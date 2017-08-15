<?php
namespace App\Dao\Agent;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
* 增量
* @since 1.0楼盘库
* @author liyang
*/

class NewBuildingCreateDao {
	

	// 查询province表所有省份
	public function getProv() {
		// if(Cache::get('province_info')){
			// return Cache::get('province_info');
		// }
		$province = DB::connection('mysql_house')->Select('SELECT id,name,districtId FROM province');
		// Cache::put('province_info', $province, 1440);
		return $province;


	}

	// 查询city表相关城市
	public function getCity($provinceId) {
		// if(Cache::get('city_info')){
			// return Cache::get('city_info');
		// }
		$cityData = DB::connection('mysql_house')->Select('SELECT id,name,provinceId FROM city WHERE provinceId = ? ', array($provinceId));
		// Cache::put('city_info', $cityData, 1440);
		return $cityData;
	}

	// 查询loopline表环线信息
	public function getLoopLine($cityId) {
		// if(Cache::get('loopline_info')){
			// return Cache::get('loopline_info');
		// }
		$loopline = DB::connection('mysql_house')->Select('SELECT id,name FROM loopline WHERE cityId = ?', array($cityId));
		// Cache::put('loopline_info', $loopline, 1440);
		return $loopline;
	}

	// 查询cityarea表相关城区
	public function getCityArea($cityId){
		// if(Cache::get('city_area')){
			// return Cache::get('city_area');
		// }
		$cityAreaData = DB::connection('mysql_house')->Select('SELECT id,name,cityId FROM cityarea WHERE cityId = ?', array($cityId));
		// Cache::put('city_area', $cityAreaData, 1440);
		return $cityAreaData;
	}

	// 查询businessarea表相关商圈
	public function getBusinessArea($cityAreaId){
		// if(Cache::get('business_area')){
			// return Cache::get('business_area');
		// }
		$businessArea = DB::connection('mysql_house')->Select('SELECT id,name,cityAreaId FROM businessarea WHERE cityAreaId = ?', array($cityAreaId));
		// Cache::put('business_area', $businessArea, 1440);
		return $businessArea;
	}

	/**
	* 根据获得的楼盘id查出相关信息
	* @param int $id 楼盘id
	*/
	public function getComm($id){
		return DB::connection('mysql_newhouse0')->table('community')->where('id',$id)->select('allFloorArea','note','developerId','projectCompanyId','investCompanyId','supervisionCompanyId','landscapeCompanyId','architecturalPlanningCompanyId','constructionCompanyId')->get();
	}

	/**
	* 查出商家name
	* @param string $tableName 表名称
	* @param int $id 商家id
	*/
	public function getCompanyName($tableName,$id){
		return DB::connection('mysql_house')->table($tableName)->where('id',$id)->select('id','companyname')->get();
	}

	/**
	* 获取楼盘表相关信息
	* @param int $id 楼盘id 
	*/
	public function getCommunityStatis($id){
		// return DB::connection('mysql_house')->table('community')->where('id',$id)->select('id','name','type1','type2','developerId','projectCompanyId','investCompanyId','supervisionCompanyId','landscapeCompanyId','architecturalPlanningCompanyId','constructionCompanyId','type101Info','type102Info','type103Info','type104Info','type105Info','type106Info','type201Info','type203Info','type204Info','type301Info','type302Info','type303Info','type304Info','type305Info')->get();
		if(!empty($id)){
			return DB::connection('mysql_newhouse0')->select( " select id, type2, type101Info, type102Info, type103Info, type104Info, type105Info, type106Info, type201Info, type203Info, type204Info, type301Info, type302Info, type303Info, type304Info, type305Info, type306Info, type307Info, IF( developerId <> 0 and projectCompanyId <> 0 and investCompanyId <> 0 and supervisionCompanyId <> 0 and landscapeCompanyId <> 0 and architecturalPlanningCompanyId <> 0 and constructionCompanyId <> 0  , true, false) as score from community where id in(".$id.")");
		}
		
	}

	/**
	* 查询学区表相关信息
	* @param int $type 1.幼儿园,2.小学,3.初中,4.高中
	*/
	public function getSchool($type){
		return DB::connection('mysql_house')->table('school')->where('type',$type)->select('id','name')->get();
	}

	/**
	* 查询学区表相关信息
	* @param array $id 
	*/
	public function getSchoolId($id){
		return DB::connection('mysql_house')->table('school')->whereIn('id',$id)->select('id','name', 'type')->get();
	}


