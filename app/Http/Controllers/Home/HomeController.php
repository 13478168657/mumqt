<?php
namespace App\Http\Controllers\Home;
use DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Request;
use Redirect;

class HomeController extends Controller{

    public function __construct() {

    }
    
    public function home(){
        $articles = $this->getHotArticles();
        $ads = $this->getAds();
        return view('home.home',['articles'=>$articles]);
    }

    /*
     * 今日热点
     */
    private function getHotArticles(){
        $articles = DB::table('articles')->orderBy('timeCreate','desc')->limit(3)->get();
        return $articles;
    }
    /*
     * 获取广告
     */
    private function getAds(){
        
    }
}