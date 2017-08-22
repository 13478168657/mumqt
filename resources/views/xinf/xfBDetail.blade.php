@extends('mainlayout')
@section('content')
@include('xinf.left')
  <div class="event_detail">
    <h2>基本信息</h2>
    <ul class="build_info">
      @if(!empty($viewShowInfo['type2']))
      <li>
        <span class="caption">物业类别：</span>
        <span class="caption_msg">{{$viewShowInfo['type2']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['address']))
      <li>
        <span class="caption">楼盘地址：</span>
        <span class="caption_msg">{{$viewShowInfo['address']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['tagsName']))
      <li>
        <span class="caption">项目特色：</span>
        <span class="caption_msg">{{trim($viewShowInfo['tagsName'],',')}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['structure']))
      <li>
        <span class="caption">建筑类别：</span>
        <span class="caption_msg">{{$viewShowInfo['structure']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['decoration']))
      <li>
        <span class="caption">装修状况：</span>
        <span class="caption_msg">{{$viewShowInfo['decoration']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['loopLineName']))
      <li>
        <span class="caption">环线位置：</span>
        <span class="caption_msg">{{$viewShowInfo['loopLineName']}}</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->volume))
      <li>
        <span class="caption">容&nbsp; 积&nbsp;率：</span>
        <span class="caption_msg">{{$type2GetInfo->volume}}</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->greenRate))
      <li>
        <span class="caption">绿&nbsp; 化&nbsp;率：</span>
        <span class="caption_msg">{{$type2GetInfo->greenRate}}%</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['openTime']))
      <li>
        <span class="caption">开盘时间：</span>
        <span class="caption_msg">{{$viewShowInfo['openTime']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['takeTime']))
      <li>
        <span class="caption">交房时间：</span>
        <span class="caption_msg">预计{{$viewShowInfo['takeTime']}}</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->propertyFee))
      <li>
        <span class="caption">物&nbsp; 业&nbsp;费：</span>
        <span class="caption_msg"> {{$type2GetInfo->propertyFee}}元/平米·月 </span>
      </li>
      @endif
      @if(!empty($viewShowInfo['propertyName']))
      <li>
        <span class="caption">物业公司：</span>
        <span class="caption_msg">{{$viewShowInfo['propertyName']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['developerName']))
      <li>
        <span class="caption">开&nbsp; 发&nbsp;商：</span>
        <span class="caption_msg">{{$viewShowInfo['developerName']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['preSalePermit']))
      <li>
        <span class="caption">预售许可证：</span>
        <span class="caption_msg">{{$viewShowInfo['preSalePermit']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['propertyAddress']))
      <li>
        <span class="caption">物业地址：</span>
        <span class="caption_msg">{{$viewShowInfo['propertyAddress']}}</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->floorSpace))
      <li>
        <span class="caption">占地面积：</span>
        <span class="caption_msg">{{$type2GetInfo->floorSpace}}平方米 </span>
      </li>
      @endif
      @if(!empty($type2GetInfo->floorage))
      <li>
        <span class="caption">建筑面积：</span>
        <span class="caption_msg">{{$type2GetInfo->floorage}}平方米</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->startTime))
      <li>
        <span class="caption">开工时间：</span>
        <span class="caption_msg">{{date('Y-m-d',$type2GetInfo->startTime)}}</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->endTime))
      <li>
        <span class="caption">竣工时间：</span>
        <span class="caption_msg">{{date('Y-m-d',$type2GetInfo->endTime)}}</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->propertyYear))
      <li>
        <span class="caption">产权年限：</span>
        <span class="caption_msg">{{$type2GetInfo->propertyYear}}年</span>
      </li>
      @endif
      @if(!empty($type2GetInfo->houseTotal))
      <li>
        <span class="caption">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数：</span>
        <span class="caption_msg">总户数@if(!empty($type2GetInfo->houseTotal)) {{$type2GetInfo->houseTotal}}户 @endif @if(!empty($viewShowInfo['houseNum'])) 当期户数{{$viewShowInfo['houseNum']}}户 @endif</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['gongshui']))
      <li>
        <span class="caption">供&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;水：</span>
        <span class="caption_msg">{{$viewShowInfo['gongshui']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['gongnuan']))
      <li>
        <span class="caption">采&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;暖：</span>
        <span class="caption_msg">{{$viewShowInfo['gongnuan']}}</span>
      </li>
      @endif
      @if(!empty($viewShowInfo['gongdian']))
      <li>
        <span class="caption">供&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;电：</span>
        <span class="caption_msg">{{$viewShowInfo['gongdian']}}</span>
      </li>
      @endif
    </ul>
    <h2>历史价格</h2>
    <div class="build_price1 marginT">
      <table class="ban">
        <tr>
          <th width="15%">时间</th>
          <th width="15%">最高价</th>
          <th width="15%">均价</th>
          <th width="15%">最低价</th>
          <th width="30%">价格描述</th>
        </tr>
      @if(!empty($communityStatus))
        @foreach($communityStatus as $status)
        <tr>
          <td>{{date('Y-m-d',strtotime($status->changeTime.'01'))}}</td>
          <td>{{$status->maxPrice or '-'}}元/平方米</td>
          <td>{{$status->avgPrice or '-'}}元/平方米</td>
          <td>{{$status->minPrice or '-'}}元/平方米</td>
          <td>{{$status->description or ''}}</td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="8">暂无数据</td>
        </tr>
      @endif
      </table>
    </div>
    <div class="house_type">
      <h2>项目配套</h2>
      <div class="map xf_map">
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
    </div>
    @if(!empty($periodBuildData))
    <h2>楼层状况</h2>
    <div class="build_price1 marginT">
      <table class="ban">
        <tr>
          <th width="15%">期数名称</th>
          <th width="15%">楼栋名称</th>
          <th width="15%">总户数</th>
          <th width="15%">单元数量</th>
          <th width="30%">具体户型</th>
        </tr>
      </table>
          <?php $i = 0;?>
          @foreach($periodBuildData as $k=>$period)
            <?php
             $i++;
            if(substr($k,6) == 1){
              $qi = '一期';
            }elseif(substr($k,6) == 2){
              $qi = '二期';
            }elseif(substr($k,6) == 3){
              $qi = '三期';
            }elseif(substr($k,6) == 4){
              $qi = '四期';
            }elseif(substr($k,6) == 5){
              $qi = '五期';
            }elseif(substr($k,6) == 6){
              $qi = '六期';
            }elseif(substr($k,6) == 7){
              $qi = '七期';
            }elseif(substr($k,6) == 8){
              $qi = '八期';
            }elseif(substr($k,6) == 9){
              $qi = '九期';
            }elseif(substr($k,6) == 10){
              $qi = '十期';
            }elseif(substr($k,6) == 11){
              $qi = '十一期';
            }elseif(substr($k,6) == 12){
              $qi = '十二期';
            }elseif(substr($k,6) == 13){
              $qi = '十三期';
            }else{
              $qi = '十三期以上';
            }
            ?>
          @if($i == 1)
            <table class="ban">
          @else
             <table class="ban ban_hide" style="display: none;">
          @endif
               @if(!empty($period))
                 <tr><td width="15%" rowspan="{{count($period)+1}}">{{$qi}}</td></tr>
                  @foreach($period as $per)
                    <tr>
                      <td width="15%">{{$per->num}}</td>
                      <td width="15%">{{!empty($per->houseTotal)?$per->houseTotal.'户':'暂无数据'}}</td>
                      <td width="15%">{{$per->unitTotal}}个</td>
                      <td width="30%">{{$per->roomName}}</td>
                    </tr>
                  @endforeach
               @endif
            </table>
          @endforeach

      @if(!empty($periodBuildData) && count($periodBuildData) > 1)
        <div class="open"><i class=""></i></div>
      @endif
    </div>
    @endif
    @if(!empty($viewShowInfo['parkingIntro']))
    <h2>车位信息</h2>
    <p class="traffic">{{$viewShowInfo['parkingIntro']}}</p>
    @endif
    @if(!empty($viewShowInfo['intro']))
    <h2>项目简介</h2>
    <p class="traffic">{{$viewShowInfo['intro']}}</p>
    @endif
  </div>
