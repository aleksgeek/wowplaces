<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectTypes extends Model
{
    protected $table = 'object_types';

    public function placesList()
    {
        return $this->belongsTo('App\Models\PlacesList', 'id_object_type', 'id');
    }
}
