@extends('mainlayout')
@section('title')
<title>【{{CURRENT_CITYNAME}}{{$commName}}楼盘详情,二手房,租房】-搜房网</title>
<meta name="Keywords" content="{{$commName}},{{$commName}}租房,{楼盘名}二手房" />
<meta name="Description" content="{{$commName}}为您提供多方位信息，小区交通、周边、学校等详情，小区外景图、户型图、交通图、配套图，小区租售价格走势，小区二手房源、租房房源。" />
@endsection
@section('head')
  <link rel="stylesheet" type="text/css" href="/css/buildDetail.css?v={{Config::get('app.version')}}">
@endsection
@section('content')

@include('esf.search')
<div class="detail esf_detail">
  @include('esf.left')
  <div class="event_detail">
    <h2>基本信息</h2>
    <ul class="build_info">
      <li>
        <span class="caption">物业类别：</span>
        <span class="caption_msg">{{(!empty(config('communityType2.'. $type2)))?config('communityType2.'. $type2):'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">项目特色：</span>
        <span class="caption_msg" title="{{(!empty($viewShowInfo['tagsName']))?$viewShowInfo['tagsName']:'暂无资料'}}">{{(!empty($viewShowInfo['tagsName']))?$viewShowInfo['tagsName']:'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">所属区域：</span>
        <span class="caption_msg">
          @if(!empty($viewShowInfo['cityAreaId']) || !empty($viewShowInfo['businessAreaId']))
            @if(!empty($viewShowInfo['cityAreaId']))
              {{\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($viewShowInfo['cityAreaId'])}}
            @endif
            @if(!empty($viewShowInfo['businessAreaId']))
              {{\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($viewShowInfo['businessAreaId'])}}
            @endif
          @else
          暂无资料
          @endif
        </span>
      </li>
      <li>
        <span class="caption">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['zipCode']))?$viewShowInfo['zipCode']:'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">环线位置：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['loopLineName']))?$viewShowInfo['loopLineName']:'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">产权年限：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->propertyYear))?$type2GetInfo->propertyYear.' 年' : '暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">竣工时间：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->endTime))?date('Y-m-d',$type2GetInfo->endTime):'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">开 发 商：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['developerName']))?$viewShowInfo['developerName']:'暂无资料'}}</span>
      </li>
      <!-- <li>
        <span class="caption">建筑结构：</span>
        <span class="caption_msg">板楼和塔楼还有板塔结合的</span>
      </li> -->
      <li>
        <span class="caption">建筑类别：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['structure']))?$viewShowInfo['structure']:'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">建筑面积：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->floorage))?$type2GetInfo->floorage.' 平方米':'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">占地面积：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->floorSpace))?$type2GetInfo->floorSpace.' 平方米':'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">总&nbsp; 户&nbsp;数：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->houseTotal))?$type2GetInfo->houseTotal.' 户':'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">绿&nbsp; 化&nbsp;率：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->greenRate))?$type2GetInfo->greenRate.' %':'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">容&nbsp; 积&nbsp;率：</span>
        <span class="caption_msg">{{(!empty($type2GetInfo->volume))?$type2GetInfo->volume:'暂无资料'}}</span>
      </li>
      <!-- <li>
        <span class="caption">物业办公电话：</span>
        <span class="caption_msg">67761717</span>
      </li> -->
      <li>
        <span class="caption">物&nbsp; 业&nbsp;费：</span>
        <span class="caption_msg"> {{(!empty($type2GetInfo->propertyFee))?$type2GetInfo->propertyFee.' 元/平米·月':'暂无资料'}} </span>
      </li>
      <!-- <li>
        <span class="caption">楼层状况：</span>
        <span class="caption_msg">4983户，8-14层，三期共200套</span>
      </li> -->
      <li>
        <span class="caption">供&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['gongshui']))?$viewShowInfo['gongshui']:'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">采&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;暖：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['gongnuan']))?$viewShowInfo['gongnuan']:'暂无资料'}}</span>
      </li>
      <li>
        <span class="caption">供&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['gongdian']))?$viewShowInfo['gongdian']:'暂无资料'}}</span>
      </li>
      
      <li class="no_left">
        <span class="caption">停&nbsp; 车&nbsp;位：</span>
        <span class="caption_msg">{{(!empty($viewShowInfo['parkingIntro']))?$viewShowInfo['parkingIntro']:'暂无资料'}}</span>
      </li>
      <li class="no_left">
        <span class="caption">物业地点：</span>
        <span>{{(!empty($viewShowInfo['propertyAddress']))?$viewShowInfo['propertyAddress']:'暂无资料'}}</span>
      </li>
      <li class="no_left">
        <span class="caption">小区地址：</span>
        <span>{{(!empty($viewShowInfo['address']))?$viewShowInfo['address']:'暂无资料'}}</span>
      </li>
    </ul>
      <h2>项目配套</h2>
      <div class="map">
        <p class="tab_nav">
                 <span>
                   <a class="tab_l">街景地图</a>
                   <a class="tab_r click">交通地图</a>
                 </span>
        </p>
        <div style="display:none;" class="jj" id="quanjing"></div>
        <div class="jt">
          <p class="jt_nav">
            <a class="curpos">楼盘位置</a>
            <a class="chechData" attr="小区">周边楼盘</a>
            <a class="chechData" attr="公交">交通</a>
            <a class="chechData" attr="超市">超市</a>
            <a class="chechData" attr="学校">学校</a>
            <a class="chechData" attr="餐饮">餐饮</a>
            <a class="chechData" attr="银行">银行</a>
            <a class="chechData" attr="医院">医院</a>
          </p>
          <div class="assort">
            <div class="assort" id="allmap"></div>
            <div class="assort_nav">
              <div id="zk" class="zk"></div>
              <h2 id="soukey"></h2>
              <div id="r-result" style="height: 320px;overflow-y: auto;"></div>
            </div>
          </div>
        </div>
      </div>
    <h2>项目简介</h2>
    {{--<p class="traffic">{{(!empty($viewShowInfo['intro']))?$viewShowInfo['intro']:'暂无资料'}}</p>--}}
    <p class="traffic">{{(!empty($viewShowInfo['note']))?$viewShowInfo['note']:'暂无资料'}}</p>
  </div>

