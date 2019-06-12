<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Objects\ObjectsRepository;

class ObjectsController extends Controller
{
    /**
     * @var ObjectsRepository
     */
    protected $objectsRepository;

    public function __construct(ObjectsRepository $objects)
    {
        $this->objectsRepository = $objects;
    }

    /**
     * get all objects
     *
     * @param Illuminate\Http\Request $request
     * @return string
     */
    public function getObjects(Request $request)
    {
        $objects = $this->objectsRepository->getAllObjects();
        return response()->json($objects); 
    }

    /**
     * get object data by id
     *
     * @param  mixed  $idPlace
     * @return string
     */
    public function getObjectById($idPlace)
    {
        $places = $this->objectsRepository->getObjectById($idPlace);

        if(empty($places)){
            return response()->json('object was not found', 404); 
        }else{
            return response()->json($places);     
        }
    }
}
