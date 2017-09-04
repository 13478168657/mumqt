@extends('mainlayout')
@section('title')
    <title>个人@if(strpos($type,'sale'))求购@else求租@endif-住宅</title>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/common.css">
    <link rel="stylesheet" type="text/css" href="/css/color.css">
    <link rel="stylesheet" type="text/css" href="/css/personalHouse.css">
    <link rel="stylesheet" type="text/css" href="/css/brokerComment.css">
@endsection
@section('content')
    <?php
            if($type == 'esfsale' || $type == 'esfrent'){
                $bjys = 'house';
            }elseif($type == 'xzlsale' || $type == 'xzlrent'){
                $bjys = 'office';
            }else{
                $bjys = 'shop';
            }
            ?>
    <div class="enter_house {{$bjys}}">
        <div class="house_info">
            <h2>免费发布{{!empty(strpos($type,'sale'))?'求购':'求租'}}信息</h2>
            <p class="submenu">
                @if(strpos($type,'sale'))
                    @if($type == 'esfsale')
                        <span class="click">住宅</span>
                    @else
                        <a href="/wantSaleRent/esfsale" >住宅</a>
                    @endif
                    @if($type == 'xzlsale')
                        <span class="click">写字楼</span>
                    @else
                        <a href="/wantSaleRent/xzlsale" >写字楼</a>
                    @endif
                    @if($type == 'spsale')
                        <span class="click">商铺</span>
                    @else
                        <a href="/wantSaleRent/spsale" >商铺</a>
                    @endif
                @else
                    @if($type == 'esfrent')
                        <span class="click">住宅</span>
                    @else
                        <a href="/wantSaleRent/esfrent" >住宅</a>
                    @endif
                    @if($type == 'xzlrent')
                        <span class="click">写字楼</span>
                    @else
                        <a href="/wantSaleRent/xzlrent" >写字楼</a>
                    @endif
                    @if($type == 'sprent')
                        <span class="click">商铺</span>
                    @else
                        <a href="/wantSaleRent/sprent" >商铺</a>
                    @endif
                @endif

            </p>
            <form id="salerent">
            <div class="house_type">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                @if(!empty($whouse->id))
                    <input type="hidden" name="id" value="{{$whouse->id}}">
                @endif
                <input type="hidden" name="searchType" value="{{!empty($whouse->searchType)?$whouse->searchType:1}}">
                <input type="hidden" name="provinceId" value="{{!empty($whouse->provinceId)?$whouse->provinceId:''}}">
                <input type="hidden" name="cityId" value="{{!empty($whouse->cityId)?$whouse->cityId:''}}">
                <input type="hidden" name="cityAreaId" value="{{!empty($whouse->cityAreaId)?$whouse->cityAreaId:''}}">
                <input type="hidden" name="businessAreaId" value="{{!empty($whouse->businessAreaId)?$whouse->businessAreaId:''}}">
                <input type="hidden" name="subwayLineId" value="{{!empty($whouse->subwayLineId)?$whouse->subwayLineId:''}}">
                <input type="hidden" name="subwayId" value="{{!empty($whouse->subwayId)?$whouse->subwayId:''}}">
                <input type="hidden" name="communityId" value="{{!empty($whouse->communityId)?$whouse->communityId:''}}">
                <input type="hidden" name="houseType1" value="{{$tp1}}">
                <input type="hidden" name="houseType2" value="{{!empty($whouse->houseType2)?$whouse->houseType2:''}}">
                <input type="hidden" name="checkInTime" value="{{!empty($whouse->checkInTime)?$whouse->checkInTime:''}}">
                @if($tp1 != 3)
                    <input type="hidden" name="fitment" value="{{!empty($whouse->fitment)?$whouse->fitment:''}}">
                @endif
                @if($type == 'esfrent')
                    <input type="hidden" name="equipment" value="{{!empty($whouse->equipment)?$whouse->equipment:''}}">
                @endif
                @if($tp1 == 1)
                    <input type="hidden" name="trade" value="{{!empty($whouse->trade)?$whouse->trade:''}}">
                @endif
                <ul>
                    <li class="no_clear">
                        <label><span>*</span>城市：</label>
                        <div class="sort_icon">
                            <a class="term_title"><span>
                                    @if(!empty($whouse->provinceId) && !empty(App\Http\Controllers\Utils\RedisCacheUtil::getProvinceNameById($whouse->provinceId)))
                                        {{App\Http\Controllers\Utils\RedisCacheUtil::getProvinceNameById($whouse->provinceId)}}
                                    @else
                                        请选择省
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag">
                                <p class="top_icon"></p>
                                <ul>
                                    @if(!empty($provinces))
                                        @foreach($provinces as $province)
                                            <li class="choosePro" value="{{$province->id}}">{{$province->name}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="sort_icon">
                            <a class="term_title"><span id="cityText">
                                    @if(!empty($whouse->cityId) && !empty(App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($whouse->cityId)))
                                        {{App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($whouse->cityId)}}
                                    @else
                                        请选择市
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag">
                                <p class="top_icon"></p>
                                <ul id="cityList">
                                    @if(!empty($citys))
                                        @foreach($citys as $city)
                                            <li class="chooseCity" value="{{$city->id}}">{{$city->name}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <span class="prcity qerr"></span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label><span>*</span>目标区域：</label>
                      <span id="type">
                        <a class="chose {{!empty($whouse->searchType)?(($whouse->searchType == 1)?'click':''):'click'}}">区域</a>
                        <a class="chose x_sub {{!empty($whouse->searchType)&&($whouse->searchType == 2)?'click':''}}">地铁</a>
                        <a class="chose {{(!empty($whouse->searchType)&&$whouse->searchType == 3)?'click':''}}">楼盘</a>
                      </span>
                    </li>
                    <li id="qy" class="no_clear" style="{{!empty($whouse->searchType)?(($whouse->searchType == 1)?'':'display:none'):''}};">
                        <label>&nbsp;</label>
                        <div class="sort_icon">
                            <a class="term_title"><span id="areaText">
                                    @if(!empty($whouse->cityAreaId) && !empty(App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($whouse->cityAreaId)))
                                        {{App\Http\Controllers\Utils\RedisCacheUtil::getCityAreaNameById($whouse->cityAreaId)}}
                                    @else
                                        请选择区域
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag">
                                <p class="top_icon"></p>
                                <ul id="areaList">
                                    @if(!empty($cityAreas))
                                        @foreach($cityAreas as $cv)
                                            <li class="chooseArea" value="{{$cv->id}}">{{$cv->name}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="sort_icon margin_left">
                            <a class="term_title"><span id="busText">
                                    @if(!empty($whouse->businessAreaId) && !empty(App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($whouse->businessAreaId)))
                                        {{App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($whouse->businessAreaId)}}
                                    @else
                                        请选择商圈
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag">
                                <p class="top_icon"></p>
                                <ul id="busareaList">
                                    @if(!empty($cityBussinAreas))
                                        @foreach($cityBussinAreas as $cbv)
                                            @foreach($cbv as $bv)
                                                <li class="chooseBusArea" value="{{$bv['id']}}">{{$bv['name']}}</li>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <span class="abus qerr"></span>
                        <div class="clear"></div>
                    </li>
                    <li id="dt" style="{{!empty($whouse->searchType)&&($whouse->searchType == 2)?'':'display:none'}};" class="no_clear">
                        <label>&nbsp;</label>
                        <div class="sort_icon">
                            <a class="term_title"><span id="subwayText">
                                    @if(!empty($whouse->subwayLineId) && !empty($subways))
                                        @foreach($subways as $sv)
                                            @if($sv->id == $whouse->subwayLineId)
                                                {{$sv->name}}
                                                <?php  break;?>
                                            @endif
                                        @endforeach
                                    @else
                                        请选择地铁线路
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag width4">
                                <p class="top_icon"></p>
                                <ul id="subway">
                                    @if(!empty($subways))
                                        @foreach($subways as $sv)
                                            <li class="subwaylist" value="{{$sv->id}}">{{$sv->name}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="sort_icon margin_left">
                            <a class="term_title"><span  id="subwaystationText">
                                   @if(!empty($whouse->subwayLineId) && !empty($citySubWayStation))
                                        @foreach($citySubWayStation as $csv)
                                            @if($csv->id == $whouse->subwayId)
                                                {{$csv->name}}
                                                <?php  break;?>
                                            @endif
                                        @endforeach
                                    @else
                                        请选择地铁站点
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag width4">
                                <p class="top_icon"></p>
                                <ul id="subwaystation">
                                    @if(!empty($citySubWayStation))
                                        @foreach($citySubWayStation as $csv)
                                            <li class="chooseSubWayStation" value="{{$csv->id}}">{{$csv->name}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <span class="sws qerr"></span>
                        <div class="clear"></div>
                    </li>
                    <li id="xq" style="{{!empty($whouse->searchType)&&($whouse->searchType == 3)?'':'display:none'}}" class="no_clear">
                        <label>&nbsp;</label>
                        <div class="chose_build">
                            <input type="text" class="txt" placeholder="请输入楼盘名称" id="keyword" value="{{$comName or ''}}">
                            <dl id="buildSearch" style="display: none">
                            </dl>
                        </div>
                        <span class="cbuild qerr"></span>
                        <div class="clear"></div>
                    </li>
                    <li class="no_clear">
                        <label><span>*</span>物业类型：</label>
                        <div class="sort_icon dw">
                            <a class="term_title"><span>
                                @if(!empty($housetypes)&&!empty($whouse->houseType2))
                                    @if(!empty($housetypes[$whouse->houseType2])){{$housetypes[$whouse->houseType2]}}@else请选择@endif
                                @else
                                    请选择
                                @endif
                                </span><i></i></a>
                            <div class="list_tag">
                                <p class="top_icon"></p>
                                <ul class="xiala">
                                    @if(!empty($housetypes))
                                        @foreach($housetypes as $k=>$housetype)
                                            <?php if($k == 0) continue;?>
                                            <li zd="houseType2" value="{{$k}}">{{$housetype}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <span class="htype2 qerr"></span>
                        <div class="clear"></div>
                    </li>
                    @if($tp1 == 3)
                        <li>
                            <label><span>*</span>期望户型：</label>
                            <input type="radio" class="radio" value="1" name="houseRoom" {{!empty($whouse->houseRoom)&&($whouse->houseRoom == 1)?'checked':''}}>
                            <span class="room">一居</span>
                            <input type="radio"  class="radio" value="2" name="houseRoom" {{!empty($whouse->houseRoom)&&($whouse->houseRoom == 2)?'checked':''}}>
                            <span class="room">二居</span>
                            <input type="radio"  class="radio" value="3" name="houseRoom" {{!empty($whouse->houseRoom)&&($whouse->houseRoom == 3)?'checked':''}}>
                            <span class="room">三居</span>
                            <input type="radio"  class="radio" value="4" name="houseRoom" {{!empty($whouse->houseRoom)&&($whouse->houseRoom == 4)?'checked':''}}>
                            <span class="room">四居</span>
                            <input type="radio"  class="radio" value="5" name="houseRoom" {{!empty($whouse->houseRoom)&&($whouse->houseRoom == 5)?'checked':''}}>
                            <span class="room">五居</span>
                            <input type="radio"  class="radio" value="6" name="houseRoom" {{!empty($whouse->houseRoom)&&($whouse->houseRoom == 6)?'checked':''}}>
                            <span class="room">五居以上</span>
                            <span class="hroom qerr"></span>
                        </li>
                    @endif
                    @if($sr == 's')
                        <li>
                            <label><span>*</span>期望售价：</label>
                            <input type="text" class="xprice txt width1 margin_l" name="priceMin" value="{{isset($whouse->priceMin)?$whouse->priceMin:''}}">
                            <span class="zhi">至</span>
                            <input type="text" class="xprice txt width1" name="priceMax" value="{{isset($whouse->priceMax)?$whouse->priceMax:''}}">
                            <span class="zhi">万元</span>
                            <span class="priceMinMax qerr"></span>
                        </li>
                    @else
                        <li>
                            <label><span>*</span>期望租价：</label>
                            <input type="text" class="xprice txt width1 margin_l" name="priceMin" value="{{isset($whouse->priceMin)?$whouse->priceMin:''}}">
                            <span class="zhi">至</span>
                            <input type="text" class="xprice txt width1" name="priceMax" value="{{isset($whouse->priceMax)?$whouse->priceMax:''}}">
                            <span class="zhi">@if($tp1 == 3) 元/月 @else 元/平米▪天 @endif</span>
                            <span class="priceMinMax qerr"></span>
                        </li>
                    @endif

                    <li>
                        <label><span>*</span>期望面积：</label>
                        <input type="text" class="xArea txt width1 margin_l" name="areaMin"  value="{{isset($whouse->areaMin)?$whouse->areaMin:''}}">
                        <span class="zhi">至</span>
                        <input type="text" class="xArea txt width1" name="areaMax"  value="{{isset($whouse->areaMax)?$whouse->areaMax:''}}">
                        <span class="zhi">平米</span>
                        <span class="areaMinMax qerr"></span>
                    </li>
                    @if($tp1 == '2')
                    <li>
                        <label><span>*</span>期望楼层：</label>
                        <input type="text" class="txt width1 margin_l" name="currentFloor" value="{{isset($whouse->currentFloor)?$whouse->currentFloor:''}}"><span class="zhi">层</span>
                        <span class="cfloor qerr"></span>
                    </li>
                    @endif
                    @if($tp1 != '3')
                        <li>
                            <label><span>*</span>装修状况：</label>
                            <input type="radio" class="radio" value="0" name="fitment" {{isset($whouse->fitment)?(($whouse->fitment == 0)?'checked':''):'checked'}}>
                            <span class="room">不限</span>
                            <input type="radio" class="radio" value="1" name="fitment" {{isset($whouse->fitment)&&($whouse->fitment == 1)?'checked':''}}>
                            <span class="room">毛坯</span>
                            <input type="radio" class="radio" value="2" name="fitment" {{isset($whouse->fitment)&&($whouse->fitment == 2)?'checked':''}}>
                            <span class="room">简装</span>
                            <input type="radio" class="radio" value="3" name="fitment" {{isset($whouse->fitment)&&($whouse->fitment == 3)?'checked':''}}>
                            <span class="room">中装</span>
                            <input type="radio" class="radio" value="4" name="fitment" {{isset($whouse->fitment)&&($whouse->fitment == 4)?'checked':''}}>
                            <span class="room">精装</span>
                            <input type="radio" class="radio" value="5" name="fitment" {{isset($whouse->fitment)&&($whouse->fitment == 5)?'checked':''}}>
                            <span class="room">豪华装修</span>
                        </li>
                    @endif

                    @if($type == 'esfrent')
                        <li>
                            <label><span>*</span>租赁方式：</label>
                            <input type="radio" class="radio" value="0" name="rentType" {{isset($whouse->rentType)?(($whouse->rentType == 0)?'checked':''):'checked'}}>
                            <span class="room">不限</span>
                            <input type="radio"  class="radio" value="1" name="rentType" {{isset($whouse->rentType)&&($whouse->rentType == 1)?'checked':''}}>
                            <span class="room">整租</span>
                            <input type="radio"  class="radio" value="2" name="rentType" {{isset($whouse->rentType)&&($whouse->rentType == 2)?'checked':''}}>
                            <span class="room">合租</span>
                        </li>
                        <li>
                            <label><span>*</span>配套设施：</label>
                            <div class="sheshi">
                                <?php
                                    if(!empty($whouse->equipment)){
                                        $equipment = explode('|',$whouse->equipment);
                                    }
                                ?>
                                <span>
                                  <input type="checkbox" onclick="cli('fitm');" id="all" class="radio">
                                  <span class="room">全选</span>
                                </span>
                                @if(!empty($fitments))
                                    @foreach($fitments as $k=>$fitment)
                                        <span>
                                            @if(!empty($equipment)&&in_array($k,$equipment))
                                                <input type="checkbox" class="fitm radio" value="{{$k}}" checked>
                                            @else
                                                <input type="checkbox" class="fitm radio" value="{{$k}}">
                                            @endif
                                          <span class="room">{{$fitment}}</span>
                                        </span>
                                    @endforeach
                                        <span class="xfitm qerr"></span>
                                @endif
                            </div>
                        </li>
                    @endif
                    @if($tp1==1)
                        <li>
                            <?php
                            if(!empty($whouse->trade)){
                                $wtrade = explode('|',$whouse->trade);
                            }
                            ?>
                            <label><span>*</span>期望行业：</label>
                            <div class="sheshi">
                                @if(!empty($trades))
                                    @foreach($trades as $k=>$trade)
                                        <?php if($k == 0) continue;?>
                                        <span>
                                            @if(!empty($wtrade)&&in_array($k,$wtrade))
                                                <input type="checkbox" class="trad radio" value="{{$k}}" checked>
                                            @else
                                                <input type="checkbox" class="trad radio" value="{{$k}}">
                                            @endif
                                          <span class="room">{{$trade}}</span>
                                        </span>
                                    @endforeach
                                @endif
                                    <span class="xtra qerr"></span>
                            </div>
                        </li>
                    @endif
                    <li class="no_clear">
                        <label><span>*</span>入住时间：</label>
                        <div class="sort_icon dw">
                            <a class="term_title"><span>
                                    @if(!empty($checkInTime)&&!empty($whouse->checkInTime))
                                        @if(!empty($checkInTime[$whouse->checkInTime])){{$checkInTime[$whouse->checkInTime]}}@else请选择@endif
                                    @else
                                        请选择
                                    @endif
                                </span><i></i></a>
                            <div class="list_tag">
                                <p class="top_icon"></p>
                                <ul class="xiala">
                                    @if(!empty($checkInTime))
                                        @foreach($checkInTime as $k=>$checkIn)
                                            <li zd="checkInTime" value="{{$k}}">{{$checkIn}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <span class="intime qerr"></span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <label><span>*</span>需求描述：</label>
                        <div class="need">
                            <textarea class="txtarea" name="describe">@if(!empty($whouse->describe)){{$whouse->describe}}@endif</textarea>
                            <p>
                                <span>详细的自身情况描述、找房要求，能让您快速地找到满意的房子…（至少5个字符）</span>
                                <span>如果输入内容出现新广告法中禁止的违规词，系统将自动隐藏。 </span>
                            </p>
                        </div>
                        <span class="describe qerr" style="margin-left: 115px;"></span>
                    </li>
                    <li>
                        <label><span>*</span>姓名：</label>
                        <input type="text" name="linkman" class="txt margin_l" value="{{!empty($whouse->linkman)?$whouse->linkman:''}}">
                        <span class="linkman qerr"></span>
                    </li>

                    @if(!Auth::check())
                        <li>
                            <label><span>*</span>联系电话：</label>
                            <input type="text" name="linkmobile" class="txt margin_l js-tel" value="">
                            <span class="linkmobile qerr"></span>
                        </li>
                        <li style="display: none;">
                            <label>&nbsp;</label>
                            <input type="text" class="txt width2 margin_l" id="img_code_val" value="" autocomplete="off">
                            <img src="/vercode" alt="验证码" id="img_code" onclick="this.src='/vercode?code='+Math.random();" style="width:95px;height:30px;float:left;margin-left:15px;border-radius:3px;">
                            <span class="qerr"></span>
                        </li>
                        <li>
                            <label><span>*</span>手机验证码：</label>
                            <input type="text" name="code" class="txt width2 margin_l">
                            <input type="button" class="btn btn_blue" value="获取验证码" id="getcode">
                        </li>
                    @endif
                    <li><input type="button" class="btn submit" value="提交"></li>
                </ul>
            </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/js/housecompare.js"></script>
<script>
    $(document).ready(function(e) {
        $("#type a").click(function(){
            $(this).addClass("click").siblings("#type a").removeClass("click");
            if($(this).text()=="区域"){
                $("#qy").show();
                $("#dt").hide();
                $("#xq").hide();
                $('#subwayText').text('请选择地铁线路');
                $('#subwaystationText').text('请选择地铁站点');
                $('#keyword').val('');
                $('input[name=subwayLineId]').val('');
                $('input[name=subwayId]').val('');
                $('input[name=communityId]').val('');
                $('input[name=searchType]').val(1);
                $('.sws').html('');
                $('.cbuild').html('');
            }else if($(this).text()=="地铁"){
                $("#qy").hide();
                $("#dt").show();
                $("#xq").hide();
                $('#areaText').text('请选择区');
                $('#busText').text('请选择商圈');
                $('#keyword').val('');
                $('input[name=cityAreaId]').val('');
                $('input[name=businessAreaId]').val('');
                $('input[name=communityId]').val('');
                $('input[name=searchType]').val(2);
                $('.abus').html('');
                $('.cbuild').html('');
            }else if($(this).text()=="楼盘"){
                $("#qy").hide();
                $("#dt").hide();
                $("#xq").show();
                $('#areaText').text('请选择区');
                $('#busText').text('请选择商圈');
                $('#subwayText').text('请选择地铁线路');
                $('#subwaystationText').text('请选择地铁站点');
                $('input[name=cityAreaId]').val('');
                $('input[name=businessAreaId]').val('');
                $('input[name=subwayLineId]').val('');
                $('input[name=subwayId]').val('');
                $('input[name=searchType]').val(3);
                $('.sws').html('');
                $('.abus').html('');
            }
        });

        /* 下拉 */
        $(".house_type .sort_icon").click(function (event) {
            $(".list_tag").hide();
            $(this).find(".list_tag").fadeIn();
            $(document).one("click", function () {//对document绑定一个影藏Div方法
                $(".list_tag").hide();
            });
            event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
        });
        $(".list_tag").click(function (event) {
            event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
        });

        $(".list_tag li").click(function(){
                $(this).parents(".sort_icon").find(".term_title span").text($(this).text());
                $(this).parents(".list_tag").hide();
            });
    });
    function cli(Obj){
        var collid = document.getElementById("all")
        var coll = document.getElementsByClassName(Obj)
        if (collid.checked){
            for(var i = 0; i < coll.length; i++)
                coll[i].checked = true;
        }else{
            for(var i = 0; i < coll.length; i++)
                coll[i].checked = false;
        }
    }

$(function(){
    function check_feild(){
        var res = true;
        if($('input[name=provinceId]').val() == '' || $('input[name=cityId]').val() == ''){
            $('.prcity').html('请选择省份或者城市');
            res = false;
        }
        if($('input[name=searchType]').val() == 1){
            if($('input[name=cityAreaId]').val() == '' || $('input[name=businessAreaId]').val() == ''){
                $('.abus').html('请选择区域或者商圈');
                res = false;
            }
        }else if($('input[name=searchType]').val() == 2){
            if($('input[name=subwayLineId]').val() == '' || $('input[name=subwayId]').val() == ''){
                $('.sws').html('请选择地铁站或者地铁站点');
                res = false;
            }
        }else{
            if($('input[name=communityId]').val() == ''){
                $('.cbuild').html('请选择楼盘');
                res = false;
            }
        }
        if($('input[name=houseType2]').val() == ''){
            $('.htype2').html('请选择物业类型');
            res = false;
        }
        if(("{{$tp1}}" == 3) && $('input[name=houseRoom]:checked').val() == undefined){
            $('.hroom').html('请选择期望户型');
            res = false;
        }
        var pattern = /^([1-9]\d*)(\.\d{1,2})?$/;
        var pattern1 = /^([1-9]\d*)(\.\d{1,2})?$/;
        if(!pattern.test($('input[name=priceMin]').val()) || !pattern1.test($('input[name=priceMax]').val()) || (eval($('input[name=priceMin]').val()) > eval($('input[name=priceMax]').val()))){
            $('.priceMinMax').html('请正确填写价格');
            res = false;
        }
        if(!pattern.test($('input[name=areaMin]').val()) || !pattern1.test($('input[name=areaMax]').val()) || (eval($('input[name=areaMin]').val()) > eval($('input[name=areaMax]').val()))){
            $('.areaMinMax').html('请正确填写面积');
            res = false;
        }
        if(("{{$tp1}}" == 2) && ($('input[name=currentFloor]').val() == '' || !/^[-1-9]+\d*$/.test($('input[name=currentFloor]').val()))){
            $('.cfloor').html('请正确填写期望楼层');
            res = false;
        }
        if($('input[name=checkInTime]').val() == ''){
            $('.intime').html('请选择入住时间');
            res = false;
        }
        if($('input[name=trade]').val() == ''){
            $('.xtra').html('请选择期望行业');
            res = false;
        }
        if($('input[name=equipment]').val() == ''){
            $('.xfitm').html('请选择配套设施');
            res = false;
        }
        if($('textarea[name=describe]').val().length < 5){
            $('.describe').html('需求描述至少填写5个字符');
            res = false;
        }
        if($('input[name=linkman]').val().length <= 1 || !/^[\u4e00-\u9fa5]|[a-z]$/.test($('input[name=linkman]').val())){
            $('.linkman').html('请填写姓名');
            res = false;
        }
        if(!"{{Auth::check()}}"){
            if( !$('input[name=linkmobile]').val() || !/^1[3|5|7|8]\d{9}$/.test($('input[name=linkmobile]').val())){
                $('.linkmobile').html('请填写手机号');
                //alert(111);
                res = false;
            }
        }
        return res;
    }
    //提交
    $('.submit').click(function(){
        console.log($('#salerent').serialize());
        if(!check_feild()){
            return false;
        }
//        return false;
        var url = '/wantSaleRentSub/'+"{{$type}}";
        if("{{$sr}}" == 's'){
            var tiao = '/userEntrust/Qs';
        }else{
            var tiao = '/userEntrust/Qz';
        }
        $.ajax({
            type : 'POST',
            url : url,
            data : $('#salerent').serialize(),
            dataType : 'json',
            success : function(msg){
                if(msg.res == 'success'){
                    xalert({
                        title:'提示',
                        content:msg.data,
                        time:1,
                        url:tiao
                    });
                }else{
                    xalert({
                        title:'提示',
                        content:msg.data,
                        state:2,
                        time:1,
                    });
                }
            }
        });
    });
    //验证
    $('.xprice').blur(function(){
        var pattern = /^([1-9]\d*)(\.\d{1,2})?$/;
        var pattern1 = /^([1-9]\d*)(\.\d{1,2})?$/;
        if(pattern.test($('input[name=priceMin]').val()) && pattern1.test($('input[name=priceMax]').val()) && (eval($('input[name=priceMin]').val()) <= eval($('input[name=priceMax]').val()))){
            $('.priceMinMax').html('');
        }else{
            $('.priceMinMax').html('请正确填写价格');
        }
    });
    $('.xArea').blur(function(){
        var pattern = /^([1-9]\d*)(\.\d{1,2})?$/;
        var pattern1 = /^([1-9]\d*)(\.\d{1,2})?$/;
        if(pattern.test($('input[name=areaMin]').val()) && pattern1.test($('input[name=areaMax]').val())&&(eval($('input[name=areaMin]').val()) <= eval($('input[name=areaMax]').val()))){
            $('.areaMinMax').html('');
        }else{
            $('.areaMinMax').html('请正确填写面积');
        }
    });
    $('textarea[name=describe]').blur(function(){
        if($(this).val().length < 5){
            $('.describe').html('需求描述至少填写5个字符');
        }else{
            $('.describe').html('');
        }
    });

    $('input[name=linkman]').blur(function(){
        if($(this).val().length <= 1){
            $('.linkman').html('请填写姓名');
        }else{
            $('.linkman').html('');
        }
    });
    $('input[name=linkmobile]').blur(function(){
        if(!$(this).val() || !/^1[3|5|7|8]\d{9}$/.test($(this).val())){
            $('.linkmobile').html('请填写手机号');
        }else{
            $('.linkmobile').html('');
        }
    });
    if("{{$tp1}}" == 2){
        $('input[name=currentFloor]').blur(function(){
            if(/^[-1-9]+\d*$/.test($(this).val())){
                $('.cfloor').html('');
            }else{
                $('.cfloor').html('请正确填写期望楼层');
            }
        });
    }else if("{{$tp1}}" == 3){
        $('input[name=houseRoom]').click(function(){
            $('.hroom').html('');
        });
    }else if("{{$tp1}}" == 1){
        //期望行业
        $('.trad').click(function(){
            var trad = [];
            $('.trad').each(function(){
                if($(this)[0].checked){
                    trad.push($(this).val());
                }
            });
            $('input[name=trade]').val(trad.join('|'));
            if(trad.length == 0){
                $('.xtra').html('请选择期望行业');
            }else{
                $('.xtra').html('');
            }
        });
    }

    //下拉选择
    $('.xiala li').click(function(){
        var zd = $(this).attr('zd');
        $('input[name='+zd+']').val($(this).attr('value'));
        $(this).parents('.sort_icon').next().html('');
    });
    if("{{$type}}" == 'esfrent'){
        //配套设施
        $('.fitm').click(function(){
            var fitm = [];
            $('.fitm').each(function(){
                if($(this)[0].checked){
                    fitm.push($(this).val());
                }
            });
            $('input[name=equipment]').val(fitm.join('|'));
            if(fitm.length == 0){
                $('.xfitm').html('请选择请选择配套设施');
            }else{
                $('.xfitm').html('');
            }
        });
        $('#all').click(function(){
            var fitm = [];
            $('.fitm').each(function(){
                if($(this)[0].checked){
                    fitm.push($(this).val());
                }
            });
            $('input[name=equipment]').val(fitm.join('|'));
        });
    }


    //  选择省份获取城市
    $('li.choosePro').click(getCityList);
    function getCityList(){
        var proId = $(this).attr('value');
        $('input[name=provinceId]').val(proId);
        var crtoken = $('#crtoken').val();
        var url = '/city/getcity';
        $.ajax({
            type : 'POST',
            url : url,
            data : {
                id : proId,
                _token : crtoken
            },
            dataType : 'json',
            success : function(msg){
                if(msg == 2){
                    return false;
                }else{
                    var cityList = '';
                    for(var i in msg){
                        cityList += '<li class="chooseCity" value="'+msg[i].id+'">'+msg[i].name+'</li>';
                    }
                    $('#cityList').html(cityList);
                    $('li.chooseCity').on('click',getAreaList);
                    $('#cityText').text('请选择市');
                    $('#areaText').text('请选择区');
                    $('#busText').text('请选择商圈');
                    $('#subwayText').text('请选择地铁线路');
                    $('#subwaystationText').text('请选择地铁站点');
                    $('#areaList').html('<li style="margin-left:20px;width:auto;">请选择市</li>');
                    $('#busareaList').html('<li style="margin-left:20px;width:auto;">请选择区</li>');
                    $('#subway').html('<li style="margin-left:20px;width:auto;">请选择市</li>');
                    $('#subwaystation').html('<li style="margin-left:10px;width:auto;">请选择地铁线路</li>');
                    $('input[name=cityId]').val('');
                    $('input[name=cityAreaId]').val('');
                    $('input[name=businessAreaId]').val('');
                    $('input[name=subwayLineId]').val('');
                    $('input[name=subwayId]').val('');
                }
            }

        });
    }
    $('li.chooseCity').click(getAreaList);
    // 获取区域
    function getAreaList(){
        var obj = $(this);
        // 楼盘数据清空 start
        $('.cbuild').html('');
        $('input[name=communityId]').val('');
        $('#keyword').val('');
        // 楼盘数据清空 end
        $('.prcity').html('');
        obj.parents('.list_tag').hide();
        $('#cityText').text(obj.text());
        var cityId = obj.attr('value');
        $('input[name=cityId]').val(cityId);
        var crtoken = $('#crtoken').val();
        var url = '/city/getcityarea';
        var url1 = '/city/getsubway';
        $.ajax({
            type : 'POST',
            url : url,
            data : {
                id : cityId,
                _token : crtoken
            },
            dataType : 'json',
            success : function(msg){
                if(msg == 2){
                    return false;
                }else{
                    var areaList = '';
                    for(var i in msg){
                        areaList += '<li class="chooseArea" value="'+msg[i].id+'">'+msg[i].name+'</li>';
                    }
                    $('#areaList').html(areaList);
                    $('li.chooseArea').on('click',getCurrentCityArea);
                }
            }
        });
        $.ajax({
            type : 'POST',
            url : url1,
            data : {
                id : cityId,
                _token : crtoken
            },
            dataType : 'json',
            success : function(msg){
                if(msg.length == 0){
                    $('.x_sub').hide();
                    $('#subway').html('<li style="margin-left:20px;width:auto;">无地铁线路</li>');
                    $('#subwaystation').html('<li style="margin-left:10px;width:auto;"></li>');
                    return false;
                }else{
                    $('.x_sub').show();
                    var subway = '';
                    for(var i in msg){
                        subway += '<li class="subwaylist" value="'+msg[i].id+'">'+msg[i].name+'</li>';
                    }
                    $('#subway').html(subway);
                    $('li.subwaylist').on('click',getsubway);
                }
            }
        });
        $('#areaText').text('请选择区');
        $('#busText').text('请选择商圈');
        $('#subwayText').text('请选择地铁线路');
        $('#subwaystationText').text('请选择地铁站点');
        $('input[name=cityAreaId]').val('');
        $('input[name=businessAreaId]').val('');
        $('input[name=subwayLineId]').val('');
        $('input[name=subwayId]').val('');
    }
    //点击方法
    $('li.chooseArea').click(getCurrentCityArea);
    $('li.subwaylist').click(getsubway);
    // 选择城区后效果
    function getCurrentCityArea(){
        var cityAreaId = $(this).attr('value');
        $('input[name=cityAreaId]').val(cityAreaId);
        $(this).parents('.list_tag').hide();
        $('#areaText').text($(this).text());
        var crtoken = $('#crtoken').val();
        var url = '/city/getbusinessarea';
        $.ajax({
            type : 'POST',
            url : url,
            data : {
                id : cityAreaId,
                _token : crtoken
            },
            dataType : 'json',
            success : function(msg){
                if(msg == 2){
                    return false;
                }else{
                    var areaList = '';
                    for(var i in msg){
                        areaList += '<li class="chooseBusArea" value="'+msg[i].id+'">'+msg[i].name+'</li>';
                    }
                    $('#busareaList').html(areaList);
                    $('li.chooseBusArea').on('click',getCurrentBusArea);
                }
            }
        });
        $('#busText').text('请选择商圈');
        $('input[name=businessAreaId]').val('');
    }
    function getCurrentBusArea(){
        var cityAreaId = $(this).attr('value');
        $('input[name=businessAreaId]').val(cityAreaId);
        $(this).parents('.list_tag').hide();
        $('#busText').text($(this).text());
        $('.abus').html('');
    }
    //选择地铁线路效果
    function getsubway(){
        var subwayLineId = $(this).attr('value');
        $('input[name=subwayLineId]').val(subwayLineId);
        $(this).parents('.list_tag').hide();
        $('#subwayText').text($(this).text());
        var crtoken = $('#crtoken').val();
        var cityId = $('input[name=cityId]').val();
        var url = '/city/getsubwaystation';
        $.ajax({
            type : 'POST',
            url : url,
            data : {
                cityId : cityId,
                lineId : subwayLineId,
                _token : crtoken
            },
            dataType : 'json',
            success : function(msg){
                if(msg.length == 0){
                    return false;
                }else{
                    var subwaystation = '';
                    for(var i in msg){
                        subwaystation += '<li class="chooseSubWayStation" value="'+msg[i].id+'">'+msg[i].name+'</li>';
                    }
                    $('#subwaystation').html(subwaystation);
                    $('li.chooseSubWayStation').on('click',getSubWayStation);
                }
            }
        });
        $('#subwaystationText').text('请选择地铁站点');
        $('input[name=subwayId]').val('');
    }
    function getSubWayStation(){
        var subWayStationId = $(this).attr('value');
        $('input[name=subwayId]').val(subWayStationId);
        $(this).parents('.list_tag').hide();
        $('#subwaystationText').text($(this).text());
        $('.sws').html('');
    }

    //楼盘搜索

    $('#keyword').on('keyup focus', function(ev){
        var crtoken = $('#crtoken').val();
        var x_url = '/houseHelp/communityNameList';
        var keyword = $.trim($(this).val());
        var tp1 = "{{$tp1}}";
        var cityId = $('input[name=cityId]').val();
        if(cityId == ''){
            $('.cbuild').html('请选择城市');
            return;
        }else{
            $('.cbuild').html('');
        }
        if(keyword == ''){
            $('.cbuild').html('请输入楼盘名称');
            return;
        }else{
            $('.cbuild').html('');
        }
        $.ajax({
            type:'post',
            url:x_url,
            data:{
                _token : crtoken,
                name : keyword,   //  楼盘名称
                cityId : cityId,    //  城市id
                type1 : tp1       //  主物业类型
            },
            dataType : 'json',
            success:function(data){
                if(data == 5){
                    $('#buildSearch').html('');
                    return false;
                }
                var dataList = '';
                for( var i in data){
                    dataList += '<dd><a class="selectSearch" value="'+ data[i].id +'">'+ data[i].name +'</a></dd>';
                }
                $('#buildSearch').html(dataList);
                $('#buildSearch').show();
                $('.selectSearch').click(function(){
                    $('#keyword').val($(this).html());
                    $('input[name=communityId]').val($(this).attr('value'));
                    $('#buildSearch').hide();
                    $('.cbuild').html('');
                });
            }
        });
    });
    {{--var versionNum = 0;--}}
    {{--$('#keyword').on('keyup focus', function(ev){--}}
        {{--var crtoken = $('#crtoken').val();--}}
        {{--var x_url = '/home_search_only';--}}
        {{--var keyword = $.trim($(this).val());--}}
        {{--var tp1 = "{{$tp1}}";--}}
        {{--var sr = "{{$sr}}";--}}
        {{--versionNum++;--}}
        {{--$.ajax({--}}
            {{--type:'post',--}}
            {{--url:x_url,--}}
            {{--data:{--}}
                {{--_token:crtoken,--}}
                {{--keywords:keyword,--}}
                {{--tp:'old',--}}
                {{--tp1:tp1,--}}
                {{--sr:sr,--}}
                {{--v:versionNum--}}
            {{--},--}}
            {{--success:function(data){--}}
                {{--if(data == 0){--}}
                    {{--$('#buildSearch').html('');--}}
                    {{--return false;--}}
                {{--}--}}
                {{--if (parseInt(data.versionNum) == versionNum) {--}}
                    {{--data = data.res;--}}
                    {{--var dataList = '';--}}
                    {{--for( var i in data){--}}
                        {{--var comName  = data[i]._source.name ? data[i]._source.name : data[i]._source.communityName;--}}
                        {{--if(typeof comName != 'undefined'){--}}
                            {{--dataList += '<dd><a class="selectSearch" value="'+ data[i]._source.id +'">'+ comName +'</a></dd>';--}}
                        {{--}--}}
                    {{--}--}}
                    {{--console.log(dataList);--}}
                    {{--$('#buildSearch').html(dataList);--}}
                    {{--$('#buildSearch').show();--}}
                    {{--$('.selectSearch').click(function(){--}}
                        {{--$('#keyword').val($(this).html());--}}
                        {{--$('input[name=communityId]').val($(this).attr('value'));--}}
                        {{--$('#buildSearch').hide();--}}
                        {{--$('.cbuild').html('');--}}
                    {{--});--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}
    {{--});--}}

    // 发送验证码
    $('#getcode').click(function(){
        if(!$('.js-tel').val() || !/^1[3|5|7|8]\d{9}$/.test($('.js-tel').val())){
            $('.js-tel').focus();
            return;
        }
        // 增加图片验证码
        $('#img_code_val').parent().show();
        var img_code = $('#img_code_val').val();
        if(img_code.length == 0 || img_code == ''){
            $('#img_code_val').focus();
            $('#img_code_val').nextAll('span').text('请输入图片验证码');
            return;
        }
        $('#img_code_val').nextAll('span').text('');
        var mobile = $('.js-tel').val();
        var url = '/yzmobile';
        $.ajax({
            type : 'POST',
            url : url,
            data : {
                mid : 2,
                mobile : mobile,
                imgCode : img_code
            },
            dataType : 'json',
            success : function(msg){
                if(typeof msg == 'object' && msg.res == 1){
                    alert('msg.message');
                    $('#getcode').attr('disabled',true);
                    return false;
                }
                if(typeof msg == 'object' && msg.res == 3){
                    $('#img_code_val').nextAll('span').text('图片验证码错误');
                    return false;
                }
                $('#getcode').removeAttr('disabled');
                $('#img_code').parent().hide();
                $('#img_code').click();
                $('#img_code_val').val('');
                //alert('验证码发送成功'+msg);
                sendCodeTime('#getcode');
            }
        });
    });


    //获取验证码按钮倒计时
    function sendCodeTime(obj){
        var second = 60;
        var machine;
        $(obj).attr('disabled',true);
        machine = setInterval(function(){
            if(second >= 0){
                $(obj).val(second+'秒');;
                $(obj).css({'background':'#e0e0e0',color:'#3281f6'});
                second--;
            }else{
                clearInterval(machine);
                $(obj).val('获取验证码');
                $(obj).css({'background':'#999',color:'#fff'});
                $(obj).removeAttr('disabled');
                return false;
            }
        },1000);
    }

    //图片验证码获得焦点错误提示消失
    $('#img_code_val').keyup(function(){
        $(this).next().next().text('');
    });
});
</script>
@endsection
