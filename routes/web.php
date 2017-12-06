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

Route::get('/', ['as' => 'login-page', 'uses' => 'AuthController@login']);
Route::get('/auth/logout', ['as' => 'logout-page', 'uses' => 'AuthController@logout']);

Route::get('/client/login', ['as' => 'client-login-page', 'uses' => 'ClientController@login']);
Route::get('/client/logout', ['as' => 'client-logout-page', 'uses' => 'ClientController@logout']);

Route::get('/cronjob-video-download/{store_id}', ['as' => 'cronjob-video-download-page', 'uses' => 'CronJobController@getCronJobVideoDownload']);

Route::post('/account/login', ['as' => 'post-login-page', 'uses' => 'AuthController@postAuthenticate']);
Route::post('/client/login', ['as' => 'client-post-login-page', 'uses' => 'ClientController@postAuthenticate']);

Route::group(['middleware' => 'auth'], function () {

  Route::get('/search/country-name', ['as' => 'search-country-name-page', 'uses' => 'CommonController@SearchCountryName']);
  Route::get('/get-country-by-partner-id', ['as' => 'get-country-by-partner-id-page', 'uses' => 'CommonController@getCountryByPartnerId']);
  Route::get('/get-store-by-country-id', ['as' => 'get-store-by-country-id-page', 'uses' => 'CommonController@getStoreByCountryId']);
  Route::get('/get-store', ['as' => 'get-store-page', 'uses' => 'CommonController@getStore']);
  Route::get('/check-username', ['as' => 'check-username-page', 'uses' => 'CommonController@CheckUsername']);
  Route::get('/dashboard', ['as' => 'dashboard-page', 'uses' => 'CommonController@getDashboard']);

  Route::get('/search/video-name', ['as' => 'search-video-name-page', 'uses' => 'CommonController@SearchVideoName']);
  Route::get('/search/store-name', ['as' => 'search-store-name-page', 'uses' => 'CommonController@SearchStoreName']);

  Route::post('file/uploadFiles', 'UploadController@uploadFiles');
  Route::get('file/removeFiles/{name}', 'UploadController@removeFiles');

  Route::group(['prefix' => 'videos'], function () {
    Route::get('/', ['as' => 'videos-page', 'uses' => 'VideoController@index']);
    Route::get('/new-video', ['as' => 'new-video-page', 'uses' => 'VideoController@getNewVideo']);
    Route::get('/edit/{id}', ['as' => 'edit-video-page', 'uses' => 'VideoController@getEditVideo']);
    Route::get('/delete/{id}', ['as' => 'delete-video-page', 'uses' => 'VideoController@getDeleteVideo']);

    Route::match(["post", "get"], '/search-videos', ['as' => 'search-videos-page', 'uses' => 'VideoController@SearchVideos']);

    Route::post('/new-video', ['as' => 'post-new-video-page', 'uses' => 'VideoController@PostNewVideo']);
    Route::post('/edit/{id}', ['as' => 'update-video-page', 'uses' => 'VideoController@postEditVideo']);
    Route::post('/delete/videos', ['as' => 'delete-videos-page', 'uses' => 'VideoController@DeleteVideos']);
  });

  Route::group(['prefix' => 'schedules'], function () {
    Route::get('/', ['as' => 'schedules-page', 'uses' => 'ScheduleController@index']);
    Route::get('/new-schedule', ['as' => 'new-schedule-page', 'uses' => 'ScheduleController@getNewSchedule']);
    Route::get('/edit/{id}', ['as' => 'edit-schedule-page', 'uses' => 'ScheduleController@getEditSchedule']);
    Route::get('/delete/{id}', ['as' => 'delete-schedule-page', 'uses' => 'ScheduleController@getDeleteSchedule']);

    Route::match(["post", "get"], '/search-schedules', ['as' => 'search-schedules-page', 'uses' => 'ScheduleController@SearchSchedules']);

    Route::post('/new-schedule', ['as' => 'new-schedule-page', 'uses' => 'ScheduleController@PostNewSchedule']);
    Route::post('/edit/{id}', ['as' => 'post-edit-schedule-page', 'uses' => 'ScheduleController@postEditSchedule']);
  });

  Route::group(['prefix' => 'stores'], function () {
    Route::get('/', ['as' => 'stores-page', 'uses' => 'StoreController@index']);
    Route::get('/new-store', ['as' => 'get-new-store-page', 'uses' => 'StoreController@getNewStore']);
    Route::get('/import', ['as' => 'store-import-page', 'uses' => 'StoreController@getImport']);
    Route::get('/edit/{id}', ['as' => 'edit-store-page', 'uses' => 'StoreController@getEditStore']);
    Route::get('/delete/{id}', ['as' => 'delete-store-page', 'uses' => 'StoreController@getDeleteStore']);

    Route::match(["post", "get"], '/search', ['as' => 'search-store-page', 'uses' => 'StoreController@SearchStores']);

    Route::post('/new-store', ['as' => 'post-new-store-page', 'uses' => 'StoreController@postNewStore']);
    Route::post('/import', ['as' => 'store-import-page', 'uses' => 'StoreController@postImport']);
    Route::post('/edit/{id}', ['as' => 'update-store-page', 'uses' => 'StoreController@postEditStore']);
    Route::post('/delete/stores', ['as' => 'delete-stores-page', 'uses' => 'StoreController@DeleteStores']);
  });

  Route::group(['prefix' => 'settings'], function () {
    Route::get('/', ['as' => 'settings-page', 'uses' => 'SettingsController@index']);
    Route::get('/global', ['as' => 'get-global-page', 'uses' => 'GlobalController@getGlobal']);
    Route::get('/countries', ['as' => 'get-countries-page', 'uses' => 'CountryController@getCountries']);
    Route::get('/users', ['as' => 'get-users-page', 'uses' => 'UserController@getUsers']);
    Route::get('/roles', ['as' => 'get-roles-page', 'uses' => 'RoleController@getRoles']);
    Route::get('/partners', ['as' => 'get-partners-page', 'uses' => 'PartnerController@getPartners']);

    Route::get('/new-country', ['as' => 'get-new-country-page', 'uses' => 'CountryController@getNewCountry']);
    Route::get('/new-user', ['as' => 'get-new-user-page', 'uses' => 'UserController@getNewUser']);
    Route::get('/new-partner', ['as' => 'get-new-partner-page', 'uses' => 'PartnerController@getNewPartner']);

    Route::match(["post", "get"], '/search/countries', ['as' => 'search-countries-page', 'uses' => 'CountryController@SearchCountries']);
    Route::match(["post", "get"], '/search/partners', ['as' => 'search-partners-page', 'uses' => 'PartnerController@SearchPartners']);
    Route::match(["post", "get"], '/search/users', ['as' => 'search-users-page', 'uses' => 'UserController@SearchUsers']);

    Route::get('/edit/country/{id}', ['as' => 'edit-country-page', 'uses' => 'CountryController@getEditCountry']);
    Route::get('/edit/user/{id}', ['as' => 'edit-user-page', 'uses' => 'UserController@getEditUser']);
    Route::get('/edit/partner/{id}', ['as' => 'edit-partner-page', 'uses' => 'PartnerController@getEditPartner']);

    Route::post('/edit/country/{id}', ['as' => 'update-country-page', 'uses' => 'CountryController@postEditCountry']);
    Route::post('/edit/user/{id}', ['as' => 'update-user-page', 'uses' => 'UserController@postEditUser']);
    Route::post('/edit/partner/{id}', ['as' => 'update-partner-page', 'uses' => 'PartnerController@postEditPartner']);

    Route::post('/delete/partners', ['as' => 'delete-partners-page', 'uses' => 'PartnerController@DeletePartners']);
    Route::post('/delete/users', ['as' => 'delete-users-page', 'uses' => 'UserController@DeleteUsers']);
    Route::post('/delete/countries', ['as' => 'delete-countries-page', 'uses' => 'CountryController@DeleteCountries']);

    Route::get('/delete/country/{id}', ['as' => 'delete-country-page', 'uses' => 'CountryController@getDeleteCountry']);
    Route::get('/delete/user/{id}', ['as' => 'delete-user-page', 'uses' => 'UserController@getDeleteUser']);
    Route::get('/delete/partner/{id}', ['as' => 'delete-partner-page', 'uses' => 'PartnerController@getDeletePartner']);

    Route::post('/update-global', ['as' => 'update-global-page', 'uses' => 'GlobalController@postUpdateGlobal']);
    Route::post('/new-country', ['as' => 'post-new-country-page', 'uses' => 'CountryController@postNewCountry']);
    Route::post('/new-user', ['as' => 'post-new-user-page', 'uses' => 'UserController@postNewUser']);
    Route::post('/new-partner', ['as' => 'post-new-partner-page', 'uses' => 'PartnerController@postNewPartner']);
  });

  Route::group(['prefix' => 'client'], function () {
    Route::get('/schedules', ['as' => 'client-schedules-page', 'uses' => 'ClientController@getSchedules']);
    Route::get('/setting', ['as' => 'get-setting-page', 'uses' => 'ClientController@getSetting']);

    Route::match(["post", "get"], '/schedules/search-schedules', ['as' => 'client-search-schedules-page', 'uses' => 'ClientController@SearchSchedules']);

    Route::post('/setting', ['as' => 'post-setting-page', 'uses' => 'ClientController@postSetting']);
  });
});
