@include('user.majorinfo.header')
<div class="user repair_info">
  <p class="info_title">为了您更好的使用搜房平台，请按照以下步骤完善相关信息。</p>
  <!-- <p class="colorfe xg"><i></i>上传成功</p> -->
  <div class="bs">
      <dl>
        <dt class="back_color colorff">第一步</dt>
        <dd class="color_blue">1.补充信息</dd>
      </dl>
      <span></span>
      <dl>
        <dt class="back_color colorff">第二步</dt>
        <dd class="color_blue">2.身份认证</dd>
      </dl>
      <span></span>
      <dl>
        <dt>第三步</dt>
        <dd>3.账户安全</dd>
      </dl>
    </div>
  <div class="rz_id">
    <p>

      <label>身份证号：</label>
      <input type="text" id="idCard" name="idCard" value="{{$broker->idCard}}" class="txt">
      <div class="clear"></div>
      <span class="res_broker" id="res_idCard"></span>
    </p>
    <div class="id_msg margin_b">
      <label>身份证照：</label>
      <div class="id">
        <dl class="margin_r">
          <dt>
            @if(empty($broker->idCardPicPlus))
            <img src="../../image/id.jpg" id="IdCardP" alt="">
            @else
            <img src="{{config('imgConfig.imgSavePath')}}{{$broker->idCardPicPlus}}" id="IdCardP" alt="">
            @endif
            <input type="button" class="btn back_color" id="IdCardPlusUpload" value="上传" />
            <input type="file" id="IdCardPlus" class="btn1">
          </dt>
          <dd>身份证正面照</dd>
        </dl>
        <dl class="margin_right">
          <dt><img src="../../image/id.jpg" alt=""></dt>
          <dd>示例</dd>
        </dl>
        <dl class="margin_r">
          <dt>
            @if(empty($broker->idCardPicMinus))
            <img src="../../image/id.jpg" id="IdCardM" alt="">
            @else
            <img src="{{config('imgConfig.imgSavePath')}}{{$broker->idCardPicMinus}}" id="IdCardM" alt="">
            @endif
            <input type="button" class="btn back_color" id="IdCardMinusUpload" value="上传" />
            <input type="file" id="IdCardMinus" class="btn1">
          </dt>
          <dd>身份证反面照</dd>
        </dl>
        <dl>
          <dt><img src="../../image/id1.jpg" alt=""></dt>
          <dd>示例</dd>
        </dl>
        <dl class="margin_r">
          <dt>
            @if(empty($broker->idCardPicAnd))
            <img src="../../image/id.jpg" id="IdCardA" alt="">
            @else
            <img src="{{config('imgConfig.imgSavePath')}}{{$broker->idCardPicAnd}}" id="IdCardA" alt="">
            @endif
            <input type="button" class="btn back_color" id="IdCardAndUpload" value="上传" />
            <input type="file" id="IdCardAnd" class="btn1">
          </dt>
          <dd>头举身份证正面照</dd>
        </dl>
        <dl class="margin_right">
          <dt><img src="../../image/id.jpg" alt=""></dt>
          <dd>示例</dd>
        </dl>
      </div>
    </div>
    <div class="clear"></div>
    <span class="res_broker res_pic" id="res_idcard"></span>
    <p>
      <label>工牌号：</label>
      <input type="text" id="jobNum" name="jobNum" value="{{$broker->jobNum}}" class="txt">
      <div class="clear"></div>
      <span class="res_broker" id="res_jobCard"></span>
    </p>
    <div class="id_msg margin_b">
      <label>工牌照：</label>
      <div class="id">
        <dl class="margin_r">
          <dt>
            @if(empty($broker->jobCard))
            <img src="../../image/id.jpg" id="CardJob" alt="">
            @else
            <img src="{{config('imgConfig.imgSavePath')}}{{$broker->jobCard}}" id="CardJob" alt="">
            @endif
            <input type="button" class="btn back_color" id="jobCardUpload" value="上传" />
            <input type="file" id="jobCard" class="btn1">
          </dt>
          <dd>身份证正面照</dd>
        </dl>
        <dl class="margin_right">
          <dt><img src="../../image/id.jpg" alt=""></dt>
          <dd>示例</dd>
        </dl>
      </div>
    </div>
    <div class="clear"></div>
    <span class="res_broker res_pic" id="res_job"></span>
    <div class="id_msg">
      <label>名片照：</label>
      <div class="id">
        <dl class="margin_r">
          <dt>
            @if(empty($broker->nameCard))
            <img src="../../image/id.jpg" id="CardName" alt="">
            @else
            <img src="{{config('imgConfig.imgSavePath')}}{{$broker->nameCard}}" id="CardName" alt="">
            @endif
            <input type="button" class="btn back_color" id="nameCardUpload" value="上传" />
            <input type="file" id="nameCard" class="btn1">
          </dt>
          <dd>身份证正面照</dd>
        </dl>
        <dl class="margin_right">
          <dt><img src="../../image/id.jpg" alt=""></dt>
          <dd>示例</dd>
        </dl>
      </div>
    </div>
    <div class="clear"></div>
    <span class="res_broker res_pic" style="top:-13px;" id="res_name"></span>
    <input type="hidden" id="idcardzheng" value="{{$broker->idCardPicPlus}}">
    <input type="hidden" id="idcardfan" value="{{$broker->idCardPicMinus}}">
    <input type="hidden" id="idcardand" value="{{$broker->idCardPicAnd}}">
    <input type="hidden" id="job" value="{{$broker->jobCard}}">
    <input type="hidden" id="name" value="{{$broker->nameCard}}">
    <p class="submit"><input type="button" onclick="window.location.href='/majorinfo/repairinfo';"class="btn back_color" value="上一步"/><input type="button" id="saveCard" class="btn back_color" value="下一步"/></p>
  </div>
</div>
@include('user.majorinfo.footer')