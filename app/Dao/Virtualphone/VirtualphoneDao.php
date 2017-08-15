<?php
namespace App\Dao\Virtualphone;
use DB;


/**
 * 虚拟号
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年1月30日 下午3:41:33
 * @version 1.0
 */
class VirtualphoneDao{
	/**
	 * 获取双方关系虚拟号
	 * @param	string		$customerMobile		客户电话号
	 * @param	string		$brokerMobile		经纪人电话号
	 * @return	string		虚拟号
	 */
	public function getRelationVirtualMobile($customerMobile, $brokerMobile){
		$relationObj = DB::connection('mysql_user')->table('virtualphone_relation')
		->where('customerMobile', $customerMobile)
		->where('brokerMobile', $brokerMobile)
		->first();
		if(is_null($relationObj)){//为空，目前双方没有建立虚拟号关系
			$virtualMobile = '';
		}else{						//存在虚拟号
			$virtualMobile = $relationObj->virtualMobile;
		}
		return $virtualMobile;
	}
	
	/**
	 * 获取与双方都没有关系的虚拟号
	 * @param	string		$customerMobile		客户电话号
	 * @param	string		$brokerMobile		经纪人电话号
	 * @return	obj								虚拟号对象
	 */
	public function getUnRelationVirtualMobile($customerMobile, $brokerMobile){
		$relationObj = DB::connection('mysql_user')->table('virtualphone_relation')->select('poolId')
		->where('customerMobile', $customerMobile)
		->orwhere('brokerMobile', $brokerMobile)
		->get();
		$relation_arr = [];
		if(!is_null($relationObj)){
			foreach($relationObj as $v){
				$relation_arr[] = $v->poolId;
			}
		}
		$poolObj = DB::connection('mysql_user')->table('virtualphone_pool')->where('state', 1);
		if(!empty($relation_arr)){
			$poolObj->whereNotIn('id', $relation_arr);
		}
		$poolObj = $poolObj->orderBy('point', 'DESC')->first();
		return $poolObj;
	}
	
	/**
	 * 根据brokerId获取分销商公司id(enterpriseshopId)
	 * @param	int		$brokerMobile_arr		经纪人电话集合（一个主叫一个被叫，没法确定哪个是经纪人）
	 * @return	int		分销商公司id
	 */
	public function getEnterpriseshopIdByBrokerMobile($brokerMobile_arr){
		$object =DB::connection('mysql_user')->table('brokers')->whereIn('mobile', $brokerMobile_arr)->first();
		if(!empty($object) && !is_null($object)){
			$enterpriseshopId = $object->enterpriseshopId;
			return $enterpriseshopId;
		}else{
			return '';
		}
	}
	
	/**
	 * 根据communityId获取分销商公司id(enterpriseshopId) 
	 * @param	string		$dbName		库名
	 * @param	string		$tbName		楼盘表名
	 * @param	int			$communityId楼盘id
	 * @return	int			分销商公司id
	 */
	public function getEnterpriseshopIdBycommunityId($dbName, $tbName, $communityId){
		$object = DB::connection($dbName)->table($tbName)->find($communityId);
		if(!empty($object) && !is_null($object)){
			$enterpriseshopId = $object->enterpriseshopId;
			return $enterpriseshopId;
		}else{
			return '';
		}
	}
	
	/**
	 * 查找是否有已存在的对应虚拟号码
	 * @param	int		$brokerMobile		经纪人手机号
	 * @param	int		$customerMobile		用户手机号
	 * @return	int		虚拟号码，若不存在则返回null	
	 */
	/* public function getDisplayMobile($brokerMobile, $customerMobile){
// 		if($uId > 0){
// 			$relationObj = DB::connection('mysql_user')->table('virtualphone_relation')
// 			->where('enterpriseshopId', $enterpriseshopId)
// 			->where('uId', $uId)
// 			->first();
// 		}else{
// 			$relationObj = DB::connection('mysql_user')->table('virtualphone_relation')
// 			->where('enterpriseshopId', $enterpriseshopId)
// 			->where('customerMobile', $customerMobile)
// 			->first();
// 		} 

		$relationObj = DB::connection('mysql_user')->table('virtualphone_relation')
		->where('brokerMobile', $brokerMobile)
		->where('customerMobile', $customerMobile)
		->first();
		
		if(is_null($relationObj)){
			return null;
		}
		$displayMobile = $relationObj->virtualMobile;
		return $displayMobile;
	} */
	
