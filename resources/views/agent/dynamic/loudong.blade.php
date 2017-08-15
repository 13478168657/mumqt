@include('agent.dynamic.header')
@include('agent.dynamic.left')
    <div class="write_msg">
      <p class="manage_title">
        @if(!empty($data))
          @foreach($data as $dkey => $dval)
            @if(!empty($dval))
              @foreach($dval as $ddk => $ddv)
              <a href="{{$hosturl}}?type={{$ddk}}" @if($pagetype[2] == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color" href="#">标注楼栋信息</a>
            <a class="btn back_color modaltrigger" href="#add">添加楼栋信息</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="10%">序号</th>
          <th width="20%">楼栋名称</th>
          <th width="20%">单元数量</th>
          <th width="20%">录入时间</th>
          <th width="30%">操作</th>
        </tr>
        @if(!empty($build->items()))
          @foreach($build->items() as $bkey => $bval)
          <tr @if( ($bkey + 1) % 2 == 0 ) class="backColor" @endif value="{{$bval->id}}" >
            <td>{{sprintf("%'.02d", ($bkey + ( ($build->currentPage() - 1) * 10) ) + 1)}}</td>
            <td>{{$bval->num}}号楼</td>
            <td>
              <a class="aa">
                <span class="colorfe">{{count($bval->unit)}}</span>/{{$bval->unitTotal}}个
              </a>
            </td>
            <td>{{$bval->timeCreate}}</td>
            <td value="{{$bval->id}}">未审核&nbsp;&nbsp;<a class="btn modaltrigger" value="{{$bval->num}},{{$bval->unitTotal}}" onclick="addUnit(this);" href="#dy">添加单元信息</a>&nbsp;&nbsp;<a class="btn modaltrigger" value="{{$bval->num}},{{$bval->unitTotal}}" onclick="editloudong(this);" href="#ld">修改楼栋信息</a>&nbsp;&nbsp;<a class="modaltrigger" onclick="deleteloudong(this);" href="#sc">删除</a></td>
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
                  @if(!empty($bval->unit))
                    @foreach($bval->unit as $ukey => $uval)
                    <li>
                      <span class="w1" value="{{$uval->num}}">{{$uval->num}}单元</span>
                      <span class="w2" value="{{$uval->floorTotal}}">{{$uval->floorTotal}}层</span>
                      <span class="w3" value="{{$uval->houseTotal}}">{{$uval->houseTotal}}</span>
                      <span class="w5" value="{{$uval->liftRatio}}">{{$uval->liftRatio}}</span>
                      <span class="w6" value="{{$uval->note}}">{{$uval->note}}</span>
                      <span class="w7" value="{{$uval->id}}"><a class="modaltrigger" onclick="editUnit(this);" href="#dy2" >修改</a>&nbsp;&nbsp;<a class="modaltrigger" onclick="deleteUnit(this);" href="#sc">删除</a></span>
                    </li>
                    @endforeach
                  @else
                    没有单元信息
                  @endif
                </ul>
              </div>
            </td>
          </tr>
          @endforeach
        @else
          <tr>
            <td colspan="6">暂无数据</td>
          </tr>
        @endif

        @if($build->lastPage() > 1)
        <tr>
          <td colspan="5">
            {!!$build->render()!!}
          </td>
        </tr>
        @endif
      </table>
    </div>  
  </div>
</div>
<div class="main_r add" id="add" style=" width:580px; top:200px;">
  <div class="ld">
    <h2>添加楼栋信息</h2>
    <span class="close" id="close_build1"></span>
    <div class="write_msg">
      <ul class="input_msg" style=" width:580px;">
        <li>
          <label><span class="dotted colorfe">*</span>楼栋名称：</label>
          <input type="text" class="txt width2 buildName" />
          <span class="res_buildName" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>单元数量：</label>
          <input type="text" class="txt width2 unitNum" />
          <span class="res_unitNum" style="color:red;margin-left:10px;"></span>
        </li>
        <li><input type="button" class="btn back_color addbuildinfo" value="下一步" /></li>
      </ul>
    </div>
  </div>
  <div class="dy" style="display:none;">
    <h2>添加单元信息</h2>
    <span class="close" id="close_build2"></span>
    <div class="write_msg" >
      <ul class="input_msg">
        <li>
          <label><span class="dotted colorfe">*</span>单元名称：</label>
          <input type="text" class="txt width2 unitName" value="" />
          <span class="res_unitName" style="color:red;margin-left:10px;"></span> 
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>单元层数：</label>
          <input type="text" class="txt width2 unitFloor" value="" />
          <span class="res_unitFloor" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>总户数：</label>
          <input type="text" class="txt width2 unitHouse" value="" />
          <span class="res_unitHouse" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>梯户配比：</label>
          <input type="text" class="txt width2 unitRatio1" value="" />
          <span class="tishi" style="margin:0 5px;">:</span>
          <input type="text" class="txt width4 unitRatio2" value="" />
          <span class="res_unitRatio" style="color:red;margin-left:10px;"></span>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>备注：</label>
          <textarea class="txtarea unitNote" value="" style="width:200px; height:40px;"></textarea>
          <span class="res_unitNote" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <input type="button" class="btn1 back_color saveUnitInfo" value="保存" />
          <input type="button" class="btn1 back_color addUnitInfo" value="创建下一个" />
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="main_r add" id="ld" style=" width:580px; top:300px;">
  <h2>修改楼栋信息</h2>
  <span class="close" onClick="closeEditloudong(this);"></span>
  <div class="write_msg">
    <ul class="input_msg" style=" width:580px;">
      <li>
        <label><span class="dotted colorfe">*</span>楼栋名称：</label>
        <input type="text" class="txt width2" id="editloudongname" value="" />
        <span id="res_editloudongname" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元数量：</label>
        <input type="text" class="txt width2" id="editunitnum" value="" />
        <span id="res_editunitnum" style="color:red;margin-left:10px;"></span>
      </li>
      <li><input type="button" id="saveEditloudong" class="btn back_color" value="保存"/></li>
    </ul>
  </div>
</div>
<div class="main_r add" id="dy" style=" width:580px; top:300px;">
  <h2>编辑单元信息</h2>
  <span class="close" onClick="closeEditunit(this);"></span>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label><span class="dotted colorfe">*</span>单元名称：</label>
        <input type="text" class="txt width2" id="editUnitname" value="" /> 
        <span id="res_editUnitname" style="margin-left:10px;color:red;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元层数：</label>
        <input type="text" class="txt width2"  id="editUnitfloor" value="" />
        <span id="res_editUnitfloor" style="margin-left:10px;color:red;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>总户数：</label>
        <input type="text" class="txt width2" id="editUnitcount" value="" />
        <span id="res_editUnitcount" style="margin-left:10px;color:red;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>梯户配比：</label>
        <input type="text" class="txt width2" id="editUnitratio1" value=""  />
        <span class="tishi" style="margin:0 5px;">:</span>
        <input type="text" class="txt width4" id="editUnitratio2" value=""  />
        <span id="res_editUnitratio" style="margin-left:10px;color:red;"></span>
      </li>
      <li style="height:auto; overflow:hidden;">
        <label><span class="dotted colorfe">*</span>备注：</label>
        <textarea class="txtarea" id="editUnitnote" value="" style="width:200px; height:40px;"></textarea>
        <span id="res_editUnitnote" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <input type="button" id="saveEditunit" class="btn1 back_color" value="保存" />
        <input type="button" id="saveEditunitnext" class="btn1 back_color" value="创建下一个" />
      </li>
    </ul>
  </div>
</div>
<div class="main_r add" id="dy2" style=" width:580px; top:300px;">
  <h2>编辑单元信息</h2>
  <span class="close" onClick="closeEditunit(this);"></span>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label><span class="dotted colorfe">*</span>单元名称：</label>
        <input type="text" class="txt width2" id="editUnitname_2" value="" /> 
        <span id="res_editUnitname_2" style="margin-left:10px;color:red;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>单元层数：</label>
        <input type="text" class="txt width2"  id="editUnitfloor_2" value="" />
        <span id="res_editUnitfloor_2" style="margin-left:10px;color:red;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>总户数：</label>
        <input type="text" class="txt width2" id="editUnitcount_2" value="" />
        <span id="res_editUnitcount_2" style="margin-left:10px;color:red;"></span>
      </li>
      <li>
        <label><span class="dotted colorfe">*</span>梯户配比：</label>
        <input type="text" class="txt width2" id="editUnitratio1_2" value=""  />
        <span class="tishi" style="margin:0 5px;">:</span>
        <input type="text" class="txt width4" id="editUnitratio2_2" value=""  />
        <span id="res_editUnitratio_2" style="margin-left:10px;color:red;"></span>
      </li>
      <li style="height:auto; overflow:hidden;">
        <label><span class="dotted colorfe">*</span>备注：</label>
        <textarea class="txtarea" id="editUnitnote_2" value="" style="width:200px; height:40px;"></textarea>
        <span id="res_editUnitnote_2" style="color:red;margin-left:10px;"></span>
      </li>
      <li>
        <input type="button" id="saveEditunit_2" class="btn1 back_color" value="保存" />
      </li>
    </ul>
  </div>
</div>
<div class="change_tel" id="sc">
  <span class="close" onClick="closeDeleteloudong(this);"></span>
  <h2>删除</h2>
  <div class="change3">
    <p class="p"><i></i>您确定要删除<span id="deletename">楼栋</span>信息吗？</p>
    <p class="p">
      <input type="button" class="btn back_color" style=" width:80px;" id="saveDelete" value="确定" />
      <input type="button" class="btn back_color" style=" width:80px;" value="取消" />
    </p>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/dynamic.js?v={{Config::get('app.version')}}"></script>
<script>
$(function(){
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:110,
    overlay:0.45,
    closeButton:".hidemodal"
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

/**
* 清除错误信息
*/
function clearError(){
  $('.res_buildName').text('');
  $('.res_unitNum').text('');

  $('.res_unitName').text('');
  $('.res_unitFloor').text('');
  $('.res_unitHouse').text('');
  $('.res_unitRatio').text('');
  $('.res_unitNote').text('');

  $('#res_editUnitname').text('');
  $('#res_editUnitfloor').text('');
  $('#res_editUnitcount').text('');
  $('#res_editUnitratio').text('');
  $('#res_editUnitnote').text('');

  $('#res_editUnitname_2').text('');
  $('#res_editUnitfloor_2').text('');
  $('#res_editUnitcount_2').text('');
  $('#res_editUnitratio_2').text('');
  $('#res_editUnitnote_2').text('');
}


// 点击查看单元信息
$(".aa").click(function(){
  if($(this).parents("tr").next().css("display")=="none"){
    $(this).parents("tr").next().show();
    $(this).parents("tr").next().find(".dy_info").slideDown();
    }else{
    $(this).parents("tr").next().find(".dy_info").slideUp();
    $(this).parents("tr").next().slideUp();
    }
});



/** 楼栋信息 **/

  var buildName, unitNum;
  var unitName, unitFloor, unitHouse, unitRatio1, unitRatio2, unitNote;

  var bid,unitId,deleteType;

  //添加楼栋
  $('.addbuildinfo').click(function(ev){
    ev.preventDefault();
    var patt = /^\d{1,3}$/;
    buildName = testing('.buildName', patt, '楼栋名称为1-3位正整数', '.res_buildName');
    unitNum = testing('.unitNum', patt, '单元总数为1-3位正整数', '.res_unitNum');
    if(buildName && unitNum){
      clearError();
      $(this).parents('.ld').hide();
      $(this).parents('.ld').next('.dy').show();
    }
    return false;
  }); 
  //关闭添加楼栋
  $('#close_build1, #close_build2').click(function(){

    $('.buildName').val('');
    $('.unitNum').val('');

    $('.unitName').val('');
    $('.unitFloor').val('');
    $('.unitHouse').val('');
    $('.unitRatio1').val('');
    $('.unitRatio2').val('');
    $('.unitNote').val('');

    clearError();

    // $(this).parents('#add').hide();
    // $('#lean_overlay').hide();

    $('.ld').show();
    $('.dy').hide();
    $('#add').hide();
    $('#lean_overlay').hide();
  });
  //保存楼栋和单元
  $('.saveUnitInfo').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/addbuildinfo';
    var comid = $('#comid').val();
    var pagetype1 = $('#pagetype1').val();
    var pagetype2 = $('#pagetype2').val();

    unitName = testing('.unitName', /^\d{1,3}$/, '单元名称为1-3位正整数', '.res_unitName');
    unitFloor = testing('.unitFloor', /^\d{1,3}$/, '总楼层数为1-3位正整数', '.res_unitFloor');
    unitHouse = testing('.unitHouse', /^\d{1,5}$/, '总户数为1-5位正整数', '.res_unitHouse');
    unitRatio1 = testing('.unitRatio1', /^\d{1,3}$/, '梯户配比为1-3位正整数', '.res_unitRatio');
    unitRatio2 = testing('.unitRatio2', /^\d{1,3}$/, '梯户配比为1-3位正整数', '.res_unitRatio');
    unitNote = testing('.unitNote', /^\S.*$/, '备注不能为空', '.res_unitNote');

    if(unitName && unitFloor && unitHouse && unitRatio1 && unitRatio2 && unitNote){
      $.ajax({
        type:'post',
        url:url,
        data:{
          _token:token,
          id:comid,
          pagetype1:pagetype1,
          pagetype2:pagetype2,
          buildName:buildName,
          unitNum:unitNum,
          unitName:unitName,
          unitFloor:unitFloor,
          unitHouse:unitHouse,
          unitRatio1:unitRatio1,
          unitRatio2:unitRatio2,
          unitNote:unitNote
        },
        success:function(data){
          alert('保存成功');
          $('.unitName').val('');
          $('.unitFloor').val('');
          $('.unitHouse').val('');
          $('.unitRatio1').val('');
          $('.unitRatio2').val('');
          $('.unitNote').val('');
          clearError();
          location.reload();
        }
      });
    }
    return false;
  });
  //继续创建下一个单元
  $('.addUnitInfo').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/addbuildinfo';
    var comid = $('#comid').val();
    var pagetype1 = $('#pagetype1').val();
    var pagetype2 = $('#pagetype2').val();

    unitName = testing('.unitName', /^\d{1,3}$/, '单元名称为1-3位正整数', '.res_unitName');
    unitFloor = testing('.unitFloor', /^\d{1,3}$/, '总楼层数为1-3位正整数', '.res_unitFloor');
    unitHouse = testing('.unitHouse', /^\d{1,5}$/, '总户数为1-5位正整数', '.res_unitHouse');
    unitRatio1 = testing('.unitRatio1', /^\d{1,3}$/, '梯户配比为1-3位正整数', '.res_unitRatio');
    unitRatio2 = testing('.unitRatio2', /^\d{1,3}$/, '梯户配比为1-3位正整数', '.res_unitRatio');
    unitNote = testing('.unitNote', /^\S.*$/, '备注不能为空', '.res_unitNote');

    if(unitName && unitFloor && unitHouse && unitRatio1 && unitRatio2 && unitNote){

      $.ajax({
        type:'post',
        url:url,
        data:{
          _token:token,
          id:comid,
          pagetype1:pagetype1,
          pagetype2:pagetype2,
          buildName:buildName,
          unitNum:unitNum,
          unitName:unitName,
          unitFloor:unitFloor,
          unitHouse:unitHouse,
          unitRatio1:unitRatio1,
          unitRatio2:unitRatio2,
          unitNote:unitNote
        },
        success:function(data){
          alert('添加成功，继续下一个');
          $('.unitName').val('');
          $('.unitFloor').val('');
          $('.unitHouse').val('');
          $('.unitRatio1').val('');
          $('.unitRatio2').val('');
          $('.unitNote').val('');
          clearError();
        }
      });
      
    }
    return false;
  });
  



  //添加单元
  function addUnit(obj){
      bid = $(obj).parent('td').attr('value');
      var val = $(obj).attr('value');
      var arr = val.split(',');
      buildName = arr[0];
      unitNum = arr[1];
  }
 
  //修改单元
  function editUnit(obj){
      unitId = $(obj).parent('span').attr('value');
      $('#editUnitname_2').val($(obj).parents('li').children('span.w1').attr('value'));
      $('#editUnitfloor_2').val($(obj).parents('li').children('span.w2').attr('value'));
      $('#editUnitcount_2').val($(obj).parents('li').children('span.w3').attr('value'));
      $('#editUnitratio1_2').val($(obj).parents('li').children('span.w5').attr('value').split(':')[0]);
      $('#editUnitratio2_2').val($(obj).parents('li').children('span.w5').attr('value').split(':')[1]);
      $('#editUnitnote_2').val($(obj).parents('li').children('span.w6').attr('value'));
  }

  //删除单元
  function deleteUnit(obj){
      unitId = $(obj).parent('span').attr('value');
      $('#deletename').text('单元');
      deleteType = 2;
  }
  //修改楼栋
  function editloudong(obj){
      bid = $(obj).parent('td').attr('value');
      var val = $(obj).attr('value');
      var arr = val.split(',');
      $('#editloudongname').val(arr[0]);
      $('#editunitnum').val(arr[1]);
  }

  //删除楼栋

  function deleteloudong(obj){
      bid = $(obj).parent('td').attr('value');
      $('#deletename').text('楼栋');
      deleteType = 1;
  }




