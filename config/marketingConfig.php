<?php
return array(
    //付费前默认数量
    'beforeBuy'=>array('dayPublishSaleCount'=>20,'dayPublishRentCount'=>20,'dayPublishBusinessCount'=>20,'canPublishCount'=>120, 'dayRefreshManualCount'=>50),
    //付费后对应字段增加数量(dayPublishSaleCount,dayPublishRentCount,dayPublishBusinessCount),公用的直接更新字段(canPublishCount,dayRefreshManualCount)
    'afterBuy'=>array('dayPublishSaleCount'=>20,'dayPublishRentCount'=>20,'dayPublishBusinessCount'=>20,'canPublishCount'=>120, 'dayRefreshManualCount'=>100)
);
