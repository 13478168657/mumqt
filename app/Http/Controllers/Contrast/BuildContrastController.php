<?php
namespace App\Http\Controllers\Contrast;
use Auth;
use DB;
use App\Dao\Contrast\BuildContrastDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Utils\AreaUtil;
use App\Http\Controllers\User\UploadsController;
use App\Http\Controllers\Utils\UploadImgUtil;
use App\CommunityDataStructure;
use App\Http\Controllers\Utils\SafeUtil;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Utils\RedisCacheUtil;
use App\Services\Search;
use App\ListInputView;
use Redirect;
class BuildContrastController extends Controller {
	protected $ContrastDao;
	public function __construct() {
		$this->Contrast = new BuildContrastDao;
	}

	/*
	|-------------------------------------------------
	| 楼盘信息对比功能页
	|-------------------------------------------------
	| 查询楼盘的基础信息,详细信息,户型信息,周边信息
	| 进行对比
	*/
	public function buildContrast() {
		$communityId = Input::get('communityId',''); // 楼盘id
                if(!empty($communityId)){
                    $communityId = explode(',',Input::get('communityId'));
                }		
		
		$connection = Input::get('conn',''); // 查询的库
		$data['conn'] = $connection; //用于view的显示
		if($connection == 1){
			$connection = 'mysql_house';
		}else{
			$connection = 'mysql_oldhouse';
		}

		if(!empty(Input::get('selectBuild')) && !empty(Input::get('type2'))){
                        $cityId = Input::get('cityId');
			$buildName = Input::get('selectBuild');
			$type2 = Input::get('type2');
			$typeXinfo = 'type'.$type2.'Info';
			$type1 = Input::get('type1');  // 主物业类型
			$community = new CommunityDataStructure($type2);
			$communityId = $this->Contrast->getCommunityId($connection,$buildName,$cityId); // 获取楼盘id
			if(empty($communityId)){
				$communityInfo = '';
			}else{
                $structure = ['0'=>'','1'=>'板楼','2'=>'塔楼','3'=>'砖楼','4'=>'砖混','5'=>'平房','6'=>'钢混','7'=>'塔板结合','8'=>'框架剪力墙','9'=>'其他'];
				$decoration = ['0'=>'','1'=>'毛坯','2'=>'简装修','3'=>'中装修','4'=>'精装修','5'=>'豪华装修'];
                // 从索引取出数据
                $search = new Search();
                if($connection == 'mysql_oldhouse'){
                    $communitymessage = $search->getCommunityByCid($communityId[0]->id);//$communityId
                }else if($connection == 'mysql_house'){
                    $communitymessage = $search->getCommunityByCid($communityId[0]->id,true);//$communityId
                }
                if(!empty($communitymessage->found)){
                    $communityInfo = array($communitymessage->_source);
                    $commTitlePic = !empty($communityInfo[0]->titleImage) ? get_img_url('commPhoto',$communityInfo[0]->titleImage,1) : '/image/noImage.png';
                    $type2GetInfo = !empty($communityInfo[0]->$typeXinfo) ? $community->unserialize($communityInfo[0]->$typeXinfo) : '';
                }else{
                    $communityInfo = $this->Contrast->getCommunityType2($connection,$communityId[0]->id,$type2); // 获取该楼盘基础信息
                    $type2Info = $communityInfo[0]->$typeXinfo;
                    $type2GetInfo = !empty($type2Info) ? $community->unserialize($type2Info) : '';
                    $commTitlePhoto = $this->Contrast->getPic($connection,$communityId[0]->id,'10'); // 获取该楼盘标题图
                    $commTitlePic = !empty($commTitlePhoto) ? get_img_url('commPhoto',$commTitlePhoto[0]->fileName,1) :'/image/noImage.png';
                }
				$tagIds =  isset($type2GetInfo->tagIds) ? $type2GetInfo->tagIds : ''; //项目特色标签
				if(!empty($tagIds)){
					$tagid = explode('|',$tagIds);
				}
				// 获得特色标签名称				
				$tagName = [];
				if(isset($tagid) && !empty($tagid)){
					foreach ($tagid as $key => $tag) {
						$tagName[] = RedisCacheUtil::getTagNameById($tag);
					}
                }
                $Communityroom = $this->getCommunityRoom($connection, $communityId[0]->id, $type1);
				//获取开盘时间 交房时间 等相关信息
				$getTime = [];
				if(!empty($data['conn'])){
                    $getTime = $this->getNewCommunityOtherById($communitymessage,$type1,$communityId[0]->id);
				}
                $communityInfo['developerName'] = $this->getDeveloperName($communityInfo[0]->developerId);
                $communityInfo['type2GetInfo'] = $type2GetInfo;
				$communityInfo['commTitlePic'] = $commTitlePic;
				$communityInfo['getTime'] = $getTime;
                $communityInfo['communityroom'] = $Communityroom;
				$communityInfo['structure'] = (!empty($type2GetInfo->structure) && isset($structure[$type2GetInfo->structure])) ? $structure[$type2GetInfo->structure] : '';
				$communityInfo['decoration'] = (!empty($type2GetInfo->decoration) && isset($decoration[$type2GetInfo->decoration])) ? $decoration[$type2GetInfo->decoration] : '';
				$communityInfo['tagName'] = $tagName;
				$communityInfo['id'] = $communityId[0]->id;
			}
			return $communityInfo;
		}
		$info = [];
		// 经纬度数组
		$jingweiArr = [];
		//if(!empty($communityId)){
        if(is_array($communityId)){
			for($i = 0;$i < count($communityId);++$i){
				$info[$i] = Session::get('buildCompare'.$communityId[$i]);
				$jingweiArr[$i]['longitude'] = $info[$i]['longitude'];
				$jingweiArr[$i]['latitude'] = $info[$i]['latitude'];
				if(empty($info[$i])){
                    unset($info[$i]);
					//return '楼盘信息有误,请重新对比';
				}
			}
        }else{
            if(isset($_SERVER['HTTP_REFERER'])){
                return Redirect::to($_SERVER['HTTP_REFERER']);
            }
        }
        if(empty($info) && isset($_SERVER['HTTP_REFERER'])){
            return Redirect::to($_SERVER['HTTP_REFERER']);
        }
        $GLOBALS['current_listurl'] = config('session.domain');
		$data['jingweiArr'] = $jingweiArr;
		$data['info'] = array_merge($info);
		// 根据当前城市id确定城市名称
		$data['city'] = RedisCacheUtil::getCityNameById(CURRENT_CITYID);
		return view('contrast.buildContrast',$data);
	}

