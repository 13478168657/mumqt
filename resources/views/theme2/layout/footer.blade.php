<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/8
 * Time: 18:09
 */


/**
 * 公共 页脚 公共的页脚  嵌入View下的MainLayout文件中
 */
?>


<div class="footer" id="footer">
    <div class="bottom">
        <p>
            <a href="/about/aboutus.html">关于我们</a>
            <!--<span class="dotted"></span>
            <a href="#">网站合作</a>-->
            <span class="dotted"></span>
            <a href="/about/contactus.html">联系我们</a>
            <span class="dotted"></span>
            <a href="/about/disclaimer.html">免责声明</a>
            <span class="dotted"></span>
            <a href="/about/recruit.html">招聘信息</a>
            <span class="dotted"></span>
            <a href="/about/secret.html">隐私协议</a>
            <span class="dotted"></span>
            <a href="/questionHelp/usehelp.html">使用帮助</a>
            <span class="dotted"></span>
            <a href="/ad/cooperation">加盟合作</a>
            <!--<span class="dotted"></span>
            <a href="#">Android客户端</a>-->
            <!-- <span class="dotted"></span>
            <a href="#">服务声明</a> -->
            <!--<span class="dotted"></span>
            <a href="#">安全联盟</a>
            <span class="dotted"></span>
            <a href="#">加盟搜房网</a>-->
        </p>
        <p class="p2">
            <span>Copyright&nbsp;©&nbsp;2016</span>
            <span>Sofang.com,&nbsp;All&nbsp;Rights&nbsp;Reserved</span>
            <span>北京道杰士投资咨询服务有限责任公司</span>
            <span>版权所有</span>
            <span><a href="http://www.miibeian.gov.cn/state/outPortal/loginPortal.action" target="_blank">京ICP证040491号</a></span>
        </p>
    </div>
</div>
<script src="/js/login.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<!--<script src="/js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>-->
@if($_SERVER['REQUEST_URI'] !== '/myinfo/userSet')
    <script type="text/javascript" src="/js/ProUserLogin.js?v={{Config::get('app.version')}}"></script>
@endif
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?d2801fc638056c1aac7e8008f41cf828";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

