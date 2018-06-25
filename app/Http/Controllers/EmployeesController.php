<?php

namespace App\Http\Controllers;

use App\Http\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Palmabit\ContactCsv\modules\ContactCsv;

class EmployeesController extends Controller 
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
        $employeesLocation = array();
        $employeesPosition = array();
        // $employeesOfMonth = array();
        $employeesWithImage = array();

        $employeesModel = new Employees();

        $allEmployees = $employeesModel->getEmployees();
        $employees = $employeesModel->getEmployeesWithImage();

        foreach($employees as $key => $employee){
            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $employeesWithImage[$key]['cn'] = $employee->cn[0];
                $employeesWithImage[$key]['company'] = $employee->company[0];
                $employeesWithImage[$key]['l'] = $employee->l[0];
                $employeesWithImage[$key]['department'] = $employee->department[0];
                $employeesWithImage[$key]['streetaddress'] = $employee->streetaddress[0];
                $employeesWithImage[$key]['postalcode'] = $employee->postalcode[0];
                $employeesWithImage[$key]['mail'] = $employee->mail[0];
                $employeesWithImage[$key]['title'] = $employee->title[0];
                $employeesWithImage[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
                $employeesWithImage[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
                // $employeesWithImage[$key]['whencreated'] = substr($employee->whencreated[0], 0, 4).'-'.substr($employee->whencreated[0], 4, 2).'-'.substr($employee->whencreated[0], 6, 2);
                $employeesWithImage[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }
        }

        foreach($allEmployees as $employee){
            if($employee->title[0] != ''){
                array_push($employeesLocation, $employee->l[0]);
                if($employee->department != ''){
                    array_push($employeesPosition, $employee->department[0]);
                }
            }
        }

        $employeesLocation = array_unique($employeesLocation);
        $employeesPosition = array_unique($employeesPosition);
        
        sort($employeesLocation);
        sort($employeesPosition);

        $data = array(
            'employees' => $employeesWithImage,
            'employeesLocation' => $employeesLocation,
            'employeesPosition' => $employeesPosition,
        );

        return view('employees', $data);
    }

    public function getEmployeesByName(Request $request) 
    {
        $employeesModel = new Employees();

        $name = $request->input('name');

        $employees = $employeesModel->getEmployeesByName($name);

        $newArrayEmployees = array();
        foreach($employees as $key => $employee){
            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $newArrayEmployees[$key]['cn'] = $employee->cn[0];
                $newArrayEmployees[$key]['mail'] = $employee->mail[0];
                $newArrayEmployees[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
                $newArrayEmployees[$key]['title'] = $employee->title[0];
                $newArrayEmployees[$key]['company'] = $employee->company[0];
                $newArrayEmployees[$key]['l'] = $employee->l[0];
                // $newArrayEmployees[$key]['whencreated'] = $employee->whencreated[0];
                $newArrayEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
                $newArrayEmployees[$key]['postalcode'] = $employee->postalcode[0];
                $newArrayEmployees[$key]['department'] = $employee->department[0];
                $newArrayEmployees[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
                $newArrayEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }
        } 

        sort($newArrayEmployees);

        return $newArrayEmployees;
    }

    public function getEmployeeByEmail(Request $request) 
    {
        $employeesModel = new Employees();

        $email = $request->input('email');

        $employee = $employeesModel->getEmployeeByEmail($email);

        $newArrayEmployees = array();
        $newArrayEmployees['cn'] = $employee->cn[0];
        $newArrayEmployees['mail'] = $employee->mail[0];
        $newArrayEmployees['telephonenumber'] = $employee->telephonenumber[0];
        $newArrayEmployees['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
        $newArrayEmployees['title'] = $employee->title[0];
        $newArrayEmployees['company'] = $employee->company[0];
        $newArrayEmployees['l'] = $employee->l[0];
        // $newArrayEmployees['whencreated'] = $employee->whencreated[0];
        $newArrayEmployees['streetaddress'] = $employee->streetaddress[0];
        $newArrayEmployees['postalcode'] = $employee->postalcode[0];
        $newArrayEmployees['department'] = $employee->department[0];
        $newArrayEmployees['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
        $newArrayEmployees['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);

        return $newArrayEmployees;
    }

    public function getEmployeeByName(Request $request) 
    {
        $employeesModel = new Employees();

        $name = $request->input('name');

        $employees = $employeesModel->getEmployeeByName($name);

        $newArrayEmployees = array();
        foreach($employees as $key => $employee){
            $newArrayEmployees[$key]['cn'] = $employee->cn[0];
            $newArrayEmployees[$key]['mail'] = $employee->mail[0];
            $newArrayEmployees[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
            $newArrayEmployees[$key]['title'] = $employee->title[0];
            $newArrayEmployees[$key]['company'] = $employee->company[0];
            $newArrayEmployees[$key]['l'] = $employee->l[0];
            // $newArrayEmployees[$key]['whencreated'] = $employee->whencreated[0];
            $newArrayEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
            $newArrayEmployees[$key]['postalcode'] = $employee->postalcode[0];
            $newArrayEmployees[$key]['department'] = $employee->department[0];
            $newArrayEmployees[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
            $newArrayEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
        } 

        return $newArrayEmployees;
    }

    public function getAllEmployees() 
    {
        $employeesModel = new Employees();

        $employees = $employeesModel->getEmployees();

        $newArrayEmployees = array();
        foreach($employees as $key => $employee){
            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $newArrayEmployees[$key]['cn'] = $employee->cn[0];
                $newArrayEmployees[$key]['mail'] = $employee->mail[0];
                $newArrayEmployees[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
                $newArrayEmployees[$key]['title'] = $employee->title[0];
                $newArrayEmployees[$key]['company'] = $employee->company[0];
                $newArrayEmployees[$key]['l'] = $employee->l[0];
                // $newArrayEmployees[$key]['whencreated'] = $employee->whencreated[0];
                $newArrayEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
                $newArrayEmployees[$key]['postalcode'] = $employee->postalcode[0];
                $newArrayEmployees[$key]['department'] = $employee->department[0];
                $newArrayEmployees[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
                $newArrayEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }
        }

        // $employees = array_values(array_values((array)$employees)[0]);
        // sort($employees);
        sort($newArrayEmployees);

        return $newArrayEmployees;
    }

    public function getEmployeesByLocation(Request $request) 
    {
        $employeesModel = new Employees();

        $location = $request->input('location');

        $employees = $employeesModel->getEmployeesByLocation($location);

        $newArrayEmployees = array();
        foreach($employees as $key => $employee){
            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $newArrayEmployees[$key]['cn'] = $employee->cn[0];
                $newArrayEmployees[$key]['mail'] = $employee->mail[0];
                $newArrayEmployees[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
                $newArrayEmployees[$key]['title'] = $employee->title[0];
                $newArrayEmployees[$key]['company'] = $employee->company[0];
                $newArrayEmployees[$key]['l'] = $employee->l[0];
                // $newArrayEmployees[$key]['whencreated'] = $employee->whencreated[0];
                $newArrayEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
                $newArrayEmployees[$key]['postalcode'] = $employee->postalcode[0];
                $newArrayEmployees[$key]['department'] = $employee->department[0];
                $newArrayEmployees[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
                $newArrayEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }
        }

        // $employees = array_values(array_values((array)$employees)[0]);
        // sort($employees);
        sort($newArrayEmployees);

        return $newArrayEmployees;
    }

    public function getEmployeesByPosition(Request $request) 
    {
        $employeesModel = new Employees();

        $position = $request->input('position');

        $employees = $employeesModel->getEmployeesByPosition($position);

        $newArrayEmployees = array();
        foreach($employees as $key => $employee){
            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $newArrayEmployees[$key]['cn'] = $employee->cn[0];
                $newArrayEmployees[$key]['mail'] = $employee->mail[0];
                $newArrayEmployees[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
                $newArrayEmployees[$key]['title'] = $employee->title[0];
                $newArrayEmployees[$key]['company'] = $employee->company[0];
                $newArrayEmployees[$key]['l'] = $employee->l[0];
                // $newArrayEmployees[$key]['whencreated'] = $employee->whencreated[0];
                $newArrayEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
                $newArrayEmployees[$key]['postalcode'] = $employee->postalcode[0];
                $newArrayEmployees[$key]['department'] = $employee->department[0];
                $newArrayEmployees[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
                $newArrayEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }
        }

        $newArrayEmployeesSortedByLocation = array();
        foreach($newArrayEmployees as $key => $value){
            $newArrayEmployeesSortedByLocation[$value['l']][$value['cn']] = $value;
        }


        ksort($newArrayEmployeesSortedByLocation);

        return $newArrayEmployeesSortedByLocation;
    }

    public function getEmployeesByLocationAndPosition(Request $request) 
    {
        $employeesModel = new Employees();

        $location = $request->input('location');
        $position = $request->input('position');

        $employees = $employeesModel->getEmployeesByLocationAndPosition($location, $position);

        $newArrayEmployees = array();
        foreach($employees as $key => $employee){
            if($employee->title[0] == ''){
                unset($employees[$key]);
            } else {
                $newArrayEmployees[$key]['cn'] = $employee->cn[0];
                $newArrayEmployees[$key]['mail'] = $employee->mail[0];
                $newArrayEmployees[$key]['telephonenumber'] = $this->formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]);
                $newArrayEmployees[$key]['title'] = $employee->title[0];
                $newArrayEmployees[$key]['company'] = $employee->company[0];
                $newArrayEmployees[$key]['l'] = $employee->l[0];
                // $newArrayEmployees[$key]['whencreated'] = $employee->whencreated[0];
                $newArrayEmployees[$key]['streetaddress'] = $employee->streetaddress[0];
                $newArrayEmployees[$key]['postalcode'] = $employee->postalcode[0];
                $newArrayEmployees[$key]['department'] = $employee->department[0];
                $newArrayEmployees[$key]['mobile'] = $this->formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]);
                $newArrayEmployees[$key]['thumbnailphoto'] = base64_encode($employee->thumbnailphoto[0]);
            }
        }

        $newArrayEmployeesSortedByLocation = array();
        foreach($newArrayEmployees as $key => $value){
            $newArrayEmployeesSortedByLocation[$value['l']][$value['cn']] = $value;
        }

        ksort($newArrayEmployeesSortedByLocation);

        // $employees = array_values(array_values((array)$employees)[0]);
        // sort($employees);
        // sort($newArrayEmployees);

        return $newArrayEmployeesSortedByLocation;
    }

    public function getCentralEmployeesByPosition(Request $request){
        $employeesModel = new Employees();

        $position = $request->input('position');

        return $employeesModel->getCentralEmployeesByPosition($position);
    }

    public function getCentralEmployeesByLocationAndPosition(Request $request){
        $employeesModel = new Employees();

        $location = $request->input('location');
        $position = $request->input('position');

        return $employeesModel->getCentralEmployeesByLocationAndPosition($location, $position);
    }
    
    public function addCentral(Request $request) 
    {
        $employeesModel = new Employees();

        $data = array(
            'zentrale' => $request->input('centralZentrale'),
            'strasse' => $request->input('centralStrasse'),
            'telefon' => $request->input('centralTelefon'),
            'abteilung' => $request->input('centralAbteilung'),
            'standort' => str_replace(' ', '', $request->input('centralStandort')),
            'sekretariat' => $request->input('centralSekretariat'),
        );

        $employeesModel->addCentral($data);  

        return back();
    } 

    public function removeCentralById(Request $request) 
    {
        $employeesModel = new Employees();

        $data = array(
            'id' => $request->get('id'),
        );

        $employeesModel->removeCentralById($data);  

        return true;
    }   

    public function getCentralInfo(Request $request)
    {
        $employeesModel = new Employees();

        $centralId = $request->input('centralId');

        $central = $employeesModel->showCentral($centralId);

        return json_encode($central);
    }

    public function updateCentral(Request $request)
    {
        $employeesModel = new Employees();

        $data = array(
            "id" => $request->input('centralId'),
            "zentrale" => $request->input('centralZentrale'),
            "strasse" => $request->input('centralStrasse'),
            "telefon" => $request->input('centralTelefon'),
            "abteilung" => $request->input('centralAbteilung'),
            'standort' => str_replace(' ', '', $request->input('centralStandort')),
            "sekretariat" => $request->input('centralSekretariat'),
        );

        $employeesModel->updateCentral($data);

        return back();
    }

    static function formatPhoneNumberByLocationAndStreet($phoneNumber, $location, $street) {
     switch($location){
        case 'Nürnberg':
        if(strlen($phoneNumber) == 12){
            if (strpos($street, 'Bucher Straße 79a') !== false){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 3) . ' ' . substr($phoneNumber, 11, 1);
            } else {
                // doesn't exists
            }
        } elseif(strlen($phoneNumber) == 13){
            if (strpos($street, 'Bucher Straße 79a') !== false){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 3) . ' ' . substr($phoneNumber, 11, 2);
            } else {
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1);
            }
        } elseif(strlen($phoneNumber) == 14) {
            if (strpos($street, 'Bucher Straße 79a') !== false){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 3) . ' ' . substr($phoneNumber, 11, 3);
            } else {
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 2);
            }
        } elseif(strlen($phoneNumber) == 15) {
            if (strpos($street, 'Bucher Straße 79a') !== false){
                // doesn't exists
            } else {
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 3);
            }
        }
        break;
        case 'Berlin':
        if(strlen($phoneNumber) == 12){
            if (strpos($street, 'Volmerstraße 10') !== false){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1);
            } else {
                // doesn't exists
            }
        } elseif(strlen($phoneNumber) == 13){
            if (strpos($street, 'Volmerstraße 10') !== false){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 2);
            } else {
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1);
            }
        } elseif(strlen($phoneNumber) == 14) {
            if (strpos($street, 'Volmerstraße 10') !== false){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 3);
            } else {
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
            }
        } elseif(strlen($phoneNumber) == 15) {
            if (strpos($street, 'Volmerstraße 10') !== false){
                // doesn't exists
            } else {
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 2);
            }
        }
        break;
        case 'München':
        if(strlen($phoneNumber) == 13){
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1);
        } elseif(strlen($phoneNumber) == 14) {
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
        }
        break;
        case 'Hamburg':
        if(strlen($phoneNumber) == 13){
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1);
        } elseif(strlen($phoneNumber) == 14) {
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
        } elseif(strlen($phoneNumber) == 15) {
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 2);
        }
        break;
        case 'Frankfurt am Main':
        if(substr($phoneNumber, 3, 2) == 69){
            if(strlen($phoneNumber) == 13){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1);
            } elseif(strlen($phoneNumber) == 14){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
            }
        } elseif(substr($phoneNumber, 3, 4) == 6122) {
            if(strlen($phoneNumber) == 13){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . '.' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1);
            } elseif(strlen($phoneNumber) == 14){
                $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . '.' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
            }
        }
        break;
        case 'Düsseldorf':
        if(strlen($phoneNumber) == 12){
            $phoneNumber = substr($phoneNumber, 0, 4) . '.' . substr($phoneNumber, 4, 2) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 1);
        } elseif(strlen($phoneNumber) == 13){
            $phoneNumber = substr($phoneNumber, 0, 4) . '.' . substr($phoneNumber, 4, 2) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 1) . substr($phoneNumber, 11, 1);
        }
        break;
        case 'Wien':
        if(strlen($phoneNumber) == 12){
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 1) . '.' . substr($phoneNumber, 4, 3) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1);
        } elseif(strlen($phoneNumber) == 13){
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 1) . '.' . substr($phoneNumber, 4, 3) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1) . substr($phoneNumber, 12, 1);
        } elseif(strlen($phoneNumber) == 14){
            $phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 1) . '.' . substr($phoneNumber, 4, 3) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1) . substr($phoneNumber, 12, 2);
        }
        break;
        default:
        $phoneNumber = $phoneNumber;
        break;
    }

    return $phoneNumber;
}

