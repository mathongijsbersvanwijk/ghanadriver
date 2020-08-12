@extends('layouts.app')

@section('content')
@isset($dq) 
	@php 
		$asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents();
		$askedmedid = $dq->getDisplayQuestionAsked()->getQuestionText()->getMedId();
		$photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName();
		$ldqalt = $dq->getListDisplayQuestionAlternative();
	@endphp
@endisset
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Update your question text or possible answers below</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <form id="fm" name="fm" role="form" action="{{ route('questions.updatetext') }}" method="post" autocomplete="off">
			@csrf
			<input type="hidden" name="queid" value="{{ $dq->getQueId() ?? '' }}" >
            <div class="form-group row">
                <div class="col-sm-12"><img class="img-fluid" src="/storage/img/{!! $photoFileName !!}"/></div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">Write the question you want to ask about this photo</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
					<input type="hidden" name="askedmedid" value="{!! $askedmedid !!}">
                    <input class="form-control" type="text" 
                    	id="asked" name="asked" value="{{ $asked ?? '' }}" placeholder="for example: Is it allowed to park here?">
                    <!-- span class="invalid-feedback asked-feedback" role="alert"></span -->
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">Give the possible multiple choice answers and indicate the correct one with the orange radio-button (press <span class="fa fa-plus gs"></span> to add more options)</div>
            </div>
            <div class="form-group row controls">
   				@php ($i = 0)
    			@foreach ($ldqalt as $dqa) 
    				@php ($qtt = $dqa->getQuestionText())
    				@if ($qtt != null)
                        <div class="entry input-group col-sm-12">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="iscorrect" value="{!! $i !!}" aria-label="Radio button for following text input" {!! $dqa->isCorrect() ? "checked" : "" !!}>
                                </div>
                            </div>
							<input type="hidden" name="alternativemedid[]" value="{!! $qtt->getMedId() !!}">
                            <input class="form-control" type="text" 
                            	name="alternative[]" value="{!! $qtt->getTekContents() !!}" placeholder="for example: Yes" />
                            <span class="input-group-btn">
			    				@if ($i < sizeof($ldqalt) - 1)
                                <button class="btn btn-danger btn-remove" type="button">
                                    <span class="fa fa-minus"></span>
                                </button>
                                @else
                                <button class="btn btn-success btn-add" type="button">
                                    <span class="fa fa-plus"></span>
                                </button>
                                @endif
                            </span>
        	                <!-- span class="invalid-feedback alternative-feedback" role="alert"></span -->
                        </div>
    				@endif
			        @php ($i++)
    			@endforeach
            </div>
            <div class="form-feedback"><p></p></div>
            <button type="submit" id="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(function() {
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();

    	var countAlt = $('.controls').children().length;
    	if (countAlt > 3) { 
    		formFeedback("Number of possible answers should not be more than 4");
    		return false;
    	}		
        
        var controlForm = $('.controls'),
	        currentEntry = $(this).parents('.entry:first'),
    	    newEntry = $(currentEntry.clone(true)).appendTo(controlForm);

        newEntry.find('input').val('');
        newEntry.find('input:radio[name=iscorrect]').val(countAlt - 1);
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-minus"></span>');

        $('input:radio[name=iscorrect]').each(function () { $(this).prop('checked', false); });
        formFeedback("");
        
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
	    formFeedback("");
		return false;
	});

    $('#fm input[type="text"]').focus(function() {
        if($(this).val() == "Please enter text") {
            $(this).val('');
        }
	    formFeedback("");
    });    

    $('#fm input[type="text"]').blur(function() {
        if(!$(this).val()) {
            $(this).val("Please enter text").addClass('input-feedback');
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
    if (!$('#asked').val() || $('#asked').val() == "Please enter text") {
    	formFeedback("Please enter text for the question you want to ask");
		return false;
    }

	var alternativeEmpty = false;
	$("input:text[name='alternative[]']").each(function () {
	    if (!$(this).val() || $(this).val() == "Please enter text") {
		    alternativeEmpty = true;
			return false;
		}	 
    });
	if (alternativeEmpty) {
		formFeedback("Please enter text for possible answer");
		return false;
	}		

	var radioButtonChecked = false;
	$('input:radio[name=iscorrect]').each(function () {
		if ($(this).prop('checked')) {
			radioButtonChecked = true; 
		}	 
    });
	if (!radioButtonChecked) {
		formFeedback("1 possible answer should be chosen as correct");
		return false;
	}		

	var countAlt = $('.controls').children().length;
	if (countAlt < 2) { 
		formFeedback("Number of possible answers should be at least 2");
		return false;
	}		
	if (countAlt > 4) { 
		formFeedback("Number of possible answers should not be more than 4");
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
