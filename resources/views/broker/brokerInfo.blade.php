@extends('broker.header2')
@section('content')
@include('broker.brokerHeader')
<p class="submenu">
    @if(isset($data->_source->businessHouseCount) && ($data->_source->businessHouseCount + $data->_source->hr3 +$data->_source->hs3) != 0)<a class="click" href="/brokerinfo/{{$data->_id}}.html">首页</a>@endif
    @if(isset($data->_source->hs3) && ($data->_source->hs3) != 0)<a  href="/broker/{{$data->_id}}/secondHouse">二手房</a>@endif
    @if(isset($data->_source->hs3) && ($data->_source->hr3) != 0)<a  href="/broker/{{$data->_id}}/rentHouse">租房</a>@endif
    @if(!empty($data->_source->businessHouseCount))<a  href="/broker/{{$data->_id}}/business">商业</a>@endif
    <a  href="/broker/{{$data->_id}}/detail">个人信息</a>

</p>
<div class="recommend">
    <span class="dztj"></span>
    @if(isset($data->_source->businessHouseCount) && ($data->_source->businessHouseCount + $data->_source->hr3 +$data->_source->hs3) == 0)
        <div class="recommend build_list">
            <div class="no_data">
                <div class="no_icon"></div>
                <div class="no_info">
                    <p class="p1"><span>亲</span>，该经纪人暂未发布此类型房源！</p>
                </div>
            </div>
        </div>
      @endif
    @if(!empty($saleHouse))
    @foreach($saleHouse as $key=>$val)
        @if($key>1)
         <?php break;?>
            @endif
            <dl >
            <dt><a href="/housedetail/ss{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseSale',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"></a></dt>
            <dd>
                <p class="home_name"><a href="/housedetail/ss{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                <div class="home_c">
                    <div class="info_l">
                        <p class="home_address">{{$val->_source->tmp_communityId}}&nbsp;&nbsp;{{$val->cityName}}{{$val->cityAreaName}}{{$val->businessName}}@if($val->_source->address){{$val->_source->address}}@endif</p>
                        <p class="home_type">
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
                        <p class="p1">@if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}</span>万元@endif</p>
                        <p class="p2">@if(!empty($val->_source->price1)){{$val->_source->price1}}元/平米@endif</p>
                    </div>
                </div>
            </dd>
        </dl>
    @endforeach
    @elseif(!empty($rentHouse))
        @foreach($rentHouse as $key=>$val)
            @if($key>1)
                <?php break;?>
            @endif
        <dl>
            <dt><a href="/housedetail/sr{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseRent',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"></a></dt>
            <dd>
                <p class="home_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                <div class="home_c">
                    <div class="info_l">
                        <p class="home_address">@if(empty($val->_source->name)){{$val->_source->tmp_communityId}}@else{{$val->_source->name}}@endif&nbsp;&nbsp;{{$val->cityName}}{{$val->cityAreaName}}{{$val->businessName}}@if($val->_source->address){{$val->_source->address}}@endif</p>
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
        @elseif(!empty($business))
        @foreach($business as $key=>$val)

            @if($key>1)
                <?php break;?>
            @endif
            @if($val->type == 'businessRent')
                    <dl>
                        <dt><a href="/housedetail/sr{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseRent',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"></a></dt>
                        <dd>
                            <p class="home_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                            <div class="home_c">
                                <div class="info_l">
                                    <p class="home_address">@if(empty($val->_source->name)){{$val->_source->tmp_communityId}}@else{{$val->_source->name}}@endif&nbsp;&nbsp;{{$val->cityName}}{{$val->cityAreaName}}{{$val->businessName}}@if($val->_source->address){{$val->_source->address}}@endif</p>
                                    <p class="home_type">
                                        <span>{{$val->_source->area}}平米</span>
                                        <span class="dotted"></span>
                                        <span>{{$val->_source->currentFloor}}/{{$val->_source->totalFloor}}层</span>
                                        <span>
                                            @if($val->_source->propertyFee > 0)
                                                <span class="dotted"></span>{{$val->_source->propertyFee}}元/平米·月
                                            @endif
                                        </span>
                                        <span class="dotted"></span>
                                        {{--<span>5%（未改收得率）</span>--}}
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
                                    <p class="p1">@if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}</span>元/平米▪天@endif</p>
                                    <p class="p2">@if(!empty($val->_source->price2) && !empty($val->_source->area)){{$val->_source->price2 * 30 * $val->_source->area}}元/月@endif</p>
                                </div>
                            </div>
                        </dd>
                    </dl>
                @elseif($val->type  == 'businessSale')
                    <dl >
                        <dt><a href="/housedetail/ss{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseSale',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"></a></dt>
                        <dd>
                            <p class="home_name"><a href="/housedetail/ss{{$val->_id}}.html">{{$val->_source->title}}</a></p>
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
                                    <p class="p1">@if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}</span>万元@endif</p>
                                    <p class="p2">@if(!empty($val->_source->price1)){{$val->_source->price1}}@endif/平米</p>
                                </div>
                            </div>
                        </dd>
                    </dl>
            @endif
        @endforeach
        @endif
