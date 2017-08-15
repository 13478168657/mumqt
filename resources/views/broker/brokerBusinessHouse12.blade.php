@extends('broker.header2')
@section('content')
@include('broker.brokerHeader')
<p class="submenu">
    @if(isset($data->_source->businessHouseCount) && ($data->_source->businessHouseCount + $data->_source->hr3 +$data->_source->hs3) != 0)<a  href="/brokerinfo/{{$data->_id}}.html">首页</a>@endif
    @if(!empty($data->_source->hs3))<a  href="/broker/{{$data->_id}}/secondHouse">二手房</a>@endif
    @if(!empty($data->_source->hr3))<a  href="/broker/{{$data->_id}}/rentHouse">租房</a>@endif
    @if(!empty($data->_source->businessHouseCount))<a  class="click" href="/broker/{{$data->_id}}/business">商业</a>@endif
    <a  href="/broker/{{$data->_id}}/detail">个人信息</a>
</p>
<div class="broker_list">
    <div class="house_l">
        <p class="select_nav">
            @if(!empty($data->_source->hr2))<a  href="/broker/{{$data->_id}}/business/22">写字楼出租</a>@endif
            @if(!empty($data->_source->hs2)) <a  href="/broker/{{$data->_id}}/business/21">写字楼出售</a>@endif
            @if(!empty($data->_source->hr1)) <a class="click" href="/broker/{{$data->_id}}/business/12">商铺出租</a>@endif
            @if(!empty($data->_source->hs1)) <a href="/broker/{{$data->_id}}/business/11">商铺出售</a>@endif
        </p>
        <div class="recommend build_list">
            @if(empty($house->hits))
                <div class="recommend build_list">
                    <div class="no_data">
                        <div class="no_icon"></div>
                        <div class="no_info">
                            <p class="p1"><span>亲</span>，该经纪人暂未发布此类型房源！</p>
                        </div>
                    </div>
                </div>
                @else
                @foreach($house->hits as $val)

                    <dl>
                        <dt><a href="/housedetail/sr{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseRent',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"></a></dt>
                        <dd>
                            <p class="home_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                            <div class="home_c">
                                <div class="info_l">
                                    <p class="home_address">@if(empty($val->_source->name)){{$val->_source->tmp_communityId}}@else{{$val->_source->name}}@endif&nbsp;&nbsp;{{$val->cityName}}{{$val->cityAreaName}}{{$val->businessName}}@if($val->_source->address){{$val->_source->address}}@endif</p>
                                    <p class="home_type">
                                        <span>{{config('houseState.shop.stateShop.'. $val->_source->stateShop)}}</span>
                                        <span class="dotted"></span>
                                        <span>{{$val->_source->area}}平米</span>
                                        <span>
                                            @if($val->_source->propertyFee > 0)
                                                <span class="dotted"></span>{{$val->_source->propertyFee}}元/平米·月
                                            @endif
                                        </span>
                                        <span class="dotted"></span>
                                        <span>{{$val->_source->currentFloor}}/{{$val->_source->totalFloor}}层</span>
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
                                    <p class="p1">@if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}</span>元/平米▪天@endif</p>
                                    <p class="p2">@if(!empty($val->_source->price2) && !empty($val->_source->area)){{$val->_source->price2 * 30 * $val->_source->area}}元/月@endif</p>
                                </div>
                            </div>
                </dd>
            </dl>

                    @endforeach
            @endif
            <div class="page_nav">
                <ul>
                    {!!$pageBar!!}
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
