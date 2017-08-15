<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\City\CityController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Dao\City\CityDao;
use App\Dao\User\MyEntrustDao;
use App\Http\Controllers\Househelp\HousehelpController;
use Auth;
use App\Http\Controllers\Lists\PublicController;
use App\Services\Search;
/**
 *  求租求购的录入控制器
 *  @date   2016年08月25日
 *  @author xcy
 */
class MyEntrustController extends Controller{
    private $cityDao;
    private $myEntrust;
    public function __construct() {
        $this->cityDao = new CityDao();
        $this->myEntrust = new MyEntrustDao();
    }

    /**
     * 求租求购的录入
     * @param $type
     * @return mixed
     */
    public function wantSaleRent($type,$id=''){
        if(strpos($type,'sale')){
            $data['sr'] = 's';
            $table = 'housesalewanted';
            $data['fitments'] = config('conditionConfig.pei.text');
        }else{
            $data['sr'] = 'r';
            $table = 'houserentwanted';
            $data['fitments'] = config('conditionConfig.pei1.text');
        }
        if($type == 'spsale' || $type == 'sprent'){
            $data['tp1'] = 1;
            $data['housetypes'] = config('conditionConfig.housetype1.text');
            $data['trades'] = config('conditionConfig.spind.text');
        }elseif($type == 'xzlsale' || $type == 'xzlrent'){
            $data['tp1'] = 2;
            $data['housetypes'] = config('conditionConfig.housetype2.text');
        }else{
            $data['tp1'] = 3;
            $data['housetypes'] = config('conditionConfig.housetype.text');
        }
        $data['checkInTime'] = config('houseState.Zz.checkInTime');
        $data['type'] = $type;
        $data['provinces'] = $this->cityDao->selectProvince();
        if(!empty($id)){
            $data['id'] = $id;
            $public = new PublicController();
            $data['whouse'] = $this->myEntrust->getWantedDataById($table,$id);
            $data['citys'] = $this->cityDao->selectCity($data['whouse']->provinceId);
            if(!empty($data['whouse']->cityId)){
                $data['cityAreas'] = $public->getCityArea($data['whouse']->cityId);
                $data['subways'] = $public->getSubWay($data['whouse']->cityId);
            }
            if(!empty($data['whouse']->searchType) && $data['whouse']->searchType ==1){
                $data['cityBussinAreas'] = $public->getBusinessArea($data['whouse']->cityAreaId);
            }elseif(!empty($data['whouse']->searchType) && $data['whouse']->searchType ==2){
                $data['citySubWayStation'] = $public->getSubWayStation($data['whouse']->cityId,$data['whouse']->subwayLineId);
            }
            $search = new Search();
            if(!empty($data['whouse']->communityId)){
                $comres = $search->getCommunityByCid($data['whouse']->communityId);
                $data['comName'] = !empty($comres->_source->name)?$comres->_source->name:'';
            }

        }
        return view('user.userEntrust.wantSaleRent',$data);
    }

    //
    public function wantSaleRentSub($type){
        if(strpos($type,'sale')){
            $table = 'housesalewanted';
        }else{
            $table = 'houserentwanted';
        }
        $data = Input::all();
        unset($data['_token']);
        // 用户未登陆的处理
        if(!Auth::check()){
            $househelp = new HousehelpController();
            // 验证码判断
            $codeFlag = $househelp->checkCode();
            if(is_array($codeFlag)){
                return json_encode($codeFlag);
            }
            // 检测手机号是否已被注册
            $mobileFlag = $househelp->checkMobile();
            if(is_array($mobileFlag)){
                return json_encode($mobileFlag);
            }

        }
        unset($data['code']);
        $data['uId'] = Auth::user()->id;
        $data['linkmobile'] = Auth::user()->mobile;

        if(!empty($data['id'])){
            $id = $data['id'];
            unset($data['id']);
            $res = $this->myEntrust->updateRentSaleWanted($table,$data,$id);
        }else{
            //是否超过所能发的最多房源
            $houseHelp = new HousehelpController();
            $houseCount = $houseHelp->getHouseCount();
            if(is_array($houseCount)){
                return json_encode($houseCount);
            }
            $res = $this->myEntrust->insertRentSaleWanted($table,$data);
        }
        if($res){
            return json_encode(['res' => 'success', 'data' => '保存成功']);
        }else{
            return json_encode(['res' => 'error', 'data' => '保存失败']);
        }
    }