</div>
<script src="/js/specially/headNav.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{config('mapApiKey.baidu')}}"></script>
<input type="hidden" name="jingduMap" value="{{!empty($jingduMap)?$jingduMap:0}}">
<input type="hidden" name="weiduMap" value="{{!empty($weiduMap)?$weiduMap:0}}">

<script type="text/javascript">
  $(function(){
    //经纬度
    var longitude = $('input[name="jingduMap"]').val();
    var latitude = $('input[name="weiduMap"]').val();
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
      var c_name = "{{$viewShowInfo['communityName'] or '暂无'}}";
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
});
window.onload = function(){
  var oDiv = document.getElementById("msg_nav");
  var h = oDiv.offsetTop;
  document.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if(h<t){
	      oDiv.style.position = 'fixed';
				oDiv.style.top=0;
				$('#void').show();
	    }else{
	      oDiv.style.position = 'static';
	      $('#void').hide();
	      }
  } 
};

$(".build_price1 .open i").click(function(){
   if($(this).attr("class")==""){ 
    $(this).addClass("click");
    $(this).parents(".build_price1").find(".ban_hide").show();  
   }else{
    $(this).removeClass("click");
    $(this).parents(".build_price1").find(".ban_hide").hide(); 
   }
  
});

</script>
@endsection