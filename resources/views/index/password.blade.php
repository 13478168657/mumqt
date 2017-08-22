<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>手机找回</title>
<link rel="stylesheet" type="text/css" href="/css/login.css?v={{Config::get('app.version')}}">
<link rel="stylesheet" type="text/css" href="/css/common.css?v={{Config::get('app.version')}}">
<script src="/js/jquery.min.js?v={{Config::get('app.version')}}"></script>
<link rel="stylesheet" type="text/css" href="/css/color.css?v={{Config::get('app.version')}}">
</head>

<body>
<header class="pwd_head">
 <div class="top_pwd">
  <div class="logo"><a href="index.htm"><img src="/image/big_logo.jpg" alt=""></a></div>
  <div class="dotted"></div>
  <h2>找回密码</h2>
  <ul class="nav">
    <li><a href="{{url('/')}}">返回首页</a></li>
    <li><a href="login.htm">登录</a></li>
    <li class="dotted"></li>
    <li><a href="register.htm">注册</a></li>
  </ul>
 </div>
</header>
<div class="pwd_main">
  <p class="nav_type">
    <a class="click">手机找回</a>
    <a>邮箱找回</a>
    <a>问题找回</a>
    <a style=" width:280px; padding:0;"></a>
  </p>
  <div class="type_msg">
   <form>
    <ul class="tel">
      <li>
        <label>手机号</label>
        <input type="text" class="txt" id="mobile" maxlength="11" onblur="vmobile()" onkeyup="this.value=this.value.replace(/\D/g,'');Checkmobile()"  onafterpaste="this.value=this.value.replace(/\D/g,'')" />
       
        <span class="ti" id="errorphone"></span>
        <i class="an" id="msphone"></i>
        
      </li>
        <script>
            function vmobile(){
                Checkmobile();
            }
            function Checkmobile(){
                if($.trim($("#mobile").val())==""){
                    meg = '手机号码不能为空';
                    ys = "red";
                    dx = "answer click";
                    ckmob(meg,ys,dx);
                    return false;
                }else{
                    var reg = /^1[3|4|5|8][0-9]\d{8}$/;
                    if(!reg.test($.trim($('#mobile').val())) ){
                        meg = '手机号码格式不对';
                        ys = "red";
                        dx = "answer click";
                        ckmob(meg,ys,dx);
                        return false;
                    }else{
                        meg = '手机号正确';
                        ys = "green";
                        dx = "answer";
                        ckmob(meg,ys,dx);
                        return false;
                    }
                }
                function ckmob(meg,ys,dx){
                    document.getElementById('errorphone').innerHTML = meg;
                    document.getElementById('errorphone').style.color = ys;
                    $("#msphone").attr("class",dx);
                    return false;
                }
            }
        </script>
      <li>
        <label>验证码</label> 
        <input type="text" class="txt width"  onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="6" />
        <i class="answer click" id="iyzm"></i>
        <input type="button" class="btn1 color_blue border_blue" value="发送验证码" onclick="settime(this)">
      </li>
        <script>
            var countdown=60; 
            function settime(val){ 
                mobile = $("#mobile").val();
                if(countdown == 0){ 
                    val.removeAttribute("disabled");    
                    val.value="重新发送";
                    $("#btn").removeClass("back8d");
                    countdown = 60; 
                    return;
                }else{
                    if (countdown == 60){
                        /AJAX发送
                      
                        $.ajax({
                            type: 'POST',
                            url: '/sendmobile',
                            data: {
                                _token:'{{csrf_token()}}',
                                mobile : mobile,  
                            },
                            dataType:'json',
                            success: function (data) {
                                   alert(data);
                            }
                        }); 
                        
                       / $("#iyzm").attr("class","answer");
                    }
                    val.setAttribute("disabled", true); 
                    val.value="重新发送(" + countdown + ")"; 
                    countdown--; 
                }
                setTimeout(function() { 
                    settime(val) 
                },1000)
            }
      </script>
      <li><input class="btn back_color" type="button" value="提交"></li>
    </ul>
    </form>
   <form class="meail" style="display:none;">
    <ul>
      <li>
        <label style=" width:60px;">邮箱</label>
        <input type="text" class="txt" id="email" onkeyup="checkEmail()">
        <span class="ti" id="ebemail"></span>
        <i class="ans" id="iemail"></i>
      </li>
        <script>
        function checkEmail(){
            var email=$.trim($("#email").val());
            /var re = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
            var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ ; 
            if($.trim($("#email").val())==""){
                tb ="answer click";
                msg = '请输入邮箱';
                ys = 'red';
                chkmail(msg,ys,tb);
                return false;
            }
            if(re.test(email)){
                tb ="answer";
                msg = '邮箱格式正确';
                ys = 'green';
                chkmail(msg,ys,tb);
            }else{
                tb ="answer click";
                msg = '邮箱格式错误';
                ys = 'red';
                chkmail(msg,ys,tb);
            }
            function chkmail(msg,ys,tb){
                $("#iemail").attr("class",tb);
                document.getElementById('ebemail').innerHTML = msg;
                document.getElementById('ebemail').style.color = ys;   
            }
        }
      </script>
      <li><input class="btn border_blue back_color" type="button" value="提交"></li>
    </ul>
    </form>
  </div>
</div>
<footer class="footer">
  <div class="bottom">
    <p>
      <a href="#">关于我们</a>
      <span class="dotted"></span>
      <a href="#">人才招聘</a>
      <span class="dotted"></span>
      <a href="#">联系我们</a>
      <span class="dotted"></span>
      <a href="#">商业合作</a>
      <span class="dotted"></span>
      <a href="#">用户反馈</a>
      <span class="dotted"></span>
      <a href="#">用户协议</a>
      <span class="dotted"></span>
      <a href="#">移动客户端</a>
    </p>
    <p class="p2">
      <span>Copyright©&nbsp;2015</span>
      <span>All&nbsp;Rights&nbsp;Reserved</span>
      <span>北京道杰士投资咨询服务有限责任公司</span>
      <span>京ICP证040491号</span>
      <span>版权所有</span>
    </p>
  </div>
</footer>
<script src="/js/jquery-1.11.1.js?v={{Config::get('app.version')}}"></script>
<script>
$(document).ready(function() {
   $(".nav_type a").click(function(){
	  $(".nav_type a").removeClass("click"); 
	  $(this).addClass("click");
	  if($(this).text()=="手机找回"){
		 $(".type_msg .tel").show(); 
		 $(".type_msg .meail").hide(); 
		 $(".type_msg .problem").hide(); 
	  }else if($(this).text()=="邮箱找回"){
		 $(".type_msg .meail").show(); 
		 $(".type_msg .tel").hide(); 
		 $(".type_msg .problem").hide(); 
	  }
	  else if($(this).text()=="问题找回"){
		 $(".type_msg .problem").show(); 
		 $(".type_msg .tel").hide(); 
		 $(".type_msg .meail").hide(); 
	  }
   });	
});
</script>
</body>
</html>
