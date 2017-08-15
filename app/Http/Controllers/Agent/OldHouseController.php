<?php
namespace App\Http\Controllers\Agent;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Lists\PublicController;
use App\Http\Controllers\Utils\UploadImgUtil;
use App\Dao\Agent\HouseDao;
use App\Dao\City\CityDao;
use App\IndexUpdateEntity;
use App\Services\Search;
/**
* Description of OldHouseController （经纪人后台存量房源库录入、编辑房源）
* @since 1.0
* @author xcy
*/
class OldHouseController extends Controller{
	public $uid;                    //经纪人id
	public $house;                  //房源数据库类
	public $buildingStructures;     //建筑结构
	public $buildingTypes;          //建筑类别
	public $faces;                  //朝向
	public $public;                  //公共类
	public $cityname;                    //城市名称
	public $cityArea;                //城市区域
	public $businessArea;            //城市子区域
	public $businessTag;             //城市下的商圈
	public $ownerships;             //房屋产权
	public $trades;             //房屋商铺目标业务
	public $type2;
	public $paymentTypes;           //租房支付方式
	public $rentPriceUnit;           //租房价格单位
	public function __construct(){
		$this->cityId = 1;//城市id
		$this->uid = 1;
		$this->house = new HouseDao();
		$this->public = new PublicController();
		//建筑形式 结构
		$this->buildingStructures = array(1=>'跃层',2=>'开间',3=>'错层',4=>'复式',5=>'平层');
		//建筑形式 类别
		$this->buildingTypes = array(1=>'塔楼',2=>'砖混',3=>'钢混',4=>'板楼',5=>'砖楼',6=>'平房',7=>'塔板结合',8=>'独栋',9=>'双拼',10=>'联排',11=>'叠加');
		//朝向
		$this->faces = array(1=>'东',2=>'南',3=>'西',4=>'北',5=>'南北',6=>'东南',7=>'西南',8=>'东北',9=>'西北',10=>'东西');
		//产权
		$this->ownerships = array(1=>'个人产权',2=>'使用权',3=>'经济适用房',4=>'单位产权',5=>'央产房',6=>'军产房',8=>'限价房');
		//租房价格单位
		$this->rentPriceUnit = array(1=>'元/月',2=>'元/天/平米',3=>'元/月/平米',4=>'元/季/平米',5=>'元/年/平米');
		$this->trades = array(1=>'百货超市',2=>'酒店宾馆',3=>'家居建材',4=>'服饰鞋包',5=>'生活服务',6=>'美容美发',7=>'餐饮美食',8=>'休闲娱乐',9=>'其他');
		$this->type2 = array(1=>array(301=>'普宅',302=>'经济适用房',303=>'商住楼',304=>'公寓',305=>'酒店式公寓',306=>'四合院',307=>'豪宅'),
			3=>array(201=>'纯写字楼',202=>'商住楼',203=>'商业综合体楼',204=>'酒店写字楼'),
			6=>array(401=>'独栋',402=>'双拼',403=>'联排',404=>'叠加'),
			4=>array(101=>'住宅底商',102=>'商业街商铺',103=>'临街商铺',104=>'写字楼底商',105=>'购物中心商铺',106=>'其他'));
		$this->paymentTypes = array(1=>'押一付三',2=>'押一付二',3=>'押一付一',4=>'押二付一',5=>'押二付二',6=>'押二付三',8=>'押三付三',9=>'半年付',10=>'年付',11=>'面议');
		$this->cityname = $this->public->findCity($this->cityId);
		$this->cityArea = $this->public->conversion($this->public->getCityArea($this->cityId));
		$this->businessArea = $this->public->conversion($this->public->getBusinessAreas($this->cityId));
		$this->businessTag = $this->public->conversion($this->public->getBusinessTag($this->cityId));
	}
	//
	public function entryHouse($class = 'sale'){
		$data['class'] = $class;
		$data['type1'] = array(1=>'普通住宅',2=>'公寓',3=>'写字楼',4=>'商铺',5=>'厂房',6=>'别墅',7=>'其它',8=>'青年公寓');
		$data['type2'] = array(1=>array(301=>'普宅',302=>'经济适用房',303=>'商住楼',304=>'公寓',305=>'酒店式公寓',306=>'四合院',307=>'豪宅'),
			3=>array(201=>'纯写字楼',202=>'商住楼',203=>'商业综合体楼',204=>'酒店写字楼'),
			6=>array(401=>'独栋',402=>'双拼',403=>'联排',404=>'叠加'),
			4=>array(101=>'住宅底商',102=>'商业街商铺',103=>'临街商铺',104=>'写字楼底商',105=>'购物中心商铺',106=>'其他'));
		$data['cityArea'] = $this->cityArea;
		$data['businessArea'] = $this->businessArea;
		$data['businessTag'] = $this->businessTag;
		return view('agent.entryCommunity',$data);
	}
	//根据楼盘名称获取楼盘信息列表
	public function getBuild(){
		$name = Input::get('name');
		$data = $this->house->getBuild($name);
		return $data;
	}
	/**
	 * 楼盘名称存在时
	 * 存量房源库 发布二手出售房源信息
	 * @param  $type house:住宅,villa:别墅,office:写字楼,shops:商铺
	 */
	public function oldHouseSale($class = 'sale',$id = ''){
		$data['class'] = $class;
		//初始化数据
		$data['buildingStructures'] = $this->buildingStructures;
		$data['buildingTypes'] = $this->buildingTypes;
		$data['faces'] = $this->faces;
		$data['trades'] = $this->trades;
//		$data['houseType2'] = array('house'=>array(301=>'普宅',302=>'经济适用房',303=>'商住楼',304=>'公寓',305=>'酒店式公寓',306=>'四合院',307=>'豪宅'),
//									'shops'=>array(101=>'住宅底商',102=>'商业街商铺',103=>'临街商铺',104=>'写字楼底商',105=>'购物中心商铺',106=>'其他'));
		$data['type2'] = $this->type2;
		$data['ownerships'] = $this->ownerships;
		$data['paymentTypes'] = $this->paymentTypes;
		$data['rentPriceUnit'] = $this->rentPriceUnit;
//		if($type== 'shops'){
//			$cityId = 1;//城市id
//			$data['cityArea'] = $this->public->conversion($this->public->getCityArea($cityId));
//			$data['businessTag'] = $this->public->conversion($this->public->getBusinessTag($cityId));
//		}
		//获取编辑数据
		$data['cityname'] = $this->cityname; //城市名称
		$data['cityArea'] = $this->cityArea; //城市区域数组
		$data['businessArea'] = $this->businessArea; //城市子区域数组
		$data['cityId'] = Input::get('cityId');
		$data['cityareaId'] = Input::get('cityareaId');
		$data['businessAreaId'] = Input::get('businessAreaId');
		$data['communityId'] = Input::get('communityId');
		$data['houseType1'] = $houseType1 = Input::get('houseType1');
		$data['houseType2'] = Input::get('houseType2');
		$data['name'] = Input::get('name'); //楼盘名称
		$data['address'] = Input::get('address'); //楼盘地址
		//判断是那个数据表
		if($class == 'sale'){
			$table = 'housesale';
			$imgtable = 'housesaleimage';
		}else{
			$table = 'houserent';
			$imgtable = 'houserentimage';
		}
		if(!empty($id)){
			//$id代表的是房源表数据的id
			$info = $this->house->getOldSaleImg($imgtable,$this->uid, $id);
			$imageInfo = [];
			foreach($info as $key => $val){
				$imageInfo[$this->typeCase($val->type)][] = $val;
			}
			unset($info);
			$data['info'] = $imageInfo;
			$data['oldsaleid'] = $id;
			$data['house'] = $houses =  $this->house->getOldSaleById($table,$this->uid,$id);
			if(!empty($houses)){
				$data['cityId'] = $houses->cityId;
				$data['cityareaId'] = $houses->cityareaId;
				$data['businessAreaId'] = $houses->businessAreaId;
				$data['communityId'] = $houses->communityId;
				$data['houseType1'] = $houses->houseType1;
				$data['houseType2'] = $houses->houseType2;
				$data['name'] = $houses->name; //楼盘名称
				$data['address'] = $houses->address; //楼盘名称
				$price = 'price'.$houses->priceUnit;
				$data['price'] = $houses->$price; //价格
			}
		}
		//配套设施
		if($data['houseType1'] == 1){
			$data['type'] = 'house';
			$data['equipments'] = array(3=>'煤气/天然气',4=>'暖气',7=>'宽带',15=>'车位/车库',17=>'电梯',18=>'储藏室/地下室',19=>'花园/小院',20=>'露台',21=>'阁楼');
		}elseif($data['houseType1'] == 6){
			$data['type'] = 'villa';
			$data['equipments'] = array(20=>'露台',21=>'阁楼',22=>'游泳池',23=>'阳光房',18=>'地下室',19=>'花园',15=>'车位/车库');
		}elseif($data['houseType1'] == 3){
			$data['type'] = 'office';
			$data['equipments'] = array(3=>'煤气/天然气',4=>'暖气',7=>'宽带',15=>'车位/车库',17=>'电梯',18=>'储藏室/地下室',19=>'花园/小院',20=>'露台',21=>'阁楼');
		}else{
			$data['type'] = 'shops';
			$data['equipments'] = array(1=>'水',3=>'燃气',4=>'暖气',7=>'网路',11=>'空调',15=>'停车位',17=>'客梯',24=>'货梯',25=>'扶梯');
		}
		//装修
		if(($data['type'] == 'house')||($data['type'] == 'villa')){
			$data['fitments'] = array(1=>'毛坯',2=>'简装',3=>'中装修',4=>'精装修',5=>'豪华装修');
		}else{
			$data['fitments'] = array(1=>'毛坯',2=>'简装',4=>'精装修');
		}
		//房源标签
		$data['tags'] = $this->house->getHouseTag($data['houseType2']);
		//获取楼栋信息
		$data['communityBuilds'] = $this->house->communityBuilding($data['communityId']);
		//获取户型信息
		$data['communityRooms'] = $this->house->communityRoom($data['communityId']);
		//print_r($data['communityRooms']);
		return view('agent.oldHouseSale',$data);
	}
	/**
	 * 楼盘名称不存在时
	 * 存量房源库 发布二手出售房源信息
	 * @param  $type house:住宅,villa:别墅,office:写字楼,shops:商铺
	 */
	public function oldHouseSale2($class = 'sale',$id = ''){
		$data['class'] = $class;
		//$data['type'] = $type;
		$data['cityId'] = $this->cityId;
		$data['cityareaId'] = Input::get('cityareaId');
		$data['businessAreaId'] = Input::get('businessAreaId');
		$data['title'] = Input::get('title');
		$data['internalNum'] = Input::get('internalNum');
		$data['housingInspectionNum'] = Input::get('housingInspectionNum');
		$data['address'] = Input::get('address');
		$data['houseNum'] = Input::get('houseNum');
		$data['houseType1'] = $houseType1 = Input::get('houseType1');
		$data['houseType2'] = Input::get('houseType2');
		$data['buildingStructures'] = $this->buildingStructures;
		$data['buildingTypes'] = $this->buildingTypes;
		//初始化数据
		$data['ownerships'] = $this->ownerships;
		$data['faces'] = $this->faces;
		$data['trades'] = $this->trades;
		$data['type2'] = $this->type2;
		$data['paymentTypes'] = $this->paymentTypes;
		$data['rentPriceUnit'] = $this->rentPriceUnit;
		//判断是那个数据表
		if($class == 'sale'){
			$table = 'housesale';
			$imgtable = 'housesaleimage';
		}else{
			$table = 'houserent';
			$imgtable = 'houserentimage';
		}
		if(!empty($id)){
			//$id代表的是房源表数据的id
			$info = $this->house->getOldSaleImg( $imgtable,$this->uid, $id);
			$imageInfo = [];
			foreach($info as $key => $val){
				$imageInfo[$this->typeCase($val->type)][] = $val;
			}
			unset($info);
			$data['info'] = $imageInfo;
			$data['oldsaleid'] = $id;
			$data['house'] = $houses =  $this->house->getOldSaleById($table,$this->uid,$id);
			if(!empty($houses)){
				$data['cityId'] = $houses->cityId;
				$data['cityareaId'] = $houses->cityareaId;
				$data['businessAreaId'] = $houses->businessAreaId;
				$data['internalNum'] = $houses->internalNum;
				$data['houseType1'] = $houses->houseType1;
				$data['houseType2'] = $houses->houseType2;
				$data['housingInspectionNum'] = $houses->housingInspectionNum;
				$data['title'] = $houses->title;
				$data['address'] = $houses->haddress;
				$data['houseNum'] = $houses->houseNum;
				$price = 'price'.$houses->priceUnit;
				$data['price'] = $houses->$price; //价格
			}
		}
		//配套设施
		if($data['houseType1'] == 1){
			$data['type'] = 'house';
			$data['equipments'] = array(3=>'煤气/天然气',4=>'暖气',7=>'宽带',15=>'车位/车库',17=>'电梯',18=>'储藏室/地下室',19=>'花园/小院',20=>'露台',21=>'阁楼');
		}elseif($data['houseType1'] == 6){
			$data['type'] = 'villa';
			$data['equipments'] = array(20=>'露台',21=>'阁楼',22=>'游泳池',23=>'阳光房',18=>'地下室',19=>'花园',15=>'车位/车库');
		}elseif($data['houseType1'] == 3){
			$data['type'] = 'office';
			$data['equipments'] = array(3=>'煤气/天然气',4=>'暖气',7=>'宽带',15=>'车位/车库',17=>'电梯',18=>'储藏室/地下室',19=>'花园/小院',20=>'露台',21=>'阁楼');
		}else{
			$data['type'] = 'shops';
			$data['equipments'] = array(1=>'水',3=>'燃气',4=>'暖气',7=>'网路',11=>'空调',15=>'停车位',17=>'客梯',24=>'货梯',25=>'扶梯');
		}
		//装修
		if(($data['type'] == 'house')||($data['type'] == 'villa')){
			$data['fitments'] = array(1=>'毛坯',2=>'简装',3=>'中装修',4=>'精装修',5=>'豪华装修');
		}else{
			$data['fitments'] = array(1=>'毛坯',2=>'简装',4=>'精装修');
		}
		//房源标签
		$data['tags'] = $this->house->getHouseTag($data['houseType2']);
		return view('agent.oldHouseSale2',$data);
	}
	//
	public function getcommunityunit(){
		$buildId = Input::get('bId');
		return $this->house->getcommunityunit($buildId);
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

			case 10:
				return 'indoor';

			case 11:
				return 'traffic';

			case 12:
				return 'peripheral';

			default:
				return 'other';
		}
	}
	/**
	 * 存量房源库 添加编辑二手出售房源提交
	 * @since 1.0
	 * @author xcy
	 * @param $type house:住宅  villa:别墅 office:写字楼 shops:商铺
	 * @param $m 是否使用模板
	 * @return 1:成功 其他:失败
	 */
	public function oldSaleSub($class='sale'){
		$temp = Input::all();
		unset($temp['_token']);
		unset($temp['name']);
		unset($temp['id']);
		unset($temp['leyout']);
		unset($temp['indoor']);
		unset($temp['traffic']);
		unset($temp['peripheral']);
		unset($temp['exterior']);
		unset($temp['titleimg']);
		unset($temp['deleteImgId']);
		$temp['uid'] = $this->uid;
		if(!empty($temp['equipment'])){
			$temp['equipment'] = implode('|',$temp['equipment']);
		}
		if(!empty($temp['trade'])){
			$temp['trade'] = implode('|',$temp['trade']);
		}

		//接收图片
		$communityId = 259503;
		$type = 'community';
		$upload = new UploadImgUtil;

		$img['leyout'] = json_decode(Input::get('leyout'));
		$img['indoor'] = json_decode(Input::get('indoor'));
		$img['traffic'] = json_decode(Input::get('traffic'));
		$img['peripheral'] = json_decode(Input::get('peripheral'));
		$img['exterior'] = json_decode(Input::get('exterior'));
		$img['title'] = json_decode(Input::get('titleimg'));

		//缩略图地址
		if(!empty($img['title'])){
			if( strpos($img['title'][0]->img , 'data:image/jpeg;base64,') !== false){
				$upload->setImgType( $type );
				$upload->setFix();
				$upload->setImgPath( $this->uid );
				$upload->setImgInfo( $img['title'][0]->img);
				$thumbPic = $upload->saveImg();
			}else{
				$thumbPic = '';
			}
		}else{
			$thumbPic = '';
		}
		//判断是那个数据表
		if($class == 'sale'){
			$table = 'housesale';
			$imgtable = 'housesaleimage';
		}else{
			$table = 'houserent';
			$imgtable = 'houserentimage';
			$price = $temp['price'];
			unset($temp['price']);
			$priceUnit = $temp['priceUnit'];
			$area = $temp['area'];
			$prices = $this->priceConversion($price,$priceUnit,$area);
			$temp = array_merge($temp,$prices);
		}

		//如果id存在则修改,反之则添加
		if(!empty(Input::get('id'))){
			$temp['thumbPic'] = $thumbPic;
			$result =  $this->house->updateOldSale($table,Input::get('id'),$temp);
			//需要删除的图片id
			if(!empty(Input::get('deleteImgId'))){
				$deleteId = explode(',',Input::get('deleteImgId'));
				if(!empty($deleteId)){
					$flag = $this->deleteImage( $imgtable,$deleteId );
					if($flag != 1) return 0;
				}
			}
			$info = [];
			foreach($img as $key => $val){
				if(empty($val)) continue;
				if($key == 'title'){
					if( strpos($val[0]->img , 'data:image/jpeg;base64,') === false){
						continue;
					}
					if( !empty($val[0]->id)){
						// var_dump($val['id']);exit;
						$this->deleteImage( $imgtable,$val[0]->id );
					}
				}
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
						$this->house->editOldSaleImg( $imgtable,$id, $tmp);
					}
				}
			}
			$flag = $this->house->insertOldSaleImg( $imgtable,$info );
			if($flag){
				return 1;
			}else{
				return 0;
			}
		}else{
			$temp['thumbPic'] = $thumbPic;
			$houseid =  $this->house->insertOldHouseSale($table,$temp);
			if(!empty($houseid)){
				$info = [];
				foreach($img as $key => $val){
					if(empty($val)) continue;
					if($key == 'title'){
						if( strpos($val[0]->img , 'data:image/jpeg;base64,') === false){
							continue;
						}
					}
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
				$houseImg = $this->house->insertOldSaleImg($imgtable,$info);
				if($houseImg){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}

	}
	/**
	 * 删除房源图片
	 * @param array $id 要删除的房源图片id
	 */
	public function deleteImage($table,$id ){
		if(!is_array($id)) $id = array($id);

		$path = $this->house->getOldSaleImgPath($table,$id);

		$flag = $this->house->deleteOldSaleImg($table,$id );
		if( !$flag ) return 2;

		$imgUtil = new UploadImgUtil;
		foreach($path as $pkey => $pval){
			$flag = $imgUtil->deleteImg($pval->fileName);
		}

		if( !$flag ) return 0;

		return 1;
	}

	/**
	 * 管理二手出售出租房源
	 * @param $class 分为sale:出售,rent:出租
	 * @param $type releaseing:已发布  releaseed:未发布 expired:过期 rules:违规
	 */
	public function oldSaleManage($class,$type = 'releaseing'){
		$data['class'] = $class;
		$data['type'] = $type;
		$data['faces'] = array(1=>'东',2=>'南',3=>'西',4=>'北',5=>'南北',6=>'东南',7=>'西南',8=>'东北',9=>'西北',10=>'东西');
		$data['housetypes'] = array(1=>'普通住宅',2=>'公寓',3=>'写字楼',4=>'商铺',5=>'厂房',6=>'别墅',7=>'其它',8=>'青年公寓');
		$data['priceUnits'] = $this->rentPriceUnit;;
		$data['models'] = array(1=>'1居',2=>'2居',3=>'3居',4=>'4居',5=>'5居',6=>'5居以上');
		$where['uid'] = $this->uid;
		$data['id'] = Input::get('id');
		$data['internalNum'] = Input::get('internalNum');
		$data['startprice'] = Input::get('startprice');
		$data['endprice'] = Input::get('endprice');
		$data['houseRoom'] = $houseRoom = Input::get('houseRoom');
		$data['page'] = $page = Input::get('page',1);
		$pageset = 5;//每页显示数量
		$order = Input::get('order','');
		if(!empty($order)){
			$order = explode('_',$order);
		}else{
			$order = array('timeCreate','desc');
		}
		if(!empty(Input::get('id'))){
			$where['h.id'] = Input::get('id');
		}
		if(!empty(Input::get('houseType1'))){
			$where['houseType1'] = Input::get('houseType1');
		}
		if(!empty(Input::get('internalNum'))){
			$where['internalNum'] = Input::get('internalNum');
		}
		if(!empty($houseRoom)){
			if($houseRoom >5){
				$where['houseRoom'] = [$houseRoom,20];
			}else{
				$where['houseRoom'] = $houseRoom;
			}
		}
		if(!empty(Input::get('startprice'))&&!empty(Input::get('endprice'))){
			$where['price2'] = [Input::get('startprice'),Input::get('endprice')];
		}
		//判断是那个数据表
		if($class == 'sale'){
			$table = 'housesale';
			$imgtable = 'housesaleimage';
		}else{
			$table = 'houserent';
			$imgtable = 'houserentimage';
		}
		//releaseing:已发布  releaseed:未发布 expired:过期 rules:违规
		if($type == 'releaseing'){
			$where['state'] = 1;
		}elseif($type == 'releaseed'){
			$where['state'] = 0;
		}elseif($type == 'expired'){
			dd('暂未开发');
		}else{
			dd('暂未开发');
		}
		$houses = $this->house->houseSaleManage($table,$where,$pageset,$page,$order);
		$data['houses'] = $houses['houses'];
		$total = $houses['count'];

		$pagingHtml = $this->public->RentPaging($total,$page,$pageset);
		$data['pagingHtml'] = $pagingHtml;
		return view('agent.oldSaleManage',$data);
	}

	//更改状态 $type refresh:刷新,bespeak:预约,nbespeak:取消预约,release:发布房源,delete:删除房源,shelves:下架,setup:设置属性
	public function updateStatus($class,$type){
		$IndexUpdateEntity = new IndexUpdateEntity();
		//判断是那个数据表
		if($class == 'sale'){
			$internal = 'SFSS';
			$table = 'housesale';
			$refreshtable = 'refreshlogoldsale';
			$Search = new Search('hs');
		}else{
			$internal = 'SFSR';
			$table = 'houserent';
			$refreshtable = 'refreshlogoldrent';
			$Search = new Search('hr');
		}
		$id = Input::get('id');
		if(!is_array($id)) $id = array($id);
		//判断
		if($type == 'refresh'){
			//检测刷新次数是否用完
			if(!($remaining = $this->checkRefreshState())){//剩余刷新次数
				return 2;
			}
			$result = false;
			$logdata = array();
			$num = 0;
			$IndexUpdateEntity->setValue(date('Y-m-d H:i:s',time()));
			//走接口
			foreach($id as $v){
				if((count($id) > $remaining)&& ($num>=$remaining)){
					break;
				}
				$IndexUpdateEntity->setIndexId('t49310094');
				$res = json_decode($Search->houseIndexUpdate($IndexUpdateEntity));
				if(array_key_exists("_id",$res)){
					$result = true;
					$num ++;
					$logdata[] = array('uId'=>$this->uid,'hId'=>$v,'type'=>1);
				}else{
					$result = false;
				}
			}
			//写入刷新完成记录表
			if(!empty($logdata)){
				$this->house->refreshLogOld($refreshtable,$logdata);
			}
			//跟新经纪人的刷新次数
			if(!empty($num)){
				$this->house->updateRefreshCount($this->uid,$num);
			}

		}elseif($type == 'bespeak'){
			return 222;
		}elseif($type == 'nbespeak'){
			return 222;
		}elseif($type == 'release'){
			foreach($id as $v){
				$internalNum = $internal.str_pad($v,10,0,STR_PAD_LEFT);
				$data = ['internalNum'=>$internalNum,'state'=>1];
				$result = $this->house->updateStatus($table,array($v),$data);
			}
		}elseif($type == 'delete'){
			$result = $this->house->deleteOldSaleHouse($table,$id);
		}elseif($type == 'shelves'){
			$state = ['state'=>1];
			$result = $this->house->updateStatus($table,$id,$state);
		}elseif($type == 'setup'){
			$attribute = explode('_',Input::get('attribute'));
			$IndexUpdateEntity->setIndexId($id[0]);
			$IndexUpdateEntity->setFields($attribute[0]);
			if(!empty($attribute[1])){
				$attr = [$attribute[0]=>0];
				$IndexUpdateEntity->setValue(0);
			}else{
				$attr = [$attribute[0]=>1];
				$IndexUpdateEntity->setValue(1);
			}
			$Search->houseIndexUpdate($IndexUpdateEntity);
			$result = $this->house->updateAttribute($table,$id,$attr);
		}
		if(!empty($result)){
			return 1;
		}else{
			return 0;
		}

	}

	//修改直接显示图片页面
	public function updateImage($class,$id,$uid){
		$data['class'] = $class;
		$status = 2; //审核状态  0、未审核  1、审核进行中   2、审核通过  3、审核未通过
		$data['status'] = $status;
		//判断是那个数据表
		if($class == 'sale'){
			$table = 'housesale';
			$imgtable = 'housesaleimage';
		}else{
			$table = 'houserent';
			$imgtable = 'houserentimage';
		}
		//$data['type'] = $type;
		$info = $this->house->getOldSaleImg( $imgtable,$this->uid, $id);
		$imageInfo = [];
		foreach($info as $key => $val){
			$imageInfo[$this->typeCase($val->type)][] = $val;
		}
		unset($info);
		$data['info'] = $imageInfo;
		$data['houseid'] = $id;
		//$data['house'] = $this->house->getOldSaleById($this->uid,$id);
		//根据房源id获取楼盘户型图片
		$data['leyouts'] = $this->house->getCommunityRoomImg($table,$id);
		//获取楼盘的交通 周边配套 外景图
		$ctype = array(1,2,6);
		$ctypeimg = $this->house->getCommunityImg('communityimage',$ctype,$uid);
		$cimginfo = array();
		foreach($ctypeimg as $key => $val){
			if($val->type == 1){
				$cimginfo['traffic'][] = $val;
			}elseif($val->type == 2){
				$cimginfo['peripheral'][] = $val;
			}elseif($val->type == 6){
				$cimginfo['waijing'][] = $val;
			}
		}
		unset($ctypeimg);
		$data['cimginfo'] = $cimginfo;
		return view('agent.editHouseImage',$data);
	}
	//修改直接显示图片提交页面
	public function updateImageSub($class = 'sale'){
		//判断是那个数据表
		if($class == 'sale'){
			$table = 'housesale';
			$imgtable = 'housesaleimage';
		}else{
			$table = 'houserent';
			$imgtable = 'houserentimage';
		}
		//接收图片
		$communityId = 259503;
		$type = 'community';
		$upload = new UploadImgUtil;

		$img['leyout'] = json_decode(Input::get('leyout'));
		$img['indoor'] = json_decode(Input::get('indoor'));
		$img['traffic'] = json_decode(Input::get('traffic'));
		$img['peripheral'] = json_decode(Input::get('peripheral'));
		$img['exterior'] = json_decode(Input::get('exterior'));
		$img['title'] = json_decode(Input::get('titleimg'));
		//去除链接的标题图片地址
		$titleimg = str_replace("http://img.sf85.85", '',$img['title'][0]->img);
		//缩略图地址
		if(!empty($img['title'])){
			if( strpos($img['title'][0]->img , 'data:image/jpeg;base64,') !== false){
				$upload->setImgType( $type );
				$upload->setFix();
				$upload->setImgPath( $this->uid );
				$upload->setImgInfo( $img['title'][0]->img);
				$thumbPic = $upload->saveImg();
			}else{
				if(Input::get('oldtitle') !=$titleimg){
					$upload->setImgType( $type );
					$upload->setFix();
					$upload->setImgPath( $this->uid );
					$thumbPic = $upload->copyFile($img['title'][0]->img);
				}else{
					$thumbPic = '';
				}
			}
		}else{
			$thumbPic = '';
		}
		//缩略图不为空时进行修改
		if(!empty($thumbPic)){
			$temp['thumbPic'] = $thumbPic;
			$result =  $this->house->updateOldSale($table,Input::get('id'),$temp);
		}

		//需要删除的图片id
		if(!empty(Input::get('deleteImgId'))){
			$deleteId = explode(',',Input::get('deleteImgId'));
			if(!empty($deleteId)){
				$flag = $this->deleteImage( $imgtable,$deleteId );
				if($flag != 1) return 0;
			}
		}
		$info = [];
		foreach($img as $key => $val){
			if(empty($val)) continue;
			if($key == 'title'){
				if( strpos($val[0]->img , 'data:image/jpeg;base64,') === false){
					if(Input::get('oldtitle') ==$titleimg){
						continue;
					}
				}
				if( !empty($val[0]->id)){
					// var_dump($val['id']);exit;
					$this->deleteImage( $imgtable,$val[0]->id );
				}
			}
			foreach($val as $vv){
				if(empty($vv->id)){
					if(empty($vv)) continue;
					if( strpos($vv->img , 'data:image/jpeg;base64,') === false){
						$upload->setImgType( $type );
						$upload->setFix();
						$upload->setImgPath( $this->uid );
						$upload->setImgInfo( $vv->img );
						$vv->fileName = $upload->copyFile($vv->img);
						$widthheight = getimagesize('/img'.$vv->fileName);
						$vv->size =filesize('/img'.$vv->fileName);
					}else{
						$upload->setImgType( $type );
						$upload->setFix();
						$upload->setImgPath( $this->uid );
						$upload->setImgInfo( $vv->img );
						$vv->fileName = $upload->saveImg();
						$widthheight = getimagesize('/img'.$vv->fileName);
						$vv->size =filesize('/img'.$vv->fileName);
					}
					$info[] = array('houseId'=>Input::get('id'),'fileName'=>$vv->fileName,'size'=>$vv->size,'width'=>$widthheight[0],'height'=>$widthheight[1],'uid'=>$this->uid,'communityId'=>1,'cityId'=>1,'note'=>$vv->note,'type'=>$vv->type);
				}else{
					$tmp = [];
					$tmp['note'] = $vv->note;
					$id = $vv->id;
					$this->house->editOldSaleImg( $imgtable,$id, $tmp);
				}
			}
		}
		$flag = $this->house->insertOldSaleImg( $imgtable,$info );
		if($flag){
			return 1;
		}else{
			return 0;
		}

	}

	//租房价格换算
	public function priceConversion($price,$unit,$area){
		if(empty($price)||empty($area)){
			$data['price1'] = '';
			$data['price2'] = '';
			$data['price3'] = '';
			$data['price4'] = '';
			$data['price5'] = '';
			return $data;
		}
		if($unit == 1){
			$data['price1'] = $price;
			$data['price2'] = $price*12/365/$area;
			$data['price3'] = $price/$area;
			$data['price4'] = $price*3/$area;
			$data['price5'] = $price*12/$area;
		}elseif($unit == 2){
			$data['price1'] = $price*365*$area/12;
			$data['price2'] = $price;
			$data['price3'] = $price*365/12;
			$data['price4'] = $price*365/4;
			$data['price5'] = $price*365;
		}elseif($unit == 3){
			$data['price1'] = $price*$area;
			$data['price2'] = $price*12/365;
			$data['price3'] = $price;
			$data['price4'] = $price*3;
			$data['price5'] = $price*12;
		}elseif($unit == 4){
			$data['price1'] = $price*$area/3;
			$data['price2'] = $price*4/365;
			$data['price3'] = $price/3;
			$data['price4'] = $price;
			$data['price5'] = $price*4;
		}elseif($unit == 5){
			$data['price1'] = $price*$area/12;
			$data['price2'] = $price/365;
			$data['price3'] = $price/12;
			$data['price4'] = $price/4;
			$data['price5'] = $price;
		}
		return $data;
	}
	//检测刷新次数是否超标
	public function checkRefreshState()
	{
		$maxDayCount=20;
		$currentPublishedCount=20;
		$maxDayCount = $this->house->getRefreshCount($this->uid,'dayRefreshCount');
		$currentPublishedCount = $this->house->getRefreshCount($this->uid,'refreshCount');
		if ($currentPublishedCount>=$maxDayCount) {
			return false;
		}else{
			return ($maxDayCount - $currentPublishedCount);
		}
	}
	//房源预约显示及保存
	public function appointment($class,$id,$m='',$mid=''){
		if($class == 'sale'){
			$table = 'refreshorderoldsale';
		}else{
			$table = 'refreshorderoldrent';
		}
		$data['class'] = $class;
		$data['houseid'] = $id;
		$data['m'] = $m;//模板标记
		//获取所有模板名称
		$data['models'] = $this->house->getordermodels($this->uid);
		if(!empty($m)){
			//根据mid获取模板数据
			$info = array();
			$detail = $this->house->getordermodelinfo($mid);
			foreach(explode('|',$detail) as $v){
				$temp = explode(':',$v);
				$info[$temp[0]][] = $temp[1];
			}
			$data['detail'] = $info;
		}
		return view('agent.houseappointment',$data);
	}

	//模板保存及编辑
	public function appointmentSub($class,$id='',$m='',$mid=''){
		if($class == 'sale'){
			$table = 'refreshorderoldsale';
			$tablegroup = 'refreshorderoldsale_group';
		}else{
			$table = 'refreshorderoldrent';
			$tablegroup = 'refreshorderoldrent_group';
		}
		if(!empty($m)){
			$table = 'refreshordermodel';
			$info['uId'] = $this->uid; //
			$info['name'] = Input::get('name'); //模板名
			$info['detail'] = substr(Input::get('detail'),0,-1);//时间序列串
			if(!empty($mid)){//更新刷新预约模板表

			}else{ //插入刷新预约模板表
				$result = $this->house->insertappointmentmodel($table,$info);
				if(!empty($result)){
					return 1;
				}else{
					return 0;
				}
			}
		}else{
			$houseId = $infogroup['houseId'] = $id;
			$infogroup['uId'] = $this->uid;
			$tempDate = Input::get('execDate');
			$refreshTime1 = date('Ymd',time());
			$infogroup['startDay'] = date('Y-m-d H:i:s',time());
			$infogroup['endDay'] = date('Y-m-d H:i:s',strtotime("+".$tempDate." days"));

			$infogroup['detail'] = $detail = substr(Input::get('detail'),0,-1);
			foreach(explode('|',$detail) as $v){
				$info[] = array('houseId'=>$houseId,'refreshTime1'=>$refreshTime1,'refreshTime2'=>$v);
			}

			$result = $this->house->insertappointmentsale($table,$info);
			$resultgroup = $this->house->insertappointmentsale($tablegroup,$infogroup);


			if(!empty($result)){
				return 1;
			}else{
				return 0;
			}
		}
	}
}