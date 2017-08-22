<?php

return array(
	'enableBaiduBce'=>false,						//是否使用百度云存储图片：true.是 false.否
	'enableFastdfs'=>false,						//是否启用分布式上传图片：true.是  false.否
// 	'imgSavePath'=>'/image/sofang',
	'imgSavePath'=>'http://192.168.1.85:8082',
	'hostImg'=>['rent'=>'http://img.sf.87',
		'sale'=>'http://img.sf.87',
		'photo'=>'http://img.sf.87',
		'community'=>'http://img.sf.87',
		'card'=>'http://img.sf.87',
		'other'=>'http://img.sf.87',
		'group' => 'http://image.sf.87'			//分布式上传图片服务器域名
	]
	
);
