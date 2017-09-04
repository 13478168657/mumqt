<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityStatusTo extends Model
{
	protected $connection = 'mysql_statistics';
	protected $table = 'communitystatus2';
	//protected $table = 'community_temp2';
	public $timestamps = false;
}
