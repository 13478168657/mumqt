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
    <h2 class="route">用户手册&nbsp;&nbsp;>&nbsp;&nbsp;注册用户权限</h2>
    <p class="why">如何使用注册用户权限？</p>
    <p class="title">若您还没有注册用户权限，详细操作步骤如下:</p>
    <p class="title color2d">1.打开个人后台首页，可以完善资料和安全信息，显示登陆频率和关注楼盘及房源。</p>
    <div class="img"><img src="/img/12.jpg" alt="帮助"></div>
    <p class="title color2d margin">2、点击“我的关注”，查看关注的房源和关注的楼盘。</p>
    <div class="img"><img src="/img/13.jpg" alt="帮助"></div>
    <p class="title color2d margin">3、点击“编辑资料”，编辑自己的基本信息。</p>
    <div class="img"><img src="/img/14.jpg" alt="帮助"></div>
    <p class="title color2d margin">4、点击“账户设置”，可以修改密码，绑定的邮箱及安全问题。</p>
    <div class="img"><img src="/img/15.jpg" alt="帮助"></div>
  </div>
</div>
@endsection