</div>
<script src="/js/specially/headNav.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{config('mapApiKey.baidu')}}"></script>
<script type="text/javascript">
  $(function(){
    //经纬度
    var longitude = "{{!empty($jingduMap)?$jingduMap:0}}";
    var latitude = "{{!empty($weiduMap)?$weiduMap:0}}";
    if((longitude == 0) && (longitude == 0)){
      longitude = '116.405467';
      latitude = '39.907761';
    }
    // 百度地图API功能
    var map = new BMap.Map("allmap");    // 创建Map实例
    var point = new BMap.Point(longitude, latitude);
    map.centerAndZoom(point, 15);  // 初始化地图,设置中心点坐标和地图级别
    map.enableScrollWheelZoom(true);
    //街景地图
    var panoramaService = new BMap.PanoramaService();
    panoramaService.getPanoramaByLocation(point, function(data){
      var panoramaInfo="";
      if (data == null) {
        $('.tab_l').hide();
        return;
      }
      var panorama = new BMap.Panorama('quanjing');
      panorama.setPosition(point); //根据经纬度坐标展示全景图
      panorama.setPov({ heading: -40, pitch: 6 });
    });
    $('.tab_r').click(function(){
      var marker2 = new BMap.Marker(point);  // 创建标注
      map.addOverlay(marker2);
    }).trigger('click');
    //周边点击
    $('.chechData').bind('click',function(){
      var data1 = $(this).attr('attr');
      var data2 = $(this).text();
      chechData(data1,data2);
    });

    function chechData(data1,data2){
      $('#soukey').text(data2);
      $('.periphery_nav').hide();
      $('.periphery_build').show();
      curpos();
      $('.assort_nav').show();
      $('soukey').html('<i></i>'+data2);
      var circle = new BMap.Circle(point,1000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
      map.addOverlay(circle);
      var local =  new BMap.LocalSearch(map, {renderOptions: {map: map, panel:"r-result", autoViewport: false},pageCapacity:5});
      local.searchNearby(data1,point,1000);
    }
    $('.curpos').click(function(){
      var c_name = "{{$viewShowInfo['commName'] or '暂无'}}";
      var c_address = "{{$viewShowInfo['address'] or '暂无'}}";
      $(this).addClass("click");
      map.clearOverlays();
      //当前楼盘地址
      var marker2 = new BMap.Marker(point);  // 创建标注
      map.addOverlay(marker2);
      var opts = {
        width : 100,     // 信息窗口宽度
        height: 70,     // 信息窗口高度
        title : "楼盘名：" + c_name , // 信息窗口标题
        offset   : new BMap.Size(-5,-20)    //设置文本偏移量
      }
      var infoWindow = new BMap.InfoWindow("地址：" + c_address, opts);  // 创建信息窗口对象
      map.openInfoWindow(infoWindow,point); //开启信息窗口
      $('.assort_nav').hide();
    }).trigger('click');;
    //楼盘位置
    function curpos(){
      map.clearOverlays();
      //当前楼盘地址
      var marker2 = new BMap.Marker(point);  // 创建标注
      map.addOverlay(marker2);
      var opts = {
        position : point,    // 指定文本标注所在的地理位置
        offset   : new BMap.Size(-45,-50)    //设置文本偏移量
      }
      var label = new BMap.Label("&nbsp;当前楼盘位置&nbsp;", opts);  // 创建文本标注对象
      label.setStyle({
        color : "red",
        fontSize : "12px",
        height : "20px",
        lineHeight : "20px",
        fontFamily:"微软雅黑"
      });
      map.addOverlay(label);
    }
  });
</script>
<script>
$(document).ready(function(e) {
  $(".hx .hx_title i").click(function(){
  $(".hx ul").hide();
  $(this).parent().next().show();  
  $(".hx .hx_title i").removeClass("click");
  $(this).addClass("click");
  });
  
  $(".fh").click(function(){
    $(".periphery_build").hide(); 
    $(".periphery_nav").show();
  });
});
window.onload = function(){
  var oDiv = document.getElementById("msg_nav");
  var h = oDiv.offsetTop;
  document.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if(h <= t){
      oDiv.style.position = 'fixed';
      oDiv.style.top=0;
      $('#void').show();
    }else{
      oDiv.style.position = '';
       $('#void').hide();
      }
  } 
};

  var longitude = $('input[name="jingduMap"]').val();
  var latitude = $('input[name="weiduMap"]').val();
  if(longitude == 0 && latitude == 0){
     longitude = '116.39750';
     latitude = '39.907761';
  }
      // var map2 = new AMap.Map("map1", {
      //     resizeEnable: true,
      //     center:[longitude, latitude],
      //     zoom:15,
      //     zooms:[11,17]
      // });
      // //添加marker点
      // var marker2 = new AMap.Marker({
      //     //icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
      //     position: [longitude, latitude]
      // });
      // marker2.setMap(map2);

    //周边配套
    var map1 = new AMap.Map("map1", {
        resizeEnable: true,
        center:[longitude, latitude],
        zoom:15,
        zooms:[11,17]
    });
    //添加marker点
    var marker1 = new AMap.Marker({
        //icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
        position: [longitude, latitude]
    });
    marker1.setMap(map1);
    //周边点击
    $('.chechData').bind('click',function(){
        var data1 = $(this).attr('attr');
        var data2 = $(this).find('dd').text();
        chechData(data1,data2);
    });

    function chechData(data1,data2){
        $('#soukey').text(data2);
        $('.periphery_nav').hide();
        $('.periphery_build').show();
        map1.clearMap();
        AMap.service(["AMap.PlaceSearch"], function() {
            var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                pageSize: 5,
                type: data1,
                pageIndex: 1,
                center:[longitude, latitude],//城市
                map: map1,
                panel: "panel"
            });
            var cpoint = [longitude, latitude]; //中心点坐标
            placeSearch.searchNearBy('', cpoint, 1000, function(status, result) {
                map1.setZoom(15);
                // map1.panBy(-200,0);
                $('.poi-more').hide(); //详情链接隐藏
            });
        });
    }  
</script>
@endsection