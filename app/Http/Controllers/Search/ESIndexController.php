<?php

namespace App\Http\Controllers\Search;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Utils\TextUtil;
/**
 * ES控制类，由SearchController调用，提供ES层搜索接口，返回JSON格式的纯文本结果
 *
 * @author yuanl
 */
class ESIndexController {
    
    public $communityUrl;
    public $houseRentUrl;
    public $houseSaleUrl;
    
    public function __construct(){
        $this->communityUrl = Config::get("esIndex.communityUrl_old");
        $this->houseRentUrl = Config::get("esIndex.houseRentUrl_old");
        $this->houseSaleUrl = Config::get("esIndex.houseSaleUrl_old");
    }
        
    public function SearchHouse($searchType,$fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc){
        if ($searchType === 'hr'){
            return ESIndexController::ESSearch($this->houseRentUrl,$fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc);
        } else {
            return ESIndexController::ESSearch($this->houseSaleUrl,$fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc);
        }
    }
    
    public function SearchCommunity($fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc){
        return ESIndexController::ESSearch($this->communityUrl,$fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc);
    }
    
    public function SearchCount($searchType,$esQuerys,$esFilters,$groupField){
        if ($searchType === 'hr'){
            return ESIndexController::ESSearchCount($this->houseRentUrl,$esQuerys,$esFilters,$groupField);
        } else if ($searchType === 'hs') {
            return ESIndexController::ESSearchCount($this->houseSaleUrl,$esQuerys,$esFilters,$groupField);
        } else {
            return ESIndexController::ESSearchCount($this->communityUrl,$esQuerys,$esFilters,$groupField);
        }
    }
    
