<?php
/**
 * 候选样板代码1
 * 需要确认\App\Commands\ClickQueue的引用方式
 * 注释中添加@return说明
 */

namespace App\Http\Controllers\Ajax;
use Illuminate\Routing\Controller;
use Queue;
// use App\Commands\ClickQueue;
/**
 * 异步实现功能
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年1月20日 上午10:19:40
 * @version 1.0
 */
class AjaxController extends Controller{
	/**
	 * 点击页面记录
	 * @param	bool	$is_call	是否调用：false不是，通过input::get获取数据；true是，通过传参获取数据。
	 * @param	string	$tableType	点击记录存入表名：houserentoldclicklog、housesalenewclicklog、housesaleoldclicklog
	 * @param	int		$hId		房源id
	 * @param	int		$cId		楼盘id
	 * @param	int		$uId		操作点击用户id
	 */
	public function clickRecord($is_call = false, $tableType='', $hId=0, $cId=0, $uId=0){
		if($is_call == false){
			$tableType = Input::get('tableType');
			$hId = Input::get('hId');
			$cId = Input::get('cId');
			$uId = Input::get('uId');
		}
		Queue::push(new \App\Commands\ClickQueue($tableType, $hId, $cId, $uId));
		return true;
	}
}