    /**
     *  我的委托(列表页)
     * @param  $type   wantRentList 表示求租列表页   wantSaleList  表示求购列表页   rentList  表示出租列表页   saleList  表示出售列表页  
     */
    public function myEntrust(){
        error_reporting(0);
        $type = Input::get('type','');
         //  普通用户信息
        $info =$this->myEntrustDao->GetCustomersInfo('customers',Auth::user()->id);
        if($type == ''){
            // 先判断 求租  求购  出租  出售  是否都有录入的信息
            $wantRentRes = $this->myEntrustDao->GetEntrustWantList(Auth::user()->id,'houserentwanted',1);            
            $Wrent = !empty($wantRentRes) ? 'Wrent' : '';
            $wantSaleRes = $this->myEntrustDao->GetEntrustWantList(Auth::user()->id,'housesalewanted',1);
            $Wsale = !empty($wantSaleRes) ? 'Wsale' : '';
            $rentRes = $this->myEntrustDao->GetRentSale(Auth::user()->id,'houserent',1);
            $rent = !empty($rentRes) ? 'rent' : '';
            $saleRes = $this->myEntrustDao->GetRentSale(Auth::user()->id,'housesale',1);
            $sale = !empty($saleRes) ? 'sale' : '';
            $entrust = ['Wrent'=>$Wrent,'Wsale'=>$Wsale,'rent'=>$rent,'sale'=>$sale];
            Session::put('entrust'.Auth::user()->id,$entrust);
            Session::save();
            if($Wrent){
                // 表示有求租信息
                $type = 'wantRentList';
            }
            if(!$Wrent && $Wsale){
                // 表示有求购信息
                $type = 'wantSaleList';
            }
            if(!$Wrent && !$Wsale && $rent){
                // 表示有出租信息
                $type = 'rentList';
            }
            if(!$Wrent && !$Wsale && !$rent && $sale){
                // 表示有出售信息
                $type = 'saleList';
            }
            if(!$Wrent && !$Wsale && !$rent && !$sale){
                // 表示没有录入信息
                return view('user.userinter.myEntrust',['entrust'=>$entrust,'info'=>$info[0]]);
            } 
        }
        // 从session中取出信息
        $entrust = Session::get('entrust'.Auth::user()->id);
        if($type == 'rentList'){         
            $click = 'rent'; 
            // 查询出租信息
            $eInfo = $this->myEntrustDao->GetRentSale(Auth::user()->id,'houserent',2);
            //dd($eInfo);
            $entrustInfo = $eInfo['info'];
            $image = $eInfo['image'];
            if($entrustInfo[0]->houseType1 == 3){
               // 查询这个物业类型的特色标签
                $type1 = 4;
                $entrustInfo[0]->tag = $this->myEntrustDao->GetTagsInfo($entrustInfo[0]->houseType2,$entrustInfo[0]->houseType1,$type1);
            }
            
        }else if($type == 'saleList'){         
            $eInfo = $this->myEntrustDao->GetRentSale(Auth::user()->id,'housesale',2);
            $entrustInfo = $eInfo['info'];
            $image = $eInfo['image'];
            $click = 'sale';
        }else if($type == 'wantSaleList'){
            $click = 'wantSale';
            // 查询求购信息
            $entrustInfo = $this->myEntrustDao->GetEntrustWantList(Auth::user()->id,'housesalewanted',2,'wantSale');
        }else if($type == 'wantRentList'){
            $click = 'wantRent';
            // 查询求租信息
            $entrustInfo = $this->myEntrustDao->GetEntrustWantList(Auth::user()->id,'houserentwanted',2,'wantRent');   
            // 根据求租信息获得推荐房源
            $tuiJhouse = $this->myEntrustDao->GetTuiJhouse($entrustInfo[0]->id,'houserentwanted_delegate',0,1);
            //dd($tuiJhouse);
                      
        }       
        if(!empty($entrustInfo[0]->roomStr)){
            $entrustInfo[0]->roomStr = explode('_',$entrustInfo[0]->roomStr);
        }
        $myEntrust = $this->EntrustWant($entrustInfo); 
        // 处理特色标签
//        if($type == 'rentList' || $type == 'saleList'){
//            $myEntrust[0]->tagId = explode('|',$myEntrust[0]->tagId);
//            // 根据标签id查询标签
//            $myEntrust[0]->tags = $this->myEntrustDao->GetTag($myEntrust[0]->tagId,'tag');
//        }
        
        // 处理物业类型
        $houseType2 = ['101'=>'住宅底商','102'=>'商业街商铺','103'=>'临街商铺','104'=>'写字楼底商','105'=>'购物中心商铺','106'=>'其他','201'=>'纯写字楼','203'=>'商业综合体楼','204'=>'酒店写字楼','303'=>'商住楼','301'=>'普宅','302'=>'经济适用房','304'=>'别墅','305'=>'豪宅','306'=>'平房','307'=>'四合院','401'=>'其他-厂房','402'=>'其他-其他'];
        $myEntrust[0]->houseType = $houseType2[$myEntrust[0]->houseType2];
        $myEntrust[0]->title = mb_substr($myEntrust[0]->title,0,24);
        //dd($myEntrust);
        if($type == 'rentList' || $type == 'saleList'){
            return view('user.userinter.myEntrust',['click'=>$click,'info'=>$info[0],'myEntrust'=>$myEntrust,'image'=>$image,'type'=>$type,'entrust'=>$entrust]);
        }
        if($type == 'wantRentList' || $type == 'wantSaleList'){
            if(!empty($tuiJhouse)){
                $houseId = [];  // 推送的房源id  和 经纪人id
                $broker = [];  // 经纪人id
                $brokerHouse = [];
                foreach($tuiJhouse as $k => $tui){
                    $broker[] = $tui->brokerId;
                    $brokerHouse[$k][0] = $tui->brokerId;
                    $brokerHouse[$k][1] = explode('|',$tuiJhouse[$k]->hIds);
                    $houseId = array_merge( $houseId , explode('|',$tui->hIds));
                }   
                //dd($brokerHouse);
                // 查询经纪人的基本信息
                $brokerInfo = $this->myEntrustDao->GetBrokerInfo($broker);
                //dd($brokerInfo);
                // 查询房源的基本信息                
                $searchRent = new Search('hr');  // 出租 (二手房)    
                $dataRent = $searchRent->searchHouseListByIds(($houseId))->docs;
                //dd($dataRent);
            } 
            return view('user.userinter.myEntrust',['brokerInfo'=>$brokerInfo,'dataRent'=>$dataRent,'brokerHouse'=>$brokerHouse,'click'=>$click,'info'=>$info[0],'myEntrust'=>$myEntrust,'type'=>$type,'entrust'=>$entrust]);
        }
                
    }
    /**
     *  求租  求购  信息的处理
     * @param  $data   求租  求购的数组
     */
    private function EntrustWant($data){
        $cityId = 1;  // 测试用北京市区，以后要根据页面头部来确定        
        if(isset($data[0]->searchType)){
            // 获取当前城市的全部的地铁线路
            $data[0]->subwayL = $this->myEntrustDao->GetSubwayLine($cityId);
        } 
        // 查询所有省市区商圈           
        $data[0]->pros = $this->cityDao->selectProvince(); 
        // 按地铁求租
        if($data[0]->searchType == 2){                          
            // 根据地铁线路确定地铁名称
            $subway = $this->myEntrustDao->SubwayGetArea($data[0]->subwayLineId,$data[0]->subwayId,$cityId);                 
            $data[0]->Line = $subway[0]->name;
            $data[0]->Station = $subway[0]->stationname;  
            // 获取当前城市的全部的地铁站点
            $data[0]->subwaySta = $this->myEntrustDao->GetSubwayLine($data[0]->subwayLineId,$cityId);
        }
        // 按区域求租
        if($data[0]->searchType == 1 || !isset($data[0]->searchType)){
            if(!isset($data[0]->searchType)){
                // 处理出租的委托信息
                $data[0]->cityAreaId = $data[0]->cityareaId;
            }
            // 查询省市区
            RedisCacheUtil::wholeCacheInit();
            $pro = RedisCacheUtil::getProvinceNameById($data[0]->provinceId);  // 省
            $data[0]->province = $pro;
            $city = RedisCacheUtil::getCityNameById($data[0]->cityId);  // 市
            $data[0]->city = $city;            
            $cityArea = RedisCacheUtil::getCityNameAreaById($data[0]->cityAreaId);  // 区域
            $data[0]->cityArea = $cityArea;
            if($data[0]->businessAreaId == 0){
                $data[0]->businessArea = '';
            }else{
                $bus = RedisCacheUtil::getBussinessNameById($data[0]->businessAreaId);  // 商圈
                $data[0]->businessArea = $bus;
            }  
            // 查询所有省市区商圈           
            $data[0]->pros = $this->cityDao->selectProvince();
            $data[0]->citys = $this->cityDao->selectCity($data[0]->provinceId);
            $data[0]->cityAreas = $this->cityDao->selectCityArea($data[0]->cityId);
            $data[0]->bus = $this->myEntrustDao->GetBusinessInfo($data[0]->cityAreaId);
        }
        // 按小区求租
        if($data[0]->searchType == 3 || !isset($data[0]->searchType)){
            if(!isset($data[0]->searchType)){
                // 处理出租的委托信息
                $data[0]->communityIds = $data[0]->communityId;
            }
            $data[0]->communityIds = explode('|',$data[0]->communityIds);          
            // 查询楼盘名称
            $data[0]->community = $this->myEntrustDao->GetCommunityName($data[0]->communityIds);          
        } 
        return $data;
    }
    /**
     *  查询省份和用户信息
     */
    public function publicFunction(){
        //  查询普通用户信息
        $info = $this->myEntrustDao->GetCustomersInfo('customers',Auth::user()->id);
        // 查询省份
        $province = $this->cityDao->selectProvince();
        return [
            'info' => $info,
            'province' => $province,
        ];
    }
    
