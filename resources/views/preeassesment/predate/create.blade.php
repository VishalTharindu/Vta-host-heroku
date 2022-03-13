
@extends('layouts.app', ['title' => __('Examination Management')])

@section('content')
@include('layouts.headers.cards')
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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
                             <h3 class="mb-10">{{ __('Pre Assessment Details') }}</h3>   
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
                        <form method="post" action="{{ route('preassesment.store') }}"  autocomplete="off">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="report_date">{{ __('Date') }}</label>
                                        <input class="form-control datepicker" id="datepicker1" name="asses_date"
                                            placeholder="Select date" value="" type="text"
                                            data-date-format="yyyy-mm-dd" require>
                                        @if ($errors->has('report_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('report_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="my-4"></div>
                                        <div class="form-group d-flex justify-content-center">                                              
                                            <button type="submit"  class="btn btn-success">{{ __('Add') }}</button>                                                                                            
                                        </div>
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
</div>
<script>
    $(document).ready(function() {
        $('#input-batches').select2();
        $('#input-courses').select2();
        $('#input-years').select2();
        $('#input-months').select2();
    });
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datepicker1').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            startDate: today,
            endDate: end,
            minDate: today,
            autoclose: true
        });
        $('#datepicker1').datepicker('setDate', today);
    });
</script>
@include('layouts.footers.auth')
</div>
@endsection