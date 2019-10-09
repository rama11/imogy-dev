<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TicketingDetail extends Model
{
    //
    protected $table = 'ticketing__detail';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_ticket',
		'refrence',
		'pic',
		'contact_pic',
		'location',
		'problem',
		'serial_device',
		'id_atm',
		'note',
		'engineer',
		'ticket_number_3party',
		'reporting_time',
		'severity'
	];

	public function id_detail(){
		return $this->hasOne('App\Http\Models\Ticketing','id_ticket','id_ticket');
	}
}