    /**
     *  录入求租信息
     * @param  $type  Zz  表示住宅   Office   表示写字楼   Shop  表示商铺
     * @param  $edit   1  表示修改
     */
    public function inputWantRent($type){
        if(!empty(Input::get())){         
            $houseInfo = Input::get();
            $edit = Input::get('edit','');
            unset($houseInfo['_token']);
            unset($houseInfo['community']);            
            $houseInfo["communityIds"] = implode('|',$houseInfo["communityIds"]);
            // 住宅
            if($type == 'Zz'){
                $houseInfo['houseType1'] = 3;
                $houseInfo["roomStr"] = implode('_',$houseInfo["room"]);
                unset($houseInfo["room"]);
                $houseInfo["equipment"] = implode('|',$houseInfo["equipment"]);
            }           
            // 写字楼
            if($type == 'Office'){
                $houseInfo['houseType1'] = 2;
            }
            // 商铺
            if($type == 'Shop'){
                $houseInfo['houseType1'] = 1;
            }
            $houseInfo['state'] = 1; // 已发布
            $houseInfo['linkman'] = Auth::user()->userName;
            $houseInfo['uid'] = Auth::user()->id;
            $houseInfo['linkmobile'] = Auth::user()->mobile;
            // 执行修改操作
            if($edit == 1){
                unset($houseInfo['edit']);
                $id = Input::get('id');
                unset($houseInfo['id']);
                $res = $this->myEntrustDao->editEntrustInfo($houseInfo,'houserentwanted',$id);
                if($res){
                    return 8;  // 修改成功
                }
            }
            // 执行添加操作
            if($edit == ''){
                $insertId = $this->myEntrustDao->InsertRent($houseInfo,'houserentwanted');
                 if($insertId){
                     //dd($insertId);
                     return 8;    // 添加成功
                 }
            }
             return 2;  // 失败
            
        }else{           
            // 查询地铁线路
            $subway = $this->myEntrustDao->GetSubwayLine(1);
            //  查询普通用户信息
            $info = $this->myEntrustDao->GetCustomersInfo('customers',Auth::user()->id);
            if(empty($info)){
                $info[0] = '';
            }
            // 查询省份
            $province = $this->cityDao->selectProvince();
            if($type == 'Zz'){
                $view = 'myWantRentZz';                
            }
            if($type == 'Office'){
                $view = 'myWantRentOffice'; 
            }
            if($type == 'Shop'){
                $view = 'myWantRentShop';
            }
            return view('user.userinter.'.$view)->with('entrust',true)
                    ->with('info',$info[0])->with('province',$province)
                    ->with('subway',$subway);
        }      
        
    }

