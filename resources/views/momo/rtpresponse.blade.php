@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3>Result</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
   			<h3>External transaction id: {!! $pay->id !!}</h3>
    		@if ($pay->momo_transaction_id  != null)
    			<h3>Success, Momo transaction id: {!! $pay->momo_transaction_id !!}</h3>
    		@else
    			<h3>Something went terribly wrong</h3>
    		@endif
    		<p>{!! $pay->financial_transaction_id !!}</p>
    		<p>{!! $pay->status !!}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h3>Please approve payment request {!! $pay->financial_transaction_id !!} in your MTN Momo Pay</h3>
			<p><a href="/dvla">Back to DVLA Services</a></p>
		</div>
	</div>
</div>
@endsection
