@extends('h5.mainlayout')
@section('title')
<title>@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif楼盘详情-搜房网</title>
@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="/h5/css/Propertydetail.css"/>
<script src="/h5/js/common/zepto.js"></script>
<script src="/h5/js/banner.js" type="text/javascript" charset="utf-8"></script>
<!-- <link rel="stylesheet" type="text/css" href="/h5/css/index.css" /> -->
@endsection
@section('content')
@include('h5.share.share')
<!-- header部分 -->
<div class="header">
    <div class="header_lf fl"><a href="javascript:window.history.go(-1)"></a></div>
    <p class="header_tit fl">楼盘详情</p>
    <span class="header_like fl"><a href="javascript:void(0);" id="share"></a></span>
    <b class="header_share fr"><a href="/"></a></b>
</div>
<!-- <div class="space24"></div> -->
<!-- banner部分 -->
<div class="bannerBox">
    <div class="clickEnlarge">
        <div class="swiper-container detailPage">
            <div class="swiper-wrapper">                       
                @if(!empty($communityImages))
                @foreach($communityImages as $k=>$communityImage)
                <div class="swiper-slide"><img src="{{get_img_url('commPhoto',$communityImage->fileName)}}"/></div>
                @endforeach
                @else
                <div class="swiper-slide"><img src="/h5/image/banner1.jpg"/></div>
                @endif
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-fraction swiper-page"></div>
        </div>
    </div>
    <div class="bannerError"></div>
</div>
<!--查看户型-->
<div class="checkBanner">
    <div class="checkEnlarge">
        <div class="swiper-container detailPage">
            <div class="swiper-wrapper">
                @if(!empty($communityroom))
                @foreach($communityroom as $k=>$cr)
                @if(!empty($cr->thumbPic))
                <div class="swiper-slide"><img src="{{get_img_url('room',$cr->thumbPic)}}"/></div>
                @endif
                @endforeach
                @endif
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-fraction swiper-page"></div>
        </div>
    </div>
    <div class="bannerError"></div>
