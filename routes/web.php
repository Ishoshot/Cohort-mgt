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
Route::get('/changeStatus', 'TrackController@changeStatus');
Route::delete('/track/{id}', 'TrackController@destroy')->name('track.destroy');

//

