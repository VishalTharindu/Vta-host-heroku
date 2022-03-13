@extends('layouts.app', ['title' => __('Training Institute Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add New Training Institute')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Training Institute Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('trainingInstitute.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('trainingInstitute.update',$trainingInstitute) }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('Training Institute information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-year">{{ __('Company Name') }}</label>
                                <input type="text" name="name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Company Name') }}" value="{{ $trainingInstitute->name }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-address">{{ __('Company Address') }}</label>
                                <input type="text" name="address" id="input-address"
                                    class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Enter the address seperating from commas') }}" value="{{ $trainingInstitute->address }}" required autofocus>
                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-address">{{ __('Company Contact No') }}</label>
                                <input type="text" name="phone_no" id="input-address"
                                    class="form-control form-control-alternative{{ $errors->has('phone_no') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Enter the phone number') }}" value="{{ $trainingInstitute->phone_no }}" required autofocus>
                                @if ($errors->has('phone_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection