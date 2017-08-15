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
    <p class="recruitTitle">渠道营销</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：1年以上</li>
      <li>最低学历：不限</li>
      <li>招聘人数：5+</li>
      <li>职位类别：渠道/分销主管</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.开拓客户、沟通与管理，制定合作方案；</p>
       <p>2.执行销售和市场推广方案；</p>
       <p>3.制定渠道策略，提供渠道服务支持；</p>
       <p>4.及时沟通客户，反馈市场信息，做出处理意见；</p>
       <p>5.完成领导交办的其他相关事项。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.受过市场营销、产品知识方面的培训；</p>
       <p>2.两年以上的渠道运营经验；对市场营销工作有所了解；良好的渠道客户关系管理；</p>
       <p>3.熟悉产品市场营销渠道开发和建设业务；熟练操作办公软件；</P>
       <p>4.坦诚自信，高度的工作热情；思路清楚、有良好的沟通技巧和语言表达能力，性格开朗；有良好的团队合作精神及独立工作能力，有敬业精神。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
