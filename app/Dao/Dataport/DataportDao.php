<?php

namespace App\Dao\Dataport;

use DB;
/**
 * Description of InterfacesDao
 *
 * @author Administrator
 */
class DataportDao {

    public function brokers($id,$data){
        $datas = array(
            'id' => $data['id'],
            'realName'=>$data['realName'],
            'photo'=>$datas['photo'],
            'gender'=>$data['gender'],
            'QQ'=>$data['qq'],
            'intro'=>$data['intro'],
            'cityId'=>$data['cityId'],
            'cityAreaId'=>$data['cityAreaId'],
            'businessAreaId'=>$data['businessAreaId'],
            'company'=>$data['realName'],
            'shopName'=>$data['shopName'],
            'address'=>$data['address'],
            'birthday'=>$data['birthday'],
            
        );

        return DB::connection("36user$id")->table('brokers')-> insert($datas);
    
    }
    
    public function customers($id,$data){
        $datas = array(
            'id' => $data['id'],
            'realName'=>$data['realName'],
            'QQ'=>$data['qq'],
            'birthday'=>$data['birthday'],
            'cityId'=>$data['cityId'],
            'cityAreaId'=>$data['cityAreaId'],
            'intro'=>$data['intro'],
            'photo'=>$data['photo'],
            'timeRegister'=>$data['timeRegister'],
            'timeUpdate'=>$data['timeUpdate'],
        );
        
        return DB::connection("36user$id")->table('brokers')-> insert($datas);
          
    }
    
    public function user($user){
        
        $users = array(
            'id' => $user['id'],
            'userName' => $user['userName'],
            'password' =>$user['password'],
            'email'=>$user['mobile'],
            'mobile'=>$user['mobile'],
            'type'=>$user['type'],
            'timeUpdate'=>$user['timeUpdate'],
      
                );
   
        return DB::connection("36user0")->table('users')-> insert( $users );
        
    }
}
