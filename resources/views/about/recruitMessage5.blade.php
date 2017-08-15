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
    <p class="recruitTitle">人力资源总监</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3-5年</li>
      <li>最低学历：本科</li>
      <li>招聘人数：1人</li>
      <li>职位类别：人力资源总监</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">工作职责：</p>
       <p>1.全面统筹规划人力资源开发及战略管理，拟定人力资源规划方案；</p>
       <p>2.建立并完善人力资源管理体系，研究、设计人力资源管理模式（包含招聘、培训、绩效薪酬及员工发展等体系的全面建设），制定和完善人力资源管理制度；</p>
       <p>3.向公司决策层提供人力资源、组织机构等方面的建议，并致力于提高公司综合管理水平，控制人力资源成本；</p>
       <p>4.负责公司的整体企业文化建设、制定企业文化推行方案，并制定系列具体措施，做好渗透等宣导工作；</p>
       <p>5.设计公司组织结构和岗位编制，开发人力资源，为实现公司经营发展战略目标提供人力保障。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职资格：</p>
       <p>1.统招本科以上学历，年龄在40岁以内，8年以上人力资源管理经验，3年以上人力资源总监工作经验，有大型互联网公司人力团队管理经验者优先考虑；</p>
       <p>2.对人力资源战略规划、人才的引进方面具有丰富的实践、管理经验；</p>
       <p>3.熟悉互联网、金融行业人力资源管理模式，实践经验丰富， 对人力资源战略规划、人才的引进、薪酬福利设计、绩效激励考核、员工培训、员工职业生涯设计、企业文化等方面具有丰富的实践、管理经验；</p>
       <p>4.熟悉国家、企业关于合同管理、薪金制度、用人机制、保险福利待遇、培训等方面的法律法规及政策； </p>
       <p>5.具备优秀的激励、沟通、协调、团队领导能力，责任心、事业心强，具备良好的管理能力和决策能力。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
