<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Objects as Objects;

class ObjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Method: index()
     *
     * Rendering the OBJECTS page with all needed data
     * page: /objekte
     * 
     * - objects = all objects
     * - cities  = all cities from objects
     */
    public function index(Request $request)
    {
        $objectName = $request->input('name');

        if($objectName){
            $objects = Objects::getAllObjectsWithName($objectName);
        } else {
            $objects = Objects::getActiveObjects();
        }

        $niederlassungen = Objects::getBranches();
        foreach($niederlassungen as $niederlassung){
            $cities[] = Objects::getCities($niederlassung->niederlassung);
        }

        $data = [
            'objects' => $objects,
            'cities' => $cities,
        ];

        return view('objects', $data);
    }

    /**
     * Method: getObjectInfo()
     *
     * Rendering the OBJECTS page with all needed data
     * page: /service/getObjectInfo
     * 
     * - objects = all objects
     * - cities  = all cities from objects
     */
    public function getObjectInfo(Request $request)
    {
        $objectId = $request->input('objectId');
        $object = Objects::showObject($objectId);

        return json_encode($object);
    }

    public function getObjectsByBranch(Request $request)
    {
        $branch = $request->input('branch');
        return Objects::getObjectsByBranch($branch);
    }

    public function getAllObjectsByCity(Request $request)
    {
        $city = $request->input('city');
        return Objects::getAllObjectsByCity($city);
    }

    public function getAllObjectsWithName(Request $request)
    {
        $name = $request->input('name');
        return Objects::getAllObjectsWithName($name);
    }

    public function getObjectWithId(Request $request)
    {
        $objectId = $request->input('objectId');
        return Objects::getObjectWithId($objectId);
    }

    public function getAllObjects()
    {
        return Objects::getActiveObjects();
    }

    public function updateObjectStatus(Request $request) 
    {
        $objectId = $request->input('id');
        $objectStatus = $request->input('status');

        return Objects::updateObjectStatus($objectId, $objectStatus);

    }   

    public function updateObject(Request $request) 
    {
        $data = array(
            "id" => $request->input('objectId'),
            "name" => $request->input('objectName'),
            "strasse" => $request->input('objectStrasse'),
            "plz" => $request->input('objectPLZ'),
            "stadt" => $request->input('objectStadt'),
            "niederlassung" => $request->input('objectNiederlassung'),
            "objekt" => $request->input('objectObjekt'),
            "datum" => $request->input('objectDatum'),
            "pdf" => $request->file('objectPDF'),
        );

        Objects::updateObject($data);

        return back();
    }   

    public function removeObject(Request $request) 
    {
        $data = array(
            'objectId' => $request->get('objectId'),
        );

        Objects::removeObject($data);  

        return true;
    }   

    public function addObject(Request $request) 
    {
        $objectNiederlassung = $request->input('objectNiederlassung');
        if($objectNiederlassung == 'Frankfurt'){
            $objectNiederlassung = 'Rhein-Main';
        }

        $data = array(
            'objectName' => $request->input('objectName'),
            'objectStrasse' => $request->input('objectStrasse'),
            'objectPLZ' => $request->input('objectPLZ'),
            'objectStadt' => $request->input('objectStadt'),
            'objectNiederlassung' => $objectNiederlassung,
            'objectObjekt' => $request->input('objectObjekt'),
            'objectStatus' => 1,
            'objectFile' => $request->file('objectFile'),
            'objectDatum' => $request->input('objectDatum'),
        );

        Objects::addObject($data);  

        return back();
    } 
}
