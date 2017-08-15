      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color modaltrigger addsale" href="#pq">添加排期信息</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="120">序号</th>
          <th width="120">排期名称</th>
          <th width="120">当期价格</th>
          <th width="120">可售户数</th>
          <th width="120">出售楼栋</th>
          <th width="120">开盘时间</th>
          <th width="120">操作</th>
        </tr>
        @if(!empty($sale->items()))
          @foreach($sale->items() as $skey => $sval)
          <tr  @if( ( $skey + 1) % 2 == 0) class="backColor" @endif >
            <td>{{sprintf("%'.02d", ($skey + ( ($sale->currentPage() - 1) * 10) ) + 1)}}</td>
            <td>{{$sval->period}}</td>
            <td>
              @if(!empty($sval->saleAvgPrice))
              {{$sval->saleAvgPrice}}
              @else
              {{$sval->rentAvgPrice}}
              @endif
              元/平米
            </td>
            <td>{{$sval->houseNum}}户</td>
            <td>{{$sval->bname}}</td>
            <td>{{$sval->openTime}}</td>
            <td>
              <a class="modaltrigger editSale"  value="{{json_encode($sval, JSON_UNESCAPED_UNICODE)}}" href="#pq">修改</a>&nbsp;&nbsp;<a class="modaltrigger deleteSale" value="{{$sval->id}}" href="#sc">删除</a>
            </td>
          </tr>
          @endforeach
        @else
        <tr>
          <td colspan="7">暂无数据</td>
        </tr>
        @endif
        <tr>
          <td colspan="7">
            {!!$sale->render()!!}
          </td>
        </tr>
      </table>
    </div>
    <div class="add" id="pq">
      <h2>维护排期信息</h2>
      <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
          <div class="write_msg">
            <ul class="input_msg enter_build">
              <li>
                <label><span class="dotted colorfe">*</span>排期名称：</label>
                <div class="dw" style="margin-left:0;">
                  <a class="term_title"><span id="paiQi1">请选择</span><i></i></a>
                  <div class="list_tag">
                     <p class="top_icon"></p>
                     <ul class="paiQi1">
                       <li>一期</li>
                       <li>二期</li>
                       <li>三期</li>
                       <li>四期</li>
                       <li>五期</li>
                       <li>六期</li>
                     </ul>
                   </div>
                </div>
                <span id="res_paiQi1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label><span class="dotted colorfe">*</span>开盘时间：</label>
                <input class="laydate-icon" name="kaiPan1" value="" id="time3">
                <span id="res_kaiPan1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label><span class="dotted colorfe">*</span>交房时间：</label>
                <input class="laydate-icon" name="jiaoFang1" value="" id="time4">
                <span id="res_jiaoFang1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label>商品房预售许可证：</label>
                <input type="text" name="yuShou1" value="" class=" txt width2" />
                <span id="res_yuShou1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label><span class="dotted colorfe">*</span>营销方式：</label>
                <div class="dw" id="market" style="margin-left:0;">
                  <a class="term_title"><span id="saleType">请选择</span><i></i></a>
                  <div class="list_tag">
                     <p class="top_icon"></p>
                     <ul class="saleType">
                       <li value="1">出售</li>
                       <li value="2">出租</li>
                       <li value="3">租售皆可</li>
                     </ul>
                   </div>
                </div>
                <span id="res_saleType1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label><span class="dotted colorfe">*</span>当期户数：</label>
                <input type="text" name="countNum1" value="" class="txt width2">
                <span id="res_countNum1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="no_height">
                <label><span class="dotted colorfe">*</span>当期楼栋：</label>
                <div class="chose_ban" style="margin:0; height:auto;">
                   <ul class="saleCbids1">
                    @if(!empty($sale->build))
                    @foreach($sale->build as $sbval)
                    <li value="{{$sbval['id']}}">{{$sbval['num']}}号楼</li>
                    @endforeach
                    @else
                    暂无相关楼栋信息,请先添加楼栋信息
                    @endif
                   </ul>
                </div>
                <span id="res_saleCbids1" style="color:red;margin-left:140px;"></span>
              </li>
              <li class="rent">
                <label><span class="dotted colorfe">*</span>项目租赁最高价：</label>
                <input type="text" name="zuGao1" value="" class="txt width2">
                <div class="dw" style="width:90px;">
                  <a class="term_title"><span id="zuGaoUnit1">元/平米·月</span><i></i></a>
                  <div class="list_tag" style="width:80px;">
                     <p class="top_icon"></p>
                     <ul class="zuGaoUnit1">
                       <li value="1">元/平米·天</li>
                       <li value="2">元/平米·月</li>
                       <li value="3">元/月</li>
                     </ul>
                   </div>
                </div>
                <span id="res_zuGao1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="rent">
                <label><span class="dotted colorfe">*</span>项目租赁最低价：</label>
                <input type="text" name="zuDi1" value="" class="txt width2">
                <div class="dw" style="width:90px;">
                  <a class="term_title"><span id="zuDi1">元/平米·月</span><i></i></a>
                  <div class="list_tag" style="width:80px;">
                     <p class="top_icon"></p>
                     <ul class="zuDi1">
                       <li value="1">元/平米·天</li>
                       <li value="2">元/平米·月</li>
                       <li value="3">元/月</li>
                     </ul>
                   </div>
                </div>
                <span id="res_zuDi1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="rent">
                <label><span class="dotted colorfe">*</span>项目租赁均价：</label>
                <input type="text" name="zuPing1" value="" class="txt width2">
                <div class="dw" style="width:90px;">
                  <a class="term_title"><span id="zuPing1">元/平米·月</span><i></i></a>
                  <div class="list_tag" style="width:80px;">
                     <p class="top_icon"></p>
                     <ul class="zuPing1">
                       <li value="1">元/平米·天</li>
                       <li value="2">元/平米·月</li>
                       <li value="3">元/月</li>
                     </ul>
                   </div>
                </div>
                <span id="res_zuPing1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="rent" style="height:auto; overflow:hidden;">
                <label><span class="dotted colorfe">*</span>价格描述：</label>
                <div class="float_l" style=" float:left; width:220px; height:62px;">
                 <textarea class="txtarea" id="zuDesc1" value="" style=" width:200px; height:50px;"></textarea>
                </div>
                <span id="res_zuDesc1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="sale">
                <label><span class="dotted colorfe">*</span>项目最高价：</label>
                <input type="text" name="shouGao1" value="" class="txt width2">
                <span class="tishi">元/平米</span>
                <span id="res_shouGao1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="sale">
                <label><span class="dotted colorfe">*</span>项目最低价：</label>
                <input type="text" name="shouDi1" value="" class="txt width2">
                <span class="tishi">元/平米</span>
                <span id="res_shouDi1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="sale">
                <label><span class="dotted colorfe">*</span>项目均价：</label>
                <input type="text" name="shouPing1" value="" class="txt width2">
                <span class="tishi">元/平米</span>
                <span id="res_shouPing1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="sale" style="height:auto; overflow:hidden;">
                <label><span class="dotted colorfe">*</span>价格描述：</label>
                <div class="float_l" style=" float:left; width:220px; height:62px;">
                 <textarea class="txtarea" id="shouDesc1" value="" style=" width:200px; height:50px;"></textarea>
                </div>
                <span id="res_shouDesc1" style="color:red;margin-left:140px;"></span>
              </li>
              <li class="sale" style="width:100%; height:auto;">
                <label><span class="dotted colorfe">*</span>折扣信息：</label>
                <div class="dw" style="margin-left:0; margin-right:15px;">
                  <a class="term_title"><span id="zheType">请选择</span><i></i></a>
                  <div class="list_tag">
                     <p class="top_icon"></p>
                     <ul class="zheType">
                       <li id="c1" value="1" onclick="discount_2('c',1)">折扣</li>
                       <li id="c2" value="2" onclick="discount_2('c',2)">直接减去</li>
                       <li id="c3" value="3" onclick="discount_2('c',3)">折后减去</li>
                     </ul>
                   </div>
                </div>
                <div id="con_c_1">
                  <input type="text" name="zhiZhe1" class="txt width3">
                  <span class="tishi">折</span>
                  <span class="tishi colorfe">示例：9.8折</span>
                </div>
                <div id="con_c_2" style="display:none;">
                  <span class="tishi">房屋总款直接减去</span>
                  <input type="text" name="zhiJian1"  class="txt width4">
                  <span class="tishi">元</span>
                  <span class="tishi colorfe">示例：2000元</span>
                </div>
                <div id="con_c_3" style="display:none;">
                  <input type="text" name="houZhe1" class="txt width3">
                  <span class="tishi">折</span>
                  <span class="tishi">折后减去</span>
                  <input type="text" name="houJian1" class="txt width4">
                  <span class="tishi">元</span>
                  <span class="tishi colorfe">示例：9折后直减2000元</span>
                </div>
                <span id="res_zhe1" style="color:red;margin-left:10px;"></span>
              </li>
              <li class="no_height sale" style="margin-top:10px;">
                <label><span class="dotted colorfe">*</span>电商优惠信息：</label>
                <input type="text" name="fu1" class="txt width3" />
                <span class="tishi marginR">抵</span>
                <input type="text" name="di1" class="txt width3" />
                <span class="tishi margin_left">示例：10000抵20000</span>
                <span id="res_dianYou1" style="color:red;margin-left:10px;"></span>
              </li>
              <div class="clear"></div>
             </ul>
           </div>
          <p class="submit" style="width:900px; margin:0 0 20px;">
            <input type="button" class="btn back_color" id="saleAddSave1" style=" float:none; margin-left:400px !important;" value="保存" />
          </p>
    </div>
  </div>
