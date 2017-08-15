<?php 
namespace App\Dao\Xinf;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
* description of resold apartment 新盘房楼房信息描述
* @since 1.0
* @author liyang
*/

class XinfDao {

	/**
	| 楼盘首页DAO
	*/
    
        /**
	* 查询楼盘的主物业类型
	* @param int $communityId 楼盘id
	* @author   zhuwei
        * @date    2016/02/27   11:53:30 
	*/
    public function getCommunityType($communityId){
        $type = DB::connection('mysql_house')
                ->table('community')
                ->where('id',$communityId)
                ->pluck('type1');
        return $type;
    }

    /**
	* 查询楼盘信息
	* @param int $communityId 楼盘id
	* @param int $type2 楼盘当前的副物业类型
	*/
	public function getCommunity($communityId) {
//		Cache::pull('newCommunity_'.$communityId);
		if(!Cache::has('newCommunity_'.$communityId)){
			$info = DB::connection('mysql_house')
				->table('community')
				->where('id',$communityId)->get();
			Cache::put('newCommunity_'.$communityId,$info,60*24*30);
		}else{
			$info = Cache::get('newCommunity_'.$communityId);
		}
		return $info;
	}

	/**
	* 获取营销信息最新一期
	* @param int $communityId 楼盘id
	*/
	public function getPeriods($communityId) {
//		Cache::pull('newCommunityPeriod_'.$communityId);
		if(!Cache::has('newCommunityPeriod_'.$communityId)){
			$info = DB::connection('mysql_house')->table('communityperiods')->where('communityId',$communityId)->orderBy('id', 'desc')->get();
//            $info = DB::connection('mysql_house')->select("SELECT * from communityperiods WHERE communityId=? ORDER BY id desc ", [$communityId]);
			Cache::put('newCommunityPeriod_'.$communityId,$info,30);
		} else {
			$info = Cache::get('newCommunityPeriod_'.$communityId);
		}
		return $info;
	}
	/**
	 * 获取营销信息最新一期
	 * @param int $communityId 楼盘id
	 */
	public function getPeriodsBytype2($communityId,$type2) {
		if(!Cache::has('newCommunityPeriod_'.$communityId.'_'.$type2)){
			$info = DB::connection('mysql_house')->table('communityperiods')->where('communityId',$communityId)->where('type2',$type2)->orderBy('openTime', 'desc')->get();
			Cache::put('newCommunityPeriod_'.$communityId.'_'.$type2,$info,30);
		}else{
			$info = Cache::get('newCommunityPeriod_'.$communityId.'_'.$type2);
		}
		return $info;
	}
//	/**
//	 * 查询期数下的楼栋id
//	 * @param int $communityId 楼盘id
//	 */
//	public function getPeriodCbids($communityId) {
//		return DB::connection('mysql_house')
//			->table('communityperiods')
//			->where('communityId',$communityId)
//			->select('id','period','communityId','cbIds')
//			->orderBy('period','asc')
//			->get();
//	}
	/**
	* 查询城区
	* @param int $id 城区id
	*/
	public function getCityAreaName($cityAreaId) {
		return DB::connection('mysql_house')
		->table('cityarea')
		->where('id',$cityAreaId)
		->select('id','name')
		->get();
	}

	/**
	* 查询商圈
	* @param int $id 商圈id
	*/
	public function getBusinessName($businessAreaId) {
		return DB::connection('mysql_house')
		->table('businessarea')
		->where('id',$businessAreaId)
		->select('id','name')
		->get();
	}

	/**
	* 获取楼盘点评
	* @param $communityId 楼盘id
	*/
	public function getCommComment($communityId) {
		if(!Cache::has('newCommunityComment_'.$communityId)){
			$info = DB::connection('mysql_house')->table('communitycomment')->where('communityId',$communityId)->select('title','comment','timeCreate')->orderBy('timeCreate', 'desc')->limit(2)->get();
			Cache::put('newCommunityComment_'.$communityId,$info,60);
		}else{
			$info = Cache::get('newCommunityComment_'.$communityId);
		}
		return $info;
	}

