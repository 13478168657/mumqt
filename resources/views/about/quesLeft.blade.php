
<div class="about_l">
    <ul>
      <li class="click">常用问题分类</li>
      <li>
        <a class="a @if(in_array($click,[1,2,3,4,5]))onclick @endif" >用户手册<i></i></a>
        <dl @if(in_array($click,[1,2,3,4,5]))style="display:block;"@endif>
          <dd><a href="/questionHelp/usehelp.html" @if($click == 1) class="check" @endif>注册与登录</a></dd>
          <dd><a href="/questionHelp/userPerm.html" @if($click == 2) class="check" @endif>注册用户权限</a></dd>
          <dd><a href="/questionHelp/userEsHouse.html" @if($click == 3) class="check" @endif>查找二手房源</a></dd>
          <dd><a href="/questionHelp/userEstate.html" @if($click == 4) class="check" @endif>通过小区查找二手房源</a></dd>
          <dd><a href="/questionHelp/userTool.html" @if($click == 5) class="check" @endif>如何使用购房工具</a></dd>
        </dl> 
      </li>
      <li>
        <a class="a @if(in_array($click,[6,7]))onclick @endif">经纪人手册<i></i></a>
        <dl @if(in_array($click,[6,7]))style="display:block;"@endif>
          <dd><a href="/questionHelp/brokerManual.html" @if($click == 6) class="check" @endif>注册与登录</a></dd>
          <dd><a href="/questionHelp/houseRelease.html" @if($click == 7) class="check" @endif>房源发布相关</a></dd>
        </dl> 
      </li>
    </ul>
  </div>
   <script>
$(document).ready(function(e) {	
	$(".about_l li .a").click(function(){
	   $(".about_l li .a").removeClass("onclick");
	   $(".about_l li dl").css("display","none");
	   $(this).addClass("onclick");
	   $(this).parent().find("dl").show();;	
    });

});
</script> 