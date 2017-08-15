<?php
/* 全局函数 */

if(! function_exists('check_perm_fun')){
	/**
	 * 验证是否拥有功能权限
	 * @param	int		$permFuncId		功能权限id
	 * @return	bool
	 */
	function check_perm_fun($permFuncId){
		$permUtilObj = new App\Http\Controllers\Utils\PermUtil;
		return $permUtilObj->checkPermFunc($permFuncId, 2);
	}
}

if(! function_exists('check_perm_field')){
	/**
	 * 验证是否拥有字段权限
	 * @param 	int 	$permFieldId	字段权限id
	 * @param	int		$type			字段权限分类：0.可读可写 1.只读
	 * @return 	bool
	 */
	function check_perm_field($permFieldId, $type=0){
		$permUtilObj = new App\Http\Controllers\Utils\PermUtil;
		return $permUtilObj->checkPermField($permFieldId, $type);
	}
}

if(! function_exists('get_left_menu_position')){
	/**
	 * 根据当前地址获取左侧菜单栏对应地址
	 * @param string 	$type				当前位置，p或a，代表p标签或a标签
	 * @param string 	$this_position		当前位置对应的值，若type=p，则为p的id，若type=a，则为a的链接
	 */
	function get_left_menu_position($this_position, $type ){
// 		$url = mb_ereg_replace("\?.*", "", $url);
		$tmparr = parse_url($_SERVER['REQUEST_URI']);		//当前相对地址
		$this_url = $tmparr['path'];
		$this_url = mb_ereg_replace("(\/\d+([^/]*|(\/\d+){1,2})|[\/]?)$", "", $this_url);
		/* $url_arr = array(
				"/buildList" => ['p'=>'p_zengliangloupanku', 'a'=>'/buildList'],				//创建新楼盘
				"/addComm" => ['p'=>'p_zengliangloupanku', 'a'=>'/buildList'],					//创建新楼盘
				"/bindingBroker" => ["p"=>"p_zengliangloupanku", 'a'=>"/examine/via"],			//绑定经纪人
		); */
		$url_arr = config("leftMenuConfig");
		if(isset($url_arr[$this_url])){
			if($url_arr[$this_url][$type] == $this_position){
				if($type=='p'){
					return 'style=display:block;';
				}elseif($type=='a'){
					return 'class=onclick';
				}
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
}

if(!function_exists('get_img_url')){
	/**
	 * 获取图片完整地址
	 * @param 	string 	$objectType		object分类，可以根据分类获取bucket名称、路径
	 * @param 	string 	$filePath		文件相对路径
	 * @param 	string	$sizeType		图片尺寸分类
	 * @return Ambigous <boolean, \App\Http\Controllers\Utils\文件路径, string>
	 */
	function get_img_url($objectType='', $filePath='', $sizeType=''){
		if(empty(trim($filePath)) || empty($objectType)){
			return '';
		}
		/* 临时修改start */
// 		$sizeType = '';//为了适应之前老版本图片没有配多尺寸图片，暂时所有图片都用原图
		/* 临时修改end */
		$filePath = trim($filePath);
		if(stripos($filePath, 'http')!==false){
			return $filePath;
		}else{
			$filePath = '/' . ltrim($filePath, '/');
		}
		$fileClient = new \App\Http\Controllers\SofangFileClient\SofangFileClientController();
		return $fileClient->getObjectPath($objectType, $filePath, $sizeType);
	}
}

if(!function_exists('get_broker_by_binding')){
	/**
	 * 根据经纪人绑定楼盘信息获取对应经纪人数据
	 * @param	int		$communityId		楼盘id
	 * @param	array	$brokerIds			经纪人id数组
	 * @return	obj
	 */
	function get_broker_by_binding($communityId, $brokerId=''){
		$brokerDao = new \App\Dao\User\BrokerDao();
		$brokerObj = $brokerDao->getBrokerByBinding($communityId, $brokerId);
		return $brokerObj;
	}
}

if(!function_exists('get_url_by_id')){
	/**
	 * @param $url  地址
	 * @param $par  参数代表的是字段名
	 * @param string $id  字段的id
	 * @return mixed|string
	 */
	function get_url_by_id($url,$par,$id=''){
		$n=strpos($url,'?');//寻找位置
		if ($n) $url=substr($url,0,$n);//删除后面

		$url = preg_replace('/bl[\w\|,]*/','bl1',$url);//默认为第一页
		if($par !='bl'){
			$url = preg_replace('/ba(\d)*/','',$url);//去除楼盘id
		}
		if($par =='aa'){
			$url = preg_replace('/ab[\w,]*/','',$url);//点击区域的不限,子区域也去掉
			$url = preg_replace('/ac[\w,]*/','',$url);//点击区域时,去除地铁的相关数据 适用于H5
			$url = preg_replace('/ad[\w,]*/','',$url);//点击区域时,去除地铁的相关数据 适用于H5
		}
		if($par =='ac'){
			$url = preg_replace('/ad[\w,]*/','',$url);//点击地铁的不限,地铁的站点也去掉
			$url = preg_replace('/aa[\w,]*/','',$url);//点击地铁时,去除区域的相关数据 适用于H5
			$url = preg_replace('/ab[\w,]*/','',$url);//点击地铁时,去除区域的相关数据 适用于H5
		}
		if($par =='ao'){
			$url = preg_replace('/bm[\w,]*/','',$url);//点击价格选择时,去掉输入框的条件
		}
		if($par =='ap'){
			$url = preg_replace('/bn[\w,]*/','',$url);//点击面积选择时,去掉输入框的条件
		}
		$urls = array();
		if(!empty($url)){
			$urls = explode('-',$url);
			foreach($urls as $k=>$v){
				if(empty($v)){
					unset($urls[$k]);
				}
			}
			$url = implode('-',$urls);
		}

		if(($par == 'bj'&& $id !=='')||($par == 'ax'&& $id !=='')||!empty($id)){
			$pbool = preg_match('/'.$par.'[\w\|,]*/',$url);
			if($pbool){
				$resurl = preg_replace('/'.$par.'[\w\|,]*/',$par.$id,$url);
			}else{
				array_push($urls,$par.$id);
				sort($urls);
				$resurl = implode('-',$urls);
			}
		}else{
			foreach($urls as $k=>$u){
				if(substr($u,0,2) == $par){
					unset($urls[$k]);
				}
			}
			$resurl = implode('-',$urls);
		}

		if($_SERVER['QUERY_STRING'] !=''){
			parse_str($_SERVER['QUERY_STRING'],$arr);
			if(array_key_exists("kw",$arr) || (array_key_exists("swlng",$arr)&&($par == 'bl'))){
				return $resurl.'?'.$_SERVER['QUERY_STRING'];
			}else{
				return $resurl;
			}
		}else{
			return $resurl;
		}

	}
}