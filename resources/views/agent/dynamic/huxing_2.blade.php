      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color modaltrigger"  onclick="addhuxing(this);"  href="#add">添加户型信息</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="80">序号</th>
          <th width="80">户型名称</th>
          <th width="80">对应楼栋</th>
          <th width="100">户型图片</th>
          <th width="160">户型信息</th>
          <th width="80">录入时间</th>
          <th width="80">操作</th>
        </tr>
        @if(!empty($room->items()))
          @foreach($room->items() as $rkey => $rval)
          <tr @if( ( $rkey + 1) % 2 == 0) class="backColor" @endif >
            <td>{{sprintf("%'.02d", ($rkey + ( ($room->currentPage() - 1) * 10) ) + 1)}}</td>
            <td>{{$rval->name}}</td>
            <td>{{$rval->bname}}</td>
            <td><img src="{{config('imgConfig.imgSavePath')}}{{$rval->thumbPic}}" width="80" height="50"/></td>
            <td>
              {{$rval->location}}&nbsp;&nbsp;{{$rval->floorage}}平米
            </td>
            <td>{{$rval->timeCreate}}</td>
            <td value="{{$rval->id}}" >未审核&nbsp;&nbsp;<a class="modaltrigger" value="{{json_encode($rval, JSON_UNESCAPED_UNICODE)}}" onclick="edithuxing(this);" href="#add">修改</a>&nbsp;&nbsp;<a href="#sc" class="modaltrigger" onclick="deletehuxing(this);">删除</a></td>
          </tr>
          @endforeach
        @else
        <tr>
          <td colspan="7">暂无数据</td>
        </tr>
        @endif

        <tr>
          <td colspan="7">
            {!!$room->render()!!}
          </td>
        </tr>
      </table>
    </div> 
  </div>
</div>
<div class="main_r add" id="add">
  <h2><span id="actiontype">添加</span>户型信息</h2>
  <span class="close" id="close_room" ></span>
  <div class="write_msg" style="width:700px;">
    <ul class="input_msg">
        <li>
          <label><span class="dotted colorfe">*</span>户型名称：</label>
          <input type="text" class="txt width4" id="roomName" value="" />
          <span class="tishi colorfe">示例：A1</span>
          <span class="res_roomName" style="color:red;margin-left:10px;"></span>
        </li>
        <li id="a">
          <label><span class="dotted colorfe">*</span>户型内容：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="weizhi">请选择</span><i></i></a>
            <div class="list_tag" id="cc">
               <p class="top_icon"></p>
               <ul>
                 <li class="weizhi" value="首层" >首层</li>
                 <li class="weizhi" value="标准层" >标准层</li>
                 <li class="weizhi" value="顶层" >顶层</li>
                 <li class="weizhi" value="地下层" >地下层</li>
                 <li class="weizhi" value="" >其他</li>
               </ul>
             </div>
          </div>
          <input type="text" class="txt width3 cc" id="weizhi2" value="" style="display:none; margin-left:20px;">
          <span class="tishi colorfe cc" style="display:none;">示例：第二层</span>
          <span class="res_weizhi" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>建筑面积：</label>
          <input type="text" class="txt width4" id="floorage" value="" />
          <span class="tishi">平米</span>
          <span class="res_floorage" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>使用面积：</label>
          <input type="text" class="txt width4" id="usableArea" value="" />
          <span class="tishi">平米</span>
          <span class="res_usableArea" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>可售套数：</label>
          <input type="text" class="txt width4" id="num" value="" />
          <span class="tishi">套</span>
          <span class="res_num" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>销售状态：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="state">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li class="state" value="1">在售</li>
                 <li class="state" value="3">售罄</li>
               </ul>
             </div>
          </div>
          <span class="res_state" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>价格：</label>
          <input type="text" class="txt width4" id="price" value="" />
          <span class="tishi">元/平米</span>
          <span class="res_price" style="color:red;margin-left:10px;"></span>
        </li>
        <li style="height:auto; overflow:hidden;">
            <label>户型解析：</label>
            <textarea class="txtarea" id="feature" value="" style=" width:300px; height:40px;"></textarea>
            <span class="res_feature" style="color:red;margin-left:10px;"></span>
        </li>
        <li style="min-height:180px;overflow:hidden;">
          <label><span class="dotted colorfe">*</span>对应户型图：</label>
          <div id="box" class="box">
              <div id="leyout" ></div>
              <div class="parentFileBox">
                <ul class="fileBoxUl">
                </ul>
              </div>
          </div>
        </li>
      <li><input type="button" class="btn back_color" id="next" style="margin-left:270px !important;" value="下一步" /></li>
    </ul>
    <div class="ban" style=" display:none;">
     <p>
      <label><span class="dotted colorfe">*</span>为所录入的户型匹配楼栋及单元</label>
      <span class="res_cbIds" style="color:red;margin-left:10px;"></span>
     </p>
     <ul>
        @if(!empty($room->build))
        @foreach($room->build as $rbval)
        <li>
          <p class="reslut">
            <span class="check_all">
              <input type="checkbox" class="cbIds" value="{{$rbval['id']}}" />
                &nbsp;{{$rbval['num']}}号楼
              </span>
            <span class="check_words"></span>
          </p>
          <div class="chose" style="display:none;">
            <p class="top_icon"></p>
            <ul>
              @if(!empty($unit[$rbval['id']]))
              @foreach($unit[$rbval['id']] as $uval)
              <li><input type="checkbox" class="uIds" value="{{$uval->id}}" />{{$uval->num}}单元</li>
              @endforeach
              @else
              该楼栋下暂无单元信息
              @endif
              <li class="icon" onclick="$(this).parents('.chose').hide();"><i></i></li>
            </ul>
          </div>
        </li>
        @endforeach
        @else
        暂无相关楼栋信息,请先添加楼栋信息
        @endif
      </ul>
     <p>
     <input type="button" class="submit back_color margin_r" style="margin-left:230px;" onclick="$(this).parents('.ban').hide();$('.input_msg').show();" value="上一步"/>
     <input type="button" id="save" class="submit back_color" value="提交"/>
     </p>
    </div>
  </div>
