<?php
namespace App;

/**
 * 楼盘私有字段数据结构
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年12月16日 下午5:01:34
 * @version 1.0
 */
class CommunityDataStructure {
	/**
	 * 物业类型（副）：
		101.商铺-住宅底商
		102.商铺-商业街商铺
		103.商铺-临街商铺
		104.商铺-写字楼底商
		105.商铺-购物中心商铺
		106.商铺-其他
		201.写字楼-纯写字楼
		203.写字楼-商业综合体楼
		204.写字楼-酒店写字楼
		301.住宅-普宅
		302.住宅-经济适用房
		303.住宅/住宅-商住楼
		304.住宅-别墅
		305.住宅-豪宅
		306.住宅-平房
		307.住宅-四合院
	 * @var int
	public $search_type2;
	*/
	
    /**
     * 分销商id(enterprise.id)
     * @var int
     */
    public $epId;
    
    /**
     * 数据创建时间
     * @var unixtime
     */
    public $timeCreate;
    
    /**
     * 数据更新时间
     * @var unixTime
     */
    public $timeUpdate;
    
    /**
     * 房屋设计类别：1.错层 2.跃层 3.复式 4.开间 5.平层
     * @var int
     */
    public $homeDesignType;
    
    /**
     * 建筑结构：1.板楼 2.塔楼 3.砖楼 4.砖混 5.平房  6.钢混 7.塔板结合
     * @var int
     */
    public $structure;
    
    /**
     * 开工时间（新盘）
     * @var time
     */
    public $startTime;
    
    /**
     * 竣工时间（新盘）
     * @var time
     */
    public $endTime;
    
    /**
     * 建筑面积（平米）
     * @var int
     */
    public $floorage;
    
    /**
     * 占地面积（平米）
     * @var int
     */
    public $floorSpace;
    
    /**
     * 产权年限
     * @var int
     */
    public $propertyYear;
    
    /**
     * 总户数（户）
     * @var int
     */
    public $houseTotal;
    
    /**
     * 容积率
     * @var float
     */
    public $volume;
    
    /**
     * 绿化率
     * @var float
     */
    public $greenRate;
    
    /**
     * 得房率
     * @var float
     */
    public $getRate;
    
    /**
     * 装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
     * @var int
     */
    public $decoration;
    
    /**
     * 公共区域装修情况：1.毛坯 2.中装修 3.精装修
     * @var int
     */
    public $decorationPublic;
    
    /**
     * 使用区域装修情况：1.毛坯 2.网络地板+吊顶
     * @var int
     */
    public $decorationUsedRange;
    
    /**
     * 标准层高（米）
     * @var float
     */
    public $floorHeight;
    
    /**
     * 项目特色（标品标签id）,西文|隔开：关联数据sofang20_house.tag.id
     * @var string
     */
    public $tagIds;
    
    /**
     * 自定义项目测色（自定义标签id）,西文|隔开：关联数据sofang20_house.tagdiy.id
     * @var string
     */
    public $diyTagIds;
    
    /**
     * 物业费(元/平米▪月)
     * @var float
     */
    public $propertyFee;
    
    /**
     * 车位信息： x_x_x_x_x;
     * 	对应数据：规划机动车停车位x个，其中地上约x个，地下约x个。住宅的机动车车位配比为x：x。
     * @var string
     */
    public $parkingInfo;
    
    /**
     * 物业备注
     * @var string
     */
    public $propertyRemark;
    
    /**
     * 学区id，关联数据school.id，西文|分隔
     * @var string
     */
    public $schoolIds;
    
    /**
     * 服务配套设施：1.客房清洁 2.洗衣熨烫 3.健身房 4.泳池 5.可注册 6.商务中心 7.24小时大堂经理 8.送餐服务 9.叫车服务；西文|隔开
     * @var string
     */
    public $supportService;
    
    /**
     * 室内配套设施：1.中央空调 2.24小时热水 3.冰箱 4.洗衣机 5.电视 6.家具 7.高速网络；西文|隔开
     * @var string
     */
    public $supportIndoor;
    
    /**
     * 供电：1.市政 2.其他
     * @var int
     */
    public $powerSupply;
    
    /**
     * 供水：1.市政 2.其他
     * @var int
     */
    public $waterSupply;
    
    /**
     * 供气：0.无 1.市政 2.其他
     * @var int
     */
    public $gasSupply;
    
    /**
     * 供暖：1.集中供暖 2.小区供暖 3.自采暖
     * @var int
     */
    public $heatingSupply;
    
    /**
     * 国有土地使用证
     * @var string
     */
    public $StateLandPermit;
    
    /**
     * 建设用地规划许可证
     * @var string
     */
    public $constructionLandUsePermit;
    
    /**
     * 建筑工程规划许可证
     * @var string
     */
    public $constructionPlanningPermit;
    
    /**
     * 建筑工程施工许可证
     * @var string
     */
    public $buildingEngineeringConstructionPermit;
    
    /**
     * 商品房预售许可证 
     * @var string
     */
    public $preSalePermit;
    
    /**
     * 项目介绍（简介）
     * @var string
     */
    public $intro;
    
    /**
     * 板块id，数据关联：macroplate.id
     * @var id
     */
    public $macroplateId;
    
    /**
     * 建筑类别（居室类型）：1.独栋 2.双拼 3.联排 4.叠拼 5.四合院 ；西文|分割
     * @var string
     */
    public $roomType;
    
    /**
     * 楼层承重（千克/平米）
     * @var float
     */
    public $floorBearing;
    
    /**
     * 写字楼级别：0.甲级 1.乙级 2.丙级 3.其他
     * @var int
     */
    public $officeLevel;
    
    /**
     * 开间面积(小)
     * @var float
     */
    public $bayAreaMin;
    
    /**
     * 开间面积(大)
     * @var float
     */
    public $bayAreaMax;
    
    /**
     * 商业面积（平米）
     * @var int
     */
    public $commercialArea;
    
    /**
     * 办公面积（平米）
     * @var int
     */
    public $officeArea;
    
    /**
     * 大商圈id，数据关联：businesstags.id
     * @var int
     */
    public $businessTagId;
    
    /**
     * 建筑外墙
     * @var string
     */
    public $wallOutside;
    
    /**
     * 建筑内墙
     * @var string
     */
    public $wallInside;
    
    /**
     * 制冷/采暖
     * @var string
     */
    public $coolingHeating;
    
    /**
     * 网络通讯
     * @var string
     */
    public $network;
    
    /**
     * 消防系统
     * @var string
     */
    public $fireFighting;
    
    /**
     * 安防系统
     * @var string
     */
    public $security;
    
    /**
     * 客梯个数
     * @var int
     */
    public $passengerLiftNum;
    
    /**
     * 客梯品牌
     * @var string
     */
    public $passengerLiftBrand;
    
    /**
     * 货梯个数
     * @var int
     */
    public $goodsLiftNum;
    
    /**
     * 货梯品牌
     * @var string
     */
    public $goodsLiftBrand;
    
    /**
     * 地板材料
     * @var string
     */
    public $flooring;
    
    /**
     * 空调系统说明（描述）
     * @var string
     */
    public $airCondition;
    
    /**
     * 总层数
     * @var int
     */
    public $totalFloor;
    
    /**
     * 地上层数
     * @var int
     */
    public $groundFloor;
    
    /**
     * 地下层数
     * @var int
     */
    public $underGroundFloor;
    
    /**
     * 净层高
     * @var float
     */
    public $clearHeight;
    
    /**
     * 建筑高度
     * @var float
     */
    public $buildingHeight;
    
    /**
     * 楼层备注（补充说明）
     * @var string
     */
    public $floorRemark;
    
    /**
     * 是否可隔层：0.是 1.否
     * @var int
     */
    public $isDivisibility;
    
