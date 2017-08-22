
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
        <p class="subnav">
            {{--<a href="/myinfo/modifyMobile">修改手机号</a>--}}
            <a href="/myinfo/passwdUpdate">修改密码</a>
            <span class="click">邮箱验证</span>
            <a href="/myinfo/problem1">安全问题</a>
        </p>
            @if(empty($info->email))
                <h2 class="edit">绑定邮箱</h2>
            @else
                <h2 class="edit">修改邮箱</h2>
            @endif
            <div class="change_msg">
                <p><img src="/image/bind_bottom1.png" alt=""></p>
                <p class="p">
                    <span class="color_blue"><span class="fontA">1、</span>验证身份</span>
                    <span class="margin_l color_blue"><span class="fontA">2、</span>输入邮箱</span>
                    <span class="margin_l"><span class="fontA">3、</span>完成绑定</span>
                </p>
                <ul class="proving">
                    <li style="height: 80px; margin-bottom:0;">
                        <label>我的邮箱</label>
                        <input type="text" id="emailinfo" value="" class="txt">
                        <dl class="emaill_list">
                        </dl>
                        <span class="ema" id="res_emailerror" style="color:red; margin-left:85px;"></span>
                        <div class="clear"></div>
                    </li>
                    <li id="res_emailerror"></li>
                    <li>
                        <label>验证码</label>
                        <input type="text" id="vercodeinfo" value=""  class="txt width">
                        <input type="button" class="hq" id="getverCode" value="获取验证码">
                        <span class="ema" id="res_vercodeerror" style="margin-left:85px;color:red;"></span>
                        <div class="clear"></div>
                    </li>
                    <li style="height:auto;">
                        <input type="hidden" id="vcode" value="{{csrf_token()}}">
                        <input type="button" id="emailsendsub" value="验证邮箱" class="btn send" disabled>
                    </li>
                </ul>
                <ul class="finish" style="display:none;">
                    <li class="li1">已发送验证邮件至: <span class="fontA" id="emailshow"></span></li>
                    <li class="li2">(请立即完成验证，邮箱验证不通过则绑定失败）</li>
                    <li class="li3">验证邮件60分钟内有效，请尽快登录你的邮箱点击验证链接完成验证。</li>
                    <li class="li4"><a id="emailconnection" target="_blank" href="#"><input type="button" class="btn" value="查看验证邮件"></a></li>
                </ul>
            </div>
        </div>
    </div>
@include('user.myinfo.footer')
@endsection

