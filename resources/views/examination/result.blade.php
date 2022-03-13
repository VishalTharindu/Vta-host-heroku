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
                            @if(isset($courses))
                                @isset($requiredCourse)
                                    @foreach($courses as $course)
                                        @if(($course->id) == $requiredCourse)
                                        <h3 class="mb-10">{{ __('Exam Final Result : ') }}<span class="text-primary">{{ $course->course_name }}</span></h3>
                                        @endif
                                    @endforeach
                                @endisset
                             @else
                             <h3 class="mb-10">{{ __('Exam Final Result') }}</h3>   
                            @endisset
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
                        <form method="post" action="{{ route('trainee.finel.result') }}" autocomplete="off">
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
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="heading">{{ __('Overall Result') }}</h5>
                                @isset($pass)
                                    <h6 class="heading-small text-muted mb-4">{{ __('Pass :') }} <span class="text-success">{{$pass}}%</span> </h6>
                                @endisset
                                @isset($fail)
                                    <h6 class="heading-small text-muted mb-4">{{ __('Fail :') }} <span class="text-danger">{{$fail}}%</span> </h6>
                                @endisset        
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    @isset($subjects)
                                        @foreach($subjects as $subject)
                                        @php
                                            $subjectfail = App\Mark::calculateSubjectFailPresentage($subject->id, $requiredBatch)
                                        @endphp

                                        @php
                                            $subjectpass = App\Mark::calculateSubjectPassPresentage($subject->id, $requiredBatch)
                                        @endphp
                                        <div class="col-md-4">
                                            <h5 class="heading">{{ __($subject->subject_name) }}</h5>
                                            <h6 class="heading-small text-muted mb-4">{{ __('Pass : ') }} <span class="text-success">{{$subjectpass}}%</span> </h6>
                                            <h6 class="heading-small text-muted mb-4">{{ __('Fail : ') }} <span class="text-danger">{{$subjectfail}}%</span> </h6>
                                        </div>
                                        @endforeach
                                    @endisset                                        
                                </div>
                            </div>                        
                        </div>                           
                    </div>
                    <form action="{{route('trainee.exam.mark.result')}}" method="post"  autocomplete="off">
                        @csrf
                        <div class="mr-3 ml-3 mt-4">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush" id="datatable-custom">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Student ID') }}</th>
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
                                            $pass = App\Examination::calculatePassPrecentage($requiredCourse, $requiredBatch);

                                            $status = App\Examination::traineePassFailStatus($data->id);

                                            $crtstatus = App\Examination::traineeCurrentStatus($data->id);

                                            $attempt = App\Examination::traineeCurrentAttempt($data->id);

                                            @endphp
                                                @if($crtstatus == 1)
                                                    <tr>
                                                        <td>{{ $data->name_with_initials }}</td>
                                                        <td>{{ $data->enrollment_no }}</td>
                                                        <td>{{ $data->nic }}</td>
                                                        <td>
                                                            {{ $data->phone_number }}
                                                        </td>
                                                        <td>{{ $data->address }}</td>
                                                        <td>{{ $data->course->course_name }}
                                                        </td>
                                                        <td>{{ $data->batch->year . ' / ' . $data->batch->batch_no}}</td>
                                                        @if($attempt == 0)
                                                            <td class="text-danger">{{$attempt}}</td>
                                                        @else
                                                            <td class="text-success">{{$attempt}}</td>
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
                                                                    <p class="dropdown-item">{{$subject->subject_name}}  :  
                                                                        <span>
                                                                            {{$score}}
                                                                        </span>
                                                                    </p>
                                                                @endforeach
                                                                </div>

                                                            </div>
                                                        </td>
                                                        @if($status == 1)
                                                        <td class="text-danger">Non-Confident</td>
                                                        @else
                                                        <td class="text-success">Confident</td>
                                                        @endif
                                                        <input type="text" class="form-control  form-control-sm" id="{{ $data->id }}_attempt"  name="rows[{{ $data->id }}][attempt]" value="{{$attempt}}" data-parsley-type="number" hidden>
                                                        <td class="text-right">                                                            
                                                        </td>
                                                    </tr>
                                                @endif                                                  
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>                      
                    </form>                  
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
                    orientation: 'landscape',
                    pageSize: 'A4',
                    title:
                    @if (isset($requiredCourse))
                        'Written Exam Result :: {{$reCourseName}} {{$reBatchName->year}} /{{$reBatchName->batch_no}} Batch'
                    @else
                        'Written Exam Result'
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