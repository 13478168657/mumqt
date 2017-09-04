@extends('mainlayout')
@section('title')
    <title>个人后台</title>
@endsection
@section('head')
    <link rel="stylesheet" type="text/css" href="/css/personalManage.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css?v={{Config::get('app.version')}}">
    <link rel="stylesheet" type="text/css" href="http://sandbox.runjs.cn/uploads/rs/351/8eazlvc1/imgareaselect-anima.css" />
@endsection
@section('content')
<div class="user">
    @include('user.userHomeLeft')
    <div class="user_r">
    <h2 class="edit">普通用户申请转换成职业经纪人<span class="em">请补充以下信息，才能重置您的身份</span></h2>
    <div class="edit_msg">
        <ul class="msg_contant" style=" width:830px;">
            <li>
                <label class="label">所属城市</label>
                <div class="birth_time">
                    <a class="brith"><span class="fontA" id="proId" value="">省</span><i></i></a>
                    <div class="type" style="display:none;">
                        <p class="top_icon"></p>
                        <ul style=" left:0;">
                        @if(!empty($province))
                            @foreach($province as $val)
                            <li value="{{$val->id}}" class="select_province">{{$val->name}}</li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
                <div class="birth_time">
                    <a class="brith"><span class="fontA" id="cityId" value="">市</span><i></i></a>
                    <div class="type" style="display:none;">
                        <p class="top_icon"></p>
                        <ul style="left:0px;" id="cityList">
                            <li>请选择省</li>
                        </ul>
                    </div>
                </div>
                <span class="ts"></span>
            </li>
            <li>
                <label class="label">服务商圈</label>
                <div class="birth_time">
                    <a class="brith"><span class="fontA" id="areaId" value="">区</span><i></i></a>
                    <div class="type" style="display:none;">
                        <p class="top_icon"></p>
                        <ul style=" left:0;" id="areaList">
                            <li>请选择市</li>
                        </ul>
                    </div>
                </div>
                <div class="birth_time">
                <a class="brith"><span class="fontA" id="businessId" value="">商圈</span><i></i></a>
                <div class="type" style="display:none;">
                  <p class="top_icon"></p>
                  <ul style="left:0px;" id="businessList">
                    <li>请选择区</li>
                  </ul>
                </div>
                </div>
                <span class="ts"></span>
            </li>
            <li id="mainbusiness">
                <label class="label">主营业务</label>
                <span><input type="checkbox" value="住宅">&nbsp;住宅</span>
                <span class="margin_l"><input type="checkbox" value="商业">&nbsp;商业</span>
                <span class="ts"></span>
            </li>
            <li>
                <label class="label">所属公司</label>
                <input type="text" class="txt company" id="company">
                <input type="hidden" id="companyId" value="">
                <dl style="display:none;" id="companyList">
                    <dd>链家地产</dd>
                    <dd>我爱我家</dd>
                </dl>
                <span class="ts"></span>
            </li>
            <li>
                <label class="label">真实姓名</label>
                <input type="text" class="txt" id="realName" value="">
                <span class="ts"></span>
            </li>
            <li>
                <label class="label">身份证号</label>
                <input type="text" class="txt" id="idcardNum" value="">
                <span class="ts" id="error_idcardNum"></span>
            </li>
            <li class="height">
                <label class="label">身份证照</label>
                <div class="idcard" id="dvMap">
                    <img src="/image/id.jpg" id="img">
                    <a>上传</a>
                    <input type="file" class="file" id="doc" onchange="javascript:setImagePreview('doc','dvMap','img');">
                </div>
            </li>
            <li class="height">
                <label class="label">头像</label>
                <div class="uploadImg">
                    {{--<form id="loginform" name="loginform" method="post" action="/myinfo/imgUpload">--}}
                        <div class="change_top">
                            <div class="upload">
                                <div id="frame" class="frame" style="width: 100%; height:auto; float: left;  overflow: hidden; display:none;">
                                   <img id="photo" src="" style="margin: 0 auto; display:block; color:#ccc;" alt="拍照的图片" />
                                </div>
                            </div>
                            <div class="upload_img">
                                <input type="button" class="btn" id="picUpload" onclick="$('#upload').click();" value="上传图片">
                                <input type="file" id="upload" style="filter: alpha(opacity = 0); opacity: 0; width: 120px; height: 38px; margin-left: -100px;" />
                                <dl class="effect" style="margin-left: 40px; width: 120px;">
                                    <div id="preview" style="width:120px; height:160px; overflow: hidden; position: relative;float: left; margin-bottom: 20px;">
                                        @if(isset($info[0]->photo))
                                            <img id="photo1" src="{{config('imgConfig.imgSavePath')}}{{$info[0]->photo}}" width="100%" alt="拍照的图片" />
                                        @else
                                            <img id="photo1" src="/image/default_broker.png" width="100%" alt="拍照的图片" />
                                        @endif
                                    </div>
                                    <dd>预览效果</dd>
                                </dl>
                                <p>图片仅支持JPEG、BMP、PENG格式</p>
                            </div>
                        </div>
                        <span id="photoerror" style=" text-algin:center;color:red;font-size:12px;height:10px; float:none;"></span>
                        <input id="x1" name="x1" type="hidden" />
                        <input id="y1" name="y1" type="hidden" />
                        <input id="CutWidth" name="CutWidth" type="hidden" />
                        <input id="CutHeight" name="CutHeight" type="hidden" />
                        <input id="imgdata" name="imgdata" type="hidden" @if(isset($info[0]->photo) && !empty($info[0]->photo)) value="{{config('imgConfig.imgSavePath')}}{{$info[0]->photo}}" @else value="" @endif />
                        <input id="imgcut" name="imgcut" value="0" type="hidden" />
                        <input id="PicWidth" name="PicWidth" type="hidden" />
                        <input id="PicHeight" name="PicHeight" type="hidden" />
                    {{--</form>--}}
                </div>
            </li>
        </ul>
    </div>
    <div class="depict">
        <p><input type="button" class="btn back_color" onclick="submit()" value="提交"></p>
        <input type="hidden" value="" id="brokerIdCard">
    </div>
    </div>
