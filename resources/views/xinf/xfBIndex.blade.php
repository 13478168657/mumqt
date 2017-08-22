@extends('mainlayout')
@include('list.header')
@section('content')
<link rel="stylesheet" type="text/css" href="/css/buildDetail.css?v={{Config::get('app.version')}}">
<!--临时的js -->
<script src="/js/list.js?v={{Config::get('app.version')}}"></script>
@yield('xsearch')
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
    <input type="hidden" id="linkurl"  value="/{{$fenlei}}/area" >
    <input type="hidden" id="par"  value="" >
<p class="route">
  <span>您的位置：</span>
  <a href="{{url('/')}}">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="/{{$fenlei}}" class="colorfe">{{$cityName}}@if($fenlei == 'shops')商铺@elseif($fenlei == 'office')写字楼@else新房@endif楼盘</a>
</p>
<div class="xf_top">
    <dl class="xf_title">
        <dt><img src="http://pan.baidu.com/share/qrcode?w=150&h=150&url={{URL::current()}}"></dt>
        <dd>
            <h2>
                <span class="build_name">@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif</span>
                <span class="sale">{{$viewShowInfo['type2Name']}}</span>
                <span class="show_house">
                 <a class="follow"><span class="focus" value="{{$communityId}},3,{{substr($type2,0,1)}},1"><i></i><span>{{(!empty($interests)&&(in_array($communityId,$interests))?'已关注':'关注')}}</span></span></a>
                    <span class="share jiathis_style_24x24">
                    <span>分享到：</span>
                    <a class="jiathis_button_weixin " ></a>
                    <a class="jiathis_button_cqq " ></a>
                    <a class="jiathis_button_qzone no_right" ></a>
                    </span>
                </span>
            </h2>
            <p>
                <?php $x=1;?>
                @if(!empty($tagNames))
                    @foreach($tagNames as $k=>$tagName)
                        <span class="tag1">{{$tagName}}</span>
                        <?php $x++;if($x >5) break;?>
                    @endforeach
                @endif
                @if(!empty($diyTagNames))
                    @foreach($diyTagNames as $k=>$diyTag)
                        <?php if($x >5) break;$x++;?>
                        <span class="data_tag">{{$diyTag}}</span>
                    @endforeach
                @endif

                @if(!empty($commStatus))
                    <span class="dynamic">
                    <span>最新动态：</span>
                     <marquee onmouseout="this.start();" onmouseover="this.stop();" direction="left" scrolldelay="50" scrollamount="3">
                         @foreach($commStatus as $k=>$commStatu)
                             {{$commStatu->title}}&nbsp;&nbsp;{{$commStatu->news}}&nbsp;&nbsp;
                         @endforeach
                     </marquee>
                   </span>
                @endif
            </p>
        </dd>
    </dl>
</div>
<div class="detail">
	<div style="height: 52px; display: none;" id="void"></div>
    <div class="msg_nav msg_nav1" id="msg_nav">
      <a href="/xinfindex/{{$communityId}}/{{$type2}}.html" class="nav_click" >楼盘首页</a>
      <a href="/xinfxq/{{$communityId}}/{{$type2}}.html">楼盘详情</a>
      @if(!in_array($fenlei,['shops','office']))
      <a href="/xinfhx/{{$communityId}}/{{$type2}}.html">户型详情</a>
      @endif
      <a href="/xinfzs/{{$communityId}}/{{$type2}}.html">房价走势</a>
      <div class="clear"></div>
    </div>
</div>
<div class="fullScreen">
    <i class="close">关闭</i>
    <a class="f_left"></a>
    <a class="f_right"></a>
    <div class="pic_box">
        <img src="" alt="@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif楼盘图片">
        <span></span>
    </div>
