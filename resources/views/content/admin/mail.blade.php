<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Question was uploaded, action: {!! $action !!}</h3>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
    		<h4><a href="{{ route('admin.questions.show', ['id' => $id]) }}">Approve or reject question</a></h4>
    	</div>
		@if ($asked != null)
	    	<div class="col-sm-12">
				<p>{!! $id !!}. {!! $asked !!}<p>  				
			</div>
		@endif
		@if ($pathToPhoto != null)
			<div class="col-sm-12">
  			   <img src="{{ $message->embed($pathToPhoto) }}">
			</div>
		@endif
    </div>
</div>
