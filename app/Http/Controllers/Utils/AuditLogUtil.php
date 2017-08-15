<?php
namespace App\Http\Controllers\Utils;
/**
 * 楼盘相关数据审核记录生成 
 * 
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月29日 下午2:20:53
 * @version 1.0
 */
class AuditLogUtil{
	public $auditLog;
	public function __construct($auditLog = array()){
		$this->auditLog = $auditLog;
	}
	/**
	 * 录入待审核数据
	 * @param	int		$type		审核状态：
	 * 								10.申请审核
	 * 								20.审核驳回
	 * 								30.申请审核（再次审核）
	 * 								40.审核通过
	 * 					----------上为未发布，下为已发布-----------
	 * 								50.已发布
	 * 								60.申请审核
	 * 								70.审核驳回
	 * 								80.审核通过
	 * 								90.申请下架
	 * 								100.已下架
	 * @param	string	$fromTable	所在表
	 * @param	int		$fromId		所在表主键id
	 * @param	string	$fieldName	字段名称
	 * @param	string	$fieldName2	字段名称2，针对community表序列化字段
	 * @param	string	$oldVal		原值
	 * @param	string	$newVal		新值
	 * @param	string	$rejectReason	驳回原因
	 * @param	string	$appeal		申诉原因
	 * @return	array	生成数组
	 * 
	 * 返回数组结构：
	 * array(
	 * 		'【表名】'=>array(
	 * 			【表id】=>array(
	 * 				'isAdded'=>0,							//整条数据是否新增：0.是新增 1.是修改
	 * 				array(
	 * 					'fieldName'=>'【字段名】',
	 * 					'fieldName2'=>'【字段名】',			//只针对community表序列化字段，例如：type101Info、type203Info等，若没有可以为空
	 * 					'oldVal'=>'【字段原值】',				//若数据为新建或没有原值，可以为空
	 * 					'newVal'=>'【字段新值】',				//若数据为驳回或申诉，可以为空
	 * 					'rejectReason'=>'【驳回原因】'		//没有可以为空（第一次申请审核时）
	 * 					'appeal'=>【申诉原因】				//没有可以为空
	 * 				)
	 * 			)
	 * 		),
	 * 		'【表名】'=>array(
	 * 			【表id】=>array(
	 * 				'isAdded'=>0,
	 * 				array(
	 * 					'fieldName'=>'【字段名】',
	 * 					'fieldName2'=>'【字段名】',			
	 * 					'oldVal'=>'【字段原值】',				
	 * 					'newVal'=>'【字段新值】',				
	 * 					'rejectReason'=>'【驳回原因】'		
	 * 					'appeal'=>【申诉原因】				
	 * 				),
	 * 				array(
	 * 					'fieldName'=>'【字段名】',
	 * 					'fieldName2'=>'【字段名】',			
	 * 					'oldVal'=>'【字段原值】',				
	 * 					'newVal'=>'【字段新值】',				
	 * 					'rejectReason'=>'【驳回原因】'		
	 * 					'appeal'=>【申诉原因】				
	 * 				)
	 * 			),
	 * 			【表id】=>array(
	 * 				'isAdded'=>0,
	 * 				array(
	 * 					'fieldName'=>'【字段名】',
	 * 					'fieldName2'=>'【字段名】',			
	 * 					'oldVal'=>'【字段原值】',				
	 * 					'newVal'=>'【字段新值】',				
	 * 					'rejectReason'=>'【驳回原因】'		
	 * 					'appeal'=>【申诉原因】				
	 * 				),
	 * 				array(
	 * 					'fieldName'=>'【字段名】',
	 * 					'fieldName2'=>'【字段名】',			
	 * 					'oldVal'=>'【字段原值】',				
	 * 					'newVal'=>'【字段新值】',				
	 * 					'rejectReason'=>'【驳回原因】'		
	 * 					'appeal'=>【申诉原因】				
	 * 				)
	 * 			)
	 * 		)
	 * )
	 */
/* 	public function RecordAuditLog($type, $fromTable, $fromId, $fieldName, $fieldName2, $oldVal, $newVal, $rejectReason, $appeal){
		$auditLog = $this->auditLog;
		$isExist = self::isExist($fromTable, $fromId, $fieldName, $fieldName2);
		if($isExist){		//存在
			foreach($auditLog[$fromTable][$fromId] as $k=>$v){
				if(empty($v['fieldName2'])){
					if($v['fieldName']==$fieldName && empty($v['fieldName2'])){
						$auditLog[$fromTable][$fromId][$k] = array(
								'fieldName'=> $fieldName,
								'fieldName2'=>$fieldName2,
								'oldVal'=>$oldVal,
								'newVal'=>$newVal,
								'rejectReason'=>$rejectReason,
								'appeal'=>$appeal
						);
						break;
					}
				}else{
					if($v['fieldName']==$fieldName && $v['fieldName2']==$fieldName2){
						$auditLog[$fromTable][$fromId][$k] = array(
								'fieldName'=> $fieldName,
								'fieldName2'=>$fieldName2,
								'oldVal'=>$oldVal,
								'newVal'=>$newVal,
								'rejectReason'=>$rejectReason,
								'appeal'=>$appeal
						);
						break;
					}
				}
			}
		}else{				//不存在
			$auditLog[$fromTable][$fromId][] = array(
					'fieldName'=> $fieldName,
					'fieldName2'=>$fieldName2,
					'oldVal'=>$oldVal,
					'newVal'=>$newVal,
					'rejectReason'=>$rejectReason,
					'appeal'=>$appeal
			);
		}
		$this->auditLog = $auditLog;
		return $this->auditLog;
	} */
	/**
	 * 判断字段是否存在
	 * @param	string	$fromTable	所在表
	 * @param	int		$fromId		所在表主键id
	 * @param	string	$fieldName	字段名称
	 * @param	string	$fieldName2	字段名称2，针对community表序列化字段
	 * @return	bool	是否存在：true.存在 false.不存在
	 */
/* 	public function isExist($fromTable, $fromId, $fieldName, $fieldName2){
		$auditLog = $this->auditLog;
		$isExist = false;		//该条数据不存在
		if(!empty($auditLog)){
			if(isset($auditLog[$fromTable][$fromId][0])){
				foreach($auditLog[$fromTable][$fromId] as $v){
					if(empty($v['fieldName2']) && empty($v['fieldName2'])){
						if($v['fieldName'] == $fieldName){
							return true;		//存在
						}
					}else{
						if($v['fieldName']==$fieldName && $v['fieldName2']==$fieldName2){
							return true;		//存在
						}
					}
				}
			}
		}
		return $isExist;
	} */
	
	/**
	 * 录入待审核数据（暂存）
	 * 每修改一个字段执行一次该函数
	 */
	public function RecordAuditLogCache($communityId, $userId, $verifierId, $type, $fromTable, $fromId, $isAdded, $fieldName, $fieldName2, $oldVal, $newVal, $rejectReason, $appeal ){
		$auditLogObj = new \App\Dao\Audit\AuditLogDao;
		$auditLogObj->saveCommunityAuditLogCache($communityId, $userId, $verifierId, $type, $fromTable, $fromId, $isAdded, $fieldName, $fieldName2, $oldVal, $newVal, $rejectReason, $appeal);
		$auditLogObj->saveCommunityAuditLogState($communityId, $fromTable, $fromId, $isAdded);
	}
	
	/**
	 * 删除某表某条数据时，同时删除communityauditlogstate和communityauditlogcache的数据
	 */
	public function delAuditLog($communityId, $fromTable, $fromId, $isAdded){
		$auditLogObj = new \App\Dao\Audit\AuditLogDao;
		$auditLogObj->delCommunityAuditLogState($communityId, $fromTable, $fromId, $isAdded);
	}
	/**
	 * 整体提交（审核、驳回、通过等）某一楼盘时，
	 * 	communityauditlog表添加一条新数据，
	 * 	communityauditlogstate、communityauditlogcache和communityauditlog表相关数据删除。
	 * @param	int		$communityId	楼盘ID
	 */
	public function submitAuditLog($communityId, $userId=0, $verifierId=0, $type){
		if(empty($communityId) || empty($type)){
			return false;				//楼盘id和审核类型不能为空（0）
		}
		$auditLogObj = new \App\Dao\Audit\AuditLogDao;
		$communityauditlogcache = $auditLogObj->getAllAuditLogCache($communityId);		//获取所有审核字段数据
		/* 将数据进行整合begin */
		$data = array();
		if(!is_null($communityauditlogcache)){
			foreach($communityauditlogcache as $k=>$v){
				$data[$v->fromTable][$v->fromId]['isAdded'] = $v->isAdded;
				$data[$v->fromTable][$v->fromId][] = array(
						'fieldName' => $v->fieldName,
						'fieldName2' => $v->fieldName2,
						'oldVal' => $v->oldVal,
						'newVal' => $v->newVal,
						'rejectReason' => $v->rejectReason,
						'appeal' => $v->appeal
				);
				if(empty($userId)){
					$userId = $v->userId;
				}
				if(empty($verifierId)){
					$verifierId = $v->verifierId;
				}
			}
		}
		/* 将数据进行整合end */
		if(empty($userId) && empty($verifierId)){
			return false;				//操作用户id和审核用户id不能同时为空（0）
		}
		$detail = empty($data) ? '' : serialize($data);
		$auditLogObj->saveCommunityAuditLog($communityId, $userId, $verifierId, $type, $detail);	//保存整合好的审核数据并删除暂存数据
	}
}