@extends('mainlayout')
@section('title')
    <title>搜房网-【房源对比】</title>
    <meta name="keywords" content="北京搜房网，新房，二手房，租房，写字楼，商铺，金融，房产名人，房产名企，房产名词"/>
    <meta name="description" content="搜房网—中国房地产综合信息门户和交易平台。为客户提供房产百科全书，包括房产名人，名词，名企，楼盘"/>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/house_loan.css?v={{Config::get('app.version')}}">
<div class="header" style="background-color: #dceaf9;">
 <div class="catalog_nav" id="catalog_nav">
  <div class="list_sub" style="margin-left:0;">
     <div class="list_search">
        <input type="text" class="txt border_blue" placeholder="请输入关键字（楼盘名/地名/开发商等）" id="keyword">
        <input type="text" class="btn back_color keybtn" value="搜房">
      </div>
  </div>
 </div>
</div>
<form id="build" method="post" >
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <input type="hidden" id="linkurl"  value="{{$souUrl}}" >
    <input type="hidden" id="par"  value="" >
</form>
<p class="route">
  <span>您的位置：</span>
  <a href="/">首页</a>
  <span>&nbsp;>&nbsp;</span>       
        <a href="{{$souUrl}}" class="colorfe">{{$city}}二手房</a>
  <span>&nbsp;>&nbsp;</span>
  <span>房源对比</span>
</p>
<div class="contrast">
  <div class="contrast_l">
    <div class="empty-placeholder hidden"></div>
    <div class="contrast_nav"  id="contrast_nav">
      <a class="adv_door click" href="#item1">价格对比</a>
      @if($uri == 'sale')
      <span>总价</span>
      <span>单价</span>
      <span>参考首付</span>
      {{--<span>参考月供</span>--}}
      @endif
      @if($uri == 'rent')
      <span>租金(按月)</span>
      <span>租金(按天)</span>
      <span>租金(按季度)</span>
      <span>租金(按年)</span>
      @endif
      <a class="adv_img" href="#item2">基本信息</a>
      <span>所在地址</span>
      <span>房源特色</span>
      @if($uri == 'sale')
            @if($houseDatas[0]->houseType1 == 3)
                <span>建筑形式</span>
                <span>产权性质</span>
                <span>建筑年代</span>
            @endif
            @if($houseDatas[0]->houseType1 == 2)
                <span>物业费</span>
                <span>分割状态</span>
                <span>写字楼级别</span>
            @endif
            @if($houseDatas[0]->houseType1 == 1)
                <span>商铺状态</span>
                <span>物业费</span>
                <span>分割状态</span>
                <span>目标业务</span>
            @endif
      @endif
      @if($uri == 'rent')
            @if($houseDatas[0]->houseType1 == 3)
                <span>租赁方式</span>
            @endif
            @if($houseDatas[0]->houseType1 == 2)               
                <span>分割状态</span>
                <span>物业费</span>
                <span>是否包含物业</span>
                <span>写字楼级别</span>
            @endif
            @if($houseDatas[0]->houseType1 == 1)               
                <span>分割状态</span>
                <span>物业费</span>
                <span>是否包含物业</span>
                <span>是否转让</span>
                <span>商铺状态</span>
            @endif
      @endif      
      @if($houseDatas[0]->houseType1 == 3)
      <span>户型</span>
      <span>朝向</span>
      @endif
      <span>面积</span>
      <span>楼层</span>
      {{--<span>楼栋</span>--}}
      <span>物业类型</span>
      <span>装修状况</span>
      @if($houseDatas[0]->houseType1 == 1 || $houseDatas[0]->houseType1 == 3)
      <span>配套设施</span>
      @endif
      <a class="adv_transfer" href="#item3">户型对比</a>
      <span>户型</span>
      <!-- <a class="adv_price" href="#item4">周边配套</a>
      @if($houseDatas[0]->communityId != 0)
      <span>交通状况</span>
      <span>周边学校</span>
      <span>周边医院</span>
      @else
      <span>交通状况</span>
      @endif -->
    </div>
  </div>
  <div class="contrast_r">
    <p class="contrast_subnav">
      <a href="houseContrast.htm" class="click">基本信息对比</a>
<!--      <a href="imageContrast.htm">图片对比</a>-->
    </p>

    <table id="contrast">
