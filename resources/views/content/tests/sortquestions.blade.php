@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
    <div class="col-sm-12">
        <h5>Sort your questions</h5>
    </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <form action="{{ route('tests.store') }}" method="post">
    <div id="draggablePanelList" class="">
    @csrf
    @foreach($ldqchosen as $dq)
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    @php ($photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName())
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="col-sm-12">
               	<img class="img-fluid" src="/storage/thumb/{!! $photoFileName !!}" />&nbsp;&nbsp;&nbsp;{!! $asked !!}
            </div>
    	</div>
	    <div class="panel-body">&nbsp;</div>
    </div>
    @endforeach
    </div>
    <button type="submit" id="submit" class="btn btn-primary">Save</button>
	</form>
    </div><!--end col-->
  </div><!--end row-->
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
});
</script>
@endsection

