<?php 
namespace App\Http\Controllers\Agent;

use Auth;
use DB;
use App\Dao\Agent\NewBuildingCreateDao;
use App\Dao\City\CityDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\AreaUtil;
use App\Http\Controllers\User\UploadsController;
use App\Http\Controllers\Utils\UploadImgUtil;
use App\CommunityDataStructure;
use App\Http\Controllers\Utils\SafeUtil;

class NewBuildingCreateController extends Controller {
	protected $CreateDao;
	protected $CityDao;
	public function __construct() {
		$this->CreateDao = new NewBuildingCreateDao;
		$this->CityDao = new CityDao;
	}

	// 创建楼盘列表页
	public function buildList() {
		$title = '增量楼盘库-楼盘列表页';
		// dd($_POST);
		$query = array();
		if(!empty(Input::get('buildName'))){
			$name = Input::get('buildName');
			$query['name'] = $name;
		}
		if(!empty(Input::get('timeStart')) && !empty(Input::get('timeEnd'))){
			$timeStart = Input::get('timeStart');
			$timeEnd = Input::get('timeEnd');
			$query['timeStart'] = $timeStart;
			$query['timeEnd'] = $timeEnd;
		}
		if(!empty(Input::get('audit'))){
			$type1 = Input::get('audit');
			$query['type1'] = $type1;
		}
		
		// 查询楼盘表相关信息
		$community = $this->CreateDao->getCommunity($query);
		// dd($community);

		// 查询楼盘相册表(community)标题图片 type = 10 为标题图
		$communityimage = $this->CreateDao->getTitlePic('10');
		// dd($communityimage);
		foreach($community->items() as $ckey=>$comm){
			$comminfo = array();
			foreach($communityimage as $img){
				if($comm->id == $img->communityId){
					$comminfo[] = $img;
				}
			}
			$comm->titleImg = $comminfo;
		}
		// dd($community);

		/**
		* 将楼盘列表的地区信息(id) 罗列
		* @param obj $community  楼盘列表信息
		*/
		function getBuildAreaInfo( $community ){
			$area = array();
			foreach($community->items() as $val){
				// $area['provinceId'][] 		= $val->provinceId;
				$area['city'][] 			= $val->cityId;
				$area['cityArea'][] 		= $val->cityAreaId;
				$area['businessArea'][] 	= $val->businessAreaId;
			}
			return $area;
		}

		/**
		* 将获取的地区  省份/城市/城区/商圈（二维数组）转为一维数组 以id为键  name 为值
		* @param array $arrTwo_D 需要转换的二维数组
		*/
		function convert_Arr( $arrTwo_D ){
			$arrOne_D = array();
			foreach($arrTwo_D as $val){
				$arrOne_D[$val->id] = $val->name;
			}
			return $arrOne_D;
		}

		/**
		* 将获取的地区  省份/城市/城区/商圈  信息 插入到 楼盘列表信息中
		* @param obj $community  楼盘列表信息
		* @param array $area  地区信息
		*/
		function insert_areaInfo_to_build( $community, $area){
			foreach($community->items() as $key => $val){
				$val->cityName 				= $area['city'][$val->cityId];
				$val->cityAreaName 			= $area['cityArea'][$val->cityAreaId];
				$val->businessAreaName 		= @$area['businessArea'][$val->businessAreaId];
				$community->items()[$key] 	= $val;
			}
			return $community;
		}

		if(!empty($community->items())){
			$area 					= getBuildAreaInfo($community); // 将楼盘列表的地区信息罗列出来 
			$area['city'] 			= convert_Arr( $this->CityDao->getCityAll( $area['city'] ) ); // 获取城市
			$area['cityArea'] 		= convert_Arr( $this->CityDao->getCityAreaAll( $area['cityArea'] ) ); // 获取城区
			$area['businessArea'] 	= convert_Arr( $this->CityDao->getBusinessAreaAll( $area['businessArea'] ) ); // 获取商圈
			$community = insert_areaInfo_to_build( $community, $area);   // 将地区信息插入楼盘列表中
		}
		// dd($community);

		$statisId = $comma = '';
		if(!empty($community->items())){
			foreach($community->items() as $cval){
				$statisId  .= $comma.$cval->id;
				$comma 		= ',';
			}
		}

		$statisComm = $this->CreateDao->getCommunityStatis($statisId);
		$statisBuild = $this->CreateDao->getBuildingType2($statisId);
		$statisRoom = $this->CreateDao->getRoomType2($statisId);
		$statisImage = $this->CreateDao->getImageCtype2($statisId);
		
		// dd($statisComm);

		foreach($community->items() as $key => $val){
			$val->type2 = explode('|', $val->type2);
			$val->score = 0;
			$val->statis = array();

			$c_statis = true;
			foreach($statisComm as $ckey => $cval){
				if($val->id == $cval->id){

					foreach($val->type2 as $t2val){
						$type2 = 'type'.$t2val.'Info';
						if(empty($cval->$type2)){
							$c_statis = false;
						}
					}
					$val->score = $c_statis ? 20 : 0;
					$val->score += $cval->score ? 20 : 0;

					$val->statis['comm'] = $cval;
					unset($statisComm[$key]);
				}
			}
			
			
			
			$b_type2 = array();
			foreach($statisBuild as $bkey => $bval){
				if($val->id == $bval->communityId){
					if(in_array($bval->type2, $b_type2)) continue;
					$b_type2[] = $bval->type2;
					
					$val->statis['build'][] = $bval;
					unset($statisBuild[$bkey]);
				}
			}

			$val->score += empty(array_diff ( $val->type2 , $b_type2)) ? 20 : 0;
			// dd($val->score);
			
			$r_type2 = array();
			foreach($statisRoom as $rkey => $rval){
				if($val->id == $rval->communityId){
					if(in_array($rval->type2, $r_type2)) continue;
					$r_type2[] = $rval->type2;
					
					$val->statis['room'][] = $rval;
					unset($statisRoom[$rkey]);
				}
			}

			$val->score += empty(array_diff ( $val->type2 , $r_type2)) ? 20 : 0;

			
			$i_type2 = array();
			foreach($statisImage as $ikey => $ival){
				if($val->id == $ival->communityId){
					// echo $ival->cType2;
					if(in_array($ival->cType2, $i_type2)) continue;
					
					$i_type2[] = $ival->cType2;
					
					$val->statis['image'][] = $ival;
					unset($statisImage[$ikey]);
				}
			}
			
			$val->score += empty(array_diff ( $val->type2 , $i_type2)) ? 20 : 0;

			$val->type2 = implode('|', $val->type2);
			$val->statis = json_encode($val->statis);
			$community->items()[$key] = $val;
		}

		// dd($community);
		// 删除楼盘
		if(!empty(Input::get('getdel'))){
			$getdel = Input::get('getdel');
			$this->CreateDao->delete('community','id',$getdel);
			return 1;
		}

		// 获取需要统计填写信息的楼盘id
		/*if(!empty(Input::get('statisId'))){
			// 获取需要统计的楼盘id
			$statisId = Input::get('statisId');
			// 查询出相关统计信息
			$statisComm = $this->CreateDao->getCommunityStatis($statisId);
			$statisBuild = $this->CreateDao->getBuildingType2($statisId);
			$statisRoom = $this->CreateDao->getRoomType2($statisId);
			$statisImage = $this->CreateDao->getImageCtype2($statisId);
			$data['statisComm'] = $statisComm;
			$data['statisBuild'] = $statisBuild;
			$data['statisRoom'] = $statisRoom;
			$data['statisImage'] = $statisImage;
			return $data;
		}*/



		// dd($community);
		return view('agent.newbuildingcreate.buildList',compact('title','community','name','timeStart','timeEnd','type1'));
	}

