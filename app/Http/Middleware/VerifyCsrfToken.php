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
        'register',
        'dataport',
        'auth/register',
        
        'interface/posthouse',
        'interface/inserthouse1',
        'interface/inserthouse2',
        'interface/houseimg1',
        'interface/houseimg2',
//         'ajax/virtualphone/getDisplayNbr',
        'upload/addphoto',
        'upload/delphoto',
        'saleHouse',
        'autoLogin',
        'autoRegister',
        'houseBuyHelp/Zz',
        'houseBuyHelp/Shop',
        'houseBuyHelp/Office',
        'houseSaleHelp/Zz',
        'houseSaleHelp/Shop',
        'houseSaleHelp/Office',
        'errorCorrection',

        /*搜索列表*/
        'build/*',
        'house/*',
        /*api接口*/
        'api/100',
    ];
}
