<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dao\Statistics;
use DB;
use App\Http\Controllers\Utils\TextUtil;
use App\Dao\City\CityDao;
/**
 * Description of SearchDao
 *
 * @author cjr
 */
class Communitystatus2Dao {

    /**
     * //统计指定楼盘的物业类型
     * @param $communityId
     * @param $type
     * @param $changeTime
     * @return array
     */
    function getHouseType($communityId,$type,$changeTime)
    {

        $typeData = DB::connection('mysql_statistics')
        ->table('communitystatus2')
        ->where('communityId', $communityId)
        ->where('cType1', 3)
       // ->where('type', $type)
        ->where('room','<>',0)
        ->where('changeTime','>=', $changeTime)
        ->orderBy('cType2','desc')
        ->distinct()
        ->select('cType2')
        ->get();
        $returnArr=array();
        foreach ($typeData as $item) {
            if (empty(TextUtil::GetCtype2Name($item->cType2))) {
                continue;
            }
            $returnArr[$item->cType2]=TextUtil::GetCtype2Name($item->cType2);
        }

        return $returnArr;

    }

    //取楼盘价格并分居室展示
    function getComPriceAllRoom($communityId,$cType2,$type,$changeTime,$room='-1',$new='0')
    {
        $tableName='communitystatus2';
        if ($new=='1') {
             $tableName='communitystatus';
        }
        $priceData = DB::connection('mysql_statistics')
        ->table($tableName)
        ->where('communityId', $communityId)
        ->where('cType2', $cType2)
        ->where('changeTime','>=', $changeTime)
        ->where('type', $type);
        if ($room=='-1') {
           $priceData->where('room','<>',0);
           $priceData->orderBy('room');
       }else
       {
         $priceData->where('room',$room);
     }

     $priceData->select('avgPrice','changeTime','room');


     $returnResults=$priceData->get();

     return $returnResults;
    }

    //取指定居室楼盘价格
    function getComPriceByRoom($communityId,$cType2,$type,$changeTime,$room)
    {
        $priceData = DB::connection('mysql_statistics')
        ->table('communitystatus2')
        ->where('communityId', $communityId)
        ->where('cType2', $cType2)
        ->where('type', $type)
        ->where('room',$room)
        ->where('changeTime','>=', $changeTime)
        ->select('avgPrice','changeTime','room')
        ->get();


        return $priceData;
    }




    //取商圈价格并分居室展示
    function getBsnPriceAllRoom($busnessid,$cType2,$type,$changeTime,$room='-1',$new='0')
    {
         $tableName='businessareastatus2';
        if ($new=='1') {
             $tableName='businessareastatus';
        }

        $priceData = DB::connection('mysql_statistics')
        ->table($tableName)
        ->where('businessareaId', $busnessid)
        ->where('cType2', $cType2)
        ->where('type', $type);
        if ($room=='-1') {
            $priceData->where('room','<>',0);
             $priceData->orderBy('room');
        }else
        {
             $priceData->where('room',$room);
        }
        $priceData->where('changeTime','>=', $changeTime);
        $priceData->select('avgPrice','changeTime','room');
        $results=$priceData->get();
        return $results;
    }

    //取商圈指定居室价格
    function getBsnPriceByRoom($busnessid,$cType2,$type,$changeTime,$room)
    {

        $priceData = DB::connection('mysql_statistics')
        ->table('businessareastatus2')
        ->where('businessareaId', $busnessid)
        ->where('cType2', $cType2)
        ->where('type', $type)
        ->where('room',$room)
        ->where('changeTime','>=', $changeTime)

        ->select('avgPrice','changeTime','room')
        ->get();
        return $priceData;
    }

    //取最近一个月的均价
    function getLastAveragePrice($communityId,$cType2,$type)
    {
        $averageData = DB::connection('mysql_statistics')
        ->table('communitystatus2')
        ->where('communityId', $communityId)
        ->where('cType2', $cType2)
        ->where('type', $type)
        ->where('room',0)
        ->orderBy('changeTime','desc')
        ->limit(10)
        ->select('avgPrice')
        ->get();
        return $averageData;


    }


    /**
     * //取指定城市最近12个月的均价
     * @param $cityid
     * @param $cType1 房屋类型
     * @param $type 出租出售
     * @return mixed
     */
    function getCityLastAveragePrice($cityid,$cType1,$type)
    {
        $averageData = DB::connection('mysql_statistics')
        ->table('citystatus2')
        ->where('cityId', $cityid)
        ->where('cType1', $cType1)
        ->where('type', $type)
        ->where('room',0)
        ->orderBy('changeTime','desc')
        ->limit(12)
        ->select('avgPrice')
        ->get();//dd($averageData);
        return $averageData;
    }

    /**
     * 获取指定城市最近12个月的均价
     * @param $cityid
     * @param $cType1 房屋类型
     * @param $type 出租出售
     * @return mixed
     */
    function getCityAveragePrice($cityid,$cType1,$type)
    {
        $averageArr = DB::connection('mysql_statistics')
            ->table('citystatus2')
            ->where('cityId', $cityid)
            ->where('cType1', $cType1)
            ->where('type', $type)
            ->where('room',0)
            ->where('changeTime','>=',date('Ym',strtotime('-12 month')))
            ->where('changeTime','<',date('Ym',time()))
            ->groupBy('changeTime')
            ->select('changeTime',DB::raw('AVG(avgPrice) as price'))//->toSql();
            ->get();
        //取查询结果值并计算均价
        $newArr=[];
        $averagePrice=0;
        if($averageArr){
            foreach ($averageArr as $v){
                $newArr[$v->changeTime]=intVal($v->price);
                $averagePrice+=$v->price;
            }
            $averagePrice=intVal($averagePrice/count($newArr));
        }
        return $averagePrice;
    }

    /**
     * 获取指定城市最近12个月的均价和详细数据
     * @param $cityid
     * @param $cType1 房屋类型
     * @param $type 出租出售
     * @return mixed
     */
    function getCityAveragePrice1($cityid,$cType1,$type)
    {
        $averageArr = DB::connection('mysql_statistics')
            ->table('citystatus2')
            ->where('cityId', $cityid)
            ->where('cType1', $cType1)
            ->where('type', $type)
            ->where('room',0)
            ->where('changeTime','>=',date('Ym',strtotime('-12 month')))
            ->where('changeTime','<',date('Ym',time()))
            ->groupBy('changeTime')
            ->select('changeTime',DB::raw('AVG(avgPrice) as price'))//->toSql();
            ->get();
        //取查询结果值并计算均价
        $newArr=[];
        $averagePrice=0;
        if($averageArr){
            foreach ($averageArr as $v){
                $newArr[$v->changeTime]=intVal($v->price);
                $averagePrice+=$v->price;
            }
            $averagePrice=intVal($averagePrice/count($newArr));
        }
        $returnArr=$this->priceArrFill($newArr);
        return $returnArr;
    }

    /**
     * 获取指定城市所有区域上个月的均价
     * @param $cityId
     * @param $cType1 房屋类型
     * @param $type 出租出售
     * @return mixed
     */
    function getAreaAveragePrice($cityId,$cType1,$type)
    {
        $cityDao=new CityDao();
        $result=$cityDao->selectCityArea($cityId);
        $cityAreaIdArr=[];
        $cityGPS=[];
        foreach($result as $v){
            $cityAreaIdArr[]=$v->id;
            $cityGPS[$v->id]=[$v->longitude,$v->latitude,$v->name];
        }
        $averagePrice = DB::connection('mysql_statistics')
            ->table('cityareastatus2')
            ->whereIn('cityareaId', $cityAreaIdArr)
            ->where('cType1', $cType1)
            ->where('type', $type)
            ->where('room',0)
            ->where('changeTime','=',date('Ym',strtotime('-1 month')))
            ->groupBy('cityareaId')
            ->select('cityareaId','avgPrice')//->toSql();
            ->get();
        $returnArr=[];
        if($averagePrice){
            foreach ($averagePrice as $v){
                $returnArr[]=[(float)$cityGPS[$v->cityareaId][0],(float)$cityGPS[$v->cityareaId][1],$v->avgPrice];
            }
        }
        $returnArr=json_encode($returnArr,JSON_UNESCAPED_SLASHES);
        //dd($returnArr);
        return $returnArr;
    }

    /**
     * ajax获取指定城市指定区域上个月的均价
     * @param $cityId
     * @param $cType1 房屋类型
     * @param $type 出租出售
     * @return mixed
     */
    function getAreaAveragePrice2($cityId,$cType1,$type)
    {
        $cityDao=new CityDao();
        $result=$cityDao->selectCityArea($cityId);
        $cityAreaIdArr=[];
        $cityGPS=[];
        foreach($result as $v){
            $cityAreaIdArr[]=$v->id;
            $cityGPS[$v->id]=[$v->longitude,$v->latitude,$v->name];
        }
        $averagePrice = DB::connection('mysql_statistics')
            ->table('cityareastatus2')
            ->whereIn('cityareaId', $cityAreaIdArr)
            ->where('cType1', $cType1)
            ->where('type', $type)
            ->where('room',0)
            ->where('changeTime','=',date('Ym',strtotime('-1 month')))
            ->groupBy('cityareaId')
            ->select('cityareaId','avgPrice')//->toSql();
            ->get();
        $returnArr=[];
        if($averagePrice){
            foreach ($averagePrice as $v){
                $returnArr[]=[
                    (float)$cityGPS[$v->cityareaId][0],
                    (float)$cityGPS[$v->cityareaId][1],
                    $cityGPS[$v->cityareaId][2],
                    $v->avgPrice];
            }
        }
        //dd($returnArr);
        return $returnArr;
    }
    
