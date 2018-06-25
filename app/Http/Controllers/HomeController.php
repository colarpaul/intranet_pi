<?php

namespace App\Http\Controllers;

use App\Http\Models\Employees;
use App\Http\Models\News;
use App\Http\Models\Objects;
use App\Http\Models\Gallery;
use App\Http\Models\Service;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $employeesOfMonth = array();
        $employeesModel = new Employees();

        // $employees = $employeesModel->getHomeEmployees();
        // $employees = $employeesModel->getHomeEmployees();
        $employees = $employeesModel->getEmployeesWithImage();
        
        // $employees = $employeesModel->getEmployees();

        foreach($employees as $key => $employee){

            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $employeesOfMonth[$key]['cn'] = $employee->cn[0];
                $employeesOfMonth[$key]['company'] = $employee->company[0];
                $employeesOfMonth[$key]['l'] = $employee->l[0];
                $employeesOfMonth[$key]['department'] = $employee->department[0];
                $employeesOfMonth[$key]['streetaddress'] = $employee->streetaddress[0];
                $employeesOfMonth[$key]['postalcode'] = $employee->postalcode[0];
                $employeesOfMonth[$key]['mail'] = $employee->mail[0];
                $employeesOfMonth[$key]['title'] = $employee->title[0];
                $employeesOfMonth[$key]['telephonenumber'] = $employee->telephonenumber[0];
                $employeesOfMonth[$key]['mobile'] = $employee->mobile[0];
                $employeesOfMonth[$key]['whencreated'] = substr($employee->whencreated[0], 0, 4).'-'.substr($employee->whencreated[0], 4, 2).'-'.substr($employee->whencreated[0], 6, 2);
                $employeesOfMonth[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }

        }

        shuffle($employeesOfMonth);
        $employeesOfMonth = array_splice($employeesOfMonth, 0, 3);

        // usort($employeesOfMonth, function ($a, $b) {
        //     return strnatcmp($a['whencreated'], $b['whencreated']);
        // });

        // $todayDate = date("Y-m-d", strtotime("-1 month", strtotime(date('Y-m-d'))));

        // $employeesOfMonth = array_reverse($employeesOfMonth);
        // foreach($employeesOfMonth as $key => $employee){
        //     if(!empty($employeesOfMonth[$key])){
        //         if($employeesOfMonth[$key]['whencreated'] > $todayDate){
        //             unset($employeesOfMonth[$key]);
        //         }
        //     }
        // }
        // $employeesOfMonth = array_splice($employeesOfMonth, 0, 3);

        $objectsModel = new Objects();
        $lastObjects = $objectsModel->getLastAddedObjects();

        // $galleryModel = new Gallery();
        // $lastImages = $galleryModel->getLastAddedImages();

        $newsModel = new News();
        $lastNews = $newsModel->getHomeNews(3);

        $serviceModel = new Service();
        $homepageData = $serviceModel->getHomepageData();
        $wlan = $serviceModel->getWLANData();

        $newDocuments = $serviceModel->getNewDocuments();

        $data = array(
            'employeesOfMonth' => $employeesOfMonth,
            'lastObjects' => $lastObjects,
            'newDocuments' => $newDocuments,
            // 'lastImages' => $lastImages,
            'lastNews' => $lastNews,
            'homepageData' => $homepageData,
            'wlan' => $wlan,
        );

        return view('home', $data);
    }

    public function suche(Request $request){

        $searchKey = $request->get('key');
        if($searchKey){

            //NEWS
            $newsModel = new News();
            $news = $newsModel->getNewsByKey($searchKey);

            //EMPLOYEES
            $employeesModel = new Employees();
            $employees = $employeesModel->getEmployeesByKey($searchKey);

            $parsedEmployees = array();
            foreach($employees as $key => $employee){
                if($employee->title[0] == ''){
                    unset($employees[$key]);
                } else {
                    $parsedEmployees[$key]['cn'] = $employee->cn[0];
                    $parsedEmployees[$key]['company'] = $employee->company[0];
                    $parsedEmployees[$key]['l'] = $employee->l[0];
                    $parsedEmployees[$key]['department'] = $employee->department[0];
                    $parsedEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
                    $parsedEmployees[$key]['postalcode'] = $employee->postalcode[0];
                    $parsedEmployees[$key]['mail'] = $employee->mail[0];
                    $parsedEmployees[$key]['title'] = $employee->title[0];
                    $parsedEmployees[$key]['telephonenumber'] = $employee->telephonenumber[0];
                    $parsedEmployees[$key]['mobile'] = $employee->mobile[0];
                    $parsedEmployees[$key]['whencreated'] = substr($employee->whencreated[0], 0, 4).'-'.substr($employee->whencreated[0], 4, 2).'-'.substr($employee->whencreated[0], 6, 2);
                    $parsedEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
                }

            }

            //DOKUMENTE
            $serviceModel = new Service();
            $documents = $serviceModel->getDocumentsByKey($searchKey);

            //FAQS
            $serviceModel = new Service();
            $faqs = $serviceModel->getFAQsByKey($searchKey);

            //OBJEKTS 
            $objectsModel = new Objects();
            $objects = $objectsModel->getObjectsByKey($searchKey);

            $data = array(
                'searchKey' => $searchKey,
                'news' => $news,
                'employees' => $parsedEmployees,
                'documents' => $documents,
                'faqs' => $faqs,
                'objects' => $objects,
            );
        } else {
            $data = array(
                'searchKey' => '',
                'news' => array(),
                'employees' => array(),
                'documents' => array(),
                'faqs' => array(),
                'objects' => array(),
            );
        }

        return view('homeSearch', $data);
    }

}
