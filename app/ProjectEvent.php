<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectEvent extends Model
{
    //
    protected $table = 'project__event';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'project_list_id',
		'name',
		'start_date',
		'due_date',
		'finish_date',
		'note',
		'status'
	];

	public function project(){
		return $this->belongsTo('App\Project','project_list_id','id');
	}

	public function history_event(){
		return $this->hasMany('App\ProjectHistory','project_event_id','id');
	}
}
