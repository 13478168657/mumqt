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
      <dd>miaoqing20101</dd>
    </dl>
    <div class="subnav">
      <p class="p1"><span>增量楼盘库</span><i></i></p>
      <p class="p2">
        <a href="../../../newBuildLibrary/add/buildList.htm"><i></i>新楼盘创建</a>
        <a href="../../../examine/via.htm"><i></i>新楼盘审核</a>
        <a href="../../../manage/buildManage.htm"><i></i>新楼盘管理</a>
        <a href="../../../examineDynamic/viaing.htm"><i></i>变动信息审核</a>
      </p>
      <p class="p1"><span>增量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../../newHouseLibrary/addNewHouse/addNewZz.htm"><i></i>录入新房房源</a>
        <a href="../../../newHouseLibrary/newHouseManage/releaseing.htm"><i></i>管理新房房源</a>
      </p>
      <p class="p1"><span>存量楼盘库</span><i></i></p>
      <p class="p2">
        <a href="../../../houseLibrary/addNewHouse/buildList.htm"><i></i>现有楼盘创建</a>
        <a href="../../../houseLibrary/examine/via.htm"><i></i>现有楼盘审核</a>
        <a href="../../../houseLibrary/manage/buildManage.htm"><i></i>现有楼盘管理</a>
      </p>
      <p class="p1 click"><span>存量房源库</span><i></i></p>
      <p class="p2" style="display:block;">
        <a href="../../enterSaleHouse/comment.htm"><i></i>录入出售房源</a>
        <a href="../releaseing.htm" class="onclick"><i></i>管理出售房源</a>
        <a href="../../enterRentHouse/comment.htm"><i></i>录入出租房源</a>
        <a href="../../rentHouseManage/releaseing.htm"><i></i>管理出租房源</a>
      </p>
      <p class="p1"><span>报表</span><i></i></p>
      <p class="p2">
        <a href="../../../buildReport/yjReport.htm"><i></i>佣金报表</a>
        <a href="../../../buildReport/buildReport.htm"><i></i>楼盘报表</a>
        <a href="../../../buildReport/brokerReport.htm"><i></i>经纪人报表</a>
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
      <a class="click">设置预约刷新</a>
    </p>
    <div class="write_msg">
      <ul class="input_msg">
        <li>
          <label class="width4">选择方案：</label>
          <div class="dw" style=" margin-left:0;">
            <a class="term_title"><span>请选择</span><i></i></a>
            <div class="list_tag">
              <p class="top_icon"></p>
              <ul>
                <li>请选择</li>
                <li>方案一</li>
                <li>方案二</li>
                <li>方案三</li>
              </ul>
            </div>
          </div>
        </li>
        <li>
          <label class="width4">自定义方案：</label>
          <div class="order">
            @if(!empty($models))
              @foreach($models as $model)
              <a class="subway" href="/old{{$class}}appointment/{{$houseid}}m{{$model->id}}">{{$model->name}}</a>
              @endforeach
            @endif
          </div>
          <a href="selectYy.htm" class="color_blue">修改模板</a>
        </li>
      </ul>
    </div>
    <div class="chose_time">
      <p class="chose">选择时间</p>
      <p class="p1" id="hour">
        <span class="title">选择小时：</span>
        @for($i=1;$i<17;$i++)
          @if(!empty($detail[str_pad($i+7,2,0,STR_PAD_LEFT)]))
            <a onclick="setContentTab('con_a_{{$i}}')" class="click">{{str_pad($i+7,2,0,STR_PAD_LEFT)}}点</a>
          @else
            <a onclick="setContentTab('con_a_{{$i}}')">{{str_pad($i+7,2,0,STR_PAD_LEFT)}}点</a>
          @endif
        @endfor
      </p>
      @for($i=1;$i<17;$i++)
        @if(!empty($detail[str_pad($i+7,2,0,STR_PAD_LEFT)]))
          <p class="p1 p2" id="con_a_{{$i}}" style="display:block;">
        @else
          <p class="p1 p2" id="con_a_{{$i}}" style="display:none;">
        @endif
          @if($i == 1)
            <span class="title">选择分钟：</span>
          @else
            <span class="title">&nbsp;</span>
          @endif
          <span class="colorfe">{{str_pad($i+7,2,0,STR_PAD_LEFT)}}点</span>
          @for($j=0;$j<12;$j++)
            @if(!empty($detail[str_pad($i+7,2,0,STR_PAD_LEFT)]) &&(in_array(str_pad($j*5,2,0,STR_PAD_LEFT),$detail[str_pad($i+7,2,0,STR_PAD_LEFT)])))
                <a class="click">{{str_pad($j*5,2,0,STR_PAD_LEFT)}}分</a>
            @else
              <a>{{str_pad($j*5,2,0,STR_PAD_LEFT)}}分</a>
            @endif
          @endfor
        </p>
      @endfor
    </div>
    <div class="write_msg" style="overflow:inherit;">
      <ul class="input_msg">
        <li class="chose">
          <label style="width:60px;">选择天数</label>
          <div class="dw leyout" style="margin-left:0; height:25px;">
            <a class="term_title"><span>今天</span><i></i></a>
            <input type="hidden" name="execDate" value="1">
            <div class="list_tag select_width">
              <p class="top_icon"></p>
              <ul>
                <li id="1">今天</li>
                <li id="2">2天</li>
                <li id="3">3天</li>
                <li id="4">4天</li>
                <li id="5">5天</li>
                <li id="6">6天</li>
                <li id="7">7天</li>
              </ul>
            </div>
          </div>
          <input type="hidden" name="setup" value="0">
          <input type="hidden" name="remaining" value="10">
          <span class="time color8d">本次已预约：<span class="setup">0</span>条&nbsp;&nbsp;您还可以设置：<span class="remaining">10</span>条&nbsp;&nbsp;您还可以设置：29个时间点</span>
        </li>
      </ul>
    </div>
    <p class="submit">
      @if(empty($m))
      <a class="btn back_color modaltrigger" href="#mb">保存为模板</a>
      @endif
      <input type="button" class="btn back_color submitapp" value="保存" />
    </p>
  </div>
