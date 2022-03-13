@extends('layouts.app', ['title' => __('Implant Training Management')])

@section('content')
@include('layouts.headers.cards')
<div class="my-5"></div>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">

                    {{------------------------------Batch and Course is selected--------------------------}}
                    @if ($selected == true)
                    <div class="row align-items-center">
                        <div class="col-8">
                            <a href="{{route('implantTraining.change')}}" class="btn btn-sm btn-light">Change the Batch
                                and Course</a>
                            <h3 class="mb-0">{{ __('Implant Training - OJT Form') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('implantTraining.generateForm')}}"
                                class="btn btn-sm btn-warning">{{ __('Create Form') }}</a>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{------------------------------Select the batch and course to continue and fill the OJT form data--------------------------}}
                @if ($selected == false)
                <div class="container">
                    <form action="{{ route('implantTraining.filterBatchAndCourse') }}" method="GET">
                        @csrf
                        <h2 class="text-center">Please Select the Batch and Course to continue</h2>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Batch">Batch</label>
                                <select
                                    class="list-batches form-control form-control-alternative{{ $errors->has('batch_id') ? ' is-invalid' : '' }}"
                                    name="batch_id" value="{{ old('batch_id') }}" required>

                                    <option></option>
                                    @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}">
                                        {{ $batch->year }} / {{ $batch->batch_no }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Course">Course</label>
                                <select
                                    class="list-batches form-control form-control-alternative{{ $errors->has('course_id') ? ' is-invalid' : '' }}"
                                    name="course_id" value="{{ old('course_id') }}" required>

                                    <option></option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->course_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-success" type="submit">Select</button>
                        </div>
                    </form>
                </div>
                @else
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
                                <th scope="col">Action</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainees as $trainee)
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
                                <td class="text-center">
                                    @if ($trainee->training_institute_id == NULL)
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#trainingDetails" data-id="{{ $trainee->id }}">Add</button>
                                    @else
                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#trainingDetails" data-id="{{ $trainee->id }}"
                                        data-startdate="{{ $trainee->ojt_start_date }}"
                                        data-enddate="{{ $trainee->ojt_end_date }}"
                                        data-company="{{ $trainee->training_institute_id }}">Edit or View</button>
                                    @endif

                                </td>
                                <td class="text-center">

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>

        <!---------------------------------------- Modal to enter the company details to issue the letter---------------------------------------->
        @if ($selected == true)
        <div class="modal fade" id="trainingDetails" tabindex="-1" role="dialog" aria-labelledby="trainingDetails"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="post" id="trainingForm">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Enter Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Training Start Date</label>
                                    <input class="form-control datepicker form-control-sm startdate" name="start_date"
                                        placeholder="Select date" value="" type="text" id="start_date"
                                        data-date-format="yyyy-mm-dd">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">Training End Date</label>
                                    <input class="form-control datepicker form-control-sm enddate" name="end_date"
                                        placeholder="Select date" value="" type="text" id="end_date"
                                        data-date-format="yyyy-mm-dd">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Company</label>
                                <select id="list-institutes"
                                    class="list-institutes company form-control form-control-alternative{{ $errors->has('traineeInstitute_id') ? ' is-invalid' : '' }}"
                                    name="traineeInstitute_id" value="{{ old('traineeInstitute_id') }}" required>

                                    <option></option>
                                    @foreach($traineeInstitutes as $traineeInstitute)
                                    <option value="{{ $traineeInstitute->id }}">
                                        {{ $traineeInstitute->name }} | {{ $traineeInstitute->address }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
    <script>
        $(document).ready(function() {
        
            $('.list-courses').select2();
            $('.list-batches').select2();
            $('.list-institutes').select2();

        });
        var base_url = '{!!URL::route('index')!!}'
        var trainee = 0
        //Populating data for the modal form
        $('#trainingDetails').on('show.bs.modal', function(event) {

            if(event.relatedTarget != null ){
                var button = $(event.relatedTarget)
                trainee = button.data('id')
                startdate = button.data('startdate')
                var enddate = button.data('enddate')
                var company = button.data('company')
                var modal = $(this)
                
                modal.find('.startdate').val(startdate)
                modal.find('.enddate').val(enddate)
                $('#list-institutes').val(company).trigger('change');
            }
            
            //Perform the form action
            var form = document.getElementById('trainingForm')
            form.action = base_url + '/implantTraining/trainingDetails/' + trainee
        })
    </script>
    @include('layouts.footers.auth')
</div>
@endsection