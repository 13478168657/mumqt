<?php
namespace App\Dao\Comment;
use App\MongoDB\HouseUserComment;
use App\MongoDB\HouseCommentReplyLog;
use App\MongoDB\HouseCommentThumbLog;
/**
 * 用户对房源评论接口类
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月10日 下午7:30:01
 * @version 1.0
 */
class HouseUserCommentDao{
	/**
	 * 房源评论添加
	 * @param	int 	$houseId			房源id
	 * @param	string	$type				对应表名：'houserent','houserent2','housesale','housesale2'
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
	public static function insertComment($houseId, $type, $uId, $scorePrice, $scoreDistrict, $scoreTraffic, $scoreAround, $scoreCondition, $scoreAvg,
			 $comment, $mentionTraffic=0, $mentionSupport=0, $mentionPrice=0, $mentionRoom=0, $mentionCondition=0, $mentionPay=0, $thumbs=0, $replies=0){
		if(!in_array($type, array('houserent','houserent2','housesale','housesale2'))){
			return false;
		}
		$mongoDB = new HouseUserComment;
		$mongoDB->houseId = $houseId;
		$mongoDB->type = $type;
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
	 * 根据房源id获取房源评论相关数据
	 * @param	int		$where_houseId			房源id
	 * @param	int		$where_houseType		房源对应表明：'houserent','houserent2','housesale','housesale2'
	 * @param	int		$uId					当前用户id
	 * @param	array	$orderby				排序方式
	 * @param	int		$take					获取条数
	 * @return	object	$result					评论对象集合
	 */
	public static function getComment($where_houseId = '', $where_houseType, $uId, $orderby = array('created_at', 'desc'), $take = 3){
		if(!in_array($where_houseType, array('houserent','houserent2','housesale','housesale2'))){
			return false;
		}
		$mongoDB = new HouseUserComment;
		if($where_houseId!=''){
			$mongoDB = $mongoDB->where('houseId', '=', $where_houseId)->where('type', $where_houseType);
		}else{
			return false;
		}
		$result = $mongoDB->orderBy($orderby[0], $orderby[1])->take($take)->get();
		$result_count = count($result);
		if($result_count > 0){
			$hucId_arr = array();
			foreach($result as $v1){
				$hucId_arr[] = $v1->id;
			}
			$thumbState_arr = self::getThumbState($hucId_arr, $uId);
			if(count($thumbState_arr) == $result_count){
				foreach($result as $k2=>&$v2){
					$v2->isThumbed = $thumbState_arr[$k2];		//isThumbed：当前用户是否已点赞，true.已点赞，false.未点赞
				}
			}
		}
		return $result;
	}
	
	/**
	 * 根据房源id获取房源评论数量
	 * @param	int		$where_houseId			房源id
	 * @param	int		$where_houseType		房源对应表明：'houserent','houserent2','housesale','housesale2'
	 * @return	object	$result					评论数量
	 */
	public static function getCommentCount($where_houseId = '', $where_houseType){
		if(!in_array($where_houseType, array('houserent','houserent2','housesale','housesale2'))){
			return false;
		}
		$mongoDB = new HouseUserComment;
		if($where_houseId!=''){
			$mongoDB = $mongoDB->where('houseId', '=', $where_houseId)->where('type', $where_houseType);
		}else{
			return false;
		}
		$result = $mongoDB->count();
		return $result;
	}
	
	/**
	 * 评论点赞操作(增加或取消)
	 * @param	int		$hucId		评论id
	 * @param	int		$uId		操作用户id
	 * @param	int		$type		具体操作：1.增加赞 2.取消赞
	 * @return	bool	$result		返回点赞操作成功或失败
	 */
	public static function setThumbs($hucId, $uId, $type){
		if(!in_array($type, array(1,2))){
			return false;
		}
		/* 点赞表操作start */
		$thumb_old = self::getThumbState($hucId, $uId);
		if(is_null($thumb_old)){			//该用户对该评论没有点赞记录，可点赞，不能取消点赞
			if($type == 1){
				$thumbObj2 = new HouseCommentThumbLog;
				$thumbObj2->hucId = $hucId;
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
		self::setCommentThumbs($hucId, $type);
		/* 评论表点赞数量修改end */
		return $result;
	}
	
	/**
	 * 获取目标评论点赞状态（点过或没点过）
	 * @param	int/array		$hucId		评论id:单个数据或数组。案例：123/array(123,124,125)
	 * @param	int				$uId		用户id
	 * @return	bool/array		$result		返回是否点过赞：若是数组，点过数组中true，没点过数组中false；或不是数组，点过返回查到的对象数据，没点过返回false
	 */
	public static function getThumbState($hucId, $uId){
		$thumbObj = new HouseCommentThumbLog;
		if(is_array($hucId)){		//多个评论同时获取点赞状态
			$result = array();
			$thumbObj = $thumbObj->where('uId', $uId)->whereIn('hucId', $hucId)->get();
			foreach($hucId as $k=>$v){
				$result[$k] = false;
				foreach($thumbObj as $t){
					if($v == $t->hucId){
						$result[$k] = true;
						break;
					}
				}
			}
			return $result;
		}else{						//单个评论获取点赞状态
			$result = $thumbObj->where('uId', $uId)->where('hucId', $hucId)->first();
			return $result;
		}
	}

	/**
	 * 操作评论记录表点赞个数+1或-1
	 * @param	int		$id		评论id
	 * @param	int		$type	具体操作：1.赞+1 2.赞-1
	 */
	public static function setCommentThumbs($id, $type){
		$commentObj = new HouseUserComment;
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
	 * @param	int		$hucId		评论id
	 * @param	int		$uId		添加回复的用户id
	 * @param	string	$reply		回复内容
	 * @return	bool	$result		是否成功添加回复
	 */
	public static function insertReply($hucId, $uId, $reply){
		//添加回复数据
		$replyObj = new HouseCommentReplyLog;
		$replyObj->hucId = $hucId;
		$replyObj->uId = $uId;
		$replyObj->reply = $reply;
		$result = $replyObj->save();
		if($result==true){
			self::setCommentReplys($hucId);
		}
		return $result;
	}
	
	/**
	 * 操作评论记录表回复个数+1
	 * @param	int		$id		评论id
	 */
	public static function setCommentReplys($id){
		$commentObj = new HouseUserComment;
		$commentObj = $commentObj->find($id);
		if(!is_null($commentObj)){
			$commentObj->replies = $commentObj->replies + 1;
			$commentObj->save();
		}
	}
}