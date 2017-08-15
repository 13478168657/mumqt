<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>标题图：</label>
  @if(!empty($info['biaoti'][0]->fileName))
    <div class="title_img">
      <img id="title_img" value="{{$info['biaoti'][0]->id}}" src="{{config('imgConfig.imgSavePath')}}{{$info['biaoti'][0]->fileName}}">
      <input type="hidden" id="oldtitle" value="{{$info['biaoti'][0]->fileName}}">
    </div>
   @else
    <div class="title_img">
      <img id="title_img" src="/image/home.jpg">
      <input type="hidden" id="oldtitle" value="/image/home.jpg">
    </div>
  @endif
</li>

<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>规划图：</label>
  <div id="box" class="box" @if(!empty($info['guihua'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="guihua" @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['guihua']))
        @foreach($info['guihua'] as $ghkey => $ghval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
            <input class="imageId" type="hidden" value="{{$ghval->id}}">
            <input class="imageNote" type="hidden" value="{{$ghval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
  </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>效果图：</label>
  <div id="box" class="box" @if(!empty($info['xiaoguo'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="xiaoguo" @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['xiaoguo']))
        @foreach($info['xiaoguo'] as $xgkey => $xgval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$xgval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$xgval->note}}">
            <input class="imageId" type="hidden" value="{{$xgval->id}}">
            <input class="imageNote" type="hidden" value="{{$xgval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
   </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>样板间：</label>
  <div id="box" class="box" @if(!empty($info['yangban'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="yangban" @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['yangban']))
        @foreach($info['yangban'] as $ybkey => $ybval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$ybval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ybval->note}}">
            <input class="imageId" type="hidden" value="{{$ybval->id}}">
            <input class="imageNote" type="hidden" value="{{$ybval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
   </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>交通图：</label>
  <div id="box" class="box" @if(!empty($info['jiaotong'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="jiaotong" @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['jiaotong']))
        @foreach($info['jiaotong'] as $jtkey => $jtval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$jtval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$jtval->note}}">
            <input class="imageId" type="hidden" value="{{$jtval->id}}">
            <input class="imageNote" type="hidden" value="{{$jtval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
   </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>实景图：</label>
  <div id="box" class="box" @if(!empty($info['shijing'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="shijing" @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['shijing']))
        @foreach($info['shijing'] as $sjkey => $sjval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$sjval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$sjval->note}}">
            <input class="imageId" type="hidden" value="{{$sjval->id}}">
            <input class="imageNote" type="hidden" value="{{$sjval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
   </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>配套图：</label>
  <div id="box" class="box" @if(!empty($info['peitao'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="peitao"  @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['peitao']))
        @foreach($info['peitao'] as $ptkey => $ptval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$ptval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif value="{{$ptval->note}}">
            <input class="imageId" type="hidden" value="{{$ptval->id}}">
            <input class="imageNote" type="hidden" value="{{$ptval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
   </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
<li style="height:auto; overflow:hidden;">
  <label><span class="dotted colorfe">*</span>施工进度图：</label>
  <div id="box" class="box" @if(!empty($info['jindu'])) style="min-height:180px; margin-top:5px;" @endif >
    <div id="jindu" @if($status == 2) style="display:none;" @endif ></div>
    <div class="parentFileBox">
      <ul class="fileBoxUl">
        @if(!empty($info['jindu']))
        @foreach($info['jindu'] as $jdkey => $jdval)
        <li class="diyUploadHover">
          <div class="viewThumb">
            <img src="{{config('imgConfig.imgSavePath')}}{{$jdval->fileName}}">
          </div>
          <div @if($status != 2 ) class="diyCancel" @endif ></div>
          <div class="diySuccess"></div>
          <div class="cz">
            <a class="setTitle">设置成标题图</a>
            <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$jdval->note}}">
            <input class="imageId" type="hidden" value="{{$jdval->id}}">
            <input class="imageNote" type="hidden" value="{{$jdval->note}}">
          </div>
        </li>
        @endforeach
        @endif
      </ul>
    </div>
   </div>
  @if($status == 2)
  <i class="eidth_icon" style="margin-top:10px;"></i>
  @endif
</li>
    </ul>
    </div>
    <p class="submit">
      <input type="button" class="btn back_color" id="saveImg" value="保存" />
    </p>
  </div>
</div>
<input type="hidden" id="token" value="{{csrf_token()}}" />
<input type="hidden" id="pagetype1" value="{{$pagetype[1]}}" />
<input type="hidden" id="pagetype2" value="{{$pagetype[2]}}" />
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
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

var deleteImgId = [];
$(document).ready(function(e) {
    $('.diyCancel').click(deleteImg);

    $(".input_msg li .eidth_icon").click(function(){
        $(this).hide();
        $(this).next().show();
        $(this).prev("#box").children('div').eq(0).show(); 

        $(this).prev("#box").children('div.parentFileBox').children('ul.fileBoxUl').children('li.diyUploadHover').each(function(){
            $(this).children('div').eq(1).addClass('diyCancel');
            $(this).children('div').eq(1).on('click',deleteImg);
            $(this).children('input.diyFileName').removeAttr('readonly');
        }); 

    });

    $(".input_msg li .ti").click(function(){
        $(this).hide();
        $(this).prev().show();
        $(this).parent().find(".content").show(); 
        $(this).parent().find(".enter").hide(); 
    });


});
  
  function deleteImg(){
      deleteImgId.push($(this).parent().find('input.imageId').val());
      $(this).parent().remove();
  }
  $('#title_img').change(function(){
    alert(1);
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
      if(sonList.length < type.num){
          alert(type.tname + '至少要' + type.num + '张');
          return false;
      }
      sonList.each(function(index){
          images[index] = {
              img:$(this).children('div.viewThumb').children('img').attr('src'),
              note:$(this).find('.diyFileName').val(),
              id:$(this).find('.imageId').val(),
              oldnote:$(this).find('.imageNote').val(),
          };
          if(images[index].oldnote == images[index].note){
            images[index] = null;
          }
      });
      return images;
  }

  $('#saveImg').click(function(){
      var url = '/buildeditimage';
      var token = $('#token').val();
      var ctype1 = $('#pagetype1').val();
      var ctype2 = $('#pagetype2').val();

      var title = {'id':$('#title_img').attr('value'), 'img':$('#title_img').attr('src'), 'oldTitle':$('#oldtitle').val()}; //标题图
      
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

      $.ajax({
          type:'post',
          url:url,
          data:{
            _token:token,
            biaoti:title,
            guihua:plan,
            xiaoguo:result,
            yangban:model,
            jiaotong:traffic,
            shijing:real,
            peitao:assort,
            jindu:progress,
            type1:ctype1,
            type2:ctype2,
            deleteId:deleteImgId
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

  $('.setTitle').bind('click', function(){
      var img = $(this).parents('li.diyUploadHover').children('div.viewThumb').children('img').attr('src');
      $('#title_img').attr('src', img);
  });
</script>