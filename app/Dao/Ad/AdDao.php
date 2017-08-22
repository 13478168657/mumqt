<?php
namespace App\Dao\Ad;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展


/**
 * 广告位信息
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年2月1日 下午6:56:25
 * @version 1.0
 */
class AdDao{
	/**
	 * 获取广告位信息
	 * @param	int		$type1		广告位分类1
	 * @param	int		$type2		广告位分类2
	 * @param	int		$count		获取数量
	 */
	public function getInfo($type1, $type2, $count = ''){
            Redis::connect(config('database.redis.default.host'), 6379);
            
            $config=config('redistime.indexOuttime');
            
            Redis::select($config['library']);  // 选择6号库 
		if($type1 == 1){			//广告位物料，关联表ad_advertising
			$cityId = !empty(CURRENT_CITYID) ? CURRENT_CITYID : 0 ; // 判断当前的cityId是否存在
			if($cityId != 1){
				$cityId = 0;
			}
			$key='DB_mysql_house_getInfo_'.$cityId.'_'.$type1.'_'.$type2.'_'.$count;
		//Cache::forget($key);
			if(Redis::exists($key)){
				$result = unserialize(Redis::get($key));
			}else{
				$result = DB::connection('mysql_house')->table('ad_advertising')->leftJoin('ad_position', 'ad_advertising.pId', '=', 'ad_position.id')
						->where('ad_position.type1', $type1)
						->where('ad_position.type2', $type2)
						->where('ad_advertising.state', 1)
						//->where('cityId', $cityId)
						->whereIn('cityId', [0,$cityId])
						->whereRaw('now() between ad_advertising.timeStart and ad_advertising.timeFinish')
						->orderBy('sort', 'Desc')
						->limit($count)
						->get(['ad_advertising.id', 'ad_advertising.name', 'ad_advertising.url', 'ad_advertising.fileName']);
				if(!empty($result)){
					Redis::set($key,serialize($result));
					Redis::expire($key,$config['outtime']);
				}
			}
		}elseif($type1 == 2){		//推荐位物料，关联表ad_recommend
			$key='DB_mysql_house_getInfo_'.CURRENT_CITYID.'_'.$type1.'_'.$type2.'_'.$count;
			//Cache::forget($key);
			if(Redis::exists($key)){
				$result=unserialize(Redis::get($key));
			}else{
				$result = DB::connection('mysql_house')->table('ad_recommend')->leftJoin('ad_position', 'ad_recommend.pId', '=', 'ad_position.id')
						->where('ad_position.type1', $type1)
						->where('ad_position.type2', $type2)
						->where('ad_recommend.state', 1)
						->where('ad_recommend.cityId', CURRENT_CITYID)
						->limit($count)->get(['fromId', 'dbType', 'houseType2', 'fileName']);
				if(!empty($result)){
					Redis::set($key,serialize($result));
					Redis::expire($key,$config['outtime']);
				}
			}
			
		}
		return $result;
	}

        /**
         * 统计广告访问量统计入库操作 
         */
        public function adVisitInsert($data){
            $res = DB::connection('mysql_statistics')
                    ->table('adstatistics')
                    ->insert($data);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }
}
