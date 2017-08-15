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
            <p><img src="../image/proplem3.png"></p>
            <p class="p">
                <span class="color_blue"><span class="fontA">1、</span>安全认证</span>
                <span class="margin_left color_blue"><span class="fontA">2、</span>填写问题</span>
                <span class="margin_left color_blue"><span class="fontA">3、</span>验证问题</span>
                <span class="margin_left color_blue"><span class="fontA">4、</span>完成</span>
            </p>
            <p class="success"><i></i>修改密保问题成功,请牢记你的密保问题！</p>
        </div>
    </div>
</div>
@include('user.myinfo.footer')
<script src="/js/jquery1.11.3.min.js"></script>
<script src="/js/specially/headNav.js"></script>

@endsection
