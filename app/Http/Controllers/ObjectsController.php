<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Objects\ObjectsRepository;

class ObjectsController extends Controller
{
    /**
     * @var ObjectsRepository
     */
    protected $objects_repository;

    public function __construct(ObjectsRepository $objects)
    {
        $this->objects_repository = $objects;
    }

	/**
     * get all objects
	 */
	public function getObjects(Request $request)
	{
		$places = $this->objects_repository->getAllObjects();
        return response()->json($places); 
	}

    /**
     * get object data by id
     * @param  mixed  $id_place
     */
    public function getObjectById($id_place)
    {
        $places = $this->objects_repository->getObjectById($id_place);
        return response()->json($places); 
    }
}
