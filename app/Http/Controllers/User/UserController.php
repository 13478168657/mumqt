<?php

namespace App\Http\Controllers\User;
use Auth;
use DB;
use App\Dao\User\UserDao;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Services\Search;
use App\Http\Controllers\Lists\PublicController;
use Redirect;


/**
 * Description of UserController
 *  普通用户个人中心后台
 * @author zhuwei
 */
class UserController extends Controller{
    
    private $UserDao;
    private $dataNumber;
    private $uid;
    private $pageUtil;
    /**
    * 构造方法 实例化DAO 并检测用户是否登录
    */
    public function __construct(){              
        $this->dataNumber = 5;   //  每次显示10条数据
        // 判断用户是否已经登陆 和 用户的类型
        if( !Auth::check() || Auth::user()->type != 1 ){
            //$this->beforeFilter('UserMyInfoFilter');
            Redirect::to('/userLogin.html')->send();
        }
        $this->UserDao = new UserDao();
        $this->uid = Auth::user()->id;  //  用户id
        $this->pageUtil = new PublicController();

    }

    /**
     *  关注的楼盘
     * @param array $seaArr   查询条件  ['key' => 'value']
     * @param return array  $commId  关注的楼盘id
     * @param  uid  用户id
     * @param  tableType  对应的楼盘表
     */
    public function interestCommunity($type,$page=1){
        $currPage = ($page == 1) ? $page : substr($page,2);
        $take = $this->dataNumber;  // 每页显示的数目

        $skip = ($currPage-1)*$take;
        $commnitySearch = new Search();
        $communityImage = '/image/noImage.png';
        // 查询用户一些信息
        $info = $this->UserDao->getUserInfo($this->uid);

        if($type == 'xinF'){ // 关注楼盘---新房
            $url = '/user/interCommunity/xinF';
            // 查询关注新盘的总数
            $totals = $this->UserDao->getInterCommunityTotal($this->uid,'3','new');
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);

            $interCommunityIds = $this->UserDao->GetCommInfo($this->uid,'3','new',$skip,$take);
            $interCommunityIds = self::objectToArray($interCommunityIds);

            $newIds = [];
            $communityData = '';
            if(!empty($interCommunityIds)){
                foreach($interCommunityIds as $new){
                    $newIds[] = $new['interestId'];
                }
                $communityData = $commnitySearch->searchCommunityListByIds($newIds,1)->docs;
                $communityData = self::getCommunityCityArea($communityData, $interCommunityIds);
            }
            $interComm = true;
            $view = 'user.userinter.interBuildXf';
            //return view('user.userinter.interBuildXf',compact('communityData','communityImage','pageHtml','interCommXinf','info'));
        }
        if($type == 'esF'){  // 关注楼盘---小区
            $url = '/user/interCommunity/esF';
            // 查询关注二手盘的总数
            $totals = $this->UserDao->getInterCommunityTotal($this->uid,'3','old');
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            //dd($pageHtml);
            $interCommunityIds = $this->UserDao->GetCommInfo($this->uid,'3','old',$skip,$take);
            $interCommunityIds = self::objectToArray($interCommunityIds);

            $oldIds = $type1 = [];
            $communityData = '';
            if(!empty($interCommunityIds)){
                foreach($interCommunityIds as $old){
                    $oldIds[] = $old['interestId'];
                }
                $communityData = $commnitySearch->searchCommunityListByIds($oldIds)->docs;
                $communityData = self::getCommunityCityArea($communityData, $interCommunityIds);
            }
            $view = 'user.userinter.interBuildXq';
            $interComm = true;

        }
        //dd($communityData);
        return view($view,compact('communityData','communityImage','pageHtml','interComm','info'));
    }


    /**
     *  关注的房源
     * @param  $id     用户id
     * @param
     * @param
     */
    public function interHouse($type,$page=1){
        $currPage = ($page == 1) ? $page : substr($page,2);
        $take = $this->dataNumber;  // 每页显示的数目
        //$take = 1;  // 每页显示的数目
        $skip = ($currPage-1)*$take;
        $interHouse = true;
        $houseImage = '/image/noImage.png';
        // 查询用户一些信息
        $info = $this->UserDao->getUserInfo($this->uid);
        if($type == 'xqsale'){
            $url = '/user/interHouse/xqsale';
            $totals = $this->UserDao->getInterHouseTotal($this->uid,'3','sale');
            $interHouseIds = $this->UserDao->getInterHouseIds($this->uid,'3','sale',$skip,$take);
            $houseData = !empty($interHouseIds) ? self::getHouseDataByEs('sale', $interHouseIds) : '';
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            $view = 'user.userinter.interHouseZzSale';
        }

        if($type == 'xqrent'){
            $url = '/user/interHouse/xqrent';
            $totals = $this->UserDao->getInterHouseTotal($this->uid,'3','rent');
            $interHouseIds = $this->UserDao->getInterHouseIds($this->uid,'3','rent',$skip,$take);
            $houseData = !empty($interHouseIds) ? self::getHouseDataByEs('rent', $interHouseIds) : '';
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            $view = 'user.userinter.interHouseZzRent';
        }

        if($type == 'officesale'){
            $url = '/user/interHouse/officesale';
            $totals = $this->UserDao->getInterHouseTotal($this->uid,'2','sale');
            $interHouseIds = $this->UserDao->getInterHouseIds($this->uid,'2','sale',$skip,$take);
            $houseData = !empty($interHouseIds) ? self::getHouseDataByEs('sale', $interHouseIds) : '';
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            $view = 'user.userinter.interHouseXzlSale';
        }

        if($type == 'officerent'){
            $url = '/user/interHouse/officerent';
            $totals = $this->UserDao->getInterHouseTotal($this->uid,'2','rent');
            $interHouseIds = $this->UserDao->getInterHouseIds($this->uid,'2','rent',$skip,$take);
            $houseData = !empty($interHouseIds) ? self::getHouseDataByEs('rent', $interHouseIds) : '';
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            $view = 'user.userinter.interHouseXzlRent';
        }

        if($type == 'shopsale'){
            $url = '/user/interHouse/shopsale';
            $totals = $this->UserDao->getInterHouseTotal($this->uid,'1','sale');
            $interHouseIds = $this->UserDao->getInterHouseIds($this->uid,'1','sale',$skip,$take);
            $houseData = !empty($interHouseIds) ? self::getHouseDataByEs('sale', $interHouseIds) : '';
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            $view = 'user.userinter.interHouseSpSale';
        }

        if($type == 'shoprent'){
            $url = '/user/interHouse/shoprent';
            $totals = $this->UserDao->getInterHouseTotal($this->uid,'1','rent');
            $interHouseIds = $this->UserDao->getInterHouseIds($this->uid,'1','rent',$skip,$take);
            $houseData = !empty($interHouseIds) ? self::getHouseDataByEs('rent', $interHouseIds) : '';
            $pageHtml = $this->pageUtil->RentPaging($totals,$currPage,$take,$url);
            $view = 'user.userinter.interHouseSpRent';
        }
        //dd($houseData);
        return view($view,compact('interHouse','houseData','houseImage','pageHtml','info'));
        
    }
    /**
     * 从接口获取房源的基本信息
     * @param  $type
     * @param  $data
     */
    private function getHouseDataByEs($type, $data){
        if($type == 'sale'){   // 出售
            $search = new Search('hs');
        }
        if($type == 'rent'){   // 出租
            $search = new Search('hr');
        }
        $house = $search->searchHouseListByIds($data)->docs;
        $ids = [];  // 索引中没有数据的房源id
        foreach($house as $key => $value){
            if(!$value->found){
                $ids[] = $value->_id;
            }else{
                $house[$key]->_source->name = RedisCacheUtil::getCommunityNameById($value->_source->communityId);
            }
        }
        if(!empty($ids)){
            $data = $this->UserDao->getHouseDataByIds($type, $ids);
            // 处理数据  获得楼盘名称和经纪人名称和联系电话
            $info = self::getBrokerCommunityName($data);
        }else{
            $info = '';
        }
        //dd($house,$info,$ids);
        return [
            'house' => $house,
            'info' => $info,
        ];
    }

    /**
     * 处理数据  获得楼盘名称和经纪人名称和联系电话
     * @param $data
     */
    private function getBrokerCommunityName($data){
        if(empty($data)) return '';
        $brokerIds = $communityIds = [];
        foreach($data as $key => $val){
            $brokerIds[] = $val->uid;
            $data[$key]->name = RedisCacheUtil::getCommunityNameById($val->communityId);
            //$communityIds[] = $val->communityId;
        }
        // 查询经纪人
        if(!empty($brokerIds)){
            $broker = $this->UserDao->getBrokerName($brokerIds);
            if(!empty($broker)){
                foreach($data as $key => $val){
                    foreach($broker as $b){
                        if($b->id == $val->uid){
                            $data[$key]->brokerName = $b->realName;
                            $data[$key]->brokerMobile = $b->mobile;
                        }
                    }
                }
            }
        }
//        // 查询楼盘名称
//        if(!empty($communityIds)){
//
////            $community = $this->UserDao->getCommunityName($communityIds);
////            if(!empty($community)){
//                foreach($data as $key => $val){
//                    foreach($community as $c){
//                        if($c->id == $val->communityId){
//
//                            $data[$key]->name = $c->name;
//                        }
//                    }
//                }
////            }
//        }
        return $data;
    }

    /**
     *  ajax 请求出售房源的近七天变化信息
     */
    public function ajaxHouseSale(){
        $houseId = Input::get('id');
        $housetype = Input::get('type');
        if(!is_numeric($houseId)) return false;
        $isNew = Input::get('isNew');
        if($isNew == 0){
            // 二手盘的房源
            $saleInfo = $this->UserDao->GetHousePrice($houseId,'sale','housesalepricelog2',$housetype);  // 价格变动
            $saleState = $this->UserDao->GetHouseState($houseId,'sale','mysql_oldhouse',$housetype);// 状态变动
        }else if($isNew == 1){
            // 新盘的房源
            $saleInfo = $this->UserDao->GetHousePrice($houseId,'sale','housesalepricelog',$housetype);  // 价格变动
            $saleState = $this->UserDao->GetHouseState($houseId,'sale','mysql_house',$housetype);// 状态变动
        }
        $time1 = time();  // 当前时间
        $time2 = $time1 - 7*24*3600;
        $change = 'salechange'.$houseId;  // 缓存的key
        if( Cache::has($change) ){
            return Cache::get($change);
        }else{
            // 发布状态
            if(!empty($saleState)){
                $state = ['待发布','已发布','违规'];
                $saleState[0]->state = $state[$saleState[0]->state];               
                // 在售状态
                $dealState = ['待售','在售','已售'];
                $saleState[0]->dealState = $dealState[$saleState[0]->dealState];               
                $saleState[0]->timeUpdate = substr($saleState[0]->timeUpdate,0,10);
                $changeInfo['saleState'] = $saleState;
            }else{
                $changeInfo['saleState'] = 1;
            }
            if(!empty($saleInfo)){
                $key = count($saleInfo)-1;
                foreach( $saleInfo as $sale){
                    if(strtotime($sale->changeTime) < $time1 && strtotime($sale->changeTime) > $time2){
                        $sale->diffPrice = ($sale->price) - ($saleInfo[$key]->price);
                        $sale->changeTime = substr($sale->changeTime,0,10);
                        $priceChange[] = $sale;
                    }
                }
                $changeInfo['priceChange'] = $priceChange;
            }else{
                $changeInfo['priceChange'] = 1;
            }
            //dd($changeInfo);
            Cache::put($change,$changeInfo,24*60);           
            return json_encode($changeInfo);
        }
    }
    /**
     *  ajax 请求出租房源的近七天变化信息
     * @param  $houseId   房源id
     * @param  $housetype 房源类型
     * @param  $isNew     是否是新盘下的房源
     */
    public function ajaxHouseRent(){
        $houseId = Input::get('id');
        $housetype = Input::get('type');
        $isNew = Input::get('isNew');       
        if($isNew == 0){
            // 二手盘的房源
            $rentInfo = $this->UserDao->GetHousePrice($houseId,'rent','houserentpricelog2',$housetype);  // 价格变动
            $rentState = $this->UserDao->GetHouseState($houseId,'rent','mysql_oldhouse',$housetype);// 状态变动
        }else if($isNew == 1){
            // 新盘的房源           
            $rentState = $this->UserDao->GetHouseState($houseId,'rent','mysql_house',$housetype);// 状态变动
        }
        $time1 = time();  // 当前时间
        $time2 = $time1 - 7*24*3600;
        $change = 'rentchange'.$houseId;  // 缓存的key
        if( Cache::has($change) ){
            return json_encode(Cache::get($change));
        }else{
             //发布状态
            if(!empty($rentState)){
                $state = ['待发布','已发布','违规'];
                $rentState[0]->state = $state[$rentState[0]->state];
                // 交易状态
                $dealState = ['待租','已租'];
                $rentState[0]->dealState = $dealState[$rentState[0]->dealState];
                $rentState[0]->timeUpdate = substr($rentState[0]->timeUpdate,0,10);
                $changeInfo['rentState'] = $rentState;
            }else{
                $changeInfo['rentState'] = 1;
            }
            if(isset($rentInfo) && !empty($rentInfo)){
                $key = count($rentInfo)-1;
                foreach( $rentInfo as $rent){
                    if(strtotime($rent->changeTime) < $time1 && strtotime($rent->changeTime) > $time2){
                        $rent->diffPrice = ($rent->price) - ($rentInfo[$key]->price);
                        $rent->changeTime = substr($rent->changeTime,0,10);
                        $priceChange[] = $rent;
                    }
                }
                $changeInfo['priceChange'] = $priceChange;
            }else{
                $changeInfo['priceChange'] = 1;
            }                      
            Cache::put($change,$changeInfo,24*60);           
            return json_encode($changeInfo);
        }
        
        
        
    }

    /**
     *  关注的  （新盘） 近七天变化信息
     * @param    $id     楼盘id
     * @param
     * @param    
     */
    public function communityChange(){
        $id = Input::get('id');
        if(!is_numeric($id)){
            return false;
        }
        $change = 'newcommunity'.$id.'change';  // 缓存的key
        if(Cache::has($change)){
            $changeInfo = Cache::get($change);
            return json_encode($changeInfo);
        }else{
            $info = $this->UserDao->getCommunityChangeInfo($id);
            //dd($info);
            $price = [];
            $discount = [];
            $dianyou = [];
            $stime = time() - (7*86400);
            $etime = strtotime(date('Y-m-d 23:59:59'));
            if(!empty($info['info2'])){
                foreach($info['info2'] as $inf){
                    $inf->detail = json_decode($inf->detail);
                    if($inf->type == 1){
                        $price[] = $inf;              
                    }else if($inf->type == 3 && strtotime($inf->timeCreate) > $stime && strtotime($inf->timeCreate) < $etime){
                        $discount[] = $inf; 
                    }else if($inf->type == 4 && strtotime($inf->timeCreate) > $stime && strtotime($inf->timeCreate) < $etime){
                        $dianyou[] = $inf;
                    }
                }
                $price1 = [];
                $price2 = [];
                if(count($price) > 1){
                    foreach($price as $pri){
                        if(strtotime($pri->timeCreate) > $stime && strtotime($pri->timeCreate) < $etime){
                            $price1[] = $pri;
                        }else{
                            $price2[] = $pri;
                        }
                    }
                }           
                $changeInfo = ['price1'=>$price1,'price2'=>$price2,'discount'=>$discount,'dianyou'=>$dianyou,'info'=>$info['info1']];
                return json_encode($changeInfo); 
            }else{
                return 5;
            } 
        }
        
    }



    /**
     * 对象转数组
     * @param $data
     * @return mixed
     */
    private function objectToArray($data){
        return json_decode(json_encode($data),true);
    }

    /**
     * 获得楼盘的城区和商圈数据
     * @param $data
     */
    private function getCommunityCityArea($data, $arrayType){
        //dd($data,$arrayType);
        if(empty($data)) return '';
        $cityAreaIds = self::getCityAreaIdArray($data);  // 获得城市id数组
        if(!empty($cityAreaIds)){
            $city['area'] = self::getCityAreaName($cityAreaIds['areaId']);
            $city['business'] = self::getBusinessName($cityAreaIds['businessAreaId']);
        }

        foreach($data as $key => $val){
            if($val->found){
                $data[$key]->_source->areaName = $city['area'][$val->_source->cityAreaId];
                $data[$key]->_source->businessName = isset($city['business'][$val->_source->businessAreaId]) ? $city['business'][$val->_source->businessAreaId] : '';
                if(!empty($val->_source->specialOffers)){
                    $data[$key]->_source->dianyou = explode('_',$val->_source->specialOffers);
                }
                // 处理同一楼盘不同物业类型的问题
                foreach($arrayType as $key1 => $type){
                    if($type['interestId'] == $val->_source->id){
                        $type1 = $type['type1'];
                        unset($arrayType[$key1]);
                        break;
                    }
                }
                $cType2 = explode('|',$val->_source->type2);
                foreach($cType2 as $cType){
                    if(substr($cType,0,1) == $type1){
                        $type2 = $cType;
                        break;
                    }
                    if($cType == '303' && $type1 == '2'){
                        $type2 = $cType;
                        break;
                    }
                }

                $data[$key]->_source->communityType = config('communityType2')[$type2];
                $data[$key]->_source->cType = $type2;
                $data[$key]->_source->cType1 = $type1;
                $typeinfo = 'type'.$type2.'Info';
                //$data[$key]->_source->$typeinfo = json_decode($val->_source->$typeinfo);
                $val->_source->$typeinfo = json_decode($val->_source->$typeinfo);
                $data[$key]->_source->propertyYear = isset($val->_source->$typeinfo->propertyYear) ? $val->_source->$typeinfo->propertyYear : '';
                $data[$key]->_source->propertyFee = isset($val->_source->$typeinfo->propertyFee) ? $val->_source->$typeinfo->propertyFee : '';
            }
        }
        //dd($data);
        return $data;
    }

    /**
     * 获得城市id数组
     * @param $data
     */
    private function getCityAreaIdArray($data){
        $cityAreaIds = [];
        foreach($data as $val){
            if($val->found){
                $cityAreaIds['areaId'][] = $val->_source->cityAreaId;
                $cityAreaIds['businessAreaId'][] = $val->_source->businessAreaId;
            }
        }
        return $cityAreaIds;
    }

    /**
     * 获得城区名称
     */
    private function getCityAreaName($areaId){
        $areaName = [];
        foreach($areaId as $id){
            if(!empty($id)){
                $areaName[$id] = RedisCacheUtil::getCityAreaNameById($id);
            }
        }
        return $areaName;
    }

    /**
     * 获得商圈名称
     */
    private function getBusinessName($businessId){
        $businessName = [];
        foreach($businessId as $id){
            if(!empty($id)){
                $businessName[$id] = RedisCacheUtil::getBussinessNameById($id);
            }
        }
        return $businessName;
    }

    /**
     * 个人中心---个人房源
     */
    public function userPersonalHouse($type=''){
        $personal = true;
        $info = $this->UserDao->getUserInfo($this->uid);
        $houseImage = '/image/noImage.png';
        $sale = $this->UserDao->searchHouseByUid($this->uid,'housesale');
        $sale = count($sale);
        $rent = $this->UserDao->searchHouseByUid($this->uid,'houserent');
        $rent = count($rent);
        $houseList = '';
        if(empty($type)){
            if($sale > 0){
                $type = 'sale';
            }else if($sale <= 0 && $rent > 0){
                $type = 'rent';
            }
        }
        if($type == 'sale' && $sale > 0){
            // 查询出售房源信息
            $field = ['id','title','communityId','houseType1','houseType2','fitment','address','area','thumbPic','picCount','roomStr','faceTo','currentFloor','totalFloor','price1','price2','timeUpdate','timeCreate','state'];
            $house = $this->UserDao->getPersonalHouseList('sale', $this->uid, $field);
            // 获得楼盘名称
            $house = self::getCommunityNameById($house);
        }
        if($type == 'rent' && $rent > 0){
            $field = ['id','title','communityId','houseType1','houseType2','fitment','address','area','rentType','thumbPic','picCount','roomStr','faceTo','currentFloor','totalFloor','price1','price2','transferPrice','timeUpdate','timeCreate','state'];
            $house = $this->UserDao->getPersonalHouseList('rent', $this->uid, $field);
            // 获得楼盘名称
            $house = self::getCommunityNameById($house);
        }
        return view('user.userinter.userHouse',compact('personal','houseList','houseImage','sale','rent','info','type','house'));
    }

    /**
     * 获得楼盘名称
     * @param $data
     */
    private function getCommunityNameById($data){
        $communityIds = [];

        if(!empty($data)){
            foreach($data as $val){
                $communityIds[] = $val->communityId;
            }
        }
        $communityIds = array_unique($communityIds);
        if(!empty($communityIds)){
            $community = $this->UserDao->getCommunityName($communityIds);
        }
        if(isset($community) && !empty($community)){
            foreach($data as $key => $val){
                foreach($community as $comm){
                    if($comm->id == $val->communityId){
                        $data[$key]->name = $comm->name;
                        $data[$key]->addr = $comm->address;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * ajax更改房源的状态
     * @param $type   cancel  取消发布   fabu  发布
     */
    public function updateHouseState($type){
        $hId = Input::get('id');
        $hType = Input::get('hType');
        if(!is_numeric($hId)) return json_encode(['res' => 'error','data' => '参数错误']);
        if($hType == 'sale'){
            $search = new Search('hs');
            $table = 'housesale';
        }else if($hType == 'rent'){
            $search = new Search('hr');
            $table = 'houserent';
        }

        if($type == 'cancel'){  // 取消发布
            $data['state'] = 0;
            $data['dealState'] = 0;
            $message = '取消发布成功';
            $res = json_decode($search->houseIndexDelete($hId));  // 取消发布要更新索引
            $flag = $this->UserDao->updateHouseState($hId,$data,$table);
        }elseif($type == 'fabu'){   // 发布
            $data['state'] = 1;
            $data['dealState'] = 1;
            // 先查询当前用户发布的房源总数
            $houseSaleNum = DB::connection('mysql_oldhouse')->table('housesale')->where('uId',$this->uid)->where('state','1')->where('publishUserType','0')->lists('id');
            $houseRentNum = DB::connection('mysql_oldhouse')->table('houserent')->where('uId',$this->uid)->where('state','1')->where('publishUserType','0')->lists('id');
            $num = count($houseSaleNum) + count($houseRentNum);
            if($num >= 10){
                return json_encode(['res' => 'total','data' => '您最多能发布10套房源']);
            }
            $message = '发布成功';
            $flag = $this->UserDao->updateHouseState($hId,$data,$table);
        }else{ // 删除
            $message = '删除成功';
            $flag = $this->UserDao->deleteHouse($hId,$table);
        }

        if($flag){
            return json_encode(['res' => 'success','data' => $message]);
        }
        return json_encode(['res' => 'fail','data' => '操作失败']);
    }
    
}