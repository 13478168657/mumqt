<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseSaleOldClickLog extends Model
{
	protected $connection = 'mysql_statistics';
	protected $table = 'housesaleoldclicklog';
	//protected $table = 'community_temp2';
	public $timestamps = false;
}
