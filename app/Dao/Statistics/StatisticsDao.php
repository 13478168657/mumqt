<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dao\Statistics;

use DB;
use Illuminate\Support\Facades\Cache;

/**
 * Description of SearchDao
 *
 * @author cjr
 */
class StatisticsDao
{
    /**
     * 取楼盘历史价格（查房价用）
     **/
    private $connectionName;

    public function __construct()
    {
        $this->connectionName = 'mysql_statistics';
    }

    function getCityStatusByCityId($id, $type = 'sale', $cType1 = 3, $cType2 = '')
    {
        $key = 'citystatus_' . $id . '_' . $type . '_' . $cType1 . '_' . $cType2;
        if (!Cache::has($key)) {
            $Conn = DB::connection($this->connectionName)
                ->table('citystatus2')
                ->where('cityId', $id)
                ->where('room', 0)
                ->orderBy('changeTime', 'desc');
            if ($type == 'sale') {
                $Conn->where('type', 2);
            } else {
                $Conn->where('type', 1);
            }
            if ($cType1 > 0) {
                $Conn->where('cType1', $cType1);
            }
            if ($cType2 > 0) {
                $Conn->where('cType2', $cType2);
            }
            $result = $Conn->first();
            Cache::put($key, $result, 60 * 12);
        } else {
            $result = Cache::get($key);
        }
        return $result;
    }

    function getCityAreasStatusByCityAreaId($id, $type = 'sale', $cType1 = 3, $cType2 = '')
    {
        $key = 'cityareastatus_'. $id . '_' . $type . '_' . $cType1 . '_' . $cType2;
        if (!Cache::has($key)) {
            $Conn = DB::connection($this->connectionName)
                ->table('cityareastatus2')
                ->where('cityareaId', $id)
                ->where('room', 0)
                ->orderBy('changeTime', 'desc');
            if ($type == 'sale') {
                $Conn->where('type', 2);
            } else {
                $Conn->where('type', 1);
            }
            if ($cType1 > 0) {
                $Conn->where('cType1', $cType1);
            }
            if ($cType2 > 0) {
                $Conn->where('cType2', $cType2);
            }
            $result = $Conn->first();
            Cache::put($key, $result, 60 * 12);
        } else {
            $result = Cache::get($key);
        }
        return $result;
    }

    function getBusinessAreaStatusByBId($id, $type = 'sale', $cType1 = 3, $cType2 = '')
    {
        $key = 'businessareastatus_' . $id . '_' . $type . '_' . $cType1 . '_' . $cType2;
        if (!Cache::has($key)) {
            $Conn = DB::connection($this->connectionName)
                ->table('businessareastatus2')
                ->where('businessareaId', $id)
                ->where('room', 0)
                ->orderBy('changeTime', 'desc');
            if ($type == 'sale') {
                $Conn->where('type', 2);
            } else {
                $Conn->where('type', 1);
            }
            if ($cType1 > 0) {
                $Conn->where('cType1', $cType1);
            }
            if ($cType2 > 0) {
                $Conn->where('cType2', $cType2);
            }
            $result = $Conn->first();
            Cache::put($key, $result, 60 * 12);
        } else {
            $result = Cache::get($key);
        }
        return $result;
    }

    function getCommunityStatusByCId($id, $type = 'sale', $cType1 = 3, $cType2 = '')
    {
        $key = 'communitystatus_' . $id . '_' . $type . '_' . $cType1 . '_' . $cType2;
        if (!Cache::has($key)) {
            $Conn = DB::connection($this->connectionName)
                ->table('communitystatus2')
                ->where('communityId', $id)
                ->where('room', 0)
                ->orderBy('changeTime', 'desc');
            if ($type == 'sale') {
                $Conn->where('type', 2);
            } else {
                $Conn->where('type', 1);
            }
            if ($cType1 > 0) {
                $Conn->where('cType1', $cType1);
            }
            if ($cType2 > 0) {
                $Conn->where('cType2', $cType2);
            }
            $result = $Conn->first();
            Cache::put($key, $result, 60 * 12);
        } else {
            $result = Cache::get($key);
        }
        return $result;
    }
}
