
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
	<title>搜房网普通用户注册</title>
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
  <h2>普通用户注册</h2>
 </div>
</header>
<div class="cont_bg cont_bg_reg">
	<div class="content content1">
		<div class="register" id="register" >
		    <div class="register_r">
		        <h2>用户注册<!--<a class="color_blue modaltrigger" href="#login">立即登录</a>--></h2>
		        <form id="loginform1" name="loginform1" method="post" action="#">
		            <ul class="login_msg">
		                <!--<li>
		                    <label>用户名</label>
		                    <input type="text" name="rname" id="rname" class="txt" onblur="checkname()" placeholder="输入6-21位，字母、数字、下划线的组合">
		                    <i class="an" id="anrname"></i>
		                    <span class="ti" id="error_rname"></span>
		                </li>-->
		                <li>
		                    <label>手机号</label>
		                    <input type="text" name="rmobile" id="rmobile" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'');upmobile()" onafterpaste="this.value=this.value.replace(/\D/g,'')" class="txt" placeholder="请输入手机号">
		                    <i class="an" id="anmobile"></i>
		                     <span class="ti" id="error_rmobile"></span>
		                </li>
		                <li style="display: none;">
		                    <label>&nbsp;</label>
		                    <input type="text" class="txt width" id="code_val" value="" autocomplete="off">
		                    <img src="/vercode" alt="验证码" id="ver_code" onclick="this.src='/vercode?code='+Math.random();" style="height:32px;margin:5px 0 0 28px;">
		                    <span class="ti" id="error_code"></span>
		                </li>
		                <li>
		                    <label>验证码</label>
		                    <input type="text" name="ryzm" id="ryzm" class="txt width" maxlength="6" onkeyup="this.value=this.value.replace(/\D/g,'');chcekymd()" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请输入验证码">
		                    <input type="button" id="btn" class="btn1 back_color" value="发送验证码" onclick="settime(this)">
		                    <i class="an" id="anryzm"></i>
		                    <span class="ti" id="error_ryzm"></span>
		                </li>
		                <li>
		                    <label>密码</label>
		                    <input type="password" name="rpwd" id="rpwd" class="txt" maxlength="16" placeholder="密码限制在6-16位">
		                    <i class="an" id="idpwd"></i>
		                    <span class="ti" id="error_rpwd"></span>
		                </li>
		                <li>
		                    <label>确认密码</label>
		                    <input type="password" name="rpwds" id="rpwds" maxlength="16" class="txt" placeholder="请确认密码">
		                    <i class="an" id="isrpwd"></i>
		                    <span class="ti" id="error_rpwds"></span>
		                </li>
		            </ul>
		            <p class="zhao">
		                <input type="checkbox" id="checkbox1" checked="checked" style="margin-top: 2px;">&nbsp;&nbsp;<span>我已阅读<a href="/about/registAgreement.html">《搜房网服务协议》</a></span>
		                <span id="error_checkbox" class="ti"></span>
		            </p>
		            <input type="button" class="btn hidemodal back_color" onclick="rsubmit()" value="立即注册">
		        </form>
		    </div>
		   <a class="returnPhone">返回</a>
		</div>
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

<div class="float">亲，您的浏览器版本过低，为了更好地浏览网页，搜房网建议您更换浏览器：<a href="http://www.chromeliulanqi.com" target="_blank"><img src="../../image/google.png" width="22" height="20" alt="">谷歌浏览器</a>&nbsp;或&nbsp;<a href="https://developer.apple.com/safari/" target="_blank"><img src="../../image/Safari.png" width="20" height="22" alt="">苹果浏览器</a></div>
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