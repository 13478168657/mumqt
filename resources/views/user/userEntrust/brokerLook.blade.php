@extends('mainlayout')
@section('title')
    <title>个人后台</title>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/personalManage.css?v={{Config::get('app.version')}}">
    {{--  <link rel="stylesheet" type="text/css" href="/css/personalHoutai.css?v={{Config::get('app.version')}}">--}}
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="http://sandbox.runjs.cn/uploads/rs/351/8eazlvc1/imgareaselect-anima.css" />
@endsection
@section('content')
   <div class="user">
        @include('user.userHomeLeft')
  <div class="user_r">
    <div class="build_list sale">
     <dl>
       <dd class="width1">
         <p class="finish_data color8d">
          <span class="color2d">
              @if($type == 'rent')
                  @if($house->houseType1 == 3)
                      [租房]
                  @elseif($house->houseType1 == 2)
                      [楼租]
                  @elseif($house->houseType1 == 1)
                      [铺租]
                  @endif
              @endif
              @if($type == 'sale')
                  @if($house->houseType1 == 3)
                      [二手房]
                  @elseif($house->houseType1 == 2)
                      [楼售]
                  @elseif($house->houseType1 == 1)
                      [铺售]
                  @endif
              @endif
          </span>
          <a href="#"><strong>{{$house->name}}</strong></a>&nbsp;&nbsp;
          <span class="color8d">{{$house->addr}}<i class="map_icon"></i></span>
         </p>
         <p class="build_type color8d">
           @if($type == 'rent' && $house->houseType1 == 3)
              <span>@if(isset(config('houseState.Zz.rentType')[$house->rentType])){{config('houseState.Zz.rentType')[$house->rentType]}}@endif</span>
              <span class="margin_l">{{$house->area}}平米</span>
           @else
              <span>{{$house->area}}平米</span>
           @endif

           @if($house->houseType1 == 3)
              <?php
                 $room = explode('_',$house->roomStr);
              ?>
              <span class="margin_l">@if(!empty($house->roomStr)){{$room[0]}}室{{$room[1]}}厅@endif</span>
              <span class="margin_l">@if(isset(config('faceToConfig')[$house->faceTo])){{config('faceToConfig')[$house->faceTo]}}@endif</span>
           @endif
           <span class="margin_l">{{$house->currentFloor}}/{{$house->totalFloor}}层</span>
           @if($type == 'sale')
              <span class="margin_l">{{floor($house->price1)}}元/平米</span>
           @endif
           @if($type == 'rent')
               @if($house->houseType1 == 2 || $house->houseType1 == 1)
                    <span class="margin_l">{{floor($house->price1)}}元/平米</span>
               @endif
           @endif
         </p>
         <p class="build_type color8d">
             <span>发布时间：</span>
             <span>{{substr($house->timeCreate,0,10)}}</span>
             <span class="margin_l">
               <?php
                $timeDiff = time() - strtotime($house->timeUpdate);
                if($timeDiff < 60){
                    $time = $timeDiff.'秒前';
                }elseif( $timeDiff < 3600){
                    $time = floor($timeDiff/60).'分钟前';
                }elseif($timeDiff < 3600*24){
                    $time = floor($timeDiff/3600).'小时前';
                }else{
                    $time = substr($house->timeUpdate,0,10).'日';
                }
                ?>
                {{$time}}更新
             </span>
         </p>
       </dd>
       <dd class="dd2">
           @if($type == 'sale')
           <span class="colorfe">{{floor($house->price2)}}</span>&nbsp;万
           @elseif($type == 'rent')
               <span class="colorfe">
               @if($house->houseType1 == 3)
                  {{floor($house->price1)}}</span>&nbsp;元/月
               @elseif($house->houseType1 == 2 || $house->houseType1 == 1)
                   {{floor($house->price2)}}</span>&nbsp;元/天/平米
           @endif
           @endif
       </dd>
       <dd class="comment_r">
         {{--<p><a href="../PersonalHouse/rentZz.htm">编辑</a></p>--}}
         @if($house->entrustState == 1)
         <p><a onclick="removeAll('{{$type}}','{{$id}}')">停止委托</a></p>
         @endif
         {{--<p><a>转为直租</a></p>--}}
       </dd>
     </dl>
    </div>
    <div class="look_borker">
      @if(!empty($broker))
        <?php
          $k = 0;
        ?>
        @for($i = 0;$i < ceil(count($broker)/2);$i++)
          <div class="broker_mag">
            @if(isset($broker[$k]))
                @if($broker[$k]->found)
            <dl class="info">
              <dt>
                <a href="/brokerinfo/{{$broker[$k]->_source->id}}.html">
                    <img src="@if(!empty($broker[$k]->_source->photo)){{get_img_url('userPhoto',$broker[$k]->_source->photo,'1')}}@endif" alt="经纪人名称">
                </a>
              </dt>
              <dd>
                <p class="p1"><a href="/brokerinfo/{{$broker[$k]->_source->id}}.html">{{$broker[$k]->_source->realName}}</a></p>
                <p class="p2">
                  <span>在售：<a>@if(isset($broker[$k]->_source->hs3)){{$broker[$k]->_source->hs3}}@else 0 @endif</a>套</span>
                  <span>在租：<a>@if(isset($broker[$k]->_source->hr3)){{$broker[$k]->_source->hr3}}@else 0 @endif</a>套</span>
                  <span>商业：<a>@if(isset($broker[$k]->_source->businessHouseCount)){{$broker[$k]->_source->businessHouseCount}}@else 0 @endif</a>套</span>
                </p>
                <p class="p2 tel"><i></i>{{$broker[$k]->_source->mobile}}</p>
                <p class="p2">
                  <a onclick="removeBroker('{{$type}}','{{$broker[$k]->_source->id}}','{{$id}}')">取消委托</a>
                </p>
              </dd>
            </dl>
                  @endif
            @endif
            @if(isset($broker[$k+1]))
                    @if($broker[$k+1]->found)
            <span class="dotted"></span>
            <dl class="info">
              <dt>
                <img src="@if(!empty($broker[$k+1]->_source->photo)){{get_img_url('userPhoto',$broker[$k+1]->_source->photo,'1')}}@endif" alt="经纪人名称">
              </dt>
              <dd>
                <p class="p1"><a href="/brokerinfo/{{$broker[$k+1]->_source->id}}.html">{{$broker[$k+1]->_source->realName}}</a></p>
                <p class="p2">
                  <span>在售：<a>@if(isset($broker[$k+1]->_source->hs3)){{$broker[$k+1]->_source->hs3}}@else 0 @endif</a>套</span>
                  <span>在租：<a>@if(isset($broker[$k+1]->_source->hr3)){{$broker[$k+1]->_source->hr3}}@else 0 @endif</a>套</span>
                  <span>商业：<a>@if(isset($broker[$k+1]->_source->businessHouseCount)){{$broker[$k+1]->_source->businessHouseCount}}@else 0 @endif</a>套</span>
                </p>
                <p class="p2 tel"><i></i>{{$broker[$k+1]->_source->mobile}}</p>
                <p class="p2">
                  <a onclick="removeBroker('{{$type}}','{{$broker[$k+1]->_source->id}}','{{$id}}')">取消委托</a>
                </p>
              </dd>
            </dl>
                 @endif
            @endif
          </div>
          <?php
              $k = $k + 2;
          ?>
        @endfor
      @endif
    </div>
  </div>
