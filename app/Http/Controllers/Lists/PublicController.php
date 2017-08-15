<?php

namespace App\Http\Controllers\Lists;

use Illuminate\Routing\Controller;
use App\Dao\City\CityDao;
use App\Dao\Agent\HouseDao;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
use DB;
use Input;
/**
* Description of PublicController （房源搜索列表下的公共类）
* @since 1.0
* @author xcy
*/

class PublicController extends Controller{

	protected $CityDao;
	protected $HouseDao;

	public function __construct(){
		$this->CityDao = new CityDao();
		$this->HouseDao = new HouseDao();
	}
//	/**
//	 * 获取 城市名称
//	 * @since 1.0
//	 * @author xcy
//	 * @param int $id 城市id
//	 * @return array 返回根据 输入的城市名称
//	 */
//	public function findCity($id='1'){
//		$cityArea = array();
//		if(!is_numeric($id)){
//			return array();
//		}else{
//			if( !Cache::has('x_cityId'.$id)){
//				$cityArea = $this->CityDao->findCity($id);
//				Cache::put('x_cityId'.$id, $cityArea, 60 * 3);
//			}else{
//				$cityArea = Cache::get('x_cityId'.$id);
//			}
//
//			return $cityArea;
//		}
//	}
	/**
	* 获取 城区数据
	* @since 1.0
	* @author xcy
	* @param int $id 城市id
	* @return array 返回根据 输入的城市id返回该城市的地区相关数据 
	*/
	public function getCityArea($id='1'){
		$cityArea = array();
		if(!is_numeric($id)){
			return array();
		}else{
			if( !Cache::has('cityArea_'.$id)){
				$cityArea = $this->CityDao->xselectCityArea($id);
				Cache::put('cityArea_'.$id, $cityArea, 60 * 12*30);
			}else{
				$cityArea = Cache::get('cityArea_'.$id);
			}

			return $cityArea;
		}
	}

	/**
	* 获取 城区下子区域
	* @since 1.0
	* @author xcy
	* @param int $id 区域id
	* @return array 返回根据 输入的区域id返回该区域子区域相关数据 并按照拼音排序
	*/
	public function getBusinessArea($id='1'){
		$businessArea = array();
		if(!is_numeric($id)){
			return array();
		}else{
			if( !Cache::has('businessAreaPy_'.$id)){
				$businessAreas = $this->CityDao->selectBusinessArea($id);
				foreach($businessAreas as $v){
					$first = strtoupper(substr($v->pinyin,0,1));
					$businessArea[$first][] = array('id'=>$v->id,'name'=>$v->name);
				}
				Cache::put('businessAreaPy_'.$id, $businessArea, 60 * 12*30);
			}else{
				$businessArea = Cache::get('businessAreaPy_'.$id);
			}

			return  $businessArea;
		}
	}
	//根据城市id获取子区域的数据
	public function getBusinessAreas($id){
		$businessArea = array();
		if(!is_numeric($id)){
			return array();
		}else{
			if( !Cache::has('businessAreasByCityId_'.$id)){
				$businessArea = $this->CityDao->selectBusinessCityArea($id);
				Cache::put('businessAreasByCityId_'.$id, $businessArea, 60 * 12*30);
			}else{
				$businessArea = Cache::get('businessAreasByCityId_'.$id);
			}
			return  $businessArea;
		}
	}
	/**
	 * 获取 全部地铁
	 */
	public function getSubWayAll(){
		$subWays = array();
		if( !Cache::get('subWayLineAll')){
			$subWay = $this->CityDao->selectSubWayAll();
			foreach($subWay as $k=>$v){
				$subWays[$v->id] = $v->name;
			}
			Cache::put('subWayLineAll', $subWays, 60 * 12*30);
		}else{
			$subWays = Cache::get('subWayLineAll');
		}
		return $subWays;
	}
	/**
	 * 获取 全部地铁站点
	 */
	public  function getSubWayStationAll(){
		$subWayStation = array();
		if( !Cache::get('subWayStationAll')){
			$subWay = $this->CityDao->selectSubWayStationAll();
			foreach($subWay as $k=>$v){
				$subWayStation[$v->id] = $v->name;
			}
			Cache::put('subWayStationAll', $subWayStation, 60 * 12*30);
		}else{
			$subWayStation = Cache::get('subWayStationAll');
		}
		return $subWayStation;
	}
	/**
	* 获取 地铁
	* @since 1.0
	* @author xcy
	* @param int $id 城市id
	* @return array 返回根据 输入的城市id返回该城市的地铁相关数据 
	*/
	public function getSubWay($id=''){
		if(empty($id)){
			$id = Input::get('id');
		}
		if(empty($id)){
			return array();
		}
		$subWay = array();
		if(!is_numeric($id)){
			return array();
		}else{
			if( !Cache::has('subwayline_'.$id)){
				$subWay = $this->CityDao->selectSubWay($id);
				Cache::put('subwayline_'.$id, $subWay, 60 * 12*30);
			}else{
				$subWay = Cache::get('subwayline_'.$id);
			}
			return $subWay;
		}
	}
	
