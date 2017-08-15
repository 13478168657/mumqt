<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Utils;

/**
 * Description of UserIdUtil
 *
 * @author yuanl
 */
class UserIdUtil {
    
    /**
     * 获取记录所在的数据连接序号
     * @param type $id ：待查找的记录ID
     * @return type　：数据库连接序号
     */
    public static function getNodeNum($id){
        $userDBCount = config("dbMapConfig.userDBCount");        
        $n = UserIdUtil::Kmod($id,$userDBCount) + 1;       
        return $n;
    }
        
    static function Kmod($bn, $sn){
        return intval(fmod(floatval($bn), $sn));
    }
}
