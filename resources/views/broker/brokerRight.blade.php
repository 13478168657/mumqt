<div class="house_r">
    <div class="message">
        <p>给他留言</p>
        <div class="tip">
            <p class="ok"><i></i>留言成功!</p>
            <p class="error"><i></i>留言失败!</p>
        </div>
        <ul class="mess">
            <li>
                <label>留言人：</label>
                <input type="text" class="txt" name="uname">
                <p id="uname"></p>
            </li>
            <li>
                <label>留言电话：</label>
                <input type="text" class="txt" name="phone">
                <p id="phone"></p>
            </li>
            <li class="infomation">
                <label>留言内容：</label>
                <div class="content">
                    <textarea name="msg" id="ta"></textarea>
                    <span class="tishi">不超过<span class="colorfe">50</span>字</span>
                </div>
                <p id="msg"></p>
            </li>
            <li id="ok" style="display: none">ok</li>
            <li id="error" style="display: none">留言失败</li>
            <li class="btns">
                <input type="hidden" name="id" value="@if(!empty($data->_source)){{$data->_id}}@endif" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="button" class="btn" value="提交" id="btn_message"/>
            </li>
        </ul>
    </div>
    @if(!empty($comm))
    <div class="message">
        <p>服务楼盘</p>
        <div class="mes_list">
	        <ul>
	            @foreach($comm as $k => $val)
	                    {{--<li><a href="/broker/@if(!empty($data->_id)){{$data->_id}}@endif/comm/{{$k}}-sale">{{$val['name']}}（{{$val['total']}}套）</a></li>--}}
	                    <li><a href="/broker/@if(!empty($data->_id)){{$data->_id}}@endif/comm/{{$k}}">{{$val['name']}}（{{$val['total']}}套）</a></li>
	            @endforeach
	
	        </ul>
        </div>
        <div class="flex_btn">展开</div>
    </div>
    @endif
</div>
<script>
    $("#ta").on('keyup', function(){
       if($("#ta").val().length > 50){
           $("#ta").val($("#ta").val().substr(0, 49)) ;
       }
    });
    $("#btn_message").click(function(){
        var uname = formTest("[name='uname']", /.+?/, "#uname", '姓名不能为空!');
         var phone = formTest("[name='phone']", /^1[3578]\d{9}$/, "#phone", '输入合法的11位电话号码!');
        var msg = formTest("[name='msg']",  /.{1,50}/, "#msg", '输入1~50位留言信息!');

        if (uname && phone && msg ) {
            $.ajax({
                url : '/brokermsg',
                data : {
                    id : $('input[name=id]').val(),
                    _token :$('input[name=_token]').val(),
                    uname : $('input[name=uname]').val(),
                    phone: $('input[name=phone]').val(),
                    msg : $('#ta').val()
                },
                type : 'post',
                success : function (msg){
                  $('.tip').show();
                    $(".mess").hide();
                    if(msg == 1){
                        $('.tip').show();
                        $('.ok').show();
                        setTimeout(function () { $('.ok').hide(); $('.mess').show();$('#ta').val('');$('input[name=uname]').val('');$('input[name=phone]').val('')}, 3000);
                    }else{
                        $('.tip').show();
                        $('.ok').hide();
                        $('.error').show();
                        setTimeout(function () { $('.error').hide(); $('.mess').show();}, 3000);
                    }
                }
            })
        }
    });

    //表单正则验证函数
    function formTest(selector,pattern,errorObj,errorMsg){
        var value=trim($(selector).val());
        var re=value.match(pattern);
        if(re == null){
            $(errorObj).text(errorMsg);
            return false;
        }else{
            $(errorObj).text('');
            return value;
        }
    }
    function trim(str) {
        return str.replace(/(^\s+)|(\s+$)/g, "");
    }
    //验证提示函数
    function errorHint(errorObj,errorMsg){
        $(errorObj).text(errorMsg);
    }
    
    //服务楼盘折叠展示
    var mesBox=$('.mes_list');
    var oh=$('.mes_list').height();
    var mesUl=$('.mes_list ul');
    var flexBtn=$('.flex_btn');
	if($('.mes_list ul').height()>oh){
		flexBtn.show();
	}
    
    flexBtn.click(function(){
    	if($(this).html()=='展开'){
    		$('.mes_list').css('maxHeight',$('.mes_list ul').height()+'px');
    		$(this).html('收起');
    	}else{
    		$('.mes_list').css('maxHeight',oh+'px');
    		$(this).html('展开');
    	}
    	
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</script>
