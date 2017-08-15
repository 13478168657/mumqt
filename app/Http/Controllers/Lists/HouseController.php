<?php
namespace App\Http\Controllers\Lists;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;

use App\ListInputView;
use App\Services\Search;
use App\Dao\Agent\HouseDao;
use App\Dao\City\CityDao;
use App\Dao\Xinf\XinfDao;
use Cookie;
use Auth;
use DB;
use App\Http\Controllers\Utils\RedisCacheUtil;
use App\Http\Controllers\Broker\BrokerController;

/**
 * Description of HouseController （各房源楼盘的搜索列表）
 * @since 1.0
 * @author xcy
 */
class HouseController extends Controller
{
    public $purl;                   //地址参数
    public $house;                  //房源数据库类
    public $public;                       //列表公共类对象
    public $lists;                         //实体类变量
    public $cityArea;                   //城区数据
    public $businessArea;           //城区下子区域数据
    public $subWay;                  //城区下子地铁数据
    public $subWayStation;       //地铁下地铁站点数据

    public $cityId;                      //城市id
    public $cityName;                      //城市名称
    public $cityareaId;               //城区id
    public $businessAreaId;       //城区下子区域id
    public $subwayLineId;            //地铁线id
    public $subwayStationId;        //地铁站id
    public $bustagid;                   //商圈id
    public $communityId;                   //楼盘id
    public $stationkeyword;          //公交线路站点搜索名称
    public $buslineid;                   //公交线路id
    public $busstationid;              //公交站点id
    public $keyword;                //搜索框内容
    public $outerring;                 //区域环线
    public $distance;                 //离地铁线的距离
    public $school;                    //学校等级
    public $from;                      // "真"房 独家  跳蚤
    public $houseType1;            // 住宅 写字楼 商铺等类型                         楼盘
    public $houseType2;            // 住宅 写字楼 商铺 子分类等类型                         楼盘
    public $averagePrice;         // 均价 价格 总价
    public $inputPrice;              // 手动输入的价格区间
    public $singlearea;               // 单层面积 、面积
    public $inputarea;              // 手动输入的面积区间
    public $model;                     // 户型
    public $rentway;                 // 租住方式
    public $feature;                  // 特色
    public $sfeature;                  // 学校特色
    public $category;                  // 类别
    public $spind;                  // 商铺 行业
    public $hezunum;                  // 合租户数
    public $salesStatusPeriods;                  // 销售状态
    public $openTimePeriods;                  // 开盘时间
    public $subbuild;                   //楼盘分类  1:特惠楼盘、2:直售楼盘、3:众筹楼盘

    public $toward;                 //朝向
    public $that;                     //房龄
    public $floor;                    //楼层
    public $decorate;             //装修
    public $buildtype;             //建筑类别
    public $structure;             //房屋结构
    public $pei;                   //配套  值为1|2|3|4
    public $swlng;              //西南经度
    public $swlat;              //西南纬度
    public $nelng;              //东北经度
    public $nelat;              //东北纬度
    public $order;               //排序字段
    public $asc;                 //正序,倒序
    //public $reltime;             //更新时间
    public $page;               //页码
    public $pageset;       //每页条数
    public $maxPage = 200;      //最多加载多少页
    public $hwdc = 3260; //海外地产在城区表中的id
    public function __construct($parameter ='')
    {
        $this->purl = $parameter;
        if(!empty($parameter)){
            $this->checkpar($parameter);
        }
        $this->house = new HouseDao();
        //城市id 城市名称
//        $py = explode('.',$_SERVER['HTTP_HOST']);
//        $py = $py[0];
//        $cityInfo = $this->house->getCityByPy($py);
//        $this->cityId = !empty($cityInfo->id)?$cityInfo->id:1;
//        $this->cityName = !empty($cityInfo->name)?$cityInfo->name:'北京';
        $this->cityId = !empty(CURRENT_CITYID)?CURRENT_CITYID:1;
        $this->cityName = !empty(CURRENT_CITYNAME)?CURRENT_CITYNAME:'北京';
        $this->keyword = Input::get('kw', '');
        $this->swlng = Input::get('swlng', null);
        $this->swlat = Input::get('swlat', null);
        $this->nelng = Input::get('nelng', null);
        $this->nelat = Input::get('nelat', null);
        if(!empty(Input::get('page'))){
            $this->page = Input::get('page');
        }
        $pagelistset = config('houseListPageConfig');
//        dd($pagelistset['pageset']);
        $this->page = !empty($this->page)?$this->page:1;
        $this->page = ($this->page > $this->maxPage)?$this->maxPage:$this->page;//最多两百页
        $this->pageset = $pagelistset['pageset'];
        //dd($businessareaAreas);
        //引入公共类
        $this->public = new PublicController();
        //获取城区、地铁
        if (!empty($this->cityId)) {
            $this->cityArea = $this->public->getCityArea($this->cityId);
            $this->subWay = $this->public->getSubWay($this->cityId);
        }

        //获取城区下子区域
        if (!empty($this->cityId) && !empty($this->cityareaId)) {
            $this->businessArea = $this->public->getBusinessArea($this->cityareaId);
        }
        //获取地铁下的站点
        if (!empty($this->cityId) && !empty($this->subwayLineId)) {
            $this->subWayStation = $this->public->getSubWayStation($this->cityId, $this->subwayLineId);

        }
    }

    /**
     * 楼盘搜索列表
     * @param string $type 二手房出售(saleesb)出租(rentesb) shops:商铺新盘 office:写字楼新盘 new:新房 villa:别墅
     * @param string $subtype area:区域  sub:地铁 环线:loop 商圈:business 户型:model 房源:house 学区:school
     * @return 搜索页面
     */
    public function community($type = 'saleesb', $subtype = 'area')
    {
        $data['purl'] = $this->purl;
        //判断所在区域是否有地铁,若没有调到区域选项
        if($subtype == 'sub'){
            if(empty($this->subWay)){
                $subtype = 'area';
            }
        }
        $data['defaultImage'] = '/image/noImage.png';//默认图片地址
        $data['type'] = $type;
        $data['subtype'] = $subtype;
        $data['cityArea'] = $this->cityArea;
        $data['linkurl'] = '/'.$type.'/'.$subtype;

        $GLOBALS['current_listurl'] = config('session.domain').$data['linkurl'];

        $data['businessArea'] = $this->businessArea;
        $data['subWay'] = $this->subWay;
        $data['subWayStation'] = $this->subWayStation;
        $data['models'] = \Config::get('conditionConfig.buildmodels.text');
        $data['areas'] = \Config::get('conditionConfig.areas.text');
        $data['distances'] = \Config::get('conditionConfig.distance.text');
        $data['schools'] = \Config::get('conditionConfig.school.text');
        //$data['outerrings'] = $this->house->getLoopline($this->cityId);
        $data['singleareas'] = \Config::get('conditionConfig.singlearea.text');
        $singleareas = \Config::get('conditionConfig.singlearea.number');
        $data['salestatus'] = \Config::get('conditionConfig.salestatus.text');
        $data['opentimes'] = \Config::get('conditionConfig.opentime.text');
        $data['bustags'] = $this->public->getBusinessTag($this->cityId);

        //根据不同的type来显示不同的住宅类型
        if ((strpos($type,'esb')) || ($type == 'new') || ($type == 'villa')) {
            $data['housetypes'] = \Config::get('conditionConfig.housetype.text');
        } elseif ($type == 'shops') {
            $data['housetypes'] = \Config::get('conditionConfig.housetype1.text');
        } elseif ($type == 'office') {
            $data['housetypes'] = \Config::get('conditionConfig.housetype2.text');
        }

        //价格
        if ($type == 'villa') {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice5.text');
            $averageprices = \Config::get('conditionConfig.averageprice5.number');
        } elseif (($type == 'shops') || ($type == 'office')) {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice1.text');
            $averageprices = \Config::get('conditionConfig.averageprice1.number');
        } else {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice.text');
            $averageprices = \Config::get('conditionConfig.averageprice.number');
        }
        //楼盘类型
        if (strpos($type,'esb') || $type == 'new') {
            $this->houseType1 = 3;
            $leixing = '住宅';
        }elseif ($type == 'office') {
            $this->houseType1 = 2;
            $data['officeLevels'] = \Config::get('conditionConfig.officeLevel.text'); //写字楼等级
            $leixing = '写字楼';
        }elseif ($type == 'shops') {
            $this->houseType1 = 1;
            $leixing = '商铺';
        }elseif($type == 'villa'){
            $this->houseType1 = 3;
            //$this->houseType2 = 304;
            if(empty($this->houseType2)){
                $this->houseType2 = "304 305";
            }
            $leixing = '住宅';
        }
        // 城市编号
        $data['cityid'] = $this->cityId;
        //搜索词
        $data['keyword'] = $this->keyword;
        // 城区区域
        $data['cityareaid'] = $this->cityareaId;
        $data['busid'] = $this->businessAreaId;
        $data['subid'] = $this->subwayLineId;
        $data['stationid'] = $this->subwayStationId;
        $data['bustagid'] = $this->bustagid;
        $data['distance'] = $this->distance;
        $data['school'] = $this->school;
        $data['outerring'] = $this->outerring;
        $data['housetype1'] = $this->houseType1;
        $data['housetype2'] = $this->houseType2;
        $data['averageprice'] = $this->averagePrice;
        $data['inputprice'] = $this->inputPrice;
        $data['singlearea'] = $this->singlearea;
        $data['inputarea'] = $this->inputarea;
        $data['model'] = $this->model;
        $data['feature'] = $this->feature;
        $data['salesStatusPeriods'] = $this->salesStatusPeriods;
        $data['openTimePeriods'] = $this->openTimePeriods;
        $data['subbuild'] = $this->subbuild;
        $data['cityName'] = $this->cityName;
        $data['order'] = $this->order;
        //$data['asc'] = $this->asc;
        $data['page'] = $this->page;
        $data['hwdc'] = $this->hwdc;
        if($this->asc == 0){
            $data['asc'] = 1;
        }elseif($this->asc == 1){
            $data['asc'] = 0;
        }
        //面积
        if (empty($this->inputarea)) {
            $this->singlearea = $this->getConfig($singleareas, $this->singlearea);
        } else {
            $this->singlearea = $this->inputarea;
        }
        //城市区域数据
        $data['cityAreas'] = $this->public->conversion($this->cityArea);
        $data['businessAreas'] = $this->public->conversion($this->public->getBusinessAreas($this->cityId));

        //开盘时间转换
        $this->openTimePeriods = $this->openTimeConversion($this->openTimePeriods);
        //距离
        if (!empty($this->distance)) {
            $distances = \Config::get('conditionConfig.distance.number');
            $this->distance = $this->getConfig($distances, $this->distance);
        }
        //根据关键词查询是否有区域或者子区域
        if(!empty($this->keyword)){
            $cityDao = new CityDao();
            if(!empty($cityAreas = $cityDao->getCityAreaByName($this->keyword))){
                $this->cityareaId = $cityAreas->id;
                $this->keyword = '';
            }
            if(!empty($businessareaAreas = $cityDao->getBusinessareaAreaByName($this->keyword))){
                $this->cityareaId = $businessareaAreas->cityAreaId;
                $this->businessAreaId = $businessareaAreas->id;
                $this->keyword = '';
            }
        }
        //对象类
        $this->lists = new ListInputView($this->cityId, $this->cityareaId, $this->businessAreaId, $this->subwayLineId, $this->subwayStationId, $this->bustagid,$this->communityId, $this->buslineid, $this->busstationid, $this->keyword, $this->outerring, $this->distance, $this->school, $this->from, $this->houseType1, $this->houseType2,$this->singlearea, $this->model, $this->rentway, $this->feature, $this->sfeature, $this->category, $this->spind, $this->hezunum, $this->salesStatusPeriods, $this->openTimePeriods, $this->subbuild, $this->toward,  $this->floor, $this->decorate, $this->buildtype, $this->structure, $this->pei, $this->swlng, $this->swlat, $this->nelng, $this->nelat, $this->order, $this->asc, $this->page, $this->pageset);

        //分销商id
        $this->lists->enterpriseshopId = Input::get('enterpriseshopId');
        //楼盘搜索关键词现改为$communityName 先不用keyword
        //$this->lists->communityName = $this->keyword;
        //$this->lists->keyword = '';
        //是否为新房
        $tlists = new ListInputView();
        $glist = new ListInputView();
        if(($type != 'saleesb')&&($type != 'rentesb')){
            //默认排序
            if(empty($this->order)){
                $this->lists->order = 'timeUpdateLong';
                $this->lists->asc = 0;
            }
            $this->lists->isNew = 1;
            $glist->order = 'timeUpdateLong';
            $glist->isNew = 1;
            $aftertable = 'status';  //统计表后缀
            $wheretag = array('type'=>1,'propertyType1'=>$this->houseType1);
            if(!empty($this->houseType2)){
                if($type == 'villa' && strlen($this->houseType2) > 4){
                    $data['priceAvg'] = 'priceSaleAvg304';
                }else{
                    $data['priceAvg'] = 'priceSaleAvg'.$this->houseType2;
                }
            }else{
                $data['priceAvg'] = 'priceSaleAvg'.$this->houseType1;
            }
        }else{
            //默认排序
            if(empty($this->order)){
                if($type == 'saleesb'){
                    $esborder = 'saleCount';
                }else{
                    $esborder = 'rentCount';
                }
                $this->lists->order = $esborder;
                $this->lists->asc = 0;
                $data['order'] = $esborder;
            }
            $glist->order = !empty($type == 'saleesb')?'saleCount':'rentCount';
            $aftertable = 'status2';
            $wheretag = array('type'=>2,'propertyType1'=>$this->houseType1);
            if($type == 'saleesb'){
                $xclass = 'Sale';
                $salerent = 2;
            }else{
                $xclass = 'Rent';
                $salerent = 1;
            }
            if(!empty($this->houseType2)){
                $data['priceAvg'] = 'price'.$xclass.'Avg'.$this->houseType2;
            }else{
                $data['priceAvg'] = 'price'.$xclass.'Avg'.$this->houseType1;
            }
        }
        /*通过配置文件来转换传递过来的格式*/
        $publicAvg = $data['priceAvg'];//楼盘的价格搜索字段
        $data['priceAvgKey'] = $this->getKeybypriceAvg($publicAvg);
        //价格
        if (empty($this->inputPrice)) {
            $this->averagePrice = $this->getConfig($averageprices, $this->averagePrice);
        } else {
            $this->averagePrice = $this->inputPrice;
        }
        $this->lists->$publicAvg = $this->averagePrice;

        //特色 房源标签
        $data['features'] = $data['featurestag'] = $this->house->getHouseTag($wheretag);//搜索条件的特色
        //模板页面
        if($type =='new'){
            $viewhtml = 'list.xfBuild';
        }else{
            $viewhtml = 'list.otherBuild';
        }

        //判断是h5还是pc ,如果是h5并且没有请求数据标记就返回页面
        if(USER_AGENT_MOBILE && empty(Input::get('f')) && $type == 'new'){//h5
            $data['businessAreaH5'] = $this->public->getBusinessAreaH5($this->cityId,$this->cityArea);
            $data['h5'] = $h5 = 'h5';
            return view($h5.'.'.$viewhtml, $data);
        }
        //调接口 取数据
        if($this->lists->salesStatusPeriods !== null)$this->lists->salesStatusPeriods = (int)$this->lists->salesStatusPeriods;
        $search = new Search();
        $results = $search->searchCommunity($this->lists);
        //当当前查询条件没有查询结果时，取消查询条件再查
        if(!isset($results->error)&&empty($results->hits->total)){
            $data['resBool'] = true;//是否是取消查询条件
            $glist->cityId = $this->cityId;
            $glist->type1 = $this->houseType1;
            $glist->pageset = 20;
            $glist->asc = 0;
            $results = $search->searchCommunity($glist);
        }

        if(!isset($results->error) && !empty($results->hits)){
            $data['total'] = $total = $results->hits->total;
            $data['builds'] = $results->hits->hits;
            $diyTagBuilds = $this->public->getDiyTagBuild($results,$this->houseType1,$this->houseType2);
            $data['diyTagBuilds'] = $this->public->conversion($diyTagBuilds);
        }else{
            $data['total'] = $total = 0;
            $data['builds'] = '';
        }
        //如果请求标记为h5,就进行处理数据并返回
        if(Input::get('f') == 'h5'){
            return $this->dealBuildData($data);
        }
        //判断用户是否登录
        $data['isLogin'] = !empty(Auth::id())?1:0;
        //如果用户登录,等获取该用户的关注房源或者楼盘表
        if(!empty(Auth::id())){
            $interest['uid'] = Auth::id();
            if(strpos($type,'esb')){
                $interest['isNew'] = 0;
            }else{
                $interest['isNew'] = 1;
            }
            $interest['tableType'] =  3;
            $interest['type1'] = $this->houseType1;
            $interest['is_del'] = 0;
            $data['interest'] = $this->house->getInterestByUid($interest);
        }
//        //城市城区商圈价格趋势
//        if(($type == 'saleesb')||($type == 'rentesb')){
//            $priceM = ['isNew'=>0,'type'=>$salerent,'houseType1'=>$this->houseType1,'cityId'=>$this->cityId,'cityareaId'=>$this->cityareaId,'businessAreaId'=>$this->businessAreaId];
//            $priceMovement = $this->public->priceMovement($priceM);
//            $data['priceMovement'] = $priceMovement;
//            if(!empty($priceMovement)){
//                $data['priceUnit'] = ($type == 'saleesb')?'元/平':'元/月';
//                $priceMove = json_decode($priceMovement);
//                $data['currentPrice'] = end($priceMove[1]);
//            }
//        }
        //当前位置 城市名称
        if(!empty($this->cityareaId)){
            $data['cityAreaName'] = RedisCacheUtil::getCityAreaNameById($this->cityareaId);
        }
        if(!empty($this->businessAreaId)){
            $data['businessAreaName'] = RedisCacheUtil::getBussinessNameById($this->businessAreaId);
        }
        //根据搜索的关键词获取数据
        if(!empty($res = $data['builds'])&&!empty(trim($this->keyword))){
            foreach($res as $re){
                if((!empty($re->_source->name)&& trim(strtolower($re->_source->name)) == trim(strtolower($this->keyword)))){
                        $tlists->communityId = $re->_source->id;
                        $tlists->cityId = $re->_source->cityId;
                        $tlists->communityName = $searchword = $re->_source->name;
                        $xhousetype2 = $re->_source->type2;
                        break;
                }
            }
        }

        //统计楼盘或者地铁站点的搜索量
        if(($type != 'saleesb')&&($type != 'rentesb')){
            $sr = 'sale';
            $newold = 'new';
            $arr = array('saleRentType'=>$sr,'newHId'=>$tlists->communityId);
        }else{
            $newold = 'old';
            if($type == 'saleesb'){
                $sr = 'sale';
            }else{
                $sr = 'rent';
            }
            $arr = array('saleRentType'=>$sr,'oldHId'=>$tlists->communityId);
        }
        if(!empty($tlists->communityId)&&!empty($tlists->cityId)){
            $this->public->searchStatistics($tlists->cityId,$newold,$arr,$this->houseType1);
        }

        /* 获取热销楼盘 */
        $data['hotComm'] =  $this->getHotCommunity();
        //获取感兴趣的新房
        if(($type == 'saleesb')||($type == 'rentesb')){
            $wheretag = array('type'=>1,'propertyType1'=>3);
            $data['buildtags'] = $this->house->getHouseTag($wheretag);//搜索条件的特色
            $newlist = new ListInputView();
            $newlist->cityId = $this->cityId;
            $newlist->isNew = true;
            $newlist->pageset = 5;
            $newlist->order = 'timeUpdateLong';
            $search = new Search();
            $results= $search->searchCommunity($newlist);
            //获取搜索数据
            if(!isset($results->error)&&!empty($results->hits->hits)){
                $data['newlists'] = $results->hits->hits;
            }else{
                $data['newlists'] = '';
            }
        }
        /* 判断模板类型 */
        $admodel = $this->getModelType($this->cityId);
        $data['admodels'] = $admodel;
        //分页
        $total = ($total > ($this->maxPage*$this->pageset))?($this->maxPage*$this->pageset):$total;
        $pagingHtml = $this->public->RentPaging($total, $this->page,$this->pageset,$data['linkurl'],$this->purl);
        $data['pagingHtml'] = $pagingHtml;
        return view($viewhtml, $data);
    }

