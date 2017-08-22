@extends('mainlayout')
@section('title')
<title>【{{CURRENT_CITYNAME}}{{$commName}}户型信息,二手房,租房】-搜房网</title>
<meta name="Keywords" content="{{$commName}},{{$commName}}租房,{楼盘名}二手房" />
<meta name="Description" content="{{$commName}}为您提供多方位信息，小区交通、周边、学校等详情，小区外景图、户型图、交通图、配套图，小区租售价格走势，小区二手房源、租房房源。" />
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="/css/buildDetail.css?v={{Config::get('app.version')}}">
@include('esf.search')
<div class="detail esf_detail">
  @include('esf.left')
  <div class="hx_nav">
    <p class="nav_msg">
      <a @if(empty($roomtype)) class="color_blue" @endif id="a1" onclick="setContentTab('a',1)">全部户型(@if(!empty($viewShowInfo['room1Tota'])) {{$viewShowInfo['room1Tota']}} @else 0 @endif)</a>
      <span></span>
      <a @if($roomtype == 2) class="color_blue" @endif id="a2" onclick="setContentTab('a',2)">2室户型（@if(!empty($viewShowInfo['room2Tota'])) {{$viewShowInfo['room2Tota']}} @else 0  @endif）</a>
      <span></span>
      <a @if($roomtype == 3) class="color_blue" @endif id="a3" onclick="setContentTab('a',3)">3室户型（@if(!empty($viewShowInfo['room3Tota'])) {{$viewShowInfo['room3Tota']}} @else 0  @endif）</a>
      <span></span>
      <a @if($roomtype == 4) class="color_blue" @endif id="a4" onclick="setContentTab('a',4)">4室户型（@if(!empty($viewShowInfo['room4Tota'])) {{$viewShowInfo['room4Tota']}} @else 0  @endif）</a>
      <span></span>
      <a @if($roomtype == 5) class="color_blue" @endif id="a5" onclick="setContentTab('a',5)">5室户型（@if(!empty($viewShowInfo['room5Tota'])) {{$viewShowInfo['room5Tota']}} @else 0  @endif）</a>
    </p>
    <div class="home_nav" id="con_a_1">
      <div id="btn-left" class="arrow-btn dasabled"></div>
      <div class="slider">
        <ul>
        @if(!empty($commRoom))
          @foreach($commRoom as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
              <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
              <span>约{{$room->floorage}}平米</span>
            </a>
            <input type="hidden" name="room" value="{{$room->room}}">
            <input type="hidden" name="name" value="{{$room->name}}">
            <input type="hidden" name="thumbPic" value="{{$room->thumbPic}}">
            <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
            <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
            <input type="hidden" name="num" value="{{$room->num}}">
            <input type="hidden" name="floorage" value="{{$room->floorage}}">
            <input type="hidden" name="price" value="{{$room->price}}">
            <input type="hidden" name="feature" value="{{$room->feature}}">
            <input type="hidden" name="roomNum" value="{{$viewShowInfo['roomNum']}}">
            <input type="hidden" name="minPrice2" value="{{$viewShowInfo['minPrice2']}}">
            <input type="hidden" name="maxPrice2" value="{{$viewShowInfo['maxPrice2']}}">
            <input type="hidden" name="rentNum" value="{{$viewShowInfo['rentNum']}}">
            <input type="hidden" name="minPrice1" value="{{$viewShowInfo['minPrice1']}}">
            <input type="hidden" name="maxPrice1" value="{{$viewShowInfo['maxPrice1']}}">
          </li>
          @endforeach
        @else
          <li>
            <a>
              <span style="color:red;">楼盘暂无</span>
              <span style="color:red;">户型信息</span>
            </a>
          </li>
        @endif
        </ul>
      </div>
      <div id="btn-right" class="arrow-btn"></div>
    </div>
    <div class="home_nav" id="con_a_2" style="display:none">
      <ul>
        @if(!empty($room2))
          @foreach($room2 as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
              <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
              <span>约{{$room->floorage}}平米</span>
            </a>
            <input type="hidden" name="room" value="{{$room->room}}">
            <input type="hidden" name="name" value="{{$room->name}}">
            <input type="hidden" name="thumbPic" value="{{$room->thumbPic}}">
            <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
            <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
            <input type="hidden" name="num" value="{{$room->num}}">
            <input type="hidden" name="floorage" value="{{$room->floorage}}">
            <input type="hidden" name="price" value="{{$room->price}}">
            <input type="hidden" name="feature" value="{{$room->feature}}">
            <input type="hidden" name="roomNum" value="{{$houseRoom2['roomNum']}}">
            <input type="hidden" name="minPrice2" value="{{$houseRoom2['minPrice2']}}">
            <input type="hidden" name="maxPrice2" value="{{$houseRoom2['maxPrice2']}}">
            <input type="hidden" name="rentNum" value="{{$houseRent2['roomNum']}}">
            <input type="hidden" name="minPrice1" value="{{$houseRent2['minPrice1']}}">
            <input type="hidden" name="maxPrice1" value="{{$houseRent2['maxPrice1']}}">
          </li>
          @endforeach
        @else
          <li>
            <a>
              <span style="color:red;">楼盘暂无</span>
              <span style="color:red;">户型信息</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
    <div class="home_nav" id="con_a_3" style="display:none">
      <ul>
        @if(!empty($room3))
          @foreach($room3 as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
              <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
              <span>约{{$room->floorage}}平米</span>
            </a>
            <input type="hidden" name="room" value="{{$room->room}}">
            <input type="hidden" name="name" value="{{$room->name}}">
            <input type="hidden" name="thumbPic" value="{{$room->thumbPic}}">
            <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
            <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
            <input type="hidden" name="num" value="{{$room->num}}">
            <input type="hidden" name="floorage" value="{{$room->floorage}}">
            <input type="hidden" name="price" value="{{$room->price}}">
            <input type="hidden" name="feature" value="{{$room->feature}}">
            <input type="hidden" name="roomNum" value="{{$houseRoom3['roomNum']}}">
            <input type="hidden" name="minPrice2" value="{{$houseRoom3['minPrice2']}}">
            <input type="hidden" name="maxPrice2" value="{{$houseRoom3['maxPrice2']}}">
            <input type="hidden" name="rentNum" value="{{$houseRent3['roomNum']}}">
            <input type="hidden" name="minPrice1" value="{{$houseRent3['minPrice1']}}">
            <input type="hidden" name="maxPrice1" value="{{$houseRent3['maxPrice1']}}"3
          </li>
          @endforeach
        @else
          <li>
            <a>
              <span style="color:red;">楼盘暂无</span>
              <span style="color:red;">户型信息</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
    <div class="home_nav" id="con_a_4" style="display:none">
      <ul>
        @if(!empty($room4))
          @foreach($room4 as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
              <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
              <span>约{{$room->floorage}}平米</span>
            </a>
            <input type="hidden" name="room" value="{{$room->room}}">
            <input type="hidden" name="name" value="{{$room->name}}">
            <input type="hidden" name="thumbPic" value="{{$room->thumbPic}}">
            <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
            <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
            <input type="hidden" name="num" value="{{$room->num}}">
            <input type="hidden" name="floorage" value="{{$room->floorage}}">
            <input type="hidden" name="price" value="{{$room->price}}">
            <input type="hidden" name="feature" value="{{$room->feature}}">
            <input type="hidden" name="roomNum" value="{{$houseRoom4['roomNum']}}">
            <input type="hidden" name="minPrice2" value="{{$houseRoom4['minPrice2']}}">
            <input type="hidden" name="maxPrice2" value="{{$houseRoom4['maxPrice2']}}">\
            <input type="hidden" name="rentNum" value="{{$houseRent4['roomNum']}}">
            <input type="hidden" name="minPrice1" value="{{$houseRent4['minPrice1']}}">
            <input type="hidden" name="maxPrice1" value="{{$houseRent4['maxPrice1']}}">
          </li>
          @endforeach
        @else
          <li>
            <a>
              <span style="color:red;">楼盘暂无</span>
              <span style="color:red;">户型信息</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
    <div class="home_nav" id="con_a_5" style="display:none">
      <ul>
        @if(!empty($room5))
          @foreach($room5 as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
              <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
              <span>约{{$room->floorage}}平米</span>
            </a>
            <input type="hidden" name="room" value="{{$room->room}}">
            <input type="hidden" name="name" value="{{$room->name}}">
            <input type="hidden" name="thumbPic" value="{{$room->thumbPic}}">
            <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
            <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
            <input type="hidden" name="num" value="{{$room->num}}">
            <input type="hidden" name="floorage" value="{{$room->floorage}}">
            <input type="hidden" name="price" value="{{$room->price}}">
            <input type="hidden" name="feature" value="{{$room->feature}}">
            <input type="hidden" name="roomNum" value="{{$houseRoom5['roomNum']}}">
            <input type="hidden" name="minPrice2" value="{{$houseRoom5['minPrice2']}}">
            <input type="hidden" name="maxPrice2" value="{{$houseRoom5['maxPrice2']}}">
            <input type="hidden" name="rentNum" value="{{$houseRent5['roomNum']}}">
            <input type="hidden" name="minPrice1" value="{{$houseRent5['minPrice1']}}">
            <input type="hidden" name="maxPrice1" value="{{$houseRent5['maxPrice1']}}">
          </li>
          @endforeach
        @else
          <li>
            <a>
              <span style="color:red;">楼盘暂无</span>
              <span style="color:red;">户型信息</span>
            </a>
          </li>
        @endif
      </ul>
    </div>
  </div>
  <div class="hx_msg">
    @if(!empty($roomOneInfo->thumbPic))
    <div class="detail_img" align="center"><a><img id="img" src="{{$roomOneInfo->thumbPic}}" alt="户型图"></a></div>
    @else
    <div class="detail_img" align="center"><a><h1>暂无图片信息</h1></a></div>
    @endif
    <div class="hx_info">
      <p><span class="span">居&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室：</span><span id="roomInfo">@if(!empty($roomOneInfo->room)) {{$roomOneInfo->room}}室 @endif @if(!empty($roomOneInfo->hall)) {{$roomOneInfo->hall}}厅 @endif @if(!empty($roomOneInfo->toilet)) {{$roomOneInfo->toilet}}卫 @endif @if(!empty($roomOneInfo->kitchen)) {{$roomOneInfo->kitchen}}厨 @endif</span></p>
      <p><span class="span">建筑面积：</span><span id="floorage">@if(!empty($roomOneInfo->floorage)) {{$roomOneInfo->floorage}}平米 @endif</span></p>
      <p><span class="span">参考均价：</span>(<span>二手房</span>)<span id="price">@if(!empty($roomOneInfo->price)) {{$roomOneInfo->price}}元/平 @else 暂无 @endif</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>(<span>租房</span>)<span>1000元/月</span></span></p>
      <p><span class="span">在售房源：</span>
         <a><span id="roomNum">18</span></a>套</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <span>报价区间：</span>
         <span><span class="colorfe" id="minPrice2">450</span>万元</span>
         <span>-</span>
         <span><span class="colorfe" id="maxPrice2">490</span>万元</span></p>
      <p><span class="span">在租房源：</span>
         <a><span id="rentNum">15</span></a>套&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <span>报价区间：</span>
         <span><span class="colorfe" id="minPrice1">3600</span>元/月</span>
         <span>-</span>
         <span><span class="colorfe" id="maxPrice1">8500</span>元/月</span>
      </p>
    </div>
  </div>
  
  <div class="build">
    <div class="house_type">
      <h2 id="saleTotal">推荐二手房源 ({{$saleTotal}})<span><a href="/house/esfsale?communityId={{$communityId}}">更多...</a></span></h2>
      <div class="apartment">
        <div class="apartment_house" id="list_sale">
        @if(!empty($houseSaleData))
         @foreach($houseSaleData as $k=>$sale)
         <?php if($k == 5) break; ?>
          <dl>
            <dt><a href="/housedetail/ss{{$sale->_source->id}}.html"><img src="{{get_img_url('houseSale', $sale->_source->thumbPic)}}" alt="户型图"></a></dt>
            <dd class="home_name"><a href="/housedetail/ss{{$sale->_source->id}}.html" >{{$sale->_source->title}}</a></dd>
            <dd>
              <p class="p1"><span>总价&nbsp;</span><span class="colorfe font_size">{{$sale->_source->price2}}万</span></p>
            </dd>
          </dl>
         @endforeach
        @else
          <dt>暂无数据</dt>
        @endif
        </div>
      </div>
    </div>
    <div class="house_type">
      <h2 id="rentTotal">推荐租房房源 ({{$rentTotal}})<span><a href="/house/esfrent?communityId={{$communityId}}">更多...</a></span></h2>
      <div class="apartment">
        <div class="apartment_house" id="list_rent">
        @if(!empty($houseRentData))
         @foreach($houseRentData as $k=>$rent)
         <?php if($k == 5) break; ?>
          <dl>
            <dt><a href="/housedetail/ss{{$rent->_source->id}}.html"><img src="{{get_img_url('houseRent', $rent->_source->thumbPic)}}" alt="户型图"></a></dt>
            <dd class="home_name">
              <a href="/housedetail/ss{{$rent->_source->id}}.html">{{$rent->_source->title}}</a>
            </dd>
            <dd>
              <p class="p1"><span>租金&nbsp;</span><span class="colorfe font_size">{{$rent->_source->price1}}元/月</span></p>
            </dd>
          </dl>
         @endforeach
        @else
          <dt>暂无数据</dt>
        @endif
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="communityId" value="{{$communityId}}">
<script src="/js/PageEffects/slider.js?v={{Config::get('app.version')}}"></script>
<script>
function setContentTab(name, curr) {
  $(".nav_msg a").click(function(){
    $(".nav_msg a").removeClass("color_blue");  
    $(this).addClass("color_blue"); 
  });
  var n=$(".nav_msg a").length;
    for (i = 1; i <= n; i++) {
        var menu = document.getElementById(name + i);
        var cont = document.getElementById("con_" + name + "_" + i);
        menu.className = i == curr ? "up" : "";
        if (i == curr) {
            cont.style.display = "block";
            $(cont).find('.changeA').eq(0).click();
        } else {
            cont.style.display = "none";
        }
    }
}
window.onload = function(){
  var oDiv = document.getElementById("msg_nav");
  var h = oDiv.offsetTop;
  document.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if(h <= t){
      oDiv.style.position = 'fixed';
    }else{
      oDiv.style.position = '';
      }
  } 
};
</script>

<script>
  $('.changeA').click(function(){
    $('.changeA a').attr('class','');
    $(this).find('a').attr('class','click');
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val(); // 获取楼盘id
    var room = $(this).find('input[name="room"]').val(); // 居室数
    var name = $(this).find('input[name="name"]').val(); // 获取居室名称
    var thumbPic = $(this).find('input[name="thumbPic"]').val(); // 获取居室图片
    var roomInfo = $(this).find('input[name="roomInfo"]').val(); // 获取居室信息
    var faceTo = $(this).find('input[name="faceTo"]').val(); // 获取户型朝向
    var num = $(this).find('input[name="num"]').val(); // 获取可售房源套数
    var floorage = $(this).find('input[name="floorage"]').val(); // 获取建筑面积
    var price = $(this).find('input[name="price"]').val(); // 获取参考均价
    var feature = $(this).find('input[name="feature"]').val(); // 获取户型解析
    var sumprice = floorage * price;
    var roomNum = $(this).find('input[name="roomNum"]').val();
    var minPrice2 = $(this).find('input[name="minPrice2"]').val();
    var maxPrice2 = $(this).find('input[name="maxPrice2"]').val();
    var rentNum = $(this).find('input[name="rentNum"]').val();
    var minPrice1 = $(this).find('input[name="minPrice1"]').val();
    var maxPrice1 = $(this).find('input[name="maxPrice1"]').val();
    var faceToCN = {'1':'东', '2':'南', '3':'西', '4':'北', '5':'南北', '6':'东南', '7':'西南', '8':'东北', '9':'西北', '10':'东西'};

    $('#img').attr('src',thumbPic);
    $('#roomInfo').html(roomInfo);
    $('#floorage').html(floorage+'平米');
    $('#price').html(price+'元/平');
    $('#roomNum').html(roomNum);
    $('#minPrice2').html(minPrice2);
    $('#maxPrice2').html(maxPrice2);
    $('#rentNum').html(rentNum);
    $('#minPrice1').html(minPrice1);
    $('#maxPrice1').html(maxPrice1);
    $.ajax({
      type : 'post',
      url  : '/esfbl',
      data : {
        _token:_token,
        communityId:communityId,
        room:room
      },
      success : function(result) {
        // console.log(result);
        var list_sale = '';
        for(i in result.houseSale) {
          list_sale += '<dl><dt><a href="/housedetail/ss'+ result.houseRent[i]._source.id +'.html"><img src="'+result.houseSale[i]._source.thumbPic+'"></a></dt><dd class="home_name"><a href="/housedetail/ss'+ result.houseRent[i]._source.id +'.html">'+ result.houseSale[i]._source.title +'</a></dd><dd><p class="p1"><span>总价&nbsp;</span><span class="colorfe font_size">'+result.houseSale[i].price2+'万</span></p></dd></dl>';
        }
        $('#list_sale').html(list_sale);
        $('#saleTotal').html('同为'+room+'居推荐二手房源 ('+result.saleTotalNum+')<span><a href="/house/esfsale?communityId='+ result.communityId +'">更多...</a></span>');

        var list_rent = '';
        for(i in result.houseRent) {
          list_rent += '<dl><dt><a href="/housedetail/sr'+ result.houseRent[i]._source.id +'.html"><img src="'+result.houseRent[i]._source.thumbPic+'"></a></dt><dd class="home_name"><a href="/housedetail/sr'+ result.houseRent[i]._source.id +'.html">'+ result.houseRent[i]._source.title +'</a></dd><dd><p class="p1"><span>租金&nbsp;</span><span class="colorfe font_size">'+result.houseRent[i].price1+'元/月</span></p></dd></dl>';
        }
        $('#list_rent').html(list_rent);
        $('#rentTotal').html('同为'+room+'居推荐租房房源 ('+result.rentTotalNum+')<span><a href="/house/esfrent?communityId='+ result.communityId +'">更多...</a></span>');
      }
    });
  });

  // autoload
  function autoLoad(){
      $('.home_nav').hide();
      $('p.nav_msg').children('a').each(function(index){
          if($(this).hasClass('color_blue') == true){
              $('#con_a_' + (index+1) ).show();
              $('#con_a_' + (index+1) ).find('.changeA').eq(0).click();
          }
      });
  }
  autoLoad();
</script>
@endsection