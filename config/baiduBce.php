<?php
return [
		'bucketName'=>[//busket名称，pic1公用数据；pic2私密数据；attachments私密数据（附件）
				'building'=>'pic1',//楼栋图片（底图）
				'room'=>'pic1',//户型图
				'commPhoto'=>'pic1',//楼盘图片
				'houseSale'=>'pic1',//房源出售图片
				'houseRent'=>'pic1',//房源出租图片
				'userPhoto'=>'pic1',//用户头像
				'userIdCard'=>'pic2',//用户身份证图片
				'userJobCard'=>'pic2',//用户工牌照片
				'userNameCard'=>'pic2',//用户名片照片
				'userNVQCard'=>'pic2',//用户职业资格认证照片
				'businessLicense'=>'pic2',//公司营业执照照片
				'contract'=>'attachments',//分销商合同
				'ad'=>'pic1',//广告图片
				'clienteleReport'=>'pic1',//客户报备图片
		],
		'objectUrl'=>[//object路径
				'building'=>'/community/building',
				'room'=>'/community/room',
				'commPhoto'=>'/community/photo',
				'houseSale'=>'/house/sale',
				'houseRent'=>'/house/rent',
				'userPhoto'=>'/user/photo',
				'userIdCard'=>'/user/idcard',
				'userJobCard'=>'/user/jobcard',
				'userNameCard'=>'/user/namecard',
				'userNVQCard'=>'/user/nvqcard',
				'businessLicense'=>'/company/bLicense',
				'contract'=>'/company/attachments',
				'ad'=>'/ad',
				'clienteleReport'=>'/clienteleReport'
		],
		'defaultPicSize'=>[//默认图片最大长宽比
				'maxWidth'=>1200,	
				'maxHeight'=>900,
		],
		'picSize'=>[//各种类图片长宽比及对应编号
				'building'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
				],
				'room'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'4'=>[
								'maxWidth'=>640,
								'maxHeight'=>400,
						],
						'2'=>[
								'maxWidth'=>224,
								'maxHeight'=>140,
						],
				],
				'commPhoto'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'5'=>[
								'maxWidth'=>665,
								'maxHeight'=>416,
						],
						'3'=>[
								'maxWidth'=>384,
								'maxHeight'=>240,
						],
						'2'=>[
								'maxWidth'=>224,
								'maxHeight'=>140,
						],
						'1'=>[
								'maxWidth'=>160,
								'maxHeight'=>100,
						],
				],
				'houseSale'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'5'=>[
								'maxWidth'=>600,
								'maxHeight'=>450,
						],
//						'3'=>[
//								'maxWidth'=>384,
//								'maxHeight'=>240,
//						],
						'2'=>[
								'maxWidth'=>200,
								'maxHeight'=>150,
						],
//						'1'=>[
//								'maxWidth'=>160,
//								'maxHeight'=>100,
//						],
				],
				'houseRent'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'5'=>[
								'maxWidth'=>600,
								'maxHeight'=>450,
						],
//						'3'=>[
//								'maxWidth'=>384,
//								'maxHeight'=>240,
//						],
						'2'=>[
								'maxWidth'=>200,
								'maxHeight'=>150,
						],
//						'1'=>[
//								'maxWidth'=>160,
//								'maxHeight'=>100,
//						],
				],
				'userPhoto'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'6'=>[
								'maxWidth'=>120,
								'maxHeight'=>160,
						],
						'7'=>[
								'maxWidth'=>90,
								'maxHeight'=>120,
						],
						'8'=>[
								'maxWidth'=>56,
								'maxHeight'=>75,
						],
				],
				'userIdCard'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'1'=>[
								'maxWidth'=>160,
								'maxHeight'=>100,
						]
				],
				'userJobCard'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'1'=>[
								'maxWidth'=>160,
								'maxHeight'=>100,
						]
				],
				'userNameCard'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'1'=>[
								'maxWidth'=>160,
								'maxHeight'=>100,
						]
				],
				'userNVQCard'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'1'=>[
								'maxWidth'=>160,
								'maxHeight'=>100,
						]
				],
				'businessLicense'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
						'1'=>[
								'maxWidth'=>160,
								'maxHeight'=>100,
						]
				],
				'contract'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						]
				],
				'ad'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						]
				],
				'clienteleReport'=>[
						'0'=>[
								'maxWidth'=>'',
								'maxHeight'=>'',
						],
				],
		],
// 		'tempFilePath'=>'/www/sofang20agr_2016/resources/tempFile/',	//临时文件存放路径
		'otherSizePath'=>'/otherSize',		//其他尺寸图片存放路径
		'tempFilePath'=>$_SERVER['DOCUMENT_ROOT'].'/upload/',			//临时文件存放路径
		'rootPath'=>'/img/sofang',					//本地存储地址所在根目录
		'host'=>'bj.bcebos.com'				//百度对象存储域名
];