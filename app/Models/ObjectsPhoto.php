<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectsPhoto extends Model
{
    public function objectsList()
	{
		return $this->belongsTo('App\Models\ObjectsList', 'id', 'object_id');
	}
}
