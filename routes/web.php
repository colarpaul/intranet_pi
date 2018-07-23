<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@index');
Route::get('/news', 'NewsController@index');
Route::get('/projectintern/', 'NewsController@index');
Route::get('/mitarbeiter', 'EmployeesController@index');
Route::get('/dokumente', 'DocumentsController@index');
Route::get('/faq-support', 'FAQSupportController@index');
Route::get('/bildergalerien', 'GalleryController@index');
Route::get('/objekte', 'ObjectsController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/reviews/add', 'ReviewsController@addReview');
Route::get('/suche',  array(
    'uses' => 'HomeController@suche'
));

// PROJECTINTERN = NEWS
Route::any('/projectintern/updateNews',  array(
    'uses' => 'NewsController@updateNews'
));

Route::any('/projectintern/updateNewsSortable',  array(
    'uses' => 'NewsController@updateNewsSortable'
));

Route::any('/projectintern/{newsId}/downloadImage',  array(
    'uses' => 'NewsController@downloadImage'
));

Route::any('/projectintern/editNews',  array(
    'uses' => 'NewsController@editNews'
));

Route::any('/projectintern/updateNewHomePublishStatus',  array(
    'uses' => 'NewsController@updateNewHomePublishStatus'
));

Route::any('/projectintern/updateNewPublishStatus',  array(
    'uses' => 'NewsController@updateNewPublishStatus'
));

Route::any('/projectintern/getNewsInfo',  array(
    'uses' => 'NewsController@getNewsInfo'
));

Route::any('/projectintern/addNews',  array(
    'uses' => 'NewsController@addNews',
    'as' => 'addNews'
));

Route::any('/projectintern/removeNews',  array(
    'uses' => 'NewsController@removeNews',
    'as' => 'removeNews'
));

Route::get('/projectintern/{newsId}/',  array(
    'uses' => 'NewsController@showNews'
));

// MITARBEITER = EMPLOYEES
Route::any('/mitarbeiter/getEmployeesByName',  array(
    'uses' => 'EmployeesController@getEmployeesByName'
));

Route::any('/mitarbeiter/getCentralEmployeesByPosition',  array(
    'uses' => 'EmployeesController@getCentralEmployeesByPosition'
));

Route::any('/mitarbeiter/getCentralEmployeesByLocationAndPosition',  array(
    'uses' => 'EmployeesController@getCentralEmployeesByLocationAndPosition'
));

Route::any('/mitarbeiter/exportContact',  array(
    'uses' => 'EmployeesController@exportContact',
    'as' => 'exportContact'
));

Route::any('/mitarbeiter/getEmployeeByName',  array(
    'uses' => 'EmployeesController@getEmployeeByName'
));

Route::any('/mitarbeiter/getEmployeeByEmail',  array(
    'uses' => 'EmployeesController@getEmployeeByEmail'
));

Route::any('/mitarbeiter/getAllEmployees',  array(
    'uses' => 'EmployeesController@getAllEmployees'
));

Route::any('/mitarbeiter/getEmployeesByLocation',  array(
    'uses' => 'EmployeesController@getEmployeesByLocation'
));

Route::any('/mitarbeiter/getEmployeesByPosition',  array(
    'uses' => 'EmployeesController@getEmployeesByPosition'
));

Route::any('/mitarbeiter/getEmployeesByLocationAndPosition',  array(
    'uses' => 'EmployeesController@getEmployeesByLocationAndPosition'
));

Route::any('/mitarbeiter/updateCentral',  array(
    'uses' => 'EmployeesController@updateCentral'
));

Route::any('/mitarbeiter/addCentral',  array(
    'uses' => 'EmployeesController@addCentral',
    'as' => 'addCentral'
));

Route::any('/mitarbeiter/removeCentralById',  array(
    'uses' => 'EmployeesController@removeCentralById',
    'as' => 'removeCentralById'
));

Route::any('/mitarbeiter/downloadVCard/{email}',  array(
    'uses' => 'EmployeesController@downloadVCard',
    'as' => 'downloadVCardd'
));

