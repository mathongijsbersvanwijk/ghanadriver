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
   			<h3>External transaction id: {!! $transactionId !!}</h3>
    		@if ($momoTransactionId != null)
    			<h3>Success, Momo transaction id: {!! $momoTransactionId !!}</h3>
    		@else
    			<h3>Something went terribly wrong</h3>
    		@endif
    		
    		@if ($result != null)
    			@php print_r($result); @endphp	
    		@else
    			<h3>Something went terribly wrong with the status</h3>
    		@endif
		</div>
	</div>
	<a href="/momo/checkout">To checkout</a>
</div>
@endsection
