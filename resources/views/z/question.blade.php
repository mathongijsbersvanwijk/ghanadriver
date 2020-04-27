@extends('layouts.app-2-colums')

@section('content')
@inject('qs', 'App\Services\QuestionService')

@if ($ut == null || $utq == null)
	<h1>Your session has expired, please </h1><a href="/testyourself">Start again</a>
@endif
@php if ($ut == null || $utq == null) return; @endphp	
@php ($dq = $utq->loadQuestion($qs))

<audio id="correctSound" src="/mp3/correct.mp3" preload="auto"></audio>
<audio id="wrongSound" src="/mp3/wrong.mp3" preload="auto"></audio>
<audio id="endTimerSound" src="/mp3/endtimer.mp3" preload="auto"></audio>

<script>
var altIdAnswer = 0;
var altCorrect = 0;
var altCorrectValues = [{!! $utq->isAlternativeCorrect(1) !!}, {!! $utq->isAlternativeCorrect(2) !!}, {!! $utq->isAlternativeCorrect(3) !!}, {!! $utq->isAlternativeCorrect(4) !!}];

function submitAnswerAndProceed(tquId, op) {
	fm.tquId.value = tquId;
	fm.altId.value = altIdAnswer;
	fm.op.value = op;
    fm.action = '/z/question';
	fm.submit();
}
function doAnswerQuestion(alt) {
	altIdAnswer = alt;
	altCorrect = altCorrectValues[alt-1];
	@if ($ut->getMode() == App\Support\Helpers\WebConstants::TIMED_QUESTION_MODE) 
		$('#feedback').show();
		$('#feedback').text("Answer submitted");
		$('#feedback').hide(1500);
	@else
		if (altCorrect == 1) {
			$('#feedback').removeClass('zebra-fault').addClass('zebra-success');
			$('#feedback').text("CORRECT");
			document.getElementById('correctSound').play();
		} else {
			$('#feedback').removeClass('zebra-success').addClass('zebra-fault');
			$('#feedback').text("NOT CORRECT");
			document.getElementById('wrongSound').play();
		}
	@endif
}
</script>

@if ($ut->getMode() == App\Support\Helpers\WebConstants::TIMED_QUESTION_MODE)
<script>
$(function(){
	var pb = $("#pb");
	pb.height(30);
	
	pb.progressbar({
		value: 999,
		max: 1000,
		change: function() {
		},
		complete: function() { 
			document.getElementById('endTimerSound').play();
			submitAnswerAndProceed({!! $ut->getCurrentTquId() !!}, {!! App\Support\Helpers\WebConstants::NEXT_QUESTION !!});
		}
	});
	function progress() {
		var val = pb.progressbar("value");
		var count = 1000 - val;

		pb.progressbar("value", val - 1);
		
		if (count < 1000) {
			setTimeout(progress, 10);
		} else {
			pb.progressbar("disable");
			pb.progressbar("value", 1000);
		}
	}
	$("#stopbutton").click(function(){
		submitAnswerAndProceed({!! $ut->getCurrentTquId() !!}, {!! App\Support\Helpers\WebConstants::STOP_TEST !!});
	});
	setTimeout(progress, 200); // offset
});
</script>
@else
<script>
$(function(){
	$("#prevbutton").click(function(){
		submitAnswerAndProceed({!! $ut->getCurrentTquId() !!}, {!! App\Support\Helpers\WebConstants::PREVIOUS_QUESTION !!});
	});
	$("#nextbutton").click(function(){
		submitAnswerAndProceed({!! $ut->getCurrentTquId() !!}, {!! App\Support\Helpers\WebConstants::NEXT_QUESTION !!});
	});
	$("#stopbutton").click(function(){
		submitAnswerAndProceed({!! $ut->getCurrentTquId() !!}, {!! App\Support\Helpers\WebConstants::STOP_TEST !!});
	});
	$("#guidebutton").click(function(){
		fmg.submit();
	});
});
</script>
@endif

<div class="container">
	@if ($ut->getMode() == App\Support\Helpers\WebConstants::TIMED_QUESTION_MODE)
		<div id="pb" ></div>
		<br/>
	@endif
	
	@php ($qt = $dq->getDisplayQuestionAsked()->getQuestionText())
	@if ($qt != null)
		<h2>{!! $ut->getCurrentTquId() !!}. {!! $qt->getTekContents() !!}</h2> 
		<br/>
	@endif
	@php ($qi = $dq->getDisplayQuestionAsked()->getQuestionImage())
	@if ($qi != null)
		<div class="image-container"><img class="img-fluid" src="/img/{!! $qi->getGrfFileName() !!}" /></div>
		<div class="zebra-image-bottom"></div>
	@endif

	<form method="post" name="fm">
		@csrf
		<input name="tquId" id="tquId" type="hidden" value="{!! $ut->getCurrentTquId() !!}" />
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
								<img class="img-fluid" src="/img/{!! $qii->getGrfFileName() !!}" />
							</a>	
						</div>
					</div>
		      	@endif
			@endforeach
			</div> 
	   	@endif
	
		@if ($ut->getMode() == App\Support\Helpers\WebConstants::SELF_PACED_MODE)
			@if (($ut->whereInTest() & App\Support\Helpers\WebConstants::BEGIN_OF_TEST) != App\Support\Helpers\WebConstants::BEGIN_OF_TEST)
				<input id="prevbutton" type="button" value="Previous" class="btn btn-primary" />
	     	@endif
			@if (($ut->whereInTest() & App\Support\Helpers\WebConstants::END_OF_TEST) != App\Support\Helpers\WebConstants::END_OF_TEST)
				<input id="nextbutton" type="button" value="Next" class="btn btn-primary" />
	     	@endif
	    @endif
		@if ($ut->getMode() == App\Support\Helpers\WebConstants::SELF_PACED_MODE) 
			@php ($title = App::make('articles')->getByTitle($dq->getCategoryTitle())->first()->title)
			<a id="guidebutton" class="btn btn-primary" href="/z/book/{!! $title !!}" role="button">Guide</a>
	   	@endif
		<input id="stopbutton" type="button" value="Stop" class="btn btn-primary" />
	</form>
	<br/>
		
	<div id="feedback"></div>
</div>

@endsection
