<?php
namespace App\Http\Controllers\Utils;

/**
* descreption of UploadeImgUtil
* @since 1.0
* @author lixiyu
*/
class UploadImgUtil{

	protected $type         = 'other';                                          // 图片类型  例： community楼盘/ room户型/  默认：other
    protected $pathGroup    = [];                                               // 图片路径组
    protected $imgName      = '';                                               // 设置图片名字
    protected $imgBase64    = '';                                               // 图片64位数据 字符串
    protected $filePath     = '';                                               // 图片保存的路径目录
    protected $rootPath     = DIRECTORY_SEPARATOR."img";                        // 图片保存的路径前缀
    protected $dbPath       = DIRECTORY_SEPARATOR."sofang".DIRECTORY_SEPARATOR; // 存入数据库的路径
    protected $error        = 'not error';                                      // 错误信息

    /**
    * 设置图片类型
    * @param string $type 
    */
    public function setPhotoType( $type ){
        $this->type = $type;
    }

    /**
    * 设置保存图片路径 
    * @param int $userid  用户id  以用户id 分文件夹
    */
    public function setImgPath( $userid ){

        if(!is_numeric($userid)){
            $this->error = 'userid is not undefined';
            return false;
        }
        /*路径 start */
        $absPath        = $this->dbPath.$userid;
        $relPath        = str_replace( DIRECTORY_SEPARATOR, '/', $absPath);
        /* 路径 end   */

        $relativePath   = "";

        $relativePath  .= DIRECTORY_SEPARATOR.$this->type;
        
        $yearPath       = date('Y', time());
        $monthPath      = date('m', time());
        $dayPath        = date('d', time());
        
        $relativePath   = $relativePath . DIRECTORY_SEPARATOR . $yearPath . DIRECTORY_SEPARATOR . $monthPath . DIRECTORY_SEPARATOR . $dayPath;
        
        $this->filePath = $absPath. $relativePath . DIRECTORY_SEPARATOR;
        
        $this->createFolder();
        $clientName = $this->getFix();

        $fileNewName = md5(date('ymdhis') . $clientName) . "." . substr(strrchr($clientName, '.'), 1);
        $this->pathGroup =  array(
                                'localPath'     => $this->filePath . $fileNewName,
                                'filePath'      => $this->filePath,
                                'webFilePath'   => $relPath.str_replace(DIRECTORY_SEPARATOR, '/', $relativePath) . '/',
                                'webPath'       => $relPath.str_replace(DIRECTORY_SEPARATOR, '/', $relativePath) . '/' . $fileNewName
                            );
    }

    /**
    * 获取图片保存路径 默认空数组
    */
    public function getImgPath(){
        return $this->pathGroup;
    }

    /**
    * 设置文件名字
    * @param $suffix 后缀名
    */
    public function setFix( $suffix = 'jpg' ){
         $this->imgName = "1_".date("YmdHis").'_'.floor(microtime() * 1000).'_'.  $this->createRandomCode(8).'.'.$suffix;
    }

    /**
    * 获取文件名字
    */
    public function getFix(){
        if($this->imgName == ''){
            $this->error = 'imgName is not set';
            return false;
        }
        return $this->imgName;
    }

    /**
    * 保存图片  并返回图片路径 
    * @param res  $file 通过文件流获取的临时文件
    */
    public function saveImg( $file ){
        $imgPath = $this->getImgPath();
        if(empty($imgPath)){
            $this->error = 'imgPath is not set';
            return false;
        }

        $webPath = str_replace(DIRECTORY_SEPARATOR, '/', $imgPath['localPath']);  
        
        if (empty($file)) {
            $this->error = 'imgInfo is not set';
            return false;
        }
            
        $newName = $imgPath['localPath'];
        
        $flag = move_uploaded_file($file, $this->rootPath . $newName);
        if(empty($flag)){
            $this->error = 'image seve faild';
            return false;
        }
        return $webPath;
    }


    //创建图片路径目录
    public function createFolder(){
        if (!is_dir($this->rootPath . $this->filePath)) {
            mkdir($this->rootPath . $this->filePath, 0777, true);
        }
    }

    
    //随机文件名 默认8位数
    function createRandomCode($length = 8) {
        $randomCode = "";
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $randomChars { mt_rand(0, 35) };
        }
        return $randomCode;
    }

    //获取错误信息
    public function getError(){
        return $this->error;
    }

    /**
    * 删除图片文件
    * @param string $path 图片的路径
    */
    public function deleteImg($path){
        $path = $this->rootPath . $path;
        if( !file_exists($path) ){
            $this->error = 'this file is not exists';
            return false;
        }
        return unlink($path);
    }

	/**
	 * 复制图片文件
	 * @param string $fileUrl 原图片路径
	 * @return boolean
	 */
	public function copyFile($fileUrl) {
		$fileUrl = str_replace(config('imgConfig.imgSavePath'), '',$fileUrl);
		$fileUrl = $this->rootPath . $fileUrl;
		$imgPath = $this->getImgPath();
		$aimUrl = $this->rootPath . $imgPath['localPath'];
        
        if(copy($fileUrl, $aimUrl)){
			return $imgPath['localPath'];
		}else{
			return false;
		}
	}


}