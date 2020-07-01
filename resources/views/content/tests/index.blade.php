@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h5>Your tests</h5>
        </div>
    </div>
    @foreach($ltst as $tst)
    <div class="row">
    	<div class="col-sm-8 gdtip">
    		<a href="/z/render/{!! $tst->id !!}/5" alt="Check your question" title="Check your question">
	       	   	<p style="margin-top: 5px">{!! $tst->tst_description !!}</p>
  			</a>
    	</div>
    	<div class="col-sm-2 gdtip">
		    <a class="btn btn-primary" href="/questions/{!! $tst->question_id !!}/edittext" role="button">Edit text</a>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
    <a class="btn btn-primary" href="{{ route('tests.create') }}" role="button">Create your test</a>
</div>
@endsection

