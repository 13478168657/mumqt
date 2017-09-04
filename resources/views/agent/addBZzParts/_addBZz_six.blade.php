<?php
/**
 * Created by PhpStorm.
 * User: huzhaer
 * Date: 2016/1/6
 * Time: 19:34
 */


    //精品豪宅
?>

@if($typeInfo == 305)
    <p class="caption">
        <span class="back_color"></span>
        基础信息
    </p>
    <ul class="input_msg enter_build">
        <li>
            <label><span class="dotted colorfe">*</span>房屋类别：</label>
            <div class="sort_icon" style="margin-right:15px;">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$houseType[$type2GetInfo->homeDesignType]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag"  style="width:150px;">
                    <p class="top_icon"></p>
                    <ul>
                        <input type="hidden" name="homeDesignType" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->homeDesignType}}" @endif />
                        <li class="design" value="1">错层</li>
                        <li class="design" value="2">跃层</li>
                        <li class="design" value="3">复式</li>
                        <li class="design" value="4">开间</li>
                        <li class="design" value="5">平层</li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>建筑结构：</label>
            <div class="sort_icon">
                <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$structure[$type2GetInfo->structure]}} @else 请选择 @endif</span><i></i></a>
                <div class="list_tag"  style="width:150px;">
                    <p class="top_icon"></p>
                    <ul>
                        <input type="hidden" name="structure" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->structure}}" @endif />
                        <li class="build" value="1">板楼</li>
                        <li class="build" value="2">塔楼</li>
                        <li class="build" value="3">砖楼</li>
                        <li class="build" value="4">砖混</li>
                        <li class="build" value="5">平房</li>
                        <li class="build" value="6">钢混</li>
                        <li class="build" value="7">塔板结合</li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>开工时间：</label>
            <input class="laydate-icon" id="time1" name="startTime" @if(!empty($type2GetInfo)) value="{{date('Y-m-d',$type2GetInfo->startTime)}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>建筑面积：</label>
            <input type="text" class="txt width2" name="floorage" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorage}}" @endif />
            <span class="tishi">平米</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>竣工时间：</label>
            <input class="laydate-icon" id="time2" name="endTime" @if(!empty($type2GetInfo)) value="{{date('Y-m-d',$type2GetInfo->endTime)}}" @endif />
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>占地面积：</label>
            <input type="text" class="txt width2" name="floorSpace" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorSpace}}" @endif />
            <span class="tishi">平米</span>
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
            <label><span class="dotted colorfe">*</span>总户数：</label>
            <input type="text" class="txt width2" name="houseTotal" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->houseTotal}}" @endif />
            <span class="tishi">户</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>容积率：</label>
            <input type="text" class="txt width2" name="volume" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->volume}}" @endif />
            <span class="tishi">%</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>得房率：</label>
            <input type="text" class="txt width2" name="getRate" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->getRate}}" @endif />
            <span class="tishi">%（预计）</span>
            <span class="tishi colorfe">示例：98%</span>
        </li>
        <li>
            <label><span class="dotted colorfe">*</span>绿化率：</label>
            <input type="text" class="txt width2" name="greenRate" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->greenRate}}" @endif />
            <span class="tishi">%</span>
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
        <li>
            <label><span class="dotted colorfe">*</span>标准层高：</label>
            <input type="text" class="txt width2" name="floorHeight" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->floorHeight}}" @endif />
            <span class="tishi">米</span>
        </li>
        <li class="no_height">
            <label><span class="dotted colorfe">*</span>所属板块：</label>
            @foreach($macroplate as $mac)
                <input type="radio" name="macroplateId" value="{{$mac->id}}" class="radio" @if(!empty($type2GetInfo)) @if($type2GetInfo->macroplateId == $mac->id) checked="checked" @endif @endif />
                <span class="tishi">{{$mac->name}}</span>
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
            物业信息
        </p>
        <ul class="input_msg enter_build">
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
                <label><span class="dotted colorfe">*</span>物业费：</label>
                <input type="text" class="txt width4" name="propertyFee" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->propertyFee}}" @endif />
                <span class="tishi">元/平米▪月</span>
                <span class="tishi colorfe">示例：5.6元/平米▪月</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>供气：</label>
                <div class="dw" style="margin-left:0;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$gasSupply[$type2GetInfo->gasSupply]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag">
                        <p class="top_icon"></p>
                        <ul>
                            <input type="hidden" name="gasSupply" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->gasSupply}}" @endif />
                            <li class="gas" value="1">管道</li>
                            <li class="gas" value="2">其他</li>
                            <li class="gas" value="0">无</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>车位信息：</label>
                <span class="tishi">规划机动车停车位</span>
                <input type="text" class="txt width3" name="parkingInfo[]" @if(!empty($type2GetInfo->parkingInfo)) value="{{explode('_',$type2GetInfo->parkingInfo)[0]}}" @endif />
                <span class="tishi">个</span>
            </li>
            <li>
                <label><span class="dotted colorfe">*</span>供暖：</label>
                <div class="dw" style="margin-left:0;">
                    <a class="term_title"><span>@if(!empty($type2GetInfo)) {{$heatingSupply[$type2GetInfo->heatingSupply]}} @else 请选择 @endif</span><i></i></a>
                    <div class="list_tag">
                        <p class="top_icon"></p>
                        <ul>
                            <input type="hidden" name="heatingSupply" @if(!empty($type2GetInfo)) value="{{$type2GetInfo->heatingSupply}}" @endif />
                            <li class="heating" value="1">集中供暖</li>
                            <li class="heating" value="2">小区供暖</li>
                            <li class="heating" value="3">自采暖</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="no_height">
                <label>&nbsp;</label>
                <span class="tishi">其中地上约</span>
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
            学区信息
        </p>
        <ul class="input_msg enter_build">
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>幼儿园：</label>
                <input type="text" class="txt width1" name="child[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][0]->name)) value="{{$childInfo[1][0]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="child[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][1]->name)) value="{{$childInfo[1][1]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="child[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][2]->name)) value="{{$childInfo[1][2]->name}}" @endif @endif />
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>小学：</label>
                <input type="text" class="txt width1" name="kid[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][0]->name)) value="{{$childInfo[2][0]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="kid[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][1]->name)) value="{{$childInfo[2][1]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="kid[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][2]->name)) value="{{$childInfo[2][2]->name}}" @endif @endif />
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>初中：</label>
                <input type="text" class="txt width1" name="primary[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][0]->name)) value="{{$childInfo[3][0]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="primary[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][1]->name)) value="{{$childInfo[3][1]->name}}" @endif @endif  />
                <input type="text" class="txt width1 margin_left" name="primary[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][2]->name)) value="{{$childInfo[3][2]->name}}" @endif @endif />
            </li>
            <li class="no_height">
                <label><span class="dotted colorfe">*</span>高中：</label>
                <input type="text" class="txt width1" name="height[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][0]->name)) value="{{$childInfo[4][0]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="height[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][1]->name)) value="{{$childInfo[4][1]->name}}" @endif @endif />
                <input type="text" class="txt width1 margin_left" name="height[]" @if(!empty($type2GetInfo)) @if(!empty($childInfo[1][2]->name)) value="{{$childInfo[4][2]->name}}" @endif @endif />
            </li>
            <div class="clear"></div>
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