	/**
	* 查询新盘调价历史(communitystatus)
	* @param int $communityId 楼盘id
	* @param int $type 1.出租 2.出售 新盘只能是2
	* @param int 物业类型2 如 301
	*/
	public function getStatus($communityId,$type,$type2) {
		if(!Cache::has('newCommunityStatus_'.$communityId.'_'.$type2)){
			$info = DB::connection('mysql_statistics')->table('communitystatus')->where('communityId',$communityId)->where('type',$type)->where('cType2',$type2)->select('changeTime','maxPrice','avgPrice','minPrice','description')->orderBy('changeTime','desc')->limit(10)->get();
			Cache::put('newCommunityStatus_'.$communityId.'_'.$type2,$info,60);
		}else{
			$info = Cache::get('newCommunityStatus_'.$communityId.'_'.$type2);
		}
		return $info;
	}
	public function getCommunityNews($communityId){
		$info = DB::connection('mysql_house')->table('communitynews')->where('cId',$communityId)->select('title','news','timeCreate')->orderBy('timeCreate','desc')->limit(2)->get();
		return $info;
	}
//	/**
//	 * 查询调价历史表信息
//	 * @param int $communityId 楼盘id
//	 * @param int $type type: 1.出租 2.出售
//	 * @param array $select 查询字段
//	 */
//	public function getCommStatusData($communityId,$type,$select) {
//		return DB::connection('mysql_statistics')
//			->table('communitystatus')
//			->where('communityId',$communityId)
//			->where('type',$type)
//			->select($select)
//			->orderBy('changeTime','desc')
//			->limit(10)
//			->get();
//	}

	/**
	 * 查询正在出售的套数
	 * @param int $communityId 楼盘id
	 */
	public function getStatusTotal($communityId) {
		return DB::connection('mysql_statistics')
			->table('communitystatus')
			->where('communityId',$communityId)
			->select('id')
			->get();
	}
	/**
	 * 查询楼盘调价历史表居数均价
	 * @param int $communityId 楼盘id
	 * @param int $type type: 1.出租 2.出售
	 * @param int $room 几居室
	 * @param array $select 查询字段
	 * +------------------------------------------------+
	 * | 查询均价取更新时间最新的那一条数据(changeTime) |
	 * +------------------------------------------------+
	 */
	public function getCommStatus($communityId,$type,$room,$select) {
		return DB::connection('mysql_statistics')
			->table('communitystatus')
			->where('communityId',$communityId)
			->where('type',$type)
			->where('room',$room)
			->select($select)
			->orderBy('changeTime','desc')
			->limit(1)
			->get();
	}
	/**
	* 查询楼盘楼栋表
	* @param $communityId 楼盘id
	*/
//	public function getCommBuild1($communityId,$type2) {
//		Cache::pull('newCommunityBuild_'.$communityId.'_'.$type2);
//		if(!Cache::has('newCommunityBuild_'.$communityId.'_'.$type2)){
//			$info = DB::connection('mysql_house')->table('communitybuilding')->where('communityId',$communityId)->where('type2',$type2)->select('id','num','openTime','takeTime','unitTotal','floorTotal','houseTotal','liftHouseRatio','coordinateX','coordinateY','state')->get();
//			Cache::put('newCommunityBuild_'.$communityId.'_'.$type2,$info,60);
//		}else{
//			$info = Cache::get('newCommunityBuild_'.$communityId.'_'.$type2);
//		}
//		return $info;
//	}
    /**
     * 查询楼盘楼栋表
     * @param $communityId 楼盘id
     */
    public function getCommBuild($communityId) {
        Cache::pull('newCommunityBuild_'.$communityId);
        if(!Cache::has('newCommunityBuild_'.$communityId)){
            $info = DB::connection('mysql_house')->table('communitybuilding')->where('communityId',$communityId)->select('id','num','openTime','takeTime','unitTotal','floorTotal','houseTotal','liftHouseRatio','coordinateX','coordinateY','state')->get();
            Cache::put('newCommunityBuild_'.$communityId,$info,60);
        }else{
            $info = Cache::get('newCommunityBuild_'.$communityId);
        }
        return $info;
    }
	/**
	* 查询楼盘的户型信息
	* @param $communityId 楼盘id
	*/
//	public function getCommRoom($communityId) {
//		return DB::connection('mysql_house')
//		->table('communityroom')
//		->where('communityId',$communityId)
//		->select('id','name','cbIds','communityId','thumbPic','room','hall','toilet','kitchen','balcony','floorage','location')
//		->get();
//	}

