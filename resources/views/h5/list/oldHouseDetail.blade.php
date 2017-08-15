@extends('h5.mainlayout')
@section('title')
<title>@if(!empty($house->title)){{$house->title}}-@endif搜房网</title>
@endsection
@section('head')
@if($class == 'sale')
<link rel="stylesheet" type="text/css" href="/h5/css/Listingsdetail.css"/>
@else
<link rel="stylesheet" type="text/css" href="/h5/css/Rentalsdetail.css"/>
@endif
<script src="/h5/js/common/zepto.js"></script>
<script src="/h5/js/banner.js" type="text/javascript" charset="utf-8"></script>
<!-- <link rel="stylesheet" type="text/css" href="/h5/css/index.css" /> -->
@endsection
@section('content')
@include('h5.share.share')
<!-- header部分 -->
<div class="header">
    <div class="header_lf fl"><a href="javascript:window.history.go(-1)"></a></div>
    <p class="header_tit fl">
        <?php
            if($type == 'esfsale')
            {
               echo  '二手房详情';
            }
            elseif($type == 'esfrent')
            {
                echo '出租详情';
            }
            elseif($type == 'sprent')
            {
                echo '商铺出租';
            }
            elseif($type == 'spsale')
            {
                echo '商铺出售';
            }
            elseif($type == 'bsrent')
            {
                echo '豪宅别墅出租';
            }
            elseif($type == 'bssale')
            {
                echo '豪宅别墅出售';
            }
            elseif($type == 'xzlrent')
            {
                echo '写字楼出租';
            }
            elseif($type == 'xzlsale')
            {
                echo '写字楼出售';
            }
            else
            {
                echo '二手房详情';
            }
        ?>
    </p>
    <span class="header_like fl"><a href="javascript:void(0);" id="share"></a></span>
    <b class="header_share fr"><a href="/"></a></b>
</div>
<!-- <div class="space24"></div> -->

