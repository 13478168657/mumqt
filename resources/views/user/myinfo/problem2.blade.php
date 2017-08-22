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
            <p><img src="../image/proplem1.png"></p>
            <p class="p">
                <span class="color_blue"><span class="fontA">1、</span>安全认证</span>
                <span class="margin_left color_blue"><span class="fontA">2、</span>填写问题</span>
                <span class="margin_left"><span class="fontA">3、</span>验证问题</span>
                <span class="margin_left"><span class="fontA">4、</span>完成</span>
            </p>
            <ul class="problem">
                <li>
                    <label>问题一</label>
                    <div class="problem_msg">
                        <a class="brith"><span class="fontA" id="problemOne" value="0">请选择问题</span><i></i></a>
                        <div class="type" style="display:none;">
                            <p class="top_icon"></p>
                            <ul style=" left:0;">
                                @if(isset($question))
                                    @foreach($question as $qval)
                                        <li class="problemOnelist" id="pro1id" value="{{$qval->id}}">{{$qval->question}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <label>答案</label>
                    <input type="text" id="answerOne" value="" class="txt">
                    <div class="clear"></div>
                    <span class="pro2" id="res_answerOne"></span>
                </li>
                <li>
                    <label>问题二</label>
                    <div class="problem_msg">
                        <a class="brith"><span class="fontA" id="problemTwo"  value="0">请选择问题</span><i></i></a>
                        <div class="type" style="display:none;">
                            <p class="top_icon"></p>
                            <ul style=" left:0;">
                                @if(isset($question))
                                    @foreach($question as $qval)
                                        <li class="problemTwolist" id="pro2id" value="{{$qval->id}}">{{$qval->question}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <label>答案</label>
                    <input type="text" id="answerTwo" value="" class="txt">
                    <div class="clear"></div>
                    <span class="pro2" id="res_answerTwo"></span>
                </li>
                <li>
                    <label>问题三</label>
                    <div class="problem_msg">
                        <a class="brith"><span class="fontA" id="problemThree"  value="">请选择问题</span><i></i></a>
                        <div class="type" style="display:none;">
                            <p class="top_icon"></p>
                            <ul style=" left:0;">
                                @if(isset($question))
                                    @foreach($question as $qval)
                                        <li class="problemThreelist"  id="pro3id" value="{{$qval->id}}">{{$qval->question}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <label>答案</label>
                    <input type="text" id="answerThree" value="" class="txt">
                    <div class="clear"></div>
                    <span class="pro2" id="res_answerThree"></span>
                </li>
                <p id="res_repeat" class="colorfe xg" style="display:none;"></p>
                <li>
                    <input type="hidden" id="vcode" value="{{csrf_token()}}">
                    <input type="button" class="btn" style="cursor:pointer;" id="answerSubmit" value="提交">
                </li>
            </ul>
        </div>
    </div>
    </div>
    @include('user.myinfo.footer')
<script src="/js/jquery1.11.3.min.js"></script>
<script src="/js/specially/headNav.js"></script>

    @endsection
