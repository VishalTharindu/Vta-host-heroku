@extends('layouts.app', ['title' => __('Restored Trainees List')])

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
                            <h3 class="mb-0">{{ __('Restored Trainees List') }}</h3>
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
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">{{ __('Enrollment No') }}</th>
                                <th scope="col">{{ __('Name With Initials') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Phone Number') }}</th>
                                <th scope="col">{{ __('Course') }}</th>
                                <th scope="col">{{ __('batch') }}</th>
                                <th>Medical Report</th>
                                <th>Other Report</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($restoreRecords as $restoreRecord)
                            @php
                            $trainee = App\Dropout::getTrainneRecord($restoreRecord->trainee_id);
                            @endphp
                            <tr>
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
                                <td>{{ $trainee->enrollment_no }}</td>
                                <td>{{ $trainee->name_with_initials }}</td>
                                <td>{{ $trainee->email }}</td>
                                <td>{{ $trainee->phone_number }}</td>
                                <td>{{ $trainee->course->course_name }}</td>
                                <td>{{ $trainee->batch->year . ' / ' . $trainee->batch->batch_no}}</td>
                                <td><a href="{{asset('storage/medical_reports/'.$restoreRecord->medical_report)}}"
                                        target="_blank">View</a>
                                </td>
                                <td>
                                    @if ($restoreRecord->other_report != 'NULL')
                                    <a href="{{asset('storage/medical_reports_other/'.$restoreRecord->other_report)}}"
                                        target="_blank">View</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#filter-courses').select2();
            $('#filter-batches').select2();

        });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection