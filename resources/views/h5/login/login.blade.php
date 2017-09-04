@extends('h5.mainlayout') @section('title')
<title>【北京房地产门户|北京房地产网|北京房地产平台】 - 北京搜房网 网罗天下房</title>
<meta name="keywords" content="北京房产,北京房地产,买房,北京租房,业主社区,北京新房,北京二手房,北京写字楼,北京商铺,北京豪宅,北京别墅,理财,装修,家居,建材,家具,团购,房地产业内精英,中介服务
      " />
<meta name="description" content="北京搜房网是中国房地产综合网络平台，提供全面实时的房地产资讯内容，为广大网民提供专业的北京新房、北京二手房、北京租房、北京豪宅、北京别墅、北京写字楼、北京商铺等全方位海量资讯信息的品质搜房体验。为业主、客户及房地产业内精英们提供高效专业的信息推广及交易服务。并且为广大客户提供了房地产行业百科大全，可轻松获得业内名人，名词，名企及楼盘的相关信息数据。" /> @endsection @section('head')
<script src="/h5/js/common/zepto.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/fnbase.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/app.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/Storage.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/logoin.js" type="text/javascript" charset="utf-8"></script>
@endsection @section('content')
<link rel="stylesheet" type="text/css" href="/h5/css/logoin.css" />
<!--========================登陆页面开始======================================-->
<header class="logoin_head">
	<h2><i><a href="javascript:window.history.go(-1)"></a></i>登录</h2>
</header>
<div class="space24"></div>
<div class="tabRegist">
	<h3 class="active">用户登录</h3>
	<h3>手机登录</h3>
</div>
<div class="tabBox">
	<div class="userRegiset">
		<form class="register_form">
                    <input type="text" name="text" id="phoneUser" maxlength="25" placeholder="手机号" class="reg_Phone" />
                    <input type="password" name="password" id="pswUser" maxlength="50" placeholder="密码" class="reg_Psw" />
		</form>
		<input type="button" name="button" id="logoinBtn" value="登录" class="btn" />
	</div>
	<div class="fastRegiset">
		<form class="register_form">
			<input type="text" name="text" id="phonePhon" maxlength="11" placeholder="手机号" class="reg_Phone" />
			<span class="reg_box">
				<input type="text" name="text" id="Num" maxlength="6" placeholder="验证码" class="reg_Num"/>
				<i class="get_Num" id="yzm">获取验证码</i>
			</span>
			<span class="reg_box picCodeBox" style="display:none;">
				<input type="text" name="text" id="pictureCode" maxlength="6" placeholder="图片验证码" class="reg_Num picCode"/>
                <i class="get_Num" id="picyzm" style="border:none;"><img onclick="addCode(this);" style="width:100%;" src="/vercode?id={{rand(1,9999999)}}"/></i>
			</span>
		</form>
		<input type="hidden" id="token" value="{{csrf_token()}}" />
		<input type="button" name="button" id="phoneBtn" value="登录" class="btn" />

	</div>
	<span class="logoin_btn"><a href="/register" class="btn_lf">快速注册</a><a href="/getPass" class="btn_rg">找回密码</a></span>
</div>
@endsection