@extends('mainlayout')
@section('title')
<title>【@if(isset($info[0])){{$info[0]['name']}}怎么样 @endif @if(isset($info[1])){{$info[1]['name']}}怎么样？@endif @if(isset($info[2])){{$info[2]['name']}}怎么样？@endif @if(isset($info[3])){{$info[3]['name']}}怎么样？@endif @if(count($info) >= 2)@if(isset($info[0]['name'])){{$info[0]['name']}}@endif @if(isset($info[1]['name']))和{{$info[1]['name']}}@endif @if(isset($info[2]['name']))和{{$info[2]['name']}}@endif @if(isset($info[3]['name']))和{{$info[3]['name']}}@endif哪个好？@endif】楼盘对比-搜房网</title>
<meta name="keywords" content="@if(isset($info[0])){{$info[0]['name']}}怎么样？@endif @if(isset($info[1])){{$info[1]['name']}}怎么样？@endif @if(isset($info[2])){{$info[2]['name']}}怎么样？@endif @if(isset($info[3])){{$info[3]['name']}}怎么样？@endif @if(count($info) >= 2)@if(isset($info[0]['name'])){{$info[0]['name']}}@endif @if(isset($info[1]['name']))和{{$info[1]['name']}}@endif @if(isset($info[2]['name']))和{{$info[2]['name']}}@endif @if(isset($info[3]['name']))和{{$info[3]['name']}}@endif哪个好？@endif"/>
<meta name="description" content="搜房网—楼盘对比通过对其价格、基本信息、户型、周边配套的对比，可以更快了解对比楼盘的对应优势与劣势，更好的明确您的需求！"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="css/house_loan.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/personalLogin.css?v={{Config::get('app.version')}}">
<div class="catalog_nav no_float">
    <div class="margin_auto clearfix">
      <div class="list_sub">
         <div class="list_search">
            <input type="text" class="txt border_blue" placeholder="请输入关键字（楼盘名/地名/开发商等）" id="keyword">
            <input type="text" class="btn back_color keybtn" value="搜房">
           <!--  <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="type2" value="301"> -->
          </div>
      </div>
 </div>
</div>
<input type="hidden" name="type1" value="{{$info[0]['type1']}}">
<input type="hidden" name="type2" value="{{$info[0]['type2']}}">
<form id="build" method="post">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <input type="hidden" id="linkurl"  value="{{$info[0]['url']}}" >
    <input type="hidden" id="par"  value="" >
</form>
<p class="route">
  <span>您的位置：</span>
  <a href="{{url('/')}}">首页</a>
  <span>&nbsp;>&nbsp;</span>
  @if($conn == 1)
  <a href="{{url('/new/area')}}" class="colorfe">{{$city}}&nbsp;新房</a>
  @else
  <a href="{{url('/saleesb/area')}}" class="colorfe">{{$city}}&nbsp;二手房</a>
  @endif
  <span>&nbsp;>&nbsp;</span>
  <span>楼盘对比</span>
</p>
<div class="contrast">
  <div class="contrast_l">
    <div class="empty-placeholder hidden"></div>
    <div class="contrast_nav"  id="contrast_nav">
    @if(!empty($conn))
      <a class="adv_door click" href="#item1">最新价格</a>
      <span>均价</span>
      <span>优惠</span>
    @endif
      <a class="adv_img @if(empty($conn)) click @endif" @if(empty($conn)) href="#item1" @else href="#item2" @endif>基本信息</a>
      <span>项目位置</span>
      <span>项目特色</span>
      <span>产权年限</span>
      @if(!empty($conn))
      <span>开盘时间</span>
      @endif
      <span>开发商</span>
      <span>建筑类型</span>
      <span>装修状况</span>
      <span>容积率</span>
      @if(isset($info[0]) && $info[0]['type1'] == 3)
      <span>户数</span>
      @endif
      <span>物业费</span>
      <a class="adv_transfer" @if(empty($conn)) href="#item2" @else href="#item3" @endif>户型对比</a>
      <span>户型</span>
      <a class="adv_price" @if(empty($conn)) href="#item3" @else href="#item4" @endif>周边配套</a>
      <span>交通状况</span>
      <span>周边学校</span>
      <span>周边医院</span>
    </div>
  </div>
  <div class="contrast_r">
    <p class="contrast_subnav">
      <a href="buildContrast.htm" class="click">基本信息对比</a>
      <!-- <a href="imageContrast1.htm">图片对比</a> -->
    </p>
    <table id="contrast">
      <tr>
        <th>楼盘对比</th>
        <td colspan="4" class="mai">
          <input type="text" class="txt" id="addCommInfo" name="selectBuild">
          <div class="pop">
            <ul></ul>
          </div>
          <input type="button" class="btn back_color addCommInfo" value="+对比">          
        </td>
      </tr>
      <tr>
      <!-- 楼盘名称 -->
        <th width="180">楼盘名称</th>
        <td width="225" class="101" id="101">
          @if(isset($info[0]))
          <a>
            <dl class="build_name">
              <dt><img src="{{$info[0]['titleImg']}}" width="160" height="100" alt="{{$info[0]['name']}}"></dt>
              <dd class="resize_w"><span id="check1" value="{{$info[0]['id']}}-{{$info[0]['type2']}}" value2="{{$info[0]['id']}}">{{$info[0]['name']}}</span><i class="delete1"></i></dd>
            </dl>
          </a>
          @endif
        </td>
        <td width="225" class="201" id="201">
          @if(isset($info[1]))
            <a>
              <dl class="build_name">
                  <dt><img src="{{$info[1]['titleImg']}}" width="160" height="100" alt="{{$info[1]['name']}}"></dt>
                <dd><span id="check2" value="{{$info[1]['id']}}-{{$info[1]['type2']}}" value2="{{$info[1]['id']}}">{{$info[1]['name']}}</span><i class="delete2"></i></dd>
              </dl>
            </a>
          @endif
        </td>
        <td width="225" class="301" id="301">
          @if(isset($info[2]))
            <a>
              <dl class="build_name">
                <dt><img src="{{$info[2]['titleImg']}}" width="160" height="100" alt="{{$info[2]['name']}}"></dt>
                <dd><span id="check3" value="{{$info[2]['id']}}-{{$info[2]['type2']}}" value2="{{$info[2]['id']}}">{{$info[2]['name']}}</span><i class="delete3"></i></dd>
              </dl>
            </a>
          @endif
        </td>
        <td width="225" class="401" id="401">
          @if(isset($info[3]))
            <a>
              <dl class="build_name">
                <dt><img src="{{$info[3]['titleImg']}}" width="160" height="100" alt="{{$info[3]['name']}}"></dt>
                <dd><span id="check4" value="{{$info[3]['id']}}-{{$info[3]['type2']}}" value2="{{$info[3]['id']}}">{{$info[3]['name']}}</span><i class="delete4"></i></dd>
              </dl>
            </a>
          @endif
        </td>
      </tr>
      <!-- <tr>
        <th>用户评分</th>
        <td class="101" id="102">
          <a class="icon">
           <img src="image/red.png"><img src="image/red.png"><img src="image/red.png"><img src="image/redgray.png"><img src="image/gray.png"><span class="colorfe"><span class="font_size">4</span>.06分</span><br/>
           共有62人参与
          </a>
        </td>
        <td class="201" id="202">
          <a class="icon">
           <img src="image/red.png"><img src="image/red.png"><img src="image/red.png"><img src="image/redgray.png"><img src="image/gray.png"><span class="colorfe"><span class="font_size">4</span>.14分</span><br/>
           共有62人参与
          </a>
        </td>
        <td class="301" id="302"></td>
        <td class="401" id="402"></td>
      </tr> -->
@if(!empty($conn))
      <tr>
        <th colspan="5"><p class="price" id="item1"><span class="border back_color"></span><span class="new_price">最新价格</span></p></th>
      </tr>

      <tr height="40">
      <!-- 价格 -->
        <th>价格</th>
        <td class="101" id="103">@if(isset($info[0]) && !empty($info[0]['saleAvgPrice']))均价<span class="colorfe font_size1">{{$info[0]['saleAvgPrice']}}</span>元/平方米@endif</td>
        <td class="201" id="203">@if(isset($info[1]) && !empty($info[1]['saleAvgPrice']))均价<span class="colorfe font_size1">{{$info[1]['saleAvgPrice']}}</span>元/平方米@endif</td>
        <td class="301" id="303">@if(isset($info[2]) && !empty($info[2]['saleAvgPrice']))均价<span class="colorfe font_size1">{{$info[2]['saleAvgPrice']}}</span>元/平方米@endif</td>
        <td class="401" id="403">@if(isset($info[3]) && !empty($info[3]['saleAvgPrice']))均价<span class="colorfe font_size1">{{$info[3]['saleAvgPrice']}}</span>元/平方米@endif</td>
      </tr>
      <tr height="50">
      <!-- 优惠 -->
        <th>优惠</th>
        <td class="101" id="104">@if(isset($info[0])) @if(isset($info[0]['zhekou'])) {{$info[0]['zhekou']}} <br> @endif {{$info[0]['specialOffers']}} @endif</td>
        <td class="201" id="204">@if(isset($info[1])) @if(isset($info[1]['zhekou'])) {{$info[1]['zhekou']}} <br> @endif {{$info[1]['specialOffers']}} @endif</td>
        <td class="301" id="304">@if(isset($info[2])) @if(isset($info[2]['zhekou'])) {{$info[2]['zhekou']}} <br> @endif {{$info[2]['specialOffers']}} @endif</td>
        <td class="401" id="404">@if(isset($info[3])) @if(isset($info[3]['zhekou'])) {{$info[3]['zhekou']}} <br> @endif {{$info[3]['specialOffers']}} @endif</td>
      </tr>
@endif
      <tr>
        <th colspan="5"><p class="price" @if(empty($conn)) id="item1" @else id="item2" @endif><span class="border back_color"></span><span class="new_price">基本信息</span></p></th>
      </tr>
      <tr>
      <!-- 项目位置 -->
        <th>项目位置</th>
        <td class="101" id="105">
          @if(isset($info[0]))
          <div class="address"><i class="map_icon"></i><span><a>{{$info[0]['address']}}</a></span></div>
          @endif
        </td>
        <td class="201" id="205">
          @if(isset($info[1]))
            <div class="address"><i class="map_icon"></i><span><a>{{$info[1]['address']}}</a></span></div>
          @endif
        </td>
        <td class="301" id="305">
          @if(isset($info[2]))
            <div class="address"><i class="map_icon"></i><span><a>{{$info[2]['address']}}</a></span></div>
          @endif
        </td>
        <td class="401" id="405">
          @if(isset($info[3]))
            <div class="address"><i class="map_icon"></i><span><a>{{$info[3]['address']}}</a></span></div>
          @endif
        </td>
      </tr>
      <tr>
      <!-- 项目特色 -->
        <th>项目特色</th>
        <td class="101" id="106">
            <div class="item">
              @if(@isset($info[0]['tagName'][0]))<a href="#">{{$info[0]['tagName'][0]}}</a>@endif 
              @if(@isset($info[0]['tagName'][1]))<a>{{$info[0]['tagName'][1]}}</a>@endif
              @if(@isset($info[0]['tagName'][2]))<a>{{$info[0]['tagName'][2]}}</a>@endif
              @if(@isset($info[0]['tagName'][3]))<a>{{$info[0]['tagName'][3]}}</a>@endif
            </div>
        </td>
        <td class="201" id="206">
            <div class="item">
              @if(@isset($info[1]['tagName'][0]))<a href="#">{{$info[1]['tagName'][0]}}</a>@endif 
              @if(@isset($info[1]['tagName'][1]))<a>{{$info[1]['tagName'][1]}}</a>@endif
              @if(@isset($info[1]['tagName'][2]))<a>{{$info[1]['tagName'][2]}}</a>@endif
              @if(@isset($info[1]['tagName'][3]))<a>{{$info[1]['tagName'][3]}}</a>@endif
            </div>
        </td>
        <td class="301" id="306">
           <div class="item">
              @if(@isset($info[2]['tagName'][0]))<a href="#">{{$info[2]['tagName'][0]}}</a>@endif 
              @if(@isset($info[2]['tagName'][1]))<a>{{$info[2]['tagName'][1]}}</a>@endif
              @if(@isset($info[2]['tagName'][2]))<a>{{$info[2]['tagName'][2]}}</a>@endif
              @if(@isset($info[2]['tagName'][3]))<a>{{$info[2]['tagName'][3]}}</a>@endif
           </div>
        </td>
        <td class="401" id="406">
            <div class="item">
              @if(@isset($info[3]['tagName'][0]))<a href="#">{{$info[3]['tagName'][0]}}</a>@endif 
              @if(@isset($info[3]['tagName'][1]))<a>{{$info[3]['tagName'][1]}}</a>@endif
              @if(@isset($info[3]['tagName'][2]))<a>{{$info[3]['tagName'][2]}}</a>@endif
              @if(@isset($info[3]['tagName'][3]))<a>{{$info[3]['tagName'][3]}}</a>@endif
           </div>
        </td>
      </tr>
      <tr height="50">
      <!-- 产权年限 -->
        <th>产权年限</th>
        <td class="101" id="107">
          @if(isset($info[0]))
            {{$info[0]['propertyYear']}}
          @endif
        </td>
        <td class="201" id="207">
          @if(isset($info[1]))
            {{$info[1]['propertyYear']}}
          @endif
        </td>
        <td class="301" id="307">
          @if(isset($info[2]))
            {{$info[2]['propertyYear']}}
          @endif
        </td>
        <td class="401" id="407">
          @if(isset($info[3]))
            {{$info[3]['propertyYear']}}
          @endif
        </td>
      </tr>
