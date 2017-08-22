<?php
namespace App\Http\Controllers\Test;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Blade;
use Auth;
use DB;
use Cache;
use App\Http\Controllers\Perm\PermController;
use App\Http\Controllers\Utils\PermUtil;
use App\CommunityDataStructure;
use App\Http\Controllers\Utils\SafeUtil;
use App\Http\Controllers\Utils\AuditLogUtil;
use Queue;
use App\Commands\ClickQueue;
use App\Http\Controllers\Ajax\AjaxController;
use Input;
/**
 * 测试页面
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2015年11月13日 下午5:43:47
 * @version 1.0
 */
class TestController extends Controller{
	/**
	 * 权限测试页面
	 */
	public function index(){
		/* 点击记录 */
		Queue::push(new \App\Commands\ClickQueue('houserentoldclicklog', 1, 1, 1));
		$ajaxObj = new AjaxController();
		$ajaxObj->clickRecord(true, 'houserentoldclicklog', 2, 2, 1);
		$ajaxObj->clickRecord(true, 'houserentoldclicklog', 2, 2, 3);
		$ajaxObj->clickRecord(true, 'houserentoldclicklog', 2, 3, 1);
		$ajaxObj->clickRecord(true, 'houserentoldclicklog', 2, 2, 1);
		$ajaxObj->clickRecord(true, 'housesaleoldclicklog', 2, 2, 1);
		$ajaxObj->clickRecord(true, 'housesalenewclicklog', 2, 2, 1);
		var_dump(Cache::get('houserentoldclicklog'));
		var_dump(Cache::get('housesalenewclicklog'));
		var_dump(Cache::get('housesaleoldclicklog'));
		dd(321); 
		
		
		/* self::setacreagediffInfo();
		$s = new AuditLogUtil();
// 		dd($s->submitAuditLog(1,12,0,40));
		dd($s->delAuditLog(2, 'community', 1, 0)); */
		
// 		dd($s->RecordAuditLogCache(1, 2, 3, 40, 'community', 1, 2, 'addresffs', '', 'vasfdv', 'vevevc', '驳回原因f', '申诉原因'));
//  		$s->RecordAuditLog(2, 'community', 1, 'type102Info', 'volume', 0.4, 0.5, '驳回原因', '申诉内容');
//  		$array = $s->RecordAuditLog(2, 'community', 1, 'type102Info', 'volume2', 0.4, 0.7, '驳回原因', '申诉内容');
//  		$b = new AuditLogUtil($array);
//  		dd($b);
		
		
		/* $s = array();
		$s['fromtable_community'] = array(
				[1]=>array(		//id=1
						array(
								'fieldName'=>'zipCode',
								'oldVal'=>'10000',
								'newVal'=>'10001',
								'rejectReason'=>'驳回原因',
								'appeal'=>'申诉内容',
								'type'=>2			//字段状态：2.审核不通过 3.再次审核 4.审核通过
						),
						array(
								'fieldName'=>'type101Info',
								'fieldName2'=>'volume',
								'oldVal'=>0.4,
								'newVal'=>0.5,
								'rejectReason'=>'驳回原因',
								'appeal'=>'申诉内容',
								'type'=>2
						)
				)
		);
		$s['fromtable_building'] = array(
				[1]=>array(
						array(				//修改
								'fromId'=>1,
								'fieldName'=>'num',
								'oldVal'=>'楼栋名称（旧）',
								'newVal'=>'楼栋名称（新）',
								'rejectReason'=>'驳回原因',
								'appeal'=>'申诉内容',
								'type'=>2
						)
				),
				[2]=>array(
						array(				//修改
								'fromId'=>2,
								'fieldName'=>'floorTotal',
								'oldVal'=>'4',
								'newVal'=>6,
								'rejectReason'=>'',
								'appeal'=>'',
								'type'=>2
						)
				)
		);
		//type=2		审核不通过记录
		
		dd($s); */
// 		$safeObj = new SafeUtil();
// 		$s1 = $safeObj->encrypt('aaa');
// 		echo $s1;
// 		$s2 = $safeObj->decrypt($s1);
// 		dd($s2);
		/* $serialize = '';
		$communityObj = new CommunityDataStructure(101);
		$communityObj->aaa = 2;
		$serialize = $communityObj->serialize();
		echo $serialize;
		$unserialize = $communityObj->unserialize($serialize);
		dd($unserialize);
		exit; */
// 		dd(serialize($communityObj));
		/* $permUtil = new PermUtil;
		$cityObj = $permUtil->getPermValueByRid('city', Session::get('user.rId'));
		var_dump($cityObj); */
		return view('test.test')->with('permUtil', $permUtil);
	}
	public function fff(){
		echo "123";
	}
	
