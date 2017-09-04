@include('agent.header')
@include('agent.left')
    <div class="write_msg">
      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color modaltrigger clear" href="#news">添加点评</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="10%">序号</th>
          <th width="70%">点评标题</th>
          <th width="10%">创建时间</th>
          <th width="10%">操作</th>
        </tr>
        @foreach($communitycomment as $k=>$comment)
        <tr @if( ( $k + 1) % 2 == 0) class="backColor" @endif>
          <td>@if($k < 9) {{'0'.($k+1)}} @else {{$k+1}} @endif</td>
          <td>{{$comment->title}}</td>
          <td>{{$comment->timeCreate}}</td>
          <td>
            <a class="modaltrigger look" href="#comment" value="{{$comment->id}}">查看</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="modaltrigger update_comment" href="#news" value="{{$comment->id}}">修改</a>
            <input type="hidden" name="title" value="{{$comment->title}}" />
            <input type="hidden" name="timeCreate" value="{{$comment->timeCreate}}" />
            <input type="hidden" name="comment" value="{{$comment->comment}}" />
          </td>
        </tr>
        @endforeach
        <tr>
          <td colspan="3">
            <div class="page_nav">
              <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">上一页</a></li>
                <li><a href="#">1</a></li>
                <li class="click">2</li>
                <li>.....</li>
                <li><a href="#">75</a></li>
                <li><a href="#">下一页</a></li>
                <li><a href="#">尾页</a></li>
              </ul>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="main_r add" id="news" style="width:600px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2 id="change_dp">添加点评</h2>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label><span class="dotted colorfe">*</span>标题：</label>
        <input type="text" class="txt width" name="add_title">
        <span id="msg_title" style="color:red;margin-left:10px;"></span>
      </li>
      <li class="no_height">
        <label>点评内容：</label>
        <div class="float_l" style=" width:412px; height:112px;">
         <textarea class="txtarea" name="add_comment" style=" width:400px; height:90px;"></textarea>
         <span class="hs">还剩<span class="colorfe">300</span>字可输入</span>
        </div>
      </li>
      <li style="height:auto; overflow:hidden;"><input type="button" class="btn back_color" name="save_comment" style="margin-left:200px !important;" value="保存"/></li>
    </ul>
  </div>
</div>
<div class="main_r add" id="comment" style="width:600px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>查看点评</h2>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label>标题：</label>
        <span class="tishi" id="look_title">精装大复式 低总价 近地铁</span>
      </li>
      <li>
        <label>时间：</label>
        <span class="tishi" id="look_timeCreate">2015年09月21日 17:00</span>
      </li>
      <li class="no_height">
        <label>点评内容：</label>
        <span class="comment" id="look_comment">1、本房是龙博苑性价比较高的两居室，2层，楼前没有遮挡采光非常好，现在业主孩子在里面住，百安居装修，业主保持的非常好，所有的室内线路都走的暗线，业主有装修时的设计视频光盘，让您完全了解室内的状况，厨房业主设计时非常用心，选的进口瓷砖，您做饭产生的油烟不会附着在上面，您买过来后基本不用装修，配上自己喜欢的家具家电就可以。 2、业主卖房单纯变现，前期需要一个大额定金，业主诚心出售随时可以签约。 </span>
      </li>
    </ul>
  </div>
</div>
<input type="hidden" name="communityId" value="{{$communityId}}">
<input type="hidden" name="_token" value="{{csrf_token()}}" />
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script>
;!function(){
  laydate({
	 elem: '#kai'
  }),
  laydate({
	 elem: '#jiao'
  })
}();

$(function(){
  $('#xiajia').submit(function(e){
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

<script>
  var comment_id;
  $('.clear').click(function(){
    $('#change_dp').html('添加点评');
    $('#msg_title').html('');
    $('#msg_comment').html('');
    comment_id = null;
    $('input[name="add_title"]').attr('value','');
    $('textarea[name="add_comment"]').text('');
  });
  // 查看点评
  $('.look').click(function(){
    var title = $(this).parent().find('input[name="title"]').val();
    var timeCreate = $(this).parent().find('input[name="timeCreate"]').val();
    var comment = $(this).parent().find('input[name="comment"]').val();
    $('#look_title').html(title);
    $('#look_timeCreate').html(timeCreate);
    $('#look_comment').html(comment);
  });
  // 修改点评
  $('.update_comment').click(function(){
    $('#change_dp').html('修改点评');
    $('#msg_title').html('');
    $('#msg_comment').html('');
    comment_id = $(this).attr('value');
    var title = $(this).parent().find('input[name="title"]').val();
    var comment = $(this).parent().find('input[name="comment"]').val();
    $('input[name="add_title"]').attr('value',title);
    $('textarea[name="add_comment"]').text(comment);
  });
  // 添加点评
  $('input[name="save_comment"]').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    var add_title = $('input[name="add_title"]').val();
    var add_comment = $('textarea[name="add_comment"]').val();
    if(add_title == ''){
      $('#msg_title').html('标题不能为空');
      add_title = '';
    }else{
      $('#msg_title').html('');
    }
    if(add_title != ''){
      $.ajax({
        type : 'post',
        url  : 'comment',
        data : {
          _token:_token,
          communityId:communityId,
          comment_id:comment_id,
          add_title:add_title,
          add_comment:add_comment
        },
        success : function(result){
          if(result == 1){
            alert('点评添加成功!');
            window.location.href="comment?communityId={{$communityId}}";
          }else{
            alert('点评修改成功!');
            window.location.href="comment?communityId={{$communityId}}";
          }
        }
      });
    }
  });
</script>
</body>
</html>
