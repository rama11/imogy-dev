<?php

namespace App;

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

	public function project(){
		return $this
		->belongsTo('App\ProjectEvent','project_event_id','id')
		->join('project__list','project__event.project_list_id','=','project__list.id');
		// return $this;
	}
}
