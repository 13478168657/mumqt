<?php
namespace App\Http\Controllers\Agent;

use Auth;
use DB;
use App\Dao\Agent\DynamicDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\AreaUtil;
use App\Http\Controllers\User\UploadsController;
use App\Http\Controllers\Utils\UploadImgUtil;

/**
* description of DynamicController
* 经纪人动态信息管理
* @author lixiyu
* @since 1.0
*/
class DynamicController extends Controller{

	
	protected $DynamicDao;

	protected $userId;
	protected $communityId;
	public function __construct(){
		$this->DynamicDao = new DynamicDao;
		$this->userId = 12; //用户id 
		$this->communityId = Input::get('communityId', '1');//楼盘id
	}

	/**
	* 楼栋信息
	*/
	public function louDong(){
		$title = '楼栋信息';
		
				
		//获取物业类型信息
		$info = $this->getPageType($this->communityId);
		$buildInfo = $this->DynamicDao->getCommunityBuild($this->communityId, $info['pagetype'][2]);
		// dd($buildInfo);
		$buildId = array();
		foreach($buildInfo->items() as $key => $val){
			$buildId[] = $val->id;
		}
		// dd($buildId);
		//获取单元信息
		$unit = $this->DynamicDao->getUnitInfo($buildId);
		// dd($unit);
		
		foreach($buildInfo->items() as $key => $val){
			$val->unit = array();
			foreach($unit as $ukey => $uval){
				if($val->id == $uval->bId){
					$val->unit[] = $uval;
				}
			}
			$buildInfo->items()[$key] = $val;
		}
		// dd($buildInfo);
		
		$this->DynamicDao->getUnitInfo($buildId);
		$buildInfo->appends(['communityId'=>$this->communityId, 'type'=>$info['pagetype'][2] ])->render();
		return view('agent.dynamic.loudong', ['title'=>$title, 'loudong'=>true, 'comid'=>$this->communityId, 'build'=>$buildInfo, 'bar'=>$info['bar'], 'data'=>$info['data'], 'pagetype'=>$info['pagetype'], 'hosturl'=>'/dynamic/loudong']);
	}


