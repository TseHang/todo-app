@extends('layouts.app') 
@section('title', '忘記您的密碼了嗎') 
@section('css')
	<link rel="stylesheet" href = "{{ asset('css/app.css') }}">
@endsection
@section('content')

<div class="container">
	<div class="block">
		<h3>忘記您的密碼了嗎？</h3>

		{!! Form::open(['method'=>'POST', 'url'=> '/password/reset']) !!} {!! csrf_field() !!}

		<div class="form-group">
			{!! Form::label('E-mail 地址: ', null, ['class' => 'label']) !!}
			{!! Form::email('email') !!}
		</div>

		<div class="form-group">
			{!! Form::label('使用者名子: ', null, ['class' => 'label']) !!}
			{!! Form::text('name'); !!}
		</div>


		<div class="form-group submit-group">
			<button type="submit" class="btn">確認</button>
			<a class="link" href="{{ url('/') }}">Home</a>
		</div>

		{!! Form::close() !!} 
		@include('includes.form_errors') 
		@include('includes.message')
	</div>
</div>
@endsection