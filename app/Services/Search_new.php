<?php
namespace App\Services;

use App\ESQuery;
use App\ESFilter;
use App\Services\ESIndex;
use App\ListInputView;
use App\BrokerInputView;
use App\Http\Controllers\Utils\HouseUtil;
use App\Dao\Map\MapDao;
use App\MapPoint;
use Illuminate\Support\Facades\Cache;
use App\UserinterestInputView;
use App\IndexUpdateEntity;

/**
 * ES全文搜索控制类，提供系统所有的全文搜索接口
 *
 * @author yuanl
 */
class Search
{

    private $searchType;

    private $esIndex;

    private $cityareaMaxLevel = 13;

    private $businessareaMaxLevel = 15;

    public function __construct($searchType = '')
    {
        $this->searchType = $searchType;
        $this->esIndex = new ESIndex();
        $this->esIndex_new = new ESIndex_new();
    }

    public function searchHouse(ListInputView $l)
    {
        $fields = "";
        $esQuerys = array();
        $esFilters = array();
        $startTime = (time() - $this->getShowDaysByCityId($l->cityId) * 24 * 60 * 60) * 1000;
// $startTime = (time() - 90 * 24 * 60 * 60) * 1000;
        if (!empty($l->keyword)) {
            array_push($esQuerys, new ESQuery("keywords", $l->keyword));
        }

        if (!empty($l->internalNum)) {
            array_push($esQuerys, new ESQuery("internalNum", $l->internalNum));
        }
        if (!empty($l->housingNum)) {
            array_push($esQuerys, new ESQuery("housingNum", $l->housingNum));
        }

        if (!empty($l->communityId)) {
            array_push($esQuerys, new ESQuery("communityId", $l->communityId));
        }
        if (!empty($l->cityId)) {
            array_push($esQuerys, new ESQuery("cityId", $l->cityId));
        }
        if (!empty($l->cityareaId)) {
            array_push($esQuerys, new ESQuery("cityareaId", $l->cityareaId));
        }
        if (!empty($l->businessAreaId)) {
            array_push($esQuerys, new ESQuery("businessAreaId", $l->businessAreaId));
        }
        if (!empty($l->bustagid)) {
            array_push($esQuerys, new ESQuery("businessTagId", $l->bustagid));
        }
        if (!empty($l->timeRelease)) {
            $startTime = $l->timeRelease;
        }
        if (!empty($l->uid)) {
            array_push($esQuerys, new ESQuery("uid", $l->uid));
        } else {
            array_push($esFilters, new ESFilter("timeRefresh", 1, $startTime, time() * 1000, null));
        }
        if (isset($l->swlng) && isset($l->swlat) && isset($l->nelng) && isset($l->nelat)) {
            array_push($esFilters, new ESFilter("longitude", 1, $l->swlng, $l->nelng, null));
            array_push($esFilters, new ESFilter("latitude", 1, $l->swlat, $l->nelat, null));
        }
        if (!empty($l->price1)) {
            $price = explode(',', $l->price1);
            array_push($esFilters, new ESFilter("price1", 1, $price[0], $price[1], null));
        }
        if (!empty($l->price2)) {
            $price = explode(',', $l->price2);
            array_push($esFilters, new ESFilter("price2", 1, $price[0], $price[1], null));
        }
        if (!empty($l->price3)) {
            $price = explode(',', $l->price3);
            array_push($esFilters, new ESFilter("price3", 1, $price[0], $price[1], null));
        }

        if (!empty($l->subwayLineId)) {
            array_push($esQuerys, new ESQuery("subwayLineId", $l->subwayLineId));
            if (!empty($l->subwayStationId)) {
                array_push($esQuerys, new ESQuery("subwayStationId", $l->subwayStationId));
            }
        }
        if (!empty($l->houseRoom)) {
            if ($l->houseRoom > 5) {
                array_push($esFilters, new ESFilter("houseRoom", 1, 6, 100, null));
            } else {
                array_push($esQuerys, new ESQuery("houseRoom", $l->houseRoom));
            }
        }
        if (!empty($l->rentway)) {
            array_push($esQuerys, new ESQuery("rentType", $l->rentway));
        }
        if (!empty($l->feature)) {
            array_push($esQuerys, new ESQuery("tagId", $l->feature));
        }
        if (!empty($l->toward)) {
            array_push($esQuerys, new ESQuery("faceTo", $l->toward));
        }
        if (!empty($l->decorate)) {
            array_push($esQuerys, new ESQuery("fitment", $l->decorate));
        }
        if (!empty($l->buildtype)) {
            array_push($esQuerys, new ESQuery("buildingType", $l->buildtype));
        }
        if (!empty($l->type1)) {
            array_push($esQuerys, new ESQuery("houseType1", $l->type1));
        }
        if (!empty($l->type2)) {
            //array_push($esQuerys, new ESQuery("houseType2", $l->type2));
            array_push($esFilters, new ESFilter("houseType2", 2, null, null, $l->type2));
        }
        if (!empty($l->isSoloAgent)) {
            array_push($esQuerys, new ESQuery("isSoloAgent", $l->isSoloAgent));
        }
        if (!empty($l->publishUserType) || $l->publishUserType === 0) {
            array_push($esQuerys, new ESQuery("publishUserType", $l->publishUserType));
        }
        if (!empty($l->agentFee)) {
            array_push($esQuerys, new ESQuery("agentFee", $l->agentFee));
        }
        if (!empty($l->outerring)) {
            array_push($esQuerys, new ESQuery("loopLineId", $l->outerring));
        }
        if (!empty($l->pei)) {
            array_push($esQuerys, new ESQuery("equipment", $l->pei));
        }
        if (!empty($l->structure)) {
            array_push($esQuerys, new ESQuery("buildingStructure", $l->structure));
        }
        if (!empty($l->buildYear)) {
            $year = explode(',', $l->buildYear);
            array_push($esFilters, new ESFilter("buildYear", 1, $year[0], $year[1], null));
        }
        if (!empty($l->singlearea)) {
            $area = explode(',', $l->singlearea);
            array_push($esFilters, new ESFilter("area", 1, $area[0], $area[1], null));
        }
        if (!empty($l->spind)) {
            array_push($esQuerys, new ESQuery("trade", $l->spind));
        }
        if (!empty($l->floor)) {
            array_push($esQuerys, new ESQuery("floorLevel", $l->floor));
        }
        if (!empty($l->isUrgent)) {
            array_push($esQuerys, new ESQuery("isUrgent", $l->isUrgent));
        }
        if (!empty($l->isNewHouse)) {
            array_push($esQuerys, new ESQuery("isNew", $l->isNewHouse));
        }
        if (!empty($l->dealState)) {
            array_push($esQuerys, new ESQuery("dealState", $l->dealState));
        }
        if (!empty($l->distance)) {
            $distance = explode(',', $l->distance);
            array_push($esFilters, new ESFilter("subwayNearestDistance", 1, $distance[0], $distance[1], null));
        }
        if (!empty($l->category) || $l->category === 0) {
            array_push($esQuerys, new ESQuery("isTransfer", $l->category));
        }
//         $json = $this->esIndex->SearchHouse($this->searchType, $fields, $esQuerys, $esFilters, $l->page, $l->pageset, $l->order, $l->asc);
        $json = $this->esIndex_new->SearchHouse($this->searchType, $fields, $esQuerys, $esFilters, $l->page, $l->pageset, $l->order, $l->asc);
        $result = json_decode($json);
        return $result;
    }

