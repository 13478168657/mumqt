<?php

namespace App\Http\Controllers\Index;

use App\Dao\User\LoginDao;
use App\Dao\User\MyInfoDao;
use App\Dao\Article\ArticleDao;
use App\Http\Controllers\Utils\ValidateUtil;
use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;
use App\Services\Search;
use App\ListInputView;
use App\Http\Controllers\Utils\CookieUtil;
use DB;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
use App\Http\Controllers\Utils\CurlUtil;

//define('CACHE_TYPE','redis');
define('EVERY_MOBILE_NUMBER', 5);
define('EVERY_IP_NUMBER', 20);
define('MESSAGE_TIME', 24*60);

/**
 * Description of indexController
 * @since 1.0
 * @author niewu
 */
class IndexController extends Controller {

    public $LoginDao;
    public $communityUrl;
    public $community;

    public function __construct() {
//        LoginDao $LoginDao
        $this->LoginDao = new LoginDao();
        $this->community = new ListInputView();
        $this->adDao = new \App\Dao\Ad\AdDao();
        $this->article = new \App\Dao\Article\ArticleDao();
        $this->index    =new \App\Dao\Index\IndexDao();
    }

    /**
     * @index  网站首页
     * @access public
     * @since 1.0
     * @author niewu
     */

    public function index() {
        Redis::connect(config('database.redis.default.host'), 6379);
        $PCModel2=config('redistime.PCModel2');
        Redis::select($PCModel2['library']);  // 选择6号库
        /**
         * 前台首页
         * 判断是否有模板,如果是0往下放，
         * 是1走方法
         * 其他的也是往下放
         * h5也得往下放
         */
        $cityId = !empty(CURRENT_CITYID) ? CURRENT_CITYID : 0 ;
        $modelKey='modelKey_cityId_'.$cityId;
        $modelTime=$PCModel2['outtime'];
        if(Redis::exists($modelKey)){
            $modelId=Redis::get($modelKey);
        }else{
            $model=$this->index->getModel($cityId);
            if(!empty($model)){
                $modelId=$model->modelId;
            }else{
                $modelId=0;
            }
            Redis::set($modelKey,$modelId);
            Redis::expire($modelKey,$modelTime);
        }

        if($modelId == 2 && !USER_AGENT_MOBILE){
            return $this->PCModel2($cityId);
        }





        $ad_arr[1001] = $this->adDao->getInfo(1, 1001, 1);  //首页导航标签
        $ad_arr[1002] = $this->adDao->getInfo(1, 1002);  //首页导航背景图
        $ad_arr[2001] = $this->adDao->getInfo(2, 2001);  //首页新旁楼盘
        $ad_arr[2002] = $this->adDao->getInfo(2, 2002);  //首页二手楼盘
        $ad_arr[2003] = $this->adDao->getInfo(2, 2003);  //首页写字楼楼盘

        // 如果新房、二手房、写字楼对应的广告位数据为空就查库
        $ad_arr = $this->searchCommunityByList($ad_arr);

        // 查询首页是否有用户 关注的房源或楼盘
        $interest = array();
        if (Auth::check()) {
            $follow = new \App\Dao\User\FollowDao; // 载入关注类
            $where = array('uid' => Auth::user()->id, 'tableType' => 3, 'is_del' => 0); // 关注条件
            $interest = $follow->get_Follow($where);
        }

//        //判断如果楼盘链接 为空， 就根据该条数据的 各种Id 拼接出其真实的链接
//        $ad_arr[2001] = $this->checkUrl($ad_arr[2001], $interest);
//        $cache_time_m = 10;
//        if (Cache::has('ad_arr_2001')){
//            $ad_arr[2001] = Cache::get('ad_arr_2001');
//        } else {
//            $ad_arr[2001] = $this->getCommInfo($ad_arr[2001], 1);
//            if ($ad_arr[2001]!= null && array_key_exists('bigTitle', $ad_arr[2001][0])){
//                Cache::put('ad_arr_2001', $ad_arr[2001], $cache_time_m);
//            }
//        }
//        $ad_arr[2002] = $this->checkUrl($ad_arr[2002], $interest);
//        if (Cache::has('ad_arr_2002')){
//            $ad_arr[2002] = Cache::get('ad_arr_2002');
//        } else {
//            $ad_arr[2002] = $this->getCommInfo($ad_arr[2002], 2);
//            if ($ad_arr[2002]!= null && array_key_exists('bigTitle', $ad_arr[2002][0])){
//                Cache::put('ad_arr_2002', $ad_arr[2002], $cache_time_m);
//            }
//        }
//        $ad_arr[2003] = $this->checkUrl($ad_arr[2003], $interest);
//        if (Cache::has('ad_arr_2003')){
//            $ad_arr[2003] = Cache::get('ad_arr_2003');
//        } else {
//            $ad_arr[2003] = $this->getCommInfo($ad_arr[2003], 3);
//            if ($ad_arr[2003]!= null && array_key_exists('bigTitle', $ad_arr[2003][0])){
//                Cache::put('ad_arr_2003', $ad_arr[2003], $cache_time_m);
//            }
//        }

        //首页广告楼盘缓存逻辑,先从缓存里取
        $cacheName = "HomePageCache_".CURRENT_CITYID;
        //Cache::forget($cacheName);
//        Redis::del($cacheName);
        $config=config('redistime.indexOuttime');
        $cache_time_m = 60*5;
        if(Redis::exists($cacheName)){//true
            $data = Redis::get($cacheName);//null
        }else{
            $loop = [2001,2002,2003];
            $flag = (int)1;
            foreach($loop as $key){
                $ad_arr[$key] = $this->checkUrl($ad_arr[$key],$interest);
                $ad_arr[$key] = $this->getCommInfo($ad_arr[$key], $flag);
                $flag ++;
            }
            if(!empty($ad_arr)){
                $ad_arr=serialize($ad_arr);
                Redis::set($cacheName,$ad_arr);
                Redis::expire($cacheName,$cache_time_m);
            }
        }
        $ad_arr = !empty($data)?$data:$ad_arr;
        $ad_arr=unserialize($ad_arr);


        //判断请求来自PC端还是移动端
        if (USER_AGENT_MOBILE) {
            //移动端数据
            $viewhtml = 'h5.index.index';
            $cityId = CURRENT_CITYID;    //城市id
            $data = array();
            $data['ad_arr'] = $ad_arr;
            $public = new \App\Http\Controllers\Lists\PublicController();
            //城市区域数据
            $data['cityAreas'] = $public->conversion($public->getCityArea($cityId));
            $data['businessAreas'] = $public->conversion($public->getBusinessAreas($cityId));
            $data['towards'] = \Config::get('conditionConfig.toward.text');     //房屋朝向
            $data['defaultImage'] = '/h5/image/pic1.png';                       //图片地址不存在时，显示默认图片
            $data['objectType'] = 'houseSale';                                  //房屋出售
            $data['sr'] = 's';                                                  //说明是出租还是出售
            $housedao = new \App\Dao\Agent\HouseDao();
            $data['featurestag'] = $housedao->getAllHouseTag(); //所有房源标签
            $admodels = $this->article->getCityModel($cityId);
            $data['admodels'] = $admodels;
            $list = new ListInputView();
            $list->cityId = $cityId;
            $list->asc = 0;
            $list->pageset = 3; 
            //缓存 查询出售房源信息，key值是根据下面的$list的参数拼凑
            $houses_key='index_'.$cityId.'_isNew_0_order_timeCreate_asc_0_pageset_3';
            $time=config('redistime.indexOuttime');
            if(Redis::exists($houses_key)){
                $data['houses']=unserialize(Redis::get($houses_key));
            }else{
                $list->isNew = false;
                $list->order = 'timeCreate';                //按创建时间降序排列
                // 查询出售房源信息(索引)
                $search = new Search('hs');
                $houseSaleData = $search->searchHouse($list);  //搜索房源
                if (empty($houseSaleData->error)) {
                    $data['houses'] = $houseSaleData->hits->hits;
                }
                if(!empty($data['houses'])){
					Redis::set($houses_key,serialize($data['houses']));
					Redis::expire($houses_key,$config['outtime']);
				}

            }
            //缓存 查询楼盘信息，key值是根据下面的$list的参数拼凑
            $builds_key='index_'.$cityId.'_isNew_1_order_timeUpdate_asc_0_pageset_3';
            if(Redis::exists($builds_key)){
                $builds = $data['builds'] = unserialize(Redis::get($builds_key));
            }else{
                //查询楼盘信息（索引)
                $list->isNew = true;
                $list->order = 'timeUpdate';                //按更新时间降序排列
                $search = new Search('c');            
                $buildCommunity = $search->searchCommunity($list);   //搜索楼盘
                if (empty($buildCommunity->error)) {
                    $builds = $data['builds'] = $buildCommunity->hits->hits;
                }
                if(!empty($builds)){
					Redis::set($builds_key,serialize($builds));
					Redis::expire($builds_key,$config['outtime']);
				}
                return view($viewhtml, $data);
            }
            return view($viewhtml, $data);
        } else {
            /*添加文章模块*/
            $article = $this->getArticleList();
//            dd($article);
            $positionName = $article['positionName'];
            $articleList = $article['article'];
            //PC端数据
//            dd(compact('runtime', 'ad_arr', 'interest','articleList','positionName'));
            return view('index.index', compact('runtime', 'ad_arr', 'interest','articleList','positionName'));
//            return view('index.index', compact('runtime', 'ad_arr', 'interest'));
        }
    }


