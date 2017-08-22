@include('agent.agent_layout.navbar')
@include('agent.agent_layout.sidebar')
  <div class="main_r" id="main_r">
    <p class="right_title border_bottom">
      <a class="click">创建新楼盘</a>
    </p>
    <div class="write_msg">
      <ul class="input_msg">
        <li style="height:auto; overflow:hidden;">
          <label>注意：</label>
          <div class="float_l colorfe">
              1、上传宽度大于600像素，比例为4:3的图片可获得更好的展示效果。<br />
              2、请勿上传有水印、盖章等任何侵犯他人版权或含有广告信息的图片。<br />
              3、可上传30张图片，每张小于20M，建议尺寸比为：16:10，最佳尺寸为480*300像素。
          </div>
        </li>
        <li class="no_height">
          <div id="type">
            <label>物业类型：</label>
            <a class="subway house" name="type1" value="3">住宅</a>
            <a class="subway office" name="type1" value="2">写字楼</a>
            <a class="subway store" name="type1" value="1">商铺</a>
            <span id="check_type" style="color:red;margin-left:10px;"></span>
          </div>
          <div id="pz" style="display:none;">
            <label>住宅：</label>
            <input type="checkbox" class="radio" name="house" value="301" />
            <span class="tishi">普通住宅</span>
            <input type="checkbox" class="radio" name="house" value="302" />
            <span class="tishi">经济适用房</span>
            <input type="checkbox" class="radio" name="house" value="303" />
            <span class="tishi">商住公寓楼</span>
            <input type="checkbox" class="radio" name="house" value="304" />
            <span class="tishi">别墅</span>
            <input type="checkbox" class="radio" name="house" value="305" />
            <span class="tishi">精品豪宅</span>
            <input type="checkbox" class="radio" name="house" value="306" />
            <span class="tishi">平房</span>
            <input type="checkbox" class="radio" name="house" value="307" />
            <span class="tishi">四合院</span>
          </div>
          <div id="xzl" style="display:none;">
            <br />
            <label>写字楼：</label>
            <input type="checkbox" class="radio" name="office" value="201" />
            <span class="tishi">纯写字楼</span>
            <input type="checkbox" class="radio" name="office" value="303" />
            <span class="tishi">商住公寓楼</span>
            <input type="checkbox" class="radio" name="office" value="203" />
            <span class="tishi">商业综合体楼</span>
            <input type="checkbox" class="radio" name="office" value="204" />
            <span class="tishi">酒店写字楼</span>
          </div>
          <div id="sp" style="display:none;">
            <br />
            <label>商铺：</label>
            <input type="checkbox" class="radio" name="store" value="101" />
            <span class="tishi">住宅底商</span>
            <input type="checkbox" class="radio" name="store" value="102" />
            <span class="tishi">商业街商铺</span>
            <input type="checkbox" class="radio" name="store" value="103" />
            <span class="tishi">临街门面</span>
            <input type="checkbox" class="radio" name="store" value="104" />
            <span class="tishi">写字楼配套底商</span>
            <input type="checkbox" class="radio" name="store" value="105" />
            <span class="tishi">购物中心/百货</span>
            <input type="checkbox" class="radio" name="store" value="106" />
            <span class="tishi">其他</span>
          </div>
        </li>
        <li>
          <label>所属区域：</label>
          <div class="sort_icon">
            <a class="term_title"><span>所属省</span><i></i></a>
            <div class="list_tag city" style="width:200px;">
               <p class="top_icon pro_none"></p>
               <ul>
                @foreach($province as $pro)
                 <li class="pro" value="{{$pro->id}}">{{$pro->name}}</li>
                @endforeach
               </ul>
             </div>
          </div>
          <div class="sort_icon" style="margin-left:20px;">
            <a class="term_title"><span id="city_name">所属市</span><i></i></a>
            <div class="list_tag city" style="width:200px;">
               <p class="top_icon cit_none"></p>
               <ul id="city_list">
                 <li class="city_info"></li>
               </ul>
             </div>
          </div>
          <div class="sort_icon" style="margin-left:20px;">
            <a class="term_title"><span id="cityarea_name">所属区/县</span><i></i></a>
            <div class="list_tag city" style="width:200px;">
               <p class="top_icon are_none"></p>
               <ul id="city_area_list">
                 <li></li>
               </ul>
             </div>
          </div>
          <div class="sort_icon" style="margin-left:20px;">
            <a class="term_title"><span id="businessarea_name">所属商圈</span><i></i></a>
            <div class="list_tag city" style="width:200px;">
               <p class="top_icon bis_none"></p>
               <ul id="businessarea_list">
                 <li></li>
               </ul>
             </div>
          </div>
          <span id="check_area" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label>新盘名称：</label>
          <input type="text" class="txt width" id="build_name" name="build_name" />
          <span id="check_name" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>环线位置：</label>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span id="loopline_name" value="">请选择</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul id="loopline_info">
                 <li></li>
               </ul>
             </div>
          </div>
          <span id="check_loop" style="color:red;margin-left:10px;"></span>
        </li>
        <li>
          <label>楼盘地址：</label>
          <input type="text" class="txt width" id="address" name="address" />
          <span id="check_address" style="color:red;margin-left:10px;"></span>
          <span class="tishi"><a class="modaltrigger" href="#map"><i></i></a></span>
        </li>
      </ul>
    </div>
    <p class="submit">
      <a id="save" class="btn back_color">开始创建</a>
    </p>
  </div>
</div>
<div class="change_tel map" id="map">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>标注楼盘位置</h2>
  <span style="margin-left: 100px;">经度:</span><span id="longitude"></span>
  <span style="margin-left: 100px;">纬度:</span><span id="latitude"></span>
  <div class="address" id="container"></div>
  <div class="change1">
    <p><input type="button" class="btn back_color" name="submit" value="提交"></p>
  </div>
</div>


<input type="hidden" name="_token" value="{{csrf_token()}}" />
<input type="hidden" name="pro_id" value="" />
<input type="hidden" name="cit_id" value="" />
<input type="hidden" name="cta_id" value="" />
<input type="hidden" name="bsa_id" value="" />
<input type="hidden" name="lop_id" value="" />


<!-- 引入Js  -->
<script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=f9bfa990faaeca0b00061582d8a2941f"></script>
<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js?v={{Config::get('app.version')}}"></script>


<!-- 选择住宅类型的JS 验证 -->
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
    $("#type a").click(function(){
    $(this).toggleClass("click");
    if($(this).text()=="住宅"){
        $("#pz").toggle();  
      }else if($(this).text()=="别墅"){
        $("#bs").toggle();  
      }else if($(this).text()=="写字楼"){
        $("#xzl").toggle(); 
      }else if($(this).text()=="商铺"){
        $("#sp").toggle();  
      }   
    });
  });
</script>

<?php  //城市复选框 ?>
<script>
  $('.house').click(function(){
    $('input[name="house"]').attr('checked',false);
  });
  $('.office').click(function(){
    $('input[name="office"]').attr('checked',false);
  });
  $('.store').click(function(){
    $('input[name="store"]').attr('checked',false);
  });

  $('.pro').click(function(){
    $('.pro_none').attr('display','none');
  });


  $('.pro').click(function(){
    var province = $(this).attr('value');
    var _token = $('input[name="_token"]').val();
    $('#city_name').html('所属市');
    $('#cityarea_name').html('所属区/县');
    $('#businessarea_name').html('所属商圈');
    $('#city_area_list').find('li').remove();
    $('#businessarea_list').find('li').remove();
    $('input[name="pro_id"]').attr('value',province);
    $('#check_area').html('');
    $.ajax({
      type : 'post',
      url  : '/addComm',
      data : {
        _token : _token, 
        province : province
      },
      success : function(result) {
        var city_list = '';
        for( i in result ){
          city_list += '<li class="city_info" value="'+result[i].id+'">'+result[i].name+'</li>';
        }
        $('#city_list').html(city_list);
        $('.city_info').click(city_id);
      }
    });
  });

  function city_id(){
    var cityid = $(this).attr('value');
    var city_name = $(this).text();
    $('#city_name').html(city_name); 
    $(this).parents('.list_tag').hide();
    var _token = $('input[name="_token"]').val();
    $('#cityarea_name').html('所属区/县');
    $('#businessarea_name').html('所属商圈');
    $('#businessarea_list').find('li').remove();
    $('input[name="cit_id"]').attr('value',cityid);
    $('#check_area').html('');
    $.ajax({
      type : 'post',
      url  : '/addComm',
      data : {
        _token : _token,
        cityid : cityid
      },
      success : function(result){
        var city_area_list = '';
        for( i in result.cityAreaData ){
          city_area_list += '<li class="city_area_info" value="'+result.cityAreaData[i].id+'">'+result.cityAreaData[i].name+'</li>';
        }
        $('#city_area_list').html(city_area_list);
        $('.city_area_info').click(cityareaid);

        var loopline_info = '';
        for( i in result.loopline ){
          loopline_info += '<li class="loopline" value="'+result.loopline[i].id+'">'+result.loopline[i].name+'</li>';
        }
        $('#loopline_info').html(loopline_info);
        $('.loopline').click(loopline);
        
        
      }
    });
  }

  function loopline(){
    var boopline = $(this).attr('value');
    var boopline_name = $(this).text();
    $('input[name="lop_id"]').attr('value',boopline);
    $('#loopline_name').html(boopline_name);
    $(this).parents('.list_tag').hide();
  }

  function cityareaid(){
    var cityareaid = $(this).attr('value');
    var cityarea_name = $(this).text();
    $('#cityarea_name').html(cityarea_name);
    $(this).parents('.list_tag').hide();
    var _token = $('input[name="_token"]').val();
    $('#businessarea_name').html('所属商圈');
    $('input[name="cta_id"]').attr('value',cityareaid);
    $('#check_area').html('');
    $.ajax({
      type : 'post',
      url  : '/addComm',
      data : {
        _token : _token,
        cityareaid : cityareaid
      },
      success : function(result){
        var businessarea_list = '';
        for( i in result ){
          businessarea_list += '<li class="businessarea_info" value="'+result[i].id+'">'+result[i].name+'</li>';
        }
        $('#businessarea_list').html(businessarea_list);
        $('.businessarea_info').click(businessid);
      }
    });
  }

  function businessid(){
    var businessid = $(this).attr('value');
    var businessarea_name = $(this).text();
    $('#businessarea_name').html(businessarea_name);
    $(this).parents('.list_tag').hide();
    $('input[name="bsa_id"]').attr('value',businessid);
    $('#check_area').html('');
  }
