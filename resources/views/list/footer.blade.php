@include('layout.footer')
<script src="/js/list.js?v={{Config::get('app.version')}}"></script>
<script>
$(function(){
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:100,
    overlay:0.45
  });
});
</script>
{{--<script src="/js/sflogger.js?v={{Config::get('app.version')}}"></script>--}}
</body>
</html>
