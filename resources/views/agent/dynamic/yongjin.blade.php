@include('agent.dynamic.header')
@include('agent.dynamic.left')
    <div class="write_msg" style=" overflow:inherit;">
      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color modaltrigger" onclick="add_yj();" href="#add">添加佣金方案</a>
          </p>
         </li>
      </ul>
     </div>
    <div class="examine">
      <table class="audit">
        <tr class="backColor">
          <th>序号</th>
          <th>物业类型</th>
          <th>起始时间</th>
          <th>排期名称</th>
          <th>方案名称</th>
          <th>提成数</th>
          <th>房屋面积</th>
          <th>操作</th>
        </tr>
        @if(!empty($yongjin->items()))
        @foreach($yongjin->items() as $key => $val)
        <tr>
          <td>{{sprintf("%'.02d", ($key + ( ($yongjin->currentPage() - 1) * 10) ) + 1)}}</td>
          <td>{{$assist['propertyType'][$val->propertyTypeId]}}</td> 
          <td>{{substr($val->beginTime, 0, 10)}}</td>
          <td>{{$yongjin->communityName}}{{$val->schedule}}</td>
          <td>{{$val->suggestionName}}</td>
          @if($val->settlement == 1)
          <td>{{$val->$assist['settlement'][$val->settlement]}}%</td>
          @elseif($val->settlement == 2)
          <td>{{$val->$assist['settlement'][$val->settlement]}}元</td>
          @elseif($val->settlement == 3)
          <td>{{$val->$assist['settlement'][$val->settlement]}}折</td>
          @endif
          <td>
            @if(!empty($val->area))
            @foreach(unserialize($val->area) as $key2 => $val2)
            {{$val2['area1']}}-{{$val2['area2']}}平米<br/>
            @endforeach
            @endif
          </td>
          @if($status == 1)
          <td>未审核&nbsp;&nbsp;<a class="modaltrigger" value="{{$val->id}}" onclick="edit_yj(this);" href="#add">修改</a>&nbsp;&nbsp;<a class="modaltrigger" value="{{$val->id}}" onclick="del_info(this);" href="#sc">删除</a></td>
          @else
          <td>已发布</td>
          @endif
        </tr>
        @endforeach
        <tr>
          <td colspan="8">
            {!!$yongjin->render()!!}
          </td>
        </tr>
        @else
        <tr><td colspan="8">暂无数据</td></tr>
        @endif
      </table>
    </div>
  </div>
</div>
<div class="change_tel map_show" id="map">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <img src="/image/about_our4.png" />
</div>
<div class="main_r add" id="add" style=" width:580px; top:200px;">
  <h2>添加佣金方案</h2>
  <span class="close" onClick="$(this).parents('#add').hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg" style=" overflow:inherit;">
      <ul class="input_msg" style="width:580px;">
        <li>
          <label><span class="dotted colorfe">*</span>物业类型：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="property">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul class="property">
                 <li value="1">普通住宅</li>
                 <li value="2">别墅</li>
                 <li value="3">纯写字楼</li>
                 <li value="4">住宅底商</li>
               </ul>
             </div>
          </div>
          <span style="color:red; margin-left:10px;" id="res_property"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>起始时间：</label>
          <input class="laydate-icon" name="begin" value="" id="time1">
          <span style="color:red; margin-left:10px;" id="res_begin"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>排期名称：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="schedule">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul class="schedule">
                 <li>一期</li>
                 <li>二期</li>
                 <li>三期</li>
                 <li>四期</li>
                 <li>五期</li>
                 <li>六期</li>
               </ul>
             </div>
          </div>
          <span style="color:red; margin-left:10px;" id="res_schedule"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>方案名称：</label>
          <input type="text" name="caseName" value="" class="txt width1">
          <span style="color:red; margin-left:10px;" id="res_caseName"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>每套房款提成：</label>
          <input type="text" name="yjNum" class="txt width4"/>
          <div class="dw" style="margin-right:5px;">
            <a class="term_title"><span id="settlement">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul class="settlement">
                 <li value="1">%</li>
                 <li value="2">元</li>
                 <li value="3">折后取整</li>
               </ul>
             </div>
          </div>
          <span style="color:red; margin-left:10px;" id="res_settlement"></span>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>按房屋面积：</label>
          <div class="yj">
            <input type="text" class="txt width4" name="area1" value="" />
            <span class="tishi" style="margin:0 5px;">至</span>
            <input type="text" class="txt width4" name="area2" value="" />
            <span class="tishi">平米</span>
            <a class="color_blue add_yj">添加</a>
            <span style="color:red; margin-left:10px;" class="res_area"></span>
          </div>
        </li>
        <div class="clear"></div>
        <li><input type="button" class="btn back_color" id="saveYj" style="margin-left:200px !important;" value="保存" /></li>
      </ul>
    </div>
