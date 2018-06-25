<?php

namespace App\Http\Controllers;

use App\Http\Models\News;
use App\Http\Models\Reviews;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Artisan;

class NewsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $newsModel = new News();

        $news = $newsModel->getNews(5);
        $newsCategories = $newsModel->getNewsCategories();

        $newsCategoriesArray = array();
        foreach($newsCategories->toArray() as $category){
            $newsCategoriesArray[] = $category->news_art;
        }

        $data = array(
            'news' => $news,
            'newsCategories' => $newsCategoriesArray,
        );

        return view('news', $data);
    }

    /**
     * Show a new by a given id
     * 
     * @param  int $newsId 
     * @return array
     */
    public function showNews($newsId){
        Artisan::call('cache:clear');

        $newsModel = new News();
        $reviewsModel = new Reviews();

        $news = $newsModel->showNews($newsId);
        $newsCategories = $newsModel->getNewsCategories();

        $newsCategoriesArray = array();
        foreach($newsCategories->toArray() as $category){
            $newsCategoriesArray[] = $category->news_art;
        }

        $data = array(
            'news' => $news,
            'newsCategories' => $newsCategoriesArray,
            'hasReviewed' => $reviewsModel->hasReviewed(Cookie::get('laravel_session')),
        );

        if(is_numeric($newsId)){
            return view('showNews', $data);
        } else {
            return view('news', $data);
        }
    }

    /**
     * Adding a new in database
     * 
     * @param Request $request
     */
    public function addNews(Request $request){

        $newsModel = new News();

        $data = array(
            'newsArt' => $request->input('newsArt'),
            'newsObject' => 0,
            'newsDatum' => $request->input('newsDate'),
            'newsTitel' => $request->input('newsTitel'),
            'newsUntertitel' => $request->input('newsUntertitel'),
            'newsMeldung' => $request->input('newsMeldung'),
            'newsBildUntertext' => $request->input('newsBildUntertext'),
            //BILD
            'newsTeaser' => $request->file('newsTeaser'),
            'newsBild' => $request->file('newsBild'),
            'newsWallpaper' => $request->file('newsWallpaper'),
            //BUTTONS
            'newsPDF' => $request->file('newsPDF'),
            'newsPDFName' => $request->input('newsPDFName'),
            'newsWEB' => $request->input('newsWEB'),
            'newsWEBName' => $request->input('newsWEBName'),
            //GOOGLE
            'newsLatitude' => $request->input('newsLatitude'),
            'newsLongitude' => $request->input('newsLongitude'),
            'newsGooglePIN' => $request->input('newsGooglePIN'),
            //YOUTUBE
            'newsYoutube' => $request->input('newsYoutube'),
        );

        $newsModel->addNews($data);  

        return back();
    }

    /**
     * Remove news from database by a given id
     * 
     * @param  Request $request
     */
    public function removeNews(Request $request) 
    {
        $newsModel = new News();

        $data = array(
            'newsId' => $request->get('newsId'),
        );

        $newsModel->removeNews($data);  

        return true;
    }   

    /**
     * Get all datas from an new by a given id
     * 
     * @param  Request $request
     * @return array
     */
    public function getNewsInfo(Request $request){
        $newsModel = new News();

        $newsId = $request->input('newsId');

        $news = $newsModel->showNews($newsId);

        return json_encode($news);
    }

    /**
     * Update new by given all necessary data as array
     * 
     * @param  Request $request
     * @return true/back
     */
    public function updateNews(Request $request){
        $newsModel = new News();

        $data = array(
            "id" => $request->input('newsId'),
            "bild_teaser" => $request->file('newsTeaser'),
            "news_art" => $request->input('newsArt'),
            "bild_unter" => $request->input('newsBildUntertext'),
            "datum" => $request->input('newsDate'),
            "titel" => $request->input('newsTitel'),
            "untertitel" => $request->input('newsUntertitel'),
            "meldung" => $request->input('newsMeldung'),
            "meldung" => $request->input('newsMeldung'),
            "web_button_url" => $request->input('newsWEBURL'),
            "web_button_name" => $request->input('newsWEBName'),
            "latitude" => $request->input('newsLatitude'),
            "longitude" => $request->input('newsLongitude'),
            'wallpaper' => $request->file('newsWallpaper'),
            'bild' => $request->file('newsBild'),
            'youtube' => $request->input('newsYoutube'),
            'pin_google' => $request->input('newsGooglePIN'),
            'pdf_button_url' => $request->file('newsPDF'),
            'pdf_button_name' => $request->input('newsPDFName'),
        );

        $news = $newsModel->updateNews($data);

        return back();
    }

    public function downloadImage($newsId){
        if($user = Auth::user())
        {
            $newsModel = new News();

            $news = $newsModel->showNews($newsId);

            $dom = new \DOMDocument();
            $dom->loadHTML($news->meldung);

            foreach ($dom->getElementsByTagName('img') as $img) {
                $imageSRC = $img->getAttribute('src');

                if(substr($imageSRC, 8, 12) == 'i.froala.com'){

                    $path = explode('?', $imageSRC, 2);
                    $path = $path[0];
                    $filename = basename($path);

                    $contents = file_get_contents($imageSRC);
                    Storage::disk('public_images')->put($filename, $contents);

                    $img->setAttribute('src', "/images/" . $filename);
                }
            }

            $content = $dom->saveHTML();

            $array1 = array('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '<html>', '</html>', '<body>', '</body>');
            $array2 = array('', '', '', '', '');

            $content = trim(str_replace($array1, $array2, $content));

            $data = array(
                'id' => $news->id,
                'meldung' => $content,
            );

            $newsModel->updateNewsMeldung($data);

            return 'true';
        } 
        return 'false';
    }

    /**
     * Update new by given all necessary data as array
     * 
     * @param  Request $request
     * @return true/back
     */
    public function updateNewsSortable(Request $request){
        $newsModel = new News();

        $data = $request->input('sortable');

        $news = $newsModel->updateNewsSortable($data);

        return 'true';
    }

    public function updateNewHomePublishStatus(Request $request) 
    {
        $newsModel = new News();

        $newId = $request->input('id');
        $newHomePublish = $request->input('home_publish');

        return $newsModel->updateNewHomePublishStatus($newId, $newHomePublish);
    } 

    public function updateNewPublishStatus(Request $request) 
    {
        $newsModel = new News();

        $newId = $request->input('id');
        $newPublish = $request->input('publish');

        return $newsModel->updateNewPublishStatus($newId, $newPublish);
    } 
}