	// 创建楼盘类型,区域,名称,地址页
	public function addComm() {
		$title = '增量楼盘库-地区信息页';
		// 获取所有省份列表
		$province = $this->CreateDao->getProv();
		if(!empty($_POST)){
			if(!empty(Input::get('province'))){
				$provinceId = Input::get('province');
				$cityData = $this->CreateDao->getCity($provinceId); // 根据所选省份查出城市
				return $cityData;
			}else if(!empty(Input::get('cityid'))){
				$cityId = Input::get('cityid');
				$cityAreaData = $this->CreateDao->getCityArea($cityId); // 根据城市查城区
				$loopline = $this->CreateDao->getLoopLine($cityId); // 根据城市查出环线
				$data['cityAreaData'] = $cityAreaData;
				$data['loopline'] = $loopline;
				return $data;
			}else if(!empty(Input::get('cityareaid'))){
				$businessid = Input::get('cityareaid');
				$businessid = $this->CreateDao->getBusinessArea($businessid); // 根据城区查商圈
				return $businessid;
			}else{
				$data['type1'] = Input::get('type1');
				$data['type2'] = strrev(implode('|', str_split(strrev(Input::get('type2')), 3)));
				$data['loopLineId'] = Input::get('lop_id');
				$data['provinceId'] = Input::get('pro_id');
				$data['cityId'] = Input::get('cit_id');
				$data['cityAreaId'] = Input::get('cta_id');
				$data['businessAreaId'] = Input::get('bsa_id');
				$data['name'] = Input::get('build_name');
				$data['address'] = Input::get('address');
				$data['longitude'] = Input::get('longitude');
				$data['latitude'] = Input::get('latitude');
				// 存入获取基础信息楼盘表(community)并返回存储id
				$communityId = $this->CreateDao->insertComm($data);
				return $communityId;
			}
				
		}
		return view('agent.newbuildingcreate.addCommontInfo',compact('title','province'));
	}

	// 增量楼盘库信息共同信息页
	public function Comminfo() {
		$title = '增量楼盘库-基础信息页';

		$communityId = Input::get('communityId'); // 获取新创建楼盘id
		$type = $this->getPageType($communityId);
		// dd($type);
		$type2 = $type['pagetype'][2];
		$type2_data = $type['bar'];



		// 查询修改楼盘的共有信息展示给用户
		$oldCommunity = $this->CreateDao->getComm($communityId);
		// dd($oldCommunity);
		if(!empty($oldCommunity[0]->developerId && $oldCommunity[0]->allFloorArea)){
			$allFloorArea = $oldCommunity[0]->allFloorArea;
			$note = $oldCommunity[0]->note;
			$developerId = $oldCommunity[0]->developerId; // 开发商id
			$projectCompanyId = $oldCommunity[0]->projectCompanyId; // 项目公司id
			$investCompanyId = $oldCommunity[0]->investCompanyId; // 投资商id
			$supervisionCompanyId = $oldCommunity[0]->supervisionCompanyId; // 监理公司id
			$landscapeCompanyId = $oldCommunity[0]->landscapeCompanyId; // 景观公司id
			$architecturalPlanningCompanyId = $oldCommunity[0]->architecturalPlanningCompanyId; // 建筑公司id
			$constructionCompanyId = $oldCommunity[0]->constructionCompanyId; // 施工公司id

			$companyArr = [];
			$developer = $this->CreateDao->getCompanyName('developers',$developerId); // 开发商名称
			$projectCompany = $this->CreateDao->getCompanyName('developers',$projectCompanyId); // 项目公司名称
			$investCompany = $this->CreateDao->getCompanyName('investcompany',$investCompanyId); // 投资商名称
			$supervisionCompany = $this->CreateDao->getCompanyName('supervisioncompany',$supervisionCompanyId); // 监理公司名称
			$landscapeCompany = $this->CreateDao->getCompanyName('landscapecompany',$landscapeCompanyId); // 景观公司名称
			$architecturalPlanningCompany = $this->CreateDao->getCompanyName('architecturalplanningcompany',$architecturalPlanningCompanyId); // 建筑公司名称
			$constructionCompany = $this->CreateDao->getCompanyName('constructioncompany',$constructionCompanyId); // 施工公司名称
			$companyArr['developer'] = $developer[0]->companyname;
			$companyArr['projectCompany'] = $projectCompany[0]->companyname;
			$companyArr['investCompany'] = $investCompany[0]->companyname;
			$companyArr['supervisionCompany'] = $supervisionCompany[0]->companyname;
			$companyArr['landscapeCompany'] = $landscapeCompany[0]->companyname;
			$companyArr['architecturalPlanningCompany'] = $architecturalPlanningCompany[0]->companyname;
			$companyArr['constructionCompany'] = $constructionCompany[0]->companyname;
			$companyArr['allFloorArea'] = $allFloorArea;
			$companyArr['note'] = $note;
			// dd($companyArr);
		}

		if(!empty(Input::get('developer'))){
			$communityId 					  = Input::get('communityId');	// 楼盘id
			$developerName 					  = Input::get('developer');	// 开发商名称
			$projectCompanyName 			  = Input::get('project');		// 项目公司
			$investCompanyName 				  = Input::get('invest');		// 投资商
			$supervisionCompanyName 		  = Input::get('supervision');	// 监理公司
			$landscapeCompanyName 			  = Input::get('landscape');	// 景观设计公司
			$architecturalPlanningCompanyName = Input::get('architectural');// 建筑规划公司
			$constructionCompanyName 		  = Input::get('construction');	// 施工公司
			$allFloorArea 					  = Input::get('area');			// 总占地面积
			$note 							  = Input::get('intro');		// 楼盘总体介绍

			/**
			* 查询各种商家是否存在,不存在insert然后获取id
			* @param $company 提交获取的商家名称
			* @param $table_key 要存入的表的字段名称
			* @param $tableName 要存入的表的名称
			* @return 与表的商家名字对应的商家的id
			*/
			function checkCompany($company,$table_key,$tableName){
				if(!empty($company)){
					$create = new NewBuildingCreateDao;
					$companyId = $create->getDeveloperId($tableName,$table_key,$company);// 查询商id
					if(!empty($companyId)){
						$companyId = $companyId[0]->id;
					}else{
						$data[$table_key] = $company;
						$companyId = $create->insertCompany($tableName,$data);
					}
					return $companyId;
				}
			}

			// 判断开发商是否存在并获取他的id
			$developerId = checkCompany($developerName,'companyname','developers');
			// 判断项目公司
			if(!empty($projectCompanyName)){
				$projectCompanyId = $this->CreateDao->getProjectId($developerId,$projectCompanyName);
				if(!empty($projectCompanyId)){
					$projectCompanyId = $projectCompanyId[0]->id;
				}else{
					$data['parentId'] = $developerId;
					$data['companyname'] = $projectCompanyName;
					$projectCompanyId = $this->CreateDao->insertCompany('developers',$data);
				}
				// return $projectCompanyId;
			}
			// 判断投资商
			$investCompanyId 				= checkCompany($investCompanyName,'companyname','investcompany');
			// 判断监理公司
			$supervisionCompanyId   		= checkCompany($supervisionCompanyName,'companyname','supervisioncompany');
			// 判断景观设计公司
			$landscapeCompanyId             = checkCompany($landscapeCompanyName,'companyname','landscapecompany');
			// 判断建筑规划公司
			$architecturalPlanningCompanyId = checkCompany($architecturalPlanningCompanyName,'companyname','architecturalplanningcompany');
			// 判断施工公司
			$constructionCompanyId 			= checkCompany($constructionCompanyName,'companyname','constructioncompany');

			// 把要存入的信息存入一个关联数组
			if(!empty($developerId && $projectCompanyId && $investCompanyId && $supervisionCompanyId && $landscapeCompanyId && $architecturalPlanningCompanyId && $constructionCompanyId && $allFloorArea && $note)){
				$communityId = Input::get('communityId');
				$info['developerId'] 					= $developerId;
				$info['projectCompanyId'] 				= $projectCompanyId;
				$info['investCompanyId'] 				= $investCompanyId;
				$info['supervisionCompanyId'] 			= $supervisionCompanyId;
				$info['landscapeCompanyId'] 			= $landscapeCompanyId;
				$info['architecturalPlanningCompanyId'] = $architecturalPlanningCompanyId;
				$info['constructionCompanyId'] 			= $constructionCompanyId;
				$info['allFloorArea'] 					= $allFloorArea;
				$info['note'] 							= $note;
				$this->CreateDao->updateCommunity($communityId,$info);
			}
			
		}


		//获取地理信息
		//经纬度当做数组传入
		$geo = $this->CreateDao->getGeoPointsById($communityId);
		//对象转数组
		$geo = json_decode(json_encode($geo),true);
		if($geo){
			$jingduMap = $geo[0]['longitude'];
			$weiduMap  = $geo[0]['latitude'];
		}
		return view('agent.newbuildingcreate.CommontInfo',compact('title','type2_data','communityId','type2','companyArr','jingduMap','weiduMap'));
	}

