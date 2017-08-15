<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="/css/brokerComment.css"/>
<link rel="stylesheet" type="text/css" href="/css/brokerCenter.css"/>
<link rel="stylesheet" type="text/css" href="/css/color.css"/>
</head>

<body>
<header class="header">
	<h2>搜房管理中心</h2>
	<nav class="head_nav">
      <a>我的店铺</a>
      <a>使用帮</a>
    </nav>
    <div class="head_r">
      <span>400-630-6888</span>
      <a>退出</a>
    </div>
</header>
<div class="main">
  <div class="main_l" id="main_l">
    <dl class="broker">
      <dt><a><img src="image/broker.jpg" /></a></dt>
    </dl>
    <div class="subnav">
      <p class="p1 click"><span>增量楼盘库</span><i></i></p>
      <p class="p2" style="display:block;">
        <a href="buildList" class="onclick"><i></i>创建新楼盘</a>
        <a href="../../../examine/via.htm"><i></i>审核新楼盘</a>
        <a href="../../../manage/buildManage.htm"><i></i>新楼盘管理</a>
        <a href="../../../editDynamic/zzInfo.htm"><i></i>动态信息修改</a>
      </p>
      <p class="p1"><span>存量楼盘库</span><i></i></p>
      <p class="p2">
        <a href="buildList"><i></i>创建现有楼盘</a>
        <a href="../../../../oldBuildLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
        <a href="../../../../oldBuildLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
      </p>
      <p class="p1"><span>增量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../../../newHouseLibrary/addNewHouse/addNewZz.htm"><i></i>录入新房房源</a>
        <a href="../../../../newHouseLibrary/newHouseManage/releaseing.htm"><i></i>管理新房房源</a>
      </p>
      <p class="p1"><span>存量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../../../oldHouseLibrary/enterSaleHouse/zzHouse.htm"><i></i>录入出售房源</a>
        <a href="../../../../oldHouseLibrary/saleHouseManage/releaseing.htm"><i></i>管理出售房源</a>
        <a href="../../../../oldHouseLibrary/enterRentHouse/zzHouse.htm"><i></i>录入出租房源</a>
        <a href="../../../../oldHouseLibrary/rentHouseManage/releaseing.htm"><i></i>管理出租房源</a>
      </p>
      <p class="p1"><span>我的搜房</span><i></i></p>
      <p class="p2">
        <a><i></i>我的资料</a>
        <a><i></i>我的认真</a>
        <a><i></i>我的积分</a>
        <a><i></i>修改密码</a>
      </p>
    </div>
  </div>
  <div class="main_r" id="main_r">
    <div class="commtent">
      <p>
        <span class="color_blue">五矿万科城</span>
        <span class="color8d">wkwkc</span>
        <span class="subway">综合体楼盘</span>
      </p>
      <p>
       <span>[&nbsp;北京-朝阳-百子湾&nbsp;]&nbsp;&nbsp;</span>
       <span>东四环与广渠路交口大郊亭桥广渠路21号&nbsp;<i class="map_icon"></i></span>
      </p>
    </div>
    <p class="right_title border_bottom">
      <a href="../addNewBuild/addBasicHouse">基础信息</a>
      <a href="addBuilding" class="click">楼栋信息</a>
      <a href="addRoom">户型信息</a>
      <a href="addImage">相册信息</a>
    </p>
    <div class="write_msg">
      <ul class="input_msg">
        <li style="height:auto; overflow:hidden;">
          <label>注意：</label>
          <div class="float_l colorfe">
              1、上传宽度大于600像素，比例为4:3的图片可获得更好的展示效果。<br />
              2、请勿上传有水印、盖章等任何侵犯他人版权或含有广告信息的图片。<br />
              3、可上传30张图片，每张小于20M，建议尺寸比为：16:10，最佳尺寸为480*300像素。<br />
              4、多图房源点击量比非多图房源高出30%。
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
          <label><span class="dotted colorfe">*</span>规划图：</label>
          <div id="box" class="box">
              <div id="toilet" ></div>
          </div>
        </li>
      </ul>
    </div>
    <div class="periphery">
      <div class="map">
      </div>
      <div class="map_msg">
        <a>1号楼</a>
        <a>2号楼</a>
        <a>3号楼</a>
        <a>4号楼</a>
        <a>5号楼</a>
        <a>6号楼</a>
      </div>
    </div>
    <p class="submit">
      <input type="button" class="btn back_color" value="保存" />
    </p>
  </div>
</div>
<script type="text/javascript" src="js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
window.onload=function(){
	var imgSrc =$("#img").css("background-image");
		var image=imgSrc.substring(5,imgSrc.length-2);
		var img1=new Image();
		img1.src=image;
		$("#" + id).css("width",img1.width+"px");
		$("#" + id).css("height",img1.height+"px");
}
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
                        if (($(this).offset().left > $("#dvMap").offset().left + 600) && click1 == 1){
                            $(this).css("visibility","hidden");
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
            if($("#img").css("background-image").indexOf('data:image') < 0 && '{{$buildBackPic}}' == ''){
                alert('请上传一张规划图');
                return false;
            }
            $(".map_msg a").each(function(index){
                var buildId = $(this).attr('value');
                var coordinateX = $(this).offset().left - $(".map").offset().left - 18;
                var coordinateY = $(this).offset().top - $(".map").offset().top - 28;
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
                    backImage : $("#img").css("background-image").substring(4,$("#img").css("background-image").length-1),
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
		var img=new Image();
		img.src=strResult;
		img.onload = function () {
		  var imgW=img.width;
		  $("#" + id).css("width",imgW+"px");
		  $("#" + id).css("height",img.height+"px");
		  $("#" + id).css("position","inherit");
		  $("#" + id).css("left","0");
		  $("#" + id).css("top","0");
		  if(imgW>=800 && imgW<=1200){
			  $(".map_msg a").attr("style","");
			  $(".map_msg a").attr("data","0");
			  $("#" + id).css("background-image", "url("+strResult+")");
		  } else {
			  alert("图片尺寸不符合要求！");
		  }
		}
    };
	reader.readAsDataURL(file.files[0]);
}
</script>
</script>
</body>
</html>