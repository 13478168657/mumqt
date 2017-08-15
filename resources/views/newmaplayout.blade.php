<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>【{{CURRENT_CITYNAME}}地图找房，{{CURRENT_CITYNAME}}楼盘地图，{{CURRENT_CITYNAME}}新盘地图】-搜房网</title>
    <meta name="keywords" content="地图找房，{{CURRENT_CITYNAME}}地图找房"/>
    <meta name="description" content="搜房网-为您提供地图搜索，包括新盘、小区、房源，为您提供楼盘新的价格与房源情况和楼盘定位，快速的查找对应房源，给您更好的地图找房体验！"/>
    <link rel="icon" href="http://www.sofang.com/favicon.ico" mce_href="http://www.sofang.com/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/css/map.css">
    <link rel="stylesheet" type="text/css" href="/css/color.css">
    <link rel="stylesheet" type="text/css" href="/css/personalLogin.css">
    <script type="text/javascript" src="/js/jquery1.11.3.min.js"></script>
</head>

<body>
<div class="main">

    @include('layout.map.newheader')
    @yield('content')
</div>
@include('layout.map.newfooter')
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?d2801fc638056c1aac7e8008f41cf828";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<script>
(function(){
    var bp = document.createElement('script');
    bp.src = '//push.zhanzhang.baidu.com/push.js';
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
<script>
    $(document).ready(function(e) {
        $(this).keydown(function (e){
            if(e.which == "13"){
                $("#login").click();
            }
        })
    });
    $('#lproname').val('');
    $('#lpropwd').val('');
</script>
<script>
    $(document).ready(function(e) {
        $(".telLogin").click(function(){
            $(".userLogin").hide();
            $(".userLogin1").show();
        });
        $(".accountLogin").click(function(){
            $(".userLogin1").hide();
            $(".userLogin").show();
        });

        $('.modaltrigger').leanModal({
            top:100,
            overlay:0.45
        });
    })
</script>
</body>
</html>