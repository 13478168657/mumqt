<?php
namespace App\Http\Controllers\Lists;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Services\Search;
use App\ListInputView;
use App\Dao\Agent\HouseDao;
use Cookie;
use Auth;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Cache;
use Session;
use App\Http\Controllers\Utils\ValidateUtil;

if(!defined('CACHE_TYPE'))          define('CACHE_TYPE','redis');
if(!defined('CACHE_TIME'))          define('CACHE_TIME',60*24*30);  // 60分 x 24时 x 30天
/**
 * Description of HouseDetailController （各房源楼盘的搜索列表）
 * @package App\Http\Controllers\Lists
 */
class HouseDetailController extends Controller{
	public $house;                  //房源数据库类
	public $public;                       //列表公共类对象
	public $paymentTypes;        //支付数组
	public $faces;               //朝向
	public $fitmentSale;            //装修 出售
	public $fitmentRent;            //装修 出租
	public $trades;             //房屋商铺目标业务
	public $saleequipments;          //住宅出售配套设施
	public $rentequipments;          //住宅出租配套设施
	public $type2;              //房源类型2
	public $officeLevel;        //写字楼等级
	public $rentType;            //租住方式
	public $stateShop;            //商铺状态
	public $pageset = 5;
	public $page = 1;

	public function __construct(){
		//RedisCacheUtil::wholeCacheInit();//缓存
		$this->house = new HouseDao();
		$this->public = new PublicController();
		//取cookie  城市id 城市名称
//		$py = explode('.',$_SERVER['HTTP_HOST']);
//		$py = $py[0];
//		$cityInfo = $this->house->getCityByPy($py);
//		$this->cityId = !empty($cityInfo->id)?$cityInfo->id:1;
//		$this->cityName = !empty($cityInfo->name)?$cityInfo->name:'北京';
//		$this->longitude = !empty($cityInfo->longitude)?$cityInfo->longitude:0;
//		$this->latitude = !empty($cityInfo->latitude)?$cityInfo->latitude:0;
		$this->cityId = !empty(CURRENT_CITYID)?CURRENT_CITYID:1;
		$this->cityName = !empty(CURRENT_CITYNAME)?CURRENT_CITYNAME:'北京';
		$this->longitude = !empty(CURRENT_LNG)?CURRENT_LNG:0;
		$this->latitude = !empty(CURRENT_LAT)?CURRENT_LAT:0;
		$this->pageset = 5;
		$this->page = Input::get('page',1);
		//支付方式
		$this->paymentTypes = array(1=>'押一付三',2=>'押一付二',3=>'押一付一',4=>'押二付一',5=>'押二付二',6=>'押二付三',7=>'押三付一',8=>'押三付三',9=>'半年付',10=>'年付',11=>'面议');
		//朝向
		$this->faces = config('conditionConfig.toward.text');//朝向
		//装修
		$this->fitmentSale = array(1=>'毛坯',2=>'简装',3=>'中装修',4=>'精装修',5=>'豪华装修');
		$this->fitmentRent = array(1=>'毛坯',2=>'简装',3=>'中装修',4=>'精装修',5=>'豪华装修');
		//商铺目标业务
		$this->trades = config('conditionConfig.spind.text');

		//出售/出租配套设施
		$this->saleequipments = array(1=>'集中供暖',2=>'自采暖',3=>'煤气/天然气',4=>'车位/车库',5=>'电梯',6=>'储藏室/地下室',7=>'花园/小院',8=>'阳台/露台',9=>'阁楼');
		$this->rentequipments = array(1=>'拎包入住',2=>'家电齐全',3=>'可上网',4=>'可做饭',5=>'可洗澡',6=>'空调房',7=>'可看电视',8=>'有暖气',9=>'车位');
		//房源类型2
		$this->type2 = array(3=>array(301=>'普宅',302=>'经济适用房',303=>'商住楼',304=>'别墅',305=>'豪宅',306=>'平房',307=>'四合院'),
			2=>array(201=>'纯写字楼',303=>'商住楼',203=>'商业综合体楼',204=>'酒店写字楼'),
			1=>array(101=>'住宅底商',102=>'商业街商铺',103=>'临街商铺',104=>'写字楼底商',105=>'购物中心商铺',106=>'其他'),
			4=>array(401=>'其它',402=>'其它'));
		$this->officeLevel = config('conditionConfig.officeLevel.text'); //写字楼等级
		$this->rentType = config('conditionConfig.rentway.text'); //租住方式
		$this->stateShop = [0=>'营业中',1=>'闲置中',2=>'新铺']; //商铺状态
	}

