@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h5>Filter questions on status</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<select id="status" name="status">
                <option value="">all</option>
                <option>UPLOADED</option>
                <option>APPROVED</option>
                <option>REJECTED</option>
            </select>
			<hr/>
        </div>
    </div>
    @foreach($ldq as $dq)
    @php ($asked = $dq->getDisplayQuestionAsked()->getQuestionText()->getTekContents())
    <div class="row">
    	<div class="col-sm-8 gdtip">
    		<a href="/z/render/{!! $dq->getQueId() !!}/5" alt="Check your question" title="Check your question">
	       	   	<p style="margin-top: 5px">{!! $asked !!}</p>
  			</a>
    	</div>
    	<div class="col-sm-2">{!! $dq->getStatus() !!}</div>

		<div>&nbsp;</div>
    </div>
    @endforeach
</div>
@endsection

@section('script')
<script>
$(function() {
	document.getElementById("status").value = '{{ $status }}'; 
	
	$("#status").on('change', function(){
	    var val = $(this).val();
	    if (val == 'all') {
			window.location.href = '/admin/questions/index';
	    } else {
			window.location.href = '/admin/questions/index/' + val;
	    }
	});
});
</script>
@endsection

