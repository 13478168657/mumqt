<div class="main">
  <div class="main_l" id="main_l">
    <dl class="broker">
      <dt><a><img src="/image/broker.jpg" /></a></dt>
    </dl>
    <div class="subnav">
      <p class="p1 click"><span>增量楼盘库</span><i></i></p>
      <p class="p2" style="display:block;">
        <a href="buildList" class="onclick"><i></i>新楼盘创建</a>
        <a href="../../examine/via.htm"><i></i>新楼盘审核</a>
        <a href="../../manage/buildManage.htm"><i></i>新楼盘管理</a>
        <a href="../../examineDynamic/viaing.htm"><i></i>变动信息审核</a>
      </p>
      <p class="p1"><span>增量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../../newHouseLibrary/addNewHouse/addNewZz.htm"><i></i>录入新房房源</a>
        <a href="../../../newHouseLibrary/newHouseManage/releaseing.htm"><i></i>管理新房房源</a>
      </p>
      <p class="p1 click"><span>存量楼盘库</span><i></i></p>
      <p class="p2">
        <a href="../../../oldBuildLibrary/add/buildList.htm"><i></i>现有楼盘创建</a>
        <a href="../../../oldBuildLibrary/examine/via.htm"><i></i>现有楼盘审核</a>
        <a href="../../../oldBuildLibrary/manage/buildManage.htm"><i></i>现有楼盘管理</a>
      </p>
      <p class="p1"><span>存量房源库</span><i></i></p>
      <p class="p2">
        <a href="../../../oldHouseLibrary/enterSaleHouse/comment.htm"><i></i>录入出售房源</a>
        <a href="../../../oldHouseLibrary/saleHouseManage/releaseing.htm"><i></i>管理出售房源</a>
        <a href="../../../oldHouseLibrary/enterRentHouse/comment.htm"><i></i>录入出租房源</a>
        <a href="../../../oldHouseLibrary/rentHouseManage/releaseing.htm"><i></i>管理出租房源</a>
      </p>
      <p class="p1"><span>报表</span><i></i></p>
      <p class="p2">
        <a href="../../../buildReport/yjReport.htm"><i></i>佣金报表</a>
        <a href="../../../buildReport/buildReport.htm"><i></i>楼盘报表</a>
        <a href="../../../buildReport/brokerReport.htm"><i></i>经纪人报表</a>
      </p>
      <p class="p1"><span>我的搜房</span><i></i></p>
      <p class="p2">
        <a><i></i>我的资料</a>
        <a><i></i>我的认真</a>
        <a><i></i>我的积分</a>
        <a><i></i>修改密码</a>
      </p>
    </div>
  </div>
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
      <a href="/marketing?communityId={{$communityId}}&typeInfo={{$typeInfo}}">营销信息</a>
      <a href="/commission?communityId={{$communityId}}" @if(!empty($yongjin)) class="click" @endif >佣金方案</a>
      <a href="comment?communityId={{$communityId}}&typeInfo={{$typeInfo}}" @if(!empty($comment)) class="click" @endif>楼盘点评</a>
    </p>