<!-- banner部分 -->
<!-- banner部分 -->
<div class="bannerBox">
        <div class="clickEnlarge">
                <div class="swiper-container detailPage">
                    <div class="swiper-wrapper">
                        @if(!empty($houseImages))
                            @foreach($houseImages as $k=>$houseimage)
                            <div class="swiper-slide"><img src="{{get_img_url($objectType,$houseimage)}}"/></div>
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
<!--==================内容区域，获取数据开始==========================================-->
<div class="wrapper">
    <div class="scroll-wrap content scroller ">
        <div class="content_box">
            <span class="box_active ps"></span>
           <!-- <div class="space24"></div>-->
            <div class="detail_banner">
                <div class="swiper-container detailPage">
                    <div class="swiper-wrapper">
                         @if(!empty($houseImages))
                            @foreach($houseImages as $k=>$houseimage)
                            <div class="swiper-slide"><img src="{{get_img_url($objectType,$houseimage)}}"/></div>
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

            @if($class == 'sale')
            <div class="main_Lists">
                @if(!empty($house->title))
                <h2 class="Lists_tit">{{mb_substr($house->title,0,25,'utf-8')}}</h2>
                @else
                <h2 class="Lists_tit">暂无数据</h2>
                @endif
                <!-- <span class="collect c_active ps"><a href="##" id="collect"></a><i>关注</i></span> -->
                <div class="Lists_ads">
                    @if(!empty($house->name))
                    <a href="/esfindex/{{$house->communityId}}/{{$house->houseType2}}.html"><h3>{{$house->name}}</h3></a>
                    @else
                    <h3>暂无数据</h3>
                    @endif
                    <div class="Lists_Pices">
                        <p><em>总价:</em><i>&nbsp;{{!empty($house->price2) ? $house->price2.'万':'面议'}}</i></p>
                        <p class="pPic"><em>单价:</em><i>&nbsp;{{!empty(floor($house->price1)) ? floor($house->price1).'元/㎡':'面议'}}</i></p>
                        <a href="/calc"></a>
                    </div>
                    @if(!empty($house->address))
                    <p class="Lists_address">地址:{{$house->address}}</p>
                    @else
                    <p class="Lists_address">地址:暂无数据</p>
                    @endif
                </div>
            </div>
            @else
                <div class="main_rentals"> 
                    @if(!empty($house->title))
                    <h2>{{mb_substr($house->title,0,25,'utf-8')}}</h2>
                    @else
                    <h2>暂无数据</h2>
                    @endif
                    <!-- <span class="collect c_active ps"><a href="##" id="collect"></a><i>关注</i></span> -->
                    @if(!empty($house->name))
                    <h6><a href="/esfindex/{{$house->communityId}}/{{$house->houseType2}}.html">{{$house->name}}</a></h6>
                    @endif
                    <div>
                            <h5>租金:</h5>
                            @if($housety == 3)
                                @if(!empty(floor($house->price1)))
                                <h2>{{floor($house->price1)}}<em>元/月</em></h2>
                                @else
                                <h2>面议</h2>
                                @endif
                            @else
                                @if(!empty($house->price2))
                                <h2>{{$house->price2}}<em>元/平.天</em></h2>
                                @else
                                <h2>面议</h2>
                                @endif
                            @endif
                            <span>
                                {{(!empty($house->paymentType)&&!empty($paymentTypes[$house->paymentType]))?'('.$paymentTypes[$house->paymentType].')':''}}
                            </span>
                            <h6 >
                                <?php
                                    if(!empty($house->timeRefresh)){
                                        $timeRefresh = floor($house->timeRefresh/1000);
                                    }elseif(!empty($house->timeUpdate)){
                                        $timeRefresh = strtotime($house->timeUpdate);
                                    }
                                   if(!empty($timeRefresh)){
                                       $time = time() - $timeRefresh;
                                       if(0<$time &&$time<60){
                                           $time = $time.'秒';
                                       }elseif(60<$time &&$time<3600){
                                           $time = (int)($time/60).'分';
                                       }elseif(3600<$time &&$time<86400){
                                           $time = (int)($time/3600).'小时';
                                       }else{
                                           $time = date('Y-m-d',$timeRefresh);
                                       }
                                       echo $time.'前';
                                   }else{
                                       echo '其它';
                                   }
                                ?>
                            </h6>
                    </div>
                    <h4> 所在地址:
                        @if(!empty($house->address))
                        <b>{{$house->address}}</b>
                        @else
                        <b>暂无数据</b>
                        @endif
                    </h4>
                    @if(($type == 'esfrent'))
                    <h4>配套设施:                        
                        <b>
                            @if(!empty($house->equipment))
                            <?php $ptss = '';?>
                            @foreach(preg_split("/[,|]/",$house->equipment) as $k=>$equipment)
                            @if(!empty($equipments[$equipment]))
                            <?php $ptss .=','.$equipments[$equipment];?>
                            @endif
                            @endforeach
                            {{!empty(trim($ptss,','))?trim($ptss,','):'暂无数据'}}
                            @else
                            暂无数据
                            @endif
                        </b> 
                    </h4>
                    @endif
                </div>
            @endif				
            <div class="main_mation">
                <h2>房源详情</h2>
                <dl class="mation_lf fl">
                    <dd>面积:</dd>
                    <dt>{{$house->area}}㎡</dt>
                    <dd>朝向:</dd>                   
                    <dt>{{$faces[$house->faceTo]}}</dt>
                    <dd>装修:</dd>
                    <dt>{{!empty($fitments[$house->fitment])?$fitments[$house->fitment]:'暂无'}}</dt>
                </dl>                
                <dl class="mation_rg fr">
                    @if($type == 'esfrent' || $type == 'esfsale' || $type == 'bssale' || $type == 'bsrent')
                        @if(!empty($house->roomStr))
                        <dd>户型:</dd>
                        <dt>{{substr($house->roomStr,0,1)}}室{{substr($house->roomStr,2,1)}}厅{{substr($house->roomStr,6,1)}}卫</dt>
                        @endif
                    @else
                        <dd>年代:</dd>
                        <dt>{{!empty($house->buildYear)?$house->buildYear:'未知'}}</dt>
                    @endif
                    <dd>楼型:</dd>
                    <dt>{{$house->currentFloor}}/{{$house->totalFloor}}层</dt>
                    <dd>类型:</dd>
                    <dt>{{$type2[$house->houseType1][$house->houseType2] or ''}}</dt>
                </dl>
            </div>		
            <div class="main_desc">
                <h2>房源描述</h2>
                <div id="js-meanu2">
                    <p id="panel2">
                        @if(!empty($house->describe))
                        <?php 
                                $house->describe = strip_tags($house->describe);
                        ;?>
                        {!! $house->describe !!}
                        @else
                        暂无房源描述
                        @endif
                    </p>
                </div>
                @if(!empty($house->describe))
                <h6 id="js-slide2">展开</h6>
                @endif
            </div>
            @if(!empty($communityId))
            <div class="main_cell">
                <h2>小区信息</h2>
                <dl class="cell_Point">
                    <dd>
                        @if($type == 'sprent' || $type == 'spsale' || $type == 'xzlrent' || $type == 'xzlsale')
                            出售房
                        @else
                            二手房
                        @endif
                        <i>{{(!empty($houseSaleData->total)) ? $houseSaleData->total : 0 }}套</i>
                    </dd>
                    <dt><a href="/{{$saleUrl}}/area/ba{{$communityId}}"></a></dt>
                </dl>
                <dl class="cell_Point">
                    <dd>出租房<b>{{(!empty($houseRentData->total)) ? $houseRentData->total : 0 }}套</b></dd>
                    <dt><a href="/{{$rentUrl}}/area/ba{{$communityId}}"></a></dt>
                </dl>
                <dl class="cell_Point">
                    <dd>小区详情</dd>
                    <!-- <dt><a href="../detail/Communitydetail.html"></a></dt> -->
                    <dt><a  href="/esfindex/{{$house->communityId}}/{{$house->houseType2}}.html"></a></dt>                    
                </dl>
            </div>
            <div class="main_review">
                <h2>房价走势</h2>
                <div class="review_rates">
                    <div class="rates_btn js-btn">
                        <span class="secound_house active" attr='sale'>二手房</span>
                        <span class="rent_house" attr='rent'>租房</span>
                    </div>
                    <!-- <div class="secound_one">
                        <div class="chart" style="height: 200px" id="communityChart">

                        </div>
                    </div>
                    <div class="secound_two"><img src="/h5/image/sOne.png" alt="" /></div> -->
                    <div class="js-sec">
                            <div class="secound_one active"  id="communityChart"></div>
                    </div>
                    <ul class="house_List" id="tag_sale">
                        <!--<li class="house_first">全部</li>
                        <li>一居</li>
                        <li>二居</li>
                        <li>三居</li>
                        <li>四居</li> -->
                    </ul>
                </div>					
            </div>
            @endif
            <div class="main_postion">
                <h2>地理位置</h2>
                <p>地址:{{(!empty($house->address)) ? $house->address : '暂无数据' }}<i></i></p>
                <!-- <img src="/h5/image/map.png" /> -->
                <div id="container" class="mapContainer"></div>
            </div>
            <div class="main_support">
                <h2>@if(!empty($house->name)){{$house->name}} @endif周边配套</h2>
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
            @if(!empty($surrounds))
            <div class="index_hot fl">
                <ul class="index_Hlist">
                    <li class="scroll_list">
                        <h2>周边楼盘相似房源</h2>
                    </li>
                    <?php
                    $i = 0;
                    $towards = \Config::get('conditionConfig.toward.text');
                    $houseDao = new \App\Dao\Agent\HouseDao;
                    $featurestag = $houseDao->getAllHouseTag(); //获取所有房源标签
                    //dd($surrounds);
                    ?>
                    @foreach($surrounds as $surround)
                    <?php
                    $i++;
                    if ($i > 3) {
                        break;
                    }
                    ?>
                    <li class="index_footer">
                        <a href="/housedetail/s{{$sr}}{{$surround->_source->id}}.html">
                            <img src="{{get_img_url($objectType,$surround->_source->thumbPic)}}" />
                            <div class="index_Hmain fl">
                                <h3>{{$surround->_source->title}}</h3>
                                <h6>@if(!empty($surround->_source->name))[{{$surround->_source->name}}]@endif{{$surround->_source->address}}</h6>
                                <ul>
                                    <li>{{substr($surround->_source->roomStr,0,1)}}室{{substr($surround->_source->roomStr,2,1)}}厅<i>|</i></li>
                                    <li>{{$surround->_source->area}}平<i>|</i></li>
                                    <li>{{$surround->_source->currentFloor}}/{{$surround->_source->totalFloor}}<i>|</i></li>
                                    <li>{{$towards[$surround->_source->faceTo]}}</li>
                                </ul>
                                <div class="house_Chouse fl">
                                    <?php $x = 1; ?>
                                    @if(!empty($surround->_source->tagId))
                                    @foreach(explode('|',$surround->_source->tagId) as $k=>$tagid)
                                    @if(!empty($featurestag[$tagid]))
                                    <span class="tag{{$x}}">{{$featurestag[$tagid]}}</span>
                                    <?php $x++;
                                    if ($x > 3) break; ?>
                                    @endif
                                    @endforeach
                                    @endif
                                    @if(!empty($surround->_source->diyTagId))
                                        <?php $tid = explode('|',$surround->_source->diyTagId);?>                                                                                    
                                        @if(!empty($diynames = $houseDao->getDiyTagByIds($tid)))                                        
                                            @foreach($diynames as $diyname) 
                                            <?php if ($x > 3) break;$x++; ?>
                                            @if(!empty($diyname->name))
                                            <span class="tag{{$x}}">{{$diyname->name}}</span>
                                            @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @if($class == 'sale')
                            <h6 class="prot_Pic"><i>{{!empty($surround->_source->price2)?$surround->_source->price2.'万':'面议'}}</i></h6>
                            @else
                                @if($housety == 3)
                                <h6 class="prot_Pic"><i>{{!empty(floor($surround->_source->price1))?floor($surround->_source->price1).'元/月':'面议'}}</i></h6>
                                @else
                                <h6 class="prot_Pic"><i>{{!empty($surround->_source->price2)?$surround->_source->price2.'元/平.天':'面议'}}</i></h6>
                                @endif
                            @endif
                        </a>
                    </li>
                    @endforeach
                    <!-- <li style="width:100%; height:30px;"></li> -->
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
<!--==================内容区域，获取数据结束==========================================-->
<div class="space32 ps"></div>
<!-- 获取安全号码模态框部分 -->
<div class="modalBox">
<div class="modal_box">
        <div class="box_infor">
            <span class="box_btn"></span>
            <h3>搜房提心您</h3>
            <p>手机号验证后，您将获得与置业顾问联系的安全号码，此号码只关联为您服务的置业顾问，其他个人或团体都不能通过安全号码与您联系，更不会得到您真实的手机号码。安全号码为153591号段，请您放心使用！
            </p>
            <form>
                <label>手机号&nbsp;</label><input type="phone" name="phone" id="phone" placeholder="请输入手机号" class="number" onkeyup="this.value=this.value.replace(/\D/g,'');checkUserPhone(this.value)"/>
                <label>验证码&nbsp;</label><input type="num" name="num" id="num" placeholder="验证码" class="num" onkeyup="this.value=this.value.replace(/\D/g,'');chcekymd()"/>
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
@if(!empty($brokers))       
    <div class="footer">
        <a href="##" class="aImg"><img src="{{!empty($brokers->photo)?get_img_url('userPhoto',$brokers->photo,8):"/h5/image/Brokers.png"}}"/></a>        
        <div class="footer_phone">
            <a class="aTit"><i >{{(!empty($brokers->realName)) ? str_limit($brokers->realName, $limit = 8, $end = '...') : '匿名'}}</i>
                
               {{-- @if(!empty($enterpriseshopName))--}}
                {{--<span>({{str_limit($enterpriseshopName,$limit = 14, $end = '...')}})</span>--}}
                {{--@else--}}
                {{--<span>(经纪人)</span>--}}
                {{--@endif--}}
            </a>
            <a class="aTit"><i>电话:</i><span>{{$brokers->mobile}}</span></a>
        </div>
        <!--判断用户是否登录，登录直接获取虚拟号，否则输入手机号获取-->
        {{--<a href="#" class="footer_btn" onclick="phoneNum({{$house->communityId}},{{$brokers->id}});">点击获取安全号码</a>--}}
    </div>
