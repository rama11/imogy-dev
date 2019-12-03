<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetNote extends Model
{
    //
    protected $table = 'budget__note';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'id_account',
		'date',
		'document',
		'issuer',
		'purpose',
		'detail',
		'nominal',
		'procced'
	];

	public function account_note(){
		return $this->hasOne('App\Http\Models\BudgetAccount','id','id_account');
	}
}