<!--      <tr>
        <th>房源对比</th>
        <td colspan="4">
          <input type="text" class="txt">
          <input type="button" class="btn back_color" value="+对比">
        </td>
      </tr>-->
      <tr>
        <th width="180">图片及对应房源</th>
        <td width="225">
          <a><dl class="build_name">
            <dt><img src="{{$houseDatas[0]->thumbPic}}" width="160" height="100" alt="" onerror="errorImage(this)"></dt>
            <dd class="resize_w" title="{{$houseDatas[0]->title}}"><span>{{$houseDatas[0]->title1}}</span></dd>
          </dl></a>
        </td>
        <td width="225">
           @if(isset($houseDatas[1]))
          <a>
            <dl class="build_name">
            <dt><img src="{{$houseDatas[1]->thumbPic}}" width="160" height="100" alt="" onerror="errorImage(this)"></dt>
            <dd class="resize_w title="{{$houseDatas[1]->title}}"><span>{{$houseDatas[1]->title1}}</span></dd>
          </dl></a>
           @endif
        </td>
        <td width="225">
            @if(isset($houseDatas[2]))
            <a><dl class="build_name">
            <dt><img src="{{$houseDatas[2]->thumbPic}}" width="160" height="100" alt="" onerror="errorImage(this)"></dt>
            <dd class="resize_w title="{{$houseDatas[2]->title}}"><span>{{$houseDatas[2]->title1}}</span></dd>
            </dl>
            </a>
            @endif
        </td>
        <td width="225">
            @if(isset($houseDatas[3]))
            <a><dl class="build_name">
            <dt><img src="{{$houseDatas[3]->thumbPic}}" width="160" height="100" alt="" onerror="errorImage(this)"></dt>
            <dd class="resize_w title="{{$houseDatas[3]->title}}"><span>{{$houseDatas[3]->title1}}</span></dd>
            </dl>
            </a>
            @endif
        </td>
      </tr>
