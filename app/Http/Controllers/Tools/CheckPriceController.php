<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Esf\EsfController;
use App\Dao\Statistics\Communitystatus2Dao;
use App\Dao\City\CityDao;
use App\Services\Search;
use App\ListInputView;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Auth;
use App\Dao\Esf\EsfDao;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

use App\Dao\MarketExpert\MarketExpertDao;

define("CATCHTIME", 60 * 24 * 2);
define("CATCHPRE", 'checkPrice_01_');

class CheckPriceController extends Controller
{

	/**
	 * @param $currentPage
	 * @param $totalPage
	 * @param string $pageUrl
	 * @return string
	 */
	function getPageInfo($currentPage, $totalPage, $pageUrl = '/client/Register/')
	{
		$totalPage = intval($totalPage);

		if ($totalPage === 1 || $totalPage === 0) {
			return '';
		}

		$pageHtml = '<ul>';

		$firstPage = $currentPage - 4;
		$endPage = $currentPage + 4;
		if ($firstPage <= 0) {
			$firstPage = 1;
			$endPage = 9;
		}
		if ($endPage > $totalPage) {
			$endPage = $totalPage;
		}
		$pageHtml .= '<li><a href="' . $pageUrl . '1">首页</a></li>';

		if ($currentPage > 1) {
			$pre = $currentPage - 1;
			$pageHtml .= '<li><a href="' . $pageUrl . $pre . '">上一页</a></li>';
		}
		$pageHtml .= $this->getPageList($firstPage, $endPage, $currentPage, $pageUrl);

		if ($currentPage < $totalPage) {
			$next = $currentPage + 1;
			$pageHtml .= '<li><a href="' . $pageUrl . $next . '">下一页</a></li>';
			$pageHtml .= '<li><a href="' . $pageUrl . $totalPage . '">尾页</a></li>';
		}

		$pageHtml .= '</ul>';
		return $pageHtml;
	}

	/**
	 * @param $begin
	 * @param $end
	 * @param $currentPage
	 * @param $pageUrl
	 * @return string
	 */
	function getPageList($begin, $end, $currentPage, $pageUrl)
	{
		$pageList = '';
		for ($i = $begin; $i <= $end; $i++) {
			if ($currentPage == $i) {
				$pageList .= '<li class="click">' . $i . '</li>';
			} else {
				$pageList .= '<li><a href="' . $pageUrl . $i . '">' . $i . '</a></li>';
			}
		}
		return $pageList;

	}

