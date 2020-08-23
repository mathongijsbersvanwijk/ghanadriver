@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Create your own questions and tests, contribute to road safety!</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>Road safety is fundamental to Ghana since the high toll of deaths due to fatal road accidents. Of course drivers need to be familiar with traffic rules and road signs, but most of these accidents are caused by irresponsible behaviour. People drive at breakneck speeds, despite speed bumps, cameras and road speed limit signs.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>To promote road safety, GhanaDriver introduces a new feature. You can now make a picture of any traffic situation you see, good or bad, upload it, add your question for the public about it. May be add more pictures and questions and put them in a test. This test will then be available for the public to do and to give feedback.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>For this you need to login. If you are not registered yet, you can <a href="{{ route('register') }}">Register here</a></p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<img align="left" src="/art/success.png" />&nbsp;&nbsp;Now <a href="{{ route('questions.index') }}">Create your questions</a>
		</div>
	</div>
    <br/>
	<div class="row">
		<div class="col-sm-12">
			<img class="img-fluid" src="/img/dvla.jpg">&nbsp;&nbsp;
			<img class="img-fluid" src="/img/nrsc.jpg">&nbsp;&nbsp;
			<img class="img-fluid" src="/img/nrsa.jpg">
		</div>
	</div>
</div>
@endsection
