<?php

namespace App\Http\Middleware\Perm;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\PermUtil;
use Illuminate\Http\Request;
class test{
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
    	$permFuncId = 4;		//权限功能（路由）id，主要根据该id判断权限
    	$is_check = PermUtil::checkPermFunc($permFuncId);
    	if($is_check == true){
    		return $next($request);
    	}
    }
}
