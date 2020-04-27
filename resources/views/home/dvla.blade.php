@extends('layouts.app')

@section('content')
<div class="row-fluid">
	<h1 class="text-center">DVLA Services following here</h1>
</div>

A story here and a DVLA form to fill in

<a class="btn btn-link" href="{{ route('momoDvlaForm') }}">Apply for the service</a>

@endsection
