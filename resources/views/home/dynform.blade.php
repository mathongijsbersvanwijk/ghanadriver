@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
        <div class="control-group" id="fields">
            <label class="control-label" for="field1">Nice Multiple Form Fields</label>
                <form role="form" action='/dynsubmit' method='post' autocomplete="off">
              		@csrf
		            <div class="dropzone" id="photo" name="photo"></div>
                    <input class="form-control" id="firstname" name="firstname" type="text" />
		            <div class="controls"> 
                        <div class="entry input-group col-xs-3">
                            <input class="form-control" name="fields[]" type="text" placeholder="Type something" />
                        	<span class="input-group-btn">
                                <button class="btn btn-success btn-add" type="button">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </span>
                        </div>
        		    </div>
		            <br>
		            <button type="submit" id="submit" class="btn btn-primary">Go</button>
                </form>
        </div>
	</div>
</div>
<small>Press <span class="fa fa-plus gs"></span> to add another form field :)</small>
@endsection

@section('dzscript')
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script>
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
            formData.append("firstname", jQuery("#firstname").val());
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