@endif
<!-- <div class="footer">
    <a href="##"><img src="/h5/image/Brokers.png"/></a>
    <div class="footer_phone">
        <h3>王国强<em>(链家地产)</em></h3>
        <h3>电话:<em>13331139424</em></h3>
    </div>
    <h5 class="footer_btn">点击获取安全号码</h5>
</div> -->
<input type="hidden" id='comid' value="{{$house->communityId}}">
<input type="hidden" id='saleRent' value="{{$class}}">
<input type="hidden" id='strType2' value="{{$house->houseType2}}">
<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >

<script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>
<input type="hidden" name="jingduMap" value="{{$house->longitude}}">
<input type="hidden" name="weiduMap" value="{{$house->latitude}}">
<script src="/h5/js/common/iscroll.js" type="text/javascript"></script>
<script src="/h5/js/common/iscroll-probe.js"  type="text/javascript"></script>
<script type="text/javascript">
    if({{$class == 'rent'}}){   //去掉出租详情页多余箭头
        $(".cell_Point dt a").css("background-image","url('')");
    }
        /*var myscroll;
        function loaded(){
            setTimeout(function(){
                myscroll=new iScroll(".wrapper");
              }, 100);
        }
        window.addEventListener("load",loaded,false);
        loaded();*/
   // var myScroll1;
    //function loaded () {
       // var pageWrapper = $(".wrapper");
       // myScroll1 = new IScroll('.scroller', { mouseWheel: true });   
   // }
   // loaded();
