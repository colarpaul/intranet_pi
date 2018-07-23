<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Http\Models\Reviews as Reviews;

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
     * Method: addReview()
     *
     * This method was created for FEEDBACK/REVIEWS FORM from NEWS
     */
    public function addReview(Request $request)
    {   
        $data = [
            'who'       => Cookie::get('laravel_session'),
            'question1' => $request->input('question1'),
            'question2' => json_encode($request->input('question2')),
            'question3' => json_encode($request->input('question3')),
            'question4' => $request->input('question4'),
            'question5' => $request->input('question5'),
            'question6' => $request->input('question6'),
            'question7' => $request->input('question7'),
            'question8' => $request->input('question8'),
        ];

        Reviews::addReview($data); 

        return back();
    }
}
