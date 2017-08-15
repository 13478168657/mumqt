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
        <a href="../../newBuildLibrary/add/buildList.htm"><i></i>创建新楼盘</a>
        <a href="../../newBuildLibrary/examine/via.htm"><i></i>审核新楼盘</a>
        <a href="../../newBuildLibrary/manage/buildManage.htm"><i></i>管理新楼盘</a>
      </p>
      <p class="p1"><span>现有楼盘库管理</span><i></i></p>
      <p class="p2">
        <a href="../../houseLibrary/enterRentHouse/buildList.htm"><i></i>创建现有楼盘</a>
        <a href="../../houseLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
        <a href="../../houseLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
      </p>
      <p class="p1"><span>增量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../newHouseLibrary/addNewHouse/addNewZz.htm"><i></i>录入新房房源</a>
        <a href="../../newHouseLibrary/newHouseManage/releaseing.htm"><i></i>管理新房房源</a>
      </p>
      <p class="p1 click"><span>存量房源库</span><i></i></p>
      <p class="p2" style="display:block;">
          <a href="/entryhouse/sale"><i></i>录入出售房源</a>
          <a href="/oldsalemanage"><i></i>管理出售房源</a>
          <a class="onclick" href="/entryhouse/rent"><i></i>录入出租房源</a>
          <a href="/oldrentmanage"><i></i>管理出租房源</a>
      </p>
      <p class="p1"><span>报表</span><i></i></p>
      <p class="p2">
        <a href="../../buildReport/yjReport.htm"><i></i>佣金报表</a>
        <a href="../../buildReport/buildReport.htm"><i></i>楼盘报表</a>
        <a href="../../buildReport/brokerReport.htm"><i></i>经纪人报表</a>
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
    <p class="right_title border_bottom">
        @if($class == 'sale')
            <a class="click">录入出售房源</a>
        @else
            <a class="click">录入出租房源</a>
        @endif
    </p>
      <form action="/old{{$class}}" method="post" id="entry">
       <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    <div class="write_msg" style="overflow:inherit;">
      <ul class="input_msg">
        <li>
            <input type="hidden" name="cityId"/>
            <input type="hidden" name="communityId" />
          <label><span class="dotted colorfe">*</span>楼盘名称：</label>
          <input type="text" name="name" class="txt width" id="sel"/>
          <dl class="build_list">

          </dl>
            <span class="tishi">没有对应楼盘</span>
            <input type="checkbox" class="radio" id="check">
        </li>
        <li class="xaddress" style="display:none">
          <label><span class="dotted colorfe">*</span>具体地址：</label>
          <span class="tishi margin_r"></span>
          <input type="text" name="address" class="txt width1 margin_r address" value="" readonly="readonly"/>
          <a>完善楼盘信息</a>
        </li>
        <li class="xhtype" style="display:none">
          <label><span class="dotted colorfe">*</span>物业类别：</label>
          <div class="dw margin_l margin_r">
              <input type="hidden" name="houseType1" />
            <a class="term_title"><span>请选择</span><i></i></a>
            <div class="list_tag" style="width:150px;">
               <p class="top_icon"></p>
               <ul class="type1">

               </ul>
             </div>

          </div>
            <div class="dw">
                <input type="hidden" name="houseType2" />
                <a class="term_title"><span>请选择</span><i></i></a>
                <div class="list_tag" style="width:150px;">
                    <p class="top_icon"></p>
                    <ul class="type2">

                    </ul>
                </div>

            </div>
        </li>
      </ul>
    </div>
    <div class="write_msg" id="no_build" style="overflow: inherit; display: none;">
              <ul class="input_msg">
                  <li class="xhtype1">
                      <label><span class="dotted colorfe">*</span>物业类别：</label>
                      <div class="dw margin_l margin_r">
                          <input type="hidden" name="houseType1" />
                          <a class="term_title"><span>请选择</span><i></i></a>
                          <div class="list_tag" style="width:150px;">
                              <p class="top_icon"></p>
                              <ul class="type1">
                                  <li id="1">普通住宅</li>
                                  <li id="4">商铺</li>
                                  <li id="3">写字楼</li>
                                  <li id="6">别墅</li>
                              </ul>
                          </div>

                      </div>
                      <div class="dw">
                          <input type="hidden" name="houseType2" />
                          <a class="term_title"><span>请选择</span><i></i></a>
                          <div class="list_tag" style="width:150px;">
                              <p class="top_icon"></p>
                              <ul class="type2">

                              </ul>
                          </div>

                      </div>
                  </li>
                  <li>
                      <label><span class="dotted colorfe">*</span>区域：</label>
                      <div class="sort_icon" style="margin-right:15px;">
                          <a class="term_title"><span>请选择区/县</span><i></i></a>
                          <input type="hidden" name="cityareaId" />
                          <div class="list_tag" style="width:150px;">
                              <p class="top_icon"></p>
                              <ul>
                                  @if(!empty($cityArea))
                                    @foreach($cityArea as $k=>$v)
                                          <li id="{{$k}}">{{$v}}</li>
                                    @endforeach
                                  @endif
                              </ul>
                          </div>
                      </div>
                      <div class="sort_icon">
                          <a class="term_title"><span>请选择商圈</span><i></i></a>
                          <input type="hidden" name="businessAreaId" />
                          <div class="list_tag" style="width:150px;">
                              <p class="top_icon"></p>
                              <ul>
                                  @if(!empty($businessTag))
                                      @foreach($businessTag as $k=>$v)
                                          <li id="{{$k}}">{{$v}}</li>
                                      @endforeach
                                  @endif
                              </ul>
                          </div>
                      </div>
                  </li>
                  <li style="margin-bottom:0;">
                      <label><span class="dotted colorfe">*</span>房源标题：</label>
                      <input class="txt width" type="text" name="title">
                  </li>
                  <li style="height:20px; margin-bottom:10px; overflow:hidden; line-height:20px;">
                      <label>&nbsp;</label>
                      <span class="colorfe">请勿填写公司名称、真实房源或最佳、唯一、独家、最新、最便宜、风水、升值等词汇。请勿填写"【】"、"*"等特殊字符。</span>
                  </li>
                  <li>
                      <label>内部编号：</label>
                      <input class="txt width2 cuo" type="text" name="internalNum">
                      <!--<i class="i click"></i>-->
                  </li>
                  <li>
                      <label>房源核验编号：</label>
                      <input class="txt width2" type="text" name="housingInspectionNum">
                      <span class="tishi colorfe">请填写建委房管部门的房源核验编号</span>
                  </li>
                  <li>
                      <label><span class="dotted colorfe">*</span>具体地址：</label>
                      <input class="txt width margin_r dizhi" type="text" name="address">
                      <input class="txt width3" type="text" name="houseNum">
                      <span class="tishi">门牌号</span>
                  </li>
              </ul>
          </div>

  <p class="submit">
      <a class="btn back_color" id="zz" style="float: left; margin-left: 200px; display: block;">开始创建</a>
      <a class="btn back_color"  id="ZZ" style="float: left; margin-left: 200px; display: none;">开始创建</a>
  </p>
      </form>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>