    /**
     * 整合首页链接 和 楼盘的关注
     * @param $buildInfo obj 楼盘信息
     * @param $interest array 关注信息
     * @return mixed
     */
    public function checkUrl($buildInfo, &$interest) {
        foreach ($buildInfo as $key => $val) {
            if (empty($val->url)) {
                // 如果type 等于1  是新盘
                if ($val->dbType == 1) {
                    $val->url = '/xinfindex/' . $val->fromId . '/' . $val->houseType2 . '.html'; // type2 在数据表中没有该字段，临时用101
                }
                // 如果type 等于2  是二手盘
                if ($val->dbType == 2) {
                    $val->url = '/esfindex/' . $val->fromId . '/' . $val->houseType2 . '.html';
                }
            }
            // 计算物业类型
            $val->houseType2 = substr($val->houseType2, 0, 1);

            // 整合首页关注的楼盘或房源
            foreach ($interest as $ikey => $ival) {
                if (($val->fromId == $ival->interestId) && ($val->houseType2 == $ival->type1)) {
                    $val->follow = true;
                    unset($interest[$key]);
                }
            }
            $buildInfo[$key] = $val;
        }
        return $buildInfo;
    }

    /**
     * 获取楼盘展示信息
     * @param $commInfo  楼盘对象
     * @param $type 类型为1 是新盘  2 为二手盘  3 为写字楼
     * @return mixed
     */
    public function getCommInfo($commInfo, $type) {
        $search = new Search();
        if (!empty($commInfo)) {
            foreach ($commInfo as $key => $val) {
                if ($val->dbType == 1) {  // dbType为1 是新盘
                    $res = $search->searchCommunityListByIds([$val->fromId], true);
                }
                if ($val->dbType == 2) {  // dbType为2 是二手盘
                    $res = $search->searchCommunityListByIds([$val->fromId], false);
                }
                if (empty($res->error) && !empty($res->docs[0]->found)) {
                    $res = json_decode(json_encode($res->docs[0]->_source), true);
                    $type2 = explode('|', $res['type2']);  // 物业类型
                    // $val->checkExists   = true;    // 检测该楼盘是否被查到
                    $val->bigTitle = $res['name'];         // 楼盘名称
                    $val->smallTitle = RedisCacheUtil::getBussinessNameById($res['businessAreaId']);   // 商圈名称
                    $val->type2 = $comma = ''; // 记录物业类型，最多3个
                    for ($i = 0; $i < 3; $i++) {
                        if (empty($type2[$i])) {
                            break;
                        }
                        $val->type2 .= $comma . config('communityType2.' . $type2[$i]);
                        $comma = '-';
                    }
//                     $val->fileName = !empty($res['titleImage']) ? $res['titleImage'] : $val->fileName;  // 楼盘标题图
                    if (!empty($res['titleImage'])) {
                        $val->fileName = !empty($val->fileName) ? $val->fileName : $res['titleImage'];  // 楼盘标题图 优先获取大后台上传的图片，如果没有就取默认标题图
                    }

                    if ($type == 1) {                                     // type == 1 is new Community
                        $saleStates = array('0' => '待售', '1' => '在售', '2' => '售磬'); // 销售状态 针对新盘
                        if (isset($res['salesStatusPeriods'])) {
                            $val->saleStates = $saleStates[$res['salesStatusPeriods']];   // 销售状态
                        }
                        $priceType = array();  // 记录不同物业类型的价格
                        $keyTemp = null;     // 记录一个临时的价格的键 最终记录价格中最低的键
                        for ($i = 1; $i <= 3; $i++) {
                            if (!empty($res['priceSaleAvg' . $i])) {
                                $priceType[$i] = $res['priceSaleAvg' . $i];
                                if ($keyTemp === null) {
                                    $keyTemp = $i;
                                } else {
                                    if ($priceType[$keyTemp] > $priceType[$i]) {
                                        $keyTemp = $i;
                                    }
                                }
                            }
                        }
                        // 记录最终选定的均价
                        if ($keyTemp !== null) {
                            $val->avgPrice = $res['priceSaleAvg' . $keyTemp];
                            $val->avgPriceUnit = !empty($res['priceSaleAvg' . $keyTemp.'Unit'])?$res['priceSaleAvg' . $keyTemp.'Unit']:'元/平米';
                        }

                        // 折扣方式：0.无 1.折扣 2.直接减去 3.折后减去
                        if (isset($res['discountType'])) {
                            if ($res['discountType'] == 1) {
                                $val->discount = $res['discount'] . '折';
                            } else if ($res['discountType'] == 2) {
                                $val->discount = '直减' . $res['subtract'] . '元';
                            } else if ($res['discountType'] == 3) {
                                $val->discount = $res['discount'] . '折后再减' . $res['subtract'] . '元';
                            } else {
                                $val->discount = '';
                            }
                        }

                        // 电商优惠
                        if (isset($res['specialOffers'])) {
                            if (strlen($res['specialOffers']) > 2 && $res['specialOffers'] != '0_0') {
                                $val->specialOffers = str_replace('_', '抵', $res['specialOffers']);
                            } else {
                                $val->specialOffers = '';
                            }
                        }
                    } else if ($type == 2) {                               // type == 2 is old Community
//                        $priceType = array();  // 记录不同物业类型的价格
//                        $keyTemp = null;     // 记录一个临时的价格的键 最终记录价格中最低的键
//                        for ($i = 1; $i <= 3; $i++) {
//                            if (!empty($res['priceSaleAvg' . $i])) {
//                                $priceType[$i] = $res['priceSaleAvg' . $i];
//                                if ($keyTemp === null) {
//                                    $keyTemp = $i;
//                                } else {
//                                    if ($priceType[$keyTemp] > $priceType[$i]) {
//                                        $keyTemp = $i;
//                                    }
//                                }
//                            }
//                        }
//                        if ($keyTemp !== null) {
//                            $val->avgPrice = $res['priceSaleAvg' . $keyTemp]; // 记录最终选定的均价
//                        }
                        $val->avgPrice = (isset($res['priceSaleAvg3']) && !empty($res['priceSaleAvg3'])) ? $res['priceSaleAvg3'] : '';
                    } else if ($type == 3) {                               // type == 3 is tablet
                        $priceType = array();  // 记录不同物业类型的价格
                        $keyTemp = null;     // 记录一个临时的价格的键 最终记录价格中最低的键
                        for ($i = 1; $i <= 3; $i++) {
                            if (!empty($res['priceRentAvg' . $i])) {
                                $priceType[$i] = $res['priceRentAvg' . $i];
                                if ($keyTemp === null) {
                                    $keyTemp = $i;
                                } else {
                                    if ($priceType[$keyTemp] > $priceType[$i]) {
                                        $keyTemp = $i;
                                    }
                                }
                            }
                        }
                        if ($keyTemp !== null) {
                            $val->avgPrice = $res['priceRentAvg' . $keyTemp]; // 记录最终选定的均价
                        }
                    }
                    // dd($res);
                }
                $commInfo[$key] = $val;
            }
        }
        // dd($commInfo);
        return $commInfo;
    }


