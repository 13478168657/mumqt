<?php

namespace App\Commands;

use App\Commands\Command;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Cache;

/**
 * 用户点击记录（队列执行）
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年1月20日 上午10:56:12
 * @version 1.0
 */
class ClickQueue extends Command implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
	public $tableType;
	public $hId;
	public $cId;
	public $uId;
	public $per;	//每次队列积累固定条数统一执行
    /**
     * @param	string	$tableType	点击记录存入表名：houserentoldclicklog、housesalenewclicklog、housesaleoldclicklog
	 * @param	int		$hId		房源id
	 * @param	int		$cId		楼盘id
	 * @param	int		$uId		操作点击用户id
     */
    public function __construct($tableType, $hId, $cId, $uId)
    {
        //
        $this->tableType = $tableType;
        $this->hId = $hId;
        $this->cId = $cId;
        $this->uId = $uId;
        
        $this->per = 5000;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
//     	Cache::forget('houserentoldclicklog');
    	if(in_array($this->tableType, array('houserentoldclicklog', 'housesalenewclicklog', 'housesaleoldclicklog'))){
    		$dateInt = date('Ymd', time());
    		$weekInt = date('YW', time());
    		$monthInt = date('Ym', time());
    		if(!Cache::has('clicklogCount') || Cache::get('clicklogCount') == null){		//点击记录数据队列缓存累计数量
    			Cache::forever('clicklogCount', 0);
    		}
    		Cache::forever('clicklogCount', Cache::get('clicklogCount')+1);
    		$houseclicklog = ['hId'=>$this->hId, 'cId'=>$this->cId, 'uId'=>$this->uId, 'dateInt'=>$dateInt, 'weekInt'=>$weekInt, 'monthInt'=>$monthInt];
    		$key = $houseclicklog['hId']."_".$houseclicklog['cId']."_".$houseclicklog['uId']."_".$houseclicklog['dateInt'];
    		if(Cache::has($this->tableType)){						//存在
    			$houseclicklog_arr = Cache::get($this->tableType);
    			if(isset($houseclicklog_arr[$key])){
    				$houseclicklog_arr[$key]['clickCount']++;
    			}else{
    				$houseclicklog['clickCount'] = 1;
    				$houseclicklog_arr[$key] = $houseclicklog;
    			}
    			Cache::forever($this->tableType, $houseclicklog_arr);
//     			dd(Cache::get($this->tableType));
// 				dd(Cache::get('clicklogCount'));
    			if(Cache::get('clicklogCount') >= $this->per){		//若达到上限阀值，统一处理存入数据库
    				Cache::forever('clicklogCount', 0);				//队列计数清零
    				self::houseClickRecord();						//统一处理房源点击录入数据库
    			}
    		}else{													//不存在
    			$houseclicklog['clickCount'] = 1;
    			Cache::forever($this->tableType, array($key=>$houseclicklog));
//     			dd(Cache::get($this->tableType));
    		}
    	}
    	
    	
    	
    	
        //
        /* $houserentoldclicklog = ['hId'=>1, 'cId'=>1, 'uId'=>1, 'time'=>20160119];
        if(Cache::has('houserentoldclicklog')){
        	$houserentoldclicklog_arr = Cache::get('houserentoldclicklog');
        	$houserentoldclicklog_arr[] = $houserentoldclicklog;
        	if(count($houserentoldclicklog_arr) >= 10){
        		$sql = "INSERT INTO houserentoldclicklog (hId, cId, uId, time) VALUES ";
        		$i = 0;
        		foreach($houserentoldclicklog_arr as $v){
        			if($i != 0){
        				$sql .= ",";
        			}
        			$sql .= "({$v['hId']}, {$v['cId']}, {$v['uId']}, {$v['time']})";
        			$i++;
        		}
        		Cache::forget('houserentoldclicklog');
        		DB::connection('mysql_statistics')->insert($sql);
        	}else{
        		Cache::forever('houserentoldclicklog', $houserentoldclicklog_arr);
        	}
        }else{
        	Cache::forever('houserentoldclicklog', array($houserentoldclicklog));
        } */
    	
//         DB::connection('mysql_statistics')->table('houserentoldclicklog')->insert(['cId'=>1]);
    }
    
    /**
     * 统一处理房源点击录入数据库
     */
    public function houseClickRecord(){
    	$tableType_arr = array('houserentoldclicklog', 'housesalenewclicklog', 'housesaleoldclicklog');
    	foreach($tableType_arr as $tableType){
//     		dd(Cache::get($tableType));
    		if(Cache::has($tableType)){
    			$houseclicklog_arr = Cache::pull($tableType);
    			foreach($houseclicklog_arr as $record_key=>$record_val){
    				
    				$houseClickRecordDao = new \App\Dao\ClickRecord\ClickRecordDao;
    				$result = $houseClickRecordDao->houseClickRecord($record_val, $tableType);		//点击数据写入
    				if($result == false){			//写入失败时，数据放回缓存
						if(Cache::has($tableType)){
							$houseclicklog_arr_temp = Cache::get($tableType);
						}else{
							if(isset($houseclicklog_arr_temp[$record_key])){
								$houseclicklog_arr_temp[$record_key]['clickCount'] = $houseclicklog_arr_temp[$record_key]['clickCount'] + $record_val['clickCount'];
							}else{
								$houseclicklog_arr_temp[$record_key] = $record_val;
							}
						}
						Cache::forever($tableType, $houseclicklog_arr_temp);
    				}
    				
    				/* 房源每天点击量记录表 */
    				/* if($tableType == 'houserentoldclicklog'){
    					$tableType2 = 'houserentday2';
    				}elseif($tableType == 'housesalenewclicklog'){
    					$tableType2 = 'housesaleday';
    				}elseif($tableType == 'housesaleoldclicklog'){
    					$tableType2 = 'housesaleday2';
    				}
    				$result = $houseClickRecordDao->houseClickRecord2($record_val, $tableType2);		//点击数据写入
    				if($result == false){			//写入失败时，数据放回缓存
    					
    				} */
    			}
    		}
    	}
    }
}
