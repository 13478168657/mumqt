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
    <h2 class="route">用户手册&nbsp;&nbsp;>&nbsp;&nbsp;通过小区查找二手房源</h2>
    <p class="why">如何通过小区查找二手房源？</p>
    <p class="title">通过小区查找二手房源，详细操作步骤如下:</p>
    <p class="title color2d">1.在搜房首页，在顶部导航栏“二手房”，找小区。</p>
    <div class="img"><img src="/img/19.jpg" alt="帮助"></div>
    <p class="title color2d margin">2、进入小区列表页。</p>
    <div class="img"><img src="/img/20.jpg" alt="帮助"></div>
    <p class="title color2d margin">3、点击小区名称，进入小区详情页。</p>
    <div class="img"><img src="/img/21.jpg" alt="帮助"></div>
    <p class="title color2d margin">4、点击“二手房”，进入展示二手房房源页。</p>
    <div class="img"><img src="/img/22.jpg" alt="帮助"></div>
    <p class="title color2d margin">5、展示二手房房源页。</p>
    <div class="img"><img src="/img/23.jpg" alt="帮助"></div>
  </div>
</div>
@endsection
