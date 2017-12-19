<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

function CheckLoginDB ($username, $pwd, $table) {
    $user = DB::table('users')->where([
        ['name', $username],
    ])->get();

    if ($user->isEmpty()) return false;
    
    $user = $user->first();
    return Hash::check($pwd, $user->password) ? $user : false;
}


function CheckLogin ($remember_token) {
    return DB::table('users')->where('remember_token', $remember_token)->get()->first();
}

function FindRememberToken($cookie, $session) {
    return $cookie ? $cookie : $session ? $session : false;
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
        $remember_token = FindRememberToken($request->cookie('todoApp'), $request->session()->get('todoApp'));
        if (strlen($remember_token) > 0) {
            if ($user = CheckLogin($remember_token)) {
                return redirect('/' . $user->name . '/tasks');
            }
        }
        return view('auth.login', ['login_description' => false]);
    }

    public function login(Request $request)
    {
        $table = DB::table('users');
        if(!$user = CheckLoginDB($request->name, $request->password, $table)) {
            return view('auth.login', ['login_description' => 'Wrong username or password!!']);
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
        $confirmation_code = str_random(20);
        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'confirmation_code' => $confirmation_code,
        ]);

        $data = [
            'confirmation_code' => $confirmation_code,
            'email' => $request->email,
            'username' => $request->name,
        ];

        // when using a closure (anonymous function), `use ($data)`
        Mail::send('email.verify', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['username'])->subject('[Todo Yo~] Verify your email address!');
        });

        return redirect('/');
    }


    public function confirm ($confirmation_code) {
        $user = User::where('confirmation_code', $confirmation_code)->first();

        if (!$user) {
            return view('errors.404');
        }

        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();

        return view('auth.login', ['login_description' => 'You have successfully verified your account. Please Login']);
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
        // return view('auth.login', ['login_description' => 'You have successfully verified your account. Please Login']);
    }


}
