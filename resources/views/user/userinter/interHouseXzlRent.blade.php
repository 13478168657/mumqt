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
		<a href="/user/interHouse/xqsale">住宅</a>
		<span class="click">写字楼</span>
		<a href="/user/interHouse/shopsale">商铺</a>
    </p>
    <p class="type_nav">
		<a href="/user/interHouse/officesale">出售</a>
		<a class="click" href="/user/interHouse/officerent">出租</a>
    </p>
    <div class="data_list">
	@if(!empty($houseData))
        @foreach($houseData['house'] as $house)
        @if($house->found)
         <div class="data_msg">
            <dl>
              <dt><a href="/housedetail/sr{{$house->_source->id}}.html"><img onerror="errorImage(this)" src="@if(!empty($house->_source->thumbPic)){{get_img_url('houserent',$house->_source->thumbPic,2)}}@else{{$houseImage}}@endif" alt="房源名称"></a></dt>
              <dd class="data_info">
                <p class="data_name"><a href="/housedetail/sr{{$house->_source->id}}.html">{{$house->_source->title}}</a></p>
                <p class="data_address"><span>@if(!empty($house->_source->name)){{$house->_source->name}}@else{{$house->_source->tmp_communityId}}@endif</span><span class="margin_l">{{$house->_source->address}}</span></p>
                <p class="data_type">
                    {{floor($house->_source->area)}}平米，
                    {{$house->_source->currentFloor}}/{{$house->_source->totalFloor}}层，
                    @if(isset(config('houseState.fitment')[$house->_source->fitment])){{config('houseState.fitment')[$house->_source->fitment]}}，@endif
                    {{floor($house->_source->price1)}}元/月
                </p>
                <p class="data_user">
                    @if(isset($house->_source->brokers))
                        @if(isset($house->_source->brokers[0]->realName)){{$house->_source->brokers[0]->realName}}@endif
                        @if(isset($house->_source->brokers[0]->mobile))&nbsp;&nbsp;{{$house->_source->brokers[0]->mobile}} @endif
                    @endif
                </p>
              </dd>
              <dd class="data_price">
                <p class="price margin_t">@if(!empty(floor($house->_source->price2)))<span>{{floor($house->_source->price2)}}</span>元/天/平米@else<span>面议</span>@endif</p>
                <p class="handle"><a class="gz" value="{{$house->_source->id}},1,{{$house->_source->houseType1}},0">取消关注</a><a class="look" value="{{$house->_source->id}}" data_type="{{$house->_source->houseType1}}">近期变化<i></i></a></p>
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
         @if(!empty($houseData['info']))
         @foreach($houseData['info'] as $info)
            <div class="data_msg">
                <dl>
                    <dt><a href="/housedetail/sr{{$info->id}}.html"><img onerror="errorImage(this)" src="@if(!empty($info->thumbPic)){{get_img_url('houserent',$info->thumbPic,2)}}@else{{$houseImage}}@endif" alt="房源名称"></a></dt>
                    <dd class="data_info">
                        <p class="data_name"><a href="/housedetail/sr{{$info->id}}.html">{{$info->title}}</a></p>
                        <p class="data_address"><span>@if(isset($info->name) && !empty($info->name)){{$info->name}}@else &nbsp;&nbsp; @endif</span><span class="margin_l">{{$info->address}}</span></p>
                        <p class="data_type">
                            {{floor($info->area)}}平米，
                            {{$info->currentFloor}}/{{$info->totalFloor}}层，
                            @if(isset(config('houseState.fitment')[$info->fitment])){{config('houseState.fitment')[$info->fitment]}}，@endif
                            {{floor($info->price1)}}元/月
                        </p>
                        <p class="data_user">
                            @if(isset($info->brokerName)){{$info->brokerName}}@endif
                            @if(isset($info->brokerMobile))&nbsp;&nbsp;{{$info->brokerMobile}} @endif
                        </p>
                    </dd>
                    <dd class="data_price">
                        <p class="price margin_t">@if(!empty(floor($info->price2)))<span>{{floor($info->price2)}}</span>元/天/平米@else<span>面议</span>@endif</p>
                        <p class="handle"><a class="gz" value="{{$info->id}},1,{{$info->houseType1}},0">取消关注</a><a class="look" value="{{$info->id}}" data_type="{{$info->houseType1}}">近期变化<i></i></a></p>
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
         @endforeach
         @endif
	@else
		<div class="no_data">
			<div class="no_icon"></div>
			<div class="no_info">
				<p class="p1"><span>亲</span>，目前没有关注出租写字楼！您还可以去看看其它出租的写字楼房源</p>
				<p>去<a href="/xzlrent/area">关注写字楼</a></p>
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
                houseChange($(this));
//                $(".data_msg .change").hide();
//                $(this).parents("dl").next().show();
            }else{
                $(".data_msg .change").hide();
            }
        });
    });

    function houseChange(obj){
        var houseId,token,type,rent_house,price_flag,state_flag;
        price_flag = state_flag = false;
        houseId = obj.attr('value');
        token = "{{csrf_token()}}";
        type = obj.attr('data_type');
        rent_house = '<p class="top_icon"></p>';
        $.ajax({
            type : 'POST',
            url : '/user/ajaxHouseRent',
            data : {
                _token : token,
                id : houseId,
                type : type,
                isNew : 0
            },
            dataType : 'json',
            success : function(msg){
                rent_house += '<ul>';
                if(msg.priceChange != 1){
                    price_flag = true;
                    for(var i in msg.priceChange){
                        rent_house += '<li><span class="dotted"></span>';
                        if(msg.priceChange[i].diffPrice > 0){
                            rent_house += '<span>'+msg.priceChange[i].changeTime+'</span><span>价格上涨了'+msg.priceChange[i].diffPrice+'</span>';
                        }
                        if(msg.priceChange[i].diffPrice < 0){
                            rent_house += '<span>'+msg.priceChange[i].changeTime+'<span>价格下调了'+msg.priceChange[i].diffPrice.toString().substr(1)+'</span>';
                        }
                        if(msg.priceChange[i].type1 == 3){
                            rent_house += '<span>'+msg.priceChange[i].changeTime+'<span>'+msg.priceChange[i].price+'元/月</span>';
                        }
                        if(msg.priceChange[i].type1 == 2 || msg.priceChange[i].type1 == 1){
                            rent_house += '<span>'+msg.priceChange[i].changeTime+'<span>'+msg.priceChange[i].price+'元/平米▪天</span>';
                        }
                        rent_house += '/<li>';
                    }
                }
                if(msg.rentState != 1){
                    state_flag = true;
                    rent_house += '<li><span class="dotted"></span>';
                    rent_house += '<span>'+msg.rentState[0].timeUpdate+'</span><span>'+msg.rentState[0].state+'</span></li>';
                    rent_house += '<li><span class="dotted"></span><span>'+msg.rentState[0].timeUpdate+'</span><span>'+msg.rentState[0].dealState+'</span></li>';
                }
                if(!price_flag && !state_flag){
                    rent_house +='<li><span class="dotted"></span><span></span><span>近期该房源无变化</span></li>';
                }
                rent_house += '</ul>';
                obj.parents("dl").next().html(rent_house).show();
            }
        });
    }
</script>
@endsection
