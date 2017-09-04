<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 16/1/23
 * Time: 上午11:27
 */

namespace App\Http\Controllers\Utils;

use DB;
use Cache;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展

if(!defined('CACHE_TYPE'))          define('CACHE_TYPE','redis');
if(!defined('CACHE_TIME'))          define('CACHE_TIME',60*24*7);  // 60分 x 24时 x 7 天

if(!defined('NO_DATA'))             define('NO_DATA','');

if(!defined('DB_NAME'))             define('DB_NAME','mysql_house');        //默认数据库宏
if(!defined('DEFAULT_TABLE'))       define('DEFAULT_TABLE','city');         //默认数据表

if(!defined('CITY'))                define('CITY',      'CityAllCache');          //默认 城市数据缓存 键名定义
if(!defined('PROV_NAME'))           define('PROV_NAME', 'ProvinceAllCache'); //默认 省份数据缓存 键名定义
if(!defined('CITY_AREA'))           define('CITY_AREA', 'CityAreaAllCache'); //默认 城区数据缓存 键名定义
if(!defined('TAGTB_NAME'))          define('TAGTB_NAME','TagTableAllCache');
if(!defined('TAG2INFO'))            define('TAG2INFO',  'Tag2infoTable');
if(!defined('B_AREA'))              define('B_AREA',    'BusinessAreaAllCache');//默认 商圈数据缓存 键名定义
if(!defined('DEVELOPER'))           define('DEVELOPER','DeveloperAllCache');  //开发商表
if(!defined('LOOPLINE'))            define('LOOPLINE','LooplineAllCache');   //地铁环线表

if(!defined('PROJECT_COMPANY'))     define('PROJECT_COMPANY'        ,'projectcompany');
if(!defined('INVEST_COMPANY'))      define('INVEST_COMPANY'         ,'investcompany');
if(!defined('SUPERVISION_COMPANY')) define('SUPERVISION_COMPANY'    ,'supervisioncompany');
if(!defined('LANDSCAPE_COMPANY'))   define('LANDSCAPE_COMPANY'      ,'landscapecompany');
if(!defined('ARCH_COMPANY'))        define('ARCH_COMPANY'           ,'architecturalplanningcompany');
if(!defined('CONSTRUCTION_COMPANY')) define('CONSTRUCTION_COMPANY'   ,'constructioncompany');


