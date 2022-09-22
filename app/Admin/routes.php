<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/MemberData','MemberDataController');
    $router->resource('/AppointmentList','AppointmentListController');
    $router->resource('/AppointmentRegistration','AppointmentRegistrationController');
    $router->resource('/Restaurant','RestaurantController');
    $router->resource('/RestaurantDate','RestaurantDateController');
    $router->resource('/VideoDate','VideoDateController');
    $router->resource('/PushFactor','PushFactorController');
    $router->get('/Upload','UploadController@index');
    $router->post('/UploadPost','UploadController@upload_post');
    $router->get('/Chart','ChartController@index');
    $router->get('/Other','OtherController@index');
    $router->get('/Download/{dbname}','OtherController@download');
});
