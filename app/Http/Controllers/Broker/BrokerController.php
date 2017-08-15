<?php
namespace App\Http\Controllers\Broker;


use Auth;
use DB;
use App\Dao\City\CityDao;
use App\Dao\User\BrokerDao;
use App\Dao\Agent\HouseDao;
use App\ListInputView;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Dao\Comment\BrokerUserCommentDao;
use App\MongoDB\BrokerUserComment;
use App\Services\Search;
use App\Http\Controllers\Lists\HouseController;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
use Redirect;
use App\Http\Controllers\Lists\PublicController;
/**
* Description of BrokerController （经济人）
* @author lixiyu
*/
//define('CACHE_TYPE', 'file');
//define('CACHE_REDIS', 'redis');
class BrokerController extends Controller{
	protected $brokerListInput;//接受到的列表筛选数据 对象
	protected $CityDao;
	protected $BrokerDao;
	protected $HouseDao;
	public $data;
	protected  $cityUtil;
	protected $houseController;
	public 		$defaultImage;
	public function __construct(){
		$this->CityDao = new CityDao();
		$this->BrokerDao = new BrokerDao();
		$this->HouseDao = new HouseDao();
		$this->houseController = new HouseController();
		$this->defaultImage = '/image/noImage.png';
		$this->cityUtil = new RedisCacheUtil();
		$this->tagSet = $this->HouseDao->getHouseTag(array());	//获取所有标签
		$GLOBALS['current_url'] = config('session.domain');
		if(!$this->data = unserialize(Cache::store(CACHE_TYPE)->get('businessAreaInfo'))){
			$this->save_BusinessArea();
		}
	}
	/**
	* 经济人列表
	*/
	public function brokerList(){

		$this->brokerListInput = new \App\BrokerInputView();
		//区域信息的展示
		$data = array();
		$public = new PublicController();
		$data['cityarea'] = $public->getCityArea($this->brokerListInput->cityId);
		//$data['business'] = $this->CityDao->selectBusinessArea($this->brokerListInput->cityAreaId);
		//$data['businessAreaH5'] = $public->getBusinessAreaH5($this->brokerListInput->cityId, 5);
//		$py = array();
//		foreach($data['cityarea'] as $key => $val){
//			dd($val);
//			$tmp = ucwords(substr($val->pinyin,0,1));
//			$py[$tmp][] = $val;
//			unset($key);
//			unset($val);
//			unset($tmp);
//		}
//		$data['cityarea'] = $py;
//		unset($py);
		//经济人列表页展示
		$brokerListPageTotal = config('brokerListPageConf.page_total');
		if($this->brokerListInput->page >= $brokerListPageTotal){
			$this->brokerListInput->page = $brokerListPageTotal;
		}
//		$this->brokerListInput->order = 'timeRegister';
//		$this->brokerListInput->asc = 0;
        $this->brokerListInput->orderby = [
            ['hs3'=>'desc'],
            ['timeRegister'=>'desc']
        ];

		$this->brokerListInput->range = ['hs3'=>['lte'=>200, 'gte'=>0]];
		$key='ES_brokerList_'.CURRENT_CITYID.'_cityAreaId_'.Input::get('cityAreaId','').'_page_'.Input::get('page','');
		$config=config('redistime.brokerListOuttime');
		Redis::connect(config('database.redis.default.host'), 6379);
		Redis::select($config['library']);  // 选择8号库
		if(Redis::exists($key)){
			$info=unserialize(Redis::get($key));
		}else{
			$Search = new Search();
			$info = $Search->searchBroker($this->brokerListInput);
			if(!empty($info->hits)){
				Redis::set($key,serialize($info));
				Redis::expire($key,$config['outtime']);
			}
		}
		if(empty($info->hits)){
			$hits = array();
		}else{
			$hits = $info->hits;
		}
		$brokerListDataTotal = config('brokerListPageConf.data_total');
		if($brokerListDataTotal > $hits->total ){
			$brokerListDataTotal = $hits->total;
		}
		$title = '经纪人列表';
		$page = $this->getPages($brokerListDataTotal, $this->brokerListInput->page, 20, 'brokerlist','bklist');

		foreach ($hits->hits as $key=>$value){
			$value = self::getBrokerHouseTotalByRedis($value);
			$value->house = $this->getSale($value->_id, 2, 1,3)->hits;	//二手房源
			if($value->_source->businessHouseCount > 200 || $value->_source->hr3 >200){
				unset($hits->hits[$key]);
			}
//			$value->rentCount = $this->getRent($value->_id, 1, 1,3)->hits->total;	//出租房源
//			$v1 = $this->getSale($value->_id, 1, 1,'')->hits->total;	//所有的出售房源
//			$v2 = $this->getRent($value->_id, 1, 1,'')->hits->total;	//所有的出租房源
//			$value->businessCount = $v1 + $v2 - $value->rentCount - $value->house->total;
		}
		$hotComm = $this->houseController->getHotCommunity();
		$xiaoqu = $this->getOldCommunity();
		//dd($xiaoqu);
		foreach ($xiaoqu as $val){
			$val->cityAreaName = $this->cityUtil->getCityareaNameById($val->_source->cityAreaId);	//添加商圈名称
			$val->businessName = $this->cityUtil->getBussinessNameById($val->_source->businessAreaId);	//添加商圈名称
		}
		//dd($hits);
		return view('broker.brokerList', ['brokerlist'=>$this->brokerListInput,'areaInfo'=>$this->data, 'xiaoqu'=>$xiaoqu, 'cityArea'=>$data['cityarea'], 'hits'=>$hits,'data'=>$data, 'title'=>$title, 'pageBar'=>$page, 'hosturl'=>'/brokerlist', 'hotComm'=>$hotComm, 'defaultImage'=>$this->defaultImage, 'type'=>'broker']);
	}

	/**
	* 经济人详情-》首页
	 * 736106
	*/
	public function brokerInfo($id){
		$data = $this->getUser($id);
		$brokerState = DB::table('users')->where('id',$id)->pluck('state');
		if($brokerState == 0){
			return '该经纪人不存在或未通过审核！';
		}
//		if(isset($data->_source->idcardState) && $data->_source->idcardState != 1){
//			return '该经纪人不存在或未通过审核！';
//		}
		if(!empty($data->_source)){
			if(in_array($data->_source->cityId,config('brokerConfig.cityId')) && $data->_source->idcardState != 1){
				return '该经纪人不存在或未通过审核！';
			}
			$data = self::getBrokerHouseTotalByRedis($data);
		}
		$saleHouse = $this->getSale($id, 6, 1,3)->hits->hits;		//二手房源
		$rentHouse = $this->getRent($id, 6, 1,3)->hits->hits;		//出租房源
		if(!empty($data->_source->hr1)){
			$business = $this->getRent($id, 6, 1,1)->hits->hits;					//获取商铺出租 1.商铺（出租，出售），2 写字楼（出租，出售）
		//	if(!empty($business)) $business->type = 'businessRent';
		}elseif (!empty($data->_source->hs1)){
			$business = $this->getSale($id, 6, 1,1)->hits->hits;					//获取商铺出租 1.商铺（出租，出售），2 写字楼（出租，出售）
			//if(!empty($business)) $business->type = 'businessSale';
		}elseif (!empty($data->_source->hr2)){
			$business = $this->getRent($id, 6, 1,2)->hits->hits;					//获取商铺出租 1.商铺（出租，出售），2 写字楼（出租，出售）
			//if(!empty($business)) { $business['type'] = 'businessRent'; }
		}else{
			$business = $this->getSale($id, 6, 1,2)->hits->hits;					//获取商铺出租 1.商铺（出租，出售），2 写字楼（出租，出售）
			//if(!empty($business)) $business->type = 'businessSale';
		}
		if(!empty($data->_source)){
//			Redis::connect(config('database.redis.default.host'), 6379);
//			$brokerInfoConfig = config('redistime.brokerInfoConfig');
//			Redis::select($brokerInfoConfig['library']);  // 选择6号库
//			$key = $brokerInfoConfig['brokerkey'].$data->_source->id;
//            if(Redis::exists($key)){
//                $redisBroker = json_decode(Redis::get($key));
//                $data->_source->hr1 = isset($redisBroker->hr1) ? $redisBroker->hr1 : $data->_source->hr1;
//                $data->_source->hr2 = isset($redisBroker->hr2) ? $redisBroker->hr2 : $data->_source->hr2;
//                $data->_source->hr3 = isset($redisBroker->hr3) ? $redisBroker->hr3 : $data->_source->hr3;
//                $data->_source->hs1 = isset($redisBroker->hs1) ? $redisBroker->hs1 : $data->_source->hs1;
//                $data->_source->hs2 = isset($redisBroker->hs2) ? $redisBroker->hs2 : $data->_source->hs2;
//                $data->_source->hs3 = isset($redisBroker->hs3) ? $redisBroker->hs3 : $data->_source->hs3;
//				$data->_source->businessHouseCount = $data->_source->hr1 + $data->_source->hr2 + $data->_source->hs1 + $data->_source->hs2;
//            }
			$data->province = $this->cityUtil->getProvinceNameById($data->_source->provinceId);				//获取城市名称
			$data->cityName = $this->cityUtil->getCityNameById($data->_source->cityId);				//获取城市名称
			$data->cityAreaName = $this->cityUtil->getCityareaNameById($data->_source->cityAreaId);	//获取商圈名称
		}

		if(!empty($business)){
			foreach ($business as $k=>$val){
				if(strstr($val->_index, 'rent')){
					$val->type = "businessRent";
				}else{
					$val->type  = "businessSale";
				}
			}
		}

		$community = $this->getCommunity($id);
		if(empty($data->_source->businessHouseCount) && empty($data->_source->hr3) && empty($data->_source->hs3)){
			if(!$data->found){
				return '该经纪人不存在或未通过审核！';
			}
			return view('broker.brokerDetail', ['data' => $data, 'flag' => 1, 'comm'=>$community]);
		}else{
			return view('broker.brokerInfo', ['data'=>$data, 'saleHouse' => $saleHouse, 'rentHouse'=> $rentHouse, 'business'=>$business,  'defaultImage'=>$this->defaultImage, 'comm'=>$community]);

		}

	}

