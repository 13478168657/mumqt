@extends('mainlayout')
@section('title')
<title>搜房家族</title>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/aboutUs.css?v={{Config::get('app.version')}}">
<div class="city_main">
    <!--<div class="banner"><img src="image/ad.jpg"></div>-->
    <div class="city_top">
        <p class="city_title subway">我们猜您可能在{{$currentCity[0]['name']}}，点击进入：<a href="http://{{$currentCity[0]['py']}}.{{config('session.domain')}}" class="color_blue"><strong>{{$currentCity[0]['name']}}站</strong></a></p>
        <p class="hot_city">
            <span>热门城市：</span>
            @foreach($hotCitys as $hot)
            <a href="http://{{$hot[0]['py']}}.{{config('session.domain')}}">{{$hot[0]['name']}}</a>
            @endforeach
            <!-- <a href="#">广州</a>
            <a href="#">天津</a>
            <a href="#">杭州</a>
            <a href="#">重庆</a>
            <a href="#">武汉</a>
            <a href="#">青岛</a>
            <a href="#">郑州</a>
            <a href="#">上海</a>
            <a href="#">深圳</a>
            <a href="#">苏州</a>
            <a href="#">成都</a>
            <a href="#">南京</a>
            <a href="#">大连</a>
            <a href="#">西安</a>
            <a href="#">长沙</a> -->
        </p>
    </div>
    <div class="city_search">
        <div class="search">
            <input id="search_value" value="" type="text" class="txt" onkeyup="setTimeout(search, 200)" placeholder="请输入你要查找的城市名或拼音...">
            <dl id="search_list" style="display: none;">
                <dd>安徽</dd>
            </dl>
            <input id="click_value" type="hidden">
            <input id="search" type="button" class="btn back_color" value="搜索">
            <span style="color: red;"></span>
            <div class="choice_city">
                <span class="tlt">你还可以：</span>
                <div class="choice">
                    <a class="province"><span id="pro_text" value="">省份</span><i></i></a>
                    <div class="choice_msg" style="left:0;">
                        <p class="top_icon" style="left:-120px; right:0;"></p>
                        <ul>
                            @foreach($proOrder as $pro)
                            <li class="pro_click" value="{{$pro->id}}">{{$pro->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="choice">
                    <a class="province"><span id="cityText" value="">城市</span><i></i></a>
                    <div class="choice_msg">
                        <p class="top_icon"></p>
                        <ul class="cityList">
                            <li>请选择省份</li>
                        </ul>
                    </div>
                </div>
                <input type="button" id="pro_city" class="btn back_color" value="确定">
                <span style="margin-left: 10px;color: red;"></span>
            </div>
        </div>
        <div class="all_city">
            <p class="city_nav">
                <a class="click">按省份选择</a>
                <a>按拼音首字母选择</a>
            </p>
        </div>
        <div class="all all1">
            <ul>
                <li>
                    <span class="letter">&nbsp;</span>
                    <span class="province">直辖市</span>
                    <p class="city_list">
                        <a href="http://bj.{{config('session.domain')}}" class="colorfe">北京</a>
                        <a href="http://sh.{{config('session.domain')}}" class="colorfe">上海</a>
                        <a href="http://tj.{{config('session.domain')}}" class="colorfe">天津</a>
                        <a href="http://cq.{{config('session.domain')}}" class="colorfe">重庆</a>
                    </p>
                </li>
                @foreach($proKeyPy as $keyp => $proK)
                @if(count($proK) > 1)
                @foreach($proK as $key1 => $pro)
                <li>
                    @if($key1 == 0)
                    <span class="letter">{{$keyp}}</span>  
                    @else
                    <span class="letter">&nbsp;</span> 
                    @endif
                    <span class="province">{{$pro->name}}</span>
                    <p class="city_list">
                        @foreach($cityKeyProId as $keyPid => $city)
                        @if($pro->id == $city->provinceId)
                        <a href="http://{{$city->py}}.{{config('session.domain')}}">{{$city->name}}</a> 
                        @endif
                        @endforeach
                    </p>                        
                </li>
                @endforeach 
                @else
                @foreach($proK as $key1 => $pro)
                <li>
                    <span class="letter">{{$keyp}}</span>  
                    <span class="province">{{$pro->name}}</span>
                    <p class="city_list">
                        @foreach($cityKeyProId as $keyPid => $city)
                        @if($pro->id == $city->provinceId)
                        <a href="http://{{$city->py}}.{{config('session.domain')}}">{{$city->name}}</a> 
                        @endif
                        @endforeach
                    </p>                        
                </li>
                @endforeach
                @endif
                @endforeach

                <li>
                    <span class="letter">&nbsp;</span>
                    <span class="province">其它</span>         
                    <p class="city_list">
                        @foreach($qitaArr as $qita)
                        <a href="http://{{$qita->pinyin}}.{{config('session.domain')}}">{{$qita->name}}</a>
                        @endforeach
                    </p>        
                </li>
            </ul>
        </div>
        <div class="all all2" style="display:none;">
            <ul>
                @foreach($cityPy as $ctyK => $cty)
                <li>
                    <span class="letter">{{$ctyK}}</span>
                    <p class="city_list">
                        @foreach($cty as $c)
                        <a href="http://{{$c->py}}.{{config('session.domain')}}">{{$c->name}}</a>
                        @endforeach        
                    </p>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>
<input type="hidden" id="crtoken" name="crtoken" value="{{csrf_token()}}">
<input type="hidden" id="hou_zui" name="crtoken" value="{{config('session.domain')}}">
<!-- <script src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script> -->
<script>
    $(document).ready(function() {
        $(".choice_city .choice").click(function(event) {
            $(".choice_msg").hide();
            $(this).find(".choice_msg").fadeIn();
            $(document).one("click", function() {//对document绑定一个影藏Div方法
                $(".choice_msg").hide();
            });
            event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
        });
        $(".choice_msg").click(function(event) {
            event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
        });

        $(".choice li").click(function() {
            $(this).parents(".choice").find(".choice_msg").hide();
            $(this).parents(".choice").find(".province span").text($(this).text());
        });
        $(".city_nav a").click(function() {
            $(".city_nav a").removeClass("click");
            $(this).addClass("click");
            if ($(this).text() == "按省份选择") {
                $(".all1").show();
                $(".all2").hide();
            } else {
                $(".all2").show();
                $(".all1").hide();
            }
        });
    });

// 根据省份获得城市
    $('li.pro_click').click(get_city);
    function get_city() {
        var proId = $(this).attr('value');
        var crtoken = $('#crtoken').val();
        var cityList = '';
        $.ajax({
            type: 'POST',
            url: '/city/getcity',
            data: {
                _token: crtoken,
                id: proId,
                type: 1
            },
            dataType: 'json',
            success: function(msg) {
                if (msg != 2) {
                    for (var i in msg) {
                        cityList += '<li class="getcity" value="' + msg[i].py + '">' + msg[i].name + '</li>'
                    }
                    $('.cityList').html(cityList);
                    $('.getcity').click(function() {
                        $('#cityText').text($(this).text());
                        $('#cityText').attr('value', $(this).attr('value'));
                        $('.cityList').parent().hide();
                    });
                }
            }
        });
    }

// 点击确定
    $('#pro_city').click(function() {
        var pro_text = $('#pro_text').text();
        if (pro_text == '省份') {
            $(this).next().text('请选择省份');
            return false;
        }
        var city_text = $('#cityText').text();
        if (city_text == '城市') {
            $(this).next().text('请选择城市');
            return false;
        }
        $(this).next().text('');
        var city_zimu = $('#cityText').attr('value');
        var hou_zui = $('#hou_zui').val();
        window.location.href = 'http://' + city_zimu + '.' + hou_zui;
    });

    // 搜索框搜索城市
    function search() {
        var city_name = $.trim($('#search_value').val());
        var crtoken = $('#crtoken').val();
        var city_py = '';
        if ((/[\u4E00-\u9FA5]+/.test(city_name) && /[A-Za-z]+/.test(city_name)) || /\d+/.test(city_name)) {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '/city/citysName',
            data: {
                _token: crtoken,
                city: city_name,
            },
            dataType: 'json',
            success: function(msg) {
                if (msg != 2) {
                    for (var i in msg) {
                        city_py += '<dd class="click_dd" value="' + msg[i].py + '">' + msg[i].name + '</dd>'
                    }
                    $('#search_list').html(city_py);
                    $('#search_list').css('display', 'block');
                    $('.click_dd').click(function() {
                        $('#search_value').val($(this).text());
                        $('#click_value').val($(this).attr('value'));
                        $('#search_list').css('display', 'none');
                    });
                } else {
                    $('#search_list').hide();
                }
            }
        });
    }
    $('#search').click(function() {
        var qian = $(this).prev().val();
        if (qian == '') {
            $(this).next().text('暂无此城市');
            return false;
        }
        var hou_zui = $('#hou_zui').val();
        window.location.href = 'http://' + qian + '.' + hou_zui;
    });
</script>
@endsection
