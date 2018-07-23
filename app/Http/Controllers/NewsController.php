<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

use App\Http\Models\News as News;
use App\Http\Models\Reviews as Reviews;

use Auth;

class NewsController extends Controller
{
    /**
     * Method: index()
     *
     * Rendering the NEWS page with all needed data
     * page: /projectintern
     * 
     * - news = all news (if a NUMBER is given, this NUMBER is passed in Model for PAGINATION)
     * - newsCategories = generated categories from news
     */
    public function index(Request $request)
    {
        $data = [
            'news'           => News::getNews(5),
            'newsCategories' => News::getNewsCategories(),
        ];

        return view('news', $data);
    }

    /**
     * Method: index()
     *
     * Rendering the NEWS page (PRO ID) with all needed data
     * page: /projectintern/{id}
     * 
     * - news = all news (If ID is passed, it will return the requested NEWS for that ID)
     * - newsCategories = generated categories from news
     * - hasReviewed = verify if a user has this news reviewed or not (Example: Feedback/Reviews FORM NEWS for INTRANET)
     */
    public function showNews($newsId)
    {
        $data = [
            'news'           => News::showNews($newsId),
            'newsCategories' => News::getNewsCategories(),
            'hasReviewed'    => Reviews::hasReviewed(Cookie::get('laravel_session')),
        ];

        if(is_numeric($newsId)){
            return view('showNews', $data);
        } else {
            return view('news', $data);
        }
    }

    /**
     * Method: addNews()
     *
     * This method is used in ADMIN PANEL(CMS) for adding NEWS to DATABASE.
     * page: /cms/news - add news form
     * 
     * DATA come from INPUT FORM
     */
    public function addNews(Request $request){

        $data = [
            'newsArt'           => $request->input('newsArt'),
            'newsObject'        => 0,
            'newsDatum'         => $request->input('newsDate'),
            'newsTitel'         => $request->input('newsTitel'),
            'newsUntertitel'    => $request->input('newsUntertitel'),
            'newsMeldung'       => $request->input('newsMeldung'),
            'newsBildUntertext' => $request->input('newsBildUntertext'),
            //BILD
            'newsTeaser'        => $request->file('newsTeaser'),
            'newsBild'          => $request->file('newsBild'),
            'newsWallpaper'     => $request->file('newsWallpaper'),
            //BUTTONS
            'newsPDF'           => $request->file('newsPDF'),
            'newsPDFName'       => $request->input('newsPDFName'),
            'newsWEB'           => $request->input('newsWEB'),
            'newsWEBName'       => $request->input('newsWEBName'),
            //GOOGLE
            'newsLatitude'      => $request->input('newsLatitude'),
            'newsLongitude'     => $request->input('newsLongitude'),
            'newsGooglePIN'     => $request->input('newsGooglePIN'),
            //YOUTUBE
            'newsYoutube'       => $request->input('newsYoutube'),
        ];

        News::addNews($data);  

        return back();
    }

    /**
     * Method: removeNews()
     *
     * This method is used in ADMIN PANEL(CMS) for removing NEWS from DATABASE
     * page: /cms/news - remove button from each news
     * 
     * DATA come from JS Ajax Call
     * Ajax Call can be found in: 
     * Folder: public/adminPanel/js/custom.js, 
     * Function: removeNewsById()
     */
    public function removeNews(Request $request) 
    {
        News::removeNews(['newsId' => $request->get('newsId')]);  

        return true;
    }   

    /**
     * Method: getNewsInfo()
     *
     * This method is used in ADMIN PANEL(CMS) for getting NEWS info from DATABASE when you try to EDIT NEWS.
     * page: /cms/news - edit button from each news
     * 
     * DATA come from JS Ajax Call
     * Ajax Call can be found in: 
     * Folder: public/adminPanel/js/custom.js, 
     * Function: getNewsInfo()
     */
    public function getNewsInfo(Request $request)
    {        
        $newsId = $request->input('newsId');
        
        return json_encode(News::showNews($newsId));
    }

