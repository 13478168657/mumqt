<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        
        'login', //首页取消多次CsrfToken验证
        'yzmobile',
        '/webChat/check',
        /*搜索列表*/
        'build/*',
        'house/*',
        /*api接口*/
        'api/100',
    ];
}
