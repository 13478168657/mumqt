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
    <h2 class="route">经纪人手册&nbsp;&nbsp;>&nbsp;&nbsp;房源发布相关</h2>
    <p class="why">如何发布出售(出租)房源？</p>
    <p class="title">若您还没有发布出售(出租)房源，详细操作步骤如下:</p>
    <p class="title color2d">1.进入经纪人管理中心页面，在左侧，点击“存量楼盘库”菜单，选择“录入出售房源”。</p>
    <div class="img"><img src="/img/5.jpg" alt="帮助"></div>
    <p class="title color2d margin">2、选择所属楼盘，如果没有相应楼盘,选择“其他”,并对应符合的物业类型、区域、设置标题，点击“开始创建”。</p>
    <div class="img"><img src="/img/6.jpg" alt="帮助"></div>
    <p class="title color2d margin">3、填写“基础信息”，“补充信息”和“上传图片”，点击“保存到待发布”。</p>
    <div class="img"><img src="/img/7.jpg" alt="帮助"></div>
    <p class="title color2d margin">4、完成真实姓名，所属分销商，身份证，工牌等信息完善并设置安全信息。</p>
    <div class="img"><img src="/img/8.jpg" alt="帮助"></div>
    <p class="title color2d margin">5、在已发布标签中进行查看，管理。</p>
    <div class="img"><img src="/img/9.jpg" alt="帮助"></div>
  </div>
</div>
@endsection
