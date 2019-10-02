<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
	//
	protected $table = 'project__team_member';

	protected $primaryKey = 'id';

	public $timestamps = false;

	protected $fillable = [
		'project_list_id',
		'user_id'
	];

	public function project(){
		return $this->belongsTo('App\Http\Models\Project','id','project_list_id');
	}

	public function detail_member(){
		return $this->hasOne('App\User','id','user_id');
	}

}