	/**
	 * 获取经纪人的服务楼盘
	 * @param $id
	 * @return array
	 */
	public function getCommunity($id){
		$houseList = new ListInputView();
		$houseList->uid = $id;
		//$houseList->cityId = CURRENT_CITYID;
		$Search = new Search('hs');    //hs housesale  hr houserent
		$total = $Search->searchHouse($houseList)->hits->total;
		if($total > 360){
			$total = 360;
		}
		$houseList->pageset = $total;
		$sale = $Search->searchHouse($houseList)->hits->hits;
		if($total < 360){
			$Search = new Search('hr');
			//$total = $Search->searchHouse($houseList)->hits->total;
			$houseList->pageset = (360 - $total);
			$rent = $Search->searchHouse($houseList)->hits->hits;
		}
		$arr = array();
		$arr1 = array();
		$j = 0;
		$arr2 = array();
		if(isset($sale)){
			foreach ($sale as $item){
				$arr[$j]= $item->_source->communityId;
				if(!empty($item->_source->name)){
					$arr2[$j] = $item->_source->name;
				}elseif(!empty($item->_source->name)){
					$arr2[$j] = $item->_source->tmp_communityId;
				}else{
					$arr2[$j]  = '';
					//$arr2[$j] = $this->cityUtil->getOldCommunityNameById($item->_source->communityId);
				}
				//$arr2[$j] = (string)$this->cityUtil->getOldCommunityNameById($item->_source->communityId);
				//$arr2[$j] = "";
				$j++;
			}
		}

		if(isset($rent)){
			foreach ($rent as $item){
				$arr[$j]= $item->_source->communityId;
				if(!empty($item->_source->name)){
					$arr2[$j] = $item->_source->name;
				}elseif(!empty($item->_source->name)){
					$arr2[$j] = $item->_source->tmp_communityId;
				}else{
					$arr2[$j]  = '';
					//$arr2[$j] = $this->cityUtil->getOldCommunityNameById($item->_source->communityId);
				}
				$j++;
			}
		}
		$resultId = array_count_values($arr);
		//dd($arr2);
		$resultName = array_count_values($arr2);
		//dd($resultId,$resultName);
		foreach ($resultId as $k=>$i){
			foreach ($resultName as $k2=>$i2){
				if($i2 == $i ){
					$arr1[$k]['name']=$k2;
					unset($resultName[$k2]);
					break;
				}else{
					$arr1[$k]['name'] = $this->cityUtil->getOldCommunityNameById($k);
				}
			}
			$arr1[$k]['total']=$i;
		}
		//dd($arr1);
		foreach ($arr1 as $k1=>$v1){
			if($v1['name'] == ''){
				unset($arr1[$k1]);
			}
		}
		return $arr1;

	}

	/**
	 * 经纪人服务楼盘下>的房源
	 * @param $id
	 * @param $communityId
	 * @return mixed
	 */
	public function brokerComm($id, $communityId, $type = ''){
		$data = $this->getUser($id);
		$data = self::getBrokerHouseTotalByRedis($data);
		$pg = Input::get('page', 1);
		$saleData = $this->getCommunitySale($id, $communityId, 1, 1);
		$rentData = $this->getCommunityRent($id, $communityId, 1, 1);
		$saleNum = $saleData->total;
		$rentNum = $rentData->total;
		$pageSize = 15;  // 每页取得数量
		$result = [];  // 获得楼盘名称、城市名称
		if(empty($type)){
			if($rentNum <= 0 && $saleNum > 0){
				$type = 'sale';
			}else{
				$type = 'rent';
			}
		}
		$rent_sale = ($rentNum > 0 && $saleNum > 0) ? true : false;
		if($type == 'sale'){
			$saleHouse = $this->getCommunitySale($id, $communityId, $pageSize, $pg);
			$sure = 's';

			if(!empty($saleHouse->hits[0])){
				$result['cName'] = $this->cityUtil->getCityNameById($saleHouse->hits[0]->_source->cityId);				//添加城市名称
				$result['aName']  = $this->cityUtil->getCityareaNameById($saleHouse->hits[0]->_source->cityareaId);	//添加商圈名称
				$result['bName']  = $this->cityUtil->getBussinessNameById($saleHouse->hits[0]->_source->businessAreaId);	//添加商圈名称
				$result['count'] = $saleHouse->total;
			}
//			else{
//				$rentHouse = $this->getCommunityRent($id, $communityId, 1, $pg);
//				$result['cName'] = $this->cityUtil->getCityNameById($rentHouse->hits[0]->_source->cityId);				//添加城市名称
//				$result['aName']  = $this->cityUtil->getCityareaNameById($rentHouse->hits[0]->_source->cityareaId);	//添加商圈名称
//				$result['bName']  = $this->cityUtil->getBussinessNameById($rentHouse->hits[0]->_source->businessAreaId);	//添加商圈名称
//				$result['count'] = 0;
//			}
			$house = $saleHouse;
			$page = $this->getPages($house->total, $pg, $pageSize,'broker/'.$id.'/comm/'.$communityId. '-sale','bklist');//分页数据的生成
		}
		if($type == 'rent'){
			$rentHouse =  $this->getCommunityRent($id, $communityId, $pageSize, $pg);

			$sure = 'r';

			if(!empty($rentHouse->hits[0])){
				$result['cName'] = $this->cityUtil->getCityNameById($rentHouse->hits[0]->_source->cityId);				//添加城市名称
				$result['aName']  = $this->cityUtil->getCityareaNameById($rentHouse->hits[0]->_source->cityareaId);	//添加商圈名称
				$result['bName']  = $this->cityUtil->getBussinessNameById($rentHouse->hits[0]->_source->businessAreaId);	//添加商圈名称
				$result['count'] = $rentHouse->total;
			}
//			else{
//				$saleHouse = $this->getCommunitySale($id, $communityId, 1, $pg);
//				$result['cName'] = $this->cityUtil->getCityNameById($saleHouse->hits[0]->_source->cityId);				//添加城市名称
//				$result['aName']  = $this->cityUtil->getCityareaNameById($saleHouse->hits[0]->_source->cityareaId);	//添加商圈名称
//				$result['bName']  = $this->cityUtil->getBussinessNameById($saleHouse->hits[0]->_source->businessAreaId);	//添加商圈名称
//				$result['count'] = 0;
//			}
			$house = $rentHouse;

			$page = $this->getPages($house->total, $pg, $pageSize,'broker/'.$id.'/comm/'.$communityId. '-rent','bklist');//分页数据的生成
		}
		$community = $this->getCommunity($id);
		if(!empty($community)){
			foreach ($community as $k=>$item){			//获取楼盘名称
				if($communityId == $k){
					$result['name'] = $item['name'];
				}
			}
		}
		return view('broker.brokerComm', ['data'=>$data, 'comm'=>$community,'tagSet'=>$this->tagSet, 'id'=>$communityId, 'house'=>$house->hits,'sure'=>$sure, 'page'=>$page, 'result'=>$result, 'rent_sale'=>$rent_sale,'defaultImage'=>$this->defaultImage]);
	}

