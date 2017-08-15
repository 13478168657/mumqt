<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/8
 * Time: 15:56
 */

  // 主页Blade文件 继承 View下的MainLayout文件
  //因此不需要再此文件中加入html头等元素 只需要将主页业务放置到这里
?>
@extends('mainlayout',['index'=>1])
@section('title')
<title>【搜房网】房地产门户|房地产网|搜房</title>
<meta name="keywords" content="{{CURRENT_CITYNAME}}房产,搜房网,搜房,买房,租房,新房,二手房,写字楼,商铺,豪宅,别墅"/>
<meta name="description" content="搜房网是中国房地产信息平台，搜房网提供全面实时的房地产资讯内容，为广大网民提供专业的新房、二手房、租房、豪宅别墅、写字楼、商铺等全方位资讯信息。为业主、客户及房地产业内精英们提供高效专业的信息推广服务。"/>
@endsection
{{--头部样式--}}
@section('head')
<?php //<link rel="stylesheet" type="text/css" href="/css/index.css?v={{Config::get('app.version')}}"> ?>
@endsection
@section('content')
{{--搜索加导航 开始--}}
<div class="index_top">
 <!-- Slideshow -->
 <div class="callbacks_container">
         <script type="text/javascript" src="/adShow.php?position=1&cityId={{CURRENT_CITYID}}"></script>
   {{--广告图片开始--}}
<!--   <ul class="rslides" id="slider">
      @if(!empty($ad_arr[1002]))
          @foreach($ad_arr[1002] as $val)
               <li style="background:url({{get_img_url('ad', $val->fileName)}}) no-repeat top;">
                   @if(!empty($val->url))
                       <a class="banner_img" href="{{$val->url}}" target="_blank">
                       </a>
                   @endif
                   <a  href="{{$val->url}}" class="banner_tlt"  target="_blank">广告&nbsp;&nbsp;{{$val->name}}</a>
               </li>
           @endforeach
      @endif
   </ul>-->
   {{--广告图片结束--}}
 </div>
 <div class="search" style="z-index:90;">
  @if(in_array(CURRENT_CITYPY, config('openCity')))
   <div class="nav">
     <a class="nav1 click" id="home3" value="/esfsale" mapvalue="/map/sale/house" onClick="setContentTab('home',3)">二手房<i></i></a>
     <a class="nav2" id="home4" value="/esfrent" mapvalue="/map/rent/house" onClick="setContentTab('home',4)">租房<i></i></a>
     <a class="nav2" id="home2" value="/new" onClick="setContentTab('home',2)">新房<i></i></a>
     <a class="nav2" id="home5" value="/xzlrent" mapvalue="/map/rent/office" onClick="setContentTab('home',5)">写字楼<i></i></a>
     <a class="nav2" id="home6" value="/sprent" mapvalue="/map/rent/shops" onClick="setContentTab('home',6)">商铺<i></i></a>
     <a class="nav2" id="home1" value="/checkpricelist" onClick="setContentTab('home',1)">查房价<i></i></a>
     <div class="clear"></div>
   </div>
   @else
   <!--无新房的样式-->
   <div class="nav nav_width">
     <a class="nav1 click" id="home3" value="/esfsale" mapvalue="/map/sale/house" onClick="setContentTab('home',3)">二手房<i></i></a>
     <a class="nav2" id="home4" value="/esfrent" mapvalue="/map/rent/house" onClick="setContentTab('home',4)">租房<i></i></a>
     <a class="nav2" id="home5" value="/xzlrent" mapvalue="/map/rent/office" onClick="setContentTab('home',5)">写字楼<i></i></a>
     <a class="nav2" id="home6" value="/sprent" mapvalue="/map/rent/shops" onClick="setContentTab('home',6)">商铺<i></i></a>
     <a class="nav2" id="home1" value="/checkpricelist" onClick="setContentTab('home',1)">查房价<i></i></a>
   </div>
   @endif
   <div class="search_txt" id="con_home_1" style=" display:none;">
     <div class="txt_r">
       <div class="div">
        <form action="/checkpricelist" id="checkprice" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <input type="text" class="txt w1 searchInput" tp="loupan" AutoComplete="off" name="kw" placeholder="请输入小区名称或地址，了解自己的房子什么价？" value="" >
          <div class="mai">
          </div>
        </form>
       </div>
       <div class="div"><input type="button" onclick="lastSearchPrice($('input[tp=loupan]'));$('#checkprice').submit();" class="btn" value="查房价"></div>
     </div>
   </div>
   <div class="search_txt" id="con_home_2" style=" display:none;">
     <div class="txt_r">
       <div class="div">
        <input type="text" class="txt w1 searchInput" tp="new" AutoComplete="off" placeholder="请输入关键字（楼盘名或地点）？" value="" >
        <div class="mai">
        </div>
       </div>
         {{--<div class="div"><input type="button" class="search_btn soufang click ss" value="搜房"><input type="button" class="search_btn map ms" value="地图"></div>--}}
         <div class="div"><input type="button" class="btn click ss" value="搜房"></div>
     </div>
   </div>
   <div class="search_txt" id="con_home_3">
     <div class="txt_r">
       <div class="div">
        <input type="text" class="txt w2 searchInput" tp="sale" AutoComplete="off" placeholder="请输入关键字（楼盘名或地点）？" value="" >
        <div class="mai mai1">
        </div>
       </div>
       <div class="div"><input type="button" class="search_btn soufang click ss" value="搜房"></div>
     </div>
   </div>
   <div class="search_txt" id="con_home_4" style=" display:none;">
     <div class="txt_r">
       <div class="div">
        <input type="text" class="txt w2 searchInput" tp="rent" AutoComplete="off" placeholder="请输入关键字（楼盘名或地点）？" value="" >
        <div class="mai mai1">
        </div>
       </div>
       <div class="div"><input type="button" class="search_btn soufang click ss" value="搜房"></div>
     </div>
   </div>
   <div class="search_txt" id="con_home_5" style=" display:none;">
     <div class="txt_r">
       <div class="div">
        <input type="text" class="txt w2 searchInput" tp="xzl" AutoComplete="off" placeholder="请输入关键字（楼盘名或地点）？" value="" >
        <div class="mai mai1">
        </div>
       </div>
       <div class="div"><input type="button" class="search_btn soufang click ss" value="搜房"></div>
     </div>
   </div>
   <div class="search_txt" id="con_home_6" style=" display:none;">
     <div class="txt_r">
       <div class="div">
        <input type="text" class="txt w2 searchInput" tp="sp" AutoComplete="off" placeholder="请输入关键字（楼盘名或地点）？" value="" >
        <div class="mai mai1">
        </div>
       </div>
       <div class="div"><input type="button" class="search_btn soufang click ss" value="搜房"></div>
     </div>
   </div>
   <!-- 搜索提交  start -->
    <form action="/esfsale" id="search_Submit" method="get">
      <input type="hidden" id="search_Intro" name="kw" value="">
    </form>
    <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
   <!-- 提过提交  end   -->
   <div class="footmark" style="display:block;" >
     <span class="mark_l"  >上次搜索:<a id="lastSearch" target="_blank"></a></span>
       @if(in_array(CURRENT_CITYPY, config('openCity')))
     <!-- 预留 猜你喜欢 -->
     <span class="mark_l mark_r">
      猜你喜欢:
      <a href="http://bj.{{config('session.domain')}}/xinfindex/927/301.html">WE+北京</a>
      <a href="http://bj.{{config('session.domain')}}/xinfindex/961/305.html">盘古大观</a>
     </span>
     @endif
     <div class="clear"></div>
   </div>
   <div class="clear"></div>
 </div>
 <div class="clear"></div>