    /**
     * 适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
     * @var string
     */
    public $trade;
    
    /**
     * 标准层面积（平米）
     * @var float
     */
    public $floorArea;
    
    /**
     * 装修描述（备注）
     * @var string
     */
    public $decorationRemark;

	/**
	 * 视频链接
	 * @var string
	 */
	public $videoUrl;

	/**二手楼盘改版新增序列化字段**/
    public $buildYear; //建筑年代
	public $unitTotal; //楼栋总数
    public $buildInfo; //楼栋状况
	public $houseNum; //当前户数
	public $oneFloorArea;//单层商铺面积
	public $isSetOut;//是否设外
    

    public function __construct($search_type2){
		$this->epId = 0;								//@var int		分销商id(enterprise.id)	
		$this->timeCreate = time();						//@var unixTime	数据创建时间		
		$this->timeUpdate = time();						//@var unixTime	数据更新时间	
			
		$this->startTime = 0;							//@var unixTime	开工时间（新盘）	
		$this->endTime = 0;								//@var unixTime	竣工时间（新盘）	
		$this->floorage = 0;							//@var int		建筑面积（平米）
        $this->floorSpace = 0;                          //@var int      占地面积（平米）
		$this->floorArea = 0;							//@var int		标准层面积（平米）
		$this->propertyYear = 0;						//@var int		产权年限
		$this->volume = 0;								//@var float	容积率
		$this->greenRate = 0;							//@var float	绿化率
		$this->floorHeight = 0;							//@var float	标准层高（米）
		$this->tagIds = '';								//@var string	项目特色（标品标签）,西文|隔开：关联数据sofang20_house.tag.id
		$this->diyTagIds = '';							//@var string	自定义标签id,西文|隔开：关联数据sofang20_house.tagdiy.id
		
		$this->propertyFee = 0;							//@var float	物业费(元/平米▪月)
		$this->parkingInfo = '';						//@var string	车位信息： x_x_x_x_x;对应数据：规划机动车停车位x个，其中地上约x个，地下约x个。住宅的机动车车位配比为x：x。
		$this->propertyRemark = '';						//@var string	物业备注
		$this->powerSupply = 0;							//@var int		供电：1.市政 2.其他
		$this->waterSupply = 0;							//@var int		供水：1.市政 2.其他
		$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
		$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
		$this->StateLandPermit = '';					//@var string	国有土地使用证
		$this->constructionLandUsePermit = '';			//@var string	建设用地规划许可证
		$this->constructionPlanningPermit = '';			//@var string	建筑工程规划许可证
		$this->buildingEngineeringConstructionPermit='';//@var string	建筑工程施工许可证
		$this->preSalePermit = '';						//@var string	商品房预售许可证
		$this->intro = '';								//@var string	项目介绍
	    $this->videoUrl = '';

		/**新增二手楼盘字段**/
		$this->buildYear = '';
		$this->unitTotal = '';
		$this->buildInfo = '';
		
        switch($search_type2){
        	case 101:		//商铺-住宅底商
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->isDivisibility = 0;						//@var int		是否可隔层：0.是 1.否
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->trade = '';								//@var string	适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
				$this->oneFloorArea = '';						//单层商铺面积
				$this->isSetOut = 0;							//是否设外
				$this->passengerLiftNum = 0;					//@var int		客梯个数
				$this->goodsLiftNum = 0;						//@var int		货梯个数
				$this->commercialArea = 0;						//@var int		商业面积
				$this->officeArea = 0;							//@var int		办公面积
        		break;
        	case 102:		//商铺-商业街店铺
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->isDivisibility = 0;						//@var int		是否可隔层：0.是 1.否
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->trade = '';								//@var string	适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		break;
        	case 103:		//商铺-临街商铺
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->isDivisibility = 0;						//@var int		是否可隔层：0.是 1.否
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->trade = '';								//@var string	适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		break;
        	case 104:		//商铺-写字楼底商
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->isDivisibility = 0;						//@var int		是否可隔层：0.是 1.否
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->trade = '';								//@var string	适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		break;
        	case 105:		//商铺-购物中心商铺
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
				$this->floorArea = 0;							//@var float	标准层面积（平米）
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
        		$this->decorationRemark = '';					//@var string	装修描述（备注）
				$this->trade = '';								//@var string	适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->network = '';							//@var string	网络通讯
				$this->fireFighting = '';						//@var string	消防系统
				$this->security = '';							//@var string	安防系统
				$this->passengerLiftNum = 0;					//@var int		客梯个数
				$this->passengerLiftBrand = '';					//@var string	客梯品牌
				$this->goodsLiftNum = 0;						//@var int		货梯个数
				$this->goodsLiftBrand = '';						//@var string	货梯品牌
				$this->flooring = '';							//@var string	地板材料
				$this->airCondition = '';						//@var string	空调系统说明（描述）
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		break;
        	case 106:		//商铺-其他
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->isDivisibility = 0;						//@var int		是否可隔层：0.是 1.否
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->trade = '';								//@var string	适合行业：1.餐饮美食 2.服饰鞋包 3.休闲娱乐 4.美容美发 5.百货超市 6.生活服务 7.家居建材 8.酒店宾馆 9.其他；西文|分割
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->network = '';							//@var string	网络通讯
				$this->fireFighting = '';						//@var string	消防系统
				$this->security = '';							//@var string	安防系统
				$this->passengerLiftNum = 0;					//@var int		客梯个数
				$this->passengerLiftBrand = '';					//@var string	客梯品牌
				$this->goodsLiftNum = 0;						//@var int		货梯个数
				$this->goodsLiftBrand = '';						//@var string	货梯品牌
				$this->flooring = '';							//@var string	地板材料
				$this->airCondition = '';						//@var string	空调系统说明（描述）
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		$this->decorationRemark = '';					//@var string	装修描述（备注）
        		break;
        	case 201:		//写字楼-纯写字楼
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->officeLevel = 0;							//@var int		写字楼级别：0.甲级 1.乙级 2.丙级 3.其他
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->commercialArea = 0;						//@var int		商业面积
        		$this->officeArea = 0;							//@var int		办公面积
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->businessTagId = 0;						//@var int		大商圈id，数据关联：businesstags.id
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->network = '';							//@var string	网络通讯
				$this->fireFighting = '';						//@var string	消防系统
				$this->security = '';							//@var string	安防系统
				$this->passengerLiftNum = 0;					//@var int		客梯个数
				$this->passengerLiftBrand = '';					//@var string	客梯品牌
				$this->goodsLiftNum = 0;						//@var int		货梯个数
				$this->goodsLiftBrand = '';						//@var string	货梯品牌
				$this->flooring = '';							//@var string	地板材料
				$this->airCondition = '';						//@var string	空调系统说明（描述）
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
				$this->oneFloorArea = '';						//单层商铺面积
				$this->isSetOut = 0;							//是否设外
				$this->isDivisibility = 0;						//@var int		是否可隔层：0.是 1.否
        		break;
        	case 203:		//写字楼-商业综合体楼
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->officeLevel = 0;							//@var int		写字楼级别：0.甲级 1.乙级 2.丙级 3.其他
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->commercialArea = 0;						//@var int		商业面积
        		$this->officeArea = 0;							//@var int		办公面积
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->businessTagId = 0;						//@var int		大商圈id，数据关联：businesstags.id
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->network = '';							//@var string	网络通讯
				$this->fireFighting = '';						//@var string	消防系统
				$this->security = '';							//@var string	安防系统
				$this->passengerLiftNum = 0;					//@var int		客梯个数
				$this->passengerLiftBrand = '';					//@var string	客梯品牌
				$this->goodsLiftNum = 0;						//@var int		货梯个数
				$this->goodsLiftBrand = '';						//@var string	货梯品牌
				$this->flooring = '';							//@var string	地板材料
				$this->airCondition = '';						//@var string	空调系统说明（描述）
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		break;
        	case 204:		//写字楼-酒店写字楼
        		$this->structure = 0;							//@var int		建筑结构：8.框架剪力墙 9.其他
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->officeLevel = 0;							//@var int		写字楼级别：0.甲级 1.乙级 2.丙级 3.其他
        		$this->bayAreaMin = 0;							//@var float	开间面积(小)
        		$this->bayAreaMax = 0;							//@var float	开间面积(大)
        		$this->commercialArea = 0;						//@var int		商业面积
        		$this->officeArea = 0;							//@var int		办公面积
        		$this->decorationPublic = 0;					//@var int		公共区域装修情况：1.毛坯 2.中装修 3.精装修
        		$this->decorationUsedRange = 0;					//@var int		使用区域装修情况：1.毛坯 2.网络地板+吊顶
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->businessTagId = 0;						//@var int		大商圈id，数据关联：businesstags.id
				$this->wallOutside = '';						//@var string	建筑外墙
				$this->wallInside = '';							//@var string	建筑内墙
				$this->coolingHeating = '';						//@var string	制冷/采暖
				$this->network = '';							//@var string	网络通讯
				$this->fireFighting = '';						//@var string	消防系统
				$this->security = '';							//@var string	安防系统
				$this->passengerLiftNum = 0;					//@var int		客梯个数
				$this->passengerLiftBrand = '';					//@var string	客梯品牌
				$this->goodsLiftNum = 0;						//@var int		货梯个数
				$this->goodsLiftBrand = '';						//@var string	货梯品牌
				$this->flooring = '';							//@var string	地板材料
				$this->airCondition = '';						//@var string	空调系统说明（描述）
				$this->totalFloor = 0;							//@var int		总层数
				$this->groundFloor = 0;							//@var int		地上层数
				$this->underGroundFloor = 0;					//@var ing		地下层数
				$this->clearHeight = 0;							//@var float	净层高
				$this->buildingHeight = 0;						//@var float	建筑高度
				$this->floorRemark = '';						//@var string	楼层备注（补充说明）
        		break;
        	case 301:		//住宅-普宅
				$this->homeDesignType = 0;						//@var int		房屋设计类别：1.错层 2.跃层 3.复式 4.开间 5.平层
				$this->structure = 0;							//@var int		建筑结构：1.板楼 2.塔楼 3.砖楼 4.砖混 5.平房  6.钢混 7.塔板结合
				$this->houseTotal = 0;							//@var int		总户数（户）
				$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
				$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
				$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
				$this->houseTotal = ''; //总户数
				$this->houseNum = '';  //当期户数
        		break;
        	case 302:		//住宅-经济适用房
				$this->homeDesignType = 0;						//@var int		房屋设计类别：1.错层 2.跃层 3.复式 4.开间 5.平层
				$this->structure = 0;							//@var int		建筑结构：1.板楼 2.塔楼 3.砖楼 4.砖混 5.平房  6.钢混 7.塔板结合
				$this->houseTotal = 0;							//@var int		总户数（户）
				$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
				$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
				$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
        		break;
        	case 303:		//写字楼/住宅-商住公寓楼
				$this->homeDesignType = 0;						//@var int		房屋设计类别：1.错层 2.跃层 3.复式 4.开间 5.平层	
				$this->structure = 0;							//@var int		建筑结构：1.板楼 2.塔楼 3.砖楼 4.砖混 5.平房  6.钢混 7.塔板结合	
				$this->houseTotal = 0;							//@var int		总户数（户）
				$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
				$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
				$this->supportService = '';						//@var string	服务配套设施：1.客房清洁 2.洗衣熨烫 3.健身房 4.泳池 5.可注册 6.商务中心 7.24小时大堂经理 8.送餐服务 9.叫车服务；西文|隔开
				$this->supportIndoor = '';						//@var string	室内配套设施：1.中央空调 2.24小时热水 3.冰箱 4.洗衣机 5.电视 6.家具 7.高速网络；西文|隔开
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
				$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
        		break;
        	case 304:		//住宅-别墅
				$this->homeDesignType = 0;
				$this->structure = 0;
				$this->houseTotal = 0;							//@var int		总户数（户）
				$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
				$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
				$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
				$this->roomType = '';							//@var string	建筑类别（居室类型）：1.独栋 2.双拼 3.联排 4.叠拼 5.四合院 ；西文|分割
				$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
				$this->houseTotal = ''; //总户数
				$this->houseNum = '';  //当期户数
        		break;
        	case 305:		//住宅-豪宅
				$this->homeDesignType = 0;						//@var int		房屋设计类别：1.错层 2.跃层 3.复式 4.开间 5.平层	
				$this->structure = 0;							//@var int		建筑结构：1.板楼 2.塔楼 3.砖楼 4.砖混 5.平房  6.钢混 7.塔板结合	
				$this->houseTotal = 0;							//@var int		总户数（户）
				$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
				$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
				$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
				$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
				$this->macroplateId = 0;						//@var int		板块id，数据关联：macroplate.id
        		break;
        	case 306:		//住宅-平房
        		$this->houseTotal = 0;							//@var int		总户数（户）
        		$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
        		$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
        		$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
        		$this->roomType = '';							//@var string	建筑类别（居室类型）：1.独栋 2.双拼 3.联排 4.叠拼 5.四合院 ；西文|分割
        		$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
        		break;
        	case 307:		//住宅-四合院
        		$this->houseTotal = 0;							//@var int		总户数（户）
        		$this->getRate = 0;								//@var float	得房率
        		$this->decoration = 1;							//@var int		装修情况：1.毛坯 2.简装修 3.中装修 4.精装修 5.豪华装修
        		$this->schoolIds = '';							//@var string	学区id，关联数据school.id，西文|分隔
        		$this->gasSupply = 0;							//@var int		供气：0.无 1.市政 2.其他
        		$this->heatingSupply = 0;						//@var int		供暖：1.集中供暖 2.小区供暖 3.自采暖
        		$this->roomType = '';							//@var string	建筑类别（居室类型）：1.独栋 2.双拼 3.联排 4.叠拼 5.四合院 ；西文|分割
        		$this->floorBearing = 0;						//@var float	楼层承重（千克/平米）
        		break;
        	default:
        		dd('物业类型参数错误，请重新输入');
        }
        serialize($this);		//序列化内容
// 		json_encode($this);			//json化内容
    }
    
