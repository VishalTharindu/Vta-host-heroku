@extends('layouts.app', ['title' => __('Scholarship Management')])

@section('content')
@include('users.partials.header', ['title' => __('Document Upload')])

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
                            <h3 class="mb-0">{{ __('Scholarship Document Upload') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('trainee.edituploaddocument', ['id' => $trainee->id]) }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">{{ __('Scholarship Document') }}</h6>
                        <div class="pl-lg-4">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('forumA') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Form A') }}</label>
                                            <input type="file" name="forumA" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('forumA') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Form A') }}"
                                            value="{{ old('forumA') }}"  autofocus>

                                        @if ($errors->has('forumA'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('forumA') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="form-group{{ $errors->has('forumB') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-nameWithInitials">{{
                                            __('Form B') }}</label>
                                        <input type="file" name="forumB" id="name_with_initials"
                                            class="form-control form-control-alternative{{ $errors->has('forumB') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('Form B') }}"
                                            value="{{ old('forumB') }}"  autofocus>

                                        @if ($errors->has('forumB'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('forumB') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 container1">
                                    <div class="form-group{{ $errors->has('other_document') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-criteria">{{ __('Other Document')
                                            }}</label>
                                        <div class="input-group control-group increment">
                                            <input type="file" name="other_document[]"
                                                class="form-control form-control-alternative{{ $errors->has('otherdocument') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Enter Criteria') }}"
                                                value="{{ old('otherdocument') }}" autofocus>
                                            <div class="input-group-btn">
                                                <div class="my-2"></div>
                                                <button class="btn btn-sm btn-success add_form_field" type="button"><i
                                                        class="glyphicon glyphicon-plus"></i>More</button>
                                            </div>
                                        </div>

                                        @if ($errors->has('otherdocument'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('otherdocument') }}</strong>
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
                    $(wrapper).append('<div class="form-group{{$errors->has('full_name') ? ' has-danger' : ''}}" id="toremove"> <label class="form-control-label" for="input-criteria">{{__('Other Criteria')}}</label> <div class="input-group control-group increment"> <input type="file" name="other_document[]" class="form-control form-control-alternative{{$errors->has('other_document') ? ' is-invalid' : ''}}" placeholder="{{__('Other Document')}}" value="{{old('other_document')}}" autofocus> <div class="input-group-btn"> <div class="my-2"></div><button class="btn btn-sm btn-danger delete" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button> </div></div>@if ($errors->has('other_document')) <span class="invalid-feedback" role="alert"> <strong>{{$errors->first('other_document')}}</strong> </span> @endif </div>'); //add input box
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
    <script>
		$(document).ready(function(){
			$('#ex1').zoom({ on:'click' });
			$('#ex2').zoom({ on:'click' });
			$('#ex3').zoom({ on:'click' });			 
			// $('#ex4').zoom({ on:'toggle' });
		});
	</script>
    @include('layouts.footers.auth')
</div>
@endsection
