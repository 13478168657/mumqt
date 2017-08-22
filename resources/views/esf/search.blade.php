<!--临时的js -->
<script src="/js/list.js?v={{Config::get('app.version')}}"></script>

<div class="catalog_nav no_float">
    <div class="margin_auto clearfix">
  <div class="list_sub">
     <div class="list_search">
      <form action="/{{$viewShowInfo['saleUrl']}}" method="get" id="search">
        <?php
                $type2x = substr($type2, 0, 1);
                if($type2x == '3'){
                    $type2x = 'esfsale';
                }else if($type2x == '2'){
                    $type2x = 'xzlsale';
                }else{
                    $type2x = 'spsale';
                }
        ?>
        <input type="text" class="txt border_blue" tp="{{$type2x}}" AutoComplete="off" id="keyword" onClick="$(this).focus();" name="kw" placeholder="请输入关键字（楼盘名/地名等）">
        <div class="mai mai1"></div>
        <input type="submit" class="btn back_color" value="搜房">
      </form>
         <input type="hidden" id="linkurl"  value="/{{$viewShowInfo['saleUrl']}}" >
         <input type="hidden" id="par"  value="" >
     <input type="hidden" id="token" value="{{csrf_token()}}">
     <input type="hidden" name="_token" value="{{csrf_token()}}">
     </div>
  </div>
 </div>
</div>
<p class="route">
  <span>您的位置：</span>
  <a href="/">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="/{{$viewShowInfo['saleUrl']}}" class="colorfe">{{CURRENT_CITYNAME}}
      @if(substr($type2, 0,1) == 1)
      商铺
      @elseif(substr($type2, 0,1) == 2)
      写字楼
      @else
      二手房
      @endif
  </a>
  <span>&nbsp;>&nbsp;{{$viewShowInfo['commName']}}</span>
</p>