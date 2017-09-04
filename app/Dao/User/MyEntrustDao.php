<?php
namespace App\Dao\User;
use DB;
use App\Http\Controllers\Utils\ValidateUtil;
use App\Http\Controllers\Utils\UserIdUtil;
use Auth;

/**
 * description of MyEntrustDao 
 * @since 1.0
 * @author zhuwei
 */

class MyEntrustDao{
    
    /**
     * 房源信息录入页面标签信息
     * @param  $table  要查询的表名
     * @param  $type   对应tag表的type字段
     */
    public function getHouseTagsByType($type){
        $db = DB::connection('mysql_house')->table('tag');
        if(is_array($type)){
            $db->whereIn('type',$type);
        }else{
            $db->where('type',$type);
        }
        $data = $db->get(['id','name','type']);
        return $data;
    }

    /**
     * 查询自定义标签是否重复
     * @param $diyNames
     */
    public function checkDiyTagsByArrayName($diyNames){
        $diyTags = DB::connection('mysql_house')->select("select min(id) id,name from tagdiy where name in ($diyNames) group by name");
        $tagsName = [];
        if(!empty($diyTags)){
            foreach($diyTags as $diy){
                $tagsName[$diy->name] = $diy;
            }
        }
        return $tagsName;
    }

    /**
     * 获得自定义标签的名称
     * @param $diyId
     */
    public function getDiyTagNameByArrayId($diyId){
        return DB::connection('mysql_house')->table('tagdiy')->whereIn('id',$diyId)->lists('name');
    }

    /**
     * 插入数据返回id
     * @param   $connection  链接的库
     * @param   $table    表名
     * @param   $data     插入的数据
     */
    public function insertDataReturnId($connection,$table,$data){
        return DB::connection($connection)->table($table)->insertGetId($data);
    }

    /**
     * 插入数据
     * @param   $connection  链接的库
     * @param   $table    表名
     * @param   $data     插入的数据
     */
    public function insertData($connection,$table,$data){
        return DB::connection($connection)->table($table)->insert($data);
    }

    /**
     * 根据手机号查询用户信息是否存在
     * @param  $mobile   用户手机号
     */
    public function searchUserByMobile($mobile){
        $data = DB::table('users')->where('mobile',$mobile)->first();
        return $data;
    }