</div>
<div class="main">
    <div class="xf_msg">
        @if(!empty($communityImages))
        <div id="jssor_1" style=" width: 600px; height: 450px;background:url(/image/houseImage.jpg) no-repeat;">
            <!-- Loading Screen -->
            <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
            </div>
            <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 600px; height: 450px; overflow: hidden;">
                    @foreach($communityImages as $k=>$communityImage)
                        <div data-p="112.50" class="pics" style="display: none;">
                            <img data-u="image" class="s_pic" src="{{get_img_url('commPhoto',$communityImage->fileName,5)}}" data_src="{{get_img_url('commPhoto',$communityImage->fileName)}}" alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif楼盘图片"/>
                            <img data-u="thumb" src="{{get_img_url('commPhoto',$communityImage->fileName,1)}}" alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif楼盘图片"/>
                        </div>
                    @endforeach
            </div>
            <div u="thumbnavigator" class="jssort03" data-autocenter="1">
                <div class="xf_img"></div>
                <div u="slides" style="cursor: default;">
                    <div u="prototype" class="p">
                        <div class="w">
                            <div u="thumbnailtemplate" class="t"></div>
                        </div>
                        <div class="c"></div>
                    </div>
                </div>
            </div>
            <span data-u="arrowleft" class="jssora02l" data-autocenter="2"></span>
            <span data-u="arrowright" class="jssora02r" data-autocenter="2"></span>
        </div>
        @else
            <div class="jssor_1"></div>
        @endif
        <div class="xf_r">
            <p>
                <label>均价：</label>
                @if(!empty($viewShowInfo['saleAvgPrice']))
                    <span class="xf_price">{{floor($viewShowInfo['saleAvgPrice'])}}</span>
                    <span>
                        @if(!empty($viewShowInfo['saleAvgPriceUnit']) && $viewShowInfo['saleAvgPriceUnit'] == 2)
                            万元/套
                            @else
                            元/平米
                            @endif
                    </span>
                @else
                    价格待定
                @endif
                <a class="jsq" href="/cal3" title="@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif房贷计算器"><i></i>房贷计算器</a>
            </p>
            <p>
                <label>优惠信息：</label>
                <span class="margin_r">
                    <span class="font_w">@if(!empty($viewShowInfo['youhui'])){{$viewShowInfo['youhui']}}@else暂无@endif</span>
                </span>

            </p>
            <p>
                @if($fenlei == 'new')
                    <label>楼盘户型：</label>
                    @if(!empty($viewShowInfo['room1Num']))
                        <a class="room" href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=1 @if(!empty($viewShowInfo['roomId1']))&roomId={{$viewShowInfo['roomId1']}}@endif" title="@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif一居户型">一居</a>
                    @endif
                    @if(!empty($viewShowInfo['room2Num']))
                        <a class="room" href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=2 @if(!empty($viewShowInfo['roomId2']))&roomId={{$viewShowInfo['roomId2']}}@endif" title="@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif二居户型">二居</a>
                    @endif
                    @if(!empty($viewShowInfo['room3Num']))
                        <a class="room" href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=3 @if(!empty($viewShowInfo['roomId3']))&roomId={{$viewShowInfo['roomId3']}}@endif" title="@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif三居户型">三居</a>
                    @endif
                    @if(!empty($viewShowInfo['room4Num']))
                        <a class="room" href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=4 @if(!empty($viewShowInfo['roomId4']))&roomId={{$viewShowInfo['roomId4']}}@endif" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif四居户型">四居</a>
                    @endif
                    @if(!empty($communityroom))
                        <a class="room" href="/xinfhx/{{$communityId}}/{{$type2}}.html" title="@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif全部户型"><i class="housetype"></i>全部户型</a>
                    @else
                        暂无户型
                    @endif
                @else
                    <label>开间面积：</label>
                    @if(!empty($type2GetInfo->bayAreaMin)&&!empty($type2GetInfo->bayAreaMax))
                        <span>{{$type2GetInfo->bayAreaMin}}-{{$type2GetInfo->bayAreaMax}}m²</span>
                    @else
                        <span>暂无</span>
                    @endif
                @endif
            </p>
            <!--<p class="phone">
                <i></i>
                @if(!empty($viewShowInfo['communityMobile']))
                    <?php $communityMobile = explode('|',$viewShowInfo['communityMobile']); ?>
                    @if(strpos($communityMobile[0],'-'))
                        <?php $pos = strrpos($communityMobile[0],"-"); ?>
                        <span class="tel">{{substr($communityMobile[0],0,$pos)}}</span>
                        <span class="font_z">转</span>
                        <span class="tel">{{substr($communityMobile[0],$pos+1)}}</span>
                    @else
                        <span class="tel">{{$communityMobile[0]}}</span>
                    @endif
                @else
                    暂无售楼热线
                @endif

            </p>-->
            <ul>
                <li>
                    <label>物业类型：</label>
                    <span>@if(!empty($viewShowInfo['type2Name'])) {{$viewShowInfo['type2Name']}} @else 暂无数据 @endif</span>
                </li>
                <li>
                    <label>物&nbsp;&nbsp;业&nbsp;费：</label>
                    <span>@if(!empty($type2GetInfo->propertyFee)) {{$type2GetInfo->propertyFee}}元/平方米·月 @else 暂无数据 @endif</span>
                </li>
                <li>
                    <label>开盘时间：</label>
                    <span>@if(!empty($viewShowInfo['startTime'])) {{$viewShowInfo['startTime']}} @else 暂无数据 @endif</span>
                </li>
                <li>
                    <label>交房时间：</label>
                    <span>@if(!empty($viewShowInfo['takeTime'])) 预计{{$viewShowInfo['takeTime']}} @else 暂无数据 @endif</span>
                </li>
                <li>
                    <label>绿&nbsp;&nbsp;化&nbsp;率：</label>
                    <span>@if(!empty($type2GetInfo->greenRate)) {{$type2GetInfo->greenRate}}% @else 暂无数据 @endif</span>
                </li>
                <li>
                    <label>容&nbsp;&nbsp;积&nbsp;率：</label>
                    <span>@if(!empty($type2GetInfo->volume)) {{$type2GetInfo->volume}} @else 暂无数据 @endif</span>
                </li>
                <li class="no_float">
                    <label>楼盘地址：</label>
                    <span>@if(!empty($viewShowInfo['address'])){{$viewShowInfo['address']}} @else 暂无数据 @endif<i></i></span>
                </li>
            </ul>
            <div class="xf_broker" id="generalize">
                @if(!empty($brokersMessage))
                    @foreach($brokersMessage as $broker)
                        <dl>
                            <dt><img src="{{get_img_url('userPhoto',$broker->photo,7)}}" littlesize alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif楼盘经纪人"></dt>
                            <dd>
                                <p class="xf_name">{{$broker->realName}}</p>
                                <p class="xf_tel">
                                    <span class="word">
                                        @if(!empty($broker->mobile))
                                            {{$broker->mobile}}
                                        @elseif(!empty($broker->phone))
                                            {{$broker->phone}}
                                        @endif
                                    </span>
                                </p>
                            </dd>
                        </dl>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="xf_comment">
        <h2>楼盘点评</h2>
        @if(!empty($commentInfo))
            @foreach($commentInfo as $comment)
                <dl>
                    <dt><span class="comment_name">{{mb_substr($comment->title,0,25,'utf-8')}}</span><span class="comment_time">{{substr($comment->timeCreate,0,16)}} 更新</span></dt>
                    <dd>{{$comment->comment}}</dd>
                </dl>
            @endforeach
        @else
            <dl>
                <dd>暂无点评</dd>
            </dl>
        @endif
    </div>
    <div class="detail">
      <div class="build xf_build">
        <!--<div style="height: 52px; display: none;" id="void"></div>
        <div class="msg_nav msg_nav1" id="msg_nav">
          <a href="/xinfindex/{{$communityId}}/{{$type2}}.html" class="nav_click" >楼盘首页</a>
          <a href="/xinfxq/{{$communityId}}/{{$type2}}.html">楼盘详情</a>
          <a href="/xinfhx/{{$communityId}}/{{$type2}}.html">户型详情</a>
          <a href="/xinfzs/{{$communityId}}/{{$type2}}.html">房价走势</a>
          <div class="clear"></div>
        </div>-->
      @if($fenlei == 'new')
        <div class="house_type">
          <h2><!--@if(!empty($viewShowInfo['communityName'])) @if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif @endif-->楼栋信息</h2>
          <div class="build_msg">
            <div class="build_img" id="pic">
              <ul>
                <li><span class="blue"></span>在售</li>
                <li><span class="or"></span>待售</li>
                <li><span class="gr"></span>售完</li>
              </ul>
              <div class="pic z_index" id="banImage" style="background-image:url(@if(!empty($viewShowInfo['buildingBackPic'])){{get_img_url('commPhoto',$viewShowInfo['buildingBackPic'])}}@endif); background-repeat:no-repeat;">
              @if(!empty($communitybuilding)&&!empty($viewShowInfo['buildingBackPic']))
                @foreach($communitybuilding as $k=>$build)
                    <?php if(empty($build->coordinateX)&&empty($build->coordinateY)) continue;  ?>
                    <div class="icon" style="position: absolute; left: {{$build->coordinateX}}px; top: {{$build->coordinateY}}px;" onClick="showData('data_{{$k}}');">
                        @if($build->state == 1 || $build->state == 0)
                        <a class="forSale"><span>{{$build->num}}号</span></a>
                        @elseif($build->state == 2)
                        <a class="staySale"><span>{{$build->num}}号</span></a>
                        @elseif($build->state == 3)
                        <a class="endSale"><span>{{$build->num}}号</span></a>
                        @endif
                    </div>
                @endforeach
              @endif
              </div>
            </div>
            <div class="build_r">
              <p class="title"><!--@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif -->楼栋列表</p>
              @foreach($communitybuilding as $k=>$build)
              <input type="hidden" name="coordinateX" value="{{$build->coordinateX}}">
              <input type="hidden" name="coordinateY" value="{{$build->coordinateY}}">
              <div class="hx" id="data_{{$k}}">
                <p class="hx_title"><i></i>@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif
                    @if(strpos($build->num,'号楼')){{$build->num}}@else {{$build->num}}号楼 @endif
                </p>
                <ul class="hx_msg" style="display:none;">
                  <li>
                   <span class="margin_l">开盘时间:</span>
                   <span>{{substr($build->openTime,0,10)}}</span>
                  </li>
                  <li>
                   <span class="margin_l">交房时间:</span>
                      @if(substr($build->takeTime,0,10) != '0000-00-00')
                          <span>{{substr($build->takeTime,0,10)}}</span>
                      @else
                          <span>待定</span>
                      @endif
                  </li>
                  <li>
                   <span class="margin_l">单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;元:</span>
                   {{--<span>含<span>{{$build->unitTotal}}</span>个单元</span>--}}
                   <span>@if(!empty($build->unitTotal))含<span>{{$build->unitTotal}}</span>个单元 @else 暂无 @endif</span>
                  </li>
                  <li>
                   <span class="margin_l">层&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数:</span>
                   <span>@if(!empty($build->floorTotal))<span>{{$build->floorTotal}}</span>层 @else 暂无 @endif</span>
                  </li>
                  <li>
                   <span class="margin_l">户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数:</span>
                   <span>@if(!empty($build->houseTotal))共<span>{{$build->houseTotal}}</span>户 @else 暂无 @endif</span>
                  </li>
                  <li>
                   <span class="margin_l">梯户配比:</span>
                   <span>
                       @if(!empty($build->liftHouseRatio))
                       <span>{{substr($build->liftHouseRatio,0,1)}}</span>梯<span>{{substr($build->liftHouseRatio,-1)}}</span>户
                       @else
                        暂无
                       @endif
                   </span>
                  </li>
                  <div class="clear"></div>
                @if(!empty($build->roomInfo))
                  <li class="no_left margin_t">
                    <p class="home_title">
                      <span>户型</span>
                      <a href="/xinfhx/{{$communityId}}/{{$type2}}.html">更多</a>
                    </p>
                  </li>
                @else
                  <li class="no_left margin_t">
                    <span>户型</span>
                    <span style="margin-left:120px;">暂无数据</span>
                  </li>
                @endif
                  @foreach($build->roomInfo as $room)
                  <li class="no_left">
                      <span>{{$room->name}}</span>
                      <span style="margin-left:100px;">{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨</span>
                      <a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype={{$room->room}}&roomId={{$room->id}}">详情</a>
                  </li>
                  @endforeach
                </ul>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
      @if(!empty($communityroom))
        <div class="house_type">
          <h2><!--@if(!empty($viewShowInfo['communityName'])) @if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif @endif-->户型详情（@if(!empty($viewShowInfo['roomAllNum'])) {{$viewShowInfo['roomAllNum']}} @else 0 @endif）
            @if($fenlei == 'new')
            <span>
                @if(!empty($viewShowInfo['room2Num']))
                    <a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=2 @if(!empty($viewShowInfo['roomId2']))&roomId={{$viewShowInfo['roomId2']}}@endif">二居（{{$viewShowInfo['room2Num']}}）</a>
                @endif
                @if(!empty($viewShowInfo['room2Num']) && !empty($viewShowInfo['room3Num']))
                    <span class="dotted"></span>
                @endif
                @if(!empty($viewShowInfo['room3Num']))
                    <a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=3 @if(!empty($viewShowInfo['roomId3']))&roomId={{$viewShowInfo['roomId3']}}@endif">三居（{{$viewShowInfo['room3Num']}}）</a>
                @endif
            </span>
            @else
             <span>
                 @if(!empty($viewShowInfo['room1Num']))
                    <a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=首层@if(!empty($viewShowInfo['roomId1']))&roomId={{$viewShowInfo['roomId1']}}@endif">首层（{{$viewShowInfo['room1Num']}}）</a>
                     @if(!empty($viewShowInfo['room2Num'])||!empty($viewShowInfo['room3Num']))
                        <span class="dotted"></span>
                     @endif
                 @endif
                 @if(!empty($viewShowInfo['room2Num']))
                    <a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=标准层@if(!empty($viewShowInfo['roomId2']))&roomId={{$viewShowInfo['roomId2']}}@endif">标准层（{{$viewShowInfo['room2Num']}}）</a>
                    @if(!empty($viewShowInfo['room3Num']))
                        <span class="dotted"></span>
                    @endif
                 @endif
                 @if(!empty($viewShowInfo['room3Num']))
                    <a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype=顶层@if(!empty($viewShowInfo['roomId3']))&roomId={{$viewShowInfo['roomId3']}}@endif">顶层（{{$viewShowInfo['room3Num']}}）</a>
                 @endif
             </span>
            @endif
          </h2>
          <div class="type_img">
            @foreach($communityroom as $key => $room)
              <?php if($key == 5) break; ?>
            <dl style="@if($key == 4) margin-right:0\0 @endif">

              @if($fenlei == 'new')
                    <dt><a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype={{$room->room}}&roomId={{$room->id}}" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif户型图"><img src="{{get_img_url('room',$room->thumbPic,2)}}" alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif户型图"></a></dt>
                  <dd><a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype={{$room->room}}&roomId={{$room->id}}">{{$room->name}}户型</a></dd>
                  {{--<dd>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨{{$room->balcony}}阳台{{$room->floorage}}㎡(建面)</dd>--}}
                  <dd>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨{{$room->floorage}}㎡(建面)</dd>
              @else
                    <dt><a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype={{$room->room}}&roomId={{$room->id}}"><img src="{{get_img_url('room',$room->thumbPic,2)}}" alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif户型图"></a></dt>
                    <dd><a href="/xinfhx/{{$communityId}}/{{$type2}}.html?roomtype={{$room->location}}&roomId={{$room->id}}">{{$room->location}} {{$room->name}}</a></dd>
                    <dd>建筑面积{{$room->floorage}}平米</dd>
              @endif
            </dl>
            @endforeach
          </div>
        </div>
      @endif
      <div class="house_type">
              <h2><!--@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}}@endif-->周边配套地图</h2>
              <div class="map xf_map">
                  <p class="tab_nav">
                 <span>
                   <a class="tab_l">街景地图</a>
                   <a class="tab_r click">交通地图</a>
                 </span>
                  </p>
                  <div style="display:none;" class="jj" id="quanjing"></div>
                  <div class="jt">
                      <p class="jt_nav">
                          <a class="curpos">楼盘位置</a>
                          <a class="chechData" attr="小区" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边楼盘">周边楼盘</a>
                          <a class="chechData" attr="公交" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边交通">交通</a>
                          <a class="chechData" attr="超市" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边超市">超市</a>
                          <a class="chechData" attr="学校" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边学校">学校</a>
                          <a class="chechData" attr="餐饮" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边餐饮">餐饮</a>
                          <a class="chechData" attr="银行" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边银行">银行</a>
                          <a class="chechData" attr="医院" title="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif周边医院">医院</a>
                      </p>
                      <div class="assort">
                          <div class="assort" id="allmap"></div>
                          <div class="assort_nav">
                              <div id="zk" class="zk"></div>
                              <h2 id="soukey"></h2>
                              <div id="r-result" style="height: 320px;overflow-y: auto;"></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
    <!-- 写字楼 商铺 显示 开始-->
      @if($fenlei != 'new')
        @if(!empty($comRent))
            <div class="house_type">
              <h2>@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif&nbsp;租房<span><a href="/{{($fenlei=='office')?'xzl':'sp'}}rent/area/ba{{$communityId}}" target="_blank">更多...</a></span></h2>
              <div class="apartment">
                  <div class="apartment_house">
                      @foreach($comRent as $k=>$rv)
                          <dl style="@if($k == 4) margin-right:0\0 @endif">
                              <dt><a href="/housedetail/sr{{$rv->_source->id}}.html" target="_blank"><img src="@if(!empty($rv->_source->thumbPic)){{get_img_url('commPhoto',$rv->_source->thumbPic,2)}}@else{{"/image/noImage.png"}}@endif"></a></dt>
                              <dd class="home_name"><a href="/housedetail/sr{{$rv->_source->id}}.html" target="_blank">{{mb_substr($rv->_source->title,0,20,'utf-8')}}</a></dd>
                              <dd>
                                  <p class="p1">{{$rv->_source->area}}平米</p>
                                  <p class="p2 color8d">
                                      @if(!empty($rv->_source->price2))
                                            <span class="colorfe">{{$rv->_source->price2}}</span>元/平米▪天
                                      @else
                                          <span class="colorfe">面议</span>
                                      @endif
                                  </p>
                              </dd>
                          </dl>
                      @endforeach
                  </div>
              </div>
            </div>
        @endif
        @if(!empty($comSale))
            <div class="house_type">
                <h2>@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif&nbsp;二手房<span><a href="/{{($fenlei=='office')?'xzl':'sp'}}sale/area/ba{{$communityId}}" target="_blank">更多...</a></span></h2>
                <div class="apartment">
                    <div class="apartment_house">
                        @foreach($comSale as $k=>$sv)
                            <dl style="@if($k == 4) margin-right:0\0 @endif">
                                <dt><a href="/housedetail/ss{{$rv->_source->id}}.html" target="_blank"><img src="@if(!empty($sv->_source->thumbPic)){{get_img_url('commPhoto',$sv->_source->thumbPic,2)}}@else{{"/image/noImage.png"}}@endif"></a></dt>
                                <dd class="home_name"><a href="/housedetail/ss{{$rv->_source->id}}.html" target="_blank">{{mb_substr($sv->_source->title,0,20,'utf-8')}}</a></dd>
                                <dd>
                                    <p class="p1">{{$sv->_source->area}}平米</p>
                                    <p class="p2 color8d">
                                        @if(!empty($sv->_source->price2))
                                            <span class="colorfe">{{$sv->_source->price2}}</span>元/平米▪天
                                        @else
                                            <span class="colorfe">面议</span>
                                        @endif
                                    </p>
                                </dd>
                            </dl>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
      @endif
    <!-- 写字楼 商铺 显示 结束-->

      @if(!empty($commAround))
        <div class="house_type">
          <h2><!--@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif-->周边楼盘<span><a href="/{{$fenlei}}?{{!empty($lnglat)?$lnglat:''}}">更多</a></span></h2>
          <div class="apartment">
            <div class="apartment_house">
                    <?php $i=0; ?>
             @foreach($commAround as $around)
                 <?php
                        if(empty($type2)){
                            $type2 = '';
                            if(!empty($around->_source->type1)){
                                $ctype1 = substr($around->_source->type1,0,1);
                                foreach(explode('|',$around->_source->type2) as $ctype2){
                                    if($ctype1 == substr($ctype2,0,1)){
                                        $type2 = $ctype2;
                                        break;
                                    }
                                }
                            }
                        }
                            $priceAvgtype2 = 'priceSaleAvg'.$type2;
                            $priceAvg = 'priceSaleAvg'.substr($type2,0,1);
                            $priceAvgtype2Unit = $priceAvgtype2 .'Unit';
                            $priceAvgUnit = $priceAvg .'Unit';
                        $i++;
                        if($i >5){
                            break;
                        }
                ?>
              <dl style="@if($i == 5) margin-right:0\0 @endif">
                <dt><a href="/xinfindex/{{$around->_source->id}}/{{$type2}}.html" target="_blank"><img src="@if(!empty($around->_source->titleImage)){{get_img_url('commPhoto',$around->_source->titleImage,2)}}@else{{"/image/noImage.png"}}@endif" alt=""></a></dt>
                <dd class="home_name margin_t"><a href="/xinfindex/{{$around->_source->id}}/{{$type2}}.html" target="_blank" class="color_blue">{{$around->_source->name}}</a></dd>
                <dd>
                    @if(!empty($around->_source->$priceAvgtype2))
                        <span class="colorfe">{{$around->_source->$priceAvgtype2}}</span>
                        @if(!empty($around->_source->$priceAvgtype2Unit) && $around->_source->$priceAvgtype2Unit == 2)
                        万元/套
                        @else
                        元/平方米
                        @endif
                    @else
                        @if(!empty($around->_source->$priceAvg))
                            <span class="colorfe">{{$around->_source->$priceAvg}}</span>
                            @if(!empty($around->_source->$priceAvgUnit) && $around->_source->$priceAvgUnit == 2)
                                万元/套
                            @else
                                元/平方米
                            @endif
                        @else
                            <span class="colorfe">价格待定</span>
                        @endif
                    @endif
                </dd>
                <dd>{{$around->_source->address}}</dd>
              </dl>
             @endforeach

            </div>
          </div>
        </div>
      @endif
      </div>
     </div>
    <div style="display: none;" id="broker" class="xf_broker broker">
        @if(!empty($brokersMessage))
            @foreach($brokersMessage as $broker)
                <dl>
                    <dt><img src="{{get_img_url('userPhoto',$broker->photo,8)}}" alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif楼盘经纪人"></dt>
                    <dd>
                        <p class="xf_name">{{$broker->realName}}</p>
                        <p class="xf_tel">
                            <span class="word">
                                @if(!empty($broker->mobile))
                                    {{$broker->mobile}}
                                @elseif(!empty($broker->phone))
                                    {{$broker->phone}}
                                @endif
                            </span>
                        </p>
                    </dd>
                </dl>
            @endforeach
        @endif
    </div>
