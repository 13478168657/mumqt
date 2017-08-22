<?php
namespace App\Dao\Contrast;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
/**
* 楼盘对比
* @since 1.0 楼盘对比功能
* @author liyang
*/
class BuildContrastDao {

	/**
	* 根据楼盘名称获取id
	* @param string $buildName 楼盘的名称
	*/
	public function getCommunityId($connection,$buildName,$cityId) {
		return DB::connection($connection)
		->table('community')
		->where('name',$buildName)
                ->where('cityId',$cityId)
		->skip(0)
		->take(1)
		->select('id')
		->get();
	}

	/**
	* 查询楼盘信息
	* @param int $communityId 楼盘的id
	* @param string $type2 副物业类型(type2)
	*/
	public function getCommunityType2($connection,$communityId,$type2) {
		return DB::connection($connection)
		->table('community')
		->where('id',$communityId)
		->select('id','name','developerId','address','longitude','latitude','type'.$type2.'Info')
		->get();
	}

	/**
	* 查询楼盘图片
	* @param int $communityId 楼盘Id
	* @param string $type 图片类型 (type = 10 位楼盘标题图)
	*/
	public function getPic($connection,$communityId,$type) {
		return DB::connection($connection)
		->table('communityimage')
		->where('communityId',$communityId)
		->where('type',$type)
		->select('id','communityId','type','fileName')
		->get();
	}

	/**
	* 查询楼盘期数(营销信息表)communityperiods
	* @param int $communityId 楼盘id
	*/
	public function getPer($connection,$communityId) {
		return DB::connection($connection)
		->select("SELECT openTime,takeTime FROM communityperiods WHERE communityId = $communityId ORDER BY id DESC LIMIT 1");
	}

	/**
	* 获取开发商名称
	* @param int $id 开发商id
	*/
	public function getDeveloperName($id) {
		return DB::connection('mysql_house')
		->table('developers')
		->where('id',$id)
		->where('parentId','0')
		->select('companyname')
		->get();
	}

	/**
	* 查询楼盘的户型信息
	* @param init $communityId 楼盘id
	*/
	public function getCommunityRoom($connection,$communityId) {
		return DB::connection($connection)
		->table('communityroom')
		->where('communityId',$communityId)
		->select('id','communityId','room','floorage','location','type2')
		->get();
	}

	/**
	 * 获得地图周边信息对象,输入ID，有信息返回对象，没信息返回false
	 * @param $id
	 * @return object|bool
	 * huzhaer  2016-1-8
	 */
	public function getMapAroundInfoById($connection,$id){
		$aroundInfo = DB::connection($connection)
			          ->table('communityaroundinfo')
			          ->where('communityId',$id)
			          ->get(['bank','food','happy','hospital',
						  	'market','park','school','traffic']);
		if(!empty($aroundInfo)){
			$aroundInfo[0]->bank = unserialize($aroundInfo[0]->bank);
			$aroundInfo[0]->food = unserialize($aroundInfo[0]->food);
			$aroundInfo[0]->happy = unserialize($aroundInfo[0]->happy);
			$aroundInfo[0]->hospital = unserialize($aroundInfo[0]->hospital);
			$aroundInfo[0]->market = unserialize($aroundInfo[0]->market);
			$aroundInfo[0]->park = unserialize($aroundInfo[0]->park);
			$aroundInfo[0]->school = unserialize($aroundInfo[0]->school);
			$aroundInfo[0]->traffic = unserialize($aroundInfo[0]->traffic);
	

			// $aroundInfo = unserialize($aroundInfo);
			$aroundInfo = json_decode(json_encode($aroundInfo),true);

			return $aroundInfo;
		}
		return false;
	}

	/**
	 * xcy 获取楼盘相关信息
	 * @param $id
	 */
	public function getCommunityInfo($connection,$id){
		return DB::connection($connection)->table('community')->find($id);
	}
	/**
	 * 查询楼盘期数(营销信息表)communityperiods
	 * @param int $communityId 楼盘id
	 */
	public function getPeriods($communityId) {
		return DB::connection('mysql_house')->table('communityperiods')->select('id','openTime','takeTime','rentAvgPrice','saleAvgPrice','specialOffers','discountType','discount','subtract')->where('communityId',$communityId)->orderBy('openTime','desc')->get();
	}
}
?>