@extends('broker.header2')
@section('content')
@include('broker.brokerHeader')
<p class="submenu">
    @if(isset($data->_source->businessHouseCount) && ($data->_source->businessHouseCount + $data->_source->hr3 +$data->_source->hs3) != 0)<a  href="/brokerinfo/{{$data->_id}}.html">首页</a>@endif
    @if(!empty($data->_source->hs3))<a  href="/broker/{{$data->_id}}/secondHouse">二手房</a>@endif
    @if(!empty($data->_source->hr3))<a  href="/broker/{{$data->_id}}/rentHouse">租房</a>@endif
    @if(!empty($data->_source->businessHouseCount))<a  href="/broker/{{$data->_id}}/business">商业</a>@endif
    <a  href="/broker/{{$data->_id}}/detail">个人信息</a>
</p>
<div class="broker_list">
    <div class="house_l">
        <p class="build_name">
            <span class="span1">@if(isset($result['name'])) {{$result['name']}} @endif</span>
            {{--<span class="span2">{{$result['cName']}}{{$result['aName']}}{{$result['bName']}}</span>--}}
            <span class="span2">@if(isset($result['cName'])) {{$result['cName']}} @endif @if(isset($result['aName'])) {{$result['aName']}} @endif  @if(isset($result['bName'])) {{$result['bName']}} @endif</span>
            <span class="span3">@if(isset($result['count'])) {{$result['count']}} @endif套</span>
        </p>
        <p class="select_nav">
            @if($rent_sale)
                <a @if($sure == 'r')  class='click' @endif href="/broker/{{$data->_id}}/comm/{{$id}}-rent">出租</a>
                <a @if($sure == 's') class='click' @endif href="/broker/{{$data->_id}}/comm/{{$id}}-sale">出售</a>
            @else
                @if($sure == 'r')
                    <a class='click' href="/broker/{{$data->_id}}/comm/{{$id}}-rent">出租</a>
                @elseif($sure == 's')
                    <a class='click' href="/broker/{{$data->_id}}/comm/{{$id}}-sale">出售</a>
                @endif
            @endif
        </p>
        <div class="recommend build_list">
        @if($sure == 's')
            @if($house)
            @foreach($house as $val)
            <dl>
                <dt><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseSale',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="房源图片"></dt>
                <dd>
                    <p class="home_name"><a href="/housedetail/ss{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                    <div class="home_c">
                        <div class="info_l">
                            <p class="home_type">
                                <span>{{$val->_source->area}}平米</span>
                                <span class="dotted"></span>
                                <span>@if(!empty(explode('_', $val->_source->roomStr)[0]))
                                        {{explode('_', $val->_source->roomStr)[0]}}室
                                    @endif
                                    @if(!empty(explode('_',$val->_source->roomStr)[1]))
                                        {{explode('_', $val->_source->roomStr)[1]}}厅
                                    @endif</span>
                                <span class="dotted"></span>
                                @if($val->_source->faceTo != 0)
                                <span>{{config('faceToConfig.'. $val->_source->faceTo)}}</span>
                                 <span class="dotted"></span>
                                @endif
                                <span>{{$val->_source->currentFloor}}/{{$val->_source->totalFloor}}层</span>
                                <span class="dotted"></span>
                                <span>{{config('houseState.fitment.'. $val->_source->fitment)}}</span>
                                <span class="dotted"></span>
                                <span>{{config('communityType2.'. $val->_source->houseType2)}}</span>
                            </p>
                            <p class="home_tag">
                                <?php $x=1;?>
                                @if(!empty($val->_source->tagId))
                                    @foreach(explode('|',$val->_source->tagId) as $k=>$tagid)

                                        @if(!empty($tagSet[$tagid]))
                                            <span class="tab tag1">{{$tagSet[$tagid]}}</span>
                                            <?php $x++;if($x >6) break;?>
                                        @endif
                                    @endforeach
                                @endif
                            </p>
                        </div>
                        <div class="info_r">

                            <p class="p1">@if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}</span>万元@endif</p>
                            <p class="p2">@if(!empty($val->_source->price1)){{$val->_source->price1}}元/平米@endif</p>
                        </div>
                    </div>
                </dd>
            </dl>
            @endforeach
                @else
                    <div class="recommend build_list">
                        <div class="no_data">
                            <div class="no_icon"></div>
                            <div class="no_info">
                                <p class="p1"><span>亲</span>，该经纪人暂未发布此类型房源！</p>
                            </div>
                        </div>
                    </div>
                @endif
                @else
                    @if($house)
                    @foreach($house as $val)
                        <dl>
                            <dt><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseRent',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"></dt>
                            <dd>
                                <p class="home_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                                <div class="home_c">
                                    <div class="info_l">
                                        <p class="home_type">
                                            <span>{{config('houseState.Zz.rentType.' .  $val->_source->rentType)}}</span>
                                            <span class="dotted"></span>
                                            <span>{{$val->_source->area}}平米</span>
                                            <span class="dotted"></span>
                                <span> @if(!empty(explode('_', $val->_source->roomStr)[0]))
                                        {{explode('_', $val->_source->roomStr)[0]}}室
                                    @endif
                                    @if(!empty(explode('_',$val->_source->roomStr)[1]))
                                        {{explode('_', $val->_source->roomStr)[1]}}厅
                                    @endif</span>
                                            <span class="dotted"></span>
                                            @if($val->_source->faceTo != 0)
                                                <span>{{config('faceToConfig.'. $val->_source->faceTo)}}</span>
                                                <span class="dotted"></span>
                                            @endif
                                            <span>{{$val->_source->currentFloor}}/{{$val->_source->totalFloor}}层</span>
                                            <span class="dotted"></span>
                                            <span>{{config('houseState.fitment.'. $val->_source->fitment)}}</span>
                                            <span class="dotted"></span>
                                            <span>{{config('communityType2.'. $val->_source->houseType2)}}</span>
                                        </p>
                                        <p class="home_tag">
                                            <?php $x=1;?>
                                            @if(!empty($val->_source->tagId))
                                                @foreach(explode('|',$val->_source->tagId) as $k=>$tagid)

                                                    @if(!empty($tagSet[$tagid]))
                                                        <span class="tab tag1">{{$tagSet[$tagid]}}</span>
                                                        <?php $x++;if($x >6) break;?>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </p>
                                    </div>
                                    <div class="info_r">
                                        <p class="p1">@if(empty($val->_source->price1))<span class="price">面议</span>@else<span class="price">{{$val->_source->price1}}</span>元/月@endif</p>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    @endforeach
                        @else
                    <div class="recommend build_list">
                        <div class="no_data">
                            <div class="no_icon"></div>
                            <div class="no_info">
                                <p class="p1"><span>亲</span>，该经纪人暂未发布此类型房源！</p>
                            </div>
                        </div>
                    </div>
                        @endif
                @endif
            <div class="page_nav">
                <ul>
                    {!!$page!!}
                </ul>
            </div>
        </div>
    </div>
    @include('broker.brokerRight')
</div>
<script>
    $(document).ready(function(e) {
        $(".head dl dd").hover(function(){
            $(this).find(".hot_city").show();
        },function(){
            $(this).find(".hot_city").hide();
        });
    });
</script>
@endsection
