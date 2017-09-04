<!--<ul class="banner banner_move">
    <li><a href=""><img src="/{{$theme}}/image/s-ban.jpg" alt="" /></a></li>
</ul>-->
<script type="text/javascript" src="/adShowModel.php?position=10&cityId={{CURRENT_CITYID}}"></script>
<div class="status_bg">
<div class="status clearfix">
	<h1 class="fl logo">
        <a href="/" title="搜房网"><img src="image/indexLogo.png" alt="搜房网"></a>
        <span>搜房网</span>
    </h1>
    <ul class="topnav fl">
        <li>
            <a class="a" href="/esfsale/area">二手房</a>
            <div class="nav_select">
                <i></i>
                <ol>
                    <li><a href="/esfsale/area">出售房源</a></li>
                    <li><a href="/saleesb/area">找小区</a></li>
                    <li><a href="/map/sale/house">地图搜房</a></li>
                    <li><a href="/checkpricelist/sale">查房价</a></li>
                    <li><a href="/brokerlist">查询经纪人</a></li>
                    <li><a href="/cal3">房贷计算器</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="/esfrent/area">租房</a>
            <div class="nav_select">
                <i></i>
                <ol>
                    <li><a href="/esfrent/area/ar1">整租房源</a></li>
                    <li><a href="/esfrent/area/ar2">合租房源</a></li>
                    <li><a href="/rentesb/area">找小区</a></li>
                    <li><a href="/map/rent/house">地图搜房</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="/new/area">新房</a>
            <div class="nav_select">
                <p><i></i></p>
                <ol>
                    <li><a href="/new/area">新楼盘</a></li>
                    <li><a href="/new/area/ay1">本月开盘</a></li>
                    <li><a href="/communitymap/new/house">地图搜房</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="/xzlrent/area">写字楼</a>
            <div class="nav_select">
                <p><i class="margin_l"></i></p>
                <ol>
                    <li><a href="/xzlrent/area">写字楼出租</a></li>
                    <li><a href="/xzlsale/area">写字楼出售</a></li>
                    <li><a href="/office/area">写字楼新盘</a></li>
                    <li><a href="/map/rent/office">地图搜房</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="/sprent/area">商铺</a>
            <div class="nav_select">
                <p><i></i></p>
                <ol>
                    <li><a href="/sprent/area">商铺出租</a></li>
                    <li><a href="/spsale/area">商铺出售</a></li>
                    <li><a href="/shops/area">商铺新盘</a></li>
                    <li><a href="/map/rent/shops">地图搜房</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="/bsrent/area">豪宅别墅</a>
            <div class="nav_select">
                <p><i class="margin_l1"></i></p>
                <ol>
                    <li><a href="/bsrent/area">豪宅别墅出租</a></li>
                    <li><a href="/bssale/area">豪宅别墅出售</a></li>
                    <li><a href="/villa/area">豪宅别墅新盘</a></li>
                    <!-- <li><a href="/map/rent/house">地图搜房</a></li>-->
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="https://www.huilc.cn/front/noviceRegister?channel=soFang&amp;usrChannel=15&amp;usrWay=1" target="_blank">理财</a>
            <div class="nav_select">
                <p><i></i></p>
                <ol>
                    <li><a href="https://www.huilc.cn/front/noviceRegister?channel=soFang&amp;usrChannel=15&amp;usrWay=1" target="_blank">我要理财</a></li>
                    <li><a href="http://fang.hlej.com/?chanel=soufang" target="_blank">我要贷款</a></li>
                    <li><a href="https://www.huilc.cn/front/borrow/noviceBorrow?channel=soFang&amp;usrChannel=15&amp;usrWay=1" target="_blank">新人壕礼</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="http://baike.sofang.com/index.php?list-property">百科</a>
            <div class="nav_select">
                <p><i></i></p>
                <ol>
                    <li><a href="http://baike.sofang.com/index.php?list-property">楼盘词典</a></li>
                    <li><a href="http://baike.sofang.com/index.php?list-mingqi">业界名企</a></li>
                    <li><a href="http://baike.sofang.com/index.php?list-words">行业名词</a></li>
                    <li><a href="http://baike.sofang.com/index.php?list-mingren">业界名人</a></li>
                </ol>
            </div>
        </li>
        <li>
            <a class="a" href="/about/download.html">移动APP</a>
        </li>
    </ul>
    @if(!Auth::check())
    <div class="login fr" >
        <a href="/userChoose.html">登录&nbsp;/&nbsp;注册</a>
        <a href="{{config('hostConfig.agr_host')}}" style="margin-left:20px;color:fff;">经纪人登录&nbsp;/&nbsp;注册</a>
    </div>
    @else
    <div class="user fr" >
        <span class="fr out"><a href="/logout">退出</a></span>
        <div class="fr">
            <span style="display: block;">{{ (Auth::user()->userName == '') ? substr_replace(Auth::user()->mobile, '****', 3, 4) : Auth::user()->userName }}</span>
            <ul style="display:none;">
                <li><a href="/userEntrust/Qz">委托房源</a></li>
                <li><a href="/user/personalHouse">个人房源</a></li>
                <li><a href="/myinfo/infoUpdate">编辑资料</a></li>
            </ul>
        </div>
    </div>
        <script>
            $(document).ready(function(e) {
                $(".user .fr,.user ul").hover(function(){
                    $(this).css("cursor","pointer");
                    $(this).addClass("click");
                    $(this).find('ul').show();
                },function(){
                    $(this).removeClass("click");
                    $(this).find('ul').hide();
                });
            });
        </script>
    @endif
</div>
</div>