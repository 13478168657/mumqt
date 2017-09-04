<?php
namespace App\Dao\User;

use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Utils\ValidateUtil;
use App\Http\Controllers\Utils\UserIdUtil;
use Auth;

   /**
   * Description of UserDao
   * @author zhuwei
   */
class UserDao{
    
    /** 
     *  获取用户头像
     * @param $uid  用户ID
     *
     */
    
    public function getUserInfo($uid){
        $photo = DB::table('customers')->where('id',$uid)->get(['photo']);
        return $photo;
    }
    
    /**
     * 根据用户id查询用户数据
     */
    static public function getUserDataById($id){
    	$brokerObj = DB::connection('mysql_user')->table('users')->where('id', $id)->first();
    	return $brokerObj;
    }

    /**
     *  关注楼盘七天变化信息
     * @param  $type    1  新盘    2  二手盘
     * @param  $cid     楼盘id
     */
    public function getCommunityChangeInfo($cid){
        $info1 = DB::connection('mysql_house')
                ->table('communityperiods')
                ->where('communityId',$cid)
                ->get(['id','period']);
        if(!empty($info1)){
            $info2 = DB::connection('mysql_house')
                ->select("select detail,type,timeCreate from communityperiodslog where periodId = ? and cId = ? and ( type = 1 or type = 3 or type = 4 ) order by timeCreate desc",array($info1[0]->id,$cid));
        }else{
            $info2 = [];
        }
        return ['info1'=>$info1,'info2'=>$info2];
    }
    
    /**
     *  关注房源七天变化信息(价格变化)
     * @param $type    sale  出售    rent  出租
     * @param $table   表名
     * @param $houseType  房源类型
     */
    public function GetHousePrice($id,$type,$table,$houseType){
        if($type == 'sale'){
            $saleChange = DB::connection('mysql_statistics')->table($table)
                    ->where('houseId',$id)
                    ->where('type1',$houseType)
                    ->orderBy('changeTime','desc')
                    ->get(['price','changeTime']);           
            return $saleChange;
        }
        if($type == 'rent'){
            $rentChange = DB::connection('mysql_statistics')->table($table)
                    ->where('houseId',$id)
                    ->where('type1',$houseType)
                    ->orderBy('changeTime','desc')
                    ->get(['price','changeTime','type1']);           
            return $rentChange;
        }
    }
    
    /**
     *  关注房源七天变化信息(状态变化)
     * @param $type    1  出售    2  出租
     * @param $datebase   表示哪个数据库
     * @param $houseType  房源类型
     */
    public function GetHouseState($id,$type,$datebase,$houseType){
        if($type == 'sale'){
            $stateChange = DB::connection($datebase)
                       ->select('select state,dealState,timeUpdate from housesale where id = ? and houseType1 = ? ',array($id,$houseType));            
            return $stateChange;
        }
        if($type == 'rent'){
            $rentChange = DB::connection($datebase)
                       ->select('select state,dealState,timeUpdate from houserent where id = ? ',array($id));
            return $rentChange;
        }
    }
    /** 
     *  用户关注楼盘
     * @param $uid              用户id
     * @param $tableType        3 楼盘表
     * @param $start            开始行数
     * @param $take             取得数量
     * @return array  $commInfo  楼盘信息
     */
    public function GetCommInfo($uid,$tableType,$isNew,$start=0,$take=10){
        if($isNew == 'new'){
            $isNew = 1;
            $interComm = DB::connection('mysql_user')->table('userinterest')
                ->where('uid',$uid)
                ->where('isNew',$isNew)
                ->where('tableType','=',$tableType)
                ->where('is_del','=',0)
                ->take($take)
                ->skip($start)
                ->orderBy('createTime','desc')
                ->get(['interestId','type1','isNew']);
        }
        if($isNew == 'old'){
            $isNew = 0;
            $interComm = DB::connection('mysql_user')->table('userinterest')
                ->where('uid',$uid)
                ->where('isNew',$isNew)
                ->where('tableType','=',$tableType)
                ->where('is_del','=',0)
                ->take($take)
                ->skip($start)
                ->orderBy('createTime','desc')
                ->get(['interestId','type1','isNew']);
        }
        return $interComm;
    }

    /**
     *  用户关注楼盘的总数
     * @param $uid              用户id
     * @param $tableType        3 楼盘表
     * @param $isNew            0.二手盘 1.新盘'
     * @return
     */
    public function getInterCommunityTotal($uid,$tableType,$isNew){
        if($isNew == 'new'){
            $isNew = 1;
            $interComm = DB::connection('mysql_user')->table('userinterest')
                ->where('uid',$uid)
                ->where('isNew',$isNew)
                ->where('tableType','=',$tableType)
                ->where('is_del','=',0)
                ->orderBy('createTime','desc')
                ->lists('interestId');
        }
        if($isNew == 'old'){
            $isNew = 0;
            $interComm = DB::connection('mysql_user')->table('userinterest')
                ->where('uid',$uid)
                ->where('isNew',$isNew)
                ->where('tableType','=',$tableType)
                ->where('is_del','=',0)
                ->orderBy('createTime','desc')
                ->lists('interestId');
        }
        return count($interComm);
    }
    /**
     * 查询住宅  写字楼  商铺  是否都存在
     * @param    $uid     用户id
     */
    public function GetHouseType($uid){
        $houseType = DB::connection('mysql_user')->table('userinterest')->where('uid',$uid)->where('is_del',0)->where('tableType','<>',3)->lists('type1');
        return $houseType;
    }

