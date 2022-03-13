@extends('layouts.app', ['title' => __('Demonstrator Management')])

@section('content')
@include('users.partials.header', ['title' => __('Edit Demonstrator')])
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Demonstrator Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('demonstrator.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All Demonstrators') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('demonstrator.update', $demonstrator) }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('Demonstrator information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-first_name">{{ __('First Name') }}</label>
                                        <input type="text" name="first_name" id="input-first_name"
                                            class="form-control form-control-alternative{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('First Name') }}" value="{{$demonstrator->first_name}}"
                                            required autofocus>

                                        @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-last_name">{{ __('Last Name') }}</label>
                                        <input type="text" name="last_name" id="input-last_name"
                                            class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Last Name') }}" value="{{$demonstrator->last_name}}"
                                            required autofocus>

                                        @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                        <input type="email" name="email" id="input-email"
                                            class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Email') }}" value="{{$demonstrator->email}}" required
                                            autofocus>

                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-phone_number">{{ __('Phone Number') }}</label>
                                        <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{10}"
                                            class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Phone Number') }}"
                                            value="{{$demonstrator->phone_number}}" required autofocus>

                                        @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-address">{{ __('Address') }}</label>
                                        <input type="text" name="address" id="address" class="form-control
                                            form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Address') }}" value="{{$demonstrator->address}}"
                                            required autofocus>

                                        @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('City') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                        <input type="text" name="city" id="city"
                                            class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter City') }}" value="{{$demonstrator->city}}"
                                            required autofocus>

                                        @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('nic') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nic">{{ __('NIC Number') }}</label>
                                        <input type="text" name="nic" id="input-nic"
                                            class="form-control form-control-alternative{{ $errors->has('nic') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('NIC Number') }}" value="{{$demonstrator->nic}}" required
                                            autofocus>

                                        @if ($errors->has('nic'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nic') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h6 class="heading-small text-muted mb-4">{{ __('Course information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('courses') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nic">{{ __('Courses') }}</label>
                                        <select name="courses[]" class="form-control course-select" multiple="multiple">
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @if($demonstrator->
                                                hasCourses($course->id))
                                                selected
                                                @endif>
                                                {{ $course->course_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            $(".course-select").select2({
                                                maximumSelectionLength: 10
                                            });
                                        </script>
                                        @if ($errors->has('courses'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('courses') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-success mt-4 px-4">{{ __('Update Demonstrator') }}</button>
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