</script>

<!--价格走势js-->
<script type="text/javascript">
    var g_communityid = $('#comid').val();
    var datatype = '';
    var saleRent = $('#saleRent').val();
    var tempType2 = $('#strType2').val();
    var room = '2';
    var _token = $('input[name="_token"]').val();
    //页面加载完初始化
    if(saleRent == 'sale')
        getSalePrice(g_communityid, saleRent, tempType2, room); //页面加载完显示走势图
    else{
        $(".rates_btn  span").removeClass('active');
        $(".rates_btn  span[attr='rent']").addClass('active');
        getSalePrice(g_communityid, saleRent, tempType2, room); //页面加载完显示走势图
    }
    $(".rates_btn  span").on('click',function(){
        var saleRent = $(this).attr('attr');
        getSalePrice(g_communityid, saleRent, tempType2, room); //点击后跳转对应折线图
    });
    function getSalePrice(g_communityid, saleRent, tempType2, room)
    {
        var type = '1';
        if (saleRent == 'sale') {
            type = '2';
        }
        $.post('/ajax/checkprice', {'comid': g_communityid, 'type': type, 'ctype2': tempType2, '_token': _token, 'room': room}, function(d) {
            if (saleRent == 'sale') {
                showCharts(d.title, d.time, d.price, '元/平米');
            } else
            {
                showCharts(d.title, d.time, d.price, '元/月');
            }
            var roomTagHtml = '';
            var beSelect = false;
            for (var i = 0; i < d.roomTags.length; i++) {
                if (d.curtRoom == d.roomTags[i]) {
                    beSelect = true;
                    roomTagHtml += '<li class="house_first" onClick="clickRoomTag(this)">' + d.roomTags[i] + '</li>';
                } else
                {
                    roomTagHtml += '<li  onClick="clickRoomTag(this)">' + d.roomTags[i] + '</li>';
                }
            }
            $('#tag_sale').html(roomTagHtml);
            if (!beSelect && $('#tag_sale li').first().length > 0)
            {
                $('#tag_sale li').first().addClass('house_first');
            }
        }, 'json');
    }

    //显示走势图，默认2居室
    function showCharts(title, artime, arprice, tag) {
        //$('#saleRoomPrice').html(title);
        $('#communityChart').html('');
        $('#communityChart').highcharts({
            title: {text: '', x: 0},
            credits: enabled = false,
            xAxis: {
                categories: artime,
                tickInterval: 1,
                labels: {
                    formatter: function() {
                        return this.value.toString().substr(4, 2) + "月";
                    }
                }
            },
            yAxis: {
                title: {text: null},
                plotLines: [{value: 0, width: 1, color: '#808080'}],
                lineWidth: 1,
                labels: {
                    formatter: function() {
                        return Highcharts.numberFormat(this.value, 0, '.', ',');
                    }
                }
            },
            tooltip: {
                formatter: function() {
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
            series: arprice
        });
    }

    //点击房源标签
    function clickRoomTag(obj)
    {
        $(obj).parent().find("li").removeClass("house_first");
        $(obj).addClass("house_first");
        room = getRoomByTag($(obj).text());
        //saleRent = $('#saleRent').val();
        saleRent = $(".rates_btn  .active").attr('attr');
        getSalePrice(g_communityid, saleRent, tempType2, room);
    }

    //获取居室
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
</script>

<!--地图js显示-->
<script type="text/javascript">
    var longitude = $('input[name="jingduMap"]').val();
    var latitude = $('input[name="weiduMap"]').val();
    var comname = "{{!empty($house->name)?$house->name:'暂无房源名称'}}";
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
            content: "<div style=\"width:200px\">房源名称 : " + comname + "</div>",
            size: new AMap.Size(200, 0),
            autoMove: true,
            offset: new AMap.Pixel(0, -30)
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
                    if(result.info == 'OK'){
                        $('.poi-more').hide(); //详情链接隐藏
                        $('.poibox').hide(); 
                        //map.panBy(-200,0);
                        var html = '';
                        var res = result.poiList.pois;
                        for(var k in res){
                            var lng = res[k].location.lng;
                            var lat = res[k].location.lat;
                            html += "<li onclick='openMarkerTipById1("+lng+','+lat+")'><em>"+res[k].name+"</em><b>"+res[k].address+"</b></li>";
                            addmarker(k, [res[k].location.lng, res[k].location.lat, res[k].name, res[k].address]);
                        }                        
                        //console.log(res);                                                                      
                        $("#panel").html(html);
                        //地图点击周边配套后始终显示为'展开'
                        $('#js-menu').css('height','144');
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
            content:'<div class=\"amap_lib_placeSearch_poi\">'+ (parseInt(i) + 1) +'</div>',
            position:new AMap.LngLat(lngX, latY)
        };
        var mar = new AMap.Marker(markerOption);
        marker1.push(new AMap.LngLat(lngX, latY));
        var infoWindow = new AMap.InfoWindow({
            content:"<h3><font color=\"#00a6ac\">" + (parseInt(i) + 1) + ". " + iName +'<br/>地址:'+iAddress+ "</font></h3>",
            size:new AMap.Size(200, 0),
            autoMove:true,
            offset:new AMap.Pixel(0,-30)
        });
        windowsArr.push(infoWindow);
        var aa = function (e) {infoWindow.open(map, mar.getPosition());};
        AMap.event.addListener(mar, "click", aa);
    }
    
    function openMarkerTipById1(lng,lat) {  //根据id 打开搜索结果点tip
        for(var k in marker1){
            if(marker1[k].lat == lat && marker1[k].lng == lng){
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
        var regex   = new RegExp(pattern);
        if(!regex.test($.trim(phonenum)) || phonenum.length != 11){
            $('.information').css({'display':'block','color':'red'});
            $('.information').html('手机号填写不正确');
            $("#btn_quickLogin").attr("disabled","disabled");
        }else{
            $('.information').css({'display':'block','color':'green'});
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
                    var reg = /^1[3|4|5|7|8]\d{9}$/;
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
        if(ryzm.length < 6 ){
            $(".information").html('手机验证码不正确');
            $(".information").css("color","red");
            cflag = 0;
            return false;
        }else{
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
                    if(data == 5){
                        $('.information').html('验证码正确');
                        $(".information").css("color","green");
                        cflag=1;                       
                    }else{
                        $('.information').html('验证码错误');
                        $(".information").css("color","red");
                        cflag=0;
                        return false;
                    }
                }
            });
        }
    }
    //点击电话按钮时，获取经济人id,并根据用户是否登录显示弹出框或直接显示虚拟号
    function phoneNum(cId, brokerId){
        //没有登录显示输入框
        if(cId !== undefined && brokerId !== undefined){
            $('#brokerId_quickLoginMobile').val(brokerId);
            var token = $("#virtualphone_token").val();            
            $.ajax({
                    type:"POST",
                    async:"false",
                    data:"cId="+cId+"&brokerId="+brokerId+"&_token="+token,
                    url:"/ajax/virtualphone/getDisplayNbr",
                    dataType:"json",
                    success: function (d){
                            //如果用户登录直接显示虚拟号
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
        var cId = $('#comid').val();    //楼盘id
        if(cflag == 0){
            $('.information').css('color','red');
            $('.information').html('验证码错误');
            return false;
        }
        var brokerId = $('#brokerId_quickLoginMobile').val();
        if (crtoken == '' || customerMobile == '' || ryzm == '' || cId == '' || brokerId == '') {
            $('.information').css('color','red');
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


