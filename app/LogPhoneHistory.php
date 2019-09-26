<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPhoneHistory extends Model
{
    //
    protected $table = 'log_phone__history';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_asterisk',
		'eventtype',
		'eventtime',
		'cid_num',
		'cid_name'
	];
}
