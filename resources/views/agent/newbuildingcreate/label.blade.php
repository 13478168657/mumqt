@include('agent.newbuildingcreate.header')
@include('agent.newbuildingcreate.left')
    <input type="hidden" name="_token" value="{{csrf_token()}}" />
    <input type="hidden" name="communityId" value="{{$communityId}}" />
    <div class="write_msg">
      <ul class="input_msg">
        <li style="height:auto; overflow:hidden;">
          <label class="width4">注意：</label>
          <div class="float_l colorfe">
              1、上传宽度大于600像素，比例为4:3的图片可获得更好的展示效果。<br />
              2、请勿上传有水印、盖章等任何侵犯他人版权或含有广告信息的图片。<br />
              3、可上传30张图片，每张小于20M，建议尺寸比为：16:10，最佳尺寸为480*300像素。<br />
              4、多图房源点击量比非多图房源高出30%。
          </div>
        </li>
        <li style="height:50px; overflow:hidden;">
          <label class="width4"><span class="dotted colorfe">*</span>规划图：</label>
          <a class="file"></a>
          <input type="file" class="file" onchange="selectImage(this,'img');" style="opacity:0;"/>
        </li>
      </ul>
    </div>
<style>
    .map { cursor:move;}
    .noselect a {-webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;}
</style>
    <div class="periphery">
        <div id="dvMap" style="height:400px; width:600px; overflow: hidden; float:left;">
        <div class="map" id="img" style="height: 600px; width:900px; float:left; background-image: url({{$buildBackPic->buildingBackPic}})"></div>
        </div>
    
    <div class="map_msg noselect">
    @if(!empty($allBuild))
        @foreach($allBuild as $build)
        <a value="{{$build->id}}" tt="{{$build->coordinateX}},{{$build->coordinateY}}"><span>{{$build->num}}号楼</span></a>
        @endforeach
    @else
    <span style="color:red;margin-left:10px;">该楼盘暂无楼栋信息,请先添加楼栋.</span>
    @endif
    </div>
  <div id="tags"></div>
  </div>
    <p class="submit">
      <input type="button" class="btn back_color" value="保存" id="submit" />
    </p>
  </div>
