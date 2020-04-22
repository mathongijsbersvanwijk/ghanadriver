@extends('layout.general')
@section('general')

<h2>Index</h2>

@include('common.articlelistcatpag')

<hr/>

<h2>Latest 20 articles of all categories sorted by date</h2>

@include('common.articlelistage')

@endsection

@section('demo')
	<br/>
	2 views are shown here: 
	<ul>
	<li>common.articlelistcatpag (articles of category 'general' with standard paging implemented)</li>
	<li>common.articlelistage (latest 20 articles of all categories)</li>
	</ul>
@endsection
