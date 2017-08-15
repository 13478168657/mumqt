<?php

/**
 * Controller样本代码
 * 规范要点：
 * 1.Class顶部必须包括类说明、作者、创建时间（至少精确到分钟）
 * 2.原则上所有纵向分隔只用一行空行即可，不允许两行以上的空行存在
 * 3.全局变量和方法尽量声明为private，只在必要情况下使用public，除非是明确的需要被继承，否则不使用protected声明
 * 4.public方法必须对每个参数和返回值添加注释，参数名和返回值必须有明确的含义说明（return view(...)不用额外说明）
 * 5.如果方法的作者与Controller作者不一致，需要单独说明，并标注时间
 * 6.引用其他类的方法，除非特殊情况，否则都在顶部使用use标签引入
 * 7.功能提交时，代码中不必要的方法或注释应该删除，因特殊情况不能删除的需要加以补充说明
 * 8.删除所有未使用过的引用和变量
 * 9.所有对数据库的操作封装在DAO层
 * 10.所有缓存从RedisCacheUtil静态类中获取
 * 11.能用一行解决的问题不要分多行，代码行数越少越好
 */

namespace App\Http\Controllers\Map;

use App\City;
use App\Dao\Agent\HouseDao;
use App\Dao\City\CityDao;
use App\Dao\Map\MapDao;
use App\Dao\Statistics\StatisticsDao;
use App\ListInputView;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\SearchController;
use App\Services\Search;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cookie;
use Cache;
use Auth;
use App\Http\Controllers\Lists\PublicController;
/**
 * 地图显示控制器
 * @author yuanl
 * @date 2016年1月20日 上午10:19:40
 */
class MapSearchController extends Controller
{
    private static $cityareaMaxLevel = 13;
    private static $businessareaMaxLevel = 15;
    private $city;
    private $showlevel;
    private $zoom;
    private $housetype1;
    private $housetype2;
    private $condition;
    private $sort;
    private $opentime;

    public function __construct()
    {
        $this->zoom = Input::get("zm");
        $this->housetype1 = Input::get("housetype1", '');
        $this->housetype2 = Input::get("housetype2", '');
        $this->sort = Input::get("sort", 'desc');
        if ($this->zoom < self::$cityareaMaxLevel) {
            $this->showlevel = 1;
        } else if ($this->zoom >= self::$cityareaMaxLevel && $this->zoom < self::$businessareaMaxLevel) {
            $this->showlevel = 2;
        } else {
            $this->showlevel = 3;
        }
        $type = Input::get("type");
        $cookie_city = Cookie::get('city');
        $this->city = new City($cookie_city->id, $cookie_city->name, $cookie_city->py, $cookie_city->pinyin, $cookie_city->longitude, $cookie_city->latitude);
        $this->condition = new ListInputView();
        $this->condition->cityId = $this->city->id;
        $this->condition->type1 = $this->housetype1;
        $this->condition->type2 = $this->housetype2;
        $this->condition->keyword = Input::get("keyword", '');
        if ($type == 'sale'){
            if($this->housetype1 == 1){
                $this->condition->price2 = Config::get('conditionConfig.totalprice1.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas1.number')[Input::get("areas", 0) + 0];
            } else if($this->housetype1 == 2){
                $this->condition->price2 = Config::get('conditionConfig.totalprice1.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas2.number')[Input::get("areas", 0) + 0];
            } else {
                //$this->condition->price2 = Config::get('conditionConfig.totalprice.number')[Input::get("totalprice", 0) + 0];
                //$this->condition->priceSaleAvg3 = Config::get('conditionConfig.averageprice.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas.number')[Input::get("areas", 0) + 0];
            }
        }elseif($type == 'new'){
             if($this->housetype1 == 1){
                $this->condition->price2 = Config::get('conditionConfig.totalprice1.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas1.number')[Input::get("areas", 0) + 0];
            } else if($this->housetype1 == 2){
                $this->condition->price2 = Config::get('conditionConfig.totalprice1.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas2.number')[Input::get("areas", 0) + 0];
            } else {
                //$this->condition->price2 = Config::get('conditionConfig.totalprice.number')[Input::get("totalprice", 0) + 0];
                $this->condition->priceSaleAvg3 = Config::get('conditionConfig.averageprice.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas.number')[Input::get("areas", 0) + 0];
            }
        } else {
            if($this->housetype1 == 1){
                $this->condition->price1 = Config::get('conditionConfig.averageprice3.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas1.number')[Input::get("areas", 0) + 0];
            } else if ($this->housetype1 == 2){
                $this->condition->price2 = Config::get('conditionConfig.averageprice4.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas2.number')[Input::get("areas", 0) + 0];
            } else {
                $this->condition->price1 = Config::get('conditionConfig.averageprice2.number')[Input::get("totalprice", 0) + 0];
                $this->condition->singlearea = Config::get('conditionConfig.areas.number')[Input::get("areas", 0) + 0];
            }
        }
        $this->condition->houseRoom = Config::get('conditionConfig.models.number')[Input::get("houseRoom", 0) + 0];
        $this->condition->toward = Config::get('conditionConfig.toward.number')[Input::get("faceTo", 0) + 0];
    }

