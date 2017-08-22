<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="/css/brokerComment.css"/>
<link rel="stylesheet" type="text/css" href="/css/brokerCenter.css"/>
<link rel="stylesheet" type="text/css" href="/css/color.css"/>
</head>

<body>
<header class="header">
	<h2>搜房管理中心</h2>
	<nav class="head_nav">
      <a>我的店铺</a>
      <a>使用帮</a>
    </nav>
    <div class="head_r">
      <span>400-630-6888</span>
      <a>退出</a>
    </div>
</header>
<div class="main">
  <div class="main_l" id="main_l">
    <dl class="broker">
      <dt><a><img src="/image/broker.jpg" /></a></dt>
    </dl>
    <div class="subnav">
      <p class="p1"><span>新盘库管理</span><i></i></p>
      <p class="p2">
        <a href="../../newBuildLibrary/add/buildList.htm"><i></i>创建新楼盘</a>
        <a href="../../newBuildLibrary/examine/via.htm"><i></i>审核新楼盘</a>
        <a href="../../newBuildLibrary/manage/buildManage.htm"><i></i>管理新楼盘</a>
        <a href="../../newBuildLibrary/editDynamic/zzInfo.htm"><i></i>动态信息修改</a>
      </p>
      <p class="p1"><span>现有楼盘库管理</span><i></i></p>
      <p class="p2">
        <a href="../../houseLibrary/addNewHouse/buildList.htm"><i></i>创建现有楼盘</a>
        <a href="../../houseLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
        <a href="../../houseLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
      </p>
      <p class="p1 click"><span>增量房源库</span><i></i></p>
      <p class="p2" style="display:block;">
        <a href="/newhouse/house" class="onclick"><i></i>录入新房房源</a>
        <a href="/newmanage" ><i></i>管理新房房源</a>
      </p>
      <p class="p1"><span>存量房源库</span><i></i></p>
      <p class="p2">
          <a class="onclick" href="/oldsale/house"><i></i>录入出售房源</a>
          <a href="/oldsale"><i></i>管理出售房源</a>
        <a href="../../oldHouseLibrary/enterRentHouse/zzHouse.htm"><i></i>录入出租房源</a>
        <a><i></i>管理出租房源</a>
      </p>
      <p class="p1"><span>我的搜房</span><i></i></p>
      <p class="p2">
        <a><i></i>我的资料</a>
        <a><i></i>我的认真</a>
        <a><i></i>我的积分</a>
        <a><i></i>修改密码</a>
      </p>
    </div>
  </div>
  <div class="main_r" id="main_r">
    <p class="right_title border_bottom">
      <a href="/newhouse/house"  class="<?=($type == 'house')?'click':''?>">住宅</a>
      <a href="/newhouse/villa" class="<?=($type == 'villa')?'click':''?>">别墅</a>
    </p>
    <div class="write_msg">
      <p class="write_title"><span class="title">基本信息</span></p>
      <form action="/newhouse/{{$type}}" method="post" enctype="mutltipart/form-data" id="house">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" >
        @if(!empty($housesaleid))
          <input type="hidden" name="id" value="{{$housesaleid}}" >
        @endif
      <ul class="input_msg">
        <li>
          <label>房源模板：</label>
          <span class="tishi">还可保存：<strong class="colorfe ms">0</strong>/10套</span>
          @if(!empty($models))
            @foreach($models as $model)
                @if(!empty($housesaleid))
                    <span class="subway mb"><a href="/newhouse/{{$type}}/{{$model->id}}m?id={{$housesaleid}}">{{$model->name}}</a><i class="delm" attr="{{$model->id}}"></i></span>
                @else
                    <span class="subway mb"><a href="/newhouse/{{$type}}/{{$model->id}}m">{{$model->name}}</a><i class="delm" attr="{{$model->id}}"></i></span>
                @endif
            @endforeach
          @endif
        </li>
        <li style="margin-bottom:0;">
          <label><span class="dotted colorfe">*</span>房源标题：</label>
          <input type="text" name="title" class="txt width" value="<?=(!empty($house->title))?$house->title:''?>"/>
        </li>
        <li style="height:20px; margin-bottom:10px; overflow:hidden; line-height:20px;">
          <label>&nbsp;</label>
          <span class="colorfe">请勿填写公司名称、真实房源或最佳、唯一、独家、最新、最便宜、风水、升值等词汇。请勿填写"【】"、"*"等特殊字符。</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>楼盘名称：</label>
          <input type="hidden" name="cityId" value="<?=(!empty($house->cityId))?$house->cityId:''?>"/>
          <input type="hidden" name="cityareaId" value="<?=(!empty($house->cityareaId))?$house->cityareaId:''?>"/>
          <input type="hidden" name="businessAreaId" value="<?=(!empty($house->businessAreaId))?$house->businessAreaId:''?>"/>
          <input type="hidden" name="communityId" value="<?=(!empty($house->communityId))?$house->communityId:''?>"/>

          <input type="text" name="name" class="txt width1" id="sel" />
          <dl class="build_list">
            <dd>远洋山水</dd>
            <dd>远洋新城</dd>
          </dl>
        </li>
        @if($type == 'villa')
        <li>
          <label><span class="dotted colorfe">*</span>进门朝向：</label>
          @if(!empty($faces))
            @foreach($faces as $k=>$face)
              @if(!empty($house->faceTo) && $house->faceTo == $k)
                <input type="radio" name="faceTo" class="radio" checked="checked" value="{{$k}}"/>
                <span class="tishi">{{$face}}</span>
              @else
                <input type="radio" name="faceTo" class="radio"  value="{{$k}}"/>
                <span class="tishi">{{$face}}</span>
              @endif
              <?php if($k == 4){break;}?>
            @endforeach
          @endif
        </li>
        @endif
        <li>
          <label><span class="dotted colorfe">*</span>户型：</label>
          <input type="hidden" name="houseRoom"  value="<?=(!empty($house->houseRoom))?$house->houseRoom:''?>"/>
          <input type="hidden" name="roomStr" value="<?=(!empty($house->roomStr))?$house->roomStr:''?>"/>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span>@if(!empty($house->houseRoom)){{$house->houseRoom}}@else{{0}}@endif</span><i></i></a>
            <div class="list_tag select_width">
               <p class="top_icon"></p>
               <ul>
                 <li>0</li>
                 <li>1</li>
                 <li>2</li>
                 <li>3</li>
                 <li>4</li>
               </ul>
             </div>
          </div>
          <span class="tishi">室</span>
          <div class="dw" style="margin-left:0;">
            <a class="term_title"><span>@if(!empty($house->roomStr))<?=substr($house->roomStr,2,1)?>@else{{0}}@endif</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>0</li>
                 <li>1</li>
                 <li>2</li>
                 <li>3</li>
                 <li>4</li>
               </ul>
             </div>
          </div>
          <span class="tishi">厅</span>
          <div class="dw" style="margin-left:0;">
              <a class="term_title"><span>@if(!empty($house->roomStr))<?=substr($house->roomStr,4,1)?>@else{{0}}@endif</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>0</li>
                 <li>1</li>
                 <li>2</li>
                 <li>3</li>
                 <li>4</li>
               </ul>
             </div>
          </div>
          <span class="tishi">卫</span>
          <div class="dw" style="margin-left:0;">
              <a class="term_title"><span>@if(!empty($house->roomStr))<?=substr($house->roomStr,6,1)?>@else{{0}}@endif</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>0</li>
                 <li>1</li>
                 <li>2</li>
                 <li>3</li>
                 <li>4</li>
               </ul>
             </div>
          </div>
          <span class="tishi">厨</span>
          <div class="dw" style="margin-left:0;">
              <a class="term_title"><span>@if(!empty($house->roomStr))<?=substr($house->roomStr,8,1)?>@else{{0}}@endif</span><i></i></a>
            <div class="list_tag">
               <p class="top_icon"></p>
               <ul>
                 <li>0</li>
                 <li>1</li>
                 <li>2</li>
                 <li>3</li>
                 <li>4</li>
               </ul>
             </div>
          </div>
          <span class="tishi">阳台</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>楼栋信息：</label>
          <div class="sort_icon margin_r loudong">
            <a class="term_title"><span>
                @if(!empty($house->buildingId))
                  {{$house->buildingId}}号楼
                @else
                  所属楼栋
                @endif
              </span><i></i></a>
            <input type="hidden" name="buildingId" value="<?=(!empty($house->buildingId))?$house->buildingId:''?>">
            <div class="list_tag width4">
               <p class="top_icon"></p>
               <ul id="loudong">
               </ul>
             </div>
          </div>
          <div class="sort_icon margin_r loudong">
            <a class="term_title"><span>
                @if(!empty($house->roomId))
                  {{$roomname}}
                @else
                  所属户型
                @endif
              </span><i></i></a>
            <input type="hidden" name="roomId" value="<?=(!empty($house->roomId))?$house->roomId:''?>">
            <div class="list_tag width4">
               <p class="top_icon"></p>
               <ul id="huxing">
               </ul>
             </div>
          </div>
          @if($type == 'house')
            <input type="text" class="txt width3" name="unit" value="<?=(!empty($house->unit))?$house->unit:''?>" />
            <span class="tishi">单元号</span>
          @endif
          <input type="text" class="txt width3" name="houseNum" value="<?=(!empty($house->houseNum))?$house->houseNum:''?>"/>
          <span class="tishi">门牌号</span>
        </li>
        @if($type == 'villa')
        <li>
          <label><span class="dotted colorfe">*</span>建筑类别：</label>
          @if(!empty($buildingTypes))
            @foreach($buildingTypes as $k=>$buildingType)
              @if($k >7)
                @if(!empty($house->buildingType) && ($house->buildingType == $k))
                  <input type="radio" name="buildingType" class="radio" checked="checked" value="{{$k}}"/>
                  <span class="tishi">{{$buildingType}}</span>
                @else
                  <input type="radio" name="buildingType" class="radio"  value="{{$k}}"/>
                  <span class="tishi">{{$buildingType}}</span>
                @endif
              @endif
            @endforeach
            <?php  if($k == 7){break;}?>
          @endif
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>交房方式：</label>
          @if(!empty($deliverys))
            @foreach($deliverys as $k=>$delivery)
                @if(isset($house->delivery) && ($house->delivery == $k))
                  <input type="radio" name="delivery" class="radio" checked="checked" value="{{$k}}"/>
                  <span class="tishi">{{$delivery}}</span>
                @else
                  <input type="radio" name="delivery" class="radio"  value="{{$k}}"/>
                  <span class="tishi">{{$delivery}}</span>
                @endif
            @endforeach
          @endif
        </li>
        @endif
        <li>
          <label><span class="dotted colorfe">*</span>参考总价：</label>
          <input type="text" class="txt width2" name="totalPrice" value="<?=(!empty($house->totalPrice))?$house->totalPrice:''?>"/>
          <span class="tishi">万元/套</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>原价：</label>
          <input type="text" class="txt width2" name="oldTotalPrice" value="<?=(!empty($house->oldTotalPrice))?$house->oldTotalPrice:''?>"/>
          <span class="tishi">万元/套</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>单价：</label>
          <input type="text" class="txt width2" name="price" value="<?=(!empty($house->price))?$house->price:''?>"/>
          <span class="tishi">万元/套</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>原单价：</label>
          <input type="text" class="txt width2" name="oldPrice" value="<?=(!empty($house->oldPrice))?$house->oldPrice:''?>"/>
          <span class="tishi">万元/套</span>
        </li>
        @if($type == 'villa')
        <li>
          <label><span class="dotted colorfe">*</span>厅结构：</label>
          <input type="radio" name="buildingStructure" class="radio" checked="checked" value="5"/>
          <span class="tishi">平层</span>
          <input type="radio" name="buildingStructure" class="radio" value="6"/>
          <span class="tishi">挑高</span>
        </li>
        @else
          <li>
            <label><span class="dotted colorfe">*</span>建筑形式：</label>
            <div class="sort_icon jianzhu" style="margin-right:15px;">
              <a class="term_title"><span>@if(!empty($house->buildingStructure)){{$buildingStructures[$house->buildingStructure]}}@else选择结构@endif</span><i></i></a>
              <input type="hidden" name="buildingStructure" value="<?=(!empty($house->buildingStructure))?$house->buildingStructure:''?>">
              <div class="list_tag"  style="width:150px;">
                <p class="top_icon"></p>
                <ul>
                  <li>选择结构</li>
                  @if(!empty($buildingStructures))
                    @foreach($buildingStructures as $k=>$buildingStructure)
                      <li id="{{$k}}">{{$buildingStructure}}</li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
            <div class="sort_icon jianzhu">
              <a class="term_title"><span>@if(!empty($house->buildingType)){{$buildingTypes[$house->buildingType]}}@else选择类别@endif</span><i></i></a>
              <input type="hidden" name="buildingType"  value="<?=(!empty($house->buildingType))?$house->buildingType:''?>">
              <div class="list_tag"  style="width:150px;">
                <p class="top_icon"></p>
                <ul>
                  <li>选择类别</li>
                  @if(!empty($buildingTypes))
                    @foreach($buildingTypes as $k=>$buildingType)
                      <li id="{{$k}}">{{$buildingType}}</li>
                      <?php  if($k == 7){break;}?>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </li>
          <li>
            <label><span class="dotted colorfe">*</span>交房方式：</label>
            @if(!empty($deliverys))
              @foreach($deliverys as $k=>$delivery)
                @if(isset($house->delivery) && ($house->delivery == $k))
                  <input type="radio" name="delivery" class="radio" checked="checked" value="{{$k}}"/>
                  <span class="tishi">{{$delivery}}</span>
                @else
                  <input type="radio" name="delivery" class="radio"  value="{{$k}}"/>
                  <span class="tishi">{{$delivery}}</span>
                @endif
              @endforeach
            @endif
          </li>
        @endif
        <li>
          <label><span class="dotted colorfe">*</span>建筑面积：</label>
          <input type="text" class="txt" name="area" value="<?=(!empty($house->area))?$house->area:''?>"/>
          <span class="tishi">平方米</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>套内面积：</label>
          <input type="text" class="txt" name="practicalArea" value="<?=(!empty($house->practicalArea))?$house->practicalArea:''?>"/>
          <span class="tishi">平方米</span>
        </li>
        @if($type == 'villa')
        <li>
          <label><span class="dotted colorfe">*</span>花园面积：</label>
          <input type="text" class="txt" name="gardenArea" value="<?=(!empty($house->gardenArea))?$house->gardenArea:''?>"/>
          <span class="tishi">平方米</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>地上层数：</label>
          <input type="text" class="txt width3" name="totalFloor" value="<?=(!empty($house->totalFloor))?$house->totalFloor:''?>"/>
          <span class="tishi">层</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>地下室面积：</label>
          <input type="text" class="txt width3" name="basementArea" value="<?=(!empty($house->basementArea))?$house->basementArea:''?>"/>
          <span class="tishi">平米</span>
          <span class="tishi colorfe">无地下室请填写数字0。</span>
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>层高：</label>
          <input type="text" class="txt width3" name="floorHeight" value="<?=(!empty($house->floorHeight))?$house->floorHeight:''?>"/>
          <span class="tishi">米</span>
        </li>
        @endif
        @if($type == 'house')
          <li>
            <label><span class="dotted colorfe">*</span>朝向：</label>
            @if(!empty($faces))
              @foreach($faces as $k=>$face)
                @if(!empty($house->faceTo) && $house->faceTo == $k)
                  <input type="radio" name="faceTo" class="radio" checked="checked" value="{{$k}}"/>
                  <span class="tishi">{{$face}}</span>
                @else
                  <input type="radio" name="faceTo" class="radio"  value="{{$k}}"/>
                  <span class="tishi">{{$face}}</span>
                @endif
              @endforeach
            @endif
          </li>
        @endif
        <li>
          <label><span class="dotted colorfe">*</span>装修程度：</label>
          @if(!empty($fitments))
            @foreach($fitments as $k=>$fitment)
              @if(!empty($house->fitment) && $house->fitment == $k)
                <input type="radio" name="fitment" class="radio" checked="checked" value="{{$k}}"/>
                <span class="tishi">{{$fitment}}</span>
              @else
                <input type="radio" name="fitment" class="radio"  value="{{$k}}"/>
                <span class="tishi">{{$fitment}}</span>
              @endif
            @endforeach
          @endif
        </li>
        <li>
          <label><span class="dotted colorfe">*</span>配套设施：</label>
          @if(!empty($equipments))
            @foreach($equipments as $k=>$equipment)
              @if(!empty($house->equipment) && in_array($k,explode('|',$house->equipment)))
                <input type="checkbox" name="equipment[]" class="radio" checked="checked" value="{{$k}}"/>
                <span class="tishi">{{$equipment}}</span>
              @else
                <input type="checkbox" name="equipment[]" class="radio"  value="{{$k}}"/>
                <span class="tishi">{{$equipment}}</span>
              @endif
            @endforeach
          @endif
        </li>
      </ul>
    </div>
    <div class="write_msg">
      <p class="write_title"><span class="title">上传图片</span></p>
      <ul class="input_msg">
        <li style="height:auto; overflow:hidden;">
          <label>注意：</label>
          <div class="float_l colorfe">
              1、上传宽度大于600像素，比例为4:3的图片可获得更好的展示效果。<br />
              2、请勿上传有水印、盖章等任何侵犯他人版权或含有广告信息的图片。<br />
              3、可上传30张图片，每张小于20M，建议尺寸比为：16:10，最佳尺寸为480*300像素。<br />
              4、多图房源点击量比非多图房源高出30%。
          </div>
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="saloon">
          <label>客厅图/餐厅图：</label>
          <div id="box" class="box">
              <div id="saloon" attr="2"  @if(!empty($status) && ($status == 2)) style="display:none;" @endif> </div>
              @if(!empty($housesaleid))
              <div class="parentFileBox">
                  <ul class="fileBoxUl">
                      @if(!empty($info['keting']))
                          @foreach($info['keting'] as $ghkey => $ghval)
                              <li class="diyUploadHover">
                                  <div class="viewThumb">
                                      <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                  </div>
                                  <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                  <div class="diySuccess"></div>
                                  <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                  <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                  <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                              </li>
                          @endforeach
                      @endif
                  </ul>
              </div>
              @endif
          </div>
        @if(!empty($status) && ($status == 2))
            <i class="eidth_icon" style="margin-top:10px;"></i>
        @endif
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="bedroom">
          <label>卧室图：</label>
          <div id="box" class="box">
              <div id="bedroom" attr="3" @if(!empty($status) && ($status == 2)) style="display:none;" @endif></div>
              @if(!empty($housesaleid))
                  <div class="parentFileBox">
                      <ul class="fileBoxUl">
                          @if(!empty($info['woshi']))
                              @foreach($info['woshi'] as $ghkey => $ghval)
                                  <li class="diyUploadHover">
                                      <div class="viewThumb">
                                          <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                      </div>
                                      <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                      <div class="diySuccess"></div>
                                      <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                      <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                      <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
              @endif
          </div>
            @if(!empty($status) && ($status == 2))
                <i class="eidth_icon" style="margin-top:10px;"></i>
            @endif
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="kitchen">
          <label>厨房图：</label>
          <div id="box" class="box">
              <div id="kitchen" attr="4" @if(!empty($status) && ($status == 2)) style="display:none;" @endif></div>
              @if(!empty($housesaleid))
                  <div class="parentFileBox">
                      <ul class="fileBoxUl">
                          @if(!empty($info['chufang']))
                              @foreach($info['chufang'] as $ghkey => $ghval)
                                  <li class="diyUploadHover">
                                      <div class="viewThumb">
                                          <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                      </div>
                                      <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                      <div class="diySuccess"></div>
                                      <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                      <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                      <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
              @endif
          </div>
            @if(!empty($status) && ($status == 2))
                <i class="eidth_icon" style="margin-top:10px;"></i>
            @endif
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="balcony">
          <label>阳台图：</label>
          <div id="box" class="box">
              <div id="balcony" attr="6" @if(!empty($status) && ($status == 2)) style="display:none;" @endif></div>
              @if(!empty($housesaleid))
                  <div class="parentFileBox">
                      <ul class="fileBoxUl">
                          @if(!empty($info['yangtai']))
                              @foreach($info['yangtai'] as $ghkey => $ghval)
                                  <li class="diyUploadHover">
                                      <div class="viewThumb">
                                          <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                      </div>
                                      <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                      <div class="diySuccess"></div>
                                      <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                      <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                      <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
              @endif
          </div>
            @if(!empty($status) && ($status == 2))
                <i class="eidth_icon" style="margin-top:10px;"></i>
            @endif
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="toilet">
          <label>卫生间图：</label>
          <div id="box" class="box">
              <div id="toilet" attr="5" @if(!empty($status) && ($status == 2)) style="display:none;" @endif></div>
              @if(!empty($housesaleid))
                  <div class="parentFileBox">
                      <ul class="fileBoxUl">
                          @if(!empty($info['weishengjian']))
                              @foreach($info['weishengjian'] as $ghkey => $ghval)
                                  <li class="diyUploadHover">
                                      <div class="viewThumb">
                                          <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                      </div>
                                      <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                      <div class="diySuccess"></div>
                                      <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                      <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                      <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
              @endif
          </div>
            @if(!empty($status) && ($status == 2))
                <i class="eidth_icon" style="margin-top:10px;"></i>
            @endif
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="exterior">
          <label>外景图：</label>
          <div id="box" class="box">
              <div id="exterior" attr="8" @if(!empty($status) && ($status == 2)) style="display:none;" @endif></div>
              @if(!empty($housesaleid))
                  <div class="parentFileBox">
                      <ul class="fileBoxUl">
                          @if(!empty($info['waijing']))
                              @foreach($info['waijing'] as $ghkey => $ghval)
                                  <li class="diyUploadHover">
                                      <div class="viewThumb">
                                          <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                      </div>
                                      <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                      <div class="diySuccess"></div>
                                      <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                      <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                      <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
              @endif
          </div>
            @if(!empty($status) && ($status == 2))
                <i class="eidth_icon" style="margin-top:10px;"></i>
            @endif
        </li>
        <li style="height:auto; overflow:hidden;">
            <input type="hidden" name="titleimg">
          <label>标题图：</label>
          <div id="box" class="box">
              <div id="title" attr="9" @if(!empty($status) && ($status == 2)) style="display:none;" @endif></div>
              @if(!empty($housesaleid))
                  <div class="parentFileBox">
                      <ul class="fileBoxUl">
                          @if(!empty($info['biaoti']))
                              @foreach($info['biaoti'] as $ghkey => $ghval)
                                  <li class="diyUploadHover">
                                      <div class="viewThumb">
                                          <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                      </div>
                                      <div @if($status != 2 ) class="diyCancel" onclick="$(this).parent().remove()" @endif ></div>
                                      <div class="diySuccess"></div>
                                      <input class="diyFileName" type="text" placeholder="别名" @if($status == 2) readonly @endif  value="{{$ghval->note}}">
                                      <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                      <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                  </li>
                              @endforeach
                          @endif
                      </ul>
                  </div>
              @endif
          </div>
            @if(!empty($status) && ($status == 2))
                <i class="eidth_icon" style="margin-top:10px;"></i>
            @endif
        </li>
      </ul>
    </div>
      <input type="hidden" name="deleteImgId">
    <p class="submit">
      <input type="button" class="btn back_color release" value="保存到待发布" />
      <input type="button" class="btn back_color template" value="保存成模板" />
    </p>
    </form>
  </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript">
