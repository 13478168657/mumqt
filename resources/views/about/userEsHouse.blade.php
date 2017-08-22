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
    <h2 class="route">用户手册&nbsp;&nbsp;>&nbsp;&nbsp;查找二手房源</h2>
    <p class="why">如何查找查找二手房源？</p>
    <p class="title">查找二手房源，详细操作步骤如下:</p>
    <p class="title color2d">1.在搜房首页，从顶部导航栏查到对应标签，也可以在搜索框搜索房源或楼盘。</p>
    <div class="img"><img src="/img/16.jpg" alt="帮助"></div>
    <p class="title color2d margin">2、进入房源列表页。</p>
    <div class="img"><img src="/img/17.jpg" alt="帮助"></div>
    <p class="title color2d margin">3、点击房源标题，进入详情页， 点击“获取联系电话”， 与经纪人联系。</p>
    <div class="img"><img src="/img/18.jpg" alt="帮助"></div>
  </div>
</div>
@endsection
