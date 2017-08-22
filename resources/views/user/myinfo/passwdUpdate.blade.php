@extends('mainlayout')
@section('title')
    <title>个人后台</title>
    <meta name="keywords" content="北京搜房网，新房，二手房，租房，写字楼，商铺，金融，房产名人，房产名企，房产名词"/>
    <meta name="description" content="搜房网—中国房地产综合信息门户和交易平台，提供二手房、租房、别墅、写字楼、商铺等交易信息，为客户提供全面的搜房体验和多种比较、为业主和经纪人提供高效的信息推广渠道。为客户提供房产百科全书，包括房产名人，名词，名企，楼盘"/>
@endsection
@section('head')
    @include('user.myinfo.header')
@endsection
@section('content')

<div class="user">
@include('user.myinfo.leftNav')
     <div class="user_r">
       <h2 class="edit">修改密码</h2>
       <p class="colorfe xg" id="editPwd" style="display:none;"></p>
       <div class="change_pwd">
         <p>
           <label>原密码</label>
           <input type="password" name="oldpass" id="pwd1" class="txt"/>
         </p>
         <p>
           <label>新密码</label>
           <input type="password" name="newpass" id="pwd2" maxlength="16" class="txt"/>
         </p>
         <p>
           <label>确认密码</label>
           <input type="password" name="confirm" id="pwd3" maxlength="16" class="txt"/>
         </p>
         <?php //这里的点击行为，会根基ID调动myinfo.js中的相关函数   ?>
         <input type="button" id="sub_password" class="btn back_color" value="确定"/>
       </div>
     </div>

</div>
@include('user.myinfo.footer')
@endsection