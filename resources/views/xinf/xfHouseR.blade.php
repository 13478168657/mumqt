<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>楼盘下的户型详情</title>
<link rel="stylesheet" type="text/css" href="css/buildDetail.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="css/common.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="css/color.css?v={{Config::get('app.version')}}">
</head>

<body>
<script src="js/header1.js?v={{Config::get('app.version')}}"></script>
<div class="catalog_nav">
    <a href="../../../detailStyle/newBuildDetail/index.htm" class="color2d">搜房网</a>
    <span>&nbsp;&nbsp;>&nbsp;&nbsp;</span>
    <a href="#">新房</a>
    <span>&nbsp;&nbsp;>&nbsp;&nbsp;</span>
    <span>合生滨江帝景</span>
    <div class="list_search">
      <input type="text" class="txt border_blue" placeholder="请输入关键字（楼盘名/地名/开发商等）">
      <input type="text" class="btn back_color" value="搜房">
      <a class="list_map color_blue"><i></i>地图</a>
    </div>
  </div>
<div class="detail">
  <div class="city_msg">
    <dl class="msg_l">
      <dt></dt>
      <dd>
        <p class="p1"><span class="color_blue">合生滨江帝景</span><a class="color8d">共有2000人点评</a></p>
        <p class="p2"><a class="subway">出售</a></p>
      </dd>
    </dl>
    <dl class="msg_r">
      <dt class="color8d">正在出售中</dt>
      <dd><span class="colorfe">38549</span>&nbsp;套</dd>
    </dl>
    <dl class="msg_r">
      <dt class="color8d"><span class="color2d">一居均价</span></dt>
      <dd><span class="colorfe">38549</span>&nbsp;元/平米</dd>
    </dl>
    <dl class="msg_r">
      <dt class="color8d"><span class="color2d">二居均价</span></dt>
      <dd><span class="colorfe">38549</span>&nbsp;元/平米</dd>
    </dl>
    <dl class="msg_r">
      <dt class="color8d"><span class="color2d">最低价</span></dt>
      <dd><span class="colorfe">38549</span>&nbsp;元/平米</dd>
    </dl>
  </div>
  <div class="build">
    <div class="msg_nav" id="msg_nav">
      <a href="xinfindex">楼盘首页</a>
      <a href="xinfxq">楼盘详情</a>
      <a href="xinffy" class="nav_click">房源详情</a>
      <a href="xinfhx">户型详情</a>
      <a href="xinfxc">楼盘相册</a>
      <a href="xinfzs">房价走势</a>
      <a href="xinfjl">带看记录</a>
      <a href="xinfdp">客户点评</a>
      <a href="../../../detailStyle/newBuildDetail/houseList.htm">二手房</a>
      <a href="../../../detailStyle/newBuildDetail/houseList.htm">租房</a>
    </div>
  </div>
  <div class="build_house">
    <div class="home_info">
      <ul>
        <li><span class="margin_l">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型：</span>
          <a class="search" value="" onclick="condi_sub(this, 'room');">全部户型</a>
          @foreach($roomnum as $num)
          <a class="search" value="{{$num->houseRoom}}" onclick="condi_sub(this, 'room');" id="{{$num->houseRoom}}">{{$num->houseRoom}}居</a>
          @endforeach
        </li>
        <li><span class="margin_l">楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;栋：</span>
          <a class="search" value="" onclick="condi_sub(this, 'building');">全部楼栋</a>
          @foreach($building as $build)
          <a class="search" value="{{$build->buildingId}}" onclick="condi_sub(this, 'building');" id="{{$build->buildingId}}">{{$build->buildingId}}号楼</a>
          @endforeach
          <!-- <?php for($i = 1 , $cnt = 1 ; $i <= count($building); $i++,$cnt++ ) { ?>
          <a class="search" id="<?php echo $cnt; ?>"><?php echo $cnt; ?>号楼</a>
          <?php } ?> -->
        </li>
        <li><span class="margin_l">楼&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;层：</span>
          <a class="search" value="" onclick="condi_sub(this, 'current_floor');">全部楼层</a>
          <a class="search" value="1 and 6" onclick="condi_sub(this, 'current_floor');"><span>低层</span>（7层以下）</a>
          <a class="search" value="7 and 12" onclick="condi_sub(this, 'current_floor');"><span>中层</span>（7-12层）</a>
          <a class="search" value="12 and 90" onclick="condi_sub(this, 'current_floor');"><span>高层</span>(13-20层)</a>
        </li>
        <li><span class="margin_l">销售状态：</span>
          <a class="search" value="" onclick="condi_sub(this, 'deal');">全部状态</a>
          <a class="search" value="0" onclick="condi_sub(this, 'deal');">在售</a>
          <a class="search" value="1" onclick="condi_sub(this, 'deal');">已售</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="house_list">
    <p id="num_sale" class="list_title">房源信息（{{count($housesale)}}）</p>
    <div id="changeinfo" class="list_house">
      @foreach($pagehousesale as $sale)
      @if($sale->dealState != 1)
      <dl>
        <dt><a href="xfBHouseR.htm"><img src="{{$sale->thumbPic}}" alt=""></a></dt>
        <dd class="dd1">
          <p class="p1"><a href="xfBHouseR.htm">合生滨江帝景-永顺镇居住项目C7号楼-1单元-9-901</a></p>
          <p class="color8d p2">{{$sale->roomStr}}  南北  {{$sale->area}} ㎡(建筑面积)</p>
        </dd>
        <dd class="dd3"><span class="dd_left colorfe fontA"><span>{{$sale->price}}</span>万</span><span class="dd_right">361.32万元/套</span></dd>
        <dd class="dd4"><a href="xfBHouseR.htm" class="back_color">我要预订</a></dd>
      </dl>
      @endif
      @if($sale->dealState == 1)
      <dl>
        <dt><a href="xfBHouseR.htm"><img src="{{$sale->thumbPic}}" alt=""></a></dt>
        <dd class="dd1">
          <p class="p1"><a href="xfBHouseR.htm">合生滨江帝景-永顺镇居住项目C7号楼-1单元-9-901</a></p>
          <p class="color8d p2">{{$sale->roomStr}}  南北  {{$sale->area}} ㎡(建筑面积)</p>
        </dd>
        <dd class="dd2 margin_t">
          <span><span class="fontA">{{$sale->price}}</span>万</span>
          <span class="finish">已售完</span>
        </dd>
      </dl>
      @endif
      @endforeach
    </div>
    <div class="page_nav">
      <ul id="changepage">
        {!!$pages!!}
      </ul>
    </div>
  </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<script src="js/footer2.js?v={{Config::get('app.version')}}"></script>
