<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>创建现有楼盘-商铺</title>
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
        <a href="../../newBuildLibrary/editDynamic/zzInfo.htm"><i></i>动态信息修改</a>
      </p>
      <p class="p1"><span>现有楼盘库管理</span><i></i></p>
      <p class="p2">
        <a href="../../houseLibrary/addNewHouse/buildList.htm"><i></i>创建现有楼盘</a>
        <a href="../../houseLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
        <a href="../../houseLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
      </p>
      <p class="p1 click"><span>增量房源库</span><i></i></p>
      <p class="p2" style="display:block;">
        <a href="/newhouse/house" ><i></i>录入新房房源</a>
        <a href="/newmanage" class="onclick"><i></i>管理新房房源</a>
      </p>
      <p class="p1"><span>存量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../oldHouseLibrary/enterSaleHouse/zzHouse.htm"><i></i>录入出售房源</a>
        <a><i></i>管理出售房源</a>
        <a href="../../oldHouseLibrary/enterRentHouse/zzHouse.htm"><i></i>录入出租房源</a>
        <a><i></i>管理出租房源</a>
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
      <a href="/newmanage/releaseing" class="<?=($type == 'releaseing')?'click':''?>">正在发布</a>
      <a href="/newmanage/releaseed" class="<?=($type == 'releaseed')?'click':''?>">待发布</a>
      <a href="/newmanage/expired" class="<?=($type == 'expired')?'click':''?>">已过期</a>
    </p>
    <div class="write_msg">
      <ul class="input_msg query_tj">
        <form action="/newmanage/{{$type}}" method="post" id="manage">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        <li>
          <label class="width4">楼盘名称：</label>
          <input type="hidden" name="communityId">
          <input type="text" class="txt width1" onfocus="$('.build_list').show();"/>
          <dl class="build_list" style="left:90px; width:205px;">
            <dd>远洋山水</dd>
            <dd>远洋新城</dd>
          </dl>
          <span class="tishi" style=" margin-left:20px;">时间段：</span>
          <input class="laydate-icon margin_r" id="kai" name="starttime" value="<?=!empty($starttime)?$starttime:''?>">
          <input class="laydate-icon" id="jiao" name="endtime" value="<?=!empty($endtime)?$endtime:''?>">
          <p class="query">
            <input type="button" class="btn back_color" value="查询"/>
          </p>
         </li>
         <li>
          <label class="width4">物业类型：</label>
          <input type="radio" class="radio" name="houseType1" <?=($houseType1 == 0)?'checked':''?> value="0"/>
          <span class="tishi">不限</span>
          <input type="radio" class="radio" name="houseType1" <?=($houseType1 == 1)?'checked':''?> value="1"/>
          <span class="tishi">普通住宅</span>
          <input type="radio" class="radio" name="houseType1" <?=($houseType1 == 6)?'checked':''?> value="6"/>
          <span class="tishi">别墅</span>
         </li>
          <input type="hidden" name="page" value="1">
        </form>
      </ul>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="600">楼盘信息</th>
          <th width="80">现价</th>
          <th width="80">原价</th>
          <th width="140">操作</th>
        </tr>

        @if(!empty($houses))
          @foreach($houses as $house)
        <tr>
          <td>
            <div class="build_list">
             <dl>
               <dt>
                <a href="#"><img src="/image/property_img.jpg"></a>
               </dt>
               <dd class="margin_l">
                 <p class="build_name"><a href="#" class="name">{{$house->title}}</a><a href="#" class="state subway">{{$housetypes[$house->houseType1]}}</a></p>
                 <p class="finish_data color8d">
                  <span>[北京-朝阳-百子湾]</span>&nbsp;&nbsp;
                  <span class="color8d"><span  class="address">{{$house->address}}</span><i class="map_icon"></i></span>
                 </p>
                 <p class="finish_data color8d">{{substr($house->roomStr,0,1)}}室{{substr($house->roomStr,2,1)}}厅{{substr($house->roomStr,4,1)}}卫{{substr($house->roomStr,6,1)}}厨  {{$faces[$house->faceTo]}}  {{$house->area}}㎡(建筑面积)</p>
                 <p class="finish_data color8d">创建时间：{{substr($house->timeCreate,0,10)}}</p>
               </dd>
             </dl>
            </div>
          </td>
          <td><span class="colorfe price1">{{$house->totalPrice}}万</span></td>
          <td><span class="price2">{{$house->oldTotalPrice}}万</span></td>
            @if($type !='expired')
            <td>
              <a href="/newhouse/<?=($house->houseType1=='1')?'house':'villa'?>/{{$house->id}}">编辑</a>&nbsp;&nbsp;
              @if($type == 'releaseing')
                <a href="reserve.htm">查看预定</a>
              @else
                <a class="fabu" attr="{{$house->id}}">发布</a>
              @endif
            </td>
            @else
            <td>—</td>
            @endif

        </tr>
          @endforeach
        <tr>
          <td colspan="4">
            <div class="page_nav">
              {!! $pagingHtml !!}
            </div>
          </td>
        </tr>
        @else
          <tr>
            <td colspan="4">
              <div class="page_nav">
                抱歉,没找到相应房源!
              </div>
            </td>
          </tr>
        @endif
      </table>
    </div>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<script>
;!function(){
  //搜索功能
  $('.btn').bind('click',function(){
    var communityId = $('input[name=communityId]').val();
    var starttime = $('input[name=starttime]').val();
    var endtime = $('input[name=endtime]').val();
    var houseType1 = $('input[name=houseType1]').val();
    if(starttime =='' && endtime ==''){
    }else{
      alert('请选择开始结束时间!');
      return false;
    }
    //提交
    $('#manage').submit();
  });
  //分页
  $('.page').bind('click',function(){
    $('input[name=page]').val($(this).attr('alt'));
    //提交
    $('#manage').submit();
  });
  //发布事件
  $('.fabu').bind('click',function(){
    var houseid = $(this).attr('attr');
    if(houseid !=''){
      $.ajax({
        type:'get',
        url:'/release',
        data:{houseid:houseid},
        success:function(data){
          if(data == 1){
            alert('发布成功!');
            window.location = '/newmanage/releaseed';
          }else{
            alert('发布失败!');
          }
        }
      });
    }
  });
  laydate({
	 elem: '#kai'
  }),
  laydate({
	 elem: '#jiao'
  })
}();
</script>
</body>
</html>