</div>
<!--==================内容区域，获取数据开始==========================================-->
<div class="wrapper">
    <div class="scroll-wrap content scroller ">
        <div class="content_box">
            <span class="box_active ps"></span>
            <!-- <div class="space24"></div> -->
            <div class="detail_banner">
                <div class="swiper-container detailPage">
                    <div class="swiper-wrapper">
                        @if(!empty($communityImages))
                        @foreach($communityImages as $k=>$communityImage)
                        <div class="swiper-slide"><img src="{{get_img_url('commPhoto',$communityImage->fileName)}}"/></div>
                        @endforeach
                        @else
                        <div class="swiper-slide"><img src="/h5/image/banner1.jpg"/></div>
                        @endif
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination swiper-page"></div>
                </div>
            </div>
            <!-- content部分 -->

            <div class="main_infor">
                <h2 class="infor_tit">@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif<span class="hTitsubway" style="color:#3281f6; font-size:24px; font-weight:normal; display:inline-block;">{{$viewShowInfo['type1Name']}}</span></h2>
                <!-- <span class="collect c_active ps"><a href="##" id="collect"></a><i>关注</i></span> -->
                <div class="infor_pice">
                    <h3 class="infor_pic fl"><i style="font-size:26px; color:#2D2D2D;line-height:56px;">最低价格:</i>@if(!empty($viewShowInfo['saleMinPrice'])) {{floor($viewShowInfo['saleMinPrice'])}} <em class="infor_unit">元/㎡</em>@else <em class="infor_unit">待定</em> @endif</h3>
                    <a class="infor_lator fr" href="/calc"></a>
                </div>
                <div class="infor_ads">
                    <p>开盘:&nbsp;@if(!empty($viewShowInfo['startTime'])) {{$viewShowInfo['startTime']}} @else 暂无数据 @endif</p>
                    <p>地址:&nbsp;
                        @if(!empty($viewShowInfo['cityAreaName']) || !empty($viewShowInfo['businessName']))
                        [@if(!empty($viewShowInfo['cityAreaName'])) {{$viewShowInfo['cityAreaName']}} @endif @if(!empty($viewShowInfo['businessName']))- {{$viewShowInfo['businessName']}} @endif]
                        @endif
                        @if(!empty($viewShowInfo['address'])) {{$viewShowInfo['address']}} @endif
                    </p>
                    <p>开发商:@if(!empty($viewShowInfo['developerName'])) {{$viewShowInfo['developerName']}} @else 暂无数据 @endif </p>
                </div>
            </div>
            <div class="main_apart">
                    <div class="apart_tit"><h3>主力户型</h3><!--<i>查看全部</i>--></div>
                <div class="apart_left">
                    <div class="swiper-container">
                        <div class="swiper-wrapper checkSlide">
                            @if(!empty($communityroom))
                            @foreach($communityroom as $cr)
                            <div class="swiper-slide">
                                @if(!empty($cr->thumbPic))
                                <img src="{{get_img_url('room',$cr->thumbPic)}}"/>
                                @endif
                                <p class="detail_tit">
                                    @if(!empty($cr->room && $cr->hall))
                                    {{$cr->room}}室{{$cr->hall}}厅
                                    @else
                                    暂无户型信息
                                    @endif
                                </p>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="main_detail">
                <h3>详细信息</h3>
                @if(!empty($viewShowInfo['takeTime']))
                <p>交房时间:&nbsp;<b>{{$viewShowInfo['takeTime']}}</b></p>
                @endif
                @if(!empty($viewShowInfo['type2Name']))
                <p>物业类型:&nbsp;<b>{{$viewShowInfo['type2Name']}}</b></p>
                @endif
                @if(!empty($type2GetInfo->propertyYear))
                <p>产权年限:&nbsp;<b>{{$type2GetInfo->propertyYear}}年</b></p>
                @endif
                @if(!empty($viewShowInfo['decoration']))
                <p>装修类型:&nbsp;<b>{{$viewShowInfo['decoration']}}</b></p>
                @endif
                @if(!empty($viewShowInfo['propertyName']))
                <p>物业公司:&nbsp;<b>{{$viewShowInfo['propertyName']}} </b></p>
                @endif
                @if(!empty($type2GetInfo->houseTotal))
                <p>&nbsp;&nbsp;&nbsp;总户数:<b>@if(!empty($type2GetInfo->houseTotal)) {{$type2GetInfo->houseTotal}}户 @endif @if(!empty($viewShowInfo['houseNum'])) 当期户数:{{$viewShowInfo['houseNum']}}户 @endif</b></p>
                @endif
                @if(!empty($type2GetInfo->propertyFee))
                <p>&nbsp;&nbsp;&nbsp;物业费:<b> {{$type2GetInfo->propertyFee}}元/平米·月 </b></p>
                @endif
                @if(!empty($type2GetInfo->greenRate))
                <p>&nbsp;&nbsp;&nbsp;绿化率:&nbsp;<b>{{$type2GetInfo->greenRate}}%</b></p>
                @endif
                @if(!empty($type2GetInfo->volume))
                <p>&nbsp;&nbsp;&nbsp;容积率:&nbsp;<b>{{$type2GetInfo->volume}}%</b></p>
                @endif
                @if(!empty($viewShowInfo['developerName']))
                <p>&nbsp;&nbsp;&nbsp;开发商:&nbsp;<b>{{$viewShowInfo['developerName']}}</b></p>
                @endif
            </div>	
            <!--<div class="main_new">
                    <div class="apart_tit"><h3>最新动态</h3><i>共计58条</i></div>
                    <p class="new_con fl">年终大促销，富丽阳光美园楼盘面对市场推出了多套优惠方案。买100平送15平。限时特卖</p>
            </div>-->
            <div class="main_desc">
                <h2>最新动态</h2>                    
                <div id="js-meanu2">
                    @if(!empty($commStatus))
                    @foreach($commStatus as $k=>$commStatu)
                    <p id="panel2">{{$commStatu->description}}</p>
                    @endforeach
                    @else
                    <p id="panel2">暂无最新动态</p>
                    @endif
                </div>
                @if(!empty($commStatus))
                <h6 id="js-slide2">展开</h6>
                @endif
            </div>
            <!-- <div class="main_review">
                 <div class="apart_tit"><h3>房价走势</h3></div>
                 <div class="secound_one">
                     <i>均价(㎡)</i></br>
                     <i  id="saleRoomPrice" style="width:200px; line-height:40px;display:inline-block!important; padding-left:10px; font-style:normal;
                         "></i>

                     <div class="chart" style="height: 200px" id="communityChart">

                     </div>-->
            <!-- <div class="chart_img">
                <div class="room">
                    <div class="room_l" id="saleRoomPrice">                                       
                    </div>
                    <div class="room_r" id="tag_sale">
                    </div>
                </div>
            </div> 
            <div id="communityChart" style="height: 200px" class="plot"></div> -->
            <!-- </div>
         </div>-->
            <div class="main_postion">
                <h2>地理位置</h2>
                <p>地址:{{$viewShowInfo['address']}}<i></i></p>
                <div id="container" class="mapContainer"></div>
            </div>
            <div class="main_support">
                <h2>@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif周边配套</h2>
                <ul class="support_list">
                    <li class="bgc1"><span class="active"  attr="公交"></span></li>
                    <li class="list_first bgc2" ><span attr="医院"></span></li>
                    <li class="list_first bgc3" ><span attr="购物"></span></li>
                    <li class="list_first bgc4" ><span attr="银行"></span></li>
                    <li class="list_first bgc5" ><span attr="餐饮"></span></li>
                    <li class="list_first bgc6" ><span attr="教育"></span></li>
                </ul>
                <div class="support_menu" id="js-menu">
                    <ul class="down_list" id="panel">
                        <!-- <li><em>808路</em><b>246米</b></li> -->
                        <!-- <li><em>902路</em><b>436米</b></li>
                        <li><em>58路</em><b>568米</b></li>
                        <li><em>808路</em><b>246米</b></li>
                        <li><em>902路</em><b>436米</b></li>
                        <li><em>58路</em><b>568米</b></li> -->
                    </ul>
                    <span id="js-slide">展开</span>
                </div>

            </div>
            <!--===================================周边楼盘==================================-->            
            @if(!empty($commAround))
            <?php $houseDao = new \App\Dao\Agent\HouseDao;?>
            <div class="index_hot">
                <ul class="index_Hlist">
                    <li class="scroll_list">
                        <h2>@if(!empty($viewShowInfo['communityName'])) {{$viewShowInfo['communityName']}} @endif周边楼盘</h2>
                    </li>
                    <?php $i = 0; ?>
                    @foreach($commAround as $build)
                    <?php
                    //if (empty($type2)) {
                        $type2 = '';
                        if (!empty($build->_source->type1)) {
                            $ctype1 = substr($build->_source->type1, 0, 1);
                            foreach (explode('|', $build->_source->type2) as $ctype2) {
                                if ($ctype1 == substr($ctype2, 0, 1)) {
                                    $type2 = $ctype2;
                                    break;
                                }
                            }
                        }
                    //}
                    if (!empty($type2)) {
                        $typeInfo = 'type' . $type2 . 'Info';
                        if (!empty($build->_source->$typeInfo)) {
                            $typeInfo = json_decode($build->_source->$typeInfo);
                        }
                    }
                    $priceAvgtype2 = 'priceSaleAvg' . $type2;
                    $priceAvg = 'priceSaleAvg' . substr($type2, 0, 1);
                    $i++;
                    if ($i > 3) {
                        break;
                    }
                    ?>
                    <li class="index_footer">
                        <a href="/xinfindex/{{$build->_source->id}}/{{$type2}}.html">
                            <img src="@if(!empty($build->_source->titleImage)){{get_img_url('commPhoto',$build->_source->titleImage)}}@else{{$defaultImage}}@endif"/>
                            <div class="index_Hmain fl">
                                <h3>{{$build->_source->name}}</h3>
                                <h6>
                                    @if(!empty($cityAreas[$build->_source->cityAreaId]) || !empty($businessAreas[$build->_source->businessAreaId]))
                                    [{{!empty($build->_source->cityAreaId)?@$cityAreas[$build->_source->cityAreaId]:''}}{{!empty($build->_source->businessAreaId)?'-'.@$businessAreas[$build->_source->businessAreaId]:''}}]
                                    @endif
                                    @if(!empty($build->_source->address))
                                    {{$build->_source->address}}
                                    @endif
                                </h6>
                                <ul>
                                    <li>1室({{!empty($build->_source->saleCountRoom1)?$build->_source->saleCountRoom1:0}})<i>|</i></li>
                                    <li>2室({{!empty($build->_source->saleCountRoom2)?$build->_source->saleCountRoom2:0}})<i>|</i></li>
                                    <li>3室({{!empty($build->_source->saleCountRoom3)?$build->_source->saleCountRoom3:0}})<i>|</i></li>
                                    <li>4室({{!empty($build->_source->saleCountRoom4)?$build->_source->saleCountRoom4:0}})</li>
                                </ul>
                                <div class="house_Chouse fl">
                                    <?php $x = 1; ?>
                                    @if(!empty($typeInfo->tagIds))
                                    @foreach(explode('|',$typeInfo->tagIds) as $k=>$tagid)
                                        @if(!empty($featurestag[$tagid]))
                                        <span class="tag{{$x}}">{{$featurestag[$tagid]}}</span>
                                        <?php
                                        $x++;
                                        if ($x > 3)
                                            break;
                                        ?>
                                        @endif
                                    @endforeach
                                    @endif
                                    @if(!empty($typeInfo->diyTagIds))
                                    <?php $tid = explode('|',$typeInfo->diyTagIds);?>                                                                                    
                                        @if(!empty($diynames = $houseDao->getDiyTagByIds($tid)))                                        
                                            @foreach($diynames as $diyname) 
                                            <?php if ($x > 3) break;$x++; ?>
                                            @if(!empty($diyname->name))
                                            <span class="tag{{$x}}">{{$diyname->name}}</span>    
                                            @endif
                                            @endforeach
                                        @endif
                                    @endif
                                    <!-- <span class="house_Croom fl">学区房</span><span class="house_Cdup fl">复式</span><span class="house_Csub fl">地铁房</span> -->
                                </div>
                            </div>
                            <h6 class="prot_Pic">
                                @if(!empty($build->_source->$priceAvgtype2))
                                <b>均价</b><span class="average"><i>{{$build->_source->$priceAvgtype2}}</i><em>元/平</em></span>
                                @elseif(!empty($around->_source->$priceAvg))
                                <b>均价</b><span class="average"><i>{{$build->_source->$priceAvg}}</i><em>元/平</em></span>
                                @else
                                <b>均价</b><span class="average"><i>待定</i><em></em></span>
                                @endif
                            </h6>
                        </a>
                    </li>
                    @endforeach
                    <!-- <li style="width:100%; height:60px;"></li> -->
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
<!--==================内容区域，获取数据结束==========================================-->
<!--==================内容区域，获取数据结束==========================================-->
<div class="space32 ps"></div>
<!-- 获取安全号码模态框部分 -->
<div class="modalBox">
<div class="modal_box">
    <div class="box_infor">
        <span class="box_btn"></span>
        <h3>搜房提醒您</h3>
        <p>手机号验证后，您将获得与置业顾问联系的安全号码，此号码只关联为您服务的置业顾问，其他个人或团体都不能通过安全号码与您联系，更不会得到您真实的手机号码。安全号码为153591号段，请您放心使用！
        </p>
        <form>
            <label>手机号&nbsp;</label><input type="phone" name="phone" id="phone" placeholder="请输入手机号" class="number" onkeyup="this.value = this.value.replace(/\D/g, ''); checkUserPhone(this.value)"/>
            <label>验证码&nbsp;</label><input type="num" name="num" id="num" placeholder="验证码" class="num" onkeyup="this.value = this.value.replace(/\D/g, ''); chcekymd()"/>
            <em id="btn_quickLogin">获取验证码</em>
            <!-- <span class="color" id="msphonequickLoginMobile" style='display: none'></span> -->
            <p onclick="rsubmit_quickMobile()">提交</p>
            <input type="hidden" name="virtualphone_token" id="virtualphone_token" value="{{csrf_token()}}" />
            <input type="hidden" name="brokerId_quickLoginMobile" id="brokerId_quickLoginMobile" value="" />
        </form>            
    </div>
    <p class="information">信息填写错误</p>