    /**
     * 获取指定月份城市均价
     * @param $cityid
     * @param $cType1
     * @param $type
     * @param $month
     * @return int
     */
    public function getCityAvgPriceByMonth($cityid,$cType1,$type,$month){
        $result = DB::connection('mysql_statistics')
            ->table('citystatus2')
            ->where('cityId', $cityid)
            ->where('cType1', $cType1)
            ->where('type', $type)
            ->where('room',0)
            ->where('changeTime','=',$month)
            ->groupBy('changeTime')
            ->select(DB::raw('AVG(avgPrice) as price'))//->toSql();
            ->first();
        $return=$result?$result->price:0;
        return $return;
    }



    /**
     * 取二手楼盘历史价格(楼盘详情页用)
     * @param $communityId
     * @param $cType2 物业类型（副）：\r\n101.商铺-住宅底商\r\n102.商铺-商业街商铺\r\n103.......
     * @param $type '1.出租 2.出售',
     * @param $room  '户型，0：不区分居室；1：一居；2：二居；3：三居……',
     * @param $changeTime  '调价时间（每月统计一次）例：201511',
     * @param bool $beOld 是否二手房
     * @return mixed
     */
    function getHistoricalPrices($communityId,$cType2,$type,$room,$changeTime,$beOld=true)
    {
     $tableName='communitystatus2';
     if (!$beOld) {
        $tableName='communitystatus';
    }
    $priceData = DB::connection('mysql_statistics')
    ->table($tableName)
    ->where('communityId', $communityId)
    ->where('cType2', $cType2)
    ->where('type', $type)
    ->where('room', $room)
    ->where('changeTime','>=', $changeTime)
    ->orderBy('changeTime','asc')
    ->select('avgPrice','changeTime')
    ->get();

    return $priceData;
    }



    /**
     * 获取环比同比月份价格
     * @param $communityId
     * @param $cType2 物业类型（副）：\r\n101.商铺-住宅底商\r\n102.商铺-商业街商铺\r\n103.......
     * @param $type  '1.出租 2.出售'
     * @param $room  '户型，0：不区分居室；1：一居；2：二居；3：三居……'
     * @param $changeTime  '调价时间（每月统计一次）例：201511'
     * @param bool $beOld 是否二手房
     * @return mixed
     */
    function getComparePrices($communityId,$cType2,$type,$room,$curMonth,$preMonth,$lastYear,$beOld=true)
    {
        $tableName='communitystatus2';
        if (!$beOld) {
            $tableName='communitystatus';
        }
        $priceData = DB::connection('mysql_statistics')
            ->table('communitystatus2')
            ->where('communityId', $communityId)
            ->where('cType2', $cType2)
            ->where('type', $type)
            ->where('room', $room)
            ->whereIn('changeTime',[$curMonth,$preMonth,$lastYear])
            ->orderBy('changeTime','asc')
            ->select('avgPrice','changeTime')
            ->get();
        $data=[];
        if($priceData){
            foreach ($priceData as $v){
                $data[$v->changeTime]=$v->avgPrice;
            }
        }
        return $data;
    }

    //取商圈二手楼盘历史价格
    function getBusnessHistoricalPrices($cType2,$type,$businessareaId,$changeTime,$beOld=true)
    {
        $tableName='businessareastatus2';
        if (!$beOld) {
            $tableName='businessareastatus';
        }
        $busnessData=DB::connection('mysql_statistics')
        ->table($tableName)
        ->where('cType2', $cType2)
        ->where('type', $type)
        ->where('businessareaId', $businessareaId)
        ->where('changeTime','>=', $changeTime)
        ->orderBy('changeTime','desc')
        ->select('avgPrice','changeTime')
        ->get();

        return $busnessData;
    }

    //取城区二手楼盘历史价格
    function getAreaHistoricalPrices($cityareaId,$type,$cType2,$changeTime,$beOld=true)
    {
        $tableName='cityareastatus2';
        if (!$beOld) {
            $tableName='cityareastatus';
        }
        $areaData=DB::connection('mysql_statistics')
        ->table($tableName)
        ->where('cityareaId', $cityareaId)
        ->where('type', $type)
        ->where('cType2', $cType2)
        ->where('changeTime','>=', $changeTime)
        ->orderBy('changeTime','asc')
        ->select('avgPrice','changeTime')
        ->get();

        return $areaData;
    }

