<?php

namespace App\Dao\User;

use DB;
use App\Http\Controllers\Utils\UserIdUtil;
use Auth;

/**
 * description of MyInfoDao 个人用户中心数据访问对象
 * @since 1.0
 * @author lixiyu
 */
class MyInfoDao {

    

    /**
     * 根据id获取用户的个人资料信息
     * @since 1.0
     * @author lixiyu
     * @param string $tableName 需要查询的表的表名
     * @param mix $id 查询的id 
     * @return mix  array/bool(false)  成功返回个人用户的资料信息  or  失败返回false
     */
    public function getInfo($tableName, $id) {
        $info = DB::connection("mysql_user")->table($tableName)->where('id', $id)->get();
        return $info;
    }

    /**
     * where in () 查询语句
     * @since 1.0
     * @author lixiyu
     * @param string $tableName 需要查询的表的表名
     * @param array $id 查询的id ['1','2']
     * @return mix  array/bool(false)  成功返回个人用户的资料信息  or  失败返回false
     */
    public function getInfoIn($tableName, $id) {
        $info = DB::connection("mysql_user")->table($tableName)->whereIn('id', $id)->get();
        return $info;
    }

    /**
     * 查询普通用户信息
     * @author niewu
     */

    public function getcustomers(){

        $info =  DB::connection("mysql_user")->table('customers')->where('id',Auth::user()->id)->get();
        if(!$info) {
            DB::connection("mysql_user")->table('customers')->insert(['id'=>Auth::user()->id, 'mobile'=>Auth::user()->mobile]);
        }
        return $info;
        
    }

    /**
     * 根据id更新用户的个人资料信息
     * @since 1.0
     * @author lixiyu
     * @param string $tableName 需要修改的表的表名
     * @param array $info 需要变更的信息 以键值对的形式 例：array( 字段名=>值 )
     * @param mix $id 修改的id 
     * @return bool 成功返回true 失败返回false
     */
    public function upInfo($tableName, $info, $id) {
        $call = DB::connection("mysql_user")->table($tableName)->where('id', $id)->update($info);
        return $call;
    }

    /**
     * 新增数据
     * @since 1.0
     * @author lixiyu
     * @param string $tableName 需要插入的表的表名
     * @param array $info 需要新增的信息 以键值对的形式 例：array( 字段名=>值 )
     * @return bool 成功返回true 失败返回false
     */
    public function addInfo($tableName, $info) {
        $call = DB::connection('mysql_user')->table($tableName)->insert($info);
        return $call;
    }

    /**
     * 根据手机号查询信息
     * @param string $mobile 要查询的手机号
     * @return mix
     */
    public function getMobile($mobile) {
        $mobile = DB::table('users')->where('mobile', $mobile)->first();
        return $mobile;
    }

    /**
     * 根据id查询相应字段信息
     * @param string $tbname 要查询的表名
     * @param int $id  查询的Id
     * @param array $fields 字段 ['field1','field2']
     * @return mix
     */
    public function getFields($tbName, $id, $fields) {
        $info = DB::connection("mysql_user")->table($tbName)->where('id', $id)->get($fields);
        return $info;
    }

    /**
     * 根据提供的条件进行查询，判断该条件的数据是否存在
     * @param string $tbName 表名
     * @param array $condition 查询的where 条件 ['email'=>'test@qq.com']
     * @param array $fields 要查询的字段 ['field1','field2']
     * @return mix
     */
    public function isExist($tbName, $condition, $fields) {
        
        $result = DB::connection("mysql_user")->table($tbName)->where($condition)->get($fields);
      
        return $result;
    }

    /**
     * 查询一个表的全部数据
     * @param string $tbName 表名
     */
    public function getAll($tbName) {
        $result = DB::connection("mysql_user")->table($tbName)->get();
        return $result;
    }

    /**
     * 按照传入的规则排序并取出第一条
     * @param string $tbName 表名
     * @param string $field 排序的字段
     * @param string $way 排序的方式
     */
    public function getOrder($tbName, $field, $way) {
        $result = DB::connection("mysql_user")->table($tbName)->orderBy($field, $way)->first();
        return $result;
    }

    /**
     * 按照传入的规则排序并取出第一条
     * @param int $id 用户id
     * @param array $limit 
     */
    public function getLastLogin($id, $limit){
        return DB::table('loginhistory')->where('uid', $id)->orderBy('id', 'Desc')
        ->skip($limit[0])->take($limit[1])
        ->get(['cityId', 'ip', 'browser', 'loginMode', 'system', 'loginTime']);
    }

    /**
     * 检测城市代理商表(根据注册用户的手机号)
     * @param  $mobile   注册用户的手机号
     * @param  $id       注册用户的用户id
     */
    public function checkUserAgent($mobile,$id){
        DB::table('agent')->where('mobile',$mobile)->update(['uId' => $id]);
    }

    /**
     * 根据条件查询
     * @param $connection  链接条件
     * @param $tableName  表名
     * @param $where      查询条件  数组
     */
    public function getIdArrayByCondition($connection,$tableName,$where){
        return DB::connection($connection)->table($tableName)->where($where)->lists('id');
    }

    /**
     * 根据id删除表中数据
     * @param $tableName
     * @param $id
     * @return mixed
     */
    public function deleteTableDataById($tableName, $id)
    {
        return DB::table($tableName)->where('id',$id)->delete();
    }

    /**
     * 根据id删除表中数据
     * @param $tableName
     * @param $where
     * @return mixed
     */
    public function deleteTableById($tableName, $where)
    {
        return DB::connection('mysql_oldhouse')->table($tableName)->where($where)->delete();
    }

    /**
     * 根据用户id更改发布的房源的发布人类型
     * @param $tableName  表名
     * @param $ids        房源id数组
     * @param $update     修改的数据
     * @return mixed
     */
    public function updateHouseByUid($tableName, $ids, $update)
    {
        return DB::connection('mysql_oldhouse')->table($tableName)->whereIn('id',$ids)->update($update);
    }

    public function updateHouseImageType($tableName, $ids, $update)
    {
        return DB::connection('mysql_oldhouse')->table($tableName)->whereIn('houseId',$ids)->update($update);
    }

    /**
     * 查询预约刷新的数据
     * @param $uid
     */
    public function selectRefreshUserSetting($uid){
        return DB::connection('mysql_user')->table('refreshusersetting_operation')->where('uid',$uid)->first();
    }

    /**
     * 根据id更新用户的扩展表
     * @since 1.0
     * @author lixiyu
     * @param string $tableName 需要修改的表的表名
     * @param array $info 需要变更的信息 以键值对的形式 例：array( 字段名=>值 )
     * @param mix $id 修改的id
     * @return bool 成功返回true 失败返回false
     */
    public function upUserInfo($tableName, $info, $id) {
        $call = DB::connection("mysql_user")->table($tableName)->where('uId', $id)->update($info);
        return $call;
    }
    
}
