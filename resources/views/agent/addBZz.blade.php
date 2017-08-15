@include('agent.header')
@include('agent.left')
 <!--  -->
    <!--"  -->
    <form id="demoform" action="addBasicHouse?communityId={{$communityId}}&typeInfo={{$typeInfo}}" class="demoform" method="post">
    <input type="hidden" name="_token" value="{!!  csrf_token()!!}" />

    <form class="demoform" action="addBasicHouse?communityId={{$communityId}}&typeInfo={{$typeInfo}}" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}" />

    <div class="write_msg">
      <p class="manage_title">
        @foreach($type2Info as $k=>$ty)
        <a href="addBasicHouse?communityId={{$communityId}}&typeInfo={{$k}}" @if($typeInfo == $k) class="click" @endif >{{$ty}}</a>
        @endforeach
      </p>
      <!-- star<<住宅底商,商业街商铺,临街门面,写字楼配套底商,其它>>star -->
        @include('agent.addBZzParts._addBZz_one')
    <!-- end<<住宅底商,商业街商铺,临街门面,写字楼配套底商,其它>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<购物中心star>>star -->
        @include('agent.addBZzParts._addBZz_two')
    <!-- end<<购物中心star>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<纯写字楼,商业综合体楼,酒店写字楼>>star -->
        @include('agent.addBZzParts._addBZz_three')
    <!-- end<<纯写字楼,商业综合体楼,酒店写字楼>>end -->
<!-- ================================================0==================================================================================================================================================== -->
    <!-- star<<普通住宅,经济适用房>>star -->
        @include('agent.addBZzParts._addBZz_four')
    <!-- end<<普通住宅,经济适用房>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<别墅>>star -->
        @include('agent.addBZzParts._addBZz_five')
    <!-- end<<别墅>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<精品豪宅>>star -->
        @include('agent.addBZzParts._addBZz_six')
    <!-- end<<精品豪宅>>end -->
<!-- ==================================================================================================================================================================================================== -->
    <!-- star<<商住公寓楼>>star -->
        @include('agent.addBZzParts._addBZz_seven')
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
<script type="text/javascript" src="js/validate.js?v={{Config::get('app.version')}}"></script>

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
    alert($('input[name="propertyYear"]').val());
    
  });
  $('input[name="otherYear"]').keyup(function(){
    $('input[name="propertyYear"]').val($(this).val());
  });
  // 存入公共区域装修情况
  $('.dec').click(function(){
    var decorationPublic = $(this).val();
    $('input[name="decorationPublic"]').attr('value',decorationPublic);
  });
  // 存入使用区域装修情况
  $('.use').click(function(){
    var decorationUsedRange = $(this).val();
    $('input[name="decorationUsedRange"]').attr('value',decorationUsedRange);
  });
  // 存入装修情况
  $('.decor').click(function(){
    var decoration = $(this).val();
    $('input[name="decoration"]').attr('value',decoration);
  });
  // 存入建筑结构
  $('.build').click(function(){
    var structure = $(this).val();
    $('input[name="structure"]').attr('value',structure);
    alert(structure);
  });
  // 存入供电
  $('.pow').click(function(){
    var powerSupply = $(this).val();
    $('input[name="powerSupply"]').attr('value',powerSupply);
  });
  // 存入供水
  $('.wat').click(function(){
    var waterSupply = $(this).val();
    $('input[name="waterSupply"]').attr('value',waterSupply);
  });
  // 存入供气
  $('.gas').click(function(){
    var gasSupply = $(this).val();
    $('input[name="gasSupply"]').attr('value',gasSupply);
    alert(gasSupply);
  });
  // 存入供暖
  $('.heating').click(function(){
    var heatingSupply = $(this).val();
    $('input[name="heatingSupply"]').attr('value',heatingSupply);
    alert(heatingSupply);
  });
  // 存入房屋类别
  $('.design').click(function(){
    var homeDesignType = $(this).val();
    $('input[name="homeDesignType"]').attr('value',homeDesignType);
    alert(homeDesignType);
  });
</script>

</body>
</html>
