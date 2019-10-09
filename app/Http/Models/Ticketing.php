<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    //
    protected $table = 'ticketing__id';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_ticket',
		'id_client',
		'operator'
	];

	public function detail_ticket(){
		return $this->hasOne('App\Http\Models\TicketingDetail','id_ticket','id_ticket');
	}

	public function activity_ticket(){
		return $this->hasMany('App\Http\Models\TicketingActivity','id_ticket','id_ticket');
	}

	public function lastest_activity_ticket(){
		return $this->hasOne('App\Http\Models\TicketingActivity','id_ticket','id_ticket')
			->orderBy('id','DESC');
	}
}
