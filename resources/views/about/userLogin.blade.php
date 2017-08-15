@extends('mainlayout')
@section('title')
    <title>【搜房网介绍，搜房网事迹】-搜房网</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css?v={{Config::get('app.version')}}">
<div class="about">
  @include('about.quesLeft')
  <div class="about_r">
    <h2 class="route">用户手册&nbsp;&nbsp;>&nbsp;&nbsp;注册与登录</h2>
    <p class="why">如何注册用户账号？</p>
    <p class="title">若您还没有搜房用户账号，请点击注册，详细操作步骤如下:</p>
    <p class="title color2d">1.打开搜房网首页，在右上方，点击“注册”按钮。。</p>
    <div class="img"><img src="/img/10.jpg" alt="帮助"></div>
    <p class="title color2d margin">2、输入用户名（可以是网名），真实手机号及验证码，密码等信息即可完成注册，并返回首页。</p>
    <div class="img"><img src="/img/11.jpg" alt="帮助"></div>
  </div>
</div>
@endsection