</div>
<!-- 头像上传js       -->
<script type="text/javascript" src="/js/jquery.imgareaselect.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/fullAvatarEditor.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/yuImgCut.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/userpicLoad.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
  // 选择头像
$('#upload').change(CheckImage);

    var token = "{{csrf_token()}}";
    var namePatt = /^[\u4E00-\u9FA5]+$/;
    /***********  用户名检测start  **********/
    $('#realName').blur(checkRealName);
    function checkRealName(){
        var nameObj = $('#realName');
        var realName = $.trim(nameObj.val());
        if(realName.length == 0){
            nameObj.next().text('请输入真实姓名');
            return false;
        }
        if(!namePatt.test(realName)){
            nameObj.next().text('真实姓名为中文');
            return false;
        }else{
            nameObj.next().text('');
            return realName;
        }
    }
    /***********  用户名检测end  ************/

    /***********  身份证号检测start  **********/
    var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];// 加权因子;
    var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];// 身份证验证位值，10代表X;
//    $('#idcardNum').focus(function(){
//        $('#error_idcardNum').text('');
//    });
    $('#idcardNum').blur(checkIdCardNum);
    function checkIdCardNum(){
        var cardNum,idcard18,idcard15;
        cardNum = $.trim($('#idcardNum').val());
        if (cardNum.length == 15) {
            idcard15 = isValidityBrithBy15IdCard(cardNum);
            return error_tig(idcard15,cardNum);
        }else if (cardNum.length == 18){
            var a_idCard = cardNum.split("");// 得到身份证数组
            if (isValidityBrithBy18IdCard(cardNum)&&isTrueValidateCodeBy18IdCard(a_idCard)) {
                idcard18 = true;
            }else{
                idcard18 = false;
            }
            return error_tig(idcard18,cardNum);
        }else if(cardNum.length == 0){
            $('#error_idcardNum').text('请输入身份证号码');
            return false;
        }else{
            $('#error_idcardNum').text('身份证号码错误');
            return false;
        }
    }
    // 身份证错误提示
    function error_tig(flag,cardNum){
        var num = cardNum;
        if(!flag){
            $('#error_idcardNum').text('身份证号码错误');
            return false;
        }else{
            $('#error_idcardNum').text('');
            return num;
        }
    }

    function isTrueValidateCodeBy18IdCard(a_idCard) {
        var sum = 0; // 声明加权求和变量
        if (a_idCard[17].toLowerCase() == 'x') {
            a_idCard[17] = 10;// 将最后位为x的验证码替换为10方便后续操作
        }
        for ( var i = 0; i < 17; i++) {
            sum += Wi[i] * a_idCard[i];// 加权求和
        }
        valCodePosition = sum % 11;// 得到验证码所位置
        if (a_idCard[17] == ValideCode[valCodePosition]) {
            return true;
        }
        return false;
    }

    function isValidityBrithBy18IdCard(idCard18){
        var year = idCard18.substring(6,10);
        var month = idCard18.substring(10,12);
        var day = idCard18.substring(12,14);
        var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
        // 这里用getFullYear()获取年份，避免千年虫问题
        if(temp_date.getFullYear()!=parseFloat(year) || temp_date.getMonth()!=parseFloat(month)-1 || temp_date.getDate()!=parseFloat(day)){
            return false;
        }
        return true;
    }

    function isValidityBrithBy15IdCard(idCard15){
        var year =  idCard15.substring(6,8);
        var month = idCard15.substring(8,10);
        var day = idCard15.substring(10,12);
        var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
        // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
        if(temp_date.getYear()!=parseFloat(year) || temp_date.getMonth()!=parseFloat(month)-1 || temp_date.getDate()!=parseFloat(day)){
            return false;
        }
        return true;
    }

    /***********  身份证号检测end  ************/

    // 获得焦点  提示消失
    $('.txt').focus(function(){
        $(this).next().text('');
    });

    // 主营业务点击事件
    var mainBuss = [];
    var mainBussObj = $('#mainbusiness .ts');
    $('#mainbusiness').find('input').click(function(){
        if($(this).prop('checked')){
            mainBuss.push($(this).val());
        }
        if(mainBuss.length > 0){
            mainBussObj.text('');
        }else{
            mainBussObj.text('请选择主营业务');
        }
    });

    //下面用于图片上传预览功能
    function setImagePreview(id1,id2,id3) {
        var imageHidden;
        var docObj = document.getElementById(id1);
        if(id1 == 'doc' && id2 == 'dvMap' && id3 == 'img'){
            imageHidden = '#brokerIdCard';
        }
        var imgObjPreview = document.getElementById(id3);
        if (!docObj.files || !window.FileReader) {
            alert("对不起，您的浏览器暂不支持图片上传操作，请尝试以下方法：\n\  * 改用最新版的Firefox、QQ、IE(9以上)或Chrome浏览器；\n\  * 如果您使用的是360浏览器，请尝试切换到极速或IE11模式。");
            return;
        }
        if(docObj.files &&docObj.files[0])
        {
            // 判断图片格式  并上传
            var len = docObj.files.length;
            if (len > 1) {
                alert("图片张数过多！");
                return false;
            }
            var reader = new FileReader();
            if(!/.(gif|jpg|jpeg|png)/.test(docObj.files[0].type)){
                alert("图片格式不正确！");
                return false;
            }
            reader.onload = function (evt) {
                var strResult = evt.target.result;
                $("#" + id3).attr("src", strResult);
                imgObjPreview.style.display = 'block';
                imgObjPreview.src = strResult;
                uploadPicture(strResult,imageHidden);
            };
            reader.readAsDataURL(docObj.files[0]);
            //火狐下，直接设img属性
//            imgObjPreview.style.display = 'block';

            //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
            //imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
        }else{
            //IE下，使用滤镜0
            docObj.select();
            var imgSrc = document.selection.createRange().text;
            var localImagId = document.getElementById(id2);

            //图片异常的捕捉，防止用户修改后缀来伪造图片
            try{
                localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
            }catch(e) {
                alert("您上传的图片格式不正确，请重新选择!");
                return false;
            }
            imgObjPreview.style.display = 'none';
            document.selection.empty();
        }
        return true;
    }

    // 执行上传操作
    function uploadPicture(strResult,imageHidden){
        $.ajax({
            type : 'POST',
            url : '/myinfo/uploadIdCard',
            async : false,
            data : {
                _token : token,
                imgdata : strResult
            },
            dataType : 'json',
            success : function(msg){
                if(msg.res == 'error'){
                    alert(msg.data);
                }
                if(msg.res == 'success'){
                    $(imageHidden).val(msg.data);
                }
            }
        });
    }

    // 提交保存
    function submit(){
        var provinceId,cityId,areaId,businessId,companyId,companyName,idcard,userRealName,idcardImg,mainBusiness=[];
        var img, x1, y1, CutWidth, CutHeight, imgcut, PicWidth, PicHeight;
        var patt = /\d+/;
        // 所属城市
        provinceId = $('#proId').attr('value');
        if(!patt.test(provinceId)){
            $('#proId').parents('.birth_time').nextAll('.ts').text('请选择省');
            return;
        }
        cityId = $('#cityId').attr('value');
        if(!patt.test(cityId)){
            $('#cityId').parents('.birth_time').nextAll('.ts').text('请选择市');
            return;
        }
        // 服务商圈
        areaId = $('#areaId').attr('value');
        if(!patt.test(areaId)){
            $('#areaId').parents('.birth_time').nextAll('.ts').text('请选择区');
            return;
        }
        businessId = $('#businessId').attr('value');
        if(!patt.test(businessId)){
            $('#businessId').parents('.birth_time').nextAll('.ts').text('请选择商圈');
            return;
        }
        // 主营业务
        $('#mainbusiness').find('input').each(function(){
            if($(this).prop('checked')){
                mainBusiness.push($(this).attr('value'));
            }
        });
        if(mainBusiness.length <= 0){
            $('#mainbusiness .ts').text('请选择主营业务');
            return;
        }
        // 所属公司
        companyId = $('#companyId').val();
        companyName = $.trim($('#company').val());
        var companyNameArray = ['其他','独立经纪人'];
        if(companyId == 0){
            var res = $.inArray(companyName,companyNameArray);
            if(res < 0){
                $('#company').nextAll('.ts').text('请选择所属公司');
                return;
            }else{
                $('#company').nextAll('.ts').text('');
            }
        }
        // 真实姓名
        userRealName = checkRealName();
        if(!userRealName) return;
        // 身份证号码
        idcard = checkIdCardNum();
        if(!idcard) return;
        // 身份证照片
        idcardImg = $.trim($('#brokerIdCard').val());
        if(idcardImg == ''){
            alert('请上传身份证照');
            return;
        }
        // 用户头像
        img = $('#imgdata').val();
        var imgPatt = /http:\/\//;
        if(!imgPatt.test(img)){
            if(img == ''){
                $('#photoerror').text('请上传图片');
                return;
            }else{
                $('#photoerror').text('');
            }
            x1 = $('#x1').val();
            y1 = $('#y1').val();
            CutWidth = $('#CutWidth').val();
            CutHeight = $('#CutHeight').val();
            imgcut = $('#imgcut').val();
            PicWidth = $('#PicWidth').val();
            PicHeight = $('#PicHeight').val();
            if( x1 == '' ||  y1 == ''){
                $('#photoerror').text('请用鼠标选择区域');
                return;
            }else{
                $('#photoerror').text('');
            }
        }

        if(img && idcard && userRealName && idcardImg && img){
            $.ajax({
                type : 'POST',
                url : '/myinfo/brokersave',
                async : false,
                data : {
                    _token : token,
                    provinceId : provinceId,
                    cityId : cityId,
                    areaId : areaId,
                    businessId : businessId,
                    mainBusiness : mainBusiness,
                    companyId : companyId,
                    companyName : companyName,
                    realName : userRealName,
                    idcard : idcard,
                    idcardImg : idcardImg,
                    imgdata:img,
                    x1:x1,
                    y1:y1,
                    CutWidth:CutWidth,
                    CutHeight:CutHeight,
                    imgcut:imgcut,
                    PicHeight:PicHeight,
                    PicWidth:PicWidth
                },
                dataType : 'json',
                success : function(msg){
                    alert(msg.data);
                    if(msg.res == 'success'){
                        window.location.href = msg.url;
                    }
                }
            });
        }
    }

    $(document).ready(function(e) {
        $(".msg_contant .birth_time").click(function (event) {
            $(".type").hide();
            $(this).find(".type").fadeIn();
            $(document).one("click", function () {//对document绑定一个影藏Div方法
                $(".type").hide();
            });
            event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
        });
        $(".msg_contant .birth_time .type").click(function (event) {
            event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
        });

        $(".birth_time .type li").click(function(){
            $(this).parents(".birth_time").find("span").text($(this).text());
            $(this).parents(".birth_time").find("span").attr('value',$(this).attr('value'));
            $(this).parents(".type").hide();
        });

        $('#loginform').submit(function(e){
            return false;
        });
        // 选择效果
        function select(obj){
            obj.parents(".birth_time").find("span").text(obj.text());
            obj.parents(".birth_time").find("span").attr('value',obj.attr('value'));
            obj.parents(".type").hide();
            obj.parents(".birth_time").nextAll('span').text('');
        }
        // 选择省份获得城市列表
        $('.select_province').click(selectProvince);

        function selectProvince(){
            select($(this));
            var proId = $(this).attr('value');
            var url = '/city/getcity';
            var city_list = '';
            $.ajax({
                type:'post',
                url:url,
                data:{
                    _token:token,
                    id:proId
                },
                dataType:'json',
                success:function(data){
                    if(data == 2){
                        return false;
                    }else{
                        for(var i in data){
                            city_list += '<li value="'+data[i].id+'" class="select_city">'+data[i].name+'</li>';
                        }
                        $('#cityList').html(city_list);
                        $('.select_city').click(selectCity);  // 选择城市
                    }
                }
            });
        }

        // 选择城市获得区域列表
        $('.select_city').click(selectCity);

        function selectCity(){
            select($(this));
            var cityId = $(this).attr('value');
            var url = '/city/getcityarea';
            var area_list = '';
            $.ajax({
                type:'post',
                url:url,
                data:{
                    _token:token,
                    id:cityId
                },
                dataType:'json',
                success:function(data){
                    if(data == 2){
                        return false;
                    }else{
                        for(var i in data){
                            area_list += '<li value="'+data[i].id+'" class="select_area">'+data[i].name+'</li>';
                        }
                        $('#areaList').html(area_list);
                        $('.select_area').click(selectArea);  // 选择区域
                    }
                }
            });
        }

        // 选择区域获得商圈列表
        $('.select_area').click(selectArea);

        function selectArea(){
            select($(this));
            var areaId = $(this).attr('value');
            var url = '/city/getbusinessarea';
            var business_list = '';
            $.ajax({
                type:'post',
                url:url,
                data:{
                    _token:token,
                    id:areaId
                },
                dataType:'json',
                success:function(data){
                    if(data == 2){
                        return false;
                    }else{
                        for(var i in data){
                            business_list += '<li value="'+data[i].id+'" class="select_business">'+data[i].name+'</li>';
                        }
                        $('#businessList').html(business_list);
                        $('.select_business').click(selectBusiness);  // 选择商圈
                    }
                }
            });
        }

        // 选择商圈
        $('.select_business').click(selectBusiness);

        function selectBusiness(){
            select($(this));
        }


        // 选择公司
        $('.company').keyup(searchCompany);
        function searchCompany(){
            var obj,name,liHtml;
            obj = $(this);
            obj.nextAll('.ts').text('');
            name = $.trim($(this).val());
            liHtml = '<dd class="companyClick" value="0">其他</dd><dd class="companyClick" value="0">独立经纪人</dd>';
            obj.nextAll('dl').show().html(liHtml);
            if(name == '') return;
            $.ajax({
                type : 'POST',
                url : '/city/getcompany',
                data : {
                    _token : token,
                    name : name
                },
                dataType : 'json',
                success : function(msg){
                    if(msg.length > 0){
                        for(var i = 0; i < msg.length;i++){
                            if(i == 0){
                            	liHtml += '<dd class="match companyClick" value="'+msg[i].id+'">'+msg[i].name+'</dd>';
                            }else{
                            	liHtml += '<dd class="companyClick" value="'+msg[i].id+'">'+msg[i].name+'</dd>';
                            }
                        }
                        obj.nextAll('dl').show().html(liHtml);
                    }
                    $('.companyClick').bind('click',selectCompany);
                }
            });
        }

        // 点击选择公司
        $('.companyClick').click(selectCompany);
        function selectCompany(){
            $('#companyId').val($(this).attr('value'));
            $('#company').val($(this).text());
            $(this).parent().hide();
        }

    });
</script>

@endsection