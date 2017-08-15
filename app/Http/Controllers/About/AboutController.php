<?php
namespace App\Http\Controllers\About;

use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Facades\Redis; //使用redis.so 高效扩展
use App\Http\Controllers\Index\IndexController;

/**
 *  页面底部的控制器
 * @author  zhuwei
 * date     2016/03/10  19:11:30
 */

class AboutController extends Controller{
    
        /**
         * 
         * 页面底部的几个链接
         */
    	public function about($type){
    		//$type = Input::get('type');
    		// 关于我们
    		if($type == 'aboutus'){
    			$selected = true;
    			return view('about.aboutus',['selected1'=>$selected]);
    		}
    		// 联系我们
    		if($type == 'contactus'){
				$cityId = !empty(CURRENT_CITYID) ? CURRENT_CITYID : 0 ; // 判断当前的cityId是否存在
				$agentByIndex = new IndexController();
				$agentMobile = $agentByIndex->getAgentMobile($cityId);
    			$selected = true;
    			return view('about.contactus',['selected2'=>$selected,'agentMobile'=>$agentMobile,'cityName'=>CURRENT_CITYNAME]);
    		}
    		// 免责声明
    		if($type == 'disclaimer'){
    			$selected = true;
    			return view('about.disclaimer',['selected3'=>$selected]);
    		}
    		// 招聘信息
    		if($type == 'recruit'){
    			$selected = true;
    			return view('about.recruit',['selected4'=>$selected]);
    		}
    		// 搜房网络服务协议
    		if($type == 'registAgreement'){
    			$selected = true;
    			return view('about.registrationAgreement');
    		}
    		// 隐私协议
    		if($type == 'secret'){
    			$selected = true;
    			return view('about.secret',['selected6'=>$selected]);
    		}
			// 查看招聘信息
			if($type == 'recruitMessage'){
    			$selected = true;
    			return view('about.recruitMessage',['selected7'=>$selected]);
    		}
			if($type == 'recruitMessage1'){
    			$selected = true;
    			return view('about.recruitMessage1',['selected8'=>$selected]);
    		}
			if($type == 'recruitMessage2'){
    			$selected = true;
    			return view('about.recruitMessage2',['selected9'=>$selected]);
    		}
			if($type == 'recruitMessage3'){
    			$selected = true;
    			return view('about.recruitMessage3',['selected10'=>$selected]);
    		}
			if($type == 'recruitMessage4'){
    			$selected = true;
    			return view('about.recruitMessage4',['selected11'=>$selected]);
    		}
			if($type == 'recruitMessage5'){
    			$selected = true;
    			return view('about.recruitMessage5',['selected12'=>$selected]);
    		}
			if($type == 'recruitMessage6'){
    			$selected = true;
    			return view('about.recruitMessage6',['selected13'=>$selected]);
    		}
			if($type == 'recruitMessage7'){
    			$selected = true;
    			return view('about.recruitMessage7',['selected14'=>$selected]);
    		}
			if($type == 'recruitMessage8'){
    			$selected = true;
    			return view('about.recruitMessage8',['selected15'=>$selected]);
    		}
			if($type == 'recruitMessage9'){
    			$selected = true;
    			return view('about.recruitMessage9',['selected16'=>$selected]);
    		}
			if($type == 'recruitMessage10'){
    			$selected = true;
    			return view('about.recruitMessage10',['selected17'=>$selected]);
    		}
			if($type == 'recruitMessage11'){
    			$selected = true;
    			return view('about.recruitMessage11',['selected18'=>$selected]);
    		}
			if($type == 'recruitMessage12'){
    			$selected = true;
    			return view('about.recruitMessage12',['selected19'=>$selected]);
    		}
    		if($type == 'recruitMessage13'){
    			$selected = true;
    			return view('about.recruitMessage13',['selected13'=>$selected]);
    		}
    		if($type == 'download'){
    		    $selected = true;
    		    return view('about.downLoad',['selected13'=>$selected]);
    		}
    	}
        
        /**
         *   常用问题分类
         */
        public function questionHelp($type){
            //$type = Input::get('type');
            /**************  用户手册  start  *************/
            
            //  注册与登陆
            if($type == 'usehelp'){
                return view('about.userLogin',['click'=>1]);
            }
            if($type == 'userPerm'){
                return view('about.userPerm',['click'=>2]);
            }
            if($type == 'userEsHouse'){
                return view('about.userEsHouse',['click'=>3]);
            }
            if($type == 'userEstate'){
                return view('about.userEstate',['click'=>4]);
            }
            if($type == 'userTool'){
                return view('about.userTool',['click'=>5]);
            }
            /**************  用户手册  end  *************/
            
            /*********** 经纪人手册  start  *************/
            if($type == 'brokerManual'){
                return view('about.brokerManual',['click'=>6]);
            }
            if($type == 'houseRelease'){
                return view('about.houseRelease',['click'=>7]);
            }
            
            /*********** 经纪人手册  end    *************/
            
            if($type == 'safeNum'){
                return view('about.safeNum',['click'=>8]);
            }
            
        }

	//推广
	public function spread(){
		$GLOBALS['current_listurl'] = config('session.domain');
		return view('ad.spreadDetail');
	}
	//商务合作
	public function businessCooperation(){
		$GLOBALS['current_listurl'] = config('session.domain');
		return view('about.businessCooperation');
	}
}