    /** 
    * 用户关注房源信息
    * @param  $uid   用户的ID 
    * @param  $take  取出的数据条目
    * @return 房源基本信息 
    */  
    public function getInterHouseIds($uid,$type,$style,$start,$take){
        if($style == 'rent'){  // 出租
            $interHouse = DB::connection('mysql_user')->table('userinterest')
                            ->where('uid',$uid)
                            ->where('type1',$type)
                            ->where('tableType',1)
                            ->where('is_del',0)
                            ->take($take)
                            ->skip($start)
                            ->orderBy('createTime','desc')
                            ->lists('interestId');
                       // ->select('select interestId,isNew from userinterest where uid = ? and type1 = ? and tableType = 1 and is_del = 0 order by createTime desc limit ?,? ',array($uid,$type,$start,$take));

        }
        if($style == 'sale'){  // 出售
            $interHouse = DB::connection('mysql_user')->table('userinterest')
                            ->where('uid',$uid)
                            ->where('type1',$type)
                            ->where('tableType',2)
                            ->where('is_del',0)
                            ->take($take)
                            ->skip($start)
                            ->orderBy('createTime','desc')
                            ->lists('interestId');
                        //->select('select interestId,isNew from userinterest where uid = ? and type1 = ? and tableType = 2 and is_del = 0 order by createTime desc limit ?,? ',array($uid,$type,$start,$take));
        }
        return $interHouse;
    }
    /** 
    * ajax请求用户关注房源4条数据
    * @param  $uid   用户的ID 
    * @return 房源基本信息 
    */  
    public function getInterHouseTotal($uid,$type,$style){
        if($style == 'rent'){  // 出租
            $interHouse = DB::connection('mysql_user')->table('userinterest')
                ->where('uid',$uid)
                ->where('type1',$type)
                ->where('tableType',1)
                ->where('is_del',0)
                ->orderBy('createTime','desc')
                ->lists('interestId');

        }
        if($style == 'sale'){  // 出售
            $interHouse = DB::connection('mysql_user')->table('userinterest')
                ->where('uid',$uid)
                ->where('type1',$type)
                ->where('tableType',2)
                ->where('is_del',0)
                ->orderBy('createTime','desc')
                ->lists('interestId');
        }
        return count($interHouse);
    }

    /**
     *  查询房源数据
     * @param  $type    sale  出售， rent  出租
     * @param  $Ids     房源数组
     */
    public function getHouseDataByIds($type,$Ids){
        if($type == 'rent'){
            $select = ['id','title','communityId','thumbPic','address','price1','price2','houseType1','rentType','roomStr','totalFloor','currentFloor','area','faceTo','uid','fitment'];
            $house = DB::connection('mysql_oldhouse')->table('houserent')
                        ->whereIn('id',$Ids)
                        ->get($select);
        }
        if($type == 'sale'){
            $select = ['id','title','communityId','thumbPic','address','price1','price2','houseType1','roomStr','totalFloor','currentFloor','area','faceTo','uid','fitment'];
            $house = DB::connection('mysql_oldhouse')->table('housesale')
                        ->whereIn('id',$Ids)
                        ->get($select);
        }
        return $house;
    }

    /**
     * 查询楼盘名称
     * @param $cIds  楼盘id数组
     */
    public function getCommunityName($cIds){
        return DB::connection('mysql_oldhouse')->table('community')->whereIn('id',$cIds)->get(['id','name','address']);
    }

    /**
     * 查询经纪人名称
     * @param $brokerIds  经纪人id数组
     */
    public function getBrokerName($brokerIds){
        return DB::connection('mysql_user')->table('brokers')->whereIn('id',$brokerIds)->get(['id','realName','mobile']);
    }

    /**
     *  查询个人房源信息列表
     * @param  $type   rent  出租  sale 出售
     * @param  $table  表名
     * @param  $uId    用户id
     * @param  $field  字段
     */
    public function getPersonalHouseList($type, $uId, $field){
        if($type == 'sale'){
            $table = 'housesale';
        }
        if($type == 'rent'){
            $table = 'houserent';
        }
        $data = DB::connection('mysql_oldhouse')->table($table)
                    ->where('uid',$uId)
                    ->where('publishUserType','0')
                    ->orderBy('state','desc')
                    ->orderBy('timeUpdate','desc')
                    ->get($field);
        return $data;
    }

    /**
     * 查询用户发布房源的数量
     * @param $Uid
     * @param $table
     * @return mixed
     */
    public function searchHouseByUid($Uid,$table){
        return DB::connection('mysql_oldhouse')->table($table)->where('uid',$Uid)->where('publishUserType','0')->lists('id');
    }

    /**
     * 修改房源的状态
     * @param $hId    房源id
     * @param $data   修改的数据
     * @param $table  表名
     */
    public function updateHouseState($hId,$data,$table){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$hId)->update($data);
    }

    /**
     * 删除房源
     * @param $hId    房源id
     * @param
     * @param $table  表名
     */
    public function deleteHouse($hId,$table){
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$hId)->delete();
    }

}