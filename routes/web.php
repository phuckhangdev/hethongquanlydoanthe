<?php
use Illuminate\Http\Request;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
    if (!Auth::check()) {
        return view('auth.login');
    } 
    else {
        return redirect('/home');
    }
    return abort(404);
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d-\/_.]+)?' );

// Route::group(['middleware' => 'role:admin'], function() {
//     Route::get('/home', 'HomeController@index');
//     Route::get('/doankhoato', 'HomeController@index'); // maybe change DashboardController to process
//     Route::get('/chidoan', 'HomeController@index');
// });

// Route::group(['middleware' => 'role:manager'], function() {
//     Route::get('/home', 'HomeController@index');
// });

// Route::group(['middleware' => 'role:student'], function() {
//     Route::get('/home', 'HomeController@index')->name('home');
// });
