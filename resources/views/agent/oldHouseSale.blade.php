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
                <a href="../../houseLibrary/enterSaleHouse/buildList.htm"><i></i>创建现有楼盘</a>
                <a href="../../houseLibrary/examine/via.htm"><i></i>审核现有楼盘</a>
                <a href="../../houseLibrary/manage/buildManage.htm"><i></i>管理现有楼盘</a>
            </p>
            <p class="p1"><span>增量房源库</span><i></i></p>
            <p class="p2">
                <a href="/newhouse/house" class="onclick"><i></i>录入新房房源</a>
                <a href="/newmanage" ><i></i>管理新房房源</a>
            </p>
            <p class="p1 click"><span>存量房源库</span><i></i></p>
            <p class="p2" style="display:block;">
                <a href="/entryhouse/sale"><i></i>录入出售房源</a>
                <a href="/oldsalemanage"><i></i>管理出售房源</a>
                <a class="onclick" href="/entryhouse/rent"><i></i>录入出租房源</a>
                <a href="/oldrentmanage"><i></i>管理出租房源</a>
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
        <div class="commtent">
            <p>
                <span class="color_blue">{{$name}}</span>
              <span class="subway">
                @if(!empty($type2[$houseType1]))
                      <?php $i = 1;?>
                      @foreach($type2[$houseType1] as $ty)
                          <?php
                          if($i == 1){
                              echo $ty;
                          }else{
                              echo '—'.$ty;
                          }
                          $i++;
                          ?>
                      @endforeach
                  @endif

              </span>
            </p>
            <p>
                <span>[&nbsp;{{$cityname->name}}-{{$cityArea[$cityareaId]}}-{{$businessArea[$businessAreaId]}}&nbsp;]&nbsp;&nbsp;</span>
                <span>{{$address}}&nbsp;<a class="modaltrigger" href="#map"><i class="map_icon"></i></a></span>
            </p>
        </div>
        <p class="right_title border_bottom">
            @if($class == 'sale')
                <a class="click">录入出售房源</a>
            @else
                <a class="click">录入出租房源</a>
            @endif
        </p>
        <div class="write_msg">
            <p class="write_title"><span class="title">基本信息</span></p>
            <form action="/submit{{$class}}" method="post" enctype="mutltipart/form-data" id="oldsale">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <input type="hidden" name="cityId" value="{{$cityId}}"/>
                <input type="hidden" name="cityareaId"  value="{{$cityareaId}}"/>
                <input type="hidden" name="businessAreaId"  value="{{$businessAreaId}}"/>
                <input type="hidden" name="communityId"  value="{{$communityId}}"/>
                <input type="hidden" name="houseType1"  value="{{$houseType1}}"/>
                <input type="hidden" name="houseType2"  value="{{$houseType2}}"/>
                @if(!empty($oldsaleid))
                    <input type="hidden" name="id" value="{{$oldsaleid}}" >
                @endif
                <ul class="input_msg">
                    <li style="margin-bottom:0;">
                        <label><span class="dotted colorfe">*</span>房源标题：</label>
                        <input type="text" class="txt width" name="title"  value="<?=(!empty($house->title))?$house->title:''?>"/>
                    </li>
                    <li style="height:20px; margin-bottom:10px; overflow:hidden; line-height:20px;">
                        <label>&nbsp;</label>
                        <span class="colorfe">请勿填写公司名称、真实房源或最佳、唯一、独家、最新、最便宜、风水、升值等词汇。请勿填写"【】"、"*"等特殊字符。</span>
                    </li>
                    @if(($type == 'villa'))
                        <li>
                            <label><span class="dotted colorfe">*</span>建筑形式：</label>
                            @if(!empty($buildingTypes))
                                <?php  $i=1;?>
                                @foreach($buildingTypes as $k=>$buildingType)
                                    @if($k >7)
                                        @if((!empty($house->buildingType) && ($house->buildingType == $k))||($i==1))
                                            <input type="radio" name="buildingType" class="radio" checked="checked" value="{{$k}}"/>
                                            <span class="tishi">{{$buildingType}}</span>
                                        @else
                                            <input type="radio" name="buildingType" class="radio"  value="{{$k}}"/>
                                            <span class="tishi">{{$buildingType}}</span>
                                        @endif
                                    @endif
                                @endforeach
                                <?php  $i++;?>
                            @endif
                        </li>
                    @endif

                    @if($type == 'shops')
                        <li>
                            <label><span class="dotted colorfe">*</span>商铺状态：</label>
                            <input name="stateShop" class="radio" checked="checked" type="radio" value="0">
                            <span class="tishi">营业中</span>
                            <input name="stateShop" class="radio" @if((!empty($house->stateShop))&&($house->stateShop == 1)) checked @endif type="radio" value="1">
                            <span class="tishi">闲置中</span>
                            <input name="stateShop" class="radio" @if((!empty($house->stateShop))&&($house->stateShop == 2)) checked @endif type="radio" value="2">
                            <span class="tishi">新铺</span>
                        </li>
                    @endif
                    <li>
                        <label>内部编号：</label>
                        <input class="txt" type="text" name="internalNum" value="<?=(!empty($house->internalNum))?$house->internalNum:''?>">
                    </li>
                    <li>
                        <label>房源核验编号：</label>
                        <input type="text" class="txt width1" name="housingInspectionNum" value="<?=(!empty($house->housingInspectionNum))?$house->housingInspectionNum:''?>"/>
                        <span class="tishi colorfe">请填写建委房管部门的房源核验编号</span>
                    </li>

                    @if($type == 'house')
                        <li>
                            <label><span class="dotted colorfe">*</span>产权性质：</label>
                            <div class="sort_icon">
                                <a class="term_title"><span>@if(!empty($house->ownership)){{$ownerships[$house->ownership]}}@else个人产权@endif</span><i></i></a>
                                <input type="hidden" name="ownership" value="">
                                <div class="list_tag" style="width:150px;">
                                    <p class="top_icon"></p>
                                    <ul>
                                        @if(!empty($ownerships))
                                            @foreach($ownerships as $k=>$ownership)
                                                <li id="{{$k}}">{{$ownership}}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                    <!-- 出租与出售不同之处-->
                    @if($class == 'sale')
                        @if($type !='office')
                            <li>
                                <label><span class="dotted colorfe">*</span>售价：</label>
                                <input type="text" class="txt width2" name="price2" value="<?=(!empty($house->price2))?$house->price2:''?>"/>
                                <span class="tishi">万元/套</span>
                            </li>
                        @else
                            <li>
                                <label><span class="dotted colorfe">*</span>单价：</label>
                                <input type="text" class="txt width2" name="price1" value="<?=(!empty($house->price1))?$house->price1:''?>"/>
                                <span class="tishi">元/平米</span>
                            </li>
                        @endif
                    @else
                        <li>
                            <label><span class="dotted colorfe">*</span>租金：</label>
                            <input class="txt width2" type="text" name="price" value="<?=(!empty($price))?$price:''?>">
                            @if(($type == 'shops')||($type == 'office'))
                            <div class="dw">
                                <a class="term_title"><span><?=(!empty($house->priceUnit))?$rentPriceUnit[$house->priceUnit]:'元/月'?></span><i></i></a>
                                <input type="hidden" name="priceUnit" value="<?=(!empty($house->priceUnit))?$house->priceUnit:'1'?>">
                                <div class="list_tag" style="width: 90px; display: none;">
                                    <p class="top_icon"></p>
                                    <ul>
                                        @if(!empty($rentPriceUnit))
                                            @foreach($rentPriceUnit as $k=>$rentunit)
                                                <li id="{{$k}}">{{$rentunit}}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @else
                                <span class="tishi">元/月</span>
                            @endif
                        </li>
                        @if($type == 'shops')
                            <li>
                                <label><span class="dotted colorfe">*</span>是否转让：</label>
                                <input name="isTransfer" class="radio" checked="checked" type="radio" value="0">
                                <span class="tishi">是</span>
                                <input name="isTransfer" class="radio" @if((!empty($house->isTransfer))&&($house->isTransfer == 1)) checked @endif type="radio" value="1">
                                <span class="tishi">否</span>
                            </li>
                        @endif
                        @if(($type == 'house')||($type == 'villa'))
                        <li>
                            <label><span class="dotted colorfe">*</span>租赁方式：</label>
                            <input name="rentType" class="radio" checked="checked" type="radio" value="1">
                            <span class="tishi">整租</span>
                            <input name="rentType" class="radio" @if((!empty($house->rentType))&&($house->rentType == 2)) checked @endif type="radio" value="2">
                            <span class="tishi">合租</span>
                        </li>
                        <li>
                            <label><span class="dotted colorfe">*</span>出租面积：</label>
                            <input class="txt" type="text" name="area" value="<?=(!empty($house->area))?$house->area:''?>">
                            <span class="tishi">平方米</span>
                        </li>
                        @endif
                        <li>
                            <label><span class="dotted colorfe">*</span>支付方式：</label>
                            <div class="sort_icon">
                                <a class="term_title"><span>@if(!empty($house->paymentType)){{$paymentTypes[$house->paymentType]}}@else押一付三@endif</span><i></i></a>
                                <input type="hidden" name="paymentType" value="<?=(!empty($house->paymentType))?$house->paymentType:''?>">
                                <div class="list_tag" style="width: 150px; display: none;">
                                    <p class="top_icon"></p>
                                    <ul>
                                        <li id="1">押一付三</li>
                                        <li id="2">押一付二</li>
                                        <li id="3">押一付一</li>
                                        <li id="4">押二付一</li>
                                        <li id="5">押二付二</li>
                                        <li id="6">押二付三</li>
                                        <li id="7">押三付一</li>
                                        <li id="8">押三付三</li>
                                        <li id="9">半年付</li>
                                        <li id="10">年付</li>
                                        <li id="11">面议</li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if($type == 'villa')
                        <li>
                            <label><span class="dotted colorfe">*</span>厅结构：</label>
                            <input type="radio" name="buildingStructure" class="radio" checked="checked" value="5"/>
                            <span class="tishi">平层</span>
                            <input type="radio" name="buildingStructure" @if((!empty($house->buildingStructure))&&($house->buildingStructure == 6)) checked @endif class="radio" value="6"/>
                            <span class="tishi">挑高</span>
                        </li>
                    @endif
                    @if(!empty($communityBuilds))
                        <li>
                            <label><span class="dotted colorfe">*</span>所在楼栋：</label>
                            <input type="hidden" name="buildingId" value="<?=(!empty($house->buildingId))?$house->buildingId:''?>">
                            <input type="hidden" name="building" value="<?=(!empty($house->building))?$house->building:''?>">
                            <a class="tishi modaltrigger color_blue building" href="#add" ><?=(!empty($house->building))?$house->building:'选择所在楼栋'?></a>
                            <input type="hidden" name="unitId" value="<?=(!empty($house->unitId))?$house->unitId:''?>">
                            <input type="hidden" name="unit" value="<?=(!empty($house->unit))?$house->unit:''?>">
                            <div class="sort_icon leyout" style="margin-left:0;">
                                <a class="term_title"><span><?=(!empty($house->unit))?$house->unit:'1'?></span><i></i></a>
                                <div class="list_tag">
                                    <p class="top_icon"></p>
                                    <ul class="comunit">

                                    </ul>
                                </div>
                            </div>
                            <span class="tishi">单元号</span>
                            <input class="txt width3" type="text" name="houseNum" value="<?=(!empty($house->houseNum))?$house->houseNum:''?>">
                            <span class="tishi">门牌号</span>
                        </li>
                    @else
                        <li>
                            <label><span class="dotted colorfe">*</span>所在楼栋：</label>
                            <input class="txt width3" type="text" name="building" value="<?=(!empty($house->building))?$house->building:''?>">
                            <span class="tishi">楼栋号</span>
                            <input class="txt width3" type="text" name="unit" value="<?=(!empty($house->unit))?$house->unit:''?>">
                            <span class="tishi">单元号</span>
                            <input class="txt width3" type="text" name="houseNum" value="<?=(!empty($house->houseNum))?$house->houseNum:''?>">
                            <span class="tishi">门牌号</span>
                        </li>
                    @endif


                    @if(($type == 'house')||($type == 'villa') )
                        @if(!empty($communityRooms))
                        <li class="no_height">
                            <label><span class="dotted colorfe">*</span>户型：</label>
                            <input type="hidden" name="roomId" value="<?=(!empty($house->roomId))?$house->roomId:''?>">
                            <input type="hidden" name="roomStr" value="<?=(!empty($house->roomStr))?$house->roomStr:''?>">
                            <input type="hidden" name="houseRoom" value="<?=(!empty($house->houseRoom))?$house->houseRoom:''?>">

                            @if(!empty($house->roomId))
                                <a class="tishi modaltrigger color_blue" href="#hx" style="display:none;">选择户型</a>
                                <div class="chose_leyout">
                                    <a class="modaltrigger" href="#hx"><img src="../../../image/leyout.jpg" height="100" width="160">
                                        <span>{{$house->roomStr}}</span></a>
                                </div>
                             @else
                                <a class="tishi modaltrigger color_blue" href="#hx" >选择户型</a>
                                    <div class="chose_leyout" style="display:none;">
                                        <a class="modaltrigger" href="#hx"><img src="../../../image/leyout.jpg" height="100" width="160">
                                            <span>A1-2室1厅1卫</span></a>
                                    </div>
                             @endif

                        </li>
                        @else
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
                        @endif
                    @elseif(($type == 'office')||($type == 'shops'))
                        <li>
                            <label><span class="dotted colorfe">*</span>物业费：</label>
                            <input class="txt width2" type="text" name="propertyFee" value="<?=(!empty($house->propertyFee))?$house->propertyFee:''?>">
                            <span class="tishi">元/平米·月</span>
                        </li>
                        <li>
                            <label><span class="dotted colorfe">*</span>建筑面积：</label>
                            <input class="txt" type="text" name="area" value="<?=(!empty($house->area))?$house->area:''?>">
                            <span class="tishi">平方米</span>
                        </li>
                        <li>
                            <label>是否可分割：</label>
                            <input name="isDivisibility" class="radio" checked="checked" type="radio" value="0">
                            <span class="tishi">是</span>
                            <input name="isDivisibility" class="radio" @if((!empty($house->isDivisibility))&&($house->isDivisibility == 1)) checked @endif type="radio" value="1">
                            <span class="tishi">否</span>
                        </li>
                    @endif
                    @if($type == 'office')
                        <li>
                            <label><span class="dotted colorfe">*</span>写字楼级别：</label>
                            <input name="officeLevel" class="radio" checked="checked" type="radio" value="0">
                            <span class="tishi">甲</span>
                            <input name="officeLevel" class="radio" @if((!empty($house->officeLevel))&&($house->officeLevel == 1)) checked @endif type="radio" value="1">
                            <span class="tishi">乙</span>
                            <input name="officeLevel" class="radio" @if((!empty($house->officeLevel))&&($house->officeLevel == 2)) checked @endif type="radio" value="2">
                            <span class="tishi">丙</span>
                            <input name="officeLevel" class="radio" @if((!empty($house->officeLevel))&&($house->officeLevel == 3)) checked @endif type="radio" value="3">
                            <span class="tishi">其他</span>
                        </li>
                    @endif
                    @if($class == 'sale')
                        @if(($type == 'house')||($type == 'villa') )
                            <li>
                                <label><span class="dotted colorfe">*</span>建筑面积：</label>
                                <input type="text" class="txt" name="area" value="<?=(!empty($house->area))?$house->area:''?>"/>
                                <span class="tishi">平方米</span>
                            </li>
                            <li>
                                <label><span class="dotted colorfe">*</span>使用面积：</label>
                                <input type="text" class="txt" name="practicalArea" value="<?=(!empty($house->practicalArea))?$house->practicalArea:''?>"/>
                                <span class="tishi">平方米</span>
                            </li>
                            <li>
                                <label><span class="dotted colorfe">*</span>建筑年代：</label>
                                <input type="text" class="txt" name="buildYear" value="<?=(!empty($house->buildYear))?$house->buildYear:''?>"/>
                                <span class="tishi">年</span>
                            </li>
                        @endif
                    @endif
                    @if(($class =='rent')&&($type == 'villa'))
                        <li>
                            <label><span class="dotted colorfe">*</span>建筑年代：</label>
                            <input type="text" class="txt width3" name="buildYear" value="<?=(!empty($house->buildYear))?$house->buildYear:''?>"/>
                            <span class="tishi">年</span>
                        </li>
                    @endif
                    @if($type == 'villa')
                        <li>
                            <label><span class="dotted colorfe">*</span>地上层数：</label>
                            <input class="txt width3" type="text"  name="totalFloor" value="<?=(!empty($house->totalFloor))?$house->totalFloor:''?>">
                            <span class="tishi">层</span>
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
                    @if($type != 'office')
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
                    @endif
                    @if($type =='shops')
                        <li>
                            <label><span class="dotted colorfe">*</span>目标业务：</label>
                            @if(!empty($trades))
                                @foreach($trades as $k=>$trade)
                                    @if(!empty($house->trade) && in_array($k,explode('|',$house->trade)))
                                        <input type="checkbox" name="trade[]" class="radio" checked="checked" value="{{$k}}"/>
                                        <span class="tishi">{{$trade}}</span>
                                    @else
                                        <input type="checkbox" name="trade[]" class="radio"  value="{{$k}}"/>
                                        <span class="tishi">{{$trade}}</span>
                                    @endif
                                @endforeach
                            @endif
                        </li>
                    @endif
                    <li style="height:auto; overflow:hidden;">
                        <label><span class="dotted colorfe">*</span>房源标签：</label>
                        <input type="hidden" name="tagId">
                        <div class="house_tag">
                            <p><span class="p2_l">可选标签：</span><span class="p2_c color8d">(可添加三个标签)</span></p>
                            <p class="p1">
                                @if(!empty($tags))
                                    @foreach($tags as $k=>$tag)
                                        @if(!empty($house->tagId) && in_array($tag->id,explode('|',$house->tagId)))
                                            <a class="subway click" id="{{$tag->id}}">{{$tag->name}}</a>
                                        @else
                                            <a class="subway" id="{{$tag->id}}">{{$tag->name}}</a>
                                        @endif
                                    @endforeach
                                @endif
                            </p>
                        </div>
                    </li>
                </ul>
        </div>
        <div class="write_msg">
            <p class="write_title"><span class="title">补充信息</span></p>
            <ul class="input_msg">
                @if($type == 'shops')
                    <li>
                        <label>交通状况：</label>
                        <input class="txt width" type="text">
                    </li>
                    <li>
                        <label>周边配套：</label>
                        <input class="txt width" type="text">
                    </li>
                @endif
                <li style="height:auto; overflow:hidden;">
                    <label>房源描述：</label>
                    <div class="float_l">
                        <textarea class="txtarea" name="describe" ><?=(!empty($house->describe))?$house->describe:''?></textarea>
                        <span class="ts colorfe">请勿填写联系方式或与房源无关信息以及图片、链接或名牌、优秀、顶级、全网首发、零距离、回报率等词汇。请勿从其它网站或其它房源描述中拷贝</span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="write_msg">
            <p class="write_title"><span class="title">上传图片</span></p>
            @if(!empty($oldsaleid))
                @include('agent.houseImage')
            @else
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
                    <input type="hidden" name="leyout">
                    <input type="hidden" name="indoor">
                    <input type="hidden" name="traffic">
                    <input type="hidden" name="peripheral">
                    <input type="hidden" name="exterior">
                    <input type="hidden" name="titleimg">

                    <li style="height:auto; overflow:hidden;">
                        <label>户型图：</label>
                        <div id="box" class="box">
                            <div id="leyout" attr="1"></div>
                        </div>
                    </li>

                    <li style="height:auto; overflow:hidden;">
                        <label>室内图：</label>
                        <div id="box" class="box">
                            <div id="indoor" attr="10"></div>
                        </div>
                    </li>
                    <li style="height:auto; overflow:hidden;">
                        <label>交通图：</label>
                        <div id="box" class="box">
                            <div id="traffic" attr="11"></div>
                        </div>
                    </li>
                    <li style="height:auto; overflow:hidden;">
                        <label>周边配套图：</label>
                        <div id="box" class="box">
                            <div id="peripheral" attr="12"></div>
                        </div>
                    </li>
                    <li style="height:auto; overflow:hidden;">
                        <label>外景图：</label>
                        <div id="box" class="box">
                            <div id="exterior" attr="8"></div>
                        </div>
                    </li>
                    <li style="height:auto; overflow:hidden;">
                        <label>标题图：</label>
                        <div class="parentFileBox">
                            <ul class="fileBoxUl">
                                <li class="diyUploadHover">
                                    <div class="viewThumb">
                                        <img src="../../../image/.jpg" id="title" attr="9">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            @endif
        </div>
        <input type="hidden" name="deleteImgId">
        <p class="submit">
            <input type="button" class="btn back_color release" value="保存到待发布" />
            <!--<input type="button" class="btn back_color template" value="保存成模板" />-->
        </p>
        </form>
    </div>
