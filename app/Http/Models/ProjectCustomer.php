<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCustomer extends Model
{
    //
    protected $table = 'project__customer';

	protected $primaryKey = 'id';

	public $timestamps = false;

	protected $fillable = [
		'name',
		'acronym'
	];
	
}
