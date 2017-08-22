@extends('h5.mainlayout')
@section('title')
 <title>【北京房地产门户|北京房地产网|北京房地产平台】 - 北京搜房网 网罗天下房</title>
<meta name="keywords"
	content="北京房产,北京房地产,买房,北京租房,业主社区,北京新房,北京二手房,北京写字楼,北京商铺,北京豪宅,北京别墅,理财,装修,家居,建材,家具,团购,房地产业内精英,中介服务
      " />
<meta name="description"
	content="北京搜房网是中国房地产综合网络平台，提供全面实时的房地产资讯内容，为广大网民提供专业的北京新房、北京二手房、北京租房、北京豪宅、北京别墅、北京写字楼、北京商铺等全方位海量资讯信息的品质搜房体验。为业主、客户及房地产业内精英们提供高效专业的信息推广及交易服务。并且为广大客户提供了房地产行业百科大全，可轻松获得业内名人，名词，名企及楼盘的相关信息数据。" />
@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="/h5/css/houselator.css"/>
@endsection
@section('content')
<header class="house_Lator">
    <div class="header_lf fl"><a href="javascript:window.history.go(-1)"></a></div>
    <h2>房贷计算器</h2>
  </header>
  <div class="space24"></div>
  <!--==================内容区域，获取数据开始==========================================-->
    <div class="wrapper">
    <div class="scroll-wrap content scroller ">
      <div class="content_box">
  <div id="house_loan" class="house_loan">
      <!--Nav-->
            <nav class="nav">
                <div  class="selected " name="#reckon">贷款计算器</div>
                <div name="#before_reckon" class="selecte">提前还贷计算器</div>
            </nav>
            <!--Left-->
            <div class="reckon" id="reckon">

                <form action="">
                     <!--表单计算区域开始 -->
                    <div class="cal">
                        <div class="title" style="margin-left:0px">计算条件</div>

                        <div class="field">
                                
                                <div class="type">
                                    <div class="name">贷款类型：</div>
                                    <span><input type="checkbox" name="type" value="1" />公积金贷款</span>
                                    <span><input type="checkbox" name="type" value="2" checked="checked" />商业贷款</span>
                                    <span><input type="checkbox" name="type" value="3" />组合贷款</span>
                                </div>

                                 <div class="count_type">
                                    <div class="name">计算方式：</div>
                                    <div class="area">
                                      <input type="checkbox" name="count_area" value="1" checked="checked"/>根据面积计算
                                    </div>
                                    <div class="count_area">
                                         <div>单价：<input type="text" class="yuan_price" /> 元/平米</div>
                                         <div>面积：<input type="text"  class="acreage" /> 平方米</div>
                                    </div>
                                    <div class="money_total"><input type="checkbox" name="count_money" value="1" />根据贷款总额计算</div>
                                    <div class="count_total">
                                        <div>贷款总额：<input type="text" class="total" /> 元</div>
                                     </div>
                                </div>
                                <div class="group_type">
                                         <div class="biz_rock">商业贷款数：<input type="text"  /> 元</div>
                                         <div class="nation_rock">公 积 &nbsp;金 数：<input type="text"  /> 元</div>
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
                                 <div class="rate_type fl">
                                    <div class="name rate">贷款利率：</div>
                                    <span class="rate_fl">利率类型：
                                        <select class="select_style style_rate" style="width:200px">
                                            <option value="32" >15年10月24日利率上限（1.1倍）</option>
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
                                    <span class="rate_fr fl"><input type="text" class="rate_percent"  value="4.9" />%</span>
                                 
                                </div>
                                <div class="compute_type fl">
                                    <div class="name">计算方式：</div>
                                     <span><input type="checkbox" name="compute_type" value="1" checked="checked"/>等额本息</span>
                                    <span><input type="checkbox" name="compute_type" value="2" />等额本金</span>
                                    <div class="reset">
                                      <input type="reset" class="back_color " value="重新填写">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!--表单计算区域结束 -->

                    <div class="compute">
                        <button class="back_color back_fr fl">开始计算</button>
                    </div>
                   
                   <!--表单计算结果开始 -->
                    <div class="result fl">
                        <div  class="title">计算结果</div>
                        <div  class="result_content">
                            <div class="money_total">
                                <div class="month_every"><p>月均还款</p><span class="num zero">0</span><em>元</em></div>
                                <div class="start_pay">首期付款：0万(0成)</div>
                                <div class="loan">贷款金额：0万(0成)</div>
                                <div class="interest">支付利息：0万元</div>
                            </div>
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
                            <div class="huan">还款类型：
                              <span class="gong"><input type="checkbox"  name="content" value="1" checked="checked" >公积金贷款
                                <input type="checkbox" name="content" value="2">商业贷款</span>
                            </div>
                            <div class="yuandai">原贷款金额：<span><input type="text" class="lei"></span> 万元</div>
                            <div class="yuanyear">原贷款年限：
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
                                 <!--   <select class="select_style2" style="width:200px">-->
                                              <select class="select_style style_rate" style="width:200px">
                                            <option value="32" >15年10月24日利率上限（1.1倍）</option>
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
                                    <!--</select>-->

                            </div>
                            <div class="shouci">首次还款时间：
                                  <select class="year1">
                                        <option value=1997>1997</option>
                                        <option value=1998>1998</option>
                                        <option value=1999>1999</option>
                                        <option value=2000>2000</option>
                                        <option value=2001>2001</option>
                                        <option value=2002>2002</option>
                                        <option value=2003>2003</option>
                                        <option value=2004>2004</option>
                                        <option value=2005>2005</option>
                                        <option value=2006>2006</option>
                                        <option value=2007>2007</option>
                                        <option value=2008>2008</option>
                                        <option value=2009>2009</option>
                                        <option value=2010>2010</option>
                                        <option value=2011>2011</option>
                                        <option value=2012>2012</option>
                                        <option value=2013>2013</option>
                                        <option value=2014>2014</option>
                                        <option value=2015>2015</option>
                                        <option value=2016 selected>2016</option>
                                  </select> 年
                                  <select class="month1">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4"  selected>4</option>
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
                                  <option value="2013">2013</option><
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
                                 <span class="only"> <input type="checkbox" name="before_function" value="1" checked="checked">一次提前还清
                                  <input type="checkbox" name="before_function"   value="2">部分还款<input type="text" class="part"> 万元</span>

                            </div>
                            <div class="chuli">处理方式：
                                  <span class="mode"><input type="checkbox" name="process" value="1" checked="checked">缩短还款期限，月还款额度不变
                                  <input type="checkbox" name="process" value="2">减少月额度，还款期限不变</span>

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
                        <div  class="title tit_fl">计算结果</div>
                        
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
    <div>
    </div>
    </div>
    <!--==================内容区域，获取数据开始==========================================-->
<script tye="text/javascript" src="/h5/js/common/Chart.js"></script>
	<script type="text/javascript" src="/h5/js/common/lilv.js"></script>
	<script type="text/javascript" src="/h5/js/common/house_loan.js"></script>
	<script type="text/javascript" src="/h5/js/common/before_reckon.js"></script>
	<script type="text/javascript" src="/h5/js/common/buy_engine.js"></script>
	<script>
	var doughnutData = [
        {
          value: 300,
          color:"#35c605",
          highlight: "#35c605",
          label: "贷款金额"
        },
        {
          value: 50,
          color: "#ff4e00",
          highlight: "#ff4e00",
          label: "首付"
        },
        {
          value: 100,
          color: "#3281f6",
          highlight: "#3281f6",
          label: "支付利息"
        },
      ];
      $('#prompt').remove();
</script>
@endsection
