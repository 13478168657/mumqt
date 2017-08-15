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
            <!--<span class="click">修改手机号</span>-->
            <a href="/myinfo/passwdUpdate">修改密码</a>
            <a href="/myinfo/bindemailphone">邮箱验证</a>
            <a href="/myinfo/problem1">安全问题</a>
        </p>
        <div class="change_msg">
            <ul class="proving">
                <li>
                    <label>新手机号</label>
                    <input type="text" id="edit_mobile2" class="txt">
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
                    <input type="button" class="hq" id="problemPhoneVerCodeSendNew" value="获取验证码">
                    <span id="edit_mobile3_error" class="pro"></span>
                    <div class="cleaer"></div>
                </li>
                <li style="height:auto;">
                    <input type="button" value="提交" class="btn" id="testing_vcode">
                </li>
            </ul>
        </div>
    </div>
</div>
@include('user.myinfo.footer')
<script src="/js/jquery1.11.3.min.js"></script>
<script src="/js/specially/headNav.js"></script>

@endsection
