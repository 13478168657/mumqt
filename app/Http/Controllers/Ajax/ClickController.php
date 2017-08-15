<?php
/**
 * 候选样板代码1
 * 需要确认\App\Commands\ClickQueue的引用方式
 * 注释中添加@return说明
 */

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Queue;
use App\Jobs\HouseClick;
use Illuminate\Support\Facades\Redis;
use Auth;
use App\HouseSaleOldClickLog;
use App\HouseRentOldClickLog;
use App\Services\Search;
use App\Jobs\HouseStatistic;

/**
 * 异步实现功能
 * @access public
 * @author cjr
 * @date 2016年3月29日 下午16:45:40
 * @version 1.0
 */
class ClickController extends Controller
{

    public function houseClick()
    {
        $webUrl = Input::get('url', '');
        // dd($webUrl);
        $communityId = Input::get('cid', '0');
        $houseType = 'sale';
        $houseId = '';

        if (empty($webUrl)) {
            return;
        }

        //   /housedetail/sr53751624.html
        if (stripos($webUrl, '/housedetail')) {
            $regex = '#/housedetail/(s[sr])([0-9]+).html#i';
            $matches = array();
            if (preg_match($regex, $webUrl, $matches)) {
                //dd($matches);
                if ($matches[1] == "sr") {
                    $houseType = 'rent';
                }
                $houseId = $matches[2];
            } else {
                return;
            }
            if (empty($houseId)) {
                return;
            }
            //xinfindex
        } elseif (stripos($webUrl, '/xinfindex/')||stripos($webUrl, '/esfindex/')) {

            $regex = '#/([esfxin]+index)/([0-9]+)/[0-9]+#i';
            $matches = array();
            if (preg_match($regex, $webUrl, $matches)) {
                if ($matches[1] == "xinfindex") {
                    $houseType = 'communityXinf';
                }elseif ($matches[1]=="esfindex") {
					$houseType='communityEsf';
				}
                else {
                    return;
                }
                $communityId = $matches[2];
                $houseId = 0;
            }
            if ($communityId == 0) {
                return;
            }
        }
        else {
            return;
        }

        $userId = 0;
        $flushCount = 100;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $ckey = 'click:' . $houseId . ':' . $communityId . ':' . $userId . ':' . $houseType;
        $tkey = 'time:' . $houseId . ':' . $communityId . ':' . $userId . ':' . $houseType;

        if (Redis::exists($ckey)) {
            Redis::incr($ckey);
            if (Redis::get($ckey) >= $flushCount) {
                $this->dispatch(new HouseClick($ckey, Redis::get($ckey)));
                Redis::del($ckey);
                Redis::del($tkey);
            }elseif(time() - Redis::get($tkey) > 5*60)
            {
                $this->dispatch(new HouseClick($ckey, Redis::get($ckey)));
                Redis::del($ckey);
                Redis::del($tkey);
            }
 //           else {

//                foreach (Redis::keys('time:*') as $key) {
//                    if (time() - Redis::get($key) > 5*60) {
//                        $ckey = str_replace('time:', 'click:', $key);
//                        $this->dispatch(new HouseClick($ckey, Redis::get($ckey)));
//                        Redis::del($ckey);
//                        Redis::del($key);
//                    }
//
//                }
   //         }
        } else {
            Redis::set($ckey, 1);
            Redis::set($tkey, time());
        }


    }
//根据key返回对象
    // function houseClickLogObj($key)
    // {
    // 	$forTime=time();
    // 	$patterms=explode(':', $key);
    // 	$itemObj='';
    // 	if ($patterms[4]=='sale') {
    // 		$itemObj=new HouseSaleOldClickLog();
    // 	}elseif ($patterms[4]=='rent') {
    // 		$itemObj=new HouseRentOldClickLog();
    // 	}
    // 	$result=$itemObj->where('hId',$patterms[1])
    // 	->where('uId',$patterms[3])
    // 	->where('dateInt',Date('Ymd',$forTime))
    // 	->first();
    // 	if (count($result)==0) {
    // 		$itemObj->hId=$patterms[1];
    // 		$itemObj->cId=$patterms[2];
    // 		$itemObj->uId=$patterms[3];
    // 		$itemObj->clickCount=Redis::get($ckey);
    // 		$itemObj->dateInt=Date('Ymd',$forTime);
    // 		$itemObj->weekInt=Date('YW',$forTime);
    // 		$itemObj->monthInt=Date('Ym',$forTime);
    // 		return $itemObj;
    // 	}else
    // 	{
    // 		$result->clickCount=intval($result->clickCount)+Redis::get($ckey);
    // 		return $result;
    // 	}


    // }
    public function clickStatistic($staWay){
        $sty = Input::get('sty','');
        if(empty($sty)) return;
        
        if($staWay == 'display'){  // 统计展示量
            $this->statisticDisplay($sty);
        }else if($staWay == 'click'){ // 统计点击量
            $this->statisticClick($sty);
        }else{
            return ;
        }
        
    }
    
