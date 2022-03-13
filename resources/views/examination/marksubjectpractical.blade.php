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
                                <h3 class="mb-10">{{ __('Mark Subjects(Practical)') }}</h3> 
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                        <form method="post" action="{{route('course.subject.practical.trainee')}}" autocomplete="off">
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
                    </div>
                    <form action="{{route('mark.subject.practical.trainees.exam')}}" method="post"  autocomplete="off">
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
                                            <th scope="col">{{ __('Mark') }}</th>                                           
                                            <th scope="col">{{ __('Action') }}</th>
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
                                            $subjectmatch = App\Subject::matchTraineeSubject($data->course->id, $subject);

                                            $attempt = App\Examination::traineeCurrentAttempt($data->id);

                                            $status = App\Examination::traineePracticlStatus($data->id);

                                            @endphp
                                            @if($subjectmatch = "True" && $status == 0)
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
                                                            $score = App\Mark::traineeSubjectsPracticalMarks($data->id, $subject->id);
                                                        @endphp
                                                    @endforeach
                                                    <td class="text-success">
                                                        <div class="form-goup">
                                                            <input type="text" class="form-control  form-control-sm text-center" id="{{ $data->id }}_marks"  name="rows[{{ $data->id }}][marks]" value="{{$score}}" data-parsley-type="number">
                                                        </div>
                                                    </td>
                                                    @foreach($requiredSubject as $subject)
                                                        <input type="text" name="subject" value="{{ $subject->id }}" hidden>
                                                    @endforeach
                                                    <input type="text" name="type" value="P" hidden>                                                                                                                                                                     
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
@include('layouts.footers.auth')
</div>
@endsection