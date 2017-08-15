
<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/9
 * Time: 11:57
 */

//侧边栏 单独
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="/css/brokerComment.css"/>
    <link rel="stylesheet" type="text/css" href="/css/brokerCenter.css"/>
    <link rel="stylesheet" type="text/css" href="/css/color.css"/>
    <link rel="stylesheet" type="text/css" href="/css/checkInputStyle.css?v={{Config::get('app.version')}}">
</head>
<div class="main">
    <div class="main_l" id="main_l"  style="min-height:1220px; height:auto;">
        <dl class="broker">
            <dt><a><img src="/image/broker.jpg" /></a></dt>
        </dl>
        <div class="subnav">
			<p class="p1 {{!empty($class)?'click':''}}"><span>存量房源库</span><i></i></p>
			<p class="p2" style="display:{{!empty($class)?'block':''}};">
				<a href="/entryhouse/sale"><i></i>录入出售房源</a>
				<a href="/oldsalemanage/releaseing"><i></i>管理出售房源</a>
				<a href="/entryhouse/rent"><i></i>录入出租房源</a>
				<a href="/oldrentmanage/releaseing"><i></i>管理出租房源</a>
            </p>
            <p class="p1"><span>委托管理</span><i></i></p>
            <p class="p2">
                <a href="#"><i></i>添加委托</a>
                <a href="#"><i></i>委托管理</a>
            </p>
            <p class="p1"><span>我的搜房</span><i></i></p>
            <p class="p2">
                <a href="/mysoufang/myinfo" ><i></i>我的资料</a>
                <a><i></i>我的认证</a>
                <a href="/mysoufang/password"><i></i>修改密码</a>
            </p>
        </div>
    </div>
    <!-- 记录当前页面导航高亮  start -->
    <script>
        var curURL = window.location.href.split('?')[0];
        var elem_A = document.getElementsByTagName('a');
        var p2     = document.getElementsByClassName('p2');
        for( var n in p2){
            p2[n].display='none';
        }

        for( var i in elem_A){
            if(elem_A[i].href == curURL){
                elem_A[i].className = 'onclick';
                elem_A[i].parentNode.style.display='block';
                break;
            }
        }
    </script>
    <!-- 记录当前页面导航高亮  end -->

