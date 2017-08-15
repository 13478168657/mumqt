@extends('mainlayout')
@section('title')
<title>【{{CURRENT_CITYNAME}}查房价-{{CURRENT_CITYNAME}}房价走势】-搜房网</title>
<meta name="keywords" content="{{CURRENT_CITYNAME}}房价走势，{{CURRENT_CITYNAME}}查房价，{{CURRENT_CITYNAME}}房价信息"/>
<meta name="description" content="搜房网-为您提供城市、楼盘相关物业类型价格走势，还为您提供房源价格估算！"/>
<link rel="stylesheet" type="text/css" href="/css/house_loan.css?v={{Config::get('app.version')}}">
<style>
	.quyu{ position:absolute; height:300px; width:88px; height:88px; background:url(../image/mapCity.png) no-repeat;}
	.quyu a{ display:inline-block; width:88px; height:88px; line-height:88px; text-align:center; color:#fff;}
	.quyu a:hover{ color: #fff; background:url(../image/mapCityHover.png) no-repeat;}
	.quyu a .margin_t{ margin-top:26px;}
	.quyu a p{ width:88px; line-height:20px;}
</style>
@endsection
@section('content')
<script src="/js/point_interest.js?v={{Config::get('app.version')}}"></script>
<script src="/js/list.js"></script>
<p class="route line-height">
	<span>您的位置：</span>
	<a href="#">首页</a>
	<span>&nbsp;&gt;&nbsp;</span>
	<a class="colorfe" href="#">{{CURRENT_CITYNAME}}楼盘</a>
</p>
{{--查房价搜索框 开始--}}
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
{{--查房价搜索框 结束--}}
<div class="price_msg">
	<h2>{{CURRENT_CITYNAME}}房产价格趋势</h2>
	{{--图表开始--}}
	<div id="price_chart" class="price_chart" style="width:700px;height:200px"></div>
	{{--图表结束--}}
	<div class="chart_info">
		<p>{{date('n',strtotime('-1 month'))}}月均价：<span>{{$cityHouseInfo["saleAvg"]}}</span>元/平米</p>
		<p>环比上月：
			@if($cityHouseInfo["chainIncr"]>0)<span class="colorfe"><i>↑</i>{{$cityHouseInfo["chainIncr"]}}%</span>；
			@elseif($cityHouseInfo["chainIncr"]<0)<span class="color096"><i>↓</i>{{$cityHouseInfo["chainIncr"]}}%</span>；
			@else
				<span><i>-</i></span>；
			@endif
			同比去年：
			@if($cityHouseInfo["yearIncr"]>0)<span class="colorfe"><i>↑</i>{{$cityHouseInfo["yearIncr"]}}%</span>；
			@elseif($cityHouseInfo["yearIncr"]<0)<span class="color096"><i>↓</i>{{$cityHouseInfo["yearIncr"]}}%</span>；
			@else
				<span><i>-</i></span>；
			@endif
		</p>
		<p>二手房：<a>{{$cityHouseInfo["saleCount"]}}</a>套，租房：<a>{{$cityHouseInfo["rentCount"]}}</a>套</p>
	</div>
</div>
{{--地图 开始--}}
<div class="price_map" id="allmap">
	<span class="title">{{CURRENT_CITYNAME}}-二手房房价地图</span>
</div>
{{--地图 结束--}}
<div class="price_list">
	@if(isset($nodata))
		<p class="no_data"><i></i>很抱歉，没有找到与<span class="colorfe">"{{$nodata}}"</span>相符的楼盘！</p>
		<p class="gxq"><span>您可能感兴趣的楼盘</span></p>
	@endif
	{{--搜索楼盘列表循环 开始--}}
	@if($communityList)
	@foreach ($communityList as $k=>$v)
	<div class="build_info">
		<h2><a class="build_name" href="/checkprice/{{$v["id"]}}">{{$v["name"]}}</a><span class="build_address">[&nbsp;{{$v['cityAreaName']}}▪{{$v['businessAreaName']}}&nbsp;]{{$v["address"]}}</span></h2>
		<div class="build">
			<div class="build_chart" id="house_chart{{$k}}"></div>
			<div class="house_list">
				{{--楼盘内详细房源循环 开始--}}
				@foreach ($v['houseList'] as $vv)
				<dl>
					<dt>
						<span class="yx"></span>
						<a href="/housedetail/ss{{$vv["id"]}}.html"><img src="{{get_img_url("houseSale",$vv["thumbPic"])}}"></a>
						<span class="price">{{$vv["price2"]}}万</span>
					</dt>
					<dd>
						<p class="house_name"><a href="/housedetail/ss{{$vv["id"]}}.html">{{$vv["title"]}}</a></p>
						<p class="house_type">{{$vv["roomStr"]}} {{$vv["area"]}}平米</p>
					</dd>
				</dl>
				@endforeach
				{{--楼盘内详细房源循环 结束--}}
			</div>
		</div>
	</div>
	@endforeach
	{{--搜索楼盘列表循环 结束--}}
	<a class="look_more" href="/checkpricelist/sale?p={{$curPage+1}}">查看更多小区</a>
	{{--分页--}}
	<div class="list"><div class="list page_nav"></div></div>
	@endif
</div>
{{--旧的JS--}}
<script>
/** 关注 start **/
point_interest('gz','home');
/** 关注 end **/

$(document).ready(function(e) {   
	$(".nav_list li").mouseover(function(){
		$(this).find(".gz").css("display","block");  
	});

	$(".nav_list li .gz").click(function(){
		$(this).toggleClass("click");  
	});

	$(".nav_list li").mouseout(function(){
		$(this).find(".gz").css("display","none");  
	});
});
</script>
{{--新的JS--}}
<script src="../../js/jquery1.11.3.min.js"></script>
<script src="../../js/specially/headNav.js"></script>
{{--生成地图部分--}}
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{config('mapApiKey.baidu')}}"></script>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap"); // 创建Map实例
	map.centerAndZoom(new BMap.Point({{$cityInfo['long']}}, {{$cityInfo['lat']}}), 11);  // 初始化地图,设置中心点坐标和地图级别
	map.addControl(new BMap.MapTypeControl()); //添加地图类型控件
	map.setCurrentCity("{{$cityInfo['name']}}"); // 设置地图显示的城市 此项是必须设置的
	//map.enableScrollWheelZoom(true); //开启鼠标滚轮缩放
	//添加标注
	$(function () {
		$.ajax({
			url: '/ajax/areaprice' ,
			type: 'Get',
			success: function (data) {
				var json_data =data;
				var pointArray = new Array();
				for(var i=0;i<json_data.length;i++){
					pointArray[i] = new BMap.Point(json_data[i][0], json_data[i][1]);
					var htm = '<div class="quyu"><a><p class="margin_t">'+json_data[i][2]+'均价</p><p><span>'+json_data[i][3]+'</span>元</p></a></div>';
					var label = new BMap.Label(htm,{position:pointArray[i],offset: new BMap.Size(-44, -44)});
					map.addOverlay(label); // 将标注添加到地图中
				}
			}
		});
		//添加控件和比例尺
		/*var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});// 左上角，添加比例尺
		var top_left_navigation = new BMap.NavigationControl();  //左上角，添加默认缩放平移控件
		map.addControl(top_left_control);
		map.addControl(top_left_navigation);*/
	});
