@extends('mainlayout')
@section('title')
<title>【北京{楼盘名},北京新楼盘】-搜房网</title>
<meta name="Keywords" content="{楼盘名},北京新盘，北京新楼盘" />
<meta name="Description" content="搜房网，北京新房为您提供新房详情、新房相册、新房户型、新房价格，让您更全面的了解新楼盘，为您创造最佳新房购房体验！" />
@endsection
@section('content')

@include('xinf.left')
  <div class="build_image">
    <div class="image_l">
      <ul>
      @if($viewShowInfo['type1ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=1" @if($type == 1) class="click" @endif>交通图<span>({{$viewShowInfo['type1ImgNum']}})</span></a></li>
      @endif
      @if($viewShowInfo['type2ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=2" @if($type == 2) class="click" @endif>实景图<span>({{$viewShowInfo['type2ImgNum']}})</span></a></li>
      @endif
      @if($viewShowInfo['type3ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=3" @if($type == 3) class="click" @endif>效果图<span>({{$viewShowInfo['type3ImgNum']}})</span></a></li>
      @endif
      @if($viewShowInfo['type4ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=4" @if($type == 4) class="click" @endif>样板间<span>({{$viewShowInfo['type4ImgNum']}})</span></a></li>
      @endif
      @if($viewShowInfo['type6ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=6" @if($type == 6) class="click" @endif>配套图<span>({{$viewShowInfo['type6ImgNum']}})</span></a></li>
      @endif
      @if($viewShowInfo['type7ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=7" @if($type == 7) class="click" @endif>施工进度图<span>({{$viewShowInfo['type7ImgNum']}})</span></a></li>
      @endif
      @if($viewShowInfo['type8ImgNum'] > 0)
        <li><a href="/xinfxc?communityId={{$communityId}}&type2={{$type2}}&type=8" @if($type == 8) class="click" @endif>规划图<span>({{$viewShowInfo['type8ImgNum']}})</span></a></li>
      @endif
      </ul>
    </div>
    <div class="image_r">
     <div>
     @if($commTypeImg->items())
      @foreach($commTypeImg->items() as $img)
       <dl>
         <dt><a href="../../../image/img1.jpg" title="第1张：合生滨江帝景周边配套-商业街"><img src="{{$img->fileName}}" alt=""></a></dt>
         <dd>{{$img->note}}</dd>
       </dl>
      @endforeach
    @else
      <dl>
        <h1>暂无图片数据</h1>
      </dl>
    @endif
     </div>
          {!!$commTypeImg->render()!!}
    </div>
  </div>
</div>

<script>
$(document).ready(function(e) {
  $(".hx .hx_title i").click(function(){
  $(".hx ul").hide();
  $(this).parent().next().show();  
  $(".hx .hx_title i").removeClass("click");
  $(this).addClass("click");
  });
  $(".build_house .home_info ul li a").click(function(){
   if($(this).attr("class")=="") {
    $(this).parent().find("a").removeClass("click");
    $(this).addClass("click"); 
   }else if($(this).attr("class")=="click"){
    $(this).removeClass("click");  
   }
  });
});
window.onload = function(){
  var oDiv = document.getElementById("msg_nav");
  var h = oDiv.offsetTop;
  document.onscroll = function(){
    var t = document.documentElement.scrollTop || document.body.scrollTop;
    if(h <= t){
      oDiv.style.position = 'fixed';
    }else{
      oDiv.style.position = '';
      }
  } 
};
</script>
@endsection