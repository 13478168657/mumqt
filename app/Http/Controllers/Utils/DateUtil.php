<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Utils;

/**
 * Description of DateUtil
 *
 * @author yuanl
 */
class DateUtil
{

    public static function GetMillisecond()
    {
        list ($s1, $s2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($s1)) * 1000);
    }

    /**
     * 
     * 获取毫秒级当前时间
     * 
     * @param string $format 日期格式, 默认:"Y-m-d H:i:s.u"
     * @return string 毫秒级当前时间.
     * @author johnyoung
     */
    public static function GetUDate($format = 'Y-m-d H:i:s.u')
    {
        $utimestamp = explode(' ', microtime());
        
        $milliseconds = substr(round($utimestamp[0], 3), 2);
        
        return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $utimestamp[1]);
    }
}