</script>
{{--生成图表部分--}}
<script type="text/javascript" src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script>
	/*显示房价图表*/
	$(function () {
		$.ajax({
			url: '/ajax/cityprice',
			type: 'Get',
			success: function (data) {
				$("#price_chart").highcharts({
					credits: enabled = false,
					xAxis: {
						tickInterval: 1,
						categories: data[0],
						labels: {
							formatter: function () {
								return this.value.toString().substr(4, 2) + "月";
							}
						}
					},
					title: {
						text: '',
						x: 0,
						//align:'left'
					},
					yAxis: {
						title: {
							text: null
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}],
						lineWidth: 1,
						labels: {
							formatter: function () {
								return Highcharts.numberFormat(this.value, 0, '.', ',');
							}
						}
					},
					tooltip: {
						valueSuffix: '元'
					},
					legend: {
						enabled: false,
						layout: 'horizontal',
						align: 'right',
						verticalAlign: 'top',
						borderWidth: 0
					},
					series: [{
						name: '二手房售价',
						data: data[1]
					}]
				});
			}
		});
	});
	/*显示列表楼盘房价图表*/
	$(function () {
		$.ajax({
			url: '/ajax/comprice',
			type: 'Get',
			data: 'communityIds=' + "{{$communityIds}}",
			success: function (data) {
				window.console.log(data);
				for (i = 0; i < data.length; i++) {
					$("#house_chart" + i).highcharts({
						credits: enabled = false,
						xAxis: {
							tickInterval: 1,
							categories: data[i][0],
							labels: {
								formatter: function () {
									return this.value.toString().substr(4, 2) + "月";
								}
							}
						},
						title: {
							text: '',
							x: 0,
							//align:'left'
						},
						yAxis: {
							title: {
								text: null
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}],
							lineWidth: 1,
							labels: {
								formatter: function () {
									return Highcharts.numberFormat(this.value, 0, '.', ',');
								}
							}
						},
						tooltip: {
							valueSuffix: '元'
						},
						legend: {
							enabled: false,
							layout: 'horizontal',
							align: 'right',
							verticalAlign: 'top',
							borderWidth: 0
						},
						series: [{
							name: '二手房售价',
							data: data[i][1]
						}]
					});
				}
			}
		});
	});
	//添加行政区划

</script>
@endsection