     /**
     *  显示录入出租信息（住宅）
     * @param   $edit   1 表示修改操作
     * @param   $type   Zz  表示住宅   Office  表示写字楼   Shop  表示商铺 
     */
    public function inputRentInfo($type){
        if(!empty(Input::get())){
            $edit = Input::get('edit','');   // $edit  1   表示修改操作
            $houseInfo = Input::get();
            //dd($houseInfo);
            unset($houseInfo["_token"]);
            unset($houseInfo["communityName"]);
            $houseInfo['linkman'] = Auth::user()->userName;
            $houseInfo['uid'] = Auth::user()->id;
            $houseInfo['linkmobile'] = Auth::user()->mobile;
            $houseInfo['state'] = 1;  // 已发布
            $houseInfo["priceUnit"] = 1;   //  选中的价格单位
            // 表示住宅
            if($type == 'Zz'){
                // 厅  室  卫  厨  处理
                $houseInfo["roomStr"] = implode('_',$houseInfo["room"]);
                $houseInfo["room"] = implode('',$houseInfo["room"]);
                $houseInfo["equipment"] = implode('|',$houseInfo["equipment"]);
                // 处理自定义标签
                $tagdiy = [];
                $diyTagId1 = [];
                foreach($houseInfo["diyTag"] as $t => $tag){
                    if(!empty($tag)){                        
                        $tagdiy[$t]['name'] = $tag;
                        $tagdiy[$t]['type'] = 4;
                        // 查询自定义标签表是否有这个标签名称
                        $res = $this->myEntrustDao->GetTagInfo($tag,'tagdiy',1);
                        if($res){
                            $diyTagId1[] = $res[0]->id;
                            unset($houseInfo["diyTag"][$t]);
                            unset($tagdiy[$t]);
                            //unset($tagdiy[$t]['type']);
                        }
                    }
                }
                if(!empty($tagdiy)){
                    // 执行插入自定义标签操作
                    $this->myEntrustDao->InsertInfo($tagdiy,'tagdiy'); 
                    $diyName = [];
                    foreach($tagdiy as $key => $diyT){
                        $diyName[$key] = $diyT['name'];
                    }                    
                    // 查询添加的标签的id
                    $diyIds = $this->myEntrustDao->GetTagInfo($diyName,'tagdiy',2);
                    $houseInfo["diyTagId"] = implode('|',array_merge($diyTagId1,$diyIds));
                }else{
                   $houseInfo["diyTagId"] = ''; 
                }               
                unset($houseInfo['diyTag']);
            }
            // 表示商铺
            if($type == 'Shop'){               
                $houseInfo["equipment"] = implode('|',$houseInfo["equipment"]);
                $houseInfo["trade"] = implode('|',$houseInfo["trade"]);
            }
            // 处理不同单位的租金
            $recordInfo = $this->myEntrustDao->GetAreaPriceDiff($houseInfo["provinceId"],$houseInfo["cityId"],$houseInfo["houseType1"],$houseInfo["houseType2"]);
            if(!empty($recordInfo)){
                $data = $this->priceConversion($houseInfo['price1'],$houseInfo['priceUnit'],$houseInfo['practicalArea']);  // 使用面积
            }else{
                $data = $this->priceConversion($houseInfo['price1'],$houseInfo['priceUnit'],$houseInfo['area']);  // 建筑面积
            }             
            // 判断是否上传图片       
            if(!empty($houseInfo['fileImg'])){  
                $data = $this->getImage($houseInfo,$edit);
                // 修改
                if($edit == 1){
                    $Hid = $data['houseInfo']['id'];
                    unset($data['houseInfo']['id']);
                    $update = $this->myEntrustDao->editEntrustInfo($data['houseInfo'],'houserent',$Hid);
                    if($update){
                        foreach ($data['imagesInfo'] as $k => $image){
                                $data['imagesInfo'][$k]['houseId'] = $Hid;
                            };
                            $res = $this->myEntrustDao->InsertImage($data['imagesInfo'],'houserentimage');
                            if($res){
                                return 8;  //  添加成功
                        }
                    }
                }
                // 添加
                if($edit == ''){
                    $insertId = $this->myEntrustDao->InsertRent($data['houseInfo'],'houserent');
                    if($insertId){
                        foreach ($data['imagesInfo'] as $k => $image){
                            $data['imagesInfo'][$k]['houseId'] = $insertId;
                        };
                        //dd($data['imagesInfo']);
                        $res = $this->myEntrustDao->InsertImage($data['imagesInfo'],'houserentimage');
                        if($res){
                            return 8;  //  添加成功
                        }
                    }
                }
            }else{                 
               unset($houseInfo['fileImg']);              
               // 执行修改操作
               if($edit == 1){
                   //dd($houseInfo);
                   $id = $houseInfo['id'];
                   unset($houseInfo['id']);
                   unset($houseInfo['edit']);
                   $res = $this->myEntrustDao->editEntrustInfo($houseInfo,'houserent',$id);
                   if($res){
                       return 8;  // 修改成功
                   }
               }
               // 执行添加操作
               if($edit == ''){
                   $insertId = $this->myEntrustDao->InsertRent($houseInfo,'houserent');
                    if($insertId){
                        return 8;  //  添加成功
                    }
               }                              
            }                   
            return 2;   // 添加或修改失败
        }else{
            //  查询普通用户信息
            $info = $this->myEntrustDao->GetCustomersInfo('customers',Auth::user()->id);
            if(empty($info)){
                $info[0] = '';
            }
            // 查询省份
            $province = $this->cityDao->selectProvince();
            // 住宅
            if($type == 'Zz'){
                $view = 'myRentInfoZz';               
            }
            // 写字楼
            if($type == 'Office'){
                $view = 'myRentInfoOffice';                
            }
            // 商铺
            if($type == 'Shop'){
                $view = 'myRentInfoShop';                
            }
            return view('user.userinter.'.$view)
                    ->with('entrust',true)
                    ->with('province',$province)
                    ->with('info',$info[0]);           
        }
    }
    