$(function(){
  var room = '';//户型
  var deleteImgId = []; //待删除的图片id
//模板数量
    $('.ms').html($('.mb').length);
//删除模板
    $('.delm').bind('click',function(){
       var ms = $(this);
       var modelid = $(this).attr('attr');
       if(modelid !=''){
           $.ajax({
               type:'get',
               url:'/delmodel',
               data:{modelid:modelid},
               success:function(data){
                   if(data == 1){
                       ms.parent().css('display','none');
                       alert('删除成功!');
                   }else{
                       console.log(data);
                       alert('删除失败!');
                   }
               }
           });
       }
    });
//编辑标签点击事件
    $(".input_msg li .eidth_icon").click(function(){
        $(this).hide();
        $(this).next().show();
        $(this).prev("#box").children('div').eq(0).show();
        $(this).prev("#box").children('div.parentFileBox').children('ul.fileBoxUl').children('li.diyUploadHover').each(function(){
            $(this).children('div').eq(1).addClass('diyCancel');
            $(this).children('div').eq(1).on('click',deleteImg);
            $(this).children('input.diyFileName').removeAttr('readonly');
        });
    });
    function deleteImg(){
        deleteImgId.push($(this).parent().children('input.imageId').val());
        $('input[name=deleteImgId]').val(deleteImgId);
        $(this).parent().remove();
    }
//楼盘名称搜索
    $('#sel').bind('input propertychange',function(){
    //console.log($(this).val());
        $.ajax({
          type:'get',
          url:'/getbuild',
          data:{name:$(this).val()},
          success:function(data){
            var result = '';
            for(var i=0;i<data.length;i++){
              result += '<dd id="'+data[i].id+'" cityId="'+data[i].cityId+'" cityareaId="'+data[i].cityareaId+'" businessAreaId="'+data[i].businessAreaId+'">'+data[i].name+'</dd>';
            }
            $('.build_list').html(result);
            $('.build_list').show();
            $('.build_list dd').bind('click',buildxcy);
         }
        });
    return false;
    });

//楼盘下拉选择
function buildxcy(){
  $('input[name=name]').val($(this).html());
  $('input[name=cityId]').val($(this).attr('cityId'));
  $('input[name=cityareaId]').val($(this).attr('cityareaId'));
  $('input[name=businessAreaId]').val($(this).attr('businessAreaId'));
  $('input[name=communityId]').val($(this).attr('id'));
  $('.build_list').hide();
};

//获取图片地址
  function getImage(obj){
    var sonList = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').children();
    var images = [];
    var type = $(obj).attr('attr');
    if(sonList.length < 1){
      return false;
    }
    sonList.each(function(index){
        console.log($(this).children('.diyFileName').val());
        console.log($(this).children('.imageNote').val());
        if( $(this).children('.diyFileName').val() !=$(this).children('.imageNote').val() ){
            images[index] = {
                img:$(this).children('div.viewThumb').children('img').attr('src'),
                note:$(this).children('.diyFileName').val(),
                id:$(this).children('.imageId').val(),
                type:type
            };
        }
    });
    return images;
  }

//保存到待发布
  $('.release').bind('click',function(){
      //获取图片数据
      var saloon = getImage('#saloon');         //客厅图/餐厅图
      var bedroom = getImage('#bedroom');      //卧室图
      var kitchen = getImage('#kitchen');       //厨房图
      var balcony = getImage('#balcony');      //阳台图
      var toilet = getImage('#toilet');         //卫生间图
      var exterior = getImage('#exterior');      //外景图
      var title = getImage('#title');   //标题图
      $('input[name=saloon]').val(JSON.stringify(saloon));
      $('input[name=bedroom]').val(JSON.stringify(bedroom));
      $('input[name=kitchen]').val(JSON.stringify(kitchen));
      $('input[name=balcony]').val(JSON.stringify(balcony));
      $('input[name=toilet]').val(JSON.stringify(toilet));
      $('input[name=exterior]').val(JSON.stringify(exterior));
      $('input[name=titleimg]').val(JSON.stringify(title));

    //房源标题
    if($('input[name=title]').val() == ''){
      errorMessage('请填写标题');
      $('input[name=title]').focus();
      return false;
    }
    //楼盘名称
    if($('input[name=name]').val() == ''){
      errorMessage('请填写楼盘名称');
      $('input[name=name]').focus();
      return false;
    }
    //户型验证
      room =$('input[name=roomStr]').val();
    if(room == '' || room == '0_0_0_0_0'){
      errorMessage('请选择户型');
      return false;
    }
    //提交信息
    if(saloon && bedroom && kitchen && balcony && toilet && exterior && title){
      $.ajax({
          type:'post',
          url:$('#house').attr('action'),
          data:  $('#house').serialize(),
          success:function(data){
              alert('保存成功!');
              //window.location = '/newmanage/releaseed';
          }
      });
    }else{
      alert('所有图片至少上传1张');
      return false;
    }
  });

//保存成模板
  $('.template').bind('click',function(){
      if($('.mb').length >=10){
          alert('只能保存10个房源模板!');
          return false;
      }
    //console.log($("#house").serialize());
    $.ajax({
      type:'post',
      url:'/newhouse/house/m',
      data:  $('#house').serialize(),
      success:function(data){
        alert('添加模板成功');
      }
    });
  });

//户型下拉选择
  $(".dw li").click(function(){
    $(this).parents(".dw").find(".term_title span").text($(this).text());
    $(this).parents(".list_tag").hide();
    room = '';
    $('div.dw a.term_title').each(function(){
        room +=$(this).find('span').text()+'_';
    });
    room = room.substr(0,room.length-1);
    $('input[name=roomStr]').val(room);
    $('input[name=houseRoom]').val(room.substr(0,1));
  });

//楼栋信息下拉
  $(".input_msg .loudong").click(function (event) {
    var communityId = 1;//$('input[name=communityId]').val();
//    if(communityId == ''){
//      alert('请选择楼盘名');
//    }
    if($(this).index() == 1){
      $.ajax({
        type: 'get',
        url: '/communitybuilding',
        data: {communityId:communityId},
        success: function (data) {//<li>1号楼</li>
          var loudong = '';
          if(data.length == 0){
            errorMessage('该楼盘下没有楼栋信息');
          }else{
            for(var i=0;i<data.length;i++){
              loudong +='<li id="'+data[i].id+'">'+data[i].num+'号楼</li>';
            }
            $('#loudong').html(loudong);
            $(".list_tag li").bind('click',buildclick);
          }
        }
      });
    }else if($(this).index() == 2){
      $.ajax({
        type: 'get',
        url: '/communityroom',
        data: {communityId:communityId},
        success: function (data) {//<li>1号楼</li>
          var huxing = '';
          if(data.length == 0){
            errorMessage('该楼盘下没有楼栋信息');
          }else{
            for(var i=0;i<data.length;i++){
              huxing +='<li id="'+data[i].id+'">'+data[i].name+'</li>';
            }
            $('#huxing').html(huxing);
            $(".list_tag li").bind('click',buildclick);
          }
        }
      });
    }
    $(".list_tag").hide();
    $(this).find(".list_tag").fadeIn();
    $(document).one("click", function () {//对document绑定一个影藏Div方法
      $(".list_tag").hide();
    });
    event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
  });

//建筑形式下拉
  $(".input_msg .jianzhu").click(function (event) {
    $(".list_tag").hide();
    $(this).find(".list_tag").fadeIn();
    $(document).one("click", function () {//对document绑定一个影藏Div方法
       $(".list_tag").hide();
    });
    event.stopPropagation();//点击 www.it165.net Button阻止事件冒泡到document
  });
  $(".list_tag li").bind('click',buildclick);
  $(".list_tag").click(function (event) {
    event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
  });

//楼栋信息点击方法
function buildclick(){
    $(this).parents(".sort_icon").find(".term_title span").text($(this).text());
    $(this).parents(".list_tag").hide();
    $(this).parent().parent().prev().val($(this).attr('id'));
  };


});

//错误提示方法
function errorMessage(message){
  alert(message);
}
/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/

/* 客厅图 */
$('#saloon').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );
	}
});

/* 卧室 */
$('#bedroom').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});

/* 厨房 */
$('#kitchen').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});

/* 阳台 */
$('#balcony').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});

/* 卫生间 */
$('#toilet').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});

/* 外景图 */
$('#exterior').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});

/* 标题图 */
$('#title').diyUpload({
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );	
	}
});
</script>
</body>
</html>