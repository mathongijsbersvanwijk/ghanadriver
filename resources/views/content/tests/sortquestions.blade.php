@extends('layouts.app')

@section('content')
<div class="container">
  <ul id="draggablePanelList" class="list-unstyled">
      <li class="panel panel-info">
          <div class="panel-heading">You can drag this panel.</div>
          <div class="panel-body">Content here ...</div>
      </li>
      <li class="panel panel-info">
          <div class="panel-heading">You can drag this panel too.</div>
          <div class="panel-body">More content here...</div>
      </li>
      <li class="panel panel-info">
          <div class="panel-heading">You can drag this panel too.</div>
          <div class="panel-body">More blah content here...</div>
      </li>
      <li class="panel panel-info">
          <div class="panel-heading">You can drag this panel too.</div>
          <div class="panel-body">Another content panel here...</div>
      </li>
  </ul>
<div class="row">
  <div class="col-xs-2">
  <div id="draggablePanelList2" class="">
      <div class="panel panel-default">
          <div class="panel-heading">You cand drag this panel.</div>
          <div class="panel-body">Content hedfsre ...</div>
      </div>
      <div class="panel panel-danger">
          <div class="panel-heading">You canfd drag this panel.</div>
          <div class="panel-body">Content hdsfere ...</div>
      </div>
  </div>
    </div><!--end col-->
  </div><!--end row-->
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h5>Your own questions</h5>
        </div>
    </div>
    @foreach($ldq as $dq)
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    @php ($photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName())
    @php ($inc = 1)
    <div class="row">
    	<div class="col-sm-1">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" style="margin-top: 12px" 
                  	name="included" id="{{ $inc }}" value="{{ $inc }}" {{ $inc == old('included') ? 'checked' : ''}} />
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
    <a class="btn btn-primary" href="{{ route('questions.create') }}" role="button">Next</a>
</div>
@endsection

@section('script')
<script>
$(function() {
	  var panelList = $("#draggablePanelList");

	  panelList.sortable({
	    // Only make the .panel-heading child elements support dragging.
	    // Omit this to make then entire <li>...</li> draggable.
	    handle: ".panel-heading",
	    update: function () {
	      $(".panel", panelList).each(function (index, elem) {
	        var $listItem = $(elem),
	          newIndex = $listItem.index();

	        // Persist the new indices.
	      });
	    }
	  });

	  var panelList2 = $("#draggablePanelList2");

	  panelList2.sortable({
	    // Only make the .panel-heading child elements support dragging.
	    // Omit this to make then entire <li>...</li> draggable.
	    handle: ".panel-heading",
	    update: function () {
	      $(".panel", panelList2).each(function (index, elem) {
	        var $listItem = $(elem),
	          newIndex = $listItem.index();

	        // Persist the new indices.
	      });
	    }
	  });
});
</script>
@endsection

