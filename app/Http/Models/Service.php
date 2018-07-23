<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Http\Helpers\Helper as Helper;

class Service extends Model
{
	public static function getAllDocuments($datum = null) 
	{
		if($datum == 'desc'){
			$documents = DB::table('dokumente')->orderBy('created_at', 'desc')->paginate(15);
		} else {
			$documents = DB::table('dokumente')->orderBy('name', 'asc')->paginate(15);
		}

		return $documents;
	}

	public static function getDocumentsByCategoriesAndSubcategories($subCategory, $categoryName)
	{
		if($categoryName == 'Alle Dokumente'){
			$documents = DB::table('dokumente')->orderBy('name', 'asc')->get();
		} else {
			$category = DB::table('kategorien_dokumente')->where('name', trim($categoryName))->first();
			$documents = DB::table('dokumente')->where('kategorie', $category->id)->orderBy('name', 'asc')->get();
		}

		return array('data' => $documents);
	}

	public static function getDocumentWithId($documentId) 
	{
		$documents = DB::table('dokumente')->where('id', $documentId)->get();

		return $documents;
	}

	public static function getAllDocumentsLikeValue($value, $limit = null) 
	{
		$documents = DB::table('dokumente')->where('name', 'like', '%'.$value.'%')->orderBy('name', 'asc')->get();

		return array('data' => $documents);
	}

	public static function getAllDocumentsLikeValueFirst5($value) 
	{
		$documents = DB::table('dokumente')->where('name', 'like', '%'.$value.'%')->take(5)->get();

		$countDocuments = DB::table('dokumente')->where('name', 'like', '%'.$value.'%')->count(); 

		$data = array('documents' => $documents, 'total' => $countDocuments);

		return json_encode($data);
	}

	public static function getAllFAQSLikeValueFirst5($value) 
	{
		$faqs = DB::table('faqs')->where('titel', 'like', '%'.$value.'%')->orWhere('meldung', 'like', '%'.$value.'%')->take(5)->get();

		$countFAQs = DB::table('faqs')->where('titel', 'like', '%'.$value.'%')->orWhere('meldung', 'like', '%'.$value.'%')->count(); 

		$data = array('faqs' => $faqs, 'total' => $countFAQs);

		return json_encode($data);
	}

	public static function getAllDocumentCategories() 
	{
		return DB::table('kategorien_dokumente')->orderBy('name', 'asc')->get();
	}

	public static function getAlldocumentSubcategories() 
	{
		return DB::table('unterkategorien_dokumente')->get();
	}	

