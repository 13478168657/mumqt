<?php

namespace App\Http\Controllers\Xinf;

use Auth;
use DB;
use App\Services\Search;
use App\Dao\Xinf\XinfDao;
use App\Dao\Agent\HouseDao;
use App\Dao\Comment\CommunityUserCommentDao;
use App\Dao\Comment\HouseUserCommentDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\CommunityDataStructure;
use App\Http\Controllers\Utils\SafeUtil;
use App\ListInputView;
use Cookie;
use App\Http\Controllers\Utils\RedisCacheUtil;
use App\Http\Controllers\Broker\BrokerController;

class XinfController extends Controller {
	protected $XinfDao;
	protected $CommunityUserCommentDao;
	protected $HouseUserCommentDao;
	public $cityName;                      //城市名称
	public $fenlei;                      //楼盘分类
	public $type2CN;                     //物业类型(副)
	public $structureCN;                 //建筑类别
	public $states;                 //销售状态 数组
	public $state;                 //销售状态
	public $cityIds = [1];         //显示不同的新盘详情页
	public function __construct() {
		$this->house = new HouseDao();
//		$py = explode('.',$_SERVER['HTTP_HOST']);
//		$py = $py[0];
//		$cityInfo = $this->house->getCityByPy($py);
//		$this->cityId = !empty($cityInfo->id)?$cityInfo->id:1;
//		$this->cityName = !empty($cityInfo->name)?$cityInfo->name:'北京';
		$this->cityId = !empty(CURRENT_CITYID)?CURRENT_CITYID:1;
		$this->cityName = !empty(CURRENT_CITYNAME)?CURRENT_CITYNAME:'北京';
		$this->states = ['待售','在售','售完'];
		$this->type2CN = ['101'=>'住宅底商','102'=>'商业街商铺','103'=>'临街门面', '104'=>'写字楼配套底商', '105'=>'购物中心', '106'=>'其它', '201'=>'纯写字楼', '203'=>'商业综合体楼', '204'=>'酒店写字楼', '301'=>'普通住宅', '302'=>'经济适用房', '303'=>'商住公寓楼', '304'=>'别墅', '305'=>'精品豪宅', '306'=>'平房', '307'=>'四合院'];
		$this->structureCN = ['1'=>'板楼', '2'=>'塔楼', '3'=>'砖楼', '4'=>'砖混', '5'=>'平房', '6'=>'钢混', '7'=>'塔板结合','8'=>'框架剪力墙', '9'=>'其他'];
		$this->XinfDao  = new XinfDao;
		$this->CommunityUserCommentDao = new CommunityUserCommentDao; // 调用用户对楼盘评论接口
		$this->HouseUserCommentDao = new HouseUserCommentDao; // 调用用户对房源评论接口
	}
	/**
	| 新房首页
	*/
	public function xinfindex($communityId,$type2='') {
		$search = new Search();
		//$communityId = Input::get('communityId');
		$cityName = $this->cityName;//城市名称
		$cityId = $this->cityId; //当前城市id
		$cityIds = $this->cityIds;
		//先从缓存获取，若没有则走es
		if(!Cache::store('redis')->has('es_newCommunity_'.$communityId)){
			// 用索引查询楼盘信息
			$communitymessage = $search->getCommunityByCid($communityId,true);//$communityId
			if(!empty($communitymessage->found)){
				$communityData = array($communitymessage->_source);
				Cache::store('redis')->put('es_newCommunity_'.$communityId,$communityData,60*24*30);
			}
		}else{
			$communityData = Cache::store('redis')->get('es_newCommunity_'.$communityId);
		}
//		// 用索引查询楼盘信息
//		$communitymessage = $search->getCommunityByCid($communityId,true);//$communityId
//		if(!empty($communitymessage->found)){
//			$communityData = array($communitymessage->_source);
//		}
        /** 增加 start (zhuwei) **/
		//$type2 = Input::get('type2','');
		if($type2 == ''){
			// 查询当前楼盘的主物业类型
			$commuType1 = explode('|',$this->XinfDao->getCommunityType($communityId));
			if(in_array(3,$commuType1)){
				$type2 = 301;
			}else if(in_array(2,$commuType1)){
				$type2 = 201;
			}else if(in_array(1,$commuType1)){
				$type2 = 101;
			}
		}
		$type1 = !empty(substr($type2,0,1))?substr($type2,0,1):3;
		if($type1 == 1){
			$this->fenlei = 'shops';
			$this->type1Name = '商铺';
		}else if($type1 == 2){
			$this->fenlei = 'office';
			$this->type1Name = '写字楼';
		}else{
			$this->fenlei = 'new';
			if($type2 == '304'){
				$this->type1Name = '别墅';
			}elseif($type2 == '305'){
				$this->type1Name = '豪宅';
			}else{
				$this->type1Name = '住宅';
			}
		}
		$GLOBALS['current_listurl'] = config('session.domain').'/'.$this->fenlei.'/area';
		/** 增加 end   (zhuwei) **/
		$fenlei = $this->fenlei;
		$typexxxInfo = 'type'.$type2.'Info';
		$community = new CommunityDataStructure($type2); // type2Info 序列化和反序列化
		//dd($community);
		//获取楼盘图片
		$communityImages = $this->XinfDao->getCommImgTotal($communityId,$type2);//$communityId
		//如果用户登录,等获取该用户的关注房源或者楼盘表
		if(!empty(Auth::id())){
			$interest['uid'] = Auth::id();
			$interest['isNew'] = 1;
			$interest['tableType'] =  3;
			$interest['type1'] = $type1;
			$interest['is_del'] = 0;
			$interests = $this->XinfDao->getInterestByUid($interest); //关注的楼盘id集合
		}
		//获取该楼盘的经纪人id
		$uids = get_broker_by_binding($communityId);//$communityId
		if(empty($uids)){
			$uids = array();
		}
		$brokersMessage = array(); //经纪人信息
		foreach($uids as $k=>$uid){
			//根据id获取经纪人的相关信息
			$xuid = $search->searchBrokerById($uid->brokerId);//$uid->brokerId
			if(!empty($xuid->found)){
				//获取服务商圈
//				$brokerBusiness = array();
//				$managebus = !empty($xuid->_source->managebusinessAreaIds)?$xuid->_source->managebusinessAreaIds:'';
//				if(!empty($managebus)){
//					foreach(explode('|',$managebus) as $k=>$v){
//						if(!empty(RedisCacheUtil::getBussinessNameById($v))){
//							array_push($brokerBusiness,RedisCacheUtil::getBussinessNameById($v));
//						}
//						if(count($brokerBusiness) == 2) break;
//					}
//				}
//				$xuid->_source->brokerBusiness = $brokerBusiness;
//				//获取主营业务
//				$configBus = \Config::get('mianBusiness');
//				$mainbusiness = !empty($xuid->_source->mainbusiness)?$xuid->_source->mainbusiness:'';
//				$brokerBus = array();
//				if(!empty($mainbusiness)){
//					foreach(explode('|',$mainbusiness) as $k=>$v){
//						if(!empty($configBus[$v])){
//							array_push($brokerBus,$configBus[$v]);
//						}
//						if(count($brokerBus) == 2) break;
//					}
//					$xuid->_source->brokerBus = $brokerBus;
//				}
				array_push($brokersMessage,$xuid->_source);
				if(count($brokersMessage) == 2) break;
			}
		}
		//若索引中没有数据则查库
		if(empty($communityData)){
			$communityData = $this->XinfDao->getCommunity($communityId); // 获取楼盘信息
		}
		$jingduMap = 0;
		$weiduMap = 0;
		if(!empty($communityData)){
			if(($communityData[0]->type1 == 2 && $type2 == 303)||((strpos($communityData[0]->type1,'3')  === false) && (strpos($communityData[0]->type2,'303')  !== false))){
				$fenlei = 'office';
				$this->type1Name = '写字楼';
			}
			$shopId = $communityData[0]->enterpriseshopId; // 分销商id
			//$viewShowInfo['enterpriseShopLogo'] = $this->XinfDao->getShopLogoById($shopId);//分销商logo
			$jingduMap = $communityData[0]->longitude; // 楼盘经度
			$weiduMap = $communityData[0]->latitude; // 楼盘纬度
			$type2Info =  !empty($communityData[0]->$typexxxInfo)?$communityData[0]->$typexxxInfo:'';
			$cityAreaName = RedisCacheUtil::getCityAreaNameById($communityData[0]->cityAreaId);
			$businessName = RedisCacheUtil::getBussinessNameById($communityData[0]->businessAreaId);
//			$cityAreaName = $this->XinfDao->getCityAreaName($communityData[0]->cityAreaId);
//			$businessName = $this->XinfDao->getBusinessName($communityData[0]->businessAreaId);
			$address = $communityData[0]->address;
			$viewShowInfo['address'] = $address;
			$communityName = $communityData[0]->name;
			$viewShowInfo['cityAreaName'] = $cityAreaName;
			$viewShowInfo['businessName'] = $businessName;
			$viewShowInfo['communityName'] = $communityName;
			$viewShowInfo['buildingBackPic'] = $communityData[0]->buildingBackPic;//楼栋标注底图
			$viewShowInfo['communityMobile'] = !empty($communityData[0]->communityMobile)?$communityData[0]->communityMobile:'';//售楼热线，多个用西文 | 隔开
		}else{
			return '没有找到此楼盘';
		}
		if(!empty($type2Info)){
			$type2GetInfo = $community->unserialize($type2Info); // 反序列化获取type2详细信息
		}

		//获取楼盘标签
		if(!empty($type2GetInfo)){
			$tagNames = array();
			if(!empty($type2GetInfo->tagIds)){
				$tagIds = explode('|', $type2GetInfo->tagIds);
				$tags = $this->house->getAllHouseTag();
				foreach($tagIds as $tag){
					if(!empty($tags[$tag])){
						$tagNames[$tag] = $tags[$tag];
					}
				}
			}
			$diyTagNames = array();
			if(!empty($type2GetInfo->diyTagIds)){
				$diyTagIds = explode('|',$type2GetInfo->diyTagIds);
				$diyTagNames = $this->XinfDao->getDiyTagName($diyTagIds);
			}
		}

		$periods = $this->XinfDao->getPeriods($communityId); // 获取营销信息
		if(!empty($periods)){
			$openTime = date('Y年m月d日',strtotime($periods[0]->openTime)); // 开盘时间
			$takeTime = date('Y年m月d日',strtotime($periods[0]->takeTime)); // 交房时间
			$salesStatus = $periods[0]->salesStatus; // 销售状态
			$saleMinPrice = $periods[0]->saleMinPrice; // 最低价格
			$viewShowInfo['saleMinPrice'] = $saleMinPrice;
            $viewShowInfo['saleAvgPrice'] = $periods[0]->saleAvgPrice; // 均价
            $viewShowInfo['saleAvgPriceUnit'] = $periods[0]->saleAvgPriceUnit;
			$viewShowInfo['startTime'] = $openTime;
			$viewShowInfo['takeTime'] = $takeTime;  //预计交房时间
			$viewShowInfo['houseNum'] = $periods[0]->houseNum;  //当前户数
			$youhui = '';

			if(!empty($communityData)){
				$discountType = !empty($communityData[0]->discountType)?$communityData[0]->discountType:'';
				$discount = !empty($communityData[0]->discount)?$communityData[0]->discount:'';
				$subtract = !empty($communityData[0]->subtract)?$communityData[0]->subtract:'';
				$specialOffers = !empty($communityData[0]->specialOffers)?$communityData[0]->specialOffers:'';
			}else{
				$discountType = $periods[0]->discountType;
				$discount = $periods[0]->discount;
				$subtract = $periods[0]->subtract;
				$specialOffers = $periods[0]->specialOffers;
			}
//			$viewShowInfo['discountType'] = $discountType;
//			$viewShowInfo['discount'] = $discount;
//			$viewShowInfo['subtract'] = $subtract;
//			$viewShowInfo['specialOffers'] = $specialOffers;
			if($discountType == 1){
				$youhui = $discount.'折';
			}elseif($discountType == 2){
				$youhui = '减去'. floor($subtract);
			}elseif($discountType == 3){
				$youhui = $discount.'折减'. floor($subtract);
			}
			if(!empty($specialOffers) && strlen($specialOffers)>2 && $specialOffers !='0_0'){
				if(!empty($youhui)){
					$youhui = $youhui.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.str_replace('_','抵',$specialOffers);
				}else{
					$youhui = str_replace('_','抵',$specialOffers);
				}
			}
			$viewShowInfo['youhui'] = $youhui;
		}
		$viewShowInfo['type1Name'] = $this->type1Name;//楼盘物业类型名称
		$type2CN = $this->type2CN;
		$structureCN = $this->structureCN;
		if(!empty($type2)){
			$type2Name = $type2CN[$type2];
			$viewShowInfo['type2Name'] = $type2Name;
		}
		if(!empty($type2GetInfo)){
			$structure = (!empty($type2GetInfo->structure) && !empty($structureCN[$type2GetInfo->structure]))?$structureCN[$type2GetInfo->structure]:'';
			$viewShowInfo['structure'] = $structure;
		}

		// 查询新盘动态
		$commStatus = $this->XinfDao->getCommunityNews($communityId);//1  301

		//获取楼盘点评
		$commentInfo = $this->XinfDao->getCommComment($communityId);//1

		// 查询户型信息
		$select = ['id','name','cbIds','communityId','thumbPic','room','hall','toilet','kitchen','balcony','floorage','location'];
		$communityroom = $this->XinfDao->getCommunityRoom($communityId);//1

		if($fenlei == 'new'){ //新楼盘户型信息
			// 楼盘楼栋信息
			$communitybuilding = $this->XinfDao->getCommBuild($communityId);//$communityId

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
			$roomAllNum = '0';
			if(!empty($communityroom)){
				$roomAllNum = count($communityroom);
				$viewShowInfo['roomAllNum'] = $roomAllNum;
			}
			foreach ($communityroom as $room) {
				if($room->room == 1){
					$room1[] = $room->id;
				}
				if($room->room == 2){
					$room2[] = $room->id;
				}
				if($room->room == 3){
					$room3[] = $room->id;
				}
				if($room->room == 4){
					$room4[] = $room->id;
				}
			}
			if(!empty($room1)){
				$room1Num = count($room1);
				$roomId1 = $room1[0];
				$viewShowInfo['room1Num'] = $room1Num;
				$viewShowInfo['roomId1'] = $roomId1;
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
			if(!empty($room4)){
				$room4Num = count($room4);
				$roomId4 = $room4[0];
				$viewShowInfo['room4Num'] = $room4Num;
				$viewShowInfo['roomId4'] = $roomId4;
			}
		}else{ //写字楼 商铺户型信息
			$roomAllNum = '0';
			if(!empty($communityroom)){
				$roomAllNum = count($communityroom);
				$viewShowInfo['roomAllNum'] = $roomAllNum;
			}
			foreach ($communityroom as $room) {
				if($room->location == '首层'){
					$room1[] = $room->id;
				}elseif($room->location == '标准层'){
					$room2[] = $room->id;
				}elseif($room->location == '顶层'){
					$room3[] = $room->id;
				}
			}
			if(!empty($room1)){
				$room1Num = count($room1);
				$roomId1 = $room1[0];
				$viewShowInfo['room1Num'] = $room1Num;
				$viewShowInfo['roomId1'] = $roomId1;
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
		}

		//商铺写字楼显示
		if($fenlei != 'new'){
			//租房
			$searchRent = new Search('hr');
			$listsRent = new ListInputView();
			$listsRent->communityId = $communityId;
			$listsRent->type2 = $type2;
			$listsRent->pageset= 5;
			$communityRent = $searchRent->searchHouse($listsRent);
			//dd($communityRent);
			if(!isset($communityRent->error)&&!empty($communityRent->hits->hits)){
				$comRent = $communityRent->hits->hits;
			}
			//二手房
			$searchSale = new Search('hs');
			$listsSale = new ListInputView();
			$listsSale->communityId = $communityId;
			$listsSale->type2 = $type2;
			$listsSale->pageset= 5;
			$communitySale = $searchRent->searchHouse($listsSale);
			if(!isset($communitySale->error)&&!empty($communitySale->hits->hits)){
				$comSale = $communitySale->hits->hits;
			}

		}

		//根据分销商id获取周边楼盘
		if(!empty($shopId)){
			$lnglat = http_build_query(['enterpriseshopId'=>$shopId]);
			$lists = new ListInputView();
			$lists->enterpriseshopId = $shopId;
			$lists->cityId = $this->cityId;
			$lists->isNew = 1;
			$lists->type1 = $type1;
			$lists->pageset = 6;
			$surround= $search->searchCommunity($lists);
			//dd($surround);
			if(empty($surround->error)){
				foreach($surround->hits->hits as $k=>$v){
					if($v->_id == $communityId){
						unset($surround->hits->hits[$k]);
					}
				}
				$commAround = array_values($surround->hits->hits);
			}else{
				$commAround = '';
			}
		}
		//根据分销商id获取不到周边楼盘时
		if(empty($commAround)){
			$lists = new ListInputView();
			$lnglat = $this->returnSquarePoint($jingduMap,$weiduMap,$distance = 10);
			$lists->swlng = $lnglat['swlng'];
			$lists->swlat = $lnglat['swlat'];
			$lists->nelng = $lnglat['nelng'];
			$lists->nelat = $lnglat['nelat'];
			$lnglat = http_build_query($lnglat);
			$lists->cityId = $this->cityId;
			$lists->isNew = 1;
			$lists->type1 = $type1;
			$lists->pageset = 6;
			$surround= $search->searchCommunity($lists);
			if(empty($surround->error)){
				foreach($surround->hits->hits as $k=>$v){
					if($v->_id == $communityId){
						unset($surround->hits->hits[$k]);
					}
				}
				$commAround = array_values($surround->hits->hits);
			}else{
				$commAround = '';
			}
		}
                if (USER_AGENT_MOBILE) {                   
                    if(!empty($communityData )){
                        $loopLineName = $this->XinfDao->getLoopLineName($communityData[0]->loopLineId); // 查询城市环线
                        if(!empty($loopLineName)){
                            $viewShowInfo['loopLineName'] = $loopLineName[0]->name;
                        }
                        $viewShowInfo['busnessId']=$communityData[0]->businessAreaId;
                        $propertyName = $this->XinfDao->getPropertyName($communityData[0]->propertyCompanyId); // 获取物业公司
                        if(!empty($propertyName)){
                                $viewShowInfo['propertyName'] = $propertyName[0]->companyname;
                        }
                        $developerName = $this->XinfDao->getDevelopersName($communityData[0]->developerId); // 获取开发商
                        if(!empty($developerName)){
                                $viewShowInfo['developerName'] = $developerName[0]->companyname;
                        }                        
                    }
                    $featurestag = $this->house->getAllHouseTag(); //所有房源标签
                    $defaultImage = '/h5/image/pic1.png';   //默认图片
                    return view('h5.xinf.xfBIndex',compact('communityId','type2','communityData','type2GetInfo','viewShowInfo','commStatus','commentInfo','communitybuilding','communityroom','communityimage','commImg','jingduMap','weiduMap','surround','comRent','comSale','commAround','shopId','lnglat','fenlei','communityImages','brokersMessage','tagNames','diyTagNames','cityName','interests','defaultImage','featurestag'));
                }
		return view('xinf.xfBIndex',compact('cityId','cityIds','communityId','type2','communityData','type2GetInfo','viewShowInfo','commStatus','commentInfo','communitybuilding','communityroom','communityimage','commImg','jingduMap','weiduMap','surround','comRent','comSale','commAround','shopId','lnglat','fenlei','communityImages','brokersMessage','tagNames','diyTagNames','cityName','interests'));
	}

	/**
	| 新房楼盘详情页
	*/
	public function xinfxq($communityId,$type2='') {
		$type1 = !empty(substr($type2,0,1))?substr($type2,0,1):3;
		if($type1 == 1){
			$this->fenlei = 'shops';
			$this->type1Name = '商铺';
		}else if($type1 == 2){
			$this->fenlei = 'office';
			$this->type1Name = '写字楼';
		}else{
			$this->fenlei = 'new';
			if($type2 == '304'){
				$this->type1Name = '别墅';
			}elseif($type2 == '305'){
				$this->type1Name = '豪宅';
			}else{
				$this->type1Name = '住宅';
			}
		}
		$GLOBALS['current_listurl'] = config('session.domain').'/'.$this->fenlei.'/area';
		$xiangqing = 'xiangqing';
		//$communityId = Input::get('communityId');
		//$type2 = Input::get('type2');
		$cityName = $this->cityName;//城市名称
		$fenlei = $this->fenlei;  //住宅 商铺 写字楼 分类标记
		$typexxxInfo = 'type'.$type2.'Info';
		$community = new CommunityDataStructure($type2); // type2Info 序列化和反序列化
		$safeUtil = new SafeUtil; // 整数加密和解密

		$type2CN = $this->type2CN;
		$structureCN = $this->structureCN;
		$decorationCN = ['1'=>'毛坯', '2'=>'简装修', '3'=>'中装修', '4'=>'精装修', '5'=>'豪华装修'];

		// 楼盘信息
		$search = new Search();
		//先从缓存获取，若没有则走es
		if(!Cache::store('redis')->has('es_newCommunity_'.$communityId)){
			// 用索引查询楼盘信息
			$communitymessage = $search->getCommunityByCid($communityId,true);//$communityId
			if(!empty($communitymessage->found)){
				$commData = array($communitymessage->_source);
				Cache::store('redis')->put('es_newCommunity_'.$communityId,$commData,60*24*30);
			}
		}else{
			$commData = Cache::store('redis')->get('es_newCommunity_'.$communityId);
		}
		//从数据库里查询
		if(empty($commData)){
			$select = ['id','name','loopLineId','address','developerId','propertyCompanyId','propertyAddress','longitude','latitude',$typexxxInfo];
			$commData = $this->XinfDao->getCommunity($communityId);
		}
		$jingduMap = '';
		$weiduMap = '';
		if(!empty($commData)){
			$type2GetInfo = $community->unserialize($commData[0]->$typexxxInfo); // 反序列化获取type2详细信息
			$jingduMap = $commData[0]->longitude; // 楼盘经度
			$weiduMap = $commData[0]->latitude; // 楼盘纬度
			$loopLineName = $this->XinfDao->getLoopLineName($commData[0]->loopLineId); // 查询城市环线
			if(!empty($loopLineName)){
				$viewShowInfo['loopLineName'] = $loopLineName[0]->name;
			}
			$propertyName = $this->XinfDao->getPropertyName($commData[0]->propertyCompanyId); // 获取物业公司
			if(!empty($propertyName)){
				$viewShowInfo['propertyName'] = $propertyName[0]->companyname;
			}
			$developerName = $this->XinfDao->getDevelopersName($commData[0]->developerId); // 获取开发商
			if(!empty($developerName)){
				$viewShowInfo['developerName'] = $developerName[0]->companyname;
			}
			
			$viewShowInfo['communityName'] = $commData[0]->name;
			$viewShowInfo['propertyAddress'] = $commData[0]->propertyAddress;
			$viewShowInfo['address'] = $commData[0]->address;
		}

		$saleMinPrice = $this->XinfDao->getPeriods($communityId); // 查询最高价 最低价 均价
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMinPrice'] = $saleMinPrice[0]->saleMinPrice;
		}
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMaxPrice'] = $saleMinPrice[0]->saleMaxPrice;
		}
		if(!empty($type2GetInfo)){
			// 查询所有项目特色
			$tagIds = explode('|', $type2GetInfo->tagIds);
			$tags = $this->XinfDao->getTagName($tagIds);
			$tagNames = array();
			foreach($tags as $tag){
				array_push($tagNames,$tag->name);
			}
			$diyTagIds = explode('|',$type2GetInfo->diyTagIds);
			$diyTags = $this->XinfDao->getDiyTagName($diyTagIds);
			$tagNames = array_merge($tagNames,$diyTags);

			$viewShowInfo['tagsName'] = implode(',',$tagNames);

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
					if(!empty($parkingInfo[3])){
						$parkingIntro = "规划机动车停车位$parkingInfo[0]个，其中地上约$parkingInfo[1]个，地下约$parkingInfo[2]个。住宅的机动车车位配比为$parkingInfo[3] ：$parkingInfo[4]。";
					}else{
						$parkingIntro = "规划机动车停车位$parkingInfo[0]个，其中地上约$parkingInfo[1]个，地下约$parkingInfo[2]个。";
					}
				
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
			}
		}

