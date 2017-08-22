<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of Community
 *
 * @author yuanl
 */
class Community {
    
    public $id;
    public $name;
    public $longitude;
    public $latitude;
    public $address;
    public $buildYear;
    public $estateCompany;
    public $estateFee;
    public $developer;
    public $greenRate;
    public $parking;
    public $timeRefreshRent;
    public $timeRefreshSale;
    public $rentBrokers;
    public $saleBrokers;
    public $rentHouses;
    public $saleHouses;
    public $priceRentBegin;
    public $priceSaleBegin;
    public $priceRent;
    public $priceSale;
    public $isNew;
    
    public function __construct(){ }
}