    /**
     *  图片的处理
     * @param  $houseInfo   房源信息
     * @param  $edit        1  表示修改  '' 表示添加
     */
    public function getImage($houseInfo,$edit){
        $imageInfo = json_decode($houseInfo['fileImg']);
        $imageUpload = new UploadImgUtil();
        $imageData = [];
        $imgId = [];
        foreach($imageInfo as $image){
            if($image != null){
                if(isset($image->id)){
                    // 执行修改图片别名操作
                    $imgId[] = $image->id;
                    $res = $this->myEntrustDao->updateImageNote($image->id,$image->note);
                }else{
                    $imageData[] = $image;
                }
            }
        }       
        $imagesInfo = [];
        foreach($imageData as $k => $images){               
            $vimg = [];
            $vimg['filename'] = $images->fileName;
            $path = DIRECTORY_SEPARATOR."img".$vimg['filename'];
            $vimgInfo = getimagesize($path);
            $vimg['size'] = ceil(filesize($path)/1024);
            $vimg['width'] = $vimgInfo[0];
            $vimg['height'] = $vimgInfo[1];
            $vimg['note'] = $images->note;      
            $vimg['uid'] = $houseInfo['uid'];
            $vimg['communityId'] = $houseInfo['provinceId'];
            $vimg['cityId'] = $houseInfo['cityId'];
            $imagesInfo[] = $vimg;
        }
        unset($houseInfo["fileImg"]);
        if(empty($imgId)){
            $houseInfo['thumbPic'] = $imageInfo[0]->fileName;
        }
        return [
            'houseInfo' => $houseInfo,
            'imagesInfo' => $imagesInfo,
        ];
    }
    
    
    /**
     *   显示录入出售页面  
     * @param  $type  Zz  住宅  Shop  商铺   Office  写字楼
     * @param  $edit   1  表示执行修改操作
     */
    public function inputSaleInfo($type){
        if(!empty(Input::get())){
            $edit = Input::get('edit','');
            $houseInfo = Input::get();
            $houseInfo['uid'] = Auth::user()->id;
            $houseInfo['linkmobile'] = Auth::user()->mobile;
            $houseInfo['linkman'] = Auth::user()->userName;
            unset($houseInfo["_token"]);
            unset($houseInfo["communityName"]);
            $houseInfo['state'] = 1;  // 已发布
            $houseInfo["priceUnit"] = 1;   //  选中的价格单位
            if($type == 'Zz'){
                $houseInfo["houseType1"] = 3;   //  表示住宅               
                // 厅  室  卫  厨  处理
                $houseInfo["roomStr"] = implode('_',$houseInfo["room"]);
                $houseInfo["room"] = implode('',$houseInfo["room"]);
            }   
            if($type == 'Shop'){
                $houseInfo["houseType1"] = 1;   //  表示商铺               
            }
            if($type == 'Office'){
                $houseInfo["houseType1"] = 1;   //  表示写字楼
            }
            // 判断是否上传图片
            if(!empty($houseInfo['fileImg'][0])){               
                $data = $this->getImage($houseInfo);
                //dd($data['imageInfo']);
                $insertId = $this->myEntrustDao->InsertRent($data['houseInfo'],'housesale');
                if($insertId){
                    foreach ($data['imageInfo'] as $k => $image){
                        $data['imageInfo'][$k]['houseId'] = $insertId;
                    }
                    $res = $this->myEntrustDao->InsertImage($data['imageInfo'],'housesaleimage');
                    if($res){
                        return 8;
                    }
                } 
            }else{                
               unset($houseInfo['fileImg']);
               // 执行修改操作
               if($edit == 1){
                    unset($houseInfo['edit']);
                    $id = $houseInfo['id'];
                    unset($houseInfo['id']);
                    $res = $this->myEntrustDao->editEntrustInfo($houseInfo,'housesale',$id);
                    if($res){
                        return 8;  // 修改成功
                    }
               }
               // 执行添加操作
               if($edit == ''){
                    $insertId = $this->myEntrustDao->InsertRent($houseInfo,'housesale');   
                    if($insertId){
                        return 8;   // 添加成功
                    }
               }               
            }                   
            return 2;
        }else{
            //  查询普通用户信息
            $info = $this->myEntrustDao->GetCustomersInfo('customers',Auth::user()->id);
            if(empty($info)){
                $info[0] = '';
            }
            // 查询省份
            $province = $this->cityDao->selectProvince();
            // 住宅
            if($type == 'Zz'){
                $view = 'mySaleInfoZz';                                            
            }
            if($type == 'Office'){
                $view = 'mySaleInfoOffice';               
            }
            if($type == 'Shop'){
                $view = 'mySaleInfoShop';
            }
            return view('user.userinter.'.$view)
                    ->with('entrust',true)
                    ->with('province',$province)
                    ->with('info',$info[0]);
        }
    }
    
