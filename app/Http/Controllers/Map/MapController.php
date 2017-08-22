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
use App\Http\Controllers\Lists\PublicController;

/**
 * 地图显示控制器
 * @author yuanl
 * @date 2016年1月20日 上午10:19:40
 */
class MapController extends Controller
{

    private static $cityareaMaxLevel = 14;
    private static $businessareaMaxLevel = 16;
    private $city;
    private $showlevel;
    private $zoom;
    private $housetype1;
    private $housetype2;
    private $condition;
    private $sort;

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
        $this->city = new City(CURRENT_CITYID, CURRENT_CITYNAME, CURRENT_CITYPY, "", CURRENT_LNG, CURRENT_LAT);
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
                $this->condition->price2 = Config::get('conditionConfig.totalprice.number')[Input::get("totalprice", 0) + 0];
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
                $totalprice = Config::get('conditionConfig.totalprice');
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
        //获取地铁线和地铁站点
        $stations = MapDao::GetStations($this->city->id);
        if($type=='sale'){
            $es_Search = new \App\Services\Search('hs');
        }else{
            $es_Search = new \App\Services\Search('hr');
        }
        $lisAttr = new \App\ListInputView();
        $lisAttr ->type1 = $this->housetype1;
        $lisAttr->cityId = $this->city->id;;//城市id
//        $lisAttr->subwayLineId = 10;//地铁线路id
//		$lisAttr->subwayStationId = 226;
        $lisAttr->order = 'timeCreate';
        $lisAttr->asc = 0;
        $lisAttr->page = 1;
        $lisAttr->pageset = 1000;
        $data = $es_Search->searchHouse4Group($lisAttr, 'subwayLineId', false);
        $stationData = $es_Search->searchHouse4Group($lisAttr, 'subwayStationId', false);
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
            $view = 'h5.map.map';
        }else{
            $view = 'map.map';
        }
        $public = new PublicController();
        $cityAreas = $public->getCityArea($this->city->id);

        //二手楼盘id
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
            ->with('communityId',$communityId)
            ->with('longitude',$longitude)
            ->with('latitude',$latitude);
    }

    public function MapSearch()
    {
        $type = Input::get("type");
        if ($type == 'new') {
            $this->condition->isNew = true;
            $search = new Search('hs');
        } else if ($type == 'rent') {
            $imageType = 'houseRent';
            $search = new Search('hr');
        } else {
            $imageType = 'houseSale';
            $search = new Search('hs');
        }
        $this->condition->swlng = Input::get("swlng", 0);
        $this->condition->swlat = Input::get("swlat", 0);
        $this->condition->nelng = Input::get("nelng", 0);
        $this->condition->nelat = Input::get("nelat", 0);
        $this->condition->pageset = 6;
        $zoom = Input::get("zm");
        if ($this->sort == 'asc'){
            $this->condition->asc = true;
        } else {
            $this->condition->asc = false;
        }

        if(Input::get('ca',0) >=1){
            $this->condition->cityareaId = Input::get('ca');
        }

        //楼盘id
        $communityId = Input::get('communityId',0);
        if($communityId>0){
            $this->condition->communityId = $communityId;
        }
        $result = $search->mapSearch($this->condition, $zoom);
        //房源信息
        $data = $this->condition;
        $data->pageset = 6;
        $data->order="timeUpdateLong";
        $data->page = Input::get("page", 1);
        $houselist = $search->searchHouse($data);
        $houseDao = new HouseDao();
        $houseTags = $houseDao->getAllHouseTag();
        foreach ($houselist->hits->hits as $key => $value) {
            $houselist->hits->hits[$key]->_source->thumbPic = get_img_url($imageType, $value->_source->thumbPic, 1);
            $tags = [];
            if($houselist->hits->hits[$key]->_source->tagId != ''){
                $tagArr = explode('|', $houselist->hits->hits[$key]->_source->tagId);
                $tagArr = array_filter($tagArr);
                foreach ($tagArr as $value){
                    $tags[] = $houseTags[$value];
                }
            }
            $houselist->hits->hits[$key]->_source->tagId = $tags;

            $houselist->hits->hits[$key]->_source->faceTo = Config::get('conditionConfig.toward.text')[$houselist->hits->hits[$key]->_source->faceTo];  //朝向

            if($type=='rent') {
                $houselist->hits->hits[$key]->_source->rentType = Config::get('conditionConfig.rentway.text')[$houselist->hits->hits[$key]->_source->rentType];//租住方式
                if($this->housetype1=='1') {
                    $houselist->hits->hits[$key]->_source->houseType2 = Config::get('conditionConfig.housetype1.text')[$houselist->hits->hits[$key]->_source->houseType2];//商铺副物业类型
                }
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
        $result['house'] = $houselist;
        return response()->json($result);
    }

    public function SubwaySearch()
    {
        $search = new SearchController('hs');
        $subwayLine = Input::get("subwayLine");
        $subwayStation = Input::get("subwayStation");
        $ht = 128;
        $zoom = Input::get("zm");
        $result = $search->subwaySearch($ht, $this->city->id, $subwayLine, $subwayStation, null, null, $zoom);
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
        //城区
        $areaId = Input::get('areaId',0);
        if($areaId>0){
            $data->cityareaId = $areaId;
        }
        //商圈
        $businessId = Input::get('businessId',0);
        if($businessId>0){
            $data->businessAreaId = $businessId;
        }



        //地铁线
        $lineId = Input::get('lineId',0);
        if($lineId>0){
            unset($data->cityareaId);
            unset($data->businessAreaId);
            unset($data->communityId);
            $data->subwayLineId =$lineId;
        }
        //地铁站点
        $stationId = Input::get('stationId',0);
        if($stationId){
            unset($data->cityareaId);
            unset($data->businessAreaId);
            $data->subwayStationId = $stationId;
        }
        //楼盘
        $community = Input::get("communityid");
        if($community>0){
            $data->communityId = Input::get("communityid");
            unset($data->subwayStationId);
        }
        $data->type1 = $this->housetype1;

        $data->pageset = 6;
        $data->page = Input::get("page", 1);
        $data->order= 'timeUpdateLong';
        $houselist = $search->searchHouse($data);

        $houseDao = new HouseDao();
        $houseTags = $houseDao->getAllHouseTag();
        foreach ($houselist->hits->hits as $key => $value) {
            $houselist->hits->hits[$key]->_source->thumbPic = get_img_url($imageType, $value->_source->thumbPic, 1);
            $tags = [];
            if($houselist->hits->hits[$key]->_source->tagId != ''){
                $tagArr = explode('|', $houselist->hits->hits[$key]->_source->tagId);
                $tagArr = array_filter($tagArr);
                foreach ($tagArr as $value){
                    $tags[] = $houseTags[$value];
                }
            }
            $houselist->hits->hits[$key]->_source->tagId = $tags;

            $houselist->hits->hits[$key]->_source->faceTo = Config::get('conditionConfig.toward.text')[$houselist->hits->hits[$key]->_source->faceTo];  //朝向

            if($type=='rent') {
                $houselist->hits->hits[$key]->_source->rentType = Config::get('conditionConfig.rentway.text')[$houselist->hits->hits[$key]->_source->rentType];//租住方式
                if($this->housetype1=='1') {
                    $houselist->hits->hits[$key]->_source->houseType2 = Config::get('conditionConfig.housetype1.text')[$houselist->hits->hits[$key]->_source->houseType2];//商铺副物业类型
                }
            }

        }
        $Status = null;
        $community= null;
        $Statistics = new StatisticsDao();
        if($lineId<1 && $stationId<1){
            $Status = $Statistics->getCommunityStatusByCId($data->communityId, $type, $this->housetype1, $this->housetype2);
            $community = $search->getCommunityByCid($data->communityId);
        }

        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $result = ["stuts" => 1, "hdate" => $houselist, "cdate" => $community, 'lefthead'=>$leftHead];
        return json_encode($result);
    }

    public function getBusinessareaByCaid()
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

        //房源信息
        $data->pageset = 6;
        $data->page = Input::get("page", 1);
        $data->order = 'timeUpdateLong';
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

            $houselist->hits->hits[$key]->_source->faceTo = Config::get('conditionConfig.toward.text')[$houselist->hits->hits[$key]->_source->faceTo];  //朝向

            if($type=='rent') {
                $houselist->hits->hits[$key]->_source->rentType = Config::get('conditionConfig.rentway.text')[$houselist->hits->hits[$key]->_source->rentType];//租住方式
                if($this->housetype1=='1') {
                    $houselist->hits->hits[$key]->_source->houseType2 = Config::get('conditionConfig.housetype1.text')[$houselist->hits->hits[$key]->_source->houseType2];//商铺副物业类型
                }
            }

        }

        $result = ["stuts" => 1, "hdate" => $cityList, "cdate" => $community[0], 'lefthead'=>$leftHead,'house'=>$houselist];
        return json_encode($result);
    }

    public function getCommunityByBid()
    {
        $type = Input::get("type");
        $data = $this->condition;
        if ($type == 'new') {
            $data->isNew = true;
            $search = new Search('hs');

        } else if ($type == 'rent') {
            $imageType = 'houseRent';
            $search = new Search('hr');
        } else {
            $imageType = 'houseSale';
            $search = new Search('hs');
        }
        if ($this->sort == 'asc'){
            $data->asc = true;
        } else {
            $data->asc = false;
        }
        $bId = Input::get("bid");
        if($bId>0){
            $data->businessAreaId = $bId;
        }

        $keyword = Input::get('keyword');
        if(!empty($keyword)){
            $data->keyword= $keyword;
        }

        $Statistics = new StatisticsDao();

        if(USER_AGENT_MOBILE){
            $cityList = $search->searchCommunity($data);
            $Status = $Statistics->getBusinessAreaStatusByBId($data->businessAreaId, $type, $this->housetype1, $this->housetype2);
        }elseif(!empty($keyword)){
            unset($data->type1);
            $cityList = $search->searchCommunity($data);
            if(count($cityList->hits->hits)<1){
                $result = ["stuts" => 0];
                return json_encode($result);
            }
            $Status = $Statistics->getCommunityStatusByCId($cityList->hits->hits[0]->_source->id, $type, 3, $this->housetype2);
        }else{
            $cityList = $search->mapSearch($data, 16);
            $Status = $Statistics->getBusinessAreaStatusByBId($data->businessAreaId, $type, $this->housetype1, $this->housetype2);
        }


        $leftHead['avgPrice'] = '暂无数据';
        $leftHead['increase'] = '--';
        if ($Status != null) {
            $leftHead['avgPrice'] = $Status->avgPrice;
            $leftHead['increase'] = $Status->increase;
        }
        $cityDao = new CityDao();
        $community = $cityDao->getBusinessareaAreaById($data->businessAreaId);

        //房源信息
        $data->pageset = 6;
        $data->page = Input::get("page", 1);
        $data->order='timeUpdateLong';
        $houselist = $search->searchHouse($data);
        $houseDao = new HouseDao();
        $houseTags = $houseDao->getAllHouseTag();
        foreach ($houselist->hits->hits as $key => $value) {
            $houselist->hits->hits[$key]->_source->thumbPic = get_img_url($imageType, $value->_source->thumbPic, 1);
            $tags = [];
            if($houselist->hits->hits[$key]->_source->tagId != ''){
                $tagArr = explode('|', $houselist->hits->hits[$key]->_source->tagId);
                $tagArr = array_filter($tagArr);
                foreach ($tagArr as $value){
                    $tags[] = $houseTags[$value];
                }
            }
            $houselist->hits->hits[$key]->_source->tagId = $tags;

            $houselist->hits->hits[$key]->_source->faceTo = Config::get('conditionConfig.toward.text')[$houselist->hits->hits[$key]->_source->faceTo];  //朝向

            if($type=='rent') {
                $houselist->hits->hits[$key]->_source->rentType = Config::get('conditionConfig.rentway.text')[$houselist->hits->hits[$key]->_source->rentType];//租住方式
                if($this->housetype1=='1') {
                    $houselist->hits->hits[$key]->_source->houseType2 = Config::get('conditionConfig.housetype1.text')[$houselist->hits->hits[$key]->_source->houseType2];//商铺副物业类型
                }
            }

        }


        if(USER_AGENT_MOBILE || !empty($keyword)){
                $result = ["stuts" => 1, "hdate" => $cityList, 'lefthead'=>$leftHead];
        }else{
            $result = ["stuts" => 1, "hdate" => $cityList, "cdate" => $community[0], 'lefthead'=>$leftHead,'house'=>$houselist];
        }
        return json_encode($result);
    }
}