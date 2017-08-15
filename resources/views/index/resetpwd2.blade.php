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
      <dt>第三步</dt>
      <dd>3.重置密码</dd>
    </dl>
  </div>
    <p class="nav_type">
    <a class="click">手机找回</a>
    @if(!empty($email))
    <a id="youxiang">邮箱找回</a>
    @else
    <span>邮箱找回</span>
    @endif
    @if(!empty($question))
    <a>问题找回</a>
    @else
    <span>问题找回</span>
    @endif
    <a style=" width:280px; padding:0;"></a>
  </p>
  <div class="type_msg">
    <ul class="tel">
      <li>
        <label>手机号</label>
        <input type="text" class="txt" name="rpromobile" id="rpromobile" onblur="phoneOnBlur();this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')">
        <i class=""></i>
        <span class="span" id="mobile"></span>
      </li>
      <li style="display: none;">
        <label>&nbsp;</label>
        <input type="text" id="img_code_val" class="txt width" autocomplete="off">
        <i class=""></i>
        <span class="span"></span>
        <img src="/vercode" alt="验证码" class="hq" id="img_code" onclick="this.src='/vercode?code='+Math.random();" style="width:84px;height:30px;float:left;margin: 5px 0 0 50px;">
      </li>
      <li>
        <label>验证码</label> 
        <input type="text" class="txt width" name="rproyzm" id="rproyzm" onafterpaste="this.value=this.value.replace(/\D/g,'')">
        <i class=""></i>
        <span class="span" id="code"></span>
        <input type="button" class="btn1 back_color" id="btn_code" value="发送验证码">
      </li>
      <li><a href="javascript:void(0);"><input class="btn border_blue back_color" type="button" onclick="submitAjax()" value="下一步"></a></li>
    </ul>
   </form>
   <form class="meail" style="display:none;">
    <ul>
      <li>
        <label style=" width:60px;">邮箱</label>
        <input type="text" class="txt" id="email">
        <i class=""></i>
        <span class="span" style="left:60px;" id="email_error"></span>
      </li>
      <li><a href="javascript:void(0);"><input class="btn border_blue back_color" type="button" id="email_btn" value="发送邮件"></a></li>
    </ul>
    </form>
    <form class="problem"  style="display:none;">
    <ul>
      @if(!empty($question))
      @foreach($question as $key => $ques)
      <li>
        <label>问题@if($key == 0)一@elseif($key == 1)二@elseif($key == 2)三@endif</label>
        <span class="tishi" value="{{$ques->id}}">{{$ques->question}}</span>
      </li>
      <li>
        <label>回答</label>
        <input type="hidden" value="{{$ques->id}}" id="idVal{{$key+1}}"/>
        <input type="text" class="txt" id="question{{$key+1}}" value="">
        <i class=""></i>
        <span class="span" id="error{{$key+1}}"></span>
      </li>
      @endforeach
      @endif
<!--      <li>
        <label>问题二</label>
        <span class="tishi">您的兴趣爱好？</span>
      </li>
      <li>
        <label>回答</label>
        <input type="text" class="txt">
        <i class="answer"></i>
        <span class="span">ssss</span>
      </li>
      <li>
        <label>问题三</label>
        <span class="tishi">您的兴趣爱好？</span>
      </li>
      <li>
        <label>回答</label>
        <input type="text" class="txt">
        <i class="answer"></i>
        <span class="span">ssss</span>
      </li>-->
<li><a href="javascript:void(0);"><input class="btn border_blue back_color" type="button" id="question" value="下一步"></a></li>
    </ul>
  </div>