</div>
<div class="change_tel" id="sc">
  <span class="close" onClick="closeDeleteyongjin(this);"></span>
  <h2>删除</h2>
  <div class="change3">
    <p class="p"><i></i>您确定要删除佣金信息吗？</p>
    <p class="p">
      <input type="button" class="btn back_color" style=" width:80px;" id="saveDelete" value="确定" />
      <input type="button" class="btn back_color" style=" width:80px;" value="取消" />
    </p>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<script>
$(function(){
  $('#map').submit(function(e){
	  return false;
  });
  //弹出层调用语句
  $('.modaltrigger').leanModal({
	  top:110,
	  overlay:0.45,
	  closeButton:".hidemodal"
  });
  $(".sub_nav a").click(function(){
	 $(".sub_nav a").removeClass("click");
	 $(this).addClass("click");  
  });
  $(".fh").click(function(){
	  $(".periphery_build").hide(); 
	  $(".periphery_nav").show();
  });
  
  $(".add_yj").click(add_yj_intro);
});
;!function(){
  laydate({
	 elem: '#time1'
  })
  laydate({
	 elem: '#time2'
  })
  laydate({
	 elem: '#time3'
  })
  laydate({
	 elem: '#time4'
  })
}();

function add_yj_intro(){
   var div="<label>&nbsp;</label>\
            <div class='yj'>\
                  <input type='text' class='txt width4' name='area1' value='' />\
                  <span class='tishi' style='margin:0 5px;'>至</span>\
                  <input type='text' class='txt width4' name='area2' value='' />\
                  <span class='tishi'>平米</span>\
                  <a class='color_blue' onclick='del_yj(this);' >删除</a>\
                  <span style='color:red; margin-left:10px;' class='res_area'></span>\
                </div>";
   $(this).parents("li").append(div);
  }
function setContentTab(name, curr) {
    for (i = 1; i <= 4; i++) {
        var menu = document.getElementById(name + i);
        var cont = document.getElementById("con_" + name + "_" + i);
        if (i == curr) {
			$("#" + name + i).addClass("click");
            cont.style.display = "block";
        } else {
			$("#" + name + i).removeClass("click");
            cont.style.display = "none";
        }
    }
}