</script>

<?php //表单验证JS  ?>
<script type="text/javascript">
  var mapInfo= {};
  $('#save').click(function(){
    // 获取type1
    var type1 = '', sep = '';
    $('a[name="type1"]').each(function(){
      if( $(this).hasClass("click") == true ){
        type1 += sep + $(this).attr('value');
        sep = '|';
      }
    });
    
    // 获取所选住宅
    var house = '';
    $('input[name="house"]').each(function(){
      if( $(this).prop('checked') == true ){
        house += $(this).val();
      }
    });

    // 获取所选别墅
    var villa = '';
    $('input[name="villa"]').each(function(){
      if( $(this).prop('checked') == true ){
        villa += $(this).val();
      }
    });

    // 获取所选写字楼
    var office = '';
    $('input[name="office"]').each(function(){
      if( $(this).prop('checked') == true ){
        office += $(this).val();
      }
    });

    // 获取所选商铺
    var store = '';
    $('input[name="store"]').each(function(){
      if( $(this).prop('checked') == true ){
        store += $(this).val();
      }
    });

    var _token = $('input[name="_token"]').val();
    var type2 = house + villa + office + store;// 获取所有物业类型2
    var pro_id = $('input[name="pro_id"]').val();// 获取省市id
    var cit_id = $('input[name="cit_id"]').val();// 获取城市id
    var cta_id = $('input[name="cta_id"]').val();// 获取城区id
    var bsa_id = $('input[name="bsa_id"]').val();// 获取商圈id lop_id
    var lop_id = $('input[name="lop_id"]').val();// 获取环线id
    var build_name = $('input[name="build_name"]').val();// 获取创建新楼盘的名称
    var address = $('input[name="address"]').val();// 获取创建新楼盘地址
    var longitude = $('#longitude').text(); // 获取经度
    var latitude = $('#latitude').text(); // 获取纬度

    var bank        = mapInfo['bank'];
    var food        = mapInfo['food'];
    var happy       = mapInfo['happy'];
    var hospital    = mapInfo['hospital'];
    var market      = mapInfo['market'];
    var park        = mapInfo['park'];
    var school      = mapInfo['school'];
    var traffic     = mapInfo['traffic'];


    if(!(/^\S.*$/.test(type1))){
      $('#check_type').html('请选择大物业类型');
      type1 = '';
    }else{
      $('#check_type').html('');
      if(!(/^\S.*$/.test(type2))){
        $('#check_type').html('请选择子物业类型');
        type2 = '';
      }else{
        $('#check_type').html('');
      }
    }
    if(!(/^\S.*$/.test(pro_id))){
      $('#check_area').html('请选择所属省市');
      pro_id = '';
    }else if(!(/^\S.*$/.test(cit_id))){
      $('#check_area').html('请选择所属城区');
      cit_id = '';
    }else if(!(/^\S.*$/.test(cta_id))){
      $('#check_area').html('请选择所属区/县');
      cta_id = '';
    }else if(!(/^\S.*$/.test(bsa_id))){
      $('#check_area').html('请选择所属商圈');
      bsa_id = '';
    }
    if(!(/^\S.*$/.test(build_name))){
      $('#check_name').html('请填写楼盘名称');
      build_name = '';
    }
    if(!(/^\S.*$/.test(lop_id))){
      $('#check_loop').html('请选择环线位置');
      lop_id = '';
    }else{
      $('#check_loop').html('');
    }
    if(!(/^\S.*$/.test(address))){
      $('#check_address').html('请输入地址并选择坐标点');
      address = '';
    }else{
      $('#check_address').html('');
    }
    if(!(/^\S.*$/.test(longitude))){
      $('#check_address').html('请输入地址并选择坐标点');
      longitude = '';
    }else{
      $('#check_address').html('');
    }
    if(!(/^\S.*$/.test(latitude))){
      $('#check_address').html('请输入地址并选择坐标点');
      latitude = '';
    }else{
      $('#check_address').html('');
    }
    if(type1 && type2 && pro_id && cit_id && cta_id && bsa_id && build_name && lop_id && address && longitude && latitude != ''){
      $.ajax({
        type : 'post',
        url  : '/addComm',
        data : {
          _token     : _token,
          type1      : type1,
          type2      : type2,
          pro_id     : pro_id,
          cit_id     : cit_id,
          cta_id     : cta_id,
          bsa_id     : bsa_id,
          lop_id     : lop_id,
          build_name : build_name,
          address    : address,
          longitude  : longitude,
          latitude   : latitude,
          //======================
          bank       : bank,
          food       : food,
          happy      : happy,
          hospital   : hospital,
          market     : market,
          park       : park,
          school     : school,
          traffic    : traffic
        },
        success : function(result){
          // 返回刚才存入的楼盘id
          // console.log(result);
          //先不跳转 调试传回的Object
          window.location.href = '/Comminfo?communityId='+result+'&type2='+type2;
        }
      });
    }
  });

  $('#build_name').blur(function(){
    var build_name = $('input[name="build_name"]').val();// 获取创建新楼盘的名称
    if(build_name.length != 0){
      $('#check_name').html('');
    }
    
  });
  $('#address').blur(function(){
    var address = $('input[name="address"]').val();// 获取创建新楼盘地址
    if(address.length != 0){
      $('#check_address').html('');
    }
    
  });

    var map = new AMap.Map("container", {
        resizeEnable: true,
        zoom:12
    });
    //为地图注册click事件获取鼠标点击出的经纬度坐标
    var clickEventListener = map.on('click', function(e) {
        $("#longitude").text(e.lnglat.getLng()); // 经度
        $("#latitude").text(e.lnglat.getLat()); // 纬度
    });

