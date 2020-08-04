@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Your own tests</h3>
        </div>
    </div>
    @foreach($ltst as $tst)
    <div class="row">
    	<div class="col-sm-10">
       	   	{!! $tst->tst_description !!} ({!! $tst->tst_count_tqu !!} questions)
    	</div>
    	<div class="col-sm-2">
		    <a class="btn btn-primary" href="{{ route('tests.edit', ['test' => $tst->id]) }}" role="button">Edit</a>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
    <a class="btn btn-primary" href="{{ route('tests.create') }}" role="button">Create your test</a>
</div>
@endsection

