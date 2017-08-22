<?php

namespace App;

/**
 * 地图搜索房源 参数
 *
 * @author xcy
 */

class ListInputView {

    public $cityId;                      //城市id                                  楼盘
    public $cityareaId;               //城区id                                   楼盘
    public $businessAreaId;       //城区下子区域id                     楼盘
    public $subwayLineId;            //地铁线id                              楼盘
    public $subwayStationId;        //地铁站id                               楼盘
    public $bustagid;                   //商圈id                                  楼盘                     
    public $communityId;            //楼盘id                               楼盘
    public $communityName;            //名称
    public $enterpriseshopId;      //分销商id

    public $buslineid;                       //公交线路id
    public $busstationid;              //公交站点id
    public $keyword;                //搜索框内容
    public $outerring;                 //区域环线                                 楼盘
    public $school;                    //学校等级                                 楼盘
    public $schoolId;                  //学校（学区）id
    public $from = 0;                      // "真"房 独家  跳蚤
    public $type1;            // 住宅 写字楼 商铺等类型                         楼盘
    public $type2;            // 住宅 写字楼 商铺 子分类等类型                         楼盘
    public $avgPrice;         // 均价 价格 总价                    楼盘

    public $priceRentAvg1;
    public $priceRentAvg2;
    public $priceRentAvg3;
    public $priceRentAvg101;
    public $priceRentAvg102;
    public $priceRentAvg103;
    public $priceRentAvg104;
    public $priceRentAvg105;
    public $priceRentAvg106;
    public $priceRentAvg201;
    public $priceRentAvg203;
    public $priceRentAvg204;
    public $priceRentAvg301;
    public $priceRentAvg302;
    public $priceRentAvg303;
    public $priceRentAvg304;
    public $priceRentAvg305;
    public $priceRentAvg306;
    public $priceRentAvg307;

    public $priceSaleAvg1;
    public $priceSaleAvg2;
    public $priceSaleAvg3;
    public $priceSaleAvg101;
    public $priceSaleAvg102;
    public $priceSaleAvg103;
    public $priceSaleAvg104;
    public $priceSaleAvg105;
    public $priceSaleAvg106;
    public $priceSaleAvg201;
    public $priceSaleAvg203;
    public $priceSaleAvg204;
    public $priceSaleAvg301;
    public $priceSaleAvg302;
    public $priceSaleAvg303;
    public $priceSaleAvg304;
    public $priceSaleAvg305;
    public $priceSaleAvg306;
    public $priceSaleAvg307;

    public $price1;         // 元/月
    public $price2;         // 元/天/平米 或者万元
    public $price3;         // 元/月/平米
    public $singlearea;               // 单层面积 、面积                楼盘
    public $houseRoom;                     // 户型                                   楼盘
    public $rentway;                 // 租住方式
    public $feature;                  // 特色                                        楼盘
    public $sfeature;                  // 学校特色
    public $category;                  // 类别
    public $spind;                  // 商铺 行业
    public $hezunum;                  // 合租户数
    public $salesStatusPeriods;                  // 销售状态                               楼盘
    public $openTimePeriods;                  // 开盘时间                                楼盘
    public $subbuild;                   //楼盘分类  1:特惠楼盘、2:直售楼盘、3:众筹楼盘   楼盘
    public $toward;                 //朝向
    public $buildYear;                     //房龄
    public $floor;                    //楼层
    public $decorate;             //装修
    public $buildtype;             //建筑类别
    public $structure;             //房屋结构
    public $pei;                     //配套  值为1,2,3,4
    public $swlng;              //西南经度
    public $swlat;              //西南纬度
    public $nelng;              //东北经度
    public $nelat;              //东北纬度

    public $longitude;              //经度
    public $latitude;              //纬度
    public $distance;                //距离
    
    public $order;               //排序字段                   楼盘
    public $asc;                 //正序,倒序                     楼盘
    public $timeRelease;             //更新时间  现在不用这个参数了
	public $range;				//查询范围数据['field1'=>['gte'=>'val1a', 'lte'=>'va11b'], .....];大于小于
    public $page = 1;               //页码                                 楼盘
    public $pageset = 20;       //每页条数
    
    public $isNew;              //新房标签0:二手房,1:新房
    public $uid;                //用户id
    
    public $fields;
    public $dealState;                //成交状态

    public $isSoloAgent;             //独家代理
    public $agentFee;                //免中介
    public $publishUserType;         //发布人类型
    public $isNewHouse;             //是否新上房源
    public $must_not;				//不等于
    public $state = 1;              // 状态 1 已发布或已上架
    public function __construct($cityId='',$cityareaId='',$businessAreaId='',$subwayLineId='',$subwayStationId='',$bustagid='',$communityId='',$buslineid='',$busstationid='',$keyword='',$outerring='',$distance='',$school='',$from='',$type1='',$type2='',$singlearea='',$houseRoom='',$rentway='',$feature='',$sfeature='',$category='',$spind='',$hezunum='',$salesStatusPeriods='',$openTimePeriods='',$subbuild='',$toward='',$floor='',$decorate='',$buildtype='',$structure='',$pei='',$swlng=null,$swlat=null,$nelng=null,$nelat=null,$order='',$asc='',$page=1,$pageset=30){
        $this->cityId = $cityId;
        $this->cityareaId = $cityareaId;
        $this->businessAreaId = $businessAreaId;
        $this->subwayLineId = $subwayLineId;
        $this->subwayStationId = $subwayStationId;
        $this->bustagid = $bustagid;
        $this->communityId = $communityId;
        $this->buslineid = $buslineid;
        $this->busstationid = $busstationid;
        $this->keyword = $keyword;
        $this->outerring = $outerring;
        $this->distance = $distance;
        $this->school = $school;
        $this->from = $from;
        $this->type1 = $type1;
        $this->type2 = $type2;
        $this->singlearea = $singlearea;
        $this->houseRoom = $houseRoom;
        $this->rentway = $rentway;
        $this->feature = $feature;
        $this->sfeature = $sfeature;
        $this->category = $category;
        $this->spind = $spind;
        $this->hezunum = $hezunum;
        $this->salesStatusPeriods = $salesStatusPeriods;
        $this->openTimePeriods = $openTimePeriods;
        $this->subbuild = $subbuild;
        $this->toward = $toward;
        $this->floor = $floor;
        $this->decorate = $decorate;
        $this->buildtype = $buildtype;
        $this->structure = $structure;
        $this->pei = $pei;
        $this->swlng = $swlng;
        $this->swlat = $swlat;
        $this->nelng = $nelng;
        $this->nelat = $nelat;
		$this->range = [];
        $this->order = $order;
        $this->asc = $asc;
        $this->page = $page;
        $this->pageset = $pageset;
        $this->must_not = '';
    }

}
