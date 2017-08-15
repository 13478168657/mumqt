<?php
namespace App\Http\Middleware;
use Closure;
use Cache;
use Session;
class SessionShare{

	/**
	* session共享中间件
	*/
    public function handle($request, Closure $next){
    	
    	/*
  		 现在的cache用的是memcache引擎，可以将session放在memcache里进行共享，key 的prefix为 'laravel:'
    	*/
        Session::put('key','12312312312312313123');
        return $next($request);
    }
}