</div>
</div>
<!-- footer部分 -->
@if(!empty($brokersMessage))
<?php $x = 1; ?>
<div class="footer" id="brokersMessage">
    @foreach($brokersMessage as $data)
    <a href="#" class="aImg"><img src="{{get_img_url('userPhoto',$data->photo)}}"/></a>        
    <div class="footer_phone">
        <a class="aTit"><i>{{(!empty($data->realName)) ? str_limit($data->realName, $limit = 8, $end = '...') : '匿名'}}</i>
           {{-- @if(!empty($enterpriseshopName)) --}}
           {{-- <span>({{str_limit($enterpriseshopName,$limit = 14, $end = '...')}})</span> --}}
            {{--@else--}}
            {{--<span>(经纪人)</span>--}}
            {{--@endif--}}
            <span></span>
        </a>
        <a class="aTit"><i>电话:</i><span>{{$data->mobile}}</span></a>
    </div>
    {{--<a href="#" class="footer_btn" onclick="phoneNum({{$communityId}},{{$data->id}});">点击获取安全号码</a>--}}
    <?php
    $x++;
    if ($x > 1)
        break;
    ?>
    @endforeach
</div>
@endif
<script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>
<input type="hidden" name="jingduMap" value="{{$jingduMap}}">
<input type="hidden" name="weiduMap" value="{{$weiduMap}}">
<input type="hidden" id="_token" value="{{ csrf_token() }}" >
<script src="/h5/js/common/iscroll.js" type="text/javascript"></script>
<script src="/h5/js/common/iscroll-probe.js"  type="text/javascript"></script>
<script type="text/javascript">
    var brokersMessage = document.getElementById("brokersMessage");
    if(brokersMessage == null){
        $(".wrapper .scroller").css('height',3354);
    }
    //$(".wrapper .scroller")
   // var myScroll1;
    //function loaded () {
       // var pageWrapper = $(".wrapper");
       // myScroll1 = new IScroll('.scroller', { mouseWheel: true });   
    //}
   // loaded();