    public function MapLoad($type, $type2 = "")
    {
        $totalprice = [];
        $avgprice = [];
        $areas = [];
        $houseRoom = [];
        $faceTo = [];
        $year = [];
        $floor = [];
        $decorate = [];
        $houseType2Arr = [];
        $buildtype = [];
        $structure = [];
        if ($type == 'rent') {
            $peitao = $value = Config::get('conditionConfig.pei1');
            if ($type2 == 'shops') {
                $this->housetype1 = 1;
                $avgprice = Config::get('conditionConfig.averageprice3');
                $areas = Config::get('conditionConfig.areas1');
            } else if ($type2 == 'office') {
                $this->housetype1 = 2;
                $avgprice = Config::get('conditionConfig.averageprice4');
                $areas = Config::get('conditionConfig.areas2');
            } else {
                $this->housetype1 = 3;
                $avgprice = Config::get('conditionConfig.averageprice2');
                $areas = Config::get('conditionConfig.areas');
                $houseRoom = Config::get('conditionConfig.models');
                $faceTo = Config::get('conditionConfig.toward');
                $year = Config::get('conditionConfig.that');
                $floor = Config::get('conditionConfig.floor');
                $decorate = Config::get('conditionConfig.decorate');
                $houseType2Arr = Config::get('conditionConfig.housetype');
                $buildtype = Config::get('conditionConfig.buildtype');
                $structure = Config::get('conditionConfig.structure');
            }
        } else {
            if ($type2 == 'shops') {
                $this->housetype1 = 1;
                $totalprice = Config::get('conditionConfig.totalprice1');
                $areas = Config::get('conditionConfig.areas1');
            } else if ($type2 == 'office') {
                $this->housetype1 = 2;
                $totalprice = Config::get('conditionConfig.totalprice1');
                $areas = Config::get('conditionConfig.areas2');
            } else {
                $this->housetype1 = 3;
                $totalprice = Config::get('conditionConfig.averageprice');
                $areas = Config::get('conditionConfig.areas');
                $houseRoom = Config::get('conditionConfig.models');
                $faceTo = Config::get('conditionConfig.toward');
                $year = Config::get('conditionConfig.that');
                $floor = Config::get('conditionConfig.floor');
                $decorate = Config::get('conditionConfig.decorate');
                $houseType2Arr = Config::get('conditionConfig.housetype');
                $buildtype = Config::get('conditionConfig.buildtype');
                $structure = Config::get('conditionConfig.structure');
            }
            $peitao = $value = Config::get('conditionConfig.pei');
        }
        $houseDao = new HouseDao();
        $tags = $houseDao->getHouseTag($wheretag = array('type' => 4, 'propertyType1' => $this->housetype1));
        $this->condition->type1 = $this->housetype1;
        $this->condition->type2 = $this->housetype2;
        //$subways = MapDao::GetSubwayLines($this->city->id);
        $stations = MapDao::GetStations($this->city->id);


        $es_Search = new \App\Services\Search();
        $lisAttr = new \App\ListInputView();
        $lisAttr->cityId = $this->city->id;;//城市id
//        $lisAttr->subwayLineId = 10;//地铁线路id
//		$lisAttr->subwayStationId = 226;
        $lisAttr->order = 'timeCreate';
        $lisAttr->asc = 0;
        $lisAttr->page = 1;
        $lisAttr->pageset = 1000;
        $data = $es_Search->searchHouse4Group($lisAttr, 'subwayLineId', true);
        $stationData = $es_Search->searchHouse4Group($lisAttr, 'subwayStationId', true);
        $stationObj = $stationData->aggregations->group->buckets;
        $stationArr1 = [];
        foreach($stationObj as $val){
            $stationArr1[$val->key] = $val->doc_count;
        }
        $InfoArr = $data->aggregations->group->buckets;
        $dataArr = [];
        foreach($InfoArr as $val){
          $dataArr[$val->key] = $val->doc_count;
        }
        $stationArr = [];
        foreach($stations as $station){
            if(isset($stationArr1[$station->id])){
                $station->count = $stationArr1[$station->id];
            }else{
                $station->count= 0;
            }
            $stationArr[$station->linename."-".$station->lineId][] = $station;
        }


        $subways = [];
        foreach($stationArr as $key=>$station){
            $lineId = explode("-",$key)[1];
            if(isset($dataArr[$lineId])){
                $subways[$key."-".$dataArr[$lineId]] = $station;
            }else{
                $subways[$key."-0"] = $station;
            }
        }


        if(USER_AGENT_MOBILE){
            $view ="h5.map.newmap";
        }else{
            $view = "map.newmap";
        }
        //销售状态
        $saleStatus = Config::get('conditionConfig.salestatus');
        $public = new PublicController();
        $cityAreas = $public->getCityArea($this->city->id);
        //开盘时间
        $this->opentime  = Config::get('conditionConfig.opentime');
        //新楼盘id
        $communityId = Input::get('communityId',0);
        $longitude = Input::get('longitude',0);
        $latitude = Input::get('latitude',0);
        return View($view)->with("subways", $subways)
            ->with("city", $this->city)
            ->with("housetype1", $this->housetype1)
            ->with('showlevel', $this->showlevel)
            ->with('type', $type)
            ->with('tags', $tags)
            ->with('peitao', $peitao['text'])
            ->with('totalprice', $totalprice)
            ->with('avgprice', $avgprice)
            ->with('areas', $areas)
            ->with('houseRoom', $houseRoom)
            ->with('faceTo', $faceTo)
            ->with('year', $year)
            ->with('floor', $floor)
            ->with('decorate', $decorate)
            ->with('houseType2Arr', $houseType2Arr)
            ->with('buildtype', $buildtype)
            ->with('structure', $structure)
            ->with('cityAreas',$cityAreas)
            ->with('saleStatus',$saleStatus)
            ->with('openTime',$this->opentime)
            ->with('communityId',$communityId)
            ->with('longitude',$longitude)
            ->with('latitude',$latitude);
    }