	// 创建楼盘基础信息---详情信息页
	public function addBasicHouse() {
		$title = '增量楼盘库-详情信息页';

		$basic = true;
		$communityId = Input::get('communityId'); // 获取新创建楼盘id
		$type = $this->getPageType($communityId);
		// dd($type);
		$hosturl = '/addBasicHouse'; // 导航条href路径
		$pagetype = $type['pagetype']; // type1 和 type2 的信息
		$type2Info = $type['data']; // 所有type2 array 对应type1 下存在的type2
		$typeInfo = $type['pagetype'][2]; // 地址栏获取的type2
		$type2_data = $type['bar']; // 获取的type2中文导航条

		// 房屋类型
		$houseType = ['1'=>'错层','2'=>'跃层','3'=>'复式','4'=>'开间','5'=>'平层'];
		// 建筑结构
		$structure = ['1'=>'板楼','2'=>'塔楼','3'=>'砖楼','4'=>'砖混','5'=>'平房','6'=>'钢混','7'=>'塔板结合','8'=>'框架剪力墙','9'=>'其它'];
		// 装修状况
		$decoration = ['1'=>'毛坯','2'=>'简装修','3'=>'中装修','4'=>'精装修','5'=>'豪华装修'];
		// 供电,供水
		$powat = ['1'=>'市政','2'=>'其他'];
		// 供气
		$gasSupply = ['1'=>'管道','2'=>'其它','3'=>'无'];
		// 供暖
		$heatingSupply = ['1'=>'集中供暖','2'=>'小区供暖','3'=>'自采暖'];
		// 公共区域装修情况
		$decorationPublic = ['1'=>'毛坯','2'=>'中装修','3'=>'精装修'];
		// 使用区域装修情况
		$decorationUsedRange = ['1'=>'毛坯','2'=>'网格地板+吊顶'];
		// 建筑类别
		$roomType = ['1'=>'独栋','2'=>'双拼','3'=>'联排','4'=>'叠拼','5'=>'四合院'];

		$community = new CommunityDataStructure($typeInfo);
		$safeUtil = new SafeUtil;

		// 获取tag表查询信息
		$tag = $this->CreateDao->getTag($typeInfo);

		// 获取businesstags表查询信息
		$businesstags = $this->CreateDao->getBusinesstags();

		// 获取macroplate(大板块)表查询信息
		$macroplate = $this->CreateDao->getMacroplate();

		if(!empty($_POST)){
			// dd($_POST);
			if(!empty(Input::get('child'))){
				$child   = Input::get('child'); // 获取幼儿园学校(array)
			}
			if(!empty(Input::get('kid'))){
				$kid     = Input::get('kid'); // 获取小学学校(array)
			}
			if(!empty(Input::get('primary'))){
				$primary = Input::get('primary'); // 获取初中学校(array)
			}
			if(!empty(Input::get('height'))){
				$height  = Input::get('height'); // 获取高中学校(array)
			}
			

				/**
				* 获取学校id,如果不存在,新存入,然后在获取id
				* @param string $schoolName 学校名称
				* @param int $type 学校类型1.幼儿园 2.小学 3.初中 4.高中
				* @return int $id 获取的学校id
				*/
				function getSchoolId($schoolName,$type){
					if(!empty($schoolName)){
						$CreateDao = new NewBuildingCreateDao;
						$childId = $CreateDao->getInfoId('school',$schoolName); // 查询所填学校id是否存在
						if(empty($childId)){
							$data['type'] = $type;
							$data['name'] = $schoolName;
							$CreateDao->insertSchool($data);
							$childId = $CreateDao->getInfoId('school',$schoolName); // 查询刚存入的学校id
						}
						return $childId[0]->id;
					}
				}

			// 获取幼儿园id
			if(!empty($child)){
				foreach ($child as  $val) {
					if(!empty($val)){
						$schoolInfo[] = getSchoolId($val,'1');
					}
				}
			}

				// 获取小学id
			if(!empty($kid)){
				foreach ($kid as  $val) {
					if(!empty($val)){
						$schoolInfo[] = getSchoolId($val,'1');
					}
				}
			}

				// 获取初中id
			if(!empty($primary)){
				foreach ($primary as  $val) {
					if(!empty($val)){
						$schoolInfo[] = getSchoolId($val,'1');
					}
				}
			}
				// 获取高中id
			if(!empty($height)){
				foreach ($height as  $val) {
					if(!empty($val)){
						$schoolInfo[] = getSchoolId($val,'1');
					}
				}
			}

			if(!empty($schoolInfo)){
				$schoolIds = implode('|', $schoolInfo);
			}else{
				$schoolIds = '';
			}

			$community = new CommunityDataStructure($typeInfo);

			// 引入加密类
			$safeUtil = new SafeUtil;
			// 引入序列化类
			/***基础信息***/
			$community->officeLevel                           = Input::get('officeLevel'); // 写字楼等级
			$community->startTime                             = strtotime(Input::get('startTime')); // 开工时间
			$community->propertyYear                          = Input::get('propertyYear'); // 产权年限
			$community->endTime                               = strtotime(Input::get('endTime')); // 竣工时间
			$community->volume                                = Input::get('volume'); // 容积率
			$community->greenRate 	                          = Input::get('greenRate'); // 绿化率
			$community->floorage	                          = Input::get('floorage'); // 建筑面积
			$community->floorSpace	                          = Input::get('floorSpace'); // 占地面积
			$community->floorArea                             = Input::get('floorArea'); // 标准层面积
			$community->commercialArea                        = Input::get('commercialArea'); // 商业面积
			$community->officeArea                            = Input::get('officeArea'); // 办公面积
			$community->bayAreaMin	                          = Input::get('bayAreaMin'); // 开间面积(小)
			$community->bayAreaMax                            = Input::get('bayAreaMax'); // 开间面积(大)
			$community->isDivisibility	                      = Input::get('isDivisibility'); // 是否可隔层
			$community->decorationPublic	                  = Input::get('decorationPublic'); // 公共区域装修情况
			$community->decorationRemark                      = Input::get('decorationRemark'); // 装修描述
			$community->decorationUsedRange	                  = Input::get('decorationUsedRange'); // 使用区域装修情况
			$community->floorBearing	                      = Input::get('floorBearing'); // 楼层承重
			$community->decoration	                          = Input::get('decoration'); // 装修状况
			$community->homeDesignType                        = Input::get('homeDesignType'); // 房屋类别
			$community->houseTotal                            = Input::get('houseTotal'); // 总户数
			$community->getRate                               = Input::get('getRate'); // 得房率
			$community->roomType                              = Input::get('roomType'); // 建筑类别
			if(!empty(Input::get('trade'))){
				$community->trade	                          = implode("|", Input::get('trade')); // 适合行业(array)
			}
			if(!empty(Input::get('tagIds'))){
				$community->tagIds	                          = implode("|", Input::get('tagIds')); // 项目特色(array)
			}
			if(!empty(Input::get('diyTagIds'))){
				$community->diyTagIds	                      = implode("|", Input::get('diyTagIds')); // 自定义项目特色(array)
			}
			$community->businessTagId                         = Input::get('businessTagId'); // 大商圈
			$community->macroplateId                          = Input::get('macroplateId'); // 所属板块
			$community->supportService                        = Input::get('supportService'); // 服务配套设施
			$community->supportIndoor                         = Input::get('supportIndoor'); // 室内配套设施
			/***内部设施***/
			$community->structure                             = Input::get('structure'); // 建筑结构
			$community->wallOutside                           = Input::get('wallOutside'); // 建筑外墙
			$community->wallInside                            = Input::get('wallInside'); // 建筑内墙
			$community->coolingHeating                        = Input::get('coolingHeating'); // 制冷/采暖
			$community->powerSupply                           = Input::get('powerSupply'); // 供电
			$community->waterSupply                           = Input::get('waterSupply'); // 供水
			$community->gasSupply                             = Input::get('gasSupply'); // 供气
			$community->heatingSupply                         = Input::get('heatingSupply'); // 供暖
			$community->network                               = Input::get('network'); // 网络通讯
			$community->fireFighting                          = Input::get('fireFighting'); // 消防系统
			$community->security                              = Input::get('security'); // 安防系统
			$community->passengerLiftNum                      = Input::get('passengerLiftNum'); // 客梯个数
			$community->passengerLiftBrand                    = Input::get('passengerLiftBrand'); // 客梯品牌
			$community->goodsLiftNum                          = Input::get('goodsLiftNum'); // 货梯个数
			$community->goodsLiftBrand                        = Input::get('goodsLiftBrand'); // 货梯品牌
			$community->flooring                              = Input::get('flooring'); // 地板材料
			$community->airCondition                          = Input::get('airCondition'); // 空调描述
			/***楼层状况***/
			$community->totalFloor                            = Input::get('totalFloor'); // 总层数
			$community->groundFloor                           = Input::get('groundFloor'); // 地上层数
			$community->underGroundFloor                      = Input::get('underGroundFloor'); // 地下层数
			$community->floorHeight                           = Input::get('floorHeight'); // 标准层高
			$community->clearHeight                           = Input::get('clearHeight'); // 净层高
			$community->buildingHeight                        = Input::get('buildingHeight'); // 建筑高度
			$community->floorRemark                           = Input::get('floorRemark'); // 补充说明
			/***物业信息***/
			$community->propertyFee                           = Input::get('propertyFee'); // 物业费
			$community->parkingInfo                           = implode("_", Input::get('parkingInfo')); // 车位信息(array)
			$community->propertyRemark                        = Input::get('propertyRemark'); // 备注
			/***许可证信息***/
			$community->StateLandPermit                       = $safeUtil->encrypt(Input::get('StateLandPermit')); // 国有土地使用证
			$community->constructionLandUsePermit             = $safeUtil->encrypt(Input::get('constructionLandUsePermit')); // 建设用地规划许可证
			$community->constructionPlanningPermit            = $safeUtil->encrypt(Input::get('constructionPlanningPermit')); // 建筑工程规划许可证
			$community->buildingEngineeringConstructionPermit = $safeUtil->encrypt(Input::get('buildingEngineeringConstructionPermit')); // 建筑工程施工许可证
			$community->preSalePermit                         = $safeUtil->encrypt(Input::get('preSalePermit')); // 商品房预售许可证
			/***学区信息***/
			$community->schoolIds                             = $schoolIds; // 获取转化个时候的学区id
			/***项目介绍***/
			$community->intro                                 = Input::get('intro'); // 项目介绍
			
			
			// dd($community);
			$type2all = $community->serialize();
			$info['type'.$typeInfo.'Info'] = $type2all;
			// 把收集信息存入相关type2字段
			$this->CreateDao->updateCommunity($communityId,$info);
		}

		/**************************************
		* 如果详细信息已存,展示已存信息在页面 *
		**************************************/
		$typeNumInfo = 'type'.$typeInfo.'Info';
		// 查询出type2基础信息
		$basicInfo = $this->CreateDao->getTypeInfo($communityId,$typeInfo);
		// dd($basicInfo[0]->$typeNumInfo);
		if(!empty($basicInfo[0]->$typeNumInfo)){
			$typeGetInfo = $basicInfo[0]->$typeNumInfo;
			// 把查取的tyoe2反序列化
			$type2GetInfo = $community->unserialize($typeGetInfo);
			// dd($type2GetInfo);
			if($typeInfo == 301 || $typeInfo == 302 || $typeInfo == 303 || $typeInfo == 304 || $typeInfo == 305 || $typeInfo == 306 || $typeInfo == 307){
				// 查询学校信息
				$id = explode('|',$type2GetInfo->schoolIds);
				$getchild = $this->CreateDao->getSchoolId($id);
				
				// $getchild = $this->CreateDao->getSchool('1');
				foreach($getchild as $childk=>$child){
					$childInfo[$child->type][] = $child;
					
				}
				// dd($childInfo);
			}
			
		}


		return view('agent.newbuildingcreate.addBZz',compact('title','basic','communityId','pagetype','hosturl','type2','type2_data','type2Info','typeInfo','tag','businesstags','macroplate','type2GetInfo','houseType','structure','decoration','powat','gasSupply','heatingSupply','safeUtil','childInfo','getkid','getprimary','getheight','decorationPublic','decorationUsedRange'));
	}

