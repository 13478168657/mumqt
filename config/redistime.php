<?php
/***
 * 下面是guanchanghu设置的一些redis缓存过期时间
 * 
 * indexOuttime     首页广告位推荐位缓存    一个小时
 * brokerListOuttime    经纪人列表          6个小时
 * brokerInfoOuttime           经纪人详情          缓存改为24小时
 * homeSearchOnlyOuttime     搜索框，在没用输入数据的时候调用    6个小时
 * **/
return [

    'indexOuttime'=>['outtime'=>3600,'library'=>6,],
    'PCModel2'      =>['outtime'=>60*60*24,'library'=>6,],
    'brokerListOuttime'=>['outtime'=>21600,'library'=>8,],
    'brokerInfoOuttime'=>['outtime'=>60*60*24,'library'=>7,],
    'homeSearchOnlyOuttime'=>['outtime'=>21600,'library'=>9,],
    'agentMobileOuttime'=>['outtime'=>3600,'library'=>9,],
    'brokerInfoConfig'  => ['brokerkey' =>'brokerHouseSum:','library'=>6],
];

