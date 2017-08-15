<?php
namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Routing\Controller;
use App\Http\Controllers\Utils\ImgUtil;

class ImageController extends Controller{
    
	/*
     * 上传图片
     * 当通过函数传参时使用传入参数，当没有传参时调用表单Post进来的数据
     * $uid_call:用户id
     * $type_call:图片所在房源类型。rent.出租房源 sale.出售房源
     * $base64_call:base64编码化的图片文件字符串
     * $clientName_call:传入的图片原有文件名
     */
    public static function saveImag($uid_call = '', $type_call = '', $base64_call = '', $clientName_call = '')
    {
        if ($uid_call == '' || $type_call == '' || $base64_call == '' || $clientName_call == '') {
            $uid = Auth::id();
            $type = Input::get('type', 'sale');
            $base64 = Input::get('data');
            $clientName = Input::get('name');
        } else {
            $uid = $uid_call;
            $type = $type_call;
            $base64 = $base64_call;
            $clientName = $clientName_call;
        }
        $system_image_path = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'images';		//系统图片保存路径
        $base64 = explode(',', $base64);
        $base64 = $base64[count($base64) - 1];
        $img = base64_decode($base64);
        
        // $newName=$pathDir.$fileNewName;
        // $webPath.=$fileNewName;
        $arrFilePath = ImageController::getImagePath($type, $clientName);
        file_put_contents($arrFilePath['localPath'], $img);
//         dd($arrFilePath['localPath']);
        self::resizeImage($arrFilePath['localPath']);	//图片若超过预设宽高，进行等比压缩
        if(in_array($type, array('rent', 'sale'))){
        	$img = self::setWatermark($arrFilePath['localPath'], $system_image_path.DIRECTORY_SEPARATOR.'watermark.png');
        	if(config('imgConfig.enableFastdfs')){				//分布式上传图片
        		$file_info = fastdfs_storage_upload_by_filename($arrFilePath['localPath']);
        		unlink($arrFilePath['localPath']);					//删除临时图片
        		if(!empty($file_info) && !empty($file_info['group_name']) && !empty($file_info['filename'])){
        			$arrFilePath['webPath'] = '/'.$file_info['group_name'].'/'.$file_info['filename'];
        		}
        	}
        }
        if ($uid_call == '' || $type_call == '' || $base64_call == '' || $clientName_call == '') {
            return Response::json([
                'success' => 'true',
                'url' => ImgUtil::getImgUrl($arrFilePath['webPath'])
            ]);
        } else {
            return array(
                'success' => true,
                'url' => ImgUtil::getImgUrl($arrFilePath['webPath']),
                'filePath' => $arrFilePath['webPath']
            );
        }
    }
    /* 图片添加水印
     * $dst_path:原图
     * $src_path:水印 */
    /**
     +------------------------------------------------------------------------------
     *                图片添加水印
     +------------------------------------------------------------------------------
     * @param String	$dst_path 源图片名        比如 “source.jpg”
     * @param String	$src_path 水印图片名
     * @author Lee     <284317997@qq.com>
     * @version 1.0
     +------------------------------------------------------------------------------
     */
    public static function setWatermark($dst_path, $src_path){
    	//创建图片的实例
    	$dst = imagecreatefromstring(file_get_contents($dst_path));
    	$src = imagecreatefromstring(file_get_contents($src_path));
    	//获取水印图片的宽高
    	list($src_w, $src_h) = getimagesize($src_path);
    	//获取原图片的宽高
    	list($dst_w, $dst_h) = getimagesize($dst_path);
    	//将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
    	// 		imagecopymerge($dst, $src, $dst_w-$src_w, $dst_h-$src_h, 0, 0, $src_w, $src_h, 10);
    	//如果水印图片本身带透明色，则使用imagecopy方法
    	// 		imagecopy($dst, $src, $dst_w-$src_w, $dst_h-$src_h, 0, 0, $src_w, $src_h);		//右下
    	// 		imagecopy($dst, $src, 0, $dst_h-$src_h, 0, 0, $src_w, $src_h);		//左下
    	// 		imagecopy($dst, $src, $dst_w-$src_w, 0, 0, 0, $src_w, $src_h);		//右上
    	imagecopy($dst, $src, 0, 0, 0, 0, $src_w, $src_h);		//左上
    	//输出图片
    	list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
    	switch ($dst_type) {
    		case 1://GIF
    			header('Content-Type: image/gif');
    			imagegif($dst, $dst_path);
    			break;
    		case 2://JPG
    			header('Content-Type: image/jpeg');
    			imagejpeg($dst, $dst_path);
    			break;
    		case 3://PNG
    			header('Content-Type: image/png');
    			imagepng($dst, $dst_path);
    			break;
    		default:
    			break;
    	}
    	imagedestroy($dst);
    	imagedestroy($src);
    }

