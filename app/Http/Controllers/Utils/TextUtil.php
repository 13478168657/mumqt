<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Utils;

/**
 * Description of TextUtil
 *
 * @author yuanl
 */
class TextUtil {

    public static function TransNum2Str($s){
        $s = str_replace("1","一",$s);
        $s = str_replace("2","二",$s);
        $s = str_replace("3","三",$s);
        return $s;
    }  
    public static function FormatQueryBlank($key){
        $k = str_replace("　", " ", $key);
        while (strpos($k, "  ") !== false){
            $k = str_replace("  ", " ", $k);
        }
        return trim($k);
    }
    public static function FormatInQueryStr($str)
    {
        $noise = array("+","-","&&","||","!","(",")","{","}","[","]","^","\"","~","*","?",":","\\","/");
        foreach ($noise as $s){
            $str = str_replace($s, " ", $str);
        }
        return $str;
    }

    public static function GetCtype($ctype)
    {
        $type=array('1'=>'商铺','2'=>'写字楼','3'=>'普通住宅');
        if (!isset($type[$ctype])) {
           return '';
        }
        return $type[$ctype];
    }

    public static function GetCtype2Name($ctype2)
    {
        $ctype=array('101'=>'住宅底商',
            '102'=>'商业街商铺',
            '103'=>'临街商铺',
            '104'=>'写字楼底商',
            '105'=>'购物中心商铺',
            '106'=>'其他',
            '201'=>'纯写字楼',
            '202'=>'商住楼',
            '203'=>'商业综合体楼',
            '204'=>'酒店写字楼',
            '301'=>'普通住宅',
            '302'=>'经济适用房',
            '303'=>'商住楼',
            '304'=>'别墅',
            '305'=>'豪宅',
            );
        if (!isset($ctype[$ctype2])) {
         return '';
     }
     return $ctype[$ctype2];

 }
}
