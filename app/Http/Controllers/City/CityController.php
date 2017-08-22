<?php

namespace App\Http\Controllers\City;

use Auth;
use DB;
use App\Dao\City\CityDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\RedisCacheUtil;
/**
* Description of CityController （省份、城市、地区查询）
* @since 1.0
* @author lixiyu
*/
class CityController extends Controller{
	protected $CityDao;

	public function __construct(){
		$this->CityDao = new CityDao();
	}
	
	/**
	* ajax获取 城市
	* @since 1.0
	* @author lixiyu
	* @param string $id
	* @return array 返回根据 输入的id而得到的地区名和相关id 
	*/
	public function getCity(){
		$id = Input::get('id');
        $type = Input::get('type','');
		if(!is_numeric($id)){
			return 2;
		}else{
            if($type == 1){
                if( !Cache::get('cityList'.$id)){
                    $cityList = $this->CityDao->getCityByProId($id);
                    Cache::put('cityList'.$id, $cityList, 60 * 3);
                }else{
                        $cityList = Cache::get('cityList'.$id);
                }
                return json_encode($cityList);
            }
			if( !Cache::get('cityId'.$id)){
				$city = $this->CityDao->selectCity($id);
				Cache::put('cityId'.$id, $city, 60 * 3);
			}else{
				$city = Cache::get('cityId'.$id);
			}			
			return json_encode($city);
		}
                
	}

	/**
	* ajax获取 城区
	* @since 1.0
	* @author lixiyu
	* @param string $id
	* @return array 返回根据 输入的id而得到的地区名和相关id 
	*/
	public function getCityArea(){
		$id = Input::get('id');
		if(!is_numeric($id)){
			return 2;
		}else{
			if( !Cache::get('cityAreaId'.$id)){
				$cityArea = $this->CityDao->selectCityArea($id);
				Cache::put('cityAreaId'.$id, $cityArea, 60 * 12*30);
			}else{
				$cityArea = Cache::get('cityAreaId'.$id);
			}
			
			return json_encode($cityArea);
		}
	}

    public function getBusinessArea(){
        $id = Input::get('id');
        if(!is_numeric($id)){
            return 2;
        }else{
            if( !Cache::get('businessAreaId'.$id)){
                $businessArea = $this->CityDao->selectBusinessArea($id);
                Cache::put('businessAreaId'.$id, $businessArea, 60 * 12*30);
            }else{
                $businessArea = Cache::get('businessAreaId'.$id);
            }

            return json_encode($businessArea);
        }
    }
	/**
	* ajax获取 省份
	* @since 1.0
	* @author lixiyu
	* @return array 返回省份
	*/
	public function getProvince(){
		if( !Cache::get('province')){
			$province = $this->CityDao->selectProvince();
			Cache::put('province', $province, 60 * 3 );
		}else{
			$province = Cache::get('province');
		}
		return $province;
	}

    /**
     * ajax查询公司
     * @since 1.0
     * @author zhuwei
     * @return array
     */
    public function getCompany(){
        $name = trim(Input::get('name'));
        $limit = 5;
        $company = empty($name) ? [] : $this->CityDao->getCompanyByName($name, $limit);
        return json_encode($company);
    }
        
    /**
	*  更多城市
	*/
	public function citysList(){
		// 热门城市id
		$hotCityId = ['1','332','116','118','2','346','158','86','50','68','337','159','333','297','217','101'];
		$hotCitys = [];
		foreach ($hotCityId as $key => $hotId) {
			$hotCitys[$hotId] = RedisCacheUtil::getCityDataById($hotId);
		}
		//dd($hotCitys);
		$currentCity = RedisCacheUtil::getCityDataById(CURRENT_CITYID);
        if(!Cache::has('city_pro_list')){
            // 按省份排序
            $proOrder = $this->CityDao->getAllProvince([1,2,3,4]);
            // 以省份首字母为键值
            $proKeyPy = [];
            $qitaArr = [];// 香港  澳门  台湾
            foreach($proOrder as $pro){
                   $proZimu = substr($pro->pinyin,0,1);
                    if(in_array($pro->id,[31,32,33])){
                        $qitaArr[] = $pro;
                    }else{
                        $proKeyPy[$proZimu][] = $pro;
                    }

            }
            // 查询城市 排除直辖市[1,2,3,4]
            $citys = $this->CityDao->getAllCitys();
            $cityKeyProId = [];
            $cityPy = [];
            foreach($citys as $cty){
                    if( !in_array($cty->provinceId,[1,2,3,4]) ){
                            $cityKeyProId[] = $cty;
                    }
                    // 以城市首字母为键值
                    $zimu = strtoupper(substr($cty->pinyin,0,1));
                    $cityPy[$zimu][] = $cty;
            }
            $citysArr = ['proOrder'=>$proOrder,'proKeyPy'=>$proKeyPy,'qitaArr'=>$qitaArr,'cityKeyProId'=>$cityKeyProId,'cityPy'=>$cityPy];
            Cache::put('city_pro_list',$citysArr,24*60);
        }else{
            $arr = Cache::get('city_pro_list');
            $proOrder = $arr['proOrder'];
            $proKeyPy = $arr['proKeyPy'];
            $qitaArr = $arr['qitaArr'];
            $cityKeyProId = $arr['cityKeyProId'];
            $cityPy = $arr['cityPy'];
            //dd($proKeyPy);
        }
        //判断请求来自PC端还是移动端
        if(USER_AGENT_MOBILE)
        {
            return view('h5.index.citysList',compact('currentCity','hotCitys','proKeyPy','cityKeyProId','qitaArr','cityPy','proOrder'));
        }
        else{
            return view('index.citysList',compact('currentCity','hotCitys','proKeyPy','cityKeyProId','qitaArr','cityPy','proOrder'));
        }
	}
        
    /**
     * ajax 查询城市
     */
    public function citysName(){
        $city = Input::get('city');
        $field = '';
        if($city == ''){
            return 2;
        }
        $chinaPatt = "/^[\x{4e00}-\x{9fa5}]+$/u";
        $engPatt = "/^[A-Za-z]+$/";
        if(preg_match($chinaPatt,$city)){
            $field = 'name';
        }else if(preg_match($engPatt,$city)){
            $field = 'pinyin';
        }
        if(!$field) return 2;
        //$field = 'pinyin';
        if(Cache::has('search'.$city)){
            $info = Cache::get('search'.$city);
            return json_encode($info);
        }else{
            $cityInfo = $this->CityDao->getCityInfo($field,$city);
            if(!empty($cityInfo)){
                Cache::put('search'.$city,$cityInfo,3*60);
                return json_encode($cityInfo);
            }
            return 2;
        }
    }
        
}