<script src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>
<script>
$(document).ready(function(e) {
  $(".hx .hx_title i").click(function(){
	$(".hx ul").hide();
	$(this).parent().next().show();  
	$(".hx .hx_title i").removeClass("click");
	$(this).addClass("click");
  });
  $(".build_house .home_info ul li a").click(function(){
	 if($(this).attr("class")=="search") {
		$(this).parent().find("a").removeClass("click");
		$(this).addClass("click"); 
	 }else if($(this).attr("class")=="click"){
		$(this).removeClass("click");  
	 }
  });
});
window.onload = function(){
	var oDiv = document.getElementById("msg_nav");
	var h = oDiv.offsetTop;
	document.onscroll = function(){
		var t = document.documentElement.scrollTop || document.body.scrollTop;
		if(h <= t){
			oDiv.style.position = 'fixed';
		}else{
			oDiv.style.position = '';
			}
	}	
};
</script>
<script>
var room='',building='',current_floor='',deal='',curr_page='';
function condi_sub(obj,type){
  if(type == 'room'){
    if(room != $(obj).attr('value')){
      room = $(obj).attr('value');
      curr_page = 1;
    }else{
      room = $(obj).attr('value');
    }
  }else if(type == 'building'){
    if(building != $(obj).attr('value')){
      building = $(obj).attr('value');
      curr_page = 1;
    }else{
      building = $(obj).attr('value');
    }
  }else if(type == 'current_floor'){
    if(current_floor != $(obj).attr('value')){
      current_floor = $(obj).attr('value');
      curr_page = 1;
    }else{
      current_floor = $(obj).attr('value');
    }
  }else if(type == 'deal'){
    if(deal != $(obj).attr('value')){
      deal = $(obj).attr('value');
      curr_page = 1;
    }else{
      deal = $(obj).attr('value');
    }
  }else if(type == 'curr_page'){
    curr_page = $(obj).attr('value');
  }
  var _token = $('input[name="_token"]').val();
  
  $.ajax({
      type : 'post',
      url  : '/xinffy',
      data : {
        _token:_token,
        room:room,
        building:building,
        current_floor:current_floor,
        deal:deal,
        curr_page:curr_page
      },
      success:function(result){
        // console.log(result);
        $('#num_sale').html('房源信息（'+ result.count +'）');
        var sale_list = '';
        for( i in result.allsearchinfo ){
          if(result.allsearchinfo[i].dealState != 1){
            sale_list += '<dl><dt><a href="xfBHouseR.htm"><img src="'+ result.allsearchinfo[i].thumbPic +'"></a></dt><dd class="dd1"><p class="p1"><a href="xfBHouseR.htm">合生滨江帝景-永顺镇居住项目C7号楼-1单元-9-901</a></p><p class="color8d p2">'+ result.allsearchinfo[i].roomStr +'  南北  '+ result.allsearchinfo[i].area +' ㎡(建筑面积)</p></dd><dd class="dd3"><span class="dd_left colorfe fontA"><span>'+ result.allsearchinfo[i].price +'</span>万</span><span class="dd_right">361.32万元/套</span></dd><dd class="dd4"><a href="xfBHouseR.htm" class="back_color">我要预订</a></dd></dl>';
          } else {
            sale_list += '<dl><dt><a href="xfBHouseR.htm"><img src="'+ result.allsearchinfo[i].thumbPic +'"></a></dt><dd class="dd1"><p class="p1"><a href="xfBHouseR.htm">合生滨江帝景-永顺镇居住项目C7号楼-1单元-9-901</a></p><p class="color8d p2">'+ result.allsearchinfo[i].roomStr +'  南北  '+ result.allsearchinfo[i].area +' ㎡(建筑面积)</p></dd><dd class="dd2 margin_t"><span><span class="fontA">'+ result.allsearchinfo[i].price +'</span>万</span><span class="finish">已售完</span></dd></dl>';
          }
        }
        $('#changeinfo').html(sale_list);
        //console.log(result);
        $('#changepage').html(result.pages);

      }
  });
}
</script>
</body>
</html>
