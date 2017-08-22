<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    @yield('title')
    <meta name="keywords" content="妈妈网" />
    <meta name="description" content="妈妈网" />
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="shortcut icon" href="favicon.ico"/>
    @yield('script')
    @yield('css')
</head>
<body>

@yield('content')

<!--content-end-->
<!--footer部分start-->
@include('layout.footer')
<!--footer部分end-->
</body>
</html>