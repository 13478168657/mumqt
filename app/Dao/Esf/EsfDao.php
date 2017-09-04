<?php

namespace App\Dao\Esf;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
 * description of resold apartment 二手房楼房信息描述
 * @since 1.0
 * @author liyang
 */
class EsfDao {

    /**
    | 二手楼盘主页DAO
    */
    
    /**
	* 查询楼盘的主物业类型
	* @param int $communityId 楼盘id
	* @author   zhuwei
        * @date    2016/02/27   11:53:30 
	*/
    public function getCommunityType($communityId){
        if(!Cache::has('getCommunityType_'.$communityId)){
            $type = DB::connection('mysql_oldhouse')
                ->table('community')
                ->where('id',$communityId)
                ->pluck('type1');
            Cache::put('getCommunityType_'.$communityId,$type,60*24*30);
        }else{
            $type =  Cache::get('getCommunityType_'.$communityId);
        }
        return $type;
    }

    /**
    * 查询楼盘信息
    * @param int $communityId 楼盘id
    * @param int $type2 楼盘当前的副物业类型
    */
    public function getCommunity($communityId,$type2) {
        if(!Cache::has('getCommunity_'.$communityId.'_'.$type2)){
            $result = DB::connection('mysql_oldhouse')
                    ->table('community')
                    ->where('id',$communityId)
                    ->select('id','name', 'cityId','cityAreaId','businessAreaId','address','propertyCompanyId','developerId','propertyAddress','type1','longitude','latitude','type'.$type2.'Info')
                    ->get();
            Cache::put('getCommunity_'.$communityId.'_'.$type2,$result,60*24*30);
        }else{
            $result =  Cache::get('getCommunity_'.$communityId.'_'.$type2);
        }
        return $result;
        
        /*return DB::connection('mysql_oldhouse')
        ->table('community')
        ->where('id',$communityId)
        ->select('id','name', 'cityId','cityAreaId','businessAreaId','address','propertyCompanyId','developerId','propertyAddress','type1','longitude','latitude','type'.$type2.'Info')
        ->get();*/
    }

    /**
    * 查询项目特色
    * @param array $tagIds 标签id
    * +-----------------------+
    * | 查询type2下的项目特色 |
    * +-----------------------+
    */
    public function getTagName($tagIds) {   
        return DB::connection('mysql_house')
        ->table('tag')
        ->whereIn('id',$tagIds)
        ->select('id','name')
        ->get();
    }

    /**
    * 查询物业公司
    * @param int $propertyCompanyId 物业公司id
    */
    public function getPropertyName($propertyCompanyId) {
        Cache::pull('getPropertyName_'.$propertyCompanyId);
        if(!Cache::has('getPropertyName_'.$propertyCompanyId)){
            $result = DB::connection('mysql_house')
                    ->table('propertycompany')
                    ->where('id',$propertyCompanyId)
                    ->select('companyname','phone')
                    ->get();
            Cache::put('getPropertyName_'.$propertyCompanyId,$result,60*24*30);
        }else{
            $result =  Cache::get('getPropertyName_'.$propertyCompanyId);
        }
        return $result;
        
        /*return DB::connection('mysql_house')
        ->table('propertycompany')
        ->where('id',$propertyCompanyId)
        ->select('companyname')
        ->get();*/
    }

    /**
    * 查询开发商
    * @param int $developerId 开发商id
    */
    public function getDevelopersName($developerId) {
        if(!Cache::has('getDevelopersName_'.$developerId)){
            $result = DB::connection('mysql_house')
                    ->table('developers')
                    ->where('id',$developerId)
                    ->select('companyname')
                    ->get();
            Cache::put('getDevelopersName_'.$developerId,$result,60*24*30);
        }else{
            $result =  Cache::get('getDevelopersName_'.$developerId);
        }
        return $result;
       /* return DB::connection('mysql_house')
        ->table('developers')
        ->where('id',$developerId)
        ->select('companyname')
        ->get();*/
    }

    /**
    * 查询楼盘楼栋表
    * @param $communityId 楼盘id
    */
    public function getCommBuild($communityId) {
        if(!Cache::has('getCommBuild_'.$communityId)){
            $result = DB::connection('mysql_oldhouse')
                    ->table('communitybuilding')
                    ->where('communityId',$communityId)
                    ->select('id','num','openTime','takeTime','unitTotal','floorTotal','houseTotal','liftHouseRatio','coordinateX','coordinateY')
                    ->get();
            Cache::put('getCommBuild_'.$communityId,$result,60*24*30);
        }else{
            $result =  Cache::get('getCommBuild_'.$communityId);
        }
        return $result;
        /*return DB::connection('mysql_oldhouse')
        ->table('communitybuilding')
        ->where('communityId',$communityId)
        ->select('id','num','openTime','takeTime','unitTotal','floorTotal','houseTotal','liftHouseRatio','coordinateX','coordinateY')
        ->get();*/
    }

