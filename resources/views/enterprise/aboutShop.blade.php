<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>关于店铺</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" type="text/css" href="css/aboutShop.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="css/common.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="css/color.css?v={{Config::get('app.version')}}">
</head>
<body>
    @include('layout.header')
<!--<script type="text/javascript" src="js/header.js?v={{Config::get('app.version')}}"></script>-->
<div class="company_shop">
 <div class="flexslider callbacks_container">
	<ul class="slides" id="slider">
            @if(!empty($focusComm))
                @foreach($focusComm as $focus)                    
                    <li>
                      @if(!empty($images))
                       <?php $tem = false; ?>
                        @foreach($images as $img)
                          @if(isset($focus->_source) && $img->communityId == $focus->_source->id)
                          <a><img src="{{$img->fileName}}"></a>
                          <?php $tem = true; ?>
                          @endif
                        @endforeach
                        {!!($tem)?'': '<a><img src="" /></a>'!!}
                      @else
                      <a><img src=""></a>
                      @endif
                      <div class="home_detail">
                       <p class="p1"><a>{{$focus->_source->name}}</a><span>[{{$focus->_source->cityName}}]</span></p>
                       <p class="p2">@if(isset($focus->_source->salesStatus)) @if($focus->_source->salesStatus[0]->salesStatus == 0)待售@elseif($focus->_source->salesStatus[0]->salesStatus == 1)在售@else售完@endif @endif&nbsp;&nbsp;{{$focus->_source->loopName}}&nbsp;&nbsp;平均价：{{$focus->_source->avgPrice}}元/平米</p>
                      </div>
                    </li>                     
                @endforeach
            @endif
	</ul>
 </div>
 <div class="company_logo">
   <p class="logo"><img src="{{$shopInfo[0]->logo}}" width="250" height="120" ></p>
   <ul>
     <li class="company_introduce">{{$shopInfo[0]->intro}}</li>
     <li class="company_info">
       <dl>
         <dt class="broker"><img src="image/fp_08.png"></dt>
         <dd>{{$shopInfo[0]->brokerTotal}}位置业顾问</dd> 
       </dl>
       <dl>
         <dt class="build"><img src="image/fp_03.png"></dt>
         <dd>{{$shopInfo[0]->communityTotal}}个精选楼盘</dd> 
       </dl>
     </li>
   </ul>
 </div>
</div>
<div class="company_build">
  <h2>全部楼盘</h2>
   @if(!empty($allComm))
    @foreach( $allComm as $key => $all)
        @if($key == 0)
        <div class="build_list">
        @endif
        <dl>
          <dt>
          @if(!empty($images))
            <?php $temp = false; ?>
            @foreach($images as $ikey => $img)
             @if(!empty($all->_source) && $img->communityId == $all->_source->id)
              <a><img src="{{$img->fileName}}" /></a>              
              <?php $temp = true; ?>
             @endif
            @endforeach
            {!!($temp)?'': '<a><img src="" /></a>'!!}
          @else
           <a><img src="" /></a>
          @endif
            <div class="home_detail">
             <p class="p1"><a>{{$all->_source->name}}</a><span>[{{$all->_source->cityName}}]</span></p>
             <p class="p2">@if(!empty($all->_source->salesStatus)) @if($all->_source->salesStatus[0]->salesStatus == 0)待售@elseif($all->_source->salesStatus[0]->salesStatus == 1)在售@else售完@endif @endif&nbsp;&nbsp;{{$all->_source->loopName}}&nbsp;&nbsp;平均价：{{$all->_source->avgPrice}}元/平米</p>
            </div>
          </dt>
        </dl>
        @if( ($key+1) % 3 == 0)
            @if($key+1 != count($allComm))
            </div>
            <div class="build_list">
            @endif
        @endif
        @if($key+1 == count($allComm))
        </div>
        @endif
    @endforeach
   @endif
</div>
<script src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
    @include('layout.footer')
<!--<script src="js/footer.js?v={{Config::get('app.version')}}"></script>-->
<script src="js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>
<script src="js/PageEffects/bannerAdv.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
window.onload = function () {
  // Slideshow 
	$("#slider").responsiveSlides({
		auto: true,
		pager: false,
		nav: true,
		speed: 500,
		timeout:4000,
		pager: true, 
		pauseControls: true,
		namespace: "callbacks"
	});
};
</script>
</body>
</html>