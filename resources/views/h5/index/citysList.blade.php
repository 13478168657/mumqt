<?php  //\App\Http\Controllers\Utils\RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'city',CITY);   ?>
<?php  //$cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->forget(CITY); // 清除城市数据的缓存  ?>

<?php  \App\Http\Controllers\Utils\RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'city',CITY);  ?>
<?php  $cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->get(CITY); ?>
<?php
	$countCityObject = count($cityObjectAll);

	$mainCity = array();
	foreach($cityObjectAll as $val){
		if($val['priority'] == 2){
			$words = substr($val['py'], 0, 1);
			$mainCity[$words][] = $val;
		}
	}
?>
@extends('h5.mainlayout')
@section('title')
<title>搜房家族</title>
@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="/h5/css/city.css"/>
<script src="/h5/js/zepcity.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
<!--========================城市切换开始===============================-->
<!--=========header开始===========-->
<div class="city_header">
    <div class="city_return fl"><a href="/"></a></div>
    <h3 class="city_Htit fl">选择城市</h3>
</div>
<!--=========header结束===========-->
<div class="space24"></div>
<div class="city_main">
    <!--=========search开始===========-->
    <div class="city_search">
        <i class="search_btn ps" id="search_btn"></i>
        <input type="text" name="text" id="search" placeholder="城市/拼音" class="search" />
        <input type="hidden" id="crtoken" name="crtoken" value="{{csrf_token()}}" />
    </div>			
    <!--=========search结束===========-->
    <!--=========城市选择开始===========-->
    <hgroup class="city_List">
        <h2>当前城市</h2>
        <a href="http://{{$currentCity[0]['py']}}.{{config('session.domain')}}"><h5>{{ $currentCity[0]['name'] }}</h5></a>
        <h2>热门城市</h2>
        @foreach($hotCitys as $hot)
            <a href="http://{{$hot[0]['py']}}.{{config('session.domain')}}"><h4>{{$hot[0]['name']}}</h4></a>
        @endforeach
        <h2 id="A1">A</h2>
        @if(!empty($mainCity['a']))
        @foreach($mainCity['a'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="B1">B</h2>
        @if(!empty($mainCity['b']))
        @foreach($mainCity['b'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="C1">C</h2>
        @if(!empty($mainCity['c']))
        @foreach($mainCity['c'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="D1">D</h2>
        @if(!empty($mainCity['d']))
        @foreach($mainCity['d'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="E1">E</h2>
        @if(!empty($mainCity['e']))
        @foreach($mainCity['e'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="F1">F</h2>
        @if(!empty($mainCity['f']))
        @foreach($mainCity['f'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="G1">G</h2>
        @if(!empty($mainCity['g']))
        @foreach($mainCity['g'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="H1">H</h2>
        @if(!empty($mainCity['h']))
        @foreach($mainCity['h'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="J1">J</h2>
        @if(!empty($mainCity['j']))
        @foreach($mainCity['j'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="M1">M</h2>
        @if(!empty($mainCity['m']))
        @foreach($mainCity['m'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="N1">N</h2>
        @if(!empty($mainCity['n']))
        @foreach($mainCity['n'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="P1">P</h2>
        @if(!empty($mainCity['p']))
        @foreach($mainCity['p'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="Q1">Q</h2>
        @if(!empty($mainCity['q']))
        @foreach($mainCity['q'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="R1">R</h2>
        @if(!empty($mainCity['r']))
        @foreach($mainCity['r'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="S1">S</h2>
        @if(!empty($mainCity['s']))
        @foreach($mainCity['s'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="T1">T</h2>
        @if(!empty($mainCity['t']))
        @foreach($mainCity['t'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="W1">W</h2>
        @if(!empty($mainCity['w']))
        @foreach($mainCity['w'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="X1">X</h2>
        @if(!empty($mainCity['x']))
        @foreach($mainCity['x'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="Y1">Y</h2>
        @if(!empty($mainCity['y']))
        @foreach($mainCity['y'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
        <h2 id="Z1">Z</h2>
        @if(!empty($mainCity['z']))
        @foreach($mainCity['z'] as $val)
            <a href="http://{{$val['py']}}.{{config('session.domain')}}"><h4>{{$val['name']}}</h4></a>
        @endforeach
        @endif
    </hgroup>
    <!--=========城市选择结束===========-->
    <!--=========字母搜索开始===========-->
    <ul class="zimu">
        <li><a href="javascript:;">A</a></li>
        <li><a href="javascript:;">B</a></li>
        <li><a href="javascript:;">C</a></li>
        <li><a href="javascript:;">D</a></li>
        <li><a href="javascript:;">E</a></li>
        <li><a href="javascript:;">F</a></li>
        <li><a href="javascript:;">G</a></li>
        <li><a href="javascript:;">H</a></li>
        <li><a href="javascript:;">J</a></li>
        <li><a href="javascript:;">M</a></li>
        <li><a href="javascript:;">N</a></li>
        <li><a href="javascript:;">P</a></li>
        <li><a href="javascript:;">Q</a></li>
        <li><a href="javascript:;">R</a></li>
        <li><a href="javascript:;">S</a></li>
        <li><a href="javascript:;">T</a></li>
        <li><a href="javascript:;">W</a></li>
        <li><a href="javascript:;">X</a></li>
        <li><a href="javascript:;">Y</a></li>
        <li><a href="javascript:;">Z</a></li>
        <li><a href="javascript:;" id="top" onclick="scrollTo(0, 0)">#</a></li>
    </ul>
    <!--=========字母搜索结束===========-->
</div>
<div class="zimu_box"></div>
<div class="checkBox">
    <ul id='search_list'>
        <li><a href="##">北京</a></li>
    </ul>
</div>
<!--========================城市切换结束===============================-->
<script type="text/javascript">
    $(document).ready(function() {
        $('body').on('click', '.zimu > li > a', function() {
            var s = $(this).html();
            $(window).scrollTop($('#' + s + '1').offset().top - 101);
        });
    })

</script>
<script type="text/javascript">
    $("#search").keyup(function(){
        var city_name = $.trim($("#search").val());
        var crtoken = $('#crtoken').val();
        var session_domain = "{{config('session.domain')}}";
        var city_py = '';
        if(city_name == ''){
            $('.checkBox').css('display', 'none');
            return false;
        }
        if((/[\u4E00-\u9FA5]+/.test(city_name) && /[A-Za-z]+/.test(city_name)) || /\d+/.test(city_name)){
            return false;
        }
        $.ajax({
           type: "POST",
           url: '/city/citysName',
           data: {
               _token: crtoken,
               city: city_name,
           },
           dataType: 'json',
           success: function(msg){
               if(msg != 2){
                    for(var i in msg){
                        city_py += '<li><a href="'+'http://'+msg[i].py+'.'+session_domain+'" class="click_dd" value="'+msg[i].py+'">'+msg[i].name+'</a></li>';
                    }
                    $('#search_list').html(city_py);
                    $('.checkBox').css('display', 'block');
                    $('.click_dd').click(function() {
                        $('#search').val('');
                        //$('#click_value').val($(this).attr('value'));
                        $('.checkBox').css('display', 'none');
                    });
                }                           
           }
        });        
    });
</script>
@endsection