    public function getImg()
    {
        $uid = Auth::id();
        $type = Input::get('type');
        $houseId = Input::get('houseId');
        $saleRentObj = '';
        if ($type == 'sale') {
            $saleRentObj = new Housesaleimage();
        } elseif ($type == 'rent') {
			$saleRentObj = new Houserentimage();
		}
        if ($saleRentObj == '') {
            return Response::json([
                'success' => 'false',
                'msg' => '信息有误'
            ]);
        }
        $resultObj = $saleRentObj::where('houseId', $houseId)->where('uid', $uid)
            ->select('fileName', 'note')
            ->get();
        foreach ($resultObj as $item) {
            $item->fileName = ImgUtil::getImgUrl($item->fileName);
        }
        return Response::json([
            'success' => 'true',
            'data' => $resultObj
        ]);
    }

    public static function getImagePath($type, $clientName)
    {
    	/*等上线后要修改 这个路径是根据个人本地环境测试 绝对路径 start */
    	$absPath = DIRECTORY_SEPARATOR."img";
    	$relPath = str_replace( DIRECTORY_SEPARATOR, '/', $absPath);
    	/* 绝对路径 end   */

        // $basePath="d:\\sofang";
        // $basePath = config('imgConfig.imgSavePath');
        $relativePath = DIRECTORY_SEPARATOR."temp";  // 生成一个 temp 的临时文件夹
        // if ($type == 'rent') {
        // 	$relativePath.=DIRECTORY_SEPARATOR."rent";
        // } elseif ($type == 'sale') {
        //     $relativePath.=DIRECTORY_SEPARATOR."sale";
        // } elseif ($type == 'photo') {
        //     $relativePath.=DIRECTORY_SEPARATOR."photo";
        // } elseif ($type == 'community') {
        //     $relativePath.=DIRECTORY_SEPARATOR."community";
        // } elseif ($type == 'card') {
        //     $relativePath.=DIRECTORY_SEPARATOR."card";
        // } else {
        //     $relativePath.="";
        // }
        $yearPath = date('Y', time());
        $monthPath = date('m', time());
        $strDay = date('d', time());
        // return $strDay;
        // $dayPath=intval($strDay)%10;
        $dayPath = $strDay;
        // $relativePath = $relativePath . DIRECTORY_SEPARATOR . $yearPath . DIRECTORY_SEPARATOR . $monthPath . DIRECTORY_SEPARATOR . $dayPath;
        $filePath = $absPath. $relativePath . DIRECTORY_SEPARATOR;
        // echo json_encode($filePath);exit();
        ImageController::createFolder($filePath);
        $fileNewName = md5(date('ymdhis') . $clientName) . "." . substr(strrchr($clientName, '.'), 1);
        // $fileNewName = $clientName . "." . substr(strrchr($clientName, '.'), 1);
        // echo $fileNewName;exit();
        return array(
            'localPath' => $filePath . $fileNewName,
            'filePath' => $filePath,
            'webFilePath' => $relPath.str_replace(DIRECTORY_SEPARATOR, '/', $relativePath) . '/',
            'webPath' => $relPath.str_replace(DIRECTORY_SEPARATOR, '/', $relativePath) . '/' . $fileNewName
        );
    }

    public static function createFolder($path)
    {
        if (! file_exists($path)) {
            ImageController::createFolder(dirname($path));
            mkdir($path, 0777);
        }
    }