	/**
	 * 查询价格列表
	 * @param string $hsType
	 * @param string $hsType1
	 * @param string $kw
	 * @return \Illuminate\View\View
	 */
	public function showPriceList($hsType = 'sale', $hsType1 = 'all', $kw = '')
	{
		$searchSale = new Search('hs');//查询出售的房源
		$searchRent = new Search('hr');//查询出租的房源
		$search = new Search();//查询任意楼盘信息
		$cityDao = new CityDao();//查询城市信息

		//获取城市信息
		$city = $cityDao->selectCity2(CURRENT_CITYID)?$cityDao->selectCity2(CURRENT_CITYID)[0]:'';
		if(!$city){
			return exit('未查询到当前所在城市信息!');
		}
		$cityInfo['id'] = $city->id;
		$cityInfo['name'] = $city->name;
		$cityInfo['long'] = $city->longitude;
		$cityInfo['lat'] = $city->latitude;

		//搜索房源,搜索到楼盘跳转到详情页
		$kw = Input::get('kw') ? Input::get('kw') : '';//dd($kw);
		if (!empty($kw)) {
			//$communityId=RedisCacheUtil::getOldCommunityIdByName($kw);
			$list = new ListInputView();
			$list->communityName = $kw;
			$list->cityId = CURRENT_CITYID;
			$re = $searchSale->searchCommunity($list)->hits->hits;
			foreach ($re as $k => $v) {
				if ($k == 0) {
					$communityId = $v->_source->id;
				}
			}
			if (isset($communityId)) {
				return redirect('/checkprice/' . $communityId);
			} else {
				$paterms['nodata'] = $kw;
			}
		}

		//默认页显示或者未搜素到房源显示以下内容
		//通过ES查询当前城市房源数量
		$lists = new ListInputView();
		$lists->cityId = CURRENT_CITYID;
		$saleCount = $searchSale->searchHouse($lists)->hits->total;//当前城市出售房源数量
		$rentCount = $searchRent->searchHouse($lists)->hits->total;//当前城市出租房源数量
		//通过数据库查询当前城市房源均价
		$cType1 = 3;//
		$comObj = new Communitystatus2Dao();
		$saleAvg = $comObj->getCityAveragePrice(CURRENT_CITYID, $cType1, '2');
		//$rentAvg=$comObj->getCityAveragePrice(CURRENT_CITYID,$cType1,'1');
		//获取环比,同比价格
		$lastMonthPrice_1 = $comObj->getCityAvgPriceByMonth(CURRENT_CITYID, $cType1, '2', date('Ym', strtotime('-1 month')));
		$lastMonthPrice_2 = $comObj->getCityAvgPriceByMonth(CURRENT_CITYID, $cType1, '2', date('Ym', strtotime('-2 month')));
		$lastMonthPrice_12 = $comObj->getCityAvgPriceByMonth(CURRENT_CITYID, $cType1, '2', date('Ym', strtotime('-12 month')));
		if ($lastMonthPrice_1) {
			$chainIncr = round(($lastMonthPrice_1 - $lastMonthPrice_2) / $lastMonthPrice_1, 2);
			$yearIncr = round(($lastMonthPrice_1 - $lastMonthPrice_12) / $lastMonthPrice_1, 2);
		}
		$cityHouseInfo['chainIncr'] = isset($chainIncr) ? $chainIncr * 100 : 0;
		$cityHouseInfo['yearIncr'] = isset($yearIncr) ? $yearIncr * 100 : 0;
		$cityHouseInfo['saleCount'] = $saleCount;
		$cityHouseInfo['rentCount'] = $rentCount;
		$cityHouseInfo['saleAvg'] = $saleAvg;
		//$cityHouseInfo['rentAvg']=$rentAvg;
		//获取城市所有区域上月均价,地图使用,换ajax方式
		//获取热门楼盘列表
		$lists->order = 'saleCount';
		$lists->asc = 0;
		$curPage=isset($_GET['p'])?$_GET['p']:1;
		$lists->page = $curPage;
		$lists->pageset = 10;
		$communitys = $search->searchCommunity($lists);
		$communityIds = [];
		$communityList = [];
		$lists->order = 'timeUpdate';
		$lists->asc = 0;
		$lists->pageset = 3;
		if (!empty($communitys->hits) && !empty($communitys->hits->hits) && count($communitys->hits->hits) > 0) {
			foreach ($communitys->hits->hits as $k => $v) {
				//获取列表楼盘信息
				$comInfo = $v->_source;
				//$comInfo->id=5045;//测试楼盘ID,测完删掉此行
				$communityList[$k]['id'] = $comInfo->id;
				$communityList[$k]['name'] = $comInfo->name;
				$communityList[$k]['cityAreaName'] = $cityDao->getCityAreaById($comInfo->cityAreaId) ? $cityDao->getCityAreaById($comInfo->cityAreaId)[0]->name : '';
				$communityList[$k]['businessAreaName'] = $cityDao->getBusinessareaAreaById($comInfo->businessAreaId) ? $cityDao->getBusinessareaAreaById($comInfo->businessAreaId)[0]->name : '';
				$communityList[$k]['address'] = $comInfo->address;
				$communityIds[] = $comInfo->id;//获取楼盘ID,给ajax获取楼盘历史价格使用
				//获取列表楼盘历史价格信息,换ajax方式
				//获取列表楼盘下推荐房源信息
				$lists->communityId = $comInfo->id;
				$houses = $searchSale->searchHouse($lists);
				$houseList = [];
				if (count($houses->hits->hits) > 0) {
					foreach ($houses->hits->hits as $kk => $vv) {
						$houseInfo = $vv->_source;
						$houseList[$kk]['id'] = $houseInfo->id;
						$houseList[$kk]['title'] = $houseInfo->title;
						$houseList[$kk]['thumbPic'] = $houseInfo->thumbPic;
						$roomStr = explode('_', $houseInfo->roomStr);
						$houseList[$kk]['roomStr'] = count($roomStr) > 1 ? $roomStr[0] . '室' . $roomStr[1] . '厅' : '';
						$houseList[$kk]['area'] = $houseInfo->area;
						$houseList[$kk]['price2'] = $houseInfo->price2;
						$houseList[$kk]['communityId'] = $houseInfo->communityId;
					}
				}
				$communityList[$k]['houseList'] = $houseList;
			}
			//$communityIds = join(',', $communityIds);
		}
		$communityIds = join(',', $communityIds);
		$paterms['cityInfo'] = $cityInfo;
		$paterms['cityHouseInfo'] = $cityHouseInfo;
		$paterms['communityList'] = $communityList;
		$paterms['communityIds'] = $communityIds;
		$paterms['curPage'] = $curPage;
		return view('tools/communityPriceList', $paterms);

	}

	public function ajaxCityPrice()
	{
		//通过数据库查询当前城市房源均价
		$cType1 = 3;//
		$comObj = new Communitystatus2Dao();
		$saleAvg = $comObj->getCityAveragePrice1(CURRENT_CITYID, $cType1, '2');
		return response()->json($saleAvg);
	}

