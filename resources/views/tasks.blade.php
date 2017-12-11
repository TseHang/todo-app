<!DOCTYPE html>

<html style = "height:100%;width:100%;margin:0px;">
<head>

  @include('includes.head')
  <!-- <title> Todo/{{Auth::user()->name}} </title> -->
  <link rel="stylesheet" href = "{{asset('css/app.css')}}">

</head>
<body>
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
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</html>