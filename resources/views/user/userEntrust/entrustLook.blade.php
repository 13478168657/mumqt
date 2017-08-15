
@extends('mainlayout')
@section('title')
    <title>个人后台</title>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/personalManage.css?v={{Config::get('app.version')}}">
    {{--  <link rel="stylesheet" type="text/css" href="/css/personalHoutai.css?v={{Config::get('app.version')}}">--}}
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="http://sandbox.runjs.cn/uploads/rs/351/8eazlvc1/imgareaselect-anima.css" />
@endsection
@section('content')
    <div class="user">
        @include('user.userHomeLeft')
    <div class="user_r">
        <div class="data_list">
            <ul class="entrust">
                <li class="entrust_l">
                    <p>
                        <span>物业类型：{{!empty($houseType1[$house->houseType1])?$houseType1[$house->houseType1]:'其它'}}</span>
                        <span>目标区域：
                            @if($house->searchType == 1)
                                @if(!empty(App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($house->cityAreaId)))
                                    {{App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($house->cityAreaId)}}
                                    ▪{{App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($house->businessAreaId)}}
                                @else
                                    暂无
                                @endif
                            @elseif($house->searchType == 2)
                                @if(isset($subWays[$house->subwayLineId])&&isset($subWayStation[$house->subwayId]))
                                    {{$subWays[$house->subwayLineId]}}▪{{$subWayStation[$house->subwayId]}}
                                @else
                                    暂无
                                @endif
                            @else
                                @if(!empty(App\Http\Controllers\Utils\RedisCacheUtil::getOldCommunityNameById($house->communityId)))
                                    {{App\Http\Controllers\Utils\RedisCacheUtil::getOldCommunityNameById($house->communityId)}}
                                @else
                                    暂无
                                @endif
                            @endif
                        </span>
                        <span>目标城市：
                            @if(!empty(App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($house->cityId)))
                                {{App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($house->cityId)}}市
                            @else
                                暂无
                            @endif
                        </span>
                    </p>
                    <p>
                        @if($house->houseType1 == 1)
                            <span>期望行业：
                                <?php
                                $xtrade = explode('|',$house->trade);
                                //$xtrade = array_unique($xtrade);
                                $ytrade = array();
                                foreach($xtrade as $k=>$trade){
                                    if(!empty($trades[$trade])){
                                        array_push($ytrade,$trades[$trade]);
                                    }
                                    if($k==1) break;
                                }
                                echo implode(',',$ytrade);
                                ?>
                                    </span>
                        @elseif($house->houseType1 == 2)
                            <span>期望楼层：{{$house->currentFloor}}</span>
                        @else
                            <span>期望户型：{{$house->houseRoom}}居</span>
                        @endif
                        @if($sr == 'r')
                            <span>期望@if($type=='Qz')租金@else售价@endif：
                                @if(isset($house->priceMin)&&!empty($house->priceMax))
                                    {{(int)$house->priceMin}}至{{(int)$house->priceMax}}
                                    @if($house->houseType1 == 3)
                                        元/月
                                    @else
                                        元/平米▪天
                                    @endif
                                @else
                                    面议
                                @endif
                            </span>
                        @else
                            <span>期望@if($type=='Qz')租金@else售价@endif：
                                @if(isset($house->priceMin)&&!empty($house->priceMax))
                                    {{(int)$house->priceMin}}至{{(int)$house->priceMax}}万元
                                @else
                                    面议
                                @endif
                            </span>
                        @endif
                        <span>期望面积：
                            @if(isset($house->areaMin)&&!empty($house->areaMax))
                                {{(int)$house->areaMin}}至{{(int)$house->areaMax}}平米
                            @else
                                待定
                            @endif
                        </span>
                    </p>
                    <p>需求描述：{{!empty($house->describe)?$house->describe:'暂无'}}</p>
                </li>
                <li class="entrust_r">
                    {{--<p><a href="entrustQz.htm">编辑</a></p>--}}
                    <p><a id="entrustAllDel">取消委托</a></p>
                </li>
            </ul>
        </div>
        <div class="build_list">
            {{--经纪人循环开始--}}
            @if($entrustList)
            @foreach($entrustList as $v)
        	<div class="broker_block">
        		<ul class="broker_info">
	                <dt><img width="90" height="120" src="{{$v['photo']}}" alt="{{$v['realName']}}" onerror="javascript:this.src='/image/default_broker.png';"></dt>
	                <dd>
	                    <p class="p1"><span>{{$v['realName']}}</span></p>
	                    <p class="p2">
	                         <span>{{$v['company']}}</span>
	                         <span class="dotted"></span>
	                         <span>{{$v['businessArea']}}</span>
	                    </p>
	                    <div class="tel">
	                        <i></i>{{$v['mobile']}}
	                    </div>
	                </dd>
                    @if((isset($v['idcardState'])&&$v['idcardState']==1)||(isset($v['jobCardState'])&&$v['jobCardState']==1))
	                <span class="dotted"></span>
                    @if(isset($v['idcardState'])&&$v['idcardState']==1)
	                <dd class="test">
                        <img src="/image/id.png">
                        <span>身份认证</span>
                    </dd>
                    @endif
                    @if(isset($v['jobCardState'])&&$v['jobCardState']==1)
                    <dd class="test">
                        <img src="/image/mp.png">
                        <span>名片认证</span>
                    </dd>
                    @endif
                    <span class="dotted"></span>
                    @endif
                    <dd class="btns">
                    	<a href="/brokerinfo/{{$v['bId']}}.html">查看店铺</a>
                    	{{--<button>取消委托</button>--}}
                        @if($v['data'])<a class="close_entrust" value="{{$v['bId']}}">取消委托</a>@endif
                    </dd>
	            </ul>
	           	<div class="entrust_list">
                    {{--房源循环开始--}}
                    @if($v['data'])
                    @foreach($v['data'] as $vv)
	           		<dl class="new_style">
	                    <dt>
	                        <a href="/housedetail/sr{{$vv['id']}}.html"><img src="{{$vv['thumbPic']}}" width="160" height="120"></a>
                        </dt>
	                    <dd>
                            @if($vv['title'])
	                        <p class="build_name"><a href="/housedetail/s{{$sr}}{{$vv['id']}}.html" class="name">{{$vv['title']}}</a></p>
                            @endif
	                        <p class="finish_data color8d">
	                            <span class="color8d">{{$vv['address']}}<i class="map_icon"></i></span>
	                        </p>
	                        <p class="build_type color8d">
                                @if($vv['area'])<span>{{$vv['area']}}平米</span>@endif
                                @if($vv['currentFloor']&&$vv['totalFloor'])<span class="margin_l">{{$vv['currentFloor']}}/{{$vv['totalFloor']}}层</span>@endif
                                @if($vv['rentType'])<span class="margin_l">{{$vv['rentType']}}</span>@endif
                                {{--@if($vv['price']&&$vv['priceUnit'])<span class="margin_l">{{$vv['price']}}{{$vv['priceUnit']}}</span>@endif--}}
	                        </p>
	                        <p class="build_type color8d">
	                            <span>发布时间：</span>
	                            <span>{{$vv['timeCreate']}}</span>
	                            <span class="margin_l">{{$vv['timeUpdate']}}更新</span>
	                        </p>
	                    </dd>
	                    <dd class="dd2"><span class="colorfe">{{$vv['price']}}{{$vv['priceUnit']}}</span>&nbsp;</dd>
	                </dl>
                    @endforeach
                    @endif
                    {{--房源循环开始--}}
	           	</div>
        	</div>
            @endforeach
            @endif
            {{--经纪人循环结束--}}

            @if(!$entrustList)
                @foreach($entrustList as $v)
                <dl>
                    <dt>
                        <a href="/housedetail/sr{{$v['id']}}.html"><img src="{{$v['thumbPic']}}"></a>
                        {{--<a href="#" class="img_num"><i></i>{{"img_num"}}</a>--}}
                    </dt>
                    <dd>
                        <p class="build_name"><a href="/housedetail/sr{{$v['id']}}.html" class="name">{{$v['title']}}</a></p>
                        <p class="finish_data color8d">
                            <a href="#"><strong>{{$v['tmp_communityId']}}</strong></a>&nbsp;&nbsp;
                            <span class="color8d">{{$v['address']}}<i class="map_icon"></i></span>
                        </p>
                        <p class="build_type color8d">
                            <span>{{$v['area']}}平米</span>
                            <span class="margin_l">{{$v['roomStr']}}</span>
                            <span class="margin_l">{{$v['faceTo']}}</span>
                            <span class="margin_l">{{$v['currentFloor']}}/{{$v['totalFloor']}}层</span>
                            <span class="margin_l">{{$v['price']}}{{$v['priceUnit']}}</span>
                        </p>
                        <p class="build_type color8d">
                            <span>发布时间：</span>
                            <span>{{$v['timeCreate']}}</span>
                            <span class="margin_l">{{$v['timeUpdate']}}更新</span>
                        </p>
                    </dd>
                    <dd class="dd2"><span class="colorfe">{{$v['price'].$v['priceUnit']}}</span>&nbsp;</dd>
                    <dd class="comment_r">
                        <a class="close_entrust" value="{{$v['bId']}}">取消委托</a>
                        <div class="broker_info">
                            <a>
                                <img src="{{$v['photo']}}">
                                <div class="info">
                                    <p class="broker_name"><a href="/brokerinfo/{{$v['bId']}}.html">{{$v['realName']}}</a></p>
                                    <p>{{$v['cityArea']}}▪{{$v['businessArea']}}</p>
                                    <p class="broker_tel">{{$v['phone']}}</p>
                                </div>
                            </a>
                        </div>
                    </dd>
                </dl>
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="claim" id="quxiao" style="z-index: 999; position: fixed; top:32%; left: 58%;">
    <span class="close" onclick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
    <dl>
        <dt><i class="tan"></i>您确定取消委托吗</dt>
        <dd>
            <input type="button" onclick="ajaxPost()" class="btn" value="确定">
            <input onclick="$('#quxiao').hide();$('#lean_overlay').hide();" type="button" class="btn" value="取消">
        </dd>
    </dl>
</div>

<script>
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
<script>
    var crtoken,bId,url,hId,type;
    hId="{{$house->id}}";
    type= "{{$type}}";
    crtoken  = $("#crtoken").val();
    $('#entrustAllDel').click(function(){
        $('#quxiao').show();
        $('#lean_overlay').show();
        bId=0;
        url='/userEntrust/removeAll';
    });

    $('.close_entrust').click(function(){
        $('#quxiao').show();
        $('#lean_overlay').show();
        bId = $(this).attr('value');
        url='/userEntrust/removeBroker';
    });
    function ajaxPost(){
        $('#quxiao').hide();
        $('#lean_overlay').hide();
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                _token : crtoken,
                hId : hId,
                bId : bId,
                type : type
            },
            dataType:'json',
            success: function (result) {
                if(result == 1){
                    alert('取消委托成功');
                    window.location.href='/userEntrust/Qz';
                }else{
                    alert('取消委托失败');
                }
            }
        });
    }
</script>
@endsection
