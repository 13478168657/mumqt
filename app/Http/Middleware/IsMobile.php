<?php
namespace App\Http\Middleware;
use Closure;
use  hisorange\BrowserDetect\Facade\Parser as BrowserDetect;
class IsMobile
{

    public function handle($request, Closure $next)
    {
        define('USER_AGENT_MOBILE',BrowserDetect::isMobile());
        return $next($request);
    }

}