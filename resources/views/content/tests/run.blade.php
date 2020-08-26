@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Available tests</h3>
        </div>
    </div>
    @foreach($ltst as $tst)
    <div class="row">
    	<div class="col-sm-8">
       	   	{!! $tst->tst_description !!} ({!! $tst->tst_count_tqu !!} questions, made by {{ $tst->owner->name }} )
    	</div>
    	<div class="col-sm-2">
			<form method="post" action="/z/start" class="form-horizontal">
					@csrf
					<input type="hidden" name="tstId" value="{!! $tst->id !!}">
					<input type="hidden" name="op" value="1">
					<input type="hidden" name="mode" value="1">
					<input type="submit" value="Start training" class="btn btn-primary m-1">
			</form>
    	</div>
    	<div class="col-sm-2">
			<form method="post" action="/z/start" class="form-horizontal">
					@csrf
					<input type="hidden" name="tstId" value="{!! $tst->id !!}">
					<input type="hidden" name="op" value="1">
					<input type="hidden" name="mode" value="2">
					<input type="submit" value="Start examination" class="btn btn-primary m-1">
			</form>
    	</div>
		<div>&nbsp;</div>
    </div>
    @endforeach
</div>
@endsection

