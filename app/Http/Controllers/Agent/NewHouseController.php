<?php
namespace App\Http\Controllers\Agent;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Dao\Agent\HouseDao;
use App\Http\Controllers\Lists\PublicController;
use App\Http\Controllers\Utils\UploadImgUtil;
use App\Dao\City\CityDao;
/**
 * Description of NewHouseController （经纪人后台增量房源库录入、编辑房源）
 * @since 1.0
 * @author xcy
 */
class NewHouseController extends Controller{
    public $uid;                    //经纪人id
    public $house;                  //房源数据库类
    public $buildingStructures;     //建筑结构
    public $buildingTypes;          //建筑类别
    public $faces;                  //朝向
    public function __construct(){
        $this->uid = 1;
        $this->house = new HouseDao();
        //建筑形式 结构
        $this->buildingStructures = array(1=>'跃层',2=>'开间',3=>'错层',4=>'复式',5=>'平层');
        //建筑形式 类别
        $this->buildingTypes = array(1=>'塔楼',2=>'砖混',3=>'钢混',4=>'板楼',5=>'砖楼',6=>'平房',7=>'塔板结合',8=>'独栋',9=>'双拼',10=>'联排',11=>'叠加');
        //朝向
        $this->faces = array(1=>'东',2=>'南',3=>'西',4=>'北',5=>'南北',6=>'东南',7=>'西南',8=>'东北',9=>'西北',10=>'东西');
    }

    /**
     * 增量房源库 添加编辑新房
     * @since 1.0
     * @author xcy
     * @param $type house:住宅  villa:别墅
     * @param $m 是否使用模板
     * @param $id $m存在,$id代表的是房源模板的id;反之,$id代表的是房源表数据的id
     * @return
     */
    public function newHouse($type = 'house',$id = '',$m=''){
        $data['type'] = $type;
        //初始化数据
        $data['deliverys'] = array(0=>'现房',1=>'期房');
        $data['faces'] = $this->faces;
        $data['fitments'] = array(1=>'毛坯',2=>'简装',3=>'中装修',4=>'精装修',5=>'豪华装修');
        $data['equipments'] = array(3=>'煤气/天然气',4=>'暖气',7=>'宽带',15=>'车位/车库',17=>'电梯',18=>'储藏室/地下室',19=>'花园/小院',20=>'露台',21=>'阁楼');
        $data['buildingStructures'] = $this->buildingStructures;
        $data['buildingTypes'] = $this->buildingTypes;

        //获取模板数据
        if($type == 'house'){
            $where['houseType1'] = 1;
        }elseif($type == 'villa'){
            $where['houseType1'] = 6;
        }
        $where['uid'] = $this->uid;
        $data['models'] = $this->house->getHouseModel($where);

        //获取编辑数据
        if(!empty($id)){
            if(!empty($m)){ //$id代表的是房源模板的id
                $data['housesaleid'] = Input::get('id');
                $data['house'] = $this->house->getHouseModelById($this->uid,$id);
            }else{ //$id代表的是房源表数据的id
                $status = 2; //审核状态  0、未审核  1、审核进行中   2、审核通过  3、审核未通过
                $data['status'] = $status;
                $info = $this->house->getHouseImg( $this->uid, $id);
                $imageInfo = [];
                foreach($info as $key => $val){
                    $imageInfo[$this->typeCase($val->type)][] = $val;
                }
                unset($info);
                $data['info'] = $imageInfo;
                $data['housesaleid'] = $id;
                $data['house'] = $this->house->getHouseById($this->uid,$id);

            }
            //根据户型id获取户型名称
            if(!empty($data['house'])){
                $roomname = $this->house->getRoomModelById($data['house']->roomId);
                $data['roomname'] = $roomname->name;
            }
        }

        return view('agent.newHouse',$data);
    }

