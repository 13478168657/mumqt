<?php
namespace App\Http\Controllers\SofangFileClient;
use Input;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\SofangFileClientBase;

/**
 * 上传文件
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年2月24日 上午10:10:18
 * @version 1.0
 */
class SofangFileClientController extends Controller {
	
	function __construct(){
		$this->Base = new SofangFileClientBase;		//上传文件基类
		$this->ImageUtil = new \App\Http\Controllers\Utils\ImageUtil;	//图片操作类
		$this->baiduBce = config('baiduBce');		//bucket名称分类集合
		$this->enableBaiduBce = config('imgConfig.enableBaiduBce');	//是否使用百度云存储图片：true.是 false.否
		$this->rootPath = $this->baiduBce['rootPath'];
		$this->otherSizePath = $this->baiduBce['otherSizePath'];
	}
	
	/**
	 * 获取全部bucket列表
	 */
	private function getListBuckets(){ 
		return $this->Base->sf_listBuckets();
	}
	
	/**
	 * 上传（未完成）
	 */
	public function save($bucketName='', $objectKey='', $data=''){
		/* $type = '';
		if($type == 'string'){
			return self::saveFromString();
		}elseif($type == 'file'){
			return self::saveFromFile();
		} */
// 		return $this->Base->putObject($bucketName, $objectKey, $data);
// 		dd($this->Base->sf_listBuckets());
		dd($this->Base->listObjects('cidgur-bucket2'));
	}
	
	/**
	 * 从字符串上传object（未完成）
	 */
	public function saveFromString(){
		return $this->Base->putObjectFromString();
	}
	
	/**
	 * 从文件流上传附件object
	 * @param	string		$objectType		object分类，可根据分类获取bucket名称、路径
	 * @param	string		$tempFile		待上传文件流
	 * @return	object						返回文件路径
	 */
	public function saveFromInputFile($objectType='', $tempFile=''){
		if(empty($objectType) || empty($tempFile) || $tempFile['error'] == 1){
			return false;
		}
		if(isset($this->baiduBce['bucketName'][$objectType])){
			$bucketName = $this->baiduBce['bucketName'][$objectType];
		}else{
			return false;
		}
		/* 生成附件路径 */
		if(in_array($objectType, ['contract'])){
// 			$file_path = $this->makeAttUrl($objectType, $tempFile);
			$objectKey = $this->ImageUtil->makeImgUrl($objectType, $tempFile);	//生成路径
			if($objectKey === false){
				return false;
			}
			if($this->enableBaiduBce == true){		//百度云存储
				$result = $this->Base->putObjectFromFile($bucketName, $objectKey, $tempFile['tmp_name']);
			}else{									//本地服务器存储
				$objectKey_new = $this->rootPath.$objectKey;
				$this->createFolder($objectKey_new);
				$result = copy($tempFile['tmp_name'], $objectKey_new);
				$this->ImageUtil->delImg($tempFile['tmp_name']);
			}
			if($result!==false){
				return $objectKey;
			}else{
				return false;
			}
		}
		return false;
	}

	/**
	 * 从文件上传object
	 * @param	string		$objectType		object分类，可以根据分类获取bucket名称、路径
	 * @param	string		$tempFile		临时文件路径
	 * @param	bool		$is_del			是否删除临时文件：true.删除，false.不删除（不删除为测试用，临时文件会被等比例缩放到最小档）
	 * @return 	object						返回文件路径
	 */
	public function saveFromFile($objectType='', $tempFile='', $is_del=true){
// 		echo $objectType . "<br>" . $tempFile;exit;
		$objectType = !empty($objectType) ? $objectType : Input::get('objectType');
		$tempFile = !empty($tempFile) ? $tempFile : Input::get('tempFile');
		$is_del = Input::has('is_del') ? Input::has('is_del') : $is_del;
		if(isset($this->baiduBce['bucketName'][$objectType])){
			$bucketName = $this->baiduBce['bucketName'][$objectType];
		}else{
			return false;
		}
		/* 图片按比例截取部分，并进行等比例压缩 */
		if( in_array($objectType, ['houseSale', 'houseRent', 'commPhoto'])){
			$tempFile = $this->ImageUtil->cutPicture($tempFile);
		}
		/* 生成图片路径 */
		$objectKey = $this->ImageUtil->makeImgUrl($objectType);			
		if($objectKey == false){
			return false;
		}
		if($this->enableBaiduBce == true){		//百度云存储
			$result = $this->Base->putObjectFromFile($bucketName, $objectKey, $tempFile);
		}else{									//本地服务器存储
			$picSize_arr = $this->baiduBce['picSize'][$objectType];	//各种类图片长宽比及对应编号
			foreach($picSize_arr as $picSize_key=>$picSize_val){
				if($picSize_key == '0'){		//原尺寸图片
					$objectKey_new = $this->rootPath.$objectKey;
					$this->createFolder($objectKey_new);
// 					echo $this->rootPath . $objectKey.'<br>';
				}else{										//缩放尺寸图片
					preg_match("/^(.*)(\.[^.]*)$/", $objectKey, $matches, PREG_OFFSET_CAPTURE);
					$objectKey_new = $this->rootPath . $this->otherSizePath . $matches[1][0] . '_' . $picSize_key . $matches[2][0];
					$this->createFolder($objectKey_new);
// 					echo $this->rootPath . $this->otherSizePath . $matches[1][0] . '_' . $picSize_key . $matches[2][0]."<br>";
					$tempFile = $this->ImageUtil->cutPicture($tempFile, $this->baiduBce['picSize'][$objectType][$picSize_key]['maxWidth'], $this->baiduBce['picSize'][$objectType][$picSize_key]['maxHeight']);
				}
				/* 上传图片 */
				$result = copy($tempFile, $objectKey_new);
			}
		}
		/* 删除临时图片 */
		if($is_del === true){
			$this->ImageUtil->delImg($tempFile);
		}
		/* 返回文件路径 */
		if($result!==false){
			return $objectKey;
		}else{
			return false;
		}
	}
	
	/**
	 * 从base64上传object
	 * @param string 	$objectType		object分类，可以根据分类获取bucket名称、路径
	 * @param string 	$base64			base64编码
	 */
	public function saveFromBase($objectType='', $base64=''){
		if(isset($this->baiduBce['bucketName'][$objectType])){
			$bucketName = $this->baiduBce['bucketName'][$objectType];
		}else{
			return false;
		}
		/* 生成图片路径 */
		$tempFilePath = $this->ImageUtil->makeImgUrl($objectType);
		if($tempFilePath == false){
			return false;
		}
		$tempFilePath = rtrim($this->baiduBce['tempFilePath'], '/') . $tempFilePath;
		$this->createFolder($tempFilePath);
// 		$tempFilePath = 'e:' . $this->baiduBce['tempFilePath'];
		/* 生成图片 */
		$file = explode(',', $base64);
		if(empty($file[1])){
			return false;
		}
		$file = base64_decode($file[1]);
		$flag = @file_put_contents($tempFilePath, $file);
		if($flag!==false){		//生成图片成功
			return $this->saveFromFile($objectType, $tempFilePath);
		}else{
			return false;
		}
	}
	
	/**
	 * 获取object路径
	 * @param 	string 	$objectType		object分类，可以根据分类获取bucket名称、路径
	 * @param 	string 	$key			文件相对路径
	 * @param 	string	$sizeType		图片尺寸分类
	 * @return boolean|\App\Http\Controllers\Utils\文件路径|string
	 */
	public function getObjectPath($objectType, $key, $sizeType){
		if($this->enableBaiduBce == true){		//百度云存储
			if(isset($this->baiduBce['bucketName'][$objectType])){
				$bucketName = $this->baiduBce['bucketName'][$objectType];
			}else{
				return false;
			}
			if($bucketName == 'pic1'){		//共有数据通过计算获取
				return 'http://' . $bucketName . '.' . $this->baiduBce['host'] . $key;
			}else{							//私密数据通过接口获取
				return $this->Base->generatePreSignedUrl($bucketName, $key);
			}
		}else{									//本地服务器
			if($sizeType == ''){			//原尺寸
				return config('imgConfig.imgSavePath') . $key;
			}else{							//缩放尺寸
				preg_match("/^(.*)(\.[^.]*)$/", $key, $matches, PREG_OFFSET_CAPTURE);
				if(empty($matches)){//传入的图片地址有误，返回空
					return '';
				}
				/* 判断缩放文件是否存在，若不存在则调取原图地址 */
				if(!file_exists(config('baiduBce.rootPath') . $this->otherSizePath . $matches[1][0] . '_' . $sizeType . $matches[2][0])){		//不存在缩放图片实体文件，则调取原始大小图片
					return config('imgConfig.imgSavePath') . $matches[1][0] . $matches[2][0];
				}else{
					return config('imgConfig.imgSavePath') . $this->otherSizePath . $matches[1][0] . '_' . $sizeType . $matches[2][0];
				}
			}
		}
	}
	
