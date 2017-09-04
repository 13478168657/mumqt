<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/8
 * Time: 19:18
 */

/**
 * 专业用户登录接口页面
 */

?>

<link rel="stylesheet" type="text/css" href="/css/index.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/personalLogin.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/brokerLogin.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">

<?php //公共的页头文件 ?>
@include('layout.navbar')

<div class="contant">
 <div class="contant_l">
   
 </div>
 <div class="contant_c"></div>
 <div class="contant_r">
   <div class="login">
      <h2 class="color2d">专业登录<a href="/majorRegister" class="color_blue">立即注册</a></h2>
      <form id="loginform" name="loginform" method="post" action="#">
      <ul class="login_msg">
          <input type="hidden" name="crtoken" value="{{csrf_token()}}" id="crtoken"/>
          <li class="error_msg" id="lpromsg" style="display:none"><i></i>用户名或密码输入错误！</li>
       <li>
         <i class="name"></i>
         <input type="text" class="txt" name="lproname" id="lproname" placeholder="请输入用户名/手机号/邮箱">
         <i class="an" id="error_lproname"></i>
       </li>
       <li>
         <i class="pwd"></i>
         <input type="password" class="txt" name="lpropwd" id="lpropwd" placeholder="请输入密码">
         <i class="an" id="error_lpropwd"></i>
       </li>
      </ul>
      <p class="zhao color2d">
          <input type="checkbox" checked="checked" >&nbsp;&nbsp;<span>下次自动登录</span>
        <a href="telPwd.htm">找回密码</a>
      </p>
      <input type="button" class="btn hidemodal back_color" value="登录"  id="login" onclick="lprosubmit()">
      </form>
      <p class="third">
       <span class="dotted"></span>
       <span class="font color8d">第三方登录</span>
       <span class="dotted"></span>
      </p>
      <div class="img">
        <dl>
          <dt><a href="#"><img src="/image/QQ.png"></a></dt>
          <dd><a href="#" class="QQ">QQ</a></dd>
        </dl>
        <dl>
          <dt><a href="#"><img src="/image/weixin.png"></a></dt>
          <dd><a href="#">微信</a></dd>
        </dl>
      </div>
    </div>
 </div>
</div>

<?php //公共的页脚文件 ?>

@include('layout.footer')

<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>
<script src="/js/index.js?v={{Config::get('app.version')}}"></script>
<script src="/js/login.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/bannerAdv.js?v={{Config::get('app.version')}}"></script>
<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/headNav.js?v={{Config::get('app.version')}}"></script>
<script src="/js/prologin.js?v={{Config::get('app.version')}}"></script>
<script>
$(document).ready(function(e) {
        $(this).keydown(function (e){
            if(e.which == "13"){
                $("#login").click();
            }
        })
    });
$('#lproname').val('');
$('#lpropwd').val('');
</script> 
