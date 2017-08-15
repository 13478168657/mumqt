<?php
/**
 * 
 */
namespace App\Dao\User;

use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
/**
 * 
 * 关注房源操作类
 * @author JohnYoung
 *
 */
class FollowDao
{

    /**
     * 获取关注的房源
     * 
     * @param array $houseArr
     */
    public function getFollowHouseList(Array $houseArr)
    {}

    /**
     * 获取关注的楼盘信息
     * 
     * @param array $comArr
     */
    public function getFollowCommunityList(Array $comArr)
    {}
    
    /**
     * 获取楼盘下的新房源
     * 
     * @param array $comArr
     */
    public function getCommunityNewHouseList(Array $comArr)
    {}
    
    /**
     * 
     * @param array $comArr ['cid'=$value, 'time'=$value]
     * @return string
     */
    public function getCommunityNewHouseCount(Array $comArr) {
        $json = '{"s":1,"r":[{"cid":'.$comArr['cid'].',"count":5}]}';
        return $json;
    }
    
    public function getHouseChangePriceCount(Array $houseArr) {
        ;
    }


    /**
    * 检测用户是否关注过些房源 or 楼盘
    * @author lixiyu
    * @param array $gz 关注信息
    */
    public function check_Follow( $gz )
    {
        return DB::connection('mysql_user')->table('userinterest')->where($gz)->get(['id', 'is_del']);
    }

    /**
    * 新增用户关注房源 or 楼盘 信息
    * @author lixiyu
    * @param array $gz 关注信息
    */
    public function insert_Follow( $gz )
    {
        return DB::connection('mysql_user')->table('userinterest')->insert($gz);
    }

    /**
    * 修改新增用户关注房源 or 楼盘 信息
    * @author lixiyu
    * @param array $gz 关注信息
    * @param int $id  关注Id
    */
    public function update_Follow( $gz , $id)
    {
        return DB::connection('mysql_user')->table('userinterest')->where('id', $id)->update($gz);
    }

    /**
     * 按条件查询出用户所关注的楼盘或房源
     * @param array $where  
     */
    public function get_Follow($where){
//        //$temp_where=implode('*',$where);
//        $temp_where='';
//        foreach($where as $k => $v){
//            $temp_where .= $k.'_'.$v.'_';
//        }
//        $temp_where=rtrim($temp_where,'_');
//        $key='DB_mysql_user_get_Follow_'.$temp_where;
//        Redis::connect(config('database.redis.default.host'), 6379);
//        Redis::select(6);  // 选择6号库  
//    
////         dd($key);
//        $time=30*60;
//        if(Redis::exists($key)){
//            $result=unserialize(Redis::get($key));
//        }else{
            $result=DB::connection('mysql_user')->table('userinterest')->where($where)->get(['interestId', 'type1']);
//            Redis::set($key,serialize($result));
//            Redis::expire($key,$time);
//        }
        return $result;
    }

}