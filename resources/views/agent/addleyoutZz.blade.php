@include('agent.header')
@include('agent.left')
    <div class="write_msg">
      <p class="manage_title">
        @foreach($type2Info as $k=>$ty)
        <a href="addRoom?communityId={{$communityId}}&typeInfo={{$k}}" @if($typeInfo == $k) class="click" @endif>{{$ty}}</a>
        @endforeach
      </p>
      <input type="hidden" name="typeInfo" value="{{$typeInfo}}" />
      <input type="hidden" name="communityId" value="{{$communityId}}">
      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color modaltrigger clear" href="#add">添加户型信息</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="10%">序号</th>
          <th width="10%">户型代号</th>
          <th width="20%">对应楼栋</th>
          <th width="20%">户型图片</th>
          <th width="20%">户型信息</th>
          <th width="10%">录入时间</th>
          <th width="10%">操作</th>
        </tr>
        @foreach($communityroom as $k=>$room)
        <tr @if( ( $k + 1) % 2 == 0) class="backColor" @endif >
          <td>@if($k < 9) {{'0'.($k+1)}} @else {{$k+1}} @endif</td>
          <td>{{$room->name}}</td>
          @if($room->build_num)
          <td>
            @foreach($room->build_num as $num)
            {{$num->num}}号楼,
            @endforeach
          </td>
          @endif
          <td><img src="{{config('imgConfig.imgSavePath')}}{{$room->thumbPic}}" width="80" height="50"/></td>
          @if($typeInfo == 301 || $typeInfo == 302 || $typeInfo == 303 || $typeInfo == 304 || $typeInfo == 305 || $typeInfo == 106)
          <td>{{$room->room}}室{{$room->hall}}厅{{$room->toilet}}卫{{$room->kitchen}}厨{{$room->balcony}}阳台&nbsp;&nbsp;{{$room->floorage}}平米&nbsp;&nbsp;{{config('faceToConfig.'.$room->faceTo)}}</td>
          @else
          <td>{{$room->location}}&nbsp;&nbsp;{{$room->floorage}}平米&nbsp;&nbsp;{{config('faceToConfig.'.$room->faceTo)}}</td>
          @endif
          <td>{{$room->timeCreate}}</td>
          <td><a class="btn modaltrigger update" value="{{$room->id}}" href="#add">修改</a>&nbsp;&nbsp;
            <input type="hidden" name="up_roomType" value="{{$room->roomType}}" />
            <input type="hidden" name="up_room_name" value="{{$room->name}}" />
            <input type="hidden" name="up_room" value="{{$room->room}}" />
            <input type="hidden" name="up_hall" value="{{$room->hall}}" />
            <input type="hidden" name="up_toilet" value="{{$room->toilet}}" />
            <input type="hidden" name="up_kitchen" value="{{$room->kitchen}}" />
            <input type="hidden" name="up_balcony" value="{{$room->balcony}}" />
            <input type="hidden" name="up_location" value="{{$room->location}}" />
            <input type="hidden" name="up_faceTo" value="{{$room->faceTo}}" />
            <input type="hidden" name="up_floorage" value="{{$room->floorage}}" />
            <input type="hidden" name="up_usableArea" value="{{$room->usableArea}}" />
            <input type="hidden" name="up_num" value="{{$room->num}}" />
            <input type="hidden" name="up_state" value="{{$room->state}}" />
            <input type="hidden" name="up_price" value="{{$room->price}}" />
            <input type="hidden" name="up_feature" value="{{$room->feature}}" />
            <input type="hidden" name="up_cbIds" value="{{$room->cbIds}}" />
            <input type="hidden" name="up_unitIds" value="{{$room->unitIds}}" />
          <a class="delete_room" value="{{$room->id}}">删除</a></td>
        </tr>
        @endforeach
        <tr>
          <td colspan="7">
            <div class="page_nav" style="width:400px;">
              <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">上一页</a></li>
                <li><a href="#">1</a></li>
                <li class="click">2</li>
                <li>.....</li>
                <li><a href="#">75</a></li>
                <li><a href="#">下一页</a></li>
                <li><a href="#">尾页</a></li>
              </ul>
            </div>
          </td>
        </tr>
      </table>
    </div> 
  </div>
