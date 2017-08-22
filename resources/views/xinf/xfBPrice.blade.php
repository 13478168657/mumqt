@extends('mainlayout')
@section('content')
@include('xinf.left')
<div class="build_price">
  <div class="price_chart">
    <a id="community_type" class="click">楼盘房价走势</a>
    @if(!empty($viewShowInfo["busnessName"]))
    <a id="busness_type">{{$viewShowInfo["busnessName"]}}房价走势</a>
    @endif
  </div>
  <div class="chart">
    <div class="chart_img">
     <div class="room">
      <div class="room_l" id="saleRoomPrice">
  <input type="hidden" id="_token" value="{{ csrf_token() }}" >
        <!--
        <p class="w1 margin_l">
          <span class="p p1">一居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w2">
          <span class="p p1">二居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w3">
          <span class="p p1">三居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w2">
          <span class="p p1">四居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w1">
          <span class="p p1">四居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w2">
          <span class="p p1">四居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w2">
          <span class="p p1">四居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
        <p class="w1 margin_l">
          <span class="p p1">四居室均价(㎡)</span>
          <span class="p"><span class="font_size">46231</span>元</span>
        </p>
      -->
      </div>
      <div class="room_r" id="tag_sale">
        <!--
        <a class="click">一居</a>
        <a>二居</a>
        <a>三居</a>
        <a>四居</a>
        <a>五居</a>
      -->
      </div>
    </div>
  </div>
  <div id="communityChart" style="height: 200px" class="plot"></div>
</div>
</div>
<div class="perimeter">
 <p class="perimeter_title"><!--@if($viewShowInfo['communityName']){{$viewShowInfo['communityName']}}@endif-->周边楼盘房价走势</p>
 <table id="perimeter">
  <tr>
    <th width="31%">楼盘名称</th>
    {{--<th width="35%">趋势图</th>--}}
    <th width="17.25%">当前均价</th>
    <th width="17.25%">涨幅</th>
    <th width="17.25%">历史最高价</th>
    <th width="17.25%">历史最低价</th>
  </tr>
 @if(!empty($commAround))
    @foreach($commAround as $around)
             <?php
                 if($around->_source->id == $communityId) continue;
                 if(empty($type2)){
                     $type2 = '';
                     if(!empty($around->_source->type1)){
                         $ctype1 = substr($around->_source->type1,0,1);
                         foreach(explode('|',$around->_source->type2) as $ctype2){
                             if($ctype1 == substr($ctype2,0,1)){
                                 $type2 = $ctype2;
                                 break;
                             }
                         }
                     }
                 }
             ?>
     <tr>
         <td><a href="/xinfindex/{{$around->_source->id}}/{{$type2}}.html">{{$around->_source->name}}</a></td>
         {{--<td><a class="price_img"><img src="/image/property_img2.jpg" alt=""></a></td>--}}
         <td>@if(!empty($around->_source->newCommunityPriceMap->$type2->saleAvgPrice)){{$around->_source->newCommunityPriceMap->$type2->saleAvgPrice}}
             @if(!empty($around->_source->newCommunityPriceMap->$type2->saleAvgPriceUnit) && $around->_source->newCommunityPriceMap->$type2->saleAvgPriceUnit == 2)
                 万元/套
             @else
                 元/平米
             @endif
             @else {{"待定"}} @endif</td>
         <td>@if(!empty($around->_source->newCommunityPriceMap->$type2->saleIncPrice)){{$around->_source->newCommunityPriceMap->$type2->saleIncPrice}}@else - @endif</td>
         <td>@if(!empty($around->_source->newCommunityPriceMap->$type2->saleMaxPrice)){{$around->_source->newCommunityPriceMap->$type2->saleMaxPrice}}@else - @endif</td>
         <td>@if(!empty($around->_source->newCommunityPriceMap->$type2->saleMinPrice)){{$around->_source->newCommunityPriceMap->$type2->saleMinPrice}}@else - @endif</td>
     </tr>
    @endforeach
 @endif
