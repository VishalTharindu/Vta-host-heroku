@extends('layouts.app', ['title' => __('Trainee Management')])

@section('content')
@include('users.partials.header', ['title' => __('Edit Trainee')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Management') }}</h3>
                        </div>
                        @if($maEdit == TRUE)
                        <div class="col-4 text-right">
                            <a href="{{ route('interview.updateTrainee') }}"
                                class="btn btn-sm btn-warning">{{ __('Back') }}</a>
                        </div>
                        @else
                        <div class="col-4 text-right">
                            <a href="" class="btn btn-sm btn-warning">{{ __('View All trainee') }}</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('trainee.update', ['id' => $trainee->id]) }}"
                        autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="pl-lg-4">

                            @if($maEdit==TRUE)
                            <input type="hidden" name="mode" value="interview">
                            @else
                            <input type="hidden" name="mode" value="normal">
                            @endif

                            <div class="row align-center mb-4">
                                <div class="col-md-4">
                                    <hr style="width:100%;text-align:left;margin-left:0">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="heading-small text-muted text-center">{{ __('Trainee information') }}
                                    </h6>
                                    @if($trainee->image)
                                    <img src="{{asset('storage/'.$trainee->image)}}" width="150px" height="150px" alt=""
                                        class="rounded-circle mx-auto d-block">
                                    @else
                                    <img src="{{asset('images/no_image.png')}}" width="150px" height="150px" alt=""
                                        class="rounded-circle mx-auto d-block">
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <hr style="width:100%;text-align:right;margin-right:0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Name With Initials') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control in_name form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                        name="name_with_initials" value="{{ $trainee->name_with_initials }}"
                                        @if($maEdit==TRUE) disabled @endif>
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
                                        name="full_name" value="{{ $trainee->full_name }}" @if($maEdit==TRUE) disabled
                                        @endif>
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
                                        name="enrollment_no" value="{{ $trainee->enrollment_no }}">
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
                                        name="image" name="image" value="{{ $trainee->image }}">
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
                                        name="email" value="{{ $trainee->email }}" @if($maEdit==TRUE) disabled @endif>
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
                                        name="nic" value="{{ $trainee->nic }}" @if($maEdit==TRUE) disabled @endif>
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
                                        name="gender" id="list-gender" value="{{ old('gender') }}" @if($maEdit==TRUE)
                                        disabled @endif>

                                        <option value=""></option>
                                        <option value="male" @if($trainee->gender == "male")
                                            selected
                                            @endif
                                            >Male</option>
                                        <option value="female" @if($trainee->gender == "female")
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
                                    <label class="form-control-label">{{ __('Ethnicity') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-ethnicity form-control form-control-alternative{{ $errors->has('ethnicity') ? ' is-invalid' : '' }}"
                                        name="ethnicity" id="input-batches" value="{{ old('ethnicity') }}"
                                        @if($maEdit==TRUE) disabled @endif>
                                        <option value=""></option>
                                        <option value="sinhala" @if($trainee->ethnicity == "sinhala")
                                            selected
                                            @endif
                                            >Sinhala</option>
                                        <option value="tamil" @if($trainee->ethnicity == "tamil")
                                            selected
                                            @endif
                                            >Tamil</option>
                                        <option value="muslim" @if($trainee->ethnicity == "muslim")
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
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Course') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('course_id') ? ' is-invalid' : '' }}"
                                        name="course_id" id="list-course" value="{{ old('course_id') }}" required
                                        @if($maEdit==TRUE) disabled @endif>

                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}" @if($course->id == $trainee->course->id)
                                            selected
                                            @endif
                                            >
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
                                        name="batch_id" id="list-batch" value="{{ old('batch_id') }}" required
                                        @if($maEdit==TRUE) disabled @endif>

                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" @if($batch->id == $trainee->batch->id)
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
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('City') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                        name="city" value="{{ $trainee->city }}" @if($maEdit==TRUE) disabled @endif>
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
                                        name="phone_number" value="{{ $trainee->phone_number }}" @if($maEdit==TRUE)
                                        disabled @endif>
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
                                        name="address" value="{{ $trainee->address }}" @if($maEdit==TRUE) disabled
                                        @endif>
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
                                        name="qualification" value="{{ $trainee->qualification }}" @if($maEdit==TRUE)
                                        disabled @endif>
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