<?php
namespace App\Http\Controllers\WebChat;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers;
class WebChatController extends Controllers{
    const token = 'ykk123';
    public function check(Request $request){
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $echostr = $request->input('echostr');
        $signature = $request->input('signature');
        $arr = [$timestamp,$nonce,self::token];
        sort($arr);
        $str = implode('',$arr);
        if(sha1($str) == $signature){
            echo $echostr;
            exit;
        }
    }
}