    private function ESSearch($qryUrl,$fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc){
        $url = $qryUrl."_search?pretty";
        $data = ESIndexController::CreateQueryStr($fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc);
        $opts = array(
            "http"=>array(
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        return $html;
    }
    
    private function ESSearchCount($qryUrl,$esQuerys,$esFilters,$groupField){
        
//        $r = ESIndexController::ESSearch($qryUrl,'',$esQuerys,$esFilters,1,10,'',false);
        
        $url = $qryUrl."_search?search_type=count";
//        $groupField = '';
        $data = ESIndexController::CreateCountStr($esQuerys,$esFilters,$groupField);
        $opts = array(
            "http"=>array(
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        return $html;
    }
        
    private function ESSearchGroupCount($qryUrl,$esQuerys,$esFilters,$groupField){
        $url = $qryUrl."_count";
        $data = ESIndexController::CreateCountStr($esQuerys,$esFilters,$groupField);
        $opts = array(
            "http"=>array(
                'method' => 'GET',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        return $html;
    }
      
    private function CreateCountStr($esQuerys,$esFilters,$groupField){
        $sq = "";
        if (count($esQuerys) > 0 || count($esFilters) > 0){
            $sq .= "{";            
            $sq .= "\"query\":{";
            $sq .= "\"filtered\":{";
            $sq .= "\"query\":{\"query_string\":{";
            $sq .= "\"default_operator\":\"AND\",";
            $sq .= "\"query\":\"";
            $sqi = "";
            for($i = 0; $i < count($esQuerys); $i++){                
                $q = $esQuerys[$i];
                $vals = explode(" ",TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($q->keywords)));
                for ($j = 0; $j < count($vals); $j++){
                    if ($vals[$j] != ""){
                        if ($sqi != ""){
                            $sqi .= " AND ";
                        }
                        $sqi .= "(".$q->field.":".$vals[$j].")";
                    }
                }
            }
            $sq .= $sqi;
            $sq .="\"}},";            
            $sq .= "\"filter\": {";
            if (count($esFilters) > 0){
                $sq .= "\"and\" : [{";                
            }
            for ($i = 0; $i < count($esFilters); $i++){
                $f = $esFilters[$i];
                if ($i > 0){
                    $sq .= ",{";
                }
                if ($f->type == 2){
                    $sq .= "\"terms\": {";
                    $sq .= "\"".$f->field."\":[";
                    for ($j = 0; $j < count($f->values); $j++){
                        if ($j > 0){
                            $sq .= ",";
                        }
                        $sq .= "\"". $f->values[$j] . "\"";
                    }
                    $sq .= "]}}";
                } else if ($f->type == 3){
                    $sq .= "\"terms\": {";
                    $sq .= "\"". $f->field ."\":[";
                    $sq .= "\"". $f->values . "\"";
                    $sq .= "]}}";
                }else {
                    $sq .= "\"range\": {";
                    $sq .= "\"".$f->field."\":{";
                    $sq .= "\"gte\":".$f->minValue.",";
                    $sq .= "\"lte\":".$f->maxValue."}}}";
                }
            }
            if (count($esFilters) > 0){
                $sq .= "]";
            }
            $sq .= "}}}";
            if (!empty($groupField)){
                $sq .= ",\"aggs\": {";
                $sq .= "\"group\": {";                
                $sq .= "\"terms\": {";
                $sq .= "\"field\": \"" . $groupField . "\",\"size\": 1000";
                $sq .= "}}}";
            }
            $sq .= "}";
        }
        return $sq;
    }
    
    private function CreateQueryStr($fields,$esQuerys,$esFilters,$pg,$ps,$sort,$asc){
        $sq = "";
        $from = ($pg - 1) * $ps;
        if (count($esQuerys) > 0 || count($esFilters) > 0){
            $sq .= "{";
            $sq .= "\"from\":".$from.",\"size\":".$ps.",";            
            $sq .= "\"query\":{";
            $sq .= "\"filtered\":{";
            $sq .= "\"query\":{\"query_string\":{";
            $sq .= "\"default_operator\":\"AND\",";
            $sq .= "\"query\":\"";
            $sqi = "";
            for($i = 0; $i < count($esQuerys); $i++){                
                $q = $esQuerys[$i];
                $vals = explode(" ",TextUtil::FormatQueryBlank(TextUtil::FormatInQueryStr($q->keywords)));
                for ($j = 0; $j < count($vals); $j++){
                    if ($vals[$j] != ""){
                        if ($sqi != ""){
                            $sqi .= " AND ";
                        }                  
                        $sqi .= "(".$q->field.":".$vals[$j].")";
                    }
                }
            }
            $sq .= $sqi;
            $sq .="\"}},";            
            $sq .= "\"filter\": {";
            if (count($esFilters) > 0){
                $sq .= "\"and\" : [{";                
            }
            for ($i = 0; $i < count($esFilters); $i++){
                $f = $esFilters[$i];
                if ($i > 0){
                    $sq .= ",{";
                }
                if ($f->type == 2){
                    $sq .= "\"terms\": {";
                    $sq .= "\"".$f->field."\":[";
                    for ($j = 0; $j < count($f->values); $j++){
                        if ($j > 0){
                            $sq .= ",";
                        }
                        $sq .= "\"". $f->values[$j] . "\"";
                    }
                    $sq .= "]}}";
                } else {
                    $sq .= "\"range\": {";
                    $sq .= "\"".$f->field."\":{";
                    $sq .= "\"gte\":".$f->minValue.",";
                    $sq .= "\"lte\":".$f->maxValue."}}}";
                }
            }
            if (count($esFilters) > 0){
                $sq .= "]";
            }    
            $sq .= "}}}";
//            $sq .= ",\"aggs\": {";
//            $sq .= "\"group\": {";
//            $sq .= "\"terms\": {";
//            $sq .= "\"field\": \"cityId\"";
//            $sq .= "}}}";
//            if ($sort === ""){
//                $sq .= ",\"sort\":[\"_score\"]";
//            } else {
//                $sq .= ",\"sort\":[{\"".$sort."\":{\"order\": \"".($asc ? "asc" : "desc")."\"}},\"_score\"]";
//            }
//            $sq .= "\"highlight\":{";
//            $sq .= "\"fields\":{";
//            $sq .= "\"name\":{}";
//            $sq .= "}}";
//            $sq .= ",\"fields\":[" . $fields ."]";
            $sq .= "}";
        }
        return $sq;
    }    
}
