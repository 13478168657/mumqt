<?php
namespace App\Dao\Enterprise;

use DB;

/**
   * Description of EnterpriseDao
   *   企业店铺
   * @author zhuwei
   */
class EnterpriseDao{
    
    /**
   *   获得企业店铺信息
   * @param   $type  图片分类
   * @param   $enterpriseId   企业id
   * @return  $enterData  企业店铺的相关数据
   */
    public function GetEnterpriseInfo($enterpriseId){
        $enterpriseInfo = DB::connection('mysql_user')
                ->table('enterpriseshop')
                ->where('id',$enterpriseId)
                ->get(['id','provinceId','cityId','companyName','brokerTotal','communityTotal','logo','focusCommIds','allCommIds','intro']);
        return $enterpriseInfo;
    }
    /**
     *  获取企业店铺中楼盘图片数据
     * @param array  $commIds   楼盘id数组
     * @param  int   $type      图片的类型
     * @return array  $communityImage  楼盘图片数组
     */
    public function GetEnterCommImage($commIds,$type){
        $communityImage = DB::connection('mysql_house')
                         ->table('communityimage')
                         ->where('type',$type)
                         ->whereIn('communityId', $commIds)
                         ->groupBy('communityId')
                         ->get(['id','communityId','fileName','type']);
       
        return $communityImage;
    }
    /**
     *  查询环线信息
     * @param    $id    环线id
     */
    public function GetLoopLine($id){        
        $loopName = DB::connection('mysql_house')
                ->table('loopline')
                ->where('id',$id)
                ->pluck('name');
        return $loopName;
    }
    /**
     *  关于我们页面数据
     * @param    $commId   楼盘的id
     */
    public function GetCommunityState($commId){  
        $stateInfo = DB::connection('mysql_house')
                ->table('communityperiods')
                ->where('communityId',$commId)
                ->orderBy('period','desc')
                ->take(1)
                ->get(['communityId','period','salesStatus']);
        return $stateInfo;
    }
}