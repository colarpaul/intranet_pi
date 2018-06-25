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
Route::get('/projectintern', 'NewsController@index');
Route::get('/employees', 'EmployeesController@index');
Route::get('/mitarbeiter', 'EmployeesController@index');
Route::get('/service', 'ServiceController@index');
Route::get('/dokumente-support', 'ServiceController@index');
// Route::get('/gallery', 'GalleryController@index');
Route::get('/bildergalerien', 'GalleryController@index');
Route::get('/objects', 'ObjectsController@index');
Route::get('/objekte', 'ObjectsController@index');

Route::get('/service/{category}/{subCategory}',  array(
    'uses' => 'ServiceController@getDocumentsByCategoriesAndSubcategories'
));

Route::get('/bildergalerien/{location}',  array(
    'uses' => 'GalleryController@getImagesByLocation'
));

Route::get('/suche',  array(
    'uses' => 'HomeController@suche'
));

Route::any('/service/getAllDocuments',  array(
    'uses' => 'ServiceController@getAllDocuments'
));

Route::any('/service/updateClicksFAQ',  array(
    'uses' => 'ServiceController@updateClicksFAQ'
));

Route::any('/service/updateClicksDocument',  array(
    'uses' => 'ServiceController@updateClicksDocument'
));

Route::any('/dokumente-support/getAllDocuments',  array(
    'uses' => 'ServiceController@getAllDocuments'
));

Route::any('/dokumente-support/alleDokumente',  array(
    'uses' => 'ServiceController@viewAllDocuments'
));

Route::any('/service/getDocumentWithId',  array(
    'uses' => 'ServiceController@getDocumentWithId'
));

Route::any('/service/getAllDocumentsLikeValue',  array(
    'uses' => 'ServiceController@getAllDocumentsLikeValue'
));

Route::any('/service/getDocumentsByCityAndTelefon',  array(
    'uses' => 'ServiceController@getDocumentsByCityAndTelefon'
));

Route::any('/service/getAllDocumentsLikeValueFirst5',  array(
    'uses' => 'ServiceController@getAllDocumentsLikeValueFirst5'
));

Route::any('/employees/getEmployeesByName',  array(
    'uses' => 'EmployeesController@getEmployeesByName'
));

Route::any('/employees/getCentralEmployeesByPosition',  array(
    'uses' => 'EmployeesController@getCentralEmployeesByPosition'
));

Route::any('/employees/getCentralEmployeesByLocationAndPosition',  array(
    'uses' => 'EmployeesController@getCentralEmployeesByLocationAndPosition'
));

Route::any('/employees/exportContact',  array(
    'uses' => 'EmployeesController@exportContact',
    'as' => 'exportContact'
));

Route::any('/employees/getEmployeeByName',  array(
    'uses' => 'EmployeesController@getEmployeeByName'
));

Route::any('/employees/getEmployeeByEmail',  array(
    'uses' => 'EmployeesController@getEmployeeByEmail'
));

Route::any('/employees/getAllEmployees',  array(
    'uses' => 'EmployeesController@getAllEmployees'
));

Route::any('/employees/getEmployeesByLocation',  array(
    'uses' => 'EmployeesController@getEmployeesByLocation'
));

Route::any('/employees/getEmployeesByPosition',  array(
    'uses' => 'EmployeesController@getEmployeesByPosition'
));

Route::any('/employees/getEmployeesByLocationAndPosition',  array(
    'uses' => 'EmployeesController@getEmployeesByLocationAndPosition'
));

Route::any('/objects/getObjectsByBranch',  array(
    'uses' => 'ObjectsController@getObjectsByBranch'
));

Route::any('/objects/getAllObjectsWithName',  array(
    'uses' => 'ObjectsController@getAllObjectsWithName'
));

Route::any('/objects/getObjectWithId',  array(
    'uses' => 'ObjectsController@getObjectWithId'
));

Route::any('/objects/getAllObjectsByCity',  array(
    'uses' => 'ObjectsController@getAllObjectsByCity'
));

Route::any('/objects/getAllObjects',  array(
    'uses' => 'ObjectsController@getAllObjects'
));

Route::any('/service/updateDocumentName',  array(
    'uses' => 'ServiceController@updateDocumentName'
));

Route::any('/service/updateHomepageData',  array(
    'uses' => 'ServiceController@updateHomepageData'
));

Route::any('/service/updateWLANBanner',  array(
    'uses' => 'ServiceController@updateWLANBanner'
));

Route::any('/news/updateNews',  array(
    'uses' => 'NewsController@updateNews'
));

Route::any('/service/updateFAQs',  array(
    'uses' => 'ServiceController@updateFAQs'
));

Route::any('/employees/updateCentral',  array(
    'uses' => 'EmployeesController@updateCentral'
));

Route::any('/news/updateNewsSortable',  array(
    'uses' => 'NewsController@updateNewsSortable'
));

Route::any('/service/updateDocumentsSortable',  array(
    'uses' => 'ServiceController@updateDocumentsSortable'
));

Route::any('/service/updateFAQsSortable',  array(
    'uses' => 'ServiceController@updateFAQsSortable'
));

Route::any('/news/{newsId}/downloadImage',  array(
    'uses' => 'NewsController@downloadImage'
));

Route::any('/projectintern/{newsId}/downloadImage',  array(
    'uses' => 'NewsController@downloadImage'
));

Route::any('/news/editNews',  array(
    'uses' => 'NewsController@editNews'
));

Route::any('/objects/updateObjectStatus',  array(
    'uses' => 'ObjectsController@updateObjectStatus'
));

Route::any('/service/updateDocumentStatus',  array(
    'uses' => 'ServiceController@updateDocumentStatus'
));

Route::any('/news/updateNewHomePublishStatus',  array(
    'uses' => 'NewsController@updateNewHomePublishStatus'
));

Route::any('/service/updateFAQPublishStatus',  array(
    'uses' => 'ServiceController@updateFAQPublishStatus'
));

Route::any('/news/updateNewPublishStatus',  array(
    'uses' => 'NewsController@updateNewPublishStatus'
));

Route::any('/objects/updateObject',  array(
    'uses' => 'ObjectsController@updateObject'
));

Route::any('/news/getNewsInfo',  array(
    'uses' => 'NewsController@getNewsInfo'
));

Route::any('/service/getFAQsInfo',  array(
    'uses' => 'ServiceController@getFAQsInfo'
));

Route::any('/employees/getCentralInfo',  array(
    'uses' => 'EmployeesController@getCentralInfo'
));

Route::any('/service/getDocumentInfo',  array(
    'uses' => 'ServiceController@getDocumentInfo'
));

Route::any('/service/getObjectInfo',  array(
    'uses' => 'ObjectsController@getObjectInfo'
));

Route::any('/service/addDocument',  array(
    'uses' => 'ServiceController@addDocument',
    'as' => 'addDocument'
));

Route::any('/service/addFAQs',  array(
    'uses' => 'ServiceController@addFAQs',
    'as' => 'addFAQs'
));

Route::any('/news/addNews',  array(
    'uses' => 'NewsController@addNews',
    'as' => 'addNews'
));

Route::any('/objects/addObject',  array(
    'uses' => 'ObjectsController@addObject',
    'as' => 'addObject'
));

Route::any('/employees/addCentral',  array(
    'uses' => 'EmployeesController@addCentral',
    'as' => 'addCentral'
));

Route::any('/service/addCategory',  array(
    'uses' => 'ServiceController@addCategory',
    'as' => 'addCategory'
));

Route::any('/service/addSubcategory',  array(
    'uses' => 'ServiceController@addSubcategory',
    'as' => 'addSubcategory'
));

Route::any('/service/removeDocument',  array(
    'uses' => 'ServiceController@removeDocument',
    'as' => 'removeDocument'
));

Route::any('/objects/removeObject',  array(
    'uses' => 'ObjectsController@removeObject',
    'as' => 'removeObject'
));

Route::any('/news/removeNews',  array(
    'uses' => 'NewsController@removeNews',
    'as' => 'removeNews'
));

Route::any('/employees/downloadVCard/{email}',  array(
    'uses' => 'EmployeesController@downloadVCard',
    'as' => 'downloadVCardd'
));

Route::any('/service/removeFAQsById',  array(
    'uses' => 'ServiceController@removeFAQsById',
    'as' => 'removeFAQsById'
));

Route::any('/employees/removeCentralById',  array(
    'uses' => 'EmployeesController@removeCentralById',
    'as' => 'removeCentralById'
));

Route::any('/service/removeCategory',  array(
    'uses' => 'ServiceController@removeCategory',
    'as' => 'removeCategory'
));

Route::any('/service/removeSubcategory',  array(
    'uses' => 'ServiceController@removeSubcategory',
    'as' => 'removeSubcategory'
));

Route::get('/news/{newsId}/',  array(
    'uses' => 'NewsController@showNews'
));

Route::get('/projectintern/{newsId}/',  array(
    'uses' => 'NewsController@showNews'
));

Route::post('/reviews/add', 'ReviewsController@addReview');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});



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

Route::any('/cms/news/sortable',  array(
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
    'uses' => 'AdminController@showWLANBanner'
))->middleware('auth');

Route::any('/cms/central',  array(
    'uses' => 'AdminController@showCentral'
))->middleware('auth');

Route::any('/cms/analytics',  array(
    'uses' => 'AdminController@viewAnalytics'
))->middleware('auth');

Route::any('/service/sendSupportEmail',  array(
    'uses' => 'ServiceController@sendSupportEmail',
    'as' => 'sendSupportEmail'
));

Route::any('/service/sendFeedbackEmail',  array(
    'uses' => 'ServiceController@sendFeedbackEmail',
    'as' => 'sendFeedbackEmail'
));
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
