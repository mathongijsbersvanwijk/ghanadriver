@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Results</h3>
        </div>
    </div>
    @foreach($lcutr as $cutr)
    <div class="row">
    	<div class="col-sm-8">
			{!! $cutr->getDesc() !!}
    	</div>
    	<div class="col-sm-4">
			{!! $cutr->getTotal() !!}
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
</div>
@endsection

