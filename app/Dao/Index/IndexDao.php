<?php
namespace App\Dao\Index;
use DB;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/8
 * Time: 16:39
 */

class IndexDao{
    public function getModel($cityId){
//        $date=date('Y-m-d H:i:s');
//        return DB::connection('mysql_user')->table('agent')->where('cityId',$cityId)->where('inUse',1)->where('state',1)->where('startTime','<',$date)->where('endTime','>',$date)->first();
        return DB::connection('mysql_house')->table('city2model')->where('cityId',$cityId)->first();
    }
    public function getCommunityperiods($cityId,$page=3,$type1=3){
        return DB::connection('mysql_house')->select("select communityperiods.*,community.name,community.cityAreaId from communityperiods LEFT JOIN community on communityperiods.communityId=community.id where community.cityId='$cityId' AND (discountType <> 0 or discount <> 0 or subtract <> 0 or specialOffers <> '_') and marketingType <> 2  GROUP BY communityId ORDER BY period desc limit $page",[]);
    }
    public function getCityarea($cityId){
        return DB::connection('mysql_house')->table('cityarea')->where('cityId',$cityId)->get();
    }
    public function getAgentMobile($cityIds,$type){
        $date=date('Y-m-d H:i:s');
        return DB::connection('mysql_user')->table('agent')->whereIn('cityId',$cityIds)->where('inUse',1)->where('state',1)->where('startTime','<',$date)->where('endTime','>',$date)->where('type',$type)->get();
    }
    public function getNewCommunityImg($ids){
        return DB::connection('mysql_house')->table('communityimage')->whereIn('communityId',$ids)->where('type',10)->select(['id','communityId','fileName'])->get();
    }
    public function getNewCommunityArea($ids){
        return DB::connection('mysql_house')->table('cityarea')->whereIn('id',$ids)->select(['id','name'])->get();
    }
}