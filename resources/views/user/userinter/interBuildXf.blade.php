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
      <span class="click" href="/user/interCommunity/xinF">新盘</span>
      <a href="/user/interCommunity/esF">小区</a>
    </p>
    <div class="data_list">
     @if(!empty($communityData))
       @foreach($communityData as $community)
       @if($community->found)
         <div class="data_msg">
            <dl>
              <dt><a href="/xinfindex/{{$community->_source->id}}/{{$community->_source->cType}}.html"><img onerror="errorImage(this)" src="@if(!empty($community->_source->titleImage)){{get_img_url('commPhoto',$community->_source->titleImage)}}@else{{$communityImage}}@endif" alt="楼盘名称"></a></dt>
              <dd class="data_info">
                <p class="data_name">
                  <a href="/xinfindex/{{$community->_source->id}}/{{$community->_source->cType}}.html">{{$community->_source->name}}</a>
                  <span>{{$community->_source->communityType}}</span>
                </p>
                <p class="data_address">
                  <span>[{{$community->_source->areaName}}@if(!empty($community->_source->businessName))▪{{$community->_source->businessName}}@endif]</span>
                  <span class="margin_l">{{$community->_source->address}}</span>
                </p>
                <p class="data_type">@if(!empty($community->_source->propertyFee)){{$community->_source->propertyFee}}元/平方米·月@endif @if(!empty($community->_source->propertyYear))，{{$community->_source->propertyYear}}年@endif</p>
              </dd>
              <dd class="data_price">
                <p class="price">
                  <span>@if(isset($community->_source->{'priceSaleAvg'.$community->_source->cType1})){{$community->_source->{'priceSaleAvg'.$community->_source->cType1} }}元/平米 @else 待定 @endif</span>
                </p>
                <p class="price">
                  @if(isset($community->_source->discountType))
                  优惠：
                  @if($community->_source->discountType == 1)
                    {{$community->_source->discount}}折
                  @elseif($community->_source->discountType == 2)
                    减去{{$community->_source->subtract}}
                  @elseif($community->_source->discountType == 3)
                    {{$community->_source->discount}}折&nbsp;减去{{$community->_source->subtract}}
                  @endif
                  @endif
                  @if(!empty($community->_source->dianyou[0]) && !empty($community->_source->dianyou[1]))
                    &nbsp;&nbsp;{{$community->_source->dianyou[0]}}&nbsp;抵&nbsp;{{$community->_source->dianyou[1]}}
                  @endif
                </p>
                <p class="handle"><a class="gz" value="{{$community->_source->id}},3,{{$community->_source->cType1}},1">取消关注</a><a class="look" value="{{$community->_source->id}}">近期变化<i></i></a></p>
              </dd>
            </dl>
            <div class="change" style="display:none;">
              <p class="top_icon"></p>
              <ul>
                <li>
                  <span class="dotted"></span>
                  <span>2016-7-7</span>
                  <span>新盘上线，价格23000元/平米，优惠：减去100000。</span>
                </li>
              </ul>
            </div>
         </div>
          @endif
        @endforeach
     @else
            <div class="no_data">
                <div class="no_icon"></div>
                <div class="no_info">
                    <p class="p1"><span>亲</span>，您暂无关注任何新盘，关注新盘，可及时了解新盘信息！</p>
                    <p>去<a href="/new/area">关注新楼盘</a></p>
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
{{--<script src="/js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>--}}
{{--<script src="/js/userindex.js?v={{Config::get('app.version')}}"></script>--}}
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
                  // 执行ajax请求  查询变化信息
                  communityChange($(this));
        //          $(".data_msg .change").hide();
        //          $(this).parents("dl").next().show();
               }else{
                  $(".data_msg .change").hide();
               }
        });
  });

  function communityChange(_this){
      var url,communityId,token,seven_comm;
      token = "{{csrf_token()}}";
      seven_comm = '<p class="top_icon"></p>';
      url = '/user/communityChange';
      communityId = _this.attr('value');
      $.ajax({
          type : 'POST',
          url : url,
          data : {
              _token : token,
              id : communityId
          },
          dataType : 'json',
          success : function(msg){
              seven_comm += '<ul>';
              if(msg == 5){
                  seven_comm += '<li><span class="dotted"></span><span></span><span>近期无变化信息</span></li>';
              }else{
                  if(msg.price1.length > 1){
                      seven_comm += '<li><span class="dotted"></span><span>'+msg.price1[0].timeCreate.toString().substr(0,10)+'</span>';
                      var diffprice = msg.price1[0].detail.saleAvgPrice - msg.price1[1].detail.saleAvgPrice;
                      if(diffprice > 0){
                          seven_comm += '<span>价格上涨了'+diffprice+'，&nbsp;价格'+msg.price1[0].detail.saleAvgPrice+'元/平米</span>';
                      }else{
                          seven_comm += '<span>价格下调了'+diffprice.toString().substr(1)+'，&nbsp;价格'+msg.price1[0].detail.saleAvgPrice+'元/平米</span>';
                      }
                      seven_comm += '</li>';
                  }else if(msg.price1.length == 1 && msg.price2.length > 0){
                      seven_comm += '<li><span class="dotted"></span><span>'+msg.price1[0].timeCreate.toString().substr(0,10)+'</span>';
                      var diffprice = msg.price1[0].detail.saleAvgPrice - msg.price2[0].detail.saleAvgPrice;
                      if(diffprice > 0){
                          seven_comm += '<span">价格上涨了'+diffprice+'，&nbsp;价格'+msg.price1[0].detail.saleAvgPrice+'元/平米</span>';
                      }else{
                          seven_comm += '<span">价格下调了'+diffprice.toString().substr(1)+'，&nbsp;价格'+msg.price1[0].detail.saleAvgPrice+'元/平米</span>';
                      }
                      seven_comm += '</li>';
                  }
                  if(msg.discount.length > 0){
                      seven_comm += '<li><span class="dotted"></span><span>'+msg.discount[0].timeCreate.toString().substr(0,10)+'</span>';
                      var period1 =  commPeriod(msg.info[0].period);
                      seven_comm += '<span>'+period1+'&nbsp;最低折扣'+msg.discount[0].detail.discount+'</span></li>';
                  }
                  if(msg.dianyou.length > 0){
                      var period2 =  commPeriod(msg.info[0].period);
                      seven_comm += '<li><span class="dotted"></span><span>'+msg.dianyou[0].timeCreate.toString().substr(0,10)+'</span>';
                      seven_comm += '<span>'+period2+'&nbsp;优惠政策'+msg.dianyou[0].detail.dianYouDesc+'</span></li>';
                  }
                  if(msg.price1.length == 0 && msg.price2.length == 0 && msg.discount.length == 0 && msg.dianyou.length == 0){
                      seven_comm += '<li><span class="dotted"></span><span></span><span>近期无变化信息</span></li>';
                  }
              }
              seven_comm += '</ul>';
              _this.parents("dl").next().html(seven_comm).show();
          }
      });

  }


</script>
@endsection