	public function ajaxAreaPrice()
	{
		$comObj = new Communitystatus2Dao();
		$cType1 = 3;//
		//获取城市上月所有区域均价,地图使用
		$areaAveragePrice = $comObj->getAreaAveragePrice2(CURRENT_CITYID, $cType1, 2);
		//return response()->json(['price'=>$areaAveragePrice]);
		return response()->json($areaAveragePrice);
	}

	public function ajaxComPrice()
	{
		$communityIds = Input::get('communityIds');
		$communityIds = explode(',', $communityIds);
		$Communitystatus2Dao = new Communitystatus2Dao();
		foreach ($communityIds as $k => $id) {
			//获取列表楼盘历史价格信息
			$cType1 = 3;
			$type = 2;
			$room = 0;
			$changeTime = date('Ym', strtotime('-12 month'));
			$hisPrice = $Communitystatus2Dao->getComHistoricalPrices($id, $cType1, $type, $room, $changeTime);
			$communityList[$k] = $hisPrice;
		}
		return response()->json($communityList);
	}


	/**
	 * 查房价详情页
	 * @param $communityId
	 * @param int $type
	 * @return \Illuminate\View\View
	 */
	public function showCheckPrice($communityId, $type = 2)
	{
		$strType1 = 'all';
		$searchSale = new Search('hs');
		$searchRent = new Search('hr');
		$Search = new Search();
		$cityDao = new CityDao();
		$result = $searchSale->getCommunityByCid($communityId);//dd($result);
		$communityName = '';
		$comAddress = '';
		$paterms = array();

		//查询周边楼盘信息
		if ($result->found) {
			//周边楼盘信息
			//二手楼盘
			$paterms['oldCommunity'] = $this->aroundCommunity($result->_source, 'sale', 0, 5);
			//租房楼盘
			$paterms['rentCommunity'] = $this->aroundCommunity($result->_source, 'rent', 0, 5);

			$EsfDao = new EsfDao;

			foreach ($paterms['oldCommunity'] as $k => $v) {
				// 查询当前楼盘的主物业类型
				$commuType1 = explode('|', $EsfDao->getCommunityType($v['id']));
				if (in_array(3, $commuType1)) {
					$paterms['oldCommunity'][$k]['type'] = 301;
				} else if (in_array(2, $commuType1)) {
					$paterms['oldCommunity'][$k]['type'] = 201;
				} else if (in_array(1, $commuType1)) {
					$paterms['oldCommunity'][$k]['type'] = 101;
				}

			}
			foreach ($paterms['rentCommunity'] as $k => $v) {
				// 查询当前楼盘的主物业类型
				$commuType1 = explode('|', $EsfDao->getCommunityType($v['id']));
				if (in_array(3, $commuType1)) {
					$paterms['rentCommunity'][$k]['type'] = 301;
				} else if (in_array(2, $commuType1)) {
					$paterms['rentCommunity'][$k]['type'] = 201;
				} else if (in_array(1, $commuType1)) {
					$paterms['rentCommunity'][$k]['type'] = 101;
				}
			}
			$urlTag = 'esf';
			if (!empty($result->_source->type1)) {
				$houseType1 = explode('|', $result->_source->type1);
				if (in_array('3', $houseType1)) {
					$urlTag = 'esf';
				} elseif (in_array('2', $houseType1)) {
					$urlTag = 'xzl';
				} elseif (in_array('1', $houseType1)) {
					$urlTag = 'sp';
				}
			}
			$paterms['houseUrlHost'] = $urlTag;
			$paterms['businessAreaId'] = $result->_source->businessAreaId;
			$paterms['cityId'] = $result->_source->cityId;
			//	$paterms['houseType1']=$result->_source->cityId;
			$communityName = $result->_source->name;
			$comAddress = $result->_source->address;
			if (in_array($result->_source->type1, ['1', '1|2', '2'])) {
				$strType1 = 'busness';
			}
			if (mb_strlen($comAddress, 'utf-8') > 14) {
				$comAddress = mb_substr($comAddress, 0, 14, 'utf-8');
			}
		}

		$paterms['comid'] = $communityId;
		$paterms['type'] = $type;
		$paterms['type1'] = $strType1;
		$paterms['communityName'] = $communityName;
		$paterms['address'] = $comAddress;

		//查询推荐置业专家信息
		$marketExpertDao = new MarketExpertDao();
		$realEstateInfo = $marketExpertDao->getMarketExpert($communityId);
		$realEstate = [];
		if (!empty($realEstateInfo)) {
			foreach ($realEstateInfo as $vv) {
				//查询房源信息
				if ($vv->saleRentType == 'rent') {
					$houseInfo = $searchRent->searchHouseById($vv->hId);
				} else {
					$houseInfo = $searchSale->searchHouseById($vv->hId);
				}

				if (!empty($houseInfo->found)) {
					$vv->houseInfo = $houseInfo->_source;
				} else {
					unset($houseInfo);
					$houseInfo = $marketExpertDao->searchHouseById($vv->hId, $vv->saleRentType);
					if (!empty($houseInfo)) {
						$vv->houseInfo = $houseInfo;
					} else {
						$vv->houseInfo = array();
					}
				}

				//查询房源所属经纪人信息
				$brokerInfo = $Search->searchBrokerById($vv->uId);//dd($brokerInfo);
				if ($brokerInfo->found) {
					$vv->brokerInfo = $brokerInfo->_source;
				} else {
					unset($brokerInfo);
					$brokerInfo = $marketExpertDao->getbrokerInfo($vv->uId);
					if (!empty($brokerInfo)) {
						$vv->brokerInfo = $brokerInfo;
					} else {
						$vv->brokerInfo = array();
					}
				}

			}
			foreach($realEstateInfo as $vvv){
				$realEstate[$vvv->position]=$vvv;
			}
		}
		$lisAttr = new ListInputView();
		$lisAttr->cityId = CURRENT_CITYID;
		$lisAttr->communityId = $communityId;
		$sortstr = 'timestampCreate';
		$lisAttr->order = $sortstr;
		$lisAttr->asc = 0;
		$lisAttr->page = 1;
		$lisAttr->pageset = 2;
		$countInfo=count($realEstate);
		$houseIds=[];
		$userIds=[];
		foreach($realEstate as $v){
			$houseIds[]=$v->hId;
			$userIds[]=$v->uId;
		}
                if($type==1 || $type==2){
                    $indexSearch=$searchRent;
                    $rentSale='rent';
                }else{
                    $indexSearch=$searchSale;
                    $rentSale='sale';
                }
		if ($countInfo < 2) {
                    $groupInfo = $indexSearch->searchHouse4Group($lisAttr, 'uid');
                    $houseInfo = [];
                    if (!empty($groupInfo->aggregations->group->buckets)) {
                        foreach($groupInfo->aggregations->group->buckets as $k => $id){
                                $lisAttr->uid = $id->key;
                                $searchInfo_t=$indexSearch->searchHouse($lisAttr)->hits->hits;
                                if(!empty($searchInfo_t)){
                                    $houseInfo[$id->key]=$searchInfo_t;
                                }
                        }
                    }
                    if(!empty($houseInfo)){
                        $sortarr=[];
                        foreach($houseInfo as $k1 => $v1){
                                $sortarr[$k1]=$v1[0]->_source->$sortstr;
                        }
                        arsort($sortarr);
                        $resultInfo=[];
                        foreach($sortarr as $k => $val){
                            $resultInfo[]=$houseInfo[$k];
                            if(count($resultInfo) >= 2){
                                    break;
                            }
                        }
                        $this->realEstate($resultInfo,$realEstate,$houseIds,$userIds,$rentSale);
                    }
		}
		$rentHouseInfo = [];
		//朝向
		$paterms['faces'] = \Config::get('conditionConfig.toward.text');//朝向;
		$paterms['realEstate'] = $realEstate;

		//查询显示主楼盘房源信息
		$communityInfo = $Search->getCommunityByCid($communityId)->_source;
		$communityInfo->businessAreaName = $cityDao->findBusiness($communityInfo->businessAreaId) ? $cityDao->findBusiness($communityInfo->businessAreaId)->name : '';
		$communityInfo->cityAreaName = $cityDao->findCityArea($communityInfo->cityAreaId) ? $cityDao->findCityArea($communityInfo->cityAreaId)->name : '';
		//判断是否已关注房源
		$gz = array();
		if(Auth::check()){
			$gz['uId'] = Auth::user()->id;         // 获取用户id
			$gz['interestId'] = $communityId;     // 获取楼盘或房源Id
			$gz['tableType'] = 3;  // 对应关联表类型 1 优质房源出租表 2 优质房源出售表 3 楼盘表
			$gz['type1'] = 3;   // 物业类型 1 商铺 2 写字楼 3 住宅
			$gz['isNew'] = 0;   // 是否是新盘 1新盘 0 二手盘
			$follow = new \App\Dao\User\FollowDao; // 载入关注类
			$info = $follow->check_Follow($gz);
			if (empty($info)) {
				$communityInfo->interested=false;
			}else{
				$communityInfo->interested=true;
			}
		}else{
			$communityInfo->interested=false;
		}
		$paterms['communityInfo'] = $communityInfo;

		//查询尾部楼盘房源推荐
		$lists = new ListInputView();
		$lists->communityId = $communityId;
		$lists->order = 'timeUpdate';
		$lists->asc = false;
		$lists->pageset = 5;
		//$lists->page=3;
		$recommendSale = $searchSale->searchHouse($lists)->hits->hits;
		$recommendRent = $searchRent->searchHouse($lists)->hits->hits;
		$recommend = [];
		foreach ($recommendSale as $v) {
			$recommend['sale'][] = $v->_source;
		}
		foreach ($recommendRent as $v) {
			$recommend['rent'][] = $v->_source;
		}
		$paterms['recommend'] = $recommend;

//        dd($paterms);
		return view('tools/communityPrice', $paterms);
	}


