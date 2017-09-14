<?php
namespace App\Http\Controllers\WebChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class WebXinController extends Controller{
    const token = 'ykk521';
    public function index(Request $request){
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
        }else{
            return false;
        }
    }
    public function check(Request $request){
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
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        file_put_contents('1.txt',$postStr);
        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
//            $textTpl = "<xml>
//							<ToUserName><![CDATA[%s]]></ToUserName>
//							<FromUserName><![CDATA[%s]]></FromUserName>
//							<CreateTime>%s</CreateTime>
//							<MsgType><![CDATA[%s]]></MsgType>
//							<Content><![CDATA[%s]]></Content>
//							<FuncFlag>0</FuncFlag>
//							</xml>";
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>1</ArticleCount>
                            <Articles>
                            <item>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                            </item>
                            <item>
                            </Articles>
                        </xml>";
//            $evt = $postObj->Event;
//            if($evt == 'subscribe'){
//                $msgType = "text";
//                $contentStr = '感谢关注！';
//                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr,'http://yirudangchu.com/article/detail/25');
//                echo $resultStr;
//                exit;
//            }
            if(!empty( $keyword ))
            {
                switch($keyword){
                    case "1":
                        $contentStr = '男人福利';
                        break;
                    case "2":
                        $contentStr = '优惠套餐';
                        break;
                    case "3":
                        $contentStr = "你爱玩";
                        break;
                    case "4":
                        $contentStr = "<a href='www.baidu.com'>百度</a>";
                        break;
                    default:
                        $contentStr = "你好！想了解更多？请按如下提升操作：输入1：男人福利；输入2：优惠套餐；输入3：你爱玩";
                }
                $msgType = "news";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr,'育婴教育','http://yirudangchu.com/images/banner.jpg','http://yirudangchu.com/article/detail/25');
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