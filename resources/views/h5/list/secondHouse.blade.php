<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
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
		
		<!--==================二手房header开始==========================================-->
		<header class="house_header">
			<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
			<input type="hidden" id="linkurl"  value="{{$linkurl}}" >
			<input type="hidden" id="par"  value="{{$purl}}" >
			<div class="house_Hbg fl"><a href="javascript:window.history.go(-1)"></a></div>
			<h3 class="house_Htit fl {{($type == 'bsrent' || $type == 'bssale')?'storeHouse':''}}">@if($type == 'esfsale')二手房@elseif($type == 'esfrent')租房@elseif($type == 'bsrent')豪宅别墅出租@elseif($type == 'bssale')豪宅别墅出售@endif</h3>
			<ul class="houseUl">
				@if($type == 'esfsale' || $type == 'esfrent')
					<li><a href="/esfrent/area">租房</a></li>
					<li><a href="/esfsale/area">二手房</a></li>
				@else
					<li><a href="/bsrent/area">豪宅别墅出租</a></li>
					<li><a href="/bssale/area">豪宅别墅出售</a></li>
				@endif
			</ul>
			<!--<a class="house_Hmag fl" href="##"></a>-->
			@if(strpos($type,'sale'))
				<a class="house_Hmap fr" href="/map/sale/house"></a>
			@else
				<a class="house_Hmap fr" href="/map/rent/house"></a>
			@endif
		</header>
		<!--==================二手房header结束==========================================-->
		<div class="space24"></div>
		<!--========================豪宅别墅Search开始============================================-->
		<div class="list_search ps">
			<i class="search_btn ps" id="search_btn"></i>
			<input type="text" name="text" id="keyword" placeholder="搜索楼盘名/地名" tp="{{$type}}" class="search" value="{{!empty($keyword)?$keyword:''}}"/>
		</div>
		<ul class="seatList">
		</ul>
		<!--========================豪宅别墅Search开始============================================-->
		<!--==================二手房Nav开始=============================================-->
		<nav class="house_Nnav">
			<ul class="house_Nlist" id="pagenavi">
				<li class="Nlist_left fl"><span>
						<?php
						$xarea = '区域';
						if(!empty($xbus = App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($busid))){
							$xarea = $xbus;
						}elseif($xcityarea = App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($cityareaid)){
							$xarea = $xcityarea;
						}elseif(!empty($stationid)){
							if(!empty($stations = $subWayStationH5[$subid])){
								foreach($stations as $station){
									if($stationid == $station->id){
										$xarea = $station->name;
										break;
									}
								}
							}
						}elseif(!empty($subid)){
							if(!empty($subWay)){
								foreach($subWay as $sub){
									if($sub->id == $subid){
										$xarea = $sub->name;
										break;
									}
								}
							}
						}
						echo $xarea;
						?>
					</span><i></i><b></b></li>
				<li class="Nlist_left fl"><span>@if(!empty($averageprice)){{$averageprices[$averageprice]}}@else @if($type == 'esfsale'||$type == 'bssale')总价@else租金@endif @endif</span><i></i><b></b></li>
				<li class="Nlist_left fl"><span>@if(!empty($model)){{$models[$model]}}@else户型@endif</span><i></i><b></b></li>
				<?php
				//更多的选择条件个数
				$xnum = 0;
				if(!empty($singlearea)){
					$xnum += 1;
				}
				if(!empty($rentway)){
					$xnum += 1;
				}
				if(!empty($toward)){
					$xnum += 1;
				}
				if(!empty($floor)){
					$xnum += 1;
				}
				if(!empty($decorate)){
					$xnum += 1;
				}
				if(!empty($that)){
					$xnum += 1;
				}
				if(!empty($housetype2)){
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
							if(empty($cityareaid)&&empty($busid)&&empty($subid)&&empty($stationid)){
								$xmo = 'active';
							}
						?>
						<li class="{{(!empty($cityareaid)||!empty($busid))?'active':$xmo}}">区域</li>
						<li class="{{(!empty($subid)||!empty($stationid))?'active':''}}">地铁</li>
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
										<?php
										if(CURRENT_CITYID ==1){
											if($v->id == $hwdc) continue;
										}
										?>
									@if($cityareaid == $v->id)
										<li class="active">{{$v->name}}</li>
									@else
										<li>{{$v->name}}</li>
									@endif
								@endforeach
							@endif
						</ul>
						<ul class="box_subarea {{!empty($subid)?'active':''}}">
							@if(!empty($subWay))
								@if(empty($subid))
									<li><a href="/{{$type}}/sub/{{get_url_by_id($purl,'ac')}}">不限</a></li>
								@else
									<li><a href="/{{$type}}/sub/{{get_url_by_id($purl,'ac')}}">不限</a></li>
								@endif
								@foreach($subWay as $sub)
									@if($sub->id == $subid)
										<li class="active">{{$sub->name}}</li>
									@else
										<li>{{$sub->name}}</li>
									@endif
								@endforeach
							@endif
						</ul>
					</div>
					<div class="area_box1 ">
						<ul class="box_area1 active">
						</ul>
						@if(!empty($businessAreaH5))
							@foreach($businessAreaH5 as $k=>$bv)
								<?php
								if(CURRENT_CITYID ==1){
									if($k == $hwdc) continue;
								}
								?>
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
					<div class="area_box2 ">
						<ul class="box_area1 {{!empty($stationid)?'active':''}}">
						</ul>
						@if(!empty($subWayStationH5))
							@foreach($subWayStationH5 as $bv)
								<ul class="box_area2 active">
									@if(!empty($bv))
										<li><a href="/{{$type}}/sub/{{get_url_by_id($purl,'ac',$bv[0]->lineId)}}">不限</a></li>
										@foreach($bv as $sv)
											@if($sv->id == $stationid)
												<li><a href="/{{$type}}/sub/{{get_url_by_id(get_url_by_id($purl,'ac',$sv->lineId),'ad',$sv->id)}}"  class="active">{{$sv->name}}</a></li>
											@else
												<li><a href="/{{$type}}/sub/{{get_url_by_id(get_url_by_id($purl,'ac',$sv->lineId),'ad',$sv->id)}}">{{$sv->name}}</a></li>
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
						@if(!empty($averageprices))
							@foreach($averageprices as $k=>$v)
								@if($averageprice == $k)
									@if(!empty($averageprice))
										<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}" class="active">{{$v}}</a></li>
									@else
										<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ao',$k)}}">{{$v}}</a></li>
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
						@if(!empty($models))
							@foreach($models as $k=>$v)
								@if($model == $k)
									@if(!empty($model))
										<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'aq',$k)}}" class="active">{{$v}}</a></li>
									@else
										<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'aq',$k)}}">{{$v}}</a></li>
									@endif
								@else
									<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'aq',$k)}}">{{$v}}</a></li>
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
							if(!empty($singlearea)){
								$active = 'sr';
							}elseif(!empty($rentway)){
								$active = 'sr';
							}elseif(!empty($toward)){
								$active = 'to';
							}elseif(!empty($floor)){
								$active = 'fl';
							}elseif(!empty($decorate)){
								$active = 'de';
							}elseif(!empty($that)){
								$active = 'th';
							}elseif(!empty($housetype2)){
								$active = 'ho';
							}
						?>
						<li class="{{($active=='sr' || $active=='')?'active':''}}">
							@if(($type != 'esfrent'))面积@else租赁@endif
						</li>
						<li class="{{($active=='to')?'active':''}}">朝向</li>
						@if($type == 'esfsale' || $type == 'esfrent')<li class="{{($active=='fl')?'active':''}}">楼层</li>@endif
						<li class="{{($active=='de')?'active':''}}">装修</li>
						@if($type == 'esfsale' || $type == 'bssale')
							@if($type == 'esfsale')<li class="{{($active=='th')?'active':''}}">房龄</li>@endif
							<li class="{{($active=='ho')?'active':''}}">住宅类别</li>
						@endif
					</ul>

					<div class="shaw_box">
						@if($type != 'esfrent')
							<ul class="box_Listarea {{($active=='sr' || $active=='')?'active':''}}">
								@if(!empty($singleareas))
									@foreach($singleareas as $k=>$v)
										@if($singlearea == $k)
											@if(!empty($singlearea))
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ap',$k)}}" class="active">{{$v}}</a></li>
											@else
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ap',$k)}}" >{{$v}}</a></li>
											@endif
										@else
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ap',$k)}}">{{$v}}</a></li>
										@endif
									@endforeach
								@endif
							</ul>
						@else
							<ul class="box_Listarea {{($active=='sr' || $active=='')?'active':''}}">
								@if(!empty($rentways))
									@foreach($rentways as $k=>$v)
										@if($rentway == $k)
											@if(!empty($rentway))
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ar',$k)}}" class="active">{{$v}}</a></li>
											@else
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ar',$k)}}" >{{$v}}</a></li>
											@endif
										@else
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'ar',$k)}}">{{$v}}</a></li>
										@endif
									@endforeach
								@endif
							</ul>
						@endif
						<ul class="box_Listarea {{($active=='to')?'active':''}}">
							@if(!empty($towards))
								@foreach($towards as $k=>$v)
									@if($toward == $k)
										@if(!empty($toward))
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bb',$k)}}" class="active">{{$v}}</a></li>
										@else
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bb',$k)}}">{{$v}}</a></li>
										@endif
									@else
										<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bb',$k)}}">{{$v}}</a></li>
									@endif
								@endforeach
							@endif
						</ul>
						@if($type == 'esfsale' || $type == 'esfrent')
							<ul class="box_Listarea {{($active=='fl')?'active':''}}">
									@if(!empty($floors))
										@foreach($floors as $k=>$v)
											@if($floor == $k)
												@if(!empty($floor))
													<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bd',$k)}}" class="active">{{$v}}</a></li>
												@else
													<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bd',$k)}}">{{$v}}</a></li>
												@endif
											@else
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bd',$k)}}">{{$v}}</a></li>
											@endif
										@endforeach
									@endif
								</ul>
						@endif
						<ul class="box_Listarea {{($active=='de')?'active':''}}">
							@if(!empty($decorates))
								@foreach($decorates as $k=>$v)
									@if($decorate == $k)
										@if(!empty($decorate))
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'be',$k)}}" class="active">{{$v}}</a></li>
										@else
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'be',$k)}}">{{$v}}</a></li>
										@endif
									@else
										<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'be',$k)}}">{{$v}}</a></li>
									@endif
								@endforeach
							@endif
						</ul>
						@if($type == 'esfsale' ||  $type =='bssale')
							@if($type == 'esfsale')
								<ul class="box_Listarea {{($active=='th')?'active':''}}">
									@if(!empty($thats))
										@foreach($thats as $k=>$v)
											@if($that == $k)
												@if(!empty($that))
													<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bc',$k)}}" class="active">{{$v}}</a></li>
												@else
													<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bc',$k)}}">{{$v}}</a></li>
												@endif
											@else
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'bc',$k)}}">{{$v}}</a></li>
											@endif
										@endforeach
									@endif
								</ul>
							@endif
							<ul class="box_Listarea {{($active=='ho')?'active':''}}">
								@if(!empty($housetypes))
									@foreach($housetypes as $k=>$v)
										@if($type == 'esfsale')
											<?php if($k == 304 || $k == 305){ continue;} ?>
										@else
											<?php if($k != 0 && $k != 304 && $k != 305){ continue;} ?>
										@endif
										@if($housetype2 == $k)
											@if(!empty($housetype2))
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}" class="active" >{{$v}}</a></li>
											@else
												<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a></li>
											@endif
										@else
											<li><a href="{{$linkurl}}/{{get_url_by_id($purl,'an',$k)}}">{{$v}}</a></li>
										@endif
									@endforeach
								@endif
							</ul>
						@endif
					</div>
				</div>