</div>
<script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
    $(function(){
        var click1 = 0;
        var click2 = 0;
        var mausx = 0;
        var mausy = 0;
        var winx = 0;
        var winy = 0;
        var difx = mausx - winx;
        var dify = mausy - winy;
        var tag = null;
        $("#dvMap").mousemove(function(event) {
            if (click2 == 1) {
                return;
            }
            mausx = event.pageX;
            mausy = event.pageY;
            winx = $(".map").offset().left;
            winy = $(".map").offset().top;
            if (click1 == 0) {
                difx = mausx - winx;
                dify = mausy - winy;
            }
            var newx = event.pageX - difx - $(".map").css("marginLeft").replace('px', '');
            var newy = event.pageY - dify - $(".map").css("marginTop").replace('px', '');
            if (newx <= $("#dvMap").offset().left && newy <= $("#dvMap").offset().top && newx + $(".map").width() >= $("#dvMap").offset().left + $("#dvMap").width() && newy + $(".map").height() >= $("#dvMap").offset().top +  $("#dvMap").height()) {
                $(".map").offset({top: newy, left: newx});
                $(".map_msg a").each(function(){
                    if ($(this).attr("data") == "1") {
                        var tagx = $(this).offset().left + newx - winx;
                        var tagy = $(this).offset().top + newy - winy;
                        $(this).offset({top: tagy, left: tagx});
                        if (($(this).offset().left < $("#dvMap").offset().left + 600) && click1 == 1){
                            $(this).css("visibility","visible");
                        }
                        if ($(this).offset().left > $("#dvMap").offset().left + 600){
                            $(this).css("visibility","visible");
                        }
                        if ($(this).offset().left < $("#dvMap").offset().left){
                            $(this).css("visibility","visible");
                        }
                        if ($(this).offset().top > $("#dvMap").offset().top + 400){
                            $(this).css("visibility","visible");
                        }
                        if ($(this).offset().top < $("#dvMap").offset().top){
                            $(this).css("visibility","visible");
                        }
                    }
                });
            }
        });
        $("#dvMap").mousedown(function(){
            click1 = 1;
        });
        $("#dvMap").mouseup(function(){
            click1 = 0;
        });
        var moveTag = function(obj){
            obj.mousedown(function(){
                tag = obj;
                click2 = 1;
            });
        };
        $(".map_msg a").each(function(){
            moveTag($(this));
            // $(this).attr("data","0");
        });
        $(".periphery").mouseup(function(){
            click2 = 0;
        });
        $(".periphery").mousemove(function(event){
            if (click2 == 1) {
                var newx2 = event.pageX;
                var newy2 = event.pageY;
                tag.offset({top: newy2, left: newx2});
                tag.attr("data","1");
            }
        });
        var mapInfo = [];
        var _token = $('input[name="_token"]').val();
        var communityId = $('input[name="communityId"]').val();
        $("#submit").click(function(){
            $(".map_msg a").each(function(index){
                var buildId = $(this).attr('value');
                var coordinateX = $(this).offset().left - $(".map").offset().left - 18;
                var coordinateY = $(this).offset().top - $(".map").offset().top - 15;
                mapInfo[index] = {
                            id:buildId,
                            x:coordinateX,
                            y:coordinateY
                };
                // var r = $(this).html() + "," + coordinateX + "," + coordinateY;
                // console.log(buildId);
            });
            // console.log(mapInfo);
            $.ajax({
                type : 'post',
                url  : 'label',
                data : {
                    _token:_token,
                    communityId:communityId,
                    mapInfo:mapInfo
                },
                success : function(resule){
                    // console.log(resule);
                    xalert({
                        title:'提示',
                        content:resule,
                        time:1,
                        url:'/label?communityId='+communityId
                    });
                }
            });
        });
    });
    $('.map_msg').children('a').each(function(){
        var val = $(this).attr('tt').split(',');
        if(val[0] > 0 && val[1] > 0){
            $(this).css({'position':'absolute', 'left': parseInt(val[0]) + 'px', 'top': parseInt(val[1]) + 'px'});
            $(this).attr('data','1');
        }
    });
	
	function selectImage(file,id) {
    if (!file.files || !file.files[0]) {
        return;
    }
    var len = file.files.length;
    if (len > 1) {
        alert("图片张数过多！");
        return;
    }
        var reader = new FileReader();
        if (!/.(gif|jpg|jpeg|png|gif|jpg|png)/.test(file.files[0].type)) {
            alert("图片格式不正确！");
            return;
        }        
        reader.onload = function (evt) {
            var strResult = evt.target.result;
            $("#" + id).css("background-image", "url("+strResult+")");
        };
        reader.readAsDataURL(file.files[0]);
}

// 参数，最大高度
var MAX_HEIGHT = 135;
// 渲染
function render(src) {
    // 创建一个 Image 对象
    var image = new Image();
    // 绑定 load 事件处理器，加载完成后执行
    image.onload = function () {
        // 获取 canvas DOM 对象
        var canva = document.createElement("canvas");
        canva.id = "myCanvas";
        var canvas = document.getElementById("myCanvas");
        // 如果高度超标
        if (image.height > MAX_HEIGHT) {
            // 宽度等比例缩放 *=
            image.width *= MAX_HEIGHT / image.height;
            image.height = MAX_HEIGHT;
        }
        // 获取 canvas的 2d 环境对象,
        // 可以理解Context是管理员，canvas是房子
        var ctx = canvas.getContext("2d");
        // canvas清屏
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        // 重置canvas宽高
        canvas.width = image.width;
        canvas.height = image.height;
        // 将图像绘制到canvas上
        ctx.drawImage(image, 0, 0, image.width, image.height);
        // !!! 注意，image 没有加入到 dom之中
    };
    // 设置src属性，浏览器会自动加载。
    // 记住必须先绑定事件，才能设置src属性，否则会出同步问题。
    image.src = src;
}
</script>
</body>
</html>