	/**
	 * 很据楼盘id获取相关的数据 并存入session
	 * @param $id  楼盘id
	 * @param $type1  住宅类型
	 *
	 */
	public function saveBuildCompare(){
		$id = Input::get('id');
		$type1 = Input::get('type1');
		$conn = Input::get('conn'); // 查询的库
		$sessionInfo = array();
        //获取楼盘信息(从索引中取数据)
        $sessionInfo = $this->getCommunityInfoBySearch($conn, $id, $type1);
		if($conn == 1){
			switch($type1){
                case 1:
                    $sessionInfo['url'] = "/shops/area";
                    break;
			    case 2:
			        $sessionInfo['url'] = "/office/area";
                                break;
			    case 3:
			        $sessionInfo['url'] = "/new/area";
				break;
			}
		}else{
			switch($type1){
                case 1:
                    $sessionInfo['url'] = "/sprent/build";
                    break;
			    case 2:
			        $sessionInfo['url'] = "/xzlrent/build";
				break;
			    case 3:
			        $sessionInfo['url'] = "/saleesb/area";
				break;
			}
		}						
		$sessionInfo['type1'] = $type1;
		$sessionInfo['id'] = $id;
		// 存入session中
		Session::put('buildCompare'.$id, $sessionInfo);
		Session::save();
	}
        
    /**
     *  从索引中取数据
     * @param  $conn  1  新盘   0 二手盘
     * @param  $id    楼盘id
     */
    protected function getCommunityInfoBySearch($conn, $id, $type1){
        $sessionInfo = array();
        $search = new Search();
        if($conn == 1){
            //  新盘获取开盘时间
            //$sessionInfo = $this->getNewCommunityOtherById($id);
            $communitymessage = $search->getCommunityByCid($id,true);
            $sessionInfo = $this->getNewCommunityOtherById($communitymessage,$type1,$id);
            $connection = 'mysql_house';
        }
        //dd($sessionInfo);
        if($conn == 0){
            $communitymessage = $search->getCommunityByCid($id);
            $connection = 'mysql_oldhouse';
        }
        if($communitymessage->found){
            $res = $communitymessage->_source;
            // 处理从索引取出的数据
            $sessionInfo = $this->getCommunityDetailByRes($res, $sessionInfo, $type1);
        }
        // 获取户型信息
        $sessionInfo['room'] = $this->getCommunityRoom($connection, $id, $type1);
        return $sessionInfo;
    }
    /**
     *  获取户型信息
     */
    protected function getCommunityRoom($connection, $id, $type1){
        $CommunityRoom = $this->Contrast->getCommunityRoom($connection,$id);
        $huxing = array();
        if(!empty($CommunityRoom)){
            foreach($CommunityRoom as $k=>$room){
                //$huxing[$room->room][] = $room->floorage;
                if(substr($room->type2,0,1) == 3){
                        $huxing[$k][0] = $room->room.'居';
                }else if(substr($room->type2,0,1) == 2 || substr($room->type2,0,1) == 1){
                        $huxing[$k][0] = $room->location;
                }
                $huxing[$k][1] = $room->floorage;
            }
        }
        return $huxing;
    }


