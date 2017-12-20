<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


function CheckLoginDB ($username, $pwd, $table) {
    $user = DB::table('users')->where([
        ['name', $username],
    ])->first();

    if (!$user) return false;
    return Hash::check($pwd, $user->password) ? $user : false;
}


function CheckUserLogin ($remember_token) {
    return DB::table('users')->where('remember_token', $remember_token)->first();
}

function FindUserRememberToken($cookie, $session) {
    return $cookie ? $cookie : $session ? $session : false;
}

function UpdateRememberToken ($user) {
    $remember_token = bcrypt(str_random(30));
    $user->remember_token = $remember_token;
    $user->save();
    return (string) $remember_token;
}

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
