@extends('mainlayout')
@section('title')
    <title>【招聘信息，招聘职位】-搜房网</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css">
<div class="about">
  @include('about.publicview')
  <div class="about_r">
    <h2><span>招聘信息</span></h2>
    <p class="present no_index">以下为搜房网招聘职位，如有意愿请您将简历发送至我们邮箱，我们会很快答复您：</p>
    <p class="present no_index">公司地址：北京朝阳区东三环北路甲2号京信大厦13层</p>
    <table id="table">
      <tr>
        <th width="16%">职位名称</th>
        <th width="16%">应聘部门</th>
        <th width="16%">招聘人数</th>
        <th width="16%">招聘类型</th>
        <th width="16%">工作经验</th>
        <th width="16%">详情</th>
      </tr>
      <tr>
        <td>首席UI设计师</td>
        <td>技术部</td>
        <td>3+</td>
        <td>全职</td>
        <td>1-3年</td>
        <td><a href="/about/recruitMessage.html">查看</a></td>
      </tr>
      <tr>
        <td>平面设计师</td>
        <td>技术部</td>
        <td>2+</td>
        <td>全职</td>
        <td>不限</td>
        <td><a href="/about/recruitMessage1.html">查看</a></td>
      </tr>
      <tr>
        <td>测试工程师</td>
        <td>测试部</td>
        <td>3+</td>
        <td>全职</td>
        <td>1-3年</td>
        <td><a href="/about/recruitMessage2.html">查看</a></td>
      </tr>
      <tr>
        <td>人力资源专员</td>
        <td>人事部</td>
        <td>1人</td>
        <td>全职</td>
        <td>3-5年</td>
        <td><a href="/about/recruitMessage3.html">查看</a></td>
      </tr>
      <tr>
        <td>人力资源主管</td>
        <td>人事部</td>
        <td>1人</td>
        <td>全职</td>
        <td>3-5年</td>
        <td><a href="/about/recruitMessage4.html">查看</a></td>
      </tr>
      <tr>
        <td>人力资源总监</td>
        <td>人事部</td>
        <td>1人</td>
        <td>全职</td>
        <td>5-10年</td>
        <td><a href="/about/recruitMessage5.html">查看</a></td>
      </tr>
      <tr>
        <td>人力资源经理</td>
        <td>人事部</td>
        <td>1人</td>
        <td>全职</td>
        <td>3-5年</td>
        <td><a href="/about/recruitMessage13.html">查看</a></td>
      </tr>
      <tr>
        <td>PHP工程师</td>
        <td>技术部</td>
        <td>20+</td>
        <td>全职</td>
        <td>不限</td>
        <td><a href="/about/recruitMessage6.html">查看</a></td>
      </tr>
      <tr>
        <td>产品经理</td>
        <td>技术部</td>
        <td>5+</td>
        <td>全职</td>
        <td>3年以上</td>
        <td><a href="/about/recruitMessage7.html">查看</a></td>
      </tr>
      <tr>
        <td>Web前端开发工程师</td>
        <td>技术部</td>
        <td>5+</td>
        <td>全职</td>
        <td>3-5年</td>
        <td><a href="/about/recruitMessage8.html">查看</a></td>
      </tr>
      <tr>
        <td>文案策划</td>
        <td>编辑部</td>
        <td>3人</td>
        <td>全职</td>
        <td>2年以上</td>
        <td><a href="/about/recruitMessage9.html">查看</a></td>
      </tr>
      <tr>
        <td>运营专员</td>
        <td>商务部</td>
        <td>3人</td>
        <td>全职</td>
        <td>3年以上</td>
        <td><a href="/about/recruitMessage10.html">查看</a></td>
      </tr>
      <tr>
        <td>运维专员</td>
        <td>技术部</td>
        <td>1人</td>
        <td>全职</td>
        <td>3年以上</td>
        <td><a href="/about/recruitMessage11.html">查看</a></td>
      </tr>
      <tr>
        <td>渠道营销</td>
        <td>商务部</td>
        <td>5+</td>
        <td>全职</td>
        <td>1年以上</td>
        <td><a href="/about/recruitMessage12.html">查看</a></td>
      </tr>
    </table>
  </div>
</div>
@endsection