    public function MapSearch()
    {
        $type = Input::get("type");
        $this->condition->isNew = true;

        $search = new Search();
        $zoom = Input::get("zm");

        //$this->condition->swlng = Input::get("swlng", 0) -0.25;
        //$this->condition->swlat = Input::get("swlat", 0) -0.1;
        //$this->condition->nelng = Input::get("nelng", 0) +0.25;
        //$this->condition->nelat = Input::get("nelat", 0) +0.1;
        if(Input::get('ca')){
            $this->condition->cityareaId = Input::get('ca');
        }
        $this->condition->swlng = Input::get("swlng", 0);
        $this->condition->swlat = Input::get("swlat", 0);
        $this->condition->nelng = Input::get("nelng", 0);
        $this->condition->nelat = Input::get("nelat", 0);
        //$this->condition->pageset = 6;

        if ($this->sort == 'asc'){
            $this->condition->asc = true;
        } else {
            $this->condition->asc = false;
        }
        //if($zoom>=14){
        //   $zoom =14;
        //}
        //新盘销售状态
        $saleStatus = Input::get("salestatus");

        if($saleStatus !=''){
            $this->condition->salesStatusPeriods = $saleStatus;
        }
        //新盘开盘时间
        $openTime = Input::get("openTime", 0);
        if($openTime >0 ){
            $this->condition-> openTimePeriods = $this->openTimeConversion($openTime);
        }

        $houseDao = new HouseDao();
        $tags = $houseDao->getHouseTag($wheretag = array('type' => 1, 'propertyType1' => 3));
        $result = $search->mapSearch($this->condition, $zoom);
        $this->condition->pageset = 6;
        $this->condition->order = 'timeUpdateLong';
        $this->condition->page = Input::get("page", 1);
        $houseData = $search->searchCommunity($this->condition);
        foreach($houseData->hits->hits as $key=>$list){
            if(property_exists($list->_source,'titleImage')){
                $houseData->hits->hits[$key]->_source->titleImage = get_img_url('commPhoto',$list->_source->titleImage);
            }
        }

        $Statistics = new StatisticsDao();
        $Status = $Statistics->getCityStatusByCityId($this->city->id, $type, $this->housetype1, $this->housetype2);
        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $result['city'] = $this->city;
        $result['lefthead'] = $leftHead;
        if(Input::get("totalprice", 0)>0){
            $avgPriceSta = Input::get("totalprice", 0);
            $avaPriceText = Config::get('conditionConfig.averageprice.text')[$avgPriceSta];
            $result['avaPriceText'] = $avaPriceText;
        }

        //是否关注
        if(!empty(Auth::id())){
            $interest['uid'] = Auth::id();
            if(strpos($type,'esb')){
                $interest['isNew'] = 0;
            }else{
                $interest['isNew'] = 1;
            }
            $interest['tableType'] =  3;
            $interest['type1'] = 3;
            $interest['is_del'] = 0;
            $dataArr = $houseDao->getInterestByUid($interest);
            if(!empty($dataArr)){
                $result['interest'] = $dataArr;
            }
        }
        $result['tags'] = $tags;
        $result['community'] = $houseData;
        return response()->json($result);
    }
    //根据楼盘id获取楼盘信息
    public function getCommunityById(){
        $type = Input::get("type");
        $search = new Search();
        $communityId = Input::get('communityId');
        $result = $search->getCommunityByCid($communityId,true);
        if(property_exists($result->_source,'titleImage')){
            $result->_source->titleImage = get_img_url('commPhoto',$result->_source->titleImage);
        }
        //是否关注
        if(!empty(Auth::id())){
            $interest['uid'] = Auth::id();
            if(strpos($type,'esb')){
                $interest['isNew'] = 0;
            }else{
                $interest['isNew'] = 1;
            }
            $interest['tableType'] =  3;
            $interest['type1'] = 3;
            $interest['is_del'] = 0;
            $houseDao = new HouseDao();
            $dataArr = $houseDao->getInterestByUid($interest);
            if(!empty($dataArr)){
                $result['interest'] = $dataArr;
            }
        }

        $Statistics = new StatisticsDao();
        $Status = $Statistics->getCommunityStatusByCId($communityId, $type, $this->housetype1, $this->housetype2);
        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $houseDao = new HouseDao();
        $tags = $houseDao->getHouseTag($wheretag = array('type' => 1, 'propertyType1' => 3));
        $cookie_city = Cookie::get('city');
        $result->cityName =$cookie_city->name;
        $result->lefthead = $leftHead;
        $result->tags = $tags;
        return response()->json($result);

    }

