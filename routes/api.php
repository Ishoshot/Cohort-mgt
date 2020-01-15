<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// List Cohorts
Route::get('cohorts', 'AttendanceController@cohort');

// Take Attendance
Route::post('submit', 'AttendanceController@submit');

// Load Cohorts
Route::get('loadCohorts', 'AttendanceController@loadCohorts');

// GetData For Pairing
Route::post('getdata', 'AttendanceController@getData');

// Get Paired Students
Route::post('getPairedStudents', 'AttendanceController@getPairedStudents');

// Map Pair
Route::post('mapPair', 'AttendanceController@mapPair');


// Notify For Attendance [Electron]
Route::get('/checkAttendance', 'AttendanceController@NotifyToTakeAttendance');