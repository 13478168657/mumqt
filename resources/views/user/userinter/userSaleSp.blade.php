@extends('mainlayout')
@section('title')
  <title>个人出售-商铺</title>
@endsection
@section('head')
  <link rel="stylesheet" type="text/css" href="/css/personalHouse.css?v={{Config::get('app.version')}}">
@endsection
@section('content')
<div class="enter_house shop">
  <div class="house_info">
    @if(!is_numeric($houseId))
      @if(empty($entrust))
        <h2>免费发布出售信息</h2>
      @else
        <h2>免费发布委托信息</h2>
      @endif
      <p class="submenu">
        @if(empty($entrust))
          <a href="/houseHelp/sale/xq">住宅</a>
          <a href="/houseHelp/sale/office">写字楼</a>
        @else
          <a href="/houseHelp/sale/xq/entrust">住宅</a>
          <a href="/houseHelp/sale/office/entrust">写字楼</a>
        @endif
        <span class="click">商铺</span>
      </p>
    @else
      <h2>修改出售信息</h2>
    @endif
    <div class="house_type">
      @if(empty($entrust))
      <form id="saveSaleSp" action="/houseHelp/save/sale/shop">
      @else
      <form id="saveSaleSp" action="/houseHelp/save/sale/shop/entrust">
      @endif
      <p class="title"><span></span>基础信息</p>
      <ul>
        <li class="no_clear">
          <label><span>*</span>城市：</label>
          <div class="js-city" style="float: left;">
            <div class="sort_icon">
              <a class="term_title"><span>@if(isset($houseDetail->provinceName)){{$houseDetail->provinceName}} @else请选择省@endif</span><i></i></a>
              <div class="list_tag">
                <p class="top_icon"></p>
                <ul>
                  @if(!empty($province))
                    @foreach($province as $pro)
                      <li class="choosePro" value="{{$pro->id}}">{{$pro->name}}</li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
            <div class="sort_icon">
              <a class="term_title"><span id="cityText">@if(isset($houseDetail->cityName)){{$houseDetail->cityName}} @else请选择市@endif</span><i></i></a>
              <div class="list_tag">
                <p class="top_icon"></p>
                <ul id="cityList">
                  @if(isset($houseDetail->cityList))
                    @foreach($houseDetail->cityList as $CList)
                      <li value="{{$CList->id}}">{{$CList->name}}</li>
                    @endforeach
                  @else
                    <li>选择省</li>
                  @endif
                </ul>
              </div>
            </div>
            <div class="sort_icon">
              <a class="term_title"><span id="areaText">@if(isset($houseDetail->cityareaName)){{$houseDetail->cityareaName}} @else请选择区@endif</span><i></i></a>
              <div class="list_tag">
                <p class="top_icon"></p>
                <ul id="areaList">
                  @if(isset($houseDetail->cityareaList))
                    @foreach($houseDetail->cityareaList as $areaList)
                      <li value="{{$areaList->id}}">{{$areaList->name}}</li>
                    @endforeach
                  @else
                    <li>选择市</li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <div class="clear"></div>
          <input type="hidden" id="select_province" name="provinceId" @if(isset($houseDetail->provinceId)) value="{{$houseDetail->provinceId}}" @else value="" @endif>
          <input type="hidden" id="select_city" name="cityId" @if(isset($houseDetail->cityId)) value="{{$houseDetail->cityId}}" @else value="" @endif>
          <input type="hidden" id="select_cityArea" name="cityareaId" @if(isset($houseDetail->cityareaId)) value="{{$houseDetail->cityareaId}}" @else value="" @endif>
        </li>
        <li class="no_clear">
          <label><span>*</span>所属小区：</label>
          <div class="chose_build">
            <input type="text" class="txt" onkeyup="searchCommunity(this,'1')" placeholder="请输入楼盘名称" data-type="void" @if(isset($houseDetail->name)) value="{{$houseDetail->name}}" @else value="" @endif >
            <dl class="company" style="display:none;">
              <dd><a>上上城二季</a></dd>
            </dl>
            <input type="hidden" id="select_communityId" name="communityId" @if(isset($houseDetail->communityId)) value="{{$houseDetail->communityId}}" @else value="" @endif>
            @if(empty($entrust))
              <input type="hidden" id="select_communityAddress" name="address" @if(isset($houseDetail->address)) value="{{$houseDetail->address}}" @else value="" @endif>
            @endif
          </div>
          <div class="clear"></div>
        </li>
        <li>
          <label><span>*</span>单价：</label>
          <input type="text" class="txt width2 margin_l" data-type="sale" name="price1" @if(isset($houseDetail->price1)) value="{{floor($houseDetail->price1)}}" @else value="" @endif>
          <span class="zhi">元/平米</span>
        </li>
        <li>
          <label><span>*</span>物业费：</label>
          <input type="text" class="txt width2 margin_l" data-type="rates" name="propertyFee" @if(isset($houseDetail->propertyFee)) value="{{floor($houseDetail->propertyFee)}}" @else value="" @endif>
          <span class="zhi">元/平米·月</span>
        </li>
        <li>
          <label><span>*</span>房屋面积：</label>
          <input type="text" class="txt width2 margin_l" data-type="area" name="area" @if(isset($houseDetail->area)) value="{{floor($houseDetail->area)}}" @else value="" @endif>
          <span class="zhi">平米</span>
        </li>
        {{--<li class="no_clear">--}}
          {{--<label><span>*</span>所在楼层：</label>--}}
          {{--<div class="sort_icon dw" id="ban">--}}
            {{--<a class="term_title"><span>单层</span><i></i></a>--}}
            {{--<div class="list_tag">--}}
               {{--<p class="top_icon"></p>--}}
               {{--<ul>--}}
                 {{--<li>单层</li>--}}
                 {{--<li>多层</li>--}}
                 {{--<li>独栋</li>--}}
               {{--</ul>--}}
             {{--</div>--}}
          {{--</div>--}}
          {{--<div class="dan" style="float:left;">--}}
            {{--<input type="text" class="txt width3 margin_l" data-type="minus">--}}
            {{--<span class="room">层</span>--}}
            {{--<div class="clear"></div>--}}
          {{--</div>--}}
          {{--<div class="duo" style="display:none; float:left;">--}}
            {{--<input type="text" class="txt width3 margin_l">--}}
            {{--<span class="room" style="margin:0 5px;">至</span>--}}
            {{--<input type="text" class="txt width3">--}}
            {{--<span class="room">层</span>--}}
            {{--<div class="clear"></div>--}}
          {{--</div>--}}
          {{--<div class="du" style="display:none; float:left;">--}}
            {{--<span class="room margin_l">共</span>--}}
            {{--<input type="text" class="txt width3">--}}
            {{--<span class="room">层</span>--}}
            {{--<div class="clear"></div>--}}
          {{--</div>--}}
          {{--<div class="clear"></div>--}}
        {{--</li>--}}
        <li class="js-floor">
          <label><span>*</span>所在楼层：</label>
          <span class="zhi margin_l">第</span>
          <input type="text" class="txt width3" data-type="floor" name="currentFloor" @if(isset($houseDetail->currentFloor)) value="{{$houseDetail->currentFloor}}" @else value="" @endif>
          <span class="zhi">层</span>
          <span class="zhi margin_l">共</span>
          <input type="text" class="txt width3" data-type="floors" name="totalFloor" @if(isset($houseDetail->totalFloor)) value="{{$houseDetail->totalFloor}}" @else value="" @endif>
          <span class="zhi">层</span>
        </li>
        <li class="no_clear">
          <label><span class="dotted colorfe">*</span>物业类型：</label>
          <div class="js-type" style="float:left;">
            <div class="sort_icon dw">
              <a class="term_title"><span>@if(isset($houseDetail->houseType2)){{config('houseState.shop.houseType2')[$houseDetail->houseType2]}}@else请选择@endif</span><i></i></a>
              <div class="list_tag">
                 <p class="top_icon"></p>
                 <ul>
                   @foreach(config('houseState.shop.houseType2') as $key => $val)
                     <li value="{{$key}}">{{$val}}</li>
                   @endforeach
                 </ul>
                <input type="hidden" name="houseType2" @if(isset($houseDetail->houseType2)) value="{{$houseDetail->houseType2}}" @else value="" @endif>
               </div>
            </div>
          </div>
          <div class="clear"></div>
        </li>
      </ul>
      @if(empty($entrust))
      <p class="title"><span></span>其他信息</p>
      <ul>
        <li>
          <label><span>*</span>房源名称：</label>
          <input type="text" class="txt width margin_l" name="title" data-type="title" @if(isset($houseDetail->title)) value="{{$houseDetail->title}}" @else value="" @endif>
        </li>
        <li>
          <label><span>*</span>是否可分割：</label>
          <input type="radio" class="radio" @if(!isset($houseDetail))checked="checked" @endif @if(isset($houseDetail->isDivisibility) && $houseDetail->isDivisibility == 0) checked="checked" @endif name="isDivisibility" value="0">
          <span class="room">是</span>
          <input type="radio" class="radio" @if(isset($houseDetail->isDivisibility) && $houseDetail->isDivisibility == 1) checked="checked" @endif name="isDivisibility" value="1">
          <span class="room">否</span>
        </li>
        <li>
          <label><span>*</span>装修程度：</label>
          @foreach(config('houseState.fitment') as $key => $val)
          <input type="radio" class="radio" @if(!isset($houseDetail) && $key == 0) checked="checked" @endif @if(isset($houseDetail->fitment) && $key == $houseDetail->fitment) checked="checked" @endif name="fitment" value="{{$key}}">
          <span class="room">{{$val}}</span>
          @endforeach
        </li>
        <li>
          <label><span>*</span>商铺状态：</label>
          @foreach(config('houseState.shop.stateShop') as $key => $val)
          <input type="radio" class="radio" @if(!isset($houseDetail) && $key == 0) checked="checked" @endif @if(isset($houseDetail->stateShop) && $key == $houseDetail->stateShop) checked="checked" @endif name="stateShop" value="{{$key}}">
          <span class="room">{{$val}}</span>
          @endforeach
        </li>
        <li>
          <label><span>*</span>推荐行业：</label>
          <div class="sheshi">
            @foreach(config('houseState.shop.trade') as $key => $val)
            <span>
              <input type="checkbox" name="trade[]" @if(isset($houseDetail->trade) && in_array($key,explode('|',$houseDetail->trade))) checked="checked" @endif class="radio" value="{{$key}}"/>
              <span class="room">{{$val}}</span>
            </span>
            @endforeach
          </div>
        </li>
        <li>
          <label><span>*</span>商铺特征：</label>
          <div class="sheshi">
            @foreach($tag10 as $key => $val)
            <span @if($val->id == 116 || $val->id == 117)style="width:150px;" @endif>
              <input type="checkbox" name="tag10[]" @if(isset($houseDetail->tagId) && in_array($val->id,explode('|',$houseDetail->tagId))) checked="checked" @endif class="radio" value="{{$val->id}}"/>
              <span class="room">{{$val->name}}</span>
            </span>
            @endforeach
          </div>
        </li>
        <li>
          <label><span>*</span>客流人群：</label>
          <div class="sheshi">
            @foreach($tag11 as $key => $val)
            <span>
              <input type="checkbox" name="tag11[]" @if(isset($houseDetail->tagId) && in_array($val->id,explode('|',$houseDetail->tagId))) checked="checked" @endif class="radio" value="{{$val->id}}"/>
              <span class="room">{{$val->name}}</span>
            </span>
            @endforeach
          </div>
        </li>
        <li>
          <label><span>*</span>配套设施：</label>
          <div class="sheshi">
            @foreach(config('houseState.shop.equipment') as $key => $val)
            <span>
              <input type="checkbox" name="equipment[]" @if(isset($houseDetail->equipment) && in_array($key,explode('|',$houseDetail->equipment))) checked="checked" @endif class="radio" value="{{$key}}"/>
              <span class="room">{{$val}}</span>
            </span>
            @endforeach
          </div>
        </li>
        <li class="no_clear">
          <label>入住时间：</label>
          <div class="sort_icon dw">
            <a class="term_title"><span>@if(isset($houseDetail->checkInTime) && isset(config('houseState.Zz.checkInTime')[$houseDetail->checkInTime])){{config('houseState.Zz.checkInTime')[$houseDetail->checkInTime]}}@else请选择@endif</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 @foreach(config('houseState.Zz.checkInTime') as $key => $val)
                   <li value="{{$key}}">{{$val}}</li>
                 @endforeach
               </ul>
              <input type="hidden" name="checkInTime" @if(isset($houseDetail->checkInTime)) value="{{$houseDetail->checkInTime}}" @else value="" @endif>
             </div>
          </div>
          <div class="clear"></div>
        </li>
        <li>
          <label><span>*</span>房源自评：</label>
          <div class="need">
            <textarea class="txtarea js-desc" name="describe" value="">@if(isset($houseDetail->describe)){{$houseDetail->describe}}@endif</textarea>
            <p>
              <span>对自身房源的评价，及优势（至少5个字符）</span>
              <span>如果输入内容出现新广告法中禁止的违规词，系统将自动隐藏。 </span>
            </p>
          </div>
        </li>
        <li>
          <label><span>*</span>房源图片：</label>
          <div class="home_img">
            <span class="star"></span>
            <div class="house_img">
              <div class="upload_img">
                <ul>
                  <li id="li_img" class="li_img" style="margin-bottom:0px;margin-right:0;">
                    <div id="upload" attr="1"></div>
                    @if(isset($houseImage))
                      <div class="parentFileBox">
                        <ul class="fileBoxUl">
                          @foreach($houseImage as $key => $image)
                            <li class="diyUploadHover">
                              <div class="viewThumb">
                                <img src="{{get_img_url('housesale', $image->fileName, '2')}}" alt="">
                              </div>
                              <div class="diyCancel" ></div>
                              <div class="diySuccess"></div>
                              <div class="cz">
                                <input class="imageId" type="hidden" value="{{$image->id}}">
                                <input class="photo_path" type="hidden" value="{{$image->fileName}}">
                              </div>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif
                  </li>
               </ul>
             </div>
           </div>
         </div>
          <input type="hidden" name="imageFile" value="">
         <div class="promit">
           <p>1、请勿上传有水印、盖章等任何侵犯他人版权或含有广告信息的图片。</p>
           <p>2、上传宽度大于600像素，比例为4:3的图片可获得更好的展示效果。</p>
           <p>3、可上传30张图片，每张小于20M，建议尺寸比为：4:3，最佳尺寸为600*450像素。</p>
         </div>
        </li>
      </ul>
      @endif
      <p class="title"><span></span>发布人信息</p>
      <ul>
        <li>
          <label><span>*</span>姓名：</label>
          <input type="text" class="txt margin_l" data-type="name" name="linkman" @if(isset($houseDetail->linkman)) value="{{$houseDetail->linkman}}" @else value="" @endif>
        </li>
        @if(!Auth::check())
        <li>
          <label><span>*</span>联系电话：</label>
          <input type="text" class="txt margin_l js-tel" name="linkmobile" maxlength="11" data-type="tel" @if(Auth::check()) value="{{Auth::user()->mobile}}" @else data-check="mobile" value="" @endif >
        </li>
          <li style="display: none;">
            <label>&nbsp;</label>
            <input type="text" class="txt width2 margin_l" id="img_code_val" value="" autocomplete="off">
            <img src="/vercode" alt="验证码" id="img_code" onclick="this.src='/vercode?code='+Math.random();" style="width:95px;height:30px;float:left;margin-left:15px;border-radius:3px;">
            <span class="qerr"></span>
          </li>
          <li>
            <label><span>*</span>手机验证码：</label>
            <input type="text" class="txt width2 margin_l" name="code" value="" data-type="code">
            <input type="button" class="btn btn_blue js-btn" id="getcode" value="获取验证码">
          </li>
        @endif
        <input type="hidden" id="crtoken" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="imageId" value="">
        @if(isset($houseDetail))
          <input type="hidden" name="houseId" value="{{$houseDetail->id}}">
          <input type="hidden" name="image" value="">
        @endif
        <li><input type="button" class="btn submit js-submit" onclick="submitInfo(this,'{{$entrust}}')" value="提交"></li>
      </ul>
      </form>
    </div>
  </div>