	// 创建楼盘楼栋信息页
	public function addBuilding() {
		$title = '增量楼盘库-楼栋信息页';

			// $communityId = Input::get('communityId'); // 获取楼盘id
			// $type2       = Input::get('type2'); // 获取所选type2
			$building = true;
			$communityId = Input::get('communityId'); // 获取新创建楼盘id
			$type = $this->getPageType($communityId);
			$hosturl = '/addBuilding'; // 导航条href路径
			$pagetype = $type['pagetype']; // type1 和 type2 的信息
			$type2Info = $type['data']; // 所有type2 array 对应type1 下存在的type2
			$type1 = $type['pagetype'][1]; // 获取对应的type1
			$typeInfo = $type['pagetype'][2]; // 地址栏获取的type2
			$type2_data = $type['bar']; // 获取的type2中文导航条

			// 查询楼栋表相关数据
			$communitybuilding = $this->CreateDao->getBuilding($communityId,$typeInfo);
			// dd($communitybuilding->items());
			// 查询单元信息表
			$communityunit = $this->CreateDao->getUnit();
			// dd($communityunit);

			// 把楼栋关联单元的信息循环在一个大数组
			foreach($communitybuilding->items() as $bkey=>$build){
				$unitinfo = array();
				foreach($communityunit as $unit){
					if($build->id == $unit->bId){
						$unitinfo[] = $unit;
					}
				}
				$build->unit = $unitinfo;
				// $communitybuilding[$key] = $build;
			}
			// dd($communitybuilding);

			// 存取楼栋信息
			if(!empty(Input::get('build_name')) && !empty(Input::get('unit_total'))){
				$num = Input::get('build_name');
				$unitTotal = Input::get('unit_total');
				$type1 = Input::get('type1');
				$typeInfo = Input::get('type2_one');
				$data['communityId'] = $communityId;
				$data['type1']       = $type1;
				$data['type2']       = $typeInfo;
				$data['num']         = $num;
				$data['unitTotal']   = $unitTotal;
				$insertLastId = $this->CreateDao->insertBuild($data); // 存储楼栋信息并返回存入id
				return $insertLastId;
			}

			// 存储单元信息
			if(!empty(Input::get('unit_name'))){
				$insertLastId = Input::get('insertLastId'); // 刚存入的楼栋id
				$num          = Input::get('unit_name');  // 单元名称
				$floor_total  = Input::get('floor_total');// 单元层数
				$house_total  = Input::get('house_total');// 总户数
				$lift_ratio1  = Input::get('lift_ratio1');
				$lift_ratio2  = Input::get('lift_ratio2');
				$liftRatio    = "$lift_ratio1:$lift_ratio2";// 梯户配比
				$note_unit    = Input::get('note_unit');  // 备注

				$data['bId']= $insertLastId; // 楼栋id
				$data['num']         = $num;          // 单元名称 
				$data['floorTotal'] = $floor_total;  // 单元层数
				$data['houseTotal'] = $house_total;  // 总户数
				$data['liftRatio']   = $liftRatio;    // 楼梯配比
				$data['note']   = $note_unit;    // 备注
				$this->CreateDao->insertUnit($data);
			}

			// 修改楼栋信息
			if(!empty(Input::get('change_build_name'))){
				$id = Input::get('build_id');
				$num = Input::get('change_build_name');
				$unitTotal = Input::get('change_unitTotal');

				$info['id'] = $id;
				$info['num'] = $num;
				$info['unitTotal'] = $unitTotal;

				$this->CreateDao->updateBuild($id,$info);
				return $this->CreateDao->getOneBuild($id);
			}

			// 添加单元信息
			if(!empty(Input::get('add_build'))){
				$bId          = Input::get('build_id');
				$num          = Input::get('add_build');  // 单元名称
				$floor_total  = Input::get('add_unitTotal');// 单元层数
				$house_total  = Input::get('add_houseTotal');// 总户数
				$add_t1  	  = Input::get('add_t1');
				$add_t2  	  = Input::get('add_t2');
				$liftRatio    = "$add_t1:$add_t2";// 梯户配比
				$note_unit    = Input::get('add_note');  // 备注

				$data['bId']        = $bId;          // 楼栋id
				$data['num']        = $num;          // 单元名称 
				$data['floorTotal'] = $floor_total;  // 单元层数
				$data['houseTotal'] = $house_total;  // 总户数
				$data['liftRatio']  = $liftRatio;    // 楼梯配比
				$data['note']       = $note_unit;    // 备注
				$this->CreateDao->insertUnit($data);
			}

			// 修改单元信息
			if(!empty(Input::get('up_id')) && !empty(Input::get('up_build'))){
				$id = Input::get('up_id');   // 单元id
				$num          = Input::get('up_build');  // 单元名称
				$floor_total  = Input::get('up_unitTotal');// 单元层数
				$house_total  = Input::get('up_houseTotal');// 总户数
				$up_t1  = Input::get('up_t1');
				$up_t2  = Input::get('up_t2');
				$liftRatio    = "$up_t1:$up_t2";// 梯户配比
				$note_unit    = Input::get('up_note');  // 备注

				$info['id']         = $id;          // 楼栋id
				$info['num']        = $num;          // 单元名称 
				$info['floorTotal'] = $floor_total;  // 单元层数
				$info['houseTotal'] = $house_total;  // 总户数
				$info['liftRatio']  = $liftRatio;    // 楼梯配比
				$info['note']       = $note_unit;    // 备注
				
				// return $liftRatio;
				$this->CreateDao->updateUnit($id,$info);
			}
				
			// 删除一条单元信息
			if(!empty(Input::get('unit_id'))){
				$id = Input::get('unit_id');
				$this->CreateDao->delete('communityunit','id',$id);
			}

			// 删除一条楼栋信息
			if(!empty(Input::get('del_build_id'))){
				$build_id = Input::get('del_build_id');
				$this->CreateDao->delete('communitybuilding','id',$build_id);
				$this->CreateDao->delete('communityunit','bId',$build_id);
			}

		return view('agent.newbuildingcreate.addBanZz',compact('title','building','communityId','hosturl','pagetype','type2','type2_data','type1','type2Info','typeInfo','communitybuilding','communityunit','pages'));
	}

