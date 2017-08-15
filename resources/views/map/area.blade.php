<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>地图</title>
<link rel="stylesheet" type="text/css" href="/css/map.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
<style>
a.cityarea:link { padding-top: 20px; top: -30px; left: -30px; position: absolute; background: url(/image/map.png) no-repeat; width:77px; height:77px; border: 0; text-align: center; display: block; color: white; text-decoration: none;}
a.cityarea:visited { padding-top: 20px; position: absolute; background: url(/image/map.png) no-repeat; width:77px; height:77px; border: 0; text-align: center; display: block; color: white; text-decoration: none;}
a.cityarea:hover { padding-top: 20px; position: absolute; background: url(/image/mapOn.png) no-repeat; width:77px; height:77px; border: 0; text-align: center; display: block; color: white; text-decoration: none;}
.cityarea label { font-size: 14px; display: block;}
.cityarea span { font-size: 12px; display: block;}
a.community:link { width:40px; background-color: #fff; position: absolute; position: absolute; display: block; color: #000; text-align: center; text-decoration: none; border: orange solid 2px;}
a.community:visited { width:40px; background-color: #fff; position: absolute; position: absolute; display: block; color: #000; text-align: center; text-decoration: none; border: orange solid 2px;}
a.community:hover { width:40px; background-color: #fff; position: absolute; position: absolute; display: block; color: #000; text-align: center; text-decoration: none; border: red solid 2px;}
.community label { font-size: 14px; }
.community span { font-size: 12px; }
.subway { cursor: pointer; display: inline;}
.no_hidden{ overflow:hidden;}
.no_hidden li{ text-align:center; padding-left:0 !important; width:98px !important;}
</style>
</head>

<body>
<div class="main">
  <header class="header">
   <div class="head">
    <div class="top">
     <div class="top_l">
       <a href="index.htm"><img src="/image/sofang_logo.png"></a>
       <span class="dotted"></span>
       <div class="city">
         <div class="biao"></div>
         <a href="#" class="a"><span>北京</span><span>二手房</span><i></i></a>
         <div class="change">
           <div class="home margin">
             <h2>热门城市</h2>
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
         <li><a href="index.htm">首页</a></li>
         <li>
           <a class="a" id="buy">买房</a>
           <div class="biao"></div>
           <div class="top_msg">
             <div class="home margin">
              <h2>住宅</h2>
              <div class="home_msg">
                <ul>
                  <li><a href="houseList.htm">买二手房</a></li>
                  <li><a href="#">“真”房</a></li>
                  <li><a href="#">业主直售</a></li>
                </ul>
                <ul>
                  <li><a href="propertyList.htm">买新房</a></li>
                  <li><a href="#">即将开盘</a></li>
                </ul>
              </div>
             </div>
             <div class="home margin_l">
              <h2>写字楼</h2>
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
              <h2>服务资源</h2>
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
              <h2>住宅</h2>
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
              <h2>写字楼</h2>
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
              <h2>服务资源</h2>
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
              <h2>业主工具</h2>
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
       <a href="login.htm">登录</a>
       <span class="dotted"></span>
       <a href="register.htm">注册</a>
       <a style="margin-left:40px;">专业客户入口</a>
     </div>
    </div>
   </div>
   <div class="search">
     <form>
     <div class="sou">
      <input type="text" class="txt" placeholder="打算在哪儿买？">
      <input type="button" class="btn1" id="sou" value="搜房">
     </div>
     <input type="hidden" name="type" value="{{$type}}">
     <span class="dotted margin_l"></span>
     <div class="type_btn">
       <div class="type">
         <p><span>价格</span><i></i></p>
         <div class="price" id="price1" style="display:none;">
          <p class="top_icon"></p>
          <ul>
            @if(!empty($prices))
                @foreach($prices as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
          </ul>
        </div>
       </div>
       <span class="dotted"></span>
       <div class="type">
         <p><span>面积</span><i></i></p>
         <div class="price" id="price2" style="display:none;">
          <p class="top_icon"></p>
          <ul>
            @if(!empty($proportion))
                @foreach($proportion as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
          </ul>
        </div>
       </div>
       <span class="dotted"></span>
       <div class="type">
         <p><span>户型</span><i></i></p>
         <div class="price" id="price3" style="display:none;">
          <p class="top_icon"></p>
          <ul>
            @if(!empty($models))
                @foreach($models as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
          </ul>
         </div>
       </div>
       <span class="dotted"></span>
       <div class="type">
         <p><span>朝向</span><i></i></p>
         <div class="price" id="price4" style="display:none;">
          <p class="top_icon"></p>
          <ul>
            @if(!empty($toward))
                @foreach($toward as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
          </ul>
         </div>
       </div>
       <span class="dotted"></span>
       <div class="type geng">
        <a id="duo"><i class="duo"></i>更多</a>
        <div class="price" id="price5" style="display:none;">
          <p class="top_icon"></p>
          <div class="more_msg">
            <div class="select">
              <dl>
                <dd>
                  <div class='diy_select1'>
                    <input type='hidden' name='that' class='diy_select_input'/>
                    <div class='diy_select_txt1'>房龄</div>
                    <div class='diy_select_btn1'></div>
                    <ul class='diy_select_list1'>
            @if(!empty($that))
                @foreach($that as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
                    </ul>
                  </div>
                </dd>
              </dl>
              <dl>
                <dd>
                  <div class='diy_select1'>
                    <input type='hidden' name='floor' class='diy_select_input'/>
                    <div class='diy_select_txt1'>楼层</div>
                    <div class='diy_select_btn1'></div>
                    <ul class='diy_select_list1'>
            @if(!empty($floor))
                @foreach($floor as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
                    </ul>
                  </div>
                </dd>
              </dl>
              <dl>
                <dd>
                   <div class='diy_select1'>
                    <input type='hidden' name='decorate' class='diy_select_input' />
                    <div class='diy_select_txt1'>装修</div>
                    <div class='diy_select_btn1'></div>
                    <ul class='diy_select_list1' style="display:none">
            @if(!empty($decorate))
                @foreach($decorate as $k=>$v)
                    <li alt="{{$k}}">{{$v}}</li>
                @endforeach
            @endif
                    </ul>
                  </div>
                </dd>
              </dl>
            </div>
            <div class="pei">
              <dl>
                <dt>配套</dt>
               @if(!empty($pei))
                    @foreach($pei as $k=>$v)
                        @if($k!=6)
                            <dd><input type="checkbox"  name="pei" value="{{$k}}">&nbsp;{{$v}}</dd>
                        @else
                            <dd style="margin-left:50px;"><input type="checkbox" name="pei" value="{{$k}}">&nbsp;{{$v}}</dd>
                        @endif              
                    @endforeach
                @endif
              </dl>
              <dl>
                <dt>特色</dt>
                @if(!empty($te))
                    @foreach($te as $k=>$v)
                        @if($k!=6)
                            <dd><input type="checkbox"  name="te" value="{{$k}}">&nbsp;{{$v}}</dd>
                        @else
                            <dd style="margin-left:50px;"><input type="checkbox" name="te" value="{{$k}}">&nbsp;{{$v}}</dd>
                        @endif              
                    @endforeach
                @endif
              </dl>
              <dl>
                <dt>学区</dt>
                @if(!empty($xue))
                    @foreach($xue as $k=>$v)
                        <dd><input type="checkbox"  name="xue" value="{{$k}}">&nbsp;{{$v}}</dd>
                    @endforeach
                @endif
              </dl>
            </div>
            <div class="du">
              <span>个性化需求</span>
              <textarea></textarea>
            </div>
            <input type="button" value="提交" class="btn">
          </div>
         </div>
       </div> 
     </div>
     <div class="search_r">
       <a href="#"><span class="span">已关注楼盘</span><span class="num">12</span></a>
       <a href="#"><span class="span">已关注房源</span><span class="num">12</span></a>
     </div>
     <div class="clear"></div>
     </form>
   </div>
  </header>
  <div class="map">
    <div class="area_l">
      <div class="title">
        <span class="span1">符合条件</span>
        <span class="span2">共计<span class="color"></span>套</span>
        <a class="#">列表<i></i></a>
      </div>
      <div class="data">
        <dl class="qu">
          <dt></dt>
          <dd>
           <p>迪庆藏族自治州迪庆藏族自</p>
           <p>共有18个区域</p>
          </dd>
        </dl>
        <dl class="jun">
          <dt>均价<span>35700</span>元/平米</dt>
        </dl>
        <dl class="shen">
          <dt>同比：<i class="click"></i>2.5%</dt>
        </dl>
      </div>
      <div class="list">
        <p class="nav_l">
          <a href="#" class="click" alt="1">"真"房</a>
          <a href="#" alt="2">独家</a>
          <a href="#" alt="3">跳蚤</a>
        </p>
        <ul class="nav_r">
          <li><a>最新</a></li>
          <li class="dotted"></li>
          <li><a>价格<i></i></a></li>
          <li class="dotted"></li>
          <li><a>面积</a><i></i></li>
        </ul>
      </div>
      <div class="home" id="home">



      </div>

    </div>
    <div id="area">
      <div class="area_detail" id="area_detail">
        <a class="close"></a>
        <div class="home_msg" id="home_msg">
          <div class="home_img"></div>
          <h2 class="home_name color2d">缘溪堂京西豪宅直观玉渊潭美景观玉渊潭美景</h2>
          <p class="build_name">
           <span class="color2d"><span>所属楼盘：远洋新城</span><i></i></span>
           <span class="color8d time">发布时间：2014-11-15</span>
          </p>
          <p class="home_tag">
            <a class="subway">地铁附近</a>
            <a class="school">学区房</a>
            <a class="tag">满五房</a>
          </p>
          <div class="house_msg">
            <div class="house_type">
              <p class="type_title">
                <span class="back_color type_border"></span>
                <span class="color_blue">基本信息</span>
              </p>
              <ul class="type_info">
                <li>
                  <span class="color8d">售价：</span>
                  <span class="type_content color2d"><span class="colorfe">256</span>&nbsp;万</span>
                </li>
                <li>
                  <span class="color8d">单价：</span>
                  <span class="type_content color2d">25648&nbsp;元/平米</span>
                </li>
                <li>
                  <span class="color8d">户型：</span>
                  <span class="type_content color2d">3室2厅1卫</span>
                </li>
                <li>
                  <span class="color8d">面积：</span>
                  <span class="type_content color2d">86平米</span>
                </li>
                <li>
                  <span class="color8d">朝向：</span>
                  <span class="type_content color2d">东南</span>
                </li>
                <li>
                  <span class="color8d">楼层：</span>
                  <span class="type_content color2d">10/23层</span>
                </li>
                <li>
                  <span class="color8d">类型：</span>
                  <span class="type_content color2d">普通住宅</span>
                </li>
                <li>
                  <span class="color8d">年代：</span>
                  <span class="type_content color2d">2008年</span>
                </li>
                <li class="no_float">
                  <span class="color8d">地址：</span>
                  <span class="type_content color2d">朝阳区东三环京信大厦</span>
                </li>
              </ul>
              <p class="type_title">
                <span class="back_color type_border"></span>
                <span class="color_blue">房源描述</span>
              </p>
              <p class="house_describe">
               此房现在业主自住，为了以后孩子上学，在别的地方已经看好了学区房此房诚心出售此房是正规的两居室，全南向，客厅主卧次卧全朝南向，客厅带个大阳台，采光非常此房是业主名下家庭不满五年住房，交
易中会产生契税、个税、营业税步行即到十号 线（角门东站），小区门口就是公交站，有多条公交从此经过乐天玛特、银泰... <a class="color_blue">阅读全部</a>
              </p>
              <p class="type_title">
                <span class="back_color type_border"></span>
                <span class="color_blue">配套设施</span>
              </p>
              <div class="assort">
                <p class="assort_nav">
                  <a href="#" class="color2d">公交</a>
                  <a href="#" class="color2d">学校</a>
                  <a href="#" class="color2d">医疗</a>
                  <a href="#" class="color2d">银行</a>
                  <a href="#" class="color2d">商业</a>
                </p>
                <div class="assort_map"></div>
              </div>
              <p class="type_title">
                <span class="back_color type_border"></span>
                <span class="color_blue">房屋贷款</span>
              </p>
              <div class="loan">
                <div class="loan_l"></div>
              </div>
            </div>
            <div class="broker_msg">
              <div class="msg_top" id="msg_top">
                <dl>
                 <dt><a href="#"><img src="/image/broker.jpg"></a></dt>
                 <dd>
                   <p class="broker_name"><span class="color2d">张磊磊</span><i></i></p>
                   <P class="broker_branch"><i></i><i></i><i></i><i></i><i class="click"></i><span class="color2d">99+分</span></P>
                 </dd>
                </dl>
                <p class="company color2d">所属公司：链家地产</p>
                <p class="company margin_top color2d">注册时间：2015-09-08</p>
                <p class="msg_btn">
                 <a href="#" class="tel">联系电话</a>
                 <a href="#" class="spot">查看店铺</a>
                </p>
                <p class="msg_btn write_msg">
                 <a href="#" class="write">填写信息</a>
                </p>
                <div class="write_content" style="display:none;">
                  <p class="phone name">
                    <i></i>
                    <input type="text" class="txt colorcd" placeholder="请输入你的名字">
                  </p>
                  <p class="phone">
                    <i></i>
                    <input type="text" class="txt colorcd" placeholder="请输入你的电话">
                  </p>
                  <textarea class="txtarea"></textarea>
                  <input type="button" class="sub_msg" value="提交信息">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="map"></div>
      <div class="area_nav" style=" display:none;">
       <div class="area_msg">
        <a href="#" class="icon icon1">
          <i></i><span>地铁</span>
        </a>
        <div class="subway">
          <p class="top_icon"></p>
           <ul>
             <?php foreach($subways as $s){ ?>
                <li alt="<?php echo $s->id?>" class="sub" value="<?php echo $s->centerLng.','.$s->centerLat.','.$s->centerLevel?>">
                 <a><?php echo $s->name?><i></i></a>
                 <div class="xian">
                   
                 </div>
                </li>
                <?php }?>   

          </ul>
  

        </div>
       </div>
       <div class="area_msg">
         <a href="#" class="icon icon2"><i></i><span>学校</span></a>
         <div class="subway">
          <p class="top_icon"></p>
          <ul class="no_hidden">
            <li class="sch"><a>幼儿园</a></li>
            <li class="sch"><a>小学</a></li>
            <li class="sch"><a>中学</a></li>
            <li class="sch"><a>高中</a> </li>
          </ul>
         </div>
       </div>
       <div class="area_msg">
        <a href="#" class="icon icon3"><i></i><span>医疗</span></a>
        <div class="subway">
          <p class="top_icon"></p>
          <ul class="no_hidden">
            <li class="sch"><a class="">综合医院</a></li>
            <li class="sch"><a>专科医院</a></li>
            <li class="sch"><a>卫生站</a></li>
          </ul>
         </div>
       </div>
       <div class="area_msg">
         <a href="#" class="icon icon4"><i></i><span>银行</span></a>
         <div class="subway">
          <p class="top_icon"></p>
          <ul class="no_hidden">
            <li class="sch"><a class="">营业厅</a></li>
            <li class="sch"><a>ATM</a></li>
          </ul>
         </div>
       </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
       <div class="area_msg">
         <a href="#" class="icon icon5"><i></i><span>商业</span></a>
         <div class="subway">
          <p class="top_icon"></p>
          <ul class="no_hidden">
            <li class="sch"><a class="">餐饮</a></li>
            <li class="sch"><a>娱乐</a></li>
            <li class="sch"><a>购物</a></li>
          </ul>
         </div>
       </div>
       <a href="#" class="icon6"><i></i></a>
      </div>
      <div class="more">
        <a href="#" class="icon6"></a>
      </div>
    </div>
  </div>
</div>
<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/mapSize.js?v={{Config::get('app.version')}}"></script>
<script src="/js/dropdown.js?v={{Config::get('app.version')}}"></script>
<script src="/js/houseScroll.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script> 
<script src="/js/headNav.js?v={{Config::get('app.version')}}"></script>

<script type="text/javascript" src="/js/jquery.nicescroll.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
$("#home").niceScroll({  
	cursorcolor:"#8d8d8d",  
	cursoropacitymax:1,  
	touchbehavior:false,  
	cursorwidth:"5px",  
	cursorborder:"0",  
	cursorborderradius:"5px"  
}); 
$("#home_msg").niceScroll({  
	cursorcolor:"#8d8d8d",  
	cursoropacitymax:1,  
	touchbehavior:false,  
	cursorwidth:"5px",  
	cursorborder:"0",  
	cursorborderradius:"5px"  
}); 
</script>
<script type="text/javascript">
$(function(){

});
</script>

<script>
$(function(){

  //点击地铁线路请求返回站点
  $(".sub").on('mouseover',function(){
    var sub_id = $(this).attr('alt');
    var dq = $(this);
    $.ajax({
          type:"GET",
          url:'/map/getsubwaystation',
          data:{sub_id:sub_id},
          dataType:"text",
          success:function(data){
           
                data = eval('('+data+')');
                dq.find('div').html();
                var sub = '';
                for(var i=0;i<data.length;i++){
                   //sub +='<a href="" attr="'+data[i]['id']+'">'+data[i]['name']+'</a>';
                    sub +='<a id="sw_'+data[i]['id']+'" class="subways" value="'+data[i]['longitude']+','+data[i]['latitude']+'">'+data[i]['name']+'</a>';
                }

                dq.find('div').html(sub);
          },
          error:function(){
          }
    });
  });

});
</script>
<script src="/js/area.js?v={{Config::get('app.version')}}"></script>
</body>
</html>
