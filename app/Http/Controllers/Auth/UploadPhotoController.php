<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Input;
use App\Http\Controllers\Utils\UploadImgUtil;
use App\Http\Controllers\SofangFileClient\SofangFileClientController;
use Exception;
/**
* Description of UploadPhotoController
* 上传图片公共接口
* @author lixiyu
*/
class UploadPhotoController extends Controller{

	protected $userId 		= 0;         										// 用户id   通过用户id进行分文件夹
	
	protected $upload;

	public function __construct(){
		if(Auth::check()){
			$this->userId = Auth::user()->id;
		}
		//$this->upload = new UploadImgUtil;
		$this->upload = new SofangFileClientController;
	}

	/**
	* 接收图片
	*/
//	public function addPhoto(){
//		if(!empty($_FILES)){
//			foreach($_FILES as $key => $val){
//				if($val['error'] != 0) continue;
//				$this->upload->setPhotoType( $key );
//				$this->upload->setFix();
//				$this->upload->setImgPath( $this->userId );
//				$callPath = $this->upload->saveImg($val['tmp_name']);
//			}
//		}
//
//		if(!empty($callPath)) return $callPath;
//		return 0;
//	}

	/**
	 * 接收图片(改版)
	 */
	public function addPhoto(){
		if(!empty($_FILES)){
			foreach($_FILES as $key => $val){
				if($val['error'] != 0) continue;
				$imageType = Input::get('imageType', '');
				if(empty($imageType)) $imageType = 'userPhoto';
				if(in_array($imageType, ['commPhoto', 'houseSale', 'houseRent'])){
					$imageInfo = getimagesize($val['tmp_name']);
					if($imageInfo[0] < '550'){
						return 1; // 返回 1 提示图片的宽度不得小于 650px
					}
				}

				try{
					$callPath = $this->upload->saveFromFile($imageType, $val['tmp_name']);
				}catch(Exception $e){
					dd($e->getMessage());
					return 0; // 返回 0 上传失败 文件已损坏（未知错误）
				}

			}
		}

		if(!empty($callPath)) return $callPath;
		return 0;
	}

//    /**
//    * ajax 根据图片路径删除图片
//    */
//    public function delPhoto(){
//    	$path = Input::get('photo_path', '');
//    	if(empty($path)) return 0;
//
//    	$flag = $this->upload->deleteImg( $path );
//    	if($flag) return 1;
//
//    	return 0;
//    }
	/**
	 * ajax 根据图片路径删除图片(改版)
	 */
	public function delPhoto(){
		$path = Input::get('photo_path', '');
		if(empty($path)) return 0;
		$imageType = Input::get('imageType', '');
		if(empty($imageType)) $imageType = 'userPhoto';
		$this->upload->deleteFile($imageType, $path);
		return 1;
	}
}