<?php
namespace App\Http\Controllers\Index;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Dao\User\ResetPwdDao;
use App\Http\Controllers\Email\SendEmailController;
use Session;
use Auth;
use Redirect;

/**
 *  找回密码
 * @author  zhuwei
 * @date    2016/03/10  14:05:30
 */

class ResetPwdController extends Controller{
    private $resetDao;
    public function __construct() {
        $this->resetDao = new ResetPwdDao();
    }
    // 密码页面
    public function resetPwd(){
        $type = Input::get('type',1);
        if(!is_numeric($type)){
            return false;  // 参数错误
        }
        if($type == 1){
            return view('index.resetpwd1');  // 重置密码第一步
        }
        if($type == 2){
            //$id = Input::get('com');           
            //dd(Cache::has('userresetId'));
            if(Cache::has('userresetId')){
                $id = Cache::get('userresetId');
            }else{
                return Redirect::to('/resetpassword');   //  缓存过期   跳到第一步验证身份页面
            }
            $ck = Input::get('ck','');
            if(!is_numeric($id)){
                return false;  // 参数错误
            }
            // 查询密保
            $question = $this->resetDao->GetUserQuestion($id);
            // 查询邮箱
            $email = $this->resetDao->GetUserEmail($id);
            return view('index.resetpwd2',['question'=>$question,'email'=>$email,'id'=>$id,'ck'=>$ck]); // 重置密码第二步
        }
        if($type == 3){
            if(Cache::has('userresetId')){
                $id = Cache::get('userresetId');
            }else{
                return Redirect::to('/resetpassword');   //  缓存过期   跳到第一步验证身份页面
            }
            if(isset($id) && !is_numeric($id)){
                return false;  // 参数错误
            }
            return view('index.resetpwd3'); // 重置密码第三步
        }
        
    }
    
    // 确认用户
    public function confirmUser(){ 
        $userName = Input::get('name');
        $imgCode = Input::get('code');
        if(empty($userName)){
            return 1; // 账户为空
        }
        if(empty($imgCode)){
           return 2; // 图片验证码为空 
        } 
        $code = Session::get('authnum_session');
        if(strtolower($imgCode) != $code){
            return 3;   // 图片验证码错误
        }
        // 确认账号是否存在
        $fieldName = $this->checkUserNameType($userName);
        if($fieldName == false){
            return 4;  // 账户格式错误
        }
        $res = $this->resetDao->GetUser($fieldName,$userName);
        if(empty($res)){
            return 5;
        }else{
            Cache::put('userresetId',$res[0]->id,15);
            return 6;
        }
    }
    
    // 密码找回方式
    public function resetWay(){
        $type = Input::get('type');
        if(!is_numeric($type)){
            return false;   //  参数错误
        }
        if($type == 1){
            $phone = Input::get('phone');
            //dd($userName);
            $code = Input::get('code');
            //dd($userName);
            $mobile = Cache::get($phone);
            if($code != $mobile){
                return 4;   // 检验手机号是否是当前的手机
            }
            // 手机找回
            $fieldName = $this->checkUserNameType($phone);
            if($fieldName == false){
                return 2;  // 手机号格式错误
            }
            $res = $this->resetDao->GetUser($fieldName,$phone);
            if(empty($res)){
                return 3;  //  用户不存在
            }else{
                return $res;
            }
            
        }
        if($type == 2){
            $email = Input::get('email');
            if(Cache::has('userresetId')){
                $id = Cache::get('userresetId');
            }else{
                return Redirect::to('/resetpassword');   //  缓存过期   跳到第一步验证身份页面
            }
            if(!is_numeric($id)){
                return false;   
            }
            $fieldName = $this->checkUserNameType($email);
            if($fieldName == false){
                return 2;  // 邮箱格式错误
            }
            $res = $this->resetDao->GetUser($fieldName,$email);
            if(empty($res)){
                return 3;   //  邮箱不存在
            }
            $sendEmail = new SendEmailController();
            $data = ['id'=>$id,'email'=>$email];
            $result = $sendEmail->resetPassword($data,1);
            if(!$result){
                return 4;  //返回4，提醒用户邮箱发送失败，请稍候再试
            }
            unset($result['email']);
            return json_encode($result);
        }
        if($type == 3){
            if(Cache::has('userresetId')){
                $id = Cache::get('userresetId');
            }else{
                return Redirect::to('/resetpassword');   //  缓存过期   跳到第一步验证身份页面
            }
            if(!is_numeric($id)){
                return false;   //  参数错误
            }
            $question = Input::get('question');
            //dd($question);
            // 查询密保答案
            $questionId = [];
            $quesAnswer = $this->resetDao->GetQuestionAnswer($id);
            foreach($quesAnswer as $key1 => $answer){
                foreach($question as  $ques){
                    if($answer->question == $ques['id']){
                        if($answer->answer != $ques['question']){
                            $questionId[] = $answer->question;
                        }
                    }
                }
            }
            if(empty($questionId)){
                return 3;
            }else{
                return $questionId;
            }
        }
    }
    
