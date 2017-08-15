<?php
namespace App\Dao\Comment;
use App\MongoDB\CommunityUserComment;
use App\MongoDB\CommunityCommentThumbLog;
use App\MongoDB\CommunityCommentReplyLog;
/**
 * 用户对楼盘评论接口类
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月10日 上午11:23:34
 * @version 1.0
 */
class CommunityUserCommentDao{
	/**
	 * 楼盘评论添加
	 * @param	int 	$communityId		楼盘id
	 * @param	int 	$uId				用户id
	 * @param	int		$scorePrice			价格打分
	 * @param	int 	$scoreDistrict		地段打分
	 * @param	int 	$scoreTraffic		交通打分
	 * @param	int 	$scoreAround		配套打分
	 * @param	int 	$scoreCondition		环境打分
	 * @param	float 	$scoreAvg			综合评分
	 * @param	string 	$comment			点评信息
	 * @param	int 	$mentionTraffic		提到了交通,1.提到了 0.没提到
	 * @param	int 	$mentionSupport		提到了配套,1.提到了 0.没提到
	 * @param	int 	$mentionPrice		提到了价格,1.提到了 0.没提到
	 * @param	int 	$mentionRoom		提到了户型,1.提到了 0.没提到
	 * @param	int 	$mentionCondition	提到了环境,1.提到了 0.没提到
	 * @param	int 	$mentionPay			提到了支付,1.提到了 0.没提到
	 * @param	int 	$thumbs				点赞数
	 * @param	int 	$replies			回复数
	 * @return 	bool	返回是否添加成功
	 */
	public static function insertComment($communityId, $uId, $scorePrice, $scoreDistrict, $scoreTraffic, $scoreAround, $scoreCondition, $scoreAvg,
			 $comment, $mentionTraffic=0, $mentionSupport=0, $mentionPrice=0, $mentionRoom=0, $mentionCondition=0, $mentionPay=0, $thumbs=0, $replies=0){
		$mongoDB = new CommunityUserComment;
		$mongoDB->communityId = $communityId;
		$mongoDB->uId = $uId;
		$mongoDB->scorePrice = $scorePrice;
		$mongoDB->scoreDistrict = $scoreDistrict;
		$mongoDB->scoreTraffic = $scoreTraffic;
		$mongoDB->scoreAround = $scoreAround;
		$mongoDB->scoreCondition = $scoreCondition;
		$mongoDB->scoreAvg = $scoreAvg;
		$mongoDB->comment = $comment;
		$mongoDB->mentionTraffic = $mentionTraffic;
		$mongoDB->mentionSupport = $mentionSupport;
		$mongoDB->mentionPrice = $mentionPrice;
		$mongoDB->mentionRoom = $mentionRoom;
		$mongoDB->mentionCondition = $mentionCondition;
		$mongoDB->mentionPay = $mentionPay;
		$mongoDB->thumbs = $thumbs;
		$mongoDB->replies = $replies;
		$result = $mongoDB->save();
		return $result;
	}
	
	/**
	 * 根据楼盘id获取楼盘评论相关数据
	 * @param	int		$where_communityId		楼盘id
	 * @param	int		$uId					当前用户id
	 * @param	array	$orderby				排序方式
	 * @param	int		$take					获取条数
	 * @return	object	$result					评论对象集合
	 */
	public static function getComment($where_communityId = '', $uId, $orderby = array('created_at', 'desc'), $take = 3){
		$mongoDB = new CommunityUserComment;
		if($where_communityId!=''){
			$mongoDB = $mongoDB->where('communityId', '=', $where_communityId);
		}else{
			return false;
		}
		$result = $mongoDB->orderBy($orderby[0], $orderby[1])->take($take)->get();
		$result_count = count($result);
		if($result_count > 0){
			$cucId_arr = array();
			foreach($result as $v1){
				$cucId_arr[] = $v1->id;
			}
			$thumbState_arr = self::getThumbState($cucId_arr, $uId);
			if(count($thumbState_arr) == $result_count){
				foreach($result as $k2=>&$v2){
					$v2->isThumbed = $thumbState_arr[$k2];		//isThumbed：当前用户是否已点赞，true.已点赞，false.未点赞
				}
			}
		}
		return $result;
	}
	
	/**
	 * 根据楼盘id获取楼盘评论数量
	 * @param	int		$where_communityId		楼盘id
	 * @return	object	$result					评论数量
	 */
	public static function getCommentCount($where_communityId = ''){
		$mongoDB = new CommunityUserComment;
		if($where_communityId!=''){
			$mongoDB = $mongoDB->where('communityId', '=', $where_communityId);
		}else{
			return false;
		}
		$result = $mongoDB->count();
		return $result;
	}
	
	/**
	 * 评论点赞操作(增加或取消)
	 * @param	int		$cucId		评论id
	 * @param	int		$uId		操作用户id
	 * @param	int		$type		具体操作：1.增加赞 2.取消赞
	 * @return	bool	$result		返回点赞操作成功或失败
	 */
	public static function setThumbs($cucId, $uId, $type){
		if(!in_array($type, array(1,2))){
			return false;
		}
		/* 点赞表操作start */
// 		$thumbObj1 = new CommunityCommentThumbLog;
// 		$thumb_old = $thumbObj1->where('cucId', $cucId)->where('uId', $uId)->first();
		$thumb_old = self::getThumbState($cucId, $uId);
		if(is_null($thumb_old)){			//该用户对该评论没有点赞记录，可点赞，不能取消点赞
			if($type == 1){
				$thumbObj2 = new CommunityCommentThumbLog;
				$thumbObj2->cucId = $cucId;
				$thumbObj2->uId = $uId;
				$result = $thumbObj2->save();
			}else{
				return false;
			}
		}else{								//该用户对该评论有点赞记录，可取消点赞，不能点赞
			if($type == 2){
				$result = $thumb_old->delete();
			}else{
				return false;
			}
		}
		/* 点赞表操作end */
		/* 评论表点赞数量修改start */
		self::setCommentThumbs($cucId, $type);
		/* 评论表点赞数量修改end */
		return $result;
	}
	
	/**
	 * 获取目标评论点赞状态（点过或没点过）
	 * @param	int/array		$cucId		评论id:单个数据或数组。案例：123/array(123,124,125)
	 * @param	int				$uId		用户id
	 * @return	bool/array		$result		返回是否点过赞：若是数组，点过数组中true，没点过数组中false；或不是数组，点过返回查到的对象数据，没点过返回false
	 */
	public static function getThumbState($cucId, $uId){
		$thumbObj = new CommunityCommentThumbLog;
		if(is_array($cucId)){		//多个评论同时获取点赞状态
			$result = array();
			$thumbObj = $thumbObj->where('uId', $uId)->whereIn('cucId', $cucId)->get();
			foreach($cucId as $k=>$v){
				$result[$k] = false;
				foreach($thumbObj as $t){
					if($v == $t->cucId){
						$result[$k] = true;
						break;
					}
				}
			}
			return $result;
		}else{						//单个评论获取点赞状态
			$result = $thumbObj->where('uId', $uId)->where('cucId', $cucId)->first();
			return $result;
		}
	}
	
	/**
	 * 操作评论记录表点赞个数+1或-1
	 * @param	int		$id		评论id
	 * @param	int		$type	具体操作：1.赞+1 2.赞-1
	 */
	public static function setCommentThumbs($id, $type){
		$commentObj = new CommunityUserComment;
		$commentObj = $commentObj->find($id);
		if(!is_null($commentObj)){
			if($type==1){		//增加赞
				$commentObj->thumbs = $commentObj->thumbs + 1;
			}else{
				$commentObj->thumbs = $commentObj->thumbs - 1;
			}
			$commentObj->save();
		}
	}
	
	/**
	 * 添加评论回复
	 * @param	int		$cucId		评论id
	 * @param	int		$uId		添加回复的用户id
	 * @param	string	$reply		回复内容
	 * @return	bool	$result		是否成功添加回复
	 */
	public static function insertReply($cucId, $uId, $reply){
		//添加回复数据
		$replyObj = new CommunityCommentReplyLog;
		$replyObj->cucId = $cucId;
		$replyObj->uId = $uId;
		$replyObj->reply = $reply;
		$result = $replyObj->save();
		if($result==true){
			self::setCommentReplys($cucId);
		}
		return $result;
	}
	
	/**
	 * 操作评论记录表回复个数+1
	 * @param	int		$id		评论id
	 */
	public static function setCommentReplys($id){
		$commentObj = new CommunityUserComment;
		$commentObj = $commentObj->find($id);
		if(!is_null($commentObj)){
			$commentObj->replies = $commentObj->replies + 1;
			$commentObj->save();
		}
	}
}