    public function SubwaySearch()
    {

        $search = new SearchController('c');
        $subwayLine = Input::get("subwayLine");
        $subwayStation = Input::get("subwayStation");
        $ht = 128;
        $zoom = Input::get("zm");
        $result = $search->subwaySearch($ht, $this->city->id, $subwayLine, $subwayStation, null, null, $zoom);
        dd($result);
        $html = json_encode($result);
        return $html;
    }


    public function GetHouseByCid()
    {
        $type = Input::get("type");
        $data = $this->condition;
        if ($type == 'rent') {
            $imageType = 'houseRent';
            $search = new Search('hr');
        } else {
            $imageType = 'houseSale';
            $search = new Search('hs');
        }
        $data->communityId = Input::get("communityid");
        $data->pageset = 6;
        $data->page = Input::get("page", 1);
        $houselist = $search->searchHouse($data);
        $houseDao = new HouseDao();
        $houseTags = $houseDao->getAllHouseTag();
        foreach ($houselist->hits->hits as $key => $value) {
            $houselist->hits->hits[$key]->_source->thumbPic = get_img_url($imageType, $value->_source->thumbPic, 1);
            $tags = [];
            if($houselist->hits->hits[$key]->_source->tagId != ''){
                $tagArr = explode('|', $houselist->hits->hits[$key]->_source->tagId);
                foreach ($tagArr as $value){
                    $tags[] = $houseTags[$value];
                }
            }
            $houselist->hits->hits[$key]->_source->tagId = $tags;
        }
        $Statistics = new StatisticsDao();
        $Status = $Statistics->getCommunityStatusByCId($data->communityId, $type, $this->housetype1, $this->housetype2);
        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $community = $search->getCommunityByCid($data->communityId);
        $result = ["stuts" => 1, "hdate" => $houselist, "cdate" => $community, 'lefthead'=>$leftHead];
        return json_encode($result);
    }

