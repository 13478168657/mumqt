<?php

namespace App\MongoDB;
use Jenssegers\Mongodb\Model as Eloquent;

/**
 * 房源评论点赞记录表
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月10日 下午3:43:13
 * @version 1.0
 */
class HouseCommentThumbLog extends Eloquent {
    protected $connection = 'mongodb';
    protected $table = 'housecommentthumblog';
}