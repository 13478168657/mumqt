<?php
namespace App\Http\Controllers\Virtualphone;
use Illuminate\Routing\Controller;
use App\Dao\Virtualphone\VirtualphoneDao;
use Input;
use DOMDocument;
use Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\AlarmMessageUtil;
use DB;
use App\Dao\User;
/**
 * 虚拟电话号码操作类
 * 相关数据可进行缓存，目前暂时直接调取数据库内容，若正式上线发现压力过大再行修改
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年2月16日 下午1:54:22
 * @version 1.0
 */
class VirtualphoneController extends Controller{
	function __construct(){
		$this->urlHead = 'http://110.84.128.78:8088/httpIntf/dealIntf?postData=';
		$this->Spid = '889351';
		$this->Appid = '575';
		$this->Passwd = 'sf40060907982';
		$this->sha1Paswd = sha1($this->Passwd); // 密码加密
// 		$this->Timestamp = date('Ymdhis',time()); // 获取要求的时间格式
		$this->perNum = 1;		//若号码池数量不足，通过接口请求新的虚拟号，每次请求虚拟号个数
		$this->enterpriseshopId = 0;
		$this->isRecord = 1;					//默认是否记录通话录音：1.是 ；其他.否
		$this->virtualphoneTimeout = 60;		//用户获取虚拟号后不使用超时时间（单位：秒）
		$this->callLogDuration = 30;			//判断是否计插入客户待登记条件--通话时长
		$this->PointsSpId = 100575;				//购买套餐id
		$this->VirtualphoneDao = new VirtualphoneDao;
		$this->AlarmMessageUtil = new AlarmMessageUtil;
	}
	/**
	 * 获取经纪人虚拟号码
	 */
	public function getDisplayNbr(){
		/* 用户验证登录、注册等操作 */
		$result = ['result'=>true, 'message'=>''];
		if(Auth::check()){			//客户登陆状态
			$customerMobile = Auth()->user()->mobile;//客户手机号
			$uId = Auth()->user()->id;//用户id
			$userType = Auth()->user()->type;//用户类型
			if($userType != 1){
				$result = ['result'=>false, 'message'=>'您的账号是经纪人，请更换账号进行登陆'];
				return json_encode($result);
			}
		}elseif(Input::get('customerMobile', 0)>0){			//客户未登录，直接用手机号验证码
			$customerMobile = Input::get('customerMobile', 0);//客户手机号
			$captcha = Input::get('captcha', 0);
			$login_result = \App\Http\Controllers\Auth\AuthController::postRegisterQuickMobile($customerMobile, $captcha);
			if($login_result['result'] == false){		//登陆失败
				$result = $login_result;
				return json_encode($result);
			}
			$uId = Auth::user()->id;
		}else{
			$result = ['result'=>false, 'message'=>'unLogin'];
			return json_encode($result);
		}
		/* 获取虚拟小号操作 */
		$this->EsSearch = new \App\Services\Search();
		$communityId = Input::get('cId');		//楼盘id
// 		$type2 = Input::get('type2');			//物业类型2
		$brokerId = Input::get('brokerId');		//经纪人id
		$brokerObj = $this->EsSearch->searchBrokerById($brokerId);
		if($brokerObj->found == true){		//是经纪人
			$brokerMobile = trim($brokerObj->_source->mobile);
			$this->enterpriseshopId = $brokerObj->_source->enterpriseshopId;
		}else{								//是普通用户
			$brokerObj = \App\Dao\User\UserDao::getUserDataById($brokerId);
			$brokerMobile = trim($brokerObj->mobile);
		}
		
// 		$displayMobile = self::getBrokerMobile($brokerMobile, $customerMobile);	
		$displayMobile = $this->VirtualphoneDao->getRelationvirtualMobile($customerMobile, $brokerMobile);//获取已建立关系的虚拟号
// 		$displayMobile = 'xxx';		//虚拟号码
		if(empty($displayMobile) || is_null($displayMobile)){		//没有具有关系的关联小号，需要进行关联
			
// 			$displayMobile = self::getRelationvirtualMobile($customerMobile, $brokerMobile, $uId, $brokerId, $this->enterpriseshopId, $communityId);//获取经纪人、客户双方关联虚拟号
			$result = self::getRelationvirtualMobile($customerMobile, $brokerMobile, $uId, $brokerId, $this->enterpriseshopId, $communityId);//获取经纪人、客户双方关联虚拟号
			if($result['result'] == false){
				if(Auth::check()){		//已登录状态
					$result['userName'] = Auth::user()->userName;
					$result['mobile'] = Auth::user()->mobile;
					return json_encode($result);
				}else{
					$result = ['result'=>false, 'message'=>'unLogin'];
					return json_encode($result);
				}
			}else{
				$displayMobile = $result['message'];
			}
		}
		if(Auth::check()){		//已登录状态
			$result = ['result'=>true, 'message'=>$displayMobile, 'userName'=>Auth::user()->userName, 'mobile'=>Auth::user()->mobile];
			return json_encode($result);
		}else{
			$result = ['result'=>true, 'message'=>$displayMobile];
			return json_encode($result);
		}
	}
	
