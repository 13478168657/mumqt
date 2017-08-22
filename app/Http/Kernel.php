<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
         \App\Http\Middleware\EncryptCookies::class,
         \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
         \Illuminate\Session\Middleware\StartSession::class,
         \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
//      \App\Http\Middleware\UserPermAuth::class,   //用户角色权限验证
        // \App\Http\Middleware\CookieCity::class, //修改域名前缀
        // \App\Http\Middleware\IsMobile::class    //判断是否是手机端访问

        // \App\Http\Middleware\ShareRedirect::class,  //楼盘/房源分享页面的中间件
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    		
    	/* 角色权限功能验证 */
    	'permResetPerm' => \App\Http\Middleware\Perm\permResetPerm::class,
    	'test' => \App\Http\Middleware\Perm\test::class,

        //共享session
        'sessionshare' => \App\Http\Middleware\SessionShare::class, 

        // 'houseShare'   => \App\Http\Middleware\ShareRedirect::class,  //楼盘/房源分享页面的中间件

    ];
}
