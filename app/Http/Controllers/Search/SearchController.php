<?php

namespace App\Http\Controllers\Search;

use App\ESQuery;
use App\ESFilter;
use App\Http\Controllers\Search\ESIndexController;
use App\MapCommunityPoint;
use App\MapPoint;
use App\Http\Controllers\Utils\HouseUtil;
use App\Http\Controllers\Controller;
use App\Dao\Map\MapDao;
use Illuminate\Support\Facades\Cache;
/**
 * ES全文搜索控制类，提供系统所有的全文搜索接口
 *
 * @author yuanl
 */
class SearchController extends Controller {
    
    private $searchType;
    private $cityareaMaxLevel = 13;
    private $businessareaMaxLevel = 15;
    
    public function __construct($searchType){
        $this->searchType = $searchType;
    }
    
    public function mapSearch($key, $ht, $cid, $ca, $ba, $p1, $p2, $swlng, $swlat, $nelng, $nelat, $order, $asc, $zoom){
        $fields = "\"id\",\"name\",\"longitude\",\"latitude\"";
        if ($zoom < $this->cityareaMaxLevel){
            $swlng = 0; //城区级别显示全部结果，不添加移动事件
            $search = SearchController::search($this->searchType, 'cityAreaId', $fields, $key, $ht, $cid, $ca, $ba, "", "", $p1, $p2, $swlng, $swlat, $nelng, $nelat, 0, 0, '', false);
            $points = SearchController::getCityAreaPoints($cid, $search);
            return ['s'=>1,'r'=>$points];
        } else if ($zoom < $this->businessareaMaxLevel) {
            $search = SearchController::search($this->searchType, 'businessId', $fields, $key, $ht, $cid, $ca, $ba, "", "", $p1, $p2, $swlng, $swlat, $nelng, $nelat, 0, 0, '', false);
            $points = SearchController::getBusinessAreaPoints($cid, $search);
            return ['s'=>2,'r'=>$points];
        } else {
            $search = SearchController::search($this->searchType, 'communityId', $fields, $key, $ht, $cid, $ca, $ba, "", "", $p1, $p2, $swlng, $swlat, $nelng, $nelat, 1000, 1, '', false);
            $points = SearchController::getCommunityPoints($cid, $ht, $search);
            return ['s'=>3,'r'=>$points];
        }
    }
    
    public function subwaySearch($ht, $cityId, $subwayLine, $subwayStation, $p1, $p2, $zoom){
        $fields = "\"id\",\"name\",\"longitude\",\"latitude\"";
        if ($subwayStation == ""){
            $search = SearchController::search($this->searchType, 'subwayStationIds', $fields, "", $ht, $cityId, "", "", $subwayLine, "", $p1, $p2, 0, 0, 0, 0, 0, 0, '', false);
            $points = SearchController::getSubwayPoints($cityId,$subwayLine,$search);
            return ['s'=>4,'r'=>$points];
        }
        return ['s'=>9,'r'=>''];
    }
    
    private function getCityAreaPoints($cityId,$searchResult){
        $points = array();
        $cacheKey = 'indexCityArea_' . $cityId;        
        if (Cache::has($cacheKey)){
            $cityareaIndex = Cache::get($cacheKey);
        } else {
            $cityareas = MapDao::GetCityareas($cityId);
            $cityareaIndex = array();
            foreach($cityareas as $c){
                $p = new MapPoint($c->id,$c->name,$c->longitude,$c->latitude,0,'');
                $cityareaIndex[$c->id] = $p;
            }
            Cache::put($cacheKey,$cityareaIndex,60);
        }
        foreach($searchResult->aggregations->group->buckets as $r){
            if ($r->key > 0){
                $p = $cityareaIndex[$r->key];
                $p->count = $r->doc_count;
                array_push($points,$p);
            }
        }
        return $points;
    }
    
    private function getBusinessAreaPoints($cityId,$searchResult){
        $points = array();
        $cacheKey = 'indexBusinessArea_' . $cityId;        
        if (Cache::has($cacheKey)){
            $businessareaIndex = Cache::get($cacheKey);
        } else {
            $businessareas = MapDao::GetBusinessareas($cityId);
            $businessareaIndex = array();
            foreach($businessareas as $c){
                $p = new MapPoint($c->id,$c->name,$c->longitude,$c->latitude,0,'');
                $businessareaIndex[$c->id] = $p;
            }
            Cache::put($cacheKey,$businessareaIndex,60);
        }
        foreach($searchResult->aggregations->group->buckets as $r){
            if ($r->key > 0){
                $p = $businessareaIndex[$r->key];
                $p->count = $r->doc_count;
                array_push($points,$p);
            }
        }
        return $points;
    }
    
