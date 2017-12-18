<?php
use App\Tasks;
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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group(['middleware' => 'VerifyUser'], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/login', 'AuthActionController@show');
    Route::post('/login', 'AuthActionController@login'); 

    Route::get('/{user}/tasks', function ($user) {
        return view('tasks');
    });

    Route::resource('/tasks', 'TasksController')->except(['edit', 'show', 'create']);
});