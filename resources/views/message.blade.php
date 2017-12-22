@extends('layouts.app')
@section('title', 'OOXX%%%666666666')
@section('css')
	<link rel="stylesheet" href = "{{asset('css/app.css'), env('REDIRECT_HTTPS')}}">
@endsection
@section('js')
	<script type="text/javascript" src="{{asset('js/message.js')}}"></script>
@endsection



@section('content')
<div class="container">
	<h1>Todo yo~</h1>

	<h3><span id="time">3</span> 秒後跳轉到主畫面...</h3>

	@if($message)
		<h3>{{$message}}</h3>
	@endif
</div>
@endsection
