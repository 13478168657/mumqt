@extends('mainlayout')
@section('title')
    <title>搜房网免责声明</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css?v={{Config::get('app.version')}}">
<div class="about">
   @include('about.publicview')
  <div class="about_r">
    <h2><span>免责声明</span></h2>
    <p class="present no_index">搜房网对于本服务包含的或用户经由或从任何与本服务有关的途径所获得的任何内容、信息或广告，不声明或保证其正确性或可靠性；并且对于用户经本服务上的广告、展示而购买、取得的任何产品、信息或资料，搜房网不负保证责任。用户自行承担担使用本服务的风险。</p>
    <p class="present">(1) 搜房网有权但无义务，改善或更正本服务任何部分之任何疏漏、错误。</p>
    <p class="present">(2) 搜房网不保证以下事项（包括但不限于）：</p>
    <p class="present">1) 本服务适合用户的使用要求；</p>
    <p class="present">2) 本服务不受干扰，及时、安全、可靠或不出现错误；</p>
    <p class="present">3) 用户经由本服务取得的任何产品、服务或其他材料符合用户的期望；</p>
    <p class="present">4) 用户使用经由本服务下载的或取得的任何资料，其风险自行负担；因该使用而导致用户电脑系统损坏或资料流失，用户应负完全责任；</p>
    <p class="present">5) 对基于以下原因而造成的利润、商业信誉、资料的损失或其他有形或无形损失，搜房网不承担任何直接、间接、附带、衍生或惩罚性的赔偿；</p>
    <p class="present">6) 服务使用或无法使用；</p>
    <p class="present">7) 经由本服务购买或取得的任何产品、资料或服务；</p>
    <p class="present">8) 用户资料遭到未授权的使用或修改；</p>
    <p class="present">9) 其他与本服务相关的事宜。</p>
    <p class="present">(3) 用户在浏览网际网路时自行判断使用搜房网的检索目录。该检索目录可能会引导用户进入到被认为具有攻击性或不适当的网站，搜房网没有义务查看检索目录所列网站的内容，因此，对其正确性、合法性、正当性不负任何责任。</p>
    <p class="present">(4) 用户同意，对于搜房网向用户提供的下列产品或者服务的质量缺陷本身及其引发的任何损失，搜房网无需承担任何责任：</p>
    <p class="present">1) 搜房网向用户免费提供的各项网络服务；</p>
    <p class="present">2) 搜房网向用户赠送的任何产品或者服务；</p>
    <p class="present">3) 搜房网向收费网络服务用户附赠的各种产品或者服务。</p>
  </div>
</div>
@endsection
