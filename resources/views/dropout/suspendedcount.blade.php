@extends('layouts.app', ['title' => __('Suspended Trainee Management')])

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
                            <h3 class="mb-0">{{ __('Suspended Trainee Count') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('suspended.index')}}" class="btn btn-sm btn-warning">Suspended
                                Trainees
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>

                    </div>

                </div>
                </form>
                <div class="card-header">
                    <h3 class="mb-0">Suspended Trainee Count By Course
                    </h3>
                </div>
                <div class="ml-4 mr-4">
                    <div class="mr-3 ml-3 mt-4">
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-custom">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Course</th>
                                        <th scope="col">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                    <tr>
                                        <td scope="col">{{$course->course_name}}
                                        </td>
                                        @if ($course->count)
                                        <td scope="col">{{$course->count}}</td>
                                        @else
                                        <td scope="col">0</td>
                                        @endif

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
                    title: @if(isset($date))
                    'Attendance Daily - {{$date}}'
                    @else 'Attendance Daily - {{Carbon\ Carbon::today()->toDateString()}}'
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