		$periods = $this->XinfDao->getPeriods($communityId);
		//dd($periods);
		if(!empty($periods)){
			$openTime = date('Y年m月d日',strtotime($periods[0]->openTime)); // 开盘时间
			$takeTime = date('Y年m月d日',strtotime($periods[0]->takeTime)); // 交房时间
			$houseNum = $periods[0]->houseNum; // 查询当期户数
			$salesStatus = $periods[0]->salesStatus; // 销售状态
			$viewShowInfo['openTime'] = $openTime;
			$viewShowInfo['takeTime'] = $takeTime;
			$viewShowInfo['houseNum'] = $houseNum;
		}

		$viewShowInfo['type1Name'] = $this->type1Name;//楼盘物业类型名称
//		$select = ['id','communityId','changeTime','maxPrice','avgPrice','minPrice','description'];
//		$communityStatus = $this->XinfDao->getCommStatusData($communityId,'2',$select); // 获取历史价格
		// 查询新盘调价历史
		$communityStatus = $this->XinfDao->getStatus($communityId,'2',$type2);//1  301
		$viewShowInfo['type2'] = $type2CN[$type2];

		// 查询楼层状况
		//$cbIdsAll = $this->XinfDao->getPeriodCbids($communityId);//1130
		$cbIdsAll = $this->XinfDao->getPeriodsBytype2($communityId,$type2);//1130

