<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>经纪人注册-{{$info->title}}</title>
<link rel="stylesheet" type="text/css" href="/css/brokerLogin.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="http://sandbox.runjs.cn/uploads/rs/351/8eazlvc1/imgareaselect-anima.css" />
</head>

<body style="background-color:#fff;">
<header class="header">
 <div class="head">
  <div class="top">
   <div class="top_l">
     <a href="index.htm"><img src="/image/sofang_logo.png"></a>
     <span class="dotted"></span>
     <div class="city">
       <div class="biao"></div>
       <a href="#" class="a"><span class="color8d">北京</span><i></i></a>
       <div class="change">
         <div class="home margin">
           <h2 class="color2e">热门城市</h2>
           <div class="home_msg">
              <ul>
                <li><a href="#">北京</a></li>
                <li><a href="#">广州</a></li>
                <li><a href="#">杭州</a></li>
                <li><a href="#">天津</a></li>
                <li><a href="#">重庆</a></li>
              </ul>
              <ul>
                <li><a href="#">上海</a></li>
                <li><a href="#">深圳</a></li>
                <li><a href="#">南京</a></li>
                <li><a href="#">武汉</a></li>
                <li><a href="#">成都</a></li>
              </ul>
            </div>
         </div>
         <div class="word">
           <h2>主要城市</h2>
           <dl>
             <dt>A-E</dt>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
           </dl>
           <dl>
             <dt>F-J</dt>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
           </dl>
           <dl>
             <dt>K-O</dt>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
           </dl>
           <dl>
             <dt>P-T</dt>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
           </dl>
           <dl>
             <dt>U-Z</dt>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
             <dd><a href="#">北京</a></dd>
           </dl>
         </div>
         <div class="home margin_l no_border" style="padding-right:20px;">
           <h2><a href="#">更多</a></h2>
         </div>
       </div>
     </div>
   </div>
   <div class="top_c">
     <ul>
       <li>
         <a class="a" id="buy">买房</a>
         <div class="biao"></div>
         <div class="top_msg">
           <div class="home margin">
            <h2 class="color2e">住宅</h2>
            <div class="home_msg">
              <ul>
                <li><a href="area.htm">买二手房</a></li>
                <li><a href="houseList.htm">“真”房</a></li>
                <li><a href="#">业主直售</a></li>
              </ul>
              <ul>
                <li><a href="propertyList.htm">买新房</a></li>
                <li><a href="#">即将开盘</a></li>
              </ul>
            </div>
           </div>
           <div class="home margin_l">
            <h2 class="color2e">写字楼</h2>
            <div class="home_msg">
              <ul>
                <li><a href="#">新建项目</a></li>
                <li><a href="#">即将开盘</a></li>
              </ul>
              <ul>
                <li><a href="#">现有项目</a></li>
                <li><a href="#">业主直售</a></li>
              </ul>
            </div>
           </div>
           <div class="home margin_l no_border">
            <h2 class="color2e">服务资源</h2>
            <div class="home_msg">
              <ul>
                <li><a href="#">找代理</a></li>
                <li><a href="#">下委托</a></li>
              </ul>
            </div>
           </div>
          </div>
       </li>
       <li>
         <a class="a">租房</a>
         <div class="biao"></div>
         <div class="top_msg">
           <div class="home margin">
            <h2 class="color2e">住宅</h2>
            <div class="home_msg">
              <ul>
                <li><a href="#">租二手房</a></li>
                <li><a href="#">“真”房</a></li>
                <li><a href="#">业主直租</a></li>
              </ul>
              <ul>
                <li><a href="#">租新房</a></li>
                <li><a href="#">即将开盘</a></li>
              </ul>
            </div>
           </div>
           <div class="home margin_l">
            <h2 class="color2e">写字楼</h2>
            <div class="home_msg">
              <ul>
                <li><a href="#">新建项目</a></li>
                <li><a href="#">即将开盘</a></li>
              </ul>
              <ul>
                <li><a href="#">现有项目</a></li>
                <li><a href="#">业主直售</a></li>
              </ul>
            </div>
           </div>
           <div class="home margin_l no_border">
            <h2 class="color2e">服务资源</h2>
            <div class="home_msg">
              <ul>
                <li><a href="#">找代理</a></li>
                <li><a href="#">下委托</a></li>
              </ul>
            </div>
           </div>
          </div>
       </li>
       <li>
         <a class="a">卖房</a>
         <div class="biao"></div>
         <div class="top_msg">
           <div class="home margin no_border">
            <h2 class="color2e">业主工具</h2>
            <div class="home_msg">
              <ul>
                <li><a href="#">查房价</a></li>
                <li><a href="#">房产评估</a></li>
                <li><a href="#">委托经纪人</a></li>
              </ul>
            </div>
           </div>
          </div>
       </li>
       <li><a>房产百科</a></li>
       <li><a>更多</a></li>
     </ul>
   </div>
   <div class="top_r">
     <a class="color8d" id="userMobile3">{{Auth::user()->userName}}</a>
     <a class="color8d" href="/logout">退出</a>
   </div>
  </div>
 </div>
</header>