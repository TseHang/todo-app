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


// Todo: 把 tasks 分開！

Route::get('/welcome', function () {
    return view('welcome');
});

Route::group(['middleware' => 'VerifyUser'], function () {

    Route::get('/', 'AuthActionController@index');
    Route::get('/register', 'AuthActionController@registerPage'); 
    Route::get('/logout', 'AuthActionController@logout'); 
    Route::get('/password/reset' , function() {
        return view('auth.passwordReset', ['message' => false]);
    });

    Route::post('/login', 'AuthActionController@login'); 
    Route::post('/register', 'AuthActionController@register'); 
    Route::post('/password/reset', 'AuthActionController@password_reset');
    Route::post('/{token}/password/reset', 'AuthActionController@reset');
    // Route::get('/{name}/tasks', 'AuthActionController@showTasks');

    Route::get('/{name}/tasks/read', 'TasksController@read');
    Route::resource('/{name}/tasks', 'TasksController')->except(['edit', 'show', 'create']);

});


Route::get('register/verify/{confirmationCode}_email_verify', [
    'as' => 'register.verify.confirmation',
    'uses' => 'AuthActionController@confirm',
]);

Route::get('password/reset/{token}_email_verify', function ($token) {
    return view('auth.password.reset', [
        'token' => $token,
        'message' => 'Please reset your password!',
    ]);
});




Route::get('/showToken', 'AuthActionController@showToken');
Route::get('/showCookie', 'AuthActionController@showCookie');
Route::get('/session', 'AuthActionController@session');

Route::get('/clear', function() {
    session()->forget('todoApp');
    return redirect('/')->withCookie(Cookie::forget('todoApp'));
});

Route::get('/mailTest', function () {
    $data = [
        'title' => 'Hihi~~',
        'content' => 'This is content',
    ];

    Mail::send('email.test', $data, function ($message) {
        $message->to('a54383813@gmail.com', 'Henry')->subject('Hello stident, how r u');
    });
});