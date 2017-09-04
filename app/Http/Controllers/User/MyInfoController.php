<?php

namespace App\Http\Controllers\User;

use Auth;
use DB;
use App\Dao\User\MyInfoDao;
use App\Dao\City\CityDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\User\UploadsController;
use App\Http\Controllers\Email\SendEmailController;
use App\Http\Controllers\Utils\UserIdUtil;
use App\Http\Controllers\Auth\AuthController;
use Redirect;
use Hash;
use Session;
/**
* Description of MyInfoController （用户中心）
* @since 1.0
* @author lixiyu
*/
class MyInfoController extends Controller{
        public $usertable;
	protected $MyInfoDao;
	protected $CityDao;
	/**
	* 构造方法 载入DAO 并检测用户是否登录
	*/
	public function __construct() {


        // 判断用户是否登录  并且 用户类型为 普通个人用户
        if( !Auth::check() || Auth::user()->type != 1){
            $this->beforeFilter('UserMyInfoFilter');
        }else{
        	$datebase = new UserIdUtil();
            $id = Auth::user()->id;
            $this->usertable = $datebase->getNodeNum($id);
            
            
            $this->MyInfoDao = new MyInfoDao();
            $this->CityDao = new CityDao();
        }
		// var_dump(Session::getId());
	}


	/**
	* 个人账户首页
	* @since 1.0
	* @author lixiyu
	*/
	public function home(){
		$info = Auth::user();
		$info->mobile = substr( $info->mobile, 0, 3) . '****' . substr( $info->mobile, -4);
		$call = $this->MyInfoDao->getFields('customers', Auth::user()->id, ['photo']);
		if($call){
			$info->photo = $call[0]->photo;
		}
		$score = 40;
		if(!empty($info->email)){
			$score += 30; 
		}
		$secu = $this->MyInfoDao->isExist( 'securityquestionuser', ['uid'=>Auth::id()], ['id']);
		if(!empty($secu)){
			$score += 30;
		}
		$login = $this->MyInfoDao->getLastLogin(Auth::user()->id, [0, 5]);
		// $city = $this->CityDao->selectCity($login->cityId);
		$login_Mode = array('1'=>'用户名', '2'=>'邮箱', '3'=>'手机', '4'=>'QQ', '5'=>'微信');
		$info->title = '账户首页';
		return view('user.myinfo.accountIndex',['info'=>$info, 'index'=>true, 'score'=>$score, 'secu'=>$secu, 'login'=>$login, 'login_Mode'=>$login_Mode ]);
	}

	/**
	 * ajax 获取更多登陆历史信息
	 */
	public function loadLoginHistory(){
		$num = Input::get('num');
		if($num > 1){
			$num = $num * 10 + 5;
		}else{
			$num = 5;
		}
		$login = $this->MyInfoDao->getLastLogin(Auth::user()->id, [$num, 10]);
		if(empty($login)) return 0;
		$login_Mode = array('1'=>'用户名', '2'=>'邮箱', '3'=>'手机', '4'=>'QQ', '5'=>'微信');
		foreach($login as $key => $val){
			$val->cityId 	= \App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($val->cityId);
			$val->loginMode	= $login_Mode[$val->loginMode];
			$login[$key] 	= $val;
		}
		return $login;
	}

	/**
	* 显示个人资料
	* @access public
	* @since 1.0
	* @author lixiyu
        * @edit niewu 分库查询 getcustomers
	*/
	public function infoShow() {

		//获取用户id
		 Auth::user()->id;
		// 通过联查得到 用户信息
        $info = $this->MyInfoDao->getcustomers();
              // dd($info);
		//截取出生日期和手机
		if(empty($info)){
			$info[0] = (object)'';
			$info[0]->birthday = 0;
			$info[0]->photo = '';
			$city = $this->CityDao->selectCity(0);
			$info[0]->gender = 0;
			$info[0]->provinceId  = 0;
			$info[0]->cityId = 0;
			$info[0]->cityAreaId = 0;
			$info[0]->intro = '';
			$cityArea = $this->CityDao->selectCityArea(0);
		}
		else{
			if($info[0]->birthday == 0){
				$info[0]->birthday = 0;
			}else{
				$info[0]->birthday = substr( $info[0]->birthday, 0, 10);
			}
			$city = $this->CityDao->selectCity($info[0]->provinceId);
			$cityArea = $this->CityDao->selectCityArea($info[0]->cityId);
		}
		$info[0]->userName = Auth::user()->userName;
		$info[0]->mobile = substr( Auth::user()->mobile, 0, 3) . '****' . substr( Auth::user()->mobile, -4);
		$province = $this->CityDao->selectProvince();
		$info[0]->title = '编辑资料';
		return view('user.myinfo.infoUpdate', ['info'=>$info, 'province'=>$province, 'city'=>$city, 'cityArea'=>$cityArea, 'infoShow'=>true]);
	}

