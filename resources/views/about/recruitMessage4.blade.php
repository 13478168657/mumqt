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
    <p class="recruitTitle">人力资源主管</p>
    <ul class="recruitMsg">
      <li>职位月薪：面议</li>
      <li>工作性质：全职</li>
      <li>工作经验：3-5年</li>
      <li>最低学历：本科</li>
      <li>招聘人数：1人</li>
      <li>职位类别：人力资源主管</li>
    </ul>
    <div class="jobDescribe">
       <p class="p1">工作职责：</p>
       <p>1.建全企业管理制度，人力资源规章制度，并实施、监督与执行；</p>
       <p>2.招聘、录用、薪酬、绩效考核、培训等相关实操工作；</p>
       <p>3.制定公司人力资源发展计划，并监督各项计划的实施；</p>
       <p>4.熟悉国家人事劳动法规、熟悉人力资源工作流程；组织实施对员工的考勤、考核、晋升、调职、奖惩、辞退等全方位管理；</p>
       <p>5.领导安排的其他任务。</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">任职资格：</p>
       <p>1.本科及以上学历，企业管理、行政管理或人力资源管理等专业； 2、4年以上人事工作经验，2年以上管理工作经验；</p>
       <p>2.性格开朗，善于沟通协调，责任心强，具备出色的组织协调能力及分析判断能力；考虑问题全面细致，有团队合作精神；</p>
       <p>3.熟悉国家、地区及企业关于合同管理、薪金制度、用人机制、保险福利待遇、培训等方面的法律法规及政策；</p>
       <p>4.有高新技术企业行政人事管理工作经验者优先。</p>
       <p>5.熟练使用internet和电脑办公软件（word,excel,powerpoint）</p>
    </div>
    <div class="jobDescribe">
       <p class="p1">亲，如有意向请：</p>
       <p class="p1">拨打电话联系：400-6090-798</p>
       <p class="p1">或简历发送至：hr@sofang.com</p>
    </div>
  </div>
</div>
@endsection
