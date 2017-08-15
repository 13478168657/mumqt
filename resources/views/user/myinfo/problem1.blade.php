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
                <a href="/myinfo/bindemailphone">邮箱验证</a>
                <span class="click">安全问题</span>
            </p>
            <div class="change_msg" style="width:640px;">
                <p><img src="/image/proplem.png" alt=""></p>
                <p class="p">
                    <span class="color_blue"><span class="fontA">1、</span>安全认证</span>
                    <span class="margin_left"><span class="fontA">2、</span>填写问题</span>
                    <span class="margin_left"><span class="fontA">3、</span>验证问题</span>
                    <span class="margin_left"><span class="fontA">4、</span>完成</span>
                </p>
                <ul class="proving">
                    <li>
                        <label>手机号</label>
                        <input type="text" id="problemPhone" class="txt">
                        <input type="hidden" id="vcode" value="{{csrf_token()}}">
                        <span id="res_problemPhone" class="pro"></span>
                        <div class="cleaer"></div>
                    </li>
                    <li style="display: none;">
                        <label>&nbsp;</label>
                        <input type="text" id="img_code_val" class="txt width" autocomplete="off">
                        <img src="/vercode" alt="验证码" class="hq" id="img_code" onclick="this.src='/vercode?code='+Math.random();" style="height:30px;float:left;margin-top:4px;">
                        <span class="pro"></span>
                        <div class="cleaer"></div>
                    </li>
                    <li>
                        <label>验证码</label>
                        <input type="text" id="problemPhoneVerCode" class="txt width">
                        <input type="button" class="hq" id="problemPhoneVerCodeSend" value="获取验证码">
                        <span id="res_problemPhoneVerCode" class="pro"></span>
                        <div class="cleaer"></div>
                    </li>
                    <li style="height:auto;">
                        <input type="button" id="problemPhoneNext" style="cursor:pointer;" disabled="true" value="下一步" class="btn">
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('user.myinfo.footer')
@endsection