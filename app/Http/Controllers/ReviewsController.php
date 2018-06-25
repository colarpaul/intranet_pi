<?php

namespace App\Http\Controllers;

use App\Http\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ReviewsController extends Controller
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
    public function addReview(Request $request)
    {   
        $reviewsModel = new Reviews();

        $data = array(
            'who' => Cookie::get('laravel_session'),
            'question1' => $request->input('question1'),
            'question2' => json_encode($request->input('question2')),
            'question3' => json_encode($request->input('question3')),
            'question4' => $request->input('question4'),
            'question5' => $request->input('question5'),
            'question6' => $request->input('question6'),
            'question7' => $request->input('question7'),
            'question8' => $request->input('question8'),
        );

        $reviewsModel->addReview($data); 

        return back();
    }
}
