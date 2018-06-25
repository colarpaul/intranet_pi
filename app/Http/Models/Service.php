<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Service extends Model
{
	/**
	 * Get all Documents
	 * 
	 * @return array
	 */
	public function getAllDocuments($datum = null) 
	{
		if($datum == 'desc'){
			$documents = DB::table('dokumente')->orderBy('created_at', 'desc')->paginate(15);
		} else {
			$documents = DB::table('dokumente')->orderBy('name', 'asc')->paginate(15);
		}

		return $documents;
	}

	/**
	 * Get all Documents by a given $category and a given $subCategory
	 * 
	 * @param  string $category
	 * @param  string $subCategory
	 * @return array
	 */
	public function getDocumentsByCategoriesAndSubcategories($subCategory, $categoryName)
	{
		if($categoryName == 'Alle Dokumente'){
			$documents = DB::table('dokumente')->orderBy('name', 'asc')->get();
		} else {
			$category = DB::table('kategorien_dokumente')->where('name', trim($categoryName))->first();
			$documents = DB::table('dokumente')->where('kategorie', $category->id)->orderBy('name', 'asc')->get();
		}

		return array('data' => $documents);
	}

	/**
	 * Get a Document by a given $documentId
	 * 
	 * @param  string $documentId
	 * @return array
	 */
	public function getDocumentWithId($documentId) 
	{
		$documents = DB::table('dokumente')->where('id', $documentId)->get();

		return $documents;
	}

	/**
	 * Get all Documents by a given $value
	 *
	 * @param  string $value
	 * @return array
	 */
	public function getAllDocumentsLikeValue($value, $limit = null) 
	{
		$documents = DB::table('dokumente')->where('name', 'like', '%'.$value.'%')->orderBy('name', 'asc')->get();

		return array('data' => $documents);
	}

	/**
	 * Get first 5 found Documents by a given $value
	 *
	 * @param  string $value
	 * @return array
	 */
	public function getAllDocumentsLikeValueFirst5($value) 
	{
		$documents = DB::table('dokumente')->where('name', 'like', '%'.$value.'%')->take(5)->get();

		$countDocuments = DB::table('dokumente')->where('name', 'like', '%'.$value.'%')->count(); 

		$data = array('documents' => $documents, 'total' => $countDocuments);

		return json_encode($data);
	}

	/**
	 * Get all categories from Documents
	 * 
	 * @return array
	 */
	public function getAllDocumentCategories() 
	{
		return DB::table('kategorien_dokumente')->orderBy('name', 'asc')->get();
	}

	/**
	 * Get all subCategories from Documents
	 * 
	 * @return array
	 */
	public function getAlldocumentSubcategories() 
	{
		return DB::table('unterkategorien_dokumente')->get();
	}	

	/**
	 * Update a document
	 * 
	 * @return array
	 */
	public function updateDocumentName($documentId, $documentName) 
	{
		DB::table('dokumente')
		->where('id', $documentId)
		->update([
			'name' => $documentName, 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	

	/**
	 * Add a document
	 * 
	 * @return array
	 */
	public function addDocument($data) 
	{
		$documentOriginalName = $data['documentFile']->getClientOriginalName();
		$pathParts = pathinfo($documentOriginalName);
		$documentExtension = $pathParts['extension'];
		$documentFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $data['documentName'].'.'.$documentExtension));
		$documentPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/pdf/'.$documentFullName));
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

	/**
	 * Add a faq
	 * 
	 * @return array
	 */
	public function addFAQs($data) 
	{
		DB::table('faqs')->insert([
			'titel' => $data['titel'],
			'meldung' => $data['meldung'],
			'kategorie' => ucfirst($data['kategorie']),
			'unterkategorie' => ucfirst($data['unterkategorie']),
			'publish' => 0
		]);
	}

	/**
	 * Add a cateogry
	 * 
	 * @return array
	 */
	public function addCategory($data) 
	{
		DB::table('kategorien_dokumente')->insert([
			'name' => $data['documentCategory']]
		);
	}

	/**
	 * Add a subcategory
	 * 
	 * @return array
	 */
	public function addSubcategory($data) 
	{
		DB::table('unterkategorien_dokumente')->insert([
			'kategorie_id' => $data['documentCategory'],
			'name' => $data['documentSubcategory']]
		);
	}

	/**
	 * Add a subcategory
	 * 
	 * @return array
	 */
	public function removeDocument($data) 
	{
		DB::table('dokumente')->where('id', $data['documentId'])->delete();
	}

	public function getDocumentsByCityAndTelefon($city) 
	{
		return DB::table('dokumente')->where('kategorie', 11)->where('name', 'like', '%'.$city.'%')->get();
	}

	public function getDocumentsByKey($key){
		return DB::table('dokumente')
		->where('name', 'like', '%'.$key.'%')
		->orderBy('sortable', 'asc')
		->get();
	}

	/**
	 * Add a subcategory
	 * 
	 * @return array
	 */
	public function removeCategory($data) 
	{
		DB::table('kategorien_dokumente')->where('id', $data['categoryId'])->delete();
		DB::table('unterkategorien_dokumente')->where('kategorie_id', $data['categoryId'])->delete();
	}

	/**
	 * Add a subcategory
	 * 
	 * @return array
	 */
	public function removeSubcategory($data) 
	{
		DB::table('unterkategorien_dokumente')->where('id', $data['subcategoryId'])->delete();
	}

	public function getDocumentsByCategory($category)
	{

		$categoryId = DB::table('kategorien_dokumente')->where('name', $category)->first();
		if(!empty($categoryId)){
			return DB::table('dokumente')->where('kategorie', $categoryId->id)->paginate(50);
		} else {
			return $this->getAllDocuments();
		}	
	}

	public function getFAQs($category = NULL)
	{
		if($category){
			return DB::table('faqs')->where('kategorie', $category)->where('publish', 1)->orderBy('sortable', 'asc')->get();
		} else {
			return DB::table('faqs')->orderBy('id', 'desc')->paginate(15);
		}
	}

	public function getTop5FAQsClicks()
	{
		return DB::table('faqs')->orderBy('clicks', 'desc')->take(10)->get();
	}

	public function getFAQsByKey($key)
	{
		return DB::table('faqs')
		->where('titel', 'like', '%'.$key.'%')
		->orWhere('meldung', 'like', '%'.$key.'%')
		->orWhere('kategorie', 'like', '%'.$key.'%')
		->orWhere('unterkategorie', 'like', '%'.$key.'%')
		->orderBy('kategorie', 'asc')
		->get();
	}



	public function getFAQsWithId($ids){
		return DB::table('faqs')->whereIn('id', $ids)->first();
	}

	public function getDocumentsById($ids){
		$documents = DB::table('dokumente')->whereIn('id', $ids)->orderByRaw(DB::raw("FIELD(id, ".implode(',', $ids).")"))->paginate();
		return $documents;
	}

	public function getHomeDocuments(){
		// $documents = DB::table('dokumente')->where('publish', 1)->orderBy('sortable', 'asc')->paginate();
		$documents = DB::table('dokumente')->orderBy('clicks', 'asc')->take(10)->get();
		return $documents;
	}

	public function getNewDocuments(){
		// return DB::table('dokumente')->where('datum', '>=', date('Y-m-d', strtotime('-4 weeks', strtotime(date('Y-m-d')))))->orderBy('datum', 'desc')->take(3)->get();
		return DB::table('dokumente')->orderBy('datum', 'desc')->take(6)->get();
	}

	public function getFAQSubcategories($category){
		if($category == 'Fuhrpark'){
			return DB::table('faqs')->select('unterkategorie')->where('kategorie', $category)->where('publish', 1)->groupBy('unterkategorie')->orderBy('unterkategorie', 'desc')->get();
		} else {
			return DB::table('faqs')->select('unterkategorie')->where('kategorie', $category)->where('publish', 1)->groupBy('unterkategorie')->get();
		}
	}

	public function getLastDocuments(){
		$documents = DB::table('dokumente')->orderBy('updated_at', 'desc')->take(6)->get();

		return $documents;
	}

	public function getDocumentsSortable(){
		$news = DB::table('dokumente')
		->where('publish', 1)
		->orderBy('sortable', 'asc')
		->get();

		return $news;
	}

	public function showFAQs($id)
	{
		return DB::table('faqs')->where('id', $id)->get()->first();
	}

	public function showDocument($id)
	{
		return DB::table('dokumente')->where('id', $id)->get()->first();
	}

	public function getHomepageData()
	{
		return DB::table('homepage')->get()->first();
	}

	public function getWLANData()
	{
		return DB::table('wlan_banner')->get()->first();
	}

	public function updateFAQPublishStatus($faqId, $status) 
	{
		DB::table('faqs')
		->where('id', $faqId)
		->update([
			'publish' => $status]
		);
	}	

	public function updateClicksFAQ($faqId) 
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

	public function updateClicksDocument($documentId) 
	{
		$clicks = DB::table('dokumente')
		->select('clicks')
		->where('id', $documentId)
		->first();

		DB::table('dokumente')
		->where('id', $documentId)
		->update([
			'clicks' => $clicks->clicks + 1]
		);
	}	

	public function updateDocument($data) 
	{
		if($data['pdf']){
			$documentOriginalName = $data['pdf']->getClientOriginalName();
			$pathParts = pathinfo($documentOriginalName);
			$documentExtension = $pathParts['extension'];
			$documentFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $data['name'].'.'.$documentExtension));
			$documentPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/documents/pdf/'.$documentFullName));
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
			'datum' => $data['datum'], 
		]);

	}

	public function updateFAQs($data) 
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

	public function updateWLANBanner($data){
		DB::table('wlan_banner')
		->where('id', 1)
		->update([
			'name' => $data['name'],
			'password' => $data['password'],
		]);
	}

	public function updateHomepageData($data){
		if($data['wallpaper']){
			$newsOriginalWallpaperName = $data['wallpaper']->getClientOriginalName();
			$pathWallpaperParts = pathinfo($newsOriginalWallpaperName);
			$wallpaperExtension = $pathWallpaperParts['extension'];
			$wallpaperFullName = $this->transformGermanChars(preg_replace('/\s+/', '', $newsOriginalWallpaperName));
			$wallpaperPfad = $this->transformGermanChars(preg_replace('/\s+/', '', '/images/wallpaper/'.$wallpaperFullName));

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

	public function removeFAQsById($data) 
	{
		DB::table('faqs')->where('id', $data['id'])->delete();
	}

	public function updateFAQsSortable($data)
	{
		foreach(json_decode($data) as $faqId => $sortableNr){
			DB::table('faqs')
			->where('id', $faqId)
			->update([
				'sortable' => $sortableNr, 
			]);
		}
	}

	public function updateDocumentsSortable($data)
	{
		foreach(json_decode($data) as $documentId => $sortableNr){
			DB::table('dokumente')
			->where('id', $documentId)
			->update([
				'sortable' => $sortableNr, 
			]);
		}
	}

	/**
	 * Update a object status
	 * 
	 * @return array
	 */
	public function updateDocumentStatus($documentId, $documentStatus) 
	{
		DB::table('dokumente')
		->where('id', $documentId)
		->update([
			'publish' => $documentStatus, 
			'updated_at' => date('Y-m-d H:i:s')]
		);
	}	

	public function getFAQsSortable()
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

	public function getBestFAQs()
	{
		return DB::table('faqs')
		->orderBy('clicks', 'desc')
		->take(3)
		->get();
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