</div>
<div class="change_tel map_show" id="map">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <img src="/image/about_our4.png" />
</div>
<div class="main_r add"  id="add">
  <h2 id="change_dp">添加户型信息</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg" style="width:900px;">
    <ul class="input_msg">
        @if($typeInfo == 101 || $typeInfo == 102 || $typeInfo == 103 || $typeInfo == 104 || $typeInfo == 105 || $typeInfo == 106)
        <li>
          <label><span class="dotted colorfe">*</span>户型类型：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="roomType">请选择</span><i></i></a>
            <div class="list_tag" id="type">
               <p class="top_icon"></p>
               <input type="hidden" name="roomType" />
               <ul>
                 <li class="roomType" value="1">楼层户型</li>
                 <li class="roomType" value="2">商铺户型</li>
               </ul>
             </div>
          </div>
          <span id="roomType_msg" style="color:red;margin-left:10px;"></span>
        </li>
        @endif
        <li>
          <label><span class="dotted colorfe">*</span>户型名称：</label>
          <input type="text" class="txt width4" name="room_name" />
          <span class="tishi colorfe">示例：A1</span>
          <span id="room_name" style="color:red;margin-left:10px;"></span>
        </li>
        @if($typeInfo == 301 || $typeInfo == 302 || $typeInfo == 303 || $typeInfo == 304 || $typeInfo == 305)
        <li>
          <label><span class="dotted colorfe">*</span>户型内容：</label>
          <div class="sort_icon" style="margin-left:0;">
            <a class="term_title"><span id="room">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <input type="hidden" name="room" />
               <ul>
                 <li class="room" value="0">0</li>
                 <li class="room" value="1">1</li>
                 <li class="room" value="2">2</li>
                 <li class="room" value="3">3</li>
                 <li class="room" value="4">4</li>
                 <li class="room" value="5">5</li>
                 <li class="room" value="6">6</li>
                 <li class="room" value="7">7</li>
                 <li class="room" value="8">8</li>
                 <li class="room" value="9">9</li>
               </ul>
             </div>
          </div>
          <span class="tishi">室</span>
          <div class="sort_icon" style="margin-left:0;">
            <a class="term_title"><span id="hall">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <input type="hidden" name="hall" />
               <ul>
                 <li class="hall" value="0">0</li>
                 <li class="hall" value="1">1</li>
                 <li class="hall" value="2">2</li>
                 <li class="hall" value="3">3</li>
                 <li class="hall" value="4">4</li>
                 <li class="hall" value="5">5</li>
                 <li class="hall" value="6">6</li>
                 <li class="hall" value="7">7</li>
                 <li class="hall" value="8">8</li>
                 <li class="hall" value="9">9</li>
               </ul>
             </div>
          </div>
          <span class="tishi">厅</span>
          <div class="sort_icon" style="margin-left:0;">
            <a class="term_title"><span id="toilet">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                <input type="hidden" name="toilet" />
                 <li class="toilet" value="0">0</li>
                 <li class="toilet" value="1">1</li>
                 <li class="toilet" value="2">2</li>
                 <li class="toilet" value="3">3</li>
                 <li class="toilet" value="4">4</li>
                 <li class="toilet" value="5">5</li>
                 <li class="toilet" value="6">6</li>
                 <li class="toilet" value="7">7</li>
                 <li class="toilet" value="8">8</li>
                 <li class="toilet" value="9">9</li>
               </ul>
             </div>
          </div>
          <span class="tishi">卫</span>
          <div class="sort_icon" style="margin-left:0;">
            <a class="term_title"><span id="kitchen">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                <input type="hidden" name="kitchen" />
                 <li class="kitchen" value="0">0</li>
                 <li class="kitchen" value="1">1</li>
                 <li class="kitchen" value="2">2</li>
                 <li class="kitchen" value="3">3</li>
                 <li class="kitchen" value="4">4</li>
                 <li class="kitchen" value="5">5</li>
                 <li class="kitchen" value="6">6</li>
                 <li class="kitchen" value="7">7</li>
                 <li class="kitchen" value="8">8</li>
                 <li class="kitchen" value="9">9</li>
               </ul>
             </div>
          </div>
          <span class="tishi">厨</span>
          <div class="sort_icon" style="margin-left:0;">
            <a class="term_title"><span id="balcony">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                <input type="hidden" name="balcony" />
                 <li class="balcony" value="0">0</li>
                 <li class="balcony" value="1">1</li>
                 <li class="balcony" value="2">2</li>
                 <li class="balcony" value="3">3</li>
                 <li class="balcony" value="4">4</li>
                 <li class="balcony" value="5">5</li>
                 <li class="balcony" value="6">6</li>
                 <li class="balcony" value="7">7</li>
                 <li class="balcony" value="8">8</li>
                 <li class="balcony" value="9">9</li>
               </ul>
             </div>
          </div>
          <span class="tishi">阳台</span>
          <span id="room_conment" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>户型朝向：</label>
          <div class="sort_icon" style="margin-left:0;">
            <a class="term_title"><span id="faceTo">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                <input type="hidden" name="faceTo" />
                 <li class="faceTo" value="1">东</li>
                 <li class="faceTo" value="2">南</li>
                 <li class="faceTo" value="3">西</li>
                 <li class="faceTo" value="4">北</li>
                 <li class="faceTo" value="5">南北</li>
                 <li class="faceTo" value="6">东南</li>
                 <li class="faceTo" value="7">西南</li>
                 <li class="faceTo" value="8">东北</li>
                 <li class="faceTo" value="9">西北</li>
                 <li class="faceTo" value="10">东西</li>
               </ul>
             </div>
          </div>
          <span id="faceTo_msg" style="color:red;margin-left:10px;"></span>
        </li>
        @endif
        @if($typeInfo == 201 || $typeInfo == 203 || $typeInfo == 204 || $typeInfo == 101 || $typeInfo == 102 || $typeInfo == 103 || $typeInfo == 104 || $typeInfo == 105 || $typeInfo == 106)
        <li>
          <label><span class="dotted colorfe">*</span>户型内容：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="location">请选择</span><i></i></a>
            <div class="list_tag" id="cc">
               <p class="top_icon"></p>
               <input type="hidden" name="location" />
               <ul>
                 <li class="location" value="首层">首层</li>
                 <li class="location" value="标准层">标准层</li>
                 <li class="location" value="顶层">顶层</li>
                 <li class="location" value="地下层">地下层</li>
                 <li class="location" value="other">其他</li>
               </ul>
             </div>
          </div>
          <span id="location_msg" style="color:red;margin-left:10px;"></span>
          <input type="text" class="txt width4 cc" style="display:none; margin-left:20px;" name="otherLocation">
          <span class="tishi colorfe cc" style="display:none;">示例：第二层</span>
        </li>
        @endif
        <li>
          <label><span class="dotted colorfe">*</span>建筑面积：</label>
          <input type="text" class="txt width4" name="floorage" />
          <span class="tishi">平米</span>
          <span id="floorage" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>使用面积：</label>
          <input type="text" class="txt width4" name="usableArea" />
          <span class="tishi">平米</span>
          <span id="usableArea" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>可售套数：</label>
          <input type="text" class="txt width4" name="num" />
          <span class="tishi">套</span>
          <span id="num" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>销售状态：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="state">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <input type="hidden" name="state" />
               <ul>
                 <li class="state" value="1">在售</li>
                 <li class="state" value="1">待售</li>
                 <li class="state" value="3">售罄</li>
               </ul>
             </div>
          </div>
          <span id="state_msg" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>价格：</label>
          <input type="text" class="txt width4" name="price" />
          <span class="tishi">元/平米</span>
          <span id="price" style="color:red;margin-left:10px;"></span>
        </li>
        <li style="height:auto; overflow:hidden;">
            <label>户型解析：</label>
            <textarea class="txtarea" name="feature" style=" width:300px; height:40px;"></textarea>
        </li>
        <li style="height:180px; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>对应户型图：</label>
          <div id="box" class="box">
              <div id="leyout" ></div>
          </div>
        </li>
      <li style="height:auto; overflow:hidden;"><input type="button" class="btn back_color" id="next_save" style="margin-left:400px !important;" value="下一步"/></li>
    </ul>
    <div class="ban" style="display:none;">
     <p>为所录入的户型匹配楼栋及单元
      <span id="room_unit" style="color:red;margin-left:10px;"></span>
    </p>
     <ul>
      @foreach($communitybuilding as $bk=>$build)
        <li>
          <p class="reslut">
            <span class="check_all"><input type="checkbox" name="build_id" value="{{$build->id}}" />&nbsp;{{$build->num}}</span>
            <span class="check_words">
            @foreach($build->unit as $uk=>$unit)
              {{$unit->num}}单元
            @endforeach
            </span>
          </p>
          <div class="chose" style="display:none;">
             <p class="top_icon"></p>
             <ul>
              @foreach($build->unit as $uk=>$unit)
               <li><input type="checkbox" name="unit_id" value="{{$unit->id}}" />{{$unit->num}}单元</li>
              @endforeach
               <li class="icon" onclick="$(this).parents('.chose').hide();"><i></i></li>
             </ul>
           </div>
        </li>
      @endforeach
     </ul>
     <p>
     <input type="button" class="submit back_color margin_r" style="margin-left:270px;" onclick="$(this).parents('.ban').hide();$('.input_msg').show();" value="上一步"/>
     <input type="button" class="submit back_color" id="save_buid" value="提交"/>
     </p>
    </div>
  </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}" />
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script>
$(function(){
  $('#add').submit(function(e){
    return false;
  });
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:110,
    overlay:0.45,
    closeButton:".hidemodal"
  });
  $(".ban li .check_all input").click(function(){
    if($(this).parents("li").find(".chose").css("display")=="none"){
     $(this).attr("checked",true); 
     $(this).parents("li").find(".chose").css("display","block"); 
    }else{
     $(this).attr("checked",false); 
     $(this).parents("li").find(".chose").css("display","none");  
    }
  });
});
</script>
<script>
/* 户型图 */
$('#leyout').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  fileNumLimit:1,
});
</script>

