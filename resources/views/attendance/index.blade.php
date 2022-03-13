@extends('layouts.app', ['title' => __('Attendance Management')])

@section('content')
@include('layouts.headers.cards')
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Attendance') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('attendance.add') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="form-group{{ $errors->has('course') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-course">{{ __('Courses') }}</label>
                                <select
                                    class="list-courses form-control form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }}"
                                    name="course" id="input-courses" value="{{ old('course') }}" data-toggle="select"
                                    required autofocus>
                                    @if ($authUser == 'Instructor')
                                    <option value="{{ $courses->id }}" {{in_array($courses->id, old("courses") ?: []) ?
                                        "selected": ""}}>
                                        {{ $courses->course_name }}</option>
                                    @else
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{in_array($course->id, old("courses") ?: []) ?
                                        "selected": ""}}>
                                        {{ $course->course_name }}</option>
                                    @endforeach
                                    @endif


                                </select>
                                @if ($errors->has('course'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('course') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('batch') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-course">{{ __('Batch') }}</label>
                                <select
                                    class="list-batches form-control form-control-alternative{{ $errors->has('batch') ? ' is-invalid' : '' }}"
                                    name="batch" id="input-batches" value="{{ old('batches') }}" data-toggle="select"
                                    required autofocus>

                                    @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{in_array($batch->id, old("batches") ?: []) ?
                                        "selected": ""}}>
                                        {{ $batch->year . '-' . $batch->batch_no }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('batch'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('batch') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-course">{{ __('Type') }}</label>
                                <select
                                    class="list-type form-control form-control-alternative{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                    name="type" id="input-type" value="{{ old('type') }}" data-toggle="select" required
                                    autofocus>
                                    <option value="Morning">Morning</option>
                                    <option value="Evening">Evening</option>
                                </select>
                                @if ($errors->has('type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Mark Attendance')
                                    }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#input-batches').select2();
            $('#input-courses').select2();
        });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection