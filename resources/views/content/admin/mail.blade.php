<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h3>Question was uploaded, action: {!! $action !!}</h3>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
    		<h4><a href="{{ route('admin.questions.show', ['id' => $id]) }}">See the question</a></h4>
    	</div>
    	<div class="col-sm-12">
  			@if ($asked != null)
				{!! $asked !!}  				
  			@else
  			   <img src="{{ $message->embed($pathToPhoto) }}">
  			@endif
    	</div>
    </div>
</div>
