<?php
/**
 * Created by PhpStorm.
 * User: yuanl
 * Date: 2016/4/19
 * Time: 16:48
 */

namespace App\Http\Controllers\Log;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;
use MongoDB;
use Session;
use Auth;

class LogController extends Controller
{

    public static function writeInPhp($data){
        $data = LogController::appendPhpData($data);
        return LogController::writeDB($data);
    }

    private static function appendPhpData($data){
        if (Auth::check()){
            $data['uid'] = Auth::id();
        }
        $data['ip'] = LogController::getIP();
        $data['sessionId'] = Session::getId();
        return $data;
    }

    public function write(){
        $data = array();
        $url = Input::get('url');
        if (strpos($url, '/housedetail/') > 0){
            $data = LogController::getDetailData($url);
        } else if (strpos($url, 'kw=') > 0){
            $data = LogController::getKeywords($url);
        }
        return LogController::writeDB($this->appendCommonData($data));
    }

    public function writeStayTime(){
        $data['stay'] = Input::get('stay');
        $data['go'] = Input::get('go');
        return LogController::writeDB($this->appendCommonData($data));
    }

    private function appendCommonData($data){
        $data['url'] = Input::get('url');
        $data['refer'] = Input::get('ref');
        if (Auth::check()){
            $data['uid'] = Auth::id();
        }
        if (!Empty(Input::get('op'))){
            $data['op'] = Input::get('op');
        }
        $data['browser'] = Input::get('br');
        $data['ip'] = LogController::getIP();
        $data['sessionId'] = Session::getId();
        $data['time'] = time();
        return $data;
    }

    private static function getDetailData($url){
        $n = strrpos($url,'/');
        $id = substr($url, $n + 3, strlen($url) - $n - 8);
        $data['hid'] = $id;
        return $data;
    }

    private static function getKeywords($url){
        $n = strpos($url, 'kw=');
        $kw = substr($url, $n + 3, strlen($url) - $n - 3);
        $n = strpos($kw, '&');
        if ($n > 0){
            $kw = substr($kw, 0, $n);
        }
        $data['kw'] = urldecode($kw);
        return $data;
    }

    private static function getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private static function writeDB($data){
//        $manager = new Manager('mongodb://localhost:27017');
        $url = \Config::get('mongodb.conn');
        $manager = new Manager($url);
        $bulk = new BulkWrite;
        $bulk->insert($data);
        $r = $manager->executeBulkWrite('sf20_log.csr2016', $bulk);
        if ($r->isAcknowledged()){
            return '1';
        } else {
            return '0\r\n' + var_dump($r);
        }
    }

}