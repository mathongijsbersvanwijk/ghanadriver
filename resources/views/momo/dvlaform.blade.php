@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h5>Form to fill in here it is</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<form action='/momo/checkout' method='post'>
			@csrf
			<div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Service application</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="name" name="name" placeholder="Enter service app name">
				</div>
			</div>
			<div class="form-group row">
				<label for="license_class" class="col-sm-2 col-form-label">License class</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="license_class" name="license_class" value="345">
				</div>
			</div>
			<div class="form-group row">
				<label for="dvla_center" class="col-sm-2 col-form-label">DVLA center</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="dvla_center" name="dvla_center">
				</div>
			</div>
			<div class="form-group row">
				<label for="service_type" class="col-sm-2 col-form-label">Service type</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="service_type" name="service_type">
				</div>
			</div>
			<div class="form-group row">
				<label for="payment_option" class="col-sm-2 col-form-label">Payment option</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="payment_option" name="payment_option">
				</div>
			</div>
			<div class="form-group row">
				<label for="comments" class="col-sm-2 col-form-label">Comments</label>
				<div class="col-sm-10">
					<textarea class="form-control" id="comments" name="comments" rows="2"></textarea>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Go to checkout</button>
		</form>
		</div>
	</div>
</div>
@endsection