//关闭修改楼栋信息
function closeEditloudong(obj){
    $(obj).parent().hide(); 
    $('#lean_overlay').hide();
    bid = '';
    $('#editloudongname').val('');
    $('#editunitnum').val('');
}

//关闭删除楼栋信息
function closeDeleteloudong(obj){
    $(obj).parent().hide(); 
    $('#lean_overlay').hide();
    bid = '';
}

// 关闭编辑单元信息
function closeEditunit(obj){
    $(obj).parent().hide(); 
    $('#lean_overlay').hide();
    unitId = '';
    bid = '';
}

//确定删除信息
$('#saveDelete').click(function(){
    var token = $('#token').val();
    var url , id;
    if(deleteType == 1){
        url = '/dynamic/deletebuild';
        id = bid;
    }
    if(deleteType == 2){
        url = '/dynamic/deleteunit';
        id = unitId;
    }

    if(url && id){
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token:token,
                id:id
            },
            dataType:'json',
            success:function(data){
                if(data == 1){
                    alert('删除成功');
                    window.location.reload();
                }else{
                    alert('删除失败');
                    window.location.reload();
                }
            }
        });
    }else{
        return false;
    }
});

//保存修改后的楼栋信息
$('#saveEditloudong').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/saveeditloudong';
    var patt = /^\d{1,3}$/;
    buildName = testing('#editloudongname', patt, '楼栋名称为1-3位正整数', '#res_editloudongname');
    unitNum = testing('#editunitnum', patt, '单元总数为1-3位正整数', '#res_editunitnum');
    if(bid && buildName && unitNum){
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token:token,
                id:bid,
                buildName:buildName,
                unitNum:unitNum
            },
            dataType:'json',
            success:function(data){
                if(data == 1){
                    alert('修改成功');
                    window.location.reload();
                }else{
                    alert('修改失败');
                    window.location.reload();
                }
            }
        });
    }
});

