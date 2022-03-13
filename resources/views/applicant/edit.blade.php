@extends('layouts.app', ['title' => __('Application Management')])

@section('content')
@include('users.partials.header', ['title' => __('Edit Applicant')])

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
                                class="btn btn-sm btn-warning">{{ __('GO back') }}</a>
                            @else
                            <a href="{{ route('applicant.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All Applicants') }}</a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($applicant->status == 1 && Auth::user()->hasRole('ma'))
                    <form action="{{ route('applicant.unselect', $applicant) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-danger float-right"
                            onclick="confirmUnselect()">{{ __('Make the applicant as unselected') }}</button>
                    </form>
                    @endif
                    <form method="post" action="{{ route('applicant.update', ['id' => $applicant->id]) }}"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('Applicant Information') }}</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('name_with_initials') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-nameWithInitials">{{ __('Name With Initials') }}</label>
                                        <input type="text" name="name_with_initials" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Name With Initials') }}"
                                            value="{{ $applicant->name_with_initials }}" required autofocus>

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
                                            for="input-fullName">{{ __('Full Name') }}</label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="form-control form-control-alternative{{ $errors->has('full_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter full Name') }}"
                                            value="{{ $applicant->full_name }}" required autofocus>

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
                                    <label class="form-control-label">{{ __('NIC Number') }}</label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('nic') ? ' is-invalid' : '' }}"
                                        name="nic" value="{{ $applicant->nic }}">
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
                                        name="email" value="{{ $applicant->email }}">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Gender') }}</label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                        name="gender" id="list-gender" value="{{ old('gender') }}" required>

                                        <option value=""></option>
                                        <option value="male" @if($applicant->gender == "male")
                                            selected
                                            @endif
                                            >Male</option>
                                        <option value="female" @if($applicant->gender == "female")
                                            selected
                                            @endif
                                            >Female</option>

                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Ethnicity') }}</label>
                                    <select
                                        class="list-ethnicity form-control form-control-alternative{{ $errors->has('ethnicity') ? ' is-invalid' : '' }}"
                                        name="ethnicity" id="list-ethnicity" value="{{ old('ethnicity') }}" required>
                                        <option value=""></option>
                                        <option value="sinhala" @if($applicant->ethnicity == "sinhala")
                                            selected
                                            @endif
                                            >Sinhala</option>
                                        <option value="tamil" @if($applicant->ethnicity == "tamil")
                                            selected
                                            @endif
                                            >Tamil</option>
                                        <option value="muslim" @if($applicant->ethnicity == "muslim")
                                            selected
                                            @endif
                                            >Muslim</option>
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
                                            for="input-phoneNumber">{{ __('Phone Number') }}</label>
                                        <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{10}"
                                            class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Phone Number') }}"
                                            value="{{ $applicant->phone_number }}" required autofocus>

                                        @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                        <input type="text" name="city" id="city"
                                            class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Badulla') }}" value="{{ $applicant->city }}" required
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
                                <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                <input type="text" name="address" id="address"
                                    class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('40/3,Passara Road,Badulla') }}"
                                    value="{{ $applicant->address }}" required autofocus>

                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('qualification') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-fullName">{{ __('Qualification') }}</label>
                                <input type="text" name="qualification" id="qualification"
                                    class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('A/L') }}" value="{{ $applicant->qualification }}" required
                                    autofocus>

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
                                            for="input-course">{{ __('Requested Courses') }}</label>
                                        <select
                                            class="list-courses form-control form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }}"
                                            name="courses[]" id="input-courses" value="{{ old('course') }}"
                                            multiple="multiple" data-toggle="select" required autofocus>

                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{in_array($course->id, old("courses") ?: []) ? "selected": ""}}
                                                @if($applicant->hasCourses($course->id))
                                                selected
                                                @endif>
                                                {{ $course->course_name }}
                                            </option>
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
                                        <label class="form-control-label" for="input-batch_id">{{ __('Batch') }}</label>
                                        <select
                                            class="list-batches form-control form-control-alternative{{ $errors->has('batch_id') ? ' is-invalid' : '' }}"
                                            name="batch_id" id="input-batches" value="{{ old('batch_id') }}" required>

                                            @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}" @if($batch->id == $applicant->batch->id)
                                                selected
                                                @endif
                                                >
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
                            @if($applicant->status == 1)
                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label class="form-control-label"
                                    for="input-address">{{ __('Selected Course') }}</label>
                                <select
                                    class="list-course-selected  val form-control form-control-alternative{{ $errors->has('selected_course_id') ? ' is-invalid' : '' }}"
                                    name="selected_course_id" value="{{ old('selected_course_id') }}">

                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" @if($course->id == $applicant->selected_course_id)
                                        selected
                                        @endif
                                        >
                                        {{ $course->course_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @endif
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Edit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {

        $('.list-batches').select2();
        $('#list-gender').select2();
        $('#list-ethnicity').select2();
        $('.list-course-selected').select2();
        $('.list-courses').select2({
            minimumResultsForSearch: 1,
            maximumSelectionLength: 2
        });
    });

    function confirmUnselect() {
        event.preventDefault();
        var form = event.target.form;
        $.confirm({
            title: 'Unselect!',
            content: 'Are you sure you want to Unselect the applicant?',
            animation: 'zoom',
            closeAnimation: 'scale',
            icon: 'fa fa-trash-alt',
            theme: 'material',
            closeIcon: true,
            type: 'red',
            animateFromElement: false,
            buttons: {
                confirm: function() {
                    form.submit();
                },
                cancel: function() {
                    $.alert('Canceled');
                }
            }
        });
    }
    </script>
    @include('layouts.footers.auth')
</div>
@endsection