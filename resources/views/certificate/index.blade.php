@extends('layouts.app', ['title' => __('Trainee Certificates Management')])

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
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Certificates') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('certificate.create')}}" class="btn btn-md btn-warning" data-toggle="modal" data-target="#issueCertificate">Issue
                                Certificate</a>

                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>

                <div class="card-body">
                    <div>
                        <form method="post" action="{{ route('certificate.filter') }}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Information') }}</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-course">{{ __('Course') }}</label>
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
                                <button type="submit" class="btn btn-sm btn-success px-4 float-right">{{ __('Filter')
                                    }}</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Name With Initials') }}</th>
                                <th scope="col">{{ __('NIC') }}</th>
                                <th scope="col">{{ __('Course') }}</th>
                                <th scope="col">{{ __('Batch') }}</th>
                                <th scope="col">{{ __('Issued Date') }}</th>
                                <th scope="col">{{ __('Proof') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                            <tr>

                                <td>{{ $certificate->trainee->name_with_initials }}</td>
                                <td>{{ $certificate->trainee->nic }}</td>
                                <td>{{ $certificate->trainee->course->course_name }}</td>
                                <td>{{ $certificate->trainee->batch->year }} -
                                    {{$certificate->trainee->batch->batch_no}}</td>
                                <td>{{$certificate->issued_date}}</td>
                                <td><a href="{{asset('storage/certificates/'.$certificate->certificate_photo)}}"
                                        target="_blank">View</a>
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('certificate.destroy', $certificate) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="dropdown-item" onclick="confirmDelete()">
                                                    {{ __('Delete') }}
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
    </div>
</div>
<!---------------------------------------- Modal to upload the certificate ---------------------------------------->
<div class="modal fade" id="issueCertificate" tabindex="-1" role="dialog" aria-labelledby="issueCertificate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="certificateForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Issue Certificate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Trainee Enrollment No</label>
                        <input type="text" name="enrolledno" class="form-control" id="enrolledno" aria-describedby="emailHelp"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Issued Date</label>
                        <input class="form-control datepicker" id="datepicker1" name="issued_date"
                                            placeholder="Select date" value="" type="text"
                                            data-date-format="yyyy-mm-dd">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Certificate Photo</label>
                        <input type="file" name="certificate" class="form-control" id="certificate" aria-describedby="emailHelp"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="issueCertificate()">Issue Certificate
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
var base_url = '{!!URL::route('index')!!}'

function issueCertificate() {
    $('#issueCertificate').modal('hide');
}

//Populating data for the modal form
$('#issueCertificate').on('show.bs.modal', function(event) {
    var form = document.getElementById('certificateForm')
    form.action = base_url + '/certificate'
})
</script>
<script>
$(document).ready(function() {

    $('#filter-courses').select2();
    $('#filter-batches').select2();

});
</script>
<script>
function confirmDelete() {
    event.preventDefault();
    var form = event.target.form;
    $.confirm({
        title: 'Delete!',
        content: 'Are you sure you want to delete this?',
        animation: 'zoom',
        closeAnimation: 'scale',
        icon: 'fa fa-trash-alt',
        theme: 'material',
        closeIcon: true,
        type: 'red',
        animateFromElement: false,
        buttons: {
            confirm: function() {
                $.alert('Deleted');
                form.submit();
            },
            cancel: function() {
                $.alert('Canceled');
            }
        }
    });
}
</script>
@include('layouts.footers.auth')
</div>
@endsection