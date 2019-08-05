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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


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


// Cohort Route
Route::get('/cohorts', 'CohortsController@index')->name('cohorts');
Route::post('/cohorts/create', 'CohortsController@store')->name('cohorts.store');
Route::get('/cohortStatus', 'CohortsController@cohortStatus');
Route::delete('/cohorts/{id}', 'CohortsController@destroy')->name('cohorts.destroy');
Route::get('/cohorts/{cohort}', 'CohortsController@show')->name('cohorts.show');

// Students Route
Route::get('/students', 'StudentsController@index');
Route::post('/students/create', 'StudentsController@store')->name('students.store');
Route::delete('/students/{id}', 'StudentsController@destroy')->name('students.destroy');
Route::get('/students/{student}', 'StudentsController@show')->name('students.show');
