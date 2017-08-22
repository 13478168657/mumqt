
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
	<title>搜房网用户登录注册</title>
<link rel="stylesheet" type="text/css" href="/css/brokerLogin.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
<link rel="icon" href="http://www.sofang.com/favicon.ico" mce_href="http://www.sofang.com/favicon.ico" type="image/x-icon">
<script src="/js/jquery1.11.3.min.js"></script>
</head>
<body>


<header class="header1">
 <div class="head">
  <div class="logo"><a href="/"><img src="/image/broker-Logo.png"></a></div>
  <span class="dotted"></span>
  <h2>登录注册</h2>
 </div>
</header>
<div class="choise_nav">
  <div class="choice_center">
	<dl>
	  <dt>登录</dt>
	  <dd class="dd1"><a href="/userLogin.html"><i class="tb tb0"></i>普通用户登录</a></dd>
	  <dd class="dd1"><a href="{{config('hostConfig.agr_host')}}/majorLogin"><i class="tb tb1"></i>二手房经纪人登录</a></dd>
	  <dd class="dd1"><a href="{{config('hostConfig.agr_host')}}/majorLogin"><i class="tb tb2"></i>新房经纪人登录</a></dd>
	</dl>
	<dl class="margin_l">
	  <dt>注册</dt>
	  <dd class="dd2"><a href="/userRegister.html"><i class="tb tb0"></i>普通用户注册</a></dd>
	  <dd class="dd2"><a href="{{config('hostConfig.agr_host')}}/majorRegister/esf"><i class="tb tb1"></i>二手房经纪人注册</a></dd>
	  <dd class="dd2"><a href="{{config('hostConfig.agr_host')}}/majorRegister/xinf"><i class="tb tb2"></i>新房经纪人注册</a></dd>
	  {{--<dd class="dd2"><a href="{{config('hostConfig.agr_host')}}/majorLogin"><i class="tb tb3"></i>新房分销商注册</a></dd>--}}
	</dl>
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
//尾部置底
var oH=document.documentElement.clientHeight;
var header=$('.header').outerHeight();
var cont=$('.choise_nav').outerHeight();
var footer=$('.footer').outerHeight();
var allH=header+cont+footer;
if(allH<oH){
		$('.footer').css({position:'absolute',left:0,bottom:0});
	}else{
		$('.footer').css('position','static');
	}
	window.onresize=function(){
		console.log(allH,document.documentElement.clientHeight)
		if(allH<document.documentElement.clientHeight){
			$('.footer').css({position:'absolute',left:0,bottom:0});
		}else{
			$('.footer').css('position','static');
		}
	}

</script>
</body>
</html>