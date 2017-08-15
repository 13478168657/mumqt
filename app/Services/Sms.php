<?php

namespace App\Services;

use App\Http\Controllers\Utils\CurlUtil;
use Client;
use Crypt;

/*
 * 发送手机短信息
 * @since 1.0
 * @author   niewu
 */
class Sms
{
    protected $client;

    public function __construct()
    {
        $config = config('sendconfig.sms');
        $gwUrl = array_get($config, 'gwUrl');
        $serialNumber = array_get($config, 'serialNumber');
        $password = array_get($config, 'password');
        $sessionKey = array_get($config, 'sessionKey');
        $connectTimeOut = array_get($config, 'connectTimeOut');
        $readTimeOut = array_get($config, 'readTimeOut');
        $proxyhost = array_get($config, 'proxyhost');
        $proxyport = array_get($config, 'proxyport');
        $proxyusername = array_get($config, 'proxyusername');
        $proxypassword = array_get($config, 'proxypassword');
        $client = new Client($gwUrl,$serialNumber,$password,$sessionKey,$proxyhost,$proxyport,$proxyusername,$proxypassword,$connectTimeOut,$readTimeOut);
        $this->client = $client;
    }

    /*
     * 
     *  发送手机验证码退出
     */
    
    function logout(){
	
	$statusCode = $this->client->logout();
        
	echo "处理状态码:".$statusCode;
    }
    
    /*
     * 
     *  发送手机验证码登录
     */
    function login(){
	
	/**
	 * 下面的操作是产生随机6位数 session key
	 * 注意: 如果要更换新的session key，则必须要求先成功执行 logout(注销操作)后才能更换
	 * 我们建议 sesson key不用常变
	 */
	//$sessionKey = $client->generateKey();
	//$statusCode = $client->login($sessionKey);

	$statusCode = $this->client->login();

	echo "处理状态码:".$statusCode."<br/>";
	if ($statusCode!=null && $statusCode=="0")
	{
		//登录成功，并且做保存 $sessionKey 的操作，用于以后相关操作的使用
		echo "登录成功, session key:".  $this->client->getSessionKey()."<br/>";
	}else{
		//登录失败处理
		echo "登录失败,返回:".$statusCode;
	}

}
    
    
    /*
     * 发送手机短信息
     * @since 1.0
     * @author   niewu
     */
    public function sendMsg($tels, $msg)
    {
        ////发送平台：\r\n type=1.搜房csr\r\n type=2.搜房agr\r\n type=3.搜房mgr\r\n type=4.搜房dt\r\n type= 5.搜房99\r\n type=6.空否\r\n type=7爱此刻';
        $params= 'mobile='.json_encode($tels).'&type=1&content='.$msg;
        $curlObj = new CurlUtil();
        $data = $curlObj->MakeCurlFunction(config('smsApiUrl.apiUrl'),'POST',$params);
        $dataObj = json_decode($data);
        /*记录短信发送信息finish*/
        return $dataObj->status;
    }

    /**
     * 获取余额
     * @return float|int
     * @author   niewu
     */
    public function getBalace()
    {
        $balance = $this->client->getBalance();

        return '余额:'.$balance?$balance:0;
    }
    
    /*
    * [密码]长度为6
    *
    * 如下面的例子是将密码修改成: 654321
    */
    
    function updatePassword(){

	$statusCode = $this->client->updatePassword('852963');
	
        echo "处理状态码:".$statusCode;
    }
    
}
