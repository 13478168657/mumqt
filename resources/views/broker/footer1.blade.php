    <?php

    $cityObjectAll = \Illuminate\Support\Facades\Cache::store(CACHE_TYPE)->get(CITY);
    ?>
    <dl class="no_border">
        <dt>各区域经纪人</dt>
        <dd class="dd">
            @if(!empty($cityArea))
                @foreach($cityArea as $k=>$v)
                    <a href="{{$hosturl}}?cityAreaId={{$v->id}}" @if(!empty($brokerlist->cityAreaId) && $v->id == $brokerlist->cityAreaId) class="color_blue active_select"@endif>{{$v->name}}经纪人</a>
                @endforeach
            @endif
        </dd>
    </dl>

    <dl>
        <dt>热门城市经纪人</dt>
        <dd>
            @if(!empty($cityObjectAll))
                @foreach($cityObjectAll as $cv)
                    @if($cv['isHot'] == 1)
                        <a href="http://{{$cv['py']}}.{{config('session.domain')}}/brokerlist">{{$cv['name']}}经纪人</a>
                    @endif
                @endforeach
            @endif
        </dd>
    </dl>
    <dl class="no_border">
            <dt>各区域二手房</dt>
            <dd class="dd">
                @if(!empty($cityArea))
                    @foreach($cityArea as $k=>$v)
                        <a href="http://{{CURRENT_CITYPY}}.{{config('session.domain')}}/esfsale/area/aa{{$v->id}}">{{$v->name}}二手房</a>
                    @endforeach
                @endif
            </dd>
        </dl>
    <dl>
        <dt>热门城市二手房</dt>
        <dd>
            @if(!empty($cityObjectAll))
                @foreach($cityObjectAll as $cv)
                    @if($cv['isHot'] == 1)
                        <a href="http://{{$cv['py']}}.{{config('session.domain')}}/{{$type}}/area">{{$cv['name']}}二手房</a>
                    @endif
                @endforeach
            @endif
        </dd>
    </dl>
<script>
    //底部切换
    function webMpe(name, curr) {
        var num=$(".dd a").length;
        for (i = 1; i <= num; i++) {
            var menu = document.getElementById(name + i);
            var cont = document.getElementById("con_" + name + "_" + i);
            menu.className = i == curr ? "up" : "";
            if (i == curr) {
                cont.style.display = "block";
            } else {
                cont.style.display = "none";
            }
        }
    }
</script>
