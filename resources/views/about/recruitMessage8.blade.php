@extends('mainlayout')
@section('title')
    <title>【搜房网招聘，招聘信息】-搜房网</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css?v={{Config::get('app.version')}}">
<div class="about">
  @include('about.publicview')
  <div class="about_r">
    <h2><span>招聘信息</span></h2>
    <p class="recruitTitle">Web前端开发工程师</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3-5年</li>
      <li>最低学历：本科</li>
      <li>招聘人数：5+</li>
      <li>职位类别：WEB前端开发</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.负责网站前端开发，与后台工程师协作，完成数据交互、动态信息展现；</p>
       <p>2.使用JS封装良好的前端交互组件，维护及优化网站前端页面性能；</p>
       <p>3.参与网站需求分析、流程设计，研讨技术实现方案；</p>
       <p>4.研究和探索创新的开发思路和前端技术。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.本科以上学历，三年以上Web前端开发经验；</p>
       <p>2.精通各种Web前端技术，包括HTML5/XHTML/ CSS3/Javascript/AJAX等；确保代码对各种浏览器的良好兼容性；</p>
       <p>3.熟练掌握Jquery开发框架，并能使用JS实现Json、XML格式的数据发送与数据解析；</p>
       <p>4.重视团队协作，熟悉各种常用工具如svn等；</p>
       <p>5.具备其他语言的开发经验，比如c#或php优先考虑；</p>
       <p>6.有iphone、ipad、android等智能手机开发经验优先；</p>
       <p>7.有百度地图API开发经验优先。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
