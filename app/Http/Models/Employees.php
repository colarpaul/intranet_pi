<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Adldap\Laravel\Facades\Adldap;

class Employees extends Model
{
	/**
	 * Get all Employees
	 * 
	 * @return object
	 */
	public function getEmployees(){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->sortBy('cn', 'asc')
		->get();	

		return $employees;
	}

	public function getEmployeesByKey($key){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->orWhere('givenname', 'contains', $key)
		->orWhere('sn', 'contains', $key)
		->orWhere('mail', 'contains', $key)
		->orWhere('streetaddress', 'contains', $key)
		->orWhere('postalcode', 'contains', $key)
		->orWhere('department', 'contains', $key)
		->orWhere('title', 'contains', $key)
		->orWhere('company', 'contains', $key)
		->orWhere('l', 'contains', $key)
		->get();	

		return $employees;
	}
	/**
	 * Get all Employees
	 * 
	 * @return object
	 */
	public function getEmployeesWithImage(){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->whereHas('thumbnailphoto')
		->sortBy('cn', 'asc')
		->get();	

		return $employees;
	}
	/**
	 * Get all Employees
	 * 
	 * @return object
	 */
	public function getHomeEmployees(){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->orWhere('mail', '=', 'm.merkel@project-immobilien.com')
		->orWhere('mail', '=', 'c.iskakova@project-immobilien.com')
		->orWhere('mail', '=', 'v.drohn@project-immobilien.com')
		->sortBy('cn', 'asc')
		->get();	

		return $employees;
	}

	/**
	 * Get all Employees by a given name
	 * 
	 * @param  string $name
	 * @return object
	 */
	public function getEmployeesByName($name){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->orWhere('givenname', 'contains', $name)
		->orWhere('sn', 'contains', $name)
		->get();	

		return $employees;
	}

	/**
	 * Get Employee by a name
	 * 
	 * @param  string $name
	 * @return object
	 */
	public function getEmployeeByName($name){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('cn', '=', $name)
		->get();	
		
		return $employees;
	}

	/**
	 * Get Employee by a name
	 * 
	 * @param  string $name
	 * @return object
	 */
	public function getEmployeeByEmail($email){

		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('mail', '=', $email)
		->first();	
		
		return $employees;
	}

	/**
	 * Get all Employees by a given $location
	 * 
	 * @param  string $location
	 * @return object
	 */
	public function getEmployeesByLocation($location){

		$employeesLocation = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('l', '=', $location)
		->get();

		return $employeesLocation;
	}

	/**
	 * Get all Employees by a given $position
	 * 
	 * @param  string $position
	 * @return object
	 */
	public function getEmployeesByPosition($department){

		$employeesLocation = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('department', '=', $department)
		->sortBy('cn', 'asc')
		->get();

		return $employeesLocation;
	}

	/**
	 * Get all Employees by a given $location and a given $position
	 * 
	 * @param  string $location
	 * @param  string $position
	 * @return object
	 */
	public function getEmployeesByLocationAndPosition($location, $department){

		$employeesLocation = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('l', '=', $location)
		->where('department', '=', $department)
		->get();

		return $employeesLocation;
	}

	public function getCentralEmployeesByPosition($position){
		return DB::table('zentrale')->where('abteilung', $position)->get();
	}

	public function getCentralEmployeesByLocationAndPosition($location, $position){
		return DB::table('zentrale')->where('abteilung', $position)->where('standort', $location)->get();
	}

	public function getCentrals()
	{
		return  DB::table('zentrale')->orderBy('abteilung', 'asc')->orderBy('standort', 'asc')->paginate(15);
	}

	public function getEmployeesPositionAndDepartment()
	{
		return Adldap::connect()
		->search()
		->users()
		->select('l', 'department')
		->get();
	}

	public function getEmailEmployees()
	{
		return Adldap::connect()
		->search()
		->users()
		->select('mail')
		->get();
	}

	public function addCentral($data) 
	{
		DB::table('zentrale')->insert([
			'zentrale' => $data['zentrale'],
			'strasse' => $data['strasse'],
			'telefon' => $data['telefon'],
			'abteilung' => $data['abteilung'],
			'standort' => $data['standort'],
			'sekretariat' => json_encode($data['sekretariat']),
		]);
	}

	public function removeCentralById($data) 
	{
		DB::table('zentrale')->where('id', $data['id'])->delete();
	}

	public function showCentral($id)
	{
		return DB::table('zentrale')->where('id', $id)->get()->first();
	}

	public function updateCentral($data) 
	{
		DB::table('zentrale')
		->where('id', $data['id'])
		->update([
			'zentrale' => $data['zentrale'], 
			'strasse' => $data['strasse'], 
			'telefon' => $data['telefon'], 
			'abteilung' => $data['abteilung'], 
			'standort' => $data['standort'], 
		]);

		if(!empty($data['sekretariat'])){
			DB::table('zentrale')
			->where('id', $data['id'])
			->update([
				'sekretariat' => json_encode($data['sekretariat']),
			]);
		}
	}	
}