<?php
namespace App\Dao\Audit;
use DB;

/**
 * 楼盘审核驳回记录表
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年1月3日 下午5:48:39
 * @version 1.0
 */
class AuditLogDao{
	
	/**
	 * communityauditlogcache表添加或修改数据
	 * @param	int		$communityId	楼盘id
	 * @param	int		$userId			操作员id
	 * @param	int		$verifierId		审核员id
	 * @param	int		$type			审核类型：
											10.申请审核
											20.审核驳回
											30.申请审核（再次审核）
											40.审核通过
											----------上为未发布，下为已发布-----------
											50.已发布
											60.申请审核
											70.审核驳回
											80.审核通过
											90.申请下架
											100.已下架
	 * @param	string	$fromTable			来自表名
	 * @param	int		$fromId				来自表id
	 * @param	int		$isAdded			整条数据是否新增：0.是新增 1.是修改
	 * @param	string	$fieldName			字段名
	 * @param	string	$fieldName2			字段名（副），只针对community表序列化字段，例如：type101Info、type203Info等，若没有可以为空
	 * @param	string	$oldVal				字段原值，若数据为新建或没有原值，可以为空
	 * @param	string	$newVal				字段新值，若数据为驳回或申诉，可以为空
	 * @param	string	$rejectReason		驳回原因，没有可以为空（第一次申请审核时）
	 * @param	string	$appeal				申诉原因，没有可以为空
	 * @return	bool
	 */
	public function saveCommunityAuditLogCache($communityId, $userId, $verifierId, $type, $fromTable, $fromId, $isAdded, $fieldName, $fieldName2, $oldVal, $newVal, $rejectReason, $appeal){
		$isset = DB::connection('mysql_newhouse0')->table('communityauditlogcache')
			->where('communityId', $communityId)
			->where('fromTable', $fromTable)
			->where('fromId', $fromId)
			->where('fieldName', $fieldName)
			->where('fieldName2', $fieldName2)->take(1)->count();
		if($isset == 0){			//不存在，添加新数据
			DB::connection('mysql_newhouse0')->table('communityauditlogcache')
				->insert(['communityId'=>$communityId, 'userId'=>$userId, 'verifierId'=>$verifierId, 'type'=>$type, 'fromTable'=>$fromTable,
						'fromId'=>$fromId, 'isAdded'=>$isAdded, 'fieldName'=>$fieldName, 'fieldName2'=>$fieldName2,
						'oldVal'=>$oldVal, 'newVal'=>$newVal, 'rejectReason'=>$rejectReason, 'appeal'=>$appeal
				]);
		}elseif($isset == 1){							//存在，在原有数据基础修改
			DB::connection('mysql_newhouse0')->table('communityauditlogcache')
				->where('communityId', $communityId)
				->where('fromTable', $fromTable)
				->where('fromId', $fromId)
				->where('fieldName', $fieldName)
				->where('fieldName2', $fieldName2)
				->update(['userId'=>$userId, 'verifierId'=>$verifierId, 'type'=>$type, 'isAdded'=>$isAdded, 'oldVal'=>$oldVal, 'newVal'=>$newVal, 'rejectReason'=>$rejectReason, 'appeal'=>$appeal]);
		}else{
			return false;
		}
		return true;
	}
	
	/**
	 * communityauditlogstate表添加数据
	 */
	public function saveCommunityAuditLogState($communityId, $fromTable, $fromId, $isAdded){
		$isset = DB::connection('mysql_newhouse0')->table('communityauditlogstate')
			->where('communityId', $communityId)
			->where('fromTable', $fromTable)
			->where('fromId', $fromId)
			->where('isAdded', $isAdded)->take(1)->count();
		if($isset == 0){			//不存在，添加新数据
			DB::connection('mysql_newhouse0')->table('communityauditlogstate')
				->insert(['communityId'=>$communityId, 'fromTable'=>$fromTable, 'fromId'=>$fromId, 'isAdded'=>$isAdded]);
		}
		return true;
	}
	/**
	 * 删除某表某条数据时，同时删除communityauditlogstate和communityauditlogcache的该条数据
	 * @param	int		$communityId		楼盘id
	 * @param	string	$fromTable			来自表名
	 * @param	int		$fromId				来自表id
	 * @param	int		$isAdded			整条数据是否新增：0.是新增 1.是修改
	 */
	public function delCommunityAuditLogState($communityId, $fromTable, $fromId, $isAdded){
		if($isAdded != 0){
			return false;		//不是新增的数据不允许删除
		}
		$isset = DB::connection('mysql_newhouse0')->table('communityauditlogstate')
			->where('communityId', $communityId)
			->where('fromTable', $fromTable)
			->where('fromId', $fromId)
			->where('isAdded', $isAdded)->first();
		if(!is_null($isset)){				//存在
// 			DB::transaction(function($isset){
				DB::connection('mysql_newhouse0')->table('communityauditlogstate')->where('id', $isset->id)->delete();
				DB::connection('mysql_newhouse0')->table('communityauditlogcache')
					->where('communityId', $isset->communityId)->where('fromTable', $isset->fromTable)->where('fromId', $isset->fromId)->where('isAdded', $isset->isAdded)
					->delete();
// 			});
		}
		dd($isset);
		return true;
	}
	
	/**
	 * 获取对应楼盘所有communityauditlogcache（楼盘审核驳回记录暂存表）数据
	 * @param	int		$communityId		楼盘id
	 */
	public function getAllAuditLogCache($communityId){
		$communityauditlogcache = DB::connection('mysql_newhouse0')->table('communityauditlogcache')->where('communityId', $communityId)->get();
		return $communityauditlogcache;
	}
	
	/**
	 * 添加新数据到communityauditlog
	 * 添加完毕后删除communityauditlogcache和communityauditlogstate的相关数据
	 * @return bool
	 */
	public function saveCommunityAuditLog($communityId, $userId, $verifierId, $type, $detail){
		$isset = DB::connection('mysql_newhouse0')->table('communityauditlog')
			->where('communityId', $communityId)->orderBy('id', 'desc')->first();
		if(!is_null($isset) && $isset->type == $type){
			return false;			//不能连续重复添加type相同的审核驳回记录
		}
		$result = DB::connection('mysql_newhouse0')->table('communityauditlog')
			->insert(['communityId'=>$communityId, 'userId'=>$userId, 'verifierId'=>$verifierId, 'type'=>$type, 'detail'=>$detail]);
		if($result == true){			//若添加数据成功则开始删除暂存数据
// 			DB::transaction(function($communityId){
				DB::connection('mysql_newhouse0')->table('communityauditlogstate')->where('communityId', $communityId)->delete();
				DB::connection('mysql_newhouse0')->table('communityauditlogcache')->where('communityId', $communityId)->delete();
// 			});
		dd($result);
		}
	}
	
}