@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h5>Checkout</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<form action='/momo/requesttopay' method='post'>
			@csrf
			<div class="form-group row">
				<div class="col-sm-2">Apply for</div>
				<div class="col-sm-10">{{ $dva->name }}</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">License class</div>
				<div class="col-sm-10">{{ $dva->license_class }}</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">DVLA center</div>
				<div class="col-sm-10">{{ $dva->dvla_center }}</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">Service type</div>
				<div class="col-sm-10">{{ $dva->service_type }}</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">Payment option</div>
				<div class="col-sm-10">{{ $dva->payment_option == 'MTN_MOMO' ? 'MTN MoMo' : 'Cash' }}</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">Comments</div>
				<div class="col-sm-10">{{ $dva->comments }}</div>
			</div>
			<hr/>
			<div class="form-group row">
				<div class="col-sm-2"><h3>Amount</h3></div>
				<div class="col-sm-10"><h3>{{ $amount }} GHC</h3></div>
			</div>
			<button type="submit" class="btn btn-primary">Do payment</button>
		</form>
		</div>
	</div>
</div>
@endsection
