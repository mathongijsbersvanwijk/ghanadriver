@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>{!! isset($test) ? "Edit your test" : "Create your test" !!}</h3>
        </div>
    </div>
	<form id="fm" name="fm" action="{{ route('tests.chosenquestions') }}" method="post">
	@csrf
	<input name="id" type="hidden" value="{!! isset($test) ? $test->id : 0 !!}" />
	<div class="form-group row">
		<label for="desc" class="col-sm-2 col-form-label">Name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" 
				id="desc" name="desc" value="{!! isset($test) ? $test->tst_description : '' !!}" placeholder="for example: Abena's test"/>
		</div>
	</div>
    <div class="row">
        <div class="col-sm-12">
            <h5>Choose questions (only approved are shown) to go into your test</h5>
        </div>
    </div>
	@if (sizeof($ldq) == 0)
    <div class="row">
    	<div class="col-sm-12">
    		<p class="text-info">You do not have any approved questions yet. Upload questions <a href="{{ route('questions.index') }}">HERE</a> or wait for approval<p>
	    </div>
    </div>
	@endif
    @foreach($ldq as $dq)
    @php ($dqid = $dq->getId())
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    @php ($photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName())
	<div class="row">
    	<div class="col-sm-1">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" style="margin-top: 12px" 
                  	name="dqids[]" value="{{ $dqid }}" {{ in_array($dqid, $dqidarr) ? 'checked' : '' }} />
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
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            <img align="left" src="/art/success.png" />&nbsp;&nbsp;So when do people succeed for your test? 
            When no more than 1 question has been answered wrongly. So if your test contains 5 questions, then at least 4 questions must be answered correctly.
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-12">
            <img align="left" src="/art/success.png" />&nbsp;&nbsp;If you need to update a question, go <a href="{{ route('questions.index') }}">HERE</a>.
        </div>
    </div>
    <div class="form-feedback"><p></p></div>
    <button type="submit" class="btn btn-primary">Save and sort</button>
    </form>
</div>
@endsection

@section('script')
<script>
$(function() {
    $('#fm input[type="text"]').focus(function() {
        if($(this).val() == "Please enter a name for your test") {
            $(this).val('');
        }
	    formFeedback("");
    });    

    $('#fm input[type="text"]').blur(function() {
        if(!$(this).val()) {
            $(this).val("Please enter a name for your test").addClass('input-feedback');
        } else{
            $(this).removeClass('input-feedback');
        }
    });    

    $('#fm').submit(function () {
        if (!formIsValid()) {
            return false;
        }
    });
});
function formIsValid() {
    if (!$('#desc').val() || $('#desc').val() == "Please enter a name for your test") {
    	formFeedback("Please enter a name for your test");
		return false;
    }
	
	var atLeastOneIsChecked = $('input:checkbox').is(':checked');
    if (!atLeastOneIsChecked) {
    	formFeedback("At least 1 question should be included");
		return false;
    }

    formFeedback("");
	return true;
}
function formFeedback(message) {
    if (message != "") {
        $('div.form-feedback p').html(message);
        $('div.form-feedback').show();
    } else {
    	$('div.form-feedback').hide();
    }
}
</script>
@endsection


