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

	public function activity_note(){
		return $this->hasMany('App\Http\Models\BudgetActivity','id_note','id');
	}

	public function latest_activity_note(){
		return $this->hasMany('App\Http\Models\BudgetActivity','id_note','id')
			->orderBy('budget__activity.id','DESC')->limit(1);;
	}
}
