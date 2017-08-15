@extends('h5.mainlayout')
@section('title')
<title>【{{CURRENT_CITYNAME}}房地产门户|{{CURRENT_CITYNAME}}房地产网|{{CURRENT_CITYNAME}}房地产平台】 - {{CURRENT_CITYNAME}}搜房网 网罗天下房</title>
<meta name="keywords" content="{{CURRENT_CITYNAME}}房产,{{CURRENT_CITYNAME}}房地产,买房,{{CURRENT_CITYNAME}}租房,业主社区,{{CURRENT_CITYNAME}}新房,{{CURRENT_CITYNAME}}二手房,{{CURRENT_CITYNAME}}写字楼,{{CURRENT_CITYNAME}}商铺,{{CURRENT_CITYNAME}}豪宅,{{CURRENT_CITYNAME}}别墅,理财,装修,家居,建材,家具,团购,房地产业内精英,中介服务
      "/>
<meta name="description" content="{{CURRENT_CITYNAME}}搜房网是中国的房地产综合网络平台，提供全面实时的房地产资讯内容，为广大网民提供专业的{{CURRENT_CITYNAME}}新房、{{CURRENT_CITYNAME}}二手房、{{CURRENT_CITYNAME}}租房、{{CURRENT_CITYNAME}}豪宅、{{CURRENT_CITYNAME}}别墅、{{CURRENT_CITYNAME}}写字楼、{{CURRENT_CITYNAME}}商铺等全方位海量资讯信息的品质搜房体验。为业主、客户及房地产业内精英们提供高效专业的信息推广及交易服务。并且为广大客户提供了房地产行业百科大全，可轻松获得业内名人，名词，名企及楼盘的相关信息数据。"/>

@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="/h5/css/index.css" />
@endsection
{{--此处是当前页面内容部分--}}
@section('content')
<div class="wrapper" id="indexContent">
    <div class="scroller ">
        {{--<div class="index_iScroll">--}}
            <!--=======================轮播图部分及搜索框开始=================-->
            {{-- @if(0) --}}
            <div class="banner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @if($admodels == 1)
                        <script type="text/javascript" src="/adShow.php?position=9&cityId={{CURRENT_CITYID}}"></script>
                        @elseif($admodels == 2)
                        <script type="text/javascript" src="/adShowModel.php?position=22&cityId={{CURRENT_CITYID}}"></script>
                        @endif
