<?php
namespace App\Http\Controllers\Agent;

use Auth;
use DB;
use App\Dao\Agent\NewBuildingCreateDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\AreaUtil;
use App\Http\Controllers\User\UploadsController;
use App\Http\Controllers\Utils\UploadImgUtil;

/**
* description of BuildEditController
* @author lixiyu
* @since 1.0
*/
class BuildEditController extends Controller{

    protected $NewBuildingCreateDao;

    public function __construct(){
    	$this->NewBuildingCreateDao = new NewBuildingCreateDao;
    }
	/**
	* 修改楼盘相册
	* @author lixiyu
	*/
	public function editImage(){
		$status = 0; //审核状态  0、未审核  1、审核进行中   2、审核通过  3、审核未通过 
		
		$userId = 12; //用户id 
		$communityId = Input::get('communityId', '36');
		
		//获取地址栏传递 物业类型 参数
		$pagetype = Input::get('type', '');
		
		//从数据库获取存在的 物业类型
		$type = $this->NewBuildingCreateDao->getCommunityType($communityId);
		
		//物业 主类型
		$type['type1'] = explode('|', $type[0]->type1);
		//物业 副类型
		$type['type2'] = explode('|', $type[0]->type2);
		// dd($type);
		$data = array();
		foreach($type['type1'] as $key => $val){
			foreach($type['type2'] as $key2 => $val2){
				$tmp = config('communityType.'. ($val - 1) .'.'. $val2);
				if($tmp){
					$data[$val][$val2] = $tmp;
				}
			}
		}
		
	
		if(!in_array($pagetype, $type['type2'])){
			$pagetype = array();
			$pagetype[1] = $val;
			$pagetype[2] = $val2;
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

		
		unset($type);
		// dd($data);


		//判断是否有上传的图片
		$info = $this->NewBuildingCreateDao->getCommunityImg( $userId, $communityId, $pagetype[2]);
		if(!empty($info)){
			$imageInfo = [];
			foreach($info as $key => $val){
				$imageInfo[config('imageType.num2type.'.$val->type)][] = $val;
			}
			unset($info);
		}else{
			$imageInfo = '';
		}
		// dd($imageInfo);


		return view('agent.editImage',['title'=>'楼盘相册', 'data'=>$data ,'hosturl'=>'/buildeditimageshow', 'pagetype'=>$pagetype, 'info'=>$imageInfo, 'status'=>$status ]);
	}


}