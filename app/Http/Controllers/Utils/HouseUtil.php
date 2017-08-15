<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Utils;

/**
 * Description of HouseUtil
 *
 * @author yuanl
 */
class HouseUtil
{
    // put your code here
    public static function Convert2HouseType($communityType)
    {
        if ($communityType == 128) {
            $housetype = 1;
        } elseif ($communityType == 64) {
            $housetype = 2;
        } elseif ($communityType == 32) {
            $housetype = 6;
        } elseif ($communityType == 16) {
            $housetype = 3;
        } elseif ($communityType == 8) {
            $housetype = 4;
        } elseif ($communityType == 4) {
            $housetype = 5;
        } else {
            $housetype = 0;
        }
        return $housetype;
    }
}