</div>
<div class="main_r add"  id="mb">
  <h2>添加预约模板</h2>
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <div class="write_msg" style="width:400px;">
    <ul class="input_msg">
      <li>
        <label>模板名称：</label>
        <input type="text" class="txt width2" name="template" />
      </li>
      <li style="overflow:hidden; height:auto;">
        <input type="button" class="btn back_color width4 template" style="margin:20px 0 0 150px !important;" value="提交" />
      </li>
    </ul>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script>
  $(function(){
    //保存
    $('.submitapp').bind('click',function(){
      var s = '';//
      var execDate = $('input[name=execDate]').val();
      $('.p2 a.click').each(function(){
        var hour = $(this).parent().find('.colorfe').html().substr(0,2);
        var minute = $(this).html().substr(0,2);
        s += hour+minute +'|';
      });
      if(s == ''){
        alert('请选择时间点');
        return false;
      }
      $.ajax({
        type:'post',
        url:'/old{{$class}}appointment/{{$houseid}}',
        data:{_token:'{{csrf_token()}}',detail:s,execDate:execDate},
        success:function(data){
          if(data == 1){
            alert('保存成功!');
            //window.location = '/old{{$class}}manage/releaseed';
          }else{
            alert('保存失败!');
          }
        }
      });
    });
    //保存为模板
    $('.template').bind('click',function(){

      var s = '';//
      var tname = $('input[name=template]').val();
      if(tname == ''){
        alert('模板名不能为空');
        return false;
      }
      $('.p2 a.click').each(function(){
        var hour = $(this).parent().find('.colorfe').html().substr(0,2);
        var minute = $(this).html().substr(0,2);
        s += hour+minute +'|';
      });

      if(s == ''){
        alert('请选择时间点');
        return false;
      }
      $.ajax({
        type:'post',
        url:'/old{{$class}}appointment/{{$houseid}}m',
        data:{_token:'{{csrf_token()}}',detail:s,name:tname},
        success:function(data){
          if(data == 1){
            alert('保存模板成功!');
            //window.location = '/old{{$class}}manage/releaseed';
          }else{
            alert('保存模板失败!');
          }
        }
      });
    });
    //下拉层点击方法
    $(".list_tag li").bind('click',buildclick);
    function buildclick(){
      var setup = $('input[name=setup]').val()*$(this).attr('id');
      if((parseInt($('input[name=remaining]').val()) - setup) < 0){
        alert('可用预约次数已不够用,请重新选择');
        return false;
      }
      $(this).parents(".sort_icon").find(".term_title span").text($(this).text());
      $(this).parents(".list_tag").hide();
      $(this).parent().parent().prev().val($(this).attr('id'));
      xsetup();
    };

    //弹出层调用语句
    $('.modaltrigger').leanModal({
      top:110,
      overlay:0.45,
      closeButton:".hidemodal"
    });

    $(".main_r .order a").click(function(){
      $(this).addClass("click").siblings(".order a").removeClass("click");
    });

    $("#hour a").click(function(){
      $(this).toggleClass("click");
    });

    $(".main_r .p2 a").click(function(){
      $(this).toggleClass("click");
      xsetup()
//      var setup = $(this).parent().parent().find('.p2 a.click').length;
//      $('input[name=setup]').val(setup);
//      $('.setup').text(setup);
//      $('.remaining').text(parseInt($('input[name=remaining]').val())-setup);
    });


  });
  //计算剩余次数
  function xsetup(){
    var setup = $('.chose_time').find('.p2 a.click').length;
    $('input[name=setup]').val(setup);
    $('.setup').text($('input[name=setup]').val()*$('input[name=execDate]').val());
    $('.remaining').text(parseInt($('input[name=remaining]').val())-$('.setup').text());
  }
  //设置显示隐藏
  function setContentTab(minId){
    $("#" + minId).toggle();
    $("#" + minId).find("a").removeClass("click");
    xsetup();
  }
</script>
</body>
</html>
