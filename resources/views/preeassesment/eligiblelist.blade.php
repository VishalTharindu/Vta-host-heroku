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
                             <h3 class="mb-10">{{ __('View Pre Assesstment Eligibility') }}</h3>   
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
                        <form method="post" action="{{ route('preassesment.trainee.eligible.list') }}" autocomplete="off">
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
                                            <th scope="col">{{ __('Precentage') }}</th>
                                            <th scope="col">{{ __('Eligibility') }}</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <input type="text" name="course" value="{{$requiredCourse}}" hidden>
                                    <input type="text" name="batch" value="{{$requiredBatch}}" hidden>
                                    <tbody>
                                    @isset($trainees)
                                        @foreach ($trainees as $data)
                                            @php
                                            $precentage = App\Attendance::calculateAttendanceEligibility($data->id);

                                            $status = App\PreAssesmentRsult::traineeFirsttimeEligibility($data->id);

                                            @endphp

                                            @if($precentage >= 80)
                                                
                                                @if($status == 1)
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
                                                    <td class="text-success">{{$precentage}}%</td>
                                                    <td class="text-success">Eligible</td>                                                                                                                                                                                                         
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
@include('layouts.footers.auth')
</div>
@endsection