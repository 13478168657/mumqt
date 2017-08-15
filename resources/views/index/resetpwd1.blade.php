@extends('mainlayout')
@section('title')
    <title>搜房网 重置密码</title>
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="css/personalLogin.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="css/common.css?v={{Config::get('app.version')}}">
<div class="pwd_main">
  <div class="bs">
    <dl>
      <dt class="back_color colorff">第一步</dt>
      <dd class="color_blue">1.确认账户</dd>
    </dl>
    <span></span>
    <dl>
      <dt>第二步</dt>
      <dd>2.找回密码</dd>
    </dl>
    <span></span>
    <dl>
      <dt>第三步</dt>
      <dd>3.重置密码</dd>
    </dl>
  </div>
  <div class="type_msg">
   <form>
    <ul class="tel">
      <li>
        <label>账号</label>
        <input type="text" class="txt" placeholder="请输入您的账号/手机号/邮箱" id="user_name">
        <i class=""></i>
        <span class="span" id="error_user"></span>
      </li>
      <li>
        <label>验证码</label> 
        <input type="text" class="txt width" id="code_val_num">
        <i class=""></i>
        <img src="{{url('/vercode')}}" alt="验证码" id="ver_code" onclick="this.src='/vercode?code='+Math.random();" style="height:40px;margin-left:50px;">
        <span class="span" id="error_code_text"></span>
<!--        <input type="button" class="btn1 back_color" value="图片验证码">-->
      </li>
      <li><a href="#"><input class="btn border_blue back_color" type="button" onclick="checkUser()" value="下一步"></a></li>
    </ul>
    </form>
  </div>
</div>
<input type="hidden" id="crtoken" name="crtoken" value="{{csrf_token()}}">
<script src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script>
    
    var crtoken = $('#crtoken').val(); 
    $('#user_name').blur(function(){
        $('#error_user').prev().attr('class','');
        $('#error_user').text('');
    });
    $('#code_val_num').blur(function(){
        $('#error_code_text').text('');
        $('#error_code_text').prev().prev().attr('class','');
    });
    // 确认用户是否存在
    function checkUser(){
        var user_name = $.trim($('#user_name').val());
        var code_val = $.trim($('#code_val_num').val());
        $.ajax({
          type : 'POST',
          url : '/resetpassword/confirmuser',
          data : {
             _token : crtoken,
             code : code_val,
             name : user_name
          },
          dataType : 'json',
          success : function(msg){
              if(msg == 1){
                  $('#error_user').prev().attr('class','answer click');
                  $('#error_user').text('账号不能为空！');   
                  $('#error_user').css('color','red');  
                  return false;
              }else if(msg == 2){
                  $('#error_code_text').prev().prev().attr('class','answer click');
                  $('#error_code_text').text('验证码不能为空！');
                  $('#error_code_text').css('color','red');
                  return false;
              }else if(msg == 3){
                  $('#error_code_text').prev().prev().attr('class','answer click');
                  $('#error_code_text').text('验证码错误！');
                  $('#error_code_text').css('color','red');
                  return false;
              }else if(msg == 4){
                  $('#error_user').prev().attr('class','answer click');
                  $('#error_user').text('账号格式错误！');   
                  $('#error_user').css('color','red');  
                  return false;
              }else if(msg == 5){
                  $('#error_user').prev().attr('class','answer click');
                  $('#error_user').text('该账号不存在！');   
                  $('#error_user').css('color','red');  
                  return false;
              }
              if(msg == 6){
                  $('#error_user').prev().attr('class','answer');
                  $('#error_user').text('');
                  $('#error_code_text').prev().prev().attr('class','answer');
                  $('#error_code_text').text('');
                  alert('请在15分钟之内完成密码重置');
                  window.location.href = '/resetpassword?type=2';
              }
          }
      });
    }
</script>
@endsection
