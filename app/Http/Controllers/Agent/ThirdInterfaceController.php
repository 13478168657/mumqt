<?php
namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Input;
use App\Dao\Agent\HouseDao;
/**
 * Description of ThirdInterfaceController
 * 房源发布/编辑
 * @author xcy
 * @since 1.0
 */
class ThirdInterfaceController extends Controller{
	public $house;
	public function __construct()
	{
		$this->house = new HouseDao();
	}

	/**
	 * 房源发布/编辑
	 */
	public function saveHouse(){
		try{
			$id = Input::get('id','');//房源ID号
			$hidFlag = Input::get('hidFlag', '');				//(必填)发布类型，rent：出租；sale：出售
			$newold = Input::get('newold', '');				    //(必填)发布类型，new：新房；old：二手房
			$title = Input::get('houseTitle', '');				//(必填)房源名称
			$communityId = (Input::get('hidHouseCommunityId')=='') ? 0 : Input::get('hidHouseCommunityId');	//楼盘ID，此参数为空时，发布的房源有可能被标记为未审核状态
			$provinceId = Input::get('proId_se', '');			//(必填)省份id
			$cityId = Input::get('cityId_se', '');				//(必填)城市id
			$cityAreaId = Input::get('areaId_se', '');			//(必填)城区id
			$businessAreaId = Input::get('areaSheng', 0);			//商圈名称（只用于发布出租房源）
			$rentType = (empty(Input::get('rentCheck'))) ? 1 : Input::get('rentCheck');				//出租类型，1：整租；2：合租(只用于发布出租房源)
			$commType = Input::get('hidHouseTypeId', '');		//(必填)物业类型，
			$ownership = (empty(Input::get('ownership'))) ? 0 : Input::get('ownership');			//产权，0：无；1：个人商品房；2：使用权；3：经济适用房；4：单位产权；5：央产；6：军产；7：其它(注：当房源类型为写字楼、商铺、厂房时，产权只能选择 0.无 8.个人 9.公司 10.乡产
			$fitment = ((Input::get('Decoration'))=='') ? 1 : Input::get('Decoration');				//装修，1：毛坯；2：简装；3：精装
			$faceTo = ((Input::get('faceTo'))=='') ? 2 : Input::get('faceTo');					//朝向，1：东；2：南；3：西；4：北； 5：南北；6：东南；7：西南；8：东北；9：西北；10：东西
			$totalFloor = Input::get('totalFloor', '');			//(必填)总层数
			$currentFloor = Input::get('currentFloor', '');		//(必填)所在楼层，物业类型为别墅时，忽略此参数
			$area = Input::get('area', '');						//(必填)建筑面积
			$room = (empty(Input::get('room', 1000))) ? 1000 : Input::get('room', 1000);				//(必填)户型，4位数字，分别表示：室、厅、卫、阳台，例如：2211表示2室2厅1卫1阳台；物业类型为写字楼、商铺、厂房时，忽略此参数
			$buildYear = (Input::get('houseDate', 0)>0) ? Input::get('houseDate', 0) : 0;			//建筑年份
			$equipment = Input::get('equipment', '');			//配套设施，1：水；2：电；3：煤气/天然气；4：暖气；5：家具；6：电话；7：宽带；8：有线电视；9：热水器；10：洗衣机；11：空调；12：冰箱；13：电视机；14：阳台；15：车位/车库；16：防盗门；17：电梯。拼接为字符串输入，以西文逗号分隔，例如：1,2,3,4,5 表示配套设施为水、电、煤气/天然气、暖气、家具
			$price = (Input::get('totalPrice')=='') ? 0 : Input::get('totalPrice');				//价格
			$priceUnit = (Input::get('priceUnit')=='') ? 1 : Input::get('priceUnit');			//价格单位，1：元/月；2：元/天/平米；3：元/月/平米；4：元/季/平米；5：元/年/平米,
			$address = strip_tags(Input::get('houseAddress', ''));			//地址
			$longitude = Input::get('longitude', '');			//百度地图上的经度位置
			$latitude = Input::get('latitude', '');				//百度地图上的纬度位置
			$linkman = Input::get('Contacts', '');				//(必填)联系人姓名
			$linkphone = Input::get('elephone', '');			//联系人固话(固定电话与手机号码至少填写一项)
			$linkmobile = Input::get('phone', '');				//联系人手机(固定电话与手机号码至少填写一项)
			$describe = Input::get('HouseDescription', '');		//房源描述
			$traffic = Input::get('AdressInfo', '');			//交通状况
			$result = array(				//接口发布房源执行结果
				'result' => true,
				'message' => ''
			);
			$thisTime = date('Y-m-d H:i:s', time());		//当前时间
			$room  = (string)$room;
			$houseRoom = $room[0];//室
			$roomStr = $room[0].'_'.$room[1].'_'.$room[2].'_'.$room[3];
			//$tpId = Session::get('user_tpId');		//第三方接口接入id
//			if(is_null(Auth::user()) || is_null($tpId)){
//				$result = array(
//					'result' => false,
//					'message' => '请登录用户账号'
//				);
//			}else
			if(!in_array($hidFlag, array('rent','sale'))){
				$result = array(
					'result' => false,
					'message' => '请选择发布类型为出租或出售'
				);
			}elseif(!in_array($newold, array('new','old'))){
				$result = array(
					'result' => false,
					'message' => '请选择房源类型为新房或二手房'
				);
			}elseif($title==''){
				$result = array(
					'result' => false,
					'message' => '请填写房源名称'
				);
			}elseif(!is_numeric($communityId)){
				$result = array(
					'result' => false,
					'message' => '楼盘id必须为数字'
				);
			}elseif(($provinceId=='' || !is_numeric($provinceId)) && empty($id)){
				$result = array(
					'result' => false,
					'message' => '请输入省份id'
				);
			}elseif(($cityId=='' || !is_numeric($cityId)) && empty($id)){
				$result = array(
					'result' => false,
					'message' => '请输入城市id'
				);
			}elseif(($cityAreaId=='' || !is_numeric($cityAreaId)) && empty($id)){
				$result = array(
					'result' => false,
					'message' => '请输入城区id'
				);
			}elseif($businessAreaId=='' || !is_numeric($businessAreaId)){
				$result = array(
					'result' => false,
					'message' => '请输入商圈id'
				);
			}elseif(!in_array($rentType, array(1,2)) && $hidFlag=='rent'){
				$result = array(
					'result' => false,
					'message' => '请选择出租类型'
				);
			}elseif(!in_array($commType, array(1,2,3,4,5,6,7))){
				$result = array(
					'result' => false,
					'message' => '请选择物业类型'
				);
			}elseif($totalFloor=='' || !is_numeric($totalFloor) || $totalFloor<=0){
				$result = array(
					'result' => false,
					'message' => '请填写总楼层数'
				);
			}elseif(($currentFloor=='' || !is_numeric($currentFloor) || $currentFloor<=0) && $commType!=32 ){
				$result = array(
					'result' => false,
					'message' => '请填写所在楼层'
				);
			}elseif($totalFloor>0 && $currentFloor>0 && $totalFloor<$currentFloor){
				$result = array(
					'result' => false,
					'message' => '楼层总层数不能小于所在楼层数'
				);
			}elseif($area=='' || !is_numeric($area) || $area<=0){
				$result = array(
					'result' => false,
					'message' => '请填写正确建筑面积'
				);
			}elseif(($room=='' || !is_numeric($room)) || strlen($room)!=4 || $room<=0){
				$result = array(
					'result' => false,
					'message' => '请填写正确户型数据'
				);
			}elseif(!is_numeric($buildYear)){
				$result = array(
					'result' => false,
					'message' => '请填写正确建筑年份'
				);
			}elseif($newold=='new'&& $hidFlag == 'rent'){
				$result = array(
					'result' => false,
					'message' => '新房没有租房表,请重新填写'
				);
			}elseif($address==''){
				$result = array(
					'result' => false,
					'message' => '请填写地址'
				);
			}elseif($linkman==''){
				$result = array(
					'result' => false,
					'message' => '请填写联系人姓名'
				);
			}elseif($linkphone=='' && $linkmobile==''){
				$result = array(
					'result' => false,
					'message' => '固定电话与手机号码请至少填写一项'
				);
			}elseif(!is_numeric($price) || ($hidFlag=='rent' && !in_array($priceUnit, array(1,2,3))) || ($hidFlag=='sale' && !in_array($priceUnit, array(1,2)))){
				$result = array(
					'result' => false,
					'message' => '价格格式有误'
				);
			}elseif( !in_array($ownership, array(0,1,2,3,4,5,6,7)) || !is_numeric($ownership)){
				$result = array(
					'result' => false,
					'message' => '请正确选择产权'
				);
			}elseif(!in_array($fitment, array(1,2,3,4,5))){
				$result = array(
					'result' => false,
					'message' => '请正确选择装修'
				);
			}elseif(!in_array($faceTo, array(1,2,3,4,5,6,7,8,9,10))){
				$result = array(
					'result' => false,
					'message' => '请正确选择朝向'
				);
			}
			if($result['result'] == false){
				return json_encode($result,JSON_UNESCAPED_UNICODE);
			}

			//添加数据
			$data['provinceId'] = $provinceId;
			$data['cityId'] = $cityId;
			$data['cityareaId'] = $cityAreaId;
			$data['businessAreaId'] = $businessAreaId;
			$data['title'] = $title;
			$data['communityId'] = $communityId;
			$data['houseType1'] = $commType;
			$data['ownership'] = $ownership;
			$data['fitment'] = $fitment;
			$data['faceTo'] = $faceTo;
			$data['totalFloor'] = $totalFloor;
			$data['currentFloor'] = $currentFloor;
			$data['area'] = $area;
			$data['room'] = $room;
			$data['buildYear'] = $buildYear;
			$data['equipment'] = $equipment;
			$data['priceUnit'] = $priceUnit;
			$data['address'] = $address;
			$data['longitude'] = $longitude;
			$data['latitude'] = $latitude;
			$data['linkman'] = $linkman;
			$data['linkphone'] = $linkphone;
			$data['linkmobile'] = $linkmobile;
			$data['describe'] = $describe;
			$data['traffic'] = $traffic;
			$data['houseRoom'] = $houseRoom;
			$data['roomStr'] = $roomStr;

			//选择数据库
			if($newold == 'new'){
				$ku = 'mysql_house';
			}else{
				$ku = 'mysql_oldhouse';
			}
			//选择数据表
			if($hidFlag == 'rent'){
				$data['rentType'] = $rentType;
				$prices = $this->priceConversion($price,$priceUnit,$area);
				$data = array_merge($data,$prices);
				$table = 'houserent';
			}else{
				if ($priceUnit==1) {
					$data['price1']=intval($price*10000/$area);
					$data['price2']=$price;
				}else{
					$data['price1']=$price;
					$data['price2']=intval($price*$area/10000);
				}
				$table = 'housesale';
			}
			/* 判断四级地区之间关系是否正确无误，返回true正确，返回false有误 */
			if(!empty($id)){		//编辑房源，存在provinceId,cityId,cityAreaId
				$houseObj = $this->house->getThirdHouse($ku,$table,$id);
				if(is_null($houseObj)){
					$result = array('result'=>false, 'message'=>'没有对应房源');
					return json_encode($result,JSON_UNESCAPED_UNICODE);
				}else{
					$provinceId = $houseObj->provinceId;
					$cityId = $houseObj->cityId;
					$cityAreaId = $houseObj->cityareaId;
				}
			}
			$checkProCityCityareaBus = $this->house->checkProCityCityareaBus($provinceId, $cityId, $cityAreaId, $businessAreaId);
			if($checkProCityCityareaBus==false){
				$result = array(
					'result' => false,
					'message' => '省、市、市区、商圈数据关系对应错误'
				);
				return json_encode($result,JSON_UNESCAPED_UNICODE);
			}
			//检查用户每天发布房源的次数是否用完
//			$uid=Auth::id();			//用户id
//			$tpId = Session::get('user_tpId');		//第三方接口接入id
//			$data['tpId'] = $tpId;
//			if($hidFlag=='rent'){
//				if(!$this->checkPublishState('rent', $uid)){
//						$result = array('result'=>false, 'message'=>'今天发布出租房源数己用完,请明天再试');
//				}
//			}else{
//				if(!$this->checkPublishState('sale', $uid)){
//						$result = array('result'=>false, 'message'=>'今天发布出售房源数己用完,请明天再试');
//				}
//			}
//			if($result['result'] == false){
//				return json_encode($result,JSON_UNESCAPED_UNICODE);
//			}

			//添加和编辑
			if(!empty($id)){
				$updatedate = $this->house->updateThirdHouse($ku,$table,$id,$data);
				if(!empty($updatedate)){
					$result = array(
						'result' => false,
						'message' => $hidFlag.'-'.$id
					);
				}else{
					$result = array(
						'result' => false,
						'message' => '修改失败'
					);
				}
				return json_encode($result,JSON_UNESCAPED_UNICODE);
			}else{
				$data['dateInt'] = date('Ymd', time());
				$data['weekInt'] = date('YW', time());
				$data['monthInt'] = date('Ym', time());
				$insertid = $this->house->insertThirdHouse($ku,$table,$data);
				if(!empty($insertid)){
					$result = array(
						'result' => true,
						'message' => $hidFlag.'-'.$insertid
					);
				}else{
					$result = array(
						'result' => false,
						'message' => '添加失败'
					);
				}
				return json_encode($result,JSON_UNESCAPED_UNICODE);
			}


		}catch (Exception $e) {
			$result = array('result'=>false, 'message'=>$e->getMessage());
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}
	}

	//检测发布次数是否超标
	public static function checkPublishState($type, $uid=0)
	{
		$house = new HouseDao();
		$uid=($uid>0) ? $uid : Auth::id();
		$maxDayCount=20;
		$currentPublishedCount=20;
		if ($type=='rent') {
			$maxDayCount=$house->getSystemsettingCount('MaxDayPublishSaleCount');
			$currentPublishedCount = $house->currentRentCount($uid);
		}elseif($type=='sale'){
			$maxDayCount=$house->getSystemsettingCount('MaxDayPublishRentCount');
			$currentPublishedCount = $house->currentSaleCount($uid);
		}
		if ($currentPublishedCount>=$maxDayCount) {
			return false;
		}
		if ($type=='rent') {
			$house->updateDayPublishRentCount($uid);
			return true;
		}else if ($type=='sale') {
			$house->updateDayPublishSaleCount($uid);
			return true;
		}else{
			return false;
		}
	}

	//插入房源出租数据
	public function rentHouse($type = 1){
		try{
			$data['id'] = Input::get('id',''); //id
			$data['title'] = Input::get('title',''); //标题
			$data['thumbPic'] = Input::get('thumbPic',''); //缩略图
			$data['uid'] = Input::get('uid',''); //发布房源用户ID
			$data['provinceId'] = Input::get('provinceId','');
			$data['cityId'] = Input::get('cityId','');
			$data['cityareaId'] = Input::get('cityAreaId','');
			$data['businessAreaId'] = Input::get('businessId','');
			$data['communityId'] = Input::get('communityId','');
			$data['ownership'] = Input::get('ownership','');
			$data['houseType1'] = Input::get('type1','');
			$data['houseType2'] = Input::get('type2','');
			$data['faceTo'] = Input::get('faceTo','');
			$data['buildYear'] = Input::get('buildYear','');
			$data['fitment'] = Input::get('fitment','');
			$data['longitude'] = Input::get('longitude','');
			$data['latitude'] = Input::get('latitude','');
			$data['describe'] = Input::get('describe','');
			$data['traffic'] = Input::get('traffic','');
			$data['address'] = Input::get('address','');
			$data['totalFloor'] = Input::get('totalFloor','');
			$data['currentFloor'] = Input::get('currentFloor','');
			$data['houseRoom'] = Input::get('houseRoom','');
			$data['room'] = $room = Input::get('room','');
			$room  = (string)$room;
			if(!empty($room)){
				$data['roomStr'] = $room[0].'_'.$room[1].'_0_'.$room[2].'_'.$room[3];
			}else{
				$data['roomStr'] = '';
			}
			$data['equipment'] = str_replace(',','|',Input::get('equipment',''));
			$data['state'] = Input::get('state','');
			$data['ip'] = Input::get('ip','');
			$data['linkman'] = Input::get('linkman','');
			$data['linkphone'] = Input::get('linkphone','');
			$data['linkmobile'] = Input::get('linkmobile','');
			$data['tpId'] = Input::get('tpId','');
			$data['tags'] = Input::get('tags','');
			$time = strtotime(Input::get('timeCreate'));
			if(empty($time)){
				$time = time();
			}
			$data['timeCreate'] = date('Y-m-d H:i:s',$time);
			$data['timeUpdate'] = date('Y-m-d H:i:s',strtotime(Input::get('timeUpdate')));
			$data['dateInt'] = date('Ymd', $time);
			$data['weekInt'] = date('YW', $time);
			$data['monthInt'] = date('Ym', $time);
			$data['area'] = $area = Input::get('area','');
			$data['priceUnit'] = $priceUnit = Input::get('priceUnit',1);
			if($type == 1){//出租
				$table = 'houserent';
				$data['rentType'] = Input::get('rentType','');
				$price = Input::get('price','');
				$prices = $this->priceConversion($price,$priceUnit,$area);
				$data = array_merge($data,$prices);
			}elseif($type == 2){//出售
				$table = 'housesale';
				$price = Input::get('priceCer','');
				if ($priceUnit==1) {
					$data['price1']=intval($price*10000/$area);
					$data['price2']=$price;
				}else{
					$data['price1']=$price;
					$data['price2']=intval($price*$area/10000);
				}
			}

			//插入数据
			$insertid = $this->house->insertRentSaleHouse('mysql_oldhouse',$table,$data);
			if(!empty($insertid)){
				$result = array(
					'result' => true,
					'message' => $table.'-success'
				);
			}else{
				$result = array(
					'result' => false,
					'message' => '添加失败'
				);
			}
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}catch (Exception $e) {
			$result = array('result'=>false, 'message'=>$e->getMessage());
			return json_encode($result,JSON_UNESCAPED_UNICODE);
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

	//写入出售/出租房源图片
	public function rentHouseImg($type = 1){
		try{
			$data = Input::all();
			if($type == 1){//出租
				$table = 'houserentimage';
			}elseif($type == 2){//出售
				$table = 'housesaleimage';
			}
			//插入数据
			$houseImg = $this->house->interfaceHouseImg($table,$data);
			if(!empty($houseImg)){
				$result = array(
					'result' => true,
					'message' => 'insertimg-success'
				);
			}else{
				$result = array(
					'result' => false,
					'message' => '添加失败'
				);
			}
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}catch (Exception $e) {
			$result = array('result'=>false, 'message'=>$e->getMessage());
			return json_encode($result,JSON_UNESCAPED_UNICODE);
		}

	}
}