	/**
	 * 根据经纪人id获取他的数据
	 */
	/* public function getBrokerDataByBrokerId($brokerId){
		$brokerObj = DB::connection('mysql_user')->table('users')->join('brokers', 'brokers.id', '=', 'users.id')
		->select('users.mobile', 'brokers.enterpriseshopId')
		->where('users.id', $brokerId)->first();
		if(is_null($brokerObj)){
			return null;
		}
		return $brokerObj;
	} */
	
	/**
	 * 创建虚拟号与双方关系数据，并存入表中
	 * @param	string		$customerMobile		客户电话号
	 * @param	string		$brokerMobile		经纪人电话号
	 * @param	int			$poolId				号码池id
	 * @param	int			$virtualMobile		虚拟号码
	 * @param	int			$uId				用户id
	 * @param	int			$brokerId			经纪人id
	 * @param	int			$enterpriseshopId	分销商公司id
	 * @param	int			$communityId		楼盘id
	 * @param	int			$state				虚拟号数据状态：0.未通过话 1.已通过话
	 */
	public function creatRelation($customerMobile, $brokerMobile, $poolId, $virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId, $state){
		$isset = DB::connection('mysql_user')->table('virtualphone_relation')->where('poolId', $poolId)->where('virtualMobile', $virtualMobile)->where('customerMobile', $customerMobile)->where('brokerMobile', $brokerMobile)->first();
		if(is_null($isset)){
			DB::connection('mysql_user')->table('virtualphone_relation')->insert(['poolId'=>$poolId, 'virtualMobile'=>$virtualMobile, 'customerMobile'=>$customerMobile, 'brokerMobile'=>$brokerMobile, 'uId'=>$uId, 'brokerId'=>$brokerId, 'enterpriseshopId'=>$enterpriseshopId, 'communityId'=>$communityId, 'state'=>$state]);
			/* 刷新经纪人在对应楼盘关系表中更新时间，方便轮换 */
		}
	}
	
	/**
	 * 创建虚拟号与双方关系历史数据，并存入表中
	 * @param	string		$customerMobile		客户电话号
	 * @param	string		$brokerMobile		经纪人电话号
	 * @param	int			$poolId				号码池id
	 * @param	int			$virtualMobile		虚拟号码
	 * @param	int			$uId				用户id
	 * @param	int			$brokerId			经纪人id
	 * @param	int			$enterpriseshopId	分销商公司id
	 * @param	int			$communityId		楼盘id
	 * @param	int			$state				虚拟号数据状态：0.未通过话 1.已通过话
	 */
	public function creatRelationLog($customerMobile, $brokerMobile, $poolId, $virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId, $state){
		DB::connection('mysql_user')->table('virtualphone_relationlog')->insert(['poolId'=>$poolId, 'virtualMobile'=>$virtualMobile, 'customerMobile'=>$customerMobile, 'brokerMobile'=>$brokerMobile, 'uId'=>$uId, 'brokerId'=>$brokerId, 'enterpriseshopId'=>$enterpriseshopId, 'communityId'=>$communityId, 'state'=>$state]);
	}
	
	
	/**
	 * 保存新获取的虚拟号到号码池中
	 * @param	string		$virtualMobile		新获取的虚拟号
	 * @param	string		$key				虚拟号key
	 * @param	string		$areaCode			虚拟号区号
	 * @param	int			$state				状态：0.未注册 1.已注册
	 * @return	obj
	 */
	public function creatPool($virtualMobile, $key, $areaCode, $state){
		$isset = DB::connection('mysql_user')->table('virtualphone_pool')->where('virtualMobile', $virtualMobile)->where('areaCode', $areaCode)->first();
		if(is_null($isset)){		//插入
			$insert_id = DB::connection('mysql_user')->table('virtualphone_pool')->insertGetId(['virtualMobile'=>$virtualMobile, 'key'=>$key, 'areaCode'=>$areaCode, 'state'=>$state]);
			$isset = DB::connection('mysql_user')->table('virtualphone_pool')->where('id', $insert_id)->first();
		}else{						//修改
			DB::connection('mysql_user')->table('virtualphone_pool')->where('id', $isset->id)->update(['key'=>$key]);
// 			$isset = DB::connection('mysql_user')->table('virtualphone_pool')->where('id', $insert_id)->first();
			$isset->key = $key;
		}
		return $isset;
	}
	
