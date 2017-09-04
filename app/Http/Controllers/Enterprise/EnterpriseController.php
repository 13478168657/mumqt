<?php
namespace App\Http\Controllers\Enterprise;

use Illuminate\Routing\Controller;
use App\Dao\Enterprise\EnterpriseDao;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Services\Search;
use App\Http\Controllers\Utils\RedisCacheUtil;

/**
 *  Description of EnterpriseController
 *  企业店铺介绍
 *  @author   zhuwei
 *  @date     2016年2月22日  13:28:35
 */
class EnterpriseController extends Controller{
    
    protected $EnterpriseDao;
    public function __construct() {
        $this->EnterpriseDao = new EnterpriseDao();
    }
    /**
     *   企业店铺页面
     * @param  $enterpriseId    企业id 
     */

    public function enterpriseShop(){
        // 企业id
        $enterpriseId = Input::get('shopId');
        $shopInfo = $this->EnterpriseDao->GetEnterpriseInfo($enterpriseId);
        $shopInfo[0]->intro = mb_substr($shopInfo[0]->intro,0,160);
        $shopInfo[0]->focusCommIds = !empty($shopInfo[0]->focusCommIds) ? explode('|',$shopInfo[0]->focusCommIds) : '';
        $shopInfo[0]->allCommIds = !empty($shopInfo[0]->allCommIds) ? explode('|',$shopInfo[0]->allCommIds) : '';
        if(!empty($shopInfo[0]->focusCommIds) || !empty($shopInfo[0]->allCommIds)){
            $commIds = array_merge($shopInfo[0]->focusCommIds,$shopInfo[0]->allCommIds);
        } 
        $allComm = [];   // 全部楼盘的数据  对应全部楼盘的id获得
        $allimages = [];
        $focusComm = [];
        $focusimages = [];
        if(isset($commIds) && !empty($commIds)){
            // 查询图片
            $images = $this->EnterpriseDao->GetEnterCommImage($commIds,10); 
            // 查询数据
            $commSearch = new Search();
            $searchData = $commSearch->searchCommunityListByIds($commIds,1)->docs;  
            foreach($searchData as $k => $search){
                if(isset($search->_source)){
                    $searchData[$k]->_source->cityName = RedisCacheUtil::getCityNameById($search->_source->cityId);  // 市
                    // 查询环线
                    $searchData[$k]->_source->loopName =  $this->EnterpriseDao->GetLoopLine($search->_source->loopLineId); 
                    // 查询销售状态
                    //$searchData[$k]->_source->salesStatus = $this->EnterpriseDao->GetCommunityState($search->_source->id);
                    if(in_array($search->_source->id,$shopInfo[0]->allCommIds)){
                        $allComm[] = $search;
                    }else{
                        $focusComm[] = $search;
                    }
                }
            }
        }
        return view('enterprise.aboutShop',['shopInfo'=>$shopInfo,'images'=>$images,'focusComm'=>$focusComm,'allComm'=>$allComm]);
    }
    
}