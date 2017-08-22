
<div class="catalog_nav" id="catalog_nav">
  <div class="list_sub">
     <div class="list_search">
     	<form action="/brokerlist" id="searchBrokerlist" method="get">
	        <input type="text" class="txt border_blue" autocomplete="off"  placeholder="请输入要搜索的经纪人姓名" name="keyword" value="">
	        <input type="button" onclick="$('#searchBrokerlist').submit();" class="btn back_color" style="cursor:pointer;" value="搜经纪人">
    	</form>
      </div>
  </div>
</div>
<p class="route">
  <span>您的位置：</span>
  <a href="/">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="/brokerlist" class="colorfe">{{CURRENT_CITYNAME}}经纪人列表</a>
  <span>&nbsp;>&nbsp;</span>
  <span class="colorfe">{{$data->realName}}</span>
</p>