<?php
namespace App\Http\Controllers\Perm;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\Dao\Perm\PermDao;
use App\Http\Controllers\Utils\PermUtil;
/**
 * 角色权限类
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年11月11日 下午4:59:55
 * @version 1.0
 */
class PermController extends Controller{
	
	public $PermDao;
	
	public function __construct() {
		$this->PermDao = new PermDao();
	}
	/**
	 * 重置权限数据到缓存
	 */
	public function resetPerm(){
		$allPerm = $this->PermDao->allPerm();
    	PermUtil::pushUserPerm();
    	return $allPerm;
	}

	
	
	/**
	 * 验证当前角色是否有权限显示对应字段
	 * @param	int	$pfId	权限字段id
	 * @return	bool	是否拥有显示该字段权限
	 */
	/* public function authPermField($pfId){
		$rId = Session::get('rId');
		if(is_null($rId)){
			return false;
		}
		if(Cache::has('allPermFieldByRid')){
			$allPermFieldByRid = Cache::get('allPermFieldByRid');
		}else{
			$this->resetPerm();
			$allPermFieldByRid = Cache::get('allPermFieldByRid');
		}
		if(in_array($pfId, $allPermFieldByRid[$rId])){
			return true;
		}else{
			return false;
		}
	} */
	
	/**
	 * 拥有的权限列表
	 */
	/* public function hasPerm(){
		$rId = Session::get('rId');
		if($rId > 0){
// 			$userPerm = $this->PermDao->hasPerm($rId);
			if(Cache::has('allPerm')){
				$allPerm = Cache::get('allPerm');
			}else{
				$allPerm = $this->allPerm();
			}
			if(isset($allPerm[$rId]) && !empty($allPerm[$rId])){
				$data = $allPerm[$rId];
			}else{
				//没有权限数据
			}
		}
	} */
}
