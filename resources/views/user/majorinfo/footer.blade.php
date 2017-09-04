<footer class="footer" id="footer">
  <div class="bottom">
    <p>
      <a href="#">关于我们</a>
      <span class="dotted"></span>
      <a href="#">人才招聘</a>
      <span class="dotted"></span>
      <a href="#">联系我们</a>
      <span class="dotted"></span>
      <a href="#">商业合作</a>
      <span class="dotted"></span>
      <a href="#">用户反馈</a>
      <span class="dotted"></span>
      <a href="#">用户协议</a>
      <span class="dotted"></span>
      <a href="#">移动客户端</a>
    </p>
    <p class="p2">
      <span>Copyright©&nbsp;2015</span>
      <span>All&nbsp;Rights&nbsp;Reserved</span>
      <span>北京道杰士投资咨询服务有限责任公司</span>
      <span>京ICP证040491号</span>
      <span>版权所有</span>
    </p>
  </div>
   <input type="hidden" name="_token" value="{{csrf_token()}}" id="vcode">
</footer>
<script src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>

<!-- 日期选择js插件   -->
<script src="/js/jquery.datetimepicker.js?v={{Config::get('app.version')}}"></script>

<!-- 头像上传js       -->
<script type="text/javascript" src="/js/jquery.imgareaselect.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/fullAvatarEditor.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/yuImgCut.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/userpicLoad.js?v={{Config::get('app.version')}}"></script>


<script src="/js/headNav.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script>
$(document).ready(function(e) {  
  /*   选择日期插件 start  */
  $('#birthday').datetimepicker({step:30});
  /*   选择日期插件 end  */
});
</script>
<script type="text/javascript">
$(function(){
  $('#loginform').submit(function(e){
	  return false;
  });
  $('#changeform').submit(function(e){
	  return false;
  });
  //弹出层调用语句
  $('.modaltrigger').leanModal({
	  top:110,
	  overlay:0.45,
	  closeButton:".hidemodal"
  });


});
</script>
<script src="/js/majorinfo.js?v={{Config::get('app.version')}}"></script>
</body>
</html>