	/**
	 * 获取到经纪人服务楼盘下-》出售房源
	 */
	public function getCommunitySale($id, $communityId, $total, $pg){
		$houseList = new ListInputView();
		$houseList->uid = $id;
		//$houseList->cityId = CURRENT_CITYID;

		$houseList->pageset = $total;
		$houseList->page = $pg;
		$houseList->communityId = $communityId;
		$Search = new Search('hs');				//出售
		$house = $Search->searchHouse($houseList)->hits;

		return $house;
	}
	/**
	 * 获取到经纪人服务楼盘下-》出租房源
	 */
	public function getCommunityRent($id, $communityId, $total, $pg){
		$houseList = new ListInputView();
		$houseList->uid = $id;
		//$houseList->cityId = CURRENT_CITYID;
		$houseList->pageset = $total;
		$houseList->page = $pg;
		$houseList->communityId = $communityId;
		$Search = new Search('hr');				//出售
		$house = $Search->searchHouse($houseList)->hits;
		return $house;
	}
	/**
	 * 获取经济人-》个人信息
	 * @param $id
	 * @return mixed
	 */
	public function brokerDetail($id){
		$data = $this->getUser($id);
		$data = self::getBrokerHouseTotalByRedis($data);
		$community = $this->getCommunity($id);
		if(!empty($data->_source)){
			$data->province = $this->cityUtil->getProvinceNameById($data->_source->provinceId);				//获取城市名称
			$data->cityName = $this->cityUtil->getCityNameById($data->_source->cityId);				//获取城市名称
			$data->cityAreaName = $this->cityUtil->getCityareaNameById($data->_source->cityAreaId);	//获取商圈名称
			$weixin = $this->BrokerDao->getBrokerweixin($id);		//获取经纪人的个性资料信息
			$data->_source->weixin = empty($weixin) ? '' : $weixin;
		}
		$resume = $this->BrokerDao ->getResume($id);	//获取经纪人的工作履历
		//dd($resume);
		$personal = $this->BrokerDao->getPersonal($id);		//获取经纪人的个性资料信息

		return view('broker.brokerDetail', ['data' => $data, 'resume'=>$resume, 'personal'=>$personal, 'comm'=>$community]);
	}

	/**
	 * 获取经纪人-》二手房信息
	 * @param $id 736106
	 * @return mixed
	 */
	public function brokerSecondHouse($id) {
		$data = $this->getUser($id);
		$data = self::getBrokerHouseTotalByRedis($data);
		$community = $this->getCommunity($id);
		$pg = Input::get('page', 1);
		$saleHouse = $this->getSale($id, 15, $pg,3)->hits;

		//dd($saleHouse);
		$page = $this->getPages($saleHouse->total, $pg, 15,'broker/'.$id.'/secondHouse','bklist');//分页数据的生成
		//dd($this->tagSet);
		return view('broker.brokerSecondHouse', ['data' => $data, 'house'=>$saleHouse, 'tagSet'=>$this->tagSet, 'pageBar'=>$page, 'defaultImage'=>$this->defaultImage, 'comm'=>$community]);
	}

