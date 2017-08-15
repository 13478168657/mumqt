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
                    <span class="index_Sroom fl" id="btn"><i class="Sroon_i" style="text-align: center;">新房</i></span>
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
				<li class="Nlist_left fl"><a href="##">均价</a><i></i><b></b></li>
				<li class="Nlist_left fl"><a href="##">类型</a><i></i><b></b></li>
				<li class="Nlist_right fl"><a href="##">更多</a><i></i></li>
			</ul>
			<section class="house_Nfliter ps" id="slide">
				<div class="Nfliter_shaw subway ps">
					<ul class="Nfliter_Lista subwayLeft">
						<li class="active">位置</li>
						<li>地铁</li>
					</ul>
                    <div class="area_box">
                        <ul class="box_area active">
                            <li>不限</li>
                            @foreach($cityAreas as $cityArea)
                            <li areaId="{{$cityArea->id}}" longitude="{{$cityArea->longitude}}" latitude="{{$cityArea->latitude}}">{{$cityArea->name}}</li>
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
                        @foreach($totalprice['alias'] as $key => $value)
                        <li value="{{$key}}">{{$value}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="ulApart">
                    <ul class=" box ul_Apart">
                        @foreach($houseType2Arr['text'] as $key => $houseType)
                            <?php if($key == 304 || $key == 305){ continue;} ?>
                            <li value="{{$key}}">{{$houseType}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="Nfliter_shaw ps">
                    <ul class="Nfliter_List">
                        <li class="active">销售状态</li>
                        <li>开盘时间</li>
                        <!--<li>房龄</li>
                        <li>特色</li>-->
                    </ul>
                    <div class="shaw_box">
                        <ul class="box_Listarea active">
                            <li class="active">不限</li>
                            @foreach($saleStatus['text'] as $key=>$value)
                            <li value="{{$key}}">{{$value}}</li>
                            @endforeach
                        </ul>
                        <ul class="box_Listarea">
                            @foreach($openTime['text'] as $key=>$value)
                            <li value="{{$key}}">{{$value}}</li>
                            @endforeach
                        </ul>
				</div>
				</div>
			</section>
				</nav>
		<!--========================地图页Nav开始=========================================-->
		<div class="space32"></div>
		<!--==================内容区域，获取数据开始==========================================-->
		<!--<div class="wrapper">
		<div class="scroll-wrap  map_content scroller "></div>
		</div>-->
		<div class="con_Map">
			<div id="container"></div>
			<!--<div class="map_Ps ps ">
				<a href="##" class="map_Ret"></a>
				<a href="##" class="map_Pos"></a>
			</div>-->
		</div>

        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

        <div class="mapList">
            <div class="newListRoom pos4">
                    <div class="mapListTit">
                        <h3>新房楼盘</h3>
                        <!--<span class="mapListPic">更多房源</span>-->
                    </div>
                    <div class="houseList">
                        <ul class="houstListUl">
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Y1kG709UBP4L0ac6SvTjxnm7"></script>
		<script type="text/javascript">
            var g_cityareaMaxLevel = 14;
            var g_businessareaMaxLevel = 15;
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
            var saleStatus = '';
            var openTime = 0;
            var psCommunityid=[];
            var tempCommunityIds = [];

            var cityLongitude ="{{$city->lng}}";   //地图中心点经度
            var cityLatitude =  "{{$city->lat}}";  //纬度
            var cCenterMark='';
            var g_subwayLine='';
            var bCenterMark='';
            var point="";

            //$(function(){
                 var windowWidth  = $("#container").width();
                 var windowHeight = $("#container").height();

            g_map = new BMap.Map("container",{enableMapClick:false});    // 创建百度Map实例
            g_map.centerAndZoom(new BMap.Point(cityLongitude, cityLatitude), 12);  // 初始化地图,设置中心点坐标和地图级

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

            //地图上次缩放级别与当前级别做对比
            g_map.addEventListener("zoomend", function () {
                if(g_stationId>0 && g_map.getZoom()<15){
                    return false;
                }

                if (g_map.getZoom() < g_cityareaMaxLevel && zoom0 >= 13) {
                    g_map.clearOverlays();
                    g_markers = new Array();
                    bound0 = null;
                    g_map.setCenter(cityCenter);
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
                       // searchMap();
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

            //地图拖动事件
            g_map.addEventListener("dragend", function () {
                if (g_map.getZoom() >= g_cityareaMaxLevel) {
                    searchHouse();
                }
            });

            var searchHouse = function () {
                //keyword="";//清除关键字
                g_map.addOverlay(cCenterMark);
                if(g_cityareaId>0){
                    $(".box_area li").each(function(){
                        if($(this).attr('areaid')==g_cityareaId){
                            $('.house_Nlist li').eq(0).find('a').text($(this).text());
                        }
                    });
                }
                var bound = g_map.getBounds();
                var psw = bound.getSouthWest();
                var pne = bound.getNorthEast();

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
                    sort: sort,
                    salestatus:saleStatus,
                    openTime:openTime
                    //communityid: 0//楼盘id
                };



                $.ajax({
                    url: "/ajax/communitymap/search",
                    data: data,
                    dataType: "json",
                    success: function(r){
                        if (r.s == "1") {
                            for (var i = 0; i < r.r.length; i++) {
                                var m = r.r[i];
                                if (m.lng == null || m.lat == null) {
                                    continue;
                                }
                                if (isPointExist(m.lng, m.lat)) {
                                    continue;
                                }
                                //var htm='<div class="mapArea"><a href="##"><i>'+m.name+'</i><em>'+ m.count+'个</em></a></div>';
                                var htm = '<div class="mapArea"><a href="##"><i>'+m.name+'</i><em>'+ m.count+'个</em></a></div>';
                                point = new BMap.Point(m.lng, m.lat);
                                var label = new BMap.Label(htm,{position:point,offset: new BMap.Size(-57, -57)});
                                label.setStyle({backgroundColor:"none",border:"none"});
                                g_map.addOverlay(label); // 将标注添加到地图中
                                addCityAreaHandler(label, m);
                            }


                        } else if (r.s == "2") {
                            for (var i = 0; i < r.r.length; i++) {
                                var m = r.r[i];

                                if(communityid == m.id){
                                    if($.inArray(communityid,psCommunityid) < 0){
                                        psCommunityid.push(communityid);
                                    }
                                    var htm='<div class="mapPro"><a href="##" class="active" id="mark'+ m.id+'"><i>'+m.name+'</i><em>'+ m.count+'个</em></a></div>';
                                }else{
                                    var htm='<div class="mapPro"><a href="##"><i>'+m.name+'</i><em>'+ m.count+'个</em></a></div>';
                                }
                                point = new BMap.Point(m.lng, m.lat);
                                var label = new BMap.Label(htm,{position:point,offset:new BMap.Size(-91,-41)});
                                label.setStyle({backgroundColor:"none",border:"none"});
                                g_map.addOverlay(label); // 将标注添加到地图中
                                g_markers.push(label);
                                addCommunityHandler(label, m);
                            }
                        } else if (r.r.hits.total>= 1) {
                            for (var i = 0; i < r.r.hits.hits.length; i++) {
                                var m = r.r.hits.hits[i]._source;
                                var avgPrice = '';
                                /*if (bound0 != null) {
                                    if (m.longitude >= bound0.getSouthWest().lng && m.longitude <= bound0.getNorthEast().lng && m.latitude >= bound0.getSouthWest().lat && m.latitude <= bound0.getNorthEast().lat) {
                                        continue;
                                    }
                                }

                                if (isPointExist(m.longitude, m.latitude)) {
                                    continue;
                                }*/
                                var avgPrice =''
                                if(m.priceSaleAvg3 == undefined){
                                    avgPrice='待定';
                                }else{
                                    //avgPrice = '<span class="fontA colorfe">'+house.priceSaleAvg3+'</span>元/平米';
                                    avgPrice =m.priceSaleAvg3+'元/平米';
                                }
                                if(communityid== m.id){
                                    //var htm='<div class="mapPro"><a href="##" class="active"><i>'+m.name+'</i><em>'+avgPrice +'</em></a></div>';
                                }else{
                                    //var htm='<div class="mapPro"><a href="##"><i>'+m.name+'</i><em>'+avgPrice +'</em></a></div>';
                                  var htm='<div class="subwayPs"><a href="##"><i>'+m.name+'</i><em>'+avgPrice+'</em></a></div>';
                                }
                                point = new BMap.Point(m.longitude, m.latitude);
                                var label = new BMap.Label(htm,{position:point,offset:new BMap.Size(-85.5,-43.5)});
                                label.setStyle({backgroundColor:"none",border:"none"});
                                g_map.addOverlay(label); // 将标注添加到地图中
                                communityUrl(label,m);
                                g_markers.push(label);
                                if(g_stationId>0){
                                    tempCommunityIds.push(label);
                                }

                            }
                        }
                        bound0 = bound;
                    }

                });
            };
            //地铁楼盘产生新的连接地址
            var communityUrl = function(marker,m){
                marker.addEventListener("click", function () {
                    var paraStr='';
                    if(m.type2.indexOf("ab") > -1){
                        var paraArr =m.type2.split("|");
                        paraStr = m.id+"/"+paraArr[0];
                    }else{
                        paraStr = m.id+"/"+m.type2;
                    }
                    window.location.href="/xinfindex/"+paraStr+".html";
                });
            }
            //第一次进入加载
            searchHouse();

            //判断是否存在经度,纬度
            var isPointExist = function (lng, lat) {
                for (var i = 0; i < g_markers.length - 1; i++) {
                    var p = g_markers[i].getPosition();
                    if (p.lng == lng && p.lat == lat) {
                        return true;
                    }
                }
                return false;
            };

            //城区监听事件
            var addCityAreaHandler = function (marker, entity) {
                marker.addEventListener("click", function () {
                    g_cityareaId = entity.id;
                    /*$(".box_area li").each(function(){ //点击城区 城区下拉框也变化
                        if($(this).attr('areaId')==g_cityareaId){
                            $('.house_Nlist li').eq(0).find('a').text($(this).text());
                        }
                    });*/
                    //searchBusinessareaByCityid(g_cityareaId);
                    g_map.setCenter(marker.getPosition());
                    g_map.setZoom(g_cityareaMaxLevel);
                });
            };
            //添加点击商圈事件
            var addCommunityHandler = function (marker, entity) {
                marker.addEventListener("click", function () {
                    $("#container").css('height','645');
                    $(".mapListTit").html("<h3>"+entity.name+"</h3>");
                    $(this).addClass('active');
                    communityid = entity.id;
                    g_map.enableAutoResize();
                    g_map.setCenter(marker.getPosition());
                    searchHouse();
                    searchCommunityByBid(entity.id,false);
                });
            };
            //商圈悬浮框效果
            var isScrool = true;
            var searchCommunityByBid = function (id,ispage) {
                if (isScrool) {
                    isScrool = false;
                    if (!ispage) {
                        communityid = id;
                        page = 1;
                        $(".houstListUl").empty();
                    } else {
                        page = page + 1;
                    }
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
                        faceTo: faceTo,
                        page:page
                    };
                    //$.getJSON("/ajax/communitymap/getcommunity", data, function (r) {
                    var bool =true;
                    if(id==0){
                        bool = false;
                    }
                    $.ajax({
                        url:"/ajax/communitymap/getcommunity",
                        data:data,
                        async: bool,
                        dataType:'json',
                        success:function(r) {
                            if (r.stuts == 1) {
                                var houseList = r.hdate.hits.hits;
                                var property = null;
                                for (var i = 0; i < houseList.length; i++) {
                                    property = houseList[i]._source;
                                    if(id==0){
                                        g_map.setCenter([houseList[0]._source.longitude,houseList[0]._source.latitude]);
                                        communityid = houseList[0]._source.id;
                                        var avgPrice =''
                                        if(property.priceSaleAvg3 == undefined){
                                            avgPrice='待定';
                                        }else{
                                            //avgPrice = '<span class="fontA colorfe">'+house.priceSaleAvg3+'</span>元/平米';
                                            avgPrice =property.priceSaleAvg3+'元/平';
                                        }
                                    }else{
                                        makecommunitydiv(property, r.tags, r.interest);
                                    }

                                }
                                //point_interest('focus', 'xcy');
                                isScrool = true;
                            }
                        }
                    });
                }
            }
                //每个楼盘悬浮框
                var makecommunitydiv = function (house,tag,interest) {
                    var typeId;
                    if(house.type2.indexOf('1') > -1){
                        var typeArr = house.type2.split('|');
                        typeId = typeArr[0];
                    }else{
                        typeId = house.type2;
                    }

                    if(typeId==301){
                        var infoJson = house.type301Info;
                        var newType='普宅';
                    }else if(typeId==302){
                        var infoJson = house.type302Info;
                        var newType='经济适用房';
                    }else if(typeId==303){
                        var infoJson = house.type303Info;
                        var newType='商住楼';
                    }else if(typeId==304){
                        var infoJson = house.type304Info;
                        var newType='别墅';
                    }else if(typeId==305){
                        var infoJson = house.type305Info;
                        var newType='豪宅';
                    }else if(typeId==306){
                        var infoJson = house.type306Info;
                        var newType='平房';
                    }else if(typeId==307){
                        var infoJson = house.type307Info;
                        var newType='四合院';
                    }else{
                        var newType='不限';
                    }

                    var convenient = [];
                    if(infoJson) {
                        var infoArr = eval("(" + infoJson + ")");
                        //var infoArr = jQuery.parseJSON(infoJson);
                        var tagsStr = infoArr.tagIds;
                        var tagArr = tagsStr.split('|');

                        for (var p in tag) {
                           for(var p1 in tagArr){
                               if(tagArr[p1]== p) {
                                   convenient.push(tag[p]);
                               }
                            }
                        }
                    }

                    var avgPrice = "";
                    if(house.priceSaleAvg3 == undefined){
                        avgPrice ='<span class="list_Pic">待定</span>';
                    }else{
                        //avgPrice = '<span class="fontA colorfe">'+house.priceSaleAvg3+'</span>元/平米';
                        avgPrice ='<span class="list_Pic">'+house.priceSaleAvg3+'元<i>/平米</i></span>';
                    }

                    var saleStatus = '';
                    if(house.salesStatusPeriods==0){
                        saleStatus = '待售';
                    }else if(house.salesStatusPeriods==1){
                        saleStatus = '在售';
                    }else if(house.salesStatusPeriods==2){
                        saleStatus = '售完';
                    }
                    //折扣和优惠
                    var discountType;
                    var zhehui='';
                    var youhui='';
                    if(house.discountType){
                        discountType = house.discountType;
                    }else{
                        discountType = 0;
                    }
                    if((discountType ==1)&& (house.discount)){
                        zhehui = house.discount+"折";
                    }else if((discountType==2) && house.subtract){
                        zhehui = '减去'+Math.floor(house.subtract);
                    }else if((discountType==3) && (house.subtract) && (house.discount)){
                        zhehui = house.discount+'折减'+floor(house.substract);
                    }
                    if((house.specialOffers) && house.specialOffers.length>2 && house.specialOffers !='0_0'){
                        var youhuistr = house.specialOffers;
                        var youhuiArr = youhuistr.split('_');
                        if(youhuiArr[0]>10000) {
                            for (var p in youhuiArr) {
                                youhuiArr[p] = youhuiArr[p] / 10000 + "万";
                            }
                        }
                        youhui = youhuiArr.join('抵');
                    }
                    var discountMean ='';
                    if(zhehui && youhui){
                        discountMean =zhehui+"&nbsp;&nbsp;"+youhui
                    }else if(zhehui){
                        discountMean = zhehui;
                    }else if(youhui){
                        discountMean = youhui;
                    }
                    var htype =house.type2;
                    var htypeArr = htype.split('|');
                    var html = "";
                    html = html +'<li><a href="/xinfindex/'+house.id+'/'+htypeArr[0]+'.html">';
                    html = html +'<div class="room"><img src="'+house.titleImage+'"/></div>';
                    html = html +'<div class="index_Hmain fl"><h3>'+house.name+'</h3>';
                    html = html +'<div class="houseLable fl"><span>'+saleStatus+'<i>|</i></span><span>'+newType+'</span><span class="discount">'+youhui+'</span></div>';
                    html = html +'<div class="houseLable fl">' ;
                    for(var p in convenient){
                        html +='<span class="tag1 fl">'+convenient[p]+'</span>';
                    }
                    html = html +'</div></div>';
                    html = html +avgPrice+'</a></li>';

                    $(".houstListUl").append(html);
                    $(".newListRoom").show();
                    $(".mapList").show();
                }


                //滚动条加载数据
                $(".houseList").bind("scroll", function () {
                    //if (($(".houseList").scrollTop() + $(".houseList").height() >= $(".houseList").height()+212) && (!$('.houseList').is(':hidden'))) {
                    var height = $(this).height();   //可见高度
                    var contentH =$(this).get(0).scrollHeight;  //内容可见高度
                    var scrollTop =$(this).scrollTop();     //滚动条高度
                    if((scrollTop == (contentH -height)) && (!$('.houseList').is(':hidden'))){
                        searchCommunityByBid(communityid, true);
                    }
                });
                //创建行政区服务
                /*AMap.service(['AMap.DistrictSearch'], function () {
                    var opts = {
                        subdistrict: 1,   //返回下一级行政区
                        extensions: 'all',  //返回行政区边界坐标组等具体信息
                        level: 'district'  //查询行政级别为 市
                    };
                    g_cityareaDistrict = new AMap.DistrictSearch(opts);
                });*/
               //城区搜索
                $(".box_area li").on('click',function(){
                    g_map.clearOverlays();
                    g_cityareaId = $(this).attr('areaId');
                    var textStr = $(this).text();
                    if(textStr=='不限'){
                        $('.house_Nlist li').eq(0).find('a').text('位置');
                    }
                    $(".mapList").hide();
                    $(".house_Nfliter").hide();
                    $('.search').val('');
                    keyword = '';
                    $("#container").css('height','1156');

                    if(g_map.getZoom()>=14){
                        var longitude = "{{$city->lng}}";
                        var latitude="{{$city->lat}}";
                        point = new BMap.Point(longitude, latitude);
                        g_map.setCenter(point);
                        g_map.setZoom(12);
                    }else{
                        var longitude  = $(this).attr('longitude');
                        var latitude   = $(this).attr('latitude');
                        var point = new BMap.Point(longitude, latitude);
                        g_map.setCenter(point);
                        searchHouse();
                    }

                });
                //价格搜索
                $(".ul_Price li").on('click',function(){
                    if(g_stationId<1){
                        g_map.clearOverlays();
                    }else{
                        for(var p in tempCommunityIds){
                            g_map.removeOverlay(tempCommunityIds[p]);
                        }
                        tempCommunityIds =[];
                    }
                    $(".house_Nfliter").hide();
                    totalprice = $(this).attr('value');
                    keyword = '';
                    $(".search").val('');
                    $(".house_Nfliter").hide();
                    var textStr = $(this).text();
                    if(textStr=='不限'){
                        $('.house_Nlist li').eq(1).find('a').text('均价');
                    }
                    $(".mapList").hide();
                    $("#container").css('height','1156');
                    searchHouse();

                });
                //房屋类型搜索
                $(".ul_Apart li").on('click',function(){
                    if(g_stationId<1){
                        g_map.clearOverlays();
                    }else{
                        for(var p in tempCommunityIds){
                            g_map.removeOverlay(tempCommunityIds[p]);
                        }
                        tempCommunityIds =[];
                    }
                    housetype2 = $(this).attr('value');
                    keyword = '';
                    $(".search").val('');
                    $(".house_Nfliter").hide();
                    var textStr = $(this).text();
                    if(textStr=='不限'){
                        $('.house_Nlist li').eq(2).find('a').text('类型');
                    }
                    $(".mapList").hide();
                    $("#container").css('height','1156');
                    searchHouse();
                });
                //销售状态 开盘时间
                $(".shaw_box li").on('click',function(){
                       $(".mapList").hide();
                       $(".house_Nfliter").hide();
                       if($(".Nfliter_List .active").text()=='销售状态'){
                           $(".mapList").hide();
                           $("#container").css('height','1156');
                            if($(this).attr('value') >=0){
                                saleStatus = $(this).attr('value');
                                if( openTime>0){
                                    $('.house_Nlist li').eq(3).find('a').text('更多(2)');
                                }else{
                                    $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                                }
                                if(g_stationId<1){
                                    g_map.clearOverlays();
                                }else{
                                    for(var p in tempCommunityIds){
                                        g_map.removeOverlay(tempCommunityIds[p]);
                                    }
                                    tempCommunityIds =[];
                                }
                                //keyword = $('.search').val();
                                keyword = '';
                                $(".search").val('');

                                searchHouse();
                            }else{
                                if(openTime>0){
                                    $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                                }else{
                                    $('.house_Nlist li').eq(3).find('a').text('更多');
                                }
                                saleStatus ='';
                                searchHouse();
                            }
                        }else if($(".Nfliter_List .active").text()=='开盘时间'){
                           $(".mapList").hide();
                           $("#container").css('height','1156');
                            if($(this).attr('value') >0){
                                openTime = $(this).attr('value');
                                if(saleStatus>=0){
                                    $('.house_Nlist li').eq(3).find('a').text('更多(2)');
                                }else{
                                    $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                                }
                                if(g_stationId<1){
                                    g_map.clearOverlays();
                                }else{
                                    for(var p in tempCommunityIds){
                                        g_map.removeOverlay(tempCommunityIds[p]);
                                    }
                                    tempCommunityIds =[];
                                }
                                //keyword = $('.search').val();
                                keyword = '';
                                $(".search").val('');
                                searchHouse();

                            }else{
                                openTime='';
                                if(saleStatus>=0){
                                    $('.house_Nlist li').eq(3).find('a').text('更多(1)');
                                }else{
                                    $('.house_Nlist li').eq(3).find('a').text('更多');
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
                    if(housetype2>0){
                        paraArr.push('an'+housetype2);
                    }
                    if(saleStatus!=''){
                        paraArr.push('ax'+saleStatus);
                    }
                    if(openTime >0){
                        paraArr.push('ay'+openTime);
                    }

                    //是否到达商圈
                    if(communityid >0){
                        paraArr.push('ab'+communityid);
                    }

                    var keywords = $('.search').val();
                    if(paraArr){
                        var  paraStr  = paraArr.join('-');
                        if((keywords!='搜索楼盘/开发商/地址') && (keywords != '')){
                            window.location.href = "/new/area/"+paraStr+"?kw="+keywords;
                        }else{
                            window.location.href = "/new/area/"+paraStr;
                        }
                    }else{
                        window.location.href="/new/area";
                    }

                });
                /** 关键字搜索 **/
                var searchKeyWords = {keyword:'', tp:'', tp1:'', sr:'', obj:null};
                $('.search').on('keyup click', function(ev){
                    var obj  = $(this);
                    var tptext =$('.Sroon_i').text();
                    var tp='';
                    if(tptext=='新房'){
                        tp ='new';
                    }else if(tptext =='二手房'){
                        tp == 'sale';
                    }else if(tptext =='租房'){
                        tp == 'rent';
                    }else if(tptext =='写字楼出租'){
                        tp == 'xzl';
                    }else if(tptext =='商铺出租'){
                        tp == 'sp';
                    }
                    //var tp = $(obj).attr('tp');
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
                            $('.selectSearch').on('tap',function(){
                                keyword = $(this).text();
                                $('.search').val(keyword);
                                $(".seatList").hide();
                                //searchCommunityByBid(0,false);
                                g_cityareaId = 0;
                                totalprice="";
                                housetype2="";
                                saleStatus="";
                                openTime=0;
                                g_stationId=0;
                                $('.house_Nlist li').eq(0).find('a').text('位置');
                                $('.house_Nlist li').eq(1).find('a').text('均价');
                                $('.house_Nlist li').eq(2).find('a').text('类型');
                                $('.house_Nlist li').eq(3).find('a').text('更多');

                                if(!$(".mapList").is(":hidden")){
                                    $(".mapList").hide();
                                    $("#container").css('height','1156');
                                }
                                g_map.clearOverlays();
                                g_map.setZoom(g_businessareaMaxLevel);
                                var data ={type:type,keyword:keyword};
                                $.getJSON("/ajax/communitymap/community", data, function (r) {
                                    if (r.status == 1) {
                                        var  houseList = r.community.hits.hits;

                                        $("#quname").empty();
                                        $("#qucount").text('搜到' + houseList.length + '个楼盘');


                                        for (var i = 0; i < houseList.length; i++) {
                                            var m = houseList[i]._source;
                                            //makecommunitydiv(m, r.tags, r.interest);
                                            if(m.priceSaleAvg3 == undefined){
                                                avgPrice = '待定';
                                            }else{
                                                avgPrice = (m.priceSaleAvg3/10000).toFixed(2)+'万';
                                            }

                                           // var htm = '<div class="map_msg" id="' + m.id + '"><a class="num_house">' +avgPrice+ '</a><a class="num_name" style="display:none;">' + m.name + '</a></div>';
                                            var htm='<div class="subwayPs"><a href="##"><i>'+m.name+'</i><em>'+avgPrice+'</em></a></div>';
                                            var point = new BMap.Point(m.longitude, m.latitude);
                                            g_map.setCenter(point);
                                            var label = new BMap.Label(htm,{position:point,offset:new BMap.Size(-85.5,-43.5)});
                                            label.setStyle({backgroundColor:"none",border:"none"});
                                            g_map.addOverlay(label); // 将标注添加到地图中
                                            communityUrl(label,m);
                                        }
                                    }else{
                                        $('.subway_list').append('<div class="no_datas">暂无数据</div>');
                                    }
                                });
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


            g_map.addEventListener("click", function () { //地图点击事件
                $(".Sroom_Ul").hide();
                $(".seatList").hide();
                if(!$(".mapList").is(":hidden")){
                    $(".mapList").hide();
                    $("#container").css('height','1156');
                }
            });


            //地铁搜索
            $(".area_box2  li").on('click',function(){
                if(!$(".mapList").is(":hidden")){
                    $(".mapList").hide();
                    $("#container").css('height','1156');
                }
                $(".house_Nfliter").hide();
                g_map.clearOverlays();
                g_cityareaId = 0;
                keyword="";
                $(".search").val('');
                g_lineId = $(this).attr('lineId');
                g_stationId =$(this).attr('stationId');
                g_subwayLine = $(this).attr('lineName');
                var lng=$(this).attr('lng');
                var lat=$(this).attr('lat');
                var point = new BMap.Point(lng,lat);
                g_map.setCenter(point);
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
