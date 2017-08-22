<?php
namespace App\Dao\Article;
use DB;

class ArticleDao{

    public function getArticle(){
        $res = DB::table('articles')->where('status',1)->paginate(5);
        return $res;
    }

    public function getDetail($id){
        $res = DB::table('articles')->where('id',$id)->first();
        return $res;
    }
}