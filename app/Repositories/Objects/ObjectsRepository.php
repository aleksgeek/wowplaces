<?php
namespace App\Repositories\Objects;

use App\Models\ObjectsList;

class ObjectsRepository
{
	/**
     * get all objects
     *
     * @return array
	 */
	public function getAllObjects()
	{
		return ObjectsList::all();
	}

    /**
     * get object data by id
     *
     * @param  mixed $id
     * @return array
     */
	public function getObjectById($id)
	{
        return ObjectsList::where('id', $id)->first();
	}	
}