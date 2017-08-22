<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use Input;
use Cache;
use Session;
use Redirect;
use App\Http\Controllers\Utils\PermUtil;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Services\String;
use Validator;
use App\Http\Controllers\Auth\AuthController ;
use function app;
use function bcrypt;
class H5AuthController extends Controller {
	function __construct(){
		
	}
	
	/**
	 * 登陆页面
	 */
	public function login(){
		if(Auth::check()){
			return redirect('/');
		}
		return view('h5.login.login');
	}
	
	/**
	 * 注册页面
	 */
	public function register(){
		if(Auth::check()){
			return redirect('/');
		}
		return view('h5.login.register');
	}

	/**
	 *找回密码
	 */
	public function recoverPass(){
		if(Auth::check()){
			return redirect('/');
		}
		return view('h5.login.missPsw');
	}
	/**
	 *找回密码
	 */
	public function postPass(){
		$mobile = Input::get('mobile','');
		$capthca = Input::get('capthca');
		$pass = Input::get('password');
		$repass = Input::get('repassword');
		$codeCache = Cache::get($mobile);
		if($codeCache != $capthca || empty($capthca)){
			return 1;
		}
		$length = strlen($pass);
		if($length<6 || $length>16){
			return 2;
		}
		if($pass != $repass){
			return 6;
		}
        $user = DB::connection('mysql_user')
        		->table('users')
        		->where('mobile',$mobile)
        		->first();
       	if(empty($user)){
       		return 4;
       	}elseif($user->type!=1){
       		return 5;
       	}
        $password = bcrypt(md5($pass));
		$question = DB::connection('mysql_user')
					->table('users')
					->where('mobile',$mobile)
					->update(['password'=>$password]);
		return 3;
	}
	/**
	 *搜房用户协议
	 */
	public function userAgreement(){
		return view('h5.login.agreement');
	}
	/**
	 *房贷计算器
	 */
	public function calculation(){
		return view('h5.login.houselator');
	}
	/**
	 * 提交注册
	 */
	public function postRegister(){
		$userName = Input::get('userName');
		$password = Input::get('password');
		if(empty($userName)){
			return response()->json(['result'=>false, 'message'=>'用户名不能为空']);
		}elseif(empty($password)){
			return response()->json(['result'=>false, 'message'=>'密码不能为空']);
		}
		$AuthObj = new AuthController();
		$userNameType = $AuthObj->checkUserNameType($userName);
	}
}