<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TicketingActivity extends Model
{
    //
    protected $table = 'ticketing__activity';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_ticket',
		'date',
		'activity',
		'operator',
		'note'
	];

	// public function detail_activity()	{
	// 	return $this->hasOne('App\Http\Models\TicketingDetail','id_ticket','id_ticket');
	// }

	public function id_activity()	{
		return $this->belongsTo('App\Http\Models\Ticketing','id_ticket','id_ticket');
	}
}
