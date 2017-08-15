<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Utils;
use App\Dao\City\CityDao;

/**
 * Description of DateUtil
 *
 * @author yuanl
 */
class AreaUtil {

	/**
	* 获取province表(省份)信息
	*/
    public static function getProvinceData($districtId = 0){
    	$info = new CityDao; // new CityDao 查询方法
    	$provinceData = $info->selectProvince();
    	return $provinceData;
    }

    /**
    * 获取city表(城市)信息
    */
    public static function getCityData($id){
    	$info = new CityDao; // new CityDao 查询方法
    	$cityData = $this->CityDao->selectCity();
    	return $cityData;
    }

    /**
    * 获取cityarea表(城区表)信息
    */
    public static function getCityAreaData($id){
    	$info = new CityDao; // new CityDao 查询方法
    	$cityAreaData = $this->CityDao->selectCityArea();
    	return $cityAreaData;
    }

    /**
    * 获取businesstags表(大商圈(商业圈))信息
    */
    public static function getBusinessTags($id){
    	$info = new CityDao; // new CityDao 查询方法
    	$businessTags = $this->CityDao->selectBusinessTag();
    	return $businessTags;
    }
}
