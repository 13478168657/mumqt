<?php
namespace App\Dao\Agent;
use DB;
use Illuminate\Support\Facades\Cache;
/**
 * description of HouseDao
 * @since 1.0
 * @author xcy
 */
class HouseDao{
    //根据域名前缀获取城市的相关信息
    public function getCityByPy($py){
        if(!Cache::has('xgetCityByPy'.$py)){
            $cityInfo =  DB::connection('mysql_house')->table('city')->where('py',$py)->select('id','name','py','longitude','latitude')->first();
            Cache::put('xgetCityByPy'.$py,$cityInfo,60*24*30);
        }else{
            $cityInfo =  Cache::get('xgetCityByPy'.$py);
        }
        return $cityInfo;
    }
    /** 前台用到的数据操作start **/
    //根据条件获取房源标签 $where (type:新盘\二手盘,propertyType:房屋类型)
    public function getHouseTag($where){
        if(!Cache::has('getHouseTag_All')){
            //$tagids =  DB::connection('mysql_house')->table('tag2info')->where($where)->groupBy('tagId')->lists('tagId');
            $house =  DB::connection('mysql_house')->table('tag')->get(['id','name']);
            $info = array();
            if(!empty($house)){
                foreach($house as $v){
                    $info[$v->id] = $v->name;
                }
            }
            Cache::put('getHouseTag_All',$info,60*24*30);
        }else{
            $info =  Cache::get('getHouseTag_All');
        }
        return $info;
    }
    //
    public function getAllHouseTag(){
        if(!Cache::has('housetagall')){
            $result =  DB::connection('mysql_house')->table('tag')->get(['id','name']);
            $houseTag = array();
            if(!empty($result)){
                foreach($result as $v){
                    $houseTag[$v->id] = $v->name;
                }
            }
            Cache::put('housetagall', $houseTag, 60*24*7);
        }else{
            $houseTag =  Cache::get('housetagall');
        }
        return $houseTag;
    }
    //用户登录后,获取该用户所关注的房源
    public function getInterestByUid($where){
        return DB::connection('mysql_user')->table('userinterest')->where($where)->lists('interestId');
    }
    //根据二手房源id获取图片
    public function getHouseImageById($table,$houseId){
        if(!Cache::has('oldHouseImage_'.$table.'_'.$houseId)){
            $info = DB::connection('mysql_oldhouse')->table($table)->select('fileName','note','type')->where('houseId',$houseId)->limit(100)->get();
            $xcom = array();//1：户型图；2：客厅；3：卧室；4：厨房；5：卫生间；6：阳台；7：其它；8：外景；9：标题；10：室内；11：交通；12：周边配套；',
            foreach($info as $com){
                if(!empty($com->fileName)){
                    $xcom[] = $com->fileName;
                }
            }
            Cache::put('oldHouseImage_'.$table.'_'.$houseId,$xcom,60*24*30);
        }else{
            $xcom =  Cache::get('oldHouseImage_'.$table.'_'.$houseId);
        }
        return $xcom;
    }
    //根据过期二手房源id获取房源信息
    public function getOldHouseById($table,$id){
        return DB::connection('mysql_oldhouse')->table($table)->find($id);
    }
    //获取经纪人信息
    public function getBrokerByuid($uid,$select){
        return DB::connection('mysql_user')->table('brokers')->select($select)->find($uid);
    }
    //获取业主信息
    public function getCustomersByuid($uid,$select){
        return DB::connection('mysql_user')->table('customers')->select($select)->find($uid);
    }
    //根据二手楼盘id获取楼盘信息
    public function getOldCommunityById($cid,$select){
        return DB::connection('mysql_oldhouse')->table('community')->select($select)->find($cid);
    }
    //更具经纪人分销商公司id获取分销商公司名称
//    public function getEnterpriseShopById($id){
//        return DB::connection('mysql_user')->table('enterpriseshop')->where('id',$id)->pluck('companyName');
//    }
	//获取更城市\区域的统计值
    public function getStatistics($table,$where){
        $where['cType2'] = !empty($where['cType2'])?$where['cType2']:$where['cType1'];
        if(!empty($where['communityId'])){
            $cacheStatistics = 'communityStatistics_'.$table.'-'.$where['communityId'].'-'.$where['type'].'-'.$where['cType1'].'-'.$where['cType2'];
        }elseif(!empty($where['businessareaId'])){
            $cacheStatistics = 'businessareaStatistics_'.$table.'-'.$where['businessareaId'].'-'.$where['type'].'-'.$where['cType1'].'-'.$where['cType2'];
        }elseif(!empty($where['cityareaId'])){
            $cacheStatistics = 'cityareaStatistics_'.$table.'-'.$where['cityareaId'].'-'.$where['type'].'-'.$where['cType1'].'-'.$where['cType2'];
        }else{
            $cacheStatistics = 'cityStatistics_'.$table.'-'.$where['cityId'].'-'.$where['type'].'-'.$where['cType1'].'-'.$where['cType2'];
        }
        if(!Cache::has($cacheStatistics)){
            $info = DB::connection('mysql_statistics')->table($table)->where($where)->orderBy('changeTime','desc')->first();
            Cache::put($cacheStatistics,$info,60*24);
        }else{
            $info =  Cache::get($cacheStatistics);
        }
        return $info;
    }
    //城市环线范围表
    public function getLoopline($cityId){
        if(!Cache::has('looplineByCityId_'.$cityId)){
            $info =  DB::connection('mysql_house')->table('loopline')->select('id','name')->where('cityId',$cityId)->get();
            $loopline = array();
            foreach($info as $v){
                $loopline[$v->id] = $v->name;
            }
            Cache::put('looplineByCityId_'.$cityId,$loopline,60*24*30);
        }else{
            $loopline =  Cache::get('looplineByCityId_'.$cityId);
        }
        return $loopline;
    }
    //根据id获取自定义标签
//    static public function getDiyTagById($id){
//        if(!Cache::has('xgetDiyTagById'.$id)){
//            $info = DB::connection('mysql_house')->table('tagdiy')->where('id',$id)->pluck('name');
//            Cache::put('xgetDiyTagById'.$id,$info,60*24*30);
//        }else{
//            $info =  Cache::get('xgetDiyTagById'.$id);
//        }
//        return $info;
//    }
    //根据id获取相对应的数据
    public  function getDiyTagByIds($ids){
        return DB::connection('mysql_house')->table('tagdiy')->whereIn('id',$ids)->select('id','name')->get();
    }
    //根据搜索添加获取学区列表
    public function getSchoolByWhere($where,$offset,$limit){
        foreach($where as $k=>$v){
            if($k == 'isSchoolHouse'){
                $selsql = $k.'='.$v;
            }else{
                if($k != 'characteristic'){
                    $selsql .= ' and '.$k.'='.$v;
                }else{
                    $selsql .= ' and characteristic REGEXP \'[[:<:]]'.$v.'[[:>:]]\'';
                }
            }
        }
        $sum = DB::connection('mysql_oldhouse')->select('select * from school_copy where '.$selsql);
        $info = DB::connection('mysql_oldhouse')->select('select * from school_copy where '.$selsql.' limit '.$offset.','.$limit);
        return ['sum'=>count($sum),'school'=>$info];
    }
    //根据id获取学区数据
    public function getSchoolById($id){
        //return  DB::select('select * from sofang_new.school where id=1 ');
        return DB::connection('mysql_oldhouse')->table('school_copy')->find($id);
    }
    //根据id获取学区简介
    public function getSchoolIntroById($id){
        return DB::connection('mysql_oldhouse')->table('schoolintro')->where('sid',$id)->first();
    }
    //根据学区id获取楼盘id
    public function getCommunityIdBySid($id,$fields){
        $communityInfo = DB::connection('mysql_oldhouse')->table('schoolcommunityrelation_copy')->where('schoolId',$id)->get($fields);
        return json_decode(json_encode($communityInfo),true);
    }

