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
                    <form action="{{route('preassesment.mark.subject.trainees')}}" method="post"  autocomplete="off">
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
                                            <th scope="col">{{ __('Mark') }}</th>                                           
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

                                            $status = App\PreAssesmentRsult::traineeFirsttimeEligibility($data->id);

                                            @endphp
                                            @if($precentage >= 80)
                                                @if($status == 1)
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
                                                            @foreach($requiredSubject as $subject)
                                                                @php
                                                                    $score = App\PreAssesmentMark::traineeSubjectsMarks($data->id, $subject->id);
                                                                @endphp
                                                            @endforeach
                                                            <td class="text-success">
                                                                <div class="form-goup">
                                                                    <select class="form-control" id="{{ $data->id }}_marks"  name="rows[{{ $data->id }}][marks]" data-dependent="id">
                                                                        <option value="N/A">Select Result</option>
                                                                        <option value="C"
                                                                         @if($score == "C")
                                                                            selected
                                                                        @endif
                                                                        >C</option>
                                                                        <option value="NC"
                                                                        @if($score == "NC")
                                                                            selected
                                                                        @endif
                                                                        >NC</option>
                                                                    </select>
                                                                    <!-- <input type="text" class="form-control  form-control-sm text-center" id="{{ $data->id }}_marks"  name="rows[{{ $data->id }}][marks]" value="{{$score}}" data-parsley-type="number"> -->
                                                                </div>
                                                            </td>
                                                            @foreach($requiredSubject as $subject)
                                                                <input type="text" name="subject" value="{{ $subject->id }}" hidden>
                                                            @endforeach                                                                                                                                                                     
                                                        </tr>
                                                    @endif
                                                @endif
                                            @endif                                                   
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                                <div class="text-center my-3">
                                    <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Save Result') }} (Total <span
                                    class="totalchecked">0</span>)</button>
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