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
            <input type="radio" name="officeLevel" value="0" class="radio" datatype="*" nullmsg="请选择写字楼等级" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 0) checked="checked" @endif @endif />
            <span class="tishi">甲级</span>
            <input type="radio" name="officeLevel" value="1" class="radio" datatype="*" nullmsg="请选择写字楼等级" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 1) checked="checked" @endif @endif />
            <span class="tishi">乙级</span>
            <input type="radio" name="officeLevel" value="2" class="radio" datatype="*" nullmsg="请选择写字楼等级" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 2) checked="checked" @endif @endif />
            <span class="tishi">丙级</span>
            <input type="radio" name="officeLevel" value="3" class="radio" datatype="*" nullmsg="请选择写字楼等级" @if(!empty($type2GetInfo)) @if($type2GetInfo->officeLevel == 3) checked="checked" @endif @endif />
            <span class="tishi">其他</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>开工时间：</label>
            <input class="laydate-icon" id="time1" name="startTime" datatype="*" nullmsg="请选择开工时间" @if(!empty($type2GetInfo)) value="{{date('Y-m-d',$type2GetInfo->startTime)}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>产权年限：</label>
            <div class="dw" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$type2GetInfo->propertyYear}}年 @else 请选择 @endif</span><i></i></a>
                <div class="list_tag" id="cc">
                    <p class="top_icon"></p>
                    <ul>
                        <li class="year" value="70">70年</li>
                        <li class="year" value="50">50年</li>
                        <li class="year" value="40">40年</li>
                        <li class="year" value="other">其他</li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="propertyYear" datatype="*" nullmsg="产权年限不能为空" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->propertyYear}}" @endif />
            <input type="text" class="txt width2 cc" style="display:none; margin-left:20px;">
            <span class="tishi cc" style="display:none;">年</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>竣工时间：</label>
            <input class="laydate-icon" id="time2" name="endTime" datatype="*" nullmsg="请选择竣工时间" @if(!empty($type2GetInfo)) value="{{date('Y-m-d',$type2GetInfo->endTime)}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>容积率：</label>
            <input type="text" class="txt width2" name="volume" datatype="n1-5" nullmsg="请填写容积率" errormsg="容积率为正整数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->volume}}" @endif />
            <span class="tishi">%</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>绿化率：</label>
            <input type="text" class="txt width2" name="greenRate" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写绿化率" errormsg="绿化率为正整数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->greenRate}}" @endif />
            <span class="tishi">%</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>建筑面积：</label>
            <input type="text" class="txt width2" name="floorage" datatype="n1-5" nullmsg="请填写建筑面积" errormsg="建筑面积为正整数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorage}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>占地面积：</label>
            <input type="text" class="txt width2" name="floorSpace" datatype="n1-5" nullmsg="请填写占地面积" errormsg="占地面积为正整数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorSpace}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>标准层面积：</label>
            <input type="text" class="txt width2" name="floorArea" datatype="n1-5" nullmsg="请填写标准层面积" errormsg="标准层面积为正整数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorArea}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>开间面积：</label>
            <input type="text" class="txt width4" name="bayAreaMin" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写开间面积" errormsg="开间面积为正整数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->bayAreaMin}}" @endif />
            <span class="tishi" style="margin-right:0;">平米</span>
            <span class="tishi" style="margin:0 10px;">至</span>
            <input type="text" class="txt width4" name="bayAreaMax" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写开间面积" errormsg="开间面积为正整数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->bayAreaMax}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>商业面积：</label>
            <input type="text" class="txt width2" name="commercialArea" datatype="n1-5" nullmsg="请填写商业面积" errormsg="商业面积为正整数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->commercialArea}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>办公面积：</label>
            <input type="text" class="txt width2" name="officeArea" datatype="n1-5" nullmsg="请填写办公面积" errormsg="办公面积为正整数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->officeArea}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>公共区域装修情况：</label>
            <div class="dw" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$decorationPublic[$type2GetInfo->decorationPublic]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag">
                    <p class="top_icon"></p>
                    <ul>
                        <li class="dec" value="1">毛坯</li>
                        <li class="dec" value="2">中装修</li>
                        <li class="dec" value="3">精装修</li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="decorationPublic" datatype="*" nullmsg="请选择装修情况" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->decorationPublic}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>使用区域装修情况：</label>
            <div class="dw" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$decorationUsedRange[$type2GetInfo->decorationUsedRange]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag">
                    <p class="top_icon"></p>
                    <ul>
                        <li class="use" value="1">毛坯</li>
                        <li class="use" value="2">网络地板+吊顶</li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="decorationUsedRange" datatype="*" nullmsg="请选择装修情况" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->decorationUsedRange}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>楼层承重：</label>
            <input type="text" class="txt width2" name="floorBearing" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写楼层承重" errormsg="楼层承重为正整数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorBearing}}" @endif />
            <span class="tishi">千克/平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>装修情况：</label>
            <div class="sort_icon" style="margin-left:0;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$decoration[$type2GetInfo->decoration]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag">
                    <p class="top_icon"></p>
                    <ul>
                        <li class="decor" value="1">毛坯</li>
                        <li class="decor" value="2">简装修</li>
                        <li class="decor" value="3">中装修</li>
                        <li class="decor" value="4">精装修</li>
                        <li class="decor" value="5">豪华装修</li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="decoration" datatype="*" nullmsg="请选择装修情况" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->decoration}}" @endif />
        </li>
        <li class="no_height">
            <label><span class="dotted colorfe">*</span>大商圈：</label>
            @foreach($businesstags as $business)
                <input type="radio" name="businessTagId" value="{{$business->id}}" class="radio" datatype="*" nullmsg="请选择大商圈" @if(!empty($type2GetInfo->businessTagId)) @if($type2GetInfo->businessTagId == $business->id) checked="checked" @endif @endif/>
                <span class="tishi">{{$business->name}}</span>
            @endforeach
        </li>
        <li class="no_height">
            <label><span class="dotted colorfe">*</span>项目特色：</label>
            @foreach($tag as $t)
                <input type="checkbox" name="tagIds[]" value="{{$t->id}}" class="radio" datatype="*" nullmsg="请选择项目特色" @if(!empty($type2GetInfo->tagIds)) @if(in_array($t->id,explode('|',$type2GetInfo->tagIds))) checked="checked" @endif @endif />
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
                            <li class="build" value="8">框架剪力墙</li>
                            <li class="build" value="9">其他</li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="structure" datatype="*" nullmsg="请选择建筑结构" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->structure}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑外墙：</label>
                <input type="text" class="txt width4" name="wallOutside" datatype="*" nullmsg="请填写建筑外墙" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->wallOutside}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑内墙：</label>
                <input type="text" class="txt width4" name="wallInside" datatype="*" nullmsg="请填写建筑内墙" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->wallInside}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>制冷/采暖：</label>
                <input type="text" class="txt width4" name="coolingHeating" datatype="*" nullmsg="请填写制冷/采暖" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->coolingHeating}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>供电：</label>
                <div class="dw" style="margin-left:0;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$powat[$type2GetInfo->powerSupply]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag">
                        <p class="top_icon"></p>
                        <ul>
                            <li class="pow" value="1">市政</li>
                            <li class="pow" value="2">其他</li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="powerSupply" datatype="*" nullmsg="请选择供电方式" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->powerSupply}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>供水：</label>
                <div class="dw" style="margin-left:0;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$powat[$type2GetInfo->waterSupply]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag">
                        <p class="top_icon"></p>
                        <ul>
                            <li class="wat" value="1">市政</li>
                            <li class="wat" value="2">其他</li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" name="waterSupply" datatype="*" nullmsg="请选择供水方式" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->waterSupply}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>网络通讯：</label>
                <input type="text" class="txt width4" name="network" datatype="*" nullmsg="请填写网络通讯" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->network}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>消防系统：</label>
                <input type="text" class="txt width4" name="fireFighting" datatype="*" nullmsg="请填写消防系统" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->fireFighting}}" @endif />
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>安防系统：</label>
                <input type="text" class="txt width4" name="security" datatype="*" nullmsg="请填写安防系统" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->security}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>客梯个数：</label>
                <input type="text" class="txt width4" name="passengerLiftNum" datatype="n1-3" nullmsg="请填写客梯个数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->passengerLiftNum}}" @endif />
                <span class="tishi">个</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>客梯品牌：</label>
                <input type="text" class="txt width4" name="passengerLiftBrand" datatype="*" nullmsg="请填写客梯品牌" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->passengerLiftBrand}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>货梯个数：</label>
                <input type="text" class="txt width4" name="goodsLiftNum" datatype="n1-3" nullmsg="请填写货梯个数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->goodsLiftNum}}" @endif />

                <span class="tishi">个</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>货梯品牌：</label>
                <input type="text" class="txt width4" name="goodsLiftBrand" datatype="*" nullmsg="请填写货梯品牌" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->goodsLiftBrand}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>地板材料：</label>
                <input type="text" class="txt width4" name="flooring" datatype="*" nullmsg="请填写地板材料" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->flooring}}" @endif />
            </li>
            <li class="no_height">
                <label>空调描述：</label>
                <div class="float_l" style=" width:620px; height:100px;">
                    <textarea class="txtarea" id="airCondition" name="airCondition" datatype="*" nullmsg="请填写空调描述" style=" width:600px; height:80px;">@if(!empty($type2GetInfo)){{$type2GetInfo->airCondition}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe" id="ktms">@if(!empty($type2GetInfo->airCondition)) {{300 - mb_strlen($type2GetInfo->airCondition, 'utf-8')}} @else 300 @endif</span>字可输入</span>
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
                <input type="text" class="txt width2" name="totalFloor" datatype="n1-3" nullmsg="请填写总层数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->totalFloor}}" @endif />
                <span class="tishi">层</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>地上层数：</label>
                <input type="text" class="txt width2" name="groundFloor" datatype="n1-3" nullmsg="请填写地上层数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->groundFloor}}" @endif />
                <span class="tishi">层</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>地下层数：</label>
                <input type="text" class="txt width2" name="underGroundFloor" datatype="n1-3" nullmsg="请填写地下层数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->underGroundFloor}}" @endif />
                <span class="tishi">层</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>标准层高：</label>
                <input type="text" class="txt width2" name="floorHeight" datatype="n1-3" nullmsg="请填写标准层高" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorHeight}}" @endif />
                <span class="tishi">米</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>净层高：</label>
                <input type="text" class="txt width2" name="clearHeight" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写净层高" errormsg="净层高为正整数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->clearHeight}}" @endif />
                <span class="tishi">米</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑高度：</label>
                <input type="text" class="txt width2" name="buildingHeight" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写建筑高度" errormsg="建筑高度为正整数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->buildingHeight}}" @endif />
                <span class="tishi">米</span>
            </li>
            <li class="no_height">
                <label>补充说明：</label>
                <div class="float_l" style=" width:620px; height:100px;">
                    <textarea class="txtarea" id="floorRemark" name="floorRemark" style=" width:600px; height:80px;">@if(!empty($type2GetInfo)){{$type2GetInfo->floorRemark}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe" id="bcsm">@if(!empty($type2GetInfo->floorRemark)) {{300 - mb_strlen($type2GetInfo->floorRemark, 'utf-8')}} @else 300 @endif</span>字可输入</span>
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
                <input type="text" class="txt width4" name="propertyFee" datatype="/^(([1-9]\d*$)|(^0\.\d{1,2}$)|(^[1-9]\d*\.\d{1,2}))$/" nullmsg="请填写物业费" errormsg="物业费为正数或1-2位小数" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->propertyFee}}" @endif />
                <span class="tishi">元/平米▪月</span>
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>车位信息：</label>
                <span class="tishi">规划机动车停车位</span>
                <input type="text" class="txt width3" name="parkingInfo[]" datatype="n1-5" nullmsg="请填写车位信息" error="车位信息为正整数" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[0]}}" @endif />
                <span class="tishi">个，其中地上约</span>
                <input type="text" class="txt width3" name="parkingInfo[]" datatype="n1-5" nullmsg="请填写车位信息" error="车位信息为正整数" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[1]}}" @endif />
                <span class="tishi">个，地下约</span>
                <input type="text" class="txt width3" name="parkingInfo[]" datatype="n1-5" nullmsg="请填写车位信息" error="车位信息为正整数" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[2]}}" @endif />
                <span class="tishi">个。住宅的机动车车位配比为</span>
                <input type="text" class="txt width3" name="parkingInfo[]" datatype="n1-5" nullmsg="请填写车位信息" error="车位信息为正整数" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[3]}}" @endif />
                <span class="tishi" style="margin-right:5px;">：</span>
                <input type="text" class="txt width3" name="parkingInfo[]" datatype="n1-5" nullmsg="请填写车位信息" error="车位信息为正整数" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[4]}}" @endif />
                <span class="tishi">。</span>
            </li>
            <li class="no_height">
                <label>备注：</label>
                <div class="float_l" style=" width:620px; height:100px;">
                    <textarea class="txtarea" id="propertyRemark" name="propertyRemark" style=" width:600px; height:80px;">@if(!empty($type2GetInfo)){{$type2GetInfo->propertyRemark}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe" id="bz">@if(!empty($type2GetInfo->propertyRemark)) {{300 - mb_strlen($type2GetInfo->propertyRemark, 'utf-8')}} @else 300 @endif</span>字可输入</span>
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
                <input type="text" class="txt width2" name="StateLandPermit" datatype="*" nullmsg="请填写国有土地使用证" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->StateLandPermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建设用地规划许可证：</label>
                <input type="text" class="txt width2" name="constructionLandUsePermit" datatype="*" nullmsg="请填写建设用地规划许可证" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->constructionLandUsePermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑工程规划许可证：</label>
                <input type="text" class="txt width2" name="constructionPlanningPermit" datatype="*" nullmsg="请填写建筑工程规划许可证" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->constructionPlanningPermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>建筑工程施工许可证：</label>
                <input type="text" class="txt width2" name="buildingEngineeringConstructionPermit" datatype="*" nullmsg="请填写建筑工程施工许可证" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->buildingEngineeringConstructionPermit)}}" @endif />
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>商品房预售许可证：</label>
                <input type="text" class="txt width2" name="preSalePermit" datatype="*" nullmsg="请填写商品房预售许可证" @if(!empty($type2GetInfo)) value="{{$safeUtil->decrypt($type2GetInfo->preSalePermit)}}" @endif />
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
                    <textarea class="txtarea" id="intro" name="intro" style=" width:600px;">@if(!empty($type2GetInfo)){{$type2GetInfo->intro}}@endif</textarea>
                    <span class="hs">还剩<span class="colorfe" id="xmjs">@if(!empty($type2GetInfo->intro)) {{300 - mb_strlen($type2GetInfo->intro, 'utf-8')}} @else 300 @endif</span>字可输入</span>
                </div>
            </li>
        </ul>
    </div>
@endif