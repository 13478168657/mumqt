<?php
namespace App\Http\Controllers\Utils;
class ImgUtil {

	public static function getImgUrl($url)
	{
		//dd($url);
		if (is_null($url)||$url=="") {
			return "/images/1.png";
		}
		$newurl=ltrim($url,'/');
		if(strpos($newurl, 'attachment/', 0)!==false){			//老版本图片地址调整
			$newurl = str_replace('attachment/', '', $newurl);
		}
		$firstRoot=explode('/',$newurl)[0];
		$imgHostUrl=array_get(ImgUtil::imgHost(),$firstRoot);

		if (in_array($firstRoot,['sale','rent','photo','community','other','card'])) {
			$url = $imgHostUrl.'/'.$newurl;
			$url= str_replace("\\", "/", $url);
			return $url;
		}elseif(preg_match("/group(?:\d)*/i", $firstRoot)){
			return array_get(ImgUtil::imgHost(), 'group') . '/' . $newurl;
		}
		if (!is_null($imgHostUrl)&&$imgHostUrl!="") {
			$url  = $imgHostUrl.'/'.'attachment/'.$newurl;
			$url= str_replace("\\", "/", $url);
			return $url;
		}
		return $url;
	}

	public static function imgHost()
	{
		$imgHost=array('sfaa'=>'http://image5.sofang.com',
			'sfaf'=>'http://image2.sofang.com',
			'sfphoto'=>'http://image3.sofang.com',
			'sfpic'=>'http://image3.sofang.com',
			'housepic'=>'http://image3.sofang.com',
			'houseimage'=>'http://image3.sofang.com',
			'salepic'=>'http://image1.sofang.com',
			'fangimages'=>'http://image1.sofang.com',
			'sfidcard'=>'http://image5.sofang.com',
			'idcard'=>'http://image5.sofang.com'
		);
		//$configImg=config('imgConfig.hostImg');

		$imgHostUrl=array_merge($imgHost,config('imgConfig.hostImg'));
		return $imgHostUrl;
	}

	private static function getFirstBoot($url)
	{
		$firstRoot=$url;
		$newurl=ltrim($url,'/');
//		$position=strstr($newurl,'/');
//		if ($position>0) {
		$firstRoot=explode('/',$newurl)[0];
		//}
		return $firstRoot;
	}

	/* 获取用户头像图片地址 */
	public static function getBrokerImgUrl($userId,$photo)
	{
		if (is_null($photo)||$photo=="") {
			//$baseUrl='http://www.sofang.com/attachment/upload/middle/';
			//return $baseUrl.substr($userId,-2,2).'/'.$userId.'.jpg';
			return '/images/touxiang.gif';
		}elseif(strrpos($photo, "/images/userImg/") !== false){
			return $photo;
		}
		$firstBoot=ImgUtil::getFirstBoot($photo);
		
		if ($firstBoot=="photo") {
			$imgHostUrl=array_get(ImgUtil::imgHost(),$firstBoot);
			return $imgHostUrl.$photo;
		}
		return rtrim(config("imgConfig.hostImg.photo"),"/")."/".ltrim($photo,"/");
		// return '/upload/middle/'.$photo;
	}
	
	/* 删除图片实体文件
	 * $img_arr：图片集合
	 * $img_save_path：图片保存目录，输入案例（imgConfig.imgSavePath）*/
	public static function delImg($img_arr, $img_save_path=''){
		if(!empty($img_arr)){
			if(!is_array($img_arr)){
				$img_arr = array($img_arr);
			}
			foreach($img_arr as $key=>$item){
				$arrImgPath = array();
				$arrImgPath=parse_url($item);
				/* 判断图片所在服务器，选择删除方式 */
				$newurl=ltrim(str_replace('/', DIRECTORY_SEPARATOR, $arrImgPath['path']),'/');
				$firstRoot=explode('/',$newurl)[0];
				if(preg_match("/group(?:\d)*/i", $firstRoot)){			//分布式存储图片，删除需要走接口
					$newurl = substr($newurl, strpos($newurl, '/')+1);
					// 					$beDel = array_get(ImgUtil::imgHost(), 'group') . '/' . $newurl;
					$beDel = fastdfs_storage_delete_file($firstRoot, $newurl);
				}else{
					// 					dd(config('imgConfig.imgSavePath').str_replace('/', DIRECTORY_SEPARATOR, $arrImgPath['path']));
					$beDel = @unlink(config('imgConfig.imgSavePath').str_replace('/', DIRECTORY_SEPARATOR, $arrImgPath['path']));
				}
			}
		}
	}
}