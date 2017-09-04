                <style type="text/css">
                    body .jiathis_style_32x32 .jiathis_button_cqq span{
                        background: url(/h5/image/QQ.png) no-repeat left;
                    }
                    body .jiathis_style_32x32 .jiathis_button_weixin span{
                        background: url(/h5/image/weiX.png) no-repeat left;   
                    }

                    body .jiathis_style_32x32 .jiathis_button_qzone span{
                        background: url(/h5/image/kongjian.png) no-repeat left; 
                    }
                    body .jiathis_style_32x32 .jtico{
                        height: 100px!important;
                        padding-left: 100px!important;
                    }
                    

                </style>
                <script type="text/javascript">
                                        
                        /****************分享start*******************/
                        $(function(){
                            $("#share").bind('click',function(event){
                            	$(".shareTo").css("display","block");
                            	$('body').css('overflow','hidden');
                            	
                            });
                                 			
                            $(".shareTo p").bind('click',function(event){
                                $(".shareTo").css("display","none");
                            });
                        });
                  </script>      
                        
<?php // 引入分享的js
/*****************分享start*************************/
?>
@include('layout.share')

<?php 
/*****************分享end*************************/
?>
            <!--分享start-->
                <div class="shareTo">
                            <ul class="picShare jiathis_style_32x32" >
                                    <li><a href="javascript:void(0)" class="jiathis_button_cqq"></a></li>
                                    <li><a href="javascript:void(0)" class="jiathis_button_weixin"></a></li>
                                    <li><a href="javascript:void(0)" class="jiathis_button_qzone"></a></li>
                            </ul>
                            <p>取消</p>
		</div>
            <!--分享end-->