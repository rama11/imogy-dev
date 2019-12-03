<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetActivity extends Model
{
    //
    protected $table = 'budget__activity';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_note',
		'date',
		'activity',
		'note',
		'updater'
	];
}
