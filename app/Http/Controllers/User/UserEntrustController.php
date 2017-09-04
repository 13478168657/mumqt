<?php
namespace App\Http\Controllers\User;

use App\Dao\User\BrokerDao;
use App\ListInputView;
use Auth;
use DB;
use App\Dao\User\MyInfoDao;
use App\Dao\User\MyEntrustDao;
use App\Dao\City\CityDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Utils\UserIdUtil;
use App\Http\Controllers\Lists\PublicController;
use Redirect;
use Hash;
use Session;
use App\Services\Search;

/**
 *  我的委托控制器
 * @date   2016年02月04日  下午14:42分
 * @author zhuwei
 */
class UserEntrustController extends Controller
{
    public $usertable;
    protected $MyInfoDao;
    protected $CityDao;
    private $info;
    private $myEntrust;

    public function __construct()
    {
        // 判断用户是否登录  并且 用户类型为 普通个人用户
        if (!Auth::check() || Auth::user()->type != 1) {
            $this->beforeFilter('UserMyInfoFilter');
            //Redirect::to('/')->send();
        } else {
            $datebase = new UserIdUtil();
            $id = Auth::user()->id;
            $this->usertable = $datebase->getNodeNum($id);
            $this->MyInfoDao = new MyInfoDao();
            $this->CityDao = new CityDao();
            $this->myEntrust = new MyEntrustDao();
        }
    }

