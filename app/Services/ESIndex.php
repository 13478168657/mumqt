<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Utils\TextUtil;
use App\Http\Controllers\Utils\CurlUtil;

/**
 * ES控制类，由SearchController调用，提供ES层搜索接口，返回JSON格式的纯文本结果
 *
 * @author yuanl
 */
class ESIndex{
	public $communityUrl;
	public $houseRentUrl;
	public $houseSaleUrl;
	public $brokerUrl;
	public $oldCommunityUrl;
	public $newhouseSaleUrl;

	public function __construct(){
		$this->communityUrl = Config::get("esIndex.communityUrl");
		$this->oldCommunityUrl = Config::get("esIndex.oldCommunityUrl");
		$this->houseRentUrl = Config::get("esIndex.oldhouseRentUrl");
		$this->houseSaleUrl = Config::get("esIndex.oldhouseSaleUrl");
		$this->houseRentFeeUrl = Config::get('esIndex.oldhouseRentFeeUrl');
		$this->houseSaleFeeUrl = Config::get('esIndex.oldhouseSaleFeeUrl');
		$this->newhouseSaleUrl = Config::get("esIndex.newhouseSaleUrl");
		$this->brokerUrl = Config::get("esIndex.brokeryUrl");
	}

	//删除经纪人索引
	public function DeleteBrokersIndex($indexId){
		return $this->ESDelete($this->brokerUrl, $indexId);
	}