	/**
	* 图片查询
	* @param int $communityId 楼盘id
	* @param int $type 图片类型
	* -------------------------------
	* 1.交通图 2.实景图 3.效果图
	* 4.样板间 6.配套图 7.施工进度图
	* 8.规划图
	* -----------------------------
	*/
	public function getCommImg($communityId,$type) {
		return DB::connection('mysql_house')
		->table('communityimage')
		->where('communityId',$communityId)
		->where('type',$type)
		->select('id','communityId','type','fileName')
		->get();
	}

	/**
	| 楼盘详情页DAO
	*/

//	/**
//	* 获取楼盘相关信息
//	* @param int $communityId 楼盘id
//	* @param array $select 查询字段
//	*/
//	public function getCommData($communityId,$select) {
//		return DB::connection('mysql_house')
//		->table('community')
//		->where('id',$communityId)
//		->select($select)
//		->get();
//	}

	/**
	* 查询项目特色
	* @param array $tagIds 标签id
	* +-----------------------+
	* | 查询type2下的项目特色 |
	* +-----------------------+
	*/
	public function getTagName($tagIds) {
		return DB::connection('mysql_house')
		->table('tag')
		->whereIn('id',$tagIds)
		->select('id','name')
		->get();
	}
	/**
	 * 查询自定义标签
	 * @param array $tagIds 标签id
	 * +-----------------------+
	 * | 查询type2下的项目特色 |
	 * +-----------------------+
	 */
	public function getDiyTagName($diyTags) {
		return DB::connection('mysql_house')
			->table('tagdiy')
			->whereIn('id',$diyTags)
			->lists('name');
	}
	/**
	* 查询城市环线名称
	* @param int $loopLineId 城市id
	*/
	public function getLoopLineName($loopLineId) {
		if(!Cache::has('loopLineName_'.$loopLineId)){
			$info = DB::connection('mysql_house')->table('loopline')->where('id',$loopLineId)->select('name')->get();
			Cache::put('loopLineName_'.$loopLineId,$info,60*24*30);
		}else{
			$info = Cache::get('loopLineName_'.$loopLineId);
		}
		return $info;
	}

	/**
	* 查询物业公司
	* @param int $propertyCompanyId 物业公司id
	*/
	public function getPropertyName($propertyCompanyId) {
		if(!Cache::has('communityPropertyName_'.$propertyCompanyId)){
			$info = DB::connection('mysql_house')->table('propertycompany')->where('id',$propertyCompanyId)->select('companyname')->get();
			Cache::put('communityPropertyName_'.$propertyCompanyId,$info,60*24*30);
		}else{
			$info = Cache::get('communityPropertyName_'.$propertyCompanyId);
		}
		return $info;
	}

	/**
	* 查询开发商
	* @param int $developerId 开发商id
	*/
	public function getDevelopersName($developerId) {
		if(!Cache::has('communityDevelopersName_'.$developerId)){
			$info = DB::connection('mysql_house')->table('developers')->where('id',$developerId)->select('companyname')->get();
			Cache::put('communityDevelopersName_'.$developerId,$info,60*24*30);
		}else{
			$info = Cache::get('communityDevelopersName_'.$developerId);
		}
		return $info;
	}



	/**
	| 户型信息页DAO
	*/