<!--                    	<div class="swiper-slide"><a href="/adVisitCount?id=48&target=aHR0cHM6Ly9kZXRhaWwudG1hbGwuY29tL2l0ZW0uaHRtP3NwbT1hMXoxMC41LWItcy53NDAxMS0xNDg5NTg5Njg3OC4yMi5mQ09INHAmaWQ9NTMxOTIyMTY3OTkwJnJuPWFmNjE2NjNhNDJmMmRjYTJhYjJkODk0MjQ0ODE0MmRhJmFiYnVja2V0PTI=" target="_blank"><img src="/h5/image/arlo_banH5.jpg" /></a></div>
                        <div class="swiper-slide"><a href="http://www.sofang.com/cooperation/"><img src="/h5/image/1.png" /></a></div>
                        <div class="swiper-slide"><a href="http://bj.sofang.com/xinfindex/1003/303.html"><img src="/h5/image/2.jpg" /></a></div>
                        <div class="swiper-slide"><a href="##"><img src="/h5/image/4.jpg" /></a></div>
                        <div class="swiper-slide"><a href="http://bj.sofang.com/xinfindex/1000/303.html"><img src="/h5/image/5.png" /></a></div>-->
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
           {{-- @else --}}
           {{-- <div class="banner"> --}}
            {{--    <div class="swiper-container"> --}}
            {{--        <div class="swiper-wrapper"> --}}
            {{--            @if(!empty($ad_arr['1002'])) --}}
            {{--                @foreach($ad_arr['1002'] as $k=>$val) --}}
            {{--                <div class="swiper-slide"> --}}
            {{--                    @if(!empty($val->url)) --}}
            {{--                    <a href="{{$val->url}}"><img src="{{get_img_url('ad', $val->fileName)}}" width="750px" height="375px"/></a> --}}
            {{--                    @else --}}
            {{--                    <img src="{{get_img_url('ad', $val->fileName)}}" width="750px" height="375px"/> --}}
            {{--                    @endif --}}
            {{--                </div> --}}
            {{--                @endforeach --}}
            {{--            @endif --}}
            {{--        </div> --}}
                    <!-- Add Pagination -->
            {{--        <div class="swiper-pagination"></div> --}}
            {{--    </div> --}}
            {{--</div> --}}
            {{--@endif --}}
            <!--=======================轮播图部分及搜索框结束=================-->
            <!--======================header开始============================-->
            <header class="index_header">
                <h4><a href="/city/citysList">{{CURRENT_CITYNAME}}</a></h4>
                <h3><!--搜房--></h3>
                @if(!Auth::check())
                <h5><a href="/login" class="logoin">登录</a></h5>
                @else 
                <h5>
                @if(!empty(Auth::user()->userName))
                <a href="javascript:void(0);" class="logoin">{{Auth::user()->userName}}</a>
                @else
                <a href="javascript:void(0);" class="logoin">{{Auth::user()->mobile}}</a>
                @endif
                <a href="/logout" class="out">退出</a></h5>
                @endif
            </header>
            <!--======================header结束============================-->
            <!--=======================分类列表开始==========================-->
            <div class="index_List">
                <ul>
                    <li class="List_lf">
                        <a href="/new/area"><img src="/h5/image/btn1.png" alt="" />
                            <h6>新房</h6></a>
                    </li>
                    <li>
                        <a href="/esfsale/area"><img src="/h5/image/btn2.png" alt="" />
                            <h6>二手房</h6></a>
                    </li>
                    <li>
                        <a href="/esfrent/area"><img src="/h5/image/btn3.png" alt="" />
                            <h6>租房</h6></a>
                    </li>
                    <li>
                        <a href="/xzlrent/area"><img src="/h5/image/btn4.png" alt="" />
                            <h6>写字楼</h6></a>
                    </li>
                    <li class="List_lf">
                        <a href="/sprent/area"><img src="/h5/image/btn5.png" alt="" />
                            <h6>商铺</h6></a>
                    </li>
                    <li>
                        <a href="/bsrent/area"><img src="/h5/image/btn8.png" alt="" />
                            <h6>豪宅别墅</h6></a>
                    </li>
                    <li>
                        <a href="/calc"><img src="/h5/image/btn6.png" alt="" />
                            <h6>计算器</h6></a>
                    </li>
                    <li>
                        <a href="/map/sale/house"><img src="/h5/image/btn7.png" alt="" />
                            <h6>地图找房</h6></a>
                    </li>

                </ul>
            </div>
            <!--=======================分类列表结束==========================-->
            <!--=======================详细信息开始==========================-->
            <div class="index_hot fl">
                <ul class="index_Hlist">
                    <li class="scroll_list">
                        <h2>热门房源</h2>
                    </li>
                    <?php $houseDao = new \App\Dao\Agent\HouseDao;?>
                    @if(!empty($houses))                    
                    @foreach($houses as $house)
                    <li class="index_footer">
                        <!--<a href="detail/Communitydetail.html"> -->
                        <a href="/housedetail/s{{$sr}}{{$house->_source->id}}.html">
                            <img src="@if(!empty($house->_source->thumbPic)){{get_img_url($objectType,$house->_source->thumbPic)}}@else{{$defaultImage}}@endif" />
                            <div class="index_Hmain fl">
                                <h3>{{$house->_source->title}}</h3>
                                <h6>@if(!empty($house->_source->name))[{{$house->_source->name}}]@endif{{$house->_source->address}}</h6>
                                <ul>
                                    <li>{{!empty(substr($house->_source->roomStr,0,1))?substr($house->_source->roomStr,0,1):'0'}}室{{!empty(substr($house->_source->roomStr,2,1))?substr($house->_source->roomStr,2,1):'0'}}厅<i>|</i></li>
                                    <li>{{$house->_source->area}}平<i>|</i></li>
                                    <li>{{$house->_source->currentFloor}}/{{$house->_source->totalFloor}}<i>|</i></li>
                                    <li>{{$towards[$house->_source->faceTo]}}</li>
                                </ul>
                                <div class="house_Chouse fl">
                                    <?php $x = 1; ?>
                                    @if(!empty($house->_source->tagId))
                                        @foreach(explode('|',$house->_source->tagId) as $k=>$tagid)
                                            @if(!empty($featurestag[$tagid]))
                                            <span class="tag{{$x}}">{{$featurestag[$tagid]}}</span>
                                            <?php $x++;if ($x > 3) break;?>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if(!empty($house->_source->diyTagId))
                                    <?php $tid = explode('|',$house->_source->diyTagId);?>                                                                                    
                                        @if(!empty($diynames = $houseDao->getDiyTagByIds($tid)))                                        
                                            @foreach($diynames as $diyname) 
                                            <?php if ($x > 3) break;$x++; ?>
                                            @if(!empty($diyname->name))
                                            <span class="tag{{$x}}">{{$diyname->name}}</span>
                                            @endif
                                            @endforeach
                                        @endif
                                    @endif
                                   <!--  <span class="house_Croom fl">学区房</span>                                    
                                    <span class="house_Cdup fl">复式</span>
                                    <span class="house_Csub fl">地铁房</span> -->
                                </div>
                            </div>
                            <h1><span class="list_Pic"><i>{{floor($house->_source->price2) }}</i><em>万</em></span></h1>
                        </a>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
            <!--===================================周边楼盘==================================-->
            <div class="index_hot fl">
                <ul class="index_Hlist">                    
                    <li class="scroll_list">
                        @if(!empty($builds))
                        <h2>最新楼盘</h2>
                        @endif
                    </li>
                    @if(!empty($builds))
                        @foreach($builds as $build)
                            <?php
                                  $type2 = $build->_source->type2;
                                  if(empty($type2)){
                                    $type2 = '';
                                    if(!empty($build->_source->type1)){
                                        $ctype1 = substr($build->_source->type1,0,1);
                                        foreach(explode('|',$build->_source->type2) as $ctype2){
                                            if($ctype1 == substr($ctype2,0,1)){
                                                $type2 = $ctype2;
                                                break;
                                            }
                                        }
                                    }
                                }
                                if(!empty($type2)){
                                    $typeInfo = 'type'.$type2.'Info';
                                    if(!empty($build->_source->$typeInfo)){
                                        $typeInfo = json_decode($build->_source->$typeInfo);
                                    }
                                }
                                $priceAvgtype2 = 'priceSaleAvg'.$type2;
                                $priceAvg = 'priceSaleAvg'.substr($type2,0,1);
                            ?>
                            <li class="index_footer">
                                <!-- <a href="detail/Communitydetail.html"> -->
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
                                        <!-- <ul>
                                            <li>户型<i>|</i></li>
                                            <li>1室({{!empty($build->_source->saleCountRoom1)?$build->_source->saleCountRoom1:0}})<i>|</i></li>
                                            <li>2室({{!empty($build->_source->saleCountRoom2)?$build->_source->saleCountRoom2:0}})<i>|</i></li>
                                            <li>3室({{!empty($build->_source->saleCountRoom3)?$build->_source->saleCountRoom3:0}})<i>|</i></li>
                                            <li>4室({{!empty($build->_source->saleCountRoom4)?$build->_source->saleCountRoom4:0}})</li>
                                        </ul> -->
                                        <div class="house_Chouse fl">
                                            <?php $x=1;?>
                                            @if(!empty($typeInfo->tagIds))
                                                @foreach(explode('|',$typeInfo->tagIds) as $k=>$tagid)
                                                    @if(!empty($featurestag[$tagid]))
                                                        <span class="tag{{$x}}">{{$featurestag[$tagid]}}</span>
                                                        <?php $x++;if($x >3) break;?>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if(!empty($typeInfo->diyTagIds))
                                                <?php $tid = explode('|',$typeInfo->diyTagIds);?>                                                                                    
                                                @if(!empty($diynames = $houseDao->getDiyTagByIds($tid)))                                        
                                                    @foreach($diynames as $diyname) 
                                                    <?php if ($x > 3) break;$x++; ?>
                                                    <span class="tag{{$x}}">{{$diyname->name}}</span>                                          
                                                    @endforeach
                                                @endif
                                            @endif
                                            <!-- <span class="house_Croom fl">学区房</span><span class="house_Cdup fl">复式</span><span class="house_Csub fl">地铁房</span> -->
                                        </div>
                                        <?php 
                                            //电商优惠
                                            if(!empty($build->_source->specialOffers)){
                                                $res = $build->_source->specialOffers;
                                                $res = explode('_', $res);
                                                $newres = '';
                                                foreach($res as $k=>$v){
                                                    $newres .= $v.'抵';
                                                }
                                                $len = mb_strlen($newres,'utf-8');
                                                $newres = mb_substr($newres, 0, $len-1, 'utf-8');
                                            }
                                            //折扣信息
                                            if (isset($build->_source->discountType)){
                                                $discount = '';
                                                if ($build->_source->discountType == 1) {
                                                    $discount .= $build->_source->discount . '折';
                                                } else if ($build->_source->discountType == 2) {
                                                    $discount .=  '直减' . $build->_source->subtract . '元';
                                                } else if ($build->_source->discountType == 3) {
                                                    $discount .= $build->_source->discount . '折后再减' . $build->_source->subtract . '元';
                                                } else {
                                                    $discount  = '';
                                                }
                                            }
                                                
                                        ;?>
                                        <div class="discount">{{!empty($newres)?$newres:''}}　{{!empty($discount)?$discount:''}}</div>
                                    </div>
                                    <h6 class="prot_Pic">
                                        @if(!empty($build->_source->$priceAvgtype2))
                                        <span class="average"><i>{{$build->_source->$priceAvgtype2}}</i><em>元/㎡</em></span>
                                        @elseif(!empty($around->_source->$priceAvg))
                                        <span class="average"><i>{{$build->_source->$priceAvg}}</i><em>元/㎡</em></span>
                                        @else
                                        <span class="average"><i>待定</i><em></em></span>
                                        @endif
                                    </h6>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        <!--=======================底部开始==========================-->
            <bottom class="bottom">
                    <ul class="bottomUl">
                            <li><a href="##">小区大全</a></li>
                            <li class="first"><a href="##">网站地图</a></li>
                            <li class="first"><a href="##">历史浏览</a></li>
                            <li class="first"><a href="/new/area">最新房源</a></li>
                            <li class="first"><a href="/calc">房贷计算器</a></li>
                    </ul>
                    <ul class="bottomList">
                            <li><a href="/">手机版</a></li>
                            <li><a href="/">电脑版</a></li>
                            <li><a href="##">客户端</a></li>
                            <li><a href="##">意见反馈</a></li>
                            <li><a href="##">免责声明</a></li>
                    </ul>
                    <p class="p2">Copyright © 2016&nbsp;m.Sofang.com&nbsp;京ICP证040491号</p>
            </bottom>
            <!--=======================底部结束==========================-->
        {{--</div>--}}
    </div>
