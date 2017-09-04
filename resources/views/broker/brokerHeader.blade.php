<p class="route line_height">
    <span>您的位置：</span>
    <a href="/">首页</a>
    <span>&nbsp;>&nbsp;</span>
    <a href="/brokerlist" class="colorfe">{{CURRENT_CITYNAME}}经纪人列表</a>
    <span class="colorfe">@if(!empty($data->_source->realName))<span>&nbsp;>&nbsp;</span>{{$data->_source->realName}}@endif</span>
</p>

<div class="broker_info">
    @if(!empty($data->_source))
    <dl>
            <dt><img src="{{!empty($data->_source->photo)?get_img_url('userPhoto',$data->_source->photo,8):"/image/default_broker.png"}}" alt="{{$data->_source->realName}}" onerror="javascript:this.src='/image/default_broker.png';"></dt>
        <dd>
            <h2 class="broker_name">@if(empty($data->_source->realName))匿名@else{{$data->_source->realName}}@endif的店铺 </h2>
            <p class="broker_type">
                @if(!empty($data->_source->company))
                    <span>{{$data->_source->company}}</span>
                    <span class="dotted"></span>
                 @endif
                <span>
                    @if(!empty($data->_source->managebusinessAreaIds) && (int)$data->_source->managebusinessAreaIds)
                        <?php $managebusinessAreaIds = explode('|', $data->_source->managebusinessAreaIds); ?>
                        @for($i = 0; $i < 2; $i++)
                            @if(!empty($managebusinessAreaIds[$i]))
                                <?php
                                $businessName = \App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($managebusinessAreaIds[$i]);
                                if(empty($businessName)){
                                    $businessName = '多商圈';
                                }
                                ?>
                                <a>{{$businessName}}</a>
                            @endif
                        @endfor
                    @else
                        多商圈
                    @endif</span>
                <span class="dotted"></span>
                <span>主营业务：
                    @if(!empty($data->_source->mainbusiness))
                        <?php $mainbusiness = explode('|', $data->_source->mainbusiness); ?>
                        @for( $i = 0; $i < 2; $i++)
                            @if(!empty($mainbusiness[$i]))
                                <a>{{config('mianBusiness.'. $mainbusiness[$i])}}</a>
                            @endif
                        @endfor
                    @else
                        暂无资料
                    @endif
                </span>
            </p>
            <p class="broker_type">
                <span>在租：@if(empty($data->_source->hr3))0 @else {{$data->_source->hr3}}@endif套</span>
                <span class="dotted"></span>
                <span>在售：@if(empty($data->_source->hs3))0 @else {{$data->_source->hs3}}@endif套</span>
                <span class="dotted"></span>
                <span>商业：@if(empty($data->_source->businessHouseCount))0 @else {{$data->_source->businessHouseCount}}@endif套</span>
            </p>
            <p class="broker_rz">
                @if($data->_source->idcardState == 1)
                <img src="/image/id.png" alt="身份证">
                @endif
                @if($data->_source->nameCardState == 1)
                <img src="/image/mp.png" alt="名片">
                @endif
            </p>
        </dd>
    </dl>

    <span class="wire"></span>
    <div class="broker_tel">
        <i></i>
        {{$data->_source->mobile}}
    </div>
        @else
        暂无该经纪人资料
    @endif

</div>

