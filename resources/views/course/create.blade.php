@extends('layouts.app', ['title' => __('Course Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add New Course')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Course Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('course.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All Course') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('course.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('Course information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('course_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-course_name">{{ __('Course Name') }}</label>
                                        <input type="text" name="course_name" id="input-course_name"
                                            class="form-control form-control-alternative{{ $errors->has('course_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Course Name') }}" value="{{ old('course_name') }}"
                                            required autofocus>

                                        @if ($errors->has('course_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('course_duration') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-batch">{{ __('Course Duration') }}</label>
                                        <select name="course_duration" class="form-control" data-toggle="select">
                                            <option value="1">1 Month</option>
                                            <option value="3">3 Month</option>
                                            <option value="6">6 Month</option>
                                            <option value="12">12 Month</option>
                                            <option value="18">18 Month</option>
                                            <option value="24">24 Month</option>
                                        </select>
                                        @if ($errors->has('course_duration'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course_duration') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('registration_fee') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-registration_fee">{{ __('Registration Fee') }}</label>
                                        <input type="text" name="registration_fee" id="input-registration_fee"
                                            class="form-control form-control-alternative{{ $errors->has('registration_fee') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Register Fee') }}" value="{{ old('registration_fee') }}"
                                            required autofocus>

                                        @if ($errors->has('registration_fee'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('registration_fee') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('course_fee') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-course_fee">{{ __('Course Fee') }}</label>
                                        <input type="text" name="course_fee" id="input-course_fee"
                                            class="form-control form-control-alternative{{ $errors->has('course_fee') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Course Fee') }}" value="{{ old('course_fee') }}"
                                            required autofocus>

                                        @if ($errors->has('course_fee'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course_fee') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('nvq_level') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-nvq_level">{{ __('NVQ Level') }}</label>
                                <select name="nvq_level" id="input-nvq_level" class="form-control"
                                    value="{{ old('nvq_level') }}" required data-toggle="select">
                                    <option value="1">Level 1</option>
                                    <option value="2">Level 2</option>
                                    <option value="3">Level 3</option>
                                    <option value="4">Level 4</option>
                                    <option value="5">Level 5</option>
                                    <option value="6">Level 6</option>
                                    <option value="7">Level 7</option>
                                </select>
                                @if ($errors->has('nvq_level'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nvq_level') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Add Course') }}</button>
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