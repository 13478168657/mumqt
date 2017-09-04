@extends('/'.$theme.'/layout/mainlayout',['index'=>1,'search'=>true])
@section('head')
    <meta charset="UTF-8" />
    <title>{{$title}}</title>
    <meta name="keywords" content="{{CURRENT_CITYNAME}}房产,搜房网,搜房,买房,租房,新房,二手房,写字楼,商铺,豪宅,别墅"/>
    <meta name="description" content="搜房网是中国房地产信息平台，搜房网提供全面实时的房地产资讯内容，为广大网民提供专业的新房、二手房、租房、豪宅别墅、写字楼、商铺等全方位资讯信息。为业主、客户及房地产业内精英们提供高效专业的信息推广服务。"/>
    <link rel="stylesheet" href="/{{$theme}}/css/base.css" />
    <link rel="stylesheet" href="/{{$theme}}/css/index.css" />
@endsection
@section('content')
<!--<script type="text/javascript" src="/adShowModel.php?position=2&cityId={{CURRENT_CITYID}}"></script>-->
<!--<ul class="banner">
    <li><a href=""><img src="/{{$theme}}/image/s-ban.jpg" alt="" /></a></li>
</ul>-->
<!--<div class="s_ban left_ban">
    <a href=""><img src="/{{$theme}}/image/house.jpg" alt="" /></a>
    <i class="closebtn l"></i>
</div>-->

<script type="text/javascript" src="/adShowModel.php?position=11&cityId={{CURRENT_CITYID}}"></script>
<script type="text/javascript" src="/adShowModel.php?position=17&cityId={{CURRENT_CITYID}}"></script>
<script type="text/javascript" src="/adShowModel.php?position=18&cityId={{CURRENT_CITYID}}"></script>
<!--<div class="s_ban right_ban">
    <a href=""><img src="/{{$theme}}/image/house.jpg" alt="" /></a>
    <i class="closebtn r"></i>
</div>-->
<div class="container">
    <div class="blocks clearfix">
    	<div class="report fl">
    		<h2 class="clearfix">
                <a href="/new/area"><span>推荐楼盘</span><i>》</i></a>
            </h2>
    		<ul class="buildings recommend">
                @if(!empty($newHotCommunity[0]))
                    @foreach($newHotCommunity[0] as $k => $v)
                        @if(!empty($v->_source))
    			<li>
    				<a href="/xinfindex/{{$v->_source->id}}/301.html">
                        <img width="271" height="170" alt="{{$v->_source->name}}" onerror="/{{$theme}}/image/default.jpg" src="@if(!empty($v->_source->titleImage)){{get_img_url('commPhoto',$v->_source->titleImage)}}@else{{$theme.'//image/ss.jpg'}}@endif" class="fl">
                    </a>
                    <i class="tag"></i>
                    <dl>
                        <dt>
                            <a href="/xinfindex/{{$v->_source->id}}/301.html">{{$v->_source->name}}</a>
                        </dt>
                        <dd>
                            <span class="fl fs-20">{{$v->_source->areaname}}</span>
                            <?php $type2 = 'priceSaleAvg'.$v->_source->type2;
                                $unit = $type2.'Unit';
                                if(!empty($v->_source->$type2)){
                                    $price = '均价'.$v->_source->$type2;
                                    if(!empty($v->_source->$unit) && $v->_source->$unit == 2){
                                        $price .= '万元/套';
                                    }else{
                                        $price .= '元/平米';
                                    }
                                }else{
                                    $price = '待定';
                                }
                            ?>
                            <span class="fr">{{$price}}</span>
                        </dd>
                    </dl>
    			</li>
                        @endif
                    @endforeach
                @endif
    		</ul>
    	</div>
    	<div class="news fr">
    		<h2 class="clearfix">
    			<a href="/news/newsList.html"><span>新闻资讯</span><i>》</i></a>
    		</h2>
                @if(!empty($articleList))
                <ul>
                    @foreach($articleList as $k => $v)
                        @if(in_array($k,[0,1,2]))
                            <li><h3><i class="orange">{{$k+1}}</i><a href="/article/{{$v->id}}.html" target="_blank" ><span>{{$v->title}}</span></a></h3>
                                <p><?php echo htmlspecialchars_decode($v->content); ?></p>
                            </li>
                        @else
                            <li>
    				<h3><i>{{$k+1}}</i><a href="/article/{{$v->id}}.html"><span>{{$v->title}}</span></a></h3>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @endif
    	</div>
        <!--<h2 class="clearfix">搜房资讯</h2>
        <div class="report_list clearfix">
            <dl class="news">
                <dt class="clearfix"><span class="fl">新闻资讯</span><a href="/news/newsList.html" target="_blank" class="fr">更多</a></dt>
                @if(!empty($articleList))
                    @foreach($articleList as $v)
                        <dd><i></i><a href="/article/{{$v->id}}.html" target="_blank" >{{$v->title}}</a></dd>
                    @endforeach
                @endif
            </dl>
        </div>-->
    </div>
    <script type="text/javascript" src="/adShowModel.php?position=12&cityId={{CURRENT_CITYID}}"></script>
