<?php
namespace App\Dao\City;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展

/**
* description of CityDao 省份、城市、地区查询数据访问对象
* @since 1.0
* @author lixiyu
*/
class CityDao{

	/**
	* 获取 城区
	* @since 1.0
	* @author lixiyu
	* @param string $id
	* @return array 返回根据 输入的id而得到的地区名和相关id 
	*/
	public function selectCityArea($id){
            $key='DB_mysql_house_selectCityArea'.'_'.$id;
            $config=config('redistime.brokerListOuttime');
            Redis::connect(config('database.redis.default.host'), 6379);
            Redis::select($config['library']);  // 选择8号库 
            if(Redis::exists($key)){
                $cityArea=unserialize(Redis::get($key));
            }else{
                $cityArea = DB::connection('mysql_house')->Select('select id, name,cityId,longitude,latitude from cityarea where cityId = ? or linkCityId= ?', array($id,$id));
                if(!empty($cityArea)){
                    Redis::set($key,serialize($cityArea));
                    Redis::expire($key,$config['outtime']);
                }

            }
            return $cityArea;
	}

	/**
	 * 根据区域id获取区域名称
	 * @param $id
	 * @return mixed
	 */
	public function getCityAreaById($id){
		$cityArea = DB::connection('mysql_house')->Select('select * from cityarea where id = ?', array($id));
		return $cityArea;
	}

	/**
	 * 根据商圈id获取商圈名称
	 * @param $id
	 * @return mixed
	 */
	public function getBusinessareaAreaById($id){
		$cityArea = DB::connection('mysql_house')->Select('select * from businessarea where id = ?', array($id));
		return $cityArea;
	}

	/**
	 * 根据城区名称获取城区信息
	 *
	 * @param $name 城区名称
	 * @return mixed 城区信息
	 * @author johnyoung
	 */
	public function getCityAreaByName($name){
		$key = 'cityarea_name_' . $name;
		if (!Cache::has($key)) {
			$result = DB::connection('mysql_house')->table('cityarea')->where('name', $name)->where('cityId', CURRENT_CITYID)->first();
			Cache::put($key, $result, 60 * 72);
		} else {
			$result = Cache::get($key);
		}
		return $result;
	}
	/**
	 * 根据商圈名称获取商圈信息
	 *
	 * @param $name 城区名称
	 * @return mixed 城区信息
	 * @author johnyoung
	 */
	public function getBusinessareaAreaByName($name){
		$key = 'businessarea_name_' . $name;
		if (!Cache::has($key)) {
			$result = DB::connection('mysql_house')->table('businessarea')->where('name', $name)->where('cityId', CURRENT_CITYID)->first();
			Cache::put($key, $result, 60 * 72);
		} else {
			$result = Cache::get($key);
		}
		return $result;
	}

	/**
	* 获取 城市
	* @since 1.0
	* @author lixiyu
	* @param string $id
	* @return array 返回根据 输入的id而得到的地区名和相关id 
	*/
	public function selectCity($id){
		$city = DB::connection('mysql_house')->Select('select id, name,longitude,latitude from city where provinceId = ?', array($id));
		return $city;
	}

	/**
	 * 获取 城市
	 * @since 1.0
	 * @author lixiyu
	 * @param string $id
	 * @return array 返回根据 输入的id而得到的地区名和相关id
	 */
	public function selectCity2($id){
		$city = DB::connection('mysql_house')->Select('select id, name,longitude,latitude from city where id = ?', array($id));
		return $city;
	}

	/**
	* 获取省份
	* @since 1.0
	* @author lixiyu
	* @param string $id
	* @return array 返回根据 输入的id而得到的地区名和相关id 
	*/
	public function selectProvince(){
		$province = DB::connection('mysql_house')->Select('select id, name from province');
		return $province;
	}

	/**
	* 获取 城区下子区域
	* @since 1.0
	* @param string $id
	* @return array 返回根据 输入的id而得到的子区域名和相关id 
	*/
	public function selectBusinessArea($id){
            $key='DB_mysql_house_selectBusinessArea_'.$id;
            $config=config('redistime.brokerListOuttime');
            Redis::connect(config('database.redis.default.host'), 6379);
            Redis::select($config['library']);  // 选择8号库 
            if(Redis::exists($key)){
                $BusinessArea=unserialize(Redis::get($key));
            }else{
		$BusinessArea = DB::connection('mysql_house')->Select('select id,name,cityAreaId,pinyin,longitude,latitude from businessarea where cityAreaId = ? order by pinyin', array($id));
                if(!empty($BusinessArea)){
                    Redis::set($key,serialize($BusinessArea));
                    Redis::expire($key,$config['outtime']);
                }

            }
            return $BusinessArea;
	}

	/**
	 * 获取城区并按照rank字段倒序排列
	 * @param $id 城区id
	 * @return mixed
	 */
	public function xselectCityArea($id){
		$cityArea = DB::connection('mysql_house')->Select('select id, name,cityId,rank,longitude,latitude from cityarea where (cityId = ? or linkCityId= ?) and rank <> 0 order by rank desc', array($id,$id));
		return $cityArea;
	}
	/**
	* 获取 商圈名称
	* @since 1.0
	* @author cjr
	* @param string $id
	* @return array 返回根据 输入的id而得到的商圈名称
	*/
	public function findBusiness($id){
		$BusinessArea = DB::connection('mysql_house')->table('businessarea')->select('name')->find($id);
		return $BusinessArea;
	}

