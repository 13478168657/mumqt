@extends('mainlayout')
@section('title')
    <title>经纪人列表</title>

    <link rel="stylesheet" type="text/css" href="/css/list.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
    <body>
<p class="route line_height">
    <span>您的位置：</span>
    <a href="/">首页</a>
    <span>&nbsp;>&nbsp;</span>
    <a href="/brokerlist" class="colorfe">{{CURRENT_CITYNAME}}经纪人列表</a>
</p>
<div class="list">
    <div class="list_term broker_list" style="border-top:1px solid #cbcbcb;">
        <dl>
            <dt class="color_grey">区域：</dt>
            <dd>
                <a href="{{$hosturl}}?cityAreaId=&page=1" class="@if(empty($brokerlist->cityAreaId)) color_blue @endif cityAreaId" value="0">不限</a>
                @foreach($data['cityarea'] as $dkey=>$dval)
                    <a href="{{$hosturl}}?cityAreaId={{$dval->id}}" class="@if(!empty($brokerlist->cityAreaId) && $dval->id == $brokerlist->cityAreaId) color_blue active_select  @endif cityAreaId" value="{{$dval->id}}">{{$dval->name}}</a>
                @endforeach
            </dd>

        </dl>
    </div>
    <div class="broker_entry list_c">
        <div class="list_l">
            <h2><span>全部经纪人</span></h2>
            <ul>
                @if(!empty($hits->hits))
                    @foreach($hits->hits as $key=>$val)
                <li>
                    <dl>
                        <dt>  <a href="/brokerinfo/{{$val->_source->id}}.html"> <img src="{{!empty($val->_source->photo)?get_img_url('userPhoto',$val->_source->photo,8):"/image/default_broker.png"}}" alt="{{$val->_source->realName}}" onerror="javascript:this.src='/image/default_broker.png';"></a></dt>
                        <dd>
                            <a href="/brokerinfo/{{$val->_source->id}}.html" class="broker_name">{{$val->_source->realName}}</a>
                            <p>{{$val->_source->company}}<span class="margin_l">
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
                                </span></p>
                            <p>在租：<a class="color_blue" href="/broker/{{$val->_source->id}}/rentHouse">@if(empty($val->_source->hr3))0 @else {{$val->_source->hr3}}@endif</a>套
                                <span class="margin_l">在售：<a class="color_blue" href="/broker/{{$val->_source->id}}/secondHouse">@if(empty($val->_source->hs3))0 @else {{$val->_source->hs3}}@endif</a>套
                                </span><span class="margin_l">商业：<a class="color_blue" href="/broker/{{$val->_source->id}}/business">@if(empty($val->_source->businessHouseCount))0 @else {{$val->_source->businessHouseCount}}@endif</a>套</span></p>
                        </dd>
                        <dd class="dd">
                            <span><i></i>{{$val->_source->mobile}}</span>
                        </dd>
                    </dl>
                    <div class="house_list">
                        @if(!empty($val->house->hits) && count($val->house->hits > 1))
                            @foreach($val->house->hits as  $v)
                        <dl>
                            <dt>
                                <span class="yx"></span>
                                <a href="/housedetail/ss{{$v->_id}}.html"><img src=" @if(!empty($v->_source->thumbPic)){{get_img_url('houseSale',$v->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="房源图片"></a>
                                @if(empty($v->_source->price2))<span class="price">面议</span>@else<span class="price">{{$v->_source->price2}}万</span>@endif
                            </dt>
                            <dd>
                                <p class="house_name"><a href="/housedetail/ss{{$v->_id}}.html">{{$v->_source->title}}</a></p>
                                <p class="house_type">@if(!empty(explode('_',$v->_source->roomStr)[0])){{explode('_', $v->_source->roomStr)[0]}}室@endif @if(!empty(explode('_',$v->_source->roomStr)[1])){{explode('_', $v->_source->roomStr)[1]}}厅@endif&nbsp;&nbsp;&nbsp;&nbsp;{{$v->_source->area}}平米</p>
                            </dd>
                        </dl>
                            @endforeach
                        @endif
                    </div>
                </li>
                    @endforeach
                    @else
                    <div class="no_state no_border">
                        <div class="state_l"><img src="/image/no_state2.png" alt="无数据"></div>
                        <div class="state_r">
                            <p class="p1">很抱歉，没有找到相关的经纪人！</p>
                            <div class="p2">
                                <span class="title">温馨提示</span><br>
                                <span class="state"><span class="dotted"></span>尝试切换到其他频道</span><br>
                                <span class="state"><span class="dotted"></span>您可以尝试切换到其他城市</span><br>
                            </div>
                        </div>
                    </div>
                @endif
            </ul>
            <div class="page_nav">
                <ul>
                    {!!$pageBar!!}
                </ul>
            </div>
        </div>
        @if(isset($xiaoqu))
        <div class="list_r">
            <div class="banner"><img src="/image/module_banner_right.jpg" alt="广告图"></div>
            @if(!empty($xiaoqu))
            <div class="spread_new" id="spread">
                <p class="price_title"><a href="/saleesb/area">推荐小区>></a></p>
                @foreach($xiaoqu as $val)
                <dl>
                    <dt>
                        <a href="/esfindex/{{$val->_id}}/301.html" target="_blank">
                        <img src="@if(!empty($val->_source->titleImage)){{get_img_url('commPhoto',$val->_source->titleImage)}}@else{{$defaultImage}}@endif" alt="{{$val->_source->name}}" >
                            <?php $priceSaleAvg = 'priceSaleAvg3'?>
                            @if(!empty($val->_source->$priceSaleAvg))
                                    <span class="price price1">{{floor($val->_source->$priceSaleAvg)}}元/平</span>
                            @else
                                <span class="price price1">未知</span>
                            @endif
                        </a>
                    </dt>
                    <dd class="build_name"><a href="/esfindex/{{$val->_id}}/301.html">{{$val->_source->name}}</a></dd>
                    <dd>{{$val->cityAreaName}}▪{{$val->businessName}}&nbsp;&nbsp;&nbsp;&nbsp;
                        @if($val->_source->rentCount)
                        {{$val->_source->rentCount}}套在租
                        @endif
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    @if($val->_source->saleCount)
                            {{$val->_source->saleCount}}套在售
                        @endif
                        </dd>
                </dl>
                @endforeach
            </div>
            @endif
            @endif
              @if(isset($hotComm))
                  <div class="spread_new">
                      @if($type == 'broker' )
                          <p class="price_title"><a href="/new/area">热销新盘>></a></p>
                      @endif
                      @foreach($hotComm as $k => $hotFloor)
                          <dl>
                              <a href="/xinfindex/{{$hotFloor->_source->id}}/{{$hotFloor->_source->type2}}.html"  target="_blank">
                                  <dt><img src="@if(!empty($hotFloor->_source->titleImage)){{get_img_url('commPhoto',$hotFloor->_source->titleImage)}}@else{{$defaultImage}}@endif" alt="{{$hotFloor->_source->name}}"><span class="sale"></span></dt>
                                  <dd class="build_name">{{$hotFloor->_source->name}}<span>[{{$hotFloor->_source->areaname}}]</span></dd>
                                  <?php $priceSaleAvg = 'priceSaleAvg'.$hotFloor->_source->type2; ?>
                                  <dd>@if(!empty($hotFloor->_source->zhehui)){{$hotFloor->_source->zhehui}}&nbsp;&nbsp;&nbsp;@endif @if($hotFloor->_source->type1 == 1)商铺 @elseif($hotFloor->_source->type1 == 2) 写字楼 @else 住宅 @endif &nbsp;&nbsp;&nbsp;
                                      @if(!empty($hotFloor->_source->$priceSaleAvg))
                                          {{$hotFloor->_source->$priceSaleAvg}}元/平米
                                      @else 待定
                                      @endif
                                  </dd>
                              </a>
                          </dl>
                      @endforeach
                  </div>
              @endif
        </div>
    </div>
</div>
<div class="web_map">
    @include('broker.footer1',['sr'=>'s','type'=>'esfsale','xiaoqu'=>'rentesb'])
</div>

<script>
    $(document).ready(function(e) {
        $(".broker_msg .dd3 .a").click(function(){
            $(this).hide();
            $(this).next().show();
        });
        $(".broker_msg .dd3 .b").click(function(){
            $(this).hide();
            $(this).parent().find(".a").show();
        });
    });
</script>

@endsection