    public function statisticDisplay($sty){        
        $dispCount = 100;  // 展示量
        $sale = Input::get('sale','');
        if(!empty($sale)){
            foreach($sale as $s){
                $saleByEs = $this->getSaerchByhouseIds($s,'sale');                   
                if(!empty($saleByEs)){
                    if($sty == 'expertstatus'){   // 置业专家展示量统计
                        $cacheKey = 'display:sale:'.$s.':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_expertstatus';
                        $timeKey  = 'displayTime:sale:'.$s.':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_expertstatus';
                    }else if($sty == 'housestickstatus'){  // 房源置顶展示量统计
                        $cacheKey = 'display:sale:'.$s.':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_housestickstatus';
                        $timeKey  = 'displayTime:sale:'.$s.':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_housestickstatus';
                    }else if($sty == 'houseputstatus'){  // 房源定投展示量统计
                        $cacheKey = 'display:sale:'.$s.':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_houseputstatus';
                        $timeKey  = 'displayTime:sale:'.$s.':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_houseputstatus';
                    }
                    $this->redisCache($cacheKey,$timeKey,$dispCount);
                }
            }
        }
        $rent = Input::get('rent','');
        if(!empty($rent)){
            foreach($rent as $r){
                $rentByEs = $this->getSaerchByhouseIds($r,'rent');
                if(!empty($rentByEs)){  // 置业专家展示量统计
                    if($sty == 'expertstatus'){ 
                        $cacheKey = 'display:rent:'.$r.':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_expertstatus';
                        $timeKey  = 'displayTime:rent:'.$r.':'.$saleByEs['houseType1'].':'.$rentByEs['uid'].':market_expertstatus';
                    }else if($sty == 'housestickstatus'){  // 房源置顶展示量统计
                        $cacheKey = 'display:rent:'.$r.':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_housestickstatus';
                        $timeKey  = 'displayTime:rent:'.$r.':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_housestickstatus';
                    }else if($sty == 'houseputstatus'){  // 房源定投展示量统计
                        $cacheKey = 'display:rent:'.$r.':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_houseputstatus';
                        $timeKey  = 'displayTime:rent:'.$r.':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_houseputstatus';
                    }
                    $this->redisCache($cacheKey,$timeKey,$dispCount);
                }
            }
        }
        
    }
    
    public function statisticClick($sty){
        $clickCount = 100;  // 点击量
        $sale = Input::get('sale','');
        if(!empty($sale)){
            if(!is_numeric($sale[0])) return ;
            $saleByEs = $this->getSaerchByhouseIds($sale[0],'sale');
            if(empty($saleByEs)) return ;
            if($sty == 'expertstatus'){   // 置业专家点击量统计
                $cacheKey = 'click:sale:'.$sale[0].':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_expertstatus';
                $timeKey  = 'clickTime:sale:'.$sale[0].':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_expertstatus';
            }else if($sty == 'housestickstatus'){  // 房源置顶点击统计
                $cacheKey = 'click:sale:'.$sale[0].':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_housestickstatus';
                $timeKey  = 'clickTime:sale:'.$sale[0].':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_housestickstatus';
            }else if($sty == 'houseputstatus'){  // 房源定投点击统计
                $cacheKey = 'click:sale:'.$sale[0].':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_houseputstatus';
                $timeKey  = 'clickTime:sale:'.$sale[0].':'.$saleByEs['houseType1'].':'.$saleByEs['uid'].':market_houseputstatus';
            }
            $this->redisCache($cacheKey,$timeKey,$clickCount);
        }
        $rent = Input::get('rent','');
        if(!empty($rent)){
            if(!is_numeric($rent[0])) return ;
            $rentByEs = $this->getSaerchByhouseIds($rent[0],'rent');
            if(empty($rentByEs)) return ;
            if($sty == 'expertstatus'){   // 置业专家点击量统计
                $cacheKey = 'click:rent:'.$rent[0].':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_expertstatus';
                $timeKey  = 'clickTime:rent:'.$rent[0].':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_expertstatus';
            }else if($sty == 'housestickstatus'){  // 房源置顶点击统计
                $cacheKey = 'click:rent:'.$rent[0].':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_housestickstatus';
                $timeKey  = 'clickTime:rent:'.$rent[0].':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_housestickstatus';
            }else if($sty == 'houseputstatus'){  // 房源定投点击统计
                $cacheKey = 'click:rent:'.$rent[0].':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_houseputstatus';
                $timeKey  = 'clickTime:rent:'.$rent[0].':'.$rentByEs['houseType1'].':'.$rentByEs['uid'].':market_houseputstatus';
            }
            $this->redisCache($cacheKey,$timeKey,$clickCount);
        }
        
    }

    // 从房源索引取一些数据
    public function getSaerchByhouseIds($houseId,$type){
        if($type == 'sale'){
            $search = new Search('hs');
        }
        if($type == 'rent'){
            $search = new Search('hr');
        }
        $houseInfo = $search->searchHouseById($houseId);
        if($houseInfo->found){
            return [
                'uid' => $houseInfo->_source->uid,
                'houseType1' => $houseInfo->_source->houseType1,
            ];
        }else{
            return '';
        }
        
    }
    
    public function redisCache($cacheKey,$timeKey,$count){  
        if(Redis::exists($cacheKey)){
            Redis::incr($cacheKey);
            if(Redis::get($cacheKey) >= $count){ 
                $this->dispatch(new HouseStatistic($cacheKey, Redis::get($cacheKey)));
                Redis::del($cacheKey);
                Redis::del($timeKey);
            }else if(time()-Redis::get($timeKey) > 5*60){
                $this->dispatch(new HouseStatistic($cacheKey, Redis::get($cacheKey)));
                Redis::del($cacheKey);
                Redis::del($timeKey);
            }           
        }else{
            Redis::set($cacheKey,1);
            Redis::set($timeKey,time());
        }
    }


}