	/**
	 * 获取 城区名称
	 * @since 1.0
	 * @author cjr
	 * @param string $id
	 * @return array 返回根据 输入的id而得到的城区名称
	 */
	public function findCityArea($id){
		$cityArea = DB::connection('mysql_house')->table('cityarea')->select('name')->find($id);
		return $cityArea;
	}

	/**
	 * 获取 城市下子区域
	 * @since 1.0
	 * @author xcy
	 * @param string $id
	 * @return array 返回根据 输入的id而得到的子区域名和相关id
	 */
	public function selectBusinessCityArea($id){
		$BusinessArea = DB::connection('mysql_house')->Select('select id, name,pinyin,cityAreaId from businessarea where cityId = ? or linkCityId= ?', array($id,$id));
		return $BusinessArea;
	}
	/**
	 * 获取 城市全部地铁
	 */
	public function selectSubWayAll(){
		$SubWay = DB::connection('mysql_house')->Select('select id,name from subwayline');
		return $SubWay;
	}
	/**
	 * 获取 城市全部地铁站点
	 */
	public function selectSubWayStationAll(){
		$SubWay = DB::connection('mysql_house')->Select('select id,name from subwaystation');
		return $SubWay;
	}
	/**
	* 获取 城市地铁
	* @since 1.0
	* @author xcy
	* @param string $id
	* @return array 返回根据 输入的id而得到的地铁名和相关id 
	*/
	public function selectSubWay($id){
		$SubWay = DB::connection('mysql_house')->Select('select id,name,centerLng,centerLat,centerLevel from subwayline where cityId = ?', array($id));
		return $SubWay;
	}

	/**
	* 获取 城市地铁站点
	* @since 1.0
	* @author xcy
	* @param string $cityId 城市id
	* @param string $lineId 地铁id
	* @return array 返回根据 输入的$cityId,$lineId而得到的地铁站点名和相关id 
	*/
	public function selectSubWayStation($where){
		$SubWayStation = DB::connection('mysql_house')->table('subwaystation')->select('id','name','lineId','longitude','latitude')->where($where)->orderBy('id','asc')->get();
		return $SubWayStation;
	}

	/**
	* 获取 城市商圈
	* @since 1.0
	* @author xcy
	* @param string $id
	* @return array 返回根据 输入的id而得到的相关商圈 
	*/
	public function selectBusinessTag($id){
		$BusinessTag = DB::connection('mysql_house')->Select('select id,cityId,name from businesstags where cityId = ?', array($id));
		return $BusinessTag;
	}


	//当搜索为线路时
	public function getBusline($cityId,$name){
		$bus = DB::connection('mysql_house')->Select('select id,cityId,name from busline where cityId = ? and name like ?  limit 1', array($cityId,$name.'%'));
		return $bus;
	}

	public function getBusstation($cityId,$lineId){
		$bus = DB::connection('mysql_house')->Select('select id,cityId,lineId,lineName,name from busstation where cityId = ? and lineId=?', array($cityId,$lineId));
		return $bus;
	}


	//当搜索为站点时
	public function getBus($cityId,$name){
		$bus = DB::connection('mysql_house')->Select('select id,cityId,lineId,lineName,name from busstation where cityId = ? and name=?', array($cityId,$name));
		return $bus;
	}

	public function getBus1($cityId,$lineId){
		$bus = DB::connection('mysql_house')->Select('select id,cityId,lineId,lineName,name from busstation where cityId = ? and lineId=?', array($cityId,$lineId));
		return $bus;
	}

        // 查询省份表
	public function getAllProvince($arrId){
		return  DB::connection('mysql_house')->table('province')->whereNotIn('id',$arrId)->orderBy('pinyin','ASC')->get(['id','name','pinyin']);
	}

	// 查询城市表
	public function getAllCitys(){
		return DB::connection('mysql_house')->table('city')->orderBy('pinyin','ASC')->get(['name','py','provinceId','pinyin']);
	}

	//  获得城市拼音
	public function getCityByProId($id){
		$city = DB::connection('mysql_house')->Select('select id, name, py from city where provinceId = ?', array($id));
		return $city;
	}
        
	// 根据名称或拼音查询城市的信息
	public function getCityInfo($field,$city){
		return DB::connection('mysql_house')->Select("select py,name from city where $field like '%$city%' limit 15");
	}

	/**
	 * 获取城区名称
	 * @param $id
	 * @return int
	 */
	public function getCityArea($id){
		if(!is_numeric($id)){
			return 2;
		}else{
			if( !Cache::get('cityAreaId_One'.$id)){
				$cityArea = $this->getCityAreaById($id);
				Cache::put('cityAreaId_One'.$id, $cityArea, 60 * 12*30);
			}else{
				$cityArea = Cache::get('cityAreaId_One'.$id);
			}
			//dd($cityArea);
			return $cityArea;
		}
	}

	/**
	 * 获取商圈名称
	 * @param $id
	 * @return int
	 */
	public function getBusinessArea($id){
		if(!is_numeric($id)){
			return 2;
		}else{
			if( !Cache::get('businessAreaId_One'.$id)){
				$businessArea = $this->getBusinessareaAreaById($id);
				Cache::put('businessAreaId_One'.$id, $businessArea, 60 * 12*30);
			}else{
				$businessArea = Cache::get('businessAreaId_One'.$id);
			}

			return $businessArea;
		}
	}

	/**
	 * 根据公司名称like查询公司信息
	 * @param $name
	 * @param $limit
	 * @return mixed
	 */
	public function getCompanyByName($name, $limit){
		return DB::table('company')->where('name','like','%'.$name.'%')->take($limit)->get(['id','name']);
	}
}