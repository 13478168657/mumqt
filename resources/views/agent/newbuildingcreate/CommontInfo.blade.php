@include('agent.agent_layout.navbar')
@include('agent.agent_layout.sidebar')
  <div class="main_r" id="main_r">
    <div class="commtent">
      <p>
        <span class="color_blue">五矿万科城</span>
        <span class="color8d">wkwkc</span>
        <span id="type2" class="subway">{{$type2_data}}</span>
        <input type="hidden" name="communityId" value="{{$communityId}}" />
        <input type="hidden" name="type2" value="{{$type2}}" />
      </p>
      <p>
       <span>[&nbsp;北京-朝阳-百子湾&nbsp;]&nbsp;&nbsp;</span>
       <span>东四环与广渠路交口大郊亭桥广渠路21号&nbsp;<a class="modaltrigger" href="#map"><i class="map_icon"></i></a></span>
      </p>
    </div>
    <p class="right_title border_bottom">
      <a href="#" class="click">共有信息</a>
    </p>
  <form action="addBasicHouse?communityId={{$communityId}}&typeInfo={{substr($type2, 0, 3)}}" method="post" class="demoform">
    <div class="write_msg">
      <ul class="input_msg enter_build">
        <li>
          <label><span class="dotted colorfe">*</span>开发商：</label>
          <input type="text" name="developer" class="txt width1" datatype="*" nullmsg="填写开发商" @if(!empty($companyArr['developer'])) value="{{$companyArr['developer']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>项目公司：</label>
          <input type="text" name="project" class="txt width1" datatype="*" nullmsg="填写项目公司" @if(!empty($companyArr['projectCompany'])) value="{{$companyArr['projectCompany']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>投资商：</label>
          <input type="text" name="invest" class="txt width1" datatype="*" nullmsg="填写投资商" @if(!empty($companyArr['investCompany'])) value="{{$companyArr['investCompany']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>监理公司：</label>
          <input type="text" name="supervision" class="txt width1" datatype="*" nullmsg="填写监理公司" @if(!empty($companyArr['supervisionCompany'])) value="{{$companyArr['supervisionCompany']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>景观设计公司：</label>
          <input type="text" name="landscape" class="txt width1" datatype="*" nullmsg="填写景观公司" @if(!empty($companyArr['landscapeCompany'])) value="{{$companyArr['landscapeCompany']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>建筑规划公司：</label>
          <input type="text" name="architectural" class="txt width1" datatype="*" nullmsg="填写建筑公司" @if(!empty($companyArr['architecturalPlanningCompany'])) value="{{$companyArr['architecturalPlanningCompany']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>施工公司：</label>
          <input type="text" name="construction" class="txt width1" datatype="*" nullmsg="填写施工公司" @if(!empty($companyArr['constructionCompany'])) value="{{$companyArr['constructionCompany']}}" @else value="" @endif />
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>总占地面积：</label>
          <input type="text" name="area" class="txt width4" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="填写占地面积" errormsg="占地面积为正数或1-2位小数" @if(!empty($companyArr['allFloorArea'])) value="{{$companyArr['allFloorArea']}}" @else value="" @endif />
          <span class="tishi">平米</span>
        </li>
        <li class="no_height">
          <label>楼盘总体介绍：</label>
          <div class="float_l" style=" width:620px; height:100px;">
           <textarea class="txtarea" id="textlength" name="intro" style=" width:600px; height:80px;">@if(!empty($companyArr['note'])){{$companyArr['note']}}@endif</textarea>
           <span class="hs">还剩<span class="colorfe" id="hint">@if(!empty($companyArr['note'])) {{300 - mb_strlen($companyArr['note'], 'utf-8')}} @else 300 @endif</span>字可输入</span>
          </div>
          <span id="intro"></span>
        </li>
        <li class="no_height">
          <label>楼盘周边配套：</label>
          <div class="periphery">
            <div class="map">
              <div id="container" style="width:570px;height: 400px;"></div>
            </div>
            <div class="map_msg">
              <div class="periphery_nav" style="display:block;">
                <dl onClick="$('#periphery_build1').show();$('.periphery_nav').hide();">
                  <dt><img src="/image/icon9.png"></dt>
                  <dd>周边楼盘</dd>
                </dl>
                <dl onClick="$('#periphery_build2').show();$('.periphery_nav').hide();">
                  <dt><img src="/image/icon4.png"></dt>
                  <dd>交通</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon8.png"></dt>
                  <dd>娱乐</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon2.png"></dt>
                  <dd>超市</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon11.png"></dt>
                  <dd>餐饮</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon7.png"></dt>
                  <dd>银行</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon6.png"></dt>
                  <dd>医院</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon3.png"></dt>
                  <dd>公园</dd>
                </dl>
                <dl>
                  <dt><img src="/image/icon5.png"></dt>
                  <dd>学校</dd>
                </dl>
              </div>
              <?php //========================================================================================?>
              <div class="periphery_build" id="periphery_build1" style="display:none;">
                <p>万达广场周边楼盘<a class="fh marginL">保存</a><a class="fh">返回</a></p>
                <div class="periphery_msg">
                  <span class="title">住宅</span>
                  <ul>
                    <li><span class="width1">华业东方</span><span class="width2"><span class="colorfe">26000</span>元/平米</span><span class="width3">1473米</span><i></i></li>
                    <li><span class="width1">华业东方</span><span class="width2"><span class="colorfe">26000</span>元/平米</span><span class="width3">1473米</span><i></i></li>
                  </ul>
                  <span class="title">商铺</span>
                  <ul>
                    <li><span class="width1">华业东方</span><span class="width2"><span class="colorfe">26000</span>元/平米</span><span class="width3">1473米</span><i></i></li>
                    <li><span class="width1">华业东方</span><span class="width2"><span class="colorfe">26000</span>元/平米</span><span class="width3">1473米</span><i></i></li>
                  </ul>
                </div>
              </div>
              <div class="periphery_build" id="periphery_build2" style="display:none;">
                <p>万达广场交通<a class="fh marginL">保存</a><a class="fh">返回</a></p>
                <div class="periphery_msg">
                  <span class="title">地铁</span>
                  <ul>
                    <li><span class="width1">十号线</span><span class="width2">国贸站</span><span class="width3">1473米</span><i></i></li>
                    <li><span class="width1">十号线</span><span class="width2">国贸站</span><span class="width3">1473米</span><i></i></li>
                    <li><a>更多</a></li>
                  </ul>
                  <span class="title">交通</span>
                  <ul>
                    <li><span class="width1">405</span><span class="width2">国贸站</span><span class="width3">1473米</span><i></i></li>
                    <li><span class="width1">十号线</span><span class="width2">国贸站</span><span class="width3">1473米</span><i></i></li>
                    <li><span class="width1">十号线</span><span class="width2">国贸站</span><span class="width3">1473米</span><i></i></li>
                    <li><span class="width4">华业东方</span><span class="width5">1473米</span><i></i></li>
                    <li><a>更多</a></li>
                  </ul>
                </div>
              </div>

              <?php //========================================================================================?>
            </div>
          </div>
        </li>
      </ul>
    </div>
  <input type="hidden" name="_token" value="{{csrf_token()}}" />
    <p class="submit">
      <!-- <a id="save_btn" class="btn back_color">下一步</a> -->
      <input type="submit" class="btn back_color" value="下一步" />
    </p>
  </div>
