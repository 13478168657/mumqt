@extends('layout.layout')
@section('title')
    <title>afafa</title>
@endsection
@section('css')
    <link rel="stylesheet" href="/css/article.css" />
@endsection
@section('content')
        <!--nav--start-->
    <div class="nav nav-fixed clearfix">
        <div class="w">
            <div class="nav-menu ">
                <ul class='fl'>
                    <li><a href="#" target="_blank">怀孕计算器</a></li>
                    <li><a href="#" target="_blank">视频学习</a></li>
                    <li><a href="#" target="_blank">备孕</a></li>
                    <li><a href="#" target="_blank">怀孕</a></li>
                    <li><a href="#" target="_blank">坐月子</a></li>
                    <li><a href="#" target="_blank">产后</a></li>
                    <li><a href="#" target="_blank">宝宝起名</a></li>
                    <li><a href="#" target="_blank">问答</a></li>
                    <li><a href="#" target="_blank">宝宝相册</a></li>
                    <li><a href="#" target="_blank">专题</a></li>
                </ul>
                <ul class='fr'>
                    <li class='login'><a href="#" target="_blank">登录</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--nav--end-->
    <div class='middlebar'>
        <div class='w'>
            <div class='middlebar-l fl'>
                <a href='#' target="_blank"><img src='images/logo-toutiao.png' alt=''></a>
            </div>
            <div class='middlebar-m fl'>
                <ul>
                    <li><h2><a href='' target="_blank">首页</a>/</h2></li>
                    <li><h2><a href='' target="_blank">育儿</a>/</h2></li>
                    <li><h2><a href='' target="_blank">正文</a></h2></li>
                </ul>
            </div>
            <div class='middlebar-r fr'>
                <div class="search-input">
                    <!--placeholder="运动相机"-->
                    <input type="text" value="运动相机"/>
                    <button>搜索</button>
                </div>
            </div>
        </div>
    </div>
    <!--content-start-->
    <div class='w clearfix'>
        <div class='content-l fl'>
            <div class='share'>
                <a href='' target="_blank"><img src='images/qq.png' alt=''>QQ</a>
                <a href='' target="_blank"><img src='images/qqkongjian.png' alt=''>Qzone</a>
                <a href='' target="_blank"><img src='images/xinliang.png' alt=''>微博</a>
                <a href='' target="_blank"><img src='images/weixin.png' alt=''>微信</a>
            </div>
        </div>
        <div class='content-m fl'>
            <h1>{{$article->title}}</h1>
            <h2>
                <span class='original'>原创</span>
                <span class='src'>观海解局</span>
                <span class='time'>{{date("Y-m-d H:s",strtotime($article->timeCreate))}}</span>
            </h2>
            <div class='content-m-c'>
            <?php echo html_entity_decode($article->content); ?>
            </div>
            <div class='shengming'><h3>声明：本文由入驻搜狐公众平台的作者撰写，除搜狐官方账号外，观点仅代表作者本人，不代表搜狐立场。</h3></div>
            <div class='guanggao'>广告</div>
            <div class="c-header"> <em>694&nbsp;</em>条评论 </div>
            <div class="inputBox">
                <div class="y-box">
                    <div class="avatar-wrap avatar-wrap-center">  </div>
                    <div class="input-wrap  ">
                        <div class="c-textarea" ga_event="click_input_comment">
                            <textarea name="inputText" placeholder="写下您的评论..."></textarea>
                        </div>
                        <div class="c-action" ga_event="click_publish_comment">
                            <div class="c-submit">评论</div>
                        </div>
                    </div>
                </div>
                <ul>
                    <li class="c-item">
                        <a target="_blank" class="avatar-wrap" href="">
                            <img alt="" src="" >
                        </a>
                        <div class="c-content">
                            <div class="c-user-info">
                                <a class="c-user-name" target="_blank" href="">yang26600368</a>
                                <span class="c-create-time">6小时前</span>
                            </div>
                            <p>古人云！一人不旅游！二人不看井！三人不挑水！记住！</p>
                            <div class="c-footer-action">
                                <span class="c-reply" ga_event="click_reply_comment">回复</span>
                                <span class="c-reply-count" ga_event="click_expand_reply">&nbsp;⋅&nbsp;28条回复<i class="y-icon icon-more"></i></span>
										<span class="y-right c-report" title="举报">
											<i class="y-icon icon-report"></i>
										</span>
                                <span title="点赞" class="y-right c-digg ">141&nbsp;<i class="y-icon icon-digg"></i></span>
                            </div>
                            <div class="J_input_0"></div> <!--riot placeholder-->
                        </div>
                    </li>
                    <li class="c-item">
                        <a target="_blank" class="avatar-wrap" href="">
                            <img alt="" src="" >
                        </a>
                        <div class="c-content">
                            <div class="c-user-info">
                                <a class="c-user-name" target="_blank" href="">yang26600368</a>
                                <span class="c-create-time">6小时前</span>
                            </div>
                            <p>古人云！一人不旅游！二人不看井！三人不挑水！记住！</p>
                            <div class="c-footer-action">
                                <span class="c-reply" >回复</span>
                                <span class="c-reply-count" >&nbsp;⋅&nbsp;28条回复<i class="y-icon icon-more"></i></span>
										<span class="y-right c-report" title="举报">
											<i class="y-icon icon-report"></i>
										</span>
                                <span title="点赞"  class="y-right c-digg ">141&nbsp;<i class="y-icon icon-digg"></i></span>
                            </div>
                            <div class="J_input_0"></div> <!--riot placeholder-->
                        </div>
                    </li>
                    <li class="c-item">
                        <a target="_blank" class="avatar-wrap" href="">
                            <img alt="" src="" alt=''>
                        </a>
                        <div class="c-content">
                            <div class="c-user-info">
                                <a class="c-user-name" target="_blank" href="">yang26600368</a>
                                <span class="c-create-time">6小时前</span>
                            </div>
                            <p>古人云！一人不旅游！二人不看井！三人不挑水！记住！</p>
                            <div class="c-footer-action">
                                <span class="c-reply" >回复</span>
                                <span class="c-reply-count" >&nbsp;⋅&nbsp;28条回复<i class="y-icon icon-more"></i></span>
										<span class="y-right c-report" title="举报">
											<i class="y-icon icon-report"></i>
										</span>
                                <span title="点赞"  class="y-right c-digg ">141&nbsp;<i class="y-icon icon-digg"></i></span>
                            </div>
                            <div class="J_input_0"></div> <!--riot placeholder-->
                        </div>
                    </li>
                    <ul>
                        <div class="c-load-more">查看更多评论</div>
            </div>
        </div>
        <div class='content-r fr'>
            <div class='content-hot content-ad'>
                广告---Ad
            </div>
        </div>
        <div class='content-r fr'>
            <div class='content-hot'>
                <span class="tt">24小时热文</span>
            </div>
            <div class="pic-txt clear " >
                <div class="pic img-do">
                    <a target="_blank" href="">
                        <img alt="" src="images/xiaohai.png">
                    </a>
                </div>
                <h2>
                    <a target="_blank" href="">看到新生儿口中露出的东西，医生吓了一跳!</a>
                </h2>
            </div>
            <div class="pic-txt clear " >
                <div class="pic img-do">
                    <a target="_blank" href="">
                        <img alt="" src="images/poxi.jpg" >
                    </a>
                </div>
                <h2>
                    <a target="_blank" href="">看到新生儿口中露出的东西，医生吓了一跳!</a>
                </h2>
            </div>
            <div class="pic-txt clear " >
                <div class="pic img-do">
                    <a target="_blank" href="">
                        <img alt="" src="images/yunfu.jpg" >
                    </a>
                </div>
                <h2>
                    <a target="_blank" href="">看到新生儿口中露出的东西，医生吓了一跳!</a>
                </h2>
            </div>
            <div class="pic-txt clear " >
                <div class="pic img-do">
                    <a target="_blank" href="">
                        <img alt="" src="images/shiyan.jpeg" >
                    </a>
                </div>
                <h2>
                    <a target="_blank" href="">看到新生儿口中露出的东西，医生吓了一跳!</a>
                </h2>
            </div>
            <div class="pic-txt clear " >
                <div class="pic img-do">
                    <a target="_blank" href="">
                        <img alt="" src="images/renren.jpeg" >
                    </a>
                </div>
                <h2>
                    <a target="_blank" href="">看到新生儿口中露出的东西，医生吓了一跳!</a>
                </h2>
            </div>
        </div>
        <div class='content-r fr'>
            <div class='content-hot content-ad'>
                广告---Ad
            </div>
        </div>
        <div class='content-r fr'>
            <div class='content-hot'>
                <span class="tt">24小时热文</span>
            </div>
        </div>
    </div>
@endsection