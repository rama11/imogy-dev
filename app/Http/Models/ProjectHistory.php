<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHistory extends Model
{
    //
    protected $table = 'project__event_history';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'project_event_id',
		'time',
		'note',
		'type',
		'updater'
	];

	public function event(){
		return $this
		->belongsTo('App\Http\Models\ProjectEvent','project_event_id','id');
		
	}

	public function project(){
		return $this
		->hasOne('App\Http\Models\ProjectEvent','id','project_event_id');
		// ->join('project__list','project__event.project_list_id','=','project__list.id');
		// return $this;

		// return $this->hasManyThrough(
		// 	'App\Http\Models\Project',
		// 	'App\Http\Models\ProjectEvent',
		// 	'project_list_id',
		// 	'id',
		// 	'id',
		// 	'id'
		// );
	}
}
