@extends('broker.header2')
@section('content')
@include('broker.brokerHeader')
<p class="submenu">
    @if(isset($flag) && $flag == 1)
        <a  class="click" href="/broker/{{$data->_id}}/detail">个人信息</a>
    @else
        @if(isset($data->_source->businessHouseCount) && ($data->_source->businessHouseCount + $data->_source->hr3 +$data->_source->hs3) != 0)<a  href="/brokerinfo/{{$data->_id}}.html">首页</a>@endif
        @if(!empty($data->_source->hs3))<a  href="/broker/{{$data->_id}}/secondHouse">二手房</a>@endif
        @if(!empty($data->_source->hr3))<a  href="/broker/{{$data->_id}}/rentHouse">租房</a>@endif
        @if(!empty($data->_source->businessHouseCount))<a  href="/broker/{{$data->_id}}/business">商业</a>@endif
        <a  class="click"  href="/broker/{{$data->_id}}/detail">个人信息</a>
    @endif
</p>
<div class="broker_list">
    <div class="house_l">
        <div class="basic_info">
            <h2><span>基础信息</span></h2>
            <ul class="broker_msg">
                <li>
                    <label>姓名：</label>
                    <span>{{empty($data->_source->realName) ? '暂无信息' : $data->_source->realName }}</span>
                </li>
                <li>
                    <label>所属公司：</label>
                    <span>{{empty($data->_source->company) ? '暂无信息' : $data->_source->company}}</span>
                </li>
                <li>
                    <label>所属城市：</label>
                    <span>{{ empty($data->cityName) ? '暂无信息' : $data->cityName }}</span>
                </li>
                <li>
                    <label>手机号：</label>
                    <span>{{ empty($data->_source->mobile) ? '暂无信息' : $data->_source->mobile }}</span>
                </li>
                <li>
                    <label>邮箱：</label>
                    <span>{{ empty($data->_source->email) ? '暂无信息' : $data->_source->email }}</span>
                </li>
                <li>
                    <label>服务商圈：</label>
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
                        @endif
                    </span>
                </li>
                <li>
                    <label>QQ：</label>
                    <span>{{ empty($data->_source->QQ) ? '暂无信息' : $data->_source->QQ }}</span>
                </li>
                <li>
                    <label>微信：</label>
                    <span>@if(empty($data->_source->weixin)) 暂无信息 @else {{$data->_source->weixin}} @endif</span>
                </li>
                <li class="no_float">
                    <label>宣言：</label>
                    <span>@if(empty($personal->manifesto)) 暂无信息 @else {{$personal->manifesto}} @endif</span>
                </li>
            </ul>
        </div>
        <div class="basic_info">
            <h2><span>工作履历</span></h2>
            <ul class="broker_msg">
                @if(empty($resume))
                    暂无资料
                    @else
                @foreach($resume as $item)
                <li>
                    <label>工作时间：</label>
                    <span>{{date('Y年m月d日', strtotime($item->timeStart)) }}&nbsp; 至 &nbsp; @if(empty($item->timeFinish))  至今 @else {{date('Y年m月d日', strtotime($item->timeFinish)) }} @endif</span>
                </li>
                <li>
                    <label>所属公司：</label>
                    <span>{{$item->companyName}}</span>
                </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="basic_info">
            <h2><span>个性资料：</span></h2>
            <ul class="broker_msg">
                <li class="no_float">
                    <label>籍贯：</label>
                    <span>
                        @if(isset($data->province) && isset($data->cityName) && isset($data->cityAreaName))
                    @if( $data->province == $data->cityName)
                            {{$data->province. $data->cityAreaName}}
                        @else
                            {{$data->province . $data->cityName. $data->cityAreaName}}
                     @endif
                        @endif
                    </span>
                </li>
                <li class="no_float">
                    <label>出生日期：</label>
                    <span>
                        @if(empty($data->_source->birthday))
                         暂无信息
                        @else
                            {{$data->_source->birthday}}
                            @endif
                    </span>
                </li>
                <li class="no_float">
                    <label>性格：</label>
                    <span>
                        @if(empty($data->_source->nature))
                            暂无信息
                            @else
                            <?php  $natures = explode('|', $data->_source->nature);
                            ?>
                            @foreach($natures as $v)
                                {{config('broker.nature').$v}}
                                @endforeach
                            @endif
                    </span>
                </li>
                <li class="no_float">
                    <label>兴趣爱好：</label>
                    <span>
                        @if(empty($data->_source->interst))
                            暂无信息
                        @else
                            <?php  $interests = explode('|', $data->_source->interest);
                            ?>
                            @foreach($interests as $v)
                                {{config('broker.interest').$v}}
                            @endforeach
                        @endif

                    </span>
                </li>
                            <li class="no_float">
                        <label>座右铭：</label>
                        <span>@if(empty($personal)) 暂无信息 @else {{$personal->motto}} @endif</span>
                    </li>
                    <li class="no_float introduce">
                        <label>个人介绍：</label>
                        <span>@if(empty($personal->introduce)) 暂无信息 @else {{$personal->introduce}} @endif</span>
                    </li>
            </ul>
        </div>
    </div>
    @include('broker.brokerRight')
</div>

<script>
    $(document).ready(function(e) {
        $(".head dl dd").hover(function(){
            $(this).find(".hot_city").show();
        },function(){
            $(this).find(".hot_city").hide();
        });
    });
</script>
@endsection