<!--      <tr>
        <th>用户评分</th>
        <td>
          <a class="icon">
           <img src="image/red.png"><img src="image/red.png"><img src="image/red.png"><img src="image/redgray.png"><img src="image/gray.png"><span class="colorfe"><span class="font_size">4</span>.06分</span><br/>
           共有62人参与
          </a>
        </td>
        <td>
          <a class="icon">
           <img src="image/red.png"><img src="image/red.png"><img src="image/red.png"><img src="image/redgray.png"><img src="image/gray.png"><span class="colorfe"><span class="font_size">4</span>.14分</span><br/>
           共有62人参与
          </a>
        </td>
        <td></td>
        <td></td>
      </tr>-->
      <tr>
        <th colspan="5"><p class="price" id="item1"><span class="border back_color"></span><span class="new_price">最新价格</span></p></th>
      </tr>

      @if($uri == 'sale')
      <tr height="40">
        <th>总价</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->price2}}</span>万元</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->price2}}</span> 万元@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->price2}}</span>万元
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->price2}}</span>万元
            @endif
        </td>
      </tr>
      <tr height="50">
        <th>单价</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->price1}}</span>元/平米</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->price1}}</span>元/平米@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->price1}}</span>元/平米
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->price1}}</span>元/平米
            @endif
        </td>
      </tr>
      <tr height="50">
        <th>首付</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->firstPay}}</span>万</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->firstPay}}</span>万@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->firstPay}}</span>万
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->firstPay}}</span>万
            @endif
        </td>
      </tr>
      {{--<tr height="50">--}}
        {{--<th>月供</th>--}}
        {{--<td>@if(isset($houseDatas[0]) && !empty($houseDatas[0]->monthPay))<span class="colorfe font_size1">{{$houseDatas[0]->monthPay}}</span>元@endif</td>--}}
        {{--<td>@if(isset($houseDatas[1]) && !empty($houseDatas[1]->monthPay))<span class="colorfe font_size1">{{$houseDatas[1]->monthPay}}</span>元@endif</td>--}}
        {{--<td>--}}
            {{--@if(isset($houseDatas[2]) && !empty($houseDatas[2]->monthPay))--}}
            {{--<span class="colorfe font_size1">{{$houseDatas[2]->monthPay}}</span>元--}}
            {{--@endif--}}
        {{--</td>--}}
        {{--<td>--}}
            {{--@if(isset($houseDatas[3]) && !empty($houseDatas[3]->monthPay))--}}
            {{--<span class="colorfe font_size1">{{$houseDatas[3]->monthPay}}</span>元--}}
            {{--@endif--}}
        {{--</td>--}}
      {{--</tr>--}}
      @endif
      @if($uri == 'rent')
      <tr height="40">
        <th>租金(按月)</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->price1}}</span>元/月</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->price1}}</span> 元/月@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->price1}}</span>元/月
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->price1}}</span>元/月
            @endif
        </td>
      </tr>
      <tr height="50">
        <th>租金(按天)</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->price2}}</span>元/天/平米</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->price2}}</span>元/天/平米@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->price2}}</span>元/天/平米
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->price2}}</span>元/天/平米
            @endif
        </td>
      </tr>
      <tr height="50">
        <th>租金(按季度)</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->price4}}</span>元/季/平米</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->price4}}</span>元/季/平米@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->price4}}</span>元/季/平米
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->price4}}</span>元/季/平米
            @endif
        </td>
      </tr>
      <tr height="50">
        <th>租金(按年)</th>
        <td><span class="colorfe font_size1">{{$houseDatas[0]->price5}}</span>元/年/平米</td>
        <td>@if(isset($houseDatas[1]))<span class="colorfe font_size1">{{$houseDatas[1]->price5}}</span>元/年/平米@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <span class="colorfe font_size1">{{$houseDatas[2]->price5}}</span>元/年/平米
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <span class="colorfe font_size1">{{$houseDatas[3]->price5}}</span>元/年/平米
            @endif
        </td>
      </tr>
      @endif
      <tr>
        <th colspan="5"><p class="price" id="item2"><span class="border back_color"></span><span class="new_price">基本信息</span></p></th>
      </tr>
      <tr>
        <th>所在地址</th>
        <td><div class="address"><i class="map_icon"></i><span><a>{{$houseDatas[0]->address}}</a></span></div></td>
        <td>@if(isset($houseDatas[1]))<div class="address"><i class="map_icon"></i><span><a>{{$houseDatas[1]->address}}</a></span></div>@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            <div class="address"><i class="map_icon"></i><span><a>{{$houseDatas[2]->address}}</a></span></div>
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <div class="address"><i class="map_icon"></i><span><a>{{$houseDatas[3]->address}}</a></span></div>
            @endif
        </td>
      </tr>
      <tr height='50px'>       
        <th>房源特色</th>
        @if(!empty($houseDatas[0]->tag))
        <td>
            <div class="item">
              @if(isset($houseDatas[0]->tag[0]->name))<a href="#">{{$houseDatas[0]->tag[0]->name}}</a> @endif 
              @if(isset($houseDatas[0]->tag[1]->name))<a href="#">{{$houseDatas[0]->tag[1]->name}}</a> @endif 
              @if(isset($houseDatas[0]->tag[2]->name))<a href="#">{{$houseDatas[0]->tag[2]->name}}</a> @endif 
            </div>
        </td>
        @endif
        <td>
            @if(isset($houseDatas[1]))
                @if(!empty($houseDatas[1]->tag))
                    <div class="item">
                        @if(isset($houseDatas[1]->tag[0]->name))<a href="#">{{$houseDatas[1]->tag[0]->name}}</a> @endif 
                        @if(isset($houseDatas[1]->tag[1]->name))<a href="#">{{$houseDatas[1]->tag[1]->name}}</a> @endif 
                        @if(isset($houseDatas[1]->tag[2]->name))<a href="#">{{$houseDatas[1]->tag[2]->name}}</a> @endif 
                    </div>
                @endif
            @endif           
        </td>
        <td>
            @if(isset($houseDatas[2]))
                @if(!empty($houseDatas[2]->tag))
                    <div class="item">
                      @if(isset($houseDatas[2]->tag[0]->name))<a href="#">{{$houseDatas[2]->tag[0]->name}}</a> @endif 
                      @if(isset($houseDatas[2]->tag[1]->name))<a href="#">{{$houseDatas[2]->tag[1]->name}}</a> @endif 
                      @if(isset($houseDatas[2]->tag[2]->name))<a href="#">{{$houseDatas[2]->tag[2]->name}}</a> @endif 
                    </div>
                @endif
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
                @if(!empty($houseDatas[3]->tag))
                    <div class="item">
                      @if(isset($houseDatas[3]->tag[0]->name))<a href="#">{{$houseDatas[3]->tag[0]->name}}</a> @endif
                      @if(isset($houseDatas[3]->tag[1]->name))<a href="#">{{$houseDatas[3]->tag[1]->name}}</a> @endif
                      @if(isset($houseDatas[3]->tag[2]->name))<a href="#">{{$houseDatas[3]->tag[2]->name}}</a> @endif
                    </div>
                @endif
            @endif
        </td>
      </tr>
     
        @if($uri == 'sale')
         @if($houseDatas[0]->houseType1 == 3)
            <tr height="50">        
                <th>建筑形式</th>
                <td>@if(isset($houseDatas[0]) && isset($houseDatas[0]->buildingType)){{$houseDatas[0]->buildingType}}@endif</td>
                <td>@if(isset($houseDatas[1]) && isset($houseDatas[1]->buildingType)){{$houseDatas[1]->buildingType}}@endif</td>
                <td>
                    @if(isset($houseDatas[2]) && isset($houseDatas[2]->buildingType))
                    {{$houseDatas[2]->buildingType}}
                    @endif
                </td>
                <td>
                    @if(isset($houseDatas[3]) && isset($houseDatas[3]->buildingType))
                    {{$houseDatas[3]->buildingType}}
                    @endif
                </td>       
            </tr>
            <tr height="50">        
            <th>产权性质</th>
            <td>@if(isset($houseDatas[0]) && isset($houseDatas[0]->ownership)){{$houseDatas[0]->ownership}}@endif</td>
            <td>@if(isset($houseDatas[1]) && isset($houseDatas[1]->ownership)){{$houseDatas[1]->ownership}}@endif</td>
            <td>
                @if(isset($houseDatas[2]) && isset($houseDatas[2]->ownership))
                {{$houseDatas[2]->ownership}}
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]) && isset($houseDatas[3]->ownership))
                {{$houseDatas[3]->ownership}}
                @endif
            </td>       
          </tr>
          <tr height="50">        
            <th>建筑年代</th>
            <td>@if(isset($houseDatas[0]) && !empty($houseDatas[0]->buildYear)){{$houseDatas[0]->buildYear}}@endif</td>
            <td>@if(isset($houseDatas[1]) && !empty($houseDatas[1]->buildYear)){{$houseDatas[1]->buildYear}}@endif</td>
            <td>
                @if(isset($houseDatas[2]) && !empty($houseDatas[2]->buildYear))
                {{$houseDatas[2]->buildYear}}
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]) && !empty($houseDatas[3]->buildYear))
                {{$houseDatas[3]->buildYear}}
                @endif
            </td>       
          </tr>
        @endif
         @if($houseDatas[0]->houseType1 == 2)
            <tr height="50">        
                <th>物业费</th>
                <td>{{$houseDatas[0]->propertyFee}}元/平米·月</td>
                <td>@if(isset($houseDatas[1])){{$houseDatas[1]->propertyFee}}元/平米·月@endif</td>
                <td>
                    @if(isset($houseDatas[2]))
                    {{$houseDatas[2]->propertyFee}}元/平米·月
                    @endif
                </td>
                <td>
                    @if(isset($houseDatas[3]))
                    {{$houseDatas[3]->propertyFee}}元/平米·月
                    @endif
                </td>       
           </tr>
           <tr height="50">        
            <th>分割状态</th>
            <td>@if($houseDatas[0]->isDivisibility == 0)可分割@elseif($houseDatas[0]->isDivisibility == 1)不可分割@endif</td>
            <td>@if(isset($houseDatas[1]))
                @if($houseDatas[1]->isDivisibility == 0)可分割@elseif($houseDatas[1]->isDivisibility == 1)不可分割@endif
                @endif
            </td>
            <td>
                @if(isset($houseDatas[2]))
                @if($houseDatas[2]->isDivisibility == 0)可分割@elseif($houseDatas[2]->isDivisibility == 1)不可分割@endif
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]))
                @if($houseDatas[3]->isDivisibility == 0)可分割@elseif($houseDatas[3]->isDivisibility == 1)不可分割@endif
                @endif
            </td>       
          </tr>
          <tr height="50">        
            <th>写字楼级别</th>
            <td>{{$houseDatas[0]->officeLevel}}</td>
            <td>@if(isset($houseDatas[1])){{$houseDatas[1]->officeLevel}}@endif</td>
            <td>
                @if(isset($houseDatas[2]))
                {{$houseDatas[2]->officeLevel}}
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]))
                {{$houseDatas[3]->officeLevel}}
                @endif
            </td>       
          </tr>
           
        @endif
        
         @if($houseDatas[0]->houseType1 == 1)
        <tr height="50">        
            <th>商铺状态</th>
            <td>{{$houseDatas[0]->stateShop}}</td>
            <td>@if(isset($houseDatas[1])){{$houseDatas[1]->stateShop}}@endif</td>
            <td>
                @if(isset($houseDatas[2]))
                {{$houseDatas[2]->stateShop}}
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]))
                {{$houseDatas[3]->stateShop}}
                @endif
            </td>       
          </tr>
          <tr height="50">        
            <th>物业费</th>
            <td>{{$houseDatas[0]->propertyFee}}元/平米·月</td>
            <td>@if(isset($houseDatas[1])){{$houseDatas[1]->propertyFee}}元/平米·月@endif</td>
            <td>
                @if(isset($houseDatas[2]))
                {{$houseDatas[2]->propertyFee}}元/平米·月
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]))
                {{$houseDatas[3]->propertyFee}}元/平米·月
                @endif
            </td>       
          </tr>
          <tr height="50">        
            <th>分割状态</th>
            <td>@if($houseDatas[0]->isDivisibility == 0)可分割@elseif($houseDatas[0]->isDivisibility == 1)不可分割@endif</td>
            <td>@if(isset($houseDatas[1]))
                @if($houseDatas[1]->isDivisibility == 0)可分割@elseif($houseDatas[1]->isDivisibility == 1)不可分割@endif
                @endif
            </td>
            <td>
                @if(isset($houseDatas[2]))
                @if($houseDatas[2]->isDivisibility == 0)可分割@elseif($houseDatas[2]->isDivisibility == 1)不可分割@endif
                @endif
            </td>
            <td>
                @if(isset($houseDatas[3]))
                @if($houseDatas[3]->isDivisibility == 0)可分割@elseif($houseDatas[3]->isDivisibility == 1)不可分割@endif
                @endif
            </td>       
          </tr>
          <tr height="80">
            <th>目标业务</th>
            <td>{{$houseDatas[0]->trade}}</td>
            <td>@if(isset($houseDatas[1])){{$houseDatas[1]->trade}}@endif</td>
            <td>@if(isset($houseDatas[2])) {{$houseDatas[2]->trade}} @endif</td>
            <td>@if(isset($houseDatas[3])) {{$houseDatas[3]->trade}} @endif</td>
          </tr>
        @endif
        
       @endif
        @if($uri == 'rent')
            <tr height="50">        
                    <th>支付方式</th>
                    <td>{{$houseDatas[0]->paymentType}}</td>
                    <td>@if(isset($houseDatas[1])){{$houseDatas[1]->paymentType}}@endif</td>
                    <td>
                        @if(isset($houseDatas[2]))
                        {{$houseDatas[2]->paymentType}}
                        @endif
                    </td>
                    <td>
                        @if(isset($houseDatas[3]))
                        {{$houseDatas[3]->paymentType}}
                        @endif
                    </td>       
             </tr>
              @if($houseDatas[0]->houseType1 == 3)
                <tr height="50">        
                    <th>租赁方式</th>
                    <td>{{$houseDatas[0]->rentType}}</td>
                    <td>@if(isset($houseDatas[1])){{$houseDatas[1]->rentType}}@endif</td>
                    <td>
                        @if(isset($houseDatas[2]))
                        {{$houseDatas[2]->rentType}}
                        @endif
                    </td>
                    <td>
                        @if(isset($houseDatas[3]))
                        {{$houseDatas[3]->rentType}}
                        @endif
                    </td>       
              </tr>             
            @endif
            
            @if($houseDatas[0]->houseType1 == 2 || $houseDatas[0]->houseType1 == 1)
                <tr height="50">        
                    <th>分割状态</th>
                    <td>@if($houseDatas[0]->isDivisibility == 0)可分割@elseif($houseDatas[0]->isDivisibility == 1)不可分割@endif</td>
                    <td>@if(isset($houseDatas[1]))
                        @if($houseDatas[1]->isDivisibility == 0)可分割@elseif($houseDatas[1]->isDivisibility == 1)不可分割@endif
                        @endif
                    </td>
                    <td>
                        @if(isset($houseDatas[2]))
                        @if($houseDatas[2]->isDivisibility == 0)可分割@elseif($houseDatas[2]->isDivisibility == 1)不可分割@endif
                        @endif
                    </td>
                    <td>
                        @if(isset($houseDatas[3]))
                        @if($houseDatas[3]->isDivisibility == 0)可分割@elseif($houseDatas[3]->isDivisibility == 1)不可分割@endif
                        @endif
                    </td>       
                  </tr>
                  <tr height="50">        
                        <th>物业费</th>
                        <td>{{$houseDatas[0]->propertyFee}}元/平米·月</td>
                        <td>@if(isset($houseDatas[1])){{$houseDatas[1]->propertyFee}}元/平米·月@endif</td>
                        <td>
                            @if(isset($houseDatas[2]))
                            {{$houseDatas[2]->propertyFee}}元/平米·月
                            @endif
                        </td>
                        <td>
                            @if(isset($houseDatas[3]))
                            {{$houseDatas[3]->propertyFee}}元/平米·月
                            @endif
                        </td>       
                   </tr>
                   {{--<tr height="50">        --}}
                        {{--<th>是否包含物业费</th>--}}
                        {{--<td>--}}
                            {{--@if(isset($houseDatas[0]) && isset($houseDatas[0]->isContainPropertyCost))--}}
                            {{--@if($houseDatas[0]->isContainPropertyCost == 0)不包含@endif @if($houseDatas[0]->isContainPropertyCost == 1)包含@endif--}}
                            {{--@endif--}}
                        {{--</td>--}}
                        {{--<td>@if(isset($houseDatas[1]) && isset($houseDatas[1]->isContainPropertyCost))--}}
                            {{--@if($houseDatas[1]->isContainPropertyCost == 0)不包含@endif @if($houseDatas[1]->isContainPropertyCost == 1)包含@endif--}}
                            {{--@endif</td>--}}
                        {{--<td>--}}
                            {{--@if(isset($houseDatas[2]) && isset($houseDatas[2]->isContainPropertyCost))--}}
                            {{--@if($houseDatas[2]->isContainPropertyCost == 0)不包含@endif @if($houseDatas[2]->isContainPropertyCost == 1)包含@endif--}}
                            {{--@endif--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--@if(isset($houseDatas[3]) && isset($houseDatas[3]->isContainPropertyCost))--}}
                            {{--@if($houseDatas[3]->isContainPropertyCost == 0)不包含@endif @if($houseDatas[3]->isContainPropertyCost == 1)包含@endif--}}
                            {{--@endif--}}
                        {{--</td>       --}}
                   {{--</tr>--}}
            @endif
            @if($houseDatas[0]->houseType1 == 2)
                <tr height="50">        
                        <th>写字楼级别</th>
                        <td>{{$houseDatas[0]->officeLevel}}</td>
                        <td>@if(isset($houseDatas[1])){{$houseDatas[1]->officeLevel}}@endif</td>
                        <td>
                            @if(isset($houseDatas[2]))
                            {{$houseDatas[2]->officeLevel}}
                            @endif
                        </td>
                        <td>
                            @if(isset($houseDatas[3]))
                            {{$houseDatas[3]->officeLevel}}
                            @endif
                        </td>       
                </tr>
            @endif
            @if($houseDatas[0]->houseType1 == 1)
                <tr height="50">        
                        <th>是否转让</th>
                        <td>@if($houseDatas[0]->isTransfer == 0)不转让@endif @if($houseDatas[0]->isTransfer == 1)转让@endif</td>
                        <td>@if(isset($houseDatas[1]))@if($houseDatas[0]->isTransfer == 0)不转让@endif @if($houseDatas[0]->isTransfer == 1)转让@endif @endif</td>
                        <td>
                            @if(isset($houseDatas[2]))
                            @if($houseDatas[0]->isTransfer == 0)不转让@endif @if($houseDatas[0]->isTransfer == 1)转让@endif
                            @endif
                        </td>
                        <td>
                            @if(isset($houseDatas[3]))
                            @if($houseDatas[0]->isTransfer == 0)不转让@endif @if($houseDatas[0]->isTransfer == 1)转让@endif
                            @endif
                        </td>       
                </tr>
                <tr height="50">        
                    <th>商铺状态</th>
                    <td>{{$houseDatas[0]->stateShop}}</td>
                    <td>@if(isset($houseDatas[1])){{$houseDatas[1]->stateShop}}@endif</td>
                    <td>
                        @if(isset($houseDatas[2]))
                        {{$houseDatas[2]->stateShop}}
                        @endif
                    </td>
                    <td>
                        @if(isset($houseDatas[3]))
                        {{$houseDatas[3]->stateShop}}
                        @endif
                    </td>       
                  </tr>
              @endif
         @endif
        @if($houseDatas[0]->houseType1 == 3)
      <tr height="50">        
        <th>户型</th>
        <td>
          @if(isset($houseDatas[0]))
          {{$houseDatas[0]->roomStr[0]}}室{{$houseDatas[0]->roomStr[1]}}厅{{$houseDatas[0]->roomStr[2]}}厨{{$houseDatas[0]->roomStr[3]}}卫@if(!empty($houseDatas[0]->roomStr[4])){{$houseDatas[0]->roomStr[4]}}阳台@endif
          @endif
        </td>
        <td>
            @if(isset($houseDatas[1]))
            {{$houseDatas[1]->roomStr[0]}}室{{$houseDatas[1]->roomStr[1]}}厅{{$houseDatas[1]->roomStr[2]}}厨{{$houseDatas[1]->roomStr[3]}}卫@if(!empty($houseDatas[1]->roomStr[4])){{$houseDatas[1]->roomStr[4]}}阳台@endif
            @endif
        </td>
        <td>
            @if(isset($houseDatas[2]))
            {{$houseDatas[2]->roomStr[0]}}室{{$houseDatas[2]->roomStr[1]}}厅{{$houseDatas[2]->roomStr[2]}}厨{{$houseDatas[2]->roomStr[3]}}卫@if(!empty($houseDatas[2]->roomStr[4])){{$houseDatas[2]->roomStr[4]}}阳台@endif
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            {{$houseDatas[3]->roomStr[0]}}室{{$houseDatas[3]->roomStr[1]}}厅{{$houseDatas[3]->roomStr[2]}}厨{{$houseDatas[3]->roomStr[3]}}卫@if(!empty($houseDatas[3]->roomStr[4])){{$houseDatas[3]->roomStr[4]}}阳台@endif
            @endif
        </td>       
      </tr>
      <tr height="50">        
        <th>朝向</th>
        <td>@if(isset($houseDatas[0]) && isset($houseDatas[0]->faceTo)){{$houseDatas[0]->faceTo}}@endif</td>
        <td>@if(isset($houseDatas[1]) && isset($houseDatas[1]->faceTo)){{$houseDatas[1]->faceTo}}@endif</td>
        <td>
            @if(isset($houseDatas[2]) && isset($houseDatas[2]->faceTo))
            {{$houseDatas[2]->faceTo}}
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]) && isset($houseDatas[3]->faceTo))
            {{$houseDatas[3]->faceTo}}
            @endif
        </td>       
      </tr>
      @endif
      <tr height="50">
        <th>面积</th>
        <td>{{$houseDatas[0]->area}}平米</td>
        <td>@if(isset($houseDatas[1])){{$houseDatas[1]->area}}平米@endif </td>
        <td>
            @if(isset($houseDatas[2]))
            {{$houseDatas[2]->area}}平米
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            {{$houseDatas[3]->area}}平米
            @endif
        </td>
      </tr>
        <tr height="50">
        <th>楼层</th>
        <td>第{{$houseDatas[0]->currentFloor}}层( 共{{$houseDatas[0]->totalFloor}}层 ）</td>
        <td>@if(isset($houseDatas[1]))第{{$houseDatas[1]->currentFloor}}层( 共{{$houseDatas[1]->totalFloor}}层 ）@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            第{{$houseDatas[2]->currentFloor}}层( 共{{$houseDatas[2]->totalFloor}}层 ）
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            第{{$houseDatas[3]->currentFloor}}层( 共{{$houseDatas[3]->totalFloor}}层 ）
            @endif
        </td>
      </tr>
       {{--<tr height="50">--}}
        {{--<th>楼栋</th>--}}
        {{--<td>{{$houseDatas[0]->building}}楼栋{{$houseDatas[0]->unit}}单元{{$houseDatas[0]->houseNum}}号</td>--}}
        {{--<td>@if(isset($houseDatas[1])){{$houseDatas[1]->building}}楼栋{{$houseDatas[1]->unit}}单元{{$houseDatas[1]->houseNum}}号@endif</td>--}}
        {{--<td>--}}
            {{--@if(isset($houseDatas[2]))--}}
            {{--{{$houseDatas[2]->building}}楼栋{{$houseDatas[2]->unit}}单元{{$houseDatas[2]->houseNum}}号--}}
            {{--@endif--}}
        {{--</td>--}}
        {{--<td>--}}
            {{--@if(isset($houseDatas[3]))--}}
            {{--{{$houseDatas[3]->building}}楼栋{{$houseDatas[3]->unit}}单元{{$houseDatas[3]->houseNum}}号--}}
            {{--@endif--}}
        {{--</td>--}}
      {{--</tr>--}}
      <tr height="50">
        <th>物业类型</th>
        <td>{{$houseDatas[0]->houseType2}}</td>
        <td>@if(isset($houseDatas[1])){{$houseDatas[1]->houseType2}}@endif</td>
        <td>
            @if(isset($houseDatas[2]))
            {{$houseDatas[2]->houseType2}}
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            {{$houseDatas[3]->houseType2}}
            @endif
        </td>
      </tr>
      <tr height="50">
        <th>装修状况</th>
        <td>{{$houseDatas[0]->fitment}}</td>
        <td>@if(isset($houseDatas[1])){{$houseDatas[1]->fitment}}@endif</td>
        <td>@if(isset($houseDatas[2])) {{$houseDatas[2]->fitment}} @endif</td>
        <td>@if(isset($houseDatas[3])) {{$houseDatas[3]->fitment}} @endif</td>
      </tr>
      @if($houseDatas[0]->houseType1 == 1 || $houseDatas[0]->houseType1 == 3)
      <tr height="80">
        <th>配套设施</th>
        <td>@if(!empty($houseDatas[0]->equipment)){{$houseDatas[0]->equipment}}@else暂无@endif</td>
        <td>@if(isset($houseDatas[1])) @if(!empty($houseDatas[1]->equipment)){{$houseDatas[1]->equipment}}@else暂无@endif @endif</td>
        <td>@if(isset($houseDatas[2])) @if(!empty($houseDatas[2]->equipment)){{$houseDatas[2]->equipment}}@else暂无@endif @endif</td>
        <td>@if(isset($houseDatas[3])) @if(!empty($houseDatas[3]->equipment)){{$houseDatas[3]->equipment}}@else暂无@endif @endif</td>
      </tr>
      @endif
      {{--@if($houseDatas[0]->publishUserType == 1)--}}
      <tr>
        <th colspan="5"><p class="price" id="item3"><span class="border back_color"></span><span class="new_price">户型对比</span></p></th>
      </tr>
      <tr height="50">
        <th>户型图片</th>
        <td>
        @if(isset($houseDatas[0]))
          <a><dl class="build_name">
              @if($houseDatas[0]->publishUserType == 1)
              <dt style="width:200px; height:200px;"><img src="@if(!empty($houseDatas[0]->huXingImage)){{$houseDatas[0]->huXingImage}} @else /image/noImage.png @endif" style="width:200px; height:200px;" alt="" onerror="errorImage(this)"></dt>
              @endif
            @if($houseDatas[0]->houseType1 == 3)
            <dd><span>{{$houseDatas[0]->roomStr[0]}}室{{$houseDatas[0]->roomStr[1]}}厅{{$houseDatas[0]->roomStr[2]}}厨{{$houseDatas[0]->roomStr[3]}}卫</span><!--<i></i>--></dd>
            @endif
          </dl></a>
          @endif
        </td>
        <td>
          @if(isset($houseDatas[1]))
          <a><dl class="build_name">
              @if($houseDatas[1]->publishUserType == 1)
              <dt style="width:200px; height:200px;"><img src="@if(!empty($houseDatas[1]->huXingImage)){{$houseDatas[1]->huXingImage}} @else /image/noImage.png @endif" style="width:200px; height:200px;" alt="" onerror="errorImage(this)"></dt>
              @endif
              @if($houseDatas[0]->houseType1 == 3)
            <dd><span>{{$houseDatas[1]->roomStr[0]}}室{{$houseDatas[1]->roomStr[1]}}厅{{$houseDatas[1]->roomStr[2]}}厨{{$houseDatas[1]->roomStr[3]}}卫</span><!--<i></i>--></dd>
          @endif
          </dl></a>
          @endif
        </td>
        <td>
            @if(isset($houseDatas[2]))
            <a><dl class="build_name">
                @if($houseDatas[2]->publishUserType == 1)
                <dt style="width:200px; height:200px;"><img src="@if(!empty($houseDatas[2]->huXingImage)){{$houseDatas[2]->huXingImage}} @else /image/noImage.png @endif" style="width:200px; height:200px;" alt="" onerror="errorImage(this)"></dt>
                @endif
            @if($houseDatas[0]->houseType1 == 3)
            <dd><span>{{$houseDatas[2]->roomStr[0]}}室{{$houseDatas[2]->roomStr[1]}}厅{{$houseDatas[2]->roomStr[2]}}厨{{$houseDatas[2]->roomStr[3]}}卫</span><!--<i></i>--></dd>
            @endif
            </dl></a>
            @endif
        </td>
        <td>
            @if(isset($houseDatas[3]))
            <a><dl class="build_name">
                @if($houseDatas[3]->publishUserType == 1)
                <dt style="width:200px; height:200px;"><img src="@if(!empty($houseDatas[3]->huXingImage)){{$houseDatas[3]->huXingImage}} @else /image/noImage.png @endif" style="width:200px; height:200px;" alt="" onerror="errorImage(this)"></dt>
                @endif
            @if($houseDatas[0]->houseType1 == 3)
            <dd><span>{{$houseDatas[3]->roomStr[0]}}室{{$houseDatas[3]->roomStr[1]}}厅{{$houseDatas[3]->roomStr[2]}}厨{{$houseDatas[3]->roomStr[3]}}卫</span><!--<i></i>--></dd>
            @endif
            </dl></a>
            @endif
        </td>
      </tr>
     <!--  <tr>
        <th colspan="5"><p class="price" id="item4"><span class="border back_color"></span><span class="new_price">周边配套</span></p></th>
      </tr> -->
    </table>
  </div>
</div>
<script src="/js/list.js?v={{Config::get('app.version')}}"></script>
<script>
$(function(){
  
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:100,
    overlay:0.45
  }); 
});
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
		//var num4=$("#item4").offset().top;
		
		
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

// 图片加载不出来时  使用默认图片
  function errorImage(obj){
      obj.src = '/image/noImage.png';
  }
</script>
@endsection