	/**
	 * 获取经纪人-》租房信息
	 * @id 736106
	 * @return mixed
	 */
	public function brokerRentHouse($id) {
		$data = $this->getUser($id);
		$data = self::getBrokerHouseTotalByRedis($data);
		$community = $this->getCommunity($id);
		$pg = Input::get('page', 1);
		$rentHouse = $this->getRent($id, 15, $pg,3);
		$page = $this->getPages($rentHouse->hits->total, $pg, 15,'broker/'.$id.'/rentHouse','bklist');//分页数据的生成
		return view('broker.brokerRentHouse', ['data' => $data, 'rentHouse'=>$rentHouse->hits, 'tagSet'=>$this->tagSet, 'pageBar'=>$page, 'defaultImage'=>$this->defaultImage, 'comm'=>$community]);
	}

	/**
	 * 去获取经纪人-》商铺信息
	 * @param $id	经纪人ID 736106
	 * @param $type		房源类型,默认写字楼出租
	 * @return mixed
	 */
	public function brokerBusiness($id, $type=22) {

	$data = $this->getUser($id);		//用户个人信息的获取
		$community = $this->getCommunity($id);
		$pg = Input::get('page', 1);
	if($type == 22){	//写字楼出租
		if($data->_source->hr2 == 0){
			if($data->_source->hs2 != 0){
			return redirect('/broker/'.$id.'/business/21');
			}elseif ($data->_source->hr1 != 0){
				return	redirect('/broker/'.$id.'/business/11');
			}elseif ($data->_source->hs1 != 0){
				return redirect('/broker/'.$id.'/business/12');
			}
		}
		$house = $this->getRent($id, 15, $pg, 2)->hits;
		//dd($house);
		}elseif ($type == 21){	//写字楼出售
		$house = $this->getSale($id, 15, $pg, 2)->hits;

		}elseif ($type == 11){	//商铺出售
		$house = $this->getSale($id, 15, $pg, 1)->hits;
			//dd($house);
		}elseif ($type == 12){	//商铺出租
		$house = $this->getRent($id, 15, $pg, 1)->hits;
			//dd($house);
		}
		$page = $this->getPages($house->total, $pg, 15,'broker/' . $id. '/business/' . $type,'');//分页数据的生成
		return view('broker.brokerBusinessHouse' . $type, ['data' => $data, 'house'=>$house, 'tagSet'=>$this->tagSet, 'pageBar'=>$page, 'defaultImage'=>$this->defaultImage, 'comm'=>$community]);
	}

	/**
	 * 获取该经济人的详情
	 * @param int $id 经济人id
	 */
	public function getUser($id){

		Redis::connect(config('database.redis.default.host'), 6379);
		//$key='ES_getUser_'.CURRENT_CITYID.'_'.$id;
		$key='ES_getUser_'.$id;
		$config=config('redistime.brokerInfoOuttime');
		Redis::select($config['library']);  // 选择7号库
		if(Redis::exists($key)){
			$result=unserialize(Redis::get($key));
		}else{
			$Search = new Search();
			$result=$Search->searchBrokerById($id);
			Redis::set($key,serialize($result));
			Redis::expire($key,$config['outtime']);
		}
//		if($result->found){
//			$result->saleCount = $this->getSale($result->_id, 1, 1,3)->hits->total;	//二手房源
//			$result->rentCount = $this->getRent($result->_id, 1, 1,3)->hits->total;	//出租房源
//			$v1 = $this->getSale($result->_id, 1, 1,'')->hits->total;	//所有的出售房源
//			$v2 = $this->getRent($result->_id, 1, 1,'')->hits->total;	//所有的出租房源
//			$result->businessCount = $v1 + $v2 - $result->rentCount - $result->saleCount;
//		}

		return $result;
	}
	/**
	* 获取页面提交的信息
	*/
	public function getInfo(){
		$info = array();
		$info['id'] = Input::get('uid');
		$info['pagetype'] = Input::get('pagetype') ? Input::get('pagetype') : 'salehouse';
		return $info;
	}
	public function getBusinessCount($id, $pg = 1 ){
		$houseList = new ListInputView();
		$Search = new Search();    //hs housesale  hr houserent
		$houseList->uid = $id;
		$houseList->type1 = 1;		//房源类型 1.商铺 2.写字楼 3.住宅
		$houseList->cityId = CURRENT_CITYID;
		$houseList->pageset = 1;
		$houseList->page = $pg;
		$result= $Search->searchHouse($houseList);

		return $result;
	}

	/**
	* 获取该经济人的出租房源
	* @param int $id 经济人id
	*/
	public function getRent($id, $ps = '10', $pg = 1, $type1 ){
		$houseList = new ListInputView();
		$Search = new Search('hr');    //hs housesale  hr houserent
		$houseList->uid = $id;
		$houseList->type1 = $type1;		//房源类型 1.商铺 2.写字楼 3.住宅
		//$houseList->cityId = CURRENT_CITYID;
		$houseList->pageset = $ps;
		$houseList->page = $pg;
		$houseList->order = 'timeRefresh';
		$houseList->asc = 0;
		$result= $Search->searchHouse($houseList);

		if(!empty($result->hits->hits)){
			foreach($result->hits->hits as $val){
				$val->cityName = $this->cityUtil->getCityNameById($val->_source->cityId);				//添加城市名称
				$val->cityAreaName = $this->cityUtil->getCityareaNameById($val->_source->cityareaId);	//添加商圈名称
				$val->businessName = $this->cityUtil->getBussinessNameById($val->_source->businessAreaId);	//添加商圈名称
			}
		}
        return $result;
	}

	/**
	* 获取该经济人的出售房源
	* @param int $id 经济人id
	*/
	public function getSale($id, $ps = 10, $pg = 1, $type1){

		$houseList = new ListInputView();
		$Search = new Search('hs');    //hs housesale  hr houserent
		$houseList->uid = $id;
		$houseList->type1 = $type1;		//房源类型 1.商铺 2.写字楼 3.住宅
		//$houseList->cityId = CURRENT_CITYID;
		$houseList->pageset = $ps;
		$houseList->order = 'timeRefresh';
		$houseList->asc = 0;
		$houseList->page = $pg;
		$result=$Search->searchHouse($houseList);

		if(!empty($result->hits->hits)){
			foreach($result->hits->hits as $val){
				$val->cityName = $this->cityUtil->getCityNameById($val->_source->cityId);				//添加城市名称
				$val->cityAreaName = $this->cityUtil->getCityareaNameById($val->_source->cityareaId);	//添加商圈名称
				$val->businessName = $this->cityUtil->getBussinessNameById($val->_source->businessAreaId);	//添加商圈名称
			}
		}

        return $result;
	}
	/**
	 * 获取该经济人的出售房源
	 * @param int $id 经济人id
	 */
	public function getXiaoqu(){

		$houseList = new ListInputView();
		$Search = new Search('hs');    //hs housesale  hr houserent
		$houseList->type1 = 3;		//房源类型 1.商铺 2.写字楼 3.住宅
		$houseList->cityId = CURRENT_CITYID;
		$houseList->pageset = 4;
		$result=$Search->searchHouse($houseList);
		return $result;
	}

	public function getOldCommunity(){
//        dd($this->houseType1);
		$tlists = new ListInputView();
		$tlists->isNew = 0;
		$tlists->pageset = 3;
		$tlists->cityId = CURRENT_CITYID;
		$tlists->type1 = 3;
		$tlists->asc = 0;
		$tlists->order = 'timeUpdate';
		$search = new Search();

		/* 获取二手楼盘 */
		$oldComm = $search->searchCommunity($tlists);
		//dd($oldComm);
		if(!empty($oldComm->hits)){
			foreach ( $oldComm->hits->hits as $k => $v) {
				if(empty($v->_source->titleImage)){
					$v->_source->titleImage = '';
				}
				$v->_source->type1 = 3;
				$v->_source->priceAverg = 'priceSaleAvg'. 3;
			}
			$oldComm = $oldComm->hits->hits;
		}else{
			$oldComm = '';
		}
		return $oldComm;
	}

	/**
	* 根据经纪人id获取经纪人评论相关数据
	* @param	int		$id			经纪人id
	*/
	public function getComment($id){
		$CommentDao = new BrokerUserCommentDao();
		$range = Input::get('range','1');
		$comment = array();
		$comment['hits'] = $CommentDao->getComment($id, $range);
		$comment['good'] = $CommentDao->getComment($id, 1)->total();
		$comment['mid'] = $CommentDao->getComment($id, 2)->total();
		$comment['bad'] = $CommentDao->getComment($id, 3)->total();
		$user = array();
		foreach( $comment['hits']->items() as $key => $val){
			$user[] = $val->uId;
		}
		$user = $this->BrokerDao->getCommentUser($user);
		foreach( $comment['hits']->items() as $key =>$val){
			foreach($user as $uk => $uv){
				if($val->uId == $uv->id){
					$val->uname = $uv->realName;
				}
			}
			$comment['hits']->items()[$key] = $val;
		}
		return $comment;
	}

