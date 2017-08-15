<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dao\Map;

use DB;
/**
 * Description of MapDao
 *
 * @author yuanl
 */
class MapDao {
    
    public static function GetSubwayLines($cityId){
        $subways = DB::connection('mysql_house')->select('select id,name,centerLng,centerLat,centerLevel from subwayline where cityId = ?', array($cityId));
        return $subways;
    }
    
    public static function GetCityareas($cityId){
        $cityareas = DB::connection('mysql_house')->Select("select id,cityId,name,longitude,latitude from cityarea where cityid=? OR linkCityId=?",array($cityId, $cityId));
        return $cityareas;
    }
    
    public static function GetBusinessareas($cityId){
        $businessareas = DB::connection('mysql_house')->Select("select id,cityId,name,longitude,latitude from businessArea where cityid=?",array($cityId));
        return $businessareas;
    }
    
    public static function GetCommunities($cityId){
        $communities = DB::connection('mysql_house')->Select("select id,cityId,name,longitude,latitude from community where cityid=? limit 50000",array($cityId));
        return $communities;
    }

    public static function GetCommunity($cid){
        $community =  DB::connection('mysql_oldhouse')->Select("select id,cityId,name,longitude,latitude,subwayStationId from community where id=?",array($cid));
        if (count($community) > 0) {
            return $community[0];
        } else {
            return null;
        }
    }
    
    public static function GetSubwayStations($cityId,$lineName){
        $subways = DB::connection('mysql_house')->Select("select id,linename,name,longitude,latitude from subwaystation where cityId = ? and linename = ?", array($cityId,$lineName));
        return $subways;
    }

    public static function SelectSubWayStations($cityId,$lineId){
        $subways = DB::connection('mysql_house')->Select("select id,linename,name,longitude,latitude from subwaystation where cityId = ? and lineId = ?", array($cityId,$lineId));
        return $subways;
    }

    public static function GetStations($cityId){
        $stations = DB::connection('mysql_house')->Select("select id,lineId,linename,name,longitude,latitude from subwaystation where cityId = ? order by lineId asc", array($cityId));
        return $stations;
    }
    
}
