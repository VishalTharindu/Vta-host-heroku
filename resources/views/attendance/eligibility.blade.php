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
                            <h3 class="mb-0">{{ __('View Eligibility') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('attendance.eligibility') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Courses') }}</label>
                                        <select
                                            class="list-courses form-control form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }}"
                                            name="course" id="input-courses" value="{{ old('course') }}"
                                            data-toggle="select" required autofocus>

                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{in_array($course->id, old("courses") ?:
                                                [])
                                                ?
                                                "selected": ""}}>
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
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Batch') }}</label>
                                        <select
                                            class="list-batches form-control form-control-alternative{{ $errors->has('batch') ? ' is-invalid' : '' }}"
                                            name="batch" id="input-batches" value="{{ old('batches') }}"
                                            data-toggle="select" required autofocus>

                                            @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}" {{in_array($batch->id, old("batches") ?:
                                                []) ?
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
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-success px-4 float-right">{{ __('Check')
                                    }}</button>
                            </div>
                    </div>
                    </form>
                </div>
                <div class="card-header">
                    @if (isset($reBatchName))
                    <h3 class="mb-0">
                        {{'Eligibility of ' . $reCourseName .' ' . $reBatchName->year .'-' . $reBatchName->batch_no .'
                        Trainees'}}
                    </h3>
                    @else
                    <h3 class="mb-0">Trainee Eligibility</h3>
                    @endif
                </div>
                <div class="ml-4 mr-4">
                    <div class="mr-3 ml-3 mt-4">
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-custom">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Enrollment No</th>
                                        <th scope="col">NIC</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Course</th>
                                        <th scope="col">Perc.</th>
                                        <th scope="col">Eligibility</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($trainees)
                                    @foreach($trainees as $trainee)
                                    <tr>
                                        <td scope="col">{{$trainee->name_with_initials}}</td>
                                        <td scope="col">{{$trainee->enrollment_no}}</td>
                                        <td scope="col">{{$trainee->nic}}</td>
                                        <td scope="col">{{$trainee->batch->year}}</td>
                                        <td scope="col">{{$trainee->course->course_name}}</td>
                                        @php
                                        $precentage = App\Attendance::calculateAttendanceEligibility($trainee->id);
                                        @endphp
                                        <td scope="col">{{$precentage}}%</td>
                                        <td scope="col">
                                            @if ($precentage >= 80)
                                            <span class="text-success font-width-bold">Eligible</span>
                                            @else
                                            <span class="text-danger font-width-bold">Not Eligible</span>
                                            @endif
                                        </td>
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
        $('#datatable-custom').DataTable({
            lengthChange: !1,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    pageSize: 'A4',
                    title:
                    @if (isset($reBatchName))
                        'Eligibility of {{$reCourseName}} {{$reBatchName->year}} {{$reBatchName->batch_no}} Trainees'
                    @else
                        'Trainee Eligibility'
                    @endif,
                },
                'copy', 'print',
            ],
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
        });
        $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default');
    });
</script>
<script>
    $(document).ready(function() {
        $('#input-batches').select2();
        $('#input-courses').select2();
        $('#input-years').select2();
        $('#input-months').select2();
    });
</script>
@include('layouts.footers.auth')
</div>
@endsection