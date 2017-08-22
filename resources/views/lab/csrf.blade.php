<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="/js/jquery-2.1.4.min.js?v={{Config::get('app.version')}}"></script>
    </head>
    <body>
        <div>Just a test page!</div>
        <div><input type="button" value="submit" id="btn"></div>
        <div id="result"></div>
    </body>    
    <script>
        $(function(){
            $("#btn").bind('click',function(){                
                var url = '/lab/csrf/getParam';
                var data = {
                    _token:'{{csrf_token()}}',
                    v1 : 'test',
                    v2 : 'v983'
                };                
                $.post(url,data,function(r){
                    $("#result").html(r);
                });
            });
        });
    </script>
</html>
