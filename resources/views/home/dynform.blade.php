@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
        <div class="control-group" id="fields">

<form action="/dynsubmit" enctype="multipart/form-data" method="POST">
    <input type="text" id ="firstname" name ="firstname" />
    <input type="text" id ="lastname" name ="lastname" />
    <div class="dropzone" id="photo" name="photo"></div>
    <button type="submit" id="submit-all"> upload </button>
</form>

        </div>
	</div>
</div>
@endsection

@section('dzscript')
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script>
Dropzone.options.photo= {
	    url: '/dynsubmit',
	    paramName: 'photo',
	    autoProcessQueue: false,
	    uploadMultiple: false,
	    parallelUploads: 5,
	    maxFiles: 5,
	    maxFilesize: 1,
	    acceptedFiles: 'image/*',
	    addRemoveLinks: true,
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },    
	    init: function() {
	        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

	        // for Dropzone to process the queue (instead of default form behavior):
	        document.getElementById("submit-all").addEventListener("click", function(e) {
	            // Make sure that the form isn't actually being sent.
	            e.preventDefault();
	            e.stopPropagation();
	            dzClosure.processQueue();
	        });

	        //send all the form data along with the files:
	        this.on("sending", function(data, xhr, formData) {
	            formData.append("firstname", jQuery("#firstname").val());
	            formData.append("lastname", jQuery("#lastname").val());
	        });
	    }
	}</script>
@endsection

@section('dzscript1')
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script>
Dropzone.options.photofff = {
        paramName: 'photo',
        maxFileSize: 2,
        acceptedFiles: '.jpg, .jpeg, .png, .bmp',
    }
</script>
@endsection