    /* function json_encode(){
    	return json_encode($this);
    }
    function json_decode($data){
    	return json_decode($data);
    } */
    
    /**
     * 序列化
     */
    function serialize(){
    	return json_encode($this);
//     	return serialize($this);
    }
    /**
     * 反序列化
     */
    function unserialize($data){
    	return json_decode($data);
//     	return unserialize($data);
    }
    
    /**
     * 不允许添加没有声明过的属性
     */
    function __set($property, $value){
    	$method = $property;
    	if(!property_exists($this, $method)){		//如果当前类没有该属性
    		unset($this->$method);
//     		dd("CommunityDataStructure类没有声明".$method."属性，请重新输入");
//     		return $this->$method($value);
    	}
    }
    /**
     * 序列化时自动消除值为null的数据
     */
    function  __sleep(){
    	$result = array();
    	foreach($this as $k=>$v){
    		if(is_null($v)){
    			unset($this->$k);
    		}else{
    			$result[] = $k;
    		}
    	}
		return $result;
    }
    
    /**
     * 饭序列化时自动消除值为NULL的数据
     */
    function __wakeup(){
    	$result = array();
    	foreach($this as $k=>$v){
    		if(is_null($v)){
    			unset($this->$k);
    		}else{
    			$result[] = $k;
    		}
    	}
    	return $result;
    }
}
