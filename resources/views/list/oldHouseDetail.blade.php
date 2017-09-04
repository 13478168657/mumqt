@extends('mainlayout')
@include('list.header')
@section('content')

    @yield('xcssjs')
    <link rel="stylesheet" type="text/css" href="/css/detail.css?v={{Config::get('app.version')}}">
    @yield('xsearch')
    @include('layout.getVirtualphone')
    <form action="{{$houseUrl}}" id="build" method="post">
        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}" >
        <input type="hidden" id="linkurl"  value="{{$houseUrl}}" >
        <input type="hidden" id="par"  value="" >
        <input type="hidden" value="" name="keyword" >
    </form>

    <input type="hidden" id='comid' value="{{$house->communityId}}">
    <input type="hidden" id='saleRent' value="{{$class}}">
    <input type="hidden" id='strType2' value="{{$house->houseType2}}">

    <p class="route">
        <span>您的位置：</span>
        <a href="/">首页</a>
        <span>&nbsp;>&nbsp;</span>
        <a href="{{$houseUrl}}">{{$cityName}} </a>
        @if(!empty($cityAreaName))
            <span>&nbsp;>&nbsp;</span>
            <a href="{{$houseUrl}}/aa{{$house->cityareaId}}">{{$cityAreaName}}</a>
        @endif
        @if(!empty($businessAreaName))
            <span>&nbsp;>&nbsp;</span>
            <a href="{{$houseUrl}}/aa{{$house->cityareaId}}-ab{{$house->businessAreaId}}">{{$businessAreaName}}</a>
        @endif
        @if(!empty($house->name))
            <span>&nbsp;>&nbsp;</span>
            <a href="{{$houseUrl}}/ba{{$house->communityId}}">{{$house->name}}</a>
        @endif
    </p>

    <div class="house_name">
        <h2>{{$house->title}}<a><span class="focus" value="{{$house->id}},{{($class == "sale")?2:1}},{{$housety}},0"><i></i><span>{{(!empty($interest)&&(in_array($house->id,$interest))?'已关注':'关注')}}</span></span></a></h2>
        <p>
            <?php $x=1;?>
            @if(!empty($house->tagId))
                @foreach(explode('|',$house->tagId) as $k=>$tagid)
                    @if(!empty($tags[$tagid]))
                        <span class="tab tag1">{{$tags[$tagid]}}</span>
                        <?php $x++;if($x >6) break;?>
                    @endif
                @endforeach
            @endif
            @if(!empty($diyTagIds))
                @foreach($diyTagIds as $k=>$diyname)
                    @if(!empty($diyname))
                        <span class="tab tag1">{{$diyname}}</span>
                        <?php $x++;if($x >6) break;?>
                    @endif
                @endforeach
            @endif
            <span class="id">房源ID：@if(!empty($house->housingNum)){{$house->housingNum}}@else{{$housing.str_pad($house->id,11,0,STR_PAD_LEFT)}}@endif
                <span>更新时间：
                    <?php
                    if(!empty($house->timeRefresh)){
                        $timeRefresh = floor($house->timeRefresh/1000);
                    }elseif(!empty($house->timeUpdate)){
                        $timeRefresh = strtotime($house->timeUpdate);
                    }
                    if(!empty($timeRefresh)){
                        $time = time() - $timeRefresh;
                        if(0<$time &&$time<60){
                            $time = $time.'秒前';
                        }elseif(60<$time &&$time<3600){
                            $time = (int)($time/60).'分钟前';
                        }elseif(3600<$time &&$time<86400){
                            $time = (int)($time/3600).'小时前';
                        }else{
                            $time = date('Y年m月d日',$timeRefresh);
                        }
                        echo $time;
                    }else{
                        echo '其它';
                    }
                    ?>
            </span>
        </span>
        <span class="share jiathis_style_24x24">
        <span>分享到：</span>
        <a class="jiathis_button_weixin " ></a>
        <a class="jiathis_button_cqq " ></a>
        <a class="jiathis_button_qzone no_right" ></a>
        </span>
        </p>
    </div>
    <div class="detail">
        <div class="house_info">
            @if(!empty($houseImages))
            <div id="jssor_1" style=" width: 600px; height: 450px;">
                <!-- Loading Screen -->
                <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                    <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                    <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                </div>
                <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 600px; height: 450px; overflow: hidden;">
                    @foreach($houseImages as $k=>$houseimage)
                        <div data-p="112.50" class="pics" style="display: none;">
                            <img data-u="image" class="s_pic" src="{{get_img_url($objectType,$houseimage,5)}}" data_src="{{get_img_url($objectType,$houseimage)}}" alt="{{!empty($house->name)?$house->name:''}}"/>
                            <img data-u="thumb" src="{{get_img_url($objectType,$houseimage,2)}}" alt="{{!empty($house->name)?$house->name:''}}"/>
                        </div>
                    @endforeach
                </div>
                <div u="thumbnavigator" class="jssort03" data-autocenter="1">
                    <div class="xf_img"></div>
                    <div u="slides" style="cursor: default;">
                        <div u="prototype" class="p">
                            <div class="w">
                                <div u="thumbnailtemplate" class="t"></div>
                            </div>
                            <div class="c"></div>
                        </div>
                    </div>
                </div>
                <span data-u="arrowleft" class="jssora02l" data-autocenter="2"></span>
                <span data-u="arrowright" class="jssora02r" data-autocenter="2"></span>
            </div>
            @else
                <div class="jssor_1"></div>
            @endif
            <div class="house_msg">
                @if($type == 'esfsale' || $type == 'esfrent' || $type == 'bssale' || $type == 'bsrent')
                    @if($type == 'esfsale' || $type == 'bssale')
                        <p class="house_price">
                            <label>售价：</label>
                            @if(!empty($house->price2))
                                <span class="sale_price"><span class="font_size">{{floor($house->price2)}}</span>万/套</span>
                                <a class="jsq" href="/cal3" title="{{!empty($house->name)?$house->name:''}} 房贷计算器"><i></i>房贷计算器</a>
                            @else
                                <span class="sale_price">面议</span>
                            @endif
                        </p>
                        <div class="house_price house_price2">
                            <label>单价：</label>
                            @if(!empty($house->price1))
                                <span class="sale_price"><span class="font_words">{{floor($house->price1)}}</span>元/平米</span>
                            @endif
                            <label>参考首付：</label>
                            <span class="sale_price margin_l" id="frist"></span>
                            <label>参考月供：</label>
                         <span id="YG" class="ck">
                          <span class="color2d"></span>
                          <i></i>
                        </span>
                            <!--月供 start-->
                            <div class="jsq-yg">
                                <span id="yg_close" class="yg_close"></span>
                                <div class="jsq-yg-one">
                                    <p class="jsq-yg-notes">注：首付和月供仅供参考，请以实际交易为准</p>
                                </div>
                                <dl>
                                    <dt>还款方式：</dt>
                                    <dd>等额本息</dd>
                                </dl>
                                <dl>
                                    <dt>贷款类型：</dt>
                                    <dd>
                                        <div class="jsq-yg-radio">
                                            <input type="radio" checked="checked" value="1" name="AppType" id="AppType">商业贷款
                                        </div>
                                        <div class="jsq-yg-radio">
                                            <input type="radio" value="2" name="AppType" id="AppType">公积金
                                        </div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>按揭成数：</dt>
                                    <dd>
                                        <select id="ChengNum" name="">
                                            <option value="2">2成</option>
                                            <option value="3">3成</option>
                                            <option value="4">4成</option>
                                            <option value="5">5成</option>
                                            <option value="6">6成</option>
                                            <option selected="selected" value="7">
                                                7成
                                            </option>
                                            <option value="8">8成</option>
                                            <option value="9">9成</option>

                                        </select>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>参考首付：</dt>
                                    <dd class="jsq-yg-red"><span id="ShouFu">187.20</span>万</dd>
                                </dl>
                                <dl>
                                    <dt>按揭年数：</dt>
                                    <dd>
                                        <select id="YearNum" name="">
                                            <option value="1">1年（12期）</option>
                                            <option value="2">2年（24期）</option>
                                            <option value="3">3年（36期）</option>
                                            <option value="4">4年（48期）</option>
                                            <option value="5">5年（60期）</option>
                                            <option value="6">6年（72期）</option>
                                            <option value="7">7年（84期）</option>
                                            <option value="8">8年（96期）</option>
                                            <option value="9">9年（108期）</option>
                                            <option value="10">10年（120期）</option>
                                            <option value="11">11年（132期）</option>
                                            <option value="12">12年（144期）</option>
                                            <option value="13">13年（156期）</option>
                                            <option value="14">14年（168期）</option>
                                            <option value="15">15年（180期）</option>
                                            <option value="16">16年（192期）</option>
                                            <option value="17">17年（204期）</option>
                                            <option value="18">18年（216期）</option>
                                            <option value="19">19年（228期）</option>
                                            <option value="20">20年（240期）</option>
                                            <option value="21">21年（252期）</option>
                                            <option value="22">22年（264期）</option>
                                            <option value="23">23年（276期）</option>
                                            <option value="24">24年（288期）</option>
                                            <option value="25">25年（300期）</option>
                                            <option value="26">26年（312期）</option>
                                            <option value="27">27年（324期）</option>
                                            <option value="28">28年（336期）</option>
                                            <option value="29">29年（348期）</option>
                                            <option selected="selected" value="30">
                                                30年（360期）
                                            </option>

                                        </select>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>利率：</dt>
                                    <dd>
                                        <select id="Rate" name="">
                                            <option value="0.05225|0.0539|0.03025|0.03575|">
                                                15年10月24日利率上限（1.1倍）
                                            </option>
                                            <option value="0.045125|0.04655|0.026125|0.030875|">
                                                15年10月24日利率下限（95折）
                                            </option>
                                            <option value="0.04275|0.0441|0.02475|0.02925|">
                                                15年10月24日利率下限（9折）
                                            </option>
                                            <option value="0.0418|0.04312|0.0242|0.0286|">
                                                15年10月24日利率下限（88折）
                                            </option>
                                            <option value="0.040375|0.04165|0.023375|0.027625|">
                                                15年10月24日利率下限（85折）
                                            </option>
                                            <option value="0.03325|0.0343|0.01925|0.02275|">
                                                15年10月24日利率下限（7折）
                                            </option>
                                            <option value="0.0475|0.049|0.0275|0.0325|" selected="selected">
                                                15年10月24日基准利率
                                            </option>
                                            <option value="0.055|0.05665|0.03025|0.03575|">
                                                15年8月26日利率上限（1.1倍）
                                            </option>
                                            <option value="0.0425|0.043775|0.023375|0.027625|">
                                                15年8月26日利率下限（85折）
                                            </option>
                                            <option value="0.035|0.03605|0.01925|0.02275|">
                                                15年8月26日利率下限（7折）
                                            </option>
                                            <option value="0.05|0.0515|0.0275|0.0325|">
                                                15年8月26日基准利率
                                            </option>
                                            <option value="0.05775|0.0594|0.033|0.0385|">
                                                15年6月28日利率上限（1.1倍）
                                            </option>
                                            <option value="0.044625|0.0459|0.0255|0.02975|">
                                                15年6月28日利率下限（85折）
                                            </option>
                                            <option value="0.03675|0.0378|0.021|0.0245|">
                                                15年6月28日利率下限（7折）
                                            </option>
                                            <option value="0.0525|0.054|0.03|0.035|">
                                                15年6月28日基准利率
                                            </option>
                                            <option value="0.0605|0.06215|0.03575|0.04125|">
                                                15年5月11日利率上限（1.1倍）
                                            </option>
                                            <option value="0.04675|0.048025|0.027625|0.031875|">
                                                15年5月11日利率下限（85折）
                                            </option>
                                            <option value="0.0385|0.03955|0.02275|0.02625|">
                                                15年5月11日利率下限（7折）
                                            </option>
                                            <option value="0.0550|0.0565|0.03250|0.03750|">
                                                15年5月11日基准利率
                                            </option>
                                            <option value="0.0633|0.0649|0.0385|0.0440|">
                                                15年3月1日利率上限（1.1倍）
                                            </option>
                                            <option value="0.0489|0.0501|0.0297|0.0340|">
                                                15年3月1日利率下限（85折）
                                            </option>
                                            <option value="0.0403|0.0413|0.0245|0.0280|">
                                                15年3月1日利率下限（7折）
                                            </option>
                                            <option value="0.0575|0.0590|0.0350|0.0400|">
                                                15年3月1日基准利率
                                            </option>
                                            <option value="0.066|0.067|0.0375|0.0425|">
                                                14年11月22日利率上限（1.1倍）
                                            </option>
                                            <option value="0.051|0.052|0.0375|0.0425|">
                                                14年11月22日利率下限（85折）
                                            </option>
                                            <option value="0.042|0.043|0.0375|0.0425|">
                                                14年11月22日利率下限（7折）
                                            </option>
                                            <option value="0.0600|0.0615|0.0375|0.0425|">
                                                14年11月22日基准利率
                                            </option>
                                            <option value="0.0704|0.07205|0.0400|0.0450|">
                                                12年7月6日利率上限（1.1倍）

                                            </option>
                                            <option value="0.0544|0.055675|0.0400|0.0450|">
                                                12年7月6日利率下限（85折）
                                            </option>
                                            <option value="0.0448|0.04585|0.0400|0.0450|">
                                                12年7月6日利率下限（7折）
                                            </option>
                                            <option value="0.0640|0.0655|0.0400|0.0450|">
                                                12年7月6日基准利率
                                            </option>
                                            <option value="0.07315|0.0748|0.0420|0.0470|">
                                                12年6月8日利率上限（1.1倍）
                                            </option>
                                            <option value="0.056525|0.0578|0.0420|0.0470|">
                                                12年6月8日利率下限（85折）
                                            </option>
                                            <option value="0.04655|0.0476|0.0420|0.0470|">
                                                12年6月8日利率下限（7折）
                                            </option>
                                            <option value="0.0665|0.0680|0.0420|0.0470|">
                                                12年6月8日基准利率
                                            </option>

                                        </select>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>参考月供：</dt>
                                    <dd class="jsq-yg-red"><span id="yuegong">23182.14</span>元</dd>
                                </dl>
                            </div>
                        </div>
                    @else
                        <p class="house_price">
                            <label>租金：</label>
                            @if(!empty($house->price1))
                                <span class="sale_price"><span class="font_size">{{floor($house->price1)}}</span>元/月</span>
                            @else
                                <span class="sale_price">面议</span>
                            @endif
                        </p>
                        <div class="house_price">
                            <label>租赁方式：</label>
                            <span class="sale_price">{{(!empty($house->rentType)&&!empty($rentTypes[$house->rentType]))?$rentTypes[$house->rentType]:'其它'}}</span>
                            <label>支付方式：</label>
                            <span class="sale_price margin_l">{{(!empty($house->paymentType)&&!empty($paymentTypes[$house->paymentType]))?$paymentTypes[$house->paymentType]:'其它'}}</span>
                        </div>
                    @endif
                    <ul class="info_nav">
                        <li>
                            <label>房&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;型：</label>
                            <span class="info_width">{{substr($house->roomStr,0,1)}}室{{substr($house->roomStr,2,1)}}厅{{substr($house->roomStr,4,1)}}厨{{substr($house->roomStr,6,1)}}卫</span>
                        </li>
                        <li>
                            <label>建筑面积：</label>
                            <span class="info_width">{{$house->area}}平米</span>
                        </li>
                        <li>
                            <label>朝&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;向：</label>
                            <span class="info_width">{{!empty($faces[$house->faceTo])?$faces[$house->faceTo]:'未知'}}</span>
                        </li>
                        <li>
                            <label>所在楼层：</label>
                            <span class="info_width"> 第{{$house->currentFloor}}层( 共{{$house->totalFloor}}层 )</span>
                        </li>
                    </ul>
                @else
                    @if($type == 'spsale' || $type == 'xzlsale')
                        <p class="house_price">
                            <label>售价：</label>
                            @if(!empty($house->price2))
                                <span class="sale_price"><span class="font_size">{{floor($house->price2)}}</span>万/套</span>
                            @else
                                <span class="sale_price">面议</span>
                            @endif
                        </p>
                        <div class="house_price">
                            <label>单价：</label>
                            @if(!empty($house->price1))
                                <span class="sale_price"><span class="font_words">{{floor($house->price1)}}</span>元/平米</span>
                            @else
                                <span class="sale_price">面议</span>
                            @endif
                            @if($type == 'spsale')
                                <label>商铺状态：</label>
                                <span class="sale_price margin_l">{{(isset($house->stateShop)&&!empty($stateShops[$house->stateShop]))?$stateShops[$house->stateShop]:'其它'}}</span>
                            @endif
                        </div>
                    @else
                        <div class="house_price">
                            <label>租金：</label>
                            @if(!empty($house->price2))
                                <span class="sale_price"><span class="font_size">{{$house->price2}}</span>元/平米▪天</span>
                            @else
                                <span class="sale_price">面议</span>
                            @endif
                            @if(($type == 'sprent')&&!empty($house->isTransfer)&&!empty($house->transferPrice))
                                <label>转让费：</label>
                                <span class="sale_price">{{$house->transferPrice}}万</span>
                            @endif
                        </div>
                        <div class="house_price">
                            <label>月租金：</label>
                            @if(!empty($house->price1))
                                <span class="sale_price"><span class="font_words">{{floor($house->price1)}}</span>元/月</span>
                            @else
                                <span class="sale_price">面议</span>
                            @endif
                            @if($type == 'sprent')
                                <label>商铺状态：</label>
                                <span class="sale_price margin_l">{{(isset($house->stateShop)&&!empty($stateShops[$house->stateShop]))?$stateShops[$house->stateShop]:'其它'}}</span>
                            @endif
                            <label>支付方式：</label>
                            <span class="sale_price margin_l">{{(!empty($house->paymentType)&&!empty($paymentTypes[$house->paymentType]))?$paymentTypes[$house->paymentType]:'其它'}}</span>
                        </div>
                    @endif
                    <ul class="info_nav">
                        <li>
                            <label>建筑面积：</label>
                            <span class="info_width">{{$house->area}}平米</span>
                        </li>
                        @if(!empty($house->propertyFee)&&($house->propertyFee != 0.00))
                            <li>
                                <label>物&nbsp;&nbsp;业&nbsp;费：</label>
                                <span class="info_width">{{$house->propertyFee}}元/平米▪月</span>
                            </li>
                        @endif
                        <li>
                            <label>所在楼层：</label>
                            <span class="info_width">第{{$house->currentFloor}}层( 共{{$house->totalFloor}}层 )</span>
                        </li>
                        <li>
                            <label>物业类型：</label>
                            <span class="info_width">{{$type2[$house->houseType1][$house->houseType2] or '暂无'}}</span>
                        </li>
                    </ul>
                @endif
                <p class="phone">
                   <i></i>
                    <span class="phone_c">
                        @if(!empty($house->publishUserType) && ($house->publishUserType == 1))
                            {{!empty($brokers->mobile)?$brokers->mobile:'暂无'}}
                        @else
                            {{!empty($house->linkmobile)?$house->linkmobile:'暂无'}}
                        @endif
                    </span>
                    @if(isset($house->publishUserType) && ($house->publishUserType == 0))
                        <span class="phone_p">联系人：{{!empty($house->linkman)?$house->linkman:'暂无'}}</span>
                    @endif
                </p>
                <p class="tell_me">联系时请说：您好，我从搜房网看到房源信息。</p>
                <ul class="info_nav">
                    @if($type == 'esfsale' || $type == 'esfrent'||$type == 'bssale' || $type == 'bsrent')
                        <li><label>装修程度：</label><span class="info_width">{{!empty($fitments[$house->fitment])?$fitments[$house->fitment]:'暂无'}}</span></li>
                        <li><label>物业类型：</label><span class="info_width">{{$type2[$house->houseType1][$house->houseType2] or ''}}</span></li>
                        @if($type == 'esfrent')
                            <li class="no_left">
                                <label>配套设施：</label>
                            <span>
                                @if(!empty($house->equipment))
                                    <?php $ptss = '';?>
                                    @foreach(preg_split("/[,|]/",$house->equipment) as $k=>$equipment)
                                        @if(!empty($equipments[$equipment]))
                                            <?php $ptss .=','.$equipments[$equipment];?>
                                        @endif
                                    @endforeach
                                    {{trim($ptss,',')}}
                                @else
                                    暂无数据
                                @endif
                            </span>
                            </li>
                        @endif
                    @else

                        @if($type == 'spsale' || $type == 'sprent')
                            <li class="no_left resize">
                                <label>推荐行业：</label>
                            <span class="info_width">
                                <?php
                                $xtrade = explode('|',$house->trade);
                                $xtrade = array_unique($xtrade);
                                $ytrade = array();
                                foreach($xtrade as $trade){
                                    if(!empty($trades[$trade])){
                                        array_push($ytrade,$trades[$trade]);
                                    }
                                }
                                echo implode(',',$ytrade);
                                ?>
                            </span>
                            </li>
                            <li class="no_left">
                                <label>物业配套：</label>
                            <span>
                                @if(!empty($house->equipment))
                                    <?php $ptss = '';?>
                                    @foreach(preg_split("/[,|]/",$house->equipment) as $k=>$equipment)
                                        @if(!empty($equipments[$equipment]))
                                            <?php $ptss .=','.$equipments[$equipment];?>
                                        @endif
                                    @endforeach
                                    {{trim($ptss,',')}}
                                @else
                                    暂无数据
                                @endif
                            </span>
                            </li>
                        @else
                            <li>
                                <label>装修程度：</label>
                                <span class="info_width">{{!empty($fitments[$house->fitment])?$fitments[$house->fitment]:'暂无'}}</span>
                            </li>
                        @endif
                    @endif
                    <li class="no_left">
                        <label>楼盘名称：</label>
                        @if(!empty($house->name))
                            <a class="build_name" href="/esfindex/{{$house->communityId}}/{{$house->houseType2}}.html" target="_blank" title="{{$house->name}}">{{$house->name}}</a>
                            <span class="sq">
                                @if(!empty($cityAreaName) && !empty($businessAreaName))
                                    [{{$cityAreaName.'▪'.$businessAreaName}}]
                                @endif
                            </span>
                            <span class="address" title="{{$house->address}}"><span>{{$house->address}}</span><i class="icon"></i></span>
                        @else
                            <a class="build_name">无</a>
                        @endif

                    </li>
                </ul>
                @if(!empty($brokers))
                    <dl class="broker_info">
                        <dt><img width="90" height="120" src="{{!empty($brokers->photo)?get_img_url('userPhoto',$brokers->photo,7):"/image/default_broker.png"}}" alt="{{$brokers->realName}}" onerror="javascript:this.src='/image/default_broker.png';" ></dt>
                        <dd>
                            <p class="p1"><span>{{$brokers->realName}}</span></p>
                            <p class="p2">
                                @if(!empty(trim($brokercompanyname)))
                                    <span>{{mb_substr($brokercompanyname,0,5,'utf-8')}}</span>
                                    <span class="dotted"></span>
                                @endif
                                <span>{{!empty($brokerBusiness)?implode('  ',$brokerBusiness):'多商圈'}}</span>
                            </p>
                            <div class="tel">
                                <p class="p4">
                                    <a href="/brokerinfo/{{$house->uid}}.html" target="_blank">我的店铺</a>
                                    <span>进入我的店铺，看您心仪的房源</span>
                                </p>
                            </div>
                        </dd>
                        <span class="dotted"></span>
                        @if($brokers->idcardState == 1)
                            <dd class="test">
                                <img src="/image/id.png">
                                <span>身份认证</span>
                            </dd>
                        @endif
                        @if($brokers->nameCardState == 1)
                            <dd class="test">
                                <img src="/image/mp.png">
                                <span>名片认证</span>
                            </dd>
                        @endif
                    </dl>
                @endif

                {{--@if(!empty($house->communityId))--}}
                    {{--<p class="jb">对应楼盘信息错误，请点此<a class="color_blue">纠错</a></p>--}}
                {{--@endif--}}
            </div>
        </div>
        <div class="house">
            <div class="house_l">
                <div class="empty-placeholder hidden"></div>
                <div id="msg_nav" class="msg_nav" style="margin-left: 0px; border-top: 0px none;">
                    <a href="#item1" class="adv_door nav_click">房源描述</a>
                    <a class="adv_transfer" href="#item2">周边配套</a>
                    <a class="adv_price" href="#item3">价格走势</a>
                </div>
                <div class="house_depict">
                    <h2 id="item1" class="color2d no_top"><span></span>房源描述</h2>
                    <div class="comment no_border">
                        <div class="comment_l">
                            <p class="comment_msg comment_info color66">
                                @if(!empty($house->describe))
                                    {!! $house->describe !!}
                                @else
                                    暂无房源描述
                                @endif
                            </p>
                        </div>
                    </div>
                    <h2 id="item2" class="color2d"><span></span>周边配套</h2>
                    <div class="map">
                        <p class="tab_nav">
                   <span>
                     <a class="tab_l">街景地图</a>
                     <a class="tab_r click">交通地图</a>
                   </span>
                        </p>
                        <div style="display:none;" class="jj" id="quanjing"></div>
                        <div class="jt">
                            <p class="jt_nav">
                                <a class="curpos">楼盘位置</a>
                                <a class="chechData" attr="小区" title="{{!empty($house->name)?$house->name:''}}周边楼盘">周边楼盘</a>
                                <a class="chechData" attr="公交" title="{{!empty($house->name)?$house->name:''}}周边交通">交通</a>
                                <a class="chechData" attr="超市" title="{{!empty($house->name)?$house->name:''}}周边超市">超市</a>
                                <a class="chechData" attr="学校" title="{{!empty($house->name)?$house->name:''}}周边学校">学校</a>
                                <a class="chechData" attr="餐饮" title="{{!empty($house->name)?$house->name:''}}周边餐饮">餐饮</a>
                                <a class="chechData" attr="银行" title="{{!empty($house->name)?$house->name:''}}周边银行">银行</a>
                                <a class="chechData" attr="医院" title="{{!empty($house->name)?$house->name:''}}周边医院">医院</a>
                            </p>
                            <div class="assort">
                                <div class="assort" id="allmap"></div>
                                <div class="assort_nav">
                                    <div id="zk" class="zk"></div>
                                    <h2 id="soukey"></h2>
                                    <div id="r-result" style="height: 320px;overflow-y: auto;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="color2d" id="item3">价格走势</h2>
                    <div class="price_chart">
                        <div class="chart_tlt">
                            <div class="chart_nav sale">
                                <a class="click">出售</a>
                                <a>出租</a>
                            </div>
                            <div class="house_list">
                                <a class="sale_list" href="/{{$houseUrlHost}}sale/area/ba{{$house->communityId}}" target="_blank">查看本楼盘出售房源</a>
                                <a class="rent_list" href="/{{$houseUrlHost}}rent/area/ba{{$house->communityId}}" target="_blank" style=" display:none;">查看本楼盘出租房源</a>
                            </div>
                        </div>
                        <div class="chart_img a1">
                            <div class="room">
                                <div class="room_l" id="saleRoomPrice">
                                </div>
                                <div class="room_r" id="tag_sale">
                                </div>
                            </div>
                            <div class="chart" style="height: 200px" id="communityChart">

                            </div>
                        </div>

                    </div>
                    
                </div>
                @if(!empty($recommends)&&!empty($house->communityId))
                    <div class="apartment">
                        @if(($type == 'esfsale')|| ($type == 'esfrent') || ($type == 'bssale')|| ($type == 'bsrent'))
                            <h3>同为{{$houseRoom}}居推荐房源<a href="/{{$type}}/area/ba{{$house->communityId}}-aq{{substr($house->roomStr,0,1)}}" target="_blank">更多》</a></h3>
                        @else
                            <h3>本楼盘推荐房源<a href="/{{$type}}/area/ba{{$house->communityId}}" target="_blank">更多》</a></h3>
                        @endif

                        <div class="apartment_house">
                            <?php $i=0; ?>
                            @foreach($recommends as $recommend)
                                <?php
                                $i++;
                                if($i > 4){
                                    break;
                                }
                                ?>
                                <dl style="@if($i == 4) margin-right:0\0; @endif">
                                    <dt>
                                        <a href="/housedetail/s{{$sr}}{{$recommend->_source->id}}.html" target="_blank"><img src="{{get_img_url($objectType,$recommend->_source->thumbPic,2)}}"  onerror="nofind(this)"></a>
                                    <div class="house_detail">
                                        <p class="home_name"><a href="/housedetail/s{{$sr}}{{$recommend->_source->id}}.html" target="_blank">{{$recommend->_source->title}}</a></p>
                                        <div class="home_price">
                                            @if(($type == 'esfsale')|| ($type == 'esfrent') ||($type == 'bssale')|| ($type == 'bsrent'))
                                                <p class="p1">{{substr($recommend->_source->roomStr,0,1)}}室{{substr($recommend->_source->roomStr,2,1)}}厅/{{$recommend->_source->area}}平米</p>
                                            @else
                                                <p class="p1">{{$recommend->_source->area}}平米</p>
                                            @endif
                                            @if($class == 'sale')
                                                <p class="p2">@if(!empty($recommend->_source->price2))<span class="colorfe">{{floor($recommend->_source->price2)}}</span>万@else<span class="colorfe">面议</span>@endif</p>
                                            @else
                                                @if($housety == 3)
                                                    <p class="p2">@if(!empty($recommend->_source->price1))<span class="colorfe">{{floor($recommend->_source->price1)}}</span>元/月@else<span class="colorfe">面议</span>@endif</p>
                                                @else
                                                    <p class="p2">@if(!empty($recommend->_source->price2))<span class="colorfe">{{$recommend->_source->price2}}</span>元/平米▪天@else<span class="colorfe">面议</span>@endif</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    </dt>
                                </dl>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(!empty($surrounds)&&!empty($house->communityId))
                    <div class="apartment">
                        <h3>周边楼盘相似房源<a href="/{{$type}}?{{$lnglat}}&cid={{$house->communityId}}" target="_blank">更多》</a></h3>
                        <div class="apartment_house">
                            <?php $i=0; ?>
                            @foreach($surrounds as $surround)
                                <?php
                                $i++;
                                if($i > 4){
                                    break;
                                }
                                ?>
                                <dl style="@if($i == 4) margin-right:0\0 @endif">
                                    <dt>
                                        <a href="/housedetail/s{{$sr}}{{$surround->_source->id}}.html" target="_blank"><img src="{{get_img_url($objectType,$surround->_source->thumbPic,2)}}"  onerror="nofind(this)"></a>
                                    <div class="house_detail">
                                        <p class="home_name"><a href="/housedetail/s{{$sr}}{{$surround->_source->id}}.html" target="_blank">{{$surround->_source->title}}</a></p>
                                        <div class="home_price">
                                            @if(($type == 'esfsale')|| ($type == 'esfrent') ||($type == 'bssale')|| ($type == 'bsrent'))
                                                <p class="p1">{{substr($surround->_source->roomStr,0,1)}}室{{substr($surround->_source->roomStr,2,1)}}厅/{{$surround->_source->area}}平米</p>
                                            @else
                                                <p class="p1">{{$surround->_source->area}}平米</p>
                                            @endif
                                            @if($class == 'sale')
                                                <p class="p2">@if(!empty($surround->_source->price2))<span class="colorfe">{{floor($surround->_source->price2)}}</span>万@else<span class="colorfe">面议</span>@endif</p>
                                            @else
                                                @if($housety == 3)
                                                    <p class="p2">@if(!empty($surround->_source->price1))<span class="colorfe">{{floor($surround->_source->price1)}}</span>元/月@else<span class="colorfe">面议</span>@endif</p>
                                                @else
                                                    <p class="p2">@if(!empty($surround->_source->price2))<span class="colorfe">{{$surround->_source->price2}}</span>元/平米▪天@else<span class="colorfe">面议</span>@endif</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    </dt>
                                </dl>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="broker_msg">
                @if($admodels->modelId == 1)
                    <script type="text/javascript" src="/adShow.php?position=33&cityId={{CURRENT_CITYID}}"></script>
                    <script type="text/javascript" src="/adShow.php?position=34&cityId={{CURRENT_CITYID}}"></script>
                    <script type="text/javascript" src="/adShow.php?position=35&cityId={{CURRENT_CITYID}}"></script>
                @elseif($admodels->modelId == 2)
                    <script type="text/javascript" src="/adShowModel.php?position=36&cityId={{CURRENT_CITYID}}"></script>
                    <script type="text/javascript" src="/adShowModel.php?position=37&cityId={{CURRENT_CITYID}}"></script>
                    <script type="text/javascript" src="/adShowModel.php?position=38&cityId={{CURRENT_CITYID}}"></script>
                @endif
                <div class="spread_home">
                    <p><a>该{{!empty($house->publishUserType)&&($house->publishUserType == 1)?'经纪人':'业主'}}下其他房源</a></p>
                    @if(!empty($otherHouses))
                        @foreach($otherHouses as $otherHouse)
                            <dl>
                                <a href="/housedetail/s{{$sr}}{{$otherHouse->_source->id}}.html" target="_blank">
                                    <dt><img src="{{get_img_url($objectType,$otherHouse->_source->thumbPic,2)}}" alt="{{$otherHouse->_source->title}}"></dt>
                                    <dd class="spread_name">{{$otherHouse->_source->title}}</dd>
                                    <dd class="spread_price">
                                        @if($type == 'esfsale' || $type == 'esfrent' || $type == 'bssale' || $type == 'bsrent')
                                            <span class="build_name">
                                        {{substr($otherHouse->_source->roomStr,0,1)}}室{{substr($otherHouse->_source->roomStr,2,1)}}厅
                                        &nbsp;&nbsp;{{$otherHouse->_source->area}}平米</span>
                                            @if($type == 'esfsale' || $type == 'bssale')
                                                <span class="price">
                                                    @if(!empty(floor($otherHouse->_source->price2)))
                                                        <span class="fontA colorfe">{{floor($otherHouse->_source->price2)}}</span>万
                                                     @else
                                                        面议
                                                     @endif
                                                </span>
                                            @else
                                                <span class="price">
                                                    @if(!empty(floor($otherHouse->_source->price2)))
                                                        <span class="fontA colorfe">{{floor($otherHouse->_source->price1)}}</span>元/月
                                                    @else
                                                        面议
                                                    @endif
                                                </span>
                                            @endif
                                        @else
                                            <span class="build_name">{{$otherHouse->_source->area}}平米</span>
                                            @if($type == 'spsale' || $type == 'xzlsale')
                                                <span class="price">
                                                   @if(!empty(floor($otherHouse->_source->price2)))
                                                        <span class="fontA colorfe">{{floor($otherHouse->_source->price2)}}</span>万
                                                    @else
                                                        面议
                                                    @endif
                                                </span>
                                            @else
                                                <span class="price">
                                                    @if(!empty($otherHouse->_source->price2))
                                                        <span class="fontA colorfe">{{$otherHouse->_source->price2}}</span>元/平米▪天
                                                    @else
                                                        面议
                                                    @endif
                                                </span>
                                            @endif
                                        @endif
                                    </dd>
                                </a>
                            </dl>
                        @endforeach
                    @else
                        <dl>暂无房源</dl>
                    @endif
                </div>
                @if(!empty($newBuilds))
                    <div class="recommend">
                        <p><a href="/new/area">新房推荐</a></p>
                        <ul>
                            @foreach($newBuilds as $newBuild)
                                <li>
                                    <a href="/xinfindex/{{$newBuild->_source->id}}/{{!empty($newBuild->_source->type2)?substr($newBuild->_source->type2,0,3):$type1.'01'}}.html" target="_blank">{{$newBuild->_source->name}}</a>
                                    @if(!empty($newBuild->_source->{$priceSaleAvg}))
                                        <span class="price"><span>{{$newBuild->_source->{$priceSaleAvg} }}</span>元/平米</span>
                                    @else
                                        <span class="price">待定</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div style="width: 1903px; height: 919px; display: none;" id="report" class="report">
            <div class="report_house" style="margin-left: 701.5px; margin-top: 309.5px;">
                <h2>楼盘纠错</h2>
                <span class="close1"></span>
                <dl>
                    <dt>举报类型（必填，可多选）：</dt>
                    <dd class="errorCheck">
                        <span class="span"><input type="checkbox" value="errorPrice">价格出错</span>
                        <span class="span"><input type="checkbox" value="errorCoordinates">地图标注出错</span>
                        <span class="span"><input type="checkbox" value="errorAddress">地址出错</span>
                        <span class="span"><input type="checkbox" value="errorName">名称出错</span>
                        <span class="span"><input class="errorOther" type="checkbox" value="errorOther">其他</span><input type="text" class="othererror" style="display:none">
                    </dd>
                </dl>
                <p class="p1">
                    <label>获取验证码：</label>
                    <input type="text" class="yzm txt width">
                    <span><img id="clickimg" title="点击刷新" src="/validateCode" align="absbottom" onclick="this.src='/validateCode?'+Math.random();"></span>
                </p>
                <p class="p1"><input type="button" value="提交" class="errorSub btn"></p>
            </div>
        </div>
    </div>
    <div class="fullScreen">
        <i class="close">关闭</i>
        <a class="f_left"></a>
        <a class="f_right"></a>
        <div class="pic_box">
            <img src="http://img.sf85.85/uploads/fmcommunity/waijing/20151230/22/7a6bfa6e781205efa83afb5d2cf1b2b3.jpg" alt="{{$house->name or ''}}">
            <span></span>
        </div>
    </div>
    @include('list.footer1',['sr'=>$sr,'type'=>$type])
     

    <script>
        function nofind(img){
            img.src="/image/noImage.png";
            img.onerror=null;
        }

        $(function(){
            $('body').keydown(function(event){
                if(event.keyCode == 27){
                    clo();
                }
            });
            var _token="{{csrf_token()}}";
            var comid="{{$house->communityId}}";
            $.post('/ajax/houseclick',{'url':window.location.href,'cid':comid,'_token':_token},function(d){
                //console.info(d);
            })
        });
        var g_communityid=$('#comid').val();
        var datatype='';
        var saleRent=$('#saleRent').val();
        var tempType2=$('#strType2').val();
        var room='2';
        var _token=$('input[name="_token"]').val();


        $(document).ready(function(e) {
            /* 自定义弹窗 */
            $("#report").css("width",$(window).width()+"px");
            $("#report").css("height",$(window).height()+"px");
            $("#report .report_house").css("margin-left",($(window).width()-500)/2+"px");
            $("#report .report_house").css("margin-top",($(window).height()-300)/2+"px");

            $("#report .close1").click(function(){
                $("#report").hide();
            });

            $(".jb a").click(function(){
                $("#report").show();
            });
            //其他错误原因
            $('.errorOther').click(function(){
                if($(this).attr('checked') == 'checked'){
                    $('.othererror').css('display','block');
                }else{
                    $('.othererror').css('display','none');
                }
            });
            $('.othererror').keyup(function(){
                if($(this).val().length > 10){
                    $(this).val($(this).val().substr(0,10));
                    alert('最多只能填写20个字符');
                }
            });
            //楼盘纠错提交
            {{--$('.errorSub').click(function(){--}}
                {{--var serror = {};--}}
                {{--var rnum = 0;--}}
                {{--$('.errorCheck input[type=checkbox]:checked').each(function(){--}}
                    {{--if($(this).val() !='errorOther'){--}}
                        {{--serror[$(this).val()] = 1;--}}
                    {{--}else{--}}
                        {{--serror['errorOther'] = $('.othererror').val();--}}
                    {{--}--}}
                    {{--rnum++;--}}
                {{--});--}}
                {{--if(rnum == 0){--}}
                    {{--alert('请选择举报类型');--}}
                    {{--return false;--}}
                {{--}--}}
                {{--if($('.yzm').val() == ''){--}}
                    {{--alert('请填写验证码');--}}
                    {{--return false;--}}
                {{--}--}}
                {{--serror['yzm'] = $('.yzm').val();--}}
                {{--if("{{$house->communityId}}" != ''){--}}
                    {{--serror['communityId'] = "{{$house->communityId}}";--}}
                {{--}--}}
                {{--$.ajax({--}}
                    {{--type: 'post',--}}
                    {{--url: '/errorCorrection',--}}
                    {{--data:serror,--}}
                    {{--success: function (data) {--}}
                        {{--if(data == 1){--}}
                            {{--alert('纠错成功');--}}
                            {{--$("#report .close1").click();--}}
                            {{--$('#clickimg').click();--}}
                        {{--}else if(data == 2){--}}
                            {{--alert('验证码填写错误');--}}
                            {{--$('#clickimg').click();--}}
                        {{--}else{--}}
                            {{--alert('纠错失败');--}}
                            {{--$('#clickimg').click();--}}
                        {{--}--}}
                        {{--$('.yzm').val('');--}}
                        {{--$('.errorCheck input[type=checkbox]:checked').each(function(){--}}
                            {{--if($(this).val() !='errorOther'){--}}
                                {{--$(this).attr('checked',false);--}}
                            {{--}else{--}}
                                {{--$(this).attr('checked',false);--}}
                                {{--$('.othererror').val('');--}}
                                {{--$('.othererror').hide();--}}
                            {{--}--}}
                        {{--});--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}

            $("#YG").click(function(){
                $(this).addClass("yuegong");
                $(this).next().show();
            });

            $("#yg_close").click(function(){
                $(this).parent().hide();
                $(this).parent().prev().removeClass("yuegong");
            });

            $(".sale a").click(function(){
                $(".sale a").removeClass("click");
                $(this).addClass("click");
                if($(this).text()=="出售"){
                    $('#saleRent').val('sale');
                    $(this).parents(".chart_tlt").find(".sale_list").show();
                    $(this).parents(".chart_tlt").find(".rent_list").hide();
                }else if($(this).text()=="出租")  {
                    $('#saleRent').val('rent');
                    $(this).parents(".chart_tlt").find(".sale_list").hide();
                    $(this).parents(".chart_tlt").find(".rent_list").show();
                }
                saleRent=$('#saleRent').val();
                room=defaultRoom(tempType2);
                getSalePrice(g_communityid,saleRent,tempType2,room);
            });

            $(".room .room_r a").click(function(){
                $(this).parent().find("a").removeClass("click");
                $(this).addClass("click");
                saleRent=$('#saleRent').val();
                room=getRoomByTag($(this).text());
                getSalePrice(g_communityid,saleRent,tempType2,room);

            });

            if (saleRent=="sale") {
                $(".sale a").first().click();
            }else
            {
                $(".sale a").last().click();
            }

//getSalePrice(g_communityid,saleRent,tempType2,room);
        });

        function defaultRoom(type2)
        {
            type2=parseInt(type2);
            if (type2>300) {
                if (type2>=304) {
                    return '3';
                }else
                {
                    return '2';
                }
            }else
            {
                return '0';
            }
        }

    </script>
    <script src="/js/detail.js?v={{Config::get('app.version')}}"></script>

    <script>
        //关注方法
        point_interest('focus','xcy');
    </script>top_r
   
    <script src="/js/jquery-1.7.min.js"></script>
    <script src="/js/specially/headNav.js"></script>
@if(!empty($houseImages))
    <script type="text/javascript" src="/js/plugs/jssor.slider.mini.js"></script>
    <script>
	jQuery(document).ready(function ($) {
	
	var jssor_1_options = {
	  $AutoPlay: true,
	  $ArrowNavigatorOptions: {
		$Class: $JssorArrowNavigator$
	  },
	  $ThumbnailNavigatorOptions: {
		$Class: $JssorThumbnailNavigator$,
		$Cols: 9,
		$SpacingX: 3,
		$SpacingY: 3,
		$Align: 260
	  }
	};
	
	var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);	
	
	jssor_1_slider.$CurrentIndex()
	//responsive code begin
	//you can remove responsive code if you don't want the slider scales while window resizing
	function ScaleSlider() {
		var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
		if (refSize) {
			refSize = Math.min(refSize, 600);
			jssor_1_slider.$ScaleWidth(refSize);
		}
		else {
			window.setTimeout(ScaleSlider, 300);
		}
	}
	ScaleSlider();
	$(window).bind("load", ScaleSlider);
	$(window).bind("resize", ScaleSlider);
	$(window).bind("orientationchange", ScaleSlider);
	//responsive code end
});

//全屏图片
  var fullMask=$('.fullScreen');
  var fullPic=$('.pic_box img');
  var fullPrev=$('.fullScreen .f_left');
  var fullRight=$('.fullScreen .f_right');
  var fullClose=$('.fullScreen .close');
  var sliderPic=$('.s_pic');
  var now=0;
	$('.pics').click(function(){
		fullMask.show();
		var _index=$(this).index();
		now=_index-1;
		fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
	});

  fullPrev.on('click',function(){
  	 now--;
  	 if(now<0){
	 	now=sliderPic.length-1;
	 }
	 fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
  });  
  //right
  fullRight.on('click',function(){
  	now++;
  	if(now>sliderPic.length-1){
	 	now=0;
	}
	fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
  }); 
  //close
	fullClose.on('click',function(){
	  	fullMask.hide();
	});
  //点击图片显示下一张
   fullPic.on('click',function(){
  	now++;
  	if(now>sliderPic.length-1){
	 	now=0;
	}
	fullPic.attr('src',sliderPic.eq(now).attr('data_src'));
  });  
  //esc
  $(document).on('keydown',function(ev){
  	if(ev.keyCode==27){
  		fullMask.hide();
  	}
  });
	</script>
@endif
    <script src="/js/highcharts/highcharts.js?v={{Config::get('app.version')}}"></script>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{config('mapApiKey.baidu')}}"></script>

    <script type="text/javascript">
    	//广告轮播
    	if($('.list_adv')){
			$('.list_adv').each(function(){
				tabs($(this).find('a'),$(this));
			});			
		}
		function tabs(obj,_this){
			var n=0;
			if(obj.length>1){
				setInterval(function(){
					n++;			
					if(n>obj.length-1){
						n=0;
					}
					obj.hide();
					obj.eq(n).show();
					
				},3000);
			}
		}
        $(function(){
            //经纬度
            var longitude = "{{$house->longitude}}";
            var latitude = "{{$house->latitude}}";
            if((longitude == 0) && (longitude == 0)){
                longitude = '116.405467';
                latitude = '39.907761';
            }
            // 百度地图API功能
            var map = new BMap.Map("allmap");    // 创建Map实例
            var point = new BMap.Point(longitude, latitude);
            map.centerAndZoom(point, 15);  // 初始化地图,设置中心点坐标和地图级别
            map.enableScrollWheelZoom(true);
            //街景地图
            var panoramaService = new BMap.PanoramaService();
            panoramaService.getPanoramaByLocation(point, function(data){
                var panoramaInfo="";
                if (data == null) {
                    $('.tab_l').hide();
                    return;
                }
                var panorama = new BMap.Panorama('quanjing');
                panorama.setPosition(point); //根据经纬度坐标展示全景图
                panorama.setPov({ heading: -40, pitch: 6 });
            });
//            $('.tab_l').click(function(){
//
//            });
            $('.tab_r').click(function(){
                var marker2 = new BMap.Marker(point);  // 创建标注
                map.addOverlay(marker2);
            }).trigger('click');
            //周边点击

            $('.chechData').bind('click',function(){
                var data1 = $(this).attr('attr');
                var data2 = $(this).text();
                chechData(data1,data2);
            });

            function chechData(data1,data2){
                $('#soukey').text(data2);
                $('.periphery_nav').hide();
                $('.periphery_build').show();
                map.clearOverlays();
                //楼盘位置
                curpos();
                $('.assort_nav').show();
                $('soukey').html('<i></i>'+data2);
                var circle = new BMap.Circle(point,1000,{fillColor:"blue", strokeWeight: 1 ,fillOpacity: 0.3, strokeOpacity: 0.3});
                map.addOverlay(circle);
                var local =  new BMap.LocalSearch(map, {renderOptions: {map: map, panel:"r-result", autoViewport: false},pageCapacity:5});
                local.searchNearby(data1,point,1000);
            }

            $('.curpos').click(function(){
                var c_name = "{{$house->name or '暂无'}}";
                var c_address = "{{$house->address or '暂无'}}";
                $(this).addClass("click");
                map.clearOverlays();
                //当前楼盘地址
                var marker2 = new BMap.Marker(point);  // 创建标注
                map.addOverlay(marker2);
                var opts = {
                    width : 100,     // 信息窗口宽度
                    height: 70,     // 信息窗口高度
                    title : "楼盘名：" + c_name , // 信息窗口标题
                    offset   : new BMap.Size(-5,-20)    //设置文本偏移量
                }
                var infoWindow = new BMap.InfoWindow("地址：" + c_address, opts);  // 创建信息窗口对象
                map.openInfoWindow(infoWindow,point); //开启信息窗口
                $('.assort_nav').hide();
            }).trigger('click');;
            //楼盘位置
            function curpos(){
                map.clearOverlays();
                //当前楼盘地址
                var marker2 = new BMap.Marker(point);  // 创建标注
                map.addOverlay(marker2);
                var opts = {
                    position : point,    // 指定文本标注所在的地理位置
                    offset   : new BMap.Size(-45,-50)    //设置文本偏移量
                }
                var label = new BMap.Label("&nbsp;当前楼盘位置&nbsp;", opts);  // 创建文本标注对象
                label.setStyle({
                    color : "red",
                    fontSize : "12px",
                    height : "20px",
                    lineHeight : "20px",
                    fontFamily:"微软雅黑"
                });
                map.addOverlay(label);
            }
        });
    </script>
    <script type="text/javascript">
        //价格走势
        function getRoomByTag(strTag)
        {
            if (strTag=='一居') {
                return '1';
            }else if(strTag=='二居')
            {
                return '2';
            }else if(strTag=='三居')
            {
                return '3';
            }else if(strTag=='四居')
            {
                return '4';
            }else if(strTag=='五居')
            {
                return '5';
            }else if(strTag=='六居')
            {
                return '6';
            }else if(strTag=='七居')
            {
                return '7';
            }else if(strTag=='八居')
            {
                return '8';
            }
            return '2';

        }

        function clickRoomTag(obj)
        {

            $(obj).parent().find("a").removeClass("click");
            $(obj).addClass("click");
            room=getRoomByTag($(obj).text());

            saleRent=$('#saleRent').val();

            getSalePrice(g_communityid,saleRent,tempType2,room);


        }

        function getSalePrice(g_communityid,saleRent,tempType2,room)
        {
            var type='1';
            if (saleRent=='sale') {
                type='2';
            }
            // var tempType2=$('#saleTagId .click').attr('id');

            $.post('/ajax/checkprice',{'comid':g_communityid,'type':type,'ctype2':tempType2,'_token':_token,'room':room},function(d){
                // console.info(d);
                if (saleRent=='sale') {
                    showCharts(d.title,d.time,d.price,'元/平米');
                }else
                {
                    showCharts(d.title,d.time,d.price,'元/月');
                }
                var roomTagHtml='';
                var beSelect=false;
                for (var i = 0;i<d.roomTags.length ; i++) {
                    if (d.curtRoom==d.roomTags[i]) {
                        beSelect=true;
                        roomTagHtml+='<a class="click" onClick="clickRoomTag(this)"><span>'+d.roomTags[i]+'</span><i></i></a>';
                    }else
                    {
                        roomTagHtml+='<a onClick="clickRoomTag(this)"><span>'+d.roomTags[i]+'</span><i></i></a>';
                    }

                }


                $('#tag_sale').html(roomTagHtml);

                if(!beSelect&&$('#tag_sale a').first().length>0)
                {
                    $('#tag_sale a').first().addClass('click');
                }


            },'json');

        }

        function showCharts (title,artime,arprice,tag) {
//function showRentMap (arTime,arPrice,priceTitle) {
            //console.info(arprice);
            $('#saleRoomPrice').html(title);
            //var priceTitle=title;
            $('#communityChart').html('');
            $('#communityChart').highcharts({
                title: { text:'', x: 0},
                // subtitle: { text: 'Source: WorldClimate.com', x: -20 },
                credits:enabled=false,
                xAxis: { categories: artime,
                    tickInterval: 1,
                    labels: {
                        formatter: function () {
                            return this.value.toString().substr(4,2)+"月";
                        }
                    }
                },
                yAxis: {
                    title: { text: null },
                    plotLines: [{ value: 0, width: 1, color: '#808080' }],
                    lineWidth: 1,
                    labels: {
                        formatter: function () {
                            return Highcharts.numberFormat(this.value,0,'.',',');
                        }
                    }


                },
                //colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655','#FFF263', '#6AF9C4'] ,
                tooltip: {
                    //valueSuffix: '元'
                    formatter: function () {
                        var tempvalue;
                        tempvalue = this.x.toString().substr(0,4)+'年'+this.x.toString().substr(4,2)+'月'+this.series.name + '<br/>' + this.y + ' '+tag;
                        return tempvalue;
                    }
                },
                legend: {
                    enabled: false,
                    layout: 'horizontal',
                    align: 'right',
                    verticalAlign: 'top',
                    // x: 250,
                    //y: 10,
                    borderWidth: 0,
                    //lineHeight: 30,

                },

                series:arprice
                // series: [
                // { name: 'Tokyo', data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 0, 9.6] },
                // { name: 'New York', data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5] },
                // { name: 'Berlin', data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0] },
                //  // { data: arPrice }
                //  ]

            });
        }
    </script>
    <script>
        $(document).ready(function(e) {
            $(".sale a").click(function () {
                $(".sale a").removeClass("click");
                $(this).addClass("click");
                if ($(this).text() == "出租") {
                    $(".a1").show();
                } else if ($(this).text() == "出售") {
                    $(".a1").show();
                }
            });

            $(".room a").click(function () {
                $(this).parent().find("a").removeClass("click");
                $(this).addClass("click");
            });
        });
    </script>
    @if($type == 'esfsale' || $type == 'bssale')
        <!--月供 end-->
        <script type="text/javascript">
            $(document).ready(function(e) {
                $("#YG").click(function(){
                    $(this).addClass("yuegong");
                    $(this).next().show();
                });

                $("#yg_close").click(function(){
                    $(this).parent().hide();
                    $(this).parent().prev().removeClass("yuegong");
                });
            });
            function GetShoufu(num) {
                //计算参考首付
                var shoufu = "{{$house->price2}}" * (10 - parseInt(num)) / 10;
                var s = shoufu.toFixed(2);
                $("#ShouFu").html(s);

            }

            ///计算月供
            //houseMoney：房屋总价
            //chengNum：按揭成数
            //rate：利率
            function CalculateYueG(houseMoney, chengNum, rate, month) {
                var a = houseMoney * chengNum * 1000 * rate / 12;
                var b = Math.pow((1 + rate / 12), month * 12);
                var x = a * b;
                var c = Math.pow((1 + rate / 12), month * 12);
                var y = c - 1;
                var yuegong = x / y;
                $("#yuegong").html(yuegong.toFixed(0));
            }

            function GetYueGong() {

                //月供=贷款总额*利率/12*(1+利率/12)贷款时长次幂/（(1+利率/12)贷款时长次幂-1）
                //commerceone  小于等于5年 商贷
                //commerceten  大于5年的   商贷
                //fundone      小于等于5年 公积金
                //fundten      大于5年的   公积金
                var appType = $("input[name='AppType']:checked").val();//贷款方式 1：商业贷，2：公积金
                var yearNum = $("#YearNum").val(); //年限
                var rateValue = $("#Rate").val(); //利率 Commerceone|Commerceten|fundone|Fundten
                var clos = rateValue.split('|');
                var chengNum = $("#ChengNum").val();
                if (appType == 1) {
                    if (yearNum <= 5) {
                        var rate = clos[0];
                        CalculateYueG('{{$house->price2}}', chengNum, rate, yearNum);
                    } else {
                        //大于5年
                        var rate = clos[1];
                        CalculateYueG('{{$house->price2}}', chengNum, rate, yearNum);
                    }
                } else {
                    if (yearNum <= 5) {
                        var rate = clos[2];
                        CalculateYueG('{{$house->price2}}', chengNum, rate, yearNum);
                    } else {
                        //大于5年
                        var rate = clos[3];
                        CalculateYueG('{{$house->price2}}', chengNum, rate, yearNum);
                    }
                }
            }

            $(function () {
                var chengNum = $("#ChengNum").val();
                GetShoufu(chengNum);
                GetYueGong();

                $("input[name='AppType']").bind("click", function () {
                    // alert($(this).val());
                    GetYueGong();
                });

                $("#frist").text($("#ShouFu").parent().text());
                $("#YG").find("span").text($("#yuegong").parent().text());
            });
            ///*表单验证*/
            //$("#BorrowMoney").blur(function () {
            //    VerifyBuyH();
            //});
            //$("#Name").blur(function () {
            //    VerifyBuyH();
            //});
            //$("#Phone").blur(function () {
            //    VerifyBuyH();
            //});
            //$("#VerifyCode").blur(function () {
            //    VerifyCodeVerify();
            //});
            ///*表单验证 end */
            ///按揭成数
            $("#ChengNum").change(function () {
                var chenNum = $("#ChengNum").val();
                GetShoufu(chenNum);
                GetYueGong();
            });

            ///利率
            $("#Rate").change(function () {
                GetYueGong();
            });

            $("#YearNum").change(function () {
                GetYueGong();
            });

        </script>
    @endif
<?php // 引入分享的js  ?>
@include('layout.share')
@endsection