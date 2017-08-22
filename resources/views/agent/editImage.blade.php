<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$title}}</title>
<link rel="stylesheet" type="text/css" href="/css/brokerComment.css"/>
<link rel="stylesheet" type="text/css" href="/css/brokerCenter.css"/>
<link rel="stylesheet" type="text/css" href="/css/color.css"/>
</head>

<body>
<header class="header">
	<h2>搜房管理中心</h2>
	<nav class="head_nav">
      <a>我的店铺</a>
      <a>使用帮</a>
    </nav>
    <div class="head_r">
      <span>400-630-6888</span>
      <a>退出</a>
    </div>
</header>
<div class="main">
  <div class="main_l" id="main_l">
    <dl class="broker">
      <dt><a><img src="/image/broker.jpg" /></a></dt>
    </dl>
    <div class="subnav">
      <p class="p1 click"><span>楼盘库管理</span><i></i></p>
      <p class="p2" style="display:block;">
        <a href="../add/buildList.htm"><i></i>创建新楼盘</a>
        <a href="../examine/via.htm"><i></i>审核新楼盘</a>
        <a href="../manage/buildManage.htm" class="onclick"><i></i>新楼盘管理</a>
      </p>
      <p class="p1"><span>房源库管理</span><i></i></p>
      <p class="p2">
        <a href="/houseLibrary/enterSaleHouse/zzHouse.htm"><i></i>录入出售房源</a>
        <a><i></i>管理出售房源</a>
        <a href="/houseLibrary/enterRentHouse/zzHouse.htm"><i></i>录入出租房源</a>
        <a><i></i>管理出租房源</a>
      </p>
      <p class="p1"><span>我的搜房</span><i></i></p>
      <p class="p2">
        <a><i></i>我的资料</a>
        <a><i></i>我的认真</a>
        <a><i></i>我的积分</a>
        <a><i></i>修改密码</a>
      </p>
    </div>
  </div>
  <div class="main_r" id="main_r">
    <div class="commtent">
      <p>
        <span class="color_blue">五矿万科城</span>
        <span class="color8d">wkwkc</span>
        <span class="subway">普通住宅</span>
      </p>
      <p>
       <span>[&nbsp;北京-朝阳-百子湾&nbsp;]&nbsp;&nbsp;</span>
       <span>东四环与广渠路交口大郊亭桥广渠路21号&nbsp;<i class="map_icon"></i></span>
      </p>
    </div>
    <p class="right_title border_bottom">
      <a href="addNewBuild/addBBs.htm">基础信息</a>
      <a href="addBan/addBan.htm">楼栋信息</a>
      <a href="addLeyout/addLeyoutZz.htm">户型信息</a>
      <a href="addNewHouse/houseManageBs.htm">房源信息</a>
      <a href="addImage.htm" class="click">相册信息</a>
    </p>
    <div class="write_msg">
      <p class="manage_title">
         @if(!empty($data))
          @foreach($data as $dkey => $dval)
            @if(!empty($dval))
              @foreach($dval as $ddk => $ddv)
              <a href="{{$hosturl}}?type={{$ddk}}" @if($pagetype[2] == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
      <ul class="input_msg">
      @include('agent.roomImage')
     
  