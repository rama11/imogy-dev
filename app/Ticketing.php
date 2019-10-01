<?php

namespace App;

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

	public function detail(){
		return $this->hasOne('App\TicketingDetail','id_ticket','id_ticket');
	}
}