</div>
<script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/brokerCenter.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/diyUpload.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/webuploader.html5only.min.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/PageEffects/Popup.min.js?v={{Config::get('app.version')}}"></script>
<div class="main_r add" id="add" >
    <h2>选择房源所在楼栋</h2>
    <span class="close" onclick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
    <div class="write_msg" style="width:700px;">
        <div class="ban">
            <ul>
                @if(!empty($communityBuilds))
                    @foreach($communityBuilds as $v)
                        <li id="{{$v->id}}">{{$v->num}}</li>
                    @endforeach
                @endif
            </ul>
            <p>
                <input class="submit buildsub back_color" style="margin-left:270px;" value="提交" type="button">
            </p>
        </div>
    </div>
</div>
<div class="main_r add" id="hx">
    <h2>选择房源户型</h2>
    <span class="close" onclick="$(this).parent().hide(); $('#lean_overlay').hide();"></span>
    <div class="write_msg" style="width:750px;">
        <div class="leyout">
            <ul>
                @if(!empty($communityRooms))
                    @foreach($communityRooms as $v)
                        <li roomstr="<?=$v->room.'_'.$v->hall.'_'.$v->toilet.'_'.$v->kitchen.'_'.$v->balcony?>" id="{{$v->id}}">
                        <img src="../../../image/leyout.jpg">
                        <span>{{$v->name}}</span>
                        </li>
                    @endforeach
                @endif
            </ul>
            <p>
                <input class="submit back_color modelsub" style="margin-left:270px;" value="提交" type="button">
            </p>
        </div>
    </div>
