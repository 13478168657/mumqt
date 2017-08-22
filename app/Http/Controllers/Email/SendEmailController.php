<?php

namespace App\Http\Controllers\Email;

use Mail;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SendEmailController extends Controller
{
    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function sendEmailReminder(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
    }

    /**
    * 发送邮件验证码
    * @param int $id 用户id
    * @param string $email 
    */
    public function send($email){
        $code = self::GenerateRand();
        $data = ['email'=>$email,'code'=>$code,'_email'=>base64_encode($email)];
        $flag = Mail::send('user.myinfo.email', $data, function ($m) use ($data) {
            $m->to($data['email'])->subject('激活您在 搜房网 会员帐号的必要步骤!');
        });

        if(!$flag) return false;
        $data['_email'] = self::MailServe($email);
        return $data;
    }

    /**
    * 找回密码发送邮件
    * @param int $id 用户id
    * @param string $email 
    * @author  zhuwei 
    */
    public function resetPassword($arr,$type){
        $code = self::GenerateRand();
        if($type == 1){
            $data = ['email'=>$arr['email'],'code'=>$code,'_email'=>base64_encode($arr['email'])]; 
            $code_id = ['code'=>$code,'id'=>$arr['id']];
            Cache::put($arr['email'], $code_id, 60);
            $flag = Mail::send('index.email', $data, function ($m) use ($data) {
                $m->to($data['email'])->subject('激活您在 搜房网 会员帐号的必要步骤!');
            });
        }
        if(!$flag) return false;
        $data['_email'] = self::MailServe($arr['email']);
        return $data;
    }

    /**
     * 通过邮箱发送验证码
     * @param string $email
     * @param string $code 随机验证码
     */
    public function sendCode($email, $code){
        $data = array('email'=>$email, 'code'=>$code);
        $flag = Mail::send('user.myinfo.email2', $data, function ($m) use ($data) {
            $m->to($data['email'])->subject('激活您在 搜房网 会员帐号的必要步骤!');
        });
        if(!$flag) return false;
        $data['_email'] = self::MailServe($email);
        return $data;
    }
    /**
     * 生成8位随机数
     * @return string
     */
    public function GenerateRand() {
        $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ';
        $i=rand(0,61);
        $t1=$str[rand(0,61)].$str[rand(0,61)].$str[rand(0,61)].$str[rand(0,61)].$str[rand(0,61)].$str[rand(0,61)].$str[rand(0,61)].$str[rand(0,61)];
        return $t1;
    }
    
    /**
     * 返回邮箱服务地址
     * @param type $email
     * @return string
     */
    public function MailServe($email) {
        $val="";
        if(strstr($email,'139.com'))
        {
            $val="http://mail.10086.cn/";
        }else if(strstr($email,'qq.com'))
        {
            $val="https://mail.qq.com/cgi-bin/loginpage";
        }else if(strstr($email,'126.com'))
        {
            $val="http://www.126.com/";
        }else if(strstr($email,'163.com'))
        {
            $val="http://mail.163.com/";
        }else if(strstr($email,'sina.com'))
        {
            $val="http://mail.sina.com.cn/";
        }
        else if(strstr($email,'yeah.net'))
        {
            $val="http://www.yeah.net/";
        }
        else if(strstr($email,'sohu.com'))
        {
            $val="http://mail.sohu.com/";
        }
        else if(strstr($email,'tom.com'))
        {
            $val="http://web.mail.tom.com/webmail/login/index.action";
        }else if(strstr($email,'live.cn')){
         
            $val="http://mail.live.cn";
            
        }else if(strstr($email,'hotmail.com')){
            $val='http://outlook.com';
        }else{
            $ext = explode('@', $email)[1];
            $val= "http://mail".$ext;  
        }
        return $val;
    }
}