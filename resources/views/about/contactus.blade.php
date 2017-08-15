@extends('mainlayout')
@section('title')
    <title>【搜房网联系方式，搜房地址】-搜房网</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css?v={{Config::get('app.version')}}">
<div class="about">
  @include('about.publicview')
  <div class="about_r">
    <h2><span>联系我们</span></h2>
    <div class="contact">
      <p class="p1">总部： 北京朝阳区东三环北路甲2号京信大厦13层</p>
      <p class="p1">邮编： 100027</p>
      <p class="p1">客服专线：400-6090-798( 9:00至18:00 ) </p>
      <p class="p1">招商专线：15907387772( 9:00至18:00 )</p>
      @if(!empty($agentMobile['target']) || !empty($agentMobile['national']))
      <p class="p1">广告招商专线：</p>
        <div style="margin-left:75px;">
          @if(!empty($agentMobile['target']))
            <p>{{$cityName}}：{{$agentMobile['target']}}</p>
          @else
            <p>全国热线：{{$agentMobile['national']}}</p>
          @endif
        </div>
      @endif
      <p class="p1">微信：soufang_com <br><img src="/image/bussines.jpg" alt="搜房网加盟合作微信" style="margin-left: 36px;"/></p>
      <p class="p1">客服E-mail： webmaster@sofang.com</p>
    </div>
    <p class="p2"><img src="/image/about_our4.jpg"  alt="搜房地址"></p>
  </div>
</div>
@endsection