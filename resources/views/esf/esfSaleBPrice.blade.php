@extends('mainlayout')
@section('title')
<title>【{{CURRENT_CITYNAME}}{{$commName}}楼盘房价走势,二手房,租房】-搜房网</title>
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
  <div class="build_price">
    <div id='comsaleprice' class="price_chart">
      <a  id="community_type" class="click">楼盘房价走势</a>
        @if(!empty($busnessName))
            <a  id="busness_type">{{$busnessName}}房价走势</a>
        @endif
     </div>
    <div class="chart">
      <div class="chart_img">
       <div class="room">
        <div class="room_l" id="saleRoomPrice">
        </div>
        <div class="room_r" id="tag_sale">
        </div>
      </div>
    </div>
    <div id="communityChart" style="height: 200px"  class="plot"></div>
  </div>
</div>
<div class="build_price">
  <div id='comrentprice' class="price_chart">
    <a  id="community_type" class="click">楼盘租金走势</a>
      @if(!empty($busnessName))
    <a  id="busness_type">{{$busnessName}}租金走势</a>
      @endif
  </div>
  <div class="chart">
    <div class="chart_img">
     <div class="room">
      <div class="room_l" id="rentRoomPrice">
      </div>
      <div class="room_r" id="tag_rent">
      </div>
    </div>
  </div>
  <div id="communityRentChart" style="height: 200px" class="plot"></div>
</div>
</div>
<div class="district float_left">
 <div class="zf_five">
   <p>{{$busnessName}}板块小区房价涨幅前5名</p>
   <ul>
    @if(!empty($priceDescTop_5))
    <?php $num = 1;  ?>
    @foreach($priceDescTop_5 as $key => $val)
    <?php
            if(!empty( $val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase) && $val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase < 0 ){
                continue;
            }
    $tempType2 = '';
    if(!empty($val->_source->type2) && !empty($val->_source->oldCommunityPriceMap)){
     foreach(explode('|',$val->_source->type2) as $ctype2){
       if(!empty(json_decode(json_encode($val->_source->oldCommunityPriceMap), true)[2][$ctype2])){
         $tempType2 = $ctype2;
         break;
       }
     }
   }
   ?>
   <li>
     <span class="span1">{{$num++}}、</span>
     <a href="/esfindex/{{$val->_source->id}}/{{$type2}}.html">{{$val->_source->name}}</a>
     <span class="span2">
      @if(!empty($val->_source->oldCommunityPriceMap) && !empty( $val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->avgPrice))
      ￥{{$val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->avgPrice}}</span><span>/平米</span>
      @else
      暂无数据</span>
      @endif
      <span class="colorfe span3">
        @if(!empty($val->_source->oldCommunityPriceMap) && !empty($val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase))
        ↑{{$val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase * 100}}%
        @else
        暂无数据
        @endif
      </span>
    </li>
    @endforeach
    @else
    <li>暂无数据</li>
    @endif
  </ul>
</div>
<div class="zf_five">
 <p>{{$busnessName}}板块小区房价跌幅前5名</p>
 <ul>
  @if(!empty($priceAscTop_5))
  <?php $num = 1;  ?>
  @foreach($priceAscTop_5 as $key => $val)
  <?php
      if(!empty( $val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase) && $val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase > 0 ){
          continue;
      }
  $tempType2 = '';
  if(!empty($val->_source->type2) && !empty($val->_source->oldCommunityPriceMap)){
   foreach(explode('|',$val->_source->type2) as $ctype2){
     if(!empty(json_decode(json_encode($val->_source->oldCommunityPriceMap), true)[2][$ctype2])){
       $tempType2 = $ctype2;
       break;
     }
   }
 }
 ?>
  <li>
      <span class="span1">{{$num++}}、</span>
      <a href="/esfindex/{{$val->_source->id}}/{{$type2}}.html">{{$val->_source->name}}</a>
      <span class="span2">
      @if(!empty($val->_source->oldCommunityPriceMap) && !empty( $val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->avgPrice))
             ￥{{$val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->avgPrice}}</span><span>/平米</span>
          @else
              暂无数据</span>
          @endif
          <span class="color096 span3">
        @if(!empty($val->_source->oldCommunityPriceMap) && !empty($val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase))
                  ↓{{$val->_source->oldCommunityPriceMap->r2->{'t'.$type2}->increase * 100}}%
              @else
                  暂无数据
              @endif
      </span>
  </li>
  @endforeach
  @else
  <li>暂无数据</li>
  @endif