function del_yj(obj){
    $(obj).parent().prev('label').remove();
    $(obj).parent().remove();
}
var property,begin,schedule,caseName,yjNum,settlement,area;
$('#saveYj').click(function(){
    var patt = /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/;
    area  = new Array();
    if(!property){                                                                              //物业类型
        $('#res_property').text('请选择物业类型');  
    }else{
        $('#res_property').text('');
    }

    begin = testing('input[name="begin"]', /^\S.+$/, '起始时间不能为空', '#res_begin'); // 起始时间

    if(!schedule){                                                                                  // 期数
        $('#res_schedule').text('请选择期数');
    }else{
        $('#res_schedule').text('');
    }

    caseName = testing('input[name="caseName"]', /^\S.+$/, '佣金方案名称不能为空', '#res_caseName'); // 佣金方案名称
    
    if(!settlement){
        $('#res_settlement').text('请选择提成方式');
    }else{
        yjNum = testing('input[name="yjNum"]', patt, '提成数必须为正数或1-2位小数', '#res_settlement'); // 佣金方案数值
    }

    var num = 0;
    $('div.yj').each(function(index){
        var area1 = $(this).children('input[name="area1"]').val();
        var area2 = $(this).children('input[name="area2"]').val();
        if(!patt.test(area1) || !patt.test(area2)){
            $(this).children('.res_area').text('面积均为正数或1-2位小数');
        }else{
            area.push({'area1':area1, 'area2':area2});
            $(this).children('.res_area').text('');
        }
        num++;
    });
    if(area.length < num){
        area = false;
    }
    if(property && begin && schedule && caseName && yjNum && settlement && area){
        var token = $('#token').val();
        var url = '/dynamic/addyongjincase';
        var comid = $('#comid').val();
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token:token,
                comid:comid,
                property:property,
                begin:begin,
                schedule:schedule,
                caseName:caseName,
                yjNum:yjNum,
                settlement:settlement,
                area:area,
                yId:yId
            },
            dataType:'json',
            success:function(data){
                if(data == 1){
                    alert('保存成功');
                    window.location.reload();
                }else{
                    alert('保存失败');
                    window.location.reload();
                }
            }
        });
    }else{
        return false;
    }
});
$('.property li').click(function(){
    property = $(this).attr('value');
});
$('.schedule li').click(function(){
    schedule = $(this).text();
});
$('.settlement li').click(function(){
    settlement = $(this).attr('value');
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
window.onbeforeunload = function(){
    $('input[type="text"]').val('');
}

// 添加佣金方案
function add_yj(){
    clear_error();
    yId         = null;
    $('#property').text('请选择');
    $('input[name="begin"]').val('');
    $('#schedule').text('请选择');
    $('input[name="caseName"]').val('');
    
    property    = null;
    
    settlement  = null;
    $('input[name="yjNum"]').val('');
    $('#settlement').text('请选择');
    
    
    area        = null;
    var div = '<label><span class="dotted colorfe">*</span>按房屋面积：</label>\
          <div class="yj">\
            <input type="text" class="txt width4" name="area1" value="" />\
            <span class="tishi" style="margin:0 5px;">至</span>\
            <input type="text" class="txt width4" name="area2" value="" />\
            <span class="tishi">平米</span>\
            <a class="color_blue add_yj">添加</a>\
            <span style="color:red; margin-left:10px;" class="res_area"></span>\
          </div>';
    var res_html = $('.add_yj').parents("li");
    res_html.html('');
    res_html.append(div);
    $(".add_yj").click(add_yj_intro);
}

var yId;
//删除佣金方案
function del_info(obj){
    yId = $(obj).attr('value');
}

$('#saveDelete').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/deleteyongjin';
    if(yId){
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token:token,
                yId:yId
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
//关闭删除佣金方案
function closeDeleteyongjin(obj){
    $(obj).parent().hide(); 
    $('#lean_overlay').hide();
    yId = '';
}
//修改佣金方案
function edit_yj(obj){
    clear_error();
    var curr    = $(obj).parents('tr').children();
    yId         = $(obj).attr('value');
    pro         = $.trim(curr.eq(1).text());
    $('#property').text(pro);
    $('input[name="begin"]').val($.trim(curr.eq(2).text()));
    schedule    = $.trim(curr.eq(3).text().replace('{{$yongjin->communityName}}', ''));
    $('#schedule').text(schedule);
    $('input[name="caseName"]').val($.trim(curr.eq(4).text()));
    
    if(pro == '普通住宅') property = 1;
    else if(pro == '别墅') property = 2;
    else if(pro == '纯写字楼') property = 3;
    else if(pro == '住宅底商') property = 4;
    
    sett        = $.trim(curr.eq(5).text());
    if(sett.indexOf('%') != -1){
        settlement  = 1;
        $('input[name="yjNum"]').val(sett.replace('%', ''));
        $('#settlement').text('%');
    }else if(sett.indexOf('元') != -1){
        settlement  = 2;
        $('input[name="yjNum"]').val(sett.replace('元', ''));
        $('#settlement').text('元');
    }else if(sett.indexOf('折') != -1){
        settlement  = 3;
        $('input[name="yjNum"]').val(sett.replace('折', ''));
        $('#settlement').text('折后取整');
    }
    
    area        = $.trim(curr.eq(6).text()).split(/\n/);

    var div = '<label><span class="dotted colorfe">*</span>按房屋面积：</label>\
          <div class="yj">\
            <input type="text" class="txt width4" name="area1" value="" />\
            <span class="tishi" style="margin:0 5px;">至</span>\
            <input type="text" class="txt width4" name="area2" value="" />\
            <span class="tishi">平米</span>\
            <a class="color_blue add_yj">添加</a>\
            <span style="color:red; margin-left:10px;" class="res_area"></span>\
          </div>';
    var res_html = $('.add_yj').parents("li");
    res_html.html('');
    res_html.append(div);
    $(".add_yj").click(add_yj_intro);

    div     = '';
    for( var i in area){
        var tmp = area[i].split('-');
        if(i == 0){
            $('.add_yj').parent().children('input[name="area1"]').val($.trim(tmp[0]));
            $('.add_yj').parent().children('input[name="area2"]').val($.trim(tmp[1]).replace('平米', ''));
        }else{
            div += "<label>&nbsp;</label>\
            <div class='yj'>\
                  <input type='text' class='txt width4' name='area1' value='"+ $.trim(tmp[0]) +"' />\
                  <span class='tishi' style='margin:0 5px;'>至</span>\
                  <input type='text' class='txt width4' name='area2' value='"+ $.trim(tmp[1]).replace('平米', '') +"' />\
                  <span class='tishi'>平米</span>\
                  <a class='color_blue' onclick='del_yj(this);' >删除</a>\
                  <span style='color:red; margin-left:10px;' class='res_area'></span>\
                </div>";
        }
    }
    $('.add_yj').parents("li").append(div);
}

// 清除错误信息
function clear_error(){
    $('#res_property').text('');
    $('#res_schedule').text('');
    $('#res_settlement').text('');
    $('.res_area').text('');
    $('#res_begin').text('');
    $('#res_caseName').text('');
}
</script>
</body>
</html>