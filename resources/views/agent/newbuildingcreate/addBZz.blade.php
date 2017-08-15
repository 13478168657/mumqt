@include('agent.newbuildingcreate.header')
@include('agent.newbuildingcreate.left')
 <!--  -->
    <!--"  -->

    <form id="demoform" action="addBasicHouse?communityId={{$communityId}}&typeInfo={{$typeInfo}}" class="demoform" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />

    <div class="write_msg">
      <p class="manage_title">
        @if(!empty($type2Info))
          @foreach($type2Info as $dkey => $dval)
            @if(!empty($dval))
              @foreach($dval as $ddk => $ddv)
              <a href="{{$hosturl}}?communityId={{$communityId}}&typeInfo={{$ddk}}" @if($pagetype[2] == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
      <!-- star<<住宅底商,商业街商铺,临街门面,写字楼配套底商,其它>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_one')
    <!-- end<<住宅底商,商业街商铺,临街门面,写字楼配套底商,其它>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<购物中心star>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_two')
    <!-- end<<购物中心star>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<纯写字楼,商业综合体楼,酒店写字楼>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_three')
    <!-- end<<纯写字楼,商业综合体楼,酒店写字楼>>end -->
<!-- ================================================0==================================================================================================================================================== -->
    <!-- star<<普通住宅,经济适用房>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_four')
    <!-- end<<普通住宅,经济适用房>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<别墅>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_five')
    <!-- end<<别墅>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<精品豪宅>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_six')
    <!-- end<<精品豪宅>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<商住公寓楼>>star -->
        @include('agent.newbuildingcreate.addBZzParts._addBZz_seven')
    <!-- star<<商住公寓楼>>star -->
    <p class="submit">
      <input type="submit" class="btn back_color" value="保存" />
    </p>
    </form>
  </div>
</div>
<div class="change_tel map_show" id="map">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <img src="image/about_our4.png" />
</div>
<script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<!-- <script type="text/javascript" src="js/jquery-1.9.1.min.js?v={{Config::get('app.version')}}"></script> -->

<!-- 表单验证 -->
<script type="text/javascript" src="js/jquery.validate.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/additional-methods.js?v={{Config::get('app.version')}}"></script>
<!-- <script type="text/javascript" src="js/validate.js?v={{Config::get('app.version')}}"></script> -->
<script type="text/javascript" src="js/Validform_v5.3.2.js?v={{Config::get('app.version')}}"></script>

<script>
$(function(){
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
  
      $("#market ul li").click(function(){
       var text=$(this).text();
           if(text=="整体出售" || text=="分割出售"){
                  $("#sale").show();
                  $("#sale_zt").show();
                  $("#rent").hide();
                  $("#rent_zt").hide();
           }else if(text=="持有运营" ){
                  $("#rent").show();
                  $("#rent_zt").show();
                  $("#sale").hide();
                  $("#sale_zt").hide();
          }else if(text=="租售皆可" ){
                  $("#rent").show();
                  $("#rent_zt").show();
                  $("#sale").show();
                  $("#sale_zt").show();
             }
       });
      })
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

/*function t(){
  var obj = [];
    $('input').each(function(index){
        if($(this)).val() == ''){
            $(this).next('span').text('');
            return false;
        }
       obj[index] = {
        $(this).attr('name'):$(this).val()
          }
    });
}*/
</script>
<script>
  /*$(".demoform").Validform({
    tiptype:3,
    label:".label",
    showAllError:true,
  });*/
  // 存入产权年限
  $('.year').click(function(){
    var propertyYear = $(this).attr('value');
    // $('input[name="propertyYear"]').val($(this).attr('value'));
    if(propertyYear == 'other'){
      $('input[name="propertyYear"]').val($('input[name="otherYear"]').val());
    }else{
      $('input[name="propertyYear"]').val(propertyYear);
    }
    $('input[name="propertyYear"]').next().next().next().removeClass('Validform_wrong').addClass('Validform_right').html('');
    //$('.Validform_checktip Validform_wrong').remove();
    
  });
  $('input[name="otherYear"]').keyup(function(){
    $('input[name="propertyYear"]').val($(this).val());
  });
  // 存入公共区域装修情况
  $('.dec').click(function(){
    var decorationPublic = $(this).val();
    $('input[name="decorationPublic"]').attr('value',decorationPublic);
    $('input[name="decorationPublic"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
  });
  // 存入使用区域装修情况
  $('.use').click(function(){
    var decorationUsedRange = $(this).val();
    $('input[name="decorationUsedRange"]').attr('value',decorationUsedRange);
    $('input[name="decorationUsedRange"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
  });
  // 存入装修情况
  $('.decor').click(function(){
    var decoration = $(this).val();
    $('input[name="decoration"]').attr('value',decoration);
    $('input[name="decoration"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
  });
  // 存入建筑结构
  $('.build').click(function(){
    var structure = $(this).val();
    $('input[name="structure"]').attr('value',structure);
    $('input[name="structure"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
    // alert(structure);
  });
  // 存入供电
  $('.pow').click(function(){
    var powerSupply = $(this).val();
    $('input[name="powerSupply"]').attr('value',powerSupply);
    $('input[name="powerSupply"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
  });
  // 存入供水
  $('.wat').click(function(){
    var waterSupply = $(this).val();
    $('input[name="waterSupply"]').attr('value',waterSupply);
    $('input[name="waterSupply"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
  });
  // 存入供气
  $('.gas').click(function(){
    var gasSupply = $(this).val();
    $('input[name="gasSupply"]').attr('value',gasSupply);
    $('input[name="gasSupply"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
    // alert(gasSupply);
  });
  // 存入供暖
  $('.heating').click(function(){
    var heatingSupply = $(this).val();
    $('input[name="heatingSupply"]').attr('value',heatingSupply);
    $('input[name="heatingSupply"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
    // alert(heatingSupply);
  });
  // 存入房屋类别
  $('.design').click(function(){
    var homeDesignType = $(this).val();
    $('input[name="homeDesignType"]').attr('value',homeDesignType);
    $('input[name="homeDesignType"]').next().removeClass('Validform_wrong').addClass('Validform_right').html('');
    // alert(homeDesignType);
  });

  $(wordCheck("#floorRemark",300,"#bcsm")); // 补充说明字数限制
  $(wordCheck("#propertyRemark",300,"#bz")); // 备注字数限制
  $(wordCheck("#intro",300,"#xmjs")); // 项目介绍字数限制
  $(wordCheck("#airCondition",300,"#ktms")); // 空调描述字数限制
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
<script>
  // 表单验证
  var formInfo = $(".demoform").Validform({
    tiptype:3,
    label:".label",
    showAllError:true,
  });
  formInfo.tipmsg.r=" ";

  // 车位信息错误提示修正
  $('input[name="parkingInfo[]"]').blur(function(){
      var val = document.getElementsByName("parkingInfo[]");
      // console.log(val);return false;
      for( var i = 0; i < val.length; i++){
          if(!/^\d{1,5}$/.test($.trim(val[i].value))){
            val = false;
            break;
         }
      }
      if(val == false){
          $(this).parent().children('.Validform_right').removeClass('Validform_right').addClass('Validform_wrong').html('请填写车位信息');
      }else{
          $(this).parent().children('.Validform_wrong').removeClass('Validform_wrong').addClass('Validform_right');
      }
  });

  // 开间面积错误提示修正
  $('input[name="bayAreaMin"]').blur(function(){
    var kaijian2 = $('input[name="bayAreaMax"]').val();
    if(kaijian2 == ''){
       $(this).parent().children('.Validform_right').removeClass('Validform_right').addClass('Validform_wrong').html('请填写开间面积');
    }
  });
  $('input[name="bayAreaMax"]').blur(function(){
    var kaijian1 = $('input[name="bayAreaMin"]').val();
    if(kaijian1 == ''){
       $(this).parent().children('.Validform_right').removeClass('Validform_right').addClass('Validform_wrong').html('请填写开间面积');
    }
  });
</script>
</body>
</html>
