<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

function CheckLoginDB ($username, $pwd, $table) {
    $user = DB::table('users')->where([
        ['name', $username],
    ])->get();

    if ($user->isEmpty()) return false;
    
    $user = $user->first();
    return Hash::check($pwd, $user->password) ? $user : false;
}

function UpdateRememberToken ($user) {
    $remember_token = bcrypt(str_random(30));
    $user->remember_token = $remember_token;
    $user->save();
    return (string) $remember_token;
}

class AuthActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $remember_token = $request->cookie('todoApp');
        if (strlen($remember_token) > 0) {
            $user = DB::table('users')->where('remember_token', $remember_token)->get()->first();
            return redirect('/' . $user->name . '/tasks');
        }
        return view('auth.login', ['login_problem' => false]);
    }

    public function login(Request $request)
    {
        $table = DB::table('users');
        if(!$user = CheckLoginDB($request->name, $request->password, $table)) {
            return view('auth.login', ['login_problem' => true]);
        };

        // Login Success
        $session_todoApp = UpdateRememberToken(User::findOrFail($user->id));
        session(['todoApp' => $session_todoApp]);
        return redirect('/' . $user->name . '/tasks')->withCookie('todoApp', $session_todoApp);

        // [Ask]: return redirect()->route('/{user}/tasks', ['user' => $name]);
    }

    public function logout(Request $request) {
        session()->forget('todoApp');
        return redirect('/')->withCookie(Cookie::forget('todoApp'));
    }

    public function register(UsersRequest $request)
    {
        // [Todo]: send email API / mail token.
        $table = DB::table('users');
        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email
        ]);
        return 'Ok';
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function showCookie(Request $request) {
        return $request->cookie();
    }

    public function session(Request $request) {
        return session()->all();
        // return $request->session()->flush();
    }
}
