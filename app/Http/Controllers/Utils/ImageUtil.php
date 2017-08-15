<?php
namespace App\Http\Controllers\Utils;
/**
 * 图片相关操作 
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年2月25日 下午4:47:15
 * @version 1.0
 */
class ImageUtil{
	
    //图片类型
    var $type;
    //临时创建的图象
    var $im;
    //目标图象地址
    var $dstimg;
    //源图象
    var $srcimg;
    // 根据不同的图片mime类型 来调用不同的方法
	var $createImg = array('1'=>'imagecreatefromgif', '2'=>'imagecreatefromjpeg', '3'=>'imagecreatefrompng');
	var $saveImg   = array('1'=>'imagegif', '2'=>'imagejpeg', '3'=>'imagepng');
    function __construct(){
    	$this->type;
    	$this->im;
    	$this->dstimg;
    	$this->srcimg;
    }
    
	/**
	 * 生成文件路径（objectKey）
	 * @param	string		$objectType		文件所在分类
	 * @param	string		$tempFile		原文件名称
	 */
	public static function makeImgUrl($objectType, $tempFile=''){
		if(in_array($objectType, ['contract'])){		//上传附件
			$file_format = substr($tempFile['name'], strrpos($tempFile['name'], '.') + 1);
		}else{											//上传图片
			$file_format = 'jpg';
		}
		$objectUrl = config('baiduBce.objectUrl');
		/* 生成路径前半部分 */
		if(isset($objectUrl[$objectType])){
			$pathBefore = $objectUrl[$objectType];
		}else{
			return false;
		}
		/* 生成路径中间部分 */
		$pathMiddle = "/" . date("Y_m") . "/" . date("d") . "/"; 
		/* 生成图片名称 */
		$fileName = date("His") . "_" . floor(microtime()*1000) . "_" . self::createRandomCode(4) . "." . $file_format;
		/* 生成完整路径 */
		$path = $pathBefore . $pathMiddle . $fileName;
		return $path;
	}
	
	/**
	 * 生成随机字符串
	 * @param 	int 	$length		返回字符串长度
	 * @return 	string				返回字符串
	 */
	public static function createRandomCode($length) {
		$randomCode = "";
		$randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i < $length; $i++) {
			$randomCode .= $randomChars { mt_rand(0, 35) };
		}
		return $randomCode;
	}
	
	/**
	 * 删除图片实体文件
	 * @param 	array/string 	$img_arr	图片集合或单张图片路径
	 */
	public static function delImg($img_arr){
		if(!empty($img_arr)){
			if(!is_array($img_arr)){
				$img_arr = [$img_arr];
			}
			foreach($img_arr as $key=>$item){
				@unlink($item);
			}
		}
	}
	
	
	/**
	 * 图片按比例截取部分，并进行等比例压缩
	 * 宽高比大于16:10的截取高度，小于16:10的截取宽度；
	 * 宽高大于$maxWidth或$maxHeight的进行等比例压缩
	 * @param string $fileName		图片绝对路径
	 * @param int	 $maxWidth		图片最大宽度
	 * @param int	 $maxHeight		图片对大高度
	 */
	public function cutPicture($fileName='', $maxWidth=0, $maxHeight=0){
		/* 获取图片宽高 */
		$img = getimagesize($fileName);
		$width=$img["0"];//获取图片的宽
		$height=$img["1"];//获取图片的高
		$maxWidth = (empty($maxWidth)) ? config('baiduBce.defaultPicSize.maxWidth') : $maxWidth;
		$maxHeight = (empty($maxHeight)) ? config('baiduBce.defaultPicSize.maxHeight') : $maxHeight;
		if($width < $maxWidth && $height < $maxHeight){
			$newPointX = 0;
			$newPointY = 0;
			$newCutWidth = $width;
			$newCutHeight = $height;
		}else{
			$newPointX = 0;
			$newPointY = 0;
			if(($width/$height) > ($maxWidth/$maxHeight)){	//按宽度比例缩放
				$newCutWidth = $maxWidth;
				$newCutHeight = $height*($maxWidth/$width);
			}else{											//按高度比例缩放
				$newCutWidth = $width*($maxHeight/$height);
				$newCutHeight = $maxHeight;
			}
		}
		
		/* 图片等比例缩放 */
		$this->cut($fileName, $fileName, 0, 0, $width, $height, $newCutWidth, $newCutHeight);
		return $fileName;
	}
	
	function cut($fileName, $dstpath, $x, $y, $width, $height, $final_width, $final_height) {        
        $this->srcimg = $fileName;
        $imageInfo = getimagesize($this->srcimg);  // 获取图片信息 
        //动态调用GD库创建新图像函数 
        $this->im = $this->createImg[$imageInfo[2]]($this->srcimg);
        //目标图象地址
        $this->dstimg = $dstpath;
        $newimg = imagecreatetruecolor($final_width, $final_height);
        imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $final_width, $final_height, $width, $height);        
        //动态调用GD库保存图像函数
        $this->saveImg[$imageInfo[2]]($newimg, $this->dstimg);
        /* try {
            //删除原图片
            imgUtil::delImg($arrFilePath['webPath']);
//             unlink($img);
        } catch (Exception $e) {
            
        } */               
    }
    
    //初始化图象
    /* function initi_img() {
    	if ($this->type == "jpg") {
    		$this->im = imagecreatefromjpeg($this->srcimg);
    	}
    	if ($this->type == "gif") {
    		$this->im = imagecreatefromgif($this->srcimg);
    	}
    	if ($this->type == "png") {
    		$this->im = imagecreatefrompng($this->srcimg);
    	}
    } */
}