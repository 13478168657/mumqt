<?php
namespace App;
use Illuminate\Support\Facades\Input;
/**
* Description of BrokerInputView （经济人列表接收表单）
* @author lixiyu
* @since 1.0
*/
class BrokerInputView{
	public $isSaleBroker = 0;	    //经济人类型 sale售房 
	public $isRentBroker = 0;		//经济人类型 rent租房 
	public $idcardState = 1;		//经济人身份证审核通过的数据
	public $keyword; 			//搜索关键字 经纪人名/所属公司/楼盘名称
	public $provinceId;			//省份id
	public $cityId;				//城市id
	public $cityAreaId;       	//地区id
	public $business; 		  	//商圈id
	public $tagid;				// 筛选经济人标签id 用逗号隔开的id串
	public $must_not;			//不等于字段数组['field1'=>'val1', 'field2'=>'val2'.....]
	public $range;				//查询范围数据['field1'=>['gte'=>'val1a', 'lte'=>'va11b'], .....];大于小于
	public $order;				//排序方式（默认/'' or 信用分/credit）
	public $asc;				//正序、倒序
    public $orderby;          //排序数据[['aaa'=>'desc'], ['bbb'=>'asc']....]。使用该参数时$order和$asc无效
	public $page;				//当前页码
	public $pagesize = 20;			//单页条数

	public function __construct(){
		$type      	=  Input::get('type');
		if(empty($type)){
			$this->isSaleBroker = 0;
			$this->isRentBroker = 0;
		}else if($type == 'sale'){
			$this->isSaleBroker = 1;
		}else if($type == 'rent'){
			$this->isRentBroker = 1;
		}
		$this->keyword    	= !empty(Input::get('keyword')) 	? Input::get('keyword') 	: '' ;
		$this->provinceId 	= !empty(Input::get('provinceId')) 	? Input::get('provinceId') 	: '' ;
		$this->cityId 		= !empty(Input::get('cityId')) 		? Input::get('cityId') 		: CURRENT_CITYID ;
		$this->cityAreaId 	= !empty(Input::get('cityAreaId')) 	? Input::get('cityAreaId') 	: '' ;
		$this->business 	= !empty(Input::get('business')) 	? Input::get('business') 	: '' ;
		$this->tagid 		= !empty(Input::get('tagid')) 		? Input::get('tagid') 		: '' ;
		$this->must_not		= [
			['photo'=>"/images/userImg/secrect_001.jpg"],
			['photo'=>"/images/userImg/boy_001.jpg"],
			['photo'=>"/images/userImg/boy_002.jpg"],
			['photo'=>"/images/userImg/boy_003.jpg"],
			['photo'=>"/images/userImg/girl_001.jpg"],
			['photo'=>"/images/userImg/girl_002.jpg"],
			['photo'=>"/images/userImg/girl_003.jpg"],
		];
		$this->range		= [];
		$this->order 		= !empty(Input::get('order')) 		? Input::get('order') 		: 'integrity' ;
		$this->asc 			= !empty(Input::get('asc')) 		? Input::get('asc') 		: false ;
		$this->page 		= !empty(Input::get('page')) 		? Input::get('page') 		: 1 ;
        $this->orderby    = !empty(Input::get('orderby'))      ? Input::get('orderby')      : [];
	}
}