	// 标注楼栋信息页
	public function label() {
			$title = '增量楼盘库-楼栋标注信息页';
			$buildingtag = true;
			$communityId = Input::get('communityId'); // 获取新创建楼盘id
			$type = $this->getPageType($communityId);
			$hosturl = '/addBuilding'; // 导航条href路径
			$pagetype = $type['pagetype']; // type1 和 type2 的信息
			$type2Info = $type['data']; // 所有type2 array 对应type1 下存在的type2
			$type1 = $type['pagetype'][1]; // 获取对应的type1
			$typeInfo = $type['pagetype'][2]; // 地址栏获取的type2
			$type2_data = $type['bar']; // 获取的type2中文导航条
			$allBuild = $this->CreateDao->getAllBuild($communityId); // 查出对应楼盘下所有楼栋
			$buildBackPic = $this->CreateDao->getBuildBackPic($communityId)[0]; // 查询对应楼盘标注图
			if(!empty(Input::get('mapInfo'))){
				// $communityId = Input::get('communityId');
				// $backImage = Input::get('backImage');
				// $upload = new UploadImgUtil;
				// $upload->setPhotoType( 'label' ); // 存储图片的文件名称
				// $upload->setFix();
				// $upload->setImgPath( 222 ); // 用户id
				// $imgPath = $upload->save_64_Img($backImage);
				// $info['buildingBackPic'] = $imgPath;
				// $this->CreateDao->updateInfo('community',$info,$communityId); // 保存楼栋标注背景图

				$mapInfo = Input::get('mapInfo');
				foreach ($mapInfo as $value) {
					$id = $value['id'];
					$coordinateX = $value['x'];
					$coordinateY = $value['y'];
					$buildData['coordinateX'] =  $coordinateX;
					$buildData['coordinateY'] =  $coordinateY;
					$this->CreateDao->updateCoordinate($id,$buildData);
				}
				return '保存成功!';
			}

		return view('agent.newbuildingcreate.label',compact('title','communityId','buildBackPic','buildingtag','typeInfo','type2_data','allBuild'));
	}

