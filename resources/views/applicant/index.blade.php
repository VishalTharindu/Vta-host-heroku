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
                            <h3 class="mb-0" id="title">{{ __('Applicants') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('applicant.create') }}"
                                class="btn btn-sm btn-warning">{{ __('Add New Applicant') }}</a>
                        </div>
                    </div>

                    <!-- Filter Applicants List According to Batch -->
                    <div class="row align-items-center mt-5">
                        <div class="col-8">
                            <h6 class="heading-small text-muted mb-4">{{ __('Filter According to Batch') }}</h6>
                            <form method="GET" action="{{ route('applicant.filterData') }}" autocomplete="off"
                                class="form-inline">
                                @csrf
                                <div class="col-md-4">
                                    <select class="list-batches form-control form-control-sm" name="filterBatch"
                                        id="filter-batches" value="{{ old('batches') }}" data-toggle="select" required
                                        autofocus>

                                        <option value="0">View All</option>
                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" @if(isset($filterBatch) && $batch->id ==
                                            $filterBatch)
                                            selected
                                            @endif>
                                            {{ $batch->year . '/' . $batch->batch_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Filter')
                                    }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--------------------------------------------------------------------------------------------------------->

                    <div class="mt-3">

                        <p>Male: <strong>{{ $maleCount }}</strong> | Female:<strong>{{ $femaleCount }}</strong></p>
                        @role('mr')
                        @if(isset($filterBatch))
                        <form action="{{ route('applicant.applicantsDelete',$filterBatch) }}" method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="applicantsDelete()">Delete
                                Applicants of Batch
                                <strong>{{ $batch->batchName($filterBatch)->year }} /
                                    {{ $batch->batchName($filterBatch)->batch_no }}</strong></button>
                        </form>
                        @endif
                        @endrole
                    </div>
                </div>




                <div class="col-12">
                    @include('partials.status')
                </div>

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
                                <td>{{ $applicant->nic }}</td>
                                <td>{{ $applicant->address }}</td>
                                <td>{{($applicant->courses->count() > 1) ? $applicant->courses[0]->course_name . ' , ' . $applicant->courses[1]->course_name : $applicant->courses[0]->course_name }}
                                </td>
                                <td>{{ $applicant->batch->year . ' / ' . $applicant->batch->batch_no}}</td>
                                <td @if($applicant->status == 1)
                                    class="text-success font-weight-bold"
                                    @elseif(($applicant->status == 0))
                                    class="text-danger font-weight-bold"
                                    @endif>{{ ($applicant->status == 1) ? 'Yes' : 'No' }}</td>
                                <!-- <td>{{ ($applicant->status == 1) ? 'Selected' : 'Not Selected' }}</td> -->
                                <td>
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
                                        data-batch="{{ $applicant->batch->year . ' / ' . $applicant->batch->batch_no }}"
                                        id="main-button">{{ __('View') }}</button>

                                </td>
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
                                                <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-------------------------------- Modal -------------------------------------------------------->
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
                    <div class="modal-body">
                        <form action="" method="POST" id="selectForm">
                            @csrf
                            @method('PUT')
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {

        $('#filter-batches').select2();

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
                    form.submit();
                },
                cancel: function() {
                    $.alert('Canceled');
                }
            }
        });
    }

    function applicantsDelete() {
        event.preventDefault();
        var form = event.target.form;
        $.confirm({
            title: 'Delete!',
            content: 'Are you sure you want to delete applicants of this batch?',
            animation: 'zoom',
            closeAnimation: 'scale',
            icon: 'fa fa-trash-alt',
            theme: 'material',
            closeIcon: true,
            type: 'red',
            animateFromElement: false,
            buttons: {
                confirm: function() {
                    form.submit();
                    $.alert('Deleted');
                },
                cancel: function() {
                    $.alert('Canceled');
                }
            }
        });
    }
    </script>
    @include('layouts.footers.auth')
</div>
@endsection