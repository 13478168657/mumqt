<?php
/**
 * Created by PhpStorm.
 * User: yuanl
 * Date: 2016/4/9
 * Time: 13:58
 */

namespace App\Http\Controllers;
use  hisorange\BrowserDetect\Facade\Parser as BrowserDetect;

class ViewSelector
{
    /**
     * @param $viewName PC端的页面名称
     * @return mixed    PC或H5端页面名称，根据当前URL域名中是否包含m.而定
     */
    public static function getViewName($viewName){
        $name = $viewName;
        if (BrowserDetect::isMobile())
        {
            $name = 'h5/'.$viewName;
        }
        return $name;
    }

    /**
     * PHP判断是否移动端访问访问
     * @return true/false
     */
    public static function  isMobile(){
        return BrowserDetect::isMobile();
    }
}