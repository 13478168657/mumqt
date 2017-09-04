@extends('h5.mainlayout')
                @section('title')
		<title>@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif详情-搜房网</title>
                @endsection
                @section('head')
		<link rel="stylesheet" type="text/css" href="/h5/css/Communitydetail.css"/>
		<script src="/h5/js/common/zepto.js"></script>
		<script src="/h5/js/banner.js" type="text/javascript" charset="utf-8"></script>
                <script src="/js/point_interest.js"></script>
                <script src="/js/highcharts/jquery-1.8.3.min.js?v={{Config::get('app.version')}}"></script>
                <script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>

                @endsection
                @section('content')
		<script type="text/javascript">
			var _phoneWidth = parseInt(window.screen.width);
			var _phoneHeight = parseInt(window.screen.height);
			var _phoneScale = Math.floor(_phoneWidth / 750 * 100) / 100;
			var Terminal = {
				platform: function() {
					var u = navigator.userAgent,
						app = navigator.appVersion;
					return {
						android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
						iPhone: u.indexOf('iPhone') > -1,
						iPad: u.indexOf('iPad') > -1
					};
				}(),
				language: (navigator.browserLanguage || navigator.language).toLowerCase()
			}
			var ua = navigator.userAgent;
			document.write('<meta name="viewport" content="width=750,target-densitydpi=device-dpi, initial-scale=' + _phoneScale + ', minimum-scale=' + _phoneScale + ', maximum-scale=' + _phoneScale + ', user-scalable=no">');
		</script>
	</head>
	<body>

