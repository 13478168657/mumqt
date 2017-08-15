@include('agent.dynamic.header')
@include('agent.dynamic.left')
<input type="hidden" id="communityName" value="{{$sale->communityName}}">
    <div class="write_msg">
      <p class="manage_title">
        @if(!empty($data))
          @foreach($data as $dkey => $dval)
            @if(!empty($dval))
              @foreach($dval as $ddk => $ddv)
              <a href="{{$hosturl}}?type={{$ddk}}" @if($pagetype[2] == $ddk) class="click" @endif>{{$ddv}}</a>
              @endforeach
            @endif
          @endforeach
        @endif
      </p>
@if($pagetype[1] == 1)
@include('agent.dynamic.sale_1')
@elseif($pagetype[1] == 2)
@include('agent.dynamic.sale_2')
@else
@include('agent.dynamic.sale_3')
@endif