    /**
     *  显示录入求购页面
     * @param   $edit   1  表示编辑信息
     */
    public function inputWantSale($type){
        if(!empty(Input::get())){
            $edit = Input::get('edit','');
            $houseInfo = Input::get();
            unset($houseInfo['_token']);
            unset($houseInfo['community']);
            $houseInfo["communityIds"] = implode('|',$houseInfo["communityIds"]);
            if($type == 'Zz'){
                $houseInfo['houseType1'] = 3;
                $houseInfo["roomStr"] = implode('_',$houseInfo["room"]);
                unset($houseInfo["room"]);
            }
            // 写字楼
            if($type == 'Office'){
                $houseInfo['houseType1'] = 2;
            }
            // 商铺
            if($type == 'Shop'){
                $houseInfo['houseType1'] = 1;
            }
            $houseInfo['state'] = 1; // 已发布
            $houseInfo['linkman'] = Auth::user()->userName;
            $houseInfo['uid'] = Auth::user()->id;
            $houseInfo['linkmobile'] = Auth::user()->mobile;
            // 执行修改操作
            if($edit == 1){
                unset($houseInfo['edit']);
                $id = $houseInfo['id'];
                unset($houseInfo['id']);
                $res = $this->myEntrustDao->editEntrustInfo($houseInfo,'housesalewanted',$id);
                if($res){
                    return 8;  // 修改成功
                }
            }
            // 执行添加操作
            if($edit == ''){
                $insertId = $this->myEntrustDao->InsertRent($houseInfo,'housesalewanted');
                 if($insertId){
                     return 8;   //  添加成功
                 }
            }
            return 2;   // 失败            
        }else{            
            $subway = $this->myEntrustDao->GetSubwayLine(1);  // 此处根据头部的城市信息确定地铁线路
            //  查询普通用户信息
            $info = $this->myEntrustDao->GetCustomersInfo('customers',Auth::user()->id);
            if(empty($info)){
                $info[0] = '';
            }
            // 查询省份
            $province = $this->cityDao->selectProvince();
            // 住宅
            if($type == 'Zz'){
                $view = 'myWantSaleZz';                                                       
            }
            if($type == 'Office'){
                $view = 'myWantSaleOffice'; 
            }
            if($type == 'Shop'){
                $view = 'myWantSaleShop'; 
            }
            return view('user.userinter.'.$view)
                    ->with('entrust',true)
                    ->with('province',$province)
                    ->with('info',$info[0])
                    ->with('subway',$subway);
        }
    }
        
