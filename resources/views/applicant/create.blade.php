@extends('layouts.app', ['title' => __('Application Management')])

@section('content')
@include('users.partials.header', ['title' => __('New Applicant')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Application Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            @if($interviewMode == True)
                            <a href="{{ route('interview.index') }}"
                                class="btn btn-sm btn-warning">{{ __('GO back to interview') }}</a>
                            @else
                            <a href="{{ route('applicant.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All Applicants') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('applicant.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('Applicant Information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('name_with_initials') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-nameWithInitials">{{ __('Name With Initials') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name_with_initials" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Name With Initials') }}"
                                            value="{{ old('name_with_initials') }}" required autofocus>

                                        @if ($errors->has('name_with_initials'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_with_initials') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('full_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-fullName">{{ __('Full Name') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="form-control form-control-alternative{{ $errors->has('full_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter full Name') }}" value="{{ old('full_name') }}"
                                            required autofocus>

                                        @if ($errors->has('full_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('full_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('NIC Number') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('nic') ? ' is-invalid' : '' }}"
                                        name="nic" value="{{ old('nic') }}">
                                    @if ($errors->has('nic'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nic') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Email') }}</label>
                                    <input type="email"
                                        class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Gender') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                        name="gender" id="list-gender" value="{{ old('gender') }}" required>

                                        <option value=""></option>
                                        <option value="male" @if(old('gender')=="male" ) selected @endif>Male</option>
                                        <option value="female" @if(old('gender')=="female" ) selected @endif>Female
                                        </option>

                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Ethnicity') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-ethnicity form-control form-control-alternative{{ $errors->has('ethnicity') ? ' is-invalid' : '' }}"
                                        name="ethnicity" id="list-ethnicity" value="{{ old('ethnicity') }}" required>
                                        <option value=""></option>
                                        <option value="sinhala" @if(old('ethnicity')=="sinhala" ) selected @endif>
                                            Sinhala</option>
                                        <option value="tamil" @if(old('ethnicity')=="tamil" ) selected @endif>Tamil
                                        </option>
                                        <option value="muslim" @if(old('ethnicity')=="muslim" ) selected @endif>Muslim
                                        </option>
                                    </select>
                                    @if ($errors->has('ethnicity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ethnicity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-phoneNumber">{{ __('Phone Number') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{10}"
                                            class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Phone Number') }}"
                                            value="{{ old('phone_number') }}" required autofocus>

                                        @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-city">{{ __('City') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="city" id="city"
                                            class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Badulla') }}" value="{{ old('city') }}" required
                                            autofocus>

                                        @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-address">{{ __('Address') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="address" id="address"
                                    class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('40/3,Passara Road,Badulla') }}" value="{{ old('address') }}"
                                    required autofocus>

                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('qualification') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-fullName">{{ __('Qualification') }}<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="qualification" id="qualification"
                                    class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('A/L') }}" value="{{ old('qualification') }}" required autofocus>

                                @if ($errors->has('qualification'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('qualification') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('course') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-course">{{ __('Requested Courses') }}<span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="list-courses form-control form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }}"
                                            name="courses[]" id="input-courses" value="{{ old('course') }}"
                                            multiple="multiple" data-toggle="select" required autofocus>

                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{in_array($course->id, old("courses") ?: []) ? "selected": ""}}>
                                                {{ $course->course_name }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('course'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('batch_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-batch_id">{{ __('Batch') }}<span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="list-batches form-control form-control-alternative{{ $errors->has('batch_id') ? ' is-invalid' : '' }}"
                                            name="batch_id" id="list-batches" value="{{ old('batch_id') }}" required>

                                            @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}" @if($batch->id == old('batch_id'))
                                                selected
                                                @endif>
                                                {{ $batch->year }} / {{ $batch->batch_no }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('batch_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('batch_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        $('#list-batches').select2();
        $('#list-gender').select2();
        $('#list-ethnicity').select2();
        $('.list-courses').select2({
            maximumSelectionLength: 2
        });

    });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection