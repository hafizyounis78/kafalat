<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('login', 'Api\UserController@login');
Route::post('refresh_token', 'Api\UserController@refresh_token');
Route::post('getDeliverySchedules', 'Api\OrderController@getDeliverySchedules');
Route::post('forgetPassword', 'Api\UserController@forgetPassword');
Route::group(['middleware' => ['auth:api'], 'namespace' => 'Api'], function () {
    //users
    Route::post('/myProfile', 'UserController@myProfile');
    Route::post('/updateProfile', 'UserController@updateProfile');
    Route::post('/updatelocation', 'UserController@updateLocation');
    Route::post('/getlocation', 'UserController@getLocation');
    Route::post('/logout', 'UserController@logout');
    // Route::post('/refresh_token', 'UserController@refresh_token');

    //Attendance
    Route::post('/checkInOut', 'AttendController@checkInOut');
    Route::post('/checkInOutRaw', 'AttendController@checkInOutRaw');
    Route::post('/getAttendance', 'AttendController@getAttendance');
    //Lookups
    Route::post('/getLookup', 'LookupController@getLookups');
    Route::post('/getLookupAll', 'LookupController@getLookupAll');
    Route::post('/getStaticLookup', 'LookupController@getStaticLookup');
    //get Reports
    Route::post('/getAllBenfReport', 'ReportsController@getAllBenfReport');
    Route::post('/getOneVisitReport', 'ReportsController@getOneVisitReport');
    Route::post('/getVisitsBySponserId', 'ReportsController@getVisitsBySponserId');//new 09-04-2020
    Route::post('/getBenVisits', 'ReportsController@getBenVisits');
    Route::post('/getGuardDetails', 'ReportsController@get_guard_details');
    //insert
    Route::post('/newBenfReport', 'ReportsController@newBenfReport');//updated 10-04-2020
    Route::post('/addGuardDetails', 'ReportsController@guard_details');//updated 10-04-2020
    Route::post('/addStaticalCard', 'ReportsController@staticalCard');//updated 28-04-2020
    Route::post('/getStaticalCard', 'ReportsController@getStaticalCard');//updated 28-04-2020
    //search
    Route::post('/getVisitsWithImage', 'ReportsController@getVisitsWithImage');//updated 10-04-2020
    Route::post('/searchByname', 'ReportsController@searchByname');
    Route::post('/searchByParam', 'ReportsController@searchByParam');//updated 10-04-2020
    Route::post('/addBeneImages', 'ReportsController@addBeneImages');

    Route::post('/addGuardian', 'GuardianController@insert_guardian');//new 09-04-2020
    Route::post('/addRawGuardian', 'GuardianController@insert_raw_guardian');//new 09-04-2020
    Route::post('/getGuardianList', 'GuardianController@get_guardian');//new 09-04-2020
    Route::post('/getGuardianbyId', 'GuardianController@get_guardian_byId');//new 10-04-2020

    //Notifications
    Route::post('getMyNotification', 'NotificationController@getMyNotification');
    Route::post('getbadge', 'NotificationController@getbadge');
    Route::post('seenNoti', 'NotificationController@seenNoti');
});
Route::get('getLookupAll', 'Api\LookupController@getLookupAll');

Route::post('clear', 'Api\UserController@clear');
