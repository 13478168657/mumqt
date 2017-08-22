@include('agent.header')
@include('agent.left')
    <div class="write_msg">
      <p class="manage_title">
        @foreach($type2Info as $k=>$ty)
        <a href="addBuilding?communityId={{$communityId}}&typeInfo={{$k}}" @if($typeInfo == $k) class="click" @endif>{{$ty}}</a>
        @endforeach
      </p>
      <input type="hidden" name="type2_one" value="{{$typeInfo}}" />
      <input type="hidden" name="communityId" value="{{$communityId}}">
      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color" href="label.htm">标注楼栋信息</a>
            <a class="btn back_color modaltrigger" href="#add">添加楼栋信息</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="150">序号</th>
          <th width="150">楼栋名称</th>
          <th width="150">单元数量</th>
          <th width="150">录入时间</th>
          <th width="150">操作</th>
        </tr>
        @foreach($communitybuilding as $k => $build)
        <tr @if( ( $k + 1) % 2 == 0) class="backColor" @endif>
          <td>@if($k < 9) {{'0'.($k+1)}} @else {{$k+1}} @endif</td>
          <td>{{$build->num}}</td>
          <td><a class="aa"><span class="colorfe">{{count($build->unit)}}</span>/{{$build->unitTotal}}个</a></td>
          <td>{{$build->timeCreate}}</td>
          <td><a class="btn modaltrigger build_id" value="{{$build->id}}" href="#dy">添加单元信息</a>&nbsp;&nbsp;
              <a class="btn modaltrigger build_id" href="#ld" value="{{$build->id}}">修改楼栋信息</a>&nbsp;&nbsp;
              <input type="hidden" name="hidden_build_name" value="{{$build->num}}" />
              <input type="hidden" name="hidden_build_unitTotal" value="{{$build->unitTotal}}" />
              <a class="btn modaltrigger del_build" href="#dell" value="{{$build->id}}">删除</a></td>
        </tr>
        <tr class="bb" style="display:none;">
          <td colspan="5">
            <div class="dy_info" style="display:none;">
              <ul>
                <li>
                  <span class="w1">单元名</span>
                  <span class="w2">单元层数</span>
                  <span class="w3">单元户数</span>
                  <span class="w5">梯户配比</span>
                  <span class="w6">备注</span>
                  <span class="w7">操作</span>
                </li>
                @if(!empty($build->unit))
                @foreach($build->unit as $uke=>$unit)
                <li>
                  <span class="w1">{{$unit->num}}</span>
                  <span class="w2">{{$unit->floorTotal}}</span>
                  <span class="w3">{{$unit->houseTotal}}</span>
                  <span class="w5">{{$unit->liftRatio}}</span>
                  <span class="w6">{{$unit->note}}</span>
                  <span class="w7"><a class="modaltrigger upd_unit" value="{{$unit->id}}" href="#del">修改</a>&nbsp;&nbsp;<a class="del_unit" value="{{$unit->id}}">删除</a></span>
                </li>
                @endforeach
                @endif
              </ul>
            </div>
          </td>
        </tr>
        @endforeach
        <tr>
          <td colspan="5">
            <div class="page_nav" style="width:400px;">
              <ul>
                <li><a href="addBuilding">首页</a></li>
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
<div class="main_r add" id="add" style=" width:580px; top:200px;">
 <div class="ld">
  <h2>添加楼栋信息</h2>
  <span class="close" onClick="$(this).parents('#add').hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg">
    <ul class="input_msg" style=" width:580px;">
      <li>
        <label><span class="dotted colorfe">*</span>楼栋名称：</label>
        <input type="text" class="txt width2" name="build_name" value="" />
        <span id="msg_name" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元数量：</label>
        <input type="text" class="txt width2" name="unit_total" />
        <span id="msg_total" style="color:red;margin-left:10px;"></span>
      </li>
      <li><input type="button" class="btn back_color" name="next_build" value="下一步" /></li>
    </ul>
  </div>
 </div>
 <div class="dy" style="display:none;">
  <h2>添加单元信息</h2>
  <span class="close" onClick="$(this).parents('#add').hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label><span class="dotted colorfe">*</span>单元名称：</label>
        <input type="text" class="txt width2" name="unit_name" />
        <span id="msg_unit_name" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元层数：</label>
        <input type="text" class="txt width2" name="floor_total" />
        <span id="msg_floor_total" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>总户数：</label>
        <input type="text" class="txt width2" name="house_total" />
        <span id="msg_house_total" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>梯户配比：</label>
        <input type="text" class="txt width2" name="lift_ratio1" />
        <span class="tishi" style="margin:0 5px;">:</span>
        <input type="text" class="txt width4" name="lift_ratio2" />
        <span id="msg_lift" style="color:red;margin-left:10px;"></span>
      </li>
      <li style="height:auto; overflow:hidden;">
        <label><span class="dotted colorfe">*</span>备注：</label>
        <textarea class="txtarea" name="note_unit" value="" style="width:200px; height:40px;"></textarea>
        <span id="msg_note" style="color:red;margin-left:10px;"></span>
      </li>
      <li><input type="button" class="btn1 back_color" name="save_unit" value="保存" /><input type="button" class="btn1 back_color" name="save_again" value="创建下一个" /></li>
    </ul>
  </div>
 </div>
</div>
<div class="main_r add" id="ld" style=" width:580px; top:300px;">
  <h2>修改楼栋信息</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg">
    <ul class="input_msg" style=" width:580px;">
      <li>
        <label><span class="dotted colorfe">*</span>楼栋名称：</label>
        <input type="text" class="txt width2" name="change_build_name" />
        <span id="change_build_name" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元数量：</label>
        <input type="text" class="txt width2" name="change_unitTotal" />
        <span id="change_unitTotal" style="color:red;margin-left:10px;"></span>
      </li>
      <li><input type="button" class="btn back_color" id="save_build" value="保存"/></li>
    </ul>
  </div>
</div>
<div class="main_r add" id="dell" style=" width:580px; top:300px;">
  <h2>删除楼栋信息</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg">
    <ul class="input_msg" style=" width:580px;">
      <li><label>确定要删除楼栋和楼栋下边的所有单元信息吗?</label></li>
      <li><input type="button" class="btn back_color" id="yes_build" value="是"/></li>
    </ul>
  </div>
</div>
<div class="main_r add" id="dy" style=" width:580px; top:300px;">
  <h2>添加单元信息</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label><span class="dotted colorfe">*</span>单元名称：</label>
        <input type="text" class="txt width2" name="add_build" />
        <span id="msg_add_build" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元层数：</label>
        <input type="text" class="txt width2" name="add_unitTotal" />
        <span id="msg_add_unitTotal" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>总户数：</label>
        <input type="text" class="txt width2" name="add_houseTotal" />
        <span id="msg_add_houseTotal" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>梯户配比：</label>
        <input type="text" class="txt width2" name="add_t1" />
        <span id="msg_add_lift" style="color:red;margin-left:10px;"></span>
        <span class="tishi" style="margin:0 5px;">:</span>
        <input type="text" class="txt width4" name="add_t2" />
        <span id="msg_add_lift" style="color:red;margin-left:10px;"></span>
      </li>
      <li style="height:auto; overflow:hidden;">
        <label><span class="dotted colorfe">*</span>备注：</label>
        <textarea class="txtarea" name="add_note" value="" style="width:200px; height:40px;"></textarea>
        <span id="msg_add_note" style="color:red;margin-left:10px;"></span>
      </li>
      <li><input type="button" class="btn1 back_color" id="save_add" value="保存" />
          <input type="button" class="btn1 back_color" name="continue" value="创建下一个" /></li>
    </ul>
  </div>
