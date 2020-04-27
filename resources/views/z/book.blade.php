@extends('layouts.app-2-colums')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			@switch($art->id)
			    @case(1)
					@include('z.theory.SA')
			        @break
			    @case(2)
					@include('z.theory.SB')
			        @break
			    @case(3)
					@include('z.theory.SC')
			        @break
			    @case(4)
					@include('z.theory.SD')
			        @break
			    @case(5)
					@include('z.theory.SE')
			        @break
			    @case(6)
					@include('z.theory.SF')
			        @break
			    @case(7)
					@include('z.theory.SG')
			        @break
			    @case(8)
					@include('z.theory.SH')
			        @break
			    @case(9)
					@include('z.theory.SI')
			        @break
			    @case(10)
					@include('z.theory.SJ')
			        @break
			    @case(11)
					@include('z.theory.SW')
			        @break
			    @case(12)
					@include('z.theory.SP')
			        @break
			    @case(13)
					@include('z.theory.SM')
			        @break
			    @case(14)
					@include('z.theory.SX')
			        @break
			    @case(15)
					@include('z.theory.C1')
			        @break
			    @case(20)
					@include('z.theory.VERSION2015')
			        @break
			    @default
			        <span>Something went wrong, please try again</span>
			@endswitch
		</div>
	</div>
</div>

@endsection