@include('h5.share.share')
		</form><input type="hidden" name="_token" value="{{csrf_token()}}"></form>
		<!-- header部分 -->
		<div class="header">
			<div class="header_lf fl"><a href="javascript:window.history.go(-1)"></a></div>
			<p class="header_tit fl">小区详情</p>
			<span class="header_like fl"><a href="javascript:void(0);" id="share"></a></span>
			<b class="header_share fr"><a href="{{url('/')}}"></a></b>
		</div>
		<!--<div class="space24"></div>-->
		<!-- banner部分 -->
                
		<div class="bannerBox">
			<div class="clickEnlarge">
				<div class="swiper-container detailPage">
				    <div class="swiper-wrapper">
				        @foreach($communityimage as $key => $val)
                                        <div class="swiper-slide"><img src="{{get_img_url('commPhoto', $val->fileName, '')}}"/></div>
                                        @endforeach
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
		<div class="detail_banner">
			<div class="swiper-container detailPage">
			    <div class="swiper-wrapper">
                                @foreach($communityimage as $key => $val)
			        <div class="swiper-slide"><img src="{{get_img_url('commPhoto', $val->fileName, '')}}"/></div>
                                @endforeach
			    </div>
			    <!-- Add Pagination -->
			        <div class="swiper-pagination swiper-pagination-fraction swiper-page"></div>
			</div>
		</div>
		<!-- content部分 -->
				<!--<div class="con_detail">-->
				<div class="main_unity">
					<h2 class="unity_tit">@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif</h2>
					<span style="display:none;" class="collect c_active ps focus" value="{{$communityId}},3,{{substr($type2, 0, 1)}},0"><a href="##" id="collect"></a><i>{{(!empty($viewShowInfo['interest'])&&($viewShowInfo['interest'])?'已关注':'关注')}}</i></span>
					<div class="unity_ads">
						<p>平均价格:&nbsp;<em>@if(!empty($viewShowInfo['statusSalePrice'])) {{$viewShowInfo['statusSalePrice']}} </em><i>元/㎡</i>@else 暂无资料  @endif
                                                    <span>
                                                        <a class="color_blue" href="/{{$viewShowInfo['saleUrl']}}/area/an{{$type2}}-ba{{$communityId}}" target="_self">
                                                        {{(!empty($houseSaleData->total)) ? $houseSaleData->total : 0 }}
                                                        </a>
                                                        套
                                                        @if(substr($type2, 0,1) == 3)
                                                            二手房
                                                        @else
                                                            出售
                                                        @endif
                                                    </span>
                                                </p>
						<p>平均租金:&nbsp;<em>@if(!empty($viewShowInfo['statusRentPrice'])) {{$viewShowInfo['statusRentPrice']}} </em><i>元/㎡</i>@else 暂无资料 @endif
                                                    <span>
                                                        <a class="color_blue" href="/{{$viewShowInfo['rentUrl']}}/area/an{{$type2}}-ba{{$communityId}}" target="_self">
                                                        {{(!empty($houseRentData->total)) ? $houseRentData->total : 0 }}
                                                        </a>
                                                        套
                                                        @if(substr($type2, 0,1) == 3)
                                                            租房
                                                        @else
                                                            出租
                                                        @endif
                                                    </span>
                                                </p>
					</div>
				</div>				
				<div class="main_detail">
					<h3>详细信息</h3>
					<p>项目特色:&nbsp;<b>{{(!empty($viewShowInfo['tagsName']))? $viewShowInfo['tagsName'] : '暂无资料'}}</b></p>
					<p>所在区域:&nbsp;<b>          
                                            @if(!empty($viewShowInfo['cityAreaId']) || !empty($viewShowInfo['businessAreaId']))
                                                @if(!empty($viewShowInfo['cityAreaId']))
                                                  {{\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($viewShowInfo['cityAreaId'])}}
                                                @endif
                                                @if(!empty($viewShowInfo['businessAreaId']))
                                                  {{\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($viewShowInfo['businessAreaId'])}}
                                                @endif
                                            @else
                                                暂无资料
                                            @endif
                                            </b></p>
					<p>物业类型:&nbsp;<b>{{(!empty(config('communityType2.'. $type2)))? config('communityType2.'. $type2) : '暂无资料'}}</b></p>
					<p>产权年限:&nbsp;<b>{{(!empty($type2GetInfo->propertyYear))?$type2GetInfo->propertyYear.' 年' : '暂无资料'}}</b></p>
					<p>装修类型:&nbsp;<b>{{(!empty($viewShowInfo['structure']))? $viewShowInfo['structure'] : '暂无资料'}}</b></p>
					<p>建筑面积:&nbsp;<b>{{(!empty($type2GetInfo->floorSpace))? $type2GetInfo->floorSpace. ' 平方米' : '暂无资料'}}</b></p>
					<p>&nbsp;&nbsp;&nbsp;住户数:<b>{{(!empty($type2GetInfo->houseTotal))? $type2GetInfo->houseTotal . ' 户' : '暂无资料'}}</b></p>
					<p>&nbsp;&nbsp;&nbsp;绿化率:&nbsp;<b>{{(!empty($type2GetInfo->greenRate))? $type2GetInfo->greenRate .' %' : '暂无资料'}}</b></p>
					<p>&nbsp;&nbsp;&nbsp;容积率:&nbsp;<b>{{(!empty($type2GetInfo->volume))? $type2GetInfo->volume.'%' : '暂无资料'}}</b></p>
					<p>&nbsp;&nbsp;&nbsp;开发商:&nbsp;<b>{{(!empty($viewShowInfo['developerName']))?$viewShowInfo['developerName'] : '暂无资料'}}</b></p>
				</div>								
				<div class="main_review">
					<div class="con_tit"><h3>房价走势</h3></div>
					<div class="review_rates">
						<div class="rates_btn js-btn">
							<span class="secound_house active" tag1="community_type" tag2="comsaleprice">二手房</span>
							<span class="rent_house" tag1="community_type" tag2="comrentprice">租房</span>
						</div>
						<div class="js-sec">
							<div class="secound_one active" id ="communityChart"><!--<img src="/h5/image/sOne.png" alt="" />--></div>
							<div class="secound_two" id ="communityRent"><!--<img src="../image/sOne.png" alt="" />--></div>                                      
						</div>
							<ul class="house_List" id="tag_sale">
                                                            <!--<li class="house_first">一居</li>-->

							</ul>
					</div>					
				</div>
				
				<div class="main_postion">
					<div class="con_tit"><h3>地理位置及周边</h3></div>
					<p><a href="/{{$viewShowInfo['saleUrl']}}/area/an{{$type2}}-ba{{$communityId}}">地址:
                                            @if( !empty($viewShowInfo['address']))
                                                @if(!empty($viewShowInfo['address']))
                                                  {{$viewShowInfo['address']}}
                                                @endif
                                            @else
                                                暂无资料
                                            @endif
                                                <i></i></a></p>
					<div class="pos_map" id="map1" style="height:450px;">
                                            <!--
                                            <a href="##">
                                                <img src="/h5/image/map.png" />
                                            </a>
                                            -->
                                        </div>
				</div>
				<div class="main_support">
					<h2>周边配套</h2>
					<ul class="support_list">
						<li  attr="公交" class="bgc1 chechData"><span class="active"></span></li>
						<li class="list_first bgc2 chechData" attr="学校"><span></span></li>
						<li class="list_first bgc3 chechData" attr="医院"><span></span></li>
						<li class="list_first bgc4 chechData" attr="银行"><span></span></li>
						<li class="list_first bgc5 chechData" attr="超市"><span></span></li>
						<li class="list_first bgc6 chechData" attr="餐饮|酒店"><span></span></li>
					</ul>
					<div class="support_menu" id="js-menu">
						<ul class="down_list" id="panel">
                                                <!--
							<li><em>808路</em><b>246米</b></li>
							<li><em>902路</em><b>436米</b></li>
							<li><em>58路</em><b>568米</b></li>
							<li><em>808路</em><b>246米</b></li>
							<li><em>902路</em><b>436米</b></li>
							<li><em>58路</em><b>568米</b></li>
						-->
                                                </ul>
						<span id="js-slide">展开</span>
					</div>
				</div>
			<!--===================================周边楼盘==================================-->
		<div class="index_hot">
                    <ul class="index_Hlist" id="newList">
                        <li class="scroll_list">
                            <h2>@if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif 房源</h2>
			</li>
                        <?php
		/*
                 *小区里有买的有租的，采用将两者合并在再打乱的方式
                 * 由于显示的时候会有整租，整售的字样，所以在合并打乱之前加入这个元素
                 *                  */
                        $house = array();
                        //增加元素
                        $tag = '';
                        if(!empty($houseSaleData->hits)){
                            if(substr($type2, 0,1) == 3){
                                $tag=['houseSale','二手房','ss'];
                            }else{
                                $tag=['houseSale','出售','ss'];
                            }
                            foreach($houseSaleData->hits as $v){
                                $v->house = $tag;
                            }
                        }
                        
                        $tag = '';
                        if(!empty($houseRentData->hits)){
                            if(substr($type2, 0,1) == 3){
                                $tag=['houseRent','租房','sr'];
                            }else{
                                $tag=['houseRent','出租','sr'];
                            }
                            foreach($houseRentData->hits as $v){
                                $v->house = $tag;
                            }
                        }
                        $house = array_merge($houseSaleData->hits,$houseRentData->hits);

                        if(!shuffle($house) && !empty($houseSaleData->hits)){
                            $house = $houseSaleData->hits;
                        }else if(!shuffle($house) && !empty($houseRentData->hits)){
                            $house = $houseRentData->hits;
                        }
                        //dd($house);
                ?>
                        @if(!empty($house))
                        <?php $HouseDao=new \App\Dao\Agent\HouseDao();
                            $diyTagIdArr=array();
                        ?>
                        @foreach($house as $vvv)
                            @if(!empty($vvv->_source->diyTagId))
                                <?php $diyTagIdArr=array_merge($diyTagIdArr,explode('|',$vvv->_source->diyTagId));?>
                            @endif
                        @endforeach
                        <?php
                        if(!empty(array_unique($diyTagIdArr))){
                            $diyTagIdArr=array_unique($diyTagIdArr);
                            $diyTagTemp=$HouseDao->getDiyTagByIds($diyTagIdArr);
                            foreach($diyTagTemp as $kk => $vv){  
                                if(!empty($vv->name)){
                                    $diyTagName[$vv->id]=$vv->name;
                                }
                            }
                        }
                        ?>
                        @foreach($house as $val)
                        <li class="index_footer">
                                <a href="/housedetail/{{$val->house[2]}}{{$val->_source->id}}.html">
                                <img src="{{get_img_url($val->house[0], $val->_source->thumbPic)}}" alt="">
                                <div class="index_Hmain fl">
                                        <h3>{{$val->_source->title}}</h3>
                                        <h6>
                                            
                                            <em>
                                                @if(!empty($viewShowInfo['commName'])) {{$viewShowInfo['commName']}} @endif
                                            </em>&nbsp;&nbsp;
                                            @if(!empty($viewShowInfo['cityAreaId']) || !empty($viewShowInfo['businessAreaId']))
                                                @if(!empty($viewShowInfo['cityAreaId']))
                                                  {{\App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($viewShowInfo['cityAreaId'])}}
                                                @endif
                                                @if(!empty($viewShowInfo['businessAreaId']))
                                                {{\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($viewShowInfo['businessAreaId'])}}
                                              @endif
                                            @else
                                                暂无资料
                                            @endif
                                        </h6>
                                        <ul>
                                                <li>{{$val->house[1]}}<i>|</i></li>
                                                <li>@if(!empty($val->_source->area)){{$val->_source->area}}平@endif<i>|</i></li>
                                                <li>{{$val->_source->currentFloor}}/{{$val->_source->totalFloor}}层<i>|</i></li>
                                                <li>{{!empty($faces[$val->_source->faceTo])?$faces[$val->_source->faceTo]:'未知'}}
                                                </li>
                                        </ul>
                                        <div class="house_Chouse fl">
                                            <!--
                                                <span class="house_Croom fl">学区房</span>
                                                <span class="house_Cdup fl">复式</span>
                                                <span class="house_Csub fl">地铁房</span>
