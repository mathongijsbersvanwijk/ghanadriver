@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h5>Apply for new driving license</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
		<form action='/momo/checkout' method='get'>
			<input type="hidden" id="name" name="name" value="New Driving License" >
			<!-- div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">Service application</label>
				<div class="col-sm-10">
					<input type="text" class="form-control @error('name') is-invalid @enderror" 
						id="name" name="name" value="{{ old('name', '') }}" placeholder="Enter service app name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
			</div -->
			<div class="form-group row">
				<label for="license_class" class="col-sm-2 col-form-label">License class</label>
				<div class="col-sm-10">
                    <select class="custom-select @error('license_class') is-invalid @enderror" id="license_class" name="license_class">
                        <option value="" {{ old('license_class') ? 'selected' : ''}}>Choose...</option>
						@foreach (App\Support\Constants::LICENSE_CLASS as $lc) 
	                        <option value="{{ $lc }}" {{ $lc == old('license_class') ? 'selected' : ''}}>{!! $lc !!}</option>
						@endforeach
                    </select>
                    @error('license_class')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
			</div>
			<div class="form-group row">
				<label for="dvla_center" class="col-sm-2 col-form-label">DVLA center</label>
				<div class="col-sm-10">
                    <select class="custom-select @error('dvla_center') is-invalid @enderror" id="dvla_center" name="dvla_center">
                        <option value="" {{ old('dvla_center') ? 'selected' : ''}}>Choose...</option>
						@foreach (App\Support\Constants::DVLA_CENTER as $dc) 
	                        <option value="{{ $dc }}" {{ $dc == old('dvla_center') ? 'selected' : ''}}>{!! $dc !!}</option>
						@endforeach
                    </select>
                    @error('dvla_center')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
			</div>
			<div class="form-group row">
				<label for="service_type" class="col-sm-2 col-form-label">Service type</label>
				<div class="col-sm-10">
                    <input class="@error('service_type') is-invalid @enderror" type="radio" name="service_type" id="none" 
                    	value="" style="display:none" {{ old('service_type') ? 'checked' : ''}} />
					@foreach (App\Support\Constants::SERVICE_TYPE as $st) 
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('service_type') is-invalid @enderror" type="radio" 
                              	name="service_type" id="{{ $st }}" value="{{ $st }}" {{ $st == old('service_type') ? 'checked' : ''}} />
                            <label class="form-check-label" for="{{ $st }}">{{ $st }}</label>
                        </div>
					@endforeach
                    @error('service_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
			</div>
			<div class="form-group row">
				<label for="payment_option" class="col-sm-2 col-form-label">Payment option</label>
				<div class="col-sm-10">
                    <input class="@error('payment_option') is-invalid @enderror" type="radio" name="payment_option" id="none" 
                    	value="" style="display:none" {{ old('payment_option') ? 'checked' : ''}} />
					@foreach (App\Support\Constants::PAYMENT_OPTION as $po) 
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('payment_option') is-invalid @enderror" type="radio" 
                              	name="payment_option" id="{{ $po }}" value="{{ $po }}" {{ $po == old('payment_option') ? 'checked' : ''}} />
                            <label class="form-check-label" for="{{ $po }}">{{ $po == 'MTN_MOMO' ? 'MTN MoMo' : 'Cash' }}</label>
                        </div>
					@endforeach
                    @error('payment_option')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
			</div>
			<div class="form-group row">
				<label for="comments" class="col-sm-2 col-form-label">Comments</label>
				<div class="col-sm-10">
					<textarea class="form-control" id="comments" name="comments" rows="2"></textarea>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Go to checkout</button>
		</form>
		</div>
	</div>
</div>
@endsection
