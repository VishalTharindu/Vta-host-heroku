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
                            <h3 class="mb-0">{{ __('Unlock Attendance Marking') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('attendance.permission.add.submit') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-date">{{ __('Date') }}</label>
                                        <input
                                            class="list-date form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                            name="date" id="input-date"
                                            value="{{ Carbon\Carbon::today()->toDateString() }}" data-toggle="select"
                                            required readonly>

                                        @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-instructorooo">{{ __('Instructor')
                                            }}</label>
                                        <select
                                            class="list-instructor form-control form-control-alternative{{ $errors->has('instructor') ? ' is-invalid' : '' }}"
                                            name="instructor" id="input-instructor" value="{{ old('instructor') }}"
                                            data-toggle="select" required autofocus>
                                            @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{in_array($instructor->id,
                                                old("instructor") ?:
                                                []) ?
                                                "selected": ""}}>
                                                {{ $instructor->first_name . ' ' . $instructor->last_name }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('batch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('instructor') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-primary px-4 float-right">{{ __('Give
                                    Permission')
                                    }}</button>
                            </div>
                    </div>
                    </form>
                </div>
                <div class="card-header">
                    <h3 class="mb-0">Unlocked Records</h3>
                </div>
                <div class="ml-4 mr-4">
                    <div class="mr-3 ml-3 mt-4">
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-buttons">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Instructor Name</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($unlockedRecords)
                                    @foreach($unlockedRecords as $record)
                                    <tr>
                                        <td scope="col">{{App\User::getUserName($record->user_id)}}</td>
                                        <td scope="col">{{$record->created_at}}</td>
                                    </tr>
                                    @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#input-instructor').select2();
    });
</script>
@include('layouts.footers.auth')
</div>
@endsection