@include('list.header')
<link rel="stylesheet" type="text/css" href="/css/buildDetail.css?v={{Config::get('app.version')}}">
<!--临时的js -->
<script src="/js/list.js?v={{Config::get('app.version')}}"></script>
<!-- <link rel="stylesheet" href="/houseScroll/style.css?v={{Config::get('app.version')}}"> -->
@yield('xsearch')
  <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
    <input type="hidden" id="linkurl"  value="/{{$fenlei}}/area" >
    <input type="hidden" id="par"  value="" >
<p class="route">
  <span>您的位置：</span>
  <a href="{{url('/')}}">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="/{{$fenlei}}" class="colorfe">{{$cityName}}@if($fenlei == 'shops')商铺@elseif($fenlei == 'office')写字楼@else新房@endif楼盘</a>
</p>

<div class="detail esf_detail">
    <div class="city_msg">
      <dl class="msg_l">
        <dt></dt>
        <dd>
          <p class="p1"><span class="color_blue">@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif</span><a class="color8d"></a></p>
          <p class="p2"><a class="subway">{{!empty($viewShowInfo['type2'])?$viewShowInfo['type2']:''}}</a></p>
        </dd>
      </dl>
     <dl class="msg_r">
        <dt class="color8d">最高价</dt>
        <dd>@if(!empty($viewShowInfo['saleMaxPrice']))<span class="colorfe"> {{$viewShowInfo['saleMaxPrice']}}</span>&nbsp;
            @if(!empty($viewShowInfo['saleMaxPriceUnit']) && $viewShowInfo['saleMaxPriceUnit'] == 2)
                万元/套
            @else
                元/平米
            @endif
            @else 暂无数据 @endif</dd>
      </dl>
      <dl class="msg_r">
        <dt class="color8d"><span class="color2d">最低价</span></dt>
        <dd>@if(!empty($viewShowInfo['saleMinPrice']))<span class="colorfe"> {{$viewShowInfo['saleMinPrice']}}</span>&nbsp;
            @if(!empty($viewShowInfo['saleMinPriceUnit']) && $viewShowInfo['saleMinPriceUnit'] == 2)
                万元/套
            @else
                元/平米
            @endif
            @else 暂无数据 @endif</dd>
      </dl>
      <span class="online"><img alt="买房，租房，上搜房！" src="/image/esfBuild.jpg"></span>
    </div>
  <div class="build">
  	<div style="height: 52px; display: none;" id="void"></div>
    <div class="msg_nav msg_nav1" id="msg_nav">
      <a href="/xinfindex/{{$communityId}}/{{$type2}}.html">楼盘首页</a>
      <a href="/xinfxq/{{$communityId}}/{{$type2}}.html" @if(!empty($xiangqing)) class="nav_click" @endif>楼盘详情</a>
      @if(!in_array($fenlei,['shops','office']))
      <a href="/xinfhx/{{$communityId}}/{{$type2}}.html" @if(!empty($huxing)) class="nav_click" @endif>户型详情</a>
      @endif
      {{--<a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=1" @if(!empty($xiangce)) class="nav_click" @endif >楼盘相册</a>--}}
      <a href="/xinfzs/{{$communityId}}/{{$type2}}.html" @if(!empty($zoushi)) class="nav_click" @endif>房价走势</a>
      <!-- <a href="xfBShow.htm">带看记录</a> -->
      <!-- <a href="xfBComment.htm">客户点评</a> -->
      <!-- <a href="../../../Lists/esfHouseList/esfList-qyss-search.htm">二手房</a> -->
      <!-- <a href="../../../Lists/RentHouseList/zfList-qyss.htm">租房</a> -->
      <div class="clear"></div>
    </div>
  </div>