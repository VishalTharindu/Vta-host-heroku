@extends('layouts.app', ['title' => __('Application Management')])

@section('content')
@include('layouts.headers.cards')
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">

                    <!------------------------------------------------------------------------------------------------------------------>
                    @if($interviewMode == TRUE)
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0" id="title">{{ __('Interview For Batch : ') }}
                                <strong>{{ $selectedBatch->year . ' / ' . $selectedBatch->batch_no}}</strong></h3>

                            @role('mr|oic')
                            @if(isset($courseName))
                            <h3 class="mb-0" id="title"> No. of selected Applicants for {{ $courseName }} :
                                <strong>{{ $applicants->count() }}</strong></h3>
                            @else
                            <h3 class="mb-0" id="title">{{ __('No. of selected Applicants : ') }}
                                <strong>{{ $applicants->count() }}</strong></h3>
                            @endif
                            @endrole

                            @role('ma')
                            <a href="{{ route('interview.change') }}" class="btn btn-sm btn-light"
                                onclick="confirmChange()">{{ __('Change the batch') }}</a>
                            @if(isset($courseName))
                            <h3 class="mb-0" id="title"> No. of selected Applicants for {{ $courseName }} :
                                <strong>{{ $selectedApplicantCount }}</strong></h3>
                            @else
                            <h3 class="mb-0" id="title">{{ __('No. of selected Applicants : ') }}
                                <strong>{{ $selectedApplicantCount }}</strong></h3>
                            @endif

                            @endrole
                        </div>
                        <div class="col-4 text-right">
                            @role('ma')
                            <a href="{{ route('applicant.create') }}"
                                class="btn btn-sm btn-warning">{{ __('Add New Applicant') }}</a>
                            @endrole
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                data-target="#send">
                                @role('ma')
                                Send To Review
                                @endrole
                                @role('mr')
                                Send To OIC
                                @endrole
                                @role('oic')
                                Confirm
                                @endrole
                            </button>
                        </div>
                    </div>


                    <div class="row align-items-center mt-5">
                        <div class="col-8">
                            <h6 class="heading-small text-muted mb-4">{{ __('Filter According To Course') }}</h6>
                            <form action="{{ route('interview.filterCourse') }}" method="get" class="form-inline">
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
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>

                <!------------------------------------------------------------------------------------------------------------------>
                @if($interviewMode == FALSE)
                <div class="container">
                    <form action="{{ route('interview.select') }}" method="GET">
                        @csrf
                        <div class="form-group">
                            <h2 class="text-center">Please Select the Batch to Start the Interview Process</h2>
                            <select
                                class="list-batches form-control form-control-alternative{{ $errors->has('batch_id') ? ' is-invalid' : '' }}"
                                name="batch_id" value="{{ old('batch_id') }}">


                                @foreach($batches as $batch)
                                <option value="{{ $batch->id }}">
                                    {{ $batch->year }} / {{ $batch->batch_no }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success" type="submit">Start</button>
                        </div>
                    </form>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('NIC No.') }}</th>
                                <th scope="col">{{ __('Address') }}</th>
                                <th scope="col">{{ __('Requested Courses') }}</th>
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Selected') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicants as $applicant)
                            <tr>
                                <td>{{ $applicant->name_with_initials }}</td>
                                <td>{{ $applicant->nic }} </td>
                                <td>{{ $applicant->address }}</td>
                                <td>{{($applicant->courses->count() > 1) ? $applicant->courses[0]->course_name . ' , ' . $applicant->courses[1]->course_name : $applicant->courses[0]->course_name }}
                                </td>
                                <td>{{ $applicant->batch->year . ' / ' . $applicant->batch->batch_no}}</td>

                                <td>
                                    @if($applicant->status == 1)
                                    @if($applicant->rejected_reason == NULL)
                                    <a
                                        class="text-success font-weight-bold">{{ $applicant->course($applicant->selected_course_id)['course_name'] }}</a>
                                    @else
                                    <a class="text-danger font-weight-bold">Rejected</a>
                                    @endif


                                    @elseif(($applicant->status == 0))

                                    <a class="text-danger font-weight-bold">{{ __('No') }}</a>

                                    @endif
                                </td>

                                <td>@if( ($applicant->status == 0 && Auth::user()->hasRole('ma')) ||
                                    (Auth::user()->hasRole('mr') || Auth::user()->hasRole('oic')) )
                                    <button class="btn-sm btn-primary" data-toggle="modal" data-target="#selectModal"
                                        data-id="{{ $applicant->id }}"
                                        data-inname="{{ $applicant->name_with_initials }}"
                                        data-nic="{{ $applicant->nic }}" data-email="{{ $applicant->email }}"
                                        data-gender="{{ $applicant->gender }}"
                                        data-ethnicity="{{ $applicant->ethnicity }}"
                                        data-fullname="{{ $applicant->full_name }}" data-city="{{ $applicant->city }}"
                                        data-reqcourses="{{($applicant->courses->count() > 1) ? $applicant->courses[0]->course_name . ' , ' . $applicant->courses[1]->course_name : $applicant->courses[0]->course_name }}"
                                        data-contact="{{ $applicant->phone_number }}"
                                        data-address="{{ $applicant->address }}"
                                        data-qualification="{{ $applicant->qualification }}"
                                        data-status="{{ $applicant->status }}"
                                        data-batch="{{ $applicant->batch->year . ' / ' . $applicant->batch->batch_no }}">
                                        @role('ma')
                                        {{ __('Select') }}
                                        @endrole
                                        @role('mr|oic')
                                        {{ __('View') }}
                                        @endrole
                                    </button>
                                    @endif

                                </td>
                                @role('ma|mr')
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('applicant.destroy', $applicant) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="dropdown-item"
                                                    href="{{ route('applicant.edit', $applicant) }}">{{ __('Edit') }}</a>
                                                @role('ma')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                    {{ __('Delete') }}
                                                </button>
                                                @endrole
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                @endrole
                                @role('oic')
                                <td class="text-center">
                                    @if($applicant->rejected_reason == NULL)
                                    <button class="btn-sm btn-danger" data-toggle="modal"
                                        data-target="#RejectApplicantModal"
                                        data-id="{{ $applicant->id }}">{{ __('Reject') }}</button>
                                    @else
                                    <form action="{{ route('applicant.reject', $applicant->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                        <button type="button" class="btn-sm btn-warning"
                                            onclick="selectAgain()">{{ __('Select Again') }}</button>
                                    </form>
                                    @endif

                                </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        @if($interviewMode == TRUE)
        <!-------------------------------- Modal To Select the applicant-------------------------------------------------------->
        <div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="selectModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select the Applicant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="selectForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">

                            <div class="form-row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Name With Initials') }}</label>
                                    <input type="text" class="form-control-plaintext in_name" name="in_name" disabled>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Full Name') }}</label>
                                    <input type="text" class="form-control-plaintext fullname" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('NIC No.') }}</label>
                                    <input type="text" class="form-control-plaintext nic" name="nic" disabled>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Email') }}</label>
                                    <input type="text" class="form-control-plaintext email" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Gender') }}</label>
                                    <input type="text" class="form-control-plaintext gender" disabled>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Ethnicity') }}</label>
                                    <input type="text" class="form-control-plaintext ethnicity" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Phone Number') }}</label>
                                    <input type="text" class="form-control-plaintext contact" disabled>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Address') }}</label>
                                    <input type="text" class="form-control-plaintext address" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="form-control-label">{{ __('Qualification') }}</label>
                                    <input type="text" class="form-control-plaintext qualification" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">{{ __('Requested Courses') }}</label>
                                    <input type="text" class="form-control-plaintext reqcourses" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-control-label">batch</label>
                                    <input type="text" class="form-control-plaintext batch" disabled>
                                </div>
                            </div>
                            @role('ma')
                            <div class="form-row view-hide" id="select-course">
                                <div class="form-group col-md-12">
                                    <div class="labe form-control-label">Select the Course</div>
                                    <select
                                        class="list-courses form-control form-control-alternative{{ $errors->has('course_id') ? ' is-invalid' : '' }}"
                                        name="course_id" value="{{ old('course_id') }}">


                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}">
                                            {{ $course->course_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            @endrole
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            @role('ma')
                            <button type="submit" class="btn btn-primary view-hide" id="select-button">Select</button>
                            @endrole
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!----------------------- Modal To Send selected data to MR or OIC------------------------------------------------->
        <div class="modal fade" id="send" tabindex="-1" role="dialog" aria-labelledby="send" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalLabel">Are You Sure??</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @role('ma')
                        Before sending to review make sure you have correctly inserted the interviewee data.
                        @endrole
                        @role('mr')
                        If you are okay with the interview process send the list to OIC to review.
                        @endrole
                        @role('oic')
                        Do you like to give permission for Management Assistant to join these selected applicants as
                        trainees?
                        @endrole
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a type="button" @role('ma') href="{{ route('interview.reviewMR') }}" @endrole @role('mr')
                            href="{{ route('interview.reviewOIC') }}" @endrole @role('oic')
                            href="{{ route('interview.oicConfirm') }}" @endrole class="btn btn-primary">
                            @role('ma|mr')
                            Send To Review
                            @endrole
                            @role('oic')
                            Yes
                            @endrole
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!----------------------- Modal To Send Reject Selected Applicants By OIC------------------------------------------------->
        <div class="modal fade" id="RejectApplicantModal" tabindex="-1" role="dialog" aria-labelledby="send"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are You Sure want To Reject This
                            Selected Trainee??</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post" id="rejectform">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-control-label">{{ __('Reason') }}</label>
                                <textarea
                                    class="form-control form-control-alternative{{ $errors->has('rejected_reason') ? ' is-invalid' : '' }}"
                                    name="rejected_reason" id="exampleFormControlTextarea1" rows="3"
                                    required>{{ old('rejected_reason') }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
    var base_url = '{!!URL::route('index')!!}'

    $(document).ready(function() {
        //$('#selectModal1').modal('show');
        $('.list-courses').select2();
        $('.list-batches').select2();
        $('#filter-courses').select2();

    });

    //Populating data for the modal form
    $('#selectModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)

        //Getting the values when the button click
        var id = button.data('id')
        var in_name = button.data('inname')
        var nic = button.data('nic')
        var email = button.data('email')
        var gender = button.data('gender')
        var ethnicity = button.data('ethnicity')
        var fullname = button.data('fullname')
        var contact = button.data('contact')
        var address = button.data('address')
        var qualification = button.data('qualification')
        var reqcourses = button.data('reqcourses')
        var batch = button.data('batch')
        var modal = $(this)

        //Assign the alues for the form
        modal.find('.in_name').val(in_name)
        modal.find('.nic').val(nic)
        modal.find('.email').val(email)
        modal.find('.gender').val(gender)
        modal.find('.ethnicity').val(ethnicity)
        modal.find('.fullname').val(fullname)
        modal.find('.contact').val(contact)
        modal.find('.address').val(address)
        modal.find('.qualification').val(qualification)
        modal.find('.reqcourses').val(reqcourses)
        modal.find('.batch').val(batch)

        $('.list-courses').val(null).trigger('change');
        //Perform the form action
        var form = document.getElementById('selectForm')
        form.action = 'applicant/select/' + id
    })

    //Geting the aplicant id for rejecting modal (Only a function of OIC)
    $('#RejectApplicantModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)

        //Getting the values when the button click
        var id = button.data('id')
        var modal = $(this)

        //Perform the form action
        var form = document.getElementById('rejectform')
        form.action = base_url + '/applicant/reject/' + id
    })

    function confirmDelete() {
        event.preventDefault();
        var form = event.target.form;
        $.confirm({
            title: 'Delete!',
            content: 'Are you sure you want to delete this?',
            animation: 'zoom',
            closeAnimation: 'scale',
            icon: 'fa fa-trash-alt',
            theme: 'material',
            closeIcon: true,
            type: 'red',
            animateFromElement: false,
            buttons: {
                confirm: function() {
                    $.alert('Deleted');
                    form.submit();
                },
                cancel: function() {
                    $.alert('Canceled');
                }
            }
        });
    }

    function confirmChange() {
        event.preventDefault();
        var form = event.target.form;
        $.confirm({
            title: 'Change!',
            content: 'Are you sure you want to change the batch?',
            animation: 'zoom',
            closeAnimation: 'scale',
            icon: 'fa fa-backspace',
            theme: 'material',
            closeIcon: true,
            type: 'red',
            animateFromElement: false,
            buttons: {
                confirm: function() {
                    location.href = base_url + '/interview/change/'
                },
                cancel: function() {

                }
            }
        });
    }

    function selectAgain() {
        event.preventDefault();
        var form = event.target.form;
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to select this applicant again?',
            buttons: {
                Yes: {
                    btnClass: 'btn-blue',
                    action: function() {
                        form.submit();
                    }
                },
                cancel: function() {},
            }
        });
    }
    </script>
    @include('layouts.footers.auth')
    @endsection