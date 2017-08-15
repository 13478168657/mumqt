<?php 

namespace App\Http\Controllers\Esf;

use Auth;
use DB;
use Cookie;


use App\CommunityStatusTo;
use App\BusinessareastatusTo;
use App\CityareastatusTo;
use App\CitystatusTo;
use Redirect;
use App\Dao\Agent\HouseDao;
use App\Services\Search;
use App\Dao\Esf\EsfDao;
use App\Dao\Statistics\Communitystatus2Dao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use App\CommunityDataStructure;
use App\Http\Controllers\Utils\SafeUtil;
use App\Http\Controllers\Utils\CookieUtil;
use App\ListInputView;
use App\Http\Controllers\Utils\RedisCacheUtil;

use App\Dao\MarketExpert\MarketExpertDao;
use App\Http\Controllers\Lists\PublicController;

define("CATCHPREESF", 'esfPrice'); 
if(!defined('CACHE_TIME'))          define('CACHE_TIME',60*24*30);  // 60分 x 24时 x 30天
class EsfController extends Controller {
	protected $EsfDao;
	public function __construct() {
		$this->EsfDao  = new EsfDao;
		if(in_array( explode('/', $GLOBALS['current_listurl'] )[1], array('esfindex', 'esfbd', 'esfbp'))){
			$current_url = explode('/', $GLOBALS['current_listurl']);
			if(!empty($current_url[3])){
				$type = substr($current_url[3], 0, 1);
				if($type == 1){
					$type = 'sprent';
				}else if($type == 2){
					$type = 'xzlrent';
				}else{
					$type = 'esfsale';
				}
				$GLOBALS['current_listurl'] = config('session.domain').'/'.$type.'/area';
			}
		}

	}
	