    /**
     *  检查用户输入的邮箱和手机号是否是当前用户的
     * @param  $type   1  表示输入的手机号    2  表示输入的邮箱
     */
    public function checkAccount(){
        $type = Input::get('type');
        $field = Input::get('field');
        if(Cache::has('userresetId')){
            $id = Cache::get('userresetId');
        }else{
            return Redirect::to('/resetpassword');   //  缓存过期   跳到第一步验证身份页面
        }
        $res = $this->resetDao->GetUserConfirm($id,$field,$type);
        if($type == 2){           
            if($res[0]->email == $field){
                return 5;   //  是当前这个邮箱
            }else{
                return 4;  //  不是
            }
        }
        if($type == 1){           
            if($res[0]->mobile == $field){
                return 5;   //  是当前这个手机号
            }else{
                return 4;  //  不是
            }
        }
    }
    
    //  设置新的密码
    public function resetAdd(){
        $newpwd1 = Input::get('new1');
        $newpwd2 = Input::get('new2');

        if(Cache::has('userresetId')){
            $id = Cache::get('userresetId');
        }else{
            return Redirect::to('/resetpassword');   //  缓存过期   跳到第一步验证身份页面
        }
        if($newpwd1 != $newpwd2) return 0;
        $password = bcrypt(md5($newpwd1));
        $call = $this->resetDao->EditUserPassword($password, $id);
        if($call){
            // 查询该用户的用户名
                $userName = $this->resetDao->GetUserName($id);
                return $userName;
                
        }else{
                return 0;
        }
    }
    
    //  点击登陆
    public function clickAutoLoad(){
        $id = Cache::get('userresetId');
        if(isset($id) && !empty($id)){
            // 执行自动登陆
            Auth::loginUsingID($id);
            if(Auth::check()){
                Cache::forget('userresetId');
                return 5;
//                dd(Auth::check());
//                Redirect::to('/');
            }           
        }else{
            return 4;
        }
    }
        
    /**
     * 检查用户输入的用户名字段 返回想用输入的用户名类型
     * @param $userName
     * @return string
     * @author huzhaer
     */
    private function checkUserNameType($userName){
        $type = '';
        $reg_phone  = '/^((\(\d{2,3}\))|(\d{3}\-))?1\d{10}$/';
        $reg_email  = '/^(\w|\d)+([-+.](\w|\d)+)*@(\w|\d)+([-.](\w|\d)+)*\.\w+([-.]\w+)*/';
        $reg_name   = '/^[a-zA-Z0-9_]{3,30}/';

        if(preg_match($reg_email,$userName)) $type = 'email';
        elseif(preg_match($reg_phone,$userName)) $type = 'mobile';
        elseif(preg_match($reg_name ,$userName)) $type = 'userName';
        if(empty($type) || (!isset($type))) return false;
        return $type;
    }
}