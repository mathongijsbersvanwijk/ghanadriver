@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Filter tests on status</h3>
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
    @foreach($ltst as $tst)
    <div class="row">
    	<div class="col-sm-8">
    		<a href="/z/render/{!! $tst->id !!}/5" alt="Check your question" title="Check your question">
	       	   	{!! $tst->tst_description !!}
  			</a>
    	</div>
    	<div class="col-sm-2">{!! $tst->status !!}</div>
    	<div class="col-sm-2">
		    <a class="btn btn-primary" href="{{ route('tests.edit', ['test' => $tst->id]) }}" role="button">Edit</a>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
    <a class="btn btn-primary" href="{{ route('tests.create') }}" role="button">Create your test</a>
</div>
@endsection

@section('script')
<script>
$(function() {
	document.getElementById("status").value = '{{ $status }}'; 
	
	$("#status").on('change', function(){
	    var val = $(this).val();
	    if (val == 'all') {
			window.location.href = '/admin/tests/index';
	    } else {
			window.location.href = '/admin/tests/index/' + val;
	    }
	});
});
</script>
@endsection