</div>
<script src="/js/specially/headNav.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{config('mapApiKey.baidu')}}"></script>
<script type="text/javascript">
    $(function(){
        //经纬度
        var longitude = "{{!empty($jingduMap)?$jingduMap:0}}";
        var latitude = "{{!empty($weiduMap)?$weiduMap:0}}";
        if((longitude == 0) && (longitude == 0)){
            longitude = '116.405467';
            latitude = '39.907761';
        }
        // 百度地图API功能
        var map = new BMap.Map("allmap");    // 创建Map实例
        var point = new BMap.Point(longitude, latitude);
        map.centerAndZoom(point, 15);  // 初始化地图,设置中心点坐标和地图级别
        map.enableScrollWheelZoom(true);
        //街景地图
        var panoramaService = new BMap.PanoramaService();
        panoramaService.getPanoramaByLocation(point, function(data){
            var panoramaInfo="";
            if (data == null) {
                $('.tab_l').hide();
                return;
            }
            var panorama = new BMap.Panorama('quanjing');
            panorama.setPosition(point); //根据经纬度坐标展示全景图
            panorama.setPov({ heading: -40, pitch: 6 });
        });
        $('.tab_r').click(function(){
            var marker2 = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker2);
        }).trigger('click');
        //周边点击
        $('.chechData').bind('click',function(){
            var data1 = $(this).attr('attr');
            var data2 = $(this).text();
            chechData(data1,data2);
        });

        function chechData(data1,data2){
            $('#soukey').text(data2);
            $('.periphery_nav').hide();
            $('.periphery_build').show();
            curpos();
            $('.assort_nav').show();
            $('soukey').html('<i></i>'+data2);
            var circle = new BMap.Circle(point,1000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
            map.addOverlay(circle);
            var local =  new BMap.LocalSearch(map, {renderOptions: {map: map, panel:"r-result", autoViewport: false},pageCapacity:5});
            local.searchNearby(data1,point,1000);
        }
        $('.curpos').click(function(){
            var c_name = "{{$viewShowInfo['communityName'] or '暂无'}}";
            var c_address = "{{$viewShowInfo['address'] or '暂无'}}";
            $(this).addClass("click");
            map.clearOverlays();
            //当前楼盘地址
            var marker2 = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker2);
            var opts = {
                width : 100,     // 信息窗口宽度
                height: 70,     // 信息窗口高度
                title : "楼盘名：" + c_name , // 信息窗口标题
                offset   : new BMap.Size(-5,-20)    //设置文本偏移量
            }
            var infoWindow = new BMap.InfoWindow("地址：" + c_address, opts);  // 创建信息窗口对象
            map.openInfoWindow(infoWindow,point); //开启信息窗口
            $('.assort_nav').hide();
        }).trigger('click');;
        //楼盘位置
        function curpos(){
            map.clearOverlays();
            //当前楼盘地址
            var marker2 = new BMap.Marker(point);  // 创建标注
            map.addOverlay(marker2);
            var opts = {
                position : point,    // 指定文本标注所在的地理位置
                offset   : new BMap.Size(-45,-50)    //设置文本偏移量
            }
            var label = new BMap.Label("&nbsp;当前楼盘位置&nbsp;", opts);  // 创建文本标注对象
            label.setStyle({
                color : "red",
                fontSize : "12px",
                height : "20px",
                lineHeight : "20px",
                fontFamily:"微软雅黑"
            });
            map.addOverlay(label);
        }
    });
