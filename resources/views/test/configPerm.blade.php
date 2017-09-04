<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <title>用户权限配置测试页</title>
    </head>
    <body>
    	<form>
    		@foreach($permModuleArr as $system_key => $system)
	    	<DIV>
	    		<h3>{{$system['name']}}</h3>
	    		@foreach($system as $module_key => $module)
	    		@if(is_array($module))
	    		<h4>{{$module['name']}}</h4>
	    		<div>
	    			@foreach($module as $function_key => $function)
	    			@if(is_array($function))
	    			<input type="checkbox" value="{{$function['id']}}" name="permModule[]" /> <i title="{{$function['url']}}">{{$function['name']}}</i>
	    			@endif
	    			@endforeach
	    		</div>
	    		@endif
	    		@endforeach
	    	</DIV>
	    	@endforeach
    	</form>
    </body>
</html>