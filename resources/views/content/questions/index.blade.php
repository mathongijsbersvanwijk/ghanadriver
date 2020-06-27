@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h5>Your own questions</h5>
        </div>
    </div>
    @foreach($ldq as $dq)
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    @php ($photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName())
    <div class="row">
    	<div class="col-sm-2 gdtip">
    		<a href="/questions/{!! $dq->getQueId() !!}/editphoto">
        	   	<img class="img-fluid" src="/storage/thumb/{!! $photoFileName !!}" />
  				<span class="gdtiptext">Change</span>
    		</a>
    	</div>
    	<div class="col-sm-8 gdtip">
    		<a href="/z/render/{!! $dq->getQueId() !!}/5" alt="Check your question" title="Check your question">
	       	   	<p style="margin-top: 5px">{!! $asked !!}</p>
  			</a>
    	</div>
    	<div class="col-sm-2 gdtip">
		    <a class="btn btn-primary" href="/questions/{!! $dq->getQueId() !!}/edittext" role="button">Edit text</a>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
    <a class="btn btn-primary" href="{{ route('questions.create') }}" role="button">Create your own question</a>
</div>
@endsection

