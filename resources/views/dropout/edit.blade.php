@extends('layouts.app', ['title' => __('Subject Management')])

@section('content')
@include('users.partials.header', ['title' => __('Update Subject')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Subject Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('subject.index') }}" class="btn btn-sm btn-warning">{{ __('View All
                                Subjects') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form method="post" action="{{ route('subject.update', $subject) }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('Course information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('course_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-batch">{{ __('Course Name') }}</label>
                                        <select name="course_id" class="form-control" data-toggle="select">
                                            @foreach ($courses as $course)

                                            <option value="{{$course->id}}" @if($course->id == $subject->course->id)
                                                selected
                                                @endif
                                                >{{$course->course_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('course_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="container1">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group{{ $errors->has('subject_name') ? ' has-danger' : '' }}">

                                            <div class="input-group control-group increment">
                                                <input type="text" name="subject_name[]"
                                                    class="form-control form-control-alternative{{ $errors->has('subject_name') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Subject Name') }}"
                                                    value="{{ old('name_with_initials', $subject->subject_name) }}"
                                                    autofocus>
                                            </div>

                                            @if ($errors->has('subject_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('subject_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group{{ $errors->has('subject_code') ? ' has-danger' : '' }}">

                                            <div class="input-group control-group increment">
                                                <input type="text" name="subject_code[]"
                                                    class="form-control form-control-alternative{{ $errors->has('subject_code') ? ' is-invalid' : '' }}"
                                                    placeholder="{{ __('Subject Code') }}"
                                                    value="{{ old('subject_code',$subject->subject_code) }}" autofocus>
                                            </div>

                                            @if ($errors->has('subject_code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('subject_code') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Update Subject')
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