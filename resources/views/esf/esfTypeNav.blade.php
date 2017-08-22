	<div style="height: 52px; display: none;" id="void"></div>
<div class="title_nav">
	<div class="msg_nav msg_nav1" id="msg_nav">
      <a href="/esfindex/{{$communityId}}/{{$type2}}.html" @if(!empty($home)) class="nav_click" @endif>楼盘首页</a>
      <a href="/esfbd/{{$communityId}}/{{$type2}}.html" @if(!empty($xiangqing)) class="nav_click" @endif>楼盘详情</a>
      <!-- <a href="/esfbl?communityId={{$communityId}}&type2={{$type2}}" @if(!empty($huxing)) class="nav_click" @endif>户型详情</a> -->
      <!-- <a href="/esfba?communityId={{$communityId}}&type2={{$type2}}&type=1" @if(!empty($xiangce)) class="nav_click" @endif>楼盘相册</a> -->
      <a href="/esfbp/{{$communityId}}/{{$type2}}.html" @if(!empty($price)) class="nav_click" @endif>房价走势</a>
      <a href="/{{$viewShowInfo['saleUrl']}}/area/ba{{$communityId}}" target="_blank">
            @if(substr($type2, 0,1) == 3)
                  二手房
            @else
                  出售
            @endif
      </a>
      <a href="/{{$viewShowInfo['rentUrl']}}/area/ba{{$communityId}}" target="_blank">
            @if(substr($type2, 0,1) == 3)
                  租房
            @else
                  出租
            @endif
      </a>
      <!-- <a href="#">搜房网店</a> -->
      <div class="clear"></div>
    </div>
</div>