	/**
	 * 二手房源详情页面
	 * @param $subtype sale:出售 rent:出租
	 * @param $id 房源id
	 * @return int
	 */
	public function oldHouseDetail($subtype,$id){
		//接口
		$data['type'] = '';
		$data['class'] = $subtype; //租 售
		if($subtype == 'sale'){
			$data['housing'] = 'SFSS';
		}else{
			$data['housing'] = 'SFSR';
		}
		$data['detailBool'] = true; //代表是内容详情页
		$data['cityName'] = $this->cityName;//城市名
		if (!empty($this->cityId)) {
			$this->cityArea = $this->public->getCityArea($this->cityId);
            /* 判断模板类型 */
            $admodel = $this->getModelType($this->cityId);
            if(empty($admodel)){
                $admodel = new \stdClass();
                $admodel->modelId = 1;
            }
            $data['admodels'] = $admodel;
		}else{
            $admodel = new \stdClass();
            $admodel->modelId = 1;
            $data['admodels'] = $admodel;
        }

		$data['cityArea'] = $this->cityArea;
		$data['businessAreaH5'] = $this->public->getBusinessAreaH5($this->cityId,$this->cityArea);
		if($subtype == 'sale'){
			$data['sr'] = $sr = 's';//说明是出租还是出售
			$search = new Search('hs');
			$data['objectType'] = 'houseSale';
			$data['equipments'] = $this->saleequipments;
			$table = 'housesale';
			$imgtable = 'housesaleimage';
			$dealState = 2;
			$data['fitments'] = $this->fitmentSale;
		}else{
			$data['sr'] = $sr = 'r';
			$search = new Search('hr');
			$data['objectType'] = 'houseRent';
			$data['equipments'] = $this->rentequipments;
			$imgtable = 'houserentimage';
			$table = 'houserent';
			$dealState = 1;
			$data['fitments'] = $this->fitmentRent;
		}
		//dd($this->oldHouseExpired($subtype,$table,$imgtable,$id));
		//从索引中获取房源数据
		//Cache::store('redis')->pull('esf_searchHouseById'.$id);
		$result = $search->searchHouseById($id);

		if(!empty($result->found)){ //有数据时
			//获取经纪人的服务商圈和主营业务
			$search = new Search();
			if(!empty($result->_source->publishUserType) && ($result->_source->publishUserType == 1)){
				$brokeruid = $search->searchBrokerById($result->_source->uid);
				//dd($brokeruid);
				if(!empty($brokeruid->found)){
					//经纪人的信息
					$data['brokers'] =$brokeruid->_source;
					//获取服务商圈
					$brokerBusiness = array();
					$managebus = !empty($brokeruid->_source->managebusinessAreaIds)?$brokeruid->_source->managebusinessAreaIds:'';
					if(!empty($managebus)){
						foreach(explode('|',$managebus) as $k=>$v){
							if(!empty(RedisCacheUtil::getBussinessNameById($v))){
								array_push($brokerBusiness,RedisCacheUtil::getBussinessNameById($v));
								if(count($brokerBusiness) == 1) break;
							}
						}
					}
					$data['brokerBusiness'] = $brokerBusiness;;
					//获取主营业务
					$configBus = config('mianBusiness');
					$mainbusiness = !empty($brokeruid->_source->mainbusiness)?$brokeruid->_source->mainbusiness:'';
					$brokerBus = array();
					if(!empty($mainbusiness)){
						foreach(explode('|',$mainbusiness) as $v){
							if(!empty($configBus[$v])){
								array_push($brokerBus,$configBus[$v]);
								if(count($brokerBus) == 2) break;
							}
						}
						$data['brokerBus'] = $brokerBus;
					}
					//经纪人所属公司名称
					$data['brokercompanyname'] = $brokeruid->_source->company;
				}
			}

			//标题title
			$data['title'] = $result->_source->title;
			$house = $result->_source;
			//获取房源图片
			$imageList = array();
			if(!empty($house->imageList)){
				$imageList = $house->imageList;
				foreach($imageList as $k=>$image){
					if(($image == $house->thumbPic) || empty($image)){
						unset($imageList[$k]);
					}
				}
				array_unshift($imageList,$house->thumbPic);
			}
			//$data['houseImages'] = $this->house->getHouseImageById($imgtable,$id);
			$data['houseImages'] = $imageList;
			$data['imageCount'] = count($imageList);
			//房源描述
			if(!empty($house->describe)){
				$house->describe = htmlspecialchars_decode($house->describe);
				$house->describe = preg_replace("/1\d{10}/","",$house->describe);//去除手机号
				$house->describe = preg_replace("/<a[^>]*>(.*)<\/a>/is","",$house->describe);//去除a标签
				$house->describe = preg_replace("/<script[^>]*?>[\s\S]*?<\/script>/is","",$house->describe);//去除js标签
				$house->describe = preg_replace("/(https?:\/\/)?www(.*?)(\.)(cn|com|net|org|edu)/is","",$house->describe);//去除明文地址
				$house->describe = $this->closetags($house->describe);//补全html代码
			}
			$data['house'] = $house;
			//经纪人的成交数量
			//$data['dealStateSum'] = $this->brokerDealCount($result->_source->uid);

			//楼盘名称
			$data['communityName'] = !empty($house->name)?$house->name:'';
			//获取该房源 小区的成交记录
//			$dealwhere = array('communityId'=>$result->_source->communityId,'dealState'=>$dealState);
//			$dealStates = $this->house->getDealState($table,$dealwhere,$this->pageset,$this->page);

			if(!empty($house->cityareaId)){
				$data['cityAreaName'] = RedisCacheUtil::getCityAreaNameById($house->cityareaId);
			}
			if(!empty($house->businessAreaId)){
				$data['businessAreaName'] = RedisCacheUtil::getBussinessNameById($house->businessAreaId);
			}
			//数字转中文 (几居)
			if(!empty($house->roomStr)){
				$data['houseRoom'] = $this->roomTurnZh($house->roomStr);
			}
			//获取周边楼盘相似房源
			$lat = $result->_source->latitude;
			$lng = $result->_source->longitude;
			$lists = new ListInputView();
			$lnglat = $this->returnSquarePoint($lng,$lat,$distance = 5);
			$data['lnglat'] = http_build_query($lnglat);
			$lists->swlng = $lnglat['swlng'];
			$lists->swlat = $lnglat['swlat'];
			$lists->nelng = $lnglat['nelng'];
			$lists->nelat = $lnglat['nelat'];
			$lists->type1 = !empty($house->houseType1)?$house->houseType1:3;
			if(($house->houseType2 == 304) || ($house->houseType2 == 305)){
				$lists->type2 = '304 305';
			}
			$lists->pageset = 5;
			$lists->cityId = $result->_source->cityId;
			$lists->must_not = [['communityId'=>$house->communityId]];
			if($subtype == 'sale'){
				$search = new Search('hs');
			}else{
				$search = new Search('hr');
			}
            $surround= $search->searchHouse($lists);

			if(!isset($surround->error)&&!empty($surround)){
				$data['surrounds'] = $surround->hits->hits;
			}else{
				$data['surrounds'] = '';
			}
			$urlTag='esf';
			if ($house->houseType1==3) {
				$urlTag='esf';
			}elseif ($house->houseType1==2) {
				$urlTag='xzl';
			}elseif ($house->houseType1==1) {
				$urlTag='sp';
			}
			$data['houseUrlHost']=$urlTag;

			//判断属于何种房源类型
			$lists = new ListInputView();
			if(!empty($houseType1 = $house->houseType1)){
				$data['housety'] = $houseType1;
				if($houseType1 == 1){
					$data['type'] = 'sp'.$subtype;
					$data['houseUrl'] = '/sp'.$subtype.'/area';//位置链接
				}elseif($houseType1 == 2){
					$data['type'] = 'xzl'.$subtype;
					$data['houseUrl'] = '/xzl'.$subtype.'/area';
				}else{
					if(($house->houseType2 == 304) || ($house->houseType2 == 305)){
						$data['type'] = 'bs'.$subtype;
						$data['houseUrl'] = '/bs'.$subtype.'/area';
					}else{
						$data['type'] = 'esf'.$subtype;
						$data['houseUrl'] = '/esf'.$subtype.'/area';
					}
					if(!empty($house->roomStr)){ //获取房源是几居
						$lists->houseRoom = substr($house->roomStr,0,1);
					}
				}
				//如果用户登录,等获取该用户的关注房源或者楼盘表
				if(!empty(Auth::id())){
					$interest['uid'] = Auth::id();
					if($subtype == 'sale'){
						$tableType = 2;
					}else{
						$tableType = 1;
					}
					$interest['tableType'] =  $tableType;
					$interest['type1'] = $houseType1;
					$interest['isNew'] = 0;
					$interest['is_del'] = 0;
					$data['interest'] = $this->house->getInterestByUid($interest);
				}
			}
			//房源标签
			$wheretag = array('type'=>4,'propertyType1'=>$house->houseType1);
			$data['tags'] = $this->house->getHouseTag($wheretag);
			if(!empty($house->diyTagId)){
				$dtIds = explode('|',$house->diyTagId);
				$diyTagIds = $this->house->getDiyTagByIds($dtIds);
				if(!empty($diyTagIds)){
					$data['diyTagIds'] = $this->public->conversion($diyTagIds);
				}
			}
			$data['paymentTypes'] = $this->paymentTypes;
			$data['faces'] = $this->faces;
			$data['trades'] = $this->trades;

			$data['officeLevels'] = $this->officeLevel;
			$data['rentTypes'] = $this->rentType;
			$data['stateShops'] = $this->stateShop;
			$data['type2'] = $this->type2;
			//获取本楼盘推荐房源
			$lists->cityId = $house->cityId;
			$lists->communityId = $house->communityId;
			$lists->type1 = $house->houseType1;
			if(($house->houseType2 == 304) || ($house->houseType2 == 305)){
				$lists->type2 = '304 305';
			}
			$lists->must_not = [['id'=>$house->id]];
			$lists->pageset = 5;
			$recommend = $search->searchHouse($lists);
			if(!isset($recommend->error)&&!empty($recommend)){
				$data['recommends'] = $recommend->hits->hits;
			}else{
				$data['recommends'] = '';
			}
		}elseif(!empty($chahouse = $this->oldHouseExpired($subtype,$table,$imgtable,$id))){
			$data = array_merge($data,$chahouse);
		}else{
			return '无此房源';
		}
		//推荐房源
		if(!empty($data['house']->uid)){
			$data['otherHouses'] = $this->returnOtherHouseByuId($sr,$data['house']->uid,$data['house']->houseType1,$id);
		}
		$data['priceSaleAvg'] = 'priceSaleAvg'.$data['house']->houseType1;
		//新房推荐
		if(!empty($data['house']->houseType1)){
			$data['newBuilds'] = $this->returnNewBuild($data['house']->cityId,$data['house']->houseType1);
		}

		if((isset($data['house']->longitude)&&isset($data['house']->longitude))&&(empty($data['house']->longitude) || empty($data['house']->latitude))){
			$data['house']->longitude = $this->longitude;
			$data['house']->latitude = $this->latitude;
		}
		$GLOBALS['current_listurl'] = config('session.domain').$data['houseUrl'];
                
                if (USER_AGENT_MOBILE) {        
                    $houseType2 = $data['house']->houseType2;
                     $t2 = substr($houseType2, 0, 1) ;
                    if($t2 == 3){
                            $data['saleUrl'] = 'esfsale'; 
                            $data['rentUrl'] = 'esfrent';
                    } else if($t2 == 2){
                            $data['saleUrl'] = 'xzlsale'; 
                            $data['rentUrl'] = 'xzlrent';
                    } else if($t2 == 1){
                            $data['saleUrl'] = 'spsale'; 
                            $data['rentUrl'] = 'sprent';
                    }else{
                        $data['saleUrl'] = 'esfsale'; 
                        $data['rentUrl'] = 'esfrent';
                    }
                    $list = new ListInputView();
                    if(!empty($result->found)){
                        $list->communityId = $result->_source->communityId;                        
                        $data['communityId'] = $result->_source->communityId;
                    }
                    $list->type1 = substr($houseType2, 0 , 1);  
                    //$list->type2 = $houseType2;
                    $list->cityId = CURRENT_CITYID;
                    //查询小区二手房套数
                    $search = new Search('hs');
                    $houseSaleData = $search->searchHouse($list);                    
                    if(empty($houseSaleData->error)){
                        $data['houseSaleData'] = $houseSaleData->hits;
                    }else{
                        $data['houseSaleData'] = '';
                    }
                    $data['houseType2'] = $houseType2;
                    //查询小区出租房套数
                    $search = new Search('hr');
                    $houseRentData = $search->searchHouse($list);
                    if(empty($houseRentData->error)){
                        $data['houseRentData'] = $houseRentData->hits;
                    }else{
                        $data['houseRentData'] = '';
                    }
                    return view('h5.list.oldHouseDetail',$data);                   
                }
		return view('list.oldHouseDetail',$data);
	}