	/**
	* 列表分页
	* @param $count 总条目 
	* @param $curr 当前页码
	* @param $num  每页条目
	 * @param 连接路由地址
	* @param $classname  为每一个按钮赋一个类名 便于区别， 可以传多个，用空格分开
	*/
	public function getPages($count, $curr, $num=20, $href='brokerlist', $classname = ''){
		$pageAll = (int)ceil($count / $num); //总页数
		//dd($count, $curr,$pageAll, $num);
		if($pageAll > 200){
			$pageAll = 200;
		}
		if($curr > $pageAll || $curr < 1){
			$curr = 1;
		}
		$left = max($curr-2, 1);//最左边页码
		$right = min($left+4, $pageAll);//获取最右边页码
		$left = max($right-4, 1);//最终的左边页码
		$first = 1;
		$end = $pageAll;
		if($pageAll > 1){
			$pageBar = '<li><a class=" '.$classname.' " value="'. $first .'" href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$first.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'" >首页</a></li>';
			if($curr != 1){
				$pageBar .= '<li><a class=" '.$classname.' " value="'. ($curr-1) .' " href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='. ($curr-1).'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">上一页</a></li>';
			}
			if( ($left-$first) > 1){
				$pageBar .= '<li><a class=" '.$classname.' " value="'. $first.' " href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$first.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">'. $first .'</a></li>';
				$pageBar .= '<li>.....</li>';
                        }else if(($left-$first) == 1){
                            $pageBar .= '<li><a class=" '.$classname.' " value="'. $first.' " href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$first.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">'. $first .'</a></li>';
                        }
			for($i = $left; $i <= $right; $i++){
				if($i == $curr){
					$pageBar .= '<li><a class="click '.$classname.' " value="'. $i .' " href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$i.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">'. $i .'</a></li>';
				}else{
					$pageBar .= '<li><a class=" '.$classname.' " value="'. $i .'" href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$i.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">'. $i .'</a></li>';
				}
			}
			if( ($pageAll-$right) > 1){
				$pageBar .= '<li>.....</li>';
				$pageBar .= '<li><a class=" '.$classname.' " value="'. $pageAll .'" href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$pageAll.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">'. $pageAll .'</a></li>';
			}else if(($pageAll-$right) == 1){
                            $pageBar .= '<li><a class=" '.$classname.' " value="'. $pageAll .'" href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$pageAll.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">'. $pageAll .'</a></li>';
                        }
			
			if($curr < $pageAll){
				$pageBar .= '<li><a class=" '.$classname.' " value="'. ($curr+1) .'" href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.($curr+1).'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">下一页</a></li>';
			}
			$pageBar .= '<li><a class=" '.$classname.' " value="'. $pageAll .'" href="/' . $href .'?'.(!empty(Input::get('cityAreaId'))?('cityAreaId='.Input::get('cityAreaId').'&'):'').'page='.$pageAll.'&'.(!empty(Input::get('keyword'))?('keyword='.Input::get('keyword')):'').'">尾页</a></li>';
		}else{
			$pageBar = '';
		}
		return $pageBar;
	}


	/**
	* 给经济人留言
	* @author lixiyu
	*/
	public function sendMsg(){
		$data['brokerId'] = Input::get('id');
		$data['senderName'] =htmlspecialchars(Input::get('uname'));
		// name.value=="" || reg.test(name.value)  /^\s*$/
		$data['senderName'] = str_replace(' ', '', $data['senderName']);
		if( strlen($data['senderName']) == 0){
			return 0;				//过滤留言人姓名
		}
		$data['message'] = htmlspecialchars(Input::get('msg'));
		$data['message'] = str_replace(' ', '', $data['message']);
		if(strlen($data['message']) == 0 ){
			return 0;			//过滤留言信息
		}
		$data['senderPhone'] = Input::get('phone');
		if(!preg_match('/^1[3578]\d{9}$/', $data['senderPhone'])){
			return 0;			//过滤留言人电话信息
		}
		$flag = $this->BrokerDao->insertMsg($data);
		if($flag) return 1;
		return 0;
	}


	/**
	* 处理房源分组
	* @param obj $house  房源对象
	* @param int $type 1 为出租 2 为出售 默认为0
	*/
	public function houseGroup($house, $type = 0){
		$house = $house->hits->hits;
		if($type == 2){
			$type = 'Sale';
		}else if($type == 1){
			$type = 'Rent';
		}
		$houseList = array(); 	// 记录房源列表信息
		$priceInfo = array();	// 记录楼盘的均价和涨幅
		foreach($house  as $key => $val){
			$houseList[$val->_source->communityId][] = $val->_source;
		}
		unset($house);
		$communityId = array_keys($houseList);
		$search = new Search();
		$communityTemp = $search->searchCommunityListByIds($communityId);
		$communityList = array();
		if(empty($communityTemp->error)){
			foreach( $communityTemp->docs  as $key => $val){
				if(empty($val->found)) continue;
				$val = $val->_source;
				$val->list = $houseList[$val->id];
				$type2 = explode('|', $val->type2);
				$type2 =  array_unique($type2); // 去重type2
				$val->type2 = implode('|', $type2);
				$priceType = array();  // 记录不同物业类型的价格
				$keyTemp   = null;     // 记录一个临时的价格的键 最终记录价格中最低的键
				foreach($type2 as $tval){
					if(!empty($val->{'price'.$type.'Avg'.$tval})){
						$priceType[$tval] = $val->{'price'.$type.'Avg'.$tval};
						if($keyTemp === null){
							$keyTemp = $tval;
						}else{
							if($priceType[$keyTemp] > $priceType[$tval]){
								$keyTemp = $tval;
							}
						}
					}
				}
				$val->houseType2 = $tval;
				if($keyTemp !== null){
					$val->avgPrice = $val->{'price'.$type.'Avg'.$keyTemp}; // 记录最终选定的均价
					$val->incPrice = $val->{'price'.$type.'Inc'.$keyTemp}; // 记录最终选定的涨幅
				}
				$communityList[$key] = $val;
			}
		}
//		dd($communityList);
		return $communityList;

	}

	/**
	* ajax加载更多房源
	*/
	public function loadMore(){
		$cid = Input::get('cid'); // 楼盘id
		$bid = Input::get('bid'); // 经纪人id
		$ptp = Input::get('ptp'); // pagetype   sale or rent
		if(empty($cid) || empty($bid) || empty($ptp)){
			return 0;
		}
		$start = Input::get('count'); // 当前该楼盘房源已经加载的总数
		$end = $start + 8;
		if($ptp == 'renthouse'){
			$info = $this->getRent($bid);
			$ptp  = '1';
		}else if($ptp == 'salehouse'){
			$info = $this->getSale($bid);
			$ptp  = '2';
		}else{
			return 0;
		}

		$info = $this->houseGroup($info);
		foreach($info as $val){
			if($cid == $val->id){
				$info = $val->list;
				break;
			}
		}
		if(empty($info)) return 0;
		foreach($info as $key => $val){
			if($ptp == '2'){
				$imageType = 'houseSale';
			}else if($ptp == '1'){
				$imageType = 'houseRent';
			}
			if(!empty($imageType)){
				$val->thumbPic = get_img_url($imageType, $val->thumbPic, 1);
				if(!empty($val->imageList)){
					foreach($val->imageList as $imgK => $imgV){
						$val->imageList[$imgK] = get_img_url($imageType, $imgV, 1);
					}
				}
			}
			$info[$key] = $val;
		}
		$count = count($info);
		$endKey = $count <= $end ? $count : $end;
		$data = [];
		for($i = $start; $i < $endKey; $i++){
			$data[] = $info[$i];
		}
		$res = array();
		$res['data'] = $data;
		$res['ptp']  = $ptp;
		$res['priceType'] = config('brokerHousePriceType');
		$res['faceTo'] = config('faceToConfig');
		return $res;
	}


	/**
	* 给经纪人评论页面
	*/
	public function commentAngent(){
		if(!Auth::check()){
			return Redirect::to('/');
		}else{
			$data['userId'] = Auth::user()->id;
		}
		$data['brokerId'] = Input::get('id');
		return view('broker.commentangent', ['title'=>'楼盘详情-点评', 'data'=>$data]);
	}

	/**
	* 提交经纪人评论信息
	*/
	public function brokerComment(){
		$brokerId = Input::get('brokerid');
		$uId = Input::get('userid');
		$scoreAttitude = Input::get('attitude');
		$scoreSkill = Input::get('skill');
		$scoreProfession = Input::get('profession');
		$score = Input::get('score');
		$comment = Input::get('content');
		
		$CommentDao = new BrokerUserCommentDao();
		$CommentDao->insertComment($brokerId, $uId, $scoreAttitude, $scoreSkill, $scoreProfession, $score, $comment);
		return Redirect::to('/brokerinfo?uid='.$brokerId.'&pagetype=comment');
	}

	/***************************************************************************************************************************
	*   内部方法
	****************************************************************************************************************************/

	// 储存 商圈列表
	protected function save_BusinessArea(){
		$data = DB::connection('mysql_house')->table('businessarea')->get();
		foreach( $data as $val){
			$this->data[$val->id] = $val->name;
		}
		Cache::store(CACHE_TYPE)->put('businessAreaInfo', serialize($this->data), 1440 * 7);
	}

	/**
	 * 根据经纪人绑定楼盘信息获取对应经纪人数据（仅限增量楼盘）
	 * @param	int		$communityId		楼盘id
	 * @param	array	$brokerIds			经纪人id数组
	 * @return	obj
	 */
	/* public static function getBrokerByBinding($communityId, $brokerId=''){
		$brokerDao = new BrokerDao();
		$brokerObj = $brokerDao->getBrokerByBinding($communityId, $brokerId);
		return $brokerObj;
	} */
	/**
	 * 从redis取经纪人统计的房源数
	 * @param $data
	 */
	private function getBrokerHouseTotalByRedis($data){
		Redis::connect(config('database.redis.default.host'), 6379);
		$brokerInfoConfig = config('redistime.brokerInfoConfig');
		Redis::select($brokerInfoConfig['library']);  // 选择6号库
		$key = $brokerInfoConfig['brokerkey'].$data->_source->id;
		if(Redis::exists($key)){
			$redisBroker = json_decode(Redis::get($key));
			$data->_source->hr1 = isset($redisBroker->hr1) ? $redisBroker->hr1 : $data->_source->hr1;
			$data->_source->hr2 = isset($redisBroker->hr2) ? $redisBroker->hr2 : $data->_source->hr2;
			$data->_source->hr3 = isset($redisBroker->hr3) ? $redisBroker->hr3 : $data->_source->hr3;
			$data->_source->hs1 = isset($redisBroker->hs1) ? $redisBroker->hs1 : $data->_source->hs1;
			$data->_source->hs2 = isset($redisBroker->hs2) ? $redisBroker->hs2 : $data->_source->hs2;
			$data->_source->hs3 = isset($redisBroker->hs3) ? $redisBroker->hs3 : $data->_source->hs3;
			$data->_source->businessHouseCount = $data->_source->hr1 + $data->_source->hr2 + $data->_source->hs1 + $data->_source->hs2;
		}
		return $data;
	}
}