</div>

<div class="change_tel" id="sc" style="top:250px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>确认删除</h2>
  <div class="change3">
    <p class="p" style="width:200px;">确定删除该点评信息吗?</p>
  </div>
  <div class="submit">
    <a class="btn back_color margin_r delete" id="saveDelete">确定</a>
    <a class="btn back_color" onClick="$('#sc').hide(); $('#lean_overlay').hide();">取消</a>
  </div>
</div>

<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
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
  
  $(".input_msg .chose_ban li").click(function(){
   $(this).toggleClass("click");  
  });
});
</script>
<script>
$(function(){  
  $("#market ul li").click(function(){
   var text=$(this).text();
   if(text=="出售"){
    $(".sale").show(); 
    $(".rent").hide(); 
   }else if(text=="出租" ){
    $(".rent").show(); 
    $(".sale").hide(); 
     }else if(text=="租售皆可" ){
    $(".rent").show(); 
    $(".sale").show(); 
     }
  });
});
</script>
<script>
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

function setContentTab(name, curr) {
    for (i = 1; i <= 5; i++) {
        var menu = document.getElementById(name + i);
        var cont = document.getElementById("con_" + name + "_" + i);
        menu.className = i == curr ? "up" : "";
        if (i == curr) {
            $(menu).addClass('click');
            cont.style.display = "block";
        } else {
            $(menu).removeClass('click');
            cont.style.display = "none";
        }
    }
}


