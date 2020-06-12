@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h5>Create your own question</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <form id="fm" name="fm" role="form" action="{{ route('questions.store') }}" enctype="multipart/form-data" method="post" autocomplete="off">
            <div class="form-group row">
                <div class="dropzone" id="photo" name="photo"></div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">Pose the question you want to ask about this photo</div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <input class="form-control @error('asked') is-invalid @enderror" type="text" 
                        id="asked" name="asked" value="{{ old('asked', '') }}" placeholder="for example: Is it allowed to park here?">
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
                            <input type="radio" name="iscorrect" aria-label="Radio button for following text input" checked="checked">
                        </div>
                    </div>
                    <input class="form-control" name="alternative" type="text" placeholder="for example: Yes" />
                    <span class="input-group-btn">
                        <button class="btn btn-success btn-add" type="button">
                            <span class="fa fa-plus"></span>
                        </button>
                    </span>
	                <!-- span class="invalid-feedback alternative-feedback" role="alert"></span -->
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Save</button>
        </form>
        </div>
    </div>
</div>
@endsection

@section('dzscript')
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
        document.getElementById("submit").addEventListener("click", function(e) {
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
                    if (file.width < 640 || file.height < 480) {
	                    file.rejectDimensions();
                    } else {
    	                file.acceptDimensions();
                    }
    		    }
        	}
        });
        
        // send all the form data along with the files:
        this.on("sending", function(data, xhr, formData) {
            var form = JSON.stringify($("#fm").serializeArray());
            formData.append("fm", form);
            //formData.append("asked", jQuery("#asked").val());
        });

        this.on('success', function() {
        	window.location.href = '/questions/check';
        });
    },
    accept: function(file, done) {
        file.acceptDimensions = done;
        file.rejectDimensions = function() {
          done('The image must be at least 640px x 480px')
        };
        file.toobig = function(max) {
        	done("File is too big " + file.size / 1000 + "KB, max filesize is " + max + " KB")
        };
    }
}
function formIsValid() {
	alert("not valid for now");
	return false;
}
</script>
@endsection

@section('script')
<script>
$(function() {
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();
      
        var controlForm = $('.controls'),
	        currentEntry = $(this).parents('.entry:first'),
    	    newEntry = $(currentEntry.clone()).appendTo(controlForm);

        alert(controlForm.children().length);
        
        newEntry.find('input').val('');
        //newEntry.find('button').removeClass('btn-add').addClass('btn-default');
        
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-minus"></span>');

        $('input:radio[name=iscorrect]').each(function () { $(this).prop('checked', false); });
        
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});

    $('#fm input[type="text"]').focus(function(){
        if($(this).val() == "Please enter text"){
            $(this).val("");
        }
    });    

    $('#fm input[type="text"]').blur(function(){
        if(!$(this).val()){
            $(this).val("Please enter text").addClass("input-feedback");
        } else{
            $(this).removeClass("input-feedback");
        }
    });    
});
</script>
@endsection

