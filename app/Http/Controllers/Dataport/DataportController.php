<?php

namespace App\Http\Controllers\Dataport;


use Illuminate\Routing\Controller;
use Input;
use App\Dao\Dataport\DataportDao;
use App\Http\Controllers\Utils\UserIdUtil;

/**
 * Description of InterfaceController
 *
 * @author niewu
 */
class DataportController extends Controller {
    
    public $DataportDao;
    public $usertable;
    public $datebase;
    public function __construct(DataportDao $DataportDao) {
        
        $this->DataportDao = $DataportDao;
        $this->datebase = new UserIdUtil();
    
    }

    public function brokers(){
  
        $data = Input::get();
           
//        var_dump($datas);
//        exit;
//        
//        $data = json_decode($datas,true);
//        
        $user = $data;
        
        $id = $this->datebase->getNodeNum($data['id']);
        
        $res = $this->DataportDao->user($user);
        
        if($data['type'] == 1){
            
            $res = $this->DataportDao->brokers($id,$data);
            
        }else{
            
            $res = $this->DataportDao->customers($id,$data);
            
        }
        
        if($res){
            
            return 'success';
            
        }else{
            
            dd($res);
            
        }
        
    }
}
