<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;

class News extends Model
{
	public function getNews($paginate = null){

		if($user = Auth::user()){
			if($paginate){
				$news = DB::table('news')
				->where('publish', 1)
				->orderBy('sortable', 'asc')
				->paginate($paginate);
			} else {
				$news = DB::table('news')
				->where('publish', 1)
				->orderBy('sortable', 'asc')
				->get();
			}
		} else {
			if($paginate){
				$news = DB::table('news')
				->where('publish', 1)
				->orderBy('sortable', 'asc')
				->paginate($paginate);
			} else {
				$news = DB::table('news')
				->where('publish', 1)
				->orderBy('sortable', 'asc')
				->get();
			}
		}

		return $news;
	}

	public function getNewsByKey($key){
		$news = DB::table('news')
		->where('news_art', 'like', '%'.$key.'%')
		->orWhere('titel', 'like', '%'.$key.'%')
		->orWhere('untertitel', 'like', '%'.$key.'%')
		->orWhere('meldung', 'like', '%'.$key.'%')
		->orWhere('bild_unter', 'like', '%'.$key.'%')
		->orWhere('pin_google', 'like', '%'.$key.'%')
		->orWhere('pdf_button_name', 'like', '%'.$key.'%')
		->orWhere('web_button_name', 'like', '%'.$key.'%')
		->orderBy('sortable', 'asc')
		->get();

		return $news;
	}

	public function getNewsCMS($paginate = null){
		if($paginate){
			$news = DB::table('news')
			->orderBy('sortable', 'asc')
			->paginate($paginate);
		} else {
			$news = DB::table('news')
			->orderBy('sortable', 'asc')
			->get();
		}

		return $news;
	}

	public function getNewsSortable(){
		$news = DB::table('news')
		->orderBy('sortable', 'asc')
		->get();

		return $news;
	}

	public function getNewsCategories(){
		$newsCategories = DB::table('news')
		->select('news_art')
		->groupBy('news_art')
		->orderBy('news_art', 'asc')
		->get();

		return $newsCategories;
	}

	public function getHomeNews(){
		return DB::table('news')
		->orderBy('sortable', 'asc')
		->where('home_publish', 1)
		->where('publish', 1)
		->take(4)
		->get();
	}

	public function getNewsArt(){
		return DB::table('news')
		->select('news_art')
		->orderBy('news_art', 'asc')
		->groupBy('news_art')
		->get();
	}

	public function getAllNews($limit = null){
		
		if($limit){
			$news = DB::table('news')
			->orderBy('sortable', 'asc')
			->take($limit)
			->get();
		} else {
			$news = DB::table('news')
			->orderBy('sortable', 'asc')
			->get();
		}

		return $news;
	}

	public function showNews($id)
	{
		if(is_numeric($id))
		{
			$news = DB::table('news')->where('id', $id)->get()->first();

			if($news->publish == 0){
				if($user = Auth::user()){
					return $news;
				}
			} else {
				return $news;
			}
		}
		else {
			$news = DB::table('news')->where('news_art', $id)->orderBy('datum', 'desc')->paginate(5);
		}

		return $news;
	}

