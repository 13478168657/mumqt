@extends('mainlayout')
@section('title')
    <title>【地产经纪人|经纪人信息】-搜房网</title>
    <meta name="keywords" content="搜房网，新房，二手房，租房，写字楼，商铺"/>
    <meta name="description" content="搜房网—中国房地产综合信息门户和交易平台，提供二手房、租房、别墅、写字楼、商铺等交易信息，为客户提供全面的搜房体验和多种比较、为业主和经纪人提供高效的信息推广渠道。为客户提供房产百科全书，包括房产名人，名词，名企，楼盘"/>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/list.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
<div class="catalog_nav" id="catalog_nav">
  <div class="list_sub">
     <div class="list_search">
        <input type="text" class="txt border_blue"  placeholder="请输入要搜索的经纪人姓名" id="keyword" value="{{$brokerlist->keyword}}">
        <input type="button" class="btn back_color" id="search" style="cursor:pointer;" value="搜经纪人">
      </div>
  </div>
</div>
<p class="route">
  <span>您的位置：</span>
  <a href="/">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="/brokerlist" class="colorfe">{{CURRENT_CITYNAME}}经纪人列表</a>
</p>
<div class="list">
  <div class="list_term broker_list" style="border-top:1px solid #cbcbcb;">
    <dl class="check _selected" style="display:none;">
      <dt class="color_grey">已选条件：</dt>
      <dd class="check_l">
      </dd>
      <dd class="check_r"><a href="{{$hosturl}}?cityAreaId=&business=&tagid=&type={{$brokerlist->type}}&page=1&keyword=" >清空</a></dd>
    </dl>
    <dl>
      <dt class="color_grey">区域：</dt>
      <dd>
        <a href="{{$hosturl}}?cityAreaId=&business=&type={{$brokerlist->type}}&page=1&keyword={{$brokerlist->keyword}}" class="@if(empty($brokerlist->cityAreaId)) color_blue @endif cityAreaId" value="0">不限</a>
        @foreach($data['cityarea'] as $dkey=>$dval)
        <a href="{{$hosturl}}?cityAreaId={{$dval->id}}&business=&type={{$brokerlist->type}}&page=1&keyword={{$brokerlist->keyword}}" class="@if(!empty($brokerlist->cityAreaId) && $dval->id == $brokerlist->cityAreaId) color_blue active_select  @endif cityAreaId" value="{{$dval->id}}">{{$dval->name}}</a>
        @endforeach
      </dd>
      @if(!empty($brokerlist->cityAreaId))
      <dd class="list_area border_blue">
        <a href="{{$hosturl}}?cityAreaId={{$brokerlist->cityAreaId}}&business=&type={{$brokerlist->type}}&page=1&keyword={{$brokerlist->keyword}}"  class=" @if(empty($brokerlist->business))color_blue @endif business" value="0">不限</a>
        @foreach($data['business'] as $bkey => $bval)
        <span>{{$bkey}}</span>
        @foreach($bval as $bk => $bv)
        <a href="{{$hosturl}}?cityAreaId={{$brokerlist->cityAreaId}}&business={{$bv->id}}&type={{$brokerlist->type}}&page=1&keyword={{$brokerlist->keyword}}" class="@if(!empty($brokerlist->business) && $brokerlist->business == $bv->id) color_blue active_select  @endif business" value="{{$bv->id}}">{{$bv->name}}</a>
        @endforeach
        @endforeach
      </dd>
      @endif
    </dl>
  </div>
  <div class="type_nav">
   <div class="property_type">
     <a href="{{$hosturl}}?cityAreaId={{$brokerlist->cityAreaId}}&business={{$brokerlist->business}}&type=&page=1&keyword={{$brokerlist->keyword}}"  class="build @if($brokerlist->isSaleBroker == 0 && $brokerlist->isRentBroker == 0 ) click @endif type" value="">全部经纪人</a>
     <a href="{{$hosturl}}?cityAreaId={{$brokerlist->cityAreaId}}&business={{$brokerlist->business}}&type=sale&page=1&keyword={{$brokerlist->keyword}}"  class="build @if($brokerlist->isSaleBroker == 1 && $brokerlist->isRentBroker == 0 ) click @endif type" value="sale">买卖经纪人</a>
     <a href="{{$hosturl}}?cityAreaId={{$brokerlist->cityAreaId}}&business={{$brokerlist->business}}&type=rent&page=1&keyword={{$brokerlist->keyword}}"  class="build @if($brokerlist->isSaleBroker == 0 && $brokerlist->isRentBroker == 1 ) click @endif type" value="rent">租赁经纪人</a>
   </div>
   <span class="build_num color2d">找到<span class="colorfe">{{$hits->total}}</span>个经纪人</span>
   <div class="clear"></div>
  </div>
  <div class="broker_msg">
    @if(!empty($hits->hits))
    @foreach($hits->hits as $key=>$val)
     <div class="name_card">
       <span class="dotted"></span>
       <dl>
         <dt>
          @if($brokerlist->type == 'rent')
          <a href="/brokerinfo/{{$val->_source->id}}-renthouse.html">
          @else
          <a href="/brokerinfo/{{$val->_source->id}}.html">
          @endif
          @if($val->_source->photo != '')
          <img src="{{get_img_url('userPhoto',$val->_source->photo, '1')}}" alt="{{(!empty($val->_source->realName)) ? $val->_source->realName : '匿名'}}">
          @else
          <img src="/image/default.png" alt="经纪人"></a>
          @endif
          </a>
          </dt>
         <dd class="dd1">
           <p class="name">
           @if($brokerlist->type == 'rent')
           <a href="/brokerinfo/{{$val->_source->id}}-renthouse.html">
           @else
           <a href="/brokerinfo/{{$val->_source->id}}.html">
           @endif
               {{(!empty($val->_source->realName)) ? $val->_source->realName : '匿名'}}
           </a>

            <?php $enterpriseshopName = \App\Http\Controllers\Utils\RedisCacheUtil::getDataLikeKing('mysql_user', 'enterpriseshop', 'EPS', $val->_source->enterpriseshopId,'companyName'); ?>
            @if(!empty($enterpriseshopName))
               <span class="broker_company" title="{{$enterpriseshopName}}">[&nbsp;{{mb_substr($enterpriseshopName, 0, 5, 'utf-8')}}&nbsp;]</span>
            @else
               <span class="broker_company">[&nbsp;独立经纪人&nbsp;]</span>
            @endif
            {{--@if(!empty($val->_source->isSaleBroker) && $val->_source->isSaleBroker == 1)--}}
            {{--<span class="subway">买卖</span>--}}
            {{--@endif--}}
            {{--@if(!empty($val->_source->isRentBroker) && $val->_source->isRentBroker == 1)--}}
            {{--<span class="subway">租赁</span>--}}
            {{--@endif--}}
          </p>
          <p class="company margin_top color2d">
            从业时间：
            @if(empty($val->_source->year) || (date('Y',time())-substr($val->_source->year, 0, 4) < 1 ) )
            1年以下
            @else
            {{date('Y',time())-substr($val->_source->year, 0, 4)}} 年以上
            @endif
          </p>
          <p class="plate">
            主营业务：
            @if(!empty($val->_source->mainbusiness))
            <?php $mainbusiness = explode('|', $val->_source->mainbusiness); ?>
              @for( $i = 0; $i < 2; $i++)
              @if(!empty($mainbusiness[$i]))
              <a>{{config('mianBusiness.'. $mainbusiness[$i])}}</a>
              @endif
              @endfor
            @else
            暂无资料
            @endif
          </p>
          <p class="plate">
            服务商圈：
            @if(!empty($val->_source->managebusinessAreaIds))
              <?php $managebusinessAreaIds = explode('|', $val->_source->managebusinessAreaIds); ?>
              @for($i = 0; $i < 2; $i++)
              @if(!empty($managebusinessAreaIds[$i]))
                  <?php
                        $businessName = \App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($managebusinessAreaIds[$i]);
                        if(empty($businessName)){
                            $businessName = '多商圈';
                        }
                  ?>
              <a>{{$businessName}}</a>
              @endif
              @endfor
            @else
            多商圈
            @endif
          </p>
         </dd>
        </dl>
     </div>
    @endforeach
    @else
    <div class="no_state no_border">
      <div class="state_l"><img src="/image/no_state2.png" alt="无数据"></div>
      <div class="state_r">
          <p class="p1">很抱歉，没有找到相关的经纪人！</p>
          <div class="p2">
              <span class="title">温馨提示</span><br>
              <span class="state"><span class="dotted"></span>请检查关键词是否正确</span><br>
              <span class="state"><span class="dotted"></span>尝试切换到其他频道</span><br>
              <span class="state"><span class="dotted"></span>您可以尝试切换到其他城市</span><br>
          </div>
      </div>
    </div>
  @endif
  </div>
  <div class="page_nav">
    <ul>
      {!!$pageBar!!}
    </ul>
  </div>
</div>
@include('broker.footer')
@endsection