    private function getShowDaysByCityId($cityId)
    {
        if ($cityId == 1 || $cityId == 332 || $cityId == 116 || $cityId == 118) {
            return 30;
        } else {
            return 90;
        }
    }

    public function searchBroker(BrokerInputView $l)
    {
        $fields = "";
        $esQuerys = array();
        $esFilters = array();

        if (!empty($l->keyword)) {
            array_push($esQuerys, new ESQuery("keywords", $l->keyword));
        }
        if (!empty($l->cityId)) {
            array_push($esQuerys, new ESQuery("cityId", $l->cityId));
        }
        if (!empty($l->cityAreaId)) {
            array_push($esQuerys, new ESQuery("cityAreaId", $l->cityAreaId));
        }
        if (!empty($l->businessAreaId)) {
            array_push($esQuerys, new ESQuery("businessAreaId", $l->business));
        }
        if (!empty($l->isSaleBroker)) {
            array_push($esQuerys, new ESQuery("isSaleBroker", $l->isSaleBroker));
        }
        if (!empty($l->isRentBroker)) {
            array_push($esQuerys, new ESQuery("isRentBroker", $l->isRentBroker));
        }

//         $json = $this->esIndex->SearchBroker($fields, $esQuerys, $esFilters, $l->page, $l->pagesize, $l->order, $l->asc);
        $json = $this->esIndex_new->SearchBroker($fields, $esQuerys, $esFilters, $l->page, $l->pagesize, $l->order, $l->asc);
        $result = json_decode($json);
        return $result;
    }

