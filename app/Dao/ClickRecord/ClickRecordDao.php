<?php
namespace App\Dao\ClickRecord;
use DB;
/**
 * 用户点击记录
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年1月20日 下午12:12:45
 * @version 1.0
 */
class ClickRecordDao {
    /**
     * 用户点击房源记录
     * @param	array	$record		待录入数据
     * @param	string	$tableName	待录入表名
     * @return	bool
     */
    function houseClickRecord($record, $tableName){
    	$result = true;
    	DB::transaction(function() use($record, $tableName, &$result){
	    	if($tableName == 'houserentoldclicklog'){
	    		$tableName2 = 'houserentday2';
	    	}elseif($tableName == 'housesalenewclicklog'){
	    		$tableName2 = 'housesaleday';
	    	}elseif($tableName == 'housesaleoldclicklog'){
	    		$tableName2 = 'housesaleday2';
	    	}
	    	/* 用户点击房源记录表 （'houserentoldclicklog', 'housesalenewclicklog', 'housesaleoldclicklog'三个表）*/
	    	$dataObj = DB::connection('mysql_statistics')->table($tableName)
	    		->where('hId', $record['hId'])->where('cId', $record['cId'])->where('uId', $record['uId'])->where('dateInt', $record['dateInt'])->first();
	    	if(is_null($dataObj)){			//insert
	    		$result = DB::connection('mysql_statistics')->table($tableName)
	    			->insert([
	    					'hId'=>$record['hId'], 
	    					'cId'=>$record['cId'], 
	    					'uId'=>$record['uId'], 
	    					'clickCount'=>$record['clickCount'], 
	    					'dateInt'=>$record['dateInt'], 
	    					'weekInt'=>$record['weekInt'], 
	    					'monthInt'=>$record['monthInt']
	    			]);
	    	}else{							//update
	    		$result = DB::connection('mysql_statistics')->table($tableName)->where('id', $dataObj->id)
	    			->update(['clickCount'=>$dataObj->clickCount + $record['clickCount']]);
	    	}
	    	if($result == false){
	    		DB::rollback();
	    	}
	    	/* 房源每天点击量记录表 （'houserentday2','housesaleday','housesaleday2'三个表）*/
	    	$dataObj = DB::connection('mysql_statistics')->table($tableName2)->where('hid', $record['hId'])->where('dayInt', $record['dateInt'])->first();
	    	if(is_null($dataObj)){			//insert
	    		$result = DB::connection('mysql_statistics')->table($tableName2)
	    			->insert([
    					'hid'=>$record['hId'],
    					'clickCount'=>$record['clickCount'],
    					'dayInt'=>$record['dateInt']
	    			]);
	    	}else{							//update
	    		$result = DB::connection('mysql_statistics')->table($tableName2)->where('hid', $record['hId'])->where('dayInt', $record['dateInt'])
	    			->update(['clickCount'=>$dataObj->clickCount + $record['clickCount']]);
	    	}
    	});
    	return $result;
    }
    
    /**
     * 房源每天点击量统计
     */
    public function houseClickRecord2($record, $tableName){
    	$dataObj = DB::connection('mysql_statistics')->table($tableName)
    		->where('hid', $record['hId'])->where('dayInt', $record['dateInt'])->first();
    	if(is_null($dataObj)){			//insert
    		$result = DB::connection('mysql_statistics')->table($tableName)
    			->insert([
    					'hid'=>$record['hId'],
    					'clickCount'=>$record['clickCount'],
    					'dayInt'=>$record['dateInt']
    			]);
    	}else{							//update
    		$result = DB::connection('mysql_statistics')->table($tableName)->where('hid', $record['hId'])->where('dayInt', $record['dateInt'])
    			->update(['clickCount'=>$dataObj->clickCount + $record['clickCount']]);
    	}
    	return $result;
    }
}
