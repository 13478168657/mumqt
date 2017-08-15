<?php
namespace App\Dao\Agent;
use DB;

/**
* description of DynamicDao
* 动态信息管理 数据访问对象
* @author lixiyu
* @since 1.0
*/

class DynamicDao{
	

	/**
	* 获取楼栋信息
	* @author lixiyu
	* @param int $communityId 楼盘id 
	* @param int $type2 物业类型 副id   
	*/
	public function getCommunityBuild( $communityId, $type2 ){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')->where(['communityId'=>$communityId, 'type2'=>$type2])->select('id', 'num', 'unitTotal', 'timeCreate')->paginate(10);
	}

	/**
	* 获取单元信息
	* @param array $buildId  楼栋Id
	*/
	public function getUnitInfo($buildId){
		return DB::connection('mysql_newhouse0')->table('communityunit')->whereIn('bId', $buildId)->orderBy('num')->get(['id', 'bId', 'num', 'liftRatio', 'floorTotal', 'houseTotal', 'note']);
	}



	/**
	* 查询相应的楼栋信息
	* @param array $build 楼栋信息 key=>val
	*/
	public function getBuildInfo( $build ){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')->where($build)->get(['id']);
	}

	/**
	* 添加楼栋信息 并返回插入的id
	* @param array $build 楼栋信息  key=>val
	*/
	public function addBuildInfo( $build ){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')->insertGetId($build);
	}

	/**
	* 添加单元信息
	* @param array $unit 单元信息 key=>val
	*/
	public function addUnitInfo( $unit ){
		return DB::connection('mysql_newhouse0')->table('communityunit')->insert($unit);
	}


	/**
	* 获取户型信息
	* @param int $communityId 楼盘Id
	* @param int $type2 物业类型 副id  
	*/
	public function getRoomInfo( $communityId, $type2 ){
		return DB::connection('mysql_newhouse0')->table('communityroom')->where(['communityId'=>$communityId, 'type2'=> $type2])->paginate(10);
	}

	/**
	* 插入一条新户型 （动态管理信息）
	* @param array $room 
	*/
	public function insertRoom( $room ){
		return DB::connection('mysql_newhouse0')->table('communityroom')->insertGetId($room);
	}

	/**
	* 插入上传新户型的 户型图片
	* @param array $info
	*/
	public function insertRoomImage( $info ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->insert($info);
	}

	/**
	* 获取排期信息
	* @param int $communityId  楼盘id
	* @param string $type2  物业类型 副
	*/
	public function getPeriods( $communityId, $type2){
		return DB::connection('mysql_newhouse0')->table('communityperiods')->where(['communityId'=>$communityId, 'type2'=>$type2])->paginate(10);
	}


	/**
	* 获取楼栋　名称
	* @author lixiyu
	* @param int $communityId 楼盘id 
	* @param int $type2 物业类型 副id   
	*/
	public function getCommunityBuildName( $communityId, $type2 ){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')->where(['communityId'=>$communityId, 'type2'=>$type2])->get(['id', 'num']);
	}

	/**
	* 插入一条新的营销信息
	* @author lixiyu
	* @param array $sale 营销信息 key=>val 信息
	*/
	public function insertSaleInfo( $sale ){
		return DB::connection('mysql_newhouse0')->table('communityperiods')->insert($sale);
	}

	/**
	* 修改一条营销信息
	* @param array $sale  需要修改的信息  key => val
	* @param int $id 对应的id
	*/
	public function updateSaleInfo( $sale, $id ){
		return DB::connection('mysql_newhouse0')->table('communityperiods')->where('id', $id)->update($sale);
	}


	/**
	* 获取楼盘点评数据
	* @param int $uid 用户id
	*/
	public function getCommentInfo( $uid ){
		return DB::connection('mysql_newhouse0')->table('communitycomment')->where('uId', $uid)->paginate(10);
	}
	/**
	* 插入一条楼盘点评数据
	* @param array $comment  
	*/
	public function insertCommentBuild( $comment ){
		return DB::connection('mysql_newhouse0')->table('communitycomment')->insert($comment);
	}


	/**
	* 获取楼盘消息数据
	* @param int $uid 用户id
	*/
	public function getNewsInfo( $uid ){
		return DB::connection('mysql_newhouse0')->table('communitynews')->where('uId', $uid)->paginate(10);
	}
	/**
	* 插入一条楼盘消息数据
	* @param array $news 
	*/
	public function insertNewsBuild( $news ){
		return DB::connection('mysql_newhouse0')->table('communitynews')->insert($news);
	}

	/**
	* 删除楼栋信息
	* @param int $id 楼栋id
	*/
	public function deleteBuild( $id ){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')->where('id', $id)->delete();
	}

	/**
	* 删除单元信息
	* @param int $id 单元id
	*/
	public function deleteUnit( $id ){
		return DB::connection('mysql_newhouse0')->table('communityunit')->where('id', $id)->delete();
	}

	/**
	* 修改信息
	* @param string $tbname 表名
	* @param array $info 修改的数据
	* @param int $id 修改的主键id
	*/
	public function updateInfo( $tbname, $info, $id){
		return DB::connection('mysql_newhouse0')->table($tbname)->where('id', $id)->update($info);
	}

	/**
	* 根据户型id获取户型图片
	* @param array $id 户型id
	*/
	public function getRoomImage( $id ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->whereIn('communityRoomId', $id)->get(['id', 'communityRoomId', 'fileName', 'note']);
	}