	/**
	 * 计算某个经纬度的周围某段距离的正方形的四个点
	 * @param $comObj
	 * @param float $distance
	 * @return array
	 */
	function returnSquarePoint($comObj, $distance = 0.5)
	{
		$lng = $comObj->longitude;
		$lat = $comObj->latitude;
		$radius = 6371;
		$dlng = 2 * asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
		$dlng = rad2deg($dlng);

		$dlat = $distance / $radius;
		$dlat = rad2deg($dlat);
		return array('swlng' => $lng - $dlng, 'swlat' => $lat - $dlat, 'nelng' => $lng + $dlng, 'nelat' => $lat + $dlat);
	}


	/**
	 * 周边楼盘
	 * @param $comObj 搜索接口得到的楼盘
	 * @param string $type
	 * @param int $isNew 是否新楼盘
	 * @param float $distance
	 * @return array
	 */
	function aroundCommunity($comObj, $type = 'sale', $isNew = 0, $distance = 0.5)
	{
		$searchSale = new Search('hs');
		$srType = 'r2';

		if ($type == 'rent') {
			$srType = 'r1';
			$isNew = 0;
			$searchSale = new Search('hr');
		}
		$Points = $this->returnSquarePoint($comObj, $distance);

		$listView = new ListInputView();
		$listView->swlng = $Points['swlng'];
		$listView->swlat = $Points['swlat'];
		$listView->nelng = $Points['nelng'];
		$listView->nelat = $Points['nelat'];
		$listView->cityId = CURRENT_CITYID;
		$listView->isNew = $isNew;
		$listView->pageset = 10;
		$comList = $searchSale->searchCommunity($listView);

		$results = array();
		foreach ($comList->hits->hits as $item) {
			$communityid = $item->_source->id;
			$communityName = $item->_source->name;
			$avgPrice = 0;
			$increase = 0;
			$type2 = explode('|', $item->_source->type2)[0];

			$maxKey = '0';
			if (isset($item->_source->oldCommunityPriceMap)) {

				if (isset($item->_source->oldCommunityPriceMap->$srType)) {
					foreach ($item->_source->oldCommunityPriceMap->$srType as $key => $val) {

						$key = str_replace('t', '', $key);
						if (intval($maxKey) < intval($key)) {
							$maxKey = $key;
						}
					}
				}
				if (intval($maxKey) > 0) {
					$maxKey = 't' . $maxKey;
					$avgPrice = $item->_source->oldCommunityPriceMap->$srType->$maxKey->avgPrice;
					$increase = $item->_source->oldCommunityPriceMap->$srType->$maxKey->increase;
				}
			}
			$results[] = ['id' => $communityid, 'type' => $type2, 'name' => $communityName, 'price' => round($avgPrice), 'increase' => $increase];
		}
		//dd($results);
		return $results;
	}


