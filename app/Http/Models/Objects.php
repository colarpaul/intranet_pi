<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Helpers\Helper as Helper;

class Objects extends Model
{
	public static function getObjects()
	{
		return DB::table('objects')->orderBy('updated_at', 'desc')->paginate(15);
	}

	public static function getActiveObjects()
	{
		return DB::table('objects')->where('status', 1)->orderBy('objekt', 'asc')->get();
	}

	// TODO: Find another name
	public static function getBranches()
	{
		return DB::table('objects')->select('niederlassung')->where('status', 1)->groupBy('niederlassung')->get();
	}

	public static function getObjectsByKey($key)
	{
		return DB::table('objects')
		->where('name', 'like', '%'.$key.'%')
		->orWhere('strasse', 'like', '%'.$key.'%')
		->orWhere('plz', 'like', '%'.$key.'%')
		->orWhere('stadt', 'like', '%'.$key.'%')
		->orWhere('niederlassung', 'like', '%'.$key.'%')
		->orWhere('objekt', 'like', '%'.$key.'%')
		->get();
	}

	public static function getCities($niederlassung)
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

	public static function getLastAddedObjects()
	{
		return DB::table('objects')->where('status', 1)->orderBy('updated_at', 'desc')->take(6)->get();
	}

	public static function getObjectsByBranch($branch)
	{
		return DB::table('objects')->where('status', 1)->where('niederlassung', $branch)->orderBy('objekt', 'asc')->get();
	}

	public static function getAllObjectsByCity($city)
	{
		return DB::table('objects')->where('status', 1)->where('stadt', $city)->orderBy('objekt', 'asc')->get();
	}

	public static function getAllObjectsWithName($name)
	{
		return DB::table('objects')
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
	}

	public static function getObjectWithId($id)
	{
		return DB::table('objects')->where('status', 1)->where('id', $id)->orderBy('objekt', 'asc')->get();
	}

	public static function showObject($id)
	{
		return DB::table('objects')->where('id', $id)->get()->first();
	}

	public static function updateObjectStatus($objectId, $objectStatus) 
	{
		DB::table('objects')
		->where('id', $objectId)
		->update([
			'status' => $objectStatus, 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	

	public static function updateObject($data) 
	{
		if($data['pdf']){
			$documentOriginalName = $data['pdf']->getClientOriginalName();
			$pathParts = pathinfo($documentOriginalName);
			$documentExtension = $pathParts['extension'];
			$documentFullName = Helper::transformGermanChars(preg_replace('/\s+/', '', $data['name'].'.'.$documentExtension));
			$documentPfad = Helper::transformGermanChars(preg_replace('/\s+/', '', '/documents/pdf/'.$documentFullName));

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

	public static function removeObject($data) 
	{
		DB::table('objects')->where('id', $data['objectId'])->delete();
	}
	
	public static function addObject($data) 
	{
		$objectOriginalName = $data['objectFile']->getClientOriginalName();
		$pathParts = pathinfo($objectOriginalName);
		$objectExtension = $pathParts['extension'];
		$objectFullName = Helper::transformGermanChars(preg_replace('/\s+/', '', $data['objectName'].'.'.$objectExtension));
		$objectPfad = Helper::transformGermanChars(preg_replace('/\s+/', '', '/documents/objects/'.$objectFullName));

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
}