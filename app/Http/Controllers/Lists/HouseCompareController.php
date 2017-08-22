<?php
namespace App\Http\Controllers\Lists;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Dao\Esf\EsfDao;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Utils\RedisCacheUtil;
use App\Http\Controllers\SofangFileClient\SofangFileClientController;
use App\Services\Search;
use Redirect;
use Request;

/**
 * Description of HouseController （房源对比）
 *
 * @author  zhuwei
 */
class HouseCompareController extends Controller{
    protected $esfDao;
    protected $uri;
    public function __construct() {
        $this->uri = explode('/',Request::path());
        $this->esfDao = new EsfDao();
    }

    /**
     *  展示对比信息
     */
    public function compareView(){
        $GLOBALS['current_listurl'] = config('session.domain');  
        $houseIds = Input::get('houseId','');
        if(empty($houseIds)){
            return Redirect::to('http://'.CURRENT_CITYPY.'.'.config('session.domain'));
        }       
        $houseIds = explode(',',$houseIds);
        
        $info = $this->getHouseDataByHouseIds($houseIds);
        //$city = RedisCacheUtil::getCityNameById(CURRENT_CITYID);  // 市
        $city = CURRENT_CITYNAME;
        $houseDatas = $info['info'];
        $houseImages = $info['houseImages'];
        $souUrl = '';
        foreach($houseDatas as $keyHouse => $house){
            if(!empty($houseImages)){
                foreach($houseImages as $key => $value){
                    if($key == $house->id){
                        $houseDatas[$keyHouse]->huXingImage = $value;
                    }
                }
            }else{
                $houseDatas[$keyHouse]->huXingImage = '/image/noImage.png';
            }           
            $souUrl = $house->url;
        }
        if(empty($houseDatas) && isset($_SERVER['HTTP_REFERER'])){
            return Redirect::to($_SERVER['HTTP_REFERER']);
        }
        return view('list.houseCompare', compact('houseDatas','city','houseIds','souUrl'))->with('uri',$this->uri[1]);
    }
    // 从索引取房源的具体数据
    protected function getHouseDataByHouseIds($houseIds){
        $info = [];
        // 出售房源
        if($this->uri[1] == 'sale'){
            $search = new Search('hs');
            $houseImages = $this->esfDao->getHouseImagesByHouseIds($houseIds,'housesaleimage');
        }
        // 出租房源
        if($this->uri[1] == 'rent'){
            $search = new Search('hr');
            $houseImages = $this->esfDao->getHouseImagesByHouseIds($houseIds,'houserentimage');
        }
        // 处理户型图片
        if(!empty($houseImages)){
            $houseImages = $this->houseHuXingImage($houseImages);
        } 
        for($i = 0;$i < count($houseIds);++$i){
            $result = $search->searchHouseById($houseIds[$i]);
            if($result->found){
                $info[] = $this->getHouseDetailData($result->_source);
            }
        }
        return [
            'info' => $info,
            'houseImages' => $houseImages,
        ];
    }
    /**
     *  处理索引返回的数据
     * @param  $data   索引返回的数据
     */
    protected function getHouseDetailData($data){
        //$data = json_decode(json_encode($data),true);
        if($this->uri[1] == 'rent' && !empty($data->thumbPic)){
            $data->thumbPic = get_img_url('houseRent',$data->thumbPic,5);
        }
        if($this->uri[1] == 'sale' && !empty($data->thumbPic)){
            $data->thumbPic = get_img_url('houseRent',$data->thumbPic,5);
        }
        // 住宅数据处理
        if($data->houseType1 == 3){
            $data->url = '/esf'.$this->uri[1].'/area';
            if($this->uri[1] == 'rent'){
                $data = $this->rentType($data);
            }
            $data = $this->getZhuData($data);
        }
        // 写字楼数据处理
        if($data->houseType1 == 2){
            $data->url =  '/xzl'.$this->uri[1].'/area';
            $data = $this->getXzlData($data);
        }
        // 商铺数据处理
        if($data->houseType1 == 1){
            $data->url =  '/sp'.$this->uri[1].'/area';
            $data = $this->getSpData($data);
        }
        if($data->houseType1 == 3 || $data->houseType1 == 1){
            $data = $this->getZhuSpData($data);
        }
        /***********  共有的数据  ************/ 
        // 处理特色标签
        if(isset($data->tagId)){
            $tagsId = str_replace('|',',',$data->tagId);
            $tagsId = explode(',',$tagsId);
            // 查询标签
            $taginfo = $this->esfDao->getTags($tagsId,4);
            $data->tag = $taginfo;
        }
        // 支付方式
        if($this->uri[1] == 'rent'){
            $paymentType = ['1' => '押一付三', '2' => '押一付二', '3' => '押一付一', '4' => '押二付一', '5' => '押二付二', '6' => '押二付三', '7' => '押三付一', '8' => '押三付三', '9' => '半年付', '10' => '年付', '11' => '面议',];
            $data->paymentType = isset($paymentType[$data->paymentType]) ? $paymentType[$data->paymentType] : '';
        }
        // 房源标题
        //$data->title1 = mb_substr($data->title,0,8);
        $data->title1 = $data->title;
        // 副物业类型
        $houseType2 = ['101'=>'住宅底商','102'=>'商业街商铺','103'=>'临街商铺','104'=>'写字楼底商','105'=>'购物中心商铺','106'=>'其他','201'=>'纯写字楼','203'=>'商业综合体楼','204'=>'酒店写字楼','303'=>'商住楼','301'=>'普宅','302'=>'经济适用房','304'=>'别墅','305'=>'豪宅','306'=>'平房','307'=>'四合院','401'=>'其他-厂房','402'=>'其他-其他'];
        $data->houseType2 = $houseType2[$data->houseType2];
        // 装修状况
        $fitment = ['0'=>'无','1'=>'毛坯','2'=>'简装','3'=>'中装修','4'=>'精装修','5'=>'豪华装修'];
        $data->fitment = $fitment[$data->fitment];
        // 参考首付、月供
        if($this->uri[1] == 'sale'){
            if($data->firstPay == '0.0' || $data->firstPay == '0.00' || empty($data->firstPay)){
                $data->firstPay = $data->price2*0.3;
            }
        }
        return $data;
    }


    /**
     *  处理户型图片
     * @param   $houseImages    户型图片数据
     */
    protected function houseHuXingImage($houseImages){
        $Images = [];
        foreach($houseImages as $key => $value){
            if(isset($value[0]->fileName)){
                if($this->uri[1] == 'sale'){
                    $Images[$key] = !empty($value[0]->fileName) ? get_img_url('houseSale',$value[0]->fileName,5) : '/image/noImage.png';
                }
                if($this->uri[1] == 'rent'){
                    $Images[$key] = !empty($value[0]->fileName) ? get_img_url('houseRent',$value[0]->fileName,5) : '/image/noImage.png';
                }
            }
        }
        return $Images;
    }
    /**
     *  支付方式
     */
    protected function rentType($data){
        $rentType = [1 => '整租',2 => '合租',3 => '短租',4 => '日租'];
        if(isset($data->rentType)){
            $data->rentType = $rentType[$data->rentType];
        }
        return $data;
    }
    /**
     *  处理住宅的数据
     */
    protected function getZhuData($data){
        $ownership = ['0'=>'无','1'=>'个人产权','2'=>'使用权','3'=>'经济适用房','4'=>'单位产权','5'=>'央产','6'=>'军产','7'=>'其他','8'=>'限价房'];
        if(isset($data->ownership)){
            $data->ownership =  $ownership[$data->ownership];
        }
         // 朝向处理
        if(isset($data->faceTo)){
            switch($data->faceTo){
                case 1:
                    $data->faceTo = '东';
                    break;
                case 2:
                    $data->faceTo = '南';
                    break;
                case 3:
                    $data->faceTo = '西';
                    break;
                case 4:
                    $data->faceTo = '北';
                    break;
                case 5:
                    $data->faceTo = '南北';
                    break;
                case 6:
                    $data->faceTo = '东南';
                    break;
                case 7:
                    $data->faceTo = '西南';
                    break;
                case 8:
                    $data->faceTo = '东北';
                    break;
                case 9:
                    $data->faceTo = '西北';
                    break;
                case 10:
                    $data->faceTo = '东西';
                    break;
                default:
                    $data->faceTo = '其他';
                    break;
            }
        }
        // 处理建筑形式
        if(isset($data->buildingType)){
            switch($data->buildingType){
                case 1:
                    $data->buildingType = '塔楼';
                    break;
                case 2:
                    $data->buildingType = '砖混';
                    break;
                case 3:
                    $data->buildingType = '钢混';
                    break;
                case 4:
                    $data->buildingType = '板楼';
                    break;
                case 5:
                    $data->buildingType = '砖楼';
                    break;
                case 6:
                    $data->buildingType = '平房';
                    break;
                case 7:
                    $data->buildingType = '塔板结合';
                    break;
                case 8:
                    $data->buildingType = '独栋';
                    break;
                case 9:
                    $data->buildingType = '双拼';
                    break;
                case 10:
                    $data->buildingType = '联排';
                    break;
                case 11:
                    $data->buildingType = '叠加';
                    break;
                default :
                    $data->buildingType = '其他';
                    break;
            }
        }
        //  户型
        if(isset($data->roomStr)){
            $data->roomStr = explode('_',$data->roomStr);
        }
        return $data;
    }
    /**
     * 处理写字楼的数据
     */
    protected function getXzlData($data){
        $officeLevel = ['0'=>'甲','1'=>'乙','2'=>'丙','3'=>'其他'];
        if(isset($data->officeLevel)){
            $data->officeLevel = $officeLevel[$data->officeLevel];
        }
        return $data;
    }
    
