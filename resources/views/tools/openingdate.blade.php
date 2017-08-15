

@extends('mainlayout',['nojquery'=>"true"])
@section('title')
    <title>【开盘日历，新房开盘日期】-搜房网</title>
    <meta name="keywords" content="开盘日历，新盘开盘日期"/>
    <meta name="description" content="搜房网，为您提供新的开盘的时期日历，让您时刻了解北京新盘动态。买房，租房，上搜房！"/>

     <style>

	body {

		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
		margin-top:40px;
		margin-bottom:40px;
	}

</style>
  


<link href='/css/fullcalendar.css' rel='stylesheet' />
<link href='/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/js/PageEffects/jquery.min.js'></script>
 <script src='/js/PageEffects/moment.min.js'></script>
 <script src='/js/PageEffects/fullcalendar.min.js'></script>
<script src='/js/PageEffects/lang-all.js'></script>
<link rel="stylesheet" type="text/css" href="/css/house_loan.css?v={{Config::get('app.version')}}">
@endsection
@section('content')

<div  id='calendar'></div>


<script type="text/javascript">

	$(document).ready(function() {
		var strData="{{$data}}";
		strData=strData.replace(/&quot;/g, "'");
		strData=strData.replace(/&amp;/g, "&");
		strData=eval('(' + strData + ')');
		$('#calendar').fullCalendar({
			lang: 'zh-cn',
			header: {
				left: 'prev,next today',
				center: 'title',
				//right: 'month,agendaWeek,agendaDay',
				right: '',
			},
			titleFormat:{
					month: 'YYYY年  MMMM', // September 2013
					week: "MMM d[ yyyy]{ '—'[ MMM] d YYYY}", // Sep 7 - 13 2013
					day: 'dddd, MMM d, YYYY', // Tuesday, Sep 8, 2013
			},
			defaultDate: "{{$default}}",
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events:strData
			// events: [
			// 	{
			// 		title: '楼盘开盘',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-01'
			// 	},

			// 	{
			// 		title: '楼盘开盘1',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-09'
			// 	},
			// 	{
			// 		title: '楼盘开盘2',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-09'
			// 	},
			// 	{
			// 		title: '楼盘开盘3',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-09'
			// 	},
			// 	{
			// 		title: '楼盘开盘4',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-09'
			// 	},
			// 	{
			// 		title: '楼盘开盘5',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-09'
			// 	},
			// 	{
			// 		id: 999,
			// 		title: '楼盘开盘',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-16'
			// 	},


			// 	{
			// 		title: '某某楼盘开盘',
			// 		url: 'http://114.113.144.236:9090/Details/DetailsBuilding_R/xfBuildDetail/xfBIndex.htm',
			// 		start: '2015-12-28'
			// 	}
			// ]
		});
//$('#prompt').css('display','none');
	});

</script>


<script src="/js/PageEffects/headNav.js?v={{Config::get('app.version')}}"></script>
@endsection