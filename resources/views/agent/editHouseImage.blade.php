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
            <dt><a><img src="/image/broker.jpg" /></a></dt>
        </dl>
        <div class="subnav">
            <p class="p1"><span>新盘库管理</span><i></i></p>
            <p class="p2">
                <a href="../../../newBuildLibrary/add/buildList.htm"><i></i>创建新楼盘</a>
                <a href="../../../newBuildLibrary/examine/via.htm"><i></i>审核新楼盘</a>
                <a href="../../../newBuildLibrary/manage/buildManage.htm"><i></i>管理新楼盘</a>
                <a href="../../../newBuildLibrary/editDynamic/zzInfo.htm"><i></i>动态信息修改</a>
            </p>
            <p class="p1"><span>现有楼盘库管理</span><i></i></p>
            <p class="p2">
                <a href="../../../houseLibrary/enterSaleHouse/buildList.htm"><i></i>创建现有楼盘</a>
                <a href="../../../houseLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
                <a href="../../../houseLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
            </p>
            <p class="p1"><span>增量房源库</span><i></i></p>
            <p class="p2">
                <a href="../../../newHouseLibrary/addNewHouse/addNewZz.htm"><i></i>录入新房房源</a>
                <a href="../../../newHouseLibrary/newHouseManage/releaseing.htm"><i></i>管理新房房源</a>
            </p>
            <p class="p1 click"><span>存量房源库</span><i></i></p>
            <p class="p2" style="display:block;">
                <a href="../../enterSaleHouse/zzHouse.htm"><i></i>录入出售房源</a>
                <a href="../releaseing.htm" class="onclick"><i></i>管理出售房源</a>
                <a href="../../enterRentHouse/zzHouse.htm"><i></i>录入出租房源</a>
                <a href="../../rentHouseManage/releaseing.htm"><i></i>管理出租房源</a>
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
        <form action="/editimagesub/{{$class}}" method="post" id="oldsale">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <input type="hidden" name="id" value="{{$houseid}}" >
            <input type="hidden" name="leyout">
            <input type="hidden" name="indoor">
            <input type="hidden" name="traffic">
            <input type="hidden" name="peripheral">
            <input type="hidden" name="exterior">
            <input type="hidden" name="titleimg">
        <p class="right_title border_bottom">
            <a class="click">修改图片</a>
        </p>
            <div class="write_msg">
                <p class="write_title">
                    <span class="title">户型图</span>
                </p>
                <div class="check">
                    <p class="check_title">选择户型图片：提供&nbsp;<span class="colorfe imgnum"></span>&nbsp;张小区户型图供选择。 已选中&nbsp;<span class="colorfe selected">0</span>&nbsp;张</p>
                    <div class="check_img choose">
                        @if(!empty($leyouts))
                            @foreach($leyouts as $key => $leyout)
                                <dl>
                                    <dt><img src="{{$leyout->fileName}}" /></dt>
                                    <dd><input type="checkbox" class="hit" id="leyout_{{$key}}" />{{$leyout->name}}</dd>
                                </dl>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="check">
                    <p class="check_title">已选图片</p>
                    <div class="check_img">
                        <div id="box" class="box" style="min-height:180px; margin:20px 0 0 10px;">
                            <div id="leyout" attr="1"></div>
                            <div class="parentFileBox">
                                <ul class="fileBoxUl">
                                    @if(!empty($info['huxing']))
                                        @foreach($info['huxing'] as $ghkey => $ghval)
                                            <li class="diyUploadHover">
                                                <div class="viewThumb">
                                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                                </div>
                                                <div class="diyCancel" ></div>
                                                <div class="diySuccess"></div>
                                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="write_title margin_t">
                    <span class="title">室内图</span>
                </p>
                <div class="check">
                    <p class="check_title">已选图片</p>
                    <div class="check_img">
                        <div id="box" class="box" style="min-height:180px; margin:20px 0 0 10px;">
                            <div id="indoor" attr="10"></div>
                            <div class="parentFileBox">
                                <ul class="fileBoxUl">
                                    @if(!empty($info['indoor']))
                                        @foreach($info['indoor'] as $ghkey => $ghval)
                                            <li class="diyUploadHover">
                                                <div class="viewThumb">
                                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                                </div>
                                                <div class="diyCancel" ></div>
                                                <div class="diySuccess"></div>
                                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="write_title margin_t">
                    <span class="title">交通图</span>
                </p>
                <div class="check">
                    <p class="check_title">选择交通图片：提供&nbsp;<span class="colorfe imgnum"></span>&nbsp;张小区交通图供选择。 已选中&nbsp;<span class="colorfe selected">0</span>&nbsp;张</p>
                    <div class="check_img choose">
                        @if(!empty($cimginfo['traffic']))
                            @foreach($cimginfo['traffic'] as $key => $traffic)
                                <dl>
                                    <dt><img src="{{$traffic->fileName}}" /></dt>
                                    <dd><input type="checkbox" class="hit" id="traffic_{{$key}}" />{{$traffic->note}}</dd>
                                </dl>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="check">
                    <p class="check_title">已选图片</p>
                    <div class="check_img">
                        <div id="box" class="box" style="min-height:180px; margin:20px 0 0 10px;">
                            <div id="traffic" attr="11"></div>
                            <div class="parentFileBox">
                                <ul class="fileBoxUl">
                                    @if(!empty($info['traffic']))
                                        @foreach($info['traffic'] as $ghkey => $ghval)
                                            <li class="diyUploadHover">
                                                <div class="viewThumb">
                                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                                </div>
                                                <div class="diyCancel" ></div>
                                                <div class="diySuccess"></div>
                                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="write_title margin_t">
                    <span class="title">周边配套</span>
                </p>
                <div class="check">
                    <p class="check_title">选择周边配套图片：提供&nbsp;<span class="colorfe imgnum"></span>&nbsp;张小区周边配套图供选择。 已选中&nbsp;<span class="colorfe selected">0</span>&nbsp;张</p>
                    <div class="check_img choose">
                        @if(!empty($cimginfo['peripheral']))
                            @foreach($cimginfo['peripheral'] as $key => $peripheral)
                                <dl>
                                    <dt><img src="{{$peripheral->fileName}}" /></dt>
                                    <dd><input type="checkbox" class="hit" id="peripheral_{{$key}}" />{{$peripheral->note}}</dd>
                                </dl>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="check">
                    <p class="check_title">已选图片</p>
                    <div class="check_img">
                        <div id="box" class="box" style="min-height:180px; margin:20px 0 0 10px;">
                            <div id="peripheral" attr="12"></div>
                            <div class="parentFileBox">
                                <ul class="fileBoxUl">
                                    @if(!empty($info['peripheral']))
                                        @foreach($info['peripheral'] as $ghkey => $ghval)
                                            <li class="diyUploadHover">
                                                <div class="viewThumb">
                                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                                </div>
                                                <div class="diyCancel" ></div>
                                                <div class="diySuccess"></div>
                                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="write_title margin_t">
                    <span class="title">外景图</span>
                </p>
                <div class="check">
                    <p class="check_title">选择外景图片：提供&nbsp;<span class="colorfe imgnum"></span>&nbsp;张小区外景图供选择。 已选中&nbsp;<span class="colorfe selected">0</span>&nbsp;张</p>
                    <div class="check_img choose">
                        @if(!empty($cimginfo['waijing']))
                            @foreach($cimginfo['waijing'] as $key => $waijing)
                                <dl>
                                    <dt><img src="{{$waijing->fileName}}" /></dt>
                                    <dd><input type="checkbox" class="hit" id="waijing_{{$key}}" />{{$waijing->note}}</dd>
                                </dl>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="check">
                    <p class="check_title">已选图片</p>
                    <div class="check_img">
                        <div id="box" class="box" style="min-height:180px; margin:20px 0 0 10px;">
                            <div id="exterior" attr="8"></div>
                            <div class="parentFileBox">
                                <ul class="fileBoxUl">
                                    @if(!empty($info['waijing']))
                                        @foreach($info['waijing'] as $ghkey => $ghval)
                                            <li class="diyUploadHover">
                                                <div class="viewThumb">
                                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                                </div>
                                                <div class="diyCancel" ></div>
                                                <div class="diySuccess"></div>
                                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="write_title margin_t">
                    <span class="title">标题图</span>
                </p>
                <div class="check"  style="height:200px;">
                    <div class="check_img">
                        <div id="box" class="box" style="min-height:180px; margin:20px 0 0 10px;">
                            <div class="parentFileBox">
                                <ul class="fileBoxUl">
                                    @if(!empty($info['biaoti']))
                                        <li class="diyUploadHover">
                                            <div class="viewThumb">
                                                <img value="{{$info['biaoti'][0]->id}}" src="{{config('imgConfig.imgSavePath')}}{{$info['biaoti'][0]->fileName}}" id="title" attr="9">
                                                <input type="hidden" name="oldtitle" value="{{$info['biaoti'][0]->fileName}}">
                                            </div>
                                        </li>
                                    @else
                                        <li class="diyUploadHover">
                                            <div class="viewThumb">
                                                <img src="../../../image/img1.jpg" id="title" attr="9">
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="deleteImgId">
        <p class="submit">
            <input type="button" class="btn back_color release" value="保存" />
        </p>
        </form>
    </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">

$(function(){
    var deleteImgId = []; //待删除的图片id
    //
    $('.choose').each(function(){
        $(this).prev().find('.imgnum').html($(this).children().length);
    });
    $('.choose dl dd').bind('click',function(){
        $(this).parent().parent().prev().find('.selected').html($(this).parent().parent().find('.hit:checked').length);

        if ($(this).find('.hit').is(':checked')){
            var l_html = '<li class="diyUploadHover" id="s'+$(this).find('.hit').attr("id")+'"><div class="viewThumb"><img src="'+$(this).prev().find('img').attr("src")+'"></div><div class="diyCancel" ></div><div class="diySuccess"></div><div class="cz"><a class="setTitle">设置成标题图</a><input class="diyFileName" type="text" placeholder="别名"  value=""></div>';
            $(this).parents('.check').next().find('.fileBoxUl').append(l_html);
            $('.setTitle').bind('click',function(){
                $('#title').attr('src',$(this).parents('.diyUploadHover').find('.viewThumb img').attr('src'));
            });
        }else{
            //$(this).parents('.check').next().find('.fileBoxUl').removeChild('#imgss');
            $('#s'+$(this).find('.hit').attr("id")).remove();
        }

    })
    //点击图片删除事件
    $('.diyCancel').bind('click',deleteImg);
    function deleteImg(){
        deleteImgId.push($(this).parent().children('input.imageId').val());
        $('input[name=deleteImgId]').val(deleteImgId);
        $(this).parent().remove();
    }
    //获取图片地址
    function getImage(obj){
        var sonList = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').children();
        var images = [];
        var type = $(obj).attr('attr');
        if(sonList.length < 1){
            return false;
        }
        sonList.each(function(index){
            if( $(this).children('div.cz').children('.diyFileName').val() !=$(this).children('.imageNote').val() ){
                images[index] = {
                    img:$(this).children('div.viewThumb').children('img').attr('src'),
                    note:$(this).children('div.cz').children('.diyFileName').val(),
                    id:$(this).children('.imageId').val(),
                    type:type
                };
            }
        });
        return images;
    };
    //保存到待发布
    $('.release').bind('click',function(){
        //获取图片数据
        var leyout = getImage('#leyout');         //户型图
        var indoor = getImage('#indoor');         //室内图
        var traffic = getImage('#traffic');      //交通图
        var peripheral = getImage('#peripheral');       //配套图
        var exterior = getImage('#exterior');      //外景图
        var title = [];
        title[0] = {id:$('#title').attr('value'),img:$('#title').attr('src'),type:$('#title').attr('attr'),note:''};   //标题图
        $('input[name=leyout]').val(JSON.stringify(leyout));
        $('input[name=indoor]').val(JSON.stringify(indoor));
        $('input[name=traffic]').val(JSON.stringify(traffic));
        $('input[name=peripheral]').val(JSON.stringify(peripheral));
        $('input[name=exterior]').val(JSON.stringify(exterior));
        $('input[name=titleimg]').val(JSON.stringify(title));

        $.ajax({
            type:'post',
            url:$('#oldsale').attr('action'),
            data: $('#oldsale').serialize(),
            success:function(data){
                if(data == 1){
                    alert('保存成功');
                    window.location = document.referrer;
                }else{
                    alert('保存失败');
                }
            }
        });

    });
});
    /*
     * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
     * 其他参数同WebUploader
     */

    /* 上传图片 */

/* 户型图 */
$('#leyout').diyUpload({
    success:function( data ) {
        console.info( data );
    },
    error:function( err ) {
        console.info( err );
    },
    setId:'title'
});

/* 室内图 */
$('#indoor').diyUpload({
    success:function( data ) {
        console.info( data );
    },
    error:function( err ) {
        console.info( err );
    },
    setId:'title'
});

/* 交通图 */
$('#traffic').diyUpload({
    success:function( data ) {
        console.info( data );
    },
    error:function( err ) {
        console.info( err );
    },
    setId:'title'
});

/* 配套图 */
$('#peripheral').diyUpload({
    success:function( data ) {
        console.info( data );
    },
    error:function( err ) {
        console.info( err );
    },
    setId:'title'
});

/* 外景图 */
$('#exterior').diyUpload({
    success:function( data ) {
        console.info( data );
    },
    error:function( err ) {
        console.info( err );
    },
    setId:'title'
});

///* 标题图 */
//$('#title').diyUpload({
//    success:function( data ) {
//        console.info( data );
//    },
//    error:function( err ) {
//        console.info( err );
//    }
//});
</script>
</body>
</html>
