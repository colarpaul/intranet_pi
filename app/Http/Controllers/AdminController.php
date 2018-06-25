<?php

namespace App\Http\Controllers;

use App\Http\Models\Service;
use App\Http\Models\Objects;
use App\Http\Models\Employees;
use App\Http\Models\News;

class AdminController extends Controller
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
    public function index()
    {   
        return view('adminPanel.index');
    }

    public function showDocuments()
    {
        $serviceModel = new Service();

        $documents = $serviceModel->getAllDocuments();
        $documentCategories = $serviceModel->getAllDocumentCategories();
        $documentSubcategories = $serviceModel->getAlldocumentSubcategories();

        $data = array(
            'documents' => $documents,
            'documentCategories' => json_decode($documentCategories),
            'documentSubcategories' => $documentSubcategories,
        );

        return view('adminPanel.showDocuments', $data);
    }

    public function showObjects()
    {
        $serviceModel = new Service();
        $objectsModel = new Objects();


        $objects = $objectsModel->getObjects();

        
        $documents = $serviceModel->getAllDocuments();
        $documentCategories = $serviceModel->getAllDocumentCategories();
        $documentSubcategories = $serviceModel->getAlldocumentSubcategories();


        $data = array(
            'documents' => $documents,
            'objects' => $objects,
            'documentCategories' => json_decode($documentCategories),
            'documentSubcategories' => $documentSubcategories,
        );

        return view('adminPanel.showObjects', $data);
    }

    public function showCentral()
    {
        $employeesModel = new Employees();

        $employeesLocation = array();
        $employeesPosition = array();

        $centrals = $employeesModel->getCentrals();

        $employeesPositionAndDepartment = $employeesModel->getEmployeesPositionAndDepartment();

        foreach($employeesPositionAndDepartment as $employee){
            array_push($employeesLocation, $employee->l[0]);
            if($employee->department != ''){
                array_push($employeesPosition, $employee->department[0]);
            }
        }

        $employeesLocation = array_unique($employeesLocation);
        $employeesPosition = array_unique($employeesPosition);
        
        sort($employeesLocation);
        sort($employeesPosition);

        $emailEmployees = $employeesModel->getEmailEmployees();

        $newEmailEmployees = array();
        foreach($emailEmployees as $key => $employee){
            if(!empty($employee->mail[0])){
                $newEmailEmployees[$key] = $employee->mail[0];
            }
        }

        sort($newEmailEmployees);

        $data = array(
            'centrals' => $centrals,
            'standorte' => $employeesLocation,
            'abteilungen' => $employeesPosition,
            'employees' => $newEmailEmployees,
        );

        return view('adminPanel.showCentral', $data);
    }

    public function showNews()
    {
        $newsModel = new News();
        $news = $newsModel->getNewsCMS(15);
        $newsArt = $newsModel->getNewsArt();

        $data = array(
            'news' => $news,
            'newsArt' => $newsArt
        );

        return view('adminPanel.showNews', $data);
    }

    public function showNewsSortable()
    {
        $newsModel = new News();
        $news = $newsModel->getNewsSortable();

        $data = array(
            'news' => $news,
        );

        return view('adminPanel.showNewsSortable', $data);
    }

    public function showDocumentsSortable()
    {
        $serviceModel = new Service();
        $documents = $serviceModel->getDocumentsSortable();

        $data = array(
            'documents' => $documents,
        );

        return view('adminPanel.showDocumentsSortable', $data);
    }

    public function showFAQsSortable()
    {
        $serviceModel = new Service();
        $faqs = $serviceModel->getFAQsSortable();

        $data = array(
            'faqs' => $faqs,
        );

        return view('adminPanel.showFAQsSortable', $data);
    }

    public function showFAQsStatistics()
    {
        $serviceModel = new Service();
        $top5faqs = $serviceModel->getTop5FAQsClicks();

        $data = array(
            'top5faqs' => $top5faqs,
        );

        return view('adminPanel.showFAQsStatistics', $data);
    }

    public function showFAQs(){
        $serviceModel = new Service();
        $faqs = $serviceModel->getFAQs();

        $data = array(
            'faqs' => $faqs,
        );

        return view('adminPanel.showFAQs', $data);
    }

    public function showHomepage()
    {
        $serviceModel = new Service();
        $homepageData = $serviceModel->getHomepageData();

        $data = array(
            'homepageData' => $homepageData,
        );

        return view('adminPanel.showHomepage', $data);
    }

    public function showWLANBanner()
    { 
        $serviceModel = new Service();
        $wlanData = $serviceModel->getWLANData();

        $data = array(
            'wlan' => $wlanData,
        );

        return view('adminPanel.showWLANBanner', $data);
    }

    public function viewAnalytics()
    {
        return view('analytics.index');
    }
}