@if(!empty($conn))
      <tr height="50">
      <!-- 开盘时间 -->
        <th>开盘时间</th>
        <td class="101" id="108">@if(isset($info[0])) {{substr($info[0]['openTime'],0,10)}} @endif</td>
        <td class="201" id="208">@if(isset($info[1])) {{substr($info[1]['openTime'],0,10)}} @endif</td>
        <td class="301" id="308">@if(isset($info[2])) {{substr($info[2]['openTime'],0,10)}} @endif</td>
        <td class="401" id="408">@if(isset($info[3])) {{substr($info[3]['openTime'],0,10)}} @endif</td>
      </tr>
      <tr height="50">
      <!-- 入住时间 -->
        <th>入住时间</th>
        <td class="101" id="109">@if(isset($info[0])) {{substr($info[0]['takeTime'],0,10)}} @endif</td>
        <td class="201" id="209">@if(isset($info[1])) {{substr($info[1]['takeTime'],0,10)}} @endif</td>
        <td class="301" id="309">@if(isset($info[2])) {{substr($info[2]['takeTime'],0,10)}} @endif</td>
        <td class="401" id="409">@if(isset($info[3])) {{substr($info[3]['takeTime'],0,10)}} @endif</td>
      </tr>
@endif
      <tr height="50" class="backcolor">
      <!-- 开发商 -->
        <th>开发商</th>
        <td class="101" id="110">@if(isset($info[0])) {{$info[0]['developerName']}} @endif</td>
        <td class="201" id="210">@if(isset($info[1])) {{$info[1]['developerName']}} @endif</td>
        <td class="301" id="310">@if(isset($info[2])) {{$info[2]['developerName']}} @endif</td>
        <td class="401" id="410">@if(isset($info[3])) {{$info[3]['developerName']}} @endif</td>
      </tr>
      <tr height="50">
      <!-- 建筑类型 -->
        <th>建筑类型</th>
        <td class="101" id="111">@if(isset($info[0])) {{$info[0]['structure']}} @endif</td>
        <td class="201" id="211">@if(isset($info[1])) {{$info[1]['structure']}} @endif</td>
        <td class="301" id="311">@if(isset($info[2])) {{$info[2]['structure']}} @endif</td>
        <td class="401" id="411">@if(isset($info[3])) {{$info[3]['structure']}} @endif</td>
      </tr>
      <tr height="50">
      <!-- 装修状况 -->
        <th>装修状况</th>
        <td class="101" id="112">
          @if(isset($info[0]))
            {{$info[0]['decorate']}}
          @endif
        </td>
        <td class="201" id="212">
          @if(isset($info[1]))
            {{$info[1]['decorate']}}
          @endif
        </td>
        <td class="301" id="312">
          @if(isset($info[2]))
            {{$info[2]['decorate']}}
          @endif
        </td>
        <td class="401" id="412">
          @if(isset($info[3]))
            {{$info[3]['decorate']}}
          @endif
        </td>
      </tr>
      <tr height="50">
      <!-- 容积率 -->
        <th>容积率</th>
        <td class="101" id="113">
          @if(isset($info[0]))
            {{$info[0]['volume']}}
          @endif
        </td>
        <td class="201" id="213">
          @if(isset($info[1]))
            {{$info[1]['volume']}}
          @endif
        </td>
        <td class="301" id="313">
          @if(isset($info[2]))
            {{$info[2]['volume']}}
          @endif
        </td>
        <td class="401" id="413">
          @if(isset($info[3]))
            {{$info[3]['volume']}}
          @endif
        </td>
      </tr>
      <tr height="50">
      <!-- 绿化率 -->
        <th>绿化率</th>
        <td class="101" id="114">
          @if(isset($info[0]) && !empty($info[0]['greenRate']))
            {{$info[0]['greenRate']}}%
          @endif
        </td>
        <td class="201" id="214">
          @if(isset($info[1]) && !empty($info[1]['greenRate']))
            {{$info[1]['greenRate']}}%
          @endif
        </td>
        <td class="301" id="314">
          @if(isset($info[2]) && !empty($info[2]['greenRate']))
            {{$info[2]['greenRate']}}%
          @endif
        </td>
        <td class="401" id="414">
          @if(isset($info[3]) && !empty($info[3]['greenRate']))
            {{$info[3]['greenRate']}}%
          @endif
        </td>
      </tr>
      @if(isset($info[0]) && $info[0]['type1'] == 3)
      <tr height="50">
      <!-- 户数 -->
        <th>户数</th>
        <td class="101" id="115">@if(isset($info[0]) && !empty($info[0]['houseTotal'])) {{$info[0]['houseTotal']}}户 @endif</td>
        <td class="201" id="215">@if(isset($info[1]) && !empty($info[1]['houseTotal'])) {{$info[1]['houseTotal']}}户 @endif</td>
        <td class="301" id="315">@if(isset($info[2]) && !empty($info[2]['houseTotal'])) {{$info[2]['houseTotal']}}户 @endif</td>
        <td class="401" id="415">@if(isset($info[3]) && !empty($info[3]['houseTotal'])) {{$info[3]['houseTotal']}}户 @endif</td>
      </tr>
      @endif
      <tr height="50">
      <!-- 物业费 -->
        <th>物业费</th>
        <td class="101" id="116">
          @if(isset($info[0]) && !empty($info[0]['propertyFee']))
            {{$info[0]['propertyFee']}}元/平方米·月
          @endif
        </td>
        <td class="201" id="216">
          @if(isset($info[1]) && !empty($info[1]['propertyFee']))
            {{$info[1]['propertyFee']}}元/平方米·月
          @endif
        </td>
        <td class="301" id="316">
          @if(isset($info[2]) && !empty($info[2]['propertyFee']))
            {{$info[2]['propertyFee']}}元/平方米·月
          @endif
        </td>
        <td class="401" id="416">
          @if(isset($info[3]) && !empty($info[3]['propertyFee']))
            {{$info[3]['propertyFee']}}元/平方米·月
          @endif
        </td>
      </tr>
      <tr>
        <th colspan="5"><p class="price" @if(empty($conn)) id="item2" @else id="item3" @endif><span class="border back_color"></span><span class="new_price">户型对比</span></p></th>
      </tr>
      <tr height="50">
      <!-- 户型 -->
        <th>户型</th>
        <td class="101" id="117">
          <ul class="leyout">
          @if(isset($info[0]) && !empty($info[0]['room']))
            @foreach($info[0]['room'] as $room)
            <li><a href="#"><span class="leyout_l">{{$room[0]}}</span><span class="leyout_r">{{$room[1]}}平米</span></a></li>
            @endforeach
          @endif
          </ul>
        </td>
        <td class="201" id="217">
          <ul class="leyout">
            @if(isset($info[1]) && !empty($info[1]['room']))
              @foreach($info[1]['room'] as $room)
              <li><a href="#"><span class="leyout_l">{{$room[0]}}</span><span class="leyout_r">{{$room[1]}}平米</span></a></li>
              @endforeach
            @endif
          </ul>
        </td>
        <td class="301" id="317">
           <ul class="leyout">
           @if(isset($info[2]) && !empty($info[2]['room']))
              @foreach($info[2]['room'] as $room)
              <li><a href="#"><span class="leyout_l">{{$room[0]}}</span><span class="leyout_r">{{$room[1]}}平米</span></a></li>
              @endforeach
            @endif
          </ul>
        </td>
        <td class="401" id="417">
            <ul class="leyout">
             @if(isset($info[3]) && !empty($info[3]['room']))
              @foreach($info[3]['room'] as $room)
              <li><a href="#"><span class="leyout_l">{{$room[0]}}</span><span class="leyout_r">{{$room[1]}}平米</span></a></li>
              @endforeach
            @endif
          </ul>
        </td>
      </tr>
      <tr>
        <th colspan="5"><p class="price" @if(empty($conn)) id="item3" @else id="item4" @endif><span class="border back_color"></span><span class="new_price">周边配套</span></p></th>
      </tr>
      <tr>
      <!-- 交通状况 -->
        <th>交通状况</th>
        <td class="101 jt1" id="118" valign="top">
          <dl class="perimeter">
            <!-- <dt>地铁（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">长阳</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">房山线</p>
            </dd>
            <dd>
              <p><span class="perimeter_l">长阳</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">房山线</p>
            </dd>
            <dd>
              <p><span class="perimeter_l">长阳</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">房山线</p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd>
          </dl> 
          <dl class="perimeter">
            <dt>公交（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">地铁长阳站</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">646路;832路;907路</p>
            </dd>
            <dd>
              <p><span class="perimeter_l">长政南街</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">专93路</p>
            </dd>
            <dd>
              <p><span class="perimeter_l">长阳镇政府</span><span class="perimeter_r">148米</span></p>
              <p class="color8d width">房38路;房3路内环</p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd> -->
          </dl>
        </td>
        <td class="201 jt2" id="218" valign="top">
          <dl class="perimeter">
            <!-- <dt>公交（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">潮白河孔雀城</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">910路;潮白河孔雀城</p>
            </dd>
            <dd>
              <p><span class="perimeter_l">潮白新城公交总站</span><span class="perimeter_r">148米</span></p>
              <p class="color8d">河北省廊坊市大厂回</p>
            </dd>
            <dd>
              <p><span class="perimeter_l">潮白家园</span><span class="perimeter_r">148米</span></p>
              <p class="color8d width">潮白河孔雀城-地铁潞</p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd> -->
          </dl>
        </td>
        <td class="301 jt3" id="318" valign="top"></td>
        <td class="401 jt4" id="418" valign="top"></td>
      </tr>
      <tr>
      <!-- 周边学校 -->
        <th>周边学校</th>
        <td class="101 sch1" id="119" valign="top">
          <dl class="perimeter">
           <!--  <dt>幼儿园（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">红黄蓝长阳万科幼</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">北京市第四幼儿园</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">北京九州京缘文艺</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd>
          </dl> 
          <dl class="perimeter">
            <dt>小学（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">北京小学长阳分校</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">西营完全小学</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">张家场小学</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd> -->
          </dl> 
        </td>
        <td class="201 sch2" id="219" valign="top">
          <dl class="perimeter">
           <!--  <dt>幼儿园（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">祁各庄中心幼儿园</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">邵府中心幼儿园</span><span class="perimeter_r">148米</span></p>
            </dd>
          </dl> 
          <dl class="perimeter">
            <dt>小学（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">祁各庄中心小学</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">邵府中心小学</span><span class="perimeter_r">148米</span></p>
            </dd> -->
          </dl> 
        </td>
        <td class="301 sch3" id="319" valign="top"></td>
        <td class="401 sch4" id="419" valign="top"></td>
      </tr>
      <tr>
      <!-- 周边医院 -->
        <th>周边医院</th>
        <td class="101 yiy1" id="120" valign="top">
          <dl class="perimeter">
            <!-- <dt>医院（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">房山区长阳镇卫生</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">长阳镇军留庄社区</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">杨庄子村第二卫生</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd> -->
          </dl> 
        </td>
        <td class="201 yiy2" id="220" valign="top">
           <dl class="perimeter">
            <!-- <dt>医院（10）</dt>
            <dd class="margin_t">
              <p><span class="perimeter_l">祁各庄中心卫生院</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">祁各庄镇洼子村卫</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_l">邵府乡卫生院</span><span class="perimeter_r">148米</span></p>
            </dd>
            <dd>
              <p><span class="perimeter_r"><a>更多...</a></span></p>
            </dd> -->
          </dl> 
        </td>
        <td class="301 yiy3" id="320" valign="top"></td>
        <td class="401 yiy4" id="420" valign="top"></td>
      </tr>
    </table>
  </div>