</div>
<script src="/h5/js/common/iscroll.js" type="text/javascript"></script>
<script src="/h5/js/common/iscroll-probe.js" type="text/javascript"></script>
<script type="text/javascript">
$('.out').css({float:'right',textIndex:'-999',textAlign:'center',fontSize:'24px',lineHeight:'100px',display:'block'});
/*var myScroll1;
function loaded() {
    var pageWrapper = $(".wrapper");
    myScroll1 = new IScroll('.scroller', {mouseWheel: true});
}
loaded();*/
function loaded () {
	var myScroll,
		upIcon = $("#up-icon"),
		downIcon = $("#down-icon");
		
	myScroll = new IScroll('.wrapper', { probeType: 3, mouseWheel: true });
	
	myScroll.on("scroll",function(){
		var y = this.y,
			maxY = this.maxScrollY - y,
			downHasClass = downIcon.hasClass("reverse_icon"),
			upHasClass = upIcon.hasClass("reverse_icon");
		
		if(y >= 40){
			!downHasClass && downIcon.addClass("reverse_icon");
			return "";
		}else if(y < 40 && y > 0){
			downHasClass && downIcon.removeClass("reverse_icon");
			return "";
		}
		
		if(maxY >= 40){
			!upHasClass && upIcon.addClass("reverse_icon");
			return "";
		}else if(maxY < 40 && maxY >=0){
			upHasClass && upIcon.removeClass("reverse_icon");
			return "";
		}
	});
	
	myScroll.on("slideDown",function(){
		if(this.y > 40){
			
			upIcon.removeClass("reverse_icon")
		}
	});
	
	myScroll.on("slideUp",function(){
		if(this.maxScrollY - this.y > 40){
			
			upIcon.removeClass("reverse_icon")
		}
	});
}

 		
</script>
@endsection
