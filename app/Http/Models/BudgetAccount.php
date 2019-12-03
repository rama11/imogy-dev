<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetAccount extends Model
{
    //
    protected $table = 'budget__account';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'PID',
		'customer',
		'project_name',
		'start',
		'end',
		'budget'
	];
}
