@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Available tests</h3>
        </div>
    </div>
    @foreach($ltst as $tst)
    <div class="row">
    	<div class="col-sm-8">
       	   	{!! $tst->tst_description !!} ({!! $tst->questions_count !!} questions)
    	</div>
    	<div class="col-sm-2">
		    <a class="btn btn-primary m-1" href="{{ route('tests.edit', ['test' => $tst->id]) }}" role="button">Start training</a>
    	</div>
    	<div class="col-sm-2">
		    <a class="btn btn-primary m-1" href="{{ route('tests.edit', ['test' => $tst->id]) }}" role="button">Start examination</a>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
</div>
@endsection