    //取城市二手楼盘历史价格
    function getCityHistoricalPrices($cityId,$type,$cType2,$changeTime,$beOld=true)
    {
       $tableName='citystatus2';
       if (!$beOld) {
        $tableName='citystatus';
    }
    $cityData=DB::connection('mysql_statistics')
    ->table('citystatus2')
    ->where('cityId', $cityId)
    ->where('type', $type)
    ->where('cType2', $cType2)
    ->where('changeTime','>=', $changeTime)
    ->orderBy('changeTime','asc')
    ->select('avgPrice','changeTime')
    ->get();
    return $cityData;
    }


    //取楼盘各居室出租历史价格,暂时不用
    function getCommunityRentPrice($communityId,$cType2,$changeTime,$beOld=true)
    {
        $tableName='communitystatus2';
        if (!$beOld) {
            $tableName='communitystatus';
        }
        $priceData = DB::connection('mysql_statistics')
        ->table('communitystatus2')
        ->where('communityId', $communityId)
        ->where('cType2', $cType2)
        ->where('type', 1)
       // ->where('room', $room)
        ->where('changeTime','>=', $changeTime)
        ->orderBy('room','asc')
        ->orderBy('changeTime','asc')

        ->select('avgPrice','changeTime','room')
        ->get();
        //->toSql();

        return $priceData;
    }


     //取商圈出租历史价格,暂时不用
    function getBusnessRentPrice($cType2,$businessareaId,$changeTime,$beOld=true)
    {
        $tableName='businessareastatus2';
        if (!$beOld) {
            $tableName='businessareastatus';
        }
        $busnessData=DB::connection('mysql_statistics')
        ->table($tableName)
        ->where('cType2', $cType2)
        ->where('type',1)
        ->where('businessareaId', $businessareaId)
        ->where('changeTime','>=', $changeTime)
        ->orderBy('room','asc')
        ->orderBy('changeTime','asc')
        ->select('avgPrice','changeTime','room')
        ->get();

        return $busnessData;
    }

    /**
     * 取二手楼盘历史价格(查房价列表页用)
     * @param $communityId
     * @param $cType1 物业类型（副）：\r\n101.商铺-住宅底商\r\n102.商铺-商业街商铺\r\n103.......
     * @param $type '1.出租 2.出售',
     * @param $room  '户型，0：不区分居室；1：一居；2：二居；3：三居……',
     * @param $changeTime  '调价时间（每月统计一次）例：201511',
     * @param bool $beOld 是否二手房
     * @return mixed
     */
    function getComHistoricalPrices($communityId,$cType1,$type,$room,$changeTime,$beOld=true)
    {
        $tableName='communitystatus2';
        if (!$beOld) {
            $tableName='communitystatus';
        }
        $priceData = DB::connection('mysql_statistics')
            ->table($tableName)
            ->where('communityId', $communityId)
            ->where('cType1', $cType1)
            ->where('type', $type)
            ->where('room', $room)
            ->where('changeTime','>=', $changeTime)
            ->groupBy('changeTime')
            ->orderBy('changeTime','asc')
            ->select(DB::raw('avg(avgPrice) as avgPrice'),'changeTime')
            //->toSql();
            ->get();
        //dd($priceData);
        $newArr=[];
        if($priceData){
            foreach ($priceData as $v){
                $newArr[$v->changeTime]=intVal($v->avgPrice);
            }
        }
        $priceData=$this->priceArrFill($newArr);
        //return $newArr;
        //dd($priceData);
        return $priceData;
    }

    /**
     * 填充缺少月份的值,缺少月份使用上个月值,首月无值用0
     * @param $array
     * @return array
     */
    protected function priceArrFill($array){
        $newArr=[];//dd($array);
        for($i=-12;$i<0;$i++){
            $month=date('Ym',strtotime("$i month"));
            if(array_key_exists($month,$array) && $array[$month]){
                $newArr[$month]=$array[$month];
            }else{
                if($i==-12){
                    $newArr[$month]=0;
                }else{
                    $index=$i-1;
                    $newArr[$month]=$newArr[date('Ym',strtotime("$index month"))];
                }
            }
        }
        ksort($newArr);
        $xAxisStr=array_keys($newArr);
        $seriesStr=array_values($newArr);
        $returnArr[]=$xAxisStr;
        $returnArr[]=$seriesStr;
        //dd($returnArr);
        return $returnArr;
    }

}
