<?php
namespace App\Dao\Comment;
use App\MongoDB\BrokerUserComment;
/**
 * 用户对经纪人评论接口类
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年12月10日 下午7:30:01
 * @version 1.0
 */
class BrokerUserCommentDao{
	/**
	 * 经纪人评论添加
	 * @param	int 	$brokerId			经纪人id
	 * @param	int 	$uId				用户id
	 * @param	int		$scoreAttitude		服务态度打分
	 * @param	int 	$scoreSkill			装业绩能打分
	 * @param	int 	$scoreProfession	职业素养打分
	 * @param	float 	$score				综合评分
	 * @param	string 	$comment			点评信息
	 * @return 	bool	返回是否添加成功
	 */
	public static function insertComment($brokerId, $uId, $scoreAttitude, $scoreSkill, $scoreProfession, $score, $comment){
		$mongoDB = new BrokerUserComment;
		$mongoDB->brokerId = (int)$brokerId;
		$mongoDB->uId = (int)$uId;
		$mongoDB->scoreAttitude = (int)$scoreAttitude;
		$mongoDB->scoreSkill = (int)$scoreSkill;
		$mongoDB->scoreProfession = (int)$scoreProfession;
		$mongoDB->score = floatval($score);
		$mongoDB->comment = $comment;
		$result = $mongoDB->save();
		return $result;
	}

	/**
	 * 根据经纪人id获取经纪人评论相关数据
	 * @param	int		$where_brokerId			经纪人id
	 * @param	int		$where_scoreRange		评分筛选范围:1.优 2.中 3.差
	 * @param	array	$orderby				排序方式
	 * @param	int		$take					每页条数
	 * @return	object	$result					评论对象集合
	 */
	public static function getComment($where_brokerId = '', $where_scoreRange, $orderby = array('created_at', 'desc'), $take = 4){
		$mongoDB = new BrokerUserComment;
		if($where_brokerId!=''){
			$where_brokerId = (int)$where_brokerId;
			$mongoDB = $mongoDB->where('brokerId', '=', $where_brokerId);
		}else{
			return false;
		}
		if(in_array($where_scoreRange, array(1,2,3))){		//评分范围筛选
			if($where_scoreRange == 1){		//优
				$mongoDB = $mongoDB->where('score', '>', 4);
			}elseif($where_scoreRange == 2){		//中
				$mongoDB = $mongoDB->whereBetween('score', [2, 4]);
			}else{							//差
				$mongoDB = $mongoDB->where('score', '<', 2);
			}
		}
		$result = $mongoDB->orderBy($orderby[0], $orderby[1])->paginate($take);
		return $result;
	}
	
	/**
	 * 根据经纪人id获取经纪人评论数量
	 * @param	int		$where_brokerId			经纪人id
	 * @return	object	$result					评论数量
	 */
	/* public static function getCommentCount($where_houseId = '', $where_houseType){
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
	} */
}