	/**
	 * 获取已存在的对应虚拟小号
	 * @param	int		$brokerMobile	经纪人手机号
	 * @param	int		$customerMobile	当前用户手机号
	 * @return	int		虚拟小号
	 */
	public function getBrokerMobile($brokerMobile, $customerMobile){
		$displayMobile = $this->VirtualphoneDao->getDisplayMobile($brokerMobile, $customerMobile);
		return $displayMobile;
	}
	
	/**
	 * 建立客户与经纪人虚拟号联系
	 */
	public function createRelation($customerMobile, $brokerMobile){
		
	}
	
	/**
	 * 获取与双方都没有关系的虚拟号
	 */
	public function getUnRelationvirtualMobile($customerMobile, $brokerMobile){
		$virtualMobile = $this->VirtualphoneDao->getUnRelationvirtualMobile($customerMobile, $brokerMobile);
		return $virtualMobile;
	}
	
	/**
	 * 获取经纪人、客户双方关联虚拟号
	 * @param ing $customerMobile 用户电话号
	 * @param int $brokerMobile 经纪人电话号
	 * @param int $uId 用户id
	 * @param int $brokerId 经纪人id
	 * @param int $enterpriseshopId 分销商公司id
	 * @param int $communityId 楼盘id
	 * @return NULL|string
	 */
	public function getRelationvirtualMobile($customerMobile, $brokerMobile, $uId, $brokerId, $enterpriseshopId, $communityId){
		if(is_null($brokerMobile) || empty($brokerMobile)){		//经纪人没有手机号
			return ['result'=>false, 'message'=>'该经纪人没有手机号'];
		}
// 		dd('customerMobile='.$customerMobile.',brokerMobile='.$brokerMobile.',uId='.$uId.',brokerId='.$brokerId.',enterpriseshopId='.$enterpriseshopId.',communityId='.$communityId);
		$virtualMobile = $this->VirtualphoneDao->getRelationvirtualMobile($customerMobile, $brokerMobile);//获取双方关系虚拟号
		if(!empty($virtualMobile)){	//存在双方关系虚拟号，直接返回
			return ['result'=>true, 'message'=>$virtualMobile];
		}else{						//不存在双方关系虚拟号，通过接口获取
			/* 去号码池查找可用虚拟号 */
			$virtualMobile_obj = self::getUnRelationvirtualMobile($customerMobile, $brokerMobile);
			if(!is_null($virtualMobile_obj) && !empty($virtualMobile_obj)){	//获取待关联虚拟号，准备进行关联操作
				/* 开始进行虚拟号关联 */
				$resultInfo = self::sendUrl_getXmlInfo('XH_DIAL1', ['virtualMobile'=>$virtualMobile_obj->virtualMobile, 'key'=>$virtualMobile_obj->key, 'customerMobile'=>$customerMobile, 'brokerMobile'=>$brokerMobile]);
				if($resultInfo['Head']['Result'] == 0){		//成功
					$this->creatRelation($customerMobile, $brokerMobile, $virtualMobile_obj->id, $virtualMobile_obj->virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId);//建立关系数据
					return ['result'=>true, 'message'=>$virtualMobile_obj->virtualMobile];
				}else{								
					if($resultInfo['Head']['Result'] == -1 && $resultInfo['Head']['ResultDesc'] == '该绑定关系已经存在！'){
						$this->creatRelation($customerMobile, $brokerMobile, $virtualMobile_obj->id, $virtualMobile_obj->virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId);
						return ['result'=>true, 'message'=>$virtualMobile_obj->virtualMobile];
					}else{							//失败
						$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'虚拟号关联绑定失败', 'info'=>'虚拟号：'.$virtualMobile_obj->virtualMobile.'；key：'.$virtualMobile_obj->key.'；用户电话号：'.$customerMobile.'；经纪人电话号：'.$brokerMobile.'。接口返回信息：'.json_encode($resultInfo)]);
						return ['result'=>false, 'message'=>'获取号码失败(code:001)'];
					}
				}
			}else{										//号码池中没有多余虚拟号，需要再次进行申请
				$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'号码池虚拟号不足，尝试申请虚拟号码', 'info'=>'用户电话号：'.$customerMobile.'；经纪人电话号：'.$brokerMobile]);
				/* 获取、注册新的虚拟号并购买套餐点数，添加对应表数据 */
				$resultInfo = self::getNewVirtualphone();
				if(isset($resultInfo['result']) && $resultInfo['result'] == false){		//失败
					return $resultInfo;
				}
			}
			
			/* 开始进行虚拟号关联 */
			$resultInfo = self::sendUrl_getXmlInfo('XH_DIAL1', ['virtualMobile'=>$virtualMobile_obj->virtualMobile, 'key'=>$virtualMobile_obj->key, 'customerMobile'=>$customerMobile, 'brokerMobile'=>$brokerMobile]);
			if($resultInfo['Head']['Result'] == 0){		//成功
				$this->creatRelation($customerMobile, $brokerMobile, $virtualMobile_obj->id, $virtualMobile_obj->virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId);
				return ['result'=>true, 'message'=>$virtualMobile_obj->virtualMobile];
			}else{
				if($resultInfo['Head']['Result'] == -1 && $resultInfo['Head']['ResultDesc'] == '该绑定关系已经存在！'){
					$this->creatRelation($customerMobile, $brokerMobile, $virtualMobile_obj->id, $virtualMobile_obj->virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId);
					return ['result'=>true, 'message'=>$virtualMobile_obj->virtualMobile];
				}else{							//失败
					$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'虚拟号关联绑定失败', 'info'=>'虚拟号：'.$virtualMobile_obj->virtualMobile.'；key：'.$virtualMobile_obj->key.'；用户电话号：'.$customerMobile.'；经纪人电话号：'.$brokerMobile.'。接口返回信息：'.json_encode($resultInfo)]);
					return ['result'=>false, 'message'=>'获取号码失败(code:005)'];
				}
			}
			