    public function searchBrokerById($id)
    {
//     	$json = $this->esIndex->SearchBrokerById($id);
        $json = $this->esIndex_new->SearchBrokerById($id);
        $result = json_decode($json);
        return $result;
    }

    public function searchHouseListByIds($arr)
    {
        $ids['ids'] = $arr;
        $json = $this->esIndex_new->SearchHouseListByIds($ids, $this->searchType);
        $result = json_decode($json);
        return $result;
    }

    public function searchHouseById($id)
    {
//         $json = $this->esIndex->SearchHouseById($id, $this->searchType);
    	$json = $this->esIndex_new->SearchHouseById($id, $this->searchType);
        $result = json_decode($json);
        return $result;
    }

    public function searchCommunityListByIds($arr, $isNew = false)
    {
//         $json = $this->esIndex->SearchCommunityListByIds($arr, $isNew);
        $json = $this->esIndex_new->SearchCommunityListByIds($arr, $isNew);
        $result = json_decode($json);
        return $result;
    }

    public function getCommunityByCid($cid, $isNew = false)
    {
        $json = $this->esIndex_new->SearchCommunityByCid($cid, $isNew);
        $result = json_decode($json);
        return $result;
    }

    public function mapSearch(ListInputView $l, $zoom)
    {
        if ($zoom < $this->cityareaMaxLevel) {
            $l->swlat = null;
            $l->swlng = null;
            $l->nelat = null;
            $l->nelng = null;
            if ($this->searchType != '') {
                $search = $this->searchHouse4Group($l, 'cityareaId');
            } else {
                $search = $this->searchHouse4Group($l, 'cityAreaId');
            }
            $points = $this->getCityAreaPoints($l->cityId, $search);
            return [
                's' => 1, 'r' => $points
            ];
        } else if ($zoom < $this->businessareaMaxLevel) {
            $search = $this->searchHouse4Group($l, 'businessAreaId');
            $points = $this->getBusinessAreaPoints($l->cityId, $search);
            return [
                's' => 2, 'r' => $points
            ];
        } else {
            if ($this->searchType != '') {
                $search = $this->searchHouse4Group($l, 'communityId');
                $points = $this->getCommunityPoints($search);
                return [
                    's' => 3, 'r' => $points,
                ];
            } else {
                $search = $this->searchCommunity($l);
                return [
                    's' => 3, 'r' => $search,
                ];
            }
        }
    }

