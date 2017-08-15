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
        <a href="../../newBuildLibrary/editDynamic/zzInfo.htm"><i></i>动态信息修改</a>
      </p>
      <p class="p1"><span>现有楼盘库管理</span><i></i></p>
      <p class="p2">
        <a href="../../houseLibrary/enterSaleHouse/buildList.htm"><i></i>创建现有楼盘</a>
        <a href="../../houseLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
        <a href="../../houseLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
      </p>
      <p class="p1"><span>增量房源库</span><i></i></p>
      <p class="p2">
          <a href="/newhouse/house" class="onclick"><i></i>录入新房房源</a>
          <a href="/newmanage" ><i></i>管理新房房源</a>
      </p>
      <p class="p1 click"><span>存量房源库</span><i></i></p>
      <p class="p2" style="display:block;">
          <a href="/entryhouse/sale"><i></i>录入出售房源</a>
          <a href="/oldsalemanage"><i></i>管理出售房源</a>
          <a class="onclick" href="/entryhouse/rent"><i></i>录入出租房源</a>
          <a href="/oldrentmanage"><i></i>管理出租房源</a>
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
            <a class="click">管理出售房源</a>
        @else
            <a class="click">管理出租房源</a>
        @endif
    </p>
      <div class="title_msg">
          <div class="manage">
              <div class="num">
                  <span class="span1">刷新量：</span>
                  <div class="problem">
                      <a class="term_title"><i></i></a>
                      <div style="display: none;" class="list_tag">
                          <p class="top_icon"></p>
                          <p class="info">楼盘简拼不是楼盘全拼，应该为wkwkc</p>
                      </div>
                  </div>
                  <span class="span2">已使用&nbsp;&nbsp;<span class="colorfe fontA">47</span></span>
                  <span class="span3">还可使用&nbsp;&nbsp;<span class="colorfe fontA">313</span></span>
              </div>
              <div class="num">
                  <span class="span1">预约执行量：</span>
                  <span class="span2">可执行&nbsp;&nbsp;<span class="colorfe fontA">47</span></span>
                  <span class="span3">还可执行&nbsp;&nbsp;<span class="colorfe fontA">313</span></span>
              </div>
              <div class="num">
                  <span class="span1">预约设置量：</span>
                  <span class="span2"><span class="colorfe fontA">360</span>次</span>
                  <span class="span3">预约套数&nbsp;&nbsp;<span class="colorfe fontA">12</span>套</span>
              </div>
              <div class="clear"></div>
          </div>
          <div class="manage">
              <div class="num">
                  <span class="span1">发布量：</span>
                  <div class="problem">
                      <a class="term_title"><i></i></a>
                      <div style="display: none;" class="list_tag">
                          <p class="top_icon"></p>
                          <p class="info">楼盘简拼不是楼盘全拼，应该为wkwkc</p>
                      </div>
                  </div>
                  <span class="span2">已使用&nbsp;&nbsp;<span class="colorfe fontA">47</span></span>
                  <span class="span3">还可使用&nbsp;&nbsp;<span class="colorfe fontA">313</span></span>
              </div>
              <div class="num">
                  <span class="span1">即将过期：</span>
                  <span class="span2"><span class="colorfe fontA">0</span></span>
                  <span class="span1">本月过期:</span>
                  <span class="span2 colorfe fontA">&nbsp;0</span>
                  <span class="span1">已发布:</span>
                  <span class="span2 colorfe fontA">&nbsp;0</span>
                  <span class="span1">还可重新发布:</span>
                  <span class="span2 colorfe fontA">&nbsp;4</span>
              </div>
              <div class="clear"></div>
          </div>
          <div class="bq">
              <span class="title">可用标签：</span>
              <span class="tag_img"><img src="../../../image/email1.png" height="30" width="30">（在用<span>&nbsp;0&nbsp;</span>&nbsp;/&nbsp;可用<span>&nbsp;0&nbsp;</span>）</span>
              <span class="tag_img"><img src="../../../image/email1.png" height="30" width="30">（在用<span>&nbsp;0&nbsp;</span>&nbsp;/&nbsp;可用<span>&nbsp;0&nbsp;</span>）</span>
              <span class="tag_img"><img src="../../../image/email1.png" height="30" width="30">（在用<span>&nbsp;0&nbsp;</span>&nbsp;/&nbsp;可用<span>&nbsp;0&nbsp;</span>）</span>
          </div>
      </div>
    <div class="write_msg">
      <p class="manage_title">
          <a href="/old{{$class}}manage/releaseing" class="<?=($type == 'releaseing')?'click':''?>">已发布</a>
          <a href="/old{{$class}}manage/releaseed" class="<?=($type == 'releaseed')?'click':''?>">待发布（220）</a>
          <a href="/old{{$class}}manage/expired" class="<?=($type == 'expired')?'click':''?>">已过期（220）</a>
          <a href="/old{{$class}}manage/rules" class="<?=($type == 'rules')?'click':''?>">违规（220）</a>
      </p>
        <form action="/old{{$class}}manage/{{$type}}" method="post" id="oldhouse">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >
            <input type="hidden" name="page" value="1">
      <ul class="input_msg query_tj">
        <li class="margin_b">
          <label class="width4">房源编号：</label>
          <input type="text" class="txt width2" name="id" value="<?=!empty($id)?$id:''?>"/>
          <label class="width4">内部编号：</label>
          <input type="text" class="txt width2" name="internalNum" value="<?=!empty($internalNum)?$internalNum:''?>"/>
          <label class="width4">物业名称：</label>
          <input type="text" class="txt width2 margin_r" name="propertyName"/>
          <label class="width3">价格：</label>
          <input type="text" class="txt width3" name="startprice" value="<?=!empty($startprice)?$startprice:''?>"/>
          <span class="tishi" style="margin-right:5px;">—</span>
          <input type="text" class="txt width3" name="endprice" value="<?=!empty($endprice)?$endprice:''?>"/>
          <span class="tishi">万元</span>
          <p class="query" style="margin-left:0;">
            <input type="button" class="btn back_color search" value="查询"/>
          </p>
        </li>
        <li>
          <div class="sort_icon margin_left margin_r sort">
            <a class="term_title"><span>默认排序</span><i></i></a>
              <input type="hidden" name="order">
            <div class="list_tag" style="width:200px;">
               <p class="top_icon"></p>
               <ul>
                 <li>默认排序</li>
                 <li id="timeCreate_desc">最后录入时间</li>
                 <li id="timeCreate_asc">最早录入时间</li>
                   @if($type == 'releaseing')
                 <li id="">最后刷新时间</li>
                 <li id="">最早刷新时间</li>
                   @endif
                 <li id="area_asc">面积由小到大</li>
                 <li id="area_desc">面积由大到小</li>
               </ul>
             </div>
          </div>
            @if(($type == 'releaseing')||($type == 'releaseed'))
          <div class="dw margin_r sort">
            <a class="term_title"><span>全部类型</span><i></i></a>
              <input type="hidden" name="houseType1">
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>全部类型</li>
                 <li id="1">住宅</li>
                 <li id="6">别墅</li>
                 <li id="3">写字楼</li>
                 <li id="4">商铺</li>
               </ul>
             </div>
          </div>
            @endif
            @if($type == 'releaseing')
          <div class="sort_icon margin_r sort">
            <a class="term_title"><span>全部房源</span><i></i></a>
              <input type="hidden" name="order">
            <div class="list_tag" style="width:200px;">
               <p class="top_icon"></p>
               <ul>
                   <li>全部房源</li>
                   <li>真房源</li>
                   <li>独代房源</li>
                   <li>预约房源</li>
                   <li>非预约房源</li>
                   <li>标签房源</li>
                   <li>将过期房源</li>
               </ul>
             </div>
          </div>
          <div class="dw margin_r sort">
            <a class="term_title"><span>全部楼盘</span><i></i></a>
              <input type="hidden" name="communityId">
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>全部楼盘</li>
                 <li>早安北京</li>
                 <li>五矿万科城</li>
               </ul>
             </div>
          </div>
            @endif
          <div class="dw margin_r sort">
            <a class="term_title"><span>@if(!empty($houseRoom)){{$models[$houseRoom]}}@else全部户型@endif</span><i></i></a>
              <input type="hidden" name="houseRoom">
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>全部户型</li>
                 <li id="1">1居</li>
                 <li id="2">2居</li>
                 <li id="3">3居</li>
                 <li id="4">4居</li>
                 <li id="5">5居</li>
                 <li id="6">5居以上</li>
               </ul>
             </div>
          </div>
        </li>
      </ul>
        </form>
    </div>
    <div class="examine">
      <table class="audit house_list">
        <tr>
          <th width="5%">选中</th>
          <th>基本信息</th>
           @if($type == 'releaseing')
          <th width="15%">
            点击量<br />
            昨日↑&nbsp;&nbsp;&nbsp;上周↑&nbsp;&nbsp;&nbsp;本月↑
          </th>
          <th width="10%">自动刷新</th>
          <th width="10%">管理</th>
          <th width="10%">标签</th>
          @elseif(($type == 'releaseed') || ($type == 'expired'))
          <th width="10%">操作</th>
          @elseif($type == 'rules')
          <th width="8%">操作</th>
          <th width="10%">违规原因</th>
          @endif
        </tr>
  @if(!empty($houses))

      @foreach($houses as $house)
        <tr class="no_border">
          <td><input type="checkbox" name="check" value="{{$house->id}}"/></td>
          <td>
            <div class="home_list">
             <dl>
               <dt>
                <a href="../../Details/DetailsHousing_R/esfSaleHouseDetail.htm"><img src="/image/property_img.jpg"></a>
                <a href="#" class="img_num"><i></i><span>11</span></a>
               </dt>
               <dd class="margin_l">
                 <p class="build_name"><a href="" class="name">{{$house->title}}</a><span>[ {{$housetypes[$house->houseType1]}} ]</span>
                     @if($type == 'releaseing')
                         @if(!empty($house->isRealHouse))<span class="school">真</span>@endif
                         @if(!empty($house->isSoloAgent))<span class="tag">独代</span>@endif
                     @endif
                 </p>
                 <p class="home_num color8d">
                     @if(($house->houseType1 !=3)&&($house->houseType1 != 4))
                  <span><span class="fontA">{{substr($house->roomStr,0,1)}}</span>室<span class="fontA">{{substr($house->roomStr,2,1)}}</span>厅</span>
                  <span>&nbsp;|&nbsp;</span>
                     @endif
                  <span>{{$house->area}}平</span>
                  <span>&nbsp;|&nbsp;</span>
                   @if(($house->houseType1 !=3)&&($house->houseType1 !=4))
                  <span>{{$faces[$house->faceTo]}}</span>
                  <span>&nbsp;|&nbsp;</span>
                   @endif
                 @if($class == 'sale')
                   @if($house->houseType1 !=3)
                  <span>{{$house->price2}}万</span>
                   @else
                    <span>{{$house->price1}}元/平米</span>
                   @endif
                 @else
                   <span>{{$house->price1}}{{$priceUnits[$house->priceUnit]}}</span>
                 @endif
                 </p>
                 <p class="finish_data color8d">
                  <span class="color8d">{{$house->name}}</span>
                 </p>
               </dd>
             </dl> 
            </div>
          </td>
            @if($type == 'releaseing')
          <td><span class="margin_r">0</span><span class="margin_r">2</span>6</td>
          <td>
              <a href="/old{{$class}}appointment/{{$house->id}}">预约</a>
          </td>
          <td>
            <a href="/old{{!empty($house->communityId)?$class:$class.'2'}}/{{$house->id}}">修改</a>&nbsp;&nbsp;<a class="refresh" attr="{{$house->id}}">刷新</a><br />
            <a href="/editimage{{$class}}/{{$house->id}}/{{$house->communityId}}">改图</a>&nbsp;&nbsp;<a class="xiajia" attr="{{$house->id}}" >下架</a><br />

          </td>
          <td class="setup" attr="{{$house->id}}">
            <a attr="isRealHouse_{{$house->isRealHouse}}">@if(!empty($house->isRealHouse))取消真房源@else设置真房源@endif</a><br />
            <a attr="isSoloAgent_{{$house->isSoloAgent}}">@if(!empty($house->isSoloAgent))取消独代@else设置独代@endif</a><br />
            {{--<a>设置加急房源</a><br />--}}
            {{--<a>设置新房源</a>--}}
          </td>
           @elseif($type == 'releaseed')
            <td><a class="fabu" attr="{{$house->id}}" >发布</a>&nbsp;&nbsp;<a href="/old{{!empty($house->communityId)?$class:$class.'2'}}/{{$house->id}}">修改</a><br><a href="/editimage{{$class}}/{{$house->id}}/{{$house->communityId}}">改图</a></td>
           @elseif($type == 'expired')
            <td><a class="fabu" attr="{{$house->id}}">重新发布</a>&nbsp;&nbsp;<a href="/old{{!empty($house->communityId)?$class:$class.'2'}}/{{$house->id}}">修改</a></td>
           @elseif($type == 'rules')
            <td><a class="fabu" attr="{{$house->id}}">重新发布</a>&nbsp;&nbsp;<a href="/old{{!empty($house->communityId)?$class:$class.'2'}}/{{$house->id}}">修改</a></td>
                <td>图片有水印，无法发布</td>
           @endif
        </tr>
        <tr class="height">
          <td colspan="6">
           <span class="id">({{$house->id}}){{$house->internalNum}}</span>
           <div class="break">
            <span>发布时间：</span>
            <span>{{substr($house->timeCreate,0,10)}}</span>&nbsp;&nbsp;
            <span>最新更新时间：</span>
            <span>{{substr($house->timeUpdate,0,10)}}</span>&nbsp;&nbsp;
            @if($type == 'releaseing')<span class="colorfe">已刷新<a href="smallPage/orderDetailDay.htm"></a></span>@endif
           </div>
          </td>
        </tr>
      @endforeach
  @else
    <tr><td>没有对象的房源</td></tr>
  @endif
        <tr>
          <td>
              <input type="checkbox" class="check_all" value="" name="check" id="all" onclick="cli('check');"/>&nbsp;&nbsp;全选
          </td>
          <td colspan="5">
            <div class="page_nav" style="float:right;">
              <ul>
{!! $pagingHtml !!}
              </ul>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="submit pl">
        @if($type == 'releaseing')
      <input type="button" class="btn back_color" attr="refresh" value="批量刷新" />
      <input type="button" class="btn back_color" attr="bespeak" value="批量预约" />
      <input type="button" class="btn back_color" attr="nbespeak" value="取消预约" />
      <input type="button" class="btn back_color" attr="shelves" value="批量下架" />
        @elseif($type == 'releaseed')
        <input type="button" class="btn back_color" attr="release" value="发布房源" />
        <input type="button" class="btn back_color" attr="delete" value="删除房源" />
        @else
         <input type="button" class="btn back_color" attr="delete" value="删除房源" />
        @endif
    </div>
    <div class="prompt">
      <p>
       友情提示：<br /> 
        1.房源取消发布后，可在待发布列表进行删除，删除后不能恢复。<br /> 
        2.房源取消发布后，不在店铺页面以及网站搜索结果中显示，可到待发布房源栏目中重新发布。<br /> 
        3.每日房源发布量统计周期为当日的00:30起至次日的00:30。00:30~01:00为系统更新时间，不建议进行房源管理。
      </p>
    </div>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script>
