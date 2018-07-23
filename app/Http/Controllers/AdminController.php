<?php

namespace App\Http\Controllers;

use App\Http\Models\Service as Service;
use App\Http\Models\Objects as Objects;
use App\Http\Models\Employees as Employees;
use App\Http\Models\News as News;

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
     * Method: index()
     *
     * Rendering the CMS page
     * page: /cms
     */
    public function index()
    {   
        return view('adminPanel.index');
    }

    /**
     * Method: showDocuments()
     *
     * Rendering the CMS - DOCUMENTS page with all documents from database 
     * page: /cms/documtens
     * 
     * - documents             = all documents 
     * - documentCategories    = all categories from documents 
     * - documentSubcategories = all subcategories from documents 
     */
    public function showDocuments()
    {
        $data = [
            'documents'             => Service::getAllDocuments(),
            'documentCategories'    => json_decode(Service::getAllDocumentCategories()),
            'documentSubcategories' => Service::getAlldocumentSubcategories(),
        ];

        return view('adminPanel.showDocuments', $data);
    }

    /**
     * Method: showDocumentsSortable()
     *
     * Rendering the CMS - DOCUMENTS (SORTABLE) page with all documents from database 
     * page: /cms/documents/sortable
     * 
     * - documents = all documents 
     */
    public function showDocumentsSortable()
    {
        $data = [
            'documents' => Service::getDocumentsSortable(),
        ];

        return view('adminPanel.showDocumentsSortable', $data);
    }

    /**
     * Method: showObjects()
     *
     * Rendering the CMS - OBJECTS page with all documents from database 
     * page: /cms/objects
     * 
     * - objects               = all objects 
     * - documents             = all documents 
     * - documentCategories    = all categories from documents 
     * - documentSubcategories = all subcategories from documents 
     */
    public function showObjects()
    {
        $data = [
            'objects'               => Objects::getObjects(),
            'documents'             => Service::getAllDocuments(),
            'documentCategories'    => json_decode(Service::getAllDocumentCategories()),
            'documentSubcategories' => Service::getAlldocumentSubcategories(),
        ];

        return view('adminPanel.showObjects', $data);
    }

    /**
     * Method: showCentral()
     *
     * Rendering the CMS - CENTRAL page with all centrals from database 
     * page: /cms/central
     * 
     * - centrals    = all centrals 
     * - standorte   = all cities 
     * - abteilungen = all departments 
     * - employees   = all employees
     */
    public function showCentral()
    {
        $centrals                       = Employees::getCentrals();
        $employeesPositionAndDepartment = Employees::getEmployeesPositionAndDepartment();

        $employeesLocation = [];
        $employeesPosition = [];
        foreach($employeesPositionAndDepartment as $employee){
            if(!in_array($employee->l[0], $employeesLocation)){
                array_push($employeesLocation, $employee->l[0]);
            }
            if(!in_array($employee->department[0], $employeesPosition)){
                array_push($employeesPosition, $employee->department[0]);
            }
        }
        
        sort($employeesLocation);
        sort($employeesPosition);

        $emailEmployees = Employees::getEmailEmployees();

        $newEmailEmployees = [];
        foreach($emailEmployees as $key => $employee){
            $newEmailEmployees[$key] = $employee->mail[0];
        }

        sort($newEmailEmployees);

        $data = [
            'centrals'    => $centrals,
            'standorte'   => $employeesLocation,
            'abteilungen' => $employeesPosition,
            'employees'   => $newEmailEmployees,
        ];

        return view('adminPanel.showCentral', $data);
    }

    /**
     * Method: showNews()
     *
     * Rendering the CMS - NEWS page with all news from database 
     * page: /cms/news
     * 
     * - news    = all news 
     * - newsArt = all newsArt 
     */
    public function showNews()
    {
        $data = [
            'news'    => News::getNewsCMS(15),
            'newsArt' => News::getNewsArt(),
        ];

        return view('adminPanel.showNews', $data);
    }

    /**
     * Method: showNewsSortable()
     *
     * Rendering the CMS - NEWS (SORTABLE) page with all news from database 
     * page: /cms/news/sortable
     * 
     * - news = all news 
     */
    public function showNewsSortable()
    {
        $data = [
            'news' => News::getNewsSortable(),
        ];

        return view('adminPanel.showNewsSortable', $data);
    }

    /**
     * Method: showFAQs()
     *
     * Rendering the CMS - FAQS page with all faqs from database 
     * page: /cms/faqs
     * 
     * - faqs = all faqs 
     */
    public function showFAQs()
    {
        $data = [
            'faqs' => Service::getFAQs(),
        ];

        return view('adminPanel.showFAQs', $data);
    }

    /**
     * Method: showFAQsSortable()
     *
     * Rendering the CMS - FAQS (SORTABLE) page with all faqs from database 
     * page: /cms/faqs/sortable
     * 
     * - faqs = all faqs 
     */
    public function showFAQsSortable()
    {
        $data = [
            'faqs' => Service::getFAQsSortable(),
        ];

        return view('adminPanel.showFAQsSortable', $data);
    }

    /**
     * Method: showFAQsStatistics()
     *
     * Rendering the CMS - FAQS (STATISTICS) page with all faqs from database 
     * page: /cms/faqs/statistics
     * 
     * - top5faqs = top 5 faqs 
     */
    public function showFAQsStatistics()
    {
        $data = [
            'top5faqs' => Service::getTop5FAQsClicks(),
        ];

        return view('adminPanel.showFAQsStatistics', $data);
    }

    /**
     * Method: showHomepage()
     *
     * Rendering the CMS - HOMEPAGE page with all homepage data from database 
     * page: /cms/homepage
     * 
     * - homepageData    = all homepage data 
     * - homeMessageData = all home_message data 
     */
    public function showHomepage()
    {
        $data = [
            'homepageData'    => Service::getHomepageData(),
            'homeMessageData' => Service::getHomeMessage(),
        ];
        
        return view('adminPanel.showHomepage', $data);
    }

    /**
     * Method: showHomepage()
     *
     * Rendering the CMS - WLAN page with wlan data from database 
     * page: /cms/wlan
     * 
     * - wlan = wlan data 
     */
    public function showHomeSettings()
    { 
        $data = [
            'wlan' => Service::getWLANData(),
        ];

        return view('adminPanel.showWLANBanner', $data);
    }

    /**
     * Method: viewAnalytics()
     *
     * Rendering MATOMO - ANALYTICS
     * page: /analytics
     */
    public function viewAnalytics()
    {
        return view('analytics.index');
    }
}