	public static function updateDocumentName($documentId, $documentName) 
	{
		DB::table('dokumente')
		->where('id', $documentId)
		->update([
			'name' => $documentName, 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	

	public static function addDocument($data) 
	{
		$documentOriginalName = $data['documentFile']->getClientOriginalName();
		$pathParts = pathinfo($documentOriginalName);
		$documentExtension = $pathParts['extension'];
		$documentFullName = Helper::transformGermanChars(preg_replace('/\s+/', '', $data['documentName'].'.'.$documentExtension));
		$documentPfad = Helper::transformGermanChars(preg_replace('/\s+/', '', '/documents/pdf/'.$documentFullName));
		$documentSize = round((File::size($data['documentFile'])/1000));

		Storage::disk('public_uploads')->putFileAs('', $data['documentFile'], $documentFullName);

		DB::table('dokumente')->insert([
			'name' => $data['documentName'],
			'pfad' => $documentPfad,
			'kategorie' => $data['documentCategory'],
			'unterkategorie' => json_encode($data['documentSubcategory']),
			'groesse' => $documentSize,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}

	public static function addFAQs($data) 
	{
		DB::table('faqs')->insert([
			'titel' => $data['titel'],
			'meldung' => $data['meldung'],
			'kategorie' => ucfirst($data['kategorie']),
			'unterkategorie' => ucfirst($data['unterkategorie']),
			'publish' => 0
		]);
	}

	public static function addCategory($data) 
	{
		DB::table('kategorien_dokumente')->insert([
			'name' => $data['documentCategory']]
		);
	}

	public static function addSubcategory($data) 
	{
		DB::table('unterkategorien_dokumente')->insert([
			'kategorie_id' => $data['documentCategory'],
			'name' => $data['documentSubcategory']]
		);
	}

	public static function removeDocument($data) 
	{
		DB::table('dokumente')->where('id', $data['documentId'])->delete();
	}

	public static function getDocumentsByCityAndTelefon($city) 
	{
		return DB::table('dokumente')->where('kategorie', 11)->where('name', 'like', '%'.$city.'%')->get();
	}

	public static function getDocumentsByKey($key)
	{
		return DB::table('dokumente')
		->where('name', 'like', '%'.$key.'%')
		->orderBy('sortable', 'asc')
		->get();
	}

	public static function removeCategory($data) 
	{
		DB::table('kategorien_dokumente')->where('id', $data['categoryId'])->delete();
		DB::table('unterkategorien_dokumente')->where('kategorie_id', $data['categoryId'])->delete();
	}

	public static function removeSubcategory($data) 
	{
		DB::table('unterkategorien_dokumente')->where('id', $data['subcategoryId'])->delete();
	}

	public static function getDocumentsByCategory($category)
	{
		$categoryId = DB::table('kategorien_dokumente')->where('name', $category)->first();
		if(!empty($categoryId)){
			return DB::table('dokumente')->where('kategorie', $categoryId->id)->paginate(50);
		} else {
			return $this->getAllDocuments();
		}	
	}

	public static function getFAQs($category = NULL)
	{
		if($category){
			return DB::table('faqs')
			->where('kategorie', $category)
			->where('publish', 1)
			->orderBy('sortable', 'asc')
			->get()
			->toArray();
		} else {
			return DB::table('faqs')
			->orderBy('id', 'desc')
			->paginate(15);
		}
	}

	public static function getFAQsByCategoryAndSubcategory($category, $subcategory)
	{
		if($subcategory == '' OR $subcategory == NULL){
			return DB::table('faqs')
			->where('kategorie', $category)
			->where('publish', 1)
			->orderBy('sortable', 'asc')
			->get()
			->toArray();
		} else {
			return DB::table('faqs')
			->where('kategorie', $category)
			->where('unterkategorie', $subcategory)
			->where('publish', 1)
			->orderBy('sortable', 'asc')
			->get()
			->toArray();
		}
	}

	public static function getTop5FAQsClicks()
	{
		return DB::table('faqs')->orderBy('clicks', 'desc')->take(10)->get();
	}

	public static function getFAQsByKey($key)
	{
		return DB::table('faqs')
		->where('titel', 'like', '%'.$key.'%')
		->orWhere('meldung', 'like', '%'.$key.'%')
		->orWhere('kategorie', 'like', '%'.$key.'%')
		->orWhere('unterkategorie', 'like', '%'.$key.'%')
		->orderBy('kategorie', 'asc')
		->get();
	}

	public static function getFAQsWithId($ids)
	{
		return DB::table('faqs')->whereIn('id', $ids)->first();
	}

	public static function getDocumentsById($ids)
	{
		$documents = DB::table('dokumente')->whereIn('id', $ids)->orderByRaw(DB::raw("FIELD(id, ".implode(',', $ids).")"))->paginate();
		return $documents;
	}

	public static function getHomeDocuments()
	{
		$documents = DB::table('dokumente')->where('publish', 1)->orderBy('sortable', 'asc')->paginate();
		return $documents;
	}

	public static function getNewDocuments()
	{
		return DB::table('dokumente')->orderBy('created_at', 'desc')->take(6)->get();
	}

	public static function getFAQSubcategories($category){
		if($category == 'Fuhrpark'){
			return DB::table('faqs')
			->select('unterkategorie')
			->where('kategorie', $category)
			->where('publish', 1)
			->groupBy('unterkategorie')
			->orderBy('unterkategorie', 'desc')
			->pluck('unterkategorie')
			->toArray();
		} else {
			return DB::table('faqs')
			->select('unterkategorie')
			->where('kategorie', $category)
			->where('publish', 1)
			->groupBy('unterkategorie')
			->pluck('unterkategorie')
			->toArray();
		}
	}

	public static function getAllFAQCategories(){
		return DB::table('faqs')
		->select('kategorie')
		->where('publish', 1)
		->groupBy('kategorie')
		->pluck('kategorie')
		->toArray();
	}

	public static function getDocumentsSortable(){
		$news = DB::table('dokumente')
		->where('publish', 1)
		->orderBy('sortable', 'asc')
		->get();

		return $news;
	}

	public static function showFAQs($id)
	{
		return DB::table('faqs')->where('id', $id)->get()->first();
	}

	public static function showDocument($id)
	{
		return DB::table('dokumente')->where('id', $id)->get()->first();
	}

	public static function getHomepageData()
	{
		return DB::table('homepage')->get()->first();
	}

	public static function getWLANData()
	{
		return DB::table('wlan_banner')->get()->first();
	}

	public static function getHomeMessage()
	{
		return DB::table('home_message')->get()->first();
	}

	public static function updateFAQPublishStatus($faqId, $status) 
	{
		DB::table('faqs')
		->where('id', $faqId)
		->update([
			'publish' => $status]
		);
	}	

	public static function updateClicksFAQ($faqId) 
	{
		$clicks = DB::table('faqs')
		->select('clicks')
		->where('id', $faqId)
		->first();

		DB::table('faqs')
		->where('id', $faqId)
		->update([
			'clicks' => $clicks->clicks + 1]
		);
	}	

	public static function updateDocument($data) 
	{
		if($data['pdf']){
			$documentOriginalName = $data['pdf']->getClientOriginalName();
			$pathParts = pathinfo($documentOriginalName);
			$documentExtension = $pathParts['extension'];
			$documentFullName = Helper::transformGermanChars(preg_replace('/\s+/', '', $data['name'].'.'.$documentExtension));
			$documentPfad = Helper::transformGermanChars(preg_replace('/\s+/', '', '/documents/pdf/'.$documentFullName));
			$documentSize = round((File::size($data['pdf'])/1000));

			Storage::disk('public_uploads')->putFileAs('', $data['pdf'], $documentFullName);


			DB::table('dokumente')
			->where('id', $data['id'])
			->update([
				'groesse' => $documentSize,
				'pfad' => $documentPfad,
			]);
		}

		if(!empty($data['unterkategorie'])){
			DB::table('dokumente')
			->where('id', $data['id'])
			->update([
				'unterkategorie' => $data['unterkategorie'], 
			]);
		}

		DB::table('dokumente')
		->where('id', $data['id'])
		->update([
			'name' => $data['name'], 
			'kategorie' => $data['kategorie'], 
			'updated_at' => date('Y-m-d H:i:s'),
		]);

	}

	public static function updateFAQs($data) 
	{
		DB::table('faqs')
		->where('id', $data['id'])
		->update([
			'titel' => $data['titel'], 
			'meldung' => $data['meldung'], 
			'kategorie' => $data['kategorie'], 
			'unterkategorie' => $data['unterkategorie'], 
		]);
	}	

	public static function updateWLANBanner($data)
	{
		DB::table('wlan_banner')
		->where('id', 1)
		->update([
			'name' => $data['name'],
			'password' => $data['password'],
		]);
	}

	public static function updateHomepageData($data)
	{
		if($data['wallpaper']){
			$newsOriginalWallpaperName = $data['wallpaper']->getClientOriginalName();
			$pathWallpaperParts = pathinfo($newsOriginalWallpaperName);
			$wallpaperExtension = $pathWallpaperParts['extension'];
			$wallpaperFullName = Helper::transformGermanChars(preg_replace('/\s+/', '', $newsOriginalWallpaperName));
			$wallpaperPfad = Helper::transformGermanChars(preg_replace('/\s+/', '', '/images/wallpaper/'.$wallpaperFullName));

			Storage::disk('public_images_wallpaper')->putFileAs('', $data['wallpaper'], $wallpaperFullName);

			DB::table('homepage')
			->where('id', 1)
			->update([
				'wallpaper' => $wallpaperPfad,
			]);
		}

		DB::table('homepage')
		->where('id', 1)
		->update([
			'titel' => $data['titel'],
			'untertitel' => $data['untertitel'],
			'button_url' => $data['WEB'],
			'button_name' => (!empty($data['WEBName'])) ? $data['WEBName'] : 'weiterleiten',
		]);
	}

	public static function updateHomeMessageData($data)
	{
		DB::table('home_message')
		->where('id', 1)
		->update([
			'title' => $data['title'],
			'message' => $data['message'],
		]);
	}

	public static function removeFAQsById($data) 
	{
		DB::table('faqs')->where('id', $data['id'])->delete();
	}

	public static function updateFAQsSortable($data)
	{
		foreach(json_decode($data) as $faqId => $sortableNr){
			DB::table('faqs')
			->where('id', $faqId)
			->update([
				'sortable' => $sortableNr, 
			]);
		}
	}

	public static function updateDocumentsSortable($data)
	{
		foreach(json_decode($data) as $documentId => $sortableNr){
			DB::table('dokumente')
			->where('id', $documentId)
			->update([
				'sortable' => $sortableNr, 
			]);
		}
	}

	public static function updateDocumentStatus($documentId, $documentStatus) 
	{
		DB::table('dokumente')
		->where('id', $documentId)
		->update([
			'publish' => $documentStatus, 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	

	public static function getFAQsSortable()
	{
		$faqs = DB::table('faqs')
		->orderBy('sortable', 'asc')
		->get();

		$categories = DB::table('faqs')
		->select('kategorie')
		->groupBy('kategorie')
		->get();

		$newsFaqs = array();
		foreach($faqs as $faq){
			foreach($categories as $category){
				if(strtolower($category->kategorie) == strtolower($faq->kategorie)){
					$newsFaqs[$category->kategorie][] = $faq;
				}
			}
		}

		ksort($newsFaqs);

		return $newsFaqs;
	}

	public static function getBestFAQs()
	{
		return DB::table('faqs')
		->orderBy('clicks', 'desc')
		->take(3)
		->get();
	}
}