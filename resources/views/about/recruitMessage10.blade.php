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
    <p class="recruitTitle">运营专员</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3年以上</li>
      <li>最低学历：本科</li>
      <li>招聘人数：3人</li>
      <li>职位类别：运营专员</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.负责公司网站的网络推广，负责搜索引擎优化、搜索引擎营销</p>
       <p>2.网站SEO、SEM数据的整理和分析。评估、分析网站的关键词，提升网站关键词的搜索排名，并围绕优化提出合理的网站调整建议，监测和分析网站的关键绩效指标。</p>
       <p>3.进行网站活动规划，提升用户数量及活跃度，提升品牌知名度，引导舆论。</p>
       <p>4.提高网站索引、排名、点击和转换；利用各大信息分类网站、微信、微博、博客、论坛、社区、QQ群、软文、口碑营销等综合手段推广；整合 资源，开发其它渠道的推广、建立多种合作 关系，提高网站用户量、流量。</p>
       <p>5.负责站内优化、代码优化、外链建设；熟悉交换链接、邮件推广、SNS推广、论坛推广、其他平台资源互换的推广、交换友情链接、软文投放及其它特殊的推广方式。</p>
       <p>6.及时提出网站推广所存在的问题，收集推广反馈数据，并能建设性的提出改进建议，不断改进推广效果。</p>
       <p>7.有较强的学习和环境适应能力，善于沟通，能及时的反映工作情况。</p>
       <p>8.负责网站日常文章添加、内容更新，有一定的写作功底；</p>
       <p>9.有耐心、有团队协作能力，具有岗位责任心。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.大专（含）以上学历。</p>
       <p>2.1-2年以上网站成功运营管理经验，具有房地产行业网站经验优先；</p>
       <p>3.对互联网行业有深刻的认知和敏感度，有丰富的管理学知识和工作经验</p>
       <p>4.工作认真踏实，对同事团结友爱，对专业认真负责，努力学习新知识，不断提高自身的技术修养。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
