@extends('layouts.app-2-colums')

@section('content')
@inject('qs', 'App\Services\QuestionService')

@php if ($utq == null) return; @endphp	
@php ($dq = $utq->loadQuestion($qs))

<audio id="correctSound" src="/mp3/correct.mp3" preload="auto"></audio>
<audio id="wrongSound" src="/mp3/wrong.mp3" preload="auto"></audio>
<audio id="endTimerSound" src="/mp3/endtimer.mp3" preload="auto"></audio>

<script>
var altIdAnswer = 0;
var altCorrect = 0;
var altCorrectValues = [{!! $utq->isAlternativeCorrect(1) !!}, {!! $utq->isAlternativeCorrect(2) !!}, {!! $utq->isAlternativeCorrect(3) !!}, {!! $utq->isAlternativeCorrect(4) !!}];

function doAnswerQuestion(alt) {
	altIdAnswer = alt;
	altCorrect = altCorrectValues[alt-1];
	if (altCorrect == 1) {
		$('#feedback').removeClass('zebra-fault').addClass('zebra-success');
		$('#feedback').text("CORRECT");
		document.getElementById('correctSound').play();
	} else {
		$('#feedback').removeClass('zebra-success').addClass('zebra-fault');
		$('#feedback').text("NOT CORRECT");
		document.getElementById('wrongSound').play();
	}
}
</script>

<div class="container">
	@php ($qt = $dq->getDisplayQuestionAsked()->getQuestionText())
	@if ($qt != null)
		<h2>{!! $utq->getQuestion()->getQueId() !!}. {!! $qt->getTekContents() !!}</h2> 
		<br/>
	@endif
	@php ($qi = $dq->getDisplayQuestionAsked()->getQuestionImage())
	@if ($qi != null)
		<div class="image-container"><img class="img-fluid" src="/storage/img/{!! $qi->getGrfFileName() !!}" /></div>
		<div class="zebra-image-bottom"></div>
	@endif

	<form method="post" name="fm">
		@csrf
		<input name="tquId" id="tquId" type="hidden" />
		<input name="altId" id="altId" type="hidden" />
		<input name="op" id="op" type="hidden" />
		@if ($utq->getAnswerResourceType() == App\Support\Helpers\WebConstants::ANSWER_RESOURCE_TYPE_TEXT) 
		    <ul class="text-alternatives">
			@php ($ldqalt = $dq->getListDisplayQuestionAlternative())
			@foreach ($ldqalt as $dqa) 
				@php ($qtt = $dqa->getQuestionText())
				@if ($qtt != null)
					<li>
						<a href="javascript:doAnswerQuestion('{!! $dqa->getAltId() !!}');">
							<strong class="abcdWrapper">
								<span class="abcd">
								{!! $dqa->getAltId() == 1 ? "A" : "" !!}
								{!! $dqa->getAltId() == 2 ? "B" : "" !!}
								{!! $dqa->getAltId() == 3 ? "C" : "" !!}
								{!! $dqa->getAltId() == 4 ? "D" : "" !!}
								</span>
							</strong>
							<span class="zebra-answer">{!! $qtt->getTekContents() !!}</span>
						</a>
					</li>
				@endif
			@endforeach
		    </ul>
		@else
		    <div id="features" class="clearfix">
			@php ($ldqalt = $dq->getListDisplayQuestionAlternative())
			@foreach ($ldqalt as $dqa) 
				@php ($qii = $dqa->getQuestionImage())
				@if ($qii != null)
			      	@if ((sizeof($ldqalt) % 3) == 0)
						@php ($css_last = " last")
					@else
						@php ($css_last = "")
			      	@endif
			      	<div class="feature{!! $css_last !!}">
						<strong class="abcdWrapper">
							<span class="abcd">
							{!! $dqa->getAltId() == 1 ? "A" : "" !!}
							{!! $dqa->getAltId() == 2 ? "B" : "" !!}
							{!! $dqa->getAltId() == 3 ? "C" : "" !!}
							{!! $dqa->getAltId() == 4 ? "D" : "" !!}
							</span>
						</strong>
			      		<div class="feature-image">  		 
							<a href="javascript:doAnswerQuestion('{!! $dqa->getAltId() !!}');">
								<img class="img-fluid" src="/storage/img/{!! $qii->getGrfFileName() !!}" />
							</a>	
						</div>
					</div>
		      	@endif
			@endforeach
			</div> 
	   	@endif
	
	</form>
	<br/>
	<div id="feedback"></div>

    @isset($que) 
	<br/>
	<form action="{{ route('admin.questions.updatestatus') }}" method="post">
		@csrf
		<input type="hidden" id="id" name="id" value="{!! $que->id !!}" >
		<h3>{{ $que->reason }}</h3>
		<div class="form-group row">
			<label for="status" class="col-sm-2 col-form-label">Status</label>
			<div class="col-sm-10">
                <input class="@error('status') is-invalid @enderror" type="radio" name="status" id="none" 
                	value="" style="display:none" {{ old('status') ? 'checked' : ''}} />
				@foreach (App\Support\Constants::QUESTION_STATUS as $qst) 
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
                          	name="status" id="{{ $qst }}" value="{{ $qst }}" {{ $qst == $que->status ? 'checked' : ''}} />
                        <label class="form-check-label" for="{{ $qst }}">{{ $qst }}</label>
                    </div>
				@endforeach
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
		</div>
		<div class="form-group row">
			<label for="reason" class="col-sm-2 col-form-label">Reason</label>
			<div class="col-sm-10">
				<textarea class="form-control" id="reason" name="reason" rows="2">{{ $que->reason }}</textarea>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Save</button>
	</form>
    @endisset
</div>

@endsection
