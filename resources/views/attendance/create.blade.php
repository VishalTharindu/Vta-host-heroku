@extends('layouts.app', ['title' => __( Carbon\Carbon::now()->toDateString() .' - '. $courseDetails->course_name . ' - '
.
$batchDetails->year . ':' .
$batchDetails->batch_no)])

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
                            <h3 class="mb-0">{{ __('Attendance ' . Carbon\Carbon::now()->toDateString() .' - '.
                                $courseDetails->course_name . ' - ' .
                                $batchDetails->year . ' : ' .
                                $batchDetails->batch_no) . ' - ' . $type }} </h3>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{__('Attendance')}}</th>
                                <th></th>
                                <th scope="col">{{ __('Trainee Name') }}</th>
                                <th scope="col">{{ __('NIC') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="custom-control custom-checkbox ml-4 my-2">
                                <input class="custom-control-input" id="ckbCheckAll" type="checkbox">
                                <label class="custom-control-label select-all" for="ckbCheckAll">Select All
                                    Trainees</label>
                            </div>
                            <form action="{{ route('attendance.store') }}" method="post">
                                @csrf
                                <input type="datetime" name="datetime" value="{{Carbon\Carbon::now()}}" hidden>
                                <input type="text" name="batch" value="{{$batchDetails->id}}" hidden>
                                <input type="text" name="course" value="{{$courseDetails->id}}" hidden>
                                <input type="text" name="type" value="{{$type}}" hidden>
                                @foreach ($trainees as $trainee)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox ml-4">
                                            <input class="custom-control-input checkBoxClass" name="attendance[]"
                                                id="{{$trainee->id}}" value="{{$trainee->id}}" type="checkbox"
                                                @isset($todayAttendancesIds)
                                                @if(in_array($trainee->id,$todayAttendancesIds))
                                            checked
                                            @endif

                                            @endisset>
                                            <label class="custom-control-label" for="{{$trainee->id}}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        @if($trainee->image)
                                        <span class="avatar rounded-circle">
                                            <img src="{{asset('storage/'.$trainee->image)}}" width="50px" height="50px"
                                                alt="" class="rounded-circle">
                                        </span>
                                        @else
                                        <span class="avatar rounded-circle">
                                            <img src="{{asset('images/no_image.png')}}" alt="">
                                        </span>
                                        @endif
                                    </td>
                                    <td>{{ $trainee->name_with_initials }}</td>
                                    <td>
                                        {{ $trainee->nic }}
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    <div class="text-center my-3">
                        <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Save Attendance') }} (Total <span
                                class="totalchecked">0</span>)</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (isset($log))
    <script>
        $(window).on('load', function() {
            $.confirm({
                title: 'Attendance is already taken',
                content: '{{$log->type . " attendance is already taken at " . $log->updated_at . " by " . App\User::getUserName($log->user_id)}}',
                type: 'dark',
                theme: 'modern',
                buttons: {
                    omg: {
                        text: 'mark again',
                        btnClass: 'btn-dark',
                    },
                    back: function() {
                        window.location.href = "/attendance";
                    }
                }
            });
        });
    </script>
    @endif
    <script>
        $(document).ready(function() {
            $("#ckbCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function() {
                if (!$(this).prop("checked")) {
                    $("#ckbCheckAll").prop("checked", false);
                }
            });
        });
    </script>
    <script>
        //initial page load return count
        $('input[name="attendance[]"]').ready(function() {
            var number = $('input[name="attendance[]"]:checked').length;
            $('.totalchecked').html(number);
        });
        //update the count on change
        $('input[name="attendance[]"]').change(function() {
            var number = $('input[name="attendance[]"]:checked').length;
            $('.totalchecked').html(number);
        });
        //select all checkbox
        $('.select-all').click(function() {
            var number = $('input[name="attendance[]"]:not(:checked)').length;
            $('.totalchecked').html(number);
        });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection