<?php

namespace App\Http\Controllers\Admin;

use App\Dao\Admin\AdminDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author niewu
 */
class AdminController extends Controller {
    
    public $AdminDao;
 
    public function __construct(AdminDao $AdminDao) {
        $this->AdminDao = $AdminDao;
        $this->middleware('auth');
        
    }
    

    //put your code here
    
    public function index(){
        
        //return $this->AdminDao->Dictionaries_index();
        
        
    }
   
}
