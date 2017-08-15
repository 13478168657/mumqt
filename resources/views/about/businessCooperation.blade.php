@extends('mainlayout')
@section('title')
	<title>商务合作</title>
	@endsection
	@section('content')
	<link rel="stylesheet" type="text/css" href="/css/aboutOurs.css">
	<div class="banner"></div>
	<div class="copy_bar"></div>
	<div class="ban_txt">
		<p>搜房网，全国知名房地产门户网站, 是中国从事房地产互联网业务的企业之一，网站创建17年，致力于坚定不移的为中国百姓提供实效、广泛的房地产互联网信息服务。2016年，搜房网全新起航，现诚邀全国地区合作伙伴加盟，年入百万不是梦。</p>
		<i class="l_top"></i>
		<i class="r_top"></i>
		<i class="l_bot"></i>
		<i class="r_bot"></i>
	</div>
	<div class="container">
		<div class="agency" id="agency">
			<h4><span>我们寻找的代理商</span></h4>
			<div class="block_cont">
				<ul>
					<li>
						<img src="../image/agency1.jpg" alt="具备广告代理资质" width="217" height="241"/>
						<p>具备广告代理资质</p>
					</li>
					<li>
						<img src="../image/agency2.jpg" alt="拥有互联网销售团队" width="217" height="241" />
						<p>拥有互联网销售团队</p>
					</li>
					<li>
						<img src="../image/agency3.jpg" alt="本地地产营销资源" width="217" height="241" />
						<p>本地地产营销资源</p>
					</li>
					<li>
						<img src="../image/agency4.jpg" alt="网络运营经验" width="217" height="241"/>
						<p>网络运营经验</p>
					</li>
				</ul>
			</div>
		</div>
		<div class="advantage" id="advantage">
			<h4><span>平台优势</span></h4>
			<div></div>
		</div>
		<div class="datas" id="datas">
			<h4><span>需要提供材料</span></h4>
			<div></div>
		</div>
		<div class="process" id="process">
			<h4><span>加盟流程</span></h4>
			<div></div>
		</div>
		<div class="map_citys" id="map_citys">
			<h4><span>招商城市</span></h4>
			<div></div>
		</div>
	</div>
	<div class="links_bar">
		<dl style="overflow: visible;">
			<dt><img src="../image/join_logo.png"/></dt>
			<dd class="tels">
				<span><i></i><em>15907387772</em></span>
				<span>微信：soufang_com</span>	
				<span style="position: relative;width:60px;height: 24px;"><img src="/image/bussines.jpg" width="70" height="70" alt="搜房网加盟合作微信" style="position: absolute;top:-28px;left:0;"/></span>
				<span>独家合作</span>
				<span>致电咨询</span>
			</dd>
		</dl>
	</div>	
	<ul class="right_nav" id="right_nav">
	    <li class="current">
	        <a href="#agency">
	            <h6 class="w_56">我们寻找的代理商</h6>
	        </a>
	    </li>
	    <li>
	        <a href="#advantage">
	            <h6>平台优势</h6>
	        </a>
	    </li>
	    <li>
	        <a href="#datas">
	            <h6 class="w_56">需要提供的资料</h6>
	        </a>
	    </li>
	    <li>
	        <a href="#process">
	          <h6>加盟流程</h6>
	        </a>
	    </li>
	    <li>
	        <a href="#map_citys">
	          <h6>招商城市</h6>
	        </a>
	    </li>
	    <li class="backtop">
	        <a href="javascript:;">
	            <i></i>
	        </a>
	    </li>
	</ul>
   <script src="../js/jquery1.11.3.min.js"></script>
   <script>
   	//侧导航
	var rightBar=document.getElementById('right_nav');
	var clientW=document.documentElement.clientWidth;
	var mar_L=30;
	var right=clientW-((clientW-1200)/2+1200)-parseInt(getStyle(rightBar,'width'))-mar_L;
	var newHouse=newHouse=$('#agency').offset().top-100;	
	var oldHouse=$('#advantage').offset().top;-140
	var office=$('#datas').offset().top-140;
	var money=$('#process').offset().top-140;
	var bottom=$('#map_citys').offset().top-325;
	var dis=$('.ban_txt').offset().top-100;
	var clientH=document.documentElement.clientHeight;
	rightBar.style.right=right+'px';
	toTop();	
	$(window).on('scroll',function(){
		toTop();
	});
	
	//回到顶部
		var backTop=$('.right_nav .backtop');
		backTop.on('click',function(){
			var n=$(document).scrollTop();			
			var timer=setInterval(function(){
				n-=110;
				$(document).scrollTop(n);
				if(n<=0){
				clearInterval(timer);	
				}
			},30);
		});
	
	
	function getStyle(obj,sClass){
		return (obj.currentStyle || getComputedStyle(obj,false))[sClass];
	}
	function toTop(){
		var n=$(document).scrollTop();
		if(n>=dis){
			$('.links_bar').css({position:'fixed',left:0,top:0});
			$('.copy_bar').show();
		}else{
			$('.links_bar').css({position:'static'});
			$('.copy_bar').hide();
		}
		if(n>=newHouse && n<oldHouse){
			$('.right_nav li').removeClass('current');
			$('.right_nav li').eq(0).addClass('current');
		}else if(n>=oldHouse && n<office){
			$('.right_nav li').removeClass('current');
			$('.right_nav li').eq(1).addClass('current');
		}else if(n>=office && n<money){
			$('.right_nav li').removeClass('current');
			$('.right_nav li').eq(2).addClass('current');
		}else if(n>=money && n<bottom){
			$('.right_nav li').removeClass('current');
			$('.right_nav li').eq(3).addClass('current');
		}else if(n>=bottom){
			$('.right_nav li').removeClass('current');
			$('.right_nav li').eq(4).addClass('current');
		}
		if(n>50){
			$(rightBar).show();
		}else{
			$(rightBar).hide();
		}	
	}
   </script>
@endsection
  