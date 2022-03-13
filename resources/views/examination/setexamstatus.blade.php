@extends('layouts.app', ['title' => __('Examination Management')])

@section('content')
@include('layouts.headers.cards')
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-10">
                             <h3 class="mb-10">{{ __('Mark Final Result') }}</h3>   
                        </div>
                        <div class="col-2">
                            @isset($recount)
                            <h4 class="mb-0 d-flex justify-content-center">Total Count :{{$recount}}</h4>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('mark.trainee.finel.result.view') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Course') }}</label>
                                        <select
                                            class="list-batches form-control form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }}"
                                            name="course" id="input-batches" value="{{ old('course') }}"
                                            data-toggle="select" required autofocus>

                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{in_array($course->id, old("course") ?:
                                                []) ?
                                                "selected": ""}}>
                                                {{ $course->course_name}}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('course'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">Batch</label>
                                        <select
                                            class="list-year form-control form-control-alternative{{ $errors->has('batch') ? ' is-invalid' : '' }}"
                                            name="batch" id="input-years" value="{{ old('batch') }}" data-toggle="select"
                                            required autofocus>

                                            @foreach($batchs as $batch)
                                            <option value="{{ $batch->id }}" {{in_array($batch,
                                                old("id")?: []) ? "selected" : "" }}>
                                                {{ $batch->year . ' / ' . $batch->batch_no}}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('batch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('batch') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>                              
                                <div class="col-md-3">
                                <div class="my-4"></div>
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success  float-left">{{ __('Search')
                                            }}</button>
                                        </div>                                              
                                    </div>
                                </div>
                            </div>
                        </form>                           
                    </div>
                    <form action="{{route('trainee.exam.mark.result')}}" method="post"  autocomplete="off">
                        @csrf
                        <div class="mr-3 ml-3 mt-4">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush" id="datatable-buttons">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('NIC') }}</th>
                                            <th scope="col">{{ __('Phone Number') }}</th>
                                            <th scope="col">{{ __('Address') }}</th>
                                            <th scope="col">{{ __('Courses') }}</th>
                                            <th scope="col">{{ __('Batch') }}</th>
                                            <th scope="col">{{ __('Remaining Attempt') }}</th>
                                            <th scope="col">{{ __('Confident Level') }}</th>
                                            <th scope="col">{{ __('Pass/Fail') }}</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    @isset($requiredCourse)
                                    <input type="text" name="course" value="{{$requiredCourse}}" hidden>
                                    @endisset
                                    @isset($requiredBatch)
                                    <input type="text" name="batch" value="{{$requiredBatch}}" hidden>
                                    @endisset
                                    <tbody>
                                    @isset($trainees)
                                        @foreach ($trainees as $data)
                                            @php
                                            $precentage = App\Attendance::calculateAttendanceEligibility($data->id);

                                            $status = App\Examination::traineePassFailStatus($data->id);

                                            $attempt = App\Examination::traineeCurrentAttempt($data->id);

                                            $paiedtrainees = App\ExaminationPayment::paiedTrainess($data->id);

                                            $totstatus = 0

                                            @endphp
                                            @if(($precentage >= 80) && ($paiedtrainees == 1) && ($status == 1) )
                                                <tr>
                                                    <td>{{ $data->name_with_initials }}</td>
                                                    <td>{{ $data->nic }}</td>
                                                    <td>
                                                        {{ $data->phone_number }}
                                                    </td>
                                                    <td>{{ $data->address }}</td>
                                                    <td>{{ $data->course->course_name }}
                                                    </td>
                                                    <td>{{ $data->batch->year . ' / ' . $data->batch->batch_no}}</td>
                                                    @if($attempt == 0)
                                                        <td class="text-danger text-center">{{$attempt}}</td>
                                                    @else
                                                        <td class="text-success text-center">{{$attempt}}</td>
                                                    @endif
                                                    <td class="text-right">
                                                        <div class="dropdown">
                                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-chevron-down"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">                                                         
                                                            @foreach($subjects as $subject)
                                                                @php                                                              
                                                                    $score = App\Mark::traineeConfidentLevel($data->id, $subject->id);                                                                  
                                                                @endphp

                                                                @if($score >= 80)
                                                                    @php
                                                                        $totstatus += 1
                                                                    @endphp
                                                                @endif
                                                                <p class="dropdown-item">{{$subject->subject_name}}  :  
                                                                    <span>
                                                                        {{$score}}%
                                                                    </span>
                                                                </p>
                                                            @endforeach
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td class="text-success">
                                                        @if ($totstatus == $subjectCount)
                                                            <div class="custom-control">
                                                                <label class="custom-toggle">
                                                                <input type="checkbox" name="status[]" value="{{$data->id}}">
                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="custom-control">
                                                                <label class="custom-toggle">
                                                                <input type="checkbox" name="status[]" value="{{$data->id}}" disabled>
                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <input type="text" class="form-control  form-control-sm" id="{{ $data->id }}_attempt"  name="rows[{{ $data->id }}][attempt]" value="{{$attempt}}" data-parsley-type="number" hidden>
                                                    <td class="text-right">
                                                        <div class="dropdown">
                                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <!-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                                <form action="" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <a class="dropdown-item"
                                                                        href="">{{ __('Edit') }}</a>
                                                                    <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                                        {{ __('Delete') }}
                                                                    </button>
                                                                </form>
                                                            </div> -->
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif                                                  
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                                <div class="text-center my-3">
                                    <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Save Result') }}</button>
                                </div>
                            </div>
                        </div>                      
                    </form>                  
                </div>                  
            </div>

        </div>
    </div>
    <div class="modal fade" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="selectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select the trainee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="get" id="selectForm">
                        @csrf
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
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="labe form-control-label">Selected Course</div>
                                <input type="text" class="form-control-plaintext reqcourses" disabled>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-8 col-8">
                                <small
                                    class="d-block text-uppercase font-weight-bold mb-4 d-flex justify-content-center">Samurdi
                                    Document</small>
                                <div class="d-flex justify-content-center">
                                    <span class="zoom" id="ex3">
                                        <img src="/images/course_1.jpg" alt="Rounded image"
                                            class="img-fluid rounded shadow-lg p-3 mb-5 bg-secondry rounded"
                                            style="width: 100%;">
                                    </span>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#input-batches').select2();
        $('#input-courses').select2();
        $('#input-years').select2();
        $('#input-months').select2();
    });
</script>
@include('layouts.footers.auth')
</div>
@endsection