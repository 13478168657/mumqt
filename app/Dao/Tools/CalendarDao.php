<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dao\Tools;
use DB;
/**
 * Description of SearchDao
 *
 * @author cjr
 */
class CalendarDao {
//取新盘开盘信息
function getNewCommunityInfo($cityid,$beginDate)
{
    $results=DB::connection('mysql_house')
    ->select('SELECT cm.name,cp.communityId,cp.period,cp.openTime,cp.type2 from communityperiods cp INNER JOIN community cm on cm.cityId=? and cp.communityId=cm.id where cp.openTime>=? and cp.marketingType=?',[$cityid,"$beginDate",1]);

    return $results;
}
}
