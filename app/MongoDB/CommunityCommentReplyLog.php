<?php

namespace App\MongoDB;
use Jenssegers\Mongodb\Model as Eloquent;

/**
 * 楼盘评论回复记录表
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月10日 下午4:31:01
 * @version 1.0
 */
class CommunityCommentReplyLog extends Eloquent {
    protected $connection = 'mongodb';
    protected $table = 'communitycommentreplylog';
}