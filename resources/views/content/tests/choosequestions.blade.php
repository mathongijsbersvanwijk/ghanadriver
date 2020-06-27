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
    @php ($inc = 1)
    <div class="row">
    	<div class="col-sm-1">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" style="margin-top: 12px" 
                  	name="included" id="{{ $inc }}" value="{{ $inc }}" {{ $inc == old('included') ? 'checked' : ''}} />
            </div>
    	</div>
    	<div class="col-sm-2">
       	   	<img class="img-fluid" src="/storage/thumb/{!! $photoFileName !!}" />
    	</div>
    	<div class="col-sm-9 gdtip">
       	   	<p style="margin-top: 5px">{!! $asked !!}</p>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
    <a class="btn btn-primary" href="{{ route('questions.create') }}" role="button">Next</a>
</div>
@endsection

