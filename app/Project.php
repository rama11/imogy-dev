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

	public function member_project_detail(){
		return $this->belongsToMany('App\User','project__team_member','project_list_id','user_id');
	}

	public function customer_project(){
		return $this->hasOne('App\ProjectCustomer','id','project_customer');
	}

	public function coordinator_project(){
		// return $this->hasOne('App\ProjectEachMember','id','project_coordinator');
		return $this->hasManyThrough(
			'App\User',
			'App\ProjectEachMember',
			'id',
			'id',
			'project_coordinator',
			'user_id'
		);
	}

	public function leader_project(){
		return $this->hasManyThrough(
			'App\User',
			'App\ProjectEachMember',
			'id',
			'id',
			'project_leader',
			'user_id'
		);
	}

	public function event_project(){
		return $this->hasMany('App\ProjectEvent','project_list_id','id');
	}

	public function history_project(){
		return $this->hasManyThrough(
			'App\ProjectHistory',
			'App\ProjectEvent',
			'project_list_id',
			'project_event_id',
			'id',
			'id'
		);
	}
}
