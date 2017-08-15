@include('agent.agent_layout.navbar')
@include('agent.agent_layout.sidebar')
  <div class="main_r" id="main_r">
    <p class="right_title border_bottom">
      <a href="newBMZz.htm" class="click">创建新楼盘</a>
    </p>
    <div class="write_msg">
      <div class="add_build"><a href="addComm" class="btn back_color">添加新楼盘</a></div>
      <form action="buildList" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
      <ul class="input_msg query_tj">
        <li>
          <label class="width4">新盘名称：</label>
          <input type="text" class="txt width1" name="buildName" @if(!empty($name)) value="{{$name}}" @endif />
          <p class="query">
            <input type="submit" class="btn back_color" value="查询"/>
          </p>
         </li>
         <li>
          <label class="width4">创建时间：</label>
          <input class="laydate-icon" id="kai" name="timeStart" @if(!empty($timeStart)) value="{{$timeStart}}" @endif />
          <span class="tishi" style="margin:0 5px;">至</span>
          <input class="laydate-icon margin_r" id="jiao" name="timeEnd" @if(!empty($timeEnd)) value="{{$timeEnd}}" @endif />
          <label class="width4">物业类型：</label>
          <input type="radio" class="radio" name="audit" value="" @if(empty($type1)) checked="checked" @endif />
          <span class="tishi">不限</span>
          <input type="radio" class="radio" name="audit" value="1" @if(!empty($type1) && $type1 == 1) checked="checked" @endif />
          <span class="tishi">住宅</span>
          <input type="radio" class="radio" name="audit" value="2" @if(!empty($type1) && $type1 == 2) checked="checked" @endif />
          <span class="tishi">写字楼</span>
          <input type="radio" class="radio" name="audit" value="3" @if(!empty($type1) && $type1 == 3) checked="checked" @endif />
          <span class="tishi">商铺</span>
         </li>
      </ul>
      </form>
    </div>
    <div class="examine">
      <table class="audit">
        <tr>
          <th width="700">楼盘信息</th>
          <th width="100">完成度</th>
          <th width="120">操作</th>
        </tr>
      @if(!empty($community->items()))
        @foreach($community as $comm)
        <tr>
          <td>
            <div class="build_list">
             <dl>
               <dt>
              @if(!empty($comm->titleImg))
              @foreach($comm->titleImg as $img)
                <a href=""><img src="{{$img->fileName}}"></a>
              @endforeach
              @endif
                <a href="#" class="img_name">{{$comm->name}}</a>
               </dt>
               <dd class="margin_l">
                 <p class="build_name"><a href="#" class="name">{{$comm->name}}</a>
                  <a class="state subway type_bar">@foreach(explode('|', $comm->type2) as $t) {{config('communityType2.'.$t)}} - @endforeach</a>
                </p>
                 <p class="finish_data color8d marginT">
                  <span>[{{$comm->cityName}}-{{$comm->cityAreaName}}-{{$comm->businessAreaName}}]</span>&nbsp;&nbsp;
                  <span class="color8d">{{$comm->address}}<i class="map_icon"></i></span>
                 </p>
                 <p class="finish_data color8d">创建时间：{{date('Y-m-d',strtotime($comm->timeCreate))}}</p>
               </dd>
             </dl>
            </div>
          </td>
          <td><a class="modaltrigger statis" value="{{$comm->statis}}" href="#wcd">{{$comm->score}}%</a></td>
          <td><a href="Comminfo?communityId={{$comm->id}}&typeInfo={{substr(str_replace('|',',',$comm->type2),0,3)}}">编辑</a>&nbsp;&nbsp;
              <a class="modaltrigger" href="#tj">提交</a>&nbsp;&nbsp;
              <a class="modaltrigger getdel" href="#del" value="{{$comm->id}}">删除</a></td>
        </tr>
        @endforeach
      @else
        <tr>
          <td colspan="7">暂无数据</td>
        </tr>
      @endif
        <tr>
          <td colspan="3">
            {!!$community->render()!!}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div class="change_tel" id="tj" style="top:250px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>提交审核</h2>
  <div class="change3">
    <p class="p" style="width:200px;"><i></i>您确定提交审核吗?</p>
  </div>
  <div class="submit">
    <a class="btn back_color margin_r" href="../examine/viaing.htm">确定</a>
    <a class="btn back_color" onClick="$('#tj').hide(); $('#lean_overlay').hide();">取消</a>
  </div>
