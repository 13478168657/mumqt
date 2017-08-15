@extends('mainlayout')
@section('title')
    <title>个人中心</title>
@endsection
@section('head')
	{{--<link rel="stylesheet" type="text/css" href="/css/personalHoutai.css?v={{Config::get('app.version')}}">--}}
	{{--<link rel="stylesheet" href="/css/checkInputStyle.css?v={{Config::get('app.version')}}">--}}
	<link rel="stylesheet" href="/css/personalManage.css?v={{Config::get('app.version')}}">
@endsection
@section('content')

<div class="user">
  {{--@include('user.myinfo.leftNav')--}}
  @include('user.userHomeLeft')
  <div class="user_r">
    <h2 class="edit">填写密码<span>手机直接登录，请设置密码</span></h2>
    <p id="editPwd" class="colorfe xg" style="display:none;" ></p>
    <form action="#" id="myForm">
		<div class="change_msg" style="width:640px;">
		<ul class="problem">
		  <li class="no_height">
		    <span>您的密码：</span>
		    <input type="password" class="txt" name="pass" id="rpropwdNum" datatype="*6-16" nullmsg="请输入密码" maxlength="16" errormsg="密码限制在6-16位" placeholder="密码限制在6-16位">
		  </li>
		  <li class="no_height">
		    <span>确认密码：</span>
		    <input type="password" class="txt" name="confirm" id="rpropwdsNum" datatype="*6-16"  nullmsg="请再输入一次密码！" maxlength="16" errormsg="您两次输入的账号密码不一致！" recheck="pass" placeholder="密码限制在6-16位"  >
		  </li>
		  <li>
		    <input type="button" class="btn no_margin" value="提交" onclick="$('#myForm').submit();">
		  </li>
		</ul>
		</div>
     </form>
  </div>
</div>
<input type="hidden" id="token" value="{{csrf_token()}}">
<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>
<script src="/js/myinfo.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/Validform_v5.3.2.js?v={{Config::get('app.version')}}"></script>
<script>
$(document).ready(function(e) {  
  $(".problem .problem_msg").click(function (event) {
	  $(".type").hide();
      $(this).find(".type").fadeIn();
      $(document).one("click", function () {//对document绑定一个影藏Div方法
         $(".type").hide();
      });
      event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
    });
    $(".problem .problem_msg .type").click(function (event) {
        event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
    });
	
  $(".problem_msg .type li").click(function(){
	$(this).parents(".birth_time").find("span").text($(this).text());
	$(this).parents(".type").hide();  
  });
});
</script>
<script>
    // 表单验证
	var formInfo = $("#myForm").Validform({
	    tiptype:3,
	    label:".label",
	    showAllError:true,
	    beforeSubmit:function(curform){
	        mySubmit();
	        return false;
	    }
	  });
  	formInfo.tipmsg.r=" ";
  	var token = $('#token').val();
  	// 检测用户名
  	function checkUserName(){
  		var userName = $('#rpronameNum');
  		if(!/^[a-zA-Z_][\w|_]{5,36}$/.test(userName.val())) return false;
  		$.post('/register', {_token:token, username:userName.val(), puid:1}, function(r){
  			
  		});
  		$.ajax({
  			type:'post',
  			url:'/register',
  			async:false,
  			data:{
  				_token:token,
  				puid:1,
  				username:userName.val()
  			},
  			success:function(r){
  				if(r == 2){
	  				userName.addClass('Validform_error').next('span.Validform_checktip').addClass('Validform_wrong').removeClass('Validform_right').text('此用户名已被占用');
	  				userName = false;
	  			}else{
	  				userName.removeClass('Validform_error').next('span.Validform_checktip').removeClass('Validform_wrong').addClass('Validform_right').text('');
	  				userName = userName.val();
	  			}
  			},
  			error:function(){
  				showError('网络错误，请稍候再试');
  				userName = false;
  			}
  		});
  		return userName;
  	}
  	// 显示正确信息
  	function showRight(str){
  		$('#editPwd').html('<i></i>'+ str).show();
  		setTimeout(function(){
  			$('#editPwd').hide();
  		}, 2000);
  	}
  	// 显示错误信息
  	function showError(str){
  		$('#editPwd').html('<i class="click"></i>'+ str).show();
  		setTimeout(function(){
  			$('#editPwd').hide();
  		}, 2000);
  	}
  	// 提交用户 信息
  	function mySubmit(){
  		//var userName = checkUserName();
  		var password = $('#rpropwdsNum').val();
  		//if(!userName) return false;
  		$.ajax({
  			type:'post',
  			url:'/ajax/usersetpwd',
  			data:{
  				_token:token,
  				//uname:userName,
  				pwd:password
  			},
  			success:function(r){
  				if(r == 1){

  					showRight('保存成功');
  					setTimeout(function(){
  						window.location.href="/user/interCommunity/xinF";
  					},1000);
  				}else{
  					showError('保存失败，请重试');
  					return false;
  				}
  			},
  			error:function(){
  				showError('网络错误，请稍候再试');
  				return false;
  			}
  		});
  	}
</script>
@endsection
