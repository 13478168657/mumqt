@extends('mainlayout')
@section('title')
<title>【{{$commName}},二手房,租房】-搜房网</title>
<meta name="Keywords" content="{{$commName}}租房,{{$commName}}二手房" />
<meta name="Description" content="{{$commName}}为您提供多方位信息，小区交通、周边、学校等详情，小区外景图、户型图、交通图、配套图，小区租售价格走势，小区二手房源、租房房源。" />
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/buildDetail.css">
@endsection
@section('content')

@include('esf.search')
<div class="build_iamge">
    <div class="detail_context_pic">
     @if(!empty($communityimage))
        <div class="detail_context_pic_top">
            <a href="#" class="js-picshow" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif"><img src='' id="pic1" curindex="0" alt="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif"/></a>
            <a id="preArrow" href="javascript:void(0)" class="contextDiv"><span id="preArrow_A"></span></a>
            <a id="nextArrow" href="javascript:void(0)" class="contextDiv"><span id="nextArrow_A"></span></a>
        </div>
        <div class="detail_context_pic_bot">
            <div class="detail_picbot_left"><a href="javascript:void(0)" id="preArrow_B"><img src="/image/left1.jpg" alt="上一个" /></a></div>
            <div class="detail_picbot_mid js-imglist">
                <ul>
                    @foreach($communityimage as $key => $val)
                        <li><a href='javascript:void(0);'><img src="{{get_img_url('commPhoto', $val->fileName, 1)}}" data_src="{{get_img_url('commPhoto', $val->fileName)}}" width='90px' height='60px'  bigimg="{{get_img_url('commPhoto', $val->fileName,5)}}" alt="@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif"/></a></li>
                    @endforeach
                </ul>
            </div>
            <div class="detail_picbot_right"><a href="javascript:void(0)" id="nextArrow_B"><img src="/image/right1.jpg" alt="下一个" /></a></div>
        </div>
     @else
        <div class="detail_img"></div>
     @endif
    </div>
    <div class="information">
        <h2>@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif<span class="subway">@if(!empty($viewShowInfo['type2Name'])) {{$viewShowInfo['type2Name']}} @endif</span></h2>
        <p class="address"><span class="sq">[
                @if(!empty($viewShowInfo['cityAreaName']) || !empty($viewShowInfo['businessareaName']))
                    @if(!empty($viewShowInfo['cityAreaName']))
                        {{$viewShowInfo['cityAreaName']}}
                    @endif
                    @if(!empty($viewShowInfo['businessareaName']))
                         ▪{{$viewShowInfo['businessareaName']}}
                    @endif
                @else
                    其它
                @endif
                ]</span><span class="position" title="{{(!empty($viewShowInfo['address']))? $viewShowInfo['address'] : ''}}">{{(!empty($viewShowInfo['address']))? $viewShowInfo['address'] : ''}}</span><i></i></p>
        <div class="build_price">
            <dl>
                <dt>本月租金</dt>
                <dd>均&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：
                    @if(Cookie::get($sale_rent)=='rentesb')
                        @if($type2=='301' && !empty($viewShowInfo['priceRentAvg3']))<span class="price">{{floor($viewShowInfo['priceRentAvg3'])}}</span>元/月@else 暂无资料 @endif
                    @elseif($type2!='301')
                        @if(!empty($viewShowInfo['price2'])) <span class="price">{{$viewShowInfo['price2']}}</span> 元/平米▪天@else 暂无资料 @endif
                    @else
                        @if(!empty(floor($viewShowInfo['statusRentPrice']))) <span class="price">{{floor($viewShowInfo['statusRentPrice'])}}</span> 元/月@else 暂无资料 @endif
                    @endif
                    <span class="dd_r">出租房源</span></dd>
                <dd>环比上月：<span class="color096 margin_r">
                        @if($viewShowInfo['statusRentIncre'] > 0 )
                            <span class="colorfe">↑{{abs($viewShowInfo['statusRentIncre'])}}% </span>
                        @elseif($viewShowInfo['statusRentIncre'] === 0)
                            <span class="colorfe">{{abs($viewShowInfo['statusRentIncre'])}}% </span>
                        @elseif($viewShowInfo['statusRentIncre'] < 0)
                            <span class="color096">↓{{abs($viewShowInfo['statusRentIncre'])}}% </span>
                        @else
                            <span class="colorfe">暂无资料</span>
                        @endif
                    </span>同比去年：<span class="colorfe">
                        @if($viewShowInfo['statusRentIncreLastYears'] > 0 )
                            <span class="colorfe">↑{{abs($viewShowInfo['statusRentIncreLastYears'])}}% </span>
                        @elseif($viewShowInfo['statusRentIncreLastYears'] === 0)
                            <span class="colorfe">{{abs($viewShowInfo['statusRentIncreLastYears'])}}% </span>
                        @elseif($viewShowInfo['statusRentIncreLastYears'] < 0)
                            <span class="color096">↓{{abs($viewShowInfo['statusRentIncreLastYears'])}}% </span>
                        @else
                            <span class="colorfe">暂无资料</span>
                        @endif
                    </span>
                    <span class="dd_r">
                        <a href="/{{$viewShowInfo['rentUrl']}}/area/ba{{$communityId}}" target="_blank">
                            {{(!empty($houseRentData->total)) ? $houseRentData->total : 0 }}
                        </a>套
                    </span>
                </dd>
            </dl>
            <dl>
                <dt>本月出售</dt>
                <dd>均&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 价：
                    @if(Cookie::get($sale_rent)=='saleesb')
                        @if($type2=='301' && !empty($viewShowInfo['priceSaleAvg3'])) <span class="price">{{floor($viewShowInfo['priceSaleAvg3'])}}</span> 元/平米@else 暂无资料 @endif
                    @else
                        @if(!empty($viewShowInfo['statusSalePrice'])) <span class="price">{{floor($viewShowInfo['statusSalePrice'])}}</span> 元/平米@else 暂无资料  @endif
                    @endif
                    <span class="dd_r">出售房源</span></dd>
                <dd>环比上月：<span class="color096 margin_r">
                        @if($viewShowInfo['statusSaleIncre'] > 0 )
                            <span class="colorfe">↑{{abs($viewShowInfo['statusSaleIncre'])}}% </span>
                        @elseif($viewShowInfo['statusSaleIncre'] === 0)
                            <span class="colorfe">{{abs($viewShowInfo['statusSaleIncre'])}}% </span>
                        @elseif($viewShowInfo['statusSaleIncre'] < 0)
                            <span class="color096">↓{{abs($viewShowInfo['statusSaleIncre'])}}% </span>
                        @else
                            <span class="colorfe">暂无资料</span>
                        @endif
                    </span>同比去年：<span class="colorfe">
                        @if($viewShowInfo['statusSaleIncreLastYears'] > 0 )
                            <span class="colorfe">↑{{abs($viewShowInfo['statusSaleIncreLastYears'])}}% </span>
                        @elseif($viewShowInfo['statusSaleIncreLastYears'] === 0)
                            <span class="colorfe">{{abs($viewShowInfo['statusSaleIncreLastYears'])}}% </span>
                        @elseif($viewShowInfo['statusSaleIncreLastYears'] < 0)
                            <span class="color096">↓{{abs($viewShowInfo['statusSaleIncreLastYears'])}}% </span>
                        @else
                            <span class="colorfe">暂无资料</span>
                        @endif
                    </span>
                    <span class="dd_r">
                        <a class="color_blue" href="/{{$viewShowInfo['saleUrl']}}/area/ba{{$communityId}}" target="_blank">
                            {{(!empty($houseSaleData->total)) ? $houseSaleData->total : 0 }}
                        </a>套
                    </span>
                </dd>
            </dl>
        </div>
        <p class="show_house">
            <a class="follow"><span class="focus" value="{{$communityId}},3,{{substr($type2, 0, 1)}},0"><i></i><span>{{(!empty($viewShowInfo['interest']))? '已关注' : '关注'}}</span></span></a>

            <span class="share jiathis_style_24x24">
            <span>分享到：</span>
            <a class="jiathis_button_weixin " ></a>
            <a class="jiathis_button_cqq " ></a>
            <a class="jiathis_button_qzone no_right" ></a>
            </span>
        </p>
    </div>
    <div class="broker_r">
        <h2>置业专家</h2>

        <div class="sale zf" >
            @if(!empty($marketExpert['realEstate']))
                @foreach($marketExpert['realEstate'] as $k1 => $v1)
                    @if(!empty($v1->brokerInfo) && !empty($v1->houseInfo))
                        <div class="expert">
                            <a href="/brokerinfo/{{$v1->brokerInfo->id}}.html" target="_blank">
                                @if(!empty($v1->brokerInfo->photo))
                                    <img style="background: rgba(0, 0, 0, 0) url(/image/default.png) no-repeat scroll 0 0 / 100% 100%;" alt="{{(!empty($v1->brokerInfo->realName))?$v1->brokerInfo->realName:'匿名'}}"  src="{{get_img_url('userPhoto',$v1->brokerInfo->photo, '1')}}" onerror="javascript:this.src='/image/default_broker.png';" width="67" height="90">
                                @else
                                    <img src="/image/default_broker.png" alt="{{(!empty($v1->brokerInfo->realName))?$v1->brokerInfo->realName:'匿名'}}" width="67" height="90">
                                @endif
                            </a>
                            <dl>
                                <dt>
                                    <a href="/housedetail/{{$v1->saleRentType=='sale'?'ss':'sr'}}{{$v1->houseInfo->id}}.html" onclick="saleClick('{{$v1->houseInfo->id}}')" target="_blank">{{$v1->houseInfo->title}}</a>
                                </dt>
                                <dd>
                                    <div class="info_l">
                                        @if($v1->houseInfo->houseType1 == 3)
                                            <p class="p1">
                                                @if(!empty($v1->houseInfo->roomStr))
                                                    <span>{{substr($v1->houseInfo->roomStr,0,1)}}室{{substr($v1->houseInfo->roomStr,2,1)}}厅</span><span class="dotted"></span>
                                                @endif
                                                <span>{{!empty($v1->houseInfo->area)?$v1->houseInfo->area.'平米':''}}</span>
                                            </p>
                                        @else
                                            <p class="p1">
                                                @if(!empty($v1->houseInfo->area))
                                                    <span>{{$v1->houseInfo->area.'平米'}}</span><span class="dotted"></span>
                                                @endif
                                                @if(!empty($v1->houseInfo->currentFloor) && !empty($v1->houseInfo->totalFloor))
                                                        <span>{{$v1->houseInfo->currentFloor}}/{{$v1->houseInfo->totalFloor}}层</span>
                                                @endif
                                            </p>
                                        @endif
                                        <p class="p2">
                                            <a href="/brokerinfo/{{$v1->brokerInfo->id}}.html" target="_blank">
                                                {{(!empty($v1->brokerInfo->realName))?$v1->brokerInfo->realName:'匿名'}}
                                            </a>
                                            @if(!empty(\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($v1->brokerInfo->cityAreaId)))
                                                <span>{{\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($v1->brokerInfo->cityAreaId)}}</span>
                                            @endif
                                            @if(!empty(\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($v1->brokerInfo->businessAreaId) ))
                                                ▪
                                                <span>{{\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($v1->brokerInfo->businessAreaId)}}</span>
                                            @endif
                                        </p>
                                        <p class="p1">
                                            @if(!empty($v1->brokerInfo->mobile))
                                                <span>{{$v1->brokerInfo->mobile}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="info_r" style="text-align: right;max-width:100px;">
                                        @if($v1->saleRentType=='sale')
                                            @if(!empty($v1->houseInfo->price2))
                                                <span class="price" style="max-width:100px;"><span>{{floor($v1->houseInfo->price2)}}</span>万</span>
                                            @else
                                                <span class="price" style="max-width:100px;"><span>面议</span></span>
                                            @endif
                                        @else
                                            @if(!empty($v1->houseInfo->price1))
                                                <span class="price" style="max-width:100px;"><span>{{floor($v1->houseInfo->price1)}}</span>元/月</span>
                                            @else
                                                <span class="price" style="max-width:100px;"><span>面议</span></span>
                                            @endif
                                        @endif
                                    </div>
                                </dd>
                            </dl>
                        </div>

                        @if((count($marketExpert['realEstate'])==2 && $k1==1))
                            <div class="border_b"></div>
                        @endif
                    @endif
                @endforeach
            @endif
        </div>
        <p class="tg"><a href="{{config('hostConfig.agr_host')}}">我也要出现在这里&lt;&lt;&lt;</a></p>
    </div>
</div>
@include('esf.esfTypeNav')
<div class="detail">
  <div class="house_msg">
      <div class="house_info">
          <ul class="basic buy_basic">
              <li>
                  <span class="color8d">物业类别：</span>
                  <span class="color2d">{{(!empty(config('communityType2.'. $type2)))? config('communityType2.'. $type2) : '暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">建筑结构：</span>
                  <span class="color2d no_width">{{(!empty($viewShowInfo['structure']))? $viewShowInfo['structure'] : '暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">项目特色：</span>
                  <span class="color2d">{{(!empty($viewShowInfo['tagsName']))? $viewShowInfo['tagsName'] : '暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">建筑面积：</span>
                  <span class="color2d">{{(!empty($type2GetInfo->floorage))?$type2GetInfo->floorage.' 平方米' : '暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">占地面积：</span>
                  <span class="color2d">{{(!empty($type2GetInfo->floorSpace))? $type2GetInfo->floorSpace. ' 平方米' : '暂无资料'}}</span>
              </li>
              @if(substr($type2,0,1) == 3)
              <li>
                  <span class="color8d">总&nbsp;&nbsp;户&nbsp;数：</span>
                  <span class="color2d">{{(!empty($type2GetInfo->houseTotal))? $type2GetInfo->houseTotal . ' 户' : '暂无资料'}}</span>
              </li>
              @endif
              <li>
                  <span class="color8d">绿&nbsp;&nbsp;化&nbsp;率：</span>
                  <span class="color2d">{{(!empty($type2GetInfo->greenRate))? $type2GetInfo->greenRate .' %' : '暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">容&nbsp;&nbsp;积&nbsp;率：</span>
                  <span class="color2d">{{(!empty($type2GetInfo->volume))? $type2GetInfo->volume : '暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">所在区域：</span>
                  <span class="color2d">
                      @if(!empty($viewShowInfo['cityAreaName']) || !empty($viewShowInfo['businessareaName']))
                          @if(!empty($viewShowInfo['cityAreaName']))
                              {{$viewShowInfo['cityAreaName']}}
                          @endif
                          @if(!empty($viewShowInfo['businessareaName']))
                              {{$viewShowInfo['businessareaName']}}
                          @endif
                      @else
                          暂无资料
                      @endif
                  </span>
              </li>
              <li>
                  <span class="color8d">物业电话：</span>
                  <span class="color2d">{{(!empty($viewShowInfo['propertyPhone']))?$viewShowInfo['propertyPhone']:'暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">物业地点：</span>
                  <span class="color2d">{{(!empty($viewShowInfo['propertyAddress']))?$viewShowInfo['propertyAddress']:'暂无资料'}}</span>
              </li>
              <li>
                  <span class="color8d">物&nbsp;&nbsp;业&nbsp;费：</span>
                  <span class="color2d">{{(!empty($type2GetInfo->propertyFee))? $type2GetInfo->propertyFee .' 元/平米·月' : '暂无资料'}}</span>
              </li>
              <li class="no_left">
                  <span class="color8d">开&nbsp;&nbsp;发&nbsp;商：</span>
                  <span class="color2d">{{(!empty($viewShowInfo['developerName']))?$viewShowInfo['developerName']:'暂无资料'}}</span>
              </li>
              <li class="no_left">
                  <span class="color8d">物业公司：</span>
                  <span class="color2d">{{(!empty($viewShowInfo['propertyName']))?$viewShowInfo['propertyName']:'暂无资料'}}</span>
              </li>
              <li class="no_left">
                  <span class="color8d">小区地址：</span>
                  <span class="color2d">{{(!empty($viewShowInfo['address']))? $viewShowInfo['address'] : '暂无资料'}}</span>
              </li>
          </ul>
      </div>
      <div class="build">
          @if(!empty($houseSaleData->hits))
              <div class="house_type">
                  <h2>
                      <!--@if(!empty($viewShowInfo['commName']))
                          {{$viewShowInfo['commName']}}
                      @endif&nbsp;-->
                      @if(substr($type2, 0,1) == 3)
                          二手房
                      @else
                          出售
                      @endif
                      <span>
                <a href="/{{$viewShowInfo['saleUrl']}}/area/ba{{$communityId}}" target="_blank">更多...</a>
            </span>
                  </h2>
                  <div class="apartment">
                      <div class="apartment_house">
                          <?php $count =  count($houseSaleData->hits) >= 4 ? 4 : count($houseSaleData->hits) ; ?>
                          @for($i = 0; $i < $count; $i++)
                              <dl>
                                  <dt>
                                      <a href="/housedetail/ss{{$houseSaleData->hits[$i]->_source->id}}.html"><img src="{{get_img_url('houseSale', $houseSaleData->hits[$i]->_source->thumbPic)}}" alt=""></a>
                                  </dt>
                                  <dd>
                                      <div class="house_detail">
                                          <p class="home_name"><a href="/housedetail/ss{{$houseSaleData->hits[$i]->_source->id}}.html" >{{$houseSaleData->hits[$i]->_source->title}}</a></p>
                                          <div class="home_price" style="cursor:pointer;" onclick="redirect('/housedetail/ss{{$houseSaleData->hits[$i]->_source->id}}.html');">
                                              <p class="p1">
                                                  @if(!empty(substr($houseSaleData->hits[$i]->_source->roomStr,0,1)))
                                                      {{substr($houseSaleData->hits[$i]->_source->roomStr,0,1)}}室
                                                  @endif
                                                  @if(!empty(substr($houseSaleData->hits[$i]->_source->roomStr,2,1)))
                                                      {{substr($houseSaleData->hits[$i]->_source->roomStr,2,1)}}厅/
                                                  @endif
                                                  @if(!empty($houseSaleData->hits[$i]->_source->area))
                                                      {{$houseSaleData->hits[$i]->_source->area}}平米
                                                  @endif
                                              </p>
                                              <p class="p2">
                                                  @if(!empty(floor($houseSaleData->hits[$i]->_source->price2)))
                                                      <span class="colorfe">{{floor($houseSaleData->hits[$i]->_source->price2)}}</span>万
                                                  @else
                                                      <span class="colorfe">面议</span>
                                                  @endif
                                              </p>
                                          </div>
                                      </div>
                                  </dd>
                              </dl>
                          @endfor
                      </div>
                  </div>
              </div>
          @endif
          @if(!empty($houseRentData->hits))
              <div class="house_type">
                  <h2>
                      <!--@if(!empty($viewShowInfo['commName']))
                          {{$viewShowInfo['commName']}}
                      @endif&nbsp;-->
                      @if(substr($type2, 0,1) == 3)
                          租房
                      @else
                          出租
                      @endif
                      <span>
                <a href="/{{$viewShowInfo['rentUrl']}}/area/ba{{$communityId}}" target="_blank">更多...</a>
            </span>
                  </h2>
                  <div class="apartment">
                      <div class="apartment_house">
                          <?php $count =  count($houseRentData->hits) >= 4 ? 4 : count($houseRentData->hits) ; ?>
                          @for($i = 0; $i < $count; $i++)
                              <dl>
                                  <dt>
                                      <a href="/housedetail/sr{{$houseRentData->hits[$i]->_source->id}}.html"><img src="{{get_img_url('houseRent',$houseRentData->hits[$i]->_source->thumbPic)}}" alt=""></a>
                                  </dt>
                                  <dd>
                                      <div class="house_detail">
                                          <p class="home_name"><a href="/housedetail/sr{{$houseRentData->hits[$i]->_source->id}}.html">{{$houseRentData->hits[$i]->_source->title}}</a></p>
                                          <div class="home_price" style="cursor:pointer;" onclick="redirect('/housedetail/sr{{$houseRentData->hits[$i]->_source->id}}.html');">
                                              <p class="p1">
                                                  @if(!empty(substr($houseRentData->hits[$i]->_source->roomStr,0,1)))
                                                      {{substr($houseRentData->hits[$i]->_source->roomStr,0,1)}}室
                                                  @endif
                                                  @if(!empty(substr($houseRentData->hits[$i]->_source->roomStr,2,1)))
                                                      {{substr($houseRentData->hits[$i]->_source->roomStr,2,1)}}厅/
                                                  @endif
                                                  @if(!empty($houseRentData->hits[$i]->_source->area))
                                                      {{$houseRentData->hits[$i]->_source->area}}平米
                                                  @endif
                                              </p>
                                              <p class="p2">
                                                  @if(!empty(floor($houseRentData->hits[$i]->_source->price1)))
                                                      <span class="colorfe">{{floor($houseRentData->hits[$i]->_source->price1)}}</span>元/月
                                                  @else
                                                      <span class="colorfe">面议</span>
                                                  @endif
                                              </p>
                                          </div>
                                      </div>
                                  </dd>
                              </dl>
                          @endfor
                      </div>
                  </div>
              </div>
          @endif
              <div class="house_type">
                  <h2>周边配套</h2>
                  <div class="map perimeter_map">
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
                              <a class="chechData" attr="小区" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边楼盘">周边楼盘</a>
                              <a class="chechData" attr="公交" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边交通">交通</a>
                              <a class="chechData" attr="超市" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边超市">超市</a>
                              <a class="chechData" attr="学校" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边学校">学校</a>
                              <a class="chechData" attr="餐饮" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边餐饮">餐饮</a>
                              <a class="chechData" attr="银行" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边银行">银行</a>
                              <a class="chechData" attr="医院" title="@if(!empty($viewShowInfo['commName'])){{$viewShowInfo['commName']}}@endif周边医院">医院</a>
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
              <div class="house_type">
                  <h2><!--@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif-->楼盘租售价格走势</h2>
                  <div class="district">
                      <div class="zf_five">
                          <p>
                              @if(!empty($viewShowInfo['commName']))
                                  {{$viewShowInfo['commName']}}
                              @endif
                              @if(substr($type2, 0,1) == 3)
                                  二手房
                              @else
                                  出售
                              @endif
                              价格走势
                          </p>
                          <div class="price" style="height: 200px" id="price_show"></div>
                      </div>
                      <div class="zf_five" style="margin-right:0\0;">
                          <p>
                              @if(!empty($viewShowInfo['commName']))
                                  {{$viewShowInfo['commName']}}
                              @endif
                              @if(substr($type2, 0,1) == 3)
                                  租房
                              @else
                                  出租
                              @endif
                              价格走势
                          </p>
                          <div class="price" style="height: 200px" id="price_zu"></div>
                      </div>
                  </div>
              </div>
      </div>
  </div>
        <div class="broker_msg">
            @if($admodels->modelId == 1)
                <script type="text/javascript" src="/adShow.php?position=33&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShow.php?position=34&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShow.php?position=35&cityId={{CURRENT_CITYID}}"></script>
            @elseif($admodels->modelId == 2)
                <script type="text/javascript" src="/adShowModel.php?position=36&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShowModel.php?position=37&cityId={{CURRENT_CITYID}}"></script>
                <script type="text/javascript" src="/adShowModel.php?position=38&cityId={{CURRENT_CITYID}}"></script>
            @endif
            @if(!empty($newComm))
            <div class="spread_home">
                <p><a href="/new/area">新房推荐</a></p>
                @foreach($newComm as $k => $newFloor)
                    <dl>
                        <a href="/xinfindex/{{$newFloor->_source->id}}/{{!empty($newFloor->_source->type2)?substr($newFloor->_source->type2,0,3):$type2}}.html"  target="_blank">
                            <dt><img src="@if(!empty($newFloor->_source->titleImage)){{get_img_url('commPhoto',$newFloor->_source->titleImage,2)}}@endif" alt="{{$newFloor->_source->name}}"></dt>
                            <dd class="spread_name">[{{$newFloor->_source->areaname}}]&nbsp;{{$newFloor->_source->name}}</dd>
                            <dd class="spread_price">
                                <span class="build_name">
                                    <?php $houset1 = substr($type2,0,1)?>
                                    @if($houset1 == 1)
                                        商铺
                                    @elseif($houset1 == 2)
                                        写字楼
                                    @else
                                        住宅
                                    @endif
                                </span>
                                <span class="price">
                                    @if(!empty($newFloor->_source->{'priceSaleAvg'.$houset1})) <span class="fontA colorfe">{{$newFloor->_source->{'priceSaleAvg'.$houset1} }}</span>元/平米 @else 待定 @endif
                                </span>
                            </dd>
                        </a>
                    </dl>
                @endforeach
            </div>
            @endif
        </div>
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
</div>
<div class="web_map">
    <dl class="no_border">
        <dt>相关区域小区</dt>
        <dd class="dd">
            @if(!empty($cityArea))
                @foreach($cityArea as $k=>$v)
                    <a onclick="webMpe('webMpe',{{$k+1}})" @if($k==0) class="up" @endif id="webMpe{{$k+1}}">{{$v->name}}</a>
                @endforeach
            @endif
        </dd>
    </dl>
    @if(!empty($businessAreaH5))
        <?php $i=0;?>
        @foreach($businessAreaH5 as $k=>$bvv)
            <dl id="con_webMpe_{{$i+1}}" @if($i++ != 0)style="display:none;"@endif >
                <dt>&nbsp;</dt>
                <dd class="color8d">
                    @foreach($bvv as $bv)
                        <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/esfsale/area/aa{{$k}}-ab{{$bv->id}}">{{$bv->name}}</a>
                    @endforeach
                </dd>
            </dl>
        @endforeach
    @endif

    <?php   $cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->get(CITY); ?>
    <dl>
        <dt>城市小区</dt>
        <dd>
            @if(!empty($cityObjectAll))
                @foreach($cityObjectAll as $cv)
                    @if($cv['isHot'] == 1)
                        <a href="http://{{$cv['py']}}.{{config('session.domain')}}/saleesb/area">{{$cv['name']}}小区</a>
                    @endif
                @endforeach
            @endif
        </dd>
    </dl>
    <dl>
        <dt>热门城市房价</dt>
        <dd>
            @if(!empty($cityObjectAll))
                @foreach($cityObjectAll as $cv)
                    @if($cv['isHot'] == 1)
                        <a href="http://{{$cv['py']}}.{{config('session.domain')}}/checkpricelist/sale">{{$cv['name']}}房价</a>
                    @endif
                @endforeach
            @endif
        </dd>
    </dl>
    <dl>
        <dt>热门城市二手房</dt>
        <dd>
            @if(!empty($cityObjectAll))
                @foreach($cityObjectAll as $cv)
                    @if($cv['isHot'] == 1)
                        <a href="http://{{$cv['py']}}.{{config('session.domain')}}/esfsale/area">{{$cv['name']}}二手房</a>
                    @endif
                @endforeach
            @endif
        </dd>
    </dl>
    <dl>
        <dt>热门城市新房</dt>
        <dd>
            @if(!empty($cityObjectAll))
                @foreach($cityObjectAll as $cv)
                    @if(($cv['isHot'] == 1) && in_array($cv['py'],config('openCity')) )
                        <a href="http://{{$cv['py']}}.{{config('session.domain')}}/new/area">{{$cv['name']}}新房</a>
                    @endif
                @endforeach
            @endif
        </dd>
    </dl>
</div>
<div class="fullScreen">
    <i class="close">关闭</i>
    <a class="f_left"></a>
    <a class="f_right"></a>
    <div class="pic_box">
        <img alt="@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif">
        <span></span>
    </div>
</div>
<script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>
<script src="/js/point_interest.js?v={{Config::get('app.version')}}"></script>
<script src="/js/specially/headNav.js"></script>
<script src="/js/plugs/newsdetail.js" type="text/javascript"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{config('mapApiKey.baidu')}}"></script>
<script type="text/javascript">
//广告轮播
	if($('.list_adv')){
		$('.list_adv').each(function(){
			tabs($(this).find('a'),$(this));
		});			
	}
	function tabs(obj,_this){
		var n=0;
		if(obj.length>1){
			setInterval(function(){
				n++;			
				if(n>obj.length-1){
					n=0;
				}
				obj.hide();
				obj.eq(n).show();
				
			},3000);
		}
	}
	 //全屏图片
    var fullMask=$('.fullScreen');
    var fullPic=$('.pic_box img');
    var fullPrev=$('.fullScreen .f_left');
    var fullRight=$('.fullScreen .f_right');
    var fullClose=$('.fullScreen .close');
    var sliderPic=$('.js-imglist img');
    var now=0;
    
    $('.js-picshow').click(function(){
        fullMask.show();
        var _index=0;
       for(var i=0;i<sliderPic.length;i++){
       		if(sliderPic.eq(i).attr('class')=='selectpic'){
       			_index=i;
       		}
       }
        now=_index;
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
	//点击图片下一张
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
            var c_name = "{{$viewShowInfo['commName'] or '暂无'}}";
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
  $('#prompt').remove();
  /** 关注 start **/
point_interest('gzCommunity', 'esfIndex');
/** 关注 end **/
</script>
<script>
$(function(){
  $('body').keydown(function(event){
	 if(event.keyCode == 27){
		clo();
	 }
  });
})
$(function(){

  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:100,
    overlay:0.45
  });
});
//底部切换
function webMpe(name, curr) {
    var num=$(".dd a").length;
    for (i = 1; i <= num; i++) {
        var menu = document.getElementById(name + i);
        var cont = document.getElementById("con_" + name + "_" + i);
        menu.className = i == curr ? "up" : "";
        if (i == curr) {
            cont.style.display = "block";
        } else {
            cont.style.display = "none";
        }
    }
}
$(document).ready(function(e) {

  var communityId={{$communityId}};
  var type2={{$type2}};
  var busness={{$viewShowInfo["busnessId"]}};;

  $(".hx .hx_title i").click(function(){
  $(".hx ul").hide();
  $(this).parent().next().show();
  $(".hx .hx_title i").removeClass("click");
  $(this).addClass("click");
  });

  $(".fh").click(function(){
    $(".periphery_build").hide();
    $(".periphery_nav").show();
  });

//经纪人展示切换
//$(".check_tag a").click(function(){
//	$(".check_tag a").removeClass("click");
//	$('.broker_r .sale').hide();
//	$(this).addClass("click");
//	var _index=$(this).index();
//	$('.broker_r .sale').eq(_index).show();
//});
//var n=0;
//var timer=null;
//timer=setInterval(tab,3000);
//
//$('.broker_r .sale').on('mouseenter',function(){
//	clearInterval(timer);
//});
//$('.broker_r .sale').on('mouseleave',function(){
//	timer=setInterval(tab,3000);
//});

function tab(){
	n++;
	if(n>$(".check_tag a").length-1){
		n=0;
	}
	$(".check_tag a").removeClass("click");
	$('.broker_r .sale').hide();
	$(".check_tag a").eq(n).addClass("click");
	$('.broker_r .sale').eq(n).show();	
}


getSalePrice(communityId,'sale',type2,busness);
getSalePrice(communityId,'rent',type2,busness);

  var _token="{{csrf_token()}}";
$.post('/ajax/houseclick',{'url':window.location.href,'_token':_token},function(d){
//console.info(d);
})

 // 置业专家统计
 var sale = [];
 var rent = [];
 var saledata,rentdata;
 @if(!empty($marketExpert['realEstate']['sale']))
    @foreach($marketExpert['realEstate']['sale'] as $key => $val)
        @if(!empty($val->brokerInfo) && !empty($val->houseInfo))
        sale.push("{{$val->houseInfo->id}}");
        @endif
    @endforeach 
 @endif
 
 @if(!empty($marketExpert['realEstate']['rent']))
    @foreach($marketExpert['realEstate']['rent'] as $key => $val)
        @if(!empty($val->brokerInfo) && !empty($val->houseInfo))
        rent.push("{{$val->houseInfo->id}}");
        @endif
    @endforeach 
 @endif

 if(sale.length > 0 || rent.length > 0){
     $.post("/ajax/clickstatistic/display",{'sty':'expertstatus','sale':sale,'rent':rent,'_token':_token},function(m){
         
     });
 }


});

function saleClick(id){  // 出售房源点击量
    var sale = [];
    sale.push(id);
    var _token="{{csrf_token()}}";
    if(sale.length <= 0) return;
    $.post("/ajax/clickstatistic/click",{'sty':'expertstatus','sale':sale,'_token':_token},function(m){
         
     });
}

function rentClick(id){  // 出租房源点击量
    var rent = [];
    rent.push(id);
    var _token="{{csrf_token()}}";
    if(rent.length <= 0) return;
    $.post("/ajax/clickstatistic/click",{'sty':'expertstatus','rent':rent,'_token':_token},function(m){
         
     });
}
window.onload = function(){
  var oDiv = document.getElementById("msg_nav");
  var h = oDiv.offsetTop;
  document.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if(h <= t){
		oDiv.style.position = 'fixed';
		oDiv.style.top=0;
		$('#void').show();
	}else{
		oDiv.style.position = '';
		$('#void').hide();
	}
  }
};


function getSalePrice(g_communityid,saleRent,tempType2,busnessId)
{
  var type='1';
  if (saleRent=='sale') {
    type='2';
  }
 // var tempType2=$('#saleTagId .click').attr('id');
var _token=$('input[name="_token"]').val();
 $.post('/ajax/checkprice',{'busness':busnessId,'comid':g_communityid,'type':type,'ctype2':tempType2,'_token':_token,'room':'0'},function(d){
  showCharts(d.title,d.time,d.price,saleRent,tempType2);

},'json');

}

function showCharts (title,artime,arprice,saleRent,type2) {
//function showRentMap (arTime,arPrice,priceTitle) {
  //console.info(arprice);
  //$('#saleRoomPrice').html(title);
  //var priceTitle=title;
  //$('#communityChart').html('');
  var tagId='price_show';
  var danwei='元/平米';
  var toop='二手房均价';
  if (saleRent=="rent") {
    tagId='price_zu';
    if (parseInt(type2)>300) {
      danwei='元/月';
    }else
    {
      danwei='元/天/平米';
    }

    toop='租金';
  }


  $('#'+tagId).highcharts({
    title: { text:'', x: 0},
    // subtitle: { text: 'Source: WorldClimate.com', x: -20 },
    credits:enabled=false,
    xAxis: {
        categories: artime,
      tickInterval: 1,
      labels: {
        formatter: function () {
         return this.value.toString().substr(4,2)+"月";
       }
     }
   },
   yAxis: {
    title: { text: null },
    plotLines: [{ value: 0, width: 1, color: '#808080' }],
    lineWidth: 1,
    labels: {
      formatter: function () {
       return Highcharts.numberFormat(this.value,0,'.',',');
     }
   }


 },
  //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655','#FFF263', '#6AF9C4'] ,
  tooltip: {
      //valueSuffix: '元'
      formatter: function () {
        var tempvalue;
        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月<br/>'+toop +  this.y + ' '+danwei;
        return tempvalue;
      }
    },
    legend: {
      enabled: false,
      layout: 'horizontal',
      align: 'right',
      verticalAlign: 'top',
     // x: 250,
      //y: 10,
      borderWidth: 0,
      //lineHeight: 30,

    },

    series:arprice
    // series: [
    // { name: 'Tokyo', data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 0, 9.6] },
    // { name: 'New York', data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5] },
    // { name: 'Berlin', data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0] },
    //  // { data: arPrice }
    //  ]

  });
}

// 页面跳转
function redirect(str){
    window.location.href=str;
}
</script>
<script>
    //关注方法
    point_interest('focus','xcy');
</script>
<?php // 引入分享的js  ?>
@include('layout.share')
@endsection