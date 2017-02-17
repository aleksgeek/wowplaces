<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectsList extends Model
{
	protected $table = 'objects_list';

    public function objectsPhoto()
	{
		return $this->hasMany('App\Models\ObjectsPhoto', 'object_id', 'id');
	}

	public function users()
	{
		return $this->hasOne('App\Models\Users', 'id', 'user_id');
	}

	public function objectTypes()
	{
		return $this->hasOne('App\Models\ObjectTypes', 'id', 'id_object_type');
	}
}