</div>
<div id="l-map" style="display:none;"></div>
<input type="hidden" id="jing1" value="@if(isset($jingweiArr[0])){{$jingweiArr[0]['longitude']}}@endif">
<input type="hidden" id="wei1" value="@if(isset($jingweiArr[0])){{$jingweiArr[0]['latitude']}}@endif">

<input type="hidden" id="jing2" value="@if(isset($jingweiArr[1])){{$jingweiArr[1]['longitude']}}@endif">
<input type="hidden" id="wei2" value="@if(isset($jingweiArr[1])){{$jingweiArr[1]['latitude']}}@endif">

<input type="hidden" id="jing3" value="@if(isset($jingweiArr[2])){{$jingweiArr[2]['longitude']}}@endif">
<input type="hidden" id="wei3" value="@if(isset($jingweiArr[2])){{$jingweiArr[2]['latitude']}}@endif">

<input type="hidden" id="jing4" value="@if(isset($jingweiArr[3])){{$jingweiArr[3]['longitude']}}@endif">
<input type="hidden" id="wei4" value="@if(isset($jingweiArr[3])){{$jingweiArr[3]['latitude']}}@endif">

<input type="hidden" id="conn" value="{{$conn}}">
<input type="hidden" id="cityId" value="{{CURRENT_CITYID}}">
<script src="/js/list.js?v={{Config::get('app.version')}}"></script>
{{--<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>--}}
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Y1kG709UBP4L0ac6SvTjxnm7"></script>
<script type="text/javascript">

  var jing1 = $('#jing1').val();
  var wei1 = $('#wei1').val();
  var jing2 = $('#jing2').val();
  var wei2 = $('#wei2').val();
  var jing3 = $('#jing3').val();
  var wei3 = $('#wei3').val();
  var jing4 = $('#jing4').val();
  var wei4 = $('#wei4').val();
  var isnew_conn = $('#conn').val();
  var a;
  if(jing1 != '' && wei1 != ''){ 
      var comm_arr1 = $('#check1').attr('value').split('-'); 
      // var comm_id1 = comm_arr1[0];
      // var comm_type1 = comm_arr1[1];
      if(isnew_conn == 1){
         var href1 = '/xinfindex/'+comm_arr1[0]+'/'+comm_arr1[1]+'.html';
      }else{
         var href1 = '/esfindex/'+comm_arr1[0]+'/'+comm_arr1[1]+'.html';
      } 
      chechData('jt1','公交',jing1,wei1,href1);
      chechData('sch1','学校',jing1,wei1,href1);
      chechData('yiy1','医院',jing1,wei1,href1);
      
  }
  if(jing2 != '' && wei2 != ''){ 
      var comm_arr2 = $('#check2').attr('value').split('-'); 
      if(isnew_conn == 1){
         var href2 = '/xinfindex/'+comm_arr2[0]+'/'+comm_arr2[1]+'.html';
      }else{
         var href2 = '/esfindex/'+comm_arr2[0]+'/'+comm_arr2[1]+'.html';
      }   
      chechData('jt2','公交',jing2,wei2,href2);
      chechData('sch2','学校',jing2,wei2,href2);
      chechData('yiy2','医院',jing2,wei2,href2);
  }
  if(jing3 != '' && wei3 != ''){  
      var comm_arr3 = $('#check3').attr('value').split('-'); 
      if(isnew_conn == 1){
         var href3 = '/xinfindex/'+comm_arr3[0]+'/'+comm_arr3[1]+'.html';
      }else{
         var href3 = '/esfindex/'+comm_arr3[0]+'/'+comm_arr3[1]+'.html';
      }  
      chechData('jt3','公交',jing3,wei3,href3);
      chechData('sch3','学校',jing3,wei3,href3);
      chechData('yiy3','医院',jing3,wei3,href3);
  }
  if(jing4 != '' && wei4 != ''){ 
      var comm_arr4 = $('#check4').attr('value').split('-'); 
      if(isnew_conn == 1){
         var href4 = '/xinfindex/'+comm_arr4[0]+'/'+comm_arr4[1]+'.html';
      }else{
         var href4 = '/esfindex/'+comm_arr4[0]+'/'+comm_arr4[1]+'.html';
      }   
      chechData('jt4','公交',jing4,wei4,href4);
      chechData('sch4','学校',jing4,wei4,href4);
      chechData('yiy4','医院',jing4,wei4,href4);
  }
    function chechData(tp,data1,longitude,latitude,href){
        var map = new BMap.Map("l-map");
        map.centerAndZoom(new BMap.Point(longitude, latitude), 11);
        var options = {
            onSearchComplete: function(results){
                // 判断状态是否正确
                if (local.getStatus() == BMAP_STATUS_SUCCESS){
                    var total = results.getNumPois();
                    placeSearch_CallBack(results,tp,href,total);
                }
            }
        };
        var local = new BMap.LocalSearch(map, options);
        var mPoint = new BMap.Point(longitude, latitude);
        local.searchNearby(data1,mPoint,1000);
    } 

     function placeSearch_CallBack(data,tp,href,total) {
        if(tp == 'jt1' || tp == 'jt2' || tp == 'jt3' || tp == 'jt4'){
           var jt1Html = '<dl class="perimeter"><dt>交通（'+total+'）</dt>';
            for(var j1 in data.wr){
              if(j1 == 0){
                 jt1Html += '<dd class="margin_t">';
              }else{
                 jt1Html += '<dd>';
              }              
              jt1Html += '<p><span class="perimeter_l">'+data.wr[j1].title+'</span></p>';
              jt1Html += '<p class="color8d">'+data.wr[j1].address+'</p></dd>';
              jt1Html += '<dd>';           
            } 
             jt1Html += '<p><span class="perimeter_r"><a href="'+href+'">更多...</a></span></p></dd></dl>';
            if(tp == 'jt1'){
               $('#118').html(jt1Html);  
            }else if(tp == 'jt2'){
               $('#218').html(jt1Html); 
            }else if(tp == 'jt3'){
               $('#318').html(jt1Html); 
            }else if(tp == 'jt4'){
               $('#418').html(jt1Html); 
            }
                  
        }
        if(tp == 'sch1' || tp == 'sch2' || tp == 'sch3' || tp == 'sch4'){
            var sch1Html = '<dl class="perimeter"><dt>学校（'+total+'）</dt>';

            for(var s1 in data.wr){
               if(s1 == 0){
                  sch1Html += '<dd class="margin_t">';
               }else{
                  sch1Html += '<dd>';
               }              
               sch1Html += '<p><span class="perimeter_l">'+data.wr[s1].title+'</span></p>';
               sch1Html += '<p class="color8d">'+data.wr[s1].address+'</p>';
               sch1Html += '</dd>';
            }
            sch1Html += '<dd><p><span class="perimeter_r"><a href="'+href+'">更多...</a></span></p></dd></dl>';
            if(tp == 'sch1'){
               $('#119').html(sch1Html);
            }else if(tp == 'sch2'){
               $('#219').html(sch1Html);
            }else if(tp == 'sch3'){
               $('#319').html(sch1Html);
            }else if(tp == 'sch4'){
               $('#419').html(sch1Html);
            }
            
        }
        if(tp == 'yiy1' || tp == 'yiy2' || tp == 'yiy3' || tp == 'yiy4'){
            var yiy1Html = '<dl class="perimeter"><dt>医院（'+total+'）</dt>';
            for(var y1 in data.wr){
                if(y1 == 0){
                  yiy1Html += '<dd class="margin_t">';
                }
                yiy1Html += '<dd>';
                yiy1Html += '<p><span class="perimeter_l">'+data.wr[y1].title+'</span></p>';
                yiy1Html += '<p class="color8d">'+data.wr[y1].address+'</p>';
                yiy1Html += '</dd>';
            }
            yiy1Html += '<dd><p><span class="perimeter_r"><a href="'+href+'">更多...</a></span></p></dd></dl>';
            if(tp == 'yiy1'){
               $('#120').html(yiy1Html);
            }else if(tp == 'yiy2'){
               $('#220').html(yiy1Html);
            }else if(tp == 'yiy3'){
               $('#320').html(yiy1Html);
            }else if(tp == 'yiy4'){
               $('#420').html(yiy1Html);
            }           

        }
     }
</script>

<script>
  $(function(){

    $('#loginform').submit(function(e){
      return false;
    });

    //弹出层调用语句
    $('.modaltrigger').leanModal({
      top:100,
      overlay:0.45
    });
  });
</script>
{{--<script src="/js/sflogger.js?v={{Config::get('app.version')}}"></script>--}}


<script>
$(document).ready(function(e) {
   //优势页面点击子导航
	var subNav_active = $(".contrast_nav a");
	var subNav_scroll = function(target){
		subNav_active.removeClass("click");
		target.addClass("click");
		subNav_active = target;
	};
	$("#contrast_nav a").click(function(){
		subNav_scroll($(this));
		var target = $(this).attr("href");
		var targetScroll = $(target).offset().top - 80;
		$("html,body").animate({scrollTop:targetScroll},300);
		return false;
	});
	//页面跳转时定位
	if(window.location.hash){
		var targetScroll = $(window.location.hash).offset().top - 80;
		$("html,body").animate({scrollTop:targetScroll},300);
	}
	$(window).scroll(function(){
		var $this = $(this);
		var targetTop = $(this).scrollTop();
		var footerTop = $("#footer").offset().top;
		var height = $(window).height();
		
		
		var num1=$("#item1").offset().top;
		var num2=$("#item2").offset().top;
		var num3=$("#item3").offset().top;
		if(isnew_conn == 1){
                    var num4=$("#item4").offset().top;
                }
		
		if (targetTop >= num1 || targetTop == footerTop){
			$("#contrast_nav").addClass("fixedSubNav");
			$(".contrast_nav").css("margin-left",$(".contrast_l").offset().left+"px");
			$(".empty-placeholder").removeClass("hidden");
		}else{
			$("#contrast_nav").removeClass("fixedSubNav");
			$(".contrast_nav").css("margin-left","0px");
			$(".empty-placeholder").addClass("hidden");
		}
		
		if(targetTop < num2){
			subNav_scroll($(".adv_door"));
		}else if(targetTop > num2 && targetTop < num3){
				subNav_scroll($(".adv_img"));
		}else if(targetTop > num3 && targetTop < num4){
				subNav_scroll($(".adv_transfer"));
		}else if(targetTop > num4){
				subNav_scroll($(".adv_price"));
		}
	});
});
</script>
<script>

  //  搜索楼盘  新盘  二手盘
  var isnew = {{$conn}};   // 判断是新盘还是二手盘

  $('.delete1').click(function(){
    $('.101').html('');
  });
  $('.delete2').click(function(){
    $('.201').html('');
  });
  $('.delete3').click(function(){
    $('.301').html('');
  });
  $('.delete4').click(function(){
    $('.401').html('');
  });
  $('.addCommInfo').click(function(){
    var _token = $('input[name="_token"]').val();
    var selectBuild = $('input[name="selectBuild"]').val();
    var type2 = $('input[name="type2"]').val();
    var type1 = $('input[name="type1"]').val();
    //var cityId = $('#cityId').val();
    var cityId = cityId_true;
    if(selectBuild == ''){
      alert('请输入关键字(楼盘名称)');
      return false;
    }
    if(selectBuild && type2){
            var html101 = $.trim($('#101').html());
            var html201 = $.trim($('#201').html());
            var html301 = $.trim($('#301').html());
            var html401 = $.trim($('#401').html());
            var flag;
            if(html101 == ''){
                flag = true;
                var num = '1';
            }else if(html201 == ''){
                flag = true;
                var num = '2';
            }else if(html301 == ''){
                flag = true;
                var num = '3';
            }else if(html401 == ''){
                flag = true;
                var num = '4';
            }else{
              flag = false;
//              alert('楼盘对比上限为4个');
//              return false;
            }
            if(flag == true){
            $.ajax({
              type : 'post',
              url  : '/buildContrast',
              data : {
                _token:_token,
                selectBuild:selectBuild,
                type2:type2,
                conn : isnew,
                type1 : type1,
                cityId : cityId
              },
              success : function(result){
                if(result == ''){
                  alert('未找到您查询的楼盘名称.');
                }else{
      //            var html101 = $.trim($('#101').html());
      //            var html201 = $.trim($('#201').html());
      //            var html301 = $.trim($('#301').html());
      //            var html401 = $.trim($('#401').html());
      //            if(html101 == ''){
      //              var num = '1';
      //            }else if(html201 == ''){
      //              var num = '2';
      //            }else if(html301 == ''){
      //              var num = '3';
      //            }else if(html401 == ''){
      //              var num = '4';
      //            }else{
      //              alert('楼盘对比上限为4个');
      //              return false;
      //            }
                  var buildId = buildId = result[0]['id'];
                  var id1 = $('#check1').attr('value2');
                  var id2 = $('#check2').attr('value2');
                  var id3 = $('#check3').attr('value2');
                  var id4 = $('#check4').attr('value2');
                  var idArr = [];
                  if(id1 != undefined){
                    idArr.push(id1);
                  }
                  if(id2 != undefined){
                    idArr.push(id2);
                  }
                  if(id3 != undefined){
                    idArr.push(id3);
                  }
                  if(id4 != undefined){
                    idArr.push(id4);
                  }
                  if(in_array(buildId , idArr) == true){
                    alert('该楼盘已在对比列表中');
                    return false;
                  }
                    var titlePic = result.commTitlePic;
                    var buildName = result[0]['name'];
                    var avgPrice = result['getTime'].saleAvgPrice;
                    //var cheap = '5折优惠!';
                    var cheap = result['getTime'].specialOffers;
                    var zhekou = result['getTime'].zhekou;
                    console.log(cheap);
                    console.log(result);
                    var cheap = cheap + '<br>' + zhekou;
                    var address = result[0]['address'];
                    //var diyTagIds = (result.type2GetInfo['diyTagIds']).split('|');
                    var diyTagIds = result['tagName'];
                    if(result['type2GetInfo'] != ''){
                        var type2GetInfo = eval(result['type2GetInfo']);
                        var propertyYear = type2GetInfo.propertyYear;
                        var greenRate = type2GetInfo.greenRate;
                        var volume = type2GetInfo.volume;
                        if(type1 == 3){
                          var houseTotal = type2GetInfo.houseTotal;
                        }else{
                            var houseTotal = 0;
                        }
                        var propertyFee = type2GetInfo.propertyFee;
                    }else{
                        var propertyFee = 0;
                        var propertyYear = 0;
                        var greenRate = 0;
                        var volume = 0;
                        var houseTotal = 0;
                    }             
                    //var propertyYear = result.type2GetInfo['propertyYear'];             
                    var openTime = result['getTime'].openTime;
                    var takeTime = result['getTime'].takeTime;
                    var developerName = result['developerName'];
                    var structure = result['structure'];
                    var decoration = result['decoration'];             
                    var room = result['communityroom'];
                    var jingdu = result[0].longitude;  // 经度
                    var weidu = result[0].latitude;  // 纬度
                    var id = result[0].id;  //  楼盘id
      //            }else{
      //              alert('该楼盘信息不完整,无法做对比!');
      //              return false;
      //            }

                  insertData(isnew,type1,type2,id,jingdu,weidu,num,titlePic,buildName,buildId,avgPrice,cheap,address,diyTagIds,propertyYear,openTime,takeTime,developerName,structure,decoration,volume,greenRate,houseTotal,propertyFee,room);
                }

              }
            });
      }else{
          alert('楼盘对比上限为4个');
          return false;
      }
    }
  });
  function insertData(isnew,type1,type2,id,jingdu,weidu,num,titlePic,buildName,buildId,avgPrice,cheap,address,diyTagIds,propertyYear,openTime,takeTime,developerName,structure,decoration,volume,greenRate,houseTotal,propertyFee,room){

    //var num = num;
    var num;
    var loupanmingcheng = '<a><dl class="build_name"><dt><img src="'+titlePic+'" width="160" height="100"></dt><dd><span id="check'+num+'" value="'+buildId+'">'+buildName+'</span><i class="delete'+num+'"></i></dd></dl></a>';
    var pingfen = '<a class="icon"><img alt="'+buildName+'" src="image/red.png"><img src="image/red.png"><img src="image/red.png"><img src="image/redgray.png"><img src="image/gray.png"><span class="colorfe"><span class="font_size">4</span>.06分</span><br/>共有62人参与</a>';
    //var junjia = '均价<span class="colorfe font_size1">'+avgPrice+'</span>元/平方米';
    var junjia = avgPrice == '' ? '' : '均价<span class="colorfe font_size1">'+avgPrice+'</span>元/平方米';
    var youhui = cheap;
    var xiangmuweizhi = '<div class="address"><i class="map_icon"></i><span><a>'+address+'</a></span></div>';
    var xiangmutese = '<div class="item">';
    if(diyTagIds.length > 0){
        xiangmutese = '<div class="item">';
        for(d in diyTagIds ){
          xiangmutese += '<a href="#">'+diyTagIds[d]+'</a>';
        }
    }
    xiangmutese += '</div>';
    var chanquannianxian = (propertyYear > 0) ? propertyYear+'年' : '';
    var kaipanshijian = openTime;
    var ruzhushijian = takeTime;
    var kaifashang = developerName;
    //var structureCN = {'1':'板楼','2':'塔楼','3':'砖楼','4':'砖混','5':'平房','6':'钢混','7':'塔板结合','8':'框架剪力墙','9':'其他','0':''};
    var jianzhuleixing = structure;
    //var decorationCN = {'1':'毛坯','2':'简装修','3':'中装修','4':'精装修','5':'豪华装修'};
    var zhuangxiuzhuangkuang = decoration;
    var rongjilv = (volume > 0) ? volume+'%' : '';
    var lvhualv = (greenRate > 0) ? greenRate+'%' : '';
    var hushu = (houseTotal > 0) ? houseTotal+'户' : '';
    var wuyefei = (propertyFee > 0) ? propertyFee+'元/平方米·月' : '';
    var huxing = '<ul class="leyout">';
    for(r in room){
      huxing += '<li><a href="#"><span class="leyout_l">'+room[r][0]+'</span><span class="leyout_r">'+room[r][1]+'平米</span></a></li>';
    }
    huxing += '</ul>';
//    var jiaotongzhuangkuang = '<dl class="perimeter"><dt>地铁（10）</dt><dd class="margin_t"><p><span class="perimeter_l">长阳</span><span class="perimeter_r">148米</span></p><p class="color8d">房山线</p></dd><dd><p><span class="perimeter_l">长阳</span><span class="perimeter_r">148米</span></p><p class="color8d">房山线</p></dd><dd><p><span class="perimeter_l">长阳</span><span class="perimeter_r">148米</span></p><p class="color8d">房山线</p></dd><dd><p><span class="perimeter_r"><a>更多...</a></span></p></dd></dl> <dl class="perimeter"><dt>公交（10）</dt><dd class="margin_t"><p><span class="perimeter_l">地铁长阳站</span><span class="perimeter_r">148米</span></p><p class="color8d">646路;832路;907路</p></dd><dd><p><span class="perimeter_l">长政南街</span><span class="perimeter_r">148米</span></p><p class="color8d">专93路</p></dd><dd><p><span class="perimeter_l">长阳镇政府</span><span class="perimeter_r">148米</span></p><p class="color8d width">房38路;房3路内环</p></dd><dd><p><span class="perimeter_r"><a>更多...</a></span></p></dd></dl>';
//    var zhoubianxuexiao = '<dl class="perimeter"><dt>幼儿园（10）</dt><dd class="margin_t"><p><span class="perimeter_l">红黄蓝长阳万科幼</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_l">北京市第四幼儿园</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_l">北京九州京缘文艺</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_r"><a>更多...</a></span></p></dd></dl> <dl class="perimeter"><dt>小学（10）</dt><dd class="margin_t"><p><span class="perimeter_l">北京小学长阳分校</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_l">西营完全小学</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_l">张家场小学</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_r"><a>更多...</a></span></p></dd></dl> ';
//    var zhoubianyiyuan = '<dl class="perimeter"><dt>医院（10）</dt><dd class="margin_t"><p><span class="perimeter_l">房山区长阳镇卫生</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_l">长阳镇军留庄社区</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_l">杨庄子村第二卫生</span><span class="perimeter_r">148米</span></p></dd><dd><p><span class="perimeter_r"><a>更多...</a></span></p></dd></dl>';

    $('#'+num+'01').html(loupanmingcheng);
    $('#'+num+'02').html(pingfen);
    if(isnew == 1){
        var href_comm = '/xinfindex/'+id+'/'+type2+'.html';
        $('#'+num+'03').html(junjia);
        $('#'+num+'04').html(youhui);
        $('#'+num+'08').html(kaipanshijian);
        $('#'+num+'09').html(ruzhushijian);
    }else{
        var href_comm = '/esfindex/'+id+'/'+type2+'.html';
    }
    $('#'+num+'05').html(xiangmuweizhi);
    $('#'+num+'06').html(xiangmutese);
    $('#'+num+'07').html(chanquannianxian);
//    $('#'+num+'08').html(kaipanshijian);
//    $('#'+num+'09').html(ruzhushijian);
    $('#'+num+'10').html(kaifashang);
    $('#'+num+'11').html(jianzhuleixing);
    $('#'+num+'12').html(zhuangxiuzhuangkuang);
    $('#'+num+'13').html(rongjilv);
    $('#'+num+'14').html(lvhualv);
    if(type1 == 3){
        $('#'+num+'15').html(hushu);
    }
    $('#'+num+'16').html(wuyefei);
    $('#'+num+'17').html(huxing);
    var zhoubianjiao = '';
    var zhoubianschool = '';
    var zhoubianyi = '';
    chechData1('jt','公交',jingdu,weidu,zhoubianjiao,num,href_comm);
    chechData1('sch','学校',jingdu,weidu,zhoubianschool,num,href_comm);
    chechData1('yiy','医院',jingdu,weidu,zhoubianyi,num,href_comm);
//    $('#'+num+'18').html(jiaotongzhuangkuang);
//    $('#'+num+'19').html(zhoubianxuexiao);
//    $('#'+num+'20').html(zhoubianyiyuan);
    if(num == '1'){
      $('.delete1').click(del1);
    }else if(num == '2'){
      $('.delete2').click(del2);
    }else if(num == '3'){
      $('.delete3').click(del3);
    }else if(num == '4'){
      $('.delete4').click(del4);
    }
    
  }
  
  function chechData1(tp,data1,jingdu,weidu,zhoubian,number,href_comm){

      var map = new BMap.Map("l-map");
      map.centerAndZoom(new BMap.Point(jingdu, weidu), 11);
      var options = {
          onSearchComplete: function(results){
              // 判断状态是否正确
              if (local.getStatus() == BMAP_STATUS_SUCCESS){
                  var total = results.getNumPois();
                  if(tp == 'jt'){
                      zhoubian += '<dl class="perimeter"><dt>交通（'+total+'）</dt>';
                  }else if(tp == 'sch'){
                      zhoubian += '<dl class="perimeter"><dt>学校（'+total+'）</dt>';
                  }else if(tp == 'yiy'){
                      zhoubian += '<dl class="perimeter"><dt>医院（'+total+'）</dt>';
                  }
                  for(var i in results.wr){
                      if(i == 0){
                          zhoubian += '<dd class="margin_t">';
                      }else{
                          zhoubian += '<dd>';
                      }
                      zhoubian += '<p><span class="perimeter_l">'+results.wr[i].title+'</span></p>';
//                      if(tp == 'jt'){
                          zhoubian += '<p class="color8d">'+results.wr[i].address+'</p></dd>';
                     // }
                      zhoubian += '</dd>';
                  }
                  zhoubian += '<dd><p><span class="perimeter_r"><a href="'+href_comm+'">更多...</a></span></p></dd></dl>';
                  if(tp == 'jt'){
                      $('#'+number+'18').html(zhoubian);
                  }else if(tp == 'sch'){
                      $('#'+number+'19').html(zhoubian);
                  }else if(tp == 'yiy'){
                      $('#'+number+'20').html(zhoubian);
                  }
              }
          }
      };
      var local = new BMap.LocalSearch(map, options);
      var mPoint = new BMap.Point(jingdu, weidu);
      local.searchNearby(data1,mPoint,1000);
    }
  
  
  
  function del1(){
    $('.101').html('');
  }
  function del2(){
    $('.201').html('');
  }
  function del3(){
    $('.301').html('');
  }
  function del4(){
    $('.401').html('');
  }

  $('#addCommInfo').on('keyup', getRecommend);

  function getRecommend(){
    var type1 = $('input[name="type1"]').val();
    var type2 = $('input[name="type2"]').val();
    var cityId = $('#cityId').val();
    var val = $.trim($(this).val());
    if(val == ''){
      $(this).next('.mai').html('');
      return false;
    }   
    var obj  = $(this);
    var tp = 'loupan';
    var token = $('input[name="_token"]').val();
    var url = '/home_search';
    $.ajax({
      type:'post',
      url:url,
      data:{
        _token:token,
        keywords:val,
        tp:tp,
        isnew : isnew,
        type1 : type1,
        type2 : type2,
        cityId : cityId
      },
      success:function(data){
        // console.log(data);return false;
        dataList += '</ul>';
        if(data == 0) return false;
        var dataList = '<ul>';
        for( var i in data){
          var comName  = data[i]._source.name ? data[i]._source.name : data[i]._source.communityName;
          dataList += '<li><a class="selectSearch" value="'+ data[i]._source.id +'">'+ comName +'</a><input type="hidden" value="'+data[i]._source.cityId+'" /></li>';
        }
        obj.next('.pop').show();
        obj.next('.pop').html(dataList);
        $('.selectSearch').click(selectSearch);
      }
    });
  }
  var cityId_true;
  function selectSearch(){
    var val = $(this).text();
    cityId_true = $(this).next().val();
    $('#addCommInfo').val(val);
    $(this).parents('.pop').hide();
  }

  /**
  * js 实现in_array功能
  */
  function in_array(search,array){
      for(var i in array){
          if(array[i]==search){
              return true;
          }
      }
      return false;
  }
</script>
@endsection