</div>
{{--搜索加导航 结束--}}
<!--主体内容 开始-->
<div class="subnav">
<div class="subnav_msg">
  <dl>
    <dt><a href="/esfsale/area" title="搜房网买房">买房</a></dt>
    @if(in_array(CURRENT_CITYPY, config('openCity')))
    <dd>
      <p><a href="/new/area" class="color_red">新房</a><a href="/checkpricelist/sale" class="color_red">查房价</a></p>
      <p><a href="/esfsale/area">二手房</a><a href="/saleesb/area">找小区</a></p>
    </dd>
    @else
    <dd>
      <p><a href="/esfsale/area">二手房</a><a href="/bssale/area">豪宅别墅</a></p>
      <p><a href="/checkpricelist/sale" class="color_red">查房价</a><a href="/saleesb/area">找小区</a></p>
    </dd>
    @endif
  </dl>
  <span class="dotted"></span>
  <dl>
    <dt><a href="/esfrent/area/ar1" title="搜房网租房">租房</a></dt>
    <dd>
      <p><a href="/esfrent/area/ar1" class="color_red">整租</a><a href="/bsrent/area">豪宅别墅</a></p>
      <p><a href="/esfrent/area/ar2">合租</a>{{--<a href="/checkpricelist/rent">租价查询</a>--}}</p>
    </dd>
  </dl>
  <span class="dotted"></span>
  <dl>
    <dt><a href="/xzlrent/area" title="搜房网商业">商业</a></dt>
    <dd>
      <p><a class="color_red" href="/xzlrent/area">写字楼出租</a><a class="color_red" href="/sprent/area">商铺出租</a></p>
      <p><a href="/xzlsale/area">写字楼出售</a><a href="/spsale/area">商铺出售</a></p>
    </dd>
  </dl>
  <span class="dotted"></span>
   <dl>
    <dt><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=2" title="搜房网理财推荐">理财</a></dt>
    <dd>
      <p><a class="color_red" href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=2" target="_blank">我要理财</a><a href="http://fang.hlej.com/?chanel=soufang" target="_blank">我要贷款</a></p>
      <p><a href="https://www.huilc.cn/front/borrow/noviceBorrow?channel=soFang&usrChannel=15&usrWay=1" target="_blank">新人壕礼</a></p>
    </dd>
  </dl>
  <span class="dotted"></span>
  <dl>
    <dt><a href="{{config('hostConfig.baike_host')}}" title="搜房网百科">百科</a></dt>
    <dd>
      <p><a href="{{config('hostConfig.baike_host')}}/index.php?list-property" class="color_red">楼盘词典</a><a href="{{config('hostConfig.baike_host')}}/index.php?list-words">行业名词</a></p>
      <p><a href="{{config('hostConfig.baike_host')}}/index.php?list-mingqi">业界名企</a><a href="{{config('hostConfig.baike_host')}}/index.php?list-mingren">业界名人</a></p>
    </dd>
  </dl>