    /**
     * 房源搜索列表
     * @param string $type esfsale:二手房出售 esfrent:二手房出租 bssale:别墅出售 bsrent:别墅出租 spsale:商铺出售 sprent:商铺出租 xzlsale:写字楼出售 xzlrent:写字楼出租
     * @param string $subtype area:区域  sub:地铁 学校:school 户型:model 公交:tbus 商圈:business  build:楼盘(写字楼,商铺出租时才会有)
     * @return 搜索页面
     */
    public function house($type = 'esfsale', $subtype = 'area')
    {
        $data['purl'] = $this->purl;
        //判断所在区域是否有地铁,若没有调到区域选项
        if($subtype == 'sub'){
            if(empty($this->subWay)){
                $subtype = 'area';
            }
        }

        $data['defaultImage'] = '/image/noImage.png';//默认图片地址
        $data['type'] = $type;
        $data['subtype'] = $subtype;
        $data['linkurl'] = '/'.$type.'/'.$subtype;
        $data['keyword'] = $this->keyword;
        $data['cityArea'] = $this->cityArea;
        $data['businessArea'] = $this->businessArea;
        $data['subWay'] = $this->subWay;
        $data['subWayStation'] = $this->subWayStation;
        $GLOBALS['current_listurl'] = config('session.domain').$data['linkurl'];

        $data['distances'] = \Config::get('conditionConfig.distance.text');
        $data['schools'] = \Config::get('conditionConfig.school.text');
        $data['models'] = \Config::get('conditionConfig.models.text');
        $data['areas'] = \Config::get('conditionConfig.areas.text');
        $data['rentways'] = \Config::get('conditionConfig.rentway.text');
        $data['spinds'] = \Config::get('conditionConfig.spind.text');
        $data['hezunums'] = \Config::get('conditionConfig.hezunum.text');
        $data['bustags'] = $this->public->getBusinessTag($this->cityId);

        $data['towards'] = \Config::get('conditionConfig.toward.text');
        //$data['outerrings'] = $this->house->getLoopline($this->cityId);
        $data['thats'] = \Config::get('conditionConfig.that.text');
        $data['floors'] = \Config::get('conditionConfig.floor.text');
        if(strpos($type,'sale')){
            $data['decorates'] = \Config::get('conditionConfig.decorate.text');
        }else{
            $data['decorates'] = \Config::get('conditionConfig.decorate1.text');
        }
        //$data['buildtypes'] = \Config::get('conditionConfig.buildtype.text');
        //$data['structures'] = \Config::get('conditionConfig.structure.text');
        if($type == 'esfsale'|| $type == 'bssale'){
            $data['peis'] = \Config::get('conditionConfig.pei.text');
        }else{
            $data['peis'] = \Config::get('conditionConfig.pei1.text');
        }
        //$data['reltimes'] = \Config::get('conditionConfig.reltime.text');

        //总价 租金
        if ($type == 'esfsale') {
            $data['averageprices'] = \Config::get('conditionConfig.totalprice.text'); //房源 二手房总价
            $averageprices = \Config::get('conditionConfig.totalprice.number');
        } elseif (($type == 'xzlsale') || ($type == 'spsale')) {
            $data['averageprices'] = \Config::get('conditionConfig.totalprice1.text'); //房源 商铺 写字楼 出售 租金
            $averageprices = \Config::get('conditionConfig.totalprice1.number');
        } elseif ($type == 'esfrent') {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice2.text'); //房源 租房租金
            $averageprices = \Config::get('conditionConfig.averageprice2.number');
        } elseif ($type == 'sprent') {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice4.text');  //房源 商铺租金
            $averageprices = \Config::get('conditionConfig.averageprice4.number');
        } elseif ($type == 'xzlrent') {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice4.text');  //房源 写字楼租金
            $averageprices = \Config::get('conditionConfig.averageprice4.number');
        }elseif ($type == 'bssale') {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice6.text');  //豪宅别墅 售总价
            $averageprices = \Config::get('conditionConfig.averageprice6.number');
        }elseif ($type == 'bsrent') {
            $data['averageprices'] = \Config::get('conditionConfig.averageprice7.text');  //豪宅别墅 租金
            $averageprices = \Config::get('conditionConfig.averageprice7.number');
        }else{
            $data['averageprices'] = \Config::get('conditionConfig.averageprice4.text');  //房源 写字楼租金
            $averageprices = \Config::get('conditionConfig.averageprice4.number');
        }

        //面积
        if ($type == 'esfsale') {
            $data['singleareas'] = \Config::get('conditionConfig.areas.text');
            $singleareas = \Config::get('conditionConfig.areas.number');
        } elseif (($type == 'sprent') || ($type == 'spsale')) {
            $data['singleareas'] = \Config::get('conditionConfig.areas1.text');
            $singleareas = \Config::get('conditionConfig.areas1.number');
        } elseif (($type == 'xzlrent') || ($type == 'xzlsale')) {
            $data['singleareas'] = \Config::get('conditionConfig.areas2.text');
            $singleareas = \Config::get('conditionConfig.areas2.number');
        } elseif(($type == 'bsrent') || ($type == 'bssale')) {
            $data['singleareas'] = \Config::get('conditionConfig.areas3.text');
            $singleareas = \Config::get('conditionConfig.areas3.number');
        }else{
            $data['singleareas'] = '';
            $singleareas = '';
        }

        //类型
        if (($type == 'sprent') || ($type == 'spsale')) {
            $data['housetypes'] = \Config::get('conditionConfig.housetype1.text');
        } elseif (($type == 'xzlrent') || ($type == 'xzlsale')) {
            $data['housetypes'] = \Config::get('conditionConfig.housetype2.text');
        }else{
            $data['housetypes'] = \Config::get('conditionConfig.housetype.text');
        }
        $data['types'] = \Config::get('conditionConfig.type.text');
        $data['officeLevels'] = \Config::get('conditionConfig.officeLevel.text');

        //类别
        if ($type == 'sprent') {
            $data['categorys'] = \Config::get('conditionConfig.category.text');
        }
        //公交
        $data['buslines'] = array();
        if (!empty($this->stationkeyword)) {
            $buslines = $this->public->getBusline('1', $this->stationkeyword);

            if (!empty($buslines)) {
                $this->buslineid = $buslines[0]->id;
                $data['buslinename'] = $buslines[0]->name;
                $data['buslines'] = $this->public->getBusstation($buslines);
            } else {
                $busstations = $this->public->getBus('1', $this->stationkeyword);
                $data['buslines'] = $this->public->getBus1($busstations);
                if (!empty($busstations)) {
                    $this->busstationid = $busstations[0]->id;
                }
            }
        }
        // dd($houseType);
        // 需要传入的值
        $data['cityid'] = $this->cityId;
        $data['keyword'] = $this->keyword;
        $data['cityareaid'] = $this->cityareaId;
        $data['busid'] = $this->businessAreaId;
        $data['subid'] = $this->subwayLineId;
        $data['stationid'] = $this->subwayStationId;
        $data['distance'] = $this->distance;
        $data['school'] = $this->school;
        $data['averageprice'] = $this->averagePrice;
        $data['inputprice'] = $this->inputPrice;
        $data['singlearea'] = $this->singlearea;

        $data['communityId'] = $this->communityId;

        $data['inputarea'] = $this->inputarea;
        $data['model'] = $this->model;
        $data['rentway'] = $this->rentway;
        $data['feature'] = $this->feature;
        $data['sfeature'] = $this->sfeature;
        $data['category'] = $this->category;
        $data['housetype2'] = $this->houseType2;
        $data['spind'] = $this->spind;
        $data['hezunum'] = $this->hezunum;
        $data['bustagid'] = $this->bustagid;
        $data['buslineid'] = $this->buslineid;
        $data['busstationid'] = $this->busstationid;
        $data['stationkeyword'] = $this->stationkeyword;

        $data['toward'] = $this->toward;
        $data['outerring'] = $this->outerring;
        $data['that'] = $this->that;
        $data['floor'] = $this->floor;
        $data['decorate'] = $this->decorate;
        //$data['buildtype'] = $this->buildtype;
        //$data['structure'] = $this->structure;
        $data['pei'] = $this->pei;
        $data['cityName'] = $this->cityName;
        $data['order'] = $this->order;
        //$data['asc'] = $this->asc;
        //$data['reltime'] = $this->reltime;
        $data['page'] = $this->page;
        $data['hwdc'] = $this->hwdc;
        if($this->asc == 0){
            $data['asc'] = 1;
        }elseif($this->asc == 1){
            $data['asc'] = 0;
        }
        //特色 房源标签
        if(($type =='esfrent') || ($type =='esfsale')){
            $this->houseType1 = 3;
            $leixing = '住宅';
            $viewhtml = 'list.secondHouse';//视图页面
        }elseif(($type =='xzlrent') || ($type =='xzlsale')){
            $this->houseType1 = 2;
            $leixing = '写字楼';
            $viewhtml = 'list.xzlHouse';//视图页面
        }elseif(($type =='sprent') || ($type =='spsale')){
            $this->houseType1 = 1;
            $leixing = '商铺';
            $viewhtml = 'list.spHouse';//视图页面
        }elseif(($type =='bsrent') || ($type =='bssale')){
            $this->houseType1 = 3;
            $leixing = '住宅';
            if(empty($this->houseType2)){
                $this->houseType2 = "304 305";
            }
            $viewhtml = 'list.secondHouse';//视图页面
        }

        /* 获取热销楼盘 */
        $data['hotComm'] =  $this->getHotCommunity();

        if(($type != 'saleesb')&&($type != 'rentesb')){
            
            if(!empty($this->houseType2)){
                if($type == 'villa' && strlen($this->houseType2) > 4){
                    $data['priceComAvg'] = 'priceSaleAvg304';
                }else{
                    $data['priceComAvg'] = 'priceSaleAvg'.$this->houseType2;
                }
            }else{
                $data['priceComAvg'] = 'priceSaleAvg'.$this->houseType1;
            }
        }else{
            $aftertable = 'status2';
            $wheretag = array('type'=>2,'propertyType1'=>$this->houseType1);
            if($type == 'saleesb'){
                $xclass = 'Sale';
            }else{
                $xclass = 'Rent';
            }
            if(!empty($this->houseType2)){
                $data['priceComAvg'] = 'price'.$xclass.'Avg'.$this->houseType2;
            }else{
                $data['priceComAvg'] = 'price'.$xclass.'Avg'.$this->houseType1;
            }
        }
        $data['housetype1'] = $this->houseType1;
        if($subtype == 'build'){
            $wheretag = array('type'=>2,'propertyType1'=>$this->houseType1);
        }else{
            $wheretag = array('type'=>4,'propertyType1'=>$this->houseType1);
        }
        $data['features'] = $data['featurestag'] = $this->house->getHouseTag($wheretag);//搜索条件的特色

        /*通过配置文件来转换传递过来的格式*/
        //价格
        if (empty($this->inputPrice)) {
            $this->averagePrice = $this->getConfig($averageprices, $this->averagePrice);
        } else {
            $this->averagePrice = $this->inputPrice;
        }
        
        //面积
        if (empty($this->inputarea)) {
            $this->singlearea = $this->getConfig($singleareas, $this->singlearea);
        } else {
            $this->singlearea = $this->inputarea;
        }

        //距离
        if (!empty($this->distance)) {
            $distances = \Config::get('conditionConfig.distance.number');
            $this->distance = $this->getConfig($distances, $this->distance);
        }
        //商铺类别
        if (!empty($this->category)) {
            $xcategory = \Config::get('conditionConfig.category.number');
            $this->category = $this->getConfig($xcategory, $this->category);
            if($this->category == 0) $this->category = (int)$this->category;
        }
        //城市区域数据
        $data['cityAreas'] = $this->public->conversion($this->cityArea);
        $data['businessAreas'] = $this->public->conversion($this->public->getBusinessAreas($this->cityId));
        //根据关键词查询是否有区域或者子区域
        if(!empty($this->keyword)){
            $cityDao = new CityDao();
            if(!empty($cityAreas = $cityDao->getCityAreaByName($this->keyword))){
                $this->cityareaId = $cityAreas->id;
                $this->keyword = '';
            }
            if(!empty($businessareaAreas = $cityDao->getBusinessareaAreaByName($this->keyword))){
                $this->cityareaId = $businessareaAreas->cityAreaId;
                $this->businessAreaId = $businessareaAreas->id;
                $this->keyword = '';
            }
        }
        //对象类
        $this->lists = new ListInputView($this->cityId, $this->cityareaId, $this->businessAreaId, $this->subwayLineId, $this->subwayStationId, $this->bustagid,$this->communityId, $this->buslineid, $this->busstationid, $this->keyword, $this->outerring, $this->distance, $this->school, $this->from, $this->houseType1, $this->houseType2,$this->singlearea, $this->model, $this->rentway, $this->feature, $this->sfeature, $this->category, $this->spind, $this->hezunum, $this->salesStatusPeriods, $this->openTimePeriods, $this->subbuild, $this->toward,  $this->floor, $this->decorate, $this->buildtype, $this->structure, $this->pei, $this->swlng, $this->swlat, $this->nelng, $this->nelat, $this->order, $this->asc, $this->page, $this->pageset);

        //房龄
        $this->lists->buildYear = $this->getBuildYear($this->that);
        $data['from'] = $from =  Input::get('from','');
        if(!empty($from)){
            $this->lists->$from = 1;
            $this->lists->page = 1;
        }
//        if(!empty($this->reltime)){
//            $this->lists->timeRelease = strtotime("-".$this->reltime." days")*1000;
//        }

        //调接口 取数据 针对房源
        if($subtype !='build'){
            if(strpos($type,'sale')){
                $data['objectType'] = 'houseSale';
                $search = new Search('hs');
                $data['sr'] = 's'; //说明是出租还是出售
                $salerent = 2;
                $housetp = 'sale';
                $this->lists->price2 = $this->averagePrice;
            }else{
                $data['objectType'] = 'houseRent';
                $search = new Search('hr');
                $data['sr']  = 'r';
                $salerent = 1;
                $housetp = 'rent';
                if($type == 'xzlrent' || $type == 'sprent'){
                    $this->lists->price2 = $this->averagePrice;
                }else{
                    $this->lists->price1 = $this->averagePrice;
                }
            }
        }else{
            $search = new Search();
            $data['sr']  = 'r';
            $salerent = 1;
        }
        //判断用户是否登录
        $data['isLogin'] = !empty(Auth::id())?1:0;
        //如果用户登录,等获取该用户的关注房源或者楼盘表
        if(!empty(Auth::id())){
            $interest['uid'] = Auth::id();
            if($subtype == 'build'){
                $tableType = 3;
            }else{
                if(strpos($type,'sale')){
                    $tableType = 2;
                }else{
                    $tableType = 1;
                }
            }
            $interest['tableType'] =  $tableType;
            $interest['type1'] = $this->houseType1;
            $interest['isNew'] = 0;
            $interest['is_del'] = 0;
            $data['interest'] = $this->house->getInterestByUid($interest);
        }

        //判断是h5还是pc ,如果是h5并且没有请求数据标记就返回页面
        if(USER_AGENT_MOBILE && empty(Input::get('f')) && $subtype !='build'){//h5
            $data['businessAreaH5'] = $this->public->getBusinessAreaH5($this->cityId,$this->cityArea);
            $data['subWayStationH5'] = $this->public->getSubWayStationH5($this->cityId,$this->subWay);
            $data['h5'] = $h5 = 'h5';
            return view($h5.'.'.$viewhtml, $data);
        }

        //根据关键词查询索引
        $csearch = new Search();
        $tlists = new ListInputView();
        if(!empty(trim($this->keyword))){
            $clist = new ListInputView();
            $clist->keyword = $this->keyword;
            $clist->cityId = $this->cityId;
            $clist->type1 = $this->houseType1;
            $ss = $csearch->searchCommunity($clist);
            if(empty($ss->error)){
                if(!empty($ss->hits->hits)){
                    foreach($ss->hits->hits as $sh){
                        if(trim(strtolower($sh->_source->name)) == trim(strtolower($this->keyword))){
                            $this->lists->communityId = $this->communityId = $sh->_source->id;
                            $tlists->cityId = $sh->_source->cityId;
                            $this->lists->keyword = '';
                            $searchword = $sh->_source->name;
                            $xhousetype2 = $sh->_source->type2;
                            break;
                        }
                    }
                }
            }
        }elseif(!empty($this->communityId)){
            $ss = $csearch->searchCommunityListByIds([$this->communityId]);
            if(!empty($ss->docs[0]->found)){
                $this->lists->communityId = $ss->docs[0]->_source->id;
                $tlists->cityId = $ss->docs[0]->_source->cityId;
                $data['searchword'] = $ss->docs[0]->_source->name;
                $xhousetype2 = $ss->docs[0]->_source->type2;
            }
        }
        $topHouse = array();
        $putHouse = array();
        $data['topHouse'] = $topHouse;
        $data['putHouse'] = $putHouse;
        //当存在经纬度时，说明是从房源详情页过来的，需去除该房源所属楼盘的所有房源
        if(!empty(Input::get('cid'))){
            $this->lists->must_not = [['communityId'=>Input::get('cid')]];
        }

        //列表搜索数据
        if($subtype !='build'){
            if(empty($this->order)){
                $this->lists->order = 'timeRefresh';
                $this->lists->asc = 0;
            }
            $houseList = $this->getHouseFee($this->lists,$search);
            $resultfee = $houseList['resfee']; //付费房源列表
            $data['resultfee'] = $resultfee;
            /* 获取房源置顶及房源定投  */
            $houseStick = $this->getHouseStick($type,$this->houseType1);
            $topHouse = $houseStick['topHouse'];
            $data['topHouse'] = $houseStick['topHouse'];
            $data['putHouse'] = $houseStick['putHouse'];
            $results = $houseList['res'];//普通房源列表
            //当当前查询条件没有查询结果时，取消查询条件再查
            if(empty($data['topHouse'])&&empty($data['resultfee'])&&!isset($results->error)&&empty($results->hits->total)){

                $data['resBool'] = true;//是否是取消查询条件
                $glist = new ListInputView();
                $glist->cityId = $this->cityId;
                $glist->type1 = $this->houseType1;
                $glist->pageset = 20;
                $glist->order = 'timeRefresh';
                $glist->asc = 0;
                $results = $search->searchHouse($glist);
            }
            //房源自定义标签查询
            $diyTagHouse = $this->public->getDiyTagHouse($results);
            $data['diyTagHBs'] = $this->public->conversion($diyTagHouse);
            $data['subNames'] = $this->public->getNameByStationId($this->cityId,$this->subWay);

            $data['businessAreaH5'] = $this->public->getBusinessAreaH5($this->cityId,$this->cityArea);
        }else{
            if(empty($this->order)){
                $this->lists->order = 'rentCount';
                $this->lists->asc = 0;
            }
            //楼盘价格排序
            if($type == 'xzlrent'){
                if(!empty($this->houseType2)){
                    $data['priceAvg'] = 'priceRentAvg'.$this->houseType2;
                }else{
                    $data['priceAvg'] = 'priceRentAvg2';
                }
            }elseif($type == 'sprent'){
                if(!empty($this->houseType2)){
                    $data['priceAvg'] = 'priceRentAvg'.$this->houseType2;
                }else{
                    $data['priceAvg'] = 'priceRentAvg1';
                }
            }
            $publicAvg = $data['priceAvg'];//楼盘的价格搜索字段
            $data['priceAvgKey'] = $this->getKeybypriceAvg($publicAvg);
            $this->lists->$publicAvg = $this->averagePrice;
            $this->lists->keyword = '';
            $this->lists->communityName = $this->keyword;
            $search = new Search();
            $results = $search->searchCommunity($this->lists);
            //当当前查询条件没有查询结果时，取消查询条件再查
            if(!isset($results->error)&&empty($results->hits->total)){
                $data['resBool'] = true;//是否是取消查询条件
                $glist = new ListInputView();
                $glist->cityId = $this->cityId;
                $glist->type1 = $this->houseType1;
                $glist->pageset = 20;
                $glist->order = 'rentCount';
                $glist->asc = 0;
                $results = $search->searchCommunity($glist);
            }
            //楼盘自定义标签查询
            $diyTagBuild = $this->public->getDiyTagBuild($results,$this->houseType1,$this->houseType2);
            $data['diyTagHBs'] = $this->public->conversion($diyTagBuild);
        }
        //获取搜索数据
        if(!isset($results->error)){
            $data['total'] = $total = $results->hits->total;
            $data['houses'] = $results->hits->hits;
        }else{
            $data['total'] = $total = 0;
            $data['houses'] = '';
        }
        //统计楼盘或者地铁站点的搜索量
        if(strpos($type,'sale')){
            $sr = 'sale';
        }else{
            $sr = 'rent';
        }
        if(!empty($this->lists->communityId)&&!empty($tlists->cityId)){
            $arr = array('saleRentType'=>$sr,'oldHId'=>$this->lists->communityId);
            $this->public->searchStatistics($tlists->cityId,'old',$arr,$this->houseType1);
        }
        if(!empty($this->lists->subwayStationId)&&!empty($tlists->cityId)){
            $arr = array('saleRentType'=>$sr,'sId'=>$this->lists->subwayStationId);
            $this->public->searchStatistics($tlists->cityId,'sub',$arr,$this->houseType1);
        }
        
        //如果请求标记为h5,就进行处理数据并返回
        if(Input::get('f') == 'h5'){
            return $this->dealHouseData($data);
        }
//        dd($this->houseType1);
        /* 去除置顶房源与楼盘列表相同的的房源 */
        if(!empty($data['houses']) && !empty($topHouse)){
            $houses = array();
            foreach($data['houses'] as $v){
                if($v->_source->id != $topHouse->_source->id){
                    $houses[] = $v;
                }
            }
            $data['houses'] = $houses;
        }
        //城市城区商圈价格趋势
        $priceM = ['isNew'=>0,'type'=>$salerent,'houseType1'=>$this->houseType1,'cityId'=>$this->cityId,'cityareaId'=>$this->cityareaId,'businessAreaId'=>$this->businessAreaId];
        $priceMovement = $this->public->priceMovement($priceM);
        //dd($priceMovement);
        $data['priceMovement'] = $priceMovement;
        if(!empty($priceMovement)){
            $data['priceUnit'] = ($salerent == 2)?'元/平':($type == 'esfrent')?'元/月':'元/平米▪天';
            $priceMove = json_decode($priceMovement);
            $data['currentPrice'] = end($priceMove[1]);
        }

        //当前城市名称
        if(!empty($this->cityareaId)){
            $data['cityAreaName'] = RedisCacheUtil::getCityAreaNameById($this->cityareaId);
        }
        if(!empty($this->businessAreaId)){
            $data['businessAreaName'] = RedisCacheUtil::getBussinessNameById($this->businessAreaId);
        }
        //获取感兴趣的新房
        $wheretag = array('type'=>1,'propertyType1'=>3);
        $data['buildtags'] = $this->house->getHouseTag($wheretag);//搜索条件的特色
        $newlist = new ListInputView();
        $newlist->cityId = $this->cityId;
        $newlist->isNew = true;
        $newlist->pageset = 5;
        $newlist->order = 'timeUpdateLong';
        $search = new Search();
        $results= $search->searchCommunity($newlist);
        //获取搜索数据
        if(!isset($results->error)){
            $data['newlists'] = $results->hits->hits;
        }else{
            $data['newlists'] = '';
        }
        /* 判断模板类型 */
        $admodel = $this->getModelType($this->cityId);
        $data['admodels'] = $admodel;
//        dd($model);
        //分页
        $total = ($total > ($this->maxPage*$this->pageset))?($this->maxPage*$this->pageset):$total;
        $pagingHtml = $this->public->RentPaging($total,$this->page,$this->pageset,$data['linkurl'],$this->purl);//
        $data['pagingHtml'] = $pagingHtml;
//        dd($data);
        return view($viewhtml, $data);
    }

