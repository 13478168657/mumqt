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
    <p class="recruitTitle">测试工程师</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：1-3年</li>
      <li>最低学历：大专</li>
      <li>招聘人数：3+</li>
      <li>职位类别：互联网软件工程师</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.编写测试计划、规划详细的测试方案、编写测试用例。</p>
       <p>2.根据测试计划搭建和维护测试环境。</p>
       <p>3.执行功能测试和性能工作，提交测试报告。包括编写用于测试的自动测试脚本，完整地记录测试结果，编写完整的测试报告等相关的技术文档。</p>
       <p>4.对测试中发现的问题进行详细分析和准确定位，与开发人员讨论缺陷解决方案。</p>
       <p>5.提出对产品的进一步改进的建议，并评估改进方案是否合理；对测试结果进行总结与统计分析，对测试进行跟踪，并提出反馈意见。</p>
       <p>6.完成上级领导安排的其它临时性工作</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
