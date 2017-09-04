@include('agent.newbuildingcreate.header')
@include('agent.newbuildingcreate.left')
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
    @if(!empty($communitycomment->items()))
      @foreach($communitycomment as $k=>$comment)
        <tr @if( ( $k + 1) % 2 == 0) class="backColor" @endif>
          <td>@if($k < 9) {{'0'.($k+1)}} @else {{$k+1}} @endif</td>
          <td>{{$comment->title}}</td>
          <td>{{$comment->timeCreate}}</td>
          <td>
            <a class="modaltrigger look" href="#comment" value="{{$comment->id}}">查看</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="modaltrigger update_comment" href="#news" value="{{$comment->id}}">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="modaltrigger delete_comment" href="#del" value="{{$comment->id}}">删除</a>
            <input type="hidden" name="title" value="{{$comment->title}}" />
            <input type="hidden" name="timeCreate" value="{{$comment->timeCreate}}" />
            <input type="hidden" name="comment" value="{{$comment->comment}}" />
          </td>
        </tr>
        @endforeach
    @else
      <tr>
        <td colspan="7">暂无数据</td>
      </tr>
    @endif
        <tr>
          <td colspan="3">
              {!!$communitycomment->render()!!}
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
         <textarea class="txtarea" name="add_comment" id="textlength" style=" width:400px; height:90px;"></textarea>
         <span class="hs">还剩<span class="colorfe" id="hint">300</span>字可输入</span>
        </div>
      </li>
      <li style="height:auto; overflow:hidden;">
        <input type="button" class="btn back_color" name="save_comment" style="margin-left:200px !important;" value="保存"/>
      </li>
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
        <span class="tishi" id="look_title"></span>
      </li>
      <li>
        <label>时间：</label>
        <span class="tishi" id="look_timeCreate"></span>
      </li>
      <li class="no_height">
        <label>点评内容：</label>
        <span class="comment" id="look_comment"></span>
      </li>
    </ul>
  </div>
</div>

<div class="change_tel" id="del" style="top:250px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>确认删除</h2>
  <div class="change3">
    <p class="p" style="width:200px;">确定删除该点评信息吗?</p>
  </div>
  <div class="submit">
    <a class="btn back_color margin_r delete">确定</a>
    <a class="btn back_color" onClick="$('#del').hide(); $('#lean_overlay').hide();">取消</a>
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
    $('input[name="add_title"]').val('');
    $('textarea[name="add_comment"]').val('');
    $('#hint').html(300);
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
    $('input[name="add_title"]').val(title);
    $('textarea[name="add_comment"]').val(comment);
    $('#hint').html(300 - comment.length);
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
          // alert(result);
          xalert({
              title:'提示',
              content:result,
          });
          window.location.href="comment?communityId={{$communityId}}";
        }
      });
    }
  });

  // 删除点评信息
  var delete_id; // 获取要删除的评论id
  $('.delete_comment').click(function(){
    delete_id = $(this).attr('value');
  });
  $('.delete').click(function(){
    var _token = $('input[name="_token"]').val();
    var communityId = $('input[name="communityId"]').val();
    $.ajax({
      type : 'post',
      url  : 'comment',
      data : {
        _token:_token,
        communityId:communityId,
        delete_id:delete_id
      },
      success : function(result){
        // console.log(result);
        // alert(result);
        window.location.href="comment?communityId={{$communityId}}";
      }
    });
  });

  $(wordCheck("#textlength",300,"#hint"));

  /**
  * 限制文本输入数量
  * @param obj textLength 对象
  * @param int maxNum 可输入最大数字数量
  * @param obj msgNotice 动态提示的对象
  */
  function wordCheck(textLength,maxNum,msgNotice){
    $(textLength).keyup(function(){
      var len = $(this).val().length;
      if(len > (maxNum-1)){
        $(this).val($(this).val().substring(0,maxNum));
      }
      var num = maxNum - len;
      if(num <= 0){
        num = 0;
      }
      $(msgNotice).text(num);
    });
  }
</script>
</body>
</html>