var communityName = $('#communityName').val();
var url = '/addsaleinfo';
var token = $('#token').val();
var comid = $('#comid').val();
var pagetype1 = $('#pagetype1').val();
var pagetype2 = $('#pagetype2').val();

/** 添加 营销信息 **/
$(function(){
  var paiQi, kaiPan, jiaoFang, yuShou, saleType, countNum, cbIds, 
  zuGao, zuGaoUnit='1', zuDi, zuDiUnit='1', zuPing, zuPingUnit='1', zuDesc, 
  shouGao, shouDi, shouPing, shouDesc, 
  zheType, zhe, jian, dianYou;
  
  $('.paiQi1 li').click(function(){
    paiQi = communityName + $(this).text();
  });
  $('.saleType li').click(function(){
    saleType = $(this).attr('value');
  });
  $('.zheType li').click(function(){
    zheType = $(this).attr('value');
  });
  $('.saleCbids1 li').click(function(){
    var val = $(this).attr('value');
    if(!cbIds){
      cbIds = val;
    }else{
      var str = cbIds.indexOf(val);
      var arr = cbIds.split('|');
      if(str == -1){
        arr.push(val);
        cbIds = arr.join('|');
      }else{
        for( i in arr){
          if(arr[i] == val){
            arr.splice(i,1);
            break;
          }
        }
        cbIds = arr.join('|');
      }
    }
  });
  $('.zuGaoUnit1 li').click(function(){
    zuGaoUnit = $(this).attr('value');
  });
  $('.zuDiUnit1 li').click(function(){
    zuDiUnit = $(this).attr('value');
  });
  $('.zuPingUnit1 li').click(function(){
    zuPingUnit = $(this).attr('value');
  });
  $('#saleAddSave1').click(function(){
    if(!paiQi){
      $('#res_paiQi1').text('请选择期数');
    }else{
      $('#res_paiQi1').text('');
    }
    kaiPan = testing('input[name="kaiPan1"]', /^\S.*$/, '不能为空', '#res_kaiPan1');
    jiaoFang = testing('input[name="jiaoFang1"]', /^\S.*$/, '不能为空', '#res_jiaoFang1');
    yuShou = $('input[name="yuShou1"]').val();
    if(!saleType){
      $('#res_saleType1').text('请选择营销方式');
    }else{
      $('#res_saleType1').text('');
    }
    countNum = testing('input[name="countNum1"]', /^[1-9]\d*$/, '正整数', '#res_countNum1');
    if(!cbIds){
      $('#res_saleCbids1').text('请选择相关楼栋');
    }else{
      $('#res_saleCbids1').text('');
    }
    
    if(saleType == 1){
      getShou();
      if( paiQi && kaiPan && jiaoFang && saleType && countNum && cbIds && shouGao && shouDi && shouPing && shouDesc && zheType && zhe && jian && dianYou){
        $.ajax({
          type:'post',
          url:url,
          data:{
            _token:token,
            id:comid,
            pagetype1:pagetype1,
            pagetype2:pagetype2,
            paiQi:paiQi,
            kaiPan:kaiPan,
            yuShou:yuShou,
            jiaoFang:jiaoFang,
            saleType:saleType,
            countNum:countNum,
            cbIds:cbIds,
            shouGao:shouGao,
            shouDi:shouDi,
            shouPing:shouPing,
            shouDesc:shouDesc,
            zheType:zheType,
            zhe:zhe,
            jian:jian,
            dianYou:dianYou,
            sId:sId
          },
          dataType:'json',
          success:function(data){
            if(data == 1){
              xalert({
                  title:'提示',
                  content:'保存成功!'
              });
              window.location.reload();
            }else{
              xalert({
                  title:'提示',
                  content:'保存失败!'
              });
              window.location.reload();
            }
          }
        });
      }else{  
        return false;
      }
    }else if(saleType == 2){
      getZu();
      if( paiQi && kaiPan && jiaoFang && saleType && countNum && cbIds && zuGao && zuGaoUnit && zuDi && zuDiUnit && zuPing && zuPingUnit && zuDesc ){
        $.ajax({
          type:'post',
          url:url,
          data:{
            _token:token,
            id:comid,
            pagetype1:pagetype1,
            pagetype2:pagetype2,
            paiQi:paiQi,
            kaiPan:kaiPan,
            yuShou:yuShou,
            jiaoFang:jiaoFang,
            saleType:saleType,
            countNum:countNum,
            cbIds:cbIds,
            zuGao:zuGao,
            zuGaoUnit:zuGaoUnit,
            zuDi:zuDi,
            zuDiUnit:zuDiUnit,
            zuPing:zuPing,
            zuPingUnit:zuPingUnit,
            zuDesc:zuDesc,
            sId:sId
          },
          dataType:'json',
          success:function(data){
            if(data == 1){
              xalert({
                  title:'提示',
                  content:'保存成功!'
              });
              window.location.reload();
            }else{
              xalert({
                  title:'提示',
                  content:'保存失败!'
              });
              window.location.reload();
            }
          }
        });
      }else{
        return false;
      }
    }else if(saleType == 3){
      getZu();
      getShou();
      if( paiQi && kaiPan && jiaoFang && saleType && countNum && cbIds && zuGao && zuGaoUnit && zuDi && zuDiUnit && zuPing && zuPingUnit && zuDesc && shouGao && shouDi && shouPing && shouDesc && zheType && zhe && jian && dianYou){
        $.ajax({
          type:'post',
          url:url,
          data:{
            _token:token,
            id:comid,
            pagetype1:pagetype1,
            pagetype2:pagetype2,
            paiQi:paiQi,
            kaiPan:kaiPan,
            jiaoFang:jiaoFang,
            saleType:saleType,
            yuShou:yuShou,
            countNum:countNum,
            cbIds:cbIds,
            zuGao:zuGao,
            zuGaoUnit:zuGaoUnit,
            zuDi:zuDi,
            zuDiUnit:zuDiUnit,
            zuPing:zuPing,
            zuPingUnit:zuPingUnit,
            zuDesc:zuDesc,
            shouGao:shouGao,
            shouDi:shouDi,
            shouPing:shouPing,
            shouDesc:shouDesc,
            zheType:zheType,
            zhe:zhe,
            jian:jian,
            dianYou:dianYou,
            sId:sId
          },
          dataType:'json',
          success:function(data){
            if(data == 1){
              xalert({
                  title:'提示',
                  content:'保存成功!'
              });
              window.location.reload();
            }else{
              xalert({
                  title:'提示',
                  content:'保存失败!'
              });
              window.location.reload();
            }
          }
        });
      }else{  
        return false;
      }
    }else{
      return false;
    }
  });

  //售房营销方式
  function getShou(){
    shouGao = testing('input[name="shouGao1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_shouGao1');
    shouDi = testing('input[name="shouDi1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_shouDi1');
    shouPing = testing('input[name="shouPing1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_shouPing1');
    shouDesc = testing('#shouDesc1', /^\S.*$/, '售价描述不能为空', '#res_shouDesc1');
    if(!zheType){
      $('#res_zhe1').text('请选择折扣信息');
    }else{
      if(zheType == 1){
        zhe = testing('input[name="zhiZhe1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '折扣信息格式不正确', '#res_zhe1');
        jian = true;
      }else if(zheType == 2){
        jian = testing('input[name="zhiJian1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_zhe1');
        zhe = true;
      }else if(zheType == 3){
        zhe = testing('input[name="houZhe1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '折扣信息格式不正确', '#res_zhe1');
        if(zhe){
          jian = testing('input[name="houJian1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_zhe1');
        }
      }else{
        zheType = false;
      }
    }

    if( !/^\S.*$/.test($('input[name="fu1"]').val()) || !/^\S.*$/.test($('input[name="di1"]').val()) ){
      $('#res_dianYou1').text('不能为空');
      dianYou = false;
    }else{
      $('#res_dianYou1').text('');
      dianYou = $('input[name="fu1"]').val() + '_' + $('input[name="di1"]').val();
    }
  }

  //租房营销方式
  function getZu(){
    zuGao = testing('input[name="zuGao1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_zuGao1');
    zuDi = testing('input[name="zuDi1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_zuDi1');
    zuPing = testing('input[name="zuPing1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '正整数或1-2位小数', '#res_zuPing1');
    zuDesc = testing('#zuDesc1', /^\S.*$/, '不能为空', '#res_zuDesc1');
  }

  //修改营销信息
  $('.editSale').click(function(){
      var val = eval( '(' + $(this).attr('value') + ')');
      sId = val.id;
      paiQi = val.period;
      $('#paiQi1').text(paiQi.replace(communityName, ''));
      kaiPan = val.openTime.substr(0, 10);
      $('input[name="kaiPan1"]').val(kaiPan);
      jiaoFang = val.takeTime.substr(0, 10);
      $('input[name="jiaoFang1"]').val(jiaoFang);
      yuShou = val.preSalePermit;
      $('input[name="yuShou1"]').val(yuShou);
      saleType = val.marketingType;
      switch(saleType){
          case 1:
          $('#saleType').text('出售');
          $('.rent').hide();
          $('.sale').show();
          break;

          case 2:
          $('.sale').hide();
          $('.rent').show();
          $('#saleType').text('出租');
          break;

          case 3:
          $('.rent').show();
          $('.sale').show();
          $('#saleType').text('租售皆可');
          break;

          default:
          $('.rent').hide();
          $('.sale').hide();
          $('#saleType').text('请选择');
          break;
      }
      countNum = val.houseNum;
      $('input[name="countNum1"]').val(countNum);
      cbIds = val.cbIds;
      $('ul.saleCbids1').children('li').each(function(){
          if( cbIds.indexOf( $(this).attr('value')) != -1){
              $(this).addClass('click');
          }
      });
      cbIds = cbIds.join('|');
      zuGao = val.rentMaxPrice;
      $('input[name="zuGao1"]').val(zuGao);
      zuGaoUnit = val.rentMaxPriceUnit;
      switch(zuGaoUnit){
          case 2:
          $('#zuGaoUnit1').text('元/平米·月');
          break;

          case 3:
          $('#zuGaoUnit1').text('元/月');
          break;

          default:
          $('#zuGaoUnit1').text('元/平米·天');
      }
      zuDi = val.rentMinPrice;
      $('input[name="zuDi1"]').val(zuDi);
      zuDiUnit = val.rentMinPriceUnit;
      switch(zuDiUnit){
          case 2:
          $('#zuDi1').text('元/平米·月');
          break;

          case 3:
          $('#zuDi1').text('元/月');
          break;

          default:
          $('#zuDi1').text('元/平米·天');
      }
      zuPing = val.rentAvgPrice;
      $('input[name="zuPing1"]').val(zuPing);
      zuPingUnit = val.rentAvgPriceUnit;
      switch(zuPingUnit){
          case 2:
          $('#zuPing1').text('元/平米·月');
          break;

          case 3:
          $('#zuPing1').text('元/月');
          break;

          default:
          $('#zuPing1').text('元/平米·天');
      }
      zuDesc = val.rentPriceDescription; 
      $('#zuDesc1').val(zuDesc);

      shouGao = val.saleMaxPrice;
      $('input[name="shouGao1"]').val(shouGao);
      shouDi = val.saleMinPrice;
      $('input[name="shouDi1"]').val(shouDi);
      shouPing = val.saleAvgPrice;
      $('input[name="shouPing1"]').val(shouPing);
      shouDesc = val.salePriceDescription;
      $('#shouDesc1').val(shouDesc);

      zheType = val.discountType;
      zhe = val.discount;
      jian = val.subtract;
      dianYou = val.specialOffers.split('_');
      switch(zheType){
          case 1:
          $('#zheType').text('折扣');
          $('input[name="zhiZhe1"]').val(zhe);
          $('#con_c_3, #con_c_2').hide();
          $('#con_c_1').show();
          break;

          case 2:
          $('#zheType').text('直接减去');
          $('input[name="zhiJian1"]').val(jian);
          $('#con_c_1, #con_c_3').hide();
          $('#con_c_2').show();
          break;

          case 3:
          $('#zheType').text('折后减去');
          $('input[name="houzhe1"]').val(zhe);
          $('input[name="houJian1"]').val(jian);
          $('#con_c_1, #con_c_2').hide();
          $('#con_c_3').show();
          break;

          default:
          $('#zheType').text('请选择');
          $('input[name="zhiZhe1"]').val('');
          $('#con_c_3, #con_c_2').hide();
          $('#con_c_1').show();
      }
      $('input[name="fu1"]').val(dianYou[0]);
      $('input[name="di1"]').val(dianYou[1]);
      dianYou = dianYou.join('_');
      // console.log(val);
  });

  //添加营销信息
  $('.addsale').click(function(){
      sId = null;
      paiQi = null;
      $('#paiQi1').text('请选择');
      kaiPan = null;
      $('input[name="kaiPan1"]').val('');
      jiaoFang = null;
      $('input[name="jiaoFang1"]').val('');
      yuShou = null;
      $('input[name="yuShou1"]').val('');
      saleType = null;
      $('.rent').hide();
      $('.sale').hide();
      $('#saleType').text('请选择');
      countNum = null;
      $('input[name="countNum1"]').val('');
      cbIds = null;
      $('ul.saleCbids1').children('li').each(function(){
          $(this).removeClass('click');
      });
      
      zuGao = null;
      $('input[name="zuGao1"]').val('');
      zuGaoUnit = 1;
      $('#zuGaoUnit1').text('元/平米·天');
      zuDi = null;
      $('input[name="zuDi1"]').val('');
      zuDiUnit = 1;
      $('#zuDi1').text('元/平米·天');
      zuPing = null;
      $('input[name="zuPing1"]').val('');
      zuPingUnit = 1;
      $('#zuPing1').text('元/平米·天');
      zuDesc = null; 
      $('#zuDesc1').val('');

      shouGao = null;
      $('input[name="shouGao1"]').val('');
      shouDi = null;
      $('input[name="shouDi1"]').val('');
      shouPing = null;
      $('input[name="shouPing1"]').val('');
      shouDesc = null;
      $('#shouDesc1').val('');

      zheType = null;
      zhe = null;
      jian = null;
      dianYou = null;
      $('#zheType').text('请选择');
      $('input[name="zhiZhe1"]').val('');
      $('#con_c_3, #con_c_2').hide();
      $('#con_c_1').show();

      $('input[name="fu1"]').val('');
      $('input[name="di1"]').val('');
  });

  //删除营销信息    删除排期维护信息
  $('.deleteSale').click(function(){
    sId = $(this).attr('value');
    $('#deletename').text('营销');
  });
  $('#saveDelete').click(function(){
      var url = '/deletesale';
      if(typeof sId != 'undefined'){
          $.ajax({
              type:'post',
              url:url,
              data:{
                  _token:token,
                  sId:sId
              },
              dataType:'json',
              success:function(data){
                  if(data == 1){
                      xalert({
                          title:'提示',
                          content:'删除成功!',
                      });
                      window.location.reload();
                  }else{
                      xalert({
                          title:'提示',
                          content:'删除失败!',
                      });
                      window.location.reload();
                  }
              }
          });
      }
      if(typeof lId != 'undefined'){
          $.ajax({
              type:'post',
              url:url,
              data:{
                  _token:token,
                  lId:lId
              },
              dataType:'json',
              success:function(data){
                  if(data == 1){
                      xalert({
                          title:'提示',
                          content:'删除成功!',
                      });
                      window.location.reload();
                  }else{
                      xalert({
                          title:'提示',
                          content:'删除失败!',
                      });
                      window.location.reload();
                  }
              }
          });
      }
      return false;   
  });

  //取消删除营销信息
  $('.closeDeleteloudong').click(function(){
      sId = null;
      lId = null;
      $(this).parent().hide();
      $('#lean_overlay').hide();
  });
});



</script>
</body>
</html>