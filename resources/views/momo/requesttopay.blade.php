@extends('layouts.app-one-col') 

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h5>Some form to submit</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<form action='/momo/requesttopay' method='post'>
			@csrf
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Your name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
				</div>
			</div>
			<div class="form-group row">
				<label for="amount" class="col-sm-2 col-form-label">Amount to
					pay</label>
				<div class="col-sm-10">
					<input type="text" readonly class="form-control-plaintext" id="amount" value="{!! isset($amount) ? $amount : "" !!}">
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Do Payment</button>
		</form>
		</div>
	</div>
</div>
@endsection