	/**
	* 获取 地铁站点
	* @since 1.0
	* @author xcy
	* @param int $cityId 城市id，$lineid 地铁线路id
	* @return array 返回根据 输入的城市cityId,地铁线路lineid返回地铁站点相关数据 
	*/
	public function getSubWayStation($cityId='',$lineId=''){
		if(empty($cityId)){
			$cityId = Input::get('cityId');
		}
		if(empty($lineId)){
			$lineId = Input::get('lineId');
		}
		if(empty($cityId)||empty($lineId)){
			return array();
		}
		$subWayStation = array();
		if(!is_numeric($lineId)){
			return array();
		}else{
			Cache::pull('subStationId_'.$cityId.'_'.$lineId);
			if( !Cache::has('subStationId_'.$cityId.'_'.$lineId)){
				$where  = array('cityId'=>$cityId,'lineId'=>$lineId);
				$subWayStation = $this->CityDao->selectSubWayStation($where);
				Cache::put('subStationId_'.$cityId.'_'.$lineId, $subWayStation, 60 * 12*30);
			}else{
				$subWayStation = Cache::get('subStationId_'.$cityId.'_'.$lineId);
			}
			return $subWayStation;
		}
	}

	/**
	* 获取 地铁及所有的站点
	* @since 1.0
	* @author xcy
	* @param int $id 城市id
	* @return array 返回根据 输入的城市id返回该城市的地铁相关数据 
	*/
	public function getSubWays($id=''){
		$subWays = array();
		if(!is_numeric($id)){
			return array();
		}else{
			if( !Cache::has('x_getSubWays'.$id)){
				$subWay = $this->getSubWay($id);
				foreach($subWay as $k=>$v){
					$subWays[$k] = $v;
					$subWays[$k]->substation = $this->getSubWayStation($id,$v->id);
				}
				Cache::put('x_getSubWays'.$id, $subWays, 60 * 12*30);
			}else{
				$subWays = Cache::get('x_getSubWays'.$id);
			}
			return $subWays;
		}
	}

	/**
	* 获取 商圈
	* @since 1.0
	* @author xcy
	* @param int $cityId 城市id，
	* @return array 返回根据 输入的城市cityId返回商圈相关数据 
	*/
	public function getBusinessTag($cityId=''){
		$BusinessTag = array();
		if(!is_numeric($cityId)){
			return array();
		}else{
			if( !Cache::has('businessTag_'.$cityId)){
				$BusinessTag = $this->CityDao->selectBusinessTag($cityId);
				Cache::put('businessTag_'.$cityId, $BusinessTag, 60 * 24*30);
			}else{
				$BusinessTag = Cache::get('businessTag_'.$cityId);
			}
			
			return $BusinessTag;
		}
	}

	public function getBusline($cityId,$name){
		$Busline = array();
		$Busline = $this->CityDao->getBusline($cityId,$name);
		return $Busline;
	}

	public function getBusstation($buslines){
		if(!empty($buslines)){
			foreach($buslines as $v){
				$busStation[$v->id] = $this->CityDao->getBusstation($v->cityId,$v->id);
			}
		}
		return $busStation;
	}