    /**
    * 查询楼盘的户型信息
    * @param $communityId 楼盘id
    */
    public function getCommRoom($communityId) {
        if(!Cache::has('getCommRoom_'.$communityId)){
            $result = DB::connection('mysql_oldhouse')
                    ->table('communityroom')
                    ->where('communityId',$communityId)
                    ->select('id','name','cbIds','communityId','thumbPic','room','hall','toilet','kitchen','balcony','floorage')
                    ->get();
            Cache::put('getCommRoom_'.$communityId,$result,60*24*30);
        }else{
            $result =  Cache::get('getCommRoom_'.$communityId);
        }
        return $result;
        /*return DB::connection('mysql_oldhouse')
        ->table('communityroom')
        ->where('communityId',$communityId)
        ->select('id','name','cbIds','communityId','thumbPic','room','hall','toilet','kitchen','balcony','floorage')
        ->get();*/
    }

    /**
    * 图片查询
    * @param int $communityId 楼盘id
    * @param int $type 图片类型
    * -------------------------------
    * 1.交通图 2.实景图 3.效果图
    * 4.样板间 6.配套图 7.施工进度图
    * 8.规划图
    * -----------------------------
    */
    /*public function getCommImg($communityId,$type) {
        if(!Cache::has('getCommImg_'.$communityId.'_'.$type)){
            $result = DB::connection('mysql_oldhouse')
                    ->table('communityimage')
                    ->where('communityId',$communityId)
                    ->where('type',$type)
                    ->select('id','communityId','type','fileName')
                    ->get();
            Cache::put('getCommImg_'.$communityId.'_'.$type,$result,60*24*30);
        }else{
            $result =  Cache::get('getCommImg_'.$communityId.'_'.$type);
        }
        return $result;
        
        return DB::connection('mysql_oldhouse')
        ->table('communityimage')
        ->where('communityId',$communityId)
        ->where('type',$type)
        ->select('id','communityId','type','fileName')
        ->get();
    }*/

    /**
    * 查询城市区域
    * @param $cityAreaId 城区id
    */
    public function getCityAreaName($cityAreaId) {
        if(!Cache::has('getCityAreaName_'.$cityAreaId)){
            $result = DB::connection('mysql_house')
                    ->table('cityarea')
                    ->where('id',$cityAreaId)
                    ->select('name')
                    ->get();
            Cache::put('getCityAreaName_'.$cityAreaId,$result,60*24*30);
        }else{
            $result =  Cache::get('getCityAreaName_'.$cityAreaId);
        }
        return $result;
        /*return DB::connection('mysql_house')
        ->table('cityarea')
        ->where('id',$cityAreaId)
        ->select('name')
        ->get();*/
    }

    /**
    * 查询商圈
    * @param $businessAreaId 商圈id
    */
    public function getBusinessAreaName($businessAreaId) {
        if(!Cache::has('getBusinessAreaName_'.$businessAreaId)){
            $result = DB::connection('mysql_house')
                    ->table('businessarea')
                    ->where('id',$businessAreaId)
                    ->select('name')
                    ->get();
            Cache::put('getBusinessAreaName_'.$businessAreaId,$result,60*24*30);
        }else{
            $result =  Cache::get('getBusinessAreaName_'.$businessAreaId);
        }
        return $result;
        /*return DB::connection('mysql_house')
        ->table('businessarea')
        ->where('id',$businessAreaId)
        ->select('name')
        ->get();*/
    }

    /**
    * 查询楼盘出售房源信息
    * @param int $communityId 楼盘id
    */
    public function getHouseSaleData($communityId) {
        return DB::connection('mysql_oldhouse')
        ->table('housesale')
        ->where('communityId',$communityId)
        ->select('id','communityId','title','thumbPic','roomStr','area','price2')
        ->limit(5)
        ->get();
    }

    /**
    * 查询楼盘出租房源信息
    * @param int $communityId 楼盘id
    */
    public function getHouseRentData($communityId) {
        return DB::connection('mysql_oldhouse')
        ->table('houserent')
        ->where('communityId',$communityId)
        ->select('id','communityId','title','thumbPic','roomStr','area','price1')
        ->limit(5)
        ->get();
    }

    /**
    | 楼盘详情页DAO
    */

