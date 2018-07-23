<?php

namespace App\Http\Controllers;

use App\Http\Models\Gallery as Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
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
     * Rendering the GALLERY page with all images
     * page: /bildgalerien
     * 
     * - images = all images
     */
    public function index(Request $request)
    {
        setlocale (LC_TIME, 'German', 'de_DE', 'deu');

        return view('gallery', ['images' => Gallery::getAllImages()]);
    }

    /**
     * Method: getImagesByLocation()
     *
     * Rendering the GALLERY page for a selected LOCATION
     * page: /bildgalerien
     * 
     * - images = all images
     */
    public function getImagesByLocation($location)
    {
        setlocale (LC_TIME, 'German', 'de_DE', 'deu');

        $data = [
            'images' => Gallery::getImagesByLocation($location),
            'date'   => Gallery::getImagesDateByLocation($location),
        ];

        return view('gallery', $data);
    }
}
