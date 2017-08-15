<?php

namespace App\Http\Controllers\AdCount;
use App\Dao\Ad\AdDao;
use Illuminate\Routing\Controller;
use Input;
use DB;

class IndexController extends Controller{
    
    public function __construct() {
        $this->adCount = new AdDao();
    }
    
    /*统计广告访问量 */
    public function adStatistics(){
        $param = [];
        $id = Input::get('id');
        $target = Input::get('target');
        $ipAddr  = getenv("HTTP_X_FORWARDED_FOR");
        if($ipAddr){
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        }else{
            $ip = getenv("REMOTE_ADDR");
        }
        $target = base64_decode($target);
        $param['adId'] = $id;
        $param['visitIp'] = $ip;
        $param['visitNum'] = 1;
        $param['timeCreate'] = date('Y-m-d');
        $res = $this->adCount->adVisitInsert($param);
        return "<script type='text/javascript'>window.location.href='".$target."'</script>";
    }
}