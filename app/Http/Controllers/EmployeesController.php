<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Helpers\Helper as Helper;
use App\Http\Models\Employees as Employees;

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
     * Method: index()
     *
     * Rendering the EMPLOYEES page with all employees from database 
     * page: /mitarbeiter
     * 
     * - employees         = all employees with image
     * - employeesLocation = location from all employees 
     * - employeesPosition = position from all employees 
     */
    public function index(Request $request)
    {   
        $employees                        = Employees::getEmployeesWithImage();
        $employeesLocationsAndDepartments = Employees::getEmployeesLocationsAndDepatments();

        $employeesLocation = [];
        $employeesPosition = [];
        foreach($employeesLocationsAndDepartments as $employee){
            if(!in_array($employee->l[0], $employeesLocation)){
                array_push($employeesLocation, $employee->l[0]);
            }
            if(!in_array($employee->department[0], $employeesPosition)){
                array_push($employeesPosition, $employee->department[0]);
            }
        }
        
        sort($employeesLocation);
        sort($employeesPosition);

        $data = [
            'employees'         => $employees,
            'employeesLocation' => $employeesLocation,
            'employeesPosition' => $employeesPosition,
        ];

        return view('employees', $data);
    }

    /**
     * Method: getEmployeesByName()
     *
     * Returning all EMPLOYEES by a given NAME
     * page: /employees/getEmployeesByName
     */
    public function getEmployeesByName(Request $request) 
    {
        $employees      = Employees::getEmployeesByName($request->input('name'));

        $newArrayEmployees = [];
        foreach($employees as $key => $employee){
            $newArrayEmployees[$key] = $this->generateEmployeeData($employee);
        }

        sort($newArrayEmployees);

        return $newArrayEmployees;
    }

    /**
     * Method: getEmployeeByEmail()
     *
     * Returning all EMPLOYEES by a given EMAIL
     * page: /employees/getEmployeeByEmail
     */
    public function getEmployeeByEmail(Request $request) 
    {
        $employee       = Employees::getEmployeeByEmail($request->input('email'));
        $employee       = $this->generateEmployeeData($employee); 

        return $employee;
    }

    /**
     * Method: getEmployeeByName()
     *
     * Returning an EMPLOYEE by a given NAME
     * page: /employees/getEmployeeByName
     */
    public function getEmployeeByName(Request $request) 
    {
        $employees      = Employees::getEmployeeByName($request->input('name'));

        $newArrayEmployees = [];
        foreach($employees as $key => $employee){
            $newArrayEmployees[$key] = $this->generateEmployeeData($employee);
        }

        return $newArrayEmployees;
    }

    /**
     * Method: getAllEmployees()
     *
     * Returning all EMPLOYEES
     * page: /employees/getAllEmployees
     */
    public function getAllEmployees() 
    {
        $employees      = Employees::getEmployees();

        foreach($employees as $key => $employee){
            $newArrayEmployees[$key] = $this->generateEmployeeData($employee);
        }

        sort($newArrayEmployees);

        return $newArrayEmployees;
    }

    /**
     * Method: getEmployeesByLocation()
     *
     * Returning all EMPLOYEES by a given LOCATION 
     * page: /employees/getEmployeesByLocation
     */
    public function getEmployeesByLocation(Request $request) 
    {
        $employees      = Employees::getEmployeesByLocation($request->input('location'));

        foreach($employees as $key => $employee){
            $newArrayEmployees[$key] = $this->generateEmployeeData($employee);
        }

        sort($newArrayEmployees);

        return $newArrayEmployees;
    }

    /**
     * Method: getEmployeesByPosition()
     *
     * Returning all EMPLOYEES by a given POSITION 
     * page: /employees/getEmployeesByPosition
     */
    public function getEmployeesByPosition(Request $request) 
    {
        $position = $request->input('position');

        $employees      = Employees::getEmployeesByPosition($position);

        $newArrayEmployees = [];
        foreach($employees as $key => $employee){
            $newArrayEmployees[$key] = $this->generateEmployeeData($employee);
        }

        $newArrayEmployeesSortedByLocation = [];
        foreach($newArrayEmployees as $key => $value){
            $newArrayEmployeesSortedByLocation[$value['l']][$value['cn']] = $value;
        }

        ksort($newArrayEmployeesSortedByLocation);

        return $newArrayEmployeesSortedByLocation;
    }

    /**
     * Method: getEmployeesByLocationAndPosition()
     *
     * Returning all EMPLOYEES by a given LOCATION and POSITION 
     * page: /employees/getEmployeesByLocationAndPosition
     */
    public function getEmployeesByLocationAndPosition(Request $request) 
    {
        $location = $request->input('location');
        $position = $request->input('position');

        $employees      = Employees::getEmployeesByLocationAndPosition($location, $position);

        $newArrayEmployees = [];
        foreach($employees as $key => $employee){
            $newArrayEmployees[$key] = $this->generateEmployeeData($employee);
        }

        $newArrayEmployeesSortedByLocation = [];
        foreach($newArrayEmployees as $key => $value){
            $newArrayEmployeesSortedByLocation[$value['l']][$value['cn']] = $value;
        }

        ksort($newArrayEmployeesSortedByLocation);

        return $newArrayEmployeesSortedByLocation;
    }

    /**
     * Method: getCentralEmployeesByPosition()
     *
     * Returning all CENTRAL EMPLOYEES by a given POSITION 
     * page: /employees/getCentralEmployeesByPosition
     */
    public function getCentralEmployeesByPosition(Request $request)
    {
        $position = $request->input('position');

        return Employees::getCentralEmployeesByPosition($position);
    }

    /**
     * Method: getCentralEmployeesByLocationAndPosition()
     *
     * Returning all CENTRAL EMPLOYEES by a given LOCATION and POSITION 
     * page: /employees/getCentralEmployeesByLocationAndPosition
     */
    public function getCentralEmployeesByLocationAndPosition(Request $request)
    {
        $location = $request->input('location');
        $position = $request->input('position');

        return Employees::getCentralEmployeesByLocationAndPosition($location, $position);
    }

    /**
     * Method: addCentral()
     *
     * Adding a CENTRAL
     * page: /employees/addCentral
     */
    public function addCentral(Request $request) 
    {
        $data = [
            'zentrale'    => $request->input('centralZentrale'),
            'strasse'     => $request->input('centralStrasse'),
            'telefon'     => $request->input('centralTelefon'),
            'abteilung'   => $request->input('centralAbteilung'),
            'standort'    => str_replace(' ', '', $request->input('centralStandort')),
            'sekretariat' => $request->input('centralSekretariat'),
        ];

        Employees::addCentral($data);  

        return back();
    } 

    /**
     * Method: removeCentralById()
     *
     * Remove a CENTRAL by a given CENTRAL ID
     * page: /employees/removeCentralById
     */
    public function removeCentralById(Request $request) 
    {
        Employees::removeCentralById($request->get('id'));  

        return true;
    }   

    /**
     * Method: getCentralInfo()
     *
     * Returning a CENTRAL by a given CENTRAL ID
     * page: /employees/getCentralInfo
     */
    public function getCentralInfo(Request $request)
    {
        $central        = Employees::showCentral($request->input('centralId'));

        return json_encode($central);
    }

    /**
     * Method: updateCentral()
     *
     * Update a CENTRAL by given CENTRAL DATA
     * page: /employees/updateCentral
     */
    public function updateCentral(Request $request)
    {

        $data = [
            "id" => $request->input('centralId'),
            "zentrale" => $request->input('centralZentrale'),
            "strasse" => $request->input('centralStrasse'),
            "telefon" => $request->input('centralTelefon'),
            "abteilung" => $request->input('centralAbteilung'),
            'standort' => str_replace(' ', '', $request->input('centralStandort')),
            "sekretariat" => $request->input('centralSekretariat'),
        ];

        Employees::updateCentral($data);

        return back();
    }

    /**
     * Method: generateEmployeeData()
     *
     * Create EMPLOYEES DATA in the needed format
     */
    public function generateEmployeeData($employee)
    {
        $data = [
            'cn' => $employee->cn[0],
            'company' => $employee->company[0],
            'l' => $employee->l[0],
            'department' => $employee->department[0],
            'streetaddress' => $employee->streetaddress[0],
            'postalcode' => $employee->postalcode[0],
            'mail' => $employee->mail[0],
            'title' => $employee->title[0],
            'telephonenumber' => Helper::formatPhoneNumberByLocationAndStreet($employee->telephonenumber[0], $employee->l[0], $employee->streetaddress[0]),
            'mobile' => Helper::formatMobileNumberByLocation($employee->mobile[0], $employee->l[0]),
            // whencreated'] = substr($employee->whencreated[0], 0, 4).'-'.substr($employee->whencreated[0], 4, 2).'-'.substr($employee->whencreated[0], 6, 2),
            'thumbnailphoto' => base64_encode($employee->thumbnailphoto[0]),
        ];

        return $data;
    }

    /**
     * Method: downloadVCard()
     *
     * Format an outlook card to be after downloaded
     * (for a specific email(employee))
     */
    public function downloadVCard($email)
    {
        $employee = Employees::getEmployeeByEmail($email);

        $name = explode(', ', $employee->cn[0]);

        $firstName = $name[0];
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
        fwrite($output, 'TITLE;CHARSET=utf-8:'.$employee->title[0].'');
        fwrite($output, "\n");
        fwrite($output, 'TEL;WORK;VOICE:'.$employee->telephonenumber[0].'');
        fwrite($output, "\n");
        fwrite($output, 'TEL;CELL;VOICE:'.$employee->mobile[0].'');
        fwrite($output, "\n");
        fwrite($output, 'EMAIL;PREF;INTERNET:'.$email.'');
        fwrite($output, "\n");
        fwrite($output, 'ADR;WORK;PREF;CHARSET=utf-8:;;;'.$employee->streetaddress[0]. ', ' . $employee->l[0] .';;;');
        fwrite($output, "\n");
        fwrite($output, 'END:VCARD');
        fclose($output);  
    }

    /**
     * Method: employeesStefan()
     *
     * Returning all Employees (Method created for <<Stefan Reihl>>)
     * page: /employees/employeesStefan
     */
    public function employeesStefan(Request $request)
    {
        $employees = Employees::getEmployeesStefan();

        foreach($employees as $employee){
            print_r($employee->cn[0].', '.$employee->department[0].', '.$employee->title[0].', '.$employee->streetaddress[0].', '.$employee->l[0]);
            echo '<br>';
        }

        echo '<hr>';
        print_r('TOTAL: '.count($employees));

        die();
    }

    /**
     * Method: employeesStefanIMG()
     *
     * Returning all Employees with IMAGE (Method created for <<Stefan Reihl>>)
     * page: /employees/employeesStefanIMG
     */
    public function employeesStefanIMG(Request $request)
    {
        $employees = Employees::getEmployeesStefanIMG();

        foreach($employees as $employee){
            print_r($employee->cn[0].', '.$employee->department[0].', '.$employee->title[0].', '.$employee->streetaddress[0].', '.$employee->l[0]);
            echo '<br>';
        }

        echo '<hr>';
        print_r('TOTAL: '.count($employees));

        die();
    }
}