    public function getBalace(){
        dd('sdfsfs');
//        return app('sms')->getBalace();
    }

//    // * 发送手机验证码头退出 
//    public function sendlogout(){
//        return app('sms')->logout(); 
//    }
//    //* 发送手机验证码头登录 
//    public function sendlogin(){
//        return app('sms')->login();
//    }
//    // 发送手机验证码。修改密码
//    public function editsend(){
//        return app('sms')->updatePassword(); 
//    }
    public function sess() {

        dd(Auth::user());
    }

    /**
     * @register  用户注册功能(ajax提交)
     * @access public
     * $_POST['puid'] 有两个值，1为验检验用户是否可用、2为注册。写入数据库
     * @since 1.0
     * @author niewu
     */

    public function register() {
        $puid = $_POST['puid'];
        if ($_POST['puid'] == 1) {
            $name = trim($_POST['username']);
            $data = $this->LoginDao->register($puid, $name);
        }
        if ($_POST['puid'] == 8) {
            $mob = $_POST['mob'];
            $data = $this->LoginDao->mobile($mob);
            return $data;
        }
        if ($_POST['puid'] == 2) {
            $name = trim($_POST['username']);
            $mobile = $_POST['mobile'];
            $pwd = $_POST['pwd'];
            if (!$pwd) {
                return 7;
            }
            $type = $_POST['_type'];
            $data = $this->LoginDao->register($puid, $name, $mobile, $pwd, $type);
            if ($data == 2) {
                $tels = $_POST['mobile'];
                $msg = '【搜房网】尊敬的用户，感谢您成功注册搜房网，您还可以下载手机搜房网，安装后可通过手机上传认证，刷新房源，下载点击 m.sofang.com,如需帮助拨打客服热线400-6090-798';
                //return app('sms')->sendMsg(array($tels), $msg);
            }
        }
        return $data;
    }

    /**
     * 退出登录
     * @author niewu
     */

    public function logout() {
        if (Auth::check()) {
            Auth::logout();
            Session::forget('user');
        }
        
        return Redirect::to($_SERVER['HTTP_REFERER']);
    }

    /**
     * @ 发送手机验证码
     * @since 1.0
     * @author niewu
     */

    public function forgot() {

        return view('index.forgotpasswd');
    }

    public function sendmobil() {
        if ($_POST['mid'] == 2) {
            $imgCode = Input::get('imgCode',''); // 图片验证码
            $code = Session::get('authnum_session');
            //$image = Input::get('image');  // 判断是否含有图片验证码  值为3代表有图片验证码
            if(empty($imgCode) || strtolower($imgCode) != $code){
                return json_encode(['res' => 3, 'message' => '图片验证码错误']);   // 图片验证码错误
            }
            $currDate = date('m-d', time());
            $tels = $_POST['mobile'];
            $mobNumber = $IpNumber = 0;
            if(Cache::store('redis')->has($currDate.'_'.$tels)){
                $mobNumber = Cache::store('redis')->get($currDate.'_'.$tels);
                if($mobNumber >= EVERY_MOBILE_NUMBER){
                    return json_encode(['res' => 1, 'message' => '短信数量超过限制']);
                }
            }
            
            if(Cache::store('redis')->has($currDate.'_'.$_SERVER["REMOTE_ADDR"])){
                $IpNumber = Cache::store('redis')->get($currDate.'_'.$_SERVER["REMOTE_ADDR"]);
                if($IpNumber >= EVERY_IP_NUMBER){
                    return json_encode(['res' => 1, 'message' => '短信数量超过限制']);
                }
            }
            Session::forget('authnum_session');  // 删除session中的验证码
            $mobyzm = mt_rand(100000, 999999);
            Cache::put($tels, $mobyzm, '15');
            $msg = '【搜房网】您的验证码是' . $mobyzm . '，在15分钟内有效，如非本人操作请忽略本短信。';
            Cache::store('redis')->put($currDate.'_'.$tels, $mobNumber, MESSAGE_TIME);
            Cache::store('redis')->put($currDate.'_'.$_SERVER["REMOTE_ADDR"], $IpNumber, MESSAGE_TIME);
            Cache::store('redis')->increment($currDate.'_'.$tels);
            Cache::store('redis')->increment($currDate.'_'.$_SERVER["REMOTE_ADDR"]);
	        if(config('app.env') == 'local'){//测试环境不发送短信
		        return $mobyzm;
	        }
            $res = app('sms')->sendMsg(array($tels), $msg);  // 0 发送成功  1 发送失败
            $message = empty($res) ?  '发送成功' : '发送失败';
            return json_encode(['res' => $res, 'message' => $message]);
        }
        if ($_POST['mid'] == 3) { //通过ajax
            $mobile = $_POST['mobile'];
            $modyzn = Cache::get($mobile);
            if ($_POST['mobyz'] == $modyzn) {
                return 5;
            } else {
                return 4;
            }
        }
    }