	/**
	| 二手房首页
	*/
	public function esfindex($id = 0, $type2 = '') {
            if(USER_AGENT_MOBILE)return $this->esf($id,$type2);
		$home = true;
		$communityId = $id;
		if(empty($communityId)) return Redirect::to('/esfsale'); // 如果楼盘Id 为空就中转到列表页面
		//$type2 = Input::get('type2');
                /** 增加 start (zhuwei) **/
		$type2 = $type2;
                
        if($type2 == ''){
            // 查询当前楼盘的主物业类型                    
            $commuType1 = explode('|',$this->EsfDao->getCommunityType($communityId));
            if(in_array(3,$commuType1)){
                $type2 = 301;
            }else if(in_array(2,$commuType1)){
                $type2 = 201;
            }else if(in_array(1,$commuType1)){
                $type2 = 101; 
            }
        }
        $t2 = substr($type2, 0, 1) ;
	  	if($t2 == 3){
			$viewShowInfo['saleUrl'] = 'esfsale'; 
			$viewShowInfo['rentUrl'] = 'esfrent';
	  	} else if($t2 == 2){
	  		$viewShowInfo['saleUrl'] = 'xzlsale'; 
	  		$viewShowInfo['rentUrl'] = 'xzlrent';
	  	} else if($t2 == 1){
	  		$viewShowInfo['saleUrl'] = 'spsale'; 
	  		$viewShowInfo['rentUrl'] = 'sprent';
	  	}
	  
  
                /** 增加 end   (zhuwei) **/
		$typexxxInfo = 'type'.$type2.'Info';            //type301Info
		$community = new CommunityDataStructure($type2); // type2Info 序列化和反序列化
		$type2CN = config('communityType2');

		$structureCN = ['1'=>'板楼', '2'=>'塔楼', '3'=>'砖楼', '4'=>'砖混', '5'=>'平房', '6'=>'钢混', '7'=>'塔板结合','8'=>'框架剪力墙', '9'=>'其他'];
                //**************************登录用户关注代码******************************//
		// 查询首页是否有用户 关注的房源或楼盘
        $interest = array();
		if(Auth::check()){
            $follow = new \App\Dao\User\FollowDao; // 载入关注类
            $where  = array('uid'=>Auth::user()->id, 'tableType'=>3, 'is_del'=>0); // 关注条件 
            $interest = $follow->get_Follow($where);
            // 整合首页关注的楼盘或房源
            foreach($interest as $ikey => $ival){
                if( ($communityId == $ival->interestId) && (substr($type2, 0, 1) == $ival->type1) ){
                    $viewShowInfo['interest'] = true;
                    break;
                }
            }
        }
        /*

         * 下面是查询楼盘的信息
         * 
         *          */
		
		// 查询楼盘详细信息(索引接口)
		$inputView = new ListInputView;
		$search = new Search();
		$inputView->isNew = false;
		// 先查缓存，没有就走ES
		if(!Cache::store('redis')->has('getCommunityByCid_'.$communityId)){
			// 用索引查询楼盘信息
			$commData = $search->getCommunityByCid($communityId);
			if(!empty($commData->found)){
				Cache::store('redis')->put('getCommunityByCid_'.$communityId,$commData,CACHE_TIME);
			}
		}else{
			$commData = Cache::store('redis')->get('getCommunityByCid_'.$communityId);
		}
		//$commData = $search->getCommunityByCid($communityId);
		
		// $commData = $this->EsfDao->getCommunity($communityId,$type2); // 获取楼盘信息
		// dd($commData);

		if(!empty($commData->found)){
			$commData = $commData->_source;

			$viewShowInfo['rentCount'] = $commData->rentCount; // 出租总数
			$viewShowInfo['saleCount'] = $commData->saleCount; // 出售总数
			$viewShowInfo['timeCreate'] = $commData->timeCreate; // 创建时间
                        
                        $jingduMap = !empty($commData->longitude) ? $commData->longitude : CURRENT_LNG ; // 楼盘经度
			$weiduMap = !empty($commData->latitude) ? $commData->latitude : CURRENT_LAT; // 楼盘纬度
                        
		}else{
			$commData = $this->EsfDao->getCommunity($communityId,$type2); // 获取楼盘信息
			if(!empty($commData[0])){
				$commData = $commData[0];
			}
		}
		// 判断如果当前这个楼盘不属于当前的城市 ，就将页面跳转到该楼盘所在的城市
//		if(!empty($commData->cityId) && $commData->cityId != CURRENT_CITYID){
//			$realCityUrl = $_SERVER['REQUEST_URI'];
//			$cityData = RedisCacheUtil::getCityDataById($commData->cityId);// 通过城市 id 获取该条数据
//			if(!empty($cityData[0])){
////				return Redirect::to('http://'.$cityData[0]['py'].'.'.config('session.domain').$realCityUrl);
//				return Redirect::to('http://'.$cityData[0]['py'].'.'.config('session.domain').'/esfsale/area/an'.$type2.'-ba'.$communityId);
//			}
//		}
		if(!empty($commData->name)){
			$commName = $commData->name;
			$viewShowInfo['commName'] = $commName;
		}else{
			$viewShowInfo['commName'] = $commName = '';
		}
		// dd($commData);
		if(!empty($commData->$typexxxInfo)){
			$type2Info =  $commData->$typexxxInfo;
		//	 dd($type2Info);
		}
		if(!empty($type2Info)){
			$type2GetInfo = $community->unserialize($type2Info); // 反序列化获取type2详细信息
			if(isset($type2GetInfo->structure)){
				if (isset($structureCN[$type2GetInfo->structure])) {
					$structure = $structureCN[$type2GetInfo->structure];
					$viewShowInfo['structure'] = $structure;
				}
				
			}
		}
		// 查询所有项目特色
		if(!empty($type2GetInfo->tagIds)){
			$tagIds = explode('|', $type2GetInfo->tagIds);
			$tags = $this->EsfDao->getTagName($tagIds);
			if(!empty($tags)){
				foreach ($tags as $k => $v) {
					if($k >= 3) break;
					$tagsName[] = $v->name;
				}
				$tagsName = implode(', ', $tagsName);
			}else{
				$tagsName = '';
			}
			$viewShowInfo['tagsName'] = $tagsName;
		}
		$viewShowInfo['busnessId'] ='0';
		if (isset($commData->businessAreaId)) {
			$viewShowInfo['busnessId'] =$commData->businessAreaId;
		}

		if(!empty($commData->address)){
			$viewShowInfo['address'] = $commData->address;
		}

		if(!empty($commData->propertyAddress)){
			$viewShowInfo['propertyAddress'] = $commData->propertyAddress;
		}
		// 物业公司
		if(!empty($commData->propertyCompanyId)){
			$propertyCompanyId = $commData->propertyCompanyId;
			$propertyName = $this->EsfDao->getPropertyName($propertyCompanyId); // 获取物业公司
			if(!empty($propertyName)){
				$viewShowInfo['propertyName'] = $propertyName[0]->companyname;
				$viewShowInfo['propertyPhone'] = $propertyName[0]->phone;
			}
		}
		// 开发商
		if(!empty($commData->developerId)){
			$viewShowInfo['developerName'] = RedisCacheUtil::getDeveloperNameById($commData->developerId); // 获取开发商
		}
		// 查询城市区域
		if(!empty($commData->cityAreaId)){
			$viewShowInfo['cityAreaName'] = RedisCacheUtil::getCityAreaNameById($commData->cityAreaId); // 获取城区名称
		}
		// 查询商圈名称
		if(!empty($commData->businessAreaId)){
			$viewShowInfo['businessareaName'] = RedisCacheUtil::getBussinessNameById($commData->businessAreaId);// 获取商圈名称
		}
		// 车位信息
		if(!empty($type2GetInfo->parkingInfo)){
			
			// 车位信息
			$parkingInfo = explode('_', $type2GetInfo->parkingInfo);
			for($i = 0; $i <= 4; $i++){
				if($i <= 3){
					$parkingInfo[$i] = empty($parkingInfo[$i]) ? '' : $parkingInfo[$i];
					continue;
				}
				$parkingInfo[$i] = empty($parkingInfo[$i]) ? '' : $parkingInfo[$i]. '个';
			}
			$parkingIntro = '';
			$parkingIntro .= empty($parkingInfo[0]) ? '' : "规划机动车停车位：$parkingInfo[0]，";
			$parkingIntro .= empty($parkingInfo[1]) ? '' : "其中地上约：$parkingInfo[1]，";
			$parkingIntro .= empty($parkingInfo[2]) ? '' : "地下约：$parkingInfo[2]。";
			$parkingIntro .= (empty($parkingInfo[3]) && empty($parkingInfo[4])) ? '' : "住宅的机动车车位配比为 $parkingInfo[3] ：$parkingInfo[4]。";
			//$parkingIntro = "规划机动车停车位：$parkingInfo[0]，其中地上约：$parkingInfo[1]，地下约：$parkingInfo[2]。住宅的机动车车位配比为 $parkingInfo[3] ：$parkingInfo[4]。";
			$viewShowInfo['parkingIntro'] = $parkingIntro;
		}


		if(!empty($type2)){
			$type2Name = $type2CN[$type2];
			$viewShowInfo['type2Name'] = $type2Name;
		}

		// 楼盘楼栋信息
		$communitybuilding = $this->EsfDao->getCommBuild($communityId);
		// 查询户型信息
		$communityroom = $this->EsfDao->getCommRoom($communityId);
                
		foreach ($communitybuilding as $build) {
			$buildRoom = [];
			foreach ($communityroom as $room) {
				$buildId = explode('|', $room->cbIds);
				if(in_array($build->id, $buildId)){
					$buildRoom[] = $room;
				}
			}
			$build->roomInfo = $buildRoom;
		}
		// dd($communitybuilding);

		// 查询communityroom表相关信息
		$communityroom = $this->EsfDao->getCommRoom($communityId);
		$roomAllNum = '0';
		if(!empty($communityroom)){
			$roomAllNum = count($communityroom);
			$viewShowInfo['roomAllNum'] = $roomAllNum;
		}
		
		foreach ($communityroom as $room) {
			if($room->room == 2){
				$room2[] = $room->id;
			}
			if($room->room == 3){
				$room3[] = $room->id;
			}
		}
		if(!empty($room2)){
			$room2Num = count($room2);
			$roomId2 = $room2[0];
			$viewShowInfo['room2Num'] = $room2Num;
			$viewShowInfo['roomId2'] = $roomId2;
		}
		if(!empty($room3)){
			$room3Num = count($room3);
			$roomId3 = $room3[0];
			$viewShowInfo['room3Num'] = $room3Num;
			$viewShowInfo['roomId3'] = $roomId3;
		}
                //dd($room3);
		// 获取该 楼盘 租金和售价 的环比上月 和同比去年的数据
		$oldCommunityStatus = $this->getOldCommunityStatus($communityId, $type2);
		$viewShowInfo['statusSalePrice'] = $oldCommunityStatus['statusSalePrice'];
		$viewShowInfo['statusSaleIncre'] = $oldCommunityStatus['statusSaleIncre'];
		$viewShowInfo['statusRentPrice'] = $oldCommunityStatus['statusRentPrice'];
  //dd($commData);
                $t='t'.$type2;
                $sale_rent='sale_rent_sb_'.CURRENT_CITYID;
                $sb='';
                if(!empty($_SERVER['HTTP_REFERER']) ){
                    $refefer=$_SERVER['HTTP_REFERER'];
                    $script=parse_url($refefer)['path'];
                    $sb=explode('/',$script)[1];
                    if($sb == 'esfindex'){
                        //$sb='rentesb';//这是刷新的情况不是通过列表进来的可能出错，附一个默认值
                    }else{
                        CookieUtil::SaveCookie($sale_rent,$sb);
                    //Cookie::make($sale_rent,$sb,PHP_INT_MAX);//也行
                    }
                    
                }
                if(Cookie::has($sale_rent)){
                    $sb=Cookie::get($sale_rent);
                }
                if($type2==301 && $sb =='saleesb'  && !empty($commData->priceSaleAvg3)){
                    $viewShowInfo['priceSaleAvg3']=$commData->priceSaleAvg3;
                }else if($type2==301 &&  $sb =='rentesb' && !empty($commData->priceRentAvg3)){
                    $viewShowInfo['priceRentAvg3']=$commData->priceRentAvg3;
                }else if(!empty($commData->oldCommunityPriceMap->r1->$t->avgPrice)){
                    $viewShowInfo['price2'] = $commData->oldCommunityPriceMap->r1->$t->avgPrice;
                }
		$viewShowInfo['statusRentIncre'] = $oldCommunityStatus['statusRentIncre'];

		$viewShowInfo['statusSaleIncreLastYears'] = $oldCommunityStatus['statusSaleIncreLastYears'];
		$viewShowInfo['statusRentIncreLastYears'] = $oldCommunityStatus['statusRentIncreLastYears'];


		$brokers = new Search(); // 搜索经纪人
		// 查询出售房源信息(索引)
		$search = new Search('hs');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->cityId = CURRENT_CITYID;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
		$list->order = 'timeRefresh';
		$list->asc = 0;
		$houseSaleData = $search->searchHouse($list);
		if(empty($houseSaleData->error)){
			$houseSaleData = $houseSaleData->hits;
//			$saleBrokerIds = array();// 记录二手房置业专家id
//			$saleBrokers   = array();// 记录二手房置业专家信息
//			foreach($houseSaleData->hits as $key => $val){
//				$brokerInfo = $brokers->searchBrokerById($val->_source->uid); // 根据二手房置业专家id查询出经纪人信息
//				if(!empty($brokerInfo->found) && !in_array($val->_source->uid, $saleBrokerIds)){
//					$saleBrokerIds[] = $val->_source->uid;
//					$saleBrokers[] = $brokerInfo;
//				}
//				if(count($saleBrokerIds) >= 3) break;
//			}
//			$viewShowInfo['saleBrokers'] = $saleBrokers;
		}
//		 dd($viewShowInfo['saleBrokers']);


		// 查询出租房源信息(索引)
		$search = new Search('hr');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->cityId = CURRENT_CITYID;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
		$list->order = 'timeRefresh';
		$list->asc = 0;
		$houseRentData = $search->searchHouse($list);
		if(empty($houseRentData->error)){
			$houseRentData = $houseRentData->hits;
//			$rentBrokerIds = array();// 记录租房置业专家id
//			$rentBrokers   = array();// 记录租房置业专家信息
//			foreach($houseRentData->hits as $key => $val){
//				$brokerInfo = $brokers->searchBrokerById($val->_source->uid); // 根据二手房置业专家id查询出经纪人信息
//				if(!empty($brokerInfo->found) && !in_array($val->_source->uid, $rentBrokerIds)){
//					$rentBrokerIds[] = $val->_source->uid;
//					$rentBrokers[] = $brokerInfo;
//				}
//				if(count($rentBrokerIds) >= 3) break;
//			}
//			$viewShowInfo['rentBrokers'] = $rentBrokers;
		}

		// 查询communityimage表相关信息
		$communityimage = $this->EsfDao->getImg($communityId);
		// dd($viewShowInfo);

		// 判断页面是否先显示买房列表的置业专家
		$isShowSaleType = array('301', '302', '303', '306', '307');
		$isShowSale     = false;
		if(in_array($type2, $isShowSaleType)){
			$isShowSale = true;
		}
		$viewShowInfo['isShowSale'] = $isShowSale;

            /********
             * 新版添加
             * 第一块，置业专家
             * 
             * ********/
            $searchSale=new Search('hs');
            $searchRent=new Search('hr');
            $Search = new Search();
            $marketExpertDao=new MarketExpertDao();
            //$subtype='sale';
            $realEstateInfo=$marketExpertDao->getMarketExpert($communityId);

            $realEstate=[];
            if(!empty($realEstateInfo)){
                foreach($realEstateInfo as $vv){
                    /****
                    * 房源信息
                    * 
                    * ***/
                    if($vv->saleRentType=='rent'){
                        $houseInfo=$searchRent->searchHouseById($vv->hId);
                    }else{
                        $houseInfo=$searchSale->searchHouseById($vv->hId);
                    }

                    if(!empty($houseInfo->found)){
                        $vv->houseInfo=$houseInfo->_source;
                    }else{
                        unset($houseInfo);
                        $houseInfo=$marketExpertDao->searchHouseById($vv->hId,$vv->saleRentType);
                        if(!empty($houseInfo)){
                            $vv->houseInfo=$houseInfo;
                        }else{
                            $vv->houseInfo=array();
                        }
                    }
                    /****
                    * 经纪人信息
                    * 
                    * ***/
                    $brokerInfo=$Search->searchBrokerById($vv->uId);
                        if(!empty($brokerInfo->found)){
                        $vv->brokerInfo=$brokerInfo->_source;
                        
                    }else{
                        unset($brokerInfo);
                        $brokerInfo=$marketExpertDao->getbrokerInfo($vv->uId);
                        if(!empty($brokerInfo)){
                            $vv->brokerInfo=$brokerInfo;
                        }else{
                            $vv->brokerInfo=array();
                        }
                    }
                    
                }
                foreach($realEstateInfo as $vvv){
                    $realEstate[$vvv->position]=$vvv;
                }
            }
            
        $lisAttr=new ListInputView();
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
        if($t2==1 || $t2==2){
            $indexSearch=$searchRent;
            $rentSale='rent';
        }else{
            $indexSearch=$searchSale;
            $rentSale='sale';
        }
        if($countInfo < 2 ){
            $groupInfo=$indexSearch->searchHouse4Group($lisAttr, 'uid');
            $houseInfo=[];
            if(!empty($groupInfo->aggregations->group->buckets)){
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
//        foreach($sortarr as $k=> $val){
//            $sortarr[$k]=date('Y-m-d H:i:s',ceil(1470297131591/1000));
//        }
//dd($groupInfo);
            /*******
            * 朝向
            * 
            * *******/
           $marketExpert['faces']=\Config::get('conditionConfig.toward.text');//朝向;
           $marketExpert['realEstate']=!empty($realEstate)?$realEstate:array();
		//新盘推荐
		$tlists = new ListInputView();
		$tlists->isNew = 1;
		$tlists->pageset = 4;
		$tlists->cityId = CURRENT_CITYID;
		$tlists->order = 'timeUpdateLong';
		$tlists->asc = 0;
		$houset1 = substr($type2,0,1);
		$tlists->type1 = $houset1;
		$search = new Search();
		$newComm = array();
		$hotComm = $search->searchCommunity($tlists);
		if(empty($hotComm->error)&&!empty($hotComm->hits)){
			foreach($hotComm->hits->hits as $k => $v){
				$v->_source->priceAverg = 'priceSaleAvg'.$houset1;
				$v->_source->areaname = RedisCacheUtil::getCityAreaNameById($v->_source->cityAreaId);
			}
			$newComm = $hotComm->hits->hits;
		}

		//城区
		$public = new \App\Http\Controllers\Lists\PublicController();
		$cityArea = $public->getCityArea(CURRENT_CITYID);
		$businessAreaH5 = $public->getBusinessAreaH5(CURRENT_CITYID,$cityArea);//dd($marketExpert);
        /* 判断模板类型 */
        $admodels = $this->getModelType(CURRENT_CITYID);
        if(empty($admodels)){
            $admodels = new \stdClass();
            $admodels->modelId = 1;
        }
        return view('esf.esfSaleBIndex',compact('jingduMap','weiduMap','marketExpert','sale_rent','commName', 'home','communityId','type2','viewShowInfo','type2GetInfo','communityroom','commImg','houseSaleData','houseRentData', 'communityimage','newComm','cityArea','businessAreaH5','admodels'));
	}
/*****
 * 置业专家模块用
 * ******/
private function realEstate($hits,&$realEstate,$houseIds,$userIds,$rentSale){
    $Search=new Search();
	$marketExpertDao=new MarketExpertDao();
    foreach($hits as $kk => $vv){
        foreach($vv as $vvv){
            if(!empty($vvv->_source)){
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
                
                /****
                * 经纪人信息
                * ***/
                $brokerInfo=$Search->searchBrokerById($vvv->_source->uid);
                if($brokerInfo->found){
                    $realEstate[$sub]->brokerInfo=$brokerInfo->_source;

                    $realEstate[$sub]->uId=$brokerInfo->_source->id;
                }else{
                    unset($brokerInfo);
                    $brokerInfo=$marketExpertDao->getbrokerInfo($vvv->_source->uid);
                    if(!empty($brokerInfo)){
                        $realEstate[$sub]->brokerInfo=$brokerInfo;
                        $realEstate[$sub]->uId=$vvv->_source->uid;
                    }else{
                        $realEstate[$sub]->brokerInfo=array();
                    }
                }

            }
            if(count($realEstate) >= 2 ){
                return;
            }
        }
        
    }
    
}
        
        
        private function esf($id = 0, $type2 = ''){
            if(!USER_AGENT_MOBILE)Redirect::to('/esfsale');
            
            $home = true;
            $communityId = $id;
            if(empty($communityId)) return Redirect::to('/esfsale'); // 如果楼盘Id 为空就中转到列表页面
            //$type2 = Input::get('type2');
            /** 增加 start (zhuwei) **/
            $type2 = $type2;
            $structureCN = ['1'=>'板楼', '2'=>'塔楼', '3'=>'砖楼', '4'=>'砖混', '5'=>'平房', '6'=>'钢混', '7'=>'塔板结合','8'=>'框架剪力墙', '9'=>'其他'];
        if($type2 == ''){
            // 查询当前楼盘的主物业类型                    
            $commuType1 = explode('|',$this->EsfDao->getCommunityType($communityId));
            if(in_array(3,$commuType1)){
                $type2 = 301;
            }else if(in_array(2,$commuType1)){
                $type2 = 201;
            }else if(in_array(1,$commuType1)){
                $type2 = 101; 
            }
        }
        $t2 = substr($type2, 0, 1) ;
	  	if($t2 == 3){
			$viewShowInfo['saleUrl'] = 'esfsale'; 
			$viewShowInfo['rentUrl'] = 'esfrent';
	  	} else if($t2 == 2){
	  		$viewShowInfo['saleUrl'] = 'xzlsale'; 
	  		$viewShowInfo['rentUrl'] = 'xzlrent';
	  	} else if($t2 == 1){
	  		$viewShowInfo['saleUrl'] = 'spsale'; 
	  		$viewShowInfo['rentUrl'] = 'sprent';
	  	}
                
                
                /** 增加 end   (zhuwei) **/
		$typexxxInfo = 'type'.$type2.'Info';            //type301Info
		$community = new CommunityDataStructure($type2); // type2Info 序列化和反序列化
                
		// 查询楼盘详细信息(索引接口)
		$inputView = new ListInputView;
		$search = new Search();
		$inputView->isNew = false;
		$commData = $search->getCommunityByCid($communityId);
                if(!empty($commData->found)){
			$commData = $commData->_source;

			$viewShowInfo['rentCount'] = $commData->rentCount; // 出租总数
			$viewShowInfo['saleCount'] = $commData->saleCount; // 出售总数
			$viewShowInfo['timeCreate'] = $commData->timeCreate; // 创建时间
                        
                        $viewShowInfo['cityAreaId'] = $commData->cityAreaId; // 城区id
			$viewShowInfo['businessAreaId'] = $commData->businessAreaId; // 商圈Id
                        
                        $viewShowInfo['address'] = $commData->address;
                        
                        $jingduMap = !empty($commData->longitude) ? $commData->longitude : CURRENT_LNG ; // 楼盘经度
			$weiduMap = !empty($commData->latitude) ? $commData->latitude : CURRENT_LAT; // 楼盘纬度
                        
		}else{
			$commData = $this->EsfDao->getCommunity($communityId,$type2); // 获取楼盘信息
			if(!empty($commData[0])){
				$commData = $commData[0];
			}
		}
                // 判断如果当前这个楼盘不属于当前的城市 ，就将页面跳转到该楼盘所在的城市
		if(!empty($commData->cityId) && $commData->cityId != CURRENT_CITYID){
			$realCityUrl = $_SERVER['REQUEST_URI'];
			$cityData = RedisCacheUtil::getCityDataById($commData->cityId);// 通过城市 id 获取该条数据
			if(!empty($cityData[0])){
//				return Redirect::to('http://'.$cityData[0]['py'].'.'.config('session.domain').$realCityUrl);
				return Redirect::to('http://'.$cityData[0]['py'].'.'.config('session.domain').'/esfsale/area/an'.$type2.'-ba'.$communityId);
			}
		} 
                if(!empty($commData->name)){
			$commName = $commData->name;
			$viewShowInfo['commName'] = $commName;
		}else{
			$viewShowInfo['commName'] = $commName = '';
		}
                
                $page = max(Input::get('page',1),1);
                $pageset = 6;
                
                $brokers = new Search(); // 搜索经纪人
                // 查询出售房源信息(索引)
		$search = new Search('hs');
		$list = new ListInputView();
		$list->page = $page;
                
		$list->pageset = $pageset/2;
		$list->communityId = $communityId;
		$list->cityId = CURRENT_CITYID;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
		$list->order = 'timeRefresh';
		$list->asc = 0;
		$houseSaleData = $search->searchHouse($list);
		if(empty($houseSaleData->error)){
			$houseSaleData = $houseSaleData->hits;
			$saleBrokerIds = array();// 记录二手房置业专家id
			$saleBrokers   = array();// 记录二手房置业专家信息
			foreach($houseSaleData->hits as $key => $val){
				$brokerInfo = $brokers->searchBrokerById($val->_source->uid); // 根据二手房置业专家id查询出经纪人信息
				if(!empty($brokerInfo->found) && !in_array($val->_source->uid, $saleBrokerIds)){
					$saleBrokerIds[] = $val->_source->uid;
					$saleBrokers[] = $brokerInfo;
				}
				if(count($saleBrokerIds) >= 3) break;
			}
			$viewShowInfo['saleBrokers'] = $saleBrokers;
		}
//		 dd($viewShowInfo['saleBrokers']);
//		 
//		 		 
		// 查询出租房源信息(索引)
		$search = new Search('hr');
		$list = new ListInputView();
		$list->pageset = $pageset/2;
		$list->page = $page;
		$list->communityId = $communityId;
		$list->cityId = CURRENT_CITYID;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
		$list->order = 'timeRefresh';
		$list->asc = 0;
		$houseRentData = $search->searchHouse($list);
		if(empty($houseRentData->error)){
			$houseRentData = $houseRentData->hits;
			$rentBrokerIds = array();// 记录租房置业专家id
			$rentBrokers   = array();// 记录租房置业专家信息
			foreach($houseRentData->hits as $key => $val){
				$brokerInfo = $brokers->searchBrokerById($val->_source->uid); // 根据二手房置业专家id查询出经纪人信息
				if(!empty($brokerInfo->found) && !in_array($val->_source->uid, $rentBrokerIds)){
					$rentBrokerIds[] = $val->_source->uid;
					$rentBrokers[] = $brokerInfo;
				}
				if(count($rentBrokerIds) >= 3) break;
			}
			$viewShowInfo['rentBrokers'] = $rentBrokers;
		}
                //朝向
                $faces=\Config::get('conditionConfig.toward.text');
                
                //特色 房源标签
                $HouseDao = new HouseDao();
                $wheretag = array('type'=>2,'propertyType1'=>substr($type2, 0, 1));
                $featurestag  = $HouseDao->getHouseTag($wheretag);//搜索条件的特色
                
                //ajax,滑动加载列表
                if(Input::get('tag','0')=='page'){
                    
                    $house = array();
                        //增加元素
                        $tag = '';
                        if(!empty($houseSaleData->hits)){
                            if(substr($type2, 0,1) == 3){
                                $tag=['houseSale','二手房','ss'];
                            }else{
                                $tag=['houseSale','出售','ss'];
                            }
                            foreach($houseSaleData->hits as $v){
                                $v->house = $tag;
                            }
                        }
                        
                        $tag = '';
                        if(!empty($houseRentData->hits)){
                            if(substr($type2, 0,1) == 3){
                                $tag=['houseRent','租房','sr'];
                            }else{
                                $tag=['houseRent','出租','sr'];
                            }
                            foreach($houseRentData->hits as $v){
                                $v->house = $tag;
                            }
                        }
                        
                        $house = array_merge($houseSaleData->hits,$houseRentData->hits);

                        if(!shuffle($house) && !empty($houseSaleData->hits)){
                            $house = $houseSaleData->hits;
                        }else if(!shuffle($house) && !empty($houseRentData->hits)){
                            $house = $houseRentData->hits;
                        }
                        if(empty($house)){
                            $house['result']=false;
                            return response()->json($house);
                        }
                        $i=0;  
                        
                        $diyTagIdArr=array();
                        foreach($house as $vvv){
                            if(!empty($vvv->_source->diyTagId)){
                                $diyTagIdArr=array_merge($diyTagIdArr,explode('|',$vvv->_source->diyTagId));
                            }
                        }
                        
                        if(!empty(array_unique($diyTagIdArr))){
                            $diyTagIdArr=array_unique($diyTagIdArr);
                            $diyTagTemp=$HouseDao->getDiyTagByIds($diyTagIdArr);
                            foreach($diyTagTemp as $kk => $vv){  
                                $diyTagName[$vv->id]=$vv->name;
                            }
                        }
                        
                        foreach($house as $v){
                            $i++;
                            $v->img=get_img_url($v->house[0], $v->_source->thumbPic);
                            $v->commName = !empty($viewShowInfo['commName'])?$viewShowInfo['commName']:'';
                            $v->cityArea= !empty($viewShowInfo['cityAreaId'])?\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($viewShowInfo['cityAreaId']):'';
                            $v->businessArea= !empty($viewShowInfo['businessAreaId'])?\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($viewShowInfo['businessAreaId']):'';
                            
                            
                            $price = 'price1';
                            if($v->house[1] == '二手房' || $v->house[1] == '出售' ){
                                $price = 'price2';
                            }
                            $v->price = !empty($v->_source->$price)?$v->_source->$price:'面议';
                            
                            $v->featurestag=array();
                            if(!empty($v->_source->tagId)){
                                foreach(explode('|',$v->_source->tagId) as $k=>$tagid){
                                    if(array_key_exists($tagid,$featurestag)){
                                        if(!empty($featurestag[$tagid])){
                                            $v->featurestag[]=$featurestag[$tagid];
                                        }
                                    }
                                }
                            }
                            if(!empty($v->_source->diyTagId)){
                                if(!empty($diyTagId= explode('|',$v->_source->diyTagId))){
                                    foreach($diyTagId as $k4=>$v4){
                                        if(!empty($diyTagName[$v4])){
                                            $v->featurestag[]=$diyTagName[$v4];
                                        }
                                        
                                    }
                                }
                            }
                            
                        }
                        $house['result']=true;
                        $house['count']=$i;
                        $house['faces']=$faces;
                        //$house['featurestag']=$featurestag;
                        return response()->json($house);
                    
                    
                }
               /***************************登录用户关注代码******************************
                
                		 
		// 查询首页是否有用户 关注的房源或楼盘
                $interest = array();
		if(Auth::check()){
                    $follow = new \App\Dao\User\FollowDao; // 载入关注类
                    $where  = array('uid'=>Auth::user()->id, 'tableType'=>3, 'is_del'=>0); // 关注条件 
                    $interest = $follow->get_Follow($where);
                    // 整合首页关注的楼盘或房源
                    foreach($interest as $ikey => $ival){
                        if( ($communityId == $ival->interestId) && (substr($type2, 0, 1) == $ival->type1) ){
                            $viewShowInfo['interest'] = true;
                            break;
                        }
                    }
                }
                */
		// dd($commData);
		if(!empty($commData->$typexxxInfo)){
			$type2Info =  $commData->$typexxxInfo;
		//	 dd($type2Info);
		}
		if(!empty($type2Info)){
			$type2GetInfo = $community->unserialize($type2Info); // 反序列化获取type2详细信息
			if(isset($type2GetInfo->structure)){
				if (isset($structureCN[$type2GetInfo->structure])) {
					$structure = $structureCN[$type2GetInfo->structure];
					$viewShowInfo['structure'] = $structure;
				}
				
			}
		}
                // 查询所有项目特色
		if(!empty($type2GetInfo->tagIds)){
			$tagIds = explode('|', $type2GetInfo->tagIds);
			$tags = $this->EsfDao->getTagName($tagIds);             //这里查数据库了，项目特色
			if(!empty($tags)){
				foreach ($tags as $k => $v) {
					if($k >= 4) break;
					$tagsName[] = $v->name;
				}
				$tagsName = implode(', ', $tagsName);
			}else{
				$tagsName = '';
			}
			$viewShowInfo['tagsName'] = $tagsName;
		}
                		// 获取该 楼盘 租金和售价 的环比上月 和同比去年的数据
		$oldCommunityStatus = $this->getOldCommunityStatus($communityId, $type2);
		$viewShowInfo['statusSalePrice'] = $oldCommunityStatus['statusSalePrice'];
		$viewShowInfo['statusSaleIncre'] = $oldCommunityStatus['statusSaleIncre'];
		$viewShowInfo['statusRentPrice'] = $oldCommunityStatus['statusRentPrice'];
		$viewShowInfo['statusRentIncre'] = $oldCommunityStatus['statusRentIncre'];

		$viewShowInfo['statusSaleIncreLastYears'] = $oldCommunityStatus['statusSaleIncreLastYears'];
		$viewShowInfo['statusRentIncreLastYears'] = $oldCommunityStatus['statusRentIncreLastYears'];
                
                
                
                
                // 查询communityimage表相关信息,楼盘图片
		$communityimage = $this->EsfDao->getImg($communityId);          //这里查数据库了，小区图片
                
                
                return view('h5.esf.esfSaleBIndex',compact('communityId','type2','viewShowInfo','type2GetInfo','houseRentData','houseSaleData','communityimage','faces','featurestag','jingduMap','weiduMap'));
                
        }
	/**
	| 二手房楼盘详情
	*/

	public function esfbd($id = 0, $type2 = '') {
		$xiangqing = 'xiangqing';
		$communityId = $id;
		$type2 = $type2;
		if($type2 == ''){
            // 查询当前楼盘的主物业类型                    
            $commuType1 = explode('|',$this->EsfDao->getCommunityType($communityId));
            if(in_array(3,$commuType1)){
                $type2 = 301;
            }else if(in_array(2,$commuType1)){
                $type2 = 201;
            }else if(in_array(1,$commuType1)){
                $type2 = 101; 
            }
        }
        $t2 = substr($type2, 0, 1) ;
	  	if($t2 == 3){
			$viewShowInfo['saleUrl'] = 'esfsale'; 
			$viewShowInfo['rentUrl'] = 'esfrent';
	  	} else if($t2 == 2){
	  		$viewShowInfo['saleUrl'] = 'xzlsale'; 
	  		$viewShowInfo['rentUrl'] = 'xzlrent';
	  	} else if($t2 == 1){
	  		$viewShowInfo['saleUrl'] = 'spsale'; 
	  		$viewShowInfo['rentUrl'] = 'sprent';
	  	}
		$typexxxInfo = 'type'.$type2.'Info';
		$community = new CommunityDataStructure($type2); // type2Info 序列化和反序列化
		$safeUtil = new SafeUtil; // 整数加密和解密

		$type2CN = config('communityType2');
		$structureCN = ['1'=>'板楼', '2'=>'塔楼', '3'=>'砖楼', '4'=>'砖混', '5'=>'平房', '6'=>'钢混', '7'=>'塔板结合','8'=>'框架剪力墙', '9'=>'其他'];
		$decorationCN = ['1'=>'毛坯', '2'=>'简装修', '3'=>'中装修', '4'=>'精装修', '5'=>'豪华装修'];

		// 获取该 楼盘 租金和售价 的环比上月 和同比去年的数据
		$oldCommunityStatus = $this->getOldCommunityStatus($communityId, $type2);
		$viewShowInfo['statusSalePrice'] = $oldCommunityStatus['statusSalePrice'];
		$viewShowInfo['statusSaleIncre'] = $oldCommunityStatus['statusSaleIncre'];
		$viewShowInfo['statusRentPrice'] = $oldCommunityStatus['statusRentPrice'];
		$viewShowInfo['statusRentIncre'] = $oldCommunityStatus['statusRentIncre'];

		$viewShowInfo['statusSaleIncreLastYears'] = $oldCommunityStatus['statusSaleIncreLastYears'];
		$viewShowInfo['statusRentIncreLastYears'] = $oldCommunityStatus['statusRentIncreLastYears'];

		// 查询楼盘详细信息(索引接口)
		$inputView = new ListInputView;
		$search = new Search();
		$inputView->isNew = false;
		// 先查缓存，没有就走ES
		if(!Cache::store('redis')->has('getCommunityByCid_'.$communityId)){
			// 用索引查询楼盘信息
			$commData = $search->getCommunityByCid($communityId);
			if(!empty($commData->found)){
				Cache::store('redis')->put('getCommunityByCid_'.$communityId,$commData,CACHE_TIME);
			}
		}else{
			$commData = Cache::store('redis')->get('getCommunityByCid_'.$communityId);
		}
		//$commData = $search->getCommunityByCid($communityId);
		if(!empty($commData->found)){
			$commData = $commData->_source;
			$viewShowInfo['rentCount'] = $commData->rentCount; // 出租总数
			$viewShowInfo['saleCount'] = $commData->saleCount; // 出售总数
			$viewShowInfo['timeCreate'] = $commData->timeCreate; // 创建时间
			$viewShowInfo['zipCode'] = $commData->zipCode; // 邮编
			$viewShowInfo['cityAreaId'] = $commData->cityAreaId; // 城区id
			$viewShowInfo['businessAreaId'] = $commData->businessAreaId; // 商圈Id
			$type2GetInfo = $community->unserialize($commData->$typexxxInfo); // 反序列化获取type2详细信息
			$jingduMap = !empty($commData->longitude) ? $commData->longitude : CURRENT_LNG ; // 楼盘经度
			$weiduMap = !empty($commData->latitude) ? $commData->latitude : CURRENT_LAT; // 楼盘纬度
			$loopLineName = $this->EsfDao->getLoopLineName($commData->loopLineId); // 查询城市环线
			if(!empty($loopLineName)){
				$viewShowInfo['loopLineName'] = $loopLineName[0]->name;
			}
			$propertyName = $this->EsfDao->getPropertyName($commData->propertyCompanyId); // 获取物业公司
			if(!empty($propertyName)){
				$viewShowInfo['propertyName'] = $propertyName[0]->companyname;
			}
			$developerName = $this->EsfDao->getDevelopersName($commData->developerId); // 获取开发商
			if(!empty($developerName)){
				$viewShowInfo['developerName'] = $developerName[0]->companyname;
			}
			
			$viewShowInfo['communityName'] = $commData->name;
			$viewShowInfo['propertyAddress'] = $commData->propertyAddress;
			$viewShowInfo['address'] = $commData->address;
		}else{
			$commData = $this->EsfDao->getCommunity($communityId,$type2); // 获取楼盘信息
			if(!empty($commData[0])){
				$commData = $commData[0];
			}
		}
		if(isset($commData->note)){
			$viewShowInfo['note'] = $commData->note;
		}
		if(!empty($commData->name)){
			$commName = $commData->name;
			$viewShowInfo['commName'] = $commName;
		}else{
			$viewShowInfo['commName'] = $commName = '';
		}
		if(!empty($type2)){
			$type2Name = $type2CN[$type2];
			$viewShowInfo['type2Name'] = $type2Name;
		}
		// dd($commData);
		if(!empty($commData)){
			// dd(\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaDataById($viewShowInfo['cityAreaId']));
			
		}
		if(!empty($type2GetInfo)){
			// 查询所有项目特色
			if(!empty($type2GetInfo->tagIds)){
				$tagIds = explode('|', $type2GetInfo->tagIds);
				$tags = $this->EsfDao->getTagName($tagIds);
				if(!empty($tags)){
					foreach ($tags as $k => $v) {
						$tagsName[] = $v->name;
					}
					$tagsName = implode(',', $tagsName);
				}else{
					$tagsName = '';
				}
			}
			if(empty($tagsName)){
				$tagsName = '';
			}
			if(!empty($type2GetInfo->diyTagIds)){
				$diyTagsName = str_replace('|', ',', $type2GetInfo->diyTagIds);
				$allTagsName = $tagsName.','.$diyTagsName;
			}else{
				if(!empty($tagsName)){
					$allTagsName = $tagsName;
					$viewShowInfo['tagsName'] = $allTagsName;
				}
			}

			// 供水 供暖 供电
			$waterSelCN = ['1'=>'市政','2'=>'其它'];
			$heatingSupplyCN = ['1'=>'集中供暖', '2'=>'小区供暖', '3'=>'自采暖'];
			if(!empty($type2GetInfo)){
				if(!empty($type2GetInfo->waterSupply)){
					$gongshui = $waterSelCN[$type2GetInfo->waterSupply];
					$viewShowInfo['gongshui'] = $gongshui;
				}
				
				if(!empty($type2GetInfo->powerSupply)){
					$gongdian = $waterSelCN[$type2GetInfo->powerSupply];
					$viewShowInfo['gongdian'] = $gongdian;
				}
				
				if(!empty($type2GetInfo->heatingSupply)){
					$gongnuan = $heatingSupplyCN[$type2GetInfo->heatingSupply];
					$viewShowInfo['gongnuan'] = $gongnuan;
				}
				if(!empty($type2GetInfo->parkingInfo)){
					// 车位信息
					$parkingInfo = explode('_', $type2GetInfo->parkingInfo);
					$parkingIntro = '';
					$parkingIntro .= empty($parkingInfo[0]) ? '' : "规划机动车停车位$parkingInfo[0]个";
					$parkingIntro .= empty($parkingInfo[1]) ? '' : "，其中地上约$parkingInfo[1]个";
					$parkingIntro .= empty($parkingInfo[2]) ? '' : "，地下约$parkingInfo[2]个。";
					$parkingIntro .= (empty($parkingInfo[3]) && empty($parkingInfo[4])) ? '' : "住宅的机动车车位配比为$parkingInfo[3] ：$parkingInfo[4]。";
					//$parkingIntro = "规划机动车停车位$parkingInfo[0]个，其中地上约$parkingInfo[1]个，地下约$parkingInfo[2]个。住宅的机动车车位配比为$parkingInfo[3] ：$parkingInfo[4]。";
					$viewShowInfo['parkingIntro'] = $parkingIntro;
				}

				if(!empty($type2GetInfo->preSalePermit)){
					$preSalePermit = $safeUtil->decrypt($type2GetInfo->preSalePermit); // 获取预售许可证
					$viewShowInfo['preSalePermit'] = $preSalePermit;
				}

				if(!empty($type2GetInfo->structure)){
					$viewShowInfo['structure'] = $structureCN[$type2GetInfo->structure];
				}
				if(!empty($type2GetInfo->decoration)){
					$viewShowInfo['decoration'] = $decorationCN[$type2GetInfo->decoration];
				}
				if(!empty($type2GetInfo->intro)){
					$viewShowInfo['intro'] = $type2GetInfo->intro;
				}
				// 竣工时间处理
				if( !is_numeric( substr($type2GetInfo->endTime,0,1 ) ) ){
					$type2GetInfo->endTime = '';
				}
				// 物业费
				if($type2GetInfo->propertyFee == 0){
					$type2GetInfo->propertyFee = '';
				}
			}
		}


		// 查询出售房源信息(索引)
		$search = new Search('hs');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->cityId = CURRENT_CITYID;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
		$list->order = 'timeRefresh';
		$list->asc = 0;
//		$list->communityId = $communityId;
//		$list->type2 = $type2;
		$houseSaleData = $search->searchHouse($list);
		if(empty($houseSaleData->error)) {
			$houseSaleData = $houseSaleData->hits;
		}

		// 查询出租房源信息(索引)
		$search = new Search('hr');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->cityId = CURRENT_CITYID;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
		$list->order = 'timeRefresh';
		$list->asc = 0;
//		$list->communityId = $communityId;
//		$list->type2 = $type2;
		$houseRentData = $search->searchHouse($list);
		if(empty($houseRentData->error)) {
			$houseRentData = $houseRentData->hits;
		}
		return view('esf.esfSaleBDetail',compact('communityId','type2','commName','xiangqing', 'houseSaleData', 'houseRentData','viewShowInfo','type2GetInfo','communityStatus','jingduMap','weiduMap','periodBuildData'));
	}

	/**
	| 二手户型详情
	*/

	public function esfbl() {

		/*
		* 同户型出售房源推荐
		*/
		if(!empty(Input::get('room'))){
			$communityId = Input::get('communityId');
			$houseRoom = Input::get('room');
			$search = new Search('hs');
			$list = new ListInputView();
			$list->communityId = $communityId;
			$list->houseRoom = $houseRoom;
			$houseSaleData = $search->searchHouse($list);
			foreach($houseSaleData->hits->hits as $key => $val){
				$val->_source->thumbPic = get_img_url('houseSale', $val->_source->thumbPic);
				$houseSaleData->hits->hits[$key] = $val;
			}
			$saleData['houseSale'] = $houseSaleData->hits->hits;
			$saleData['saleTotalNum'] = $houseSaleData->hits->hits;


			// 查询出租房源信息(索引)
			$search = new Search('hr');
			$list = new ListInputView();
			$list->communityId = $communityId;
			$list->houseRoom = $houseRoom;
			$houseRentData = $search->searchHouse($list);
			foreach($houseRentData->hits->hits as $key => $val){
				$val->_source->thumbPic = get_img_url('houseRent', $val->_source->thumbPic);
				$houseRentData->hits->hits[$key] = $val;
			}
			$saleData['houseRent'] = $houseRentData->hits->hits;
			$saleData['rentTotalNum'] = $houseRentData->hits->total;
			$saleData['communityId'] = $communityId;
			return $saleData;
		}

		$huxing = 'huxing';
		$communityId = Input::get('communityId');
		$type2 = Input::get('type2');
		$roomtype = Input::get('roomtype');
		$roomId = Input::get('roomId');
		$typexxxInfo = 'type'.$type2.'Info';
		$community = new CommunityDataStructure($type2); // type2Info 序列化和反序列化
		$safeUtil = new SafeUtil; // 整数加密和解密

		// 获取该 楼盘 租金和售价 的环比上月 和同比去年的数据
		$oldCommunityStatus = $this->getOldCommunityStatus($communityId, $type2);
		$viewShowInfo['statusSalePrice'] = $oldCommunityStatus['statusSalePrice'];
		$viewShowInfo['statusSaleIncre'] = $oldCommunityStatus['statusSaleIncre'];
		$viewShowInfo['statusRentPrice'] = $oldCommunityStatus['statusRentPrice'];
		$viewShowInfo['statusRentIncre'] = $oldCommunityStatus['statusRentIncre'];

		$viewShowInfo['statusSaleIncreLastYears'] = $oldCommunityStatus['statusSaleIncreLastYears'];
		$viewShowInfo['statusRentIncreLastYears'] = $oldCommunityStatus['statusRentIncreLastYears'];

		// 楼盘信息
		// $select = ['id','name'];
		// $commData = $this->EsfDao->getCommData($communityId,$select);
		// 查询楼盘详细信息(索引接口)
		$type2CN = config('communityType2');
		$inputView = new ListInputView;
		$search = new Search();
		$inputView->isNew = false;
		// 先查缓存，没有就走ES
		if(!Cache::store('redis')->has('getCommunityByCid_'.$communityId)){
			// 用索引查询楼盘信息
			$commData = $search->getCommunityByCid($communityId);
			if(!empty($commData->found)){
				Cache::store('redis')->put('getCommunityByCid_'.$communityId,$commData,CACHE_TIME);
			}
		}else{
			$commData = Cache::store('redis')->get('getCommunityByCid_'.$communityId);
		}
		//$commData = $search->getCommunityByCid($communityId);
		$commData = $commData->_source;
		if(!empty($commData)){
			$commName = $commData->name;
			$viewShowInfo['commName'] = $commName;
			$viewShowInfo['communityName'] = $commName;
			$viewShowInfo['rentCount'] = $commData->rentCount; // 出租总数
			$viewShowInfo['saleCount'] = $commData->saleCount; // 出售总数
			$viewShowInfo['timeCreate'] = $commData->timeCreate; // 创建时间
		}
		if(!empty($type2)){
			$type2Name = $type2CN[$type2];
			$viewShowInfo['type2Name'] = $type2Name;
		}
		

		// if(!empty($commData->name)){
		// 	$commName = $commData->name;
		// 	$viewShowInfo['commName'] = $commName;
		// }

		// 查询所有户型信息
		$select = ['id','communityId','name','state','thumbPic','room','hall','toilet','kitchen','floorage','faceTo','num','price','feature'];
		$commRoom = $this->EsfDao->getCommunityRoom($communityId,'1',$select);
		if(!empty($commRoom)){
			$room1Tota = count($commRoom);
			$viewShowInfo['room1Tota'] = $room1Tota;
			// dd($room1Tota);
			$room2 = $this->getRoomNum($commRoom,2); // 获取2居室户型信息
			if(!empty($room2)){
				$room2Tota = count($room2);
				$viewShowInfo['room2Tota'] = $room2Tota;
			}
			$room3 = $this->getRoomNum($commRoom,3); // 获取3居室户型信息
			if(!empty($room3)){
				$room3Tota = count($room3);
				$viewShowInfo['room3Tota'] = $room3Tota;
			}
			$room4 = $this->getRoomNum($commRoom,4); // 获取4居室户型信息
			if(!empty($room4)){
				$room4Tota = count($room4);
				$viewShowInfo['room4Tota'] = $room4Tota;
			}
			$room5 = $this->getRoomNum($commRoom,5); // 获取5居室户型信息
			if(!empty($room5)){
				$room5Tota = count($room5);
				$viewShowInfo['room5Tota'] = $room5Tota;
			}
		}
		// dd($commRoom);
		if(!empty($commRoom)){
			// 从主页跳转过来需要查询的户型信息
			if(!empty($roomId)){
				$roomOneInfo = [];
				foreach ($commRoom as $roomV) {
					if($roomV->id == $roomId){
						$roomOneInfo = $roomV;
					}
				}
			}else if(!empty($roomtype)){
				foreach ($commRoom as $roomV) {
					if($roomV->room == $roomtype){
						$roomOneInfo = $roomV;
					}
				}
			}else{
				$roomOneInfo = $commRoom[0];
				$roomId = $commRoom[0]->id;
			}
			$faceToCN = [1 =>'东', 2 =>'南', 3 =>'西', 4 =>'北', 5 =>'南北', 6 =>'东南', 7 =>'西南', 8 =>'东北', 9 =>'西北', 10 =>'东西'];
			if(!empty($roomOneInfo->faceTo)){
				$faceToName = $faceToCN[$roomOneInfo->faceTo];
				$viewShowInfo['faceToName'] = $faceToName;
			}
		}

		// 查询出租房源信息(索引)
		$search = new Search('hs');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->type2 = $type2;
		$houseSaleData = $search->searchHouse($list);
		// $houseSaleData = $this->EsfDao->getHouseSale($communityId);
		// dd($houseSaleData);
		if(!empty($houseSaleData->hits->hits)){
			$saleTotal = $houseSaleData->hits->total;
			$houseSaleData = $houseSaleData->hits->hits;
			foreach ($houseSaleData as $sale) {
				$price[] = $sale->_source->price2;
			}
			$viewShowInfo['roomNum'] = count($price);
			$viewShowInfo['minPrice2'] = min($price);
			$viewShowInfo['maxPrice2'] = max($price);
			$houseRoom1 = $this->houseSaleRoom($houseSaleData,1); // 取出室为1是价格区间
			$houseRoom2 = $this->houseSaleRoom($houseSaleData,2); // 取出室为2是价格区间
			$houseRoom3 = $this->houseSaleRoom($houseSaleData,3); // 取出室为3是价格区间
			$houseRoom4 = $this->houseSaleRoom($houseSaleData,4); // 取出室为4是价格区间
			$houseRoom5 = $this->houseSaleRoom($houseSaleData,5); // 取出室为5是价格区间
		}
		// 查询出租房源信息(索引)
		$search = new Search('hr');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->type2 = $type2;
		$houseRentData = $search->searchHouse($list);
		// $houseRentData = $this->EsfDao->getHouseRent($communityId);
		if(!empty($houseRentData->hits->hits)){
			$rentTotal = $houseRentData->hits->total;
			$houseRentData = $houseRentData->hits->hits;
			foreach ($houseRentData as $rent) {
				$price[] = $rent->_source->price1;
			}
			$viewShowInfo['rentNum'] = count($price);
			$viewShowInfo['minPrice1'] = min($price);
			$viewShowInfo['maxPrice1'] = max($price);
			$houseRent1 = $this->houseRentRoom($houseRentData,1); // 取出室为1是价格区间
			$houseRent2 = $this->houseRentRoom($houseRentData,2); // 取出室为2是价格区间
			$houseRent3 = $this->houseRentRoom($houseRentData,3); // 取出室为3是价格区间
			$houseRent4 = $this->houseRentRoom($houseRentData,4); // 取出室为4是价格区间
			$houseRent5 = $this->houseRentRoom($houseRentData,5); // 取出室为5是价格区间
		}

		return view('esf.esfSaleBLeyout',compact('communityId','type2', 'rentTotal', 'saleTotal','huxing','viewShowInfo', 'commName','commRoom','room2','room3','room4','room5','roomtype','roomId','roomOneInfo','houseRoom1','houseRoom2','houseRoom3','houseRoom4','houseRoom5','houseRent1','houseRent2','houseRent3','houseRent4','houseRent5','houseSaleData','houseRentData'));
	}

	/**
	| 二手相册
	*/

	public function esfba() {

		$xiangce = 'xiangce';
		$communityId = Input::get('communityId');
		$type2 = Input::get('type2');
		$typexxxInfo = 'type'.$type2.'Info';

		// 楼盘信息
		$select = ['id','name'];
		$type2CN = config('communityType2');
		$inputView = new ListInputView;
		$search = new Search();
		$inputView->isNew = false;
		// 先查缓存，没有就走ES
		if(!Cache::store('redis')->has('getCommunityByCid_'.$communityId)){
			// 用索引查询楼盘信息
			$commData = $search->getCommunityByCid($communityId);
			if(!empty($commData->found)){
				Cache::store('redis')->put('getCommunityByCid_'.$communityId,$commData,CACHE_TIME);
			}
		}else{
			$commData = Cache::store('redis')->get('getCommunityByCid_'.$communityId);
		}
		//$commData = $search->getCommunityByCid($communityId);
		$commData = $commData->_source;
		if(!empty($commData)){
			$viewShowInfo['communityName'] = $commData->name;
		}

		if(!empty($commData->name)){
			$commName = $commData->name;
			$viewShowInfo['commName'] = $commName;
		}

		// 获取该 楼盘 租金和售价 的环比上月 和同比去年的数据
		$oldCommunityStatus = $this->getOldCommunityStatus($communityId, $type2);
		$viewShowInfo['statusSalePrice'] = $oldCommunityStatus['statusSalePrice'];
		$viewShowInfo['statusSaleIncre'] = $oldCommunityStatus['statusSaleIncre'];
		$viewShowInfo['statusRentPrice'] = $oldCommunityStatus['statusRentPrice'];
		$viewShowInfo['statusRentIncre'] = $oldCommunityStatus['statusRentIncre'];

		$viewShowInfo['statusSaleIncreLastYears'] = $oldCommunityStatus['statusSaleIncreLastYears'];
		$viewShowInfo['statusRentIncreLastYears'] = $oldCommunityStatus['statusRentIncreLastYears'];

		//查询楼盘下所有图片
		$commImgTotal = $this->EsfDao->getCommImgTotal($communityId);
		/*
		| ------------------------------
		| 统计不同类型图片的数量
		| ------------------------------
		| 1.交通图 2.实景图 3.效果图
		| 4.样板间 6.配套图 7.施工进度图
		| 8.规划图
		*/
		$type1ImgNum = $this->imgTypeStatistics($commImgTotal,'1');
		$type2ImgNum = $this->imgTypeStatistics($commImgTotal,'2');
		$type3ImgNum = $this->imgTypeStatistics($commImgTotal,'3');
		$type4ImgNum = $this->imgTypeStatistics($commImgTotal,'4');
		$type6ImgNum = $this->imgTypeStatistics($commImgTotal,'6');
		$type7ImgNum = $this->imgTypeStatistics($commImgTotal,'7');
		$type8ImgNum = $this->imgTypeStatistics($commImgTotal,'8');
		$viewShowInfo['type1ImgNum'] = $type1ImgNum;
		$viewShowInfo['type2ImgNum'] = $type2ImgNum;
		$viewShowInfo['type3ImgNum'] = $type3ImgNum;
		$viewShowInfo['type4ImgNum'] = $type4ImgNum;
		$viewShowInfo['type6ImgNum'] = $type6ImgNum;
		$viewShowInfo['type7ImgNum'] = $type7ImgNum;
		$viewShowInfo['type8ImgNum'] = $type8ImgNum;

		// 查询不同类型图片
		$type = Input::get('type'); // 图片type
		$commTypeImg = $this->EsfDao->getCommTypeImg($communityId,$type);
		// dd($commTypeImg);
		$commTypeImg->appends([
			'communityId' => $communityId,
			'type2'       => $type2,
			'type'        => $type
			])->render();

		return view('esf.esfSaleBAlbum',compact('communityId','type2','xiangce','viewShowInfo','commTypeImg','type'));
	}

	/**
	| 二手房价走势
	*/
	public function esfbp($id = 0, $type2 = '') {

		$communityId=$id;
		$type2=$type2;
		$type=Input::get('type',2);
		$room=Input::get('room',0);

		$changeTime=date('Ym',strtotime('-12 month'));

		$esfObj=new EsfDao();
		if($type2 == ''){
            // 查询当前楼盘的主物业类型                    
            $commuType1 = explode('|',$this->EsfDao->getCommunityType($communityId));
            if(in_array(3,$commuType1)){
                $type2 = 301;
            }else if(in_array(2,$commuType1)){
                $type2 = 201;
            }else if(in_array(1,$commuType1)){
                $type2 = 101; 
            }
        }
        $t2 = substr($type2, 0, 1) ;
	  	if($t2 == 3){
			$viewShowInfo['saleUrl'] = 'esfsale'; 
			$viewShowInfo['rentUrl'] = 'esfrent';
	  	} else if($t2 == 2){
	  		$viewShowInfo['saleUrl'] = 'xzlsale'; 
	  		$viewShowInfo['rentUrl'] = 'xzlrent';
	  	} else if($t2 == 1){
	  		$viewShowInfo['saleUrl'] = 'spsale'; 
	  		$viewShowInfo['rentUrl'] = 'sprent';
	  	}
		$type2CN = config('communityType2');
		// 获取该 楼盘 租金和售价 的环比上月 和同比去年的数据
		$oldCommunityStatus = $this->getOldCommunityStatus($communityId, $type2);
		$viewShowInfo['statusSalePrice'] = $oldCommunityStatus['statusSalePrice'];
		$viewShowInfo['statusSaleIncre'] = $oldCommunityStatus['statusSaleIncre'];
		$viewShowInfo['statusRentPrice'] = $oldCommunityStatus['statusRentPrice'];
		$viewShowInfo['statusRentIncre'] = $oldCommunityStatus['statusRentIncre'];

		$viewShowInfo['statusSaleIncreLastYears'] = $oldCommunityStatus['statusSaleIncreLastYears'];
		$viewShowInfo['statusRentIncreLastYears'] = $oldCommunityStatus['statusRentIncreLastYears'];
		$inputView = new ListInputView;
		$search = new Search();
		$inputView->isNew = false;
		$commData = $search->getCommunityByCid($communityId);

		if(!empty($commData->found)){
			$commData = $commData->_source;
                        $viewShowInfo['commName']=$commData->name;
			$viewShowInfo['rentCount'] = $commData->rentCount; // 出租总数
			$viewShowInfo['saleCount'] = $commData->saleCount; // 出售总数
			$viewShowInfo['timeCreate'] = $commData->timeCreate; // 创建时间
			$viewShowInfo['businessAreaId']=$commData->businessAreaId;
			$busnessName=RedisCacheUtil::getBussinessNameById($commData->businessAreaId);
			$viewShowInfo['busnessName']=$busnessName;

			// 查询出售房源信息(索引)
			$search = new Search();
			$list = new ListInputView();
			$list->isNew = false;
			$list->businessAreaId = $commData->businessAreaId;
			$list->order = 'oldCommunityPriceMap.r2.t'.$type2.'.increase';
			$list->asc = 0;
			$list->pageset = 5;
			$houseSaleData = $search->searchCommunity($list);
//			dd($houseSaleData);
			if(empty($houseSaleData->error)){
				$viewShowInfo['priceDescTop_5'] = $houseSaleData->hits->hits;  // 涨幅前5
			}
			$list->asc = 1;
			$houseSaleData = $search->searchCommunity($list);
			if(empty($houseSaleData->error)){
				$viewShowInfo['priceAscTop_5'] = $houseSaleData->hits->hits;  // 跌幅前5
			}
		}else{
			$viewShowInfo['busnessName'] ='';
			$viewShowInfo['commName']    = '';
			$viewShowInfo['businessAreaId']='';
		}

		$viewShowInfo['communityId']=$communityId;
		$viewShowInfo['type2']=$type2;
		
		

		if(!empty($type2)){
			$type2Name = $type2CN[$type2];
			$viewShowInfo['type2Name'] = $type2Name;
		}
		
		$viewShowInfo['price']=true;
		$viewShowInfo['viewShowInfo'] = $viewShowInfo;
		// 查询出售房源信息(索引)
		$search = new Search('hs');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
                $list->cityId = CURRENT_CITYID;
		$list->order = 'timeRefresh';
		$list->asc = 0;
//		$list->communityId = $communityId;
//		$list->type2 = $type2;
		$houseSaleData = $search->searchHouse($list);
		if(empty($houseSaleData->error)) {
			$viewShowInfo['houseSaleData'] = $houseSaleData->hits;
		}

		// 查询出租房源信息(索引)
		$search = new Search('hr');
		$list = new ListInputView();
		$list->communityId = $communityId;
		$list->type1 = substr($type2, 0 , 1);
		//$list->type2 = $type2;
                $list->cityId = CURRENT_CITYID;
		$list->order = 'timeRefresh';
		$list->asc = 0;
//		$list->communityId = $communityId;
//		$list->type2 = $type2;
		$houseRentData = $search->searchHouse($list);
		if(empty($houseRentData->error)) {
			$viewShowInfo['houseRentData'] = $houseRentData->hits;
		}
		return view('esf.esfSaleBPrice',$viewShowInfo);
		//return view('esf.esfSaleBPrice');
	}




	//异步取二手楼盘历史价格
	public function showEsfSalePrice()
	{
		
		$type2=Input::get('ctype2','301');
		$type=Input::get('type',2);
		$priceType=Input::get('dataType');
		$communityId='';
		$businessareaId='';
		$cityareaId='';
		$cityId='';





		$priceArray=array();

		$catchKey=CATCHPREESF.'_'.$type2.'_'.$type.'_'.$priceType.'_'.$communityId.'_'.$businessareaId.'_'.$cityareaId.'_'.$cityId;
		if (Cache::has($catchKey))
		{
			$priceArray=Cache::get($catchKey);
		}else
		{
			if ($priceType=='sale_1') {
			//楼盘历史价格
				$communityId=Input::get('comid','1');
				$priceArray=$this->esfCommunityPrice($communityId,$type2,$type);
			}elseif ($priceType=='sale_2') {
			//商圈历史价格
				$businessareaId=Input::get('businessareaId',88);
				$priceArray=$this->esfCommunityBusnessPrice($type2,$type,$businessareaId);


			}elseif ($priceType=='sale_3') {
			//城区历史价格
				$cityareaId=Input::get('cityArea',5);
				$priceArray=$this->esfCommunityCityAreaPrice($cityareaId,$type,$type2);

			}elseif ($priceType=='sale_4') {
			//城市历史价格
				$cityId=Input::get('cityId',1);
				$priceArray=$this->esfCommunityCityPrice($cityId,$type,$type2);
			}

			Cache::put($catchKey, $priceArray, 60*24*7);


		}
		return response()->json($priceArray);

	}
	//二手楼盘价格趋势数据
	function esfCommunityPrice($communityId,$type2,$type)
	{
		// $communityId=Input::get('comid','1');
		// $type2=Input::get('ctype2','301');
		// $type=Input::get('type',2);
		//$room=Input::get('room',0);
		$room=0;
		$changeTime=date('Ym',strtotime('-12 month'));
		$comObj=new Communitystatus2Dao();
		$communityPrices=$comObj->getHistoricalPrices($communityId,$type2,$type,$room,$changeTime);
		//$priceInfo=array();
		$showTime=array();
		$showPrice=array();
		foreach ($communityPrices as $item) {
			
			array_push($showTime,$item->changeTime);
			array_push($showPrice,$item->avgPrice);
		}

		$fmateData=$this->fullComplement($showTime,$showPrice);
		$priceTitle=$this->getPriceTitle();
		return ['priceTitle' => $priceTitle, 'price' => array_values($fmateData),'time'=>array_keys($fmateData)];
	//	return response()->json(['priceTitle' => $priceTitle, 'price' => $showPrice,'time'=>$showTime]);
		//return view('esf.esfSaleBPrice',['priceTitle'=>$priceTitle,'price'=>json_encode($showPrice),'time'=>json_encode($showTime)]);
	}


	//返回商圈价格趋势数据
	function esfCommunityBusnessPrice($type2,$type,$businessareaId)
	{
		
		// $type2=Input::get('ctype2','301');
		// $type=Input::get('type',2);
		// $businessareaId=Input::get('businessareaId',88);
		$changeTime=date('Ym',strtotime('-12 month'));
		$comObj=new Communitystatus2Dao();
		$busnessPrices=$comObj->getBusnessHistoricalPrices($type2,$type,$businessareaId,$changeTime);
		$results=array('time'=>[],'price'=>[]);
		foreach ($busnessPrices as $item) {
			$results['time'][]=$item->changeTime;
			$results['price'][]=$item->avgPrice;
		}
		//$title=$this->getPriceTitle();
		$fmateData=$this->fullComplement($results['time'],$results['price']);
		$results['time']=array_keys($fmateData);
		$results['price']=array_values($fmateData);



		$results['priceTitle']=$this->getPriceTitle();
		unset($comObj);
		return $results;
	}

	//返回城区价格走势数据
	function esfCommunityCityAreaPrice($cityareaId,$type,$type2)
	{
		$changeTime=date('Ym',strtotime('-12 month'));
		$comObj=new Communitystatus2Dao();
		$cityAreaPrices=$comObj->getAreaHistoricalPrices($cityareaId,$type,$type2,$changeTime);
		$results=array('time'=>[],'price'=>[]);
		foreach ($cityAreaPrices as $item) {
			$results['time'][]=$item->changeTime;
			$results['price'][]=$item->avgPrice;
		}

		$fmateData=$this->fullComplement($results['time'],$results['price']);
		$results['time']=array_keys($fmateData);
		$results['price']=array_values($fmateData);



		$results['priceTitle']=$this->getPriceTitle();
		unset($comObj);
		return $results;
	}

	//返回城市价格走势数据
	function esfCommunityCityPrice($cityId,$type,$type2)
	{
		$changeTime=date('Ym',strtotime('-12 month'));
		$comObj=new Communitystatus2Dao();
		$cityPrices=$comObj->getCityHistoricalPrices($cityId,$type,$type2,$changeTime);
		$results=array('time'=>[],'price'=>[]);
		foreach ($cityPrices as $item) {
			$results['time'][]=$item->changeTime;
			$results['price'][]=$item->avgPrice;
		}

		$fmateData=$this->fullComplement($results['time'],$results['price']);
		$results['time']=array_keys($fmateData);
		$results['price']=array_values($fmateData);


		$results['priceTitle']=$this->getPriceTitle();
		unset($comObj);
		return $results;
	}



	public function getPriceTitle()
	{
		return date('Y',strtotime('-12 month')).'年'.date('m',strtotime('-12 month')).'月-'.date('Y',strtotime('-1 month')).'年'.date('m',strtotime('-1 month')).'月';
		
	}


	

	public function esfRentPrice()
	{
		$changeTime=date('Ym',strtotime('-12 month'));
		$type2=Input::get('ctype2','301');
		$priceType=Input::get('dataType');
		
		$rentPrice=array();
		$comObj=new Communitystatus2Dao();
		if ($priceType=='rent_1') {
			$communityId=Input::get('comid','1');
			$rentPrice=$comObj->getCommunityRentPrice($communityId,$type2,$changeTime);
			//$rentPrice=$this->formateRentPrict($communityPrices);
			//$rentPrice=$this->esfCommunityRentPrice($communityId,$type2);
		}elseif ($priceType=='rent_2') {
			$businessareaId=Input::get('businessareaId',88);
			$rentPrice=$comObj->getBusnessRentPrice($type2,$businessareaId,$changeTime);
			//$rentPrice=$this->formateRentPrict($busnessPrices);

		}else
		{
			return response()->json(['title'=>$this->getPriceTitle(),'time'=>[],'price'=>[]]);
		}
		
		// $roomTitle=[1=>'一居室',2=>'二居室',3=>'三居室',4=>'四居室',5=>'五居室',6=>'六居室',7=>'七居室',8=>'八居室'];
		// $returnPrice=array();
		
		// $ftime='';
		// foreach ($rentPrice as $room => $item) {
		// 	$fmateData=$this->fullComplement($item['time'],$item['price']);
		// 	$fPrice=array_values($fmateData);
		// 	if (empty($ftime)) {
		// 		$ftime=array_keys($fmateData);
		// 	}

		// 	array_push($returnPrice,['name'=>$roomTitle[$room],'data'=>$fPrice]);
		// }
		$fmateDatas=$this->perfectData($rentPrice);


		$title=$this->getPriceTitle();
		return response()->json(['title'=>$title,'time'=>$fmateDatas['time'],'price'=>$fmateDatas['price']]);
		

	}


//补充完事每月数据
	function fullComplement($time,$price)
	{

		$timeToPrice=array();
		foreach ($time as $key => $value) {
			$timeToPrice[$value]=$price[$key];
		}

		$resuts=array();
		for ($i=12; $i>0; $i--) { 
			$strdt=date('Ym',strtotime('-'.$i.' month'));
			$resuts[$strdt]=0;
		}
		$_s=$price[0];
		foreach ($resuts as $t=>$p) {
			if (isset($timeToPrice[$t])) {
				$resuts[$t]=$timeToPrice[$t];
				$_s=$timeToPrice[$t];
			}else
			{
				$resuts[$t]=$_s;
			}

		}

		return $resuts;
	}


	//将数据分组并补充完成
	public function perfectData($dt)
	{
		
		$rentPrice=$this->formateRentPrict($dt);
		//dd($rentPrice);
		
		$roomTitle=[0=>'均价',1=>'一居',2=>'二居',3=>'三居',4=>'四居',5=>'五居',6=>'六居',7=>'七居',8=>'八居'];
		$returnPrice=array();
		
		$ftime='';
		foreach ($rentPrice as $room => $item) {
			$fmateData=$this->fullComplement($item['time'],$item['price']);

			$fPrice=array_values($fmateData);
			if (empty($ftime)) {
				$ftime=array_keys($fmateData);
			}
			if (!isset($roomTitle[$room])) {
				
				continue;
			}

			array_push($returnPrice,['name'=>$roomTitle[$room],'data'=>$fPrice]);

			
		}
		if (count($rentPrice)==0) {
			$fmateData=$this->fullComplement([date('Ym',strtotime('-12 month'))],[0]);
			return ['time'=>array_keys($fmateData),'price'=>[['name'=>'均价','data'=>array_values($fmateData)]]];
			
		}

		return ['time'=>$ftime,'price'=>$returnPrice];

	}


	// function esfCommunityRentPrice($communityId,$type2)
	// {

	// 	$changeTime=date('Ym',strtotime('-12 month'));
	// 	$comObj=new Communitystatus2Dao();
	// 	$communityPrices=$comObj->getCommunityRentPrice($communityId,$type2,$changeTime);


	// 	$results=$this->formateRentPrict($communityPrices);
	// 	return $results;

	// }

	//整数出租价格
	function formateRentPrict($priceData)
	{
		$results=array();
		foreach ($priceData as $item) {

			$results[$item->room]['time'][]=$item->changeTime;
			$results[$item->room]['price'][]=intval($item->avgPrice);
		}
		return $results;
	}






	//	添加二手楼盘测试数据
	function addEsfPriceData()
	{
		
		for ($i=1; $i <12 ; $i++) { 
			$comObj=new CommunityStatusTo();
			$comObj->communityId=1;
			$comObj->cType1=3;
			$comObj->cType2=301;
			$comObj->type=1;
			$comObj->room=2;
			$comObj->cityId=1;
			$comObj->cityAreaId=5;
			$comObj->businessAreaId=88;

			$comObj->maxPrice=20000+$i*100;
			$comObj->minPrice=10000+$i*100;
			$comObj->avgPrice=rand(20000,30000);
			$comObj->increase=rand(0,30);
			$comObj->description='价格描述';
			$comObj->changeTime=date('Ym',strtotime('-'.$i.' month'));
			$comObj->save();
		}
	}

	//添加楼盘所有商圈测试数据
	function addBusnessPriceTest()
	{
		
		for ($i=1; $i <12 ; $i++) { 
			$comObj=new BusinessareastatusTo();

			$comObj->cType1=3;
			$comObj->cType2=301;
			$comObj->type=1;
			$comObj->room=4;
			// $comObj->cityId=1;
			// $comObj->cityAreaId=5;
			$comObj->businessareaId=88;
			$comObj->maxPrice=20000+$i*100;
			$comObj->minPrice=10000+$i*100;
			$comObj->avgPrice=rand(30000,40000);
			$comObj->increase=rand(0,30);
			$comObj->description='价格描述';
			$comObj->changeTime=date('Ym',strtotime('-'.$i.' month'));
			$comObj->save();
		}
	}
	//添加城区测试数据
	function addAreaPriceTest()
	{
		for ($i=1; $i <12 ; $i++) { 
			$comObj=new CityareastatusTo();

			$comObj->cType1=3;
			$comObj->cType2=301;
			$comObj->type=2;
			// $comObj->cityId=1;
			// $comObj->cityAreaId=5;
			$comObj->cityareaId=5;
			$comObj->maxPrice=20000+$i*100;
			$comObj->minPrice=10000+$i*100;
			$comObj->avgPrice=rand(20000,40000);
			$comObj->increase=rand(0,30);
			$comObj->description='价格描述';
			$comObj->changeTime=date('Ym',strtotime('-'.$i.' month'));
			$comObj->save();
		}
	}

	//添加城市测试数据
	function addCityPriceTest()
	{
		for ($i=1; $i <12 ; $i++) { 
			$comObj=new CitystatusTo();

			$comObj->cType1=3;
			$comObj->cType2=301;
			$comObj->type=2;
			// $comObj->cityId=1;
			// $comObj->cityAreaId=5;
			$comObj->cityId=1;
			$comObj->maxPrice=20000+$i*100;
			$comObj->minPrice=10000+$i*100;
			$comObj->avgPrice=rand(20000,40000);
			$comObj->increase=rand(0,30);
			$comObj->description='价格描述';
			$comObj->changeTime=date('Ym',strtotime('-'.$i.' month'));
			$comObj->save();
		}
	}

	/**
	| 函数封装
	*/

	/**
	* 获取类型图片的第一张,并且给其命名
	* @param resource $typeImg 查询到图片
	* @param string $typeName 给图片命名
	*/
	public function getImg($typeImg,$typeName) {
		if(!empty($typeImg)){
			$fileName = $typeImg[0]->fileName;
			$type = $typeImg[0]->type;
			$imgInfo['fileName'] = $fileName;
			$imgInfo['imgName'] = $typeName;
			$imgInfo['type'] = $type;
		}
		return $imgInfo;
	}

	/**
	* 取出不同户型信息 room 为几 就是几户型
	* @param resource $commRoom 查询到的所有户型
	* @param int $num 几室数量
	*/
	public function getRoomNum($commRoom,$num) {
		$room = array();
		foreach ($commRoom as $v) {
			if($v->room == $num){
				$room[] = $v;
			}
		}
		return $room;
	}

	/**
	* 统计不同类型图片的数量
	* @param resource $commImgTotal 楼盘下所有图片
	* @param int $type 图片类型
	*/
	public function imgTypeStatistics($commImgTotal,$type) {
		$typeNum = [];
		foreach ($commImgTotal as $imgV) {
			if($imgV->type == $type) {
				$typeNum[] = $imgV;
			}
		}
		$imgNum = count($typeNum);
		return $imgNum;
	}

	/**
	* 统计不同户型的出售房源价格区间
	* @param resource $houseSaleData 同楼盘下的所有出售房源信息
	* @param int $num 几室
	*/
	public function houseSaleRoom($houseSaleData,$num) {
		$saleHouseRoom = [];
		if(!empty($houseSaleData)){
			foreach ($houseSaleData as $sale) {
				if($sale->_source->houseRoom == $num){
					$houseRoom[] = $sale->_source;
					$roomNum = count($houseRoom);
					foreach ($houseRoom as $saleRoom) {
						$price2[] = $saleRoom->price2;
					}
					$minPrice2 = min($price2); // 取出在售房源最小区间价
					$maxPrice2 = max($price2); // 取出在售房源最大区间价
					$saleHouseRoom['roomNum'] = $roomNum;
					$saleHouseRoom['minPrice2'] = $minPrice2;
					$saleHouseRoom['maxPrice2'] = $maxPrice2;
				}
			}
		}
		return $saleHouseRoom;
	}

	/**
	* 统计不同户型的出售房源价格区间
	* @param resource $houseRentData 同楼盘下的所有出租房源信息
	* @param int $num 几室
	*/
	public function houseRentRoom($houseRentData,$num) {
		$rentHouseRoom = [];
		if(!empty($houseRentData)){
			foreach ($houseRentData as $rent) {
				if($rent->_source->houseRoom == $num){
					$houseRoom[] = $rent->_source;
					$roomNum = count($houseRoom);
					foreach ($houseRoom as $rentRoom) {
						$price1[] = $rentRoom->price1;
					}
					$minPrice1 = min($price1); // 取出在租房源最小区间价
					$maxPrice1 = max($price1); // 取出在租房源最大区间价
					$rentHouseRoom['roomNum'] = $roomNum;
					$rentHouseRoom['minPrice1'] = $minPrice1;
					$rentHouseRoom['maxPrice1'] = $maxPrice1;
				}
			}
		}
		return $rentHouseRoom;
	}

	/**
	 * @param $communityId
	 * @param $type2
	 * @return array
	 */
	public function getOldCommunityStatus($communityId, $type2){
		$commStatus = $this->EsfDao->getStatusByLimit_24($communityId, $type2); // 查询调价历史信息
		$info = array();
		if(!empty($commStatus)){
			$commStatusSaleByMonth = array();  // 记录每个月的出售均价和增长幅度
			$commStatusRentByMonth = array();  // 记录每个月的出租均价和增长幅度
			foreach($commStatus as $val){
				if($val->type == 2){	// type 为 2 是出售
					$commStatusSaleByMonth[] = array('avgPrice'=>$val->avgPrice, 'increase'=>$val->increase);
				}
				if($val->type == 1){ 	// type 为 1 是出租
					$commStatusRentByMonth[] = array('avgPrice'=>$val->avgPrice, 'increase'=>$val->increase);
				}
			}
			$info['statusSalePrice'] = isset($commStatusSaleByMonth[0]['avgPrice']) ? $commStatusSaleByMonth[0]['avgPrice'] : '' ; 	//  环比上月出售均价
			$info['statusRentPrice'] = isset($commStatusRentByMonth[0]['avgPrice']) ? $commStatusRentByMonth[0]['avgPrice'] : '' ; 	//  环比上月出租均价

			$info['statusSaleIncre'] = isset($commStatusSaleByMonth[0]['increase']) ? $commStatusSaleByMonth[0]['increase'] * 100 : '' ;		//  环比上月出售涨幅
			$info['statusRentIncre'] = isset($commStatusRentByMonth[0]['increase']) ? $commStatusRentByMonth[0]['increase'] * 100 : '' ;		//  环比上月出租涨幅

			//  环比去年出售涨幅
			if(isset($commStatusSaleByMonth[11]['increase'])){
				$info['statusSaleIncreLastYears'] =  $commStatusSaleByMonth[11]['increase'] * 100 ;
			}elseif(isset($commStatusSaleByMonth[ (count($commStatusSaleByMonth) - 1)]['increase'])){
				$info['statusSaleIncreLastYears'] =  $commStatusSaleByMonth[ (count($commStatusSaleByMonth) - 1)]['increase'] * 100 ;
			}else{
				$info['statusSaleIncreLastYears'] =  '' ;
			}

			//  环比去年出租涨幅
			if(isset($commStatusRentByMonth[11]['increase'])){
				$info['statusRentIncreLastYears'] =  $commStatusRentByMonth[11]['increase'] * 100 ;
			}elseif(isset($commStatusSaleByMonth[ (count($commStatusRentByMonth) - 1)]['increase'])){
				$info['statusRentIncreLastYears'] =  $commStatusRentByMonth[ (count($commStatusRentByMonth) - 1)]['increase'] * 100 ;
			}else{
				$info['statusRentIncreLastYears'] =  '' ;
			}
		}else{
			$info['statusSalePrice'] =  '' ; 	//  环比上月出售均价
			$info['statusRentPrice'] =  '' ; 	//  环比上月出租均价

			$info['statusSaleIncre'] =  '' ;		//  环比上月出售涨幅
			$info['statusRentIncre'] =  '';		//  环比上月出租涨幅

			$info['statusSaleIncreLastYears'] =  '' ; //  环比去年出售涨幅
			$info['statusRentIncreLastYears'] =  '' ; //  环比去年出租涨幅
		}

		foreach($info as $key => $val){
			if(is_float($val) && $val == 0){
				$info[$key] = (int) $val;
			}
		}
//		dd($info);
		return $info;
	}

    /*
     * 判断当前城市所用模板
     */
    private function getModelType($cityId){
        $res = $this->EsfDao->getCityModel($cityId);
        return $res;
    }
}