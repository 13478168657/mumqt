<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <title>搜房首页</title>
    </head>
    <body>
    	@if($permUtil->checkPermField(1))
        <div>显示数据field1</div>
        @endif
        @if($permUtil->checkPermField(3))
        <input type="button" value="新增" />
        @endif
        @if($permUtil->checkPermField(4))
        <input type="button" value="修改" />
        @endif
        @if($permUtil->checkPermField(5))
        <input type="button" value="删除" />
        @endif
        <a target="_blank" href="/perm/resetPerm">重置权限缓存</a>
    </body>
</html>