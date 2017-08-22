@include('agent.agent_layout.navbar')
@include('agent.agent_layout.sidebar')
<div class="main_r" id="main_r">
    <div class="commtent">
      <p>
        <span class="color_blue">五矿万科城</span>
        <span class="color8d">wkwkc</span>
        <span class="subway">{{$type2_data}}</span>
      </p>
      <p>
       <span>[&nbsp;北京-朝阳-百子湾&nbsp;]&nbsp;&nbsp;</span>
       <span>东四环与广渠路交口大郊亭桥广渠路21号&nbsp;<a class="modaltrigger" href="#map"><i class="map_icon"></i></a></span>
      </p>
    </div>
    <p class="right_title border_bottom">
      <a href="/addBasicHouse?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($basic)) class="click" @endif>详细信息</a>
      <a href="/addBuilding?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($building)) class="click" @endif>楼栋信息</a>
      <a href="/addRoom?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($houseroom)) class="click" @endif>户型信息</a>
      <a href="/buildaddimage?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($addImage)) class="click" @endif>相册信息</a>
      <a href="/marketing?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($marketing)) class="click" @endif>营销信息</a>
      <a href="/commission?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($yongjin)) class="click" @endif >佣金方案</a>
      <a href="comment?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($comment)) class="click" @endif>楼盘点评</a>
    </p>