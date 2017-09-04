<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Index\IndexController;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use DB;
use Input;
use Cache;
use Session;
use Redirect;
//use App\Http\Controllers\Utils\PermUtil;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use function app;
use function bcrypt;
define('FAILED',0);
define('SUCCESS',1);
//define('FORBIDDEN',2);
define('FORBIDDEN',3);
define('WRONG_GROUP',2);
define('REGISTER_CACHE_TIME', 30);

class AuthController extends Controller {
//    use AuthenticatesAndRegistersUsers,
//        ThrottlesLogins;
    protected $username;
    protected $redirectPath = '/';
    protected $loginPath = '/auth/login';

    /**
     * Create a new authentication controller instance.
     * @return void
     */
    public function __construct() {
        // 下面这行代码原先是开启的   暂时屏蔽
        //$this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     *登录
     */
    public function login(){
        return view('auth.login');
    }
    /*
     * 注册
     */
    public function register(){
        return view('auth.register');
    }
    /**
     * Handle a registration request for the application.
     * @param  Request  $request
     * @return Response
     */
    public function postRegister(Request $request) {
        // 此处增加了一些  判断验证码是否准确
//        $mobile = Input::get('mobile','');
//        $username = Input::get('userName','');
//        $reg_name   = '/^[\x41-\x5a\x61-\x7a]([a-zA-z0-9_]){5,20}$/';
//        if(!preg_match($reg_name,$username)) return 6;
//        $userNameKey = strtolower($username);
//        $code = Input::get('password','');
//        if(empty($mobile)){
//            return 4;   //  手机号为空
//        }
//        $codeCache = Cache::get($mobile);
//        if($codeCache != $code || empty($code)){
//            return 5;   //   验证码错误
//        }
//        Cache::forget($mobile);  // 忘记此验证码
        //if( Cache::store('redis')->has('register_name'.$userNameKey) || Cache::store('redis')->has('register_mobile'.$mobile) ){
//        if( Cache::store('redis')->has('register_mobile'.$mobile) ){
//            return 7;
//        }else{
//            $validator = $this->validator($request->all());
//            $checkRepeat = json_decode(json_encode($validator->messages()), true);
//            if(!empty($checkRepeat)){
//                return 7;  // 用户名或手机号重复
//            }
//        }
//        if($validator->fails()) {
//            $this->throwValidationException(
//                    $request, $validator
//            );
//        }
        $r = $this->create($request->all());
        return $r;
    }
    
    
    /**
     * 重写登陆函数，返回 2为被禁用户，返回1为成功，返回0为失败。
     * @return int
     */
    public function postLogin(){
        $userName  = Input::get('userName');
        $password = md5(Input::get('password'));
        $type = $this->checkUserNameType($userName);
        //如果是经纪人或者分销商的话，开始登陆流程。 至少查了一次库 返回一个用户信息对象
        $user = $this->checkIfProUser($type,$userName);

        if(boolval($user)){
            //进行登陆
            return $this->checkLogin($type,$userName,$password,$user);
        }else{
            //专业用户验证失败失败 证明用户组别不正确
            return (int)WRONG_GROUP;
        }
        //return $this->checkLogin($type,$userName,$password);
    }

    /**
     * 检查是否普通用户  如果不是返回false  如果成功 返回一个用户对象
     * @param $type
     * @param $userName
     * @return bool | obj
     */
    public function checkIfProUser($type,$userName){
        //用户可能通过三种 方式登录，因此需要检查用户名的字段是个变量
        $user     = DB::connection('mysql_user')->table('users')->where($type,$userName)->get();
        if(empty($user) || (!isset($user))) return false;
        return $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     * @author niewu
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                   // 'userName' => 'required|unique:users|between:5,21',
                    'mobile' => 'required|unique:users',
                    'email' => 'email|max:255|unique:users',
                    // 'password' => 'required|between:31,33',
                        //'regpwd'=>'required|confirmed',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     * @param  array  $data
     * @return User
     * @author niewu
     */
    protected function create(array $data) {

        $user = User::create([
            //'userName' => $data['userName'],
            'password' => bcrypt(md5($data['password'])),
            'mobile'   => $data['mobile']
        ]);
        Auth::logout();
        Auth::loginUsingID($user->id);
        return ['code'=>1,'msg'=>'注册成功'];
    }
    /**
     * 录入房源信息时自动注册
     * @param  $mobile    用户手机号
     * @param
     * @author zhuwei
     * @date   2016年2月19日  13:00:25
     */
    public function autoRegister($mobile) {

        $user = User::create([
            'mobile' => $mobile,
            'type'     => 1,
            'rId'      => 7,
        ]);
        Auth::logout();
        Auth::loginUsingID($user->id);
        PermUtil::pushUserPerm(); //给用户注入权限数据
        // 记录用户上次登陆
        \App\Http\Controllers\Auth\LoginRecordController :: recordLogin();
        $MyInfo = new \App\Dao\User\MyInfoDao();
        $MyInfo->addInfo('customers',['id'=>$user->id,'mobile'=>$mobile,'gender'=>1]);
        self::insertRefreshUserSetting($user->id);  //用户刷新、发布量配置表
        //$msg = '【搜房网】尊敬的用户，感谢您成功注册搜房网，您的密码是【'.$data['password'].'】，您还可以下载手机搜房网，安装后可通过手机上传认证，刷新房源，下载点击 m.sofang.com,如需帮助拨打客服热线400-6090-798';
        return true;
    }
    /**
     * 自动登陆
     * @param  $id  用户id
     * @author zhuwei
     * @date   2016年2月19日  13:12:25
     */
    public function autoLogin($id){
        Auth::logout();
        Auth::loginUsingID($id);
        PermUtil::pushUserPerm(); //给用户注入权限数据
        // 记录用户上次登陆
        \App\Http\Controllers\Auth\LoginRecordController :: recordLogin();
        return true;
    }
    /**
     * 仅适用手机号快速注册登录(普通用户)
     * @param	int		$mobile		手机号
     * @param	int		$captcha	手机验证码
     */
    public static function postRegisterQuickMobile($mobile='', $captcha=''){
    	$mobile = (!empty($mobile)) ? $mobile : Input::get('mobile');
    	$captcha = (!empty($captcha)) ? $captcha : Input::get('capthca');
    	if(empty($mobile) || empty($captcha)){
    		return ['result'=>false, 'message'=>'请填写手机号或验证码'];
    	}
    	/* 检查验证码 */
    	$check_captcha = Cache::get($mobile);
    	if($check_captcha != $captcha || empty($captcha)){
    		return ['result'=>false, 'message'=>'验证码不正确'];
    	}
    	/* 注册 */
        Cache::forget($mobile);  // 忘记此验证码
    	$LoginDao = new \App\Dao\User\LoginDao();
    	$userObj = $LoginDao->getUserByMobile($mobile);
    	if($userObj){			//被注册过，直接登录
    		if($userObj->type == 1){		//是普通用户
    			Auth::logout();
    			Auth::loginUsingID($userObj->id);
    			PermUtil::pushUserPerm(); //给用户注入权限数据
                /* 修改登录时间 */
                $index = new IndexController();
                $index->updateUserLoginTime(Auth::user()->id);
    			// 记录用户上次登陆
    			\App\Http\Controllers\Auth\LoginRecordController :: recordLogin();
    		}else{							//不是普通用户
    			return ['result'=>false, 'message'=>'您的手机号已经注册为经纪人，请更换手机号'];
    		}
    	}else{	//没被注册过，进行快速注册
    		$user = User::create([
    				'mobile' => $mobile,
    				'type'     => 1,
    				'rId'      => 7,
    		]);
    		Auth::logout();
    		Auth::loginUsingID($user->id);
            /* 修改登录时间 */
            $index = new IndexController();
            $index->updateUserLoginTime($user->id);
    		PermUtil::pushUserPerm(); //给用户注入权限数据
    		// 记录用户上次登陆
    		\App\Http\Controllers\Auth\LoginRecordController :: recordLogin();
//     		if($user->type == 1){
    			$MyInfo = new \App\Dao\User\MyInfoDao();
    			$MyInfo->addInfo('customers',['id'=>$user->id, 'mobile'=>$mobile, 'gender'=>1]);
//     		}
            self::insertRefreshUserSetting($user->id);  //用户刷新、发布量配置表
    	}
    	return ['result'=>true];
    }

    /**
     * ajax 检测密码 - 重写
     * @author huzhaer
     */
    public function checkOldPasswd(){
        $oldpass = md5(Input::get('pwd'));
        if(Auth::check()){
            if(!empty(Auth::user()->userName)){
                if(Auth::attempt(array('userName' => Auth::user()->userName, 'password' => $oldpass))){
                    return SUCCESS;
                }
            }else{
                if(Auth::attempt(array('mobile' => Auth::user()->mobile, 'password' => $oldpass))){
                    return SUCCESS;
                }
            }
        }
        return FAILED;
    }

    public function updatePasswd(){
        if(Auth::check()){
            $uid    = Auth::user()->id;
            $newpass = bcrypt(md5(Input::get('pwd')));
            if(DB::table('users')->where('id',$uid)->update(['password'=>$newpass])){
                return SUCCESS;
            }
        }
        return FAILED;
    }

    /**
     *  注册时，用户刷新、发布量配置表
     * @param  $uid  用户id
     */
    public static function insertRefreshUserSetting($uid){
        $marketingConfig = config('marketingConfig');
        $getUserRefreshConfig = DB::connection('mysql_user')->table('refreshusersetting_operation')->where('uid',$uid)->first();
        if(empty($getUserRefreshConfig)){
            $insert = array('uid'=>$uid,'dayPublishSaleCount'=>$marketingConfig['beforeBuy']['dayPublishSaleCount'],'dayPublishRentCount'=>$marketingConfig['beforeBuy']['dayPublishRentCount'],'dayPublishBusinessCount'=>$marketingConfig['beforeBuy']['dayPublishBusinessCount'],'canPublishCount'=>$marketingConfig['beforeBuy']['canPublishCount'], 'dayRefreshManualCount'=>$marketingConfig['beforeBuy']['dayRefreshManualCount']);
            //不存在该用户就添加
            DB::connection('mysql_user')->table('refreshusersetting_operation')->insert($insert);
        }
    }

//============== 工具函数 =============================
    /**
     * 检查用户输入的用户名字段 返回想用输入的用户名类型
     * @param $userName
     * @return string
     * @author huzhaer
     */
    public function checkUserNameType($userName){
        $type = '';
        $reg_phone  = '/^((\(\d{2,3}\))|(\d{3}\-))?1\d{10}$/';
        $reg_email  = '/^(\w|\d)+([-+.](\w|\d)+)*@(\w|\d)+([-.](\w|\d)+)*\.\w+([-.]\w+)*/';
        $reg_name   = '/^[a-zA-Z0-9_]{3,30}/';
        //返回type 1是手机 2是邮箱 3是用户名
        if(preg_match($reg_email,$userName)) $type = 'email';
        elseif(preg_match($reg_phone,$userName)) $type = 'mobile';
//         elseif(preg_match($reg_name ,$userName)) $type = 'userName';
		else $type = 'userName';
        if(empty($type) || (!isset($type))) return false;
        return $type;
    }
    /**
     * 检查是否可以登录函数   可以返回2 不行返回1
     * @param $type
     * @param $userName
     * @param $password
     * @return int
     * @author huzhaer
     */
    private function checkLogin($type,$userName,$password){
        $res = DB::table('users')->where($type,$userName)->get();
        if(empty($res) || (!isset($res))) return FAILED;
        if (Auth::attempt(array($type => $userName, 'password' => $password)) ){
            return SUCCESS;
        } else {
            return FAILED;
        }
    }
    /**
     * 检查用户是否被禁  禁返false 只能跟着checkLogin函数使用
     * @param $data
     * @return bool
     * @author huzhaer
     */
    private function checkIfUserBanned($data){
        //用户的state字段，0为禁止 1为开始
        if($data[0]->state) return true;
        return false;
    }

    /**
     *  通过手机号快速注册后，普通用户 修改密码和用户名
     */
    public function userSetPwd(){
        if(!Auth::check()) return FAILED;
        //$info['userName'] = Input::get('uname');
        $info['password'] = bcrypt(md5(Input::get('pwd')));
        $info['rId'] = 8;  // 设置密码后  角色rId为8 是普通用户
        if(DB::table('users')->where('id',Auth::user()->id)->update($info)){
            return SUCCESS;
        }
        return FAILED;
    }
}



/**
 * Handle a login request to the application.
 * @param  Request  $request
 * @return Response
 */
//    public function postLogin() {
//        $userName = Input::get('userName');
//        $password = md5(Input::get('password'));
//
//        $type = $this->
//        if (is_numeric($userName)) {
//            $type = 'mobile';
//            return $this->isName($type, $userName, $password);
//        } else if (strstr($userName, '@')) {
//            $type = 'email';
//            return $this->isName($type, $userName, $password);
//        } else {
//            $type = 'userName';
//            return $this->isName($type, $userName, $password);
//        }
//    }