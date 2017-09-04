@extends('mainlayout')
@section('title')
    <title>房贷计算器</title>
    <meta name="keywords" content="北京搜房网 房地产交易平台 租房 买房来搜房网"/>
    <meta name="description" content="搜房网—中国房地产综合信息门户和交易平台，提供二手房、租房、别墅、写字楼、商铺等交易信息，为客户提供全面的搜房体验和多种比较、为业主和经纪人提供高效的信息推广渠道。"/>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script type="text/javascript" src="/js/jquery1.11.3.min.js?v={{Config::get('app.version')}}"></script>
    <link rel="stylesheet" type="text/css" href="/css/house_loan.css?v={{Config::get('app.version')}}">
    <script src="/js/list.js?v={{Config::get('app.version')}}"></script>
@endsection
@section('content')
<!--
<div class="header">
 <div class="catalog_nav" id="catalog_nav">
  <div class="list_sub">
     <div class="list_search">
      <form action="" id="searchHouse" method="">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="text" class="txt border_blue" placeholder="请输入关键字（楼盘名/地名/等）">
        <input type="button" style="cursor:pointer;" onclick="_submit()" class="btn back_color" value="查小区"><!-- onclick="$('#searchHouse').submit();"-->
<!--
      </form>
      </div>
  </div>
 </div>
</div>
-->
    <div class="catalog_nav no_float">
        <div class="margin_auto clearfix">
            <div class="list_sub">
                <div class="list_search">
                    <input type="text" class="txt border_blue" tp="saleesb" AutoComplete="off" placeholder="请输入关键字（楼盘名/地名等）" value="" id="keyword">
                   <div class="mai mai1"></div>
                    <input type="button" class="btn back_color keybtn" value="搜房">
                </div>
            </div>
        </div>
    </div>
<input type="hidden" value="{{ csrf_token() }}" name="_token" id='token'>
<input type="hidden" id="linkurl"  value="/saleesb/area" >
<input type="hidden" id="par"  value="" >
<p class="route">
  <span>您的位置：</span>
  <a href="/">首页</a>
  <span>&nbsp;>&nbsp;</span>
  <a href="javascript:void(0)" class="colorfe">{{CURRENT_CITYNAME}}房贷计算器</a>
