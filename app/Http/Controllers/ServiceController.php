<?php

namespace App\Http\Controllers;

use App\Http\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailer;

class ServiceController extends Controller
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
* Show the application dashboard.
* 
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
    $serviceModel = new Service();

    $documentCategory = $request->input('category');
    if(!empty($documentCategory)){
        $documents = $serviceModel->getDocumentsByCategory($documentCategory);
    } else {
        $documents = $serviceModel->getHomeDocuments();
    }

    $documentCategories = $serviceModel->getAllDocumentCategories();
    $documentSubcategories = $serviceModel->getAlldocumentSubcategories();

    $faqsIT = $serviceModel->getFAQs('IT');
    $faqSubcategoriesIT = $serviceModel->getFAQSubcategories('IT');
    foreach($faqSubcategoriesIT as $key => $faqSubcategorie){
        if(empty($faqSubcategorie->unterkategorie)){
            unset($faqSubcategoriesIT[$key]);
        }
    }

    $faqsBuero = $serviceModel->getFAQs('Büroorganisation');
    $faqSubcategoriesBuero = $serviceModel->getFAQSubcategories('Büroorganisation');
    foreach($faqSubcategoriesBuero as $key => $faqSubcategorie){
        if(empty($faqSubcategorie->unterkategorie)){
            unset($faqSubcategoriesBuero[$key]);
        }
    }

    $faqBestQuestions = $serviceModel->getBestFAQs();

    $faqsPersonal = $serviceModel->getFAQs('Personalabteilung');
    $faqsFacilityManagement = $serviceModel->getFAQs('Facility Management');
    $faqsFuhrpark = $serviceModel->getFAQs('Fuhrpark');
    $faqsReisestelle = $serviceModel->getFAQs('Reisestelle');
    $faqsDatenschutz = $serviceModel->getFAQs('Datenschutz');

    $faqsSubcategoriesFuhrpark = $serviceModel->getFAQSubcategories('Fuhrpark');
    foreach($faqsSubcategoriesFuhrpark as $key => $faqSubcategorie){
        if(empty($faqSubcategorie->unterkategorie)){
            unset($faqsSubcategoriesFuhrpark[$key]);
        }
    }

    $data = array(
        'documents' => $documents,
        'documentCategories' => $documentCategories,
        'documentSubcategories' => $documentSubcategories,
        'faqsIT' => $faqsIT,
        'faqSubcategoriesIT' => $faqSubcategoriesIT,
        'faqsBuero' => $faqsBuero,
        'faqSubcategoriesBuero' => $faqSubcategoriesBuero,
        'faqBestQuestions' => $faqBestQuestions,
        'faqsPersonal' => $faqsPersonal,
        'faqsFacilityManagement' => $faqsFacilityManagement,
        'faqsFuhrpark' => $faqsFuhrpark,
        'faqsReisestelle' => $faqsReisestelle,
        'faqsDatenschutz' => $faqsDatenschutz,
        'faqSubcategoriesFuhrpark' => $faqsSubcategoriesFuhrpark,
    );

    return view('service', $data);
}

public function viewAllDocuments(Request $request)
{
    $serviceModel = new Service();

    $documentCategory = $request->input('category');
    if(!empty($documentCategory)){
        $documents = $serviceModel->getDocumentsByCategory($documentCategory);
    } else {
        $datum = $request->get('datum');
        $documents = $serviceModel->getAllDocuments($datum);
    }

    $documentCategories = $serviceModel->getAllDocumentCategories();
    $documentSubcategories = $serviceModel->getAlldocumentSubcategories();

    $faqsIT = $serviceModel->getFAQs('IT');
    $faqSubcategoriesIT = $serviceModel->getFAQSubcategories('IT');
    foreach($faqSubcategoriesIT as $key => $faqSubcategorie){
        if(empty($faqSubcategorie->unterkategorie)){
            unset($faqSubcategoriesIT[$key]);
        }
    }

    $faqsBuero = $serviceModel->getFAQs('Büroorganisation');
    $faqSubcategoriesBuero = $serviceModel->getFAQSubcategories('Büroorganisation');
    foreach($faqSubcategoriesBuero as $key => $faqSubcategorie){
        if(empty($faqSubcategorie->unterkategorie)){
            unset($faqSubcategoriesBuero[$key]);
        }
    }

    $faqBestQuestions[] = $serviceModel->getFAQsWithId(array(2));
    $faqBestQuestions[] = $serviceModel->getFAQsWithId(array(23));
    $faqBestQuestions[] = $serviceModel->getFAQsWithId(array(4));

    $faqsPersonal = $serviceModel->getFAQs('Personalabteilung');
    $faqsFacilityManagement = $serviceModel->getFAQs('Facility Management');
    $faqsFuhrpark = $serviceModel->getFAQs('Fuhrpark');
    $faqsReisestelle = $serviceModel->getFAQs('Reisestelle');

    $faqsSubcategoriesFuhrpark = $serviceModel->getFAQSubcategories('Fuhrpark');
    foreach($faqsSubcategoriesFuhrpark as $key => $faqSubcategorie){
        if(empty($faqSubcategorie->unterkategorie)){
            unset($faqsSubcategoriesFuhrpark[$key]);
        }
    }
    
    $data = array(
        'documents' => $documents,
        'documentCategories' => $documentCategories,
        'documentSubcategories' => $documentSubcategories,
        'faqsIT' => $faqsIT,
        'faqSubcategoriesIT' => $faqSubcategoriesIT,
        'faqsBuero' => $faqsBuero,
        'faqSubcategoriesBuero' => $faqSubcategoriesBuero,
        'faqBestQuestions' => $faqBestQuestions,
        'faqsPersonal' => $faqsPersonal,
        'faqsFacilityManagement' => $faqsFacilityManagement,
        'faqsFuhrpark' => $faqsFuhrpark,
        'faqsReisestelle' => $faqsReisestelle,
        'faqSubcategoriesFuhrpark' => $faqsSubcategoriesFuhrpark,
    );

    return view('service', $data);
}