    /**
     * 委托房源页面，求租，求购
     * @param $type
     * @return mixed
     */
    public function entrustIndex($type)
    {
        $pageset = 20;
        $info = $this->MyInfoDao->getcustomers();
        $uid = Auth::user()->id;

        if ($type == 'Qz' || $type == 'Qs') {
            $public = new PublicController();
            $data['subWays'] = $public->getSubWayAll();
            $data['subWayStation'] = $public->getSubWayStationAll();
            $data['houseType1'] = config('conditionConfig.type.text');
            $data['trades'] = config('conditionConfig.spind.text');
        }
        //////////////求租/////////////
        if (empty($type) || $type == 'Qz') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            $select = ['id', 'title','searchType', 'cityId', 'cityAreaId', 'businessAreaId', 'subwayLineId', 'subwayId','communityId', 'houseRoom', 'houseType1', 'houseRoom', 'priceMin', 'priceMax', 'areaMin', 'areaMax', 'trade', 'describe','entrustState','hadCommissioned','currentFloor'];
            $houseWanted = $this->myEntrust->rentSaleWanted('houserentwanted', $uid, $select, $pageset);
            $data['houseWanted'] = $houseWanted->items();
            $data['pageHtml'] = $houseWanted->render();
            $data['type2'] = $type;
            return view('user.userEntrust.entrustQz', $data);
        }
        //////////////求购/////////////
        if ($type == 'Qs') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            $select = ['id', 'title','searchType', 'cityId', 'cityAreaId', 'businessAreaId', 'subwayLineId', 'subwayId','communityId','houseType1', 'houseRoom', 'priceMin', 'priceMax', 'areaMin', 'areaMax', 'trade', 'describe','entrustState','hadCommissioned','currentFloor'];
            $houseWanted = $this->myEntrust->rentSaleWanted('housesalewanted', $uid, $select, $pageset);
            $data['houseWanted'] = $houseWanted->items();
            $data['pageHtml'] = $houseWanted->render();
            $data['type2'] = $type;
            return view('user.userEntrust.entrustQs', $data);
        }
        //////////////出租/////////////
        if ($type == 'rent') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            $select = ['id', 'communityId', 'houseType1', 'houseType2', 'fitment', 'rentType', 'area', 'roomStr', 'faceTo', 'currentFloor', 'totalFloor', 'price1', 'price2', 'hadCommissioned', 'timeUpdate', 'timeCreate','entrustState'];
            $data['house'] = self::entrustHouseData('rent', $select);
            return view('user.userEntrust.entrustRent', $data);
        }
        //////////////出售/////////////
        if ($type == 'sale') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            $select = ['id', 'communityId', 'houseType1', 'houseType2', 'fitment', 'area', 'roomStr', 'faceTo', 'currentFloor', 'totalFloor', 'price1', 'price2', 'hadCommissioned', 'timeUpdate', 'timeCreate','entrustState'];
            $data['house'] = self::entrustHouseData('sale', $select);
            return view('user.userEntrust.entrustSale', $data);
        }
    }

    /**
     * 获取委托房源认领列表
     * @param $type
     * @param $id
     * @return \Illuminate\View\View
     */
    public function entrustLook($type, $id)
    {
        $info = $this->MyInfoDao->getcustomers();
        $search = new Search();
        $searchRent = new Search('hr');
        $searchSale = new Search('hs');
        $cityDao=new CityDao();
        if ($type == 'Qz' || $type == 'Qs') {
            $data['houseType1'] = config('conditionConfig.type.text');
            $data['trades'] = config('conditionConfig.spind.text');
        }
        ////////////////////////////////求租///////////////////////////////////
        if (empty($type) || $type == 'Qz') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            $data['sr'] = 'r';
            $select = ['id', 'title', 'cityId','searchType', 'subwayId','communityId','subwayLineId', 'cityAreaId','currentFloor', 'businessAreaId', 'houseType1', 'houseRoom', 'priceMin', 'priceMax', 'areaMin', 'areaMax', 'trade', 'describe'];
            $data['house'] = $this->myEntrust->rentSaleWantedById('houserentwanted', $select, $id);
            //查询认领列表
            $select2 = ['id', 'hwId', 'uId', 'brokerId', 'cityId', 'status', 'hIds'];
            $entrustList = $this->myEntrust->getEntrustHouseDetailByhwId('houserentwanted_delegate', $select2, $id);
            //获取认领信息
            $entrustArr = [];
            if ($entrustList) {
                foreach ($entrustList as $v) {
                    $brokerInfo = [];
                    $broker = isset($search->searchBrokerById($v->brokerId)->_source) ? $search->searchBrokerById($v->brokerId)->_source : '';
                    if ($broker) {
                        $brokerInfo['bId'] = $broker->id;
                        $brokerInfo['realName'] = $broker->realName;
                        $brokerInfo['mobile'] = $broker->mobile;
                        $brokerInfo['company'] = $broker->company;
                        $brokerInfo['idcardState'] = $broker->idcardState;
                        $brokerInfo['jobCardState'] = $broker->jobCardState;
                        if(!$brokerInfo['company']){
                            $brokerDao=new BrokerDao();
                            $info=$brokerDao->getBroker($broker->id);
                            $companyId=$info?$info->companyId:0;
                            $brokerInfo['company']=$brokerDao->getBrokerCompany($companyId)?$brokerDao->getBrokerCompany($companyId)->name:'';
                        }
                        $brokerInfo['photo'] = get_img_url('userPhoto', $broker->photo);
                        $brokerInfo['cityArea'] = $cityDao->getCityArea($broker->cityAreaId)?$cityDao->getCityArea($broker->cityAreaId)[0]->name:'';
                        $brokerInfo['businessArea'] = $cityDao->getBusinessArea($broker->businessAreaId)?$cityDao->getBusinessArea($broker->businessAreaId)[0]->name:'';
                    } else {
                        $brokerInfo = [];
                    }
                    $hIdsArr = explode('|', $v->hIds);
                    $houseArr = [];
                    foreach ($hIdsArr as $vv) {
                        $houseInfo = [];
                        $re = isset($searchRent->searchHouseById($vv)->_source) ? $searchRent->searchHouseById($vv)->_source : '';
                        if ($re) {
                            $houseInfo['id'] = $re->id;
                            $houseInfo['title'] = $re->title;
                            $houseInfo['thumbPic'] = get_img_url("houseRent", $re->thumbPic);
                            $houseInfo['communityId'] = $re->communityId;
                            $houseInfo['tmp_communityId'] = $re->tmp_communityId;
                            $houseInfo['address'] = $re->address;
                            $houseInfo['area'] = $re->area;
                            $houseInfo['rentType'] = $re->rentType?config('houseState.Zz.rentType')[$re->rentType]:'';
                            $houseInfo['fitment'] = config('houseState.fitment')[$re->fitment];
                            $houseInfo['faceTo'] = $re->faceTo?config('houseState.faceTo')[$re->faceTo]:'';
                            $houseInfo['currentFloor'] = $re->currentFloor;
                            $houseInfo['totalFloor'] = $re->totalFloor;
                            $houseInfo['priceUnit'] = $re->priceUnit?config('houseState.rent.priceUnit')[$re->priceUnit]:'';
                            $index='price'.$re->priceUnit;
                            $houseInfo['price1']=$re->price1;
                            $houseInfo['price2']=$re->price2;
                            $houseInfo['price3']=$re->price3;
                            $houseInfo['price4']=$re->price4;
                            $houseInfo['price5']=$re->price5;
                            $houseInfo['price'] = $houseInfo['priceUnit'] ? $houseInfo[$index] : '';
                            $houseInfo['timeCreate'] = substr($re->timeCreate,0,10);
                            $timeUpdate=strtotime($re->timeUpdate);
                            $interval=time()-$timeUpdate;
                            if($interval<=60){
                                $houseInfo['timeUpdate']=$interval.'秒前';
                            }elseif($interval<=(60*60)){
                                $houseInfo['timeUpdate']=intval($interval/60).'分钟前';
                            }elseif($interval<=(60*60*24)){
                                $houseInfo['timeUpdate']=intval($interval/3600).'小时前';
                            }elseif($interval<=(60*60*24*15)){
                                $houseInfo['timeUpdate']=intval($interval/3600/24).'天前';
                            }else{
                                $houseInfo['timeUpdate']=substr($re->timeUpdate,0,10);
                            }
                            $houseInfo['roomStr'] = $re->roomStr?$re->roomStr[0].'室'.$re->roomStr[2].'厅':'';
                        } else {
                            $houseInfo = [];
                        }
                        //if ($brokerInfo && $houseInfo) $entrustArr[] = array_merge($houseInfo, $brokerInfo);
                        if ($houseInfo) $houseArr[] = $houseInfo;
                    }
                    if ($brokerInfo) $entrustArr[] = array_merge($brokerInfo, ['data'=>$houseArr]);
                }
            }
            $data['entrustList'] = $entrustArr;
            $data['type'] = $type;
            $public = new PublicController();
            $data['subWays'] = $public->getSubWayAll();
            $data['subWayStation'] = $public->getSubWayStationAll();
            return view('user.userEntrust.entrustLook', $data);
        }
        
        ///////////////////////求购////////////////////////////////
        if ($type == 'Qs') {

            $data['info'] = $info;
            $data['entrustQz'] = true;
            $data['sr'] = 's';
            $select = ['id', 'title', 'cityId','searchType', 'subwayId','subwayLineId','communityId','cityAreaId', 'currentFloor','businessAreaId', 'houseType1', 'houseRoom', 'priceMin', 'priceMax', 'areaMin', 'areaMax', 'trade', 'describe'];
            $data['house'] = $this->myEntrust->rentSaleWantedById('housesalewanted', $select, $id);

            //查询认领列表
            $select2 = ['id', 'hwId', 'uId', 'brokerId', 'cityId', 'status', 'hIds'];
            $entrustList = $this->myEntrust->getEntrustHouseDetailByhwId('housesalewanted_delegate', $select2, $id);
            //获取认领信息
            if ($entrustList) {
                $entrustArr = [];
                foreach ($entrustList as $v) {
                    $brokerInfo = [];
                    $broker = isset($search->searchBrokerById($v->brokerId)->_source) ? $search->searchBrokerById($v->brokerId)->_source : '';
                    if ($broker) {
                        $brokerInfo['bId'] = $broker->id;
                        $brokerInfo['realName'] = $broker->realName;
                        $brokerInfo['mobile'] = $broker->mobile;
                        $brokerInfo['company'] = $broker->company;
                        $brokerInfo['idcardState'] = $broker->idcardState;
                        $brokerInfo['jobCardState'] = $broker->jobCardState;
                        if(!$brokerInfo['company']){
                            $brokerDao=new BrokerDao();
                            $info=$brokerDao->getBroker($broker->id);
                            $companyId=$info?$info->companyId:0;
                            $brokerInfo['company']=$brokerDao->getBrokerCompany($companyId)?$brokerDao->getBrokerCompany($companyId)->name:'';
                        }
                        $brokerInfo['photo'] = get_img_url('userPhoto', $broker->photo);
                        $brokerInfo['cityArea'] = $cityDao->getCityArea($broker->cityAreaId)?$cityDao->getCityArea($broker->cityAreaId)[0]->name:'';
                        $brokerInfo['businessArea'] = $cityDao->getBusinessArea($broker->businessAreaId)?$cityDao->getBusinessArea($broker->businessAreaId)[0]->name:'';
                    } else {
                        $brokerInfo = [];
                    }
                    $hIdsArr = explode('|', $v->hIds);
                    $houseArr = [];
                    foreach ($hIdsArr as $vv) {
                        $houseInfo = [];
                        $re = isset($searchSale->searchHouseById($vv)->_source) ? $searchSale->searchHouseById($vv)->_source : '';
                        if ($re) {
                            $houseInfo['id'] = $re->id;
                            $houseInfo['title'] = $re->title;
                            $houseInfo['thumbPic'] = get_img_url("houseRent", $re->thumbPic);
                            $houseInfo['communityId'] = $re->communityId;
                            $houseInfo['tmp_communityId'] = $re->tmp_communityId;
                            $houseInfo['address'] = $re->address;
                            $houseInfo['area'] = $re->area;
                            $houseInfo['rentType'] = '';
                            $houseInfo['fitment'] = config('houseState.fitment')[$re->fitment];
                            $houseInfo['faceTo'] = $re->faceTo?config('houseState.faceTo')[$re->faceTo]:'';
                            $houseInfo['currentFloor'] = $re->currentFloor;
                            $houseInfo['totalFloor'] = $re->totalFloor;
//                            $houseInfo['priceUnit'] = $re->priceUnit?config('houseState.rent.priceUnit')[$re->priceUnit]:'';
//                            $index='price'.$re->priceUnit;
//                            $houseInfo['price1']=$re->price1;
//                            $houseInfo['price2']=$re->price2;
//                            $houseInfo['price'] = $houseInfo['priceUnit'] ? $houseInfo[$index] : '';
                            $houseInfo['price']=$re->price2;
                            $houseInfo['priceUnit']='万元';
                            $houseInfo['timeCreate'] = substr($re->timeCreate,0,10);
                            $timeUpdate=strtotime($re->timeUpdate);
                            $interval=time()-$timeUpdate;
                            if($interval<=60){
                                $houseInfo['timeUpdate']=$interval.'秒前';
                            }elseif($interval<=(60*60)){
                                $houseInfo['timeUpdate']=intval($interval/60).'分钟前';
                            }elseif($interval<=(60*60*24)){
                                $houseInfo['timeUpdate']=intval($interval/3600).'小时前';
                            }elseif($interval<=(60*60*24*15)){
                                $houseInfo['timeUpdate']=intval($interval/3600/24).'天前';
                            }else{
                                $houseInfo['timeUpdate']=substr($re->timeUpdate,0,10);
                            }
                            $houseInfo['roomStr'] = $re->roomStr?$re->roomStr[0].'室'.$re->roomStr[2].'厅':'';
                        } else {
                            $houseInfo = [];
                        }
                        if ($houseInfo) $houseArr[] = $houseInfo;
                    }
                    if ($brokerInfo) $entrustArr[] = array_merge($brokerInfo, ['data'=>$houseArr]);
                }
            }else{
                exit('未查到认领信息!');
            }
            $data['entrustList'] = $entrustArr;
            $data['type'] = $type;
            $public = new PublicController();
            $data['subWays'] = $public->getSubWayAll();
            $data['subWayStation'] = $public->getSubWayStationAll();
            return view('user.userEntrust.entrustLook', $data);
        }
        /////////////////////出租/////////////////////////////////
        if ($type == 'rent') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            /********  查询该房源数据start  ********/
            $data['type'] = $type;
            $data['id'] = $id;
            $select = ['id', 'communityId', 'houseType1', 'houseType2', 'fitment', 'rentType', 'area', 'roomStr', 'faceTo', 'currentFloor', 'totalFloor', 'price1', 'price2', 'hadCommissioned', 'timeUpdate', 'timeCreate', 'entrustState'];
            $data['house'] = $this->myEntrust->rentSaleWantedById('houserententrust', $select, $id);
            $address = $name = '';
            if (!empty($data['house'])) {
                $community = $this->myEntrust->getCommunityDataByIdArray([$data['house']->communityId]);
                if (!empty($community)) {
                    $address = $community[0]->address;
                    $name = $community[0]->name;
                }
            }
            $data['house']->name = $name;
            $data['house']->addr = $address;
            /********  查询该房源数据end    ********/
            // 查询认领的经纪人
            $brokerId = $this->myEntrust->getEntrustBrokerIdList('houserent_delegate', $id, Auth::user()->id);
            $broker = [];
            if (!empty($brokerId)) {
                $search = new Search();
                foreach ($brokerId as $val) {
                    $broker[] = $search->searchBrokerById($val);
                }
            }
            $data['broker'] = $broker;
            return view('user.userEntrust.brokerLook', $data);
        }
        /////////////////////////出售/////////////////////////////
        if ($type == 'sale') {
            $data['info'] = $info;
            $data['entrustQz'] = true;
            /********  查询该房源数据start  ********/
            $data['type'] = $type;
            $data['id'] = $id;
            $select = ['id', 'communityId', 'houseType1', 'houseType2', 'fitment', 'area', 'roomStr', 'faceTo', 'currentFloor', 'totalFloor', 'price1', 'price2', 'hadCommissioned', 'timeUpdate', 'timeCreate', 'entrustState'];
            $data['house'] = $this->myEntrust->rentSaleWantedById('housesaleentrust', $select, $id);
            $address = $name = '';
            if (!empty($data['house'])) {
                $community = $this->myEntrust->getCommunityDataByIdArray([$data['house']->communityId]);
                if (!empty($community)) {
                    $address = $community[0]->address;
                    $name = $community[0]->name;
                }
            }
            $data['house']->name = $name;
            $data['house']->addr = $address;
            /********  查询该房源数据end    ********/
            // 查询认领的经纪人
            $brokerId = $this->myEntrust->getEntrustBrokerIdList('housesale_delegate', $id, Auth::user()->id);
            $broker = [];
            if (!empty($brokerId)) {
                $search = new Search();
                foreach ($brokerId as $val) {
                    $broker[] = $search->searchBrokerById($val);
                }
            }
            $data['broker'] = $broker;
            return view('user.userEntrust.brokerLook', $data);
        }
    }


    /**
     * 出租、出售  委托房源数据处理
     * @param
     * @param   $houseType  分类  出租、出售
     * @param   $select     查询的字段
     */
    private function entrustHouseData($houseType, $select)
    {
        $table = ($houseType == 'rent') ? 'houserententrust' : 'housesaleentrust';
        $communityId = [];
        $uId = Auth::user()->id;
        $data = $this->myEntrust->getEntrustHouseDetail($table, $select, $uId);
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $communityId[] = $val->communityId;
            }
        }

        if (!empty($communityId)) { // 获取楼盘名称和地址
            $community = $this->myEntrust->getCommunityDataByIdArray($communityId);
            foreach ($data as $key => $val) {
                foreach ($community as $comm) {
                    if ($comm->id == $val->communityId) {
                        $data[$key]->name = $comm->name;
                        $data[$key]->addr = $comm->address;
                    }
                }
            }
        }
        return $data;
    }

    //
    public function entrustDel($type)
    {
        if ($type == 'sale') {
            $table = 'housesalewanted';
        } else {
            $table = 'houserentwanted';
        }
        $id = Input::get('id');
        if (!empty($id)) {
            $res = $this->myEntrust->rentSaleWanteDel($table, $id);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /**
     * 取消当前经纪人委托
     * @return string
     */
    public function removeBroker()
    {
        $type = Input::get('type');
        $bId = Input::get('bId');
        $hId = Input::get('hId');
        if (!is_numeric($bId) || !is_numeric($hId) || !in_array($type, ['Qz', 'Qs', 'sale', 'rent'])) {
            //return json_encode(['res' => 'error', 'data' => '操作失败！']);
            return 0;
        }
        $table = self::getTableNameByType($type);//dd($type,$bId,$hId,$table);
        DB::connection('mysql_oldhouse')->beginTransaction();
        try {
            $res = $this->myEntrust->updateHouseState($bId, $hId, $table['table1'], $type);
            $flag = $this->myEntrust->updateEntrustClaimNum($hId, $table['table2']);
            if ($res && $flag) {
                DB::connection('mysql_oldhouse')->commit();
                //return json_encode(['res' => 'success', 'data' => '操作成功']);
                return 1;
            } else {
                DB::connection('mysql_oldhouse')->rollBack();
                //return json_encode(['res' => 'fail', 'data' => '操作失败']);
                return 0;
            }
        } catch (Exception $e) {
            DB::connection('mysql_oldhouse')->rollBack();
            //return json_encode(['res' => 'fail', 'data' => '操作失败']);
            return 0;
        }
    }

    /**
     * 取消当前全部经纪人委托
     * @return string
     */
    public function removeAll()
    {
        $type = Input::get('type');
        $hId = Input::get('hId');
        if (!is_numeric($hId) || !in_array($type, ['Qz', 'Qs', 'sale', 'rent'])) {
            //return json_encode(['res' => 'error', 'data' => '操作失败！']);
            return 0;
        }
        $table = self::getTableNameByType($type);
        DB::connection('mysql_oldhouse')->beginTransaction();
        $data['hadCommissioned'] = 0;
        $data['entrustState'] = 0;
        try {
            $res = $this->myEntrust->deleteEntrustDelegate($hId, $table['table1'], $type);
            $flag = $this->myEntrust->updateEntrustClaim($hId, $table['table2'], $data);
            if ($res && $flag) {
                DB::connection('mysql_oldhouse')->commit();
                //return json_encode(['res' => 'success', 'data' => '操作成功']);
                return 1;
            } else {
                DB::connection('mysql_oldhouse')->rollBack();
                //return json_encode(['res' => 'fail', 'data' => '操作失败']);
                return 0;
            }
        } catch (Exception $e) {
            DB::connection('mysql_oldhouse')->rollBack();
            //return json_encode(['res' => 'fail', 'data' => '操作失败']);
            return 0;
        }
    }
    /**
     * 开启当前全部经纪人委托
     * @return string
     */
    public function openAll(){
        $type = Input::get('type');
        $hId = Input::get('hId');
        if (!is_numeric($hId) || !in_array($type, ['Qz', 'Qs', 'sale', 'rent'])) {
            //return json_encode(['res' => 'error', 'data' => '操作失败！']);
            return 0;
        }
        $table = self::getTableNameByType($type);
        $data['entrustState'] = 1;
        $entrustRent = DB::connection('mysql_oldhouse')->table('houserententrust')->where('uId',Auth::user()->id)->where('entrustState','1')->lists('id');
        $entrustSale = DB::connection('mysql_oldhouse')->table('housesaleentrust')->where('uId',Auth::user()->id)->where('entrustState','1')->lists('id');
        $entrustQz = DB::connection('mysql_oldhouse')->table('houserentwanted')->where('uId',Auth::user()->id)->where('entrustState','1')->lists('id');
        $entrustQs = DB::connection('mysql_oldhouse')->table('housesalewanted')->where('uId',Auth::user()->id)->where('entrustState','1')->lists('id');
        $entrustNum = count($entrustRent) + count($entrustSale) + count($entrustQz) + count($entrustQs);
        if($entrustNum >= 20){
            return 2;
        }
        $flag = $this->myEntrust->updateEntrustClaim($hId, $table['table2'], $data);
        if($flag){
            //return json_encode(['res' => 'success', 'data' => '操作成功']);
            return 1;
        }
        //return json_encode(['res' => 'fail', 'data' => '操作失败']);
        return 0;
    }

    /**
     * 出租、出售房源取消委托(无经纪人认领)
     */
    public function delEntrust(){
        $type = Input::get('type');
        $hId = Input::get('hId');
        if (!is_numeric($hId) || !in_array($type, ['sale', 'rent'])) {
            return 0;
        }
        $table = self::getTableNameByType($type);
        $data['entrustState'] = 0;
        $flag = $this->myEntrust->updateEntrustClaim($hId, $table['table2'], $data);
        if($flag){
            return 1;
        }
        return 0;
    }

    /**
     * 根据分类获得表名
     * @param $type
     * @return array
     */
    private function getTableNameByType($type)
    {
        switch ($type) {
            case 'Qz':
                $table1 = 'houserentwanted_delegate';
                $table2 = 'houserentwanted';
                break;
            case 'Qs':
                $table1 = 'housesalewanted_delegate';
                $table2 = 'housesalewanted';
                break;
            case 'rent':
                $table1 = 'houserent_delegate';
                $table2 = 'houserententrust';
                break;
            case 'sale':
                $table1 = 'housesale_delegate';
                $table2 = 'housesaleentrust';
                break;
        }
        return [
            'table1' => $table1,
            'table2' => $table2,
        ];
    }

}