	/**
	 * 初始化acreagediff表数据
	 */
	public function setacreagediffInfo(){
		$result = DB::connection('mysql_house')->select('select c.id as cityId, p.id as provinceId, c.name as cityName, p.name as provinceName from city c left join province p on p.id=c.provinceId');
		$arr = array(
				1=>array(101,102,103,104,105,106),
				2=>array(201,303,203,204),
				3=>array(301,302,303,304,305)
		);
		foreach($result as $k1=>$v1){
			foreach($arr as $k2=>$v2){
				
			}
		}
		dd($result);
	}
	
	/**
	 * 权限配置测试页面
	 */
	public function configPerm(){
		$permModuleArr = array();
		$permModuleObj = DB::table('perm_url_f')
			->join('perm_url_s', 'perm_url_s.id', '=', 'perm_url_f.code_system')
			->join('perm_url_m', 'perm_url_m.id', '=', 'perm_url_f.code_module')
			->select('perm_url_f.*', 'perm_url_f.name as function_name', 'perm_url_s.name as system_name', 'perm_url_m.name as module_name')
			->where('perm_url_f.code_system', '<>', 0)
			->get();
		foreach($permModuleObj as $permModule){
			$permModuleArr[$permModule->code_system]['name'] = $permModule->system_name;
			$permModuleArr[$permModule->code_system][$permModule->code_module]['name'] = $permModule->module_name;
			$permModuleArr[$permModule->code_system][$permModule->code_module][$permModule->code_function] = array('id'=>$permModule->id, 'url'=>$permModule->url, 'name'=>$permModule->name);
		}
// 		dd($permModuleArr);
		return view('test.configPerm', ['permModuleArr'=>$permModuleArr]);
	}
	
	public function mainlayout(){
		return view('test.mainlayout');
	}
	
	/**
	 * 测试虚拟号相关
	 */
	public function Virtualphone(){
		$Virtualphone = new \App\Http\Controllers\Virtualphone\VirtualphoneController();
		$VirtualphoneDao = new \App\Dao\Virtualphone\VirtualphoneDao();
		/* 虚拟号注册 */
// 		$result = $Virtualphone->sendUrl_getXmlInfo('XH_FINISH', ['virtualMobile'=>'15359102476', 'key'=>'15970395', 'AreaCode'=>591, 'UserName'=>'', 'Address'=>'']);
		/* 虚拟号获取 */
		/* $result = $Virtualphone->sendUrl_getXmlInfo('XH_QUERY', []);
		echo "<pre>";
		var_dump($result);
		$VirtualphoneDao = new \App\Dao\Virtualphone\VirtualphoneDao;
		$VirtualphoneDao->creatPool($result['Body']['Data']['Ims'], $result['Body']['Data']['Key'], $result['Body']['Data']['Areacode'], 1);
// 		var_dump($result);
		$a1 = $Virtualphone->sendUrl_getXmlInfo('XH_FINISH', ['virtualMobile'=>$result['Body']['Data']['Ims'], 'key'=>$result['Body']['Data']['Key'], 'AreaCode'=>591, 'UserName'=>'', 'Address'=>'']);
		var_dump($a1);
		$a2 = $Virtualphone->sendUrl_getXmlInfo('IMS_BUY', ['virtualMobile'=>$result['Body']['Data']['Ims'], 'key'=>$result['Body']['Data']['Key']]);
		var_dump($a2); */
		/* 绑定虚拟号 */
// 		$result = $Virtualphone->sendUrl_getXmlInfo('XH_DIAL1', ['virtualMobile'=>'15359102946', 'key'=>'80351560', 'customerMobile'=>'13836129404', 'brokerMobile'=>'15110287652']);
		/* 获取小号绑定关系 */
		$result = $Virtualphone->sendUrl_getXmlInfo('XH_SEARCH1', ['virtualMobile'=>'15359102734', 'key'=>'24888479', 'Telno1'=>'', 'Telno2'=>'']);
		/* 取消绑定关系 */
// 		$result = $Virtualphone->sendUrl_getXmlInfo('XH_CLOSE1', ['virtualMobile'=>'15359102429', 'key'=>'07666131', 'customerMobile'=>'13269783192', 'brokerMobile'=>'15727375690']);
		
		/* 测试搜索现有关联号码关系 */
// 		$result = DB::connection('mysql_user')->table('virtualphone_pool')->where('virtualMobile', 15359102429)->first();
		/* 修改号码池虚拟号状态 */
// 		$result = $VirtualphoneDao->editPool(15359102479, 1);
		/* 取消所有当前小号下的绑定号码关系（慎用） */
// 		$result = $Virtualphone->xh_close_all();
		/* 获取所有当前小号下的绑定关系 */
// 		$result = $Virtualphone->xh_search_all();
		/* 购买小号套餐点数 */
// 		$result = $Virtualphone->sendUrl_getXmlInfo('IMS_BUY', ['virtualMobile'=>'15359102479', 'key'=>'44817470']);
		/* 设置账单推送地址 */
// 		$result = $Virtualphone->setBillsUrl();
		/* 设置录音对送地址 */
// 		$result = $Virtualphone->setRecordUrl();
		/* 获取指定虚拟号点数使用情况 */
// 		$result = $Virtualphone->sendUrl_getXmlInfo('IMS_USE_LOG', ['virtualMobile'=>'15359102947', 'key'=>'37034135']);
		/* 获取所有虚拟号点数使用情况，并记录 */
// 		$result = $Virtualphone->getImsPoint();
		/* 获取所有当前小号点数使用情况，根据剩余点数分别购买点数套餐补全 */
// 		$result = $Virtualphone->buyImsAll();
		print_r($result);
	}
	