    /**
     * 处理从索引取出的数据
     * @param  $res   索引取出的数据
     */
    protected function getCommunityDetailByRes($res, $sessionInfo, $type1){
        $sessionInfo['longitude'] = ($res->longitude == 0 && $res->latitude == 0) ? '116.405467' : $res->longitude;
        $sessionInfo['latitude'] = ($res->longitude == 0 && $res->latitude == 0) ? '39.907761' : $res->latitude;
        $sessionInfo['name'] = $res->name;
        $sessionInfo['titleImg'] = !empty($res->titleImage) ? get_img_url('commPhoto',$res->titleImage,5) : '/image/noImage.png';
        $sessionInfo['address'] = $res->address;
        $sessionInfo['developerName'] = $this->getDeveloperName($res->developerId);
        //$sessionInfo['developerName'] = !empty($developer) ? $developer : '';
        foreach(explode('|',$res->type2) as $tp2){
            if(substr($tp2,0,1) == $type1){
                $type2 = $tp2;
                break;
            }
        }
        $sessionInfo['type2'] = $type2;
        $typeInfo = 'type'.$type2.'Info';
        $typeInfo = !empty($res->$typeInfo) ? json_decode($res->$typeInfo) : '';
        if(!empty($typeInfo)){
            $tagId = !empty($typeInfo->tagIds) ? explode('|',$typeInfo->tagIds) : '';
            // 获得特色标签名称
            $tagName = [];
            if(isset($tagId) && !empty($tagId)){
                foreach ($tagId as $key => $tag) {
                    $tagName[] = RedisCacheUtil::getTagNameById($tag);
                }
            }
            $sessionInfo['tagName'] = $tagName;
            $sessionInfo['propertyYear'] = $typeInfo->propertyYear; //产权年限
            $decorate = \Config::get('conditionConfig.decorate.text');
            $sessionInfo['decorate'] = !empty($decorate[$typeInfo->decoration]) ? $decorate[$typeInfo->decoration] : '';//装修
            $sessionInfo['volume'] = $typeInfo->volume;//容积率
            $sessionInfo['greenRate'] = $typeInfo->greenRate;//绿化率
            $sessionInfo['propertyFee'] = $typeInfo->propertyFee;//物业费
            if($type1 == 3){
                $sessionInfo['houseTotal'] = $typeInfo->houseTotal;//户数
            }
            //建筑结构
            $structure = array(1=>'板楼',2=>'塔楼',3=>'砖楼',4=>'砖混',5=>'平房',6=>'钢混',7=>'塔板结合',8=>'框架剪力墙',9=>'其它');
            $sessionInfo['structure'] = !empty($typeInfo->structure)? $structure[$typeInfo->structure] : '';//建筑结构
        }else{
            $sessionInfo['propertyYear'] = $sessionInfo['decorate'] = $sessionInfo['volume'] = $sessionInfo['greenRate'] = $sessionInfo['propertyFee'] = $sessionInfo['houseTotal'] = $sessionInfo['structure'] = $sessionInfo['tagName'] = '';
        }
        return $sessionInfo;
    }
        
    /**
     * 获取新楼盘开盘时间 交房时间 等相关信息
     * @param  $communitymessage  索引数据
     * @param  $type1  主物业类型
     */
    protected function getNewCommunityOtherById($communitymessage,$type1,$id){
        $communityOther = array();

        //$related = $this->Contrast->getPeriods($id);
        if($communitymessage->found){
            switch((int)$communitymessage->_source->discountType){
                case 0:
                    $communityOther['zhekou'] = '';
                    break;
                case 1:
                    $communityOther['zhekou'] = $communitymessage->_source->discount.'折';
                    break;
                case 2:
                    $communityOther['zhekou'] = '直接减去'.$communitymessage->_source->subtract;
                    break;
                case 3:
                    $communityOther['zhekou'] = $communitymessage->_source->discount.'折,折后减去'.$communitymessage->_source->subtract;
                    break;
            }
            $avgPrice = 'priceSaleAvg'.$type1;
            $communityOther['saleAvgPrice'] = isset($communitymessage->_source->$avgPrice) ? $communitymessage->_source->$avgPrice : ''; //出售的均价
            $communityOther['specialOffers'] = (!empty($communitymessage->_source->specialOffers) && $communitymessage->_source->specialOffers != '_') ? str_replace('_', '抵', $communitymessage->_source->specialOffers) : ''; //优惠信息
            $related = $this->Contrast->getPeriods($id);
            if(!empty($related)){
                foreach($related as $val){
                    if($val->saleAvgPrice == $communityOther['saleAvgPrice']){
                        $communityOther['openTime'] = substr($val->openTime,0,10); //开盘时间
                        $communityOther['takeTime'] = substr($val->takeTime,0,10); //交房时间
                        break;
                    }
                }
            }
        }else{
            $communityOther['saleAvgPrice'] = $communityOther['specialOffers'] = $communityOther['openTime'] = $communityOther['takeTime'] = $communityOther['zhekou'] = '';
        }
        return $communityOther;
    }

    /**
     *  获得项目公司
     */
    protected function getDeveloperName($id){
        if(empty($id)) return '';
        return RedisCacheUtil::getDeveloperNameById($id);
    }

}
?>