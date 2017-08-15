 <div class="user_r">
    <p class="enter_house">
      <a href="/houseHelp/rent/xq">出租</a>
      <a href="/houseHelp/sale/xq">出售</a>
    </p>
    <p class="subnav">
      @if($sale > 0)
      <a href="/user/personalHouse/sale">出售</a>
      @endif
      <span class="click">出租</span>
    </p>
    <div class="build_list">
     @if(!empty($house))
         @foreach($house as $val)
             <dl>
                 <dt>
                     <a href="/housedetail/sr{{$val->id}}.html" target="_blank"><img src="@if(!empty($val->thumbPic)){{get_img_url('houserent',$val->thumbPic,2)}}@else{{$houseImage}}@endif" onerror="errorImage(this)" alt="房源图片"></a>
                     {{--<a href="#" class="img_num"><i></i>{{$house->_source->picCount}}</a>--}}
                 </dt>
                 <dd class="width2">
                     <p class="build_name"><span class="color2d">[&nbsp;@if($val->houseType1 == 3)租房@elseif($val->houseType1 == 2)楼租@elseif($val->houseType1 == 1)铺租@endif &nbsp;]</span><a href="/housedetail/sr{{$val->id}}.html" target="_blank" class="name txt-hid" style="width: 430px;margin-right: 0;">{{$val->title}}</a></p>
                     <p class="finish_data color8d">
                         @if(isset($val->name))
                             <?php
                             if($val->houseType1 == 3){
                                 $url = '/esfrent/area/ba'.$val->communityId;
                             }else if($val->houseType1 == 2){
                                 $url = '/xzlrent/area/ba'.$val->communityId;
                             }else if($val->houseType1 == 1){
                                 $url = '/sprent/area/ba'.$val->communityId;
                             }
                             ?>
                             <a href="{{$url}}" style="float: left;">
                         @else
                            <a href="#" style="float: left;">
                         @endif
                             <strong>@if(isset($val->name)){{$val->name}}@endif</strong>
                         </a>&nbsp;&nbsp;
                         <span class="color8d txt-hid" style="width: 330px;">@if(isset($val->address)){{$val->address}}@endif</span>
                     </p>
                     <p class="build_type color8d">
                         @if($val->houseType1 == 3)
                             <span>@if(isset(config('houseState.Zz.rentType')[$val->rentType])){{config('houseState.Zz.rentType')[$val->rentType]}}@endif</span>
                             <span class="margin_l">{{floor($val->area)}}平米</span>
                         @else
                             <span>{{floor($val->area)}}平米</span>
                         @endif
                         @if($val->houseType1 == 3)
                             <?php
                             $room = explode('_',$val->roomStr);
                             ?>
                             <span class="margin_l">@if(!empty($val->roomStr)){{$room[0]}}室{{$room[1]}}厅{{$room[2]}}厨{{$room[3]}}卫@endif</span>
                             <span class="margin_l">@if(isset(config('faceToConfig')[$val->faceTo])){{config('faceToConfig')[$val->faceTo]}}@endif</span>
                         @endif
                         <span class="margin_l">{{$val->currentFloor}}/{{$val->totalFloor}}层</span>
                         @if($val->houseType1 == 2)
                             <span class="margin_l">@if(isset(config('houseState.fitment')[$val->fitment])){{config('houseState.fitment')[$val->fitment]}}@endif</span>
                         @endif
                         @if($val->houseType1 == 1 && !empty($val->transferPrice) && $val->transferPrice != '0.00')
                             <span class="margin_l">转让费：{{floor($val->transferPrice)}}万元</span>
                         @endif
                         @if($val->houseType1 == 2 || $val->houseType1 == 1)
                             <span class="margin_l">{{floor($val->price1)}}元/月</span>
                         @endif
                     </p>
                     <p class="build_type color8d">
                         <span>发布时间：</span>
                         <span>{{substr($val->timeCreate,0,10)}}</span>
                         <span class="margin_l">
                               <?php
                               $timeDiff = time() - strtotime($val->timeUpdate);
                               if($timeDiff < 60){
                                   $time = $timeDiff.'秒前';
                               }elseif( $timeDiff < 3600){
                                   $time = floor($timeDiff/60).'分钟前';
                               }elseif($timeDiff < 3600*24){
                                   $time = floor($timeDiff/3600).'小时前';
                               }else{
                                   $time = substr($val->timeUpdate,0,10).'日';
                               }
                               ?>
                               {{$time}}更新
                         </span>
                     </p>
                 </dd>
                 <dd class="dd2">
               <span class="colorfe">
                   @if($val->houseType1 == 3)
                       {{floor($val->price1)}}</span>&nbsp;元/月
                     @elseif($val->houseType1 == 2 || $val->houseType1 == 1)
                     {{floor($val->price2)}}</span>&nbsp;元/天/平米
                     @endif
                 </dd>
                 <dd class="comment_r margin_t">
                     <p>
                         <a @if($val->houseType1 == 3)href="/houseHelp/rent/xq?id={{$val->id}}" @elseif($val->houseType1 == 2)href="/houseHelp/rent/office?id={{$val->id}}" @elseif($val->houseType1 == 1)href="/houseHelp/rent/shop?id={{$val->id}}"@endif>编辑</a>
                     </p>
                     <p>
                         @if($val->state == 0)
                             <a onclick="fabuState('{{$val->id}}','rent')">发布</a>
                         @elseif($val->state == 1)
                             <a onclick="cncelState('{{$val->id}}','rent')">取消发布</a>
                         @endif
                     </p>
                     @if($val->state == 0)
                     <p><a onclick="delHouse('{{$val->id}}','rent')">删除</a></p>
                     @endif
                 </dd>
             </dl>
         @endforeach
     @endif
    </div>
  </div>


