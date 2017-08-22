<?php
namespace App\Dao\Agent;

use DB;
use App\Http\Controllers\Utils\UserIdUtil;
use Auth;

/**
* Description of MySouFangDao
* 经纪人管理后台  我的搜房数据访问对象
* @author lixiyu
* @since 1.0
*/
class MySouFangDao{
	public $usertable;

    public function __construct() {
        $datebase = new UserIdUtil();
        $id = Auth::user()->id;
        $this->usertable = $datebase->getNodeNum($id);
    }

    /**
     * 根据id更新用户的个人资料信息
     * @since 1.0
     * @author lixiyu
     * @param string $tableName 需要修改的表的表名
     * @param array $info 需要变更的信息 以键值对的形式 例：array( 字段名=>值 )
     * @param mix $id 修改的id 
     * @return bool 成功返回true 失败返回false
     */
    public function upInfo($tableName, $info, $id) {
    	// DB::connection("mysql_user$this->usertable")->enableQueryLog();
        $call = DB::table($tableName)->where('id', $id)->update($info);
		// var_dump(DB::connection("mysql_user$this->usertable")->getQueryLog());exit;
        return $call;
    }
}