-->
                                            @if(!empty($val->_source->tagId))
                                            @foreach(explode('|',$val->_source->tagId) as $k=>$tagid)
                                                @if(array_key_exists($tagid,$featurestag))
                                                    <span class="house_Csub fl">{{$featurestag[$tagid]}}</span>
                                                @endif
                                            @endforeach
                                            @endif
                                            @if(!empty($val->_source->diyTagId))
                                                @if(!empty($diyTagId = explode('|',$val->_source->diyTagId)))
                                                @foreach($diyTagId as $v)
                                                    @if(!empty($diyTagName[$v]))
                                                    <span class="house_Csub fl">{{$diyTagName[$v]}}</span>
                                                    @endif
                                                @endforeach
                                                @endif
                                            @endif
                                        </div>
                                </div>
                                <h6 class="prot_Pic">
                                    <?php
                                        $price = 'price1';
                                        if($val->house[1] == '二手房' || $val->house[1] == '出售' ){
                                            $price = 'price2';
                                        }
                                        
                                    ?>
                                    @if(!empty($val->_source->$price))
                                    <span class="average"><i>{{$val->_source->$price}}</i><em>
                                            @if($val->house[2]=='ss')
                                            万
                                            @else
                                            元/月
                                            @endif
                                        </em></span>
                                    @else
                                    <span class="average"><i>面议</i></span>
                                    @endif
                                </h6>
                                </a>
                        </li>
                        @endforeach
                        @endif

                    </ul>
                </div>
                </div>
		</div>
		</div>
		<!--==================内容区域，获取数据结束==========================================-->
		<!--<div class="space32 ps"></div>-->
		<!-- 获取安全号码模态框部分 -->
                <div class="modalbox">
                <div class="modal_box">
                    <div class="box_infor">
                        <span class="box_btn"></span>
                        <h3>搜房提醒您</h3>
                        <p>手机号验证后，您将获得与置业顾问联系的安全号码，此号码只关联为您服务的置业顾问，其他个人或团体都不能通过安全号码与您联系，更不会得到您真实的手机号码。安全号码为153591号段，请您放心使用！
                        </p>
                        <form>
                            <label>手机号&nbsp;</label><input type="phone" name="phone" id="phone" placeholder="请输入手机号" class="number" onkeyup="this.value=this.value.replace(/\D/g,'');checkUserPhone(this.value)"/>
                            <label>验证码&nbsp;</label><input type="num" name="num" id="num" placeholder="验证码" class="num" />
                            <em id="btn_quickLogin">获取验证码</em>
                            <span class="color" id="msphonequickLoginMobile" style='display: none'></span>
                            <p onclick="rsubmit_quickMobile()">提交</p>
                            <input type="hidden" name="virtualphone_token" id="virtualphone_token" value="{{csrf_token()}}" />
                        </form>
                    </div>
                </div>
                </div>
		<!--=====================回到顶部=======================-->
			<a  href="#" class="top_fix" id="backtop"></a>
		
		<!--=====================回到顶部=======================-->	
		<!-- footer部分 -->
                <?php 
                //小区里有买的有租的且有多个，采用将两者合并再打乱取其一的方式
                    $agent=array();
                    $agent = array_merge($viewShowInfo['saleBrokers'],$viewShowInfo['rentBrokers']);
                    
                    if(!shuffle($agent) && !empty($viewShowInfo['saleBrokers'][0])){
                        $agent=$viewShowInfo['saleBrokers'];
                    }else if(!shuffle($agent) && !empty($viewShowInfo['rentBrokers'][0])){
                        $agent=$viewShowInfo['rentBrokers'];
                    }
                    $agent=!empty($agent[0])?$agent[0]:array();
                ?>
		<div class="footer">
                    <!--<a href="/brokerinfo/{{!empty($agent->_source->id)?$agent->_source->id:''}}-renthouse.html" target="_blank">-->
			<a href="javascript:void(0)" class="aImg">
                            @if(!empty($agent->_source->photo))
                            <img style="background: rgba(0, 0, 0, 0) url(/image/default.png) no-repeat scroll 0 0 / 100% 100%;" alt="{{(!empty($agent->_source->realName))?$agent->_source->realName:'匿名'}}" src="{{get_img_url('userPhoto',$agent->_source->photo, '1')}}" alt="">
                            @else
                            <img src="/image/default.png" alt="{{(!empty($agent->_source->realName))?$val->_source->realName:'匿名'}}"></a>
                            @endif
                        </a>
			<div class="footer_phone">
                            <a class="aTit"><i>{{(!empty($agent->_source->realName))?$agent->_source->realName:'匿名'}}</i>               
                <?php $enterpriseshopName = \App\Http\Controllers\Utils\RedisCacheUtil::getDataLikeKing('mysql_user', 'enterpriseshop', 'EPS', !empty($agent->_source->enterpriseshopId)?$agent->_source->enterpriseshopId:'','companyName'); ?>
                {{--@if(!empty($enterpriseshopName))--}}
                  {{--<span title="{{$enterpriseshopName}}">(&nbsp;{{mb_substr($enterpriseshopName, 0, 5, 'utf-8')}}&nbsp;)</span>--}}
               {{-- @else--}}
                 {{-- <span>(&nbsp;独立经纪人&nbsp;)</span>--}}
               {{-- @endif--}}
                </a>
                            <a class="aTit"><i>电话:</i><span>
                                        @if(!empty($agent->_source->mobile))
                                        {{$agent->_source->mobile}}
                                        @else
                                        暂无资料
                                        @endif
                                    </span></a>
			</div>
			<!--<h5 class="footer_btn" onclick="phoneNum({{!empty($communityId)?$communityId:''}},{{!empty($agent->_source->id)?$agent->_source->id:''}});">点击获取安全号码</h5>-->
                        {{--<a href="#" class="footer_btn" onclick="phoneNum({{!empty($communityId)?$communityId:''}},{{!empty($agent->_source->id)?$agent->_source->id:''}});">点击获取安全号码</a>--}}
                
		</div>
                

<input type="hidden" name="jingduMap" value="{{(!empty($jingduMap)) ? $jingduMap : '0'}}">
<input type="hidden" name="weiduMap" value="{{(!empty($weiduMap)) ? $weiduMap : '0'}}">
	<script src="/h5/dist/js/swiper-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
        
        <script src="/h5/js/common/iscroll.js" type="text/javascript"></script>
	<script src="/h5/js/common/iscroll-probe.js"  type="text/javascript"></script>
        <script type="text/javascript" src="/h5/js/demo.js"></script>
        
        <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>
        
	<script type="text/javascript">
    var myScroll1;
    function loaded () {
        var pageWrapper = $(".wrapper");
        myScroll1 = new IScroll('.scroller', {mouseWheel: true });   
    }
    loaded();
    function lo(){
        $("#lerror").hide();
        $("#lname").val('');
        $('#lpwd').val('');
        $("#islname").attr("class","answ");
        $("#islpwd").attr("class","ans");
    }
    //关注方法
    point_interest('focus','esfIndex');
    /**************************************地图js代码start***************************************/
    var longitude = $('input[name="jingduMap"]').val();
    var latitude = $('input[name="weiduMap"]').val();
    if(longitude == 0 && latitude == 0){
        longitude = '116.39750';
        latitude = '39.907761';
    }

    //周边配套
    var windowsArr = new Array();
    var map1 = new AMap.Map("map1", {
        resizeEnable: true,
        center:[longitude, latitude],
        zoom:15,
        zooms:[3,19]
    });
    //添加marker点
    var marker1 = new AMap.Marker({
        //icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
        position: [longitude, latitude]
    });
    marker1.setMap(map1);
    //周边点击
    $('.chechData').bind('click',function(){
        var data1 = $(this).attr('attr');
        chechData(data1);
        $(this).parent().find('span').removeClass('active');
        $(this).find('span').addClass('active');
    });

    function chechData(data1){
        //$('.periphery_nav').hide();
        //$('.periphery_build').show();
        map1.clearMap();
        AMap.service(["AMap.PlaceSearch"], function() {
            var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                pageSize: 5,
                type: data1,
                pageIndex: 1,
                center:[longitude, latitude],//城市
                map: map1,
                panel: "panel"
            });
            var cpoint = [longitude, latitude]; //中心点坐标
            placeSearch.searchNearBy('', cpoint, 1000, function(status, result) {
                map1.setZoom(15);
                // map1.panBy(-200,0);
                $('.poi-more').hide(); //详情链接隐藏
                //console.log(status);
                //console.log(result.poiList.pois);
                var html = "";
                window.marker2=new Array();
                //window.windowsArr.splice(0,window.windowsArr.length);
                window.windowsArr=new Array();
                $.each(result.poiList.pois,function(k,v){
                    html += '<li onclick="openMarkerTipById1('+k+',this)"><em>'+v.name+'</em><b>'+v.distance+'米</b></li>';
                    addmarker(k, [v.location.lng,v.location.lat,v.name]);
                });
                
                $("#panel").html(html);
                
            });
        });
    }
    
    //添加marker&infowindow
    var marker2 = new Array();
    var windowsArr=new Array();
    function addmarker(i, d) {
        var lngX = d[0];
        var latY = d[1];
        var iName = d[2];
        var markerOption = {
            map:map1,
            //icon:"http://webapi.amap.com/images/" + (parseInt(i) + 1) + ".png",
            content:'<div class=\"amap_lib_placeSearch_poi\">'+ (parseInt(i) + 1) +'</div>',
            position:new AMap.LngLat(lngX, latY)
        };
        var mar = new AMap.Marker(markerOption);
        marker2.push(new AMap.LngLat(lngX, latY));
        var infoWindow = new AMap.InfoWindow({
            content:"<h3><font color=\"#00a6ac\">" + (parseInt(i) + 1) + ". " + iName + "</font></h3>",
            size:new AMap.Size(200, 0),
            autoMove:true,
            offset:new AMap.Pixel(0,-30)
        });
        windowsArr.push(infoWindow);
        var aa = function (e) {infoWindow.open(map, mar.getPosition());};
        AMap.event.addListener(mar, "click", aa);
    }
    function openMarkerTipById1(pointid, thiss) {  //根据id 打开搜索结果点tip
        windowsArr[pointid].open(map1, marker2[pointid]);
    }
    
    
    chechData("公交");
    $('.main_postion img').css('display','none');
    
    /**************************************地图js代码end***************************************/
    
    /**************************************折线图js代码start***************************************/
    var _token=$('input[name="_token"]').val();
    var communityId='{{$communityId}}';
    var busnessId="{{!empty($viewShowInfo['businessAreaId'])?$viewShowInfo['businessAreaId']:0}}";
    var cType2='{{$type2}}';
    var dataType='';
        $(function(){
        $("li[class^=house_List]").click(function(){
            $(this).parent().find("li").removeClass("house_first");  
            $(this).addClass("house_first");
        });
        
        var room='2';
        if (parseInt(cType2)==304) {
          room='3';
        }
        $('span[tag1^=community_type]').click(function(){
//            $(this).parent().find('a').removeClass('active');
//            $(this).addClass("active"); 
            $(this).parent().find('span').removeClass('active');
            $(this).addClass('active');
            dataType=$(this).attr('tag1');
            var saleRent='rent';
            if ($(this).attr('tag2')=='comsaleprice') {
                saleRent='sale';
            }
            getSalePrice(communityId,saleRent,cType2,room,dataType,busnessId);
            if ($(this).attr('tag2')=='comsaleprice') {
                $("#communityChart").toggleClass('active');
                $("#communityRent").toggleClass('active');
            }else{
                $("#communityRent").toggleClass('active');
                $("#communityChart").toggleClass('active');
            }
            
        });
        getSalePrice(communityId,'sale',cType2,room,'community_type',busnessId);//出售（二手房折线图）

        //getSalePrice(communityId,'rent',cType2,room,'community_type',busnessId);//出租
    });
    
    
    function getSalePrice(g_communityid,saleRent,tempType2,room,datatype,busnessid)
    {
        
        var type='1';
        if (saleRent=='sale') {
          type='2';
        }
        // var tempType2=$('#saleTagId .click').attr('id');

        var rentUnit='元/月';
        if (parseInt(tempType2)<300) {
         rentUnit='元/天/平米';
        }


        $.post('/ajax/checkprice',{'busness':busnessid,'comid':g_communityid,'type':type,'ctype2':tempType2,'datatype':datatype,'_token':_token,'room':room,'benew':'0'},function(d){
        //console.info(d);

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
            roomTagHtml+='<li onClick="clickRoomTag(this)" class="house_first">'+d.roomTags[i]+'</li>';
          }else
          {
            roomTagHtml+='<li onClick="clickRoomTag(this)">'+d.roomTags[i]+'</li>';
          }

        }
        

        if (saleRent=='sale') {
          $('#tag_sale').html(roomTagHtml);
          if(!beSelect&&$('#tag_sale li').first().length>0)
          {
            $('#tag_sale li').first().addClass('house_first');
          }
        }else
        {
          $('#tag_sale').html(roomTagHtml);
          if(!beSelect&&$('#tag_sale li').first().length>0)
          {
            $('#tag_sale li').first().addClass('house_first');
          }
        }
        
        //$('#tag_sale li').removeClass('house_first');
        },'json');
    }