    /**
     *  自动登录
     *  @author zhuwei
     */
    public function autoLogin() {
        $name = trim(Input::get("name"));
        if (is_numeric($name)) {
            $type = '1';
        }
        $user = $this->LoginDao->autoLogin($name, $type);
        return $user;
    }

    /**
     * 自动注册
     * @param  zhuwei
     * @return int
     */
    public function autoRegister() {
        $puid = $_POST['puid'];
        if ($_POST['puid'] == 2) {
            $name = trim($_POST['username']);
            $mobile = $_POST['mobile'];
            $pwd = $_POST['pwd'];
            if (!$pwd) {
                return 7;
            }
            $type = $_POST['_type'];
            $data = $this->LoginDao->register($puid, $name, $mobile, $pwd, $type);
            if ($data == 2) {
                $tels = $_POST['mobile'];
                $msg = '【搜房网】尊敬的用户，感谢您成功注册搜房网，您的密码是【' . $pwd . '】，您还可以下载手机搜房网，安装后可通过手机上传认证，刷新房源，下载点击 m.sofang.com,如需帮助拨打客服热线400-6090-798';
            }
        }
    }

    /**
     * @ 专业用户注册
     * @since 1.0
     * @author niewu
     */

    /**
     * 图片验证码
     * @since 1.0
     * @author niewu
     */
    public function verCode() {
        $_vc = new ValidateUtil();      //实例化一个对象
        $_vc->doimg();
        Session::put('authnum_session', $_vc->getCode()); //验证码保存到SESSION中
    }

    /**
     * 激活邮箱链接
     * @since 1.0 
     * @author lixiyu
     */
    public function activeEmail() {
        $code1 = Input::get('bcode');
        $email = base64_decode(Input::get('email'));
        $code2 = Cache::get($email);
        if (empty($code2)) {
            return Redirect::to('/');
        }

        if ($code1 != $code2['code']) {
            return Redirect::to('/');
        } else {

            $id = $code2['id'];
            $info['email'] = $code2['email'];
            $myinfo = new MyInfoDao();
            $call = $myinfo->upInfo('users', $info, $id);
            Cache::forget($info['email']);
            if (!$call) {
                return Redirect::to('/');
            } else {
                Auth::loginUsingID($id);
                if (Auth::user()->type == 1) {
                    return Redirect::to('/myinfo/bindemailcomplate');
                } else if (Auth::user()->type == 2) {
                    return Redirect::to('/majorinfo/accountSafe');
                }
            }
        }
    }

    /**
     * 激活邮箱链接
     * @since 1.0 
     * @author zhuwei
     */
    public function resetEmail() {
        $code1 = Input::get('bcode');
        $email = base64_decode(Input::get('email'));
        $code2 = Cache::get($email);
        if (empty($code2) || $code1 != $code2['code']) {
            $connection = "/resetpassword?type=2&ck=1";
            return Redirect::to($connection);
        } else {
            $conn = "/resetpassword?type=3&";
            return Redirect::to($conn);
        }
    }

    /**
     * 判断用户要绑定的手机号 是否可用
     * @since 1.0
     * @author lixiyu
     */
    public function isBindPhone() {
        $mobile1 = Input::get('mobile'); // 接收传来的手机 号
        $mobile2 = Auth::user()->mobile; // 用户原本的手机 号
        if ($mobile1 == $mobile2)
            return 1; // 返回1 提醒这是用户当前的手机 号（并且已验证）
        $user = DB::connection('mysql_user')->table('users')->where('mobile', $mobile1)->get(['id']); // 岔气传来的手机 号获得用户 id 
        if (!empty($user)) {
            return Auth::user()->id == $user[0]->id ? 1 : 2; // 返回 1 提醒这是用户当前的手机号 返回 2 表示此手机号已经被注册过 
        }
        return 0; // 返回 0 表示 这个手机 号没有被注册
    }

    public function mobile_API_Search_community() {  //旧盘
        $mobile_API_Search = new Search();

        //$cityId =Input::get('cityId');
        $page = Input::get('page');

        $this->community->enterpriseshopId = Input::get('enterpriseshopId');

        $this->community->page = $page;
        $this->community->cityId = 0;
        $this->community->pageset = 10;

        $this->community->isNew = FALSE;
        //$this->community->communityId = $communityId;

        echo json_encode($mobile_API_Search->searchCommunity($this->community));
    }

    public function mobile_API_Search_new_community() { //新楼盘
        $mobile_API_Search = new Search();

        //$cityId =Input::get('cityId');
        $page = Input::get('page');

        $this->community->enterpriseshopId = Input::get('enterpriseshopId');

        $this->community->page = $page;
        $this->community->cityId = 1;
        $this->community->pageset = 10;

        $this->community->isNew = true;
        //$this->community->communityId = $communityId;

        echo json_encode($mobile_API_Search->searchCommunity($this->community));
    }