</div>
<div class="change_tel" id="sc">
  <span class="close" onClick="closeDeletehuxing(this);"></span>
  <h2>删除</h2>
  <div class="change3">
    <p class="p"><i></i>您确定要删除户型信息吗？</p>
    <p class="p">
      <input type="button" class="btn back_color" style=" width:80px;" id="saveDelete" value="确定" />
      <input type="button" class="btn back_color" style=" width:80px;" value="取消" />
    </p>
  </div>
</div>
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
});
$(".ban li .check_all").click(function(){
    if($(this).parents("li").find(".chose").css("display")=="none"){
       $(this).parents("li").find(".chose").css("display","block"); 
    }else{
       $(this).parents("li").find(".chose").css("display","none");  
    }
});

$("#type ul li").click(function(){
    if($(this).text()=="楼层户型"){
      $("#a").show();
      $("#b").hide();
    }else{
      $("#b").show();
      $("#a").hide();
    } 
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
  titleImage:false
});


/** 户型信息-商铺 **/

  var roomName, weizhi, floorage, usableArea, num, state, price, cbIds, uIds = '', feature, leyout, rId, delImg = new Array();
  
  $('#close_room').click(function(){
      $(this).parent().children().eq(2).children('ul.input_msg').show();
      $(this).parent().children().eq(2).children('div.ban').hide();
      $(this).parent().hide();
      $('#lean_overlay').hide();
  });

  $('#next').click(function(){
    var weizhi2 = $('#weizhi2').val();
    
    roomName = testing('#roomName', /^\S.*$/, '户型名称不能为空', '.res_roomName');

    if(!weizhi){
        if(weizhi2 == ''){
            $('.res_weizhi').text('户型内容不能为空');
            weizhi = false;
        }else{
            var flag = /^第([\u4e00-\u9fa5]+?)层$/.test(weizhi2);
            if(!flag){
                $('.res_weizhi').text('请按范例填写户型内容');
                weizhi = false;
            }else{
                $('.res_weizhi').text('');
                weizhi = weizhi2;         
            }
        }
    }else{
        $('.res_weizhi').text('');
    }
    
    floorage = testing('#floorage', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '建筑面积为正整数或1-2位小数', '.res_floorage');
    usableArea = testing('#usableArea', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '使用面积为正整数或1-2位小数', '.res_usableArea');
    num = testing('#num', /^[1-9]\d*$/, '可售套数为正整数', '.res_num');
    
    if(!state){
      $('.res_state').text('请选择销售状态');
    }else{
      $('.res_state').text('');
    }

    price = testing('#price', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '价格为正整数或1-2位小数', '.res_price');
    feature = $('#feature').val();
    leyout = getImage('#leyout');
    
    if(roomName && weizhi && floorage && usableArea && num && state && price && leyout){
      $(this).parents('ul').hide();
      $(this).parents('ul').next().show();
    }
    return false;
  });
  
  $('.weizhi').click(function(){
      weizhi = $(this).attr('value');
  });

  $('.state').click(function(){
    state = $(this).attr('value');
  });


  $('.cbIds').click(function(){
    var val = $(this).attr('value');
    var uIds2 = $(this).parents('p.reslut').next('div.chose').children('ul');
    if($(this).prop('checked')){
        if(!cbIds){
          cbIds = val;
        }else{
          var cbidsarr = cbIds.split('|');
          cbidsarr.push(val);
          cbIds = cbidsarr.join('|');
        }
    }else{
        var arr = cbIds.split('|');
        for( i in arr){
          if(arr[i] == val){
            arr.splice(i,1);
            break;
          }
        }
        cbIds = arr.join('|');
        var uIds2_val = [];
        uIds2.children('li').each(function(){
          $(this).children('input.uIds').prop('checked',false);
          var uIds2_all = uIds.split('|');
          for( i in uIds2_all){
            if(uIds2_all[i] == $(this).children('input.uIds').val() ){
              uIds2_all.splice(i,1);
              break;
            }
          }
        });
        $(this).parent('span').next('span.check_words').text('');
    }
  });

  $('.uIds').click(function(){
    var val = $(this).attr('value');
    var txt = $(this).parent().text();
    var unitName = $(this).parents('div.chose').prev('p.reslut').children('span.check_words');
    var cbIds2 =  unitName.prev('span.check_all').children('.cbIds');
    if($(this).prop('checked')){
        if(cbIds2.prop('checked') == false){
            if(!cbIds){
              cbIds = cbIds2.val();
            }else{
              var cbidsarr = cbIds.split('|');
              cbidsarr.push(cbIds2.val());
              cbIds = cbidsarr.join('|');
            }
            unitName.prev('span.check_all').children('.cbIds').prop('checked',true);
        }
        if(!unitName.text()){
            unitName.text(txt);
        }else{
            var unitxt = unitName.text().split(',');
            unitxt.push(txt);
            unitName.text( unitxt.join(',') );
        }

        if(!uIds){
          uIds = val;
        }else{
          var uidsarr = uIds.split('|');
          uidsarr.push(val);
          uIds = uidsarr.join('|');
        }
    }else{
        var arr = uIds.split('|');
        for( i in arr){
          if(arr[i] == val){
            arr.splice(i,1);
            break;
          }
        }
        uIds = arr.join('|');

        var parr = unitName.text().split(',');
        for( i in parr){
          if(parr[i] == txt){
            parr.splice(i,1);
            break;
          }
        }
        unitName.text(parr.join(','));
    }
  });

  $('#save').click(function(){
    var token = $('#token').val();
    var comid = $('#comid').val();
    var pagetype1 = $('#pagetype1').val();
    var pagetype2 = $('#pagetype2').val();
    var url = '/dynamic/addhuxing';

    if(!cbIds || !uIds){
      $('.res_cbIds').text('请选择相关楼栋及单元');
      return false;
    }
    
    $.ajax({
      type:'post',
      url:url,
      data:{
        _token:token,
        id:comid,
        pagetype1:pagetype1,
        pagetype2:pagetype2,
        name:roomName,
        weizhi:weizhi,
        floorage:floorage,
        usableArea:usableArea,
        num:num,
        state:state,
        price:price,
        cbIds:cbIds,
        uIds:uIds,
        feature:feature,
        leyout:leyout,
        rId:rId,
        delImg:delImg
      },
      dataType:'json',
      success:function(data){
        if(data == 1){
          alert('保存成功');
          window.location.reload();
        }
      }
    });
  });
