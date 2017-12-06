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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/tasks', 'TasksController')->except(['show', 'create']);

Route::get('taa/{user_id}', function($user_id) {
    // $request = array_except($request, ['_token']);
    echo 
    $request = [
        'user_id' => $user_id,
        'content' => '1233333',
    ];
    $input = Tasks::create($request);
    

    return $input;
});