    private function getCommunityPoints($cityId, $type, $searchResult){
        $points = array();
        $cacheKey = 'indexCommunity_' . $cityId;
        if (Cache::get($cacheKey)){
            $communityIndex = Cache::get($cacheKey);
        } else {
            $communities = MapDao::GetCommunities($cityId,$type);
            $communityIndex = array();
            foreach($communities as $c){
                $p = new MapPoint($c->id,$c->name,$c->longitude,$c->latitude,0,'');
                $communityIndex[$c->id] = $p;
            }
            Cache::put($cacheKey,$communityIndex,60);
        }
        dd($communityIndex);
        foreach($searchResult->aggregations->group->buckets as $r){
            if ($r->key > 0){
                $p = $communityIndex[$r->key];
                $p->count = $r->doc_count;
                array_push($points,$p);
            }
        }
        return $points;
    }
    
    private function getSubwayPoints($cityId, $lineName, $searchResult){
        $points = array();
        $cacheKey = 'indexSubway_' . $cityId . '_' . $lineName;
        if (Cache::has($cacheKey)){
            $subwayIndex = Cache::get($cacheKey);
        } else {
            $subways = MapDao::GetSubwayStations($cityId,$lineName);
            $subwayIndex = array();
            foreach($subways as $s){
                $p = new MapPoint($s->id, $s->name, $s->longitude, $s->latitude, 0, '');
                $subwayIndex[$s->id] = $p;
            }
            Cache::put($cacheKey,$subwayIndex,60);
        }
        foreach($searchResult->aggregations->group->buckets as $r){
            if (array_key_exists($r->key,$subwayIndex)){
                $p = $subwayIndex[$r->key];
                $p->count += $r->doc_count;
                $points[$r->key] = $p;
            } else if (strpos($r->key,',') > 0) {
//                $ids = explode(',',$r->key);
//                foreach($ids as $id){
//                    if (array_key_exists($id,$subwayIndex)){
//                        if (array_key_exists($id, $points)){
//                            $p = $points[$id];
//                        } else {
//                            $p = $subwayIndex[$id];
//                        }
//                        $p->count += $r->doc_count;
//                        $points[$id] = $p;                        
//                    }
//                }
            }
        }
        $points2 = array();
        foreach ($points as $p){
            $points2[] = $p;
        }
        foreach ($subwayIndex as $s){
            if (!array_key_exists($s->id, $points)){
                $points2[] = $s;
            }
        }
        return $points2;
    }
    
//    public function mapSearch0($key, $ht, $cid, $ca, $ba, $p1, $p2, $swlng, $swlat, $nelng, $nelat, $order, $isNew, $zoom){
//        $fields = "\"id\",\"name\",\"longitude\",\"latitude\"";
//        $lngv = $nelng - $swlng;
//        $latv = $nelat - $swlat;
//        if ($zoom < 14) {
//            $cityareas = DB::connection('mysql_house')->select("select * from cityarea where cityId = ? and linkCityId = 0", array($cid));
//            $results = array();
//            foreach($cityareas as $ca){
//                if ($ca->longitude < $nelng && $ca->longitude > $swlng && $ca->latitude < $nelat && $ca->latitude > $swlat){
//                    $r = SearchController::search($fields, $key, $ht, $cid, $ca->id, $ba, $p1, $p2, null, null, null, null, 0, 1, $order, $isNew);
//                    $cs = new MapCommunityPoint($ca->id,$ca->name,$ca->longitude,$ca->latitude,$r->count,''); 
//                    array_push($results,$cs);
//                }
//            }
//            return ['s'=>1,'r'=>$results];
//        } else if ($zoom < 16) {
//            $communities = SearchController::search($fields, $key, $ht, $cid, $ca, $ba, $p1, $p2, $swlng, $swlat, $nelng, $nelat, 1, 1, $order, $isNew);
//            $results = array();           
//        } else {
//            $communities = SearchController::search($fields, $key, $ht, $cid, $ca, $ba, $p1, $p2, $swlng, $swlat, $nelng, $nelat, 100, 1, $order, $isNew);
//            $pointSet = SearchController::mapCluster($communities->hits->hits);
//            $results = array();
//            foreach($pointSet as $p){
//                array_push($results,$p);
//            }
//            return ['s'=>2,'r'=>$results];
//        }
//    }
               
