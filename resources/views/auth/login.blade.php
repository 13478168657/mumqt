<!DOCTYPE html>
<html>
<!--－ head.jade-->
<head>
    <title>母婴头条账号</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/home.css">
    <script src="/public/jquery.min.js"></script>
</head>
<body>
<!-- nav-->
<header>
    <div class="signin pull-right">还没帐号？<a href="/register" target="_blank">立即注册</a></div>
    <div class="nav-logo"><a>母婴头条通行证</a></div>
</header>
<!-- content-->
<div class="row bg-color">
    <div class="login-box clearfix">
        <div class="pull-left left-area">
            <h1 class="slogan">一证通行&nbsp;&nbsp;,&nbsp;&nbsp;&nbsp;畅享母婴头条
                <small>同一账号登录母婴头条视频、母婴头条新闻、母婴头条博客、母婴头条焦点等母婴头条旗下产品</small>
            </h1>
            <div class="carousel">
                <div class="stages clearfix"><img src="https://sucimg.itc.cn/avatarimg/s_201314_1442559963922"/></div>
            </div>
        </div>
        <div class="pull-right login-wrap icons">
            <div class="nav-tabs"><a href="javascript:;" class="active">普通登录</a></div>
            <div class="tabs-box">
                <form id="loginform" action="" class="clearfix">
                    <section class="loginform">
                        <div class="control-group">
                            <label><a href="javascript:;" class="shortcut"><i class="img-delete">&times;</i></a><span class="ipt">
                      <input name="userid" type="text" placeholder="请输入邮箱/手机号" tabindex="1"></span></label>
                        </div>
                        <div class="control-group">
                            <label><span class="ipt">
                      <input name="password" type="password" placeholder="请输入密码" tabindex="2"></span></label>
                        </div>
                        <div class="alert-block txt-alert txt-center hide">用户名或密码错误</div>
                        <div class="assist clearfix">
                            <div class="pull-right"><a href="/forget_password/input_user" target="_blank">忘记密码</a></div>
                            <label>
                                <input name="rpwd" type="checkbox" tabindex="3"> 下次自动登录
                            </label>
                        </div>
                        <div class="btnbox clearfix">
                            <a href="javascript:;" btn-action="submit" class="btn btn-large btn-yellow pull-left" tabindex="4">登录</a>
                            <a href="/signup" class="btn btn-large btn-yellow pull-right" tabindex="5" target="_blank">注册</a>
                        </div>
                    </section>
                </form>
            </div>
            <div class="pp-other">
                <h5><span><b class="line">其它登录方式</b></span></h5>


                <div class="dropdown cboth"><a href="javascript:;"><i class="img-arrow-down"></i></a></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="info clearfix">
        <dl class="info-safe">
            <dt><i></i>安全保障</dt>
            <dd>全新的母婴头条安全体系<br/>充分尊重个人隐私<br/>保障账号安全</dd>
        </dl>
        <dl class="info-login">
            <dt><i></i>一键登录</dt>
            <dd>支持多种登录方式<br/>手机或邮箱账号+密码登录<br/>手机动态码登录</dd>
        </dl>
        <dl class="info-service">
            <dt><i></i>贴心客服</dt>
            <dd>客服邮箱：webmaster@vip.mum.com</dd>
            <dd>客服电话：010-58103760</dd>
        </dl>
    </div>
</div>
<!-- footer.jade-->
<footer>
    <div class="footer-content txt-center">
        <p><a href="http://corp.mum.com" target="_blank">关于我们</a>&nbsp;|&nbsp;<a href="#"
                                                                                 target="_blank">母婴头条首页</a>&nbsp;|&nbsp;<a
                    href="http://mail.mum.com" target="_blank">母婴头条邮箱</a>&nbsp;|&nbsp;<a href="/help" target="_blank">帮助</a>
        </p>

        <p>Copyright &copy; 2017 mum.com Inc. All Rights Reserved. 母婴头条公司 版权所有</p>
    </div>
</footer>

</body>
</html>