	/**
	* 根据获取的type2查询 typeInfo 的信息
	* @param int $id 要查询的楼盘id
	* @param int $tyoe2 要查询的type2基础信息
	*/
	public function getTypeInfo($id,$type){
		return DB::connection('mysql_newhouse0')->table('community')->where('id',$id)->select('type'.$type.'Info')->get();
	}

	/**
	* 根据不同条件筛选出楼盘表的对应信息
	* @param array $query 不确定个数的查询条件拼成的数组
	*/
	public function getCommunity($query){
		if(!empty($query['name']) && !empty($query['timeStart']) && !empty($query['timeEnd']) && !empty($query['type1'])){
			return DB::connection('mysql_newhouse0')->table('community')->where('name','like','%'.$query['name'].'%')->whereBetween('timeCreate', [$query['timeStart'], $query['timeEnd']])->where('type1','like','%'.$query['type1'].'%')->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else if(!empty($query['name']) && !empty($query['timeStart']) && !empty($query['timeEnd'])){
			return DB::connection('mysql_newhouse0')->table('community')->where('name','like','%'.$query['name'].'%')->whereBetween('timeCreate', [$query['timeStart'], $query['timeEnd']])->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else if(!empty($query['name']) && !empty($query['type1'])){
			return DB::connection('mysql_newhouse0')->table('community')->where('name','like','%'.$query['name'].'%')->where('type1','like','%'.$query['type1'].'%')->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else if(!empty($query['type1']) && !empty($query['timeStart']) && !empty($query['timeEnd'])){
			return DB::connection('mysql_newhouse0')->table('community')->where('type1','like','%'.$query['type1'].'%')->whereBetween('timeCreate', [$query['timeStart'], $query['timeEnd']])->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else if(!empty($query['name'])){
			return DB::connection('mysql_newhouse0')->table('community')->where('name','like','%'.$query['name'].'%')->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else if(!empty($query['timeStart']) && !empty($query['timeEnd'])){
			return DB::connection('mysql_newhouse0')->table('community')->whereBetween('timeCreate', [$query['timeStart'], $query['timeEnd']])->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else if(!empty($query['type1'])){
			return DB::connection('mysql_newhouse0')->table('community')->where('type1','like','%'.$query['type1'].'%')->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}else{
			return DB::connection('mysql_newhouse0')->table('community')->Select('id','name','type1','type2','provinceId','cityId','cityAreaId','businessAreaId','address','longitude','latitude','timeCreate')->paginate(10);
		}
		
	}

	// 存储新增楼盘基础信息到数据库
	public function insertComm($data){
		$insertcomm = DB::connection('mysql_newhouse0')->table('community')->insertGetId($data);
		return $insertcomm;
	}

	// 查询刚存入的楼盘表id
	public function getCommunityId(){
		$communityId = DB::connection('mysql_newhouse0')->Select('SELECT last_insert_id() AS communityId FROM community WHERE id = last_insert_id()');
		return $communityId;
	}

	// 查询楼盘表的type2信息
	public function getType2($id){
		return DB::connection('mysql_newhouse0')->select('SELECT type2 FROM community WHERE id =?',array($id));
	}

	// 存储楼栋信息到数据库
	public function insertBuild($data){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')->insertGetId($data);
	}

	// 存储单元表
	public function insertUnit($data){
		return DB::connection('mysql_newhouse0')->table('communityunit')->insert($data);
	}

	/**
	* 查询要修改的楼栋信息
	* @param int $id 楼栋id
	*/
	public function getOneBuild($id){
		return DB::connection('mysql_newhouse0')->Select('SELECT num,unitTotal FROM communitybuilding WHERE id = ?',array($id));
	}

	/**
	* 更改单元表信息
	* @param int $id 单元id
	* @param array 更改的键/值(数据库字段,要存入的值)
	*/
	public function updateUnit($id, $info){
		return  DB::connection('mysql_newhouse0')->table('communityunit')->where('id',$id)->update($info);
	}

	/**
	* 删除一条信息
	* @param string $tableName 要删除的表名称
	* @param string $whereName 要删除的表字段
	* @param $id 要删除条件
	* @return bool
	*/
	public function delete($tableName,$whereName,$id){
		return DB::connection('mysql_newhouse0')->delete("DELETE FROM $tableName WHERE $whereName = $id");
	}

	/**
	* 查询楼栋表信息
	* @param int $communityId 楼盘id
	* @param int $type2 具体的某一个type2
	*/
	public function getBuilding($communityId,$type2){
		// return DB::connection('mysql_house')->Select("SELECT id,communityId,type2,num,unitTotal,timeCreate FROM communitybuilding WHERE communityId = '$communityId' AND type2 = '$type2'");
		return DB::connection('mysql_newhouse0')->table('communitybuilding')
											->where('communityId',$communityId)
											->where('type2',$type2)
											->select('id','communityId','type2','num','unitTotal','timeCreate')
											->paginate(10);
	}

	/**
	* 查询一个楼盘下所有的楼栋信息
	* @param int $communityId 楼盘id
	*/
	public function getAllBuild($communityId){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')
											->where('communityId',$communityId)
											->select('id','num','coordinateX','coordinateY')
											->get();
	}

	/**
	* 存取楼栋标注坐标点
	* @param string $num 楼栋名称
	* @param array $buildData 需要update 的信息
	*/
	public function updateCoordinate($id,$buildData){
		return DB::connection('mysql_newhouse0')->table('communitybuilding')
											->where('id',$id)
											->update($buildData);
	}

	/**
	* 查询每个楼盘下的楼栋表中是否存在楼栋信息
	* @param int $communityId 楼栋表与楼盘表的关联id
	*/
	public function getBuildingType2($communityId){
		// return DB::connection('mysql_house')->table('communitybuilding')->where('communityId',$communityId)->select('type2')->get();
		if(!empty($communityId)){
			return DB::connection('mysql_newhouse0')->select('select communityId, type2 from communitybuilding where communityId in ('.$communityId.')');
		}
		// return DB::connection('mysql_house')->select('select communityId, type2 from communitybuilding where communityId in ('.$communityId.')');
	}

	/**
	* 查询楼盘下是否有相关户型
	* @param int $communityId 户型表与楼盘表的关联id
	*/
	public function getRoomType2($communityId){
		// return DB::connection('mysql_house')->table('communityroom')->where('communityId',$communityId)->select('type2')->get();
		if(!empty($communityId)){
			return DB::connection('mysql_newhouse0')->select('select communityId, type2 from communityroom where communityId in ('.$communityId.')');
		}
	}

	/**
	* 查询楼盘不同type图片
	* @param int $type 图片类型
	*/
	public function getTitlePic($type){
		return DB::connection('mysql_newhouse0')->table('communityimage')
												->where('type',$type)
												->select('id','communityId','type','fileName')
												->get();
	}

	/**
	* 查询楼盘下是否有相关图片
	* @param int $communityId 图片表与楼盘表的关联id
	*/
	public function getImageCtype2($communityId){
		// return DB::connection('mysql_house')->table('communityimage')->where('communityId',$communityId)->select('cType2')->get();
		if(!empty($communityId)){
			return DB::connection('mysql_newhouse0')->select('select communityId, cType2 from communityimage where communityId in('.$communityId.')');
		}
	}

	// 查询单元信息
	public function getUnit(){
		//return DB::connection('mysql_house')->Select('SELECT num,floorTotal,houseTotal,liftRatio,note FROM communityunit WHERE bId = ?', array($bId));
		// return DB::connection('mysql_house')->Select('SELECT * FROM communityunit');
		return DB::connection('mysql_newhouse0')->table('communityunit')
											->select('id','bId','num','liftRatio','floorTotal','houseTotal','note','timeCreate')
											->get();
	}

	// 查询楼栋号是否存在
	public function checkBuildName($communityId,$build_name){
		$buildName = DB::connection('mysql_newhouse0')->Select("SELECT num FROM communitybuilding WHERE communityId = '$communityId' AND num = '$build_name'");
		return $buildName;
	}


	// 根据获取的开发商名称查出开发商id
	public function getDeveloperId($tableName,$wordName,$getName){
		return DB::connection('mysql_house')->Select("SELECT id FROM $tableName WHERE $wordName = '$getName'");
	}

	/**
	* 存入共有信息公司的名称,并返回存入时的id
	* @param $tableName 表名称
	* @param $data 要存入的数据
	* @return int id 刚存入的id
	*/
	public function insertCompany($tableName,$data){
		return DB::connection('mysql_house')->table($tableName)->insertGetId($data);
	}
	// 查询刚存入的id
	public function LastInsertId($tableName){
		$developerId = DB::connection('mysql_house')->Select("SELECT last_insert_id() AS id FROM $tableName WHERE id = last_insert_id()");
		return $developerId;
	}
	// 根据获取的项目名称获取项目id
	public function getProjectId($developerId,$projectName){
		$projectId = DB::connection('mysql_house')->Select("SELECT id FROM developers where parentId = '$developerId' AND companyname = '$projectName'");
		return $projectId;
	}
	// 查询不到填写项目存入填写的项目
	public function insertProject($developerId,$projectCompanyName){
		$project = DB::connection('mysql_house')->Insert("INSERT INTO developers (parentId,companyname) VALUES('$developerId','$projectCompanyName')");
		return $project;
	}
	// 查询投资商id
	public function getInvestId($investCompanyName){
		$investId = DB::connection('mysql_house')->Select("SELECT id FROM investcompany WHERE name = '$investCompanyName'");
		return $investId;
	}
	// 查询id
	public function getInfoId($tableName,$name){
		$getInfoId = DB::connection('mysql_house')->Select("SELECT id FROM $tableName WHERE name = '$name'");
		return $getInfoId;
	}
	// 存入一条数据
	public function insertOne($tableName,$typename,$name){
		$insertOne = DB::connection('mysql_house')->Insert("INSERT INTO $tableName ($typename) VALUES('$name')");
		return $insertOne; 
	}

	/**
	* 存入一条数据学区学校信息
	* @param array $data
	*/
	public function insertSchool($data){
		return DB::connection('mysql_house')->table('school')->Insert($data);
	}
	// 存入投资商
	public function insertInvest($investCompanyName){
		$insertInvest = DB::connection('mysql_house')->Insert("INSERT INTO investcompany (name) VALUES('$investCompanyName')");
		return $insertInvest;
	}
	/**
	* 查询communityroom表相关信息
	* @param int $communityId 楼盘id
	* @param int $type2 具体某一个type2
	* @return resource
	*/
	public function getCommunityRoom($communityId,$type2){
		return DB::connection('mysql_newhouse0')->table('communityroom')
											->where('communityId',$communityId)
											->where('type2',$type2)
											->select()
											->paginate(10);
	}
	/**
	* 查询楼盘点评表信息
	* @param int $communityId 楼盘id
	* @return array resource
	*/
	public function getComment($communityId){
		return DB::connection('mysql_newhouse0')->table('communitycomment')->where('communityId',$communityId)->select('id','uId','title','comment','timeCreate')->paginate(10);
	}
	/**
	* 存入点评信息
	* @param array $data
	*/
	public function insertComment($data){
		return DB::connection('mysql_newhouse0')->table('communitycomment')->Insert($data);
	}
	/**
	* 修改点评信息
	* @param array $data
	*/
	public function updateComment($id,$data){
		return DB::connection('mysql_newhouse0')->table('communitycomment')->where('id',$id)->update($data);
	}
	/**
	* 查询communityroom表要修改的一条信息(用来把要修改的信息展示给用户)
	* @param int $id 户型id
	* @return array resource
	*/
	public function getOneRoom($id){
		return DB::connection('mysql_newhouse0')->Select('SELECT name,room,hall,toilet,kitchen,balcony,faceTo,floorage,usableArea,num,state,price,feature,thumbPic,cbIds,unitIds FROM communityroom WHERE id = ?',array($id));
	}
	/**
	* 修改户型表信息
	* @param $id int 
	* @return bool
	*/
	public function updateRoom($id,$info){
		return DB::connection('mysql_newhouse0')->table('communityroom')->where('id',$id)->update($info);
	}
	/**
	* 更改楼盘表信息
	* @param int $id 楼盘id
	* @param array 存入的键/值(数据库字段,要存入的值)
	*/
	public function updateCommunity($id, $info){
		$updateCommunity = DB::connection('mysql_newhouse0')->table('community')->where('id',$id)->update($info);
		return $updateCommunity;
	}
	/**
	* 更改楼栋表信息
	* @param int $id 楼栋id
	* @param array 存入的键/值(数据库字段,要存入的值)
	*/
	public function updateBuild($id, $info){
		return  DB::connection('mysql_newhouse0')->table('communitybuilding')->where('id',$id)->update($info);
	}

	/**
	* 获取tag表数据
	* @param int $propertyType
	* @return 一条查询信息
	*/
	public function getTag($propertyType){
		return DB::connection('mysql_house')->Select('SELECT * FROM tag WHERE propertyType = ?', array($propertyType));
	}

	/**
	* 获取大板块(豪宅)数据
	*/
	public function getMacroplate(){
		return DB::connection('mysql_house')->Select('SELECT * FROM macroplate');
	}

	/**
	* 获取大商圈表数据
	*/
	public function getBusinesstags(){
		return DB::connection('mysql_house')->Select('SELECT * FROM businesstags');
	}

	/**
	* 存入一条数据并返回刚存入的id
	* @param string $tableName 表名称
	* @param array $data 要存入的数据
	* @return int id 返回存入的id
	*/
	public function getInsertLastId($tableName,$data){
		return DB::connection('mysql_house')->table($tableName)->insertGetId($data);
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
		return DB::connection('mysql_newhouse0')->table('communityimage')->where(['communityId'=>$communityId, 'cType2'=>$type2])->get(['id', 'type', 'fileName', 'note', 'cType2']);
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
	 * 根据id获得地理信息
	 * @param $id  传入相应楼盘的id
	 * @return object|bool	获取成功返回经纬度对象，获取失败返回false
	 * huzhaer  2016-1-7
	 */
	public function getGeoPointsById($id){
		//huzhaer   2016-1-7
		$points = DB::connection('mysql_newhouse0')->table('community')->where('id', $id)->get(['longitude','latitude']);
		if(isset($points)){
			return $points;
		}
		return false;
	}

	/**
	 * 地图周边信息存库函数，将周边信息存入aroundinfo表
	 * @param $data
	 * @return mixed
	 * huzhaer 2016-1-8
	 */
	public function insertMapAroundInfo($data){
		return DB::connection('communityaroundinfo')->table('communityaroundinfo')->Insert($data);
	}

	/**
	 * 获得地图周边信息对象,输入ID，有信息返回对象，没信息返回false
	 * @param $id
	 * @return object|bool
	 * huzhaer  2016-1-8
	 */
	public function getMapAroundInfoById($id){
		$aroundInfo = DB::connection('communityaroundinfo')
			          ->table('communityaroundinfo')
			          ->where('communityId',$id)
			          ->get(['bank','food','happy','hospital',
						  	'market','park','school','traffic']);
		if(isset($aroundInfo)){
			return $aroundInfo;
		}
		return false;
	}




	/**
	* 根据主键id删除记录
	* @author lixiyu 
	* @param string $tbname 表名 
	* @param int $id 要删除的主键id
	*/
	public function deleteInfo( $tbname, $id){
		return DB::connection('mysql_house')->table($tbname)->where('id', $id)->delete();
	}

	/**
	*  获取佣金方案
	* @author lixiyu 
	* @param int $communityId 楼盘id  developerId
	*/
	public function getCommission( $id ){
		return DB::connection('mysql_newhouse0')->table('developerscommission')->where('communityId', $id)->select('id', 'did', 'communityId', 'propertyTypeId', 'beginTime', 'endTime', 'settlement', 'schedule', 'suggestionName', 'percentage', 'commission', 'area')->paginate(10);
	}
	
	/**
	* 插入一条数据
	* @author lixiyu 
	* @param string $tbname 表名 
	* @param array $info 要插入的数据
	*/	
	public function insertInfo( $tbname, $info ){
		return DB::connection('mysql_newhouse0')->table($tbname)->insert( $info );
	}

	/**
	* 查询楼盘标注图片
	* @param int $id
	*/
	public function getBuildBackPic($communityId){
		return DB::connection('mysql_newhouse0')->table('community')->where('id', $communityId)->select('buildingBackPic')->get();
	}

	/**
	* 删除一条记录
	* @author lixiyu 
	* @param string $tbname 表名
	* @param int $id 主键id
	*/
	public function daleteInfo($tbname, $id){
		return DB::connection('mysql_newhouse0')->table($tbname)->where('id', $id)->delete();
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
	* 根据营销id 删除营销信息
	* @param int $id 营销信息id
	*/
	public function deleteSale($id){
		return DB::connection('mysql_newhouse0')->table('communityperiods')->where('id', $id)->delete();
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
	* 获取单元信息
	* @param array $buildId  楼栋Id
	*/
	public function getUnitInfo($buildId){
		return DB::connection('mysql_newhouse0')->table('communityunit')->whereIn('bId', $buildId)->orderBy('num')->get(['id', 'bId', 'num', 'liftRatio', 'floorTotal', 'houseTotal', 'note']);
	}

	/**
	* 根据户型id获取户型图片
	* @param array $id 户型id
	*/
	public function getRoomImage( $id ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->whereIn('communityRoomId', $id)->get(['id', 'communityRoomId', 'fileName', 'note']);
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
	* 根据图片id获取户型图片
	* @param array $id 图片id
	*/
	public function selectRoomImage( $id ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->whereIn('id', $id)->get(['id', 'communityRoomId', 'fileName', 'note']);
	}

	/**
	* 删除户型图片
	* @param array $id 户型图片id
	*/
	public function deleteRoomImage( $id ){
		return DB::connection('mysql_newhouse0')->table('communityroomimage')->whereIn('id', $id)->delete();
	}

	/**
	* 根据户型Id 删除户型信息
	* @param int $id 户型id
	*/
	public function deleteRoomInfo($id){
		return DB::connection('mysql_newhouse0')->table('communityroom')->where('id', $id)->delete();
	}
}


?>