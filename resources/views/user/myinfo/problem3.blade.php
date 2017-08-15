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
            <p><img src="../image/proplem2.png"></p>
            <p class="p">
                <span class="color_blue"><span class="fontA">1、</span>安全认证</span>
                <span class="margin_left color_blue"><span class="fontA">2、</span>填写问题</span>
                <span class="margin_left color_blue"><span class="fontA">3、</span>验证问题</span>
                <span class="margin_left"><span class="fontA">4、</span>完成</span>
            </p>
            <ul class="problem">
                <li>
                    <label>问题一</label>
                    <span>{{$suce['pro'.$r[0]]['name']}}</span>
                </li>
                <li>
                    <label>答案</label>
                    <input type="hidden" id="pro{{$r[0]}}Id" name="pro{{$r[0]}}Id" value="{{$suce['pro'.$r[0]]['question']}}">
                    <input type="text" id="pro{{$r[0]}}answer" name="pro{{$r[0]}}answer" value="" class="txt">
                    <div class="clear"></div>
                    <span class="pro2" id="res_pro{{$r[0]}}answer"></span>
                </li>

                <li>
                    <label>问题二</label>
                    <span>{{$suce['pro'.$r[1]]['name']}}</span>
                </li>
                <li>
                    <label>答案</label>
                    <input type="hidden" id="pro{{$r[1]}}Id" name="pro{{$r[1]}}Id" value="{{$suce['pro'.$r[1]]['question']}}">
                    <input type="text" id="pro{{$r[1]}}answer" name="pro{{$r[1]}}answer" value="" class="txt">
                    <div class="clear"></div>
                    <span class="pro2" id="res_pro{{$r[1]}}answer"></span>
                </li>
                <li>
                    <label>问题三</label>
                    <span>{{$suce['pro'.$r[2]]['name']}}</span>
                </li>
                <li>
                    <label>答案</label>
                    <input type="hidden" id="pro{{$r[2]}}Id" name="pro{{$r[2]}}Id" value="{{$suce['pro'.$r[2]]['question']}}">
                    <input type="text" id="pro{{$r[2]}}answer" name="pro{{$r[2]}}answer" value="" class="txt">
                    <div class="clear"></div>
                    <span class="pro2" id="res_pro{{$r[2]}}answer"></span>
                <li>
                    <input type="hidden" id="vcode" value="{{csrf_token()}}">
                    <input type="button" id="problemSave" style="cursor:pointer;" class="btn blue" value="提交">
                </li>
            </ul>
        </div>
        </div>
    </div>
    @include('user.myinfo.footer')
    <script src="/js/jquery1.11.3.min.js"></script>
    <script src="/js/specially/headNav.js"></script>

@endsection

