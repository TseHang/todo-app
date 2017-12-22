@extends('layouts.app')
@section('title', '登入')

@section('css')
	<link rel="stylesheet" href = "{{asset('css/app.css')}}">
@endsection

@section('content')

<div class="container">
	<div class="block">
		<h1 class="title">Todo yo~</h1>

		<h3>登入</h3>

		{!! Form::open(['method'=>'POST', 'url'=> '/login']) !!}

		{!! csrf_field() !!}

		<div class="form-group">
			{!! Form::label('username : ', null, ['class' => 'label']) !!}
			{!! Form::text('name') !!}
		</div>

		<div class="form-group">
			{!! Form::label('password : ', null, ['class' => 'label']) !!}
			{!! Form::password('password') !!}
		</div>


		<div class="form-group submit-group">
			<button type="submit" class="btn">Login</button>
			<a class="link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
		</div>

		{!! Form::close() !!}
		@include('includes.form_errors')
		@include('includes.message')
	</div>
</div>

@endsection