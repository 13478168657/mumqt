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
                <a href="/userEntrust/Qs">求购</a>
                <span class="click">出租</span>
                <a href="/userEntrust/sale">出售</a>

            </p>
            <div class="build_list sale">
                @if(!empty($house))
                  @foreach($house as $val)
                    <dl>
                        <dd class="width1">
                            <p class="finish_data color8d">
                                <span class="color2d" style="float: left;margin-right: 10px;">@if($val->houseType1 == 3)[租房]@elseif($val->houseType1 == 2)[楼租]@elseif($val->houseType1 == 1)[铺租]@endif</span>
                                {{--<a href="#"><strong>@if(isset($val->name)){{$val->name}}@endif</strong></a>&nbsp;&nbsp;--}}
                                <span style="float: left;margin-right: 10px;"><strong class="txt-hid" style="display: block;max-width: 112px;">@if(isset($val->name)){{$val->name}}@endif</strong></span>&nbsp;&nbsp;
                                <span class="color8d" style="float: left;"><span class="txt-hid" style="float: left;max-width: 390px;">@if(isset($val->addr)){{$val->addr}}@endif</span><i class="map_icon" style="float: left;"></i></span>
                            </p>
                            <p class="build_type color8d">
                                @if($val->houseType1 == 3)
                                <span>@if(isset(config('houseState.Zz.rentType')[$val->rentType])){{config('houseState.Zz.rentType')[$val->rentType]}}@endif</span>
                                @endif
                                <span @if($val->houseType1 == 3)class="margin_l"@endif>{{floor($val->area)}}平米</span>
                                @if($val->houseType1 == 3)
                                    <?php
                                    $room = explode('_',$val->roomStr);
                                    ?>
                                    <span class="margin_l">@if(!empty($val->roomStr)){{$room[0]}}室{{$room[1]}}厅{{$room[2]}}厨{{$room[3]}}卫@endif</span>
                                    <span class="margin_l">@if(isset(config('faceToConfig')[$val->faceTo])){{config('faceToConfig')[$val->faceTo]}}@endif</span>
                                @endif
                                <span class="margin_l">{{$val->currentFloor}}/{{$val->totalFloor}}层</span>
                                @if($val->houseType1 == 2 || $val->houseType1 == 1)
                                    <span class="margin_l">{{floor($val->price1)}}元/月</span>
                                @endif
                            </p>
                            <p class="build_type color8d">
                                <span>发布时间：</span>
                                <span>{{substr($val->timeCreate,0,10)}}</span>
                               <span class="margin_l">
                                   <?php
                                   $timeDiff = time() - strtotime($val->timeUpdate);
                                   if($timeDiff < 60){
                                       $time = $timeDiff.'秒前';
                                   }elseif( $timeDiff < 3600){
                                       $time = floor($timeDiff/60).'分钟前';
                                   }elseif($timeDiff < 3600*24){
                                       $time = floor($timeDiff/3600).'小时前';
                                   }else{
                                       $time = substr($val->timeUpdate,0,10).'日';
                                   }
                                   ?>
                                   {{$time}}更新
                               </span>
                            </p>
                        </dd>
                        <dd class="dd2">
                            <span class="colorfe">
                            @if($val->houseType1 == 3)
                            {{floor($val->price1)}}</span>&nbsp;元/月
                            @elseif($val->houseType1 == 2 || $val->houseType1 == 1)
                            {{floor($val->price2)}}</span>&nbsp;元/天/平米
                            @endif
                        </dd>
                        <dd class="comment_r">
                            @if($val->hadCommissioned <= 0)
                            <p>
                                <a @if($val->houseType1 == 3) href="/houseHelp/rent/xq/entrust?id={{$val->id}}" @elseif($val->houseType1 == 2) href="/houseHelp/rent/office/entrust?id={{$val->id}}" @elseif($val->houseType1 == 1) href="/houseHelp/rent/shop/entrust?id={{$val->id}}" @endif>
                                    编辑
                                </a>
                            </p>
                            @endif
                            @if($val->entrustState == 1)
                                @if($val->hadCommissioned > 0)
                                    <p><a href="/userEntrust/rent-{{$val->id}}">查看委托</a></p>
                                @endif
                                @if($val->hadCommissioned == 0)
                                    <p><a onclick="delEntrust('{{$val->id}}','rent')">取消委托</a></p>
                                @endif
                            @endif
                            @if($val->entrustState == 0)
                                <p><a onclick="openAll('{{$val->id}}','rent')">开启委托</a></p>
                            @endif
                            {{--<p><a>转为直租</a></p>--}}
                        </dd>
                    </dl>
                  @endforeach
                @else
                    <div class="user_r">
                        <div class="no_data">
                            <div class="no_icon"></div>
                            <div class="no_info">
                                <p class="p1"><span>亲</span>，您暂无委托任何出租房源！</p>
                                <p>去<a href="/houseHelp/rent/xq/entrust">委托房源</a></p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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

        // 开启委托
        function openAll(hId,type){
            $.ajax({
                type : 'POST',
                url : '/userEntrust/openAll',
                data : {
                    _token : "{{csrf_token()}}",
                    type : type,
                    hId : hId
                },
                dataType : 'json',
                success : function(msg){
                    if(msg == 2){
                        alert('您最多能委托20套房源');
                        location.reload();
                    }
                    if(msg == 1){
                        alert('操作成功');
                        location.reload();
                    }
                    if(msg == 0){
                        alert('操作失败');
                    }
                }
            });
        }

        // 取消委托(无经纪人认领时)
        function delEntrust(hId,type){
            $.ajax({
                type : 'POST',
                url : '/userEntrust/delEntrust',
                data : {
                    _token : "{{csrf_token()}}",
                    type : type,
                    hId : hId
                },
                dataType : 'json',
                success : function(msg){
                    if(msg == 1){
                        alert('取消委托成功');
                        location.reload();
                    }
                    if(msg == 0){
                        alert('操作失败');
                    }
                }
            });
        }
    </script>
@endsection
