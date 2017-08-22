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
    <h2 class="route">用户手册&nbsp;&nbsp;>&nbsp;&nbsp;如何使用购房工具</h2>
    <p class="why">如何使用购房工具？</p>
    <p class="title">如何使用购房工具，详细操作步骤如下:</p>
    <p class="title color2d">1.打开搜房首页，在顶部导航栏“二手房”，查房价。</p>
    <div class="img"><img src="/img/24.jpg" alt="帮助"></div>
    <p class="title color2d margin">2、进入查房价首页，点击楼盘名称进入楼盘详情页。</p>
    <div class="img"><img src="/img/25.jpg" alt="帮助"></div>
    <p class="title color2d margin">3、进入楼盘详情页，展示各个物业类型房源价格走势。</p>
    <div class="img"><img src="/img/26.jpg" alt="帮助"></div>
    <p class="title color2d margin">4、打开搜房首页，在顶部导航栏“二手房”，房贷计算器。</p>
    <div class="img"><img src="/img/27.jpg" alt="帮助"></div>
    <p class="title color2d margin">5、进入房贷计算器页面。</p>
    <div class="img"><img src="/img/28.jpg" alt="帮助"></div>
    <p class="title color2d margin">6、打开搜房首页，在顶部导航栏“二手房”，查询经纪人。</p>
    <div class="img"><img src="/img/29.jpg" alt="帮助"></div>
    <p class="title color2d margin">7、进入经纪人列表页。</p>
    <div class="img"><img src="/img/30.jpg" alt="帮助"></div>
    <!--<p class="title color2d margin">8、打开搜房首页，顶部导航栏“买房”，开盘日历。</p>
    <div class="img"><img src="/img/31.jpg" alt="帮助"></div>
    <p class="title color2d margin">9、进入开盘日历页面，展示本月开盘楼盘的时间。</p>
    <div class="img"><img src="/img/32.jpg" alt="帮助"></div>
    <p class="title color2d margin">10、打开搜房首页，顶部导航栏“百科”，百科分为两大类，“房产百科”和“百科工具箱”。</p>
    <div class="img"><img src="/img/33.jpg" alt="帮助"></div>-->
  </div>
</div>
@endsection
