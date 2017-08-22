 <div class="user_r">
    <p class="enter_house">
      <a href="/houseHelp/rent/xq">出租</a>
      <a href="/houseHelp/sale/xq">出售</a>
    </p>
    <p class="subnav">
      <span class="click">出售</span>
      @if($rent > 0)
      <a href="/user/personalHouse/rent">出租</a>
      @endif
    </p>
    <div class="build_list">
         @if(!empty($house))
             @foreach($house as $val)
                 <dl>
                     <dt>
                         <a href="/housedetail/ss{{$val->id}}.html" target="_blank"><img src="@if(!empty($val->thumbPic)){{get_img_url('housesale',$val->thumbPic,2)}}@else{{$houseImage}}@endif" onerror="errorImage(this)" alt="房源图片"></a>
                         {{--<a href="#" class="img_num"><i></i>0</a>--}}
                     </dt>
                     <dd class="width2">
                         <p class="build_name">
                             <span class="color2d">[&nbsp;@if($val->houseType1 == 3)二手房@elseif($val->houseType1 == 2)楼售@elseif($val->houseType1 == 1)铺售@endif&nbsp;]</span><a href="/housedetail/ss{{$val->id}}.html" target="_blank" class="name txt-hid" style="width:420px;margin-right: 0;">{{$val->title}}</a></p>
                         <p class="finish_data color8d">
                             @if(isset($val->name))
                                 <?php
                                    if($val->houseType1 == 3){
                                        $url = '/esfsale/area/ba'.$val->communityId;
                                    }else if($val->houseType1 == 2){
                                        $url = '/xzlsale/area/ba'.$val->communityId;
                                    }else if($val->houseType1 == 1){
                                        $url = '/spsale/area/ba'.$val->communityId;
                                    }
                                 ?>
                                 <a href="{{$url}}" style="float: left;">
                             @else
                                <a href="#" style="float: left;">
                             @endif
                                 <strong>@if(isset($val->name)){{$val->name}}@endif</strong>
                             </a>&nbsp;&nbsp;
                             <span class="color8d txt-hid" style="width:330px;">@if(isset($val->address)){{$val->address}}@endif</span>
                         </p>
                         <p class="build_type color8d">
                             <span>{{floor($val->area)}}平米</span>
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
                             <span class="margin_l">{{floor($val->price1)}}元/平米</span>
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
                     <dd class="dd2"><span class="colorfe">{{floor($val->price2)}}</span>&nbsp;万元</dd>
                     <dd class="comment_r margin_t">
                         <p>
                             <a @if($val->houseType1 == 3)href="/houseHelp/sale/xq?id={{$val->id}}" @elseif($val->houseType1 == 2)href="/houseHelp/sale/office?id={{$val->id}}" @elseif($val->houseType1 == 1)href="/houseHelp/sale/shop?id={{$val->id}}"@endif>编辑</a>
                         </p>
                         <p>
                             @if($val->state == 1)
                                 <a onclick="cncelState('{{$val->id}}','sale')">取消发布</a>
                             @elseif($val->state == 0)
                                 <a onclick="fabuState('{{$val->id}}','sale')">发布</a>
                             @endif
                         </p>
                         @if($val->state == 0)
                         <p><a onclick="delHouse('{{$val->id}}','sale')">删除</a></p>
                         @endif
                     </dd>
                 </dl>
             @endforeach
         @endif
    </div>
  </div>


