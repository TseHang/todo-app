@extends('layouts.app')
@section('title', $username)

@section('css')
  <link rel="stylesheet" href = "{{asset('css/tasks.css', env('REDIRECT_HTTPS'))}}">
@endsection

@section('js')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="{{asset('js/tasks.js')}}"></script>
@endsection

@section('content')
  <div class="container">
    <div class="date-container">
      <span class="date">
        24
      </span>
      <span class="month">
        APR
      </span>
      <span class="year">
        2017
      </span>
      <span class="day">
        Mon
      </span>
    </div>
    <div class="input-container">
      <input type="text" class="input-task" placeholder="My new task">
    </div>
    <div class="task-container">
    </div>
    <hr>
    <div class="task-row">
      <input type="checkbox" id="with-done" data-id="done" class="checkbox">
      <p class="task-description">Done</p>
    </div>
  </div>
@endsection