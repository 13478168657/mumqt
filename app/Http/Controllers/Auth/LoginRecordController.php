<?php
namespace App\Http\Controllers\Auth;

use App\Dao\User\LoginDao;
use Illuminate\Routing\Controller;
use Input;
use Auth;
/**
 * description of LoginRecordController
 * 记录用户登陆信息
 * @author lixiyu
 */
class LoginRecordController extends Controller{


	// 记录用户上次登陆
    
    /**
     * 记录用户登陆信息
     */
    public static function recordLogin(){
    	$LoginIn = new LoginDao;
	    $loginInfo = Self :: getLoginInfo();
	    $LoginIn->recordLogin($loginInfo);
    }

    /**
    * 获取登陆方式 并计算出相应的信息
    */
    public static function getLoginInfo(){
        $info = array();
        $name = trim(Input::get('userName'));
        if(is_numeric($name)){
            // 1.用户名登陆 2.邮箱地址登录 3.手机号登陆   4、qq  5、 微信
            $info['loginMode'] = '3';
        }else{
            if(strpos($name, '@') !== false){
                $info['loginMode'] = '2';
            }else{
                $info['loginMode'] = '1';
            }
        }
       
       	$info['uid'] 		= Auth::user()->id;  								// 获取用户id 
        $info['cityId'] 	= Self::getCity(); 									// 获取用户登陆的所在城市 
        $info['ip'] 		= Self::getIP();  									// 获取用户登陆时用的ip
        $info['browser'] 	= Self::getBrowser($_SERVER['HTTP_USER_AGENT']); 	// 获取用户登陆时用的浏览器
        $info['system'] 	= Self::getSystem($_SERVER['HTTP_USER_AGENT']); 	// 获取用户登陆是用的操作系统 
        $info['loginTime'] 	= date('Y-m-d H:i:s');   							// 获取用户用登陆的时间 
        return $info;
    }


    // 获取Ip
    protected static function getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    } 


    //获取访问用户的浏览器的信息
    protected static function getBrowser ($Agent) {
        $browseragent="";   //浏览器
        $browserversion=""; //浏览器的版本
        if (preg_match('/MSIE ([0-9].[0-9]{1,2})/',$Agent,$version)) {
         $browserversion=$version[1];
         $browseragent="Internet Explorer";
        } else if (preg_match( '/Opera\/([0-9]{1,2}.[0-9]{1,2})/',$Agent,$version)) {
         $browserversion=$version[1];
         $browseragent="Opera";
        } else if (preg_match( '/Firefox\/([0-9.]{1,5})/',$Agent,$version)) {
         $browserversion=$version[1];
         $browseragent="Firefox";
        }else if (preg_match( '/Chrome\/([0-9.]{1,3})/',$Agent,$version)) {
         $browserversion=$version[1];
         $browseragent="Chrome";
        }
        else if (preg_match( '/Safari\/([0-9.]{1,3})/',$Agent,$version)) {
         $browseragent="Safari";
         $browserversion="";
        }
        else {
        $browserversion="";
        $browseragent="Unknown";
        }
        return $browseragent." ".$browserversion;
    }

    // 同理获取访问用户的系统
    protected static function getSystem ($Agent) {
        $browserplatform='';
        if (preg_match('/win/i',$Agent) && strpos($Agent, '95')) {
        $browserplatform="Windows 95";
        }
        elseif (preg_match('/win 9x/i',$Agent) && strpos($Agent, '4.90')) {
        $browserplatform="Windows ME";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/98/',$Agent)) {
        $browserplatform="Windows 98";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/nt 5.0/i',$Agent)) {
        $browserplatform="Windows 2000";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/nt 5.1/i',$Agent)) {
        $browserplatform="Windows XP";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/nt 6.0/i',$Agent)) {
        $browserplatform="Windows Vista";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/nt 6.1/i',$Agent)) {
        $browserplatform="Windows 7";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/32/',$Agent)) {
        $browserplatform="Windows 32";
        }
        elseif (preg_match('/win/i',$Agent) && preg_match('/nt/i',$Agent)) {
        $browserplatform="Windows NT";
        }elseif (preg_match('/Mac OS/i',$Agent)) {
        $browserplatform="Mac OS";
        }
        elseif (preg_match('/linux/i',$Agent)) {
        $browserplatform="Linux";
        }
        elseif (preg_match('/unix/i',$Agent)) {
        $browserplatform="Unix";
        }
        elseif (preg_match('/sun/i',$Agent) && preg_match('/os/i',$Agent)) {
        $browserplatform="SunOS";
        }
        elseif (preg_match('/ibm/i',$Agent) && preg_match('/os/i',$Agent)) {
        $browserplatform="IBM OS/2";
        }
        elseif (preg_match('/Mac/i',$Agent) && preg_match('/PC/i',$Agent)) {
        $browserplatform="Macintosh";
        }
        elseif (preg_match('/PowerPC/i',$Agent)) {
        $browserplatform="PowerPC";
        }
        elseif (preg_match('/AIX/i',$Agent)) {
        $browserplatform="AIX";
        }
        elseif (preg_match('/HPUX/i',$Agent)) {
        $browserplatform="HPUX";
        }
        elseif (preg_match('/NetBSD/i',$Agent)) {
        $browserplatform="NetBSD";
        }
        elseif (preg_match('/BSD/i',$Agent)) {
        $browserplatform="BSD";
        }
        elseif (preg_match('/OSF1/',$Agent)) {
        $browserplatform="OSF1";
        }
        elseif (preg_match('/IRIX/',$Agent)) {
        $browserplatform="IRIX";
        }
        elseif (preg_match('/FreeBSD/i',$Agent)) {
        $browserplatform="FreeBSD";
        }
        if ($browserplatform=='') {$browserplatform = "Unknown"; }
        return $browserplatform;
    }

    // 获取城市id
    protected static function getCity()
    {
    	return CURRENT_CITYID; 
    }
}