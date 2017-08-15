<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>经纪人店铺</title>
    <link rel="stylesheet" type="text/css" href="/css/personalLogin.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="/css/submenu.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="/css/broker.css?v={{Config::get('app.version')}}">
    <script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
</head>
<?php \App\Http\Controllers\Utils\RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME, 'city', CITY); ?>
<?php $cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->get(CITY); ?>
<?php
$countCityObject = count($cityObjectAll);

$mainCity = array();
foreach ($cityObjectAll as $val) {
    if ($val['priority'] == 2) {
        $words = substr($val['py'], 0, 1);
        $mainCity[$words][] = $val;
    }
}
foreach ($cityObjectAll as $v){
    if($v['isHot'] == 1){
        $hotCity[] = $v;
    }
}
$hot = array_chunk($hotCity, 5);
?>
<body>
<div class="header clearfix">
    <div class="head clearfix">
        <dl>
            <dt><a href="/"><img src="/image/detailLogo.png" alt="搜房网"></a></dt>
            <dd>
                <a class="city_title"><span>{{CURRENT_CITYNAME}}</span><i></i></a>
                <div class="hot_city" style="display:none;">
                    <h5>热门城市</h5>
                    <ul>
                       @foreach( $hot as $k1 => $v1)
                            <li>
                                @foreach($hot[$k1] as $v2)
                                <a href="http://{{$v2['py']}}.{{$GLOBALS['current_url']}}">{{$v2['name']}}</a>
                                @endforeach
                            </li>

                        @endforeach
                    </ul>
                </div>
            </dd>
        </dl>
        <ul class="subnav">
            <li><a href="/">首页</a></li>
            <li><a href="/esfsale/area">二手房</a></li>
            <li><a href="/esfrent/area">租房</a></li>
            @if(in_array(CURRENT_CITYPY, config('openCity')))
                <li>
                    <a class="a" href="/new/area">新房</a>
                </li>
            @endif
            <li><a href="/xzlrent/area">写字楼</a></li>
            <li><a href="/sprent/area">商铺</a></li>
            <li><a href="/bsrent/area">豪宅别墅</a></li>
            <li><a class="a" href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=1" target="_blank">理财</a></li>
            <li><a class="a" href="{{config('hostConfig.baike_host')}}/index.php?list-property">百科</a></li>
            <li>
                <a class="a" href="http://bj.sofang.com/about/download.html">移动APP</a>
            </li>
         </ul>
        @if(!Auth::check())
            <div class="top_r">
                <a class="color8d" href="/userChoose.html">登录注册</a>
                 <a href="{{config('hostConfig.agr_host')}}" style="margin-left: 40px; font-size:16px; color:#dc3022;">经纪人登录注册</a>
            </div>
        @else
            <div class="top_r">
              <div class="user">
                @if(Auth::user()->type == 1)
                    @if(Auth::user()->userName=='')
                        <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/myinfo/userSet"> <span class="username">{{substr_replace(Auth::user()->mobile,'****',3,4)}}</span><i class="icon"></i></a>
                    @else
                        <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/user/interCommunity/xinF"> <span class="username">{{Auth::user()->userName}}</span><i class="icon"></i></a>
                    @endif
                @else
                    <a  href="{{config('hostConfig.agr_host')}}/majorLogin"><?= (Auth::user()->userName == '') ? substr_replace(Auth::user()->mobile, '****', 3, 4) : Auth::user()->userName ?></a>
                @endif
                <p style="display:none;">
                    <i></i>
                    <a href="/userEntrust/Qz">委托房源</a>
                    <a href="/user/personalHouse">个人房源</a>
                    <a href="/myinfo/infoUpdate">编辑资料</a>
                </p>
                </div>
                <span class="dotted"></span> <a href="/logout"> 退出</a>
            </div>
        @endif
        </div>
    </div>
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
		$(document).ready(function(e) {
        $(".top_r .user").hover(function(){
		   $(this).addClass("click");
		   $(this).find("p").show();	
		},function(){
		   $(this).removeClass("click");
		   $(this).find("p").hide();	
		});
    });
    </script>
    <div class="login" id="login" style="display:none;">
            <span class="close"></span>
            <h2>
                <a class="user_login click">账号密码登录</a>
                <a class="user_login">手机快捷登录</a>
                <div class="clear"></div>
            </h2>
            <div class="userLogin">
                <input type="hidden" name="crtoken" value="{{csrf_token()}}" id="crtoken"/>
                <form id="loginform" name="loginform" method="post" action="#">
                    <p class="zhao color2d margin_b">
                        <a class="color_blue modaltrigger" id="zhuce" href="#register" onclick="regs()">立即注册</a>
                    </p>
                    <ul class="login_msg">
                        <li class="error_msg"  id="lerror" style="display: none"><i></i><span>用户名或密码输入错误！</span></li>
                        <li class="error_msg"  id="lerror2" style="display: none"><i></i><span>用户已被限制登录！</span></li>
                        <li>
                            <i class="name"></i>
                            <input type="text" name="lname" id="lname" class="txt" placeholder="请输入用户名/手机号/邮箱">
                            <i class="an" id="islname"></i>
                        </li>
                        <li>
                            <i class="pwd"></i>
                            <input type="password" name="lpwd" id="lpwd" maxlength="16" class="txt" placeholder="请输入密码">
                            <i class="an" id="islpwd"></i>
                        </li>
                    </ul>
                    <p class="zhao color2d">
                        <input type="checkbox" checked="checked" id="autoLogin" >&nbsp;&nbsp;下次自动登录
                        <a href="/resetpassword">找回密码</a>
                    </p>
                    <p class="noRegister margin_b"><a class="color_blue" href="http://my.soufang.85cc/majorLogin">经纪人可从这里登录>></a></p>
                    <input type="button" class="btn hidemodal back_color" id='login' onclick="lsubmit()" value="登录">
                </form>
            </div>
            <div class="userLogin1" style="display:none;">
                <p class="noRegister">未注册将自动创建搜房账号，并登录<a class="color_blue modaltrigger" href="#register" onclick="regs(),$('#login').hide();">立即注册</a></p>
                <form name="loginformPhone" method="post" action="#">
                    <ul class="login_msg">
                        <li>
                            <input type="text" name="quickLoginMobileNum" id='quickLoginMobileNum' maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,''); homeLogin_checkQuickLoginMobile(this.value)"
                                   onafterpaste="this.value=this.value.replace(/\D/g,'')" class="txt margin_l" placeholder="请输入手机号">
                            <i style="display: none;"id="anquickLoginMobileNum"></i>
                            <span class="ti" id="error_quickLoginMobileNum"></span>
                        </li>
                        <li>
                            <input type="text" maxlength="6" class="txt margin_l code"  placeholder="输入验证码" onafterpaste="this.value=this.value.replace(/\D/g,'')" onkeyup="this.value=this.value.replace(/\D/g,'')" id="ryzm_quickLoginMobileNum">
                            <input type="button" class="btn width back_color" id="btn_quickLoginNum"  value="获取验证码" >
                            <i style="display:none;" class="btnicon" id="tishibtnicon"></i>
                            <span class="ti" id="msphonequickLoginMobileNum"></span>
                        </li>
                    </ul>
                    <p class="zhao color2d">
                        <input type="checkbox" checked="checked"  id="agreeCheck" name="agree" onclick="checkBoxOnChange()">&nbsp;&nbsp;我已阅读<a href="/about/registAgreement.html" class="no_float">《搜房网服务协议》</a>
                        <span id="checkbox" style="display: none">请阅读并同意《搜房网服务协议》</span>
                    </p>
                    <p class="noRegister margin_b"><a class="color_blue" href="http://my.soufang.85cc/majorLogin">经纪人可从这里登录>></a></p>
                    <input type="button" class="btn hidemodal back_color" id='login' onclick="homeLogin_rsubmit_quickMobile()" value="登录">
                </form>
            </div>
        </div>
    <div class="register" id="register" style=" display:none; position:fixed !important;">
        <span class="close"></span>
        <div class="register_l"><img src="/image/4.jpg" alt=""></div>
        <div class="register_c"></div>
        <div class="register_r">
            <h2>用户注册<a class="color_blue modaltrigger" href="#login">立即登录</a></h2>
            <form id="loginform1" name="loginform1" method="post" action="#">
                <ul class="login_msg">
                    <li>
                        <label>用户名</label>
                        <input type="text" name="rname"  id='rname' class="txt" onblur="checkname()" placeholder="输入6-21位，字母、数字、下划线的组合">
                        <i class="an" id="anrname"></i>
                        <span class="ti" id="error_rname"></span>
                    </li>
                    <li>
                        <label>手机号</label>
                        <input type="text" name="rmobile" id="rmobile" maxlength="11"  onkeyup="this.value=this.value.replace(/\D/g,'');upmobile()" onafterpaste="this.value=this.value.replace(/\D/g,'')"  class="txt" placeholder="请输入手机号">
                        <i class="an" id="anmobile"></i>
                        <span class="ti" id='error_rmobile'></span>
                    </li>
                    <li>
                        <label>验证码</label>
                        <input type="text" name="ryzm" id="ryzm" class="txt width" maxlength="6" onkeyup="this.value=this.value.replace(/\D/g,'');chcekymd()" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请输入验证码">
                        <input type="button" id=btn class="btn1 back_color" value="发送验证码" onclick="settime(this)">
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
                    <input type="checkbox" id="checkbox1" checked="checked" >&nbsp;&nbsp;<span>我已阅读<a href="/about/registAgreement.html">搜房网服务协议</a></span>
                    <span id="error_checkbox" class="ti"></span>
                </p>
                <input type="button" class="btn hidemodal back_color" onclick="rsubmit()" value="立即注册">
            </form>
        </div>
        <a class="returnPhone">返回</a>
    </div>
    <input type="hidden" id="virtualphone_token" value="{{csrf_token()}}">
<script src='/js/telephoneLogin.js'></script>
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
<script src="/js/housecompare.js?v=1.1.9.1"></script>
<script src="/js/point_interest.js?v=1.1.9.1"></script>
<script type="text/javascript" src="/js/ProUserLogin.js?v=1.1.9.1"></script>
<script src="/js/virtualphone.js?v=1.1.9.1"></script>
    @yield('content')
@include('broker.footer')
</body>
</html>