    /**
     * 参数说明
     * @param type $searchType 搜索类型，'c'：楼盘；'hr'：出租房源；'hs'：出售房源
     * @param type $level 搜索级别，'city'：城市；'cityarea'：城区；'businessarea'：商圈
     * @param type $fields 输出字段名称，为空时输出所有字段
     * @param type $key 关键词
     * @param type $ht 楼盘类型，128：普通住宅……
     * @param type $cid 城市ID
     * @param type $ca 城区ID
     * @param type $ba 商圈ID
     * @param type $subwayLine  地铁线路
     * @param type $subwayStation   地铁站名
     * @param type $p1 最低均价 
     * @param type $p2 最高均价
     * @param type $swlng 地图西南经度
     * @param type $swlat 地图西南纬度
     * @param type $nelng 地图东北经度
     * @param type $nelat 地图东北纬度
     * @param type $ps 每页结果数，当此值为0时，只统计结果数目，并且忽略$pg、$order参数
     * @param type $pg 当前页号
     * @param type $order 排序方式
     * @param type $isNew 是否只搜索新楼盘
     * @return type
     */    
    public function search($searchType, $groupType, $fields, $key, $ht, $cid, $ca, $ba, $subwayLine, $subwayStation,
            $p1, $p2, $swlng, $swlat, $nelng, $nelat, $ps, $pg,$order, $asc){
        $esQuerys = array();
        $esFilters = array();
        if ($key !== null && $key !== "") {
            array_push($esQuerys, new ESQuery("keywords", $key));
        } 
        if ($cid > 0) {array_push($esQuerys, new ESQuery("cityId", $cid)); }
        if ($ca > 0){ array_push($esQuerys, new ESQuery("cityAreaId", $ca)); }
        if ($ba > 0){ array_push($esQuerys, new ESQuery("businessAreaId", $ba)); }
//        if ($isNew) { array_push($esQuerys, new ESQuery("isNew", 1)); }
        if ($swlng > 0 && $swlat > 0 && $nelng > 0 && $nelat > 0){
            array_push($esFilters, new ESFilter("longitude", 1, $swlng, $nelng, null));
            array_push($esFilters, new ESFilter("latitude", 1, $swlat, $nelat, null));
        }
        if ($p1 >= 0 && $p2 > 0){
            array_push($esFilters, new ESFilter("averagePrice", 1, $p1, $p2, null));
        } 
        if ($subwayStation !== null && $subwayStation !== ""){
            array_push($esQuerys, new ESQuery("subwayLine", $subwayLine));
            array_push($esQuerys, new ESQuery("subwayStation", $subwayStation));
        } else if ($subwayLine !== null && $subwayLine !== ""){
            array_push($esQuerys, new ESQuery("subwayLine", $subwayLine));        
        }
        $esIndex = new ESIndexController();
//        if ($ht > 0){
//            if ($ht === 128){
//                $values = array();
//                array_push($values,  HouseUtil::Convert2HouseType(128));
//                array_push($values,  HouseUtil::Convert2HouseType(64));
//                array_push($esFilters, new ESFilter("houseType", 2, null, null, $values));
//            } else {
//                array_push($esQuerys, new ESQuery("type", HouseUtil::Convert2HouseType($ht)));
//            }
//        }
        $json = $esIndex->SearchCount($searchType, $esQuerys, $esFilters, $groupType);      
        $result = json_decode($json);
        return $result;
    }
    