    /**
     *  ajax请求商圈
     * @param $cityAreaId   城区id
     */
    public function getBusinessInfo(){
        $cityAreaId = Input::get('id'); 
        if(!is_numeric($cityAreaId)){
            return 2;
        }else{
            if(Cache::has('areaId'.$cityAreaId)){
                $business = Cache::get('areaId'.$cityAreaId);
            }else{
                $business = $this->myEntrustDao->GetBusinessInfo($cityAreaId);
                Cache::put('areaId'.$cityAreaId,$business,60*3);                
            }
            return json_encode($business);
        }       
    } 
    
    /**
     *  ajax请求楼盘名称
     */
    public function getCommunityName(){
        $name = Input::get('name');
        $cityId = Input::get('cityId');
        $type1 = Input::get('type1');
        $lists = new ListInputView();
        $lists->cityId = $cityId;
        $lists->communityName = $name;
        $lists->fields = '"id","name","provinceId","cityId","cityAreaId","businessAreaId","address"';
        $lists->pageset = 10;
        $lists->type1 = $type1;
        $lists->isNew = false;
        $search = new Search();     
        $res = $search->searchCommunity($lists);     
        //dd($res);
        $communityInfo = $res->hits->hits;   
        $data = array();              
        if(!empty($communityInfo)){
            foreach($communityInfo as $k => $community){
                $data[$k]['id'] = $community->fields->id[0];
                $data[$k]['name'] = $community->fields->name[0];
                $data[$k]['cityId'] = $community->fields->cityId[0];
                $data[$k]['cityAreaId'] = $community->fields->cityAreaId[0];
                $data[$k]['businessAreaId'] = $community->fields->businessAreaId[0];
                $data[$k]['address'] = $community->fields->address[0];
            }
            return json_encode($data);
        }else{
            return 5;  //  没有搜索到楼盘名称
        }
    } 
    
    /**
     *  ajax获得标签
     * @param  $houseType2   副物业类型
     * @param  $houseType1   主物业类型
     * @param  $type         4 二手房房源
     */
    public function getTags(){       
        $houseType2 = Input::get('houseType2');
        $houseType1 = Input::get('houseType1');
        //dd($houseType2);
        $type = Input::get('type');
        if(!is_numeric($houseType2) || !is_numeric($houseType1)){
            return 3;    //  参数错误
        }
//        if(Cache::has($houseType1.'tags'.$houseType2)){
//            $tagInfo = Cache::get($houseType1.'tags'.$houseType2);
//        }else{
            $tagInfo = $this->myEntrustDao->GetTagsInfo($houseType2,$houseType1,$type);                
            //Cache::put($houseType1.'tags'.$houseType2,$tagInfo,24*60);                
        //}
        return json_encode($tagInfo);
    }
    
