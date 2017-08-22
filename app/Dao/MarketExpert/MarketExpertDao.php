<?php

namespace App\Dao\MarketExpert;

use DB;
use Auth;
/*********
* 置业专家Dao
 * 
 * 
 * *********/


class MarketExpertDao{
    
    /*******
     * 
     * 获得Market_expert置业专家的信息,特定的rent或sale
     * ******/
    
    public function getSubtypeMarketExpert($communityId,$subtype = 'rent'){
        //return DB::connection('mysql_oldhouse')->table('market_expert')->where('saleRentType',$subtype)->where('communityId',$communityId)->get();
        $time=date('Ymd');
        return DB::connection('mysql_marketing')
                ->table('log_expert')
//                ->where('saleRentType',$subtype)
                ->where('communityId',$communityId)
                ->where('startTime','<=',$time)
                ->where('lastTime','>=',$time)
                ->where('state',1)
                ->orderBy('position','asc')
                ->get();
    }
    
    /*******
     * 
     * 获得Market_expert置业专家的信息
     * ******/
    
    public function getMarketExpert($communityId){
        //return DB::connection('mysql_oldhouse')->table('market_expert')->where('saleRentType',$subtype)->where('communityId',$communityId)->get();
        $time=date('Ymd');
        return DB::connection('mysql_marketing')
                ->table('log_expert')
                ->where('communityId',$communityId)
                ->where('startTime','<=',$time)
                ->where('lastTime','>=',$time)
                ->where('state',1)
                ->orderBy('position','asc')
                ->get();
    }
    /*******
     * 查询房源信息
     * *******/
    public function searchHouseById($id,$type='rent'){
        $table='house'.$type;
        return DB::connection('mysql_oldhouse')->table($table)->where('id',$id)->where('state',1)->first();
    }
    
    /****
     * 获得经纪人信息
     * *****/
    public function getbrokerInfo($brokerId){
         return DB::connection("mysql_user")->table('brokers') ->where('brokers.id',$brokerId)->first();
    }
}
