@extends('mainlayout')
@section('title')
    <title>{{$communityName}}房价，{{$communityName}}房价走势，北京查房价</title>
    <meta name="keywords" content="{{$communityName}}房价，{{$communityName}}房价走势，{{$communityName}}房价信息"/>
    <meta name="description" content="搜房网-为您提供城市、楼盘相关物业类型价格走势，还为您提供房源价格估算！"/>
    <link rel="stylesheet" type="text/css" href="/css/house_loan.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
    {{--搜索栏 开始--}}
    <form name="priceSearch" method="post" action="/checkpricelist">
        <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="type" value=''>
        <input type="hidden" name="type1" value=''>
        <div class="catalog_nav no_float">
            <div class="margin_auto clearfix">
                <div class="list_sub">
                    <div class="list_search">
                        <input type="text" name='kw' class="txt border_blue" tp="esfsale" AutoComplete="off" placeholder="请输入关键字（楼盘名/地名等）" value="{{!empty($keyword)?$keyword:''}}" id="keyword">
                        <div class="mai mai1"></div>
                        <input type="submit" class="btn back_color keybtn" value="搜房">
                    </div>
                </div>
                <input type="hidden" id="searchStatus" value=1>
            </div>
        </div>
    </form>
    {{--搜索栏 结束--}}
    @include('layout.getVirtualphone')
    {{--您的位置 开始--}}
    <p class="route">
        <span>您的位置：</span>
        <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}">首页</a>
        <span>&nbsp;>&nbsp;</span>
        <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/saleesb/area" class="colorfe">{{CURRENT_CITYNAME}}楼盘</a>
    </p>
    {{--您的位置 结束--}}
    {{--楼盘信息 开始--}}
    <div class="list">
        <div class="list_l" style="border-top:0; margin-right:0;">
            <div class="build_price">
                <dl>
                    {{--楼盘详情左侧 开始--}}
                    <dt>
                        <h2>
                            <a href="/esfindex/{{$communityInfo->id}}/303.html" target="_blank">{{$communityInfo->name}}</a>
                        </h2>
                        <p class="p1">
                            <span>[{{$communityInfo->cityAreaName}}▪{{$communityInfo->businessAreaName}}]</span>
                            <span class="address">{{$communityInfo->address}}</span>
                        </p>
                        <p class="p2">
                            <span>售均价：<span class="colorfe">{{isset($communityInfo->priceSaleAvg3)?$communityInfo->priceSaleAvg3:'-'}}</span>元/平米</span>
                            <span>环比上月：
                                @if(isset($communityInfo->priceSaleInc3) && $communityInfo->priceSaleInc3>0)
                                    <span class="colorfe">{{$communityInfo->priceSaleInc3}}%↑</span>
                                @elseif(isset($communityInfo->priceSaleInc3) && $communityInfo->priceSaleInc3<0)
                                    <span class="color096">{{$communityInfo->priceSaleInc3}}%↓</span>
                                @else
                                    <span>-</span>
                                @endif
                            </span>
                            @if(isset($communityInfo->priceSaleYearInc))
                                <span>同比去年：<span class="colorfe">2.635%↑</span></span>
                            @endif
                        </p>
                        <p class="p2">
                            <span>租均价：<span class="colorfe">{{isset($communityInfo->priceRentAvg3)?$communityInfo->priceRentAvg3:'-'}}</span>元/月</span>
                            <span>环比上月：
                                @if(isset($communityInfo->priceRentInc3) && $communityInfo->priceRentInc3>0)
                                    <span class="colorfe">{{$communityInfo->priceRentInc3}}%↑</span>
                                @elseif(isset($communityInfo->priceRentInc3) && $communityInfo->priceRentInc3<0)
                                    <span class="color096">{{$communityInfo->priceRentInc3}}%↓</span>
                                @else
                                    <span>-</span>
                                @endif
                            </span>
                            @if(isset($communityInfo->priceRentYearInc))
                                <span>同比去年：<span class="colorfe">2.635%↑</span></span>
                            @endif
                        </p>
                        <p class="p3">
                            <span>出售：<a>{{$communityInfo->saleCount}}</a>套</span>
                            <span>出租：<a>{{$communityInfo->rentCount}}</a>套</span>
                        </p>
                        <p class="p4">
                            <a href="#">
                                <span class="focus" value="{{$communityInfo->id}},3,{{strtok($communityInfo->type1,'|')}},0"><i></i><span>{{$communityInfo->interested ? '已关注' : '关注'}}</span></span>
                            </a>
                            <a href="/houseHelp/sale/xq">我要卖房</a>
                            <a href="/wantSaleRent/esfsale">我要买房</a>
                        </p>
                    </dt>
                    {{--楼盘详情左侧 结束--}}

                    {{--楼盘详情右侧置业专家 开始--}}
                    <dd class="price_info" id="tab1">
                        {{--出租出售导航栏 开始--}}
                        {{--<div class="price_title title_nav">
                            <a class="click">出售</a>
                            <a>出租</a>
                        </div>--}}
                        {{--出租出售导航栏 结束--}}
                        {{--置业专家开始--}}
                        <div class="property_type sale_msg">
                            @if(!empty($realEstate))
                                @foreach($realEstate as $k1 => $v1)
                                    @if(!empty($v1->brokerInfo) && !empty($v1->houseInfo))
                                        <div class="expert {{($v1->position==2)?'marginLeft':''}}">
                                            <img src="{{get_img_url('userPhoto',$v1->brokerInfo->photo)}}"onerror="javascript:this.src='/image/default_broker.png';">
                                            <dl>
                                                <dt>
                                                    <a href="/housedetail/{{$v1->saleRentType=='sale'?'ss':'sr'}}{{$v1->houseInfo->id}}.html" onclick="saleClick({{$v1->houseInfo->id}})" target="_blank">{{$v1->houseInfo->title}}</a>
                                                </dt>
                                                <dd>
                                                    <div class="info_l">
                                                        @if($v1->houseInfo->houseType1 != 2)
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
                                                                <span>{{!empty($v1->houseInfo->currentFloor)?$v1->houseInfo->currentFloor:''}}/{{!empty($v1->houseInfo->totalFloor)?$v1->houseInfo->totalFloor:''}}</span>
                                                            </p>
                                                        @endif
                                                        <p class="p2">
                                                            <a href="/brokerinfo/{{$v1->brokerInfo->id}}.html" target="_blank">{{!empty($v1->brokerInfo->realName)?$v1->brokerInfo->realName:''}}</a>
                                                            <span class="margin_l">@if(property_exists($v1->brokerInfo,'businessArea')){{$v1->brokerInfo->businessArea}}@endif<span>{{!empty(\App\Http\Controllers\Utils\RedisCacheUtil::getEnterpriseshopNameByEId($v1->brokerInfo->enterpriseshopId))?(\App\Http\Controllers\Utils\RedisCacheUtil::getEnterpriseshopNameByEId($v1->brokerInfo->enterpriseshopId)):''}}</span></span>
                                                        </p>
                                                        <p class="p1">
                                                            <span>{{!empty($v1->brokerInfo->mobile)?$v1->brokerInfo->mobile:''}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="info_r" style="text-align: right;overflow: hidden;max-width:100px;">
                                                        @if(!empty($v1->houseInfo->price2))
                                                            <span class="price" style="max-width:100px;"><span>{{$v1->houseInfo->price2}}</span>万</span>
                                                        @else
                                                            <span class="price" style="max-width:100px;"><span>面议</span></span>
                                                        @endif
                                                        {{--<a onclick="getBrokerNumBr(0,{{$v1->uId}}, $(this))">免费通话</a>--}}
                                                        <span class="tel" style="display:none;position: relative;top: 8px;color:#0074e0;line-height:30px;font-size:14px;"></span>
                                                    </div>
                                                </dd>

                                            </dl>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        {{--置业专家end--}}
                        <a href="{{config('hostConfig.agr_host')}}" target="_blank">我也要出现在这里<<<</a>
                    </dd>
                    {{--楼盘详情右侧置业专家 结束--}}
                    <div class="clear"></div>
                </dl>
            </div>
        </div>
    </div>
    {{--楼盘信息 结束--}}
    {{--中间主体内容 开始--}}
    <div class="list">
        {{--左侧图表部分 开始--}}
        <div class="list_l" style="border-top:0;">
            {{--图表 开始--}}
            <div class="chart">
                {{--出售价格走势 开始--}}
                <div class="chart_tlt">
                    <span class="title">出售价格走势</span>
                    <div class="chart_nav sale">
                        <a id="community_type" class="click">楼盘</a>
                        <a id="busness_type">商圈</a>
                    </div>
                    <a class="link_list" href="/{{$houseUrlHost}}sale/area/ba{{$comid}}" target="_blank">查看本楼盘出售房源</a>
                </div>
                {{--出售图表 开始--}}
                <div class="chart_img a1" style="display: block;">
                    {{--显示房屋信息部分--}}
                    <div class="room">
                        {{--均价部分--}}
                        <div class="room_l" id="saleRoomPrice"></div>
                        {{--居室选择部分--}}
                        <div class="room_r" id="tag_sale"></div>
                    </div>
                    {{--显示走势图表部分--}}
                    <div id="communityChart" style="width:800px;height: 200px"></div>
                </div>
                {{--出售图表 结束--}}
                {{--出售价格走势 结束--}}
                {{--出租价格走势 开始--}}
                <div class="chart_tlt">
                    <span class="title">出租价格走势</span>
                    <div class="chart_nav rent">
                        <a id="community_type" class="click">楼盘</a>
                        <a id="busness_type" >商圈</a>
                    </div>
                    <a class="link_list" href="/{{$houseUrlHost}}rent/area/ba{{$comid}}" target="_blank">查看本楼盘出租房源</a>
                </div>
                {{--出租图表 开始--}}
                <div class="chart_img b1">
                    <p id="rentComPrice" class="rent_price" style="display: block;">
                    </p>
                    <div class="room">
                        <div class="room_l" id="rentRoomPrice">
                        </div>
                        <div class="room_r" id="tag_rent">
                        </div>
                    </div>
                    <div id="communityRentChart" style="width:800px;height: 200px"></div>
                </div>
                {{--出租图表 结束--}}
                {{--出租价格走势 结束--}}
            </div>
            {{--图表 结束--}}
        </div>
        {{--左侧图表部分 结束--}}
        {{--主体右侧部分 开始--}}
        <div class="list_r">
            {{--查房价 开始--}}
            <div class="check_title">
                <div class="check_type">
                    <p class="tlt">查房价</p>
                    <div class="search2">
                        <ul>
                            <li>
                                <label>楼&nbsp;&nbsp;栋&nbsp;号：</label>
                                <input type="text" class="txt width1">
                            </li>
                            <li>
                                <label>房&nbsp;&nbsp;间&nbsp;号：</label>
                                <input type="text" class="txt width1">
                            </li>
                            <li>
                                <label>朝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;向：</label>
                                <input type="text" id="faceTo" class="txt width1">
                            </li>
                            <li>
                                <label>建筑面积：</label>
                                <input type="text" id="areaId" class="txt width1">
                                <span>平米</span>
                            </li>
                            <li>
                                <label>总&nbsp;&nbsp;楼&nbsp;层：</label>
                                <input type="text" class="txt width1">
                            </li>
                            <li>
                                <label>户&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型：</label>
                                <input type="text" id="roomId" class="txt width2">
                                <span>室</span>
                                <input type="text" id="hallId" class="txt width2">
                                <span>厅</span>
                                <input type="text" id="guardId" class="txt width2">
                                <span>卫</span>
                            </li>
                        </ul>
                        <p class="check_btn">
                            <input type="button" class="btn back_color" value="开始查房价" onClick="searchPrice()">
                        </p>
                    </div>
                </div>
                <div class="jg" style="display:none;">
                </div>
            </div>
            {{--查房价 结束--}}
            {{--周边楼盘 开始--}}
            <div class="serach_libray">
                <div class="title">
                    周边楼盘
                    <p class="title_r">

                        <a class="click">二手房</a>
                        <a>租房</a>
                    </p>
                </div>
                <div class="periphery new">
                    <ul>
                        <li class="periphery_tlt">
                            <span class="width1">楼盘名称</span>
                            <span class="width2">价格(元/平方米)</span>
                            <span class="width3">环比</span>
                        </li>
                        @foreach ($oldCommunity as $newCom)
                            <li>
                                <a href="/esfindex/{{$newCom['id']}}/{{$newCom['type']}}.html"><span class="width1">{{$newCom["name"]}}</span></a>
                                <span class="width2">{{$newCom["price"]}}</span>
                                @if($newCom["increase"]>0)
                                    <span class="width3 color096">{{$newCom["increase"]}}↑</span>
                                @elseif ($newCom["increase"]<0)
                                    <span class="width3 color096">{{$newCom["increase"]}}↓</span>
                                @else
                                    <span class="width3 color096">{{$newCom["increase"]}}</span>
                                @endif

                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="periphery old" style="display:none;">
                    <ul>
                        <li class="periphery_tlt">
                            <span class="width1">楼盘名称</span>
                            <span class="width2">价格(元/月)</span>
                            <span class="width3">环比</span>
                        </li>

                        @foreach ($rentCommunity as $rentCom)
                            <li>
                                <a href="/esfindex/{{$rentCom['id']}}/{{$rentCom['type']}}.html"><span class="width1">{{$rentCom["name"]}}</span></a>
                                <span class="width2">{{$rentCom["price"]}}</span>
                                @if($rentCom["increase"]>0)
                                    <span class="width3 color096">{{$rentCom["increase"]}}↑</span>
                                @elseif ($rentCom["increase"]<0)
                                    <span class="width3 color096">{{$rentCom["increase"]}}↓</span>
                                @else
                                    <span class="width3 color096">{{$rentCom["increase"]}}</span>
                                @endif

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{--周边楼盘 结束--}}
        </div>
        {{--主体右侧部分 结束--}}
    </div>
    {{--中间主体内容 结束--}}
    {{--尾部推荐 开始--}}
    @if(isset($recommend) && isset($recommend['sale']) || isset($recommend) && isset($recommend['rent']))
    <div class="list" style="margin-bottom:20px;">
        <div class="list_l" style="border-top:0; margin-right:0;">
            <div class="build_house">
                <div class="nav_tlt home">
                    <span class="build_tlt">小区推荐房源</span>
                    <p class="house_nav fy">
                        @if(isset($recommend) && isset($recommend['sale']))
                        <a class="click">出售</a>
                        @endif
                        @if(isset($recommend) && isset($recommend['rent']))
                        <a @if(!isset($recommend['sale']))class="click"@endif>出租</a>
                        @endif
                    </p>
                </div>
                {{--出售--}}
                <div class="house_list margin_l a">
                    @if(isset($recommend) && isset($recommend['sale']))
                        @foreach($recommend['sale'] as $v)
                            <dl>
                                <dt>
                                    <a href="/housedetail/ss{{$v->id}}.html"><img src="{{get_img_url("houseSale", $v->thumbPic)}}"></a>
                                    <span class="price">{{$v->price2}}万</span>
                                </dt>
                                <dd>
                                    <p class="house_name"><a href="/housedetail/sr{{$v->id}}.html">{{$v->title}}</a></p>
                                    <p class="house_type">@if(isset($v->roomStr)  && strpos($v->roomStr,'_')){{explode('_',$v->roomStr)[0]}}室{{explode('_',$v->roomStr)[1]}}厅@endif {{$v->area}}平米</p>
                                </dd>
                            </dl>
                        @endforeach
                    @endif
                </div>
                {{--出租--}}
                <div class="house_list margin_l b" @if(isset($recommend) && isset($recommend['rent']) &&!isset($recommend['sale']))style="display:block;"@else style="display:none;"@endif>
                    @if(isset($recommend) && isset($recommend['rent']))
                        @foreach($recommend['rent'] as $v)
                            <dl>
                                <dt>
                                    <a href="/housedetail/sr{{$v->id}}.html"><img src="{{get_img_url("houseRent", $v->thumbPic)}}"></a>
                                    <span class="price">@if($v->price1==0) 价格面议 @else {{$v->price1}}{{\Config::get('houseState.rent.priceUnit')[$v->priceUnit]}} @endif</span>
                                </dt>
                                <dd>
                                    <p class="house_name"><a href="/housedetail/sr{{$v->id}}.html">{{$v->title}}</a></p>
                                    <p class="house_type">@if(isset($v->roomStr) && strpos($v->roomStr,'_')){{explode('_',$v->roomStr)[0]}}室{{explode('_',$v->roomStr)[1]}}厅@endif {{$v->area}}平米</p>
                                </dd>
                            </dl>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    {{--尾部推荐 结束--}}
    {{--新版JS 开始--}}
    <script src="../../js/jquery1.11.3.min.js"></script>
    <script src="../../js/specially/headNav.js"></script>
    <script>
        $(document).ready(function(e) {
            $(".fy a").click(function(){
                $(".fy a").removeClass("click");
                $(this).addClass("click");
                if($(this).text()=="出售"){
                    $(".build_house .a").show();
                    $(".build_house .b").hide();
                }else if($(this).text()=="出租")  {
                    $(".build_house .b").show();
                    $(".build_house .a").hide();
                }
            });
            $(".serach_libray .title a").click(function(){
                $(".serach_libray .title a").removeClass("click");
                $(this).addClass("click");
                if($(this).text()=="二手房"){
                    $(".new").show();
                    $(".old").hide();
                }else if($(this).text()=="租房")  {
                    $(".old").show();
                    $(".new").hide();
                }
            });

            $(".room a").click(function(){
                $(this).parent().find("a").removeClass("click");
                $(this).addClass("click");
            });
        });

        //置业专家JS
        /*$(function(){
            var i=0;//初始记录用户鼠标经过是第几个li
            var canmove=true;
            $('#tab1 .price_title a').click(function(){
                canmove=false;
                clearInterval(li_timer);
                i=$(this).index();
                $(this).addClass('click').siblings().removeClass('click');
                $('.sale_msg').hide();
                $('.sale_msg').eq(i).show();
            });
            $("#tab1").mouseenter(function(){//只要用户鼠标在这个tab1区域内，就不自动跳转
                canmove=false;
            }).mouseleave(function(){
                clearInterval(li_timer);
                setTimeout(function(){canmove=true;},4000);//两秒后自动切换
            });
            function li_timer(){
                if(canmove){
                    i++;
                    if(i==$('#tab1 .price_title a').length){
                        i=0;
                    }
                    $('#tab1 .price_title a').eq(i).addClass('click').siblings().removeClass('click');
                    $('.sale_msg').hide();
                    $('.sale_msg').eq(i).show();
                }
            }
            setInterval(li_timer,4000);//每两秒切换
        });*/
    </script>
    {{--新版JS 结束--}}
    {{--旧版JS 开始--}}
    <script src="/js/list.js?v={{Config::get('app.version')}}"></script>
    <script src="/js/PageEffects/houseScroll.js?v={{Config::get('app.version')}}"></script>
    {{--图表插件 开始 必须先加载Jquery--}}
    <script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>
    <script>
        var _token=$('input[name="_token"]').val();
        var g_communityid={{$comid}};
        var g_busness={{$businessAreaId}};
        var g_city={{$cityId}};

        function saleClick(id){  // 出售房源点击量
            var sale = [];
            sale.push(id);
            $.post("/ajax/clickstatistic/click",{'sty':'expertstatus','sale':sale,'_token':_token},function(m){

            });
        }
        function rentClick(id){  // 出租房源点击量
            var rent = [];
            rent.push(id);
            $.post("/ajax/clickstatistic/click",{'sty':'expertstatus','rent':rent,'_token':_token},function(m){

            });
        }
        $(document).ready(function(e) {
            //尾部推荐房源JS
            $(".fy a").click(function(){
                $(".fy a").removeClass("click");
                $(this).addClass("click");
                if($(this).text()=="二手房"){
                    $(".build_house .a").show();
                    $(".build_house .b").hide();
                }else if($(this).text()=="出租")  {
                    $(".build_house .b").show();
                    $(".build_house .a").hide();
                }
            });

            //楼盘价格图表
            $(".sale a").click(function(){
                $(".sale a").removeClass("click");
                $(this).addClass("click");
                var dataType=$(this).attr('id');
                var tempType2=$('#saleTagId .click').attr('id');
                var room='2';
                if (parseInt(tempType2)==304) {
                    room='3';
                }
                getSalePrice(g_communityid,g_busness,dataType,g_city,'2','sale',room);
            });
            $(".rent a").click(function(){
                $(".rent a").removeClass("click");
                $(this).addClass("click");
                var dataType=$(this).attr('id');
                var tempType2=$('#saleTagId .click').attr('id');
                var room='2';
                if (parseInt(tempType2)==304) {
                    room='3';
                }
                getSalePrice(g_communityid,g_busness,dataType,g_city,'1','rent',room);
            });
            $(".serach_libray .title a").click(function(){
                $(".serach_libray .title a").removeClass("click");
                $(this).addClass("click");
                if($(this).text()=="二手房"){
                    $(".new").show();
                    $(".old").hide();
                }else if($(this).text()=="租房")  {
                    $(".old").show();
                    $(".new").hide();
                }
            });
            $(".room .room_r a").click(function(){
                $(this).parent().find("a").removeClass("click");
                $(this).addClass("click");
                var room=getRoomByTag($(this).text());
                var type='2';
                var datatype= $(".sale a .click").attr('id');
                var saleRent='sale';
                if ($(this).parent().attr('id')=='tag_rent') {
                    type='1';
                    datatype= $(".rent a .click").attr('id');
                    saleRent='rent';
                }
                getSalePrice(g_communityid,g_busness,datatype,g_city,type,saleRent,room);
            });
            //楼盘或商圈点击
            // $('#datatypeid a').click(function(){
            //   var strDataType=$(this).attr('id');
            //   console.info(strDataType);
            // });
            //点击Tag
            $('#saleTagId span').click(function(){
                $('#saleTagId span').removeClass('click');
                $(this).addClass('click');

                var currentType=parseInt($(this).attr('id'));

                if (currentType<300) {
                    $('.sale').hide();
                    $('.rent').hide();
                }else
                {
                    $('.sale').show();
                    $('.rent').show();
                }
                $(".sale a").first().click();
                $(".rent a").first().click();
            });
            if ($('#saleTagId span').first().length>0) {
                $('#saleTagId span').first().click();
            }else
            {
                $('.sale a').first().click();
                $('.rent a').first().click();
            }
        });
        function getRoomByTag(strTag)
        {
            if (strTag=='一居') {
                return '1';
            }else if(strTag=='二居') {
                return '2';
            }else if(strTag=='三居') {
                return '3';
            }else if(strTag=='四居') {
                return '4';
            }else if(strTag=='五居') {
                return '5';
            }else if(strTag=='六居') {
                return '6';
            }else if(strTag=='七居') {
                return '7';
            }else if(strTag=='八居') {
                return '8';
            }return '2';
        }
        //查房价
        function searchPrice()
        {
            var area=$('#areaId').val();
            var room=$('#roomId').val();
            var faceto=$('#faceTo').val();
            var comName=$('.name a').first().text();
            var re = /^[1-9]+[0-9]*]*$/  ;
            if (!re.test(area)) {
                alert('建筑面积格式不正确！');
                return;
            }
            var type2='301';
            if ($('#saleTagId span').first().length>0) {
                type2=$('#saleTagId span').first().attr('id');
            }
            $.post('/ajax/scprice',{'community':g_communityid,'type2':type2,'_token':_token},function(d){
                var strData='<p class="tlt">查房价<a onClick="$(\'.check_type\').show();$(\'.jg\').hide();">返回</a></p>';
                strData+='<dl><dt>'+comName+'</dt><dd><span>面积：'+area+'平米</span>';
                if (faceto!='') {
                    strData+='<span>朝向：'+faceto+'</span>';
                }
                strData+='</dd></dl><dl><dt><span class="font_size colorfe">'+Math.round(parseInt(d.price)*area/10000) +'</span><span class="font_size1">万元</span></dt>'
                strData+='<dd><span>单价&nbsp;'+d.price+'元/平米</span></dd>';
                $('.jg').html(strData);
                $('.check_type').hide();
                $('.jg').show();
            },'json');
        }
        /*显示房价图表*/
        function getSalePrice(g_communityid,g_busness,datatype,g_city,type,saleRent,room)
        {
            var tempType2=$('#saleTagId .click').attr('id');
            var rentUnit='元/月';
            if (parseInt(tempType2)<300) {
                rentUnit='元/天/平米';
            }
            $.post('/ajax/checkprice',{'comid':g_communityid,'type':type,'ctype2':tempType2,'busness':g_busness,'datatype':datatype,'city':g_city,'_token':_token,'room':room},function(d){
                if (saleRent=='sale') {
                    showCharts(d.title,d.time,d.price);
                }else
                {
                    showRentCharts(d.title,d.time,d.price,rentUnit);
                }
                var roomTagHtml='';
                var beSelect=false;
                for (var i = 0;i<d.roomTags.length ; i++) {
                    if (d.curtRoom==d.roomTags[i]) {
                        beSelect=true;
                        roomTagHtml+='<a class="click" onClick="clickRoomTag(this)"><span>'+d.roomTags[i]+'</span><i></i></a>';
                    }else
                    {
                        roomTagHtml+='<a onClick="clickRoomTag(this)"><span>'+d.roomTags[i]+'</span><i></i></a>';
                    }
                }
                if (saleRent=='sale') {
                    $('#tag_sale').html(roomTagHtml);
                    if(!beSelect&&$('#tag_sale a').first().length>0)
                    {
                        $('#tag_sale a').first().addClass('click');
                    }
                }else
                {
                    $('#tag_rent').html(roomTagHtml);
                    if(!beSelect&&$('#tag_rent a').first().length>0)
                    {
                        $('#tag_rent a').first().addClass('click');
                    }
                }
                //bindRoomTag();
            },'json');
        }
        function clickRoomTag(obj)
        {
            $(obj).parent().find("a").removeClass("click");
            $(obj).addClass("click");
            var room=getRoomByTag($(obj).text());
            var type='2';
            var datatype= $(".sale .click").attr('id');
            var saleRent='sale';
            if ($(obj).parent().attr('id')=='tag_rent') {
                type='1';
                datatype= $(".rent .click").attr('id');
                saleRent='rent';
            }
            getSalePrice(g_communityid,g_busness,datatype,g_city,type,saleRent,room);
        }

        function showCharts (title,artime,arprice) {
            $('#saleRoomPrice').html(title);
            //var priceTitle=title;
            $('#communityChart').html('');
            $('#communityChart').highcharts({
                title: { text:'', x: 0},
                // subtitle: { text: 'Source: WorldClimate.com', x: -20 },
                credits:enabled=false,
                xAxis: { categories: artime,
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
                tooltip: {
                    //valueSuffix: '元'
                    formatter: function () {
                        var tempvalue;
                        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' 元/平米';
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
            });
        }
        function showRentCharts (title,artime,arprice,Unit) {
            //function showRentMap (arTime,arPrice,priceTitle) {
            // console.info(arprice);
            $('#rentRoomPrice').html(title);
            //var priceTitle=title;
            $('#communityRentChart').html('');
            $('#communityRentChart').highcharts({
                title: { text:'', x: 0},
                // subtitle: { text: 'Source: WorldClimate.com', x: -20 },
                credits:enabled=false,
                xAxis: { categories: artime,
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
                tooltip: {
                    formatter: function () {
                        var tempvalue;
                        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' '+Unit;
                        return tempvalue;
                    }
                },
                legend: {
                    enabled: false,
                    layout: 'horizontal',
                    align: 'right',
                    verticalAlign: 'top',
                    borderWidth: 0,

                },
                series:arprice
            });
        }
    </script>
    {{--图表插件 结束 必须先加载Jquery--}}
    <script src="/js/sflogger.js" type="text/javascript"></script>
    {{--旧版JS 结束--}}
    {{--楼盘关注js--}}
    <script src="/js/point_interest.js" type="text/javascript"></script>
    <script type="text/javascript">
        //点击楼盘关注方法
        point_interest('focus','xcy');
    </script>
@endsection