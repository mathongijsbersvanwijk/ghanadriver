@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>How popular is a test?</h3>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-8">
			<b>Name of test</b>
    	</div>
    	<div class="col-sm-4">
			<b>How many times done</b>
    	</div>
    </div>
    <hr/>
    @foreach($lcutr as $cutr)
    <div class="row">
    	<div class="col-sm-8">
			{!! $cutr->getDesc() !!} (created by {{ $cutr->getName() }} )
			
    	</div>
    	<div class="col-sm-4">
			{!! $cutr->getTotal() !!}
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
</div>
@endsection