<!--    <ul class="banner">
        <li><a href=""><img src="/{{$theme}}/image/s-ban.jpg" alt="" /></a></li>
    </ul>-->
     <div class="blocks">
        <h2 class="clearfix">
        	<a href="/new/area" class="fl"><span><b class="hot"></b>热门楼盘</span><i>》</i></a>
        	<a href="{{config('hostConfig.agr_host')}}" class="fr"><b class="agent"></b><strong>注册成为经纪人</strong></a>
        </h2>
        <div class="news_house">
            <ul class="buildings clearfix">{{--fr--}}
                @if(!empty($newHotCommunity[1]))
                    @foreach($newHotCommunity[1] as $k => $v)
                        @if(!empty($v->_source))
                <li>
                    <a href="/xinfindex/{{$v->_source->id}}/301.html">
                        <img width="271" height="170" alt="{{$v->_source->name}}" onerror="/{{$theme}}/image/default.jpg" src="@if(!empty($v->_source->titleImage)){{get_img_url('commPhoto',$v->_source->titleImage)}}@else{{'/'.$theme.'/image/default.jpg'}}@endif" alt="{{$v->_source->name}}" class="fl"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="/xinfindex/{{$v->_source->id}}/301.html">{{$v->_source->name}}<b>[{{$v->_source->areaname}}]</b></a>
                        </dt>
                        <dd>
                            <span>{{$v->_source->salesStatusPeriods==1?"在售":($v->_source->salesStatusPeriods==0?'待售':($v->_source->salesStatusPeriods==2?'售完':''))}}</span>
                            <span>普通住宅</span>
                        </dd>
                        <?php $type2 = 'priceSaleAvg'.$v->_source->type2;
                        $unit = $type2.'Unit';
                        if(!empty($v->_source->$type2)){
                            $price = '均价'.$v->_source->$type2;
                            if(!empty($v->_source->$unit) && $v->_source->$unit == 2){
                                $price .= '万元/套';
                            }else{
                                $price .= '元/平米';
                            }
                        }else{
                            $price = '待定';
                        }
                        ?>
                        <dd>{{$price}}</dd>
                    </dl>
                </li>
                        @endif
                    @endforeach
                @endif

            </ul>
        </div>
    </div>
    <div class="blocks">
        <h2 class="clearfix">
        	<a href="/new/area" class="fl"><span><em>优</em><b class="cheap"></b><em>楼盘</em></span><i>》</i></a>
        	<a href="/about/contactus.html" class="fr"><b class="tel"></b><strong>咨询电话</strong></a>
        </h2>
            <ul class="buildings  build_discount clearfix">
                @if(!empty($periods))
                    @foreach($periods as $v)
                <li>
                    <a href="/xinfindex/{{$v->communityId}}/301.html">
                        <img width="271" height="170" alt="{{$v->name}}" onerror="/{{$theme}}/image/default.jpg" src="@if(!empty($v->periods_img)){{get_img_url('commPhoto',$v->periods_img)}}@else{{'/'.$theme.'/image/default.jpg'}}@endif" alt="{{$v->name}}" class="fl"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="/xinfindex/{{$v->id}}/301.html">{{$v->name}}<b>[{{$v->periods_areaname}}]</b></a>
                        </dt>
                        <dd>
                            @if($v->marketingType==1 || $v->marketingType==3)
                                <span>均价{{intval($v->saleAvgPrice)}}{{$v->saleAvgPriceUnit==1?'元/平米':'万元/套'}}</span>
                            @else
                                <span>均价{{intval($v->rentAvgPrice)}}{{$v->rentAvgPriceUnit==1?'元/平米':'万元/套'}}</span>
                            @endif
                        </dd>
                        @if(!empty($v->specialOffers) && $v->specialOffers != '_')
                            <?php $arr=explode('_',$v->specialOffers); ?>
                            <dd class="max"><span>{{$arr[0].'抵'.$arr[1]}}</span></dd>
                        @else
                            @if($v->discountType==1)
                                <dd class="discount"><i>折</i><span>{{$v->discount}}折</span></dd>
                            @elseif($v->discountType==2)
                                <dd class="reduce"><i>减</i><span>减去{{intval($v->subtract)}}元</span></dd>
                            @else
                                <dd class="">无优惠</dd>
                            @endif
                        @endif
                    </dl>
                </li>
                    @endforeach
                @endif

            </ul>
    </div>
    @if(!empty($newCommunity))
    <div class="blocks">
        <h2 class="clearfix">
        	<a href="/new/area" class="fl"><span>新房</span><i>》</i></a>
        	<a href="/cal3" class="fr"><b class="cal"></b><strong>房贷计算器</strong></a>
        </h2>
        <div class="news_house">
            <?php
            /**
            <div class="sign fl">
                <div class="signname">
                    <h3>
                        <span class="fl">活动报名</span>
                        <!--<a href="../../Details/DetailGroupBuy/groupBuyIndex.htm" class="fr">更多&gt;&gt;</a>-->
                    </h3>
                    <div class="count_down">
                        <p class="tit"><a href="">2016-6-31 太阳宫看房报名处</a></p>
                        <p class="tips"><b>1</b>天&nbsp;<b>1</b>时<b>1</b>分<b>1</b>秒</p>
                        <p class="num">现已报名20人</p>
                        <p><input type="text" /><span>您的姓名：</span></p>
                        <p><input type="text" /><span>您的手机：</span></p>
                        <p><input type="text" /><span>参加人数：</span></p>
                        <div><input type="button" value="我要报名"/></div>
                    </div>
                </div>
                <div class="article">
                    <h6>太阳宫看房团</h6>
                    <p>为了迎接新年的到来，搜房网携手今朝馨苑园中园，为渭南楼市点燃2016年的第一把火！团购抢房，疯狂来袭，最高3千抵13万钜惠。为了迎接新年的到来，搜房网携手今朝馨苑园中园，为渭南楼市点燃2016年的第一把火！团购抢房，疯狂来袭，最高3千抵13万钜惠。</p>
                    <p class="more"><a href="">查看活动详情</a></p>
                </div>
            </div>
            */
            ?>
            <ul class="buildings clearfix">{{--fr--}}
                @foreach($newCommunity as $k => $v)
                <li>
                    <a href="/xinfindex/{{$v->_source->id}}/301.html">
                        <img width="271" height="170" alt="{{$v->_source->name}}" onerror="/{{$theme}}/image/default.jpg" src="@if(!empty($v->_source->titleImage)){{get_img_url('commPhoto',$v->_source->titleImage)}}@else{{'/'.$theme.'/image/default.jpg'}}@endif" alt="{{$v->_source->name}}" class="fl"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="/xinfindex/{{$v->_source->id}}/301.html">{{$v->_source->name}}<b>[{{$v->_source->areaname}}]</b></a>
                        </dt>
                        <dd>
                            <span>{{$v->_source->salesStatusPeriods==1?"在售":($v->_source->salesStatusPeriods==0?'待售':($v->_source->salesStatusPeriods==2?'售完':''))}}</span>
                            <span>普通住宅</span>
                        </dd>
                        <?php $type2 = 'priceSaleAvg'.$v->_source->type2;
                        $unit = $type2.'Unit';
                        if(!empty($v->_source->$type2)){
                        $price = '均价'.$v->_source->$type2;
                        if(!empty($v->_source->$unit) && $v->_source->$unit == 2){
                        $price .= '万元/套';
                        }else{
                        $price .= '元/平米';
                        }
                        }else{
                        $price = '待定';
                        }
                        ?>
                        <dd>{{$price}}</dd>
                    </dl>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
    @endif
    <script type="text/javascript" src="/adShowModel.php?position=13&cityId={{CURRENT_CITYID}}"></script>
