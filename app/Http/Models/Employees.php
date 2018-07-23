<?php

namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Adldap\Laravel\Facades\Adldap;

class Employees extends Model
{
	public static function getEmployees()
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->whereHas('title')
		->sortBy('cn', 'asc')
		->get();	

		return $employees;
	}

	public static function getEmployeesByKey($key)
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->orWhere('cn', 'contains', $key)
		->orWhere('givenname', 'contains', $key)
		->orWhere('sn', 'contains', $key)
		->orWhere('mail', 'contains', $key)
		->orWhere('streetaddress', 'contains', $key)
		->orWhere('postalcode', 'contains', $key)
		->orWhere('department', 'contains', $key)
		->orWhere('title', 'contains', $key)
		->orWhere('company', 'contains', $key)
		->orWhere('l', 'contains', $key)
		->whereHas('title')
		->get();	

		return $employees;
	}

	public static function getEmployeesWithImage()
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->whereHas('thumbnailphoto')
		->whereHas('title')
		->sortBy('cn', 'asc')
		->get();	

		return $employees;
	}

	public static function getEmployeesLocationsAndDepatments()
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('l', 'department')
		->whereHas('title')
		->get();

		return $employees;
	}

	public static function getHomeEmployees()
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->orWhere('mail', '=', 'm.merkel@project-immobilien.com')
		->orWhere('mail', '=', 'c.iskakova@project-immobilien.com')
		->orWhere('mail', '=', 'v.drohn@project-immobilien.com')
		->whereHas('title')
		->sortBy('cn', 'asc')
		->get();	

		return $employees;
	}

	public static function getEmployeesByName($name)
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->orWhere('givenname', 'contains', $name)
		->orWhere('sn', 'contains', $name)
		->whereHas('title')
		->get();	

		return $employees;
	}

	public static function getEmployeeByName($name)
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('cn', '=', $name)
		->whereHas('title')
		->get();	
		
		return $employees;
	}

	public static function getEmployeeByEmail($email)
	{
		$employees = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('mail', '=', $email)
		->whereHas('title')
		->first();	
		
		return $employees;
	}

	public static function getEmployeesByLocation($location)
	{
		$employeesLocation = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('l', '=', $location)
		->whereHas('title')
		->get();

		return $employeesLocation;
	}

	public static function getEmployeesByPosition($department)
	{
		$employeesLocation = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('department', '=', $department)
		->whereHas('title')
		->sortBy('cn', 'asc')
		->get();

		return $employeesLocation;
	}

	public static function getEmployeesByLocationAndPosition($location, $department)
	{
		$employeesLocation = Adldap::connect()
		->search()
		->users()
		->select('cn', 'mail', 'telephonenumber', 'title', 'company', 'l', 'whencreated', 'streetaddress', 'postalcode', 'department', 'thumbnailphoto', 'mobile')
		->where('l', '=', $location)
		->where('department', '=', $department)
		->whereHas('title')
		->get();

		return $employeesLocation;
	}

	public static function getCentralEmployeesByPosition($position)
	{
		return DB::table('zentrale')->where('abteilung', $position)->get();
	}

	public static function getCentralEmployeesByLocationAndPosition($location, $position)
	{
		return DB::table('zentrale')->where('abteilung', $position)->where('standort', $location)->get();
	}

	public static function getCentrals()
	{
		return  DB::table('zentrale')->orderBy('abteilung', 'asc')->orderBy('standort', 'asc')->paginate(15);
	}

	public static function getEmployeesPositionAndDepartment()
	{
		return Adldap::connect()
		->search()
		->users()
		->select('l', 'department')
		->get();
	}

	public static function getEmailEmployees()
	{
		return Adldap::connect()
		->search()
		->users()
		->select('mail')
		->whereHas('mail')
		->get();
	}

	public static function addCentral($data) 
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

	public static function removeCentralById($id) 
	{
		DB::table('zentrale')->where('id', $id)->delete();
	}

	public static function showCentral($id)
	{
		return DB::table('zentrale')->where('id', $id)->get()->first();
	}

	public static function updateCentral($data) 
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

		if(!empty($data['sekretariat']))
		{
			DB::table('zentrale')
			->where('id', $data['id'])
			->update([
				'sekretariat' => json_encode($data['sekretariat']),
			]);
		}
	}	

	public static function getEmployeesStefan() 
	{
		return Adldap::connect()
		->search()
		->users()
		->select('cn', 'department', 'title', 'l', 'streetaddress')
		->whereHas('title')
		->sortBy('cn', 'asc')
		->get();
	}	

	public static function getEmployeesStefanIMG() 
	{
		return Adldap::connect()
		->search()
		->users()
		->select('cn', 'department', 'title', 'thumbnailphoto', 'l', 'streetaddress')
		->whereHas('thumbnailphoto')
		->whereHas('title')
		->sortBy('cn', 'asc')
		->get();
	}	
}