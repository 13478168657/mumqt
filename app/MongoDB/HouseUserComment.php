<?php

namespace App\MongoDB;
use Jenssegers\Mongodb\Model as Eloquent;

/**
 * 房源评论记录表
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月10日 下午3:43:38
 * @version 1.0
 */
class HouseUserComment extends Eloquent {
    protected $connection = 'mongodb';
    protected $table = 'houseusercomment';
}