    //从配置文件中取数据
    public function getConfig($data, $key = '')
    {
        if(isset($data[$key])){
            $res = $data[$key];
            return $res;
        }else{
            return '';
        }
    }
    //年份换算
    public function getBuildYear($key = ''){

        if($key == 1){
            $curr1 = date('Y');
            $curr2 = date('Y', strtotime("-2 years"));
        }elseif($key == 2){
            $curr1 = date('Y', strtotime("-2 years"));
            $curr2 = date('Y', strtotime("-5 years"));
        }elseif($key == 3){
            $curr1 = date('Y', strtotime("-5 years"));
            $curr2 = date('Y', strtotime("-10 years"));
        }elseif($key == 4){
            $curr1 = date('Y', strtotime("-10 years"));
            $curr2 = '1970';
        }else{
            return '';
        }
        return $curr2.','.$curr1;
    }
    //开盘时间转换 $key 键值
    public function openTimeConversion($key){
        $sthisMonthStart = strtotime(date("Ym01"))*1000; //本月月初 时间戳
        $thisMonthStart = date('Ym01', strtotime(date("Ymd"))); //本月月初 日期格式
        $thisMonthEnd = strtotime("$thisMonthStart +1 month -1 day")*1000; //本月月末
        $nextMonthStart = strtotime("$thisMonthStart +1 month")*1000; //下月月初
        $nextMonthEnd = strtotime("$thisMonthStart +2 month -1 day")*1000;//下月月末
        $cthisMonthStart = date("Y-m-d"); //当前时间
        $threeMonthEnd = strtotime("$cthisMonthStart +3 month -1 day")*1000;//三个月月末
        $sixMonthEnd = strtotime("$cthisMonthStart +6 month -1 day")*1000;//六个月个月月末
        $current = date('Y-m-d H:i:s');
        $time = time()*1000;
        $tMonthEnd = strtotime("$current -3 month")*1000;//已开盘三个月
        $sMonthEnd = strtotime("$current -6 month")*1000;//已开盘六个月
        $res = '';
        switch($key){
            case 1:
                $res = $sthisMonthStart.','.$thisMonthEnd;
                break;
            case 2:
                $res = $nextMonthStart.','.$nextMonthEnd;
                break;
            case 3:
                $res = $time.','.$threeMonthEnd;
                break;
            case 4:
                $res = $time.','.$sixMonthEnd;
                break;
            case 5:
                $res = $tMonthEnd.','.$time;
                break;
            case 6:
                $res = $sMonthEnd.','.$time;
                break;
            default:
                $res = '';
        }
        return $res;
    }

