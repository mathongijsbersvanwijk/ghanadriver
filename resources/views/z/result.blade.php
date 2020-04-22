@extends('layouts.app')

@section('content')
@if ($ut == null)
	<h1>Your session has expired, please </h1><a href="/testyourself">Start again</a>
@endif
@php if ($ut == null) return; @endphp	
@php if ($ut == null) return; @endphp	
@php ($correctAnswers = $ut->getCountAnswers()[0])
@php ($wrongAnswers = $ut->getCountAnswers()[1])

<audio id="successSound" src="/mp3/success.mp3" preload="auto"></audio>
<audio id="failureSound" src="/mp3/failure.mp3" preload="auto"></audio>

<script>
@if ($correctAnswers > 8) {
	document.getElementById('successSound').play();
@else 
	document.getElementById('failureSound').play();
@endif
</script>

<div class="container">
	<div class="{!! $correctAnswers > 8 ? 'success' : 'fault' !!}">
		<h2>{!! $correctAnswers > 8 ? 'Great, you did it!' : 'Sorry, not yet done' !!}</h2>
	</div>

	<div class="row">
		<div class="col-sm-4">
		<table class="zebra-result-summary">
		    <tbody>
		        <tr>
					<td>Answered correctly:</td>
					<td width="20" align="right"><div class="success"><strong>{!! $correctAnswers !!}</strong></div></td>
				</tr>
		        <tr>
					<td>Answered incorrectly:</td>
					<td width="20" align="right"><div class="fault"><strong>{!! $wrongAnswers !!}</strong></div></td>
				</tr>
		        <tr>
					<td>Not answered:</td>
					<td width="20" align="right"><strong>{!! 10 - $correctAnswers - $wrongAnswers !!}</strong></td>
				</tr>
		        <tr>
					<td colspan="2"><hr/></td>
				</tr>
			</tbody>
		</table>
		</div>
		<div class="col-sm-8">
		<table class="zebra-result">
		    <tbody>
		    	@php ($i = 1)
				@php ($lutq = $ut->getUserTestQuestions())
				@foreach ($lutq as $utq) 
					@php ($dqa = $utq->getQuestionAnswer())
			        <tr>
			            <td><a href="/z/render/{!! $i !!}/{!! App\Support\Helpers\WebConstants::THIS_QUESTION !!}">Question {!! $i !!}</a></td>
						@if ($dqa != null)
				            <td>
								@if ($dqa->isCorrect())
						        	<img align="right" src="/art/success.png" />
								@else 
						        	<img align="right" src="/art/error.png" />
								@endif
				            </td>
				            <td>
				            	&nbsp;&nbsp;
								@php ($dq = $utq->getQuestion())
								@php ($title = App::make('articles')->getByTitle($dq->getCategoryTitle())->first()->title)
					        	<a href="/z/book/{!! $title !!}" title="Ghana Highway Code"><img align="right" src="/art/book.png" /></a>
				            </td>
						@else
				            <td>
				            </td>
				            <td>
				            </td>
			            @endif
			        </tr>
			        @php ($i++)
				@endforeach
		    </tbody>
		</table>
		</div>
	</div>

	<div class="row">
		<a id="redofaultsbutton" class="btn btn-primary btn-primary-result" href="/z/restart" role="button">Redo faults</a>
		<a id="redotrainingbutton" class="btn btn-primary btn-primary-result" href="/z/render/0/{!! App\Support\Helpers\WebConstants::REDO_TEST_SELF_PACED !!}" role="button">Redo as training</a>
		<a id="redoexambutton" class="btn btn-primary btn-primary-result" href="/z/render/0/{!! App\Support\Helpers\WebConstants::REDO_TEST_TIMED_QUESTION !!}" role="button">Redo as examination</a>
		<a id="newtestbutton" class="btn btn-primary btn-primary-result" href="/z" role="button">New test</a>
	</div>
</div>
@endsection
