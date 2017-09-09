<?php
namespace App\Http\Controllers\WebChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class WebChatController extends Controller{
    const token = 'ykk123';
    public function check(Request $request){

        $file_path = storage_path().'logs/webChart.txt';
        $handle = fopen($file_path,'a');
        fwrite($handle,'sdsf');
        fclose($handle);
//        $timestamp = $request->input('timestamp');
//        $nonce = $request->input('nonce');
//        $echostr = $request->input('echostr');
//        $signature = $request->input('signature');
//        $arr = [$timestamp,$nonce,self::token];
//        sort($arr);
//        $str = implode('',$arr);
//        if(sha1($str) == $signature){
//            echo $echostr;
//            exit;
//        }
        $this->responseMsg($request);
    }
    public function responseMsg($request)
    {
        //get post data, May be due to the different environments
        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $request->input('FromUserName');
            $toUsername = $request->input(ToUserName;
            $keyword = trim($request->Content);
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if(!empty( $keyword ))
            {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                echo "Input something...";
            }

        }else {
            echo "";
            exit;
        }
    }
}