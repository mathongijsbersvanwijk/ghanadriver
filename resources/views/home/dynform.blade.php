@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
        <div class="control-group" id="fields">
            <label class="control-label" for="field1">Nice Multiple Form Fields</label>
                <form role="form" action='/dynsubmit' method='post' autocomplete="off">
              		@csrf
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
                    <button type="submit" class="btn btn-primary">Go</button>
                </form>
        </div>
	</div>
</div>
<small>Press <span class="fa fa-plus gs"></span> to add another form field :)</small>

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
