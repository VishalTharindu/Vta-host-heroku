@extends('layouts.app', ['title' => __('Implant Training Management')])

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
                            <h3 class="mb-0">{{ __('Implant Training - Letters') }}</h3>
                        </div>
                    </div>
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
                <div class="card-body">
                    <div>
                        <form method="get" action="{{ route('implantTraining.filterData') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Courses') }}</label>
                                        <select class="list-courses form-control form-control-sm" name="filterCourse"
                                            id="filter-courses" value="{{ old('course') }}" data-toggle="select"
                                            required autofocus>

                                            <option value="0">View All</option>
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @if(isset($filterCourse) && $course->id ==
                                                $filterCourse)
                                                selected
                                                @endif>
                                                {{ $course->course_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Batch') }}</label>
                                        <select class="list-batches form-control form-control-sm" name="filterBatch"
                                            id="filter-batches" value="{{ old('batches') }}" data-toggle="select"
                                            required autofocus>

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
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-primary px-4 float-right">{{ __('Filter')
                                    }}</button>
                            </div>
                    </div>
                    </form>
                    @if (isset($letterNeeded) && $letterNeeded > 0)
                    <p>There are still <strong>{{$letterNeeded}}</strong> Trainees of
                        <strong>{{$cName->course_name}}</strong> batch <strong>{{$bName->year}} /
                            {{$bName->batch_no}}</strong> to send the letters</p>
                    @endif
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
                                <th scope="col">Letter Issued</th>
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
                                    @if ($trainee->ojt_letter_issued == 1)
                                    <a class="text-success font-weight-bold">Yes</a>
                                    <a id="issued{{$trainee->id}}" style="display:none;" hidden>Yes</a>
                                    <a id="notIssued{{$trainee->id}}" hidden>No</a>
                                    @else
                                    <a id="issued{{$trainee->id}}" style="display:none;"
                                        class="text-success font-weight-bold">Yes</a>
                                    <a id="notIssued{{$trainee->id}}" class="text-danger font-weight-bold">No</a>
                                    @endif

                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#issueLetter" data-id="{{ $trainee->id }}">Send</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!---------------------------------------- Modal to enter the company details to issue the letter---------------------------------------->
        <div class="modal fade" id="issueLetter" tabindex="-1" role="dialog" aria-labelledby="issueLetter"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="post" id="letterForm">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Enter Company Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Receiver's Name</label>
                                <input type="text" name="receiver_name" class="form-control" id="receiver_name"
                                    aria-describedby="emailHelp" placeholder="Enter the name of the receiver">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company Address</label>
                                <input type="text" name="company_address" class="form-control" id="company_address"
                                    aria-describedby="address" placeholder="Enter the address using commas">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="issueLetter()">Make PDF</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var base_url = '{!!URL::route('index')!!}'
        var traineeID = 0
        function issueLetter() {

            //get the unique id of the elements toggle the styles
          var issued = document.getElementById('issued' + traineeID);
          var notIssued = document.getElementById('notIssued' + traineeID);

          issued.style.display = "block";
          notIssued.style.display = "none";
          $('#issueLetter').modal('hide');

        }

        //Populating data for the modal form
        $('#issueLetter').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            traineeID = button.data('id')
            //Getting the id of the trainee
            var trainee = button.data('id')
            var modal = $(this)
            
            //Perform the form action
            var form = document.getElementById('letterForm')
            form.action = base_url + '/implantTraining/generatePdf/' + trainee
        })
    </script>
    @include('layouts.footers.auth')
</div>
@endsection