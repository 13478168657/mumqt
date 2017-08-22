<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/6
 * Time: 19:28
 */

 //纯写字楼,商业综合体楼,酒店写字楼
?>


@if($typeInfo == 201 || $typeInfo == 203 || $typeInfo == 204)
    <p class="caption">
        <span class="back_color"></span>
        基础信息
    </p>
    <ul class="input_msg enter_build">
        <li>
            <label><span class="dotted colorfe">*</span>写字楼等级：</label>
            <input type="radio" name="officeLevel" value="0" class="radio" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 0) checked="checked" @endif @endif />
            <span class="tishi">甲级</span>
            <input type="radio" name="officeLevel" value="1" class="radio" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 1) checked="checked" @endif @endif />
            <span class="tishi">乙级</span>
            <input type="radio" name="officeLevel" value="2" class="radio" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 2) checked="checked" @endif @endif />
            <span class="tishi">丙级</span>
            <input type="radio" name="officeLevel" value="3" class="radio" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 3) checked="checked" @endif @endif />
            <span class="tishi">其他</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>开工时间：</label>
            <input class="laydate-icon" id="time1" name="startTime" @if(!empty($type2GetInfo)) value="{{date('Y-m-d',$type2GetInfo->startTime)}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>产权年限：</label>
            <div class="dw" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$type2GetInfo->propertyYear}}年 @else 请选择 @endif</span><i></i></a>
                <div class="list_tag" id="cc">
                    <p class="top_icon"></p>
                    <ul>
                        <input type="hidden" name="propertyYear" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->propertyYear}}" @endif />
                        <li class="year" value="70">70年</li>
                        <li class="year" value="50">50年</li>
                        <li class="year" value="40">40年</li>
                        <li class="year" value="other">其他</li>
                    </ul>
                </div>
            </div>
            <input type="text" class="txt width2 cc" style="display:none; margin-left:20px;">
            <span class="tishi cc" style="display:none;">年</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>竣工时间：</label>
            <input class="laydate-icon" id="time2" name="endTime" @if(!empty($type2GetInfo)) value="{{date('Y-m-d',$type2GetInfo->endTime)}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>容积率：</label>
            <input type="text" class="txt width2" name="volume" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->volume}}" @endif />
            <span class="tishi">%</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>绿化率：</label>
            <input type="text" class="txt width2" name="greenRate" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->greenRate}}" @endif />
            <span class="tishi">%</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>建筑面积：</label>
            <input type="text" class="txt width2" name="floorage" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorage}}" @endif />
            <span class="tishi">平米</span>
            <span class="tishi colorfe">示例：200平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>占地面积：</label>
            <input type="text" class="txt width2" name="floorSpace" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorSpace}}" @endif />
            <span class="tishi">平米</span>
            <span class="tishi colorfe">示例：200平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>标准层面积：</label>
            <input type="text" class="txt width2" name="floorArea" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorArea}}" @endif />
            <span class="tishi">平米</span>
            <span class="tishi colorfe">示例：200平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>开间面积：</label>
            <input type="text" class="txt width4" name="bayAreaMin" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->bayAreaMin}}" @endif />
            <span class="tishi" style="margin-right:0;">平米</span>
            <span class="tishi" style="margin:0 10px;">至</span>
            <input type="text" class="txt width4" name="bayAreaMax" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->bayAreaMax}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>商业面积：</label>
            <input type="text" class="txt width2" name="commercialArea" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->commercialArea}}" @endif />
            <span class="tishi">平米</span>
            <span class="tishi colorfe">示例：200平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>办公面积：</label>
            <input type="text" class="txt width2" name="officeArea" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->officeArea}}" @endif />
            <span class="tishi">平米</span>
            <span class="tishi colorfe">示例：200平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>公共区域装修情况：</label>
            <div class="dw" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$decorationPublic[$type2GetInfo->decorationPublic]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag">
                    <p class="top_icon"></p>
                    <ul>
                        <input type="hidden" name="decorationPublic" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->decorationPublic}}" @endif />
                        <li class="dec" value="1">毛坯</li>
                        <li class="dec" value="2">中装修</li>
                        <li class="dec" value="3">精装修</li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>使用区域装修情况：</label>
            <div class="dw" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$decorationUsedRange[$type2GetInfo->decorationUsedRange]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag">
                    <p class="top_icon"></p>
                    <ul>
                        <input type="hidden" name="decorationUsedRange" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->decorationUsedRange}}" @endif />
                        <li class="use" value="1">毛坯</li>
                        <li class="use" value="2">网络地板+吊顶</li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>楼层承重：</label>
            <input type="text" class="txt width2" name="floorBearing" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorBearing}}" @endif />
            <span class="tishi">千克/平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>装修情况：</label>
            <div class="sort_icon" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$decoration[$type2GetInfo->decoration]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag">
                    <p class="top_icon"></p>
                    <ul>
                        <input type="hidden" name="decoration" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->decoration}}" @endif />
                        <li class="decor" value="1">毛坯</li>
                        <li class="decor" value="2">简装修</li>
                        <li class="decor" value="3">中装修</li>
                        <li class="decor" value="4">精装修</li>
                        <li class="decor" value="5">豪华装修</li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="no_height">
            <label><span class="dotted colorfe">*</span>大商圈：</label>
            @foreach($businesstags as $business)
                <input type="radio" name="businessTagId" value="{{$business->id}}" class="radio" @if(!empty($type2GetInfo->businessTagId)) @if($type2GetInfo->businessTagId == $business->id) checked="checked" @endif @endif/>
                <span class="tishi">{{$business->name}}</span>
            @endforeach
        </li>
        <li class="no_height">
            <label><span class="dotted colorfe">*</span>项目特色：</label>
            @foreach($tag as $t)
                <input type="checkbox" name="tagIds[]" value="{{$t->id}}" class="radio" @if(!empty($type2GetInfo->tagIds)) @if(in_array($t->id,explode('|',$type2GetInfo->tagIds))) checked="checked" @endif @endif />
                <span class="tishi">{{$t->name}}</span>
            @endforeach
            <label>&nbsp;</label>
            <span class="tishi">自定义项目特色：</span>
            <input type="text" class="txt width2" name="diyTagIds[]" style="margin-right:20px;" @if(!empty($type2GetInfo->diyTagIds)) value="{{explode('|',$type2GetInfo->diyTagIds)[0]}}" @endif />
            <input type="text" class="txt width2" name="diyTagIds[]" style="margin-right:20px;" @if(!empty($type2GetInfo->diyTagIds)) value="{{explode('|',$type2GetInfo->diyTagIds)[1]}}" @endif />
            <input type="text" class="txt width2" name="diyTagIds[]" style="margin-right:20px;" @if(!empty($type2GetInfo->diyTagIds)) value="{{explode('|',$type2GetInfo->diyTagIds)[2]}}" @endif />
        </li>
    </ul>
    </div>
    <div class="write_msg">
        <p class="caption">
            <span class="back_color"></span>
            内部设施
        </p>
        <ul class="input_msg enter_build">
            <li>
                <label><span class="dotted colorfe">*</span>建筑结构：</label>
                <div class="dw" style="margin-right:15px;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$structure[$type2GetInfo->structure]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag"  style="width:150px;">
                        <p class="top_icon"></p>
                        <ul>
                            <input type="hidden" name="structure" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->structure}}" @endif />
                            <li class="build" value="8">框架剪力墙</li>
                            <li class="build" value="9">其他</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑外墙：</label>
                <input type="text" class="txt width4" name="wallOutside" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->wallOutside}}" @endif />
                <span class="tishi colorfe">示例：玻璃幕墙</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑内墙：</label>
                <input type="text" class="txt width4" name="wallInside" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->wallInside}}" @endif />
                <span class="tishi colorfe">示例：高级内墙涂料</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>制冷/采暖：</label>
                <input type="text" class="txt width4" name="coolingHeating" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->coolingHeating}}" @endif />
                <span class="tishi colorfe">示例：中央空调</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>供电：</label>
                <div class="dw" style="margin-left:0;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$powat[$type2GetInfo->powerSupply]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag">
                        <p class="top_icon"></p>
                        <ul>
                            <input type="hidden" name="powerSupply" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->powerSupply}}" @endif />
                            <li class="pow" value="1">市政</li>
                            <li class="pow" value="2">其他</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>供水：</label>
                <div class="dw" style="margin-left:0;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$powat[$type2GetInfo->waterSupply]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag">
                        <p class="top_icon"></p>
                        <ul>
                            <input type="hidden" name="waterSupply" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->waterSupply}}" @endif />
                            <li class="wat" value="1">市政</li>
                            <li class="wat" value="2">其他</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>网络通讯：</label>
                <input type="text" class="txt width4" name="network" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->network}}" @endif />
                <span class="tishi colorfe">示例：光纤接入；语音采用大对数电缆</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>消防系统：</label>
                <input type="text" class="txt width4" name="fireFighting" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->fireFighting}}" @endif />
                <span class="tishi colorfe">示例：火灾报警及自动灭火系统</span>
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>安防系统：</label>
                <input type="text" class="txt width4" name="security" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->security}}" @endif />
                <span class="tishi colorfe">示例：无线巡更；无线对讲；监控系统；门卡识别；园区门禁出入识别</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>客梯个数：</label>
                <input type="text" class="txt width4" name="passengerLiftNum" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->passengerLiftNum}}" @endif />
                <span class="tishi">个</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>客梯品牌：</label>
                <input type="text" class="txt width4" name="passengerLiftBrand" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->passengerLiftBrand}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>货梯个数：</label>
                <input type="text" class="txt width4" name="goodsLiftNum" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->goodsLiftNum}}" @endif />

                <span class="tishi">个</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>货梯品牌：</label>
                <input type="text" class="txt width4" name="goodsLiftBrand" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->goodsLiftBrand}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>地板材料：</label>
                <input type="text" class="txt width4" name="flooring" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->flooring}}" @endif />
            </li>
            <li class="no_height">
                <label>空调描述：</label>
                <div class="float_l" style=" width:620px; height:100px;">
                    <textarea class="txtarea" name="airCondition" style=" width:600px; height:80px;">@if(!empty($type2GetInfo)){{$type2GetInfo->airCondition}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe">300</span>字可输入</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="write_msg">
        <p class="caption">
            <span class="back_color"></span>
            楼层状况
        </p>
        <ul class="input_msg enter_build">
            <li>
                <label><span class="dotted colorfe">*</span>总层数：</label>
                <input type="text" class="txt width2" name="totalFloor" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->totalFloor}}" @endif />
                <span class="tishi">层</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>地上层数：</label>
                <input type="text" class="txt width2" name="groundFloor" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->groundFloor}}" @endif />
                <span class="tishi">层</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>地下层数：</label>
                <input type="text" class="txt width2" name="underGroundFloor" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->underGroundFloor}}" @endif />
                <span class="tishi">层</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>标准层高：</label>
                <input type="text" class="txt width2" name="floorHeight" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorHeight}}" @endif />
                <span class="tishi">米</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>净层高：</label>
                <input type="text" class="txt width2" name="clearHeight" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->clearHeight}}" @endif />
                <span class="tishi">米</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑高度：</label>
                <input type="text" class="txt width2" name="buildingHeight" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->buildingHeight}}" @endif />
                <span class="tishi">米</span>
            </li>
            <li class="no_height">
                <label>补充说明：</label>
                <div class="float_l" style=" width:620px; height:100px;">
                    <textarea class="txtarea" name="floorRemark" style=" width:600px; height:80px;">@if(!empty($type2GetInfo)){{$type2GetInfo->floorRemark}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe">300</span>字可输入</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="write_msg">
        <p class="caption">
            <span class="back_color"></span>
            物业信息
        </p>
        <ul class="input_msg enter_build">
            <li>
                <label><span class="dotted colorfe">*</span>物业费：</label>
                <input type="text" class="txt width4" name="propertyFee" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->propertyFee}}" @endif />
                <span class="tishi">元/平米▪月</span>
                <span class="tishi colorfe">示例：5.6元/平米▪月</span>
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>车位信息：</label>
                <span class="tishi">规划机动车停车位</span>
                <input type="text" class="txt width3" name="parkingInfo[]" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[0]}}" @endif />
                <span class="tishi">个，其中地上约</span>
                <input type="text" class="txt width3" name="parkingInfo[]" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[1]}}" @endif />
                <span class="tishi">个，地下约</span>
                <input type="text" class="txt width3" name="parkingInfo[]" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[2]}}" @endif />
                <span class="tishi">个。住宅的机动车车位配比为</span>
                <input type="text" class="txt width3" name="parkingInfo[]" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[3]}}" @endif />
                <span class="tishi" style="margin-right:5px;">：</span>
                <input type="text" class="txt width3" name="parkingInfo[]" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[4]}}" @endif />
                <span class="tishi">。</span>
            </li>
            <li class="no_height">
                <label>备注：</label>
                <div class="float_l" style=" width:620px; height:100px;">
                    <textarea class="txtarea" name="propertyRemark" style=" width:600px; height:80px;">@if(!empty($type2GetInfo)){{$type2GetInfo->propertyRemark}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe">300</span>字可输入</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="write_msg">
        <p class="caption">
            <span class="back_color"></span>
            许可信息
        </p>
        <ul class="input_msg enter_build">
            <li>
                <label><span class="dotted colorfe">*</span>国有土地使用证：</label>
                <input type="text" class="txt width2" name="StateLandPermit" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->StateLandPermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建设用地规划许可证：</label>
                <input type="text" class="txt width2" name="constructionLandUsePermit" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->constructionLandUsePermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑工程规划许可证：</label>
                <input type="text" class="txt width2" name="constructionPlanningPermit" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->constructionPlanningPermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑工程施工许可证：</label>
                <input type="text" class="txt width2" name="buildingEngineeringConstructionPermit" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->buildingEngineeringConstructionPermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>商品房预售许可证：</label>
                <input type="text" class="txt width2" name="preSalePermit" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->preSalePermit)}}" @endif />
            </li>
            <div class="clear"></div>
        </ul>
    </div>
    <div class="write_msg">
        <p class="caption">
            <span class="back_color"></span>
            项目介绍
        </p>
        <ul class="input_msg">
            <li class="no_height">
                <label>&nbsp;</label>
                <div class="float_l" style=" width:620px;">
                    <textarea class="txtarea" name="intro" style=" width:600px;">@if(!empty($type2GetInfo)){{$type2GetInfo->intro}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe">300</span>字可输入</span>
                </div>
            </li>
        </ul>
    </div>
@endif