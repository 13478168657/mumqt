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
    <p class="recruitTitle">文案/策划</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：2年以上</li>
      <li>最低学历：大专</li>
      <li>招聘人数：3人</li>
      <li>职位类别：文案/策划</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.负责各类稿件及方案的撰写；</p>
       <p>2.负责品牌相关新闻稿、评论稿、媒体、深度稿撰写；</p>
       <p>3.各种新闻稿件、论坛、微博稿件、文案的撰写；</p>
       <p>4.负责公司客户微信、微博的日常运营；</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.广告类或新闻等相关专业本科毕业生；</p>
       <p>2.2年以上工作经验，具备一定的文字驾驭展现的能力，文字基本功扎实；</p>
       <p>3.表达力强、责任心强，热点敏感度强，思维活跃，有上进心；</p>
       <p>4.沟通能力强，具备诚实、负责任的品德；</p>
       <p>5.有新媒体运营（微信、微博）等方面工作经验者优先。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
