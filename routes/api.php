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

Route::apiResources([
    'doankhoato' => 'API\DoankhoatoController',
    'chidoan' => 'API\ChidoanController',
    'captochuc' => 'API\CaptochucController',
    'hoatdong' => 'API\HoatdongController',
    'khenthuong' => 'API\KhenthuongController',
    'kyluat' => 'API\KyluatController',
    'user' => 'API\UserController',
    'ct_hoatdong' => 'API\Ct_hoatdongController',
    'vanban' => 'API\VanbanController',
    'role' => 'API\RoleController',
]);

Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('checkrole', 'API\UserController@checkrole');

Route::put('updaterole', 'API\UserController@updateRole');
