<?php
/*
 * @亿美发送手机信息配置文件
 * @since 1.0
 * @author niewu
 */
return [
	/* 每条短信扣除余额0.1，字数限制每67个字符算一条
	 * 发送短信是应注意字数，避免因超出限制多算费用 */
    'sms' => [
//         'gwUrl' => 'http://sdk4report.eucp.b2m.cn:8080/sdk/SDKService', // 网关地址
		'gwUrl' => 'http://hprpt2.eucp.b2m.cn:8080/sdk/SDKService?wsdl',
//         'serialNumber' => '0SDK-EBB-6688-JGRLR', //序列号,请通过亿美销售人员获取
		'serialNumber' => '8SDK-EMY-6699-RERTQ',
//         'password' => '028364', //密码,请通过亿美销售人员获取
        'password' => '852963', //密码,请通过亿美销售人员获取
//         'sessionKey' => '028364', //登录后所持有的SESSION KEY，即可通过login方法时创建
        'sessionKey' => '852963', //登录后所持有的SESSION KEY，即可通过login方法时创建
        'connectTimeOut' => 2,   //连接超时时间，单位为秒
        'readTimeOut' => 10,    //远程信息读取超时时间，单位为秒
        'proxyhost' => false,  //可选，代理服务器地址，默认为 false ,则不使用代理服务器
        'proxyport' => false,    //可选，代理服务器端口，默认为 false
        'proxyusername' => false,  //可选，代理服务器用户名，默认为 false
        'proxypassword' => false,  //可选，代理服务器密码，默认为 false
        
    ],
];