    /**
     * 参数说明
     *
     * @param type $searchType
     *            搜索类型，'c'：楼盘；'hr'：出租房源；'hs'：出售房源
     * @param type $level
     *            搜索级别，'city'：城市；'cityarea'：城区；'businessarea'：商圈
     * @param type $fields
     *            输出字段名称，为空时输出所有字段
     * @param type $key
     *            关键词
     * @param type $ht
     *            楼盘类型，128：普通住宅……
     * @param type $cid
     *            城市ID
     * @param type $ca
     *            城区ID
     * @param type $ba
     *            商圈ID
     * @param type $subwayLine
     *            地铁线路
     * @param type $subwayStation
     *            地铁站名
     * @param type $p1
     *            最低均价
     * @param type $p2
     *            最高均价
     * @param type $swlng
     *            地图西南经度
     * @param type $swlat
     *            地图西南纬度
     * @param type $nelng
     *            地图东北经度
     * @param type $nelat
     *            地图东北纬度
     * @param type $ps
     *            每页结果数，当此值为0时，只统计结果数目，并且忽略$pg、$order参数
     * @param type $pg
     *            当前页号
     * @param type $order
     *            排序方式
     * @param type $isNew
     *            是否只搜索新楼盘
     * @return type
     */
    public function searchHouse4Group(ListInputView $l, $groupType)
    {
        $esQuerys = array();
        $esFilters = array();
        if (!empty($l->keyword)) {
            array_push($esQuerys, new ESQuery("keywords", $l->keyword));
        }
        if (!empty($l->communityId)) {
            array_push($esQuerys, new ESQuery("communityId", $l->communityId));
        }
        if (!empty($l->cityId)) {
            array_push($esQuerys, new ESQuery("cityId", $l->cityId));
        }
        if (!empty($l->cityareaId)) {
            if ($this->searchType != '') {
                array_push($esQuerys, new ESQuery("cityareaId", $l->cityareaId));
            } else {
                array_push($esQuerys, new ESQuery("cityAreaId", $l->cityareaId));
            }
        } else {
            if ($this->searchType != '') {
                array_push($esFilters, new ESFilter("cityareaId", 4, 0, null, null));
            } else {
                array_push($esFilters, new ESFilter("cityAreaId", 4, 0, null, null));
            }
        }
        if (!empty($l->businessAreaId)) {
            array_push($esQuerys, new ESQuery("businessAreaId", $l->businessAreaId));
        } else {
            array_push($esFilters, new ESFilter("businessAreaId", 4, 0, null, null));
        }
        if (!empty($l->bustagid)) {
            array_push($esQuerys, new ESQuery("businessTagId", $l->bustagid));
        }
        if (isset($l->swlng) && isset($l->swlat) && isset($l->nelng) && isset($l->nelat)) {
            array_push($esFilters, new ESFilter("longitude", 1, $l->swlng, $l->nelng, null));
            array_push($esFilters, new ESFilter("latitude", 1, $l->swlat, $l->nelat, null));
        }
        if (!empty($l->price1)) {
            $price = explode(',', $l->price1);
            array_push($esFilters, new ESFilter("price1", 1, $price[0], $price[1], null));
        }
        if (!empty($l->price2)) {
            $price = explode(',', $l->price2);
            array_push($esFilters, new ESFilter("price2", 1, $price[0], $price[1], null));
        }
        if (!empty($l->price3)) {
            $price = explode(',', $l->price3);
            array_push($esFilters, new ESFilter("price3", 1, $price[0], $price[1], null));
        }

        if (!empty($l->subwayLineId)) {
            array_push($esQuerys, new ESQuery("subwayLineId", $l->subwayLineId));
            if (!empty($l->subwayStationId)) {
                array_push($esQuerys, new ESQuery("subwayStationId", $l->subwayStationId));
            }
        }
        if (!empty($l->houseRoom)) {
            array_push($esQuerys, new ESQuery("houseRoom", $l->houseRoom));
        }
        if (!empty($l->rentway)) {
            array_push($esQuerys, new ESQuery("rentType", $l->rentway));
        }
        if (!empty($l->feature)) {
            array_push($esQuerys, new ESQuery("tagId", $l->feature));
        }
        if (!empty($l->toward)) {
            array_push($esQuerys, new ESQuery("faceTo", $l->toward));
        }
        if (!empty($l->decorate)) {
            array_push($esQuerys, new ESQuery("fitment", $l->decorate));
        }
        if (!empty($l->buildtype)) {
            array_push($esQuerys, new ESQuery("buildingType", $l->buildtype));
        }
        if (!empty($l->type1)) {
            if ($this->searchType != '') {
                array_push($esQuerys, new ESQuery("houseType1", $l->type1));
            } else {
                array_push($esFilters, new ESFilter("type1", 2, null, null, $l->type1));
            }
        }
        if (!empty($l->type2)) {
            if ($this->searchType != '') {
                array_push($esQuerys, new ESQuery("houseType2", $l->type1));
            } else {
                array_push($esFilters, new ESFilter("type2", 2, null, null, $l->type2));
            }
        }
        if (!empty($l->publishUserType) || $l->publishUserType === 0) {
            array_push($esQuerys, new ESQuery("publishUserType", $l->publishUserType));
        }
        if (!empty($l->agentFee)) {
            array_push($esQuerys, new ESQuery("agentFee", $l->agentFee));
        }
        if (!empty($l->timeRelease)) {
            array_push($esFilters, new ESFilter("timeRelease", 1, $l->timeRelease, date("Y-m-d", time()), null));
        }
        if (!empty($l->outerring)) {
            array_push($esQuerys, new ESQuery("loopLineId", $l->outerring));
        }
        if (!empty($l->pei)) {
            array_push($esQuerys, new ESQuery("equipment", $l->pei));
        }
        if (!empty($l->structure)) {
            array_push($esQuerys, new ESQuery("buildingStructure", $l->structure));
        }
        if (!empty($l->buildYear)) {
            $year = explode(',', $l->buildYear);
            array_push($esFilters, new ESFilter("buildYear", 1, $year[0], $year[1], null));
        }
        if (!empty($l->singlearea)) {
            $area = explode(',', $l->singlearea);
            array_push($esFilters, new ESFilter("area", 1, $area[0], $area[1], null));
        }
        if (!empty($l->spind)) {
            array_push($esQuerys, new ESQuery("trade", $l->spind));
        }
        if (!empty($l->floor)) {
            array_push($esQuerys, new ESQuery("floorLevel", $l->floor));
        }
        if (!empty($l->isUrgent)) {
            array_push($esQuerys, new ESQuery("isUrgent", $l->isUrgent));
        }
        if (!empty($l->isNewHouse)) {
            array_push($esQuerys, new ESQuery("isNew", $l->isNewHouse));
        }
        if (!empty($l->dealState)) {
            array_push($esQuerys, new ESQuery("dealState", $l->dealState));
        }
        if ($this->searchType != '') {
//             array_push($esFilters, new ESFilter("timeRefresh", 1, (time() - $this->getShowDaysByCityId($l->cityId) * 24 * 60 * 60) * 1000, time() * 1000, null));
        	array_push($esFilters, new ESFilter("timeRefresh", 1, (time() - 90 * 24 * 60 * 60) * 1000, time() * 1000, null));
        }
        if (!empty($l->priceSaleAvg3)) {
            $price = explode(',', $l->priceSaleAvg3);
            array_push($esFilters, new ESFilter("priceSaleAvg3", 1, $price[0], $price[1], null));
        }
        if (!empty($l->salesStatusPeriods) || $l->salesStatusPeriods === 0) {
            array_push($esQuerys, new ESQuery("salesStatusPeriods", $l->salesStatusPeriods));
        }
        if (!empty($l->openTimePeriods)) {
            $openTimePeriods = explode(',', $l->openTimePeriods);
            array_push($esFilters, new ESFilter("openTimeLong", 1, $openTimePeriods[0], $openTimePeriods[1], null));
        }
//         $json = $this->esIndex->SearchCount($this->searchType, $esQuerys, $esFilters, $groupType, $l->asc);
        $json = $this->esIndex_new->SearchCount($this->searchType, $esQuerys, $esFilters, $groupType, $l->asc);
        $result = json_decode($json);
        return $result;
    }

    private function getCityAreaPoints($cityId, $searchResult)
    {
        $points = array();
        $cacheKey = 'indexCityArea_' . $cityId;
        if (Cache::has($cacheKey)) {
            $cityareaIndex = Cache::get($cacheKey);
        } else {
            $cityareas = MapDao::GetCityareas($cityId);
            $cityareaIndex = array();
            foreach ($cityareas as $c) {
                $p = new MapPoint($c->id, $c->name, $c->longitude, $c->latitude, 0, '');
                $cityareaIndex[$c->id] = $p;
            }
            Cache::put($cacheKey, $cityareaIndex, 60);
        }
        foreach ($searchResult->aggregations->group->buckets as $r) {
            if ($r->key > 0 && isset($cityareaIndex[$r->key])) {
                $p = $cityareaIndex[$r->key];
                $p->count = $r->doc_count;
                array_push($points, $p);
            }
        }
        return $points;
    }

    private function getBusinessAreaPoints($cityId, $searchResult)
    {
        $points = array();
        $cacheKey = 'indexBusinessArea_' . $cityId;
        if (Cache::has($cacheKey)) {
            $businessareaIndex = Cache::get($cacheKey);
        } else {
            $businessareas = MapDao::GetBusinessareas($cityId);
            $businessareaIndex = array();
            foreach ($businessareas as $c) {
                $p = new MapPoint($c->id, $c->name, $c->longitude, $c->latitude, 0, '');
                $businessareaIndex[$c->id] = $p;
            }
            Cache::put($cacheKey, $businessareaIndex, 60);
        }
        foreach ($searchResult->aggregations->group->buckets as $r) {
            if ($r->key > 0) {
                if (array_key_exists($r->key, $businessareaIndex)) {
                    $p = $businessareaIndex[$r->key];
                    $p->count = $r->doc_count;
                    array_push($points, $p);
                }
            }
        }
        return $points;
    }