	public function SearchHouse($searchType, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isHouseFee){
		if($isHouseFee === FALSE){ // 免费版房源发布
			if($searchType === 'hr'){
				return ESIndex::ESSearch($this->houseRentUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
			}else{
				return ESIndex::ESSearch($this->houseSaleUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
			}
		}else{ // 收费版房源发布
			if($searchType === 'hr'){
				return ESIndex::ESSearch($this->houseRentFeeUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
			}else{
				return ESIndex::ESSearch($this->houseSaleFeeUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
			}
		}
	}

	public function SearchCommunity($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isNew){
		$isCommunity = TRUE;
		if($isNew){
			return ESIndex::ESSearch($this->communityUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, FALSE);
		}else{
			return ESIndex::ESSearch($this->oldCommunityUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity);
		}
	}

	public function SearchBroker($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc){
		return ESIndex::ESSearch($this->brokerUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
	}

	public function SearchCommunityByCid($cid, $isNew = FALSE){
		if($isNew){
			return ESIndex::ESSearchById($this->communityUrl, $cid);
		}else{
			return ESIndex::ESSearchById($this->oldCommunityUrl, $cid);
		}
	}

	public function SearchBrokerByCid($cid){
		return ESIndex::ESSearchById($this->brokerUrl, $cid);
	}

	public function SearchHouseListByIds($ids, $searchType){
		if($searchType === 'nhs'){
			return ESIndex::ESSearchByIds($this->newhouseSaleUrl, $ids);
		}else if($searchType === 'hr'){
			return ESIndex::ESSearchByIds($this->houseRentUrl, $ids);
		}else{
			return ESIndex::ESSearchByIds($this->houseSaleUrl, $ids);
		}
	}

	public function SearchHouseById($id, $searchType){
		if($searchType === 'hr'){
			return ESIndex::ESSearchById($this->houseRentUrl, $id);
		}else{
			return ESIndex::ESSearchById($this->houseSaleUrl, $id);
		}
	}

	public function SearchCommunityListByIds($ids, $isNew = FALSE){
		$arr ['ids'] = $ids;
		if($isNew){
			return ESIndex::ESSearchByIds($this->communityUrl, $arr);
		}else{
			return ESIndex::ESSearchByIds($this->oldCommunityUrl, $arr);
		}
	}

	public function SearchCount($searchType, $esQuerys, $esFilters, $groupField, $asc = FALSE, $isNewComm){
		if($searchType === 'hr'){
			return ESIndex::ESSearchCount($this->houseRentUrl, $esQuerys, $esFilters, $groupField, $asc);
		}else if($searchType === 'hs'){
			return ESIndex::ESSearchCount($this->houseSaleUrl, $esQuerys, $esFilters, $groupField, $asc);
		}else{ // 楼盘
			if($isNewComm === TRUE){
				return ESIndex::ESSearchCount($this->communityUrl, $esQuerys, $esFilters, $groupField, $asc);
			}else{
				return ESIndex::ESSearchCount($this->oldCommunityUrl, $esQuerys, $esFilters, $groupField, $asc);
			}
		}
	}

	public function UpdateHouse($searchType, $indexid, $fields, $value){
		if($searchType === 'hr'){
			return $this->ESUpdate($this->houseRentUrl, $indexid, $fields, $value);
		}else if($searchType === 'hs'){
			return $this->ESUpdate($this->houseSaleUrl, $indexid, $fields, $value);
		}
	}

	public function DeleteHouse($searchType, $indexId, $isHouseFee){
		if($isHouseFee === FALSE){ // 免费版房源下架删除
			if($searchType === 'hr'){
				return $this->ESDelete($this->houseRentUrl, $indexId);
			}else if($searchType === 'hs'){
				return $this->ESDelete($this->houseSaleUrl, $indexId);
			}
		}else{ // 收费版房源下架删除
			if($searchType === 'hr'){
				return $this->ESDelete($this->houseRentFeeUrl, $indexId);
			}else if($searchType === 'hs'){
				return $this->ESDelete($this->houseSaleFeeUrl, $indexId);
			}
		}
	}

	public function DeleteHouseByIdsArray($searchType, $indexId){
		if($searchType === 'hr'){
			$host = $this->houseRentUrl;
		}else if($searchType === 'hs'){
			$host = $this->houseSaleUrl;
		}
		$params_hosts = explode('/', $host);
		/*遍历每条数据批量删除*/
		$params_str = '';
		foreach($indexId as $val){
			$params_str .= json_encode([
					"delete" => [
						"_index" => $params_hosts[3],
						"_type" => 'external',
						"_id" => $val
					]
				], JSON_UNESCAPED_UNICODE) . "\n";
		}
		$url = "http://" . $params_hosts[2] . "/_bulk";
		return CurlUtil::MakeCurlFunction($url, 'POST', $params_str);
	}

	public function DeleteCommunity($indexId, $isNew = FALSE){
		if($isNew){
			return $this->ESDelete($this->communityUrl, $indexId);
		}else{
			return $this->ESDelete($this->oldCommunityUrl, $indexId);
		}
	}

	private function ESSearch($qryUrl, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity = FALSE){
		$url = $qryUrl . "_search";
		$data = ESIndex::CreateQueryStr($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity);
		$html = CurlUtil::MakeCurlFunction($url, 'POST', $data);
		return $html;
	}

	private function ESUpdate($qryUrl, $indexid, $fields, $value){
		$url = $qryUrl . 'external/' . $indexid . '/_update';
		// 初始化
		$postArr = ['doc' => [$fields => $value]];
		$html = CurlUtil::MakeCurlFunction($url, 'POST', json_encode($postArr));
		return $html;
	}

	private function ESDelete($qryUrl, $indexid){
		$url = $qryUrl . 'external/' . $indexid;
		$html = CurlUtil::MakeCurlFunction($url, 'DELETE');
		return $html;
	}

	private function ESSearchById($qryUrl, $id){
		$url = $qryUrl . 'external/' . $id;
		$html = CurlUtil::MakeCurlFunction($url, 'GET');
		return $html;
	}

	private function ESSearchByIds($qryUrl, $ids){
		$url = $qryUrl . 'external/_mget';
		// 初始化
		$html = CurlUtil::MakeCurlFunction($url, 'POST', json_encode($ids));
		return $html;
	}

	private function ESSearchCount($qryUrl, $esQuerys, $esFilters, $groupField, $asc = FALSE){
		$url = $qryUrl . "_search?search_type=count";
		$data = ESIndex::CreateCountStr($esQuerys, $esFilters, $groupField, $asc);
		$html = CurlUtil::MakeCurlFunction($url, 'GET', $data);
		return $html;
	}

	private function ESSearchGroupCount($qryUrl, $esQuerys, $esFilters, $groupField){
		$url = $qryUrl . "_count";
		$data = ESIndex::CreateCountStr($esQuerys, $esFilters, $groupField);
		$opts = [
			"http" => [
				'method' => 'GET',
				'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data) . "\r\n",
				'content' => $data
			]
		];
		$context = stream_context_create($opts);
		$html = file_get_contents($url, FALSE, $context);
		return $html;
	}

	public function ESAutoComplete($query_string, $type1, $isNew = FALSE){
		if($isNew){
			$qryUrl = $this->communityUrl;
		}else{
			$qryUrl = $this->oldCommunityUrl;
		}
		$url = $qryUrl . 'external/_search';
		// 初始化
		/**
		 */
		$postArr = [
			'query' => [
				'filtered' => [
					'query' => [
						'bool' => [
							'should' => [
								['match' => ['keywords' => $query_string]],
								['prefix' => ['pinyin' => $query_string]],
								['prefix' => ['initial' => $query_string]]
							]
						]
					],
					'filter' => [
						'bool' => [
							//												'must' => [
							//														[
							//																'match' => [
							//																		'cityId' => CURRENT_CITYID
							//																]
							//														]
							//												]
							'should' => [
								['term' => ['cityId' => CURRENT_CITYID]],
								['term' => ['linkCityIds' => CURRENT_CITYID]]
							]
						]
					]
				]
			],
			'fields' => ['name'],
			'sort' => ['_score'],
			"size" => 8
		];
		if($type1 > 0){
			$postArr ['query'] ['filtered'] ['filter'] ['bool'] ['must'] [] = ['match' => ['type1' => $type1]];
		}
		$html = CurlUtil::MakeCurlFunction($url, 'POST', json_encode($postArr));
		return $html;
	}

	private function CreateCountStr($esQuerys, $esFilters, $groupField, $asc = FALSE){
		$sq = "";

		if(count($esQuerys) > 0 || count($esFilters) > 0){
			$params = [

				'query' => [
					'filtered' => [
						'query' => [
							'query_string' => []
						],
						'filter' => []
					]
				],
				'aggs' => ['group' => []]
			];
			$sqi = "";
			foreach($esQuerys as $esQuerys_key => $esQuerys_val){
				if($esQuerys_val->field == 'cityId'){
					if(!empty ($sqi)){
						$sqi .= " AND ";
					}
					$sqi .= "(cityId:{$esQuerys_val->keywords} OR linkCityIds:{$esQuerys_val->keywords})";
				}else{
					$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esQuerys_val->keywords)));
					foreach($vals as $vals_v){
						if(!empty ($vals_v)){
							if(!empty ($sqi)){
								$sqi .= " AND ";
							}
							$sqi .= "({$esQuerys_val->field}:{$vals_v})";
						}
					}
				}
			}
			if(!empty ($sqi)){
				$params ['query'] ['filtered'] ['query'] ['query_string'] = [
					'default_operator' => "AND",
					'query' => $sqi
				];
			}
			foreach($esFilters as $esFilters_val){
				if($esFilters_val->type == 2){ // term条件范围
					if(is_array($esFilters_val->values)){
						$vals = $esFilters_val->values;
					}else{
						$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esFilters_val->values)));
					}
					$params ['query'] ['filtered'] ['filter'] ['and'] [] = ['terms' => [$esFilters_val->field => $vals]];
				}else{ // range区间范围
					$params ['query'] ['filtered'] ['filter'] ['and'] [] = [
						'range' => [
							$esFilters_val->field => [
								'gte' => $esFilters_val->minValue,
								'lte' => $esFilters_val->maxValue
							]
						]
					];
				}
			}

			if(!empty ($groupField)){
				$params ['aggs'] = [
					'group' => [
						'terms' => [
							'field' => $groupField,
							'size' => 1000,
							'order' => [['_count' => ($asc ? "asc" : "desc")]]
						]
					]
				];
			}
		}
		$sq = json_encode($params);
		return $sq;
	}

	/**
	 * es索引json查询字符串生成
	 * @param $fields 显示字段
	 * @param $esQuerys 条件
	 * @param $esFilters 条件
	 * @param $pg 页数
	 * @param $ps 每页条数
	 * @param $sort 排序字段
	 * @param $asc 排序方式：true.asc false.desc
	 * @param $isCommunity 是否是楼盘：true.是 false.不是
	 * @return string
	 */
	private function CreateQueryStr($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity = fales){
		$from = ($pg - 1) * $ps;
		$params = [
			'from' => $from,
			'size' => $ps,
			'query' => [
				'filtered' => [
					'query' => [],
					'filter' => []
				]
			],
			'sort' => [],
			'highlight' => ['fields' => ['name' => []]]
		];
		$sqi = '';
		/* query语句生成 */
		foreach($esQuerys as $esQuerys_key => $esQuerys_val){
			if($esQuerys_val->field == 'must_not'){//不等于操作，单独处理
				$not_sqi = " (";
				$must_not = $esQuerys_val->keywords;
				foreach($must_not as $must_not_val){
					foreach($must_not_val as $must_not_k => $must_not_v){
						if($not_sqi != " ("){
							$not_sqi .= " OR ";
						}
						$not_sqi .= $must_not_k . ":" . "\"" . $must_not_v . "\"";
					}
				}
				$not_sqi .= ")";
			}else if($esQuerys_val->field == 'range'){//大于小于操作，单独处理
				foreach($esQuerys_val->keywords as $field => $glt){
					$field_arr = [];
					foreach($glt as $glt_key => $glt_val){
						$field_arr[$glt_key] = $glt_val;
					}
					$params ['query'] ['filtered'] ['filter'] ['and'] [] = ['range' => [$field => $field_arr]];
				}
			}else if($esQuerys_val->field == 'cityId'){
				if(!empty ($sqi)){
					$sqi .= " AND ";
				}
				$sqi .= "(cityId:{$esQuerys_val->keywords} OR linkCityIds:{$esQuerys_val->keywords})";
			}else{
				if(strchr($esQuerys_val->keywords, ',') !== FALSE){
					$vals = explode(",", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esQuerys_val->keywords)));
					if(!empty ($sqi)){
						$sqi .= " AND ";
					}
					$sqi .= "(";
					foreach($vals as $vals_k => $vals_v){
						if($vals_v !== ""){
							// if($esQuerys_val->field == 'houseType1'){
							// $params['type'] = "t" . $vals_v;
							// }
							if(!empty ($sqi) and $vals_k != 0){
								$sqi .= " OR ";
							}
							$sqi .= "({$esQuerys_val->field}:{$vals_v})";
						}
					}
					$sqi .= ")";
				}else{
					$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esQuerys_val->keywords)));
					foreach($vals as $vals_v){
						if($vals_v !== ""){
							// if($esQuerys_val->field == 'houseType1'){
							// $params['type'] = "t" . $vals_v;
							// }
							if(!empty ($sqi)){
								$sqi .= " AND ";
							}
							$sqi .= "({$esQuerys_val->field}:{$vals_v})";
						}
					}
				}
			}
		}
		if(!empty($not_sqi)){
			if(!empty($sqi)){
				$sqi .= " AND NOT " . $not_sqi;
			}else{
				$sqi .= " NOT " . $not_sqi;
			}
		}

		foreach($esFilters as $esFilters_val){
			if($esFilters_val->type == 2){ // term条件范围
				if(is_array($esFilters_val->values)){
					$vals = $esFilters_val->values;
				}else{
					$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esFilters_val->values)));
				}
				$params ['query'] ['filtered'] ['filter'] ['and'] [] = ['terms' => [$esFilters_val->field => $vals]];
			}else{ // range区间范围
				$params ['query'] ['filtered'] ['filter'] ['and'] [] = [
					'range' => [
						$esFilters_val->field => [
							'gte' => $esFilters_val->minValue,
							'lte' => $esFilters_val->maxValue
						]
					]
				];
			}
		}
		if(!empty ($sqi)){
			$params ['query'] ['filtered'] ['query'] ['query_string'] = [
				'default_operator' => "AND",
				'query' => $sqi
			];
		}
		// 排序
		if(!empty ($sort)){
			if(is_array($sort)){
				foreach($sort as $sort_val){
					foreach($sort_val as $k => $v){
						$params['sort'][] = [$k => ['order' => $v]];
					}
				}
			}else{
				if($isCommunity > 0){
					$params ['sort'] [] = [$sort => ['order' => ($asc ? 'asc' : 'desc')]];
					$params ['sort'] [] = ['titleImage' => ['missing' => '_last']];
				}else{
					$params ['sort'] [] = [$sort => ['order' => ($asc ? 'asc' : 'desc')]];
				}
			}
		}
		$params ['sort'] [] = '_score';
		// 返回字段
		if(!empty ($fields)){
			$params ['highlight'] ['fields'] ['name'] = $fields;
		}
		//		 dd($params);
		$json_params = json_encode($params);
		return $json_params;
	}
}