<!--    <ul class="banner">
        <li><a href=""><img src="/{{$theme}}/image/s-ban.jpg" alt="" /></a></li>
    </ul>-->
    <div class="house">
        <h2 class="clearfix">
        	<a href="/esfsale/area"><span>二手房</span><i>》</i></a>
        </h2>
        <div class="house_cont clearfix">
            <div class="audit fl">
            	<dl>
            		<dt>区域</dt>
            		<dd class="district"> @if(!empty($cityarea))
                    @foreach($cityarea as $k=> $v)
                        @if($k < 4)
                            @foreach($v as $k1 =>$v1)
                    <a href="/esfsale/area/aa{{$v1->id}}">{{$v1->name}}</a>
                                @if(count($v)- 1 !=  $k1)
                                    <span>|</span>
                                    @endif
                                @endforeach
                            @endif
                    @endforeach
                    @endif
                    </dd>
                     <dd class="more"><a href="/esfsale/area">更多</a><i>》</i></dd>
            	</dl>
                <dl>
                	<dt>户型/类型</dt>
                	<dd>
                		<a href="/esfsale/area/aq1">一室</a><span>|</span>
	                    <a href="/esfsale/area/aq2">二室</a><span>|</span>
	                    <a href="/esfsale/area/aq3">三室</a><span>|</span>
	                    <a href="/esfsale/area/aq4">四室</a>
	                    <a href="/esfsale/area">住宅</a><span>|</span>
	                    <a href="/spsale/area">商铺</a><span>|</span>
	                    <a href="/xzlsale/area">办公楼</a>
                    </dd>
                    <dd class="more"><a href="/esfsale/area">更多</a><i>》</i></dd>
                </dl>
                <dl>
                	<dt>价格</dt>
                	<dd class="price price2">
                		@if(!empty($averageprices))
	                    @foreach($averageprices as $k => $v)
	                        @if($k < 4 && $k != 0)
	                                @foreach($v as $k1=> $v1)
	                                    <a href="/esfsale/area/{{get_url_by_id('','ao',$k1)}}">{{$v1}}</a>
	                                    @if(!($k == 3 && $k1 == 0) && !($k == 1 && $k1 == 2))
	                                    <span>|</span>
	                                    @endif
	                                @endforeach
	                        @endif
	                    @endforeach
	                    @endif
                    </dd>
                    <dd class="more"><a href="/esfsale/area">更多</a><i>》</i></dd>
                </dl>

                <div class="btns">
                    <a href="/houseHelp/sale/xq" class="fl">
                        <i class="sale"></i>
                        <span class="_mai">我要卖房</span>
                    </a>
                    @if(!Auth::check())
                    <a href="/userChoose.html" class="fr">
                        <i class="sale_entrust"></i>
                        <span class="mai_">我要求购</span>
                    </a>
                    @else
                        <a href="/wantSaleRent/esfsale" class="fr">
                            <i class="sale_entrust"></i>
                            <span class="mai_">我要求购</span>
                        </a>
                    @endif
                </div>
            </div>
            <ul class="house_list fr">
                @if(!empty($saleHouses))
                @foreach($saleHouses as $k=> $house)
                    @if(!empty($house->_source))
                <li>
                    <a href="/housedetail/ss{{$house->_source->id}}.html" class="pic_box">
                        <img  onerror="/{{$theme}}/image/house.jpg" src="{{!empty($house->_source->thumbPic)?get_img_url('commPhoto',$house->_source->thumbPic,2):'/'.$theme.'/image/house.jpg'}}" alt="{{!empty($house->_source->title)?$house->_source->title:''}}" width="212" height="134"/>
                       <span>{{$house->_source->name}}</span>
                    </a>
                    <p class="tit">
                    	<a href="/housedetail/ss{{$house->_source->id}}.html">
                        @if(!empty($cityareaArr[$house->_source->cityareaId]))
                        [{{$cityareaArr[$house->_source->cityareaId]}}]
                        @endif
                        @if(!empty($house->_source->title))
                        {{$house->_source->title}}
                            @endif
                        </a>
                    </p>
                    <p class="disc">
                        @if(!empty($house->_source->roomStr))
                        <span>
                            @if($house->_source->houseType1==3)
                            普通住宅
                            @elseif($house->_source->houseType1==1)
                                商铺
                            @elseif($house->_source->houseType1==2)
                                写字楼
                            @else
                                其他
                            @endif
                        </span>
                        @endif
                        <span>{{!empty($house->_source->area)?$house->_source->area.'平米':''}}</span>
                    </p>
                    <p class="price">
                        @if(!empty($house->_source->price2))
                            {{$house->_source->price2}}万
                        @else
                            面议
                        @endif
                    </p>
                </li>
                        @endif
                @endforeach
                @endif
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="/adShowModel.php?position=15&cityId={{CURRENT_CITYID}}"></script>
<!--    <ul class="banner">
        <li><a href=""><img src="/{{$theme}}/image/s-ban.jpg" alt="" /></a></li>
    </ul>-->
    <div class="house">
        <h2 class="clearfix">
        	<a href="/esfrent/area/ar1"><span>租房</span><i>》</i></a>
        </h2>
        <div class="house_cont clearfix">
            <div class="audit fl">
                <dl>
                	<dt>区域</dt>
                	<dd class="district">
                		@if(!empty($cityarea))
                        @foreach($cityarea as $k=> $v)
                            @if($k < 4)
                                {{--<div>--}}
                                @foreach($v as $k1 =>$v1)
                                <a href="/esfrent/area/aa{{$v1->id}}">{{$v1->name}}</a>
                                    @if(count($v)- 1 !=  $k1)
                                        <span>|</span>
                                    @endif
                                @endforeach
                                {{--</div>--}}
                            @endif
                        @endforeach
                    @endif
                	</dd>
                	<dd class="more"><a href="/esfrent/area">更多</a><i>》</i></dd>
                </dl>
                <dl>
                	<dt>户型/类型</dt>
                	<dd>
                		<a href="/esfrent/area/aq1">一室</a><span>|</span>
	                    <a href="/esfrent/area/aq2">二室</a><span>|</span>
	                    <a href="/esfrent/area/aq3">三室</a><span>|</span>
	                    <a href="/esfrent/area/aq4">四室</a>
	                    <a href="/esfrent/area">住宅</a><span>|</span>
	                    <a href="/sprent/area">商铺</a><span>|</span>
	                    <a href="/xzlrent/area">办公楼</a>
                	</dd>
                	<dd class="more"><a href="/esfrent/area">更多</a><i>》</i></dd>
                </dl>
                <dl>
                	<dt>价格</dt>
                	<dd class="price">
                		@if(!empty($averageprice2))
	                        @foreach($averageprice2 as $k => $v)
	                            @if($k < 4 && $k != 0)
	                            @foreach($v as $k1=> $v1)
	                                <a href="/esfrent/area/{{get_url_by_id('','ao',$k1)}}">{{$v1}}</a>
	                                    @if(count($v) - 1 !=  $k1)
	                                        <span>|</span>
	                                    @endif
	                            @endforeach
	                            @endif
	                        @endforeach
	                    @endif
                	</dd>
                	<dd class="more"><a href="/esfrent/area">更多</a><i>》</i></dd>
                </dl>
                <div class="btns">
                    <a href="/houseHelp/rent/xq" class="fl">
                        <i class="rent"></i>
                        <span class="_mai">我要租房</span>
                    </a>
                    @if(!Auth::check())
                        <a href="/userChoose.html" class="fr">
                            <i class="rent_entrust"></i>
                            <span class="mai_">我要求租</span>
                        </a>
                    @else
                        <a href="/wantSaleRent/esfrent" class="fr">
                            <i class="rent_entrust"></i>
                            <span class="mai_">我要求租</span>
                        </a>
                    @endif
                </div>
            </div>
            <ul class="house_list fr">
                @if(!empty($rentHouses))
                    @foreach($rentHouses as $k=> $house)
                        @if(!empty($house->_source))
                <li>
                    <a href="/housedetail/sr{{$house->_source->id}}.html" class="pic_box">
                        <img onerror="/{{$theme}}/image/house.jpg" src="{{!empty($house->_source->thumbPic)?get_img_url('commPhoto',$house->_source->thumbPic,2):'/'.$theme.'/image/house.jpg'}}" alt="{{!empty($house->_source->title)?$house->_source->title:''}}" width="214" height="140"/>
                        <span>{{(isset($house->_source->name))?$house->_source->name:''}}</span>
                    </a>
                    <p class="tit">
                    	<a href="/housedetail/sr{{$house->_source->id}}.html">
                        @if(!empty($cityareaArr[$house->_source->cityareaId]))
                            [{{$cityareaArr[$house->_source->cityareaId]}}]
                        @endif
                        @if(!empty($house->_source->title))
                            {{$house->_source->title}}
                        @endif
                        </a>
                    </p>
                    <p class="disc">
                        @if(!empty($house->_source->roomStr))
                            <span><!--{{substr($house->_source->roomStr,0,1)}}室{{substr($house->_source->roomStr,2,1)}}厅-->
                                @if($house->_source->houseType1==3)
                                    普通住宅
                                @elseif($house->_source->houseType1==1)
                                    商铺
                                @elseif($house->_source->houseType1==2)
                                    写字楼
                                @else
                                    其他
                                @endif
                            </span>
                        @endif
                        <span>
                            @if(!empty($house->_source->rentType))
                                {{$house->_source->rentType==1?'整租':($house->_source->rentType==2?'合租':($house->_source->rentType==3?'短租':($house->_source->rentType==4?'日租':'')))}}
                            @endif
                        </span>
                    </p>
                    <p class="price">
                        @if(!empty($house->price1))
                        {{floor($house->price1)}}元/月
                        @else
                        面议
                        @endif
                    </p>

                </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>

    </div>