    /**
     * 查询房源的详细信息
     * @param $Id       房源id
     * @param $field    要查询的字段
     * @param $table    表名
     */
    public function getHouseDetailDataById($Id, $field, $table){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$Id)->get($field);
    }

    /**
     * 查询房源的其他信息
     * @param $Id
     * @param
     */
    public function getHouseOtherById($Id){
        return DB::connection('mysql_oldhouse')->table('housesaleext')->where('hId',$Id)->get();
    }

    /**
     * 查询房源图片信息
     * @param $Id    房源id
     * @param $table 表名
     */
    public function getHouseImage($Id, $table){
        return DB::connection('mysql_oldhouse')->table($table)->where('houseId',$Id)->get(['id','fileName']);
    }

    /**
     * 获得楼盘名称
     * @param $communityId
     */
    public function getCommunityNameById($communityId){
        return DB::connection('mysql_oldhouse')->table('community')->where('id',$communityId)->pluck('name');
    }

    /**
     * 修改数据
     * @param $connection   连接的数据库
     * @param $table        表名
     * @param $data         更改的数据
     * @param $hId          房源id
     */
    public function updateHouseData($connection,$table,$data,$hId){
        if($table == 'housesaleext'){
            return DB::connection($connection)->table($table)->where('hId',$hId)->update($data);
        }else{
            return DB::connection($connection)->table($table)->where('id',$hId)->update($data);
        }

    }

    /**
     * 修改房源其他数据
     * @param $connection   连接的数据库
     * @param $table        表名
     * @param $data         更改的数据
     * @param $hId          房源id
     */
    public function updateHouseOtherData($connection,$table,$data,$hId){
        return DB::connection($connection)->table($table)->where('hId',$hId)->update($data);
    }

    /**
     * 删除图片
     * @param $table   表名
     * @param $Ids     图片id数组
     */
    public function delHouseImage($table,$Ids){
        return DB::connection('mysql_oldhouse')->table($table)->whereIn('id',$Ids)->delete();
    }

    /**
     * 查询出租、出售委托记录表
     * @param $table  表名
     * @param $uId    用户id
     */
    public function entrustTypeSearch($table,$uId){
        return DB::connection('mysql_oldhouse')->table($table)->where('uId',$uId)->lists('hId');
    }

    /**
     * 根据委托用户id查询委托房源的具体信息
     * @param $table  表名
     * @param
     * @param $field  查询的字段
     * @param #$uId   用户id
     */
    public function getEntrustHouseDetail($table,$field,$uId){
        return DB::connection('mysql_oldhouse')->table($table)->where('uid',$uId)->orderBy('timeUpdate','desc')->get($field);
    }

    /**
     * 根据委托房源id查询委托的具体信息
     * @param $table  表名
     * @param $field  查询的字段
     * @param $hwId   委托房源id
     */
    public function getEntrustHouseDetailByhwId($table,$field,$hwId){
        return DB::connection('mysql_oldhouse')->table($table)->where('hwId',$hwId)->where('status',1)->get($field);
    }

    /**
     * 获得房源对应的楼盘数据
     * @param $communityId  楼盘id数组
     */
    public function getCommunityDataByIdArray($communityId){
        return DB::connection('mysql_oldhouse')->table('community')->whereIn('id',$communityId)->get(['id','name','address']);
    }

    //求租求购查询
    public function rentSaleWanted($table,$uid,$select,$pageset){
        return DB::connection('mysql_oldhouse')->table($table)->where('uid',$uid)->select($select)->paginate($pageset);
    }
    //根据id求租求购查询
    public function rentSaleWantedById($table,$select,$id){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$id)->select($select)->first();
    }
    //求租求购删除
    public function rentSaleWanteDel($table,$id){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$id)->delete();
    }
    //插入求租求购信息
    public function insertRentSaleWanted($table,$data){
        return DB::connection('mysql_oldhouse')->table($table)->insert($data);
    }
    //更新求租求购信息
    public function updateRentSaleWanted($table,$data,$id){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$id)->update($data);
    }
    //根据求租求购id查询数据
    public function getWantedDataById($table,$id){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$id)->first();
    }

    /**
     * 查询出租出售委托记录表中的信息
     * @param $table     表名
     * @param $id        房源id
     * @param $uId       用户id
     */
    public function getEntrustBrokerIdList($table,$id,$uId){
        return DB::connection('mysql_oldhouse')->table($table)->where('hId',$id)->where('uId',$uId)->where('status','1')->lists('brokerId');
    }

    /**
     * 更改委托记录表中的状态
     * @param $bId    经纪人id
     * @param $hId    房源id
     * @param $table  表名
     * @param $type   分类
     */
    public function updateHouseState($bId,$hId,$table,$type){
        if(in_array($type,['Qz','Qs'])){
            return DB::connection('mysql_oldhouse')->table($table)->where('hwId',$hId)->where('brokerId',$bId)->update(['status' => '0']);
        }
        if(in_array($type,['rent','sale'])){
            return DB::connection('mysql_oldhouse')->table($table)->where('hId',$hId)->where('brokerId',$bId)->update(['status' => '0']);
        }
    }

    /**
     * 委托信息表中的认领人数自减一
     * @param $hId
     * @param $table
     * @param
     */
    public function updateEntrustClaimNum($hId,$table){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$hId)->decrement('hadCommissioned');
    }

    /**
     * 更改委托信息表中的认领人数
     * @param $hId
     * @param $table
     * @param
     */
    public function updateEntrustClaim($hId,$table,$data){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$hId)->update($data);
    }

    /**
     * 删除委托记录表的信息
     * @param $hId    房源id
     * @param $table  表名
     * @param $type   分类
     */
    public function deleteEntrustDelegate($hId,$table,$type){
        if(in_array($type,['Qz','Qs'])){
            return DB::connection('mysql_oldhouse')->table($table)->where('hwId',$hId)->delete();
        }
        if(in_array($type,['rent','sale'])){
            return DB::connection('mysql_oldhouse')->table($table)->where('hId',$hId)->delete();
        }
    }

}