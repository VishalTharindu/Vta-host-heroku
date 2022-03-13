@extends('layouts.app', ['title' => __('Suspended Trainee Management')])

@section('content')
@include('layouts.headers.cards')
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Suspended Trainees') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('suspended.reconsider.index')}}" class="btn btn-sm btn-warning">Restored
                                Trainees
                                List</a>
                            <a href="{{route('suspended.count')}}" class="btn btn-sm btn-info">Course Count</a>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>

                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('suspended.filter') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Course') }}</label>
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
                                <button type="submit" class="btn btn-sm btn-success px-4 float-right">{{ __('Filter')
                                    }}</button>
                            </div>
                    </div>
                    </form>
                    <p>Male: <strong>{{ $maleCount }}</strong> | Female:<strong>{{ $femaleCount }}</strong></p>

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
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Letter') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
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
                                <td>
                                    @if (App\Dropout::leaveLetterStatus($trainee->id) == 1)
                                    <button class="btn btn-sm btn-dark" data-toggle="modal" data-target="#uploadLetter"
                                        data-id="{{ $trainee->id }}">Upload Letter</button>
                                    @elseif (App\Dropout::leaveLetterStatus($trainee->id) == 2)
                                    <a href="{{asset('storage/leave_letters/'.App\Dropout::returnLeaveLetter($trainee->id))}}"
                                        class="btn-sm btn-dark" target="_blank">View
                                        Letter</a>
                                    @else
                                    <a href="suspended/letter/{{$trainee->id}}" class="btn-sm btn-dark">Generate
                                        Letter</a>
                                    @endif

                                </td>
                                <td>
                                    <a href="suspended/reconsider/{{$trainee->id}}"
                                        class="btn-sm btn-primary">Reconsider</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!---------------------------------------- Modal to enter the company details to issue the letter---------------------------------------->
        <div class="modal fade" id="uploadLetter" tabindex="-1" role="dialog" aria-labelledby="uploadLetter"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="post" id="letterForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Printed Letter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="text" name="trainee_id" id="trainee_id" hidden>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Letter</label>
                                <input type="file" name="letter" class="form-control" id="letter"
                                    aria-describedby="emailHelp" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="uploadLetter()">Upload
                                Letter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var base_url = '{!!URL::route('index')!!}'
        var traineeID = 0
        function uploadLetter() {

            //get the unique id of the elements toggle the styles
          var issued = document.getElementById('issued' + traineeID);
          var notIssued = document.getElementById('notIssued' + traineeID);

          issued.style.display = "block";
          notIssued.style.display = "none";
          $('#uploadLetter').modal('hide');

        }
        
        //Populating data for the modal form
        $('#uploadLetter').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            //Getting the id of the trainee
            var trainee = button.data('id')
            var modal = $(this)
            $('#trainee_id').val(trainee)
            //Perform the form action
            var form = document.getElementById('letterForm')
            form.action = base_url + '/suspended/leave/letter/'
        })
    </script>
    <script>
        $(document).ready(function() {

            $('#filter-courses').select2();
            $('#filter-batches').select2();

        });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection