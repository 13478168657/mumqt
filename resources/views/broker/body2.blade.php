  <div class="broker_msg">
   <div class="broker_info" id="msg_top">
    <p class="broker_title">
      <span>{{(!empty($data->realName)) ? $data->realName : '匿名'}}</span>
      的旗舰网店
    </p>
    <div class="msg_top">
      <dl>
       <dt>
          <a href="">
            @if($data->photo != '')
            {{--<img src="{{config('imgConfig.imgSavePath')}}{{$data->photo}}"> --}}
            <img src="{{get_img_url('userPhoto' , $data->photo)}}" alt="{{(!empty($data->realName)) ? $data->realName : '匿名'}}">
            @else
            <img src="/image/default.png" alt="">
            @endif
          </a>
       </dt>
       <dd>
         <p class="broker_name">
             {{--<span class="color2d">{{(!empty($data->realName)) ? $data->realName : '匿名'}}</span><!-- <i></i> --> --}}
             <span class="color2d">{{(!empty($data->realName)) ? str_limit($data->realName, $limit = 8, $end = '...') : '匿名'}}</span>
             <?php //$enterpriseshopName = \App\Http\Controllers\Utils\RedisCacheUtil::getDataLikeKing('mysql_user', 'enterpriseshop', 'EPS', $data->enterpriseshopId,'companyName'); ?>
             @if(!empty($data->company))
                 {{--<span title="{{$data->company}}" class="broker_company" >[&nbsp;{{mb_substr($data->company, 0, 5, 'utf-8')}}&nbsp;]</span>--}}
                 <span title="{{$data->company}}" class="broker_company" >[&nbsp;{{str_limit($data->company,$limit = 24, $end = '...')}}&nbsp;]
             @else
                 <span class="broker_company">[&nbsp;独立经纪人&nbsp;]</span>
             @endif

         </p>

         <p class="broker_branch">
            服务商圈：
            @if(!empty($data->managebusinessAreaIds))
              <?php $managebusinessAreaIds = explode('|', $data->managebusinessAreaIds); ?>
              @for($i = 0; $i < 2; $i++)
              @if(!empty($managebusinessAreaIds[$i]))
              <a>{{\App\Http\Controllers\Utils\RedisCacheUtil::getBussinessNameById($managebusinessAreaIds[$i])}}</a>
              @endif
              @endfor
            @else
            多商圈
            @endif
         </p>
         <p class="broker_branch">
            主营业务：
            @if(!empty($data->mainbusiness))
            <?php $mainbusiness = explode('|', $data->mainbusiness); ?>
              @for( $i = 0; $i < 2; $i++)
              @if(!empty($mainbusiness[$i]))
              <a>{{config('mianBusiness.'. $mainbusiness[$i])}}</a>
              @endif
              @endfor
            @else
            暂无资料
            @endif
         </p>
         <P class="broker_branch">
            从业时间：
            @if(empty($data->year) || (date('Y',time())-substr($data->year, 0, 4) < 1 ) )
            1年以下
            @else
            {{date('Y',time())-substr($data->year, 0, 4)}} 年以上
            @endif
         </P>
       </dd>
      </dl>
      {{--<p class="company color2d">--}}
      {{--<i></i><i></i><i></i><i></i><i class="click"></i><span class="good subway comment" style="cursor:pointer;">评价Ta</span><a class="good back_color dian">逛逛Ta的店</a></p>--}}
      {{--<p class="company margin_top color2d">--}}
      {{--所属公司：--}}
      {{--@if($data->company != '')--}}
      {{--{{$data->company}}--}}
      {{--@else--}}
      {{--未知--}}
      {{--@endif--}}
      {{--</p>--}}
      {{--<p class="company margin_top color2d">--}}
      {{--所属门店：--}}
      {{--@if($data->shopName != '')--}}
      {{--{{$data->shopName}}--}}
      {{--@else--}}
      {{--暂无--}}
      {{--@endif--}}
      {{--</p>--}}
      {{--<p class="company margin_top color2d">--}}
        {{--从业时间：--}}
        {{--@if(empty($data->year) || (date('Y',time())-substr($data->year, 0, 4) < 1 ) )--}}
        {{--1年以下--}}
        {{--@else--}}
        {{--{{date('Y',time())-substr($data->year, 0, 4)}} 年以上--}}
        {{--@endif--}}
      {{--</p>--}}
      <p class="msg_btn">
        <span class="label">电话号码：</span>
            <span class="font_size">{{$data->mobile}}</span>
      </p>
      <p class="msg_btn">
      <span class="label">虚拟号码：</span>
       <a class="tel" style="text-decoration:none;" onclick="getBrokerNumBr(0,{{$data->id}}, $(this))">点击获取</a>
       <span class="font_size" style="display:none;"></span>
      </p>
      <p class="tel_info">拨打虚拟号码，可隐藏己方电话号码</p>
      {{--<p class="write_msg">--}}
       {{--<a class="write">给我留言</a>--}}
      {{--</p>--}}
      {{--<div class="write_content" style="display:none;">--}}
        {{--<p class="phone name">--}}
          {{--<i></i>--}}
          {{--<input type="text" class="txt colorcd" id="name2" placeholder="请输入你的名字">--}}
        {{--</p>--}}
        {{--<textarea class="txtarea"  id="textarea2"></textarea>--}}
        {{--<p>--}}
        {{--<input type="button" class="sub_msg" value="取消" onClick="$('.write_content').hide(); $('.write_msg').show();">--}}
        {{--<input type="button" class="sub_msg no_margin"  onClick="comment_commit2();"  value="提交信息">--}}
        {{--</p>--}}
      {{--</div>--}}
    </div>
   </div>
   {{--<div class="company_msg">--}}
      {{--<h2>所属机构</h2>--}}
      {{--<p class="logo"><img src="/image/companyLogo.jpg" width="112" height="54"></p>--}}
      {{--<p>门店名称：富力2组</p>--}}
      {{--<p>地址：朝阳区天力街</p>--}}
      {{--<p>--}}
        {{--主营区域：--}}
        {{--@if(!empty($data->managebusinessAreaIds))--}}
        {{--@foreach($data->managebusinessAreaIds as $val)--}}
        {{--{{$val->name}} &nbsp;--}}
        {{--@endforeach--}}
        {{--@else--}}
        {{--无--}}
        {{--@endif--}}
      {{--</p>--}}
      {{--<p>门店店长：</p>--}}
      {{--<p>开店时间：1900-01-01</p>--}}
    {{--</div>--}}
    {{--<div class="angent_build">--}}
      {{--<h2>置业专家</h2>--}}
      {{--<p class="build_name">五矿万科城</p>--}}
      {{--<div class="build_info">--}}
        {{--<dl>--}}
          {{--<dt><img src="/image/new3.jpg"></dt>--}}
          {{--<dd>物业类型：普通住宅</dd>--}}
          {{--<dd>地址：北京市朝阳区东三环中路35号</dd>--}}
          {{--<dd><a>查看房源>></a>&nbsp;&nbsp;<a>查看楼盘详情>></a></dd>--}}
        {{--</dl>--}}
      {{--</div>--}}
      {{--<p class="build_name">富力新城</p>--}}
      {{--<div class="build_info" style="display:none;">--}}
        {{--<dl>--}}
          {{--<dt><img src="/image/new2.jpg"></dt>--}}
          {{--<dd>物业类型：普通住宅</dd>--}}
          {{--<dd>地址：北京市朝阳区东三环中路35号</dd>--}}
          {{--<dd><a>查看房源>></a>&nbsp;&nbsp;<a>查看楼盘详情>></a></dd>--}}
        {{--</dl>--}}
      {{--</div>--}}
      {{--<p class="build_name">潮白河孔雀城</p>--}}
      {{--<div class="build_info" style="display:none;">--}}
        {{--<dl>--}}
          {{--<dt><img src="/image/new1.jpg"></dt>--}}
          {{--<dd>物业类型：普通住宅</dd>--}}
          {{--<dd>地址：北京市朝阳区东三环中路35号</dd>--}}
          {{--<dd><a>查看房源>></a>&nbsp;&nbsp;<a>查看楼盘详情>></a></dd>--}}
        {{--</dl>--}}
      {{--</div>--}}
    {{--</div>--}}
  </div>
<input type="hidden" id="brokerId" value="{{$data->id}}">