// 			self::createRelation
		}
	}
	
	/**
	 * 获取、注册新的虚拟号并购买套餐点数，添加对应表数据
	 */
	public function getNewVirtualphone(){
		$resultInfo = self::sendUrl_getXmlInfo('XH_QUERY');
		if($resultInfo['Head']['Result'] == 0){		//获取新虚拟号成功
			$new_virtualMobile = $resultInfo['Body']['Data']['Ims'];
			$new_key = $resultInfo['Body']['Data']['Key'];
			$new_areacode = $resultInfo['Body']['Data']['Areacode'];
			$virtualMobile_obj = $this->VirtualphoneDao->creatPool($new_virtualMobile, $new_key, $new_areacode, 0);	//保存获取的新虚拟号到号码池中
			if(is_null($virtualMobile_obj)){			//保存失败
				$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'新虚拟号获取成功，保存失败', 'info'=>'虚拟号：'.$new_virtualMobile.'；key：'.$new_key.'；areacode:'.$new_areacode.'。接口返回信息：'.json_encode($resultInfo)]);
				return ['result'=>false, 'message'=>'获取号码失败(code:002)'];
			}
			/* 对获取成功的新虚拟号进行注册 */
			$resultInfo = self::sendUrl_getXmlInfo('XH_FINISH', ['virtualMobile'=>$new_virtualMobile, 'key'=>$new_key, 'AreaCode'=>$new_areacode, 'UserName'=>'', 'Address'=>'']);
			if($resultInfo['Head']['Result'] == 0){		//注册成功
				$virtualMobile_obj = $this->VirtualphoneDao->editPool($virtualMobile_obj->virtualMobile, 1);
				/* 对注册成功的虚拟号进行购买套餐点数的操作 */
				$resultInfo = self::sendUrl_getXmlInfo('IMS_BUY', ['virtualMobile'=>$virtualMobile_obj->virtualMobile, 'key'=>$virtualMobile_obj->key]);
				if($resultInfo['Head']['Result'] != 0){		//充值失败
					$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'虚拟号充值点数失败', 'info'=>'虚拟号：'.$virtualMobile_obj->virtualMobile.'；key：'.$virtualMobile_obj->key.'；接口返回信息：'.json_encode($resultInfo)]);
					return ['result'=>false, 'message'=>'获取号码失败(code:006)'];
				}
			}else{										//注册失败
				$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'新虚拟号获取成功，注册失败', 'info'=>'虚拟号：'.$new_virtualMobile.'；key：'.$new_key.'；areacode:'.$new_areacode.'。接口返回信息：'.json_encode($resultInfo)]);
				// 						return null;
				return ['result'=>false, 'message'=>'获取号码失败(code:003)'];
			}
		}else{								//失败
			$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'号码池虚拟号不足，尝试申请虚拟号码失败', 'info'=>'接口返回信息：'.json_encode($resultInfo)]);
			return ['result'=>false, 'message'=>'您绑定的号码数量已超过上限，请稍后再试。'];
		}
		return $resultInfo;
	}
	/**
	 * 检查用户获取小号（虚拟号）后是否在限定时间内使用该小号通话
	 * @param 
	 */
	/* public function checkDial($customerMobile, $brokerMobile, $virtualMobile){
		$this->virtualphoneTimeout;
	} */
	
	/**
	 * 创建虚拟号关系表数据、及相关数据
	 * @param	string		$customerMobile		客户电话号
	 * @param	string		$brokerMobile		经纪人电话号
	 * @param	int			$poolId				号码池id
	 * @param	int			$virtualMobile		虚拟号码
	 * @param	int			$uId				用户id
	 * @param	int			$brokerId			经纪人id
	 * @param	int			$enterpriseshopId	分销商公司id
	 * @param	int			$communityId		楼盘id
	 * @param	int			$state				虚拟号数据状态：0.未通过话 1.已通过话
	 */
	public function creatRelation($customerMobile, $brokerMobile, $poolId, $virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId, $state=0){
		$communityName = \App\Http\Controllers\Utils\RedisCacheUtil::getCommunityNameById($communityId);
// 		$communityName = ($communityName == '没有数据') ? '' : $communityName;
		//创建虚拟号与双方关系数据，并存入表中
		$this->VirtualphoneDao->creatRelation($customerMobile, $brokerMobile, $poolId, $virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId, $state);
		//创建虚拟号与双方关系历史数据，并存入表中
		$this->VirtualphoneDao->creatRelationLog($customerMobile, $brokerMobile, $poolId, $virtualMobile, $uId, $brokerId, $enterpriseshopId, $communityId, $state);	
		//插入客户数据
// 		$clientId = $this->VirtualphoneDao->insertInfo('mysql_user', 'client', ['uId'=>$uId, 'brokerId'=>$brokerId, 'phone'=>$virtualMobile, 'realPhone'=>$customerMobile, 'status1'=>0, 'status2'=>0, 'brokerAdd'=>0]);	
		//客户意向信息插入
// 		$clientItentionId = $this->VirtualphoneDao->insertInfo('mysql_user', 'client_itention', ['clientId'=>$clientId, 'brokerId'=>$brokerId, 'communityId'=>$communityId, 'communityName'=>$communityName, 'status1'=>0, 'status2'=>0]);	
		//客户订单状态信息插入
// 		$clientOrderId = $this->VirtualphoneDao->insertInfo('mysql_user', 'client_order', ['clientItentionId'=>$clientItentionId, 'status1'=>0, 'status2'=>0, 'brokerId'=>$brokerId, 'communityId'=>$communityId, 'communityName'=>$communityName]);
		//客户报备表	
// 		$clientReportId = $this->VirtualphoneDao->insertInfo('mysql_user', 'client_report', ['brokerId'=>$brokerId, 'customerId'=>$uId, 'DisplayNbr'=>$virtualMobile, 'CustomerNbr'=>$customerMobile]);
		//绑定楼盘信息更新时间刷新
		$this->VirtualphoneDao->updateTimeBindingBroker($enterpriseshopId, $communityId, $brokerId);		
	}
	

	/**
	* php发送http请求
	* @param string $url 需要请求的url地址
	* @return resource
	*/
	public function send_url($url){
		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
	
		// //释放curl句柄
		curl_close($ch);
		return $output;
	}
	
	function xml_parser($str){
		$xml_parser = xml_parser_create();
		if(!xml_parse($xml_parser,$str,true)){
			xml_parser_free($xml_parser);
			return false;
		}else {
			return (json_decode(json_encode(simplexml_load_string($str)),true));
		}
	}
	
	/**
	 * 通过接口发送数据，并接受数据进行解析
	 * @param	string		$MethodName		方法名
	 * @param	array		$send_arr		待发送数据集合
	 * @return	array						返回数据
	 */
	public function sendUrl_getXmlInfo($MethodName, $send_arr = []){
		$timestamp = date('Ymdhis',time());
		$Authenticator = sha1($timestamp.$MethodName.$this->Spid.$this->Passwd);
		if($MethodName == 'XH_DIAL1'){	//绑定双方号码与虚拟号
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>{$MethodName}</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<Ims>".$send_arr['virtualMobile']."</Ims>".
					"<Key>".$send_arr['key']."</Key>".
					"<Telno1>".$send_arr['customerMobile']."</Telno1>".
					"<Telno2>".$send_arr['brokerMobile']."</Telno2>".
					"<IsRecord>$this->isRecord</IsRecord>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'XH_CLOSE1'){	//取消虚拟号与通话双方绑定关系
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>{$MethodName}</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<Ims>".$send_arr['virtualMobile']."</Ims>".
					"<Key>".$send_arr['key']."</Key>".
					"<Telno1>".$send_arr['customerMobile']."</Telno1>".
					"<Telno2>".$send_arr['brokerMobile']."</Telno2>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'XH_QUERY'){		//获取新的虚拟号
			$send_url_str = $this->urlHead.
			"<Request>".
			    "<Head>".
			        "<MethodName>{$MethodName}</MethodName>".
			        "<Spid>{$this->Spid}</Spid>".
			        "<Appid>{$this->Appid}</Appid>".
			        "<Passwd>{$this->sha1Paswd}</Passwd>".
			        "<Timestamp>{$timestamp}</Timestamp>".
			        "<Authenticator>{$Authenticator}</Authenticator>".
			    "</Head>".
			    "<Body>".
			        "<Number>{$this->perNum}</Number>".
			   "</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'XH_FINISH'){	//对新获取的虚拟号进行注册
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>{$MethodName}</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<Ims>".$send_arr['virtualMobile']."</Ims>".
					"<Key>".$send_arr['key']."</Key>".
					"<AreaCode>".$send_arr['AreaCode']."</AreaCode>".
					"<UserName>".$send_arr['UserName']."</UserName>".
					"<Address>".$send_arr['Address']."</Address>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'XH_SEARCH1'){					//查询小号定制接口绑定关系
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>{$MethodName}</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<Ims>".$send_arr['virtualMobile']."</Ims>".
					"<Key>".$send_arr['key']."</Key>".
					"<Telno1>".$send_arr['Telno1']."</Telno1>".
					"<Telno2>".$send_arr['Telno2']."</Telno2>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'IMS_BUY'){						//购买套餐
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>IMS_BUY</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<PointsSpId>".$this->PointsSpId."</PointsSpId>".
					"<Ims>".$send_arr['virtualMobile']."</Ims>".
					"<Key>".$send_arr['key']."</Key>".
					"<Type>1</Type>".
					"<EffectType>1</EffectType>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'BILLS_URL'){						//设置账单推送地址
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>BILLS_URL</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<Url>".$send_arr['url']."</Url>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'PushRecordUrl'){						//设置录音推送地址
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>PushRecordUrl</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
				"<Body>".
					"<Url>".$send_arr['url']."</Url>".
				"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}elseif($MethodName == 'IMS_USE_LOG'){							//获取小号点数使用情况
			$send_url_str = $this->urlHead.
			"<Request>".
				"<Head>".
					"<MethodName>IMS_USE_LOG</MethodName>".
					"<Spid>{$this->Spid}</Spid>".
					"<Appid>{$this->Appid}</Appid>".
					"<Passwd>{$this->sha1Paswd}</Passwd>".
					"<Timestamp>{$timestamp}</Timestamp>".
					"<Authenticator>{$Authenticator}</Authenticator>".
				"</Head>".
			"<Body>".
				"<Ims>".$send_arr['virtualMobile']."</Ims>".
				"<Key>".$send_arr['key']."</Key>".
			"</Body>".
			"</Request>";
			$result = self::send_url($send_url_str);
			$resultInfo = self::xmlInfo($result, $send_url_str);
		}
		return $resultInfo;
	}
	
	/**
	 * 获取请求成功后返回的 Ims Key AreaCode
	 * @param 	string	$result		获取的xmlInfo
	 * @param	array	$field_arr	待查询的字段名集合
	 * @return array
	 */
	public function xmlInfo($result, $send_url_str = []){
	
		if(self::xml_parser($result)){		//判断xml格式是否正确
			$xmlInfo = (json_decode(json_encode((array) simplexml_load_string($result)), true));
			return $xmlInfo;
		}else{
			$xmlInfo = ['Head'=>['Result'=>-1, 'ReaultDesc'=>'接口请求返回数据格式错误']];
			$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'接口请求返回数据格式错误', 'info'=>'发送信息：'.json_encode($send_url_str).'返回信息：'.$result]);
			return $xmlInfo;
		}
	}
	
	/**
	 * 设置获取通话录音记接口地址
	 */
	public function setRecordUrl($url = 'http://bj.sofang.com/virtualphone/getRecord'){
		$result = self::sendUrl_getXmlInfo('PushRecordUrl', ['url'=>base64_encode($url)]);
		return $result;
	}
	/**
	 * 获取通话录音记录
	 */
	public function getRecord(){
		if(!empty(Input::get('vType', ''))){
			$recordData['vType'] = Input::get('vType', '');
			$recordData['vCaller'] = Input::get('vCaller', '');
			$recordData['vCallee'] = Input::get('vCallee', '');
			$recordData['vRecordUrl'] = Input::get('vRecordUrl', '');
			$recordData['vSessionId'] = Input::get('vSessionId', '');
			$this->VirtualphoneDao->insertInfo('mysql_user', 'virtualphone_recordlog' ,$recordData);
			$notice = 'success';
		}else{
			$notice = 'fail,Parameter is not complete!';
		}
		return $notice;
	}
	//获取账单记录，按天推送
	public function getVBills(){
		if(!empty(Input::get('vType')) && !empty(Input::get('vBillsUrl')) ){
			$vType = Input::get('vType');
			$vBillsUrl = Input::get('vBillsUrl');
				
			$vbillsData['vType'] = $vType;
			$vbillsData['vBillsUrl'] = $vBillsUrl;
			$this->VirtualphoneDao->insertInfo('mysql_user', 'virtualphone_bills', $vbillsData);
			$notice = 'success';
	
		}else{
			$notice = 'fail,Parameter is not complete!';
	
		}
		return $notice;
	}
	//获取余额记录
	public function getBalance(){
		if(!empty(Input::get('Date'))){
			$vType = Input::get('Date');
			$balanceData['Date'] = $vType;
			$this->VirtualphoneDao->insertInfo('mysql_user', 'virtualphone_balance', $balanceData);
			$notice = 'success';
		}else{
			$notice = 'fail,Parameter is not complete!';
		}
		return $notice;
	}
	/**
	 * 设置获取通话记录接口地址
	 */
	public function setBillsUrl($url = 'http://bj.sofang.com/virtualphone/getBills'){
// 		base64_encode
		$result = self::sendUrl_getXmlInfo('BILLS_URL', ['url'=>base64_encode($url)]);
		return $result;
	}
	
	/**
	 * 获取通话记录
	 */
	public function getBills(){
// 		DB::connection('mysql_user')->table('virtualphone_test')->insert(['info'=>json_encode(Input::all(), true)]);
		if(!empty(Input::get('Billtype', ''))){
		//if(!empty(Input::get('Billtype')) && !empty(Input::get('Sessionid')) && !empty(Input::get('ChargeNbr')) && !empty(Input::get('DisplayNbr')) && !empty(Input::get('CallerNbr')) && !empty(Input::get('CalledNbr')) && !empty(Input::get('StartTime')) && !empty(Input::get('EndTime'))  && !empty(Input::get('BillSubtype')) && !empty(Input::get('Duration')) && !empty(Input::get('Points')) && !empty(Input::get('Meet_AccessPhone')) && !empty(Input::get('Meet_MediaType')) && !empty(Input::get('Meet_CreatedTime')) && !empty(Input::get('Meet_ColsedTime')) && !empty(Input::get('Meet_OrganizationId')) && !empty(Input::get('Meet_BillType')) ){
			$billsData['Billtype']				=Input::get('Billtype', '');
			$billsData['Sessionid']				=Input::get('Sessionid', '');
			$billsData['ChargeNbr']				=Input::get('ChargeNbr', '') ;//虚拟号
			$billsData['DisplayNbr']			=Input::get('DisplayNbr', '');//主叫
			$billsData['CallerNbr']				=Input::get('CallerNbr', '');//虚拟小号
			$billsData['CalledNbr']				=Input::get('CalledNbr', '');//被叫
			$billsData['StartTime']				=Input::get('StartTime', '');
			$billsData['EndTime']				=Input::get('EndTime', '');
			$billsData['StarttimeCalled']		=Input::get('StarttimeCalled', '');
			$billsData['BillSubtype']			=Input::get('BillSubtype', '');//通话类型
			$billsData['Duration']				=Input::get('Duration', '');//通话时长
			$billsData['Points'] 				=Input::get('Points', '');
			$billsData['Meet_AccessPhone'] 		=Input::get('Meet_AccessPhone', '');
			$billsData['Meet_MediaType']		=Input::get('Meet_MediaType', '');
			$billsData['Meet_CreatedTime']		=Input::get('Meet_CreatedTime', '');
			$billsData['Meet_ColsedTime']		=Input::get('Meet_ColsedTime', '');
			$billsData['Meet_OrganizationId']	=Input::get('Meet_OrganizationId', '');
			$billsData['Meet_BillType'] 		=Input::get('Meet_BillType', '');
			
			/* 扣除虚拟号piont点数 */
			if(!empty($billsData['Points'])){
				$this->VirtualphoneDao->minusVirtualphonePoint($billsData['ChargeNbr'], (int)$billsData['Points']);
			}
			/* 判断是否存在通话记录，若不存在，则添加客户报备数据 */
			if($billsData['BillSubtype'] == '1201' && $billsData['Billtype'] == '1' && $billsData['Duration']>=$this->callLogDuration){
				//修改小号关系状态
				$is_update = DB::connection('mysql_user')->table('virtualphone_relation')->where('virtualMobile', $billsData['CallerNbr'])->where('customerMobile', $billsData['DisplayNbr'])->where('brokerMobile', $billsData['CalledNbr'])->update(['state'=>1]);
				if($is_update !== 0){
					//判断同一公司下是否有经纪人与该用户的通话记录
					$isset = $this->VirtualphoneDao->issetRecordLogInE($billsData['CallerNbr'], $billsData['DisplayNbr'], $billsData['CalledNbr']);
					if(isset($isset['result']) && $isset['result'] === false){
						//插入客户报备数据
// 					$this->VirtualphoneDao->insertClientReport($billsData);
						/* 添加客户待登记数据、客户意向信息数据、客户订单数据 */
						$this->VirtualphoneDao->insertClientData($billsData);
					}
				}
			}
			/* 插入记录 */
			$this->VirtualphoneDao->insertInfo('mysql_user', 'virtualphone_calllog', $billsData);
			$notice = 'success';
		}else{
			$notice = 'fail,Parameter is not complete!';
		}
		return $notice;
	}
	
	/**
	 * 取消所有当前小号下的绑定号码关系（慎用）
	 */
	public function xh_close_all(){
		$poolObj = $this->VirtualphoneDao->getVirtualphonePool();
		foreach($poolObj as $pool_key=>$pool_val){
			$resultInfo = self::sendUrl_getXmlInfo('XH_CLOSE1', ['virtualMobile'=>$pool_val->virtualMobile, 'key'=>$pool_val->key, 'customerMobile'=>'', 'brokerMobile'=>'']);
			if($resultInfo['Head']['Result'] == '-1'){
				$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'批量取消小号绑定关系失败', 'info'=>'虚拟号：'.$pool_val->virtualMobile.'；key：'.$pool_val->key.'；areacode:'.$pool_val->areaCode.'。接口返回信息：'.json_encode($resultInfo)]);
			}
		}
		return $poolObj;
	}
	/**
	 * 获取所有当前小号下的绑定关系
	 */
	public function xh_search_all(){
		$poolObj = $this->VirtualphoneDao->getVirtualphonePool();
		$resultInfo = [];
		foreach($poolObj as $pool_key=>$pool_val){
			$resultInfo[] = self::sendUrl_getXmlInfo('XH_SEARCH1', ['virtualMobile'=>$pool_val->virtualMobile, 'key'=>$pool_val->key, 'Telno1'=>'', 'Telno2'=>'']);
		}
		return $resultInfo;
	}
	
	/**
	 * 获取所有当前小号的点数使用情况，并修改本地数据库记录
	 */
	public function getImsPoint(){
		$poolObj = $this->VirtualphoneDao->getVirtualphonePool();
		foreach($poolObj as $pool_key=>$pool_val){
			$resultInfo = self::sendUrl_getXmlInfo('IMS_USE_LOG', ['virtualMobile'=>$pool_val->virtualMobile, 'key'=>$pool_val->key]);
			if($resultInfo['Head']['Result'] == 0){		//获取成功
				$this->VirtualphoneDao->updateVirtualphonePoint($pool_val->virtualMobile, $resultInfo['Body']['RemainPoint']);
			}else{//获取不成功
				$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'获取小号点数使用情况失败', 'info'=>'虚拟号：'.$pool_val->virtualMobile.'；key：'.$pool_val->key.'。接口返回信息：'.json_encode($resultInfo)]);
			}
		}
	}
	
	/**
	 * 获取所有当前小号点数使用情况，根据剩余点数分别购买点数套餐补全
	 */
	public function buyImsAll(){
		$min_point = 600;//最低点数值，地域此点数值的进行充值
		$per_point = 200;//每次充值补充点数
		$poolObj = $this->VirtualphoneDao->getVirtualphonePool();
		foreach($poolObj as $pool_key=>$pool_val){
			if($pool_val->point < $min_point){
				/* 进行充值 */
				//计算需要充值多少次
				$buy_times = 0;//充值次数
				$buy_times = ceil(($min_point - $pool_val->point) / $per_point);
// 				echo $pool_val->point." ".$buy_times."<br>";
				for( ; $buy_times>0; $buy_times--){
					$resultInfo = self::sendUrl_getXmlInfo('IMS_BUY', ['virtualMobile'=>$pool_val->virtualMobile, 'key'=>$pool_val->key]);
					if($resultInfo['Head']['Result'] != 0){		//充值失败
						$this->AlarmMessageUtil->insertAlarm(['type'=>1, 'title'=>'虚拟号充值点数失败', 'info'=>'虚拟号：'.$pool_val->virtualMobile.'；key：'.$pool_val->key.'；接口返回信息：'.json_encode($resultInfo)]);
					}
				}
			}
		}
		return true;
	}
}