</div>
<div class="main_r add" id="del" style=" width:580px; top:300px;">
  <h2>修改单元信息</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label><span class="dotted colorfe">*</span>单元名称：</label>
        <input type="text" class="txt width2" name="up_build" />
        <span id="msg_up_build" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元层数：</label>
        <input type="text" class="txt width2" name="up_unitTotal" />
        <span id="msg_up_unitTotal" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>总户数：</label>
        <input type="text" class="txt width2" name="up_houseTotal" />
        <span id="msg_up_houseTotal" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>梯户配比：</label>
        <input type="text" class="txt width2" name="up_t1" />
        <span class="tishi" style="margin:0 5px;">:</span>
        <input type="text" class="txt width4" name="up_t2" />
        <span id="msg_up_t" style="color:red;margin-left:10px;"></span>
      </li>
      <li style="height:auto; overflow:hidden;">
        <label><span class="dotted colorfe">*</span>备注：</label>
        <textarea class="txtarea" name="up_note" style="width:200px; height:40px;"></textarea>
        <span id="msg_up_note" style="color:red;margin-left:10px;"></span>
      </li>
      <li><input type="button" class="btn1 back_color" id="save_up" value="保存" /></li>
    </ul>
  </div>
</div>
<script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<input type="hidden" name="_token" value="{{csrf_token()}}" />
<script>
$(function(){
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:110,
    overlay:0.45,
    closeButton:".hidemodal"
  });
  $(".aa").click(function(){
  if($(this).parents("tr").next().css("display")=="none")
    {
    $(this).parents("tr").next().show();
    $(this).parents("tr").next().find(".dy_info").slideDown();
  }else{
    $(this).parents("tr").next().find(".dy_info").slideUp();
    $(this).parents("tr").next().slideUp();
  }
  });
});
</script>
<script>
$(document).ready(function(e) { 
  $(".ban li").click(function(){
     $(this).parents(".ban").find(".term_title span").text($(this).text()); 
     $(this).parents(".list_tag").hide();
    });
});
</script>
<script>
  // ajax获取楼栋信息
  var insertLastId = '';
  $('input[name="next_build"]').click(function(){
    var _token     = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var type2_one  = $('input[name="type2_one"]').val(); // 当前具体type2
    var build_name = testing('input[name="build_name"]', /^\S.*$/, '楼栋名称不能为空', '#msg_name');//楼栋名称
    var unit_total = testing('input[name="unit_total"]', /^\d{1,3}$/, '单元数量为1-3位正整数', '#msg_total');// 楼栋单元
    if(build_name && unit_total){
      $(this).parents('.ld').hide();
      $(this).parents('.ld').next().show();
      $.ajax({
        type : 'post',
        url  : 'addBuilding',
        data : {
          _token     : _token,
          communityId:communityId,
          build_name : build_name,
          unit_total : unit_total,
          type2_one  : type2_one
        },
        success : function(result){
          console.log(result);
          insertLastId = result;
          alert('楼栋添加成功!');
        }
      });
    }
  });

  // ajax获取单元信息
  $('input[name="save_unit"]').click(function(){
    var _token      = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var unit_name = testing('input[name="unit_name"]', /^\d{1,3}$/, '单元名称为1-3位正整数', '#msg_unit_name');
    var floor_total = testing('input[name="floor_total"]', /^\d{1,3}$/, '单元层数为1-3位正整数', '#msg_floor_total');
    var house_total = testing('input[name="house_total"]', /^\d{1,3}$/, '总户数为1-3位正整数', '#msg_house_total');
    var lift_ratio1 = testing('input[name="lift_ratio1"]', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_lift');
    var lift_ratio2 = testing('input[name="lift_ratio2', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_lift');
    var note_unit = testing('textarea[name="note_unit"]', /^\S.*$/, '备注不能为空', '#msg_note');
    if(unit_name && floor_total && house_total && lift_ratio1 && lift_ratio2 && note_unit){
      $.ajax({
        type : 'post',
        url  : 'addBuilding',
        data : {
          _token      : _token,
          communityId : communityId,
          insertLastId: insertLastId,
          unit_name   : unit_name,
          floor_total : floor_total,
          house_total : house_total,
          lift_ratio1 : lift_ratio1,
          lift_ratio2 : lift_ratio2,
          note_unit   : note_unit
        },
        success : function(result){
          // console.log(result);
          alert('保存成功!');
          window.location.href="addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
        }
      });
    }
  });

  // 继续创建单元
  $('input[name="save_again"]').click(function(){
    var _token      = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var unit_name = testing('input[name="unit_name"]', /^\d{1,3}$/, '单元名称为1-3位正整数', '#msg_unit_name');
    var floor_total = testing('input[name="floor_total"]', /^\d{1,3}$/, '单元层数为1-3位正整数', '#msg_floor_total');
    var house_total = testing('input[name="house_total"]', /^\d{1,3}$/, '总户数为1-3位正整数', '#msg_house_total');
    var lift_ratio1 = testing('input[name="lift_ratio1"]', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_lift');
    var lift_ratio2 = testing('input[name="lift_ratio2', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_lift');
    var note_unit = testing('textarea[name="note_unit"]', /^\S.*$/, '备注不能为空', '#msg_note');
    if(unit_name && floor_total && house_total && lift_ratio1 && lift_ratio2 && note_unit){
      $.ajax({
        type : 'post',
        url  : 'addBuilding',
        data : {
          _token      : _token,
          communityId : communityId,
          insertLastId: insertLastId,
          unit_name   : unit_name,
          floor_total : floor_total,
          house_total : house_total,
          lift_ratio1 : lift_ratio1,
          lift_ratio2 : lift_ratio2,
          note_unit   : note_unit
        },
        success : function(result){
          // console.log(result);
          alert('创建成功,继续创建单元!');
          $('input[name="unit_name"]').val(''); // 单元名称
          $('input[name="floor_total"]').val(''); // 单元层数
          $('input[name="house_total"]').val(''); // 总户数
          $('input[name="lift_ratio1"]').val(''); // 梯户配比1
          $('input[name="lift_ratio2"]').val(''); // 梯户配比2
          $('textarea[name="note_unit"]').val(''); // 备注
        }
      });
    }
  });

  // 获取楼栋id
  var build_id;
  $('.build_id').click(function(){
    build_id = $(this).attr('value'); // 获取要修改的楼栋id
    var build_name = $(this).parent().find('input[name="hidden_build_name"]').val();
    var build_unitTotal  = $(this).parent().find('input[name="hidden_build_unitTotal"]').val();
    $('input[name="change_build_name"]').attr('value',build_name);
    $('input[name="change_unitTotal"]').attr('value',build_unitTotal);
  });

  // 修改楼栋信息
  $('#save_build').click(function(){
    var _token      = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var change_build_name = $('input[name="change_build_name"]').val();
    var change_unitTotal = $('input[name="change_unitTotal"]').val();
    if(!(/^\S.*$/.test(change_build_name))){
      $('#change_build_name').html('楼栋名称不能为空');
      change_build_name = '';
    }else{
      $('#change_build_name').html('');
    }
    if(!(/^\d{1,3}$/.test(change_unitTotal))){
      $('#change_unitTotal').html('单元层数为1-3位正整数');
      change_unitTotal = '';
    }else{
      $('#change_unitTotal').html('');
    }
    if(change_build_name && change_unitTotal != ''){
      $.ajax({
        type : 'post',
        url  : 'addBuilding',
        data : {
          _token:_token,
          communityId:communityId,
          build_id:build_id,
          change_build_name:change_build_name,
          change_unitTotal:change_unitTotal
        },
        success : function(result){
          alert('楼栋修改成功!');
          window.location.href="addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
        }
      });
    }
  });

  // 添加单元信息(update)
  $('#save_add').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var add_build = testing('input[name="add_build"]', /^\d{1,3}$/, '单元名称为1-3位正整数', '#msg_add_build');
    var add_unitTotal = testing('input[name="add_unitTotal"]', /^\d{1,3}$/, '单元层数为1-3位正整数', '#msg_add_unitTotal');
    var add_houseTotal = testing('input[name="add_houseTotal"]', /^\d{1,3}$/, '总户数为1-3位正整数', '#msg_add_houseTotal');
    var add_t1 = testing('input[name="add_t1"]', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_add_lift');
    var add_t2 = testing('input[name="add_t2', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_add_lift');
    var add_note = testing('textarea[name="add_note"]', /^\S.*$/, '备注不能为空', '#msg_add_note');
    if(add_build && add_unitTotal && add_houseTotal && add_t1 && add_t2 && add_note)
    $.ajax({
      type : 'post',
      url  : 'addBuilding',
      data : {
        _token      : _token,
        communityId:communityId,
        build_id: build_id,
        add_build   : add_build,
        add_unitTotal : add_unitTotal,
        add_houseTotal : add_houseTotal,
        add_t1 : add_t1,
        add_t2 : add_t2,
        add_note   : add_note
      },
      success : function(result){
        // console.log(result);
        alert('添加单元成功!');
        window.location.href="addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
      }
    });
  });

  // 继续创建单元信息
  $('input[name="continue"]').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var add_build = testing('input[name="add_build"]', /^\d{1,3}$/, '单元名称为1-3位正整数', '#msg_add_build');
    var add_unitTotal = testing('input[name="add_unitTotal"]', /^\d{1,3}$/, '单元层数为1-3位正整数', '#msg_add_unitTotal');
    var add_houseTotal = testing('input[name="add_houseTotal"]', /^\d{1,3}$/, '总户数为1-3位正整数', '#msg_add_houseTotal');
    var add_t1 = testing('input[name="add_t1"]', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_add_lift');
    var add_t2 = testing('input[name="add_t2', /^\d{1,3}$/, '梯户配比为1-3位正整数', '#msg_add_lift');
    var add_note = testing('textarea[name="add_note"]', /^\S.*$/, '备注不能为空', '#msg_add_note');
    if(add_build && add_unitTotal && add_houseTotal && add_t1 && add_t2 && add_note){
      $.ajax({
        type : 'post',
        url  : 'addBuilding',
        data : {
          _token      : _token,
          communityId:communityId,
          build_id: build_id,
          add_build   : add_build,
          add_unitTotal : add_unitTotal,
          add_houseTotal : add_houseTotal,
          add_t1 : add_t1,
          add_t2 : add_t2,
          add_note   : add_note
        },
        success : function(result){
          // console.log(result);
          $('input[name="add_build"]').val(''); // 单元名称
          $('input[name="add_unitTotal"]').val(''); // 单元层数
          $('input[name="add_houseTotal"]').val(''); // 总户数
          $('input[name="add_t1"]').val(''); // 梯户配比1
          $('input[name="add_t2"]').val(''); // 梯户配比2
          $('textarea[name="add_note"]').val(''); // 备注
          alert('添加单元成功,继续添加');
        }
      });
    }
  });

  // 获取修改单元id
  var up_unit_id;
  $('.upd_unit').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    up_unit_id = $(this).attr('value');
    // alert(up_unit_id);
    $.ajax({
      type : 'post',
      url  : 'addBuilding',
      data : {
        _token:_token,
        communityId:communityId,
        up_unit_id:up_unit_id
      },
      success : function(result){
        for( i in result ){
          // console.log(result[i].num);
          $('input[name="up_build"]').attr('value',result[i].num);
          $('input[name="up_unitTotal"]').attr('value',result[i].floorTotal);
          $('input[name="up_houseTotal"]').attr('value',result[i].houseTotal);
          var lift = result[i].liftRatio.split(':');
          $('input[name="up_t1"]').attr('value',lift[0]);
          $('input[name="up_t2"]').attr('value',lift[1]);
          $('textarea[name="up_note"]').text(result[i].note);
        }
      }
    });
  });

  // 修改单元
  $('#save_up').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var up_id  = up_unit_id;
    var up_build   = $('input[name="up_build"]').val(); // 单元名称
    var up_unitTotal = $('input[name="up_unitTotal"]').val(); // 单元层数
    var up_houseTotal = $('input[name="up_houseTotal"]').val(); // 总户数
    var up_t1 = $('input[name="up_t1"]').val(); // 梯户配比1
    var up_t2 = $('input[name="up_t2"]').val(); // 梯户配比
    var up_note   = $('textarea[name="up_note"]').val(); // 备注

    if(!(/^\S.*$/.test(up_build))){
      $('#msg_up_build').html('楼栋名称不能为空');
      up_build = '';
    }else{
      $('#msg_up_build').html('');
    }
    if(!(/^\d{1,3}$/.test(up_unitTotal))){
      $('#msg_up_unitTotal').html('单元层数为1-3位正整数');
      up_unitTotal = '';
    }else{
      $('#msg_up_unitTotal').html('');
    }
    if(!(/^\d{1,3}$/.test(up_houseTotal))){
      $('#msg_up_houseTotal').html('总户数为1-3位正整数');
      up_houseTotal = '';
    }else{
      $('#msg_up_houseTotal').html('');
    }
    if(!(/^\d{1,3}$/.test(up_t1))){
      $('#msg_up_t').html('梯户配比为1-3位正整数');
      up_t1 = '';
    }else{
      $('#msg_up_t').html('');
    }
    if(!(/^\d{1,3}$/.test(up_t2))){
      $('#msg_up_t').html('梯户配比为1-3位正整数');
      up_t2 = '';
    }else{
      $('#msg_up_t').html('');
    }
    if(!(/^\S.*$/.test(up_note))){
      $('#msg_up_note').html('备注不能为空');
      up_note = '';
    }else{
      $('#msg_up_note').html('');
    }
    if(up_build && up_unitTotal && up_houseTotal && up_t1 && up_t2 && up_note != ''){
      $.ajax({
        type : 'post',
        url  : 'addBuilding',
        data : {
          _token      : _token,
          communityId:communityId,
          up_id:up_id,
          up_build   : up_build,
          up_unitTotal : up_unitTotal,
          up_houseTotal : up_houseTotal,
          up_t1 : up_t1,
          up_t2 : up_t2,
          up_note   : up_note
        },
        success : function(result){
          // console.log(result);
          alert('修改单元成功!');
          window.location.href="addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
        }
      });
    }
  });

  // 删除单元信息
  $('.del_unit').click(function(){
    var unit_id = $(this).attr('value');
    var communityId = $('input[name="communityId"]').val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type : 'post',
      url  : 'addBuilding',
      data : {
        _token:_token,
        communityId:communityId,
        unit_id:unit_id
      },
      success : function(result){
        // console.log(result);
        alert('删除成功!');
        window.location.href="addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
      }
    });
  });

  // 删除楼栋
  var del_build_id;
  $('.del_build').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    del_build_id = $(this).attr('value');
  });
  $('#yes_build').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    $.ajax({
      type : 'post',
      url  : 'addBuilding',
      data : {
        _token:_token,
        communityId:communityId,
        del_build_id:del_build_id
      },
      success : function(result){
        // console.log(result);
        alert('删除楼栋成功!');
        window.location.href="addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}";
      }
    });
  });

  /**
  * 验证信息函数
  * @param string obj 需要找的对象
  * @param string patt 需要验证的条件正则
  * @param string cont 如果不通过，需要显示的内容 
  * @param string res 如果不通过，显示内容位置的选择器 
  */
  function testing( obj, patt, cont, res){
    var obj = $(obj);
    var patt = patt;
    var cont = cont;
    var res = $(res);
    
    if( patt.test(obj.val()) || patt.test(obj.attr('value'))) {
      res.text('');
      return obj.val() ? obj.val() : obj.attr('value');
    }else{
      res.text(cont);
      return false;
    }
  }
</script>
</body>
</html>
