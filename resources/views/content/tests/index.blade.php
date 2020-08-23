@extends('layouts.app')

@section('content')
<div class="container">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <h3>Your own tests</h3>
        </div>
    </div>
	@if (sizeof($ltst) == 0)
    <div class="row">
    	<div class="col-sm-12">
    		<p class="text-info">You do not have any tests yet<p>
	    </div>
    </div>
	@endif
    @foreach($ltst as $tst)
    <div class="row">
    	<div class="col-sm-8">
       	   	{!! $tst->tst_description !!} ({!! $tst->tst_count_tqu !!} questions)
    	</div>
    	<div class="col-sm-4 mb-1">
		    <a class="btn btn-primary mb-1 mr-1" href="{{ route('tests.edit', ['test' => $tst->id]) }}" role="button">Edit</a>
		    <a class="btn btn-danger mb-1" href="javascript:deleteTest({!! $tst->id !!})" role="button">Delete ...</a>
    	</div>
    </div>
    <form action="{{ route('tests.destroy', $tst->id) }}" method="POST" id="del-test-{!! $tst->id !!}" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    @endforeach
    <a class="btn btn-primary" href="{{ route('tests.create') }}" role="button">Create your test</a>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
function deleteTest(id){
	Swal.fire({
        title: 'Delete test?',
        text: "Note: your questions will stay!",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#102812',
        confirmButtonText: 'Yes'
	}).then((result) => {
        if (result.value) {
	        document.getElementById('del-test-'+id).submit();
        }
	})
}
</script>
@endsection
