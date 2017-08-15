<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of MapCommunitiesCluster
 *
 * @author yuanl
 */
class MapCommunitiesCluster {
    public $id;
    public $name;
    public $lng;
    public $lat;
    public $count;
    public $swlng;
    public $swlat;
    public $nelng;
    public $nelat;
    public function __construct($id,$name,$lng,$lat,$count,$swlng,$swlat,$nelng,$nelat){
        $this->id = $id;
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->count = $count;
        $this->swlat = $swlat;
        $this->swlng = $swlng;
        $this->nelat = $nelat;
        $this->nelng = $nelng;
    }
}
