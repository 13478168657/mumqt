<?php
namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\User\ImageController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Redirect;
use App\Http\Controllers\Utils\ImgUtil;
use App\Dao\User\MyInfoDao;
use App\Dao\Agent\MySouFangDao;
use App\Http\Controllers\SofangFileClient\SofangFileClientController;

class UploadsController extends Controller {

    //图片类型
    var $type;
    //临时创建的图象
    var $im;
    //目标图象地址
    var $dstimg;
    //源图象
    var $srcimg;
    // 根据不同的图片mime类型 来调用不同的方法
    var $createImg = array('2'=>'imagecreatefromjpeg', '3'=>'imagecreatefrompng');
    protected $ImgUpload;

    public function __construct(){
        $this->ImgUpload = new SofangFileClientController(); // 实例一个上传图片对象
    }
        
    function  cutparam($userid, $x1 = '', $y1 = '', $CutWidth = '', $CutHeight = '', $PicWidth = '', $PicHeight = '', $base64 = ''){
        $x1 = (empty($x1))?Input::get('x1'):$x1;
        $y1 = (empty($y1))?Input::get('y1'):$y1;
        $CutWidth = (empty($CutWidth))?Input::get('CutWidth'):$CutWidth;
        $CutHeight = (empty($CutHeight))?Input::get('CutHeight'):$CutHeight;
        $PicWidth = (empty($PicWidth))?Input::get('PicWidth'):$PicWidth;
        $PicHeight = (empty($PicHeight))?Input::get('PicHeight'):$PicHeight;
        $doReturnFlag = (empty($base64)) ? true : false;
        
        if($x1 == null || $y1 == null)
        {
            return 0;
        }

        //图片名称
        $fileNewName = date("YmdHis") . '_' . microtime() . '_' . UploadsController::createRandomCode(8) . ".jpg";

        //先用这种方法，用来覆盖之前上传的图片
        // $fileNewName = "photo.jpg";
        $arrFilePath = ImageController::getImagePath("",$fileNewName);
        // echo json_encode($arrFilePath);exit();
        /*等上线后要修改 这个路径是根据个人本地环境测试 绝对路径 start */
      
        /* 绝对路径 end   */
        $webPath= $this->SaveImag($arrFilePath["localPath"],$fileNewName, $base64);            //原始图片地址(绝对地址)

        /* $system32 = php_uname('s');
        if($system32 == 'Linux'){
        $localpath= str_replace("/", "/", getcwd())."/";
        }else{
        $localpath= str_replace("\\", "/", getcwd())."/";
        } */
        //得到原始的图片的宽、高
       
        
        $img = getimagesize($webPath);
        //计算图片类型
        if ($img[2] == '3'){
            $this->type = "png";
        } else if ($img[2] == '1'){
            $this->type = "gif";
        } else if ($img[2] == '2') {
            $this->type = "jpg";
        }
        $weight=$img["0"];////获取图片的宽
        $height=$img["1"];///获取图片的高
        //所有的宽=现有值*（原始图片宽/div宽）
        //所有的高=现有值*（原始图片高/div高）
        if($PicWidth<342 && $PicHeight<408)//四周都有空隙的小图
        {
            $newPointX=$x1;
            $newPointY=$y1;
            $newCutWidth=$CutWidth;
            $newCutHeight=$CutHeight;
        }
        else{//比较宽的图片
            $newPointX=$x1*($weight/$PicWidth);
            $newPointY=$y1*($height/$PicHeight);
            $newCutWidth=$CutWidth*($weight/$PicWidth);
            $newCutHeight=$CutHeight*($height/$PicHeight);
        }
        //return "weight=$weight,height=$height";
        $jpgname="1_".date("YmdHis").'_'.floor(microtime() * 1000).'_'.  UploadsController::createRandomCode(8).'.jpg';
        // $jpgname="photo.jpg";
        $newfilename= $arrFilePath["filePath"].$jpgname;
        //return $webPath."----newfilename-----".$newfilename;
        $this->cut($arrFilePath,$newfilename,$newPointX,$newPointY,$newCutWidth,$newCutHeight,$userid);
        
        if ($doReturnFlag){
            return true;
        }
    }