	/**
	* 户型信息
	*/
	public function huXing(){
		$title = '户型信息';

		//获取物业类型信息
		$info = $this->getPageType($this->communityId);

		//获取户型信息
		$roomInfo = $this->DynamicDao->getRoomInfo($this->communityId, $info['pagetype'][2]);

		$roomInfo->roomId = array();
		foreach($roomInfo  as $key => $val){
			$roomInfo->roomId[] = $val->id;
		}


		// 获取楼栋名称
		$buildInfo = $this->DynamicDao->getCommunityBuildName($this->communityId, $info['pagetype'][2]);
		foreach( $buildInfo as $bval ){
			$roomInfo->build[] = array('id'=>$bval->id, 'num'=>$bval->num );
			$roomInfo->buildId[] = $bval->id;
		}
		if(empty($roomInfo->buildId)){
			$roomInfo->buildId = array();
		}

		$unitInfo = $this->DynamicDao->getUnitInfo( $roomInfo->buildId );
		// dd($unitInfo);


		//获取户型图
		$roomImage = $this->DynamicDao->getRoomImage( $roomInfo->roomId );

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
				if( in_array($imageval->communityRoomId, $roomInfo->roomId)){
					$v->roomimage[] = $imageval;
					unset($roomImage[$imagekey]);
				}
			}
			$roomInfo->items()[$k] = $v;
		}
		// dd($roomInfo);
		$roomInfo->appends(['communityId'=>$this->communityId, 'type'=>$info['pagetype'][2] ])->render();
		
		return view('agent.dynamic.huxing', ['title'=>$title, 'huxing'=>true, 'comid'=>$this->communityId, 'room'=>$roomInfo, 'unit'=>$unit, 'data'=>$info['data'], 'bar'=>$info['bar'], 'pagetype'=>$info['pagetype'], 'hosturl'=>'/dynamic/huxing']);
	}

	/**
	* 相册信息
	*/
	public function photo(){
		$title = '相册信息';

		//获取物业类型信息
		$info = $this->getPageType($this->communityId);


		//判断是否有上传的图片
		$image = $this->DynamicDao->getCommunityImg( $this->userId, $this->communityId, $info['pagetype'][2]);
		if(!empty($image)){
			$imageInfo = [];
			foreach($image as $key => $val){
				$imageInfo[config('imageType.num2type.'.$val->type)][] = $val;
			}
			unset($image);
		}else{
			$imageInfo = '';
		}
		// dd($imageInfo);
		return view('agent.dynamic.photo', ['title'=>$title, 'photo'=>true, 'comid'=>$this->communityId, 'info'=>$imageInfo, 'data'=>$info['data'], 'bar'=>$info['bar'], 'pagetype'=>$info['pagetype'], 'hosturl'=>'/dynamic/photo']);
	}

	/**
	* 营销信息
	*/
	public function sale(){
		$title = '营销信息';

		//获取物业类型信息
		$info = $this->getPageType($this->communityId);

		//获取营销（排期）信息
		$saleInfo = $this->DynamicDao->getPeriods($this->communityId, $info['pagetype'][2]);

		// 获取楼栋名称
		$buildInfo = $this->DynamicDao->getCommunityBuildName($this->communityId, $info['pagetype'][2]);

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
		$saleInfo->appends(['communityId'=>$this->communityId, 'type'=>$info['pagetype'][2] ])->render();
		
		return view('agent.dynamic.sale', ['title'=>$title, 'sale'=>true, 'status'=>1, 'comid'=>$this->communityId, 'sale'=>$saleInfo, 'data'=>$info['data'], 'bar'=>$info['bar'], 'pagetype'=>$info['pagetype'], 'hosturl'=>'/dynamic/sale']);
	}

	/**
	* ajax 删除营销信息 
	*/
	public function deleteSale(){
		$sId = Input::get('sId', '');
		$lId = Input::get('lId', '');
		if(!empty($sId)){
			$flag = $this->DynamicDao->deleteSale($sId);
			if($flag) return 1;
		}
		
		if(!empty($lId)){
			$flag = $this->DynamicDao->deletePeriodsLog($lId);
			if($flag) return 1;
		}

		return 0;
	}

	/**
	* ajax 获取排期维护信息
	*/
	public function getDynamicInfo(){
		$id = Input::get('pId', '');
		$type = Input::get('type', '');
		if(empty($id) || empty($type)) return 0;
		
		$where['cId'] = $id;
		$where['type'] = $type;
		
		$info = $this->DynamicDao->getDynamicInfo($where);
		
		return $info;
	}
	/**
	* 佣金方案
	*/
	public function yongJin(){
		$title = '佣金方案';
		//获取物业类型信息
		$info = $this->getPageType($this->communityId);
		$yongjin = $this->DynamicDao->getCommission($this->communityId);
		
		return view('agent.dynamic.yongjin', ['title'=>$title, 'yongjin'=>true, 'yongjin'=>$yongjin, 'comid'=>$this->communityId, 'bar'=>$info['bar']]);
	}

	/**
	* 楼盘点评 
	*/
	public function comment(){
		$title = '楼盘点评';
		//获取物业类型信息
		$info = $this->getPageType($this->communityId);
		$commentData = $this->DynamicDao->getCommentInfo( $this->userId );
		// dd($commentData);
		return view('agent.dynamic.comment', ['title'=>$title, 'comment'=>true, 'status'=>1, 'comid'=>$this->communityId, 'data'=>$commentData, 'bar'=>$info['bar']]);
	}

	/**
	* ajax 楼盘点评
	*/
	public function commentBuild(){
		$id = Input::get('commentId', '');
		$comment['title'] = Input::get('title');
		$comment['comment'] = Input::get('intro');
		$comment['uId'] = $this->userId;

		if(empty($id)){
			$flag = $this->DynamicDao->insertCommentBuild( $comment );
			if($flag) return 1;
		}else{
			$flag = $this->DynamicDao->updateInfo('communitycomment', $comment, $id);
			if($flag) return 1;
		}
		

		return 0;
	}

	/**
	* ajax 删除点评
	*/
	public function deleteComment(){
		$id = Input::get('commentId', '');
		if(empty($id)) return 0;

		$flag = $this->DynamicDao->deleteInfo('communitycomment', $id);
		if($flag) return 1;

		return 0;
	}
	/**
	* 楼盘消息
	*/
	public function news(){
		$title = '楼盘消息';

		//获取物业类型信息
		$info = $this->getPageType($this->communityId);
		
		$newsData = $this->DynamicDao->getNewsInfo( $this->userId );
		return view('agent.dynamic.news', ['title'=>$title, 'news'=>true, 'status'=>1, 'comid'=>$this->communityId, 'data'=>$newsData, 'bar'=>$info['bar']]);
	}


	/**
	* ajax 楼盘消息
	*/
	public function newsBuild(){
		$id = Input::get('newsId', '');
		$news['title'] = Input::get('title');
		$news['news'] = Input::get('intro');
		$news['uId'] = $this->userId;

		if(empty($id)){
			$flag = $this->DynamicDao->insertNewsBuild( $news );
			if($flag) return 1;
		}else{
			$flag = $this->DynamicDao->updateInfo('communitynews', $news, $id);
			if($flag) return 1;
		}
		

		return 0;
	}

	/**
	* ajax 删除消息
	*/
	public function deleteNews(){
		$id = Input::get('newsId', '');
		if(empty($id)) return 0;

		$flag = $this->DynamicDao->deleteInfo('communitynews', $id);
		if($flag) return 1;

		return 0;
	}

	/**
	* 获取物业类型
	* @param int $communityId  楼盘id
	*/
	public function getPageType( $communityId ){
		
		//获取地址栏传递 物业类型 参数
		$pagetype = Input::get('type', '');
		//从数据库获取存在的 物业类型
		$type = $this->DynamicDao->getCommunityType($communityId);
		if(!$type) return false;
		//物业 主类型
		$type['type1'] = explode('|', $type[0]->type1);
		//物业 副类型
		$type['type2'] = explode('|', $type[0]->type2);
		// dd($type);
		$data = array();
		$bar = $comma = '';
		foreach($type['type1'] as $key => $val){
			foreach($type['type2'] as $key2 => $val2){
				$tmp = config('communityType.'. ($val - 1) .'.'. $val2);
				if($tmp){
					$data[$val][$val2] = $tmp;
					$bar .= $comma.$tmp;
					$comma = ' - ';
				}
			}
		}
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
		
		// dd($data);

		$info = array();
		$info['pagetype'] = $pagetype;
		$info['data'] = $data;
		$info['bar'] = $bar;
		$info['name'] = $type[0]->name;
		unset($type);
		return $info;
	}


	/**
	* ajax 添加楼栋信息（包括单元）
	*/
	public function addBuildInfo(){
		$build['communityId'] = Input::get('id');
		$build['type1'] = Input::get('pagetype1');
		$build['type2'] = Input::get('pagetype2');
		$build['num'] = Input::get('buildName');
		$build['unitTotal'] = Input::get('unitNum');
		$id = $this->DynamicDao->getBuildInfo($build);
		if(empty($id)){
			$id = $this->DynamicDao->addBuildInfo($build);
		}else{
			$id = $id[0]->id;
		}
		// return $id;
		
		$unit['bId'] = $id;
		$unit['num'] = Input::get('unitName');
		$unit['floorTotal'] = Input::get('unitFloor');
		$unit['houseTotal'] = Input::get('unitHouse');
		
		$ratio1 = Input::get('unitRatio1');
		$ratio2 = Input::get('unitRatio2');
		$unit['liftRatio'] = $ratio1.':'.$ratio2;

		$unit['note'] = Input::get('unitNote');

		$this->DynamicDao->addUnitInfo($unit);
		return 1;
	}

	/**
	* ajax 修改楼栋信息
	*/
	public function saveEditloudong(){
		$id = Input::get('id');
		$build['num'] = Input::get('buildName');
		$build['unitTotal'] = Input::get('unitNum');

		if(empty($id)) return 0;

		$flag = $this->DynamicDao->updateInfo('communitybuilding', $build, $id);

		if($flag) return 1;

		return 0;
	}

	/**
	* ajax 删除楼栋信息
	*/
	public function deleteBuild(){
		$id = Input::get('id');
		if(empty($id)) return 0;
		
		$flag = $this->DynamicDao->deleteBuild($id);
		if($flag) return 1;

		return 0;
	}

	/**
	* ajax 删除单元信息
	*/
	public function deleteUnit(){
		$id = Input::get('id');
		if(empty($id)) return 0;

		$flag = $this->DynamicDao->deleteUnit($id);
		if($flag) return 1;

		return 0;
	}

	/**
	* ajax 保存修改后的单元信息
	*/
	public function editUnitInfo(){
		
        $id = Input::get('unitId');
        $unit['num'] = Input::get('unitName');
		$unit['floorTotal'] = Input::get('unitFloor');
		$unit['houseTotal'] = Input::get('unitHouse');
		
		$ratio1 = Input::get('unitRatio1');
		$ratio2 = Input::get('unitRatio2');
		$unit['liftRatio'] = $ratio1.':'.$ratio2;

		$unit['note'] = Input::get('unitNote');

		$this->DynamicDao->updateInfo('communityunit', $unit, $id);

		return 1;
	}

	/**
	* ajax 上传动态管理 信息 相册
	* @author lixiyu
	*/
	public function addPhoto(){
		$userId = $this->userId; //用户id 
		$communityId = $this->communityId;
		
		//获取地址栏传递 物业类型 参数
		$ctype1 = Input::get('type1');
		$ctype2 = Input::get('type2');

		$type = 'community';
		

		$data['biaoti'] = Input::get('biaoti');
		$data['guihua'] = Input::get('guihua');
		$data['xiaoguo'] = Input::get('xiaoguo');
		$data['yangban'] = Input::get('yangban');
		$data['jiaotong'] = Input::get('jiaotong');
		$data['shijing'] = Input::get('shijing');
		$data['peitao'] = Input::get('peitao');
		$data['jindu'] = Input::get('jindu');
		
		// var_dump($data);exit;
		$upload = new UploadImgUtil;
		
		$info = [];
		if(empty($data)) return 1;

		foreach($data as $key => $val){
			if(empty($val)) continue;
			if($key == 'biaoti'){
				if( strpos($val['img'] , 'data:image/jpeg;base64,') === false){
					continue;
				}
				if( !empty($val['id'])){
					// var_dump($val['id']);exit;
					$this->deleteImage( $val['id'] );
				}

				$upload->setImgType( $type );
				$upload->setFix();
				$upload->setImgPath( $userId );
				$upload->setImgInfo( $val['img'] );
				$val = array();
				$val['fileName'] = $upload->saveImg();
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
				$upload->setImgType( $type );
				$upload->setFix();
				$upload->setImgPath( $userId );
				$upload->setImgInfo( $vv['img'] );
				$vv['fileName'] = $upload->saveImg();
				$vv['communityid'] = $communityId;
				$vv['type'] = config('imageType.type2num.'.$key);
				$vv['cType1'] = $ctype1;
				$vv['cType2'] = $ctype2;
				$vv['uid'] = $userId;
				unset($vv['img']);
				$info[] = $vv;
			}
		}
		if(!empty($info)){
			$this->DynamicDao->insertCommunityImg( $info );
		}

		return 1;
	}

	/**
	* 删除楼盘图片
	* @author lixiyu
	* @param array $id 要删除的楼盘图片id
	*/
	public function deleteImage( $id ){
		
		if(!is_array($id)) $id = array($id);
		
		$path = $this->DynamicDao->getImgPath($id);
		
		$flag = $this->DynamicDao->deleteCommunityImg( $id );
		if( !$flag ) return 2;
		
		$imgUtil = new UploadImgUtil;
		foreach($path as $pkey => $pval){
			$flag = $imgUtil->deleteImg($pval->fileName);
		}
		
	}

	/**
	* ajax 添加户型信息
	*/
	public function addHuXing(){
		$room = $this->getRoomInfo();

		$delImg = $room['delImg']; 
		unset($room['delImg']);


		if(!empty($delImg)){
			$this->deleteRoomImage($delImg);
		}

		$id = $room['rId'];  
		unset($room['rId']);
		
		if(empty($id)){
			if(!empty($room['thumbPic'])){
				$upload = new UploadImgUtil;
				$userId = $this->userId; //用户id 
				$info = array();
				foreach($room['thumbPic'] as $val){
					if(empty($val)) continue;
					$upload->setImgType('leyout');
					$upload->setFix();
					$upload->setImgPath( $userId );
					$upload->setImgInfo( $val['img'] );
					$val['fileName'] = $upload->saveImg();
					unset($val['img']);
					$info[] = $val;
				}
				if(!empty($info))
				$room['thumbPic'] = $info[0]['fileName'];
				$info[0]['isTitlePic'] = 1;
			}

			$roomId = $this->DynamicDao->insertRoom($room);
			if(!empty($info) && !empty($roomId)){
				foreach($info as $key => $val){
					$val['communityRoomId'] = $roomId;
					if(empty($val['isTitlePic'])){
						$val['isTitlePic'] = 0;
					}
					$info[$key] = $val;
				}
				$this->DynamicDao->insertRoomImage($info);
			}
			return 1;
		}

		if(!empty($room['thumbPic'])){
			$upload = new UploadImgUtil;
			$userId = $this->userId; //用户id 
			$info = array();
			foreach($room['thumbPic'] as $val){
				if(empty($val)) continue;
				if( strpos($val['img'] , 'data:image/jpeg;base64,') === false){
					$val['fileName'] = str_replace(config('imgConfig.imgSavePath'), '', $val['img']);
					unset($val['img']);
					$info[] = $val;
					continue;
				}

				$upload->setImgType('leyout');
				$upload->setFix();
				$upload->setImgPath( $userId );
				$upload->setImgInfo( $val['img'] );
				$val['fileName'] = $upload->saveImg();
				unset($val['img']);
				$info[] = $val;
			}
			if(!empty($info))
			$room['thumbPic'] = $info[0]['fileName'];
		}
		
		$this->DynamicDao->updateInfo('communityroom', $room, $id);
		$roomId = $id;
		if(!empty($info) && !empty($roomId)){
			foreach($info as $key => $val){
				
				$val['communityRoomId'] = $roomId;
				if(empty($val['isTitlePic'])){
					$val['isTitlePic'] = 0;
				}

				if( !empty($val['id'])){
					$val['fileName'] = str_replace(config('imgConfig.imgSavePath'), '', $val['fileName']);
					$this->DynamicDao->updateInfo('communityroomimage', $val, $val['id']);
					unset($info[$key]);
					continue;
				}
				$info[$key] = $val;
			}
			$this->DynamicDao->insertRoomImage($info);
		}
		return 1;
	}

	/**
	* 删除户型图片
	* @param array $id 要删除的户型图片id
	*/
	public function deleteRoomImage( $id ){
		if(!is_array($id)) $id = array($id);
		$path = $this->DynamicDao->selectRoomImage($id);

		$this->DynamicDao->deleteRoomImage( $id );
		
		$imgUtil = new UploadImgUtil;
		foreach($path as $pkey => $pval){
			$flag = $imgUtil->deleteImg($pval->fileName);
		}
	
	}

	/**
	* 获取户型信息
	*/
	public function deleteRoom(){
		$id = Input::get('rId');
		$this->DynamicDao->deleteRoomInfo($id);
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



	/**
	* ajax 添加营销信息
	*/
	public function addSale(){
		$sale = $this->getSaleInfo();
		$id = $sale['sId'];
		unset($sale['sId']);
		if(empty($id)){
			$flag = $this->DynamicDao->insertSaleInfo($sale);
			if($flag) return 1;
		}else{
			$flag = $this->DynamicDao->updateInfo('communityperiods', $sale, $id);
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
	* ajax 添加 价格记录 动态信息管理 
	*/
	public function updatePrice(){
		$id = Input::get('pId', '');
		$log['cId'] = Input::get('comid', '');
		if(empty($id) || empty($log['cId'])) return 0;

		$sale['saleMaxPrice'] = Input::get('shouGao', '');
		$sale['saleMinPrice'] = Input::get('shouDi', '');
		$sale['saleAvgPrice'] = Input::get('shouPing', '');
		$sale['salePriceDescription'] = Input::get('shouDesc', '');
		$this->DynamicDao->updateSaleInfo( $sale, $id);
		
		
		$log['periodId'] = $id;
		$log['type'] = 1;
		$log['detail'] = json_encode($sale, JSON_UNESCAPED_UNICODE);
		$log['state'] = 0;

		$lId = Input::get('lId', '');
		if(empty($lId)){
			$this->DynamicDao->insertDynamicInfo($log);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}else{
			$this->DynamicDao->updateInfo('communityperiodslog', $log, $lId);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}
		
		return 'fail';
	}

	/**
	* ajax 添加户数记录
	*/
	public function updateNum(){
		$id = Input::get('pId', '');
		$log['cId'] = Input::get('comid', '');
		if(empty($id) || empty($log['cId'])) return 0;

		$sale['houseNum'] = Input::get('countNum', '');
		$this->DynamicDao->updateSaleInfo( $sale, $id);

		$log['periodId'] = $id;
		$log['type'] = 2;
		$log['detail'] = json_encode($sale, JSON_UNESCAPED_UNICODE);
		$log['state'] = 0;

		$lId = Input::get('lId', '');
		if(empty($lId)){
			$this->DynamicDao->insertDynamicInfo($log);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}else{
			$this->DynamicDao->updateInfo('communityperiodslog', $log, $lId);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}
		
		return 'fail';
	}

	/**
	* ajax 添加楼栋记录
	*/
	public function updateBuild(){
		$id = Input::get('pId', '');
		$log['cId'] = Input::get('comid', '');
		if(empty($id) || empty($log['cId'])) return 0;

		$sale['cbIds'] = Input::get('cbIds', '');
		
		$this->DynamicDao->updateSaleInfo( $sale, $id);

		$info['buildDesc'] = Input::get('buildDesc');
		$info['cbname'] = Input::get('cbname');
		$info['cbIds'] = $sale['cbIds'];

		$log['periodId'] = $id;
		$log['type'] = 5;
		$log['detail'] = json_encode($info, JSON_UNESCAPED_UNICODE);
		$log['state'] = 0;

		$lId = Input::get('lId', '');
		if(empty($lId)){
			$this->DynamicDao->insertDynamicInfo($log);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}else{
			$this->DynamicDao->updateInfo('communityperiodslog', $log, $lId);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}
		
		return 'fail';
	}

	/*
	* ajax 添加折扣记录
	*/
	public function updateZhe(){
		$id = Input::get('pId', '');
		$log['cId'] = Input::get('comid', '');
		if(empty($id) || empty($log['cId'])) return 0;

		$sale['discountType'] = Input::get('zheType', '');
		$sale['discount'] = Input::get('zhe', '');
		$sale['subtract'] = Input::get('jian', '');

		$this->DynamicDao->updateSaleInfo( $sale, $id);

		$info['zheDesc'] = Input::get('zheDesc');
		$info['discountType'] = $sale['discountType'];
		$info['discount'] = $sale['discount'];
		$info['subtract'] = $sale['subtract'];
		
		$log['periodId'] = $id;
		$log['type'] = 3;
		$log['detail'] = json_encode($info, JSON_UNESCAPED_UNICODE);
		$log['state'] = 0;

		$lId = Input::get('lId', '');
		if(empty($lId)){
			$this->DynamicDao->insertDynamicInfo($log);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}else{
			$this->DynamicDao->updateInfo('communityperiodslog', $log, $lId);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}
		
		return 'fail';
	}

	/**
	* ajax 添加电商优惠记录
	*/
	public function updateDianYou(){
		$id = Input::get('pId', '');
		$log['cId'] = Input::get('comid', '');
		if(empty($id) || empty($log['cId'])) return 0;

		$sale['specialOffers'] = Input::get('dianYou', '');

		$this->DynamicDao->updateSaleInfo( $sale , $id);
		
		$info['dianYouDesc'] = Input::get('dianYouDesc');
		$info['specialOffers'] = $sale['specialOffers'];

		$log['periodId'] = $id;
		$log['type'] = 4;
		$log['detail'] = json_encode($info, JSON_UNESCAPED_UNICODE);
		$log['state'] = 0;

		$lId = Input::get('lId', '');
		if(empty($lId)){
			$this->DynamicDao->insertDynamicInfo($log);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}else{
			$this->DynamicDao->updateInfo('communityperiodslog', $log, $lId);
			$where['cId'] = $log['cId'];
			$where['type'] = $log['type'];
			$info = $this->DynamicDao->getDynamicInfo($where);
			$info['type'] = $log['type'];
			return $info;
		}
		
		return 'fail';
	}

	/**
	* ajax 获取营销信息排期动态信息翻页
	*/
	public function pageTurn(){
		$pageobj = Input::get('param', '');
		if(empty($pageobj)) return 0;
		
		$where['periodId'] = $pageobj['pId'];
		$where['type'] = $pageobj['type'];

		$limit[0] = ( $pageobj['cur'] - 1 ) * 3;	
		$limit[1] = 3;
		$obj = $this->DynamicDao->getPageTurn($where, $limit);
		
		if($obj){
			$count = $this->DynamicDao->getPeriodsCount($where);
			$info = array();
			$info['current_page'] = $pageobj['cur'];
			$info['data'] = $obj;
			$info['last_page'] = (int) ceil($count / 3);
			return $info;
		}
		return 0;
	}
}