    //根据传递的参数初始化传入的条件
    public function checkpar($url){
        $parameter = array('aa'=>'cityareaId','ab'=>'businessAreaId','ac'=>'subwayLineId','ad'=>'subwayStationId','ae'=>'stationkeyword','af'=>'buslineid','ag'=>'busstationid','ah'=>'outerring','ai'=>'distance','aj'=>'school','al'=>'from','am'=>'houseType1','an'=>'houseType2','ao'=>'averagePrice','ap'=>'singlearea','aq'=>'model','ar'=>'rentway','as'=>'feature','at'=>'sfeature','au'=>'category','av'=>'spind','aw'=>'hezunum','ax'=>'salesStatusPeriods','ay'=>'openTimePeriods','az'=>'bustagid','ba'=>'communityId','bb'=>'toward','bc'=>'that','bd'=>'floor','be'=>'decorate','bf'=>'buildtype','bh'=>'pei','bi'=>'order','bj'=>'asc','bk'=>'reltime','bl'=>'page','bm'=>'inputPrice','bn'=>'inputarea');//'bg'=>'structure',
        $order = array(1=>'price1',2=>'price2',3=>'area',4=>'openTimeLong',5=>'saleCount',6=>'rentCount',11=>'priceRentAvg1',12=>'priceRentAvg2',13=>'priceRentAvg3',14=>'priceRentAvg101',15=>'priceRentAvg102',16=>'priceRentAvg103',17=>'priceRentAvg104',18=>'priceRentAvg105',19=>'priceRentAvg106',20=>'priceRentAvg201',21=>'priceRentAvg203',22=>'priceRentAvg204',23=>'priceRentAvg301',24=>'priceRentAvg302',25=>'priceRentAvg303',26=>'priceRentAvg304',27=>'priceRentAvg305',28=>'priceRentAvg306',29=>'priceRentAvg307',30=>'priceSaleAvg1',31=>'priceSaleAvg2',32=>'priceSaleAvg3',33=>'priceSaleAvg101',34=>'priceSaleAvg102',35=>'priceSaleAvg103',36=>'priceSaleAvg104',37=>'priceSaleAvg105',38=>'priceSaleAvg106',39=>'priceSaleAvg201',40=>'priceSaleAvg203',41=>'priceSaleAvg204',42=>'priceSaleAvg301',43=>'priceSaleAvg302',44=>'priceSaleAvg303',45=>'priceSaleAvg304',46=>'priceSaleAvg305',47=>'priceSaleAvg306',48=>'priceSaleAvg307');

        foreach(explode('-',$url) as $v){
            if(!empty($parameter[substr($v,0,2)])){
                $p = $parameter[substr($v,0,2)];
                if($p == 'order'){
                    $this->$p = !empty($order[substr($v,2)])?$order[substr($v,2)]:'';
                }else{
                    $this->$p = substr($v,2);
                }
            }
        }
    }

