@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
    <div class="col-sm-12">
        <h3>Sort the questions in your test</h3>
    </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <form action="{{ $id == 0 ? route('tests.store') : route('tests.update', ['test' => $id]) }}" method="post">
    <div id="sortable" class="ui-sortable collection">   
    @csrf
	<input name="id" type="hidden" value="{!! $id !!}" />
	@if ($id > 0)
		<input type="hidden" name="_method" value="put">
	@endif
	<div class="form-group row">
		<div class="col-sm-12">
			<h4>"{!! $desc !!}"</h4>
		</div>
	</div>
	<input type="hidden" name="desc" value="{!! $desc !!}">
    <div class="row">
        <div class="col-sm-12">
            <h5>Click a question, then drag and drop it downward or upward</h5>
        </div>
    </div>
    @foreach($ldqchosen as $dq)
    @php ($dqid = $dq->getId())
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    @php ($photoFileName = $dq->getDisplayQuestionAsked()->getQuestionImage()->getGrfFileName())
    <div class="row">
        <div class="ui-state-default ui-sortable-handle col-sm-12 mb-2">
    		<input name="dqids[]" type="hidden" value="{!! $dqid !!}" />
    		<img class="img-fluid" src="/storage/thumb/{!! $photoFileName !!}" />&nbsp;&nbsp;&nbsp;{!! $asked !!}
        </div>
    </div>
    @endforeach
    </div>
    <button type="submit" id="submit" class="btn btn-primary">Save</button>
	</form>
  </div>
</div>
</div>
@endsection

@section('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js'></script>
<script>
$(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
});
</script>
@endsection