</script>

<!--房价走势js-->
<script type="text/javascript">
            var g_communityid = {{$communityId}};
            var tempType2 = {{$type2}};
            var busnessId = {{$viewShowInfo["busnessId"]}};
            var _token = $('#_token').val();
            $(document).ready(function(e) {
    var dataType = 'community_type';
            getSalePrice(g_communityid, 'sale', tempType2, '2', dataType, busnessId);
    });
            function getRoomByTag(strTag)
            {
            if (strTag == '一居室') {
            return '1';
            } else if (strTag == '二居室')
            {
            return '2';
            } else if (strTag == '三居室')
            {
            return '3';
            } else if (strTag == '四居室')
            {
            return '4';
            } else if (strTag == '五居室')
            {
            return '5';
            } else if (strTag == '六居室')
            {
            return '6';
            } else if (strTag == '七居室')
            {
            return '7';
            } else if (strTag == '八居室')
            {
            return '8';
            }
            return '2';
            }

    function clickRoomTag(obj)
    {

    $(obj).parent().find("a").removeClass("click");
            $(obj).addClass("click");
            room = getRoomByTag($(obj).text());
            var dataType = $('.price_chart .click').attr('id');
            getSalePrice(g_communityid, 'sale', tempType2, room, dataType);
    }

    function getSalePrice(g_communityid, saleRent, tempType2, room, datatype, busnessId)
    {
    var type = '1';
            if (saleRent == 'sale') {
    type = '2';
    }
    // var tempType2=$('#saleTagId .click').attr('id');

    $.post('/ajax/checkprice', {'comid':g_communityid, 'busness':busnessId, 'type':type, 'ctype2':tempType2, 'datatype':datatype, '_token':_token, 'room':room, 'benew':'1'}, function(d){
    // console.info(d);
    if (saleRent == 'sale') {
    showCharts(d.title, d.time, d.price, '元/平米');
    } else
    {
    showCharts(d.title, d.time, d.price, '元/月');
    }
    var roomTagHtml = '';
            for (var i = 0; i < d.roomTags.length; i++) {
    if (d.curtRoom == d.roomTags[i]) {
    roomTagHtml += '<a class="click" onClick="clickRoomTag(this)">' + d.roomTags[i] + '</a>';
    } else
    {
    roomTagHtml += '<a onClick="clickRoomTag(this)">' + d.roomTags[i] + '</a>';
    }

    }


    $('#tag_sale').html(roomTagHtml);
    }, 'json');
    }

    function showCharts (title, artime, arprice, tag) {
    $('#saleRoomPrice').html(title);
            var title = $(".w1 .font_size").text() + '元/月';
            $('#saleRoomPrice').html(title);
            //var priceTitle=title;
            $('#communityChart').html('');
            $('#communityChart').highcharts({
    title: { text:'', x: 0},
            // subtitle: { text: 'Source: WorldClimate.com', x: -20 }, 
            credits:enabled = false,
            xAxis: { categories: artime,
                    tickInterval: 1,
                    labels: {
                    formatter: function () {
                    return this.value.toString().substr(4, 2) + "月";
                    }
                    }
            },
            yAxis: {
            title: { text: null },
                    plotLines: [{ value: 0, width: 1, color: '#808080' }],
                    lineWidth: 1,
                    labels: {
                    formatter: function () {
                    return Highcharts.numberFormat(this.value, 0, '.', ',');
                    }
                    }


            },
            //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655','#FFF263', '#6AF9C4'] ,
            tooltip: {
            //valueSuffix: '元'
            formatter: function () {
            var tempvalue;
                    tempvalue = this.x.toString().substr(0, 4) + '年' + this.x.toString().substr(4, 2) + '月' + this.series.name + '<br/>' + this.y + ' ' + tag;
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
</script>

<!--地图js-->
<script type="text/javascript">
    var longitude = $('input[name="jingduMap"]').val();
            var latitude = $('input[name="weiduMap"]').val();
            var comname = "{{!empty($viewShowInfo['communityName'])?$viewShowInfo['communityName']:'暂无楼盘名称'}}";
            $(function() {
            setTimeout("chechData('公交')", 1000);
            });
            //通过楼盘经纬度获取定位
            if (longitude != '' && latitude != '') {
    var map = new AMap.Map('container', {
    resizeEnable: true,
            zoom: 15,
            center: [longitude, latitude]
    });
            var marker = new AMap.Marker({
            //icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
            position: [longitude, latitude]
            });
            marker.setMap(map);
            var infoWindow = new AMap.InfoWindow({
            content: "<div style=\"width:200px\">楼盘名称 : " + comname + "</div>",
                    size: new AMap.Size(200, 0),
                    autoMove: true,
                    offset: new AMap.Pixel(0, - 30)
            });
            infoWindow.open(map, marker.getPosition());
            //周边点击
            $('.support_list li span').bind('click', function() {
    var data1 = $(this).attr('attr');
            chechData(data1);
            $('.support_list li span').removeClass('active');
            $(this).addClass('active');
    });
            function chechData(data1) {
            map.clearMap();
                    AMap.service(["AMap.PlaceSearch"], function() {
                    var placeSearch = new AMap.PlaceSearch({//构造地点查询类
                    pageSize: 5,
                            type: data1,
                            pageIndex: 1,
                            //city: "010", //城市
                            map: map,
                            panel: "panel"
                    });
                            var cpoint = [longitude, latitude]; //中心点坐标
                            placeSearch.searchNearBy('', cpoint, 5000, function(status, result) {
                            map.setZoom(15);
                            if (result.info == 'OK'){
                            $('.poi-more').hide(); //详情链接隐藏
                                    $('.poibox').hide();
                                    //map.panBy(-200,0);
                                    var html = '';
                                    var res = result.poiList.pois;
                                    for (var k in res){
                            var lng = res[k].location.lng;
                                    var lat = res[k].location.lat;
                                    html += "<li onclick='openMarkerTipById1(" + lng + ',' + lat + ")'><em>" + res[k].name + "</em><b>" + res[k].address + "</b></li>";
                                    addmarker(k, [res[k].location.lng, res[k].location.lat, res[k].name, res[k].address]);
                            }                                                                    
                            $("#panel").html(html);
                                    //地图点击周边配套后始终显示为'展开'
                                    $('#js-menu').css('height', '144');
                                    $('#js-slide').html('展开');
                                    if(res.length<=3 || res == ""){
                                        $('#js-slide').hide();     //隐藏展开                             
                                    }else{
                                        $('#js-slide').show(); 
                                    }
                            }else{
                                $('#js-slide').hide();
                            }
                            });
                    });
            }
    } else {
    $('#container').html('<h1>该楼盘未设定坐标点,无法展示地图信息</h1>')
            }
    $('.main_postion img')[0].style.display = "none";
            var windowsArr = new Array();
            var marker1 = new Array();
            //添加marker&infowindow
                    function addmarker(i, d) {
                    var lngX = d[0];
                            var latY = d[1];
                            var iName = d[2];
                            var iAddress = d[3];
                            var markerOption = {
                            map:map,
                                    //icon:"http://webapi.amap.com/images/" + (parseInt(i) + 1) + ".png",
                                    content:'<div class=\"amap_lib_placeSearch_poi\">' + (parseInt(i) + 1) + '</div>',
                                    position:new AMap.LngLat(lngX, latY)
                            };
                            var mar = new AMap.Marker(markerOption);
                            marker1.push(new AMap.LngLat(lngX, latY));
                            var infoWindow = new AMap.InfoWindow({
                            content:"<h3><font color=\"#00a6ac\">" + (parseInt(i) + 1) + ". " + iName + '<br/>地址:' + iAddress + "</font></h3>",
                                    size:new AMap.Size(200, 0),
                                    autoMove:true,
                                    offset:new AMap.Pixel(0, - 30)
                            });
                            windowsArr.push(infoWindow);
                            var aa = function (e) {infoWindow.open(map, mar.getPosition()); };
                            AMap.event.addListener(mar, "click", aa);
                    }

            function openMarkerTipById1(lng, lat) {  //根据id 打开搜索结果点tip
            for (var k in marker1){
            if (marker1[k].lat == lat && marker1[k].lng == lng){
            var pointid = k;
            }
            }
            windowsArr[pointid].open(map, marker1[pointid]);
                    }
</script>

<!--获取虚拟号码-->
<script type="text/javascript">
            //判断手机号是否正确
            function checkUserPhone(phonenum){
            var pattern = /^1[3|4|5|7|8]\d{9}$/;
                    var regex = new RegExp(pattern);
                    if (!regex.test($.trim(phonenum)) || phonenum.length != 11){
            $('.information').css({'display':'block', 'color':'red'});
                    $('.information').html('手机号填写不正确');
                    $("#btn_quickLogin").attr("disabled", "disabled");
            } else{
            $('.information').css({'display':'block', 'color':'green'});
                    $('.information').html('手机号填写正确');
                    $("#btn_quickLogin").removeAttr("disabled");
            }
            }
            //获取手机验证码,
            var countdown_quickLoginMobile = 60;
                    $("#btn_quickLogin").bind('click', settime_quickMobile);
                    function settime_quickMobile() {
                    var val = $("#btn_quickLogin");
                            if (countdown_quickLoginMobile == 0) {
                    val.bind('click', settime_quickMobile);
                            val.text("重新发送");
                            countdown_quickLoginMobile = 60;
                            return;
                    } else {
                    if (countdown_quickLoginMobile == 60) {
                    var mob = $.trim($('#phone').val());
                            if (mob == "") {
                    return false;
                    } else {
                    var reg = /^1[3|4|5|8|7]\d{9}$/;
                            if (!reg.test(mob)) {
                    return false;
                    }
                    }
                    val.unbind('click');
                            var crtoken = $("#virtualphone_token").val();
                            $.ajax({
                            type: 'POST',
                                    url: '/yzmobile', //URL地址
                                    data: {
                                    _token: crtoken,
                                            mobile: mob,
                                            mid: 2 //1为发送手机号产生随机验证码发送给客户
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                    //                    alert("发送手机测试验证码："+data);
                                    if (data != 1) {		//成功
                                    $('.information').html('发送成功');
                                            $(".information").css("color", "green");
                                    } else {				//失败
                                    $('.information').html('发送失败');
                                            $(".information").css("color", "red");
                                    }
                                    }
                            });
                    }
                    val.css('background-color', '#007AFF');
                            val.text("重新发送(" + countdown_quickLoginMobile + ")");
                            countdown_quickLoginMobile--;
                    }
                    setTimeout(function() {
                    settime_quickMobile()
                    }, 1000)
                    }
            //判断验证码
            var cflag = 0;
                    function chcekymd(){
                    var ryzm = $('#num').val();
                            var crtoken = $("#virtualphone_token").val();
                            var rmobile = $.trim($('#phone').val());
                            if (ryzm.length < 6){
                    $(".information").html('手机验证码不正确');
                            $(".information").css("color", "red");
                            cflag = 0;
                            return false;
                    } else{
                    $.ajax({
                    type:'POST',
                            url:'/yzmobile',
                            data:{
                            _token:crtoken,
                                    mobyz : ryzm,
                                    mobile:rmobile,
                                    mid : 3 //通过ajax获取发送给用户的验证码
                            },
                            dataType:'json',
                            success:function (data){
                            if (data == 5){
                            $('.information').html('验证码正确');
                                    $(".information").css("color", "green");
                                    cflag = 1;
                            } else{
                            $('.information').html('验证码错误');
                                    $(".information").css("color", "red");
                                    cflag = 0;
                                    return false;
                            }
                            }
                    });
                    }
                    }
            //点击电话按钮时，获取经济人id,并根据用户是否登录显示弹出框或直接显示虚拟号
            function phoneNum(cId, brokerId){
            //没有登录显示输入框
            if (cId !== undefined && brokerId !== undefined){
            $('#brokerId_quickLoginMobile').val(brokerId);
                    var token = $("#virtualphone_token").val();
                    $.ajax({
                    type:"POST",
                            async:"false",
                            data:"cId=" + cId + "&brokerId=" + brokerId + "&_token=" + token,
                            url:"/ajax/virtualphone/getDisplayNbr",
                            dataType:"json",
                            success: function (d){
                                if(d.result == true){                                   
                                    $(".modal_box").hide("fast");
                                    $(".modalBox").css('display','none');
                                    $(".footer_btn").text(d.message);
                                    $(".footer_btn").attr('href','tel:'+d.message);
                                    $(".footer_btn").removeAttr("onclick");
                            }else{
                                $(".modal_box").show();
                                $(".modalBox").css('display','block');
                                $('body').css('overflow','hidden');
                                $(".modal_box .box_btn").click(function(event){
                                        $(".modalBox").css('display','none');
                                })
                            }
                        }
                    });
            }
            }
            //提交信息，获取虚拟号
            function rsubmit_quickMobile() {
            var crtoken = $("#virtualphone_token").val();
                    var customerMobile = $.trim($('#phone').val());
                    var ryzm = $('#num').val();
                    var cId = "{{$communityId}}"; //楼盘id
                    if (cflag == 0){
            $('.information').css('color', 'red');
                    $('.information').html('验证码错误');
                    return false;
            }
            var brokerId = $('#brokerId_quickLoginMobile').val();
                    if (crtoken == '' || customerMobile == '' || ryzm == '' || cId == '' || brokerId == '') {
            $('.information').css('color', 'red');
                    $('.information').html('数据不全');
                    return false;
            }
            /*$.ajax({
             type:'post',
             url:'/ajax/registerQuickMobile',
             data:{
             _token:crtoken,
             mobile:mobile,
             captcha:ryzm,
             },
             //		dataType:'json',
             success:function(data){chcekymd
             alert(data);
             }
             });*/
            $.ajax({
            type: "post",
                    url: "/ajax/virtualphone/getDisplayNbr",
                    async: false,
                    data: {
                    cId: cId, //楼盘id
                            brokerId: brokerId, //经济人id
                            _token: crtoken,
                            captcha: ryzm,
                            customerMobile: customerMobile,
                    },
                    dataType: 'json',
                    success: function(d) {
//    		thisObj.show();
//    		thisObj.next().hide();
                    if (d.result == true) {                       
                            $(".modal_box").hide();
                           $(".modalBox").css('display','none');
                            $(".footer_btn").text(d.message);
                            $(".footer_btn").attr('href','tel:'+d.message);
                            $(".footer_btn").removeAttr("onclick");
                            //Object {result: true, message: "15359102947", userName: "dfh420984", mobile: "13331139424"}
                    }else{
                            alert(d.message);
                    }
                }
            });
            }
</script>
@endsection