</div>

<div class="change_tel" id="del" style="top:250px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>确认删除</h2>
  <div class="change3">
    <p class="p" style="width:200px;">确定删除该楼盘吗?</p>
  </div>
  <div class="submit">
    <a class="btn back_color margin_r delete">确定</a>
    <a class="btn back_color" onClick="$('#del').hide(); $('#lean_overlay').hide();">取消</a>
  </div>
</div>

<div class="change_tel" id="wcd" style="top:150px;">
  <span class="close" onClick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
  <h2>楼盘创建页面完成度<span class="ts color8d">（红色为：未录入；绿色为:已录入；）</span></h2>
  <div class="page_info">
    <dl class="wc_nav">
      <dt>基础信息</dt>
      <dd class="basic">
        <!-- <a>基础信息</a> -->
      </dd>
    </dl>
    <dl class="wc_nav">
      <dt>详细信息</dt>
      <!-- class-"color096" 绿色, class="colorfe" 红色 -->
      <dd class="details">
        <!-- <a class="color096">普通住宅</a>
        <a class="color096">商住公寓楼</a>
        <a class="color096">精品豪宅</a>
        <a class="color096">别墅</a>
        <a class="colorfe no_r" href="addBXzl.htm">纯写字楼</a>
        <a class="colorfe no_r" href="addBSp.htm">住宅底商</a>
        <a class="colorfe no_r" href="addInfo/addNewBuild/addBGwzx.htm">购物中心</a> -->
      </dd>
    </dl>
    <dl class="wc_nav">
      <dt>楼栋信息</dt>
      <dd class="color096 building">
        <!-- <a class="color096">普通住宅</a>
        <a class="color096">别墅</a>
        <a class="colorfe" href="addInfo/addBan/addBanXzl.htm">纯写字楼</a>
        <a class="colorfe" href="addInfo/addBan/addBanSp.htm">住宅底商</a> -->
      </dd>
    </dl>
    <dl class="wc_nav">
      <dt>户型信息</dt>
      <dd class="color096 room">
        <!-- <a class="color096">普通住宅</a>
        <a class="color096">别墅</a>
        <a class="colorfe" href="addInfo/addLeyout/addLeyoutXzl.htm">纯写字楼</a>
        <a class="colorfe" href="addInfo/addLeyout/addLeyoutSp.htm">住宅底商</a> -->
      </dd>
    </dl>
    <dl class="wc_nav">
      <dt>图片信息</dt>
      <dd class="image">
        <!-- <a class="color096">普通住宅</a>
        <a class="color096">别墅</a>
        <a class="colorfe" href="addInfo/addImage/addImageXzl.htm">纯写字楼</a>
        <a class="colorfe" href="addInfo/addImage/addImageSp.htm">住宅底商</a> -->
      </dd>
    </dl>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/laydate/laydate.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<script>

