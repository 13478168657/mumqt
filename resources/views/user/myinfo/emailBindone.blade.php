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
                <p><img src="/image/bind_bottom.png" alt=""></p>
                <p class="p">
                    <span class="color_blue"><span class="fontA">1、</span>验证身份</span>
                    <span class="margin_l"><span class="fontA">2、</span>输入邮箱</span>
                    <span class="margin_l"><span class="fontA">3、</span>完成绑定</span>
                </p>
                <ul class="proving">
                    <li style="height: 80px; margin-bottom:0;">
                        <label>手机号</label>
                        <input type="text" id="emailBindPhone" class="txt">
                        <input type="hidden" id="vcode" value="{{csrf_token()}}">
                        <span class="ema" id="res_emailBindPhone" style="color:red; margin-left:85px;"></span>
                        <div class="clear"></div>
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
                        <input type="text" id="emailBindVcode" class="txt width">
                        <input type="button" class="hq" id="emailBindSendCode" value="获取验证码">
                        <span class="ema" id="res_emailBindVcode" style="margin-left:85px;color:red;"></span>
                        <div class="clear"></div>
                    </li>
                    <li style="height:auto;">
                        <input type="button" id="emailBind1sub" style="cursor:pointer;" disabled="true" value="下一步" class="btn">
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('user.myinfo.footer')
@endsection