<script type="text/javascript" src="/adShowModel.php?position=16&cityId={{CURRENT_CITYID}}"></script>
<!--    <ul class="banner">
        <li><a href=""><img src="/{{$theme}}/image/s-ban.jpg" alt="" /></a></li>
    </ul>-->
    <div class="money">
        <h2 class="clearfix"><a href="http://www.huilc.cn/"><span>理财</span><i>》</i></a></h2>
        <div class="sliderbox">
        	<i class="left"></i>
        	<i class="right"></i>
        	<div class="slider">
        	<ul class="buildings clearfix">
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/5181755de03b43339ceb6e3d1a953825" target="_blank">
                        <img src="image/financeOne.jpg"  onerror='this.src="/image/default.png"' alt="顺德陈村印象花城黄金宝-2期" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/5181755de03b43339ceb6e3d1a953825" title="顺德陈村印象花城黄金宝-2期" target="_blank">顺德陈村印象花城黄金宝-2期</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥20,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/c11a33354b8a48c88a1c3ab65c8c9642" target="_blank">
                        <img src="image/financeSix.jpg"  onerror='this.src="/image/default.png"' alt="新会碧桂园购房通" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/c11a33354b8a48c88a1c3ab65c8c9642" title="新会碧桂园购房通" target="_blank">新会碧桂园购房通</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥120,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/1667a212a55a40d3838c2b3f56a87b05" target="_blank">
                        <img src="image/financeTwo.jpg"  onerror='this.src="/image/default.png"' alt="茂名翡翠郡认筹宝-商铺" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/1667a212a55a40d3838c2b3f56a87b05" title="茂名翡翠郡认筹宝-商铺" target="_blank">茂名翡翠郡认筹宝-商铺</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥90,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/214646a3d3304565aa9ab1316b90222c" target="_blank">
                        <img src="image/financeThree.jpg"  onerror='this.src="/image/default.png"' alt="佛山三水华府汇盈宝-9" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/214646a3d3304565aa9ab1316b90222c" title="佛山三水华府汇盈宝-9" target="_blank">佛山三水华府汇盈宝-9</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥10,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/b19ca7417b3845048435297063b48552" target="_blank">
                        <img src="image/financeFour.jpg"  onerror='this.src="/image/default.png"' alt="临泉碧桂园-洋房" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/b19ca7417b3845048435297063b48552" title="临泉碧桂园-洋房" target="_blank">临泉碧桂园-洋房</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥10,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/05bfdfa1e3034e8788a839124ad47f4d" target="_blank">
                        <img src="image/financeFive.jpg"  onerror='this.src="/image/default.png"' alt="碧桂园十里江湾认筹宝" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/05bfdfa1e3034e8788a839124ad47f4d" title="碧桂园十里江湾认筹宝" target="_blank">碧桂园十里江湾认筹宝</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥10,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/fbe2fa164091483f9493302e31a18ae6" target="_blank">
                        <img src="image/financeFour2.jpg"  onerror='this.src="/image/default.png"' alt="碧桂园城市花园" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/fbe2fa164091483f9493302e31a18ae6" title="碧桂园城市花园" target="_blank">碧桂园城市花园</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥20,000.00元</dd>
                    </dl>
                </li>
                <li>
                    <a href="http://fang.hlej.com/?chanel=soufang#product/2/aea196d3a588457894ecb78b964f4572" target="_blank">
                        <img src="image/financeSix.png"  onerror='this.src="/image/default.png"' alt="邢台碧桂园洋房" width="271" height="170"/>
                    </a>
                    <dl>
                        <dt>
                            <a href="http://fang.hlej.com/?chanel=soufang#product/2/aea196d3a588457894ecb78b964f4572" title="邢台碧桂园洋房" target="_blank">邢台碧桂园洋房</a>
                        </dt>
                        <dd>
                            <span>5%收益</span>
                        </dd>
                        <dd>小投资金额：￥10,000.00元</dd>
                    </dl>
                </li>
        </ul>
        </div>
        </div>
    </div>