		// 查询楼盘下的楼栋信息
		$communitybuilding = $this->XinfDao->getCommBuild($communityId);//1
		//dd($communitybuilding);
		// 查询楼栋下的户型名称
		$select = ['id','name','cbIds'];
		$communityroom = $this->XinfDao->getCommunityRoom($communityId);//1
		//dd($communityroom);
		if(!empty($cbIdsAll)){
			foreach ($cbIdsAll as $k => $v) {
				$period1 = $v->cbIds;
				if(!empty($period1 && $communityroom)){
					$period1Arr = explode('|', $period1);
					$period1Info = $this->insertBuildToPeriod($communitybuilding,$period1Arr);
					$periodBuildData['period'.$v->period] = $this->insertRoomToBuild($period1Info,$communityroom);

				}
			}
		}

		return view('xinf.xfBDetail',compact('communityId','cityName','fenlei','type2','xiangqing','viewShowInfo','type2GetInfo','communityStatus','jingduMap','weiduMap','periodBuildData'));
	}

	/**
	| 新房户型详情页
	*/
	public function xinfhx($communityId,$type2='') {
		$type1 = !empty(substr($type2,0,1))?substr($type2,0,1):3;
		if($type1 == 1){
			$this->fenlei = 'shops';
			$this->type1Name = '商铺';
		}else if($type1 == 2){
			$this->fenlei = 'office';
			$this->type1Name = '写字楼';
		}else{
			$this->fenlei = 'new';
			if($type2 == '304'){
				$this->type1Name = '别墅';
			}elseif($type2 == '305'){
				$this->type1Name = '豪宅';
			}else{
				$this->type1Name = '住宅';
			}
		}
		$GLOBALS['current_listurl'] = config('session.domain').'/'.$this->fenlei.'/area';
		$huxing = 'huxing';
		//$communityId = Input::get('communityId');
		//$type2 = Input::get('type2');
		$cityName = $this->cityName;//城市名称
		$fenlei = $this->fenlei;  //住宅 商铺 写字楼 分类标记
		$roomtype = Input::get('roomtype');
		$roomId = Input::get('roomId');
		$typexxxInfo = 'type'.$type2.'Info';
		// 楼盘信息
		$search = new Search();
		//先从缓存获取，若没有则走es
		if(!Cache::store('redis')->has('es_newCommunity_'.$communityId)){
			// 用索引查询楼盘信息
			$communitymessage = $search->getCommunityByCid($communityId,true);//$communityId
			if(!empty($communitymessage->found)){
				$commData = array($communitymessage->_source);
				Cache::store('redis')->put('es_newCommunity_'.$communityId,$commData,60*24*30);
			}
		}else{
			$commData = Cache::store('redis')->get('es_newCommunity_'.$communityId);
		}
		//从数据库里查询
		if(empty($commData)){
			$select = ['id','name'];
			$commData = $this->XinfDao->getCommunity($communityId);
		}
		if(!empty($commData)){
			$viewShowInfo['communityName'] = $commData[0]->name;
			if(($commData[0]->type1 == 2 && $type2 == 303)||((strpos($commData[0]->type1,'3')  === false) && (strpos($commData[0]->type2,'303')  !== false))){
				$fenlei = 'office';
				$this->type1Name = '写字楼';
			}
		}

		$saleMinPrice = $this->XinfDao->getPeriods($communityId); // 查询最高价 最低价
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMinPrice'] = $saleMinPrice[0]->saleMinPrice;
		}
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMaxPrice'] = $saleMinPrice[0]->saleMaxPrice;
		}
		$viewShowInfo['type1Name'] = $this->type1Name;//楼盘物业类型名称
		// 查询所有户型信息
		if($fenlei == 'new'){
			$select = ['id','communityId','name','state','thumbPic','room','hall','toilet','kitchen','floorage','faceTo','num','price','feature','location'];
		}else{
			$select = ['id','communityId','name','state','thumbPic','floorage','usableArea','price','feature','location'];
		}
		$commRoom = $this->XinfDao->getCommunityRoom($communityId);//1
		//dd($commRoom);
		if(!empty($commRoom)){
			if($fenlei == 'new'){
				$room2 = $this->getRoomNum($commRoom,2); // 获取2居室户型信息
				$room3 = $this->getRoomNum($commRoom,3); // 获取3居室户型信息
				$room4 = $this->getRoomNum($commRoom,4); // 获取4居室户型信息
				$room5 = $this->getRoomNum($commRoom,5); // 获取5居室户型信息
                $room6 = $this->getRoomNum($commRoom,1); // 获取1居室户型信息
			}else{
				$room2 = $this->getLocation($commRoom,'首层'); // 获取 首层 户型信息
				$room3 = $this->getLocation($commRoom,'标准层'); // 获取 标准层 户型信息
				$room4 = $this->getLocation($commRoom,'顶层'); // 获取 顶层 户型信息
				$room5 = $this->getLocation($commRoom,'地下层'); // 获取 地下层 户型信息
                $room6 = $this->getLocation($commRoom,'其他'); // 获取 地下层 户型信息
			}

			$room1Tota = count($commRoom);
			$room2Tota = count($room2);
			$room3Tota = count($room3);
			$room4Tota = count($room4);
			$room5Tota = count($room5);
            $room6Tota = count($room6);
			$viewShowInfo['room1Tota'] = $room1Tota;
			$viewShowInfo['room2Tota'] = $room2Tota;
			$viewShowInfo['room3Tota'] = $room3Tota;
			$viewShowInfo['room4Tota'] = $room4Tota;
			$viewShowInfo['room5Tota'] = $room5Tota;
            $viewShowInfo['room6Tota'] = $room6Tota;
		}

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
				if($fenlei == 'new'){
					foreach ($commRoom as $roomV) {
						if($roomV->room == $roomtype){
							$roomOneInfo = $roomV;
						}
					}
				}else{
					foreach ($commRoom as $roomV) {
						if($roomV->location == $roomtype){
							$roomOneInfo = $roomV;
						}
					}
				}
			}else{
				$roomOneInfo = $commRoom[0];
				$roomId = $commRoom[0]->id;
			}
			if($fenlei == 'new'){
				$faceToCN = [1 =>'东', 2 =>'南', 3 =>'西', 4 =>'北', 5 =>'南北', 6 =>'东南', 7 =>'西南', 8 =>'东北', 9 =>'西北', 10 =>'东西'];
				$faceToName = !empty($roomOneInfo->faceTo)&&!empty($faceToCN[$roomOneInfo->faceTo])?$faceToCN[$roomOneInfo->faceTo]:'其它';
				$viewShowInfo['faceToName'] = $faceToName;
			}
		}
		$type2CN = $this->type2CN;
		$viewShowInfo['type2'] = $type2CN[$type2];
		return view('xinf.xfBLeyout',compact('communityId','cityName','fenlei','type2','huxing','viewShowInfo','commRoom','room2','room3','room4','room5','room6','roomtype','roomId','roomOneInfo'));
	}

	/**
	| 新房楼盘相册页
	*/
	public function xinfxc($communityId,$type2='') {
		$type1 = !empty(substr($type2,0,1))?substr($type2,0,1):3;
		if($type1 == 1){
			$this->fenlei = 'shops';
			$this->type1Name = '商铺';
		}else if($type1 == 2){
			$this->fenlei = 'office';
			$this->type1Name = '写字楼';
		}else{
			$this->fenlei = 'new';
			if($type2 == '304'){
				$this->type1Name = '别墅';
			}elseif($type2 == '305'){
				$this->type1Name = '豪宅';
			}else{
				$this->type1Name = '住宅';
			}
		}
		$GLOBALS['current_listurl'] = config('session.domain').'/'.$this->fenlei.'/area';
		$xiangce = 'xiangce';
		//$communityId = Input::get('communityId');
		$cityName = $this->cityName;//城市名称
		$fenlei = $this->fenlei;  //住宅 商铺 写字楼 分类标记
		//$type2 = Input::get('type2');
		$typexxxInfo = 'type'.$type2.'Info';
		$viewShowInfo['state'] = !empty($this->state)?$this->state:'出售';
		// 楼盘信息
		$search = new Search();
		//先从缓存获取，若没有则走es
		if(!Cache::store('redis')->has('es_newCommunity_'.$communityId)){
			// 用索引查询楼盘信息
			$communitymessage = $search->getCommunityByCid($communityId,true);//$communityId
			if(!empty($communitymessage->found)){
				$commData = array($communitymessage->_source);
				Cache::store('redis')->put('es_newCommunity_'.$communityId,$commData,60*24*30);
			}
		}else{
			$commData = Cache::store('redis')->get('es_newCommunity_'.$communityId);
		}
		//从数据库里查询
		if(empty($commData)){
			$select = ['id','name'];
			$commData = $this->XinfDao->getCommunity($communityId);
		}

		if(!empty($commData)){
			$viewShowInfo['communityName'] = $commData[0]->name;
		}

		$saleMinPrice = $this->XinfDao->getPeriods($communityId); // 查询最高价 最低价
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMinPrice'] = $saleMinPrice[0]->saleMinPrice;
		}
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMaxPrice'] = $saleMinPrice[0]->saleMaxPrice;
		}

		//查询楼盘下所有图片
		$commImgTotal = $this->XinfDao->getCommImgTotal($communityId);
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

		$viewShowInfo['type1Name'] = $this->type1Name;//楼盘物业类型名称

		// 查询不同类型图片
		$type = Input::get('type'); // 图片type
		$commTypeImg = $this->XinfDao->getCommTypeImg($communityId,$type);
		$commTypeImg->appends([
			'communityId' => $communityId,
			'type2'       => $type2,
			'type'        => $type
			])->render();

		return view('xinf.xfBAlbum',compact('communityId','cityName','fenlei','type2','xiangce','viewShowInfo','commTypeImg','type'));
	}
	/**
	| 新房房价走势页
	*/
	public function xinfzs($communityId,$type2='') {
		$type1 = !empty(substr($type2,0,1))?substr($type2,0,1):3;
		if($type1 == 1){
			$this->fenlei = 'shops';
			$this->type1Name = '商铺';
		}else if($type1 == 2){
			$this->fenlei = 'office';
			$this->type1Name = '写字楼';
		}else{
			$this->fenlei = 'new';
			if($type2 == '304'){
				$this->type1Name = '别墅';
			}elseif($type2 == '305'){
				$this->type1Name = '豪宅';
			}else{
				$this->type1Name = '住宅';
			}
		}
		$GLOBALS['current_listurl'] = config('session.domain').'/'.$this->fenlei.'/area';
		$zoushi = 'zoushi';
		//$communityId = Input::get('communityId');
		//$type2 = Input::get('type2');
		$cityName = $this->cityName;//城市名称
		$fenlei = $this->fenlei;  //住宅 商铺 写字楼 分类标记
		$typexxxInfo = 'type'.$type2.'Info';
		$viewShowInfo['state'] = !empty($this->state)?$this->state:'出售';
		// 楼盘信息
		$search = new Search();
		//先从缓存获取，若没有则走es
		if(!Cache::store('redis')->has('es_newCommunity_'.$communityId)){
			// 用索引查询楼盘信息
			$communitymessage = $search->getCommunityByCid($communityId,true);//$communityId
			if(!empty($communitymessage->found)){
				$commData = array($communitymessage->_source);
				Cache::store('redis')->put('es_newCommunity_'.$communityId,$commData,60*24*30);
			}
		}else{
			$commData = Cache::store('redis')->get('es_newCommunity_'.$communityId);
		}
		//从数据库里查询
		if(empty($commData)){
			$select = ['id','name','longitude','latitude','businessAreaId'];
			$commData = $this->XinfDao->getCommunity($communityId);
		}

		if(!empty($commData)){
			$viewShowInfo['communityName'] = $commData[0]->name;
			$jingduMap = $commData[0]->longitude; // 楼盘经度
			$weiduMap = $commData[0]->latitude; // 楼盘纬度
		}

		$saleMinPrice = $this->XinfDao->getPeriods($communityId); // 查询最高价 最低价
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMinPrice'] = $saleMinPrice[0]->saleMinPrice;
		}
		if(!empty($saleMinPrice)){
			$viewShowInfo['saleMaxPrice'] = $saleMinPrice[0]->saleMaxPrice;
		}
		$viewShowInfo['type1Name'] = $this->type1Name;//楼盘物业类型名称
		$type2CN = $this->type2CN;
		$viewShowInfo['type2'] = $type2CN[$type2];
		$viewShowInfo['busnessId']='0';
		$viewShowInfo['busnessName']='';
		if (!empty($commData[0]->businessAreaId)) {
			$viewShowInfo['busnessId']=$commData[0]->businessAreaId;
			$busnessName=RedisCacheUtil::getBussinessNameById($commData[0]->businessAreaId);
			$viewShowInfo['busnessName']=$busnessName;
		}
		//获取楼盘周边信息
		if(empty($jingduMap)){
			$jingduMap = 0;
		}
		if(empty($weiduMap)){
			$weiduMap = 0;
		}
		$search = new Search();
		$lists = new ListInputView();
		$lnglat = $this->returnSquarePoint($jingduMap,$weiduMap,$distance = 5);
		$lnglat = http_build_query($lnglat);
		$lists->cityId = $this->cityId;
		$lists->isNew = 1;
		$lists->pageset = 6;
		$lists->type2= $type2;
		$lists->order = 'timeUpdate';
		$lists->asc = 0;
		$surround= $search->searchCommunity($lists);
		if(empty($surround->error)){
			$commAround = $surround->hits->hits;
		}else{
			$commAround = '';
		}

		return view('xinf.xfBPrice',compact('communityId','cityName','fenlei','type2','zoushi','viewShowInfo','commAround'));
	}

	// 新房带看走势详情页
	public function xinfjl() {
		return view('xinf.xfBShow');
	}

	// 新房客户点评页
	public function xinfdp() {
		return view('xinf.xfBComment');
	}

	// 新房预订页
	public function xinfyd() {
		return view('xinf.xfBHouseR');
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
	 * 新盘
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
	 * 写字楼 商铺
	 * 取出不同户型信息 $str 首层   标准层   顶层   地下层   其它
	 * @param resource $commRoom 查询到的所有户型
	 */
	public function getLocation($commRoom,$str) {
		$room = array();
		foreach ($commRoom as $v) {
			if($v->location == $str){
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
	* 把楼栋信息嵌入它所在的期数里边
	* @param array $communitybuilding 查询的楼盘下所有楼栋信息
	* @param array $periodArr  查询到的期数下包含的所有楼栋id
	 * @return info
	*/
	public function insertBuildToPeriod($communitybuilding,$periodArr){
		$periodInfo = array();
		foreach ($communitybuilding as $build) {
			if(in_array($build->id, $periodArr)){
				$periodInfo[] = $build;
			}
		}
		return $periodInfo;
	}

	/**
	 * 把户型嵌入它存在的楼栋之下
	 * @param array $periodBuildData
	 * @param array $communityroom 户型信息
	 * @return date
	 */
	public function insertRoomToBuild($periodBuildData,$communityroom){
		foreach ($periodBuildData as $key => $per) {
			$roomName = $comma = '';
			foreach ($communityroom as $room) {
				if(in_array($per->id, explode('|', $room->cbIds))){
					$roomName .= $comma . $room->name;
					$comma = ',';
				}
			}
			$periodBuildData[$key]->roomName = $roomName;
		}
		return $periodBuildData;
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
}
?>