</p>
    <div id="house_loan">

            <div class="nav">
                <div  class="selected" name="#reckon">贷款计算器</div>
                <div name="#before_reckon">提前还贷计算器</div>
            </div>

            <!--计算中间区域 -->

            <div class="reckon" id="reckon">

                <form action="">
                     <!--表单计算区域开始 -->
                    <div class="cal">
                        <div class="title" style="margin-left:0px">计算条件</div>

                        <div class="field">
                                
                                <div class="type">
                                    <div class="name">贷款类型：</div>
                                     <span><input type="radio" name="type" value="1" />公积金贷款</span>
                                    <span><input type="radio" name="type" value="2" checked="checked" />商业贷款</span>
                                    <span><input type="radio" name="type" value="3" />组合贷款</span>

                                </div>

                                 <div class="count_type">
                                    <div class="name">计算方式：</div>
                                     <div class="area"><input type="radio" name="count_area" value="1"  checked />根据面积计算</div>

                                     <div class="count_area">
                                         <div>单价：<input type="text" class="yuan_price" /> 元/平米</div>
                                         <div>面积：<input type="text"  class="acreage" /> 平方米</div>

                                     </div>
                                    <div class="money_total"><input type="radio" name="count_money" value="1" />根据房款总额计算</div>
                                    <div class="count_total">
                                        <div>房款总额：<input type="text" class="total" /> 元</div>
                                     </div>
                                </div>

                                <div class="group_type">
                                         <div class="biz_rock">商业贷款数：<input type="text"  /> 元</div>
                                         <div class="nation_rock">公 积 金 数：<input type="text"  /> 元</div>
                                </div>

                                 <div class="mortgage_type">
                                    <div class="name">按揭方式：</div>
                                     <div>按揭成数：
                                        <select class="select_style">
                                            <option value="9">9成</option>
                                            <option  value="8">8成</option>
                                            <option  value="7">7成</option>
                                            <option  value="6">6成</option>
                                            <option  value="5">5成</option>
                                            <option  value="4">4成</option>
                                            <option  value="3">3成</option>
                                            <option  value="2">2成</option>
                                            <option  value="1">1成</option>
                                        </select>
                                    </div>
                                    <div class="year">按揭年数：
                                        <select class="select_style">
                                              <option value="0.5">6个月(6期)</option>
                                              <option value="1">1年(12期)</option>
                                              <option value="2">2年(24期)</option>
                                              <option value="3">3年(36期)</option>
                                              <option value="4">4年(48期)</option>
                                              <option value="5">5年(60期)</option>
                                              <option value="6">6年(72期)</option>
                                              <option value="7">7年(84期)</option>
                                              <option value="8">8年(96期)</option>
                                              <option value="9">9年(108期)</option>
                                              <option value="10">10年(120期)</option>
                                              <option value="11">11年(132期)</option>
                                              <option value="12">12年(144期)</option>
                                              <option value="13">13年(156期)</option>
                                              <option value="14">14年(168期)</option>
                                              <option value="15">15年(180期)</option>
                                              <option value="16">16年(192期)</option>
                                              <option value="17">17年(204期)</option>
                                              <option value="18">18年(216期)</option>
                                              <option value="19">19年(228期)</option>
                                              <option value="20" selected="selected">20年(240期)</option>
                                              <option value="21">21年(252期)</option>
                                              <option value="22">22年(264期)</option>
                                              <option value="23">23年(276期)</option>
                                              <option value="24">24年(288期)</option>
                                              <option value="25">25年(300期)</option>
                                              <option value="26">26年(312期)</option>
                                              <option value="27">27年(324期)</option>
                                              <option value="28">28年(336期)</option>
                                              <option value="29">29年(348期)</option>
                                              <option value="30">30年(360期)</option>
                                        </select>
                                    </div>
                                   

                                </div>
                                 <div class="rate_type">
                                    <div class="name">贷款利率：</div>
                                     <span>利率类型：
                                        <select class="select_style" style="width:200px">
                                             <option value="35" >15年10月24日利率上限（1.1倍）</option>
                                              <option value="34" >15年10月24日利率下限（95折）</option>
                                              <option value="33" >15年10月24日利率下限（9折）</option>
                                              <option value="32" >15年10月24日利率下限（88折）</option>
                                              <option value="31" >15年10月24日利率下限（85折）</option>
                                              <option value="30" >15年10月24日利率下限（7折）</option>
                                              <option value="29" selected="selected">15年10月24日基准利率</option>
                                              <option value="28" >15年8月26日利率上限（1.1倍）</option>
                                              <option value="27" >15年8月26日利率下限（85折）</option>
                                              <option value="26" >15年8月26日利率下限（7折）</option>
                                              <option value="25" >15年8月26日基准利率</option>
                                              <option value="24" >15年6月28日利率上限（1.1倍）</option>
                                              <option value="23" >15年6月28日利率下限（85折）</option>
                                              <option value="22" >15年6月28日利率下限（7折）</option>
                                              <option value="21" >15年6月28日基准利率</option>
                                              <option value="20" >15年5月11日利率上限（1.1倍）</option>
                                              <option value="19" >15年5月11日利率下限（85折）</option>
                                              <option value="18" >15年5月11日利率下限（7折）</option>
                                              <option value="17" >15年5月11日基准利率</option>
                                              <option value="16" >15年3月1日利率上限（1.1倍）</option>
                                              <option value="15" >15年3月1日利率下限（85折）</option>
                                              <option value="14" >15年3月1日利率下限（7折）</option>
                                              <option value="13" >15年3月1日基准利率</option>
                                              <option value="12" >14年11月22日利率上限（1.1倍）</option>
                                              <option value="11" >14年11月22日利率下限（85折）</option>
                                              <option value="10" >14年11月22日利率下限（7折）</option>
                                              <option value="9" >14年11月22日基准利率</option>
                                              <option value="8" >12年7月6日利率上限（1.1倍）</option>
                                              <option value="7" >12年7月6日利率下限（85折）</option>
                                              <option value="6" >12年7月6日利率下限（7折）</option>
                                              <option value="5" >12年7月6日基准利率</option>
                                              <option value="4" >12年6月8日利率上限（1.1倍）</option>
                                              <option value="3" >12年6月8日利率下限（85折）</option>
                                              <option value="2" >12年6月8日利率下限（7折）</option>
                                              <option value="1" >12年6月8日基准利率</option>

                                        </select>
                                    </span>
                                    <span><input type="text" class="rate_percent"  value="4.9" />%</span>
                                    

                                </div>

                                <div class="compute_type">
                                    <div class="name">计算方式：</div>
                                     <span><input type="radio" name="compute_type" checked="checked" value="1" />等额本息</span>
                                    <span><input type="radio" name="compute_type" value="2" />等额本金</span>
                                    <div class="reset">
                                      <input type="reset" class="back_color" value="重新填写">
                                    </div>
                                </div>

                                
                                    
                                   

                        
                        </div>
                    </div>
                    <!--表单计算区域结束 -->

                    <div class="compute">
                        <input type="button" class="js back_color" value="开始计算">
                    </div>
                   
                   <!--表单计算结果开始 -->
                    <div class="result">
                        <div  class="title">计算结果</div>
                        <div  class="result_content">
                            <div class="money_total">
                                <div class="month_every">月均还款<span class="num">0</span>元</div>
                                <div class="month_end" style="display:none">首月还款<span class="num">0</span>元 <img src="/image/jt.png" class="jt" /> 末月还款<span class="num_end">0</span>元</div>
                                <div class="start_pay">首期付款：0万(0成)</div>
                                <div class="loan">贷款金额：0万(0成)</div>
                                <div class="interest">支付利息：0万元</div>
                            </div>
                            <div id="canvas-holder" class="pic_total">
                                <canvas id="chart-area" width="500" height="500"/>
                            </div>
                            <!--
                            <div class="pic_total">
                                <div>估算总价约：0万</div>
                            </div>
                            -->

                        </div>

                         <div class="anotice"><span class="red">*</span>以上计算结果仅供参考</div>

                    </div>
                    <!--表单计算结果结束 -->

                </form>
            </div>
             <!--计算中间区域结束 -->

             <!--提前还贷计算器开始 -->
             <div id="before_reckon">
                     <form action="">
                     <!--表单计算区域开始 -->
                    <div class="cal">
                        <div class="title" style="margin-left:0px">计算条件</div>

                        <div class="field_two">
                            <div class="huan">还款类型：<span class="gong margin_left"><input type="radio"  name="content" checked value="1" >公积金贷款</span>
                                           <span class="gong"><input type="radio" name="content" value="2">商业贷款</span>
                            
                            </div>
                            <div class="yuandai">原贷款金额：<span><input type="text" class="lei"></span> 万元</div>
                            <div class="yuanyear">原贷款年限:
                                  <span><select class="select_style1">
                                              <option value="0.5">6个月(6期)</option>
                                              <option value="1">1年(12期)</option>
                                              <option value="2">2年(24期)</option>
                                              <option value="3">3年(36期)</option>
                                              <option value="4">4年(48期)</option>
                                              <option value="5">5年(60期)</option>
                                              <option value="6">6年(72期)</option>
                                              <option value="7">7年(84期)</option>
                                              <option value="8">8年(96期)</option>
                                              <option value="9">9年(108期)</option>
                                              <option value="10">10年(120期)</option>
                                              <option value="11">11年(132期)</option>
                                              <option value="12">12年(144期)</option>
                                              <option value="13">13年(156期)</option>
                                              <option value="14">14年(168期)</option>
                                              <option value="15">15年(180期)</option>
                                              <option value="16">16年(192期)</option>
                                              <option value="17">17年(204期)</option>
                                              <option value="18">18年(216期)</option>
                                              <option value="19">19年(228期)</option>
                                              <option value="20" selected="selected">20年(240期)</option>
                                              <option value="21">21年(252期)</option>
                                              <option value="22">22年(264期)</option>
                                              <option value="23">23年(276期)</option>
                                              <option value="24">24年(288期)</option>
                                              <option value="25">25年(300期)</option>
                                              <option value="26">26年(312期)</option>
                                              <option value="27">27年(324期)</option>
                                              <option value="28">28年(336期)</option>
                                              <option value="29">29年(348期)</option>
                                              <option value="30">30年(360期)</option>
                                        </select>
                                      </span>  
                            </div>
                            <div class="daili">贷款利率：
                                    <select class="select_style2" style="width:200px">
                                              <option value="35" >15年10月24日利率上限（1.1倍）</option>
                                              <option value="34" >15年10月24日利率下限（95折）</option>
                                              <option value="33" >15年10月24日利率下限（9折）</option>
                                              <option value="32" >15年10月24日利率下限（88折）</option>
                                              <option value="31" >15年10月24日利率下限（85折）</option>
                                              <option value="30" >15年10月24日利率下限（7折）</option>
                                              <option value="29" selected="selected">15年10月24日基准利率</option>
                                              <option value="28" >15年8月26日利率上限（1.1倍）</option>
                                              <option value="27" >15年8月26日利率下限（85折）</option>
                                              <option value="26" >15年8月26日利率下限（7折）</option>
                                              <option value="25" >15年8月26日基准利率</option>
                                              <option value="24" >15年6月28日利率上限（1.1倍）</option>
                                              <option value="23" >15年6月28日利率下限（85折）</option>
                                              <option value="22" >15年6月28日利率下限（7折）</option>
                                              <option value="21" >15年6月28日基准利率</option>
                                              <option value="20" >15年5月11日利率上限（1.1倍）</option>
                                              <option value="19" >15年5月11日利率下限（85折）</option>
                                              <option value="18" >15年5月11日利率下限（7折）</option>
                                              <option value="17" >15年5月11日基准利率</option>
                                              <option value="16" >15年3月1日利率上限（1.1倍）</option>
                                              <option value="15" >15年3月1日利率下限（85折）</option>
                                              <option value="14" >15年3月1日利率下限（7折）</option>
                                              <option value="13" >15年3月1日基准利率</option>
                                              <option value="12" >14年11月22日利率上限（1.1倍）</option>
                                              <option value="11" >14年11月22日利率下限（85折）</option>
                                              <option value="10" >14年11月22日利率下限（7折）</option>
                                              <option value="9" >14年11月22日基准利率</option>
                                              <option value="8" >12年7月6日利率上限（1.1倍）</option>
                                              <option value="7" >12年7月6日利率下限（85折）</option>
                                              <option value="6" >12年7月6日利率下限（7折）</option>
                                              <option value="5" >12年7月6日基准利率</option>
                                              <option value="4" >12年6月8日利率上限（1.1倍）</option>
                                              <option value="3" >12年6月8日利率下限（85折）</option>
                                              <option value="2" >12年6月8日利率下限（7折）</option>
                                              <option value="1" >12年6月8日基准利率</option>
                                    </select>

                            </div>
                            <div class="shouci">首次还款时间：
                                  <select class="year1">
                                        <OPTION value=1997>1997</OPTION>
                                        <OPTION value=1998>1998</OPTION>
                                        <OPTION value=1999>1999</OPTION>
                                        <OPTION value=2000>2000</OPTION>
                                        <OPTION value=2001>2001</OPTION>
                                        <OPTION value=2002>2002</OPTION>
                                        <OPTION value=2003>2003</OPTION>
                                        <OPTION value=2004>2004</OPTION>
                                        <OPTION value=2005>2005</OPTION>
                                        <OPTION value=2006>2006</OPTION>
                                        <OPTION value=2007>2007</OPTION>
                                        <OPTION value=2008>2008</OPTION>
                                        <OPTION value=2009>2009</OPTION>
                                        <OPTION value=2010>2010</OPTION>
                                        <OPTION value=2011>2011</OPTION>
                                        <OPTION value=2012>2012</OPTION>
                                        <OPTION value=2013>2013</OPTION>
                                        <OPTION value=2014>2014</OPTION>
                                        <OPTION value=2015>2015</OPTION>
                                        <OPTION value=2016 selected>2016</OPTION>
                                  </select> 年
                                  <select class="month1">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4" selected>4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                  </select> 月
                            </div>
                            <div class="yuji">预计提前还款：
                                  <select name="tqhksjn" class="year2">
                                  <option value="2008">2008</option>
                                  <option value="2009">2009</option>
                                  <option value="2010">2010</option>
                                  <option value="2011">2011</option>
                                  <option value="2012">2012</option>
                                  <option value="2013">2013</option>
                                  <option value="2014">2014</option>
                                  <option value="2015">2015</option>
                                  <option value="2016" selected>2016</option>
                                  <option value="2017">2017</option>
                                  <option value="2018">2018</option>
                                  <option value="2019">2019</option>
                                  <option value="2020">2020</option>
                                  <option value="2021">2021</option>
                                  <option value="2022">2022</option>
                                  <option value="2023">2023</option>
                                  <option value="2024">2024</option>
                                  <option value="2025">2025</option>
                                  <option value="2026">2026</option>
                                  <option value="2027">2027</option>
                                  <option value="2028">2028</option>
                                  <option value="2029">2029</option>
                                  <option value="2030">2030</option>
                                  <option value="2031">2031</option>
                                  <option value="2032">2032</option>
                                  <option value="2033">2033</option>
                                  <option value="2034">2034</option>
                                  <option value="2035">2035</option>
                                  <option value="2036">2036</option>
                                  <option value="2037">2037</option>
                                  <option value="2038">2038</option>
                                  <option value="2039">2039</option>
                                  <option value="2040">2040</option>
                                  <option value="2041">2041</option>
                                  <option value="2042">2042</option>
                                  <option value="2043">2043</option>
                                  <option value="2044">2044</option>
                                  <option value="2045">2045</option>
                                  </select> 年
                                  <select class="month2">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4" selected>4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                  </select> 月
                            </div>
                            <div class="tiqian">提前还款方式：
                                 <span class="only">
                                  <span><input type="radio" name="before_function" checked value="1">一次提前还清</span>
                                  <span><input type="radio" name="before_function" value="2">部分还款<input type="text" class="part"> 万元</span></span>

                            </div>
                            <div class="chuli">处理方式：
                                  <span class="mode">
                                  <span class="margin_r"><input type="radio" name="process" value="1" checked>缩短还款期限，月还款额度不变</span>
                                  <span><input type="radio" name="process" value="2">减少月额度，还款期限不变</span></span>

                            </div>
                            <div class="reset1">
                                      <input type="reset" class="back_color" value="重新填写">
                            </div>

                        </div>


 
                                

                        
                    </div>
                    <!--表单计算区域结束 -->

                     <div class="comp">
                        <button class="back_color">开始计算</button>
                    </div>
                   
                  
                    <div class="result">
                        <div  class="title">计算结果</div>
                        
                        <div  class="result_co">
                            <div class="mon">原月还款额：<span class="dan"><input type="text" ></span>  元</div>
                            <div class="day">最后还款日期：<span class="end_time"><input type="text" ></span></div>
                            <div class="yihuan">已还款总额：<span class="zong"><input type="text" ></span> 元</div>
                            <div class="yihuan">已还利息额：<span class="finsih_lixi"><input type="text" ></span> 元</div>
                            <div class="one">该月一次还款额：<span class="gaiyue"><input type="text" ></span> 元</div>
                            <div class="jie">节省利息支出：<span class="jieyue"><input type="text" ></span> 元</div>
                            <div class="new">新的最后还款日期：<span class="new_time"><input type="text" ></span></div>
                            
                            <div class="an"><span class="red">*</span>以上计算结果仅供参考</div>
                        </div>

                       
                    </div>
                  

                </form>
            </div>
            <!-- 提前还贷计算器结束-->

    </div>
<script src="/js/chart/Chart.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/lilv.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/house_loan.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/before_reckon.js?v={{Config::get('app.version')}}"></script>
<script type="text/javascript" src="/js/buy_engine.js?v={{Config::get('app.version')}}"></script>
<script>
var doughnutData = [
        {
          value: 0,
          color:"#35c605",
          highlight: "#35c605",
          label: "贷款金额"
        },
        {
          value: 0,
          color: "#ff4e00",
          highlight: "#ff4e00",
          label: "首付"
        },
        {
          value: 0,
          color: "#3281f6",
          highlight: "#3281f6",
          label: "支付利息"
        },
      

      ];

      window.onload = function(){
        var ctx = document.getElementById("chart-area"); 
		var context = ctx.getContext('2d'); 
        window.myDoughnut = new Chart(context).Doughnut(doughnutData, {responsive : true});
      };



      $('#prompt').remove();
</script>
</body>
</html>
@endsection
