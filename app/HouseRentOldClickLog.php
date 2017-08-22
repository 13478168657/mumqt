<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseRentOldClickLog extends Model
{
	protected $connection = 'mysql_statistics';
	protected $table = 'houserentoldclicklog';
	//protected $table = 'community_temp2';
	public $timestamps = false;
}
