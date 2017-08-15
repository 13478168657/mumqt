@include('agent.dynamic.header')
@include('agent.dynamic.left')
    <div class="write_msg">
      <p class="manage_title">
        @if(!empty($data))
          @foreach($data as $dkey => $dval)
            @if(!empty($dval))
              @foreach($dval as $ddk => $ddv)
              <a href="{{$hosturl}}?type={{$ddk}}" @if($pagetype[2] == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
      <ul class="input_msg">
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>标题图：</label>
          @if(!empty($info['biaoti'][0]->fileName))
            <div class="title_img">
              <img id="title_img" value="{{$info['biaoti'][0]->id}}" src="{{config('imgConfig.imgSavePath')}}{{$info['biaoti'][0]->fileName}}">
            </div>
           @else
            <div class="title_img">
              <img id="title_img" src="/image/home.jpg">
            </div>
            @endif
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>规划图：</label>
          <div id="box" class="box" >
            <div id="guihua" ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['guihua']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['guihua'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['guihua'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['guihua'])}}"><i></i>已上传{{count($info['guihua'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>效果图：</label>
          <div id="box" class="box" >
            <div id="xiaoguo" ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['xiaoguo']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['xiaoguo'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['xiaoguo'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['xiaoguo'])}}"><i></i>已上传{{count($info['xiaoguo'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>样板间：</label>
          <div id="box" class="box" >
            <div id="yangban" ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['yangban']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['yangban'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['yangban'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['yangban'])}}"><i></i>已上传{{count($info['yangban'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>交通图：</label>
          <div id="box" class="box" >
            <div id="jiaotong" ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['jiaotong']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['jiaotong'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['jiaotong'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['jiaotong'])}}"><i></i>已上传{{count($info['jiaotong'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>实景图：</label>
          <div id="box" class="box" >
            <div id="shijing" ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['shijing']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['shijing'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['shijing'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['shijing'])}}"><i></i>已上传{{count($info['shijing'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>配套图：</label>
          <div id="box" class="box" >
            <div id="peitao"  ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['peitao']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['peitao'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['peitao'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['peitao'])}}"><i></i>已上传{{count($info['peitao'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>施工进度图：</label>
          <div id="box" class="box" >
            <div id="jindu" ></div>
            <div class="parentFileBox">
              <ul class="fileBoxUl">
                <li class="diyUploadHover">
                  <div class="viewThumb">
                    @if(!empty($info['jindu']))
                    <a class="modaltrigger" onclick="getImg(this);" value="{{json_encode($info['jindu'], JSON_UNESCAPED_UNICODE)}}" href="#hx">
                      <img src="{{config('imgConfig.imgSavePath')}}{{$info['jindu'][0]->fileName}}">
                      <span class="imgNum" value="{{count($info['jindu'])}}"><i></i>已上传{{count($info['jindu'])}}张</span>
                    </a>
                    @else
                    <a>
                      <img src="/image/img1.jpg">
                      <span><i></i>暂无上传图片</span>
                    </a>
                    @endif
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <p class="submit">
      <input type="button" class="btn back_color" id="saveImg" value="保存" />
    </p>
  </div>
</div>
<div class="main_r add"  id="hx">
  <h2>查看已上传图片</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg" style="width:750px;">
    <div class="leyout">
     <ul id="res_image">
     </ul>
    </div>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">

$(function(){
  $('#map').submit(function(e){
    return false;
  });
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:110,
    overlay:0.45,
    closeButton:".hidemodal"
  });
});
/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/

/* 上传图片 */


/* 规划图 */
$('#guihua').diyUpload({
  success:function( data ) {
    console.info( data );

  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'

});

/* 效果图 */
$('#xiaoguo').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'
});

/* 样板间 */
$('#yangban').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'
});

/* 交通图 */
$('#jiaotong').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'
});

/* 实景图 */
$('#shijing').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'
});

/* 配套图 */
$('#peitao').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'
});

/* 施工进度 */
$('#jindu').diyUpload({
  success:function( data ) {
    console.info( data );
  },
  error:function( err ) {
    console.info( err );  
  },
  setId:'title_img'
});


</script>
</body>
</html>

<script>
  function imageType(obj){
      var type = {};
      switch(obj){
  
          case '#guihua':
          type = {tname:'规划图', num:1 };
          break;

          case '#xiaoguo':
          type = {tname:'效果图', num:3 };
          break;

          case '#yangban':
          type = {tname:'样板图', num:3 };
          break;

          case '#jiaotong':
          type = {tname:'交通图', num:1 };
          break;

          case '#shijing':
          type = {tname:'实景图', num:3 };
          break;

          case '#peitao':
          type = {tname:'配套图', num:3 };
          break;

          case '#jindu':
          type = {tname:'施工进度图', num:1 };
          break;

          default:
          type = {tname:'上传的图片', num:1 };
          break;
      }
      return type;
  }
  function getImage(obj){
      var sonList = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').children();
      var images = [];
      var type = imageType(obj);
      var imgNum = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').find('span.imgNum').attr('value');
      if((sonList.length - 1 + imgNum) < type.num){
          alert(type.tname + '至少要' + type.num + '张');
          return false;
      }
      sonList.each(function(index){
          images[index] = {
              img:$(this).children('div.viewThumb').children('img').attr('src'),
              note:$(this).find('.diyFileName').val(),
          };
      });
      // console.log(images);
      return images;
  }

  $('#saveImg').click(function(){
      var url = '/dynamic/addphoto';
      var token = $('#token').val();
      var ctype1 = $('#pagetype1').val();
      var ctype2 = $('#pagetype2').val();

      var title = {'id':$('#title_img').attr('value'), 'img':$('#title_img').attr('src')}; //标题图
      var plan = getImage('#guihua');         //规划图
      if(!plan) return false;
      
      var result = getImage('#xiaoguo');      //效果图
      if(!result) return false;

      var model = getImage('#yangban');       //样板间
      if(!model) return false;

      var traffic = getImage('#jiaotong');      //交通图
      if(!traffic) return false;

      var real = getImage('#shijing');         //实景图
      if(!real) return false;

      var assort = getImage('#peitao');      //配套图
      if(!assort) return false;

      var progress = getImage('#jindu');   //施工进度图
      if(!progress) return false;
      // return false;
      $.ajax({
          type:'post',
          url:url,
          data:{
            _token:token,
            guihua:plan,
            biaoti:title,
            xiaoguo:result,
            yangban:model,
            jiaotong:traffic,
            shijing:real,
            peitao:assort,
            jindu:progress,
            type1:ctype1,
            type2:ctype2
          },
          dataType:'json',
          success:function(data){
              if(data == 1){
                alert('保存成功');
                window.location.reload();
              }else{
                alert('保存失败');
              }
          }
      });
  });

  function getImg(obj){
      var val = eval( '(' + $(obj).attr('value') + ')' );
      var imglist = '';
      for( var i in val){
          imglist += '<li><img src="'+ "{{config('imgConfig.imgSavePath')}}" + val[i].fileName +'"></li>';
      }
      $('ul#res_image').html(imglist);
  }
</script>