@extends('layouts.app', ['title' => __('Instructor Management')])

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
                            <h3 class="mb-0">{{ __('Instructor') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('instructor.create') }}"
                                class="btn btn-sm btn-warning">{{ __('Add Instructor') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    @include('partials.status')
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="datatable-basic">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('First Name') }}</th>
                                <th scope="col">{{ __('Last Name') }}</th>
                                <th scope="col">{{ __('NIC') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Phone Number') }}</th>
                                <th scope="col">{{ __('Course') }}</th>
                                <th scope="col">{{ __('City') }}</th>
                                <th scope="col">{{ __('Address') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instructors as $instructor)
                            <tr>
                                <td>{{ $instructor->first_name }}</td>
                                <td>
                                    {{ $instructor->last_name }}
                                </td>
                                <td>
                                    {{ $instructor->nic }}
                                </td>
                                <td>
                                    {{$instructor->email }}
                                </td>
                                <td>
                                    {{$instructor->phone_number }}
                                </td>
                                <td>
                                    {{$instructor->course->course_name}}
                                </td>
                                <td>
                                    {{$instructor->city }}
                                </td>
                                <td>
                                    {{$instructor->address }}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('instructor.destroy', $instructor) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="dropdown-item"
                                                    href="{{ route('instructor.edit', $instructor) }}">{{ __('Edit') }}</a>
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