</div>

{{--主页尾部 开始--}}
<div class="footer">
    <div class="foot_nav">
        <div class="submenu">
            <div class="nav_buy">
                <h2><a href="/esfsale/area" title="搜房网买房">买房</a></h2>
                @if(in_array(CURRENT_CITYPY, config('openCity')))
                    <ul>
                        <li><a href="/new/area">新房</a></li>
                        <li><a href="/esfsale/area">二手房</a></li>
                        <li><a href="/checkpricelist/sale">查房价</a></li>
                        <li><a href="/saleesb/area">找小区</a></li>
                        <!--<li><a href="/esfsale/area?from=isSoloAgent">独家代理</a></li>-->
                        <!--<li><a href="/new/area">学区房</a></li>-->
                    </ul>
                @else
                    <ul>
                        <li><a href="/esfsale/area" title="搜房网二手房房">二手房</a></li>
                        <li><a href="/bssale/area">豪宅别墅</a></li>
                        <li><a href="/checkpricelist/sale">查房价</a></li>
                        <li><a href="/saleesb/area">找小区</a></li>
                        <!--<li><a href="/esfsale/area?from=isSoloAgent">独家代理</a></li>-->
                        <!--<li><a href="/new/area">学区房</a></li>-->
                    </ul>
                @endif
            </div>
            <div class="nav_buy">
                <h2><a href="/esfrent/area" title="搜房网租房">租房</a></h2>
                <ul>
                    <!--<li><a href="/esfrent/area?from=agentFee">免中介</a></li>-->
                    <li><a href="/esfrent/area/ar1">整租</a></li>
                    <li><a href="/esfrent/area/ar2">合租</a></li>
                    <li><a href="/bsrent/area">豪宅别墅</a></li>
                    {{--<li><a href="/checkpricelist/rent">租价查询</a></li>--}}
                </ul>
            </div>
            <div class="nav_buy">
                <h2><a href="/xzlrent/area" title="搜房网商业">商业</a></h2>
                <ul>
                    <li><a href="/xzlrent/area">写字楼出租</a></li>
                    <li><a href="/sprent/area">商铺出租</a></li>
                    <!--<li><a href="/xzlrent/area?from=isSoloAgent">独家代理</a></li>-->
                    <li><a href="/spsale/area">商铺出售</a></li>
                    <li><a href="/xzlsale/area">写字楼出售</a></li>
                </ul>
            </div>
            <div class="nav_buy">
                <h2><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=4" target="_blank" title="搜房网理财推荐">理财</a></h2>
                <ul>
                    <li><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=4" target="_blank">我要理财</a></li>
                    <li><a href="https://www.huilc.cn/front/borrow/noviceBorrow?channel=soFang&usrChannel=15&usrWay=1" target="_blank">新人壕礼</a></li>
                    <li><a href="http://fang.hlej.com/?chanel=soufang" target="_blank">我要贷款</a></li>
                </ul>
            </div>
            <div class="nav_buy">
                <h2><a href="{{config('hostConfig.baike_host')}}/index.php?list-property" target="_blank" title="搜房网百科">百科</a></h2>
                <ul>
                    <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-property" target="_blank">楼盘词典</a></li>
                    <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-words" target="_blank">行业名词</a></li>
                    <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-mingqi" target="_blank">业界名企</a></li>
                    <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-mingren" target="_blank">业界名人</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
{{--主页尾部 结束--}}
<script>
//顶部广告
	var topAdv=$('.banner_move');
	topAdv.slideDown(1000);	
	setTimeout(function(){
		topAdv.slideUp(1500);
	},3000);
	
	//小广告bannner
	
	$('.banner').each(function(){
		tabs($(this).find('li'));
	});
	function tabs(obj){
		var n=0;
		if(obj.length>1){
			setInterval(function(){
				n++;			
				if(n>obj.length-1){
					n=0;
				}
				obj.hide();
				obj.eq(n).css('display','block');		
			},3000);
		}
	}
	//理财
	var slider=$('.slider .buildings');
	var leftBtn=$('.sliderbox .left');
	var rightBtn=$('.sliderbox .right');
	var blockWidth=$('.slider').width();
	var oW=slider.children().eq(0).outerWidth(true);
	var allWidth=slider.children().length*oW;
	if(slider.children().length<=4){
		leftBtn.hide();
		rightBtn.hide();
	}else{
		slider.width(allWidth);
	}
	var count=(allWidth-blockWidth)/oW;
	var n=0;
	rightBtn.on('click',function(){	
		if(n>=count){	
			return;
			n=0;
		}
		n++;
		slider.animate({left:-n*oW+'px'});
		if(n==count){
			$(this).addClass('right2');
			leftBtn.addClass('left2');
		}
	});
	leftBtn.on('click',function(){
		if(n<=0){	
			return;
			n=count;
		}
		n--;
		slider.animate({left:-n*oW+'px'});		
		if(n==0){
			$(this).removeClass('left2');
			rightBtn.removeClass('right2');
		}
	});	
	//两侧广告关闭
	$('.s_ban .closebtn').on('click',function(){
		$(this).parent().hide();
	});
	//搜索下拉消失
	$(document).on('click',function(e){
		if(e.target.className!='txt searchInput'){
			$('.txt_cont ul').hide();
		}
	});
</script>
@endsection