	//过期后的房源详情
	public function oldHouseExpired($subtype,$table,$imgtable,$id){
		//获取房源信息
		$house = $this->house->getOldHouseById($table,$id);
		if(!empty($house)){
			if(!empty($house->describe)){
				$house->describe = htmlspecialchars_decode($house->describe);
				$house->describe = preg_replace("/1\d{10}/","",$house->describe);//去除手机号
				$house->describe = preg_replace("/<a[^>]*>(.*)<\/a>/is","",$house->describe);//去除a标签
				$house->describe = preg_replace("/<script[^>]*?>[\s\S]*?<\/script>/is","",$house->describe);//去除js标签
				$house->describe = preg_replace("/(https?:\/\/)?www(.*?)(\.)(cn|com|net|org|edu)/is","",$house->describe);//去除明文地址
				$house->describe = $this->closetags($house->describe);//补全html代码
			}

			//获取房源图片
			$data['houseImages'] = $this->house->getHouseImageById($imgtable,$id);
			$data['imageCount'] = count($data['houseImages']);
			if($house->publishUserType == 1){
				//获取经纪人的服务商圈和主营业务
				$select = ['id','realName','photo','mobile','mainbusiness','managebusinessAreaIds','company','nameCardState','idcardState'];
				$data['brokers'] = $brokerMessage = $this->house->getBrokerByuid($house->uid,$select);//$houseExpired->uid
				if(!empty($brokerMessage)){
					//获取服务商圈
					$brokerBusiness = array();
					$managebus = !empty($brokerMessage->managebusinessAreaIds)?$brokerMessage->managebusinessAreaIds:'';
					if(!empty($managebus)){
						foreach(explode('|',$managebus) as $k=>$v){
							if(!empty(RedisCacheUtil::getBussinessNameById($v))){
								array_push($brokerBusiness,RedisCacheUtil::getBussinessNameById($v));
								if(count($brokerBusiness) == 1) break;
							}
						}
						$data['brokerBusiness'] = $brokerBusiness;
					}

					//获取主营业务
					$configBus = \Config::get('mianBusiness');
					$mainbusiness = !empty($brokerMessage->mainbusiness)?$brokerMessage->mainbusiness:'';
					$brokerBus = array();
					if(!empty($mainbusiness)){
						foreach(explode('|',$mainbusiness) as $v){
							if(!empty($configBus[$v])){
								array_push($brokerBus,$configBus[$v]);
								if(count($brokerBus) == 2) break;
							}
						}
						$data['brokerBus'] = $brokerBus;
					}
					//经纪人所属公司名称
					$data['brokercompanyname'] = $brokerMessage->company;
				}
			}

			//标题title
			$data['title'] = $house->title;

			//经纪人的成交数量
			//$data['dealStateSum'] = $this->brokerDealCount($house->uid);

			//楼盘名称
			$select = ['id','name','longitude','latitude','enterpriseshopId','address'];
			$OldCommunity = $this->house->getOldCommunityById($house->communityId,$select);
			if(!empty($OldCommunity)){
				$data['communityName'] = $OldCommunity->name;
				$longitude = $OldCommunity->longitude;
				$latitude = $OldCommunity->latitude;
				$house->name = $OldCommunity->name;
				$house->address = $OldCommunity->address;
			}else{
				$data['communityName'] = '';
			}
			$data['house'] = $house;
			if(!empty($house->cityareaId)){
				$data['cityAreaName'] = RedisCacheUtil::getCityAreaNameById($house->cityareaId);
			}
			if(!empty($house->businessAreaId)){
				$data['businessAreaName'] = RedisCacheUtil::getBussinessNameById($house->businessAreaId);
			}
			//数字转中文 (几居)
			if(!empty($house->roomStr)){
				$data['houseRoom'] = $this->roomTurnZh($house->roomStr);
			}
			//获取周边楼盘相似房源
			$lat = !empty($latitude)?$latitude:0;
			$lng = !empty($longitude)?$longitude:0;
			$lists = new ListInputView();
			$lnglat = $this->returnSquarePoint($lng,$lat,$distance = 3);
			$data['lnglat'] = http_build_query($lnglat);
			$lists->swlng = $lnglat['swlng'];
			$lists->swlat = $lnglat['swlat'];
			$lists->nelng = $lnglat['nelng'];
			$lists->nelat = $lnglat['nelat'];
			$lists->type1 = !empty($house->houseType1)?$house->houseType1:3;
			if(($house->houseType2 == 304) || ($house->houseType2 == 305)){
				$lists->type2 = '304 305';
			}
			$lists->pageset = 5;
			$lists->cityId = $house->cityId;
			$lists->must_not = [['communityId'=>$house->communityId]];
			if($subtype == 'sale'){
				$search = new Search('hs');
			}else{
				$search = new Search('hr');
			}
			$surround= $search->searchHouse($lists);
			if(!isset($surround->error)&&!empty($surround)){
				$data['surrounds'] = $surround->hits->hits;
			}else{
				$data['surrounds'] = '';
			}
			$urlTag='esf';
			if ($house->houseType1==3) {
				$urlTag='esf';
			}elseif ($house->houseType1==2) {
				$urlTag='xzl';
			}elseif ($house->houseType1==1) {
				$urlTag='sp';
			}
			$data['houseUrlHost']=$urlTag;
			//判断属于何种房源类型
			$lists = new ListInputView();
			if(!empty($houseType1 = $house->houseType1)){
				$data['housety'] = $houseType1;
				if($houseType1 == 1){
					$data['type'] = 'sp'.$subtype;
					$data['houseUrl'] = '/sp'.$subtype.'/area';//位置链接
				}elseif($houseType1 == 2){
					$data['type'] = 'xzl'.$subtype;
					$data['houseUrl'] = '/xzl'.$subtype.'/area';
				}else{
					if(($house->houseType2 == 304) || ($house->houseType2 == 305)){
						$data['type'] = 'bs'.$subtype;
						$data['houseUrl'] = '/bs'.$subtype.'/area';
					}else{
						$data['type'] = 'esf'.$subtype;
						$data['houseUrl'] = '/esf'.$subtype.'/area';
					}
					if(!empty($house->roomStr)){ //获取房源是几居
						$lists->houseRoom = substr($house->roomStr,0,1);
					}
				}
				//如果用户登录,等获取该用户的关注房源或者楼盘表
				if(!empty(Auth::id())){
					$interest['uid'] = Auth::id();
					if($subtype == 'sale'){
						$tableType = 2;
					}else{
						$tableType = 1;
					}
					$interest['tableType'] =  $tableType;
					$interest['type1'] = $houseType1;
					$interest['isNew'] = 0;
					$interest['is_del'] = 0;
					$data['interest'] = $this->house->getInterestByUid($interest);
				}
			}
			//房源标签
			$wheretag = array('type'=>4,'propertyType1'=>$house->houseType1);
			$data['tags'] = $this->house->getHouseTag($wheretag);
			if(!empty($house->diyTagId)){
				$dtIds = explode('|',$house->diyTagId);
				$diyTagIds = $this->house->getDiyTagByIds($dtIds);
				if(!empty($diyTagIds)){
					$data['diyTagIds'] = $this->public->conversion($diyTagIds);
				}
			}
			$data['paymentTypes'] = $this->paymentTypes;
			$data['faces'] = $this->faces;
			$data['trades'] = $this->trades;
			$data['officeLevels'] = $this->officeLevel;
			$data['rentTypes'] = $this->rentType;
			$data['stateShops'] = $this->stateShop;
			$data['type2'] = $this->type2;
			//获取本楼盘推荐房源
			$lists->communityId = $house->communityId;
			if(($house->houseType2 == 304) || ($house->houseType2 == 305)){
				$lists->type2 = '304 305';
			}
			$lists->must_not = [['id'=>$house->id]];
			$lists->pageset = 5;
			//print_r($lists);
			$recommend = $search->searchHouse($lists);
			if(!isset($recommend->error)&&!empty($recommend)){
				$data['recommends'] = $recommend->hits->hits;
			}else{
				$data['recommends'] = '';
			}

			return $data;
		}else{
			return array();
		}

	}
	//经纪人的成交数量
	public function brokerDealCount($uid){
		//经纪人出售的成交数量
		$dealSale = 0;
		$dealRent = 0;
		$brokerCount = new ListInputView();
		$brokerCount->uid = $uid;
		$search = new Search('hs');
		$brokerCount->dealState = 2;
		$saleCount = $search->searchHouse($brokerCount);
		if(!isset($saleCount->error)&&!empty($saleCount)){
			$dealSale = $saleCount->hits->total;
		}
		//经纪人出租的成交数量
		$search = new Search('hr');
		$brokerCount->dealState = 1;
		$rentCount = $search->searchHouse($brokerCount);
		if(!isset($rentCount->error)&&!empty($rentCount)){
			$dealRent = $rentCount->hits->total;
		}

		return $dealSale + $dealRent;
	}
	//数字转中文 (几居)
	protected function roomTurnZh($roomStr){
		switch (substr($roomStr,0,1)){
			case 1:
				$houseRoom = "一";
				break;
			case 2:
				$houseRoom = "两";
				break;
			case 3:
				$houseRoom = "三";
				break;
			case 4:
				$houseRoom = "四";
				break;
			case 5:
				$houseRoom = "五";
				break;
			case 6:
				$houseRoom = "六";
				break;
			case 7:
				$houseRoom = "七";
				break;
			case 8:
				$houseRoom = "八";
				break;
			case 9:
				$houseRoom = "九";
				break;
			default:
				$houseRoom ='';
		}
		return $houseRoom;
	}
	//获取该房源 小区的成交记录
	public function getDealState(){
		$type = Input::get('type');
		$this->page = Input::get('page',1);
		$communityId = Input::get('cid');//177659
		if($type == 'sale'){
			$objectType = 'houseSale';
			$search = new Search('hs');
			$table = 'housesale';
			$dealState = 2;
		}else{
			$objectType = 'houseRent';
			$search = new Search('hr');
			$table = 'houserent';
			$dealState = 1;
		}

		$dealRecord = new ListInputView();
		$dealRecord->communityId = $communityId;
		$dealRecord->dealState = $dealState;
		$dealRecord->pageset = $this->pageset;
		$dealStates = $search->searchHouse($dealRecord);
		if(empty($dealStates->error)){
			$total = $dealStates->hits->total;
			$houses = $dealStates->hits->hits;
		}else{
			return '';
		}
		if(!empty($houses)){
			foreach($houses as $k=>$v){
				if(!empty($houses[$k]->_source->thumbPic)){
					$houses[$k]->_source->thumbPic = get_img_url($objectType,$houses[$k]->_source->thumbPic,1);
				}
			}
			//分页
			$public = new PublicController();
			$pagingHtml = $public->RentPaging($total,$this->page,$this->pageset);
			$shuju['paging'] = $pagingHtml;
			$shuju['dealStates'] = $houses;
			return $shuju;
		}else{
			return '';
		}
	}
	/**
	 * 计算某个经纬度的周围某段距离的正方形的四个点
	 * @param $lng 经度
	 * @param $lat 纬度
	 * @param float $distance 距离
	 * @return array
	 */
	public function returnSquarePoint($lng,$lat,$distance = 0.5){
		$radius = 6371;
		$dlng = 2*asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
		$dlng = rad2deg($dlng);

		$dlat = $distance/$radius;
		$dlat = rad2deg($dlat);
		return array('swlng'=>$lng-$dlng,'swlat'=>$lat-$dlat,'nelng'=>$lng+$dlng,'nelat'=>$lat+$dlat);
	}

