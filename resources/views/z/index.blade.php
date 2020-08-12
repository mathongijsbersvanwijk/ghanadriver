@extends('layouts.app-2-colums')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- test responsive -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-5116872999998695"
                 data-ad-slot="6762554889"
                 data-ad-format="auto"
                 data-adtest = "on"
                 data-full-width-responsive="true"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="col-md-9">
        	<h1>How is your knowledge of traffic rules and road signs?</h1>
        	<p>To get your drivers license you need your DVLA theory examination first! The tests offered here help you in training for it. There is also an online summary of the Ghana Highway Code, on which the test questions are based. We have more than 350 questions available now!</p>
        	<p>A test contains 10 multiple choice questions, all DVLA compliant. You need to answer 9 questions correctly to succeed. Do you like to try a training or an examination?</p>
        	<div class="row">
        		<div class="col-sm-6">
        			<form name="fm1" method="post" action="/z/start" class="form-horizontal">
        					@csrf
        					<input type="hidden" name="tstId" value="3">
        					<input type="hidden" name="op" value="2">
        					<input type="hidden" name="mode" value="1">
        					<input type="submit" value="Start training" class="btn btn-primary">
        			</form>
        			<p>Feedback is given, click for next question (or previous), GHC summary is available</p>
        			<form name="fm2" method="post" action="/z/start" class="horizontal nel">
        					@csrf
        					<input type="hidden" name="tstId" value="3">
        					<input type="hidden" name="op" value="2">
        					<input type="hidden" name="mode" value="2">
        					<input type="submit" value="Start examination" class="btn btn-primary">
        			</form>
        			<p>Timer gives 20 sec to answer, next question is shown automatically, NO GHC summary</p>
        		</div>
        		<div class="col-sm-6">
        			@php ($carindex = rand(0, 2))
        			@switch($carindex)
        			    @case(0)
        					<img class="img-fluid" src="/art/redcar.jpg" alt=""/>
        			        @break
        			    @case(1)
        					<img class="img-fluid" src="/art/greencar.jpg" alt=""/>
        			        @break
        			    @case(2)
        					<img class="img-fluid" src="/art/yellowcar.jpg" alt=""/>
        			        @break
        			    @default
        			        <span>Something went wrong, please try again</span>
        			@endswitch
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-sm-12">
					<div class="fb-like" data-href="http://ghanadriver.com" data-width="" data-layout="standard" data-action="like" data-size="large" data-share="true"></div>
	        	</div>
        	</div>
        </div>
    </div>
</div>
@endsection

@section('nav-ridehailing')
<div class="card">
    <div class="card-body">
        <a class="nav-link" href="/ridehailing">
			<h6>Ride hailing and sharing</h6>
			<img class="img-fluid" src="/vendor/landing-page/img/ridehailing.jpg" href="/ridehailing" alt=""/>
        </a>
    </div>
</div>
@endsection
