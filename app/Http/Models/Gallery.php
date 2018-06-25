<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
	public function getAllImages()
	{
		setlocale (LC_TIME, 'German', 'de_DE', 'deu');

		$gallery = DB::table('gallery')->paginate(15);

		return $gallery;
	}

	public function getImagesByLocation($location)
	{
		setlocale (LC_TIME, 'German', 'de_DE', 'deu');

		$gallery = DB::table('gallery')->where('description', 'like', '%'.$location.'%')->paginate(15);

		return $gallery;
	}

	public function getImagesDateByLocation($location)
	{
		setlocale (LC_TIME, 'German', 'de_DE', 'deu');

		$gallery = DB::table('gallery')->select('date')->where('description', 'like', '%'.$location.'%')->first();

		return $gallery;
	}

	public function getLastAddedImages()
	{
		$gallery = DB::table('gallery')->orderBy('updated_at')->take(4)->get();

		return $gallery;
	}

	public function storeAllImages($images)
	{
		$name = 'Weihnachtsfeier';
		foreach($images as $image){
			$pos = strpos($image, '/');
			$desc1 = substr($image, 0, $pos);
			$description = 'Weihnachtsfeier-'.ucfirst($desc1);
			$pfad = $image;
			DB::table('gallery')->insert([
				'name' => $name,
				'description' => $description,
				'pfad' => '/images/gallery/'.$image,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			]);
		}
	}
}