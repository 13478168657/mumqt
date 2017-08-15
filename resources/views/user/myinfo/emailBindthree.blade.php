
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
                    <p><img src="/image/bind_bottom2.png" alt=""></p>
                    <p class="p">
                        <span class="color_blue"><span class="fontA">1、</span>验证身份</span>
                        <span class="margin_l color_blue"><span class="fontA">2、</span>输入邮箱</span>
                        <span class="margin_l"><span class="fontA">3、</span>完成绑定</span>
                    </p>
                    <p class="success"><i></i>操作成功,<span class="fontA colorfe">{{$email}}</span>可作为你的账户名</p>
                </div>
            </div>
        </div>
    @include('user.myinfo.footer')
@endsection
