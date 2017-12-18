<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

function CheckLoginDB($username, $pwd, $table) {
    $user = DB::table('users')->where([
        ['name', $username],
    ])->get();

    if ($user->isEmpty()) return false;
    
    $user = $user->first();
    return Hash::check($pwd, $user->password) ? $user : false;
}

class AuthActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login(UsersRequest $request)
    {
        $table = DB::table('users');
        if(!$user = CheckLoginDB($request->name, $request->password, $table)) {
            return 'Wrong username or password!';
        }
        $name = $user->name;
        return redirect('/' . $name . '/tasks');

        // [Ask]: return redirect()->route('/{user}/tasks', ['user' => $name]);
    }

    public function show() {
        return view('login');
    }
}