</div>
<div class="broker_list">
    <div class="house_l">
        @if(!empty($saleHouse) && !empty($saleHouse[2]))
        <div class="house_list">
            <h2>二手房房源<a href="/broker/@if(!empty($data->_source)){{$data->_id}}@endif/secondHouse">更多>></a></h2>
            <div class="sale_house">
                @foreach($saleHouse as $k => $val)
                    @if($k <=1 )
                        <?php continue; ?>
                        @endif
                <dl>
                    <dt>
                        <a href="/housedetail/ss{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseSale',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="房源图片"></a>
                        @if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}万元</span>@endif
                    </dt>
                    <dd>
                        <p class="house_name"><a href="/housedetail/ss{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                        <p class="house_type">
                            @if(!empty(explode('_', $val->_source->roomStr)[0]))
                                {{explode('_', $val->_source->roomStr)[0]}}室
                            @endif
                            @if(!empty(explode('_',$val->_source->roomStr)[1]))
                                {{explode('_', $val->_source->roomStr)[1]}}厅
                            @endif&nbsp;&nbsp;
                                {{$val->_source->area}}平米
                                &nbsp;&nbsp;{{config('faceToConfig.'. $val->_source->faceTo)}}</p>
                    </dd>
                </dl>
                @endforeach
            </div>
        </div>

        @endif
        @if(!empty($rentHouse) && count($rentHouse) > 1)
        <div class="house_list">
            <h2>租房房源<a href="/broker/@if(!empty($data->_source)){{$data->_id}}@endif/rentHouse">更多>></a></h2>
            <div class="sale_house">
                @foreach($rentHouse as $k=>$val)
                    @if($data->_source->hs3 == 0)
                        @if($k <=1 )
                            <?php continue; ?>
                        @endif
                    @else
                        @if($k > 3 )
                            <?php break; ?>
                        @endif
                    @endif
                <dl>
                    <dt>
                        <a href="/housedetail/sr{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseRent',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="房源图片"></a>
                        @if(empty($val->_source->price1))<span class="price">面议</span>@else<span class="price">{{$val->_source->price1}}元/月</span>@endif
                    </dt>
                    <dd>
                        <p class="house_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                        <p class="house_type">{{config('houseState.Zz.rentType.'. $val->_source->houseType1)}}
                            &nbsp;&nbsp;@if(!empty(explode('_', $val->_source->roomStr)[0]))
                                {{explode('_', $val->_source->roomStr)[0]}}室
                            @endif
                            @if(!empty(explode('_',$val->_source->roomStr)[1]))
                                {{explode('_', $val->_source->roomStr)[1]}}厅
                            @endif
                            &nbsp;&nbsp;{{$val->_source->area}}平米</p>
                    </dd>
                </dl>
            @endforeach
            </div>
        </div>
            @endif
            @if(!empty($business))
        <div class="house_list">
            <h2>商业房源<a href="/broker/@if(!empty($data->_source)){{$data->_id}}@endif/business/">更多>></a></h2>
            <div class="sale_house">
                @foreach($business as $k=>$val)
                    @if(($data->_source->hr3 + $data->_source->hs3) == 0)
                      @if($k <=1 )
                        <?php continue; ?>
                     @endif
                    @else
                        @if($k > 3 )
                            <?php break; ?>
                        @endif
                    @endif
                    @if($val->type == 'businessRent')
                        <dl>
                            <dt>
                                <a href="/housedetail/sr{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseRent',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="房源图片"></a>
                                @if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}元/平米▪天</span>@endif
                            </dt>
                            <dd>
                                <p class="house_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                                <p class="house_type">{{$val->_source->area}}平米&nbsp;&nbsp;{{$val->_source->currentFloor}}/{{$val->_source->totalFloor}}层&nbsp;&nbsp;{{config('houseState.fitment.'. $val->_source->fitment)}}</p>
                            </dd>
                        </dl>
                        @else
                        <dl>
                            <dt>
                                <a href="/housedetail/ss{{$val->_id}}.html"><img src="@if(!empty($val->_source->thumbPic)){{get_img_url('houseSale',$val->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="房源图片"></a>
                                @if(empty($val->_source->price2))<span class="price">面议</span>@else<span class="price">{{$val->_source->price2}}万元</span>@endif
                            </dt>
                            <dd>
                                <p class="house_name"><a href="/housedetail/sr{{$val->_id}}.html">{{$val->_source->title}}</a></p>
                                <p class="house_type"><span>{{$val->_source->area}}平米</span>&nbsp;&nbsp;{{config('houseState.fitment.'. $val->_source->fitment)}}</p>
                            </dd>
                        </dl>
                    @endif
                    @endforeach
            </div>
        </div>
         @endif
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