    public function searchCommunity(ListInputView $l)
    {
        $esQuerys = array();
        $esFilters = array();
        if (!empty($l->keyword)) {
            array_push($esQuerys, new ESQuery("keywords", $l->keyword));
        }
        if (!empty($l->cityId)) {
            array_push($esQuerys, new ESQuery("cityId", $l->cityId));
        }
        if (!empty($l->cityareaId)) {
            array_push($esQuerys, new ESQuery("cityAreaId", $l->cityareaId));
        }
        if (!empty($l->businessAreaId)) {
            array_push($esQuerys, new ESQuery("businessAreaId", $l->businessAreaId));
        }
        if (!empty($l->subwayLineId)) {
            array_push($esQuerys, new ESQuery("subwayLineId", $l->subwayLineId));
        }

        if (!empty($l->subwayStationId)) {
            array_push($esQuerys, new ESQuery("subwayStationId", $l->subwayStationId));
        }
        if (!empty($l->type1)) {
            array_push($esFilters, new ESFilter("type1", 2, null, null, $l->type1));
        }
        if (!empty($l->type2)) {
            array_push($esFilters, new ESFilter("type2", 2, null, null, $l->type2));
        }
        if (!empty($l->enterpriseshopId)) {
            array_push($esQuerys, new ESQuery("enterpriseshopId", $l->enterpriseshopId));
        }
        if (!empty($l->communityName)) {
            array_push($esQuerys, new ESQuery("name", $l->communityName));
        }
        if (!empty($l->outerring)) {
            array_push($esQuerys, new ESQuery("loopLineId", $l->outerring));
        }
        if (!empty($l->salesStatusPeriods) || $l->salesStatusPeriods === 0) {
            array_push($esQuerys, new ESQuery("salesStatusPeriods", $l->salesStatusPeriods));
        }
        if (!empty($l->avgPrice)) {
            $price = explode(',', $l->avgPrice);
            array_push($esFilters, new ESFilter("avgPrice", 1, $price[0], $price[1], null));
        }
        if (!empty($l->openTimePeriods)) {
            $openTimePeriods = explode(',', $l->openTimePeriods);
            array_push($esFilters, new ESFilter("openTimeLong", 1, $openTimePeriods[0], $openTimePeriods[1], null));
        }
        if (!empty($l->subwayLine)) {
            array_push($esQuerys, new ESQuery("subwayLine", $l->subwayLine));
            if (!empty($l->subwayStation)) {
                array_push($esQuerys, new ESQuery("subwayStation", $l->subwayStation));
            }
        }
        if (isset($l->swlng) && isset($l->swlat) && isset($l->nelng) && isset($l->nelat)) {
            array_push($esFilters, new ESFilter("longitude", 1, $l->swlng, $l->nelng, null));
            array_push($esFilters, new ESFilter("latitude", 1, $l->swlat, $l->nelat, null));
        }
        if (!empty($l->houseRoom)) {
            array_push($esFilters, new ESFilter($l->houseRoom, 1, 0, 99999, null));
        }
        if (!empty($l->distance)) {
            $distance = explode(',', $l->distance);
            array_push($esFilters, new ESFilter("subwayNearestDistance", 1, $distance[0], $distance[1], null));
        }
        $priceArr = ['priceRentAvg1', 'priceRentAvg2', 'priceRentAvg3', 'priceRentAvg101', 'priceRentAvg102', 'priceRentAvg103', 'priceRentAvg104', 'priceRentAvg105', 'priceRentAvg106', 'priceRentAvg201', 'priceRentAvg203', 'priceRentAvg204', 'priceRentAvg301', 'priceRentAvg302', 'priceRentAvg303', 'priceRentAvg304', 'priceRentAvg305', 'priceRentAvg306', 'priceRentAvg307', 'priceSaleAvg1', 'priceSaleAvg2', 'priceSaleAvg3', 'priceSaleAvg101', 'priceSaleAvg102', 'priceSaleAvg103', 'priceSaleAvg104', 'priceSaleAvg105', 'priceSaleAvg106', 'priceSaleAvg201', 'priceSaleAvg203', 'priceSaleAvg204', 'priceSaleAvg301', 'priceSaleAvg302', 'priceSaleAvg303', 'priceSaleAvg304', 'priceSaleAvg305', 'priceSaleAvg306', 'priceSaleAvg307'];
        foreach ($priceArr as $value) {
            if (!empty($l->$value)) {
                $argArr = explode(',', $l->$value);
                array_push($esFilters, new ESFilter("$value", 1, $argArr[0], $argArr[1], null));
            }
        }
        if (!empty($l->singlearea)) {
            $area = explode(',', $l->singlearea);
            array_push($esFilters, new ESFilter("t2_floorArea", 1, $area[0], $area[1], null));
        }
        $json = $this->esIndex_new->SearchCommunity($l->fields, $esQuerys, $esFilters, $l->page, $l->pageset, $l->order, $l->asc, $l->isNew);
        $result = json_decode($json);
        return $result;
    }

