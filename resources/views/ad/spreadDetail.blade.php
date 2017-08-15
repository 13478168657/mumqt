@extends('mainlayout')
@section('title')
    <title>推广详情页面</title>
@endsection
@section('content')
    <style>
        .main{ width:100%; min-width:1200px; height:auto; overflow:hidden; position:relative;}
        .main .spread_top{ width:100%; height:650px; background:url(/image/spreadDetail.jpg) no-repeat center top;}
        .spread_top p{ width:1200px; margin:0 auto; height:auto; overflow:hidden;}
        .spread_top p a{ float:left; margin:488px 0 0; width:153px; height:43px; line-height:43px; border:1px solid #3c3c3c; color:#3c3c3c; text-align:center; font-size:26px; border-radius:30px;}
        .spread_top p a:hover{ text-decoration:none; color:#fff; border-color:#ff7509; background-color:#ff7509;}
        .spread_top p .margin_l{ margin-left:20px;}
        .main .spread_nav{ width:1200px; margin:0 auto; height:auto; overflow:hidden;}
        .spread_nav dl{ float:left; width:132px; text-align:center; margin:40px 0 55px 185px;}
        .spread_nav dl dt,.spread_nav dl dt img{ width:132px; height:145px;}
        .spread_nav dl dd{ font-size:20px; color:#3c3c3c; margin-top:15px;}
        .spread_nav .margin_l{ margin-left:64px;}
        .main .spread_info{ width:100%; background-color:#f1f1f1; height:auto; overflow:hidden;}
        .spread_info h2{ width:1200px; margin:109px auto 76px; font-size:36px; color:#3c3c3c;}
        .spread_info .msg{ display:block; width:1200px; height:auto; margin:0 auto 128px; overflow:hidden;}
        .spread_info .msg li{ width:600px; float:left; background-color:#fff; height:318px; overflow:hidden;}
        .msg li i{ width:301px; height:318px;}
        .msg .words{ float:left; width:299px;}
        .msg .words .p1{ width:100%; text-align:center; font-size:30px; color:#3c3c3c; margin-top:95px;}
        .msg .words .p2{ padding:0 25px; font-size:20px; color:#3c3c3c; margin-top:20px;}
        .msg .words  .txt_c{ text-align:center;}
        .msg .backColor1 i{ float:left; background:url(/image/backColor1.png) no-repeat -1px top;}
        .msg .backColor2 i{ float:left; background:url(/image/backColor2.png) no-repeat -1px top;}
        .msg .backColor3 i{ float:right; background:url(/image/backColor3.png) no-repeat 1px;}
        .msg .backColor4 i{ float:right; background:url(/image/backColor4.png) no-repeat 1px;}

        .msg .backColor1:hover{ background-color:#57aeff; }
        .msg .backColor2:hover{ background-color:#8dcd5f;}
        .msg .backColor3:hover{ background-color:#fe5e60;}
        .msg .backColor4:hover{ background-color:#ffc30d;}
        .msg li:hover .p1,.msg li:hover .p2{color:#fff;}

        .main .spread_foot{ width:100%; height:342px; margin-top:70px; background:url(/image/spreadDetail1.png) no-repeat center top; overflow:hidden;}
        .spread_foot .p1{ width:100%; margin-top:75px;}
        .spread_foot .p1 a{ display:block; width:153px; height:43px; line-height:43px; border:1px solid #3c3c3c; color:#3c3c3c; text-align:center; font-size:26px; border-radius:30px; margin:0 auto;}
        .spread_foot .p1 a:hover{ text-decoration:none; color:#fff; border-color:#ff7509; background-color:#ff7509;}
        .spread_foot .p2{ width:100%; margin-top:20px; text-align:center;}
        .spread_foot .p2 a{ font-size:20px; color:#3c3c3c;}
        .spread_foot .p2 a:hover{ color:#0074e0;}

        .main .float_ad{ position:fixed; bottom:40px; right:50px; width:252px; height:156px;}
        .float_ad i{ display:inline-block; position:absolute; top:0; right:20px; background:url(/image/icon.png) -159px 0; width:26px; height:26px; cursor:pointer;}
    </style>
<div class="main">
    <div class="spread_top">
        <p>
            <a href="{{config('hostConfig.agr_host')}}/majorRegister/esf">立即注册</a>
            <a class="margin_l" href="{{config('hostConfig.agr_host')}}">立即登录</a>
        </p>
    </div>
    <div class="spread_nav">
        <dl class="margin_l">
            <dt><img src="/image/mh.png" alt="房地产门户"></dt>
            <dd>房地产门户</dd>
        </dl>
        <dl>
            <dt><img src="/image/16year.png" alt="搜房网16年"></dt>
            <dd>搜房网16年</dd>
        </dl>
        <dl>
            <dt><img src="/image/fwh.png" alt="优质服务"></dt>
            <dd>优质服务</dd>
        </dl>
        <dl>
            <dt><img src="/image/yhd.png" alt="千万用户"></dt>
            <dd>千万用户</dd>
        </dl>
    </div>
    <div class="spread_info">
        <h2>4大营销利器保驾护航</h2>
        <ul class="msg">
            <li class="backColor1">
                <i></i>
                <div class="words">
                    <p class="p1">付费会员，尊享特权</p>
                    <p class="p2">预约刷新，更多刷新条数，上半区优先显示</p>
                </div>
            </li>
            <li class="backColor2">
                <i></i>
                <div class="words">
                    <p class="p1">房源置顶</p>
                    <p class="p2">好房源推广不用愁，房源置顶上户无忧更明显的标识，黄金位置</p>
                </div>
            </li>
            <li class="backColor3">
                <i></i>
                <div class="words">
                    <p class="p1">房源定投</p>
                    <p class="p2 txt_c">房源推广如此简单</p>
                </div>
            </li>
            <li class="backColor4">
                <i></i>
                <div class="words">
                    <p class="p1">置业专家</p>
                    <p class="p2 txt_c">值得信赖的置业伙伴</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="spread_foot">
        <p class="p1"><a href="{{config('hostConfig.agr_host')}}/majorRegister/esf">立即注册</a></p>
        <p class="p2"><a href="{{config('hostConfig.agr_host')}}">已有账号？立即登录</a></p>
    </div>
    <p class="float_ad"><i id="close"></i><a href="{{config('hostConfig.agr_host')}}"><img src="/image/cz.png" alt="充值"></a></p>
</div>
<script src="/js/specially/headNav.js"></script>
<script>
    $(document).ready(function(e) {
        $("#close").click(function(){
            $(this).parent().hide();
        });
    });
</script>
@endsection
