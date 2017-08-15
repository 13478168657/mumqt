<?php
namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Utils\TextUtil;
use App\Http\Controllers\Utils\CurlUtil;

use Elasticsearch\ClientBuilder;
use App\ListInputView;
// use App\Http\Controllers\Utils\CookieUtil;
use App\Http\Controllers\Utils\RedisCacheUtil;
use DB;
/**
 * ES控制类，由SearchController调用，提供ES层搜索接口，返回JSON格式的纯文本结果
 *
 * @author yuanl
 */
class ESIndex_new
{

    public $communityUrl;

    public $houseRentUrl;

    public $houseSaleUrl;

    public $brokerUrl;

    public $oldCommunityUrl;

    public $newhouseSaleUrl;

    private $hosts;

    private $searchType;

    private $index;

	private $type;

    public function __construct()
    {
        /* $this->communityUrl = 'sofangnewcommunity';
        $this->oldCommunityUrl = 'sofangoldcommunity';
        // $this->houseRentUrl = Config::get("esIndex.oldhouseRentUrl");
        // $this->houseSaleUrl = Config::get("esIndex.oldhouseSaleUrl");
        $this->newhouseSaleUrl = 'sofangnewhousesale';
        $this->brokerUrl = 'sofangbroker';
        $this->hosts = [
        		'192.168.1.85:9200',
//         		'192.168.1.38:9200',
        ];
        $searchType_arr = [
        		'hr'=>[
        			'hr1',
        			'hr2',
        			'hr3',
        			'hr4',
        			'hr5',
        			'hr6',
        			'hr7',
        		],
        		'hs'=>[
        			'hs1',
        			'hs2',
        			'hs3',
        			'hs4',
        			'hs5',
        			'hs6',
        			'hs7',
        		],
        ]; */
        $this->esConfig = config('esConfig');
        $this->index = '';
        $this->type = 'external';
        $this->params = [];
    }

