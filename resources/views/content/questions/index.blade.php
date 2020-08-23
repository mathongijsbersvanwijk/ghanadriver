@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Your own questions</h3>
        </div>
    </div>
	@if (sizeof($ldq) == 0)
    <div class="row">
    	<div class="col-sm-12">
    		<p class="text-info">You do not have any questions yet<p>
	    </div>
    </div>
	@endif
    @foreach($ldq as $dq)
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    @php ($qi = $dq->getDisplayQuestionAsked()->getQuestionImage())
    <div class="row">
    	<div class="col-sm-2 gdtip">
        	@if ($qi != null && $qi->getGrfFileName() != null)
        		<a href="/questions/{!! $dq->getQueId() !!}/editphoto">
               	   	<img class="img-fluid" src="/storage/thumb/{!! $qi->getGrfFileName() !!}" 
	               	   	onerror="this.onerror=null;this.src='/storage/thumb/empty.png';"/>
      				<span class="gdtiptext">Change</span>
        		</a>
    		@else
	       	   	<p style="margin-top: 5px">Text only</p>
        	@endif
    	</div>
    	<div class="col-sm-6 gdtip">
       	   	<p style="margin-top: 5px">{!! $asked !!}</p>
    		<!-- a href="/z/render/{!! $dq->getQueId() !!}/5" alt="Check your question" title="Check your question">
	       	   	<p style="margin-top: 5px">{!! $asked !!}</p>
  			</a -->
    	</div>
    	<div class="col-sm-2 gdtip">
       	   	<p style="margin-top: 5px">{!! $dq->getStatus() !!}</p>
    	</div>
    	<div class="col-sm-2 gdtip">
		    <a class="btn btn-primary" href="/questions/{!! $dq->getQueId() !!}/edittext" role="button">Edit text</a>
    	</div>
		<div>&nbsp;</div>
    </div>
	@if ($dq->getStatus() == 'REJECTED')
    <div class="row">
    	<div class="col-sm-12">
            <img align="left" src="/art/error.png" />&nbsp;&nbsp;Reason for rejection: {!! $dq->getReason() !!}
    	</div>
    </div>
	@endif
    @endforeach
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            <img align="left" src="/art/success.png" />&nbsp;&nbsp;When you are done (even one question is fine) you can put your questions in a test <a href="{{ route('tests.index') }}">HERE</a>.
        </div>
    </div>
    <br/>
    <a class="btn btn-primary" href="{{ route('questions.create') }}" role="button">Create your question</a>
</div>
@endsection

