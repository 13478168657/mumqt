<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/22
 * Time: 17:24
 */


namespace App\Http\Controllers\Utils;

use DB;
use Cookie;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

define('COOKIE_TIME', 360 * 24 * 60);
define('COOKIE_CACHE_TYPE', 'redis');
define('COOKIE_CACHE_TIME', 60 * 24 * 7);
define('COOKIE_CITY_CACHE', 'cookiecache');

class CookieUtil extends Controller
{

    public static function getCityByPy($py)
    {
        $city = Cache::store(COOKIE_CACHE_TYPE)->get(COOKIE_CITY_CACHE . $py);
        if (empty($city) || (!isset($city))) {
            $city = DB::connection('mysql_house')->table('city')
                ->where('py', $py)
                ->get(['name', 'fullname', 'id', 'pinyin', 'longitude', 'py', 'latitude']);
            Cache::store(COOKIE_CACHE_TYPE)->put(COOKIE_CITY_CACHE . $py, $city, COOKIE_CACHE_TIME);
        }
        if (empty($city)) return false;
        return $city[0];
    }

    public static function setCookieWithCity($city)
    {
        CookieUtil::SaveCookie('city', $city);
    }

    /**
     * ����cookie
     * @param type $name
     * @param type $value
     */
    public static function SaveCookie($name, $value)
    {

        if (Cookie::has($name)) {
            Cookie::forget($name);
            Cookie::make($name, $value, COOKIE_TIME);
            Cookie::queue($name, $value, COOKIE_TIME);
        } else {
            Cookie::make($name, $value, COOKIE_TIME);
            Cookie::queue($name, $value, COOKIE_TIME);
        }
    }

    public static function setCookieWithCityId($id)
    {
        CookieUtil::SaveCookie('cityId', $id);
    }

    /**
     * 通过城市名字获取城市信息
     * @param string $cityName
     */
    public static function getCityByName($cityName)
    {
        $city = Cache::store(COOKIE_CACHE_TYPE)->get(COOKIE_CITY_CACHE . $cityName);
        if (empty($city) || (!isset($city))) {
            $city = DB::connection('mysql_house')->table('city')
                ->where('name', $cityName)
                ->get(['name', 'fullname', 'id', 'pinyin', 'py', 'longitude', 'latitude']);
            Cache::store(COOKIE_CACHE_TYPE)->put(COOKIE_CITY_CACHE . $cityName, $city, COOKIE_CACHE_TIME);
        }
        if (empty($city)) return false;
        return $city[0];
    }
}
