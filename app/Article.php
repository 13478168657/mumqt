<?php

namespace App;

use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Description of Article
 *
 * @author yuanl
 */
class Article extends Eloquent {
    
    protected $connection = 'mongodb';
    protected $collection = 'articles';
    
//    public $content;
//    public $communityId;
//    public $tags;
//    public $scorePrice;
//    public $scoreDistrict;
//    public $scoreTraffic;
//    public $scoreEquip;
//    public $scoreEnvironment;
//    public $scoreTotal;
//    public $countAgree;
//    public $countReply;
//    public $timeUpdate;
    
}