$(function(){
  $('#xiajia').submit(function(e){
    return false;
  });
  //弹出层调用语句
  $('.modaltrigger').leanModal({
    top:110,
    overlay:0.45,
    closeButton:".hidemodal"
  });
});
</script>
<script>
;!function(){
  laydate({
   elem: '#kai'
  }),
  laydate({
   elem: '#jiao'
  })
}();
</script>
<script>
  // 获取需要删除楼盘的id
  var getdel;
  $('.getdel').click(function(){
    getdel = $(this).attr('value');
  });
  // 删除楼盘
  $('.delete').click(function(){
    var _token = $('input[name="_token"]').val();
    $.ajax({
      url  : 'buildList',
      type : 'post',
      data : {
        _token:_token,
        getdel:getdel
      },
      success : function(result){
        if(result == 1){
          $('#del').hide(); 
          $('#lean_overlay').hide();
          window.location.href="buildList";
        }
      }
    });
  });

  // 获取需要统计填写信息的楼盘id
  var statisId;
  $('.statis').click(function(){
        var statis = eval( '(' + $(this).attr('value') + ')' );
        // console.log(statis);return false;
        var type2_ch = {
                        '101':'住宅底商',
                        '102':'商业街商铺',
                        '103':'临街门面',
                        '104':'写字楼配套底商',
                        '105':'购物中心',
                        '106':'其它',
                        '201':'纯写字楼',
                        '203':'商业综合体楼',
                        '204':'酒店写字楼',
                        '301':'普通住宅',
                        '302':'经济适用房',
                        '303':'商住公寓楼',
                        '304':'别墅',
                        '305':'精品豪宅',
                        '306':'平方',
                        '307':'四合院'
                      };
        // 循环查出基础信息是否填写
        var communityId = statis.comm.id;
        
        // 将查询到的type2转化成数组
        var details = statis.comm.type2.split('|');

        if(statis.comm.score != 0 ){
          $('.basic').html('<a class="color096" href="Comminfo?communityId='+communityId+'">基础信息</a>');
        }else{
          $('.basic').html('<a class="colorfe" href="Comminfo?communityId='+communityId+'">基础信息</a>');
        }

        
        

        // 查询到的楼栋表对应楼盘的楼栋
        var building = statis.build;
        // 将查询发挥的数组对象装化成数组
        var building_arr = [];
        for(b in building){
          building_arr.push(building[b].type2);
        }
        // console.log(building_arr);
        var building_str = building_arr.join();
        // console.log(building_str);

        var room = statis.room;
        var room_arr = [];
        for(r in room){
          room_arr.push(room[r].type2);
        }
        // console.log(room_arr);
        var room_str = room_arr.join();
        // console.log(room_str);

        var image = statis.image;
        var image_arr = [];
        for( i in image){
          image_arr.push(image[i].cType2);
        }
        // console.log(image_arr);
        var image_str = image_arr.join();
        // console.log(image_str);

        var list_details = '';
        var list_building = '';
        var list_room = '';
        var list_image = '';
        for(d in details){
          // console.log(details[d]);
          var typeGetInfo = 'type'+details[d]+'Info';
          // 循环查出所有typexxxInfo 的信息是否填写
          if(statis.comm[typeGetInfo] == ''){
            var clas = 'class="colorfe"';
          }else{
            var clas = 'class="color096"';
          }
          list_details += '<a '+clas+' href="/addBasicHouse?communityId='+communityId+'&typeInfo='+details[d]+'">'+type2_ch[details[d]]+'</a>';
          
          // 循环查询出对应的楼栋表是否有楼栋
          if(building_str.indexOf(details[d]) == -1){
            var classB = 'class="colorfe"';
          }else{
            var classB = 'class="color096"';
          }
          // 循环查出楼栋表中的type2
          list_building += '<a '+classB+' href="/addBuilding?communityId='+communityId+'&typeInfo='+details[d]+'">'+type2_ch[details[d]]+'</a>';

          // 循环查询出对应的楼盘是否有户型
          if(room_str.indexOf(details[d]) == -1){
            var classR = 'class="colorfe"';
          }else{
            var classR = 'class="color096"';
          }
          // 循环查出户型表中的type2
          list_room += '<a '+classR+' href="/addRoom?communityId='+communityId+'&typeInfo='+details[d]+'">'+type2_ch[details[d]]+'</a>';

          // 循环查出对应的楼盘是否有相册
          if(image_str.indexOf(details[d]) == -1){
            var classI = 'class="colorfe"';
          }else{
            var classI = 'class="color096"';
          }
          // 循环出图片表中的type2
          list_image += '<a '+classI+' href="/buildaddimage?communityId='+communityId+'&typeInfo='+details[d]+'" >'+type2_ch[details[d]]+'</a>';
        }
        // 写入详细信息 
        $('.details').html(list_details);
        // 写入楼栋信息
        $('.building').html(list_building);
        // 写入户型信息
        $('.room').html(list_room);
        // 写入图片
        $('.image').html(list_image);
  });
  $('.type_bar').each(function(){
      var bar = $(this).text();
      $(this).text( bar.substr(0, (bar.length - 2)));
  });
  /*xalert({
    title:'sss',
    content:'dddddd',
    url:'http://www.baidu.com',
    time:4
  });*/
</script>
</body>
</html>