//添加户型信息
function addhuxing(){
    rId = null;
    $('#actiontype').text('添加');
    $('#roomName').val('');
    $('#floorage').val('');
    $('#usableArea').val('');
    $('#num').val('');
    $('#price').val('');
    $('#feature').val('');
    weizhi = null;
    state = null;
    $('#a').show();
    $('#b').hide();
    $('#roomType').text('请选择');
    $('#weizhi').text('请选择');
    $('#weizhi2').text('');
    $('.cc').hide();
    $('#faceTo').text('请选择');
    $('#state').text('请选择');
    $('input[type="checkbox"]').prop('checked',false);
    cbIds = '';
    uIds = '';
    $('.diyUploadHover').remove();
}

//修改户型信息
function edithuxing(obj){
    var val = eval('(' + $(obj).attr('value') + ')');
    rId = $(obj).parent('td').attr('value');
    $('#actiontype').text('修改');
    $('#roomName').val(val.name);
    $('#floorage').val(val.floorage);
    $('#usableArea').val(val.usableArea);
    $('#num').val(val.num);
    $('#price').val(val.price);
    $('#feature').val(val.feature);
    weizhi = val.location;
    state = val.state;
    image = val.roomimage;
    uIds = val.unitIds;
    cbIds = val.cbIds;
    switch(weizhi){
        case '首层':
        $('#weizhi').text('首层');
        break;

        case '标准层':
        $('#weizhi').text('标准层');
        break;

        case '顶层':
        $('#weizhi').text('顶层');
        break;

        case '地下层':
        $('#weizhi').text('地下层');
        break;

        default:
        $('#weizhi').text('其他');
        $('#weizhi2').text(weizhi);
        $('.cc').show();
    }

    if(state == 1){
        $('#state').text('在售');
    }
    if(state == 3){
        $('#state').text('售罄');
    }
    if( typeof image != 'null' || typeof image != 'undefined'){
        var lis = '';
        for( var i in image){
            lis += '<li class="diyUploadHover">';         
            lis += '<div class="viewThumb"><img src="'+ '{{config("imgConfig.imgSavePath")}}' +image[i].fileName +'"></div>';
            lis += '<div class="diyCancel" value="' + image[i].id + '" onclick="deleteimg(this);"></div><div class="diySuccess"></div>';
            lis += '<div class="cz"><input type="text" placeholder="描述/别名" class="diyFileName" value="' + image[i].note + '"></div>';       
            lis += '</li>';
        }
        $('ul.fileBoxUl').html(lis);
    }

    $('.cbIds').each(function(){
        if( cbIds.indexOf($(this).val()) != -1){
            $(this).prop('checked',true);
        }
    });
    cbIds = cbIds.join('|');
    
    $('.uIds').each(function(){
        if( uIds.indexOf($(this).val()) != -1){
            $(this).prop('checked',true);
        }
    });
    uIds = uIds.join('|');
}

//删除户型信息
function deletehuxing(obj){
    rId = $(obj).parent('td').attr('value');
}

$('#saveDelete').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/deleteroom';

    if(rId){
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token:token,
                rId:rId
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
//关闭删除户型信息
function closeDeletehuxing(obj){
    $(obj).parent().hide(); 
    $('#lean_overlay').hide();
    rId = '';
}

//删除图片
function deleteimg(obj){
    delImg.push($.trim($(obj).attr('value')));
    $(obj).parents('li.diyUploadHover').remove();
}
window.onbeforeunload = function(){
    $('input[type="checkbox"]').prop('checked',false);
}


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


// 获取上传的图片信息
function getImage(obj){
  var sonList = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').children();
  var images = [];
  if(sonList.length < 1){
      alert('户型图至少要1张');
      return false;
  }
  sonList.each(function(index){
      images[index] = {
          img:$(this).children('div.viewThumb').children('img').attr('src'),
          note:$(this).find('.diyFileName').val(),
          id:$(this).find('.diyCancel').attr('value')
      };
  });
  return images;
}
</script>
</body>
</html>