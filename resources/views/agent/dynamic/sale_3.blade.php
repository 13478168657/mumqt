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
              @if($status == 1)
              未审核&nbsp;&nbsp;<a class="modaltrigger editSale"  value="{{json_encode($sval, JSON_UNESCAPED_UNICODE)}}" href="#pq">修改</a>&nbsp;&nbsp;<a class="modaltrigger deleteSale" value="{{$sval->id}}" href="#sc">删除</a>
              @else
              <a class="modaltrigger updateDynamic" value="{{$sval->id}}" href="#add">维护动态信息</a>
              <input type="hidden" class="bid" value="{{$sval->bid}}">
              @endif
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
    <div class="add" id="add" style="width:960px;">
      <h2>维护排期信息</h2>
      <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
      <div class="write_msg">
        <p class="manage_title">
          <a id="a1" onclick="setContentTab('a',1)" class="click dynamicInfo">价格</a>
          <a id="a2" onclick="setContentTab('a',2)" class="dynamicInfo">在售户数</a>
          <a id="a3" onclick="setContentTab('a',3)" class="dynamicInfo">折扣信息</a>
          <a id="a4" onclick="setContentTab('a',4)" class="dynamicInfo">电商优惠</a>
          <a id="a5" onclick="setContentTab('a',5)" class="dynamicInfo">添加楼栋</a>
        </p>
      </div>
      <div class="message" id="con_a_1">
        <div class="write_msg">
          <ul class="input_msg">
            <li>
              <label><span class="dotted colorfe">*</span>最高价格：</label>
              <input type="text" name="shouGao1_2" value="" class="txt width2" />
              <span class="tishi">元/平米</span>
              <span id="res_shouGao1_2" style="color:red;margin-left:10px;"></span>
            </li>
            <li>
              <label><span class="dotted colorfe">*</span>均价：</label>
              <input type="text" name="shouPing1_2" value="" class="txt width2" />
              <span class="tishi">元/平米</span>
              <span id="res_shouPing1_2" style="color:red;margin-left:10px;"></span>
            </li>
            <li>
              <label><span class="dotted colorfe">*</span>最低价格：</label>
              <input type="text" name="shouDi1_2" class="txt width2">
              <span class="tishi">元/平米</span>
              <span id="res_shouDi1_2" style="color:red;margin-left:10px;"></span>
            </li>
            <li style="height:auto; overflow:hidden;">
              <label><span class="dotted colorfe">*</span>价格描述：</label>
              <textarea class="txtarea" id="shouDesc1_2" value="" style=" width:300px; height:40px;"></textarea>
              <span id="res_shouDesc1_2" style="color:red;margin-left:10px;"></span>
            </li>
          </ul>
        </div>
        <p class="submit">
          <input type="button" class="btn back_color" id="updatePrice1" style="float:none;" value="提交" />
        </p>
        <div class="examine">
          <table class="audit">
          </table>
        </div>
      </div>
      <div class="message" id="con_a_2" style="display:none;">
        <div class="write_msg">
          <ul class="input_msg">
            <li>
              <label><span class="dotted colorfe">*</span>在售户数：</label>
              <input type="text" name="countNum1_2" value="" class="txt width3">
              <span class="tishi">户</span>
              <span id="res_countNum1_2" style="color:red;margin-left:10px;"></span>
            </li>
          </ul>
        </div>
        <p class="submit">
          <input type="button" class="btn back_color" id="updateNum1" style="float:none;" value="提交" />
        </p>
        <div class="examine">
          <table class="audit">
          </table>
        </div>
      </div>
      <div class="message" id="con_a_3" style="display:none;">
        <div class="write_msg" style="overflow:inherit;">
          <ul class="input_msg">
            <li>
              <label><span class="dotted colorfe">*</span>折扣信息：</label>
              <div class="dw" style="margin-left:0; margin-right:15px;">
                <a class="term_title"><span>折扣</span><i></i></a>
                <div class="list_tag">
                   <p class="top_icon"></p>
                   <ul class="zheType1_2" >
                     <li id="b1" value="1" onclick="discount_2('b',1)">折扣</li>
                     <li id="b2" value='2' onclick="discount_2('b',2)">直接减去</li>
                     <li id="b3" value="3" onclick="discount_2('b',3)">折后减去</li>
                   </ul>
                 </div>
              </div>
              <div id="con_b_1">
                <input type="text" name="zhiZhe1_2" value="" class="txt width3">
                <span class="tishi">折</span>
                <span class="tishi colorfe">示例：9.8折</span>
              </div>
              <div id="con_b_2" style="display:none;">
                <span class="tishi">房屋总款直接减去</span>
                <input type="text" name="zhiJian1_2" value="" class="txt width4">
                <span class="tishi">元</span>
                <span class="tishi colorfe">示例：2000元</span>
              </div>
              <div id="con_b_3" style="display:none;">
                <input type="text" name="houZhe1_2" value="" class="txt width3">
                <span class="tishi">折</span>
                <span class="tishi">折后减去</span>
                <input type="text" name="houJian1_2" class="txt width4">
                <span class="tishi">元</span>
                <span class="tishi colorfe">示例：9折后直减2000元</span>
              </div>
              <span id="res_zhe1_2" style="color:red;margin-left:10px;"></span>
            </li>
            <li style="height:auto; overflow:hidden;">
              <label>折扣描述：</label>
              <textarea class="txtarea" id="zheDesc1_2" style=" width:300px; height:40px;"></textarea>
            </li>
          </ul>
        </div>
        <p class="submit">
          <input type="button" class="btn back_color" id="updateZhe1" style="float:none;" value="提交" />
        </p>
        <div class="examine">
          <table class="audit">
          </table>
        </div>
      </div>
      <div class="message" id="con_a_4" style="display:none;">
        <div class="write_msg">
          <ul class="input_msg">
            <li>
              <label><span class="dotted colorfe">*</span>电商优惠信息：</label>
              <input type="text" name="fu1_2" value="" class="txt width3" />
              <span class="tishi">万</span>
              <span class="tishi">抵</span>
              <input type="text" name="di1_2" value="" class="txt width3" />
              <span class="tishi">万</span>
              <span class="tishi">示例：1万抵2万</span>
              <span id="res_dianYou1_2" style="color:red;margin-left:10px;"></span>
            </li>
            <li style="height:auto; overflow:hidden;">
              <label>电商优惠描述：</label>
              <textarea class="txtarea" id="dianYouDesc1_2" value="" style=" width:300px; height:40px;"></textarea>
            </li>
          </ul>
        </div>
        <p class="submit">
          <input type="button" class="btn back_color" id="updateDianyou1" style="float:none;" value="提交" />
        </p>
        <div class="examine">
          <table class="audit">
          </table>
        </div>
      </div>
      <div class="message" id="con_a_5" style="display:none;">
        <div class="write_msg">
          <ul class="input_msg">
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>当期楼栋：</label>
                <div class="chose_ban" style="margin:0; height:auto;">
                   <ul class="addCbids cbIds1_2">
                      @if(!empty($sale->build))
                      @foreach($sale->build as $sbval)
                      <li value="{{$sbval['id']}}" class="changebuild">{{$sbval['num']}}号楼</li>
                      @endforeach
                      @else
                      暂无相关楼栋信息,请先添加楼栋信息
                      @endif
                   </ul>
                </div>
                <span id="res_cbIds1_2" style="color:red;margin-left:140px;"></span>
              </li>
            <li style="height:auto; overflow:hidden;">
              <label>楼栋描述：</label>
              <textarea class="txtarea" id="buildDesc1_2" value="" style=" width:300px; height:40px;"></textarea>
            </li>
          </ul>
        </div>
        <p class="submit">
          <input type="button" class="btn back_color" id="updateBuild1" style="float:none;" value="提交" />
        </p>
        <div class="examine">
          <table class="audit">
          </table>
        </div>
      </div>
    </div>
    <div class="add" id="pq" style="width:900px;">
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
              <li>
                <label><span class="dotted colorfe">*</span>项目最高价：</label>
                <input type="text" name="shouGao1" value="" class="txt width2">
                <span class="tishi">元/平米</span>
                <span id="res_shouGao1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label><span class="dotted colorfe">*</span>项目最低价：</label>
                <input type="text" name="shouDi1" value="" class="txt width2">
                <span class="tishi">元/平米</span>
                <span id="res_shouDi1" style="color:red;margin-left:10px;"></span>
              </li>
              <li>
                <label><span class="dotted colorfe">*</span>项目均价：</label>
                <input type="text" name="shouPing1" value="" class="txt width2">
                <span class="tishi">元/平米</span>
                <span id="res_shouPing1" style="color:red;margin-left:10px;"></span>
              </li>
              <li style="height:auto; overflow:hidden;">
                <label><span class="dotted colorfe">*</span>价格描述：</label>
                <div class="float_l" style=" float:left; width:220px; height:62px;">
                 <textarea class="txtarea" id="shouDesc1" value="" style=" width:200px; height:50px;"></textarea>
                </div>
                <span id="res_shouDesc1" style="color:red;margin-left:140px;"></span>
              </li>
              <li style="width:100%;">
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
              <li class="no_height ">
                <label><span class="dotted colorfe">*</span>电商优惠信息：</label>
                <input type="text" name="fu1" class="txt width3" />
                <span class="tishi marginR">抵</span>
                <input type="text" name="di1" class="txt width3" />
                <span class="tishi margin_left">示例：10000抵20000</span>
                <span id="res_dianYou1" style="color:red;margin-left:10px;"></span>
              </li>
             </ul>
           </div>
          <p class="submit" style="width:900px; margin:0 0 20px;">
            <input type="button" class="btn back_color" id="saleAddSave1" style=" float:none; margin-left:400px !important;" value="保存" />
          </p>
    </div>
  </div>
