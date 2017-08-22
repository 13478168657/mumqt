<!DOCTYPE html>
<html>
    <head>
        <title>激活您在 搜房网 会员帐号的必要步骤!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>Hi！亲爱的{{$email}}
            <h1>
                请点击下面的链接完成激活：<a href="http://{{$_SERVER['HTTP_HOST']}}/active_email?bcode={{$code}}&email={{$_email}}">http://{{$_SERVER['HTTP_HOST']}}/active_email?bcode={{$code}}&email={{$_email}}</a>
                (该链接在60分钟内有效)
                <br>
                <a href="http://www.sofang.com.cn">返回搜房网首页</a>
            </h1>               
        </div>
    </body>
</html>