    public function SearchHouse($searchType, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc)
    {
    	if($searchType == 'hs'){
    		ESIndex_new::getEsConfig('oldhouseSaleUrl');
    	}elseif($searchType == 'hr'){
    		ESIndex_new::getEsConfig('oldhouseRentUrl');
    	}
    	ESIndex_new::getHouseurlByCity($searchType);
    	return ESIndex_new::ESSearch($this->index, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
    }

    public function SearchCommunity($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isNew)
    {
        if ($isNew) {
        	ESIndex_new::getEsConfig('communityUrl');
            return ESIndex_new::ESSearch($this->index, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, 1);
        } else {
        	ESIndex_new::getEsConfig('oldCommunityUrl');
            return ESIndex_new::ESSearch($this->index, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, 2);
        }
    }

    public function SearchBroker($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc)
    {
    	ESIndex_new::getEsConfig('brokerUrl');
        return ESIndex_new::ESSearch($this->index, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc);
    }

    public function SearchCommunityByCid($cid, $isNew = false)
    {
        if ($isNew) {
    		ESIndex_new::getEsConfig('communityUrl');
            return ESIndex_new::ESSearchById($this->index, $cid);
        } else {
    		ESIndex_new::getEsConfig('oldCommunityUrl');
            return ESIndex_new::ESSearchById($this->index, $cid);
        }
    }

    public function SearchBrokerById($id)
    {
    	ESIndex_new::getEsConfig('brokerUrl');
        return ESIndex_new::ESSearchById($this->index, $id);
    }

    public function SearchHouseListByIds($ids, $searchType)
    {
        if ($searchType === 'nhs'){
    		ESIndex_new::getEsConfig('newhouseSaleUrl');
            return ESIndex_new::ESSearchByIds($this->index, $ids);
        } else if ($searchType === 'hr') {
    		ESIndex_new::getEsConfig('oldhouseRentUrl');
			ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchByIds($this->index, $ids);
        } else {
    		ESIndex_new::getEsConfig('oldhouseSaleUrl');
			ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchByIds($this->index, $ids);
        }
    }

    public function SearchHouseById($id, $searchType)
    {
        if ($searchType === 'hr') {
    		ESIndex_new::getEsConfig('oldhouseRentUrl');
    		ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchById($this->index, $id);
        } else {
    		ESIndex_new::getEsConfig('oldhouseSaleUrl');
    		ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchById($this->index, $id);
        }
    }

    public function SearchCommunityListByIds($ids, $isNew = false)
    {
        $arr['ids'] = $ids;
        if ($isNew) {
    		ESIndex_new::getEsConfig('communityUrl');
            return ESIndex_new::ESSearchByIds($this->index, $arr);
        } else {
    		ESIndex_new::getEsConfig('oldCommunityUrl');
            return ESIndex_new::ESSearchByIds($this->index, $arr);
        }
    }

    public function SearchCount($searchType, $esQuerys, $esFilters, $groupField, $asc = false)
    {
        if ($searchType === 'hr') {
    		ESIndex_new::getEsConfig('oldhouseRentUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchCount($this->index, $esQuerys, $esFilters, $groupField, $asc);
        } else if ($searchType === 'hs') {
    		ESIndex_new::getEsConfig('oldhouseSaleUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchCount($this->index, $esQuerys, $esFilters, $groupField, $asc);
        } else {
    		ESIndex_new::getEsConfig('newhouseSaleUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return ESIndex_new::ESSearchCount($this->index, $esQuerys, $esFilters, $groupField, $asc);
        }
    }

    public function UpdateHouse($searchType, $indexid, $fields, $value)
    {
        if ($searchType === 'hr') {
    		ESIndex_new::getEsConfig('oldhouseRentUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return $this->ESUpdate($this->index, $indexid, $fields, $value);
        } else if ($searchType === 'hs') {
    		ESIndex_new::getEsConfig('oldhouseSaleUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return $this->ESUpdate($this->index, $indexid, $fields, $value);
        }
    }

    public function DeleteHouse($searchType, $indexId)
    {
        if ($searchType === 'hr') {
    		ESIndex_new::getEsConfig('oldhouseRentUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return $this->ESDelete($this->index, $indexId);
        } else if ($searchType === 'hs') {
    		ESIndex_new::getEsConfig('oldhouseSaleUrl');
        	ESIndex_new::getHouseurlByCity($searchType);
            return $this->ESDelete($this->index, $indexId);
        }
    }
    public function DeleteCommunity($indexId, $isNew=false)
    {
        if ($isNew) {
    		ESIndex_new::getEsConfig('communityUrl');
            return $this->ESDelete($this->index, $indexId);
        } else {
    		ESIndex_new::getEsConfig('oldCommunityUrl');
            return $this->ESDelete($this->index, $indexId);
        }
    }

    private function ESSearch($index, $fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity = 0)
    {
//         $url = $index . "_search";
        $params = ESIndex_new::CreateQueryStr($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity);
		$this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
        $response = $this->esIndex->search($params);
        return json_encode($response);
    }

    private function ESUpdate($qryUrl, $indexid, $fields, $value)
    {
//         $url = $qryUrl . 'external/' . $indexid . '/_update';
//         // 初始化
//         $postArr = [
//             'doc' => [
//                 $fields => $value
//             ]
//         ];
//         $html = CurlUtil::MakeCurlFunction($url, 'POST', json_encode($postArr));
//         return $html;
			$params = [
					'index'=>$this->index,
					'type'=>$this->type,
					'id'=>$indexid,
					'body'=>[
							'doc'=>[
									$fields=>$value
							]
					]
			];
			$this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
			$response = $this->esIndex->update($params);
			return json_encode($response);
    }

    private function ESDelete($qryUrl, $indexid)
    {
//         $url = $qryUrl . 'external/' . $indexid;
//         $html = CurlUtil::MakeCurlFunction($url, 'DELETE');
//         return $html;
		$params = [
				'index'=>$this->index,
				'type'=>$this->type,
				'id'=>$indexid,
		];
		$this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
		$response = $this->esIndex->delete($params);
		return json_encode($response);
    }

    private function ESSearchById($qryUrl, $id)
    {
    	$params = [
    			'index'=>$this->index,
    			'type'=>$this->type,
    			'id'=>(string)$id,
//     			'body'=>[
//     					'query'=>[
//     							'bool'=>[
//     									'must'=>[
//     											'term'=>[
//     													'id'=>(string)$id
//     											]
//     									]
//     							]
//     					]
//     			]
    	];
    	$this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
    	$response = $this->esIndex->get($params);
        return json_encode($response);
    }

    private function ESSearchByIds($qryUrl, $ids)
    {
        $params = [
    			'index'=>$this->index,
    			'type'=>$this->type,
    			'body'=>[
    					'ids'=>$ids['ids'],
    			]
    	];
        $this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
        $response = $this->esIndex->mget($params);
        return json_encode($response);
    }

    private function ESSearchCount($qryUrl, $esQuerys, $esFilters, $groupField, $asc = false)
    {
		$params = ESIndex_new::CreateCountStr($esQuerys, $esFilters, $groupField, $asc);
		$this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
		$response = $this->esIndex->search($params);
        return json_encode($response);
    }

    private function ESSearchGroupCount($qryUrl, $esQuerys, $esFilters, $groupField)
    {
        $url = $qryUrl . "_count";
        $data = ESIndex_new::CreateCountStr($esQuerys, $esFilters, $groupField);
        $opts = array(
            "http" => array(
                'method' => 'GET','header' => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data) . "\r\n",'content' => $data
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        return $html;
    }

    public function ESAutoComplete($query_string, $type1, $isNew = false)
    {
    	if ($isNew){
    		ESIndex_new::getEsConfig('communityUrl');
    	} else {
    		ESIndex_new::getEsConfig('oldCommunityUrl');
    	}
    	// 初始化
    	$params = [ 
				'index' => $this->index,
				'type' => $this->type,
				'body' => [ 
						'query' => [ 
								'filtered' => [ 
										'query' => [ 
												'bool' => [ 
														'should' => [ 
																[ 
																		'match' => [ 
																				'keywords' => $query_string 
																		] 
																],
																[ 
																		'prefix' => [ 
																				'pinyin' => $query_string 
																		] 
																],
																[ 
																		'prefix' => [ 
																				'initial' => $query_string 
																		] 
																] 
														] 
												] 
										],
										'filter' => [ 
												'bool' => [ 
														'must' => [ 
																[ 
																		'match' => [ 
																				'cityId' => CURRENT_CITYID 
																		] 
																] 
														] 
												] 
										] 
								] 
						],
						'fields' => [ 
								'name' 
						],
						'sort' => [ 
								'_score' 
						],
						"size" => 8 
				] 
		]
		;
    	if ($type1 > 0){
    		$params['body']['query']['filtered']['filter']['bool']['must'][] = ['match'=>['type1'=>$type1]];
    	}
    	$this->esIndex = ClientBuilder::create()->setHosts($this->hosts)->build();
    	$response = $this->esIndex->search($params);
    	return json_encode($response);
    }
    
    private function CreateCountStr($esQuerys, $esFilters, $groupField, $asc = false)
    {
    	if(count($esQuerys) > 0 || count($esFilters) > 0){
    		$params = [
    				'index'=>$this->index,
    				'type'=>$this->type,
    				'search_type'=>'count',
    				'body'=>[
    						'query'=>[
    								'filtered'=>[
    										'filter'=>[
    												
    										],
    										'query'=>[
    												
    										]
    								]
    						],
    				]
    		];
    		$sqi = '';
	    	foreach($esQuerys as $esQuerys_key=>$esQuerys_val){
	    		if($esQuerys_val->field == 'cityId'){
	                if(!empty($sqi)){
	                    $sqi .= " AND ";
	                }
	                $sqi .= "(cityId:{$esQuerys_val->keywords} OR linkCityIds:{$esQuerys_val->keywords})";
	            }else{
		        	$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esQuerys_val->keywords)));
		        	foreach($vals as $vals_v){
	                    if(!empty($vals_v)){
							if($esQuerys_val->field == 'houseType1'){
								$params['type'] = "t" . $vals_v;
							}
	                        if(!empty($sqi)){
	                            $sqi .= " AND ";
	                        }
	                        $sqi .= "({$esQuerys_val->field}:{$vals_v})";
	                    }
	                }
	            }
	    	}
	    	foreach($esFilters as $esFilters_val){
	    		if($esFilters_val->type == 2){//term条件范围
	    			if(is_array($esFilters_val->values)){
	    				$vals = $esFilters_val->values;
	    			}else{
	    				$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esFilters_val->values)));
	    			}
	    			$params['body']['query']['filtered']['filter']['and'][] = [
	    					'terms'=>[
	    							$esFilters_val->field=>$vals
	    					]
	    			];
	    		}else{//range区间范围
	    			$params['body']['query']['filtered']['filter']['and'][] = [
	    					'range'=>[
	    							$esFilters_val->field=>[
	    									'gte'=>$esFilters_val->minValue,
	    									'lte'=>$esFilters_val->maxValue,
	    							]
	    					]
	    					];
	    		}
	    	}
	    	if(!empty($sqi)){
	    		$params['body']['query']['filtered']['query']['query_string'] = [
	    				'default_operator'=>"AND",
	    				'query'=>$sqi,
	    		];
	    	}
	    	if(!empty($groupField)){
	    		$params['body']['aggs'] = [
    					'group'=>[
    							'terms'=>[
    									'field'=>$groupField,
    									'size'=>1000,
    									'order'=>[
    											['_count'=>($asc ? "asc" : "desc")],
    									]
    							]
    					]
	    		];
	    	}
    	}
        return $params;
    }

    private function CreateQueryStr($fields, $esQuerys, $esFilters, $pg, $ps, $sort, $asc, $isCommunity = fales)
    {
    	$from = ($pg - 1) * $ps;
    	$params = [
    			'index'=>$this->index,
    			'type'=>$this->type,
    			'body'=>[
    					'from'=>$from,
    					'size'=>$ps,
    					'query'=>[
    							'filtered'=>[
    									'filter'=>[

    									],
	    								'query'=>[

	    								]
    							]
    					],
    					'sort'=>[
    							'_score'
    					],
    					'highlight'=>[
    							'fields'=>[
    									'name'=>[]
    							]
    					]
    			]
    	];
        $sqi = '';
    	foreach($esQuerys as $esQuerys_key=>$esQuerys_val){
    		if($esQuerys_val->field == 'cityId'){
                if(!empty($sqi)){
                    $sqi .= " AND ";
                }
                $sqi .= "(cityId:{$esQuerys_val->keywords} OR linkCityIds:{$esQuerys_val->keywords})";
            }else{
				if(strchr($esQuerys_val->keywords, ',') !== false){
					$vals = explode(",", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esQuerys_val->keywords)));
					$sqi .= "(";
					foreach($vals as $vals_k=>$vals_v){
						if(!empty($vals_v)){
							if($esQuerys_val->field == 'houseType1'){
								$params['type'] = "t" . $vals_v;
							}
							if(!empty($sqi) AND $vals_k!=0){
								$sqi .= " OR ";
							}
							$sqi .= "({$esQuerys_val->field}:{$vals_v})";
						}
					}
					$sqi .= ")";
				}else{
					$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esQuerys_val->keywords)));
					foreach($vals as $vals_v){
						if(!empty($vals_v)){
							if($esQuerys_val->field == 'houseType1'){
								$params['type'] = "t" . $vals_v;
							}
							if(!empty($sqi)){
								$sqi .= " AND ";
							}
							$sqi .= "({$esQuerys_val->field}:{$vals_v})";
						}
					}
				}
            }
    	}
    	foreach($esFilters as $esFilters_val){
    		if($esFilters_val->type == 2){//term条件范围
				if(is_array($esFilters_val->values)){
					$vals = $esFilters_val->values;
				}else{
					$vals = explode(" ", TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($esFilters_val->values)));
				}
				$params['body']['query']['filtered']['filter']['and'][] = [
					'terms'=>[
						$esFilters_val->field=>$vals
					]
				];
			}else{//range区间范围
				$params['body']['query']['filtered']['filter']['and'][] = [
					'range'=>[
						$esFilters_val->field=>[
							'gte'=>$esFilters_val->minValue,
							'lte'=>$esFilters_val->maxValue,
						]
					]
				];
			}
    	}
    	if(!empty($sqi)){
    		$params['body']['query']['filtered']['query']['query_string'] = [
    				'default_operator'=>"AND",
    				'query'=>$sqi,
    		];
    	}
		//排序
		if(empty($sort)){
			if($isCommunity > 0){
				$params['body']['sort'][] = [
					'titleImage'=>[
						'missing'=>'_last'
					]
				];
			}
		}else{
			$params['body']['sort'][] = [
				$sort=>[
					'order'=>($asc ? 'asc' : 'desc')
				]
			];
		}
		//返回字段
		if(!empty($fields)){
			$params['body']['highlight']['fields']['name'] = $fields;
		}
		// dd($params);
    	return $params;
    }

    /**
     * 根据当前所在城市获取房源对应节点
     * @param 出租或出售 $searchType
     */
    private function getHouseurlByCity($searchType){
    	$cityId = CURRENT_CITYID;
    	$cityId = (empty($cityId)) ? 1 : $cityId;
    	$city = RedisCacheUtil::getCityDataById($cityId);
    	$city_districtId = $city[0]['districtId'];
    	$this->index = $searchType . $city_districtId;
    }
    private function getEsConfig($searchType){
    	$this->index = $this->esConfig[$searchType]['index'];
    	$this->hosts = $this->esConfig[$searchType]['hosts'];
    	$this->type = $this->esConfig[$searchType]['type'];
    }
}