	/**
	* ajax 修改个人资料
	* @since 1.0
	* @author lixiyu
	*/
	public function infoUp(){
		//获取用户id
		$id = Auth::user()->id;

		$info['gender']     = Input::get('gender');
		$info['birthday']   = Input::get('birthday');
		$info['provinceId'] = Input::get('provinceId');
		$info['cityId']     = Input::get('cityId');
		$info['cityAreaId'] = Input::get('cityAreaId');
		$info['intro']      = Input::get('intro');

		$call = $this->MyInfoDao->upInfo( 'customers', $info, $id);
		if($call){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	* 修改密码页面
	* @access public
	* @since 1.0
	* @author lixiyu
	*/
	public function passwdShow() {
		$detail = $this->MyInfoDao->getcustomers();
		return view('user.myinfo.modifyPwd',['info'=>$detail, 'set'=>true]);
	}

	/**
	* ajax 修改密码
	* @since 1.0
	* @author lixiyu
	*/
	public function passwdUp(){
		$pwd = Input::get('pwd');
		$user['password'] = bcrypt(md5($pwd));
		$id = Auth::user()->id;
		$call = $this->MyInfoDao->upInfo('users', $user, $id);
		if($call){
			return 1;
		}else{
			return 0;
		}
	}
	//修改手机号页面展示
	public function modifyMobile(){

		$detail = $this->MyInfoDao->getcustomers();
		return view('user.myinfo.modifyMobile',['info'=>$detail, 'set'=>true]);
	}
	//输入新手机号
	public function modifyMobile2(){
		$referer = 'http://'.$_SERVER['HTTP_HOST'].'/myinfo/modifyMobile';

		if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $referer){
			$detail = $this->MyInfoDao->getcustomers();
			return view('user.myinfo.modifyMobile2',['info'=>$detail, 'set'=>true]);
		}else{
			// 如果之前来访页面不是邮箱绑定显示页面一，就直接跳转到首页
			return Redirect::to('/');
		}
	}
	/**
	* ajax 验证用户当前手机
	* @access public
	* @since 1.0
	* @author lixiyu
	*/
	public function verifyMobile(){
		$mobile1 = Input::get('mobile1');
		$mobile = Auth::user()->mobile;
		if($mobile == $mobile1){
			return 1;
		}else{
			return 2;
		}
	}

	/**
	* ajax 修改手机号
	* @since 1.0
	* @author lixiyu
	*/
	protected function editMobile() {
		$info['mobile'] = Input::get('mobile');
		//判断此手机号是否存在
		$exist = $this->MyInfoDao->getMobile( $info['mobile'] );
		if( !empty($exist)) {
			return 0;
		}
		$id = Auth::user()->id;
		$call = $this->MyInfoDao->upInfo( 'users', $info, $id);
		$call = $this->MyInfoDao->upInfo( 'customers', $info, $id);
		if($call){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	* ajax 图片上传 并返回修改过后的图片路径
	* @since 1.0
	* @author lixiyu
	*/
	public function imgUpload(){
		$id = Auth::user()->id;
		$filename = $this->MyInfoDao->getFields('customers', $id, ['photo']);

		if(!empty($filename[0]->photo)){
			$filename = DIRECTORY_SEPARATOR."img".$filename[0]->photo;
			if(file_exists($filename)){
				unlink($filename);
			}
		}

		$upload = new UploadsController();    
		$upload->cutparam($id);    
		$info = $this->MyInfoDao->getInfo('customers', $id);
        $photo = config('imgConfig.imgSavePath').$info[0]->photo;
        return json_encode($photo);
	}


	/**
	* ajax 检测密码
	* @since 1.0
	* @author lixiyu
	*/
	public function detePasswd(){
		$pwd1 = md5(Input::get('pwd'));
		$call = Hash::check($pwd1, Auth::user()->password);
		if($call) return 1;
		
		return 0;
	}

	/**
	* 邮箱绑定显示页面一
	* @since 1.0
	* @author lixiyu
	*/
	public function emailShow1(){
		$detail = $this->MyInfoDao->getcustomers();
		return view('user.myinfo.emailBindone',['info'=>$detail, 'set'=>true]);
	}

	/**
	* 邮箱绑定显示页面二
	* @since 1.0
	* @author lixiyu
	*/
	public function emailShow2(){
		$referer = 'http://'.$_SERVER['HTTP_HOST'].'/myinfo/bindemailphone';

		if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $referer){
			$detail = $this->MyInfoDao->getcustomers();
			return view('user.myinfo.emailBindtwo',['info'=>$detail, 'set'=>true]);
		}else{
			// 如果之前来访页面不是邮箱绑定显示页面一，就直接跳转到首页
			return Redirect::to('/');
		}
	}

	/**
	* 邮箱绑定显示页面三
	* @since 1.0
	* @author lixiyu
	*/
	public function emailShow3(){
		$detail = $this->MyInfoDao->getcustomers();
		$info = Auth::user();

		$info->email = substr( $info->email, 0, 3) . '****' . substr( $info->email, -4);
		return view('user.myinfo.emailBindthree',['info'=>$detail, 'email'=>$info->email ,'set'=>true]);
	}

	/**
	* ajax发送邮箱验证码
	* @since 1.0
	* @author lixiyu
	*/
	public function sendEmail(){

		$info['email'] = Input::get('email');
		
		if(Cache::get($info['email'])) return 1;// 返回1，提醒客户邮件已发送，到相关邮箱查看激活码
		
		$user = Auth::user();
		if( $user->email == $info['email']){
			return 2; //返回2，提醒用户这是他的账号里存在的邮箱，并已激活
		}
		
//		$call = $this->MyInfoDao->isExist('users',$info,array('email'));
//		if($call) return 3;//返回3，提醒客户此邮箱已被激活并占用
		
		$test = new SendEmailController();
		$info['code'] = rand(1000, 9999);
		$data = $test->sendCode($info['email'], $info['code']);

		
		if(!$data) return 4; //返回4，提醒用户邮箱发送失败，请稍候再试
		
		$data['id'] = Auth::id(); 
		Cache::put($info['email'], $data, 60);
		unset($data['code']);
		unset($data['id']);
		return json_encode($data);//返回$data，邮箱发送成功并提醒用户登陆邮箱并激活邮箱
	}

	/**
	 * 检测邮箱
	 */
	public function checkEmail(){
		
		$info['email'] = Input::get('email');
		if(!Cache::has($info['email'])){
			return 1; // 返回1，提醒客户该验证码已经过期，请重新发送
		}
		$email = Cache::get($info['email']);
		$vercode1 = Input::get('vercode');
		$vercode2 = $email['code'];
		if($vercode1 != $vercode2){
			return 0; //返回0，验证码不正确
		}else{

			$myinfo = new MyInfoDao();
            $call = $myinfo->upInfo('users', ['email'=>$info['email']], Auth::user()->id);
            Cache::forget($info['email']);
            return 2;
		}
		
		
		
	}
	/**
	* 安全问题显示页面一
	* @since 1.0
	* @author lixiyu
	*/
	public function problem1(){
		//$info = Auth::user();
		$detail = $this->MyInfoDao->getcustomers();
		return view('user.myinfo.problem1',['info'=>$detail, 'set'=>true]);
	}


	/**
	* 安全问题显示页面二
	* @since 1.0
	* @author lixiyu
	*/
	public function problem2(){

		$referer = 'http://'.$_SERVER['HTTP_HOST'].'/myinfo/problem1';

		if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $referer){
			$detail = $this->MyInfoDao->getcustomers();
			$question = $this->MyInfoDao->getAll('securityquestion');
			return view('user.myinfo.problem2',['info'=>$detail, 'set'=>true, 'question'=>$question]);
		}else{
			// 如果之前来访页面不是安全问题显示页面一，就直接跳转到首页
			return Redirect::to('/myinfo/problem1');
		}
	}

	/**
	* ajax 安全问题提交
	* @since 1.0
	* @author lixiyu
	*/
	public function problemSubmit(){
		$pro = Input::get('pro');
		Cache::put('problem'.Auth::id(), $pro, 60);
		return 1;
		
	}

	/**
	* 确认安全问题 页面三
	* @since 1.0
	* @author lixiyu
	*/
	public function problemconfirm(){
		$detail = $this->MyInfoDao->getcustomers();
		$suce = Cache::get('problem'.Auth::id());
		if(empty($suce)){
			return Redirect::to('/myinfo/index');
		}
		$problem = $this->MyInfoDao->getInfoIn('securityquestion',[$suce['pro1']['question'], $suce['pro2']['question'], $suce['pro3']['question']]);
		foreach($suce as $skey => $sval){
			foreach($problem as $pkey => $pval){
				if($sval['question'] == $pval->id){
					$sval['name'] = $pval->question;
				}
			}
			$suce[$skey] = $sval;
		}
		$random = [1,2,3];
		shuffle($random);
		return view('user.myinfo.problem3',['info'=>$detail, 'set'=>true, 'suce'=>$suce, 'r'=>$random]);
	}

	/**
	* 存入安全问题
	*/
	public function problemSave(){
		$pro1 = Input::get('pro');
		$pro2 = Cache::get('problem'.Auth::id());
		if( empty($pro2)) return 0; //返回0 ，说明数据已经过期

		for($i = 1; $i <= 3; $i++){
			$res = true;
			if($pro1['pro'.$i]['question'] != $pro2['pro'.$i]['question']){
				$res = false;
				break;
			}
			if($pro1['pro'.$i]['answer'] != $pro2['pro'.$i]['answer']){
				$res = false;
				break;
			}
		}

		if( !$res ) return 1;// 返回1，说明问题答案不对
		
		foreach($pro1 as $key => $val){
			$tmp = array();
			$tmp['uid'] = Auth::id();
			$tmp['question'] = $val['question'];
			$tmp['answer'] = $val['answer'];
			$info[] = $tmp;
		}
		
		$secu = $this->MyInfoDao->isExist( 'securityquestionuser', ['uid'=>Auth::id()], ['id']);

		if(empty($secu)){
			$flag = $this->MyInfoDao->addInfo('securityquestionuser', $info);
			if($flag){
				Cache::forget('problem'.Auth::id());
				Cache::put('problemconfirm'.Auth::id(),'ok',2);
				return 2; // 返回2表示成功 
			} 
			
			return 3; //返回3表示 数据写入失败
		}else{
			for($i = 0; $i < 3; $i++ ){
				$flag = $this->MyInfoDao->upInfo('securityquestionuser', $info[$i], $secu[$i]->id);
			}
			
			Cache::forget('problem'.Auth::id());
			Cache::put('problemconfirm'.Auth::id(),'ok',2);
			return 2;
		}
	}

	/**
	* 安全问题显示页面四
	* @since 1.0
	* @author lixiyu
	*/
	public function problem4(){
		$flag = Cache::get('problemconfirm'.Auth::id());
		if(empty($flag)){
			return Redirect::to('/myinfo/problem1');
		}
		$question = $this->MyInfoDao->getAll('securityquestion');
		$detail = $this->MyInfoDao->getcustomers();

		return view('user.myinfo.problem4',['info'=>$detail, 'set'=>true, 'question'=>$question]);

	}

	/**
	* 将传入的datetime 转换
	* @since 1.0
	* @author lixiyu
	* @param string $datetime
	*/
	public function changeTime($datetime){
		$hours = substr($datetime , 0 ,-8);
		$minute = substr($datetime , -8, -3);
		$reltime = strtotime($hours);
		$curtime = time();
		$moretime = $curtime - $reltime;
		if($moretime < 86400){
			$day = '今天 '.$minute;
		}else if($moretime < (86400 * 2)){
			$day = '昨天 '.$minute;
		}else{
			$day = $hours.$minute;
		}
		return $day;
	}



	/**
	*  用手机登陆后设置用户名  密码
	*    
	*/
	public function userSet(){
		return view('user.myinfo.usersetPwd');
	}

	/**
	 * 普通用户转换为经纪人
	 * @return \Illuminate\View\View
	 */
	public function userChangeToBroker()
	{
		$reset = true;
		// 查询所有的省份
		$province = $this->CityDao->selectProvince();
		$info = $this->MyInfoDao->getInfo('customers',Auth::user()->id);
		return view('user.myinfo.resetUserStatus',compact('reset','province','info'));
	}

	/**
	 * ajax上传身份证照片
	 */
	public function uploadIdCard()
	{
		$field = Input::get('filename');
		$id = Auth::user()->id;
		$upload = new UploadsController();
		$flag = $upload->cardUpload($id, 'brokers', $field);
		return json_encode(['res' => 'success', 'data' => $flag]);
	}

	/**
	 * ajax提交  用户转变经纪人信息保存
	 */
	public function brokerSave(){
		/**
		 * 检测身份证是否已注册
		 * 房源的发布人类型 publishUserType 改为1
		 * customers 普通用户信息（是否用）删除
		 * 普通用户头像从服务器删除
		 * brokers表增加一条记录
		 * 更改users表的角色rId
		 * 增加预约刷新--如果没有就增加
		 * 委托房源删除
		 */
		$provinceId = Input::get('provinceId');		// 省
		$cityId = Input::get('cityId');				// 市
		$areaId = Input::get('areaId');				// 区
		$businessId = Input::get('businessId');		// 商圈
		$companyId = Input::get('companyId');		// 公司id
		$companyName = Input::get('companyName');	// 公司名称
		$mainBusiness = Input::get('mainBusiness');	// 主营业务
		$userImage = Input::get('imgdata');  // 用户头像

		$mainBus = '';
		foreach($mainBusiness as $main){
			if($main == '住宅') $mainBus .= '2|3';
			if($main == '商业') $mainBus .= '|4|5';
		}
		$mainBus = trim($mainBus,'|');
		$realName = trim(Input::get('realName'));
		$patt = "/^[\x{4e00}-\x{9fa5}]+$/u";
		if(!preg_match($patt,$realName)) return json_encode(['res' => 'error','data' => '真实姓名为中文']);
		$idcard = trim(Input::get('idcard'));
		$idcardImg = Input::get('idcardImg');
		if(empty($realName) || empty($idcard) || empty($idcardImg)) return json_encode(['res' => 'error','data' => '缺少参数']);
		// 检测身份证号是否已被注册
		$idCardNumFlags = $this->MyInfoDao->isExist('brokers',['idcardNum'=>$idcard],['id']);
		if(!empty($idCardNumFlags)) return json_encode(['res' => 'error','data' => '此身份证号已被注册']);
		// 处理用户头像
		if(strripos($userImage,'http://') === false) {
			$upload = new UploadsController();
			$upload->cutparam(Auth::user()->id);
		}

		// 检测发布的房源
		$houseRent = $this->MyInfoDao->getIdArrayByCondition('mysql_oldhouse','houserent',['uid' => Auth::user()->id,'cityId' => $cityId]);
		$houseSale = $this->MyInfoDao->getIdArrayByCondition('mysql_oldhouse','housesale',['uid' => Auth::user()->id,'cityId' => $cityId]);
		// 检测委托的房源
		$rent = $this->MyInfoDao->getIdArrayByCondition('mysql_oldhouse','houserententrust',['uid' => Auth::user()->id]);
		$Qz = $this->MyInfoDao->getIdArrayByCondition('mysql_oldhouse','houserentwanted',['uId' => Auth::user()->id]);
		$sale = $this->MyInfoDao->getIdArrayByCondition('mysql_oldhouse','housesaleentrust',['uid' => Auth::user()->id]);
		$Qg = $this->MyInfoDao->getIdArrayByCondition('mysql_oldhouse','housesalewanted',['uId' => Auth::user()->id]);
		// 查询用户头像
		//$info = $this->MyInfoDao->getFields('customers', Auth::user()->id, ['photo']);
		$info = $this->MyInfoDao->getInfo('customers', Auth::user()->id);

		$broker = [
			'id' => Auth::user()->id,
			'realName' => $realName,
			'photo' => $info[0]->photo,
			'mobile' => Auth::user()->mobile,
			'provinceId' => $provinceId,
			'cityId' => $cityId,
			'cityAreaId' => $areaId,
			'businessAreaId' => $businessId,
			'idcardNum' => $idcard,
			'idcardPicFront' => $idcardImg,
			'companyId' => $companyId,
			'managebusinessAreaIds' => $businessId,
			'mainbusiness' => $mainBus,
			'company' => $companyName
		];
		if($info[0]->gender == 2){
			$broker['gender'] = 0;
		}else if($info[0]->gender == 0){
			$broker['gender'] = 2;
		}else{
			$broker['gender'] = $info[0]->gender;
		}

		DB::connection('mysql_user')->beginTransaction();
		try{
			// 查询用户拓展表是否有信息(users_info)
			$users_info = $this->MyInfoDao->isExist('users_info', ['uId' => Auth::user()->id], ['uId']);
			$usersInfo = self::getUsers_InfoTable($info,$broker);
			if(empty($users_info)){
				if(!empty($usersInfo)) $this->MyInfoDao->addInfo('users_info', $usersInfo);
			}else{
				if(!empty($usersInfo)) $this->MyInfoDao->upUserInfo('users_info', $usersInfo, Auth::user()->id);
			}
			// 查询用户认证信息表(users_verify)
			$users_verify = $this->MyInfoDao->isExist('users_verify',['uId' => Auth::user()->id], ['uId']);
			$usersverify = self::getUsers_VerifyTable($broker);
			if(empty($users_verify)){
				if(!empty($usersverify)) $this->MyInfoDao->addInfo('users_verify', $usersverify);
			}else{
				if(!empty($usersverify)) $this->MyInfoDao->upUserInfo('users_verify', $usersverify, Auth::user()->id);
			}
			// 删除普通用户信息
			$del = $this->MyInfoDao->deleteTableDataById('customers', Auth::user()->id);
			// broker表增加一条记录
			if(in_array($companyName,['其他','独立经纪人'])) unset($broker['company']);
			$ins = $this->MyInfoDao->addInfo('brokers', $broker);
			// 更改users表的角色rId
			$up = $this->MyInfoDao->upInfo('users', ['type' => 2,'rId' => 2], Auth::user()->id);
			// 预约刷新--如果没有就增加
			$refreshUser = $this->MyInfoDao->selectRefreshUserSetting(Auth::user()->id);
			if(empty($refreshUser)){
				$esfData = config('marketingConfig.beforeBuy');
				$esfData['uid'] = Auth::user()->id;
				$insRes = $this->MyInfoDao->addInfo('refreshusersetting_operation', $esfData);
			}
			// 房源更改
			if(!empty($houseSale)){
				$hr = $this->MyInfoDao->updateHouseByUid('housesale', $houseSale, ['publishUserType' => 1]);
				$hrImage = $this->MyInfoDao->updateHouseImageType('housesaleimage', $houseSale, ['type' => 10]);
			}
			if(!empty($houseRent)){
				$hs = $this->MyInfoDao->updateHouseByUid('houserent', $houseRent, ['publishUserType' => 1]);
				$hsImage = $this->MyInfoDao->updateHouseImageType('houserentimage', $houseRent, ['type' => 10]);
			}
			// 委托信息删除
			if(!empty($rent)){
				$rentFlags= $this->MyInfoDao->deleteTableById('houserententrust', ['uid' => Auth::user()->id]);
			}
			if(!empty($Qz)){
				$QzFlags= $this->MyInfoDao->deleteTableById('houserentwanted', ['uId' => Auth::user()->id]);
			}
			if(!empty($sale)){
				$saleFlags= $this->MyInfoDao->deleteTableById('housesaleentrust', ['uid' => Auth::user()->id]);
			}
			if(!empty($Qg)){
				$QgFlags= $this->MyInfoDao->deleteTableById('housesalewanted', ['uId' => Auth::user()->id]);
			}
		}catch(Exception $e){
			DB::connection('mysql_user')->rollBack();
			return json_encode(['res' => 'error','data' => '保存失败']);
		}
		DB::connection('mysql_user')->commit();
		// 退出当前的登陆状态
		Auth::logout();
		Session::forget('user');
		$url = config('hostConfig.agr_host').'/majorLogin';
		return json_encode(['res' => 'success','data' => '保存成功','url' => $url]);

	}

	/**
	 * 组合用户认证信息表
	 */
	private function getUsers_VerifyTable($broker)
	{
		$data['uId'] = Auth::user()->id;
		$data['idCard'] = $broker['idcardNum'];
		$data['idCard_verify'] = 1;
		$data['idCard_pic1'] = $broker['idcardPicFront'];
		$data['realName'] = $broker['realName'];
		$data['company_id'] = $broker['companyId'];
		$data['company_name'] = $broker['company'];
		return $data;
	}

	/**
	 * 组合用户拓展表信息
	 */
	private function getUsers_InfoTable($info,$broker)
	{
		$data['uId'] = Auth::user()->id;
		$data['realName'] = $broker['realName'];
		$data['icon'] = $broker['photo'];
		$data['provinceId'] = $broker['provinceId'];
		$data['cityId'] = $broker['cityId'];
		$data['cityAreaId'] = $broker['cityAreaId'];
		$data['businessAreaId'] = $broker['businessAreaId'];
		$data['birthday'] = (!empty($info[0]->birthday)) ? str_replace('-','',substr($info[0]->birthday,0,10)) : 0;
		$data['intro'] = (!empty($info[0]->intro)) ? $info[0]->intro : '';
		if($info[0]->gender == 1){
			$data['gender'] = 1;
		}else if($info[0]->gender == 2){
			$data['gender'] = 0;
		}
		return $data;
	}

}