    /**
     * ajax 关注接口
     * @return 返回 0  没有登陆   返回 1 关注成功   返回 2 取消关注成功  返回  3 不是普通用户，无权限关注
     */
    public function point_Interest() {
        if (!Auth::check())
            return 0;
        if (Auth::user()->type != 1)
            return 3;

        $gz = array();
        $gz['uId'] = Auth::user()->id;         // 获取用户id
        // $gz['uId']          = 1;         // 获取用户id
        $gz['interestId'] = Input::get('id', '');     // 获取楼盘或房源Id
        $gz['tableType'] = Input::get('tabId', '');  // 对应关联表类型 1 优质房源出租表 2 优质房源出售表 3 楼盘表
        $gz['type1'] = Input::get('type', '');   // 物业类型 1 商铺 2 写字楼 3 住宅
        $gz['isNew'] = Input::get('isNew', '');   // 是否是新盘 1新盘 0 二手盘
        $follow = new \App\Dao\User\FollowDao; // 载入关注类
        $info = $follow->check_Follow($gz);
        if (empty($info)) {
            $gz['createTime'] = date('Y-m-d H:i:s');
            $flag = $follow->insert_Follow($gz);
            if ($flag)
                return 1;
        }else {
            if ($info[0]->is_del == 0) {
                $flag = $follow->update_Follow(['is_del' => 1], $info[0]->id);
                if ($flag)
                    return 2;
            }else {
                $flag = $follow->update_Follow(['is_del' => 0], $info[0]->id);
                if ($flag)
                    return 1;
            }
        }
        exit;
    }

    /**
     * 房贷计算 器
     */
    public function houseLoanCalc() {
        return view('index.houseloan');
    }

    /**
     * 设置城市
     */
    public function setCity() {
        $cityName = Input::get('name');
        // 根据城市名称 查询到相关的信息
        $city = CookieUtil::getCityByName($cityName);
        if (!empty($city)) {
            CookieUtil::SaveCookie("cityid", $city->id);
            CookieUtil::SaveCookie("city", $city);
            CookieUtil::SaveCookie("citypy", $city->py);
            return $city->py;
        } else {
            return "0";
        }
    }

    //=====================================================
    /**
     * 检查用户输入的用户名字段 返回想用输入的用户名类型
     * @param $userName
     * @return string
     * @author huzhaer
     */
    private function checkUserNameType($userName) {
        $type = '';
        $reg_phone = '/^((\(\d{2,3}\))|(\d{3}\-))?1\d{10}$/';
        $reg_email = '/^(\w|\d)+([-+.](\w|\d)+)*@(\w|\d)+([-.](\w|\d)+)*\.\w+([-.]\w+)*/';
        $reg_name = '/^[a-zA-Z0-9_]{3,30}/';
        //返回type 1是手机 2是邮箱 3是用户名
        if (preg_match($reg_email, $userName))
            $type = 'email';
        elseif (preg_match($reg_phone, $userName))
            $type = 'mobile';
        elseif (preg_match($reg_name, $userName))
            $type = 'userName';
        if (empty($type) || (!isset($type)))
            return false;
        return $type;
    }

    /**
     * 检测页面打开速度方法
     */
    public  function checkSpeed(){
        $start = microtime(true);
        $ad_arr[1001] = $this->adDao->getInfo(1, 1001, 1);  //首页导航标签
        $ad_arr[1002] = $this->adDao->getInfo(1, 1002);  //首页导航背景图
        // dd($ad_arr[1002]);
        $ad_arr[2001] = $this->adDao->getInfo(2, 2001);  //首页新旁楼盘
        $ad_arr[2002] = $this->adDao->getInfo(2, 2002);  //首页二手楼盘
        $ad_arr[2003] = $this->adDao->getInfo(2, 2003);  //首页写字楼楼盘

        echo '查导航标签，导航背景， 推荐新楼盘 ， 二手盘， 写字楼， 数据库耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);

        // 查询首页是否有用户 关注的房源或楼盘
        $interest = array();
        if (Auth::check()) {
            $follow = new \App\Dao\User\FollowDao; // 载入关注类
            $where = array('uid' => Auth::user()->id, 'tableType' => 3, 'is_del' => 0); // 关注条件
            $interest = $follow->get_Follow($where);
        }

        echo '查关注， 数据库耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        // dd($interest);
        // 判断如果楼盘链接 为空， 就根据该条数据的 各种Id 拼接出其真实的链接
        $ad_arr[2001] = $this->checkUrl($ad_arr[2001], $interest);
        echo '动态拼接新楼盘链接 耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        $ad_arr[2001] = $this->getCommInfo($ad_arr[2001], 1);
        echo '查新楼盘详情 ES 耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        $ad_arr[2002] = $this->checkUrl($ad_arr[2002], $interest);
        echo '动态拼接二手楼盘链接 耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        $ad_arr[2002] = $this->getCommInfo($ad_arr[2002], 2);
        echo '查二手楼盘详情 ES 耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        $ad_arr[2003] = $this->checkUrl($ad_arr[2003], $interest);
        echo '动态拼接写字楼链接 耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        $ad_arr[2003] = $this->getCommInfo($ad_arr[2003], 3);
        echo '查 写字楼盘 详情 ES 耗时：', microtime(true) - $start , ' 秒', "<br/>";
        $start = microtime(true);
        //判断请求来自PC端还是移动端
        if (USER_AGENT_MOBILE) {
            $viewhtml = 'h5.index.index';
            $cityId = CURRENT_CITYID;    //城市id
            $data = array();
            $data['ad_arr'] = $ad_arr;
            $public = new \App\Http\Controllers\Lists\PublicController();
            //城市区域数据
            $data['cityAreas'] = $public->conversion($public->getCityArea($cityId));
            $data['businessAreas'] = $public->conversion($public->getBusinessAreas($cityId));
            $data['towards'] = \Config::get('conditionConfig.toward.text');     //房屋朝向
            $data['defaultImage'] = '/h5/image/pic1.png';   //图片地址不存在时，显示默认图片
            $data['objectType'] = 'houseSale';              //房屋出售
            $data['sr'] = 's'; //说明是出租还是出售
            $housedao = new \App\Dao\Agent\HouseDao();
            $data['featruestag'] = $housedao->getAllHouseTag(); //所有房源标签
            $list = new ListInputView();
            $list->cityId = $cityId;
            $list->isNew = false;
            $list->order = 'timeCreate';                //按创建时间降序排列
            $list->asc = 0;
            $list->pageset = 3;
            // 查询出售房源信息(索引)
            $search = new Search('hs');
            $houseSaleData = $search->searchHouse($list);  //搜索房源
            if (empty($houseSaleData->error)) {
                $data['houses'] = $houseSaleData->hits->hits;
            }
            //查询楼盘信息（索引)
            $list->isNew = true;
            $search = new Search('c');
            $buildCommunity = $search->searchCommunity($list);   //搜索楼盘
            if (empty($buildCommunity->error)) {
                $builds = $data['builds'] = $buildCommunity->hits->hits;
            }
            echo 'h5页面 获取数据 耗时：', microtime(true) - $start , ' 秒', "<br/>";
            $start = microtime(true);
            $res = view($viewhtml, $data);
            echo 'h5页面 生成 耗时：', microtime(true) - $start , ' 秒', "<br/>";
            die;

        } else {
            $start = microtime(true);
            $res = view('index.index', compact('runtime', 'ad_arr', 'interest'));
            echo 'pc页面 生成 耗时：', microtime(true) - $start , ' 秒', "<br/>";
            die;
        }
    }