    //根据学区id获取楼盘id
    public function inserterrorCorrection($data){
        return DB::connection('mysql_statistics')->table('correct_oldcommunity')->insert($data);
    }
    /** 前台用到的数据操作end **/


//
//
//
////    //根据楼盘名称获取楼盘列表信息
////    public function getBuild($name){
////        //$where['name'] = array('like',$name.'%');
////        $builds = DB::connection('mysql_house')->table('community')->select('id','cityId','cityareaId','businessAreaId','name')->where('name','like',$name.'%')->limit(10)->get();
////        return $builds;
////    }
//
//    //根据楼盘id获取相关楼栋列表信息
//    public function communityBuilding($id){
//        $builds = DB::connection('mysql_oldhouse')->table('communitybuilding')->select('id','num')->where('communityId',$id)->get();
//        return $builds;
//    }
//    //根据楼盘id获取相关户型列表信息
//    public function communityRoom($id){
//        $rooms = DB::connection('mysql_house')->table('communityroom')->select('id','name','room','hall','toilet','kitchen','balcony')->where('communityId',$id)->get();
//        return $rooms;
//    }
//
//    //根据楼盘id获取相关户型列表信息
//    public function getcommunityunit($id){
//        $units = DB::connection('mysql_oldhouse')->table('communityunit')->select('id','num')->where('bId',$id)->get();
//        return $units;
//    }
//    //插入新房出售房源数据表
//    public function insertHouseSale($data){
//        $houseid = DB::connection('mysql_house')->table('housesale')->insertGetId($data);
//        return $houseid;
//    }
//    //插入新房出售房源图片表
//    public function insertHouseImg($data){
//        $houseimg = DB::connection('mysql_house')->table('housesaleimage')->insert($data);
//        return $houseimg;
//    }
//    //获取房源图片表数据
//    public function getHouseImg($uid,$houseId){
//        $con['uid'] = $uid;
//        $con['houseId'] = $houseId;
//        $houseimg = DB::connection('mysql_house')->table('housesaleimage')->where($con)->get();
//        return $houseimg;
//    }
//    /**
//     * 获取房源图片路径
//     * @param int $imgId 图片id
//     */
//    public function getHouseSaleImgPath( $imgId ){
//        return DB::connection('mysql_house')->table('housesaleimage')->whereIn('id', $imgId)->get(['fileName']);
//    }
//    /**
//     * 修改房源图片信息
//     * @param int $id  图片id
//     * @param array $info 图片信息
//     */
//    public function editHouseSaleImg( $id, $info){
//        return DB::connection('mysql_house')->table('housesaleimage')->where('id', $id)->update($info);
//    }
//    /**
//     * 删除房源图片
//     * @param int $imgId  图片id
//     */
//    public function deleteHouseSaleImg( $imgId ){
//        return DB::connection('mysql_house')->table('housesaleimage')->whereIn('id', $imgId)->delete();
//    }
//    /**
//     * 删除房源出售模板
//     * @param int $modelId  房源模板id
//     */
//    public function delHouseSaleModel( $modelId ){
//        return DB::connection('mysql_house')->table('housesalemodel')->where('id', $modelId)->delete();
//    }
//    //插入房源模板表
//    public function insertUpdateModel($communityid,$data){
//        $res = DB::connection('mysql_house')->table('housesalemodel')->where('communityId',$communityid)->get();
//        if(!empty($res)){
//            $models = DB::connection('mysql_house')->table('housesalemodel')->where('communityId',$communityid)->update($data);
//        }else{
//            $models = DB::connection('mysql_house')->table('housesalemodel')->insert($data);
//        }
//        return $models;
//    }
//    //更新房源数据表
//    public function updateHouseSale($id,$data){
//        $rooms = DB::connection('mysql_house')->table('housesale')->where('id',$id)->update($data);
//        return $rooms;
//    }
//    //更新房源模板表
//    public function updateHouseModel($id,$data){
//        $models = DB::connection('mysql_house')->table('housesalemodel')->where('id',$id)->update($data);
//        return $models;
//    }
//    //根据房源id获取数据(新房源表)
//    public function getHouseModel($where){
//        $models = DB::connection('mysql_house')->table('housesalemodel')->select('id','name')->where($where)->get();
//        return $models;
//    }
//    //根据房源id获取数据(新房源表)
//    public function getHouseById($uid,$id){
//        $houses = DB::connection('mysql_house')->table('housesale')->where('uid',$uid)->find($id);
//        return $houses;
//    }
//    //根据房源模板id获取数据(新房源模板表)
//    public function getHouseModelById($uid,$id){
//        $houses = DB::connection('mysql_house')->table('housesalemodel')->where('uid',$uid)->find($id);
//        return $houses;
//    }
//    //根据楼盘户型id获取数据(楼盘户型表)
//    public function getRoomModelById($id){
//        $room = DB::connection('mysql_house')->table('communityroom')->select('name')->find($id);
//        return $room;
//    }
//    //管理新房房源表
//    public function houseManage($where,$t,$offset,$page){
//        $houses['count'] = DB::connection('mysql_house')->table('housesale as h')->leftJoin('community as c', DB::raw('h.communityId'), '=', DB::raw('c.id'))->select(DB::raw('h.id,h.thumbPic,h.title,h.houseType1,h.cityId,h.cityareaId,h.businessAreaId,c.address,h.roomStr,h.faceTo,h.area,h.totalPrice,h.oldTotalPrice,h.timeCreate'))->where($where)->whereBetween($t[0],$t[1])->count();
//        $houses['house'] = DB::connection('mysql_house')->table('housesale as h')->leftJoin('community as c', DB::raw('h.communityId'), '=', DB::raw('c.id'))->select(DB::raw('h.id,h.thumbPic,h.title,h.houseType1,h.cityId,h.cityareaId,h.businessAreaId,c.address,h.roomStr,h.faceTo,h.area,h.totalPrice,h.oldTotalPrice,h.timeCreate'))->where($where)->whereBetween($t[0],$t[1])->skip($offset*($page-1))->take($offset)->get();
//        return $houses;
//    }
//    //更改房源数据的状态(发布/未发布)
//    public function editHouseState($id){
//        return DB::connection('mysql_house')->table('housesale')->where('id',$id)->update(['state' => 1]);
//    }
//
//    /**
//     * 以下是二手房出售所用到的数据操作
//     *
//     */
//
//    //根据楼盘名称获取楼盘列表信息
//    public function getBuild($name){
//        //$where['name'] = array('like',$name.'%');
//        $builds = DB::connection('mysql_oldhouse')->table('community')->select('id','cityId','cityareaId','businessAreaId','name','address','type1')->where('name','like',$name.'%')->limit(10)->get();
//        return $builds;
//    }
//    //插入二手出售房源数据表
//    public function insertOldHouseSale($table,$data){
//        $houseid = DB::connection('mysql_oldhouse')->table($table)->insertGetId($data);
//        return $houseid;
//    }
//    //更新二手出售房源缩略图
//    public function updateOldSaleThumbPic($houseid,$thumbPic){
//        $houseimg = DB::connection('mysql_oldhouse')->table('housesale')->where('id',$houseid)->update($thumbPic);
//        return $houseimg;
//    }
//    //插入二手出售房源图片表
//    public function insertOldSaleImg($table,$data){
//        $houseimg = DB::connection('mysql_oldhouse')->table($table)->insert($data);
//        return $houseimg;
//    }
//    //获取二手出售房源图片表数据
//    public function getOldSaleImg($table,$uid,$houseId){
//        $con['uid'] = $uid;
//        $con['houseId'] = $houseId;
//        $houseimg = DB::connection('mysql_oldhouse')->table($table)->where($con)->get();
//        return $houseimg;
//    }
//    //根据房源id获取数据(二手出售房源)
//    public function getOldSaleById($table,$uid,$id){
//        $where['uid'] = $uid;
//        $where['h.id'] = $id;
//        if($table == 'housesale'){
//            $fields = DB::raw('h.id,h.title,h.houseType1,h.houseType2,h.cityId,h.internalNum,h.ownership,h.housingInspectionNum,h.cityareaId,h.communityId,h.businessAreaId,h.practicalArea,h.buildYear,h.fitment,h.equipment,h.building,h.buildingId,h.unit,h.unitId,h.houseNum,c.name,c.address,h.roomId,h.roomStr,h.houseRoom,h.faceTo,h.area,h.address as haddress,h.building,h.tagId,h.unit,h.houseNum,h.currentFloor,h.totalFloor,h.isDivisibility,h.buildingType,h.buildingStructure,h.price1,h.price2,h.trade,h.describe,h.officeLevel,h.propertyFee,h.timeCreate,h.timeUpdate');
//        }else{
//            $fields = DB::raw('h.id,h.title,h.houseType1,h.houseType2,h.cityId,h.internalNum,h.ownership,h.housingInspectionNum,h.cityareaId,h.communityId,h.businessAreaId,h.practicalArea,h.buildYear,h.fitment,h.equipment,h.building,h.buildingId,h.unit,h.unitId,h.houseNum,c.name,c.address,h.roomId,h.roomStr,h.houseRoom,h.faceTo,h.area,h.address as haddress,h.building,h.tagId,h.unit,h.houseNum,h.buildingType,h.totalFloor,h.isDivisibility,h.isTransfer,h.buildingStructure,h.price1,h.price2,h.price3,h.price4,h.price5,h.priceUnit,h.paymentType,h.rentType,h.trade,h.describe,h.officeLevel,h.propertyFee,h.timeCreate,h.timeUpdate');
//        }
//        //$houses = DB::connection('mysql_house')->table('housesale2_bak')->where('uid',$uid)->find($id);
//        $houses = DB::connection('mysql_oldhouse')->table($table.' as h')->leftJoin('community as c', DB::raw('h.communityId'), '=', DB::raw('c.id'))->select($fields)->where($where)->first();
//
//        return $houses;
//    }
//    //编辑二手房出售图片信息
//    public function editOldSaleImg( $table,$id, $info){
//        return DB::connection('mysql_oldhouse')->table($table)->where('id', $id)->update($info);
//    }
//    public function getOldSaleImgPath($table,$imgId ){
//        return DB::connection('mysql_oldhouse')->table($table)->whereIn('id', $imgId)->get(['fileName']);
//    }
//    //删除二手房出售指定图片id
//    public function deleteOldSaleImg($table,$imgId ){
//        return DB::connection('mysql_oldhouse')->table($table)->whereIn('id', $imgId)->delete();
//    }
//    //更新二手房源出售房源数据表
//    public function updateOldSale($table,$id,$data){
//        $rooms = DB::connection('mysql_oldhouse')->table($table)->where('id',$id)->update($data);
//        return $rooms;
//    }
//    //管理二手房源出售房源表
//    public function houseSaleManage($table,$where,$offset,$page,$order){
//        if($table == 'housesale'){
//            $fields = DB::raw('h.id,h.internalNum,h.thumbPic,h.title,h.houseType1,h.cityId,h.cityareaId,h.businessAreaId,h.communityId,c.name,h.roomStr,h.faceTo,h.area,h.price1,h.price2,h.isRealHouse,h.isSoloAgent,h.timeCreate,h.timeUpdate');
//        }else{
//            $fields = DB::raw('h.id,h.internalNum,h.thumbPic,h.title,h.houseType1,h.cityId,h.cityareaId,h.businessAreaId,h.communityId,c.name,h.roomStr,h.faceTo,h.area,h.price1,h.priceUnit,h.isRealHouse,h.isSoloAgent,h.timeCreate,h.timeUpdate');
//        }
//        $houses = DB::connection('mysql_oldhouse')->table($table.' as h')->leftJoin('community as c', DB::raw('h.communityId'), '=', DB::raw('c.id'))->select($fields);
//        //->where($where)->get()
//        foreach ($where as $key => $value){
//            if(!is_array($value)){
//                $houses->where($key,$value);
//            }else{
//                $houses->whereBetween($key,$value);
//            }
//        }
//        $count = $houses->count();
//        $houses = $houses->skip($offset*($page-1))->take($offset)->orderBy($order[0], $order[1])->get();
//        return ['count'=>$count,'houses'=>$houses];
//    }
//    //更改二手出售房源数据的状态(发布<->未发布)
//    public function editOldSaleState($id,$state){
//        return DB::connection('mysql_house')->table('housesale2_bak')->where('id',$id)->update(['state' => $state]);
//    }
//    //更改二手出售房源数据的状态(发布<->下架)(批量)
//    public function updateStatus($table,$id,$state){
//        return DB::connection('mysql_oldhouse')->table($table)->whereIn('id',$id)->update($state);
//    }
//    //更改二手出售房源数据的状态(发布<->下架)(批量)
//    public function updateAttribute($table,$id,$attr){
//        return DB::connection('mysql_oldhouse')->table($table)->whereIn('id',$id)->update($attr);
//    }
//    //删除二手出售房源
//    public function deleteOldSaleHouse($table,$id){
//        return DB::connection('mysql_oldhouse')->table($table)->whereIn('id',$id)->delete();
//    }
//
//    //获取楼盘户型图片
//    public function getCommunityRoomImg($table,$id){
//
//        $houses = DB::connection('mysql_oldhouse')->table($table.' as h')->leftJoin('communityroom as c', DB::raw('h.communityId'), '=', DB::raw('c.communityId'))->leftJoin('communityroomimage as r', DB::raw('c.id'), '=', DB::raw('r.communityRoomId'))->select(DB::raw('c.name,r.fileName'))->where('h.id',$id)->get();
//        return $houses;
//    }
//    //获取楼盘图片
//    public function getCommunityImg($table,$ctype,$uid){
//        return DB::connection('mysql_oldhouse')->table($table)->whereIn('type',$ctype)->where('communityId',$uid)->get();
//    }

