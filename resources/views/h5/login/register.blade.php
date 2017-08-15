@extends('h5.mainlayout') @section('title')
<title>【北京房地产门户|北京房地产网|北京房地产平台】 - 北京搜房网 网罗天下房</title>
<meta name="keywords" content="北京房产,北京房地产,买房,北京租房,业主社区,北京新房,北京二手房,北京写字楼,北京商铺,北京豪宅,北京别墅,理财,装修,家居,建材,家具,团购,房地产业内精英,中介服务
      " />
<meta name="description" content="北京搜房网是中国房地产综合网络平台，提供全面实时的房地产资讯内容，为广大网民提供专业的北京新房、北京二手房、北京租房、北京豪宅、北京别墅、北京写字楼、北京商铺等全方位海量资讯信息的品质搜房体验。为业主、客户及房地产业内精英们提供高效专业的信息推广及交易服务。并且为广大客户提供了房地产行业百科大全，可轻松获得业内名人，名词，名企及楼盘的相关信息数据。" /> @endsection @section('head')
<script src="/h5/js/common/zepto.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/register.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/fnbase.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/app.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/Storage.js" type="text/javascript" charset="utf-8"></script>
@endsection {{--此处是当前页面内容部分--}} @section('content')
<link rel="stylesheet" type="text/css" href="/h5/css/register.css" />
<!--========================注册开始=========================================-->
<header class="logoin_head">
	<h2><i><a href="javascript:window.history.go(-1)"></a></i>注册</h2>
</header>
<div class="space24"></div>
<form class="logo_form">
	<p>手机号:</p><input type="text" name="text" id="mobile" placeholder="请输入手机号" />
	<span class="reg_box">
                <p>验证码:</p><input type="text" name="text" id="reCode" class="codes" maxlength="6" placeholder="请输入验证码" class="reg_Num"/>
                <i class="get_Num" id="yzm">获取验证码</i>
        </span>
	<span class="codebox" style="display:none; position:relative;">
        <p>图片验证码:</p><input type="text" name="text" id="pictureCode" class="codes" maxlength="6" placeholder="图片验证码" class="reg_Num"/>
        <i class="get_Num" id="picCode" style="width:22%; position:absolute; right:6px; top:20px;"><img style="width:100%;" onclick="addCode(this);" src="/vercode?id={{rand(1,9999999)}}"/></i>
	</span>
	<p>密码:</p><input type="password" name="password " maxlength="16" id="password" placeholder="请输入密码" />
	<p>确认密码:</p><input type="password" name="password " maxlength="16" id="confirmPassword" placeholder="请确认密码" />
</form>
<input type="hidden" id="token" value="{{csrf_token()}}" />
<button type="submit" class="btn" id="registBtn">注册</button>
<p class="protocol">点击"注册"按钮，即表示同意
	<a href="userAgreement/agreement.html">《搜房服务协议》</a>
</p>

<!--========================注册开始=========================================-->

<div class="regUserName" <span id="errorName">请输入用户名</div>
@endsection