	public function getBus($cityId,$name){
		$busStation = array();
		$busStation = $this->CityDao->getBus($cityId,$name);
		return $busStation;
	}
	public function getBus1($cityBus){
		$temp = array();
		if(!empty($cityBus)){
			foreach($cityBus as $v){
				$temp[$v->lineId] = $this->CityDao->getBus1($v->cityId,$v->lineId);
			}			
		}

		return $temp;
	}
	/**
	* 获取分页页码
	* @since 1.0
	* @author xcy
	* @param type $total    总条数
	* @param type $mCurPageNum     当前页码数
	* @param type $pageset     每页显示条数
	* @return string 返回根据 输入的参数得到分页页码 
	*/
	public function RentPaging($total,$mCurPageNum,$pageset='30',$linkurl = '',$purl = ''){
		$linkurl .= '/';
		$totalPageNum = (int) ($total / $pageset);
		if ($total % $pageset > 0) {
		    $totalPageNum ++;
		}
		$startpage = (int) ($mCurPageNum - 3);
		if (empty($mCurPageNum) || $startpage <= 0) {
		    $startpage = 1;
		}
		$stoppage = (int) ($mCurPageNum+ 3);

		if ($stoppage > $totalPageNum) {
		    $stoppage = $totalPageNum;
		}

		if ($startpage == 1) {
		    $stoppage = (int) $totalPageNum;
		}

	    $pagingHtml="";
	    
		$nPage=0;
		$nPageCount = 0;
		//链接
		$url='';        
		if($startpage==$totalPageNum&&$startpage==1)
		{
		    $pagingHtml="<li class=\"left\"></li><li class=\"click\">1</li><li class=\"right\"></li>";
		    return $pagingHtml;
		}                   

		if ($totalPageNum == 0)
		{
		    return;
		}
		$pagingHtml="";//<li>首页</li><li>上一页</li>
		if($mCurPageNum!=1)
		{
		    $pagingHtml="<li><a class=\"page\" href=\"".$linkurl.get_url_by_id($purl,'bl',1)."\" alt=\"1\">首页</a></li><li><a class=\"page\" href=\"".$linkurl.get_url_by_id($purl,'bl',$mCurPageNum-1)."\" alt=\"".($mCurPageNum-1)."\">上一页</a></li>";
		}
		for($nPage = $startpage; $nPage <= $stoppage; $nPage++)
		{           
		    if ($startpage >= 2 && $nPage == $startpage)
		    {                                    
		        //$pagingHtml=$pagingHtml."<li class=\"left\"></li><li>1</li>";
		        if ($mCurPageNum >= 5)                    
		        {
		            $pagingHtml=$pagingHtml."<li><a href=\"".$linkurl.get_url_by_id($purl,'bl',1)."\" class=\"page\" alt=\"1\">1</a></li><li class=\"no_border\">...</li>";
		        }                
		    }
		    if($nPage==$mCurPageNum)
		    {
		        $pagingHtml=$pagingHtml."<li class=\"click\">".$nPage."</li>";    
		    }else
		    {
		        $pagingHtml=$pagingHtml."<li><a href=\"".$linkurl.get_url_by_id($purl,'bl',$nPage)."\" alt=\"".$nPage."\"  class=\"page\">".$nPage."</a></li>";
		    }
		    //$pagingHtml=$pagingHtml."<li><a href=\"".$url."&page=".$nPage."\">".$nPage."</a></li>";
		    $nPageCount++;
		        if ($nPageCount >= 5)
		            break;
		}        
		if ($totalPageNum > $mCurPageNum)
		{
		     if ($totalPageNum > 3)
		     {
		         if ($stoppage != $mCurPageNum&&$totalPageNum-$mCurPageNum>=2&&$totalPageNum!=5&&$totalPageNum!=4)
		         {
		             $pagingHtml=$pagingHtml."<li class=\"no_border\">...</li><li><a href=\"".$linkurl.get_url_by_id($purl,'bl',$totalPageNum)."\" alt=\"".$totalPageNum."\"  class=\"page\">".$totalPageNum."</a></li><li class=\"right\"><a href=\"".$linkurl.get_url_by_id($purl,'bl',$mCurPageNum+1)."\" alt=\"".($mCurPageNum+1)."\" class=\"page\">下一页</a></li><li><a href=\"".$linkurl.get_url_by_id($purl,'bl',$totalPageNum)."\" alt=\"".$totalPageNum."\"  class=\"page\">尾页</a></li>";
		         }     
		         else 
		         {
		             $pagingHtml=$pagingHtml."<li><a class=\"page\" href=\"".$linkurl.get_url_by_id($purl,'bl',$mCurPageNum+1)."\" alt=\"".($mCurPageNum+1)."\">下一页</a></li><li><a href=\"".$linkurl.get_url_by_id($purl,'bl',$totalPageNum)."\" alt=\"".$totalPageNum."\"  class=\"page\">尾页</a></li>";
		         }
		     }else
		     {
		         $pagingHtml=$pagingHtml."<li><a href=\"".$linkurl.get_url_by_id($purl,'bl',$mCurPageNum+1)."\" alt=\"".($mCurPageNum+1)."\" class=\"page\">下一页</a></li><li><a href=\"".$linkurl.get_url_by_id($purl,'bl',$totalPageNum)."\" alt=\"".$totalPageNum."\"  class=\"page\">尾页</a></li>";
		     }
		}else if($mCurPageNum==$totalPageNum)
		{
		    $pagingHtml=$pagingHtml;//."<li>下一页</li><li>尾页</li>"
		}
		//跳转
		//$return="<li class=\"no_border width\">跳转到</li><li><input id=\"pageText\" type=\"text\" class=\"txt\"></li><li onclick=\"gotoPage(21)\" class=\"margin_r\"><a id=\"click_get_page\" href=\"#\">GO</a></li>";
		return $pagingHtml;
	}

