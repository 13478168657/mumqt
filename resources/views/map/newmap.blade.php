@extends('newmaplayout')
@section('content')
    
<div class="map" id="centent">
    <div id="map"></div>
    @include("map.maporlist")
    @include("map.newmapleft")
{{--    @include("map.communitydb")--}}
{{--    @include("map.housedb")--}}
</div>
@endsection