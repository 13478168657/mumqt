@extends('layout.layout')
@section('title')
    <title>afafa</title>
@endsection
@section('css')
<link rel="stylesheet" href="/css/index.css" />
@endsection
        <!--top-banner部分end-->
@include('layout.header')
        <!--content-start-->
        <!--nav--start-->
@include('layout.nav')
        <!--nav--end-->
@section('content')
    <!--banner-start-->
    <div class='w clearfix'>
        <div class="fl banner-fl">
            <div class='banner'>
                <img src='images/banner.jpg' alt=''>
            </div>
            <div class='banner-ad'>
                <img class='banner-ad-l' src='images/banner-ad.jpg' alt=''>
                <img class='banner-ad-r' src='images/banner-ad-1.jpg' alt=''>
            </div>
        </div>
        <div class='fl banner-fr'>
            <img src='images/hot.png' alt=''>
            <a href='/article/list/1' target="_blank">[往日回顾]</a>
            <ul class="news">
                @foreach($articles as $k=>$article)
                <li class="no{{$k+1}}" >
                    <h3><a target="_blank"  href="/article/detail/{{$article->id}}">{{$article->title}}</a></h3>
                    <p class="desc"><a target="_blank"  href="#">{{$article->describe}}</a></p>
                    <p class="key">相关阅读:
                        <a target="_blank" href="#">宝宝才艺启蒙</a>
                        <a target="_blank" href="#">激发宝宝艺术潜能</a>
                    </p>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class='w centent clearfix'>
        <div class='centent-t content-a'>
            <div class='fl content-t-l'><h2><strong>1F 准备备孕</strong><h2></div>
            <div class='fr content-t-r'>
                <ul>
                    <li class='content-t-r-a'><a href='#' target="_blank">备孕知识</a></li>
                    <li><a href='#' target="_blank">备孕注意事项</a></li>
                    <li><a href='#' target="_blank">备孕吃什么</a></li>
                    <li><a href='#' target="_blank">备孕成功经验</a></li>
                </ul>
            </div>
        </div>
        <div class='fl content-l'>
            <div class='fl content-l-img'>
                <img src='images/centent1.png' alt=''>
            </div>
            <div class='fr content-l-title'>
                <ul class="news">
                    <li class="no1" >
                        <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        <p class="desc"><a target="_blank"  href="#">父母大多希望自己的孩子能成为人中龙凤，害怕他们输在起跑线上，于是，似乎早...</a></p>

                    </li>
                    <li class="no2" >
                        <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        <p class="desc"><a target="_blank"  href="#"> 		有的人是先见红，有的人是先破羊水，具体也是因人而异的，但是肚子都会微微...</a>
                        </p>
                    </li>
                    <li class="no3 " >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                    <li class="no3 no" >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>

                </ul>
            </div>
        </div>
        <div class='fr content-r'>
            <div class='content-r-top clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu.jpg' alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">高校教师10年写出近千条暖心日志记录学生成长</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class='content-r-bottom clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu-1.jpg' alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class='w centent clearfix'>
        <div class='centent-t content-b'>
            <div class='fl content-t-l'><h2><strong>2F 坐月子</strong><h2></div>
            <div class='fr content-t-r content-color-a'>
                <ul>
                    <li class='content-t-r-a'><a href='#' target="_blank">坐月子注意事项</a></li>
                    <li><a href='#' target="_blank">坐月子食谱</a></li>
                    <li><a href='#' target="_blank">坐月子吃什么好</a></li>

                </ul>
            </div>
        </div>
        <div class='fl content-l'>
            <div class='fl content-l-img'>
                <img src='images/centent2.png' alt=''>
            </div>
            <div class='fr content-l-title'>
                <ul class="news">
                    <li class="no1" >
                        <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        <p class="desc"><a target="_blank"  href="#">父母大多希望自己的孩子能成为人中龙凤，害怕他们输在起跑线上，于是，似乎早...</a></p>
                    </li>
                    <li class="no2" >
                        <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        <p class="desc"><a target="_blank"  href="#"> 		有的人是先见红，有的人是先破羊水，具体也是因人而异的，但是肚子都会微微...</a></p>
                    </li>
                    <li class="no3 " >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                    <li class="no3 no" >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>

                </ul>
            </div>
        </div>
        <div class='fr content-r'>
            <div class='content-r-top clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu.jpg' alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">高校教师10年写出近千条暖心日志记录学生成长</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class='content-r-bottom clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu-1.jpg' alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class='w centent clearfix'>
        <div class='centent-t content-c'>
            <div class='fl content-t-l'><h2><strong>3F 产后护理</strong><h2></div>
            <div class='fr content-t-r content-color-b'>
                <ul>
                    <li class='content-t-r-b'><a href='#' target="_blank">产后恢复</a></li>
                    <li><a href='#' target="_blank">产后同房</a></li>
                    <li><a href='#' target="_blank">产后减肥</a></li>
                    <li><a href='#' target="_blank">产后瑜伽</a></li>
                    <li><a href='#' target="_blank">产后抑郁症</a></li>
                </ul>
            </div>
        </div>
        <div class='fl content-l'>
            <div class='fl content-l-img'>
                <img src='images/centent3.png'  alt=''>
            </div>
            <div class='fr content-l-title'>
                <ul class="news">
                    <li class="no1" >
                        <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        <p class="desc"><a target="_blank"  href="#">父母大多希望自己的孩子能成为人中龙凤，害怕他们输在起跑线上，于是，似乎早...</a></p>
                    </li>
                    <li class="no2" >
                        <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        <p class="desc"><a target="_blank"  href="#"> 		有的人是先见红，有的人是先破羊水，具体也是因人而异的，但是肚子都会微微...</a></p>
                    </li>
                    <li class="no3 " >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                    <li class="no3 no" >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class='fr content-r'>
            <div class='content-r-top clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu.jpg'  alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">高校教师10年写出近千条暖心日志记录学生成长</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class='content-r-bottom clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu-1.jpg'  alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class='w centent clearfix'>
        <div class='centent-t content-d'>
            <div class='fl content-t-l'><h2><strong>4F 科学哺育</strong><h2></div>
            <div class='fr content-t-r content-color-c'>
                <ul>
                    <li class='content-t-r-c'><a href='#' target="_blank">催乳</a></li>
                    <li><a href='#' target="_blank">母乳喂养</a></li>
                    <li><a href='#' target="_blank">断奶</a></li>
                    <li><a href='#' target="_blank">混合喂养</a></li>
                    <li><a href='#' target="_blank">催乳食谱</a></li>
                </ul>
            </div>
        </div>
        <div class='fl content-l'>
            <div class='fl content-l-img'>
                <img src='images/centent4.png'  alt='' >
            </div>
            <div class='fr content-l-title'>
                <ul class="news">
                    <li class="no1" >
                        <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        <p class="desc"><a target="_blank"  href="#">父母大多希望自己的孩子能成为人中龙凤，害怕他们输在起跑线上，于是，似乎早...</a></p>
                    </li>
                    <li class="no2" >
                        <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        <p class="desc"><a target="_blank"  href="#"> 		有的人是先见红，有的人是先破羊水，具体也是因人而异的，但是肚子都会微微...</a></p>
                    </li>
                    <li class="no3 " >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                    <li class="no3 no" >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class='fr content-r'>
            <div class='content-r-top clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu.jpg'  alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">高校教师10年写出近千条暖心日志记录学生成长</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class='content-r-bottom clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu-1.jpg'  alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class='w centent clearfix'>
        <div class='centent-t content-e'>
            <div class='fl content-t-l'><h2><strong>5F 婴幼健康</strong><h2></div>
            <div class='fr content-t-r content-color-d'>
                <ul>
                    <li class='content-t-r-d'><a href='#' target="_blank">婴儿睡眠</a></li>
                    <li><a href='#' target="_blank">婴儿护理</a></li>
                    <li><a href='#' target="_blank">儿童安全</a></li>
                    <li><a href='#' target="_blank">成长发育</a></li>
                </ul>
            </div>
        </div>
        <div class='fl content-l'>
            <div class='fl content-l-img'>
                <img src='images/centent.png'  alt=''>
            </div>
            <div class='fr content-l-title'>
                <ul class="news">
                    <li class="no1" >
                        <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        <p class="desc"><a target="_blank"  href="#">父母大多希望自己的孩子能成为人中龙凤，害怕他们输在起跑线上，于是，似乎早...</a></p>
                    </li>
                    <li class="no2" >
                        <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        <p class="desc"><a target="_blank"  href="#"> 		有的人是先见红，有的人是先破羊水，具体也是因人而异的，但是肚子都会微微...</a></p>
                    </li>
                    <li class="no3 " >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                    <li class="no3 no" >
                        <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        <p class="desc"><a target="_blank"  href="#">头胎的我完全没经验，内分泌失调、几个月才来一次月经让我觉得自己很难怀孕而...</a></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class='fr content-r'>
            <div class='content-r-top clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu.jpg'  alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">高校教师10年写出近千条暖心日志记录学生成长</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class='content-r-bottom clearfix'>
                <div class='fl content-r-top-l'><img src='images/jiaoyu-1.jpg'  alt=''></div>
                <div class='fl content-r-top-r'>
                    <ul class="news" >
                        <li class="no1" >
                            <h3><a target="_blank"  href="#">教你几招，轻松提防早教机构的忽悠</a></h3>
                        </li>
                        <li class="no2" >
                            <h3><a target="_blank"  href="#">临产妈咪别紧张，征兆有规律可循！</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 " >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                        <li class="no3 no" >
                            <h3><a target="_blank"  href="#">5分钟通过NT，提前做这4件事你也行</a></h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class=' centent clearfix' >
        <div class='w  centent-t content-f'>
            <div class='fl content-t-l'><h2><strong>6F 月子餐</strong><h2></div>
            <div class='fr content-t-r content-color-e'>
                <ul>
                    <li class='content-t-r-e'><a href='#' target="_blank">月子餐</a></li>
                    <li><a href='#' target="_blank">月子餐30天食谱</a></li>
                    <li><a href='#' target="_blank">坐月子食谱</a></li>
                    <li><a href='#' target="_blank">坐月子可以吃什么水果</a></li>
                </ul>
            </div>
        </div>
        <div class='w food'>
            <div class='food-w clearfix'>
                <div class="ztlist_style1_item">
                    <ul class="ztlist_style1_item_list clearfix">
                        <li class="current clearfix">
                            <div class="topzt">
                                <a target="_blank" href="" class="img"><img src="./images/meishi.jpg"  alt=''><span class="fixer"></span></a>
                                <div class="c">
                                    <strong class="title"><a target="_blank" href="">吃面姿势不正确引发糖尿病</a></strong>
                                    <p>营养师总结六大实用健康吃面技巧！</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="ztlist_style1_item">
                    <ul class="ztlist_style1_item_list clearfix">
                        <li class="current clearfix">
                            <div class="topzt">
                                <a target="_blank" href="" class="img"><img src="./images/meishi.jpg"  alt=''><span class="fixer"></span></a>
                                <div class="c">
                                    <strong class="title"><a target="_blank" href="">鸡翅鸡腿巧去骨</a></strong>
                                    <p>吃肉不吐骨头才痛快！</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="ztlist_style1_item mr0">
                    <ul class="ztlist_style1_item_list clearfix">
                        <li class="current clearfix">
                            <div class="topzt">
                                <a target="_blank" href="" class="img"><img src="./images/meishi.jpg"  alt=''><span class="fixer"></span></a>
                                <div class="c">
                                    <strong class="title"><a target="_blank" href="">吃年糕，年年高</a></strong>
                                    <p>春节吃年糕，这样做最好！</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="ztlist_style1_item mb0">
                    <ul class="ztlist_style1_item_list clearfix">
                        <li class="current clearfix">
                            <div class="topzt">
                                <a target="_blank" href="" class="img"><img src="./images/meishi.jpg"  alt=''><span class="fixer"></span></a>
                                <div class="c">
                                    <strong class="title"><a target="_blank" href="">美食达人版块全新改版</a></strong>
                                    <p>更多好文好友好福利如期而至</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="ztlist_style1_item mb0">
                    <ul class="ztlist_style1_item_list clearfix">
                        <li class="current clearfix">
                            <div class="topzt">
                                <a target="_blank" href="" class="img"><img src="./images/meishi.jpg"  alt=''><span class="fixer"></span></a>
                                <div class="c">
                                    <strong class="title"><a target="_blank" href="">如何做一顿好吃的饺子</a></strong>
                                    <p>冬至饺子这样做，全家人都抢着吃</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="ztlist_style1_item mr0 mb0">
                    <ul class="ztlist_style1_item_list clearfix">
                        <li class="current clearfix">
                            <div class="topzt">
                                <a target="_blank" href="" class="img"><img src="./images/meishi.jpg"  alt=''><span class="fixer"></span></a>
                                <div class="c">
                                    <strong class="title"><a target="_blank" href="">猪肉这么做</a></strong>
                                    <p>鼻子都香掉</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection