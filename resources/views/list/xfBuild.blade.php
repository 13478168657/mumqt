@extends('mainlayout')
@include('list.header')
@section('content')
    @yield('xcssjs')
    @yield('xsearch')
    <p class="route">
        <span>您的位置：</span>
        <a href="/">首页</a>
        <span>&nbsp;>&nbsp;</span>
        <a href="{{$linkurl}}">{{$cityName}} 新房新盘</a>
        @if(!empty($cityareaid))
            <span>&nbsp;>&nbsp;</span>
            <a href="{{$linkurl}}/aa{{$cityareaid}}">{{$cityAreaName}}</a>
        @endif
        @if(!empty($busid))
            <span>&nbsp;>&nbsp;</span>
            <a href="{{$linkurl}}/aa{{$cityareaid}}-ab{{$busid}}">{{$businessAreaName}}</a>
        @endif
    </p>
    <div class="list">
        <div class="list_nav">
            <div class="nav_l">
                <a class="<?=($subtype == 'area')?'click color_blue border_blue':''?>" href="/{{$type}}/area">区域查询</a>
                @if(!empty($subWay))
                        <!--  <a class="<?=($subtype == 'sub')?'click color_blue border_blue':''?>" href="/{{$type}}/sub">地铁查询</a> -->
                @endif
            </div>
        </div>
        <div class="list_term">
            <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
            <input type="hidden" id="linkurl"  value="{{$linkurl}}" >
            <input type="hidden" id="par"  value="{{$purl}}" >
            <!--如果子类为学区则显示类别-->
            @if($subtype == 'school')
                <dl>
                    <dt class="color_grey">类别：</dt>
                    <dd>
                        @if(!empty($schools))
                            @foreach($schools as $k=>$v)
                                @if($school == $k)
                                    @if(!empty($school))
                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'aj',$k)}}" class="color_blue acon" con="aj">{{$v}}</a>
                                    @else
                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'aj',$k)}}" class="color_blue">{{$v}}</a>
                                    @endif
                                @else
                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'aj',$k)}}">{{$v}}</a>
                                @endif
                            @endforeach
                        @endif
                    </dd>
                </dl>
                @endif
                        <!--根据子类显示不同的选项-->
                @if(($subtype == 'area') || ($subtype == 'model') || ($subtype == 'house') || ($subtype == 'school'))
                    <dl>
                        <dt class="color_grey">区域：</dt>
                        <dd>
                            @if(!empty($cityArea))
                                @if(empty($cityareaid))
                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'aa')}}" class="color_blue">不限</a>
                                @else
                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'aa')}}" >不限</a>
                                @endif

                                @foreach($cityArea as $v)
                                    @if($cityareaid == $v->id)
                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'aa',$v->id)}}" class="color_blue acon"  con="aa">{{$v->name}}</a>
                                    @else
                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'aa',$v->id)}}">{{$v->name}}</a>
                                    @endif
                                @endforeach
                            @endif
                        </dd>
                        <!--如果子类为学区则不显示子区域-->
                        @if($subtype != 'school')
                            @if(count($businessArea)>0)
                                <dd class="list_area border_blue">
                            @else
                                <dd class="">
                                    @endif

                                    @if(!empty($businessArea))
                                        @if(empty($busid))
                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ab')}}" class="color_blue" >不限</a>
                                        @else
                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ab')}}">不限</a>
                                        @endif
                                        @foreach($businessArea as $k=>$v)
                                            <span>{{$k}}</span>
                                            @foreach($v as $bus)
                                                @if($busid == $bus['id'])
                                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'ab',$bus['id'])}}" class="color_blue acon" attr="{{$bus['id']}}" con="ab">{{$bus['name']}}</a>
                                                @else
                                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'ab',$bus['id'])}}" >{{$bus['name']}}</a>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif
                                </dd>
                            @endif
                    </dl>
                @elseif($subtype == 'sub')
                    @if(!empty($subWay))
                        <dl>
                            <dt class="color_grey">地铁：</dt>
                            <dd>
                                @if(empty($subid))
                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'ac')}}" class="color_blue">不限</a>
                                @else
                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'ac')}}">不限</a>
                                @endif

                                @foreach($subWay as $sub)
                                    @if($sub->id == $subid)
                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'ac',$sub->id)}}" class="color_blue acon"  con="ac">{{$sub->name}}</a>
                                    @else
                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'ac',$sub->id)}}" >{{$sub->name}}</a>
                                    @endif
                                @endforeach
                            </dd>

                            @if(!empty($subWayStation))
                                @if(count($subWayStation)>0)
                                    <dd class="list_area border_blue" id="list_sub">
                                @else
                                    <dd class="" id="list_sub">
                                        @endif

                                        @if(empty($stationid))
                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ad')}}" class="color_blue">不限</a>
                                        @else
                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ad')}}">不限</a>
                                        @endif

                                        @foreach($subWayStation as $station)
                                            @if($station->id == $stationid)
                                                <a href="{{$linkurl}}/{{get_url_by_id($purl,'ad',$station->id)}}" class="color_blue acon"  con="ad">{{$station->name}}</a>
                                            @else
                                                <a href="{{$linkurl}}/{{get_url_by_id($purl,'ad',$station->id)}}">{{$station->name}}</a>
                                            @endif
                                        @endforeach
                                    </dd>
                                @endif
                        </dl>
                        <dl>
                            <dt class="color_grey">距离：</dt>
                            <dd>
                                @if(!empty($distances))
                                    @foreach($distances as $k=>$v)
                                        @if($distance == $k)
                                            @if(!empty($distance))
                                                <a href="{{$linkurl}}/{{get_url_by_id($purl,'ai',$k)}}" class="color_blue acon" con="ai">{{$v}}</a>
                                            @else
                                                <a href="{{$linkurl}}/{{get_url_by_id($purl,'ai',$k)}}" class="color_blue" >{{$v}}</a>
                                            @endif
                                        @else
                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ai',$k)}}">{{$v}}</a>
                                        @endif
                                    @endforeach
                                @endif
                            </dd>
                        </dl>
                        @endif
                        @endif
                                <!--房源和学区不显示房屋类型-->
                        @if(($subtype != 'sub') && ($subtype != 'school'))
                            <dl>
                                <dt class="color_grey">类型：</dt>
                                <dd>
                                    @if(count($housetypes)>0)
                                        @foreach($housetypes as $k=>$v)
                                            <?php if($k == 304 || $k == 305){ continue;} ?>
                                            @if($housetype2 == $k)
                                                @if(!empty($housetype2))
                                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="color_blue acon" con="an">{{$v}}</a>
                                                @else
                                                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="color_blue" >{{$v}}</a>
                                                @endif
                                            @else
                                                <a  href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a>
                                            @endif
                                        @endforeach
                                    @endif
                                </dd>
                            </dl>
                            @endif

                                    <!--学区不显示价格-->
                            @if($subtype != 'school')
                                <dl>
                                    <dt class="color_grey">
                                        @if($type == 'second')
                                            均价：
                                        @elseif(($type == 'shops') || ($type == 'office'))
                                            价格：
                                        @else
                                            @if($subtype == 'house')
                                                总价：
                                            @else
                                                价格：
                                            @endif
                                        @endif
                                    </dt>
                                    <dd>
                                        @if(count($averageprices)>0)
                                            @foreach($averageprices as $k=>$v)
                                                @if($averageprice == $k)
                                                    @if(!empty($averageprice))
                                                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="color_blue acon" con="ao">{{$v}}</a>
                                                    @else
                                                        @if(!empty($inputprice))
                                                            <a  class="acon" attr="{{$inputprice}}" con="bm" style="display:none">{{$inputprice}}</a>
                                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" >{{$v}}</a>
                                                        @else
                                                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="color_blue" attr="{{$k}}">{{$v}}</a>
                                                        @endif
                                                    @endif
                                                @else
                                                    <a  href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}">{{$v}}</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <span class="color8d left">
                                            @if($subtype == 'house')
                                                总价（万元）
                                            @else
                                                单价（元/平米）
                                            @endif
                                        </span>
                                        <div class="prc">
                                            <span class="prc_l"><input type="text" class="txt startprice" value="<?=$inputprice?explode(',',$inputprice)[0]:''?>"></span>
                                            <span class="dotted"></span>
                                            <span class="prc_l"><input type="text" class="txt endprice" value="<?=$inputprice?explode(',',$inputprice)[1]:''?>"></span>
                                            <input type="button" class="btn avgbtn" value="确定">
                                        </div>
                                    </dd>
                                </dl>
                                @endif

                                <!--学区不显示更多条件-->
                                @if(($subtype !='school'))
                                    <dl class="more_term">
                                        <dt>更多条件：</dt>
                                        @if($subtype == 'sub')
                                            <dd class="term">
                                                <a class="term_title"><span>
                                                        @if(!empty($housetype2))
                                                            {{$housetypes[$housetype2]}}
                                                        @else
                                                            类型
                                                        @endif
                                                    </span><i class="arrow"></i>
                                                </a>
                                                <div class="list_tag">
                                                    <p class="top_icon"></p>
                                                    <ul>
                                                        @if(!empty($housetypes))
                                                            @foreach($housetypes as $k=>$v)
                                                                @if($housetype2 == $k)
                                                                    @if(!empty($housetype2))
                                                                        <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="acon" alt="{{$k}}" con="an">{{$v}}</a></li>
                                                                    @else
                                                                        <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a></li>
                                                                    @endif
                                                                @else
                                                                    <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a></li>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </dd>
                                        @endif
                                        <dd class="term">
                                            {{--<a class="term_title">--}}
                                                {{--<span>--}}
                                                    {{--@if($salesStatusPeriods !='')--}}
                                                        {{--{{$salestatus[$salesStatusPeriods]}}--}}
                                                    {{--@else--}}
                                                        {{--销售状态--}}
                                                    {{--@endif--}}
                                                {{--</span><i class="arrow"></i>--}}
                                            {{--</a>--}}
                                            @if($salesStatusPeriods !='')
                                            <a class="term_title">
                                                <span>
                                                     {{$salestatus[$salesStatusPeriods]}}
                                                </span><i class="arrow"></i>
                                            </a>
                                            @endif
                                            <div class="list_tag">
                                                <p class="top_icon"></p>
                                                <ul>
                                                    @if(!empty($salestatus))
                                                        <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax')}}">不限</a></li>
                                                        @foreach($salestatus as $k=>$v)
                                                            @if($salesStatusPeriods == $k)
                                                                @if($salesStatusPeriods !='')
                                                                    <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax',$k)}}" class="acon" alt="{{$k}}" con="ax">{{$v}}</a></li>
                                                                @else
                                                                    <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax',$k)}}">{{$v}}</a></li>
                                                                @endif
                                                            @else
                                                                <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax',$k)}}">{{$v}}</a></li>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </dd>
                                        @if($subtype !='house')
                                            <dd class="term">
                                                <a class="term_title">
                                                    <span>
                                                        @if(!empty($openTimePeriods))
                                                            {{$opentimes[$openTimePeriods]}}
                                                        @else
                                                            开盘时间
                                                        @endif
                                                    </span><i class="arrow"></i>
                                                </a>
                                                <div class="list_tag">
                                                    <p class="top_icon"></p>
                                                    <ul class="openTimePeriods">
                                                        @if(!empty($opentimes))
                                                            @foreach($opentimes as $k=>$v)
                                                                @if($openTimePeriods == $k)
                                                                    @if(!empty($openTimePeriods))
                                                                        <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',$k)}}" class="acon"  con="ay">{{$v}}</a></li>
                                                                    @else
                                                                        <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',$k)}}">{{$v}}</a></li>
                                                                    @endif
                                                                @else
                                                                    <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',$k)}}">{{$v}}</a></li>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </dd>
                                        @endif
                                    </dl>
                                @endif
        </div>
        <div class="list_c">
            <div class="list_l">
                <div class="type_nav" style="border-bottom:none;">
                    <div class="property_type" style="float: none;border-bottom: 2px solid #4c9ed9;">
                        @if(($subtype =='area'))
                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ay')}}" class="build {{($openTimePeriods !=1)?'click':''}}" alt="0">全部楼盘</a>
                            <!--  <a class="build {{($subbuild=='1')?'click':''}}" alt="1">热门楼盘</a> -->
                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',1)}}" class="build {{($openTimePeriods=='1')?'click':''}}" alt="1">本月开盘</a>
                        @endif
                        @if(($subtype =='sub'))
                            <a class="build {{($subbuild=='0')?'click':''}}" alt="0">全部楼盘</a>
                            <!--<a class="build {{($subbuild=='1')?'click':''}}" alt="1">特惠楼盘</a>
                  <a class="build {{($subbuild=='3')?'click':''}}" alt="3">众筹楼盘</a> -->
                        @endif
                        @if($subtype == 'model')
                            <a class="build model {{($model=='0')?'click':''}}" attr="0">全部户型</a>
                            <a class="build model {{($model=='1')?'click':''}}" attr="1">一居户型</a>
                            <a class="build model {{($model=='2')?'click':''}}" attr="2">二居户型</a>
                            <a class="build model {{($model=='3')?'click':''}}" attr="3">三居户型</a>
                            <a class="build model {{($model=='4')?'click':''}}" attr="4">四居以上户型</a>
                        @endif
                        @if($subtype == 'school')
                            <a class="build click">全部学校</a>
                        @endif
                    </div>
                    <div style="padding:10px 10px 4px;">
                        <span class="build_num color2d">共<span class="colorfe fontA">{{$total}}</span>个符合条件的楼盘</span>
                        <div style="float: left;" class="sort_nav">
                            <span class="sort color2d">排序：</span>
                            @if($type !='second')
                                <a class="sort_icon {{($order=='')?'sort_click':''}}"><span>默认</span></a>
                            @endif
                            <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi',$priceAvgKey),'bj',($order==$priceAvg)?$asc:0)}}" class="sort_icon {{($order==$priceAvg)?'sort_click':''}}"><span >价格</span><i class="{{(($order.$asc)==$priceAvg.'1')?'':'click'}}"></i></a>

                            @if(($subtype != 'model') && ($subtype != 'house') && ($subtype != 'school'))
                                <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi','4'),'bj',($order=='openTimeLong')?$asc:0)}}" class="sort_icon {{($order=='openTimeLong')?'sort_click':''}}"><span  >开盘时间</span><i  class="{{(($order.$asc)=='openTimeLong1')?'':'click'}}"></i></a>
                                <!-- <a class="sort_icon {{($order=='comment')?'sort_click':''}}"><span  alt="{{$order.$asc}}">点评数</span><i  class="{{(($order.$asc)=='comment0')?'':'click'}}"></i></a> -->
                            @else
                                <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi','3'),'bj',($order=='area')?$asc:0)}}" class="sort_icon {{($order=='area')?'sort_click':''}}"><span  alt="{{$order.$asc}}">面积</span><i  class="{{(($order.$asc)=='area1')?'':'click'}}"></i></a>
                            @endif
                        </div>
                        <div class="clear"></div>
                    </div>

                </div>
                <div class="build_list">
                    @if(!empty($resBool)&&!empty($builds))
                        <p class="no_data">很抱歉，没有找到与“<span id="condition"></span>”相符的楼盘！</p>
                        <h2 class="title_house">您可能感兴趣的楼盘</h2>
                    @endif
                    @if(!empty($builds))
                        @foreach($builds as $build)
                            <?php
                            if(!empty($housetype2)){
                                $type2 = $housetype2;
                            }else{
                                $type2 = '';
                                foreach(explode('|',$build->_source->type2) as $tp2){
                                    if($tp2 == 202) continue;
                                    if(substr($tp2,0,1) == $housetype1){
                                        $type2 = $tp2;
                                        break;
                                    }
                                }
                            }
                            if(!empty($type2)){
                                $typeInfo = 'type'.$type2.'Info';
                                if(!empty($build->_source->$typeInfo)){
                                    $typeInfo = json_decode($build->_source->$typeInfo);
                                }else{
                                    $typeInfo = '';
                                }
                            }else{
                                $type2 = '301';
                                $typeInfo = '';
                            }
                            $titleImage = 'titleImage_'.$type2;
                            ?>
                            <dl>
                                <dt>
                                    <a href="/xinfindex/{{$build->_source->id}}/{{$type2}}.html"  target="_blank"><img src="@if(!empty($build->_source->$titleImage)){{get_img_url('commPhoto',$build->_source->$titleImage)}}@else{{$defaultImage}}@endif" alt="标题图"></a>
                                </dt>
                                <dd class="margin_l">
                                    <p class="build_name margin_b">
                                        <a href="/xinfindex/{{$build->_source->id}}/{{$type2}}.html" class="name build_width"  target="_blank">{{$build->_source->name}}</a>
                                        <?php
                                        $discountType = !empty($build->_source->discountType)?$build->_source->discountType:0;
                                        $zhehui = '';
                                        $youhui = '';
                                        if(($discountType == 1) && !empty($build->_source->discount)){
                                            $zhehui = $build->_source->discount.'折';
                                        }elseif(($discountType == 2)&&!empty($build->_source->subtract)){
                                            $zhehui = '减去'. floor($build->_source->subtract);
                                        }elseif(($discountType == 3)&& !empty($build->_source->discount)&&!empty($build->_source->subtract)){
                                            $zhehui = $build->_source->discount.'折减'. floor($build->_source->subtract);
                                        }
                                        if(!empty($build->_source->specialOffers) && strlen($build->_source->specialOffers)>2 && ($build->_source->specialOffers !='0_0')){
                                            $youhui = str_replace('_','抵',$build->_source->specialOffers);
                                        }
                                        ?>
                                        @if(!empty($zhehui)||!empty($youhui))
                                            <span class="dis"><i></i>
                                        <span class="dis_content">{{$zhehui}} {{$youhui}}</span>
                                    </span>
                                        @endif
                                    </p>
                                    <p class="finish_data color8d margin_b">
                                          <span class="span">
                                              @if(!empty($cityAreas[$build->_source->cityAreaId]) && !empty($businessAreas[$build->_source->businessAreaId]))
                                                  <span class="quyu">[<span>{{!empty($build->_source->cityAreaId)?@$cityAreas[$build->_source->cityAreaId]:''}}</span><span>{{(!empty($build->_source->businessAreaId)&&!empty($businessAreas[$build->_source->businessAreaId]))?'-'.@$businessAreas[$build->_source->businessAreaId]:''}}</span>]</span>&nbsp;&nbsp;
                                              @endif
                                              @if(!empty($build->_source->address))
                                                  <span class="address1">{{$build->_source->address}}</span>
                                              @endif
                                          </span>
                                        @if(!empty($build->_source->address))
                                            <a href="/communitymap/new/house?communityId={{$build->_source->id}}&longitude={{$build->_source->longitude}}&latitude={{$build->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                                        @endif
                                    </p>
                                    <p class="build_type color8d margin_b">
                                        <span>户型：</span>
                                        <span><span class="fontA">1</span>室(<span class="fontA">{{!empty($build->_source->countRoom1)?$build->_source->countRoom1:0}}</span>)</span>
                                        <span>丨</span>
                                        <span><span class="fontA">2</span>室(<span class="fontA">{{!empty($build->_source->countRoom2)?$build->_source->countRoom2:0}}</span>)</span>
                                        <span>丨</span>
                                        <span><span class="fontA">3</span>室(<span class="fontA">{{!empty($build->_source->countRoom3)?$build->_source->countRoom3:0}}</span>)</span>
                                        <span>丨</span>
                                        <span><span class="fontA">4</span>室(<span class="fontA">{{!empty($build->_source->countRoom4)?$build->_source->countRoom4:0}}</span>)</span>
                                    </p>
                                    <p class="build_tag">
                                        <?php $x=1;?>
                                        @if(!empty($typeInfo->tagIds))
                                            @foreach(explode('|',$typeInfo->tagIds) as $k=>$tagid)
                                                @if(!empty($featurestag[$tagid]))
                                                    <span class="tag{{$tagid}}">{{$featurestag[$tagid]}}</span>
                                                    <?php $x++;if($x >5) break;?>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if(!empty($typeInfo->diyTagIds) && !empty($diyTagBuilds))
                                            @foreach(explode('|',$typeInfo->diyTagIds) as $k=>$tid)
                                                @if(!empty($diyTagBuilds[$tid]))
                                                    <?php if($x >5) break;$x++;?>
                                                    <span class="data_tag">{{$diyTagBuilds[$tid]}}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </p>
                                </dd>
                                <dd class="right">
                                    <p class="build_price color2d margin_top">{{--dd($priceAvg)--}}
                                        <?php
                                            $priceUnit = $priceAvg.'Unit';
                                            if(isset($build->_source->$priceUnit) && $build->_source->$priceUnit == 2){
                                                $ptype = '万元/套';
                                            }else{
                                                $ptype = '元/平米';
                                            }
                                        ?>
                                        @if(!empty($build->_source->$priceAvg))
                                            均价<span class="colorfe fontA">{{$build->_source->$priceAvg}}</span>{{$ptype}}
                                        @else
                                            <span class="colorfe fontA">待定</span>
                                        @endif
                                    </p>
                                    <p class="handle margin_top1">
                                        <a class="color66"><span class="focus" value="{{$build->_source->id}},3,{{$housetype1}},1"><i class="follow"></i><span>{{(!empty($interest)&&(in_array($build->_source->id,$interest))?'已关注':'关注')}}</span></span></a>
                                        <a href="javascript:void(0);" onclick='addBuildCompare({{$build->_source->id}},"{{$build->_source->name}}",1,{{$housetype1}});' class="color66"><i class="contrast"></i>对比</a>
                                    </p>
                                </dd>
                            </dl>
                        @endforeach
                    @else
                        <p class="no_data">很抱歉，没有找到与“<span id="condition"></span>”相符的楼盘！</p>
                    @endif
                </div>
                <div class="page_nav">
                    <ul>
                        {!!$pagingHtml!!}
                    </ul>
                </div>
            </div>
            <div class="list_r">
               @if($admodels->modelId == 1)
                <script type="text/javascript" src="/adShow.php?position=6&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShow.php?position=7&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShow.php?position=8&cityId={{CURRENT_CITYID}}"></script>
               @elseif($admodels->modelId == 2)
                <script type="text/javascript" src="/adShowModel.php?position=19&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShowModel.php?position=20&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShowModel.php?position=21&cityId={{CURRENT_CITYID}}"></script>
               @endif