//保存当前添加的单元信息
  $('#saveEditunit').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/addbuildinfo';
    var comid = $('#comid').val();
    var pagetype1 = $('#pagetype1').val();
    var pagetype2 = $('#pagetype2').val();

    unitName = testing('#editUnitname', /^\d{1,3}$/, '单元名称为1-3位正整数', '#res_editUnitname');
    unitFloor = testing('#editUnitfloor', /^\d{1,3}$/, '总楼层数为1-3位正整数', '#res_editUnitfloor');
    unitHouse = testing('#editUnitcount', /^\d{1,5}$/, '总户数为1-5位正整数', '#res_editUnitcount');
    unitRatio1 = testing('#editUnitratio1', /^\d{1,3}$/, '', '');
    unitRatio2 = testing('#editUnitratio2', /^\d{1,3}$/, '', '');
    unitNote = testing('#editUnitnote', /^\S.*$/, '备注不能为空', '#res_editUnitnote');

    if(unitRatio1 && unitRatio2){
        $('#res_editUnitratio').text('');
    }else{
        $('#res_editUnitratio').text('梯户配比为1-3位正整数');
    }

    if(unitName && unitFloor && unitHouse && unitRatio1 && unitRatio2 && unitNote){
      $.ajax({
        type:'post',
        url:url,
        data:{
          _token:token,
          id:comid,
          pagetype1:pagetype1,
          pagetype2:pagetype2,
          buildName:buildName,
          unitNum:unitNum,
          unitName:unitName,
          unitFloor:unitFloor,
          unitHouse:unitHouse,
          unitRatio1:unitRatio1,
          unitRatio2:unitRatio2,
          unitNote:unitNote
        },
        success:function(data){
          alert('保存成功');
          $('#editUnitname').val('');
          $('#editUnitfloor').val('');
          $('#editUnitcount').val('');
          $('#editUnitratio1').val('');
          $('#editUnitratio2').val('');
          $('#editUnitnote').val('');
          clearError();
          location.reload();
        }
      });
    }
    return false;
  });

