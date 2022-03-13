
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
                            @if(isset($requiredSubject))
                                @foreach($requiredSubject as $subject)
                                    <h3 class="mb-10"><span>{{ __('Subject : ') }}</span>{{ __($subject->subject_name) }}</h3>  
                                @endforeach
                             @else
                             <h3 class="mb-10">{{ __('Subjects Results') }}</h3>   
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
                        <form method="post" action="{{route('course.subject.result')}}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">                                                           
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">Batch</label>
                                        <select
                                            class="list-year form-control form-control-alternative{{ $errors->has('year') ? ' is-invalid' : '' }}"
                                            name="batch" id="input-years" value="{{ old('year') }}" data-toggle="select"
                                            required autofocus>

                                            @foreach($batchs as $batch)
                                            <option value="{{ $batch->id }}" {{in_array($batch->id ,old("batch")?: 
                                                []) ?
                                                "selected" : "" }}>
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
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Course') }}</label>
                                        <select
                                            class="list-batches form-control form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }} dynamic" data-dependent="id"
                                            name="course" id="course_id" value="{{ old('course') }}" data-toggle="select"
                                            required autofocus>
                                            <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{in_array($course->id, old("course") ?:
                                                []) ?
                                                "selected": ""}}>
                                                {{ $course->course_name}}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('fund'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fund') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols3Input">Subject</label>
                                        <select
                                            class="list-year form-control form-control-alternative{{ $errors->has('year') ? ' is-invalid' : '' }} "
                                            name="subjects" id="id" value="{{ old('year') }} " data-toggle="select"
                                            required autofocus>
                                            
                                            <option value="">Select Subject</option>

                                        </select>
                                        @if ($errors->has('batch'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('batch') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                {{ csrf_field() }}                             
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
                                @isset($requiredSubject)
                                    @foreach($requiredSubject as $subject)
                                    @php
                                        $subjectfail = App\Mark::calculateSubjectFailPresentage($subject->id, $requiredBatch)
                                    @endphp

                                    @php
                                        $subjectpass = App\Mark::calculateSubjectPassPresentage($subject->id, $requiredBatch)
                                    @endphp
                                    <div class="col-md-4">
                                        <h6 class="heading-small text-muted mb-4">{{ __('Pass : ') }} <span class="text-success">{{$subjectpass}}%</span> </h6>
                                        <h6 class="heading-small text-muted mb-4">{{ __('Fail : ') }} <span class="text-danger">{{$subjectfail}}%</span> </h6>
                                    </div>
                                    @endforeach
                                @endisset         
                            </div>
                        </div>                           
                    </div>                  
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
                                        <th scope="col">{{ __('Attempt') }}</th>
                                        <th scope="col">{{ __('Confident') }}</th>
                                        <th scope="col">{{ __('Action') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($trainees)
                                        @foreach ($trainees as $data)
                                            @php
                                            $precentage = App\Attendance::calculateAttendanceEligibility($data->id);

                                            $subjectmatch = App\Subject::matchTraineeSubject($data->course->id, $subject);

                                            $status = App\Examination::traineePassFailStatus($data->id);

                                            $attempt = App\Examination::traineeCurrentAttempt($data->id);

                                            $paiedtrainees = App\ExaminationPayment::paiedTrainess($data->id);

                                            @endphp
                                            @if(($precentage >= 80) && ($paiedtrainees == 1))
                                                @if($subjectmatch = "True")
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
                                                        <td class="text-center">{{$attempt}}</td>
                                                        @foreach($requiredSubject as $subject)
                                                            @php
                                                                $score = App\Mark::traineeConfidentLevel($data->id, $subject->id);
                                                            @endphp
                                                        @endforeach
                                                        <td class="text-success">
                                                            {{$score}} %
                                                        </td>                                                                                                                                                                     
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
                                            @endif                                                   
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                  
            </div>

        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function(){

        $('.dynamic').change(function(){
            if($(this).val() != '')
            {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('course.subject.fetch') }}",
                    method:"GET",
                    data:{select:select, value:value, _token:_token, dependent:dependent},
                    success:function(result)
                    {
                    $('#'+dependent).html(result);
                    console.log(result);
                    }

                })
                }
            });

            $('#country').change(function(){
            $('#state').val('');
            $('#city').val('');
            });

            $('#state').change(function(){
            $('#city').val('');
        });
    

    });
</script>
<!-- <script>
    $(document).ready(function() {
        $('#input-batches').select2();
        $('#input-courses').select2();
        $('#input-years').select2();
        $('#input-months').select2();
    });
</script> -->
@include('layouts.footers.auth')
</div>
@endsection