</ul>
</div>
</div>
<!-- <div class="district">
 <div class="zf_five">
   <p>百子湾板块小区租金涨幅前5名</p>
   <ul>
     <li>
       <span class="span1">1、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="colorfe span3">↑3.50%</span>
     </li>
     <li>
       <span class="span1">2、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="colorfe span3">↑3.50%</span>
     </li>
     <li>
       <span class="span1">3、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="colorfe span3">↑3.50%</span>
     </li>
     <li>
       <span class="span1">4、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="colorfe span3">↑3.50%</span>
     </li>
     <li>
       <span class="span1">5、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="colorfe span3">↑3.50%</span>
     </li>
   </ul>
 </div>
 <div class="zf_five">
   <p>百子湾板块小区租金跌幅前5名</p>
   <ul>
     <li>
       <span class="span1">1、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="color096 span3">↓3.50%</span>
     </li>
     <li>
       <span class="span1">2、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="color096 span3">↓3.50%</span>
     </li>
     <li>
       <span class="span1">3、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="color096 span3">↓3.50%</span>
     </li>
     <li>
       <span class="span1">4、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="color096 span3">↓3.50%</span>
     </li>
     <li>
       <span class="span1">5、</span>
       <a href="#">金都心语</a>
       <span class="span2">￥1000</span>
       <span>/月</span>
       <span class="color096 span3">↓3.50%</span>
     </li>
   </ul>
 </div>
</div> -->
</div>
<script src="/js/highcharts/jquery-1.8.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>
<script>
var communityId='{{$communityId}}';
var cType2='{{$type2}}';
var busnessId='{{$businessAreaId}}';
var dataType='';

