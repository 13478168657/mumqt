<?php
// 设置BosClient的Access Key ID、Secret Access Key和ENDPOINT
return array (
		'protocol' => 'http', // 传输协议
		'region' => 'bj', // 区域 bj / gz 目前支持“华北-北京” 和 “华南-广州”两个区域
		'connection_timeout_in_millis' => 120 * 1000, // 请求超时时间（单位：毫秒）
		'socket_timeout_in_millis' => 300 * 1000, // 通过打开的连接传输数据的超时时间（单位：毫秒）
		'send_buf_size' => 5 * 1024 * 1024, // 发送缓冲区大小
		'recv_buf_size' => 5 * 1024 * 1024, // 接收缓冲区大小
		
		'credentials' => array (
			'ak' => '4b8d657cf37040478ec992221ee0f91d', // AK 对应控制台中的 “Access Key ID”
			'sk' => 'e8a2f0c8eba741538fa462289e5d5a54' 	// SK 对应控制台中的 “Access Key Secret”
		) 
,
		'endpoint' => 'http://bj.bcebos.com' // 目前支持“华北-北京” 和 “华南-广州”两个区域 
) 
;  
