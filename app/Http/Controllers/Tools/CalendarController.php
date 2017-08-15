<?php 

namespace App\Http\Controllers\Tools;

use App\Dao\Tools\CalendarDao;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;

define("CATCHPRE", 'Calendar'); 
class CalendarController extends Controller {

	public function showCalendar()
	{
		$cityid=CURRENT_CITYID;
		$beginDate=date('Ym',strtotime('-6 month'));

		$catchKey=CATCHPRE.'_'.$cityid.'_'.$beginDate;

		$data='';
		// if (Cache::has($catchKey))
		// {
		// 	$data=Cache::get($catchKey);
		// }else
		// {
			$calendObj=new CalendarDao();
			$comDates=$calendObj->getNewCommunityInfo($cityid,$beginDate);

			$returnData=array();

			foreach ($comDates as $item) {
				$_title=$item->name.$item->period.'期';
				$_url='/xinfindex?communityId='.$item->communityId.'&type2='.$item->type2;
				$_start=substr($item->openTime,0,10);
			//$returnData[]=["title"=>$_title,"url"=>$_url,"start"=>$_start];

				array_push($returnData,['title'=>$_title,'url'=>$_url,'start'=>$_start]);
			}
			$data = json_encode($returnData);
		// 	Cache::put($catchKey, $data, 60*24);
		// }
		
		//dd($data);
		return view('tools.openingdate',['default'=>Date('Y-m-d',time()),'data'=>$data]);
		
		// var_dump($comDates);
		// exit();

	}


}

?>