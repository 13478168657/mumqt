@extends('mainlayout')
@include('list.header')
@section('content')
    @yield('xcssjs')
    @yield('xsearch')
@include('layout.getVirtualphone')
<p class="route">
  <span>您的位置：</span>
  <a href="#">首页</a>
  <span>&nbsp;>&nbsp;</span>
    <a href="{{$linkurl}}">{{$cityName}} @if($subtype=='build')商铺小区@else @if(strpos($type,'sale'))商铺出售@else商铺出租@endif @endif</a>
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
      <a  class="<?=($subtype == 'area')?'click color_blue border_blue':''?>" href="/{{$type}}/area">区域查询</a>
      <!-- <a  class="<?=($subtype == 'business')?'click color_blue border_blue':''?>" href="/{{$type}}/business">核心圈查询</a> -->
      @if(!empty($subWay))
        <a  class="<?=($subtype == 'sub')?'click color_blue border_blue':''?>" href="/{{$type}}/sub">地铁查询</a>
      @endif
    @if($type == 'sprent')
      <a  class="<?=($subtype == 'build')?'click color_blue border_blue':''?>" href="/{{$type}}/build">楼盘查询</a>
    @endif
        @if(strpos($type,'sale'))
            <a href="/map/sale/shops">地图查询</a>
        @else
            <a href="/map/rent/shops">地图查询</a>
        @endif
    </div>
  </div>
  <div class="list_term">
      <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
      <input type="hidden" id="linkurl"  value="{{$linkurl}}" >
      <input type="hidden" id="par"  value="{{$purl}}" >
    <!--根据子类显示不同的选项-->
    @if(($subtype=='area')||($subtype=='build'))
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
                      <?php
                      if(CURRENT_CITYID ==1){
                          if($v->id == $hwdc) continue;
                      }
                      ?>
                      @if($cityareaid == $v->id)
                          <a href="{{$linkurl}}/{{get_url_by_id($purl,'aa',$v->id)}}" class="color_blue acon"  con="aa">{{$v->name}}</a>
                      @else
                          <a href="{{$linkurl}}/{{get_url_by_id($purl,'aa',$v->id)}}">{{$v->name}}</a>
                      @endif
                  @endforeach
              @endif
          </dd>

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
      </dl>
    @elseif($subtype=='sub')
      <dl>
       @if(!empty($subWay))
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
      @endif
      </dl>
      @if($type == 'sprent')
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
    @elseif($subtype == 'business')
      <dl>
        @if(!empty($bustags))
            <dt class="color_grey">商圈：</dt>
            <dd>
                @if(empty($bustagid))
                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'az')}}" class="color_blue">不限</a>
                @else
                    <a href="{{$linkurl}}/{{get_url_by_id($purl,'az')}}" >不限</a>
                @endif

                @foreach($bustags as $k=>$v)
                    @if($bustagid == $v->id)
                        @if(!empty($bustagid))
                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'az',$v->id)}}" class="color_blue acon"  con="az">{{$v->name}}</a>
                        @else
                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'az',$v->id)}}" class="color_blue">{{$v->name}}</a>
                        @endif
                    @else
                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'az',$v->id)}}">{{$v->name}}</a>
                    @endif
                @endforeach
            </dd>
        @endif
      </dl>
    @endif

        <dl>
          <dt class="color_grey">
            @if(($type == 'esfsale') || ($type == 'spsale') || ($type == 'xzlsale'))
                总价：
            @else
                租金：
            @endif
          </dt>
          <dd>
            @if(!empty($averageprices))
              @foreach($averageprices as $k=>$v)
                  @if($averageprice == $k)
                      @if(!empty($averageprice))
                          <a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="color_blue acon"  con="ao">{{$v}}</a>
                      @else
                          @if(!empty($inputprice))
                              <a  class="acon" attr="{{$inputprice}}" con="bm" style="display:none">{{$inputprice}}</a>
                              <a  href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}">{{$v}}</a>
                          @else
                              <a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="color_blue">{{$v}}</a>
                          @endif
                      @endif
                  @else
                      <a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}">{{$v}}</a>
                  @endif
              @endforeach
            @endif
            <span class="color8d left">
              @if(($type == 'esfsale') || ($type == 'spsale')  || ($type == 'xzlsale'))
                  总价（万元）
              @elseif(($type == 'sprent'))
                  租金（元/平米▪天）
              @else
                  租金（元/月）
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

        <!-- 商铺显示类型 行业-->
      @if(($type=='spsale')||($subtype=='build'))
        <dl>
          <dt class="color_grey">类型：</dt>
          <dd>
            @if(!empty($housetypes))
                @foreach($housetypes as $k=>$v)
                    @if($housetype2 == $k)
                          @if(!empty($housetype2))
                              <a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="color_blue acon"  con="an">{{$v}}</a>
                         @else
                              <a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="color_blue" >{{$v}}</a>
                         @endif
                    @else
                        <a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a>
                    @endif
                @endforeach
            @endif
          </dd>
        </dl>
      @endif
        <!-- 商铺出租写字楼显示类别-->
        @if(($type == 'sprent')&&($subtype !='sub')&&($subtype !='build'))
            <dl>
              <dt class="color_grey">类别：</dt>
              <dd>
                @if(!empty($categorys))
                    @foreach($categorys as $k=>$v)
                        @if($category == $k)
                              @if(!empty($category))
                                  <a href="{{$linkurl}}/{{get_url_by_id($purl,'au',$k)}}" class="category color_blue acon" con="au">{{$v}}</a>
                             @else
                                  <a href="{{$linkurl}}/{{get_url_by_id($purl,'au',$k)}}" class="color_blue">{{$v}}</a>
                             @endif
                        @else
                            <a href="{{$linkurl}}/{{get_url_by_id($purl,'au',$k)}}">{{$v}}</a>
                        @endif
                    @endforeach
                @endif
              </dd>
            </dl>
        @endif

        @if($subtype != 'build')
          <dl>
              <dt class="color_grey">面积：</dt>
              <dd>
                  @if(!empty($singleareas))
                      @foreach($singleareas as $k=>$v)
                          @if($singlearea == $k)
                              @if(!empty($singlearea))
                                  <a href="{{$linkurl}}/{{get_url_by_id($purl,'ap',$k)}}" class="color_blue acon" con="ap">{{$v}}</a>
                              @else
                                  <a href="{{$linkurl}}/{{get_url_by_id($purl,'ap',$k)}}" class="color_blue">{{$v}}</a>
                              @endif
                          @else
                              <a href="{{$linkurl}}/{{get_url_by_id($purl,'ap',$k)}}">{{$v}}</a>
                          @endif
                      @endforeach
                  @endif
              </dd>
          </dl>
          <dl class="more_term">
              <dt>更多条件：</dt>
              @if(($type == 'spsale')&&($subtype == 'sub'))
                  <dd class="term">
                      <a class="term_title"><span>
                    @if(!empty($distance))
                          {{$distances[$distance]}}
                      @else
                          距离
                      @endif
                  </span><i class="arrow"></i></a>
                      <div class="list_tag">
                          <p class="top_icon"></p>
                          <ul>
                              @if(!empty($distances))
                                  @foreach($distances as $k=>$v)
                                      @if($distance == $k)
                                          @if(!empty($distance))
                                              <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ai',$k)}}" class="acon" con="ai">{{$v}}</a></li>
                                          @else
                                              <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ai',$k)}}">{{$v}}</a></li>
                                          @endif
                                      @else
                                          <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ai',$k)}}">{{$v}}</a></li>
                                      @endif
                                  @endforeach
                              @endif
                          </ul>
                      </div>
                  </dd>
              @endif
          @if($subtype !='build')
              @if(($type == 'sprent'))
                  <dd class="term">
                      <a class="term_title"><span>
                    @if(!empty($housetype2))
                      {{$housetypes[$housetype2]}}
                    @else
                          类型
                    @endif
                  </span><i class="arrow"></i></a>
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
                  @if($subtype == 'sub')
                      <dd class="term">
                          <a class="term_title"><span>
                    @if(!empty($category))
                                      {{$categorys[$category]}}
                                  @else
                                      类别
                                  @endif
                        </span><i class="arrow"></i></a>
                          <div class="list_tag">
                              <p class="top_icon"></p>
                              <ul>
                                  @if(!empty($categorys))
                                      @foreach($categorys as $k=>$v)
                                          @if($category == $k)
                                              @if(!empty($category))
                                                  <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'au',$k)}}" class="acon" alt="{{$k}}" con="au">{{$v}}</a></li>
                                              @else
                                                  <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'au',$k)}}">{{$v}}</a></li>
                                              @endif
                                          @else
                                              <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'au',$k)}}">{{$v}}</a></li>
                                          @endif
                                      @endforeach
                                  @endif
                              </ul>
                          </div>
                      </dd>
                  @endif
              @endif
          @endif
            @if($subtype !='build')
              <dd class="term">
                  <a class="term_title"><span>
                    @if(!empty($spind))
                              {{$spinds[$spind]}}
                          @else
                              行业
                          @endif
                  </span><i class="arrow"></i></a>
                  <div class="list_tag">
                      <p class="top_icon"></p>
                      <ul class="spindxl">
                          @if(!empty($spinds))
                              @foreach($spinds as $k=>$v)
                                  @if($spind == $k)
                                      @if(!empty($spind))
                                          <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'av',$k)}}" class="acon" con="av">{{$v}}</a></li>
                                      @else
                                          <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'av',$k)}}">{{$v}}</a></li>
                                      @endif
                                  @else
                                      <li><a href="{{$linkurl}}/{{get_url_by_id($purl,'av',$k)}}">{{$v}}</a></li>
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
    @if(!empty($searchword))
        <a style="display:none" class="acon" con="ba">{{$searchword}}</a>
    @endif
  <div class="list_c">
     <div class="list_l">
