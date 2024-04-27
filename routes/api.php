<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//account
Route::post('/account', 'App\Http\Controllers\UserMobileController@store');
Route::post('/login', 'App\Http\Controllers\UserMobileController@get');
Route::get('/getDoctors', 'App\Http\Controllers\UserMobileController@getDoctors');
Route::get('/getParents', 'App\Http\Controllers\UserMobileController@getParents');
Route::post('/changeProfileImage', 'App\Http\Controllers\UserMobileController@changeProfile');

//child
Route::post('/childprofile', 'App\Http\Controllers\ChildMobileController@store');
Route::post('/getchildprofile', 'App\Http\Controllers\ChildMobileController@get');
Route::get('/getAllChildProfile','App\Http\Controllers\ChildMobileController@getAll');
Route::post('/getChildProfileDoc', 'App\Http\Controllers\ChildMobileController@getDoc');
Route::post('/childDelete', 'App\Http\Controllers\ChildMobileController@delete');

//appointment
Route::post('/appointments/store', 'App\Http\Controllers\AppointmentMobileController@store');
Route::post('/appointments/getAllApp', 'App\Http\Controllers\AppointmentMobileController@AllAppointments');
Route::post('/appointments/getFirstApp', 'App\Http\Controllers\AppointmentMobileController@firstApp');

//appointmentdoctor
Route::post('/appointments/getFirstAppDoc', 'App\Http\Controllers\AppointmentMobileController@firstAppDoc');
Route::post('/appointments/getAllAppDoc', 'App\Http\Controllers\AppointmentMobileController@AllAppointmentsDoc');
Route::post('/appointments/cancelAppDoc', 'App\Http\Controllers\AppointmentMobileController@cancel');
Route::post('/appointments/confirmAppDoc', 'App\Http\Controllers\AppointmentMobileController@confirm');
Route::post('/appointments/countDoc', 'App\Http\Controllers\AppointmentMobileController@countAllAppointments');
Route::post('/appointments/getAllAppDocToday', 'App\Http\Controllers\AppointmentMobileController@AllAppointmentsDocToday');

//dailycare
Route::get('/dailycare', 'App\Http\Controllers\DailyCareMobileController@get');
Route::get('/dailycaretwo', 'App\Http\Controllers\DailyCareMobileController@gettwo');
Route::post('/dailycareguide', 'App\Http\Controllers\DailyCareMobileController@createguide');
Route::post('/dailycaregetbody', 'App\Http\Controllers\DailyCareMobileController@getBody');
Route::post('/dailycareedit', 'App\Http\Controllers\DailyCareMobileController@edit');
Route::post('/dailycarechangeimage', 'App\Http\Controllers\DailyCareMobileController@changeImage');
Route::post('/dailycaredelete', 'App\Http\Controllers\DailyCareMobileController@delete');
//category
Route::get('getCategories', 'App\Http\Controllers\CategoryMobileController@get');

//posts
Route::post('/createpost', 'App\Http\Controllers\PostMobileController@createpost');
Route::get('/posts', 'App\Http\Controllers\PostMobileController@get');
Route::post('/createImage', 'App\Http\Controllers\PostMobileController@uploadImage');

//comments
Route::post('/getComments', 'App\Http\Controllers\CommentMobileController@getComments');
Route::post('/storeComment', 'App\Http\Controllers\CommentMobileController@storeComment');


//childhistory
Route::post('/childHistoryCreate', 'App\Http\Controllers\ChildHistoryMobileController@store');
Route::post('/childHistoryGet', 'App\Http\Controllers\ChildHistoryMobileController@get');
Route::post('/childHistoryUpdate', 'App\Http\Controllers\ChildHistoryMobileController@updateAssessment');
Route::post('/childHistoryGetOne', 'App\Http\Controllers\ChildHistoryMobileController@getOne');
Route::post('/childHistoryDelete', 'App\Http\Controllers\ChildHistoryMobileController@delete');
//payment
Route::post('/storePayment', 'App\Http\Controllers\PaymentMobileController@store');
Route::post('/getAppointPayments', 'App\Http\Controllers\PaymentMobileController@getAppointPayment');

//doc schedules
Route::post('/createDocSched', 'App\Http\Controllers\DoctorSchedulesMobileController@create');
Route::post('/getDocSchedule', 'App\Http\Controllers\DoctorSchedulesMobileController@get');
Route::post('/editDocSchedule', 'App\Http\Controllers\DoctorSchedulesMobileController@edit');
Route::post('/deleteSchedule', 'App\Http\Controllers\DoctorSchedulesMobileController@delete');
