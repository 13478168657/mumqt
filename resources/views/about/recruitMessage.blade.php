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
    <p class="recruitTitle">首席UI设计师</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：1-3年</li>
      <li>最低学历：本科</li>
      <li>招聘人数3+</li>
      <li>职位类别：用户界面（UI）设计</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">【职位描述】</p>
       <p>1. 负责公司线上互联网产品整体视觉设计，提升公司的品牌形象；</p>
       <p>2.根据产品需求、运营需求产出高质量的产品视觉设计、交互设计；</p>
       <p>3.参与设计讨论，和开发团队共同创建用户界面，跟踪产品效果，提出设计改善方案；</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">【职位要求】</p>
       <p>1.设计或相关专业毕业，有国内知名互联网公司 工作经验者优先；</p>
       <p>2.熟悉Android等流行移动设备操作系统，有2年以上大型门户网站、时尚资讯网站、移动应用的网页设计工作经验；</p>
       <p>3.对移动互联网产品和软件有强烈兴趣和灵敏触觉，富有创造力和激情。</p>
       <p>4.有丰富的设计理论知识和对UI设计流行趋势敏锐的洞察力。</p>
       <p>5.熟练掌握Photoshop、Flash、Dreamweaver、AI等设计软件和网页制作流程；</p>
       <p>6.思维活跃，有创意及想法，美术功底扎实，有独特的设计品味；</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
