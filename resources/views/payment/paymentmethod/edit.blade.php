@extends('layouts.app', ['title' => __('Scholarship Management')])

@section('content')
@include('users.partials.header', ['title' => __('New Scholarship')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                <div class="col-12">
                    @include('partials.status')
                </div>
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Scholarship Management') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('funds.index') }}" class="btn btn-sm btn-warning">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('funds.update', $fund) }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('Scholarship Information') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('fund_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Scholarship Name') }}</label>
                                        <input type="text" name="fund_name" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('fund_name') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Scholarship Name') }}"
                                            value="{{ $fund->fund_name}}"  autofocus>

                                        @if ($errors->has('fund_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fund_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group{{ $errors->has('full_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label text-center" for="input-samurdi">{{
                                            __('Samurdi') }}</label>
                                        <div class="my-2"></div>
                                        <div class="custom-control">
                                            <label class="custom-toggle">
                                                <input type="checkbox" name="samurdi" 
                                                @if(($fund->samurdi) == 1) 
                                                    checked
                                                @endif>
                                                <span class="custom-toggle-slider rounded-circle"></span>
                                            </label>
                                        </div>
                                        @if ($errors->has('samurdi'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('samurdi') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group{{ $errors->has('Attendance') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-attendance">{{ __('80% Attendance')
                                            }}</label>
                                        <div class="my-2"></div>
                                        <div class="custom-control">
                                            <label class="custom-toggle">
                                                <input type="checkbox" name="attendance"
                                                @if(($fund->attendance) == 1) 
                                                    checked
                                                @endif>                                               
                                                <span class="custom-toggle-slider rounded-circle"></span>
                                            </label>
                                        </div>
                                        @if ($errors->has('full_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('full_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 container1">
                                    <div class="form-group{{ $errors->has('full_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-criteria">{{ __('Other Criteria')
                                            }}</label>
                                            @foreach (json_decode($fund->othercriteria) as $criteria)
                                                <p>{{$criteria}}</p>
                                            @endforeach
                                        <div class="input-group control-group increment">
                                            <input type="text" name="criteria[]"
                                                class="form-control form-control-alternative{{ $errors->has('criteria') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Enter Criteria') }}"
                                                value="{{ old('criteria') }}" autofocus>
                                            <div class="input-group-btn">
                                                <div class="my-2"></div>
                                                <button class="btn btn-sm btn-success add_form_field" type="button"><i
                                                        class="glyphicon glyphicon-plus"></i>More</button>
                                            </div>
                                        </div>

                                        @if ($errors->has('criteria'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('criteria') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Amount') }}</label>
                                        <input type="text" name="amount" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Amount') }}"
                                            value="{{ $fund->amount}}"  autofocus>

                                        @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('full_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-discription">{{ __('Discription')
                                            }}</label>
                                        <textarea name="discription" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Fund Name') }}"
                                            value="" required autofocus> {{$fund->discription}} </textarea>
                                        @if ($errors->has('full_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('full_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('.list-batches').select2();
            $('.list-courses').select2({
                minimumResultsForSearch: 1,
                maximumSelectionLength: 2
            });

        });
    </script>


    <script type='text/javascript'>
        $(document).ready(function() {
            var max_fields = 100;
            var wrapper = $(".container1");
            var add_button = $(".add_form_field");

            var x = 1;

            $(document).on('click', ".add_form_field", function(e) {
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $(wrapper).append('<div class="form-group{{$errors->has('criteria') ? ' has-danger' : ''}}" id="toremove"> <label class="form-control-label" for="input-criteria">{{__('Other Criteria')}}</label> <div class="input-group control-group increment"> <input type="text" name="criteria[]" class="form-control form-control-alternative{{$errors->has('criteria') ? ' is-invalid' : ''}}" placeholder="{{__('Enter Criteria')}}" value="{{old('criteria')}}" autofocus> <div class="input-group-btn"> <div class="my-2"></div><button class="btn btn-sm btn-danger delete" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button> </div></div>@if ($errors->has('criteria')) <span class="invalid-feedback" role="alert"> <strong>{{$errors->first('criteria')}}</strong> </span> @endif </div>'); //add input box
                } else {
                    alert('You Reached the limits')
                }
            });

            $(wrapper).on("click", ".delete", function(e) {
                e.preventDefault();
                $(this).closest('#toremove').remove();
                x--;
            })
        });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection
