<?php
namespace App\Http\Controllers\Utils;
use Auth;
use Cache;
use Session;
use App\Dao\Perm\PermDao;

/**
 * 用户权限
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年11月16日 下午7:22:42
 * @version 1.0
 */
class PermUtil{
    /**
     * 验证当前角色是否有权限显示对应字段
     * @param	int	$rId	角色id
     * @param	int	$pmId	权限字段id
     * @return	bool	$is_check	返回是否拥有权限
     */
    public static function checkPermField($pmId, $rId = ''){
    	if(empty($rId)){
    		$permFieldByRid = Session::get('user.permFieldByRid');
    	}
    	if(empty($permFieldByRid) || is_null($permFieldByRid)){
    		return false;
    	}
     	$is_check = in_array($pmId, $permFieldByRid);
     	return $is_check;
    }
    
    /**
     * 验证当前角色是否有权限访问对应路径
     * @param	int		$permFuncId		权限功能（路由）id，主要根据该id判断权限
     * @return	bool					返回是否拥有权限
     */
    public static function checkPermFunc($permFuncId){
    	if(!Cache::has('allPermFuncByRid') || !Cache::has('allPermFieldByRid')){//验证权限缓存是否存在
    		self::resetPerm();//重置权限缓存
    	}
    	//验证session权限数据是否存在
    	if(!Session::has('user.permFieldByRid') || empty(Session::get('user.permFieldByRid')) || !Session::has('user.permFuncByRid') || empty(Session::get('user.permFuncByRid') || !Session::has('user.rId') || is_null(Session::get('user.rId')) || !Session::has('allPermFunc'))){
    		self::pushUserPerm();
    	}
    	$rId = Session::get('user.rId');	//角色id
    	$permFuncByRid = Session::get('user.permFuncByRid');
    	$allPermFunc = Session::get('allPermFunc');
    	if(in_array($permFuncId, $allPermFunc)){
    		if(empty($permFuncByRid)){
    			self::return_error(2);	//提示权限错误
    		}else{
    			if(!in_array($permFuncId, $permFuncByRid)){
    				self::return_error(1);	//提示权限错误
    			}else{
    				return true;
    			}
    		}
    	}else{
    		self::return_error(3);	//提示权限错误
    	}
    }

    /**
     * 获取角色拥有数据权限
     * @param	string	$table		角色关联数据表名
     * @param	int		$rId		角色id
     * @return	object				搜索数据对象
     */
    public static function getPermValueByRid($table, $rId = ''){
    	if(!empty($table) && !is_null($rId) && !empty($rId)){
    		switch ($table){
    			case 'city':
    				$table_name = 'sofang20_house.city';
    				$relation_table_name = 'sofang20_user.role2city';
    				$relation_id = 'cityId';
    		}
    		$permDao = new PermDao();
    		$object = $permDao->getPermValueByRid($table_name, $relation_table_name, $relation_id, $rId);
    		return $object;
    	}else{
    		return false;
    	}
    }
    
    /**
     * 给用户注入权限数据
     */
    public static function pushUserPerm(){
    	if(Auth::check()){
    		$rId = Auth::user()->rId;
    	}else{
    		$rId = 0;
    	}
    	$allPermFieldByRid = Cache::get('allPermFieldByRid');
    	if(isset($allPermFieldByRid[$rId])){
    		$permFieldByRid = $allPermFieldByRid[$rId];
    	}else{
    		$permFieldByRid = array();
    	}
    	$allPermFuncByRid = Cache::get('allPermFuncByRid');
    	if(isset($allPermFuncByRid[$rId])){
    		$PermFuncByRid = $allPermFuncByRid[$rId];
    	}else{
    		$PermFuncByRid = array();
    	}
    	$allPermFunc = Cache::get('allPermFunc');
    	if(!isset($allPermFunc)){
    		$allPermFunc = array();
    	}
//     	Session::forget('user');
     	Session::put('user.permFieldByRid', $permFieldByRid);
     	Session::put('user.permFuncByRid', $PermFuncByRid);
     	Session::put('allPermFunc', $allPermFunc);
     	Session::put('user.rId', $rId);
    }
    
    /**
     * 重置权限缓存
     */
    public static function resetPerm(){
    	$permDao = new PermDao();
    	$allPerm = $permDao->allPerm();
    	self::pushUserPerm();
//     	return redirect(Session::get('lastUrl'));
    }
    
    /**
     * 提示无权限
     */
    public static function return_error($messageId = 1){
    	switch ($messageId){
    		case 1:
    			dd('当前用户角色没有访问该页面权限');	//当前用户角色或为游客，或未配置任何页面访问权限
    		case 2:
    			dd('当前用户角色没有任何访问权限');		//用户无权限访问该页面
    		case 3:
    			dd('当前访问页面没有对应数据');		//数据库perm_function表没有对应数据
    	}
    }
}
