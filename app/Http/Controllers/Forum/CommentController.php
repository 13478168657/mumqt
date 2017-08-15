<?php

namespace App\Http\Controllers\Forum;

use App\Article;
use Illuminate\Routing\Controller;

/**
 * 用户评论控制器V0.1
 * 当前版本(V0.1)仅用于Mongodb连接测试
 *
 * @author yuanl
 */
class CommentController extends Controller {
    
    public function writeSample(){
    
        date_default_timezone_set('prc');
        $a = new Article;
        $a->communityId = 1;
        $a->content = 'Juse a test article';
        $a->countAgree = 10;
        $a->countReply = 2;
        $a->scoreDistrict = 4;
        $a->scoreEnvironment = 4;
        $a->scoreEquip = 5;
        $a->scorePrice = 3;
        $a->scoreTotal = 4.5;
        $a->scoreTraffic = 5;
        $a->tags = '交通,配套,价格,户型,环境';
        $a->timeUpdate = date('Y-m-d H:i:s');
        CommentController::write($a);
    
    }
    
    public function write($a){
        
        $a->save();

    }
    
}
