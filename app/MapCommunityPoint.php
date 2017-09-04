<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of MapCommunityPoint
 *
 * @author yuanl
 */
class MapCommunityPoint {
    public $id;
    public $name;
    public $lng;
    public $lat;
    public $count;
    public $note;
    public function __construct($id,$name,$lng,$lat,$count,$note){
        $this->id = $id;
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->count = $count;
        $this->note = $note;
    }
}