    //根据均价字段返回均价的键值
    public function getKeybypriceAvg($priceAvg){
        $res = '';
        switch($priceAvg){
            case 'priceRentAvg1':
                $res = 11;
                break;
            case 'priceRentAvg2':
                $res = 12;
                break;
            case 'priceRentAvg3':
                $res = 13;
                break;
            case 'priceRentAvg101':
                $res = 14;
                break;
            case 'priceRentAvg102':
                $res = 15;
                break;
            case 'priceRentAvg103':
                $res = 16;
                break;
            case 'priceRentAvg104':
                $res = 17;
                break;
            case 'priceRentAvg105':
                $res = 18;
                break;
            case 'priceRentAvg106':
                $res = 19;
                break;
            case 'priceRentAvg201':
                $res = 20;
                break;
            case 'priceRentAvg203':
                $res = 21;
                break;
            case 'priceRentAvg204':
                $res = 22;
                break;
            case 'priceRentAvg301':
                $res = 23;
                break;
            case 'priceRentAvg302':
                $res = 24;
                break;
            case 'priceRentAvg303':
                $res = 25;
                break;
            case 'priceRentAvg304':
                $res = 26;
                break;
            case 'priceRentAvg305':
                $res = 27;
                break;
            case 'priceRentAvg306':
                $res = 28;
                break;
            case 'priceRentAvg307':
                $res = 29;
                break;
            case 'priceSaleAvg1':
                $res = 30;
                break;
            case 'priceSaleAvg2':
                $res = 31;
                break;
            case 'priceSaleAvg3':
                $res = 32;
                break;
            case 'priceSaleAvg101':
                $res = 33;
                break;
            case 'priceSaleAvg102':
                $res = 34;
                break;
            case 'priceSaleAvg103':
                $res = 35;
                break;
            case 'priceSaleAvg104':
                $res = 36;
                break;
            case 'priceSaleAvg105':
                $res = 37;
                break;
            case 'priceSaleAvg106':
                $res = 38;
                break;
            case 'priceSaleAvg201':
                $res = 39;
                break;
            case 'priceSaleAvg203':
                $res = 40;
                break;
            case 'priceSaleAvg204':
                $res = 41;
                break;
            case 'priceSaleAvg301':
                $res = 42;
                break;
            case 'priceSaleAvg302':
                $res = 43;
                break;
            case 'priceSaleAvg303':
                $res = 44;
                break;
            case 'priceSaleAvg304':
                $res = 45;
                break;
            case 'priceSaleAvg305':
                $res = 46;
                break;
            case 'priceSaleAvg306':
                $res = 47;
                break;
            case 'priceSaleAvg307':
                $res = 48;
                break;
        }
        return $res;
    }