//    var mapInfo = {};
    function mapRim(obj, okey, longitude, latitude){
          var obj = obj;
          var okey = okey;
          var longitude = longitude;
          var latitude = latitude;
               AMap.service(["AMap.PlaceSearch"], function() {
                  var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                      pageSize: 10,
                      pageIndex: 1,
                      // city: "北京", //城市
                      map: map
                  });
                  var tmp = [];   
                  var cpoint = [longitude, latitude]; //中心点坐标
                  placeSearch.searchNearBy(obj, cpoint, 500, function(status, result) {
                      if(status == 'complete' && result.info == 'OK'){
                        // console.log(result);
                        var poiArr = result.poiList.pois;
                        var resultCount = poiArr.length;
                        
                        for(var i = 0;i<resultCount;i++){
                           tmp[i] = [poiArr[i].name,poiArr[i].address,poiArr[i].distance];
                        }
                      }
                      mapInfo[okey] = tmp;
                  });
              });
    }
  //===========================================================================
    $('input[name="submit"]').click(function(){
      var longitude = $('#longitude').text();
      var latitude = $('#latitude').text();
      if(longitude.length == 0 && latitude.length == 0){
        alert('请选择坐标点');
        return false;
      }else{
        $('.close').parent().hide(); 
        $('#lean_overlay').hide();
         var mapType = {'bank':'银行', 'traffic':'交通','happy':'娱乐','market':'超市','food':'餐饮','hospital':'医院','park':'公园','school':'学校'};
         for( var n in mapType){
          mapRim(mapType[n], n, longitude, latitude);
         }
      }
    });

</script>
</body>
</html>
