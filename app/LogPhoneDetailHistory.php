<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPhoneDetailHistory extends Model
{
    //
    protected $table = 'log_phone__detail_history';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_detail',
		'id_history',
		'updated'
	];

	public function history()
	{
		return $this->hasOne('App\LogPhoneHistory','id','id_history');
	}
}
