<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/2/21
 * Time: 21:56
 */

  //找回密码 页面
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>手机找回</title>
    <link rel="stylesheet" type="text/css" href="/css/personalLogin.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
</head>

<body>
<header class="pwd_head">
    <div class="top_pwd">
        <div class="logo"><a href="/a"><img src="/image/big_logo.jpg"></a></div>
        <div class="dotted"></div>
        <h2>找回密码</h2>
        <ul class="nav">
            <li><a href="/">返回首页</a></li>
            <li><a href="/">登录</a></li>
            <li class="dotted"></li>
            <li><a href="/">注册</a></li>
        </ul>
    </div>
</header>
<div class="pwd_main">
    <p class="nav_type">
        <a class="click">手机找回</a>
        <a>邮箱找回</a>
        <a>问题找回</a>
        <a style=" width:280px; padding:0;"></a>
    </p>
    <div class="type_msg">
        <form>
            <ul class="tel">
                <li>
                    <label>手机号</label>
                    <input type="text" class="txt">
                    <i class="answer"></i>
                </li>
                <li>
                    <label>验证码</label>
                    <input type="text" class="txt width">
                    <i class="answer click"></i>
                    <input type="button" class="btn1 back_color" value="发送验证码">
                </li>
                <li><input class="btn back_color" type="button" value="提交"></li>
            </ul>
        </form>
        <form class="meail" style="display:none;">
            <ul>
                <li>
                    <label style=" width:60px;">邮箱</label>
                    <input type="text" class="txt">
                </li>
                <li><input class="btn border_blue back_color" type="button" value="提交"></li>
            </ul>
        </form>
        <form class="problem"  style="display:none;">
            <ul>
                <li>
                    <label>问题</label>
                    <span class="tishi">您最喜欢的颜色？</span>
                </li>
                <li>
                    <label>回答</label>
                    <input type="text" class="txt">
                    <i class="answer"></i>
                </li>
                <li><input class="btn back_color" type="button" value="下一步" onClick="$(this).parents('ul').next().show();$(this).parents('ul').hide();"></li>
            </ul>
            <ul style="display:none;">
                <li>
                    <label>问题</label>
                    <span class="tishi">您的兴趣爱好？</span>
                </li>
                <li>
                    <label>回答</label>
                    <input type="text" class="txt">
                    <i class="answer"></i>
                </li>
                <li><input class="btn back_color" type="button" value="提交"></li>
            </ul>
        </form>
    </div>
</div>
<script src="/js/footer.js?v={{Config::get('app.version')}}"></script>
<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script>
    $(document).ready(function() {
        $(".nav_type a").click(function(){
            $(".nav_type a").removeClass("click");
            $(this).addClass("click");
            if($(this).text()=="手机找回"){
                $(".type_msg .tel").show();
                $(".type_msg .meail").hide();
                $(".type_msg .problem").hide();
            }else if($(this).text()=="邮箱找回"){
                $(".type_msg .meail").show();
                $(".type_msg .tel").hide();
                $(".type_msg .problem").hide();
            }
            else if($(this).text()=="问题找回"){
                $(".type_msg .problem").show();
                $(".type_msg .tel").hide();
                $(".type_msg .meail").hide();
            }
        });
    });
</script>
</body>
</html>

