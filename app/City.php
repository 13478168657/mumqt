<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use App\Http\Controllers\Utils\MapUtil;

/**
 * Description of City
 *
 * @author yuanl
 */
class City
{
    public $id;
    public $name;
    public $py;
    public $pinyin;
    public $lng;
    public $lat;
    public $rangeKmLng;
    public $rangeKmLat;

    public function __construct($id, $name, $py, $pinyin, $lng, $lat)
    {
        $this->id = $id;
        $this->name = $name;
        $this->py = $py;
        $this->pinyin = $pinyin;
        $this->lng = $lng;
        $this->lat = $lat;
        $range = MapUtil::GetRangeByKm($lat);
        $this->rangeKmLng = $range[1];
        $this->rangeKmLat = $range[0];
    }
}