	/**
	 * 共查房价详情页的置业专家模块用
	 * @param $hits
	 * @param $realEstate
	 * @param $houseIds
	 * @param $userIds
	 * @param string $type
	 */
	private function realEstate($hits, &$realEstate, $houseIds, $userIds,$rentSale)
	{
		$marketExpertDao = new MarketExpertDao();
		$Search = new Search();
		$cityDao= new CityDao();
		foreach ($hits as $kk => $vv) {
			foreach($vv as $vvv){
				if (!empty($vvv->_source)) {
					if(!empty($realEstate)){
						$subs=  array_keys($realEstate);
						$sub=max($subs)+1;
					}else{
						$sub=1;
					}

					if(in_array($vvv->_source->id,$houseIds)){
						continue;
					}else{
						$houseIds[]=$vvv->_source->id;
					}

					if(in_array($vvv->_source->uid,$userIds)){
						continue;
					}else{
						$userIds[]=$vvv->_source->uid;
					}

					$realEstate[$sub]= new \stdClass();
					$realEstate[$sub]->position=$sub;
					$realEstate[$sub]->houseInfo=$vvv->_source;
					$realEstate[$sub]->saleRentType=$rentSale;

					//经纪人信息
					$brokerInfo = $Search->searchBrokerById($vvv->_source->uid);
					if ($brokerInfo->found) {
						$realEstate[$sub]->brokerInfo=$brokerInfo->_source;

						$realEstate[$sub]->uId=$brokerInfo->_source->id;

						//查询商圈名称
						$managebusinessAreaIds=explode('|',$brokerInfo->_source->managebusinessAreaIds);
						if($managebusinessAreaIds){
							$businessArea='';
							foreach ($managebusinessAreaIds as $v){
								if($v){
									if(count($cityDao->getBusinessArea($v)>1)){
										$businessArea.='▪'.$cityDao->getBusinessArea($v)[0]->name;
									}
								}
							}
							$brokerInfo->_source->businessArea=$businessArea?mb_substr($businessArea,1):'多个商圈';
						}
					} else {
						unset($brokerInfo);
						$brokerInfo = $marketExpertDao->getbrokerInfo($vvv->_source->uid);
						if (!empty($brokerInfo)) {
							$realEstate[$sub]->brokerInfo = $brokerInfo;
						} else {
							$realEstate[$sub]->brokerInfo = array();
						}
					}
				}
				if(count($realEstate) >= 2 ){
					return;
				}
			}
		}
	}

