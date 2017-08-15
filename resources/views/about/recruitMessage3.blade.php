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
    <p class="recruitTitle">人力资源专员</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3-5年</li>
      <li>最低学历：本科</li>
      <li>招聘人数：1人</li>
      <li>职位类别：人力资源专员/助理</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">岗位职责：</p>
       <p>1.参与制定人力资源战略规划，为重大人事决策提供建议和信息支持；</p>
       <p>2.起草、修改和完善人力资源相关管理制度和工作流程；</p>
       <p>3.根据公司对绩效管理的要求，制定评价政策，组织实施绩效管理，并对各部门绩效评价过程进行监督控制，及时解决其中出现的问题，使绩效评价体系能够落到实处，并不断完善绩效管理体系；</p>
       <p>4.制定招聘计划、招聘程序，进行初步的面试与筛选，做好各部门间的协调工作等；</p>
       <p>5.制定培训计划，实施培训方案，组织完成培训工作和培训后的情况跟踪；</p>
       <p>6.制定薪酬政策和晋升政策，组织提薪评审和晋升评审，制定公司福利政策，办理社会保障福利；</p>
       <p>7.参与职位管理、组织机构设置,组织编写、审核各部门职能说明书与职位说明书；受理员工投诉，处理劳动争议、纠纷，进行劳动诉讼；</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职要求：</p>
       <p>1.国家统招专科及以上学历，人力资源管理等相关专业；</p>
       <p>2.具有2年以上人力资源管理经验，对现代企业人力资源管理模式有系统的了解和实践经验，熟悉制造行业人事管理流程；</p>
       <p>3.熟悉人力资源各模块，熟悉国家各项劳动人事法规政策；</p>
       <p>4.熟练使用OFFICE办公软件；</p>
       <p>5.具有较强的语言表达能力、人际交往能力、应变能力、沟通能力及解决问题的能力，有亲和力，较强的责任感与敬业精神。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
