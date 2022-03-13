@extends('layouts.app', ['title' => __('Course Duration Management')])

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
                            <h3 class="mb-0">
                                {{ __('Course Duration') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('courseduration.create') }}" class="btn btn-sm btn-warning">{{ __('Setup
                                New
                                Course Duration')
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
                                <th scope="col">{{ __('Bacth Code') }}</th>
                                <th scope="col">{{ __('Start Date') }}</th>
                                <th scope="col">{{ __('End Date') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseDurations as $courseDuration)
                            <tr>
                                <td>
                                    {{ $courseDuration->course->course_name }}
                                </td>
                                <td>{{ $courseDuration->batch->year . ' / ' . $courseDuration->batch->batch_no}}</td>
                                <td>
                                    {{ $courseDuration->start_date }}
                                </td>
                                <td>
                                    {{ $courseDuration->end_date}}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('courseduration.destroy', $courseDuration) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="dropdown-item"
                                                    href="{{ route('courseduration.edit', $courseDuration) }}">{{
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