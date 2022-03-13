@extends('layouts.app', ['title' => __('Dropout Management')])

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
                                {{ __('Dropout Warning List') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <a href="{{ route('subject.create') }}" class="btn btn-sm btn-warning"></a> -->
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
                                <th scope="col"></th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('NIC') }}</th>
                                <th scope="col">{{ __('Enrollment No') }}</th>
                                <th scope="col">{{ __('No Absent Days') }}</th>
                                <th scope="col">{{ __('Warning Letter') }}</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dropoutList as $record)
                            <tr>
                                <td>
                                    @if($record->trainee->image)
                                    <span class="avatar rounded-circle">
                                        <img src="{{asset('storage/'.$record->trainee->image)}}" width="50px"
                                            height="50px" alt="" class="rounded-circle">
                                    </span>
                                    @else
                                    <span class="avatar rounded-circle">
                                        <img src="{{asset('images/no_image.png')}}" alt="">
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $record->trainee->name_with_initials }}
                                </td>
                                <td>
                                    {{ $record->trainee->nic }}
                                </td>
                                <td>
                                    {{ $record->trainee->enrollment_no }}
                                </td>
                                <td>
                                    {{ $record->no_of_absents }}
                                </td>
                                <td>
                                    @if ($record->letter_issued == 0)
                                    <a href="{{route('dropout.letter', $record->trainee->id)}}" class="btn btn-sm btn-success">Generate
                                        Letter</a>
                                    @else
                                    <a href="{{route('dropout.letter', $record->trainee->id)}}" class="btn btn-sm btn-dark">Generate
                                        Again</a>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('dropout.destroy', $record) }}" method="post">
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