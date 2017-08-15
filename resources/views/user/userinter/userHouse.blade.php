@extends('mainlayout')
@section('title')
    <title>个人后台</title>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/personalManage.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
    <div class="user">
        @include('user.userHomeLeft')

        @if($sale <= 0 && $rent <= 0)
            <div class="user_r">
                <p class="enter_house">
                    <a href="/houseHelp/rent/xq">出租</a>
                    <a href="/houseHelp/sale/xq">出售</a>
                </p>
                <div class="no_data">
                    <div class="no_icon"></div>
                    <div class="no_info">
                        <p class="p1"><span>亲</span>，您暂无发布任何房源！</p>
                        <p>去<a href="/houseHelp/sale/xq">发布房源</a></p>
                    </div>
                </div>
            </div>
        @elseif($sale > 0)
            {{--@include('user.userinter.userHouseSale')--}}
            @if($type == 'sale')
                @include('user.userinter.userHouseSale')
            @else
                @include('user.userinter.userHouseRent')
            @endif
        @elseif($rent > 0)
            @if($type == 'rent')
                @include('user.userinter.userHouseRent')
            @else
                @include('user.userinter.userHouseSale')
            @endif
        @endif
    </div>
    <div class="claim" id="quxiao" style="z-index: 999; position: fixed; top:32%; left: 58%;">
        <span class="close" onclick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
        <dl>
            <dt><i class="tan"></i>您确定取消委托吗</dt>
            <dd><input type="button" onclick="ajaxPost()" class="btn" value="确定"><input onclick="$('#quxiao').hide();$('#lean_overlay').hide();" type="button" class="btn" value="取消"></dd>
        </dl>
    </div>
    <script src="/js/specially/headNav.js?v={{Config::get('app.version')}}"></script>
    <script>
        $(document).ready(function(e) {
            $(".data_msg .look").click(function(){
                if($(this).parents("dl").next().css("display")=="none"){
                    $(".data_msg .change").hide();
                    $(this).parents("dl").next().show();
                }else{
                    $(".data_msg .change").hide();
                }
            });

            //弹出层调用语句
            $('.modaltrigger').leanModal({
                top:110,
                overlay:0.45,
                closeButton:".hidemodal"
            });
        });

        var token = "{{csrf_token()}}";
        var hId1,type1,url;
        // 发布
        function fabuState(hId,type){
            $('#quxiao').find('dt').html('<i class="tan"></i>您确定发布该房源吗');
            $('#quxiao').show();
            $('#lean_overlay').show();
            hId1 = hId;
            type1 = type;
            url = '/user/personalHouse/fabu';
        }

        // 取消发布
        function cncelState(hId,type){
            $('#quxiao').find('dt').html('<i class="tan"></i>您确定取消发布吗');
            $('#quxiao').show();
            $('#lean_overlay').show();
            hId1 = hId;
            type1 = type;
            url = '/user/personalHouse/cancel';
        }
        // 删除
        function delHouse(hId,type){
            $('#quxiao').find('dt').html('<i class="tan"></i>你确定删除该房源吗');
            $('#quxiao').show();
            $('#lean_overlay').show();
            hId1 = hId;
            type1 = type;
            url = '/user/personalHouse/del';
        }

        // 点击确定
        function ajaxPost(){
            $('#quxiao').hide();
            $('#lean_overlay').hide();
            $.ajax({
                type : 'POST',
                url : url,
                data : {
                    _token : token,
                    id : hId1,
                    hType : type1
                },
                dataType : 'json',
                success : function(msg){
                    if(msg.res == 'success'){
                        alert(msg.data);
                        location.reload(true);
                    }
                    if(msg.res == 'fail' || msg.res == 'error' || msg.res == 'total'){
                        alert(msg.data);
                    }
                }
            });
        }

        // 图片加载不出来时  使用默认图片
        function errorImage(obj){
            obj.src = '/image/noImage.png';
        }
    </script>
@endsection
