@extends('layouts.app')
@section('title', '註冊新的用戶')
@section('css')
	<link rel="stylesheet" href = "{{asset('css/app.css')}}">
@endsection

@section('content')

<div class="container">
	<div class="block">
		<h1>Todo yo~</h1>

		<h3>註冊</h3>
		{!! Form::open(['method'=>'POST', 'url'=> '/register']) !!}

		{!! csrf_field() !!}

		<div class="form-group {{$errors->has('name') ? ' has-error' : '' }}">
			{!! Form::label('username: ', null, ['class' => 'label']) !!}
			{!! Form::text('name'); !!}
		</div>

		<div class="form-group {{$errors->has('email') ? ' has-error' : ''}}">
			{!! Form::label('email: ', null, ['placeholder' => 'Email@example.com', 'id' => 'email', 'class' => 'label']) !!}
			{!! Form::email('email', $value = null, $attributes = []) !!}
		</div>

		<div class="form-group {{$errors->has('password') ? ' has-error' : '' }}">
			{!! Form::label('password: ', null, ['class' => 'label']) !!}
			{!! Form::password('password'); !!}
		</div>

		<div class="form-group">
			{!! Form::label('Confirm: ', null, ['class' => 'label']) !!}
			{!! Form::password('password_confirmation'); !!}
		</div>


		<div class="form-group submit-group">
			<button type="submit" class="btn">Register</button>
			<a class="link" href="{{ url('/') }}">I have an account~</a>
		</div>
		{!! Form::close() !!}

		@include('includes.form_errors')
	</div>
</div>

@endsection