</form>
</div>
<div class="change_tel map_show" id="map">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <img src="/image/about_our4.png" />
</div>
<script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<!-- 表单验证 -->
<script type="text/javascript" src="js/Validform_v5.3.2.js?v={{Config::get('app.version')}}"></script>


<?php //======================地图的JS======huzhaer====================== ?>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>
<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js?v={{Config::get('app.version')}}"></script>

<script>
  var map = new AMap.Map('container', {
    resizeEnable: true,
    zoom:15,
    center: [{{$jingduMap}}, {{$weiduMap}}]
  });

  var marker = new AMap.Marker({
    icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
    position: [{{$jingduMap}}, {{$weiduMap}}]
  });
  marker.setMap(map);
</script>


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
});
</script>
<script>
$(document).ready(function(e) {	
  $(".sub_nav a").click(function(){
	 $(".sub_nav a").removeClass("click");
	 $(this).addClass("click");  
  });
  $(".fh").click(function(){
	  $(".periphery_build").hide(); 
	  $(".periphery_nav").show();
  });
});
</script>

<script>
$(function(){
  // 表单验证
  var formInfo = $(".demoform").Validform({
    tiptype:3,
    label:".label",
    showAllError:true,
    beforeSubmit:function(curform){
                commInfo();
                return false;
                //在验证成功后，表单提交前执行的函数，curform参数是当前表单对象。
                //这里明确return false的话表单将不会提交;
            },
  });
  formInfo.tipmsg.r=" ";
  function commInfo(){
    var communityId = $('input[name="communityId"]').val();
    var type2 = $('input[name="type2"]').val();
    var _token = $('input[name="_token"]').val();
    var developer = $('input[name="developer"]').val();
    var project = $('input[name="project"]').val();
    var invest = $('input[name="invest"]').val();
    var supervision = $('input[name="supervision"]').val();
    var landscape = $('input[name="landscape"]').val();
    var architectural = $('input[name="architectural"]').val();
    var construction = $('input[name="construction"]').val();
    var area = $('input[name="area"]').val();
    var intro = $('textarea[name="intro"]').val(); // 楼盘总体介绍
    
      $.ajax({
        type : 'post',
        url  : 'Comminfo',
        data : {
          _token : _token,
          communityId   : communityId,
          developer     : developer,
          project       : project,
          invest        : invest,
          supervision   : supervision,
          landscape     : landscape,
          architectural : architectural,
          construction  : construction,
          area          : area,
          intro         : intro
        },
        success : function(result){
          window.location.href = '/addBasicHouse?communityId='+communityId+'&typeInfo='+type2.substring(3,0);
        }
      });
    
    
  };

});

  /*$('#save_btn').click(function(){
    var communityId = $('input[name="communityId"]').val();
    var type2 = $('input[name="type2"]').val();
    var _token = $('input[name="_token"]').val();
    var developer = testing('input[name="developer"]', /^\S.*$/, '请填写开发商', '#developer');
    var project = testing('input[name="project"]', /^\S.*$/, '请填写项目公司', '#project');
    var invest = testing('input[name="invest"]', /^\S.*$/, '请填写投资商', '#invest');
    var supervision = testing('input[name="supervision"]', /^\S.*$/, '请填写监理公司', '#supervision');
    var landscape = testing('input[name="landscape"]', /^\S.*$/, '请填写设计公司', '#landscape');
    var architectural = testing('input[name="architectural"]', /^\S.*$/, '请填写规划公司', '#architectural');
    var construction = testing('input[name="construction"]', /^\S.*$/, '请填写施工公司', '#construction');
    var area = testing('input[name="area"]', /^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/, '占地面积为正数', '#area');
    var intro = $('textarea[name="intro"]').val(); // 楼盘总体介绍
    if(developer && project && invest && supervision && landscape && architectural && construction && area){
      $.ajax({
        type : 'post',
        url  : 'Comminfo',
        data : {
          _token : _token,
          communityId   : communityId,
          developer     : developer,
          project       : project,
          invest        : invest,
          supervision   : supervision,
          landscape     : landscape,
          architectural : architectural,
          construction  : construction,
          area          : area,
          intro         : intro
        },
        success : function(result){
          window.location.href = '/addBasicHouse?communityId='+communityId+'&typeInfo='+type2.substring(3,0);
        }
      });
    }
    
  });*/

  $(wordCheck("#textlength",300,"#hint"));

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

  /**
  * 限制文本输入数量
  * @param obj textLength 对象
  * @param int maxNum 可输入最大数字数量
  * @param obj msgNotice 动态提示的对象
  */
  function wordCheck(textLength,maxNum,msgNotice){
    $(textLength).keyup(function(){
      var len = $(this).val().length;
      if(len > (maxNum-1)){
        $(this).val($(this).val().substring(0,maxNum));
      }
      var num = maxNum - len;
      if(num <= 0){
        num = 0;
      }
      $(msgNotice).text(num);
    });
  }
</script>
</body>
</html>
