<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Test;

use Session;
use Illuminate\Routing\Controller;
/**
 * Description of LabController
 *
 * @author yuanl
 */
class LabController extends Controller {
    
    public function session1(){
        
        Session(['yy' => 'value']);
        return Session('yy');
    }
    
    public function session2(){
        
        return Session('yy');
    }
}