	//数组转换
	public function conversion($data){
		$info=array();
		if(!empty($data)){
			foreach($data as $v){
				$info[$v->id] = $v->name;
			}
			return $info;
		}else{
			return $info;
		}
	}
	/**
	 * 以下是h5页面上用的方法
	 */
	//应用于h5页面 根据城区数据获取该城市的子区域
	public function getBusinessAreaH5($cityId,$cityArea){
		if(empty($cityArea)){
			return array();
		}
		$arr = array();
		$res = array();
		if(!Cache::has('businessAreaH5_'.$cityId)){
			$BusinessAreas = $this->getBusinessAreas($cityId);
			if(!empty($BusinessAreas)){
				foreach($BusinessAreas as $bv){
					$arr[$bv->cityAreaId][] = $bv;
				}
			}
			foreach($cityArea as $av){
				$res[$av->id] = !empty($arr[$av->id])?$arr[$av->id]:array();
			}
			Cache::put('businessAreaH5_'.$cityId, $res, 60 * 24*30);
		}else{
			$res = Cache::get('businessAreaH5_'.$cityId);
		}

		return $res;
	}

	//应用于h5页面 根据地铁数据获取该城市的地铁站点
	public function getSubWayStationH5($cityId,$subWay){
		if(empty($subWay)){
			return array();
		}
		$arr = array();
		$res = array();
		Cache::forget('subWayStationH5_'.$cityId);
		if(!Cache::has('subWayStationH5_'.$cityId)){
			$where  = array('cityId'=>$cityId);
			$subWayStation = $this->CityDao->selectSubWayStation($where);
			$subWayArr = $this->conversion($subWay);
			if(!empty($subWayStation)){
				foreach($subWayStation as $sv){
					$sv->lineName = !empty($subWayArr[$sv->lineId])?$subWayArr[$sv->lineId]:'';
					$arr[$sv->lineId][] = $sv;
				}
			}
			foreach($subWay as $av){
				$res[$av->id] = !empty($arr[$av->id])?$arr[$av->id]:array();
			}
			Cache::put('subWayStationH5_'.$cityId, $res, 60 * 24*30);
		}else{
			$res = Cache::get('subWayStationH5_'.$cityId);
		}
		return $res;
	}