    /**
     * 推广位没有数据，从索引取数据
     * @param  $ad_arr  数组
     */
    public function searchCommunityByList($ad_arr){
        $list = new ListInputView();
        $list->cityId = CURRENT_CITYID;  // 城市id
        $list->pageset = 8;        // 取得数目
        $list->asc = 0;      // 倒序
        if(empty($ad_arr[2001])){  // 首页新盘
            $key_2001 = md5('ad_arr_new_by_esCommunity'.$list->cityId);
            if(Cache::store('redis')->has($key_2001)){
                $ad_arr[2001] = Cache::store('redis')->get($key_2001);
            }else{
                $list->order = 'timeCreate';  // 更新时间排序
                $list->isNew = true;
                $search = new Search('c');
                $newCommunity = $search->searchCommunity($list);   //搜索楼盘
                if(!empty($newCommunity->hits->hits)){
                    foreach($newCommunity->hits->hits as $key => $comm){
                        $ad_arr[2001][$key]['fromId'] = $comm->_source->id;
                        $ad_arr[2001][$key]['dbType'] = 1;
                        $ad_arr[2001][$key]['houseType2'] = explode('|',$comm->_source->type2)[0];
                        $ad_arr[2001][$key]['fileName'] = $comm->_source->buildingBackPic;
                        $ad_arr[2001][$key] = (object)$ad_arr[2001][$key];
                    }
                }
                Cache::store('redis')->put($key_2001,$ad_arr[2001],10);
            }

        }
        if(empty($ad_arr[2002])){  // 首页二手盘
            $key_2002 = md5('ad_arr_esf_by_esCommunity'.$list->cityId);
            if(Cache::store('redis')->has($key_2002)){
                $ad_arr[2002] = Cache::store('redis')->get($key_2002);
            }else{
                $list->order = 'saleCount';  // 出售房源总数排序
                $list->isNew = false;
                $list->type1 = 3;
                $search = new Search('c');
                $oldCommunity = $search->searchCommunity($list);   //搜索楼盘
                if(!empty($oldCommunity->hits->hits)){
                    foreach($oldCommunity->hits->hits as $key => $comm){
                        $ad_arr[2002][$key]['fromId'] = $comm->_source->id;
                        $ad_arr[2002][$key]['dbType'] = 2;
                        $ad_arr[2002][$key]['houseType2'] = 301;
                        //$ad_arr[2002][$key]['houseType2'] = explode('|',$comm->_source->type2)[0];
                        $ad_arr[2002][$key]['fileName'] = $comm->_source->buildingBackPic;
                        $ad_arr[2002][$key] = (object)$ad_arr[2002][$key];
                    }
                }
                Cache::store('redis')->put($key_2002,$ad_arr[2002],10);
            }
        }
        if(empty($ad_arr[2003])){  // 首页写字楼
            $key_2003 = md5('ad_arr_office_by_esCommunity'.$list->cityId);
            if(Cache::store('redis')->has($key_2003)){
                $ad_arr[2003] = Cache::store('redis')->get($key_2003);
            }else{
                $list->order = 'rentCount';  // 出租房源总数排序
                $list->isNew = false;
                $list->type1 = 2;
                $search = new Search('c');
                $officeCommunity = $search->searchCommunity($list);   //搜索楼盘
                if(!empty($officeCommunity->hits->hits)){
                    foreach($officeCommunity->hits->hits as $key => $comm){
                        $ad_arr[2003][$key]['fromId'] = $comm->_source->id;
                        $ad_arr[2003][$key]['dbType'] = 2;
                        $ad_arr[2003][$key]['houseType2'] = 201;
                        //$ad_arr[2003][$key]['houseType2'] = explode('|',$comm->_source->type2)[0];
                        $ad_arr[2003][$key]['fileName'] = $comm->_source->buildingBackPic;
                        $ad_arr[2003][$key] = (object)$ad_arr[2003][$key];
                    }
                }
                Cache::store('redis')->put($key_2003,$ad_arr[2003],10);
            }
        }
        return $ad_arr;
    }

    /**
     *  用户登陆注册页面
     * @param  $type    userChoose 注册登陆选择页面、  userLogin 登陆页面、 userRegister 注册页面
     */
    public function userChoose($type){
        if(Auth::check()){
           // if( empty(Auth::user()->userName) && empty(Auth::user()->password) ){  // 手机快速登录  如果用户名、密码空 补充页面
            $this->updateUserLoginTime(Auth::user()->id); //更新用户登录时间
            if( Auth::user()->rId == 7 ){  // 手机快速登录  如果用户名、密码空 补充页面
                return Redirect::to('/myinfo/userSet');
            }
            return Redirect::to('/user/interCommunity/xinF');
        }
        return view('index.'.$type);
    }

    //更新用户登录时间 dfh
    public function updateUserLoginTime($uId){
        $URL = config('hostConfig')['interface_host'].'/interface/user/updateLoginTime';
        $type = 'POST';
        $params = json_encode(['uId'=>$uId]);
        return CurlUtil::MakeCurlFunction($URL, $type, $params); //更新用户登录时间主表
    }
    
    /*
     * ykk
     * 获取文章资讯页
     */
    private function getArticleList(){
        $param = [];
        $cityId = CURRENT_CITYID;
        Redis::connect(config('database.redis.default.host'), 6379);
        Redis::select(13);
        $agent = $this->article->getCityArticleAgent($cityId);
        if(empty($agent)){
            $cityId = 0;
        }
        $res = $this->article->getArticles($cityId);
        $position = $res['position'];
        $param['article'] = [];
        foreach($position as $k => $v){
//            Redis::del('art_'.$cityId.'_'.$v);
            $length = count($position);
            if(!Redis::exists('art_'.$cityId.'_'.$v)){
                if($k <$length - 1){
                    $article = $this->article->getArticleByPosition($v,$cityId);
                }else{
                    $article = $this->article->getArticleWithImg($v,$cityId);
                }
                if(!empty($article)){
                    Redis::set('art_'.$cityId.'_'.$v,json_encode($article));
                }
                $param['article'][$v] = $article;
            }else{
                $param['article'][$v] = json_decode(Redis::get('art_'.$cityId.'_'.$v));
            }
        }
        $param['positionName'] = $res['positionName'];
        $param['position'] = $position;
//        dd($param);
        return $param;
    }
    
    /**
     * 模板二代码
     */
  
