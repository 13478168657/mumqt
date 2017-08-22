<?php
namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Dao\Article\ArticleDao;
use Input;
use DB;
use Illuminate\Support\Facades\Request;
class ArticleController extends Controller{
    public function __construct(){
        $this->article = new ArticleDao();
        
    }
    /*获取各新闻板块的文章列表 */
    public function articleList($type){
        $res = $this->article->getArticle();
        return view('article.list',['articles'=>$res]);
    }
    /*
     * 创建文章
     */
    public function create(Request $request){
        return view('article.article');
    }
    /*
     * 文章详情
     */
    public function detail(Request $request,$id){
        $article = $this->article->getDetail($id);
//        dd(htmlspecialchars_decode(htmlentities($article->content)));
//        html_entity_decode($article->content);die;
        return view('article.detail',['article'=>$article]);
    }
    /*
     * 添加文章
     */
    public function postCreate(Request $request){
        $param['title'] = $_POST['title'];
        $param['describe'] = $_POST['description'];
        $param['classify_id'] = $_POST['class'];
        $param['type_id'] = $_POST['type'];
        $param['model'] = $_POST['model'];
        $param['status'] = $_POST['state'];
        $param['content'] = $_POST['content'];
        $article_id = DB::table('articles')->insertGetId($param);
        $pic = $_POST['pic'];
        foreach($pic as $p){
            $data[] = $this->pasteUpload($p,$article_id);
        }
        if($_POST['model']==1){
            $picArr['pic1'] = $data[0];
            $picArr['pic2'] = $data[1];
            $picArr['pic3'] = $data[2];
        }else{
            $picArr['pic1'] = $data[0];
        }

        Db::table('articles')
            ->where('id', $article_id)
            ->update($picArr);
        return $this->articleList();
    }
    /*
     * 上传图片
     */
    public function pasteUpload($pic, $item,$subDirectory='')
    {
        $file =$pic;
        $seg = explode(";",$file);
        if(sizeof($seg)!=2){
            return resError(400,"wrong paramater" );
        }
        $segments = explode(",",$seg[1]);
        if(sizeof($segments)!=2){
            return resError(400,"wrong paramter");
        }
        $data = $segments[1];
        $encoding = $segments[0];

        $header = explode(":",$seg[0]);
        if(sizeof($header)!=2){
            return resError(400,"wrong paramter");
        }

        $mime = explode("/",$header[1]);
        if(sizeof($header)!=2){
            return resError(400,"wrong paramter");
        }
        $extName =  strtolower($mime[1]);
        if(!in_array($extName,array("jpg","bmp","gif","png"))) {
            return resError(403,"bad extension name of the file");
        }
        try{
            $real_data = base64_decode($data);
        }catch(Exception $e){
            return resError(402,"parse data failed");
        }
        $y= date("Ym");
        if (!$subDirectory) {
            $subDirectory = date("Ym/dH/");
        }
        $destDirectory = $this->getUploadDirectory() . $subDirectory;
        if (!file_exists($destDirectory)) {
            mkdir($destDirectory, 0777, true);
        }
        $extension = $extName;
        $mime = $header[1];
        $filename = $this->buildPasteFileName($extension);
        file_put_contents($destDirectory.$filename,$real_data);
        $clientSize = filesize($destDirectory.$filename);
        return DIRECTORY_SEPARATOR.$subDirectory . $filename;
    }

    private function buildPasteFileName($extension){
        $fi = microtime(true).rand(0,99999);
        return $fi.'.'.$extension;
    }
    private function getUploadDirectory(){
        return '/Users/yangzhengxing/project/images/';
    }
}