    public function getBusinessareaByCaid()
    {
        $type = Input::get("type");

        /*if ($type == 'rent') {
            $search = new Search('hr');
        } else {
            $search = new Search('hs');
        }*/
        $search = new Search();
        $this->condition->isNew = true;
        $data = $this->condition;
        $data->cityareaId = Input::get("caid");
        if ($this->sort == 'asc'){
            $data->asc = true;
        } else {
            $data->asc = false;
        }

        $cityList = $search->mapSearch($data, 14);

        $cityDao = new CityDao();
        $community = $cityDao->getCityAreaById($data->cityareaId);
        $Statistics = new StatisticsDao();
        $Status = $Statistics->getCityAreasStatusByCityAreaId($data->cityareaId, $type, $this->housetype1, $this->housetype2);
        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $result = ["stuts" => 1, "hdate" => $cityList, "cdate" => $community[0], 'lefthead'=>$leftHead];
        return json_encode($result);
    }

    public function getCommunityByBid()
    {
        $type = Input::get("type");
        $data = $this->condition;
        $data->isNew = true;
        /*if ($type == 'new') {
            $data->isNew = true;
            $search = new Search('hs');
        } else if ($type == 'rent') {
            $search = new Search('hr');
        } else {
            $search = new Search('hs');
        }*/
        $houseDao = new HouseDao();
        $tags = $houseDao->getHouseTag($wheretag = array('type' => 1, 'propertyType1' => 3));

        $search = new Search();
        if ($this->sort == 'asc'){
            $data->asc = true;
        } else {
            $data->asc = false;
        }
        $data->pageset = 6;
        $data->page = Input::get("page", 1);
        $data->businessAreaId = Input::get("bid");
        //$cityList = $search->mapSearch($data, 16);
        $cityList = $search->searchCommunity($data);
        if(count($cityList->hits->hits)<1){
            return json_encode(["stuts" => 0]);
        }
        foreach($cityList->hits->hits as $key=>$list){
            if(property_exists($list->_source,'titleImage')){
                $cityList->hits->hits[$key]->_source->titleImage = get_img_url('commPhoto',$list->_source->titleImage);
            }
        }
        $Statistics = new StatisticsDao();
        $Status = $Statistics->getBusinessAreaStatusByBId($data->businessAreaId, $type, $this->housetype1, $this->housetype2);
        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $cityDao = new CityDao();
        $community = $cityDao->getBusinessareaAreaById($data->businessAreaId);
        $houseDao = new HouseDao();
        //是否关注
        if(!empty(Auth::id())){
            $interest['uid'] = Auth::id();
            if(strpos($type,'esb')){
                $interest['isNew'] = 0;
            }else{
                $interest['isNew'] = 1;
            }
            $interest['tableType'] =  3;
            $interest['type1'] = 3;
            $interest['is_del'] = 0;
            $dataArr = $houseDao->getInterestByUid($interest);
            $result = ["stuts" => 1, "hdate" => $cityList, "cdate" => $community[0], 'lefthead'=>$leftHead,'tags'=>$tags,'interest'=>$dataArr];
        }else{
            if(!$community){
                $result = ["stuts" => 1, "hdate" => $cityList];
            }else{
                $result = ["stuts" => 1, "hdate" => $cityList, "cdate" => $community[0], 'lefthead'=>$leftHead,'tags'=>$tags];
            }

        }

        return json_encode($result);
    }