    public function houseIndexUpdate(IndexUpdateEntity $iue)
    {
        return $this->esIndex_new->UpdateHouse($this->searchType, $iue->getIndexId(), $iue->getFields(), $iue->getValue());
    }

    public function houseIndexDelete($indexId)
    {
        return $this->esIndex_new->DeleteHouse($this->searchType, $indexId);
    }

    public function communityIndexDelete($indexId, $isNew = false)
    {
        return $this->esIndex_new->DeleteCommunity($indexId, $isNew);
    }

    private function getCommunityPoints($searchResult)
    {
        $points = array();
        foreach ($searchResult->aggregations->group->buckets as $r) {
            if ($r->key > 0) {
                $cacheKey = 'communityMapPoint_' . $r->key;
                if (Cache::has($cacheKey)) {
                    $c = Cache::get($cacheKey);
                } else {
                    $c = MapDao::GetCommunity($r->key);
                    if ($c != null) {
                        Cache::put($cacheKey, $c, 24 * 60);
                    }
                }
                if ($c != null) {
                    $p = new MapPoint($c->id, $c->name, $c->longitude, $c->latitude, 0, '');
                    $p->count = $r->doc_count;
                    array_push($points, $p);
                }
            }
        }
        return $points;
    }

    /**
     * @param $query_string 搜索字符串
     * @param $type1 物业类型1
     * @param bool $isNew 是否新盘, true 新盘, false 二手盘
     * @return string json
     */
    public function ESAutoComplete($query_string, $type1, $isNew = false){
    	return $this->esIndex_new->ESAutoComplete($query_string, $type1, $isNew);
    }
}
