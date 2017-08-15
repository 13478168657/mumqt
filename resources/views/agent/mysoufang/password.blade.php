@include('agent.mysoufang.header')
@include('agent.mysoufang.left')
  <div class="main_r" id="main_r">
    <p class="right_title border_bottom">
      <a href="#" class="click">修改密码</a>
    </p>
    <div class="write_msg">
      <ul class="input_msg">
        <li>
          <label class="width4"><span class="dotted colorfe">*</span>旧密码：</label>
          <input type="password" id="oldPwd" value="" class="txt width1">
          <span id="res_oldPwd" style="color:red; margin-left:10px;"></span>
        </li>
        <li>
          <label class="width4"><span class="dotted colorfe">*</span>新密码：</label>
          <input type="password" id="newPwd1" value="" class="txt width1">
          <span id="res_newPwd1" style="color:red; margin-left:10px;"></span>
        </li>
        <li>
          <label class="width4"><span class="dotted colorfe">*</span>确认密码：</label>
          <input type="password" id="newPwd2" value="" class="txt width1"/>
          <span id="res_newPwd2" style="color:red; margin-left:10px;"></span>
        </li>
      </ul>
    </div>
    <p class="submit">
      <input class="btn back_color" id="submitPwd" readonly style="margin-left:200px; float:left;" value="提交" />
    </p>
  </div>
</div>
<input type="hidden" id="token" value="{{csrf_token()}}">
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
</body>
</html>
<script type="text/javascript" src="/js/mysoufang.js?v={{Config::get('app.version')}}"></script>
