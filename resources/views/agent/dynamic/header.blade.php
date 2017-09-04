<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>动态信息管理-{{$title}}</title>
<link rel="stylesheet" type="text/css" href="/css/brokerComment.css"/>
<link rel="stylesheet" type="text/css" href="/css/brokerCenter.css"/>
<link rel="stylesheet" type="text/css" href="/css/color.css"/>
</head>

<body>
<header class="header">
  <h2>搜房管理中心</h2>
  <nav class="head_nav">
      <a>我的店铺</a>
      <a>使用帮</a>
    </nav>
    <div class="head_r">
      <span>400-630-6888</span>
      <a>退出</a>
    </div>
    <input type="hidden" id="token" value="{{csrf_token()}}" />
  @if(!empty($pagetype))
	<input type="hidden" id="pagetype1" value="{{$pagetype[1]}}" />
	<input type="hidden" id="pagetype2" value="{{$pagetype[2]}}" />
	@endif
	<input type="hidden" id="comid" value="{{$comid}}" />
</header>