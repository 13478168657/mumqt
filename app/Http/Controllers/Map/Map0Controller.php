<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Map;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\SearchController;
use App\Dao\Map\MapDao;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
/**
 * Description of MapController
 *
 * @author yuanl
 */
class Map0Controller extends Controller{

    public function MapLoad(){
        $city = new City(1,"北京","bj",116.395645,39.929986);
        $subways = MapDao::GetSubwayLines($city->id);
        return View("map.map")->with("subways",$subways)->with("city",$city);
    }

    public function MapSearch(){
        $search = new SearchController('hs');
        $city = new City(1,"北京","bj",116.395645,39.929986);
        $type = "sale";
        $key = Input::get("keyword");
        $ht = 128;
        $swlng = Input::get("swlng");
        $swlat = Input::get("swlat");
        $nelng = Input::get("nelng");
        $nelat = Input::get("nelat");
        $zoom = Input::get("zm");
        if ($key == ""){
            if ($type == "sale"){
                $order = "timeSaleLong";
            } else {
                $order = "timeRentLong";
            }
        } else {
            $order = "";
        }
        $result = $search->mapSearch($key, $ht, $city->id, null, null, null, null, $swlng, $swlat, $nelng, $nelat, $order, false, $zoom);
        $html = json_encode($result);
        return $html;
    }

    public function SubwaySearch(){
        $search = new SearchController('hs');
        $subwayLine = Input::get("subwayLine");
        $subwayStation = Input::get("subwayStation");
        $city = new City(1,"北京","bj",116.395645,39.929986);
        $ht = 128;
        $zoom = Input::get("zm");
        $result = $search->subwaySearch($ht, $city->id, $subwayLine, $subwayStation, null, null, $zoom);
        $html = json_encode($result);
        return $html;
    }

    public function SearchHouse(){
        $fields = "\"id\",\"name\",\"longitude\",\"latitude\"";
        $search = new SearchController('hs');
        $city = new City(1,"北京","bj",116.395645,39.929986);
        $type = "sale";
        $key = "";
        $ht = 128;
        $swlng = Input::get("swlng");
        $swlat = Input::get("swlat");
        $nelng = Input::get("nelng");
        $nelat = Input::get("nelat");
        $zoom = Input::get("zm");
        if ($key == ""){
            if ($type == "sale"){
                $order = "timeSaleLong";
            } else {
                $order = "timeRentLong";
            }
        } else {
            $order = "";
        }
//        $result = $search->mapSearch($key, $ht, $city->id, null, null, null, null, $swlng, $swlat, $nelng, $nelat, $order, false, $zoom);
        $result = $search->searchHouse('hs', null, $fields, $key, $ht, $city->id, null, null, '地铁1号线', '四惠东', null, null, $swlng, $swlat, $nelng, $nelat, 1000, 1, $order, false);
        $html = json_encode($result);
        return $html;
    }

}
