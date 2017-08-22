@include('agent.dynamic.header')
@include('agent.dynamic.left')
    <div class="write_msg">
      <ul class="input_msg query_tj">
        <li>
          <p class="query" style="float:right;">
            <a class="btn back_color modaltrigger" onclick="add();" href="#addnews">添加消息</a>
          </p>
         </li>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="10%">序号</th>
          <th width="70%">消息内容</th>
          <th width="10%">创建时间</th>
          <th width="10%">操作</th>
        </tr>
        @if(!empty($data->items()))
        @foreach($data->items() as $key => $val)
        <tr>
          <td id="a{{$key}}">{{sprintf("%'.02d", ($key + ( ($data->currentPage() - 1) * 10) ) + 1)}}</td>
          <td id="b{{$key}}">{{mb_substr($val->news, 0, 55, 'UTF-8')}}</td>
          <td id="c{{$key}}">{{mb_substr($val->timeCreate, 0, 10, 'UTF-8')}}</td>
          <td>
            @if($status != 1)
            已发布&nbsp;&nbsp;<a class="modaltrigger" href="#news" onclick='see("{{$key}}");'>查看</a>
            @else
            未审核&nbsp;&nbsp;<a class="modaltrigger" href="#news"  onclick='see("{{$key}}");'>查看</a>&nbsp;&nbsp;<a class="modaltrigger" onclick="edi(this, '{{$key}}');" value="{{$val->id}}" href="#addnews">修改</a>&nbsp;&nbsp;<a class="modaltrigger" onclick="del(this);" href="#sc" value="{{$val->id}}">删除</a>
            @endif
          </td>
          <input type="hidden" id="d{{$key}}" value="{{$val->news}}">
          <input type="hidden" id="e{{$key}}" value="{{$val->title}}">
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="3">
            暂无楼盘消息
          </td>
        </tr>
        @endif
        <tr>
          <td colspan="3">
            {!!$data->render()!!}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="main_r add" id="addnews" style="width:600px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>添加消息</h2>
  <div class="write_msg">
      <ul class="input_msg">
        <li>
          <label><span class="dotted colorfe">*</span>标题：</label>
          <input type="text" id="news_title" value="" class="txt width">
          <span style="color:red; margin-left:10px;" id="res_title"></span>
        </li>
        <li class="no_height">
          <label>消息内容：</label>
          <div class="float_l" style=" width:412px; height:112px;">
            <textarea class="txtarea" id="news_intro" value="" wrap="physical" maxlength="300" style=" width:400px; height:90px; word-wrap:break-word; word-break:break-all;"></textarea>
            <span class="hs">还剩<span class="colorfe" id="num">300</span>字可输入</span>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;"><input type="button" class="btn back_color" id="save_news" style="margin-left:200px !important;" value="保存"/></li>
      </ul>
    </div>
</div>
<div class="main_r add" id="news" style="width:600px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>查看消息</h2>
  <div class="write_msg">
    <ul class="input_msg">
      <li>
        <label>标题：</label>
        <span class="tishi"></span>
      </li>
      <li>
        <label>时间：</label>
        <span class="tishi"></span>
      </li>
      <li class="no_height">
        <label>点评内容：</label>
        <textarea class="news" readonly style="border:none; width:400px; resize : none; min-height:150px; color: #565656; font-family: '微软雅黑';font-size: 12px;"></textarea>
      </li>
    </ul>
  </div>
</div>
<div class="change_tel" id="sc">
  <span class="close" onClick="closeDeletenews(this);"></span>
  <h2>删除</h2>
  <div class="change3">
    <p class="p"><i></i>您确定要删除此消息吗？</p>
    <p class="p">
      <input type="button" class="btn back_color" style=" width:80px;" id="saveDelete" value="确定" />
      <input type="button" class="btn back_color" style=" width:80px;" value="取消" />
    </p>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/dynamic.js?v={{Config::get('app.version')}}"></script>
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

$('#news_intro').keyup(function(){
   var len = $(this).val();
   var num = 300 - parseInt(len.length) ;
   $('#num').text( num );
});

$('#save_news').click(function(){
    var token = $('#token').val();
    var title = testing('#news_title', /^\S.*$/, '标题不能为空', '#res_title');
    var intro = $('#news_intro').val();
    // console.log(intro);
    // return false;
    if(title){
      $.ajax({
        type:'post',
        url:'/dynamic/newsbuild',
        data:{
          _token:token,
          title:title,
          intro:intro,
          newsId:newsId
        },
        dataType:'json',
        success:function(data){
          if(data == 1){
            alert('保存成功');
            window.location.reload();
          }else{
            alert('保存失败');
            window.location.reload();
          }
        }
      });
    }else{
      return false;
    }

});
window.onbeforeunload = function(){
  $('#news_title').val('');
  $('#news_intro').val('');
}

function see( skey ){
  
    $('ul.input_msg').find('.tishi').eq(0).text( $('#e'+skey).val() );
    $('ul.input_msg').find('.tishi').eq(1).text( $('#c'+skey).text() );
    $('ul.input_msg').find('.news').text( $('#d'+skey).val() );
}

function closeDeletenews(obj){
    $(obj).parent().hide();
    $('#lean_overlay').hide();
    newsId = undefined;
}

function del(obj){
    newsId = $(obj).attr('value');
}

$('#saveDelete').click(function(){
    var token = $('#token').val();
    var url = '/dynamic/deletenews';
    if(typeof newsId == 'undefined'){
        return false;
    }else{
        $.ajax({
            type:'post',
            url:url,
            data:{
                _token:token,
                newsId:newsId
            },
            dataType:'json',
            success:function(data){
                if(data == 1){
                    alert('删除成功');
                    window.location.reload();
                }else{
                    alert('删除失败');
                    window.location.reload();
                }
            }
        });
    }
});

function edi(obj, skey){
    var skey = skey;
    newsId = $(obj).attr('value');
    var len = $('#d'+skey).val();
    $('#news_title').val( $('#e'+skey).val() );
    $('#news_intro').val( len );
    var num = 300 - parseInt(len.length) ;
    $('#num').text( num );
}
function add(){
    newsId = undefined;
    $('#comment_title').val('');
    $('#comment_intro').val('');
    $('#num').text( 300 );
}
</script>
</body>
</html>