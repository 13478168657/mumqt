<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Utils;

/**
 * Description of MapUtil
 *
 * @author yuanl
 */
class MapUtil {
    
    public static function GetRangeByKm($lat){
        $r = array(2);
        $r[0] = 180 / pi() * 1 / 6372.797; 
        $r[1] = $r[0] / cos($lat * pi() / 180);
        return $r;
    }

}
