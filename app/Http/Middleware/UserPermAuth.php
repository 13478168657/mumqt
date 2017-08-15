<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Contracts\Routing\TerminableMiddleware;
use Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\PermUtil;
use Illuminate\Http\Request;
use Auth;
/**
 * 用户权限验证中间件
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年11月14日 上午10:44:27
 * @version 1.0
 */
class UserPermAuth implements TerminableMiddleware{
    /**
     * Handle an incoming request.
     * 用户所在角色权限认证中间件
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
    	return $next($request);
		/* global $ISCHECKMIDDLEWARE;
		dd($ISCHECKMIDDLEWARE);
		$ISCHECKMIDDLEWARE = true;    	 
    	if(!Cache::has('allPermUrlByRid') || !Cache::has('allPermFieldByRid')){//验证权限缓存是否存在
    		PermUtil::resetPerm();//重置权限缓存
    	}
		//验证session权限数据是否存在
		if(!Session::has('user.permFieldByRid') || empty(Session::get('user.permFieldByRid')) || !Session::has('user.permUrlByRid') || empty(Session::get('user.permUrlByRid') || !Session::has('user.rId') || empty(Session::get('user.rId')))){
			PermUtil::pushUserPerm();
		}
		$rId = Session::get('user.rId');	//角色id
    	$thisUrl = $_SERVER['REQUEST_URI'];	//当前地址（对应路由地址）
    	$parse = parse_url($thisUrl);
    	$thisUrl = $parse['path'];
// 		$thisQueryString = $request->query();
		$thisQueryString = Input::all();
     	if($rId > 0){	
     		$hasPermUrl = Cache::get('allPermUrlByRid');
     		$isset_url = self::isset_url($thisUrl, $thisQueryString, $hasPermUrl[$rId]);
     		if($isset_url==true){
     			return $next($request);
     		}else{
     			return self::redirect_error();
//      			return redirect('/');
     		}
     	}else{			//当前用户没有对应角色，不能访问当前地址
     		return self::redirect_error();
     	}
    	return $next($request); */
    }
    
    /**
     * 判断当前地址是否存在与目标地址集合
     * @param	string	$thisUrl	当前地址
     * @param	array	$thisQueryString	当前地址所有参数
     * @param	array	$url_arr	目标地址集合		
     * @return	bool	true存在、false不存在
     */
    /* public function isset_url($thisUrl, $thisQueryString, $url_arr){
    	foreach($url_arr as $url=>$item_arr){
    		if($thisUrl == $url){			//地址相同
    			foreach($item_arr as $thatQueryString){
    				$is_urlSame = true;			//flag，地址完全对应成功
    				foreach($thatQueryString as $item_key=>$item){
    					if(!isset($thisQueryString[$item_key]) || $thisQueryString[$item_key] != $item){		//若参数没能对应上，直接跳过
    						$is_urlSame = false;
    						break;
    					}
    				}
    				if($is_urlSame == true){		//若地址对应成功
    					return true;
    				}else{
    					continue;
    				}
    			}
    		}else{
    			continue;
    		}
    	}
    	return false;
    } */
    
    /**
     * 页面权限验证不通过，显示错误信息
     */
   /*  public function redirect_error(){
    	dd('当前角色权限不支持');
    	return redirect('/');
    } */
   /*  public function terminate($request, $response)
    {
    	global $ISCHECKMIDDLEWARE;
    	if(is_null($ISCHECKMIDDLEWARE)){
    		dd('请配置权限数据及中间件');
    	}else{
    		if($ISCHECKMIDDLEWARE!=true){
    			dd('请配置权限数据及中间件');
    		}else{
//     			return $next($request);
    		}
    	}
    	// Store the session data...
    } */
}
