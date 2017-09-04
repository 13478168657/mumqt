<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CitystatusTo extends Model
{
	protected $connection = 'mysql_statistics';
	protected $table = 'citystatus2';
	//protected $table = 'community_temp2';
	public $timestamps = false;
}
