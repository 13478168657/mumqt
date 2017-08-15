<?php
namespace App\Dao\AlarmMessage;
use DB;

/**
 * 警报信息管理
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年3月11日 下午4:09:05
 * @version 1.0
 */
class AlarmMessageDao{
	/** 
	 * 插入警报信息
	 * @param	array	$data	待插入信息
	 * @return	bool
	 */
	public function insertAlarm($data = []){
		return DB::connection('mysql_user')->table('alarmmessage')->insert($data); 
	}
}
