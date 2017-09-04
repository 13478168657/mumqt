<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
        <meta name="sogou_site_verification" content="ojP49dO3yi"/>
        <meta name="360-site-verification" content="1524c7d232ff39b8b441133fe660d306" />
        <link rel="icon" href="http://www.sofang.com/favicon.ico" mce_href="http://www.sofang.com/favicon.ico" type="image/x-icon">
        <script src="/{{$theme}}/js/jquery.js"></script>
        @yield('head')
    </head>
    <body>
        {{--头部--}}
        @include($theme.".layout.header")

        @if(isset($search) && $search==true)
            @include($theme.".layout.search")
        @endif

        @yield('content')

        @include($theme.'.layout.footer')
    </body>

</html>