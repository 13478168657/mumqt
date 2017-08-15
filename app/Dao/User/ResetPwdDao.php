<?php
namespace App\Dao\User;
use DB;

/**
*  重置密码Dao
* @author zhuwei
*/

class ResetPwdDao{
    /**
     *  确认账户是否存在
     * @param  $filedName   字段名
     * @param  $userName    传递的值
     */
    public function GetUser($filedName,$userName){
        $res = DB::connection('mysql_user')
                ->table('users')
                ->where('type','=','1')
                ->where($filedName,$userName)
                ->get(['id']);
        return $res;
    }
    /**
     *  查询密保问题
     * @param  $id        用户id
     * @param  $userName    传递的值
     */
    public function GetUserQuestion($id){
        $question = DB::connection('mysql_user')
                ->table('securityquestion')
                ->join('securityquestionuser','securityquestion.id','=','securityquestionuser.question')
                ->where('securityquestionuser.uid',$id)
                ->get(['securityquestion.question','securityquestion.id']);
        return $question;
    }
    /**
     *  查询密保问题答案
     * @param  $id        用户id
     * @param  
     */
    public function GetQuestionAnswer($id){
        $answer = DB::connection('mysql_user')
                ->table('securityquestionuser')
                ->where('uid',$id)
                ->get(['question','answer']);
        return $answer;
    }
    
    /**
     *  查询邮箱
     * @param  $id        用户id
     * @param  $userName    传递的值
     */
    public function GetUserEmail($id){
        $email = DB::connection('mysql_user')
                ->table('users')
                ->where('id',$id)
                ->where('type','=','1')
                ->pluck('email');
        return $email;
    }
    
    /**
     *  设置新密码
     * @param  $id        用户id
     * @param  $password    传递的值
     */
    public function EditUserPassword($password,$id){
        $question = DB::connection('mysql_user')
                ->table('users')
                ->where('id',$id)
                ->update(['password'=>$password]);
        return $question;
    }
    //  查询用户名
    public function GetUserName($id){
        $res = DB::connection('mysql_user')
                ->table('users')
                ->where('type','=','1')
                ->where('id',$id)
                ->get(['userName']);
        return $res;
    }
    /**
     *  确认用户输入的手机号和邮箱
     *  @param  $id         用户id
     *  @param  $fieldName  字段名
     */
    public function GetUserConfirm($id,$fieldName,$type){
        if($type == 2){
            $res = DB::connection('mysql_user')
                     ->table('users')
                     ->where('id',$id)
                     ->where('type','=','1')
                     ->get(['email']);
        }
        if($type == 1){
            $res = DB::connection('mysql_user')
                     ->table('users')
                     ->where('id',$id)
                     ->where('type','=','1')
                     ->get(['mobile']);
        }
        return $res;
    }
    
}