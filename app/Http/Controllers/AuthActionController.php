<?php

namespace App\Http\Controllers;

use App\User;
use App\PasswordReset;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class AuthActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $remember_token = FindUserRememberToken($request->cookie('todoApp'), $request->session()->get('todoApp'));
        if (strlen($remember_token) > 0) {
            if ($user = CheckUserLogin($remember_token)) {
                return redirect('/' . $user->name . '/tasks');
            }
        }
        return view('auth.login', ['message' => false]);
    }

    public function login(Request $request)
    {
        $table = DB::table('users');
        if(!$user = CheckLoginDB($request->name, $request->password, $table)) {
            return view('auth.login', ['message' => 'Wrong username or password!!']);
        };

        if($user->confirmed) {
            // Login Success
            $session_todoApp = UpdateRememberToken(User::findOrFail($user->id));
            session(['todoApp' => $session_todoApp]);
            return redirect('/' . $user->name . '/tasks')->withCookie('todoApp', $session_todoApp);
        }

        return view('auth.login', ['message' => 'You have to verify your email to start your account!']);
        // [Ask]: return redirect()->route('/{user}/tasks', ['user' => $name]);
    }

    public function logout(Request $request) {
        session()->forget('todoApp');
        return redirect('/')->withCookie(Cookie::forget('todoApp'));
    }

    public function register(UsersRequest $request)
    {
        $confirmation_code = str_random(30);
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'confirmation_code' => $confirmation_code,
        ]);

        PasswordReset::create([
            'email' => $request->email,
            'token' => str_random(30),
        ]);

        $data = [
            'confirmation_code' => $confirmation_code,
            'email' => $request->email,
            'username' => $request->name,
        ];

        // when using a closure (anonymous function), `use ($data)`
        Mail::send('email.verify', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['username'])->subject('[Todo Yo] Verify your email address!');
        });

        return view('message', ['message' => 'Please verified your account, then login!!']);
    }


    public function confirm ($confirmation_code) {
        $user = User::where('confirmation_code', $confirmation_code)->first();

        if (!$user) {
            return view('errors.404');
        }

        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();

        return view('auth.login', ['message' => 'You have successfully verified your account. Please Login']);
    } 


    public function password_reset (Request $request) {        
        $user = User::where([
            ['name', $request->name],
            ['email', $request->email],
        ])->first();

        if(!$user) {
            return view('auth.passwordReset', ['message' => 'Wrong email or username!']);
        }

        $token = $user->password_resets->token;

        $data = [
            'token' => $token,
            'username' => $user->name,
            'email' => $user->email,
        ];

        // when using a closure (anonymous function), `use ($data)`
        Mail::send('email.password_reset', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['username'])->subject('[Todo Yo] Reset your password!');
        });

        return view('message', ['message' => 'Please check your email to reset password!']);
    }


    public function reset(Request $request, $token) {
        $password_reset_raw = PasswordReset::where('token', $token)->first();
        
        if (!$password_reset_raw) return view('errors.404');

        $user = $password_reset_raw->user;
        $user->password = Hash::make($request->password);
        $user->save();

        // update token
        DB::update('update password_resets set token = ? where email = ?', [str_random(30), 'a54383813@gmail.com']);

        return view('/message', ['message' => $password_reset_raw->token]);
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

    public function showToken() {
        return User::find(18)->password_resets? 'true' : 'false';
    }


}
