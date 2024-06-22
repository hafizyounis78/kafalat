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


Route::get('/', 'UserController@login');

Auth::routes();
Route::get('home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {


    Route::resource('user', 'UserController');
    Route::get('user-data', 'UserController@userData');
    Route::post('user/availabileEmail', 'UserController@availabileEmail');
    Route::post('user/getEmployee', 'UserController@getEmployee');
    Route::post('user/del-one', 'UserController@del_one_user');
    Route::post('user/del-chk', 'UserController@del_chk_user');
    Route::get('user/{id}/map', 'UserController@show_user_map');
    Route::post('user/all-location-date', 'UserController@get_user_locations');
    Route::post('user/get-supervisor', 'UserController@getUserSupervisor');

    Route::post('get-guardian-data', 'UserController@getGuardianData');
    Route::get('logout', 'UserController@logout');

    Route::get('setting/s2', 'SettingController@s2');
    Route::get('s2-data', 'SettingController@s2_data');
    Route::post('s2-details-data', 'SettingController@s2_detials_data');
    Route::post('setting/s2-save', 'SettingController@s2_save');
    Route::post('setting/s2-delete', 'SettingController@s2_delete');
    Route::post('setting/s2-detail-delete', 'SettingController@s2_detail_delete');
    Route::post('setting/s4-change-state', 'SettingController@s4_change_state');
    Route::post('setting/save-lookup-detail', 'SettingController@s2_details_save');
    Route::get('setting/s4', 'SettingController@s4');
    Route::get('s4-data', 'SettingController@s4_data');
    //attendance
    Route::resource('attendance', 'AttendanceController');
    Route::post('attendance-data', 'AttendanceController@attendanceData');
    //  Route::get('attendance/getAttendByDate', 'AttendanceController@getAttendByDate');
    //reports
    Route::resource('report', 'ReportController');
    Route::post('report-data', 'ReportController@reportData');
    Route::post('visits-data', 'ReportController@visitsData');
    Route::post('one-visit', 'ReportController@getOneVisit');
    Route::post('year-report', 'ReportController@getYearlyReport');
    // Route::post('print-visit', 'ReportController@printVisit');
    Route::get('print/{id}', 'ReportController@printVisit');
    Route::get('yearly-print/{id}', 'ReportController@getYearlyReport');

    Route::post('filterVisits-data', 'ReportController@filterVisitsData');
    Route::post('filterExcel-data', 'ReportController@filterExcel');

    Route::post('filterNeeds-data', 'ReportController@filterNeedsData');
    Route::post('filter-enquiry-data', 'ReportController@filterEnquiryData');

    Route::post('get-rep-prop', 'ReportController@get_rep_prop');
    Route::post('bef/del-one', 'ReportController@del_one_bef');
    Route::post('bef/del-chk', 'ReportController@del_chk_bef');
    Route::post('bef/change-report-status', 'ReportController@change_report_status');
    Route::post('run_rep', 'ReportController@run_rep');
    Route::post('run_rep_view', 'ReportController@run_rep_view');
    Route::post('report/get-sub-need', 'ReportController@get_sub_need');
    Route::post('report/get-outcome-need', 'ReportController@get_outcome_need');
    Route::post('report/get-report-status', 'ReportController@get_report_status');
    Route::post('report/get-report-status-byReference', 'ReportController@get_report_status_byReference');





    Route::get('system-report', 'ReportController@system_report');
    Route::get('needs-report', 'ReportController@needs_report');
    Route::get('report-enquiry', 'ReportController@report_enquiry');


    //Guardian
    Route::resource('guardian', 'GuardianController');
    Route::post('guardian/guardian-data', 'GuardianController@getGuardianData');
    Route::post('guardian/sponsored-data', 'GuardianController@getSponsoredData');
    Route::post('guardian/get-city', 'GuardianController@getCity');
    Route::post('guardian/get-image', 'GuardianController@getGuardianImage');
    //Route::post('get-guardian-data', 'UserController@getGuardianData');
  //  Route::post('supporter-data', 'GuardianController@supporterData');



    //

    //roles
    Route::get('role', 'RoleController@role');
    Route::get('role-data', 'RoleController@roleData');
    Route::post('storeRole', 'RoleController@roleStore');
    Route::post('deleteRole', 'RoleController@roleDelete');
    Route::post('role/getPermissions', 'RoleController@getPermissions');
    Route::post('role/getRolePermissions', 'RoleController@getRolePermissions');

    Route::post('role/selectPer', 'RoleController@selectPer');
    Route::post('role/deselectPer', 'RoleController@deselectPer');

    Route::post('role/selectUserPer', 'RoleController@selectUserPer');
    Route::post('role/deselectUserPer', 'RoleController@deselectUserPer');
    //menu
    Route::get('menu', 'RoleController@menu');
    Route::get('menu-data', 'RoleController@menuData');
    Route::post('storeMenu', 'RoleController@menuStore');
    Route::post('deleteMenu', 'RoleController@menuDelete');

    //permission
    Route::get('permission', 'RoleController@permission');
    Route::get('permission-data', 'RoleController@permissionData');
    Route::post('storePermission', 'RoleController@permissionStore');
    Route::post('deletePermission', 'RoleController@permissionDelete');
    Route::get('role_permission', 'RoleController@role_permission');
    Route::get('user_permission', 'RoleController@user_permission');
});
