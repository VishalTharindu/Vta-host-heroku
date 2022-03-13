@extends('layouts.app', ['title' => __('Application Management')])

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

                            @if(isset($trainees))
                            <h3 class="mb-0" id="title">{{ __('Newly Selected Trainee Details') }}</h3>
                            <a type="button" href="{{ route('interview.rejected') }}"
                                class="btn-sm btn-danger text-right">View OIC Rejected List</a>
                            @endif
                            @if(isset($applicants))
                            <h3 class="mb-0" id="title">{{ __('OIC Rejected List') }}</h3>
                            <a type="button" href="{{ route('interview.updateTrainee') }}"
                                class="btn-sm btn-success text-right">View OIC Approved List</a>
                            @endif

                        </div>
                        <div class="col-4 text-right">

                            @if(isset($trainees))
                            <form action="{{route('trainee.finishUpdate')}}" method="GET" id="finishProcess">
                                <button type="submit" class="btn btn-sm btn-success"
                                    onclick="finishProcess()">{{ __('Finish the Process') }}</button>
                            </form>
                            @endif

                        </div>
                    </div>
                    @if(isset($trainees))
                    <div class="row align-items-center mt-5">
                        <div class="col-8">
                            <h6 class="heading-small text-muted mb-4">{{ __('Filter According To Course') }}</h6>
                            <form action="{{ route('interview.filterCourse') }}" method="GET" class="form-inline">
                                @csrf
                                <div class="col-md-4">
                                    <select class="form-control form-control-sm form-control-alternative"
                                        name="filtercourse" id="filter-courses" data-toggle="select" required autofocus>
                                        <option value="0">View All</option>
                                        @foreach($courses as $course)
                                        <option type="submit" value="{{ $course->id }}" @if(isset($filteredCourse) &&
                                            $course->id == $filteredCourse)
                                            selected
                                            @endif>
                                            {{ $course->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-12">
                    @include('partials.status')
                    @if ($errors->any())
                    @endif
                </div>

                <!-----------------------OIC Approved List in the interview process ------------------------- -->
                @if(isset($trainees))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Phone Number') }}</th>
                                <th scope="col">{{ __('Address') }}</th>
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Selected') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainees as $trainee)
                            <tr>
                                <td>
                                    @if($trainee->image)
                                    <span>
                                        <img src="{{asset('storage/'.$trainee->image)}}" width="50px" height="50px" alt="" class="rounded-circle">
                                    </span>
                                    @else
                                    <span class="avatar rounded-circle">
                                        <img src="{{asset('images/no_image.png')}}" alt="">
                                    </span>
                                    @endif
                                </td>
                                <td>{{ $trainee->name_with_initials }}</td>
                                <td>{{ $trainee->phone_number }}</td>
                                <td>{{ $trainee->address }}</td>
                                <td>{{ $trainee->batch->year . ' / ' . $trainee->batch->batch_no}}</td>

                                <td>{{ $trainee->course->course_name }}</td>

                                <td>
                                    @if($trainee->enrollment_no == NULL)
                                    <a type="button" href="{{ route('trainee.edit' , $trainee) }}"
                                        class="btn btn-sm btn-primary">
                                        {{ __('Fill') }}
                                    </a>

                                    @else
                                    <span class="text-success">Done</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$trainee->enrollment_no == NULL)
                                    <a type="button" href="{{ route('trainee.edit' , $trainee) }}"
                                        class="btn btn-sm btn-light">
                                        {{ __('Edit') }}
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <!------------------------------------------------------------------------------------------------>

                <!-----------------------OIC Rejected List in the interview process ------------------------- -->
                @if(isset($applicants))
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('NIC') }}</th>
                                <th scope="col">{{ __('Rejected Reason') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicants as $applicant)
                            <tr>
                                <td>{{ $applicant->name_with_initials }}</td>
                                <td>{{ $applicant->nic }}</td>
                                <td>{{ $applicant->rejected_reason }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <!------------------------------------------------------------------------------------------------>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    //$('#selectModal1').modal('show');
    $('.list-gender').select2();
    $('#filter-courses').select2();
    $('.list-ethnicity').select2();


});

function finishProcess() {
    event.preventDefault();
    var form = event.target.form;
    $.confirm({
        title: 'Finish!',
        content: 'Are you sure you want finish the update process?',
        animation: 'zoom',
        closeAnimation: 'scale',
        icon: 'fa fa-trash-success',
        theme: 'material',
        closeIcon: true,
        type: 'red',
        animateFromElement: false,
        buttons: {
            confirm: function() {
                form.submit();
            },
            cancel: function() {
                $.alert('Canceled');
            }
        }
    });
}
</script>
@include('layouts.footers.auth')
@endsection