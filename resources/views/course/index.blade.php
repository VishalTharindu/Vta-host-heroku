@extends('layouts.app', ['title' => __('Course Management')])

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
                            <h3 class="mb-0">{{ __('Coursees') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('course.create') }}" class="btn btn-sm btn-warning">{{ __('Add Course')
                                }}</a>
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
                                <th scope="col">{{ __('Course Name') }}</th>
                                <th scope="col">{{ __('Duration (Mon.)') }}</th>
                                <th scope="col">{{ __('NVQ Level') }}</th>
                                <th scope="col">{{ __('Reg. Fee') }}</th>
                                <th scope="col">{{ __('Course. Fee') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->course_name }}</td>
                                <td>
                                    {{ $course->course_duration }}
                                </td>
                                <td>
                                    {{ $course->nvq_level }}
                                </td>
                                <td>
                                    {{ number_format($course->registration_fee,2) }}
                                </td>
                                <td>
                                    {{ number_format($course->course_fee,2) }}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('course.destroy', $course) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="dropdown-item" href="{{ route('course.edit', $course) }}">{{
                                                    __('Edit') }}</a>
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