</div>
</div>
<script type="text/javascript" src="/adShow.php?position=2&cityId={{CURRENT_CITYID}}"></script>
<div class="container">
    {{--计算显示记录数量--}}
    <?php $ad_arr_2001_count = count($ad_arr[2001]); shuffle($ad_arr[2001]); ?>
    <?php //$ad_arr_2001_count = $ad_arr_2001_count - ($ad_arr_2001_count % 4); ?>
    <?php $ad_arr_2001_count = $ad_arr_2001_count>8?8:$ad_arr_2001_count; ?>
    <?php $ad_arr_2002_count = count($ad_arr[2002]); shuffle($ad_arr[2002]); ?>
    <?php $ad_arr_2002_count = $ad_arr_2002_count - ($ad_arr_2002_count % 4); ?>
    <?php $ad_arr_2002_count = $ad_arr_2002_count>8?8:$ad_arr_2002_count; ?>
    <?php $ad_arr_2003_count = count($ad_arr[2003]); shuffle($ad_arr[2003]); ?>
    <?php $ad_arr_2003_count = $ad_arr_2003_count - ($ad_arr_2003_count % 4); ?>
    <?php $ad_arr_2003_count = $ad_arr_2003_count>8?8:$ad_arr_2003_count; ?>
    {{--新房--}}
    @if($ad_arr_2001_count)
    <div class="buildings" id="newHouse">
        <h2 class="clearfix">
            <div class="l_linear fl"><i></i></div>
            <dl class="fl">
                <a href="/new/area" alt="搜房网新房">
                    <dt class="fl">新房</dt>
                    <dd class="fl">
                        <p class="tit">专属未来&nbsp;&nbsp;全新出发</p>
                        <p class="dis">楼盘动态，一手信息全部掌握</p>
                    </dd></a>
            </dl>
            <div class="r_linear fr"><i></i></div>
        </h2>
        <ul class="clearfix">
            @for($i = 0; $i < $ad_arr_2001_count; $i++)
                <li>
                    <a href="{{$ad_arr[2001][$i]->url}}">
                        <?php
                            $imgTypeArr_2001 = explode('/',$ad_arr[2001][$i]->fileName);
                            $imgType_2001 = (isset($imgTypeArr_2001[1]) && $imgTypeArr_2001[1] == 'ad') ? 'ad' : 'commPhoto';
                        ?>
                        {{--<img data-src="{{get_img_url('ad', $ad_arr[2001][$i]->fileName?get_img_url('ad', $ad_arr[2001][$i]->fileName):'/image/default.png')}}" onerror='this.src="/image/default.png"' alt="{{(!empty($ad_arr[2001][$i]->bigTitle))?$ad_arr[2001][$i]->bigTitle:'暂无楼盘名称'}}" width="271" height="170"/>--}}
                        <img data-src="{{get_img_url($imgType_2001, $ad_arr[2001][$i]->fileName?get_img_url($imgType_2001, $ad_arr[2001][$i]->fileName):'/image/default.png')}}" onerror='this.src="/image/default.png"' alt="{{(!empty($ad_arr[2001][$i]->bigTitle))?$ad_arr[2001][$i]->bigTitle:'暂无楼盘名称'}}" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt><a href="{{$ad_arr[2001][$i]->url}}">{{(!empty($ad_arr[2001][$i]->bigTitle))?mb_substr($ad_arr[2001][$i]->bigTitle,0,6):'暂无楼盘名称'}}<b>[{{(!empty($ad_arr[2001][$i]->smallTitle))?mb_substr($ad_arr[2001][$i]->smallTitle,0,4):'暂无商圈'}}]</b></a></dt>
                        <dd>
                            {{--<span>{{(!empty($ad_arr[2001][$i]->saleStates))?mb_substr($ad_arr[2001][$i]->saleStates,0,6):'暂无销售状态'}}</span>&nbsp;--}}
                            <span>{{(!empty($ad_arr[2001][$i]->type2))?mb_substr($ad_arr[2001][$i]->type2,0,10):'暂无物业类型'}}</span>
                        </dd>
                        <dd>均价：{{(!empty($ad_arr[2001][$i]->avgPrice))?($ad_arr[2001][$i]->avgPrice.($ad_arr[2001][$i]->avgPriceUnit==2?'万/套':'元/平米')):'暂无数据'}}</dd>
                    </dl>
                </li>
            @endfor
        </ul>
        <p class="more_link">
            <a href="/new">查看{{CURRENT_CITYNAME}}更多新房</a>
        </p>
    </div>
    @endif
    <script type="text/javascript" src="/adShow.php?position=3&cityId={{CURRENT_CITYID}}"></script>
    {{--二手房--}}
    @if($ad_arr_2002_count)
    <div class="buildings" id="oldHouse">
        <h2 class="clearfix s_width">
            <div class="l_linear fl"><i></i></div>
            <dl class="fl">
                <a href="/esfsale/area" alt="搜房网二手房">
                    <dt class="fl icon2">二手房</dt>
                    <dd class="fl">
                        <p class="tit">用心之选&nbsp;&nbsp;为您坚守</p>
                        <p class="dis">海量真实房源，租房，买房，尽在搜房</p>
                    </dd>
                </a>
            </dl>
            <div class="r_linear fr"><i></i></div>
        </h2>
        <ul class="clearfix">
            @for($i = 0; $i < $ad_arr_2002_count; $i++)
                <li>
                    <a href="{{$ad_arr[2002][$i]->url}}">
                        <?php
                            $imgTypeArr_2002 = explode('/',$ad_arr[2002][$i]->fileName);
                            $imgType_2002 = (isset($imgTypeArr_2002[1]) && $imgTypeArr_2002[1] == 'ad') ? 'ad' : 'commPhoto';
                        ?>
                        {{--<img data-src="{{get_img_url('ad', $ad_arr[2002][$i]->fileName?get_img_url('ad', $ad_arr[2002][$i]->fileName):'/image/default.png')}}" onerror='this.src="/image/default.png"' alt="{{(!empty($ad_arr[2002][$i]->bigTitle))?$ad_arr[2002][$i]->bigTitle:'暂无楼盘名称'}}" width="271" height="170"/>--}}
                        <img data-src="{{get_img_url($imgType_2002, $ad_arr[2002][$i]->fileName?get_img_url($imgType_2002, $ad_arr[2002][$i]->fileName):'/image/default.png')}}" onerror='this.src="/image/default.png"' alt="{{(!empty($ad_arr[2002][$i]->bigTitle))?$ad_arr[2002][$i]->bigTitle:'暂无楼盘名称'}}" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt><a href="{{$ad_arr[2002][$i]->url}}">{{(!empty($ad_arr[2002][$i]->bigTitle))?mb_substr($ad_arr[2002][$i]->bigTitle,0,6):'暂无楼盘名称'}}<b>[{{(!empty($ad_arr[2002][$i]->smallTitle))?mb_substr($ad_arr[2002][$i]->smallTitle,0,4):'暂无商圈'}}]</b></a></dt>
                        <dd>
                            {{--<span>{{(!empty($ad_arr[2002][$i]->saleStates))?mb_substr($ad_arr[2002][$i]->saleStates,0,6):'暂无销售状态'}}</span>&nbsp;--}}
                            <span>{{(!empty($ad_arr[2002][$i]->type2))?mb_substr($ad_arr[2002][$i]->type2,0,10):'暂无物业类型'}}</span>
                        </dd>
                        <dd>均价：{{(!empty($ad_arr[2002][$i]->avgPrice))?intval($ad_arr[2002][$i]->avgPrice).' 元/平米':'暂无数据'}}</dd>
                    </dl>
                </li>
            @endfor
        </ul>
        <p class="more_link">
            <a href="/esfsale">查看{{CURRENT_CITYNAME}}更多二手房</a>
        </p>
    </div>
    @endif
    <script type="text/javascript" src="/adShow.php?position=14&cityId={{CURRENT_CITYID}}"></script>
    
    {{--写字楼--}}
    @if($ad_arr_2003_count)
    <div class="buildings" id="office">
        <h2 class="clearfix s_width">
            <div class="l_linear fl"><i></i></div>
            <dl class="fl">
                <a href="/xzlrent/area" alt="搜房网写字楼">
                    <dt class="fl icon3">写字楼</dt>
                    <dd class="fl">
                        <p class="tit">居于城央&nbsp;&nbsp;阅尽繁华</p>
                        <p class="dis">海量写字楼，商铺信息，用你量身定做</p>
                    </dd></a>
            </dl>
            <div class="r_linear fr"><i></i></div>
        </h2>
        <ul class="clearfix">
            @for($i = 0; $i < $ad_arr_2003_count; $i++)
                <li>
                    <a href="{{$ad_arr[2003][$i]->url}}">
                        <?php
                            $imgTypeArr_2003 = explode('/',$ad_arr[2003][$i]->fileName);
                            $imgType_2003 = (isset($imgTypeArr_2003[1]) && $imgTypeArr_2003[1] == 'ad') ? 'ad' : 'commPhoto';
                        ?>
                        {{--<img data-src="{{get_img_url('ad', $ad_arr[2003][$i]->fileName?get_img_url('ad', $ad_arr[2003][$i]->fileName):'/image/default.png')}}" onerror='this.src="/image/default.png"' alt="{{(!empty($ad_arr[2003][$i]->bigTitle))?$ad_arr[2003][$i]->bigTitle:'暂无楼盘名称'}}" width="271" height="170"/>--}}
                        <img data-src="{{get_img_url($imgType_2003, $ad_arr[2003][$i]->fileName?get_img_url($imgType_2003, $ad_arr[2003][$i]->fileName):'/image/default.png')}}" onerror='this.src="/image/default.png"' alt="{{(!empty($ad_arr[2003][$i]->bigTitle))?$ad_arr[2003][$i]->bigTitle:'暂无楼盘名称'}}" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt><a href="{{$ad_arr[2003][$i]->url}}">{{(!empty($ad_arr[2003][$i]->bigTitle))?mb_substr($ad_arr[2003][$i]->bigTitle,0,6):'暂无楼盘名称'}}<b>[{{(!empty($ad_arr[2003][$i]->smallTitle))?mb_substr($ad_arr[2003][$i]->smallTitle,0,4):'暂无商圈'}}]</b></a></dt>
                        <dd>
                            {{--<span>{{(!empty($ad_arr[2003][$i]->saleStates))?mb_substr($ad_arr[2003][$i]->saleStates,0,6):'暂无销售状态'}}</span>&nbsp;--}}
                            <span>{{(!empty($ad_arr[2003][$i]->type2))?mb_substr($ad_arr[2003][$i]->type2,0,10):'暂无物业类型'}}</span>
                        </dd>
                        <dd>均价：{{(!empty($ad_arr[2003][$i]->avgPrice))?$ad_arr[2003][$i]->avgPrice.' 元/平米/天':'暂无数据'}}</dd>
                    </dl>
                </li>
            @endfor
        </ul>
        <p class="more_link">
            <a href="xzlrent">查看{{CURRENT_CITYNAME}}更多写字楼</a>
        </p>
    </div>
    @endif
    
     <script type="text/javascript" src="/adShow.php?position=4&cityId={{CURRENT_CITYID}}"></script>   
    {{--理财--}}
    <div class="buildings" id="money">
        <h2 class="clearfix">
            <div class="l_linear fl"><i></i></div>
            <dl class="fl">
                <a href="http://www.huilc.cn/" alt="搜房网理财推荐">
                    <dt class="fl icon4">理财</dt>
                    <dd class="fl">
                        <p class="tit">成于资本&nbsp;&nbsp;财赢天下</p>
                        <p class="dis">购房置业，定制式金融服务一站搞定</p>
                    </dd>
                </a>
            </dl>
            <div class="r_linear fr"><i></i></div>
        </h2>
        <ul class="clearfix">
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/5181755de03b43339ceb6e3d1a953825" target="_blank">
                    <img data-src="image/financeOne.jpg"  onerror='this.src="/image/default.png"' alt="顺德陈村印象花城黄金宝-2期" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/5181755de03b43339ceb6e3d1a953825" title="顺德陈村印象花城黄金宝-2期" target="_blank">顺德陈村印象花城黄金宝-2期</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥20,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/c11a33354b8a48c88a1c3ab65c8c9642" target="_blank">
                    <img data-src="image/financeSix.jpg"  onerror='this.src="/image/default.png"' alt="新会碧桂园购房通" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/c11a33354b8a48c88a1c3ab65c8c9642" title="新会碧桂园购房通" target="_blank">新会碧桂园购房通</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥120,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/1667a212a55a40d3838c2b3f56a87b05" target="_blank">
                    <img data-src="image/financeTwo.jpg"  onerror='this.src="/image/default.png"' alt="茂名翡翠郡认筹宝-商铺" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/1667a212a55a40d3838c2b3f56a87b05" title="茂名翡翠郡认筹宝-商铺" target="_blank">茂名翡翠郡认筹宝-商铺</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥90,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/214646a3d3304565aa9ab1316b90222c" target="_blank">
                    <img data-src="image/financeThree.jpg"  onerror='this.src="/image/default.png"' alt="佛山三水华府汇盈宝-9" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/214646a3d3304565aa9ab1316b90222c" title="佛山三水华府汇盈宝-9" target="_blank">佛山三水华府汇盈宝-9</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥10,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/b19ca7417b3845048435297063b48552" target="_blank">
                    <img data-src="image/financeFour.jpg"  onerror='this.src="/image/default.png"' alt="临泉碧桂园-洋房" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/b19ca7417b3845048435297063b48552" title="临泉碧桂园-洋房" target="_blank">临泉碧桂园-洋房</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥10,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/05bfdfa1e3034e8788a839124ad47f4d" target="_blank">
                    <img data-src="image/financeFive.jpg"  onerror='this.src="/image/default.png"' alt="碧桂园十里江湾认筹宝" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/05bfdfa1e3034e8788a839124ad47f4d" title="碧桂园十里江湾认筹宝" target="_blank">碧桂园十里江湾认筹宝</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥10,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/fbe2fa164091483f9493302e31a18ae6" target="_blank">
                    <img data-src="image/financeFour2.jpg"  onerror='this.src="/image/default.png"' alt="碧桂园城市花园" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/fbe2fa164091483f9493302e31a18ae6" title="碧桂园城市花园" target="_blank">碧桂园城市花园</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥20,000.00元</dd>
                </dl>
            </li>
            <li>
                <a href="http://fang.hlej.com/?chanel=soufang#product/2/aea196d3a588457894ecb78b964f4572" target="_blank">
                    <img data-src="image/financeSix.png"  onerror='this.src="/image/default.png"' alt="邢台碧桂园洋房" width="271" height="170"/>
                </a>
                <dl>
                    <dt>
                        <a href="http://fang.hlej.com/?chanel=soufang#product/2/aea196d3a588457894ecb78b964f4572" title="邢台碧桂园洋房" target="_blank">邢台碧桂园洋房</a>
                    </dt>
                    <dd>
                        <span>5%收益</span>
                    </dd>
                    <dd>小投资金额：￥10,000.00元</dd>
                </dl>
            </li>
            {{--<li>--}}
                {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/1982af3e9ab64e1495f9c84ba95689a2">--}}
                    {{--<img data-src="image/financeThree2.jpg"  onerror='this.src="/image/default.png"' alt="碧桂园龙里天麓1号-洋房" width="271" height="170"/>--}}
                {{--</a>--}}
                {{--<dl>--}}
                    {{--<dt>--}}
                        {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/1982af3e9ab64e1495f9c84ba95689a2" title="碧桂园龙里天麓1号-洋房">碧桂园龙里天麓1号-洋房</a>--}}
                    {{--</dt>--}}
                    {{--<dd>--}}
                        {{--<span>5%收益</span>--}}
                    {{--</dd>--}}
                    {{--<dd>小投资金额：￥20,000.00元</dd>--}}
                {{--</dl>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/6b7632b6a41f422396e3f3e4f1d7996d">--}}
                    {{--<img data-src="image/financeSix2.jpg"  onerror='this.src="/image/default.png"' alt="贵阳碧桂园贵安1号汇盈宝-洋房" width="271" height="170"/>--}}
                {{--</a>--}}
                {{--<dl>--}}
                    {{--<dt>--}}
                        {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/6b7632b6a41f422396e3f3e4f1d7996d" title="贵阳碧桂园贵安1号汇盈宝-洋房">贵阳碧桂园贵安1号汇盈宝-洋房</a>--}}
                    {{--</dt>--}}
                    {{--<dd>--}}
                        {{--<span>5%收益</span>--}}
                    {{--</dd>--}}
                    {{--<dd>小投资金额：￥10,000.00元</dd>--}}
                {{--</dl>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/68333cf1604448cebec94bfafdb6c7fa">--}}
                    {{--<img data-src="image/financeSeven.png"  onerror='this.src="/image/default.png"' alt="邢台碧桂园双拼" width="271" height="170"/>--}}
                {{--</a>--}}
                {{--<dl>--}}
                    {{--<dt>--}}
                        {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/68333cf1604448cebec94bfafdb6c7fa" title="邢台碧桂园双拼">邢台碧桂园双拼</a>--}}
                    {{--</dt>--}}
                    {{--<dd>--}}
                        {{--<span>5%收益</span>--}}
                    {{--</dd>--}}
                    {{--<dd>小投资金额：￥50,000.00元</dd>--}}
                {{--</dl>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/34d31862ded94855a723acae085a5d8c">--}}
                    {{--<img data-src="image/financeEight.jpg"  onerror='this.src="/image/default.png"' alt="临泉碧桂园-商铺" width="271" height="170"/>--}}
                {{--</a>--}}
                {{--<dl>--}}
                    {{--<dt>--}}
                        {{--<a href="http://fang.hlej.com/?chanel=soufang#product/2/34d31862ded94855a723acae085a5d8c" title="临泉碧桂园-商铺">临泉碧桂园-商铺</a>--}}
                    {{--</dt>--}}
                    {{--<dd>--}}
                        {{--<span>5%收益</span>--}}
                    {{--</dd>--}}
                    {{--<dd>小投资金额：￥10,000.00元</dd>--}}
                {{--</dl>--}}
            {{--</li>--}}
        </ul>
        <p class="more_link">
            <a href="http://www.huilc.cn/" target="_blank">查看<!--{{CURRENT_CITYNAME}}-->更多理财</a>
        </p>
    </div>
     <script type="text/javascript" src="/adShow.php?position=5&cityId={{CURRENT_CITYID}}"></script>
</div>
<!--主体内容 结束-->

{{--尾部介绍 开始--}}
<div class="bot_more">
    <ul class="clearfix">
        <li>
            <div>
                <img data-src="image/hlfy.jpg" width="296" height="177" alt="海量房源"/>
                <h4 class="s_tit">海量房源</h4>
            </div>
            <div class="more_dis">
                <h4>海量房源</h4>
                <p class="cont">搜房为您提供大量房源信息，供你参考、比对、选择。众里寻他千百度，好房就要上搜房。</p>
                <p class="more_link">
                    <a href="/esfsale">了解更多</a>
                </p>
            </div>
        </li>
        <li>
            <div>
                <img data-src="image/jrpt.jpg" width="296" height="177" alt="理财投资"/>
                <h4 class="s_tit">理财投资</h4>
            </div>
            <div class="more_dis">
                <h4>理财投资</h4>
                <p class="cont">搜房为您提供大量房产类理财产品，便捷、安全。让您的资产，保值、增值。</p>
                <p class="more_link">
                    <a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=3">了解更多</a>
                </p>
            </div>
        </li>
        <li class="no_mar">
            <div>
                <img data-src="image/zyfw.jpg" width="296" height="177" alt="专业服务"/>
                <h4 class="s_tit">专业服务</h4>
            </div>
            <div class="more_dis">
                <h4>专业服务</h4>
                <p class="cont">搜房为您提供专业的经纪人服务，买房、卖房、租房，想您所想，无后顾之忧。</p>
                <p class="more_link">
                    <a href="/brokerlist">了解更多</a>
                </p>
            </div>
        </li>
    </ul>
</div>
{{--尾部介绍 结束--}}

<!--右侧导航 开始-->
<ul class="right_nav" id="right_nav">
    <li>
        <a href="#newHouse">
            <i></i><h6>新房</h6>
        </a>
    </li>
    <li>
        <a href="#oldHouse">
            <i class="icon2"></i><h6>二手房</h6>
        </a>
    </li>
    <li>
        <a href="#office">
            <i class="icon3"></i><h6>写字楼</h6>
        </a>
    </li>
    <li>
        <a href="#report">
            <i class="icon5"></i><h6>资讯</h6>
        </a>
    </li>
    <li>
        <a href="#money">
            <i class="icon4"></i><h6>理财</h6>
        </a>
    </li>
    <li class="backtop">
        <a href="javascript:;">
            <i></i>
        </a>
    </li>
</ul>
<!--右侧导航 结束-->
<script src="/js/index.js?v={{Config::get('app.version')}}"></script>
<script src="/js/specially/bannerAdv.js"></script>
<script src="/js/point_interest.js"></script>
<script type="text/javascript">
window.onload = function () {
//	//网站维护提示
    //var tips=$('.update');
    //setTimeout(function(){
    //	tips.hide();
    //},10000);
    //$('.update i').click(function(){
    //	tips.hide();
    //});

	$("#slider").responsiveSlides({
		auto: true,
		pager: true,
		nav: true,
		speed: 2000,
		timeout:6000,
		pauseControls: true,
		namespace: "callbacks"
	});

    var hideTimer;
	$('.callbacks_container').mouseenter(function(){
		hideTimer=setTimeout("$('.callbacks_container .clickBtn').fadeIn(500);",500);//鼠标滑过元素1秒钟显示子元素
	}).mouseleave(function(){
		clearTimeout(hideTimer);//清除计时器
		hideTimer=setTimeout("$('.callbacks_container .clickBtn').fadeOut(200);",10);//鼠标移除元素区域子元素消失
	});

 /* iconBtn("goleft","goright","indexmaindiv","maindiv");
  iconBtn("goleft1","goright1","indexmaindiv1","maindiv1");
  iconBtn("goleft2","goright2","indexmaindiv2","maindiv2");
  iconBtn("goleft5","goright5","indexmaindiv5","maindiv5");*/

//$(".searchInput").focus(); 取消默认焦点


};
  /***  搜索提交  start  ***/
  $('.ss').click(function(){
      var val = $(this).parent('div').prev('div').children('input').val();
      var id = $(this).parents('div.search_txt').attr('id').replace('con_home_', '');
      $('#search_Intro').val(val);
      var obj = {};
      obj.val = val;
      obj.name = 'search' + id ;
      lastSearch(obj);
      var elements = $('#search_Intro');
      if($.trim(elements.val()) == ''){
          elements.remove();
      }
      $('#search_Submit').submit();
  });

  // 地图搜索地址
  var mapSearch = '/';
  function mapSearchRedirect(){
      window.location.href = mapSearch;
  }
  $('.ms').click(function(){
      // var val = $(this).parent('div').prev('div').children('input').val();
      // var id = $(this).parents('div.search_txt').attr('id').replace('con_home_', '');
      // var obj = {};
      // obj.val = val;
      // obj.name = 'search' + id ;
      // lastSearch(obj);
      mapSearchRedirect();
  });
  /***  搜索提交  end    ***/

  /** 关注 开始 **/
  point_interest('gz','home');
  /** 关注 结束 **/

</script>
{{--主页尾部 开始--}}
<div class="footer">
  <div class="foot_nav">
   <div class="submenu">
    <div class="nav_buy">
      <h2><a href="/esfsale/area" title="搜房网买房">买房</a></h2>
      @if(in_array(CURRENT_CITYPY, config('openCity')))
      <ul>
        <li><a href="/new/area">新房</a></li>
        <li><a href="/esfsale/area">二手房</a></li>
        <li><a href="/checkpricelist/sale">查房价</a></li>
        <li><a href="/saleesb/area">找小区</a></li>
        <!--<li><a href="/esfsale/area?from=isSoloAgent">独家代理</a></li>-->
        <!--<li><a href="/new/area">学区房</a></li>-->
      </ul>
      @else
      <ul>
        <li><a href="/esfsale/area" title="搜房网二手房房">二手房</a></li>
        <li><a href="/bssale/area">豪宅别墅</a></li>
        <li><a href="/checkpricelist/sale">查房价</a></li>
        <li><a href="/saleesb/area">找小区</a></li>
        <!--<li><a href="/esfsale/area?from=isSoloAgent">独家代理</a></li>-->
        <!--<li><a href="/new/area">学区房</a></li>-->
      </ul>
      @endif
    </div>
    <div class="nav_buy">
      <h2><a href="/esfrent/area" title="搜房网租房">租房</a></h2>
      <ul>
        <!--<li><a href="/esfrent/area?from=agentFee">免中介</a></li>-->
        <li><a href="/esfrent/area/ar1">整租</a></li>
        <li><a href="/esfrent/area/ar2">合租</a></li>
        <li><a href="/bsrent/area">豪宅别墅</a></li>
        {{--<li><a href="/checkpricelist/rent">租价查询</a></li>--}}
      </ul>
    </div>
    <div class="nav_buy">
      <h2><a href="/xzlrent/area" title="搜房网商业">商业</a></h2>
      <ul>
        <li><a href="/xzlrent/area">写字楼出租</a></li>
        <li><a href="/sprent/area">商铺出租</a></li>
        <!--<li><a href="/xzlrent/area?from=isSoloAgent">独家代理</a></li>-->
        <li><a href="/spsale/area">商铺出售</a></li>
        <li><a href="/xzlsale/area">写字楼出售</a></li>
      </ul>
    </div>
    <div class="nav_buy">
      <h2><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=4" target="_blank" title="搜房网理财推荐">理财</a></h2>
      <ul>
        <li><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=4" target="_blank">我要理财</a></li>
        <li><a href="https://www.huilc.cn/front/borrow/noviceBorrow?channel=soFang&usrChannel=15&usrWay=1" target="_blank">新人壕礼</a></li>
        <li><a href="http://fang.hlej.com/?chanel=soufang" target="_blank">我要贷款</a></li>
      </ul>
    </div>
    <div class="nav_buy">
      <h2><a href="{{config('hostConfig.baike_host')}}/index.php?list-property" target="_blank" title="搜房网百科">百科</a></h2>
      <ul>
        <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-property" target="_blank">楼盘词典</a></li>
        <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-words" target="_blank">行业名词</a></li>
        <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-mingqi" target="_blank">业界名企</a></li>
        <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-mingren" target="_blank">业界名人</a></li>
      </ul>
    </div>
   </div>
  </div>
</div>
{{--主页尾部 结束--}}
<div class="adv">
 <a class="adv_link" href="http://bj.sofang.com/sofangAPP/index.html" target="_blank"></a>
 <div class="adv_c">
    <a class="adv_close"></a>
    <a class="xz iPhone" href="https://itunes.apple.com/us/app/sou-fang-wang-zu-fang-mai/id1193969192?mt=8" target="_blank">iPhone下载</a>
    <a class="xz Android" href="http://api.sofang.com/download/sofang_release.apk">Android下载</a>
    <p class="adv_font">
      <span>搜房网旗下社区社交软件，寓房于乐。认识你生活、</span>
      <span>工作的社区、楼宇中更多的人，了解你身边更多的事。</span>
      <span>在自娱自乐中买房租房。</span>
    </p>
 </div> 
</div>
<div class="adv_small"></div>
<script>
$(document).ready(function(e) {
    $(".adv .adv_close").click(function(){
	   var width=$(window).width();
	   $(".adv").animate({"left":-width+"px"},1000,function(){
		  $(".adv_small").animate({"left":"0px"},1000);
	   });
	});
	$(".adv_small").click(function(){
	   	  var width=$(window).width();
		  $(this).animate({"left":"-178px"},1000,function(){
		    $(".adv").animate({"left":"0px"},1000);
	      });
	});
});
</script>
@endsection
