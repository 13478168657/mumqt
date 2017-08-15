<?php
namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Utils\CookieUtil;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Redirect;
use Cache;
use Cookie;

class CookieCity{

	public function handle($request, Closure $next){
		$host_arr = explode('.', $request->server()['HTTP_HOST']);
		$py = $host_arr[0];//子域名
		//$redisObj = new RedisCacheUtil;
		$city = RedisCacheUtil::getCityDataByPy($py);//redis中的城市数据
		$current_url = config('session.domain') . explode('?', $request->server()['REQUEST_URI'])[0];
		$GLOBALS['current_listurl'] = $current_url;
		$cookie_py = (Cookie::has('citypy')) ? Cookie::get('citypy') : '';//cookie中的子域名
// 		dd($city);
// 		$city = CookieUtil::getCityByPy($py);
// 		dd($city);
		$domain_ex=explode('.', config('session.domain'));// $py == $domain_ex[0]|| $py == $domain_ex[0]
		if($py == 'www' || empty($city) || $py == $domain_ex[0]){	//子域名为www或者通过子域名找不到城市数据
			if(empty($cookie_py)){
//				define('CURRENT_CITYPY', '');
//				define('CURRENT_CITYNAME', '北京');
//				define('CURRENT_CITYID', 0);
//				define('CURRENT_URL', '');
//	    		return $next($request);
                            $ip=$_SERVER['REMOTE_ADDR'];//'202.198.16.3';//
                            $api='http://api.map.baidu.com/location/ip?ak=F454f8a5efe5e577997931cc01de3974&ip='.$ip;
                            $json=@file_get_contents($api);
                            $result=json_decode($json,true);
                            if($result['status'] == 0){
                                $fullname=$result['content']['address_detail']['city'];
                                $cityname=join("",array_slice(preg_split("//u",$fullname,"-1",PREG_SPLIT_NO_EMPTY),0,mb_strrpos($fullname,'市')));
                                $city=RedisCacheUtil::getCityDataByName($cityname);
                                if($city == false){
                                    $city=RedisCacheUtil::getCityDataByName('北京');
                                }
                            }else{
                                $city=RedisCacheUtil::getCityDataByName('北京');
                            }
                            
                            //dd($city);
                            //dd($cityInfo);
                            define('CURRENT_CITYPY', $city->py);
                            define('CURRENT_CITYNAME', $city->name);
                            define('CURRENT_CITYID', $city->id);
                            define('CURRENT_LNG', $city->longitude);
                            define('CURRENT_LAT', $city->latitude);
                            define('CURRENT_URL', $current_url);
                            
                            CookieUtil::SaveCookie("cityid", $city->id);
                            CookieUtil::SaveCookie("city", $city);
                            CookieUtil::SaveCookie("citypy", $city->py);

                            return Redirect::to('http://'.$city->py.'.'.$current_url);
                                
			}else{
                            return Redirect::to('http://'.$cookie_py.'.'.$current_url);
			}
		}else{
			define('CURRENT_CITYPY', $city->py);
			define('CURRENT_CITYNAME', $city->name);
			define('CURRENT_CITYID', $city->id);
			define('CURRENT_LNG', $city->longitude);
			define('CURRENT_LAT', $city->latitude);
			define('CURRENT_URL', $current_url);
			if($cookie_py == $city->py){
				return $next($request);
			}else{
				CookieUtil::SaveCookie("cityid", $city->id);
				CookieUtil::SaveCookie("city", $city);
				CookieUtil::SaveCookie("citypy", $city->py);

				//return Redirect::to('http://'.$city->py.'.'.$current_url);
                                return $next($request);
			}
		}
	}


	/* public function handle($request, Closure $next){



		$py = explode('.', $request->server()['HTTP_HOST']);
		$py = $py[0];
    	// $py = str_replace('.'.config('session.domain'), '', $request->server()['HTTP_HOST']);
    	// dd($py);
		$current_url = config('session.domain') . explode('?', $request->server()['REQUEST_URI'])[0];
		$GLOBALS['current_listurl'] = $current_url;



    	if($py == 'www'){
    		if(!Cookie::has("citypy") ){
	    		// 如果cookie中没有找到城市信息
	    		define('CURRENT_CITYPY', '');
				define('CURRENT_CITYNAME', '北京');
				define('CURRENT_CITYID', 0);
				define('CURRENT_URL', '');
	    		return $next($request);
	    	}
	    	$py = Cookie::get('citypy');
	    	return Redirect::to('http://'.$py.'.' . $current_url);
	    }



		// 根据拼音简拼 查询到相关的信息
		$city = CookieUtil::getCityByPy($py);
		// dd($city);
		if(!$city){
			// 如果查不到结果
			// return Redirect::to('http://bj.' . config('session.domain') . $request->server()['REQUEST_URI']);
			define('CURRENT_CITYPY', '');
			define('CURRENT_CITYNAME', '北京');
			define('CURRENT_CITYID', 0);
			define('CURRENT_URL', '');

		}else{
			// 将当前选中的城市信息保存至cookie
			CookieUtil::SaveCookie("cityid", $city->id);
			CookieUtil::SaveCookie("city", $city);
			CookieUtil::SaveCookie("citypy", $py);

			define('CURRENT_CITYPY', $py);
			define('CURRENT_CITYNAME', $city->name);
			define('CURRENT_CITYID', $city->id);
			define('CURRENT_LNG', $city->longitude);
			define('CURRENT_LAT', $city->latitude);
			define('CURRENT_URL', $current_url);
		}

        return $next($request);
    } */


    protected function on_City_Convert( $request ){
    	$py = str_replace('.'.config('session.domain'), '', $request->server()['HTTP_HOST']);
    	// dd($py);
    	if($py == 'www'){
    		if(Cookie::has("current_citypy") ){
	    		$py = Cookie::get('current_citypy');
	    	}
    	}else{
    		// 根据拼音简拼 查询到相关的信息
			$city = CookieUtil::getCityByPy($py);
			// dd($city);
			// 如果查不到结果 ，就默认为北京
			if(!$city) return  false;
			CookieUtil::setCookieWithCity($city->name);
			CookieUtil::setCookieWithCityId($city->id);


			define('CURRENT_CITYPY', $py);
			define('CURRENT_CITYNAME', $city->name);
			define('CURRENT_CITYID', $city->id);
		}
    	return true;
    }


    protected function off_City_Convert(){
    	define('CURRENT_CITYPY', 'bj');
		define('CURRENT_CITYNAME', '北京');
		define('CURRENT_CITYID', '1');
	}
}

