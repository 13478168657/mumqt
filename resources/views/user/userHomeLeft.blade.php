<div class="user_l">
    <div class="user_info">
        <dl>
            @if(!empty($info))
            <dt><a href="/myinfo/infoUpdate"><img onerror="this.src='/image/user.png';" src="{{config('imgConfig.imgSavePath')}}{{$info[0]->photo}}" alt="{{Auth::user()->userName}}"></a></dt>
            @else
            <dt><a href="/myinfo/infoUpdate"><img src="/image/user.png" alt="经纪人名称"></a></dt>
            @endif
            <dd>
                <p class="p1">欢迎您</p>
                {{--<p class="p2">{{Auth::user()->userName}}</p>--}}
                <p class="p2">{{substr_replace(Auth::user()->mobile,'****',3,4)}}</p>
            </dd>
        </dl>
    </div>
    <div class="user_menu">
        <ul>
            <li @if(isset($interComm)) class="click" @endif><a href="/user/interCommunity/xinF">关注的楼盘</a></li>
            <li @if(isset($interHouse)) class="click" @endif><a href="/user/interHouse/xqsale">关注的房源</a></li>
            <li @if(isset($entrustQz)) class="click" @endif><a href="/userEntrust/Qz">委托房源</a></li>
            <li @if(isset($personal)) class="click" @endif><a href="/user/personalHouse">个人房源</a></li>
            <li @if(isset($infoShow)) class="click" @endif><a href="/myinfo/infoUpdate">编辑资料</a></li>
            <li @if(isset($set)) class="click" @endif><a href="/myinfo/passwdUpdate">账户设置</a></li>
            <li @if(isset($reset)) class="click" @endif><a href="/myinfo/userChangeBroekr">重置身份</a></li>
        </ul>
    </div>
</div>