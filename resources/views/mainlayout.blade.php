<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/8
 * Time: 18:03
 */

/**
 * 公共 主页框架
 */
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
<meta name="sogou_site_verification" content="ojP49dO3yi"/>
<meta name="360-site-verification" content="1524c7d232ff39b8b441133fe660d306" />
@yield('title')
<link rel="icon" href="http://www.sofang.com/favicon.ico" mce_href="http://www.sofang.com/favicon.ico" type="image/x-icon">
{{--首页和其他页面样式不同--}}
@if (isset($index)&&$index==1)<meta name="我是首页"/>
    <link rel="stylesheet" type="text/css" href="css/index.css?v={{Config::get('app.version')}}">
@else<meta name="我是别的页"/>
    <link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
@endif
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
{{--此处head 是专门用来引入 当前页面的css文件 的--}}
@yield('head')
{{--判断是否加载JQuery--}}
@if (!isset($nojquery))
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
@endif
</head>
<body>
{{--加载公共头部,首页头部和其他页面头部不同--}}
@if (isset($index)&&$index==1)
    @include('layout.headerIndex')
@else
    @include('layout.headerOther')
@endif
{{--加载主体内容--}}
@yield('content')
{{--加载公共尾部--}}
@include('layout.footer')
<script>
    $(document).ready(function(e) {
        $(this).keydown(function (e){
            if(e.which == "13"){
                $("#login").click();
            }
        })
    });
    $('#lproname').val('');
    $('#lpropwd').val('');
</script> 
<script>
(function(){
    var bp = document.createElement('script');
    bp.src = '//push.zhanzhang.baidu.com/push.js';
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
<script>
$(document).ready(function(e) {
  $(".telLogin").click(function(){
	  $(".userLogin").hide();
	  $(".userLogin1").show();  
  });
  $(".accountLogin").click(function(){
	  $(".userLogin1").hide();
	  $(".userLogin").show();  
  });	

  $('.modaltrigger').leanModal({
		top:100,
		overlay:0.45
	});
})
</script>
{{--<script src="/js/sflogger.js" type="text/javascript"></script>--}}
</body>
</html>
