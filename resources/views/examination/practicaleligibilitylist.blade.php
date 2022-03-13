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
                            @if(isset($requestedfund))
                                @foreach($requestedfund as $requefund)
                                <h3 class="mb-0">{{ $requefund->fund_name }}</h3>
                                @endforeach
                             @else
                             <h3 class="mb-10">{{ __('Practical  Exam Eligibility') }}</h3>   
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
                        <form method="post" action="{{ route('practical.eligible.list.trainee.exam') }}" autocomplete="off">
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
                                        @if ($errors->has('fund'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fund') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                    <div class="mr-3 ml-3 mt-4">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="datatable-custom">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Name') }}</th>
                                        <th scope="col">{{ __('NIC') }}</th>
                                        <th scope="col">{{ __('Phone Number') }}</th>
                                        <th scope="col">{{ __('Address') }}</th>
                                        <th scope="col">{{ __('Courses') }}</th>
                                        <th scope="col">{{ __('Batch') }}</th>
                                        <th scope="col">{{ __('Written Exam Result') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @isset($trainees)
                                    @foreach ($trainees as $data)
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
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">                                                         
                                                    @foreach($subjects as $subject)
                                                        @php                                                              
                                                            $score = App\Mark::traineeSubjectsMarks($data->id, $subject->id);
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
                                        </tr>                                                   
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
                        'Practical Exam Eligibility List :: {{$reCourseName}} {{$reBatchName->year}} /{{$reBatchName->batch_no}} Batch'
                    @else
                        'Practical Exam Eligibility List'
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