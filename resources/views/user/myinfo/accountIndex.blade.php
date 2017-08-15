@extends('mainlayout')
@section('title')
    <title>个人后台</title>
    <meta name="keywords" content="北京搜房网，新房，二手房，租房，写字楼，商铺，金融，房产名人，房产名企，房产名词"/>
    <meta name="description" content="搜房网—中国房地产综合信息门户和交易平台，提供二手房、租房、别墅、写字楼、商铺等交易信息，为客户提供全面的搜房体验和多种比较、为业主和经纪人提供高效的信息推广渠道。为客户提供房产百科全书，包括房产名人，名词，名企，楼盘"/>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/personalHoutai.css?v={{Config::get('app.version')}}">
    @include('user.myinfo.header')
@endsection
@section('content')
<div class="user">
@include('user.myinfo.leftNav')
    <div class="user_r">
    <h2 class="edit">安全评分</h2>
    <div class="user_safe">
      <dl class="jd">
        <input type="hidden" id="score" value="{{$score}}">
        <dt><span id="scoreColor"></span></dt>
        <dd id="scoreNum">80%</dd>
      </dl>
      <div class="install_nav">
        <dl>
          <dt>
            <a class="modaltrigger phone" onclick="clearEditMobileInfo();" href="#change_pwd"></a>
          </dt>
          <dd class="color_blue">已绑定手机号</dd>
          <dd class="color_blue">您绑定的手机号为：{{$info->mobile}}</dd>
          
          <!-- <dt></dt>
          <dd class="color_blue">
            <a class="modaltrigger phone" href="#change_pwd">
              <font class="blue">已绑定手机号</font>
            </a>
          </dd> -->
        </dl>
        <dl>
          <dt>
            @if(!empty($secu))
            <a class="problem_click" href="/myinfo/problem1"></a>
            @else
            <a class="problem" href="/myinfo/problem1"></a>
            @endif
          </dt>
          <dd class="color_blue">设置密保问题</dd>
        </dl>
        <dl>
          <dt>
            @if(!empty($info->email))
            <a class="email_click" href="/myinfo/bindemailphone"></a>
            @else
            <a class="email" href="/myinfo/bindemailphone"></a>
            @endif
          </dt>
          @if(!empty($info->email))
           <dd class="color_blue">您绑定的邮箱为：{{$info->email}}</dd>
          @else
          <dd>绑定密保邮箱</dd>
          @endif
        </dl>
      </div>
    </div>
    <h2 class="edit" style="margin-top:60px;">历史登录</h2>
    <div class="login_history">
      <p class="title">以下为你最近1次登录，若存在异常情况，请在核实后尽快<a href="/myinfo/passwdUpdate" class="color_blue">修改密码</a></p>
      <ul class="login_msg" id="log_Show">
        <li>
          <span class="width1">时间</span>
          <span class="width2">地点</span>
          <span class="width3">IP</span>
          <span class="width4">浏览器</span>
          <span class="width5">登录方式</span>
          <span class="width6">设备</span>
        </li>
        @if(!empty($login))
        @foreach($login as $log)
        <li>
          <span class="width1">{{$log->loginTime}}</span>
          <span class="width2">{{\App\Http\Controllers\Utils\RedisCacheUtil::getCityNameById($log->cityId)}}</span>
          <span class="width3">{{$log->ip}}</span>
          <span class="width4">{{$log->browser}}</span>
          <span class="width5">{{$login_Mode[$log->loginMode]}}</span>
          <span class="width6">{{$log->system}}</span>
        </li>
        @endforeach
        @else
        <li><a>暂无数据</a></li>
        @endif
      </ul>
      <ul class="login_msg">
        <li><a id="loadMore">加载更多<i></i></a></li>
      </ul>
    </div>
  </div>
</div>
<div class="change_tel" id="change_pwd">
  <span class="close" onClick="$(this).parent().hide();$('#lean_overlay').hide();"></span>
  <h2>更换密保手机号</h2>
  <div class="change1">
    <p class="p1">为了保证你的账户安全，更换密保手机号前请先进行安全验证</p>
    <p class="p2">
      你当前手机号是：<span class="fontA">{{$info->mobile}}</span>
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
      <span class="clear"></span>
      <span id="edit_mobile2_error" style="position:relative;top:-9px;left:49px;color:red;font-size:10px;height:10px;"></span>
    </p>
    <p class="p_code" style="overflow:visible;">
      <label>验证码</label>
      <input type="text" id="verify_code" class="tel_txt code_txt">
      <input type="button" class="code_btn back_color" id="send_verify" value="获取验证码">
      <span class="clear"></span>
      <span id="edit_mobile3_error" style="position:relative;top:-3px;left:-140px;color:red;height:10px;"></span>
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
<script>
  var requestNum = 1;
  var token = $('#vcode').val();
    $('#loadMore').click(function(){
        if(requestNum == 0){
           return false;
        }
        $.post('/myinfo/loginhistory', {_token:token, num:requestNum}, function(r){
            console.log(r);
            if(r == 0){
                requestNum = 0;
                $('#loadMore').text('没有更多数据');
                return false;
            }else{
                requestNum ++;
                var logList = '';
                for(var i in r){
                    logList += '<li>';
                    logList += '<span class="width1">'+ r[i].loginTime +'</span>\
                                <span class="width2">'+ r[i].cityId +'</span>\
                                <span class="width3">'+ r[i].ip +'</span>\
                                <span class="width4">'+ r[i].browser +'</span>\
                                <span class="width5">'+ r[i].loginMode +'</span>\
                                <span class="width6">'+ r[i].system +'</span>';
                    logList += '</li>';
                }
                $('#log_Show').append(logList);
            }
        });
    });
</script>
@include('user.myinfo.footer')
@endsection