public function documentsShow()
{
    header("Content-Disposition: inline; filename='asdqwe'");

}

public function getAllDocuments() 
{
    $serviceModel = new Service();

    return $serviceModel->getAllDocuments();
}

public function getDocumentsByCityAndTelefon(Request $request) 
{
    $serviceModel = new Service();

    $city = $request->input('city');

    return $serviceModel->getDocumentsByCityAndTelefon($city);
}

public function getDocumentsByCategoriesAndSubcategories($category, $subCategory)
{
    $serviceModel = new Service();

    return $serviceModel->getDocumentsByCategoriesAndSubcategories($category, $subCategory);
}

public function getDocumentWithId(Request $request) 
{
    $serviceModel = new Service();

    $documentId = $request->input('documentId');

    return $serviceModel->getDocumentWithId($documentId);
}

public function getAllDocumentsLikeValue(Request $request) 
{
    $serviceModel = new Service();

    $value = $request->input('value');

    return $serviceModel->getAllDocumentsLikeValue($value);
}

public function getAllDocumentsLikeValueFirst5(Request $request) 
{
    $serviceModel = new Service();

    $value = $request->input('value');

    return $serviceModel->getAllDocumentsLikeValueFirst5($value);
}

public function getAllDocumentCategories() 
{
    $serviceModel = new Service();

    return $serviceModel->getAllDocumentCategories();
}

public function getAlldocumentSubcategories() 
{
    $serviceModel = new Service();

    return $serviceModel->getAlldocumentSubcategories();
}   

public function updateDocumentName(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'id' => $request->input('documentId'),
        'name' => $request->input('documentName'),
        'pdf' => $request->file('documentPDF'),
        'kategorie' => $request->get('documentCategory'),
        'datum' => $request->get('documentDatum'),
    );

    if(!empty($request->get('documentSubcategory'))){
        $data['unterkategorie'] = json_encode($request->get('documentSubcategory'));
    }

    $serviceModel->updateDocument($data);

    return back();
}   

public function addDocument(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'documentName' => $request->input('documentName'),
        'documentFile' => $request->file('documentFile'),
        'documentCategory' => $request->get('documentCategory'),
        'documentSubcategory' => $request->get('documentSubcategory'),
    );

    $serviceModel->addDocument($data);  

    return back();
}  

public function updateHomepageData(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'wallpaper' => $request->file('homepageWallpaper'),
        'titel' => $request->input('homepageTitel'),
        'untertitel' => $request->input('homepageUntertitel'),
        'WEB' => $request->input('homepageWEB'),
        'WEBName' => $request->input('homepageWEBName'),
    );

    $serviceModel->updateHomepageData($data);  

    return back();
}  



public function updateWLANBanner(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'name' => $request->input('wlanName'),
        'password' => $request->input('wlanPassword'),
    );

    $serviceModel->updateWLANBanner($data);  

    return back();
}  

public function addFAQs(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'titel' => $request->input('faqTitel'),
        'meldung' => $request->input('faqMeldung'),
        'kategorie' => $request->input('faqKategorie'),
        'unterkategorie' => $request->input('faqUnterkategorie'),
    );

    $serviceModel->addFAQs($data);  

    return back();
}   

public function addCategory(Request $request) 
{
    $serviceModel = new Service();

    $data['documentCategory'] = $request->get('documentCategory');

    $serviceModel->addCategory($data);  

    return back();
}   

public function updateFAQPublishStatus(Request $request) 
{
    $serviceModel = new Service();

    $faqId = $request->input('id');
    $newPublish = $request->input('publish');

    return $serviceModel->updateFAQPublishStatus($faqId, $newPublish);
} 

public function addSubcategory(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'documentSubcategory' => $request->get('documentSubcategory'),
        'documentCategory' => $request->get('documentCategory'),
    );

    $serviceModel->addSubcategory($data);  

    return back();
}   

public function removeDocument(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'documentId' => $request->get('documentId'),
    );

    $serviceModel->removeDocument($data);  

    return true;
}   

public function removeCategory(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'categoryId' => $request->get('categoryId'),
    );

    $serviceModel->removeCategory($data);  

    return true;
}   