    //开盘时间转换 $key 键值
    public function openTimeConversion($key){
        $sthisMonthStart = strtotime(date("Ym01"))*1000; //本月月初 时间戳
        $thisMonthStart = date('Ym01', strtotime(date("Ymd"))); //本月月初 日期格式
        $thisMonthEnd = strtotime("$thisMonthStart +1 month -1 day")*1000; //本月月末
        $nextMonthStart = strtotime("$thisMonthStart +1 month")*1000; //下月月初
        $nextMonthEnd = strtotime("$thisMonthStart +2 month -1 day")*1000;//下月月末
        $cthisMonthStart = date("Y-m-d"); //当前时间
        $threeMonthEnd = strtotime("$cthisMonthStart +3 month -1 day")*1000;//三个月月末
        $sixMonthEnd = strtotime("$cthisMonthStart +6 month -1 day")*1000;//六个月个月月末
        $current = date('Y-m-d H:i:s');
        $time = time()*1000;
        $tMonthEnd = strtotime("$current -3 month")*1000;//已开盘三个月
        $sMonthEnd = strtotime("$current -6 month")*1000;//已开盘六个月
        $res = '';
        switch($key){
            case 1:
                $res = $sthisMonthStart.','.$thisMonthEnd;
                break;
            case 2:
                $res = $nextMonthStart.','.$nextMonthEnd;
                break;
            case 3:
                $res = $time.','.$threeMonthEnd;
                break;
            case 4:
                $res = $time.','.$sixMonthEnd;
                break;
            case 5:
                $res = $tMonthEnd.','.$time;
                break;
            case 6:
                $res = $sMonthEnd.','.$time;
                break;
            default:
                $res = '';
        }
        return $res;
    }
    //无刷新分页获取新楼盘信息
    public function getCommunity(){
        $type = Input::get("type");
        $this->condition->isNew = true;
        $this->condition->asc = false;
        $this->condition->pageset = 6;
        $this->condition->page = Input::get("page", 1);
        $areaId = Input::get('areaId',0);
        if($areaId>=0){
            $this->condition->cityareaId = $areaId;
        }
        //获取地铁线数据
        $lineId = Input::get('lineId',0);
        if($lineId>0){
            $this->condition->subwayLineId = $lineId;
        }
        //获取地铁站点id
        $stationId = Input::get('stationId',0);
        if($stationId){
            $this->condition->subwayStationId = $stationId;
        }
        if(Input::get('keyword',0)){
            $this->condition->keyword = Input::get('keyword');
        }
        $search = new Search();
        $this->condition->order='timeUpdateLong';
        $houseData = $search->searchCommunity($this->condition);
        foreach($houseData->hits->hits as $key=>$list){
            if(property_exists($list->_source,'titleImage')){
                $houseData->hits->hits[$key]->_source->titleImage = get_img_url('commPhoto',$list->_source->titleImage);
            }
        }

        $count = count($houseData->hits->hits);
        if($count>=1){
            $result['status'] = 1;
            $result['community']  = $houseData;
        }else{
            $result['status'] = 0;
        }

        $houseDao = new HouseDao();
        $tags = $houseDao->getHouseTag($wheretag = array('type' => 1, 'propertyType1' => 3));
        $result['tags'] = $tags;

        if(!empty(Auth::id())){
            $interest['uid'] = Auth::id();
            if(strpos($type,'esb')){
                $interest['isNew'] = 0;
            }else{
                $interest['isNew'] = 1;
            }
            $interest['tableType'] =  3;
            $interest['type1'] = 3;
            $interest['is_del'] = 0;
            $houseDao = new HouseDao();
            $dataArr = $houseDao->getInterestByUid($interest);
            if(!empty($dataArr)){
                $result['interest'] = $dataArr;
            }
        }
        return json_encode($result);
    }
    /*获取商圈信息*/
    public function getBusiness(){
        $areaId = Input::get('areaId');
        $houseDao = new cityDao();
        $dataArr = $houseDao->selectBusinessArea($areaId);
        return json_encode($dataArr);
    }
}