<script>
  //获取户型类型
  $('.roomType').click(function(){
    var roomType = $(this).val();
    $('input[name="roomType"]').attr('value',roomType);
  });

  // 获取室
  $('.room').click(function(){
    var room = $(this).val();
    $('input[name="room"]').attr('value',room);
  });
  // 获取厅
  $('.hall').click(function(){
    var hall = $(this).val();
    $('input[name="hall"]').attr('value',hall);
  });
  // 获取卫
  $('.toilet').click(function(){
    var toilet = $(this).val();
    $('input[name="toilet"]').attr('value',toilet);
  });
  // 获取厨
  $('.kitchen').click(function(){
    var kitchen = $(this).val();
    $('input[name="kitchen"]').attr('value',kitchen);
  });
  // 阳台
  $('.balcony').click(function(){
    var balcony = $(this).val();
    $('input[name="balcony"]').attr('value',balcony);
  });

  // 获取户型内容
  // 失去焦点获取其它 填写的location
  $('input[name="otherLocation"]').blur(function(){
    $('input[name="location"]').val($(this).val());
  });
  $('.location').click(function(){
    var location = $(this).attr('value');
    if(location == 'other'){
      $('input[name="location"]').val($('input[name="otherLocation"]').val());
    }else{
      $('input[name="location"]').val(location);
    }
    // alert($('input[name="location"]').val());
  });

  // 朝向
  $('.faceTo').click(function(){
    var faceTo = $(this).val();
    $('input[name="faceTo"]').attr('value',faceTo);
  });
  // 销售状态
  $('.state').click(function(){
    var state = $(this).val();
    $('input[name="state"]').attr('value',state);
  });

   var up_build_id; // 获取修改id
   // 点击添加户型信息,清除所有input残留值,和提示信息
   $('.clear').click(function(){
    up_build_id = null;
    $('#change_dp').html('添加户型信息');
    $('input[name="roomType"]').attr('value',''); // 户型类型
    $('#roomType').html('请选择');
    $('input[name="room_name"]').attr('value',''); // 户型名
    $('#room_name').html('');
    $('input[name="room"]').attr('value','');       // 室
    $('#room').html('请选择');
    $('input[name="hall"]').attr('value','');       // 厅
    $('#hall').html('请选择');
    $('input[name="toilet"]').attr('value','');   // 卫
    $('#toilet').html('请选择');
    $('input[name="kitchen"]').attr('value',''); // 厨
    $('#kitchen').html('请选择');
    $('input[name="balcony"]').attr('value',''); // 阳
    $('#balcony').html('请选择');
    $('input[name="location"]').attr('value',''); // 户型内容
    $('#location').html('请选择');
    $('input[name="faceTo"]').attr('value','');   // 朝向
    $('#faceTo').html('请选择');
    $('input[name="floorage"]').attr('value',''); // 建筑面积
    $('#floorage').html('');
    $('input[name="usableArea"]').attr('value',''); // 使用面积
    $('#usableArea').html('');
    $('input[name="num"]').attr('value','');  // 可售套数
    $('#num').html('');
    $('input[name="state"]').attr('value',''); // 销售状态
    $('#state').html('请选择');
    $('input[name="price"]').attr('value',''); // 价格
    $('#price').html('');
    $('textarea[name="feature"]').text(''); // 户型解析
    $('input[name="build_id"]').attr('checked',false);
    $('input[name="unit_id"]').attr('checked',false);
   });

  // 下一步判断数据类型是否符合
  $('#next_save').click(function(){
    // 户型类型
    if($('input[name="roomType"]').val() != undefined){ // 户型类型
      var roomType = $('input[name="roomType"]').val();
      if(!(/^\d{1,3}$/.test(roomType))){
        $('#roomType_msg').html('请选择户型类型');
        roomType = '';
      }else{
        $('#roomType_msg').html('');
      }
    }
    

    if($('input[name="room_name"]').val() != undefined){ // 户型名
      var room_name = $('input[name="room_name"]').val();
      if(!(/^[\da-z]+$/i.test(room_name))){
        $('#room_name').html('户型名称为字母或数字');
        room_name = '';
      }else{
        $('#room_name').html('');
      }
    }

    if($('input[name="room"]').val() != undefined){       // 室
      var room = $('input[name="room"]').val();
      if(!(/^\d{1,3}$/.test(room))){
        $('#room_conment').html('请完善户型内容');
        room = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="hall"]').val() != undefined){       // 厅
      var hall = $('input[name="hall"]').val();
      if(!(/^\d{1,3}$/.test(hall))){
        $('#room_conment').html('请完善户型内容');
        hall = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="toilet"]').val() != undefined){   // 卫
      var toilet = $('input[name="toilet"]').val();
      if(!(/^\d{1,3}$/.test(toilet))){
        $('#room_conment').html('请完善户型内容');
        toilet = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="kitchen"]').val() != undefined){ // 厨
      var kitchen = $('input[name="kitchen"]').val();
      if(!(/^\d{1,3}$/.test(kitchen))){
        $('#room_conment').html('请完善户型内容');
        kitchen = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="balcony"]').val() != undefined){ // 阳
      var balcony = $('input[name="balcony"]').val();
      if(!(/^\d{1,3}$/.test(balcony))){
        $('#room_conment').html('请完善户型内容');
        balcony = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="location"]').val() != undefined){
      var location = $('input[name="location"]').val(); // 户型内容
      // alert(location);
      if(location == ''){
        $('#location_msg').html('请选择户型内容');
        location = '';
      }else{
        $('#location_msg').html('');
      }
    }
    if($('input[name="faceTo"]').val() != undefined){
      var faceTo = $('input[name="faceTo"]').val();   // 朝向
      if(!(/^\d{1,3}$/.test(faceTo))){
        $('#faceTo_msg').html('请选择户型朝向');
        faceTo = '';
      }else{
        $('#faceTo_msg').html('');
      }
    }

    var floorage = $('input[name="floorage"]').val(); // 建筑面积
    if(!(/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/.test(floorage))){
      $('#floorage').html('建筑面积为正整数或1-2位小数');
      floorage = '';
    }else{
      $('#floorage').html('');
    }

    var usableArea = $('input[name="usableArea"]').val(); // 使用面积
    if(!(/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/.test(usableArea))){
      $('#usableArea').html('使用面积为正整数或1-2位小数');
      usableArea = '';
    }else{
      $('#usableArea').html('');
    }

    var num  = $('input[name="num"]').val();  // 可售套数
    if(!(/^\d{1,3}$/.test(num))){
      $('#num').html('可售套数为1-3位正整数');
      num = '';
    }else{
      $('#num').html('');
    }

    var state = $('input[name="state"]').val(); // 销售状态
    if(!(/^\d{1,3}$/.test(state))){
      $('#state_msg').html('请选择销售状态');
      state = '';
    }else{
      $('#state_msg').html('');
    }

    var price = $('input[name="price"]').val(); // 价格
    if(!(/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/.test(price))){
      $('#price').html('价格为正整数或1-2位小数');
      price = '';
    }else{
      $('#price').html('');
    }

    var feature = $('textarea[name="feature"]').val(); // 户型解析  

    if( (room_name && floorage && usableArea && num && state && price != '') && (room || hall || toilet || kitchen || balcony || faceTo != '') ){
      $(this).parents('ul').hide();
      $(this).parents('ul').next().show();
    }
  });

  // 存储户型信息
  $('#save_buid').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var type2_one = $('input[name="typeInfo"]').val(); // type2
    var room_name = $('input[name="room_name"]').val(); // 户型名
    // 户型类型
    if($('input[name="roomType"]').val() != undefined){ // 户型类型
      var roomType = $('input[name="roomType"]').val();
      if(!(/^\d{1,3}$/.test(roomType))){
        $('#roomType_msg').html('请选择户型类型');
        roomType = '';
      }else{
        $('#roomType_msg').html('');
      }
    }
    
    if($('input[name="room_name"]').val() != undefined){ // 户型名
      var room_name = $('input[name="room_name"]').val();
      if(!(/^[\da-z]+$/i.test(room_name))){
        $('#room_name').html('户型名称为字母或数字');
        room_name = '';
      }else{
        $('#room_name').html('');
      }
    }

    if($('input[name="room"]').val() != undefined){       // 室
      var room = $('input[name="room"]').val();
      if(!(/^\d{1,3}$/.test(room))){
        $('#room_conment').html('请完善户型内容');
        room = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="hall"]').val() != undefined){       // 厅
      var hall = $('input[name="hall"]').val();
      if(!(/^\d{1,3}$/.test(hall))){
        $('#room_conment').html('请完善户型内容');
        hall = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="toilet"]').val() != undefined){   // 卫
      var toilet = $('input[name="toilet"]').val();
      if(!(/^\d{1,3}$/.test(toilet))){
        $('#room_conment').html('请完善户型内容');
        toilet = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="kitchen"]').val() != undefined){ // 厨
      var kitchen = $('input[name="kitchen"]').val();
      if(!(/^\d{1,3}$/.test(kitchen))){
        $('#room_conment').html('请完善户型内容');
        kitchen = '';
      }else{
        $('#room_conment').html('');
      }
    }

    if($('input[name="balcony"]').val() != undefined){ // 阳
      var balcony = $('input[name="balcony"]').val();
      if(!(/^\d{1,3}$/.test(balcony))){
        $('#room_conment').html('请完善户型内容');
        balcony = '';
      }else{
        $('#room_conment').html('');
      }
    }

    // 失去焦点把其它值赋给location
    if($('input[name="location"]').val() != undefined){
      var location = $('input[name="location"]').val(); // 户型内容
      // alert(location);
      if(location == ''){
        $('#location_msg').html('请选择户型内容');
        location = '';
      }else{
        $('#location_msg').html('');
      }
    }
    if($('input[name="faceTo"]').val() != undefined){
      var faceTo = $('input[name="faceTo"]').val();   // 朝向
      if(!(/^\d{1,3}$/.test(faceTo))){
        $('#faceTo_msg').html('请选择户型朝向');
        faceTo = '';
      }else{
        $('#faceTo_msg').html('');
      }
    }

    var floorage = $('input[name="floorage"]').val(); // 建筑面积
    if(!(/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/.test(floorage))){
      $('#floorage').html('建筑面积为正整数或1-2位小数');
      floorage = '';
    }else{
      $('#floorage').html('');
    }

    var usableArea = $('input[name="usableArea"]').val(); // 使用面积
    if(!(/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/.test(usableArea))){
      $('#usableArea').html('使用面积为正整数或1-2位小数');
      usableArea = '';
    }else{
      $('#usableArea').html('');
    }

    var num  = $('input[name="num"]').val();  // 可售套数
    if(!(/^\d{1,3}$/.test(num))){
      $('#num').html('可售套数为1-3位正整数');
      num = '';
    }else{
      $('#num').html('');
    }

    var state = $('input[name="state"]').val(); // 销售状态
    if(!(/^\d{1,3}$/.test(state))){
      $('#state_msg').html('请选择销售状态');
      state = '';
    }else{
      $('#state_msg').html('');
    }

    var price = $('input[name="price"]').val(); // 价格
    if(!(/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/.test(price))){
      $('#price').html('价格为正整数或1-2位小数');
      price = '';
    }else{
      $('#price').html('');
    }

    var feature = $('textarea[name="feature"]').val(); // 户型解析  
    // var leyout = getImage('#leyout');

    // 获取上传的图片信息
    /*function getImage(obj){
      var sonList = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').children();
      var images = [];
      if(sonList.length < 1){
          alert('户型图至少要1张');
          return false;
      }
      sonList.each(function(index){
          images[index] = {
              img:$(this).children('div.viewThumb').children('img').attr('src'),
              note:$(this).children('.diyFileName').val()
          };
      });
      return images;
    }*/
    
    // 取出所有选中楼栋id
    obj_build = $('input[name="build_id"]');
    build_id = [];
    for(b in obj_build){
      if(obj_build[b].checked){
        build_id.push(obj_build[b].value);
      }
    }
    // alert(build_id);

    // 取出所有选中的单元id
    obj_unit = $('input[name="unit_id"]');
    unit_id = [];
    for( i in obj_unit){
      if(obj_unit[i].checked){
        unit_id.push(obj_unit[i].value);
      }
    }
    
    if(build_id.length == 0){
      $('#room_unit').html('请配置楼栋和单元');
      build_id = '';
    }else{
      $('#room_unit').html('');
    }

    if(unit_id.length == 0){
      $('#room_unit').html('请配置楼栋和单元');
      unit_id = '';
    }else{
      $('#room_unit').html('');
    }
    if( (room_name && floorage && usableArea && num && state && price != '') && (room || hall || toilet || kitchen || balcony || faceTo != '') ){
      $.ajax({
        type : 'post',
        url  : 'addRoom',
        data : {
          _token:_token,
          communityId:communityId,
          type2_one:type2_one,
          roomType:roomType,
          up_build_id:up_build_id,
          room_name:room_name,
          room:room,
          hall:hall,
          toilet:toilet,
          kitchen:kitchen,
          balcony:balcony,
          location:location,
          faceTo:faceTo,
          floorage:floorage,
          usableArea:usableArea,
          num:num,
          state:state,
          price:price,
          feature:feature,
          build_id:build_id,
          unit_id:unit_id
        },
        success : function(reslut){
          if(reslut == 1){
            alert('提交成功!');
            window.location.href="addRoom?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
          }else{
            alert('修改成功!');
            window.location.href="addRoom?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
          }
          
        }
      });
    }
  });
  
  // 获取要修改的楼栋id
  $('.update').click(function(){
    $('#change_dp').html('修改户型信息');
    up_build_id = $(this).attr('value');
    var up_roomType = $(this).parent().find('input[name="up_roomType"]').val();
    var up_room_name = $(this).parent().find('input[name="up_room_name"]').val(); // 获取要修改的户型名称
    var up_room = $(this).parent().find('input[name="up_room"]').val(); // 获取要修改的室
    var up_hall = $(this).parent().find('input[name="up_hall"]').val(); // 获取要修改的厅
    var up_toilet = $(this).parent().find('input[name="up_toilet"]').val(); // 获取要修改的卫
    var up_kitchen = $(this).parent().find('input[name="up_kitchen"]').val(); // 获取要修改的厨
    var up_balcony = $(this).parent().find('input[name="up_balcony"]').val(); // 获取要修改的阳
    var up_location = $(this).parent().find('input[name="up_location"]').val(); // 获取要修改的户型内容
    var up_faceTo = $(this).parent().find('input[name="up_faceTo"]').val(); // 获取要修改的朝向
    var up_floorage = $(this).parent().find('input[name="up_floorage"]').val(); // 获取要修改的朝向
    var up_usableArea = $(this).parent().find('input[name="up_usableArea"]').val(); // 获取要修改的使用面积
    var up_num = $(this).parent().find('input[name="up_num"]').val(); // 获取要修改的可售套数
    var up_state = $(this).parent().find('input[name="up_state"]').val(); // 获取要修改的销售状态
    var up_price = $(this).parent().find('input[name="up_price"]').val(); // 获取要修改的价格
    var up_feature = $(this).parent().find('input[name="up_feature"]').val(); // 获取要修改的户型解析
    var up_cbIds = $(this).parent().find('input[name="up_cbIds"]').val(); // 获取要修改的楼栋
    var up_unitIds = $(this).parent().find('input[name="up_unitIds"]').val(); // 获取要修改的单元
    var faceTo_ch = {1:'东',2:'南',3:'西',4:'北',5:'南北',6:'东南',7:'西南',8:'东北',9:'西北',10:'东西'};
    var state_ch = {1:'在售',2:'待售',3:'售罄'};
    var roomType_ch = {1:'楼层户型',2:'商铺户型'};
    $('input[name="roomType"]').attr('value',up_roomType); // 户型类型
    $('#roomType').html(roomType_ch[up_roomType]);
    $('input[name="room_name"]').attr('value',up_room_name); // 户型名
    $('input[name="room"]').attr('value',up_room);       // 室
    $('#room').html(up_room);
    $('input[name="hall"]').attr('value',up_hall);       // 厅
    $('#hall').html(up_hall);
    $('input[name="toilet"]').attr('value',up_toilet);   // 卫
    $('#toilet').html(up_toilet);
    $('input[name="kitchen"]').attr('value',up_kitchen); // 厨
    $('#kitchen').html(up_kitchen);
    $('input[name="balcony"]').attr('value',up_balcony); // 阳
    $('#balcony').html(up_balcony);
    $('input[name="location"]').attr('value',up_location); // 户型内容
    $('#location').html(up_location);
    $('input[name="faceTo"]').attr('value',up_faceTo);   // 朝向
    $('#faceTo').html(faceTo_ch[up_faceTo]);
    $('input[name="floorage"]').attr('value',up_floorage); // 建筑面积
    $('input[name="usableArea"]').attr('value',up_usableArea); // 使用面积
    $('input[name="num"]').attr('value',up_num);  // 可售套数
    $('input[name="state"]').attr('value',up_state); // 销售状态
    $('#state').html(state_ch[up_state]);
    $('input[name="price"]').attr('value',up_price); // 价格
    $('textarea[name="feature"]').text(up_feature); // 户型解析

    // 显示要修改的楼栋
    var list_build_id = up_cbIds.split('|');
    // console.log(list_build_id);
    $('input[name="build_id"]').each(function(){
       if(list_build_id.indexOf($(this).val()) != -1){
        $(this).prop('checked', true);
       }else{
        $(this).prop('checked', false);
       }
    });
    // 显示要修改的单元
    var list_unit_id = up_unitIds.split('|');
    // console.log(list_unit_id);
    $('input[name="unit_id"]').each(function(){
      if(list_unit_id.indexOf($(this).val()) != -1){
        $(this).prop('checked', true);
      }else{
        $(this).prop('checked', false);
      }
    });
  });

  // 删除户型信息
  $('.delete_room').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var delete_room_id = $(this).attr('value');
    $.ajax({
      type : 'post',
      url  : 'addRoom',
      data : {
        _token:_token,
        communityId:communityId,
        delete_room_id:delete_room_id
      },
      success : function(reslut){
        alert('删除成功!');
        window.location.href="addRoom?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
      }
    });
  });
</script>
</body>
</html>