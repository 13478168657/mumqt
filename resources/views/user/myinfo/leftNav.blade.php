<div class="user_l">
  <div id="msg_top">
	<dl class="user_img" id="user_photo">
  @if(!empty($info->photo))
  <dt><a href="/myinfo/infoUpdate"><img src="{{config('imgConfig.imgSavePath')}}{{$info->photo}}" alt=""></a></dt>
  @else
  <dt><a href="/myinfo/infoUpdate"><img src="/image/default.png" alt=""></a></dt>
  @endif
  @if(Auth::user()->userName == '')
  <dd>您还没有设置用户名和密码</dd>
  <dd><a href="{{url('/myinfo/userSet')}}">去设置&nbsp;</a></dd>
  @else
  <dd><a href="/myinfo/infoUpdate">欢迎您&nbsp;<span class="font_size" id="userMobile2" >{{Auth::user()->userName}}</span></a></dd>
  @endif
	</dl>
	<ul class="user_nav">
		<li>
			<a href="{{url('/user/home')}}" class=" @if(isset($userIndex)) click @endif">个人中心</a></li>
		<li>
			<a class="clickStop @if(isset($houseZz) || isset($newComm)) click @endif">我的关注<i></i></a>
			<dl class="sub_nav">
                <dd><a href="{{url('/user/interHouse')}}" class="@if(isset($houseZz)) color_blue @endif">关注的房源</a></dd>
				<dd><a href="{{url('/user/interCommunity')}}" class="@if(isset($newComm)) color_blue @endif">关注的楼盘</a></dd>
			</dl>
		</li>
		<li>
			<a class="clickStop @if(isset($passwdShow) || isset($emailShow) || isset($index) || isset($problem) || isset($infoShow)) click @endif">账户设置<i></i></a>
			<dl class="sub_nav" >
		        <dd><a href="/myinfo/home" class=" @if(isset($index) || isset($problem) || isset($emailShow) ) color_blue @endif">账户首页</a></dd>
		        <dd><a href="/myinfo/infoUpdate" class=" @if(isset($infoShow)) color_blue @endif">编辑资料</a></dd>
		        <dd><a href="/myinfo/passwdUpdate" class=" @if(isset($passwdShow)) color_blue @endif">修改密码</a></dd>
	        </dl>
		</li>
	</ul>
  </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}" id="vcode">