	// 增量楼盘库户型信息页
	public function addRoom() {
		$title = '增量楼盘库-户型信息页';
		$communityId = Input::get('communityId'); // 获取新创建楼盘id

		//获取物业类型信息
		$info 		= $this->getPageType($communityId);

		//获取户型信息
		$roomInfo 	= $this->CreateDao->getRoomInfo($communityId, $info['pagetype'][2]);

		$roomInfo->roomId = array();
		foreach($roomInfo  as $key => $val){
			$roomInfo->roomId[] = $val->id;
		}


		// 获取楼栋名称
		$buildInfo = $this->CreateDao->getCommunityBuildName($communityId, $info['pagetype'][2]);
		foreach( $buildInfo as $bval ){
			$roomInfo->build[] = array('id'=>$bval->id, 'num'=>$bval->num );
			$roomInfo->buildId[] = $bval->id;
		}
		if(empty($roomInfo->buildId)){
			$roomInfo->buildId = array();
		}

		$unitInfo = $this->CreateDao->getUnitInfo( $roomInfo->buildId );
		// dd($unitInfo);


		//获取户型图
		$roomImage = $this->CreateDao->getRoomImage( $roomInfo->roomId );

		$unit = array();
		foreach( $unitInfo as $uval){
			$unit[$uval->bId][] = $uval;
		}
		// dd($unit);
		foreach($roomInfo->items() as $k => $v){
			$v->cbIds = explode('|', $v->cbIds);
			$v->unitIds = explode('|', $v->unitIds);
			$v->bname = $comma = '';
			foreach($roomInfo->build as $rv){
				if( in_array($rv['id'], $v->cbIds)){
					$v->bname .= $comma.$rv['num'].'号楼';
					$comma = ',';
				}
			}
			$v->roomimage = array();
			foreach($roomImage as $imagekey => $imageval){
				if($imageval->communityRoomId == $v->id){
					$v->roomimage[] = $imageval;
					unset($roomImage[$imagekey]);
				}
			}
			$roomInfo->items()[$k] = $v;
		}
		// dd($roomInfo);
		$roomInfo->appends(['communityId'=>$communityId, 'type'=>$info['pagetype'][2] ])->render();
		
		return view('agent.newbuildingcreate.addleyoutZz', ['title'=>$title, 'huxing'=>true,'houseroom'=>true, 'communityId'=>$communityId, 'room'=>$roomInfo, 'unit'=>$unit, 'data'=>$info['data'], 'type2_data'=>$info['bar'],'typeInfo'=>$info['pagetype'][2], 'pagetype'=>$info['pagetype'], 'hosturl'=>'/addRoom']);

		// return view('agent.newbuildingcreate.addleyoutZz',compact('title','houseroom','communityId','type2_data','type2Info','communityroom','typeInfo','communitybuilding','faceTo'));
	}

	/**
	* ajax 添加户型信息
	*/
	public function addHuXing(){
		$room = $this->getRoomInfo();
		$userId = 12; //用户id
		$delImg = $room['delImg']; 
		unset($room['delImg']);


		if(!empty($delImg)){
			$this->deleteRoomImage($delImg);
		}

		$id = $room['rId'];  
		unset($room['rId']);
		
		// 当id 为空时，是添加
		if(empty($id)){
			if(!empty($room['thumbPic'])){
				$upload = new UploadImgUtil;
				$info = array();
				foreach($room['thumbPic'] as $val){
					if(empty($val)) continue;
					$val['fileName'] = $val['img'];
					unset($val['img']);
					$info[] = $val;
				}
				if(!empty($info))
				$room['thumbPic'] = $info[0]['fileName'];
				$info[0]['isTitlePic'] = 1;
			}

			$roomId = $this->CreateDao->insertRoom($room);
			if(!empty($info) && !empty($roomId)){
				foreach($info as $key => $val){
					$val['communityRoomId'] = $roomId;
					if(empty($val['isTitlePic'])){
						$val['isTitlePic'] = 0;
					}
					$info[$key] = $val;
				}
				$this->CreateDao->insertRoomImage($info);
			}
			return 1;
		}


		// 以下是修改户型
		if(!empty($room['thumbPic'])){
			$upload = new UploadImgUtil;
			$info = array();
			
			foreach($room['thumbPic'] as $val){
				if(empty($val)) continue;
				if( !empty($val['img'])) {
					$val['fileName'] = str_replace(config('imgConfig.imgSavePath'), '', $val['img']);
					unset($val['img']);
				}
				$info[] = $val;
			}
			if(!empty($info[0]['fileName']))
			$room['thumbPic'] = $info[0]['fileName'];
		}
		
		$this->CreateDao->updateInfo('communityroom', $room, $id);
		$roomId = $id;
		if(!empty($info) && !empty($roomId)){
			foreach($info as $key => $val){
				
				$val['communityRoomId'] = $roomId;
				if(empty($val['isTitlePic'])){
					$val['isTitlePic'] = 0;
				}
				
				if( !empty($val['id'])){
					$val['fileName'] = str_replace(config('imgConfig.imgSavePath'), '', $val['fileName']);
					$this->CreateDao->updateInfo('communityroomimage', $val, $val['id']);
					unset($info[$key]);
					continue;
				}
				$info[$key] = $val;
			}
			$this->CreateDao->insertRoomImage($info);
		}
		return 1;
	}

	/**
	* 删除户型图片
	* @param array $id 要删除的户型图片id
	*/
	public function deleteRoomImage( $id ){
		if(!is_array($id)) $id = array($id);
		$path = $this->CreateDao->selectRoomImage($id);

		$this->CreateDao->deleteRoomImage( $id );
		
		$imgUtil = new UploadImgUtil;
		foreach($path as $pkey => $pval){
			$flag = $imgUtil->deleteImg($pval->fileName);
		}
	
	}

	/**
	* 删除户型信息
	*/
	public function deleteRoom(){
		$id = Input::get('rId');
		$this->CreateDao->deleteRoomInfo($id);
		return 1;
	}
	/**
	* 获取ajax传过来的 户型信息
	*/
	protected function getRoomInfo(){
		$room['rId'] = Input::get('rId','');
		$room['communityId'] = Input::get('id', '');
		$room['name'] = Input::get('name', '');
		$room['state'] = Input::get('state', '');
		$room['cbIds'] = Input::get('cbIds', '');
		$room['unitIds'] = Input::get('uIds', '');
		$room['type1'] = Input::get('pagetype1', '');
		$room['type2'] = Input::get('pagetype2', '');
		$room['roomType'] = Input::get('type', '');
		$room['thumbPic'] = Input::get('leyout', '');
		$room['room'] = Input::get('room', '');
		$room['hall'] = Input::get('hall', '');
		$room['kitchen'] = Input::get('kitchen', '');
		$room['balcony'] = Input::get('balcony', '');
		$room['floorage'] = Input::get('floorage', '');
		$room['usableArea'] = Input::get('usableArea', '');
		$room['faceTo'] = Input::get('faceTo', '');
		$room['num'] = Input::get('num', '');
		$room['price'] = Input::get('price', '');
		$room['feature'] = Input::get('feature', '');
		$room['location'] = Input::get('weizhi', '');
		$room['distribute'] = Input::get('distribute', '');
		$room['delImg'] = Input::get('delImg', '');
		return $room;
	}
	

