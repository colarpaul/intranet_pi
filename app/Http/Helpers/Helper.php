<?php // Code within app\Helpers\Helper.php

namespace App\Http\Helpers;

class Helper
{

    /**
     * Method: formatPhoneNumberByLocationAndStreet()
     *
     * Format a phone number by location and street.
     * (Each location and street has a different format)
     */
	public static function formatPhoneNumberByLocationAndStreet($phoneNumber, $location, $street) 
	{
		switch($location)
		{
			case 'Nürnberg':
			if(strlen($phoneNumber) == 12)
			{
				if (strpos($street, 'Bucher Straße 79a') !== false)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 3) . ' ' . substr($phoneNumber, 11, 1);
				} else {
                    // doesn't exists
				}
			} elseif(strlen($phoneNumber) == 13) {
				if (strpos($street, 'Bucher Straße 79a') !== false)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 3) . ' ' . substr($phoneNumber, 11, 2);
				} else {
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1);
				}
			} elseif(strlen($phoneNumber) == 14) {
				if (strpos($street, 'Bucher Straße 79a') !== false)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 3) . ' ' . substr($phoneNumber, 11, 3);
				} else {
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 2);
				}
			} elseif(strlen($phoneNumber) == 15) {
				if (strpos($street, 'Bucher Straße 79a') !== false)
				{
                    // doesn't exists
				} else {
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 3) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 3);
				}
			}
			break;
			case 'Berlin':
			if(strlen($phoneNumber) == 12)
			{
				if (strpos($street, 'Volmerstraße 10') !== false)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1);
				} else {
                    // doesn't exists
				}
			} elseif(strlen($phoneNumber) == 13)
			{
				if (strpos($street, 'Volmerstraße 10') !== false)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 2);
				} else {
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1);
				}
			} elseif(strlen($phoneNumber) == 14) 
			{
				if (strpos($street, 'Volmerstraße 10') !== false)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 3);
				} else {
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
				}
			} elseif(strlen($phoneNumber) == 15) 
			{
				if (strpos($street, 'Volmerstraße 10') !== false)
				{
                    // doesn't exists
				} else {
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 2);
				}
			}
			break;
			case 'München':
			if(strlen($phoneNumber) == 13)
			{
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1);
			} elseif(strlen($phoneNumber) == 14) {
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
			}
			break;
			case 'Hamburg':
			if(strlen($phoneNumber) == 13)
			{
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1);
			} elseif(strlen($phoneNumber) == 14) {
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
			} elseif(strlen($phoneNumber) == 15) {
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 2);
			}
			break;
			case 'Frankfurt am Main':
			if(substr($phoneNumber, 3, 2) == 69)
			{
				if(strlen($phoneNumber) == 13){
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1);
				} elseif(strlen($phoneNumber) == 14)
				{
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . '.' . substr($phoneNumber, 5, 3) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 2) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
				}
			} elseif(substr($phoneNumber, 3, 4) == 6122) 
			{
				if(strlen($phoneNumber) == 13){
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . '.' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1);
				} elseif(strlen($phoneNumber) == 14){
					$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 4) . '.' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 3) . ' ' . substr($phoneNumber, 12, 1) . substr($phoneNumber, 13, 1);
				}
			}
			break;
			case 'Düsseldorf':
			if(strlen($phoneNumber) == 12)
			{
				$phoneNumber = substr($phoneNumber, 0, 4) . '.' . substr($phoneNumber, 4, 2) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 1);
			} elseif(strlen($phoneNumber) == 13)
			{
				$phoneNumber = substr($phoneNumber, 0, 4) . '.' . substr($phoneNumber, 4, 2) . '.' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8, 2) . ' ' . substr($phoneNumber, 10, 1) . substr($phoneNumber, 11, 1);
			}
			break;
			case 'Wien':
			if(strlen($phoneNumber) == 12)
			{
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 1) . '.' . substr($phoneNumber, 4, 3) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1);
			} elseif(strlen($phoneNumber) == 13)
			{
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 1) . '.' . substr($phoneNumber, 4, 3) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1) . substr($phoneNumber, 12, 1);
			} elseif(strlen($phoneNumber) == 14)
			{
				$phoneNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 1) . '.' . substr($phoneNumber, 4, 3) . ' ' . substr($phoneNumber, 7, 2) . ' ' . substr($phoneNumber, 9, 2) . ' ' . substr($phoneNumber, 11, 1) . substr($phoneNumber, 12, 2);
			}
			break;
			default:
			$phoneNumber = $phoneNumber;
			break;
		}

		return $phoneNumber;
	}

    /**
     * Method: formatMobileNumberByLocation()
     *
     * Format a phone number by location.
     * (Each location has a different format = only for WIEN)
     */
	public static function formatMobileNumberByLocation($mobileNumber, $location)
	{
		switch($location)
		{
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

    /**
     * Method: transformGermanChars()
     *
     * Searching for german characters and transform them.
     */
	public static function transformGermanChars($string)
	{
		$string = str_replace("ä", "ae", $string);
		$string = str_replace("ü", "ue", $string);
		$string = str_replace("ö", "oe", $string);
		$string = str_replace("Ä", "Ae", $string);
		$string = str_replace("Ü", "Ue", $string);
		$string = str_replace("Ö", "Oe", $string);
		$string = str_replace("ß", "ss", $string);
		$string = str_replace("´", "", $string);
		return $string;
	}
}