//保存当前添加的单元信息并继续创建下一个
  $('#saveEditunitnext').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/addbuildinfo';
    var comid = $('#comid').val();
    var pagetype1 = $('#pagetype1').val();
    var pagetype2 = $('#pagetype2').val();

    unitName = testing('#editUnitname', /^\d{1,3}$/, '单元名称为1-3位正整数', '#res_editUnitname');
    unitFloor = testing('#editUnitfloor', /^\d{1,3}$/, '总楼层数为1-3位正整数', '#res_editUnitfloor');
    unitHouse = testing('#editUnitcount', /^\d{1,5}$/, '总户数为1-5位正整数', '#res_editUnitcount');
    unitRatio1 = testing('#editUnitratio1', /^\d{1,3}$/, '', '');
    unitRatio2 = testing('#editUnitratio2', /^\d{1,3}$/, '', '');
    unitNote = testing('#editUnitnote', /^\S.*$/, '备注不能为空', '#res_editUnitnote');

    if(unitRatio1 && unitRatio2){
        $('#res_editUnitratio').text('');
    }else{
        $('#res_editUnitratio').text('梯户配比为1-3位正整数');
    }

    if(unitName && unitFloor && unitHouse && unitRatio1 && unitRatio2 && unitNote){

      $.ajax({
        type:'post',
        url:url,
        data:{
          _token:token,
          id:comid,
          pagetype1:pagetype1,
          pagetype2:pagetype2,
          buildName:buildName,
          unitNum:unitNum,
          unitName:unitName,
          unitFloor:unitFloor,
          unitHouse:unitHouse,
          unitRatio1:unitRatio1,
          unitRatio2:unitRatio2,
          unitNote:unitNote
        },
        success:function(data){
          alert('添加成功，继续下一个');
          $('#editUnitname').val('');
          $('#editUnitfloor').val('');
          $('#editUnitcount').val('');
          $('#editUnitratio1').val('');
          $('#editUnitratio2').val('');
          $('#editUnitnote').val('');
          clearError();
        }
      });
      
    }
    return false;
  });

