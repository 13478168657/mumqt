<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseSaleNewClickLog extends Model
{
	protected $connection = 'mysql_statistics';
	protected $table = 'housesalenewclicklog';
	//protected $table = 'community_temp2';
	public $timestamps = false;
}