	/**
	 * //查房价
	 * @return mixed
	 */
	public function searchPrice()
	{
		$communityId = Input::get('community');
		$type2 = Input::get('type2');
		$avprice = $this->getAvgPrice($communityId, $type2, '2');
		return response()->json(['price' => round($avprice)]);

	}

	/**
	 * 取城市各物业类型的均价,取最近一月的
	 * @param $cityid
	 * @param $type1
	 * @param $type
	 * @return int
	 */
	function getCityAvgPrice($cityid, $type1, $type)
	{
		$comObj = new Communitystatus2Dao();
		$averageObj = $comObj->getCityLastAveragePrice($cityid, $type1, $type);
		$averagePrice = 0;
		//dd($averageObj[0]);
		if (count($averageObj) > 0) {
			$averagePrice = $averageObj[0]->avgPrice;
		}
		return $averagePrice;
	}

	/**
	 * 取楼盘各物业类型的均价
	 * @param $communityId
	 * @param $type2
	 * @param $type
	 * @return int
	 */
	function getAvgPrice($communityId, $type2, $type)
	{
		$comObj = new Communitystatus2Dao();
		$averageObj = $comObj->getLastAveragePrice($communityId, $type2, $type);
		$averagePrice = 0;
		if (count($averageObj) > 0) {
			$averagePrice = $averageObj[0]->avgPrice;
		}
		return $averagePrice;
	}

	/**
	 * 取楼盘各物业类型的均价
	 * @param $communityid
	 * @param $type2
	 * @param $housetype
	 * @return mixed
	 */
	function getHouseCount($communityid, $type2, $housetype)
	{
		$searchSale = new Search($housetype);//hs出售，hr出租
		$lisAttr = new ListInputView();
		$lisAttr->type2 = $type2;
		$lisAttr->communityId = $communityid;
		$lisAttr->pageset = '10';

		return $searchSale->searchHouse($lisAttr)->hits->total;
	}

	/**
	 * @param $cityid
	 * @param $type1
	 * @param $housetype
	 * @return mixed
	 */
	function getCityHouseCount($cityid, $type1, $housetype)
	{
		$searchSale = new Search($housetype);//hs出售，hr出租
		$lisAttr = new ListInputView();
		$lisAttr->type1 = $type1;
		$lisAttr->cityId = $cityid;
		$lisAttr->pageset = '10';

		return $searchSale->searchHouse($lisAttr)->hits->total;
	}