    /**
     * 按照区域剪切头像，并且生成新的头像
     * @param type $img
     * @param type $jpgname
     * @param type $dstpath
     * @param type $x
     * @param type $y
     * @param type $width
     * @param type $height
     * @param type $userid
     */
    function cut($arrFilePath,$dstpath, $x, $y, $width, $height,$userid) {  
        $this->srcimg = $arrFilePath['localPath'];
        $this->initi_img();

        //目标图象地址
        $this->dst_img($dstpath);
        $final_width = 120;
        $final_height = 160; //round($final_width * $height / $width);  
        $newimg = imagecreatetruecolor($final_width, $final_height);
        imagecopyresampled($newimg, $this->im, 0, 0, $x, $y, $final_width, $final_height, $width, $height);        
        ImageJpeg($newimg, $this->dstimg);
        $jpgname = $this->ImgUpload->saveFromFile('userPhoto', $this->dstimg);
        try {
            //删除原图片
            ImgUtil::delImg($arrFilePath['webPath']);
            if(file_exists($arrFilePath['webPath'])){
                unlink($arrFilePath['webPath']);
            }
            // ImgUtil::delImg($arrFilePath['localPath']);
            //             unlink($img);
        } catch (Exception $e) {
            
        }
        UploadsController::UpdateUserPhoto( $jpgname);        
    }

    //初始化图象
    function initi_img() {
        if ($this->type == "jpg") {
            $this->im = imagecreatefromjpeg($this->srcimg);
        }
        if ($this->type == "gif") {
            $this->im = imagecreatefromgif($this->srcimg);
        }
        if ($this->type == "png") {
            $this->im = imagecreatefrompng($this->srcimg);
        }
    }

    //图象目标地址
    function dst_img($dstpath) {
        $full_length = strlen($this->srcimg);
        $type_length = strlen($this->type);
        $name_length = $full_length - $type_length;
        $name = substr($this->srcimg, 0, $name_length - 1);
        $this->dstimg = $dstpath;
    }

    /**
     * 修改用户头像
     * @param type $id
     * @param type $photo
     */
    public function UpdateUserPhoto($photo) {
        $Dao = new MyInfoDao();
        $user = Auth::user();
        if($user->type == 2){
            $tbName = 'brokers';
        }else if($user->type == 1){
            $tbName = 'customers';
        }else if($user->type == 3){
            $tbName = 'enterprises';
        }
        $info['photo'] = $photo;
        $Dao->upInfo($tbName, $info, $user->id);
    }

    public function SaveImag($pathDir, $fileNewName, $base64 = '') {
        
        $webPath = str_replace(DIRECTORY_SEPARATOR, '/', $pathDir);  
		if (empty($base64)) {
            $base64 = explode(',', Input::get('imgdata'));
		}
        $img = base64_decode($base64[count($base64) - 1]);
        $newName = $pathDir;
        file_put_contents($newName, $img);
        ImageController::resizeImage($newName);
        return $webPath;
    }

    function createRandomCode($length) {
        $randomCode = "";
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $randomChars { mt_rand(0, 35) };
        }
        return $randomCode;
    }

    /**
    * 上传专业用户身份证、工牌、名片
    * @since 1.0
    * @author lixiyu
    * @param int $userid
    * @param string $tbName 保存的表名
    * @param string $field 字段
    * @param string $base64 图片文件
    */
    public function cardUpload( $userid, $tbName, $field, $base64=''){
        //图片名称
        $fileNewName = date("YmdHis") . '_' . microtime() . '_' . UploadsController::createRandomCode(8) . ".jpg";
        $arrFilePath = ImageController::getImagePath("",$fileNewName);
        $webPath = $this->SaveImag($arrFilePath["localPath"],$fileNewName, $base64);   // 先将64位图片数据保存到本地
        $filePath = $this->ImgUpload->saveFromFile('userIdCard', $webPath);    // 图片最终保存路径
        return $filePath;
    }
}
