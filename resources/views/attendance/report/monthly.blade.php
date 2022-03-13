@extends('layouts.app', ['title' => __('Monlthy Report')])

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
                            <h3 class="mb-0">{{ __('Monlthy Attendance Report') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('attendance.report.monthly.submit') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">Year</label>
                                        <select
                                            class="list-year form-control form-control-alternative{{ $errors->has('year') ? ' is-invalid' : '' }}"
                                            name="year" id="input-years" value="{{ old('year') }}" data-toggle="select"
                                            required autofocus>

                                            @foreach($attendanceYears as $attendanceYear)
                                            <option value="{{ $attendanceYear->year }}" {{in_array($attendanceYear,
                                                old("attendanceYears")?: []) ? "selected" : "" }}>
                                                {{ $attendanceYear->year }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('year'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('year') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">Month</label>
                                        <select
                                            class="list-month form-control form-control-alternative{{ $errors->has('month') ? ' is-invalid' : '' }}"
                                            name="month" id="input-months" value="{{ old('month') }}"
                                            data-toggle="select" required autofocus>

                                            @foreach($attendanceMonths as $attendanceMonth)
                                            <option value="{{ $attendanceMonth->month }}" {{in_array($attendanceMonth,
                                                old("attendanceMonths")?: []) ? "selected" : "" }}>
                                                {{ $attendanceMonth->month }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('month'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('month') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-success px-4 float-right">{{ __('Generate')
                                    }}</button>
                            </div>
                    </div>
                    </form>
                </div>
                <div class="card-header">

                    @if (isset($reCourseName))
                    <h3 class="mb-0">
                        {{'Attendance of ' . $reCourseName .' ' . $reBatchName->year .'-' . $reBatchName->batch_no .'
                        Trainees ' . '- ' . date("F", mktime(0, 0, 0, $reMonth, 1)) .' ' . $reYear}}
                    </h3>
                    <p class="text-sm mb-0">
                        Hour Based Attendance <span class="font-weight-bold">(8 - Full Day , 4 - Half Day , 0 -
                            Abesent)</span> | <span class="font-weight-bold">N</span> = Attendance is not taken.
                    </p>
                    <hr>
                    <p class="mb-0">Monthly Precentage: <span class="font-weight-bold">Male</span> -
                        {{number_format($avgPrec->male_perc,2)}}% <span class="font-weight-bold">Female</span> -
                        {{number_format($avgPrec->female_perc,2)}}%
                    </p>

                    @else
                    <h3 class="mb-0">Trainee Attendance</h3>
                    <p class="text-sm mb-0">
                        Hour Based Attendance <span class="font-weight-bold">(8 - Full Day , 4 - Half Day , 0 -
                            Abesent)</span> | <span class="font-weight-bold">N</span> = Attendance is not taken.
                    </p>
                    @endif


                </div>
                <div class="mr-3 ml-3 mt-4">

                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-custom">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">NIC</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th scope="col">Perc.</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                    <th>8</th>
                                    <th>9</th>
                                    <th>10</th>
                                    <th>11</th>
                                    <th>12</th>
                                    <th>13</th>
                                    <th>14</th>
                                    <th>15</th>
                                    <th>16</th>
                                    <th>17</th>
                                    <th>18</th>
                                    <th>19</th>
                                    <th>20</th>
                                    <th>21</th>
                                    <th>22</th>
                                    <th>23</th>
                                    <th>24</th>
                                    <th>25</th>
                                    <th>26</th>
                                    <th>27</th>
                                    <th>28</th>
                                    <th>29</th>
                                    <th>30</th>
                                    <th>31</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($attendances)
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td scope="col">{{$attendance->trainee->name_with_initials}}</td>
                                    <td scope="col">{{$attendance->trainee->nic}}</td>
                                    <td>{{$attendance->year}}</td>
                                    <td>{{$attendance->month}}</td>
                                    <td scope="col"><span class="font-weight-bold">
                                            {{$attendance->calculateAttendacnePercentage($attendance)}}%</span>
                                    </td>
                                    @for ($i = 1; $i < 32; $i++) @php $day='day_' . $i; @endphp <td>
                                        @if ($attendance->$day == -1)
                                        N
                                        @else
                                        {{$attendance->$day}}
                                        @endif
                                        </td> @endfor
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
        $('#datatable-custom').DataTable({
            lengthChange: !1,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A3',
                    title:
                    @if (isset($reCourseName))
                        'Attendance of {{$reCourseName}} {{$reBatchName->year}} {{$reBatchName->batch_no}} Trainees {{date("F", mktime(0, 0, 0, $reMonth, 1))}}  {{$reYear}}'
                    @else
                        'Trainee Attendance'
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