</table>
</div>
</div>
<script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>
<script>
var g_communityid={{$communityId}};
var tempType2={{$type2}};
var busnessId={{$viewShowInfo["busnessId"]}};
var _token=$('#_token').val();

$(document).ready(function(e) {
  $(".hx .hx_title i").click(function(){
    $(".hx ul").hide();
    $(this).parent().next().show();  
    $(".hx .hx_title i").removeClass("click");
    $(this).addClass("click");
  });

  $(".build_house .home_info ul li a").click(function(){
   if($(this).attr("class")=="") {
    $(this).parent().find("a").removeClass("click");
    $(this).addClass("click"); 
  }else if($(this).attr("class")=="click"){
    $(this).removeClass("click");  
  }
});

  $('.price_chart a').click(function(){
    var dataType=$(this).attr('id');
    //console.info(dataType);
    $('.price_chart a').removeClass("click");
    $(this).addClass('click');
    getSalePrice(g_communityid,'sale',tempType2,'2',dataType,busnessId);
  });
var dataType= $('.price_chart .click').attr('id');
 getSalePrice(g_communityid,'sale',tempType2,'2',dataType,busnessId);

});

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


function getRoomByTag(strTag)
{
  if (strTag=='一居室') {
    return '1';
  }else if(strTag=='二居室')
  {
    return '2';
  }else if(strTag=='三居室')
  {
    return '3';
  }else if(strTag=='四居室')
  {
    return '4';
  }else if(strTag=='五居室')
  {
    return '5';
  }else if(strTag=='六居室')
  {
    return '6';
  }else if(strTag=='七居室')
  {
    return '7';
  }else if(strTag=='八居室')
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


var dataType= $('.price_chart .click').attr('id');
 getSalePrice(g_communityid,'sale',tempType2,room,dataType);


}

function getSalePrice(g_communityid,saleRent,tempType2,room,datatype,busnessId)
{
  var type='2';
  if (saleRent=='sale') {
    type='1';
  }
 // var tempType2=$('#saleTagId .click').attr('id');

 $.post('/ajax/checkprice',{'comid':g_communityid,'busness':busnessId,'type':type,'ctype2':tempType2,'datatype':datatype,'_token':_token,'room':room,'benew':'1'},function(d){
 // console.info(d);
  if (saleRent=='sale') {
    showCharts(d.title,d.time,d.price,'元/平米');  
  }else
  {
    showCharts(d.title,d.time,d.price,'元/月');  
  }
  var roomTagHtml='';
  for (var i = 0;i<d.roomTags.length ; i++) {
    if (d.curtRoom==d.roomTags[i]) {
     roomTagHtml+='<a class="click" onClick="clickRoomTag(this)">'+d.roomTags[i]+'</a>';
   }else
   {
    roomTagHtml+='<a onClick="clickRoomTag(this)">'+d.roomTags[i]+'</a>';
  }

}


$('#tag_sale').html(roomTagHtml);



},'json');

}

function showCharts (title,artime,arprice,tag) { 
//function showRentMap (arTime,arPrice,priceTitle) { 
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
  //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655','#FFF263', '#6AF9C4'] ,
  tooltip: { 
      //valueSuffix: '元'
      formatter: function () {
        var tempvalue;
        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' '+tag;
        return tempvalue;
      }
    }, 
    legend: { 
      enabled: false, 
      layout: 'horizontal', 
      align: 'right',
      verticalAlign: 'top', 
     // x: 250,
      //y: 10,
      borderWidth: 0,
      //lineHeight: 30,

    },

    series:arprice 
    // series: [
    // { name: 'Tokyo', data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 0, 9.6] }, 
    // { name: 'New York', data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5] }, 
    // { name: 'Berlin', data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0] },
    //  // { data: arPrice }
    //  ]

  });
}

</script>
@endsection