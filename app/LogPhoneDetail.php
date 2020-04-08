<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPhoneDetail extends Model
{
    //
    protected $table = 'log_phone__detail';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'answered',
		'date',
		'discussion',
		'involved',
		'details'
	];

}
