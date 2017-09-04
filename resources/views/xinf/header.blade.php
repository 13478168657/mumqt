<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>【{{$cityName or ''}}@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif,{{$cityName or ''}}新楼盘】-搜房网</title>
<meta name="Keywords" content="{{$cityName or ''}} @if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif,{{$cityName or ''}}新楼盘" />
<meta name="Description" content="搜房网，{{$cityName or ''}}新房为您提供 @if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif 新房详情、新房相册、新房户型、新房价格，让您更全面的了解新楼盘，为您创造最佳新房购房体验！" />
<link rel="stylesheet" type="text/css" href="/css/buildDetail.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
</head>

<body>
<!-- <script src="/js/header1.js?v={{Config::get('app.version')}}"></script> -->
@include('layout.header')
<div class="header">
    <div class="catalog_nav" id="catalog_nav">
        <div class="list_sub">
            <div class="list_search">
                <input type="text" class="txt border_blue" tp="new" AutoComplete="off" placeholder="请输入关键字（楼盘名/地名等）" value="" id="keyword">
                <div class="mai mai1"></div>
                <input type="button" class="btn back_color keybtn" value="搜房">
            </div>

        </div>
    </div>
</div>
<p class="route">
  <span>您的位置：</span>
  <a href="{{url('/')}}">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="#" class="colorfe">北京新房</a>
</p>
<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script>
  $('#prompt').remove();
</script>