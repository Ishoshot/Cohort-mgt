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

Route::get('/', function () {
	return view('attendance.welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');


// Track Routes
Route::get('/track', 'TrackController@index');
Route::Post('/track/create', 'TrackController@store');
Route::get('/trackStatus', 'TrackController@trackStatus');
Route::get('/showTopics', 'TrackController@showTopics');
Route::delete('/track/{id}', 'TrackController@destroy')->name('track.destroy');


// Topics Route
Route::get('/topics', 'TopicsController@index')->name('topics');
Route::post('/topics/create', 'TopicsController@store')->name('topics.store');
Route::delete('/topics/{id}', 'TopicsController@destroy')->name('topics.destroy');
Route::patch('/topics/update/{topic}', 'TopicsController@update')->name('topics.update');


// Cohort Route
Route::get('/cohorts', 'CohortsController@index')->name('cohorts');
Route::post('/cohorts/create', 'CohortsController@store')->name('cohorts.store');
Route::get('/cohortStatus', 'CohortsController@cohortStatus');
Route::delete('/cohorts/{id}', 'CohortsController@destroy')->name('cohorts.destroy');
Route::get('/cohorts/{cohort}', 'CohortsController@show')->name('cohorts.show');

//Schedule
Route::post('/schedule/generate/{id}', 'ScheduleController@generate')->name('schedule.generate');


// Students Route
Route::get('/students', 'StudentsController@index');
Route::post('/students/create', 'StudentsController@store')->name('students.store');
Route::delete('/students/{id}', 'StudentsController@destroy')->name('students.destroy');
Route::get('/students/{student}', 'StudentsController@show')->name('students.show');

//Pairs Route
Route::get('/pair', 'PairController@index');
Route::get('/pair/fetch', 'PairController@fetch')->name('pair.fetch');
Route::post('/mappairs', 'PairController@mappairs')->name('pair.mappairs');
Route::delete('/pair/{id}', 'PairController@destroy')->name('pair.destroy');

//Attendance routes
// Route::get('/attendance', 'AttendanceController@viewAttendance');
Route::get('/attendance', 'AdminAttendanceController@index');
Route::get('/viewAttendance', 'AdminAttendanceController@viewAttendance');