public function updateFAQs(Request $request)
{
    $serviceModel = new Service();

    $data = array(
        "id" => $request->input('faqId'),
        "titel" => $request->input('faqTitel'),
        "meldung" => $request->input('faqMeldung'),
        "kategorie" => $request->input('faqKategorie'),
        "unterkategorie" => $request->input('faqUnterkategorie'),
    );

    $faqs = $serviceModel->updateFAQs($data);

    return back();
}

public function removeFAQsById(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'id' => $request->get('id'),
    );

    $serviceModel->removeFAQsById($data);  

    return true;
}   

public function removeSubcategory(Request $request) 
{
    $serviceModel = new Service();

    $data = array(
        'subcategoryId' => $request->get('subcategoryId'),
    );

    $serviceModel->removeSubcategory($data);  

    return true;
}   

public function getFAQsInfo(Request $request)
{
    $serviceModel = new Service();

    $faqId = $request->input('faqId');

    $faq = $serviceModel->showFAQs($faqId);

    return json_encode($faq);
}

public function getDocumentInfo(Request $request)
{
    $serviceModel = new Service();

    $documentId = $request->input('documentId');

    $document = $serviceModel->showDocument($documentId);

    return json_encode($document);
}

/**
* Update new by given all necessary data as array
* 
* @param  Request $request
* @return true/back
*/
public function updateFAQsSortable(Request $request)
{
    $serviceModel = new Service();

    $data = $request->input('sortable');

    $faqs = $serviceModel->updateFAQsSortable($data);

    return 'true';
}

/**
* Update new by given all necessary data as array
* 
* @param  Request $request
* @return true/back
*/
public function updateDocumentsSortable(Request $request)
{
    $serviceModel = new Service();

    $data = $request->input('sortable');

    $documents = $serviceModel->updateDocumentsSortable($data);

    return 'true';
}

public function updateDocumentStatus(Request $request) 
{
    $serviceModel = new Service();

    $documentId = $request->input('id');
    $documentStatus = $request->input('status');

    return $serviceModel->updateDocumentStatus($documentId, $documentStatus);
}   

public function updateClicksFAQ(Request $request) 
{
    $serviceModel = new Service();

    $faqId = $request->input('id');

    return $serviceModel->updateClicksFAQ($faqId);
}   

public function updateClicksDocument(Request $request) 
{
    $serviceModel = new Service();

    $documentId = $request->input('id');

    return $serviceModel->updateClicksDocument($documentId);
}   

public function sendSupportEmail(Request $request)
{
    $data = $request->get('value');
    $email = $data['email'];
    $data = array(
        'email' =>$data['email'],
        'name' =>$data['name'],
        'body' => $data['body'],
    );

    if($email == 'it-anfragen@project-immobilien.com'){
        \Mail::send('emails.reminder',$data, function ($m)  {

            $m->from('support.intranet@app.com', 'SUPPORT Intranet');

            $m->to('it-anfragen@project-immobilien.com', 'SUPPORT Intranet')->subject('SUPPORT Intranet Subject');
        });
    } elseif($email == 'fm-anfragen@project-immobilien.com'){
        \Mail::send('emails.reminder',$data, function ($m)  {

            $m->from('support.intranet@app.com', 'SUPPORT Intranet');

            $m->to('it-anfragen@project-immobilien.com', 'SUPPORT Intranet')->subject('SUPPORT Intranet Subject');
        });
    } elseif($email == 'software.support@project-immobilien.com'){
        \Mail::send('emails.reminder',$data, function ($m)  {

            $m->from('support.intranet@app.com', 'SUPPORT Intranet');

            $m->to('software.support@project-immobilien.com', 'SUPPORT Intranet')->subject('SUPPORT Intranet Subject');
        });
    } elseif($email == 'personal@project-immobilien.com'){
        \Mail::send('emails.reminder',$data, function ($m)  {

            $m->from('support.intranet@app.com', 'SUPPORT Intranet');

            $m->to('personal@project-immobilien.com', 'SUPPORT Intranet')->subject('SUPPORT Intranet Subject');
        });
    } elseif($email == 'support.intranet@project-immobilien.com'){
        \Mail::send('emails.reminder',$data, function ($m)  {

            $m->from('support.intranet@app.com', 'SUPPORT Intranet');

            $m->to('support.intranet@project-immobilien.com', 'SUPPORT Intranet')->subject('SUPPORT Intranet Subject');
        });
    } else {
        \Mail::send('emails.reminder',$data, function ($m)  {

            $m->from('support.intranet@app.com', 'SUPPORT Intranet');

            $m->to('colarpaul@gmail.com', 'SUPPORT Intranet')->subject('SUPPORT Intranet Subject');
        });  
    }



    return $data;
}

public function sendFeedbackEmail(Request $request)
{

    $data = $request->get('value');

    $data = array(
        'name' =>$data['name'],
        'body' => $data['body'],
    );

    \Mail::send('emails.reminder',$data, function ($m)  {

        $m->from('feedback.intranet@app.com', 'FEEDBACK Intranet');

        $m->to('feedback.intranet@project-immobilien.com', 'FEEDBACK Intranet')->subject('FEEDBACK Intranet Subject');
    });

    return $data;
}
}