// DOKUMENTE = DOCUMENTS
Route::get('/dokumente/{category}/{subCategory}',  array(
    'uses' => 'DocumentsController@getDocumentsByCategoriesAndSubcategories'
));

Route::any('/dokumente/getAllDocuments',  array(
    'uses' => 'DocumentsController@getAllDocuments'
));

Route::any('/dokumente/updateClicksFAQ',  array(
    'uses' => 'DocumentsController@updateClicksFAQ'
));

Route::any('/dokumente/updateClicksDocument',  array(
    'uses' => 'DocumentsController@updateClicksDocument'
));

Route::any('/dokumente/getAllDocuments',  array(
    'uses' => 'DocumentsController@getAllDocuments'
));

Route::any('/dokumente/alleDokumente',  array(
    'uses' => 'DocumentsController@viewAllDocuments'
));

Route::any('/dokumente/getDocumentWithId',  array(
    'uses' => 'DocumentsController@getDocumentWithId'
));

Route::any('/dokumente/getAllDocumentsLikeValue',  array(
    'uses' => 'DocumentsController@getAllDocumentsLikeValue'
));

Route::any('/dokumente/getDocumentsByCityAndTelefon',  array(
    'uses' => 'DocumentsController@getDocumentsByCityAndTelefon'
));

Route::any('/dokumente/getAllDocumentsLikeValueFirst5',  array(
    'uses' => 'DocumentsController@getAllDocumentsLikeValueFirst5'
));

Route::any('/dokumente/getAllFAQSLikeValueFirst5',  array(
    'uses' => 'DocumentsController@getAllFAQSLikeValueFirst5'
));

Route::any('/dokumente/updateDocumentName',  array(
    'uses' => 'DocumentsController@updateDocumentName'
));

Route::any('/dokumente/updateHomepageData',  array(
    'uses' => 'DocumentsController@updateHomepageData'
));

Route::any('/dokumente/updateHomeMessageData',  array(
    'uses' => 'DocumentsController@updateHomeMessageData'
));

Route::any('/dokumente/updateWLANBanner',  array(
    'uses' => 'DocumentsController@updateWLANBanner'
));

Route::any('/dokumente/updateFAQs',  array(
    'uses' => 'DocumentsController@updateFAQs'
));

Route::any('/dokumente/updateDocumentsSortable',  array(
    'uses' => 'DocumentsController@updateDocumentsSortable'
));

Route::any('/dokumente/updateFAQsSortable',  array(
    'uses' => 'DocumentsController@updateFAQsSortable'
));

Route::any('/dokumente/updateDocumentStatus',  array(
    'uses' => 'DocumentsController@updateDocumentStatus'
));

Route::any('/dokumente/updateFAQPublishStatus',  array(
    'uses' => 'DocumentsController@updateFAQPublishStatus'
));

Route::any('/dokumente/getFAQsInfo',  array(
    'uses' => 'DocumentsController@getFAQsInfo'
));

Route::any('/dokumente/removeCategory',  array(
    'uses' => 'DocumentsController@removeCategory',
    'as' => 'removeCategory'
));

Route::any('/dokumente/removeSubcategory',  array(
    'uses' => 'DocumentsController@removeSubcategory',
    'as' => 'removeSubcategory'
));

Route::any('/dokumente/addCategory',  array(
    'uses' => 'DocumentsController@addCategory',
    'as' => 'addCategory'
));

Route::any('/dokumente/addSubcategory',  array(
    'uses' => 'DocumentsController@addSubcategory',
    'as' => 'addSubcategory'
));

Route::any('/dokumente/getDocumentInfo',  array(
    'uses' => 'DocumentsController@getDocumentInfo'
));

Route::any('/dokumente/getObjectInfo',  array(
    'uses' => 'ObjectsController@getObjectInfo'
));

Route::any('/dokumente/addDocument',  array(
    'uses' => 'DocumentsController@addDocument',
    'as' => 'addDocument'
));

Route::any('/dokumente/addFAQs',  array(
    'uses' => 'DocumentsController@addFAQs',
    'as' => 'addFAQs'
));