</div>
<div class="change_tel" style="z-index: 99999;" id="sc">
  <span class="close closeDeleteloudong"></span>
  <h2>删除</h2>
  <div class="change3">
    <p class="p"><i></i>您确定要删除<span id="deletename">营销</span>信息吗？</p>
    <p class="p">
      <input type="button" class="btn back_color" style=" width:80px;" id="saveDelete" value="确定" />
      <input type="button" class="btn back_color" style=" width:80px;" value="取消" />
    </p>
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
  
  // $("#add .manage_title a").click(function(){
	 // $(this).addClass("click").siblings(".manage_title a").removeClass("click");  
  // });

  $(".input_msg .chose_ban li").click(function(){
   $(this).toggleClass("click");  
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
var url = '/dynamic/addsaleinfo';
var token = $('#token').val();
var comid = $('#comid').val();
var pagetype1 = $('#pagetype1').val();
var pagetype2 = $('#pagetype2').val();

/** 添加 营销信息 **/
$(function(){
  var paiQi, kaiPan, jiaoFang, yuShou, countNum, cbIds, 
  shouGao, shouDi, shouPing, shouDesc, 
  zheType, zhe, jian, dianYou;
  
  $('.paiQi1 li').click(function(){
    paiQi = communityName + $(this).text();
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
    kaiPan = testing('input[name="kaiPan1"]', /^\S.*$/, '开盘时间不能为空', '#res_kaiPan1');
    jiaoFang = testing('input[name="jiaoFang1"]', /^\S.*$/, '交房时间不能为空', '#res_jiaoFang1');
    yuShou = $('input[name="yuShou1"]').val();

    countNum = testing('input[name="countNum1"]', /^[1-9]\d*$/, '当期户数为正整数', '#res_countNum1');
    if(!cbIds){
      $('#res_saleCbids1').text('请选择相关楼栋');
    }else{
      $('#res_saleCbids1').text('');
    }
    
    getShou();
    if( paiQi && kaiPan && jiaoFang && countNum && cbIds && shouGao && shouDi && shouPing && shouDesc && zheType && zhe && jian && dianYou){
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

  //售房营销方式
  function getShou(){
    shouGao = testing('input[name="shouGao1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '最高售价为正整数或1-2位小数', '#res_shouGao1');
    shouDi = testing('input[name="shouDi1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '最低售价为正整数或1-2位小数', '#res_shouDi1');
    shouPing = testing('input[name="shouPing1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '平均售价为正整数或1-2位小数', '#res_shouPing1');
    shouDesc = testing('#shouDesc1', /^\S.*$/, '售价描述不能为空', '#res_shouDesc1');
    if(!zheType){
      $('#res_zhe1').text('请选择折扣信息');
    }else{
      if(zheType == 1){
        zhe = testing('input[name="zhiZhe1"]', /^\d\.\d{1,2}$/, '折扣信息格式不正确', '#res_zhe1');
        jian = true;
      }else if(zheType == 2){
        jian = testing('input[name="zhiJian1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '被减金额为正整数或1-2位小数', '#res_zhe1');
        zhe = true;
      }else if(zheType == 3){
        zhe = testing('input[name="houZhe1"]', /^\d\.\d{1,2}$/, '折扣信息格式不正确', '#res_zhe1');
        if(zhe){
          jian = testing('input[name="houJian1"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '被减金额为正整数或1-2位小数', '#res_zhe1');
        }
      }else{
        zheType = false;
      }
    }

    if( !/^\S.*$/.test($('input[name="fu1"]').val()) || !/^\S.*$/.test($('input[name="di1"]').val()) ){
      $('#res_dianYou1').text('电商优惠信息均不能为空');
      dianYou = false;
    }else{
      $('#res_dianYou1').text('');
      dianYou = $('input[name="fu1"]').val() + '_' + $('input[name="di1"]').val();
    }
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
      var url = '/dynamic/deletesale';
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
                      alert('删除成功');
                      window.location.reload();
                  }else{
                      alert('删除失败');
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
                      alert('删除成功');
                      window.location.reload();
                  }else{
                      alert('删除失败');
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
      if($('#add').css('display') == 'none'){
          $('#lean_overlay').hide();
      }
  });
});

//维护动态信息
$(function(){
  var pId, zheType = 1, bId, cbIds='', cbname='';
  $('.updateDynamic').click(function(){
      pId = $(this).attr('value');
      bId = $(this).next('input.bid').val().split(',');
      cbIds = new Array();
      cbname = new Array();
      $('ul.addCbids').children('li').each(function(){
        var id = $(this).attr('value');

        if( bId.indexOf(id) != -1){
          $(this).addClass('border_8d');
          cbname.push($(this).text());
          cbIds.push(id);
        }
      });

      
      cbIds = cbIds.join('|');
      cbname = cbname.join(',');
      
      $('#con_a_1').show();
      $('#con_a_2').hide();
      $('#con_a_3').hide();
      $('#con_a_4').hide();
      $('#con_a_5').hide();
      $('#a1').addClass('click');
      $('#a2').removeClass('click');
      $('#a3').removeClass('click');
      $('#a4').removeClass('click');
      $('#a5').removeClass('click');

      $('#a1').attr('value', pId + ',1');
      $('#a2').attr('value', pId + ',2');
      $('#a3').attr('value', pId + ',3');
      $('#a4').attr('value', pId + ',4');
      $('#a5').attr('value', pId + ',5');

      getDynamicInfo(pId, 1);

      $('#add').find('input[type="text"]').each(function(){
          $(this).val('');
      });
      $('#add').find('textarea').each(function(){
          $(this).val('');
      });
  });

  $('a.dynamicInfo').click(function(){
      var val = $(this).attr('value').split(',');
      getDynamicInfo(val[0], val[1]);
      $('.message').find('input[type="text"]').each(function(){
          $(this).val('');
      });
      $('.message').find('textarea').each(function(){
          $(this).val('');
      });
  });
  /*
  $('.cbIds1_2 li').click(function(){
    if(!$(this).hasClass('border_8d')){
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
    }
  });
  */
  $('#updatePrice1').click(function(){
    var shouGao, shouDi, shouPing, shouDesc;
    shouGao = testing('input[name="shouGao1_2"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '最高售价为正整数或1-2位小数', '#res_shouGao1_2');
    shouDi = testing('input[name="shouDi1_2"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '最低售价为正整数或1-2位小数', '#res_shouDi1_2');
    shouPing = testing('input[name="shouPing1_2"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '平均售价为正整数或1-2位小数', '#res_shouPing1_2');
    shouDesc = testing('#shouDesc1_2', /^\S.*$/, '售价描述不能为空', '#res_shouDesc1_2');
    if( shouGao && shouDi && shouPing && shouDesc){
        $.ajax({
          type:'post',
          url:'/dynamic/updatePrice',
          data:{
            _token:token,
            pId:pId,
            shouGao:shouGao,
            shouDi:shouDi,
            shouPing:shouPing,
            shouDesc:shouDesc,
            lId:lId
          },
          dataType:'json',
          success:function(data){
            if(typeof data == 'object'){
              alert('保存成功');
              disableObj('input[name="shouGao1_2"]');
              disableObj('input[name="shouDi1_2"]');
              disableObj('input[name="shouPing1_2"]');
              disableObj('#shouDesc1_2');
              $('#updatePrice1').attr('disabled', true);
              showDynamicInfo(data, data.type);
            }else{
                alert('操作失败');
            }
          }
        });
    }else{
        return false;
    }
  });

  $('#updateNum1').click(function(){
    var countNum = testing('input[name="countNum1_2"]', /^[1-9]\d*$/, '当期户数为正整数', '#res_countNum1_2');
    if(countNum){
      $.ajax({
        type:'post',
        url:'/dynamic/updateNum',
        data:{
          _token:token,
          pId:pId,
          comid:comid,
          countNum:countNum,
          lId:lId
        },
        dataType:'json',
        success:function(data){
            if(typeof data == 'object'){
              alert('保存成功');
              disableObj('input[name="countNum1_2"]');
              $('#updateNum1').attr('disabled', true);
              showDynamicInfo(data, data.type);
            }else{
                alert('操作失败');
            }
        }
      });
    }
  });

  $('.zheType1_2 li').click(function(){
    zheType = $(this).attr('value');
  });

  $('#updateZhe1').click(function(){
    var zhe, jian, zheDesc1_2 = $('#zheDesc1_2').val();

    if($('#zheType1_2').attr('value') !== ''){
        zheType = $('#zheType1_2').attr('value');
    }
    if(!zheType){
      $('#res_zhe1_2').text('请选择折扣信息');
    }else{
      if(zheType == 1){
        zhe = testing('input[name="zhiZhe1_2"]', /^\d\.\d{1,2}$/, '折扣信息格式不正确', '#res_zhe1_2');
        jian = true;
      }else if(zheType == 2){
        jian = testing('input[name="zhiJian1_2"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '被减金额为正整数或1-2位小数', '#res_zhe1_2');
        zhe = true;
      }else if(zheType == 3){
        zhe = testing('input[name="houZhe1_2"]', /^\d\.\d{1,2}$/, '折扣信息格式不正确', '#res_zhe1_2');
        if(zhe){
          jian = testing('input[name="houJian1_2"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '被减金额为正整数或1-2位小数', '#res_zhe1_2');
        }
      }else{
        zheType = false;
      }
    }

    if( zheType && zhe && jian){
      $.ajax({
        type:'post',
        url:'/dynamic/updateZhe',
        data:{
          _token:token,
          pId:pId,
          comid:comid,
          zheType:zheType,
          zhe:zhe,
          jian:jian,
          zheDesc:zheDesc1_2,
          lId:lId
        },
        dataType:'json',
        success:function(data){
            if(typeof data == 'object'){
                alert('保存成功');
                disableObj('input[name="zhiZhe1_2"]');
                disableObj('input[name="zhiJian1_2"]');
                disableObj('input[name="houZhe1_2"]');
                disableObj('input[name="houJian1_2"]');
                disableObj('#zheDesc1_2');
                $('#updateZhe1').attr('disabled', true);
                showDynamicInfo(data, data.type);
            }else{
                alert('操作失败');
            }
        }
      });
    }else{
      return false;
    }
  });

  $('.changebuild').click(function(){
      var id = $(this).attr('value'), val = $(this).text(), tmp = false;
      cbname = cbname.split(',');
      cbIds = cbIds.split('|');
      
      var k = function(){
          for(var i in cbIds){
              if(cbIds[i] == id ){
                  return i;
              }
          }
          return -1;
      }();

      var n = function(){
          for (var i in cbname) {
              if(cbname[i] == val){
                return i;
              }
          };
          return -1;
      }();
      
      if(k != -1){
          cbIds.splice(k, 1);
          cbname.splice(n, 1);
          $(this).removeClass('click');
      }else{
          cbIds.push(id);
          cbname.push(val);
          $(this).addClass('click');
      }
      
      cbIds = cbIds.join('|');
      cbname = cbname.join(',');
  });
  $('#updateBuild1').click(function(){
    var tmp = false;
    $('ul.addCbids').children('li').each(function(){
      if($(this).hasClass('click')){
        tmp = true;
      }
    });

    if(tmp){
      $('#res_cbIds1_2').text('');
      var buildDesc = $('#buildDesc1_2').val();
      $.ajax({
        type:'post',
        url:'/dynamic/updateBuild',
        data:{
          _token:token,
          cbIds:cbIds,
          comid:comid,
          buildDesc:buildDesc,
          cbname:cbname,
          pId:pId,
          lId:lId
        },
        dataType:'json',
        success:function(data){
            if(typeof data == 'object'){
                alert('保存成功');
                $('.changebuild').each(function(){
                    if($(this).hasClass('click')){
                        $(this).removeClass('click');
                        $(this).addClass('border_8d');
                    }
                });
                disableObj('#buildDesc1_2');
                $('#updateBuild1').attr('disabled', true);
                showDynamicInfo(data, data.type);
            }else{
                alert('操作失败');
            }
        }
      });
    }else{
      $('#res_cbIds1_2').text('没有新增加的楼栋');
      return false;
    }
  });

  $('#updateDianyou1').click(function(){
    var dianYou, dianYouDesc = $('#dianYouDesc1_2').val();

    if( !/^\S.*$/.test($('input[name="fu1_2"]').val()) || !/^\S.*$/.test($('input[name="di1_2"]').val()) ){
      $('#res_dianYou1_2').text('电商优惠信息均不能为空');
      dianYou = false;
    }else{
      $('#res_dianYou1_2').text('');
      dianYou = $('input[name="fu1"]').val() + '_' + $('input[name="di1"]').val();
    }
    if(dianYou){
      $.ajax({
        type:'post',
        url:'/dynamic/updateDianyou',
        data:{
          _token:token,
          pId:pId,
          comid:comid,
          dianYou:dianYou,
          dianYouDesc:dianYouDesc,
          lId:lId
        },
        dataType:'json',
        success:function(data){
            if(typeof data == 'object'){
                alert('保存成功');
                disableObj('input[name="fu1_2"]');
                disableObj('input[name="di1_2"]');
                disableObj('#dianYouDesc1_2');
                $('#updateDianyou1').attr('disabled', true);
                showDynamicInfo(data, data.type);
            }else{
                alert('操作失败');
            }
        }
      });
    }else{
      return false;
    }
  });

  //获取动态维护信息
  function getDynamicInfo(id, type){
      var url = '/dynamic/getdynamicinfo';
      var pId = id;
      var type = type;
      $.ajax({
          type:'post',
          url:url,
          data:{
              _token:token,
              pId:pId,
              type:type
          },
          dataType:'json',
          success:function(data){
              showDynamicInfo(data, type);
          }
      });
  }

  function showDynamicInfo(obj, type){
      var type = type;
      var obj =  obj;
      if(type == 1){
          var position = $('#con_a_1').children('.examine').children('table');
          var tr_list = '<tr><th width="100">维护时间</th><th width="100">最高价</th><th width="100">均价</th><th width="100">最低价</th><th width="300">价格描述</th><th width="150">状态</th></tr>';
          var isnul = false;
          for(var i in obj.data){
              isnul = true;
              var tmp = eval('('+ obj.data[i].detail + ')');
              tr_list += '<tr><td>'+ obj.data[i].timeCreate.substr(0, 10) +'</td>';
              tr_list += '<td>'+ tmp.saleMaxPrice +'元/平米</td><td>'+ tmp.saleAvgPrice +'元/平米</td>';
              tr_list += '<td>'+ tmp.saleMinPrice +'元/平米</td><td>'+ tmp.salePriceDescription +'</td>';
              tr_list += '<td value="'+ obj.data[i].id +'">未审核&nbsp;&nbsp;<a onclick="editDynamicInfo(this,'+ type +');">修改</a>&nbsp;&nbsp;<a onclick="deleteDynamic(this, '+ type +');">删除</a></td></tr>';
          }
          if(isnul == false){
              tr_list += '<tr><td colspan="6">暂无相关排期记录信息</td></tr>';
          }else{
              var pagelist = getPagebal(obj, type);
              tr_list += '<tr><td colspan="6">'+ pagelist +'</td></tr>';
          }
          position.html(tr_list);
          $(position).find('div.page_nav').children('ul').children('li').children('a').click(pageTurn);
      }
      if(type == 2){
          var position = $('#con_a_2').children('.examine').children('table');
          var tr_list = '<tr><th>维护时间</th><th>在售户数</th><th>操作</th></tr>';
          var isnul = false;
          for(var i in obj.data){
              isnul = true;
              var tmp = eval('('+ obj.data[i].detail + ')');
              tr_list += '<tr><td>'+ obj.data[i].timeCreate.substr(0, 10) +'</td>';
              tr_list += '<td>'+ tmp.houseNum +'户</td>';
              tr_list += '<td value="'+ obj.data[i].id +'">未审核&nbsp;&nbsp;<a onclick="editDynamicInfo(this,'+ type +');">修改</a>&nbsp;&nbsp;<a onclick="deleteDynamic(this, '+ type +');">删除</a></td></tr>';
          }
          if(isnul == false){
              tr_list += '<tr><td colspan="3">暂无相关排期记录信息</td></tr>';
          }else{
              var pagelist = getPagebal(obj, type);
              tr_list += '<tr><td colspan="3">'+ pagelist +'</td></tr>';
          }
          position.html(tr_list);
          $(position).find('div.page_nav').children('ul').children('li').children('a').click(pageTurn);
      }
      if(type == 3){
          var position = $('#con_a_3').children('.examine').children('table');
          var tr_list = '<tr><th>维护时间</th><th>折扣信息</th><th>折扣描述</th><th>操作</th></tr>';
          var isnul = false;
          for(var i in obj.data){
              isnul = true;
              var tmp = eval('('+ obj.data[i].detail + ')');
              tr_list += '<tr><td>'+ obj.data[i].timeCreate.substr(0, 10) +'</td>';
              if(tmp.discountType == 1){
                  tr_list += '<td>'+ tmp.discount +'折</td>';
              }else if(tmp.discountType == 2){
                  tr_list += '<td>直减'+ tmp.subtract +'元</td>';
              }else if(tmp.discountType == 3){
                  tr_list += '<td>'+ tmp.discount +'折后再减'+ tmp.subtract +'元</td>';
              }
              
              tr_list += '<td>'+ tmp.zheDesc +'</td>';
              tr_list += '<td value="'+ obj.data[i].id +'">未审核&nbsp;&nbsp;<a onclick="editDynamicInfo(this,'+ type +');">修改</a>&nbsp;&nbsp;<a onclick="deleteDynamic(this, '+ type +');">删除</a></td></tr>';
          }
          if(isnul == false){
              tr_list += '<tr><td colspan="4">暂无相关排期记录信息</td></tr>';
          }else{
              var pagelist = getPagebal(obj, type);
              tr_list += '<tr><td colspan="4">'+ pagelist +'</td></tr>';
          }
          position.html(tr_list);
          $(position).find('div.page_nav').children('ul').children('li').children('a').click(pageTurn);
      }
      if(type == 4){
          var position = $('#con_a_4').children('.examine').children('table');
          var tr_list = '<tr><th>维护时间</th><th>电商优惠</th><th>电商优惠描述</th><th>操作</th></tr>';
          var isnul = false;
          for(var i in obj.data){
              isnul = true;
              var tmp = eval('('+ obj.data[i].detail + ')');
              tr_list += '<tr><td>'+ obj.data[i].timeCreate.substr(0, 10) +'</td>';
              
              tr_list += '<td>'+ tmp.specialOffers.split('_')[0] +'万抵'+ tmp.specialOffers.split('_')[1] +'万</td>';
              tr_list += '<td>'+ tmp.dianYouDesc +'</td>';
              tr_list += '<td value="'+ obj.data[i].id +'">未审核&nbsp;&nbsp;<a onclick="editDynamicInfo(this,'+ type +');">修改</a>&nbsp;&nbsp;<a onclick="deleteDynamic(this, '+ type +');">删除</a></td></tr>';
          }
          if(isnul == false){
              tr_list += '<tr><td colspan="4">暂无相关排期记录信息</td></tr>';
          }else{
              var pagelist = getPagebal(obj, type);
              tr_list += '<tr><td colspan="4">'+ pagelist +'</td></tr>';
          }
          position.html(tr_list);
          $(position).find('div.page_nav').children('ul').children('li').children('a').click(pageTurn);
      }
      if(type == 5){
          var position = $('#con_a_5').children('.examine').children('table');
          var tr_list = '<tr><th>维护时间</th><th>楼栋信息</th><th>描述</th><th>状态</th></tr>';
          var isnul = false;
          for(var i in obj.data){
              isnul = true;
              var tmp = eval('('+ obj.data[i].detail + ')');
              tr_list += '<tr><td>'+ obj.data[i].timeCreate.substr(0, 10) +'</td>';
              tr_list += '<td value="'+ tmp.cbIds +'">'+ tmp.cbname +'</td>';
              tr_list += '<td>'+ tmp.buildDesc +'</td>';
              tr_list += '<td value="'+ obj.data[i].id +'">未审核&nbsp;&nbsp;<a onclick="editDynamicInfo(this,'+ type +');">修改</a>&nbsp;&nbsp;<a onclick="deleteDynamic(this, '+ type +');">删除</a></td></tr>';
          }
          if(isnul == false){
              tr_list += '<tr><td colspan="4">暂无相关排期记录信息</td></tr>';
          }else{
              var pagelist = getPagebal(obj, type);
              tr_list += '<tr><td colspan="4">'+ pagelist +'</td></tr>';
          }
          position.html(tr_list);
          $(position).find('div.page_nav').children('ul').children('li').children('a').click(pageTurn);
      }
  }

  // 页面分页
  function getPagebal(obj, type){
      var obj = obj, type = type, leftP, rightP;

      if(obj.last_page == 1){
          return '';
      }

      leftP = Math.max(obj.current_page - 2, 1);
      rightP = Math.min(leftP + 4, obj.last_page);
      leftP = Math.max(rightP - 4, 1);

      var pagelist = '<div class="page_nav"><ul>';
      pagelist += '<li><a style="cursor:pointer;" value="{type:'+ type +', cur:'+ 1 +', pId:'+ obj.data[0].periodId +'}">首页</a></li>';
      if(leftP > 1){
          pagelist += '<li><a style="cursor:pointer;" value="{type:'+ type +', cur:'+ obj.current_page - 1 +', pId:'+ obj.data[0].periodId +'}" >上一页</a></li>';
      }
      
      if( (leftP - 1) > 1 ){
          pagelist += '<li><a style="cursor:pointer;"  value="{type:'+ type +', cur:'+ 1 +', pId:'+ obj.data[0].periodId +'}">1</a></li>';
          pagelist += '<li>...</li>';
      }
      
      for(var i = leftP; i <= rightP; i++){

          if(i == obj.current_page){
              pagelist += '<li class="click">'+ i +'</li>';
          }else{
              pagelist += '<li><a style="cursor:pointer;"  value="{type:'+ type +', cur:'+ i +', pId:'+ obj.data[0].periodId +'}">'+ i +'</a></li>';
          }
          
      }

      if( (rightP + 1) < obj.last_page ){
          pagelist += '<li>...</li>';
          pagelist += '<li><a style="cursor:pointer;"  value="{type:'+ type +', cur:'+ obj.last_page +', pId:'+ obj.data[0].periodId +'}">'+ obj.last_page +'</a></li>';
      }
      if(rightP < obj.current_page){
          pagelist += '<li><a style="cursor:pointer;"  value="{type:'+ type +', cur:'+ (obj.current_page + 1) +', pId:'+ obj.data[0].periodId +'}" >下一页</a></li>';
      }
      
      pagelist += '<li><a style="cursor:pointer;"  value="{type:'+ type +', cur:'+ obj.last_page +', pId:'+ obj.data[0].periodId +'}" >尾页</a></li>';
      pagelist += '</ul></div>';

      return pagelist;
  }

  // 翻页
  function pageTurn(){
      var pageobj = eval( '(' + $(this).attr('value') + ')' );
      var url = '/dynamic/pageturn';
      $.ajax({
          type:'post',
          url:url,
          data:{
              _token:token,
              param:pageobj
          },
          dataType:'json',
          success:function(data){
              if(data == 0){
                  alert('操作失败');
                  return false;
              }
              showDynamicInfo(data, pageobj.type);
          }
      });
  }

  //清空选择器的内容 并将其残废
  function disableObj(obj){
      $(obj).val('');
      $(obj).attr('disabled', true);
  }
});


var lId;
function editDynamicInfo(obj, type){
    var type = type;
    var td_list = $(obj).parents('tr').children();
    lId = $(obj).parent('td').attr('value');
    if(type == 1){
        $('input[name="shouGao1_2"]').val(td_list.eq(1).text().replace(/元\/平米/g, ''));
        $('input[name="shouPing1_2"]').val(td_list.eq(2).text().replace(/元\/平米/g, ''));
        $('input[name="shouDi1_2"]').val(td_list.eq(3).text().replace(/元\/平米/g, ''));
        $('#shouDesc1_2').val(td_list.eq(4).text());

        $('input[name="shouGao1_2"]').removeAttr('disabled');
        $('input[name="shouPing1_2"]').removeAttr('disabled');
        $('input[name="shouDi1_2"]').removeAttr('disabled');
        $('#shouDesc1_2').removeAttr('disabled');
        $('#updatePrice1').removeAttr('disabled');
    }
    if(type == 2){
        $('input[name="countNum1_2"]').val(td_list.eq(1).text().replace(/户/g, ''));

        $('input[name="countNum1_2"]').removeAttr('disabled');
        $('#updateNum1').removeAttr('disabled');
    }
    if(type == 3){
        var zhe = td_list.eq(1).text();
        if(/折$/.test(zhe)){
            $('#zheType1_2').text('打折');
            $('input[name="zhiZhe1_2"]').val(zhe.replace(/[\u4e00-\u9fa5]+/g, ''));
            $('#zheType1_2').attr('value',1);
            $('#con_b_1').show();
            $('#con_b_2, #con_b_3').hide();
        }
        if(/^直减/.test(zhe)){
            $('#zheType1_2').text('直接减去');
            $('input[name="zhiJian1_2"]').val(zhe.replace(/[\u4e00-\u9fa5]+/g, ''));
            $('#zheType1_2').attr('value',2);
            $('#con_b_2').show();
            $('#con_b_1, #con_b_3').hide();
        }
        if(/折后再减/.test(zhe)){
            $('#zheType1_2').text('折后再减');
            zhe = zhe.split('折后再减');
            $('input[name="houZhe1_2"]').val(zhe[0]);
            $('input[name="houJian1_2"]').val(zhe[1].replace(/[\u4e00-\u9fa5]+/g, ''));
            $('#zheType1_2').attr('value',3);
            $('#con_b_3').show();
            $('#con_b_2, #con_b_1').hide();
        }
        $('#zheDesc1_2').val(td_list.eq(2).text());

        $('input[name="zhiZhe1_2"]').removeAttr('disabled');
        $('input[name="zhiJian1_2"]').removeAttr('disabled');
        $('input[name="houZhe1_2"]').removeAttr('disabled');
        $('input[name="houJian1_2"]').removeAttr('disabled');
        
        $('#zheDesc1_2').removeAttr('disabled');
        $('#updateZhe1').removeAttr('disabled');
    }
    if(type == 4){
        $('input[name="fu1_2"]').val(td_list.eq(1).text().split('万抵')[0]);
        $('input[name="di1_2"]').val(td_list.eq(1).text().split('万抵')[1].replace(/万/g,''));
        $('#dianYouDesc1_2').val(td_list.eq(2).text());

        $('input[name="fu1_2"]').removeAttr('disabled');
        $('input[name="di1_2"]').removeAttr('disabled');
        $('#dianYouDesc1_2').removeAttr('disabled');
        $('#updateDianyou1').removeAttr('disabled');
    }
    if(type == 5){
        var c = td_list.eq(1).attr('value').split('|');
        $('.changebuild').each(function(){
            if( c.indexOf($(this).attr('value')) != -1){
                $(this).addClass('click');
            } 
        });
        $('#buildDesc1_2').val(td_list.eq(2).text());
        
        $('#buildDesc1_2').removeAttr('disabled');
        $('#updateBuild1').removeAttr('disabled');
    }
}

function deleteDynamic(obj, type){
    var type = type;
    lId = $(obj).parent('td').attr('value');
    $('#deletename').text('排期维护记录');
    $('#sc').show();
}

</script>
</body>
</html>
