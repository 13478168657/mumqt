@include('user.majorinfo.header')
<div class="user repair_info">
  <p class="info_title">为了您更好的使用搜房平台，请按照以下步骤完善相关信息。</p>
  <!-- <p class="colorfe xg"><i></i>修改成功</p> -->
  <div class="bs">
      <dl>
        <dt class="back_color colorff">第一步</dt>
        <dd class="color_blue">1.补充信息</dd>
      </dl>
      <span></span>
      <dl>
        <dt>第二步</dt>
        <dd>2.身份认证</dd>
      </dl>
      <span></span>
      <dl>
        <dt>第三步</dt>
        <dd>3.账户安全</dd>
      </dl>
    </div>
  <div class="user_r">
    <div class="edit_msg">
      <ul class="msg_contant">
        <li>
          <label class="label">用户名</label>
          <span>{{Auth::user()->userName}}</span>
        </li>
        <li>
          <label class="label">真实姓名</label>
          <input type="text" id="realName" name="realName" value="{{$info->realName}}" class="txt">
          <div class="clear"></div>
          <span class="res_info" id="res_realName"></span>
        </li>
        <li>
          <label class="label">性别</label>
          <span><input type="radio" name="gender" value="1" @if($info->gender == 1) checked @endif>&nbsp;男</span>
          <span class="margin_l"><input type="radio" name="gender" value="2" @if($info->gender == 2) checked @endif>&nbsp;女</span>
          <span class="margin_l"><input type="radio" name="gender" value="0" @if($info->gender == 0) checked @endif>&nbsp;保密</span>
          <div class="clear"></div>
          <span class="res_info" id="res_gender"></span>
        </li>
        <li>
          <label class="label">出生日期</label>
          <div >
              <span><input type="text" class="txt" name="birthday" id="birthday" value="{{$info->birthday}}" readonly></span>
          </div>
          <div class="clear"></div>
          <span class="res_info" id="res_birthday"></span>
        </li>
        <li>
          <label class="label">所属地区</label>
          <div class="birth_time">
            <input type="hidden" id="provinceId" value="{{$info->provinceId}}">
            <input type="hidden" id="cityId" value="{{$info->cityId}}">
            <input type="hidden" id="cityAreaId"  value="{{$info->cityAreaId}}">
            <a class="brith"><span class="fontA" id="result_provinceId"  value=""></span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul style=" left:0;" id="province_list">
                @if(isset($province))
                @foreach($province as $proval)
                <li value="{{$proval->id}}" class="select_provinceId">{{$proval->name}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
          </div>
          <div class="birth_time">
            <a class="brith"><span class="fontA" id="result_cityId" value=""></span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul style="left:-119px;" id="city_list" >
                @if(isset($city))
                @foreach($city as $cityval)
                <li value="{{$cityval->id}}" class="select_cityId">{{$cityval->name}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
          </div>
          <div class="birth_time">
            <a class="brith"><span class="fontA" id="result_cityAreaId" value=""></span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul id="cityArea_list" >
                @if(isset($cityArea))
                @foreach($cityArea as $areaval)
                <li value="{{$areaval->id}}" class="select_cityAreaId">{{$areaval->name}}</li>
                @endforeach
                @endif
               
              </ul>
            </div>  
          </div>
          <div class="clear"></div>
          <span class="res_info" id="res_address"></span>
        </li>
        <li>
          <label class="label">所属公司</label>
          <input type="text" id="company" name="company" value="{{$info->company}}" class="txt">
          <div class="clear"></div>
          <span class="res_info" id="res_company"></span>
        </li>
        <li>
          <label class="label">所属门店</label>
          <input type="text" id="shopName" name="shopName" value="{{$info->shopName}}" class="txt">
          <div class="clear"></div>
          <span class="res_info" id="res_shopName"></span>
        </li>
      </ul>
      <dl class="edit_head" id="photoShow">
         @if(!empty($info->photo))
        <dt><img src="{{config('imgConfig.imgSavePath')}}{{$info->photo}}" width="122" height="122" alt=""></dt>
        @else
        <dt><img src="../../image/broker.jpg" width="122" height="122" alt=""></dt>
        @endif
        <input type="hidden" id="brokerPhoto" value="{{$info->photo}}">
        <dd><a class="modaltrigger" href="#change_img">修改头像</a></dd>
        <div class="clear"></div>
        <span class="res_info" style="left:31px;top:7px;" id="res_brokerPhoto"></span>
      </dl>
      <div class="clear"></div>
    </div>
    <div class="depict">
     <p>
       <label>个人描述</label>
       <textarea class="txtarea" id="intro" name="intro">@if($info->intro){{$info->intro}}@endif</textarea>
     </p>
     <div class="clear"></div>
     <span class="res_info" id="res_intro"></span>
     <p><input type="button" class="btn back_color" id="saveInfo" value="下一步"></p>
    </div>
  </div>
</div>
<div class="change_img" id="change_img">
  <span class="close" onClick="$(this).parent().hide();$('#lean_overlay').hide();"></span>
  <h2>修改头像</h2>
  <form id="loginform" name="loginform" method="post" action="/myinfo/imgUpload" >
    <div class="change_top">
      <div class="upload">
        <div id="frame" class="frame" style="width: 100%; height:auto; float: left;  overflow: hidden; display: none;">
          <img id="photo" alt="拍照的图片" />
        </div>
      </div>
      <div class="upload_img">
        <input type="button" class="btn" id="picUpload" value="上传图片">
        <input type="file" id="upload" style="filter: alpha(opacity = 0); opacity: 0; width: 144px; height: 38px;display:none;" />
        <dl class="effect">
          <div id="preview" style="width:140px; height:140px; border-radius:70px; overflow: hidden; position: relative;float: left; margin-top: 20px;">
            @if(!empty($info->photo))
            <img src="{{config('imgConfig.imgSavePath')}}{{$info->photo}}" id="photo1"  alt="拍照的图片" />
            @else
            <img id="photo1" src="../../image/broker.jpg" width="100%" alt="拍照的图片" />
            @endif
            <span style="position: absolute; top: 0px; left: 0px; background: url(../../images/border_user.png) no-repeat; display: inline-block; width: 140px; height: 140px;"></span>
          </div>
         <dd>预览效果</dd>
        </dl>
        <p>图片仅支持JPEG、BMP、PENG格式</p>
      </div>
    </div>
    <div class="clear"></div>
    <span id="photoerror" style="position:relative;left:265px;top:10px;text-algin:center;color:red;font-size:10px;height:10px;"></span>
    <p class="upload_btn">
      <input type="button" id="picSub" class="keep" value="保存">
      <input type="button" class="cancel" value="取消" id="cancel">
    </p>
    <input id="x1" name="x1" type="hidden" /> 
    <input id="y1" name="y1" type="hidden" />
    <input id="CutWidth" name="CutWidth" type="hidden" /> 
    <input id="CutHeight" name="CutHeight" type="hidden" /> 
    <input id="imgdata" name="imgdata" type="hidden" /> 
    <input id="imgcut" name="imgcut" value="0" type="hidden" /> 
    <input id="PicWidth" name="PicWidth" type="hidden" /> 
    <input id="PicHeight" name="PicHeight" type="hidden" />
  </form>
</div>
@include('user.majorinfo.footer')