    /**
     * 判断图片字段类型
     * @param string $type 1：户型图；2：客厅；3：卧室；4：厨房；5：卫生间；6：阳台；7：其它；8：外景；；9：标题；
     */
    protected function typeCase( $type ){
        switch($type){
            case 1:
                return 'huxing';

            case 2:
                return 'keting';

            case 3:
                return 'woshi';

            case 4:
                return 'chufang';

            case 5:
                return 'weishengjian';

            case 6:
                return 'yangtai';

            case 8:
                return 'waijing';

            case 9:
                return 'biaoti';

            default:
                return 'other';
        }
    }
    //管理新房房源 releaseing:已发布  releaseed:未发布 expired:过期
    public function newHouseManage($type = 'releaseing'){
        $data['type'] = $type;
        $data['faces'] = array(1=>'东',2=>'南',3=>'西',4=>'北',5=>'南北',6=>'东南',7=>'西南',8=>'东北',9=>'西北',10=>'东西');
        $data['housetypes'] = array(1=>'普通住宅',2=>'公寓',3=>'写字楼',4=>'商铺',5=>'厂房',6=>'别墅',7=>'其它',8=>'青年公寓');
        $communityId = Input::get('communityId');
        $starttime = Input::get('starttime',0);
        $endtime = Input::get('endtime',date('Y-m-d'));
        $houseType1 = Input::get('houseType1',0);
        $data['houseType1'] = $houseType1;
        $offset = 1;//每页显示数量
        $pagenum = Input::get('page',1);
        $where['uid'] = $this->uid;
        if(!empty($communityId)){
            $where['communityId'] = $communityId;
        }
        if(!empty($houseType1)){
            $where['houseType1'] = $houseType1;
        }
        if(empty($endtime) || empty($starttime)){
            $starttime =0;
            $endtime = date('Y-m-d');
        }else{
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
        }

        //时间
        $time = array('h.timeCreate',array($starttime,$endtime));

        if($type == 'releaseing'){
            $where['state'] = 1;
            $houses = $this->house->houseManage($where,$time,$offset,$pagenum);
        }elseif($type == 'releaseed'){
            $where['state'] = 0;
            $houses = $this->house->houseManage($where,$time,$offset,$pagenum);
        }elseif($type == 'expired'){
            dd('暂未开发');
        }
        $data['houses'] = $houses['house'];
        //分页
        //引入公共类
        $page = new PublicController();
        $total = $houses['count'];
        echo $total;
        $pagingHtml = $page->RentPaging($total,$pagenum,$offset);
        $data['pagingHtml'] = $pagingHtml;
        return view('agent.newManage',$data);
    }

    /**
     * 增量房源库 添加编辑新房提交
     * @since 1.0
     * @author xcy
     * @param $type house:住宅  villa:别墅
     * @param $m 是否使用模板
     * @return 1:成功 其他:失败
     */
    public function newHouseSub($type='house',$m = ''){
        $data['cityId'] = Input::get('cityId');
        $data['cityareaId'] = Input::get('cityareaId');
        $data['businessAreaId'] = Input::get('businessAreaId');
        $data['buildingId'] = Input::get('buildingId');
        $data['communityId'] = Input::get('communityId');
        $data['title'] = Input::get('title');
        $data['uid'] = $this->uid;
        $data['houseRoom'] = Input::get('houseRoom');
        $data['roomStr'] = Input::get('roomStr');
        $data['faceTo'] = Input::get('faceTo');
        $data['roomId'] = Input::get('roomId');
        $data['houseNum'] = Input::get('houseNum');
        $data['totalPrice'] = Input::get('totalPrice');
        $data['oldTotalPrice'] = Input::get('oldTotalPrice');
        $data['price'] = Input::get('price');
        $data['oldPrice'] = Input::get('oldPrice');
        $data['buildingStructure'] = Input::get('buildingStructure');
        $data['buildingType'] = Input::get('buildingType');
        $data['delivery'] = Input::get('delivery');
        $data['area'] = Input::get('area');
        $data['practicalArea'] = Input::get('practicalArea');
        $data['fitment'] = Input::get('fitment');
        if(!empty(Input::get('equipment'))){
            $data['equipment'] = implode('|',Input::get('equipment'));
        }
        if($type == 'house'){
            $data['unit'] = Input::get('unit');
            $data['houseType1'] = 1;
        }elseif($type == 'villa'){
            $data['gardenArea'] = Input::get('gardenArea');
            $data['floorHeight'] = Input::get('floorHeight');
            $data['basementArea'] = Input::get('basementArea');
            $data['totalFloor'] = Input::get('totalFloor');
            $data['houseType1'] = 6;
        }

        $communityId = 259503;
        $type = 'community';
        $upload = new UploadImgUtil;

        $img['saloon'] = json_decode(Input::get('saloon'));
        $img['bedroom'] = json_decode(Input::get('bedroom'));
        $img['kitchen'] = json_decode(Input::get('kitchen'));
        $img['balcony'] = json_decode(Input::get('balcony'));
        $img['toilet'] = json_decode(Input::get('toilet'));
        $img['exterior'] = json_decode(Input::get('exterior'));
        $img['title'] = json_decode(Input::get('titleimg'));
        //缩略图地址
        if(!empty($img['title'])){
            $upload->setImgType( $type );
            $upload->setFix();
            $upload->setImgPath( $this->uid );
            $upload->setImgInfo( $img['title'][0]->img );
            $thumbPic = $upload->saveImg();
        }else{
            $thumbPic = '';
        }

        //如果id存在则修改,反之则添加
        if(!empty(Input::get('id'))){
            //修改数据
            if(!empty($m)){
                $data['name'] =  Input::get('name');
                $result =  $this->house->insertUpdateModel(Input::get('communityId'),$data);
            }else{
                $data['thumbPic'] = $thumbPic;
                $result =  $this->house->updateHouseSale(Input::get('id'),$data);
                //需要删除的图片id
                if(!empty(Input::get('deleteImgId'))){
                    $deleteId = explode(',',Input::get('deleteImgId'));
                    if(!empty($deleteId)){
                        $flag = $this->deleteImage( $deleteId );
                        if($flag != 1) return 0;
                    }
                }
                $info = [];
                foreach($img as $key => $val){
                    if(empty($val)) continue;
                    foreach($val as $vv){
                        if(empty($vv->id)){
                            if(empty($vv)) continue;
                            $upload->setImgType( $type );
                            $upload->setFix();
                            $upload->setImgPath( $this->uid );
                            $upload->setImgInfo( $vv->img );
                            $vv->fileName = $upload->saveImg();
                            $widthheight = getimagesize('/img'.$vv->fileName);
                            $vv->size =filesize('/img'.$vv->fileName);
                            $info[] = array('houseId'=>Input::get('id'),'fileName'=>$vv->fileName,'size'=>$vv->size,'width'=>$widthheight[0],'height'=>$widthheight[1],'uid'=>$this->uid,'communityId'=>1,'cityId'=>1,'note'=>$vv->note,'type'=>$vv->type);
                        }else{
                            $tmp = [];
                            $tmp['note'] = $vv->note;
                            $id = $vv->id;
                            $this->house->editHouseSaleImg( $id, $tmp);
                        }
                    }
                }
                $flag = $this->house->insertHouseImg( $info );
                if($flag){
                    return 1;
                }else{
                    return 0;
                }

            }
        }else{
            //插入数据
            if(!empty($m)){
                $data['name'] =  Input::get('name');
                $result =  $this->house->insertUpdateModel(Input::get('communityId'),$data);
            }else{
                $data['thumbPic'] = $thumbPic;
                $houseid =  $this->house->insertHouseSale($data);
                if(!empty($houseid)){
                    $info = [];
                    foreach($img as $key => $val){
                        if(empty($val)) continue;
                        foreach($val as $vv){
                            if(empty($vv)) continue;
                            $upload->setImgType( $type );
                            $upload->setFix();
                            $upload->setImgPath( $this->uid );
                            $upload->setImgInfo( $vv->img );
                            $vv->fileName = $upload->saveImg();
                            $widthheight = getimagesize('/img'.$vv->fileName);
                            $vv->size =filesize('/img'.$vv->fileName);
                            $info[] = array('houseId'=>$houseid,'fileName'=>$vv->fileName,'size'=>$vv->size,'width'=>$widthheight[0],'height'=>$widthheight[1],'uid'=>$this->uid,'communityId'=>1,'cityId'=>1,'note'=>$vv->note,'type'=>$vv->type);
                        }
                    }
                    $houseImg = $this->house->insertHouseImg($info);
                    return json_decode($houseImg);
                }
            }
        }

        return json_encode($result);
    }
    /**
     * 删除房源图片
     * @param array $id 要删除的房源图片id
     */
    public function deleteImage( $id ){
        if(!is_array($id)) $id[] = $id;

        $path = $this->house->getHouseSaleImgPath($id);

        $flag = $this->house->deleteHouseSaleImg( $id );
        if( !$flag ) return 2;

        $imgUtil = new UploadImgUtil;
        foreach($path as $pkey => $pval){
            $flag = $imgUtil->deleteImg($pval->fileName);
        }

        if( !$flag ) return 0;

        return 1;
    }
    /**
     * ajax 发布房源信息
     */
    public function release(){
        $id = Input::get('houseid');
        return $this->house->editHouseState($id);
    }

    /**
     * ajax 删除指定的房源模板
     */
    public function delModel(){
        $modelid = Input::get('modelid');
        $data = $this->house->delHouseSaleModel($modelid);
        return $data;
    }
    //根据楼盘名称获取楼盘信息列表
    public function getBuild(){
        $name = Input::get('name');
        $data = $this->house->getBuild($name);
        return $data;
    }
    //根据楼盘id获取楼栋信息列表
    public function communityBuilding(){
        $communityId = Input::get('communityId');
        $data =  $this->house->communityBuilding($communityId);
        return $data;
    }
    //根据楼盘id获取楼栋信息列表
    public function communityRoom(){
        $communityId = Input::get('communityId');
        $data =  $this->house->communityRoom($communityId);
        return $data;
    }

}