	public function testEsSearch(){
		$EsSearch = new \App\Services\Search('hr');
		/* 查询用户 */
// 		$result = $EsSearch->searchBrokerById(1530169);
// 		dd($result);
		/* 删除索引 */
		$result = $EsSearch->houseIndexDelete(39011977);
		dd($result);
	}
	
	/**
	 * 测试虚拟号绑定、解绑、通话
	 */
	public function testVirtualphone(){
		$poolObj = DB::connection('mysql_user')->table('virtualphone_pool')->where('state', 1)->get();
		if(Input::get('type')!==''){		//提交表单
			if(empty(Input::get('customerMobile')) || empty(Input::get('brokerMobile')) || empty(Input::get('virtualMobile'))){
				echo "请完整填写数据";
				return view('test.testVirtualphone', compact('poolObj'));
			}else{
				$customerMobile = Input::get('customerMobile');
				$brokerMobile = Input::get('brokerMobile');
				$virtualMobile_arr = explode('_', Input::get('virtualMobile'));
				$virtualMobile = $virtualMobile_arr[0];
				$key = $virtualMobile_arr[1];
			}
			$virtualphoneObj = new \App\Http\Controllers\Virtualphone\VirtualphoneController;
			if(Input::get('type') == 'XH_DIAL1'){		//号码绑定
				$resultInfo = $virtualphoneObj->sendUrl_getXmlInfo(Input::get('type'), ['virtualMobile'=>$virtualMobile, 'key'=>$key, 'customerMobile'=>$customerMobile, 'brokerMobile'=>$brokerMobile]);
				if($resultInfo['Head']['Result'] == 0){		//成功
					echo "成功";
				}else{
					if($resultInfo['Head']['Result'] == -1 && $resultInfo['Head']['ResultDesc'] == '该绑定关系已经存在！'){
						echo "成功";
					}else{							//失败
						echo "失败";
						var_dump($resultInfo);
					}
				}
			}elseif(Input::get('type') == 'XH_CLOSE1'){	//号码解绑
				if(empty($customerMobile) || empty($brokerMobile)){
					echo "请完成填写数据！";
				}else{
					$resultInfo = $virtualphoneObj->sendUrl_getXmlInfo('XH_CLOSE1', ['virtualMobile'=>$virtualMobile, 'key'=>$key, 'customerMobile'=>$customerMobile, 'brokerMobile'=>$brokerMobile]);
					if($resultInfo['Head']['Result'] == 0){		//成功
						echo "成功";
					}else{
						echo "失败";
						var_dump($resultInfo);
					}
				}
			}
		}
		return view('test.testVirtualphone', compact('poolObj'));
	}
	
	/**
	 * 测试es索引搜索
	 */
	function es_search(){
		$es_Search = new \App\Services\Search_new('hr');
		$houseList = new \App\ListInputView();
		$houseList->uid = 712276;
		$houseList->cityId = CURRENT_CITYID;
		$houseList->pageset = 1000;
		dd($es_Search->searchHouse($houseList));
	}

	/**
	 * 测试es索引搜索个数
	 */
	function es_searchCount(){
		$es_Search = new \App\Services\Search();
		$lisAttr = new \App\ListInputView();
		$lisAttr->cityId = 1;//城市id
//		$lisAttr->subwayLineId = 2;//地铁线路id
//		$lisAttr->subwayStationId = 226;
		$lisAttr->order = 'timeCreate';
		$lisAttr->asc = 0;
		$lisAttr->page = 1;
		$lisAttr->pageset = 1000;

//		$lisAttr->isNew = false;
//		dd($es_Search->searchCommunity($lisAttr));

		dd($es_Search->searchHouse4Group($lisAttr, 'subwayLineId', false));
	}
}