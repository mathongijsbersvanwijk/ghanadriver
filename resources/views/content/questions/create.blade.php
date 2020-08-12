@extends('layouts.app')

@section('content')
@isset($dq) 
	@php 
		$asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents();
		$photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName();
	@endphp
@endisset
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Create your question</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <form id="fm" name="fm" role="form" action="" enctype="multipart/form-data" method="post" autocomplete="off">
            <div class="form-group row">
                <div class="dropzone" id="photo" name="photo"></div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">Write the question you want to ask about this photo</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input class="form-control" type="text" 
                    	id="asked" name="asked" value="{{ $asked ?? '' }}" placeholder="for example: Is it allowed to park here?">
                    <!-- span class="invalid-feedback asked-feedback" role="alert"></span -->
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">Give the possible multiple choice answers and indicate the correct one with the orange radio-button (press <span class="fa fa-plus gs"></span> to add more options)</div>
            </div>
            <div class="form-group row controls"> 
                <div class="entry input-group col-sm-12">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" name="iscorrect" aria-label="Radio button for following text input" checked>
                        </div>
                    </div>
                    <input class="form-control" type="text" 
                    	name="alternative" value="" placeholder="for example: Yes" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger btn-remove" type="button">
                            <span class="fa fa-minus"></span>
                        </button>
                    </span>
	                <!-- span class="invalid-feedback alternative-feedback" role="alert"></span -->
                </div>
                <div class="entry input-group col-sm-12">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="radio" name="iscorrect" aria-label="Radio button for following text input">
                        </div>
                    </div>
                    <input class="form-control" type="text" 
                    	name="alternative" value="" placeholder="for example: No" />
                    <span class="input-group-btn">
                        <button class="btn btn-success btn-add" type="button">
                            <span class="fa fa-plus"></span>
                        </button>
                    </span>
	                <!-- span class="invalid-feedback alternative-feedback" role="alert"></span -->
                </div>
            </div>
            <div class="form-feedback"><p></p></div>
            <button type="submit" id="submit" class="btn btn-primary">Save and check</button>
        </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script>
Dropzone.prototype.defaultOptions.dictDefaultMessage = "Choose photo";
Dropzone.prototype.defaultOptions.dictRemoveFile = "Remove photo";
Dropzone.options.photo = {
    url: '{{ route('questions.store') }}',
    paramName: 'photo',
    autoProcessQueue: false,
    uploadMultiple: false,
    maxFiles: 1,
    acceptedFiles: 'image/*',
    resizeWidth: 384,
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },    
    init: function() {
        dzClosure = this; // make sure that 'this' is understood inside the functions below.
        
        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById('submit').addEventListener('click', function(e) {
            // make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            if (formIsValid()) {
                dzClosure.processQueue();
            };
        });

        this.on('thumbnail', function(file) {
            if (file.accepted !== false) {
                if (file.size > 100000) {
                    file.toobig(100); 
                } else {                
                    if (file.width < 384 || file.height < 256 || file.size == 0) {
                        file.rejectDimensions();
                    } else {
                        file.acceptDimensions();
                    }
                }
            }
            formFeedback("");
        });

        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
 
        // send all the form data along with the files:
        this.on('sending', function(data, xhr, formData) {
            var form = JSON.stringify($('#fm').serializeArray());
            formData.append('fm', form);
            //formData.append('asked', jQuery('#asked').val());
        });

        this.on('success', function() {
        	window.location.href = '/questions/check';
        });
    },
    accept: function(file, done) {
        file.acceptDimensions = done;
        file.rejectDimensions = function() {
        	done("The image must be at least 640px x 480px")
        };
        file.toobig = function(max) {
        	done("File is too big " + file.size / 1000 + "KB, max filesize is " + max + " KB")
        };
    }
}
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
});
function formIsValid() {
    if ($('#photo').find('.dz-preview').length == 0) {
    	formFeedback("Please choose photo");
		return false;
    }
    	
    if (!$('#asked').val() || $('#asked').val() == "Please enter text") {
    	formFeedback("Please enter text for the question you want to ask");
		return false;
    }

	var alternativeEmpty = false;
	$('input:text[name=alternative]').each(function () {
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
		formFeedback("1 possible answer should be checked as correct");
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
