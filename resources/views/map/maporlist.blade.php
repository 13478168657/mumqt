<div class="qh">
    <!--<dl>
        <dt></dt>
        <dd>
            地图
        </dd>
    </dl>-->
    <dl>
        <dd>
            @if($housetype1 == '1')
                @if($type == 'sale')
                    <a href="/spsale/area"><i></i>列表</a>
                @else
                    <a href="/sprent/area"><i></i>列表</a>
                @endif
            @elseif($housetype1 == '2')
                @if($type == 'sale')
                    <a href="/xzlsale/area"><i></i>列表</a>
                @else
                    <a href="/xzlrent/area"><i></i>列表</a>
                @endif
            @else
                @if($type == 'sale')
                    <a href="/esfsale/area"><i></i>列表</a>
                @elseif($type =='new')
                    <a href="/new"><i></i>列表</a>    
                @else
                    <a href="/esfrent/area"><i></i>列表</a>
                @endif
            @endif
        </dd>
    </dl>
</div>