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
use App\Http\Controllers\Auth\AuthController;
use Redirect;
use Hash;
use Session;
/**
* Description of MajorInfoController （专业用户中心）
* @since 1.0
* @author lixiyu
*/
class MajorInfoController extends Controller{

	protected $MyInfoDao;
	protected $CityDao;
	/**
	* 构造方法 载入DAO 并检测用户是否登录
	*/
	public function __construct() {
		$this->MyInfoDao = new MyInfoDao();
		$this->CityDao = new CityDao();
		// 判断用户是否登录  并且 用户类型为 专业经纪人用户
		if( !Auth::check() || Auth::user()->type != 2){
			$this->beforeFilter('UserMyInfoFilter');
		}
	}

	/**
	* 专业经纪人用户信息补充页面一
	* @since 1.0
	* @author lixiyu
	*/
	public function repairInfo(){
		//获取用户id
		$id = Auth::user()->id;
		// 通过联查得到 用户信息
		$info = $this->MyInfoDao->getLeft( 'users', 'brokers', array('id','id'), 'users.id', '=', $id);
		//截取出生日期和手机
		$info[0]->birthday = substr( $info[0]->birthday, 0, 10);
		$info[0]->mobile = substr( $info[0]->mobile, 0, 3) . '****' . substr( $info[0]->mobile, -4);
		$province = $this->CityDao->selectProvince();
		$city = $this->CityDao->selectCity($info[0]->provinceId);
		$cityArea = $this->CityDao->selectCityArea($info[0]->cityId);

		$info[0]->title = '补充信息';
		return view('user.majorinfo.repairInfo', ['info'=>$info[0], 'province'=>$province, 'city'=>$city, 'cityArea'=>$cityArea, 'infoShow'=>true]);
	}


	/**
	* ajax 图片上传 并返回修改过后的图片路径
	* @since 1.0
	* @author lixiyu
	*/
	public function imgUpload(){
		$id = Auth::user()->id;
		$filename = $this->MyInfoDao->getFields('brokers', $id, ['photo']);
                
		$filename = DIRECTORY_SEPARATOR."img".$filename[0]->photo;
		if(file_exists($filename)){
			unlink($filename);
                        
		}
		$upload = new UploadsController(); 
		$upload->cutparam($id);    
		$info = $this->MyInfoDao->getInfo('brokers', $id);

        $photo = config('imgConfig.imgSavePath').$info[0]->photo;
        return json_encode($photo);
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
		$info['realName']   = Input::get('realname');
		$info['company']    = Input::get('company');
		$info['shopName']   = Input::get('shopName');

		$call = $this->MyInfoDao->upInfo( 'brokers', $info, $id);
		if($call){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	* 专业经纪人用户信息补充页面二
	* @since 1.0
	* @author lixiyu
	*/
	public function brokerId(){
		$info = Auth::user();
		$broker = $this->MyInfoDao->getInfo('brokers', $info->id);
		$info->title = '补充信息';
		// dd($broker);
		return view('user.majorinfo.brokerId', ['info'=>$info, 'broker'=>$broker[0]]);
	}

	/**
	* ajax 上传专业经纪人身份证、工牌和名片
	* @since 1.0
	* @author lixiyu
	*/
	public function pictureAll(){
		$field = Input::get('filename');
		$id = Auth::user()->id;
		$filename = $this->MyInfoDao->getFields('brokers', $id, [$field]);
		$filename = DIRECTORY_SEPARATOR."img".$filename[0]->$field;
		if(file_exists($filename)){
			unlink($filename);
		}
		$upload = new UploadsController(); 
		$flag = config('imgConfig.imgSavePath').$upload->cardUpload($id, 'brokers', $field);
		return json_encode($flag);
	}

	/**
	* ajax 上传经纪人的身份证号和工牌号
	* @since 1.0
	* @author lixiyu
	*/
	public function brokerInfo(){
		$info['idCard'] = Input::get('idcard');
		$info['jobNum'] = Input::get('jobNum');
		$this->MyInfoDao->upInfo('brokers', $info, Auth::user()->id);
		return 1;
	}

	/**
	* 专业经纪人用户信息补充页面三
	* @since 1.0
	* @author lixiyu
	*/
	public function accountSafe(){
            $info = Auth::user();
            $info->mobile = substr( $info->mobile, 0, 3) . '****' . substr( $info->mobile, -4);
            $score = 40;
            if(!empty($info->email)){
                    $score += 30; 
            }
            $secu = $this->MyInfoDao->isExist( 'securityquestionuser', ['uid'=>Auth::id()], ['id']);
            if(!empty($secu)){
                    $score += 30;
            }
            $question = $this->MyInfoDao->getAll('securityquestion');
            $info->title = '补充信息';
		return view('user.majorinfo.accountSafe',  ['info'=>$info, 'score'=>$score, 'question'=>$question ,'secu'=>$secu]);
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
            if($call){
                    return 1;
            }else{
                    return 0;
            }
	}

	/**
	* ajax发送邮箱验证码
	* @since 1.0
	* @author lixiyu
	*/
	public function sendEmail(){

            $info['email'] = Input::get('email');

            if(Cache::get($info['email'])) return 1;// 返回1，提醒客户邮件已发送，到相关邮箱点击连接进行激活

            $user = Auth::user();
            if( $user->email == $info['email']){
                    return 2; //返回2，提醒用户这是他的账号里存在的邮箱，并已激活
            }

            $call = $this->MyInfoDao->isExist('users',$info,array('email'));
            if($call) return 3;//返回3，提醒客户此邮箱已被激活并占用

            $test = new SendEmailController();
            $data = $test->send($info['email']);

            if(!$data) return 4; //返回4，提醒用户邮箱发送失败，请稍候再试

            $data['id'] = Auth::id(); 
            Cache::put($info['email'], $data, 60);
            unset($data['code']);
            unset($data['id']);
            return json_encode($data);//返回$data，邮箱发送成功并提醒用户登陆邮箱并激活邮箱
	}

	/**
	* 存入安全问题
	*/
	public function problemSave(){
		$pro = Input::get('pro');
		
		foreach($pro as $key => $val){
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
}