	// 楼盘点评页
	public function comment(){
		$title = '增量楼盘库-楼盘点评页';

		$comment = true;
		$communityId = Input::get('communityId'); // 获取新创建楼盘id
		$type = $this->getPageType($communityId);
		$type1 = $type['pagetype'][1]; // 获取对应的type1
		$typeInfo = $type['pagetype'][2]; // 地址栏获取的type2
		$type2_data = $type['bar']; // 获取的type2中文导航条

		// 查询点评表信息
		$communitycomment = $this->CreateDao->getComment($communityId);
		$communitycomment->appends(['communityId'=>$communityId])->render();

		// 存储点评信息
		if(!empty(Input::get('add_title'))){
			$comment_id = Input::get('comment_id');
			$data['communityId'] = Input::get('communityId');
			$data['title'] = Input::get('add_title');
			$data['comment'] = Input::get('add_comment');
			if(empty($comment_id)){
				$this->CreateDao->insertComment($data);
				return '点评添加成功!';
			}else{
				$this->CreateDao->updateComment($comment_id,$data);
				return '点评修改成功!';
			}
		}

		// 删除点评信息
		if(!empty(Input::get('delete_id'))){
			$id = Input::get('delete_id');
			if($this->CreateDao->delete('communitycomment','id',$id)){
				return '删除成功';
			}else{
				return '删除失败';
			}
		}

		return view('agent.newbuildingcreate.manageComment',compact('title','comment','typeInfo','type2_data','communityId','communitycomment'));
	}



	// 营销信息页
	public function marketing(){

		$title = '增量楼盘库-营销信息';

		$communityId = Input::get('communityId', '1'); // 获取楼盘id
		//获取物业类型信息
		$info = $this->getPageType($communityId);

		//获取营销（排期）信息
		$saleInfo = $this->CreateDao->getPeriods($communityId, $info['pagetype'][2]);
		// dd($saleInfo);
		// 获取楼栋名称
		$buildInfo = $this->CreateDao->getCommunityBuildName($communityId, $info['pagetype'][2]);

		foreach( $buildInfo as $bval ){
			$saleInfo->build[] = array('id'=>$bval->id, 'num'=>$bval->num );
		}
		if(empty($saleInfo->build)){
			$saleInfo->build = array();
		}
		foreach($saleInfo->items() as $k => $v){
			$v->cbIds = explode('|', $v->cbIds);
			$v->bname = $v->bid = $comma = '';
			foreach($saleInfo->build as $rv){
				if( in_array($rv['id'], $v->cbIds)){
					$v->bname .= $comma.$rv['num'].'号楼';
					$v->bid .= $comma.$rv['id'];
					$comma = ',';
				}
			}
			$saleInfo->items()[$k] = $v;
		}
		// dd($saleInfo);

		$saleInfo->communityName = $info['name'];
		$saleInfo->appends(['communityId'=>$communityId, 'type'=>$info['pagetype'][2] ])->render();
		
		return view('agent.newbuildingcreate.yingxiao', ['title'=>$title, 'marketing'=>true, 'status'=>1,'typeInfo'=>$info['pagetype'][2], 'communityId'=>$communityId, 'type2_data'=>$info['bar'], 'sale'=>$saleInfo, 'data'=>$info['data'], 'bar'=>$info['bar'], 'pagetype'=>$info['pagetype'], 'hosturl'=>'/marketing']);
		// return view('agent.yingxiao',compact('communityId','type2_data','type2Info'));
	}

	/**
	* ajax 删除营销信息 
	*/
	public function deleteSale(){
		$sId = Input::get('sId', '');
		$lId = Input::get('lId', '');
		if(!empty($sId)){
			$flag = $this->CreateDao->deleteSale($sId);
			if($flag) return 1;
		}
		
		if(!empty($lId)){
			$flag = $this->CreateDao->deletePeriodsLog($lId);
			if($flag) return 1;
		}

		return 0;
	}

	/**
	* ajax 添加营销信息
	*/
	public function addSale(){
		$sale = $this->getSaleInfo();
		$id = $sale['sId'];
		unset($sale['sId']);
		if(empty($id)){
			$flag = $this->CreateDao->insertSaleInfo($sale);
			if($flag) return 1;
		}else{
			$flag = $this->CreateDao->updateInfo('communityperiods', $sale, $id);
			if($flag) return 1;
		}
		
		
		return 0;
	}
	/**
	* 获取ajax传来的 营销信息
	*/
	protected function getSaleInfo(){
		$sale['communityId'] = Input::get('id', '');
		$sale['type1'] = Input::get('pagetype1', '');
		$sale['type2'] = Input::get('pagetype2', '');
		$sale['period'] = Input::get('paiQi', '');
	   	$sale['openTime'] = Input::get('kaiPan', '');
		$sale['takeTime'] = Input::get('jiaoFang', '');
		$sale['preSalePermit'] = Input::get('yuShou', '');
		$sale['marketingType'] = Input::get('saleType', '');
		$sale['houseNum'] = Input::get('countNum', '');
		$sale['cbIds'] = Input::get('cbIds', '');
		$sale['rentMaxPrice'] = Input::get('zuGao', '');
		$sale['rentMaxPriceUnit'] = Input::get('zuGaoUnit', '');
		$sale['rentMinPrice'] = Input::get('zuDi', '');
		$sale['rentMinPriceUnit'] = Input::get('zuDiUnit', '');
		$sale['rentAvgPrice'] = Input::get('zuPing', '');
		$sale['rentAvgPriceUnit'] = Input::get('zuPingUnit', '');
		$sale['rentPriceDescription'] = Input::get('zuDesc', '');
		$sale['saleMaxPrice'] = Input::get('shouGao', '');
		$sale['saleMinPrice'] = Input::get('shouDi', '');
		$sale['saleAvgPrice'] = Input::get('shouPing', '');
		$sale['salePriceDescription'] = Input::get('shouDesc', '');
		$sale['discountType'] = Input::get('zheType', '');
		$sale['discount'] = Input::get('zhe', '');
		$sale['subtract'] = Input::get('jian', '');
		$sale['specialOffers'] = Input::get('dianYou', '');
		$sale['sId'] = Input::get('sId', '');
		return $sale;
	}

	/**
	* 增量楼盘库相册信息页
	* @author lixiyu
	*/
	public function addImage() {
		$status = 0; //审核状态  0、未审核  1、审核进行中   2、审核通过  3、审核未通过 
		
		$userId = 12; //用户id 
		$communityId = Input::get('communityId', '1');
		
		//获取地址栏传递 物业类型 参数
		//获取物业类型信息
		$type = $this->getPageType($communityId);
		
		// dd($type);

		//判断是否有上传的图片
		$info = $this->CreateDao->getCommunityImg( $userId, $communityId, $type['pagetype'][2]);
		if(!empty($info)){
			$imageInfo = [];
			foreach($info as $key => $val){
				$imageInfo[config('imageType.num2type.'.$val->type)][] = $val;
			}
			unset($info);
		}else{
			$imageInfo = '';
		}

		// dd($imageInfo);
		return view('agent.newbuildingcreate.addImage',['title'=>'增量楼盘库-新楼盘相册', 'data'=>$type['data'] , 'communityId'=>$communityId, 'hosturl'=>'/buildaddimage', 'type2_data'=>$type['bar'], 'typeInfo'=>$type['pagetype'][2], 'pagetype'=>$type['pagetype'], 'info'=>$imageInfo, 'status'=>$status, 'addImage'=>true ]);
	}



	/**
	* 删除楼盘图片
	* @author lixiyu
	* @param array $id 要删除的楼盘图片id
	*/
	public function deleteImage( $id ){
		
		if(!is_array($id)) $id = array($id);
		
		$path = $this->CreateDao->getImgPath($id);
		
		$flag = $this->CreateDao->deleteCommunityImg( $id );
		if( !$flag ) return 2;
		
		$imgUtil = new UploadImgUtil;
		foreach($path as $pkey => $pval){
			$flag = $imgUtil->deleteImg($pval->fileName);
		}
		
		if( !$flag ) return 0;
		
		return 1;
	}

