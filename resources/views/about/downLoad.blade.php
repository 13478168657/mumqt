@extends('mainlayout')
@section('title')
<title>搜房APP下载</title>
@endsection
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="/public/css/common.css">
<link rel="stylesheet" type="text/css" href="/publiccss/color.css"> -->
	<style>
		.app_contant dt{width:110px;text-align: center;}
	</style>
    <div class="app_contant" style="margin-top:150px;margin-bottom:460px;">
    	<!--<dl>
	        <dt>
	        	<a>
	                <i style="background:url(../image/cike.png) no-repeat"></i>
	                <h3>爱此刻</h3>
	            </a>
	        </dt>
	        <dd class="downs">
	            <p class="android">
	                <a href="http://www.aicike.cn/download/imoment_release.apk" class="anDown" title="点击Android下载">
	                	<span>Android下载</span><br>
	                	<em>
	                		<img src="../image/android.png" class="fl"><span class="fl">Android下载</span><img src="../image/55.png" class="fl">
	                	</em>
	                </a>
	            </p>
	            <p class="ios">
	                <a href="https://itunes.apple.com/app/id1176405145" target="_blank" class="iosDown" title="点击iPhone下载">
	                	<span>iPhone下载</span><br>
	                	<em>
	                		<img src="../image/ios.png" class="fl"><span class="fl">iPhone下载</span><img src="../image/55.png" class="fl">
	                	</em>
	                </a>
	            </p>
	            <p>
                	<img src="/image/aick_code.png" alt="爱此刻App下载二维码" width="120" height="120">
                </p>
	        </dd>
	        <dd class="desc">人生没有太晚的开始，珍惜此刻、爱此刻。记录此刻的自己，留下位置的足迹。 拓展圈子的交往，参与兴趣的话题。 邀约同城的朋友，分享生活的乐趣。无论人生有多少个此刻，我只 - 爱此刻。
            </dd>
    	</dl>
    	<dl>
            <dt>
            	<a href="http://www.kongfou.net/" target="_blank">
	                <i style="background:url(../image/kongfou.png) no-repeat"></i>
	                <h3>空否</h3>
                </a>
            </dt>
            <dd class="downs">
                <p class="android">
                    <a href="http://www.kongfou.net/kongfou.apk" class="anDown" title="点击Android下载">
                    	<span>Android下载</span><br />
                    	<em>
                    		<img src="/image/android.png" class="fl"/><span class="fl">Android下载</span><img  src="/image/55.png" class="fl"/>
                    	</em>
                    </a>
                </p>
                <p class="ios">
                    <a href="https://itunes.apple.com/us/app/kong-fou-sou-fang-wang-qi/id1149740405?l=zh&ls=1&mt=8" target="_blank" class="iosDown" title="点击iPhone下载">
                    	<span>iPhone下载</span><br />
                    	<em>
                    		<img src="/image/ios.png" class="fl"/><span class="fl">iPhone下载</span><img  src="/image/55.png" class="fl"/>
                    	</em>
                    </a>
                </p>
                <p>
                	<img src="/image/kongfCode.png" alt="空否App下载二维码" width="120" height="120">
                </p>
            </dd>
            <dd class="desc">空否”——搜房网旗下产品，面向商业地产人脉的社交平台。致力于业主
和经纪人信息交流传播。地产经纪人和商业地产业主一键联系，全新的商业
模式，助力商业地产发展。
            </dd>
    	</dl>
    	-->
    	<dl>
	        <dt>
	        	<a href="/sofangAPP/index.html" target="_blank">
	                <i style="background:url(../image/soufang.png) no-repeat"></i>
	                <h3>搜房网</h3>
	            </a>
	        </dt>
	        <dd class="downs">
	            <p class="android">
	                <a href="http://api.sofang.com/download/sofang_release.apk" class="anDown" title="点击Android下载">
	                	<span>Android下载</span><br />
	                	<em>
	                		<img src="../image/android.png" class="fl"/><span class="fl">Android下载</span><img  src="../image/55.png" class="fl"/>
	                	</em>
	                </a>	               
	            </p>
	            <p class="ios">
	                <a href="https://itunes.apple.com/us/app/sou-fang-wang-zu-fang-mai/id1193969192?mt=8
" target="_blank" class="iosDown" title="点击iPhone下载">
	                	<span>iPhone下载</span><br />
	                	<em>
	                		<img src="../image/ios.png" class="fl"/><span class="fl">iPhone下载</span><img  src="../image/55.png" class="fl"/>
	                	</em>
	                </a>
	            </p>
	            <p>
	            	<img src="../image/sf_code.png"  alt="搜房网ios下载二维码" />
	            </p>
	        </dd>
	        <dd class="desc">搜房网APP是集二手房、租房、新房功能于一体的手机找房软件，认证真房源，让您安心买好房，早日安居；及时精准的房价信息，为您买房、卖房、查房价提供参考；为广大买房、租房人群提供个性化找房体验，用户可随时随地通过手机查找房产信息，寻找区域内的房产经纪人，为双方搭建便捷的沟通桥梁。
            </dd>
    	</dl> 
    	<dl>
            <dt>
                <i></i>
                <h3>搜房网经纪人</h3>
            </dt>
            <dd class="downs">
                <p class="android">
                    <a href="http://www.sofang.com/app/sofang_1.0.0.apk" class="anDown" title="点击Android下载">
                    	<span>Android下载</span><br />
                    	<em>
                    		<img src="/image/android.png" class="fl"/><span class="fl">Android下载</span><img  src="/image/55.png" class="fl"/>
                    	</em>
                    </a>
                </p>
                <p class="ios">
                    <a href="https://itunes.apple.com/us/app/sou-fang-wang-xin-fang-jing/id1131133406?l=zh&ls=1&mt=8" target="_blank" class="iosDown" title="点击iPhone下载">
                    	<span>iPhone下载</span><br />
                    	<em>
                    		<img src="/image/ios.png" class="fl"/><span class="fl">iPhone下载</span><img  src="/image/55.png" class="fl"/>
                    	</em>
                    </a>                
                </p>
                <p>
                	<img src="/image/sfagent_code.png" alt="新房经纪人App下载二维码" width="120" height="120">
                </p>
            </dd>
            <dd class="desc">
                搜房网经纪人APP是一款适用于房产经纪人的手机工作平台，专为经纪人打造一个提升业绩的必备工具。同时具备房屋租赁信息免费查询、发布，具备房源统计量，清晰明了，方便经纪人之间的交流，互帮互助，同时还可以查看附近经纪人，了解动态。
            </dd>
    	</dl>
    </div>
    <div class="footer">
    </div>
    <script>
        function lo() {
            $("#lerror").hide();
            $("#lname").val('');
            $('#lpwd').val('');
            $("#islname").attr("class", "answ");
            $("#islpwd").attr("class", "ans");
        }
        function regs() {
            $("#rname").val('');
            $("#anrname").attr("class", "an");
            $("#error_rname").val('');
            $("#rmobile").val('');
            $("#anmobile").attr("class", "an");
            $("#error_rmobile").val('');
            $("#ryzm").val('');
            $("#anryzm").attr("class", "an");
            $("#error_ryzm").val('');
            $("#rpwd").val('');
            $("#idpwd").attr("class", "an");
            $("#rpwds").val('');
            $("#isrpwd").attr("class", "an");
            $("#error_rpwds").html('');
        }
    </script>
@endsection
