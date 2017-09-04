@extends('mainlayout')
@section('title')
	<title>个人后台</title>
@endsection
@section('head')
	<link rel="stylesheet" type="text/css" href="/css/personalManage.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
<div class="user">
	@include('user.userHomeLeft')
  <div class="user_r">
    <p class="subnav">
      <a href="/user/interCommunity/xinF">新盘</a>
      <span class="click" href="/user/interCommunity/esF">小区</span>
    </p>
    <div class="data_list">
	 @if(!empty($communityData))
	 @foreach($communityData as $community)
     @if($community->found)
     <div class="data_msg">
        <dl>
          <dt><a href="/esfindex/{{$community->_source->id}}/{{$community->_source->cType}}.html"><img onerror="errorImage(this)" src="@if(!empty($community->_source->titleImage)){{get_img_url('commPhoto',$community->_source->titleImage)}}@else{{$communityImage}}@endif" alt="楼盘名称"></a></dt>
          <dd class="data_info">
            <p class="data_name"><a href="/esfindex/{{$community->_source->id}}/{{$community->_source->cType}}.html">{{$community->_source->name}}</a><span>{{$community->_source->communityType}}</span></p>
            <p class="data_address">
                <span>[{{$community->_source->areaName}}@if(!empty($community->_source->businessName))▪{{$community->_source->businessName}}@endif]</span>
                <span class="margin_l">{{$community->_source->address}}</span>
            </p>
            <p class="data_type">
                主营户型：
                @if(isset($community->_source->saleCountRoom1) || isset($community->_source->saleCountRoom2) || isset($community->_source->saleCountRoom3) || isset($community->_source->saleCountRoom4))
                    @if(isset($community->_source->saleCountRoom1))
                        一居
                    @endif
                    @if(isset($community->_source->saleCountRoom2))
                        &nbsp;&nbsp;二居
                    @endif
                    @if(isset($community->_source->saleCountRoom3))
                        &nbsp;&nbsp;三居
                    @endif
                    @if(isset($community->_source->saleCountRoom4))
                        &nbsp;&nbsp;四居
                    @endif
                @else
                    @if(isset($community->_source->rentCountRoom1))
                        一居
                    @endif
                    @if(isset($community->_source->rentCountRoom2))
                       &nbsp;&nbsp;二居
                    @endif
                    @if(isset($community->_source->rentCountRoom3))
                       &nbsp;&nbsp;三居
                    @endif
                    @if(isset($community->_source->rentCountRoom4))
                       &nbsp;&nbsp;四居
                    @endif
                @endif
            </p>
            <p class="data_state">二手房<a>{{$community->_source->saleCount}}</a>套，租房<a>{{$community->_source->rentCount}}</a>套</p>
          </dd>
          <dd class="data_price">
            <p class="price margin_t">
                @if(isset($community->_source->priceSaleAvg3))
                <span>{{$community->_source->priceSaleAvg3}}</span>元/平米
                @elseif(isset($community->_source->{'priceSaleAvg'.$community->_source->cType1}))
                    <span>{{$community->_source->{'priceSaleAvg'.$community->_source->cType1} }}</span>元/平米
                @else
                    待定
                @endif
            </p>
            <p class="handle"><a class="gz" value="{{$community->_source->id}},3,{{$community->_source->cType1}},0">取消关注</a></p>
          </dd>
        </dl>
     </div>
     @endif
	 @endforeach
     @else
            <div class="no_data">
                <div class="no_icon"></div>
                <div class="no_info">
                    <p class="p1"><span>亲</span>，您暂无关注任何小区，关注小区，可及时了解小区相关信息！</p>
                    <p>去<a href="/saleesb/area">关注小区</a></p>
                </div>
            </div>
	 @endif
    </div>
    @if(!empty($pageHtml))
    <div class="page_nav">
      <ul>
          {!! $pageHtml !!}
      </ul>
    </div>
    @endif
  </div>
</div>
<script src="/js/specially/headNav.js?v={{Config::get('app.version')}}"></script>
<script src="/js/point_interest.js?v={{Config::get('app.version')}}"></script>
<script>
    // 取消关注
    point_interest('gz', 'reload');

    // 图片加载不出来时  使用默认图片
    function errorImage(obj){
        obj.src = '/image/noImage.png';
    }

    $(document).ready(function(e) {
        $(".data_msg .look").click(function(){
             if($(this).parents("dl").next().css("display")=="none"){
                 $(".data_msg .change").hide();
                 $(this).parents("dl").next().show();
             }else{
                 $(".data_msg .change").hide();
             }
        });
    });
</script>
@endsection