    /* 获取房源置顶信息(楼盘) by ykk   */

    public function getHouseStickByCom($communityId,$housetp,$houseType1){
        $time = date('Ymd');
        $result = DB::connection('mysql_marketing')
                ->table('log_housestick')
                ->where('communityId',$communityId)
                ->where('saleRentType',$housetp)
                ->where('type1',$houseType1)
                ->where('lastTime','>=',$time)
                ->where('startTime','<=',$time)
                ->select('hId','saleRentType','uId','communityId')
                ->first();
        return $result;
    }
    /* 查询房源信息，如果es索引中没有数据 从数据库中查数据 */
    public function getHouseByDatabase($housetp,$hid,$uId,$communityId){
        $brokerInfo = DB::table('brokers')->where('id',$uId)->select('id','realName')->first();
        if($housetp == 'rent'){
             $result = DB::connection('mysql_oldhouse')->table('houserent')->where('id',$hid)->first();
             $brokers= array();
             $brokers[] = $brokerInfo;
             $res = new \stdClass();
             if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
             }else{
                $res->found = false;
                $res->_source = $result;
            }
        }else{
            $res = new \stdClass();
            $result = DB::connection('mysql_oldhouse')->table('housesale')->where('id',$hid)->first();
            if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
            }else{
                $res->found = false;
                $res->_source = array();
            }
        }
        return $res;
    }
    /* 获取房源置顶信息（地铁站） by ykk */

    public function getHouseStickByStation($subwayStationId,$housetp,$houseType1){
        $time = date('Ymd');
        $result = DB::connection('mysql_marketing')
                ->table('log_housestick')
                ->where('subwaystationId',$subwayStationId)
                ->where('saleRentType',$housetp)
                ->where('type1',$houseType1)
                ->where('lastTime','>=',$time)
                ->where('startTime','<=',$time)
                ->select('hId','saleRentType','uId','subwaystationId')
                ->first();
        return $result;
    }
    
    /* 获取地铁站定投从数据库中查找 */
    public function getHouseByStationDatabase($housetp,$hid,$uId,$subwaystationId){
        $brokerInfo = DB::table('brokers')->where('id',$uId)->select('id','realName')->first();
        if($housetp == 'rent'){
             $result = DB::connection('mysql_oldhouse')->table('houserent')->where('id',$hid)->first();
             $brokers= array();
             $brokers[] = $brokerInfo;
             $res = new \stdClass();
             if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$result->communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
             }else{
                $res->found = false;
                $res->_source = $result;
            }
        }else{
            $res = new \stdClass();
            $result = DB::connection('mysql_oldhouse')->table('housesale')->where('id',$hid)->first();
            if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$result->communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
            }else{
                $res->found = false;
                $res->_source = array();
            }
        }
        return $res;
    }
    /* 获取房源定投信息(楼盘) by ykk */

    public function getHousePutByCom($communityId,$housetp,$houseType1){
        $time = date('Ymd');
        $result = DB::connection('mysql_marketing')
                ->table('log_houseput')
                ->where('communityId',$communityId)
                ->where('saleRentType',$housetp)
                ->where('type1',$houseType1)
                ->where('state',1)
                ->where('lastTime','>=',$time)
                ->where('startTime','<=',$time)
                ->orderBy('position')
                ->select('hId','saleRentType','uId')
                ->get();
        return $result;
    }
    /* 获取房源定投信息(地铁站) by ykk */

    public function getHousePutBySubway($subwayStationId,$housetp,$houseType1){
        $time = date('Ymd');
        $result = DB::connection('mysql_marketing')
                ->table('log_houseput')
                ->where('subwaystationId',$subwayStationId)
                ->where('saleRentType',$housetp)
                ->where('type1',$houseType1)
                ->where('state',1)
                ->where('lastTime','>=',$time)
                ->where('startTime','<=',$time)
                ->orderBy('position')
                ->select('hId','saleRentType','uId')
                ->get();
        return $result;
    }
    /*  获取房源定投信息通过数据库（用于楼盘的） */
    public function getHousePutbyCommDB($housetp,$hid,$uId){
        $brokerInfo = DB::table('brokers')->where('id',$uId)->select('id','realName')->first();
        if($housetp == 'rent'){
             $result = DB::connection('mysql_oldhouse')->table('houserent')->where('id',$hid)->first();
             $brokers= array();
             $brokers[] = $brokerInfo;
             $res = new \stdClass();
             if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$result->communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
             }else{
                $res->found = false;
                $res->_source = $result;
            }
        }else{
            $res = new \stdClass();
            $result = DB::connection('mysql_oldhouse')->table('housesale')->where('id',$hid)->first();
            if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$result->communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
            }else{
                $res->found = false;
                $res->_source = array();
            }
        }
        return $res;
    }
    /* 获取房源定投信息通过数据库（用于地铁站的 */
    public function getHousePutbyStationDB($housetp,$hid,$uId){
        $brokerInfo = DB::table('brokers')->where('id',$uId)->select('id','realName')->first();
        if($housetp == 'rent'){
             $result = DB::connection('mysql_oldhouse')->table('houserent')->where('id',$hid)->first();
             $brokers= array();
             $brokers[] = $brokerInfo;
             $res = new \stdClass();
             if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$result->communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
             }else{
                $res->found = false;
                $res->_source = $result;
            }
        }else{
            $res = new \stdClass();
            $result = DB::connection('mysql_oldhouse')->table('housesale')->where('id',$hid)->first();
            if($result){
                $resComm = DB::connection('mysql_oldhouse')->table('community')->where('id',$result->communityId)->select('name')->first();
                  if ($result->houseType1 == 1) {
                      $housetypes = \Config::get('conditionConfig.housetype1.text');
                  } elseif ($result->houseType1 == 2) {
                      $housetypes = \Config::get('conditionConfig.housetype2.text');
                  }else{
                      $housetypes = \Config::get('conditionConfig.housetype.text');
                  }
                 $result->housetypes = $housetypes;
                 $result->name = $resComm->name;
//                 $result->communityId = $communityId;
                 $result->brokers = $brokers;
                 $res->found = true;
                 $res->_source = $result;
            }else{
                $res->found = false;
                $res->_source = array();
            }
        }
        return $res;
    }
    /*判断当前城市说用模板 */
    public function getCityModel($cityId){
        $res = DB::connection('mysql_house')
                ->table('city2model')
                ->where('cityId',$cityId)
                ->first();
        return $res;
    }
}