@extends('mainlayout')
@section('title')
  <title>个人后台</title>
@endsection
@section('head')
  <link rel="stylesheet" type="text/css" href="/css/personalManage.css?v={{Config::get('app.version')}}">
  {{--  <link rel="stylesheet" type="text/css" href="/css/personalHoutai.css?v={{Config::get('app.version')}}">--}}
  <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css?v={{Config::get('app.version')}}">
  <link rel="stylesheet" type="text/css" href="http://sandbox.runjs.cn/uploads/rs/351/8eazlvc1/imgareaselect-anima.css" />
@endsection
@section('content')
  <div class="user">
    @include('user.userHomeLeft')
    <div class="user_r">

    <h2 class="edit">编辑个人信息</h2>
    <p class="colorfe xg" id="editSuccess" style="display:none;"><i></i>设置成功</p>
    <div class="edit_msg">
      <ul class="msg_contant">
      	{{--<li>--}}
          {{--<label class="label">用户名</label>--}}
          {{--<span>{{$info[0]->userName}}</span>--}}
        {{--</li>--}}
        <li>
          <label class="label">手机号</label>
          <span class="fontA" id="userMobile1">{{$info[0]->mobile}}</span>
          <!--<a class="margin_l color_blue modaltrigger" onclick="clearEditMobileInfo();" href="#change_pwd">修改</a>-->
        </li>
        <li>
          <label class="label">性别</label>
          <span><input type="radio" name="gender" value="1" @if($info[0]->gender == 1 || $info[0]->gender == 0) checked @endif>&nbsp;男</span>
          <span class="margin_l"><input type="radio" name="gender" value="2" @if($info[0]->gender == 2) checked @endif>&nbsp;女</span>
          <span class="res_info" id="res_gender"></span>
          <div class="clear"></div>
        </li>
        <li>
          <label class="label"><span style="color:red;">*</span>出生日期</label>
          <div >
            	<span><input type="text" class="laydate-icon" style="width:107px;" name="birthday" id="birthday" value="@if(!empty($info[0]->birthday)){{$info[0]->birthday}}@endif" ></span>
          </div>
          <span class="res_info" id="res_birthday"></span>
          <div class="clear"></div>
        </li>
        <li>
          <label class="label"><span style="color:red;">*</span>所属城市</label>
          <div class="birth_time">
            <input type="hidden" id="provinceId" value="{{$info[0]->provinceId}}">
            <input type="hidden" id="cityId" value="{{$info[0]->cityId}}">
            <input type="hidden" id="cityAreaId"  value="{{$info[0]->cityAreaId}}">
            <a class="brith"><span class="fontA" id="result_provinceId"  value=""></span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul style=" left:0;" id="province_list">
                @if(isset($province))
                @foreach($province as $proval)
                <li value="{{$proval->id}}" class="select_provinceId">{{$proval->name}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
          </div>
          <div class="birth_time">
            <a class="brith"><span class="fontA" id="result_cityId" value=""></span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul id="city_list" >
                @if(isset($city))
                @foreach($city as $cityval)
                <li value="{{$cityval->id}}" class="select_cityId">{{$cityval->name}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
          </div>
          <div class="birth_time">
            <a class="brith"><span class="fontA" id="result_cityAreaId" value=""></span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul id="cityArea_list">
                @if(isset($cityArea))
                @foreach($cityArea as $areaval)
                <li value="{{$areaval->id}}" class="select_cityAreaId">{{$areaval->name}}</li>
                @endforeach
                @endif
               
              </ul>
            </div>  
          </div>
          <span class="res_info" id="res_address"></span>
          <div class="clear"></div>
        </li>
      </ul>
      <dl class="edit_head" id="head_photo">
        @if(!empty($info[0]->photo))
        <dt><img src="{{config('imgConfig.imgSavePath')}}{{$info[0]->photo}}" width="122" height="122" alt=""></dt>
        @else
        <dt><img src="/image/user.png" width="122" height="122" alt=""></dt>
        @endif
        <dd><a class="modaltrigger" href="#change_img">修改头像</a></dd>
      </dl>
      <div class="clear"></div>
    </div>
    <div class="depict">
     <p>
       <label>个人描述</label>
       <textarea class="txtarea" id="intro" value="" name="intro">@if($info[0]->intro){{$info[0]->intro}}@endif</textarea>
     </p>
     <!-- <span class="res_info" id="res_intro"></span> -->
     <div class="clear"></div>
     <p><input type="button" class="btn back_color" id="saveInfo" value="保存信息"></p>
    </div>
  </div>
</div>
<div class="change_img" id="change_img">
  <span class="close" onClick="$('#lean_overlay ~ div').hide();"></span>
  <h2>修改头像</h2>
  <form id="loginform" name="loginform" method="post" action="/myinfo/imgUpload" >
    <div class="change_top">
      <div class="upload">
        <div id="frame" class="frame" style="width: 100%; height:auto; float: left;  overflow: hidden; display: none;">
          <img id="photo" style="margin: 0 auto; display:block;" alt="拍照的图片" />
        </div>
      </div>

      <div class="upload_img">
        <input type="button" class="btn" id="picUpload" value="上传图片">
        <input type="file" id="upload" style="filter: alpha(opacity = 0); opacity: 0; width: 120px; height: 38px;display:none;" />
        <dl class="effect" style="margin-left: 40px; width: 120px;">
          <div id="preview" style="width:120px; height:160px; overflow: hidden; position: relative;float: left; margin-bottom: 20px;">
            @if(!empty($info[0]->photo))
            <img src="{{config('imgConfig.imgSavePath')}}{{$info[0]->photo}}" id="photo1"  alt="拍照的图片" />
            @else
            <img id="photo1" src="/image/default.png" width="100%" alt="拍照的图片" />
            @endif
            <span style="position: absolute; top: 0px; left: 0px; background: url(/images/border_user.png) no-repeat; display: inline-block; width: 120px; height: 160px;"></span>
          </div>
         <dd>预览效果</dd>
        </dl>
        <p>图片仅支持JPEG格式</p>
      </div>
    </div>
    <div class="clear"></div>
    <span id="photoerror" style="position:relative;left:265px;top:10px;text-algin:center;color:red;font-size:10px;height:10px;"></span>
    <p class="upload_btn">
      <input type="button" id="picSub" class="keep" value="保存">
      <input type="button" class="cancel" value="取消" id="cancel">
    </p>
    <input id="x1" name="x1" type="hidden" /> 
    <input id="y1" name="y1" type="hidden" />
    <input id="CutWidth" name="CutWidth" type="hidden" /> 
    <input id="CutHeight" name="CutHeight" type="hidden" /> 
    <input id="imgdata" name="imgdata" type="hidden" /> 
    <input id="imgcut" name="imgcut" value="0" type="hidden" />
    <input type="hidden" id="vcode" value="{{csrf_token()}}">
    <input id="PicWidth" name="PicWidth" type="hidden" /> 
    <input id="PicHeight" name="PicHeight" type="hidden" />
  </form>
</div>
<div class="change_tel" id="change_pwd">
  <span class="close" onClick="$(this).parent().hide();$('#lean_overlay').hide();"></span>
  <h2>更换密保手机号</h2>
  <div class="change1">
    <p class="p1">为了保证你的账户安全，更换密保手机号前请先进行安全验证</p>
    <p class="p2">
      你当前手机号是：<span class="fontA">{{$info[0]->mobile}}</span>
      <span id="current_mobile1_error" style="position:relative;left:30px;color:red;font-size:10px;height:10px;"></span>
    </p>
    <form id="changeform" name="changeform" method="post">
      <p>
        <input type="text" class="txt" id="current_mobile1" placeholder="请输入完整的手机号码">
      </p>
      <p><input type="button" class="btn back_color" value="确定" id="edit_mobile1"></p>
    </form>
    <p class="p3">如你的密保工具都已无法使用，<a href="#">请点此申诉</a>，成功后可更换。</p>
  </div>
  <div class="change2" style="display:none;">
    <p class="p1">请输入您要绑定的手机号，绑定后即可用该手机号登录搜房</p>
    <p class="p_tel">
      <label>手机号</label>
      <input type="text" id="edit_mobile2" class="tel_txt">
      <span id="edit_mobile2_error" class="editTel"></span>
      <span class="clear"></span>
    </p>
    <p class="p_code" style="display: none;">
      <label>&nbsp;</label>
      <input type="text" id="img_code_val" class="tel_txt code_txt" autocomplete="off">
      <img src="/vercode" alt="验证码" id="img_code" onclick="this.src='/vercode?code='+Math.random();" style="width:86px;height:30px;float:left;margin-left:35px;margin-top:4px;">
      <span class="editTel"></span>
      {{--<span class="clear"></span>--}}
    </p>
    <p class="p_code">
      <label>验证码</label>
      <input type="text" id="verify_code" class="tel_txt code_txt">
      <input type="button" class="code_btn back_color" id="send_verify" value="获取验证码">
      <span id="edit_mobile3_error" class="editTel"></span>
      <span class="clear"></span>
    </p>
    <p class="no_margin"><input type="button" class="btn back_color" id="testing_vcode" value="确定" ></p>
    <ul class="prompt">
      <li><span></span>你可使用此密保手机号找回密码及登录</li>
      <li><span></span>请勿随意泄露手机号，以防被不法分子利用，骗取账号信息</li>
    </ul>
  </div>
  <div class="change3" style="display:none;">
    <p class="p"><i></i>更换密保手机号成功</p>
  </div>
</div>
@include('user.myinfo.footer')
<!-- 日期选择js插件   -->
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<!-- 头像上传js       -->
<script type="text/javascript" src="/js/jquery.imgareaselect.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/fullAvatarEditor.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/yuImgCut.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/userpicLoad.js?v={{Config::get('app.version')}}"></script>
<script>
/*   选择日期插件 start  */
  ;!function(){ 
    laydate({
     elem: '#birthday'
    })
  }();
  /*   选择日期插件 end  */
</script>
<script type="text/javascript">
$(function(){
  $('#loginform').submit(function(e){
	  return false;
  });
  $('#changeform').submit(function(e){
	  return false;
  });
  //弹出层调用语句
//  $('.modaltrigger').leanModal({
//	  top:110,
//	  overlay:0.45,
//	  closeButton:".hidemodal"
//  });

});
</script>
@endsection

