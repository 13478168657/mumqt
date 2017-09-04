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
    <p class="recruitTitle">PHP工程师</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：不限</li>
      <li>最低学历：不限</li>
      <li>招聘人数：20+</li>
      <li>职位类别：高级软件工程师</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.掌握PHP，了解OOP、框架、模板等开发技术； </p>
       <p>2.熟悉MYSQL及常用优化方案，有一定的数据库规划,调优能力；</p>
       <p>3.熟悉Javascript、jquery，熟悉ajax技术，熟悉div+css等网页前端技术。了解浏览器兼容性问题；</p>
       <p>4.良好的执行能力，较好的完成预定任务，良好的学习能力和独立解决问题的能力；</p>
       <p>5.逻辑思维能力强，做事有条理性，有较强的分析问题和解决问题的能力；</p>
       <p>6.对软件开发工作有富有热情，责任心强，良好的沟通能力与团队合作精神；</p>
       <p>7.至少1年工作经验</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
