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

Route::get('/', 'DateController@login');
Route::group(['prefix'=>'date'], function(){
    Route::get('/', 'DateController@login');
    Route::get('/login', 'DateController@login');
    Route::post('/login_post', 'DateController@login_post');
    Route::get('/data', 'DateController@data')->middleware('check_status');
    Route::get('/invitation', 'DateController@invitation')->middleware('check_status');
    Route::post('/invitation_post', 'DateController@invitation_post');
    Route::get('/respond', 'DateController@respond')->middleware('check_status');
    Route::post('/respond_post', 'DateController@respond_post');
    Route::get('/show_result', 'DateController@show_result')->middleware('check_status');
    Route::post('/date_msg_post', 'DateController@date_msg_post');
    Route::get('/logout', 'DateController@logout');
    Route::get('/restaurant', 'DateController@restaurant')->middleware('check_status');
    //Route::get('/test', 'DateController@test');
}); 
