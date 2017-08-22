<?php //\App\Http\Controllers\Utils\RedisCacheUtil::initOrCacheWholeTableYouChosen(DB_NAME,'city',CITY);    ?>
<?php //$cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->forget(CITY); // 清除城市数据的缓存   ?>

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
<div class="nav_bg">
    <div class="nav clearfix"> 
        <div class="cur_city js-tab fl">
        	<i class="local fl"></i>
            <span class="fl js-cur">{{CURRENT_CITYNAME}}<i class="tab"></i></span>            
            <div class="hotcity">
                <h6>热门城市</h6>
                <ul>
                    @for($i = 0, $n = 0; $i < $countCityObject; $i++) @if($cityObjectAll[$i]['isHot'] == 1)
                        <li><a href="http://{{$cityObjectAll[$i]['py']}}.{{$GLOBALS['current_listurl']}}">{{$cityObjectAll[$i]['name']}}</a></li>
                        <?php $n++; ?>
                    @else
                        <?php continue; ?>
                    @endif  @if( ($n > 0) && ($n % 6 == 0) && ($n < 18))
                </ul>
                <ul>
                    @endif @endfor
                    <li><a class="color_blue" href="/city.html">更多>></a></li>
                </ul>
            </div>
        </div>
        <div class="fl search">
        	<div class="cur_type fl">
        		<span class="js-curtype"><b>二手房</b><i class="tab"></i></span>
        		<ul class="search_nav">
                    <li class="-search" tp="sale" id="con_home_3"><b>二手房</b></li>{{--onClick="setContentTab('home',3)"--}}
                    <li class="-search" tp="rent" id="con_home_4"><b>租房</b></li>{{--onClick="setContentTab('home',4)"--}}
	                <li class="-search" tp="new" id="con_home_2"><b>新房</b></li>{{--onClick="setContentTab('home',2)"--}}
	                <li class="-search" tp="xzl" id="con_home_5"><b>写字楼</b></li>{{--onClick="setContentTab('home',5)"--}}
	                <li class="-search" tp="sp" id="con_home_6"><b>商铺</b></li>{{--onClick="setContentTab('home',6)"--}}
	                <li class="-search" tp="loupan" id="con_home_1"><b>查房价</b></li>{{--onClick="setContentTab('home',1)"--}}
	                <li onclick="window.location.href='/map/sale/house'"><b>地图搜房</b></li>
	                <li class="icon"></li>
	           </ul>
        	</div>
        	<div class="txt_cont fl">
        		<input type="text" class="txt searchInput" tp="sale" id="con_home_3" autocomplete="off" placeholder="请输入关键字（楼盘名或地点）？"/>
        		<ul>
		        </ul>
        	</div>
	        <input type="button" class="soufang fl ss" value="搜索">
        </div>       
        <div class="download fr">
            <dl class="fl">
            	<dt><a href="/about/download.html">搜房app下载</a></dt>
            	<dd>买卖房源更方便</dd>
            </dl>
            <div class="app fr">
               <a href="/about/download.html "></a>
            </div>
        </div>
    </div>
</div>
<form action="/esfsale" id="search_Submit" method="get">
    <input type="hidden" id="search_Intro" name="kw" value="">
</form>
<form action="/checkpricelist" id="checkprice" method="post">
    <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
    <input type="hidden" class="checkpricelist" tp="loupan" AutoComplete="off" name="kw" value="" >
</form>
<!-- 提过提交  end   -->
<script src="{{$theme}}/js/index.js?v={{Config::get('app.version')}}"></script>
<script>
    //切换城市
    var curCity=$('.js-cur');
    var hotCity=$('.hotcity');
    var timer=null;
    curCity.on('mouseover',function(){
        clearTimeout(timer);
        hotCity.show();
        curCity.addClass('cur');
    });
    curCity.on('mouseout',function(){
        timer=setTimeout(function(){
            hotCity.hide();
            curCity.removeClass('cur');
        },50);
    });
    hotCity.on('mouseover',function(){
        clearTimeout(timer);
    });
    hotCity.on('mouseout',function(){
        timer=setTimeout(function(){
            hotCity.hide();
            curCity.removeClass('cur');
        },50);
    });
//搜索类型切换
	var searchNav=$('.search_nav');
	$('.cur_type').on('mouseenter',function(){
		searchNav.show();
	});
	$('.cur_type').on('mouseleave',function(){
		searchNav.hide();
	});
	var choose=$('.search_nav li');
	for(var i=0;i<choose.length-2;i++){
		choose.eq(i).on('click',function(){
			$('.cur_type span b').html($(this).html());
			$(this).parent().hide();
		});
	}
	
	
  /***  搜索提交  start  ***/
  $('.ss').click(function(){
      var val = $(this).prev().find('input').eq(0).val();
      var id = $(this).prev().find('input').eq(0).attr('id').replace('con_home_', '');
      if(id==1){
          $('.checkpricelist').val(val);
          $('#checkprice').submit();
          return;
      }
      $('#search_Intro').val(val);
      var obj = {};
      obj.val = val;
      obj.name = 'search' + id ;
//      lastSearch(obj);
      var elements = $('#search_Intro');
      if($.trim(elements.val()) == ''){
          elements.remove();
      }
      $('#search_Submit').submit();
  });

</script>