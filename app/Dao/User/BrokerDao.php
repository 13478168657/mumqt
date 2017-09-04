<?php
namespace App\Dao\User;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
use DB;
use Auth;

/**
* BrokerDao
* @author lixiyu
*/
class BrokerDao{
	/**
	* 获取经济人的筛选标签
	*/
	public function getBrokerTag(){
            Redis::connect(config('database.redis.default.host'), 6379);
            $key='DB_brokerTag_all_getBrokerTag';
            $config=config('redistime.brokerListOuttime');
            Redis::select($config['library']);  // 选择8号库 
            if(Redis::exists($key)){
                $result=unserialize(Redis::get($key));
            }else{
		$result=DB::table('brokerTag')->get(['id','name']);
                if(!empty($result)){
                    Redis::set($key,serialize($result));
                    Redis::expire($key,$config['outtime']);
                }

            }
            return $result;
	}

	/**
	* 给经济人留言
	* @param array $data 需要插入的数据
	*/
	public function insertMsg($data){
		return DB::table('brokermessage')->insert($data);
	}

	/**
	 * 获取经济人的工作履历
	 * @param $id
	 * @return mixed
	 */
	public function getResume($id){
		return DB::table('brokerresume')->where('brokerId', $id)->get();
	}

	/**
	 * 获取用户的个性资料
	 * @param $id
	 * @return mixed
	 */
	public function getPersonal($id){
		return DB::table('brokerpersonality')->where('brokerId', $id)->first();
	}
	public function getBrokerweixin($id){
		return DB::table('brokers')->where('id', $id)->value('weixin');
	}
	/**
	* 获取经济人主营板块
	* @param $id 商圈id
	*/
	public function getMainPlate($id){
		return DB::connection('mysql_house')->table('businesstags')->whereIn('id', explode(',', $id))->get(['id','name']);
	}

	/**
	* 获取个人售房业绩
	* @param $id 经济人id
	*/
	public function getSaleScore($id){
		return 'getSaleScore';
	}

	/**
	* 获取个人租房业绩
	* @param $id 经济人id
	*/
	public function getRentScore($id){
		return 'getSaleScore';
	}

	/**
	* 获取个人历史成效套数
	* @param $id 经济人id
	*/
	public function getCompleteScore($id){
		return 'getSaleScore';
	}


	/**
	* 获取经济人发布的房源楼盘
	* @param string $id 楼盘id 
	*/
	public function getCommunity($id){
		return DB::connection('mysql_house')->table('community')->whereIn('id', $id)->get(['id', 'name', 'address', 'type2']);
	}

	/**
	* 获取经纪人发布的二手楼盘当前均价 和 上月的均价
	* @param array $id 楼盘id
	*/
	public function getCommunAvgPrice($id){
		$time = ['changeTime'=>date('ym'), 'changeTime'=>date('Ym', strtotime('last month'))];
		return DB::connection('mysql_statistics')->table('communitystatus')->where($time)->whereIn('communityId', $id)->get(['communityId', 'avgPrice']);
	}

	/**
	* 查询经纪人评论的用户名
	* @param array $uid
	*/
	public function getCommentUser( $uid ){
		return DB::table('customers')->whereIn('id', $uid)->get(['id', 'realName']);
	}
	
	/**
	 * 根据经纪人绑定楼盘信息获取对应经纪人数据
	 * @param int $communityId 楼盘id
	 * @param array $brokerId 经纪人id
	 */
	public function getBrokerByBinding($communityId, $brokerId=''){
		$take = 10;		//获取条数
		if(empty($brokerId)){		//楼盘详情页
			//未登录
			$brokerObj = DB::connection('mysql_user')->table('enterpriseshop_bindingbroker')
			->leftJoin('brokers','enterpriseshop_bindingbroker.brokerId','=','brokers.id')
			->select('enterpriseshop_bindingbroker.*')
			->where('communityId', $communityId)
			->where('enterpriseshopState', '1')
			->orderBy('timeUpdate', 'ASC')
			->take($take)
			->get();
		}else{						//房源详情页、列表页
			if(Auth::check() && Auth::user()->type==1){		//已登录
				$uId = Auth::user()->id;
				$brokerObj = DB::connection('mysql_user')->table('virtualphone_relation')->select('virtualMobile')->where('uId', $uId)->where('brokerId', $brokerId)->first();
			}else{
				return [];
			}
		}
		
		return $brokerObj;
	}

	/**
	 * 获取经纪人的资料
	 * @param $id
	 * @return mixed
	 */
	public function getBroker($id){
		return DB::table('brokers')->where('id', $id)->first();
	}

	/**
	 * 获取经纪人公司的资料
	 * @param $id
	 * @return mixed
	 */
	public function getBrokerCompany($id){
		return DB::table('company')->where('id', $id)->first();
	}
}