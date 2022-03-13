@extends('layouts.app', ['title' => __('Examination Management')])

@section('content')
@include('layouts.headers.cards')
<style>
    .invalid { border-color: red; }
</style>
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-10">
                            @foreach($requiredSubject as $subject)
                                <h3 class="mb-10"><span>{{ __('Subject : ') }}</span>{{ __($subject->subject_name) }}</h3>  
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>
                <div class="card-body">
                    <div>
                                                  
                    </div>
                    <form action="{{route('mark.subject.trainees.exam')}}" method="post" onsubmit="return validateRule()"  autocomplete="off">
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
                                            <th scope="col">{{ __('Written Mark') }}</th>
                                            <th scope="col">{{ __('Practicle Mark') }}</th>                                            
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <input type="text" name="course" value="{{$requiredCourse}}" hidden>
                                    <input type="text" name="batch" value="{{$requiredBatch}}" hidden>
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
                                            @if(($precentage >= 80) && ($paiedtrainees == 1) && ($status == 1) )
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
                                                                $Wscore = App\Mark::traineeWrittenSubjectsMarks($data->id, $subject->id);
                                                                $Pscore = App\Mark::traineePracticleSubjectsMarks($data->id, $subject->id);
                                                            @endphp
                                                        @endforeach
                                                        <td class="text-success">
                                                            <div class="form-goup">
                                                                <input type="text" class="form-control  form-control-sm text-center written" id="{{ $data->id }}_Wmarks"  name="rows[{{ $data->id }}][Wmarks]" value="{{$Wscore}}" data-parsley-type="number">
                                                            </div>
                                                        </td>
                                                        <td class="text-success">
                                                            <div class="form-goup">
                                                                <input type="text" class="form-control  form-control-sm text-center practicle" id="{{ $data->id }}_Pmarks"  name="rows[{{ $data->id }}][Pmarks]" value="{{$Pscore}}" data-parsley-type="number">
                                                            </div>
                                                        </td>
                                                        @foreach($requiredSubject as $subject)
                                                            <input type="text" name="subject" value="{{ $subject->id }}" hidden>
                                                        @endforeach
                                                        <input type="text" name="type" value="W" hidden>
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
    function validateRule(){
        let written = document.querySelectorAll(".written")
        let practicle = document.querySelectorAll(".practicle")
       
        for (let i = 0; i < written.length; i++) {
            console.log(written[i].value);
            if (written[i].value > 60) {
                written[i].focus();
                $.alert({
                    title: 'Alert!',
                    content: 'Written exam confident level connot exceed 60% limit',
                    animation: 'zoom',
                    closeAnimation: 'scale',
                    icon: 'fa fa-exclamation-triangle',
                    theme: 'material',
                    closeIcon: true,
                    type: 'red',
                });
                return false;           
            }   
        }

        for (let i = 0; i < practicle.length; i++) {
            console.log(practicle[i].value);
            if (practicle[i].value > 40) {
                practicle[i].focus();
                $.alert({
                    title: 'Alert!',
                    content: 'Practicle exam confident level connot exceed 40% limit',
                    animation: 'zoom',
                    closeAnimation: 'scale',
                    icon: 'fa fa-exclamation-triangle',
                    theme: 'material',
                    closeIcon: true,
                    type: 'red',
                });
                return false;
            }   
        }
    }
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