	/**
	 * Ajax获取出售楼盘价格走势
	 * @return mixed
	 */
	public function ajaxSalePrice()
	{
		$communityId = Input::get('comid', '1');//楼盘id
		$type = Input::get('type', '2');//1:出租 2：出售
		$cType2 = Input::get('ctype2', '301');//
		$busnessId = Input::get('busness', '107');//商圈ID
		$dataType = Input::get('datatype', 'community_type');//community_type,busness_type,默认楼盘均价
		$cityid = Input::get('city', CURRENT_CITYID);
		$room = Input::get('room', '2');//居室,默认2居室
		$beNewCommunity = Input::get('benew', '0');//是否是新房,默认二手房
		$changeTime = date('Ym', strtotime('-12 month'));
		$returnDatas = array('time' => [], 'price' => []);
		$title = '';
		$priceTag = '';
		//end


		$roomTitle=['均价'=>'0','一居'=>'1','二居'=>'2','三居'=>'3','四居'=>'4','五居'=>'5','六居'=>'6','七居'=>'7','八居'=>'8'];

		$dataRoomArr=['0'=>'均价','1'=>'一居','2'=>'二居','3'=>'三居','4'=>'四居','5'=>'五居','6'=>'六居','7'=>'七居','8'=>'八居'];
		if ($cType2=='301'&&$dataType!='community_type'&&$dataType!='busness_type') {
			return response()->json(['title' => $title, 'time'=>$returnDatas['time'],'price'=>$returnDatas['price']]);
		}
		$currentRommTag=$dataRoomArr[$room];
		$roomTags=array();
		$returnPriceData=array();
		$roomFlag='-1';
		if(intval($room)===0)
		{
			$roomFlag='0';
		}
		if ($cType2 == '301' && $dataType != 'community_type' && $dataType != 'busness_type') {
			return response()->json(['title' => $title, 'time' => $returnDatas['time'], 'price' => $returnDatas['price']]);
		}

		//生成图表链接
		//商圈均价数据
		if ($dataType == 'busness_type') {
			$busnessData = RedisCacheUtil::getBussinessDataById($busnessId);
			if (count($busnessData) > 0) {
				$cityAreaId = $busnessData[0]['cityAreaId'];
				$priceTag = '-aa' . $cityAreaId . '-ab' . $busnessId;
			}
		} else {
			$priceTag = '-ba' . $communityId;
		}
		$roomTitle = ['均价' => '0', '一居' => '1', '二居' => '2', '三居' => '3', '四居' => '4', '五居' => '5', '六居' => '6', '七居' => '7', '八居' => '8'];
		$dataRoomArr = ['0' => '均价', '1' => '一居', '2' => '二居', '3' => '三居', '4' => '四居', '5' => '五居', '6' => '六居', '7' => '七居', '8' => '八居'];
		$currentRommTag = $dataRoomArr[$room];
		$roomTags = array();
		$returnPriceData = array();

		//判断数据是否在缓存中存在
		$catchKey = CATCHPRE . '_042301_sf_' . $room . '_' . $communityId . '_' . $type . '_' . $beNewCommunity . '_' . $cType2 . '_' . $busnessId . '_' . $dataType . '_' . $cityid . '_' . $changeTime . '_communityPrice';
		if (Cache::has($catchKey)) {
			$title = Cache::get($catchKey)[0];//dd($title);
			$returnDatas = Cache::get($catchKey)[1];
			$returnPriceData = Cache::get($catchKey)[2];
			$roomTags = Cache::get($catchKey)[3];
		} else {
			$comObj = new Communitystatus2Dao();
			$esfConObj = new EsfController();
			$houseData = '';
			//获取价格数据
			if ($dataType == 'community_type')//楼盘价格走势
			{
				if (intval($cType2) < 300) {
					$houseData = $comObj->getComPriceAllRoom($communityId, $cType2, $type, $changeTime, '0', $beNewCommunity);
					$room = '0';
				} else {
					$houseData = $comObj->getComPriceAllRoom($communityId, $cType2, $type, $changeTime, $roomFlag, $beNewCommunity);
				}
			} elseif ($dataType == 'busness_type')//商圈价格趋势
			{
				if (intval($cType2) < 300) {
					$room = '0';
					$houseData = $comObj->getBsnPriceAllRoom($busnessId, $cType2, $type, $changeTime, '0', $beNewCommunity);
				} else {
					$houseData = $comObj->getBsnPriceAllRoom($busnessId, $cType2, $type, $changeTime, $roomFlag, $beNewCommunity);

				}
			}
			$returnDatas = $esfConObj->perfectData($houseData);
			//拼接图表标题
			foreach ($returnDatas['price'] as $i => $item) {
				if ($roomTitle[$item['name']] == $room) {
					$returnPriceData[] = $item;
				}
				$danwei = intval($cType2) > 300 ? '元/月' : '元/天/平米';
				if ($item['name'] == '均价') {
					if ($type == '2') {
						$title .= '<p class="w1"><span class="p p1">均价(㎡)</span>';
						$title .= '<span class="p"><span class="font_size">' . $item['data'][count($item['data']) - 1] . '</span>元</span></p>';
					} else {

						$title .= '<p class="w1"><span class="p p1">均价</span>';
						$title .= '<span class="p"><span class="font_size">' . $item['data'][count($item['data']) - 1] . '</span>' . $danwei . '</span></p>';
					}
				} else {
					$roomTags[] = $item['name'];
					$dataRoom = intval($roomTitle[$item['name']]);
					if ($dataRoom > 5) {
						$dataRoom = 6;
					}

					$tag = ($i % 3) + 1;
					if ($type == '2') {

						$title .= '<p class="w' . $tag . '"><a target="_blank" href="/esfsale/area/aq' . $dataRoom . $priceTag . '"><span class="p p1">' . $item['name'] . '均价(㎡)</span>';
						$title .= '<span class="p"><span class="font_size">' . $item['data'][count($item['data']) - 1] . '</span>元</span></a></p>';
					} else {

						$title .= '<p class="w' . $tag . '"><a target="_blank" href="/esfrent/area/aq' . $dataRoom . $priceTag . '"><span class="p p1">' . $item['name'] . '均价</span>';
						$title .= '<span class="p"><span class="font_size">' . $item['data'][count($item['data']) - 1] . '</span>' . $danwei . '</span></a></p>';
					}
				}
			}

			if (count($returnPriceData) == 0) {
				if (count($returnDatas['price']) > 0) {
					$returnPriceData[] = $returnDatas['price'][0];
				} else {
					$returnPriceData[] = ['name' => $dataRoomArr[$room], 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]];
				}
			}
			//将数据库数据存入缓存
			Cache::put($catchKey, [$title, $returnDatas, $returnPriceData, $roomTags], CATCHTIME);
		}

