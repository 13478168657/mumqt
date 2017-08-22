<?php

namespace App\Http\Controllers\Map;

use App\City;
use App\ListPutView;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Search\SearchController;
use App\Dao\Map\MapDao;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
/**
 * Description of MapController
 *
 * @author xcy
 */
class AreaController extends Controller{
	

	public function MapLoad($type='ershoufang'){        
		//根据地址栏传参 判断不同的房源类型
		$data['type'] = $type;
		//地铁
		$data['city'] = $city = new City(1,"北京","bj",116.395645,39.929986);
		$data['subways'] = $subways = MapDao::GetSubwayLines($city->id);      

		//价格
		$data['prices'] = \Config::get('priceConfig.beijing.text');
		//面积
		$data['proportion'] = \Config::get('areaConfig.beijing.text');
		//户型
		$data['models'] = \Config::get('conditionConfig.models.text');
		//朝向
		$data['toward'] = \Config::get('conditionConfig.toward.text');
		//房龄
		$data['that'] = \Config::get('conditionConfig.that.text');
		//楼层
		$data['floor'] = \Config::get('conditionConfig.floor.text');
		//装修
		$data['decorate'] = \Config::get('conditionConfig.decorate.text');
		//配套
		$data['pei'] = \Config::get('conditionConfig.pei.text');
		//特色
		$data['te'] = \Config::get('conditionConfig.te.text');
		//学区
		$data['xue'] = \Config::get('conditionConfig.xue.text');

		return View("map.area",$data);
	} 

	/**
	* ajax获取 地图数据
	* @since 1.0
	* @author xcy
	* @param string 
	* @return array 返回根据 输入的参数而得到的房源 
	*/
	public function getArea(){
		$housetype=Input::get('housetype','');	
		$search=Input::get('search','');
		$price=Input::get('price','');
		$area=Input::get('area','');
		$model=Input::get('model','');
		$toward=Input::get('toward','');
		$that=Input::get('that','');
		$floor=Input::get('floor','');
		$decorate=Input::get('decorate','');
		$pei=Input::get('pei','');
		$te=Input::get('te','');
		$xue=Input::get('xue','');
		$sort=Input::get('sort','');
		$page=Input::get('page','');
		//$ListPutView = new ListPutView($housetype,$search,$price,$area,$model,$toward,$that,$floor,$decorate,$pei,$te,$xue,$sort,$page);
		
		//return json_encode($ListPutView);
		return 123;
	}

	/**
	* ajax获取 地铁站点
	* @since 1.0
	* @author xcy
	* @param string $id
	* @return array 返回根据 输入的id而得到的地铁站点名和相关id 
	*/
	public function getSubWayStation($lineid=''){
		$city = new City(1,"北京","bj",116.395645,39.929986);
		$cityId = $city->id;
		$lineId = Input::get('sub_id',$lineid);
		if(!is_numeric($lineId)){
			return 2;
		}else{
			if( !Cache::get('citySubStationId'.$cityId.$lineId)){
				$subWay = MapDao::SelectSubWayStations($cityId,$lineId);
				Cache::put('citySubStationId'.$cityId.$lineId, $subWay, 1);
			}else{
				$subWay = Cache::get('citySubStationId'.$cityId.$lineId);
			}
			
			return json_encode($subWay);
			//return $subWay;
		}
	}


}