<!--            	<div class="list_adv">
			       	<a href="/adVisitCount?id=48&amp;target=aHR0cHM6Ly9kZXRhaWwudG1hbGwuY29tL2l0ZW0uaHRtP3NwbT1hMXoxMC41LWItcy53NDAxMS0xNDg5NTg5Njg3OC4yMi5mQ09INHAmaWQ9NTMxOTIyMTY3OTkwJnJuPWFmNjE2NjNhNDJmMmRjYTJhYjJkODk0MjQ0ODE0MmRhJmFiYnVja2V0PTI=" target="_blank" ><img src="../../image/arlo_list.jpg" width="208" height="240" alt="广告"></a>
			    </div>
                <div class="list_adv">
                    <a href="/ad/spread" target="_blank" ><img src="../../image/module_banner_right.jpg" width="208" height="240" alt="广告"></a>
                </div>-->
                @if($hotComm)
                    <div class="spread_new">
                        <p class="price_title"><a href="/new/area">热销新盘>></a></p>
                        @foreach($hotComm as $k => $hotFloor)
                            <dl>
                                <a href="/xinfindex/{{$hotFloor->_source->id}}/{{$hotFloor->_source->type2}}.html"  target="_blank">
                                    <dt><img src="@if(!empty($hotFloor->_source->titleImage)){{get_img_url('commPhoto',$hotFloor->_source->titleImage)}}@else{{$defaultImage}}@endif" alt="{{$hotFloor->_source->name}}"><span class="sale"></span></dt>
                                    <dd class="build_name">{{$hotFloor->_source->name}}<span>[{{$hotFloor->_source->areaname}}]</span></dd>
                                    <?php
                                        $type2 = 'priceSaleAvg'.$hotFloor->_source->type2;
                                        $pricetype = $type2.'Unit';
                                    ?>
                                    <dd>@if($hotFloor->_source->type1 == 1)商铺 @elseif($hotFloor->_source->type1 == 2) 写字楼 @else 住宅 @endif &nbsp;&nbsp;&nbsp;@if(!empty($hotFloor->_source->$type2)) {{$hotFloor->_source->$type2}} @if($hotFloor->_source->$pricetype == 1) {{'元/平米'}} @else {{'万元/套'}} @endif @else 待定 @endif
                                    </dd>
                                </a>
                            </dl>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
    <div class="db">
        <dl class="title">
            <dt><i></i>展开</dt>
            <dd>楼盘对比</dd>
        </dl>
        <div class="db_msg" style="display:none;">
            <h2>
                <span class="yc">隐藏<i></i></span>
                <span class="build_db">楼盘对比</span>
            </h2>
            <div class="db_build">
                <p class="db_title">您浏览过的楼盘(<span class="color2d">最多勾选4项</span>)</p>
                <ul class="db_info">
                </ul>
                <div class="db_search">
                    <!--   <input type="text" class="txt" placeholder="请输入关键字">
                       <ul class="search_result" style="display:none;">
                       </ul>  -->
                </div>
                <p class="db_submit">
                    <a href="javascript:void(0);" class="color66" onclick="startBuildCompare(1);" ><input type="button" class="btn back32" value="开始对比"></a>
                    <input type="button" class="btn backf3" onclick="$('ul.db_info').html('')" value="全部清空">
                </p>
            </div>
        </div>
    </div>
    <script>
        //关注方法
        point_interest('focus','xcy');
    </script>
@endsection