</div>
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
        //下拉方法
        $(".input_msg .sort_icon").click(function (event) {
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
        $(".list_tag li").bind('click',buildclick);
        function buildclick(){
            $(this).parents(".sort_icon").find(".term_title span").text($(this).text());
            $(this).parents(".list_tag").hide();
            $(this).parent().parent().prev().val($(this).attr('id'));
        };

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
//房源标签选择
        $(".house_tag .p1 a").click(function(){
            $(this).toggleClass("click");
        });
        $('.house_tag .p1 a ').bind('click',function(){
            var housetag = '';
            if($('.house_tag .p1 a.click').length >3){
                $(this).toggleClass("click");
                alert('很抱歉,只能选择三个标签!');
                return false;
            }
            $('.house_tag .p1 a.click').each(function(){
                housetag +=$(this).attr('id')+'|';
            });
            housetag = housetag.substr(0,housetag.length-1);
            $('input[name=tagId]').val(housetag);
        });
//点击图片删除事件
        $('.diyCancel').bind('click',deleteImg);
        function deleteImg(){
            deleteImgId.push($(this).parent().children('input.imageId').val());
            $('input[name=deleteImgId]').val(deleteImgId);
            $(this).parent().remove();
        }
//获取图片地址
        function getImage(obj){
            var sonList = $(obj).next('div.parentFileBox').children('ul.fileBoxUl').children();
            var images = [];
            var type = $(obj).attr('attr');
            if(sonList.length < 1){
                return false;
            }
            sonList.each(function(index){
                if( $(this).children('div.cz').children('.diyFileName').val() !=$(this).children('.imageNote').val() ){
                    images[index] = {
                        img:$(this).children('div.viewThumb').children('img').attr('src'),
                        note:$(this).children('div.cz').children('.diyFileName').val(),
                        id:$(this).children('.imageId').val(),
                        type:type
                    };
                }
            });
            return images;
        }

//alert(document.referrer);
//保存到待发布
        $('.release').bind('click',function(){
            //获取图片数据
            var leyout = getImage('#leyout');         //户型图
            var indoor = getImage('#indoor');         //室内图
            var traffic = getImage('#traffic');      //交通图
            var peripheral = getImage('#peripheral');       //配套图
            var exterior = getImage('#exterior');      //外景图
            var title = [];
            title[0] = {id:$('#title').attr('value'),img:$('#title').attr('src'),type:$('#title').attr('attr'),note:''};   //标题图
            $('input[name=leyout]').val(JSON.stringify(leyout));
            $('input[name=indoor]').val(JSON.stringify(indoor));
            $('input[name=traffic]').val(JSON.stringify(traffic));
            $('input[name=peripheral]').val(JSON.stringify(peripheral));
            $('input[name=exterior]').val(JSON.stringify(exterior));
            $('input[name=titleimg]').val(JSON.stringify(title));

            $.ajax({
                type:'post',
                url:$('#oldsale').attr('action'),
                data: $('#oldsale').serialize(),
                success:function(data){
                    if(data == 1){
                        alert('保存成功');
                        if($('input[name=id]').val()){
                            window.location = document.referrer;
                        }else{
                            window.location = '/old<?=$class?>manage/releaseed';
                        }
                    }else{
                        alert('保存失败');
                    }
                }
            });

        });

    });

    //弹出层
    $(document).ready(function(e) {
        $(".ban li").click(function(){
            $(this).addClass("click").siblings(".ban li").removeClass("click");
        });
        $(".add .leyout li").click(function(){
            $(this).addClass("click").siblings(".add .leyout li").removeClass("click");
        });
        $('#add').submit(function(e){
            return false;
        });
//弹出层调用语句
        $('.modaltrigger').leanModal({
            top:110,
            overlay:0.45,
            closeButton:".hidemodal"
        });



        //提交
        $('.buildsub').bind('click',function(){
            $('input[name=buildingId]').val($('div.ban .click').attr('id'));
            $('input[name=building]').val($('div.ban .click').text());
            $('.building').text($('div.ban .click').text());
            $('.close').trigger('click');
            //获取单元号数据
            $.ajax({
                type:'get',
                url:'/getcommunityunit',
                data: {bId:$('div.ban .click').attr('id')},
                success:function(data){
                    var res = '';
                    for(var i=0;i<data.length;i++){
                        res +='<li id='+data[i].id+'>'+data[i].num+'</li>';
                    }
                    $('.comunit').html(res);
                    $('.comunit li').bind('click',unitclick);
                    //window.location = '/newmanage/releaseed';
                }
            });

        });
        //单元数点击
        function unitclick(){
            $('input[name=unitId]').val($(this).attr('id'));
            $('input[name=unit]').val($(this).text());
            $(this).parent().parent().prev().find('span').html($(this).text());
            $(this).parent().parent().hide();
        }

        //选择户型
        //提交
        $('.modelsub').bind('click',function(){
            $('input[name=roomId]').val($('div.leyout .click').attr('id'));
            $('input[name=roomStr]').val($('div.leyout .click').attr('roomstr'));
            $('input[name=houseRoom]').val($('div.leyout .click').attr('roomstr').substr(0,1));
            $('.close').trigger('click');
            $('.chose_leyout').find('img').attr('src',$('div.leyout .click').find('img').attr('src'));
            $('.chose_leyout').find('span').html($('div.leyout .click').find('span').text());
            $('.chose_leyout').show();
            $('.chose_leyout').prev().hide();

        });
    });

    /*
     * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
     * 其他参数同WebUploader
     */

    /* 上传图片 */

    /* 户型图 */
    $('#leyout').diyUpload({
        success:function( data ) {
            console.info( data );
        },
        error:function( err ) {
            console.info( err );
        },
        setId:'title'
    });

    /* 室内图 */
    $('#indoor').diyUpload({
        success:function( data ) {
            console.info( data );
        },
        error:function( err ) {
            console.info( err );
        },
        setId:'title'
    });

    /* 交通图 */
    $('#traffic').diyUpload({
        success:function( data ) {
            console.info( data );
        },
        error:function( err ) {
            console.info( err );
        },
        setId:'title'
    });

    /* 配套图 */
    $('#peripheral').diyUpload({
        success:function( data ) {
            console.info( data );
        },
        error:function( err ) {
            console.info( err );
        },
        setId:'title'
    });

    /* 外景图 */
    $('#exterior').diyUpload({
        success:function( data ) {
            console.info( data );
        },
        error:function( err ) {
            console.info( err );
        },
        setId:'title'
    });

    /* 标题图
    $('#title').diyUpload({
        success:function( data ) {
            console.info( data );
        },
        error:function( err ) {
            console.info( err );
        }
    });*/
</script>
</body>
</html>