    public function saveCommImage()
    {
        $path = 'd:\\image\\';
        $total = CommunityImage::whereNull('localFile')->orderBy('id','asc')->count();
        while ($total > 0){
            $images = CommunityImage::whereNull('localFile')->take(2)->orderBy('id','asc')->get();
            $count = 0;
            foreach ($images as $key => $value){
                $file_name = sprintf("%03d", $value->id%100);
                $file_name = $path.$file_name;
                $curl = curl_init($value->fileName);
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                $imageData = curl_exec($curl);
                if (!curl_errno($curl) && $imageData != '404 Not Found'){
                    if (!is_dir($file_name)){
                        mkdir($file_name);
                    }
                    $img_path = $file_name.'\\'.$value->id.'.jpg';
                    file_put_contents($img_path, $imageData);
                    $count = $count++;
                    $value->localFile = $img_path;
                    $value->save();
                } else {
                    $value->localFile = ' ';
                    $value->save();
                    echo "下载失败,路径无效.图片id:".$value->id.'<br />';
                    ob_flush();
                    flush();
                }
                curl_close($curl);
            }
            $total = CommunityImage::whereNull('localFile')->orderBy('id','asc')->count();
            echo '成功下载'.$count.'张图片<br />';
            echo '程序休眠2秒...<br />';
            sleep(2);
        }
    }
    
    /**
     +------------------------------------------------------------------------------
     *                等比例压缩图片
     +------------------------------------------------------------------------------
     * @param String $src_imagename 源文件名        比如 “source.jpg”
     * @param int    $maxwidth      压缩后最大宽度
     * @param int    $maxheight     压缩后最大高度
     * @param String $savename      保存的文件名    “d:save”
     * @param String $filetype      保存文件的格式 比如 ”.jpg“
     * @author Yovae     <yovae@qq.com>
     * @version 1.0
     +------------------------------------------------------------------------------
     */
    public static function resizeImage($src_imagename, $maxwidth = 400, $maxheight = 400, $savename = '', $filetype = '') {
        // 根据不同的图片mime类型 来调用不同的方法
        $createImg = array('2'=>'imagecreatefromjpeg', '3'=>'imagecreatefrompng');
        $saveImg   = array('2'=>'imagejpeg', '3'=>'imagepng');
        $imageInfo = getimagesize($src_imagename);  // 获取图片信息 
        //动态调用GD库创建新图像函数 
        
        $im = $createImg[$imageInfo[2]]( $src_imagename );
		$current_width = imagesx ( $im ); // 源图片宽度
		$current_height = imagesy ( $im ); // 源图片高度
		if (empty ( $savename ) && empty ( $filetype )) {
			$savename = $src_imagename;
		} else {
			$savename = $savename . $filetype;
		}
		if (($maxwidth && $current_width > $maxwidth) || ($maxheight && $current_height > $maxheight)) {
	    	$resizewidth_tag = false;
	    	$resizeheight_tag = false;
			if ($maxwidth && $current_width > $maxwidth) {
				$widthratio = $maxwidth / $current_width;		//宽度比例
				$resizewidth_tag = true;
			}
			
			if ($maxheight && $current_height > $maxheight) {
				$heightratio = $maxheight / $current_height;	//高度比例
				$resizeheight_tag = true;
			}
			//$ratio采用比例
			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio)
					$ratio = $widthratio;		
				else
					$ratio = $heightratio;
			}
			
			if ($resizewidth_tag && ! $resizeheight_tag)
				$ratio = $widthratio;
			if ($resizeheight_tag && ! $resizewidth_tag)
				$ratio = $heightratio;
			
			$newwidth = $current_width * $ratio;
			$newheight = $current_height * $ratio;
			
			if (function_exists ( "imagecopyresampled" )) {
				$newim = imagecreatetruecolor ( $newwidth, $newheight );
				imagecopyresampled ( $newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height );
			} else {
				$newim = imagecreate ( $newwidth, $newheight );
				imagecopyresized ( $newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $current_width, $current_height );
			}
			imagejpeg( $newim, $savename, 50 );
			imagedestroy ( $newim );
		} else {
			if ($src_imagename != $savename) {
				imagejpeg( $im, $savename, 50 );
			}
		}
	}
}
