@extends('layouts.app', ['title' => __('Trainee Management')])

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
                            <h3 class="mb-0">{{ __('Trainees') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            @role('admin|mr')
                            <a href="{{ route('trainee.create') }}"
                                class="btn btn-sm btn-warning">{{ __('Add New Trainee') }}</a>
                            @endrole
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>

                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('trainee.filterData') }}" autocomplete="off">
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
                    <p>Male: <strong>{{ $maleCount }}</strong> | Female:<strong>{{ $femaleCount }}</strong></p>
                </div>


                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">{{ __('Enrollment No') }}</th>
                                <th scope="col">{{ __('Name With Initials') }}</th>
                                <th scope="col">{{ __('Full Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Phone Number') }}</th>
                                <th scope="col">{{ __('Course') }}</th>
                                <th scope="col">{{ __('batch') }}</th>
                                <th scope="col">{{ __('Gender') }}</th>
                                <th scope="col">{{ __('ethnicity') }}</th>
                                <th scope="col">{{ __('NIC') }}</th>
                                <th scope="col">{{ __('address') }}</th>
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
                                <td>{{ $trainee->full_name }}</td>
                                <td>{{ $trainee->email }}</td>
                                <td>{{ $trainee->phone_number }}</td>
                                <td>{{ $trainee->course->course_name }}</td>
                                <td>{{ $trainee->batch->year . ' / ' . $trainee->batch->batch_no}}</td>
                                <td>{{ $trainee->gender }}</td>
                                <td>{{ $trainee->ethnicity }}</td>
                                <td>{{ $trainee->nic }}</td>
                                <td>{{ $trainee->address }}</td>
                                @if((($trainee->forumA ) === '0') and (($trainee->forumB) === '0') and
                                (($trainee->other_documents) === '0'))
                                <td><a href="upload/scholarship/document/{{$trainee->id}}"
                                        class="btn-sm btn-primary">Document</a></td>
                                @else
                                <td><a href="{{ route('trainee.edituploadview', ['id' => $trainee->id]) }}"
                                        class="btn-sm btn-success">Update_Document</a></td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

        $('#filter-courses').select2();
        $('#filter-batches').select2();

    });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection