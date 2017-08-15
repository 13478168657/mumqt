<?php
namespace App\Http\Controllers\Search;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use App\ListInputView;
use App\Services\Search;
use Input;
use App\Http\Controllers\Utils\RedisCacheUtil;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
/**
* description of HomeSearchController
* 针对首页的搜索 关键字 
* @author lixiyu
*/

class HomeSearchController extends Controller{
	public $shengmu = array('b','p','m','f','d','t','n','l','g','k','h','j','q','x','z','c','s','r','y','w');
	// 返回关键字推荐
	public function get_Recommend()
	{
//		dd(Input::get());
		$keywords = Input::get('keywords', '');
		$type	  = Input::get('tp', '');
		$isnew    = Input::get('isnew','');
		$type1	  = Input::get('type1', '');
		$type2	  = Input::get('type2', '');
                $cityId   = Input::get('cityId','');

		$inputView = new ListInputView;
		$inputView->pageset = 10;
		$inputView->cityId  = CURRENT_CITYID;
		if($type == 'new'){
			$search = new Search();
			$inputView->isNew = true;
			$inputView->keyword = $keywords;
			$res = $search->searchCommunity($inputView);
		}

		if($type == 'sale'){
			$search = new Search('hs');
			$inputView->keyword = $keywords;
			$res = $search->searchHouse($inputView);
		}

		if($type == 'rent'){
			$search = new Search('hr');
			$inputView->keyword = $keywords;
			$res = $search->searchHouse($inputView);
		}

		if($type == 'xzl'){
			$search = new Search();
			$inputView->type1 = 2;
			$inputView->keyword = $keywords;
			$res = $search->searchCommunity($inputView);
		}

		if($type == 'sp'){
			$search = new Search();
			$inputView->type1 = 1;
			$inputView->keyword = $keywords;
			$res = $search->searchCommunity($inputView);
		}
		if($type == 'loupan'){
			$search = new Search();
			$inputView->type1 = $type1;
                        $inputView->cityId = $cityId;
			if($isnew == 1){
				$inputView->isNew = true;
			}else{
				$inputView->isNew = false;
			}
			$inputView->keyword = $keywords;
			$res = $search->searchCommunity($inputView);
		}
		if(empty($res->hits->hits)) return 0;
		if(count($res->hits->hits) > 5 ){
			$res = array(
					$res->hits->hits[0],
					$res->hits->hits[1],
					$res->hits->hits[2],
					$res->hits->hits[3],
					$res->hits->hits[4],
				);
		}else{
			$res = $res->hits->hits;
		}
		return $res;
	}

	/**
	 * 检测搜索的字符，判定是否需要拆分
	 * @param string $str
	 * @param int    $num  匹配的次数
	 * @return string $str
	 */
	public function checkWords($str, &$num){
		$num = 1;
		for($i = 0; $i < strlen($str); $i++){
			if(($i + 1) < strlen($str) && in_array($str{$i}, $this->shengmu) && in_array($str{$i+1}, $this->shengmu)){
				$str = substr($str, 0, $i+1).'*'.substr($str, $i+1);
				$num ++;
			}
			continue;
		}
		return $str;
	}

	/**
	 * 将拼音查出的楼盘名称排序返回
	 * @param mixed $words
	 * @param int $type  // type 为0 是拼音  1 是汉字  默认为0
	 */
	public function getKeyWords($words, $type = 0){
		if(empty($words)) return 0;
		$res = array();
		$len = (count($words) >= 8) ? 8 : count($words);
		for($i = 0; $i < $len; $i++){
			$item = explode(':', $words[$i]);
			$item = explode('|', $item[1]);
			if($type == 0){
				$res[$i]['_source'] = array(
					'name'      => !empty($item[1]) ? $item[1] : '' ,
					'id'        => !empty($item[2]) ? $item[2] : '' ,
				);
			}else{
				$res[$i]['_source'] = array(
					'name'      => !empty($item[0]) ? $item[0] : '' ,
					'id'        => !empty($item[1]) ? $item[1] : '' ,
				);
			}

		}

		$info = array();
		$info['res']   = $res;
		return $info;
	}

	/**
	 * 首页搜索 其它 开发人员 慎用 redis
	 * 如需使用 请把方法名修改为getHomeSearch
	 */
	public function lishi_getHomeSearch(){
	    return 0;exit;
		$keywords = Input::get('keywords', ''); // 搜索的关键字
		$type	  = Input::get('tp', ''); // 搜索类型，判断是新盘还是二手盘
		$type1	  = Input::get('tp1', ''); // 楼盘物业主物业类型
		$sr       = Input::get('sr', ''); // 出租或出售 1出租、2出售
		if(empty($type) || empty($type1)) return 0;
		if(empty($keywords)){
			$searchInfo = array('tp'=>$type, 'tp1'=>$type1, 'sr'=>$sr);
			return $this->getHomeSearchByEmpty($searchInfo);
		}
		$patt     = '/^\w+$/'; // 判断搜索关键字是不是英文
		if(preg_match($patt, $keywords) > 0){
			$keywords = strtolower($keywords); // 将拼音字母全部转换为小写
			$keywords = $this->checkWords($keywords, $num);
			$searchInfo = array('kw'=>$keywords, 'tp1'=>$type1);
			if($type == 'new'){
				$words = RedisCacheUtil::getNewCommunityNameByPy($searchInfo);
			}else{
				$words = RedisCacheUtil::getOldCommunityNameByPy($searchInfo);
			}
			if(empty($words)) return 0;
			$res = $this->getKeyWords($words);
			return $res;
		}else{
			$searchInfo = array('kw'=>$keywords, 'tp1'=>$type1);
			if($type == 'new'){
				$words = RedisCacheUtil::getNewCommunityNameByName($searchInfo);
			}else{
				$words = RedisCacheUtil::getOldCommunityNameByName($searchInfo);
			}
			if(empty($words)) return 0;
			$res = $this->getKeyWords($words, 1);
			return $res;
		}

	}

	/*
	 *  搜索时推荐房源最多的楼盘
	 * @param array $searchInfo = array('tp'=>$type, 'tp1'=>$type1, 'sr'=>$sr);
	 */
	public function getHomeSearchByEmpty($searchInfo){
            if($searchInfo['tp1'] == '*'){
                    $searchInfo['tp1'] = '3';
            }
            if($searchInfo['tp'] == 'new'){
                    $flag = 1;
            }else{
                    $flag = 0;
            }
            if($searchInfo['sr'] == '1'){
                    $orderByFields = 'rentCount';
            }else{
                    $orderByFields = 'saleCount';
            }
            
            $key = 'getHomeSearchByEmpty_cityId_'.CURRENT_CITYID.'_type1_'.$searchInfo['tp1'].'_isNew=>'.$flag.'_order_'.$orderByFields;
            $config=config('redistime.homeSearchOnlyOuttime');
            Redis::connect(config('database.redis.default.host'), 6379);
            Redis::select($config['library']);  // 选择9号库 
            if(Redis::exists($key)){
                $info=unserialize(Redis::get($key));
            }else{
                $search = new Search();
                $list   = new ListInputView();
                $list->cityId = CURRENT_CITYID;
                $list->type1  = $searchInfo['tp1'];
                $list->isNew = $flag;
                $list->order  = $orderByFields;

                $res = $search->searchCommunity($list);
                if(empty($res->hits->hits)) return 0;
                $count = 8;
                $info  = array();
                if(count($res->hits->hits) > $count ){
                        for($i = 0; $i < $count; $i++){
                                $info['res'][] = $res->hits->hits[$i];
                        }
                }else{
                        $info['res']  = $res->hits->hits;
                }
                if(!empty($info)){
                    Redis::set($key,serialize($info));
                    Redis::expire($key,$config['outtime']);                    
                }

            }
            return $info;
	}

	/**
	 * 首页搜索 其它 开发人员 慎用 es
	 */
	public function getHomeSearch(){
		$keywords = Input::get('keywords', ''); // 搜索的关键字
		$type	  = Input::get('tp', ''); // 搜索类型，判断是新盘还是二手盘
		$type1	  = Input::get('tp1', ''); // 楼盘物业主物业类型
		$sr       = Input::get('sr', ''); // 出租或出售 1出租、2出售
		if(empty($type) || empty($type1)) return 0;
		$isNew = ($type == 'new')?true:false;
		$search = new Search();
		$results = json_decode($search->ESAutoComplete($keywords,$type1,$isNew));
		//获取搜索数据
		if(!isset($results->error)){
			$words = $results->hits->hits;
			if(empty($words)) return 0;
			$res = $this->convertWords($words);
			$res['versionNum'] = Input::get('v');
			return $res;
		}else{
			return 0;
		}
	}
	//处理数据
	public function convertWords($words){
		$res = array();
		foreach($words as $k=>$v){
			$res[$k]['_source'] = array(
				'id'        => $v->_id,
				'name'      => $v->fields->name[0]
			);
		}
		$info = array();
		$info['res']   = $res;
		return $info;
	}
}