</div>
<script src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<input type="hidden" id="crtoken" name="crtoken" value="{{csrf_token()}}">
<input type="hidden" id="select" value="1">
<input type="hidden" id="userId" value="{{$id}}">
<input type="hidden" id="ck" name="ck" value="{{$ck}}">
<script>
$(document).ready(function() {
   var ck = $('#ck').val();
   if(ck == 1){
       $('#youxiang').addClass("click");
       $(".type_msg .meail").show(); 
        $(".type_msg .tel").hide(); 
        $(".type_msg .problem").hide(); 
        $('#select').val('2');      
   }
   $(".nav_type a").click(function(){
	  $(".nav_type a").removeClass("click"); 
	  $(this).addClass("click");
	  if($(this).text()=="手机找回"){
		 $(".type_msg .tel").show(); 
		 $(".type_msg .meail").hide(); 
		 $(".type_msg .problem").hide(); 
                 $('#select').val('1');
	  }else if($(this).text()=="邮箱找回"){
		 $(".type_msg .meail").show(); 
		 $(".type_msg .tel").hide(); 
		 $(".type_msg .problem").hide(); 
                 $('#select').val('2');
	  }
	  else if($(this).text()=="问题找回"){
		 $(".type_msg .problem").show(); 
		 $(".type_msg .tel").hide(); 
		 $(".type_msg .meail").hide(); 
                 $('#select').val('3');
	  }
   });	
});
</script>
<script>
    /*********************************  手机找回 start  **********************************/   
    var userPhone,userCode,userToken;
    var codeCountdown = 60;
    // 获取文本框的值
    function getAllInputs(){
        userPhone   = $.trim($('#rpromobile').val());
        userCode    = $.trim($('#rproyzm').val());
        userToken   = $.trim($("#crtoken").val());
    }
    $(function(){
        getAllInputs();
    });
    // 手机框失去焦点事件
    function phoneOnBlur(){
        getAllInputs();
        if(!userPhone.length){
            $('#mobile').prev().attr("class","");
            return false;
        }
        if(userPhone.length != 11){
            $('#mobile').text('手机号长度错误！');
            $('#mobile').css('color','red');
            $('#mobile').prev().attr('class','answer click');
            //$('#btn_code').removeClass("back_color");
            return false;
        }else{
            $('#mobile').text('');
            $('#mobile').prev().attr('class','');
        }
        var pattern = /^1[3|4|5|7|8]\d{9}$/;
        if(!pattern.test(userPhone)){
            $('#mobile').text('手机号格式错误！');
            $('#mobile').css('color','red');
            $('#mobile').prev().attr('class','answer click');
            //$('#btn_code').removeClass("back_color");
            return false;
        }else{
            $('#mobile').text('');
            $('#mobile').prev().attr('class','');
        }
       
        
    }
    $('#btn_code').click(clickCode);
    // 发送验证码
    function clickCode(){
           getAllInputs();
            var mobile2 = $.trim(userPhone);
            var patt = /^1[3|4|5|7|8]\d{9}$/;
            if(!patt.test(mobile2)){
                $('#mobile').text('手机号格式不对');
                $('#mobile').css('color','red');
                $('#mobile').prev().attr('class','answer click');
                return false;
            }else{
                // 增加图片验证码
                $('#img_code_val').parent().show();
                var img_code = $('#img_code_val').val();
                if(img_code.length == 0 || img_code == ''){
                    $('#img_code_val').focus();
                    $('#img_code_val').nextAll('span').text('请输入图片验证码').css('color','red');
                    return;
                }
                $('#img_code_val').nextAll('span').text('');
                $('#mobile').text('');
                $('#mobile').prev().attr('class','answer');
                 //  检查手机号是否是用户绑定的手机号
                $.ajax({
                   type: 'POST',
                   url: '/resetpassword/checkAccount', //URL地址
                   data: {
                       _token:  userToken,
                       field : userPhone,
                       type : 1 //
                   },
                   dataType:'json',
                   success: function (msg) {
                       if(msg == 4){
                            $('#mobile').text('请输入您绑定的手机号！');
                            $('#mobile').prev().attr('class','answer click');
                            $('#mobile').css('color','red');
                       }else{
                            $('#mobile').text('');
                            $('#mobile').prev().attr('class','answer');
                            //$('#btn_code').addClass("back_color");
                            sendCode(userPhone,img_code);
                       }
                   }
               });
                    
            }
    };
    // 发送验证码
    function sendCode(mobile2,img_code){
        var url = '/yzmobile';
        $.ajax({
                type:'post',
                url:url,
                data:{
                    _token:userToken,
                    mobile:mobile2,
                    mid:2,
                    imgCode:img_code
                },
                dataType:'json',
                success:function(data){
                    if(typeof data == 'object'){
                        if(data.res == 1){
                            alert(data.message);
                            return false;
                        }
                        if(data.res == 3){
                            $('#img_code_val').nextAll('span').text('图片验证码错误');
                            return false;
                        }
                    }
                    $('#img_code').parent().hide();
                    $('#img_code').click();
                    $('#img_code_val').val('');
                    sendCodeTime('#btn_code');
                }
        });
    }
    
    //发送验证码计时器
 	function sendCodeTime(obj){
	 	var second = 60;
	 	var machine;
	 	$(obj).attr('disabled',true);
	 	machine = setInterval(function(){
	 		if(second >= 0){
	 			$(obj).val('重新发送('+second+'s)');
	 			second--;
	 		}else{
	 			clearInterval(machine);
	 			$(obj).val('获取验证码');
	 			$(obj).removeAttr('disabled');
	 			return false;
	 		}
	 	},1000);
 	}
        //  验证码失去焦点事件
        $('#rproyzm').blur(function(){
            $('#code').text('');
            $('#code').prev().attr('class','');
        });
        
      /**
    * 提交
    */
   function submitAjax(data){
       getAllInputs();
       if(userCode == ''){
           $('#code').text('验证码不能为空！');
           $('#code').prev().attr('class','answer click');
           $('#code').css('color','red');
           return false;
       }
       $('#code').text('');
       $('#code').prev().attr('class','answer');
       $.ajax({
           type: 'POST',
           url: '/resetpassword/resetWay',
           data: {
               _token : userToken,
               phone : userPhone,
               code : userCode,
               type : 1
           },
           dataType:'json',
           success: function (msg) {
               if(msg == 2){
                    $('#mobile').text('手机号格式不正确！');
                    $('#mobile').prev().attr("class","answer click");
                    $('#mobile').css('color','red');
               }
               if(msg == 3){
                    $('#mobile').text('用户不存在！');
                    $('#mobile').prev().attr("class","answer click");
                    $('#mobile').css('color','red');
               }
               if(msg == 4){
                    $('#code').text('验证码错误！');
                    $('#code').prev().attr("class","answer click");
                    $('#code').css('color','red');
               }
               if(typeof msg == 'object'){
                  $('#mobile').prev().removeClass('click');
                  $('#mobile').text('');
                  $('#code').prev().attr("class","answer");
                  $('#code').text(''); 
                  window.location.href = '/resetpassword?type=3';
              }
           }
       });
   }
   
      /*********************************  手机找回 end  **********************************/  
      
      /*********************************  邮箱找回 start  **********************************/ 
      $('#email').blur(function(){
          $('#email_error').text('');
          $('#email_error').prev().attr('class','');
      });
      $('#email_btn').click(function(){
          var email = $.trim($('#email').val());
          if(email == ''){
              $('#email_error').text('邮箱不能为空！');
              $('#email_error').css('color','red');
              $('#email_error').prev().attr('class','answer click');
              return false;
          }
          var patt = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!patt.test(email)){
              $('#email_error').text('邮箱格式错误！');
              $('#email_error').css('color','red');
              $('#email_error').prev().attr('class','answer click');
              return false;
          }
//          $('#email_error').text('');
//          $('#email_error').prev().attr('class','answer');
          $.ajax({
              type : 'POST',
              url : '/resetpassword/checkAccount',
              data : {
                  _token : userToken,
                  field : email,
                  type : 2    
              },
              dataType : 'json',
              success : function(msg){
                  if(msg == 4){
                        $('#email_error').text('请输入您绑定的邮箱！');
                        $('#email_error').css('color','red');
                        $('#email_error').prev().attr('class','answer click');
                  }else{
                        $('#email_error').text('');
                        $('#email_error').prev().attr('class','answer');
                        // 执行发送邮箱功能
                        youxiang(email);
                  }
              }
          });
      });
      function youxiang(email){
          $.ajax({
              type : 'POST',
              url : '/resetpassword/resetWay',
              data : {
                  _token : userToken,
                  email : email,
                  type : 2    //  通过邮箱找回
              },
              dataType : 'json',
              success : function(msg){
                  if(msg == 2){
                        $('#email_error').text('邮箱格式错误！');
                        $('#email_error').css('color','red');
                        $('#email_error').prev().attr('class','answer click');
                  }else if(msg == 3){
                        $('#email_error').text('邮箱不存在！');
                        $('#email_error').css('color','red');
                        $('#email_error').prev().attr('class','answer click');
                  }else if(msg == 4){
                        $('#email_error').text('邮件发送失败！');
                        $('#email_error').css('color','red');
                        $('#email_error').prev().attr('class','answer click');
                  }else{
                      alert('邮件发送成功，请到您的邮箱去激活！');
                  }
              }
          });
      }
      
      /*********************************  邮箱找回 end  **********************************/
      
      /*********************************  密保问题找回 start  **********************************/ 
      $('#question1').blur(function(){
          $('#error1').text('');
          $('#error1').prev().attr('class','');
      });
      $('#question2').blur(function(){
          $('#error2').text('');
          $('#error2').prev().attr('class','');
      });
      $('#question2').blur(function(){
          $('#error2').text('');
          $('#error2').prev().attr('class','');
      });
      var flag1 = true;
      var flag2 = true;
      var flag3 = true;
      //  获取id值
      var id1 = $('#idVal1').val();
      var id2 = $('#idVal2').val();
      var id3 = $('#idVal3').val();
      $('#question').click(function(){
            var userId = $('#userId').val();
            var question1 = $.trim($('#question1').val());
            var question2 = $.trim($('#question2').val());
            var question3 = $.trim($('#question3').val());
           if(question1 == ''){
               $('#error1').text('答案不能为空！');
               $('#error1').css('color','red');
               $('#error1').prev().attr('class','answer click');
               flag1 = false;
           }else{
               $('#error1').text('');
               $('#error1').prev().attr('class','answer');
           }
           if(question2 == ''){
               $('#error2').text('答案不能为空！');
               $('#error2').css('color','red');
               $('#error2').prev().attr('class','answer click');
               flag2 = false;
           }else{
               $('#error2').text('');
               $('#error2').prev().attr('class','answer'); 
           }
           if(question3 == ''){
               $('#error3').text('答案不能为空！');
               $('#error3').css('color','red');
               $('#error3').prev().attr('class','answer click');
               flag3 = false;
           }else{
               $('#error3').text('');
               $('#error3').prev().attr('class','answer');
           }
           if(flag1 && flag2 && flag3){           
            var dataQ = [{'id':id1,'question':question1},{'id':id2,'question':question2},{'id':id3,'question':question3}];
            $.ajax({
                type : 'POST',
                url : '/resetpassword/resetWay',
                data : {
                    _token : userToken,
                    question : dataQ,
                    type : 3,
                    id : userId
                },
                dataType : 'json',
                success : function(msg){
                    if(typeof msg == 'number' && msg == 3){
                        $('#error1').prev().attr('class','answer');
                        $('#error2').prev().attr('class','answer');
                        $('#error3').prev().attr('class','answer');
                        window.location.href = '/resetpassword?type=3';
                    }else{
                        for(var i in msg){
                            if(msg[i] == id1){
                                 $('#error1').text('答案错误！');
                                 $('#error1').css('color','red');
                                 $('#error1').prev().attr('class','answer click');
                            }else if(msg[i] == id2){
                                 $('#error2').text('答案错误！');
                                 $('#error2').css('color','red');
                                 $('#error2').prev().attr('class','answer click');
                            }else if(msg[i] == id3){
                                 $('#error3').text('答案错误！');
                                 $('#error3').css('color','red');
                                 $('#error3').prev().attr('class','answer click');
                            }
                        }
                    }
                }
            });
           }else{
               return false;
           }
      });
      /*********************************  密保问题找回 end  **********************************/
    
    

 
   
</script>
@endsection