    /**
     * Method: updateNews()
     *
     * This method is used in ADMIN PANEL(CMS) for getting NEWS info from DATABASE when you try to UPDATE NEWS.
     * page: /cms/news - edit button > save from each news
     * 
     * DATA come from JS Ajax Call
     * Ajax Call can be found in: 
     * Folder: public/adminPanel/js/custom.js, 
     * Function: updateNews()
     */
    public function updateNews(Request $request){

        $data = [
            "id"              => $request->input('newsId'),
            "bild_teaser"     => $request->file('newsTeaser'),
            "news_art"        => $request->input('newsArt'),
            "bild_unter"      => $request->input('newsBildUntertext'),
            "datum"           => $request->input('newsDate'),
            "titel"           => $request->input('newsTitel'),
            "untertitel"      => $request->input('newsUntertitel'),
            "meldung"         => $request->input('newsMeldung'),
            "meldung"         => $request->input('newsMeldung'),
            "web_button_url"  => $request->input('newsWEBURL'),
            "web_button_name" => $request->input('newsWEBName'),
            "latitude"        => $request->input('newsLatitude'),
            "longitude"       => $request->input('newsLongitude'),
            'wallpaper'       => $request->file('newsWallpaper'),
            'bild'            => $request->file('newsBild'),
            'youtube'         => $request->input('newsYoutube'),
            'pin_google'      => $request->input('newsGooglePIN'),
            'pdf_button_url'  => $request->file('newsPDF'),
            'pdf_button_name' => $request->input('newsPDFName'),
        ];

        $news = News::updateNews($data);

        return back();
    }

     /**
     * Method: downloadImage()
     *
     * This method used to import images from FROALA editor.
     * Once you are on NEWS page, take all FROALA images, imports into public file and generates a new link for it.
     * page: /projectintern/[id] - click from /cms/news/ on news as logged user
     */
     public function downloadImage($newsId){
        if($user = Auth::user())
        {
            $news      = News::showNews($newsId);

            $dom = new \DOMDocument();
            $dom->loadHTML($news->meldung);

            foreach ($dom->getElementsByTagName('img') as $img) 
            {
                $imageSRC = $img->getAttribute('src');

                if(substr($imageSRC, 8, 12) == 'i.froala.com')
                {
                    $path = explode('?', $imageSRC, 2);
                    $path = $path[0];
                    $filename = basename($path);

                    $contents = file_get_contents($imageSRC);
                    Storage::disk('public_images')->put($filename, $contents);

                    $img->setAttribute('src', "/images/" . $filename);
                }
            }

            $content = $dom->saveHTML();

            $array1 = ['<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '<html>', '</html>', '<body>', '</body>'];
            $array2 = ['', '', '', '', ''];

            $data = [
                'id'      => $news->id,
                'meldung' => trim(str_replace($array1, $array2, $content)),
            ];

            News::updateNewsMeldung($data);

            return 'true';
        } 
        return 'false';
    }

    /**
     * Method: updateNewsSortable()
     *
     * This method is used to sortable in a ORDER all news in ADMIN PANEL(CMS)
     * page: cms/news/sortable/
     */
    public function updateNewsSortable(Request $request)
    {
        News::updateNewsSortable($request->input('sortable'));

        return 'true';
    }

    /**
     * Method: updateNewHomePublishStatus()
     *
     * This method is used to put publishing NEWS on HOMEPAGE (/start) from ADMIN PANEL(CMS)
     * page /cms/news - publish home button
     *
     * If button is green, news will appear on HOMEPAGE
     * If red, otherwise
     */
    public function updateNewHomePublishStatus(Request $request) 
    {
        $newId = $request->input('id');
        $newHomePublish = $request->input('home_publish');

        return News::updateNewHomePublishStatus($newId, $newHomePublish);
    } 

   /**
     * Method: updateNewHomePublishStatus()
     *
     * This method is used to put publishing NEWS on NEWS PAGE (/projectintern) from ADMIN PANEL(CMS)
     * page /cms/news - publish news button
     *
     * If button is green, news will appear on NEWS PAGE
     * If red, otherwise
     */
    public function updateNewPublishStatus(Request $request) 
    {
        $newId = $request->input('id');
        $newPublish = $request->input('publish');

        return News::updateNewPublishStatus($newId, $newPublish);
    } 
}
