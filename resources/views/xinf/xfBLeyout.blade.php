@extends('mainlayout')
@section('content')
@include('xinf.left')
  <div class="hx_nav">
    <p class="nav_msg">
    @if($fenlei == 'new')
        <a @if(empty($roomtype)) class="color_blue" @endif id="a1" onclick="setContentTab('a',1)">全部户型(@if(!empty($viewShowInfo['room1Tota'])) {{$viewShowInfo['room1Tota']}} @else 0 @endif)</a>
        @if(!empty($viewShowInfo['room6Tota']))
        <span></span>
        <a @if($roomtype == 1) class="color_blue" @endif id="a6" onclick="setContentTab('a',6)">1室户型（{{$viewShowInfo['room6Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room2Tota']))
        <span></span>
        <a @if($roomtype == 2) class="color_blue" @endif id="a2" onclick="setContentTab('a',2)">2室户型（{{$viewShowInfo['room2Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room3Tota']))
        <span></span>
        <a @if($roomtype == 3) class="color_blue" @endif id="a3" onclick="setContentTab('a',3)">3室户型（{{$viewShowInfo['room3Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room4Tota']))
        <span></span>
        <a @if($roomtype == 4) class="color_blue" @endif id="a4" onclick="setContentTab('a',4)">4室户型（{{$viewShowInfo['room4Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room5Tota']))
        <span></span>
        <a @if($roomtype == 5) class="color_blue" @endif id="a5" onclick="setContentTab('a',5)">5室户型（{{$viewShowInfo['room5Tota']}}）</a>
        @endif
    @else
        <a @if(empty($roomtype)) class="color_blue" @endif id="a1" onclick="setContentTab('a',1)">全部户型(@if(!empty($viewShowInfo['room1Tota'])) {{$viewShowInfo['room1Tota']}} @else 0 @endif)</a>
        @if(!empty($viewShowInfo['room6Tota']))
        <span></span>
        <a @if($roomtype == '其他') class="color_blue" @endif id="a2" onclick="setContentTab('a',6)">首层（{{$viewShowInfo['room6Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room2Tota']))
        <span></span>
        <a @if($roomtype == '首层') class="color_blue" @endif id="a2" onclick="setContentTab('a',2)">首层（{{$viewShowInfo['room2Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room3Tota']))
        <span></span>
        <a @if($roomtype == '标准层') class="color_blue" @endif id="a3" onclick="setContentTab('a',3)">标准层（{{$viewShowInfo['room3Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room4Tota']))
        <span></span>
        <a @if($roomtype == '标准层') class="color_blue" @endif id="a4" onclick="setContentTab('a',4)">顶层（{{$viewShowInfo['room4Tota']}}）</a>
        @endif
        @if(!empty($viewShowInfo['room5Tota']))
        <span></span>
        <a @if($roomtype == '地下层') class="color_blue" @endif id="a5" onclick="setContentTab('a',5)">地下层（{{$viewShowInfo['room5Tota']}}）</a>
        @endif
    @endif
    </p>
    <div class="home_nav" id="con_a_1">
      <div id="btn-left" class="arrow-btn dasabled"></div>
      <div class="slider">
        <ul>
        @if(!empty($commRoom))
          @foreach($commRoom as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
              @if($fenlei == 'new')
                <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
              @else
                    <span>{{$room->location}}{{$room->name}}</span>
              @endif
              <span>约{{$room->floorage}}平米</span>
            </a>
              @if($fenlei == 'new')
                  <input type="hidden" name="room" value="{{$room->room}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="name" value="{{$room->name}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
                  <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
                  <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
                  <input type="hidden" name="num" value="{{$room->num}}">
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="priceUnit" value="{{$room->priceUnit}}">
                  <input type="hidden" name="feature" value="{{$room->feature}}">
              @else
                  <input type="hidden" name="name" value="{{$room->name}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="usableArea" value="{{$room->usableArea}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
              @endif
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
                @if($fenlei == 'new')
                    <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
                @else
                    <span>{{$room->location}}{{$room->name}}</span>
                @endif
              <span>约{{$room->floorage}}平米</span>
            </a>
              @if($fenlei == 'new')
                  <input type="hidden" name="room" value="{{$room->room}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="name" value="{{$room->name}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
                  <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
                  <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
                  <input type="hidden" name="num" value="{{$room->num}}">
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="priceUnit" value="{{$room->priceUnit}}">
                  <input type="hidden" name="feature" value="{{$room->feature}}">
              @else
                  <input type="hidden" name="name" value="{{$room->name}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="usableArea" value="{{$room->usableArea}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
              @endif
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
                @if($fenlei == 'new')
                    <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
                @else
                    <span>{{$room->location}}{{$room->name}}</span>
                @endif
              <span>约{{$room->floorage}}平米</span>
            </a>
              @if($fenlei == 'new')
                  <input type="hidden" name="room" value="{{$room->room}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="name" value="{{$room->name}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
                  <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
                  <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
                  <input type="hidden" name="num" value="{{$room->num}}">
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="priceUnit" value="{{$room->priceUnit}}">
                  <input type="hidden" name="feature" value="{{$room->feature}}">
              @else
                  <input type="hidden" name="name" value="{{$room->name}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="usableArea" value="{{$room->usableArea}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
              @endif
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
                @if($fenlei == 'new')
                    <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
                @else
                    <span>{{$room->location}}{{$room->name}}</span>
                @endif
              <span>约{{$room->floorage}}平米</span>
            </a>
              @if($fenlei == 'new')
                  <input type="hidden" name="room" value="{{$room->room}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="name" value="{{$room->name}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
                  <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
                  <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
                  <input type="hidden" name="num" value="{{$room->num}}">
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="priceUnit" value="{{$room->priceUnit}}">
                  <input type="hidden" name="feature" value="{{$room->feature}}">
              @else
                  <input type="hidden" name="name" value="{{$room->name}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="usableArea" value="{{$room->usableArea}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
              @endif
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
                @if($fenlei == 'new')
                    <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
                @else
                    <span>{{$room->location}}{{$room->name}}</span>
                @endif
              <span>约{{$room->floorage}}平米</span>
            </a>
              @if($fenlei == 'new')
                  <input type="hidden" name="room" value="{{$room->room}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">  --}}
                  <input type="hidden" name="name" value="{{$room->name}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
                  <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
                  <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
                  <input type="hidden" name="num" value="{{$room->num}}">
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="priceUnit" value="{{$room->priceUnit}}">
                  <input type="hidden" name="feature" value="{{$room->feature}}">
              @else
                  <input type="hidden" name="name" value="{{$room->name}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="usableArea" value="{{$room->usableArea}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
              @endif
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
    <div class="home_nav" id="con_a_6" style="display:none">
      <ul>
        @if(!empty($room6))
          @foreach($room6 as $room)
          <li class="changeA">
            <a @if($room->id == $roomId) class="click" @endif>
                @if($fenlei == 'new')
                    <span>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫</span>
                @else
                    <span>{{$room->location}}{{$room->name}}</span>
                @endif
              <span>约{{$room->floorage}}平米</span>
            </a>
              @if($fenlei == 'new')
                  <input type="hidden" name="room" value="{{$room->room}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="name" value="{{$room->name}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
                  <input type="hidden" name="roomInfo" value="{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨">
                  <input type="hidden" name="faceTo" value="{{$room->faceTo}}">
                  <input type="hidden" name="num" value="{{$room->num}}">
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="priceUnit" value="{{$room->priceUnit}}">
                  <input type="hidden" name="feature" value="{{$room->feature}}">
              @else
                  <input type="hidden" name="name" value="{{$room->name}}">
                  {{--<input type="hidden" name="state" value="{{$room->state}}">--}}
                  <input type="hidden" name="floorage" value="{{$room->floorage}}">
                  <input type="hidden" name="usableArea" value="{{$room->usableArea}}">
                  <input type="hidden" name="price" value="{{$room->price}}">
                  <input type="hidden" name="thumbPic" value="{{get_img_url('room',$room->thumbPic,4)}}" raw="{{get_img_url('room',$room->thumbPic)}}">
              @endif
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

    {{--<h2 id="name">@if(!empty($roomOneInfo->name)) {{$roomOneInfo->name}} @endif<span class="color8d">[在售]</span></h2>--}}
    <h2 id="name">@if(!empty($roomOneInfo->name)) {{$roomOneInfo->name}} @endif<span class="color8d"></span></h2>

    @if(!empty($roomOneInfo->thumbPic))
    <div class="detail_img" align="center"><a class="dian"><img id="img" src="{{get_img_url('room',$roomOneInfo->thumbPic,4)}}" alt="@if(!empty($viewShowInfo['communityName'])){{$viewShowInfo['communityName']}}@endif户型图" raw="{{get_img_url('room',$roomOneInfo->thumbPic)}}" ></a></div>
    @else
    <div class="detail_img" align="center"><a><h1>暂无图片信息</h1></a></div>
    @endif
    <div class="hx_info">
      @if($fenlei == 'new')
      <p><span class="span">居&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室：</span><span id="roomInfo">@if(!empty($roomOneInfo->room)) {{$roomOneInfo->room}}室 @endif @if(!empty($roomOneInfo->hall)) {{$roomOneInfo->hall}}厅 @endif @if(!empty($roomOneInfo->toilet)) {{$roomOneInfo->toilet}}卫 @endif @if(!empty($roomOneInfo->kitchen)) {{$roomOneInfo->kitchen}}厨 @endif</span></p>
      <p><span class="span">户型朝向：</span><span id="faceTo">@if(!empty($viewShowInfo['faceToName'])) {{$viewShowInfo['faceToName']}} @endif</span></p>
      <p><span class="span">可售房源：</span><span id="num">@if(!empty($roomOneInfo->num)) {{$roomOneInfo->num}}套 @endif</span></p>
      <p><span class="span">建筑面积：</span><span id="floorage">@if(!empty($roomOneInfo->floorage)) {{$roomOneInfo->floorage}}平米 @endif</span></p>
      <p><span class="span">参考均价：</span><span id="price">
              @if(!empty($roomOneInfo->price))
                    @if(!empty($roomOneInfo->priceUnit) && $roomOneInfo->priceUnit == 2)
                      {{$roomOneInfo->price * 10000 / $roomOneInfo->floorage }}
                    @else
                      {{$roomOneInfo->price}}
                    @endif
                        元/平
              @endif
          </span></p>
      <p><span class="span">参考总价：</span><span id="sumprice">
              @if(!empty($roomOneInfo->price))
                  @if(!empty($roomOneInfo->priceUnit) && $roomOneInfo->priceUnit == 1)
                      {{$roomOneInfo->price * $roomOneInfo->floorage / 10000}}
                  @else
                      {{$roomOneInfo->price}}
                  @endif
                      万(参考总价=参考均价*建筑面积）
              @endif
          </span></p>
      <p><span class="span">户型解析：</span><span id="feature">@if(!empty($roomOneInfo->feature)) {{$roomOneInfo->feature}} @endif</span></p>
      @else
            <p><span class="span">建筑面积：</span><span id="floorage">@if(!empty($roomOneInfo->floorage)) {{$roomOneInfo->floorage}}平米 @endif</span></p>
            <p><span class="span">使用面积：</span><span id="usableArea">@if(!empty($roomOneInfo->usableArea)) {{$roomOneInfo->usableArea}}平米 @endif</span></p>
           <!-- <p><span class="span">参考租金：</span><span id="price">@if(!empty($roomOneInfo->price)) {{$roomOneInfo->price}}元/平米▪天 @endif</span></p> -->
            <p><span class="span">参考售价：</span><span id="totalprice">@if(!empty($roomOneInfo->price)&&!empty($roomOneInfo->floorage)){{($roomOneInfo->price*$roomOneInfo->floorage)/10000}}万元@endif</span></p>
      @endif
    </div>
  </div>
 <!--户型图片弹层--> 
  <div class="cd-main-content popup" id="tan">
    	<span class="operation" id="closebtn">关闭</span>
    	<i></i>
      <img id="zoompic" src=""/>
 </div> 
  
  {{--<div class="build">--}}
    {{--<div class="house_type">--}}
    {{--<h2 id="houseSale">推荐房源 (0)<span><a>更多</a></span></h2>--}}
    {{--<div class="apartment">--}}
      {{--<div class="apartment_house">--}}
      {{--<ul id="list_sale">--}}
        {{--<dt>暂无数据</dt>--}}
      {{--</ul>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
  {{--</div>--}}
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="communityId" value="{{$communityId}}">
<script src="/js/PageEffects/slider.js?v={{Config::get('app.version')}}"></script>
<script>
function setContentTab(name, curr) {
    $(".nav_msg a").removeClass("color_blue"); 
    $("#a"+curr).addClass("color_blue"); 
  $(".nav_msg a").click(function(){
    $(".nav_msg a").removeClass("color_blue");  
    $(this).addClass("color_blue"); 
  });
    //alert("con_" + name + "_" + curr);
    $("#con_" + name + "_" + curr).css('display','block').siblings('div').css('display','none');
    $("#con_" + name + "_" + curr).find('.changeA').eq(0).click();
//  var n=$(".nav_msg a").length;
//    for (i = 1; i <= n; i++) {
//        var menu = document.getElementById(name + i);
//        var cont = document.getElementById("con_" + name + "_" + i);
//        //menu.className = i == curr ? "up" : "";
//        if (i == curr) {
//            cont.style.display = "block";
//            $(cont).find('.changeA').eq(0).click();
//        } else {
//            cont.style.display = "none";
//        }
//    }
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
    if("{{$fenlei}}"=='new'){
        var room = $(this).find('input[name="room"]').val(); // 居室数
        var name = $(this).find('input[name="name"]').val(); // 获取居室名称
        var state = $(this).find('input[name="state"]').val(); // 是否出售
        var thumbPic = $(this).find('input[name="thumbPic"]').val(); // 获取居室图片
        var raw = $(this).find('input[name="thumbPic"]').attr('raw'); // 获取居室原图
        var roomInfo = $(this).find('input[name="roomInfo"]').val(); // 获取居室信息
        var faceTo = $(this).find('input[name="faceTo"]').val(); // 获取户型朝向
        var num = $(this).find('input[name="num"]').val(); // 获取可售房源套数
        var floorage = $(this).find('input[name="floorage"]').val(); // 获取建筑面积
        var price = $(this).find('input[name="price"]').val(); // 获取参考均价
        var feature = $(this).find('input[name="feature"]').val(); // 获取户型解析
        var faceToCN = {'1':'东', '2':'南', '3':'西', '4':'北', '5':'南北', '6':'东南', '7':'西南', '8':'东北', '9':'西北', '10':'东西'};
        var stateCN = {'1':'在售', '2':'待售', '3':'已售完'};

        $('#name').html(name+'户型<span class="color8d"></span>');
        $('#img').attr('src',thumbPic);
        $('#img').attr('raw',raw);
        $('#roomInfo').html(roomInfo);
        $('#faceTo').html(faceToCN[faceTo]);
        $('#num').html(num+'套');
        $('#floorage').html(floorage+'平米');

        var priceUnit = $(this).find('input[name="priceUnit"]').val();
        if(priceUnit == 2){
            var sumprice = price;
            price = price * 10000 / floorage;
        }else if(priceUnit == 1){
            var sumprice =price * floorage / 10000;
        }

        $('#price').html(price+'元/平米');
        $('#sumprice').html(sumprice+'万元(参考总价=参考均价*建筑面积)');
        $('#feature').html(feature);
    }else{
        var floorage = $(this).find('input[name="floorage"]').val(); // 获取建筑面积
        var usableArea = $(this).find('input[name="usableArea"]').val(); // 获取使用面积
        var price = $(this).find('input[name="price"]').val(); // 获取参考均价
        var thumbPic = $(this).find('input[name="thumbPic"]').val(); // 获取居室图片
        var raw = $(this).find('input[name="thumbPic"]').attr('raw'); // 获取居室图片
        var sumprice = floorage * price / 10000;
        var stateCN = {'1':'在售', '2':'待售', '3':'已售完'};
        var name = $(this).find('input[name="name"]').val(); // 获取居室名称
        var state = $(this).find('input[name="state"]').val(); // 是否出售
        $('#name').html(name+'户型<span class="color8d">['+stateCN[state]+']</span>');
        $('#img').attr('src',thumbPic);
        $('#img').attr('raw',raw);
        $('#floorage').html(floorage+'平米');
        $('#usableArea').html(floorage+'平米');
        $('#price').html(price+'元/平米');
        $('#totalprice').html(sumprice+'万元');
    }


//    $.ajax({
//      type : 'post',
//      url  : '/xinfhx',
//      data : {
//        _token:_token,
//        communityId:communityId,
//        room:room
//      },
//      success : function(result) {
//        console.log(result);
//        var list_sale = '';
//        for(i in result.houseSale) {
//          var priceW = result.houseSale[i]['price2'] / 10000;
//          list_sale += '<dl><dt><a href="#"><img src="'+result.houseSale[i]['thumbPic']+'"></a></dt><dd class="home_name"><a>[亦庄·金茂悦]  X87-14号楼 - 1单元 - 17 - 1701</a></dd><dd><p class="p1"><span>总价&nbsp;</span><span class="colorfe font_size">'+priceW+'万</span><a class="border_blue color_blue">我要预订</a></p></dd></dl>';
//        }
//        $('#list_sale').html(list_sale);
//        $('#houseSale').html('同为'+room+'居推荐房源 ('+result.num+')<span><a>更多</a></span>');
//      }
//    });
  });

  // autoload
  function autoLoad(){
      $('.home_nav').hide();
      $('p.nav_msg').children('a').each(function(index){
          if($(this).hasClass('color_blue') == true){
              $('#con_a_' + $(this).attr('id').substr(-1) ).show();
              if("{{$roomId}}" == '' ) {
                  $('#con_a_' + $(this).attr('id').substr(-1)).find('.changeA').eq(0).click();
              }
          }
      });
  }

  autoLoad();
  //关闭弹层
  $(document).keydown(function(e){
				if(e.which==27){
					$('#tan').hide();
				}
	});
	$('#closebtn').click(function(){
		$('#tan').hide();
	});
	
	$('.dian').click(function(){
		var t = document.getElementById('tan');
			t.style.display = 'block';
			var pic=$(this).find('img');
			var src=pic.attr('raw');
//			if(pic.width()>pic.height()){
//				$('#zoompic').css('width','1000px');
//			}else{
//				$('#zoompic').css('width','600px');
//			}
			$('#zoompic').attr('src',src);
	});
	
</script>
@endsection