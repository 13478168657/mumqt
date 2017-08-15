<?php
namespace App\Http\Controllers\Utils;

/**
 * curl操作类
 *
 * @author JohnYoung
 *        
 * @version 1.0
 *         
 */
class CurlUtil
{

    /**
     * curl操作函数
     *
     * @param string $URL
     *            请求地质 http://baidu.com
     * @param string $type
     *            请求方式 GET/POST/PUT/DELETE
     * @param json $params
     *            提交参数 $params="{user:"admin",pwd:"admin"}";
     * @param string $headers
     *            http头文件
     *            
     * @return string 请求返回流
     *        
     * @author JohnYoung
     *        
     * @version 1.0
     */
    public static function MakeCurlFunction($URL, $type, $params = '', $headers = '')
    {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $URL); // 发贴地址
        if ($headers != "") {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: text/json'
            ));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        switch ($type) {
            case "GET":
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }
        if (! empty($params)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        $file_contents = curl_exec($ch); // 获得返回值
        curl_close($ch);
        return $file_contents;
    }
}