	/**
	 * @param $cityId
	 * @param $subWay
	 * @return array 键：站点id  值：[name：站点名称，lineId：线路id，lineName：线路名称]
	 */
	public function getNameByStationId($cityId,$subWay){
		$res = array();
		//Cache::forget('subNameByStationId_'.$cityId);
		if(!Cache::has('subNameByStationId_'.$cityId)){
			$subWay = $this->getSubWayStationH5($cityId,$subWay);
			foreach($subWay as $sub){
				foreach($sub as $su){
					$res[$su->id] = ['name'=>$su->name,'lineId'=>$su->lineId,'lineName'=>$su->lineName];
				}
			}
			Cache::put('subNameByStationId_'.$cityId, $res, 60 * 24*30);
		}else{
			$res = Cache::get('subNameByStationId_'.$cityId);
		}
		return $res;
	}
	//房源自定义标签获取
	public function getDiyTagHouse($results){
		if(isset($results->error)||empty($results)){
			return array();
		}

		$houses = $results->hits->hits;
		$res = array();
		if(!empty($houses)){
			foreach($houses as $house){
				if(!empty($house->_source->diyTagId)){
					$diyTagIds = explode('|',$house->_source->diyTagId);
					$res = array_merge($res,$diyTagIds);
				}
			}
		}
		$res = array_unique($res);
		$info = array();
		if(!empty($res)){
			$info = $this->HouseDao->getDiyTagByIds($res);
		}
		return $info;
	}
	//楼盘自定义标签获取
	public function getDiyTagBuild($results,$type1,$type2){
		if(isset($results->error)||empty($results)){
			return array();
		}
		$builds = $results->hits->hits;
		$res = array();
		if(!empty($builds)){
			foreach($builds as $build){
				if(!empty($type2)){
					$type2 = $type2+0;
				}else{
					$type2 = '';
					foreach(explode('|',$build->_source->type2) as $tp2){
						if((substr($tp2,0,1) == $type1)||(($tp2 =='303')&&($type1 == 2))){
							$type2 = $tp2;
							break;
						}
					}
				}
				$typeInfo = 'type'.$type2.'Info';
				if(!empty($build->_source->$typeInfo)){
					$typeInfo = json_decode($build->_source->$typeInfo);
				}else{
					$typeInfo = '';
				}
				if(!empty($typeInfo)){
					if(!empty($typeInfo->diyTagIds)){
						$diyTagIds = explode('|',$typeInfo->diyTagIds);
						$res = array_merge($res,$diyTagIds);
					}
				}
			}
		}
		$res = array_unique($res);
		$info = array();
		if(!empty($res)){
			$info = $this->HouseDao->getDiyTagByIds($res);
		}
		return $info;
	}
	//城市城区商圈价格趋势
	/**
	 * @param $data [type,houseType1,cityId,cityareaId,businessAreaId] 出租|出售，物业类型，城市id，城区id，商圈id
	 */
	public function  priceMovement($data){
		$isNew = $data['isNew'];
		$type = $data['type'];
		$type1 = $data['houseType1'];
		$cityId = $data['cityId'];
		$cityareaId = $data['cityareaId'];
		$businessAreaId = $data['businessAreaId'];
		Redis::connect(config('database.redis.default.host'), 6379);
		Redis::select(6);  // 选择6号库
		$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
		$time = $endThismonth - time();
		if(!empty($businessAreaId)){
			$key = 'businessAreaId:'.$isNew.':'.$type.':'.$type1.':'.$cityId.':'.$cityareaId.':'.$businessAreaId;
			if(empty(json_decode(Redis::get($key)))){
				$where = ['businessareaId'=>$businessAreaId,'cType1'=>$type1,'type'=>$type,'room'=>0];
				$info = DB::connection('mysql_statistics')->table('businessareastatus2')
					->where($where)
					->where('changeTime','>=',date('Ym',strtotime('-6 month')))
					->where('changeTime','<',date('Ym',time()))
					->groupBy('changeTime')
					->select('id','avgPrice','changeTime')
					->orderBy('id','desc')
					->limit(6)
					->get();
				$info = $this->priceArrFill($info);
				$info = json_encode($info);
				Redis::SETEX($key,$time,$info);
			}else{
				$info = Redis::get($key);
			}
			return $info;
			//return json_decode($info);
		}elseif(!empty($cityareaId)){
			$key = 'cityareaId:'.$isNew.':'.$type.':'.$type1.':'.$cityId.':'.$cityareaId;
			if(empty(json_decode(Redis::get($key)))){
				$where = ['cityareaId'=>$cityareaId,'cType1'=>$type1,'type'=>$type,'room'=>0];
				$info = DB::connection('mysql_statistics')->table('cityareastatus2')
					->where($where)
					->where('changeTime','>=',date('Ym',strtotime('-6 month')))
					->where('changeTime','<',date('Ym',time()))
					->groupBy('changeTime')
					->select('id','avgPrice','changeTime')
					->orderBy('id','desc')
					->limit(6)
					->get();
				$info = $this->priceArrFill($info);
				$info = json_encode($info);
				Redis::SETEX($key,$time,$info);
			}else{
				$info = Redis::get($key);
			}
			return $info;
			//return json_decode($info);
		}else{
			$key = 'cityId:'.$isNew.':'.$type.':'.$type1.':'.$cityId;
			if(empty(json_decode(Redis::get($key)))){
				$where = ['cityId'=>$cityId,'cType1'=>$type1,'type'=>$type,'room'=>0];
				$info = DB::connection('mysql_statistics')->table('citystatus2')
					->where($where)
					->where('changeTime','>=',date('Ym',strtotime('-6 month')))
					->where('changeTime','<',date('Ym',time()))
					->groupBy('changeTime')
					->select('id','avgPrice','changeTime')
					->orderBy('id','desc')
					->limit(6)
					->get();
				$info = $this->priceArrFill($info);
				$info = json_encode($info);
				Redis::SETEX($key,$time,$info);
			}else{
				$info = Redis::get($key);
			}
			return $info;
			//return json_decode($info);
		}
	}
	/**
	 * 填充缺少月份的值,缺少月份使用上个月值,首月无值用0
	 * @param $array
	 * @return array
	 */
	protected function priceArrFill($info){
		//取查询结果值并计算均价
		$array=[];
		$averagePrice=0;
		if(!empty($info)){
			foreach ($info as $v){
				$array[$v->changeTime]=intVal($v->avgPrice);
			}
		}
		//dd($array);
		$newArr=[];//dd($array);
		for($i=-6;$i<0;$i++){
			$month=date('Ym',strtotime("$i month"));
			if(array_key_exists($month,$array) && $array[$month]){
				$newArr[$month]=$array[$month];
			}else{
				if($i==-6){
					$newArr[$month]=0;
				}else{
					$index=$i-1;
					$newArr[$month]=$newArr[date('Ym',strtotime("$index month"))];
				}
			}
		}
		ksort($newArr);
		$xAxisStr=array_keys($newArr);
		$seriesStr=array_values($newArr);
		$returnArr[]=$xAxisStr;
		$returnArr[]=$seriesStr;
		return $returnArr;
	}
	//获取客户端ip
	public function clientIP(){
		$cIP = getenv('REMOTE_ADDR');
		$cIP1 = getenv('HTTP_X_FORWARDED_FOR');
		$cIP2 = getenv('HTTP_CLIENT_IP');
		$cIP1 ? $cIP = $cIP1 : null;
		$cIP2 ? $cIP = $cIP2 : null;
		return $cIP;
	}
	/**
	 * @param string $class old:二手楼盘 new:新楼盘 sub:地铁站点
	 * @param array $data ['saleRentType','oldHId'];['saleRentType','newHId'];['saleRentType','sId']
	 * @param int $type1 1.商铺 2.写字楼 3住宅
	 */
	public function searchStatistics($cityId,$class = 'old',$data,$type1='3'){
		Redis::select(1);
		$where = array();
		$where['saleRentType'] = $sr = $data['saleRentType'];
		//键值
		if($class == 'new'){
			$table = 'displaycommunitystatus';
			$newHId = $data['newHId'];
			$where['newHId'] = $newHId;
			$key = $class.':'.$sr.':'.$type1.':'.$newHId;
		}elseif($class == 'sub'){
			$table = 'displaysubwaystationstatus';
			$sId = $data['sId'];
			$where['sId'] = $sId;
			$key = $class.':'.$sr.':'.$type1.':'.$sId;
		}else{
			$table = 'displaycommunitystatus';
			$oldHId = $data['oldHId'];
			$where['oldHId'] = $oldHId;
			$key = $class.':'.$sr.':'.$type1.':'.$oldHId;
		}
		$where['dateInt'] = date('Ymd');
		$time = time();
		if(Redis::exists($key)){
			$value = Redis::get($key);
			$arr = explode('|',$value);
			$sum = !empty($arr[0])?$arr[0]:0;
			$stime = !empty($arr[1])?$arr[1]:$time;
			$sum += 1;
			if(($sum >=10) || ($time - $stime) > 10*60){
				//写入数据库
				$id = DB::connection('mysql_statistics')->table($table)->where($where)->pluck('id');
				if(!empty($id)){
					DB::connection('mysql_statistics')->table($table)->where('id',$id)->increment('dispCount',$sum);
				}else{
					$data['type1'] = $type1;
					$data['cityId'] = $cityId;
					$data['dateInt'] = date('Ymd');
					$data['dispCount'] = $sum;
					DB::connection('mysql_statistics')->table($table)->insert($data);
				}
				Redis::SETEX($key,604800,'0|'.$time);
			}else{
				Redis::SETEX($key,604800,$sum.'|'.$time);
			}

		}else{
			Redis::SETEX($key,604800,'1|'.$time);
		}
	}
}




