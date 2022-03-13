@extends('layouts.app', ['title' => __('Attendance Daily Report')])

@section('content')
@include('layouts.headers.cards')
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Daily Report') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('attendance.report.daily.submit') }}" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="report_date">{{ __('Date') }}</label>
                                        <input class="form-control datepicker" id="datepicker1" name="report_date"
                                            placeholder="Select date" value="" type="text"
                                            data-date-format="yyyy-mm-dd">
                                        @if ($errors->has('report_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('report_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-success px-5 float-right">{{ __('Search')
                            }}</button>
                    </div>
                </div>
                </form>
                <div class="card-header">
                    <h3 class="mb-0">Attendance Daily - @if (isset($date))
                        {{$date}}
                        @else
                        {{Carbon\Carbon::today()->toDateString()}}
                        @endif</h3>
                </div>
                <div class="ml-4 mr-4">
                    <div class="mr-3 ml-3 mt-4">
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-custom">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Course</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Male</th>
                                        <th scope="col">Female</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayRecords as $todayRecord)
                                    <tr>
                                        <td scope="col">{{App\Course::find($todayRecord->course_id)->course_name}}</td>
                                        <td scope="col">{{App\Batch::find($todayRecord->batch_id)->year}} -
                                            {{App\Batch::find($todayRecord->batch_id)->batch_no}}</td>
                                        <td scope="col">{{$todayRecord->male_perc}}</td>
                                        <td scope="col">{{$todayRecord->female_perc}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                    @if (isset($date))
                        'Attendance Daily - {{$date}}'
                    @else 
                        'Attendance Daily - {{Carbon\ Carbon::today()->toDateString()}}'
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
<script type='text/javascript'>
    $(document).ready(function() {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datepicker1').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            startDate: today,
            endDate: end,
            autoclose: true
        });
        $('#datepicker1').datepicker('setDate', today);
    });
</script>

@include('layouts.footers.auth')
</div>
@endsection