Route::any('/dokumente/removeDocument',  array(
    'uses' => 'DocumentsController@removeDocument',
    'as' => 'removeDocument'
));

Route::any('/dokumente/sendSupportEmail',  array(
    'uses' => 'DocumentsController@sendSupportEmail',
    'as' => 'sendSupportEmail'
));

Route::any('/dokumente/sendFeedbackEmail',  array(
    'uses' => 'DocumentsController@sendFeedbackEmail',
    'as' => 'sendFeedbackEmail'
));

Route::any('/dokumente/removeFAQsById',  array(
    'uses' => 'DocumentsController@removeFAQsById',
    'as' => 'removeFAQsById'
));

// FAQ-SUPPORT = FAQ & SUPPORT
// 

// BILDGALERIEN = GALLERY
Route::get('/bildergalerien/{location}',  array(
    'uses' => 'GalleryController@getImagesByLocation'
));

// OBJEKTE = OBJECTS
Route::any('/objekte/getObjectsByBranch',  array(
    'uses' => 'ObjectsController@getObjectsByBranch'
));

Route::any('/objekte/getAllObjectsWithName',  array(
    'uses' => 'ObjectsController@getAllObjectsWithName'
));

Route::any('/objekte/getObjectWithId',  array(
    'uses' => 'ObjectsController@getObjectWithId'
));

Route::any('/objekte/getAllObjectsByCity',  array(
    'uses' => 'ObjectsController@getAllObjectsByCity'
));

Route::any('/objekte/getAllObjects',  array(
    'uses' => 'ObjectsController@getAllObjects'
));

Route::any('/objekte/updateObjectStatus',  array(
    'uses' => 'ObjectsController@updateObjectStatus'
));

Route::any('/objekte/updateObject',  array(
    'uses' => 'ObjectsController@updateObject'
));

Route::any('/mitarbeiter/getCentralInfo',  array(
    'uses' => 'EmployeesController@getCentralInfo'
));

Route::any('/objekte/addObject',  array(
    'uses' => 'ObjectsController@addObject',
    'as' => 'addObject'
));

Route::any('/objekte/removeObject',  array(
    'uses' => 'ObjectsController@removeObject',
    'as' => 'removeObject'
));

// CMS
Route::any('/cms',  array(
    'uses' => 'AdminController@index'
))->middleware('auth');

Route::any('/cms/documents',  array(
    'uses' => 'AdminController@showDocuments'
))->middleware('auth');

Route::any('/cms/objects',  array(
    'uses' => 'AdminController@showObjects'
))->middleware('auth');

Route::any('/cms/news',  array(
    'uses' => 'AdminController@showNews'
))->middleware('auth');

Route::any('/cms/projectintern/sortable',  array(
    'uses' => 'AdminController@showNewsSortable'
))->middleware('auth');

Route::any('/cms/documents/sortable',  array(
    'uses' => 'AdminController@showDocumentsSortable'
))->middleware('auth');

Route::any('/cms/faqs/sortable',  array(
    'uses' => 'AdminController@showFAQsSortable'
))->middleware('auth');

Route::any('/cms/faqs/statistics',  array(
    'uses' => 'AdminController@showFAQsStatistics'
))->middleware('auth');

Route::any('/cms/faqs',  array(
    'uses' => 'AdminController@showFAQs'
))->middleware('auth');

Route::any('/cms/homepage',  array(
    'uses' => 'AdminController@showHomepage'
))->middleware('auth');

Route::any('/cms/wlan',  array(
    'uses' => 'AdminController@showHomeSettings'
))->middleware('auth');

Route::any('/cms/central',  array(
    'uses' => 'AdminController@showCentral'
))->middleware('auth');

Route::any('/cms/analytics',  array(
    'uses' => 'AdminController@viewAnalytics'
))->middleware('auth');

// HELPERS
Route::any('/employeesStefan',  array(
    'uses' => 'EmployeesController@employeesStefan',
    'as' => 'employeesStefan'
));

Route::any('/employeesStefanIMG',  array(
    'uses' => 'EmployeesController@employeesStefanIMG',
    'as' => 'employeesStefanIMG'
));

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Auth::routes();