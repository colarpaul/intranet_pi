<?php

namespace App\Http\Controllers;

use App\Http\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $images = Storage::disk('public_gallery')->allFiles();
        // foreach($images as $key => $image){
        //     if(substr($image, 0, 5) == 'modal'){
        //         unset($images[$key]);
        //     }
        // }
        // $galleryModel = new Gallery();
        // $galleryModel->storeAllImages($images);

        setlocale (LC_TIME, 'German', 'de_DE', 'deu');

        $galleryModel = new Gallery();

        $images = $galleryModel->getAllImages();

        $data = array(
            'images' => $images,
        );

        return view('gallery', $data);
    }

    public function getImagesByLocation($location){

        setlocale (LC_TIME, 'German', 'de_DE', 'deu');

        $galleryModel = new Gallery();

        $images = $galleryModel->getImagesByLocation($location);
        $date = $galleryModel->getImagesDateByLocation($location);

        $data = array(
            'images' => $images,
            'date' => $date,
        );

        return view('gallery', $data);
    }
}