    private function PCModel2($cityId){
        Redis::connect(config('database.redis.default.host'), 6379);
        $PCModel2=config('redistime.PCModel2');
        Redis::select($PCModel2['library']);  // 选择6号库
        $theme=config('themeConfig.theme2');
        $title='【搜房网】房地产门户|房地产网|搜房';
        $type1=3;
        $order='timeUpdateLong';
//        $cityId=1;
        $newCommunityDB_key='model2Key_newCommunityES_'.strval($cityId);
//        Redis::del($newCommunityDB_key);
        if(Redis::exists($newCommunityDB_key)){
            $newCommunityES = Redis::get($newCommunityDB_key);
            $newCommunityES=unserialize($newCommunityES);
        }else{
            $newCommunityES=$this->getNewCommunity($cityId,$order,12,$type1);
            $ad_arr=serialize($newCommunityES);
            Redis::set($newCommunityDB_key,$ad_arr);
            Redis::expire($newCommunityDB_key,$PCModel2['outtime']);
        }

        $newHotCommunity=   array_slice($newCommunityES,0,8);
        $newHotCommunity=   array_chunk($newHotCommunity,4);
        $newCommunity   =   array_slice($newCommunityES,8);
//        dd($newCommunity);
        
        /*添加文章模块*/
        $articleList = $this->getNewModelArtList();
        if(!empty($articleList)){
            foreach($articleList as $v){
                $firstContent = explode('</p>',$v->content);
//                dd($fistContent[0]);
                for($i = 0; $i<count($firstContent);$i++){
                    $content = preg_replace("/<(\/?.*?)>/si","", $firstContent[$i]);
                    if(!empty(strlen(trim($content)))){
                        $v->content = $content;
                        break;
                    }
                }
            }
        }
        /**优惠信息**/
        $periods_key='model2Key_periods_'.strval($cityId);
//        Redis::del($periods_key);
        if(Redis::exists($periods_key)){
            $periods = Redis::get($periods_key);
            $periods=unserialize($periods);
        }else{
            $periods=$this->index->getCommunityperiods($cityId , 8,3);
            $periods_img=[];
            if(!empty($periods)){
                $communityIds=[];
                $cityAreaId=[];
                foreach($periods as $v){
                    $communityIds[$v->communityId]=$v->communityId;
                    $cityAreaId[$v->cityAreaId]=$v->cityAreaId;
                }
                $periods_img=$this->index->getNewCommunityImg($communityIds);
                $periods_areaname=$this->index->getNewCommunityArea($cityAreaId);
                if(!empty($periods_areaname)){
                    $periods_areaname=json_decode(json_encode($periods_areaname),true);
                    $periods_areaname=array_column($periods_areaname,null,'id');
                }
                if(!empty($periods_img)){
                    $periods_img=json_decode(json_encode($periods_img),true);
                    $periods_img=array_column($periods_img,null,'communityId');
//                    dd($communityIds,$cityAreaId,$periods_img,$periods,$periods_img);
                }
                foreach($periods as $v){
                    $v->periods_img=!empty($periods_img[$v->communityId])?$periods_img[$v->communityId]['fileName']:'';
                    $v->periods_areaname=!empty($periods_areaname[$v->cityAreaId])?$periods_areaname[$v->cityAreaId]['name']:'';
                }
            }
            $ad_arr=serialize($periods);
            Redis::set($periods_key,$ad_arr);
            Redis::expire($periods_key,$PCModel2['outtime']);
        }

//dd($periods);
        $averageprices = \Config::get('conditionConfig.totalprice.text'); //房源 二手房总价
        $averageprices=array_chunk($averageprices,3);
        $averageprice2 = \Config::get('conditionConfig.averageprice2.text'); //房源 二手房总价
        $averageprice2=array_chunk($averageprice2,2);
        $limit=4;

        $cityarea_key='model2Key_cityarea_'.strval($cityId);
//        Redis::del($cityarea_key);
        if(Redis::exists($cityarea_key)){
            $cityarea = Redis::get($cityarea_key);
            $cityarea=unserialize($cityarea);
            $cityarea_t=[];
            foreach($cityarea as $v1){
                foreach($v1 as $v2){
                    $cityarea_t[]=$v2;
                }
            }
        }else{
            $cityarea_t=$this->index->getCityarea($cityId);
            $cityarea=array_chunk($cityarea_t,4);

            $ad_arr=serialize($cityarea);
            Redis::set($cityarea_key,$ad_arr);
            Redis::expire($cityarea_key,$PCModel2['outtime']);
        }

        $cityareaArr=$cityarea_t;
        $cityareaArr=json_decode(json_encode($cityareaArr),true);
        $cityareaArr=array_column($cityareaArr,'name','id');

        $oldHouses_key='model2Key_oldHouses_'.strval($cityId);
//        Redis::del($oldHouses_key);
        if(Redis::exists($oldHouses_key)){
            $oldHouses = Redis::get($oldHouses_key);
            $oldHouses=unserialize($oldHouses);
        }else{
            $oldHouses['sale']=$this->getOldHouses($cityId,'sale',$order,8,5);
            $oldHouses['rent']=$this->getOldHouses($cityId,'rent',$order,8,5);
            $ad_arr=serialize($oldHouses);
            Redis::set($oldHouses_key,$ad_arr);
            Redis::expire($oldHouses_key,$PCModel2['outtime']);
        }
        $saleHouses=$oldHouses['sale'];
        $rentHouses=$oldHouses['rent'];
//dd($oldHouses);
        return view($theme.'.index.index',compact('averageprice2','title','theme','newHotCommunity','newCommunity','averageprices','cityarea','saleHouses','cityareaArr','rentHouses','articleList','periods'));
    }

    /* 获取新盘 */
    private function getNewCommunity($cityId,$order='timeUpdateLong',$pageset=3,$houseType1=3){
        $tlists = new ListInputView();
        $tlists->isNew = 1;
        $tlists->pageset = $pageset;
        $tlists->cityId = $cityId;
        $tlists->order = $order;
        $tlists->asc = 0;
        $tlists->type1 = $houseType1;
        $search = new Search();
        /* 获取热销楼盘 */
        $hotComm = $search->searchCommunity($tlists);
//         dd($hotComm);
        if(!empty($hotComm->hits)){
            foreach($hotComm->hits->hits as $k => $v){
                $v->_source->type2 = substr($v->_source->type2,0,3);
                $v->_source->type1 = $houseType1;
                $v->_source->priceAverg = 'priceSaleAvg'.strval($houseType1);
                $v->_source->areaname = RedisCacheUtil::getCityAreaNameById($v->_source->cityAreaId);
            }
            $hotComm = $hotComm->hits->hits;
        }else{
            $hotComm = '';
        }
//        dd($hotComm);
        return $hotComm;
    }