</script>
<script>
$(function(){
  $('body').keydown(function(event){
	 if(event.keyCode == 27){
		clo();
	 }
  });
})
$(document).ready(function(e) {
  $(".hx .hx_title").click(function(){
    if($(this).parent().find(".hx_msg").css("display")=="none"){
		$(".hx_msg").css("display","none")
		$(this).parent().find(".hx_msg").css("display","block")
		$(".hx .hx_title i").removeClass("click");
		$(this).find("i").addClass("click"); 
    }else{
		$(this).parent().find(".hx_msg").css("display","none")
		$(".hx .hx_title i").removeClass("click");  
    }
  });
  
  $(".hx .no_left p").click(function(){
   if($(this).parent().find(".home_contant").css("display")=="block"){
    $(this).parent().find(".home_contant").css("display","none"); 
   }else{
    $(this).parent().find(".home_contant").css("display","block"); 
   }
  });
  

  $(".comment .comment_msg .look").click(function(){
    $(this).hide();  
    $(this).parents(".comment").find(".comment_info").hide();
    $(this).parents(".comment").find(".comment_info1").show();
    $(this).parents(".comment").find(".retract").show();
  });
  $(".comment_info1 .retract").click(function(){
    $(this).hide();  
    $(this).parent().hide();
    $(this).parents(".comment").find(".comment_info").show(); 
    $(this).parents(".comment").find(".look").show();
  });

   var _token="{{csrf_token()}}";
$.post('/ajax/houseclick',{'url':window.location.href,'_token':_token},function(d){
//console.info(d);
})
});
window.onload = function(){
    var brokerCount = "{{count($brokersMessage)}}";
    var oDiv = document.getElementById("msg_nav");
    var h = oDiv.offsetTop;
    var oDiv1 = document.getElementById("generalize");
    var h1 = oDiv1.offsetTop+100;
    document.onscroll = function(){
        var t = document.documentElement.scrollTop || document.body.scrollTop;
        if(h <= t){
            oDiv.style.position = 'fixed';
        }else{
            oDiv.style.position = '';
        }

        var t1 = document.documentElement.scrollTop || document.body.scrollTop;
        if(h1 <= t1){
            if(parseInt(brokerCount) > 0){
                $("#broker").show();
            }else{
                $("#broker").hide();
            }
        }else{
            $("#broker").hide();
        }
    }
	
	var imgSrc =$("#banImage").css("background-image");
	var image=imgSrc.substr(5,imgSrc.length-7);
	  
	if(image.indexOf("jpg")<0){
		image=imgSrc.substr(4,imgSrc.length-5);
	}
	var img=new Image();
	img.src=image;
	
	$("#banImage").css("width",img.width);
	$("#banImage").css("height",img.height);
};