	//该经纪人下其他房源
	public function returnOtherHouseByuId($sr,$uid,$type1,$id){
		if($sr == 's'){
			$search = new Search('hs');
		}else{
			$search = new Search('hr');
		}
		$lists = new ListInputView();
		$lists->must_not = [['id'=>$id]];
		$lists->uid = $uid;
		$lists->type1 = $type1;
		$lists->order = 'timeRefresh';
		$lists->asc = 0;
		$lists->pageset = 3;
		$results = $search->searchHouse($lists);
		if(!isset($results->error)){
			$otherHouses = $results->hits->hits;
		}else{
			$otherHouses = '';
		}
		//dd($otherHouses);
		return $otherHouses;
	}

	//新房推荐
	public function returnNewBuild($cityId,$type1){
		$search = new Search();
		$lists = new ListInputView();
		$priceSaleAvg = "priceSaleAvg".$type1;
		//$lists->fields = '"id","name","type1","type2","'.$priceSaleAvg.'"';
		$lists->cityId = $cityId;
		$lists->type1 = $type1;
		$lists->isNew = true;
		$lists->order = 'timeUpdateLong';
		$lists->asc = 0;
		$lists->pageset = 6;
		$results = $search->searchCommunity($lists);
		if(!isset($results->error)){
			$newBuilds = $results->hits->hits;
		}else{
			$newBuilds = '';
		}
		return $newBuilds;
	}
	//补全html代码
	public function closetags($html) {
		// 不需要补全的标签
		$arr_single_tags = array('meta', 'img', 'br', 'link', 'area');
		// 匹配开始标签
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];
		// 匹配关闭标签
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		// 计算关闭开启标签数量，如果相同就返回html数据
		$len_opened = count($openedtags);
		if (count($closedtags) == $len_opened) {
			return $html;
		}
		// 把排序数组，将最后一个开启的标签放在最前面
		$openedtags = array_reverse($openedtags);
		// 遍历开启标签数组
		for ($i = 0; $i < $len_opened; $i++) {
			// 如果需要补全的标签
			if (!in_array($openedtags[$i], $arr_single_tags)) {
			// 如果这个标签不在关闭的标签中
				if (!in_array($openedtags[$i], $closedtags)) {
					// 直接补全闭合标签
					$html .= '</' . $openedtags[$i] . '>';
				} else {
					unset($closedtags[array_search($openedtags[$i], $closedtags)]);
				}
			}
		}
		return $html;
	}

	//
	public function validateCode(){
		$_vc = new ValidateUtil();  //实例化一个对象
		$_vc->width = 80;
		$_vc->height = 30;
		$_vc->fontsize = 16;
		$_vc->doimg();
		Session::put('authnum_session',$_vc->getCode());//验证码保存到SESSION中
	}
	/**
	 * 楼盘纠错
	 * @param $id 房源id
	 * @return int
	 */
	public function errorCorrection(){
		$data = Input::all();
		if(strtolower($data['yzm']) != strtolower(Session::get('authnum_session'))){
			return 2;
		}
		unset($data['yzm']);
		if(!empty(Auth::id())) {
			$data['uid'] = Auth::id();
		}
		$res = $this->house->inserterrorCorrection($data);
		if($res){
			return 1;
		}else{
			return 0;
		}
	}

    /*
     * 判断当前城市所用模板
     */
    private function getModelType($cityId){
        $res = $this->house->getCityModel($cityId);
        return $res;
    }
}