<?php
namespace App\Http\Controllers\Utils;

use Illuminate\Routing\Controller;

include dirname(__FILE__).'/BOS/BaiduBce.phar';
require dirname(__FILE__).'/BOS/LogConf.php';

use BaiduBce\BceClientConfigOptions;
use BaiduBce\Util\Time;
use BaiduBce\Util\MimeTypes;
use BaiduBce\Http\HttpHeaders;
use BaiduBce\Services\Bos\BosClient;
use BaiduBce\Services\Bos\BosOptions;
use BaiduBce\Auth\SignOptions;

//调用配置文件中的参数
// global $BOS_TEST_CONFIG;
//新建BosClient
// $client = new BosClient($BOS_TEST_CONFIG);


/**
 * 上传文件基类
 * @access public
 * @author lichen(lee.lc@foxmail.com)
 * @date 2016年2月24日 上午10:37:19
 * @version 1.0
 */
class SofangFileClientBase extends Controller{
	private $client;
	private $bucket;
	private $key;
	private $filename;
	private $download;
	protected $customizedConfig; // 自定义配置
	protected $options;    		 // 每一个方法具有的可选参数
	function __construct(){
		$config = require dirname(__FILE__).'/BOS/MyConf.php';
		$this->customizedConfig = array(
			BceClientConfigOptions::PROTOCOL => $config['protocol'],										// 传输协议
			BceClientConfigOptions::REGION => $config['region'],											// 区域  bj / gz  目前支持“华北-北京” 和  “华南-广州”两个区域
			BceClientConfigOptions::CONNECTION_TIMEOUT_IN_MILLIS => $config['connection_timeout_in_millis'],// 请求超时时间（单位：毫秒）
			BceClientConfigOptions::SOCKET_TIMEOUT_IN_MILLIS => $config['socket_timeout_in_millis'], 		// 通过打开的连接传输数据的超时时间（单位：毫秒）
			BceClientConfigOptions::SEND_BUF_SIZE => $config['send_buf_size'],								// 发送缓冲区大小
			BceClientConfigOptions::RECV_BUF_SIZE => $config['recv_buf_size'],								// 接收缓冲区大小
			BceClientConfigOptions::CREDENTIALS => $config['credentials'],									// 对应控制台中的 “Access Key ID”   和  “Access Key Secret”
			'endpoint' => $config['endpoint'],																// 目前支持“华北-北京” 和  “华南-广州”两个区域
		);
		$this->client = new BosClient($this->customizedConfig);
	}
	
	/**
	 * 创建Bucket
	 * @param	string		$bucketName		Bucket名称
	 */
	private function sf_createBucket($bucketName){
		$isExists = self::sf_doesBucketExist($bucketName);
		if(!$isExists){
			return false;
		}else{
			return $this->client->createBucket($bucketName);
		}
	}
	
	/**
	 * 获取Bucket列表
	 */
	public function sf_listBuckets(){
		return $this->client->listBuckets();
	}
	
	
	/**
	 * 获取Bucket
	 * @param	string		$type		命名空间分类:
	 * 										private_img		加密图片
	 * 										house			房源图片	
	 * 										community		楼盘图片
	 * 										broker			经纪人图片
	 */
	public function sf_getBucketAcl($type){
		if(in_array($type, ['private_img', 'house', 'community', 'broker'])){
			
		}
		
		/* private_img
		house
		community
		broker */
	}
	
	/**
	 * 判断指定Bucket是否存在
	 * @param	string		$bucketName		Bucket名称
	 */
	public function sf_doesBucketExist($bucketName){
		return $this->client->doesBucketExist($bucketName);
	}
	
	/**
	 * 删除指定Bucket
	 * @param	string		$bucketName		Bucket名称
	 */
	private function sf_delBucket($bucketName){
		$isExists = self::sf_doesBucketExist($bucketName);
		if(!$isExists){
			return false;
		}else{
			return $this->client->deleteBucket($bucketName);
		}
	}
	
	/**
	 * 查看Bucket中的Object
	 */
	public function listObjects($bucketName){
		return $this->client->listObjects($bucketName);
	}
	
	/**
	 * 上传数据单元
	 */
	public function putObject($bucketName, $objectKey, $data){
		$type = 'string';
		 if($type == 'string'){
		 	return self::putObjectFromString($bucketName, $objectKey, $data);
		 }elseif($type == 'file'){
		 	return self::putObjectFromFile($bucketName, $objectKey, $data);
		 }
	}
	
	/**
	 * 从字符串上传object
	 * @param	string		$bucketName		bucket名称
	 * @param	string		$objectKey		
	 * @param	string		$string			文件转码的字符串
	 */
	public function putObjectFromString($bucketName, $objectKey, $string){
		return $this->client->putObjectFromString($bucketName, $objectKey, $string);
	}
	
	/**
	 * 从文件上传object
	 * @param	string		$bucketName		bucket名称
	 * @param	string		$objectKey		
	 * @param	string		$string			文件路径
	 */
	public function putObjectFromFile($bucketName, $objectKey, $fileName){
		try {
			return $this->client->putObjectFromFile($bucketName, $objectKey, $fileName);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * 删除Object
	 * @param	string		$bucketName		bucket名称
	 * @param	string		$objectKey
	 */
	public function deleteObject($bucketName, $objectKey){
		try {
			return $this->client->deleteObject($bucketName, $objectKey);
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * 获取加密路径
	 * @param	string		$bucket		bucket名称
	 * @param	string		$key		
	 * @return							文件路径
	 */
	public function generatePreSignedUrl($bucket, $key){
		$signOptions = [
				SignOptions::TIMESTAMP=>new \DateTime(),
				SignOptions::EXPIRATION_IN_SECONDS=>-1,
		];
// 		$d = new BosOptions;
// 		dd($d);

		$url = $this->client->generatePreSignedUrl($bucket, $key, array(BosOptions::SIGN_OPTIONS => $signOptions));
		return $url;
	}
	
	/**
	 * 拷贝Object
	 * @param string $sourceBucketName	源文件bucket名称
	 * @param string $sourceObjectKey	源文件objectkey
	 * @param string $targetBucketName	复制目标bucket名称
	 * @param string $targetObjectKey	复制目标objectkey
	 */
	public function copyObject($sourceBucketName, $sourceObjectKey, $targetBucketName, $targetObjectKey){
		return $this->client->copyObject($sourceBucketName, $sourceObjectKey, $targetBucketName, $targetObjectKey);
	}
	
	
}