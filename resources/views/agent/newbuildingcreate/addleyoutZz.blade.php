@include('agent.newbuildingcreate.header')
@include('agent.newbuildingcreate.left')
<input type="hidden" id="token" value="{{csrf_token()}}">
<input type="hidden" id="comid" value="{{$communityId}}">
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
              <a href="{{$hosturl}}?communityId={{$communityId}}&typeInfo={{$ddk}}" @if($typeInfo == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
@if($pagetype[1] == 1)
@include('agent.newbuildingcreate.addleyoutZz_1')
@elseif($pagetype[1] == 2)
@include('agent.newbuildingcreate.addleyoutZz_2')
@else
@include('agent.newbuildingcreate.addleyoutZz_3')
@endif