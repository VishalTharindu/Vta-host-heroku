@extends('layouts.app', ['title' => __('Instructor Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add New Instructor')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Instructor Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('instructor.index') }}"
                                class="btn btn-sm btn-warning">{{ __('View All Instructors') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('instructor.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('First Name') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-first_name">{{ __('First Name') }}</label>
                                        <input type="text" name="first_name" id="input-first_name"
                                            class="form-control form-control-alternative{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}"
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
                                            for="input-batch">{{ __('Last Name') }}</label>
                                        <input type="text" name="last_name" id="input-last_name"
                                            class="form-control form-control-alternative{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Last Name') }}" value="{{ old('last_name') }}"
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
                                    <div class="form-group{{ $errors->has('nic') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-nic">{{ __('NIC') }}</label>
                                        <input type="text" name="nic" id="input-nic"
                                            class="form-control form-control-alternative{{ $errors->has('nic') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('NIC') }}" value="{{ old('nic') }}"
                                            required autofocus>

                                        @if ($errors->has('nic'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nic') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-email">{{ __('Email') }}</label>
                                        <input type="text" name="email" id="input-email"
                                            class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Email') }}" value="{{ old('email') }}"
                                            required autofocus>

                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-phone_number">{{ __('Phone Number') }}</label>
                                        <input type="text" name="phone_number" id="input-phone_number"
                                            class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Phone Number') }}" value="{{ old('phone_number') }}"
                                            required autofocus>
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
                                        <input type="text" name="city" id="input-city"
                                            class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('City') }}" value="{{ old('city') }}"
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
                                    <div class="form-group{{ $errors->has('course_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-batch">{{ __('Course Name') }}</label>
                                        <select name="course_id" class="form-control" data-toggle="select">
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->course_name}}</option>
                                            @endforeach                                           
                                            
                                        </select>
                                        @if ($errors->has('course_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                        <input type="text" name="address" id="input-address"
                                            class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('40/3,Passara Road,Badulla') }}" value="{{ old('address') }}"
                                            required autofocus>
                                        @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h6 class="heading-small text-muted mb-4">{{ __('Login information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('login-email') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-login-email">{{ __('Login Email') }}</label>
                                        <input type="text" name="login-email" id="input-login-email"
                                            class="form-control form-control-alternative{{ $errors->has('login-email') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Login Email') }}" value="{{ old('login-email') }}"
                                            required autofocus>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input mt-3" id="same" type="checkbox" onchange= "sameEmail()">
                                                <label class="custom-control-label" for="same">Use Above Email Address</label>
                                            </div>
                                        @if ($errors->has('login-email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('login-email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('login-password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-login-password">{{ __('Login Password (Default: abcd1234)') }}</label>
                                        <input type="text" name="login-password" id="input-login-password"
                                            class="form-control form-control-alternative{{ $errors->has('login-password') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Login Password') }}" value="abcd1234"
                                            required autofocus>
                                        @if ($errors->has('login-password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('login-password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>                   
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Add Instructor') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script> 
        function sameEmail() 
        { 
          if (document.getElementById('same').checked) 
          { 
            document.getElementById('input-login-email').value=document. 
                     getElementById('input-email').value;  
          } 
              
          else
          { 
            document.getElementById('input-login-email').value=""; 
          } 
        } 
    </script>

    @include('layouts.footers.auth')
</div>
@endsection