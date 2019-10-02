<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEachMember extends Model
{
    //
    protected $table = 'project__member';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	protected $fillable = [
		'user_id',
		'nickname',
		'position'
	];
}
