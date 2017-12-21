@extends('layouts.app')

@section('content')
<h1>Todo yo~</h1>

<h3><span id="time">3</span> 秒後跳轉到主畫面...</h3>

@if($message)
<div class="alert-danger">
	<h1>{{$message}}</h1>
</div>
@endif

<script type="text/javascript" src="{{asset('js/message.js')}}"></script>
@endsection
