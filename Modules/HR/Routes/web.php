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

Route::prefix('hr')->group(function() {
    Route::get('/', 'HRController@index');
});


Route::group(['as' => 'hr.admin.', 'prefix' => 'admin/hr', 'namespace' => 'Admin', 'middleware' => ['auth']],function() {
    
    // Daily Attendances
    Route::delete('daily-attendances/destroy', 'DailyAttendancesController@massDestroy')->name('daily-attendances.massDestroy');
    Route::resource('daily-attendances', 'DailyAttendancesController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Monthly Attendances
    Route::resource('monthly-attendances', 'MonthlyAttendancesController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Client Meetings
    Route::delete('client-meetings/destroy', 'ClientMeetingsController@massDestroy')->name('client-meetings.massDestroy');
    Route::resource('client-meetings', 'ClientMeetingsController');

    // Survey
    // Route::delete('survey/destroy', 'SurveyController@massDestroy')->name('survey.massDestroy');
    // Route::resource('survey', 'SurveyController');

    // Employees
    Route::delete('employees/destroy', 'EmployeesController@massDestroy')->name('employees.massDestroy');
    Route::resource('employees', 'EmployeesController');

     // Departments
     Route::delete('departments/destroy', 'DepartmentsController@massDestroy')->name('departments.massDestroy');
     Route::resource('departments', 'DepartmentsController');
 
     // Designations
     Route::delete('designations/destroy', 'DesignationsController@massDestroy')->name('designations.massDestroy');
     Route::resource('designations', 'DesignationsController');
 
     // Account Details
     Route::delete('account-details/destroy', 'AccountDetailsController@massDestroy')->name('account-details.massDestroy');
     Route::post('account-details/media', 'AccountDetailsController@storeMedia')->name('account-details.storeMedia');
     Route::post('account-details/ckmedia', 'AccountDetailsController@storeCKEditorImages')->name('account-details.storeCKEditorImages');
     Route::resource('account-details', 'AccountDetailsController');
 
     // Overtimes
     Route::delete('overtimes/destroy', 'OvertimeController@massDestroy')->name('overtimes.massDestroy');
     Route::post('overtimes/media', 'OvertimeController@storeMedia')->name('overtimes.storeMedia');
     Route::post('overtimes/ckmedia', 'OvertimeController@storeCKEditorImages')->name('overtimes.storeCKEditorImages');
     Route::resource('overtimes', 'OvertimeController');
 
     // Holidays
     Route::delete('holidays/destroy', 'HolidaysController@massDestroy')->name('holidays.massDestroy');
     Route::resource('holidays', 'HolidaysController');
 
     // Trainings
     Route::delete('trainings/destroy', 'TrainingsController@massDestroy')->name('trainings.massDestroy');
     Route::post('trainings/media', 'TrainingsController@storeMedia')->name('trainings.storeMedia');
     Route::post('trainings/ckmedia', 'TrainingsController@storeCKEditorImages')->name('trainings.storeCKEditorImages');
     Route::resource('trainings', 'TrainingsController');
 
     // Leave Categories
     Route::delete('leave-categories/destroy', 'LeaveCategoriesController@massDestroy')->name('leave-categories.massDestroy');
     Route::resource('leave-categories', 'LeaveCategoriesController');
 
     // Leave Applications
     Route::delete('leave-applications/destroy', 'LeaveApplicationsController@massDestroy')->name('leave-applications.massDestroy');
     Route::post('leave-applications/media', 'LeaveApplicationsController@storeMedia')->name('leave-applications.storeMedia');
     Route::post('leave-applications/ckmedia', 'LeaveApplicationsController@storeCKEditorImages')->name('leave-applications.storeCKEditorImages');
     Route::resource('leave-applications', 'LeaveApplicationsController');
 
     // Meeting Minutes
     Route::delete('meeting-minutes/destroy', 'MeetingMinutesController@massDestroy')->name('meeting-minutes.massDestroy');
     Route::post('meeting-minutes/media', 'MeetingMinutesController@storeMedia')->name('meeting-minutes.storeMedia');
     Route::post('meeting-minutes/ckmedia', 'MeetingMinutesController@storeCKEditorImages')->name('meeting-minutes.storeCKEditorImages');
     Route::resource('meeting-minutes', 'MeetingMinutesController');
 
     // Employee Awards
     Route::delete('employee-awards/destroy', 'EmployeeAwardsController@massDestroy')->name('employee-awards.massDestroy');
     Route::resource('employee-awards', 'EmployeeAwardsController');
 
     // attendances
     Route::delete('attendances/destroy', 'AttendancesController@massDestroy')->name('attendances.massDestroy');
     Route::resource('attendances', 'AttendancesController');

     // Employee Banks
     Route::delete('employee-banks/destroy', 'EmployeeBankController@massDestroy')->name('employee-banks.massDestroy');
     Route::resource('employee-banks', 'EmployeeBankController');
 
     // Vacations
     Route::delete('vacations/destroy', 'VacationsController@massDestroy')->name('vacations.massDestroy');
     Route::post('vacations/media', 'VacationsController@storeMedia')->name('vacations.storeMedia');
     Route::post('vacations/ckmedia', 'VacationsController@storeCKEditorImages')->name('vacations.storeCKEditorImages');
     Route::resource('vacations', 'VacationsController');
 

});
