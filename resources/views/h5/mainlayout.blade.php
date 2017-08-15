<?php
/**
 * Created by NetBean.
 * User: duanfuhao
 * Date: 2016/4/22
 * Time: 10:15
 * 公共 主页框架
 */
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <meta http-equiv="Pragma"content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="expires"content="0">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">		
        @yield('title')      
        <link rel="stylesheet" type="text/css" href="/h5/css/common/common.css" />
        <link rel="stylesheet" type="text/css" href="/h5/dist/css/swiper-3.3.1.min.css" />
        <script src="/h5/js/common/jquery1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/h5/dist/js/swiper-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/h5/js/common/common.js" type="text/javascript" charset="utf-8"></script>       
        {{--此处head 是用来引入 当前页面的css/js等文件的--}}
        @yield('head')
        <script type="text/javascript">
            var _phoneWidth = parseInt(window.screen.width);
            var _phoneHeight = parseInt(window.screen.height);
            var _phoneScale = Math.floor(_phoneWidth / 750 * 100) / 100;
            var Terminal = {
                platform: function() {
                    var u = navigator.userAgent,
                            app = navigator.appVersion;
                    return {
                        android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
                        iPhone: u.indexOf('iPhone') > -1,
                        iPad: u.indexOf('iPad') > -1
                    };
                }(),
                language: (navigator.browserLanguage || navigator.language).toLowerCase()
            }
            var ua = navigator.userAgent;
            document.write('<meta name="viewport" content="width=750,target-densitydpi=device-dpi, initial-scale=' + _phoneScale + ', minimum-scale=' + _phoneScale + ', maximum-scale=' + _phoneScale + ', user-scalable=no">');
        	window.onresize = function(){
				document.documentElement.style.fontSize = document.documentElement.clientWidth/3.2+"px";
			}
        </script>
    </head>
    <body onload="loaded()">
        @yield('content')
    </body>
</html>
