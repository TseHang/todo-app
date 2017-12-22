@extends('layouts.app')
@section('title', '重設密碼')
@section('css')
	<link rel="stylesheet" href = "{{asset('css/app.css')}}">
@endsection


@section('content')
<div class="container">
	<div class="block">
		<h3>重設密碼</h3>

		{!! Form::open(['method'=>'POST', 'url'=> '/' . $token . '/password/reset']) !!}

		{!! csrf_field() !!}

		<div class="form-group">
			{!! Form::label('新密碼: ', null, ['class' => 'label']) !!}
			{!! Form::password('password'); !!}
		</div>

		<div class="form-group">
			{!! Form::label('確認密碼: ', null, ['class' => 'label']) !!}
			{!! Form::password('password_confirmation'); !!}
		</div>

		<div class="form-group">
			<button type="submit" class="btn">確認</button>
		</div>

		{!! Form::close() !!}

		@include('includes.form_errors')
		@include('includes.message')
	</div>
</div>
@endsection