<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta http-equiv="Pragma"content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="expires"content="0">
		<title>地图搜房</title>
		<link rel="stylesheet" type="text/css" href="/h5/css/map.css" />
		<link rel="stylesheet" type="text/css" href="/h5/css/common/common.css" />
		<script src="/h5/js/common/zepto.js"></script>
        <script src="/h5/js/map.js" type="text/javascript" charset="utf-8"></script>
        <script src="/js/jquery1.11.3.min.js" type="text/javascript"></script>
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
		<!--========================地图页header开始======================================-->
        <header class="house_header">
            <div class="house_Hbg fl"><a href="javascript:window.history.go(-1)"></a></div>
            <div class="list_search ">
                <i class="search_btn ps"></i>
                <input type="text" name="text"  placeholder="搜索楼盘名称/地址" class="search" />
                <ul class="seatList"></ul>
                <div class="index_map">
                    <span class="index_Sroom fl" id="btn"><i class="Sroon_i" style="text-align: center;">
                         @if($type=='sale')
                             二手房
                         @else
                             @if($housetype1==3)
                                 租房
                             @elseif($housetype1==2)
                                 写字楼出租
                             @else
                                 商铺出租
                             @endif
                         @endif
                        </i></span>
                    <ul class="Sroom_Ul">
                        <li>新房</li>
                        <li>二手房</li>
                        <li>租房</li>
                        <li>写字楼出租</li>
                        <li>商铺出租</li>
                    </ul>
                </div>
            </div>
            <a class="map_List fr" href="#"></a>
        </header>
		<!--========================地图页header结束======================================-->
		<div class="space24"></div>
		
		<!--========================地图页Nav开始=========================================-->
		<nav class="map_nav">
			
			<ul class="house_Nlist" id="pagenavi">
				<li class="Nlist_left fl"><a href="##">位置</a><i></i><b></b></li>
				<li class="Nlist_left fl"><a href="##">
                        @if($type =="sale")
                        总价
                        @elseif($type=="rent")
                            租金
                        @endif
                    </a><i></i><b></b></li>
				<li class="Nlist_left fl"><a href="##">面积</a><i></i><b></b></li>
                @if($type =='sale')
				<li class="Nlist_right fl"><a href="##">更多</a><i></i></li>
                @else
                    @if($housetype1==3)
                        <li class="Nlist_right fl"><a href="##">更多</a><i></i></li>
                    @endif
                @endif
			</ul>
			<section class="house_Nfliter ps" id="slide">
				<div class="Nfliter_shaw subway ps">
					<ul class="Nfliter_Lista subwayLeft">
						<li class="active">区域</li>
						<li>地铁</li>
					</ul>
					<div class="area_box">
						<ul class="box_area active">
							<li>不限</li>
                            @foreach($cityAreas as $key=>$cityarea)
							<li value="{{$cityarea->id}}" longitude="{{$cityarea->longitude}}" latitude="{{$cityarea->latitude}}">{{$cityarea->name}}</li>
                            @endforeach
						</ul>
						<ul class="box_subarea ">
							<li>不限</li>
							@foreach($subways as $key=>$subway)
								<?php $subline = explode('-',$key);?>
							<li>{{$subline[0]}}</li>
					        @endforeach
						</ul>
					</div>
					<div class="area_box2 ">
						<ul class="box_area2"><li><a href="##"></a></li></ul>
						@foreach($subways as $key=>$subway)
									<ul class="box_area2">
										@foreach($subway as $station)
											<li lineId="{{$station->lineId}}" stationId="{{$station->id}}" lng="{{$station->longitude}}" lat="{{$station->latitude}}" lineName="{{$station->linename}}"><a href="javascript:void(0);">{{$station->name}}</a></li>
										@endforeach
									</ul>
						@endforeach
					</div>
				</div>
				<div class="ulPrice">
					<ul class="box ul_Price ">
                        @if($type=="sale")
                            @foreach($totalprice['text'] as $key=>$price)
                                <li value="{{$key}}">{{$price}}</li>
                            @endforeach
                        @elseif($type=="rent")
                            @foreach($avgprice['text'] as $key => $price)
                                <li value="{{$key}}">{{$price}}</li>
                            @endforeach
                        @endif
					</ul>
				</div>
				<div class="ulApart">
					<ul class=" box ul_Apart">
                        @if(array_key_exists('text', $areas))
                            @foreach($areas['text'] as $key=>$area)
                                <li value="{{$key}}">{{$area}}</li>
                            @endforeach
                        @endif
					</ul>
				</div>	
				<div class="Nfliter_shaw ps">
					<ul class="Nfliter_List">
						<li class="active">户型</li>
						<li>朝向</li>
					</ul>
					<div class="shaw_box">
						<ul class="box_Listarea active">
                                @if(array_key_exists('text', $houseRoom))
                                    @foreach($houseRoom['text'] as $key=>$room)
                                        <li value="{{$key}}">{{$room}}</li>
                                    @endforeach
                                @endif
						</ul>
						<ul class="box_Listarea">
                            @if(array_key_exists('text', $faceTo))
                                @foreach($faceTo['text'] as $key=>$face)
                                <li value="{{$key}}">{{$face}}</li>
                                @endforeach
                            @endif
						</ul>
					</div>
				</div>
			</section>
				</nav>
		<!--========================地图页Nav开始=========================================-->
		<div class="space32"></div>
		<!--==================内容区域，获取数据开始==========================================-->

		<div class="con_Map">
			<div id="container"></div>
			<!--<div class="map_Ps ps ">
				<a href="##" class="map_Ret"></a>
				<a href="##" class="map_Pos"></a>
			</div>-->
		</div>
        <div class="mapList">
            <!--====================二手房开始==========================-->
            @if($type=='sale')
                <div class="secListRoom pos1">
                    <div class="mapListTit ">
                        <h3>二手房楼盘</h3>
                    </div>
            @else
                   @if($housetype1=='1')
                        <div class="storeListRoom pos5">
                            <div class="mapListTit">
                                <h3>商铺楼盘名</h3>
                            </div>
                   @elseif($housetype1=='2')
                        <div class="officeListRoom pos6">
                            <div class="mapListTit">
                                <h3>写字楼楼盘名</h3>
                            </div>
                   @else
                        <div class="rentListRoom pos3">
                            <div class="mapListTit">
                                <h3>租房楼盘</h3>
                            </div>
                   @endif
            @endif
                <div class="houseList">
                    <ul class="houstListUl"></ul>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Y1kG709UBP4L0ac6SvTjxnm7"></script>
        <script type="text/javascript">
            var g_cityareaMaxLevel = 14;
            var g_businessareaMaxLevel = 16;
            var g_communityMaxLevel = 17;
            var g_linesearch = null;
            var g_querySubwayLine = null;
            var g_subwayLine = null;
            var g_lineId = 0;
            var g_stationId = 0;
            var g_cityareaId = 0;
            var g_cityareaDistrict = null;
            var g_cityareaLines = new Array();
            var g_businessDistrict = null;
            var g_businessAreaId = 0;
            var g_markers = new Array();
            var bound0 = null;
            var zoom0 = 0;
            var type = "{{$type}}";
            var housetype1 = "{{$housetype1}}";
            var housetype2 = '';
            var keyword = "";
            var totalprice = "";
            var areas = "";
            var houseRoom = "";
            var faceTo = "";
            var communityid = "";
            var g_map;
            var isLoad = true;
            var isSearch = true;
            var year = 0;
            var floor = 0;
            var decorate = 0;
            var buildtype = 0;
            var structure = 0;
            var peitao = '';
            var tags = '';
            var cityCenter = [{{$city->lng}}, {{$city->lat}}];
            var page = 1;
            var sort = 'dese';
            var saleStatus = 0;
            var openTime = 0;

			var cityLongitude ="{{$city->lng}}";   //地图中心点经度
			var cityLatitude =  "{{$city->lat}}";  //纬度
			var cCenterMark='';
			var g_subwayLine='';
			var bCenterMark='';
			var tempcommunityId =0;
            //$(function() {

                var windowWidth  = $("#container").width();
                var windowHeight = $("#container").height();

                /*var g_map = new AMap.Map('container', {   //构造地图
                    zoom: 12,
                    center: cityCenter,
                    zooms: [11, 19],
                    animateEnable: false,
                    jogEnable: false
                });*/

				g_map = new BMap.Map("container",{enableMapClick:false});    // 创建百度Map实例
				g_map.centerAndZoom(new BMap.Point(cityLongitude, cityLatitude), 12);  // 初始化地图,设置中心点坐标和地图级

