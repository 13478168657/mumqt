<?php

namespace App\Http\Controllers\Utils;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nume_FormatUtil
 * 数字每三位加逗号(金额)
 * @author niewu
 */
class Num_FormatUtil {

    function num_format($num) {
        if (!is_numeric($num)) {
            return false;
        }
        $num = explode('.', $num); //把整数和小数分开 
        $rl = $num[1]; //小数部分的值 
        $j = strlen($num[0]) % 3; //整数有多少位 
        $sl = substr($num[0], 0, $j); //前面不满三位的数取出来 
        $sr = substr($num[0], $j); //后面的满三位的数取出来 
        $i = 0;
        while ($i <= strlen($sr)) {
            $rvalue = $rvalue . ',' . substr($sr, $i, 3); //三位三位取出再合并，按逗号隔开 
            $i = $i + 3;
        }
        $rvalue = $sl . $rvalue;
        $rvalue = substr($rvalue, 0, strlen($rvalue) - 1); //去掉最后一个逗号 
        $rvalue = explode(',', $rvalue); //分解成数组 
        if ($rvalue[0] == 0) {
            array_shift($rvalue); //如果第一个元素为0，删除第一个元素 
        }
        $rv = $rvalue[0]; //前面不满三位的数 
        for ($i = 1; $i < count($rvalue); $i++) {
            $rv = $rv . ',' . $rvalue[$i];
        }
        if (!empty($rl)) {
            $rvalue = $rv . '.' . $rl; //小数不为空，整数和小数合并 
        } else {
            $rvalue = $rv; //小数为空，只有整数 
        }
        return $rvalue;
    }

}
