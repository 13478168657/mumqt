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
            <div class="parentFileBox">
                <ul class="fileBoxUl">
                    @if(!empty($info['huxing']))
                        @foreach($info['huxing'] as $ghkey => $ghval)
                            <li class="diyUploadHover">
                                <div class="viewThumb">
                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                </div>
                                <div class="diyCancel" ></div>
                                <div class="diySuccess"></div>
                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </li>
        <li style="height:auto; overflow:hidden;">
            <label>室内图：</label>
            <div id="box" class="box">
                <div id="indoor" attr="10"></div>
                <div class="parentFileBox">
                    <ul class="fileBoxUl">
                        @if(!empty($info['indoor']))
                            @foreach($info['indoor'] as $ghkey => $ghval)
                                <li class="diyUploadHover">
                                    <div class="viewThumb">
                                        <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                    </div>
                                    <div class="diyCancel" ></div>
                                    <div class="diySuccess"></div>
                                    <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                    <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                    <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </li>
        <li style="height:auto; overflow:hidden;">
            <label>交通图：</label>
            <div id="box" class="box">
                <div id="traffic" attr="11"></div>
                <div class="parentFileBox">
                    <ul class="fileBoxUl">
                        @if(!empty($info['traffic']))
                            @foreach($info['traffic'] as $ghkey => $ghval)
                                <li class="diyUploadHover">
                                    <div class="viewThumb">
                                        <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                    </div>
                                    <div class="diyCancel" ></div>
                                    <div class="diySuccess"></div>
                                    <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                    <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                    <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </li>
        <li style="height:auto; overflow:hidden;">
            <label>周边配套图：</label>
            <div id="box" class="box">
                <div id="peripheral" attr="12"></div>
                <div class="parentFileBox">
                    <ul class="fileBoxUl">
                        @if(!empty($info['peripheral']))
                            @foreach($info['peripheral'] as $ghkey => $ghval)
                                <li class="diyUploadHover">
                                    <div class="viewThumb">
                                        <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                    </div>
                                    <div class="diyCancel" ></div>
                                    <div class="diySuccess"></div>
                                    <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                    <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                    <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </li>

    <li style="height:auto; overflow:hidden;">
        <label>外景图：</label>
        <div id="box" class="box">
            <div id="exterior" attr="8"></div>
            <div class="parentFileBox">
                <ul class="fileBoxUl">
                    @if(!empty($info['waijing']))
                        @foreach($info['waijing'] as $ghkey => $ghval)
                            <li class="diyUploadHover">
                                <div class="viewThumb">
                                    <img src="{{config('imgConfig.imgSavePath')}}{{$ghval->fileName}}">
                                </div>
                                <div class="diyCancel" ></div>
                                <div class="diySuccess"></div>
                                <div class="cz"><input class="diyFileName" type="text" placeholder="别名"  value="{{$ghval->note}}"></div>
                                <input class="imageId" type="hidden" value="{{$ghval->id}}">
                                <input class="imageNote" type="hidden" value="{{$ghval->note}}">
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </li>
    <li style="height:auto; overflow:hidden;">
        <label>标题图：</label>
            <div class="parentFileBox">
                <ul class="fileBoxUl">
                    @if(!empty($info['biaoti']))
                            <li class="diyUploadHover">
                                <div class="viewThumb">
                                    <img value="{{$info['biaoti'][0]->id}}" src="{{config('imgConfig.imgSavePath')}}{{$info['biaoti'][0]->fileName}}" id="title" attr="9">
                                </div>
                            </li>
                    @else
                        <li class="diyUploadHover">
                            <div class="viewThumb">
                                <img src="../../../image/img1.jpg" id="title" attr="9">
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
    </li>
</ul>