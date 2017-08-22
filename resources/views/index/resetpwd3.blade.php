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
      <dt class="back_color colorff">第二步</dt>
      <dd class="color_blue">2.找回密码</dd>
    </dl>
    <span></span>
    <dl>
      <dt class="back_color colorff">第三步</dt>
      <dd class="color_blue">3.重置密码</dd>
    </dl>
  </div>
  <div class="type_msg">
    <ul class="tel">
      <li>
        <label>新密码</label>
        <input type="password" class="txt" placeholder="密码限制在6-16位的字母、数字或字符" id="new1">
        <i class=""></i>
        <span class="span" id="res_newPwd1"></span>
      </li>
      <li>
        <label>确认密码</label> 
        <input type="password" class="txt" id="new2">
        <i class=""></i>
        <span class="span" id="res_newPwd2"></span>
      </li>
      <li><input class="btn back_color" type="button" id="resetSubmit"  value="提交"></li>
    </ul>
   <div class="reset" style="display:none;">
       <p class="p1"><i></i>账号<span class="color_blue" id="username"></span>的密码已重置成功！</p>
       <p class="p2"><a class="btn" href="#" id="clickLu">登录</a></p>
   </div>
  </div>
</div>
<script src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<input type="hidden" id="crtoken" name="crtoken" value="{{csrf_token()}}">
<script>
$(document).ready(function(e) {	
//  $(".tel .btn").click(function(){
//	$(this).parents(".tel").hide();
//	$(".reset").show();  
//  });
});
</script>
<script>
    var newPwd1, newPwd2;
    var token = $('#crtoken').val();
    $('#resetSubmit').click(function(){
        newPwd1 = $.trim( $('#new1').val() );
        newPwd2 = $.trim( $('#new2').val() );
        checkNewPwd1( newPwd1 );
        checkNewPwd2( newPwd2 );
        if( newPwd1 && newPwd2){
            $.ajax({
                type:'post',
                url:'/resetpassword/resetAdd',
                data:{
                    _token:token,
                    new1:newPwd1,
                    new2:newPwd2
                },
                dataType:'json',
                success:function(data){
                    if(data == 0){
                        alert('设置失败');
                        //window.location.reload();
                        return false;
                    }else{                        
                        alert('设置成功');
                        //window.location.reload();
                        $(".tel").hide();
                        $(".reset").show();
                        $('#username').text('【'+data[0].userName+'】');
                        return false;
                    }
                }
            });
        }else{
            return false;
        }
    });
    
    function checkNewPwd1( val){
    if(val == ''){
        showWrong('#res_newPwd1' ,'请输入新密码');
        $('#res_newPwd1').css('color','red');
        $('#res_newPwd1').prev().attr('class','answer click');
        newPwd1 = false;
        return false;
    }
    if ((/>|<|,|\[|\]|\{|\}|\?|\/|\+|=|\||\'|\\|\"|:|;|\~|\!|\@|\#|\*|\$|\%|\^|\&|\(|\)|`/i).test( val )) {
        showWrong('#res_newPwd1', "请勿用特殊字符" );
        $('#res_newPwd1').css('color','red');
        $('#res_newPwd1').prev().attr('class','answer click');
        newPwd1 = false;
        return false;
    }
    if ( val.indexOf(" ") > -1) {
        showWrong('#res_newPwd1', "请不要输入空格");
        $('#res_newPwd1').css('color','red');
        $('#res_newPwd1').prev().attr('class','answer click');
        newPwd1 = false;
        return false;
    }
    if (!/.{6,16}/.test( val )) {
        showWrong('#res_newPwd1', "长度要求6-16个字符");
        $('#res_newPwd1').css('color','red');
        $('#res_newPwd1').prev().attr('class','answer click');
        newPwd1 = false;
        return false;
    }
    showWrong('#res_newPwd1', "");
    $('#res_newPwd1').prev().attr('class','');
    newPwd1 = val;
}

function checkNewPwd2( val ){
    if(val == ''){
        showWrong('#res_newPwd2' ,'请再次输入新密码');
        $('#res_newPwd2').css('color','red');
        $('#res_newPwd2').prev().attr('class','answer click');
        newPwd2 = false;
        return false;
    }else{
        if( val != $.trim($('#new1').val())){
            showWrong('#res_newPwd2' ,'再次密码不一致');
            $('#res_newPwd2').css('color','red');
            $('#res_newPwd2').prev().attr('class','answer click');
            newPwd2 = false;
            return false;
        }else{
            showWrong('#res_newPwd2', "");
            $('#res_newPwd2').prev().attr('class','');
            newPwd2 = val;
        }
    }
}
function showWrong( obj, cont){
    $(obj).text(cont);
}

// 点击登陆
$('#clickLu').click(function(){
    $.ajax({
        type : 'POST',
        url : '/resetpassword/clickLoad',
        data : {
            _token : token,
        },
        dataType : 'json',
        success : function(msg){
            if(msg == 4){
                alert('密码重置成功，请到登陆页面重新登陆');
            }else{
                window.location.href = '/user/interCommunity/xinF';
            }
        }
    });
});
</script>
@endsection