//保存单元信息
  $('#saveEditunit_2').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/editunitinfo';

    unitName = testing('#editUnitname_2', /^\d{1,3}$/, '单元名称为1-3位正整数', '#res_editUnitname_2');
    unitFloor = testing('#editUnitfloor_2', /^\d{1,3}$/, '总楼层数为1-3位正整数', '#res_editUnitfloor_2');
    unitHouse = testing('#editUnitcount_2', /^\d{1,5}$/, '总户数为1-5位正整数', '#res_editUnitcount_2');
    unitRatio1 = testing('#editUnitratio1_2', /^\d{1,3}$/, '', '');
    unitRatio2 = testing('#editUnitratio2_2', /^\d{1,3}$/, '', '');
    unitNote = testing('#editUnitnote_2', /^\S.*$/, '备注不能为空', '#res_editUnitnote_2');

    if(unitRatio1 && unitRatio2){
        $('#res_editUnitratio_2').text('');
    }else{
        $('#res_editUnitratio_2').text('梯户配比为1-3位正整数');
    }

    if(unitName && unitFloor && unitHouse && unitRatio1 && unitRatio2 && unitNote){
      $.ajax({
        type:'post',
        url:url,
        data:{
          _token:token,
          unitId:unitId,
          unitName:unitName,
          unitFloor:unitFloor,
          unitHouse:unitHouse,
          unitRatio1:unitRatio1,
          unitRatio2:unitRatio2,
          unitNote:unitNote
        },
        success:function(data){
          alert('保存成功');
          $('#editUnitname_2').val('');
          $('#editUnitfloor_2').val('');
          $('#editUnitcount_2').val('');
          $('#editUnitratio1_2').val('');
          $('#editUnitratio2_2').val('');
          $('#editUnitnote_2').val('');
          clearError();
          location.reload();
        }
      });
    }
    return false;
  });
</script>
</body>
</html>
