@include('user.majorinfo.header')
<div class="user repair_info">
  <p class="info_title">为了您更好的使用搜房平台，请按照以下步骤完善相关信息。</p>
  <p class="colorfe xg" style="display:none;"><i></i>设置成功</p>
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
      <dt class="back_color colorff">第三步</dt>
      <dd class="color_blue">3.账户安全</dd>
    </dl>
  </div>
  <div class="safe">
    <dl class="progress">
      <input type="hidden" id="score" value="{{$score}}">
      <dt><span id="scoreColor"></span></dt>
      <dd id="scoreNum" class="fontA">80%</dd>
    </dl>
    <div class="safe_nav">
      <dl>
        <dt></dt>
          <a class="modaltrigger phone" href="#change_pwd">
            <dd class="color_blue">已绑定手机</dd>
          </a>
      </dl>
      <dl>
        <dt></dt>
          <a class="modaltrigger email" href="#email">
            <dd>
              @if(!empty($info->email))
              <font color="#3281f6">已绑定密保邮箱</font>
              @else
              设定密保邮箱
              @endif
            </dd>
          </a>
      </dl>
      <dl>
        <dt></dt>
          <a class="modaltrigger problem" href="#problem">
              <dd>
                @if(!empty($secu))
                <font color="#3281f6">已设置密保问题</font>
                @else
                设置密保问题
                @endif
              </dd>
          </a>
      </dl>
    </div>
    <p class="submit"><input type="button" onclick="window.location.href='/majorinfo/brokerId';" class="an back_color no_left" value="上一步"><input type="button" class="an back_color" value="提交"></p>
  </div>
</div>
<div class="change_tel" id="change_pwd">
  <span class="close" onClick="$(this).parent().hide();$('#lean_overlay').hide();"></span>
  <h2>更换密保手机号</h2>
  <div class="change1">
    <p class="p1">为了保证你的账户安全，更换密保手机号前请先进行安全验证</p>
    <p class="p2">
      你当前手机号是：<span class="fontA">{{$info->mobile}}</span>
      <span id="current_mobile1_error" style="position:relative;left:30px;color:red;font-size:10px;height:10px;"></span>
    </p>
    <form id="changeform" name="changeform" method="post">
      <p>
        <input type="text" class="txt" id="current_mobile1" placeholder="请输入完整的手机号码">
      </p>
      <p><input type="button" class="btn back_color" value="确定" id="edit_mobile1"></p>
    </form>
    <p class="p3">如你的密保工具都已无法使用，<a href="#">请点此申诉</a>，成功后可更换。</p>
  </div>
  <div class="change2" style="display:none;">
    <p class="p1">请输入您要绑定的手机号，绑定后即可用该手机号登录搜房</p>
    <p class="p_tel">
      <label>手机号</label>
      <input type="text" id="edit_mobile2" class="tel_txt">
      <span class="clear"></span>
      <span id="edit_mobile2_error" style="position:relative;top:-9px;left:49px;color:red;font-size:10px;height:10px;"></span>
    </p>
    <p class="p_code">
      <label>验证码</label>
      <input type="text" id="verify_code" class="tel_txt code_txt">
      <input type="button" class="code_btn back_color" id="send_verify" value="获取验证码">
      <span class="clear"></span>
      <span id="edit_mobile3_error" style="position:relative;top:-6px;left:-140px;color:red;font-size:10px;height:10px;"></span>
    </p>
    <p class="no_margin"><input type="button" class="btn back_color" id="testing_vcode" value="确定" ></p>
    <ul class="prompt">
      <li><span></span>你可使用此密保手机号找回密码及登录</li>
      <li><span></span>请勿随意泄露手机号，以防被不法分子利用，骗取账号信息</li>
    </ul>
  </div>
  <div class="change3" style="display:none;">
    <p class="p"><i></i>更换密保手机号成功</p>
  </div>
</div>
<div class="change_tel" id="email">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>绑定邮箱</h2>
  <div class="change2">
    <p class="p1">请输入您要绑定的邮箱，绑定后即可用该邮箱号登录搜房</p>
    <p class="p_tel">
      <label>邮箱</label>
      <input type="text" id="emailinfo" value="" class="txt">
      <div class="clear"></div>
      <span class="ema"  id="res_emailerror"></span>
    </p>
    <p class="no_margin"><input type="button" id="emailsendsub" class="btn back_color" value="发送验证邮件"></p>
  </div>
</div>
<div class="change_tel" id="problem" style="top:100px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>设置安全问题</h2>
  <div class="change2">
    <p class="p1">请设置您的安全问题，保护您的账户安全</p>
    <ul class="problem">
        <p id="res_repeat" style="color:red;font-size:16px;text-align:center;"></p>
        <li>
          <label>问题一</label>
          <div class="problem_msg">
            <a class="brith"><span class="fontA" id="problemOne" value="0">请选择问题</span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul style=" left:0;">
                @if(isset($question))
                @foreach($question as $qval)
                <li class="problemOnelist" value="{{$qval->id}}">{{$qval->question}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
           </div>
        </li>
        <li>
          <label>答案</label>
          <input type="text" id="answerOne" value="" class="txt">
          <div class="clear"></div>
          <span class="pro2" id="res_answerOne"></span>
        </li>
        <li>
          <label>问题二</label>
          <div class="problem_msg">
            <a class="brith"><span class="fontA" id="problemTwo"  value="0">请选择问题</span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul style=" left:0;">
                @if(isset($question))
                @foreach($question as $qval)
                <li class="problemTwolist" value="{{$qval->id}}">{{$qval->question}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
           </div>
        </li>
        <li>
          <label>答案</label>
          <input type="text" id="answerTwo" value="" class="txt">
          <div class="clear"></div>
          <span class="pro2" id="res_answerTwo"></span>
        </li>
        <li>
          <label>问题三</label>
          <div class="problem_msg">
            <a class="brith"><span class="fontA" id="problemThree"  value="">请选择问题</span><i></i></a>
            <div class="type" style="display:none;">
              <p class="top_icon"></p>
              <ul style=" left:0;">
                @if(isset($question))
                @foreach($question as $qval)
                <li class="problemThreelist" value="{{$qval->id}}">{{$qval->question}}</li>
                @endforeach
                @endif
              </ul>
            </div>  
           </div>
        </li>
        <li>
          <label>答案</label>
          <input type="text" id="answerThree" value="" class="txt">
          <div class="clear"></div>
          <span class="pro2" id="res_answerThree"></span>
        </li>
        <li>
            <input type="button" class="btn hui" disabled="true" style="cursor:pointer;" id="answerSubmit" value="提交">
        </li>
      </ul>
  </div>
</div>
@include('user.majorinfo.footer')