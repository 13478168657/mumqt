@include('agent.newbuildingcreate.header')
@include('agent.newbuildingcreate.left')
<input type="hidden" id="communityName" value="{{$sale->communityName}}">
<input type="hidden" id="comid" value="{{$communityId}}">
<input type="hidden" id="token" value="{{csrf_token()}}">
@if(!empty($pagetype))
  <input type="hidden" id="pagetype1" value="{{$pagetype[1]}}" />
  <input type="hidden" id="pagetype2" value="{{$pagetype[2]}}" />
@endif
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
@if($pagetype[1] == 1)
@include('agent.newbuildingcreate.yingxiao_1')
@elseif($pagetype[1] == 2)
@include('agent.newbuildingcreate.yingxiao_2')
@else
@include('agent.newbuildingcreate.yingxiao_3')
@endif