</div>

<div class="claim" id="quxiao" style="z-index: 999; position: fixed; top:32%; left: 58%;">
   <span class="close" onclick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
   <dl>
       <dt><i class="tan"></i>您确定取消委托吗</dt>
       <dd><input type="button" onclick="ajaxPost()" class="btn" value="确定"><input onclick="$('#quxiao').hide();$('#lean_overlay').hide();" type="button" class="btn" value="取消"></dd>
   </dl>
</div>
<script>
$(document).ready(function(e) {
   $(".data_msg .look").click(function(){
      if($(this).parents("dl").next().css("display")=="none"){
          $(".data_msg .change").hide();
          $(this).parents("dl").next().show();
      }else{
          $(".data_msg .change").hide();
      }

       //弹出层调用语句
       $('.modaltrigger').leanModal({
           top:110,
           overlay:0.45,
           closeButton:".hidemodal"
       });
   });
});
  var token = "{{csrf_token()}}";
    var type1,bId1,hId1,url;
  // 取消当前的经纪人委托
   function removeBroker(type,bId,hId){
       $('#quxiao').show();
       $('#lean_overlay').show();
       type1 = type;
       bId1 = bId;
       hId1 = hId;
       url = '/userEntrust/removeBroker';
   }

   // 取消全部的委托
    function removeAll(type,hId){
        $('#quxiao').show();
        $('#lean_overlay').show();
        type1 = type;
        //bId1 = bId;
        hId1 = hId;
        url = '/userEntrust/removeAll';
    }

    // 点击确定
    function ajaxPost(){
        $('#quxiao').hide();
        $('#lean_overlay').hide();
        $.ajax({
            type : 'POST',
            url : url,
            data : {
                _token : token,
                type : type1,
                hId : hId1,
                bId : bId1
            },
            dataType : 'json',
            success : function(msg){
//                    if(msg.res == 'success'){
//                        alert(msg.data);
//                        location.reload();
//                    }
//                    if(msg.res == 'fail' || msg.res == 'error'){
//                        alert(msg.data);
//                    }
                if(msg == 1){
                    alert('操作成功');
                    location.reload();
                }
                if(msg == 0){
                    alert('操作失败');
                }
            }
        });
    }
</script>
@endsection