    //楼盘h5页面数据处理
    public function dealBuildData($data){
        $priceAvg = $data['priceAvg'];
        $builds = $data['builds'];
        $type1 = $data['housetype1'];
        $type2 = $data['housetype2'];
        $diyTagBuilds = !empty($data['diyTagBuilds'])?$data['diyTagBuilds']:'';
        $featurestag = $data['featurestag'];
        if(!empty($builds)){
            foreach($builds as $build){
                //typexxxInfo
                foreach(explode('|',$build->_source->type2) as $tp2){
                    if((substr($tp2,0,1) == $type1) ||(($tp2 =='303')&&($type1 == 2))){
                        $type2 = $tp2;
                        break;
                    }
                }
                if(!empty($type2)){
                    $typeInfo = 'type'.$type2.'Info';
                    if(!empty($build->_source->$typeInfo)){
                        $typeInfo = json_decode($build->_source->$typeInfo);
                    }
                }else{
                    $type2 = $type1.'01';
                }
                $build->_source->xtype2 = $type2;
                //标品标签
                $tags = array();
                if(!empty($typeInfo->tagIds)){
                    foreach(explode('|',$typeInfo->tagIds) as $tagid){
                        if(isset($featurestag[$tagid])){
                            $tags[$tagid] = $featurestag[$tagid];
                        }
                    }
                }
                $build->_source->tags = $tags;
                //自定义标签
                $diytags = array();
                if(!empty($typeInfo->diyTagIds) && !empty($diyTagBuilds)){
                    foreach(explode('|',$typeInfo->diyTagIds) as $diytagid){
                        if(!empty($diyTagBuilds[$diytagid])){
                            $diytags[] = $diyTagBuilds[$diytagid];
                        }
                    }
                }
                $build->_source->diytags = $diytags;
                //优惠信息
                $discountType = !empty($build->_source->discountType)?$build->_source->discountType:0;
                $zhehui = '';
                $youhui = '';
                if(($discountType == 1) && !empty($build->_source->discount)){
                    $zhehui = $build->_source->discount.'折';
                }elseif(($discountType == 2)&&!empty($build->_source->subtract)){
                    $zhehui = '减去'. floor($build->_source->subtract);
                }elseif(($discountType == 3)&& !empty($build->_source->discount)&&!empty($build->_source->subtract)){
                    $zhehui = $build->_source->discount.'折减'. floor($build->_source->subtract);
                }
                if(!empty($build->_source->specialOffers) && strlen($build->_source->specialOffers)>2 && ($build->_source->specialOffers !='0_0')){
                    $youhui = str_replace('_','抵',$build->_source->specialOffers);
                }
                $build->_source->zhehui = $zhehui;
                $build->_source->youhui = $youhui;
                //销售状态
                $salesStatusPeriods = !empty($build->_source->salesStatusPeriods)?$build->_source->salesStatusPeriods:0;
                if($salesStatusPeriods == 1){
                    $build->_source->salesStatusPeriods = '在售';
                }elseif($salesStatusPeriods == 2){
                    $build->_source->salesStatusPeriods = '售完';
                }else{
                    $build->_source->salesStatusPeriods = '待售';
                }
                //均价
                $build->_source->buildPriceAvg = !empty($build->_source->$priceAvg)?$build->_source->$priceAvg:'待定';
                if(!empty($build->_source->titleImage)){
                    $build->_source->titleImage = get_img_url('commPhoto',$build->_source->titleImage,2);
                }else{
                    $build->_source->titleImage = '';
                }

            }
        }else{
            return array();
        }
        return $builds;
    }

    //房源h5页面数据处理
    public function dealHouseData($data){
        $type = $data['type'];
        $type1 = $data['housetype1'];
        $type2 = $data['housetype2'];
        $featurestag = $data['featurestag'];
        $officeLevels = $data['officeLevels'];
        $housetypes = $data['housetypes'];
        $faceTo = $data['towards'];
        $rentType = $data['rentways'];
        $spinds = $data['spinds'];
        $diyTagHBs = !empty($data['diyTagHBs'])?$data['diyTagHBs']:'';
        $houses = $data['houses'];
        if(strpos($type,'sale')){
            $class = 'sale';
        }else{
            $class = 'rent';
        }
        if(!empty($houses)){
            foreach($houses as $house){
                //标品标签
                $tags = array();
                if(!empty($house->_source->tagId)){
                    foreach(explode('|',$house->_source->tagId) as $tagid){
                        if(isset($featurestag[$tagid])){
                            $tags[$tagid] = $featurestag[$tagid];
                        }
                    }
                }
                $house->_source->tags = $tags;
                //自定义标签
                $diytags = array();
                if(!empty($house->_source->diyTagId) && !empty($diyTagHBs)){
                    foreach(explode('|',$house->_source->diyTagId) as $diytagid){
                        if(!empty($diyTagHBs[$diytagid])){
                            $diytags[] = $diyTagHBs[$diytagid];
                        }
                    }
                }
                $house->_source->diytags = $diytags;
                //写字楼等级
                if($type == 'xzlsale' || $type == 'xzlrent'){
                    if(isset($house->_source->officeLevel)){
                        $house->_source->officeLevel = !empty($officeLevels[$house->_source->officeLevel])?$officeLevels[$house->_source->officeLevel].'级':'其它';
                    }else{
                        $house->_source->officeLevel = '其它';
                    }
                }
                if($type1 !=3){
                    if(!empty($house->_source->houseType2)){
                        $house->_source->houseType2 = !empty($housetypes[$house->_source->houseType2])?$housetypes[$house->_source->houseType2]:'其它';
                    }else{
                        $house->_source->houseType2 = '其它';

                    }
                }
                //商铺的目标业务
                if($type == 'spsale'){
                    if(!empty($house->_source->trade)){
                        $arr = explode('|',$house->_source->trade);
                        $house->_source->trade = !empty($spinds[current($arr)])?$spinds[current($arr)]:'';
                    }
                }
                //缩略图
                if(!empty($house->_source->thumbPic)){
                    if($class == 'sale'){
                        $house->_source->thumbPic = get_img_url('houseSale',$house->_source->thumbPic,2);
                    }else{
                        $house->_source->thumbPic = get_img_url('houseRent',$house->_source->thumbPic,2);
                    }
                }else{
                    $house->_source->thumbPic = '';
                }
                //楼盘名
                if(empty($house->_source->name)){
                    $house->_source->name = '';
                }
                //朝向
                if(!empty($house->_source->faceTo)){
                    if(!empty($faceTo[$house->_source->faceTo])){
                        $house->_source->faceTo = $faceTo[$house->_source->faceTo];
                    }else{
                        $house->_source->faceTo = '其它';
                    }
                }else{
                    $house->_source->faceTo = '其它';
                }
                //租赁方式
                if(!empty($house->_source->rentType)){
                    if(!empty($rentType[$house->_source->rentType])){
                        $house->_source->rentType = $rentType[$house->_source->rentType];
                    }else{
                        $house->_source->rentType = '其它';
                    }
                }

            }
        }else{
            return array('class'=>'','houses'=>array());
        }
        return array('class'=>$class,'houses'=>$houses);
    }
    /* 获取房源置顶 */
    public function getHouseStick($type,$houseType1){
        if(strpos($type,'sale')){
            $housetp = 'sale';
            $fangtype = 'hs';
        }else{
            $housetp = 'rent';
            $fangtype = 'hr';
        }
        /* 获取房源置顶  */
        $data['topHouse'] = '';
        $data['putHouse'] = '';
        $communityId = $this->communityId;
        $searchhouse = new Search($fangtype);
        if($communityId){
            /* 通过楼盘id 获取(房源置顶) */
            $houseInfo = $this->house->getHouseStickByCom($communityId,$housetp,$houseType1);
            if($houseInfo){
                $topHouse = $searchhouse->searchHouseById($houseInfo->hId);
//                dd($topHouse);
                if($topHouse->found){
                    if ($topHouse->_source->houseType1 == 1) {
                        $housetypes = \Config::get('conditionConfig.housetype1.text');
                    } elseif ($topHouse->_source->houseType1 == 2) {
                        $housetypes = \Config::get('conditionConfig.housetype2.text');
                    }else{
                        $housetypes = \Config::get('conditionConfig.housetype.text');
                    }
                    $topHouse->_source->housetypes = $housetypes;
                    $data['topHouse'] = $topHouse;
                }else{
                    $topHouse = $this->house->getHouseByDatabase($housetp,$houseInfo->hId,$houseInfo->uId,$houseInfo->communityId);
//                    dd($topHouse);
                    if($topHouse->found == true){
                        if ($topHouse->_source->houseType1 == 1) {
                            $housetypes = \Config::get('conditionConfig.housetype1.text');
                        } elseif ($topHouse->_source->houseType1 == 2) {
                            $housetypes = \Config::get('conditionConfig.housetype2.text');
                        }else{
                            $housetypes = \Config::get('conditionConfig.housetype.text');
                        }
                        $topHouse->_source->housetypes = $housetypes;
                        $data['topHouse'] = $topHouse;
                    }
                }
            }
            /* 通过 楼盘id 获取(房源定投) */
            $housePutbyComm = $this->house->getHousePutByCom($communityId,$housetp,$houseType1);
            if($housePutbyComm){
                foreach($housePutbyComm as $k => $v){
                    $housePutRes = $searchhouse->searchHouseById($v->hId);
                    if($housePutRes->found){
                        $data['putHouse'][$k] = $housePutRes;
                    }else{
                        $putRes = $this->house->getHousePutbyCommDB($housetp,$v->hId,$v->uId);
                        if(!empty($putRes->found)){
                            $data['putHouse'][$k] = $putRes;
                        }
                    }
                }
            }
        }else{
            $subwayStationId = $this->subwayStationId;
            if($subwayStationId){
                /*通过地铁id 获取（房源定投） 楼盘 */
                unset($searchhouse);
                $searchhouse = new Search($fangtype);
                $housePutbySubway = $this->house->getHousePutBySubway($subwayStationId,$housetp,$houseType1);

                if($housePutbySubway){
                    foreach($housePutbySubway as $k => $v){
                        $housePutbySubwayRes = $searchhouse->searchHouseById($v->hId);
                        if($housePutbySubwayRes->found){
                            $data['putHouse'][$k] = $housePutbySubwayRes;
                        }else{
                            $putRes = $this->house->getHousePutbyStationDB($housetp,$v->hId,$v->uId);
                            if($putRes->found){
                                $data['putHouse'][$k] = $putRes;
                            }
                        }
                    }
                }
                // dd($data);
                // dd($data['putHouse']);
                /* 通过地铁id获取（房源置顶） 楼盘 */
                $topHouseBySubway = $this->house->getHouseStickByStation($subwayStationId,$housetp,$houseType1);
                if($topHouseBySubway){
                    $topHouse = $searchhouse->searchHouseById($topHouseBySubway->hId);
                    if($topHouse->found){
                        if ($topHouse->_source->houseType1 == 1) {
                            $housetypes = \Config::get('conditionConfig.housetype1.text');
                        } elseif ($topHouse->_source->houseType1 == 2) {
                            $housetypes = \Config::get('conditionConfig.housetype2.text');
                        }else{
                            $housetypes = \Config::get('conditionConfig.housetype.text');
                        }
                        $topHouse->_source->housetypes = $housetypes;
                        $data['topHouse'] = $topHouse;
                    }else{
                        $topHouse = $this->house->getHouseByStationDatabase($housetp,$topHouseBySubway->hId,$topHouseBySubway->uId,$topHouseBySubway->subwaystationId);
                        if($topHouse->found == true){
                            if ($topHouse->_source->houseType1 == 1) {
                                $housetypes = \Config::get('conditionConfig.housetype1.text');
                            } elseif ($topHouse->_source->houseType1 == 2) {
                                $housetypes = \Config::get('conditionConfig.housetype2.text');
                            }else{
                                $housetypes = \Config::get('conditionConfig.housetype.text');
                            }
                            $topHouse->_source->housetypes = $housetypes;
                            $data['topHouse'] = $topHouse;
                        }
                    }
                }
            }
        }
        return $data;
    }
    