	/**
	 * 修改号码池数据状态
	 * @param	string		$virtualMobile		虚拟号
	 * @param	int			$state				状态：0.未注册 1.已注册
	 * @return	obj
	 */
	public function editPool($virtualMobile, $state){
		DB::connection('mysql_user')->table('virtualphone_pool')->where('virtualMobile', $virtualMobile)->update(['state'=>$state]);
		$poolObj = DB::connection('mysql_user')->table('virtualphone_pool')->where('virtualMobile', $virtualMobile)->first();
		return $poolObj;
	}
	
	/**
	 * 绑定楼盘信息更新时间刷新
	 */
	public function updateTimeBindingBroker($enterpriseshopId, $communityId, $brokerId){
		if(empty($enterpriseshopId) || empty($communityId) || empty($brokerId)){
			return false;
		}
		$this_time = date('Y-m-d H:i:s');
		return DB::connection('mysql_user')->table('enterpriseshop_bindingbroker')
		->where('enterpriseshopId', $enterpriseshopId)
		->where('communityId', $communityId)
		->where('brokerId', $brokerId)
		->update(['timeUpdate'=>$this_time]);
	}
	/**
	 * 插入一条数据
	 * @author lichen
	 * @param string $dtName 库名
	 * @param string $tbname 表名
	 * @param array $info 要插入的数据
	 */
	public function insertInfo( $dtName, $tbName, $info ){
		return DB::connection($dtName)->table($tbName)->insertGetId( $info );
	}
	/**
	 * 获取所有小号号码
	 */
	public function getVirtualphonePool(){
		$poolObj = DB::connection('mysql_user')->table('virtualphone_pool')->where('state', 1)->get();
		return $poolObj;
	}
	
	/**
	 * 判断之前是否存在通话记录
	 * @param string $Ims 虚拟号
	 * @param string $Telno1 关联号码1
	 * @param string $Telno2 关联号码2
	 * @return bool true.存在 false.不存在
	 */
	public function issetRecordLog($Ims, $Telno1, $Telno2){
		$isset = DB::connection('mysql_user')->table('virtualphone_calllog')
		->whereRaw("BillSubtype='1201' AND ((DisplayNbr='{$Telno1}' AND CalledNbr='{$Telno2}') OR (DisplayNbr='{$Telno2}' AND CalledNbr='{$Telno1}'))")
		->first();
		if(is_null($isset) || empty($isset)){
			return false;
		}else{
			return true;
		}
	}
	
	/**
	 * 判断同一公司下是否有经纪人与该用户的通话记录
	 * @param string $Ims 虚拟号
	 * @param string $Telno1 关联号码1
	 * @param string $Telno2 关联号码2
	 * @return bool true.存在  false.不存在
	 */
	public function issetRecordLogInE($Ims, $Telno1, $Telno2){
		$enterpriseshopId = self::getEnterpriseshopIdByBrokerMobile([$Telno1, $Telno2]);
		if(empty($enterpriseshopId)){		
			return ['brokerType'=>'normal'];//普通经纪人
		}else{
			$relationObj = DB::connection('mysql_user')
			->table('virtualphone_relation')
			->whereRaw("enterpriseshopId='{$enterpriseshopId}' AND state=1 AND virtualMobile='{$Ims}' AND (customerMobile!={$Telno1} AND brokerMobile!={$Telno2}) AND ((customerMobile='{$Telno1}' AND brokerMobile='{$Telno2}') OR (customerMobile='{$Telno2}' AND brokerMobile='{$Telno1}'))")
			->first();
			if(!empty($relationObj) && !is_null($relationObj)){
				return ['brokerType'=>'enterprise', 'result'=>true];//分销商经纪人，存在通话记录
			}else{
				return ['brokerType'=>'enterprise', 'result'=>false];//分销商经纪人，不存在通话记录
			}
		}
	}
	
	/**
	 * 添加客户待登记数据、客户意向信息数据、客户订单数据
	 * @param array $data 传入数据
	 * @return bool true.成功 false.不成功
	 */
	public function insertClientData($data){
		$AlarmMessageUtil = new \App\Http\Controllers\Utils\AlarmMessageUtil;
		$result = [
				'brokerId'=>'',
				'brokerName'=>'',
				'brokerMobile'=>'',
				'customerId'=>'',
				'DisplayNbr'=>$data['CallerNbr'],
				'CustomerNbr'=>'',
				'StartTime'=>$data['StartTime'],
				'EndTime'=>$data['EndTime'],
				'Duration'=>$data['Duration'],
		];
		$EsSearch = new \App\Services\Search();
		$userObj = DB::connection('mysql_user')->table('users')->whereIn('mobile', [$data['DisplayNbr'], $data['CalledNbr']])->get();
		if(count($userObj) == 2){		//成功获取
			foreach($userObj as $user_val){
				if($user_val->type == 1){		//普通用户
					$result['customerId'] = $user_val->id;
					$result['CustomerNbr'] = $user_val->mobile;
				}elseif($user_val->type == 2){		//经纪人用户
					$result['brokerId'] = $user_val->id;
					$brokerName_obj = $EsSearch->searchBrokerById($user_val->id);
					if($brokerName_obj->found == false){		//索引获取经纪人数据失败
						$brokerObj = DB::connection('mysql_user')->table('brokers')->where('id', $user_val->id)->first();
						if(!empty($brokerObj)){
							$AlarmMessageUtil->insertAlarm(['type'=>2, 'title'=>'ES索引获取经纪人数据失败', 'info'=>'经纪人id：'.$user_val->id]);
							$result['brokerMobile'] = $brokerObj->mobile;
						}else{
							$AlarmMessageUtil->insertAlarm(['type'=>3, 'title'=>'数据库获取经纪人数据失败', 'info'=>'经纪人id：'.$user_val->id]);
							return false;
						}
					}else{
						$result['brokerName'] = $brokerName_obj->_source->realName;
						$result['brokerMobile'] = $brokerName_obj->_source->mobile;
					}
				}
			}
		}else{
			return false;
		}
		$relationObj = DB::connection('mysql_user')->table('virtualphone_relation')->where('virtualMobile', $data['CallerNbr'])->where('customerMobile', $result['CustomerNbr'])->where('brokerMobile', $result['brokerMobile'])->first();
		if(is_null($relationObj) || empty($relationObj) || $relationObj->communityId==0){
			$AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'虚拟小号关联数据丢失', 'info'=>'相关数据'.json_encode($data, true)]);
			return false;
		}else{
			$communityId = $relationObj->communityId;
		}
		/* ES索引 */
		$communityObj = $EsSearch->getCommunityByCid($relationObj->communityId, true);
		if($communityObj->found==true){
			$communityName = $communityObj->_source->name;
		}else{
			/* 查表 */
			$communityObj = DB::connection('mysql_house')->table('community')->where('id', $communityId)->first();
			if(!empty($communityObj)){
				$AlarmMessageUtil->insertAlarm(['type'=>2, 'title'=>'ES索引获取新盘数据失败', 'info'=>'楼盘id：'.$relationObj->communityId]);
				$communityName = $communityObj->name;
			}else{
				$AlarmMessageUtil->insertAlarm(['type'=>3, 'title'=>'数据库获取新盘数据失败', 'info'=>'楼盘id：'.$relationObj->communityId]);
				return false;
			}
		}
		
		//插入客户待登记数据
// 		$clientId = self::insertInfo('mysql_user', 'client', ['uId'=>$result['customerId'], 'brokerId'=>$result['brokerId'], 'phone'=>$data['CallerNbr'], 'realPhone'=>$result['CustomerNbr'], 'status1'=>0, 'status2'=>0, 'brokerAdd'=>0]);
		$clientId = self::insertInfo('mysql_user', 'clientele', ['uId'=>$result['customerId'], 'brokerId'=>$result['brokerId'], 'virtualPhone'=>$data['CallerNbr'], 'realPhone'=>$result['CustomerNbr'], 'brokerAdd'=>0]);
		//客户意向信息插入
// 		$clientItentionId = self::insertInfo('mysql_user', 'client_itention', ['clientId'=>$clientId, 'brokerId'=>$result['brokerId'], 'communityId'=>$communityId, 'communityName'=>$communityName, 'status1'=>0, 'status2'=>0]);
		//客户订单状态信息插入
// 		$clientOrderId = self::insertInfo('mysql_user', 'client_order', ['clientItentionId'=>$clientItentionId, 'status1'=>0, 'status2'=>0, 'brokerId'=>$result['brokerId'], 'communityId'=>$communityId, 'communityName'=>$communityName]);
		//客户报备信息插入
// 		self::insertInfo('mysql_user', 'client_report', ['brokerId'=>$result['brokerId'], 'brokerName'=>$result['brokerName'], 'customerId'=>$result['customerId'], 'DisplayNbr'=>$result['DisplayNbr'], 'CustomerNbr'=>$result['CustomerNbr'], 'StartTime'=>$result['StartTime'], 'EndTime'=>$result['EndTime'], 'Duration'=>$result['Duration']]);
		//修改小号关系状态
// 		DB::connection('mysql_user')->table('virtualphone_relation')->where('id', $relationObj->id)->update(['state'=>1]);
	}

	/**
	 * 插入客户报备信息，并返回是否成功
	 * @param array $data 传入数据
	 * @return bool true.成功 false.不成功
	 */
	public function insertClientReport($data){
		$result = [
				'brokerId'=>'',
				'brokerName'=>'',
				'customerId'=>'',
				'DisplayNbr'=>$data['CallerNbr'],
				'CustomerNbr'=>'',
				'StartTime'=>$data['StartTime'],
				'EndTime'=>$data['EndTime'],
				'Duration'=>$data['Duration'],
		];
		$EsSearch = new \App\Services\Search(); 
		$userObj = DB::connection('mysql_user')->table('users')->whereIn('mobile', [$data['DisplayNbr'], $data['CalledNbr']])->get();
		if(count($userObj) == 2){		//成功获取
			foreach($userObj as $user_val){
				if($user_val->type == 1){		//普通用户
					$result['customerId'] = $user_val->id;
					$result['CustomerNbr'] = $user_val->mobile;
				}elseif($user_val->type == 2){		//经纪人用户
					$result['brokerId'] = $user_val->id;
					$brokerName_obj = $EsSearch->searchBrokerById($user_val->id);
					$result['brokerName'] = $brokerName_obj->_source->realName;
				}
			}
		}else{
			return false;
		}
		
		if(empty($result['brokerId']) || empty($result['brokerName']) || empty($result['customerId']) || empty($result['CustomerNbr'])){
			return false;
		}
		DB::connection('mysql_user')->table('client_report')->insert($result);
		return true;
	}
	/**
	 * 修改小号剩余点数
	 * @param string $Virtualphone 小号
	 * @param int $point 小号剩余点数
	 */
	public function updateVirtualphonePoint($Virtualphone='', $point=0){
		if($Virtualphone!='' && $point>=0){
			$result = DB::connection('mysql_user')->table('virtualphone_pool')->where('virtualMobile', $Virtualphone)->update(['point'=>$point]);
		}
	}
	/**
	 * 扣除虚拟号piont点数
	 * @param string $Virtualphone 小号
	 * @param int $point 小号待扣除点数
	 */
	public function minusVirtualphonePoint($Virtualphone='', $point=0){
		if($Virtualphone!='' && $point>=0){
			$result = DB::connection('mysql_user')->table('Virtualphone_pool')->where('virtualMobile', $Virtualphone)->decrement('point', $point);
		}
	}
	
}
