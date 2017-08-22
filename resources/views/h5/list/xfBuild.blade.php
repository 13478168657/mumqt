<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta http-equiv="Pragma"content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="expires"content="0">
	<title></title>
	<link rel="stylesheet" type="text/css" href="/{{$h5}}/css/newHouse.css" />
	<link rel="stylesheet" type="text/css" href="/{{$h5}}/css/common/common.css" />
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

<body >
<!--========================新房header开始============================================-->
<header class="house_header">
	<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
	<input type="hidden" id="linkurl"  value="{{$linkurl}}" >
	<input type="hidden" id="par"  value="{{$purl}}" >
	<div class="house_Hbg fl"><a href="javascript:window.history.go(-1)"></a></div>
	<h3 class="newHouse fl "><em>新盘&nbsp;</em><i>&nbsp;{{$cityName}}</i></h3>
	<!--<a class="house_Hmag fl" href="##"></a>-->
	<a class="house_Hmap fr" href="/communitymap/new/house"></a>
</header>
<!--========================新房header结束============================================-->
<div class="space24"></div>
<!--========================豪宅别墅Search开始============================================-->
<div class="list_search">
	<i class="search_btn ps" id="search_btn"></i>
	<input type="text" name="text" id="keyword" placeholder="搜索楼盘名/地名" tp="{{$type}}" class="search" value="{{!empty($keyword)?$keyword:''}}"/>
</div>
<ul class="seatList">
</ul>
<!--========================豪宅别墅Search开始============================================-->
<!--========================新房Nav开始===============================================-->
<nav class="house_Nnav">
	<ul class="house_Nlist" id="pagenavi">
		<li class="Nlist_left fl"><span>
				<?php
				if(!empty($xbus = App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($busid))){
					echo $xbus;
				}elseif($xcityarea = App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($cityareaid)){
					echo $xcityarea;
				}else{
					echo '区域';
				}
					?>
			</span><i></i><b></b></li>
		<li class="Nlist_left fl"><span>@if(!empty($averageprice)){{$averageprices[$averageprice]}}@else价格@endif</span><i></i><b></b></li>
		<li class="Nlist_left fl"><span>@if(!empty($housetype2)){{$housetypes[$housetype2]}}@else类型@endif</span><i></i><b></b></li>
		<?php
		//更多的选择条件个数
		$xnum = 0;
		if($salesStatusPeriods !=''){
			$xnum += 1;
		}
		if(!empty($openTimePeriods)){
			$xnum += 1;
		}
		?>
		<li class="Nlist_right fl"><span>更多@if(!empty($xnum))({{$xnum}})@endif</span><i></i></li>
	</ul>
	<section class="house_Nfliter ps" id="slide">
		<div class="Nfliter_shaw subway ps">
			<ul class="Nfliter_Lista subwayLeft">
				<?php
				$xmo = '';
				if(empty($cityareaid)&&empty($busid)){
					$xmo = 'active';
				}
				?>
				<li class="{{(!empty($cityareaid)||!empty($busid))?'active':$xmo}}">区域</li>
			</ul>
			<div class="area_box">
				<ul class="box_area {{!empty($cityareaid)?'active':$xmo}}">
					@if(!empty($cityArea))
						@if(empty($cityareaid))
							<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'aa')}}">不限</a></li>
						@else
							<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'aa')}}">不限</a></li>
						@endif
						@foreach($cityArea as $v)
							@if($cityareaid == $v->id)
								<li class="active">{{$v->name}}</li>
							@else
								<li>{{$v->name}}</li>
							@endif
						@endforeach
					@endif
				</ul>
			</div>
			<div class="area_box1 ">
				<ul class="box_area1 active">
				</ul>
				@if(!empty($businessAreaH5))
					@foreach($businessAreaH5 as $bv)
						<ul class="box_area1 active">
							@if(!empty($bv))
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'aa',$bv[0]->cityAreaId)}}">不限</a></li>
								@foreach($bv as $sv)
									@if($busid == $sv->id)
										<li><a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'aa',$sv->cityAreaId),'ab',$sv->id)}}"  class="active">{{$sv->name}}</a></li>
									@else
										<li><a href="{{$linkurl}}/{{get_url_by_id(get_url_by_id($purl,'aa',$sv->cityAreaId),'ab',$sv->id)}}">{{$sv->name}}</a></li>
									@endif
								@endforeach
							@endif
						</ul>
					@endforeach
				@endif
			</div>
		</div>
		<div class="ulPrice">
			<ul class="box ul_Price ">
				@if(count($averageprices)>0)
					@foreach($averageprices as $k=>$v)
						@if($averageprice == $k)
							@if(!empty($averageprice))
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="color_blue acon" con="ao">{{$v}}</a></li>
							@else
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="color_blue" attr="{{$k}}">{{$v}}</a></li>
							@endif
						@else
							<li><a  href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}">{{$v}}</a></li>
						@endif
					@endforeach
				@endif
			</ul>
		</div>
		<div class="ulApart">
			<ul class=" box ul_Apart">
				@if(count($housetypes)>0)
					@foreach($housetypes as $k=>$v)
						@if($housetype2 == $k)
							@if(!empty($housetype2))
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="color_blue acon" con="an">{{$v}}</a></li>
							@else
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="color_blue" >{{$v}}</a></li>
							@endif
						@else
							<li><a  href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a></li>
						@endif
					@endforeach
				@endif
			</ul>
		</div>

		<div class="Nfliter_shaw ps">
			<ul class="Nfliter_List">
				<?php
				//子菜单是否显示标记
				$active = '';
				if(!empty($salesStatusPeriods)){
					$active = 'sa';
				}elseif(!empty($openTimePeriods)){
					$active = 'op';
				}
				?>
				<li class="{{($active=='sa' || $active=='')?'active':''}}">销售状态</li>
				<li class="{{($active=='op')?'active':''}}">开盘时间</li>
			</ul>
			<div class="shaw_box">
				<ul class="box_Listarea {{($active=='sa' || $active=='')?'active':''}}">
					@if(!empty($salestatus))
						<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax')}}">不限</a></li>
						@foreach($salestatus as $k=>$v)
							@if($salesStatusPeriods == $k)
								@if($salesStatusPeriods !='')
									<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax',$k)}}"class="active">{{$v}}</a></li>
								@else
									<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax',$k)}}">{{$v}}</a></li>
								@endif
							@else
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ax',$k)}}">{{$v}}</a></li>
							@endif
						@endforeach
					@endif
				</ul>
				<ul class="box_Listarea {{($active=='op')?'active':''}}">
					@if(!empty($opentimes))
						@foreach($opentimes as $k=>$v)
							@if($openTimePeriods == $k)
								@if(!empty($openTimePeriods))
									<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',$k)}}" class="active">{{$v}}</a></li>
								@else
									<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',$k)}}">{{$v}}</a></li>
								@endif
							@else
								<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ay',$k)}}">{{$v}}</a></li>
							@endif
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</section>
</nav>
<!--========================新房Nav开始===============================================-->
<div class="space48"></div>
<!--==================内容区域，获取数据开始==========================================-->
<div class="wrapper" id="indexContent">
	<div class="scroll-wrap house_contet scroller">
		<ul class="house_Clist" id="newList">

		</ul>
	</div>
