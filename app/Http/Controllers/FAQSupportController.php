<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Helpers\Helper as Helper;
use App\Http\Models\Service as Service;

class FAQSupportController extends Controller
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
     * Rendering the FAQS-SUPPORT page with all needed data
     * page: /faq-support
     * 
     * - faqsData = all faqs
     * - faqBestQuestions = top 3 faq data
     */
    public function index(Request $request)
    {
        $faqBestQuestions  = Service::getBestFAQs();
        $faqsCategories    = Service::getAllFAQCategories();
        foreach($faqsCategories as $category){
            $faqsData[$category]['translation'] = strtolower(preg_replace('/\s+/', '', Helper::transformGermanChars($category)));
            $subCategories = Service::getFAQSubcategories($category);
            foreach($subCategories as $key => $subCategory){
                $faqsData[$category]['subcategories'][$subCategory] = Service::getFAQsByCategoryAndSubcategory($category, $subCategory);
            }
        }

        $data = array(
            'faqsData' => $faqsData,
            'faqBestQuestions' => $faqBestQuestions,
        );

        return view('faq-support', $data);
    }
}
