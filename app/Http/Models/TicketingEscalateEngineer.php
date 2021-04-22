<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TicketingEscalateEngineer extends Model
{
    //
    protected $table = 'ticketing__escalate_engineer';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_ticket ',
		'engineer_name',
		'engineer_contact',
		'rca',
		'date_add',
		'status',
	];
}