    /**
    * 获取楼盘相关信息
    * @param int $communityId 楼盘id
    * @param array $select 查询字段
    */
    public function getCommData($communityId,$select) {
        return DB::connection('mysql_oldhouse')
        ->table('community')
        ->where('id',$communityId)
        ->select($select)
        ->get();
    }

    /**
    * 查询城市环线
    * @param int $loopLineId 城市id
    */
    public function getLoopLineName($loopLineId) {
        if(!Cache::has('getLoopLineName_'.$loopLineId)){
            $result = DB::connection('mysql_house')
                    ->table('loopline')
                    ->where('id',$loopLineId)
                    ->select('name')
                    ->get();
            Cache::put('getLoopLineName_'.$loopLineId,$result,60*24*30);
        }else{
            $result =  Cache::get('getLoopLineName_'.$loopLineId);
        }
        return $result;
        /*return DB::connection('mysql_house')
        ->table('loopline')
        ->where('id',$loopLineId)
        ->select('name')
        ->get();*/
    }

    /**
    | 楼盘户型页DAO
    */

    /**
    * 获取楼盘下所有户型信息
    * @param int $communityId 楼盘id
    * @param int $state 销售状态 1.在售 2.待售 3.巳售完
    * @param array $select 查询字段
    */
    public function getCommunityRoom($communityId,$state,$select) {
        return DB::connection('mysql_oldhouse')
        ->table('communityroom')
        ->where('communityId',$communityId)
        ->where('state',$state)
        ->select($select)
        ->get();
    }

    /**
    * 房源户型在售房源信息
    * @param int $communityId 楼盘id
    */
    public function getHouseSale($communityId) {
        return DB::connection('mysql_oldhouse')
        ->table('housesale')
        ->where('communityId',$communityId)
        ->select('id','communityId','price2','houseRoom','thumbPic')
        ->get();
    }

    /**
    * 房源户型再租房源信息
    * @param int $communityId 楼盘id
    */
    public function getHouseRent($communityId) {
        return DB::connection('mysql_oldhouse')
        ->table('houserent')
        ->where('communityId',$communityId)
        ->select('id','communityId','price1','houseRoom','thumbPic')
        ->get();
    }

    /**
    * 查询同居室出售数量的户型信息
    * @param int $communityId 楼盘id
    * @param int $houseRoom 居室数量
    */
    public function getHouseSaleRoom($communityId,$houseRoom) {
        return DB::connection('mysql_oldhouse')
        ->table('housesale')
        ->where('communityId',$communityId)
        ->where('houseRoom',$houseRoom)
        ->select('id','communityId','price2','houseRoom','thumbPic')
        ->limit(5)
        ->get();
    }

    /**
    * 查询同居室出租数量的户型信息
    * @param int communityId 楼盘id
    * @param int $houseRoom 居室数量
    */
    public function getHouseRentRoom($communityId,$houseRoom) {
        return DB::connection('mysql_oldhouse')
        ->table('houserent')
        ->where('communityId',$communityId)
        ->where('houseRoom',$houseRoom)
        ->select('id','communityId','price1','houseRoom','thumbPic')
        ->limit(5)
        ->get();
    }

    /**
    | 楼盘相册页DAO
    */

    /**
    * 图片查询
    * @param int $communityId 楼盘id
    * @param int $type 图片类型
    * -------------------------------
    * 1.交通图 2.实景图 3.效果图
    * 4.样板间 6.配套图 7.施工进度图
    * 8.规划图
    * -----------------------------
    */
    public function getCommTypeImg($communityId,$type) {
        if(!Cache::has('getCommTypeImg_'.$communityId.'_'.$type)){
            $result = DB::connection('mysql_oldhouse')
                    ->table('communityimage')
                    ->where('communityId',$communityId)
                    ->where('type',$type)
                    ->select('id','communityId','type','fileName','note')
                    -> paginate(12);
            Cache::put('getCommTypeImg_'.$communityId.'_'.$type,$result,60*24*30);
        }else{
            $result =  Cache::get('getCommTypeImg_'.$communityId.'_'.$type);
        }
        return $result;
        /*return DB::connection('mysql_oldhouse')
        ->table('communityimage')
        ->where('communityId',$communityId)
        ->where('type',$type)
        ->select('id','communityId','type','fileName','note')
        -> paginate(12);*/
    }

    /**
    * 查询楼盘下所有图片(用来统计各类型图片数量)
    * @param int $communityId 楼盘id
    */
    public function getCommImgTotal($communityId) {
        if(!Cache::has('getCommImgTotal_'.$communityId)){
            $result = DB::connection('mysql_oldhouse')
                    ->table('communityimage')
                    ->where('communityId',$communityId)
                    ->select('id','communityId','type')
                    ->get();
            Cache::put('getCommImgTotal_'.$communityId,$result,60*24*30);
        }else{
            $result =  Cache::get('getCommImgTotal_'.$communityId);
        }
        return $result;
        /*return DB::connection('mysql_oldhouse')
        ->table('communityimage')
        ->where('communityId',$communityId)
        ->select('id','communityId','type')
        ->get();*/
    }

