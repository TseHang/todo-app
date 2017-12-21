@extends('layouts.app')

@section('content')

<h1>註冊</h1>

{!! Form::open(['method'=>'POST', 'url'=> '/register']) !!}

{!! csrf_field() !!}

<div class="form-group {{$errors->has('name') ? ' has-error' : '' }}">
	{!! Form::label('username: ', null, ['class' => 'username']) !!}
	{!! Form::text('name'); !!}
</div>

<div class="form-group {{$errors->has('email') ? ' has-error' : ''}}">
	{!! Form::label('email: ', null, ['placeholder' => 'Email@example.com', 'id' => 'email', 'class' => 'form-control']) !!}
	{!! Form::email('email', $value = null, $attributes = []) !!}
</div>

<div class="form-group {{$errors->has('password') ? ' has-error' : '' }}">
	{!! Form::label('password: ', null, ['class' => 'password']) !!}
	{!! Form::password('password'); !!}
</div>

<div class="form-group">
	{!! Form::label('Confirm password: ', null, ['class' => 'password']) !!}
	{!! Form::password('password_confirmation'); !!}
</div>


<div class="form-group">
	<div class="yoyoman">
		<button type="submit" class="btn">Login</button>

		<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
	</div>
</div>

{!! Form::close() !!}

@include('includes.form_errors')

@endsection