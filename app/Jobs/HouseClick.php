<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\HouseSaleOldClickLog;
use App\HouseRentOldClickLog;
use App\HouseSaleNewClickLog;
use App\Services\Search;
class HouseClick extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;


    /**
     * Create a new job instance.
     *$key
     * @return void
     */
    protected  $key;
    protected  $click;
    public function __construct($key,$clickCount)
    {
        $this->key=$key;
        $this->click=$clickCount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->houseClickLogObj($this->key,$this->click);

    }

    //根据key返回对象
    function houseClickLogObj($key,$clickCount)
    {
        $forTime=time();
        $patterms=explode(':', $key);
        $itemObj='';
        if ($patterms[4]=='sale') {
            $search = new Search('hs');
            $data = $search->searchHouseById($patterms[1]);
            $brokerId = (!empty($data->found)) ? $data->_source->uid : 0;
            $houseType1 = (!empty($data->found)) ? $data->_source->houseType1 : 0;
            $itemObj=new HouseSaleOldClickLog();
        }elseif ($patterms[4]=='rent') {
            $search = new Search('hr');
            $data = $search->searchHouseById($patterms[1]);
            $brokerId = (!empty($data->found)) ? $data->_source->uid : 0;
            $houseType1 = (!empty($data->found)) ? $data->_source->houseType1 : 0;
            $itemObj=new HouseRentOldClickLog();
        }elseif ($patterms[4]=='communityEsf') {
             $itemObj=new HouseSaleOldClickLog();
        }elseif ($patterms[4]=='communityXinf') {
             $itemObj=new HouseSaleNewClickLog();
        }
        $result=$itemObj->where('hId',$patterms[1])
        ->where('uId',$patterms[3])
        ->where('dateInt',Date('Ymd',$forTime))
        ->where('cId',$patterms[2])
        ->first();
        if (count($result)==0) {
            $itemObj->hId=$patterms[1];
            $itemObj->cId=$patterms[2];
            if($patterms[4]=='sale' || $patterms[4]=='rent'){
                $itemObj->brokerId = $brokerId;
                $itemObj->houseType1 = $houseType1;
            }
            $itemObj->uId=$patterms[3];
            $itemObj->clickCount=$clickCount;
            $itemObj->dateInt=Date('Ymd',$forTime);
            $itemObj->weekInt=Date('YW',$forTime);
            $itemObj->monthInt=Date('Ym',$forTime);
            $itemObj->save();
            //return $itemObj;
        }else
        {
            $result->clickCount=intval($result->clickCount)+$clickCount;
            $result->save();
            //return $result;
        }
        


    }
}