	/**
	* 获取楼盘下所有户型信息
	* @param int $communityId 楼盘id
	* @param array $select 查询字段
	*/
//	public function getCommunityRoom1($communityId,$select,$type2) {
//		Cache::pull('newCommunityRoom_'.$communityId.'_'.$type2);
//		if(!Cache::has('newCommunityRoom_'.$communityId.'_'.$type2)){
//			$info = DB::connection('mysql_house')->table('communityroom')->where('communityId',$communityId)->where('type2',$type2)->get();
//			Cache::put('newCommunityRoom_'.$communityId.'_'.$type2,$info,60);
//		}else{
//			$info = Cache::get('newCommunityRoom_'.$communityId.'_'.$type2);
//		}
//		return $info;
//	}
    /**
     * 获取楼盘下所有户型信息
     * @param int $communityId 楼盘id
     * @param array $select 查询字段
     */
    public function getCommunityRoom($communityId) {
        Cache::pull('newCommunityRoom_'.$communityId);
        if(!Cache::has('newCommunityRoom_'.$communityId)){
            $info = DB::connection('mysql_house')->table('communityroom')->where('communityId',$communityId)->get();
            Cache::put('newCommunityRoom_'.$communityId,$info,60);
        }else{
            $info = Cache::get('newCommunityRoom_'.$communityId);
        }
        return $info;
    }
	/**
	* 查询房源居室信息
	* @param int $communityId 楼盘id
	* @param int $houseRoom 居室数
	* @param array $select 查询字段
	*/
	public function getHouseSale($communityId,$houseRoom,$select) {
		return DB::connection('mysql_house')
		->table('housesale')
		->where('communityId',$communityId)
		->where('houseRoom',$houseRoom)
		->select($select)
		->limit(5)
		->get();
	}

	/**
	| 相册信息页DAO
	*/

	/**
	* 图片查询
	* @param int $communityId 楼盘id
	* @param int $type 图片类型
	* -------------------------------
	* 1.交通图 2.实景图 3.效果图
	* 4.样板间 6.配套图 7.施工进度图
	* 8.规划图
	* -----------------------------
	*/
	public function getCommTypeImg($communityId,$type) {
		return DB::connection('mysql_house')
		->table('communityimage')
		->where('communityId',$communityId)
		->where('type',$type)
		->select('id','communityId','type','fileName','note')
		-> paginate(12);
	}

	/**
	* 查询楼盘下所有图片(用来统计各类型图片数量)
	* @param int $communityId 楼盘id array(10,3,4,8,1,6,2,9)
	*/
	public function getCommImgTotal($communityId,$type2) {
		if(!Cache::has('xcommunityimage_'.$communityId.'_'.$type2)){
			$info = DB::connection('mysql_house')->table('communityimage')->where('communityId',$communityId)->where('cType2',$type2)->select('id','communityId','type','fileName')->get();
			Cache::put('xcommunityimage_'.$communityId.'_'.$type2,$info,60*24*30);
		}else{
			$info =  Cache::get('xcommunityimage_'.$communityId.'_'.$type2);
		}
		return $info;
	}

	/**
	 * 获取经纪人在该楼盘的带看次数 xcy
	 * @param $brokerId  经纪人id
	 * @param $communityId 楼盘id
	 * @return mixed
	 */
//	public function getClientCountBycuid($brokerId,$communityId){
//		return DB::connection('mysql_user')
//			->table('client_flow2 as c')
//			->leftJoin('client_itention as i', DB::raw('c.clientItentionId'), '=', DB::raw('i.id'))
//			->where('i.brokerId',$brokerId)
//			->where('i.communityId',$communityId)
//			->count();
//	}

	/**
	 * 根据id获取该公司的logo
	 * @param $shopid 分销商公司id
	 */
	public function getShopLogoById($shopid){
		if(!Cache::has('enterpriseShopById_'.$shopid)){
			$info = DB::connection('mysql_user')->table('enterpriseshop')->where('id',$shopid)->pluck('logo');
			Cache::put('enterpriseShopById_'.$shopid,$info,60*24);
		}else{
			$info =  Cache::get('enterpriseShopById_'.$shopid);
		}
		return $info;
	}

	/**
	 * 用户登录后,获取该用户所关注的楼盘
	 * @param $where
	 * @return mixed
	 */
	public function getInterestByUid($where){
		return DB::connection('mysql_user')->table('userinterest')->where($where)->lists('interestId');
	}
}
?>