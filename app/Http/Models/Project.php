<?php

namespace App\Http\Models;

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
		return $this->hasMany('App\Http\Models\ProjectMember','project_list_id','id');
	}

	public function member_project_detail(){
		return $this
			->hasMany('App\Http\Models\ProjectMember','project_list_id','id')
			->join('project__member','project__team_member.user_id','=','project__member.id')
			->join('users','users.id','=','project__member.user_id');
	}

	public function customer_project(){
		return $this->hasOne('App\Http\Models\ProjectCustomer','id','project_customer');
	}

	public function coordinator_project(){
		// return $this->hasOne('App\Http\Models\ProjectEachMember','id','project_coordinator');
		return $this->hasManyThrough(
			'App\User',
			'App\Http\Models\ProjectEachMember',
			'id',
			'id',
			'project_coordinator',
			'user_id'
		);
	}

	public function leader_project(){
		return $this->hasManyThrough(
			'App\User',
			'App\Http\Models\ProjectEachMember',
			'id',
			'id',
			'project_leader',
			'user_id'
		);
	}

	public function last_event_project(){
		return $this->hasOne('App\Http\Models\ProjectEvent','project_list_id','id')->orderBy('id','DESC');
	}

	public function event_project(){
		return $this->hasMany('App\Http\Models\ProjectEvent','project_list_id','id');
	}

	public function latest_event_project(){
		return $this->hasMany('App\Http\Models\ProjectEvent','project_list_id','id');
	}

	public function history_project(){
		return $this->hasManyThrough(
			'App\Http\Models\ProjectHistory',
			'App\Http\Models\ProjectEvent',
			'project_list_id',
			'project_event_id',
			'id',
			'id'
		);
	}

	public function latest_history_project(){
		return $this->hasManyThrough(
			'App\Http\Models\ProjectHistory',
			'App\Http\Models\ProjectEvent',
			'project_list_id',
			'project_event_id',
			'id',
			'id'
		)->orderBy('time','DESC')->limit(1);
	}
}
