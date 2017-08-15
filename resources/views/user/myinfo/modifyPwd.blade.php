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
            <span class="click">修改密码</span>
            <a href="/myinfo/bindemailphone">邮箱验证</a>
            <a href="/myinfo/problem1">安全问题</a>
        </p>
            <h2 class="edit">修改密码</h2>
            <p class="colorfe xg" id="editPwd" style="display:none;"></p>
            <div class="change_pwd">
                <p>
                    <label>原密码</label>
                    <input type="password" name="oldpass" id="pwd1" class="txt"/>
                </p>
                <p>
                    <label>新密码</label>
                    <input type="password" name="newpass" id="pwd2" maxlength="16" class="txt"/>
                </p>
                <p>
                    <label>确认密码</label>
                    <input type="password" name="confirm" id="pwd3" maxlength="16" class="txt"/>
                </p>
                <input type="hidden" id="vcode" value="{{csrf_token()}}">
                <input type="button" id="sub_password" class="btn back_color" value="确定"/>
            </div>
        </div>
        </div>
        @include('user.myinfo.footer')
 @endsection