    /**
    * 查询二手房调价历史表
    * @param int $communityId 楼盘id
    * @param int $type 1.出租 2.出售
    * @param int $type2 物业类型2 如 103
    */
    public function getStatus($communityId,$type,$type2) {
        return DB::connection('mysql_statistics')
        ->table('communitystatus2')
        ->where('communityId',$communityId)
        ->where('type',$type)
        ->where('cType2',$type2)
        ->select('id','avgPrice','increase')
        ->orderBy('changeTime','desc')
        ->limit(1)
        ->get();
    }
    
    /**
    * 查询二手房调价历史表 （环比上月和环比去年）
    * @param int $communityId 楼盘id
    * @param int $type2 物业类型2 如 103
    */
    public function getStatusByLimit_24($communityId, $type2) {
        if(!Cache::has('getStatusByLimit_24_'.$communityId.'_'.$type2)){
            $result = DB::connection('mysql_statistics')
                    ->table('communitystatus2')
                    ->where('communityId',$communityId)
                    ->where('cType2',$type2)
                    ->groupBy('type','changeTime')
                    ->select('id','avgPrice','increase', 'type')
                    ->orderBy('id','desc')
                    ->limit(24)
                    ->get();
            Cache::put('getStatusByLimit_24_'.$communityId.'_'.$type2,$result,60*24*30);
        }else{
            $result =  Cache::get('getStatusByLimit_24_'.$communityId.'_'.$type2);
        }
        return $result;
        /*return DB::connection('mysql_statistics')
        ->table('communitystatus2')
        ->where('communityId',$communityId)
        ->where('cType2',$type2)
        ->groupBy('type','changeTime')
        ->select('id','avgPrice','increase', 'type')
        ->orderBy('id','desc')
        ->limit(24)
        ->get();*/
    }
    
/**********************************************************************************************/

    /**
     *   房源对比中      房源的基本信息
     * @author  zhuwei
     * @param   $houseId   房源id
     * @param   $type      sale  表示出售   rent  表示出租
     * @param   $houseType  1  商铺   2 写字楼   3  住宅
     * @param   author    zhuwei
     */
    public function searchHouse($houseId,$type,$houseType){

        if($type == 'sale'){
           
            // 查询户型图
            $houseImage = DB::connection('mysql_oldhouse')
                ->select('select fileName from housesaleimage where houseId = ? and type = ? limit 1',array($houseId,1));
        }
        if($type == 'rent'){   
            // 查询户型图
            $houseImage = DB::connection('mysql_oldhouse')
                    ->select('select fileName from houserentimage where houseId = ? and type = ? limit 1',array($houseId,1));
        }
       
        return [
            'houseImage' => $houseImage,
            // 'aroundInfo' => $aroundInfo,
        ];
    }
    /**
     *  查询户型图片
     * @param   $ids   房源id
     * @param   $table 表名
     */
    public function getHouseImagesByHouseIds($ids,$table){
        $houseImgs = [];
        $houseImage = DB::connection('mysql_oldhouse')
                        ->table($table)
                        ->where('type',1)
                        ->whereIn('houseId',$ids)
                        ->get(['houseId','fileName']);
        if(!empty($houseImage)){
            foreach($houseImage as $Image){
                $houseImgs[$Image->houseId][] = $Image;
            }
        }
        return $houseImgs;
    }

    /**
     *  查询特色标签
     * @param  $id   标签的id  字符串
     * @param  $type 4  表示是二手房
     */
    public function getTags($id,$type){
        $tag = DB::connection('mysql_house')->table('tag')
                ->whereIn('id',$id)->get(['name']);
        return $tag;
    }
    
    /**
     * 根据楼盘id 获取楼盘相册
     * @param int $id
     */
    public function getImg($id){
        if(!Cache::has('getImg_'.$id)){
            $result = DB::connection('mysql_oldhouse')->table('communityimage')->where('communityId', $id)->where('type', '<>', '10')->get(['fileName']);
            Cache::put('getImg_'.$id,$result,60*24*30);
        }else{
            $result =  Cache::get('getImg_'.$id);
        }
        return $result;
    }
    /*判断当前城市说用模板 */
    public function getCityModel($cityId){
        $res = DB::connection('mysql_house')
            ->table('city2model')
            ->where('cityId',$cityId)
            ->first();
        return $res;
    }
}

?>