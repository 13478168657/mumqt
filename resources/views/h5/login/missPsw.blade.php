 @extends('h5.mainlayout')
 @section('title')
 <title>【北京房地产门户|北京房地产网|北京房地产平台】 - 北京搜房网 网罗天下房</title>
<meta name="keywords"
	content="北京房产,北京房地产,买房,北京租房,业主社区,北京新房,北京二手房,北京写字楼,北京商铺,北京豪宅,北京别墅,理财,装修,家居,建材,家具,团购,房地产业内精英,中介服务
      " />
<meta name="description"
	content="北京搜房网是中国房地产综合网络平台，提供全面实时的房地产资讯内容，为广大网民提供专业的北京新房、北京二手房、北京租房、北京豪宅、北京别墅、北京写字楼、北京商铺等全方位海量资讯信息的品质搜房体验。为业主、客户及房地产业内精英们提供高效专业的信息推广及交易服务。并且为广大客户提供了房地产行业百科大全，可轻松获得业内名人，名词，名企及楼盘的相关信息数据。" />
@endsection
@section('head')
<script src="/h5/js/common/zepto.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/app.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/Storage.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/missPass.js" type="text/javascript" charset="utf-8"></script>
<script src="/h5/js/common/fnbase.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="h5/css/missPsw.css"/>
<!--========================找回密码=========================================-->
<header class="logoin_head">
	<h2><i><a href="javascript:window.history.go(-1)"></a></i>找回密码</h2>
</header>
<div class="space24"></div>
<div class="recoverPsw">
	<form class="recoverForm">
		<p>手机号</p><input type="text" name="text" id="missPhon" maxlength="11"  placeholder="请输入手机号" class="reg_Phone"/>
		<p>验证码</p>
        <span class="reg_box">
            <input type="text" name="text" id="Num" maxlength="6" placeholder="填写验证码" class="miss_Num"/>
            <i class="get_Num" id="yzm">获取验证码</i>
		</span>
		<span class="reg_box picBox" style="display:none; margin:0;">
            <p>图片验证码</p><input type="text" name="text" id="pictureCode" class="codes" maxlength="6" placeholder="图片验证码" class="miss_Num" style="width:60%; height:60px;"/>
            <img style="width:22%; height:58px; display: inline-block;" onclick="addCode(this);" src="/vercode?id={{rand(1,9999999)}}"/>
        </span>
		<p>密码</p><input type="password" name="missPsw" id="missPsw" placeholder="密码长度在6-16之间" />
		<p>确认密码</p><input type="password" name="rpwds" id="rpwds" placeholder="请确认密码" />
	</form>
	<input type="hidden" id="token" value="{{csrf_token()}}" />
	<input type="button" name="button" id="turnBtn" value="确定" class="btn"/>
	
</div>
<!--========================找回密码=========================================-->
@endsection