<!--显示城市或者楼盘的均价-->
  <div class="type_nav">
   <div class="property_type">
       @if($subtype != 'build')
           <a class="house {{($from=='')?'click':''}}" alt="">全部房源</a>
           <!--<a class="house {{($from=='isSoloAgent')?'click':''}}" alt="isSoloAgent">独家代理</a>
           <a class="house {{($from=='publishUserType')?'click':''}}" alt="publishUserType">业主@if(strpos($type,'sale'))直售@else直租@endif</a>-->
       @else
           <a class="house {{($from=='')?'click':''}}" alt="">全部楼盘</a>
       @endif
   </div>
   <div class="sort_nav">
     <span class="sort color2d">排序：</span>
       <a class="sort_icon {{($order=='')?'sort_click':''}}"><span>默认</span></a>
       @if(strpos($type,'sale'))
          <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi','2'),'bj',($order=='price2')?$asc:0)}}" class="sort_icon {{($order=='price2')?'sort_click':''}}"><span  alt="{{$order.$asc}}">总价</span><i class="{{(($order.$asc)=='price21')?'':'click'}}"></i></a>
       @else
           @if($subtype !='build')
               <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi','2'),'bj',($order=='price2')?$asc:0)}}" class="sort_icon {{($order=='price2')?'sort_click':''}}" type="price2"><span  alt="{{$order.$asc}}">租金</span><i class="{{(($order.$asc)=='price21')?'':'click'}}"></i></a>
           @else
               <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi',$priceAvgKey),'bj',($order==$priceAvg)?$asc:0)}}" class="sort_icon {{($order==$priceAvg)?'sort_click':''}}"><span  alt="{{$order.$asc}}" avg="{{$priceAvg}}">价格</span><i class="{{(($order.$asc)==$priceAvg.'1')?'':'click'}}"></i></a>
           @endif
       @endif
       @if($subtype !='build')
         <a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'bi','3'),'bj',($order=='area')?$asc:0)}}" class="sort_icon {{($order=='area')?'sort_click':''}}"><span  alt="{{$order.$asc}}">面积</span><i  class="{{(($order.$asc)=='area1')?'':'click'}}"></i></a>
       @endif
   </div>
   {{--<span class="build_num color2d">找到<span class="colorfe fontA">{{$total}}</span>个符合条件的房源</span>--}}
   <div class="clear"></div>
  </div>
  <div class="build_list">
    @if($topHouse)
       <dl  class="add_border">
              <dt>
                  <a href="/housedetail/s{{$sr}}{{$topHouse->_source->id}}.html" onclick="staClick('{{$topHouse->_source->id}}','t')" target="_blank"><img src="@if(!empty($topHouse->_source->thumbPic)){{get_img_url($objectType,$topHouse->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="标题图"></a>
            <!--  <div class="home_detail"><a href="/housedetail/s{{$sr}}{{$topHouse->_source->id}}.html" class="img_num"><i></i>@if(!empty($topHouse->_source->imageCount)){{$topHouse->_source->imageCount}}@else 0  @endif</a></div> -->
              </dt>
              <dd class="margin_l">
                  <p class="build_name margin_b">
                      <a href="/housedetail/s{{$sr}}{{$topHouse->_source->id}}.html" onclick="staClick('{{$topHouse->_source->id}}','t')" class="name" target="_blank">{{$topHouse->_source->title}}</a>
                      &nbsp;&nbsp;&nbsp;&nbsp;
                  </p>
                  <p class="finish_data color8d margin_b">
                     @if($subtype != 'build')
                      @if(!empty($topHouse->_source->communityId))
                          <a href="{{$linkurl}}/ba{{$topHouse->_source->communityId}}"><strong>{{!empty($topHouse->_source->name)?$topHouse->_source->name:''}}</strong></a>&nbsp;&nbsp;
                      @endif
                      @if(!empty($topHouse->_source->address))
                          <span>
                              <span title="{{$topHouse->_source->address}}" class="address">{{$topHouse->_source->address}}</span>
                              @if(!empty($topHouse->_source->communityId))
                                  <a href="/map/{{($type=='spsale')?'sale':'rent'}}/shops?communityId={{$topHouse->_source->communityId}}&longitude={{$topHouse->_source->longitude}}&latitude={{$topHouse->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                              @endif
                          </span>
                      @endif
                     @else
                      <span class="color8d">
                          @if(!empty($cityAreas[$topHouse->_source->cityAreaId]) || !empty($businessAreas[$topHouse->_source->businessAreaId]))
                          [<span>{{!empty($topHouse->_source->cityAreaId)?@$cityAreas[$topHouse->_source->cityAreaId]:''}}</span><span>{{!empty($topHouse->_source->businessAreaId)?'-'.@$businessAreas[$topHouse->_source->businessAreaId]:''}}</span>]
                          @endif
                          @if(!empty($topHouse->_source->address))
                              {{$topHouse->_source->address}}
                              @if(!empty($topHouse->_source->communityId))
                                  <a href="/map/rent/shops?communityId={{$topHouse->_source->communityId}}&longitude={{$topHouse->_source->longitude}}&latitude={{$topHouse->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                              @endif
                          @endif
                      </span>
                     @endif
                  </p>
                  <p class="home_num color8d margin_b">
                  <!-- 商铺置顶 -->
                    
                      @if(strpos($type,'sale'))
                        <span>类型：</span>
                        <span>{{$topHouse->_source->housetypes[$topHouse->_source->houseType2] or '其它'}}</span>
                        <span>|</span>
                        
                        @if(!empty($house->_source->trade))
                            <span>
                            @foreach(explode('|',$topHouse->_source->trade) as $k=>$trade)
                                   {{(!empty($trade) && !empty($spinds[$trade]))?$spinds[$trade]:''}}&nbsp;
                                <?php if($k == 2) break;?>
                            @endforeach
                            </span>
                            <span>|</span>
                        @endif
                        <span><span>{{$topHouse->_source->currentFloor}}</span>/<span>{{$topHouse->_source->totalFloor}}</span>层</span>
                      @elseif(strpos($type,'rent'))
                        @if($subtype !='build')
                            <span>类型:</span>
                            <span>{{$topHouse->_source->housetypes[$topHouse->_source->houseType2] or '无'}}</span>
                            <span>|</span>
                            <span>{{floor($topHouse->_source->area)}}平米</span>
                            <span>|</span>
                            <span>所在楼层:</span>
                            <span><span>{{$topHouse->_source->currentFloor}}</span>/<span>{{$topHouse->_source->totalFloor}}</span>层</span>
                            @if(!empty($topHouse->_source->isTransfer))
                                <span>|</span>
                                <span>转让费：</span>
                                <span><span>{{!empty($topHouse->_source->transferPrice)?$topHouse->_source->transferPrice.'万元':'面议'}}</span></span>
                            @endif
                        @else
                            @if(!empty($typeInfo))
                                @if(!empty($typeInfo->propertyYear))
                                    <span>{{$typeInfo->propertyYear}}年</span>
                                @endif
                                @if(!empty($typeInfo->totalFloor)&&!empty($typeInfo->totalFloor))
                                    <span>|</span>
                                @endif
                                @if(!empty($typeInfo->totalFloor))
                                <span>共{{$typeInfo->totalFloor}}层</span>
                                @endif
                            @endif
                        @endif
                      @endif
                  </p>
                  <p class="build_tag">
                      @if(!empty($topHouse->_source->brokers))
                          <a href="/brokerinfo/{{$topHouse->_source->uid}}.html" target="_blank">{{!empty($topHouse->_source->brokers[0]->realName)?mb_substr($topHouse->_source->brokers[0]->realName,0,12,'UTF-8'):""}}</a>
                      @endif
                      @if(!empty($topHouse->_source->subwayNearestDistance))
                          <?php
                              if(!empty($stationid)){
                                  $distance = explode('|',$topHouse->_source->subwayStationDistance);
                                  $subIdArr = explode('|',$topHouse->_source->subwayStationId);
                                  $pos = array_search($stationid,$subIdArr);
                                  if(!empty($subNames[$stationid])){
                                      $subStation = $subNames[$stationid];
                                      $lineName = $subStation['lineName'];
                                      $StationName = $subStation['name'];
                                      $tagpos = 2;
                                      if(!empty($distance[$pos])){
                                          $topHouse->_source->subwayNearestDistance = $distance[$pos];
                                      }
                                  }
                              }elseif(!empty($subid)){
                                  $subIdArr = explode('|',$topHouse->_source->subwayStationId);
                                  foreach($subIdArr as $k=>$StationId){
                                      if(!empty($subNames[$StationId])){
                                          if($subNames[$StationId]['lineId'] == $subid){
                                              $lineName = $subNames[$StationId]['lineName'];
                                              $StationName = $subNames[$StationId]['name'];
                                              $pos = $k;
                                              break;
                                          }
                                      }
                                  }
                                  $distance = explode('|',$topHouse->_source->subwayStationDistance);
                                  if(!empty($pos)&&!empty($distance[$pos])){
                                      $topHouse->_source->subwayNearestDistance = $distance[$pos];
                                      $tagpos = 2;
                                  }
                              }else{
                                  $distance = explode('|',$topHouse->_source->subwayStationDistance);
                                  $pos = array_search($topHouse->_source->subwayNearestDistance,$distance);
                                  $subIdArr = explode('|',$topHouse->_source->subwayStationId);
                                  if(!empty($subIdArr[$pos])&&!empty($subNames[$subIdArr[$pos]])){
                                      $subStation = $subNames[$subIdArr[$pos]];
                                      $lineName = $subStation['lineName'];
                                      $StationName = $subStation['name'];
                                      $tagpos = 2;
                                  }
                              }
                          ?>
                          @if(!empty($lineName)&&!empty($StationName)&&!empty($topHouse->_source->subwayNearestDistance))
                              <span class="subway">距离{{$lineName}}{{$StationName}}站{{$topHouse->_source->subwayNearestDistance}}米</span>
                          @endif
                      @endif
                      <?php $x=1;$tagpos = !empty($tagpos)?$tagpos:5;?>
                      @if(!empty($topHouse->_source->tagId))
                        @foreach(explode('|',$topHouse->_source->tagId) as $k=>$tagid)
                            @if(!empty($featurestag[$tagid]))
                                  <span class="tag{{$k+1}}">{{$featurestag[$tagid]}}</span>
                                    <?php $x++;if($x >$tagpos) break;?>
                            @endif
                        @endforeach
                      @endif
                      @if(!empty($topHouse->_source->diyTagId) && !empty($diyTagHBs))
                          @foreach(explode('|',$topHouse->_source->diyTagId) as $k=>$tid)
                              @if(!empty($diyTagHBs[$tid]))
                                  <?php if($x >$tagpos) break;$x++;?>
                                  <span class="data_tag">{{$diyTagHBs[$tid]}}</span>
                              @endif
                          @endforeach
                      @endif
                  </p>
    
              </dd>
          @if($subtype !='school')
              <dd class="right price_r">
                  @if(strpos($type,'sale'))
                    <p class="build_price">
                        @if(!empty($topHouse->_source->price2))
                            <span class="fontA colorfe">{{floor($topHouse->_source->price2)}}</span>万
                        @else
                            <span class="fontA colorfe">面议</span>
                        @endif
                    </p>
                    <p class="release_time color8d">
                        @if(!empty($topHouse->_source->price1))
                            <span><span class="fontA">{{floor($topHouse->_source->price1)}}</span>元/平米</span>
                        @endif
                    </p>
                  @else
                    @if($subtype !='build')
                        <p class="build_price">
                            @if(!empty($topHouse->_source->price2))
                                @if(strpos($topHouse->_source->price2,'.'))
                                  <span class="fontA colorfe">{{substr($topHouse->_source->price2,0,strpos($topHouse->_source->price2,'.')+2)}}</span>元/平米▪天
                                @else
                                  <span class="fontA colorfe">{{$topHouse->_source->price2}}</span>元/平米▪天
                                @endif
                            @else
                                <span class="fontA colorfe">面议</span>
                            @endif
                        </p>

                        <p class="release_time color8d">
                            @if(!empty($topHouse->_source->price1))
                                <span><span class="fontA">{{floor($topHouse->_source->price1)}}</span>元/月</span>
                            @endif
                        </p>
                    @else
                        <p class="build_price margin_top">
                            @if(!empty($topHouse->_source->$priceAvg))
                                起价&nbsp;<span class="colorfe fontA">{{floor($topHouse->_source->$priceAvg)}}</span>元/平米▪天
                            @else
                                <span class="colorfe fontA">未知</span>
                            @endif
                        </p>
                        <p class="build_price margin_top">
                            <a class="house_num"></a><a class="color_blue" style=" font-size:16px;" href="/esfrent/area/ba{{$house->_source->id}}">{{$topHouse->_source->rentCount}}</a>&nbsp;&nbsp;个房源在租
                        </p>
                    @endif
                  @endif
                  <p class="handle">
                      <a class="color66" ><span class="focus" value="{{$topHouse->_source->id}},{{($sr == "s")?2:1}},{{$housetype1}},0"><i class="follow"></i><span>{{(!empty($interest)&&(in_array($topHouse->_source->id,$interest))?'已关注':'关注')}}</span></span></a>
                      <a href="javascript:void(0);" class="color66" onclick='addCompare({{$topHouse->_source->id}},"{{$topHouse->_source->title}}","{{($sr == "s")?"sale":"rent"}}",{{$housetype1}});'><i class="contrast"></i>对比</a>
                  </p>
              </dd>
          @endif
          </dl>
    @endif
    @if(!empty($resultfee))
    <div class="backColor">
    @foreach($resultfee as $house)
      <?php
      if($subtype == 'build'){
          if(!empty($housetype2)){
              $type2 = $housetype2;
          }else{
              $type2 = '';
              foreach(explode('|',$house->_source->type2) as $tp2){
                  if($tp2 == 202) continue;
                  if(substr($tp2,0,1) == $housetype1){
                      $type2 = $tp2;
                      break;
                  }
              }
          }

          if(!empty($type2)){
              $typeInfo = 'type'.$type2.'Info';
              if(!empty($house->_source->$typeInfo)){
                  $typeInfo = json_decode($house->_source->$typeInfo);
              }else{
                  $typeInfo = '';
              }
          }else{
              $typeInfo = '';
          }
      }
      ?>
      <dl>
          <dt>
          @if($subtype != 'build')
                  <a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" target="_blank"><img src="@if(!empty($house->_source->thumbPic)){{get_img_url($objectType,$house->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"  alt="标题图"></a>
                  <!--  <div class="home_detail"><a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" class="img_num"><i></i>@if(!empty($house->_source->imageCount)){{$house->_source->imageCount}}@else 0  @endif</a></div> -->
          @else
              <a href="/esfindex/{{$house->_source->id}}/{{!empty($type2)?$type2:'101'}}.html" target="_blank"><img src="@if(!empty($house->_source->titleImage)){{get_img_url('commPhoto',$house->_source->titleImage,2)}}@else{{$defaultImage}}@endif"  alt="标题图"></a>
          @endif
          </dt>
          <dd class="marketing"><a href="{{config('hostConfig.agr_host').'/buyPackage/1'}}">推广</a></dd>
          <dd class="margin_l {{($subtype == 'build')?'build_width1':''}}">
              <p class="build_name margin_b">
                  @if($subtype != 'build')
                      <a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" class="name" target="_blank">{{$house->_source->title}}</a>
                      <!--<span class="home_time"><?php
                              if(!empty($house->_source->timeUpdate)){
                                $time = time() - strtotime($house->_source->timeUpdate);
                                  if(0<$time &&$time<60){
                                        $time = $time.'秒';
                                  }elseif(60<$time &&$time<3600){
                                        $time = (int)($time/60).'分';
                                  }elseif(3600<$time &&$time<86400){
                                      $time = (int)($time/3600).'小时';
                                  }else{
                                        $time = substr($house->_source->timeUpdate,0,10);
                                  }
                                  echo $time;
                              }
                              ?>前更新</span>-->
                  @else
                      <a href="/esfindex/{{$house->_source->id}}/{{!empty($type2)?$type2:'101'}}.html" class="name build_width" target="_blank">{{$house->_source->name}}</a>
                        @if(!empty($type2))
                          <a  class="state subway">{{$housetypes[$type2] or '其它'}}</a>
                        @endif
                  @endif
              </p>
              <p class="finish_data color8d margin_b">
                  @if($subtype != 'build')
                      @if(!empty($house->_source->communityId))
                          <a href="{{$linkurl}}/ba{{$house->_source->communityId}}"><strong>{{!empty($house->_source->name)?$house->_source->name:''}}</strong></a>&nbsp;&nbsp;
                      @endif
                      @if(!empty($house->_source->address))
                          <span>
                              <span title="{{$house->_source->address}}" class="address">{{$house->_source->address}}</span>
                              @if(!empty($house->_source->communityId))
                                  <a href="/map/{{($type=='spsale')?'sale':'rent'}}/shops?communityId={{$house->_source->communityId}}&longitude={{$house->_source->longitude}}&latitude={{$house->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                              @endif
                          </span>
                      @endif
                  @else
                      <span class="color8d">
                          @if(!empty($cityAreas[$house->_source->cityAreaId]) || !empty($businessAreas[$house->_source->businessAreaId]))
                              [<span>{{!empty($house->_source->cityAreaId)?@$cityAreas[$house->_source->cityAreaId]:''}}</span><span>{{!empty($house->_source->businessAreaId)?'-'.@$businessAreas[$house->_source->businessAreaId]:''}}</span>]
                          @endif
                          @if(!empty($house->_source->address))
                              {{$house->_source->address}}
                                  @if(!empty($house->_source->communityId))
                                      <a href="/map/sale/shops?communityId={{$house->_source->communityId}}&longitude={{$house->_source->longitude}}&latitude={{$house->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                                  @endif
                          @endif
                      </span>
                  @endif
              </p>
              <p class="home_num color8d margin_b">
                  @if($type == 'spsale')
                      <span>类型：</span>
                      <span>{{$housetypes[$house->_source->houseType2] or '其它'}}</span>
                      <span>|</span>

                      @if(!empty($house->_source->trade))
                          <span>
                          @foreach(explode('|',$house->_source->trade) as $k=>$trade)
                                  {{(!empty($trade) && !empty($spinds[$trade]))?$spinds[$trade]:''}}&nbsp;
                              <?php if($k == 2) break;?>
                          @endforeach
                          </span>
                          <span>|</span>
                      @endif
                      <span><span>{{$house->_source->currentFloor}}</span>&nbsp;/&nbsp;<span>{{$house->_source->totalFloor}}</span>层</span>
                  @elseif($type == 'sprent')
                      @if($subtype !='build')
                          <span>类型:</span>
                          <span>{{$housetypes[$house->_source->houseType2] or '无'}}</span>
                          <span>|</span>
                          <span>{{$house->_source->area}}平米</span>
                          <span>|</span>
                          <span>所在楼层:</span>
                          <span><span>{{$house->_source->currentFloor}}</span>/<span>{{$house->_source->totalFloor}}</span>层</span>
                          @if(!empty($house->_source->isTransfer))
                              <span>|</span>
                              <span>转让费：</span>
                              <span><span>{{!empty($house->_source->transferPrice)?$house->_source->transferPrice.'万元':'面议'}}</span></span>
                          @endif
                      @else
                          @if(!empty($typeInfo))
                              @if(!empty($typeInfo->propertyYear))
                                  <span>{{$typeInfo->propertyYear}}年</span>
                              @endif
                              @if(!empty($typeInfo->totalFloor)&&!empty($typeInfo->totalFloor))
                                  <span>|</span>
                              @endif
                              @if(!empty($typeInfo->totalFloor))
                              <span>共{{$typeInfo->totalFloor}}层</span>
                              @endif
                          @endif
                      @endif
                  @endif
              </p>
              <p class="build_tag">
                  <?php $x=1;?>
                  @if($subtype == 'build')
                      @if(!empty($typeInfo->tagIds))
                          @foreach(explode('|',$typeInfo->tagIds) as $k=>$tagid)
                              @if(!empty($featurestag[$tagid]))
                                  <span class="tag{{$k+1}}">{{$featurestag[$tagid]}}</span>
                                  <?php $x++;if($x >5) break;?>
                              @endif
                          @endforeach
                      @endif
                      @if(!empty($typeInfo->diyTagIds) && !empty($diyTagHBs))
                          @foreach(explode('|',$typeInfo->diyTagIds) as $k=>$tid)
                              @if(!empty($diyTagHBs[$tid]))
                                  <?php if($x >5) break;$x++;?>
                                  <span class="data_tag">{{$diyTagHBs[$tid]}}</span>
                              @endif
                          @endforeach
                      @endif
                  @else
                      @if(!empty($house->_source->brokers))
                          <a href="/brokerinfo/{{$house->_source->uid}}.html" target="_blank">{{!empty($house->_source->brokers[0]->realName)?mb_substr($house->_source->brokers[0]->realName,0,12,'UTF-8'):""}}</a>
                      @endif
                      @if(!empty($house->_source->subwayNearestDistance))
                          <?php
                              if(!empty($stationid)){
                                  $distance = explode('|',$house->_source->subwayStationDistance);
                                  $subIdArr = explode('|',$house->_source->subwayStationId);
                                  $pos = array_search($stationid,$subIdArr);
                                  if(!empty($subNames[$stationid])){
                                      $subStation = $subNames[$stationid];
                                      $lineName = $subStation['lineName'];
                                      $StationName = $subStation['name'];
                                      $tagpos = 2;
                                      if(!empty($distance[$pos])){
                                          $house->_source->subwayNearestDistance = $distance[$pos];
                                      }
                                  }
                              }elseif(!empty($subid)){
                                  $subIdArr = explode('|',$house->_source->subwayStationId);
                                  foreach($subIdArr as $k=>$StationId){
                                      if(!empty($subNames[$StationId])){
                                          if($subNames[$StationId]['lineId'] == $subid){
                                              $lineName = $subNames[$StationId]['lineName'];
                                              $StationName = $subNames[$StationId]['name'];
                                              $pos = $k;
                                              break;
                                          }
                                      }
                                  }
                                  $distance = explode('|',$house->_source->subwayStationDistance);
                                  if(!empty($pos)&&!empty($distance[$pos])){
                                      $house->_source->subwayNearestDistance = $distance[$pos];
                                      $tagpos = 2;
                                  }
                              }else{
                                  $distance = explode('|',$house->_source->subwayStationDistance);
                                  $pos = array_search($house->_source->subwayNearestDistance,$distance);
                                  $subIdArr = explode('|',$house->_source->subwayStationId);
                                  if(!empty($subIdArr[$pos])&&!empty($subNames[$subIdArr[$pos]])){
                                      $subStation = $subNames[$subIdArr[$pos]];
                                      $lineName = $subStation['lineName'];
                                      $StationName = $subStation['name'];
                                      $tagpos = 2;
                                  }
                              }
                          ?>
                          @if(!empty($lineName)&&!empty($StationName)&&!empty($house->_source->subwayNearestDistance))
                              <span class="subway">距离{{$lineName}}{{$StationName}}站{{$house->_source->subwayNearestDistance}}米</span>
                          @endif
                      @endif
                      <?php $x=1;$tagpos = !empty($tagpos)?$tagpos:5;?>
                      @if(!empty($house->_source->tagId))
                          @foreach(explode('|',$house->_source->tagId) as $k=>$tagid)
                              @if(!empty($featurestag[$tagid]))
                                  <span class="tag{{$k+1}}">{{$featurestag[$tagid]}}</span>
                                  <?php $x++;if($x >$tagpos) break;?>
                              @endif
                          @endforeach
                      @endif
                      @if(!empty($house->_source->diyTagId) && !empty($diyTagHBs))
                          @foreach(explode('|',$house->_source->diyTagId) as $k=>$tid)
                                  @if(!empty($diyTagHBs[$tid]))
                                      <?php if($x >$tagpos) break;$x++;?>
                                      <span class="data_tag">{{$diyTagHBs[$tid]}}</span>
                                  @endif
                          @endforeach
                      @endif
                  @endif

              </p>
          </dd>
          
          <dd class="right {{($subtype != 'build')?'price_r':''}}">
              @if(strpos($type,'sale'))
              <p class="build_price">
                  @if(!empty($house->_source->price2))
                      <span class="fontA colorfe">{{floor($house->_source->price2)}}</span>万
                  @else
                      <span class="fontA colorfe">面议</span>
                  @endif
              </p>
              <p class="release_time color8d">
                  @if(!empty($house->_source->price1))
                      <span><span class="fontA">{{floor($house->_source->price1) }}</span>元/平米</span>
                  @endif
              </p>
              @else
                  @if($subtype !='build')
                      <p class="build_price">
                          @if(!empty($house->_source->price2))
                              <span class="fontA colorfe">{{$house->_source->price2}}</span>元/平米▪天
                          @else
                              <span class="fontA colorfe">面议</span>
                          @endif
                      </p>

                      <p class="release_time color8d">
                          @if(!empty($house->_source->price1))
                              <span><span class="fontA">{{floor($house->_source->price1)}}</span>元/月</span>
                          @endif
                      </p>
                  @else
                      <p class="build_price margin_top">
                          @if(!empty($house->_source->$priceAvg))
                              起价&nbsp;<span class="colorfe fontA">{{$house->_source->$priceAvg}}</span>元/平米▪天
                          @else
                              <span class="colorfe fontA">未知</span>
                          @endif
                      </p>
                      <p class="build_price margin_top">
                          <a class="house_num"></a><a class="color_blue" style=" font-size:16px;" href="/esfrent/area/ba{{$house->_source->id}}">{{$house->_source->rentCount}}</a>&nbsp;&nbsp;个房源在租
                      </p>
                  @endif
              @endif
              <p class="handle">
                  @if($subtype !='build')
                      <a class="color66" ><span class="focus" value="{{$house->_source->id}},{{($sr == "s")?2:1}},{{$housetype1}},0"><i class="follow"></i><span>{{(!empty($interest)&&(in_array($house->_source->id,$interest))?'已关注':'关注')}}</span></span></a>
                      <a href="javascript:void(0);" class="color66" onclick='addCompare({{$house->_source->id}},"{{$house->_source->title}}","{{($sr == "s")?"sale":"rent"}}",{{$housetype1}});'><i class="contrast"></i>对比</a>
                  @else
                      <a class="color66" ><span class="focus" value="{{$house->_source->id}},3,{{$housetype1}},0"><i class="follow"></i><span>{{(!empty($interest)&&(in_array($house->_source->id,$interest))?'取消关注':'关注')}}</span></span></a>
                      <a href="javascript:void(0);" onclick='addBuildCompare({{$house->_source->id}},"{{$house->_source->name}}",0,{{$housetype1}});' class="color66"><i class="contrast"></i>对比</a>
                  @endif
              </p>
          </dd>
      </dl>
    @endforeach
    </div>
@endif
    @if(empty($topHouse) && empty($resultfee)&&!empty($resBool)&&!empty($houses))
        <p class="no_data">很抱歉，没有找到与“<span id="condition"></span>”相符的{{($subtype=='build')?'楼盘':'房源'}}！</p>
        <h2 class="title_house">您可能感兴趣的{{($subtype=='build')?'楼盘':'房源'}}</h2>
    @endif
@if(!empty($houses))
    @foreach($houses as $house)
      <?php
      if($subtype == 'build'){
          if(!empty($housetype2)&&empty($resBool)){
              $type2 = $housetype2;
          }else{
              $type2 = '';
              foreach(explode('|',$house->_source->type2) as $tp2){
                  if($tp2 == 202) continue;
                  if(substr($tp2,0,1) == $housetype1){
                      $type2 = $tp2;
                      break;
                  }
              }
          }

          if(!empty($type2)){
              $typeInfo = 'type'.$type2.'Info';
              if(!empty($house->_source->$typeInfo)){
                  $typeInfo = json_decode($house->_source->$typeInfo);
              }else{
                  $typeInfo = '';
              }
          }else{
              $typeInfo = '';
          }
      }
      ?>
      <dl>
          <dt>
          @if($subtype != 'build')
                  <a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" target="_blank"><img src="@if(!empty($house->_source->thumbPic)){{get_img_url($objectType,$house->_source->thumbPic,2)}}@else{{$defaultImage}}@endif"  alt="标题图"></a>
                  <!--  <div class="home_detail"><a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" class="img_num"><i></i>@if(!empty($house->_source->imageCount)){{$house->_source->imageCount}}@else 0  @endif</a></div> -->
          @else
              <a href="/esfindex/{{$house->_source->id}}/{{!empty($type2)?$type2:'101'}}.html" target="_blank"><img src="@if(!empty($house->_source->titleImage)){{get_img_url('commPhoto',$house->_source->titleImage,2)}}@else{{$defaultImage}}@endif"  alt="标题图"></a>
          @endif
          </dt>
          <dd class="margin_l {{($subtype == 'build')?'build_width1':''}}">
              <p class="build_name margin_b">
                  @if($subtype != 'build')
                      <a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" class="name" target="_blank">{{$house->_source->title}}</a>
                      @if($house->_source->publishUserType !=1)
                          <span class="yz_sale">业主{{($sr=='s')?'直售':'直租'}}</span>
                          @endif
                  @else
                      <a href="/esfindex/{{$house->_source->id}}/{{!empty($type2)?$type2:'101'}}.html" class="name build_width" target="_blank">{{$house->_source->name}}</a>
                        @if(!empty($type2))
                          <a  class="state subway">{{$housetypes[$type2] or '其它'}}</a>
                        @endif
                  @endif
              </p>
              <p class="finish_data color8d margin_b">
                  @if($subtype != 'build')
                      @if(!empty($house->_source->communityId))
                          <a href="{{$linkurl}}/ba{{$house->_source->communityId}}"><strong>{{!empty($house->_source->name)?$house->_source->name:''}}</strong></a>&nbsp;&nbsp;
                      @endif
                      @if(!empty($house->_source->address))
                          <span>
                              <span title="{{$house->_source->address}}" class="address">{{$house->_source->address}}</span>
                              @if(!empty($house->_source->communityId))
                                  <a href="/map/{{($type=='spsale')?'sale':'rent'}}/shops?communityId={{$house->_source->communityId}}&longitude={{$house->_source->longitude}}&latitude={{$house->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                              @endif
                          </span>
                      @endif
                  @else
                      <span class="color8d">
                          @if(!empty($cityAreas[$house->_source->cityAreaId]) || !empty($businessAreas[$house->_source->businessAreaId]))
                              [<span>{{!empty($house->_source->cityAreaId)?@$cityAreas[$house->_source->cityAreaId]:''}}</span><span>{{!empty($house->_source->businessAreaId)?'-'.@$businessAreas[$house->_source->businessAreaId]:''}}</span>]
                          @endif
                          @if(!empty($house->_source->address))
                              {{$house->_source->address}}
                                  @if(!empty($house->_source->communityId))
                                      <a href="/map/rent/shops?communityId={{$house->_source->communityId}}&longitude={{$house->_source->longitude}}&latitude={{$house->_source->latitude}}" target="_blank"><i class="map_icon"></i></a>
                                  @endif
                          @endif
                      </span>
                  @endif
              </p>
              <p class="home_num color8d margin_b">
                  @if($type == 'spsale')
                      <span>类型：</span>
                      <span>{{$housetypes[$house->_source->houseType2] or '其它'}}</span>
                      <span>|</span>
                      @if(!empty($house->_source->trade))
                          <span>
                          @foreach(explode('|',$house->_source->trade) as $k=>$trade)
                                  {{(!empty($trade) && !empty($spinds[$trade]))?$spinds[$trade]:''}}&nbsp;
                              <?php if($k == 2) break;?>
                          @endforeach
                          </span>
                          <span>|</span>
                      @endif
                      <span><span>{{$house->_source->currentFloor}}</span>&nbsp;/&nbsp;<span>{{$house->_source->totalFloor}}</span>层</span>
                  @elseif($type == 'sprent')
                      @if($subtype !='build')
                          <span>类型:</span>
                          <span>{{$housetypes[$house->_source->houseType2] or '无'}}</span>
                          <span>|</span>
                          <span>{{$house->_source->area}}平米</span>
                          <span>|</span>
                          <span>所在楼层:</span>
                          <span><span>{{$house->_source->currentFloor}}</span>/<span>{{$house->_source->totalFloor}}</span>层</span>
                          @if(!empty($house->_source->isTransfer))
                              <span>|</span>
                              <span>转让费：</span>
                              <span><span>{{!empty($house->_source->transferPrice)?$house->_source->transferPrice.'万元':'面议'}}</span></span>
                          @endif
                      @else
                          @if(!empty($typeInfo))
                              @if(!empty($typeInfo->propertyYear))
                                  <span>{{$typeInfo->propertyYear}}年</span>
                              @endif
                              @if(!empty($typeInfo->totalFloor)&&!empty($typeInfo->totalFloor))
                                  <span>|</span>
                              @endif
                              @if(!empty($typeInfo->totalFloor))
                              <span>共{{$typeInfo->totalFloor}}层</span>
                              @endif
                          @endif
                      @endif
                  @endif
              </p>
              <p class="build_tag">
                  <?php $x=1;?>
                  @if($subtype == 'build')
                      @if(!empty($typeInfo->tagIds))
                          @foreach(explode('|',$typeInfo->tagIds) as $k=>$tagid)
                              @if(!empty($featurestag[$tagid]))
                                  <span class="tag{{$k+1}}">{{$featurestag[$tagid]}}</span>
                                  <?php $x++;if($x >5) break;?>
                              @endif
                          @endforeach
                      @endif
                      @if(!empty($typeInfo->diyTagIds) && !empty($diyTagHBs))
                          @foreach(explode('|',$typeInfo->diyTagIds) as $k=>$tid)
                              @if(!empty($diyTagHBs[$tid]))
                                  <?php if($x >5) break;$x++;?>
                                  <span class="data_tag">{{$diyTagHBs[$tid]}}</span>
                              @endif
                          @endforeach
                      @endif
                  @else
                      @if(!empty($house->_source->brokers))
                          @if(!empty($house->_source->publishUserType)&&$house->_source->publishUserType == 1)
                              <a href="/brokerinfo/{{$house->_source->uid}}.html" target="_blank">{{!empty($house->_source->brokers[0]->realName)?mb_substr($house->_source->brokers[0]->realName,0,12,'UTF-8'):""}}</a>
                          @else
                                  {{!empty($house->_source->linkman)?mb_substr($house->_source->linkman,0,12,'UTF-8'):""}}
                          @endif
                      @endif
                      @if(!empty($house->_source->subwayNearestDistance))
                          <?php
                              if(!empty($stationid)){
                                  $distance = explode('|',$house->_source->subwayStationDistance);
                                  $subIdArr = explode('|',$house->_source->subwayStationId);
                                  $pos = array_search($stationid,$subIdArr);
                                  if(!empty($subNames[$stationid])){
                                      $subStation = $subNames[$stationid];
                                      $lineName = $subStation['lineName'];
                                      $StationName = $subStation['name'];
                                      $tagpos = 2;
                                      if(!empty($distance[$pos])){
                                          $house->_source->subwayNearestDistance = $distance[$pos];
                                      }
                                  }
                              }elseif(!empty($subid)){
                                  $subIdArr = explode('|',$house->_source->subwayStationId);
                                  foreach($subIdArr as $k=>$StationId){
                                      if(!empty($subNames[$StationId])){
                                          if($subNames[$StationId]['lineId'] == $subid){
                                              $lineName = $subNames[$StationId]['lineName'];
                                              $StationName = $subNames[$StationId]['name'];
                                              $pos = $k;
                                              break;
                                          }
                                      }
                                  }
                                  $distance = explode('|',$house->_source->subwayStationDistance);
                                  if(!empty($pos)&&!empty($distance[$pos])){
                                      $house->_source->subwayNearestDistance = $distance[$pos];
                                      $tagpos = 2;
                                  }
                              }else{
                                  $distance = explode('|',$house->_source->subwayStationDistance);
                                  $pos = array_search($house->_source->subwayNearestDistance,$distance);
                                  $subIdArr = explode('|',$house->_source->subwayStationId);
                                  if(!empty($subIdArr[$pos])&&!empty($subNames[$subIdArr[$pos]])){
                                      $subStation = $subNames[$subIdArr[$pos]];
                                      $lineName = $subStation['lineName'];
                                      $StationName = $subStation['name'];
                                      $tagpos = 2;
                                  }
                              }
                          ?>
                          @if(!empty($lineName)&&!empty($StationName)&&!empty($house->_source->subwayNearestDistance))
                              <span class="subway">距离{{$lineName}}{{$StationName}}站{{$house->_source->subwayNearestDistance}}米</span>
                          @endif
                      @endif
                      <?php $x=1;$tagpos = !empty($tagpos)?$tagpos:5;?>
                      @if(!empty($house->_source->tagId))
                          @foreach(explode('|',$house->_source->tagId) as $k=>$tagid)
                              @if(!empty($featurestag[$tagid]))
                                  <span class="tag{{$k+1}}">{{$featurestag[$tagid]}}</span>
                                  <?php $x++;if($x >$tagpos) break;?>
                              @endif
                          @endforeach
                      @endif
                      @if(!empty($house->_source->diyTagId) && !empty($diyTagHBs))
                          @foreach(explode('|',$house->_source->diyTagId) as $k=>$tid)
                                  @if(!empty($diyTagHBs[$tid]))
                                      <?php if($x >$tagpos) break;$x++;?>
                                      <span class="data_tag">{{$diyTagHBs[$tid]}}</span>
                                  @endif
                          @endforeach
                      @endif
                  @endif

              </p>
          </dd>
          <dd class="right {{($subtype != 'build')?'price_r':''}}">
              @if(strpos($type,'sale'))
              <p class="build_price">
                  @if(!empty($house->_source->price2))
                      <span class="fontA colorfe">{{floor($house->_source->price2)}}</span>万
                  @else
                      <span class="fontA colorfe">面议</span>
                  @endif
              </p>
              <p class="release_time color8d">
                  @if(!empty($house->_source->price1))
                      <span><span class="fontA">{{floor($house->_source->price1) }}</span>元/平米</span>
                  @endif
              </p>
              @else
                  @if($subtype !='build')
                      <p class="build_price">
                          @if(!empty($house->_source->price2))
                            @if(strpos($house->_source->price2,'.'))
                              <span class="fontA colorfe">{{substr($house->_source->price2,0,strpos($house->_source->price2,'.')+2)}}</span>元/平米▪天
                            @else
                              <span class="fontA colorfe">{{$house->_source->price2}}</span>元/平米▪天
                            @endif
                          @else
                              <span class="fontA colorfe">面议</span>
                          @endif
                      </p>

                      <p class="release_time color8d">
                          @if(!empty($house->_source->price1))
                              <span><span class="fontA">{{floor($house->_source->price1)}}</span>元/月</span>
                          @endif
                      </p>
                  @else
                      <p class="build_price margin_top">
                          @if(!empty($house->_source->$priceAvg))
                              起价&nbsp;<span class="colorfe fontA">{{$house->_source->$priceAvg}}</span>元/平米▪天
                          @else
                              <span class="colorfe fontA">未知</span>
                          @endif
                      </p>
                      <p class="build_price margin_top">
                          {{--<a class="house_num"></a><a class="color_blue" style=" font-size:16px;" href="/esfrent/area/ba{{$house->_source->id}}">{{$house->_source->rentCount}}</a>&nbsp;&nbsp;个房源在租--}}
                          <a class="house_num"></a><a class="color_blue" style=" font-size:16px;" href="/sprent/area/ba{{$house->_source->id}}">{{$house->_source->rentCount}}</a>&nbsp;&nbsp;个房源在租
                      </p>
                  @endif
              @endif
              <p class="handle">
                  @if($subtype !='build')
                      <a class="color66" ><span class="focus" value="{{$house->_source->id}},{{($sr == "s")?2:1}},{{$housetype1}},0"><i class="follow"></i><span>{{(!empty($interest)&&(in_array($house->_source->id,$interest))?'已关注':'关注')}}</span></span></a>
                      <a href="javascript:void(0);" class="color66" onclick='addCompare({{$house->_source->id}},"{{$house->_source->title}}","{{($sr == "s")?"sale":"rent"}}",{{$housetype1}});'><i class="contrast"></i>对比</a>
                  @else
                      <a class="color66" ><span class="focus" value="{{$house->_source->id}},3,{{$housetype1}},0"><i class="follow"></i><span>{{(!empty($interest)&&(in_array($house->_source->id,$interest))?'取消关注':'关注')}}</span></span></a>
                      <a href="javascript:void(0);" onclick='addBuildCompare({{$house->_source->id}},"{{$house->_source->name}}",0,{{$housetype1}});' class="color66"><i class="contrast"></i>对比</a>
                  @endif
              </p>
          </dd>
      </dl>
   @endforeach
    @if(!empty($resBool))
        @if($subtype == 'build')
            <p class="more_home"><a class="color_blue" href="{{$linkurl}}">更多楼盘&gt;&gt;</a></p>
        @else
            <p class="more_home"><a class="color_blue" href="{{$linkurl}}">更多@if($type == 'spsale')商铺出售@else商铺出租@endif&gt;&gt;</a></p>
        @endif
    @endif
@else
  @if(empty($topHouse) && empty($resultfee))
       <p class="no_data">很抱歉，没有找到与“<span id="condition"></span>”相符的{{($subtype=='build')?'楼盘':'房源'}}！</p>
  @endif
@endif

  </div>
     @if(empty($resBool))
         <div class="page_nav">
             <ul>
                 {!!$pagingHtml!!}
             </ul>
         </div>
     @endif
  </div>
  <div class="list_r">
      @if($subtype == 'area')
        <div class="function">
            @if(strpos($type,'sale'))
                <a href="/houseHelp/sale/shop"><i class="sale"></i>个人出售</a>
                <a href="/houseHelp/sale/shop/entrust"><i class="sale_entrust"></i>委托出售</a>
            @else
                <a href="/houseHelp/rent/shop"><i class="sale"></i>个人出租</a>
                <a href="/houseHelp/rent/shop/entrust"><i class="sale_entrust"></i>委托出租</a>
            @endif
        </div>
      @endif
               @if($admodels->modelId == 1)
                <script type="text/javascript" src="/adShow.php?position=6&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShow.php?position=7&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShow.php?position=8&cityId={{CURRENT_CITYID}}"></script>
               @elseif($admodels->modelId == 2)
                <script type="text/javascript" src="/adShowModel.php?position=19&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShowModel.php?position=20&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShowModel.php?position=21&cityId={{CURRENT_CITYID}}"></script>
               @endif
<!--	    <div class="list_adv">
	       <a href="/adVisitCount?id=48&target=aHR0cHM6Ly9kZXRhaWwudG1hbGwuY29tL2l0ZW0uaHRtP3NwbT1hMXoxMC41LWItcy53NDAxMS0xNDg5NTg5Njg3OC4yMi5mQ09INHAmaWQ9NTMxOTIyMTY3OTkwJnJuPWFmNjE2NjNhNDJmMmRjYTJhYjJkODk0MjQ0ODE0MmRhJmFiYnVja2V0PTI=" target="_blank" ><img src="../../image/arlo_list.jpg" width="208" height="240" alt="广告"></a>
	    </div>
        <div class="list_adv">
          <a href="/ad/spread" target="_blank"><img src="../../image/module_banner_right.jpg" width="208" height="240" alt="广告"></a>
        </div>-->

      @if(!empty($currentPrice))
          <div class="list_info" style="display:none;">
              <p class="price_title">
                  @if(!empty($businessAreaName))
                      {{$businessAreaName}}房价走势>>
                  @elseif(!empty($cityAreaName))
                      {{$cityAreaName}}房价走势>>
                  @else
                      {{$cityName}}房价走势>>
                  @endif
              </p>
              <p class="price_info"><span class="color8d">{{date('m',strtotime('-1 month'))}}月份均价：</span><span class="price_r">{{$currentPrice}}{{($sr == 's')?'元/月':'元/平米▪天'}}</span></p>
              <div id="price_chart"></div>
          </div>
      @endif

        @if($putHouse)
      <div class="spread_new" id="spread">
        <p class="price_title">推荐房源</p>
        @foreach($putHouse as $k => $house)
        @if($house)
        <dl>
          <a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html" onclick="staClick('{{$house->_source->id}}','p')" target="_blank">
          <dt><img src="@if(!empty($house->_source->thumbPic)){{get_img_url($objectType,$house->_source->thumbPic,2)}}@else{{$defaultImage}}@endif" alt="标题图">
          @if($subtype !='school')
            @if(strpos($type,'sale'))
              @if(!empty($house->_source->price2))
              <span class="price">{{floor($house->_source->price2)}}万</span></dt>
              @else
              <span class="price">面议</span></dt>
              @endif
              <dd class="build_name">{{$house->_source->title}}</dd>
              <dd>
              @if(!empty($house->_source->roomStr))
              {{substr($house->_source->roomStr,0,1)}}室{{substr($house->_source->roomStr,2,1)}}厅&nbsp;&nbsp;&nbsp;@endif
              @if(!empty($house->_source->area)){{floor($house->_source->area)}}平米
              @endif
              @if(!empty($house->_source->brokers))
              @foreach($house->_source->brokers as $v)
              <span class="broker_name">{{$v->realName}}</span>
              @endforeach
              @endif
              </dd>
            @elseif(strpos($type,'rent'))
                @if(!empty($house->_source->price2))
                  @if(strpos($house->_source->price2,'.'))
                    <span class="price">{{substr($house->_source->price2,0,strpos($house->_source->price2,'.')+2)}}元/平米▪天</span>
                  @else
                    <span class="price">{{$house->_source->price2}}元/平米▪天</span>
                  @endif
                @else
                    <span class="price">面议</span></dt>
                @endif
                <dd class="build_name">{{$house->_source->title}}</dd>
                <dd>
                @if(!empty($house->_source->roomStr))
                {{substr($house->_source->roomStr,0,1)}}室{{substr($house->_source->roomStr,2,1)}}厅&nbsp;&nbsp;&nbsp;@endif
                @if(!empty($house->_source->area)){{floor($house->_source->area)}}平米
                @endif
                @if(!empty($house->_source->brokers))
                @foreach($house->_source->brokers as $v)
                <span class="broker_name">{{$v->realName}}</span>
                @endforeach
                @endif
                </dd>
            @endif
          @endif
          </a>
        </dl>
        @endif
        @endforeach
      </div>
      @endif
        @if($hotComm)
        <div class="spread_new">
          <p class="price_title"><a href="/shops/area">热销新盘>></a></p>
          @foreach($hotComm as $k => $hotFloor)
          <dl>
            <a href="/xinfindex/{{$hotFloor->_source->id}}/{{$hotFloor->_source->type2}}.html"  target="_blank">
            <dt><img src="@if(!empty($hotFloor->_source->titleImage)){{get_img_url('commPhoto',$hotFloor->_source->titleImage)}}@else{{$defaultImage}}@endif" alt="{{$hotFloor->_source->name}}" onerror="javascript:this.src='{{$defaultImage}}';"><span class="sale"></span></dt>
            <dd class="build_name">{{$hotFloor->_source->name}}<span>[{{$hotFloor->_source->areaname}}]</span></dd>
            <?php
                $priceSaleAvg = 'priceSaleAvg'.$hotFloor->_source->type2;
                $pricetype = $priceSaleAvg.'Unit';
                if(isset($hotFloor->_source->$pricetype) && $hotFloor->_source->$pricetype == 2){
                    $ptype = '万元/套';
                }else{
                    $ptype = '元/平米';
                }
            ?>
            <dd>@if($hotFloor->_source->type1 == 1)商铺 @elseif($hotFloor->_source->type1 == 2) 写字楼 @else 住宅 @endif &nbsp;&nbsp;&nbsp;@if(!empty($hotFloor->_source->$priceSaleAvg)) {{$hotFloor->_source->$priceSaleAvg}} {{$ptype}}@else 待定 @endif
            </dd>
            </a>
          </dl>
          @endforeach
        </div>
      @endif
 </div>
</div>
</div>
@include('list.footer1',['sr'=>$sr,'type'=>$type])

<div class="db">
  <dl class="title">
    <dt><i></i>展开</dt>
    <dd>{{($subtype=='build')?'楼盘':'房源'}}对比</dd>
  </dl>
  <div class="db_msg" style="display:none;">
    <h2>
     <span class="yc">隐藏<i></i></span>
     <span class="build_db">{{($subtype=='build')?'楼盘':'房源'}}对比</span>
    </h2>
    <div class="db_build">
      <p class="db_title">您浏览过的楼盘(<span class="color2d">最多勾选4项</span>)</p>
      <ul class="db_info">
      </ul>
      <div class="db_search">
      </div>
      <p class="db_submit">
          @if($subtype == 'build')
            <a href="javascript:void(0);" class="color66" onclick="startBuildCompare(0);" ><input type="button" class="btn back32" value="开始对比"></a>
          @else
              <a href="javascript:void(0);" class="color66" onclick='startCompare("{{($sr == "s")?"sale":"rent"}}");' ><input type="button" class="btn back32" value="开始对比"></a>
          @endif
          <input type="button" onclick="$('ul.db_info').html('')" class="btn backf3" value="全部清空">
      </p>
    </div>
  </div>
</div>

<script>
    //关注方法
    point_interest('focus','xcy');
    
    var _token = $('#token').val();
    $(function(){      
        @if(!empty($topHouse))
            var sale = [];
            var rent = [];
            var type = "{{$sr}}";
            @if(!empty($topHouse->found))                       
            if(type == 's'){
                sale.push("{{$topHouse->_source->id}}");
            }
            if(type == 'r'){
                rent.push("{{$topHouse->_source->id}}");                
            }
            @endif
            if(sale.length > 0 || rent.length > 0){
                $.post("/ajax/clickstatistic/display",{'sty':'housestickstatus','rent':rent,'sale':sale,'_token':_token},function(m){

                });
            }
        @endif
        
        @if($putHouse)
            var type = "{{$sr}}";
            var psale = [];
            var prent = [];
            @foreach($putHouse as $k => $house)
                @if($house)
                    if(type == 's'){
                        psale.push("{{$house->_source->id}}");                        
                    }
                    if(type == 'r'){
                        prent.push("{{$house->_source->id}}");                       
                    }
                @endif
            @endforeach
            if(psale.length > 0 || prent.length > 0){
                $.post("/ajax/clickstatistic/display",{'sty':'houseputstatus','sale':psale,'rent':prent,'_token':_token},function(m){

                });
            }
        @endif
        
    });
    function staClick(id,st){
        var styles;
        var csale = [];
        var crent = [];
        if(st == 't'){
            styles = 'housestickstatus';
        }else if(st == 'p'){
            styles = 'houseputstatus';
        }
        if(type == 's'){                      
            csale.push(id);           
        }
        if(type == 'r'){            
            crent.push(id);            
        }
        if(csale.length > 0 || crent.length > 0){
            $.post("/ajax/clickstatistic/click",{'sty':styles,'sale':csale,'rent':crent,'_token':_token},function(m){

            });
        }
//        alert(2222);
    }
</script>
@endsection