    /**
     *  处理商铺的数据
     */
    protected function getSpData($data){
        // 目标业务
        if(isset($data->trade) && !empty($data->trade)){
            $trade = explode('|',$data->trade);
            foreach($trade as $i => $t){
                switch($t){
                    case 1:
                        $trade[$i] = '百货超市';
                        break;
                    case 2:
                        $trade[$i] = '酒店宾馆';
                        break;
                    case 3:
                        $trade[$i] = '家居建材';
                        break;
                    case 4:
                        $trade[$i] = '服饰鞋包';
                        break;
                    case 5:
                        $trade[$i] = '生活服务';
                        break;
                    case 6:
                        $trade[$i] = '美容美发';
                        break;
                    case 7:
                        $trade[$i] = '餐饮美食';
                        break;
                    case 8:
                        $trade[$i] = '休闲娱乐';
                        break;
                    case 9:
                        $trade[$i] = '其他';
                        break;
                }
            }           
            $data->trade = trim(implode(',',$trade));
        }
        // 商铺状态
        $stateShop = ['0'=>'营业中','1'=>'闲置中','2'=>'新铺'];
        if(isset($data->stateShop)){
            $data->stateShop = $stateShop[$data->stateShop];
        }
        return $data;
    }
    /**
     * 处理商铺和住宅的数据
     */
    protected function getZhuSpData($data){
        if($this->uri[1] == 'rent'){
            $equipment = ['1' => '拎包入住', '2' => '家电齐全', '3' => '可上网', '4' => '可做饭', '5' => '可洗澡', '6' => '空调房', '7' => '可看电视', '8' => '有暖气', '9' => '车位'];
        }
        if($this->uri[1] == 'sale'){
            $equipment = ['1' => '集中供暖', '2' => '自采暖', '3' => '煤气/天然气', '4' => '车位/车库', '5' => '电梯', '6' => '储藏室/地下室', '7' => '花园/小院', '8' => '阳台/露台', '9' => '阁楼'];
        }
        if($data->equipment == ' '){
            $data->equipment = '';
        }else{
            $data->equipment = explode('|',$data->equipment);
            foreach($data->equipment as $k => $v){
                switch($v){
                    case 1:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 2:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 3:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 4:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 5:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 6:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 7:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 8:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    case 9:
                        $data->equipment[$k] = $equipment[$v];
                        break;
                    default:
                        $data->equipment[$k] = '';
                        break;
                }
            }
            $data->equipment = trim(implode(',',$data->equipment),',');
        }
        return $data;
    }

}