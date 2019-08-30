<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	//
	protected $table = 'project__list';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'project_name',
		'project_pid',
		'project_customer',
		'project_start',
		'project_periode',
		'project_periode_duration',
		'project_coordinator',
		'project_leader'
	];

	public function member_project(){
		return $this->hasMany('App\ProjectMember','project_list_id','id');
	}
}
