<?php

namespace App\Http\Controllers\Utils;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormatDateUtil
 * 去时间后三位，（毫秒）
 * @author niewu
 */
class FormatDateUtil {
    
    public static function FormatTime($time){
        
        $time = substr($time,strlen($time)- 3,3);
        
        return $time;
      
    }   
}