<script>
$(function(){
    //没有对应楼盘显示
    $("#check").click(function(){
        if($("#no_build").css("display")=="none"){
            $("#no_build").show();
            $("#zz").hide();
            $("#ZZ").show();
            //点击之后隐藏 地址和物业类型
            $('.xaddress').hide();
            $('.xhtype').hide();

        }else{
            $("#no_build").hide();
            $("#zz").show();
            $("#ZZ").hide();
        }
    });
    //下拉方法
    $(".input_msg .sort_icon").click(function (event) {
        $(".list_tag").hide();
        $(this).find(".list_tag").fadeIn();
        $(document).one("click", function () {//对document绑定一个影藏Div方法
            $(".list_tag").hide();
        });
        event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
    });
    $(".list_tag").click(function (event) {
        event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
    });
    $(".list_tag li").bind('click',buildclick);
    function buildclick(){
        $(this).parents(".sort_icon").find(".term_title span").text($(this).text());
        $(this).parents(".list_tag").hide();
        $(this).parent().parent().prev().val($(this).attr('id'));
    };
//开始创建 无楼盘名称
    $('#ZZ').bind('click',function(){

        if($('input[name=houseType1]').val() == ''|| $('input[name=houseType2]').val() == ''){
            alert('请选择物业类型');
            return false;
        }
        if($('input[name=cityareaId]').val() == ''|| $('input[name=businessAreaId]').val() == ''){
            alert('请选择区域');
            return false;
        }
        if($('input[name=title]').val() == ''){
            alert('请填写标题');
            return false;
        }
        if($('.dizhi').val() == ''|| $('input[name=houseNum]').val() == ''){
            alert('请填写地址和门牌号');
            return false;
        }
        $('#entry').attr('action',$('#entry').attr('action')+'2');
        $('#entry').submit();
    });
//开始创建 有楼盘名称
    $('#zz').bind('click',function(){
        if($('input[name=communityId]').val() == ''){
            alert('请正确填写楼盘名称');
            return false;
        }
        if($('input[name=houseType1]').val() == ''|| $('input[name=houseType2]').val() == ''){
            alert('请选择物业类型');
            return false;
        }

        $('#entry').submit();
    });
//楼盘名称搜索
    $('#sel').bind('input propertychange',function(){
        $.ajax({
            type:'get',
            url:'/getbuild',
            data:{name:$(this).val()},
            success:function(data){
                var result = '';
                for(var i=0;i<data.length;i++){
                    result += '<dd id="'+data[i].id+'" type="'+data[i].type1+'" dizhi="'+data[i].address+'" cityId="'+data[i].cityId+'" cityareaId="'+data[i].cityareaId+'" businessAreaId="'+data[i].businessAreaId+'">'+data[i].name+'</dd>';
                }
                $('.build_list').html(result);
                $('.build_list').show();
                $('.build_list dd').bind('click',buildxcy);
            }
        });
        return false;
    });
    //楼盘下拉选择
    function buildxcy(){
        $('input[name=name]').val($(this).html());
        $('input[name=cityId]').val($(this).attr('cityId'));
        $('input[name=cityareaId]').val($(this).attr('cityareaId'));
        $('input[name=businessAreaId]').val($(this).attr('businessAreaId'));
        $('input[name=communityId]').val($(this).attr('id'));
        //点击之后显示 地址和物业类型
        $('.xaddress').show();
        $('.xhtype').show();
        //地址
        var cityArea = <?=json_encode($cityArea)?>;
        var businessArea = <?=json_encode($businessArea)?>;
        var info = cityArea[$(this).attr('cityareaId')] +'['+businessArea[$(this).attr('businessAreaId')]+']';
        $('.xaddress .tishi').html(info);
        $('.address').val($(this).attr('dizhi'));
        var type = $(this).attr('type');
        var types = type.split("|");
        //物业类型1
        var housetype = <?=json_encode($type1)?>;
        var result= '';
        for(var i in types ){
            result += '<li id='+types[i]+'>'+housetype[types[i]]+'</li>';
        }
        $('.type1').html(result);
        $('.type1 li').bind('click',typelist);
        //物业类型2

        $('.build_list').hide();
    };
    $('.type1 li').bind('click',typelist);
    //物业类型下拉
    function typelist(){
        $(this).parents(".dw").find(".term_title span").text($(this).text());
        $(this).parents(".list_tag").hide();
        $('input[name=houseType1]').val($(this).attr('id'));
        //物业类型2
        var type2 = <?=json_encode($type2)?>;
        console.log(type2);
        var type2s = type2[$(this).attr('id')];
        var result2= '';
        for(var i in type2s ){
            result2 += '<li id='+i+'>'+type2s[i]+'</li>';
        }
        $('.type2').html(result2);
        $('input[name=houseType2]').val('');
        $('.type2 li').bind('click',function(){
            $(this).parents(".dw").find(".term_title span").text($(this).text());
            $(this).parents(".list_tag").hide();
            $('input[name=houseType2]').val($(this).attr('id'));
        });
    }

});
</script>
</body>
</html>