	/**
	* ajax 修改楼盘图片信息
	* @author lixiyu
	*/
	public function buildEditImage(){
		$userId = 12; //用户id 
		$communityId = Input::get('communityId', '1');
		
		//获取地址栏传递 物业类型 参数
		$ctype1 = Input::get('type1');
		$ctype2 = Input::get('type2');

		$type = 'community';
		$deleteId = Input::get('deleteId');
		// var_dump($deleteId);exit;
		if(!empty($deleteId)){
			$this->deleteImage( $deleteId );
		}

		$data['biaoti'] = Input::get('biaoti');
		$data['guihua'] = Input::get('guihua');
		$data['xiaoguo'] = Input::get('xiaoguo');
		$data['yangban'] = Input::get('yangban');
		$data['jiaotong'] = Input::get('jiaotong');
		$data['shijing'] = Input::get('shijing');
		$data['peitao'] = Input::get('peitao');
		$data['jindu'] = Input::get('jindu');
		
		
		$upload = new UploadImgUtil;
		
		$info = [];
		if(empty($data)) return 1;
		foreach($data as $key => $val){
			if(empty($val)) continue;
			if($key == 'biaoti'){
				
				// 判断是否修改过标题图
				$img = $val['img'];
				if(strpos($img, config('imgConfig.imgSavePath')) === false){
					if( !empty($val['id'])) $this->deleteImage( $val['id'] ); // 如果有id 就先删除
					$upload->setPhotoType( $key );
					$upload->setFix();
					$upload->setImgPath($userId);
					$img = $upload->copyFile($img);

					$val = array();
					$val['fileName'] = $img;
				}else{
					$val = array();
					$val['fileName'] = $img;
				}
				
				$val['communityid'] = $communityId;
				$val['type'] = config('imageType.type2num.'.$key);
				$val['cType1'] = $ctype1;
				$val['cType2'] = $ctype2;
				$val['uid'] = $userId;
				$val['note'] = '';
				$info[] = $val;
				continue;
			}

			foreach($val as $vv){
				if(empty($vv)) continue;
				if(empty($vv['id'])){
					$vv['fileName'] = $vv['img'];
					$vv['communityid'] = $communityId;
					$vv['type'] = config('imageType.type2num.'.$key);
					$vv['cType1'] = $ctype1;
					$vv['cType2'] = $ctype2;
					$vv['uid'] = $userId;
					unset($vv['img']);
					$info[] = $vv;
				}else{
					$tmp = [];
					$tmp['note'] = $vv['note'];
					$id = $vv['id']; 
					$this->CreateDao->editImgInfo( $id, $tmp);
				}
			}
		}

		if(!empty($info)){
			$this->CreateDao->insertCommunityImg( $info );
		}

		return 1;
	}


	/**
	* 佣金方案
	* @author lixiyu
	*/
	public function commission(){
            
		$title = '增量楼盘库-佣金方案';
		$communityId = Input::get('communityId', '1'); // 获取楼盘id
		//获取物业类型信息
		$info 					= $this->getPageType($communityId);
		$yongjin 				= $this->CreateDao->getCommission($communityId); // 获取佣金信息
		$yongjin->communityName = $info['name'];    //获得楼盘名字

		$assist  				= array();    // 辅助变量
		$assist['propertyType']		= array('1'=>'普通住宅', '2'=>'别墅', '3'=>'纯写字楼', '4'=>'住宅底商'); // 物业类型
		$assist['settlement']	= array('1'=>'percentage', '2'=>'commission', '3'=>'percentage');	// 计算结算方式
		// dd($yongjin);
		return view('agent.newbuildingcreate.commission', ['title'=>$title, 'yongjin'=>$yongjin, 'assist'=>$assist,'typeInfo'=>$info['pagetype'][2], 'communityId'=>$communityId, 'type2_data'=>$info['bar']]);
	}

	/**
	* ajax 增加佣金方案
	* @author lixiyu
	*/
	public function addYongJinCase(){
		$commission 					= array();
		$commission['communityId']		= Input::get('comid');
		$commission['propertyTypeId'] 	= Input::get('property');
        $commission['beginTime'] 		= Input::get('begin');
        $commission['schedule'] 		= Input::get('schedule');
       	$commission['suggestionName'] 	= Input::get('caseName');
        $settlement					 	= Input::get('settlement');
        $commission['settlement']		= $settlement;
        switch ($settlement) {
        	case 1:
        	$commission['percentage']   = Input::get('yjNum');
    		break;
        	
        	case 2:
        	$commission['commission']   = Input::get('yjNum');
        	break;

        	case 3:
        	$commission['percentage']   = Input::get('yjNum');
    		break;
        }
        
        $commission['area'] 			= serialize(Input::get('area'));

        $id = Input::get('yId', '');
        if(empty($id)){
        	$flag = $this->CreateDao->insertInfo('developerscommission', $commission);
        	if($flag) return 1;
        }else{
        	$flag = $this->CreateDao->updateInfo('developerscommission', $commission, $id);
        	if($flag) return 1;
        }
        

        return 0;
	}

	/**
	* ajax 删除佣金方案
	* @author lixiyu
	*/
	public function deleteYongjin(){
		$id = Input::get('yId', '');
		if(empty($id)) return 0;


		$flag = $this->CreateDao->daleteInfo('developerscommission', $id);
		if($flag) return 1;

		return 0;
	}


	/**
	* 获取物业类型
	* @author lixiyu
	* @param int $communityId  楼盘id
	*/
	public function getPageType( $communityId ){
		
		//获取地址栏传递 物业类型 参数
		$pagetype = Input::get('typeInfo', '');
		//从数据库获取存在的 物业类型
		$type = $this->CreateDao->getCommunityType($communityId);
		// dd($type);
		if(!$type) return false;
		//物业 主类型
		$type['type1'] = explode('|', $type[0]->type1);
		//物业 副类型
		$type['type2'] = explode('|', $type[0]->type2);
		// dd($type);
		$data = array();
		$repeat_arr = array();
		$bar = $comma = '';
		foreach($type['type1'] as $key => $val){
			foreach($type['type2'] as $key2 => $val2){
				$tmp = config('communityType.'. ($val - 1) .'.'. $val2);
				
				if($tmp){
					if(in_array($val2, $repeat_arr)) continue;
					$repeat_arr[] = $val2;

					$data[$val][$val2] = $tmp;
					$bar .= $comma.$tmp;
					$comma = ' - ';
				}
			}
		}
		// dd($data);
		unset($comma);
		unset($tmp);
		//给当前页面指定一个选中的物业类型
		if(!in_array($pagetype, $type['type2'])){
			$pagetype = array();
			foreach($data as $key => $val){
				$pagetype[1] = $key;
				$pagetype[2] = key($val);
				break;
			}
		}else{
			foreach($data as $key => $val){
				if(array_key_exists($pagetype, $val)){
					$tmp = $pagetype;
					$pagetype = array();
					$pagetype[1] = $key;
					$pagetype[2] = $tmp;
					unset($tmp);
					break;
				}
			}
		}

		$type2 = array_count_values($type['type2']);
		if(!empty($type2['303']) && $type2['303'] == 2 ){
			if(in_array(2, $type['type1']) && in_array(3, $type['type1'])){
				if($pagetype[2] == '303'){
					$pagetype[1] = '3|2';
				}
			}
		}
		
		// dd($pagetype);

		$info = array();
		$info['pagetype'] = $pagetype;
		$info['data'] = $data;
		$info['bar'] = $bar;
		$info['name'] = $type[0]->name;
		unset($type);
		// dd($info);
		return $info;
	}

}
?>