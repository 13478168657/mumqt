<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>
    <style>
        a.cityarea:link { padding-top: 20px; top: -30px; left: -30px; position: absolute; background: url(/image/map.png) no-repeat; width:77px; height:77px; border: 0; text-align: center; display: block; color: white; text-decoration: none;}
        a.cityarea:visited { padding-top: 20px; position: absolute; background: url(/image/map.png) no-repeat; width:77px; height:77px; border: 0; text-align: center; display: block; color: white; text-decoration: none;}
        a.cityarea:hover { padding-top: 20px; position: absolute; background: url(/image/mapOn.png) no-repeat; width:77px; height:77px; border: 0; text-align: center; display: block; color: white; text-decoration: none;}
        .cityarea label { font-size: 14px; display: block;}
        .cityarea span { font-size: 12px; display: block;}
        a.community:link { width:40px; background-color: #fff; position: absolute; position: absolute; display: block; color: #000; text-align: center; text-decoration: none; border: orange solid 2px;}
        a.community:visited { width:40px; background-color: #fff; position: absolute; position: absolute; display: block; color: #000; text-align: center; text-decoration: none; border: orange solid 2px;}
        a.community:hover { width:40px; background-color: #fff; position: absolute; position: absolute; display: block; color: #000; text-align: center; text-decoration: none; border: red solid 2px;}
        .community label { font-size: 14px; }
        .community span { font-size: 12px; }
        .subway { cursor: pointer; display: inline;}
    </style>
</head>
<body>
<div>
    <ul>
        <li id="sw_" class="subway">不限</li>
        <?php foreach($subways as $s){ ?>
        <li id="sw_<?php echo $s->id?>" class="subway" value="<?php echo $s->centerLng.','.$s->centerLat.','.$s->centerLevel?>"><?php echo $s->name?></li>
        <?php }?>
    </ul>
    <span id="result"></span>
</div>
<div id="map"></div>
<script type="text/javascript">
    $(function(){
//      $("#map").width(document.body.clientWidth - 0);
//      $("#map").height(window.screen.height - 150);
        var g_map = new AMap.Map('map',{
            zoom: 12,
            zooms: [11,17],
            center: [116.39,39.9],
            animateEnable: false,
            jogEnable: false
        });
        var g_cityareaMaxLevel = 13;
        var g_businessareaMaxLevel = 15;
        var g_linesearch = null;
        var g_querySubwayLine = null;
        var g_subwayLine = null;
        var g_subwayLineId = 0;
        var g_subwayStations = new Array();
        var g_cityareaId = 0;
        var g_cityareaDistrict = null;
        var g_cityareaLines = new Array();
        var g_businessDistrict = null;
        var g_markers = new Array();
        var bound0 = null;
        var zoom0 = 0;

        $(".subway").bind("click",function(){
            if ($(this).attr("id") == "sw_"){
                g_querySubwayLine = null;
                clearSubwayLine();
            } else {
                g_subwayLineId = $(this).attr("id");
                g_querySubwayLine = $(this).text();
                subwaySearch();
            }
        });
        AMap.plugin(['AMap.ToolBar','AMap.Scale'],function(){
            g_map.addControl(new AMap.ToolBar());
            g_map.addControl(new AMap.Scale());
        });
        AMap.event.addListener(g_map,"zoomend",function(){
            if (g_map.getZoom() < g_cityareaMaxLevel && zoom0 >= g_cityareaMaxLevel){
                g_map.clearMap();
                g_markers = new Array();
                bound0 = null;
                searchMap();
            } else if (g_map.getZoom() >= g_cityareaMaxLevel && g_map.getZoom() < g_businessareaMaxLevel){
                if (zoom0 < g_cityareaMaxLevel || zoom0 >= g_businessareaMaxLevel){
                    g_map.clearMap();
                    g_markers = new Array();
                    bound0 = null;
                    searchMap();
                } else if (g_map.getZoom() < zoom0){
                    if (g_subwayLine != ""){
                        bound0 = null;
                    }
                    searchMap();
                }
            } else if (g_map.getZoom() >= g_businessareaMaxLevel){
                if (zoom0 < g_businessareaMaxLevel){
                    g_map.clearMap();
                    g_markers = new Array();
                    bound0 = null;
                }
                if (g_map.getZoom() < zoom0 || zoom0 < g_businessareaMaxLevel){
                    searchMap();
                }
            }
            zoom0 = g_map.getZoom();
        });
        AMap.event.addListener(g_map,"zoomstart",function(){
//                    zoom0 = g_map.getZoom();
        });
        AMap.event.addListener(g_map,"dragend",function(){
            if (g_map.getZoom() >= g_cityareaMaxLevel){
                searchHouse();
            }
        });
        AMap.service(["AMap.LineSearch"], function() {
            g_linesearch = new AMap.LineSearch({
                pageIndex: 1,
                city: '北京',
                pageSize: 1,
                extensions: 'all'
            });
        });
        AMap.service(['AMap.DistrictSearch'], function() {
            var opts = {
                subdistrict: 1,   //返回下一级行政区
                extensions: 'all',  //返回行政区边界坐标组等具体信息
                level: 'district'  //查询行政级别为 市
            };
            g_cityareaDistrict = new AMap.DistrictSearch(opts);
        });
        AMap.service(['AMap.DistrictSearch'], function() {
            var opts = {
                subdistrict: 1,
                extensions: 'all',
                level: 'biz_area'
            };
            g_businessDistrict = new AMap.DistrictSearch(opts);
        });

        var subwaySearch = function(){
            clearSubwayLine();
            g_linesearch.search(g_querySubwayLine, function(status, result) {
                if (status === 'complete' && result.info === 'OK') {
                    lineSearch_Callback(result);
                } else {
                    alert(result);
                }
            });
        };
        var searchMap = function(){
            if (g_querySubwayLine != null){
                subwaySearch();
            }
            searchHouse();
        };
        var searchHouse = function(){
            var bound = g_map.getBounds();
            var psw = bound.getSouthWest();
            var pne = bound.getNorthEast();
            var data = {
                keyword: "", //搜索框关键词
                housetype: 128, //物业类型（普通住宅、公寓、写字楼。。。）
                type: "sale", //销售类型（出租、出售）
                ca: g_cityareaId, //城区id
                zm: g_map.getZoom(), //获取当前放大级别
                swlng: psw.getLng(), //西南经度
                swlat: psw.getLat(), //西南纬度
                nelng: pne.getLng(), //东北（右上）
                nelat: pne.getLat(),
                pg: 1,
                communityid: 0//楼盘id
            };
            $.getJSON("/map/search",data,function(r){
                if (r.s == "1"){
                    for (var i = 0; i < r.r.length; i++) {
                        var m = r.r[i];
                        var htm = '<a class="cityarea" href="#"><label>'+m.name+'</label><span>'+m.count+'</span></a>';
                        var marker = new AMap.Marker({
                            content: htm,
                            title:'data.name',
                            position: [m.lng, m.lat],
                            offset: new AMap.Pixel(0, 0),
                            zIndex: 10,
                            map:g_map
                        });
                        addCityAreaHandler(marker, m);
                    }
                } else if (r.s == "2"){

                    for (var i = 0; i < r.r.length; i++) {
                        var m = r.r[i];
                        if (bound0 != null){
                            if (m.lng >= bound0.getSouthWest().lng && m.lng <= bound0.getNorthEast().lng && m.lat >= bound0.getSouthWest().lat && m.lat <= bound0.getNorthEast().lat){
                                continue;
                            }
                        }
                        if (isPointExist(m.lng, m.lat)){
                            continue;
                        }
                        var htm = '<a class="cityarea" href="#"><label>'+m.name+'</label><span>'+m.count+'</span></a>';
                        var marker = new AMap.Marker({
                            content: htm,
                            title:'data.name',
                            position: [m.lng, m.lat],
                            offset: new AMap.Pixel(0, 0),
                            zIndex: 10,
                            map:g_map
                        });
                        g_markers.push(marker);
                        addBusinessAreaHandler(marker, m);
                    }
                } else if (r.s == "3") {
                    for (var i = 0; i < r.r.length; i++) {
                        var m = r.r[i];
                        var htm = '<a class="community" href="#" title="'+m.name+'"><span>'+m.count+'</span></a>';
                        var marker = new AMap.Marker({
                            content: htm,
                            title:'data.name',
                            position: [m.lng, m.lat],
                            offset: new AMap.Pixel(0, 0),
                            zIndex: 10,
                            map:g_map
                        });
                        g_markers.push(marker);
                    }
                }
                bound0 = bound;
            });
        };
        var addCityAreaHandler = function(marker, entity){

            AMap.event.addListener(marker,"click",function(){
                g_cityareaId = entity.id;
                g_map.setCenter(marker.getPosition());
                g_map.setZoom(g_cityareaMaxLevel);
            });
            AMap.event.addListener(marker,"mouseover",function(){
                if (g_cityareaLines.length > 0){
                    for(var i = 0; i < g_cityareaLines.length; i++){
                        g_cityareaLines[i].setMap(null);
                    }
                }
                g_cityareaDistrict.search(entity.name, function(status, result) {
//                            $("#result").html(JSON.stringify(result));
                    var bounds = result.districtList[0].boundaries;
                    if (bounds) {
                        for (var i = 0, l = bounds.length; i < l; i++) {
                            var cityareaLine = new AMap.Polygon({
                                map: g_map,
                                strokeWeight: 1,
                                path: bounds[i],
                                fillOpacity: 0.7,
                                fillColor: '#CCF3FF',
                                strokeColor: '#CC66CC'
                            });
                            g_cityareaLines.push(cityareaLine);
                        }
                    }
                });
            });
            AMap.event.addListener(marker,"mouseout",function(){
                if (g_cityareaLines.length > 0){
                    for(var i = 0; i < g_cityareaLines.length; i++){
                        g_cityareaLines[i].setMap(null);
                    }
                }
            });
        }
        var addBusinessAreaHandler = function(marker, entity){
            AMap.event.addListener(marker,"click", function(){
                g_cityareaId = entity.id;
                g_map.setCenter(marker.getPosition());
                g_map.setZoom(g_businessareaMaxLevel);
            });
            AMap.event.addListener(marker,"mouseover",function(){
                g_businessDistrict.search("国贸", function(status, result) {
                    var bounds = result.districtList[0].boundaries;
                    if (bounds) {
                        for (var i = 0, l = bounds.length; i < l; i++) {
                            var cityareaLine = new AMap.Polygon({
                                map: g_map,
                                strokeWeight: 1,
                                path: bounds[i],
                                fillOpacity: 0.7,
                                fillColor: '#CCF3FF',
                                strokeColor: '#CC66CC'
                            });
//                                    g_cityareaLines.push(cityareaLine);
                        }
                    }
                });
            });
        };
        var isPointExist = function(lng,lat){
            for (var i = 0; i < g_markers.length - 1; i++){
                var p = g_markers[i].getPosition();
                if (p.getLng() == lng && p.getLat() == lat){
                    return true;
                }
            }
            return false;
        };
        var lineSearch_Callback = function(data) {
            var lineArr = data.lineInfo;
            var lineNum = data.lineInfo.length;
            if (lineNum == 0) {
                alert(data.info);
            }
            else {
                for (var i = 0; i < lineNum; i++) {
                    var pathArr = lineArr[i].path;
                    var stops = lineArr[i].via_stops;
                    if (i == 0) drawbusLine(pathArr);
                    for (var j = 0; j < stops.length; j++){
                        var s = stops[j];
                        var htm = '<a class="community" href="#"><span>'+s.name+'</span></a>';
                        var marker = new AMap.Marker({
                            content: htm,
                            title:'data.name',
                            position: s.location,
                            offset: new AMap.Pixel(0, 0),
                            zIndex: 10,
                            map:g_map
                        });
                        g_subwayStations.push(marker);
                    }
                }
                var x = $("#" + g_subwayLineId).attr("value");
                var a = x.split(",");
                g_map.setCenter([parseFloat(a[0]),parseFloat(a[1])]);
            }
        };
        var drawbusLine = function(BusArr) {
            g_subwayLine = new AMap.Polyline({
                map: g_map,
                path: BusArr,
                strokeColor: "#09f",//线颜色
                strokeOpacity: 0.8,//线透明度
                strokeWeight: 6//线宽
            });
        };
        var clearSubwayLine = function(){
            if (g_subwayLine != null){
                g_subwayLine.setMap(null);
                for (var i = 0; i < g_subwayStations.length; i++){
                    g_subwayStations[i].setMap(null);
                }
                g_subwayStations = [];
            }
        }
        searchMap();

        AMap.service(['AMap.PlaceSearch'],function(){
            var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                pageSize:50,
                pageIndex:1,
                city:"北京",
                map: g_map,
                panel: "result"
            });
            var bounds = null;
            g_cityareaDistrict.search("朝阳", function(status0, result0) {
                bounds = result0.districtList[0].boundaries;
//                        $("#result").html(JSON.stringify(result));
                placeSearch.searchInBounds("住宅小区",bounds,function(status,result){
                    if (status == "complete"){
                        $("#result").html(JSON.stringify(result));
//                                var pois = result.poiList[0].pois;
//                                if (pois){
//                                    for (var i = 0; i < pois.length; i++){
//
//                                    }
//                                }
                    } else {
                        //alert(0);
                    }
                });
            });
        });
    });
</script>
</body>
</html>