	/**
	* 删除户型图片
	* @param array $id 户型图片id
	*/
	public function deleteRoomImage( $id ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->whereIn('id', $id)->delete();
	}

	/**
	* 根据图片id获取户型图片
	* @param array $id 图片id
	*/
	public function selectRoomImage( $id ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->whereIn('id', $id)->get(['id', 'communityRoomId', 'fileName', 'note']);
	}

	/**
	* 根据户型Id 删除户型信息
	* @param int $id 户型id
	*/
	public function deleteRoomInfo($id){
		return DB::connection('mysql_newhouse0')->table('communityroom')->where('id', $id)->delete();
	}

	/**
	* 根据营销id 删除营销信息
	* @param int $id 营销信息id
	*/
	public function deleteSale($id){
		return DB::connection('mysql_newhouse0')->table('communityperiods')->where('id', $id)->delete();
	}







	/**
	* 获取楼盘包含物业类型
	* @author lixiyu
	* @param int $id 楼盘小区Id
	*/
	public function getCommunityType($id){
		return DB::connection('mysql_newhouse0')->table('community')->where('id', $id)->get(['name', 'type1', 'type2']);
	}

	/**
	* 将新添加的房源图片路径写入数据库
	* @author lixiyu
	* @param $data
	*/
	public function insertCommunityImg( $data ){
		return DB::connection('mysql_newhouse0')->table('communityimage')->insert($data);
	}

	/**
	* 获取房源图片信息
	* @author lixiyu
	* @param  int  $userId  用户id
	* @param  int $communityId  楼盘id
	* @param  int $type2    物业 副类型
	*/
	public function getCommunityImg( $userId, $communityId, $type2){
		return DB::connection('mysql_newhouse0')->table('communityimage')->where(['uid'=>$userId, 'communityId'=>$communityId, 'cType2'=>$type2])->get(['id', 'type', 'fileName', 'note', 'cType2']);
	}

	/**
	* 删除房源图片
	* @author lixiyu
	* @param int $imgId  图片id
	*/
	public function deleteCommunityImg( $imgId ){
		return DB::connection('mysql_newhouse0')->table('communityimage')->whereIn('id', $imgId)->delete();
	}

	/**
	* 获取房源图片路径
	* @author lixiyu
	* @param int $imgId 图片id
	*/
	public function getImgPath( $imgId ){
		return DB::connection('mysql_newhouse0')->table('communityimage')->whereIn('id', $imgId)->get(['fileName']);
	}

	/**
	* 修改房源图片信息
	* @author lixiyu
	* @param int $id  图片id
	* @param array $info 图片信息
	*/
	public function editImgInfo( $id, $info){
		return DB::connection('mysql_newhouse0')->table('communityimage')->where('id', $id)->update($info);
	}

	/**
	* 获取动态维护信息
	* @param array $where 营销排期信息where 条件
	*/
	public function getDynamicInfo($where){
		return DB::connection('mysql_newhouse0')->table('communityperiodslog')->where($where)->orderBy('timeCreate', 'DESC')->select('id', 'periodId', 'detail', 'state', 'timeCreate')->paginate(3);
	}

	/**
	* 插入一条动态维护信息
	* @param array  $info  营销排期信息
	*/
	public function insertDynamicInfo($info){
		return DB::connection('mysql_newhouse0')->table('communityperiodslog')->insertGetId($info);
	}

	/**
	* 删除一条排期记录信息
	* @param int $id 排期记录id 
	*/
	public function deletePeriodsLog($id){
		return DB::connection('mysql_newhouse0')->table('communityperiodslog')->where('id', $id)->delete();
	}

	/**
	* 获取动态维护信息翻页信息
	* @param array $where  筛选条件
	* @param array $limit 翻页条件
	*/
	public function getPageTurn( $where, $limit){
		return DB::connection('mysql_newhouse0')->table('communityperiodslog')->where($where)->orderBy('timeCreate', 'DESC')->skip($limit[0])->take($limit[1])->select('id', 'periodId', 'detail', 'state', 'timeCreate')->get();
	}

	/**
	* 获取动态维护信息总条目
	* @param array $where 营销排期信息where 条件
	*/
	public function getPeriodsCount($where){
		return DB::connection('mysql_newhouse0')->table('communityperiodslog')->where($where)->count();
	}

	/**
	* 根据主键id删除记录
	* @param string $tbname 表名 
	* @param int $id 要删除的主键id
	*/
	public function deleteInfo( $tbname, $id){
		return DB::connection('mysql_newhouse0')->table($tbname)->where('id', $id)->delete();
	}

	/**
	*  获取佣金方案
	* @param int $communityId 楼盘id  developerId
	*/
	public function getCommission( $id ){
		return DB::connection('mysql_newhouse0')->table('developerscommission')->where('communityId', $id)->select('id', 'did', 'communityId', 'propertyTypeId', 'beginTime', 'endTime', 'schedule', 'suggestionName', 'percentage', 'commission', 'areaBegin', 'areaEnd')->paginate(10);
	}
	
	/**
	* 插入一条数据
	* @param string $tbname 表名 
	* @param array $commission 佣金方案数据
	*/	
	public function insertInfo( $tbname, $commission ){
		return DB::connection('mysql_newhouse0')->table($tbname)->insert( $commission );
	}

}