$(function(){
//搜索提交
    $('.search').bind('click',function(){
        //检测价格格式
        if(priceCheck() == false){
            return false;
        }
        $('#oldhouse').submit();
        console.log($('#oldhouse').serialize());
    });
//分页
    $('.page').bind('click',function(){
        $('input[name=page]').val($(this).html());
        $('#oldhouse').submit();
    });

    //检测价格
    function priceCheck(){
        var startprice = $('input[name=startprice]').val();
        var endprice = $('input[name=endprice]').val();
        if(startprice =='' && endprice ==''){
            return true;
        }else{
            var temp=/^\d+(\.\d+)?$/;
            if(temp.test(startprice)==false || temp.test(endprice)==false){
                alert("价格输入格式错误");
                return false;
            }
            if(startprice > endprice){
                alert('开始价格不能大于结束价格!');
                return false;
            }
        }
    };
    //排序下拉
    $(".input_msg .sort").click(function (event) {
        $(".list_tag").hide();
        $(this).find(".list_tag").fadeIn();
        $(document).one("click", function () {//对document绑定一个影藏Div方法
            $(".list_tag").hide();
        });
        event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
    });
    $(".list_tag li").bind('click',buildclick);
    $(".list_tag").click(function (event) {
        event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
    });

    //排序下拉内容点击方法
    function buildclick(){
        $(this).parents(".sort_icon").find(".term_title span").text($(this).text());
        $(this).parents(".list_tag").hide();
        $(this).parent().parent().prev().val($(this).attr('id'));
        $('#oldhouse').submit();
    };
    //发布事件
    $('.fabu').bind('click',function(){
        var houseid = $(this).attr('attr');
        if(houseid !=''){
            $.ajax({
                type:'get',
                url:'/status{{$class}}/release',
                data:{id:houseid},
                success:function(data){
                    if(data == 1){
                        alert('发布成功!');
                        window.location = '/old{{$class}}manage/releaseed';
                    }else{
                        alert('发布失败!');
                    }
                }
            });
        }
    });
    //刷新事件
    $('.refresh').bind('click',function(){
        var houseid = $(this).attr('attr');
        if(houseid !=''){
            $.ajax({
                type:'get',
                url:'/status{{$class}}/refresh',
                data:{id:houseid},
                success:function(data){
                    if(data == 1){
                        alert('刷新成功!');
                        window.location = '/oldsalemanage/releaseing';
                    }else if(data == 2){
                        alert('今天刷新房源数己用完,请明天再试');
                    }else{
                        alert('刷新失败!');
                    }
                }
            });
        }
    });
    //下架事件
    $('.xiajia').bind('click',function(){
        var houseid = $(this).attr('attr');
        if(houseid !=''){
            $.ajax({
                type:'get',
                url:'/status{{$class}}/shelves',
                data:{id:houseid},
                success:function(data){
                    if(data == 1){
                        alert('下架成功!');
                        window.location = '/oldsalemanage/releaseing';
                    }else{
                        alert('下架失败!');
                    }
                }
            });
        }
    });
    //设置房源标签
    $('.setup a').bind('click',function(){
        var houseid = $(this).parent().attr('attr');
        var attribute = $(this).attr('attr');
        if(houseid !=''){
            $.ajax({
                type:'get',
                url:'/status{{$class}}/setup',
                data:{id:houseid,attribute:attribute},
                success:function(data){
                    if(data == 1){
                        alert('设置成功!');
                        window.location = '/oldsalemanage/releaseing';
                    }else{
                        alert('设置失败!');
                    }
                }
            });
        }
    });
    //批量操作
    $('.submit input').bind('click',function(){
        var type = $(this).attr('attr');
        var s = [];
        $("input[name='check']:checked").each(function(){
            if($(this).val() !=''){
                s.push($(this).val());
            }
        });
        if(s ==''){
            alert('请选择房源!');
            return false;
        }
        $.ajax({
            type:'get',
            url:'/status{{$class}}/'+type,
            data:{id:s},
            success:function(data){
                if(data == 1){
                    alert('操作成功!');
                    document.location.reload();
                }else if(data == 2){
                    alert('今天刷新房源数己用完,请明天再试');
                }else{
                    alert('操作失败!');
                }
            }
        });
    });



})
</script>
<script>
$(document).ready(function(e) {	
    $(".num .problem").click(function (event) {
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
});
</script>
<script>
    function cli(Obj)
    {
        var collid = document.getElementById("all")
        var coll = document.getElementsByName(Obj)
        if (collid.checked){
            for(var i = 0; i < coll.length; i++)
                coll[i].checked = true;
        }else{
            for(var i = 0; i < coll.length; i++)
                coll[i].checked = false;
        }
    }
</script>
</body>
</html>
