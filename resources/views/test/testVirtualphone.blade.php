<form action="" methond="get">
	<h1>绑定虚拟号</h1>
	客户手机号<input name="customerMobile" value="{{Input::get('customerMobile')}}" />
	经纪人手机号<input name="brokerMobile" value="{{Input::get('brokerMobile')}}" />
	虚拟号<select name="virtualMobile">
	<option value=''>请选择</option>
	@foreach($poolObj as $pool_key=>$pool_val)
	<option @if(($pool_val->virtualMobile.'_'.$pool_val->key)==Input::get('virtualMobile')){{'selected=selected'}}@endif value="{{$pool_val->virtualMobile}}_{{$pool_val->key}}">{{$pool_key+1}}. {{$pool_val->virtualMobile}}</option>
	@endforeach
	</select>
	<input type="hidden" name="type" value="XH_DIAL1" />
	<input type="submit" value="提交" />
</form>

<form action="" methond="get">
	<h1>解绑虚拟号</h1>
	客户手机号<input name="customerMobile" value="{{Input::get('customerMobile')}}" />
	经纪人手机号<input name="brokerMobile" value="{{Input::get('brokerMobile')}}" />
	虚拟号<select name="virtualMobile">
	<option value=''>请选择</option>
	@foreach($poolObj as $pool_key=>$pool_val)
	<option @if(($pool_val->virtualMobile.'_'.$pool_val->key)==Input::get('virtualMobile')){{'selected=selected'}}@endif value="{{$pool_val->virtualMobile}}_{{$pool_val->key}}">{{$pool_key+1}}. {{$pool_val->virtualMobile}}</option>
	@endforeach
	</select>
	<input type="hidden" name="type" value="XH_CLOSE1" />
	<input type="submit" value="提交" />
</form>