</div>
<script src="/js/specially/headNav.js?v={{Config::get('app.version')}}"></script>
<script src="/js/PageEffects/validate.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script src="/js/myhouse.js?v={{Config::get('app.version')}}"></script>
<script>
$(document).ready(function(e) {

    /* 上传图片 */
    $('#upload').diyUpload({
      success:function( data ) {
        console.info( data );
      },
      error:function( err ) {
        console.info( err );
      },
      houseImage:true,
      imageType:'houseSale'
    });

  // 删除图片
  $('.diyCancel').click(deleteImg);

	$(".tag_nav a").click(function(){
	  $(this).toggleClass("click");	
	});
  
    /* 下拉 */
	$(".house_type .sort_icon").click(function (event) {
      $(".list_tag").hide();
      $(this).find(".list_tag").fadeIn();
      $(document).one("click", function () {//对document绑定一个影藏Div方法
         $(".list_tag").hide();
      });
      event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
    });
    $(".list_tag").click(function (event) {
        event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
    });
	
	$(".list_tag li").click(function(){
	   $(this).parents(".sort_icon").find(".term_title span").text($(this).text());	
	   $(this).parents(".list_tag").hide();
       $(this).parent().next('input').val($(this).attr('value'));
    });
	
	$("#ban li").click(function(){
	 $("#ban").parent().find("div").hide();
	 $("#ban").parent().find(".clear").show();
	 $("#ban").show();
	 if($(this).text()=="单层"){
        $(".dan").show();
     }else if($(this).text()=="多层"){
		$(".duo").show();
	 }else{
		$(".du").show();
	 }
  });
});

//  获得删除图片的id
function deleteImg(){
  var deleteImgId = [];
  deleteImgId.push($(this).parent().find('input.imageId').val());
  $(this).parent().remove();
  $('input[name="imageId"]').val(deleteImgId.join('|'));
}

function cli(Obj)
  {
  var collid = document.getElementById("all")
  var coll = document.getElementsByName(Obj)
  if (collid.checked){
     for(var i = 0; i < coll.length; i++)
       coll[i].checked = true;
  }else{
     for(var i = 0; i < coll.length; i++)
       coll[i].checked = false;
  }
}
</script>
@endsection