    /**
     *  ajax获得地铁站点
     * @param  $lineId  地铁线路id
     * @param  $cityId  城市id
     */
    public function getSubwayStation(){
        $lineId = Input::get('id');
        $cityId = 1;
        if(!is_numeric($lineId)){
            return 3;  // 参数错误
        }else{
            if(Cache::has('subwayStation'.$lineId)){
                $station = Cache::get('subwayStation'.$lineId);
            }else{
                $station = $this->myEntrustDao->GetSubwayStation($lineId,$cityId);
                Cache::put('subwayStation'.$lineId,$station,24*60);
            }
            return json_encode($station);
        }
    }
    /**
     *  ajax 请求   取消发布的委托信息
     * @param  $id  要更改的数据的id
     * @param  $type  
     */
    public function changeState(){
        $id = Input::get('id');
        $type = Input::get('type');
        // 求租信息取消
        if($type == 'wantRent'){
            $res = $this->myEntrustDao->changeState($id,'houserentwanted');
        }
        // 求购信息取消
        if($type == 'wantSale'){
            $res = $this->myEntrustDao->changeState($id,'housesalewanted');
        }
        // 出租信息取消
        if($type == 'rent'){
            $res = $this->myEntrustDao->changeState($id,'houserent');
        }
        // 出售信息取消
        if($type == 'sale'){
            $res = $this->myEntrustDao->changeState($id,'housesale');
        }
        if($res){
            return 8;   // 取消发布成功
        }
        return 2;  // 取消发布失败       
    }
    /**
     * ajax请求更多推送房源
     * @param   $type       1 求租列表推送  2  求购列表推送
     * @param   $houseId    委托信息的房源id
     * @param   $brokerNum   经纪人的数量
     */
    public function getMoreHouse(){
        $houseId = Input::get('id');
        $brokerNum = Input::get('brokerNum');
        // 求租列表推送
        if(Input::get('type') == 1){
            $houseInfo = $this->myEntrustDao->GetTuiJhouse($houseId,'houserentwanted_delegate',$brokerNum);
        }
        //dd($houseInfo);
        if(!empty($houseInfo)){
            $hId = [];  // 推送的房源id  和 经纪人id
            $broker = [];  // 经纪人id
            $brokerHouse = [];
            foreach($houseInfo as $k => $info){
                $broker[] = $info->brokerId;
                $brokerHouse[$k][0] = $info->brokerId;
                $brokerHouse[$k][1] = explode('|',$info->hIds);
                $hId = array_merge( $hId , explode('|',$info->hIds));
            }   
            //dd($brokerHouse);
            // 查询经纪人的基本信息
            $brokerInfo = $this->myEntrustDao->GetBrokerInfo($broker);
            //dd($brokerInfo);
            // 查询房源的基本信息                
            if(Input::get('type') == 1){
                $searchRent = new Search('hr');  // 出租 (二手房)    
                $data = $searchRent->searchHouseListByIds(($hId))->docs;
            }
            
            //dd($dataRent);
            return json_encode(['brokerHouse'=>$brokerHouse,'brokerInfo'=>$brokerInfo,'data'=>$data]);
        }else{
            return 2;  // 无更多推送信息
        }
    }
    
    /**
     *  出租，出售编辑时的图片删除
     */
    public function delImage(){
        $imgId = Input::get('imgId');
        if(!is_numeric($imgId)){
            return 2;  // 参数错误
        }
        $uid = Auth::user()->id;
        $res = $this->myEntrustDao->delImage($imgId,1,'houserentimage');
        if($res){
            return 8;  // 删除成功
        }
        return 2;  // 删除失败
    }
    
    //租房价格换算
    public function priceConversion($price,$unit,$area){
            if(empty($price)||empty($area)){
                    $data['price1'] = '';
                    $data['price2'] = '';
                    $data['price3'] = '';
                    $data['price4'] = '';
                    $data['price5'] = '';
                    return $data;
            }
            if($unit == 1){
                    $data['price1'] = $price;
                    $data['price2'] = $price*12/365/$area;
                    $data['price3'] = $price/$area;
                    $data['price4'] = $price*3/$area;
                    $data['price5'] = $price*12/$area;
            }elseif($unit == 2){
                    $data['price1'] = $price*365*$area/12;
                    $data['price2'] = $price;
                    $data['price3'] = $price*365/12;
                    $data['price4'] = $price*365/4;
                    $data['price5'] = $price*365;
            }elseif($unit == 3){
                    $data['price1'] = $price*$area;
                    $data['price2'] = $price*12/365;
                    $data['price3'] = $price;
                    $data['price4'] = $price*3;
                    $data['price5'] = $price*12;
            }elseif($unit == 4){
                    $data['price1'] = $price*$area/3;
                    $data['price2'] = $price*4/365;
                    $data['price3'] = $price/3;
                    $data['price4'] = $price;
                    $data['price5'] = $price*4;
            }elseif($unit == 5){
                    $data['price1'] = $price*$area/12;
                    $data['price2'] = $price/365;
                    $data['price3'] = $price/12;
                    $data['price4'] = $price/4;
                    $data['price5'] = $price;
            }
            return $data;
    }

}