$(function(){
    //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:100,
    overlay:0.45
  });

});
//楼栋标注
function showData(data){
    $(".hx_msg").css("display","none");
    $(".hx .hx_title i").removeClass("click");
    $("#"+data).find(".hx_msg").show();
    $("#"+data).find(".hx_title i").addClass("click");
}
</script>
<script src="/js/login.js?v={{Config::get('app.version')}}"></script>
<script src="/js/point_interest.js?v={{Config::get('app.version')}}"></script>
@if($fenlei == 'new' && !empty($viewShowInfo['buildingBackPic']))
<script src="/js/PageEffects/draggable.js?v={{Config::get('app.version')}}"></script>
@endif
@if(!empty($communityImages))
<!--全屏图片滚动-->
<script type="text/javascript" src="/js/plugs/jssor.slider.mini.js"></script>
<script>
    jQuery(document).ready(function ($) {

        var jssor_1_options = {
            $AutoPlay: true,
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 9,
                $SpacingX: 3,
                $SpacingY: 3,
                $Align: 260
            }
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        jssor_1_slider.$CurrentIndex()
        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizing
        function ScaleSlider() {
            var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 600);
                jssor_1_slider.$ScaleWidth(refSize);
            }
            else {
                window.setTimeout(ScaleSlider, 300);
            }
        }
        ScaleSlider();
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
    });
    //全屏图片
    var fullMask=$('.fullScreen');
    var fullPic=$('.pic_box img');
    var fullPrev=$('.fullScreen .f_left');
    var fullRight=$('.fullScreen .f_right');
    var fullClose=$('.fullScreen .close');
    var sliderPic=$('.s_pic');
    var now=0;
    $('.pics').click(function(){
        fullMask.show();
        var _index=$(this).index();
        now=_index-1;
        fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
    });

    fullPrev.on('click',function(){
        now--;
        if(now<0){
            now=sliderPic.length-1;
        }
        fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
    });
    //right
    fullRight.on('click',function(){
        now++;
        if(now>sliderPic.length-1){
            now=0;
        }
        fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
    });
	//点击图片显示下一张
	fullPic.on('click',function(){
        now++;
        if(now>sliderPic.length-1){
            now=0;
        }
        fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
    });
    //close
    fullClose.on('click',function(){
        fullMask.hide();
    });

    //esc
    $(document).on('keydown',function(ev){
        if(ev.keyCode==27){
            fullMask.hide();
        }
    });
</script>
@endif
<script>
    //关注方法
    point_interest('focus','xcy');
</script>
<?php // 引入分享的js  ?>
@include('layout.share')
@endsection