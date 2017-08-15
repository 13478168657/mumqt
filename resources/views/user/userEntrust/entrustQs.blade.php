<?php $type='2'?>
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
            @include('user.userEntrust.publishHeader')
        <p class="subnav">
            <a href="/userEntrust/Qz">求租</a>
            <span class="click">求购</span>
            <a href="/userEntrust/rent">出租</a>
            <a href="/userEntrust/sale">出售</a>
        </p>
        <div class="data_list">
            <input type="hidden" name="crtoken" value="{{csrf_token()}}" id="crtoken"/>
            @if(!empty($houseWanted))
                @foreach($houseWanted as $v)
                    <ul class="entrust">
                        <li class="entrust_l">
                            <p>
                                <span>物业类型：{{!empty($houseType1[$v->houseType1])?$houseType1[$v->houseType1]:'其它'}}</span>
                                <span>目标区域：
                                    @if($v->searchType == 1)
                                        @if(!empty(App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($v->cityAreaId)))
                                            {{App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($v->cityAreaId)}}
                                            ▪{{App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($v->businessAreaId)}}
                                        @else
                                            暂无
                                        @endif
                                    @elseif($v->searchType == 2)
                                        @if(isset($subWays[$v->subwayLineId])&&isset($subWayStation[$v->subwayId]))
                                            {{$subWays[$v->subwayLineId]}}▪{{$subWayStation[$v->subwayId]}}
                                        @else
                                            暂无
                                        @endif
                                    @else
                                        @if(!empty(App\Http\Controllers\Utils\RedisCacheUtil::getOldCommunityNameById($v->communityId)))
                                            {{App\Http\Controllers\Utils\RedisCacheUtil::getOldCommunityNameById($v->communityId)}}
                                        @else
                                            暂无
                                        @endif
                                    @endif
                                </span>
                                <span>目标城市：
                                    @if(!empty(App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($v->cityId)))
                                        {{App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($v->cityId)}}市
                                    @else
                                        暂无
                                    @endif
                                </span>
                            </p>
                            <p>
                                @if($v->houseType1 == 1)
                                    <span>期望行业：
                                        <?php
                                        $xtrade = explode('|',$v->trade);
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
                                @elseif($v->houseType1 == 2)
                                    <span>期望楼层：{{$v->currentFloor}}</span>
                                @else
                                    <span>期望户型：{{$v->houseRoom}}居</span>
                                @endif
                                <span>期望售价：
                                    @if(isset($v->priceMin)&&!empty($v->priceMax))
                                        {{(int)$v->priceMin}}至{{(int)$v->priceMax}}万元
                                    @else
                                        面议
                                    @endif
                                </span>
                                <span>期望面积：
                                    @if(isset($v->areaMin)&&!empty($v->areaMax))
                                        {{(int)$v->areaMin}}至{{(int)$v->areaMax}}平米
                                    @else
                                        待定
                                    @endif
                                </span>
                            </p>
                            <p>需求描述：{{!empty($v->describe)?$v->describe:'暂无'}}</p>
                        </li>
                        <li class="entrust_r">
                            <?php
                                if($v->houseType1 == 1){
                                    $type_x = 'spsale';
                                }elseif($v->houseType1 == 2){
                                    $type_x = 'xzlsale';
                                }else{
                                    $type_x = 'esfsale';
                                }
                            ?>
                            @if($v->entrustState)
                                @if($v->hadCommissioned > 0)
                                <p><a href="/userEntrust/Qs-{{$v->id}}">查看委托</a></p>
                                @endif
                            @else
                            <p><a class="startEntrust" value="{{$v->id}}">开始委托</a></p>
                            @endif
                            @if($v->hadCommissioned <= 0)
                            <p><a href="/wantSaleRent/{{$type_x}}/{{$v->id}}">编辑</a></p>
                            <p><a class="entrustDel" value="{{$v->id}}">删除</a></p>
                            @endif
                        </li>
                    </ul>
                @endforeach
            @else
                <div class="user_r">
                    <div class="no_data">
                        <div class="no_icon"></div>
                        <div class="no_info">
                            <p class="p1"><span>亲</span>，您暂无委托任何求购房源！</p>
                            <p>去<a href="/wantSaleRent/esfsale">委托房源</a></p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="page_nav">
            {!! $pageHtml !!}
        </div>
    </div>
</div>

<div class="claim" id="quxiao" style="z-index: 999; position: fixed; top:32%; left: 58%;">
    <span class="close" onclick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
    <dl>
        <dt id="oprateHint"><i class="tan"></i>您确定取消委托吗</dt>
        <dd>
            <input type="button" onclick="ajaxPost()" class="btn" value="确定">
            <input onclick="$('#quxiao').hide();$('#lean_overlay').hide();" type="button" class="btn" value="取消">
        </dd>
    </dl>
</div>
@include('user.myinfo.footer')
<script>
/*    $(function(){
        console.log(document.location.href);
        $('.entrustDel').click(function(){
            var delId = $(this).attr('value');
            var crtoken  = $("#crtoken").val();
            if (confirm('你确定要删除吗?')) {
                $.ajax({
                    type: 'POST',
                    url: '/entrustDel/sale',
                    data: {
                        _token : crtoken,
                        id : delId
                    },
                    dataType:'json',
                    success: function (result) {
                        if(result == 1){
                            alert('删除成功');
                            window.location.href='/userEntrust/Qs';
                        }else{
                            alert('删除失败');
                        }
                    }
                });
            }
        });
        $('.startEntrust').click(function(){
            var hId = $(this).attr('value');
            var crtoken  = $("#crtoken").val();
            if (confirm('你确定要开始委托吗?')) {
                $.ajax({
                    type: 'POST',
                    url: '/userEntrust/openAll',
                    data: {
                        _token : crtoken,
                        hId : hId,
                        type: "{{$type2}}"
                    },
                    dataType:'json',
                    success: function (result) {
                        if(result == 1){
                            alert('委托成功');
                            window.location.href='/userEntrust/Qs';
                        }else{
                            alert('委托失败');
                        }
                    }
                });
            }
        });
    });*/
    var crtoken,hId,type;
    type= "{{$type2}}";
    crtoken  = $("#crtoken").val();
    $('.entrustDel').click(function(){
        $('#oprateHint').html('<i class="tan"></i>您确定删除吗');
        $('#quxiao').show();
        $('#lean_overlay').show();
        hId = $(this).attr('value');
        url='/entrustDel/sale';
    });

    $('.startEntrust').click(function(){
        $('#oprateHint').html('<i class="tan"></i>您确定开始委托吗');
        $('#quxiao').show();
        $('#lean_overlay').show();
        hId = $(this).attr('value');
        url='/userEntrust/openAll';
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
                id : hId,
                type : type
            },
            dataType:'json',
            success: function (result) {
                if(result == 1){
                    alert('操作成功!');
                    window.location.href='/userEntrust/Qs';
                }else if(result == 2){
                    alert('您所有的委托已达20个上限!');
                }else if(result == 0){
                    alert('操作失败!');
                }
            }
        });
    }
</script>
@endsection

