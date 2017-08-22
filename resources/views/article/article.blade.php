@extends('layout.layout')
@section('title')
    <title>wowoowoosoosowowoow</title>
@endsection
@section('content')
<div class="layui-tab layui-tab-brief" lay-filter="demoTitle">
    <div class="layui-body layui-tab-content site-demo site-demo-body">
        <div class="layui-tab-item layui-show">
            <div class="layui-main">
                <div id="LAY_preview">
                    <form class="layui-form articleForm" method="post" action="/article/postCreate">
                        <div class="layui-form-item">
                            <label class="layui-form-label">文章标题:</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">文章描述:</label>
                            <div class="layui-input-block">
                                <input type="text" name="description" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">文章类别</label>
                            <div class="layui-input-inline">
                                <select name="class">
                                    <option value="">请选择省</option>
                                    <option value="1" selected>娱乐</option>
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="type">
                                    <option value="">请选择市</option>
                                    <option value="1">小道</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">文章模式</label>
                            <div class="layui-input-block">
                                <input type="radio" name="model" value="0" title="单图模式">
                                <input type="radio" name="model" value="1" title="三图模式">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">上传图片:</label>
                            <div class="layui-input-block">
                                <input type="file" name="test[]" id="test"/><img src="" class="images" id="img" style="width:120px;">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="uploadImg layui-input-block">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">创建日期</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="date" id="date" lay-verify="date" placeholder="yyyy-mm-dd h:i:s" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block">
                                <input type="radio" name="state" value="0" title="待审核">
                                <input type="radio" name="state" value="1" title="审核通过">
                                <input type="radio" name="state" value="2" title="禁用">
                            </div>
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <textarea id="container" name="content"
                                      type="text/plain">
                            </textarea>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="demo1">立即提交</button>
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>">
<script src="/js/upload.js"></script>
<script type="text/javascript">
    $('input[name="test[]"]').UploadImg({
        url : '/article/upload',
        // width : '320',
        //height : '200',
        quality : '0.8', //压缩率，默认值为0.8
        // 如果quality是1 宽和高都未设定 则上传原图
        mixsize : '10000000',
        //type : 'image/png,image/jpg,image/jpeg,image/pjpeg,image/gif,image/bmp,image/x-png',
        before : function(blob){
//            $('#img').attr('src',blob);
            var img = '<img class="images" width="100px" height="100px" src="'+blob+'"/>';
            var inputImg = '<input type="hidden" name="pic[]" value="'+blob+'"/>';
            $('.uploadImg').append(img);
            $('.articleForm').append(inputImg);
        },
        error : function(res){
            $('#img').attr('src','');
            $('#error').html(res);
        },
        success : function(res){
            $('#imgurl').val(res);
        }
    });
</script>
@endsection