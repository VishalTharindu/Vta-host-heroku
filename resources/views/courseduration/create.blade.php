@extends('layouts.app', ['title' => __('Course Duration Management')])

@section('content')
@include('users.partials.header', ['title' => __('Add New Course Duration')])
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Course Duration Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('courseduration.index') }}" class="btn btn-sm btn-warning">{{ __('View All
                                Course Duration') }}</a>
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
                    <form method="post" action="{{ route('courseduration.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('Course information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('course_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-batch">{{ __('Course Name*')
                                            }}</label>
                                        <select name="course_id" class="form-control" data-toggle="select">
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{in_array($course->id, old("courses") ?:
                                                []) ?
                                                "selected": ""}}>
                                                {{ $course->course_name }}</option>
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
                                    <div class="form-group{{ $errors->has('batch_id') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-batch">{{ __('Batch Name')
                                            }}</label>
                                        <select name="batch_id" class="form-control" data-toggle="select">
                                            @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}" {{in_array($batch->id, old("batches") ?:
                                                []) ?
                                                "selected": ""}}>
                                                {{ $batch->year . '-' . $batch->batch_no }}</option>
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
                            <div class="container1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="start_date">{{ __('Start Date')
                                                }}</label>
                                            <input class="form-control datepicker" id="datepicker1" name="start_date"
                                                placeholder="Select date" value="" type="text"
                                                data-date-format="yyyy-mm-dd">
                                            @if ($errors->has('start_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="end_date">{{ __('End Date')}}</label>
                                            <input class="form-control datepicker" id="datepicker1" name="end_date"
                                                placeholder="Select date" value="" type="text"
                                                data-date-format="yyyy-mm-dd">
                                            @if ($errors->has('end_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Add Course Duration')
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