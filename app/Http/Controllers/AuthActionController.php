<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;

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
        $user = $request->all();
        $answer = User::where('name', $user->name);
        return $answer->all();
    }
}