    private function getOldHouses($cityId,$saleRent,$order='timeUpdateLong',$pageset=3,$houseType1=3){
        $tlists = new ListInputView();
        $tlists->isNew = 0;
        $tlists->pageset = $pageset;
        $tlists->cityId = $cityId;
        $tlists->order = $order;
        $tlists->asc = 0;
        if(in_array($houseType1,[1,2,3,4])){
            $tlists->type1 = $houseType1;
        }

        if($saleRent == 'sale'){
            $search = new Search('hs');
        }else{
            $search = new Search('hr');
        }
        $hotComm=$search->searchHouse($tlists);

        return !empty($hotComm->hits->hits)?$hotComm->hits->hits:[];
    }
    /**获得广告代理商的手机号**/
    public function getAgentMobile($cityId){
        $cityIds=[0];
        $type=1;
        if($cityId != 0){
            $cityIds[]=$cityId;
        }
        $agentMobile=$this->index->getAgentMobile($cityIds,$type);
        if(empty($agentMobile)){
            return ['target'=>'','national'=>''];
        }
        $agentMobile=json_decode(json_encode($agentMobile),true);
        $agentMobile=json_decode(json_encode($agentMobile),true);
        $agentMobile=array_column($agentMobile,'contactMobile','cityId');
        return ['target'=>!empty($agentMobile[$cityId])?$agentMobile[$cityId]:'','national'=>!empty($agentMobile[0])?$agentMobile[0]:''];
//        dd($agentMobile,$cityIds,$cityId);
    }
    /*
     * 获取新模版的首页资讯
     */
    
    public function getNewModelArtList(){
        $position = 1;
        $cityId = CURRENT_CITYID;
        $agent = $this->article->getCityArticleAgent($cityId);
        if(empty($agent)){
            $cityId = 0;
        }
        $page = 10;
        $article = '';
        $res = $this->article->getPositionArticleList($position,$cityId,$page,$article);
        return $res;
    }

}

    
// echo $a->getNodeNum(1);

//         $start = microtime(true);
//         RedisCacheUtil::wholeCacheInit();
//         $runtime = RedisCacheUtil::testTime($start);


//$msg = '【搜房网】尊敬的用户，感谢您成功注册搜房网，您还可以下载手机搜房网，安装后可通过手机上传认证，刷新房源，下载点击 m.sofang.com,如需帮助拨打客服热线400-6090-798';
//  return app('sms')->sendMsg(array('13811121101'), $msg);
//public function majorRegister() {
//    if(auth::check()){
//        return Redirect::to('/user/home');
//    }else{
//        return view('index.prouserreg');
//    }
//}
///*
//* @ 专业用户登陆页
//* @since 1.0
//* @author niewu
//*/
//public function majorLogin(){
//    if (Auth::check()) {
//        return Redirect::to('/user');
//    }else{
//        return view('index.prouserLogin');
//    }
//}
//    /*
//     * @login  用户登录功能(ajax提交)
//     * @access public
//     * type 1为手机登录    2为邮箱登录  3为用户名登录
//     * @since 1.0
//     * @author niewu
//     */
//    public function login() {
//        $pwd = md5(trim(Input::get("pwd")));
//        $name = trim(Input::get("name"));
//        //返回type 1是手机 2是邮箱 3是用户名
//        $type = $this->checkUserNameType($name);
//        $user = $this->LoginDao->login($name, $pwd, $type);
//        return $user;
//    }




//  2016.5.13 huzhaer修改进行了缩减
// dd($interest);
// 判断如果楼盘链接 为空， 就根据该条数据的 各种Id 拼接出其真实的链接
//        $ad_arr[2001] = $this->checkUrl($ad_arr[2001], $interest);
//        $cache_time_m = 10;
//        if (Cache::has('ad_arr_2001')){
//            $ad_arr[2001] = Cache::get('ad_arr_2001');
//        } else {
//            $ad_arr[2001] = $this->getCommInfo($ad_arr[2001], 1);
//            if ($ad_arr[2001]!= null && array_key_exists('bigTitle', $ad_arr[2001][0])){
//                Cache::put('ad_arr_2001', $ad_arr[2001], $cache_time_m);
//            }
//        }
//        $ad_arr[2002] = $this->checkUrl($ad_arr[2002], $interest);
//        if (Cache::has('ad_arr_2002')){
//            $ad_arr[2002] = Cache::get('ad_arr_2002');
//        } else {
//            $ad_arr[2002] = $this->getCommInfo($ad_arr[2002], 2);
//            if ($ad_arr[2002]!= null && array_key_exists('bigTitle', $ad_arr[2002][0])){
//                Cache::put('ad_arr_2002', $ad_arr[2002], $cache_time_m);
//            }
//        }
//        $ad_arr[2003] = $this->checkUrl($ad_arr[2003], $interest);
//        if (Cache::has('ad_arr_2003')){
//            $ad_arr[2003] = Cache::get('ad_arr_2003');
//        } else {
//            $ad_arr[2003] = $this->getCommInfo($ad_arr[2003], 3);
//            if ($ad_arr[2003]!= null && array_key_exists('bigTitle', $ad_arr[2003][0])){
//                Cache::put('ad_arr_2003', $ad_arr[2003], $cache_time_m);
//            }
//        }


//判断如果楼盘链接 为空， 就根据该条数据的 各种Id 拼接出其真实的链接
//        $ad_arr[2001] = $this->checkUrl($ad_arr[2001], $interest);
//        $cache_time_m = 10;
//        if (Cache::has('ad_arr_2001')){
//            $ad_arr[2001] = Cache::get('ad_arr_2001');
//        } else {
//            $ad_arr[2001] = $this->getCommInfo($ad_arr[2001], 1);
//            if ($ad_arr[2001]!= null && array_key_exists('bigTitle', $ad_arr[2001][0])){
//                Cache::put('ad_arr_2001', $ad_arr[2001], $cache_time_m);
//            }
//        }
//        $ad_arr[2002] = $this->checkUrl($ad_arr[2002], $interest);
//        if (Cache::has('ad_arr_2002')){
//            $ad_arr[2002] = Cache::get('ad_arr_2002');
//        } else {
//            $ad_arr[2002] = $this->getCommInfo($ad_arr[2002], 2);
//            if ($ad_arr[2002]!= null && array_key_exists('bigTitle', $ad_arr[2002][0])){
//                Cache::put('ad_arr_2002', $ad_arr[2002], $cache_time_m);
//            }
//        }
//        $ad_arr[2003] = $this->checkUrl($ad_arr[2003], $interest);
//        if (Cache::has('ad_arr_2003')){
//            $ad_arr[2003] = Cache::get('ad_arr_2003');
//        } else {
//            $ad_arr[2003] = $this->getCommInfo($ad_arr[2003], 3);
//            if ($ad_arr[2003]!= null && array_key_exists('bigTitle', $ad_arr[2003][0])){
//                Cache::put('ad_arr_2003', $ad_arr[2003], $cache_time_m);
//            }
//        }
//
//        dd($ad_arr);
