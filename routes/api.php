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

Route::post('/v1/addMember', 'api\AppointmentApiController@addMember');
Route::post('/v1/pushMember', 'api\AppointmentApiController@pushMember');
Route::post('/v1/goldPushMember', 'api\AppointmentApiController@goldPushMember');
Route::post('/v1/inviteInsertPush', 'api\AppointmentApiController@inviteInsertPush');

Route::post('/v1/pairTime', 'api\AppointmentApiController@pairTime');