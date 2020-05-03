@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>DVLA Services test</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h5>Under construction: you will be able to apply for a new driving license</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('momoDvlaForm') }}">Apply for the service</a>
		</div>
	</div>
</div>
@endsection
