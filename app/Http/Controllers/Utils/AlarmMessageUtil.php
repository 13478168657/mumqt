<?php
namespace App\Http\Controllers\Utils;
use App\Dao\AlarmMessage\AlarmMessageDao;
/**
 * 警报信息管理
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年3月11日 上午11:04:45
 * @version 1.0
 */
class AlarmMessageUtil{
	function __construct(){
		$this->AlarmMessageDao = new AlarmMessageDao();
	}
	/**
	 * 插入警报信息
	 * @param	array	$data	待插入信息
	 * @return	bool
	 */
	public function insertAlarm($data = []){
		return $this->AlarmMessageDao->insertAlarm($data);
	}
}