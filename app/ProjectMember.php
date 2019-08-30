<?php

namespace App;

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
		return $this->belongsTo('App\Project','id','project_list_id');
	}

}
