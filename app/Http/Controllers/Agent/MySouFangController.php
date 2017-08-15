<?php
namespace App\Http\Controllers\Agent;

use Auth;
use Illuminate\Routing\Controller;
use App\Dao\Agent\MySouFangDao;
use App\Dao\User\MyInfoDao;
use Input;
use Hash;
use DB;

/**
* Description of MySouFangController
* 经纪人后台 我的搜房
* @author lixiyu
* @since 1.0
*/

class MySouFangController extends Controller{
	protected $MySouFangDao;
	protected $userInfo;

	public function __construct(){
		
		// 判断用户是否登录  并且 用户类型为 经纪人用户
        if( !Auth::check() || Auth::user()->type != 2){
                $this->beforeFilter('UserMyInfoFilter');
        }else{
			$this->MySouFangDao = new MySouFangDao();
        }
		$this->userInfo = Auth::user();
	}

	/**
	* 修改密码
	* @author lixiyu
	*/
	public function passWord(){
		// dd($this->userInfo);
		return view('agent.mysoufang.password');
	}

	/**
	* ajax 验证密码
	*/
	public function matchPassWord(){
		$oldpwd = md5(Input::get('oldPwd'));
		$call = Hash::check($oldpwd, $this->userInfo->password);
		// echo 1;exit;
		if($call) return 1;

		return 0;
	}

	/**
	* ajax 修改密码
	*/
	public function editPassWord(){
		$oldpwd = md5(Input::get('oldPwd'));
		// echo json_encode(Input::get('oldPwd'));exit;
		$call = Hash::check($oldpwd, $this->userInfo->password);
		if(!$call) return 0;

		$newpwd1 = Input::get('newPwd1');
		$newpwd2 = Input::get('newPwd2');

		if($newpwd1 != $newpwd2) return 0;
		
		$user['password'] = bcrypt(md5($newpwd1));
		$id = $this->userInfo->id;
		// echo $user['password'];exit;
		$call = $this->MySouFangDao->upInfo('users', $user, $id);
		// var_dump($id);exit;
		if($call){
			return 1;
		}else{
			return 0;
		}
	}
}