class RedisCacheUtil {

//==================================== Get 函数方法区 ====================================================
    /**
     * 通过ID 获取单条 商圈Name
     * @param $id
     * @return mixed
     */
    public static function getBussinessNameById($id){
        if(empty($id)) return false;
        $unique = md5(B_AREA.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'businessarea',$unique,$id);
            if($data == NO_DATA) return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过ID 获得单条 城区Name
     * @param $id
     * @return mixed
     */
    public static function getCityAreaNameById($id){
        if(empty($id)) return false;
        $unique = md5(CITY_AREA.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'cityarea',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过ID 获取单条 城市Name
     * @param $id
     * @return mixed
     */
    public static function getCityNameById($id){
        if(empty($id)) return false;
        $unique = md5(CITY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'city',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过ID 获取单条 省市Name
     * @param $id
     * @return mixed
     */
    public static function getProvinceNameById($id){
        if(empty($id)) return false;
        $unique = md5(PROV_NAME.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'province',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过Id 获取单条 Tag 的Name
     * @param $id
     * @return mixed
     */
    public static function getTagNameById($id){
        if(empty($id)) return false;
        $unique = md5(TAGTB_NAME.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'tag',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过id 获得单条 Tag2info 的Name
     * @param $id
     * @return mixed
     */
    public static function getTag2infoNameById($id){
        if(empty($id)) return false;
        $unique = md5(TAG2INFO.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'tag2info',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['type'];
        }
        return $data[0]['type'];
    }
    /**
     * 通过ID 获取单条 开发商Name
     * @param $id
     * @return mixed
     */
    public static function getDeveloperNameById($id){
        if(empty($id)) return false;
        $unique = md5(DEVELOPER.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'developers',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['companyname'];
        }
        return $data[0]['companyname'];
    }
    /**
     * 通过ID 获取单条 环线Name
     * @param $id
     * @return mixed
     */
    public static function getLooplineNameById($id){
        if(empty($id)) return false;
        $unique = md5(LOOPLINE.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'loopline',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过EnterpriseShop Id 返回分销商的名字
     * @param $id
     * @return bool|string
     */
    public static function getEnterpriseshopNameByEId($id){
        if(empty($id)) return false;
        $unique = md5('EnterpriseshopName'.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById('mysql_user','enterpriseshop',$unique,$id);
            if($data == NO_DATA) return false;
            return $data[0]['companyName'];
        }
        return $data[0]['companyName'];
    }
    /**
     * 通过ID 获取单条 项目公司Name
     * @param $id
     * @return string
     */
    public static function getProjectCompanyNameById($id){
        if(empty($id)) return false;
        $unique = md5(PROJECT_COMPANY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'projectcompany',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 通过ID 获取单条 监理公司Name
     * @param $id
     * @return string
     */
    public static function getSupervisionCompanyNameById($id){
        if(empty($id)) return false;
        $unique = md5(SUPERVISION_COMPANY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'supervisioncompany',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['companyname'];
        }
        return $data[0]['companyname'];
    }
    /**
     * 通过ID 获取单条 投资公司Name
     * @param $id
     * @return string
     */
    public static function getInvestCompanyNameById($id){
        if(empty($id)) return false;
        $unique = md5(INVEST_COMPANY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'investcompany',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['companyname'];
        }
        return $data[0]['companyname'];
    }
    /**
     * 通过ID 获取单条 景观公司Name
     * @param $id
     * @return string
     */
    public static function getLandscapeCompanyNameById($id){
        if(empty($id)) return false;
        $unique = md5(LANDSCAPE_COMPANY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'landscapecompany',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['companyname'];
        }
        return $data[0]['companyname'];
    }
    /**
     * 通过ID 获取单条 建筑公司Name
     * @param $id
     * @return string
     */
    public static function getArchCompanyNameById($id){
        if(empty($id)) return false;
        $unique = md5(ARCH_COMPANY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'architecturalplanningcompany',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['companyname'];
        }
        return $data[0]['companyname'];
    }
    /**
     * 通过ID 获取单条 施工公司Name
     * @param $id
     * @return string
     */
    public static function getConstructCompanyNameById($id){
        if(empty($id)) return false;
        $unique = md5(CONSTRUCTION_COMPANY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'constructioncompany',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['companyname'];
        }
        return $data[0]['companyname'];
    }

    /**
     * 更过ID 获取单条 楼盘Name
     * @param int $id 楼盘id
     * @return string
     */
    public static function getCommunityNameById($id){
        if(empty($id)) return false;
        $unique = md5('Community'.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById('mysql_newhouse0','community',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
    /**
     * 更过ID 获取单条 二手楼盘Name
     * @param int $id 楼盘id
     * @return string
     */
    public static function getOldCommunityNameById($id){
        if(empty($id)) return false;
        $unique = md5('OldCommunity'.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById('mysql_oldhouse','community',$unique,$id);
            if($data == NO_DATA)return false;
            return $data[0]['name'];
        }
        return $data[0]['name'];
    }
//==================================  Get 整条数据  ========================================================
    /**
     * 通过ID 获取单条 商圈Name
     * @param $id
     * @return mixed
     */
    public static function getBussinessDataById($id){
        if(empty($id)) return false;
        $unique = md5(B_AREA.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'businessarea',$unique,$id);
            return $data;
        }
        return $data;
    }
    /**
     * 通过ID 获得单条 城区Name
     * @param $id
     * @return mixed
     */
    public static function getCityAreaDataById($id){
        if(empty($id)) return false;
        $unique = md5(CITY_AREA.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'cityarea',$unique,$id);
            return $data;
        }
        return $data;
    }
    /**
     * 通过ID 获取单条 城市Name
     * @param $id
     * @return mixed
     */
    public static function getCityDataById($id)
    {
        if(empty($id)) return false;
        $unique = md5(CITY.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'city',$unique,$id);
            Cache::store(CACHE_TYPE)->put($unique, $data, CACHE_TIME);
            return Cache::store(CACHE_TYPE)->get($unique);
        
        }
        return $data;
    }
    /**
     * 通过城市名 获取单条 城市
     * @param $name
     * @return mixed
     */
    public static function getCityDataByName($name)
    {
    	if(empty($name)) return false;
    	$unique = md5(CITY.$name);
    	$data = Cache::store(CACHE_TYPE)->get($unique);
    	if(empty($data) || (!isset($data))){
    		//     		$data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'city',$unique,$id);
    		$db = DB::connection('mysql_house')->table('city')->where('name', $name)->first();
    		if(empty($db)) return false;
    		Cache::store(CACHE_TYPE)->put($unique, $db, CACHE_TIME);
    		$data = Cache::store(CACHE_TYPE)->get($unique);
    		if(empty($data)) return false;
    		return $data;
    	}
    	return $data;
    }
    /**
     * 通过城市简写拼音 获取单条 城市
     * @param $py
     * @return mixed
     */
    public static function getCityDataByPy($py)
    {
    	if(empty($py)) return false;
    	$unique = md5(CITY.$py);
    	$data = Cache::store(CACHE_TYPE)->get($unique);
    	if(empty($data) || (!isset($data))){
    		//     		$data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'city',$unique,$id);
    		$db = DB::connection('mysql_house')->table('city')->select('name', 'fullname', 'id', 'pinyin', 'longitude', 'py', 'latitude')->where('py', $py)->first();
    		if(empty($db)) return false;
    		Cache::store(CACHE_TYPE)->put($unique, $db, CACHE_TIME);
    		$data = Cache::store(CACHE_TYPE)->get($unique);
    		if(empty($data)) return false;
    		return $data;
    	}
    	return $data;
    }
    /**
     * 通过ID 获取单条 省市Name
     * @param $id
     * @return mixed
     */
    public static function getProvinceDataById($id){
        if(empty($id)) return false;
        $unique = md5(PROV_NAME.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'province',$unique,$id);
            return $data;
        }
        return $data;
    }
    /**
     * 通过Id 获取单条 Tag 的Name
     * @param $id
     * @return mixed
     */
    public static function getTagDataById($id){
        if(empty($id)) return false;
        $unique = md5(TAGTB_NAME.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'tag',$unique,$id);
            return $data;
        }
        return $data;
    }
    /**
     * 通过id 获得单条 Tag2info 的Name
     * @param $id
     * @return mixed
     */
    public static function getTag2infoDataById($id){
        if(empty($id)) return false;
        $unique = md5(TAG2INFO.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'tag2info',$unique,$id);
            return $data;
        }
        return $data;
    }

    public static function getDeveloperDataById($id){
        if(empty($id)) return false;
        $unique = md5(DEVELOPER.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'developers',$unique,$id);
            return $data;
        }
        return $data;
    }

    public static function getLooplineDataById($id){
        if(empty($id)) return false;
        $unique = md5(LOOPLINE.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'loopline',$unique,$id);
            return $data;
        }
        return $data;
    }


//============================= 工具方法 - 工具函数 =======================
    /**
     * 缓存 某数据库的某表 的全部内容 并制定键名
     *
     * @param $db                 - 数据库名
     * @param $table              - 表名
     * @param $key                - 键名
     * @return bool               - 返回 成功 | 失败
     */
    public static function initOrCacheWholeTableYouChosen($db,$table,$key){
        $data   = Cache::store(CACHE_TYPE)->get($key);
        if((!isset($data)) ||  empty($data)){
            $db_data = DB::connection($db)->table($table)->get();//取数据;
            if(!isset($db_data)|| empty($db_data))return NO_DATA;
            $db_data = json_decode(json_encode($db_data),true);
            Cache::store(CACHE_TYPE)->put($key,$db_data,CACHE_TIME);
            return true;
        }
        return true;
    }
    /**
     * 缓存 某数据库 某表的 根据ID 制定键名
     * @param $db             -数据库
     * @param $table          -数据表
     * @param $key            -主键名特征
     * @param $id             -数据Id 反查是要查询 md5(主键特征名.ID)
     * @return bool           -返回
     */
    public static function initOrCacheSingleLineDataYouChosenById($db,$table,$key,$id){
        $unique = md5($key.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);

        if(!isset($data) || empty($data)){
            $db_data = DB::connection($db)->table($table)->where('id',$id)->get();//根据取数据;
            if(!isset($db_data)||empty($db_data))return NO_DATA;
            $db_data = json_decode(json_encode($db_data),true);
            Cache::store(CACHE_TYPE)->put($unique,$db_data,CACHE_TIME);
            return Cache::store(CACHE_TYPE)->get($unique);
        }
        return $data;
    }

    /**
     * 获取单条缓存数据的国王方法
     * @param $dbname
     * @param $tablename
     * @param $key
     * @param $id
     * @return bool
     */
    public static function initLikeKing($dbname,$tablename,$key,$id){
        $unique = md5($key.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById($dbname,$tablename,$unique,$id);
            if(empty($data) || (!isset($data))) return NO_DATA;
            return $data;
        }
        return $data;
    }

    /**
     * 获取缓存列的国王方法
     * @param $dbname
     * @param $tablename
     * @param $key
     * @param $id
     * @param $column
     * @return mixed
     */
    public static function getDataLikeKing($dbname,$tablename,$key,$id,$column){
        $unique = md5($key.$id);
        $data = Cache::store(CACHE_TYPE)->get($unique);
        if(empty($data) || (!isset($data))){
            $data = RedisCacheUtil::initOrCacheSingleLineDataYouChosenById($dbname,$tablename,$unique,$id);
            if(empty($data) || (!isset($data))) return NO_DATA;
            if(empty($data[0][$column]) || (!isset($data[0][$column]))) return NO_DATA;
            return $data[0][$column];
        }
        return $data[0][$column];
    }
    /**
     * 传入一个起始时间
     * @param $start
     * @return string
     */
    public static function testTime($start){
        return  number_format(((microtime(true)-$start)*1000),4)." ms</br>";
    }
//=================================================================================================
//==================================   集体缓存函数   ===============================================
//=================================================================================================
    /**
     * 总缓存函数
     *
     */
    public static function wholeCacheInit(){
        $state = boolval(Cache::store(CACHE_TYPE)->get('WHOLE_INIT_STATE'));
        if(!$state){
            RedisCacheUtil::initOrCacheProvinceTable();
            RedisCacheUtil::initOrCacheCityTable();
            RedisCacheUtil::initOrCacheCityAreaTable();
            RedisCacheUtil::initOrCacheBussinessTable();
            RedisCacheUtil::initOrCacheTagTable();
            RedisCacheUtil::initOrCacheTag2infoTable();
            //===========================================
            RedisCacheUtil::initWholeTableBySingleItem();
            Cache::store(CACHE_TYPE)->put('WHOLE_INIT_STATE',1,CACHE_TIME);
        }
    }
    public static function initWholeTableBySingleItem(){
        $state = boolval(Cache::store(CACHE_TYPE)->get('SINGLE_INIT_'));
        RedisCacheUtil::cacheProvinceBySingleItem();
        RedisCacheUtil::cacheCityBySingleItem();
        RedisCacheUtil::cacheCityAreaBySingleItem();
        RedisCacheUtil::cacheBussinessAreaBySingleItem();
        RedisCacheUtil::cacheTagBySingleItem();
        RedisCacheUtil::cacheTag2infoBySingleItem();
        Cache::store(CACHE_TYPE)->put('SINGLE_INIT_STATE',1,CACHE_TIME);
    }
    //============== ===缓存函数========================
    /**
     * 缓存城市表，成功返回真。如果已经缓存直接返回真
     * @return bool
     */
    public static function initOrCacheCityTable(){
        $result = RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'city',CITY);
        return $result;
    }
    /**
     * 缓存省份表，成功返回真。如果已经缓存直接返回真
     * @return bool
     */
    public static function initOrCacheProvinceTable(){
        return RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'province',PROV_NAME);
    }
    /**
     * 缓存城区表，成功返回真。如果已经缓存直接返回真
     * @return bool
     */
    public static function initOrCacheCityAreaTable(){
        return RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'cityarea',CITY_AREA);
    }
    /**
     * 缓存商圈表，成功返回真，如果已缓存直接返回真
     * @return bool
     */
    public static function initOrCacheBussinessTable(){
        return  RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'businessarea',B_AREA);
    }
    /**
     * 缓存整个 Tag表 成功返回真
     * @return bool
     */
    public static function initOrCacheTagTable(){
        return  RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'tag',TAGTB_NAME);
    }
    /**
     * 缓存整个 Tag2info 表 成功 返回真
     * @return bool
     */
    public static function initOrCacheTag2infoTable(){
        return RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'tag2info',TAG2INFO);
    }
    /**
     * 按照ID单条缓存 BusinessArea 表，查库可以做到 1ms以下
     * @return bool
     */
    public static function cacheBussinessAreaBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('businessarea')->get();
        foreach($db_data as $item){
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'businessarea',B_AREA,$item->id);
        }
        Cache::store(CACHE_TYPE)->put('BUSINESSNAME_INIT_STATE',1,CACHE_TIME);
        return true;
    }
    /**
     * 按照单条ID缓存 城区表 CityArea
     * @return bool
     */
    public static function cacheCityAreaBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('cityarea')->get();
        foreach($db_data as $item){
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'cityarea',CITY_AREA,$item->id);
        }
        Cache::store(CACHE_TYPE)->put('CITYAREA_INIT_STATE',1,CACHE_TIME);
        return true;
    }
    /**
     * 按照单条ID 缓存 城市表 City
     * @return bool
     */
    public static function cacheCityBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('city')->get();
        foreach($db_data as $item){
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'city',CITY,$item->id);
        }
        Cache::store(CACHE_TYPE)->put('CITY_INIT_STATE',1,CACHE_TIME);
        return true;
    }
    /**
     * 按照省份ID 缓存 省市表 Province
     * @return bool
     */
    public static function cacheProvinceBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('province')->get();
        foreach ($db_data as $item ) {
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'province',PROV_NAME,$item->id);
        }
        return true;
    }
    /**
     * 按照标签Id 缓存 标签表单条数据
     * @return bool
     */
    public static function cacheTagBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('tag')->get();
        foreach($db_data as $item){
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById('mysql_house','tag',TAGTB_NAME,$item->id);
        }
        return true;
    }
    /**
     * 按照标签ID 缓存 Tag2Info表的一条数据
     * @return bool
     */
    public static function cacheTag2infoBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('tag2info')->get();
        foreach($db_data as $item){
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'tag2info',TAG2INFO,$item->id);
        }
        return true;
    }
    /**
     * 按照开发商ID 缓存 Developers 表的单条数据
     * @return bool
     */
    public static function cacheDeveloperBySingleItem(){
        $db_data = DB::connection(DB_NAME)->table('developers')->get();
        foreach($db_data as $item){
            RedisCacheUtil::initOrCacheSingleLineDataYouChosenById(DB_NAME,'developers','DEVELOPER',$item->id);
        }
        return true;
    }


    /**
     * 根据拼音查询新楼盘的名字
     * @param string $searchInfo = array('kw'=> $keywords, 'tp1'=>$type1);
     * @return string $name
     */
    public static function getNewCommunityNameByPy($searchInfo){
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(14);  // 选择14号库  新盘的库
        return Redis::keys('np'.CURRENT_CITYID.'_'.$searchInfo['tp1'].':'.$searchInfo['kw'].'*');
    }

    /**
     * 根据拼音查询二手楼盘的名字
     * @param string $searchInfo = array('kw'=> $keywords, 'tp1'=>$type1);
     * @return string $name
     */
    public static function getOldCommunityNameByPy($searchInfo){
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(15);  // 选择15号库  二手盘的库
        return Redis::keys('op'.CURRENT_CITYID.'_'.$searchInfo['tp1'].':'.$searchInfo['kw'].'*');
    }

    /**
     * 根据汉字查询新楼盘的名字
     * @param string $searchInfo = array('kw'=> $keywords, 'tp1'=>$type1);
     * @return string $name
     */
    public static function getNewCommunityNameByName($searchInfo){
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(14);  // 选择14号库  新盘的库
        return Redis::keys('nn'.CURRENT_CITYID.'_'.$searchInfo['tp1'].':'.$searchInfo['kw'].'*');
    }

    /**
     * 根据汉字查询二手楼盘的名字
     * @param string $searchInfo = array('kw'=> $keywords, 'tp1'=>$type1);
     * @return string $name
     */
    public static function getOldCommunityNameByName($searchInfo){
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(15);  // 选择15号库  二手盘的库
        return Redis::keys('on'.CURRENT_CITYID.'_'.$searchInfo['tp1'].':'.$searchInfo['kw'].'*');
    }

    /**
     * 根据汉字新楼盘查房价
     * @param string $keywords
     * @return string $name
     */
    public static function getNewCommunityIdByName($keywords){
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(14);  // 选择14号库  新盘的库
        return Redis::get('nl'.CURRENT_CITYID.':'.$keywords);
    }

    /**
     * 根据汉字二手楼盘查房价
     * @param string $searchInfo = array('kw'=> $keywords, 'tp1'=>$type1);
     * @return string $name
     */
    public static function getOldCommunityIdByName($keywords){
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(15);  // 选择15号库  二手盘的库
        return Redis::get('ol'.CURRENT_CITYID.':'.$keywords);
    }
}

//    private static $_instance;
//
//    /**
//     * 构造函数 防止实例化
//     */
//    private function __construct(){
//    }
//
//    /**
//     * 防克隆
//     */
//    private function __clone()
//    {
//        // TODO: Implement __clone() method.
//    }
//
//    /**
//     * 示例：
//     * $redis = RedisCacheUtil::getInstance();
//     * $redis->getBussinessNameById();
//     * @return RedisCacheUtil
//     */
//    public static function getInstance(){
//        if(!(self::$_instance instanceof self)){
//            self::$_instance = new self;
//        }
//        return self::$_instance;
//    }