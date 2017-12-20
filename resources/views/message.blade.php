@extends('layouts.app')

@section('content')
<h1>Todo yo~</h1>

@if($message)
<div class="alert-danger">
	<h1>{{$message}}</h1>
</div>
@endif


@endsection