static function formatMobileNumberByLocation($mobileNumber, $location)
{
    switch($location){
        case 'Wien':
        $mobileNumber = substr($mobileNumber, 0, 3) . ' ' . substr($mobileNumber, 3, 3) . '.' . substr($mobileNumber, 6, 2) . ' ' . substr($mobileNumber, 8, 2) . ' ' . substr($mobileNumber, 10, 2) . ' ' . substr($mobileNumber, 12, 2);
        break;
        default:
        $mobileNumber = substr($mobileNumber, 0, 3) . ' ' . substr($mobileNumber, 3, 3) . '.' . substr($mobileNumber, 6, 2) . ' ' . substr($mobileNumber, 8, 2) . ' ' . substr($mobileNumber, 10, 2) . ' ' . substr($mobileNumber, 12, 2);
        break;
        return;
    }

    if(trim($mobileNumber) == '.'){
        $mobileNumber = '';
    }

    return $mobileNumber;
}

function downloadVCard($email){

    $employeeModel = new Employees;
    $employee = $employeeModel->getEmployeeByEmail($email);

    
    $name = explode(', ', $employee->cn[0]);
    //Colar
    $firstName = $name[0];
    //Paul
    $lastName = $name[1];

    header('Content-Type: text/vcf; charset=utf-8');  
    header('Content-Disposition: attachment; filename=' . $name[1] . '_' . $name[0] . '.vcf');  
    $output = fopen("php://output", "w");  
    fwrite($output, 'BEGIN:VCARD');
    fwrite($output, "\n");
    fwrite($output, 'N:'.$firstName.';'.$lastName.'');
    fwrite($output, "\n");
    fwrite($output, 'FN:'.$employee->cn[0].'');
    fwrite($output, "\n");
    fwrite($output, 'ORG:'.$employee->company[0].'');
    fwrite($output, "\n");
    fwrite($output, 'TITLE:'.$employee->title[0].'');
    fwrite($output, "\n");
    fwrite($output, 'TEL;WORK;VOICE:'.$employee->telephonenumber[0].'');
    fwrite($output, "\n");
    fwrite($output, 'EMAIL;PREF;INTERNET:'.$email.'');
    fwrite($output, "\n");
    fwrite($output, 'ADR;WORK;PREF;CHARSET=utf-8:;;;'.$employee->streetaddress[0]. ', ' . $employee->l[0] .';;;');
    fwrite($output, "\n");
    fwrite($output, 'END:VCARD');
    fclose($output);  
}


}
