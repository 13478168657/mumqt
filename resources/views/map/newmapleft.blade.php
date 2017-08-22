<div class="area_l">
	@include('layout.map.newsearchbar')
	<div class="flexbtn"><</div>
    <div class="bot_cont">
	<ul class="left_bar clearfix">
		<li class="active"><i class="region"></i><span>区域</span><b></b><em></em></li>
		<li><i class="sub"></i><span>地铁</span><b></b><em></em></li>
	</ul>
	<ul class="right_cont">
	<li class="active">
    <div class="data">
        <dl class="qu">
            <dt></dt>
            <dd>
                <p id="quname"></p>
                <p id="qucount"></p>
            </dd>
        </dl>
        <!--<dl class="jun">
            <dt>均价<span id="avgprice"></span>&nbsp;
                <a id="priceunit">
                    @if($type == 'sale')
                        元/平米
                    @else
                        @if($housetype1 == 3)
                            元/月
                        @else
                            元/天/平米
                        @endif
                    @endif
                </a></dt>
            <dd>同比：<i id="increaseupordown" class="click"></i><a id="increase"></a>%</dd>
        </dl>-->
    </div>
    <!--<div class="list">
        <p class="nav_l"><span class="click">全部城区</span></p>
        <ul class="nav_r">
            <li class="dotted"></li>
            <li><a>楼盘个数</a><i class="click"></i></li>
        </ul>
    </div>-->
    <div class="house_list" id="house">
        <div class="home_list" style="display: none">
        </div>
        <div class="city_list">
            <ul id="city_list_ul">
            </ul>
        </div>
    </div>
    <div class="open">
        <i class=""></i>
    </div>
     </li>
    <li>
    	<div class="choose clearfix">
    		<p class="fl">请选择地铁线路</p>
    		<p class="fr">全市共<span class="nums">{{count($subways)}}</span>条线路</p>
    	</div>
    	<ol class="subway_list" id="house2">
            <?php $index=0;?>
            @foreach($subways as $key=>$subway)
                <?php $subline = explode('-',$key);?>
    		<li class="clearfix">
    			<span class="fl num" id="line_{{$subline[1]}}" onclick="subwayLine({{$subline[1]}});" index="{{$index}}">{{$subline[0]}}</span>
    			<span class="fr count">{{$subline[2]}}个&nbsp;&nbsp;<i class="lt">></i></span>
    		</li>
                <?php $index++ ;?>
    		@endforeach
    	</ol>
        @foreach($subways as $key=>$subway)
            <?php $stationArr = array_chunk($subway,17);?>
    	<div class="station_list">
            @foreach($stationArr as $stations)
    		<ul>
                @foreach($stations as $station)
    			<li stationId="{{$station->id}}" lng="{{$station->longitude}}" lat="{{$station->latitude}}" line="{{$key}}">{{$station->name}}</li>
                @endforeach
    		</ul>
            @endforeach

    	</div>
        @endforeach
    </li>
    </ul>
   </div>
</div>