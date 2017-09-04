@extends('mainlayout')
@section('title')
    <title>【{{CURRENT_CITYNAME}}房地产经纪人，{{CURRENT_CITYNAME}}经纪人信息平台】-搜房网</title>
    <meta name="keywords" content="北京搜房网，新房，二手房，租房，写字楼，商铺，金融，房产名人，房产名企，房产名词"/>
    <meta name="description" content="搜房网—中国房地产综合信息门户和交易平台，提供二手房、租房、别墅、写字楼、商铺等交易信息，为客户提供全面的搜房体验和多种比较、为业主和经纪人提供高效的信息推广渠道。为客户提供房产百科全书，包括房产名人，名词，名企，楼盘"/>

@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/detail.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
@include('broker.body1')
<div class="broker_detail">
  <div class="broker_l">
    <div class="msg_list" id="msg_list">
      <div class="broker_nav">
        <a href="{{$hosturl}}/{{$data->id}}-salehouse.html" class="@if(!empty($salehouse)) click @endif" value="salehouse">二手房房源</a>
        <a href="{{$hosturl}}/{{$data->id}}-renthouse.html" class="@if(!empty($renthouse)) click @endif" value="renthouse">租房房源</a>
      </div>
      <div class="content">
      @if(!empty($pageinfo))
        @foreach($pageinfo as $pagek => $pagev)
        <div class="home_list">
          <div class="house_list">
            <dl class="build_msg">
              <dt class="p1"><a href="/esfindex/{{$pagev->id}}/{{$pagev->houseType2}}.html" target="_blank"  class="color2d" value="{{$pagev->id}}">{{$pagev->name}}</a></dt>
              <dd class="p2">
                @if(!empty($pagev->type2))
                @foreach(explode('|', $pagev->type2) as $type2)
                <span class="subway">{{config('communityType2.'. $type2)}}</span>
                @endforeach
                @endif
              </dd>
              <dd class="p2">{{$pagev->address}}</dd>
              <dd class="p3">当前均价
              @if(isset($pagev->avgPrice))
              <span class="colorfe">{{$pagev->avgPrice}}</span>元/月
              @else
              <span class="colorfe">暂无数据</span>
              @endif
              </dd>
              <dd class="p4">环比上月
              @if(isset($pagev->incPrice))
              <span class="color096">↑{{$pagev->incPrice * 100}}%</span>
              @else
              <span class="colorfe">暂无数据</span>
              @endif
              </dd>
            </dl>
            @if(!empty($pagev->list))
            <?php  if(count($pagev->list) < 7){ $cou = count($pagev->list);}else{ $cou = 7; }  ?>
            @for($i=0;$i<$cou;$i++)
            <dl class="build_house">
              <dt>
                <div id="wrapper">
                  <div class="callbacks_container">
                    <ul class="rslides" id="slider4">
                      @if(!empty($pagev->list[$i]->imageList))
                          @foreach($pagev->list[$i]->imageList as $imagev)
                          <li>
                              <a href="/housedetail/sr{{$pagev->list[$i]->id}}.html" target="_blank" title="{{$pagev->list[$i]->title}}">
                                <img data-original="{{get_img_url('houseRent', $imagev, 1)}}" alt="房源图片">
                              </a>
                          </li>
                          @endforeach
                      @elseif(!empty($pagev->list[$i]->thumbPic))
                        <a href="/housedetail/sr{{$pagev->list[$i]->id}}.html" target="_blank" title="{{$pagev->list[$i]->title}}">
                            <img data-original="{{get_img_url('houseRent', $pagev->list[$i]->thumbPic, 1)}}" alt="房源图片">
                        </a>
                      @else
                          <a href="/housedetail/sr{{$pagev->list[$i]->id}}.html" target="_blank" title="{{$pagev->list[$i]->title}}">
                            <img data-original="/image/noImage.png" alt="房源图片">
                          </a>
                      @endif
                    </ul>
                  </div>
                </div>
                <p class="house_img"><i></i>{{count($pagev->list[$i]->imageList)}}
                  @if(!empty($pagev->list[$i]->priceUnit))
                  <?php $priceType = $pagev->list[$i]->priceUnit;  $price = 'price'.$priceType;  ?>
                  <span>{{$pagev->list[$i]->$price}}<span class="font_size">{{config('brokerHousePriceType.'. $priceType)}}</span></span>
                  @endif
                </p>
              </dt>
              <dd>
                <p class="house_name">
                  <a href="/housedetail/sr{{$pagev->list[$i]->id}}.html" target="_blank" title="{{$pagev->list[$i]->title}}">{{$pagev->list[$i]->title}}</a>
                </p>
                <p class="house_type">
                    @if(!empty(explode('_', $pagev->list[$i]->roomStr)[0]))
                        {{explode('_', $pagev->list[$i]->roomStr)[0]}}室/
                    @endif
                    @if(!empty(explode('_', $pagev->list[$i]->roomStr)[1]))
                        {{explode('_', $pagev->list[$i]->roomStr)[1]}}厅/
                    @endif
                    @if(!empty(explode('_', $pagev->list[$i]->roomStr)[2]))
                        {{explode('_', $pagev->list[$i]->roomStr)[2]}}厨/
                    @endif
                    @if(!empty(explode('_', $pagev->list[$i]->roomStr)[3]))
                        {{explode('_', $pagev->list[$i]->roomStr)[3]}}卫/
                    @endif
                    @if(!empty(explode('_', $pagev->list[$i]->roomStr)[4]))
                        {{explode('_', $pagev->list[$i]->roomStr)[4]}}阳台/
                    @endif
                    @if(!empty($pagev->list[$i]->area))
                        {{$pagev->list[$i]->area}}平/
                    @endif

                    @if(!empty($pagev->list[$i]->faceTo))
                        朝向&nbsp;{{config('faceToConfig.'. $pagev->list[$i]->faceTo)}}/
                    @endif
                    &nbsp;
                    @if(!empty($pagev->list[$i]->currentFloor))
                        第{{$pagev->list[$i]->currentFloor}}层
                    @endif
                    @if(!empty($pagev->list[$i]->totalFloor))
                        (共{{$pagev->list[$i]->totalFloor}}层)
                    @endif
                </p>
              </dd>
            </dl>
            @endfor
            @else
            暂无房源
            @endif
          </div>
          @if(count($pagev->list) <= 7)
          <p class="more_house"  style="cursor:pointer;">[&nbsp;共{{count($pagev->list)}}条&nbsp;]</p>
          @else
          <p class="more_house more" style="cursor:pointer;" value="{{$pagev->id}},{{$brokerinfo['id']}},{{$brokerinfo['pagetype']}}" ><a>加载更多&nbsp;</a>[&nbsp;共{{count($pagev->list)}}条&nbsp;]</p>
          @endif
        </div>
        @endforeach
      @else
        <div class="no_state no_border">
          <div class="state_l"><img src="/image/no_state.png" alt="无数据"></div>
          <div class="state_r">
              <p class="p1">很抱歉，该经纪人没有相关的租房房源！</p>
              <!-- <div class="p2">
                  <span class="title">温馨提示</span><br>
                  <span class="state"><span class="dotted"></span>请检查关键词是否正确</span><br>
                  <span class="state"><span class="dotted"></span>尝试切换到其他频道</span><br>
                  <span class="state"><span class="dotted"></span>您可以尝试切换到其他城市</span><br>
              </div> -->
          </div>
        </div>
      @endif
     </div>
    </div>
  </div>
