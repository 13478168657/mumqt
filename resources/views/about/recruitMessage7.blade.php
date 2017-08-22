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
    <p class="recruitTitle">产品经理</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3-5年</li>
      <li>最低学历：不限</li>
      <li>招聘人数：5+</li>
      <li>职位类别：互联网产品经理/主管</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.根据公司网站和APP产品的用户体验反馈，引导进行界面视觉优化，完成产品创新；</p>
       <p>2.基于用户行为研究、进行竞品研究和数据分析，持续改进产品用户体验度</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.有4-5年以上IT互联网行业主要产品负责人工作经验</p>
       <p>2.有2年以上的移动互联网或互联网产品团队管理经验</p>
       <p>3.有2年以上的较复杂软件及互联网服务的项目管理协调经验</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