var _token=$('input[name="_token"]').val();
$(document).ready(function(e) {
  $(".room .room_r a").click(function(){
    $(this).parent().find("a").removeClass("click");  
    $(this).addClass("click");
  });
  var room='2';
  if (parseInt(cType2)==304) {
    room='3';
  }

  $('.price_chart a').click(function(){
   $(this).parent().find('a').removeClass('click');
   $(this).addClass("click"); 
   dataType=$(this).attr('id');
   var saleRent='rent';
   if ($(this).parent().attr('id')=='comsaleprice') {
    saleRent='sale';
  }
  getSalePrice(communityId,saleRent,cType2,room,dataType,busnessId);

});


  getSalePrice(communityId,'sale',cType2,room,'community_type',busnessId);
  getSalePrice(communityId,'rent',cType2,room,'community_type',busnessId);
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

function getRoomByTag(strTag)
{
  if (strTag=='一居') {
    return '1';
  }else if(strTag=='二居')
  {
    return '2';
  }else if(strTag=='三居')
  {
    return '3';
  }else if(strTag=='四居')
  {
    return '4';
  }else if(strTag=='五居')
  {
    return '5';
  }else if(strTag=='六居')
  {
    return '6';
  }else if(strTag=='七居')
  {
    return '7';
  }else if(strTag=='八居')
  {
    return '8';
  }
  return '2';

}

function clickRoomTag(obj)
{

  $(obj).parent().find("a").removeClass("click");  
  $(obj).addClass("click");
  room=getRoomByTag($(obj).text());
  var tagType=$(obj).parent().attr('id');
  var beSale='sale';
  if (tagType=='tag_sale') {
    dataType=$('#comsaleprice .click').attr('id');
    beSale='sale';
  }else
  {
    dataType=$('#comrentprice .click').attr('id');
    beSale='rent';
  }


  getSalePrice(communityId,beSale,cType2,room,dataType,busnessId);
}

function getSalePrice(g_communityid,saleRent,tempType2,room,datatype,busnessid)
{
  var type='1';
  if (saleRent=='sale') {
    type='2';
  }
 // var tempType2=$('#saleTagId .click').attr('id');

 var rentUnit='元/月';
 if (parseInt(tempType2)<300) {
  rentUnit='元/天/平米';
}


$.post('/ajax/checkprice',{'busness':busnessid,'comid':g_communityid,'type':type,'ctype2':tempType2,'datatype':datatype,'_token':_token,'room':room,'benew':'0'},function(d){
 // console.info(d);
 if (saleRent=='sale') {
  showCharts(d.title,d.time,d.price);  
}else
{
  showRentCharts(d.title,d.time,d.price,rentUnit);  
}
var roomTagHtml='';
var beSelect=false;
for (var i = 0;i<d.roomTags.length ; i++) {
  if (d.curtRoom==d.roomTags[i]) {
    beSelect=true;
    roomTagHtml+='<a class="click" onClick="clickRoomTag(this)">'+d.roomTags[i]+'</a>';
  }else
  {
    roomTagHtml+='<a onClick="clickRoomTag(this)">'+d.roomTags[i]+'</a>';
  }

}

if (saleRent=='sale') {
  $('#tag_sale').html(roomTagHtml);
  if(!beSelect&&$('#tag_sale a').first().length>0)
  {
    $('#tag_sale a').first().addClass('click');
  }
}else
{
  $('#tag_rent').html(roomTagHtml);
  if(!beSelect&&$('#tag_rent a').first().length>0)
  {
    $('#tag_rent a').first().addClass('click');
  }
}
},'json');
}

function showCharts (title,artime,arprice) { 

  //console.info(arprice);
  $('#saleRoomPrice').html(title);
  //var priceTitle=title;
  $('#communityChart').html('');
  $('#communityChart').highcharts({ 
    title: { text:'', x: 0}, 
    // subtitle: { text: 'Source: WorldClimate.com', x: -20 }, 
    credits:enabled=false,
    xAxis: { categories: artime,
      tickInterval: 1,
      labels: {
        formatter: function () {
         return this.value.toString().substr(4,2)+"月";
       }
     }
   }, 
   yAxis: { 
    title: { text: null },
    plotLines: [{ value: 0, width: 1, color: '#808080' }], 
    lineWidth: 1,
    labels: {
      formatter: function () {
       return Highcharts.numberFormat(this.value,0,'.',',');
     }
   }


 },

  tooltip: { 
      formatter: function () {
        var tempvalue;
        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' 元/平米';
        return tempvalue;
      }
    }, 
    legend: { 
      enabled: false, 
      layout: 'horizontal', 
      align: 'right',
      verticalAlign: 'top', 
      borderWidth: 0,
    },
    series:arprice 
  });
}


function showRentCharts (title,artime,arprice,unit) { 
//function showRentMap (arTime,arPrice,priceTitle) { 
  //console.info(arprice);
  $('#rentRoomPrice').html(title);
  //var priceTitle=title;
  $('#communityRentChart').html('');
  $('#communityRentChart').highcharts({ 
    title: { text:'', x: 0}, 
    // subtitle: { text: 'Source: WorldClimate.com', x: -20 }, 
    credits:enabled=false,
    xAxis: { categories: artime,
      tickInterval: 1,
      labels: {
        formatter: function () {
         return this.value.toString().substr(4,2)+"月";
       }
     }
   }, 
   yAxis: { 
    title: { text: null },
    plotLines: [{ value: 0, width: 1, color: '#808080' }], 
    lineWidth: 1,
    labels: {
      formatter: function () {
       return Highcharts.numberFormat(this.value,0,'.',',');
     }
   }


 },
  //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655','#FFF263', '#6AF9C4'] ,
  tooltip: { 
      //valueSuffix: '元'
      formatter: function () {
        var tempvalue;
        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' '+unit;
        return tempvalue;
      }
    }, 
    legend: { 
      enabled: false, 
      layout: 'horizontal', 
      align: 'right',
      verticalAlign: 'top', 
      borderWidth: 0,
    },
    series:arprice 
  });
}
</script>
@endsection
