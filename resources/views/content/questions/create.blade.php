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
        <form role="form" action='/dynsubmit' method='post' autocomplete="off">
      		@csrf
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
                    @error('asked')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
			</div>
			<div class="form-group row">
        		<div class="col-sm-12">Give the possible multiple choice answers (press <span class="fa fa-plus gs"></span> to add more options)</div>
			</div>
            <div class="controls"> 
                <div class="form-group row">
    				<div class="entry input-group col-sm-12">
                        <input class="form-control" name="fields[]" type="text" placeholder="for example: Yes" />
                    	<span class="input-group-btn">
                            <button class="btn btn-success btn-add" type="button">
                                <span class="fa fa-plus"></span>
                            </button>
                        </span>
    				</div>
    			</div>

		    </div>
            <button type="submit" id="submit" class="btn btn-primary">Go</button>
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
Dropzone.options.photo= {
	url: '/dynsubmit',
    paramName: 'photo',
    autoProcessQueue: false,
    uploadMultiple: false,
    maxFiles: 1,
    maxFilesize: 1,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },    
    init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("submit").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });

        //send all the form data along with the files:
        dzClosure.on("sending", function(data, xhr, formData) {
            formData.append("asked", jQuery("#asked").val());
        });

        dzClosure.on('complete',function(){
            window.location.href = '/';
        })
    }
}
</script>
@endsection

@section('script')
<script>
$(function() {
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls'),
	        currentEntry = $(this).parents('.entry:first'),
    	    newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
});
</script>
@endsection
