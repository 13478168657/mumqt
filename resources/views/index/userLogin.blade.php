
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
	<title>搜房网普通用户登录</title>
<link rel="stylesheet" type="text/css" href="/css/personalLogin.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
<link rel="icon" href="http://www.sofang.com/favicon.ico" mce_href="http://www.sofang.com/favicon.ico" type="image/x-icon">
<script src="/js/jquery1.11.3.min.js"></script>
</head>
<body>


<header class="header1">
 <div class="head">
  <div class="logo"><a href="/"><img src="/image/broker-Logo.png"></a></div>
  <span class="dotted"></span>
  <h2>普通用户登录</h2>
 </div>
</header>
	<div class="cont_bg">
		<div class="content content1">
			<div class="login" id="login" >
			  <h3><img src="/image/sficon.png" alt="搜房网" /></h3>
			  <h2>
			    <a class="user_login click">账号密码登录</a>
			    <a class="user_login">手机快捷登录</a>
			    <div class="clear"></div>
			  </h2>
			  <div class="userLogin">
			    <input type="hidden" name="crtoken" value="{{csrf_token()}}" id="crtoken">
			    <form id="loginform" name="loginform" method="post" action="#">
			        <p class="zhao color2d margin_b">
			            <!--<a class="color_blue modaltrigger" id="zhuce" href="#register" onclick="regs()">立即注册</a>-->
			        </p>
			        <ul class="login_msg">
			            <li class="error_msg" id="lerror" style="display: none"><i></i><span>用户名或密码输入错误！</span></li>
			            <li class="error_msg" id="lerror2" style="display: none"><i></i><span>用户已被限制登录！</span></li>
			            <li style="background: #fff;">
			                <i class="name"></i>
			                <input type="text" name="lname" id="lname" class="txt" placeholder="请输入手机号">
			                <i class="answ" id="islname"></i>
			            </li>
			            <li style="background: #fff;">
			               <i class="pwd"></i>
			               <input type="password" name="lpwd" id="lpwd" maxlength="16" class="txt" placeholder="请输入密码">
			               <i class="ans" id="islpwd"></i>
			            </li>
			        </ul>
			        <p class="zhao color2d">
			            <input type="checkbox" checked="checked" id="autoLogin">&nbsp;&nbsp;下次自动登录
			            <a href="/resetpassword">找回密码</a>
			        </p>
			        <p class="noRegister margin_b"><!--<a class="color_blue" href="http://my.soufang.85cc">经纪人可从这里登录&gt;&gt;</a>--></p>
			        <input type="button" class="btn hidemodal back_color" id="login" onclick="lsubmit()" value="登录">
			    </form>
			  </div>
			  <div class="userLogin1" style="display:none;">
			    <p class="noRegister">未注册将自动创建搜房账号，并登录<!--<a class="color_blue modaltrigger" href="#register" onclick="regs(),$('#login').hide();">立即注册</a>--></p>
			    <form name="loginformPhone" method="post" action="#">
			        <ul class="login_msg">
			            <li style="background: #fff;">
			                <input type="text" name="quickLoginMobileNum" id="quickLoginMobileNum" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,''); homeLogin_checkQuickLoginMobile(this.value)" onafterpaste="this.value=this.value.replace(/\D/g,'')" class="txt margin_l" placeholder="请输入手机号">
			               	<i style="display: none;" id="anquickLoginMobileNum"></i> 
			                <span class="ti" id="error_quickLoginMobileNum"></span>
			            </li>
						<li class="phone_code" style="display:none;">
							<input type="text" class="txt width" id="code_val" value="" autocomplete="off">
							<img src="/vercode" alt="验证码" id="ver_code" onclick="this.src='/vercode?code='+Math.random();" style="height:32px;margin:5px 0 0 28px;">
							<span class="ti" id="error_code"></span>
						</li>
			            <li style="background: #fff;">
			               <input type="text" maxlength="6" class="txt margin_l code" placeholder="输入验证码" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="ryzm_quickLoginMobileNum">
			               <input type="button" class="btn width back_color" id="btn_quickLoginNum" value="获取验证码">
			               <i style="display:none;" class="btnicon" id="tishibtnicon"></i>
			               <span class="ti" id="msphonequickLoginMobileNum"></span>
			            </li>
			        </ul>
			        <p class="zhao color2d">
			            <input type="checkbox" checked="checked" id="agreeCheck" name="agree" onclick="checkBoxOnChange()">&nbsp;&nbsp;我已阅读<a href="/about/registAgreement.html" class="no_float">《搜房网服务协议》</a>
			            <span id="checkbox" style="display: none">请阅读并同意《搜房网服务协议》</span>
			        </p> 
			        <p class="noRegister margin_b"><!--<a class="color_blue" href="http://my.soufang.85cc/majorLogin">经纪人可从这里登录&gt;&gt;</a>--></p>
			        <input type="button" class="btn hidemodal back_color" id="login" onclick="homeLogin_rsubmit_quickMobile()" value="登录">
			    </form>
			  </div>
			</div>
			<input id="virtualphone_token" value="{{csrf_token()}}" type="hidden">
			<div class="shadow"></div>
		</div>
	</div>

