<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>经纪人列表</title>
    <link rel="stylesheet" type="text/css" href="/css/submenu.css">
    <link rel="stylesheet" type="text/css" href="/css/color.css">
    <link rel="stylesheet" type="text/css" href="/css/broker.css">

</head>
<body>
<?php \App\Http\Controllers\Utils\RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME, 'city', CITY); ?>
<?php $cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->get(CITY); ?>
<?php
$countCityObject = count($cityObjectAll);

$mainCity = array();
foreach ($cityObjectAll as $val) {
    if ($val['priority'] == 2) {
        $words = substr($val['py'], 0, 1);
        $mainCity[$words][] = $val;
    }
}
?>

<div class="header clearfix">
    <div class="head clearfix">
        <dl>
            <dt><a href="/"><img src="/image/brokerlogo.png" alt="搜房网"></a></dt>
            <dd>
                <a class="city_title"><span>北京</span><i></i></a>
                <div class="hot_city" style="display:none;">
                    <h5>热门城市</h5>

                        <ul>
                            @for($i = 0, $n = 0; $i < $countCityObject; $i++) @if($cityObjectAll[$i]['isHot'] == 1)
                                @if($n  == 0 )
                                <li ><a href="http://{{$cityObjectAll[$i]['py']}}.{{$GLOBALS['current_listurl']}}">{{$cityObjectAll[$i]['name']}}</a>
                                </li>
                                @elseif(($n > 0) && ($n % 6 == 0))
                                    <li ><a href="http://{{$cityObjectAll[$i]['py']}}.{{$GLOBALS['current_listurl']}}">{{$cityObjectAll[$i]['name']}}</a></li>
                                @endif
                                <?php $n++; ?>
                            @else
                                <?php continue; ?>
                            @endif  @if( ($n > 0) && ($n % 6 == 0) && ($n < 18))
                        </ul>
                        <ul>
                            @endif @endfor
                        </ul>
                    </div>
            </dd>
        </dl>

        <ul class="subnav">
            <li><a href="/">首页</a></li>
            <li><a href="/esfsale/area">二手房</a></li>
            <li><a href="/esfrent/area">租房</a></li>
            <li><a href="/new/area">新房</a></li>
            <li><a href="/xzlrent/area">写字楼</a></li>
            <li><a href="/sprent/area">商铺</a></li>
            <li><a href="/bsrent/area">豪宅别墅</a></li>
            <li><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&usrChannel=15&usrWay=1">理财</a></li>
            <li><a href="{{config('hostConfig.baike_host')}}/index.php?list-property">百科</a></li>
        </ul>
        <div class="top_r">
            @if(!Auth::check())
                <div class="top_r">
                    <a class="modaltrigger color8d" onclick="lo()" href="#login">登录</a>
                    <span class="dotted"></span> <a class="modaltrigger color8d"
                                                    onclick="regs()" href="#register">注册</a> <a
                            href="{{config('hostConfig.agr_host')}}/majorLogin" style="margin-left: 40px;">经纪人登录</a>
                </div>
            @else
                <div class="top_r">
                    @if(Auth::user()->type == 1)
                        @if(Auth::user()->userName=='')
                            <a class="modaltrigger" href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/myinfo/userSet"> {{substr_replace(Auth::user()->mobile,'****',3,4)}}</a>
                        @else
                            <a class="modaltrigger" href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/user/interCommunity/xinF"> {{Auth::user()->userName}}</a>
                        @endif
                    @else
                        <a class="modaltrigger" href="{{config('hostConfig.agr_host')}}/majorLogin"><?= (Auth::user()->userName == '') ? substr_replace(Auth::user()->mobile, '****', 3, 4) : Auth::user()->userName ?></a>
                    @endif
                    <span class="dotted"></span> <a href="/logout"> 退出</a>
                </div>
            @endif
        </div>
    </div>
</div>