    public function searchHouse($searchType, $groupType, $fields, $key, $ht, $cid, $ca, $ba, $subwayLine, $subwayStation,
            $p1, $p2, $swlng, $swlat, $nelng, $nelat, $ps, $pg,$order, $asc){        
        $esQuerys = array();
        $esFilters = array();
        if ($key !== null && $key !== "") {
            array_push($esQuerys, new ESQuery("keywords", $key));
        } 
        if ($cid > 0) {array_push($esQuerys, new ESQuery("cityId", $cid)); }
        if ($ca > 0){ array_push($esQuerys, new ESQuery("cityAreaId", $ca)); }
        if ($ba > 0){ array_push($esQuerys, new ESQuery("businessAreaId", $ba)); }
//        if ($isNew) { array_push($esQuerys, new ESQuery("isNew", 1)); }
        if ($swlng > 0 && $swlat > 0 && $nelng > 0 && $nelat > 0){
            array_push($esFilters, new ESFilter("longitude", 1, $swlng, $nelng, null));
            array_push($esFilters, new ESFilter("latitude", 1, $swlat, $nelat, null));
        }
        if ($p1 >= 0 && $p2 > 0){
            array_push($esFilters, new ESFilter("averagePrice", 1, $p1, $p2, null));
        }         
        if ($subwayStation !== null && $subwayStation !== ""){
            array_push($esQuerys, new ESQuery("subwayLine", $subwayLine));
            array_push($esQuerys, new ESQuery("subwayStation", $subwayStation));
        } else if ($subwayLine !== null && $subwayLine !== ""){
            array_push($esQuerys, new ESQuery("subwayLine", $subwayLine));        
        }
        $esIndex = new ESIndexController();
        if ($ht > 0){
            if ($ht === 128){
                $values = array();
                array_push($values,  HouseUtil::Convert2HouseType(128));
                array_push($values,  HouseUtil::Convert2HouseType(64));
                array_push($esFilters, new ESFilter("houseType", 2, null, null, $values));
            } else {
                array_push($esQuerys, new ESQuery("type", HouseUtil::Convert2HouseType($ht))); 
            }
        }
        $json = $esIndex->SearchHouse($searchType, $fields, $esQuerys, $esFilters, $pg, $ps, $order, $asc);     
        $result = json_decode($json);
        return $result;
    }
    
    /**
     * 对给定的楼盘集合进行坐标聚合
     * @param type $communities
     */
    private function mapCluster($communities){
        
        $pointSet = array();
        $pointNumSet = array();
        foreach ($communities as $c){
            $id = $c->fields->id[0];
            $name = $c->fields->name[0];
            $lng = $c->fields->longitude[0];
            $lat = $c->fields->latitude[0];
            $p = new MapCommunityPoint($id,$name,$lng,$lat,1,'');
            $pointSet[$id] = $p;
            array_push($pointNumSet,$p);
        }
        $distanceSet = SearchController::initDistanceSet($pointNumSet);
        $minDis = 100;
        while (count($distanceSet) > 20){
            asort($distanceSet);
            foreach($distanceSet as $k => $v){ 
                $ps = explode('_',$k);
                if (array_key_exists($ps[0], $pointSet) && array_key_exists($ps[1], $pointSet)){
                    break;
                } else {
                    unset($distanceSet[$k]);
                }
            } 
            $p = SearchController::getNewPosition($pointSet[$ps[0]],$pointSet[$ps[1]]);
            unset($pointSet[$ps[0]]);
            unset($pointSet[$ps[1]]);
            $minDis = 100;
            $minKey = '';
            foreach($pointSet as $pi){
                $key = $p->id.'_'.$pi->id;
                $val = SearchController::getDistance($p, $pi);
                if ($val < $minDis){
                    $minDis = $val;
                    $minKey = $key;
                }
            }
            unset($distanceSet[$k]);
            $pointSet[$p->id] = $p;
            $distanceSet[$minKey] = $minDis;
        }
        return $pointSet;
    }
        
    private function initDistanceSet($pointSet){
        $distanceSet = array();
        for ($i = 0; $i < count($pointSet); $i++){
            $minDis = 100;
            $minKey = '';
            for ($j = $i + 1; $j < count($pointSet); $j++){
                $p1 = $pointSet[$i];
                $p2 = $pointSet[$j];               
                $key = $p1->id.'_'.$p2->id;
                $val = SearchController::getDistance($p1, $p2);
                if ($val < $minDis){
                    $minDis = $val;
                    $minKey = $key;
                }
            }
            if ($minKey != ''){
                $distanceSet[$minKey] = $minDis;
            }
        }        
        return $distanceSet;
    }
        
    private function getDistance($c1, $c2){
        $d = sqrt(($c1->lng - $c2->lng) * ($c1->lng - $c2->lng) + ($c1->lat - $c2->lat) * ($c1->lat - $c2->lat));
        return $d;        
    }
    
    private function getNewPosition($c1, $c2){        
        $id = $c1->id;
        $name = $c1->name;
        $lng = ($c1->lng + $c2->lng) / 2;
        $lat = ($c1->lat + $c2->lat) / 2;
        $count = $c1->count + $c2->count;
        $c = new MapCommunityPoint($id,$name,$lng,$lat,$count,'');
        return $c;
    }
}