		return response()->json(['curtRoom' => $currentRommTag, 'roomTags' => $roomTags, 'title' => $title, 'time' => $returnDatas['time'], 'price' => $returnPriceData]);
	}

	//Ajax获取出租楼盘价格走势
	// public function  ajaxRentPrice()
	// {
	// 	$communityId=Input::get('comid','1');
	// 	$type=Input::get('type','2');//1:出售 2：出租
	// 	$cType2=Input::get('ctype2','301');
	// 	$busnessId=Input::get('busness','107');
	// 	$dataType=Input::get('datatype','community_type');//community_type,busness_type
	// 	$cityid=Input::get('city','1');
	// 	$changeTime=date('Ym',strtotime('-12 month'));
	// 	$comObj=new Communitystatus2Dao();
	// 	$returnDatas=array('time'=>[],'price'=>[]);
	// 	$title='';
	// 	$esfConObj=new EsfController();
	// 	//普通住宅 出租价格
	// 	if ($cType2==='301') {
	// 		$houseData='';
	// 		if ($dataType=='community_type')//楼盘价格走势
	// 		{
	// 			$title='<strong class="color2d">本楼盘出租指导价：</strong>';
	// 			$houseData=$comObj->getComPriceAllRoom($communityId,$cType2,$type,$changeTime);
	// 		}elseif ($dataType=='busness_type')//商圈价格趋势
	// 		{
	// 			$title='<strong class="color2d">本商圈出租指导价：</strong>';
	// 			$houseData=$comObj->getBsnPriceAllRoom($busnessId,$cType2,$type,$changeTime);
	// 		}else
	// 		{
	// 			return response()->json(['title' => $title, 'time'=>$returnDatas['time'],'price'=>$returnDatas['price']]);
	// 		}


	// 		$returnDatas=$esfConObj->perfectData($houseData);

	// 		foreach ($returnDatas['price'] as $item) {
	// 			$title.='<span>'.$item['name'].'：</span>';
	// 			$title.='<strong class="colorfe">'.$item['data'][count($item['data'])-1].'</strong>元，';
	// 		}
	// 	}else
	// 	{
	// 		$cityObj=new CityDao();
	// 		//楼盘价格
	// 		$communityPrice=$comObj->getHistoricalPrices($communityId,$cType2,$type,0,$changeTime);
	// 		$formateCommunityPrice=$this->formatePriceData($communityPrice);
	// 		$returnDatas['time']=array_keys($formateCommunityPrice);

	// 		$returnDatas['price'][]=['name'=>'楼盘','data'=>array_values($formateCommunityPrice)];
	// 		//商圈价格走势
	// 		$bsnPrice=$comObj->getBusnessHistoricalPrices($cType2,$type,$busnessId,$changeTime);
	// 		$formateBsnPrice=$this->formatePriceData($bsnPrice);

	// 		$busnessName=$cityObj->findBusiness($busnessId)->name;
	// 		$returnDatas['price'][]=['name'=>$busnessName,'data'=>array_values($formateBsnPrice)];
	// 		//城市价格走势
	// 		$cityPrice=$comObj->getCityHistoricalPrices($cityid,$type,$cType2,$changeTime);
	// 		$formateCityPrice=$this->formatePriceData($cityPrice);
	// 		$cityName=$cityObj->findCity($cityid)->name;
	// 		$returnDatas['price'][]=['name'=>$cityName,'data'=>array_values($formateCityPrice)];


	// 	}
	// 	return response()->json(['title' => $title, 'time'=>$returnDatas['time'],'price'=>$returnDatas['price']]);

	// }

	/**
	 * @param $priceData
	 * @return array
	 */
	function formatePriceData($priceData)
	{
		$esfObj = new EsfController();
		$results = array('time' => [], 'price' => []);
		foreach ($priceData as $item) {
			$results['time'][] = $item->changeTime;
			$results['price'][] = $item->avgPrice;
		}

		return $esfObj->fullComplement($results['time'], $results['price']);
	}

	/**
	 * 将数据分组并补充完成
	 * @param $dt
	 * @param $tag
	 * @return array
	 */
	public function perfectPriceData($dt, $tag)
	{
		$rentPrice=$this->formateRentPrict($dt);
		$roomTitle=[1=>'一居',2=>'二居',3=>'三居',4=>'四居',5=>'五居',6=>'六居',7=>'七居',8=>'八居'];
		$returnPrice=array();

		$ftime='';
		foreach ($rentPrice as $room => $item) {
			$fmateData = $this->fullComplement($item['time'], $item['price']);
			$fPrice = array_values($fmateData);
			if (empty($ftime)) {
				$ftime = array_keys($fmateData);
			}
			if (!isset($roomTitle[$room])) {
				continue;
			}

			array_push($returnPrice, ['name' => $roomTitle[$room], 'data' => $fPrice]);
		}
		return ['time' => $ftime, 'price' => $returnPrice];
	}

}

?>