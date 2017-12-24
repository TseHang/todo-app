<?php

namespace App\Http\Controllers;

use App\Tasks;
use App\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $name)
    {
        $id = User::where('name', $name)->first()->id;
        $remember_token = FindUserRememberToken($request->cookie('todoApp'), $request->session()->get('todoApp'));
        if (strlen($remember_token) > 0) {
            return view('tasks', [
                'id' => $id,
                'username' => $name,
            ]);
        }
        return redirect('/');
    }

    public function read($name) {
        $query = User::where('name', $name)->first()->tasks->all();
        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $name)
    {  
        if(empty($request->content)) {
            throw new Exception('Input error', 'empty string');
            return;
        }
        $request['user_id'] = User::where('name', $name)->first()->id;
        $input = Tasks::create($request->all());
        return $input;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name, $taskId)
    {
        $updated = Tasks::find($taskId)->update($request->all());
        return (string) $updated;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name, $taskId)
    {
        return (string) Tasks::findOrFail($taskId)->delete();
    }
}
