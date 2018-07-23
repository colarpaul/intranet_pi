<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\News as News;
use App\Http\Helpers\Helper as Helper;
use App\Http\Models\Objects as Objects;
use App\Http\Models\Service as Service;
use App\Http\Models\Employees as Employees;

class HomeController extends Controller
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
     * Rendering the home(START) page with all needed data
     * page: / or /start
     * 
     * - headerHPData     = header(image + title + text + button)
     * - lastNews         =  last 3 news
     * - employeesOfMonth = 3 random employees
     * - newDocuments     = last 6 documents
     * - wlan             = WLAN header(image + text)
     */
    public function index()
    {
        $employees = Employees::getEmployeesWithImage();
        foreach($employees as $key => $employee){
            $randomEmployees[$key] = $this->generateEmployeeData($employee);
        }

        shuffle($randomEmployees);
        $randomEmployees = array_splice($randomEmployees, 0, 3);

        //NEWS
        $lastNews = News::getHomeNews(3);

        //HOMEPAGE
        $headerHPData    = Service::getHomepageData();
        $homeMessageData = Service::getHomeMessage();
        $wlan            = Service::getWLANData();

        //DOKUMENTE
        $newDocuments = Service::getNewDocuments();

        $data = [
            'employeesOfMonth' => $randomEmployees,
            'newDocuments'     => $newDocuments,
            'lastNews'         => $lastNews,
            'headerHPData'     => $headerHPData,
            'wlan'             => $wlan,
            'homeMessageData'  => $homeMessageData,
        ];

        return view('home', $data);
    }
    
    /**
     * Method: suche()
     *
     * Rendering the SEARCH page with all needed data for a given key
     * page: /suche + ?key="example"
     * 
     * If key exists, data will contain:
     * (it will look in whole database/table for the given key.)
     * - documents 
     * - faqs
     * - objects
     * - employees
     * - news
     */
    public function suche(Request $request)
    {
        $searchKey = $request->get('key');
        if($searchKey){
            //NEWS
            $news = News::getNewsByKey($searchKey);

            //EMPLOYEES
            $employees = Employees::getEmployeesByKey($searchKey);

            $parsedEmployees = [];
            foreach($employees as $key => $employee){
                $parsedEmployees[$key] = $this->generateEmployeeData($employee);
            }

            //DOKUMENTE
            $documents = Service::getDocumentsByKey($searchKey);

            //FAQS
            $faqs = Service::getFAQsByKey($searchKey);

            //OBJEKTS 
            $objects = Objects::getObjectsByKey($searchKey);

            $data = [
                'searchKey' => $searchKey,
                'news'      => $news,
                'employees' => $parsedEmployees,
                'documents' => $documents,
                'faqs'      => $faqs,
                'objects'   => $objects,
            ];
        } else {
            $data = [
                'searchKey' => '',
                'news'      => [],
                'employees' => [],
                'documents' => [],
                'faqs'      => [],
                'objects'   => [],
            ];
        }

        return view('homeSearch', $data);
    }

    /**
     * Method: generateEmployeeData()
     *
     * Create EMPLOYEES DATA in the needed format
     */
    public function generateEmployeeData($employee)
    {
        $data = [
            'cn'              => $employee->cn[0],
            'company'         => $employee->company[0],
            'l'               => $employee->l[0],
            'department'      => $employee->department[0],
            'streetaddress'   => $employee->streetaddress[0],
            'postalcode'      => $employee->postalcode[0],
            'mail'            => $employee->mail[0],
            'title'           => $employee->title[0],
            'telephonenumber' => Helper::formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]),
            'mobile'          => Helper::formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]),
            // whencreated'] = substr($employee->whencreated[0], 0, 4).'-'.substr($employee->whencreated[0], 4, 2).'-'.substr($employee->whencreated[0], 6, 2),
            'thumbnailphoto'  => base64_encode($employee->thumbnailphoto[0]),
        ];

        return $data;
    }

}
