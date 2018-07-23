<?php

namespace App\Http\Controllers;

use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;

use App\Http\Models\Service as Service;

class DocumentsController extends Controller
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
     * Rendering the DOCUMENTS (Meistgenutzte Dokumente) page with all needed data
     * page: /dokumente
     * 
     * - documents = all documents
     * - documentCategories = generated categories from documents
     * - documentSubcategories = generated subcategories from documents
     */
    public function index(Request $request)
    {
        $documentCategory = $request->input('category');
        if(!empty($documentCategory)){
            $documents = Service::getDocumentsByCategory($documentCategory);
        } else {
            $documents = Service::getHomeDocuments();
        }

        $data = [
            'documents' => $documents,
            'documentCategories' => Service::getAllDocumentCategories(),
            'documentSubcategories' => Service::getAlldocumentSubcategories(),
        ];

        return view('documents', $data);
    }

    /**
     * Method: viewAllDocuments()
     *
     * Rendering the DOCUMENTS (Alle Dokumente) page with all needed data
     * page: /dokumente/alleDokumente
     * 
     * - documents = all documents
     * - documentCategories = generated categories from documents
     * - documentSubcategories = generated subcategories from documents
     */
    public function viewAllDocuments(Request $request)
    {
        $documentCategory = $request->input('category');
        if(!empty($documentCategory)){
            $documents = Service::getDocumentsByCategory($documentCategory);
        } else {
            $datum = $request->get('datum');
            $documents = Service::getAllDocuments($datum);
        }

        $data = [
            'documents' => $documents,
            'documentCategories' => Service::getAllDocumentCategories(),
            'documentSubcategories' => Service::getAlldocumentSubcategories(),
        ];

        return view('documents', $data);
    }

    /**
     * Method: getAllDocuments()
     *
     * Get ALL DOCUMENTS data from DATABASE
     * page: /dokumente/getAllDocuments
     */
    public function getAllDocuments() 
    {
        return Service::getAllDocuments();
    }

    /**
     * Method: getDocumentsByCityAndTelefon()
     *
     * Get ALL DOCUMENTS data from DATABASE by City
     * page: /dokumente/getAllDocuments
     */
    public function getDocumentsByCityAndTelefon(Request $request) 
    {
        return Service::getDocumentsByCityAndTelefon($request->input('city'));
    }

    /**
     * Method: getDocumentsByCategoriesAndSubcategories()
     *
     * Get ALL DOCUMENTS data from DATABASE by Category and Subcategory
     * page: /dokumente/getDocumentsByCategoriesAndSubcategories
     */
    public function getDocumentsByCategoriesAndSubcategories($category, $subCategory)
    {
        return Service::getDocumentsByCategoriesAndSubcategories($category, $subCategory);
    }

    /**
     * Method: getDocumentWithId()
     *
     * Get ALL DOCUMENTS data from DATABASE by ID
     * page: /dokumente/getDocumentWithId
     */
    public function getDocumentWithId(Request $request) 
    {
        return Service::getDocumentWithId($request->input('documentId'));
    }

    /**
     * Method: getAllDocumentsLikeValue()
     *
     * Get ALL DOCUMENTS data from DATABASE by given VALUE
     * page: /dokumente/getAllDocumentsLikeValue
     */
    public function getAllDocumentsLikeValue(Request $request) 
    {
        return Service::getAllDocumentsLikeValue($request->input('value'));
    }

    /**
     * Method: getAllDocumentsLikeValueFirst5()
     *
     * Get ALL DOCUMENTS data (First 5) from DATABASE by given VALUE
     * page: /dokumente/getAllDocumentsLikeValueFirst5
     */
    public function getAllDocumentsLikeValueFirst5(Request $request) 
    {
        return Service::getAllDocumentsLikeValueFirst5($request->input('value'));
    }

    /**
     * Method: getAllFAQSLikeValueFirst5()
     *
     * Get ALL FAQS data from DATABASE by given VALUE
     * page: /dokumente/getAllFAQSLikeValueFirst5
     */
    public function getAllFAQSLikeValueFirst5(Request $request) 
    {
        return Service::getAllFAQSLikeValueFirst5($request->input('value'));
    }

    /**
     * Method: getAllDocumentCategories()
     *
     * Get ALL DOCUMENTS CATEGORIES from DATABASE
     * page: /dokumente/getAllDocumentCategories
     */
    public function getAllDocumentCategories() 
    {
        return Service::getAllDocumentCategories();
    }

    /**
     * Method: getAlldocumentSubcategories()
     *
     * Get ALL DOCUMENTS SUBCATEGORIES from DATABASE
     * page: /dokumente/getAlldocumentSubcategories
     */
    public function getAlldocumentSubcategories() 
    {
        return Service::getAlldocumentSubcategories();
    }

    /**
     * Method: updateDocumentName()
     *
     * Update DOCUMENT data
     * page: /dokumente/updateDocumentName
     */
    public function updateDocumentName(Request $request) 
    {
        $data = [
            'id' => $request->input('documentId'),
            'name' => $request->input('documentName'),
            'pdf' => $request->file('documentPDF'),
            'kategorie' => $request->get('documentCategory'),
            'datum' => $request->get('documentDatum'),
        ];

        if(!empty($request->get('documentSubcategory'))){
            $data['unterkategorie'] = json_encode($request->get('documentSubcategory'));
        }

        Service::updateDocument($data);

        return back();
    }   

    /**
     * Method: addDocument()
     *
     * Add new DOCUMENT
     * page: /dokumente/addDocument
     */
    public function addDocument(Request $request) 
    {
        $data = [
            'documentName' => $request->input('documentName'),
            'documentFile' => $request->file('documentFile'),
            'documentCategory' => $request->get('documentCategory'),
            'documentSubcategory' => $request->get('documentSubcategory'),
        ];

        Service::addDocument($data);  

        return back();
    }  

    /**
     * Method: updateHomepageData()
     *
     * Update HOMEPAGE data (wallpaper info from start)
     */
    public function updateHomepageData(Request $request) 
    {
        $data = [
            'wallpaper' => $request->file('homepageWallpaper'),
            'titel' => $request->input('homepageTitel'),
            'untertitel' => $request->input('homepageUntertitel'),
            'WEB' => $request->input('homepageWEB'),
            'WEBName' => $request->input('homepageWEBName'),
        ];

        Service::updateHomepageData($data);  

        return back();
    }  

    /**
     * Method: updateHomeMessageData()
     *
     * Update HOMEPAGE Message Info (Over employees from START PAGE)
     */
    public function updateHomeMessageData(Request $request) 
    {
        $data = [
            'title' => $request->input('messageTitle'),
            'message' => $request->input('messageMessage'),
        ];

        Service::updateHomeMessageData($data);  

        return back();
    }  

    /**
     * Method: updateWLANBanner()
     *
     * Update WLAN BANNER from START PAGE
     * page: /dokumente/updateWLANBanner
     */
    public function updateWLANBanner(Request $request) 
    {
        $data = [
            'name' => $request->input('wlanName'),
            'password' => $request->input('wlanPassword'),
        ];

        Service::updateWLANBanner($data);  

        return back();
    }  

    /**
     * Method: addFAQs()
     *
     * Add new FAQ
     * page: /dokumente/addFAQs
     */
    public function addFAQs(Request $request) 
    {
        $data = [
            'titel' => $request->input('faqTitel'),
            'meldung' => $request->input('faqMeldung'),
            'kategorie' => $request->input('faqKategorie'),
            'unterkategorie' => $request->input('faqUnterkategorie'),
        ];

        Service::addFAQs($data);  

        return back();
    }   

    /**
     * Method: addCategory()
     *
     * Add new CATEGORY for DOCUMENTS
     * page: /dokumente/addCategory
     */
    public function addCategory(Request $request) 
    {
        $data['documentCategory'] = $request->get('documentCategory');

        Service::addCategory($data);  

        return back();
    } 

    /**
     * Method: updateFAQPublishStatus()
     *
     * Set FAQ als active(published/or not)
     * page: /dokumente/updateFAQPublishStatus
     */
    public function updateFAQPublishStatus(Request $request) 
    {
        $faqId = $request->input('id');
        $newPublish = $request->input('publish');

        return Service::updateFAQPublishStatus($faqId, $newPublish);
    } 

    /**
     * Method: addSubcategory()
     *
     * Add new SUBCATEGORY for DOCUMENTS
     * page: /dokumente/addSubcategory
     */
    public function addSubcategory(Request $request) 
    {
        $data = [
            'documentSubcategory' => $request->get('documentSubcategory'),
            'documentCategory' => $request->get('documentCategory'),
        ];

        Service::addSubcategory($data);  

        return back();
    }   

    /**
     * Method: removeDocument()
     *
     * Remove a DOCUMENT by a given ID
     * page: /dokumente/removeDocument
     */
    public function removeDocument(Request $request) 
    {
        $data = [
            'documentId' => $request->get('documentId'),
        ];

        Service::removeDocument($data);  

        return true;
    }   

    /**
     * Method: removeCategory()
     *
     * Remove a DOCUMENT CATEGORY by a given ID
     * page: /dokumente/removeCategory
     */
    public function removeCategory(Request $request) 
    {
        $data = [
            'categoryId' => $request->get('categoryId'),
        ];

        Service::removeCategory($data);  

        return true;
    }   

    /**
     * Method: updateFAQs()
     *
     * Update an FAQ
     * page: /dokumente/updateFAQs
     */
    public function updateFAQs(Request $request)
    {
        $data = [
            "id" => $request->input('faqId'),
            "titel" => $request->input('faqTitel'),
            "meldung" => $request->input('faqMeldung'),
            "kategorie" => $request->input('faqKategorie'),
            "unterkategorie" => $request->input('faqUnterkategorie'),
        ];

        Service::updateFAQs($data);

        return back();
    }

    /**
     * Method: removeFAQsById()
     *
     * Remove a FAQ by a given ID
     * page: /dokumente/removeFAQsById
     */
    public function removeFAQsById(Request $request) 
    {
        $data = [
            'id' => $request->get('id'),
        ];

        Service::removeFAQsById($data);  

        return true;
    }   

    /**
     * Method: removeSubcategory()
     *
     * Remove a SUBCATEGORY
     * page: /dokumente/removeSubcategory
     */
    public function removeSubcategory(Request $request) 
    {
        $data = [
            'subcategoryId' => $request->get('subcategoryId'),
        ];

        Service::removeSubcategory($data);  

        return true;
    }   

    public function getFAQsInfo(Request $request)
    {
        return json_encode(Service::showFAQs($request->input('faqId')));
    }

    public function getDocumentInfo(Request $request)
    { 
        return json_encode(Service::showDocument($request->input('documentId')));
    }

    /**
     * Method: updateFAQsSortable()
     *
     * Update FAQ status (sortable/ or not)
     * page: /dokumente/updateFAQsSortable
     */
    public function updateFAQsSortable(Request $request)
    {
        Service::updateFAQsSortable($request->input('sortable'));

        return 'true';
    }

    /**
     * Method: updateDocumentsSortable()
     *
     * Update DOCUMENTS status (sortable/ or not)
     * page: /dokumente/updateDocumentsSortable
     */
    public function updateDocumentsSortable(Request $request)
    {
        Service::updateDocumentsSortable($request->input('sortable'));

        return 'true';
    }

    /**
     * Method: updateDocumentStatus()
     *
     * Update DOCUMENTS status (publish/ or not)
     * page: /dokumente/updateDocumentStatus
     */
    public function updateDocumentStatus(Request $request) 
    {
        $documentId = $request->input('id');
        $documentStatus = $request->input('status');

        return Service::updateDocumentStatus($documentId, $documentStatus);
    }   

    /**
     * Method: updateClicksFAQ()
     *
     * Update FAQ - CLICK status
     * page: /dokumente/updateClicksFAQ
     */
    public function updateClicksFAQ(Request $request) 
    {
        return Service::updateClicksFAQ($request->input('id'));
    }   

    /**
     * Method: updateClicksDocument()
     *
     * Update DOCUMENTS - CLICK status
     * page: /dokumente/updateClicksDocument
     */
    public function updateClicksDocument(Request $request) 
    {
        return Service::updateClicksDocument($request->input('id'));
    }   
}
