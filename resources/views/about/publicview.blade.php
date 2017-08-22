<div class="about_l">
    <ul>
      
        @if(isset($selected1) && !empty($selected1))
            <li class="click">关于我们	        
      	@else
      		<li>
	      	<a href="/about/aboutus.html">关于我们</a>
      	@endif
      		</li>
      	@if(isset($selected2) && !empty($selected2))
      		<li class="click">联系我们	
      	@else
      		<li>
	    	<a href="/about/contactus.html">联系我们</a>
      	@endif
	    	</li>

		   @if(isset($selected3) && !empty($selected3))
      		<li class="click">免责声明	
      	@else
      		<li>
	    	<a href="/about/disclaimer.html">免责声明</a>
      	@endif
	    	</li>
		
		   @if(isset($selected4) || isset($selected7) || isset($selected8) || isset($selected9) || isset($selected10) || isset($selected11) || isset($selected12) || isset($selected12) || isset($selected13) || isset($selected14) || isset($selected15) || isset($selected16) || isset($selected17) || isset($selected18) || isset($selected19))
      		<li class="click">招聘信息	
      	@else
      		<li>
	    	<a href="/about/recruit.html">招聘信息</a>
      	@endif
	    	</li>

	     @if(isset($selected6) && !empty($selected6))
      		<li class="click">隐私协议	
      	@else
      		<li>
	    	<a href="/about/secret.html">隐私协议</a>
      	@endif
	    	</li>
    </ul>
  </div>