function showCharts (title,artime,arprice) { 

  //console.info(arprice);
  //$('#saleRoomPrice').html(title);
  //var priceTitle=title;
  $('#communityRent').removeClass('active');
  $('#communityChart').addClass('active');
  $('#communityRent').html('<div style="height:310px;"></div>');
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
      borderWidth: 0,
    },
    series:arprice 
  });
}
function showRentCharts (title,artime,arprice,unit) { 
//function showRentMap (arTime,arPrice,priceTitle) { 
  //console.info(arprice);
  //$('#rentRoomPrice').html(title);
  //var priceTitle=title;
  $('#communityChart').removeClass('active');
  $('#communityRent').addClass('active');
  $('#communityChart').html('<div style="height:310px;"></div>');
  $('#communityRent').highcharts({ 
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
  //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655','#FFF263', '#6AF9C4'] ,
  tooltip: { 
      //valueSuffix: '元'
      formatter: function () {
        var tempvalue;
        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' '+unit;
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


function clickRoomTag(obj)
{

  //$(obj).parent().find("a").removeClass("house_first");  
  //$(obj).addClass("house_first");
  room=getRoomByTag($(obj).text());
  //var tagType=$(obj).parent().attr('id');
  var tagType=$("span[tag1*=community_type][class*=active]").attr('tag2');
  var beSale='rent';
if (tagType=='comsaleprice') {
	beSale='sale';
}
  


  getSalePrice(communityId,beSale,cType2,room,"community_type",busnessId);
}

function getRoomByTag(strTag)
{
  if (strTag=='一居室') {
    return '1';
  }else if(strTag=='二居室')
  {
    return '2';
  }else if(strTag=='三居室')
  {
    return '3';
  }else if(strTag=='四居室')
  {
    return '4';
  }else if(strTag=='五居室')
  {
    return '5';
  }else if(strTag=='六居室')
  {
    return '6';
  }else if(strTag=='七居室')
  {
    return '7';
  }else if(strTag=='八居室')
  {
    return '8';
  }
  return '2';

}


/******************折线图js代码end*********************/


/*****************虚拟手机号start*************************/
//$(".box_btn").bind("tap",function(){
//    $(".footer_btn").css("display","block");
//});

//$(".footer_btn").bind("tap",function(){
//    $(".modal_box").css("display","block");
//});

//获取手机验证码
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
                        if (data != 1) {	 //成功
                            $('#msphonequickLoginMobile').html('发送成功');
                            $("#msphonequickLoginMobile").css("color", "green");
                            $('#msphonequickLoginMobile').show();
                            b = 1;
                        } else {	 //失败
                            $('#msphonequickLoginMobile').html('发送失败');
                            $("#msphonequickLoginMobile").css("color", "red");
                            b = 0;
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
                                $(".modalBox").css('display','none');
                                    $(".modal_box").hide("fast");
                                    $(".footer_btn").text(d.message);
                                    $(".footer_btn").attr('href','tel:'+d.message);
                                    $(".footer_btn").removeAttr("onclick");
                            }else{
                                $(".modal_box").show();
                                $(".modalBox").css('display','block');
                               // $(".box_active").css('display','block');
                               $('body').css('overflow','hidden');
                                $(".modal_box .box_btn").on('tap',function(){
                                    $('.modal_box').hide();
                                   // $(".box_active").css('display','none');
                                    $(".modalBox").css('display','none');
                                });
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
        var cId = {{$communityId}};
        var brokerId = {{!empty($agent->_source->id)?($agent->_source->id):'0'}};
        //var cId = $('#cId_quickLoginMobile').val();
        //var brokerId = $('#brokerId_quickLoginMobile').val();
        /*if (crtoken == '' || customerMobile == '' || ryzm == '' || cId == '' || brokerId == '') {
         alert('数据不全');
         return false;
         }*/
        /*$.ajax({
         type:'post',
         url:'/ajax/registerQuickMobile',
         data:{
         _token:crtoken,
         mobile:mobile,
         captcha:ryzm,
         },
         //	 dataType:'json',
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
//    	 thisObj.show();
//    	 thisObj.next().hide();
                if (d.result == true) {
                    //Object {result: true, message: "15359102947", userName: "dfh420984", mobile: "13331139424"}
                    //alert(d.message);
                    //console.log(d);
                    $(".modalBox").css('display','none');
                    $(".modal_box,.box_active").hide();
                    $(".footer_btn").html(d.message);
                    $(".footer_btn").attr('href','tel:'+d.message);
                }else{
                    alert(d.message);
                }
            }
        });
    }
/*****************虚拟手机号end*************************/

/*****************滑动加载start*************************/
var proSort = {
    
    canLoad:false,//是否允许加载下一页数据
    pageNum:0,//当前请求第几页数据
    limit:6,//每页数据长度
    type:1,//选项卡状态
    
    //初始化
    init:function(){
        proSort.$list = $('#newList');
	proSort.addData();
    },
    
    //添加数据
    addData:function(clear){
        proSort.canLoad = true;
        var str = window.location.pathname;
        if(++proSort.pageNum==1){
            return ;
        }
        $.ajax({
            url : str,
            dataType :'json',
            type : 'get',
            data:{
                'page':proSort.pageNum,
                'tag':'page'
            },
            success : function(data){
                //console.log(data);
                var html = '';
                if(data.result===false){
                    proSort.canLoad = false;
                    return;
                }
                for(var i=0;i<data.count;++i){
                    html += '<li class="index_footer"><a href="/housedetail/'+data[i].house[2]+data[i]._source.id+'.html"><img src="'+data[i].img+'" /><div class="index_Hmain fl"><h3>'+data[i]._source.title+'</h3><h6>';
                    html +=((data[i].commName+data[i].cityArea+data[i].businessArea)?('<em>'+data[i].commName+'</em>&nbsp;&nbsp;'+data[i].cityArea+' '+data[i].businessArea):'暂无资料')+'</h6><ul><li>'+data[i].house[1]+'<i>|</i></li><li>'+data[i]._source.area+'平<i>|</i></li><li>'+data[i]._source.currentFloor+'/'+data[i]._source.totalFloor+'层<i>|</i></li><li>'+((data.faces[data[i]._source.faceTo]=='')?'未知':data.faces[data[i]._source.faceTo])+'</li>';
                    html +='<div class="house_Chouse fl">';
                    for(var j=0;j<data[i]['featurestag'].length;++j){
                        html += '<span class="house_Csub fl">'+data[i]['featurestag'][j]+'</span>';
                    }
                    
                    html +='</div></div>';    
                    html +='<h6 class="prot_Pic"><span class="average"><i>'+data[i].price+'</i>';
                    if(data[i].price!='面议'){
                        html +='<em>';
                        if(data[i].house[2]=='ss'){
                            html +='万';
                        }else{
                            html +='元/月';
                        }
                        html +='</em>';
                    }
                    html +='</span></h6></a></li>';
                    //console.log(html);
                    $('#newList').append(html);
                    html='';
                    
                    myScroll.refresh();//重新计算高度
                }
            }
        });
    },
    
    //刷新，需要初始化属性
    upData:function(){
    proSort.pageNum = 0;
    proSort.canLoad = false;
    proSort.addData(true);
    }
}




/*****************滑动加载end*************************/
</script>

@endsection

