<?php

namespace App\Http\Controllers;

use App\Http\Models\Objects;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $objectName = $request->input('name');

        $objectsModel = new Objects();
        if($objectName){
            $objects = $objectsModel->getAllObjectsWithName($objectName);
        } else {
            $objects = $objectsModel->getActiveObjects();
        }

        $niederlassungen = $objectsModel->getBranches();
        foreach($niederlassungen as $niederlassung){
            $cities[] = $objectsModel->getCities($niederlassung->niederlassung);
        }

        $data = array(
            'objects' => $objects,
            'cities' => $cities,
        );

        return view('objects', $data);
    }

    public function getObjectInfo(Request $request)
    {
        $serviceModel = new Objects();

        $objectId = $request->input('objectId');

        $object = $serviceModel->showObject($objectId);

        return json_encode($object);
    }

    public function getObjectsByBranch(Request $request)
    {
        $objectsModel = new Objects();

        $branch = $request->input('branch');

        return $objectsModel->getObjectsByBranch($branch);
    }

    public function getAllObjectsByCity(Request $request)
    {
        $objectsModel = new Objects();

        $city = $request->input('city');

        return $objectsModel->getAllObjectsByCity($city);
    }

    public function getAllObjectsWithName(Request $request)
    {
        $objectsModel = new Objects();

        $name = $request->input('name');

        return $objectsModel->getAllObjectsWithName($name);
    }

    public function getObjectWithId(Request $request)
    {
        $objectsModel = new Objects();

        $objectId = $request->input('objectId');

        return $objectsModel->getObjectWithId($objectId);
    }

    public function getAllObjects()
    {
        $objectsModel = new Objects();

        return $objectsModel->getActiveObjects();
    }

    public function updateObjectStatus(Request $request) 
    {
        $objectModel = new Objects();

        $objectId = $request->input('id');
        $objectStatus = $request->input('status');

        return $objectModel->updateObjectStatus($objectId, $objectStatus);

    }   

    public function updateObject(Request $request) 
    {
        $objectModel = new Objects();

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

        $object = $objectModel->updateObject($data);

        return back();
    }   

    public function removeObject(Request $request) 
    {
        $objectModel = new Objects();

        $data = array(
            'objectId' => $request->get('objectId'),
        );

        $objectModel->removeObject($data);  

        return true;
    }   

    public function addObject(Request $request) 
    {
        $objectModel = new Objects();

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

        $objectModel->addObject($data);  

        return back();
    } 
}
