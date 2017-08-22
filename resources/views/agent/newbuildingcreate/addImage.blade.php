@include('agent.newbuildingcreate.header')
@include('agent.newbuildingcreate.left')
    <div class="write_msg">
      <p class="manage_title">
         @if(!empty($data))
          @foreach($data as $dkey => $dval)
            @if(!empty($dval))
              @foreach($dval as $ddk => $ddv)
              <a href="{{$hosturl}}?communityId={{$communityId}}&typeInfo={{$ddk}}" @if($pagetype[2] == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
      <ul class="input_msg">
          <li style="height:auto; overflow:hidden;">
            <label>注意：</label>
            <div class="float_l colorfe">
                1、上传宽度大于600像素，比例为4:3的图片可获得更好的展示效果。<br />
                2、请勿上传有水印、盖章等任何侵犯他人版权或含有广告信息的图片。<br />
                3、可上传30张图片，每张小于20M，建议尺寸比为：16:10，最佳尺寸为480*300像素。<br />
                4、多图房源点击量比非多图房源高出30%。
            </div>
          </li>
      @include('agent.newbuildingcreate.roomImage')
      
