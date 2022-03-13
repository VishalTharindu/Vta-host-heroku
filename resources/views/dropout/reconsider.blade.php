@extends('layouts.app', ['title' => __('Medical Document Upload')])

@section('content')
@include('users.partials.header', ['title' => __('Medical Document Upload')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="col-12">
                        @include('partials.status')
                    </div>
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Medical Document Upload') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('suspended.reconsider.medical')}}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{$trainee->id}}" hidden>
                        <h6 class="heading-small text-muted mb-4">{{ __('Medical Document') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-5">
                                    <div
                                        class="form-group{{ $errors->has('name_with_initials') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Name With Initials') }}</label>
                                        <div class="input-group control-group increment">
                                            <input type="text" name="name_with_initials"
                                                class="form-control form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                                placeholder="{{$trainee->name_with_initials}}"
                                                value="{{$trainee->name_with_initials}}" autofocus>
                                        </div>

                                        @if ($errors->has('name_with_initials'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_with_initials') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('enrollment_no') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-enrollment_no">{{
                                            __('Enrollment No') }}</label>
                                        <div class="input-group control-group increment">
                                            <input type="text" name="enrollment_no"
                                                class="form-control form-control-alternative{{ $errors->has('enrollment_no') ? ' is-invalid' : '' }}"
                                                placeholder="{{$trainee->enrollment_no}}"
                                                value="{{$trainee->enrollment_no}}" autofocus>
                                        </div>

                                        @if ($errors->has('enrollment_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('enrollment_no') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('forumA') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Medical Report') }}</label>
                                        <input type="file" name="medical_report" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('medical_report') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Medical Report') }}" value="{{ old('medical_report') }}"
                                            autofocus>

                                        @if ($errors->has('medical_report'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('medical_report') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('other_report') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Other Document (If any)') }}</label>
                                        <input type="file" name="other_report" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('other_report') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Other Document') }}" value="{{ old('other_report') }}"
                                            autofocus>

                                        @if ($errors->has('other_report'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('other_report') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Remove Suspension')
                                    }}</button>
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