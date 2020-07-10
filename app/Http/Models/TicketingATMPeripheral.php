<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TicketingATMPeripheral extends Model
{
    //
    protected $table = 'ticketing__atm_peripheral';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_atm',
		'id_peripheral',
		'type',
		'serial_number',
		'machine_type'
	];

	public function atm(){
		return $this->hasOne('App\Http\Models\TicketingATM','id','id_atm');
	}
}
