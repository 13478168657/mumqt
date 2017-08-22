<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class HouseStatistic extends Job implements SelfHandling, ShouldQueue
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
        $this->HouseStatisticObj($this->key,$this->click);

    }

    //根据key返回对象
    function HouseStatisticObj($key,$clickCount)
    {
        $forTime=time();
        $patterms=explode(':', $key);
        $db = DB::connection('mysql_statistics')->table($patterms[5])
                ->where('hId',$patterms[2])
                ->where('uid',$patterms[4])
                ->where('houseType1',$patterms[3])
                ->where('saleRentType',$patterms[1])
                ->first();
        $data = [];
        if(empty($db)){
            if($patterms[0] == 'display'){  // 展示量
                $data['dispCount'] = $clickCount;
                //$data['clickCount'] = 0;
            }else if($patterms[0] == 'click'){  // 点击量
                $data['clickCount'] = $clickCount;
                //$data['dispCount'] = 0;
            }
            $data['saleRentType'] = $patterms[1];
            $data['hId']          = $patterms[2];
            $data['houseType1']   = $patterms[3];
            $data['uid']          = $patterms[4];
            $data['dateInt']      = Date('Ymd',$forTime);
            $data['weekInt']      = Date('YW',$forTime);
            $data['monthInt']      = Date('Ym',$forTime);
            DB::connection('mysql_statistics')->table($patterms[5])->insert($data);
        }else{
            if($patterms[0] == 'display'){  // 展示量
                $data['dispCount'] = intval($db->dispCount) + $clickCount;
            }else if($patterms[0] == 'click'){  // 点击量
                $data['clickCount'] = intval($db->clickCount) + $clickCount;
            }
            DB::connection('mysql_statistics')->table($patterms[5])->where('id',$db->id)->update($data);        
        }

    }
}