</div>
<!--==================内容区域，获取数据结束==========================================-->

</body>
<script src="/{{$h5}}/js/common/jquery1.11.3.min.js"></script>
<script src="/{{$h5}}/js/common/zepto.js"></script>
<script src="/{{$h5}}/js/list.js" type="text/javascript" charset="utf-8"></script>
<script src="/{{$h5}}/js/common/iscroll.js" type="text/javascript"></script>
<script src="/{{$h5}}/js/common/iscroll-probe.js"  type="text/javascript"></script>

<script type="text/javascript" src="/{{$h5}}/js/demo.js"></script>
<script>
	var proSort = {
		canLoad:false,//是否允许加载下一页数据
		pageNum:0,//当前请求第几页数据
		limit:20,//每页数据长度
		type:1,//选项卡状态
		//初始化
		init:function(){
			proSort.$list = $('#newList');
			proSort.addData();
		},
		//添加数据
		addData:function(clear){
			var linkurl = $('#linkurl').val();
			var url = $('#par').val();
			if(url !=''){
				linkurl = linkurl +'/'+url;
			}
			var str = window.location.search;
			if(str == ''){
				str = '?f=h5';
			}else{
				str += '&f=h5';
			}
			$.get(linkurl+str,{'page':++proSort.pageNum},function(data){
				//return false;
				var oData = data;
				if(oData.length>=1){//判断是否有数据
					$("#house_Footer").remove();
					if(oData.length==proSort.limit){//后台返回数据条目如果与要求数据条目相等，就允许加载下页条数据；
						proSort.canLoad = true;
					}else{
						proSort.canLoad = false;
					}
					if(clear){//如果需要请空数据，就清空
						proSort.$list.html("")
					}
					//拼接填充字符串 //<span class='img_tit'>"+oData[i]._source.salesStatusPeriods+"</span>
					for(var i=0;i<oData.length;i++){
						var ulli = "<li class='house_Cli'><a href='/xinfindex/"+oData[i]._source.id+"/"+oData[i]._source.xtype2+".html'><img src='"+oData[i]._source.titleImage+"' />"+
								"<div class='house_Cmain fl'><h3>"+oData[i]._source.name+"</h3>"+
								"<h6>"+oData[i]._source.address+"</h6><div class='house_Chouse fl'>";
						var y = 0;
						for(var j in oData[i]._source.tags){
							y++;
							ulli +="<span class='tag"+y+"'>"+oData[i]._source.tags[j]+"</span>";
							if(y==4){break;}
						}
						for(var x=0;x<oData[i]._source.diytags.length;x++){
							if(y==4){break;}
							y++;
							ulli +="<span class='data_tag'>"+oData[i]._source.diytags[x]+"</span>";
						}
						ulli += "</div><div class='discount'><b>"+oData[i]._source.youhui+"</b><i>"+oData[i]._source.zhehui+"</i></div></div>";
						if(oData[i]._source.buildPriceAvg == '待定'){
							ulli += "<h6 class='New_Pic'><b>均价</b><span class='average'><i>"+oData[i]._source.buildPriceAvg+"</i><em></em></span></h6></a></li>";
						}else{
							ulli += "<h6 class='New_Pic'><b>均价</b><span class='average'><i>"+oData[i]._source.buildPriceAvg+"</i><em>元/平</em></span></h6></a></li>";
						}

						$(ulli).appendTo(proSort.$list);
					};
					$("<li id='house_Footer'></li>").appendTo(proSort.$list);
					myScroll.refresh();//重新计算高度
				}else {
					if(proSort.pageNum == 1){
						$("<li>很抱歉，没有找到相符的楼盘！</li>").appendTo(proSort.$list)
					}
					proSort.canLoad = false;//没有数据了就不能在加载
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
</script>
</html>