//                AMap.plugin(['AMap.ToolBar'], function () {  //添加工具条
//                    g_map.addControl(new AMap.ToolBar({
//                        offset: new AMap.Pixel(windowWidth - 700, windowHeight - 800)
//                    }));
//                });
//
//                AMap.plugin(['AMap.Scale'], function () {  //添加比例尺
//                    g_map.addControl(new AMap.Scale());
//                });

				//中心点坐标
				cCenterMark = new BMap.Marker(new BMap.Point(cityLongitude, cityLatitude));
				g_map.addOverlay(cCenterMark);

				var top_left_navigation = new BMap.NavigationControl({
					// LARGE类型
					type: BMAP_NAVIGATION_CONTROL_LARGE,
					// 启用显示定位
					offset: new BMap.Size(windowWidth - 700, windowHeight - 800)
				});  //左上角，添加默认缩放平移控件
				g_map.addControl(top_left_navigation);
				g_map.enableScrollWheelZoom(true);

               g_map.addEventListener("zoomend", function () {  //地图缩放事件
				    if(g_stationId>0 && g_map.getZoom()<15){
						return false;
					}
                    if (g_map.getZoom() < g_cityareaMaxLevel && zoom0 >= 13) {
						g_map.clearOverlays();
                        g_map.setCenter(cityCenter);
                        g_businessAreaId = 0;
                        communityid = '';
                        g_markers = new Array();
                        bound0 = null;
                        searchHouse();
                    } else if (g_map.getZoom() >= g_cityareaMaxLevel && g_map.getZoom() < g_businessareaMaxLevel) {
                        if (zoom0 < g_cityareaMaxLevel || zoom0 >= g_businessareaMaxLevel) {
							g_map.clearOverlays();
                            g_markers = new Array();
                            bound0 = null;
                            //searchMap();
                            searchHouse();
                        } else if (g_map.getZoom() < zoom0) {
                            if (g_subwayLine != "") {
                                bound0 = null;
                            }
                            //searchMap();
                            searchHouse();
                        }
                    } else if (g_map.getZoom() >= g_businessareaMaxLevel) {
                        if (zoom0 < g_businessareaMaxLevel) {
							if(g_stationId<1){
								g_map.clearOverlays();
							}
                            g_markers = new Array();
                            bound0 = null;
                        }
                        if (g_map.getZoom() < zoom0 || zoom0 < g_businessareaMaxLevel) {
                            //searchMap();
                            searchHouse();
                        }
                    }
                    zoom0 = g_map.getZoom();
                });
                g_map.addEventListener("dragend", function () { //地图拖动事件
                    if (g_map.getZoom() >= g_cityareaMaxLevel) {
                        searchHouse();
                    }
                });

               g_map.addEventListener("click", function () { //地图点击事件
                    $(".Sroom_Ul").hide();
                    $(".seatList").hide();
				   if(!$(".mapList").is(":hidden")){
					   $(".mapList").hide();
					   $("#container").css('height','1156');
				   }
			   });

                var searchHouse = function () {
					g_map.addOverlay(cCenterMark);
                    var bound = g_map.getBounds();
                    var psw = bound.getSouthWest();
                    var pne = bound.getNorthEast();
                    if(g_cityareaId>0){
                        $(".box_area li").each(function(){
                            if($(this).attr('areaid')==g_cityareaId){
                                $('.house_Nlist li').eq(0).find('a').text($(this).text());
                            }
                        });
                    }
                    if(keyword!=""){
						var data = {
							totalprice: totalprice,
							areas: areas,
							houseRoom: houseRoom,
							faceTo: faceTo,
							housetype1: housetype1, //物业类型（普通住宅、公寓、写字楼。。。）
							housetype2: housetype2, //物业类型（普通住宅、公寓、写字楼。。。）
							type: type, //销售类型（出租、出售）
							ca: g_cityareaId, //城区id
							zm: g_map.getZoom(), //获取当前放大级别
							swlng: psw.lng, //西南经度
							swlat: psw.lat, //西南纬度
							nelng: pne.lng, //东北（右上）
							nelat: pne.lat,
							year: year,
							floor: floor,
							decorate: decorate,
							buildtype: buildtype,
							structure: structure,
							peitao: peitao,
							tags: tags,
							pg: 1,
							sort: sort,
							communityId: communityid//楼盘id
						};

					}else{
						var data = {
							keyword: keyword, //搜索框关键词
							totalprice: totalprice,
							areas: areas,
							houseRoom: houseRoom,
							faceTo: faceTo,
							housetype1: housetype1, //物业类型（普通住宅、公寓、写字楼。。。）
							housetype2: housetype2, //物业类型（普通住宅、公寓、写字楼。。。）
							type: type, //销售类型（出租、出售）
							ca: g_cityareaId, //城区id
							zm: g_map.getZoom(), //获取当前放大级别
							swlng: psw.lng, //西南经度
							swlat: psw.lat, //西南纬度
							nelng: pne.lng, //东北（右上）
							nelat: pne.lat,
							year: year,
							floor: floor,
							decorate: decorate,
							buildtype: buildtype,
							structure: structure,
							peitao: peitao,
							tags: tags,
							pg: 1,
							sort: sort
							//communityid: 0//楼盘id
						};
					}

                    $.ajax({
                        url:"/ajax/map/search",
                        data:data,
                        dataType:'json',
                        success:function (r) {
                            if (r.s == "1") {
                                for (var i = 0; i < r.r.length; i++) {
                                    var m = r.r[i];
                                    if (m.lng == null || m.lat == null) {
                                        continue;
                                    }
                                    if (isPointExist(m.lng, m.lat)) {
                                        continue;
                                    }
                                    //var htm = '<div class="quyu"><a><p class="margin_t">' + m.name + '</p><p><span>' + m.count + '</span>套</p></a></div>';
                                    /*if(g_cityareaId>0){
                                        g_map.setCenter([m.lng, m.lat]);
                                    }*/
                                    var htm='<div class="mapArea"><a href="##"><i>'+ m.name+'</i><em>'+ m.count+'套</em></a></div>';
									var point = new BMap.Point(m.lng, m.lat);
									var label = new BMap.Label(htm,{position:point,offset: new BMap.Size(-57, -57)});
									label.setStyle({backgroundColor:"none",border:"none"});
									g_map.addOverlay(label); // 将标注添加到地图中
								    addCityAreaHandler(label, m);
                                }
                            } else if (r.s == "2") {
                                for (var i = 0; i < r.r.length; i++) {
                                    var m = r.r[i];
                                    if (bound0 != null) {
                                        if (m.lng >= bound0.getSouthWest().lng && m.lng <= bound0.getNorthEast().lng && m.lat >= bound0.getSouthWest().lat && m.lat <= bound0.getNorthEast().lat) {
                                            continue;
                                        }
                                    }
                                    if (isPointExist(m.lng, m.lat)) {
                                        continue;
                                    }
                                    //var htm = '<div class="tube"><div class="num">' + m.count + '套</div><div class="name">' + m.name + '</div></div>';
                                    var htm = '<div class="ulNum"><a href="#"><p><i>'+ m.count+'</i><b>套</b></p><h5 class="map_add">'+ m.name+'</h5></a></div>';
									var point = new BMap.Point(m.lng, m.lat);
									var label = new BMap.Label(htm,{position:point,offset:new BMap.Size(-55,-73)});
									label.setStyle({backgroundColor:"none",border:"none"});
									g_map.addOverlay(label); // 将标注添加到地图中
                                    g_markers.push(label);
                                    addBusinessAreaHandler(label, m);
                                }
                            } else if (r.s == "3") {
                                for (var i = 0; i < r.r.length; i++) {
                                    var m = r.r[i];
									//if(g_stationId<1){
//										if (bound0 != null) {
//											if (m.lng >= bound0.getSouthWest().lng && m.lng <= bound0.getNorthEast().lng && m.lat >= bound0.getSouthWest().lat && m.lat <= bound0.getNorthEast().lat) {
//												continue;
//											}
//										}
										//alert("经度"+bound0.getSouthWest().lng+","+bound0.getNorthEast().lng+"纬度"+bound0.getSouthWest().lat+","+bound0.getNorthEast().lat);
										if (isPointExist(m.lng, m.lat)) {
											continue;
										}
									//}


									var htm = '<div class="map_Li"><a href="##" id="c'+m.id+'">'+m.count+'</a></div>';
									var point = new BMap.Point(m.lng, m.lat);
									var label = new BMap.Label(htm,{position:point,offset:new BMap.Size(-40,-40)});
									label.setStyle({backgroundColor:"none",border:"none"});
									g_map.addOverlay(label); // 将标注添加到地图中
									g_markers.push(label);
                                    addCommunityHandler(label, m);
                                }
                            }
                            bound0 = bound;
                        }
                    });
                };

                var isPointExist = function (lng, lat) {  //经度纬度集合判断
                    for (var i = 0; i < g_markers.length - 1; i++) {
                        var p = g_markers[i].getPosition();
                        if (p.lng == lng && p.lat == lat) {
                            return true;
                        }
                    }
                    return false;
                };

                searchHouse()//地图第一次进来加载

                var addCityAreaHandler = function (marker, entity) {  //添加城区点击事件监听器
                    marker.addEventListener("click", function () {
                        g_cityareaId = entity.id;
                        /*$(".box_area li").each(function(){
                            if($(this).attr('value')==g_cityareaId){
                                $('.house_Nlist li').eq(0).find('a').text($(this).text());
                            }
                        });*/
                        //searchBusinessareaByCityid(g_cityareaId);
                        g_map.setCenter(marker.getPosition());
						cCenterMark = new BMap.Marker(marker.getPosition());
                        g_map.setZoom(g_cityareaMaxLevel);
                    });
                };
                var searchBusinessareaByCityid = function (id) {   //城区点击触发动作
                    var data = {
                        type: type, //销售类型（出租、出售）
                        sort: sort,
                        caid: id, //城区id
                        housetype1: housetype1,
                        housetype2: housetype2,
                        keyword: keyword,
                        totalprice: totalprice,
                        areas: areas,
                        houseRoom: houseRoom,
                        faceTo: faceTo
                    };
                    $.getJSON("/ajax/map/getbusinessarea", data, function (r) {
                        if (r.stuts == 1) {
							var houseList = r.house.hits;
							var point = new BMap.Point(r.cdate.longitude,r.cdate.latitude);
							g_map.setCenter(point);
                            g_map.setZoom(g_cityareaMaxLevel);
                        }
                    })
                }
                var addBusinessAreaHandler = function (marker, entity) {  //添加商圈点击动作监听器
                    marker.addEventListener("click", function () {
                        g_businessAreaId = entity.id;
                        //searchCommunityByBid(g_businessAreaId);
                        g_map.setCenter(marker.getPosition());
						cCenterMark = new BMap.Marker(marker.getPosition());
						g_map.addOverlay(cCenterMark);
                       // businessPos = marker.getPosition();
                        g_map.setZoom(g_businessareaMaxLevel);
                    });
                };

                var searchCommunityByBid = function (id) {  //点击商圈到小区这一层级
                    var data = {
                        type: type, //销售类型（出租、出售）
                        sort: sort,
                        bid: id, //城区id
                        housetype1: housetype1,
                        housetype2: housetype2,
                        keyword: keyword,
                        totalprice: totalprice,
                        areas: areas,
                        houseRoom: houseRoom,
                        faceTo: faceTo
                    };
                    $.ajax({
                        url: "/ajax/map/getcommunity",
                        post:'POST',
                        data:data,
                        async: false,
                        dataType:'json',
                        success:function (r) {
                            if (r.stuts == 1) {
                                if(r.hdate.hits.hits.length>=1){
                                    var houseList = r.hdate.hits.hits[0]._source;
                                    communityid = houseList.id;
									var point = new BMap.Point(houseList.longitude, houseList.latitude);
									cCenterMark = new BMap.Marker(point);
									g_map.setCenter(point);
                                }

                            }
                        }
                    })
                }

                var addCommunityHandler = function (marker, entity) {  //点击小区触发的事件
                    marker.addEventListener("click", function () {
						$("#c"+communityid).removeClass('active');
                        $("#c"+entity.id).addClass('active');
                        communityid = entity.id;
						//tempcommunityId = entity.id;
                        $("#container").css('height','645');
						g_map.enableAutoResize();
                        $(".mapListTit").html("<h3>"+entity.name+"</h3>");
						if(g_stationId<=0){
							g_map.setCenter(marker.getPosition());
						}
                        if(g_map.getZoom()<=15){
                           g_map.setZoom(16);
                        }else{
                           searchHouse();
                        }
						searchHouseByCid(entity.id, false);
                    });
                };

                var isScrool = true; //滚动效果添加房源信息
                var searchHouseByCid = function (cid, ispage) { //社区搜索房源
                    if (isScrool) {
                        isScrool = false;
                        if (!ispage) {
                            communityid = cid;
                            page = 1;
                            $(".houstListUl").empty();
                        } else {
                            page = page + 1;
                        }
                        var data = {
                            type: type, //销售类型（出租、出售）
                            sort: sort,
                            housetype1: housetype1,
                            housetype2: housetype2,
                            communityid: cid,
                            //keyword: keyword,
                            totalprice: totalprice,
                            areas: areas,
                            houseRoom: houseRoom,
                            faceTo: faceTo,
                            page: page
                        };
                        $.ajax({
                            url:'/ajax/map/gethouse',
                            data:data,
                            dataType:'json',
                            success:function (r) {
                                if (r.stuts == 1) {
                                    var houseList = r.hdate.hits;
                                    var house = null;
                                    for (var i = 0; i < houseList.hits.length; i++) {
                                        house = houseList.hits[i]._source;
                                        makehousediv(house);
                                    }
                                }
                            }
                        });
                        isScrool = true;
                    }

                }

                //房源具体信息
                var makehousediv = function (house) {
                    var html = "";
                    if (type == 'sale') {
                        var urltype = 's';
                    } else {
                        var urltype = 'r';
                    }
                    var houseRoomArr = house.roomStr.split('_');

                    if (type == 'sale') {
                        if (house.price2 == 0){
                            var unit = '';
                            var price = '面议';
                        } else {
                            var unit = '元/平米';
                            var price = house.price2+"万";
                        }
                    } else {
                        if (housetype1 == 3){
                            if (house.price1 == 0){
                                var unit = '';
                                var price = '面议';
                            } else {
                                var unit = '元/月';
                                var price = house.price1+unit;
                            }
                        } else {
                            if (house.price2 == 0){
                                var unit = '';
                                var price = '面议';
                            } else {
                                var unit = '元/天/平米';
                                var price = house.price2+unit;
                            }
                        }
                    }

                    html = html +'<li><a href="/housedetail/s' + urltype + house.id + '.html"><div class="room"><img src="'+house.thumbPic+'"/></div>';
                    html = html +'<div class="index_Hmain fl"><h3>'+house.title+'</h3>';

                    if(type=='sale') {
                        html = html +'<span class="secRoom">'+houseRoomArr[0]+'室'+houseRoomArr[1]+'厅</span><span class="secRoom">'+house.area+'平米</span>';
                        html = html +'<div class="houseLable fl">';
                        html = html + '<span>' + house.faceTo + '</span><span>' + house.currentFloor + '/' + house.totalFloor + '层</span></div>';
                    }else {
                        if(housetype1==3) {
                            html = html + '<span class="secRoom">' + houseRoomArr[0] + '室' + houseRoomArr[1] + '厅</span><span class="secRoom">' + house.area + '平米</span>';
                            html = html + '<div class="houseLable fl">';
                            html = html + '<span class="tag1 fl">' + house.faceTo + '</span><span class="tag2 fl">' + house.rentType + '</span></div>';
                        }else if(housetype1==2){ //写字楼
                           html = html +'<p>'+house.name+'</p>';
                           html = html +'<div class="houseLable fl "><span>'+house.rentType+'<i>|</i></span><span>'+house.area+'平米</span></div>';
                        }else if(housetype1==1){ //商铺
                           html= html+'<div class="houseLable fl mg"><span>'+house.houseType2+'<i>|</i></span><span>'+house.area+'平米</span></div>';
                        }
                    }
                    html = html +'</div>';
                    html  =html +'<span class="list_Pic">'+price+'</span></a></li>';
                    $(".houstListUl").append(html);
                    if(type=='sale'){
                        $(".pos1").show();
                    }else{
                        if(housetype1=='1'){
                            $(".pos5").show();
                        }else if(housetype1=='2'){
                            $(".pos6").show();
                        }else{
                            $(".pos3").show();
                        }

                    }

                    $(".mapList").show();

                }
                //条件搜索 城区搜索
                $(".box_area li").on('click',function(){
                	g_stationId=0;
					g_map.clearOverlays();
                    $('.search').val('');
                    keyword='';
                    g_cityareaId   = $(this).attr('value');
                    var longitude  = $(this).attr('longitude');
                    var latitude   = $(this).attr('latitude');
                    var textStr = $(this).text();
                    if(textStr=='不限'){
                        $('.house_Nlist li').eq(0).find('a').text('区域');
                    }
                    $(".mapList").hide();
                    $("#container").css('height','1156');
					$(".house_Nfliter").hide();
                    if(g_map.getZoom()>=14){
                        g_map.setCenter(cityCenter);
                        communityid = '';
                        g_map.setZoom(12);
                    }else {
                        g_map.setCenter([longitude,latitude]);
                        searchHouse();
                    }
                });
                //价格搜索
                $(".ul_Price li").on('click',function(){
					$(".house_Nfliter").hide();
                    $('.search').val('');
                    keyword='';
					if(g_stationId<1){
						g_map.clearOverlays();
					}else{
						for(var p in g_markers){
							g_map.removeOverlay(g_markers[p]);
						}
						g_markers =[];
					}
                    totalprice = $(this).attr('value');
                    var textStr = $(this).text();
                    if(textStr=='不限'){
                        $('.house_Nlist li').eq(1).find('a').text('总价');
                    }
                    $(".mapList").hide();
                    $("#container").css('height','1156');
					if(g_stationId>0){
						searchHouse();
					}else{
						if(g_map.getZoom()>=14){
							g_map.setCenter(cityCenter);
							g_businessAreaId = 0;
							communityid = '';
							g_map.setZoom(12);
						}else {
							searchHouse();
						}
					}

                });
                //面积搜索
                $(".ul_Apart li").on('click',function(){
					$(".house_Nfliter").hide();
                    $('.search').val('');
                    keyword='';
					if(g_stationId<1){
						g_map.clearOverlays();
					}else{
						for(var p in g_markers){
							g_map.removeOverlay(g_markers[p]);
						}
						g_markers =[];
					}
                    areas = $(this).attr('value');
                    var textStr = $(this).text();
                    if(textStr=='不限'){
                        $('.house_Nlist li').eq(2).find('a').text('面积');
                    }
                    $(".mapList").hide();
                    $("#container").css('height','1156');
					if(g_stationId>0){
						searchHouse();
					}else{
						if(g_map.getZoom()>=14){
							g_map.setCenter(cityCenter);
							g_businessAreaId = 0;
							communityid = '';
							g_map.setZoom(12);
						}else {
							searchHouse();
						}
					}
                });
                //面积,朝向搜索
                $(".box_Listarea li").on('click',function(){
					$(".house_Nfliter").hide();
                    $(".mapList").hide();
                    $("#container").css('height','1156');
                    if($(".Nfliter_List > .active").text()=='户型'){
                        if($(this).attr('value') >0){
                            $('.search').val('');
                            keyword='';
                            houseRoom = $(this).attr('value');
                            if( faceTo>0){
                                $('.house_Nlist li').eq(3).find('a').text('更多(2)');
                            }else{
                                $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                            }
							if(g_stationId<1){
								g_map.clearOverlays();
							}else{
								for(var p in g_markers){
									g_map.removeOverlay(g_markers[p]);
								}
								g_markers =[];
							}

							if(g_stationId>0){
								searchHouse();
							}else{
								if(g_map.getZoom()>=14){
									g_map.setCenter(cityCenter);
									g_businessAreaId = 0;
									communityid = '';
									g_map.setZoom(12);
								}else {
									searchHouse();
								}
							}
                        }else{
                            houseRoom =0;
                            if(faceTo>0){
                                $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                            }else{
                                $('.house_Nlist li').eq(3).find('a').text('更多');
                            }
							if(g_stationId<1){
								g_map.clearOverlays();
							}else{
								for(var p in g_markers){
									g_map.removeOverlay(g_markers[p]);
								}
								g_markers =[];
							}
                            searchHouse();
                        }
                    }else if($(".Nfliter_List .active").text()=='朝向'){
                        $(".mapList").hide();
                        $("#container").css('height','1156');
                        if($(this).attr('value') >0){
                            $('.search').val('');
                            keyword='';
                            faceTo = $(this).attr('value');
                            if(houseRoom>0){
                                $('.house_Nlist li').eq(3).find('a').text('更多(2)');
                            }else{
                                $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                            }
							if(g_stationId<1){
								g_map.clearOverlays();
							}else{
								for(var p in g_markers){
									g_map.removeOverlay(g_markers[p]);
								}
								g_markers =[];
							}
							if(g_stationId>0){
								searchHouse();
							}else{
								if(g_map.getZoom()>=14){
									g_map.setCenter(cityCenter);
									g_businessAreaId = 0;
									communityid = '';
									g_map.setZoom(12);
								}else {
									searchHouse();
								}
							}
                        }else{
                            faceTo =0;
                            if(houseRoom>0){
                                $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                            }else{
                                $('.house_Nlist li').eq(3).find('a').text('更多');
                            }
							if(g_stationId<1){
								g_map.clearOverlays();
							}else{
								for(var p in g_markers){
									g_map.removeOverlay(g_markers[p]);
								}
								g_markers =[];
							}
                            searchHouse();
                        }

                    }
                });

                //地图跳转到新楼盘列表页
                $(".map_List").on("click",function(){
                    var paraArr = [];
                    if(g_cityareaId >0){
                        paraArr.push('aa'+g_cityareaId);
                    }
                    if(totalprice>0){
                        paraArr.push('ao'+totalprice);
                    }
                    if(houseRoom>0){
                        paraArr.push('aq'+houseRoom);
                    }
                    if(areas>0){
                        paraArr.push('ap'+areas);
                    }
                    if(faceTo >0){
                        paraArr.push('bb'+faceTo);
                    }
                    //是否到达商圈
                    if(g_businessAreaId >0){
                        paraArr.push('ab'+g_businessAreaId);
                    }
                    var keywords = $('.search').val();
                    //根据条件跳转到相关列表页
                    var toUrl ="";
                    if(type=='sale'){
                        toUrl = "/esfsale/area/";
                    }else{
                        if(housetype1==1){
                            toUrl ="/sprent/area/";
                        }else if(housetype1==2){
                            toUrl ="/xzlrent/area/";
                        }else if(housetype1==3){
                            toUrl ="/esfrent/area/";
                        }
                    }
                    if(paraArr){
                        var  paraStr  = paraArr.join('-');
                        if((keywords!='搜索楼盘名称/地址') && (keywords != '')){
                            window.location.href = toUrl+paraStr+"?kw="+keywords;
                        }else{
                            window.location.href = toUrl+paraStr;
                        }
                    }else{
                        window.location.href=toUrl;
                    }

                });

                //滚动条加载数据
                $(".houseList").bind("scroll", function () {
                    var height = $(this).height();   //可见高度
                    var contentH =$(this).get(0).scrollHeight;  //内容可见高度
                    var scrollTop =$(this).scrollTop();     //滚动条高度
                    if((scrollTop == (contentH -height)) && (!$('.houseList').is(':hidden'))){
                        searchHouseByCid(communityid, true);
                    }
                });
                /** 关键字搜索 **/
                var searchKeyWords = {keyword:'', tp:'', tp1:'', sr:'', obj:null};
                $('.search').on('keyup click', function(ev){
                    var obj  = $(this);
                    var text =$('.Sroon_i').text();
                    var tp='';
                    var reg =/[\u4E00-\u9FA5\uf900-\ufa2d]+/ig;
                    var  tpText=text.match(reg);
                    if(tpText=='新房'){
                        tp ='new';
                    }else if(tpText == '二手房'){
                        tp = 'sale';
                    }else if(tpText == '租房'){
                        tp = 'rent';
                    }else if(tpText =='写字楼出租'){
                        tp = 'xzl';
                    }else if(tpText =='商铺出租'){
                        tp = 'sp';
                    }

                    var val = $.trim($(obj).val());
                    var sr = 1;
                    if(tp == 'new' || tp == 'sale' || tp =='rent'){
                        searchKeyWords.tp1 = '3';
                    }else if(tp == 'xzl'){
                        searchKeyWords.tp1 = '2';
                    }else if(tp == 'sp'){
                        searchKeyWords.tp1 = '1';
                    }else{
                        searchKeyWords.tp1 = '*';
                    }
                    if(tp == 'new' || tp == 'loupan' || tp =='sale'){
                        sr = 2;
                    }
                    searchKeyWords.keyword = val;
                    searchKeyWords.tp = tp;
                    searchKeyWords.sr  = sr;
                    searchKeyWords.obj = obj;
                    getRecommend(searchKeyWords);
                });


                function getRecommend(searchKeyWords){
                    var token = $('#token').val();
                    var url = '/home_search_only';
                    $.ajax({
                        type:'post',
                        url:url,
                        data:{
                            _token:token,
                            keywords:searchKeyWords.keyword,
                            tp:searchKeyWords.tp,
                            tp1:searchKeyWords.tp1,
                            sr:searchKeyWords.sr
                        },
                        success:function(data){
                            //console.log(data);return false;
                            if(data == 0) return false;
                            data = data.res;
                            var dataList = '';
                            for( var i in data){
                                var comName  = data[i]._source.name ? data[i]._source.name : data[i]._source.communityName;
                                if(typeof comName != 'undefined'){
                                    dataList += '<li><a class="selectSearch" value="'+ data[i]._source.id +'">'+ comName +'</a></li>';
                                }
                            }
                            $(".seatList").html(dataList);
                            $(".seatList").show();
                            g_cityareaId=0;
                            g_businessAreaId=0;
                            communityid = 0;
							g_stationId=0;
                            totalprice='';
                            areas='';
                            houseRoom='';
                            faceTo='';
                            $('.house_Nlist li').eq(0).find('a').text('位置');
                            $('.house_Nlist li').eq(1).find('a').text('总价');
                            $('.house_Nlist li').eq(2).find('a').text('面积');
                            $('.house_Nlist li').eq(3).find('a').text('更多');

							if(!$(".mapList").is(":hidden")){
								$(".mapList").hide();
								$("#container").css('height','1156');
							}
                            $('.selectSearch').on('tap',function(){
                                keyword = $(this).text();
                                $('.search').val(keyword);
                                $(".seatList").hide();
                                g_map.clearOverlays();
                                searchCommunityByBid();
                               if(g_map.getZoom() == g_businessareaMaxLevel){
                                    searchHouse();
                                }else{
                                   g_map.setZoom(g_businessareaMaxLevel);
                                }
                            });
                        }
                    });
                }

                //搜索关键字失去焦点时隐藏下拉框
                $('.search').blur(function(){
                    $('.seatList').hide();
                });

                //地图替换事件
                $(".Sroon_i").on("click",function(){
                    $(".Sroom_Ul").show();
                });

                $(".Sroom_Ul li").on("click",function(){
                    var mapType = $(this).text();
                    if(mapType=='新房'){
                        window.location.href='/communitymap/new/house';
                    }else if(mapType=='二手房'){
                        window.location.href='/map/sale/house';
                    }else if(mapType=='租房'){
                        window.location.href='/map/rent/house';
                    }else if(mapType=='写字楼出租'){
                        window.location.href='/map/rent/office';
                    }else if(mapType=='商铺出租'){
                        window.location.href='/map/rent/shops';
                    }
                });

				//地铁搜索
				$(".area_box2  li").on('click',function(){
					$(".house_Nfliter").hide();
					g_map.clearOverlays();
					g_cityareaId = 0;
                    $('.search').val('');
                    keyword='';
					g_lineId = $(this).attr('lineId');
					g_stationId =$(this).attr('stationId');
					g_subwayLine = $(this).attr('lineName');
                    var lng=$(this).attr('lng');
					var lat=$(this).attr('lat');
					var point = new BMap.Point(lng,lat);
					bCenterMark = new BMap.Marker(point);
					busLineSearch.getBusList(g_subwayLine);
				});

			var busLineSearch = new BMap.BusLineSearch(g_map,{
				renderOptions:{map:g_map}
			});
			busLineSearch.setGetBusListCompleteCallback(function(result){
				busLineSearch.getBusLine(result.getBusListItem(0));
			});
			busLineSearch.setMarkersSetCallback(function(t) {
				for (var e = 0; e < t.length; e++){
					g_map.removeOverlay(t[e]);
				}
			});


			busLineSearch.setPolylinesSetCallback(function(t){
				var subway = [];
				for (var i = 0; i < t.getPath().length; i++){
					subway[i] = new BMap.Point(t.getPath()[i].lng, t.getPath()[i].lat);
				}
				var line = new BMap.Polyline(subway, {
					strokeColor: "#e84a01",
					strokeWeight: 6,
					strokeOpacity: 1
				});
				g_map.addOverlay(line);
				@foreach($subways as $key=>$subway)
				<?php $subline = explode('-',$key);?>
			    var lineName = "{{$subline['0']}}";
				if(lineName==g_subwayLine){
					@foreach($subway as $key=>$station)
						var point = new BMap.Point("{{$station->longitude}}","{{$station->latitude}}");
					    if(g_stationId=="{{$station->id}}"){
							var htm='<div class="mapSub sub1"><a href="##" class="active">{{$station->name}}</a></div>';
						}else{
							var htm='<div class="mapSub"><a href="##">{{$station->name}}</a></div>';
						}

						var label = new BMap.Label(htm,{position:point,offset:new BMap.Size(-57,-29)});
						label.setStyle({backgroundColor:"none",border:"none"});
						g_map.addOverlay(label); // 将标注添加到地图中
						{{--if(g_map.getZoom()<15){--}}
							{{--mouseStationHandler(label,"{{$station->id}}",point,"{{$station->name}}");--}}
						{{--}--}}
					@endforeach
				}
				@endforeach

			});
			//地铁线路加载完成,然后触发事件
			g_map.addEventListener('tilesloaded', function () {
				if(g_stationId>0){
					g_map.setCenter(bCenterMark.getPosition());
					g_map.addOverlay(bCenterMark);
					g_map.setZoom(g_businessareaMaxLevel);
					if(g_map.getZoom()>=g_businessareaMaxLevel){
						searchHouse();
					}
				}
			});

            //});

		</script>
		<!--==================内容区域，获取数据结束==========================================-->
	</body>
</html>