@include('broker.body2')
<div class="list"><div class="page_nav"></div></div>
</div>
@include('broker.footer')
<script src="/js/PageEffects/houseScroll.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/jquery.lazyload.js"></script>
<script>
		$('.content img').lazyload({
			placeholder:'image/noImage.jpg',
			threshold:200,
			failure_limit : 10  
		});
</script>
<script>
$(document).ready(function() {
  $(".fs").mouseover(function(){
    $(this).find(".fs_nav").show();  
  }); 
  $(".fs").mouseout(function(){
    $(this).find(".fs_nav").hide();  
  });
  
  $(".fs_nav a").click(function(){
   $(this).parents(".fs").find("span").text($(this).text());  
   $(this).parent().hide(); 
  });
  $(".msg_top .write_msg").click(function(){
     $(".msg_top .write_content").show();
     $(this).hide();   
   });
});
window.onload = function(){
  var oDiv = document.getElementById("msg_top");
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

/* 图片滚动 */
$(document).ready(function() {
  $(".build_house dt").hover(function(){
   $(this).find(".callbacks_nav").css("display","block");  
  },function(){
   $(this).find(".callbacks_nav").css("display","none");    
  });
});
$(function () {
  $(".rslides").responsiveSlides({
  auto: false,
  pager: false,
  nav: true,
  speed: 500,
  namespace: "callbacks"
  });
});
</script>
@endsection