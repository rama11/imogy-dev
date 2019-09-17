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
		return $this->belongsTo('App\ProjectEvent','project_list_id','id');
	}
}
