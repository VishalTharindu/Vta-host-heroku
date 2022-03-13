@extends('layouts.app', ['title' => __('Scholarship Management')])

@section('content')
@include('users.partials.header', ['title' => __('Re_Assign Scholarship')])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Re_Assign Scholarship') }}</h3>
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">                  
                    <form method="get" action="{{ route('trainee.reassignefund', ['id' => $trainee->id]) }}"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __('trainee Information') }}</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('name_with_initials') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-nameWithInitials">{{ __('Name With Initials') }}</label>
                                        <input type="text" name="name_with_initials" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('name_with_initials') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Name With Initials') }}"
                                            value="{{ $trainee->name_with_initials }}" required autofocus disabled>

                                        @if ($errors->has('name_with_initials'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_with_initials') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('NIC Number') }}</label>
                                    <input type="text"
                                        class="form-control form-control-alternative{{ $errors->has('nic') ? ' is-invalid' : '' }}"
                                        name="nic" value="{{ $trainee->nic }}" disabled>
                                    @if ($errors->has('nic'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nic') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Email') }}</label>
                                    <input type="email"
                                        class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ $trainee->email }}" disabled>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group  col-md-6">
                                    <label class="form-control-label">{{ __('Gender') }}</label>
                                    <select
                                        class="list-gender form-control form-control-alternative{{ $errors->has('gender') ? ' is-invalid' : '' }}"
                                        name="gender" id="list-gender" value="{{ old('gender') }}" required disabled>

                                        <option value=""></option>
                                        <option value="male" @if($trainee->gender == "male")
                                            selected
                                            @endif
                                            >Male</option>
                                        <option value="female" @if($trainee->gender == "female")
                                            selected
                                            @endif
                                            >Female</option>

                                    </select>
                                    @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-phoneNumber">{{ __('Phone Number') }}</label>
                                        <input type="tel" name="phone_number" id="phone_number" pattern="[0-9]{10}"
                                            class="form-control form-control-alternative{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Enter Phone Number') }}"
                                            value="{{ $trainee->phone_number }}" required autofocus disabled>

                                        @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                        <input type="text" name="city" id="city"
                                            class="form-control form-control-alternative{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Badulla') }}" value="{{ $trainee->city }}" required
                                            autofocus disabled>

                                        @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                <input type="text" name="address" id="address"
                                    class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('40/3,Passara Road,Badulla') }}"
                                    value="{{ $trainee->address }}" required autofocus disabled>

                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('qualification') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-fullName">{{ __('Qualification') }}</label>
                                        <input type="text" name="qualification" id="qualification"
                                            class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('A/L') }}" value="{{ $trainee->qualification }}" required
                                            autofocus disabled>

                                        @if ($errors->has('qualification'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('qualification') }}</strong>
                                        </span>
                                        @endif
                                    </div>                               
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('qualification') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-fullName">{{ __('Cours') }}</label>
                                        <input type="text" name="qualification" id="qualification"
                                            class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('A/L') }}" value="{{ $trainee->course->course_name }}" required
                                            autofocus disabled>

                                        @if ($errors->has('qualification'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('qualification') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-6">                                  
                                    <div class="form-group{{ $errors->has('qualification') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-fullName">{{ __('Batch') }}</label>
                                        <input type="text" name="qualification" id="qualification"
                                            class="form-control form-control-alternative{{ $errors->has('qualification') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('A/L') }}" value="{{ $trainee->batch->year . ' / ' . $trainee->batch->batch_no}}" required
                                            autofocus disabled>

                                        @if ($errors->has('qualification'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('qualification') }}</strong>
                                        </span>
                                        @endif
                                    </div>                                   
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('funds') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-course">{{ __('Allocate Scholarship') }}<span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="list-courses form-control fund-select form-control-alternative{{ $errors->has('course') ? ' is-invalid' : '' }}"
                                            name="funds[]" id="input-courses" value="{{ old('course') }}"
                                            multiple="multiple" data-toggle="select" required autofocus>

                                            @foreach($funds as $fund)
                                            <option value="{{ $fund->id }}" @if($trainee->
                                                hasFunds($fund->id))
                                                selected
                                                @endif>
                                                {{ $fund->fund_name }}</option>
                                            @endforeach

                                            <script>
                                                $(".fund-select").select2({
                                                    maximumSelectionLength: 10
                                                });
                                            </script>   

                                        </select>
                                        @if ($errors->has('funds'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('funds') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm-4 col-4 d-flex justify-content-center">
                                        <small class="d-block text-uppercase font-weight-bold mb-4 d-flex justify-content-center">Forum A</small>
                                    </div>
                                    <div class="col-sm-4 col-4 d-flex justify-content-center">
                                        <small class="d-block text-uppercase font-weight-bold mb-4 d-flex justify-content-center">Forum B</small>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm-4 col-4 d-flex justify-content-center">                                  
                                        <div class="my3"></div>
                                        <div class ="d-flex justify-content-center">
                                            <span class="zoom" id="ex1">
                                                <img src="{{ asset('storage/ForumA/'.$trainee->forumA) }}" alt="Rounded image" class="img-fluid rounded shadow-lg p-3 mb-5 bg-secondry rounded" style="width: 100%;">
                                            </span>                                  
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-4 d-flex justify-content-center">                              
                                        <div class ="d-flex justify-content-center">
                                            <span class="zoom" id="ex2">
                                                <img src="{{ asset('storage/forumB/'.$trainee->forumB) }}" alt="Rounded image" class="img-fluid rounded shadow-lg p-3 mb-5 bg-secondry rounded" style="width: 100%;">
                                            </span>                                  
                                        </div>
                                    </div>                                                                    
                                </div>
                                <div class="row d-flex justify-content-center">
                                @foreach (json_decode($trainee->other_documents) as $image)
                                    <div class="col-sm-4 col-4 d-flex justify-content-center">                                  
                                        <div class="my3"></div>
                                        <div class ="d-flex justify-content-center">
                                            <span class="zoom" id="ex3">
                                                <img src="{{ asset('storage/'.$image) }}" alt="Rounded image" class="img-fluid rounded shadow-lg p-3 mb-5 bg-secondry rounded" style="width: 100%;">
                                            </span>                                  
                                        </div>
                                    </div>                                                                    
                                @endforeach
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4 px-4">{{ __('Select') }}</button>
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
        $('#list-gender').select2();
        $('#list-ethnicity').select2();
        $('.list-course-selected').select2();
        $('.list-courses').select2({
            minimumResultsForSearch: 1,
            maximumSelectionLength: 2
        });
    });

    function confirmUnselect() {
        event.preventDefault();
        var form = event.target.form;
        $.confirm({
            title: 'Unselect!',
            content: 'Are you sure you want to Unselect the trainee?',
            animation: 'zoom',
            closeAnimation: 'scale',
            icon: 'fa fa-trash-alt',
            theme: 'material',
            closeIcon: true,
            type: 'red',
            animateFromElement: false,
            buttons: {
                confirm: function() {
                    form.submit();
                },
                cancel: function() {
                    $.alert('Canceled');
                }
            }
        });
    }
    </script>
    <script>
        $(document).ready(function(){
			$('#ex1').zoom({ on:'click' });
			$('#ex2').zoom({ on:'click' });
			$('#ex3').zoom({ on:'click' });			 
			// $('#ex4').zoom({ on:'toggle' });
		});
    </script>
    <!-- <script>
        $(function () {
            var viewer = ImageViewer();
            $('.gallery-items').click(function () {
                var imgSrc = this.src,
                    highResolutionImage = $(this).data('high-res-img');
        
                viewer.show(imgSrc, highResolutionImage);
            });
        });
    </script> -->
    @include('layouts.footers.auth')
</div>
@endsection