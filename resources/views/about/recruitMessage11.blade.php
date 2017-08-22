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
    <p class="recruitTitle">运维工程师</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3年以上</li>
      <li>最低学历：本科</li>
      <li>招聘人数：1人</li>
      <li>职位类别：计算机软件</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.负责相关系统进行日常监控、维护、升级、安全优化，保证其稳定与高效运行；</p>
       <p>2.负责监系统故障的应急响应和问题处理；</p>
       <p>3.经过培训后，能够对为客户解答系统的常见使用问题；</p>
       <p>4.配合其他系统进行功能的调试及简单网络故障分析。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.专科及以上学历，一年以上系统管理（网站、运营支撑系统、系统集成）工作经验；</p>
       <p>2.了解JavaEE应用，知道其结构，了解如何部署及诊断常见问题；</p>
       <p>3.了解Ajax、DIV+CSS、html、javascript等相关Web开发技术、了解APP开发技术；</p>
       <p>4.了解Linux和Solaris，能够使用常见的命令。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