	/**
	 * Add news
	 * 
	 * @return array
	 */
	public function addNews($data) 
	{
		if($data['newsPDF']){
			$newsOriginalPDFName = $data['newsPDF']->getClientOriginalName();
			$pathPDFParts = pathinfo($newsOriginalPDFName);
			$newsPDFExtension = $pathPDFParts['extension'];
			$newsPDFFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $data['newsTitel'].'.'.$newsPDFExtension));
			$newsPDFPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsPDFFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['newsPDF'], $newsPDFFullName);
		}

		if($data['newsBild']){
			$newsOriginalBildName = $data['newsBild']->getClientOriginalName();
			$pathBildParts = pathinfo($newsOriginalBildName);
			$newsBildExtension = $pathBildParts['extension'];
			$newsBildFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalBildName));
			$newsBildPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsBildFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['newsBild'], $newsBildFullName);
		}

		if($data['newsTeaser']){
			$newsOriginalTeaserName = $data['newsTeaser']->getClientOriginalName();
			$pathTeaserParts = pathinfo($newsOriginalTeaserName);
			$newsTeaserExtension = $pathTeaserParts['extension'];
			$newsTeaserFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalTeaserName));
			$newsTeaserPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsTeaserFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['newsTeaser'], $newsTeaserFullName);
		}

		if($data['newsWallpaper']){
			$newsOriginalWallpaperName = $data['newsWallpaper']->getClientOriginalName();
			$pathWallpaperParts = pathinfo($newsOriginalWallpaperName);
			$newsWallpaperExtension = $pathWallpaperParts['extension'];
			$newsWallpaperFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalWallpaperName));
			$newsWallpaperPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsWallpaperFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['newsWallpaper'], $newsWallpaperFullName);
		}

		DB::table('news')->insert([
			'news_art' => $data['newsArt'],
			'datum' => $data['newsDatum'],
			'objekte_id' => $data['newsObject'],
			'titel' => $data['newsTitel'],
			'untertitel' => $data['newsUntertitel'],
			'meldung' => $data['newsMeldung'],
			'bild_unter' => $data['newsBildUntertext'],
			//BILD
			'bild' => (!empty($newsBildPfad)) ? $newsBildPfad : '',
			'bild_teaser' => (!empty($newsTeaserPfad)) ? $newsTeaserPfad : '',
			'wallpaper_bild' => (!empty($newsWallpaperPfad)) ? $newsWallpaperPfad : '',
			//BUTTONS
			'pdf_button_url' => (!empty($newsPDFPfad)) ? $newsPDFPfad : '',
			'pdf_button_name' => $data['newsPDFName'],
			'web_button_url' => $data['newsWEB'],
			'web_button_name' => $data['newsWEBName'],
			//GOOGLE
			'latitude' => $data['newsLatitude'],
			'longitude' => $data['newsLongitude'],
			'pin_google' => $data['newsGooglePIN'],
			//YOUTUBE
			'youtube_url' => $data['newsYoutube'],
			//PUBLISHING LIVE
			'home_publish' => 0,
			'publish' => 0,
		]);
	}

	/**
	 * Remove news by a given id
	 * 
	 * @return array
	 */
	public function removeNews($data) 
	{
		DB::table('news')->where('id', $data['newsId'])->delete();
	}

	/**
	 * Update a object status
	 * 
	 * @return array
	 */
	public function updateNews($data) 
	{
		DB::table('news')
		->where('id', $data['id'])
		->update([
			'titel' => $data['titel'], 
			'datum' => $data['datum'], 
			'bild_unter' => $data['bild_unter'], 
			'untertitel' => $data['untertitel'], 
			'meldung' => $data['meldung'], 
			'web_button_url' => $data['web_button_url'], 
			'news_art' => $data['news_art'],
			'latitude' => $data['latitude'],
			'longitude' => $data['longitude'],
			'youtube_url' => $data['youtube'],
			'pin_google' => $data['pin_google'],
			'web_button_name' => $data['web_button_name'],
			'pdf_button_name' => $data['pdf_button_name'],
		]);

		if($data['wallpaper']){
			$newsOriginalWallpaperName = $data['wallpaper']->getClientOriginalName();
			$pathWallpaperParts = pathinfo($newsOriginalWallpaperName);
			$newsWallpaperExtension = $pathWallpaperParts['extension'];
			$newsWallpaperFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalWallpaperName));
			$newsWallpaperPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsWallpaperFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['wallpaper'], $newsWallpaperFullName);

			DB::table('news')
			->where('id', $data['id'])
			->update([
				'wallpaper_bild' => $newsWallpaperPfad
			]);
		}

		if($data['bild_teaser']){
			$newsOriginalTeaserName = $data['bild_teaser']->getClientOriginalName();
			$pathTeaserParts = pathinfo($newsOriginalTeaserName);
			$newsTeaserExtension = $pathTeaserParts['extension'];
			$newsTeaserFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalTeaserName));
			$newsTeaserPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsTeaserFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['bild_teaser'], $newsTeaserFullName);

			DB::table('news')
			->where('id', $data['id'])
			->update([
				'bild_teaser' => $newsTeaserPfad
			]);
		}

		if($data['bild']){
			$newsOriginalBildName = $data['bild']->getClientOriginalName();
			$pathBildParts = pathinfo($newsOriginalBildName);
			$newsBildExtension = $pathBildParts['extension'];
			$newsBildFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalBildName));
			$newsBildPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsBildFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['bild'], $newsBildFullName);

			DB::table('news')
			->where('id', $data['id'])
			->update([
				'bild' => $newsBildPfad
			]);
		}

		if($data['pdf_button_url']){
			$newsOriginalPDFName = $data['pdf_button_url']->getClientOriginalName();
			$pathPDFParts = pathinfo($newsOriginalPDFName);
			$newsPDFExtension = $pathPDFParts['extension'];
			$newsPDFFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalPDFName));
			$newsPDFPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/news/'.$newsPDFFullName));

			Storage::disk('public_news_uploads')->putFileAs('', $data['pdf_button_url'], $newsPDFFullName);

			DB::table('news')
			->where('id', $data['id'])
			->update([
				'pdf_button_url' => $newsPDFPfad
			]);
		}
	}	

	public function updateNewsMeldung($data){
		DB::table('news')
		->where('id', $data['id'])
		->update([
			'meldung' => $data['meldung'],
		]);
	}

	public function updateNewsSortable($data){
		foreach(json_decode($data) as $newsId => $sortableNr){
			DB::table('news')
			->where('id', $newsId)
			->update([
				'sortable' => $sortableNr, 
			]);
		}
	}

	public function updateNewHomePublishStatus($newId, $status) 
	{
		DB::table('news')
		->where('id', $newId)
		->update([
			'home_publish' => $status]
		);
	}	

	public function updateNewPublishStatus($newId, $status) 
	{
		DB::table('news')
		->where('id', $newId)
		->update([
			'publish' => $status]
		);
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