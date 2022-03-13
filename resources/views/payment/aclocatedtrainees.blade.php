@extends('layouts.app', ['title' => __('Scholarship Management')])

@section('content')
@include('layouts.headers.cards')
<link href="{{ asset('argon') }}/vendor/imgzoom/zoom.min.css" rel="stylesheet">
<div class="my-5"></div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <h3 class="mb-0">{{ __('Scholarship Receivers') }}</h3>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <h4 class="mb-0">Total Count : {{$recount}}</h4>
                        </div>                      
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')

                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-buttons">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Phone Number') }}</th>
                                <th scope="col">{{ __('Address') }}</th>
                                <th scope="col">{{ __('Course') }}</th>
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Scholarship') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainees as $trainee)
                            <tr>
                                <td>{{ $trainee->name_with_initials }}</td>
                                <td>
                                    {{ $trainee->phone_number }}
                                </td>
                                <td>{{ $trainee->address }}</td>
                                <td>{{ $trainee->course->course_name }}
                                </td>
                                <td>{{ $trainee->batch->year . ' / ' . $trainee->batch->batch_no}}</td>
                                <!-- <td @if($trainee->active == 1)
                                        class="text-success font-weight-bold"
                                    @elseif(($trainee->active == 0))
                                        class="text-danger font-weight-bold"
                                    @endif>{{ ($trainee->active == 1) ? 'Yes' : 'No' }}</td> -->
                                <!-- <td>{{ ($trainee->status == 1) ? 'Selected' : 'Not Selected' }}</td> -->
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            @foreach ($trainee->funds as $item)
                                            <p class="dropdown-item">{{$item->fund_name}}</p>
                                            @endforeach
                                        </div>

                                    </div>
                                </td>                               
                                <td><a href="{{ route('trainee.reassignefundtotrainees', ['id' => $trainee->id]) }}" class="btn-sm btn-primary">Re_assigne</a></td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="/trainee/removefundtrainee/{{$trainee->id}}" method="get">
                                                @csrf                                                                                 
                                                <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                    {{ __('Remove') }}
                                                </button>
                                            </form>
                                        </div>                                     
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-------------------------------- Modal -------------------------------------------------------->
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
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="labe form-control-label">Allocate Scholarship</div>
                                    <select name="funds[]" class="form-control course-select" multiple="multiple">
                                        @foreach ($funds as $fund)
                                        <option value="{{ $fund->id }}">
                                            {{ $fund->fund_name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        $(".course-select").select2({
                                            maximumSelectionLength: 10
                                        });
                                    </script>
                                    @if ($errors->has('fund_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('payments') }}</strong>
                                    </span>
                                    @endif
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
    <script>
        $(document).ready(function() {

            $('.list-courses').select2();

        });

        //Populating data for the modal form
        $('#selectModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)

            //Getting the values when the button click
            var id = button.data('id')
            var in_name = button.data('inname')
            var fullname = button.data('fullname')
            var contact = button.data('contact')
            var address = button.data('address')
            var qualification = button.data('qualification')
            var reqcourses = button.data('reqcourses')
            var batch = button.data('batch')
            var scholarship = button.data('scholarship')
            var modal = $(this)

            //Assign the alues for the form
            modal.find('.in_name').val(in_name)
            modal.find('.fullname').val(fullname)
            modal.find('.contact').val(contact)
            modal.find('.address').val(address)
            modal.find('.qualification').val(qualification)
            modal.find('.reqcourses').val(reqcourses)
            modal.find('.batch').val(batch)
            modal.find('.scholarship').val(scholarship)

            $('.list-courses').val(null).trigger('change');
            //Perform the form action
            var form = document.getElementById('selectForm')
            form.action = '/trainee/reassignefund/' + id
        })

        function confirmDelete() {
            event.preventDefault();
            var form = event.target.form;
            $.confirm({
                title: 'Remove!',
                content: 'Are you sure you want to remove this?',
                animation: 'zoom',
                closeAnimation: 'scale',
                icon: 'fa fa-trash-alt',
                theme: 'material',
                closeIcon: true,
                type: 'red',
                animateFromElement: false,
                buttons: {
                    confirm: function() {
                        $.alert('Removed');
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
        $(document).ready(function() {
            $('#ex1').zoom();
            $('#ex2').zoom({
                on: 'grab'
            });
            $('#ex3').zoom({
                on: 'click'
            });
            // $('#ex4').zoom({ on:'toggle' });
        });
    </script>
    @include('layouts.footers.auth')
</div>
@endsection