<footer class="footer">
	<div class="bottom">
		<p>
			<a href="/about/aboutus.html">关于我们</a>
			<span class="dotted"></span>
			<a href="/about/contactus.html">联系我们</a>
			<span class="dotted"></span>
			<a href="/about/disclaimer.html">免责声明</a>
			<span class="dotted"></span>
			<a href="/about/recruit.html">招聘信息</a>
			<span class="dotted"></span>
			<a href="/about/secret.html">隐私协议</a>
			<span class="dotted"></span>
			<a href="/questionHelp/usehelp.html">使用帮助</a>
			<span class="dotted"></span>
			<a href="/ad/cooperation">加盟合作</a>
		</p>
		<p class="p2">
			<span>Copyright&nbsp;©&nbsp;2016</span>
			<span>Sofang.com,&nbsp;All&nbsp;Rights&nbsp;Reserved</span>
			<span>北京道杰士投资咨询服务有限责任公司</span>
			<span>版权所有</span>
			<span><a href="http://www.miibeian.gov.cn/state/outPortal/loginPortal.action" target="_blank">京ICP证040491号</a></span>
		</p>
	</div>
</footer>

<div class="float">亲，您的浏览器版本过低，为了更好地浏览网页，搜房网建议您更换浏览器：<a href="http://www.chromeliulanqi.com" target="_blank"><img src="/image/google.png" width="22" height="20" alt="">谷歌浏览器</a>&nbsp;或&nbsp;<a href="https://developer.apple.com/safari/" target="_blank"><img src="/image/Safari.png" width="20" height="22" alt="">苹果浏览器</a></div>
<script type="text/javascript">
window.onload = function () {
	if (!window.applicationCache) {
	   $(".float").show(); 
	   $(".an").show(); 
	   $(".an").addClass("ie_web"); 
	}
};
</script>
<script src="/js/login.js"></script>
<script src="/js/telephoneLogin.js"></script>
<script src="/js/ProUserLogin.js"></script>
<script>
$(document).ready(function(e) {
	$("#login h2 a").click(function(){
	   $("#login h2 a").removeClass("click");
	   $(this).addClass("click");
	   if($(this).text()=="账号密码登录")	{
		  $(".userLogin").show();
		  $(".userLogin1").hide(); 
	   }else{
		  $(".userLogin1").show();
		  $(".userLogin").hide();  
	   }
	});
});
</script>
<script>
        function lo() {
            $("#lerror").hide();
            $("#lname").val('');
            $('#lpwd').val('');
            $("#islname").attr("class", "answ");
            $("#islpwd").attr("class", "ans");
        }
        function regs() {
            $("#rname").val('');
            $("#anrname").attr("class", "an");
            $("#error_rname").val('');
            $("#rmobile").val('');
            $("#anmobile").attr("class", "an");
            $("#error_rmobile").val('');
            $("#ryzm").val('');
            $("#anryzm").attr("class", "an");
            $("#error_ryzm").val('');
            $("#rpwd").val('');
            $("#idpwd").attr("class", "an");
            $("#rpwds").val('');
            $("#isrpwd").attr("class", "an");
            $("#error_rpwds").html('');
        }
        //尾部置底
	var oH=document.documentElement.clientHeight;
	var header=$('.header').outerHeight();
	var cont=$('.cont_bg').outerHeight();
	var footer=$('.footer').outerHeight();
	var allH=header+cont+footer;
	if(allH<oH){
		$('.footer').css({position:'absolute',left:0,bottom:0});
	}else{
		$('.footer').css('position','static');
	}
	window.onresize=function(){
		if(allH<document.documentElement.clientHeight){
			$('.footer').css({position:'absolute',left:0,bottom:0});
		}else{
			$('.footer').css('position','static');
		}
	}
    </script>
</body>
</html>