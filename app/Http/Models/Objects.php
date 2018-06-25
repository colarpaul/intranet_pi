<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Objects extends Model
{
	public function getObjects()
	{
		$objects = DB::table('objects')->orderBy('updated_at', 'desc')->paginate(15);

		return $objects;
	}

	public function getActiveObjects()
	{
		$objects = DB::table('objects')->where('status', 1)->orderBy('objekt', 'asc')->get();

		return $objects;
	}

	// TODO: Find another name
	public function getBranches()
	{
		$niederlassungen = DB::table('objects')->select('niederlassung')->where('status', 1)->groupBy('niederlassung')->get();

		return $niederlassungen;
	}

	public function getObjectsByKey($key){
		return DB::table('objects')
		->where('name', 'like', '%'.$key.'%')
		->orWhere('strasse', 'like', '%'.$key.'%')
		->orWhere('plz', 'like', '%'.$key.'%')
		->orWhere('stadt', 'like', '%'.$key.'%')
		->orWhere('niederlassung', 'like', '%'.$key.'%')
		->orWhere('objekt', 'like', '%'.$key.'%')
		->get();

	}

	public function getCities($niederlassung)
	{
		$cities = DB::table('objects')
		->select(DB::raw('GROUP_CONCAT(DISTINCT stadt) as cities, niederlassung'))
		->where('niederlassung', $niederlassung)
		->where('status', 1)
		->groupBy('niederlassung')
		->get();

		$cities = array(
			'niederlassung' => $cities[0]->niederlassung,
			'cities' => explode(",", $cities[0]->cities),
		);

		return $cities;
	}

	public function getLastAddedObjects()
	{
		$objects = DB::table('objects')->where('status', 1)->orderBy('updated_at', 'desc')->take(6)->get();

		return $objects;
	}

	public function getObjectsByBranch($branch)
	{
		if($branch != ''){
			$objects = DB::table('objects')->where('status', 1)->where('niederlassung', $branch)->orderBy('objekt', 'asc')->get();
		} else {
			$objects = DB::table('objects')->where('status', 1)->orderBy('objekt', 'asc')->get();
		}

		return $objects;
	}

	public function getAllObjectsByCity($city)
	{
		if($city != ''){
			$objects = DB::table('objects')->where('status', 1)->where('stadt', $city)->orderBy('objekt', 'asc')->get();
		} else {
			$objects = DB::table('objects')->where('status', 1)->orderBy('objekt', 'asc')->get();
		}

		return $objects;
	}

	public function getAllObjectsWithName($name)
	{
		$objects = DB::table('objects')
		->where([
			['status', '=', 1],
			['name', 'like', '%'.$name.'%'],
		])
		->orWhere([
			['status', '=', 1],
			['strasse', 'like', '%'.$name.'%'],
		])
		->orWhere([
			['status', '=', 1],
			['stadt', 'like', '%'.$name.'%'],
		])
		->orWhere([
			['status', '=', 1],
			['niederlassung', 'like', '%'.$name.'%'],
		])
		->orWhere([
			['status', '=', 1],
			['objekt', 'like', '%'.$name.'%'],
		])
		->orderBy('objekt', 'asc')->get();

		return $objects;
	}

	public function getObjectWithId($id)
	{
		$objects = DB::table('objects')->where('status', 1)->where('id', $id)->orderBy('objekt', 'asc')->get();

		return $objects;
	}

	public function showObject($id)
	{
		return DB::table('objects')->where('id', $id)->get()->first();
	}


	/**
	 * Update a object status
	 * 
	 * @return array
	 */
	public function updateObjectStatus($objectId, $objectStatus) 
	{
		DB::table('objects')
		->where('id', $objectId)
		->update([
			'status' => $objectStatus, 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	


	/**
	 * Update a object status
	 * 
	 * @return array
	 */
	public function updateObject($data) 
	{
		if($data['pdf']){
			$documentOriginalName = $data['pdf']->getClientOriginalName();
			$pathParts = pathinfo($documentOriginalName);
			$documentExtension = $pathParts['extension'];
			$documentFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $data['name'].'.'.$documentExtension));
			$documentPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/pdf/'.$documentFullName));

			Storage::disk('public_uploads')->putFileAs('', $data['pdf'], $documentFullName);

			DB::table('objects')
			->where('id', $data['id'])
			->update([
				'pfad' => $documentPfad,
			]);
		}

		DB::table('objects')
		->where('id', $data['id'])
		->update([
			'name' => $data['name'], 
			'strasse' => $data['strasse'], 
			'plz' => $data['plz'], 
			'stadt' => $data['stadt'], 
			'niederlassung' => $data['niederlassung'], 
			'objekt' => $data['objekt'], 
			'datum' => $data['datum'], 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	

	/**
	 * Add a subcategory
	 * 
	 * @return array
	 */
	public function removeObject($data) 
	{
		DB::table('objects')->where('id', $data['objectId'])->delete();
	}

	/**
	 * Add a document
	 * 
	 * @return array
	 */
	public function addObject($data) 
	{
		$objectOriginalName = $data['objectFile']->getClientOriginalName();
		$pathParts = pathinfo($objectOriginalName);
		$objectExtension = $pathParts['extension'];
		$objectFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $data['objectName'].'.'.$objectExtension));
		$objectPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/objects/'.$objectFullName));

		Storage::disk('public_objects_uploads')->putFileAs('', $data['objectFile'], $objectFullName);

		DB::table('objects')->insert([
			'name' => $data['objectName'],
			'strasse' => $data['objectStrasse'],
			'plz' => $data['objectPLZ'],
			'stadt' => $data['objectStadt'],
			'niederlassung' => $data['objectNiederlassung'],
			'objekt' => $data['objectObjekt'],
			'pfad' => $objectPfad,
			'status' => $data['objectStatus'],
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			'datum' => $data['objectDatum'],
		]);
	}

	// CREATE NEW FOLDER WITH HELPER FUNCTIONS !!!
	function transformGermanChars($string)
	{
		$string = str_replace("ä", "ae", $string);
		$string = str_replace("ü", "ue", $string);
		$string = str_replace("ö", "oe", $string);
		$string = str_replace("Ä", "Ae", $string);
		$string = str_replace("Ü", "Ue", $string);
		$string = str_replace("Ö", "Oe", $string);
		$string = str_replace("ß", "ss", $string);
		$string = str_replace("´", "", $string);
		return $string;
	}	
}