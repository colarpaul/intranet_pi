<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reviews extends Model
{
	public static function addReview($data) 
	{
		$reviews = DB::table('reviews')->where('who', $data['who'])->get();

		if(count($reviews) == 0){
			DB::table('reviews')->insert([
				'who' => $data['who'],
				'question1' => $data['question1'],
				'question2' => $data['question2'],
				'question3' => $data['question3'],
				'question4' => $data['question4'],
				'question5' => $data['question5'],
				'question6' => $data['question6'],
				'question7' => $data['question7'],
				'question8' => $data['question8'],
			]);
		}

		return back();
	}

	public static function hasReviewed($cookieId)
	{
		$reviews = DB::table('reviews')->where('who', $cookieId)->get();

		if(count($reviews)){
			return true;
		}

		return false;
	}

}