    /* 获取热销楼盘 */
    public function getHotCommunity(){
//        dd($this->houseType1);
        $tlists = new ListInputView();
        $tlists->isNew = 1;
        $tlists->pageset = 3;
        $tlists->cityId = $this->cityId;
        $tlists->order = 'timeUpdateLong';
        $tlists->asc = 0;
        $tlists->type1 = $this->houseType1;
        $search = new Search();

        /* 获取热销楼盘 */
        $hotComm = $search->searchCommunity($tlists);
//         dd($hotComm);
        if(!empty($hotComm->hits)){  
           
            foreach($hotComm->hits->hits as $k => $v){
                // dd($v);
                // dd($v->cityareaid);
//                $discountType = !empty($v->_source->discountType)?$v->_source->discountType:0;
//                $zhehui = '';
//                $youhui = '';
//                // dd($v);
//                if(($discountType == 1) && !empty($v->_source->discount)){
//                    $zhehui = $v->_source->discount.'折';
//                }elseif(($discountType == 2)&&!empty($v->_source->subtract)){
//                    $zhehui = '减去'. floor($v->_source->subtract);
//                }elseif(($discountType == 3)&& !empty($v->_source->discount)&&!empty($v->_source->subtract)){
//                    $zhehui = $v->_source->discount.'折减'. floor($v->_source->subtract);
//                }
//                if(!empty($v->_source->specialOffers) && strlen($v->_source->specialOffers)>2 && ($v->_source->specialOffers !='0_0')){
//                    $youhui = str_replace('_','抵',$v->_source->specialOffers);
//                }
//                if(empty($v->_source->titleImage)){
//                    $v->_source->titleImage = '';
//                }
//                $v->_source->type2 = substr($v->_source->type2,0,3);
//                $v->_source->zhehui = $zhehui;
//                $v->_source->youhui = $youhui;
                $v->_source->type2 = substr($v->_source->type2,0,3);
                $v->_source->type1 = $this->houseType1;
                $v->_source->priceAverg = 'priceSaleAvg'.$this->houseType1;
                $v->_source->areaname = RedisCacheUtil::getCityAreaNameById($v->_source->cityAreaId);
            }
            $hotComm = $hotComm->hits->hits;
        }else{
            $hotComm = '';
        }
//        dd($hotComm);
        return $hotComm;
    }
    /* 获取二手楼盘 */
    public function getOldCommunity(){
//        dd($this->houseType1);
        $tlists = new ListInputView();
        $tlists->isNew = 0;
        $tlists->pageset = 3;
        $tlists->cityId = $this->cityId;
        $tlists->asc = 0;
        $tlists->type1 = $this->houseType1;
        $search = new Search();

        /* 获取热销楼盘 */
        $oldComm = $search->searchCommunity($tlists);
        //dd($oldComm);
        if(!empty($oldComm->hits)){
            $oldComm = $oldComm->hits->hits;
        }else{
            $oldComm = '';
        }
        return $oldComm;
    }
    /* 获取付费房源 */
    private function getHouseFee($lists,$search){
        $pagelistset = config('houseListPageConfig');
        $lists->pageset = $pagelistset['pagefeeset'];
        $lists->page = 1;
        $result = $search->searchHouse($lists,true);
//        dd($result);
        $resultfee = array();
        $uidArr = array();
        $param = array();
        $pageCode = $this->page;
        if($pageCode <=4){
            if(!isset($result->error)){
                $resultfee = $result->hits->hits;
                foreach($resultfee as $v){
                    foreach($v->_source->brokers as $k1=>$v1){
                        if(!in_array($v1->id,$uidArr)){
                            $uidArr[] = $v1->id;
                        }
                    }
                }
                $length = count($uidArr)*$pagelistset['multipart'];
                if($length >$pagelistset['maxperpageset']){
                    $length = $pagelistset['maxperpageset'];
                }
                $lists->pageset = $length;
                $lists->page = $pageCode;
                $resfee = $search->searchHouse($lists,true);
                $param['resfee'] = $resfee->hits->hits;
                $lists->pageset = $pagelistset['pageset'];
                $res = $search->searchHouse($lists);
                $param['res'] = $res;
            }else{
                $lists->page = $pageCode;
                $lists->pageset = $pagelistset['pageset'];
                $res = $search->searchHouse($lists);
                $param['resfee'] = array();
                $param['res'] = $res;
            }
        }else{
            $lists->page = $pageCode;
            $lists->pageset = $pagelistset['pageset'];
            $res = $search->searchHouse($lists);
            $param['resfee'] = array();
            $param['res'] = $res;
        }
        return $param;
    }
    /*
     * 判断当前城市所用模板
     */
    private function getModelType($cityId){
        $res = $this->house->getCityModel($cityId);
        return $res;
    }
}