	/**
	 * 复制图片
	 * @param	string		$objectType		object分类，可以根据分类获取bucket名称、路径
	 * @param	string		$tempFile		临时文件路径
	 * @param	string		$picSize_key	图片尺寸编号
	 * @return	boolean|string
	 */
	public function copyFromFile($objectType='', $tempFile='', $picSize_key=''){
		if(isset($this->baiduBce['bucketName'][$objectType])){
			$bucketName = $this->baiduBce['bucketName'][$objectType];
		}else{
			return false;
		}
		/* 生成图片路径 */
		$objectKey = $this->ImageUtil->makeImgUrl($objectType);
		if($objectKey == false){
			return false;
		}
		if($this->enableBaiduBce == true){		//百度云存储
			$result = $this->Base->copyObject($bucketName, $tempFile, $bucketName, $objectKey);
		}else{									//本地服务器存储
			$this->createFolder($this->rootPath.$objectKey);
			if($picSize_key == ''){			//复制原尺寸
				$result = copy($this->rootPath.$tempFile, $this->rootPath.$objectKey);
			}else{							//复制并缩放尺寸
				/* 源文件 */
				preg_match("/^(.*)(\.[^.]*)$/", $tempFile, $matches, PREG_OFFSET_CAPTURE);
				$tempFile_new = $this->rootPath . $this->otherSizePath . $matches[1][0] . '_' . $picSize_key . $matches[2][0];
				/* 复制目标地址 */
				preg_match("/^(.*)(\.[^.]*)$/", $objectKey, $matches, PREG_OFFSET_CAPTURE);
				$objectKey_new = $this->rootPath . $this->otherSizePath . $matches[1][0] . '_' . $picSize_key . $matches[2][0];
				copy($this->rootPath . $tempFile, $this->rootPath . $objectKey);
				$result = copy($tempFile_new, $objectKey_new);
			}
		}
		if($result!==false){
			return $objectKey;
		}else{
			return false;
		}
	}

	/**
	 * 删除object
	 * @param string $objectType	object分类，可以根据分类获取bucket名称、路径
	 * @param string $key			objectKey
	 * @return object
	 */
	public function deleteFile($objectType, $key){
		if($this->enableBaiduBce == true){		//百度云存储
			if(isset($this->baiduBce['bucketName'][$objectType])){
				$bucketName = $this->baiduBce['bucketName'][$objectType];
			}else{
				return false;
			}
			$result = $this->Base->deleteObject($bucketName, $key);
			if($result !== false){
				return true;
			}else{
				return false;
			}
		}else{					//本地服务器
			$picSize_arr = $this->baiduBce['picSize'][$objectType];	//各种类图片长宽比及对应编号
			foreach($picSize_arr as $picSize_key=>$picSize_val){
				if($picSize_key == '0'){		//删除原尺寸图片
					$path = $this->rootPath . $key;
					if( file_exists($path) ){
						@unlink($path);
					}
				}else{										//删除缩放尺寸图片
					preg_match("/^(.*)(\.[^.]*)$/", $key, $matches, PREG_OFFSET_CAPTURE);
					$path = $this->rootPath . $this->otherSizePath . $matches[1][0] . '_' . $picSize_key . $matches[2][0];
					if( file_exists($path) ){
						@unlink($path);
					}
				}
			}
		}
	}
	
	/**
	 * 替换文件（上传新的+删除旧的）
	 * @param string $objectType	object分类，可以根据分类获取bucket名称、路径
	 * @param string $tempFile		临时文件路径
	 * @param string $deleteFile	待删除objectKey
	 * @return Ambigous <object, boolean, string>
	 */
	public function changeFile($objectType='', $tempFile='', $deleteFile=''){
		/* 上传新的 */
		$saveResult = self::saveFromFile($objectType, $tempFile);
		/* 删除旧的 */
		if($saveResult == true){
			self::deleteFile($objectType, $deleteFile);
		}else{
			return $saveResult;
		}
	}

	/**
	 * 获取加密路径
	 */
	public function getPreSignedUrl(){
		return $this->Base->generatePreSignedUrl();
	}
	
	/**
	 * 创建文件路径目录
	 * @param string $objectKey
	 */
	public function createFolder($objectKey=''){
		$path = mb_ereg_replace("[^\/]*$", "", $objectKey);
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
	}
}