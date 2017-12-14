@extends('layouts.app')

@section('content')
{!! Form::open(['method'=>'POST', 'url'=> '/login']) !!}

<div class="form-group">
	{!! Form::label('username: ', null, ['class' => 'username']) !!}
	{!! Form::text('name'); !!}
</div>

<div class="form-group">
	{!! Form::label('email: ', null, ['placeholder' => 'Email@example.com', 'id' => 'email', 'class' => 'form-control']) !!}
	{!! Form::email('email', $value = null, $attributes = []) !!}
</div>

<div class="form-group">
	{!! Form::label('password: ', null, ['class' => 'password']) !!}
	{!! Form::password('password', ['class' => 'password']); !!}
</div>


<div class="form-group">
	<div class="yoyoman">
		<button type="submit" class="btn btn-primary">Login</button>

		<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
	</div>
</div>

{!! Form::close() !!}

@include('includes.form_errors')


{{--  <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
	{!! csrf_field() !!}

	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		<label class="col-md-4 control-label">E-Mail Address</label>

		<div class="col-md-6">
			<input type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif
		</div>
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		<label class="col-md-4 control-label">Password</label>

		<div class="col-md-6">
			<input type="password" class="form-control" name="password">
            @if ($errors->has('password'))
			<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
			@endif
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<div class="checkbox">
				<label>
					<input type="checkbox" name="remember"> Remember Me
				</label>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary">
				<i class="fa fa-btn fa-sign-in"></i>Login
			</button>

			<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
		</div>
	</div>
</form>  --}}

@endsection