</section>
</nav>
<!--==================二手房Nav开始=============================================-->

<!--==================内容区域，获取数据开始========================================-->

<div class="scroll-wrap house_contet scroller">
			<div class="scrollerBox">
<ul class="house_Clist" id="newList">

</ul>
</div>
</div>
<div class="backTop" style="position: fixed; bottom: 150px; right: 20px;"><a href="javascript:;" class="backtop" id="backtop">回到顶部</a></div>	
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
			var xclass = data['class'];
			var oData = data['houses'];
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
				//拼接填充字符串
				for(var i=0;i<oData.length;i++){
					var ulli = "<li class='house_Cli'><a href='/housedetail/s"+xclass.substr(0,1) + oData[i]._source.id+".html'><img src='"+oData[i]._source.thumbPic+"' />"+
							"<div class='house_Cmain fl'><h3>"+oData[i]._source.title+"</h3>"+
							"<h6><em>"+oData[i]._source.name+"</em>&nbsp;&nbsp;"+oData[i]._source.address+"</h6>";
					ulli +="<ul>";
					var type2 = oData[i]._source.houseType2;
					if(xclass == 'rent' && (type2 !='304' && type2 !='305')){
						ulli +="<li>"+oData[i]._source.rentType+"<i>|</i></li>";
					}
					ulli +="<li>"+oData[i]._source.roomStr.substr(0,1)+"室"+oData[i]._source.roomStr.substr(2,1)+"厅<i>|</i></li><li>"+oData[i]._source.currentFloor+"/"+oData[i]._source.totalFloor+"层<i>|</i></li><li>"+oData[i]._source.faceTo+"</li>";
					if(xclass == 'sale'){
						ulli +="<li><i>|</i>"+oData[i]._source.buildYear+"年</li>";
					}
					ulli += "</ul>";
					//房源标签
					var y = 0;
					ulli +="<div class='house_Chouse fl'>";
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
					ulli += "</div></div>";
					if(xclass == 'sale'){
						if(oData[i]._source.price2 == 0){
							ulli += "<h1><span class='list_Pic'><i>面议</span><b>"+oData[i]._source.area+"平</b></h1></a></li>";
						}else{
							ulli += "<h1><span class='list_Pic'><i>"+oData[i]._source.price2+"</i><em>万</em></span><b>"+oData[i]._source.area+"平</b></h1></a></li>";
						}
					}else{
						if(oData[i]._source.price1 == ''){
							ulli += "<h1><span class='list_Pic'><i>面议</i><em></em></span></h1></a></li>";
						}else{
							ulli += "<h1><span class='list_Pic'><i>"+oData[i]._source.price1+"</i><em>元/月</em></span><b>"+oData[i]._source.area+"平</b></h1></a></li>";
						}
					}

					$(ulli).appendTo(proSort.$list);
				};
				$("<li id='house_Footer'></li>").appendTo(proSort.$list);
				myScroll.refresh();//重新计算高度
			}else {
				if(proSort.pageNum == 1){
					$("<li>很抱歉，没有找到相符的房源！</li>").appendTo(proSort.$list)
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
