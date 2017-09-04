@extends('mainlayout')
@section('title')
    <title>【搜房网介绍，搜房网事迹】-搜房网</title>
    <meta name="keywords" content="搜房网，搜房网介绍，搜房网联系方式，搜房地址，搜房招聘"/>
    <meta name="description" content="关于搜房，搜房电话，搜房招聘，搜房服务声明，搜房协议"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css?v={{Config::get('app.version')}}">
<div class="about">
  @include('about.quesLeft')
  <div class="about_r">
    <!--<h2 class="route">安全号码</h2> 
    <div class="img margin_t"><img src="/img/34.jpg" alt="帮助"></div>-->
    <h2 class="route">用户手册 &gt; 注册与登录</h2>
    <div class="rout_bot">
    	<div class="safe_tel">
    		<h4>安全号码</h4>
    		<p class="icon_tit"><span>搜房</span> 为您的隐私保驾护航</p>
    		<p class="icon_des">通过拨打安全电话，您的真实手机号码将不会在置业顾问的
手机中显示，置业顾问与您的电话联系将只通过搜房为您提供的安
全号码。除了为提供服务的置业顾问，任何个人或团体都不能通过
安全号码联系到您，更不会获得您真实的手机号码。</p>
    	</div>
    	<div class="safe_mid">
    		<h4></h4>
    		<p>将客户的信息作为自有资源，通过各种方式将客户信息泄露出去</p>
    		<ul>
    			<li><span>经纪人或团体获得
客户的真实手机号
码，变换不同的销
售人员对客户进行
骚扰。</span></li>
    			<li><span>客户的信息会成为
买卖资源进行交易，
客户会不间断的接
到各类产品的销售
电话，产品良莠不
齐。</span></li>
    			<li><span>当客户对销售人员
或产品表现出不满
时，客户信息有被
恶意泄露的风险。</span></li>
    		</ul>
    	</div>
    	<div class="safe_bot">
    		<div class="safe_cont">
    			<h4><img src="/img/222.png" alt="" /></h4>
	    		<ul>
	    			<li><span>1</span>客户在意向楼盘或房源处找到经纪人的安全号码</li>
	    			<li><span>2</span>客户登录或填写自己的真实手机号码，安全号码
	            1535910****出现</li>
	    			<li><span>3</span>客户用登录的手机号拨打安全号码联系经纪人，
	             此时经纪人的手机上只显示1535910****安全
	             号码，不会泄露客户的真实号码</li>
	    			<li><span>4</span>此时您与置业顾问的联系通过安全号码建立，
	             其他任何人都无法通过此安全号码联系到您，
	             更不会获得您的真实手机号码</li>
	    		</ul>
    		</div>
    	</div>
    </div>
  </div>
</div>
@endsection
