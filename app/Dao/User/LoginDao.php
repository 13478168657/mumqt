<?php

namespace App\Dao\User;

use DB;
use Illuminate\Support\Facades\Session;

//define('FAILED',0);
//define('SUCCESS',1);
//define('FORBIDDEN',2);

class LoginDao {
    /*
     * @index  用户注册功能
     * @access public
     * $_POST['puid'] 有两个值，1为验检验用户是否可用、2为注册。写入数据库
     * @since 1.0
     * @author niewu
     */
    public function index() {  }
    /*
     * @register  用户注册功能
     * @access public
     * $_POST['puid'] 有两个值，1为验检验用户是否可用、2为注册。写入数据库
     * @since 1.0
     * @author niewu
     */
    public function register($puid, $name = null, $mobile = null, $pwd = null, $type = null) {
        if ($puid == 1) {
            $res = DB::table('users')->where('mobile', $name)->get();
            if ($res) {
                return 1;
            } else {
                $re = DB::table('users')->where('userName', $name)->get();
                if ($re) {
                    return 2;
                } else {
                    return 3;
                }
            }
        }
        if ($puid == 2) {
            $res = DB::table('users')->where('mobile', $mobile)->get();
            if($res){
                return 9;
            }
            $user = array('userName' => $name, 'mobile' => $mobile, 'password' => bcrypt(md5($pwd)), 'type' => $type);
            $res = DB::table('users')->insert($user);
            if ($res) {
                Session::put('name', $name);
                Session::put('type', $type);
                return 2;
            }
        }
    }
    /*
     * 检查手机是不被注册过
     */
    public function mobile($mob) {
        $res = DB::table('users')->where('mobile', $mob)->get();
        if ($res) {
            return 6;
        } else {
            return 7;
        }
    }
    /**
     * 检查手机号对应users表信息
     */
    public function getUserByMobile($mobile){
    	$userObj = DB::connection('mysql_user')->table('users')->where('mobile', $mobile)->first();
    	return $userObj;
    }

    /**
     * 重写普通用户login功能  增加了被禁用户访问权限的限制
     * @param $name
     * @param $pwd
     * @param $type
     * @return int
     * @author huzhaer
     */
//    public function login($name, $pwd, $type){
//        session()->flush();
//        return $this->checkLogin($type,$name,$pwd);
//    }
    /**
     *   自动登陆
     *  @author zhuwei
     */
    public function autoLogin($name,$type){
        session()->flush();
        if($type == '1'){
            $res = DB::table('users')->where('mobile', $name)->get();
            if($res){
                Session::put('name', $res[0]->userName);
                Session::put('type', $res[0]->type);
                Session::put('rId', $res[0]->rId);
                return 2;
            }else{
                return 1;
            }
        }
    }
    /**
     *  记录用记登陆信息
     *  @param array $info 需要录入 的信息
     */
    public function recordLogin( $info ){
        return DB::table('loginhistory')->insert($info);
    }

//============== 工具函数 =============================
    /**
     * 检查是否可以登录函数   可以返回2 不行返回1
     * @param $type
     * @param $userName
     * @param $password
     * @return int
     * @author huzhaer
     */
//    private function checkLogin($type,$userName,$password){
//        $res = DB::table('user')->where($type,$userName)->get();
//
//        if($this->checkIfUserBanned($res)) return FORBIDDEN;
//        if($this->checkPassowrd($res,$password)){
//            return (int)SUCCESS;
//        }else{
//            return (int)FAILED;
//        }
//    }
//    /**
//     * 检查密码函数，只能跟着上面的checkLogin一起用
//     * @param $data
//     * @param $password
//     * @return bool
//     * @author huzhaer
//     */
//    private function checkPassowrd($data,$password){
//        if ($password != $data[0]->password) {
//            return false;
//        } else {
//            Session::put('name', $data[0]->userName);
//            Session::put('type', $data[0]->type);
//            Session::put('rId',  $data[0]->rId);
//            return true;
//        }
//    }
//    /**
//     * 检查用户是否被禁  禁返false 只能跟着checkLogin函数使用
//     * @param $data
//     * @return bool
//     * @author huzhaer
//     */
//    private function checkIfUserBanned($data){
//        //用户的state字段，0为禁止 1为开始
//        if($data[0]->state) return true;
//        return false;
//    }
}



/*
 * @register  用户登陆功能
 * @$type 1为手机登录    2为邮箱登录  3为用户名登录
 * @access public
 * @since 1.0
 * @author niewu
 */
//    public function login($name, $pwd, $type) {
//        session()->flush();
//        if ($type == '3') {
//            $res = DB::table('users')->where('userName', $name)->get();
//
//            if ($res) {
//                if ($pwd != $res[0]->password) {
//                    return 1;
//                } else {
//                    Session::put('name', $res[0]->userName);
//                    Session::put('type', $res[0]->type);
//                    Session::put('rId', $res[0]->rId);
//                    return 2;
//                }
//            } else {
//                return 1;
//            }
//        }
//        if ($type == '2') {
//            $res = DB::table('users')->where('email', $name)->get();
//            if ($res) {
//                if ($pwd != $res[0]->password) {
//                    return 1;
//                } else {
//                    Session::put('name', $res[0]->userName);
//                    Session::put('type', $res[0]->type);
//                    Session::put('rId', $res[0]->rId);
//                    return 2;
//                }
//            } else {
//                return 1;
//            }
//        }
//        if ($type == '1') {
//            $res = DB::table('users')->where('mobile', $name)->get();
//            if ($res) {
//                if ($pwd != $res[0]->password) {
//                    return 1;
//                } else {
//                    Session::put('name', $res[0]->userName);
//                    Session::put('type', $res[0]->type);
//                    Session::put('rId', $res[0]->rId);
//                    return 2;
//                }
//            } else {
//                return 1;
//            }
//        }
//    }