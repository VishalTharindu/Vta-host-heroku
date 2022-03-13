@extends('layouts.app', ['title' => __('Trainee Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add Trainee')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Add Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('trainee.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All trainees') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('trainee.store') }}" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Name With Initials') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control in_name form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                        name="name_with_initials" value="{{ old('name_with_initials') }}">
                                    @if ($errors->has('name_with_initials'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_with_initials') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Full Name') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('full_name') ? ' is-invalid' : '' }}"
                                        name="full_name" value="{{ old('full_name') }}">
                                    @if ($errors->has('full_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Enrollment Number') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('enrollment_no') ? ' is-invalid' : '' }}"
                                        name="enrollment_no" value="{{ old('enrollment_no') }}">
                                    @if ($errors->has('enrollment_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('enrollment_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Image') }}</label>
                                    <input type="file"
                                        class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                        name="image">
                                    @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
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
                            </div>

                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Gender') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                        name="gender" id="list-gender" value="{{ old('gender') }}">

                                        <option value=""></option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>

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
                                        name="ethnicity" id="input-batches" value="{{ old('ethnicity') }}">
                                        <option value=""></option>
                                        <option value="sinhala">Sinhala</option>
                                        <option value="tamil">Tamil</option>
                                        <option value="muslim">Muslim</option>
                                    </select>
                                    @if ($errors->has('ethnicity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ethnicity') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Course') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('course_id') ? ' is-invalid' : '' }}"
                                        name="course_id" id="list-course" value="{{ old('course_id') }}" required>
                                        <option value=""></option>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->course_name }}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('course_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('course_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Batch') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('batch_id') ? ' is-invalid' : '' }}"
                                        name="batch_id" id="list-batch" value="{{ old('batch_id') }}" required>
                                        <option value=""></option>
                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}">
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
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('City') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                        name="city" value="{{ old('city') }}">
                                    @if ($errors->has('city'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Phone Number') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                        name="phone_number" value="{{ old('phone_number') }}">
                                    @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Address') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                        name="address" value="{{ old('address') }}">
                                    @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Qualification') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}"
                                        name="qualification" value="{{ old('qualification') }}">
                                    @if ($errors->has('qualification'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('qualification') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Complete') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
<script>
    $(document).ready(function() {
    $('#list-batch').select2();
    $('#list-course').select2();
    $('#list-gender').select2();
    $('.list-ethnicity').select2();
});
</script>
@endsection